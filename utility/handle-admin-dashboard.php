<?php
require_once '../connect/class.booventpdo.php';
ini_set('display_errors',1);
if(!isset($_SESSION)){
    session_start();
}
// $user_email=$_SESSION['user_email'];
$condition_arr1 = ""; 
$condition_arr2 = "";
$msg="";

// ==================== SHOW BOOVENT ADMIN LIVE STATUS =============================== //
if (isset($_POST['show_live_boovent_status'])) {
	$data = array();

	//--------------------- COUNT ALL ORGANIZERS ----------------------------------//
	$organizer = new BooventPDO;
	$organizer_info_sql = "SELECT * FROM boovent_user WHERE total_event_created>0";
	$organizer_list=$organizer->selectQuery($organizer_info_sql);
	$total_organizers=sizeof($organizer_list);
	unset($organizer);
	//--------------------- COUNT ALL USERS --------------------------------------- //
  	$all_users = new BooventPDO;
	$all_users_info_sql = "SELECT * FROM boovent_user";
	$all_users_list=$all_users->selectQuery($all_users_info_sql);
	$total_all_users=sizeof($all_users_list);
	unset($all_users);
	//------------------------ COUNT ALL LIVE EVENTS -----------------------------------//
	$condition_arr1 = ""; 
    $condition_arr2 = "";
	$condition_arr1= array(":live");
	$condition_arr2= array("Live");
  	$live_events = new BooventPDO;
	$live_events_info_sql = "SELECT * FROM boovent_events WHERE make_event_live=:live";
	$live_events_list=$live_events->selectQuery($live_events_info_sql,$condition_arr1,$condition_arr2);
	$total_live_events=sizeof($live_events_list);
	unset($live_events);
	//-------------------- COUNT ALL NOT LIVE EVENTS PENDING TASKS --------------------------//
	$condition_arr1 = ""; 
    $condition_arr2 = "";
	$condition_arr1= array(":live"); 
	$condition_arr2= array("Not Live");
  	$pending_events = new BooventPDO;
	$pending_events_info_sql = "SELECT * FROM boovent_events WHERE make_event_live=:live";
	
	$pending_events_list=$pending_events->selectQuery($pending_events_info_sql,$condition_arr1,$condition_arr2);
	$total_pending_events=sizeof($pending_events_list);
	$row_data = array(
		'total_organizers' => $total_organizers,
		'total_users' => $total_all_users, 
		'total_events' => $total_live_events, 
		'pending_events' => $total_pending_events
	);
	array_push($data, $row_data);
    echo json_encode($data);
    unset($pending_events);
}

// ==================== SHOW ORGANIZER DETAILS ON ADMIN PANEL =========================== //
if (isset($_POST['show_organizer_details'])) {
	$organizer = new BooventPDO;
	$organizer_info_sql = "SELECT * FROM boovent_user WHERE total_event_created>0";
	$organizer_list=$organizer->selectQuery($organizer_info_sql);
	if (sizeof($organizer_list)>0) {
		$i=1; 
		foreach ($organizer_list as $rows) { 
          $organizer_email=$rows['user_email']; 
          $is_active=$rows['email_activated'];
          if ($is_active==1) {
            $user_status="ACTIVE";
          }else{ $user_status="INACTIVE"; }
            echo'<tr class="">';
            echo  '<td>'.$i.'</td>';
            echo  '<td>'.$rows['user_name'].'</td>';
            echo  '<td>'.$organizer_email.'</td>';
            echo  '<td>'.$rows['user_mobile'].'</td>';
            echo  '<td>'.$rows['join_date'].'</td>';
            echo  '<td>'.$rows['user_address'].'</td>';
            echo  '<td>'.$rows['user_zipcode'].'</td>';
            echo  '<td>'.$rows['user_city'].'</td>';
            echo  '<td>'.$rows['user_state'].'</td>';
            
            echo  '<td><a id="'.$organizer_email.'" onclick="showOrganizerBankDetail(this.id)" class="btn btn-primary btn-xs" href="javascript:;"  data-toggle="modal" data-target="#organizers_bank_detail_modal">SHOW</a></td>';
            echo "<td class='bold'><a id='".$organizer_email."' onclick='deleteUser(this.id)' class='btn btn-primary btn-xs' href='javascript:;'>DELETE</a></td>";
			

            echo  '<td><b>'.$user_status.'</b></td>';
            echo '</tr>';
			$i++;
		}
	}else{
		echo '<h3 class="text-center">Bank Details <br>('.$organizer_email.')</h3>';
		echo '<h3 class="text-center">There is not any user yet!</h3>';
	}
	unset($organizer);
}

