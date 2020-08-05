<?php
require_once '../connect/class.booventpdo.php';
ini_set('display_errors',0);
if(!isset($_SESSION)){
    session_start();
}
$user_email=$_SESSION['user_email'];
$condition_arr1 = ""; 
$condition_arr2 = "";
$msg="";
//============================= UPDATE USER INFO =============================//

if(isset($_POST['user_name'])) {
	//----------------- SET VARIABLES ------------------------------------//
	$name = $_POST['user_name'];
	$address = $_POST['user_address'];
	$zip = $_POST['user_zip_code'];
	$city = $_POST['user_city'];
	$state = $_POST['user_state'];
	$user_contact_no = $_POST['user_contact_no'];
	// $country = $_POST['user_country'];
	$UserInfo = new BooventPDO;
	$update_user_sql = "UPDATE boovent_user SET user_name = :name ,user_mobile = :mobile, user_address = :address,user_city = :city,user_zipcode = :zip,user_state= :state WHERE user_email = :email";
	$condition_arr1= array(":email", ":name", ":mobile",":address", ":zip", ":city", ":state");
	$condition_arr2= array($user_email, $name, $user_contact_no,$address, $zip, $city, $state);
	$result_count= $UserInfo->updateQuery($update_user_sql,$condition_arr1,$condition_arr2);
	if ($result_count>0) {
		$msg="Profile Updated Successfully!";
	}else{
		$msg="Make Changes for update";
	}
	echo $msg;

}
// ================== SHOW PROFILE INFORMATION ================================================
if (isset($_POST['show_profile_info'])) {
	$userInfo = new BooventPDO;
	$user_info_sql = "SELECT * FROM boovent_user WHERE user_email=:email";
	$condition_arr1= array(":email");
	$condition_arr2= array($user_email);
	$result=$userInfo->selectQuery($user_info_sql, $condition_arr1, $condition_arr2);
	$max_size = sizeof($result);
	$data = array();
    if ($max_size > 0) {
       	foreach ($result as $row) {
       		if ($row['user_zipcode']==0) {
       			$user_zipcode="Not Specified";
       		}else{
       			$user_zipcode=$row['user_zipcode'];
       		}
	      $row_data = array(
	        'user_name' => $row['user_name'],
	        'user_contact_no' => $row['user_mobile'], 
	        'user_organization_name' => $row['organization_name'], 
	        'user_website' => $row['user_website'],
	        'user_address' => $row['user_address'],
	        'user_city' => $row['user_city'],
	        'user_state' => $row['user_state'],
	        'user_zip_code' => $user_zipcode
	      );
	      array_push($data, $row_data);
	    }
	}
 echo json_encode($data);
}

// ================== SHOW PROFILE PIC ====================================================
if (isset($_POST['profile_pic'])) {
	$user_profile_pic = new BooventPDO;
	$user_info_sql = "SELECT * FROM boovent_user WHERE user_email=:email";
	$condition_arr1= array(":email");//SQL BINDPARAM 
	$condition_arr2= array($user_email);//BINDPARAM VALUE
	$result=$user_profile_pic->selectQuery($user_info_sql, $condition_arr1, $condition_arr2);
	$max_size = sizeof($result);
	if ($max_size > 0) {
		echo $result[0]['user_profile_pic'];
	}
}
// ================== CHANGE PASSWORD ================================================
if(isset($_POST['password'])) {
	//----------------- SET VARIABLES ------------------------------------//
	$password = $_POST['password'];

	if(isset($_SESSION['user_email'])){
	    $user_email = $_SESSION['user_email'];
	}else{
		$user_email = $_POST['email'];
	}
	
	if ($password!='') {
		$change_password = new BooventPDO;
		$user_pwd_sql = "UPDATE boovent_user SET user_password = :user_password WHERE user_email = :email";
		$condition_arr1= array(":user_password", ":email");//SQL BINDPARAM 
		$condition_arr2= array($password, $user_email);//BINDPARAM VALUE
		$result=$change_password->updateQuery($user_pwd_sql, $condition_arr1, $condition_arr2);

		if ($result>0) {
			$msg="Password Updated Successfully !";
		}else{
			$msg="Password Updated Successfully !";
		}
	}else{
		$msg="Fields can not be blank.";
	}
	echo $msg;
}

