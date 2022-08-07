<?php
#require_once "tools/tools.php";

class users
{
    const provinces = [
        ['id' => 0, 'code' => 'QC', 'name' => 'Québec'],
        ['id' => 1, 'code' => 'ON', 'name' => 'Ontario'],
        ['id' => 2, 'code' => 'NB', 'name' => 'New-Brunswick'],
        ['id' => 4, 'code' => 'NS', 'name' => 'Nova-Scotia'],
        ['id' => 5, 'code' => 'MN', 'name' => 'Manitoba'],
        ['id' => 6, 'code' => 'SK', 'name' => 'Saskatchewan'],
    ];

    public static function login($msg = null)
    {
        $page_data = DEFAULT_PAGE_DATA;
        $page_data['title'] = COMPANY_NAME . '- logon your account';
        $page_data['description'] = 'Connect to track to shop and track your order and more';
        $content = '<form action="index.php" method="POST">';
        $content .= '<input type="hidden" value="2" name="op">';
        $content .= "<h2>Please connect</h2>";
        if ($msg != null) {
            $content .= "<p class='errorMsg'>$msg</p>";
        }
        $content .= "<br><label>email: <input type='email' name='email' required maxlength='126' autofocus></label><br/>";
        $content .= "<label>password:<input type='password' name='pw' required maxlength='16' placeholder='max 16 characters'></label>";
        $content .= "<br><button type='submit'>Continue</button><button onclick='history.back();' type='button'>Back</button><br/>";
        $content .= "</form>";
        $page_data['content'] = $content;
        webpage::render($page_data);
    }

    public static function register($msg = null, $autofill_values = null)
    {

        $page_data = DEFAULT_PAGE_DATA;
        $page_data['title'] = COMPANY_NAME . '- Register your account';
        $page_data['description'] = 'Connect to track to shop and track your order and more';

        $content = '<form action="index.php" method="POST">';
        $content .= '<input type="hidden" value="4" name="op">';
        $content .= "<h2>Register</h2>";
        if ($msg != null) {
            $content .= "<p class='form-text errorMsg'>$msg</p>";
        }
        $content .= "<h4>General Information **</h4>";
        $content .= "<label class='form-label' for='fullname'><input placeholder='fullname' type='text' name='fullname' id='fullname' maxlength='50' " . fillValue($autofill_values, 'fullname', 50) . " required></label>";

        $content .= "<br><h4>Address (optional)</h4>";
        $content .= "<label class='form-label' for='address1'><input placeholder='Address line 1' type='text' name='address1' id='address1' " .  fillValue($autofill_values, 'address1', 255) . "maxlength='255'></label>";
        $content .= "<br><label class='form-label' for='address2'><input placeholder='Address line 2' type='text' name='address2' id='address2' " .  fillValue($autofill_values, 'address2', 255) . " maxlength='255'></label>";

        $content .= "<br><h4>City (optional)</h4>";
        $content .= "<label class='form-label' for='city'><input placeholder='city' type='text' name='city' id='city' " .  fillValue($autofill_values, 'city', 50) . " maxlength='50'></label>";

        $content .= "<br><h4>Province (optional)</h4>";
        $content .= "<select name='province'>";

        foreach (self::provinces as $province) {
            $content .= '<option value="' . $province['code'] . '">' . $province['name'] . '</option>';
        }
        $content .= "</select>";

        $content .= "<br><h4>Postal code (optional)</h4>";
        $content .= "<label class='form-label' for='postal_code'><input type='text' name='postal_code' " .  fillValue($autofill_values, 'postal_code', 7) . " id='postal_code' maxlength='7'></label>";

        $content .= "<br><h4>Language (required)**</h4>";
        $content .= "<input type='radio' id='fr' name = 'language' value = 'fr'>";
        $content .= "<label class='form-label' for='fr'>French</label><br>";
        $content .= "<input type='radio' id='en' name = 'language' value = 'en'>";
        $content .= "<label class='form-label' for='en'>English</label><br>";
        $content .= "<input type='radio' id='other' name = 'language' value = 'other'>";
        $content .= "<label class='form-label' for='other'>Other <input name='other_lang' id='other_lang' " .  fillValue($autofill_values, 'other_lang', 25) . " maxlength='25'></label><br><br>";

        $content .= "<h4>Connection Info (required) **</h4>";
        $content .= "<label class='form-label' for='email'><input placeholder='email' type='email' id='email' name='email' maxlength='126' " .  fillValue($autofill_values, 'email', 126) . "  required></label><br/>";
        $content .= "<label class='form-label' for='pw1'><input placeholder='password' type='password' id='pw1' name='pw1' maxlength='16' required></label><br/>";
        $content .= "<label class='form-label' for='pw2'><input placeholder='repeat your password' type='password' id='pw2' name='pw2' maxlength='16' required></label><br/><br/>";
        $content .= "<input type='checkbox' id='spam_ok' name='spam_ok' value='1'><label for='spam_ok'>I accept periodically receive information about new products</label><br>";
        $content .= "<br><button type='submit'>Continue</button><br/>";
        $content .= "</form>";
        $page_data['content'] = $content;
        webpage::render($page_data);
    }

