<?php
session_start();
require 'database.php';
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Enquete</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
    </head>
<body class="w-50">
<?php
if ($_SESSION['level'] == "docent")
{
    echo '<p>Welkom ' . $_SESSION['gebruikersnaam'] . ',</p>';
    echo '<p>In het lijstje hieronder kunt u zien welke studenten de enquete ingevuld hebben</p>';
    require 'datatable.php';
    echo '<p><a href="logout.php">Uitloggen</a></p>';
}

if ($_SESSION['level'] == "student")
{
    $student = $_SESSION['gebruikersnaam'];
    $queryStudent = "SELECT * FROM enquete WHERE student = " . $student;
    $resultStudent = mysqli_query($mysqli, $queryStudent);

    if (mysqli_num_rows($resultStudent) == 0)
    {
        echo "<h3>Beste $student u heeft nog niet de enquete ingevuld.</h3>";
        echo '<p>Vul hier de enquete in: <a href="add_enquete.php">Enquete invullen</a></p>';
    }
    else
    {
        $row = mysqli_fetch_array($resultStudent);
        echo "<h4>Beste  $student u heeft de enquete ingevuld.</h4>";
        //echo '<p>Als u nog iets wil aanpassen aan wat u ingevuld heeft <a href="update_enquete.php?enquete_id=' . $row['enquete_id'] . '">klik hier.</a></p>';
        echo '<p>Wilt u uw ingevulde enquete verwijderen? <a href="enquete_delete.php?enquete_id=' . $row['enquete_id'] . '">Klik hier.</a></p>';
        echo '<p>In het lijstje hieronder kunt u zien wat u ingevuld heeft</p>';
        ?>
        <table class="table">
            <tbody>
            <tr>
                <th scope="row">studentnummer:</th>
                <td><?php echo $row['student']; ?></td>

            </tr>
            <tr>
                <th scope="row">Aantal km van school:</th>
                <td><?php echo $row['km'] . ' kilometer'; ?></td>
            </tr>
            <tr>
                <th scope="row">Reistijd:</th>
                <td><?php echo $row['reistijd'] . ' minuten'; ?></td>
            </tr>
            <tr>
                <th scope="row">Vervoersmiddelen:</th>
                <td><?php echo $row['vervoersmiddel']; ?></td>
            </tr>
            <tr>
                <th scope="row">Wat vindt je van de begintijd (08:15):</th>
                <td><?php echo $row['beginTijd']; ?></td>
            </tr>
            <tr>
                <th scope="row">Wat vindt je van de eindtijd (17:15):</th>
                <td><?php echo $row['eindTijd']; ?></td>
            </tr>
            <tr>
                <th scope="row">Opmerkingen:</th>
                <td><?php echo $row['opmerkingen']; ?></td>
            </tr>
            </tbody>
        </table>
        <?php
        echo '<p><a href="logout.php">Uitloggen</a></p>';
    }
}

if ($_SESSION == false)
{
    echo '<p>U moet ingelogd zijn als u iets met een account <a href="inlog.php">KLIK HIER </a>om in te loggen</p>';
}
?>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('#enqueteTable').DataTable();
    });
</script>
</body>
</html>
