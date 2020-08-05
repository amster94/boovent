<?php
require_once 'connect/class.booventpdo.php';
ini_set('display_errors',0);
if(!isset($_SESSION)){
    session_start();
}
if (!isset($_SESSION['user_email'])) {
    $home_url = BASE_URL. 'auth.php';
    header('Location: ' . $home_url);
}
// print_r($_SESSION);
include 'header.php'; // INCLUDING HEADER
$user_email=$_SESSION['user_email'];
$condition_arr1 = ""; // FOR SQL PARAMETER VALUE
$condition_arr2 = ""; // FOR BINDING SQL PARAMETER VALUE
if (isset($_GET['update'])) {
    $update_event=$_GET['update'];

    $condition_arr1 = ""; 
    $condition_arr2 = "";
    $condition_arr1= array(":user_email", ":event_id");
    $condition_arr2= array($user_email, $update_event);

    $update_event_obj = new BooventPDO;
    $update_event_sql = "SELECT * FROM boovent_events WHERE user_email=:user_email AND event_id=:event_id ";
    $update_event_list=$update_event_obj->selectQuery($update_event_sql, $condition_arr1, $condition_arr2);
    $update_event_result=sizeof($update_event_list);

    if($update_event_result>=1 OR $user_email==ADMIN_LOGIN_EMAIL){
        
        $script = '<script>  var update_event = "' . $update_event . '"; </script>';
        echo $script;
        $script1 = '<script>  $("#select_event_sub_category").prop("disabled", false); </script>';
        echo $script1;

    }else{
        // $home_url1 = BASE_URL. '404.php';
        header('Location: https://www.boovent.com/404.php');
    }

    
}else{

}
?>
<script>
var event_pay_type = "Paid";
</script>
<!-- css for tags input -->
<link rel="stylesheet" href="css/bootstrap-tagsinput.css">
<!-- INCLUDE FOR RICH TEXT EDITOR -->
<!-- <link href="http://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet"> -->
<!-- <link href="css/external/google-code-prettify/prettify.css" rel="stylesheet"> -->
<script src="js/external/jquery.hotkeys.js"></script>
<script src="js/external/google-code-prettify/prettify.js"></script>
<link href="css/rich-text.css" rel="stylesheet">
<script src="js/bootstrap-wysiwyg.js"></script>
<!-- INCLUDE FOR RICH TEXT EDITOR END -->
<div class="container">
	<div class="row">
    	<div class="col-md-12 page_heading">
    		<h3> CREATE YOUR EVENT IN 3-STEP </h3>
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
                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Create Tickets">
                            <span class="round-tab">
                                <i class="fa fa-ticket" aria-hidden="true"></i>
                            </span>
                        </a>
                    </li>
                    <li role="presentation" class="disabled">
                        <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Additional Settings and Post">
                            <span class="round-tab">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <form action="" id="create_event_form" method="POST">
            <div class="col-md-12 tab-content create_event_box ">
                <!-- ========== EVENT INFORMATION TAB ======================== -->
                <div class="tab-pane active col-md-8 col-md-offset-2" role="tabpanel" id="step1">
                    <h3>Event Information</h3>
                    
                    <div class="top_5pt">
                        <h4 class="">Event Type</h4>
                        <div class="row">
                            <div class="radio ">
                                <label class="radio-inline">
                                    <input type="radio" name="event_type" value="offline" checked>
                                    <span class="box-sign"><i class="fa fa-check" aria-hidden="true"></i></span>
                                    Offline
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="event_type" value="online" >
                                    <span class="box-sign"><i class="fa fa-check" aria-hidden="true"></i></span>
                                    Online
                                </label>
                                
                            </div>
                        </div>
                        
				    	<div class="form-group">
                            <input type="text" id="event_title" name="event_title" class="event_title" required/>
                            <span class="bar"></span>
                            <span class="floating-label">Event Title</span>
                        </div>
                        <div class="form-group">
                            <input type="text" id="event_location" name="event_location" class="event_locations" required/>
                            <span class="bar"></span>
                            <span class="floating-label">Location</span>
                        </div>
                        <div class="form-group">
                            <input type="text" id="event_addres" name="event_addres" class="event_addres" required/>
                            <span class="bar"></span>
                            <span class="floating-label">Address</span>
                        </div>
                        <div class="form-group">
                            <input type="text" id="event_city" name="event_city" class="event_city" required/>
                            <span class="bar"></span>
                            <span class="floating-label">City</span>
                        </div>
                        <div class="form-group">
                            <input onkeypress="return isNumberKey(event, this.id, 'zip', 6)" maxlength="6" type="number" id="event_zip" name="event_zip" class="event_zip" required/>
                            <span class="bar"></span>
                            <span class="floating-label">zip/postal</span>
                            <span id="zip"></span>
                        </div>
                        <div class="form-group">
                            <input type="text" id="event_state" name="event_state" class="event_state" required/>
                            <span class="bar"></span>
                            <span class="floating-label">State</span>
                        </div>
                        <div class="form-group">
                            <input type="text" id="event_country" name="event_country" class="event_country" required/>
                            <span class="bar"></span>
                            <span class="floating-label">Country</span>
                        </div>
                        <div class="form-group">
                            <input onkeypress="return isNumberKey(event, this.id, 'phone', 10)" maxlength="10" type="number" id="event_organizer_mobile" name="event_organizer_mobile" class="event_organizer_mobile" required/>
                            <span class="bar"></span>
                            <span class="floating-label">Contact Number</span>
                            <span id="phone"></span>
                        </div>
                        <div class="form-group">
                            <input type="text" id="event_organizer_organization_name" name="event_organizer_organization_name" class="event_organizer_organization_name" required />
                            <span class="bar"></span>
                            <span class="floating-label">Organization Name</span>
                        </div>
                        <div class="form-group">
                            <input onkeypress="return isWebsiteKey(event, this.id, 'website')" type="text" id="event_website_url" name="event_website_url" class="event_website_url" required/>
                            <span class="bar"></span>
                            <span class="floating-label">Website Url</span>
                            <span id="website"></span>
                        </div>
                        <h4 class="">Event Occurence</h4>
                        <div class="row">
                            <div class="radio ">
                                <label class="radio-inline">
                                    <input type="radio" name="event_occurence" value="None" checked>
                                    <span class="box-sign"><i class="fa fa-check" aria-hidden="true"></i></span>
                                    None
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="event_occurence" value="Daily" >
                                    <span class="box-sign"><i class="fa fa-check" aria-hidden="true"></i></span>
                                    Daily
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="event_occurence" value="Weekly">
                                    <span class="box-sign"><i class="fa fa-check" aria-hidden="true"></i></span>
                                    Weekly
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="event_occurence" value="Monthly" >
                                    <span class="box-sign"><i class="fa fa-check" aria-hidden="true"></i></span>
                                    Monthly
                                </label>
                            </div>
                        </div>
                        <!-- <div class=""> -->
                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                            <input type="text" id="event_start_date" name="event_start_date" class="event_start_date row" required/>
                            <span class="bar row"></span>
                            <span class="floating-label">Start Date/Time</span>
                        </div>
                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                            <input type="text" id="event_end_date" name="event_end_date" class="event_end_date row " required/>
                            <span class="bar row"></span>
                            <span class="floating-label">End Date/Time</span>
                        </div>
                        
                        <div class=" event_image">
                            <div class="form-group files" >
                                <label>Upload Your Event Image <span class="input_notice">(image should be less than 3Mb and 1600X500 for better look.)</span></label>
                                <input type="file" class="form-control" id="event-image" name="event-image"  onchange="previewImage(event)" />
                            </div>
                        </div>
                        <div id="preview_image"></div>
                        <div class="top_1pt">
                            <a class="btn btn-primary" id="cancel_upload" onclick="cancelUpload()" href="javascript:void(0)">Cancel Image</a>
                            <a class="btn btn-primary" id="upload_file" onclick="uploadFile()" href="javascript:void(0)">Upload</a>
                        </div>
                        <!-- ============ RICH TEXT EDITOR ============ -->
                        <div class="row form-group top_5pt hero-unit">
                            <h4>Event Descriptions</h4>
                            <?php include 'include/text_editor_btn.php'; ?>
                            <div id="editor" class="custom_text_box">
                            </div>
                            <!-- <input type="text" id="event_end_date" name="event_end_date" class="event_end_date row " required/> -->
                        </div>
                    </div><!-- row -->
                    <div class="clearfix"></div>
                    <ul class="list-inline pull-right top_35pt top_min40pt">
                       <li><input type="button" class="btn btn-primary next-step1" value="Next" /></li>
                    </ul>
                </div>
                <!-- ========== EVENT CREATE TICKETS TAB ======================== -->
                <div class="tab-pane col-md-8 col-md-offset-2" role="tabpanel" id="step2">
                    <h3>Create Tickets</h3>
                    <!-- <p>This is step 2</p> -->
                    <div class="top_5pt">
                        <div class="col-md-12">
                            <div class="ticket_setting">
                                <div class="panel panel-default">
                                  <div class="panel-heading">
                                      <p class="col-md-6">Ticket Name</p>
                                      <p class="col-md-3">QTY Availble</p>
                                      <p class="col-md-3">Price</p>
                                  </div>
                                  <div class="panel-body">
                                     <!-- TICKET CUSTOMIZATION BOX FIRST -->
                                    <div id="ticket_customization_1box">
                                        <div class="form-group col-md-6">
                                            <input type="text" id="ticket_name" name="ticket_name" class="ticket_name" required/>
                                            <span class="bar"></span>
                                            <span class="floating-label">Ticket Name</span>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <input type="number" id="ticket_quantity" maxlength="3" name="ticket_quantity" class="ticket_quantity" required/>
                                            <span class="bar"></span>
                                            <span class="floating-label">Quantity</span>
                                        </div>
                                        <!-- PAID-FREE TICKET BOX SETTING -->
                                        <div class="form-group col-md-3" id="paid_ticket_box">
                                            <input type="number" id="ticket_price" maxlength="6" name="ticket_price" class="ticket_price" required/>
                                            <span class="bar"></span>
                                            <span class="floating-label">Price</span>
                                        </div>
                                        <div class="form-group col-md-3" id="free_ticket_box">
                                            <h2 class="top_5pt">FREE</h2>
                                        </div>
                                    </div>

                                    <div id="add_more_customization_field">
                                        <!-- TICKET CUSTOMIZATION BOX SECOND -->
                                        <div id="ticket_customization_2box">
                                            <div class="form-group col-md-6">
                                                <input type="text" id="ticket_name2" name="ticket_name2" class="ticket_name2" required/>
                                                <span class="bar"></span>
                                                <span class="floating-label">Ticket Name</span>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <input type="number" id="ticket_quantity2" maxlength="3" name="ticket_quantity2" class="ticket_quantity2" required/>
                                                <span class="bar"></span>
                                                <span class="floating-label">Quantity</span>
                                            </div>
                                            <div class="form-group col-md-3" id="paid_ticket_box">
                                                <input type="number" id="ticket_price2" maxlength="6" name="ticket_price2" class="ticket_price2" required/>
                                                <span class="bar"></span>
                                                <span class="floating-label">Price</span>
                                            </div>
                                        </div>
                                        <!-- TICKET CUSTOMIZATION BOX THIRD -->
                                        <div id="ticket_customization_3box">
                                            <div class="form-group col-md-6">
                                                <input type="text" id="ticket_name3" name="ticket_name3" class="ticket_name3" required/>
                                                <span class="bar"></span>
                                                <span class="floating-label">Ticket Name</span>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <input type="number" id="ticket_quantity3" maxlength="3" name="ticket_quantity3" class="ticket_quantity3" required/>
                                                <span class="bar"></span>
                                                <span class="floating-label">Quantity</span>
                                            </div>
                                            <!-- PAID TICKET BOX SETTING -->
                                            <div class="form-group col-md-3" id="paid_ticket_box">
                                                <input type="number" id="ticket_price3" maxlength="6" name="ticket_price3" class="ticket_price3" required/>
                                                <span class="bar"></span>
                                                <span class="floating-label">Price</span>
                                            </div>
                                        </div><!-- ticket_customization_by_type -->

                                        <!-- TICKET CUSTOMIZATION BOX FOURTH ADDED LATER -->
                                        <div id="ticket_customization_4box">
                                            <div class="form-group col-md-6">
                                                <input type="text" id="ticket_name4" name="ticket_name4" class="ticket_name4" required/>
                                                <span class="bar"></span>
                                                <span class="floating-label">Ticket Name</span>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <input type="number" id="ticket_quantity4" maxlength="3" name="ticket_quantity4" class="ticket_quantity4" required/>
                                                <span class="bar"></span>
                                                <span class="floating-label">Quantity</span>
                                            </div>
                                            <!-- PAID TICKET BOX SETTING -->
                                            <div class="form-group col-md-3" id="paid_ticket_box">
                                                <input type="number" id="ticket_price4" maxlength="6" name="ticket_price4" class="ticket_price4" required/>
                                                <span class="bar"></span>
                                                <span class="floating-label">Price</span>
                                            </div>
                                        </div><!-- ticket_customization_by_type -->

                                        <!-- TICKET CUSTOMIZATION BOX FIFTH ADDED LATER -->
                                        <div id="ticket_customization_5box">
                                            <div class="form-group col-md-6">
                                                <input type="text" id="ticket_name5" name="ticket_name5" class="ticket_name5" required/>
                                                <span class="bar"></span>
                                                <span class="floating-label">Ticket Name</span>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <input type="number" id="ticket_quantity5" maxlength="3" name="ticket_quantity5" class="ticket_quantity5" required/>
                                                <span class="bar"></span>
                                                <span class="floating-label">Quantity</span>
                                            </div>
                                            <!-- PAID TICKET BOX SETTING -->
                                            <div class="form-group col-md-3" id="paid_ticket_box">
                                                <input type="number" id="ticket_price5" maxlength="6" name="ticket_price5" class="ticket_price5" required/>
                                                <span class="bar"></span>
                                                <span class="floating-label">Price</span>
                                            </div>
                                        </div><!-- ticket_customization_by_type -->

                                        <!-- TICKET CUSTOMIZATION BOX SIXTH ADDED LATER -->
                                        <div id="ticket_customization_6box">
                                            <div class="form-group col-md-6">
                                                <input type="text" id="ticket_name6" name="ticket_name6" class="ticket_name6" required/>
                                                <span class="bar"></span>
                                                <span class="floating-label">Ticket Name</span>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <input type="number" id="ticket_quantity6" maxlength="3" name="ticket_quantity6" class="ticket_quantity6" required/>
                                                <span class="bar"></span>
                                                <span class="floating-label">Quantity</span>
                                            </div>
                                            <!-- PAID TICKET BOX SETTING -->
                                            <div class="form-group col-md-3" id="paid_ticket_box">
                                                <input type="number" id="ticket_price6" maxlength="6" name="ticket_price6" class="ticket_price6" required/>
                                                <span class="bar"></span>
                                                <span class="floating-label">Price</span>
                                            </div>
                                        </div><!-- ticket_customization_by_type -->

                                        <!-- TICKET CUSTOMIZATION BOX SEVENTH ADDED LATER -->
                                        <div id="ticket_customization_7box">
                                            <div class="form-group col-md-6">
                                                <input type="text" id="ticket_name7" name="ticket_name7" class="ticket_name7" required/>
                                                <span class="bar"></span>
                                                <span class="floating-label">Ticket Name</span>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <input type="number" id="ticket_quantity7" maxlength="3" name="ticket_quantity7" class="ticket_quantity7" required/>
                                                <span class="bar"></span>
                                                <span class="floating-label">Quantity</span>
                                            </div>
                                            <!-- PAID TICKET BOX SETTING -->
                                            <div class="form-group col-md-3" id="paid_ticket_box">
                                                <input type="number" id="ticket_price7" maxlength="6" name="ticket_price7" class="ticket_price7" required/>
                                                <span class="bar"></span>
                                                <span class="floating-label">Price</span>
                                            </div>
                                        </div><!-- ticket_customization_by_type -->

                                        <!-- TICKET CUSTOMIZATION BOX EIGHT ADDED LATER -->
                                        <div id="ticket_customization_8box">
                                            <div class="form-group col-md-6">
                                                <input type="text" id="ticket_name8" name="ticket_name8" class="ticket_name8" required/>
                                                <span class="bar"></span>
                                                <span class="floating-label">Ticket Name</span>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <input type="number" id="ticket_quantity8" maxlength="3" name="ticket_quantity8" class="ticket_quantity8" required/>
                                                <span class="bar"></span>
                                                <span class="floating-label">Quantity</span>
                                            </div>
                                            <!-- PAID TICKET BOX SETTING -->
                                            <div class="form-group col-md-3" id="paid_ticket_box">
                                                <input type="number" id="ticket_price8" maxlength="6" name="ticket_price8" class="ticket_price8" required/>
                                                <span class="bar"></span>
                                                <span class="floating-label">Price</span>
                                            </div>
                                        </div><!-- ticket_customization_by_type -->

                                        <!-- TICKET CUSTOMIZATION BOX NINTH ADDED LATER -->
                                        <div id="ticket_customization_9box">
                                            <div class="form-group col-md-6">
                                                <input type="text" id="ticket_name9" name="ticket_name9" class="ticket_name9" required/>
                                                <span class="bar"></span>
                                                <span class="floating-label">Ticket Name</span>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <input type="number" id="ticket_quantity9" maxlength="3" name="ticket_quantity9" class="ticket_quantity9" required/>
                                                <span class="bar"></span>
                                                <span class="floating-label">Quantity</span>
                                            </div>
                                            <!-- PAID TICKET BOX SETTING -->
                                            <div class="form-group col-md-3" id="paid_ticket_box">
                                                <input type="number" id="ticket_price9" maxlength="6" name="ticket_price9" class="ticket_price9" required/>
                                                <span class="bar"></span>
                                                <span class="floating-label">Price</span>
                                            </div>
                                        </div><!-- ticket_customization_by_type -->
                                    </div>
                                    <!-- BUTTON FOR ADD MORE FIELDS FOR TICKETS CUSTOMIZATION -->
                                    <a id="add_fields_for_customization" href="javascript:void(0);" class="btn btn-primary" role="button"><i class="fa fa-plus-circle" aria-hidden="true"></i> ADD MORE TICKET</a>
                                    <a id="cancel_ticket_customization" href="javascript:void(0);" class="btn btn-primary" role="button"><i class="fa fa-minus-circle" aria-hidden="true"></i> REMOVE</a>
                                  </div><!-- panel-body -->
                                  <div class="bare_boobent_fees">
                                        <h4 class="">Who will bare boovent and payment gateway fees?</h4>
                                        <div class="form-group ">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="who_bare_payment" value="i_will">
                                                <span class="box-sign"><i class="fa fa-check" aria-hidden="true"></i></span>
                                                I will
                                            </label>
                                        </div>
                                        </div>
                                        <div class="form-group ">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="who_bare_payment" value="customer_will">
                                                <span class="box-sign"><i class="fa fa-check" aria-hidden="true"></i></span>
                                                Customer will
                                            </label>
                                        </div>
                                        </div>
                                        <div class="form-group ">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="who_bare_payment" value="will_be_divided_equally">
                                                <span class="box-sign"><i class="fa fa-check" aria-hidden="true"></i></span>
                                                Will be divided equally
                                            </label>
                                        </div>
                                      </div>    
                                  </div>
                                  <div class="bare_boobent_fees boobent_button_type">
                                        <h4 class="">Create your button:</h4>
                                        <div class="form-group ">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="button_type" value="buy">
                                                <span class="box-sign"><i class="fa fa-check" aria-hidden="true"></i></span>
                                                Buy Now
                                            </label>
                                        </div>
                                        </div>
                                        <div class="form-group ">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="button_type" 
                                                value="register">
                                                <span class="box-sign"><i class="fa fa-check" aria-hidden="true"></i></span>
                                                Register Now
                                            </label>
                                        </div>
                                        </div>    
                                  </div>
                                </div> 
                            </div>
                            <div class=" center ticket_setting_btn">
                                <a id="paid_ticket_btn" href="javascript:void(0);" class="btn btn-primary " role="button"><i class="fa fa-plus-circle" aria-hidden="true"></i> PAID TICKET</a>
                                <a id="free_ticket_btn" href="javascript:void(0);" class="btn btn-primary " role="button"><i class="fa fa-plus-circle" aria-hidden="true"></i> FREE TICKET</a>
                            </div>
                        </div>
                    </div>  
                    <ul class="list-inline pull-right">
                        <li><input type="button" class="btn btn-primary prev-step" value="Previous" /></li>
                        <li><input type="button" class="btn btn-primary next-step2" value="Next" /></li>
                    </ul>
                </div>
                <!-- ========== EVENT TICKET ADDITIONAL SETTINGS TAB ======================== -->
                <div class="tab-pane col-md-8 col-md-offset-2" role="tabpanel" id="complete">
                    <h3>Additional Settings</h3>
                    <div class="top_5pt ticket_additional_setting">
                        <div class="form-group">
                            <select id="select_event_category" class="form-control select_event_category">
                                <option value="" selected="selected">SELECT EVENT TYPE</option>
                                <option value="Cultural">Cultural</option>
                                <option value="Food and Drinks">Food and Drinks</option>
                                <option value="Political">Political</option>
                                <option value="Health">Health</option>
                                <option value="Business">Business</option>
                                <option value="Hobbies">Hobbies</option>
                                <option value="Music">Music</option>
                                <option value="Entertainment">Entertainment</option>
                                <option value="Art">Art</option>
                                <option value="Science and Technology">Science and Technology</option>
                                <option value="Religious">Religious</option>
                                <option value="Holiday">Holiday</option>
                                <option value="Sports and Adventure">Sports and Adventure</option>
                                <option value="College">College</option>
                                <option value="Education and Family">Education and Family</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select id="select_event_sub_category" class="form-control select_event_sub_category">
                              <option selected="selected">SELECT EVENT CATEGORY</option>
                            </select>
                        </div>
                        <div class="form-group other_category_box">
                            <input type="text" id="other_category" name="other_category" class="other_category" required/>
                            <span class="bar"></span>
                            <span class="floating-label">Other Category</span>
                        </div>
                        <div class="form-group">
                            <input type="text" id="event_term_condition" name="event_term_condition" class="event_term_condition" required/>
                            <span class="bar"></span>
                            <span class="floating-label">Event Term Condition</span>
                        </div>
                        <h4 class="">Add Event Tags:</h4>
                        <div class="form-group event_tag_box">
                            <input value="" data-role="tagsinput" type="text" id="event_tags" name="event_tags" class="form-control event_tags" required/>
                            <!-- <span class="bar"></span>
                            <span class="floating-label">Enter Event Tag</span> -->
                        </div>
                        <!-- <div id="show_tag"></div> -->
                        <div class="form-group col-md-6 col-md-offset-3 col-sm-12 col-xs-12 main_btn">
                            <?php if(!isset($_GET['update'])) { ?>
                            <input type="button" class="btn btn-primary event_live_btn" value="Make Your Event Live" onclick="makeEventLive();" />
                            <?php } else { ?>
                            <input type="button" class="btn btn-primary update_event_btn" value="Update Event" onclick="updateEvent();" />
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            </form>
        </div><!-- wizard -->
   </div>
</div><!-- container -->

<div class="container">

</div><!-- container -->


<!-- <br><br> -->
<?php
include 'footer.php'; // INCLUDING FOOTER
?>
<!-- ======================= FORM VALIDATION CODE GOES HERE ======================= -->
<script type="text/javascript" src="js/validation-functions.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    $('#create_event_form input[type=text], #create_event_form textarea').each(function(){
    // $('.form-group').after('<span class="validation">sfd</span>');
    });
    // $(".event_live_btn").show();
    // $(".update_event_btn").hide();
});    
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
        var event_title = $('#event_title').val();
        var event_location = $('#event_location').val();
        var event_address = $('#event_addres').val();
        var event_zip = $('#event_zip').val();
        var event_city = $('#event_city').val();
        var event_state = $('#event_state').val();
        var event_country = $('#event_country').val();
        var event_mobile = $('#event_organizer_mobile').val();
        var event_organization = $('#event_organizer_organization_name').val();
        var event_website = $('#event_website_url').val();
        var event_start_date = $('#event_start_date').val();
        var event_end_date = $('#event_end_date').val();
        var event_description = $('#editor').html();
        var event_term_condition = $('#event_term_condition').val();
        var event_tag = $('#event_tags').val();
        var event_category = $('#select_event_category').val();
        if (event_title=='' || event_location=='' || event_zip=='' || event_city=='' || event_state=='' || event_mobile=='' || event_start_date=='' || event_end_date=='' || event_description=='') {
            
            $('#alert_text').text('Empty fields! Please fill.');
            $('#alert-modal').modal('show');
            var $active = $('.wizard .nav-tabs li.active');
            $active.next().addClass('disabled');
        }else{
            // window.field_error=0;
            if (event_zip.length!=6) {

            }else if(event_mobile.length!=10){

            }else{
                var $active = $('.wizard .nav-tabs li.active');
                $active.next().removeClass('disabled');
                nextTab($active);
            }
        }
    });

    $(".next-step2").click(function (e) {
        var ticket_name = $('#ticket_name').val();
        var ticket_quantity = $('#ticket_quantity').val();
            
        if (ticket_name=='' || ticket_quantity=='') {
            $('#alert_text').text('Empty fields! Please fill.');
            $('#alert-modal').modal('show');
            var $active = $('.wizard .nav-tabs li.active');
            $active.next().addClass('disabled');
        }else{
            var $active = $('.wizard .nav-tabs li.active');
            $active.next().removeClass('disabled');
            nextTab($active); 
        }

    });

    $(".prev-step").click(function (e) {
        var $active = $('.wizard .nav-tabs li.active');
        prevTab($active);

    });
});

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}
</script>
<!-- =========== DATE AND TIME CUSTOMIZATION =========== -->
<script type="text/javascript">
    $('#event_start_date').datetimepicker({
        //language:  'fr',
        format: 'dd-mm-yyyy hh:ii',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1,
        minDate: 0
    });
    $('#event_end_date').datetimepicker({
        // language:  'fr',
        format: 'dd-mm-yyyy hh:ii',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1,
        minDate: 0
    });