// ===================== SHOW ORGANIZER BANK DETAIL IN ADMIN PANEL ON MODAL =============== //
if (isset($_POST['organizer_email_for_bank_detail'])) {
	$organizer_email=$_POST['organizer_email_for_bank_detail'];
	$condition_arr1 = ""; 
    $condition_arr2 = "";
	$condition_arr1= array(":email"); 
	$condition_arr2= array($organizer_email);
	$organizer_bank_details = new BooventPDO;
	$user_info_sql = "SELECT * FROM organizer_bank_details WHERE user_email=:email";
	$organizer_bank_detail_list=$organizer_bank_details->selectQuery($user_info_sql,$condition_arr1,$condition_arr2);

	if (sizeof($organizer_bank_detail_list)>0) {
		foreach ($organizer_bank_detail_list as $rows) {
			echo '<h3 class="text-center">Bank Details<br>('.$organizer_email.')</h3>';
	        
	        echo '<div class="row">';
		        echo '<p class="col-md-6 bold">Account Holder Name:</p>';
		        echo '<p class="col-md-6">'.$rows['account_holder_name'].'</p>';
	        echo '</div>';

	        echo '<div class="row">';
		        echo '<p class="col-md-6 bold">Account Number::</p>';
		        echo '<p class="col-md-6">'.$rows['bank_account_number'].'</p>';
	        echo '</div>';

	        echo '<div class="row">';
		        echo '<p class="col-md-6 bold">Bank Name:</p>';
		        echo '<p class="col-md-6">'.$rows['bank_name'].'</p>';
	        echo '</div>';

	        echo '<div class="row">';
		        echo '<p class="col-md-6 bold">IFSC Code:</p>';
		        echo '<p class="col-md-6">'.$rows['ifsc_code'].'</p>';
	        echo '</div>';

	        echo '<div class="row">';
		        echo '<p class="col-md-6 bold">Account Type:</p>';
		        echo '<p class="col-md-6">'.$rows['account_type'].'</p>';
	        echo '</div>';

	        echo '<div class="row">';
		        echo '<p class="col-md-6 bold">GST Number:</p>';
		        echo '<p class="col-md-6">'.$rows['registered_gst_no'].'</p>';
	        echo '</div>';
		}
	}else{
		echo '<h3 class="text-center">Bank Details <br>('.$organizer_email.')</h3>';
		echo '<h3 class="text-center">This user not saved yet!</h3>';

	}
	unset($organizer_bank_details);
}

// ===================== SHOW ALL USERS DETAILS IN ADMIN PANEL ======================== //
if (isset($_POST['user_details'])) {
	$alluser_details = new BooventPDO;
	$user_info_sql = "SELECT * FROM boovent_user";
	$user_detail_list=$alluser_details->selectQuery($user_info_sql);
	$i=1;
	if (sizeof($user_detail_list)>0) {
		foreach ($user_detail_list as $rows) {
			$is_active=$rows['email_activated'];
              if ($is_active==1) {
                $user_status="ACTIVE";
              }else{ $user_status="INACTIVE"; }
			$user_email=$rows['user_email'];
			echo "<tr>";
				echo "<td>".$i."</td>";
				echo "<td>".$rows['user_name']."</td>";
				echo "<td>".$user_email."</td>";
				echo "<td>".$rows['user_mobile']."</td>";
				echo "<td class='bold'>".$user_status."</td>";
				echo "<td class='bold'><a id='".$user_email."' onclick='deleteUser(this.id)' class='btn btn-primary btn-xs' href='javascript:;'>DELETE</a></td>";
			echo "</tr>";
			$i++;
		}
	}else{
		// echo '<h3 class="text-center">Bank Details <br>('.$organizer_email.')</h3>';
		echo '<h3 class="text-center">There is not any user yet!</h3>';
	}
	unset($alluser_details);
}

