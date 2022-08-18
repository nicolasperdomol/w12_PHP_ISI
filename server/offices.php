<?php
require_once "db_pdo.php";
class offices
{
    const MAX_STRLEN_OFFICE_CODE = 10;
    const MAX_STRLEN_CITY = 50;
    const MAX_STRLEN_PHONE = 50;
    const MAX_STRLEN_ADDRESS_LINE_1 = 50;
    const MAX_STRLEN_ADDRESS_LINE_2 = 50;
    const MAX_STRLEN_STATE = 50;
    const MAX_STRLEN_COUNTRY = 50;
    const MAX_STRLEN_POSTAL_CODE = 15;
    const MAX_STRLEN_TERRITORY = 10;


    /**
     * Operation #500: Present a table list based on the table 'Offices' from the classicmodels database,
     */
    public static function list($message = null)
    {
        $DB = new db_pdo();
        $DB->connect();
        $offices = $DB->querySelect("SELECT officeCode, city, addressLine1, country FROM offices");
        $page_data = DEFAULT_PAGE_DATA;
        $page_data["content"] = '<h2>List of our offices</h2>';
        $page_data['content'] .= ($message != null ? "<div class=\"alert alert-danger\" role=\"alert\"><b>$message</b></div>" : '');
        $page_data['content'] .= <<<HTML
        <form method="GET">
            <input type="hidden" name="op" value="502">
            <input style="width:100px" name="office_id" placeholder="office code" type="text"/>
            <button type="submit">search</button>
        </form>
       HTML;

        //display offices table
        $row_data = "";
        $office_count = 0;
        foreach ($offices as $office) {
            $row_data .= <<<HTML
                        <tr>
                            <th scope="row"><a href="index.php?op=502&office_id={$office['officeCode']}">{$office["officeCode"]}</a></th>
                            <td>{$office["city"]}</td>
                            <td>{$office["addressLine1"]}</td>
                            <td>{$office["country"]}</td>
                            <td>
            HTML;
            $row_data .= "<form class='office_list_form' action=\"index.php\" method=\"POST\">
                <input type=\"hidden\" name=\"op\" value=\"503\">
                <input type=\"hidden\" name=\"officeCode\" value=\"" . $office['officeCode'] . "\">
                <button class=\"btn btn-outline-success\"><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i></button>
            </form>";

            $row_data .= <<<HTML
                                <form class='office_list_form' action="index.php" method="POST">
                                    <input type='hidden' name='op' value='504'>
                                    <input type='hidden' name='office_id' value="{$office['officeCode']}">
                                    <button class="btn btn-outline-danger" type="submit">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    HTML;
            //On the last office add an extra row
            if ($office_count == count($offices) - 1) {
                $row_data .= <<<HTML
                            <tr class="table-light">
                                <td align="center" colspan=5>
                                    <form method="POST" action="index.php">
                                        <input type="hidden" name="op" value="503">
                                        <button class="btn btn-outline-primary" type="submit">+</button>
                                </td>
                            </tr>
                        HTML;
            }
            $office_count++;
        }


        $page_data["content"] .= <<<HTML
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">City</th>
                                <th scope="col">Address</th>
                                <th scope="col">Country</th>
                                <th scope="col">Modify</th>
                            </tr>
                        </thead>
                        <tbody>
                            {$row_data}
                        </tbody>
                    </table>
                HTML;

        webpage::render($page_data);
    }

    /**
     * Displays details of the selected record.
     * $_REQUEST["office_id"] may be used to present a single row of the table.
     */
    public static function display()
    {
        $DB = new db_pdo();
        $DB->connect();
        if (!isset($_REQUEST['office_id'])) {
            header("HTTP/1.0 400 offices::display() requires 'office_id' parameter and was not found in the request");
        } elseif ($_REQUEST['office_id'] == "") {
            header("HTTP/1.0 400 office::display() does not accept an empty string as a parameter for 'office_id'");
            self::list("Please enter an id for the office you are looking for");
            return;
        }
        $params = [$_REQUEST['office_id']];
        $offices = $DB->querySelectParam("SELECT officeCode, city, phone, addressLine1, addressLine2, state, country, postalCode, territory FROM offices WHERE officeCode = ?", $params);
        if (count($offices) == 0) {
            header("HTTP/1.0 404 'office_id' does not match with any record");
            self::list("We are sorry, we did not found an office with that code");
            return;
        }
        $page_data = DEFAULT_PAGE_DATA;
        $page_data["content"] .= <<<HTML
                    <br><a href="index.php?op=500"><< Display all</a>
                HTML;
        $row_data = "";
        foreach ($offices as $office) {
            $row_data .= <<<HTML
                        <tr>
                            <th scope="row">{$office["officeCode"]}</th>
                            <td>{$office["city"]}</td>
                            <td>{$office["phone"]}</td>
                            <td>{$office["addressLine1"]}</td>
                            <td>{$office["addressLine2"]}</td>
                            <td>{$office["state"]}</td>
                            <td>{$office["country"]}</td>
                            <td>{$office["postalCode"]}</td>
                            <td>{$office["territory"]}</td>
                            <td>
                                <form class='office_list_form' action="index.php" method="POST">
                                    <input type="hidden" name="op" value="503">
                                    <input type="hidden" name="officeCode" value="{$office['officeCode']}">
                                    <button class="btn btn-outline-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                </form>
                                <form class='office_list_form' action="index.php" method="POST">
                                    <input type='hidden' name='op' value='504'>
                                    <input type='hidden' name='office_id' value="{$office['officeCode']}">
                                    <button class="btn btn-outline-danger" type="submit"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                </form>
                            </td>
                        </tr>
                    HTML;
        }

        $page_data["content"] .= <<<HTML
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">City</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Address 1</th>
                                <th scope="col">Address 2</th>
                                <th scope="col">State</th>
                                <th scope="col">Country</th>
                                <th scope="col">Postal Code</th>
                                <th scope="col">Territory</th>
                                <th scope="col">Modify</th>
                            </tr>
                        </thead>
                        <tbody>
                            {$row_data}
                        </tbody>
                    </table>
                HTML;
        webpage::render($page_data);
    }