</script>
<!-- =========== JS FOR HIDE AND SHOW ELEMENT AS PER IT REQUIREMENTS AND ALSO SHOW CATEGORY DYNAMICALY ========================= -->
<script type="text/javascript">
$(document).ready(function(){
    $('#free_ticket_box').hide();
    $('#add_more_customization_field').hide();
    // $('#ticket_customization_3box').hide();
    $('#cancel_ticket_customization').hide();
// ------ CODE FOR PAID TICKET BUTTON SHOW-HIDE ELEMENTS RELATED ACTION -----------------------
    $('#paid_ticket_btn').on('click', function(){
        $('#free_ticket_box').hide();
        $('#paid_ticket_box').show();
        $('.bare_boobent_fees').show();
        $('#add_fields_for_customization').show(); 
        $('#ticket_name').val('');
        $('#ticket_quantity').val('');
        event_pay_type = "Paid";
    });

// ------ CODE FOR FREE TICKET BUTTON SHOW-HIDE ELEMENTS RELATED ACTION -----------------------
    $('#free_ticket_btn').on('click', function(){
        $('#paid_ticket_box').hide();
        $('.bare_boobent_fees').hide();
        $('#add_more_customization_field').hide();
        // $('#ticket_customization_3box').hide();
        $('#add_fields_for_customization').hide();
        $('#cancel_ticket_customization').hide();
        $('#free_ticket_box').show();

        // Empty All Paid Ticket Fields
        $('#ticket_name').val('');
        $('#ticket_quantity').val('');
        $('#ticket_price').val('');
        $('#ticket_name2').val('');
        $('#ticket_quantity2').val('');
        $('#ticket_price2').val('');
        $('#ticket_name3').val('');
        $('#ticket_quantity3').val('');
        $('#ticket_price3').val('');
        $('input[name=who_bare_payment]:checked').prop('checked', false);
        $('input[name=button_type]:checked').prop('checked', false);
        event_pay_type = "Free";
    });

// ------ CODE FOR TEICKET NAME MORE CUSTOMIZATION -----------------------------
    $('#add_fields_for_customization').on('click', function(){
        
        $('#add_fields_for_customization').hide();
        $('#cancel_ticket_customization').show();     
        $('#add_more_customization_field').show();
        // $('#ticket_customization_3box').show();
        $('#free_ticket_box').hide();
        $('#paid_ticket_box').show();
        $('.bare_boobent_fees').show();
    });
    $('#cancel_ticket_customization').on('click', function(){
        $('#cancel_ticket_customization').hide();
        $('#add_fields_for_customization').show();
        $('#add_more_customization_field').hide();
        // $('#ticket_customization_3box').hide();
        $('#ticket_name2').val('');
        $('#ticket_quantity2').val('');
        $('#ticket_price2').val('');
        $('#ticket_name3').val('');
        $('#ticket_quantity3').val('');
        $('#ticket_price3').val('');
        
    });

// ------ CHANGE EVENT SUB-CATEGORY A/C TO MAIN CATEGORY DYNAMICALLY ---------------
$("#select_event_sub_category").prop("disabled", true);
$("#select_event_category").change(function() {

    var $dropdown = $(this);
    $("#select_event_sub_category").prop("disabled", false);
    $.getJSON("include/event-category.json", function(data) {
    
        var key = $dropdown.val();
        var vals = [];
        // alert(key);                 
        switch(key) {
            // SHOWING SUB-CATEGORIES FOR CULTURAL 
            case 'Cultural':
                vals = data.Cultural.split(",");
                break;
            // SHOWING SUB-CATEGORIES FOR FOOD AND DRINKS 
            case 'Food and Drinks':
                vals = data.Food_and_Drinks.split(",");
                break;
            // SHOWING SUB-CATEGORIES FOR POLITICAL
            case 'Political':
                vals = data.Political.split(",");
                break;
            // SHOWING SUB-CATEGORIES FOR HEALTH
            case 'Health':
                vals = data.Health.split(",");
                break;
            // SHOWING SUB-CATEGORIES FOR BUSINESS
            case 'Business':
                vals = data.Business.split(",");
                break;
            // SHOWING SUB-CATEGORIES FOR HOBBIES
            case 'Hobbies':
                vals = data.Hobbies.split(",");
                break;
            // SHOWING SUB-CATEGORIES FOR MUSICS
            case 'Music':
                vals = data.Music.split(",");
                break;
            // SHOWING SUB-CATEGORIES FOR ENTERTAINMNTS
            case 'Entertainment':
                vals = data.Entertainment.split(",");
                break;
            // SHOWING SUB-CATEGORIES FOR ART
            case 'Art':
                vals = data.Art.split(",");
                break;
            // SHOWING SUB-CATEGORIES FOR SCIENCE AND TECHNOLOGY
            case 'Science and Technology':
                vals = data.Science_and_Technology.split(",");
                break;
            // SHOWING SUB-CATEGORIES FOR TELIGIOUS
            case 'Religious':
                vals = data.Religious.split(",");
                break;
            // SHOWING SUB-CATEGORIES FOR HOLIDAY
            case 'Holiday':
                vals = data.Holiday.split(",");
                break;
            // SHOWING SUB-CATEGORIES FOR SPORTS AND ADVENTURE
            case 'Sports and Adventure':
                vals = data.Sports_and_Adventure.split(",");
                break;
            // SHOWING SUB-CATEGORIES FOR COLLEGE
            case 'College':
                vals = data.College.split(",");
                break;
            // SHOWING SUB-CATEGORIES FOR EDUCATION AND FAMILY
            case 'Education and Family':
                vals = data.Education_and_Family.split(",");
                break;
            // Do nothing
            case '':
                // vals = ['Please choose from above'];
                $("#select_event_sub_category").prop("disabled", true);
        }
        
        var $secondChoice = $("#select_event_sub_category");
        $secondChoice.empty();
        $secondChoice.append("<option>SELECT EVENT CATEGORY</option>");
        $.each(vals, function(index, value) {
            $secondChoice.append("<option>" + value + "</option>");
        });
        $secondChoice.append("<option>Others</option>");

    });
});
// ----- TEST FOR GETTING SUB-CATEGORY JS CODE -----------------
    $(".other_category_box").hide();
    $("#select_event_sub_category").change(function(){
        var event_sub_category=$(this).val();
        //alert(event_sub_category);
        if (event_sub_category=="Others") {
            $(".other_category_box").show();
        }else{
            $(".other_category_box").hide();
        }
    });
});
</script>
<!-- ============= EVENT TAG IMPLEMENTATION =============== -->
<script type="text/javascript">

