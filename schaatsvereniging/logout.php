<?php
//Eerst wordt de sessie gestart, zodat de bestaande sessie hier ook bestaat
session_start();
//Daarna wordt de sessie leeggemaakt
session_unset();
//Tot slot wordt de sessie verwijderd
session_destroy();
//Als dat allemaal gedaan is wordt je automatisch naar de index pagina gestuurd
header("location:index.php");
?>