<?php
require_once '../connect/class.booventpdo.php';
date_default_timezone_set('Asia/Kolkata');
ini_set('display_errors',1);
if(!isset($_SESSION)){
    session_start();
}
if (!isset($_SESSION['user_email'])) {
    $home_url = BASE_URL. 'auth.php';
    header('Location: ' . $home_url);
}
$user_email=$_SESSION['user_email'];
$current_date=date('Y-m-d h:i:s') ;
//----------------------- GET LIVE CREATED EVENT INFORMATION DETAILS ------------------------//
$condition_arr1= "";
$condition_arr2= "";
$condition_arr1= array(":email", ":live",":current_dates"); 
$condition_arr2= array($user_email, "Live",$current_date);
$live_event_details = new BooventPDO;
$user_info_sql = "SELECT *,DATE_FORMAT(event_start_date, '%W %M %e %r') as formatted_start_date,DATE_FORMAT(event_end_date, '%W %M %e %r') as formatted_end_date FROM boovent_events WHERE user_email=:email AND event_end_date> :current_dates AND make_event_live=:live";
$live_events=$live_event_details->selectQuery($user_info_sql,$condition_arr1,$condition_arr2);
$live_size = sizeof($live_events);
unset($live_event_details);
//----------------------- GET NOT LIVE EVENT INFORMATION DETAILS -----------------------------//
$condition_arr1= "";
$condition_arr2= "";
$condition_arr1= array(":email", ":live");
$condition_arr2= array($user_email, "Not Live");
$not_live_event_details = new BooventPDO;
$user_info_sql = "SELECT *,DATE_FORMAT(event_start_date, '%W %M %e %r') as formatted_start_date,DATE_FORMAT(event_end_date, '%W %M %e %r') as formatted_end_date FROM boovent_events WHERE user_email=:email AND make_event_live=:live";
$not_live_events=$not_live_event_details->selectQuery($user_info_sql,$condition_arr1,$condition_arr2);
$not_live_size = sizeof($not_live_events);
unset($not_live_event_details);

// ---------------------- CALCULATION FOR REVENUE, INCOME, ACTIVE EVENT, ATTENDEES ------------ //
$condition_arr1= "";
$condition_arr2= "";
$condition_arr1= array(":email", ":live",":current_dates");
$condition_arr2= array($user_email, "Not Live",$current_date);
$organizer_revenue = new BooventPDO;
$user_info_sql = "SELECT * FROM boovent_events WHERE user_email=:email AND event_end_date= :current_dates AND make_event_live=:live";
$calculate_live_events=$organizer_revenue->selectQuery($user_info_sql,$condition_arr1,$condition_arr2);
unset($organizer_revenue);

include 'header-dashboard.php'; // INCLUDING HEADER
?>

