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
//------------------ INITIALIZE THE VARIABLES -----------------------------------------//
$current_date=date('Y-m-d') ;
//----------------------- GET PURCHASED INFORMATION DETAILS -----------------------------------//
$condition_arr1 = "";
$condition_arr2 = "";
$condition_arr1= array(":email",":current_dates"); 
$condition_arr2= array($_SESSION['user_email'],$current_date);
$event_details = new BooventPDO;
// $user_info_sql = "SELECT boovent_purchase.*, boovent_events.* FROM boovent_purchase JOIN boovent_events ON boovent_purchase.user_email=:email AND boovent_purchase.event_id=boovent_events.event_id";
$user_info_sql = "SELECT boovent_purchase.*, boovent_events.*,DATE_FORMAT(boovent_events.event_start_date, '%W %M %e %r') as formatted_start_date,DATE_FORMAT(boovent_events.event_end_date, '%W %M %e %r') as formatted_end_date FROM boovent_purchase JOIN boovent_events ON boovent_purchase.event_id=boovent_events.event_id WHERE boovent_purchase.user_email=:email AND boovent_events.event_end_date >= :current_dates";
$show_purchased_event=$event_details->selectQuery($user_info_sql,$condition_arr1,$condition_arr2);
include 'header-dashboard.php';
?>
<!-- ==================== TAB MENU ========================= -->
<div class="container-fluid ">
<div class="row">
    <div class="tabbable-line tab_menu">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#user_profile" data-toggle="tab">My Profile</a>
			</li>
			<li>
				<a href="#user_change_password" data-toggle="tab">Password</a>
			</li>
			<li>
				<a href="#user_active_events" data-toggle="tab">Events</a>
			</li>
		</ul>
		<!-- <div class="container"></div> -->
		<div class="tab-content user_account" >
			<!-- USER PROFILE TAB -->
			<div class="tab-pane active" id="user_profile">
				<div class="col-md-8 col-md-offset-2 my_profile_main_box">
			        <div class="row">
			        	<!-- <h4><center>Profile Details</center></h4> -->
			            <div class="col-md-3 col-sm-12 col-xs-12 text-center">
			                <center><img id="user_profile_pic" src="" class="img-responsive img-thumbnail" alt="User Profile Pic"></center>
			            	<a class="top_1pt" data-toggle="modal" data-target="#upload_profile_pic_modal" href="javascript:void(0)">Change Photo</a>
			            	<div class="clearfix"></div>
			            	<a class="top_1pt" data-toggle="modal" data-target="#remove_profile_pic_modal" href="javascript:void(0)">Remove Photo</a>
			            </div>
			            
			            <div class="col-md-9 col-sm-12 col-xs-12">
			               <form action="" >
				               	<h3>Contact Information</h3>
	                            <div class="form-group top_5pt">
	                              <input type="text" id="user_name" name="user_name" class="user_name" required/>
	                              <span class="bar"></span>
	                              <span class="floating-label">Name</span>
	                            </div>
	                            <div class="form-group">
	                              <input type="number" id="user_contact_no" name="user_contact_no" class="user_contact_no" required/>
	                              <span class="bar"></span>
	                              <span class="floating-label">Contact No</span>
	                            </div>
	                            <h3>Address Details</h3>
	                            <div class="form-group top_5pt">
	                              <input type="text" id="user_address" name="user_address" class="user_address" required/>
	                              <span class="bar"></span>
	                              <span class="floating-label">Address</span>
	                            </div>
	                            <div class="form-group">
	                              <input type="text" id="user_city" name="user_city" class="user_city" required/>
	                              <span class="bar"></span>
	                              <span class="floating-label">City</span>
	                            </div>
	                            <div class="form-group">
	                              <input type="text" id="user_state" name="user_state" class="user_state" required/>
	                              <span class="bar"></span>
	                              <span class="floating-label">State</span>
	                            </div>
	                            <div class="form-group">
	                              <input type="number" id="user_zip_code" name="user_zip_code" class="user_zip_code" required/>
	                              <span class="bar"></span>
	                              <span class="floating-label">Zip Code</span>
	                            </div>

	                            <div class="form-group">
	                                <input onclick="updateDetails()" type="button" class="btn btn-primary" value="Save">
	                            </div>
                          </form> 
			            </div>
			        </div>
			    </div><!-- event_main_box -->
			</div>
			<!-- USER CHANGE PASSWORD TAB -->
			<div class="tab-pane" id="user_change_password">
				<div class="col-md-6 col-md-offset-3 change_pwd_main_box">
			        <div class="row">
			            <form action="" id="update_password" method="POST">
			            	<h3>Change Password</h3>
                            <div class="form-group top_5pt">
                              <input type="password" id="new_password" name="new_password" class="new_password" required/>
                              <span class="bar"></span>
                              <span class="floating-label">New Password</span>
                            </div>
                            <div class="form-group top_5pt">
                              <input type="password" id="confirm_password" name="confirm_password" class="confirm_password" required/>
                              <span class="bar"></span>
                              <span class="floating-label">Confirm Password</span>
                            </div>
                            <div class="form-group">
                                <input type="button"  class="btn btn-primary" value="Update Password" onclick="updatePassword();">
                            </div>
			            </form>
			        </div>
			    </div><!-- event_main_box -->
			</div>
			<!-- USER PURCHASED OR ACTIVE TAB -->
			<div class="tab-pane" id="user_active_events">
				<div class="col-md-12 ">
			        <div class="row">
			        	<h3 class="text-center">Active Events</h3><br>
			        	<div class="event_main_box">
				            <?php 
				            if(!empty($show_purchased_event)) {
				            foreach ($show_purchased_event as $rows) {
			            	$event_tags= $rows['event_tags']; 
          					$tags =explode(',', $event_tags); 
          					//------------ EVENT IMAGE -----------------------//
          					if(!empty($rows['event_image']) && $rows['event_image']!="Not Given" ) {
          						$event_image = "../".$rows['event_image'];
          					} else {
          						$event_image = "../".EVENT_IMAGE;
          					}
	          				?>
				            <div class="col-sm-6 col-md-4 event_box">
				                <div class="thumbnail">
				                  <img class="img-responsive" src="<?php echo $event_image; ?>" 
				                  alt="Boovent -<?php echo $rows['event_title']; ?>">
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
				                    <p class="top_2pt"><a target="_BLANK" href="<?php echo '../'. BASE_URL; ?>event-details.php?eid=<?php echo $rows['event_id']; ?>" class="btn btn-primary" role="button">View Details</a></p>
				                    <p class="event_tag">
			                    	<?php if(!empty($event_tags)) { foreach ($tags as $values) { ?>
					                <a href="browse-event.php?tag=<?php echo $values; ?>">
					                #<?php echo $values; ?>
					                </a>
					                <?php } } ?>
				                    </p>
				                  </div>
				                </div>
				            </div>
				            <?php } } else { 
				            	echo "<h3><center>No Active Registered Events for you.</center></h3>"; } ?>
			            </div>
			        </div>
			    </div><!-- event_main_box -->
			</div>
		</div>
	</div>
