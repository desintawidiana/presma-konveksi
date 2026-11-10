<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Models\UkuranPesanan;
use App\Services\PesananService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PesananController extends Controller
{
    public function __construct(private PesananService $service)
    {
    }

    /**
     * Daftar order untuk tabel dashboard. Memakai view `v_order` yang sudah
     * menghitung jumlah, total tagihan, DP, kekurangan, status pembayaran,
     * dan tahap produksi.
     *
     * Filter opsional: ?status_order=BARU  ?tahap=Cutting  ?q=kata
     */
    public function index(Request $request)
    {
        $query = DB::table('v_order')->orderByDesc('no');

        if ($request->filled('status_order')) {
            $query->where('status_order', $request->query('status_order'));
        }

        if ($request->filled('tahap')) {
            $query->where('tahap_saat_ini', $request->query('tahap'));
        }

        if ($request->filled('q')) {
            $q = '%' . $request->query('q') . '%';
            $query->where(function ($w) use ($q) {
                $w->where('kode_order', 'like', $q)
                  ->orWhere('customer', 'like', $q)
                  ->orWhere('instansi', 'like', $q);
            });
        }

        return response()->json([
            'message' => 'Data pesanan berhasil diambil',
            'data' => $query->get(),
        ]);
    }

    /** Detail lengkap satu order (untuk halaman detail & cetak). */
    public function show(Pesanan $pesanan)
    {
        $pesanan->load([
            'pelanggan', 'spesifikasi', 'ukuranPesanan',
            'invoice', 'pembayaran', 'workOrder',
        ]);

        $data = $pesanan->toArray();
        $data['ringkasan_pembayaran'] = DB::table('v_pembayaran_order')
            ->where('pesanan_id', $pesanan->id)->first();
        $data['riwayat_tahap'] = DB::table('riwayat_tahap')
            ->where('pesanan_id', $pesanan->id)->orderBy('id')->get();

        return response()->json([
            'message' => 'Detail pesanan berhasil diambil',
            'data' => $data,
        ]);
    }

    /** CS membuat order manual (misal pelanggan memesan lewat WhatsApp). */
    public function store(Request $request)
    {
        $validated = $request->validate(array_merge([
            'pelanggan_id' => ['required', 'integer', Rule::exists('pelanggan', 'id')],
        ], PesananService::aturanIsiPesanan()));

        $pesanan = $this->service->buat(
            Pelanggan::findOrFail($validated['pelanggan_id']),
            $validated,
            'CS'
        );

        return response()->json([
            'message' => 'Pesanan berhasil dibuat',
            'data' => $pesanan,
        ], 201);
    }

    /**
     * Ubah data order. Harga & rincian ukuran otomatis DIKUNCI oleh database
     * setelah invoice dibuat (pesan penolakan dari trigger diteruskan sebagai 422).
     * Perubahan tercatat ke riwayat_perubahan oleh trigger.
     */
    public function update(Request $request, Pesanan $pesanan)
    {
        $aturan = PesananService::aturanIsiPesanan();

        $validated = $request->validate([
            'jenis_produk' => ['sometimes', 'required', Rule::in(PesananService::JENIS_PRODUK)],
            'keterangan' => $aturan['keterangan'],
            'harga_satuan' => $aturan['harga_satuan'],
            'deadline' => ['nullable', 'date'],
            'catatan_internal' => ['nullable', 'string'],

            'spesifikasi' => ['sometimes', 'array'],
            'spesifikasi.model_cuttingan' => $aturan['spesifikasi.model_cuttingan'],
            'spesifikasi.lengan' => $aturan['spesifikasi.lengan'],
            'spesifikasi.status_desain' => ['sometimes', Rule::in(['SUDAH_ADA_FILE', 'DIBUATKAN_TIM'])],
            'spesifikasi.catatan_desain' => $aturan['spesifikasi.catatan_desain'],
            'spesifikasi.bahan' => $aturan['spesifikasi.bahan'],
            'spesifikasi.warna' => $aturan['spesifikasi.warna'],
            'spesifikasi.pakai_lanyard' => $aturan['spesifikasi.pakai_lanyard'],
            'spesifikasi.pakai_id_card' => $aturan['spesifikasi.pakai_id_card'],
            'spesifikasi.model_saku' => $aturan['spesifikasi.model_saku'],
            'spesifikasi.pakai_sablon' => $aturan['spesifikasi.pakai_sablon'],
            'spesifikasi.pakai_bordir' => $aturan['spesifikasi.pakai_bordir'],
            'spesifikasi.ket_bordir_sablon' => $aturan['spesifikasi.ket_bordir_sablon'],
            'spesifikasi.tambahan' => $aturan['spesifikasi.tambahan'],
            'spesifikasi.variasi_lain' => $aturan['spesifikasi.variasi_lain'],

            'ukuran' => ['sometimes', 'array', 'min:1'],
            'ukuran.*.ukuran' => $aturan['ukuran.*.ukuran'],
            'ukuran.*.jumlah' => $aturan['ukuran.*.jumlah'],
        ]);

        DB::transaction(function () use ($validated, $pesanan) {
            $pesanan->fill(collect($validated)->only([
                'jenis_produk', 'keterangan', 'harga_satuan', 'deadline', 'catatan_internal',
            ])->all())->save();

            if (!empty($validated['spesifikasi'])) {
                $pesanan->spesifikasi()->update($validated['spesifikasi']);
            }

            if (isset($validated['ukuran'])) {
                // Tabel ukuran_pesanan memakai primary key gabungan
                // (pesanan_id, ukuran), jadi diganti lewat hapus + isi ulang
                // (tidak lewat model->update()).
                UkuranPesanan::where('pesanan_id', $pesanan->id)->delete();

                foreach ($validated['ukuran'] as $item) {
                    $pesanan->ukuranPesanan()->create($item);
                }
            }
        });

        return response()->json([
            'message' => 'Pesanan berhasil diperbarui',
            'data' => $pesanan->fresh(['pelanggan', 'spesifikasi', 'ukuranPesanan']),
        ]);
    }

    /** CS memverifikasi order: BARU -> DIKONFIRMASI. */
    public function konfirmasi(Pesanan $pesanan)
    {
        if ($pesanan->status_order !== 'BARU') {
            return response()->json([
                'message' => 'Hanya order berstatus BARU yang bisa dikonfirmasi.',
            ], 422);
        }

        $pesanan->update(['status_order' => 'DIKONFIRMASI']);

        return response()->json([
            'message' => 'Pesanan berhasil dikonfirmasi',
            'data' => $pesanan->fresh(),
        ]);
    }

    /** Membatalkan order (BARU/DIKONFIRMASI -> BATAL). */
    public function batal(Request $request, Pesanan $pesanan)
    {
        $request->validate(['alasan' => ['nullable', 'string', 'max:255']]);

        if ($pesanan->status_order === 'BATAL') {
            return response()->json(['message' => 'Order sudah berstatus BATAL.'], 422);
        }

        $pesanan->status_order = 'BATAL';

        if ($request->filled('alasan')) {
            $pesanan->catatan_internal = trim(
                ($pesanan->catatan_internal ? $pesanan->catatan_internal . "\n" : '')
                . 'Dibatalkan: ' . $request->input('alasan')
            );
        }

        $pesanan->save();

        return response()->json([
            'message' => 'Pesanan berhasil dibatalkan',
            'data' => $pesanan->fresh(),
        ]);
    }
}
