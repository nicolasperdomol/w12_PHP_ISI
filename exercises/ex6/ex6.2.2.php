<?php
const FIRST_DISCOUNT_AMOUNT = 100;

function getPicturesCost($nbPics)
{
    if ($nbPics >= 0 and $nbPics <= FIRST_DISCOUNT_AMOUNT) {
        return number_format((5 * $nbPics) / 100, 2, ".", "'");
    } elseif ($nbPics > FIRST_DISCOUNT_AMOUNT) {
        return number_format(((FIRST_DISCOUNT_AMOUNT * 5) + (($nbPics - 100) * 3)) / 100, 2, ".", "'");
    } else {
        echo "nbPics cannot be a negative number";
        return -1;
    }
}

echo getPicturesCost(70) . "<br>";
echo getPicturesCost(130);