// $(document).ready(function(){
// $(".event_tag_box").hide();
//     $('#add_event_tag').on('click', function(){
//         $(".event_tag_box").show();
//         e.preventDefault();
//     });
// });
var tag = [];
// var tag_size;
// $(document).keypress(function(e) {
//     if(e.which == 13) {
//         var event_tag=$("#event_tag").val();
//         if (event_tag!='') {
//             tag.push(event_tag);
//             var tag_show_html=tag;
//                 $("#event_tag").val('');
//                 $("#show_tag").text(tag_show_html);
//         }
//     }
// });
</script>
<!-- ================ FILE UPLOAD SCRIPTS ================= -->
<script type='text/javascript'>
$('#cancel_upload').hide();
$('#upload_file').hide();
function previewImage(event) {
 var reader = new FileReader();
 reader.onload = function(){
    $('#preview_image').removeClass('files');
    $('.event_image').hide();
    $('#preview_image').html('<img class="" id="output_image"/>');
    $('#cancel_upload').show();
    $('#upload_file').show();

    var output = document.getElementById('output_image');
    output.src = reader.result;
 }
 reader.readAsDataURL(event.target.files[0]);
}
function cancelUpload(){
    $('#cancel_upload').hide();
    $('#preview_image').html('');
    $('#preview_image').addClass('files');
    // $('#preview_image').html('<label>Upload Your Event Image</label><input onchange="previewImage(event)" id="event-image" name="event-image" type="file" class="form-control" multiple="">');

    $('.event_image').show();
    $('#event-image').val('');
    $('#upload_file').hide();
}

