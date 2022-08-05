<?php

function logVisitor()
{
    $f = fopen("log" . DIRECTORY_SEPARATOR . "visitor.log", "a");
    fwrite($f, date(DATE_RFC2822) . "\n");
    fclose($f);
}

function viewCount($path)
{
    logVisitor();

    $views = file_get_contents($path);
    file_put_contents($path, $views + 1);
}
