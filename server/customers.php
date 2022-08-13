<?php
require_once "db_pdo.php";
class customers
{

    public static function list()
    {

        $DB = new db_pdo();
        $DB->connect();

        if (!isset($_REQUEST['customer_id']) or $_REQUEST['customer_id'] == "") {
            $customers = $DB->querySelect("SELECT customerNumber, customerName, country FROM customers");
        } else {
            $params = [$_REQUEST['customer_id']];
            $customers = $DB->querySelectParam("SELECT customerNumber, customerName, country FROM customers WHERE customerNumber = ?", $params);
        }

        $content = 'Number of customers found: ' . count($customers) . '</br>';
        $content .= '<label for="customer_id">Search by ID</label>';
        $content .= '<form action="index.php?op=400" method="POST">
                    <input type="text" name="customer_id"> <input type="submit" value="submit">
                    </form>';
        $content .= '<a href="index.php?op=400">List All</a>';


        $content .= '<div class="container"><h2>Customer List</h2></div>';
        $content .= '<div class="container"><table><tr>';
        $content .= '<th>Customer ID</th>';
        $content .= '<th>Customer Name</th>';
        $content .= '<th>Customer Country</th>';
        $content .= "</tr>";

        foreach ($customers as $single_customer) {
            $content .= '<tr>';
            foreach ($single_customer as $key => $value) {
                $content .= '<td>' . $value . '</td>';
            }
            $content .= "</tr>";
        }
        $content .= "</table></div>";

        $page_data = DEFAULT_PAGE_DATA;
        $page_data['title'] = COMPANY_NAME . "'s Customers List";
        $page_data['description'] = "Connect to shop and track your order.";
        $page_data['content'] = $content;
        webpage::render($page_data);
        die();
    }

    public static function listJSON()
    {
        $DB = new db_pdo();
        $DB->connect();

        $customers = $DB->table("customers");

        $arrayJSON = json_encode($customers, JSON_PRETTY_PRINT);
        header('Content-Type: application/json; charset=UTF-8');
        http_response_code(200);
        echo $arrayJSON;
    }
}
