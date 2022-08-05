<?php
/* exercise 7-7 */
function showTitle($title)
{
    echo "<br/><b>&#9830; $title</b><br/>";
    echo '<hr/>';
}

$users = [
    [
        'id' => 2135,
        'first_name' => 'John',
        'last_name' => 'Doe',
    ],
    [
        'id' => 3245,
        'first_name' => 'Sally',
        'last_name' => 'Smith',
    ],
    [
        'id' => 5342,
        'first_name' => 'Jane',
        'last_name' => 'Jones',
    ],
    [
        'id' => 5623,
        'first_name' => 'Peter',
        'last_name' => 'Doe',
    ],
];

showTitle('Exercise 1: Display firstnames only without iterations using array_column() and implode()');
echo implode(" ", array_column($users, 'first_name'));

showTitle('Exercise 2: Display values that are different between $firstArray and $secondArray using array_diff()');
$firstArray = ['a' => 'car', 'b' => 'motorcycle', 'c' => 'plane'];
$secondArray = ['a' => 'car', 'f' => 'motorcycle'];
var_dump(array_diff($firstArray, $secondArray));

showTitle('Exercise 3: Reverse keys and values in $firstArray with array_flip()');
var_dump(array_flip($firstArray));
