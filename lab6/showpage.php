<?php
function PokazPodstrone($id)
{
    $id_clear = htmlspecialchars($id);

    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'moja_strona';
    $link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if (!$link) {
        die('Nie uda³o siê po³¹czyæ z baz¹ danych: ' . mysqli_connect_error());
    }

    $query = "SELECT * FROM page_list WHERE id = ? LIMIT 1";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, 's', $id_clear);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);

    if(empty($row['id']))
    {
        $web = '[nie_znaleziono_strony]';
    }
    else
    {
        $web = $row['page_content'];
    }

    mysqli_close($link);
    return $web;
}
?>