<?php
require_once dirname( dirname(__FILE__) )."/config.php";
require "login_signup_Function.php";

//Add new account detail to database
$db = new login_signup_Function();
if (isset($_POST['email']) && isset($_POST['password']))
{ //check if all fields filled
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); //sanitize email address
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) //validate email address
    {
        if ($db->passwordStrength($_POST['password']))
        {
            $sql_checkExisitngAcc = "SELECT * from `user account` where email ='" . $email . "'"; //check existing account
            $result_checkExistingAcc = mysqli_query($mysqli, $sql_checkExisitngAcc);
            if (mysqli_num_rows($result_checkExistingAcc) != false) //search success && return object
            {
                $row = mysqli_fetch_assoc($result_checkExistingAcc);
                $activated = $row['activated'];
                if ($activated == false)
                { //if account exist && activated
                    $msg = "Account already exist, but not activated yet";
                    echo json_encode($msg);
                }
                else
                { //if account exist but not activated
                    $msg = "Account already exist";
                    echo json_encode($msg);
                }
            }
            else if ($db->signUp($email, $_POST['password']))
            { //proceed to sign up process
                $db->sendVerificationEmail($email);
                $msg = "Sign Up Success";
                echo json_encode($msg);
            }
            else
            {
                echo json_encode("Sign up Failed");
            } //If sign up failed
        }
        else
        { //if password strength too weak
            $msg = "Password should be at least 8 characters in length and should include at least 1 upper case letter, 1 number, and 1 special character.";
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
{
    $msg = "All fields are required";
    echo json_encode($msg);
}

?>
