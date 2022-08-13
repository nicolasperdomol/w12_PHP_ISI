<?php
const DB_HOST = '127.0.0.1'; //local server on my own laptop
const DB_PORT = 3306; //default is 3306 for an SQL server
const DB_NAME = 'teachers'; //for example
const DB_CHARSET = 'utf8mb4'; //for French accent set charset
const DB_USER_NAME = 'root';
const DB_USER_PW = 'Np!1202236';

function read_teachers_ordered_by_region_yearHired()
{
    $DB = new mysqli(DB_HOST, DB_USER_NAME, DB_USER_PW, DB_NAME, DB_PORT);
    mysqli_set_charset($DB, DB_CHARSET);

    if (mysqli_connect_errno()) {
        http_response_code(500); // server error
        exit('Database Connection failed:' . mysqli_connect_error());
    }

    $sql_str = "SELECT region, yearHired, id, name, position FROM teachers.teachers ORDER BY region, yearHired;";
    $result = $DB->query($sql_str);

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


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Website</title>
    <link rel="stylesheet" href="./style.css">
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
    <table>
        <tr>
            <th>Region</th>
            <th>Year Hired</th>
            <th>Id</th>
            <th>Name</th>
            <th>Position</th>
        </tr>
        <?php
        $teachers = read_teachers_ordered_by_region_yearHired();
        foreach ($teachers as $teacher) {
            $row_content = "<tr>";
            $row_content .= "<td>" . $teacher["region"] . "</td>";
            $row_content .= "<td>" . $teacher["yearHired"] . "</td>";
            $row_content .= "<td>" . $teacher["id"] . "</td>";
            $row_content .= "<td>" . $teacher["name"] . "</td>";
            $row_content .= "<td>" . $teacher["position"] . "</td>";
            $row_content .= "</tr>";
            echo $row_content;
        }
        ?>
    </table>
</body>

</html>