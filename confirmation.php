<?php
require_once 'connect/class.booventpdo.php';
ini_set('display_errors',1);
if(!isset($_SESSION))
{
    session_start();
}
if (!isset($_SESSION['user_email'])) {
    $home_url = BASE_URL. 'auth.php';
    header('Location: ' . $home_url);
}
//------------------------------ RETRIEVE THE BUYIED INFORMATION -----------------------//
    $condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":order"); 
    $condition_arr2= array($_SESSION['order_id']);
    $confirm_sql = "SELECT *,SUM(customer_price_purchased) AS total,SUM(purchase_quantity) AS qty FROM boovent_purchase WHERE order_id = :order";
    $ConfirmDetails=new BooventPDO();
    $confirm_result=$ConfirmDetails->selectQuery($confirm_sql,$condition_arr1,$condition_arr2); 
    $total_paid = $confirm_result[0]['total'];
    $total_qty = $confirm_result[0]['qty'];
    $event_id = $confirm_result[0]['event_id'];
    $event_ticket_type = $confirm_result[0]['purchased_ticket_type'];
    unset($ConfirmDetails);
    //------------------------------ RETRIEVE THE BUYIED INFORMATION -----------------------//
    $condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":order"); 
    $condition_arr2= array($_SESSION['order_id']);
    $confirm_sql = "SELECT *,SUM(event_ticket_total) AS total,SUM(event_ticket_quantity) AS qty FROM boovent_ticket_format WHERE order_id = :order";
    $TicketDetails=new BooventPDO();
    $ticket_result=$TicketDetails->selectQuery($confirm_sql,$condition_arr1,$condition_arr2); 
    $event_name = $ticket_result[0]['event_name'];
    $user_contact = $ticket_result[0]['user_mobile'];
    $event_total = $ticket_result[0]['total'];
    $event_quantity = $ticket_result[0]['qty'];
    unset($TicketDetails);

// CODE FOR GETTING DATE FOR SHARINT IN SOCIAL MEDIA
$condition_arr1="";
$condition_arr2="";
$condition_arr1= array(":event_id"); 
$condition_arr2= array($event_id);
$get_event_sql = "SELECT * FROM boovent_events WHERE event_id = :event_id";
$get_event=new BooventPDO();
$get_event_result=$get_event->selectQuery($get_event_sql,$condition_arr1,$condition_arr2); 
$share_image = $get_event_result[0]['event_image'];
$share_event_title=$get_event_result[0]['event_title'];
$share_event_description=strip_tags($get_event_result[0]['event_description']);
$share_event_description=substr($share_event_description, 0,40).'...';
$share_event_url=BASE_URL."event-details.php?eid=".$event_id;
include 'header.php'; // INCLUDING HEADER
?>
<style type="text/css">
body{
    background-color: #f1f1f1;
}
</style>
<div class="container">
    <div class="row">
        <div class="col-sm-10 col-md-offset-1 confirmation_box">
            <div class="confirm_1box text-center">
                <h1>Thank you for your order! <i class="fa fa-check-circle fa-1x" aria-hidden="true"></i></h1>
                <h3>Your payment was succussful done.</h3>
                <p>Your ticket has been sent to your e-mail address. You can also access the tickets from My Ticket section on our website</p>
                
            </div>
            <div class="confirm_2box col-md-8 col-md-offset-2">
                <p>Event: <span><?php echo $event_name; ?></span></p>
                <p>Order No: <span><?php echo $_SESSION['order_id']; ?></span></p>
                <p>Ticket QTY: <span><?php echo $total_qty; ?></span></p>
                <p>Total Rs.: <span><?php echo round($total_paid,2); ?></span></p>
                <?php if($event_ticket_type == "Free") {?>
                <p>Payment Method: <span>Not Applicable</span></p>
                <?php } else { ?>
                 <p>Payment Method: <span>Online</span></p>
                <?php } ?>
            </div>
            <div class="confirm_3box col-md-8 col-md-offset-2 text-center">
                <h3>Events are better with friends. Share this event</h3>
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
        </div>
    </div>
</div>

<!-- <br><br> -->
<?php
include 'footer.php'; // INCLUDING FOOTER
?>