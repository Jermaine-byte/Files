<?php
session_start();
require 'database.php';

error_reporting(E_ALL);
ini_set('display_errors', '1');
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Enquete verwijderen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">    <link rel="stylesheet" href="footer.css">
</head>
<body>
<div class="container">
    <?php
    $enquete_id = $_GET['enquete_id'];
    $query = "SELECT * FROM enquete WHERE enquete_id = " . $enquete_id;
    $result = mysqli_query($mysqli, $query);
    if (mysqli_num_rows($result) == 0)
    {
        echo "<p>There is no enquete with id $enquete_id</p>";
    }
    else
    {
        $row = mysqli_fetch_array($result);
        ?>
        <p>Wilt u uw ingevulde enquete verwijderen?</p>
        <form name="form1" method="post" action="enquete_delete_verwerk.php">
            <input type="hidden" name="enquete_id" value="<?php echo $row['enquete_id']; ?>"/>
            <p>Enquete van: <?php echo $row['student']; ?></p>
            <p><input type="submit" name="submit" value="delete" /></p>
        </form>
        <p>Wilt u toch niet uw ingevulde enquete verwijdern? <a href="enquete.php">TERUG</a> naar enquete</p>
        <?php
    }
    ?>
</div>
<?php
if ($_SESSION != true)
{
    echo '<h3>Je moet ingelogd zijn om de enquete in te kunnen vullen, probeer alstublieft <a href="inlog.php">in te loggen</a></h3>';
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>