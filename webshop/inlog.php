<?php
session_start();
require 'database.php';

if (isset($_POST['submit']))
{
    $gebruikersnaam = $_POST['user'];
    $wachtwoord = (md5($_POST['password']));
    $query = "SELECT * FROM inlog WHERE gebruikersnaam = '$gebruikersnaam' AND wachtwoord = '$wachtwoord'";
    $resultaat = mysqli_query($mysqli, $query);
    if (is_null($resultaat))
    {
        echo "Mysqli query failed: " . mysqli_error();
    }

    if (mysqli_num_rows($resultaat) > 0)
    {
        $user = mysqli_fetch_array($resultaat);
        $_SESSION['id'] = $user['id'];
        $_SESSION['gebruikersnaam'] = $user['gebruikersnaam'];
        $_SESSION['level'] = $user['level'];

        if ($_SESSION['gebruikersnaam'] == 'voorraad')
        {
            header('location:voorraad.php');
        }
        else if ($_SESSION['gebruikersnaam'] == 'verzend')
        {
            header('location: verzendAfdeling.php');
        }
        else {
            header('location:index.php');
        }
    }
    else
    {
        ?>
        <div class="alert alert-danger" role="alert">
            <p>Gebruikersnaam en/of wachtwoord zijn fout.</p>
            <p>Probeer het opniew!</p>
        </div>
        <?php
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Inlog pagina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
include_once 'header.php';
?>
<div class="content loginBoxDiv mt-5 mb-5">
    <div class="col-sm-8 col-md-5 col-lg-5 col-xl-3 col-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <form class="px-4 py-3" method="post">
                    <p><b><i>Inloggen</i></b></p>
                    <div class="form-group">
                        <label for="e">Gebruikersnaam</label>
                        <input type="text" name="user" class="form-control" id="gebruikersnaam" placeholder="gebruikersnaam">
                    </div>
                    <div class="form-group">
                        <label for="password">Wachtwoord</label>
                        <input type="password" name="password" class="form-control" id="password002" placeholder="Wachtwoord ">
                    </div>
                    <div class="dropdown-divider"></div>
                    <button type="submit" name="submit" class="btn btn-primary">LOG IN</button>
                    <button type="button" name="terug" class="btn btn-danger" onclick="document.location.href='index.php'">Naar winkelwagen</button>
                    <hr>
                    <p><b><i>Nog geen account? Registreer hier als klant</i></b></p>
                    <button type="button" name="registeer" onclick="window.location.href='register.php'">Registreren</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>