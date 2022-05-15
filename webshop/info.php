<?php
session_start();
require 'database.php';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>info product pagina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
include_once 'header.php'
?>
<div class="content mt-5 mb-5">
    <div class="col-sm-8 col-md-5 col-lg-5 col-xl-3 col-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <?php
                $id_product = $_GET['id_product'];
                $taskProdcut = "SELECT * FROM product WHERE id_product = " . $id_product;
                $resultProduct = mysqli_query($mysqli, $taskProdcut);
                if (mysqli_num_rows($resultProduct) == 0)
                {
                    echo '<p>There were no results found</p>';
                }
                else
                {
                    while ($row =  mysqli_fetch_array($resultProduct))
                    {
                        echo '<img src="img/' . $row['img'] . '" style="width: 100%" />';
                        echo '<p style="color: white"> <b>Product: </b>' . $row['product'] . '</p>';
                        echo '<p style="color: white"> <b>Informatie: </b>' . $row['informatie'] . '</p>';
                        echo '<p style="color: white"> <b>Prijs: </b> €' . $row['prijs'] . '</p>';
//                        echo '<p style="color: white"> <b>Voorraad: </b>' . $row['voorraad'] . ' stuks</p>';
                    }
                }
                ?>
                <a class="btn btn-primary" href="index.php">Terug naar shoppen</a>
            </div>
        </div>
    </div>
</div>
<?php
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>