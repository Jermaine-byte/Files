<?php
session_start();
require 'database.php';
$id_bestelling = $_GET['id_bestelling'];
$Getquery = "SELECT * FROM bestelling WHERE id_bestelling = " . $id_bestelling;
var_dump($id_bestelling);
$result = mysqli_query($mysqli, $Getquery);
    if (mysqli_num_rows($result) == 0)
    {
        echo "<p>Er bestaat geen bestelling met ID $id_bestelling.</p>";
    }
    else
    {
        var_dump($id_bestelling);
        $query = "UPDATE bestelling SET status = 'verzonden' WHERE id_bestelling = '$id_bestelling'";
        if (mysqli_query($mysqli, $query))
        {
            header("location:verzendAfdeling.php");
        }
        else
        {
            echo '<p>Er is een fout opgetreden</p>';
        }
    }
?>