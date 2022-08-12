<?php
#require_once "tools/tools.php";

class users
{
    const PROVINCES = [
        ['id' => 0, 'code' => 'QC', 'name' => 'Québec'],
        ['id' => 1, 'code' => 'ON', 'name' => 'Ontario'],
        ['id' => 2, 'code' => 'NB', 'name' => 'New-Brunswick'],
        ['id' => 4, 'code' => 'NS', 'name' => 'Nova-Scotia'],
        ['id' => 5, 'code' => 'MN', 'name' => 'Manitoba'],
        ['id' => 6, 'code' => 'SK', 'name' => 'Saskatchewan'],
    ];

    const LANGUAGES = [
        "French" => "fr",
        "English" => "en",
    ];

    /**
     * displays new user login form
     */
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

    /**
     * displays new user registration form
     */
    public static function register($msg = null, $autofill_values = null)
    {
        #var_dump($autofill_values);
        $page_data = DEFAULT_PAGE_DATA;
        $page_data['title'] = COMPANY_NAME . '- Register your account';
        $page_data['description'] = 'Connect to track to shop and track your order and more';

        $content = '<form enctype="multipart/form-data" action="index.php" method="POST">';
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

        foreach (self::PROVINCES as $province) {

            $content .= '<option ';
            if (isset($autofill_values['province']) && $autofill_values['province'] == $province['code']) {
                $content .= 'selected ';
            }
            $content .=  'value="' . $province['code'] . '">' . $province['name'] . '</option>';
        }
        $content .= "</select>";

        $content .= "<br><h4>Postal code (optional)</h4>";
        $content .= "<label class='form-label' for='postal_code'><input type='text' name='postal_code' " .  fillValue($autofill_values, 'postal_code', 7) . " id='postal_code' maxlength='7'></label>";

        $content .= "<br><h4>Language (required)**</h4>";
        foreach (self::LANGUAGES as $language => $value) {
            $content .= "<input type='radio'";

            //Select previous selected option.
            if (isset($autofill_values["language"]) && $autofill_values["language"] == $value) {
                $content .= " checked ";
            }

            $content .= "id='$value' name = 'language' value = '$value'>";
            $content .= "<label class='form-label' for='$value'>$language</label><br>";
        }
        $content .= "<input type='radio'";
        //Select previous selected option.
        if (isset($autofill_values["language"]) && $autofill_values["language"] == "other") {
            $content .= " checked ";
        }
        $content .= "id='other' name = 'language' value = 'other'>";
        $content .= "<label class='form-label' for='other'>Other <input name='other_lang' id='other_lang' " .  fillValue($autofill_values, 'other_lang', 25) . " maxlength='25'></label><br><br>";

        $content .= "<h4>Connection Info (required) **</h4>";
        $content .= "<label class='form-label' for='email'><input placeholder='email' type='email' id='email' name='email' maxlength='126' " .  fillValue($autofill_values, 'email', 126) . "  required></label><br/>";
        $content .= "<label class='form-label' for='pw'><input placeholder='password' type='password' id='pw' name='pw' maxlength='16' required></label><br/>";
        $content .= "<label class='form-label' for='pw2'><input placeholder='repeat your password' type='password' id='pw2' name='pw2' maxlength='16' required></label><br/><br/>";
        $content .= "<input type='checkbox' id='spam_ok' name='spam_ok' value='1' checked><label for='spam_ok'>I accept periodically receive information about new products</label><br>";
        $content .= "<br><label>Select a picture <input type='file' name='product_image'></label>";
        $content .= "<br><button type='submit'>Continue</button><br/>";
        $content .= "</form>";
        $page_data['content'] = $content;
        webpage::render($page_data);
    }

