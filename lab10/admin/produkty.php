<?php
// Włączenie pliku konfiguracyjnego
include("./cfg.php");

// Funkcja generująca listę podstron
function Kategorie($connection)
{
    $query = "SELECT id, matka, nazwa FROM produkty";
    
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Błąd zapytania: " . mysqli_error($connection));
    }

    if ($result->num_rows > 0) {
        $output .= "<ul>";
        while ($row = $result->fetch_assoc()) {
            // Jeśli matka=0, to jest to nowa kategoria
            if ($row['matka'] == 0) {
                $output .= "<li>" . $row['nazwa'] . "</li>";
                wyswietlPodkategorie($row['id'], $connection);
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

// Funkcja do edycji wpisu
// function edytujWpis($id, $nowyTytul, $nowaZawartosc, $nowyStatus) {
//     // Dane do połączenia z bazą danych
//     $dbhost = 'localhost';
//     $dbuser = 'root';
//     $dbpass = '';
//     $baza = 'moja_strona';

//     // Nawiązanie połączenia z bazą danych
//     $conn = new mysqli($dbhost, $dbuser, $dbpass, $baza);

//     if ($conn->connect_error) {
//         die("Połączenie nieudane: " . $conn->connect_error);
//     }

//     // Escapowanie danych przed zapytaniem SQL
//     $id = $conn->real_escape_string($id);
//     $nowyTytul = $conn->real_escape_string($nowyTytul);
//     $nowaZawartosc = $conn->real_escape_string($nowaZawartosc);
//     $nowyStatus = $conn->real_escape_string($nowyStatus);

//     // Zapytanie aktualizujące wpis w bazie danych
//     $query = "UPDATE page_list SET page_title='$nowyTytul', page_content='$nowaZawartosc', status='$nowyStatus' WHERE id='$id'";

//     // Wykonanie zapytania
//     if ($conn->query($query) === TRUE) {
//         echo "Wpis został zaktualizowany pomyślnie.";
//     } else {
//         echo "Błąd podczas aktualizacji wpisu: " . $conn->error;
//     }

//     // Zamknięcie połączenia
//     $conn->close();
// }

// // Funkcja dodająca nowy wpis
// function dodajNowyWpis($tytul, $zawartosc, $status) {
//     // Dane do połączenia z bazą danych
//     $dbhost = 'localhost';
//     $dbuser = 'root';
//     $dbpass = '';
//     $baza = 'moja_strona';

//     // Nawiązanie połączenia z bazą danych
//     $conn = new mysqli($dbhost, $dbuser, $dbpass, $baza);

//     if ($conn->connect_error) {
//         die("Połączenie nieudane: " . $conn->connect_error);
//     }

//     // Sprawdzenie, czy baza danych została wybrana poprawnie
//     if (!mysqli_select_db($conn, $baza)) {
//         die("Nie udało się wybrać bazy danych: " . mysqli_error($conn));
//     }

//     // Escapowanie danych przed zapytaniem SQL
//     $tytul = $conn->real_escape_string($tytul);
//     $zawartosc = $conn->real_escape_string($zawartosc);
//     $status = $conn->real_escape_string($status);

//     // Zapytanie dodające nowy wpis do bazy danych
//     $query = "INSERT INTO page_list (page_title, page_content, status) VALUES ('$tytul', '$zawartosc', '$status')";

//     // Wykonanie zapytania
//     if ($conn->query($query) === TRUE) {
//         echo "Nowy wpis został dodany pomyślnie.";
//     } else {
//         echo "Błąd podczas dodawania nowego wpisu: " . $conn->error;
//     }

//     // Zamknięcie połączenia
//     $conn->close();
// }

// // Funkcja usuwająca wpis
// function usunWpis($id) {
//     // Dane do połączenia z bazą danych
//     $dbhost = 'localhost';
//     $dbuser = 'root';
//     $dbpass = '';
//     $baza = 'moja_strona';

//     // Nawiązanie połączenia z bazą danych
//     $conn = new mysqli($dbhost, $dbuser, $dbpass, $baza);

//     if ($conn->connect_error) {
//         die("Połączenie nieudane: " . $conn->connect_error);
//     }

//     // Sprawdzenie, czy baza danych została wybrana poprawnie
//     if (!mysqli_select_db($conn, $baza)) {
//         die("Nie udało się wybrać bazy danych: " . mysqli_error($conn));
//     }

//     // Escapowanie danych przed zapytaniem SQL
//     $id = $conn->real_escape_string($id);

//     // Zapytanie usuwające wpis z bazy danych
//     $query = "DELETE FROM page_list WHERE id='$id'";

//     // Wykonanie zapytania
//     if ($conn->query($query) === TRUE) {
//         echo "Wpis został usunięty pomyślnie.";
//     } else {
//         echo "Błąd podczas usuwania wpisu: " . $conn->error;
//     }

//     // Zamknięcie połączenia
//     $conn->close();
// }

// // Obsługa formularza edycji, dodawania, usuwania wpisu
// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['operacja'])) {
//     $operacja = $_POST['operacja'];
//     $id = isset($_POST['id']) ? $_POST['id'] : '';
//     $nowyTytul = isset($_POST['nowy_tytul']) ? $_POST['nowy_tytul'] : '';
//     $nowaZawartosc = isset($_POST['nowa_zawartosc']) ? $_POST['nowa_zawartosc'] : '';
//     $nowyStatus = isset($_POST['nowy_status']) ? $_POST['nowy_status'] : '';

//     // Wywołanie odpowiedniej funkcji w zależności od operacji
//     switch ($operacja) {
//         case 'edytuj':
//             edytujWpis($id, $nowyTytul, $nowaZawartosc, $nowyStatus);
//             break;
//         case 'dodaj':
//             dodajNowyWpis($nowyTytul, $nowaZawartosc, $nowyStatus);
//             break;
//         case 'usun':
//             usunWpis($id);
//             break;
//         default:
//             echo "Nieznana operacja";
//     }
// }

// // Funkcja wylogowująca użytkownika
// function Wyloguj()
// {
//     session_destroy();
// }
?>