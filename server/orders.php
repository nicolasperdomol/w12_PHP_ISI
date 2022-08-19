<?php
require_once "db_pdo.php";
class orders
{
    public static function list($message = null)
    {
        $DB = new db_pdo();
        $DB->connect();
        $qry = "SELECT `orders`.`orderNumber`, `orders`.`orderDate`, `orders`.`status`, `orders`.`customerNumber` FROM `orders`";
        $orders = $DB->querySelect($qry);
        $DB->disconnect();

        $tbody_content = "";
        foreach ($orders as $order) {
            $tbody_content .= <<<HTML
                    <tr>
                        <th scope="row"><a href="index.php?op=202&orderNumber={$order['orderNumber']}">{$order["orderNumber"]}</a></th>
                        <td>{$order["orderDate"]}</td>
                        <td>{$order["status"]}</td>
                        <td>{$order["customerNumber"]}</td>
                        <td>
                            <form class='order_list_form' action="index.php" method='POST'>
                                <input type='hidden' name='op' value='202'>
                                <input type='hidden' name='orderNumber' value="{$order['orderNumber']}">
                                <button class="btn btn-outline-info" type="submit">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    </button>
                                </form>
                            <form class='order_list_form' action="index.php" method="POST">
                                    <input type="hidden" name="op" value="203">
                                    <input type="hidden" name="orderNumber" value="{$order['orderNumber']}">
                                    <button class="btn btn-outline-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                            </form>
                        </td>
            HTML;
        }

        $page_data = DEFAULT_PAGE_DATA;
        $page_data['title'] = "Order list";
        $page_data['content'] = "";
        $page_data['content'] .= ($message != null ? "<div class=\"alert alert-danger\" role=\"alert\"><b>$message</b></div>" : '');
        $page_data['content'] .= <<<HTML
            <table class='table table-dark table-striped'>
                <thead>
                    <tr>
                        <th scope='col'>Order No</th>
                        <th scope='col'>Order date</th>
                        <th scope='col'>Status</th>
                        <th scope='col'>Customer Number</th>
                        <th scope='col'>Actions</th>
                        </tr>
                </thead>
                <tbody>
                    {$tbody_content}
                </tbody>
            </table>
        HTML;
        webpage::render($page_data);
    }

    public static function display()
    {
        $orderNumber = isset($_REQUEST['orderNumber']) ? $_REQUEST['orderNumber'] : null;
        $order = orders::select_order_by_orderNumber($orderNumber);
        $order_details = orders::select_order_details_by_orderNumber($orderNumber);
        if (count($order) != 1) {
            header("HTTP/1.0 404 orderNumber do not match with any record");
            return;
        }
        $order = $order[0];
        #var_dump($order_details);

        $tbody_content = "";
        $total_price = 0;
        foreach ($order_details as $order_detail) {
            $sub_total = $order_detail['quantityOrdered'] * $order_detail['priceEach'];
            $total_price += $sub_total;
            $tbody_content .= <<<HTML
            <tr>
                <th scope="row">{$order_detail['productCode']}</th>
                <td>{$order_detail['quantityOrdered']}</td>
                <td>$ {$order_detail['priceEach']}</td>
                <td>$ {$sub_total}</td>
            </tr>
        HTML;
        }
        $tbody_content .= "<tr><td colspan='1'><b>Total:</b></td><td class='text-end' colspan='3'>$ {$total_price}</td></tr>";



        $page_data = DEFAULT_PAGE_DATA;
        $page_data['title'] = "order " . $order['orderNumber'];
        $page_data['content'] = "";
        $page_data['content'] .= <<<HTML
            <br>
            <div class='container'>
                <div class='row justify-content-center'>
                    <a href='index.php?op=200'><< Display orders</a>
                    <br>
                    <div class='col-3'>
                        <div><b>Order Number: </b></div>
                        <div><b>Customer Number: </b></div>
                        <div><b>Order status: </b></div>
                        <div><b>Order Date: </b></div>
                        <div><b>Required Date: </b></div>
                        <div><b>Shipped Date: </b></div>
                    </div>
                    <div class='col-3'>
                        <div><i>{$order['orderNumber']}</i></div>
                        <div><i>{$order['customerNumber']}</i></div>
                        <div><i>{$order['status']}</i></div>
                        <div><i>{$order['orderDate']}</i></div>
                        <div><i>{$order['requiredDate']}</i></div>
                        <div><i>{$order['shippedDate']}</i></div>
                    </div>
                </div>
                <br>
                <div class='row justify-content-center'>
                    <div class='col-6'>
                        <table class='table table-bordered'>
                            <thead>
                                <tr>
                                    <th scope="col">Product code</th>
                                    <th scope="col">Quantity ordered</th>
                                    <th scope="col">Unit price</th>
                                    <th scope="col">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                {$tbody_content}
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class='row justify-content-center'>
                    <div class='col-3'>
                        <br>

                        <br><br>
                        <div><b>Comments: </b></div>
                    </div>
                    <div class='col-3'>
                        <br>
                        <form class='order_list_form' action="index.php" method="POST">
                                    <input type="hidden" name="op" value="203">
                                    <input type="hidden" name="orderNumber" value="{$order['orderNumber']}">
                                    <button class="btn btn-outline-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                            </form>
                        <br><br>
                        <div><i>{$order['comments']}</i></div>
                    </div>
                </div>
                <br>
            </div>
        HTML;
        webpage::render($page_data);
    }

