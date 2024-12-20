document.addEventListener('DOMContentLoaded', function() {
    var textWrapper = document.querySelector('.ml6 .letters');
    textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

    anime.timeline({loop: true})
    .add({
        targets: '.ml6 .letter',
        translateY: ["1.1em", 0],
        opacity: [0, 1],
        duration: 750,
        delay: (el, i) => 50 * i
    }).add({
        targets: '.ml6 .letter',
        opacity: [1, 0],
        duration: 750,
        easing: "easeOutExpo",
        delay: (el, i) => 50 * i
    });
});