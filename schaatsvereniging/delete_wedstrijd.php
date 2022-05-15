<?php
session_start();
require 'database.php';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>wedstrijd verwijder pagina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
if ($_SESSION['voornaam'] == "admin")
{
    // met de volgende 2 regels code haal ik het id op dat ik nodig heb om te verwijderen
    // & ik haal de naam op voor een beetje extra bevestiging
        $id_wedstrijd = $_GET['id_wedstrijd'];
        $wedstrijdNaam = $_GET['wedstrijdNaam'];
        $query = "SELECT * FROM wedstrijd WHERE id_wedstrijd = " . $id_wedstrijd;
        $resultaat = mysqli_query($mysqli, $query);

        if(mysqli_num_rows($resultaat) == 0)
        {
            echo "<p>Er is geen wedstrijd met id $id_wedstrijd</p>";
        }
        else
        {
            $rij = mysqli_fetch_array($resultaat);
            ?>
            <div class="container">
            <div class="alert alert-danger" role="alert">
            <p style="display: none"><?= $rij['id_wedstrijd'] ?></p>
            <h4 class="alert-heading">U sure?</h4>
            <p>Weet je zeker dat je skill: <p class="font-weight-bold text-monospace"><?= $rij['wedstrijdNaam'] ?></p> permanent uit het register wilt verwijderen?</p>
            <hr>
            <form action="delete_verwerk.php" method="post">
                <input type="text" name="id_wedstrijd" readonly value="<?= $rij['id_wedstrijd'] ?>" style="display: none">
                <button type="submit" name="submitW" class="btn btn-warning">VERWIJDEREN</button>
                <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">TO INDEX</button>
            </form>
            <?php
        }
        ?>
    </div>
    </div>
<?php
}
if ($_SESSION['voornaam'] != "admin")
{
    //Dit is de tweede helft van de beveiliging. Als het account niet ingelogd is als admin krijg je het onderstaande te zien, verder niks.
    ?>
    <div class="container">
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Geen Rechten</h4>
            <p>Je hebt niet de rechten om informatie toe te voegen aan wedstrijden. Als je admin bent probeer dan in te loggen, anders ga naar de algemene pagina</p>
            <hr>
            <form>
                <button type="button" name="terug" class="btn btn-warning mx-auto" onclick="window.location.href='login.php'">inloggen</button>
                <button type="button" name="terug" class="btn btn-primary mx-auto" onclick="window.location.href='index.php'">Terug naar Algemeen</button>
            </form>
        </div>
    </div>
    <?php
}
include_once 'footer.php';
?>
</body>
</html>