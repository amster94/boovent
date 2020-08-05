<?php
require_once '../connect/class.booventpdo.php';
require_once '../functions/class.booventMailer.php';
require_once '../functions/class.BooventMessage.php';
ini_set('display_errors',1);
if(!isset($_SESSION)){
    session_start();
}
//========================== EVENT CREATION FUNCTION ===========================================//
function generateEventCode(){
    $unique =   FALSE;
    $length =   8;
    $chrDb  =   array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
    //Generate the random Event Id for the Event
	$CreateEvent = new BooventPDO;
	$get_event_id_sql = "SELECT event_id FROM boovent_events";
	$result=$CreateEvent->selectQuery($get_event_id_sql);
	//print_r(sizeof($result));
	$max_length = sizeof($result);
	if($max_length > 0) {
		if(!$unique){
          $str = '';
          $eventRand = '';
          for ($count = 0; $count < $length; $count++){
              $chr = $chrDb[rand(0,count($chrDb)-1)];
              if (rand(0,1) == 0){
                 $chr = strtolower($chr);
              }
              if (3 == $count){
                 $str .= '-';
              }
              $str .= $chr;
          }
          $eventRand = "BVNT-".$str;
          $counter = 1;
          foreach($result as $row) {
          	if ($max_length == $counter) {
		        if ($eventRand != $row['event_id']){ $unique = TRUE; }
		    } else { /* Do Another Thing Here*/ }
		    $counter++;
          } 
    	}
    	return $eventRand;
	}
	else {
		$str = '';
          for ($count = 0; $count < $length; $count++){
              $chr = $chrDb[rand(0,count($chrDb)-1)];
              if (rand(0,1) == 0){
                 $chr = strtolower($chr);
              }
              if (3 == $count){
                 $str .= '-';
              }
              $str .= $chr;
          }
          return "BVNT-".$str;
	}
	unset($CreateEvent);
}

