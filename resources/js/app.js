import './bootstrap';
document.addEventListener("DOMContentLoaded", function () {
    const button = document.querySelector('.menu-button');
    const dropdown = document.getElementById('userDropdown');

    button?.addEventListener('click', function (e) {
        e.stopPropagation();
        dropdown?.classList.toggle('show');
    });

    document.addEventListener('click', function (e) {
        if (!button.contains(e.target)) {
            dropdown?.classList.remove('show');
        }
    });
});
