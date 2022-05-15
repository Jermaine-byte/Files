<?php
session_start();
require 'database.php';

error_reporting(E_ALL);
ini_set('display_errors', '1');

$enquete_id = $_GET['enquete_id'];

$getEnquete = "SELECT * FROM enquete WHERE `enquete_id` = " . $enquete_id;
$result = mysqli_query($mysqli, $getEnquete);

if (mysqli_num_rows($result) == 0)
{
    echo "<p>There is no enquete with id $enquete_id</p>";
}
else
{
    $row = mysqli_fetch_array($result);
    echo '<h3>Student: ' . $row['student'] . '</h3>';

    $getInfo = "SELECT * FROM inlog WHERE `gebruikersnaam` = " . $row['student'];
    $resultInfo = mysqli_query($mysqli, $getInfo);

    if (mysqli_num_rows($resultInfo) == 0)
    {
        echo '<p>There does not exists date this student</p>';
    } else
    {
        $rowInfo = mysqli_fetch_array($resultInfo);
        echo '<h4>Gegevens van student ' . $rowInfo['gebruikersnaam'] . '</h4>';
        ?>
        <table class="table">
            <tbody>
            <tr>
                <th scope="row">Voornaam:</th>
                <td><?php echo $rowInfo['voornaam']; ?></td>
            </tr>
            <tr>
                <th scope="row">Achternaam:</th>
                <td><?php echo $rowInfo['achternaam']; ?></td>
            </tr>
            <tr>
                <th scope="row">Adres:</th>
                <td><?php echo $rowInfo['adres']; ?></td>
            </tr>
            <tr>
                <th scope="row">postcode:</th>
                <td><?php echo $rowInfo['postcode']; ?></td>
            </tr>
            <tr>
                <th scope="row">Woonplaats:</th>
                <td><?php echo $rowInfo['woonplaats']; ?></td>
            </tr>
            <tr>
                <th scope="row">Leeftijd:</th>
                <td><?php echo $rowInfo['leeftijd']; ?></td>
            </tr>
            </tbody>
        </table>
        <?php
    }

    echo '<h4>Ingevulde Enquete van ' . $row['student'] . '</h4>';
    ?>
    <table class="table">
        <tbody>
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
}
if ($_SESSION['level'] != "docent")
{
    echo '<h3>Je moet ingelogd zijn als docent om de ingevulde enquete van leerlingen te zien, probeer alstublieft <a href="inlog.php">in te loggen</a></h3>';
}
?>
<button type="button" name="terug" onclick="window.location.href='enquete.php'">Terug naar enquete overzicht</button>
