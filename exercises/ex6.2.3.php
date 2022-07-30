<?php
const FIXED_RATE_PER_DAY = 0.5;

function getElectricityTotal($day_no, $kWh)
{
    $total_per_days = $day_no * FIXED_RATE_PER_DAY;

    if ($kWh >= 0 and $kWh <= 200) {
        return ($kWh * 0.3) + $total_per_days;
    } elseif ($kWh > 200) {
        return (200 * 0.3) + (($kWh - 200) * 0.2) + $total_per_days;
    } else {
        echo "kWh cannot be negative";
        return -1;
    }
}

echo getElectricityTotal(60, 180) . "<br>";
echo getElectricityTotal(60, 350);