//----------------- CHECK FOR EVENT IMAGE SESSION ---------------------------//
if(!empty($_SESSION['event_image'])) {
	$event_image = $_SESSION['event_image'];
}
else {
	$event_image = "Not Given";
}
//============================== CREATE EVENT ==============================================//
if(isset($_POST['event_title'])){
try {
	//------------------------ SET THE TICKET TYPES(GOLD,SILVER,PLATINUM) TO 0 -----------------//
	$no_of_ticket_types = 0;
	//------------------------ SET ALL POST VARIABLES ---------------------------------// 
	$event_place_type = $_POST['event_place_type'];
	$event_occurence = $_POST['event_occurence'];
	$event_type = $_POST['event_type'];
	$event_title = $_POST['event_title'];
	$event_location = strtok($_POST['event_location'], ',');
	$event_address = $_POST['event_address'];
	$event_zip = $_POST['event_zip'];
	$event_city = $_POST['event_city'];
	$event_state = $_POST['event_state'];
	$event_country = $_POST['event_country'];
	$event_mobile = $_POST['event_mobile'];
	if(!empty($_POST['event_organization'])) {
		$event_organization = $_POST['event_organization'];
	}
	else { $event_organization = "Not Specified"; }
	if(!empty($_POST['event_website'])) {
		$event_website = $_POST['event_website'];
	}
	else { $event_website = "Not Specified"; }
	if (isset($_POST['event_start_date'])) {
		$start = $_POST['event_start_date'];
		$time = strtotime($start);
		$event_start_date = date ("Y-m-d H:i:s", $time );
	}
	if (isset($_POST['event_end_date'])) {
		$end = $_POST['event_end_date'];
		$time1 = strtotime($end);
		$event_end_date = date ("Y-m-d H:i:s", $time1 );
	}
	$event_start_date = $_POST['event_start_date'];
	$event_end_date = $_POST['event_end_date'];
	$event_description = $_POST['event_description'];
	$event_term_condition = $_POST['event_term_condition'];
	$event_tag = $_POST['event_tag'];
	$event_category = $_POST['event_category'];
	$event_sub_category = $_POST['event_sub_category'];

	$event_tag = $event_category.','.$event_tag;
	$event_tag=trim($event_tag,',');
	if(isset($_POST['payment_type'])) {
		$payment_type = $_POST['payment_type'];
	}
	else {
		$payment_type = "Not Applicable";
	}
	$ticket_name1 = $_POST['ticket_name'];
	$ticket_quantity1 = $_POST['ticket_quantity'];
	if(isset($_POST['ticket_price'])) {
		if($_POST['ticket_price'] == 0) {
			$ticket_price1 = $_POST['ticket_price'];
		}
		else {
			$ticket_price1 = $_POST['ticket_price'];
			$no_of_ticket_types = 1;
		}
	}
	
	// ---------------------- IF ENTERED TICKET 2 -----------------------------------------//
	if(isset($_POST['ticket_name2'])) {
	if(!empty($_POST['ticket_name2'])) {
	$ticket_name2 = $_POST['ticket_name2'];
	$ticket_quantity2 = $_POST['ticket_quantity2'];
	$ticket_price2 = $_POST['ticket_price2'];
	$no_of_ticket_types = 2;
	}
	}
	//------------------------ IF ENTERED TICKET 3 -----------------------------------------//
	if(isset($_POST['ticket_name3'])) {
	if(!empty($_POST['ticket_name3'])) {
	$ticket_name3 = $_POST['ticket_name3'];
	$ticket_quantity3 = $_POST['ticket_quantity3'];
	$ticket_price3 = $_POST['ticket_price3'];
	$no_of_ticket_types = 3;
	}
	}
	//------------------------ IF ENTERED TICKET 4 -----------------------------------------//
	if(isset($_POST['ticket_name4'])) {
	if(!empty($_POST['ticket_name4'])) {
	$ticket_name4 = $_POST['ticket_name4'];
	$ticket_quantity4 = $_POST['ticket_quantity4'];
	$ticket_price4 = $_POST['ticket_price4'];
	$no_of_ticket_types = 4;
	}
	}
	//------------------------ IF ENTERED TICKET 5 -----------------------------------------//
	if(isset($_POST['ticket_name5'])) {
	if(!empty($_POST['ticket_name5'])) {
	$ticket_name5 = $_POST['ticket_name5'];
	$ticket_quantity5 = $_POST['ticket_quantity5'];
	$ticket_price5 = $_POST['ticket_price5'];
	$no_of_ticket_types = 5;
	}
	}
	//------------------------ IF ENTERED TICKET 6 -----------------------------------------//
	if(isset($_POST['ticket_name6'])) {
	if(!empty($_POST['ticket_name6'])) {
	$ticket_name6 = $_POST['ticket_name6'];
	$ticket_quantity6 = $_POST['ticket_quantity6'];
	$ticket_price6 = $_POST['ticket_price6'];
	$no_of_ticket_types = 6;
	}
	}
	//------------------------ IF ENTERED TICKET 7 -----------------------------------------//
	if(isset($_POST['ticket_name7'])) {
	if(!empty($_POST['ticket_name7'])) {
	$ticket_name7 = $_POST['ticket_name7'];
	$ticket_quantity7 = $_POST['ticket_quantity7'];
	$ticket_price7 = $_POST['ticket_price7'];
	$no_of_ticket_types = 7;
	}
	}
	//------------------------ IF ENTERED TICKET 8 -----------------------------------------//
	if(isset($_POST['ticket_name8'])) {
	if(!empty($_POST['ticket_name8'])) {
	$ticket_name8 = $_POST['ticket_name8'];
	$ticket_quantity8 = $_POST['ticket_quantity8'];
	$ticket_price8 = $_POST['ticket_price8'];
	$no_of_ticket_types = 8;
	}
	}
	//------------------------ IF ENTERED TICKET 9 -----------------------------------------//
	if(isset($_POST['ticket_name9'])) {
	if(!empty($_POST['ticket_name9'])) {
	$ticket_name9 = $_POST['ticket_name9'];
	$ticket_quantity9 = $_POST['ticket_quantity9'];
	$ticket_price9 = $_POST['ticket_price9'];
	$no_of_ticket_types = 9;
	}
	}

	if(!empty($_POST['button_type'])) {
		$button_type = $_POST['button_type'];
	} else {
		$button_type = "DEFAULT_BUTTON";
	}
	
	//------------------ INITIALIZE THE VARIABLES -----------------------------------------//
	$condition_arr1 = "";
	$condition_arr2 = "";
	//----------------- GET RANDON GENERATED EVENT ID ------------------------------------//
	$event_id = generateEventCode();
	//------------------ FETCH USER IP ----------------------------------------//
	$ipaddress = getenv('REMOTE_ADDR');
	//------------------------- PROCESS THE EVENT CREATION --------------------------------//
	$CreateEvent = new BooventPDO;
	//----------------------- INSERT INTO EVENT -------------------------------//
	$insert_event_sql = "INSERT INTO boovent_events(event_id,event_type,event_occurence,user_email,organizer_mobile,event_title,event_organization,event_category,event_sub_category,event_create_date,event_start_date,event_end_date,ipaddress,event_description,event_conditions,event_location,event_address,event_zipcode,event_city,event_state,
	event_country,event_website,event_tags,event_image,event_button) VALUES(:eventid,:event_type,:event_occurence,:email,:mobile,:title,:organization,:category,:subcategory,now(),:startdate,:enddate,:ip,:description,:conditions,:location,:address,:zip,:city,:state,:country,:website,:tags,:image,:show_type)";
	$condition_arr1= array(":eventid",":event_type",":event_occurence",":email", ":mobile",":title",":organization",":category",":subcategory",":startdate",":enddate",":ip",":description",":conditions",":location",":address",":zip",":city",":state",":country",":website",":tags",":image",":show_type");
	$condition_arr2= array($event_id,$event_place_type,$event_occurence,$_SESSION['user_email'], $event_mobile, $event_title,$event_organization,$event_category,$event_sub_category,date ("Y-m-d H:i:s", $time ),date ("Y-m-d H:i:s", $time1 ),$ipaddress,$event_description,$event_term_condition,$event_location,$event_address,$event_zip,$event_city,$event_state,$event_country,$event_website,$event_tag,$event_image,$button_type);
	$result=$CreateEvent->insertQuery($insert_event_sql,$condition_arr1,$condition_arr2);
	if($result > 0) {
		$condition_arr1 = "";
		$condition_arr2 = "";
		$insert_ticket_sql = "INSERT INTO boovent_ticket_manager(user_email,event_id,ticket_id,ticket_name,ticket_type,ticket_class,ticket_price,payment_bearing,total_tickets_issued,total_tickets_remaining) VALUES(:email,:eventid,:ticketid,:name,:type,:class,:price,:bearing,:issued,:remaining)";
		if($no_of_ticket_types > 0 ) {
			for($i=1;$i<=$no_of_ticket_types;$i++) {
			if($i==1) { $ticket_class = "GOLD";$ticket_id = "TKT-".$event_id."-1"; }
			else if($i==2) { $ticket_class = "SILVER";$ticket_id = "TKT-".$event_id."-2"; }
			else if($i==3) { $ticket_class = "BRONZE";$ticket_id = "TKT-".$event_id."-3"; }
			else if($i==4) { $ticket_class = "EXT1";$ticket_id = "TKT-".$event_id."-4"; }
			else if($i==5) { $ticket_class = "EXT2";$ticket_id = "TKT-".$event_id."-5"; }
			else if($i==6) { $ticket_class = "EXT3";$ticket_id = "TKT-".$event_id."-6"; }
			else if($i==7) { $ticket_class = "EXT4";$ticket_id = "TKT-".$event_id."-7"; }
			else if($i==8) { $ticket_class = "EXT5";$ticket_id = "TKT-".$event_id."-8"; }
			else if($i==9) { $ticket_class = "EXT6";$ticket_id = "TKT-".$event_id."-9"; }
			$condition_arr1= array(":email",":eventid", ":ticketid",":name",":type",":class",":price",":bearing",":issued",":remaining");//SQL BINDPARAM 
			$condition_arr2= array($_SESSION['user_email'],$event_id, $ticket_id,${"ticket_name".$i},$event_type,$ticket_class,${"ticket_price".$i},$payment_type,${"ticket_quantity".$i},${"ticket_quantity".$i});
			$CreateEvent->insertQuery($insert_ticket_sql,$condition_arr1,$condition_arr2);
			}
			echo "Event Created Successfully!";
		}
		else {
			$ticket_id = "TKT-".$event_id."-0";
			$ticket_class = "GENERAL";
			$condition_arr1= array(":email",":eventid", ":ticketid",":name",":type",":class",":price",":bearing",":issued",":remaining");//SQL BINDPARAM 
			$condition_arr2= array($_SESSION['user_email'],$event_id, $ticket_id,$ticket_name1,$event_type,$ticket_class,$ticket_price1,$payment_type,$ticket_quantity1,$ticket_quantity1);//BINDPARAM VALUE
			$result1=$CreateEvent->insertQuery($insert_ticket_sql,$condition_arr1,$condition_arr2);
			if($result1 > 0) {
				echo "Event Created Successfully!";
			}
			else {
				echo "Something went wrong please contact at support@boovent.com";
			}
		}
		//------------------------------ UPDATE THE USER EVENT CREATION COUNT ---------------//
		$event_update_sql="UPDATE boovent_user SET total_event_created = total_event_created +1 WHERE user_email = :email ";
		$CreateEvent->query($event_update_sql);
        $CreateEvent->bindParam(':email', $_SESSION['user_email']);
        $CreateEvent->execute();
        //----------- DESTROY IMAGE PATH ----------------------//
        if(isset($_SESSION['event_image'])) {
                unset($_SESSION['event_image']);
        }

    $MessageDetails=new booventMessage();
    $message = $MessageDetails->message_for_event_created(
    $_SESSION['user_email'],$event_title);
    unset($MessageDetails);
    //print_r($message);

    $to = PERSONAL_MAIL;
    $subject = 'New Event Created -'.$event_title;
    $MailDetails=new booventMailer();
    $MailDetails->send_mail_for_event_created($to,$subject,$message);
    unset($MailDetails);
	}
	else {
		echo "Error Query Execution Failed !";
	}
	unset($CreateEvent);
	} catch(Exception $e) {
		$return = "Exception Message ->".$e->getMessage().":Exception Code ->".$e->getCode();
  		$return.=":Exception File ->".$e->getFile().":Exception Line ->".$e->getLine();
  		echo $return;
	}
}

