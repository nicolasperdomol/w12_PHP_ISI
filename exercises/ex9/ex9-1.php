<?php
//Exercise 9-1 Date and Time functions
// reference https://www.php.net/manual/fr/function.date.php
// date formating https://www.php.net/manual/fr/datetime.format.php


function showTitle($title)
{
    echo "<h2>&#9830; $title</h2>";
    echo '<hr/>';
}

showTitle('timezone specified in php.ini');
date_default_timezone_set("Canada/Eastern");
echo 'timezone:' . date_default_timezone_get();

showTitle('current timestamp, seconds since january 1st, 1970');
$t = time();
print_r($t);

showTitle('Create a timestamp for a given date 20h:25min:10s on 10 january 2019');
// 1st method with mktime
$t = mktime(20, 25, 10, 1, 10, 2019);
echo $t . "<br>";


//2nd method with strotime()
$t = strtotime('10 January 2019 20 hours 25 minutes 10 seconds');
echo $t;

showTitle('Exercise 1 full date and time in RFC2822 format');
echo date(DATE_RFC2822);

showTitle('Exercise 2 Day only');
echo date("d");

showTitle('Exercise 3 The Month only');
echo date("m") . "<br>";
echo date("M");

showTitle('Exercise 4 The Year only');
echo date("Y");

showTitle('Exercise 5 Date displayed like 10,january,2019');
echo date("d, F, Y");

showTitle('Exercise 6 Add 1 month and full display');
echo date(DATE_RFC2822, strtotime("+1 month"));

showTitle('Exercice 7 Number of days since 31 décembre 1973');
$now = date_create();
$olderDate = date_create("1973-12-31");
$dateInterval = date_diff($now, $olderDate);
echo $dateInterval->format("%a days");

showTitle('Exercice 8 Date displayed like Thurday, 10 january 2019');
echo date("l, d F Y");
