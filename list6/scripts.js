/*jslint browser:true */
let time = 0;

setInterval(function () {
    time += 1;

    let hours = Math.floor(time / (60 * 60));
    let minutes = Math.floor((time % (60 * 60)) / 60);
    let seconds = time % 60;

    let str = hours + "h " + minutes + "m " + seconds + "s";

    document.getElementById("timer").innerText = "Czas na stronie: " + str;
}, 1000);