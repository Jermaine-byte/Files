<?php
session_start();
require 'database.php';
$id_bestelling = $_GET['id_bestelling'];
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>producten pagina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
include_once 'header.php';

$getOrder = "SELECT * FROM bestelProduct WHERE id_bestelling = " . $id_bestelling;
$OrderResult = mysqli_query($mysqli, $getOrder);
?>
<div class="content mt-5 mb-5">
    <div class="col-sm-8 col-md-5 col-lg-5 col-xl-3 col-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <?php
                if (mysqli_num_rows($OrderResult) == 0) {echo '<p>There were no results found</p>';}
                else
                {
                    while ($row = mysqli_fetch_array($OrderResult))
                    {
                        ?>
                        <p>
                            <?php
                            $getProduct = "SELECT * FROM product WHERE productNummer = " . $row['productNummer'];
                            $resultProduct = mysqli_query($mysqli, $getProduct);
                            if (mysqli_num_rows($resultProduct) == 0)
                            {
                                echo '<p>There were no results found</p>';
                            }
                        else
                        {
                            while ($product =  mysqli_fetch_array($resultProduct))
                            {
                                echo '<b>Product: </b>' . $product['product'];
                            }
                        }
                            ?>
                            <br>
                            <b>Productnummer: </b> <?php echo $row['productNummer']; ?>
                            <br>
                            <b>Stuks: </b> <?php echo $row['stuks']; ?>
                        </p>
                        <?php
                    }
                }
                ?>
                <a class="btn btn-primary" href="verzendAfdeling.php">Terug naar de verzendafdeling</a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