function uploadFile(){
  // var files=$('#files').val();
    var file_data = $('#event-image').prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('file', file_data);
    // alert(file_data);                       
    $.ajax({
        url: 'utility/file-upload.php', // point to server-side PHP script 
        dataType: 'text',  // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        error: function (xhr, ajaxOptions, thrownError) {
          console.log('wait...');
          console.log(xhr);
          console.log(ajaxOptions);
          console.log(thrownError);
        },
        beforeSend: function(){
            $('#loader_text').text('Please wait, File uploading in progress...');
            $('#loader-modal').modal('show');
        },
        success: function(data){
            $('#loader-modal').modal('hide');
            $('#alert_text').text(data);
            $('#alert-modal').modal('show'); // display response from the PHP script, if any
            console.log('done...');
        }
     });
}
</script>
<?php //====EVENT LOCATION SHOWING DYNAMICALLY BY AUTO HINT BY GOOGLE LOCATION=====// ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC6jN9xh1nrsOyRQlBuShvbS_9QCfdVSrE&libraries=places">
</script>
<script type="text/javascript">
    google.maps.event.addDomListener(window, 'load', function () {
        var options = {
                types: ['(cities)'],
                componentRestrictions: {country: "in"}
        };
        var input = document.getElementById('event_location');
        var places = new google.maps.places.Autocomplete(input,options);
        google.maps.event.addListener(places, 'place_changed', function () {
            var place = places.getPlace();
            var address = place.formatted_address;
            var latitude = place.geometry.location.lat();
            var longitude = place.geometry.location.lng();
            var mesg = "Address: " + address;
            mesg += "\nLatitude: " + latitude;
            mesg += "\nLongitude: " + longitude;
        });
    });
    $("#event_location").attr("placeholder","");
