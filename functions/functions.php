<?php
error_reporting(-1);
ini_set('display_errors', 'On');
include "config.php";
include "email_config.php";

function getDB()
{

    $db = $GLOBALS["db"];
    return $db;

}

// HELPER  FUNCTIONS //
function clean($string)
{

    return htmlentities($string);
}

function redirect($location)
{

    return header("location: $location");
}

function set_message($message)
{

    if (!empty($message)) {

        $_SESSION['message'] = $message;
    } else {
        $message = "";
    }
}

// Helper function for database input
// this function checks if mysql_real_escape string is available - addslashes if it’s not available,
// this function is purely for form input - i.e. O'Reilly becomes O\'Reilley:
function mysql_prep($string)
{

    $php_is_recent = function_exists("mysql_real_escape_string");
    if ($php_is_recent == true) {
        $string = stripslashes($string);
    } else {
        $string = addslashes($string);
    }
    return $string;
}

// function called from php pages to display any messages that were set:
// by @set_message($message)
function display_message()
{

    $message = array_key_exists('message', $_SESSION) ? $_SESSION['message'] : "";

    if ($message) {
        echo $message;
        unset($_SESSION['message']);
    }
}

function display_validation_errors($e)
{
    $err_message = <<<EOT
 <div class="alert alert-info" role="alert"> $e </div>
EOT;
    return $err_message;
}

function token_generator()
{
    //Generate a random string.
    $token = openssl_random_pseudo_bytes(16);

    //Convert the binary data into hexadecimal representation.
    $token = $_SESSION['token'] = bin2hex($token);

    //Print it out for example purposes.
    return $token;
}

// check if email and username already exists  - if so let the user know to login
function email_exists($email)
{
    $db = getDB();
    //$db = $GLOBALS["db"];
    $accounts = $db->query('SELECT * FROM users where email = ?', $email);

    if ($accounts->numrows() == 1) {
        return true;
    } else {
        return false;
    }
    //  $db->close();
}

function username_exists($username)
{
    $db = getDB();
    $accounts = $db->query('SELECT * FROM users where username = ?', $username);

    if ($accounts->numrows() == 1) {
        return true;
    } else {
        return false;
    }
//    $db->close();
}

// -check if user activated their email:
function is_active($email)
{

    $db = getDB();
    $accounts = $db->query('SELECT active FROM users where email = ?', $email)->fetchAll();

    foreach ($accounts as $a) {
        if ($a['active'] == 1) {
            return true;
        } else {
            return false;
        }
    }
    //  $db->close();
}

// sends @activation code to new registered user for user to activate their email after signup:
function send_email($email, $subject, $msg)
{
    $mail = $GLOBALS["mail"];

    $mail->addAddress($email);
    $mail->Subject = $subject;
    $mail->Body = $msg;

    if (!$mail->send()) {
        return false;
    } else {
        return true;
    }
}

// VALIDATION FUNCTIONS //
// -helper function to check if user is logged in:
function logged_in()
{

    if (isset($_SESSION['email']) || isset($_COOKIE['email'])) {

        return true;
    } else {
        return false;
    }
}

function getusername($email)
{
    $db = getDB();

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $email = clean($_POST['email']);
    }

    $result = $db->query('SELECT username FROM users where email = ?', $email)->fetchAll();

    foreach ($result as $r) {
        return $r['username'];
    }

}

function set_reset_code($em, $vc)
{

    $db = getDB();
    $db->query('UPDATE users set reset_code = ? where email = ?', $vc, $em);

    // $db->close();
}

function get_validation_code($email)
{

    $db = getDB();

    $result = $db->query('SELECT validation_code FROM users where email = ?', $email)->fetchAll();
    //   echo $accounts->numRows();
    foreach ($result as $r) {
        return $r['validation_code'];
    }
}

function get_reset_code($email)
{
    $db = getDB();

    $result = $db->query('SELECT reset_code FROM users where email = ?', $email)->fetchAll();
    //   echo $accounts->numRows();
    foreach ($result as $r) {
        return $r['reset_code'];
    }
}

