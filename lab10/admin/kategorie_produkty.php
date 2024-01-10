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
        $output = "<ul>";
        while ($row = $result->fetch_assoc()) {
            // Jeśli matka=0, to jest to nowa kategoria
            if ($row['matka'] == 0) {
                $output .= "<li>". $row['id'] . ' ' . $row['nazwa'];
                $output .= wyswietlPodkategorie($row['id'], $conn);
                $output .= "</li>";
            }
        }
        $output .= "</ul>";
    } else {
        $output = "Brak danych do wyświetlenia.";
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

    $output = '';

    if ($result->num_rows > 0) {
        $output .= "<ul>";
        while ($row = $result->fetch_assoc()) {
            // Wyświetl podkategorie
            $output .= "<li>". $row['id'] . ' ' . $row['nazwa'];
            $output .= wyswietlPodkategorie($row['id'], $conn);
            $output .= "</li>";
        }
        $output .= "</ul>";
    }

    return $output;
}

function EdytujKategorie($id, $nowaMatka, $nowaNazwa) {
    // Dane do połączenia z bazą danych
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'moja_strona';

    // Nawiązanie połączenia z bazą danych
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Połączenie nieudane: " . $conn->connect_error);
    }

    // Escapowanie danych przed zapytaniem SQL
    $id = $conn->real_escape_string($id);
    $nowyTytul = $conn->real_escape_string($nowaMatka);
    $nowaZawartosc = $conn->real_escape_string($nowaNazwa);

    // Zapytanie aktualizujące wpis w bazie danych
    $query = "UPDATE produkty SET matka='$nowaMatka', nazwa='$nowaNazwa' WHERE id='$id'";

    // Wykonanie zapytania
    if ($conn->query($query) === TRUE) {
        echo "Wpis został zaktualizowany pomyślnie.";
    } else {
        echo "Błąd podczas aktualizacji wpisu: " . $conn->error;
    }

    // Zamknięcie połączenia
    $conn->close();
}

function DodajKategorie($matka, $nazwa) {
    // Dane do połączenia z bazą danych
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'moja_strona';

    // Nawiązanie połączenia z bazą danych
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Połączenie nieudane: " . $conn->connect_error);
    }

    // Sprawdzenie, czy baza danych została wybrana poprawnie
    if (!mysqli_select_db($conn, $dbname)) {
        die("Nie udało się wybrać bazy danych: " . mysqli_error($conn));
    }

    // Escapowanie danych przed zapytaniem SQL
    $matka = $conn->real_escape_string($matka);
    $nazwa = $conn->real_escape_string($nazwa);

    // Zapytanie dodające nowy wpis do bazy danych
    $query = "INSERT INTO produkty (matka, nazwa) VALUES ('$matka', '$nazwa')";

    // Wykonanie zapytania
    if ($conn->query($query) === TRUE) {
        echo "Nowy wpis został dodany pomyślnie.";
    } else {
        echo "Błąd podczas dodawania nowego wpisu: " . $conn->error;
    }

    // Zamknięcie połączenia
    $conn->close();
}

function UsunKategorie($id) {
    // Dane do połączenia z bazą danych
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'moja_strona';

    // Nawiązanie połączenia z bazą danych
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Połączenie nieudane: " . $conn->connect_error);
    }

    // Escapowanie danych przed zapytaniem SQL
    $id = $conn->real_escape_string($id);

    // Zapytanie usuwające wpis z bazy danych
    $query = "DELETE FROM produkty WHERE id='$id'";

    // Wykonanie zapytania
    if ($conn->query($query) === TRUE) {
        echo "Wpis został usunięty pomyślnie.";
    } else {
        echo "Błąd podczas usuwania wpisu: " . $conn->error;
    }

    // Zamknięcie połączenia
    $conn->close();
}

function ZarzadzajKategoriami($conn){
    $output .= '<table><tr><td width="50%">'. wyswietlKategorie() . '</td>';
    $output .= '<td><div class="panel_admina"><form method="post" action="' . $_SERVER["PHP_SELF"] . '">
    <label for="products">Operacja:</label>
    <select name="products">
        <option value="edytuj">Edytuj</option>
        <option value="dodaj">Dodaj</option>
        <option value="usun">Usuń</option>
    </select><br>
    <table class="operacje">
    <tr>
        <td><label for="id">ID:</label></td>
        <td><input type="number" name="id"></td>
    </tr>
    <tr>
        <td><label for="matka">Matka:</label></td>
        <td><input type="number" name="matka" ></td>
    </tr>
    <tr>
        <td><label for="nazwa">Nazwa:</label></td>
        <td><input type="text" name="nazwa" ></td>
    </tr>
    </table>
    
    <input type="submit" value="Wykonaj Operację">
    </form></div></td></tr></table>';

    mysqli_free_result($result);
    return $output;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['products'])) {
    $operacja = $_POST['products'];
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $nowaMatka = isset($_POST['matka']) ? $_POST['matka'] : '';
    $nowaNazwa = isset($_POST['nazwa']) ? $_POST['nazwa'] : '';

    // Wywołanie odpowiedniej funkcji w zależności od operacji
    switch ($operacja) {
        case 'edytuj':
            EdytujKategorie($id, $nowaMatka, $nowaNazwa);
            break;
        case 'dodaj':
            DodajKategorie($nowaMatka, $nowaNazwa);
            break;
        case 'usun':
            UsunKategorie($id);
            break;
        default:
            echo "Nieznana operacja";
    }
}
?>