</script>
<?php 
if (isset($_GET['update'])) {
   $update_event=$_GET['update'];
}
?>
<script type="text/javascript">
$(document).ready(function(){
    // var update_event='<?php echo $update_event; ?>';
    // if (update_event!='') {
    //     $("#select_event_sub_category").prop("disabled", false);
    // }else{
    //     $("#select_event_sub_category").prop("disabled", true);
    // }
});
</script>
<?php  //================== CREATE FORM DETAIL 1 =============================================// ?>
<script type='text/javascript'>

function makeEventLive() {
    var event_place_type = $('input[name=event_type]:checked').val();
    var event_occurence = $('input[name=event_occurence]:checked').val();
    var event_type = event_pay_type;
    var event_title = $('#event_title').val();
    var event_location = $('#event_location').val();
    var event_address = $('#event_addres').val();
    var event_zip = $('#event_zip').val();
    var event_city = $('#event_city').val();
    var event_state = $('#event_state').val();
    var event_country = $('#event_country').val();
    var event_mobile = $('#event_organizer_mobile').val();
    var event_organization = $('#event_organizer_organization_name').val();
    var event_website = $('#event_website_url').val();
    var event_start_date = $('#event_start_date').val();
    var event_end_date = $('#event_end_date').val();
    var event_description = $('#editor').html();
    event_description=event_description.trim();
    var event_term_condition = $('#event_term_condition').val();
    var event_tag = $('#event_tags').val();
    var event_category = $('#select_event_category').val();
    if($('#other_category').val()) {
        var event_sub_category = $('#other_category').val();
    }
    else {
        var event_sub_category = $('#select_event_sub_category').val();   
    }
    var ticket_name = $('#ticket_name').val();
    var ticket_quantity = $('#ticket_quantity').val();
    if($('#ticket_price').val()) {
    var ticket_price = $('#ticket_price').val();
    }
    else {
        var ticket_price = 0;
    }
    var payment_type = $('input[name=who_bare_payment]:checked', '#create_event_form').val();
    var button_show_type = $('input[name=button_type]:checked').val();
    var ticket_name2 = $('#ticket_name2').val();
    var ticket_quantity2 = $('#ticket_quantity2').val();
    var ticket_price2 = $('#ticket_price2').val();
    var ticket_name3 = $('#ticket_name3').val();
    var ticket_quantity3 = $('#ticket_quantity3').val();
    var ticket_price3 = $('#ticket_price3').val();
    var ticket_name4 = $('#ticket_name4').val();
    var ticket_quantity4 = $('#ticket_quantity4').val();
    var ticket_price4 = $('#ticket_price4').val();
    var ticket_name5 = $('#ticket_name5').val();
    var ticket_quantity5 = $('#ticket_quantity5').val();
    var ticket_price5 = $('#ticket_price5').val();
    var ticket_name6 = $('#ticket_name6').val();
    var ticket_quantity6 = $('#ticket_quantity6').val();
    var ticket_price6 = $('#ticket_price6').val();
    var ticket_name7 = $('#ticket_name7').val();
    var ticket_quantity7 = $('#ticket_quantity7').val();
    var ticket_price7 = $('#ticket_price7').val();
    var ticket_name8 = $('#ticket_name8').val();
    var ticket_quantity8 = $('#ticket_quantity8').val();
    var ticket_price8 = $('#ticket_price8').val();
    var ticket_name9 = $('#ticket_name9').val();
    var ticket_quantity9 = $('#ticket_quantity9').val();
    var ticket_price9 = $('#ticket_price9').val();
    
    $.ajax({
      type:'POST',
      url:'utility/handleEventCreation.php',
      data:{
        event_type:event_type,
        event_occurence:event_occurence,
        event_place_type:event_place_type,
        event_title:event_title,
        event_location:event_location,
        event_address:event_address,
        event_zip:event_zip,
        event_city:event_city,
        event_state:event_state,
        event_country:event_country,
        event_mobile:event_mobile,
        event_organization:event_organization,
        event_website:event_website,
        event_start_date:event_start_date,
        event_end_date:event_end_date,
        event_description:event_description,
        event_term_condition:event_term_condition,
        event_tag:event_tag,
        event_category:event_category,
        event_sub_category:event_sub_category,
        payment_type :payment_type,
        ticket_name:ticket_name,
        ticket_quantity:ticket_quantity,
        ticket_price:ticket_price,
        ticket_name2:ticket_name2,
        ticket_quantity2:ticket_quantity2,
        ticket_price2:ticket_price2,
        ticket_name3:ticket_name3,
        ticket_quantity3:ticket_quantity3,
        ticket_price3:ticket_price3,
        ticket_name4:ticket_name4,
        ticket_quantity4:ticket_quantity4,
        ticket_price4:ticket_price4,
        ticket_name5:ticket_name5,
        ticket_quantity5:ticket_quantity5,
        ticket_price5:ticket_price5,
        ticket_name6:ticket_name6,
        ticket_quantity6:ticket_quantity6,
        ticket_price6:ticket_price6,
        ticket_name7:ticket_name7,
        ticket_quantity7:ticket_quantity7,
        ticket_price7:ticket_price7,
        ticket_name8:ticket_name8,
        ticket_quantity8:ticket_quantity8,
        ticket_price8:ticket_price8,
        ticket_name9:ticket_name9,
        ticket_quantity9:ticket_quantity9,
        ticket_price9:ticket_price9,
        button_type:button_show_type
      },
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr);
        console.log(ajaxOptions);
        console.log(thrownError);
      },
      beforeSend: function(){
        $('#loader_text').text('Creating your Boovent Event');
        $('#loader-modal').modal('show');
      },
      success: function(data) {
        // Success
        alert(data);
        $('#loader-modal').modal('hide');
        //window.location.href = "index.php";
      }
      });
}

