<?php
require_once 'connect/class.booventpdo.php';
ini_set('display_errors',0);
if(!isset($_SESSION)) {
	session_start();
}
try {
	if (!empty($_GET['eid'])) {
    $event_id=$_GET['eid'];
    $make_event_live="Live";
    
    //==============GETTING EVENT FROM BOOVENT_EVENT TABLE FOR SHOWING DETAILS ==============//
    $condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":event_id", ":make_event_live"); 
    $condition_arr2= array($event_id, $make_event_live);

    $get_event_sql="SELECT *,DATE_FORMAT(event_start_date, '%W %M %e, %r') as formatted_start_date,DATE_FORMAT(event_end_date, '%W %M %e, %r') as formatted_end_date FROM boovent_events WHERE event_id=:event_id AND make_event_live=:make_event_live";
    $EventDetails=new BooventPDO();
    $result=$EventDetails->selectQuery($get_event_sql,$condition_arr1,$condition_arr2); 
    $event_result=$result;
    $result_for_social_media_share=$result;
    unset($EventDetails);

    //============================ GET USER DETAILS ========================================//
    $condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":event_id", ":make_event_live"); 
    $condition_arr2= array($event_id, $make_event_live);
    $user_sql = "SELECT * FROM boovent_user JOIN boovent_events ON boovent_user.user_email=boovent_events.user_email WHERE event_id=:event_id AND make_event_live=:make_event_live ";
    $UserDetails=new BooventPDO();
    $user_result=$UserDetails->selectQuery($user_sql,$condition_arr1,$condition_arr2); 
    $user_profile = $user_result[0]['user_profile_pic'];
    unset($UserDetails);
    if(!empty($user_profile)) {
    	//Image Present
    } else {
    	$user_profile = USER_IMAGE;
    }
    //=================GETTING MINIMUM PRICE OF TICKET FOR SHOWING ON button================//
    $condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":event_id");
    $condition_arr2= array($event_id);
    $TicketPrice=new BooventPDO();
    $get_ticket_sql="SELECT *,MIN(ticket_price) as min_price FROM boovent_ticket_manager WHERE event_id=:event_id";
    $event_price_result=$TicketPrice->selectQuery($get_ticket_sql,$condition_arr1,$condition_arr2);
    $event_min_price= $event_price_result[0]['min_price'];
    $event_tickets_remaining= $event_price_result[0]['total_tickets_remaining'];
    unset($TicketPrice);
    //========GETTING ALL TICKET CUSTOMIZATION TO PRINT TICKET PRICE AND NAME ON MODAL========//
    $condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":event_id"); 
    $condition_arr2= array($event_id);
    $TicketCustomize=new BooventPDO();
    $get_ticket_customization_sql="SELECT * FROM boovent_ticket_manager WHERE event_id=:event_id";
    $ticket_customization_result=$TicketCustomize->selectQuery($get_ticket_customization_sql,$condition_arr1,$condition_arr2);
    $payment_bearing= $ticket_customization_result[0]['payment_bearing'];
    unset($TicketCustomize);
  	}
} catch (Exception $e) {
		
}
// CODE FOR GETTING DATE FOR SHARINT IN SOCIAL MEDIA
foreach ($result_for_social_media_share as $value) {
	$share_image=$value['event_image'];
	$share_event_title=$value['event_title'];
	$share_event_description=strip_tags($value['event_description']);
	$share_event_description=substr($share_event_description, 0,40).'...';
	$share_event_url=BASE_URL."event-details.php?eid=".$value['event_id'];;
}
// $share_image=$event_image_url;
include 'header.php'; // INCLUDING HEADER
?>

