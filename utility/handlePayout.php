<?php
require_once '../connect/class.booventpdo.php';
require_once '../functions/class.BooventMessage.php';
require_once '../functions/class.booventMailer.php';
date_default_timezone_set('Asia/Kolkata');
ini_set('display_errors',1);
if(!isset($_SESSION))
{
    session_start();
}

function generateOrderid() {
//-------------------------- GENERATE ORDER ID ---------------------------------------//
    $order_sql = "SELECT * FROM boovent_purchase ORDER BY boovent_purchase_id DESC LIMIT 1";
    $OrderDetails=new BooventPDO();
    $order_result=$OrderDetails->selectQuery($order_sql);
    $order_size = sizeof($order_result); 
    if($order_size > 0) {
        $order_id = $order_result[0]['order_id'];
        //------------- EXPLODE FOR BOOK NUMBER -------------------//
        $order_id =explode('-', $order_id);
        $order_id = end($order_id);
        $order_id = (int)$order_id;
        $order_id = $order_id +1;
        $ordering_id = "BVNT-OID-".$order_id;
    } else {
        $ordering_id = "BVNT-OID-100000";
    }
    unset($OrderDetails);
    return $ordering_id;
}

function generateBookingid() {
//------------------------- GENERATE THE BOOKING ID ----------------------------------//
    $book_sql = "SELECT * FROM boovent_purchase ORDER BY boovent_purchase_id DESC LIMIT 1";
    $BookDetails=new BooventPDO();
    $book_result=$BookDetails->selectQuery($book_sql);
    $book_size = sizeof($book_result); 
    if($book_size > 0) {
        $book_id = $book_result[0]['booking_id'];
        //------------- EXPLODE FOR BOOK NUMBER -------------------//
        $book_id =explode('-', $book_id);
        $book_id = end($book_id);
        $book_id = (int)$book_id;
        $book_id = $book_id +1;
        $booking_id = "BVNT-BID-".$book_id;
    } else {
        $booking_id = "BVNT-BID-100000";
    }
    unset($BookDetails);
    return $booking_id;
}

