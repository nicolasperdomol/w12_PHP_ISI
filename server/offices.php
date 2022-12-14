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
    public static function list($error_message = null, $success_message = null)
    {
        $DB = new db_pdo();
        $DB->connect();
        $offices = $DB->querySelect("SELECT officeCode, city, addressLine1, country FROM offices");
        $page_data = DEFAULT_PAGE_DATA;
        $page_data["content"] = '<br><h2>Our offices</h2>';
        $page_data['content'] .= ($error_message != null ? "<div class=\"alert alert-danger\" role=\"alert\"><b>$error_message</b></div>" : '');
        $page_data['content'] .= ($success_message != null ? "<div class=\"alert alert-success\" role=\"alert\"><b>$success_message</b></div>" : '');
        $page_data['content'] .= <<<HTML
                <form method="GET">
                    <input type="hidden" name="op" value="502">
                    <div class="w-25 p-3">
                HTML;
        $page_data['content'] .= "<input id='office_id_input_text' name='office_id' placeholder='office code' maxlength='" . self::MAX_STRLEN_OFFICE_CODE . "' type='text'/>";
        $page_data['content'] .= <<<HTML
            <button id='search_button' class='btn btn-sm btn-outline-primary' type="submit">search</button>
        </div>
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
                                        <button class="btn btn-outline-primary" id='add_icon' type="submit">+</button>
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
    public static function display($success_message=null, $officeCode = null)
    {
        $DB = new db_pdo();
        $DB->connect();
        $params = null;
        if (!isset($_REQUEST['office_id']))
            header("HTTP/1.0 400 offices::display() requires 'office_id' parameter and was not found in the request");
        elseif ($_REQUEST['office_id'] == "") {
            header("HTTP/1.0 400 office::display() does not accept an empty string as a parameter for 'office_id'");
            self::list("Please enter an id for the office you are looking for");
            return;
        }

        if($officeCode != null)
            $params = [$officeCode];
        else
            $params = [$_REQUEST['office_id']];


        $offices = $DB->querySelectParam("SELECT officeCode, city, phone, addressLine1, addressLine2, state, country, postalCode, territory FROM offices WHERE officeCode = ?", $params);
        $DB->disconnect();
        if (count($offices) == 0) {
            header("HTTP/1.0 404 'office_id' does not match with any record");
            self::list("We are sorry, we did not found an office with that code");
            return;
        }
        $page_data = DEFAULT_PAGE_DATA;
        $page_data["content"] = "";
        $page_data['content'] .= ($success_message != null ? "<div class=\"alert alert-success\" role=\"alert\"><b>$success_message</b></div>" : '');
        $page_data["content"] .= <<<HTML
                    <br><a id='display_all' href="index.php?op=500"><< Display all</a>
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

    /**
     * Create an office form and then display that to the user, used in offices::save(), this form is different depending if we intentend to create a new record or update a past record.
     */
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
            "<div id='office_form_container' class='container-fluid'><div class='d-flex justify-content-center'><form id='office_form' class='office_form' method='POST' action='index.php'>
                    <input type='hidden' name='op' value=" . $subsequent_op . ">";

        if (!isset($_REQUEST['officeCode'])) {
            $office_form .= "<div class=\"mb-3\"><label for=\"officeCode\" class=\"form-label\">Office code: <input class=\"form-control\" required type='text' id='officeCode' name='officeCode' placeholder='Office code*' maxlength='" . offices::MAX_STRLEN_OFFICE_CODE . "'></label></div>
            <input type='hidden' name='action' value='INSERT'>";
        } else {
            $office_form .= "<input type='hidden' name='officeCode' value=" . $_REQUEST['officeCode'] . ">";
        }

        $office_form .= "<div class=\"mb-3\"><label for=\"city\" class=\"form-label\">City: <input id='city' class=\"form-control\" required type='text' name='city' placeholder='City*' maxlength=" . offices::MAX_STRLEN_CITY . " " . append_html_value($city) . "></label></div>
                    <div class=\"mb-3\"><label for=\"phone\" class=\"form-label\">Phone:<input id='phone' class=\"form-control\" required type='text' pattern='[\+][0-9]{1,4}\s[\(][0-9]{1,4}[\)][0-9]{1,4}[\-][0-9]{1,5}' name='phone' placeholder='Phone*' title='Please follow the format: +X (XXX)XXX-XXXX' maxlength=" . offices::MAX_STRLEN_PHONE . " " . append_html_value($phone) . "></label><div class='form-text'>Format: +X (XXX)XXX-XXXX</div><div class='form-text'>Phone example: +1 (514)834-0059</div></div>
                    <div class=\"mb-3\"><label for=\"addressLine1\" class=\"form-label\">Address Line 1:<input id='addressLine1' class=\"form-control\" required  type='text' name='addressLine1' placeholder='Address Line 1*' maxlength=" . offices::MAX_STRLEN_ADDRESS_LINE_1 . " " . append_html_value($addressLine1) . "></label></div>
                    <div class=\"mb-3\"><label for=\"addressLine2\" class=\"form-label\">Address Line 2:<input id='addressLine2' class=\"form-control\" type='text' name='addressLine2' placeholder='Address Line 2' maxlength=" . offices::MAX_STRLEN_ADDRESS_LINE_2 . " " . append_html_value($addressLine2) . "></label></div>
                    <div class=\"mb-3\"><label for=\"state\" class=\"form-label\">State:<input id='state' class=\"form-control\" type='text' name='state' placeholder='State' maxlength=" . offices::MAX_STRLEN_STATE . " " . append_html_value($state) . "></label></div>
                    <div class=\"mb-3\"><label for=\"country\" class=\"form-label\">Country:<input id='country' class=\"form-control\" required type='text' name='country' placeholder='Country*' maxlength=" . offices::MAX_STRLEN_COUNTRY . " " . append_html_value($country) . "></label></div>
                    <div class=\"mb-3\"><label for=\"postalCode\" class=\"form-label\">Postal Code:<input id='postalCode' class=\"form-control\" required type='text' name='postalCode' placeholder='Postal Code*' maxlength=" . offices::MAX_STRLEN_POSTAL_CODE . " " . append_html_value($postalCode) . "></label></div>
                    <div class=\"mb-3\"><label for=\"territory\" class=\"form-label\">Territory:<input id='territory' class=\"form-control\" required type='text' name='territory' placeholder='Territory*' maxlength=" . offices::MAX_STRLEN_TERRITORY . " " . append_html_value($territory) . "></label></div>

                    <button class=\"btn btn-outline-secondary btn-sm\" formnovalidate type='submit' name='cancel' value='1'>cancel</button>
                    <button class=\"btn btn-outline-primary btn-sm\" type='submit'>save</button>
                </form></div></div>";

        $page_data = DEFAULT_PAGE_DATA;
        $page_data['content'] = <<<HTML
        <br><a id='display_all' href="index.php?op=500"><< Display all</a>
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
        if (isset($_REQUEST['cancel'])) {
            header('location: index.php?op=500');
            return;
        }
        if ($isOfficeCode) {
            $officeCode = $_REQUEST['officeCode'];
        }

        $DB = new db_pdo();
        $DB->connect();
        $sql_query = null;
        $params = null;

        $is_insert_request = isset($_REQUEST['action']) && $_REQUEST['action'] === 'INSERT';
        if ($is_insert_request && $isOfficeCode) {
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

        if ($successful_transaction && $is_insert_request) {
            self::display("Office #$officeCode created", $officeCode);
            #header("location: index.php?op=502&office_id=$officeCode");
        } elseif ($successful_transaction && !$is_insert_request){
            self::display("Office #$officeCode updated", $officeCode);
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
        $employees = offices::select_employees_by_officeCode($params[0]);

        if (count($employees) == 0) {
            $is_office_deleted = ($DB->queryParam($qry, $params))->rowCount() == 1;
            if ($is_office_deleted) {
                offices::list(null, "Office #$params[0] was successfully deleted");
            } else {
                //record was not erase
                header("HTTP/1.0 304 offices::delete() was called but the query with id provided did not return any row");
                self::display("We could not find an office with that id");
            }
        } else {
            $employee_list = "";
            foreach ($employees as $employee) {
                $employee_list .= "[#" . $employee['employeeNumber'] . " - " . $employee['lastName'] . " " . $employee['firstName'] . "]<br>";
            }
            offices::list("Office #$params[0] cannot be deleted, there are still employees working in this office, first you will need to move these employees to a different office: <br><br>" . $employee_list, null);
        }
    }

    public static function listJSON()
    {
        $DB = new db_pdo();
        $DB->connect();

        $offices = $DB->table("offices");

        $arrayJSON = json_encode($offices, JSON_PRETTY_PRINT);
        header('Content-Type: application/json; charset=UTF-8');
        http_response_code(200);
        echo $arrayJSON;
    }

    private static function select_employees_by_officeCode($officeCode)
    {
        $DB = new db_pdo();
        $DB->connect();
        $qry = "SELECT * FROM employees WHERE officeCode = ?";
        $employees = $DB->querySelectParam($qry, [$officeCode]);
        $DB->disconnect();
        return $employees;
    }
}
