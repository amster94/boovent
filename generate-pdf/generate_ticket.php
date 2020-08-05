<?php
ini_set('display_errors',1);

require('WriteHTML.php');
$event_name="UpStart Pune - Funding ka Funda";
$event_location="Wingify, Vanshaj Society Koregaon Park AnnWingify, Vanshaj Society Koregaon Park Annexe, Mundhwa, Pune, Maharashtra, India, 411036";
$event_start_time="20 May 2017 05:00 PM";
$event_end_time="20 May 2017 05:00 PM";
$ticket_type_title1="Platinum";
$ticket_type_title2="Silver";
$ticket_type_title3="Golden";
$ticket_numbering1="ABV123-ABV126";
$ticket_numbering2="ABV123-ABV126";
$ticket_numbering3="ABV123-ABV126";
$no_of_attendies="10";
$ivoice_id="64465436445634";
$cust_id='jeet09778347';
$date='06-07-2017';
$user_email="kumar.dharambir99@gmail.com";
$user_name="Dharambir Kumar";
$user_contact="9784458792168";
$terms_condition="Wingify, Vanshaj Society Koregaon Park Annexe, Mundhwa, PWingify, Vanshaj Society Koregaon Park Annexe, Mundhwa, PWingify, Vanshaj Society Koregaon Park Annexe, Mundhwa, PWingify, Vanshaj Society Koregaon Park Annexe, Mundhwa, P";
// $ticket_qty='232';
// $ticket_price='22232';
// $ticket_booking_date="12 Jul 2017";
// $ticket_booking_id="4342389794293749";


// $description="Your registration was successful for event #UpStart Pune - Funding Ka Funda. We hope you had a smooth experience at Explara.com. Below are your transaction details.";


// ============ PDF GENERATION CODE =================================
$invoice_name=$cust_id.'.pdf';
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
if(!empty($ticket_type_title1)){
$pdf->MultiCell(100, 7, $ticket_type_title1.' '.$ticket_numbering1, false);
}
if(!empty($ticket_type_title2)){
$pdf->MultiCell(100, 7, $ticket_type_title2.' '.$ticket_numbering2, false);
}
if(!empty($ticket_type_title3)){
$pdf->MultiCell(100, 7, $ticket_type_title3.' '.$ticket_numbering3, false);
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
// }
?>