// ================== UPDATE ORGANIZER BANK DETAIL ON ORGANIZER-DASHBOARD INFORMATION ======== //
if(isset($_POST['account_holder_name'])) {
	//----------------- SET VARIABLES ------------------------------------//
	$account_holder_name = $_POST['account_holder_name'];
	$account_number = $_POST['account_number'];
	$organizer_bank_name = $_POST['organizer_bank_name'];
	$organizer_bank_ifsc_code = $_POST['organizer_bank_ifsc_code'];
	$organizer_bank_account_type = $_POST['organizer_bank_account_type'];
	$organizer_gst_no = $_POST['organizer_gst_no'];
	
	$check_bank_detail = new BooventPDO;
	$check_bank_detail_sql = "SELECT * FROM organizer_bank_details WHERE user_email=:user_email";
	$condition_arr1= array(":user_email");//SQL BINDPARAM 
	$condition_arr2= array($user_email);//BINDPARAM VALUE
	$result=$check_bank_detail->selectQuery($check_bank_detail_sql, $condition_arr1, $condition_arr2);
	if (sizeof($result)>0) {
		if ($account_holder_name!='') {
			$org_bank_detail = new BooventPDO;
			$org_bank_detail_sql = "UPDATE organizer_bank_details SET account_holder_name=:account_holder_name, bank_account_number=:bank_account_number, bank_name=:bank_name, ifsc_code=:ifsc_code, account_type=:account_type, registered_gst_no=:registered_gst_no WHERE user_email = :email";
			$condition_arr1= array(":account_holder_name", ":bank_account_number", ":bank_name", ":ifsc_code", ":account_type", ":registered_gst_no", ":email");//SQL BINDPARAM 
			$condition_arr2= array($account_holder_name, $account_number, $organizer_bank_name, $organizer_bank_ifsc_code, $organizer_bank_account_type, $organizer_gst_no, $user_email);//BINDPARAM VALUE
			$result=$org_bank_detail->updateQuery($org_bank_detail_sql, $condition_arr1, $condition_arr2);
			if ($result>0) {
				$msg="Account Detail Saved Successfully !";
			}else{
				$msg="Account Detail Saved Successfully !";
			}
		}else{
			$msg="Fields can not be blank.";
		}
	}else{
		$org_bank_detail = new BooventPDO;
		$org_bank_detail_sql = "INSERT INTO organizer_bank_details(user_email, account_holder_name, bank_account_number, bank_name, ifsc_code, account_type, registered_gst_no) VALUES(:user_email, :account_holder_name, :bank_account_number, :bank_name, :ifsc_code, :account_type, :registered_gst_no)";
		$condition_arr1= array(":user_email", ":account_holder_name", ":bank_account_number", ":bank_name", ":ifsc_code", ":account_type", ":registered_gst_no");//SQL BINDPARAM 
		$condition_arr2= array($user_email, $account_holder_name, $account_number, $organizer_bank_name, $organizer_bank_ifsc_code, $organizer_bank_account_type, $organizer_gst_no);//BINDPARAM VALUE
		$result=$org_bank_detail->insertQuery($org_bank_detail_sql, $condition_arr1, $condition_arr2);
		if ($result>0) {
			$msg="Account Detail Saved Successfully !";
		}else{
			$msg="Account Detail Saved Successfully !";
		}
	}
	unset($org_bank_detail);
	echo $msg;
}

