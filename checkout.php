<?php
ini_set('display_errors',1);
require_once 'connect/class.booventpdo.php';
if(!isset($_SESSION))
{
    session_start();
}
if (!isset($_SESSION['user_email'])) {
    $home_url = BASE_URL. 'auth.php';
    header('Location: ' . $home_url);
}
// elseif (!isset($_SESSION["eventid"])) {
//     $home_url =BASE_URL;
//     header('Location: ' . $home_url);
// }
include 'header.php'; // INCLUDING HEADER

//------------------------ RETRIEVE THE EVENT INFORMATION -------------------------------//
    $condition_arr1= "";
    $condition_arr2= "";
    $condition_arr1 = array(":event_id", ":make_event_live");
    $condition_arr2 = array($_SESSION["event"]["eventid"], "Live");
    $displayEvent=new BooventPDO();
    $get_event_sql = "SELECT *,DATE_FORMAT(event_start_date, '%W %M %e %r') as formatted_start_date,DATE_FORMAT(event_end_date, '%W %M %e %r') as formatted_end_date FROM boovent_events WHERE event_id = :event_id AND make_event_live=:make_event_live";
    $event_result=$displayEvent->selectQuery($get_event_sql,$condition_arr1,$condition_arr2);
    $event_condition = $event_result[0]['event_conditions'];
    $max_size = sizeof($event_result);
    if($max_size > 0) {
      $event_checkout_result=$event_result;
    } else {
      $error = "<p><center><h1>Could Not Display Event Information</h1></center></p>";
    }
    unset($displayEvent);
//------------------------- RETRIEVE USER INFORMATION ------------------------------------//
    $condition_arr1= "";
    $condition_arr2= "";
    $condition_arr1 = array(":email");
    $condition_arr2 = array($_SESSION["user_email"]);
    $UserEvent=new BooventPDO();
    $get_user_sql = "SELECT * FROM boovent_user WHERE user_email = :email";
    $user_result=$UserEvent->selectQuery($get_user_sql,$condition_arr1,$condition_arr2);
    $user_mobile = $user_result[0]['user_mobile'];
    $max_size = sizeof($event_result);
    if($max_size > 0) {
      $user_checkout_result=$user_result;
    } else {
      $error = "<p><center><h1>Could Not Display Event Information</h1></center></p>";
    }
    unset($UserEvent);
    //------------------------- RETRIEVE TICKET INFORMATION ------------------------------------//
    $condition_arr1= "";
    $condition_arr2= "";
    $condition_arr1 = array(":event_id");
    $condition_arr2 = array($_SESSION["event"]["eventid"]);
    $TicketEvent=new BooventPDO();
    $get_ticket_sql = "SELECT * FROM boovent_ticket_manager WHERE event_id = :event_id";
    $ticket_result=$TicketEvent->selectQuery($get_ticket_sql,$condition_arr1,$condition_arr2);
    $event_type = $ticket_result[0]['ticket_type'];
    unset($TicketEvent);
    //------------------------- CHECK TICKET BUY STATUS --------------------------------------//
    $ticket1=$price1=$qty1=$ticketid1=$ticket2=$price2=$qty2=$ticketid2=$ticket3=$price3=$qty3=$ticketid3=$ticket4=$price4=$qty4=$ticketid4=$ticket5=$price5=$qty5=$ticketid5=$ticket6=$price6=$qty6=$ticketid6=$ticket7=$price7=$qty7=$ticketid7=$ticket8=$price8=$qty8=$ticketid8=$ticket9=$price9=$qty9=$ticketid9 = '';
    if(isset($_SESSION['event']['qty1'])) {
        $ticket1 = $_SESSION['event']['ticket1'];
        $price1 = $_SESSION['event']['price1'];
        $qty1 = $_SESSION['event']['qty1'];
        $ticketid1 = $_SESSION['event']['id1'];
    }
    if(isset($_SESSION['event']['qty2'])) {
        $ticket2 = $_SESSION['event']['ticket2'];
        $price2 = $_SESSION['event']['price2'];
        $qty2 = $_SESSION['event']['qty2'];
        $ticketid2 = $_SESSION['event']['id2'];
    }
    if(isset($_SESSION['event']['qty3'])) {
        $ticket3 = $_SESSION['event']['ticket3'];
        $price3 = $_SESSION['event']['price3'];
        $qty3 = $_SESSION['event']['qty3'];
        $ticketid3 = $_SESSION['event']['id3'];
    }
    if(isset($_SESSION['event']['qty4'])) {
        $ticket3 = $_SESSION['event']['ticket4'];
        $price3 = $_SESSION['event']['price4'];
        $qty3 = $_SESSION['event']['qty4'];
        $ticketid3 = $_SESSION['event']['id4'];
    }
    if(isset($_SESSION['event']['qty5'])) {
        $ticket3 = $_SESSION['event']['ticket5'];
        $price3 = $_SESSION['event']['price5'];
        $qty3 = $_SESSION['event']['qty5'];
        $ticketid3 = $_SESSION['event']['id5'];
    }
    if(isset($_SESSION['event']['qty6'])) {
        $ticket3 = $_SESSION['event']['ticket6'];
        $price3 = $_SESSION['event']['price6'];
        $qty3 = $_SESSION['event']['qty6'];
        $ticketid3 = $_SESSION['event']['id6'];
    }
    if(isset($_SESSION['event']['qty7'])) {
        $ticket3 = $_SESSION['event']['ticket7'];
        $price3 = $_SESSION['event']['price7'];
        $qty3 = $_SESSION['event']['qty7'];
        $ticketid3 = $_SESSION['event']['id7'];
    }
    if(isset($_SESSION['event']['qty8'])) {
        $ticket3 = $_SESSION['event']['ticket8'];
        $price3 = $_SESSION['event']['price8'];
        $qty3 = $_SESSION['event']['qty8'];
        $ticketid3 = $_SESSION['event']['id8'];
    }
    if(isset($_SESSION['event']['qty9'])) {
        $ticket3 = $_SESSION['event']['ticket9'];
        $price3 = $_SESSION['event']['price9'];
        $qty3 = $_SESSION['event']['qty9'];
        $ticketid3 = $_SESSION['event']['id9'];
    }
