<?php
session_start();
require 'database.php';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Enquete invullen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<?php
$enquete_id = $_GET['enquete_id'];
$query = "SELECT * FROM `enquete` WHERE enquete_id = " . $enquete_id;
$result = mysqli_query($mysqli, $query);
if (mysqli_num_rows($result) == 0)
{
    echo "<p>Er is geen enquete met id $enquete_id</p>";
}
else
{
    $row = mysqli_fetch_array($result);
    ?>
    <div class="content loginBoxDiv mt-5 mb-5">
        <div class="col-sm-8 col-md-5 col-lg-5 col-xl-3 col-12 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form class="px-4 py-3" method="post">
                        <p><b><i>enquete</i></b></p>
                        <div class="form-group">
                            <input type="hidden" name="enquete_id" value="<?php echo $enquete_id; ?>">
                            <label for="e">Hoeveel km woon je van school (heel getal)</label>
                            <input type="number" name="km" class="form-control" id="km" value="<?php echo $row['km']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="e">Wat is je reistijd in minuten?</label>
                            <input type="number" name="reistijd" class="form-control" id="reistijd" value="<?php echo $row['reistijd']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="e">Wat voor vervoersmiddelen gebruik je?</label>
                            <textarea name="vervoersmiddel" class="form-control" id="vervoersmiddel"><?php echo $row['vervoersmiddel']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="e">wat vindt je van de begintijd van school (08:15)?</label>
                            <select name="beginTijd" class="form-select">
                                <option selected disabled>Selecteer een optie</option>
                                <option value="Te vroeg">Te vroeg</option>
                                <option value="Goed">Goed</option>
                                <option value="Te laat">Te laat</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="e">wat vindt je van de eindtijd van school (17:15)?</label>
                            <select name="eindTijd" class="form-select">
                                <option selected disabled>Selecteer een optie</option>
                                <option value="Te vroeg">Te vroeg</option>
                                <option value="Goed">Goed</option>
                                <option value="Te laat">Te laat</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="e">Heb je nog verdere opmerkingen?</label>
                            <textarea name="opmerkingen" class="form-control" id="opmerkingen" rows="3"><?php echo $row['opmerkingen']; ?></textarea>
                        </div>
                        <div class="dropdown-divider"></div>
                        <button type="submit" name="submit" class="btn btn-primary">AANPASSEN</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    if (isset($_POST['submit']))
    {
        $enquete_id = $_POST['enquete_id'];
        $km = $_POST['km'];
        $reistijd = $_POST['reistijd'];
        $vervoersmiddel = $_POST['vervoersmiddel'];
        $beginTijd = $_POST['beginTijd'];
        $eindTijd = $_POST['eindTijd'];
        $opmerkingen = $_POST['opmerkingen'];
        $enqueteQuery = "UPDATE `enquete` SET `km` = '$km', `reistijd` = '$reistijd', `vervoersmiddel` = '$vervoersmiddel', `beginTijd` = '$beginTijd', `eindTijd` = '$eindTijd', `opmerkingen` = '$opmerkingen' WHERE `enquete_id` = '$enquete_id'";
        if (mysqli_query($mysqli, $enqueteQuery))
        {
            header("location: enquete.php");
        }
        else
        {
            echo '<p>Er is een fout opgetreden!</p>';
        }
    }
}

if ($_SESSION != true)
{
    echo '<h3>Je moet ingelogd zijn om de enquete aan te kunnen passen, probeer alstublieft <a href="inlog.php">in te loggen</a></h3>';
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>