// ================== SHOW ORGANIZER BANK DETAIL ON ORGANIZER-DASHBOARD INFORMATION ============//
if (isset($_POST['org_bank_detail'])) {
	$userInfo = new BooventPDO;
	$user_info_sql = "SELECT * FROM organizer_bank_details WHERE user_email=:email";
	$condition_arr1= array(":email");//SQL BINDPARAM 
	$condition_arr2= array($user_email);//BINDPARAM VALUE
	$result=$userInfo->selectQuery($user_info_sql, $condition_arr1, $condition_arr2);

	$data = array();
    if (sizeof($result)>0) {
        // echo $result->rowCount();
       	foreach ($result as $row) {
       		
	      $row_data = array(
	        'account_holder_name' => $row['account_holder_name'],
	        'account_number' => $row['bank_account_number'], 
	        'organizer_bank_name' => $row['bank_name'], 
	        'organizer_bank_ifsc_code' => $row['ifsc_code'],
	        'organizer_bank_account_type' => $row['account_type'],
	        'organizer_gst_no' => $row['registered_gst_no']
	      );
	      array_push($data, $row_data);
	    }
	}
 unset($userInfo);
 echo json_encode($data);
}

// ================== SHOW EVENTS DETAIL THAT IS NOT LIVE YET FOR ORGANIZER ==================//
if (isset($_POST['event_id_for_show_detail'])) {
	$event_id=$_POST['event_id_for_show_detail'];

	$inactive_event_details = new BooventPDO;
	$user_info_sql = "SELECT * FROM boovent_events WHERE user_email=:email AND event_id=:event_id AND make_event_live=:live";
	$condition_arr1= array(":email", ":event_id", ":live");//SQL BINDPARAM 
	$condition_arr2= array($user_email, $event_id, "Not Live");//BINDPARAM VALUE
	$inactive_events=$inactive_event_details->selectQuery($user_info_sql,$condition_arr1,$condition_arr2);

	foreach ($inactive_events as $rows) {
		echo '<div><h3>Event Title : '.$rows['event_title'].'</h3></div>';
		echo '<div><img class="img-responsive" src="../docs/event_images/'.$rows['event_image'].'"/></div>';
		echo '<div><p><b>Organization Name </b>: '.$rows['event_organization'].'</p></div>';
		echo '<div><p><b>Event Category </b>: '.$rows['event_category'].'</p></div>';
		echo '<div><p><b>Event Sub Category </b>: '.$rows['event_sub_category'].'</p></div>';
		// echo '<div><p><b>Event Created Date </b>: '.$rows['event_create_date'].'</p></div>';
		echo '<div><p><b>Event Start Date </b>: '.$rows['event_start_date'].'</p></div>';
		echo '<div><p><b>Event End Date </b>: '.$rows['event_end_date'].'</p></div>';
		echo '<div><p><b>Event Terms-Conditions </b>: '.$rows['event_conditions'].'</p></div>';
		echo '<div><p><b>Event Location </b>: '.$rows['event_location'].'</p></div>';
		echo '<div><p><b>Event Address </b>: '.$rows['event_address'].'</p></div>';
		echo '<div><p><b>Event Zipcode </b>: '.$rows['event_zipcode'].'</p></div>';
		echo '<div><p><b>Event City </b>: '.$rows['event_city'].'</p></div>';
		echo '<div><p><b>Event Description </b>: '.$rows['event_description'].'</p></div>';
	}
	unset($inactive_event_details);
}

