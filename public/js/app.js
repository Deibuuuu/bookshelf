document.addEventListener('DOMContentLoaded', function () {
    const filterForm = document.querySelector('.filter-container');
    if (filterForm) {
        filterForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const url = new URL(filterForm.action, window.location.origin);
            const formData = new FormData(filterForm);

            for (const [key, value] of formData.entries()) {
                if (typeof value === 'string' && value.trim() !== '') {
                    url.searchParams.set(key, value.trim());
                } else {
                    url.searchParams.delete(key);
                }
            }

            url.hash = 'book-section';

            if (url.toString() === window.location.href) {
                window.location.reload();
            } else {
                window.location.href = url.toString();
            }
        });
    }

    if (window.location.search && !window.location.hash) {
        const bookSection = document.getElementById('book-section');
        if (bookSection) {
            bookSection.scrollIntoView();
        }
    }
});

// password toggle
document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password');
    const toggleBtn = document.getElementById('togglePassword');
    const eyeIcon = document.getElementById('eyeIcon');

    if (toggleBtn && passwordInput && eyeIcon) {
        const eyeOpen = toggleBtn.dataset.eyeOpen || '/images/icons/eye.svg';
        const eyeClosed =
            toggleBtn.dataset.eyeClosed || '/images/icons/eye-closed.svg';

        toggleBtn.addEventListener('click', function () {
            const isPassword = passwordInput.type === 'password';

            passwordInput.type = isPassword ? 'text' : 'password';

            eyeIcon.src = isPassword ? eyeOpen : eyeClosed;
            eyeIcon.alt = isPassword ? 'Hide password' : 'Show password';
        });
    }
});