//=================================== FREE TICKET TYPE ==================================//
if(isset($_POST['free_type'])) {
    if(isset($_SESSION['order_id'])) {
        unset($_SESSION['order_id']);
    }
	$ticket = $_POST['ticket1'];
	$quantity = $_POST['qty1'];
	$ticketid = $_POST['id1'];
	$price = $_POST['price1'];
    $eventid = $_POST['eventid'];
    $user_contact = $_POST['contact'];
	$total = 0;
	$tnumber ="";
	$ordering_id = generateOrderid();
    $booking_id = generateBookingid();
    //------------------------- GET EVENT DETAILS -----------------------------------------//
    $condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":eventid"); 
    $condition_arr2= array($eventid);
    $user_sql = "SELECT *,DATE_FORMAT(event_start_date, '%W %M %e %r') as formatted_start_date,DATE_FORMAT(event_end_date, '%W %M %e %r') as formatted_end_date FROM boovent_events WHERE event_id = :eventid AND make_event_live='Live'";
    $EventDetails=new BooventPDO();
    $event_result=$EventDetails->selectQuery($user_sql,$condition_arr1,$condition_arr2); 
    $event_name = $event_result[0]['event_title'];
    $event_location = $event_result[0]['event_location'];
    $event_address = $event_result[0]['event_address'];
    $event_zipcode = $event_result[0]['event_zipcode'];
    $event_city = $event_result[0]['event_city'];
    $invoice_event = $event_address." ".$event_location." ".$event_zipcode." ".$event_city;
    $event_time = $event_result[0]['formatted_start_date']."-".$event_result[0]['formatted_end_date'];
    unset($EventDetails);
	//------------------------- GET USER DETAILS -----------------------------------------//
	$condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":user_email"); 
    $condition_arr2= array($_SESSION['user_email']);
    $user_sql = "SELECT * FROM boovent_user WHERE user_email = :user_email AND email_activated='1' ";
    $UserDetails=new BooventPDO();
    $user_result=$UserDetails->selectQuery($user_sql,$condition_arr1,$condition_arr2); 
    //$user_contact = $user_result[0]['user_mobile'];
    $user_address = $user_result[0]['user_address'];
    if($user_address=="") {
        $user_address = "Not Specified";
    }
    unset($UserDetails);
    //------------------------- GET TICKET DETAILS -----------------------------------------//
    $condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":eventid",":ticketid"); 
    $condition_arr2= array($_SESSION['event']['eventid'],$ticketid);
    $ticket_sql = "SELECT * FROM boovent_ticket_manager WHERE event_id=:eventid AND ticket_id = :ticketid";
    $TicketDetails=new BooventPDO();
    $ticket_result=$TicketDetails->selectQuery($ticket_sql,$condition_arr1,$condition_arr2);
    $ticket_size = sizeof($ticket_result); 
    if($ticket_size > 0) {
    	//----------------------- FETCH THE TICKET NUMBERS -------------------------//
    	$ticket_booked = $ticket_result[0]['total_tickets_booked'];
    	$ticket_last = $ticket_booked + $quantity;
    	$ticket_booked = $ticket_booked +1;
    	$ticket_booked = (string)$ticket_booked;
    	$ticket_last = (string)$ticket_last;
    	//------------------------- GENERATE THE TICKET NUMBER ---------------------------------//
    	if($quantity > 1) {
    		$tnumber = "BVNT-".$ticket_booked." to BVNT-".$ticket_last;
    	} else {
    		$tnumber = "BVNT-".$ticket_last;
    	}
    } else {
    	$error = "Cannot find Ticket Information for the Event.";
    }
    unset($TicketDetails);
	//------------------------- SET THE PURCHASE TABLE PARAMETERS --------------------------//
	$condition_arr1="";
    $condition_arr2="";
    $purchase_date=date("Y-m-d h:i:s");
    $condition_arr1= array(":order",":booking_id",":purchase_date", ":email", ":contact", ":eventid", ":ticketid",":type",":bearing",":ticketnumber", ":quantity",":cost", ":total",":paid");
    //print_r($condition_arr1);
    $condition_arr2= array($ordering_id,$booking_id, $purchase_date, $_SESSION['user_email'],$user_contact,
    	$_SESSION['event']['eventid'],$ticketid,'Free','Not Applicable',$tnumber,$quantity,$total,$total,$total);
    //print_r($condition_arr2);

    $insert_purchase_sql="INSERT INTO boovent_purchase(order_id,booking_id,date_of_purchase,user_email,purchase_contact,event_id,ticket_id,purchased_ticket_type,purchased_ticket_bearing,purchased_ticket_numbers,purchase_quantity,boovent_cost,total_price,customer_price_purchased) VALUES(:order,:booking_id,:purchase_date,:email,:contact,:eventid,:ticketid,:type,:bearing,:ticketnumber,:quantity,:cost,:total,:paid)";
    $PurchaseDetails=new BooventPDO();
    $result=$PurchaseDetails->insertQuery($insert_purchase_sql,$condition_arr1,$condition_arr2);
    if($result > 0) {
    	$error = "Event Registeration Successfully Completed.";
    	 //------------------------- UPDATE THE TICKETS QUANTITY -------------------------------//
    	$condition_arr1="";
    	$condition_arr2="";
    	$condition_arr1= array(":eventid",":ticketid",":qty"); 
    	$condition_arr2= array($_SESSION['event']['eventid'],$ticketid,$quantity);
    	$UpdateTicket=new BooventPDO();
    	$update_ticket_sql="UPDATE boovent_ticket_manager SET total_tickets_booked = total_tickets_booked + :qty,total_tickets_remaining = total_tickets_remaining - :qty WHERE event_id = :eventid AND ticket_id = :ticketid";
    	$update_result = $UpdateTicket->updateQuery($update_ticket_sql,$condition_arr1,$condition_arr2);
        if($update_result > 0) {
        	//echo "Update Successfully";
        } else {
        	echo "Failed to Update the Count";
        }
        unset($UpdateTicket);
    //------------------------- INSERT INTO INVOICE TABLE ----------------------------------//
    $condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":order",":booking_id",":payment_id", ":email", ":name",
    	":address",":purchase_date", ":event",":location",":quantity",":paid");
    $condition_arr2= array($ordering_id,$booking_id, 'FREE', $_SESSION['user_email'],$_SESSION['user_name'],$user_address,$purchase_date,$event_name,$invoice_event,$quantity,$total);

    $insert_invoice_sql="INSERT INTO boovent_invoice(order_id,booking_id,payment_id,invoice_email,invoice_name,invoice_address,invoice_create_date,event_name,event_location,quantity_puchased,total_price_paid) VALUES(:order,:booking_id,:payment_id,:email,:name,:address,:purchase_date,:event,:location,:quantity,:paid)";
    $InvoiceDetails=new BooventPDO();
    $result=$InvoiceDetails->insertQuery($insert_invoice_sql,$condition_arr1,$condition_arr2);
    if($result > 0) {
    	// echo "Invoice Pass";
    }
    else {
    	// echo "Invoice Fail";
    }
    unset($InvoiceDetails);
    //------------------------- INSERT INTO TICKET FORMAT TABLE ----------------------------------//
    $condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":order",":purchase_date", ":name", ":email",":mobile",":ticketid",
        ":type",":event_name",":event_ticket_name", ":event_address",":event_date",":quantity",":tnumber",":total");
    $condition_arr2= array($ordering_id,$purchase_date,$_SESSION['user_name'],$_SESSION['user_email'],$user_contact,$ticketid,'Free',$event_name,$ticket,$invoice_event,$event_time,$quantity,$tnumber,0);

    $ticket_format_sql="INSERT INTO boovent_ticket_format(order_id,event_ticket_send_date,user_name,user_email,user_mobile,ticket_id,event_ticket_type,event_name,event_ticket_name,event_ticket_address,event_ticket_date,event_ticket_quantity,event_ticket_numbers,event_ticket_total) VALUES(:order,:purchase_date,:name,:email,:mobile,:ticketid,:type,:event_name,:event_ticket_name,:event_address,:event_date,:quantity,:tnumber,:total)";
    $FormatDetails=new BooventPDO();
    $result=$FormatDetails->insertQuery($ticket_format_sql,$condition_arr1,$condition_arr2);
    if($result > 0) {
        //echo "Format Pass";
    }
    else {
        //echo "Format Fail";
    }
    unset($FormatDetails);
    //--------------------------- SEND MAIL FOR CONFIRMATION ------------------------------//
    $MessageDetails=new booventMessage();
    $message = $MessageDetails->message_for_confirmation($_SESSION['user_name'],
        $_SESSION['user_email'],$user_contact,$quantity,0,$ordering_id);
    unset($MessageDetails);

    $to = $_SESSION['user_email'];
    $subject = 'Event Confirmation Boovent';
    $MailDetails=new booventMailer();
    $MailDetails->send_mail_for_confirmation($to,$subject,$message,$ordering_id);
    unset($MailDetails);
    } else {
    	$error = "Could Not Register to the Event.Please Try Again.";
    }
    unset($PurchaseDetails);
   	$_SESSION['order_id'] = $ordering_id;
}