// register form field validation while user registers
function validate_user_registration()
{

    $errors = array();
    $min = 3;

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $first_name = clean($_POST['first_name']);
        $last_name = clean($_POST['last_name']);
        $username = clean($_POST['username']);
        $email = clean($_POST['email']);
        $password = clean($_POST['password']);
        $confirm_password = clean($_POST['confirm_password']);

        if (email_exists($email)) {
            $errors[] = "This email already exists, please Login. ";
        }

        if (username_exists($username)) {
            $errors[] = "This username is already taken, please try again with another username.";
        }

        if (strlen($first_name) < $min) {
            $errors[] = "Your First Name cannot be less than $min";
        }

        if (strlen($last_name) < $min) {
            $errors[] = "Your Last Name cannot be less than $min";
        }

        if (strlen($username) < $min) {
            $errors[] = "Your Username cannot be less than $min";
        }

        if ($password != $confirm_password) {
            $errors[] = "Your Password fields do not match";
        }

        $validation_code = md5($password + set_time_limit(600));

        // display all gathered errors on registration page:
        if (!empty($errors)) {
            foreach ($errors as $e) {
                echo display_validation_errors($e);
            }
        } else {

            if (register_user($first_name, $last_name, $username, $email, $password, $validation_code)) {
                set_message("<p class='bg-success text-center'>
                   Please check your email or spam folder to activate your account</p>");
            }
            // now send to new reqistered recipient

            $subject = "ACTIVATE Account";
            $msg = "Please click on the activation page link below to activate your account"
                . LOCAL_HOST_PATH . "/login.php?email=$email&code=$validation_code";

            if (send_email($email, $subject, $msg)) {
                set_message("<div class='alert alert-info' role='alert'>You are registered! Please check your email or spam folder to activate your account.</div>");
            } else {
                set_message("<div class='alert alert-info' role='alert'>email activation email send fail.</div>");
            }
        }
    }
}

function register_user($fn, $ln, $un, $em, $pw, $vc)
{
    $fname = mysql_prep($fn);
    $lname = mysql_prep($ln);
    $uname = mysql_prep($un);
    $email = mysql_prep($em);

    // encrypt the password
    $hash = password_hash($pw, PASSWORD_DEFAULT);

    $db = getDB();
    $db->query('INSERT INTO users (first_name,last_name,username,email,password,validation_code,active,reset_code,remember)
 VALUES (?,?,?,?,?,?,?,?,?)', $fname, $lname, $uname, $email, $hash, $vc, 0, 0, 0);

    $newID = $db->lastInsertID();
    $results = $db->query('SELECT * from users WHERE user_id = ?', $newID);

    if ($results->numrows() == 1) {
        return true;
    } else {
        return false;
    }
    //   $db->close();
}

function proc_user_activation($em, $vc)
{
    $db = getDB();
    $db->query('UPDATE users set active = 1 where email = ? and validation_code = ?', $em, $vc);

    $results = $db->query('SELECT active from users WHERE email = ? and validation_code = ?', $em, $vc)->fetchAll();

    foreach ($results as $result) {
        if ($result['active'] == 1) {
            return true;
        } else {
            return false;
        }
    }
    //   $db->close();
}

// function to validate user login
function validate_login()
{

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $errors = array();
        $email = clean($_POST['email']);
        $password = clean($_POST['password']);
        $rememberme = clean(isset($_POST['remember']));
        $email = clean($_POST['email']);

        if (isset($_COOKIE['rempw'])) {
            if (checkRememberMe($email) == 1) {
                $username = getusername($email);
                $_SESSION['username'] = $username;
                $_SESSION["loggedin"] = true;
                redirect("index.php");
            }
        } elseif (!email_exists($email) or !validate_user_login($email, $password)) {
            $errors[] = "Oops! It looks like your email and/or password are incorrect or not on file.";
        } elseif (!is_active($email)) {
            $validation_code = get_validation_code($email);
            check_activation($email, $validation_code);
        } else {
            $username = getusername($email);
            $_SESSION['username'] = $username;
            $_SESSION["loggedin"] = true;
            get_rememberme($rememberme, $email);
            redirect("index.php");
        }

        // display all gathered errors on registration page:
        if (!empty($errors)) {
            foreach ($errors as $e) {
                echo display_validation_errors($e);
            }
        }
    }
}

// set cookie for logged in user if remeber me was checked:
// this creates a passwordless login for 14 days
function get_rememberme($rememberme, $email)
{

    if (isset($_SESSION["loggedin"])) {
        if (isset($rememberme) && $rememberme == 1) {
            $errors[] = "remebered set!";
            if (!isset($_COOKIE['rempw'])) {
                $rempw = token_generator();
                // -Add remember token to database to compare on check when user logs in
                //   setcookie('email', $email, time() + 2 * 24 * 60 * 60);
                addRemember($rempw, $email);
                setcookie('email', $email, strtotime('+14 days'));
                setcookie('rempw', $rempw, strtotime('+14 days'));

            }
        }
    }
}

function validate_user_login($email, $password)
{
    // echo "$email ::: $password";

    $db = getDB();

    $loginresult = $db->query('SELECT email, password FROM users where email = ?', $email)->fetchAll();

    foreach ($loginresult as $result) {

        if ($result['email'] == $email && password_verify($password, $result['password'])) {

            return true;
        } else {
            return false;
        }
    }

    //   $db->close();
}

