<?php
/* EXERCISE 3-1A and 3-1B */
/* EXERCISE 3-1B */
require_once "globals.php";
require_once "products.php";
require_once "view/webpage.php";
require_once "tools/tools.php";

createFiles();
$op = -1;
if (isset($_REQUEST['op'])) {
    $op = $_REQUEST['op'];
} else {
    $op = 0;
}

function createFiles()
{
    $listPath = "log" . DIRECTORY_SEPARATOR . "productsListCounter.txt";
    $cataloguePath = "log" . DIRECTORY_SEPARATOR . "productsCatalogueCounter.txt";
    if (!file_exists($listPath)) {
        file_put_contents($listPath, "0");
    }
    if (!file_exists($cataloguePath)) {
        file_put_contents($cataloguePath, "0");
    }
}

switch ($op) {
    case 0:
        $pageData = DEFAULT_PAGE_DATA;
        $pageData['title'] = "HOME";
        $pageData['description'] = "HOME";
        $pageData['content'] = "<h2>Welcome to the home page!</h2>";
        webpage::render($pageData);
        break;

    case 50:
        //file download from server to client
        // set the file type, here a PDF file, see link below for other file types
        header('Content-type: application/pdf');
        // file name is some_file.pdf, the web browser asks to confirm the download
        header('Content-Disposition: attachment; filename=some_file.pdf');
        // send out the file, read and send directly with readfile() function
        readfile('some_file.pdf');
        break;

    case 51:
        header("location: http://www.amazon.ca");
        break;

    case 100:
        products::productsList();
        break;
    case 101:
        products::productsCatalogue();
        break;
    default:
        header("HTTP/1.0 400 This operation won't be implemented in the near future, try a different operation.");
        $pageData = DEFAULT_PAGE_DATA;
        $pageData['title'] = "INVALID OPERATION";
        $pageData['description'] = "INVALID OPERATION";
        $pageData['content'] = "INVALID OPERATION";
        webpage::render($pageData);
}

#webpage::render(DEFAULT_PAGE_DATA);
