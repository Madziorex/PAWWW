<?
 error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
 /* po tym komentarzu będzie kod do dynamicznego ładowania stron */
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
                    <h1><a href="index.html">Bestiariusz</a></h1>
                    <h2>Kilka potworów z gry "Wiedźmin 3: Dziki Gon"</h2>
                </div>
            </td>
        </tr>
        <tr>
            <td class="nav">
                <ul>
                    <li><a href="./html/bazyliszek.html">Bazyliszek</a></li>
                    <li><a href="./html/leszy.html">Leszy</a></li>
                    <li><a href="./html/him.html">Him</a></li>
                    <li><a href="./html/bies.html">Bies</a></li>
                    <li><a href="./html/poludnica.html">Południca</a></li>
                </ul>
            </td>
        </tr>
        <tr>
            <td class="inf_ogl">
                <!-- Treść strony wczytana z pliku glowna.html -->
                <?php include($strona); ?>
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
    </table>
    <?php
        $nr_indeksu = '164442';
        $nrGrupy = '4ISI';
        echo 'Autor: Magdalena Wojciechowska '.$nr_indeksu.' grupa '.$nrGrupy.' <br /><br />';
    ?>
</body>
</html>
