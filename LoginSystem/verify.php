<?php
require_once dirname( dirname(__FILE__) )."/config.php";
require "login_signup_Function.php";

//Add new account detail to database
$db = new login_signup_Function();
if (isset($_GET['email']) && isset($_GET['verification_code']))
{ //check if all fields filled
    $email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL); //sanitize email address
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) //validate email address
    
    {
        $sql_checkExistingAcc = "SELECT * from   `user account`   where email = '" . $email . "'"; //check existing account
        $result_checkExistingAcc = mysqli_query($mysqli, $sql_checkExistingAcc);
        if (mysqli_num_rows($result_checkExistingAcc) != false)
        { //search success and return object
            $dbverification_code = $row['verification_code'];
            if ($verificaition_code == $dbverification_code)
            {
                $sql_setActivated = "UPDATE `user account` SET activated = true WHERE email = '$email'";
                $result_setActivated = mysqli_query($mysqli, $sql_setActivated);
                if ($result_setActivated)
                {
                    echo "Account for " . $email . " has been activated." . nl2br("\n\n") . "Please sign in to <b>medPal</b> Application.";
                }
                else echo "Account activation for " . $email . " failed." . nl2br("\n\n") . "Please request for activation link from <b>Sign Up</b>page on <b>medPal</b> apllication again.";
            }
        }
        else echo "Account not created, cannot be activated. Please sign up again. ";
    }
    else echo "Email is invalid."; //if email validation fail
    
}
else echo "Email/Verification code not received" . $_GET['email'] . $_GET['verification_code']; //if exist unfilled fields



?>
