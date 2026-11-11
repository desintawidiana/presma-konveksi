document.addEventListener('DOMContentLoaded', function () {
    const filterButtons = document.querySelectorAll(
        '.notification-filter-tabs button'
    );

    const categoryFilter = document.querySelector(
        '.notification-filter select'
    );

    const notificationCards = document.querySelectorAll(
        '.notification-card'
    );

    const markAllBtn = document.querySelector('.btn-mark-all');

    let activeStatus = 'Semua';

    function filterNotifications() {
        const selectedCategory = categoryFilter
            ? categoryFilter.value.toLowerCase()
            : 'semua';

        notificationCards.forEach(card => {
            const isUnread = card.classList.contains('unread');

            const cardCategory = (
                card.dataset.category || ''
            ).toLowerCase();

            let matchStatus = true;
            let matchCategory = true;

            // Filter status
            if (activeStatus === 'Baru') {
                matchStatus = isUnread;
            } else if (activeStatus === 'Sudah Dilihat') {
                matchStatus = !isUnread;
            }

            // Filter kategori
            if (
                selectedCategory !== 'semua' &&
                selectedCategory !== ''
            ) {
                matchCategory = cardCategory === selectedCategory;
            }

            card.style.display =
                matchStatus && matchCategory ? 'flex' : 'none';
        });
    }

    // FILTER STATUS
    filterButtons.forEach(button => {
        button.addEventListener('click', function () {
            filterButtons.forEach(item => {
                item.classList.remove('active');
            });

            button.classList.add('active');
            activeStatus = button.textContent.trim();

            filterNotifications();
        });
    });

    // FILTER KATEGORI
    if (categoryFilter) {
        categoryFilter.addEventListener('change', function () {
            filterNotifications();
        });
    }

    // TANDAI SEMUA SUDAH DILIHAT
    if (markAllBtn) {
        markAllBtn.addEventListener('click', function () {
            notificationCards.forEach(card => {
                card.classList.remove('unread');

                const newLabel = card.querySelector('.new-label');

                if (newLabel) {
                    newLabel.remove();
                }
            });

            // Perbarui jumlah notifikasi baru
            const summaryNumbers = document.querySelectorAll(
                '.notification-summary-card h3'
            );

            if (summaryNumbers.length >= 2) {
                summaryNumbers[1].textContent = '0';
            }

            markAllBtn.textContent = 'Semua sudah dilihat';

            filterNotifications();
        });
    }

    // Tampilkan seluruh notifikasi saat halaman pertama dibuka
    filterNotifications();
});