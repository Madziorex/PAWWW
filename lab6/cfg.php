<?php
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $baza = 'moja_strona';

    $link = mysqli_connect($dbhost, $dbuser, $dbpass, $baza);
    if(!$link){
        die('<b>przerwane połączenie</b>: '. mysqli_connect_error());
    }
    if(!mysqli_select_db($link, $baza)) echo 'nie wybrano bazy';
    mysqli_close($link);
?>