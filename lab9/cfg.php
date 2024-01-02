<?php
// Plik konfiguracyjny
// Dane do logowania
$login = "admin";
$pass = "admin123";

// Dane bazy danych
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$baza = 'moja_strona';

// Połączenie z bazą danych
$link = mysqli_connect($dbhost, $dbuser, $dbpass);

// Sprawdzenie, czy udało się nawiązać połączenie
if (!$link) {
    echo '<b>Przerwane połączenie</b>';
}

// Wybór bazy danych
if (!mysqli_select_db($link, $baza)) {
    echo 'Nie wybrano bazy danych';
}
?>