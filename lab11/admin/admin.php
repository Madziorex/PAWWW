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

function Pokaz($link){
    $output .= '<div>';
    $output .= '<h1>Podstrony</h1>';
    $output .= ListaPodstron($link);
    $output .= '</div>';
    $output .= '<div>';
    $output .= '<h1>Kategorie</h1>';
    $output .= ZarzadzajKategoriami($link);
    $output .= '</div>';
    $output .= '<div><h1>Produkty</h1>';
    $output .= WyswietlSklep();
    $output .= '<table><tr><td>';
    $output .= '<h4>Dodaj produkt</h4>';
    $output .= '
    <form method="post" action="' . $_SERVER["PHP_SELF"] . '" enctype="multipart/form-data">
    <input type="hidden" name="sklep_dodaj" value="1">
    <table>
    <tr>
        <td><label for="tytul">Tytuł Produktu:</label></td>
        <td><input type="text" name="tytul" required></td>
    </tr><tr>
        <td><label for="opis">Opis Produktu:</label></td>
        <td><textarea name="opis"></textarea></td>
    </tr><tr>
        <td><label for="cena_netto">Cena Netto:</label></td>
        <td><input type="number" name="cena_netto" step="0.01"></td>
    </tr><tr>
        <td><label for="podatek_vat">Podatek VAT (%):</label></td>
        <td><input type="number" name="podatek_vat" step="0.01"></td>
    </tr><tr>
        <td><label for="dostepne_sztuki">Ilość Dostępnych Sztuk:</label></td>
        <td><input type="number" name="dostepne_sztuki"></td>
    </tr><tr>
        <td><label for="status_dostepnosci">Status Dostępności:</label></td>
        <td><select name="status_dostepnosci">
            <option value="1">Dostępny</option>
            <option value="0">Niedostępny</option>
        </select></td>
    </tr><tr>
        <td><label for="kategoria">Kategoria:</label></td>
        <td><input type="text" name="kategoria"></td>
    </tr><tr>
        <td><label for="gabaryt_produktu">Gabaryt Produktu:</label></td>
        <td><input type="text" name="gabaryt_produktu"></td>
    </tr><tr>
        <td><label for="data_wygasniecia">Data Wygaśnięcia:</label></td>
        <td><input type="date" name="data_wygasniecia"></td>
    </tr><tr>
        <td><label for="zdjecie">Zdjęcie Produktu (ścieżka):</label></td>
        <td><input type="text" name="zdjecie"></td>
    </tr><tr>
        <td></td>
        <td><input type="submit" value="Dodaj Produkt"></td></tr>
    </table>
    </form></td>';
    $output .= '<td><h4>Edytuj produkt</h4>';
    $output .= '
    <form method="post" action="' . $_SERVER["PHP_SELF"] . '" enctype="multipart/form-data">
    <input type="hidden" name="sklep_edytuj" value="1">
    <table>
    <tr>
        <td><label for="id">ID Produktu:</label></td>
        <td><input type="number" name="id"></td>
    </tr><tr>
    </tr><tr>
        <td><label for="tytul">Tytuł Produktu:</label></td>
        <td><input type="text" name="tytul"></td>
    </tr><tr>
        <td><label for="opis">Opis Produktu:</label></td>
        <td><textarea name="opis"></textarea></td>
    </tr><tr>
        <td><label for="cena_netto">Cena Netto:</label></td>
        <td><input type="number" name="cena_netto" step="0.01"></td>
    </tr><tr>
        <td><label for="podatek_vat">Podatek VAT (%):</label></td>
        <td><input type="number" name="podatek_vat" step="0.01"></td>
    </tr><tr>
        <td><label for="dostepne_sztuki">Ilość Dostępnych Sztuk:</label></td>
        <td><input type="number" name="dostepne_sztuki"></td>
    </tr><tr>
        <td><label for="status_dostepnosci">Status Dostępności:</label></td>
        <td><select name="status_dostepnosci">
            <option value="1">Dostępny</option>
            <option value="0">Niedostępny</option>
        </select></td>
    </tr><tr>
        <td><label for="kategoria">Kategoria:</label></td>
        <td><input type="text" name="kategoria"></td>
    </tr><tr>
        <td><label for="gabaryt_produktu">Gabaryt Produktu:</label></td>
        <td><input type="text" name="gabaryt_produktu"></td>
    </tr><tr>
        <td><label for="data_wygasniecia">Data Wygaśnięcia:</label></td>
        <td><input type="date" name="data_wygasniecia"></td>
    </tr><tr>
        <td><label for="zdjecie">Zdjęcie Produktu (ścieżka):</label></td>
        <td><input type="text" name="zdjecie"></td>
    </tr><tr>
        <td></td>
        <td><input type="submit" value="Edytuj Produkt"></td></tr>
    </table>
    </form></td></tr></table>';
    $output .= '<h4>Usuń produkt</h4>
    <form method="post" action="' . $_SERVER["PHP_SELF"] . '" enctype="multipart/form-data">
    <input type="hidden" name="sklep_usun" value="1">
    <label for="id">ID Produktu:</label>
    <input type="number" name="id">
    <input type="submit" value="Usuń Produkt">
    </form>
    ';
    $output .= '</div>';
    return $output;
}

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

