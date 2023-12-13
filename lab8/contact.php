<?php
    function PokazKontakt(){
        
    }
    
    function WyslijMailaKontakt(){
        if(empty($_POST['temat']) || empty($_POST['tresc']) || empty($_POST['email'])){
            echo '[nie_wypelniles_pola]';
            echo PokazKontakt();
        }
        else
        {
            $mail['subject'] = $_POST['temat'];
            $mail['budy'] = $_POST['tresc'];
            $mail['sender'] = $_POST['email'];
            $mail['reciptient'] = $odbiorca;

            $header = "From: Formularz kontaktowy <".$mail['sender'].">\n";
            $header .= "MIME-Version: 1.0\nContent-Type: text/plain; charset=utf-8\nContent-Transfer-Encoding";
            $header .= "X-Sender: <".$mail['sender'].">\n";
            $header .= "X-Mailer: PRapWWW mail 1.2\n";
            $header .= "X-Priority: 3\n";
            $header .= "Return-Path: <".$mail['sender'].">\n";

            mail($mail['reciptient'],$mail['subject'],$mail['body'],$header);

            echo '[wiadomosc_wyslana]';
        }
    }

    function PrzypomnijHaslo(){

    }
?>