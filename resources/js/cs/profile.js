document.addEventListener('DOMContentLoaded', function () {
    // EDIT PROFIL
    const editBtn = document.getElementById('edit-profile-btn');
    const cancelBtn = document.getElementById('cancel-profile-btn');
    const saveBtn = document.getElementById('save-profile-btn');
    const profileForm = document.getElementById('profile-form');
    const profileActions = document.getElementById('profile-actions');

    if (editBtn && profileForm && profileActions) {
        const inputs = profileForm.querySelectorAll(
            'input[name="name"], input[name="email"], input[name="phone"]'
        );

        let originalValues = {};

        function setEditMode(enabled) {
            inputs.forEach(input => {
                input.readOnly = !enabled;
            });

            profileActions.classList.toggle('show', enabled);
            editBtn.style.display = enabled ? 'none' : 'flex';
        }

        editBtn.addEventListener('click', function () {
            originalValues = {};

            inputs.forEach(input => {
                originalValues[input.name] = input.value;
            });

            setEditMode(true);
        });

        if (cancelBtn) {
            cancelBtn.addEventListener('click', function () {
                inputs.forEach(input => {
                    input.value = originalValues[input.name] ?? input.value;
                });

                setEditMode(false);
            });
        }

        if (saveBtn) {
            saveBtn.addEventListener('click', function () {
                alert(
                    'Tampilan edit profil berhasil diuji. Penyimpanan database belum diaktifkan.'
                );

                setEditMode(false);
            });
        }
    }

    // GANTI PASSWORD
    const passwordBtn = document.getElementById('change-password-btn');
    const passwordForm = document.getElementById('password-form');

    if (passwordBtn && passwordForm) {
        passwordBtn.addEventListener('click', function () {
            passwordForm.classList.toggle('hidden');

            passwordBtn.textContent =
                passwordForm.classList.contains('hidden')
                    ? 'Ganti Password'
                    : 'Tutup';
        });
    }
});