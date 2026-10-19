
document.addEventListener('DOMContentLoaded', function () {

    // =========================
    // SHOW / HIDE PASSWORD
    // =========================

    const passwordInput =
        document.getElementById('password');

    const togglePassword =
        document.getElementById('togglePasswordBtn');

    const passwordIcon =
        document.getElementById('pwdIcon');

    if (passwordInput && togglePassword) {

        togglePassword.addEventListener('click', function () {

            const isHidden =
                passwordInput.type === 'password';

            passwordInput.type =
                isHidden ? 'text' : 'password';

            if (passwordIcon) {
                passwordIcon.textContent =
                    isHidden ? 'visibility_off' : 'visibility';
            }

            togglePassword.setAttribute(
                'aria-label',
                isHidden
                    ? 'Sembunyikan kata sandi'
                    : 'Tampilkan kata sandi'
            );

        });
    }

    // =========================
    // DEMO ROLE SELECTOR
    // =========================

    const demoButtons =
        document.querySelectorAll('[data-demo-email]');

    const identifierInput =
        document.getElementById('identifier');

    demoButtons.forEach(function (button) {

        button.addEventListener('click', function () {

            if (!identifierInput) return;

            const demoEmail =
                button.getAttribute('data-demo-email');

            identifierInput.value = demoEmail || '';

            identifierInput.focus();

        });

    });

    // =========================
    // FORGOT PASSWORD
    // =========================

    const forgotPassword =
        document.getElementById('forgotPassword');

    if (forgotPassword) {

        forgotPassword.addEventListener('click', function (event) {

            event.preventDefault();

            alert(
                'Silakan hubungi administrator Presma Konveksi untuk mengatur ulang kata sandi.'
            );

        });

    }

});
