<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Models\UkuranPesanan;
use App\Services\PesananService;
use App\Support\AlurOrder;
use Illuminate\Support\Facades\Auth;
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
        $query = $this->queryOrder()->orderByDesc('o.no');

        if ($request->filled('status_order')) {
            $query->where('o.status_order', $request->query('status_order'));
        }

        if ($request->filled('tahap')) {
            $query->where('o.tahap_saat_ini', $request->query('tahap'));
        }

        if ($request->filled('q')) {
            $q = '%' . $request->query('q') . '%';
            $query->where(function ($w) use ($q) {
                $w->where('o.kode_order', 'like', $q)
                  ->orWhere('o.customer', 'like', $q)
                  ->orWhere('o.instansi', 'like', $q);
            });
        }

        $data = $query->get()->map(function ($row) {
            $row->alur = AlurOrder::tahap($row);
            $row->alur_label = AlurOrder::LABEL[$row->alur];

            return $row;
        });

        return response()->json([
            'message' => 'Data pesanan berhasil diambil',
            'data' => $data,
        ]);
    }

    /** v_order + status Work Order, dipakai index/show/dashboard. */
    public static function queryOrder()
    {
        return DB::table('v_order as o')
            ->leftJoin('work_order as w', 'w.pesanan_id', '=', 'o.no')
            ->select('o.*', 'w.id as work_order_id', 'w.status_wo');
    }

    /** Detail lengkap satu order (untuk halaman detail & cetak). */
    public function show(Pesanan $pesanan)
    {
        $pesanan->load([
            'pelanggan', 'spesifikasi', 'ukuranPesanan',
            'invoice', 'pembayaran', 'workOrder',
        ]);

        $data = $pesanan->toArray();
        $ringkasan = $this->queryOrder()->where('o.no', $pesanan->id)->first();

        $data['ringkasan'] = $ringkasan;
        $data['alur'] = AlurOrder::tahap($ringkasan);
        $data['alur_label'] = AlurOrder::LABEL[$data['alur']];
        $data['ringkasan_pembayaran'] = DB::table('v_pembayaran_order')
            ->where('pesanan_id', $pesanan->id)->first();
        $data['riwayat_tahap'] = DB::table('riwayat_tahap as r')
            ->leftJoin('pengguna as p', 'p.id', '=', 'r.diubah_oleh')
            ->where('r.pesanan_id', $pesanan->id)
            ->orderBy('r.id')
            ->get(['r.*', 'p.nama as diubah_oleh_nama']);

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

    /**
     * CS menyerahkan barang ke pelanggan: Packing -> Selesai.
     * Syarat (aplikasi): order sudah lunas. Syarat QC lolos dijaga trigger DB.
     */
    public function serahTerima(Request $request, Pesanan $pesanan)
    {
        $validated = $request->validate(['catatan' => ['nullable', 'string', 'max:255']]);

        $row = $this->queryOrder()->where('o.no', $pesanan->id)->first();

        if ($pesanan->tahap_saat_ini !== 'Packing') {
            return response()->json([
                'message' => 'Serah terima hanya bisa dilakukan saat order berada di tahap Packing.',
            ], 422);
        }

        if ((float) $row->kekurangan > 0) {
            return response()->json([
                'message' => 'Pelunasan harus selesai sebelum serah terima.',
            ], 422);
        }

        DB::statement('CALL ubah_tahap_produksi(?, ?, ?, ?)', [
            $pesanan->id,
            'Selesai',
            $validated['catatan'] ?? 'Serah terima ke pelanggan',
            Auth::id(),
        ]);

        return response()->json([
            'message' => 'Order selesai: barang telah diserahkan ke pelanggan',
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
