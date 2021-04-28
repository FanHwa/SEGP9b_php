<?php
require_once dirname( dirname(__FILE__) )."/config.php";
require "login_signup_Function.php";

//Add new account detail to database
$db = new login_signup_Function();
if (isset($_POST['email']))
{ //check if email is provided
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); //sanitize email address
    if (filter_var($email, FILTER_VALIDATE_EMAIL))
    { //validate email address
        //check if account exist in database
        $sql_checkExistingAcc = "SELECT * from   `user account`   where email = '" . $email . "'"; //check existing account
        $result_checkExistingAcc = mysqli_query($mysqli, $sql_checkExistingAcc);
        if (mysqli_num_rows($result_checkExistingAcc) != false)
        { //search success and return object
            $row = mysqli_fetch_assoc($result_checkExistingAcc);
            $activated = $row['activated'];
            if ($activated)
            {
                $db->sendResetPasswordEmail($email);
                $msg = "Reset password email sent";
                //echo $msg;
                //return $msg;
                echo json_encode($msg);
            }
            else
            {
                $msg = "Account not verified yet. Please request for verification email at Sign Up page";
                echo json_encode($msg);
            }
        }
        else
        {
            $msg = "No account registered under this email";
            echo json_encode($msg);
        }
    }
    else
    { //if email validation fail
        $msg = "Email is invalid";
        echo json_encode($msg);
    }
}
else
{ //if email not provided
    $msg = "Please enter email registered for account";
    echo json_encode($msg);
}

?>