if (update_event!='') {
    $(".event_live_btn").hide();
    showForUpdateEventDetails();
    showForUpdateTicketDeatils();
    window.update_event=update_event
};
function showForUpdateEventDetails(){
    // alert(update_event);
    show_for_update_event=window.update_event;
    $.ajax({
        type:"POST",
        url:'utility/handleUserDashboard.php',
        data:{
        show_for_update_event:show_for_update_event
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
            // console.log(response);
            var d = JSON.parse(response);
            $('#editor').html(d[0].editor);
            $('#event_tags').val(d[0].event_tags);
            // alert(d[0].event_tags);
            // $("#event_tags").val('sssd,dsds');

            // $('#select_event_sub_category').val(d[0].select_event_sub_category);

            var result = $.parseJSON(response);//parse JSON
            // alert(result.editor);
            $.each(result, function(key, value){
                $.each(value, function(key, value){
                    // console.log(key, value);
                    $('#'+key).val(value);
                    // $('#'+key).html(value);
                    
                });
            });
            // $(".event_live_btn").val('Update Event');
            $(".event_live_btn").hide();
            $(".update_event_btn").show();

        }
    });
}

function showForUpdateTicketDeatils(){
    // alert(window.update_event);
    show_ticket_details="show_ticket_details";
    show_for_update_ticket=window.update_event;
    $.ajax({
        type:"POST",
        url:'utility/handleUserDashboard.php',
        data:{
        show_ticket_details:show_ticket_details,
        show_for_update_ticket:show_for_update_ticket
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
            // console.log(response);
            // $('#select_event_sub_category').val(d[0].select_event_sub_category);

            var result = $.parseJSON(response);//parse JSON
            // alert(result.editor);
            $.each(result, function(key, value){
                $.each(value, function(key, value){
                    console.log(key, value);
                    $('#'+key).val(value);
                    // $('#'+key).html(value);
                    
                });
            });

        }
    });
}
function updateEvent(){
    update_event=window.update_event;
    var event_place_type = $('input[name=event_type]:checked').val();
    var event_occurence = $('input[name=event_occurence]:checked').val();
    // alert(update_event);
    var event_type = event_pay_type;
    var event_title_update = $('#event_title').val();
    var event_location = $('#event_location').val();
    var event_address = $('#event_addres').val();
    var event_zip = $('#event_zip').val();
    var event_city = $('#event_city').val();
    var event_state = $('#event_state').val();
    var event_country = $('#event_country').val();
    var event_mobile = $('#event_organizer_mobile').val();
    var event_organization = $('#event_organizer_organization_name').val();
    var event_website = $('#event_website_url').val();
    var event_start_date = $('#event_start_date').val();
    var event_end_date = $('#event_end_date').val();
    var event_description = $('#editor').html();
    var event_term_condition = $('#event_term_condition').val();
    var event_tag = $('#event_tags').val();
    // event_tag=event_tag.replace(/,(?=[^,]*$)/, '');
    var event_category = $('#select_event_category').val();
    if($('#other_category').val()) {
        var event_sub_category = $('#other_category').val();
    }
    else {
        var event_sub_category = $('#select_event_sub_category').val();   
    }
    var ticket_name = $('#ticket_name').val();
    var ticket_quantity = $('#ticket_quantity').val();
    if($('#ticket_price').val()) {
    var ticket_price = $('#ticket_price').val();
    }
    else {
        var ticket_price = 0;
    }
    var payment_type = $('input[name=who_bare_payment]:checked', '#create_event_form').val();
    var ticket_name2 = $('#ticket_name2').val();
    var ticket_quantity2 = $('#ticket_quantity2').val();
    var ticket_price2 = $('#ticket_price2').val();
    var ticket_name3 = $('#ticket_name3').val();
    var ticket_quantity3 = $('#ticket_quantity3').val();
    var ticket_price3 = $('#ticket_price3').val();
    var ticket_name4 = $('#ticket_name4').val();
    var ticket_quantity4 = $('#ticket_quantity4').val();
    var ticket_price4 = $('#ticket_price4').val();
    var ticket_name5 = $('#ticket_name5').val();
    var ticket_quantity5 = $('#ticket_quantity5').val();
    var ticket_price5 = $('#ticket_price5').val();
    var ticket_name6 = $('#ticket_name6').val();
    var ticket_quantity6 = $('#ticket_quantity6').val();
    var ticket_price6 = $('#ticket_price6').val();
    var ticket_name7 = $('#ticket_name7').val();
    var ticket_quantity7 = $('#ticket_quantity7').val();
    var ticket_price7 = $('#ticket_price7').val();
    var ticket_name8 = $('#ticket_name8').val();
    var ticket_quantity8 = $('#ticket_quantity8').val();
    var ticket_price8 = $('#ticket_price8').val();
    var ticket_name9 = $('#ticket_name9').val();
    var ticket_quantity9 = $('#ticket_quantity9').val();
    var ticket_price9 = $('#ticket_price9').val();
    $.ajax({
      type:'POST',
      url:'utility/handleEventCreation.php',
      data:{
        update_event:update_event,
        event_place_type:event_place_type,
        event_occurence:event_occurence,
        event_type:event_type,
        event_title_update:event_title_update,
        event_location:event_location,
        event_address:event_address,
        event_zip:event_zip,
        event_city:event_city,
        event_state:event_state,
        event_country:event_country,
        event_mobile:event_mobile,
        event_organization:event_organization,
        event_website:event_website,
        event_start_date:event_start_date,
        event_end_date:event_end_date,
        event_description:event_description,
        event_term_condition:event_term_condition,
        event_tag:event_tag,
        event_category:event_category,
        event_sub_category:event_sub_category,
        payment_type :payment_type,
        ticket_name:ticket_name,
        ticket_quantity:ticket_quantity,
        ticket_price:ticket_price,
        ticket_name2:ticket_name2,
        ticket_quantity2:ticket_quantity2,
        ticket_price2:ticket_price2,
        ticket_name3:ticket_name3,
        ticket_quantity3:ticket_quantity3,
        ticket_price3:ticket_price3,
        ticket_name4:ticket_name4,
        ticket_quantity4:ticket_quantity4,
        ticket_price4:ticket_price4,
        ticket_name5:ticket_name5,
        ticket_quantity5:ticket_quantity5,
        ticket_price5:ticket_price5,
        ticket_name6:ticket_name6,
        ticket_quantity6:ticket_quantity6,
        ticket_price6:ticket_price6,
        ticket_name7:ticket_name7,
        ticket_quantity7:ticket_quantity7,
        ticket_price7:ticket_price7,
        ticket_name8:ticket_name8,
        ticket_quantity8:ticket_quantity8,
        ticket_price8:ticket_price8,
        ticket_name9:ticket_name9,
        ticket_quantity9:ticket_quantity9,
        ticket_price9:ticket_price9
      },
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr);
        console.log(ajaxOptions);
        console.log(thrownError);
      },
      beforeSend: function(){
        $('#loader_text').text('Updating your Boovent Event');
        $('#loader-modal').modal('show');
      },
      success: function(data) {
        $('#loader-modal').modal('hide');
        // Success
        $('#alert_text').text('Query :' + data);
        $('#alert-modal').modal('show');
      }
    });
}

</script>
<!-- bootstrap js for tags input -->
<script src="js/bootstrap-tagsinput.js"></script>