<?php
require_once '../functions/class.booventMailer.php';
require_once '../functions/class.BooventMessage.php';
require_once '../connect/class.booventpdo.php';
require_once '../functions/Base32.php';
use Base32\Base32;
/*---------------------- RANDOM GENERATOR --------------------------------*/
function generate_random_password($length) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$password = substr( str_shuffle( $chars ), 0, $length );
	return $password;
}

if(isset($_POST['forget_email'])) {
	$email = $_POST['forget_email'];
	//------------------------ CHECK EMAIL EXSIST ----------------------------------//
	$condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":user_email"); 
    $condition_arr2= array($email);
    $user_sql = "SELECT * FROM boovent_user WHERE user_email = :user_email AND email_activated='1' ";
    $UserDetails=new BooventPDO();
    $user_result=$UserDetails->selectQuery($user_sql,$condition_arr1,$condition_arr2);
    $max_size = sizeof($user_result);
    if($max_size > 0) {
        $user_name = $user_result[0]['user_name'];
        $encoded = Base32::encode($email);
        $link = BASE_URL."forgot.php?pass=".$encoded;
        //----------------- SEND MAIL TO USER --------------------------------//
            $MessageDetails=new booventMessage();
            $message = $MessageDetails->message_for_forget_password($email,$user_name,$link);
            unset($MessageDetails);
            $to = $email;
            $subject = 'Boovent Change Password';
            $MailDetails=new booventMailer();
            $MailDetails->send_mail_for_forget_password($to,$subject,$message);
            unset($MailDetails);
  //   	//---------------- GENERATE RANDOM PASS -------------------------------//
  //   	$password = generate_random_password(8);
  //   	//----------------- UPDATE THE PASSWORD ------------------------------//
		// $condition_arr1="";
  //   	$condition_arr2="";
  //   	$condition_arr1= array(":password",":email"); 
  //   	$condition_arr2= array($password,$email);
  //   	$UpdatePass=new BooventPDO();
  //   	$update_pass_sql="UPDATE boovent_user SET user_password = :password WHERE user_email=:email";
  //   	$update_result = $UpdatePass->updateQuery($update_pass_sql,$condition_arr1,$condition_arr2);
  //   	$user_name = $user_result[0]['user_name'];
  //       if($update_result > 0) {
  //       	//----------------- SEND MAIL TO USER --------------------------------//
  //       	$MessageDetails=new booventMessage();
  //   		$message = $MessageDetails->message_for_forget_password($email,$user_name,$password);
  //   		unset($MessageDetails);

		//     $to = $email;
		//     $subject = 'Boovent Password Change Successful';
		//     $MailDetails=new booventMailer();
		//     $MailDetails->send_mail_for_forget_password($to,$subject,$message);
  //   		unset($MailDetails);
  //       } else {
  //       	echo "Failed to Change Password.Please try Again.";
  //       }
  //       unset($UpdatePass);
    }
    else {
    	echo "Please Enter a valid Email.";
    }
    unset($UserDetails);
}

?>