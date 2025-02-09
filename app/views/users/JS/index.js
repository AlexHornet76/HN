document.addEventListener('DOMContentLoaded', () => {
    const rows = document.querySelectorAll('table tr');
    const fadeInOnScroll = () => {
        rows.forEach((row) => {
            const rowPosition = row.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            if (rowPosition < windowHeight - 50) {
                row.classList.add('visible');
            } else {
                row.classList.remove('visible');
            }
        });
    };
    window.addEventListener('scroll', fadeInOnScroll);
    fadeInOnScroll();
});
