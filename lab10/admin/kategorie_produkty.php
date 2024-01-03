<?php

function wyswietlKategorie()
{
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'moja_strona';

    // Utwórz połączenie
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Sprawdź połączenie
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Zapytanie SQL
    $sql = "SELECT id, matka, nazwa FROM produkty";

    // Wykonaj zapytanie
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $output .= "<ul>";
        while ($row = $result->fetch_assoc()) {
            // Jeśli matka=0, to jest to nowa kategoria
            if ($row['matka'] == 0) {
                $output .= "<li>" . $row['nazwa'] . "</li>";
                wyswietlPodkategorie($row['id'], $conn);
            }
        }
        $output .= "</ul>";
    } else {
        echo "Brak danych do wyświetlenia.";
    }

    // Zamknij połączenie
    $conn->close();

    return $output;
}

function wyswietlPodkategorie($matkaId, $conn)
{
    // Zapytanie SQL dla podkategorii
    $sql = "SELECT id, matka, nazwa FROM produkty WHERE matka = $matkaId";

    // Wykonaj zapytanie
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $output .= "<ul>";
        while ($row = $result->fetch_assoc()) {
            // Wyświetl podkategorie
            $output .= "<li>" . $row['nazwa'] . "</li>";
            wyswietlPodkategorie($row['id'], $conn);
        }
        $output .= "</ul>";
    }
}

function WybierzOpcje($conn){
    wyswietlKategorie();
}
?>