    public static function edit($message = null, $autofill = null, $success_message = null)
    {

        if (!isset($_REQUEST['orderNumber'])) {
            header("HTTP/1.0 400 orderNumber required");
        }
        $order = orders::select_order_by_orderNumber($_REQUEST['orderNumber']);
        if (count($order) == 0 or $order == null) {
            header("HTTP/1.0 404 order not found");
        }
        $order = $order[0];

        $page_data = DEFAULT_PAGE_DATA;
        $page_data['title'] = "Editing order " . $_REQUEST['orderNumber'];
        $page_data['content'] = "";
        $page_data['content'] .= ($message != null ? "<div class=\"alert alert-danger\" role=\"alert\"><b>$message</b></div>" : '');
        $page_data['content'] .= ($success_message != null ? "<div class=\"alert alert-success\" role=\"alert\"><b>$success_message</b></div>" : '');
        $page_data['content'] .= <<<HTML
            <br>
            <div class='container'>
                <div class='row justify-content-center'>
                    <a href='index.php?op=200'><< Display orders</a>
                    <br>
                    <div class='col-3'>
                        <form action='index.php'>
                            <input type='hidden' name='op' value='205'>
                            <input type='hidden' name='orderNumber' value="{$order['orderNumber']}">
                            <label>Order number: <input type='number' name='orderNumber' value="{$order['orderNumber']}" disabled></label>
                            <label>Order date: <input type="date" name='orderDate' value='{$order["orderDate"]}'></label>
                            <label>Required date: <input type="date" name='requiredDate' value='{$order["requiredDate"]}'></label>
                            <label>Shipped date: <input type="date" name='shippedDate' value='{$order["shippedDate"]}'></label>
                            <label>Status: <input type="text" name='status' value='{$order["status"]}'></label>
                            <label>Customer number: <input type="number" name='customerNumber' value='{$order["customerNumber"]}'></label>
                            <label>Comments: <input type="textarea" name='comments' value='{$order["comments"]}' rows="4" cols="50"></label>

                            <button class='btn btn-primary' type='submit'>save</button>
                        </form>
                    </div>
                </div>
            </div>
            <br>
        HTML;
        webpage::render($page_data);
    }

    public static function save()
    {
        $orderNumber = checkInput('orderNumber', 11);
        $orderDate =  checkInput('orderDate');
        $requiredDate = checkInput('requiredDate');
        $status = checkInput('status');
        $customerNumber = checkInput('customerNumber', 11);
        $customer = orders::select_customer_by_customerNumber($customerNumber);
        $shippedDate = isset($_REQUEST['shippedDate'])  ? $_REQUEST['shippedDate'] : "";
        $comments = isset($_REQUEST['comments']) ? $_REQUEST['comments'] : "";

        if (count($customer) == 0) {
            orders::edit("This is not a valid user");
            return;
        }
        $result = orders::update_order_by_orderNumber([$orderDate, $requiredDate, $shippedDate, $status, $comments, $customerNumber, $orderNumber]);
        if (($result->rowCount()) > 0)
            orders::edit(null, null, "Order saved");
        else
            orders::edit(null, null, "");
    }

    private static function update_order_by_orderNumber($params)
    {
        $DB = new db_pdo();
        $DB->connect();
        $qry = "UPDATE `orders` SET `orderDate` = ?, `requiredDate` = ?, `shippedDate` = ?, `status` = ?, `comments` = ?, `customerNumber` = ? WHERE `orders`.`orderNumber` = ?";
        $order = $DB->queryParam($qry, $params);
        $DB->disconnect();
        return $order;
    }
    private static function select_order_by_orderNumber($id)
    {
        $DB = new db_pdo();
        $DB->connect();
        $qry = "SELECT * FROM orders WHERE orderNumber=?";
        $params = [$id];
        $order = $DB->querySelectParam($qry, $params);
        $DB->disconnect();
        return $order;
    }
    private static function select_order_details_by_orderNumber($id)
    {
        $DB = new db_pdo();
        $DB->connect();
        $qry = "SELECT * FROM `orderdetails`JOIN orders ON `orders`.orderNumber = `orderdetails`.orderNumber JOIN `products` ON `products`.`productCode` = `orderdetails`.`productCode` WHERE `orderdetails`.orderNumber=?";
        $params = [$id];
        $order_details = $DB->querySelectParam($qry, $params);
        $DB->disconnect();
        return $order_details;
    }
    private static function select_customer_by_customerNumber($id)
    {
        $DB = new db_pdo();
        $DB->connect();
        $qry = "SELECT * FROM customers WHERE customerNumber=?";
        $params = [$id];
        $customer = $DB->querySelectParam($qry, $params);
        $DB->disconnect();
        return $customer;
    }
    private static function select_status()
    {
    }
}
