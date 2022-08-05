<!DOCTYPE html>
<html>

<head>
    <title>ex6-5-1.php</title>
</head>

<body>
    <?php
    function newLine()
    {
        echo "<br><br>";
    }
    function echoTitle($title)
    {
        echo "<h3><b>$title</b></h3>";
    }

    echoTitle("For loop:");
    for ($i = 0; $i < 6; $i++) {
        echo $i . "<br>";
    }
    newLine();
    echoTitle("While loop:"); {
        $i = 0;
        while ($i < 6) {
            echo $i . "<br>";
            $i++;
        }
    }
    newLine();
    echoTitle("Do while:"); {
        $i = 0;
        do {
            echo $i . "<br>";
            $i++;
        } while ($i < 6);
    }

    ?>
</body>

</html>