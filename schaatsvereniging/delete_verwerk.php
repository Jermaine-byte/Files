<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
require 'database.php';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>verwijderen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
//Dit is de eerste helft van het verwerken voor het verwijderen. Dit deel is voor een wedstrijd te verwijderen, dat kan je het best zien aan `submitW`
if (isset($_POST['submitW']))
{
    $id_wedstrijd = $_POST['id_wedstrijd'];
    $query = "DELETE FROM wedstrijd WHERE id_wedstrijd = " . $id_wedstrijd;
    $queryD = "DELETE FROM tijden WHERE id_wedstrijd = " . $id_wedstrijd;


    if (mysqli_query($mysqli, $queryD))
    {
        if (mysqli_query($mysqli, $query))
        {
        // Dit deel krijg je te zien als het verwijderen gelukt is
        ?>
        <div class="alert alert-success" role="alert">
            <p>Het verwijderen van je wedstrijd & gekoppelde tijden is gelukt</p>
            <button type="button" name="verder" class="btn btn-primary mx-auto" onclick="window.location.href='index.php'">
                Terug naar algemene pagina
            </button>
        </div>
        <?php
        }
        else
        {
            echo"<p>FOUT bij het verwijderen van wedstrijd: $id_wedstrijd.</p>";
            echo mysqli_error($mysqli);
        }
    }

    else
    {
        echo "<p>FOUT bij het verwijderen van de gekoppelde tijden van wedstrijd: $id_wedstrijd</p>";
        echo mysqli_error($mysqli);
    }

}

//Dit is de tweede helft van het verwerken voor het verwijderen. Dit deel is voor een tijd te verwijderen, dat kan je het best zien aan `submitT`
if (isset($_POST['submitT']))
{
    $id_tijd = $_POST['id_tijd'];
    $queryT = "DELETE FROM tijden WHERE id_tijd = ". $id_tijd;


    if (mysqli_query($mysqli, $queryT))
    {
        // Dit deel krijg je te zien als het verwijderen gelukt is
        ?>
        <div class="alert alert-success" role="alert">
            <p>Het verwijderen van je tijd is gelukt</p>
            <button type="button" name="verder" class="btn btn-primary mx-auto" onclick="window.location.href='index.php'">
                Terug naar algemene pagina
            </button>
        </div>
        <?php
    }

    else
    {
        echo"<p>FOUT bij het verwijderen van tijd: $id_tijd.</p>";
        echo mysqli_error($mysqli);
    }

}

include_once 'footer.php';
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>