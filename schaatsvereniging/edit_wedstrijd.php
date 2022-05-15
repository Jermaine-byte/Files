<?php
session_start();
require 'database.php';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Wedstrijd aanpassen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
//dit is een beveiliging die checkt of de administrator ingelogd is, als hij dat is krijgt hij het onderstaande formulier te zien
if ($_SESSION['voornaam'] == "admin")
{
    include_once 'header.php';
    // Het onderstaande stukje code is voor het geselecteerde id uit de sessie te halen en dat dan in de query te zetten
    $id_wedstrijd = $_GET['id_wedstrijd'];
    $getQuery = "SELECT * FROM wedstrijd WHERE id_wedstrijd = " . $id_wedstrijd;
    $result = mysqli_query($mysqli, $getQuery);
    if (mysqli_num_rows($result) == 0)
    {
        echo "<p>De informatie over wedstrijd met id $id_wedstrijd bestaat niet.</p>";
    }
    else
    {
        $rij = mysqli_fetch_array($result);
        // Op de plekken van value staat een stukje php code waarbij de value wordt gevuld met de waardes die in de database staan
        ?>
        <div class="content loginBoxDiv mt-5 mb-5">
            <div class="col-sm-8 col-md-5 col-lg-5 col-xl-3 col-12 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <form class="px-4 py-3" method="post" enctype="multipart/form-data">
                            <p><b><i>School toevoegen</i></b></p>
                            <div class="form-group">
                                <input type="hidden" name="id_wedstrijd" value="<?php echo $id_wedstrijd; ?>";
                                <label for="e">Wedstrijdnaam:</label>
                                <input type="text" name="wedstrijdNaam" class="form-control" id="wedstrijdNaam" value="<?php echo $rij['wedstrijdNaam']; ?>">
                                <label for="e">Datum:</label>
                                <input type="date" name="datum" class="form-control" id="datum" value="<?php echo $rij['datum']; ?>">
                                <label for="e">Begintijd:</label>
                                <input type="time" name="beginTijd" class="form-control" id="beginTijd" value="<?php echo $rij['beginTijd']; ?>">
                                <label for="e">Afstand:</label>
                                <select name="afstand" class="form-control">
                                    <option value="disabled" disabled>Selecteer een afstand</option>
                                    <option value="100" <?php if ($rij['afstand'] == 100) {echo 'selected';}?>>100 meter</option>
                                    <option value="500" <?php if ($rij['afstand'] == 500) {echo 'selected';}?>>500 meter</option>
                                    <option value="1000" <?php if ($rij['afstand'] == 1000) {echo 'selected';}?>>1000 meter</option>
                                    <option value="1500" <?php if ($rij['afstand'] == 1500) {echo 'selected';}?>>1500 meter</option>
                                    <option value="3000" <?php if ($rij['afstand'] == 3000) {echo 'selected';}?>>3000 meter</option>
                                    <option value="5000" <?php if ($rij['afstand'] == 5000) {echo 'selected';}?>>5000 meter</option>
                                    <option value="10000" <?php if ($rij['afstand'] == 10000) {echo 'selected';}?>>10000 meter</option>
                                </select>
                            </div>
                            <button type="submit" id="submit" name="submit" class="btn btn-primary">AANPASSEN</button>
                        </form>
                        <div class="dropdown-divider"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        // dit stuk code is het deel om wat je in het formulier ingevuld hebt toe te voegen aan de database
        if (isset($_POST['submit']))
        {
            //de onderstaande 5 regels zijn de variabelen die uit het formulier de ingevulde informatie haalt.
            $id_wedstrijd = $_POST['id_wedstrijd'];
            $wedstrijdNaam = $_POST['wedstrijdNaam'];
            $datum = $_POST['datum'];
            $beginTijd = $_POST['beginTijd'];
            $afstand = $_POST['afstand'];
            //Met deze onderstaande query wordt de informatie in de database toegevoegd.
            $query = "UPDATE `wedstrijd` SET `wedstrijdNaam` = '$wedstrijdNaam', `datum` = '$datum', `beginTijd` = '$beginTijd', `afstand` = '$afstand' WHERE `id_wedstrijd` = '$id_wedstrijd'";
//            echo $query;
            if (mysqli_query($mysqli, $query))
            {
                header("location: index.php");
            }
            else
            {
                echo "<p>Er is een fout opgetreden!</p>";
            }
        }
    }
}
if ($_SESSION['voornaam'] != "admin")
{
    //Dit is de tweede helft van de beveiliging. Als het account niet ingelogd is als admin krijg je het onderstaande te zien, verder niks.
    ?>
    <div class="container">
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Geen Rechten</h4>
            <p>Je hebt niet de rechten om informatie aan te passen aan wedstrijden. Als je admin bent probeer dan in te loggen, anders ga naar de algemene pagina</p>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>