</div>
</div>

<!-- =========== BOOVENT MODAL DESIGN =============== -->
<div id="upload_profile_pic_modal" class="modal fade upload_profile_pic_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
                <h4 class="modal-title">Upload Profile Picture</h4>
            </div>
            <div class="modal-body">
            	<div class="row">
            		<div class="col-md-10 col-md-offset-1 profile_image">
	                    <div class="form-group files" >
	                        <input onchange="previewImage(event)" type="file" id="profile_pic" class="form-control">
	                    </div>
	                    <div id="preview_image"></div>
	                    <a id="cancel_upload" onclick="cancelUpload()" href="javascript:void(0)">Choose Other</a>
                	</div>
                	<p class="col-md-10 col-md-offset-1"><b>Note : </b><span class="input_notice">(image should  be less than 3Mb and 150X200.)</span></p>
                </div>
            </div>
            <div class="modal-footer">
                <input onclick="uploadFile()" type="button" class="btn btn-primary" value="SAVE" />
            </div>
        </div>
    </div>
</div>
<!-- <br><br> -->
<!-- =========== BOOVENT MODAL DESIGN =============== -->
<div id="remove_profile_pic_modal" class="modal fade remove_profile_pic_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
                <h4 class="modal-title">Remove Profile Picture</h4>
            </div>
            <div class="modal-body">
            	<div class="row">
            		<h3><p style="color:#FF0000;text-align: center;">You are about to remove your image.</p></h3>
                </div>
            </div>
            <div class="modal-footer">
                <input onclick="removeFile()" type="button" class="btn btn-primary" value="Yes Remove" />
            </div>
        </div>
    </div>
</div>
<!-- <br><br> -->
<?php
include '../footer.php'; // INCLUDING FOOTER
?>

<!-- ================ FILE UPLOAD SCRIPTS ================= -->
<script type='text/javascript'>
setInterval(function(){
	showProfilePic();
 }, 3000);