    public static function display_office_form($user_info = null)
    {
        $city = "";
        $phone = "";
        $addressLine1 = "";
        $addressLine2 = "";
        $state = "";
        $country = "";
        $postalCode = "";
        $territory = "";

        $error_message = "";
        if ($user_info != null) {
            $error_message = "<div class=\"alert alert-danger\" role=\"alert\">This office is already registered, please choose a different office code</div>";
            $city = get_user_info_str($user_info, "city");
            $phone = get_user_info_str($user_info, "phone");
            $addressLine1 = get_user_info_str($user_info, "addressLine1");
            $addressLine2 = get_user_info_str($user_info, "addressLine2");
            $state = get_user_info_str($user_info, "state");
            $country = get_user_info_str($user_info, "country");
            $postalCode = get_user_info_str($user_info, "postalCode");
            $territory = get_user_info_str($user_info, "territory");
        } elseif (isset($_REQUEST['officeCode'])) {
            $officeCode = $_REQUEST['officeCode'];
            $DB = new db_pdo();
            $DB->connect();
            $record = $DB->querySelectParam("SELECT * FROM `offices` WHERE `officeCode` = ?", [$officeCode]);
            if (count($record) > 0) {
                $record = $record[0];
                $city = $record["city"];
                $phone = $record['phone'];
                $addressLine1 = $record['addressLine1'];
                $addressLine2 = $record['addressLine2'];
                $state = $record['state'];
                $country = $record['country'];
                $postalCode = $record['postalCode'];
                $territory = $record['territory'];
            } else {
                header("HTTP/1.0 404 officeCode not found in the database");
            };
        }


        $subsequent_op = "505";
        $office_form =
            "<form class='office_form' method='POST' action='index.php'>
                    <input type='hidden' name='op' value=" . $subsequent_op . ">";

        if (!isset($_REQUEST['officeCode'])) {
            $office_form .= "<input required type='text' name='officeCode' placeholder='Office code*' maxlength='" . offices::MAX_STRLEN_OFFICE_CODE . "'>
            <input type='hidden' name='action' value='INSERT'>";
        } else {
            $office_form .= "<input type='hidden' name='officeCode' value=" . $_REQUEST['officeCode'] . ">";
        }

        $office_form .= "<input required type='text' name='city' placeholder='City*' maxlength=" . offices::MAX_STRLEN_CITY . " " . append_html_value($city) . ">
                    <input required type='text' name='phone' placeholder='Phone*' maxlength=" . offices::MAX_STRLEN_PHONE . " " . append_html_value($phone) . ">
                    <input required  type='text' name='addressLine1' placeholder='Address Line 1*' maxlength=" . offices::MAX_STRLEN_ADDRESS_LINE_1 . " " . append_html_value($addressLine1) . ">
                    <input type='text' name='addressLine2' placeholder='Address Line 2' maxlength=" . offices::MAX_STRLEN_ADDRESS_LINE_2 . " " . append_html_value($addressLine2) . ">
                    <input type='text' name='state' placeholder='State' maxlength=" . offices::MAX_STRLEN_STATE . " " . append_html_value($state) . ">
                    <input required type='text' name='country' placeholder='Country*' maxlength=" . offices::MAX_STRLEN_COUNTRY . " " . append_html_value($country) . ">
                    <input required type='text' name='postalCode' placeholder='Postal Code*' maxlength=" . offices::MAX_STRLEN_POSTAL_CODE . " " . append_html_value($postalCode) . ">
                    <input required type='text' name='territory' placeholder='Territory*' maxlength=" . offices::MAX_STRLEN_TERRITORY . " " . append_html_value($territory) . ">

                    <button type='submit'>save</button>
                </form>";

        $office_form .= "<form class='office_form' action=\"index.php\"><input type=\"hidden\" name='op' value='500'><button type='submit'>cancel</button></form>";

        $page_data = DEFAULT_PAGE_DATA;
        $page_data['content'] = <<<HTML
        <br><a href="index.php?op=500"><< Display all</a>
        HTML;
        $page_data['content'] .= $error_message;
        $page_data['content'] .= $office_form;
        webpage::render($page_data);
    }

