<?php
ini_set('display_errors',1);

require('WriteHTML.php');	
$user_email="kumar.dharambir99@gmail.com";

$ivoice_id="64465436445634";
$cust_id='jeet09778347';
$date='06-07-2017';
$user_name="Dharambir Kumar";
$user_contact="9784458792168";
$ticket_qty='232';
$ticket_price='22232';
$ticket_booking_date="12 Jul 2017";
$ticket_booking_id="4342389794293749";
$event_name="#UpStart Pune - Funding ka Funda";
$event_location="Wingify, Vanshaj Society Koregaon Park Annexe, Mundhwa, Pune, Maharashtra, India, 411036";
$event_time="20 May 2017 05:00 PM - 20 May 2017 08:00 PM";
$description="Your registration was successful for event #UpStart Pune - Funding Ka Funda. We hope you had a smooth experience at Explara.com. Below are your transaction details.";


// ============ PDF GENERATION CODE =================================
$invoice_name=$cust_id.'.pdf';
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

// TICKET description
$pdf->SetXY(10,60);
$pdf->SetTextColor(85,85,85);
$pdf->SetFont('Arial','',12);
$pdf->MultiCell(190, 7, $description, false);

// EVENT NAME
$pdf -> SetXY(10,72);
$pdf->SetTextColor(85,85,85);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(110,18,"Event : ");

$pdf -> SetXY(27,72);
$pdf->SetTextColor(85,85,85);
$pdf->SetFont('Arial','',12);
$pdf->Cell(110,18,$event_name,'','','',false,'www.boovent.com'); //false means cell background is transparent

// LOCATION NAME
$pdf -> SetXY(10,82);
$pdf->SetTextColor(85,85,85);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(110,18,"Location : ");

$pdf -> SetXY(33,88);
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

$pdf->Output('../docs/'.$invoice_name,'F'); 
// }
?>
