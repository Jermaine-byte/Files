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
if ($_SESSION['gebruikersnaam'] == 'verzend')
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
                        <b><i>Verzend afdeling</i></b>
                        <?php
                        $orderQuery = "SELECT * FROM bestelling";
                        $orderResult = mysqli_query($mysqli, $orderQuery);
                        if (mysqli_num_rows($orderResult) == 0)
                        {
                            echo '<p>There were no results found</p>';
                        }
                        else
                        {
                        ?>
                        <table class="table" id="stockTable">
                            <thead>
                            <th scope="col"><i>Product</i></th>
                            <th scope="col"><i>Klant</i></th>
                            <th scope="col"><i>Adresgegevens</i></th>
                            <th scope="col"><i>Status</i></th>
                            <th scope="col"><i>Status verzending</i></th>
                            </thead>
                            <tbody>
                            <?php
                            while ($row = mysqli_fetch_array($orderResult))
                            {
                                // ! in de plaats van plek product kan ik het naar een andere pagina laden waarbij ik via json alle producten laat laden
                                ?>
                                <tr>
                                    <th> <?php echo '<a class="btn btn-primary" href="product.php?id_bestelling=' . $row['id_bestelling'] . '">producten</a>'; ?></th>
                                    <th>
                                        <?php
                                        if ($row['voornaam'] == '')
                                        {
                                            echo 'Niet bekent';
                                        }
                                        else
                                        {
                                            echo $row['voornaam'];
                                        }
                                        ?>
                                    </th>
                                    <th><?php echo $row['adresGegevens']; ?></th>
                                    <th>Klaargezet</th>
                                    <th>
                                        <?php
                                        if ($row['status'] == 'niet verzonden')
                                        {
                                            echo '<a href="verzenden.php?id_bestelling=' . $row['id_bestelling'] . '" class="btn btn-warning">' . $row['status'] . '</a>';
                                        }
                                        else
                                        {
                                            echo '<button type="button" class="btn btn-success" disabled>' . $row['status'] . '</button>';
                                        }
//                                        echo $row['status'];
                                        ?>
                                    </th>
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
if ($_SESSION['gebruikersnaam'] != "verzend")
{
    //Dit is de tweede helft van de beveiliging. Als het account niet ingelogd is als verzend afdeling krijg je het onderstaande te zien, verder niks.
    ?>
    <div class="container">
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Geen Rechten</h4>
            <p>Je hebt niet de rechten om de status van de verzend afdeleing te zien. Als je de voorraad beheerder bent probeer dan in te loggen, anders ga naar de algemene pagina</p>
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