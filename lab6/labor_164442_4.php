<?php
    $nr_indeksu = '164442';
    $nrGrupy = '4';

    echo 'Magdalena Wojciechowska '.$nr_indeksu.' grupa '.$nrGrupy.' <br /><br />';

    echo 'Zastosowanie metody include() <br />';
    include 'test.php';
    echo "A $color $fruit<br /><br />";

    echo 'Zastosowanie metody require_once() <br />';
    $s = require_once('test.php');
    echo "\n".$s.'<br /><br />';

    echo 'Zastosowanie warunków if(), else(), elseif() <br />';
    $a = 25;
    $b = 26;
    if ($a > $b) {
        echo "a jest większe od b<br /><br />";
    } elseif ($a == $b) {
        echo "a jest równe b<br /><br />";
    } else {
        echo "a jest mniejsze od b<br /><br />";
    }
    
    echo 'Zastosowanie warunku switch() <br />';
    $i = 2;
    switch ($i) {
        case 0:
            echo "i jest równe 0<br /><br />";
            break;
        case 1:
            echo "i jest równe 1<br /><br />";
            break;
        case 2:
            echo "i jest równe 2<br /><br />";
            break;
    }

    echo 'Zastosowanie warunków while() <br />';
    $i = 1;
    while ($i <= 10):
        echo "$i ";
        $i++;
    endwhile;
    echo '<br /><br />';

    echo 'Zastosowanie warunków for() <br />';
    for ($i = 1; $i <= 10; $i++) {
        echo "$i ";
    }
    echo '<br /><br />';

    echo 'Typ zmiennych $_GET (dopisz do linku "?name=imie") <br />';
    echo 'Hello ' . htmlspecialchars($_GET["name"]) . '!<br /><br />';

    echo 'Typ zmiennych $_POST <br />';
    echo 'Hello ' . htmlspecialchars($_POST["names"]) . '!<br /><br />';

    echo 'Typ zmiennych $_SESSION<br />';
    $value = 4;
    $updatedvalue = 7;
    session_start();
    $_SESSION["newsession"]=$value;
    echo $_SESSION["newsession"].'<br />';
    $_SESSION["newsession"]=$updatedvalue;
    echo $_SESSION["newsession"].'<br/>';
    unset($_SESSION["newsession"]);
?>