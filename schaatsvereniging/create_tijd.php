<?php
session_start();
require 'database.php';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>tijd toevoegen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
//dit is een beveiliging die checkt of de administrator ingelogd is, als hij dat is krijgt hij het onderstaande formulier te zien
if ($_SESSION['voornaam'] == 'admin')
{
    include_once 'header.php'
    ?>
    <div class="content loginBoxDiv mt-5 mb-5">
        <div class="col-sm-8 col-md-5 col-lg-5 col-xl-3 col-12 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form class="px-4 py-3" method="post" enctype="multipart/form-data">
                        <p><b><i>Tijd toevoegen</i></b></p>
                        <div class="form-group">
                            <select name="afstand" class="form-control" hidden>
                                <?php
                                $id_wedstrijd = $_GET['id_wedstrijd'];
                                $game = "SELECT * FROM wedstrijd WHERE id_wedstrijd = " . $id_wedstrijd;
                                $gameResult = mysqli_query($mysqli, $game);
                                while ($gameM = mysqli_fetch_array($gameResult))
                                {
                                    echo '<option value="' . $gameM['afstand'] . '" selected>' . $gameM['afstand'] . ' meter' . '</option>';
                                }
                                ?>
                            </select>
                            <select name="wedstrijdNaam" class="form-control" hidden>
                                <option selected disabled>Selecteer een wedstrijd</option>
                                <?php
                                // met deze php code ga ik naar de tabel van wedstrijden en haal ik er de naam van de bijbehorende webstite uit
                                $id_wedstrijd = $_GET['id_wedstrijd'];
                                $taskGame = "SELECT * FROM wedstrijd WHERE id_wedstrijd = " . $id_wedstrijd;
                                $resultGame = mysqli_query($mysqli, $taskGame);
                                while ($id_wedstrijd= mysqli_fetch_array($resultGame))
                                {
                                    echo '<option value="' . $id_wedstrijd['id_wedstrijd'] . '" selected>' . $id_wedstrijd['wedstrijdNaam'] . '</option>';
                                }
                                ?>
                            </select>
                            <label for="e">Speler:</label>
                            <select name="spelerNummer" class="form-control">
                                <option selected disabled>Selcteer een speler</option>
                                <?php
                                // met deze php code ga ik naar de tabel van tijden en daar haal ik ieder spelernummer op dat boven de 0 is
                                $taskPlayer = "SELECT * FROM inlog WHERE spelerNummer > 0";
                                $resultPlayer = mysqli_query($mysqli, $taskPlayer);
                                while ($spelerNummer = mysqli_fetch_array($resultPlayer))
                                {
                                    echo '<option value="' . $spelerNummer['spelerNummer'] . '">' . $spelerNummer['spelerNummer'] . '</option>';
                                }
                                ?>
                            </select>
                            <label for="e">Tijd in seconde:</label>
                            <input type="text" name="Tijd" class="form-control" id="Tijd" placeholder="37,5">
                        </div>
                        <button type="submit" id="submit" name="submit" class="btn btn-primary">AANMAKEN</button>
                    </form>
                    <div class="dropdown-divider"></div>
                </div>
            </div>
        </div>
    </div>
    <?php
    if (isset($_POST['submit']))
    {
        $id_tijd = $_POST['id_tijd'];
        $afstand = $_POST['afstand'];
        $id_wedstrijd = $_POST['wedstrijdNaam'];
        $spelerNummer = $_POST['spelerNummer'];
        $Tijd = $_POST['Tijd'];
        if (strlen($spelerNummer) != 0 && strlen($Tijd) != 0)
        {
            $query = "INSERT INTO `tijden` (`id_tijd`, `afstand`, `id_wedstrijd`, `spelerNummer`, `Tijd`) VALUES (NULL, '$afstand', '$id_wedstrijd', '$spelerNummer', '$Tijd')";
            if (mysqli_query($mysqli, $query))
            {
                ?>
                <div class="alert alert-success" role="alert">
                    <p>Het toevoegen van uw tijd is gelukt! Als u wilt kunt u gelijk nog een tijd toevoegen.</p>
                    <button type="button" name="verder" class="btn btn-primary mx-auto" onclick="window.location.href='index.php'">
                        Terug naar algemene pagina
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
    //dit is de tweede helf van de beveiliging. Als het account niet ingelogd is als admin krijg je het onderstaande te zien, verder niks.
    ?>
    <div class="container">
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Geen Rechten</h4>
            <p>Je hebt niet de rechten om informatie toe te voegen aan tijden. Als je admin bent probeer dan in te loggen, anders ga naar de algemene pagina</p>
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