function WyswietlSklep()
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
    $sql = "SELECT * FROM produkty_sklep";

    // Wykonaj zapytanie
    $result = $conn->query($sql);


    while ($row = mysqli_fetch_assoc($result)) {
        $output .= 'Id: '. $row['id'] .', nazwa: '. $row['tytul'] .', opis: '. $row['opis'] .', cena netto: '. $row['cena_netto'] .', podatek vat: '. $row['podatek_vat'] .', dostepne sztuki: '. $row['dostepne_sztuki'] .', status dostępności: '. $row['status_dostepnosci'] .', kategoria: '. $row['kategoria'] .', gabaryt produktu: '. $row['gabaryt_produktu'] .', ścieżka zdjęcia: '. htmlspecialchars($row['zdjecie']) .'<br><br>';
    }

    // Zamknij połączenie
    $conn->close();

    return $output;
}

function DodajSklep($tytul, $opis, $cena_netto, $podatek_vat, $dostepne_sztuki, $status_dostepnosci, $kategoria, $gabaryt_produktu, $zdjecie, $data_wygasniecia) {
    // Your existing code for database connection
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
    $tytul = $conn->real_escape_string($tytul);
    $opis = $conn->real_escape_string($opis);
    $cena_netto = $conn->real_escape_string($cena_netto);
    $podatek_vat = $conn->real_escape_string($podatek_vat)*$cena_netto/100;
    $dostepne_sztuki = $conn->real_escape_string($dostepne_sztuki);
    $status_dostepnosci = $conn->real_escape_string($status_dostepnosci);
    $kategoria = $conn->real_escape_string($kategoria);
    $gabaryt_produktu = $conn->real_escape_string($gabaryt_produktu);
    $zdjecie = $conn->real_escape_string($zdjecie);
    $data_wygasniecia = $conn->real_escape_string($data_wygasniecia);

    // Zapytanie dodające nowy wpis do bazy danych
    $query = "INSERT INTO produkty_sklep (tytul, opis, cena_netto, podatek_vat, dostepne_sztuki, status_dostepnosci, kategoria, gabaryt_produktu, zdjecie, data_utworzenia, data_wygasniecia) VALUES ('$tytul', '$opis', '$cena_netto', '$podatek_vat', '$dostepne_sztuki', '$status_dostepnosci', '$kategoria', '$gabaryt_produktu', '$zdjecie', CURDATE(), '$data_wygasniecia')";

    // Wykonanie zapytania
    if ($conn->query($query) === TRUE) {
        echo "Nowy wpis został dodany pomyślnie.";
    } else {
        echo "Błąd podczas dodawania nowego wpisu: " . $conn->error;
    }

    // Zamknięcie połączenia
    $conn->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sklep_dodaj']) && $_POST['sklep_dodaj'] == '1') {
    // Przechwytywanie zmiennych z formularza
    $tytul = isset($_POST['tytul']) ? $_POST['tytul'] : '';
    $opis = isset($_POST['opis']) ? $_POST['opis'] : '';
    $cena_netto = isset($_POST['cena_netto']) ? $_POST['cena_netto'] : '';
    $podatek_vat = isset($_POST['podatek_vat']) ? $_POST['podatek_vat'] : '';
    $dostepne_sztuki = isset($_POST['dostepne_sztuki']) ? $_POST['dostepne_sztuki'] : '';
    $status_dostepnosci = isset($_POST['status_dostepnosci']) ? $_POST['status_dostepnosci'] : '';
    $kategoria = isset($_POST['kategoria']) ? $_POST['kategoria'] : '';
    $gabaryt_produktu = isset($_POST['gabaryt_produktu']) ? $_POST['gabaryt_produktu'] : '';
    $data_wygasniecia = isset($_POST['data_wygasniecia']) ? $_POST['data_wygasniecia'] : '';
    $zdjecie = isset($_POST['zdjecie']) ? $_POST['zdjecie'] : '';

    // Wywołanie funkcji do obsługi dodawania produktu do sklepu
    DodajSklep($tytul, $opis, $cena_netto, $podatek_vat, $dostepne_sztuki, $status_dostepnosci, $kategoria, $gabaryt_produktu, $zdjecie, $data_wygasniecia);
}

