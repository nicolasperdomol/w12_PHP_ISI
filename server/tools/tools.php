<?php

function logVisitor()
{
    $f = fopen("log" . DIRECTORY_SEPARATOR . "visitor.log", "a");
    fwrite($f, date(DATE_RFC2822) . " " . $_SERVER["REMOTE_ADDR"] . "\n");
    fclose($f);
}

function viewCount($path)
{
    logVisitor();

    $views = file_get_contents($path);
    file_put_contents($path, $views + 1);
}

function checkInput($name, $maxlength = 0)
{
    if (isset($_REQUEST[$name])) {
        if (($maxlength > 0) and (strlen($_REQUEST[$name])) > $maxlength) {
            header("HTTP/1.0 400 Input greater than maxlength in tools::checkInput()");
            exit("HTTP/1.0 400 Input greater than maxlength in tools::checkInput()");
        }
        return htmlspecialchars($_REQUEST[$name]);
    } else {
        header("HTTP/1.0 400 Input $name missing on the login form in users.php");
        exit("HTTP/1.0 400 Input $name missing on the login form in users.php");
    }
}

function fillValue($request, $parameter, $maxlength)
{

    if ($request == null or $request[$parameter] == '') {
        return '';
    }

    $value = checkInput($parameter, $maxlength);
    return "value = '$value'";
}