// ============================ UPDATE EVENT ============================================== //
if(isset($_POST['update_event'])) {
	//------------------------ SET THE TICKET TYPES(GOLD,SILVER,PLATINUM) TO 0 -----------------//
	$no_of_ticket_types = 0;
	//------------------------ SET ALL POST VARIABLES ---------------------------------// 
	$event_place_type = $_POST['event_place_type'];
	$event_occurence = $_POST['event_occurence'];
	$update_event_id = $_POST['update_event'];
	$event_type = $_POST['event_type'];
	$event_title = $_POST['event_title_update'];
	$event_location = strtok($_POST['event_location'], ',');
	$event_address = $_POST['event_address'];
	$event_zip = $_POST['event_zip'];
	$event_city = $_POST['event_city'];
	$event_state = $_POST['event_state'];
	$event_country = $_POST['event_country'];
	$event_mobile = $_POST['event_mobile'];
	if(!empty($_POST['event_organization'])) {
		$event_organization = $_POST['event_organization'];
	}
	else {
		$event_organization = "Not Specified";
	}
	if(isset($_POST['event_website'])) {
		$event_website = $_POST['event_website'];
	}
	else {
		$event_website = "Not Specified";
	}
	if (isset($_POST['event_start_date'])) {
		$start = $_POST['event_start_date'];
		$time = strtotime($start);
		$event_start_date = date ("Y-m-d H:i:s", $time );
	}
	if (isset($_POST['event_end_date'])) {
		$end = $_POST['event_end_date'];
		$time1 = strtotime($end);
		$event_end_date = date ("Y-m-d H:i:s", $time1 );
	}
	$event_start_date = $_POST['event_start_date'];
	$event_end_date = $_POST['event_end_date'];
	$event_description = $_POST['event_description'];
	$event_term_condition = $_POST['event_term_condition'];
	$event_tag = $_POST['event_tag'];
	$event_category = $_POST['event_category'];
	$event_sub_category = $_POST['event_sub_category'];
	if(isset($_POST['payment_type'])) {
		$payment_type = $_POST['payment_type'];
	}
	else {
		$payment_type = "Not Applicable";
	}
	$ticket_name1 = $_POST['ticket_name'];
	$ticket_quantity1 = $_POST['ticket_quantity'];
	if(isset($_POST['ticket_price'])) {
		if($_POST['ticket_price'] == 0) {
			$ticket_price1 = $_POST['ticket_price'];
		}
		else {
			$ticket_price1 = $_POST['ticket_price'];
			$no_of_ticket_types = 1;
		}
	}
	
	// ---------------------- IF ENETERED TICKET 2 -----------------------------------------//
	if(isset($_POST['ticket_name2'])) {
	if(!empty($_POST['ticket_name2'])) {
	$ticket_name2 = $_POST['ticket_name2'];
	$ticket_quantity2 = $_POST['ticket_quantity2'];
	$ticket_price2 = $_POST['ticket_price2'];
	$no_of_ticket_types = 2;
	}
	}
	//------------------------ IF ENETERED TICKET 3 -----------------------------------------//
	if(isset($_POST['ticket_name3'])) {
	if(!empty($_POST['ticket_name3'])) {
	$ticket_name3 = $_POST['ticket_name3'];
	$ticket_quantity3 = $_POST['ticket_quantity3'];
	$ticket_price3 = $_POST['ticket_price3'];
	$no_of_ticket_types = 3;
	}
	}
	//------------------------ IF ENTERED TICKET 4 -----------------------------------------//
	if(isset($_POST['ticket_name4'])) {
	if(!empty($_POST['ticket_name4'])) {
	$ticket_name4 = $_POST['ticket_name4'];
	$ticket_quantity4 = $_POST['ticket_quantity4'];
	$ticket_price4 = $_POST['ticket_price4'];
	$no_of_ticket_types = 4;
	}
	}
	//------------------------ IF ENTERED TICKET 5 -----------------------------------------//
	if(isset($_POST['ticket_name5'])) {
	if(!empty($_POST['ticket_name5'])) {
	$ticket_name5 = $_POST['ticket_name5'];
	$ticket_quantity5 = $_POST['ticket_quantity5'];
	$ticket_price5 = $_POST['ticket_price5'];
	$no_of_ticket_types = 5;
	}
	}
	//------------------------ IF ENTERED TICKET 6 -----------------------------------------//
	if(isset($_POST['ticket_name6'])) {
	if(!empty($_POST['ticket_name6'])) {
	$ticket_name6 = $_POST['ticket_name6'];
	$ticket_quantity6 = $_POST['ticket_quantity6'];
	$ticket_price6 = $_POST['ticket_price6'];
	$no_of_ticket_types = 6;
	}
	}
	//------------------------ IF ENTERED TICKET 7 -----------------------------------------//
	if(isset($_POST['ticket_name7'])) {
	if(!empty($_POST['ticket_name7'])) {
	$ticket_name7 = $_POST['ticket_name7'];
	$ticket_quantity7 = $_POST['ticket_quantity7'];
	$ticket_price7 = $_POST['ticket_price7'];
	$no_of_ticket_types = 7;
	}
	}
	//------------------------ IF ENTERED TICKET 8 -----------------------------------------//
	if(isset($_POST['ticket_name8'])) {
	if(!empty($_POST['ticket_name8'])) {
	$ticket_name8 = $_POST['ticket_name8'];
	$ticket_quantity8 = $_POST['ticket_quantity8'];
	$ticket_price8 = $_POST['ticket_price8'];
	$no_of_ticket_types = 8;
	}
	}
	//------------------------ IF ENTERED TICKET 9 -----------------------------------------//
	if(isset($_POST['ticket_name9'])) {
	if(!empty($_POST['ticket_name9'])) {
	$ticket_name9 = $_POST['ticket_name9'];
	$ticket_quantity9 = $_POST['ticket_quantity9'];
	$ticket_price9 = $_POST['ticket_price9'];
	$no_of_ticket_types = 9;
	}
	}

	//------------------ INITIALIZE THE VARIABLES -----------------------------------------//
	$condition_arr1 = "";
	$condition_arr2 = "";
	
	//------------------ FETCH USER IP ----------------------------------------//
	$ipaddress = getenv('REMOTE_ADDR');
	//------------------------- PROCESS THE EVENT CREATION --------------------------------//
	$updateEvent = new BooventPDO;
	$update_ticket_manager = new BooventPDO;
	//----------------------- INSERT INTO EVENT -------------------------------//
	$update_event_sql = "UPDATE boovent_events SET organizer_mobile=:mobile,event_type=:event_type,event_occurence=:event_occurence, event_title=:title, event_organization=:organization, event_category=:category, event_sub_category=:subcategory, event_create_date=now(), event_start_date=:startdate, event_end_date=:enddate, ipaddress=:ip, event_description=:description, event_conditions=:conditions, event_location=:location, event_address=:address, event_zipcode=:zip, event_city=:city, event_state=:state,
	event_country=:country, event_website=:website, event_tags=:tags, event_image=:image WHERE event_id=:eventid";
	$condition_arr1= array(":mobile",":event_type",":event_occurence", ":title",":organization",":category",":subcategory",":startdate",":enddate",":ip",":description",":conditions",":location",":address",":zip",":city",":state",":country",":website",":tags",":image", ":eventid");
	$condition_arr2= array($event_mobile,$event_place_type,$event_occurence, $event_title,$event_organization,$event_category,$event_sub_category,date ("Y-m-d H:i:s", $time ),date ("Y-m-d H:i:s", $time1 ),$ipaddress,$event_description,$event_term_condition,$event_location,$event_address,$event_zip,$event_city,$event_state,$event_country,$event_website,$event_tag,$event_image, $update_event_id);

	$result=$updateEvent->updateQuery($update_event_sql,$condition_arr1,$condition_arr2);
	if($result > 0) {
		$condition_arr1 = "";
		$condition_arr2 = "";
		$insert_ticket_sql = "UPDATE boovent_ticket_manager SET ticket_name=:name, ticket_type=:type, ticket_class=:class, ticket_price=:price, payment_bearing=:bearing, total_tickets_issued=:issued, total_tickets_remaining=:remaining WHERE event_id=:event_id AND ticket_id=:ticket_id";
		if($no_of_ticket_types > 0 ) {
			for($i=1;$i<=$no_of_ticket_types;$i++) {
				if($i==1) {
				 	$ticket_class = "GOLD";$ticket_id = "TKT-".$update_event_id."-1";
				}else if($i==3) {
				 	$ticket_class = "SILVER";$ticket_id = "TKT-".$update_event_id."-2";  
				}else if($i==3) {
					$ticket_class = "BRONZE";$ticket_id = "TKT-".$update_event_id."-3"; 
				}else if($i==4) {
					$ticket_class = "EXT1";$ticket_id = "TKT-".$update_event_id."-4"; 
				}else if($i==5) {
					$ticket_class = "EXT2";$ticket_id = "TKT-".$update_event_id."-5"; 
				}else if($i==6) {
					$ticket_class = "EXT3";$ticket_id = "TKT-".$update_event_id."-6"; 
				}else if($i==7) {
					$ticket_class = "EXT4";$ticket_id = "TKT-".$update_event_id."-7"; 
				}else if($i==8) {
					$ticket_class = "EXT5";$ticket_id = "TKT-".$update_event_id."-8"; 
				}else if($i==9) {
					$ticket_class = "EXT6";$ticket_id = "TKT-".$update_event_id."-9"; 
				}
				$condition_arr1= array(":name",":type",":class",":price",":bearing",":issued",":remaining", ":event_id", ":ticket_id");//SQL BINDPARAM 
				$condition_arr2= array(${"ticket_name".$i},$event_type,$ticket_class,${"ticket_price".$i},$payment_type,${"ticket_quantity".$i},${"ticket_quantity".$i}, $update_event_id, $ticket_id);
				$update_ticket_manager->updateQuery($insert_ticket_sql,$condition_arr1,$condition_arr2);
			}
			echo "Event Updated Successfully!";
		}
		else {
			$ticket_id = "TKT-".$update_event_id."-0";
			$ticket_class = "GENERAL";
			$condition_arr1= array(":name",":type",":class",":price",":bearing",":issued",":remaining", ":event_id", ":ticket_id");//SQL BINDPARAM 
			$condition_arr2= array($ticket_name1,$event_type,$ticket_class,$ticket_price1,$payment_type,$ticket_quantity1,$ticket_quantity1,  $update_event_id, $ticket_id);//BINDPARAM VALUE
			$result1=$update_ticket_manager->updateQuery($insert_ticket_sql,$condition_arr1,$condition_arr2);
			if($result1 > 0) {
				echo "Event Updated Successfully!";
			}
			else {
				echo "Make Changes For Update this event!";
			}
		}
		
        //----------- DESTROY IMAGE PATH ----------------------//
        if(isset($_SESSION['event_image'])) {
            unset($_SESSION['event_image']);
        }
	}
	else {
		echo "Error: Query Execution Failed !";
	}
}
?>