// ====================== DELETE USER BY EMAIL ID =================================== //
if (isset($_POST['delete_user'])) {
	$user_email=$_POST['delete_user'];
	$condition_arr1 = ""; 
    $condition_arr2 = "";
	$condition_arr1= array(":user_email"); 
	$condition_arr2= array($user_email);
	$delete_user = new BooventPDO;
	$delete_user_sql = "DELETE FROM boovent_user WHERE user_email=:user_email";
	$delete_result=$delete_user->deleteQuery($delete_user_sql,$condition_arr1,$condition_arr2);
	if ($delete_result>0) {
		$msg="User deleted permanently!";
	}else{
		$msg="Something wrong!";
	}
echo $msg;
unset($delete_user);
}

// ======================= SHOW ALL LIVE EVENTS DETAILS ============================== //
if (isset($_POST['live_event_detail'])) {
	$live_event_detail=$_POST['live_event_detail'];
	$condition_arr1= "";
	$condition_arr2= "";
	$condition_arr1= array(":live");
	$condition_arr2= array("Live");
	$live_events = new BooventPDO;
	$live_events_sql = "SELECT boovent_user.*, boovent_events.* FROM boovent_user JOIN boovent_events ON boovent_user.user_email=boovent_events.user_email AND make_event_live=:live";
	$live_event_list=$live_events->selectQuery($live_events_sql,$condition_arr1,$condition_arr2);
	$qty_sold=0;
	if ($live_event_list>0) {
		$i=1;
		foreach ($live_event_list as $rows) {
			$event_id=$rows['event_id'];
			$boovent_charge=0;
			$total_charge = 0;
			$condition_arr1= "";
			$condition_arr2= "";
			$condition_arr1= array(":event_id");
			$condition_arr2= array($event_id);
			$ticket_manager = new BooventPDO;
			$ticket_manager_sql = "SELECT * FROM boovent_ticket_manager WHERE event_id=:event_id";
			$ticket_purchased_detail=$ticket_manager->selectQuery($ticket_manager_sql,$condition_arr1,$condition_arr2);
			$max_ticket_size = sizeof($ticket_purchased_detail);
			if($max_ticket_size > 0) {
				//$qty_sold=$ticket_purchased_detail[0]['qty'];
				$payment_bearing=$ticket_purchased_detail[0]['payment_bearing'];

				if($payment_bearing == "Not Applicable") {
				//--------------------- EVENT IS FREE -------------------------------------- //
					$boovent_charge = 0;
					$qty_sold = $ticket_purchased_detail[0]['total_tickets_booked'];
				} else {
				//--------------------- EVENT IS PAID -------------------------------------- //
				// INITIALIZE VARIABLES
					$ticket_gold_price = 0;
					$ticket_silver_price = 0;
					$ticket_bronze_price = 0;
					$ticket_gold_qty = 0;
					$ticket_silver_qty = 0;
					$ticket_bronze_qty = 0;
					$total_bronze_price = 0;
					$total_silver_price = 0;
				//----------------------- GET THE TOTAL PAYOUT ----------------------------//
				$condition_arr1= "";
				$condition_arr2= "";
				$condition_arr1= array(":event_id");
				$condition_arr2= array($event_id);
				$ticket_charge = new BooventPDO;
				if($max_ticket_size == 1) {
					$sql = "SELECT * FROM boovent_ticket_manager WHERE ticket_class IN('GOLD') AND event_id = :event_id";
				} else if($max_ticket_size == 2) {
					$sql = "SELECT * FROM boovent_ticket_manager WHERE ticket_class IN('GOLD','SILVER') AND event_id = :event_id";
				} else {
					$sql = "SELECT * FROM boovent_ticket_manager WHERE ticket_class IN('GOLD','SILVER','BRONZE') AND event_id = :event_id";
				}
				$ticket_detail=$ticket_charge->selectQuery($ticket_manager_sql,$condition_arr1,$condition_arr2);
				$max_charge_size = sizeof($ticket_detail);
				if($max_charge_size > 0) {
					if($max_ticket_size == 3) {
						$ticket_bronze_price = $ticket_detail[2]['ticket_price'];
						$ticket_bronze_qty = $ticket_detail[2]['total_tickets_booked'];
						$total_bronze_price = $ticket_bronze_price*$ticket_bronze_qty;
					}
					if($max_ticket_size == 2 || $max_ticket_size == 3) {
						$ticket_silver_price = $ticket_detail[1]['ticket_price'];
						$ticket_silver_qty = $ticket_detail[1]['total_tickets_booked'];
						$total_silver_price = $ticket_silver_price*$ticket_silver_qty;
					} 
					$ticket_gold_price = $ticket_detail[0]['ticket_price'];
					$ticket_gold_qty = $ticket_detail[0]['total_tickets_booked'];
					$total_gold_price = $ticket_gold_price*$ticket_gold_qty;
					$total_charge = $total_gold_price + $total_silver_price +$total_bronze_price;
					$qty_sold = $ticket_gold_qty + $ticket_silver_qty + $ticket_bronze_qty;
				} else {
					//Fail

				}
				if($payment_bearing == "i_will") {
					$boovent_charge = BOOVENT_CUT*$total_charge/100;
				} else if($payment_bearing == "customer_will") {
					$boovent_charge = BOOVENT_CUT*$total_charge/100;
				} else {
					$boovent_charge = BOOVENT_CUT*$total_charge*3/1000;
				}
			 }

			} else {
				$boovent_charge = "Cannot fetch";
				$qty_sold = "Cannot fetch";
			}
			//print_r($ticket_detail);
			echo "<tr>";
				echo "<td>".$i."</td>";
				echo "<td>".$rows['event_create_date']."</td>";
				echo "<td>".$event_id."</td>";
				echo "<td>".$rows['event_title']."</td>";
				echo "<td>".$boovent_charge."</td>";
                echo "<td><a onclick='showTicketPurchaseDetail(\"".$event_id."\")' href='javascript:;' class='btn btn-primary btn-xs' role='button'>Show</a></td>";
                echo "<td><a onclick='deleteThisEvent(\"".$event_id."\")' href='javascript:;' class='btn btn-primary btn-xs' role='button'>Delete</a></td>";
				echo "<td>".$qty_sold."</td>";
				echo "<td>".$rows['user_name']."</td>";
				echo "<td>".$rows['organizer_mobile']."</td>";
				echo "<td>".$rows['user_email']."</td>";
			echo "</tr>";
			$i++;
		}
		unset($ticket_manager);
	} else{
		echo '<h3 class="text-center">There is not any user yet!</h3>';
	}
	unset($live_events);
}

