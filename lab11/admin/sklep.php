<?php

function pokazSklep()
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
    $sql = "SELECT * FROM produkty_sklep WHERE status_dostepnosci=1 AND dostepne_sztuki>0 AND data_wygasniecia>CURRENT_TIMESTAMP()";
    
    // Wykonaj zapytanie
    $result = $conn->query($sql);
    
    $output .= '<table border="1px" width="100%">';
    $output .= '<tr><td>Zdjęcie</td><td>Nazwa</td><td>Opis</td><td>Waga</td><td>Kategoria</td><td>Cena</td></tr>';

    while ($row = mysqli_fetch_assoc($result)) {
        $output .= '<tr><td>'. $row['zdjecie'] .'</td><td>'. $row['tytul'] .'</td><td>'. $row['opis'] .'</td><td>'. $row['gabaryt_produktu'] .' kg</td><td>'. $row['kategoria'] .'</td><td>'. ($row['cena_netto']  +  $row['podatek_vat']) .' zł</td></tr>';
    }

    $output .= '</table>';
    
    // Zamknij połączenie
    $conn->close();

    return $output;
}
?>