<!-- ==================== TAB MENU ========================= -->
<div class="container-fluid ">
<div class="row">
    <div class="tabbable-line tab_menu">
    	<!-- <div class="touch-scrollable"> -->
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#organizer_event_overview" data-toggle="tab">Overview</a>
			</li>
			<li>
				<a href="#organizer_bank_detail" data-toggle="tab">Bank Details</a>
			</li>
		</ul>
		<!-- </div> -->
		<!-- <div class="container"></div> -->
		<div class="tab-content organizer_account" >
			<!-- ORGANIZER EVENT AND TICKET OVERVIEW TAB -->
			<div class="tab-pane active" id="organizer_event_overview">
				<div class="col-md-12 organizer_event_overviewmain_box">
			        <div class="row" >
			        	<!-- REVENUE BLOCK -->
			        	<div class="col-md-3  col-sm-6 col-xs-6">
							<div class="circle-tile">
								<div class="circle-tile-heading green">
							      <i class="fa fa-money fa-fw fa-3x"></i>
							  	</div>
								<div class="circle-tile-content green">
								  	<div class="circle-tile-description text-faded">
								      Revenue
								  	</div>
								  	<div class="circle-tile-number text-faded" >
								      Rs. <span id="total_revenue">0</span>
								  	</div>
								  	<a href="#" class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></a>
								</div>
							</div>
						</div>
						<!-- NET INCOME BLOCK  -->
						<div class="col-md-3  col-sm-6 col-xs-6">
						  <div class="circle-tile">
						      <!-- <a href="#"> -->
						          <div class="circle-tile-heading red">
						              <i class="fa fa-money fa-fw fa-3x"></i>
						          </div>
						      <!-- </a> -->
						      <div class="circle-tile-content red">
						          <div class="circle-tile-description text-faded">
						              NET INCOME
						          </div>
						          <div class="circle-tile-number text-faded" >
						              Rs. <span id="net_income">0</span>
						          </div>
						          <a href="#" class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></a>
						      </div>
						  </div>
						</div>
						<!-- ACTIVE EVENT BLOCK -->
						<div class="col-md-3  col-sm-6 col-xs-6">
						  <div class="circle-tile">
						      <!-- <a href="#"> -->
						          <div class="circle-tile-heading orange">
						              <i class="fa fa-calendar fa-fw fa-3x"></i>
						          </div>
						      <!-- </a> -->
						      <div class="circle-tile-content orange">
						          <div class="circle-tile-description text-faded">
						              ACTIVE EVENTS
						          </div>
						          <div class="circle-tile-number text-faded">
						             <span id="active_events">0</span>
						          </div>
						          <a href="#" class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></a>
						      </div>
						  </div>
						</div>
						<!-- TOTAL USER BLOCK -->
						<div class="col-md-3  col-sm-6 col-xs-6">
						  <div class="circle-tile">
						      <!-- <a href="#"> -->
						          <div class="circle-tile-heading blue">
						              <i class="fa fa-users fa-fw fa-3x"></i>
						          </div>
						      <!-- </a> -->
						      <div class="circle-tile-content blue">
						          <div class="circle-tile-description text-faded" >TOTAL ATTENDEES</div>
						          <div class="circle-tile-number text-faded" >
						              <span id="total_attendees">0</span>
						          </div>
						          <a href="#" class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></a>
						      </div>
						  </div>
						</div>
					</div>
			    </div><!-- event_main_box -->
			    
			    <div class="col-md-12 ">
				    <div class="tabbable-line tab_menu">
				    	<!-- <div class="touch-scrollable"> -->
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#live-events" data-toggle="tab">Live Events</a>
							</li>
							<li>
								<a href="#inactive-events" data-toggle="tab">Inactive Events</a>
							</li>
						</ul>
						<div class="tab-content">
					    	<!-- LIVE EVENTS -->
					        <div  class="row tab-pane active" id="live-events">
					        	<h3 class="text-center">Currently Live Events</h3><br>
					        	<div id="live_events" class="event_main_box">
					        	<?php if ($live_size > 0) { 
						        foreach ($live_events as $rows) { 
				            	$event_tags= $rows['event_tags']; 
	          					$tags =explode(',', $event_tags); 
	          					//----------------- IMAGE CHECK --------------------//
	          					if(!empty($rows['event_image']) && $rows['event_image']!="Not Given" ) {
	          						$event_image = "../".$rows['event_image'];
	          					} else {
	          						$event_image = "../".EVENT_IMAGE;
	          					}
	          					//-------------------- TICKET QUERY ---------------------//
								$condition_arr1= "";
								$condition_arr2= "";
								$condition_arr1= array(":event_id");
								$condition_arr2= array($rows['event_id']);
								$organizer_ticket = new BooventPDO;
								$ticket_info_sql = "SELECT *,SUM(total_tickets_booked) AS booked,SUM(total_tickets_remaining) AS remain FROM boovent_ticket_manager WHERE event_id=:event_id";
								$ticket_events=$organizer_ticket->selectQuery($ticket_info_sql,$condition_arr1,$condition_arr2);
								$book = $ticket_events[0]['booked'];
								$remain = $ticket_events[0]['remain'];
								unset($organizer_ticket);

			          			?>
						            <div class="col-sm-6 col-md-4 event_box">
						                <div class="thumbnail">
						                  <img class="img-responsive" src="<?php echo $event_image; ?>" alt="Boovent -<?php echo $rows['event_title']; ?> ">
						                  <div class="caption">
						                    <h4><?php echo $rows['event_title']; ?></h4>
						                    <p class="event_time">
						                      <p>
						                      <?php echo $rows['formatted_start_date']." - "; ?>
								              <br/>
								              <?php echo $rows['formatted_end_date']; ?>
								              </p>
						                    </p>
						                    <p class="event_address"><?php echo $rows['event_address']." ".$rows['event_location']." ".$rows['event_city']." ".$rows['event_state']." ".$rows['event_country']; ?></p>
						                    <p>Total Tickets Booked : <span id="ticket_booked">
						                    <?php echo $book; ?></span>
						                    </p>
						                    <p>Total Tickets Remaining : <span id="ticket_remaing"><?php echo $remain; ?></span>
						                    </p>
						                    <p class="top_2pt">
						                    	<a onclick="showTicketPurchaseDetail('<?php echo $rows['event_id']; ?>')" href="javascript:;" class="btn btn-primary" role="button">Detail</a>
						                    	<a target="_BLANK" href="../event-details.php?eid=<?php echo $rows['event_id']; ?>" class="btn btn-primary" role="button">Go to Event</a>
						                    	<input type="hidden" id="event_link" value="<?php echo BASE_URL; ?>event-details.php?eid=<?php echo $rows['event_id']; ?>" />
						                    	<a class="btn btn-primary copy_link_btn" onclick="copyToClipboard('<?php echo BASE_URL; ?>event-details.php?eid=<?php echo $rows['event_id']; ?>')" href="javascript:;" ><i class="fa fa-clone fa-1x" aria-hidden="true"></i></a>
						                    	<!-- <span class="copyied">Link copied..</span> -->
						                    </p>
						                    <p class="event_tag">
						                    	<?php if(!empty($event_tags)) { 
						                    		foreach ($tags as $values) { ?>
								                    <a href="../browse-event.php?tag=<?php echo $values; ?>">#<?php echo $values; ?></a>
								                <?php } } ?>
						                    </p>
						                  </div>
						                </div>
						            </div>
						            <?php } } else { ?>
						            	<div class="text-center">
						            		<h4>No any event yet!</h4>
						            		<a class="btn btn-primary" href="../create-event.php" role="button">Create Event</a>
						            	</div>
						            <?php } ?>
					            </div>
					        </div>
					        <!-- NOT LIVE EVENTS -->
					        <div  class="row tab-pane" id="inactive-events">
					        	<h3 class="text-center">Current Inactive Events</h3><br>
					        	<div id="not_live_events" class="event_main_box">
					        	<?php if ($not_live_size > 0) { 
					        	foreach ($not_live_events as $rows) { 
						        $event_tags= $rows['event_tags']; 
	          					$tags =explode(',', $event_tags); 
	          					//----------------- IMAGE CHECK --------------------//
	          					if(!empty($rows['event_image']) && $rows['event_image']!="Not Given" ) {
	          						$event_image = "../".$rows['event_image'];
	          					} else {
	          						$event_image = "../".EVENT_IMAGE;
	          					}
			          			?>
						            <div class="col-sm-6 col-md-4 event_box">
						                <div class="thumbnail">
						                  <img class="img-responsive" src="<?php echo $event_image; ?>" alt="Boovent - <?php echo $rows['event_title']; ?>">
						                  
						                  <div class="caption">
						                    <h4><?php echo $rows['event_title']; ?></h4>
						                    <p class="event_time">
						                      <p>
						                      <?php echo $rows['formatted_start_date']." - "; ?>
								              <br/>
								              <?php echo $rows['formatted_end_date']; ?>
								              </p>
						                    </p>
						                    <p class="event_address"><?php echo $rows['event_address']." ".$rows['event_location']." ".$rows['event_city']." ".$rows['event_state']." ".$rows['event_country']; ?></p>
						                    <p class="top_2pt">
						                    	<a onclick="showEventDetail('<?php echo $rows['event_id']; ?>')" data-toggle="modal" data-target="#event_detail_modal" href="javascript:void(0)" class="btn btn-primary " role="button">View Details</a>
						                    	<a href="../create-event.php?update=<?php echo $rows['event_id']; ?>" class="btn btn-primary " role="button">Edit</a>
						                    	<a onclick="deleteEvent('<?php echo $rows['event_id']; ?>')"  href="javascript:void(0)" class="btn btn-primary " role="button">Delete</a>
						                    </p>
						                    <p class="event_tag">
						                    	<?php if(!empty($event_tags)) { 
						                    		foreach ($tags as $values) { ?>
								                    <a href="../browse-event.php?tag=<?php echo $values; ?>">#<?php echo $values; ?></a>
								                <?php } } ?>
						                    </p>
						                  </div>
						                </div>
						            </div>
						            <?php }
						            }else{ ?>
						            	<div class="text-center">
						            		<h4>No event yet!</h4>
						            		<a class="btn btn-primary" href="../create-event.php" role="button">Create Event</a>
						            	</div>
						            <?php } ?>
					            </div>
					        </div>
				        </div>
				    </div><!-- event_main_box -->
			    </div><!-- event_main_box -->
			</div>
			
			<!-- ORGANIZER BANK DETAILS TAB -->
			<div class="tab-pane" id="organizer_bank_detail">
				<div class="col-md-6 col-md-offset-3 change_pwd_main_box">
			        <div class="row">
			            <form action="">
			            	<h3>My Bank Details</h3>
                            <div class="form-group top_5pt">
                              <input type="text" id="account_holder_name" name="account_holder_name" class="" required/>
                              <span class="bar"></span>
                              <span class="floating-label">Account Holder Name</span>
                            </div>
                            <div class="form-group top_5pt">
                              <input type="text" id="account_number" name="account_number" class="" required/>
                              <span class="bar"></span>
                              <span class="floating-label">Account Number</span>
                            </div>
                            <div class="form-group top_5pt">
                              <input type="text" id="organizer_bank_name" name="organizer_bank_name" class="" required/>
                              <span class="bar"></span>
                              <span class="floating-label">Bank Name</span>
                            </div>
                            <div class="form-group top_5pt">
                              <input type="text" id="organizer_bank_ifsc_code" name="organizer_bank_ifsc_code" class="" required/>
                              <span class="bar"></span>
                              <span class="floating-label">IFSC Code</span>
                            </div>
                            <div class="form-group top_5pt">
                              <input type="text" id="organizer_bank_account_type" name="organizer_bank_account_type" class="" required/>
                              <span class="bar"></span>
                              <span class="floating-label">Account Type</span>
                            </div>
                        	
                        	<div class="form-group gst_block">
                        	<h4 class="top_5pt">Are you registered under GST ?</h4>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="is_organizer_under_gst" id="under_gst_yes" value="yes">
                                        <span class="box-sign"><i class="fa fa-check" aria-hidden="true"></i></span>
                                        Yes
                                    </label>
                                    <label>
                                        <input type="radio" name="is_organizer_under_gst" id="under_gst_no" value="no">
                                        <span class="box-sign"><i class="fa fa-check" aria-hidden="true"></i></span>
                                        No
                                    </label>
                                </div>
                            </div>
                            <div class="form-group top_5pt gst_input_block">
                              <input type="text" id="organizer_gst_no" name="organizer_gst_no" class="" required/>
                              <span class="bar"></span>
                              <span class="floating-label">GST Number</span>
                            </div>
                            <div class="form-group">
                                <input onclick="updateOrganizerBankDetail()" type="button" class="btn btn-primary" value="Save">
                            </div>
			            </form>
			        </div>
			    </div><!-- event_main_box -->
			</div>
		</div>
	</div>
