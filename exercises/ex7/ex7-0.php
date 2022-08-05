<!DOCTYPE html>
<html>

<head>
    <title>ex6-5-2.php</title>
</head>

<body>
    <style>
        table,
        tr,
        th,
        td {
            margin: 1%;
            border: 1px solid black;
        }
    </style>
    <?php

    use function PHPSTORM_META\map;

    $products = [
        [
            'id' => 'td1234',
            'name' => 'lawn mower',
            'price' => 199.99,
            'weight' => 50,
        ],
        [
            'id' => 'ra9xfg',
            'name' => 'rake',
            'price' => 19.99,
            'weight' => 5,
        ],
        [
            'id' => 'pe4532',
            'name' => 'shovel',
            'price' => 19.99,
            'weight' => 5,
        ],
    ];

    function getKeys($table)
    {
        echo $table;
    }

    function echoHeader($key)
    {
        echo "<td>$key</td>";
    }

    function dataToTD($data)
    {
        $toReturn = ["<td>", $data, "</td>"];
        return implode("", $toReturn);
    }

    function echoRows($table)
    {
        echo "<tr>";
        $row = "";
        $row .= dataToTD($table["id"]);
        $row .= dataToTD($table["name"]);
        $row .= dataToTD($table["price"]);
        $row .= dataToTD($table["weight"]);
        $row .= "</td>";
        echo $row;
        echo "</tr>";
    }

    function part1And2TableDisplay($table)
    {
        echo "<table>";

        echo "<tr>";
        foreach (array_keys($table[0]) as $header) {
            echo "<th>$header</th>";
        }
        echo "</tr>";

        foreach ($table as $row) {
            echo "<tr>";
            foreach (array_keys($table[0]) as $key) {
                echo "<td>" . $row[$key] . "</td>";
            }
            echo "</tr>";
        }

        echo "</table>";
    }

    function part3TableDisplay($table)
    {
        echo "<table>";

        $tableKeys = array_keys($table[0]);
        echo "<tr>";
        array_map("echoHeader", $tableKeys);
        echo "</tr>";

        array_map("echoRows", $table);
        echo "</table>";
    }

    #part1And2TableDisplay($products);
    echo "<br><br>";
    part3TableDisplay($products);
    ?>
</body>

</html>