<?php
//Exercise 7-3
const IMG_PATH = 'weather_images/';

$forecasts = [
    '2018-02-11' => [
        'image_file' => 'degagement.gif',
        'image_desc' => 'clearing skies',
        'temperature' => '-17ºC',
        'temperature' => '-17ºC',
    ],
    '2018-02-12' => [
        'image_file' => 'soleil_nuage.gif',
        'image_desc' => 'sunny with clouds',
        'temperature' => '-11ºC',
    ],
    '2018-02-13' => [
        'image_file' => 'neige.gif',
        'image_desc' => 'snow',
        'temperature' => '-12ºC',
    ],
    '2018-02-14' => [
        'image_file' => 'soleil.gif',
        'image_desc' => 'sunny',
        'temperature' => '-15ºC',
    ],
    '2018-02-15' => [
        'image_file' => 'neige.gif',
        'image_desc' => 'snow',
        'temperature' => '-11ºC',
    ],
    '2018-02-16' => [
        'image_file' => 'soleil.gif',
        'image_desc' => 'sunny',
        'temperature' => '-15ºC',
    ],
];

$forecast_keys = array_keys($forecasts);

function getWeatherTable($forecast, $forecast_key)
{
    return "<tr><td>" . $forecast_key . "<img src=\"images/" . $forecast["image_file"] . "\" alt=\"" . $forecast["image_desc"] . "\">" . $forecast["temperature"] . "<td></tr>";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <title>Exercise 7-3 Weather forecast</title>
    <style>
        body {
            width: 300px;
            margin: auto;
            border: 1px solid darkgrey;
            padding: 5px;
        }
    </style>

</head>

<body>
    <div>
        <header>
            <h1>Weather forecast</h1>
        </header>
        <main>
            <table>
                <?php
                $weatherTable = implode("", array_map("getWeatherTable", $forecasts, $forecast_keys));
                echo $weatherTable;
                ?>
            </table>
        </main>
    </div>
</body>

</html>