// ================== SHOW ORGANIZER REVENUE, NET INCOMEM, ACTIVE EVENTS, TOTAL ATTENDEES ==== //
if (isset($_POST['organizer_dashboard_details'])) {
	$total_revenue=0;
	$net_income=0;
	$total_attendees=0;
	$active_events=0;
	$current_date=date('Y-m-d') ;
	$condition_arr1 = ""; 
	$condition_arr2 = "";
	$condition_arr1= array(":email");
	$condition_arr2= array($user_email);
	$organizer_dashboard_details = new BooventPDO;
	$organizer_dashboard_details_sql = "SELECT * FROM boovent_ticket_manager WHERE user_email=:email";
	$result=$organizer_dashboard_details->selectQuery($organizer_dashboard_details_sql, $condition_arr1, $condition_arr2);
	$data = array();
	$max_size = sizeof($result);
    if ($max_size > 0) {
        $boovent_cut= BOOVENT_CUT;
       	foreach ($result as $rows) {
       		$ticket_price=$rows['ticket_price'];
       		$total_tickets_booked=$rows['total_tickets_booked'];
       		// CALCULATE TOTAL REVENUE OF ORGANIZER
       		$total_revenue=$total_revenue+($ticket_price*$total_tickets_booked);
       		// CALCULATE TOTAL NET INCOME OF ORGANIZER
       		if($rows['payment_bearing'] == "i_will") {
       			$net_income=$total_revenue-(($total_revenue*$boovent_cut)/100);
       		} else if($rows['payment_bearing'] == "customer_will") {
       			$net_income=$total_revenue;
       		} else if($rows['payment_bearing'] == "will_be_divided_equally"){
       			$net_income=$total_revenue-(($total_revenue*$boovent_cut)*3/1000);
       		}
       		
       		// CALCULATE TOTAL ATTENDEES OF EVENTS OF THE ORGANIZER
       		$total_attendees=$total_attendees+$total_tickets_booked;
		}
		// CALCULATE TOTAL ACTIVE EVENTS OF THE ORGANIZER
			$condition_arr1 = ""; 
			$condition_arr2 = "";
			$condition_arr1= array(":email", ":make_event_live",":event_start_date");
			$condition_arr2= array($user_email, "Live",$current_date);
       		$organizer_active_event = new BooventPDO;
			$organizer_active_event_sql = "SELECT * FROM boovent_events WHERE user_email=:email AND event_start_date >= :event_start_date AND make_event_live=:make_event_live";
			$result=$organizer_active_event->selectQuery($organizer_active_event_sql, $condition_arr1, $condition_arr2);
			$active_events=sizeof($result);
	      $row_data = array(
	        'total_revenue' => $total_revenue,
	        'net_income' => $net_income, 
	        'active_events' => $active_events, 
	        'total_attendees' => $total_attendees
	      );
	      array_push($data, $row_data);
	    
	}
	unset($organizer_active_event);
 echo json_encode($data);
}

// ================== SHOW EVENTS FOR UPDATE IF ANY ERROR FOUND ========================= //
if (isset($_POST['show_for_update_event'])) {
	$update_event=$_POST['show_for_update_event'];
	$show_event = new BooventPDO;
	$show_event_sql = "SELECT * FROM boovent_events WHERE event_id=:event_id";
	$condition_arr1= array(":event_id");//SQL BINDPARAM 
	$condition_arr2= array($update_event);//BINDPARAM VALUE
	$result=$show_event->selectQuery($show_event_sql, $condition_arr1, $condition_arr2);

	$data = array();
    if(sizeof($result)>0) {
        // echo $result->rowCount();
       	foreach ($result as $row) {
       		
	      $row_data = array(
	        'event_title' => $row['event_title'],
	        'event_location' => $row['event_location'], 
	        'event_addres' => $row['event_address'], 
	        'event_city' => $row['event_city'],
	        'event_state' => $row['event_state'],
	        'event_zip' => $row['event_zipcode'],
	        'event_country' => $row['event_country'],
	        'event_organizer_mobile' => $row['organizer_mobile'],
	        'event_organizer_organization_name' => $row['event_organization'],
	        'event_website_url' => $row['event_website'],
	        'event_start_date' => $row['event_start_date'],
	        'event_end_date' => $row['event_end_date'],
	        'editor' => $row['event_description'],
	        'select_event_category' => $row['event_category'],
	        'select_event_sub_category' => $row['event_sub_category'],
	        'event_term_condition' => $row['event_conditions'],
	        'event_tags' => $row['event_tags']
	      );
	      array_push($data, $row_data);
	    }
	}
	unset($show_event);
 echo json_encode($data);
}
// ================== SHOW EVENTS FOR UPDATE IF ANY ERROR FOUND ============================= //
if (isset($_POST['show_ticket_details'])) {
	$update_event=$_POST['show_for_update_ticket'];
	$show_event = new BooventPDO;
	$show_event_sql = "SELECT * FROM boovent_ticket_manager WHERE event_id=:event_id";
	$condition_arr1= array(":event_id");
	$condition_arr2= array($update_event);
	$result=$show_event->selectQuery($show_event_sql, $condition_arr1, $condition_arr2);

	$data = array();
    if(sizeof($result)>0) {
       	foreach ($result as $row) {
       		if ($row['ticket_class']=='SILVER') {
       			$row_data = array(
		        'ticket_name2' => $row['ticket_name'],
		        'ticket_quantity2' => $row['total_tickets_issued'], 
		        'ticket_price2' => $row['ticket_price']
		      );
		      array_push($data, $row_data);
       		}
       		if ($row['ticket_class']=='BRONZE') {
       			$row_data = array(
		        'ticket_name3' => $row['ticket_name'],
		        'ticket_quantity3' => $row['total_tickets_issued'], 
		        'ticket_price3' => $row['ticket_price']
		      );
		      array_push($data, $row_data);
       		}
       		if ($row['ticket_class']=='GOLD') {
       			$row_data = array(
		        'ticket_name' => $row['ticket_name'],
		        'ticket_quantity' => $row['total_tickets_issued'], 
		        'ticket_price' => $row['ticket_price']
		      );
		      array_push($data, $row_data);
       		}
       		if ($row['ticket_class']=='GENERAL') {
       			$row_data = array(
		        'ticket_name' => $row['ticket_name'],
		        'ticket_quantity' => $row['total_tickets_issued'], 
		        'ticket_price' => $row['ticket_price']
		      );
		      array_push($data, $row_data);
       		}
	      
	    }
	}
 echo json_encode($data);
}

