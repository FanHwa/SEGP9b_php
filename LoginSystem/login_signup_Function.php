<?php
require_once dirname( dirname(__FILE__) )."/config.php";

//function for database
class login_signup_Function
{
    public $data;

    //setup database information
    public function __construct()
    {
        $this->data = null;
    }

    //prep data using escape string to MYSQL prevent Injection
    function prepareData($data)
    {
        return mysqli_real_escape_string($GLOBALS['mysqli'], stripslashes(htmlspecialchars($data)));
    }

    function logIn($email, $password)
    {
        $email = $this->prepareData($email);
        $password = $this->prepareData($password);
        $sql = "SELECT * from   `user account`   where email = '" . $email . "'";
        $result = mysqli_query($GLOBALS['mysqli'], $sql);
        if (mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_assoc($result);
            $dbemail = $row['email'];
            $dbpassword = $row['password'];
            $dbactivate = $row['activated'];
            if ($dbemail == $email && $dbactivate == false)
            {
                $msg = "Account not activated yet";
                //echo $msg; //no switch, no toast
                //return $msg; //toast appear double, no switch
                echo json_encode($msg);
                return "idk what is this #1";
            }
            else if ($dbemail == $email && password_verify($password, $dbpassword) && $dbactivate == true)
            {
                $msg = "Login Success";
                //echo $msg;
                //return $msg;
                echo json_encode($msg);
                return "idk what is this #2";
            }
            else $msg = "Email or Password wrong";
            //echo $msg;
            //return $msg;
            echo json_encode($msg);
            return "idk what is this #3";
        }
        else $msg = "Email or Password wrong";
        //echo $msg;
        //return $msg;
        echo json_encode($msg);
        return "idk what is this #4";
    }

    function signUp($email, $password)
    {
        $hashed_password = password_hash($this->prepareData($password) , PASSWORD_BCRYPT); //ENCRYPT PASSWORD WHEN SAVING FROM DATABASE
        $email = $this->prepareData($email);
        $verification_code = $this->prepareData(md5(rand(0, 1000))); //GENERATE RANDOM NO. BETWEEN 0-1000 & HASH
        $sql = "INSERT INTO `user account` (email,password,verification_code) VALUES ('$email','$hashed_password', '$verification_code')";
        $result = mysqli_query($GLOBALS['mysqli'], $sql);
        return $result;
    }

    // Validate password strength
    function passwordStrength($password)
    {
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[\w_]@', $password);
       

        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8)
        {

            return false;
        }
        else return true;
    }

    //Send verification email
    function sendVerificationEmail($email)
    {
        $email = $this->prepareData($email);
        $sql = "SELECT * from   `user account`   where email = '" . $email . "'";
        $result = mysqli_query($GLOBALS['mysqli'], $sql);
        if (mysqli_num_rows($result) > 0) //if successfully retrieve account detail from database
        
        {
            $row = mysqli_fetch_assoc($result);
            $verification_code = $row['verification_code'];

            //construct email
            //change line 107 if .php file changes in cPanel database
            $subject = 'medPal | Verify your Email';
            $message = '
            Thanks for signing up to medPal!
            
            Please click this link to activate your account:
            http://www.hpyzl1.jupiter.nottingham.edu.my/medpal-db/LoginSystem/verify.php?email=' . $email . '&verification_code=' . $verification_code . '    

            You may login to your account after activation.';

            $headers = "From: medPal <noreply@medpal.com>\r\n"; // Set from headers
            $headers .= "Reply-To: noreply@medPal.com\r\n";
            $headers .= "Return-Path: noreply@medPal.com\r\n";
            $headers .= "CC: noreply@medPal.com\r\n";
            $headers .= "BCC: noreply@medPal.com\r\n";
            mail($email, $subject, $message, $headers); // Send our email
            return true;
        }
        else return false;
    }

    //send email for password reset function
    function sendResetPasswordEmail($email)
    {
        $email = $this->prepareData($email);

        //construct email
        //change line 107 if .php file changes in cPanel database
        $subject = 'medPal | Reset Password';
        $message = '
            You have requested to change the password for your medPal account. 

            Please click this link to reset password:
            http://www.hpyzl1.jupiter.nottingham.edu.my/medpal-db/LoginSystem/resetPassword.php?email=' . $email;
        ' . "/n"   

            ';

        $headers = "From: medPal <noreply@medpal.com>\r\n"; // Set from headers
        $headers .= "Reply-To: noreply@medPal.com\r\n";
        $headers .= "Return-Path: noreply@medPal.com\r\n";
        $headers .= "CC: noreply@medPal.com\r\n";
        $headers .= "BCC: noreply@medPal.com\r\n";
        mail($email, $subject, $message, $headers); // Send email
        
    }
}

?>