//=================================== PAID TICKET TYPE ==================================//
if(isset($_POST['paid_type'])) {

	$payment_bearing = $_POST['payment_bearing'];
	$payment_id = $_POST['payment_id'];
	$eventid = $_POST['eventid'];
    $user_contact = $_POST['contact'];
	$max_ticket_type =9;$a = 0;$b = 1;
	for($a=0;$a < $max_ticket_type;$a++) {
	    if(!empty($_POST['qty'.$b]) && $_POST['qty'.$b] != 0) {
	        $ticket[$a]['ticket'] = $_POST['ticket'.$b];
	        $ticket[$a]['ticketid'] = $_POST['id'.$b];
	        $ticket[$a]['quantity'] = $_POST['qty'.$b];
	        $ticket[$a]['price'] = $_POST['price'.$b];
	        $ticket[$a]['total'] = $_POST['price'.$b]*$_POST['qty'.$b];
	        $ticket[$a]['cost'] = $ticket[$a]['total']/20;
	        if($payment_bearing == "i_will") {
	        	$ticket[$a]['paid'] = $ticket[$a]['total'];
	        }
	        else if($payment_bearing == "customer_will") {
	        	$ticket[$a]['paid'] = $ticket[$a]['total']+$ticket[$a]['cost'];
	        }
	        else {
	        	$ticket[$a]['paid'] = $ticket[$a]['total']+$ticket[$a]['total']*3.5/100;
	        }
	        if($b < $max_ticket_type) { $b++; }
	        else { break; } 
	    }
	    else {
	     $a= $a-1;
	     if($b < $max_ticket_type) { $b++; }
	     else { break; }
	    }
	}
	//------------------------- GET EVENT DETAILS -----------------------------------------//
	$condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":eventid"); 
    $condition_arr2= array($eventid);
    $user_sql = "SELECT *,DATE_FORMAT(event_start_date, '%W %M %e %r') as formatted_start_date,DATE_FORMAT(event_end_date, '%W %M %e %r') as formatted_end_date FROM boovent_events WHERE event_id = :eventid AND make_event_live='Live'";
    $EventDetails=new BooventPDO();
    $event_result=$EventDetails->selectQuery($user_sql,$condition_arr1,$condition_arr2); 
    $event_name = $event_result[0]['event_title'];
    $event_location = $event_result[0]['event_location'];
    $event_address = $event_result[0]['event_address'];
    $event_zipcode = $event_result[0]['event_zipcode'];
    $event_city = $event_result[0]['event_city'];
    $invoice_event = $event_address." ".$event_location." ".$event_zipcode." ".$event_city;
    $event_time = $event_result[0]['formatted_start_date']."-".$event_result[0]['formatted_end_date'];
    unset($EventDetails);
	//------------------------- GET USER DETAILS -----------------------------------------//
	$condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":user_email"); 
    $condition_arr2= array($_SESSION['user_email']);
    $user_sql = "SELECT * FROM boovent_user WHERE user_email = :user_email AND email_activated='1' ";
    $UserDetails=new BooventPDO();
    $user_result=$UserDetails->selectQuery($user_sql,$condition_arr1,$condition_arr2); 
    //$user_contact = $user_result[0]['user_mobile'];
    $user_address = $user_result[0]['user_address'];
    if($user_address =="") {
        $user_address = "Not Specified";
    }
    unset($UserDetails);
    $ordering_id = generateOrderid();
    //============================== TICKET LOOP ======================================//
    foreach($ticket as $row) {
    $booking_id = generateBookingid();
    //------------------------- GET TICKET DETAILS -----------------------------------------//
    $condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":eventid",":ticketid"); 
    $condition_arr2= array($_SESSION['event']['eventid'],$row['ticketid']);
    $ticket_sql = "SELECT * FROM boovent_ticket_manager WHERE event_id=:eventid AND ticket_id = :ticketid";
    $TicketDetails=new BooventPDO();
    $ticket_result=$TicketDetails->selectQuery($ticket_sql,$condition_arr1,$condition_arr2);
    $ticket_size = sizeof($ticket_result); 
    if($ticket_size > 0) {
    	///----------------------- FETCH THE TICKET NUMBERS -------------------------//
    	$ticket_booked = $ticket_result[0]['total_tickets_booked'];
    	$ticket_last = $ticket_booked + $row['quantity'];
    	$ticket_booked = $ticket_booked +1;
    	$ticket_booked = (string)$ticket_booked;
    	$ticket_last = (string)$ticket_last;
    	//------------------------- GENERATE THE TICKET NUMBER ---------------------------------//
    	if($row['quantity'] > 1) {
    		$tnumber = "BVNT-".$ticket_booked." to BVNT-".$ticket_last;
    	} else {
    		$tnumber = "BVNT-".$ticket_last;
    	}
    	
    } else {
    	$error = "Cannot find Ticket Information for the Event.";
    }
    unset($TicketDetails);
	//------------------------- SET THE PURCHASE TABLE PARAMETERS --------------------------//
	$condition_arr1="";
    $condition_arr2="";
    $purchase_date=date("Y-m-d h:i:s");
    $condition_arr1= array(":order",":booking_id",":purchase_date", ":email", ":contact", ":eventid", ":ticketid",":type",":bearing",":ticketnumber", ":quantity",":cost", ":total",":paid");
    //print_r($condition_arr1);
    $condition_arr2= array($ordering_id,$booking_id, $purchase_date, $_SESSION['user_email'],$user_contact,
    	$_SESSION['event']['eventid'],$row['ticketid'],'Paid',$payment_bearing,$tnumber,$row['quantity'],$row['cost'],$row['total'],$row['paid']);
    //print_r($condition_arr2);

    $insert_purchase_sql="INSERT INTO boovent_purchase(order_id,booking_id,date_of_purchase,user_email,purchase_contact,event_id,ticket_id,purchased_ticket_type,purchased_ticket_bearing,purchased_ticket_numbers,purchase_quantity,boovent_cost,total_price,customer_price_purchased) VALUES(:order,:booking_id,:purchase_date,:email,:contact,:eventid,:ticketid,:type,:bearing,:ticketnumber,:quantity,:cost,:total,:paid)";
    $PurchaseDetails=new BooventPDO();
    $result=$PurchaseDetails->insertQuery($insert_purchase_sql,$condition_arr1,$condition_arr2);
    if($result > 0) {
    	$error = "Purchase Successfully Completed.";
    	//------------------------- UPDATE THE TICKETS QUANTITY -------------------------------//
    	$condition_arr1="";
    	$condition_arr2="";
    	$condition_arr1= array(":eventid",":ticketid",":qty"); 
    	$condition_arr2= array($_SESSION['event']['eventid'],$row['ticketid'],$row['quantity']);
    	$UpdateTicket=new BooventPDO();
    	$update_ticket_sql="UPDATE boovent_ticket_manager SET total_tickets_booked = total_tickets_booked + :qty,total_tickets_remaining = total_tickets_remaining - :qty WHERE event_id = :eventid AND ticket_id = :ticketid";
    	$update_result = $UpdateTicket->updateQuery($update_ticket_sql,$condition_arr1,$condition_arr2);
        if($update_result > 0) {
        	//echo "Update Successfully";
        } else {
        	//echo "Failed to Update the Count";
        }
        unset($UpdateTicket);
    //------------------------- INSERT INTO INVOICE TABLE ----------------------------------//
    $condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":order",":booking_id",":payment_id", ":email", ":name",
    	":address",":purchase_date", ":event",":location",":quantity",":paid");
    $condition_arr2= array($ordering_id,$booking_id, $payment_id, $_SESSION['user_email'],
        $_SESSION['user_name'],$user_address,$purchase_date,$event_name,$invoice_event,
        $row['quantity'],$row['paid']);

    $insert_invoice_sql="INSERT INTO boovent_invoice(order_id,booking_id,payment_id,invoice_email,invoice_name,invoice_address,invoice_create_date,event_name,event_location,quantity_puchased,total_price_paid) VALUES(:order,:booking_id,:payment_id,:email,:name,:address,:purchase_date,:event,:location,:quantity,:paid)";
    $InvoiceDetails=new BooventPDO();
    $result=$InvoiceDetails->insertQuery($insert_invoice_sql,$condition_arr1,$condition_arr2);
    if($result > 0) {
    	// echo "Invoice Pass";
    }
    else {
    	// echo "Invoice Fail";
    }
    unset($InvoiceDetails);
    //------------------------- INSERT INTO TICKET FORMAT TABLE ----------------------------------//
    $condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":order",":purchase_date", ":name", ":email",":mobile",":ticketid",
    	":type",":event_name",":event_ticket_name", ":event_address",":event_date",":quantity",":tnumber",":total");
    $condition_arr2= array($ordering_id,$purchase_date,$_SESSION['user_name'],
    	$_SESSION['user_email'],$user_contact,$row['ticketid'],'Paid',$event_name,$row['ticket'],$invoice_event,$event_time,$row['quantity'],$tnumber,$row['paid']);

    $ticket_format_sql="INSERT INTO boovent_ticket_format(order_id,event_ticket_send_date,user_name,user_email,user_mobile,ticket_id,event_ticket_type,event_name,event_ticket_name,event_ticket_address,event_ticket_date,event_ticket_quantity,event_ticket_numbers,event_ticket_total) VALUES(:order,:purchase_date,:name,:email,:mobile,:ticketid,:type,:event_name,:event_ticket_name,:event_address,:event_date,:quantity,:tnumber,:total)";
    $FormatDetails=new BooventPDO();
    $result=$FormatDetails->insertQuery($ticket_format_sql,$condition_arr1,$condition_arr2);
    if($result > 0) {
    	//echo "Format Pass";
    }
    else {
    	//echo "Format Fail";
    }
    unset($FormatDetails);
    if($row === end($ticket)) {
    //------------------------------ RETRIEVE THE BUYIED INFORMATION -----------------------//
    $condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":order"); 
    $condition_arr2= array($ordering_id);
    $confirm_sql = "SELECT *,SUM(event_ticket_total) AS total,SUM(event_ticket_quantity) AS qty FROM boovent_ticket_format WHERE order_id = :order";
    $TicketDetails=new BooventPDO();
    $ticket_result=$TicketDetails->selectQuery($confirm_sql,$condition_arr1,$condition_arr2);
    $event_total = $ticket_result[0]['total'];
    $event_quantity = $ticket_result[0]['qty'];
    unset($TicketDetails);
    //--------------------------- SEND MAIL FOR CONFIRMATION ------------------------------//
    $MessageDetails=new booventMessage();
    $message = $MessageDetails->message_for_confirmation($_SESSION['user_name'],
        $_SESSION['user_email'],$user_contact,$event_quantity,$event_total,$ordering_id);
    unset($MessageDetails);

    $to = $_SESSION['user_email'];
    $subject = 'Event Payment Confirmation Boovent';
    $MailDetails=new booventMailer();
    $MailDetails->send_mail_for_confirmation($to,$subject,$message,$ordering_id);
    unset($MailDetails);
    }
    } else {
    	$error = "Could Not Complete the Purchase.Please Try Again.";
    }
    unset($PurchaseDetails);
	}
	//--------------------------- UPDATE THE EVENT BUY COUNT ------------------------------//
		$condition_arr1="";
    	$condition_arr2="";
    	$condition_arr1= array(":email"); 
    	$condition_arr2= array($_SESSION['user_email']);
    	$UpdateUser=new BooventPDO();
    	$update_user_sql="UPDATE boovent_user SET total_events_buyied = total_events_buyied + 1 WHERE user_email=:email";
    	$update_result = $UpdateUser->updateQuery($update_user_sql,$condition_arr1,$condition_arr2);
        if($update_result > 0) {
        	//echo "Update Successfully";
        } else {
        	//echo "Failed to Update the Count";
        }
        unset($UpdateUser);
    $_SESSION['order_id'] = $ordering_id;
}

?>