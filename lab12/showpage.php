<?php
// Plik do pokazywania podstron
function PokazPodstrone($id)
{
    // Zabezpieczenie przed atakami XSS
    $id_clear = htmlspecialchars($id);

    // Dołączenie pliku konfiguracyjnego
    include("./cfg.php");

    // Zapytanie SQL do pobrania treści strony o danym ID
    $query = "SELECT * FROM page_list WHERE id = ? LIMIT 1";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, 's', $id_clear);
    mysqli_stmt_execute($stmt);

    // Pobranie wyników zapytania
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);

    // Sprawdzenie, czy strona o podanym ID istnieje
    if (empty($row['id'])) {
        $web = '[nie_znaleziono_strony]';
    } else {
        $web = $row['page_content'];
    }

    // Zamknięcie połączenia z bazą danych
    mysqli_close($link);

    // Zwrócenie treści strony
    return $web;
}
?>