// ======================= SHOW ALL NOT LIVE EVENTS YET DETAILS ========================= //
if (isset($_POST['not_live_event_detail'])) {
	$not_live_event_detail=$_POST['not_live_event_detail'];
	$condition_arr1= "";
	$condition_arr2= "";
	$condition_arr1= array(":live");
	$condition_arr2= array("Not Live");
	$inactive_event_details = new BooventPDO;
	$event_sql = "SELECT boovent_user.*, boovent_events.* FROM boovent_user JOIN boovent_events ON boovent_user.user_email=boovent_events.user_email AND make_event_live=:live";
	$inactive_events=$inactive_event_details->selectQuery($event_sql,$condition_arr1,$condition_arr2);
	if (sizeof($inactive_events)>0) {
		foreach ($inactive_events as $rows) {
			$event_id=$rows['event_id'];
			if (!empty($rows['event_image']) AND $rows['event_image']!='Not Given') {
				$event_image='../'.$rows['event_image'];
			}else{
				$event_image='../'.EVENT_IMAGE;
			}
			echo '<div class="col-sm-6 col-md-3 event_box_admin ">';
            echo  '<table class="filter-table-all-pending-events ">';
			echo '<tbody><tr><td class="thumbnail" >';
				echo '<img class="img-responsive" src="'.$event_image.'" alt="Boovent - '.$rows['event_title'].'">';
                echo '<div class="caption">';
                echo   '<h4>'.strtoupper($rows['event_title']).'</h4>';
                echo   '<p class="event_time">'.$rows['event_start_date'].'</p>';
                echo   '<p class="event_address">'.$rows['event_address'].'</p>';
                echo   '<p>Organizer Name : <span id="organizer_name">'.$rows['user_name'].'</span></p>';
                echo   '<p>Email : <span id="organizer_email">'.$rows['user_email'].'</span></p>';
                echo   '<div class="top_2pt">';
                echo    '<a id="'.$event_id.'" onclick="showEventDetail(this.id)" href="javascript:;" data-toggle="modal" data-target="#organizers_event_detail_modal" class="btn btn-primary" role="button">Show</a>';
                echo    '<a id="'.$event_id.'" onclick="aproveEvent(this.id)" href="javascript:;" class="btn btn-primary" role="button">Approve</a>';
                echo    "<a onclick='deleteThisEvent(\"".$event_id."\")' href='javascript:;' class='btn btn-primary' role='button'>Delete</a>";
                echo    "<a target='_BLANK' href='../create-event.php?update=".$event_id."' class='btn btn-primary' role='button'>Edit</a>";
                echo   '</div>';
                // echo   '<p class="event_tag"><a href="#tag"></p>';
                echo '</div>';
			echo "</td></tr></tbody>";
			echo '</table>';
			echo '</div>';
		}
	}else{
		echo '<h3 class="text-center">Not pending task now!</h3>';
	}
	unset($inactive_event_details);
}