<?php foreach ($event_result as $rows) { 
  if(!empty($rows['event_image']) && $rows['event_image']!="Not Given") {
    $event_image_url=$rows['event_image'];
  }else{
    $event_image_url=EVENT_IMAGE;
  } ?>
<!-- <div class="row"> -->
	<!-- SHOW BANER OF EVENTS -->
	<div class="container-fluid">
	    <div class="row event_baner">
	    	<img class="img-responsive" src="<?php echo $event_image_url; ?>">
	    </div>
	</div>
	<!-- EVENT DETAILS AND BOOK -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-3 event_organizer_info">
				<div class="row event_info">
					<div class="event_title">
						<p><?php echo strtoupper($rows['event_title']); ?></p>
					</div>
					<div class="date_time">
		              <p><?php echo $rows['formatted_start_date']." - "; ?>
		              <br/>
		              <?php echo $rows['formatted_end_date']; ?>
		              </p>
		            </div>
					<?php if($rows['event_type'] =="online") { ?>
                    <p class="event_address">
                    <?php echo "This is an online Event"; ?> 
                    </p>
                    <?php } else { ?>
                    <p class="event_address">
                    <?php echo $rows['event_address']." ".$rows['event_location']." ".$rows['event_city']." ".$rows['event_state']." ".$rows['event_country']; ?> 
                    </p>
                    <?php } ?>
					<?php if($event_tickets_remaining > 0) { 
					if($event_min_price > 0) { 
                  	if($rows['event_button'] == "register") {
                  	?>
                  	<p class="top_2pt buy_btn">
                  		<a data-toggle="modal" data-target="#buy_ticket_modal" href="javascript:;" class="btn btn-primary" role="button">Register Now</a>
                  	</p>
                  <?php } else { ?>
                  	<p class="top_2pt buy_btn"><a data-toggle="modal" data-target="#buy_ticket_modal" href="javascript:;" class="btn btn-primary" role="button">Buy at Rs. <?php echo $event_min_price; ?></a></p>
                  <?php } } else { ?>
		             <p class="top_2pt buy_btn"><a data-toggle="modal" data-target="#buy_ticket_modal" href="javascript:;" class="btn btn-primary" role="button">Free Event</a></p>
		            <?php } } else { ?>
		            <p class="top_2pt buy_btn"><a href="javascript:;" class="btn btn-primary" role="button">All Tickets Booked
		            </a>
		            </p>
		            <?php } ?>
		            <div class="share_on_social ">
		              <p class="">Share on : 
		              	<span>
	                      <a onclick="window.open('http://www.facebook.com/share.php?u=<?php echo $share_event_url; ?>&title=<?php echo $share_event_title; ?>&description=<?php echo $share_event_description; ?>','Boovent','width=800,height=400')" href="javascript:;"><i class="fa fa-facebook" aria-hidden="true"></i></a>
	                      <a onclick="window.open('http://twitter.com/home?status=<?php echo $share_event_title; ?>+<?php echo $share_event_url; ?>','Boovent','width=800,height=400')" href="javascript:;"><i class="fa fa-twitter" aria-hidden="true"></i></a>
	                      <a onclick="window.open('https://plus.google.com/share?url=<?php echo $share_event_url; ?>','Boovent','width=800,height=400')" href="javascript:;"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
	                    </span>
		              </p>
		            </div>
				</div>
				<div class="row organizer_info">
					<div class="organizer_head">
						<p>ORGANIZER</p>
					</div>
					<div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-4 col-xs-offset-4 organizer_pic">
						<img class="img-responsive img-circle" src="<?php echo $user_profile; ?>">
					</div>
					<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-6 col-xs-offset-3 organizer_name">
					<?php if(!empty($rows['event_organization']) && $rows['event_organization']!="Not Specified") { ?>
						<p><?php echo $rows['event_organization']; ?></p>
					<?php } else { ?>
						<p><?php echo $_SESSION['user_name']; ?></p>
					<?php } ?>
					</div>
				</div>
			</div><!-- event_organizer_info -->
			<div class="col-md-9 event_description_main_box">
				<div class="row event-navbar">
					<ul class="nav navbar-nav">
			            <li class="hidden">
			                <a href="#page-top"></a>
			            </li>
			            <li>
			                <a class="page-scroll" href="#event_overview">EVENT OVERVIEW</a>
			            </li>
			            <li>
			                <a class="page-scroll" href="#event_ticket">TICKETS</a>
			            </li>
			            <li>
			                <a class="page-scroll" href="#event_venue">VENUE DETAILS</a>
			            </li>
			        </ul>
				</div><!-- row -->
				<div class="event_description">
					<div class="row">
						<div class="col-md-12 col-md-offset-0" id="event_overview">
							<h4>OVERVIEW</h4>
							<div class="event_overview_box">
								<?php echo $rows['event_description']; ?>
								<?php if ($rows['event_website']!='Not Specified') { ?>
									<br>
									<p><b>Please Visit : </b><a target="_BLANK" href="<?php echo $rows['event_website']; ?>"><?php echo $rows['event_website']; ?></a></p>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-md-offset-0" id="event_ticket">
							<h4>TICKETS</h4>
							<div class="event_ticket_box">
								<?php if(!empty($rows['event_conditions'])) { 
									echo $rows['event_conditions']; } 
								else {
									echo "No Conditions for the Event !";
								}?>

								<!-- BUY NOW AND REGISTER BUTTON -->
								<?php if($event_tickets_remaining > 0) { 
								if($event_min_price > 0) { 
			                  	if($rows['event_button'] == "register") {
			                  	?>
			                  	<p class="top_2pt buy_btn">
			                  		<a data-toggle="modal" data-target="#buy_ticket_modal" href="javascript:;" class="btn btn-primary" role="button">Register Now</a>
			                  	</p>
			                  	<?php } else { ?>
			                  		<p class="top_2pt buy_btn"><a data-toggle="modal" data-target="#buy_ticket_modal" href="javascript:;" class="btn btn-primary" role="button">Buy at Rs. <?php echo $event_min_price; ?></a></p>
			                  	<?php } } else { ?>
					             	<p class="top_2pt buy_btn"><a data-toggle="modal" data-target="#buy_ticket_modal" href="javascript:;" class="btn btn-primary" role="button">Free Event</a></p>
					            <?php } } else { ?>
					            <p class="top_2pt buy_btn"><a href="javascript:;" class="btn btn-primary" role="button">All Tickets Booked
					            </a>
					            </p>
					            <?php } ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-md-offset-0" id="event_venue">
							<h4>VENUE</h4>
							<?php if($rows['event_type'] =="online") { ?>
							<div class="event_venue_box">
								<?php echo "This is an online Event."; ?>
							</div>
							<?php } else {?>
							<div class="event_venue_box">
								<?php echo $rows['event_address'].', '.$rows['event_location'].', '. $rows['event_city'].', '. $rows['event_state'].', '. $rows['event_zipcode']; ?>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div><!-- row -->
	</div>
<!-- </div> -->
<?php } ?>
<!-- <br><br> -->

<!-- =========== BOOVENT MODAL DESIGN =============== -->
<div id="buy_ticket_modal" class="modal fade buy_ticket_modal">
    <div class="modal-dialog">
        <div class="modal-content">
        <form action="" method="POST" id="ticket-control">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
                <h4 class="modal-title">Select Your Tickets</h4>
            </div>
            <div class="modal-body">
            	<div class="row">
            		<?php 
            		$i= 1;
            		foreach ($ticket_customization_result as $rows){ ?>
            		<div class="ticket_select_box">
            			<input type="text" name="ticket_id_<?php echo $i; ?>"
            			id="ticket_id_<?php echo $i; ?>"
            			value="<?php echo $rows['ticket_id']; ?>" style="display:none;" />
            			<input type="text" name="ticket_remaining_<?php echo $i; ?>"
            			id="ticket_remaining_<?php echo $i; ?>"
            			value="<?php echo $rows['total_tickets_remaining']; ?>" style="display:none;" />
            			<input type="text" name="ticket_price_<?php echo $i; ?>"
            			id="ticket_price_<?php echo $i; ?>"
            			value="<?php echo $rows['ticket_price']; ?>" style="display:none;" />
		            	<div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1 ticket_box">
	                        <div class="col-md-9 col-xs-12 col-sm-9">
	                        <?php if($rows['ticket_price'] > 0) {?>
	                        <h4>
	                        <span id="ticket_name_<?php echo $i; ?>">
	                        <?php echo $rows['ticket_name']; ?></span>: Rs. 
	                        <span id="ticket_price_<?php echo $i; ?>">
	                        <?php echo $rows['ticket_price']; ?>
	                        </span>
	                        </h4>
	                        <?php } else { ?>
	                        <h4>
	                        <span id="ticket_name_<?php echo $i; ?>">
	                        <?php echo $rows['ticket_name']; ?></span>: 
	                        <span id="ticket_price_<?php echo $i; ?>">Free</span>
	                        </h4>
	                        <?php } ?>
	                        </div>
	                        <?php if($rows['total_tickets_remaining'] > 0) { ?>
	                        <div class="form-group col-md-3 col-xs-12 col-sm-3">
	                            <select id="select_ticket_qty_type_<?php echo $i; ?>" class="form-control select_ticket_qty ticket-control">
	                              <option value="0">QTY.</option>
	                              <option value="1" 
	                              data-attr="<?php echo $rows['ticket_price']*1; ?>">1</option>
	                              <option value="2" 
	                              data-attr="<?php echo $rows['ticket_price']*2; ?>">2</option>
	                              <option value="3" 
	                              data-attr="<?php echo $rows['ticket_price']*3; ?>">3</option>
	                              <option value="4" 
	                              data-attr="<?php echo $rows['ticket_price']*4; ?>">4</option>
	                              <option value="5" 
	                              data-attr="<?php echo $rows['ticket_price']*5; ?>">5</option>
	                              <option value="6" 
	                              data-attr="<?php echo $rows['ticket_price']*6; ?>">6</option>
	                              <option value="7" 
	                              data-attr="<?php echo $rows['ticket_price']*7; ?>">7</option>
	                              <option value="8" 
	                              data-attr="<?php echo $rows['ticket_price']*8; ?>">8</option>
	                              <option value="9" 
	                              data-attr="<?php echo $rows['ticket_price']*9; ?>">9</option>
	                              <option value="10" 
	                              data-attr="<?php echo $rows['ticket_price']*10; ?>">10</option>
	                            </select>
	                        </div>
	                        <?php } else { ?>
	                        <div class="form-group col-md-3 col-xs-12 col-sm-3">
	                        <h4>All Booked</h4>
	                        </div>
	                        <?php } ?>
	                    </div>
		            </div>
		            <?php $i++; } ?>
	            </div>
            </div>
            <div class="modal-footer">
            	<div class="col-md-8 col-xs-12 col-sm-9 text-center">
            		<h4 class="col-md-5 col-xs-12 col-sm-12">MAX QTY: <span id="ticket_total_qty">10</span></h4>
            		<h4 class="col-md-7 col-xs-12 col-sm-12">Total: Rs. <span id="ticket_total_price">0</span></h4>
            	</div>
                <input onclick="Checkout(event,'<?php echo $i-1; ?>');" type="button" class="btn btn-primary col-md-3 col-xs-12 col-sm-4" value="CHECKOUT" />
            </div>
        </form>
        </div>
    </div>
</div><!-- buy_ticket_modal -->

<?php
include 'footer.php'; // INCLUDING FOOTER
// Check For Login 
if (isset($_SESSION['user_email'])) {
	$login_flag=1;
}
else{
	$login_flag=0;
	$_SESSION['not_logged_in'] = 1;
}
?>

<!-- ==================================================
******************** SCRIPTS **************************
=================================================== -->
<!-- Update Script-->
<script type="text/javascript">
var $form = $('#ticket-control');
var $summands = $form.find('.ticket-control'),
    $sumDisplay = $('#ticket_total_price');
$form.delegate('.ticket-control', 'change', function ()
{
    var sum = 0;
    $summands.each(function ()
    {
    	var myValue=$(this).find('option:selected').attr('data-attr');
        //var value = Number($(this).val());
        var value = Number(myValue);
        if (!isNaN(value)) sum += value;
    });
    $sumDisplay.text(sum);
});
</script>
<script type="text/javascript">
var login = "<?php echo $login_flag; ?>";

function Checkout(e,ticket_no) {
e.preventDefault();
e.stopPropagation();
var ticket1,qty1,qty_remaining_1,price1,id1="";
var ticket2,qty2,qty_remaining_2,price2,id2="";
var ticket3,qty3,qty_remaining_3,price3,id3="";
var ticket4,qty4,qty_remaining_4,price4,id4="";
var ticket5,qty5,qty_remaining_5,price5,id5="";
var ticket6,qty6,qty_remaining_6,price6,id6="";
var ticket7,qty7,qty_remaining_7,price7,id7="";
var ticket8,qty8,qty_remaining_8,price8,id8="";
var ticket9,qty9,qty_remaining_9,price9,id9="";
var count = 0;
if(ticket_no == 1 || ticket_no > 1 ) {
ticket1 = $('#ticket_name_1').text();
qty1 = parseInt($('#select_ticket_qty_type_1').val());
qty_remaining_1 = parseInt($('#ticket_remaining_1').val());
if($('#ticket_price_1').val()!="Free") {
price1 = parseInt($('#ticket_price_1').val()); }
else { price1 = parseInt(0); }
id1 = $('#ticket_id_1').val();
count = count + qty1;
}
if(ticket_no == 2 || ticket_no > 2) {
ticket2 = $('#ticket_name_2').text();
qty2 = parseInt($('#select_ticket_qty_type_2').val());
qty_remaining_2 = parseInt($('#ticket_remaining_2').val());
price2 = parseInt($('#ticket_price_2').val());
id2 = $('#ticket_id_2').val();
count = count + qty2;
}
if(ticket_no == 3 || ticket_no > 3) {
ticket3 = $('#ticket_name_3').text();
qty3 = parseInt($('#select_ticket_qty_type_3').val());
qty_remaining_3 = parseInt($('#ticket_remaining_3').val());
price3 = parseInt($('#ticket_price_3').val());
id3 = $('#ticket_id_3').val();
count = count + qty3;
}
if(ticket_no == 4 || ticket_no > 4) {
ticket4 = $('#ticket_name_4').text();
qty4 = parseInt($('#select_ticket_qty_type_4').val());
qty_remaining_4 = parseInt($('#ticket_remaining_4').val());
price4 = parseInt($('#ticket_price_4').val());
id4 = $('#ticket_id_4').val();
count = count + qty4;
}
if(ticket_no == 5 || ticket_no > 5) {
ticket5 = $('#ticket_name_5').text();
qty5 = parseInt($('#select_ticket_qty_type_5').val());
qty_remaining_5 = parseInt($('#ticket_remaining_5').val());
price5 = parseInt($('#ticket_price_5').val());
id5 = $('#ticket_id_5').val();
count = count + qty5;
}
if(ticket_no == 6 || ticket_no > 6) {
ticket6 = $('#ticket_name_6').text();
qty6 = parseInt($('#select_ticket_qty_type_6').val());
qty_remaining_6 = parseInt($('#ticket_remaining_6').val());
price6 = parseInt($('#ticket_price_6').val());
id6 = $('#ticket_id_6').val();
count = count + qty6;
}
if(ticket_no == 7 || ticket_no > 7) {
ticket7 = $('#ticket_name_7').text();
qty7 = parseInt($('#select_ticket_qty_type_7').val());
qty_remaining_7 = parseInt($('#ticket_remaining_7').val());
price7 = parseInt($('#ticket_price_7').val());
id7 = $('#ticket_id_7').val();
count = count + qty7;
}
if(ticket_no == 8 || ticket_no > 8) {
ticket8 = $('#ticket_name_8').text();
qty8 = parseInt($('#select_ticket_qty_type_8').val());
qty_remaining_8 = parseInt($('#ticket_remaining_8').val());
price8 = parseInt($('#ticket_price_8').val());
id8 = $('#ticket_id_8').val();
count = count + qty8;
}
if(ticket_no == 9 ) {
ticket9 = $('#ticket_name_9').text();
qty9 = parseInt($('#select_ticket_qty_type_9').val());
qty_remaining_9 = parseInt($('#ticket_remaining_9').val());
price9 = parseInt($('#ticket_price_9').val());
id9 = $('#ticket_id_9').val();
count = count + qty9;
}

if((ticket_no == 1 || ticket_no > 1 ) && qty_remaining_1 < qty1) {
	// alert("Sorry only " + qty_remaining_1 + " remaining for " + ticket1);
	$('#alert_text').text("Sorry only " + qty_remaining_1 + " remaining for " + ticket1);
	$('#alert-modal').modal('show');
}else if((ticket_no == 2 || ticket_no > 2 ) && qty_remaining_2 < qty2) {
	// alert("Sorry only " + qty_remaining_2 + " remaining for " + ticket2);
	$('#alert_text').text("Sorry only " + qty_remaining_2 + " remaining for " + ticket2);
	$('#alert-modal').modal('show');
}else if(ticket_no == 3 && qty_remaining_3 < qty3) {
	// alert("Sorry only " + qty_remaining_3 + " remaining for " + ticket3);
	$('#alert_text').text("Sorry only " + qty_remaining_3 + " remaining for " + ticket3);
	$('#alert-modal').modal('show');
}else if(ticket_no == 4 && qty_remaining_4 < qty4) {
	// alert("Sorry only " + qty_remaining_3 + " remaining for " + ticket3);
	$('#alert_text').text("Sorry only " + qty_remaining_4 + " remaining for " + ticket4);
	$('#alert-modal').modal('show');
}else if(ticket_no == 5 && qty_remaining_5 < qty5) {
	// alert("Sorry only " + qty_remaining_3 + " remaining for " + ticket3);
	$('#alert_text').text("Sorry only " + qty_remaining_5 + " remaining for " + ticket5);
	$('#alert-modal').modal('show');
}else if(ticket_no == 6 && qty_remaining_6 < qty6) {
	// alert("Sorry only " + qty_remaining_3 + " remaining for " + ticket3);
	$('#alert_text').text("Sorry only " + qty_remaining_6 + " remaining for " + ticket6);
	$('#alert-modal').modal('show');
}else if(ticket_no == 7 && qty_remaining_7 < qty7) {
	// alert("Sorry only " + qty_remaining_3 + " remaining for " + ticket3);
	$('#alert_text').text("Sorry only " + qty_remaining_7 + " remaining for " + ticket7);
	$('#alert-modal').modal('show');
}else if(ticket_no == 8 && qty_remaining_8 < qty8) {
	// alert("Sorry only " + qty_remaining_3 + " remaining for " + ticket3);
	$('#alert_text').text("Sorry only " + qty_remaining_8 + " remaining for " + ticket8);
	$('#alert-modal').modal('show');
}else if(ticket_no == 9 && qty_remaining_9 < qty9) {
	// alert("Sorry only " + qty_remaining_3 + " remaining for " + ticket3);
	$('#alert_text').text("Sorry only " + qty_remaining_9 + " remaining for " + ticket9);
	$('#alert-modal').modal('show');
}
// All pass Condition
else {
//  Check for Login
if (login == 0) {
	$('#login_signup_modal').modal({backdrop: 'static', keyboard: false});
    $('#login_signup_modal').modal('show');
}
else if(count > 10) {
$('#alert_text').text("You can purchase Max 10 Tickets for an Event.");
$('#alert-modal').modal('show');
}
else {
	var total_ticket_price=$('#ticket_total_price').text();
	if (qty1>0 || qty2>0 || qty3>0 || qty4>0 || qty5>0 || qty6>0 || qty7>0 || qty8>0 || qty9>0) {
	var event_id = "<?php echo $event_id; ?>";
	var payment_bearing = "<?php echo $payment_bearing; ?>";
	$.ajax({
      type:'POST',
      url:'utility/handleCheckout.php',
      data:{
      	eventid:event_id,
      	payment_bearing:payment_bearing,
        ticket1:ticket1,
        qty1:qty1,
        price1:price1,
        id1:id1,
        ticket2:ticket2,
        qty2:qty2,
        price2:price2,
        id2:id2,
        ticket3:ticket3,
        qty3:qty3,
        price3:price3,
        id3:id3,
        ticket4:ticket4,
        qty4:qty4,
        price4:price4,
        id4:id4,
        ticket5:ticket5,
        qty5:qty5,
        price5:price5,
        id5:id5,
        ticket6:ticket6,
        qty6:qty6,
        price6:price6,
        id6:id6,
        ticket7:ticket7,
        qty7:qty7,
        price7:price7,
        id7:id7,
        ticket8:ticket8,
        qty8:qty8,
        price8:price8,
        id8:id8,
        ticket9:ticket9,
        qty9:qty9,
        price9:price9,
        id9:id9
      },
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr);
        console.log(ajaxOptions);
        console.log(thrownError);
      },
      beforeSend: function(){
        
      },
      success: function(data) {
        // Success
        window.location.href='checkout.php';
      }
      });
	}else{
		$('#alert_text').text("Please select atleast one ticket.");
		$('#alert-modal').modal('show');
	}
}
}

	
}

</script>
<script type="text/javascript">
$(document).ready(function(){
$("#buy_ticket_modal").modal('show');
// SMOOTH SCROLL ON CLICK LINKSS
(function($) {
    "use strict"; // Start of use strict
	$('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: ($($anchor.attr('href')).offset().top - 50)
        }, 1250, 'easeInOutExpo');
        event.preventDefault();
    });
})(jQuery); // End of use strict
});
</script>