function EdytujSklep($id, $tytul, $opis, $cena_netto, $podatek_vat, $dostepne_sztuki, $status_dostepnosci, $kategoria, $gabaryt_produktu, $zdjecie, $data_wygasniecia) {
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
    $tytul = $conn->real_escape_string($tytul);
    $opis = $conn->real_escape_string($opis);
    $cena_netto = $conn->real_escape_string($cena_netto);
    $podatek_vat = $conn->real_escape_string($podatek_vat)*$cena_netto/100;
    $dostepne_sztuki = $conn->real_escape_string($dostepne_sztuki);
    $status_dostepnosci = $conn->real_escape_string($status_dostepnosci);
    $kategoria = $conn->real_escape_string($kategoria);
    $gabaryt_produktu = $conn->real_escape_string($gabaryt_produktu);
    $zdjecie = $conn->real_escape_string($zdjecie);
    $data_wygasniecia = $conn->real_escape_string($data_wygasniecia);
    
    // Zapytanie aktualizujące wpis w bazie danych
    $query = "UPDATE produkty_sklep SET tytul='$tytul', opis='$opis', cena_netto='$cena_netto', podatek_vat='$podatek_vat', dostepne_sztuki='$dostepne_sztuki', status_dostepnosci='$status_dostepnosci', kategoria='$kategoria', gabaryt_produktu='$gabaryt_produktu', zdjecie='$zdjecie', data_wygasniecia='$data_wygasniecia', data_modyfikacji=CURDATE() WHERE id='$id'";

    // Wykonanie zapytania
    if ($conn->query($query) === TRUE) {
        echo "Wpis został zaktualizowany pomyślnie.";
    } else {
        echo "Błąd podczas aktualizacji wpisu: " . $conn->error;
    }

    // Zamknięcie połączenia
    $conn->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sklep_edytuj']) && $_POST['sklep_edytuj'] == '1') {
    // Przechwytywanie zmiennych z formularza
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $tytul = isset($_POST['tytul']) ? $_POST['tytul'] : '';
    $opis = isset($_POST['opis']) ? $_POST['opis'] : '';
    $cena_netto = isset($_POST['cena_netto']) ? $_POST['cena_netto'] : '';
    $podatek_vat = isset($_POST['podatek_vat']) ? $_POST['podatek_vat'] : '';
    $dostepne_sztuki = isset($_POST['dostepne_sztuki']) ? $_POST['dostepne_sztuki'] : '';
    $status_dostepnosci = isset($_POST['status_dostepnosci']) ? $_POST['status_dostepnosci'] : '';
    $kategoria = isset($_POST['kategoria']) ? $_POST['kategoria'] : '';
    $gabaryt_produktu = isset($_POST['gabaryt_produktu']) ? $_POST['gabaryt_produktu'] : '';
    $data_wygasniecia = isset($_POST['data_wygasniecia']) ? $_POST['data_wygasniecia'] : '';
    $zdjecie = isset($_POST['zdjecie']) ? $_POST['zdjecie'] : '';

    // Wywołanie funkcji do obsługi dodawania produktu do sklepu
    EdytujSklep($id, $tytul, $opis, $cena_netto, $podatek_vat, $dostepne_sztuki, $status_dostepnosci, $kategoria, $gabaryt_produktu, $zdjecie, $data_wygasniecia);
}

function UsunSklep($id) {
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
    $query = "DELETE FROM produkty_sklep WHERE id='$id'";

    // Wykonanie zapytania
    if ($conn->query($query) === TRUE) {
        echo "Wpis został usunięty pomyślnie.";
    } else {
        echo "Błąd podczas usuwania wpisu: " . $conn->error;
    }

    // Zamknięcie połączenia
    $conn->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sklep_usun']) && $_POST['sklep_usun'] == '1') {
    // Przechwytywanie zmiennych z formularza
    $id = isset($_POST['id']) ? $_POST['id'] : '';

    // Wywołanie funkcji do obsługi dodawania produktu do sklepu
    UsunSklep($id);
}

// Funkcja wylogowująca użytkownika
function Wyloguj()
{
    session_destroy();
}
?>