// ======================= APROVE AND MAKE EVENT LIVE ================================ //
if (isset($_POST['update_event_id'])) {
	$update_event_id=$_POST['update_event_id'];
	$condition_arr1= "";
	$condition_arr2= "";
	$condition_arr1= array(":live", "event_id"); 
	$condition_arr2= array("Live", $update_event_id);
	$make_event_live = new BooventPDO;
	$make_event_live_sql = "UPDATE boovent_events SET make_event_live=:live WHERE event_id=:event_id";
	$aprove=$make_event_live->updateQuery($make_event_live_sql,$condition_arr1,$condition_arr2);
	if ($aprove>0) {
		$msg="This event is successfuly live!";
	}
	echo $msg ;
	unset($make_event_live);
}

// ================== SHOW EVENTS DETAIL THAT IS NOT LIVE YET FOR ADMIN ON MODAL ========= //
if (isset($_POST['event_id_for_show_detail'])) {
	$event_id=$_POST['event_id_for_show_detail'];

	$inactive_event_details = new BooventPDO;
	$user_info_sql = "SELECT * FROM boovent_events WHERE event_id=:event_id AND make_event_live=:live";
	$condition_arr1= "";
	$condition_arr2= "";
	$condition_arr1= array(":event_id", ":live");
	$condition_arr2= array($event_id, "Not Live");
	$inactive_events=$inactive_event_details->selectQuery($user_info_sql,$condition_arr1,$condition_arr2);

	foreach ($inactive_events as $rows) {
		$condition_arr1= "";
	    $condition_arr2= "";
		$condition_arr1= array(":event_id");
		$condition_arr2= array($event_id);
		$inactive_ticket = new BooventPDO;
		$ticket_sql = "SELECT * FROM boovent_ticket_manager WHERE event_id=:event_id";
		$inactive_ticket=$inactive_ticket->selectQuery($ticket_sql,$condition_arr1,$condition_arr2);

		if (!empty($rows['event_image']) AND $rows['event_image']!='Not Given') {
			$event_image='../'.$rows['event_image'];
		}else{
			$event_image='../'.EVENT_IMAGE;
		}
		echo '<div><h3>Event Title : '.$rows['event_title'].'</h3></div>';
		echo '<div><img class="img-responsive" src="'.$event_image.'" alt="Boovent - '.$rows['event_title'].'"/></div>';
		echo '<div><p><b>Organization Name </b>: '.$rows['event_organization'].'</p></div>';
		echo '<div><p><b>Organizer Contact </b>: '.$rows['organizer_mobile'].'</p></div>';
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
		foreach ($inactive_ticket as $value) {
            echo   '<p>Ticket Name : '.$value["ticket_name"].' : <span id="ticket_qty"> QTY : '.$value["total_tickets_issued"].'</span> <span id="ticket_price"> Price : '.$value["ticket_price"].'</span></p>';
        }

		echo '<div><p><b>Event Description </b>: '.$rows['event_description'].'</p></div>';
	}
	unset($inactive_ticket);
}

// ================== SHOW EVENT PURCHASE OR REGISTERATION DETAIL FOR ADMIN ON MODAL ========= //
if (isset($_POST['event_id_for_show_purchase_detail'])) {
	$event_id=$_POST['event_id_for_show_purchase_detail'];

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

// ====================== DELETE ANY EVENT =======================================================================
if (isset($_POST['delete_this_event'])) {
	$delete_this_event=$_POST['delete_this_event'];

	$delete_user = new BooventPDO;
	$delete_user_sql = "DELETE FROM boovent_events WHERE event_id=:event_id";
	$condition_arr1= array(":event_id");//SQL BINDPARAM 
	$condition_arr2= array($delete_this_event);//BINDPARAM VALUE
	$delete_result=$delete_user->deleteQuery($delete_user_sql,$condition_arr1,$condition_arr2);

	if ($delete_result>0) {
		$msg="Event deleted permanently!";
	}else{
		$msg="Something wrong!";
	}
echo $msg;
}
?>