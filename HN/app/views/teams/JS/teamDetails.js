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

document.addEventListener("DOMContentLoaded", function() {
    var forms = document.querySelectorAll("form[id^='deletePlayerForm-']");
    forms.forEach(function(form) {
        form.addEventListener("submit", function(event) {
            var confirmDelete = confirm("Are you sure you want to delete this player?");
            if (!confirmDelete) {
                event.preventDefault();
            }
        });
    });
});


