document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('loginForm');
    if (!form) return;
    const identifier = document.getElementById('identifier');
    const password = document.getElementById('password');
    const toggle = document.getElementById('togglePasswordBtn');
    const icon = document.getElementById('pwdIcon');

    toggle?.addEventListener('click', () => {
        const show = password.type === 'password';
        password.type = show ? 'text' : 'password';
        icon.textContent = show ? 'visibility_off' : 'visibility';
        toggle.setAttribute('aria-label', show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
    });

    document.querySelectorAll('[data-demo-email]').forEach((button) => {
        button.addEventListener('click', () => {
            identifier.value = button.dataset.demoEmail || '';
            identifier.focus();
        });
    });

    document.getElementById('forgotPassword')?.addEventListener('click', (e) => {
        e.preventDefault();
        alert('Silakan hubungi administrator Presma Konveksi.');
    });

    // Preview saja. Jangan kirim password sampai route autentikasi backend siap.
    form.addEventListener('submit', (e) => {
        if (form.dataset.previewOnly === 'true') {
            e.preventDefault();
            alert('Ini masih pratinjau Login. Autentikasi menunggu integrasi backend.');
        }
    });
});
