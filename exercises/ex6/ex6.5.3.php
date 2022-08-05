<!DOCTYPE html>
<html>

<head>
    <title>ex6-5-2.php</title>
</head>

<body>
    <?php
    function sumBetween($n1, $n2)
    {
        $sum = 0;
        if ($n1 < $n2) {
            for ($i = $n1; $i <= $n2; $i++) {
                $sum += $i;
            }
        } else {
            for ($i = $n1; $i >= $n2; $i--) {
                $sum += $i;
            }
        }
        echo $sum;
    }
    sumBetween(5, 10);
    echo "<br>";
    sumBetween(12, 8);
    ?>
</body>

</html>