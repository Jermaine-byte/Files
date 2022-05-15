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
if ($_SESSION == true && $_SESSION['voornaam'] != 'admin')
{
    include_once 'header.php';
    // Het onderstaande stukje code is voor het geselecteerde id uit de sessie te halen en dat dan in de query te zetten
    $id = $_GET['id'];
    $getQuery = "SELECT * FROM inlog WHERE id = " . $id;
    $result = mysqli_query($mysqli, $getQuery);
    if (mysqli_num_rows($result) == 0)
    {
        echo "<p>Er bestaat geen inforamtie met speler ID $id.</p>";
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
                                <input type="hidden" name="id" value="<?php echo $id; ?>";
                                <label for="e">Voornaam:</label>
                                <input type="text" name="voornaam" class="form-control" id="voornaam" value="<?php echo $rij['voornaam']; ?>">
                                <label for="e">Achternaam:</label>
                                <input type="text" name="achternaam" class="form-control" id="achternaam" value="<?php echo $rij['achternaam']; ?>">
                                <label for="e">Adres:</label>
                                <input type="text" name="adres" class="form-control" id="adres" value="<?php echo $rij['adres']; ?>">
                                <label for="e">Bankgegevens:</label>
                                <input type="text" name="bankgegevens" class="form-control" id="bankgegevens" value="<?php echo $rij['bankgegevens']; ?>">
                                <label for="e">Geslacht:</label>
                                <select name="geslacht" class="form-control">
                                    <option value="disabled" disabled>Selecteer een geslacht</option>
                                    <option value="M" <?php if ($rij['geslacht'] == "M") {echo 'selected';}?>>Man</option>
                                    <option value="V" <?php if ($rij['geslacht'] == "V") {echo 'selected';}?>>Vrouw</option>
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
            //de onderstaande paar regels zijn de variabelen die uit het formulier de ingevulde informatie haalt.
            $id = $_POST['id'];
            $voornaam = $_POST['voornaam'];
            $achternaam = $_POST['achternaam'];
            $adres = $_POST['adres'];
            $bankgegevens = $_POST['bankgegevens'];
            $geslacht = $_POST['geslacht'];
            //Met deze onderstaande query wordt de informatie in de database toegevoegd.
            $query = "UPDATE `inlog` SET `voornaam` = '$voornaam', `achternaam` = '$achternaam', `adres` = '$adres', `bankgegevens` = '$bankgegevens', `geslacht` = '$geslacht' WHERE `id` = '$id'";
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
if ($_SESSION == false)
{
    //Dit is de tweede helft van de beveiliging. Als het account niet ingelogd is als admin krijg je het onderstaande te zien, verder niks.
    ?>
    <div class="container">
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Geen Rechten</h4>
            <p>Je hebt niet de rechten om informatie van dit persoon aan te passen. Als je de eigenaar bent van dit account probeer dan in te loggen, anders ga naar de algemene pagina</p>
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