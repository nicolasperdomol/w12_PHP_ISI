<?php
/* EXERCISE 3-1A and 3-1B */
/* EXERCISE 3-1B */
/* GLOBAL CONSTANTS */
const COMPANY_LOGO = 'red_jersey.jpg';
const COMPANY_NAME = 'ManchesterUnitedCanada.com';
const COMPANY_STREET_ADDRESS = '5340 St-Laurent';
const COMPANY_CITY = 'Montréal';
const COMPANY_PROVINCE = 'QC';
const COMPANY_COUNTRY = 'Canada';
const COMPANY_POSTAL_CODE = 'J0P 1T0';
const COMPANY_PHONE_NUMBER = '514-834-0059';
const COMPAY_EMAIL = "info@manchesterunitedcanada.com";
const PATH = "products_images/";

/* web page variable properties */
$lang = 'en-CA';
$title = 'Product List - ' . COMPANY_NAME . ' - Home Page';
$description = 'Scale Models of Classic Cars, Trucks, Planes, Motorcyles and more';
$author = 'Stéphane Lapointe';

$op = -1;
if (isset($_REQUEST['op'])) {
    $op = $_REQUEST['op'];
} else {
    $op = 1;
}

function productsList()
{
    global $products;
    $product_keys = array_keys($products[0]);

    $productList = "<table class=\"productsList\"><tr>";
    foreach ($product_keys as $key) {
        $productList .= "<th>$key</th>";
    }
    $productList .= "</tr>";
    foreach ($products as $product) {
        foreach ($product as $value) {
            $productList .= "<td>$value</td>";
        }
        $productList .= "</tr>";
    }
    $productList .= "</table>";
    echo $productList;
}

function productsCatalogue()
{
    global $products;
    $productCatalogue = "<table><tr>";
    foreach ($products as $product) {
        $productCatalogue .= "<td class=\"product\">";
        $productCatalogue .= "<div><img title=\"" . $product["name"] . "\" src=\"" . PATH . $product["pic"] . "\"></div>";
        $productCatalogue .= "<div class='name'>" . $product["name"] . "</div>";
        $productCatalogue .= "<div class='description'>" . $product["description"] . "</div>";
        $productCatalogue .= "<div class=\"price\">" . $product["price"] . "</div>";
        $productCatalogue .= "</td>";
    }
    $productCatalogue .= "</tr></table>";

    echo $productCatalogue;
}

// list of 6 products as it would be retrieved from a database
$products = [
    [
        'id' => 0,
        'name' => 'Red Jersey',
        'description' => 'Manchester United Home Jersey, red, sponsored by Chevrolet',
        'price' => 59.99,
        'pic' => 'red_jersey.jpg',
        'qty_in_stock' => 200,
    ],
    [
        'id' => 1,
        'name' => 'White Jersey',
        'description' => 'Manchester United Away Jersey, white, sponsored by Chevrolet',
        'price' => 49.99,
        'pic' => 'white_jersey.jpg',
        'qty_in_stock' => 133,
    ],
    [
        'id' => 2,
        'name' => 'Black Jersey',
        'description' => 'Manchester United Extra Jersey, black, sponsored by Chevrolet',
        'price' => 54.99,
        'pic' => 'black_jersey.jpg',
        'qty_in_stock' => 544,
    ],
    [
        'id' => 3,
        'name' => 'Blue Jacket',
        'description' => 'Blue Jacket for cold and raniy weather',
        'price' => 129.99,
        'pic' => 'blue_jacket.jpg',
        'qty_in_stock' => 14,
    ],
    [
        'id' => 4,
        'name' => 'Snapback Cap',
        'description' => 'Manchester United New Era Snapback Cap- Adult',
        'price' => 24.99,
        'pic' => 'cap.jpg',
        'qty_in_stock' => 655,
    ],
    [
        'id' => 5,
        'name' => 'Champion Flag',
        'description' => 'Manchester United Champions League Flag',
        'price' => 24.99,
        'pic' => 'champion_league_flag.jpg',
        'qty_in_stock' => 321,
    ],
];
?>


<!-- WEB PAGE TEMPLATE BELOW ========================== -->
<!DOCTYPE html>
<html lang="<?= $lang ?>">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="global.css">
    <title><?= $title ?></title>
    <link rel="icon" type="image/x-icon" href="<?= PATH . COMPANY_LOGO ?>">
    <meta name="description" content="<?= $description ?>">
    <meta name="author" content="<?= $author ?>">

    <!--IMPORTANT for responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        header {
            background-color: black;
            color: white;
            padding: 10px;
        }

        nav {
            background-color: grey;
            color: white;
            padding: 10px;
        }

        footer {
            background-color: black;
            color: white;
            padding: 10px
        }
    </style>
</head>

<body>

    <!-- PAGE HEADER -->
    <header>
        <img width="50px" src="<?= PATH . COMPANY_LOGO ?>" alt="COMPANY-LOGO-ICON">
        <h2 style="display:inline">
            ManchesterUnitedCanada.com

        </h2>
    </header>

    <!-- NAVIGATION BAR-->
    <nav>
        <a href='ex7-8?op=1'>Product List</a>
        <a href='ex7-8?op=2'>Product Catalogue</a>
    </nav>

    <main>
        <?php
        global $op;
        switch ($op) {
            case 1:
                productsList();
                break;
            case 2:
                productsCatalogue();
                break;
            default:
                echo "INVALID OPERATION";
        }
        ?>
    </main>


    <!-- FOOTER -->
    <footer>
        Designed by <?= $author ?> &copy;<br>
        <?= COMPANY_NAME . "<br>" ?>
        <?= COMPANY_STREET_ADDRESS . " " . COMPANY_CITY . " " . COMPANY_POSTAL_CODE . " " . COMPANY_COUNTRY . "<br>"  ?>
        <?= COMPANY_PHONE_NUMBER . " | " . COMPAY_EMAIL . "<br>"  ?>
    </footer>
    </div>
</body>

</html>