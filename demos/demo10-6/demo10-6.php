<?php
$f = fopen("text.txt", "r");

#1. READ CHARACTER BY CHARACTER.
do {
    $c = fgetc($f);
    if ($c) {
        if ($c == "\n") {
            echo "<br>";
        } else {
            echo $c;
        }
    }
} while ($c);
rewind($f);
echo "<br><br>";

#2.READ LINE BY LINE.
do {
    $d = fgets($f);
    if ($d) {
        echo $d . '<br>';
    }
} while ($d);
rewind($f);
echo "<br>";

#3. WHILE NOT END OF THE FILE.
while (!feof($f)) {
    $c = fgetc($f);
    if ($c) {
        if ($c == "\n") {
            echo "<br>";
        } else {
            echo $c;
        }
    }
}

fclose($f);
