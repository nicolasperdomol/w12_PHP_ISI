<?php
class webpage
{
    public static function render($page_data)
    {
        #WEBSITE TEMPLATE
        require_once "head.php";
        require_once "header.php";
        require_once "nav.php";
        echo $page_data["content"];
        require_once "footer.php";
    }

    public static function updateViewCounter($path)
    {
        return file_get_contents($path);
    }
}
