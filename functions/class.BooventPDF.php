<?php
require('../generate-pdf/WriteHTML.php');
require_once '../connect/class.booventpdo.php';
ini_set('display_errors',1);

class booventPDF {
	//============================== INVOICE FORMAT =========================================//
public function send_invoice_pdf($order_id) {
	$current_date=date('Y-m-d') ;
	//-------------------------- GET PURCHASE DETAIL -----------------------------------//
	$condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":order"); 
    $condition_arr2= array($order_id);
    $purchase_sql = "SELECT event_id FROM boovent_purchase WHERE order_id = :order";
    $PurchaseDetails=new BooventPDO();
    $purchase_result=$PurchaseDetails->selectQuery($purchase_sql,$condition_arr1,$condition_arr2);
    $max_size = sizeof($purchase_result);
    if($max_size > 0) {
    	$event_id = $purchase_result[0]['event_id'];
    }
    else {
    	//Fail
    }
    unset($PurchaseDetails);
    //------------------------------ RETRIEVE THE BUYIED INFORMATION -----------------------//
    $condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":order"); 
    $condition_arr2= array($order_id);
    $buy_sql = "SELECT *,SUM(event_ticket_total) AS total,SUM(event_ticket_quantity) AS qty FROM boovent_ticket_format WHERE order_id = :order";
    $TicketDetails=new BooventPDO();
    $buy_result=$TicketDetails->selectQuery($buy_sql,$condition_arr1,$condition_arr2);
    $event_total = $buy_result[0]['total'];
    $event_quantity = $buy_result[0]['qty'];
    unset($TicketDetails);
    //-------------------------- GET EVENT DETAIL -----------------------------------//
	$condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":eventid"); 
    $condition_arr2= array($event_id);
    $event_sql = "SELECT * FROM boovent_events WHERE event_id = :eventid";
    $EventDetails=new BooventPDO();
    $event_result=$EventDetails->selectQuery($event_sql,$condition_arr1,$condition_arr2);
    $max_size = sizeof($event_result);
    if($max_size > 0) {
    	$event_description = $event_result[0]['event_description'];
    }
    else {
    	//Fail
    }
    unset($EventDetails);
	//-------------------------- GET TICKET FORMAT -----------------------------------//
	$condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":order"); 
    $condition_arr2= array($order_id);
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
    
	$user_email=$ticket_result[0]['user_email'];
	//-------------------------- GET USER DETAILS -----------------------------------//
	$condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":email"); 
    $condition_arr2= array($user_email);
    $user_sql = "SELECT * FROM boovent_user WHERE user_email = :email";
    $UserDetails=new BooventPDO();
    $user_result=$UserDetails->selectQuery($user_sql,$condition_arr1,$condition_arr2);
    $max_size = sizeof($user_result);
    if($max_size > 0) {
    	$user_name = $user_result[0]['user_name'];
    	$user_contact = $user_result[0]['user_mobile'];
    }
    else {
    	//Fail
    }
    unset($UserDetails);
    //---------------------- INITIALIZE THE VARIABLES -----------------------------------//
	$date=$current_date;
	$ticket_qty=$event_quantity;
	$ticket_price=$event_total;
	$ticket_booking_date=date('l jS \of F Y ');
	$ticket_booking_id=$order_id;
	$description=$event_description;
	// ======================== PDF GENERATION CODE ================================= //
	$invoice_name=$order_id.'_invoice'.'.pdf';
	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true, 15);
	$pdf->AddPage();

	// SETTING TOP LOGO
	$pdf->Image('../images/logo.png',10,10,40);

	// HORIZONTAL LINE
	$pdf->SetLineWidth(0.1);
	$pdf->SetDrawColor(212, 89, 90);
	$pdf->Line(10, 27, 200, 27);

	// SETTING VERIFIED TICK ICON
	$pdf->Image('../images/tick.png',10,36,8);
	$pdf->SetTextColor(85,85,85);
	$pdf->SetXY(18,32);
	$pdf->SetFont('Arial','B',16);
	$pdf->Cell(110,18,'Thank you. Your transaction is done!');

	// USER NAME
	$pdf->SetTextColor(85,85,85);
	$pdf->SetXY(10,44);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(110,18,'Dear '.$user_name);

	// EVENT NAME
	$pdf -> SetXY(10,$pdf->GetY()+10);
	$pdf->SetTextColor(85,85,85);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(110,18,"Event : ");

	$pdf -> SetXY(27,$pdf->GetY());
	$pdf->SetTextColor(85,85,85);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(110,18,$event_name,'','','',false,'www.boovent.com'); //false means cell background is transparent

	// LOCATION NAME
	$pdf -> SetXY(10,$pdf->GetY()+10);
	$pdf->SetTextColor(85,85,85);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(110,18,"Location : ");

	$pdf -> SetXY(33,$pdf->GetY()+6);
	$pdf->SetTextColor(85,85,85);
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(160, 7, $event_location, false);

	// EVENT TIMING
	$pdf -> SetXY(10,$pdf->GetY());
	$pdf->SetTextColor(85,85,85);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(110,18,"Time : ");

	$pdf -> SetXY(27,$pdf->GetY());
	$pdf->SetTextColor(85,85,85);

	$pdf->SetFont('Arial','',12);
	$pdf->Cell(110,18,$event_time);

	// CREATING RECTANGULAR BOX
	$pdf->setFillColor(222, 51, 52);
	$pdf->Rect(10,$pdf->GetY()+15,190,40,'D');
	// TICKET BOOKING ON NAME
	$pdf->SetTextColor(85,85,85);
	$pdf->SetXY(13,$pdf->GetY()+15);
	$pdf->SetFont('Arial','B',18);
	$pdf->Cell(110,18, $user_name);

	$pdf->SetTextColor(85,85,85);
	$pdf->SetXY(13,$pdf->GetY()+10);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(110,18, $user_email);

	$pdf->SetTextColor(85,85,85);
	$pdf->SetXY(13,$pdf->GetY()+10);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(110,18, $user_contact);

	$pdf->SetTextColor(85,85,85);
	$pdf->SetXY(85,$pdf->GetY()-10);
	$pdf->SetFont('Arial','B',16);
	$pdf->Cell(110,18, "Ticket QTY. ".$ticket_qty);

	$pdf->SetTextColor(85,85,85);
	$pdf->SetXY(135,$pdf->GetY()+0);
	$pdf->SetFont('Arial','B',23);
	$pdf->Cell(110,18, "Total Rs. ".$ticket_price);

	// CREATING RECTANGULAR BOX
	$pdf->setFillColor(193, 7, 8);
	$pdf->Rect(10,$pdf->GetY()+30,190,10,'D');

	$pdf->SetTextColor(85,85,85);
	$pdf->SetXY(13,$pdf->GetY()+26);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(110,18, "Booking Date : ".$ticket_booking_date);

	$pdf->SetTextColor(85,85,85);
	$pdf->SetXY(135,$pdf->GetY()+0);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(110,18, "Order Id : ".$ticket_booking_id);

	$pdf->SetTextColor(85,85,85);
	$pdf->SetXY(10,$pdf->GetY()+30);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(110,18, "Is there anything you want to share with us?");

	$pdf->SetTextColor(85,85,85);
	$pdf->SetXY(10,$pdf->GetY()+8);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(110,18, "Feedback, comments, suggestions or compliments - do write to support@boovent.com");

	$pdf->Image('../images/logo.png',10,$pdf->GetY()+30,40);

	$pdf->Output('../docs/invoice/'.$invoice_name,'F');
}

	//============================== TICKET FORMAT =========================================//