// ====================== DELETE INACTIVE EVENT =======================================================================
if (isset($_POST['delete_inactive_event'])) {
	$delete_inactive_event=$_POST['delete_inactive_event'];

	$delete_user = new BooventPDO;
	$delete_user_sql = "DELETE FROM boovent_events WHERE event_id=:event_id";
	$condition_arr1= array(":event_id");//SQL BINDPARAM 
	$condition_arr2= array($delete_inactive_event);//BINDPARAM VALUE
	$delete_result=$delete_user->deleteQuery($delete_user_sql,$condition_arr1,$condition_arr2);

	if ($delete_result>0) {
		$msg="Event deleted permanently!";
	}else{
		$msg="Something wrong!";
	}
echo $msg;
}

// ================= SHOW TICKET PURCHASE DETAIL FOR ORGANIZERS =====================================================
if (isset($_POST['event_id_for_show_ticket_purchase_detail'])) {
	$event_id=$_POST['event_id_for_show_ticket_purchase_detail'];
	$ticket_purchase = new BooventPDO;
	$ticket_purchase_info_sql = "SELECT * FROM boovent_purchase WHERE event_id=:event_id";
	$condition_arr1= array(':event_id');//SQL BINDPARAM 
	$condition_arr2= array($event_id);//BINDPARAM VALUE
	$ticket_purchase_list=$ticket_purchase->selectQuery($ticket_purchase_info_sql,$condition_arr1,$condition_arr2);
	
	$size_ticket_purchase_list=sizeof($ticket_purchase_list);
	if ($size_ticket_purchase_list>0) {
		$i=1; 
		foreach ($ticket_purchase_list as $rows) { 
          $user_email=$rows['user_email'];
          	if ($rows['purchase_contact']!='') {
          		$purchase_contact=$rows['purchase_contact'];
          	}else{
          		$purchase_contact='Not Given';
          	}
            echo'<tr class="">';
            echo  '<td>'.$i.'</td>';
            echo  '<td>'.$rows['order_id'].'</td>';
            echo  '<td>'.$user_email.'</td>';
            echo  '<td>'.$purchase_contact.'</td>';
            echo  '<td>'.$rows['date_of_purchase'].'</td>';
            echo  '<td>'.$rows['purchased_ticket_numbers'].'</td>';
            echo  '<td>'.$rows['purchase_quantity'].'</td>';
            echo  '<td>'.$rows['purchased_ticket_type'].'</td>';
            echo  '<td>'.$rows['customer_price_purchased'].'</td>';
            echo '</tr>';
			$i++;
		}
	}else{
		echo '<tr class=""><td colspan="9"><h3 class="text-center">Registrations/Purchase detail not available</h3><td></tr>';
	}
}
?>