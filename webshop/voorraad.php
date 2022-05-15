<?php
session_start();
require 'database.php';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Algemeen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
include_once 'header.php';
if ($_SESSION['gebruikersnaam'] == 'voorraad')
{
    ?>
    <div class="container mb-5" style=" max-width: 1600px;">
        <div class="row">
            <div>
                <div class="row">
                    <div class="col-md-12">
                        <a class="btn btn-primary" href="logout.php">Logout</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 border border-3 border-primary rounded-3">
                        <b><i>Voorraad</i></b>
                        <?php
                        $productQuery = "SELECT * FROM product";
                        $productResult = mysqli_query($mysqli, $productQuery);
                        if (mysqli_num_rows($productResult) == 0)
                        {
                            echo '<p>There were no results found</p>';
                        }
                        else
                        {
                        ?>
                        <table class="table" id="stockTable">
                            <thead>
                            <th scope="col"><i>Product</i></th>
                            <th scope="col"><i>Prijs</i></th>
                            <th scope="col"><i>Voorraad</i></th>
                            <th scope="col"><i>Minimale voorraad</i></th>
<!--                            <th scope="col"><i>Info</i></th>-->
                            <th scope="col"><i>Buy</i></th>
                            <th scope="col"><i>Status</i></th>
                            </thead>
                            <tbody>
                            <?php
                            while ($row = mysqli_fetch_array($productResult))
                            {
//                                $stock = $row['voorraad'] + 4 - $row['minimaleVoorraad'];
                                ?>
                                <tr>
                                    <th><?php echo $row['product']; ?></th>
                                    <th>€ <?php echo $row['prijs']; ?></th>
                                    <th><?php echo $row['voorraad']; ?></th>
                                    <th><?php echo $row['minimaleVoorraad']; ?></th>
<!--                                    <th>--><?php //echo '<a class="btn btn-warning" href="info.php?id_product=' . $row['id_product'] . '">Info</a>'; ?><!--</th>-->
                                    <th> <?php echo '<a class="btn btn-success" href="buyStock.php?id_product=' . $row['id_product'] . '">Voorraad bijkopen</a>'; ?></th>
                                        <?php
                                        if ($row['voorraad'] > $row['minimaleVoorraad'] && $row['minimaleVoorraad'] != 0)
                                        {
                                            ?>
                                            <th style="color: lawngreen">
                                                Voorraad is goed
                                            </th>
                                            <?php
                                        }
                                        if ($row['voorraad'] < $row['minimaleVoorraad']  OR $row['voorraad'] == $row['minimaleVoorraad'] && $row['minimaleVoorraad'] != 0)
                                        {
                                            ?>
                                            <th style="color:orange">
                                                Voorraad bijkopen
                                            </th>
                                            <?php
                                        }
                                        if ($row['minimaleVoorraad'] == 0)
                                        {
                                            ?>
                                            <th style="color:red">
                                                Voorraad is op
                                            </th>
                                            <?php
                                        }
                                        ?>
                                </tr>
                                <?php
                            }
                        }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($_SESSION['gebruikersnaam'] != "voorraad")
{
    //Dit is de tweede helft van de beveiliging. Als het account niet ingelogd is als voorraad beheerder krijg je het onderstaande te zien, verder niks.
    ?>
    <div class="container">
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Geen Rechten</h4>
            <p>Je hebt niet de rechten om de status van de voorraad te zien. Als je de voorraad beheerder bent probeer dan in te loggen, anders ga naar de algemene pagina</p>
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
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#stockTable').DataTable();
    });
</script>
</body>
</html>