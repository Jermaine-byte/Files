<?php
require 'database.php';
include_once 'header.php';
if (isset($_POST['submit']))
{
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $mail = $_POST['mail'];
    $adresGegevens = $_POST['adresGegevens'];
    $bankgegevens = $_POST['bankgegevens'];
    $geslacht = $_POST['geslacht'];
    $geboortedatum = $_POST['geboortedatum'];
    $telefoon = $_POST['telefoon'];
    $wachtwoord = (md5($_POST['password']));

    if (strlen($voornaam) == 0 || strlen($achternaam) == 0 || strlen($mail) == 0 || strlen($adresGegevens) == 0 || strlen($bankgegevens) == 0 || strlen($geslacht) == 0 || strlen($geboortedatum) == 0 || strlen($telefoon) == 0 || strlen($wachtwoord) == 0)
    {
        ?>
        <script>
            alert('1 of meerdere velden zijn niet ingevuld!');
        </script>
        <?php
    } else {
        $query = "INSERT INTO `inlog` (`id`, `gebruikersnaam`, `mail`, `wachtwoord`, `level`) VALUES (NULL, '$voornaam', '$mail', '$wachtwoord', 'klant')";
//        var_dump($query);
        //Als het eerste deel goed gegaan is ga je verder naar het tweede deel van de registratie
        if(mysqli_query($mysqli, $query))
        {
            $last_id = mysqli_insert_id($mysqli);
            $queryR = "INSERT INTO klant (id, voornaam, achternaam, adresGegevens, bankgegevens, geslacht, geboortedatum, telefoon) VALUES ('$last_id', '$voornaam', '$achternaam', '$adresGegevens', '$bankgegevens', '$geslacht', '$geboortedatum', '$telefoon')";
            if(mysqli_query($mysqli, $queryR))
            {
                ?>
                <!-- Dit is een soort alert die je krijgt als alles goed gegaan is. Dit bevestig de informatie dat het account aanmaken gelukt is met de vraag-->
                <script>
                    if (window.confirm('Het registreren is gelukt, druk op `OK` om verder te gaan naar het inlogscherm'))
                    {
                        window.location.href='https://84645.ict-lab.nl/webshop/inlog.php';
                    };
                </script>
                <?php
            }
//      echo ' & het toevoegen van de informatie is ook gelukt';
//      echo '<p><a href="inlog.php">Terug naar inlogpagina</a></p>';
        }
        else
        {
            //Dit is de alert die gegeven wordt als er iets fout gegaan is met het toevoegen van de informatie in de tabel inlog
            ?>
            <script>
                alert("Er is een fout opgetreden met het toevoegen van de klant zijn inloggegevens")
            </script>
            <?php
        }
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
                        <input type="text" name="voornaam" class="form-control" id="voornaam" value="<?php echo $voornaam; ?>">
                        <label for="e">Achternaam:</label>
                        <input type="text" name="achternaam" class="form-control" id="achternaam" placeholder="Winters" value="<?php echo $achternaam; ?>">
                        <label for="e">Email:</label>
                        <input type="email" name="mail" class="form-control" id="mail" placeholder="peterkroos@gmail.com" value="<?php echo $mail; ?>">
                        <label for="e">adresGegevens:</label>
                        <input type="text" name="adresGegevens" class="form-control" id="adresGegevens" value="<?php echo $adresGegevens; ?>">
                        <label for="e">Bankgegevens:</label>
                        <input type="text" name="bankgegevens" class="form-control" id="bankgegevens" value="<?php echo $bankgegevens; ?>">
                        <label for="e">Geboortedatum:</label>
                        <input type="date" name="geboortedatum" class="form-control" id="geboortedatum" value="<?php echo $geboortedatum; ?>">
                        <label for="e">Geslacht:</label>
                        <select name="geslacht" class="form-control">
                            <option value="disabled" disabled selected>Selecteer een geslacht</option>
                            <option value="M">Man</option>
                            <option value="V">Vrouw</option>
                        </select>
                        <label for="e">Telefoon:</label>
                        <input type="tel" name="telefoon" class="form-control" id="telefoon" value="<?php echo $telefoon; ?>">
                        <label for="password">Wachtwoord</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Wachtwoord ">
                    </div>
                    <div class="dropdown-divider"></div>
                    <button type="submit" name="submit" class="btn btn-primary">Aanmelden</button>
                    <button type="button" name="terug" class="btn btn-danger" onclick="document.location.href='inlog.php'">Terug</button>
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