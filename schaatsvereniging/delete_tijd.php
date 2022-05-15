<?php
session_start();
require 'database.php';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>tijd verwijder pagina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
//De $_GET haald het informatie op van het eerder geselecteerde item. Daarna wordt het gebruikt om de query te kunnen gebruiken
$id_tijd = $_GET['id_tijd'];
$spelerNummer = $_GET['spelerNummer'];
$tijd = $_GET['Tijd'];
$query = "SELECT * FROM tijden WHERE id_tijd = " . $id_tijd;
$resultaat = mysqli_query($mysqli, $query);

if(mysqli_num_rows($resultaat) == 0)
{
    echo "<p>Er is geen tijd met id $id_tijd</p>";
}
else
{
$rij = mysqli_fetch_array($resultaat);
?>
<!--Dit is het formulier dat naar de verwerkpagina de informatie gaat sturen-->
<div class="container">
    <div class="alert alert-danger" role="alert">
        <p style="display: none"><?= $rij['id_tijd'] ?></p>
        <h4 class="alert-heading">U sure?</h4>
        <p>Weet je zeker dat je de tijd van speler: <p class="font-weight-bold text-monospace"><b>Spelernummer: <?= $rij['spelerNummer'] ?><br>Tijd: <?= $rij['Tijd'] ?> seconden</b></p> permanent uit het register wilt verwijderen?</p>
        <hr>
        <form action="delete_verwerk.php" method="post">
            <input type="text" name="id_tijd" readonly value="<?= $rij['id_tijd'] ?>" style="display: none">
            <button type="submit" name="submitT" class="btn btn-warning">VERWIJDEREN</button>
            <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">TO INDEX</button>
        </form>
        <?php
        }
        ?>
    </div>
</div>
<?php
include_once 'footer.php';
?>
</body>
</html>