//  function activate_user() is called from the login.php page when the user submits (GET)method
//  the activation link from their email that was sent to them: and done from proc_user_activation:
function activate_user()
{

    if ($_SERVER['REQUEST_METHOD'] == "GET") {

        if (isset($_GET['email'])) {
            $email = clean($_GET['email']);
            $validation_code = clean($_GET['code']);

            if (proc_user_activation($email, $validation_code)) {
                echo display_validation_errors("Your email has been activated, thank you! You can now Login.");
            } else {
                echo display_validation_errors("There was a problem activating your email.");
            }
        }
    }
}

// helper function call from function validate_login()
// if user never activated their account send them a activation email back to them:
function check_activation($email, $validation_code)
{

    $subject = "ACTIVATE Account";
    //   $msg = "Please click on the activation page link below to activate your account:
    http: //localhost:8082/exercise-files/login.php?email=$email&code=$validation_code";

    $msg = "Please click on the activation page link below to activate your account:"
        . LOCAL_HOST_PATH . "/login.php?email=$email&code=$validation_code";

    // now send activation link (GET)method to the user recipient email indicated in $msg above

    if (send_email($email, $subject, $msg)) {
        set_message("<div class='alert alert-info' role='alert'>
     You did not activate your account.<br>
     Please check your email or spam folder to activate your account. <br>
     An activation email was sent to $email</div>");
    } else {
        set_message("<div class='alert alert-info' role='alert'>
                      email activation email send fail.</div>");
    }
}

//================= recover functions ===============================

// function recover_password() called from recover.php
// - checks if generated session token is valid to the specific user's session
// - checks if the user's email is on file,
// - generates a new reset_code
// - adds reset_code to user's cookie (10 min expiration)
// - sends an email to user with the reset_code
function recover_password()
{

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $email = clean($_POST['email']);

        if (isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
            if (email_exists($email)) {
                $reset_code = mt_rand();

                // set the reset code for user to expire in 10 minutes (600 secs) to reset their password:
                setcookie("ResetCode", $reset_code, time() + 1200);

                $message = " Here is your reset code which expires in 20 minutes: $reset_code  \n " . LOCAL_HOST_PATH . "/code.php?email=$email";

                $subject = "PASSWORD RESET";
                send_email($email, $subject, $message);
                set_message("<div class='alert alert-info' role='alert'>
                A reset code was sent to $email.</div>");
            } else {
                set_message("<div class='alert alert-info' role='alert'>This email is not on file, &nbsp;<a href='register.php'>Please register here.</a></div>");
            }
        }
    }
}

// function check_reset_code() is
// - called from recover.php when user submits
// the reset code from thier email to recover.php
// sent from function recover_password():
// - checks the code from user vs the user's reset_code,
// if still valid allows user to reset their password at reset.php
function check_reset_code()
{

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $email = clean($_POST['email']);
        $rc = clean($_POST['code']);
        //  $reset_code = get_reset_code($email);
        $un = getusername($email);

        if (isset($_COOKIE['ResetCode'])) {
            //  echo "ResetCode cookieTest:" . $_COOKIE["ResetCode"];
            if ($_COOKIE["ResetCode"] == $rc) {
                $_SESSION["approved"] = true;
                $_SESSION["email"] = $email;
                redirect("reset.php");
            } else {
                set_message("<div class='alert alert-info' role='alert'>Your reset code may have expired. Please try again.</div>");
            }
        }
    }

}

// function reset_password called from reset.php on submit
// this function updates the password after all validations pass:
function reset_password()
{
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $email = clean($_POST['email']);
        $password = clean($_POST['password']);
        $confirm_password = clean($_POST['confirm_password']);
        $hash = password_hash($password, PASSWORD_DEFAULT);

        if ($password == $confirm_password) {
            update_password($email, $hash);
        } else {
            set_message("<div class='alert alert-info' role='alert'>Your Password fields do not match</div>");

        }
    }
}

function update_password($email, $hash)
{

    $db = getDB();
    $db->query('UPDATE users set password = ? where email = ?', $hash, $email);
    // $db->close();

    set_message("<div class='alert alert-info' role='alert'>Your Password has been updated, &nbsp;<a href='login.php'>Please login here.</a></div>");
}

function checkRememberMe($email)
{
    // echo ("im at the checkRemberMe $email");

    $db = getDB();
    $results = $db->query('SELECT remember from users WHERE email = ?', $email)->fetchAll();
    foreach ($results as $result) {

        if ($result['remember'] == $_COOKIE['rempw']) {
            return true;
        } else {
            return false;
        }
    }

    //   $db->close();

}

function addRemember($rempw, $email)
{

    $db = $GLOBALS["db"];
    $db->query('UPDATE users set remember = ? where email = ?', $rempw, $email);

}