    /**
     * Verify new user registration form
     */
    public static function registerVerify()
    {
        // if (!isset($_FILES['product_image']) or $_FILES['product_image'] == 'none') {
        //     echo 'No image selected';
        // } elseif ($_FILES['product_image']['error'] !== UPLOAD_ERR_OK) {
        //     echo 'error in file upload';
        // } elseif ($_FILES['product_image']['size'] > 1000000) {
        //     //set 1MB as the update limit
        //     echo 'error file to big';
        // } elseif (!getimagesize($_FILES['product_image']['tmp_name'])) {
        //     echo 'error document is not an image';
        // } else {
        //     $pathParts = pathinfo($_FILES['product_image']['name']);
        //     $ext = $pathParts['extension'];
        //     if ($ext !== 'png' and $ext !== 'jpg' and $ext !== 'gif' and $ext !== 'jpeg') {
        //         echo 'error image format not supported';
        //     } else {
        //         $target_file = 'user_images' . DIRECTORY_SEPARATOR . basename($_FILES['product_image']['name']);
        //         if (file_exists($target_file)) {
        //             echo 'file already exists';
        //         } else {
        //             //Migrating the file from temp to folder
        //             if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file)) {
        //                 echo 'file uploaded';
        //                 echo '<img alt="new picture" width="20%" src="' . $target_file . '"/>';
        //             } else {
        //                 echo 'file transfer from temp to folder failed';
        //             }
        //         }
        //     }
        // }

        $error_message = "";
        Picture_Uploaded_Save_File('product_image', 'user_images\\');
        if ($error_message == 'OK') {
            $error_message = '';
        }

        $fullname = checkInput("fullname", 50);
        $address1 = checkInput("address1", 50);
        $email = checkInput("email", 126);
        $pw = checkInput("pw", 8);
        $pw2 = checkInput("pw2", 8);
        $spam_ok = false;

        $no_errors = true;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_message .= "Email format is wrong<br>";
        }
        if (isset($_REQUEST['spam_ok'])) {
            $spam_ok = true;
        }

        $registered_users = [
            ['id' => 0, 'email' => 'abc@test.com', 'pw' => '12345678'],
            ['id' => 1, 'email' => 'def@test.com', 'pw' => '12345678'],
            ['id' => 2, 'email' => 'abc@gmail.com', 'pw' => '11111111'],
        ];
        foreach ($registered_users as $user) {
            //I. Email must be unique
            if ($user['email'] == $email) {
                $no_errors = false;
                $error_message .= "This email already in use, please select a different email<br>";
                self::register($error_message, $_POST);
                break;
            }
        }

        if ($no_errors == true) {
            if ($pw != $pw2) {
                //II. Passwords should match
                $no_errors = false;

                //Unset passwords
                unset($_POST['pw']);
                unset($_POST['pw2']);

                self::register("passwords doesn't match", $_POST);
            } else if (strlen($pw) < 8 or strlen($pw2) < 8) {
                //III. Passwords must have at least 8 characters
                $no_errors = false;

                //Unset passwords
                unset($_POST['pw']);
                unset($_POST['pw2']);

                self::register("password must have at least 8 characters", $_POST);
            } else if (!isset($_POST['language'])) {
                $no_errors = false;

                //Unset passwords
                unset($_POST['pw']);
                unset($_POST['pw2']);

                self::register("Please select your prefered language", $_POST);
            } else if (!isset($_POST['fullname'])) {
                $no_errors = false;

                //Unset passwords
                unset($_POST['pw']);
                unset($_POST['pw2']);

                self::register("Please enter your fullname", $_POST);
            } else if (!isset($_POST['email'])) {
                $no_errors = false;

                //Unset passwords
                unset($_POST['pw']);
                unset($_POST['pw2']);

                self::register("Enter your fullname", $_POST);
            } else if (!isset($_POST['pw']) or !isset($_POST['pw2'])) {
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

    public static function logout()
    {
        unset($_SESSION['email']);
        unset($_SESSION['loginCount']);
        //erase the whole session, but in some cases we do not want to
        //$_SESSION = [];
        //redirect to home page
        header('location: index.php');
    }

    /**
     * Verify user login form
     */
    public static function loginVerify()
    {
        if (!isset($_SESSION['loginCount'])) {
            $_SESSION['loginCount'] = 0;
        }

        if ($_SESSION['loginCount'] >= MAX_LOGIN_ATTEMPT) {
            //the user should wait 24 minutes
            $page_data = DEFAULT_PAGE_DATA;
            $page_data['title'] = COMPANY_NAME . ' - try again later';
            $page_data['content'] = '<h2>Try again later</h2>';
            webpage::render($page_data);
            die();
        }

        $email = checkInput("email");
        $pw = checkInput("pw");

        $error = "";
        if ($pw == "" or $email == "") {
            $error = "missing email or password";

            #1. Redisplay login form.
            #header("location: index.php?op=1");
            $_SESSION['loginCount']++;
            self::login($error . " - attempt(" . $_SESSION['loginCount'] . "/" . MAX_LOGIN_ATTEMPT . ")");
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
                $_SESSION['email'] = $user['email'];
                $page_data = DEFAULT_PAGE_DATA;
                $page_data['title'] = $email . " account";
                $page_data['description'] = "You are connected";
                $page_data["content"] = "<h2>You are connected.</h2>";
                webpage::render($page_data);
                die();
            }
        }

        $_SESSION['loginCount']++;
        self::login("Incorrect email or password" . " - attempt(" . $_SESSION['loginCount'] . "/" . MAX_LOGIN_ATTEMPT . ")");
    }
}