// print_r($_SESSION);
?>
<div class="container">
    <input type="text" name="ticket1" value="<?php echo $_SESSION['event']['ticket1']; ?>" 
    id="ticket1" style="display: none;" />
    <input type="text" name="price1" value="<?php echo $_SESSION['event']['price1']; ?>" 
    id="price1" style="display: none;" />
    <input type="text" name="qty1" value="<?php echo $_SESSION['event']['qty1']; ?>" 
    id="qty1" style="display: none;" />
    <input type="text" name="ticketid1" value="<?php echo $_SESSION['event']['id1']; ?>" 
    id="ticketid1" style="display: none;" />

    <input type="text" name="ticket2" value="<?php echo $_SESSION['event']['ticket2']; ?>" 
    id="ticket2" style="display: none;" />
    <input type="text" name="price2" value="<?php echo $_SESSION['event']['price2']; ?>" 
    id="price2" style="display: none;" />
    <input type="text" name="qty2" value="<?php echo $_SESSION['event']['qty2']; ?>" 
    id="qty2" style="display: none;" />
    <input type="text" name="ticketid2" value="<?php echo $_SESSION['event']['id2']; ?>" 
    id="ticketid2" style="display: none;" />

    <input type="text" name="ticket3" value="<?php echo $_SESSION['event']['ticket3']; ?>" 
    id="ticket3" style="display: none;" />
    <input type="text" name="price3" value="<?php echo $_SESSION['event']['price3']; ?>" 
    id="price3" style="display: none;" />
    <input type="text" name="qty3" value="<?php echo $_SESSION['event']['qty3']; ?>" 
    id="qty3" style="display: none;" />
    <input type="text" name="ticketid3" value="<?php echo $_SESSION['event']['id3']; ?>" 
    id="ticketid3" style="display: none;" />

     <input type="text" name="ticket4" value="<?php echo $_SESSION['event']['ticket4']; ?>" 
    id="ticket4" style="display: none;" />
    <input type="text" name="price4" value="<?php echo $_SESSION['event']['price4']; ?>" 
    id="price4" style="display: none;" />
    <input type="text" name="qty4" value="<?php echo $_SESSION['event']['qty4']; ?>" 
    id="qty4" style="display: none;" />
    <input type="text" name="ticketid4" value="<?php echo $_SESSION['event']['id4']; ?>" 
    id="ticketid4" style="display: none;" />

     <input type="text" name="ticket5" value="<?php echo $_SESSION['event']['ticket5']; ?>" 
    id="ticket5" style="display: none;" />
    <input type="text" name="price5" value="<?php echo $_SESSION['event']['price5']; ?>" 
    id="price5" style="display: none;" />
    <input type="text" name="qty5" value="<?php echo $_SESSION['event']['qty5']; ?>" 
    id="qty5" style="display: none;" />
    <input type="text" name="ticketid5" value="<?php echo $_SESSION['event']['id5']; ?>" 
    id="ticketid5" style="display: none;" />

     <input type="text" name="ticket6" value="<?php echo $_SESSION['event']['ticket6']; ?>" 
    id="ticket6" style="display: none;" />
    <input type="text" name="price6" value="<?php echo $_SESSION['event']['price6']; ?>" 
    id="price6" style="display: none;" />
    <input type="text" name="qty6" value="<?php echo $_SESSION['event']['qty6']; ?>" 
    id="qty6" style="display: none;" />
    <input type="text" name="ticketid6" value="<?php echo $_SESSION['event']['id6']; ?>" 
    id="ticketid6" style="display: none;" />

     <input type="text" name="ticket7" value="<?php echo $_SESSION['event']['ticket7']; ?>" 
    id="ticket7" style="display: none;" />
    <input type="text" name="price7" value="<?php echo $_SESSION['event']['price7']; ?>" 
    id="price7" style="display: none;" />
    <input type="text" name="qty7" value="<?php echo $_SESSION['event']['qty7']; ?>" 
    id="qty7" style="display: none;" />
    <input type="text" name="ticketid7" value="<?php echo $_SESSION['event']['id7']; ?>" 
    id="ticketid7" style="display: none;" />

     <input type="text" name="ticket8" value="<?php echo $_SESSION['event']['ticket8']; ?>" 
    id="ticket8" style="display: none;" />
    <input type="text" name="price8" value="<?php echo $_SESSION['event']['price8']; ?>" 
    id="price8" style="display: none;" />
    <input type="text" name="qty8" value="<?php echo $_SESSION['event']['qty8']; ?>" 
    id="qty8" style="display: none;" />
    <input type="text" name="ticketid8" value="<?php echo $_SESSION['event']['id8']; ?>" 
    id="ticketid8" style="display: none;" />

     <input type="text" name="ticket9" value="<?php echo $_SESSION['event']['ticket9']; ?>" 
    id="ticket9" style="display: none;" />
    <input type="text" name="price9" value="<?php echo $_SESSION['event']['price9']; ?>" 
    id="price9" style="display: none;" />
    <input type="text" name="qty9" value="<?php echo $_SESSION['event']['qty9']; ?>" 
    id="qty9" style="display: none;" />
    <input type="text" name="ticketid9" value="<?php echo $_SESSION['event']['id9']; ?>" 
    id="ticketid9" style="display: none;" />
	<div class="row">
    	<div class="col-md-12 page_heading">
    		<h3> COMPLETE YOUR ORDER </h3>
    	</div>
    </div>
	<div class="row">
        <div class="wizard">
            <div class="wizard-inner">
                <div class="connecting-line col-md-8 col-md-offset-2"></div>
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Event Information">
                            <span class="round-tab">
                                <i class="fa fa-info" aria-hidden="true"></i>
                            </span>
                        </a>
                    </li>
                    <li role="presentation" class="disabled">
                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Personal Information">
                            <span class="round-tab">
                                <i class="fa fa-address-book-o" aria-hidden="true"></i>
                            </span>
                        </a>
                    </li>
                    <!-- <li role="presentation" class="disabled">
                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
                            <span class="round-tab">
                                <i class="fa fa-user-secret" aria-hidden="true"></i>
                            </span>
                        </a>
                    </li> -->
                    <li role="presentation" class="disabled">
                        <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Checkout">
                            <span class="round-tab">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-md-12 tab-content checkout_box">
                <div class="tab-pane active" role="tabpanel" id="step1">
                    <h3>Event Information</h3>
                    <!-- <p>This is step 1</p> -->
                    <div class="row">
                    <?php if(!empty($event_checkout_result)) {
                    foreach ($event_checkout_result as $rows){ 
                        $link_for_detail=BASE_URL."event-details.php?eid=".$rows['event_id'];
                        $start_date= $rows['event_start_date'];
                        $end_date= $rows['event_end_date'];
                        $start_date=date_create($start_date);
                        $start_date= date_format($start_date,"Ymd H:i:s");
                        $start_date=explode(" ", $start_date);

                        $start_time=end($start_date);
                        $start_date=$start_date[0];
                        $start_time= strtotime($start_time) - strtotime('TODAY');

                        $end_date=date_create($end_date);
                        $end_date= date_format($end_date,"Ymd H:i:s");
                        $end_date=explode(" ", $end_date);
                        $end_time=end($end_date);
                        $end_date=$end_date[0];
                        
                        $end_time= strtotime($end_time) - strtotime('TODAY');
                        for ($i=0; $i <8 ; $i++) { 
                            if (strlen($start_time)==6) {
                                break;
                            }else{
                                $start_time='0'.$start_time;
                            }
                            if (strlen($end_time)==6) {
                                break;
                            }else{
                                $end_time='0'.$end_time;
                            }
                        }
                        $pass_date_to_google_cal=$start_date.'T'.$start_time.'Z/'.$end_date.'T'.$end_time.'Z';
                        if(!empty($rows['event_image']) && $rows['event_image']!="Not Given") {
                            $event_image_url=$rows['event_image'];
                        }else{
                            $event_image_url=EVENT_IMAGE;
                        } ?>
				    	<div class="col-md-4 ticket_image">
                            <img class="img-responsive" src="<?php echo $event_image_url; ?>">
                        </div>
						<div class="col-md-4 ticket_detail">
							<div class="event_title">
								<p><?php echo $rows['event_title']; ?></p>
							</div>
				            <div class="date_time">
				              <p><?php echo $rows['formatted_start_date']."-".
                              $rows['formatted_end_date']; ?></p>
				            </div>
							<div class="event_address">
								<p><?php echo $rows['event_address']." ".$rows['event_location']." ".$rows['event_city']." ".$rows['event_state']." ".$rows['event_country']; ?></p>
							</div>
							<div class="add_event_to_calender">
								<a target="_BLANK" href="https://calendar.google.com/calendar/render?action=TEMPLATE&text=<?php echo $rows['event_title']; ?>&dates=<?php echo $pass_date_to_google_cal; ?>&details=For+details,+link+here:+<?php echo $link_for_detail; ?>&location=<?php echo $rows['event_location']; ?>&pli=1&t=AKUaPmZXscxU7cNp2uRoAtwZEHTU7CplQtxX2MZHARIAw964Hb-NNjQASM3AJ6FBQgEWn_3ccTYqyESSJ6L6mXqgDbGouSarNg%3D%3D&sf=true&output=xml#eventpage_6"><i class="fa fa-calendar" aria-hidden="true"></i> Add event to my google calender</a>
							</div>
						</div>
						<div class="col-md-4 ticket_price_box">
							<h4>SUMMARY</h4>
                            <div class="row">
                                <div class="col-md-6"><span>Ticket Type: <b><?php echo strtoupper($event_type); ?></b></span></div>
                            </div>
                            <div class="ticket_price_detail">
                            <?php 
                            //---------------- CALCULATE TICKET QUANTITY ---------------------//
                            $quantity = 0;
                            $sum = 0;
                            $total = 0;
                            if(isset($_SESSION['event']['qty1'])) {
                                $quantity = $quantity + $_SESSION['event']['qty1'];
                                $sum = $sum + $_SESSION['event']['price1']*$_SESSION['event']['qty1'];
                            }
                            if(isset($_SESSION['event']['qty2'])) {
                                $quantity = $quantity + $_SESSION['event']['qty2'];
                                $sum = $sum + $_SESSION['event']['price2']*$_SESSION['event']['qty2'];
                            }
                            if(isset($_SESSION['event']['qty3'])) {
                                $quantity = $quantity + $_SESSION['event']['qty3'];
                                $sum = $sum + $_SESSION['event']['price3']*$_SESSION['event']['qty3'];
                            }
                            if(isset($_SESSION['event']['qty4'])) {
                                $quantity = $quantity + $_SESSION['event']['qty4'];
                                $sum = $sum + $_SESSION['event']['price4']*$_SESSION['event']['qty4'];
                            }
                            if(isset($_SESSION['event']['qty5'])) {
                                $quantity = $quantity + $_SESSION['event']['qty5'];
                                $sum = $sum + $_SESSION['event']['price5']*$_SESSION['event']['qty5'];
                            }
                            if(isset($_SESSION['event']['qty6'])) {
                                $quantity = $quantity + $_SESSION['event']['qty6'];
                                $sum = $sum + $_SESSION['event']['price6']*$_SESSION['event']['qty6'];
                            }
                            if(isset($_SESSION['event']['qty7'])) {
                                $quantity = $quantity + $_SESSION['event']['qty7'];
                                $sum = $sum + $_SESSION['event']['price7']*$_SESSION['event']['qty7'];
                            }
                            if(isset($_SESSION['event']['qty8'])) {
                                $quantity = $quantity + $_SESSION['event']['qty8'];
                                $sum = $sum + $_SESSION['event']['price8']*$_SESSION['event']['qty8'];
                            }
                            if(isset($_SESSION['event']['qty9'])) {
                                $quantity = $quantity + $_SESSION['event']['qty9'];
                                $sum = $sum + $_SESSION['event']['price9']*$_SESSION['event']['qty9'];
                            }
                            ?>
                                <p><span>Price of <b><?php echo $quantity; ?></b> Tickets: </span><span class="pull-right">Rs.<b><?php echo $sum; ?></b></span></p>
                                <?php //================= ORGANIZER PAY =====================// ?>
                                <?php if($_SESSION['event']['payment_bearing'] == "i_will") { ?>
                                <h4><span>Order Total: </span><span class="pull-right">Rs.
                                <b><?php echo $sum;$total = $sum; ?></b></span>
                                </h4>
                                <?php //================== CUSTOMER PAY =====================// ?>
                                <?php } else if($_SESSION['event']['payment_bearing'] == "customer_will") { ?>
                                <p class="bottom_border"><span>Boovent Service & payment gateway charge: </span><span class="pull-right ">Rs. <b><?php echo $sum*BOOVENT_CUT/100; ?></b></span></p>
                                <h4><span>Order Total: </span><span class="pull-right">Rs.
                                <b><?php echo $sum + $sum*BOOVENT_CUT/100;$total = $sum + $sum*BOOVENT_CUT/100; ?></b>
                                </span></h4>
                                <?php //================= EQUAL PAY =====================// ?>
                                <?php } else if($_SESSION['event']['payment_bearing'] == "will_be_divided_equally") { ?>
                                <p class="bottom_border"><span>Boovent Service & payment gateway charge:  </span>
                                <span class="pull-right ">Rs. <b><?php echo $sum*((BOOVENT_CUT*7)/1000); ?></b>
                                </span>
                                </p>
                                <h4><span>Order Total: </span><span class="pull-right">Rs.
                                <b><?php echo $sum + $sum*((BOOVENT_CUT*7)/1000);$total = $sum + $sum*((BOOVENT_CUT*7)/1000); ?></b>
                                </span></h4>
                                <?php //================= NO PAY =====================// ?>
                                <?php } else { ?>
                                <h4><span>Order Total: </span><span class="pull-right">Rs.
                                <b><?php echo "0";$total = 0; ?></b>
                                </span></h4>
                                <?php } ?>
							</div>
						</div>
                    <?php } } ?>
				    </div><!-- row -->
                    <br>
                    <ul class="list-inline pull-right">
                        <li><input type="button" class="btn btn-primary next-step1" value="Next" /></li>
                    </ul>
                </div>
                <?php if(!empty($user_checkout_result)) { 
                        foreach ($user_checkout_result as $rows){
                ?>
                <div class="tab-pane" role="tabpanel" id="step2">
                    <h3>Personal Information</h3>
                    <!-- <p>This is step 2</p> -->
                    <div class="row">
                    
                        <div class="col-md-7 col-sm-12 col-xs-12 checkout_form_box">
                          <form id="checkout-form">
                            <div class="form-group">
                              <input type="text" class="inputText" value="<?php echo $rows['user_name']; ?>" required/>
                              <span class="bar"></span>
                              <span class="floating-label">Name</span>
                            </div>
                            <div class="form-group">
                              <input type="text" id="user_password" name="user_password" value="<?php echo $rows['user_email']; ?>" required/>
                              <span class="bar"></span>
                              <span class="floating-label">Email</span>
                            </div>
                            <div class="form-group">
                              <input type="number" id="user_mobile" name="user_mobile" value="<?php echo $rows['user_mobile']; ?>" required/>
                              <span class="bar"></span>
                              <span class="floating-label">Contact No</span>
                            </div>
                          </form>
                        </div>
                        <div class="col-md-5 col-sm-12 col-xs-12 checkout_terms">
                            <!-- <h4>Terms and Condition</h4> -->
                            <div class="panel panel-default">
                                <div class="panel-heading"><h4>Terms and Condition</h4></div>
                                <div class="panel-body">
                                 <?php if(!empty($event_condition)) { ?>
                                    <p><?php echo $event_condition; ?></p>
                                    <div class="row checkbox top_5pt ">
                                      <label>
                                        <input type="checkbox" id="terms_condition_check" value="agree" checked>
                                        <span class="box-sign"><i class="fa fa-check" aria-hidden="true"></i></span>
                                        I agree with terms and conditions
                                      </label>
                                    </div>
                                   <?php } else { ?>
                                   <div class="row checkbox top_5pt ">
                                    <?php echo "<p>No Event Conditions Specified.</p>"; ?>
                                    <input type="checkbox" id="terms_condition_check" value="agree" checked style="display: none;">
                                   </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    
                    </div>  
                    <ul class="list-inline pull-right">
                        <li><input type="button" class="btn btn-primary prev-step" value="Previous" /></li>
                        <li><input type="button" class="btn btn-primary next-step2" value="Next" /></li>
                    </ul>
                </div>
                <!-- <div class="tab-pane" role="tabpanel" id="step3">
                    <h3>Step 3</h3>
                    <p>This is step 3</p>
                    <ul class="list-inline pull-right">
                        <li><button type="button" class="btn btn-primary prev-step">Previous</button></li>
                        <li><button type="button" class="btn btn-primary next-step">Skip</button></li>
                        <li><button type="button" class="btn btn-primary btn-info-full next-step">Save and continue</button></li>
                    </ul>
                </div> -->
                <div class="tab-pane" role="tabpanel" id="complete">
                    <h3>Checkout</h3>
                    <!-- <p>You have successfully completed all steps.</p> -->
                    <div class="row">
                        <div class="col-md-4 col-sm-12 col-xs-12 checkout_confirmation">
                            <p>Name: <span class="bold"><?php echo $rows['user_name']; ?></span>
                            </p>
                        <!-- </div> -->
                        <!-- <div class="col-md-4 col-sm-12 col-xs-12 checkout_confirmation"> -->
                            <p>Email: <span class="bold"><?php echo $rows['user_email']; ?></span></p>
                            <p>Contact: <span class="bold"><?php echo $rows['user_mobile']; ?></span></p>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 main_btn">
                            <h4>Total Payable Amount: Rs.<span class="bold"><?php echo $total; ?></span></h4>
                            <input type="button" onclick="PayNow();" class="btn btn-primary pay-now" value="Pay Now" />
                        </div>
                    </div>
                </div>
            <?php } } ?>
                <div class="clearfix"></div>
            </div>
        </div><!-- wizard -->
   </div>
</div><!-- container -->

<div class="container">
	
    
</div><!-- container -->

<!-- <br><br> -->
<?php
include 'footer.php'; // INCLUDING FOOTER
?>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script type="text/javascript">
function initRazorPay(total_price) {
if(total_price=="" || total_price=="undefined" ){
    $('#alert_text').text("Please Fill valid value!");
    $('#alert-modal').modal('show');
    }
    total_price=total_price*100;
    var user_razor_email="<?php echo $_SESSION['user_email']; ?>";
    var user_razor_name ="<?php echo $_SESSION['user_name']; ?>";
    var user_contact ="<?php echo $user_mobile; ?>";
    var options = {
     "key": "rzp_test_GpaqBD6mYl5B3v",
    //"key": "rzp_live_Jr1uY5J1eAPGbU",
    "amount": total_price, // 2000 paise = INR 20
    "name": "Boovent",
    "description": "Payment Information",
    "image": "images/razor_pay_icon.png",
    "handler": function (response){
        paymentCheckout(response.razorpay_payment_id, total_price);
    },
    "prefill": {
        "name": user_razor_name,
        "contact": user_contact,
        "email": user_razor_email
    },
    "notes": {
        "address": ""
    },
    "theme": {
        "color": "#c10708"
    }
    };
    var rzp1 = new Razorpay(options);
    rzp1.open();
}
</script>
<script type="text/javascript">
function PayNow() {
    var payment = "<?php echo $event_type; ?>";
    var eventid = "<?php echo $_SESSION['event']['eventid']; ?>";
    var totalprice = parseInt("<?php echo $total; ?>");
    if(totalprice!=0 && payment == 'Paid') { 
        initRazorPay(totalprice); 
    }
    else {
    var type = "Free";
    var contact = $('#user_mobile').val();
    var ticket1 = $('#ticket1').val();
    var qty1 = parseInt($('#qty1').val());
    var price1 = parseInt($('#price1').val());
    var id1 = $('#ticketid1').val();
    $.ajax({
      type:'POST',
      url:'utility/handlePayout.php',
      data:{
        free_type:type,
        eventid:eventid,
        ticket1:ticket1,
        qty1:qty1,
        price1:price1,
        id1:id1,
        contact:contact
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
        $('#alert_text').text(data);
        $('#alert-modal').modal('show');
        window.location.href='confirmation.php';
      }
      });
    }
}

function paymentCheckout(payment_id, total_price) {
    var ticket1,qty1,price1,id1="";
    var ticket2,qty2,price2,id2="";
    var ticket3,qty3,price3,id3="";
    var type = "Paid";
    var contact = $('#user_mobile').val();
    var payment_bearing = "<?php echo $_SESSION['event']['payment_bearing']; ?>";
    var event_id = "<?php echo $_SESSION['event']['eventid']; ?>";
    ticket1 = $('#ticket1').val();
    qty1 = parseInt($('#qty1').val());
    price1 = parseInt($('#price1').val());
    id1 = $('#ticketid1').val();
    ticket2 = $('#ticket2').val();
    qty2 = parseInt($('#qty2').val());
    price2 = parseInt($('#price2').val());
    id2 = $('#ticketid2').val();
    ticket3 = $('#ticket3').val();
    qty3 = parseInt($('#qty3').val());
    price3 = parseInt($('#price3').val());
    id3 = $('#ticketid3').val();
    ticket4 = $('#ticket4').val();
    qty4 = parseInt($('#qty4').val());
    price4 = parseInt($('#price4').val());
    id4 = $('#ticketid4').val();
    ticket5 = $('#ticket5').val();
    qty5 = parseInt($('#qty5').val());
    price5 = parseInt($('#price5').val());
    id5 = $('#ticketid5').val();
    ticket6 = $('#ticket6').val();
    qty6 = parseInt($('#qty6').val());
    price6 = parseInt($('#price6').val());
    id6 = $('#ticketid6').val();
    ticket7 = $('#ticket7').val();
    qty7 = parseInt($('#qty7').val());
    price7 = parseInt($('#price7').val());
    id7 = $('#ticketid7').val();
    ticket8 = $('#ticket8').val();
    qty8 = parseInt($('#qty8').val());
    price8 = parseInt($('#price8').val());
    id8 = $('#ticketid8').val();
    ticket9 = $('#ticket9').val();
    qty9 = parseInt($('#qty9').val());
    price9 = parseInt($('#price9').val());
    id9 = $('#ticketid9').val();
    $.ajax({
      type:'POST',
      url:'utility/handlePayout.php',
      data:{
        paid_type:type,
        eventid:event_id,
        payment_bearing:payment_bearing,
        payment_id:payment_id,
        total:total_price,
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
        id9:id9,
        contact:contact
      },
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr);
        console.log(ajaxOptions);
        console.log(thrownError);
      },
      beforeSend: function(){
        $('#loader_text').text('Please wait and do not press back button while payment is doing.');
        $('#loader-modal').modal('show');
      },
      success: function(data) {
        // Success
        $('#loader-modal').modal('hide');
        // alert(data);
        window.location.href='confirmation.php';
      }
      });
}
</script>
<!-- ==================== MULTI STEP WIZARD ========================= -->
<script type="text/javascript">
$(document).ready(function () {
    //Initialize tooltips
    $('.nav-tabs > li a[title]').tooltip();
    
    //Wizard
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

        var $target = $(e.target);
    
        if ($target.parent().hasClass('disabled')) {
            return false;
        }
    });

    $(".next-step1").click(function (e) {
            
        var $active = $('.wizard .nav-tabs li.active');
        $active.next().removeClass('disabled');
        nextTab($active);

    });
    $(".next-step2").click(function (e) {

        var contact_no = $('#user_mobile').val();
        var filter = /^(\+91-|\+91|0)?\d{10}$/;
        if (filter.test(contact_no)) {
            // alert('valid');
            if($("#terms_condition_check").is(':checked')){
                var $active = $('.wizard .nav-tabs li.active');
                $active.next().removeClass('disabled');
                nextTab($active);
            } else {
                var $active = $('.wizard .nav-tabs li.active');
                $active.next().addClass('disabled');
                $('#alert_text').text("Please check our terms and conditions");
                $('#alert-modal').modal('show');
            }
        }
        else {
            var $active = $('.wizard .nav-tabs li.active');
            $active.next().addClass('disabled');
            $('#alert_text').text("Please fill valid contact no.");
            $('#alert-modal').modal('show');
        }
        
        

    });
    $(".prev-step").click(function (e) {
        var $active = $('.wizard .nav-tabs li.active');
        prevTab($active);

    });
});

$('#user_mobile').blur(function() {
    var user_mobile=$('#user_mobile').val();
    user_mobile=user_mobile.trim();
    var filter = /^(\+91-|\+91|0)?\d{10}$/;
    if (filter.test(user_mobile)) {
        // alert(user_mobile);
    }else{
        // alert('no');
        var $active = $('.wizard .nav-tabs li.active');
        $active.next().addClass('disabled');
    }
    
});
$('#terms_condition_check').click(function() {
    if (!$(this).is(':checked')) {
        var $active = $('.wizard .nav-tabs li.active');
        $active.next().addClass('disabled');
    }
});

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}
</script>
