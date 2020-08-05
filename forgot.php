<?php
require_once 'connect/class.booventpdo.php';
require_once 'functions/Base32.php';
use Base32\Base32;
ini_set('display_errors',1);
//------------------ INITIALIZE THE VARIABLES -----------------------------------------//
$current_date=date('Y-m-d') ;
if(isset($_GET['pass']) && !empty($_GET['pass'])) {
	$pass = $_GET['pass'];
	$email = Base32::decode($pass);
	//-------------------------- RUN THE QUERY ----------------------------------------//
	$condition_arr1="";
    $condition_arr2="";
    $condition_arr1= array(":user_email"); 
    $condition_arr2= array($email);
    $user_sql = "SELECT * FROM boovent_user WHERE user_email = :user_email AND email_activated='1' ";
    $UserDetails=new BooventPDO();
    $user_result=$UserDetails->selectQuery($user_sql,$condition_arr1,$condition_arr2);
    $max_size = sizeof($user_result);
    if($max_size > 0) {
    	$verified_email = $email;
    } else {
    	$home_url = BASE_URL. 'auth.php';
    	header('Location: ' . $home_url);
    }
} else {
	$home_url = BASE_URL. 'auth.php';
    header('Location: ' . $home_url);
}
include 'header.php';
?>
<!-- ==================== TAB MENU ========================= -->
<div class="container-fluid ">
<div class="row">
    <div class="tabbable-line tab_menu">
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
	</div>
</div>
</div>
<?php
include 'footer.php'; // INCLUDING FOOTER
?>
<script type='text/javascript'>
function updatePassword() {
	var new_password = $('#new_password').val();
	var confirm_password = $('#confirm_password').val();
	var email = "<?php echo $verified_email; ?>";
	if(new_password == confirm_password) {
	$.ajax({
      type:'POST',
      url:'utility/handleUserDashboard.php',
      data:{
      	email : email,
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
        
        $('#alert-modal').modal('show');
        $('#alert_text').text(data);
        // window.location.href = "user-dashboard.php";
        
      }
      });
	}
	else {
		// alert("Password and Confirm Password should Match !");
    $('#alert-modal').modal('show');
    $('#alert_text').text('Password and Confirm Password should Match !');
	}
}
</script>