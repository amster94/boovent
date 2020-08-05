<?php

/*
* BooventPDO - PHP PDO mail creation .
* PHP Version 7
* @package BooventMailer

/**
* BooventPDO -  PHP PDO mail creation .
* @package BooventDatabase
* @author Amey Sarode (Amster) <ameysarode00@gmail.com>
* @author Amarjeet Sharma (jimjag) <amarjeet.sharma@gmail.com>
*/
//=========================== INCLUDES ALL DEFINES VARIABLES ===================================//
require_once dirname(__DIR__).'/class.phpmailer.php';
require_once dirname(__DIR__).'/class.smtp.php';
require_once dirname(__DIR__)."/functions/class.BooventPDF.php";
class BooventMailer
{
/**
* The MIME Content-type of the admin email.
* @type string
*/
protected $support_mail = SUPPORT_MAIL;
/**
* The MIME Content-type of the admin password.
* @type string
*/
protected $support_pass = SUPPORT_PASS;
/**
* The MIME Content-type of the admin password.
* @type string
*/
/**
* The MIME Content-type of the admin email.
* @type string
*/
protected $google_mail = GOOGLE_MAIL;
/**
* The MIME Content-type of the admin password.
* @type string
*/
protected $google_pass = GOOGLE_PASS;
/**
* The MIME Content-type of the admin password.
* @type string
*/
protected $my_order = "DEFAULT";

public function send_mail_for_signup($to,$subject,$message)
{
			    $username = $this->support_mail;
			    $password = $this->support_pass;
			    $mode = "Confirmation";
			    return $this->smtpmailer($to,$subject,$message,$username,$password,$mode);
}

public function send_mail_for_forget_password($to,$subject,$message)
{
			    $username = $this->support_mail;
			    $password = $this->support_pass;
			    $mode = "Forget-Password";
			    return $this->smtpmailer($to,$subject,$message,$username,$password,$mode);
}

public function send_mail_for_event_created($to,$subject,$message)
{
			    $username = $this->support_mail;
			    $password = $this->support_pass;
			    $mode = "Event-Created";
			    return $this->smtpmailer($to,$subject,$message,$username,$password,$mode);
}

public function send_mail_for_confirmation($to,$subject,$message,$order_id)
{
			    $username = $this->support_mail;
			    $password = $this->support_pass;
			    $this->my_order = $order_id;
			    $mode = "Payment-Confirmation";
			    $Booventpdf = new booventPDF();
			    $Booventpdf->send_invoice_pdf($order_id);
			    $Booventpdf->send_ticket_pdf($order_id);
			    unset($Booventpdf);
			    return $this->smtpmailer($to,$subject,$message,$username,$password,$mode);
}

protected function smtpmailer($to,$subject,$message,$Username,$Password,$mode){
			    	$mail = new PHPMailer;
			    	$mail->isSMTP();
			    	$mail->Host = 'smtp.boovent.com';
			    	$mail->SMTPAuth = true;
			    	$mail->Username = $Username;
			    	$mail->Password = $Password;
			    	$mail->SMTPSecure = 'tls';
			    	$mail->Port = 587;
			    	$mail->From = $Username;
			    	$mail->FromName = 'Boovent';
			    	$mail->isHTML(true);
			    	$mail->addAddress($to);
			    	$mail->Subject = $subject;
			    	$mail->Body = ( stripslashes( $message ) );
			    	$mail->AltBody = 'Please Use a Html email Client To view This Message!!';
			    	if($mode == "Payment-Confirmation") {
		    		$mail->AddAttachment('../docs/tickets/'.$this->my_order.'_ticket.pdf', $name = $this->my_order.'_ticket.pdf',  $encoding = 'base64', $type = 'application/pdf');
		    		$mail->AddAttachment('../docs/invoice/'.$this->my_order.'_invoice.pdf', $name = $this->my_order.'_invoice.pdf',  $encoding = 'base64', $type = 'application/pdf');
			    	}
			    	$mail->SMTPOptions = array(
			        	'ssl' => array(
			            'verify_peer' => false,
			            'verify_peer_name' => false,
			            'allow_self_signed' => true
			        	)
			    	);
			    	if(!$mail->send()) {
			    		if($mode == "Confirmation") {
			    	    $error_msg = "Confirmation-Fail";
			    		} else if($mode == "Forget-Password") {
			    		$error_msg = "Could not send new password.!";
			    		} else if($mode == "Event-Created") {
			    			$error_msg = "Cannot Create New Event!";
			    		} else {
			    		$error_msg = "Event Not Registration Successful.!";
			    		}
			    	} else {
			    		if($mode == "Confirmation") {
			    		$error_msg = "Confirmation-Success";
			    		} else if($mode == "Forget-Password") {
			    		$error_msg = "New Password Link has been Sent to your Email Id.!";
			    		} else if($mode == "Event-Created") {
			    		$error_msg = " Please check your email.";
			    		} else {
			    		$error_msg = "Event Registration Successful.!";
			    		}
			    	}
			    	echo $error_msg;
}

protected function smtpmailer_gmail($to,$subject,$message,$Username,$Password,$mode) {
			    	$mail = new PHPMailer;
			    	$mail->isSMTP();
			    	$mail->Host = 'smtp.gmail.com';
			    	$mail->SMTPAuth = true;
			    	$mail->Username = $Username;
			    	$mail->Password = $Password;
			    	$mail->SMTPSecure = 'tls';
			    	$mail->Port = 587;
			    	$mail->From = $Username;
			    	$mail->FromName = 'Boovent';
			    	$mail->isHTML(true);
			    	$mail->addAddress($to);
			    	$mail->Subject = $subject;
			    	$mail->Body = ( stripslashes( $message ) );
			    	$mail->AltBody = 'Please Use a Html email Client To view This Message!!';
			    	$mail->SMTPOptions = array(
			        	'ssl' => array(
			            'verify_peer' => false,
			            'verify_peer_name' => false,
			            'allow_self_signed' => true
			        	)
			    	);
			    	if(!$mail->send()) {
			    	    $error_msg = "Confirmation email could not be sent.!";
			    	    // echo 'Mailer Error: ' . $mail->ErrorInfo;
			    	} else {
			    		if($mode == "Event-Created") {
			    			$error_msg = "Event Creation email has been sent successfully.!";
			    		}
			    		else if($mode == "Payment-Confirmation") {
			    			$error_msg = "Payment Confirmation email has been sent successfully.!";
			    		}	
			    	}
}

}