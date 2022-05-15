<?php
session_start();
require 'database.php';

// Het login-systeem is er om de checken of de gegevens die opgegeven zijn bestaan in de database.
if (isset($_POST['submit']))
{
    $voornaam = $_POST['user'];
    $wachtwoord = (md5($_POST['password']));
    $query = "SELECT * FROM inlog WHERE voornaam = '$voornaam' AND wachtwoord = '$wachtwoord'";
    $resultaat = mysqli_query($mysqli, $query);
    if (is_null($resultaat))
    {
        echo "Mysqli query failed: " . mysqli_error();
    }

    //Als de gegevens kloppen wordt het ID & de naam van de gebruiker in de Sessie opgeslagen totdat er uitgelogd wordt
    if (strlen($voornaam) > 0 && strlen($wachtwoord) > 0)
    {
        if (mysqli_num_rows($resultaat) > 0)
        {
            $user = mysqli_fetch_array($resultaat);
            $_SESSION['id'] = $user['id'];
            $_SESSION['voornaam'] = $user['voornaam'];

            header("location: index.php");
        }
        else
        {
//            var_dump($query);
            ?>
            <div class="alert alert-danger" role="alert">
                <p>Voornaam en/of wachtwoord zijn fout.</p>
                <p>Probeer het opniew!</p>
            </div>
            <?php
        }
    } else {
        ?>
        <script>
            alert('1 of meerdere velden zijn niet ingevuld!');
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
    <title>Inlog pagina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="content loginBoxDiv mt-5 mb-5">
    <div class="col-sm-8 col-md-5 col-lg-5 col-xl-3 col-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <form class="px-4 py-3" method="post">
                    <p><b><i>Inloggen</i></b></p>
                    <div class="form-group">
                        <label for="e">Voornaam</label>
                        <input type="text" name="user" class="form-control" id="Voornaam" placeholder="voornaam">
                    </div>
                    <div class="form-group">
                        <label for="password">Wachtwoord</label>
                        <input type="password" name="password" class="form-control" id="password002" placeholder="Wachtwoord ">
                    </div>
                    <div class="dropdown-divider"></div>
                    <button type="submit" name="submit" class="btn btn-primary">LOG IN</button>
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