</div>
</div>
<!-- =========== SHOW EVENT DETAILS ON MODAL THAT IS NOT LIVE  =============== -->
<div id="event_detail_modal" class="modal fade event_detail_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
                <h4 class="modal-title">Event Details</h4>
            </div>
            <div class="modal-body">
            	<div class="row">
            		<div class="col-md-10 col-md-offset-1">
            			<div id="event_details"></div>
            		</div>
	            </div>
            </div>
            <div class="modal-footer">
            	<input type="button" class="btn btn-primary col-md-3 col-xs-12 col-sm-4 pull-right" data-dismiss="modal" value="OK" />
            </div>
        </div>
    </div>
</div><!-- event_detail_modal -->
<!-- =========== SHOW TICKET PURCHASE DETAIL ON MODAL  =============== -->
<div id="ticket_purchase_detail_modal" class="modal fade ticket_purchase_detail_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
                <h4 class="modal-title">Ticket Purchase/Registration Detail</h4>
            </div>
            <div class="modal-body">
            	<div class="row">
            		<div class="col-md-10 col-md-offset-1">
            			<div class="table-responsive">
					        <table class="filter-table-organizer table  table-striped table-hover">
					          <thead class="thead-inverse">
					            <tr>
					              <th>Sl. No.</th>
					              <th>Order Id</th>
					              <th>Email</th>
					              <th>Contact</th>
					              <th>Purchase Date</th>
					              <th>Ticket No.</th>
					              <th>QTY.</th>
					              <th>Ticket Type</th>
					              <th>Paid(INR)</th>
					            </tr>
					          </thead>
					          <tbody class="table-striped" id="ticket_purchase_detail">
					          </tbody>
					        </table>
					    </div> <!--   table-responsive -->
            		</div>
	            </div>
            </div>
            <div class="modal-footer">
            	<input type="button" class="btn btn-primary col-md-3 col-xs-12 col-sm-4 pull-right" data-dismiss="modal" value="OK" />
            </div>
        </div>
    </div>
