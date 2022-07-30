<!DOCTYPE html>
<html lang="en-CA">

<head>
    <meta charset="UTF-8">
    <title>test</title>
</head>

<body>
    <h1>First page</h1>
    <?php
    //Start of php program
    //$name = "Nicolas";

    $name = $_REQUEST['name']; //Reads input value
    for ($i = 0; $i < 10; $i++) {
        echo "My name is " . $name . "<br>";
    }

    //phpinfo();
    $a;
    if (!isset($a)) {
        echo "IS TRUE";
    }

    /**
     * Shows the input name on the screen
     * @param string $name target object to be printed
     */
    function allo($name)
    {
        echo $name;
    }
    ?>
</body>

</html>