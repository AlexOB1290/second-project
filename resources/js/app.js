import './bootstrap';

document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const sidebar = document.getElementById('sidebar');
    const closeSidebarBtn = document.querySelector('.close-sidebar');
    const overlay = document.createElement('div');

    overlay.classList.add('fixed', 'inset-0', 'bg-black', 'opacity-50', 'z-40', 'hidden');
    document.body.appendChild(overlay);

    function toggleSidebar() {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('hidden');
        document.body.classList.toggle('overflow-hidden');
    }

    mobileMenuBtn.addEventListener('click', toggleSidebar);
    closeSidebarBtn.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', toggleSidebar);

    // Закрываем сайдбар при изменении размера экрана
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768 && sidebar.classList.contains('active')) {
            toggleSidebar();
        }
    });
});