</div><!-- ticket_purchase_detail_modal -->
<!-- <br><br> -->
<?php
include '../footer.php'; // INCLUDING FOOTER
?>
<!-- ================ JAVA SCRIPTS ================================================== -->
<script type="text/javascript">
$(document).ready(function(){
	// $(".copyied").hide();
	// $(".gst_input_block").hide();
	var is_organizer_under_gst=$('input[name=is_organizer_under_gst]:checked').val();
	var organizer_gst_no=$('#organizer_gst_no').val();
	$("input[name=is_organizer_under_gst]").change(function () {
		var is_organizer_under_gst=$('input[name=is_organizer_under_gst]:checked').val();
        if (is_organizer_under_gst=='yes') {

            $(".gst_input_block").show();
        }
        else {

            $(".gst_input_block").hide();
        }
    })
	setInterval(function(){
		showOrganizerBankDetail();
		showOrganizerRevenueDetails();
	}, 5000);
});
</script>
<!-- ================ FILE UPLOAD SCRIPTS ================= -->
<script type='text/javascript'>
showOrganizerBankDetail();
function showOrganizerBankDetail() {
	var org_bank_detail='bank detail';
	// alert(show_profile_info);
	$.ajax({
		type:"POST",
		url:'../utility/handleUserDashboard.php',
		data:{
        org_bank_detail:org_bank_detail
      	},
		cache:false,
		error: function (xhr, ajaxOptions, thrownError) {
	        console.log(xhr);
	        console.log(ajaxOptions);
	        console.log(thrownError);
	    },
	    beforeSend: function(){
	    },
		success:function(response) {
		// alert(response);
		var result = $.parseJSON(response);//parse JSON
		$.each(result, function(key, value){
		    $.each(value, function(key, value){
		        console.log(key, value);
		        $('#'+key).val(value);

		    });
		});

		var organizer_gst_no=$('#organizer_gst_no').val();
			if (organizer_gst_no!='') {
				$('.gst_block').hide();
				$(".gst_input_block").show();
			}else{
				$('.gst_block').show();
				$(".gst_input_block").hide();
			}
		}
	});
}
function updateOrganizerBankDetail() {
	var account_holder_name=$('#account_holder_name').val();
	var account_number=$('#account_number').val();
	var organizer_bank_name=$('#organizer_bank_name').val();
	var organizer_bank_ifsc_code=$('#organizer_bank_ifsc_code').val();
	var organizer_bank_account_type=$('#organizer_bank_account_type').val();
	
	var is_organizer_under_gst=$('input[name=is_organizer_under_gst]:checked').val();
	var organizer_gst_no=$('#organizer_gst_no').val();
	// alert(is_organizer_under_gst);
	$.ajax({
		type:"POST",
		url:'../utility/handleUserDashboard.php',
		data:{
        account_holder_name:account_holder_name,
        account_number:account_number,
        organizer_bank_name:organizer_bank_name,
        organizer_bank_ifsc_code:organizer_bank_ifsc_code,
        organizer_bank_account_type:organizer_bank_account_type,
        organizer_gst_no:organizer_gst_no
      	},
		cache:false,
		error: function (xhr, ajaxOptions, thrownError) {
	        console.log(xhr);
	        console.log(ajaxOptions);
	        console.log(thrownError);
	    },
	    beforeSend: function(){
	    },
		success:function(response) {
			// alert(data);
			$('#alert-modal').modal('show');
			$('#alert_text').text(response);
	        
		
		}
	});
}

