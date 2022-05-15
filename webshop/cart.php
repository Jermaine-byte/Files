<?php
session_start();
require 'database.php';
//print_r($_SESSION['shopping_cart']);
$cart = $_SESSION['shopping_cart'];
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>cart pagina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
include_once 'header.php';

if ($_SESSION['id'] == false)
{
    $klant = 0;
}
else
{
    $klant = $_SESSION['id'];
}
//    var_dump($klant);

$getCustomer = "SELECT * FROM klant WHERE id = " . $klant;
$customerResult = mysqli_query($mysqli, $getCustomer);
?>
<div class="content mt-5 mb-5">
    <div class="col-sm-8 col-md-5 col-lg-5 col-xl-3 col-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <?php
                        for ($i = 0; $i < count($cart); $i++)
                        {
                            echo '<p><b>Product: </b>' . $cart[$i]['product'] . '<br>' . '<b>Stuks: </b>' . $cart[$i]['quantity'] . '</p>';
                        }
                        if (mysqli_num_rows($customerResult) == 0) {}
                        $row = mysqli_fetch_array($customerResult);
                        if ($_SESSION['id'] == true)
                        {
                            echo '<p>Als deze gegevens kloppen hoeft u niks aan te passen</p>';
                        }
                        ?>
                        <label for="e">Voornaam:</label>
                        <input type="text" name="voornaam" class="form-control" id="voornaam" <?php if($_SESSION['id'] == true) {echo 'readonly'; }?> value="<?php if($_SESSION['id'] == true) {echo $row['voornaam']; } ?>">
                        <label for="e">Achternaam:</label>
                        <input type="text" name="achternaam" class="form-control" id="achternaam" <?php if($_SESSION['id'] == true) {echo 'readonly'; }?> value="<?php if($_SESSION['id'] == true) {echo $row['achternaam']; } ?>">
                        <label for="e">Telefoon:</label>
                        <input type="tel" name="telefoon" class="form-control" id="telefoon" <?php if($_SESSION['id'] == true) {echo 'readonly'; }?> value="<?php if($_SESSION['id'] == true) {echo $row['telefoon']; } ?>">
                        <label for="e">adresGegevens:</label>
                        <input type="text" name="adresGegevens" class="form-control" id="adresGegevens" <?php if($_SESSION['id'] == true) {echo 'readonly'; }?> value="<?php if($_SESSION['id'] == true) {echo $row['adresGegevens']; } ?>">
                        <button type="submit" name="submit" class="btn btn-primary">Kopen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
if (isset($_POST['submit']))
{
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $telefoon = $_POST['telefoon'];
    $adresGegevens = $_POST['adresGegevens'];

    $query = "INSERT INTO `bestelling` (`id_bestelling`, `id_klant`, `status`, `voornaam`, `achternaam`, `telefoon`, `adresGegevens`) VALUES (NULL, '$klant', 'niet verzonden' ,'$voornaam', '$achternaam', '$telefoon', '$adresGegevens')";
    if(mysqli_query($mysqli, $query))
    {
        $last_id = mysqli_insert_id($mysqli);
        for ($i = 0; $i < count($cart); $i++)
        {
            $queryNumber = "SELECT * FROM product WHERE id_product = " . $cart[$i]['id_product'];
            $resultNumber = mysqli_query($mysqli, $queryNumber);
            $row =  mysqli_fetch_array($resultNumber);
            $product = $row['productNummer'];
            $quantity = $cart[$i]['quantity'];
            $queryProduct = "INSERT INTO `bestelProduct` (`id_bestelling`, `productNummer`, `stuks`) VALUES ('$last_id', '$product', '$quantity')";
            if (mysqli_query($mysqli, $queryProduct))
            {
                header("location:index.php");
                unset($_SESSION['shopping_cart']);
            }
            else
            {
                echo  'it does not work';
            }
        }
    }
    else {

    }
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
