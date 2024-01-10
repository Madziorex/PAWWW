// Funkcja pobierająca bieżącą datę i aktualizująca element HTML o identyfikatorze "data"
function gettheDate() {
    Todays = new Date();
    TheDate = "" + (Todays.getMonth() + 1) +" / "+ Todays.getDate() + " / "+(Todays.getYear()-100);
    document.getElementById("data").innerHTML = TheDate;
}

// Zmienne globalne związane z zegarem
var timerID = null;
var timerRunning = false;

// Funkcja zatrzymująca działanie zegara
function stopclock() {
    if(timerRunning) {
        clearTimeout(timerID);
    }
    timerRunning = false;
}

// Funkcja rozpoczynająca działanie zegara
function startclock() {
    stopclock();
    gettheDate();
    showtime();
}

// Funkcja wyświetlająca bieżący czas w elemencie HTML o identyfikatorze "zegarek"
function showtime() {
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var seconds = now.getSeconds();
    var timeValue = "" + ((hours >12)? hours -12 :hours);
    timeValue += ((minutes < 10) ? ":0" : ":") + minutes;
    timeValue += ((seconds < 10) ? ":0" : ":") + seconds;
    timeValue += (hours >= 12) ? " P.M." : " A.M.";
    document.getElementById("zegarek").innerHTML = timeValue;
    timerID = setTimeout("showtime()",1000);
    timerRunning = true;
}