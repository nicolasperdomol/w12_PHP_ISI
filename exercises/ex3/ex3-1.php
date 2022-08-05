<?php
/* EXERCISE 3-1A and 3-1B */

/* web page variable properties */
$lang = 'en-CA';
$title = 'ClassicModels.com - Home Page';
$description = 'Scale Models of Classic Cars, Trucks, Planes, Motorcyles and more';
$author = 'Stéphane Lapointe';
$content = 'bla bla bla bla bla this is the page content';
?>

<!-- WEB PAGE TEMPLATE BELOW ========================== -->
<!DOCTYPE html>
<html lang="<?= $lang ?>">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
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
        <h2>
            ClassicModels.com
        </h2>
    </header>

    <!-- NAVIGATION BAR-->
    <nav>
        <a href='ex3-1.php'>Home</a>
    </nav>

    <!-- CONTENT -->
    <?= $content ?>

    <!-- FOOTER -->
    <footer>
        Designed by <?= $author ?> &copy;<br>
    </footer>
    </div>
</body>

</html>