<?php
//require_once 'connect/class.booventpdo.php';
/*
* BooventPDO - PHP PDO mail Message creation .
* PHP Version 7
* @package BooventMailer

/**
* BooventPDO -  PHP PDO mail Message creation .
* @package BooventDatabase
* @author Amey Sarode (Amster) <ameysarode00@gmail.com>
* @author Amarjeet Sharma (jimjag) <amarjeet.sharma@gmail.com>
*/

class BooventMessage
{

public function message_for_signup($email,$name)
{
	$message = '<div class="container-fluid" style="padding: 3% 2%; border: 1px solid #ddd;">
	<div class="container main_body">
		<img class="img-responsive" src="https://www.boovent.com/images/logo.png">
		<div class="hr-line" style="height: 1px; width: 100%; background-color: rgba(193, 7, 8, 0.31); margin-top: 1%; margin-bottom: 1%;"></div>
		<h4 class="success"><img class="img-responsive" src="https://www.boovent.com/images/tick.png"><span class=""> Thank you for registering on our site.</span></h4>
		<h4>Dear <b>'.$name.'</b></h4>
		
		<h4>Please verify your account to login. please Click to Activate your account:</h4>
		<div class="view_print_btn" style="margin-top: 3%;">
			<a class="btn btn-primary" href="https://www.boovent.com/account-activation.php?id='.$email.'&proof='.$name.'" style="text-decoration: none; display: inline-block; margin-bottom: 0; font-size: 14px; font-weight: normal; line-height: 1.42857143; text-align: center; white-space: nowrap; vertical-align: middle; -ms-touch-action: manipulation; touch-action: manipulation; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; border-radius: 0px; transition: 1s; color: #fff; background-image: none; background-color: #c10708; padding: 6px 12px; border: 1px none transparent;">Activate Boovent Account Now</a>
		</div>
		<div class="follow_box">
			<h4>Follow Us:</h4>
			<ul style="display: flex;position: relative;">
				<li style="display: inline-block"><a href="https://www.facebook.com/Boovent/"><img class="img-responsive" src="https://www.boovent.com/images/facebook.png"></a></li>
				<li style="display: inline-block;margin-left: 10px;"> <a href="https://www.instagram.com/Booventinsta/"><img class="img-responsive" src="https://www.boovent.com/images/instagram.png"></a></li>
				<li style="display: inline-block;margin-left: 10px;"> <a href="https://plus.google.com/u/0/113626090209911771822"><img class="img-responsive" src="https://www.boovent.com/images/google.png"></a></li>
				<li style="display: inline-block;margin-left: 10px;"> <a href="https://twitter.com/booovent"><img class="img-responsive" src="https://www.boovent.com/images/twitter.png"></a></li>
			</ul>
		</div>
		<div class="feedback">
			<p>Is there anything you want to share with us?</p>
			<p class="sm-font">Feedback, comments, suggestions or compliments - do write to <a href="mailto:support@boovent.com">support@boovent.com</a></p>
		</div>
		<div class="copyright">
			<p><span class="sm-font"><sub>Powered by </sub></span><a href="https://www.boovent.com">boovent.com</a></p>
		</div>
	</div>
</div>';
return $message;
}

public function message_for_forget_password($email,$username,$link)
{
	$message = '<div class="container-fluid" style="padding: 3% 2%; border: 1px solid #ddd;">
	<div class="container main_body">
		<img class="img-responsive" src="https://www.boovent.com/images/logo.png">
		<div class="hr-line" style="height: 1px; width: 100%; background-color: rgba(193, 7, 8, 0.31); margin-top: 1%; margin-bottom: 1%;"></div>
		<h4 class="success"><img class="img-responsive" src="https://www.boovent.com/images/tick.png"><span class=""> Change your Boovent Password.</span></h4>
		<h4>Dear <b>'.$username.'</b></h4>
		
		<h4>Please follow this link to change your Boovent Password <span style="color:#0000FF;">'.$link.'</span>
		</h4>
		<h4>You can change your password for security purpose after login in My Profile tab!</h4>
		<div class="follow_box">
			<h4>Follow Us:</h4>
			<ul style="display: flex;position: relative;">
				<li style="display: inline-block"><a href="https://www.facebook.com/Boovent/"><img class="img-responsive" src="https://www.boovent.com/images/facebook.png"></a></li>
				<li style="display: inline-block;margin-left: 10px;"> <a href="https://www.instagram.com/Booventinsta/"><img class="img-responsive" src="https://www.boovent.com/images/instagram.png"></a></li>
				<li style="display: inline-block;margin-left: 10px;"> <a href="https://plus.google.com/u/0/113626090209911771822"><img class="img-responsive" src="https://www.boovent.com/images/google.png"></a></li>
				<li style="display: inline-block;margin-left: 10px;"> <a href="https://twitter.com/booovent"><img class="img-responsive" src="https://www.boovent.com/images/twitter.png"></a></li>
			</ul>
		</div>
		<div class="feedback">
			<p>Is there anything you want to share with us?</p>
			<p class="sm-font">Feedback, comments, suggestions or compliments - do write to <a href="mailto:support@boovent.com">support@boovent.com</a></p>
		</div>
		<div class="copyright">
			<p><span class="sm-font"><sub>Powered by </sub></span><a href="https://www.boovent.com">boovent.com</a></p>
		</div>
	</div>
    </div>';
	return $message;
}

public function message_for_event_created($user_email,$event_name)
{
	$message = '<div class="container-fluid" style="padding: 3% 2%; border: 1px solid #ddd;">
	<div class="container main_body">
		<img class="img-responsive" src="https://www.boovent.com/images/logo.png">
		<div class="hr-line" style="height: 1px; width: 100%; background-color: rgba(193, 7, 8, 0.31); margin-top: 1%; margin-bottom: 1%;"></div>
		<h4 class="success"><img class="img-responsive" src="https://www.boovent.com/images/tick.png"><span class=""> New Event created in Boovent Successfully.</span></h4>
		<h4>Hi <b> Jeet Vithlani,</b></h4>
		
		<h4>New Event created in Boovent just Now by <span style="color:#0000FF;">'.$user_email.'
		</span>
		</h4>
		<h4>Please verify Event Details.Event name :<span style="color:#0000FF;">'.$event_name.'
		</span>
		</h4>
		<div class="feedback">
			<p>Is there anything you want to share with out Team?</p>
			<p class="sm-font">Feedback, comments, suggestions or compliments - do write to <a href="mailto:ameysarode00@gmail.com">Team Boovent</a></p>
		</div>
		<div class="copyright">
			<p><span class="sm-font"><sub>Powered by </sub></span><a href="https://www.boovent.com">boovent.com</a></p>
		</div>
	</div>
    </div>';
	return $message;
}

public function message_for_confirmation($username,$user_email,$user_contact,$quantity,$total,$orderid)
{
	$current_date=date('l jS \of F Y ');
	//-------------------------- GET TICKET FORMAT -----------------------------------//
	$condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":order"); 
    $condition_arr2= array($orderid);
    $confirm_sql = "SELECT * FROM boovent_ticket_format WHERE order_id = :order";
    $TicketDetails=new BooventPDO();
    $ticket_result=$TicketDetails->selectQuery($confirm_sql,$condition_arr1,$condition_arr2);
    $max_size = sizeof($ticket_result);
    if($max_size > 0) {
    	$event_name = $ticket_result[0]['event_name'];
    	$event_location = $ticket_result[0]['event_ticket_address'];
    	$event_time = $ticket_result[0]['event_ticket_date'];
    }
    else {
    	//Fail
    }
    unset($TicketDetails);
			    $message ='
<div class="container-fluid" style="padding: 3% 2%; border: 1px solid #ddd;">
	<div class="container main_body" style="background-color: #fafafa; padding: 2%;">
		<img class="img-responsive" src="https://www.boovent.com/images/logo.png">
		<div class="hr-line" style="height: 1px; width: 100%; background-color: rgba(193, 7, 8, 0.31); margin-top: 1%; margin-bottom: 1%;"></div>
		<h4 class="success" style="display: -moz-flex; color: #555;"><img class="img-responsive" src="https://www.boovent.com/images/tick.png"><span class=""> Thank you. Your transaction is done!</span></h4>
		<h4 style="color: #555;">Dear <b>'.$username.'</b></h4>
		<p style="color: #555;">Your registration was successful for event <b>#'.$event_name.'</b>. We hope you had a smooth experience at boovent.com. Below are your transaction details.</p>
		<p style="color: #555;"><b>Event :</b> <a href="#" style="text-decoration: none;">'.$event_name.'</a></p>
		<p style="color: #555;"><b>Location :</b> <span> '.$event_location.'</span></p>
		<p style="color: #555;"><b>Timing :</b> <span>'.$event_time.'</span></p>';
		foreach($ticket_result as $row) {

		$message .='<p style="color: #555;"><b>Ticket Name :</b> <span>'.$row['event_ticket_name'].'
		</span></p>
		<p style="color: #555;"><b>Ticket Numbers :</b> <span>'.$row['event_ticket_numbers'].'</span></p>';
		}
		$message .='<div class="ticket_detail" style="background-color: rgba(193, 7, 8, 0.66); padding: 2%; border: 1px solid #ddd;">
			<table style="border-collapse: collapse; width: 100%;">
			<tr style="padding: 18px;">
				<td style="padding: 10px;">
					<h3 style="color: #fff;">'.$username.'</h3>
					<p class="sm-line-height" style="color: #fff; font-size: 0.8em;">Email : <a href="" style="text-decoration: none; color: #fff;">'.$user_email.'</a></p>
					<p class="sm-line-height" style="color: #fff; font-size: 0.8em;">Contact : '.$user_contact.'</p>
				</td>
				<td style="padding: 10px;">
					<h4 style="color: #fff;">Ticket QTY: '.$quantity.'</h4>
				</td>
				<td style="padding: 10px;">
					<h3 style="color: #fff;">Rs. '.$total.'</h3>
				</td>
			</tr>
			