public function send_ticket_pdf($order_id) {
	//----------------------- INITIALIZE THE VARIABLES ---------------------------------//
	$ticket_type_title1="";
	$ticket_type_title2="";
	$ticket_type_title3="";
	$ticket_type_title4="";
	$ticket_type_title5="";
	$ticket_type_title6="";
	$ticket_type_title7="";
	$ticket_type_title8="";
	$ticket_type_title9="";
	$ticket_numbering1="";
	$ticket_numbering2="";
	$ticket_numbering3="";
	$ticket_numbering4="";
	$ticket_numbering5="";
	$ticket_numbering6="";
	$ticket_numbering7="";
	$ticket_numbering8="";
	$ticket_numbering9="";
	//-------------------------- GET PURCHASE DETAIL -----------------------------------//
	$condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":order"); 
    $condition_arr2= array($order_id);
    $purchase_sql = "SELECT event_id FROM boovent_purchase WHERE order_id = :order";
    $PurchaseDetails=new BooventPDO();
    $purchase_result=$PurchaseDetails->selectQuery($purchase_sql,$condition_arr1,$condition_arr2);
    $max_size = sizeof($purchase_result);
    if($max_size > 0) {
    	$event_id = $purchase_result[0]['event_id'];
    }
    else {
    	//Fail
    }
    unset($PurchaseDetails);
    //------------------------------ RETRIEVE THE BUYIED INFORMATION -----------------------//
    $condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":order"); 
    $condition_arr2= array($order_id);
    $buy_sql = "SELECT *,SUM(event_ticket_quantity) AS qty FROM boovent_ticket_format WHERE order_id = :order";
    $TicketDetails=new BooventPDO();
    $buy_result=$TicketDetails->selectQuery($buy_sql,$condition_arr1,$condition_arr2);
    $user_email = $buy_result[0]['user_email'];
    $event_quantity = $buy_result[0]['qty'];
    $event_location = $buy_result[0]['event_ticket_address'];
    unset($TicketDetails);
    //-------------------------- GET EVENT DETAIL -----------------------------------//
	$condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":eventid"); 
    $condition_arr2= array($event_id);
    $event_sql = "SELECT *,DATE_FORMAT(event_start_date, '%W %M %e %r') as formatted_start_date,DATE_FORMAT(event_end_date, '%W %M %e %r') as formatted_end_date FROM boovent_events WHERE event_id = :eventid";
    $EventDetails=new BooventPDO();
    $event_result=$EventDetails->selectQuery($event_sql,$condition_arr1,$condition_arr2);
    $max_size = sizeof($event_result);
    if($max_size > 0) {
    	$event_name = $event_result[0]['event_title'];
    	$event_description = $event_result[0]['event_description'];
    	$event_start_date = $event_result[0]['formatted_start_date'];
    	$event_end_date = $event_result[0]['formatted_end_date'];
    }
    else {
    	//Fail
    }
    unset($EventDetails);
    //-------------------------- GET TICKET FORMAT -----------------------------------//
	$condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":order"); 
    $condition_arr2= array($order_id);
    $confirm_sql = "SELECT * FROM boovent_ticket_format WHERE order_id = :order";
    $TicketDetails=new BooventPDO();
    $ticket_result=$TicketDetails->selectQuery($confirm_sql,$condition_arr1,$condition_arr2);
    $max_ticket_size = sizeof($ticket_result);
    if($max_ticket_size > 0) {
    	$i = 1;
    	foreach($ticket_result as $rows) {
    		${'ticket_type_title'.$i} = $rows['event_ticket_name'];
    		${'ticket_numbering'.$i} = $rows['event_ticket_numbers'];
    		$i++;
    	}
    }
    else {
    	//Fail
    }
    unset($TicketDetails);
    //-------------------------- GET USER DETAILS -----------------------------------//
	$condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":email"); 
    $condition_arr2= array($user_email);
    $user_sql = "SELECT * FROM boovent_user WHERE user_email = :email";
    $UserDetails=new BooventPDO();
    $user_result=$UserDetails->selectQuery($user_sql,$condition_arr1,$condition_arr2);
    $max_size = sizeof($user_result);
    if($max_size > 0) {
    	$user_name = $user_result[0]['user_name'];
    	$user_contact = $user_result[0]['user_mobile'];
    }
    else {
    	//Fail
    }
    unset($UserDetails);

	$event_start_time=$event_start_date;
	$event_end_time=$event_end_date;
	$no_of_attendies=$event_quantity;
	$terms_condition="Please do not Share or make copies or Edit the details of the following Ticket. If found guilty the Event Manager has the right to cancel the registration of the Event without notice.No Refund will be applicable in such case.";
	// ============ PDF GENERATION CODE =================================
	$invoice_name=$order_id.'_ticket'.'.pdf';
	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true, 15);

	$pdf->AddPage();

	// SETTING TOP LOGO
	$pdf->Image('../images/logo.png',10,10,40);
	// ADDING WATERMARK
	$pdf->SetFont('Arial','B',50);
	$pdf->SetTextColor(240,240,240);
	$pdf->RotatedText(60,150,'BOOVENT.COM',45);

	// HORIZONTAL LINE
	$pdf->SetLineWidth(1.0);
	$pdf->SetDrawColor(193, 7, 8);
	$pdf->Line(10, 27, 200, 27);

	// EVENT NAME
	$pdf -> SetXY($pdf->GetX(),$pdf->GetY()+20);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',22);
	$pdf->Cell(190,18,$event_name,'','','C',0,'www.boovent.com'); //false means cell background is transparent

	// EVENT LOCATION
	$pdf -> SetXY(10,$pdf->GetY()+15);
	$pdf->SetTextColor(245,88,122);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(100,18,'LOCATION','','','L',0,''); 

	$pdf -> SetXY(10,$pdf->GetY()+12);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',13);
	$pdf->MultiCell(100, 7, $event_location, false);

	// EVENT LOCATION
	$pdf -> SetXY(10,$pdf->GetY());
	$pdf->SetTextColor(245,88,122);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(100,18,'DATE AND TIME','','','L',0,'');

	// EVENT START AND END TIME
	$pdf -> SetXY(10,$pdf->GetY()+12);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',13);
	$pdf->MultiCell(100, 7, 'START: '.$event_start_time, false);
	$pdf->MultiCell(100, 7, 'END : '.$event_end_time, false);

	// TICKET TYPE AND NUMBERING
	$pdf -> SetXY(10,$pdf->GetY());
	$pdf->SetTextColor(245,88,122);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(100,18,'TICKET TYPE AND NUMBERING','','','L',0,'');

	$pdf -> SetXY(10,$pdf->GetY()+12);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',10);

	// if(!empty($ticket_type_title1)){
	// $pdf->MultiCell(100, 7, $ticket_type_title1.' '.$ticket_numbering1, false);
	// }
	// if(!empty($ticket_type_title2)){
	// $pdf->MultiCell(100, 7, $ticket_type_title2.' '.$ticket_numbering2, false);
	// }
	// if(!empty($ticket_type_title3)){
	// $pdf->MultiCell(100, 7, $ticket_type_title3.' '.$ticket_numbering3, false);
	// }
    for($i=1;$i<=$max_ticket_size;$i++) {
    	if(!empty(${'ticket_type_title'.$i})){
		$pdf->MultiCell(100, 7, ${'ticket_type_title'.$i}.' '.${'ticket_numbering'.$i}, false);
		}
    }

	// VERTICAL LINE
	$pdf->SetLineWidth(0.5);
	$pdf->SetDrawColor(193, 7, 8);
	$pdf->Line(120, 60, 120, $pdf->GetY());

	// NUMBER OF ATTENDIES
	$pdf -> SetXY(125,55);
	$pdf->SetTextColor(245,88,122);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(100,18,'NO OF ATTENDIES','','','L',0,'');

	$pdf -> SetXY(125,$pdf->GetY()+12);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',13);
	$pdf->MultiCell(100, 7, $no_of_attendies, false);

	// TICKET BOOKED BY NAME
	$pdf -> SetXY(125,$pdf->GetY());
	$pdf->SetTextColor(245,88,122);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(100,18,'TICKET BOOKED BY','','','L',0,'');

	$pdf -> SetXY(125,$pdf->GetY()+12);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',13);
	$pdf->MultiCell(100, 7, $user_name, false);

	// TICKET BOOKED BY EMAIL
	$pdf -> SetXY(125,$pdf->GetY());
	$pdf->SetTextColor(245,88,122);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(100,18,'EMAIL AND CONTACT','','','L',0,'');

	$pdf -> SetXY(125,$pdf->GetY()+12);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',13);
	$pdf->MultiCell(100, 7, $user_email, false);

	$pdf -> SetXY(125,$pdf->GetY());
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',13);
	$pdf->MultiCell(100, 7, $user_contact, false);

	// HORIZONTAL LINE
	$pdf->SetLineWidth(0.5);
	$pdf->SetDrawColor(193, 7, 8);
	$pdf->Line(10, $pdf->GetY()+30, 200, $pdf->GetY()+30);

	// TERMS AND CONDITION OF USE TICKETS
	$pdf -> SetXY(10,$pdf->GetY()+30);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(100,18,'TERMS & CONDITION OF USE','','','L',0,'');

	$pdf -> SetXY(10,$pdf->GetY()+12);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',11);
	$pdf->MultiCell(190, 7, $terms_condition, false);

	// TERMS AND CONDITION OF USE TICKETS
	$pdf -> SetXY(10,$pdf->GetY()+15);
	$pdf->SetTextColor(245,88,122);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(190,18,"POWERED BY BOOVENT.COM",'','','L',0,'www.boovent.com');
	$pdf->Output('../docs/tickets/'.$invoice_name,'F');
		
	}
}


?>
