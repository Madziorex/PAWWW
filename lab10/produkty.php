<?php
// Inicjalizacja sesji
session_start();

// Raportowanie błędów
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

// Dołączanie plików konfiguracyjnych
include('./cfg.php');
include('./showpage.php');
include('./admin/admin.php');

// Definiowanie idp
if ($_GET['idp'] == '') {
    $strona = PokazPodstrone(1);
}
if ($_GET['idp'] == 'bazyliszek') {
    $strona = PokazPodstrone(2);
}
if ($_GET['idp'] == 'leszy') {
    $strona = PokazPodstrone(3);
}
if ($_GET['idp'] == 'him') {
    $strona = PokazPodstrone(4);
}
if ($_GET['idp'] == 'bies') {
    $strona = PokazPodstrone(5);
}
if ($_GET['idp'] == 'poludnica') {
    $strona = PokazPodstrone(6);
}
if ($_GET['idp'] == 'filmy') {
    $strona = PokazPodstrone(7);
}
if ($_GET['idp'] == 'produkty') {
    $strona = PokazPodstrone(8);
}
if ($_GET['idp'] == 'admin') {
    if ($_SESSION['login'] == null || $_SESSION['pass'] == null) {
        $strona = FormularzLogowania();
    } elseif ($_SESSION['login'] != $login || $_SESSION['pass'] != $pass) {
        echo '<div class="zalogowany">Login albo hasło są błędne</div>';
        $strona = FormularzLogowania();
    } else {
        echo '<div class="zalogowany">ZALOGOWANY DO ADMINA</div>
            <form action="wyloguj.php" method="post">
                <input type="submit" value="Wyloguj">
            </form>';
        $strona = ListaPodstron($link);
    }
}
?>
<!DOCTYPE html>
<html lang="PL">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="pl" />
    <meta name="Author" content="Magdalena Wojciechowska" />
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="./js/kolorujtlo.js"></script>
    <script src="./js/timedate.js" type="text/javascript"></script>
    <title>Bestiariusz</title>
</head>
<body onload="startclock()">
    <table>
        <tr>
            <td class="title">
                <div>
                    <h5><i>Moje hobby to gry, więc dałam coś z "Wiedźmina 3"</i></h5>
                    <h1><a href="./index.php">Bestiariusz</a></h1>
                    <h2>Kilka potworów z gry "Wiedźmin 3: Dziki Gon"</h2>
                </div>
            </td>
        </tr>
        <tr>
            <td class="nav">
                <ul>
                    <li><a href="./index.php?idp=bazyliszek">Bazyliszek</a></li>
                    <li><a href="./index.php?idp=leszy">Leszy</a></li>
                    <li><a href="./index.php?idp=him">Him</a></li>
                    <li><a href="./index.php?idp=bies">Bies</a></li>
                    <li><a href="./index.php?idp=poludnica">Południca</a></li>
                    <li><a href="./index.php?idp=filmy">Filmy</a></li>
                    <li><a href="./produkty.php">Produkty</a></li>
                </ul>
            </td>
        </tr>
        <tr>
            <td class="inf_ogl">
                <?php
                    include("./cfg.php");

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
                        $query = "SELECT * FROM produkty WHERE matka=0 LIMIT 100";
                        
                        $result = mysqli_query($connection, $query);
                    
                        if (!$result) {
                            die("Błąd zapytania: " . mysqli_error($connection));
                        }
                    
                        $output = '<table><tr><td><div class="lista_kategorii"><table>';
                    
                        while ($row = mysqli_fetch_assoc($result)) {
                            $output .= '<tr class="srodek"><td>' . $row['id'] . ' ' . $row['nazwa'] . '</td></tr>';
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
            </td>
        </tr>
        <tr>
            <td class="kolor">
                <form method="POST" name="background">
                    <input type="button" value="żółty" onclick="changeBackground ('#FFF000')">
                    <input type="button" value="czarny" onclick="changeBackground ('#000000')">
                    <input type="button" value="biały" onclick="changeBackground ('#FFFFFF')">
                    <input type="button" value="zielony" onclick="changeBackground('#00FF00')">
                    <input type="button" value="niebieski" onclick="changeBackground ('#0000FF')">
                    <input type="button" value="pomarańczowy" onclick="changeBackground ('#FF8000')">
                    <input type="button" value="szary" onclick="changeBackground ('#c0c0c0')">
                    <input type="button" value="czerwony" onclick="changeBackground ('#FF0000')">
                    <input type="button" value="original" onclick="changeBackground ('#500d0d')">
                </form>
            </td>
        </tr>
        <tr>
            <td class="czas">
                <div>
                    <div id="zegarek"></div>
                    <div id="data"></div>
                </div>
            </td>
        </tr>
        <tr>
            <td class="animacje">
                <div id="animacjaTestowa1" class="test-block">Kliknij, a się powiększe</div>
                <script>
                    $("#animacjaTestowa1").on("click", function(){
                        $(this).animate({
                            width: "500px",
                            opacity: 0.4,
                            fontSize: "3em",
                            borderWidth: "10px"
                        }, 1500);
                    });
                </script>
            </td>
        </tr>
        <tr>
            <td class="animacje">
                <div id="animacjaTestowa2" class="test-block">Najedź kursorem, a się powiększę</div>
                <script>
                    $("#animacjaTestowa2").on({
                        "mouseover" : function() {
                            $(this).animate({
                                width: 300
                            }, 800);
                        },
                        "mouseout" : function() {
                            $(this).animate({
                                width: 200
                            }, 800);
                        }
                    });
                </script>
            </td>
        </tr>
        <tr>
            <td class="animacje">
                <div id="animacjaTestowa3" class="test-block">Kliknij, abym urósł</div>
                <script>
                    $("#animacjaTestowa3").on("click", function(){
                        if (!$(this).is(":animated")) {
                            $(this).animate({
                                width: "+=" + 50,
                                height: "+=" + 10,
                                opacity: "-=" + 0.1
                            }, 3000);
                        }
                    });
                </script>
            </td>
        </tr>
        <tr class="kontakty">
            <td>
                <h2><u>Kontakt</u></h2>
                    <form action="mailto:164442@student.uwm.edu.pl" method="post" enctype="text/plain">
                        Imię: <input type="text" name="imie"><br>
                        Email: <input type="email" name="email"><br>
                        Wiadomość:<br>
                    <textarea name="wiadomosc" rows="5" cols="40"></textarea><br>
                    <input type="submit" value="Wyślij">
                    </form>
            </td>
        </tr>
    </table>
    <?php
        $nr_indeksu = '164442';
        $nrGrupy = '4ISI';
        echo 'Autor: Magdalena Wojciechowska '.$nr_indeksu.' grupa '.$nrGrupy.' <br /><br />';
    ?>
</body>
</html>
