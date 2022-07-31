<?php

//the NAV bar items
const HOME = 'Welcome';
const PRODUCT = 'Product Catalogue';
const ABOUT = 'About Us';
const IDEA = 'Gift Ideas';

// the selected item
$selected = ABOUT;

function echoListItem($value)
{
    global $selected;
    if ($selected != $value)
        echo "<li><a href=\"#\">$value</a></li>";
    else
        echo "<li class=\"selected\"><a href=\"#\">$value</a></li>";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Exercice 6-1 conditionnal CSS</title>
    <style>
        nav ul li {
            display: inline-block;
            width: 150px;
            padding: 4px;
            margin: 4px;
            text-align: center;
        }

        .menu-item {
            background-color: #e1f4f3;
            color: #0000cc;
        }

        .selected {
            background-color: #fea799;
        }
    </style>
</head>

<body>
    <h2>Exercise 6-1: Highlight the selected item in the nav bar</h2>
    <nav>
        <ul>
            <?php
            echoListItem(HOME);
            echoListItem(PRODUCT);
            echoListItem(ABOUT);
            echoListItem(IDEA);
            ?>
        </ul>
    </nav>
</body>

</html>