<?php
session_start();
require 'database.php';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Enquete verwijderen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">    <link rel="stylesheet" href="footer.css">
</head>
<body>
<?php
if (isset($_POST['submit']))
{
    $enquete_id = $_POST['enquete_id'];
    $student = $_POST['student'];
    $query = "DELETE FROM enquete WHERE enquete_id = " . $enquete_id;

    if(mysqli_query($mysqli, $query))
    {
        echo '<p>Het verwijderen van de enquete van student ' . $student . ' is gelukt</p>';
    }
    else
    {
        echo '<p>FOUT bij het verwijderen van de enquete van student ' . $student . '</p>';
    }
}
else
{
    echo '<p>Geen gegevens ontvangen...</p>';
}

if ($_SESSION != true)
{
    echo '<h3>Je moet ingelogd zijn om de enquete in te kunnen vullen, probeer alstublieft <a href="inlog.php">in te loggen</a></h3>';
}
?>
<p><a href="enquete.php">TERUG</a> naar enquete overzicht</p>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>