			</table>
			
		</div>
		
		<table class="date_orderid" style="border-collapse: collapse; width: 100%; text-align: left; margin-top: -1px;">
			<thead class="dark-strip" style="background-color: #c10708; color: #fff;">
				<tr style="padding: 18px;">
					<th style="padding: 10px;">Booking Date : '.$current_date.'</th>
					<th class="float-right" style="float: right; padding: 10px;">Order Id : '.$orderid.'</th>
				</tr>
			</thead>
			<tbody>
				<tr style="padding: 18px;">
					<td style="padding: 10px;"></td>
					<td style="padding: 10px;"></td>
				</tr>
			</tbody>
		</table>
		<div class="follow_box" style="margin-top: 3%;">
			<h4 style="color: #555;">Follow Us:</h4>
			<ul style="display: flex; position: relative;">
				<li style="display: inline-block"><a href="https://www.facebook.com/Boovent/"><img class="img-responsive" src="https://www.boovent.com/images/facebook.png"></a></li>
				<li style="display: inline-block;margin-left: 10px;"> <a href="https://www.instagram.com/Booventinsta/"><img class="img-responsive" src="https://www.boovent.com/images/instagram.png"></a></li>
				<li style="display: inline-block;margin-left: 10px;"> <a href="https://plus.google.com/u/0/113626090209911771822"><img class="img-responsive" src="https://www.boovent.com/images/google.png"></a></li>
				<li style="display: inline-block;margin-left: 10px;"> <a href="https://twitter.com/booovent"><img class="img-responsive" src="https://www.boovent.com/images/twitter.png"></a></li>
			</ul>
		</div>
		<div class="feedback" style="margin-top: 3%;">
			<p style="color: #555;">Is there anything you want to share with us?</p>
			<p class="sm-font" style="color: #555; font-size: 0.8em;">Feedback, comments, suggestions or compliments - do write to <a href="mailto:support@boovent.com" style="text-decoration: none;">support@boovent.com</a></p>
		</div>
		<div class="copyright">
			<p style="color: #555;"><span class="sm-font" style="font-size: 0.8em;"><sub>Powered by </sub></span><a href="https://www.boovent.com">boovent.com</a></div>
	</div>
</div>';
			    return $message;
}


}

?>