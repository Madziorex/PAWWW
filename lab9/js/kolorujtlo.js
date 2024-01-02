// Zmienne globalne
var computer = false; // Flaga oznaczająca, czy użytkownik wprowadził dane
var decimal = 0; // Liczba miejsc po przecinku

// Funkcja konwertująca jednostki miar
function convert(entryform, from, to) {
    // Pobranie indeksów jednostek miar
    convertfrom = from.selectedIndex;
    convertto = to.selectedIndex;

    // Wykonanie konwersji i wyświetlenie wyniku
    entryform.display.value = (entryform.input.value * from[convertfrom].value / to[convertto.value]);
}

// Funkcja dodająca znak do pola wejściowego
function addChar(input, character) {
    // Warunki sprawdzające, czy można dodać znak
    if ((character == '.' && decimal == "0") || character != '.') {
        // Dodanie znaku do pola wejściowego
        (input.value == "" || input.value == "0") ? input.value = character : input.value += character;

        // Wywołanie funkcji konwersji i ustawienie flag
        convert(input.form.input.form.measure1, input.form.measure2);
        computer = true;

        // Ustawienie flagi dla kropki dziesiętnej
        if (character == ".") {
            decimal = 1;
        }
    }
}

// Funkcja otwierająca nowe okno przeglądarki
function openVothcom() {
    window.open("", "Display window", "toolbar=no,directories=no,menubar=no");
}

// Funkcja czyszcząca pola formularza
function clear(form) {
    form.input.value = 0;
    form.display.value = 0;
    decimal = 0;
}

// Funkcja zmieniająca kolor tła strony
function changeBackground(hexNumber) {
    document.body.style.backgroundColor = hexNumber;
}