    public static function save()
    {
        $city = checkInput("city", offices::MAX_STRLEN_CITY);
        $phone = checkInput("phone", offices::MAX_STRLEN_PHONE);
        $addressLine1 = checkInput("addressLine1", offices::MAX_STRLEN_ADDRESS_LINE_1);
        $addressLine2 = checkInput("addressLine2", offices::MAX_STRLEN_ADDRESS_LINE_2);
        $state = checkInput("state", offices::MAX_STRLEN_STATE);
        $country = checkInput("country", offices::MAX_STRLEN_COUNTRY);
        $postalCode = checkInput("postalCode", offices::MAX_STRLEN_POSTAL_CODE);
        $territory = checkInput("territory", offices::MAX_STRLEN_TERRITORY);
        $isOfficeCode = isset($_REQUEST['officeCode']);
        if ($isOfficeCode) {
            $officeCode = $_REQUEST['officeCode'];
        }

        $DB = new db_pdo();
        $DB->connect();
        $sql_query = null;
        $params = null;

        $flag = isset($_REQUEST['action']) && $_REQUEST['action'] === 'INSERT';
        if ($flag && $isOfficeCode) {
            //First search is the PK_officeCode is already in the database
            $record = $DB->querySelectParam("SELECT * FROM `offices` WHERE `officeCode` = ?", [$officeCode]);
            if (count($record) > 0) {
                $DB->disconnect();
                unset($_REQUEST['officeCode']);
                $user_info = [
                    "city" => htmlspecialchars($city),
                    "phone" => htmlspecialchars($phone),
                    "addressLine1" => htmlspecialchars($addressLine1),
                    "addressLine2" => htmlspecialchars($addressLine2),
                    "state" => htmlspecialchars($state),
                    "country" => htmlspecialchars($country),
                    "postalCode" => htmlspecialchars($postalCode),
                    "territory" => htmlspecialchars($territory),
                ];
                self::display_office_form($user_info);
                return;
            }

            //Add office
            $sql_query = "INSERT INTO `offices` (`officeCode`, `city`, `phone`, `addressLine1`, `addressLine2`, `state`, `country`, `postalCode`, `territory`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
            $params = [$officeCode, $city, $phone, $addressLine1, $addressLine2, $state, $country, $postalCode, $territory];
        } elseif ($isOfficeCode) {
            //Update office by officeCode
            $sql_query = "UPDATE `offices` SET `city` = ?, `phone` = ?, `addressLine1` = ?, `addressLine2` = ?, `state` = ?, `country` = ?, `postalCode` = ?, `territory` = ? WHERE `offices`.`officeCode` = ?;";
            $params = [$city, $phone, $addressLine1, $addressLine2, $state, $country, $postalCode, $territory, $officeCode];
        } else {
            header("HTTP/1.0 400 officeCode must be set in offices::save()");
        }
        $successful_transaction = (($DB->queryParam($sql_query, $params))->rowCount()) > 0;
        $DB->disconnect();

        if ($successful_transaction) {
            header("location: index.php?op=502&office_id=$officeCode");
        } else {
            header("location: index.php?op=500");
        }
    }

    /**delete one record then call office::list()*/
    public static function delete()
    {
        $DB = new db_pdo();
        $DB->connect();
        if (!isset($_REQUEST['office_id'])) {
            header("HTTP/1.0 400 offices::delete() requires 'office_id' parameter and was not found in the request");
        }
        $params = [$_REQUEST['office_id']];
        $qry = "DELETE FROM `offices` WHERE `offices`.`officeCode` = ?";
        $is_office_deleted = ($DB->queryParam($qry, $params))->rowCount() == 1;
        if ($is_office_deleted) {
            header("LOCATION:index.php?op=500");
        } else {
            //record was not erase
            header("HTTP/1.0 304 offices::delete() was called but the query with id provided did not return any row");
            self::display("We could not find an office with that id");
        }
    }

    public static function listJSON()
    {
        $DB = new db_pdo();
        $DB->connect();

        $customers = $DB->table("offices");

        $arrayJSON = json_encode($customers, JSON_PRETTY_PRINT);
        header('Content-Type: application/json; charset=UTF-8');
        http_response_code(200);
        echo $arrayJSON;
    }
}