// SHOW EVENT DETAIL THAT IS NOT LIVE
function showEventDetail(event_id){
  var event_id_for_show_detail=event_id;
  // alert(event_id_for_show_detail);
  $.ajax({
    type:'POST',
    url:'../utility/handleUserDashboard.php',
    data:{
      event_id_for_show_detail:event_id_for_show_detail
    },
    error: function (xhr, ajaxOptions, thrownError) {
      console.log(xhr);
      console.log(ajaxOptions);
      console.log(thrownError);
    },
    beforeSend: function(){
        // alert("Sending Data..");
    },
    success: function(data) {
    	// alert(data);
      $('#event_details').text('');
      $('#event_details').append(data); 
    }
  });
}

// SHOW ORGANIZER REVENUE, NET INCOMEM, ACTIVE EVENTS, TOTAL ATTENDEES
showOrganizerRevenueDetails();
function showOrganizerRevenueDetails(){
  var organizer_dashboard_details='organizer_dashboard_details';
  // alert(event_id_for_show_detail);
	$.ajax({
		type:"POST",
		url:'../utility/handleUserDashboard.php',
		data:{
        organizer_dashboard_details:organizer_dashboard_details
      	},
		cache:false,
		error: function (xhr, ajaxOptions, thrownError) {
	        console.log(xhr);
	        console.log(ajaxOptions);
	        console.log(thrownError);
	    },
	    beforeSend: function(){
	    },
		success:function(response) {
			var result = $.parseJSON(response);//parse JSON
			$.each(result, function(key, value){
			    $.each(value, function(key, value){
			        console.log(key, value);
			        $('#'+key).text(value);

			    });
			});

		}
	});
}

