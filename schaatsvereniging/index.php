<?php
session_start();
require 'database.php';
//dit is de algemene pagina van dit project, dit zou uiteindelijk verdeeld worden in 3 delen. De 3 delen zijn: niet ingelogd, ingelogd als admin & ingelogd als speler.
//Ze zien alle 3 wat anders.
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
if ($_SESSION == true && $_SESSION['voornaam'] != 'admin')
{
    ?>
    <div class="container mb-5" style=" max-width: 1600px;">
        <div class="row">
            <div>
                <div class="row">
                    <div class="col-md-6 border border-3 border-primary rounded-3">
                        <?php
                        $infoQuery = "SELECT * FROM inlog where id = '". $_SESSION['id'] . "'";
                        $infoResult = mysqli_query($mysqli, $infoQuery);
                        if (mysqli_num_rows($infoResult) == 0)
                        {
                            echo '<p>There were no results found</p>';
                        }
                        else
                        {
                            while ($row = mysqli_fetch_array($infoResult))
                            {
                                ?>
                                <h3>Goedendag <?php echo ucfirst($row['voornaam']) . ' ' . $row['achternaam']; ?><a class="btn btn-primary" style="float: right;" href="logout.php">Logout</a></h3>
                                <h5>Uw gegevens:</h5>
                                <p>Klopt er iets niet? <?php echo '<a class="btn btn-warning" href="edit_info.php?id=' . $row['id'] . '">Klik hier</a>'; ?> om het aan te passen</p>
                                <p>
                                    <?php echo 'Voornaam: ' . ucfirst($row['voornaam']); ?>
                                    <br>
                                    <?php echo 'Achternaam: ' . $row['achternaam']; ?>
                                    <br>
                                    <?php echo 'Spelernummer: ' . $row['spelerNummer']; ?>
                                    <br>
                                    <?php echo 'Adres: ' . $row['adres']; ?>
                                    <br>
                                    <?php echo 'Bankgegevens: ' . $row['bankgegevens']; ?>
                                    <br>
                                    <?php
                                    if ($row['geslacht'] == 'M') {
                                        echo 'Geslacht: Man';
                                    } else if ($row['geslacht'] == 'V') {
                                        echo 'Geslacht: Vrouw';
                                    }
                                    ?>
                                    <br>
                                    <?php echo 'Start Lidmaatschap: ' . $row['startLidmaatschap']; ?>
                                    <br>
                                    <?php
                                    $today = date("Y-m-d");
                                    $diff = date_diff(date_create($row['geboortedatum']), date_create($today));
                                    $age = $diff->format('%y');
                                    echo 'Leedtijd: ' . $age;
                                    ?>
                                    <br>
                                    <?php echo 'Geboortedatum: ' . $row['geboortedatum']; ?>
                                </p>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="col-md-6 border border-3 border-primary rounded-3">
                        <?php
                        $playerQuery = "SELECT * FROM inlog where id = '". $_SESSION['id'] . "'";
                        $playerResult = mysqli_query($mysqli, $playerQuery);
                        if (mysqli_num_rows($playerResult) == 0)
                        {
                            echo '<p>There were no results found</p>';
                        }
                        else
                        {
                        ?>
                        <table class="table" id="playerTable">
                            <thead>
                            <th scope="col"><i>Tijd</i></th>
                            <th scope="col"><i>Afstand</i></th>
                            <th scope="col"><i>Wedstrijd</i></th>
                            </thead>
                            <tbody>
                            <?php
                            while ($row = mysqli_fetch_array($playerResult))
                            {
                                ?>

                                    <?php
                                    $timeTask = "SELECT * FROM tijden WHERE spelerNummer = " . $row['spelerNummer'];
                                    $timeResult = mysqli_query($mysqli, $timeTask);
                                    while ($tijden = mysqli_fetch_array($timeResult))
                                    {
                                        ?>
                                        <tr>
                                        <th><?php echo $tijden['Tijd'] . ' seconden'; ?></th>
                                        <th><?php echo $tijden['afstand'] . ' meter'; ?></th>
                                        <?php
                                        // met deze php code ga ik naar de tabel van wedstrijden en haal ik ieder id op met de bijbehorende naam
                                        $taskGame = "SELECT * FROM wedstrijd WHERE id_wedstrijd = " . $tijden['id_wedstrijd'];
                                        $resultGame = mysqli_query($mysqli, $taskGame);
                                        while ($id_wedstrijd = mysqli_fetch_array($resultGame)) {
                                            ?>
                                                <th><?php echo $id_wedstrijd['wedstrijdNaam']; ?></th>
                                            <?php
                                        }
                                        ?>
                                        </tr>
                                        <?php
                                    }
                                    ?>
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

if ($_SESSION['voornaam'] == 'admin')
{
    ?>
    <div class="container mb-5" style=" max-width: 1600px;">
        <div class="row">
            <div>
                <div class="row">
                    <div class="col-md-12">
                        <a class="btn btn-success" href="create_wedstrijd.php">Wedstrijd toevoegen</a>
                        <a class="btn btn-primary" style="float: right;" href="logout.php">Logout</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 border border-3 border-primary rounded-3" style="overflow-x: scroll">
                        <b><i>Wedstrijdagenda</i></b>
                        <?php
                        $gameQuery = "SELECT * FROM wedstrijd";
                        $gameResult = mysqli_query($mysqli, $gameQuery);
                        if (mysqli_num_rows($gameResult) == 0)
                        {
                            echo '<p>There were no results found</p>';
                        }
                        else
                        {
                        ?>
                        <table class="table" id="gameTable">
                            <thead>
                            <th scope="col"><i>Wedstrijd</i></th>
                            <th scope="col"><i>Datum</i></th>
                            <th scope="col"><i>BeginTijd</i></th>
                            <th scope="col"><i>Info</i></th>
                            <th scope="col"><i>Edit</i></th>
                            <th scope="col"><i>Delete</i></th>
                            <th scope="col"><i>Tijd toevoegen</i></th>
                            <th scope="col"><i>Tijden</i></th>
                            </thead>
                            <tbody>
                            <?php
                            while ($row = mysqli_fetch_array($gameResult))
                            {
                                ?>
                                <tr>
                                    <th><?php echo $row['wedstrijdNaam']; ?></th>
                                    <th><?php echo $row['datum']; ?></th>
                                    <th><?php echo $row['beginTijd']; ?></th>
                                    <th> <?php echo '<a class="btn btn-primary" href="wedstrijd_info.php?id_wedstrijd=' . $row['id_wedstrijd'] . '">Info</a>'; ?></th>
                                    <th> <?php echo '<a class="btn btn-success" href="edit_wedstrijd.php?id_wedstrijd=' . $row['id_wedstrijd'] . '">Edit Wedstrijd</a>'; ?></th>
                                    <th> <?php echo '<a class="btn btn-danger" href="delete_wedstrijd.php?id_wedstrijd=' . $row['id_wedstrijd'] . '">Delete Wedstrijd</a>' ?></th>
                                    <th> <?php echo '<a class="btn btn-success" href="create_tijd.php?id_wedstrijd=' . $row['id_wedstrijd'] . '">Tijd toevoegen</a>' ?></th>
                                    <th> <?php echo '<a class="btn btn-primary" href="tijd_info.php?id_wedstrijd=' . $row['id_wedstrijd'] . '">Tijden</a>'; ?></th>
<!--                                    <th><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#recordModal">Tijden</button></th>-->
                                </tr>
                                <?php
                                $taskTime = "SELECT * FROM tijden WHERE id_wedstrijd = " . $row['id_wedstrijd'];
                                $resultTime = mysqli_query($mysqli, $taskTime);

                                ?>
                                <!-- Scrollable modal -->
                                <div class="modal" id="recordModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Tijden</h5>
                                                <button type="button" class="btn-close" style="background-color: red" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <?php
                                                while ($time = mysqli_fetch_array($resultTime))
                                                {
                                                echo '<p><b>Tijd: </b>' . $time['Tijd'] . ' seconden<a class=" btn btn-danger" href="delete_tijd.php?id_tijd=' . $time['id_tijd'] . '">Tijd verwijderen</a><br><b>Spelernummer: </b> ' . $time['spelerNummer'] . '</p>';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

if ($_SESSION == false)
{
    // Ik heb in de informatie een klein beetje javascript verwerkt. Als er een jaar voorbij is wordt de leeftijd ook een jaar verder.
    ?>
        <div class="container mb-5" style=" max-width: 1600px;">
            <div class="row">
                <div>
                    <div class="row">
                        <div class="col-md-9 border border-3 border-primary rounded-3">
                            <b><i>Schaatsvereniging Rotterdam</i></b>
                            <p>
                                Dit is een schaatsvereniging die in Rotterdam staat.
                                De schaatsvereniging is voor iedereen beschikbaar.
                                Jong of oud, man of vrouw, klein of groot.
                                Met deze schaatsvereniging kan je leren schaatsen & wedstrijdschaatsen.
                            </p>
                            <p>
                                Deze schaatsvereniging bestaat al sinds 2010, dus de vereniging is nu
                                <script>
                                    let build = 2010;
                                    let year = new Date().getFullYear();
                                    let age = year - build;
                                    document.write(age + " ");
                                </script>
                                jaar oud. in de afgelopen jaar is er veel veranderd.
                                We zijn populair geworden en we hebben leden zien komen en gaan.
                            </p>
                            <p>
                                We zijn altijd op zoek naar nieuwe leden, want hoe meer zielen hoe meer vreugd.
                                Voor hier te kunnen schaatsen zou u een abonnement moet afsluiten, dat abonnement kost €125 per jaar.
                            </p>
                            <p>
                                Voor de mensen die al lid zijn van deze vereniging <a href="login.php">klik hier</a> om in te loggen,
                                als u wilt inschrijven <a href="registreer.php">klik hier</a>.
                            </p>
                        </div>
                        <div class="col-md-3 border border-3 border-primary rounded-3">
                            <img src="schaatsvereniging.jpeg" alt="schaatsvereniging" width="100%">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 border border-3 border-primary rounded-3">
                            <b><i>Wedstrijdagenda</i></b>
                            <?php
                            $date = date("Y-m-d");
                            $gameQuery = "SELECT * FROM wedstrijd WHERE datum = " . "'" . $date . "'" . " OR datum > " . "'" . $date . "'";
                            $gameResult = mysqli_query($mysqli, $gameQuery);
                            if (mysqli_num_rows($gameResult) == 0)
                            {
                                echo '<p>There were no results found</p>';
                            }
                            else
                            {
                                ?>
                            <table class="table" id="gameTable">
                                <thead>
                                <th scope="col"><i>Wedstrijd</i></th>
                                <th scope="col"><i>Datum</i></th>
                                <th scope="col"><i>beginTijd</i></th>
                                </thead>
                                <tbody>
                                <?php
                                while ($row = mysqli_fetch_array($gameResult))
                                {
                                    ?>
                                    <tr>
                                        <th><?php echo $row['wedstrijdNaam']; ?></th>
                                        <th><?php echo $row['datum'] ?></th>
                                        <th><?php echo $row['beginTijd']; ?></th>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6 border border-3 border-primary rounded-3">
                            <b><i>Records</i></b>
                            <?php
                            $recordQuery = "SELECT * FROM tijden";
                            $recordResult = mysqli_query($mysqli, $recordQuery);
                            if (mysqli_num_rows($recordResult) == 0)
                            {
                                echo '<p>There were no results found</p>';
                            }
                            else
                            {
                            ?>
                            <table class="table" id="recordTable">
                                <thead>
                                <th scope="col"><i>Afstand</i></th>
                                <th scope="col"><i>Tijd</i></th>
                                <th scope="col"><i>Speler</i></th>
                                </thead>
                                <tbody>
                                <?php
                                while ($row = mysqli_fetch_array($recordResult))
                                {
                                    ?>
                                    <tr>
                                        <th><?php echo $row['afstand'] . ' meter'; ?></th>
                                        <th><?php echo $row['Tijd'] . ' sec'; ?></th>
                                        <?php
                                        $taskPlayer = "SELECT * FROM inlog WHERE spelerNummer = " . $row['spelerNummer'];
                                        $resultPlayer = mysqli_query($mysqli, $taskPlayer);
                                        while ($spelerNummer = mysqli_fetch_array($resultPlayer))
                                        {
                                            ?>
                                            <th><?php echo $spelerNummer['spelerNummer'] . ' - ' . ucfirst($spelerNummer['voornaam']); ?></th>
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
include_once 'footer.php';
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#gameTable').DataTable();
    });

    $(document).ready(function() {
        $('#recordTable').DataTable();
    });

    $(document).ready(function() {
        $('#playerTable').DataTable();
    });
</script>
</body>
</html>