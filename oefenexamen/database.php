<?php
// database Logingegevens
$db_hostname = '127.0.0.1'; //localhost of '127.0.0.1'
$db_username = '84645';
$db_password = '#1Geheim';
$db_database = '84645_examen';

// maak de database-verbinding
$mysqli = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);

if (!$mysqli) {
    echo "FOUT: geen connectie naar database. <br>";
    echo "Errno: " . mysqli_connect_errno() . "<br/>";
    echo "Error: " . mysqli_connect_error() . "<br/>";
    exit;
}