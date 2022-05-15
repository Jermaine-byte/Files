<?php
require 'database.php';
if (isset($_POST['submit']))
{
    $id = $_POST['id'];
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $klas = $_POST['klas'];
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $adres = $_POST['adres'];
    $postcode = $_POST['postcode'];
    $woonplaats = $_POST['woonplaats'];
    $leeftijd = $_POST['leeftijd'];
    $mail = $_POST['mail'];
    $wachtwoord = (md5($_POST['password']));
    $query = "INSERT INTO `inlog` (`id`, `gebruikersnaam`, `klas`, `voornaam`, `achternaam`, `adres`, `postcode`, `woonplaats`, `leeftijd`, `mail`, `wachtwoord`) VALUES (NULL, '$gebruikersnaam', '$klas', '$voornaam', '$achternaam', '$adres', '$postcode', '$woonplaats', '$leeftijd', '$mail', '$wachtwoord')";

    if(mysqli_query($mysqli, $query))
        {
            echo 'Registreren is gelukt';
            echo '<p><a href="inlog.php">Terug naar inlogpagina</a></p>';
        }
        else
        {
            echo "<p>Er is een fout opgetreden!</p>";
        }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registreer pagina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<div class="content loginBoxDiv mt-5 mb-5">
    <div class="col-sm-8 col-md-5 col-lg-5 col-xl-3 col-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <form class="px-4 py-3" method="post">
                    <p><b><i>Registreren als student</i></b></p>
                    <div class="form-group">
                        <label for="e">Leerlingnummer</label>
                        <input type="number" name="gebruikersnaam" class="form-control" id="gebruikersnaam" placeholder="12345" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.   (0, this.maxLength);" maxlength="5">
                    </div>
                    <div class="form-group">
                        <label for="e">Klas</label>
                        <input type="text" name="klas" class="form-control" id="klas" placeholder="D3C2">
                    </div>
                    <div class="form-group">
                        <label for="e">Voornaam</label>
                        <input type="text" name="voornaam" class="form-control" id="voornaam" placeholder="Kees">
                    </div>
                    <div class="form-group">
                        <label for="e">Achteraam</label>
                        <input type="text" name="achternaam" class="form-control" id="achternaam" placeholder="Smit">
                    </div>
                    <div class="form-group">
                        <label for="e">Adres</label>
                        <input type="text" name="adres" class="form-control" id="adres" placeholder="Vogellaan 12">
                    </div>
                    <div class="form-group">
                        <label for="e">Postcode</label>
                        <input type="text" name="postcode" class="form-control" id="postcode" placeholder="1234 AB">
                    </div>
                    <div class="form-group">
                        <label for="e">Woonplaats</label>
                        <input type="text" name="woonplaats" class="form-control" id="woonplaats" placeholder="Rotterdam">
                    </div>
                    <div class="form-group">
                        <label for="e">Leeftijd</label>
                        <input type="number" name="leeftijd" class="form-control" id="leeftijd" placeholder="18">
                    </div>
                    <div class="form-group">
                        <label for="e">Mail</label>
                        <input type="email" name="mail" class="form-control" id="mail" placeholder="12345@glr.nl ">
                    </div>
                    <div class="form-group">
                        <label for="password">Wachtwoord</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Wachtwoord ">
                    </div>
                    <div class="dropdown-divider"></div>
                    <button type="submit" name="submit" class="btn btn-primary">Aanmelden</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>