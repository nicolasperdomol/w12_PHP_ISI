<!DOCTYPE html>
<html>

<head>
    <title>ex6-5-2.php</title>
</head>

<body>
    <?php
    function displayBetween($n1, $n2)
    {
        if ($n1 < $n2) {
            for ($i = $n1; $i <= $n2; $i++) {
                echo "> " . $i . "<br>";
            }
        } else {
            for ($i = $n1; $i >= $n2; $i--) {
                echo "> " . $i . "<br>";
            }
        }
    }
    displayBetween(5, 10);
    echo "<br><br>";
    displayBetween(10, 5);
    ?>
</body>

</html>