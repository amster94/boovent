<?php
require_once '../connect/class.booventpdo.php';
require_once '../functions/class.booventMailer.php';
require_once '../functions/class.BooventMessage.php';
ini_set('display_errors',1);

//============================ INITIALIZE THE VARIABLES =========================================//
$Error ="";

try {
//============================== BOOVENT USER LOGIN ==============================================//
if(isset($_POST['login_email'])) {
	$email = $_POST['login_email'];
	$password = $_POST['password'];

	if(!empty($email) && !empty($password)) {

		if(isset($_SESSION['user_email']) == $email)
        {
                $Error = "Already Logged In !!!!";
        }
    	else {
    	$sql = "SELECT user_name,user_email,user_password FROM boovent_user WHERE user_email = :user_email AND user_password = :user_password AND email_activated='1' ";
    	$loginUser = new BooventPDO;
    	$loginUser->query($sql);
    	$loginUser->bindParam(':user_email', $email);
    	$loginUser->bindParam(':user_password', $password);
    	$loginUser->execute();

    	if($loginUser->rowCount() == 1) {
    		$row = $loginUser->single();
            if(!isset($_SESSION))
            {
                session_start();
            }
    		$_SESSION['user_name'] = $row['user_name'];
            $_SESSION['user_email'] = $row['user_email'];
            setcookie('user_email', $row['user_email'], time() + (60 * 60 * 24 * 30));  // expires in 30 days
            setcookie('user_name', $row['user_name'], time() + (60 * 60 * 24 * 30));  // expires in 30 days
            //-------------------- UPDATE USER LOGIN COUNT ----------------------------//
            $login_count = "UPDATE boovent_user SET login_count = login_count +1  WHERE user_email = :email AND user_password = :password ";
            $loginUser->query($login_count);
            $loginUser->bindParam(':email', $email);
            $loginUser->bindParam(':password', $password);
            $loginUser->execute();
    	}
        else {
            //---------------------- CHECK WHETHER THE ACCOUNT IS CONFIRMED OR NOT -------------------------//
            $check = "SELECT user_email FROM boovent_user WHERE user_email=:user_email AND email_activated='0'";
            $loginUser->query($check);
            $loginUser->bindParam(':user_email', $email);
            $loginUser->execute();
            if($loginUser->rowCount() == 1) {
                $Error=" User email already Exist! Please Confirm your Account.";
            }
            //----------------------- RETURN AS INVALID EMAIL OR PASSWORD ------------------------------//
            else {
                    $Error = "Invalid Login Email or Password";
            }
        }
    	}
	}
    //------------------------------ SPECIFY EMPTY FIELDS ----------------------------------------//
    else {
    if(empty($password)){
       $Error = 'Enter your Password!!!!!';
        }
    else {
       $Error = 'Enter your Email!!!!!';
        }
    }
    unset($loginUser); //Clear Object
   if(!empty($Error)) {
     echo $Error;   
    }
    exit();
}

//============================== BOOVENT USER SIGNUP ==========================//
if(isset($_POST['signup_email'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
	$email = $_POST['signup_email'];
	$password = $_POST['password'];
	if(!empty($name) && !empty($phone) && !empty($email) && !empty($password)) {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo("Email is not valid");
    	} 
    	else {
        //----------------------------- GET IP ADDRESS ----------------------------------//
        $ipaddress = getenv('REMOTE_ADDR');
        /*---------------------------- EMAIL CHECK -----------------------------------------------*/
        $mail_check = "SELECT user_email FROM boovent_user WHERE user_email=:user_email AND email_activated='1' ";
        $signUpUser = new BooventPDO;
        $signUpUser->query($mail_check);
        $signUpUser->bindParam(':user_email', $email);
        $signUpUser->execute();
        if($signUpUser->rowCount() == 1) {
            $Error=" User email already Exist! Please Confirm your Account.";
        }
        else {
         /*---------------------------- INSERT USER INFO -----------------------------------*/ 
         $signup_sql = "INSERT INTO boovent_user(user_name,user_email,user_password,user_mobile,ipaddress,join_date) VALUES(:user_name,:user_email,:user_password,:user_mobile,:ipaddress,now())";
         $signUpUser->query($signup_sql);
         $signUpUser->bindParam(':user_name', $name);
         $signUpUser->bindParam(':user_email', $email);
         $signUpUser->bindParam(':user_mobile', $phone);
         $signUpUser->bindParam(':user_password', $password);
         $signUpUser->bindParam(':ipaddress', $ipaddress);
         $signUpUser->execute();
         if($signUpUser->rowCount() == 1) {
            $MessageDetails=new booventMessage();
            $message = $MessageDetails->message_for_signup($email,$name);
            unset($MessageDetails);
            $to = $email;
            $subject = 'Account Activation - Boovent';
            $MailDetails=new booventMailer();
            $MailDetails->send_mail_for_signup($to,$subject,$message);
            unset($MailDetails);
         }
         else
         {   // failure to update User Info
            $Error = "Failure could not execute! Please try again.";
         }

        } // End of else part of Email Filter

    	} // End of else part of Email Check
	}
    //------------------------------ SPECIFY EMPTY FIELDS ----------------------------------------//
    else 
    {
     if(empty($name)){
       $Error = 'Enter your Name!!!!!';
        }
     else if(empty($email)){
       $Error = 'Enter your Email!!!!!';
        }
     else if(empty($phone)){
       $Error = 'Enter your Phone Number!!!!!';
        }
     else {
       $Error = 'Enter your Password!!!!!';
        }
    }
    unset($signUpUser); //Clear Object
    if(!empty($Error)) {
     echo $Error;   
    }
    exit();
}

}
catch (Exception $e) {
    $Error = $e->getMessage();
}

?>
