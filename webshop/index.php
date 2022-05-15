<?php
session_start();
$product_ids = array();
//session_destroy();

if (filter_input(INPUT_POST, 'add_to_cart'))
{
    if (isset($_SESSION['shopping_cart']))
    {
        // * houdt bij hoeveel producten er in de winkelwagen zitten
        $count = count($_SESSION['shopping_cart']);

        // * maak een sequentiële array voor het matchen van arraysleutels met product-ID's
        $product_ids = array_column($_SESSION['shopping_cart'], 'id_product');

        if (!in_array(filter_input(INPUT_GET, 'id_product'), $product_ids))
        {
            $_SESSION['shopping_cart'][$count] = array
            (
                'id_product' => filter_input(INPUT_GET, 'id_product'),
                'product' => filter_input(INPUT_POST, 'product'),
                'prijs' => filter_input(INPUT_POST, 'prijs'),
                'quantity' => filter_input(INPUT_POST, 'quantity')
            );
        }
        else
        { // * product bestaat al, verhoog de hoeveelheid
            // * match de arraysleutel met de id van het product dat aan de winkelwagen wordt toegevoegd
            for ($i = 0; $i < count($product_ids); $i++)
            {
                if ($product_ids[$i] == filter_input(INPUT_GET, 'id_product'))
                {
                    // * verhoogt de hoeveelheid van een product dat al in de winkelwagen zit als er nog een keer op hetzelfde product wordt gedrukt in de array
                    $_SESSION['shopping_cart'][$i]['quantity'] += filter_input(INPUT_POST, 'quantity');
                }
            }
        }
    }
    else
    {
        // * als de winkelwagen niet bestaat, maak eerst een product met array key 0
        // * maak array van verzonden data, start vanaf key 0 en vul het met waardes
        $_SESSION['shopping_cart'][0] = array
        (
                'id_product' => filter_input(INPUT_GET, 'id_product'),
                'product' => filter_input(INPUT_POST, 'product'),
                'prijs' => filter_input(INPUT_POST, 'prijs'),
                'quantity' => filter_input(INPUT_POST, 'quantity')
        );
    }
}

if (filter_input(INPUT_GET, 'action') == 'delete')
{
    // * loop door alle producten in het winkelwagentje totdat het overeenkomt met de GET id-variabele
    foreach ($_SESSION['shopping_cart'] as $key => $product)
    {
        if ($product['id_product'] == filter_input(INPUT_GET, 'id_product'))
        {
            // * product uit de winkelwagen verwijderen als het overeenkomt met de GET-id
            unset($_SESSION['shopping_cart'][$key]);
        }
    }
    // * reset sessie-arraysleutels zodat ze overeenkomen met $product_ids numerieke array
    $_SESSION['shopping_cart'] = array_values($_SESSION['shopping_cart']);
}

if (filter_input(INPUT_GET, 'action') == 'checkout')
{
//    unset($_SESSION['shopping_cart']);
//    print_r($_SESSION);
    header("location:cart.php");
}

//pre_r($_SESSION);

function pre_r($array)
{
    echo '<pre>' . print_r($array) . '</pre>';
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Webshop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include_once 'header.php'; ?>
<div class="container">
    <div class="col-md-12 mb-3">
        <?php
        if ($_SESSION['level'] == 'klant')
        {
        ?>
            <h3 id="title" class="text-center">Welkom <?php echo $_SESSION['gebruikersnaam']; ?></h3>
            <a class="btn btn-primary" style="float: right;" href="logout.php">Logout</a>
        <?php
        }
        else
        {
            ?>
            <a class="btn btn-primary" style="float: right;" href="inlog.php">Login</a>
            <?php
        }
        ?>
    </div>
    <?php
    // * dit is de is voor de connectie naar de database in de file.
    $connect = mysqli_connect('127.0.0.1', 'webshop', '#1Geheim', '84645_webshop');
    $query = 'SELECT * FROM product ORDER BY id_product ASC';
    $result = mysqli_query($connect, $query);

    if ($result):
        if (mysqli_num_rows($result)>0):
            while ($product = mysqli_fetch_assoc($result)):
//                print_r($product);
                ?>
                <div class="col-sm-4 col-md-3">
                    <form method="post" action="index.php?action=add&id_product=<?php echo $product['id_product']; ?>">
                        <div class="products">
                            <img src="img/<?php echo $product['img']; ?>" class="img-responsive" />
                            <h4 class="text-info"><?php echo $product['product']; ?></h4>
                            <h4 class="text-light">€ <?php echo $product['prijs']; ?></h4>
                            <input type="number" name="quantity" class="form-control" value="1" min="1" />
                            <input type="hidden" name="product" value="<?php echo $product['product']; ?>" />
                            <input class="text-light" type="hidden" name="prijs" value="<?php echo $product['prijs']; ?>" />
                            <?php
                            if ($product['voorraad'] == 0)
                            {
                                echo '<button type="button" class="btn btn-danger mt-1" disabled>Uiterverkocht</button>';
                            } else {
                                ?>
                                <input type="submit" name="add_to_cart" class="btn btn-info mt-1" value="Add to Cart" />
                                <?php
                            }
                            echo '<a class="btn btn-warning" href="info.php?id_product=' . $product['id_product'] . '">Info</a>';
                            ?>
                        </div>
                    </form>
                </div>
                <?php
            endwhile;
        endif;
    endif;
    ?>
    <div style="clear: both"></div>
    <br />
    <div class="table-responsive">
        <table class="table">
            <tr><th colspan="5"><h3>Order details</h3></th></tr>
            <tr>
                <th width="40%">Product Name</th>
                <th width="10%">Quantity</th>
                <th width="20%">Price</th>
                <th width="15%">Total</th>
                <th width="5%">Action</th>
            </tr>
            <?php
            if (!empty($_SESSION['shopping_cart'])):

                $total = 0;

                foreach($_SESSION['shopping_cart'] as $key => $product):
            ?>
            <tr>
                <td><?php echo $product['product']; ?></td>
                <td><?php echo $product['quantity']; ?></td>
                <td>€ <?php echo $product['prijs']; ?></td>
                <td>€ <?php echo number_format($product['quantity'] * $product['prijs'], 2); ?></td>
                <td>
                    <a href="index.php?action=delete&id_product=<?php echo $product['id_product']; ?>">
                        <div class="btn btn-danger">Remove</div>
                    </a>
                </td>
            </tr>
            <?php
                    $total = $total + ($product['quantity'] * $product['prijs']);
                endforeach;
            ?>
            <tr>
                <td colspan="3" align="right">Total</td>
                <td align="right">€ <?php echo number_format($total, 2); ?></td>
                <td></td>
            </tr>
            <tr>
<!--                Alleen de uitchecken knop tonen als de winkelwagen niet leeg is-->
                <td colspan="5">
                    <?php
                    if (isset($_SESSION['shopping_cart'])):
                    if (count($_SESSION['shopping_cart']) > 0):
                    ?>
                        <a href="index.php?action=checkout" class="button">Checkout</a>
                    <?php endif; endif; ?>
                </td>
            </tr>
            <?php endif; ?>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>