    public static function registerVerify()
    {
        $email = checkInput("email", 126);
        $pw1 = checkInput("pw1", 8);
        $pw2 = checkInput("pw2", 8);
        $no_errors = true;


        $registered_users = [
            ['id' => 0, 'email' => 'abc@test.com', 'pw' => '12345678'],
            ['id' => 1, 'email' => 'def@test.com', 'pw' => '12345678'],
            ['id' => 2, 'email' => 'abc@gmail.com', 'pw' => '11111111'],
        ];
        foreach ($registered_users as $user) {
            //I. Email must be unique
            if ($user['email'] == $email) {
                $no_errors = false;
                self::register('this email already in use, please select a different email.', $_POST);
                break;
            }
        }

        if ($no_errors == true) {
            if ($pw1 != $pw2) {
                //II. Passwords should match
                $no_errors = false;

                //Unset passwords
                unset($_POST['pw1']);
                unset($_POST['pw2']);

                self::register("passwords doesn't match", $_POST);
            } else if (strlen($pw1) < 8 or strlen($pw2) < 8) {
                //III. Passwords must have at least 8 characters
                $no_errors = false;

                //Unset passwords
                unset($_POST['pw1']);
                unset($_POST['pw2']);

                self::register("password must have at least 8 characters", $_POST);
            } else if (!isset($_POST['language'])) {
                $no_errors = false;

                //Unset passwords
                unset($_POST['pw1']);
                unset($_POST['pw2']);

                self::register("Please select your prefered language", $_POST);
            } else if (!isset($_POST['fullname'])) {
                $no_errors = false;

                //Unset passwords
                unset($_POST['pw1']);
                unset($_POST['pw2']);

                self::register("Please enter your fullname", $_POST);
            } else if (!isset($_POST['email'])) {
                $no_errors = false;

                //Unset passwords
                unset($_POST['pw1']);
                unset($_POST['pw2']);

                self::register("Enter your fullname", $_POST);
            } else if (!isset($_POST['pw1']) or !isset($_POST['pw2'])) {
                $no_errors = false;
                self::register("Enter a password", $_POST);
            }
        }

        if ($no_errors) {
            $page_data = DEFAULT_PAGE_DATA;
            $page_data['content'] = "<h4>Your account was created!</h4>";
            webpage::render($page_data);
        }
    }

    public static function loginVerify()
    {
        $email = checkInput("email");
        $pw = checkInput("pw");

        $error = "";
        if ($pw == "" or $email == "") {
            $error = "missing email or password";

            #1. Redisplay login form.
            #header("location: index.php?op=1");
            self::login();
        }

        $users = [
            ['id' => 0, 'email' => 'Yannick@gmail.com', 'pw' => '12345678'],
            ['id' => 1, 'email' => 'Victor@test.com', 'pw' => '11111111'],
            ['id' => 2, 'email' => 'Christian@victoire.ca', 'pw' => '22222222'],
            ['id' => 3, 'email' => 'a@a', 'pw' => 'a'],
        ];

        //Check if there is a match:
        foreach ($users as $user) {
            if ($user['email'] == $email and $user['pw'] == $pw) {
                $page_data = DEFAULT_PAGE_DATA;
                $page_data['title'] = $email . " account";
                $page_data['description'] = "You are connected";
                $page_data["content"] = "<h2>You are connected.</h2>";
                webpage::render($page_data);
                die();
            }
        }
        self::login("Incorrect email or password");
    }
}
