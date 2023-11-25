document.addEventListener("DOMContentLoaded", () => {

    function inicializacao() {
        startTimer();
        console.log('[+] login-form.js iniciado');
    }

    inicializacao();
    function startTimer() {
        var hoursElement = document.getElementById("hours");
        var minutesElement = document.getElementById("minutes");
        var secondsElement = document.getElementById("seconds");

        var hours = 24;
        var minutes = 0;
        var seconds = 0;

        var intervalId = setInterval(function () {
            seconds--;
            if (seconds < 0) {
                seconds = 59;
                minutes--;
                if (minutes < 0) {
                    minutes = 59;
                    hours--;
                    if (hours < 0) {
                        clearInterval(intervalId);
                    }
                }
            }

            hoursElement.textContent = (hours < 10 ? "0" : "") + hours;
            minutesElement.textContent = (minutes < 10 ? "0" : "") + minutes;
            secondsElement.textContent = (seconds < 10 ? "0" : "") + seconds;
        }, 1000);
    }
});