$('#cancel_upload').hide();
function previewImage(event) {

 var reader = new FileReader();
 reader.onload = function(){
    $('#preview_image').removeClass('files');
    $('.files').hide();
    $('#preview_image').html('<img class="" id="output_image"/>');
    $('#cancel_upload').show();

    var output = document.getElementById('output_image');
    output.src = reader.result;
 }
 reader.readAsDataURL(event.target.files[0]);
}
function uploadFile(){
    var file_data = $('#profile_pic').prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('file', file_data);                      
    $.ajax({
        url: '../utility/file-upload-profile-pic.php', 
        dataType: 'text', 
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
           	$('#loader_text').text('Please wait. Your profile pic is uploading..');
        	$('#loader-modal').modal('show');
        },
        success: function(data){
        	$('#loader-modal').modal('hide');
            $('#alert_text').text(data);
        	$('#alert-modal').modal('show'); 
            console.log(data+' done...');
           	showProfilePic(); 
        }
     });
    
}
function removeFile(){                     
    $.ajax({
    	type: 'POST',
        url: '../utility/handleFileRemove.php', 
        dataType: 'text',
        data: { remove_profile_image : 1 },                         
        error: function (xhr, ajaxOptions, thrownError) {
          console.log('wait...');
          console.log(xhr);
          console.log(ajaxOptions);
          console.log(thrownError);
        },
        beforeSend: function(){
           	$('#loader_text').text('Please wait. Removing your Profile picture..');
        	$('#loader-modal').modal('show');

        },
        success: function(data){
        	$('#remove_profile_pic_modal').modal('hide');
        	$('#loader-modal').modal('hide');
            $('#alert_text').text(data);
        	$('#alert-modal').modal('show'); 
            console.log(data+' done...');
           	showProfilePic(); 
        }
     });
    
}
function cancelUpload(){
    $('#cancel_upload').hide();
    $('#preview_image').html('');
    $('#preview_image').addClass('files');
    // $('#preview_image').html('<label>Upload Your Event Image</label><input id="profile_pic" onchange="previewImage(event)" type="file" class="form-control">');
	$('.files').show();
    $('#profile_pic').val('');
}
showProfilePic();
function showProfilePic(){
	var profile_pic="profile";
	$.ajax({
      type:'POST',
      url:'../utility/handleUserDashboard.php',
      data:{
        profile_pic : profile_pic
      },
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr);
        console.log(ajaxOptions);
        console.log(thrownError);
      },
      beforeSend: function(){
      },
      success: function(data) {
        if(data) {
        	$('#user_profile_pic').prop('src','../'+data);
    	}
    	else {
    		$('#user_profile_pic').prop('src','../images/user-profile-pic/1.jpg');
    	}
      }
      });
}
</script>
<script type='text/javascript'>
showProfileInfo();
function showProfileInfo(){
	var show_profile_info='show_profile_info';
	$.ajax({
		type:"POST",
		url:'../utility/handleUserDashboard.php',
		data:{
        show_profile_info:show_profile_info
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
		}
	});
}
function updateDetails() {
	var user_name = $('#user_name').val();
	
	var user_contact_no = $('#user_contact_no').val();
	var user_organization_name = $('#user_organization_name').val();
	var user_website = $('#user_website').val();
	var user_address = $('#user_address').val();
	var user_zip_code = $('#user_zip_code').val();
	var user_city = $('#user_city').val();
	var user_state = $('#user_state').val();
	// var user_country = $('#user_country').val();
	if(user_name && user_contact_no) {
	// alert( "Hi" + user_name );
	$.ajax({
      type:'POST',
      url:'../utility/handleUserDashboard.php',
      data:{
        user_name:user_name,
        user_contact_no:user_contact_no,
        user_organization_name:user_organization_name,
        user_website:user_website,
        user_address:user_address,
        user_zip_code:user_zip_code,
        user_city:user_city,
        user_state:user_state
        // user_country:user_country
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
        // alert("Profile Updated SuccessFully !");
        // window.location.href = "user-dashboard.php";
        showProfileInfo(); 
      }
      });
	}
	else {
		if(!user_name) {
			alert("Name cannot be empty");
		}
		else {
			alert("Contact cannot be empty");
		}
	}
}

function updatePassword() {
	var new_password = $('#new_password').val();
	var confirm_password = $('#confirm_password').val();
	if(new_password == confirm_password) {
	$.ajax({
      type:'POST',
      url:'../utility/handleUserDashboard.php',
      data:{
        password : new_password
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
        // window.location.href = "user-dashboard.php";
        
      }
      });
	}
	else {
		alert("Password and Confirm Password should Match !");
	}
}
</script>