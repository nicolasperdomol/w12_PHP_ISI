<?php
require_once "db_pdo.php";
class offices
{
    /**
     * Operation #500: Present a table list based on the table 'Offices' from the classicmodels database,
     * $_REQUEST["office_id"] may be used to present a single row of the table.
     */
    public static function list()
    {
        $DB = new db_pdo();
        $DB->connect();

        $offices = null;
        if (!isset($_REQUEST['office_id']) or $_REQUEST['office_id'] == "") {
            $offices = $DB->querySelect("SELECT officeCode, city, addressLine1, country FROM offices");
        } else {
            $params = [$_REQUEST['office_id']];
            $offices = $DB->querySelectParam("SELECT officeCode, city, phone, addressLine1, addressLine2, state, country, postalCode, territory FROM offices WHERE officeCode = ?", $params);
        }
        $page_data = DEFAULT_PAGE_DATA;
        $page_data["content"] = <<<HTML
        <h2>List of offices</h2>
        <form method="GET">
            <input type="hidden" name="op" value="500">
            <input style="width:100px" name="office_id" placeholder="office id" type="number" min="0" max="99"/>
            <button type="submit">search</button>
        </form>
        HTML;
        switch (count($offices)) {
            case 1:
                //display selected office
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
                            </tr>
                        </thead>
                        <tbody>
                            {$row_data}
                        </tbody>
                    </table>
                HTML;
                break;
            case 0:
                //No offices were found
                $page_data["content"] .= "<div>We are sorry, we didn't find any office with the id #" . $_REQUEST["office_id"] . "</div>";
            default:
                //display offices table
                $row_data = "";
                foreach ($offices as $office) {
                    $row_data .= <<<HTML
                        <tr>
                            <th scope="row"><a href="index.php?op=500&office_id={$office['officeCode']}">{$office["officeCode"]}</a></th>
                            <td>{$office["city"]}</td>
                            <td>{$office["addressLine1"]}</td>
                            <td>{$office["country"]}</td>
                            <td>
                                <a href="index.php?op=503"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <a href="index.php?op=503"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
                break;
        }
        webpage::render($page_data);
    }
}
