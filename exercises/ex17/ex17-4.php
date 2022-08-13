<?php
const DB_HOST = '127.0.0.1'; //local server on my own laptop
const DB_PORT = 3306; //default is 3306 for an SQL server
const DB_NAME = 'teachers'; //for example
const DB_CHARSET = 'utf8mb4'; //for French accent set charset
const DB_USER_NAME = 'root';
const DB_USER_PW = 'root';

function read_teachers_by_region($region)
{
    $DB = new mysqli(DB_HOST, DB_USER_NAME, DB_USER_PW, DB_NAME, DB_PORT);
    mysqli_set_charset($DB, DB_CHARSET);

    if (mysqli_connect_errno()) {
        http_response_code(500); // server error
        exit('Database Connection failed:' . mysqli_connect_error());
    }

    $sql_str = "SELECT *  FROM teachers.teachers WHERE region = ?;";
    $stmt = $DB->prepare($sql_str);
    $stmt->bind_param('s', $region);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        // -no results only if error in query
        // -if query is good but returns no records, the code below not executed
        // because query() will return true (ok)
        http_response_code(500); // server error
        // display error message
        exit('Database SQL Error: ' . $DB->error);
    }

    // convert records ony by one into an array with key=>value pairs
    // initialize an empty array;
    $teachers = [];
    while ($teacher = $result->fetch_array()) {
        array_push($teachers, $teacher);
    }
    mysqli_free_result($result);
    mysqli_close($DB);
    return $teachers;
}

function read_regions()
{
    $DB = new mysqli(DB_HOST, DB_USER_NAME, DB_USER_PW, DB_NAME, DB_PORT);
    mysqli_set_charset($DB, DB_CHARSET);

    if (mysqli_connect_errno()) {
        http_response_code(500); // server error
        exit('Database Connection failed:' . mysqli_connect_error());
    }

    $sql_str = "SELECT region from teachers group by region";
    $stmt = $DB->prepare($sql_str);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        // -no results only if error in query
        // -if query is good but returns no records, the code below not executed
        // because query() will return true (ok)
        http_response_code(500); // server error
        // display error message
        exit('Database SQL Error: ' . $DB->error);
    }

    // convert records ony by one into an array with key=>value pairs
    // initialize an empty array;
    $regions = [];
    while ($region = $result->fetch_array()) {
        array_push($regions, $region[0]);
    }
    mysqli_free_result($result);
    mysqli_close($DB);
    return $regions;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Website</title>

    <link rel="icon" href="./favicon.ico" type="image/x-icon">
</head>

<body>
    <style>
        table,
        th,
        td,
        tr {
            border: 1px solid;
        }
    </style>
    <form method="POST">
        <select name="region" id="region">
            <?php
            $regions = read_regions();
            foreach ($regions as $region) {
                echo "<option value=$region>$region</option>";
            }
            ?>
        </select>
        <button type="submit">search</button>
    </form>
    <table>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Year Hired</th>
            <th>Rank</th>
            <th>School</th>
            <th>Region</th>
            <th>Position</th>
        </tr>
        <?php
        if (isset($_POST["region"])) {
            $teachers = read_teachers_by_region($_POST["region"]);
            foreach ($teachers as $teacher) {
                $row_content = "<tr>";
                $row_content .= "<td>" . $teacher["id"] . "</td>";
                $row_content .= "<td>" . $teacher["name"] . "</td>";
                $row_content .= "<td>" . $teacher["yearHired"] . "</td>";
                $row_content .= "<td>" . $teacher["rank"] . "</td>";
                $row_content .= "<td>" . $teacher["school_name"] . "</td>";
                $row_content .= "<td>" . $teacher["region"] . "</td>";
                $row_content .= "<td>" . $teacher["position"] . "</td>";
                $row_content .= "</tr>";
                echo $row_content;
            }
        } else {
            echo "<h3>Please select a region . . .</h3>";
        }
        ?>
    </table>
</body>

</html>