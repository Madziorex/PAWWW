<?php
// Rozpoczęcie sesji
session_start();

// Usunięcie wszystkich zmiennych sesyjnych
session_unset();

// Zniszczenie sesji
session_destroy();

// Przekierowanie na stronę główną (index.php)
header("Location: index.php");

// Zakończenie działania skryptu
exit();
?>