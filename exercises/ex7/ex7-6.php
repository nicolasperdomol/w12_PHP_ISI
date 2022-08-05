<?php
//Exercise 7-6 array functions

use function PHPSTORM_META\type;

function arrayDisplay($array)
{
    echo '<table>';
    echo '<tr><th style="border:1px solid black">index/key</th><th style="border:1px solid black">value</th></tr>';
    foreach ($array as $key => $value) {
        echo '<tr><td style="border:1px solid black">' . $key . '</td><td style="border:1px solid black">' . $value . '</td></tr>';
    }
    echo '</table>';
}

function showTitle($title)
{
    echo "<br/><b>&#9830; $title</b><br/>";
    echo '<hr/>';
}

function arrayToUpper($color)
{
    return strtoupper($color);
}


$colors = [
    'red',
    'blue',
    'black',
    'green',
    'grey',
];

showTitle('Exercise 1 - Sort array in ascending order');
sort($colors);
arrayDisplay($colors);


showTitle('Exercise 2 - All uppercase using array_walk or array_map');
arrayDisplay(array_map("arrayToUpper", $colors));

showTitle('Exercise 3 - Merge $colors and $otherColors with array_merge()');

$otherColors = [
    'yellow',
    'purple',
    'black',
];

arrayDisplay(array_merge($colors, $otherColors));

showTitle('Exercise 4: one word per line with explode() and foreach');
$sentence = 'Hello my friends! How are you today?';
$splitted_sentence = explode(" ", $sentence);
arrayDisplay($splitted_sentence);

showTitle('Exercise 5: reverse the array with array_reverse()');
arrayDisplay(array_reverse($splitted_sentence));
