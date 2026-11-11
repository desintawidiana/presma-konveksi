// Helper bersama untuk halaman CS yang terhubung ke API Laravel.
// API memakai sesi login (cookie), jadi setiap request wajib membawa token CSRF.

export const csrfToken = () =>
    document.querySelector('meta[name="csrf-token"]')?.content || '';

/** Ubah respons error Laravel (422/403/409/...) menjadi satu pesan yang mudah dibaca. */
const pesanError = (hasil, status) => {
    if (status === 404) return 'Data tidak ditemukan.';
    if (status === 403) return hasil?.message && hasil.message !== 'This action is unauthorized.'
        ? hasil.message : 'Kamu tidak memiliki akses ke fitur ini.';
    if (hasil?.errors) {
        const pertama = Object.values(hasil.errors)[0];
        if (Array.isArray(pertama) && pertama[0]) return pertama[0];
    }
    if (hasil?.message && !/^Server Error$/i.test(hasil.message)) return hasil.message;
    if (status === 419) return 'Sesi kedaluwarsa. Muat ulang halaman lalu coba lagi.';
    return 'Terjadi kesalahan pada server (kode ' + status + ').';
};

export async function api(path, { method = 'GET', body } = {}) {
    const response = await fetch('/api' + path, {
        method,
        credentials: 'same-origin',
        headers: {
            Accept: 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken(),
            ...(body !== undefined ? { 'Content-Type': 'application/json' } : {}),
        },
        body: body !== undefined ? JSON.stringify(body) : undefined,
    });

    // Sesi login habis -> kembali ke halaman login.
    if (response.status === 401) {
        window.location.assign('/login');
        throw new Error('Sesi login berakhir.');
    }

    const hasil = await response.json().catch(() => ({}));

    if (!response.ok) {
        const error = new Error(pesanError(hasil, response.status));
        error.status = response.status;
        error.errors = hasil?.errors || null;
        throw error;
    }

    return hasil;
}

export const esc = (nilai) =>
    String(nilai ?? '').replace(/[&<>"']/g, (c) =>
        ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

export const rupiah = (nilai) =>
    nilai === null || nilai === undefined || nilai === ''
        ? '—'
        : 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(Number(nilai) || 0));

export const tanggal = (nilai, denganJam = false) => {
    if (!nilai) return '—';
    const d = new Date(/^\d{4}-\d{2}-\d{2}$/.test(nilai) ? nilai + 'T12:00:00' : nilai);
    if (Number.isNaN(d.getTime())) return String(nilai);
    const opsi = { day: 'numeric', month: 'short', year: 'numeric' };
    if (denganJam) Object.assign(opsi, { hour: '2-digit', minute: '2-digit' });
    return d.toLocaleDateString('id-ID', opsi);
};

/** 0812-xxx / +62812-xxx -> 62812xxx (sama dengan aturan di database). */
export const normalisasiWa = (nomor) => {
    const d = String(nomor || '').replace(/[\s\-+().]/g, '');
    if (d.startsWith('0')) return '62' + d.slice(1);
    if (d.startsWith('8')) return '62' + d;
    return d;
};

export const waLink = (nomor, teks = '') =>
    'https://wa.me/' + normalisasiWa(nomor) + (teks ? '?text=' + encodeURIComponent(teks) : '');

/** Gaya badge untuk tiap posisi alur kerja (AlurOrder.php). */
export const GAYA_ALUR = {
    verification: 'background:#fef3c7;color:#92400e',
    payment: 'background:#fde8e8;color:#c62b2b',
    wo: 'background:#ffedd5;color:#9a3412',
    tracking: 'background:#ebf2fa;color:#2563a8',
    settlement: 'background:#fef3c7;color:#92400e',
    ready: 'background:#e8f5ee;color:#16804b',
    completed: 'background:#d1fae5;color:#065f46',
    cancelled: 'background:#e5e7eb;color:#4b5563',
};

export const badge = (teks, gaya) =>
    `<span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold" style="${gaya};white-space:nowrap">${esc(teks)}</span>`;

/** Status pembayaran dari angka v_order: lunas | dp | belum. */
export const statusBayar = (o) => {
    const total = Number(o.total_pembayaran) || 0;
    const dibayar = Number(o.total_dibayar) || 0;
    if (total > 0 && dibayar >= total) return 'lunas';
    if (Number(o.dp) > 0 || dibayar > 0) return 'dp';
    return 'belum';
};

export const LABEL_BAYAR = { lunas: 'Lunas', dp: 'DP Masuk', belum: 'Belum Bayar' };
export const GAYA_BAYAR = {
    lunas: 'background:#d1fae5;color:#065f46',
    dp: 'background:#dbeafe;color:#1e40af',
    belum: 'background:#fef3c7;color:#92400e',
};

export function toast(pesan, sukses = true) {
    document.querySelector('.cs-live-toast')?.remove();
    const node = document.createElement('div');
    node.className = 'cs-live-toast';
    node.setAttribute('role', 'status');
    node.style.cssText =
        'position:fixed;right:20px;bottom:20px;z-index:9999;max-width:360px;padding:12px 16px;border-radius:10px;' +
        'font-size:13px;font-weight:600;box-shadow:0 8px 24px rgba(0,0,0,.18);color:#fff;' +
        'background:' + (sukses ? '#16804b' : '#c62b2b');
    node.textContent = pesan;
    document.body.appendChild(node);
    window.setTimeout(() => node.remove(), 4200);
}

export const JENIS_PRODUK = [
    'Korsa', 'Vest', 'Kaos', 'Polo', 'Jaket', 'Topi', 'Celana/Rok', 'Scrub',
    'Makloon', 'Ganci', 'Lanyard', 'ID CARD', 'Jersey', 'Workshirt', 'Lainnya',
];

export const UKURAN = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL', '5XL', '6XL', 'TANPA_UKURAN'];

export const SUMBER = {
    REKOMENDASI_TEMAN: 'Rekomendasi Teman', INSTAGRAM: 'Instagram', TIKTOK: 'TikTok',
    IKLAN: 'Iklan', FACEBOOK: 'Facebook', LAINNYA: 'Lainnya',
};
