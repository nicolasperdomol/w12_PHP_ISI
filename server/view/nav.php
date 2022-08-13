<!-- NAVIGATION BAR-->
<nav>
    <a href='index.php?op=0'>Home</a>
    <a href='index.php?op=100'>Product List</a>
    <a href='index.php?op=101'>Product Catalogue</a>
    <a href='index.php?op=120'>ProductsJSON</a>
    <a href='index.php?op=50'>Download</a>
    <a href='index.php?op=51'>Redirect</a>
    <a href='index.php?op=400'>Customers</a>
    <a href='index.php?op=420'>CustomersJSON</a>

    <?php
    $default_options = <<<HTML
    <a href='index.php?op=1'>Login</a>
    <a href='index.php?op=3'>Register</a>
    HTML;

    if (!isset($_SESSION['email'])) {
        //Welcome page
        echo $default_options;
    } else {
        //After successfully login
        echo "<a href='index.php?op=5'>Logout</a><span>" . $_SESSION['email'] . "</span>";
    }

    ?>


</nav>