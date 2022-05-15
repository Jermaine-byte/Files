<?php
session_start();
require 'database.php';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>wedstrijd info pagina</title>
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
                $id_wedstrijd = $_GET['id_wedstrijd'];
                $gameQuery = "SELECT * FROM wedstrijd WHERE id_wedstrijd = " . $id_wedstrijd;
                $gameResult = mysqli_query($mysqli, $gameQuery);
                if (mysqli_num_rows($gameResult) == 0)
                {
                    echo '<p>There were no results found</p>';
                }
                else
                {
                    $row =  mysqli_fetch_array($gameResult);
                    ?>
                    <p><b>Wedstrijd: </b> <?php echo $row['wedstrijdNaam']; ?></p>
                    <p><b>Datum: </b> <?php echo $row['datum']; ?></p>
                    <p><b>BeginTijd: </b> <?php echo $row['beginTijd']; ?></p>
                    <p><b>Afstand: </b> <?php echo $row['afstand']; ?> meter</p>
                    <?php
                }
                ?>
                <a class="btn btn-primary" href="index.php">Terug naar index</a>
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