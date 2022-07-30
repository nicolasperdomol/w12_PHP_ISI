<?php
function getMax($n1, $n2, $n3)
{
    if ($n1 > $n2 and $n1 > $n3)
        return $n1;
    elseif ($n2 > $n1 and $n2 > $n3)
        return $n2;
    return $n3;
}

echo (getMax(8, 52, 34)) . "<br>";
echo (getMax(108, 52, 34)) . "<br>";
echo (getMax(8, 52, 65)) . "<br>";
