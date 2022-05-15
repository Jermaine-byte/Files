<?php
session_start();
require 'database.php';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Wedstrijd toevoegen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
//dit is een beveiliging die checkt of de administrator ingelogd is, als hij dat is krijgt hij het onderstaande formulier te zien
if ($_SESSION['voornaam'] == "admin")
{
    include_once 'header.php';
    ?>
    <div class="content loginBoxDiv mt-5 mb-5">
        <div class="col-sm-8 col-md-5 col-lg-5 col-xl-3 col-12 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form class="px-4 py-3" method="post" enctype="multipart/form-data">
                        <p><b><i>Wedstrijd toevoegen</i></b></p>
                        <div class="form-group">
                            <label for="e">Wedstrijdnaam:</label>
                            <input type="text" name="wedstrijdNaam" class="form-control" id="wedstrijdNaam">
                            <label for="e">Datum:</label>
                            <input type="date" name="datum" class="form-control" id="datum">
                            <label for="e">Begintijd:</label>
                            <input type="time" name="beginTijd" class="form-control" id="beginTijd">
                            <label for="e">Afstand:</label>
                            <select name="afstand" class="form-control">
                                <option value="disabled" selected disabled>Selecteer een afstand</option>
                                <option value="100">100 meter</option>
                                <option value="500">500 meter</option>
                                <option value="1000">1000 meter</option>
                                <option value="1500">1500 meter</option>
                                <option value="3000">3000 meter</option>
                                <option value="5000">5000 meter</option>
                                <option value="10000">10000 meter</option>
                            </select>
                        </div>
                        <button type="submit" id="submit" name="submit" class="btn btn-primary">AANMAKEN</button>
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
        if (strlen($wedstrijdNaam) != 0 && strlen($datum) != 0 && strlen($beginTijd) != 0 && strlen($afstand) != 0)
        {
            //Met deze onderstaande query wordt de informatie in de database toegevoegd.
            $query = "INSERT INTO `wedstrijd`  (`id_wedstrijd`, `wedstrijdNaam` , `datum`, `beginTijd`, `afstand`) VALUES (NULL, '$wedstrijdNaam', '$datum', '$beginTijd', '$afstand')";
            if (mysqli_query($mysqli, $query))
            {
                //Het onderstaande stukje code is wat je te zien krijgt als het aanmaken gelukt is.
                ?>
                <div class="alert alert-success" role="alert">
                    <p>Het toevoegen van je wedstijd is gelukt! Als je wil kan je gelijk nog een wedstrijd toevoegen.</p>
                    <button type="button" name="verder" class="btn btn-primary mx-auto" onclick="window.location.href='index.php'">
                        terug naar algemene pagina
                    </button>
                </div>
                <?php
            }
            else
            {
                echo "<p>Er is een fout opgetreden!</p>";
            }
        } else {
            ?>
    <script>
        alert('Niet alle velden zijn ingevuld!');
    </script>
    <?php
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>