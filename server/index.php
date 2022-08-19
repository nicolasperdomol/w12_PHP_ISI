<?php
session_start();
/* EXERCISE 3-1A and 3-1B */
/* EXERCISE 3-1B */
require_once "globals.php";
require_once "products.php";
require_once "view/webpage.php";
require_once "tools/tools.php";
require_once "users.php";
require_once "customers.php";
require_once "offices.php";

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

function home()
{
    $pageData = DEFAULT_PAGE_DATA;
    $pageData['title'] = "HOME";
    $pageData['description'] = "HOME";

    #detect client prefered language
    $lang = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);
    switch ($lang) {
        case 'es':
            $pageData["content"] = "<h2>Bienvendio a la pagina principal</h2>";
            break;
        default:
            //default to english
            $pageData["content"] = "<h2>Welcome to the home page!</h2>";
            break;
    }

    if (isset($_COOKIE['lastVisit'])) {
        $pageData['content'] .= "<br><span>Your last visit was on " . $_COOKIE['lastVisit'] . "</span>";
        setcookie('lastVisit', date(DATE_RFC2822), strtotime(+31536000));
    } else {
        $pageData['content'] .= "<br>Welcome, this is your first visit";
        setcookie('lastVisit', date(DATE_RFC2822), strtotime(+31536000));
    }
    webpage::render($pageData);
}

function main()
{
    //main-controller
    createFiles();
    $op = -1;
    if (isset($_REQUEST['op'])) {
        $op = $_REQUEST['op'];
    } else {
        $op = 0;
    }

    switch ($op) {
        case 0:
            home();
            break;

        case 1:
            //LOGIN
            users::login();
            break;

        case 2:
            //Form login verify
            users::loginVerify();
            break;

        case 3:
            //REGISTER
            users::register();
            break;
        case 4:
            //Regsiter validation
            users::registerVerify();
            break;

        case 5:
            //Log out
            users::logout();
            break;

        case 50:
            //file download from server to client
            // set the file type, here a PDF file, see link below for other file types
            header('Content-type: application/pdf');
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
        case 120:
            products::listJSON();
            break;
        case 400:
            if (isset($_SESSION["email"])) {
                customers::list();
            } else {
                header("location:index.php");
            }
            break;
        case 420:
            customers::listJSON();
            break;
        case 500:
            #gmail();
            if (isset($_SESSION["email"])) {
                offices::list();
            } else {
                header("HTTP/1.0 503 We are sorry, operation 511 first you must log in your account");
                $pageData = DEFAULT_PAGE_DATA;
                $pageData['content'] = "<div style='margin-top:1%; margin-bottom:1%;'><b>We are sorry but first you must log in your account <a href=\"index.php?op=1\">here</a></b></div>";
                webpage::render($pageData);
            }
            break;
        case 502:
            offices::display();
            break;
        case 503:
            offices::display_office_form();
            break;
        case 504:
            offices::delete();
            break;
        case 505:
            offices::save();
            break;
        case 509:
            offices::listJSON();
            break;
        default:
            header("HTTP/1.0 400 This operation won't be implemented in the near future, try a different operation.");
            $pageData = DEFAULT_PAGE_DATA;
            $pageData['title'] = "INVALID OPERATION";
            $pageData['description'] = "INVALID OPERATION";
            $pageData['content'] = "INVALID OPERATION";
            webpage::render($pageData);
    }
}

main();
