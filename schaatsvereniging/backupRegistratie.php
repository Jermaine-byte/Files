<?php
require 'database.php';
include_once 'header.php';
//Dit registreer systeem is verdeeld in 2 delen. Het eerste deel is om in de login tabel bepaalde informatie op te slaan & het tweede deel is om bepaalde informatie in de speler tabel op te slaan
if (isset($_POST['submit']))
{
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $email = $_POST['email'];
    //Voor een spelernummer te bepalen wordt er tussen de 1 en 500 een willekeurig nummer gekozen
    $spelernummer = rand(1, 500);
    $adres = $_POST['adres'];
    $bankgegevens = $_POST['bankgegevens'];
    $geslacht = $_POST['geslacht'];
    $geboortedatum = $_POST['geboortedatum'];
    //variabele $today pakt de dag van vandaag
    $today = date("Y-m-d");
    // variabele diff vergelijkt de geboortedatum met de datum van vandaag. Met een bepaalde formule kan dit een leeftijd up-to-date berekenen
    $diff = date_diff(date_create($geboortedatum), date_create($today));
    //Het format bepaald als wat het eruit moet komen, in dit geval komt het als een jaar eruit.
    $leeftijd = $diff->format('%y');
    $wachtwoord = (md5($_POST['password']));
    //Dit is het eerste deel waar ik het eerder over had, er wordt bepaalde informatie in de tabel inlog opgeslagen
    $query = "INSERT INTO `inlog` (`id`, `voornaam`, `achternaam`, `email`, `wachtwoord`) VALUES (NULL, '$voornaam', '$achternaam', '$email', '$wachtwoord')";

    //Als het eerste deel goed gegaan is ga je verder naar het tweede deel van de registratie
    if(mysqli_query($mysqli, $query))
    {
        //Hier wordt de overige informatie inclusief de voor- en achternaam in de tabel van speler opgeslagen
        $player = "INSERT INTO `speler` (`id_speler`, `voornaam`, `achternaam`, `spelerNummer`, `adres`, `bankgegevens`, `geslacht`, `startLidmaatschap`, `geboortedatum`) VALUES (NULL, '$voornaam', '$achternaam', '$spelernummer', '$adres', '$bankgegevens', '$geslacht', '$today', '$geboortedatum')";
        if (mysqli_query($mysqli, $player))
        {
            ?>
            <!--                Dit is een soort alert die je krijgt als alles goed gegaan is. Dit bevestig de informatie dat het account aanmaken gelukt is met de vraag-->
            <script>
                if (window.confirm('Het registreren is gelukt, druk op `OK` om verder te gaan naar het inlogscherm'))
                {
                    window.location.href='https://84645.ict-lab.nl/schaatsvereniging/login.php';
                };
            </script>
            <?php
//            echo ' & het toevoegen van de informatie is ook gelukt';
//            echo '<p><a href="inlog.php">Terug naar inlogpagina</a></p>';
        }
        else {
            //Dit is de alert die gegeven wordt als er iets fout gegaan is met het toevoegen van de informatie in de tabel speler
            // !heb geprobeerd om het voor elkaar te krijgen, maar het lukte niet. Heb voor de veiligheid het weggehaald
            ?>
            <script>
                alert("Er is een fout opgetreden met het toevoegen van de speler zijn informatie")
            </script>
            <?php
        }
    }
    else
    {
        //Dit is de alert die gegeven wordt als er iets fout gegaan is met het toevoegen van de informatie in de tabel inlog
        ?>
        <script>
            alert("Er is een fout opgetreden met het toevoegen van de speler zijn inloggegevens")
        </script>
        <?php
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
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="content loginBoxDiv mt-5 mb-5">
    <div class="col-sm-8 col-md-5 col-lg-5 col-xl-3 col-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <form class="px-4 py-3" method="post">
                    <p><b><i>Registreren</i></b></p>
                    <div class="form-group">
                        <label for="e">Voornaam:</label>
                        <input type="text" name="voornaam" class="form-control" id="voornaam" placeholder="Kees">
                        <label for="e">Achternaam:</label>
                        <input type="text" name="achternaam" class="form-control" id="achternaam" placeholder="Winters">
                        <label for="e">Email:</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="peterkroos@gmail.com">
                        <label for="e">Adres:</label>
                        <input type="text" name="adres" class="form-control" id="adres" placeholder="Vogellaan 45">
                        <label for="e">Bankgegevens:</label>
                        <input type="text" name="bankgegevens" class="form-control" id="bankgegevens">
                        <label for="e">Geboortedatum:</label>
                        <input type="date" name="geboortedatum" class="form-control" id="geboortedatum">
                        <label for="e">Geslacht:</label>
                        <select name="geslacht" class="form-control">
                            <option value="disabled" disabled selected>Selecteer een geslacht</option>
                            <option value="M">Man</option>
                            <option value="V">Vrouw</option>
                        </select>
                        <label for="password">Wachtwoord</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Wachtwoord ">
                    </div>
                    <div class="dropdown-divider"></div>
                    <button type="submit" name="submit" class="btn btn-primary">Aanmelden</button>
                    <button type="button" name="terug" class="btn btn-danger" onclick="document.location.href='index.php'">Terug</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include_once 'footer.php';
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>