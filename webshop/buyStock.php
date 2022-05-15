<?php
session_start();
require 'database.php';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Voorraad bijkopen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
//dit is een beveiliging die checkt of de administrator ingelogd is, als hij dat is krijgt hij het onderstaande formulier te zien
if ($_SESSION['gebruikersnaam'] == "voorraad")
{
    include_once 'header.php';

    $id_product = $_GET['id_product'];
    $product = $_GET['product'];
    $voorraad = $_GET['vooraad'];
    $query = "SELECT * FROM `product` WHERE `id_product` = " .$id_product;
    $result = mysqli_query($mysqli, $query);

    if (mysqli_num_rows($result) == 0)
    {
        echo "<p>Er is geen product met $id_product</p>";
    }
    else
    {
    $row = mysqli_fetch_array($result);
    ?>
        <div class="content loginBoxDiv mt-5 mb-5">
            <div class="col-sm-8 col-md-5 col-lg-5 col-xl-3 col-12 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <form class="px-4 py-3" action="buyStock_verwerk.php" method="post" enctype="multipart/form-data">
                            <p><b><i>Voorraad bijkopen</i></b></p>
                            <i>Voorraad van <?php echo '<b>' . $row['product'] . '</b> is ' . $row['voorraad']; ?></i>
                            <div class="form-group">
                                <input type="hidden" name="id_product" value="<?php echo $id_product; ?>";
                                <label for="e">Stuks:</label>
                                <input type="number" name="voorraad" class="form-control" id="voorraad">
                            </div>
                            <button type="submit" name="submitS" class="btn btn-primary">Kopen</button>
                        </form>
                        <div class="dropdown-divider"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
if ($_SESSION['gebruikersnaam'] != "voorraad")
{
    //Dit is de tweede helft van de beveiliging. Als het account niet ingelogd is als admin krijg je het onderstaande te zien, verder niks.
    ?>
    <div class="container">
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Geen Rechten</h4>
            <p>Je hebt niet de rechten om voorraad bij te kopen. Als je de voorraad beheerder bent probeer dan in te loggen, anders ga naar de algemene pagina</p>
            <hr>
            <form>
                <button type="button" name="terug" class="btn btn-warning mx-auto" onclick="window.location.href='inlog.php'">inloggen</button>
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