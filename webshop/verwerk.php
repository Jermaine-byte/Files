<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
require 'database.php';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>kopen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
    if (isset($_POST['submit']))
    {
        $id_product = $_POST['id_product'];
        $voorraad = $_POST['voorraad'];
        $query = "SELECT * FROM product WHERE id_product = " . $id_product;
        $result = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_array($result);
        $stock = $row['voorraad'] + $voorraad;
        $queryS = "UPDATE `product` SET `voorraad` = '$stock' WHERE `id_product` = '$id_product'";
        if (mysqli_query($mysqli, $queryS))
        {
            header("location: voorraad.php");
        }
    }
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>