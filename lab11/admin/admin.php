<?php
// Włączenie pliku konfiguracyjnego
include("./cfg.php");

// Funkcja generująca formularz logowania
function FormularzLogowania()
{
    $wynik = '
        <h1 class="heading">Panel CMS:</h1>
        <form method="post" name="LoginForm" enctype="multipart/form-data" action="'.$_SERVER['REQUEST_RRI'].'">
            <table class="logowanie">
                <tr><td class="log4_t">[email]</td><td><input type="text" name="login_email" class="logowanie" /></td></tr>
                <tr><td class="log4_t">[haslo]</td><td><input type="password" name="login_pass" class="logowanie" /></td></tr>
                <tr><td>&nbsp;</td><td><input type="submit" name="x1_submit" class="logowanie" value="zaloguj" /></td></tr>
            </table>
        </form>
    ';

    // Obsługa formularza logowania
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $loginEmail = isset($_POST['login_email']) ? $_POST['login_email'] : '';
        $loginPassword = isset($_POST['login_pass']) ? $_POST['login_pass'] : '';
    
        $_SESSION['login'] = $loginEmail;
        $_SESSION['pass'] = $loginPassword;

        // Przekierowanie po zalogowaniu
        header("Location: index.php?idp=admin");
    }

    return $wynik;
}

// Funkcja generująca listę podstron
function ListaPodstron($connection)
{
    $query = "SELECT * FROM page_list LIMIT 100";
    
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Błąd zapytania: " . mysqli_error($connection));
    }

    $output = '<table><tr><td><div class="lista_podstron"><table>';

    while ($row = mysqli_fetch_assoc($result)) {
        $output .= '<tr class="srodek"><td>' . $row['id'] . ' ' . $row['page_title'] . '</td></tr>';
    }

    $output .= '</table></div></td><td>';
    $output .= '<div class="panel_admina"><form method="post" action="' . $_SERVER["PHP_SELF"] . '">
    <label for="operacja">Operacja:</label>
    <select name="operacja">
        <option value="edytuj">Edytuj</option>
        <option value="dodaj">Dodaj</option>
        <option value="usun">Usuń</option>
    </select><br>
    <table class="operacje">
    <tr>
        <td><label for="id">ID:</label></td>
        <td><input type="text" name="id"></td>
    </tr>
    <tr>
        <td><label for="nowy_tytul">Nowy Tytuł:</label></td>
        <td><input type="text" name="nowy_tytul" ></td>
    </tr>
    <tr>
        <td><label for="nowa_zawartosc">Nowa Zawartość:</label></td>
        <td><textarea name="nowa_zawartosc" rows="4" ></textarea></td>
    </tr>
    <tr>
        <td><label for="nowy_status">Nowy Status:</label></td>
        <td><input type="text" name="nowy_status" ></td>
    </tr>
    </table>
    
    <input type="submit" value="Wykonaj Operację">
    </form></div></td></tr></table>';

    mysqli_free_result($result);

    return $output;
}

// Funkcja do edycji wpisu
function edytujWpis($id, $nowyTytul, $nowaZawartosc, $nowyStatus) {
    // Dane do połączenia z bazą danych
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $baza = 'moja_strona';

    // Nawiązanie połączenia z bazą danych
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $baza);

    if ($conn->connect_error) {
        die("Połączenie nieudane: " . $conn->connect_error);
    }

    // Escapowanie danych przed zapytaniem SQL
    $id = $conn->real_escape_string($id);
    $nowyTytul = $conn->real_escape_string($nowyTytul);
    $nowaZawartosc = $conn->real_escape_string($nowaZawartosc);
    $nowyStatus = $conn->real_escape_string($nowyStatus);

    // Zapytanie aktualizujące wpis w bazie danych
    $query = "UPDATE page_list SET page_title='$nowyTytul', page_content='$nowaZawartosc', status='$nowyStatus' WHERE id='$id'";

    // Wykonanie zapytania
    if ($conn->query($query) === TRUE) {
        echo "Wpis został zaktualizowany pomyślnie.";
    } else {
        echo "Błąd podczas aktualizacji wpisu: " . $conn->error;
    }

    // Zamknięcie połączenia
    $conn->close();
}

// Funkcja dodająca nowy wpis
function dodajNowyWpis($tytul, $zawartosc, $status) {
    // Dane do połączenia z bazą danych
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $baza = 'moja_strona';

    // Nawiązanie połączenia z bazą danych
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $baza);

    if ($conn->connect_error) {
        die("Połączenie nieudane: " . $conn->connect_error);
    }

    // Sprawdzenie, czy baza danych została wybrana poprawnie
    if (!mysqli_select_db($conn, $baza)) {
        die("Nie udało się wybrać bazy danych: " . mysqli_error($conn));
    }

    // Escapowanie danych przed zapytaniem SQL
    $tytul = $conn->real_escape_string($tytul);
    $zawartosc = $conn->real_escape_string($zawartosc);
    $status = $conn->real_escape_string($status);

    // Zapytanie dodające nowy wpis do bazy danych
    $query = "INSERT INTO page_list (page_title, page_content, status) VALUES ('$tytul', '$zawartosc', '$status')";

    // Wykonanie zapytania
    if ($conn->query($query) === TRUE) {
        echo "Nowy wpis został dodany pomyślnie.";
    } else {
        echo "Błąd podczas dodawania nowego wpisu: " . $conn->error;
    }

    // Zamknięcie połączenia
    $conn->close();
}

// Funkcja usuwająca wpis
function usunWpis($id) {
    // Dane do połączenia z bazą danych
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $baza = 'moja_strona';

    // Nawiązanie połączenia z bazą danych
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $baza);

    if ($conn->connect_error) {
        die("Połączenie nieudane: " . $conn->connect_error);
    }

    // Sprawdzenie, czy baza danych została wybrana poprawnie
    if (!mysqli_select_db($conn, $baza)) {
        die("Nie udało się wybrać bazy danych: " . mysqli_error($conn));
    }

    // Escapowanie danych przed zapytaniem SQL
    $id = $conn->real_escape_string($id);

    // Zapytanie usuwające wpis z bazy danych
    $query = "DELETE FROM page_list WHERE id='$id'";

    // Wykonanie zapytania
    if ($conn->query($query) === TRUE) {
        echo "Wpis został usunięty pomyślnie.";
    } else {
        echo "Błąd podczas usuwania wpisu: " . $conn->error;
    }

    // Zamknięcie połączenia
    $conn->close();
}

// Obsługa formularza edycji, dodawania, usuwania wpisu
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['operacja'])) {
    $operacja = $_POST['operacja'];
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $nowyTytul = isset($_POST['nowy_tytul']) ? $_POST['nowy_tytul'] : '';
    $nowaZawartosc = isset($_POST['nowa_zawartosc']) ? $_POST['nowa_zawartosc'] : '';
    $nowyStatus = isset($_POST['nowy_status']) ? $_POST['nowy_status'] : '';

    // Wywołanie odpowiedniej funkcji w zależności od operacji
    switch ($operacja) {
        case 'edytuj':
            edytujWpis($id, $nowyTytul, $nowaZawartosc, $nowyStatus);
            break;
        case 'dodaj':
            dodajNowyWpis($nowyTytul, $nowaZawartosc, $nowyStatus);
            break;
        case 'usun':
            usunWpis($id);
            break;
        default:
            echo "Nieznana operacja";
    }
}

// Funkcja wylogowująca użytkownika
function Wyloguj()
{
    session_destroy();
}
?>