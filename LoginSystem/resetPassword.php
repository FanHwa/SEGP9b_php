<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
require_once dirname( dirname(__FILE__) )."/config.php";
require "login_signup_Function.php";
?>


<h2>Reset Password for medPal Account <i> <?php print $_GET['email'] ?> </i> </h2>
<p> Password should be at least 8 characters in length and should include at least 1 upper case letter, 1 number, and 1 special character.<p>
<p><span class="error">* required field</span></p>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?email=" . $_GET['email']); ?>"> 
Register Email for Account : <input type="email" id="email" name="email" value="<?php print $_GET['email'] ?>" readonly>
  <br><br>
  New Password: <input type="password" id="newPassword" name="newPassword" value="<?php echo $newPassword; ?>">
  <span class="error">*<?php echo $newPasswordErr; ?></span>
  <br><br>
  Confirm Password: <input type="password" id="confirmPassword" name="confirmPassword" value="<?php echo $confirmPassword; ?>">
  <span class="error">*<?php echo $confirmPasswordErr; ?></span>
  <br><br>
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>

<?php
// define variables and set to empty values
$db = new login_signup_Function();
$newPasswordErr = $confirmPasswordErr = "";
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); //email is readonly attribute & validated beforehand, only need to sanitize
$newPassword = sanitize_input($_POST['newPassword']);
$confirmPassword = sanitize_input($_POST['confirmPassword']);
if ($_SERVER["REQUEST_METHOD"] == "POST")
{

    if (empty($newPassword))
    { //check if new Password field is provided
        $newPasswordErr = "Required";
    }
    else
    {
        if ($db->passwordStrength($newPassword))
        { //if New Password field not empty, check strength
            $newPasswordErr = "Password too weak";
        }
    }

    if (empty($confirmPassword))
    { //check if new Password field is provided
        $confirmPasswordErr = "Required";
    }

    if (!empty($confirmPassword) && !empty($newPassword))
    { //if both strings are given
        if (strcmp($confirmPassword, $newPassword) == 0)
        { //if passwords are not same
            if ($db->passwordStrength($newPassword))
            { //if password strength is strong enough
                /*
                $sql_checkExistingAcc =  "SELECT * from   `user account`   where email = '" . $email . "'"; //check existing account
                $result_checkExistingAcc = mysqli_query($db->dbConnect() , $sql_checkExistingAcc);
                if (mysqli_num_rows($result_checkExistingAcc) != false) //check existing account
                { 
                */
                //search success and return object
                //query database & make changes
                //hash password before updating to database
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                $sql_changePassword = "UPDATE `user account` SET password = '$hashedPasword' WHERE email = '$email'";
                $result_changePassword = mysqli_query($mysqli, $sql_changePassword);
                if ($result_changePassword != 0) //if query performed successfully
                {
                    echo "<h2>Password successfully update. Please sign in to <b>medPal</b> Application with new credentials.</h2>";
                }
                else echo "<h2>Failed.</h2>"; //if query failed
                
            }
            else
            { // strength too weak
                echo "<h2>Password should have at least 8 characters in length and should include at least 1 upper case letter, 1 number, and 1 special character.</h2>";
            }
        }
        else
        {
            echo "<h2>Both passwords must be SAME</h2>"; //if passwords are same, check strength
            
        }
    }
    else
    { //either field is absent
        echo "<h2>Must provide details for all fields</h2>";
    }
}

function sanitize_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<?php
echo "<h2> Input:</h2>";
echo $email;
echo "<br>";
echo $confirmPassword;
echo "<br>";
echo $newPassword;
?>

</body>
</html>
