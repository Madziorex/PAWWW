<?php
session_start();

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

    $output = '<form method="post" action="" enctype="multipart/form-data">';
    $output .= '<table border="1px" width="100%">';
    $output .= '<tr><td>Zdjęcie</td><td>Nazwa</td><td>Opis</td><td>Waga</td><td>Kategoria</td><td>Cena</td><td>Ilość sztuk</td><td>Akcja</td></tr>';

    while ($row = mysqli_fetch_assoc($result)) {
        $output .= '<tr>';
        $output .= '<td>' . $row['zdjecie'] . '</td>';
        $output .= '<td>' . $row['tytul'] . '</td>';
        $output .= '<td>' . $row['opis'] . '</td>';
        $output .= '<td>' . $row['gabaryt_produktu'] . ' kg</td>';
        $output .= '<td>' . $row['kategoria'] . '</td>';
        $output .= '<td>' . ($row['cena_netto'] + $row['podatek_vat']) . ' zł</td>';
        $output .= '<td>' . $row['dostepne_sztuki'] . '</td>';
        $output .= '<td><input type="checkbox" name="produkt[' . $row['id_produktu'] . ']" value="' . $row['tytul'] . '|' . ($row['cena_netto'] + $row['podatek_vat']) . '">';
        $output .= '<input type="hidden" name="cena[' . $row['id_produktu'] . ']" value="' . ($row['cena_netto'] + $row['podatek_vat']) . '">';
        $output .= ' Dodaj do koszyka</td>';
        $output .= '</tr>';
    }

    $output .= '</table>';
    $output .= '<input type="submit" name="submit" value="Dodaj do koszyka">';
    $output .= '</form>';

    // Zamknij połączenie
    $conn->close();

    return $output;
}

function pokazKoszyk()
{
    $output = '<h2>Koszyk</h2>';
    $suma = 0; // Dodajemy zmienną do przechowywania sumy

    if (isset($_SESSION['koszyk']) && !empty($_SESSION['koszyk'])) {
        $output .= '<form method="post" action="">';
        $output .= '<table border="1px" width="100%">';
        $output .= '<tr><td>Nr</td><td>Nazwa</td><td>Cena</td><td>Data</td><td>Ilość</td><td>Podsumowanie</td><td>Usuń</td></tr>';

        foreach ($_SESSION['koszyk'] as $nr => $item) {
            $output .= '<tr>';
            $output .= '<td>' . ($nr + 1) . '</td>';
            $output .= '<td>' . $item['nazwa'] . '</td>';
            $output .= '<td>' . $item['cena'] . ' zł</td>';
            $output .= '<td>' . date('Y-m-d H:i:s', $item['data']) . '</td>';
            $output .= '<td><input type="number" name="ilosc[' . $nr . ']" value="' . $item['ile_sztuk'] . '" min="1">';
            $output .= '<input type="hidden" name="stara_ilosc[' . $nr . ']" value="' . $item['ile_sztuk'] . '">'; // Dodane pole ukryte
            $output .= '</td>';
            $podsumowanie = $item['ile_sztuk'] * $item['cena']; // Obliczamy podsumowanie dla tego elementu
            $output .= '<td>' . $podsumowanie . ' zł</td>'; // Zaktualizowane pole podsumowania
            $suma += $podsumowanie; // Dodajemy podsumowanie do sumy
            $output .= '<td><input type="submit" name="delete[' . $nr . ']" value="Usuń"></td>';
            $output .= '</tr>';
        }

        $output .= '</table>';
        $output .= '<p>Suma: ' . $suma . ' zł</p>'; // Wyświetlamy sumę
        $output .= '<input type="submit" name="update" value="Aktualizuj koszyk">';
        $output .= '</form>';
    } else {
        $output .= '<p>Koszyk jest pusty.</p>';
    }

    return $output;
}

function dodajDoKoszyka($produktId, $nazwa, $cena)
{
    if (!isset($_SESSION['koszyk'])) {
        $_SESSION['koszyk'] = array();
    }

    // Dodaj produkt do sesji
    $_SESSION['koszyk'][] = array(
        'id' => $produktId,
        'nazwa' => $nazwa,
        'cena' => $cena,
        'ile_sztuk' => 1, // Możesz dostosować ilość
        'data' => time(),
    );
}

function usunZKoszyka(){
    if(isset($_POST['delete'])){
        foreach($_POST['delete'] as $nr => $value){
            unset($_SESSION['koszyk'][$nr]);
        }
    }
}

function Sklep()
{
    $output = '';

    if (isset($_POST['submit'])) {
        foreach ($_POST['produkt'] as $produktId => $wartosc) {
            list($nazwa, $cena) = explode('|', $wartosc);
            dodajDoKoszyka($produktId, $nazwa, $cena);
        }
    }

    if (isset($_POST['update'])) {
        foreach ($_POST['ilosc'] as $nr => $ilosc) {
            if ($ilosc != $_POST['stara_ilosc'][$nr]) {
                $_SESSION['koszyk'][$nr]['ile_sztuk'] = $ilosc;
            }
        }
    }

    usunZKoszyka();

    $output .= pokazSklep();
    $output .= pokazKoszyk();

    return $output;
}
?>