// DELETE INCATIVE EVENT
function deleteEvent(event_id){
	var delete_inactive_event=event_id;
	var r = confirm("Are realy want to delete this event!");
	if (r == true) {
		$.ajax({
			type:"POST",
			url:'../utility/handleUserDashboard.php',
			data:{
	        delete_inactive_event:delete_inactive_event
	      	},
			cache:false,
			error: function (xhr, ajaxOptions, thrownError) {
		        console.log(xhr);
		        console.log(ajaxOptions);
		        console.log(thrownError);
		    },
		    beforeSend: function(){
		    },
			success:function(response) {
				data(response);
				window.location.reload();

			}
		});
	} else {
	    // txt = "You pressed Cancel!";
	}
}
// SHOW TICKET PURCHASE DETAILS
function showTicketPurchaseDetail(event_id){
	$('#ticket_purchase_detail_modal').modal('show');
	// alert(event_id);
	var event_id_for_show_ticket_purchase_detail=event_id;
	$.ajax({
		type:"POST",
		url:'../utility/handleUserDashboard.php',
		data:{
        event_id_for_show_ticket_purchase_detail:event_id_for_show_ticket_purchase_detail
      	},
		cache:false,
		error: function (xhr, ajaxOptions, thrownError) {
	        console.log(xhr);
	        console.log(ajaxOptions);
	        console.log(thrownError);
	    },
	    beforeSend: function(){
	    },
		success:function(response) {
			// alert(response);
			$('#ticket_purchase_detail').html(response);

		}
	});
}
// ================== COPY TO CLIPBOARD FUNCTION =====================================================================
$(".copyied").hide();
function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val(element).select();
  document.execCommand("copy");
  $temp.remove();
  // (this).next().find('.copyied').show();
  
  $('#alert-modal').modal('show');
  $('#alert_text').text('Event Link Copied.');
  // $(".copyied").show();
  // $(".copyied").delay("slow").fadeOut();
}
</script>