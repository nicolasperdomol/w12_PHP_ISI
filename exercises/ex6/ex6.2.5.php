<?php
function swap(&$a, &$b)
{
    $temp = $a;
    $a = $b;
    $b = $temp;
}

function sortAsc($n1, $n2, $n3)
{
    if ($n3 < $n2)
        swap($n3, $n2);
    if ($n3 < $n1)
        swap($n3, $n1);
    if ($n2 < $n1) {
        swap($n2, $n1);
    }
    echo "$n1, $n2, $n3<br>";
}

sortAsc(34, 356, 999); // all show on console 34, 356, 999
sortAsc(356, 34, 999);
sortAsc(999, 356, 34);
sortAsc(34, 999, 356);
