<?php
include 'header.php'; // INCLUDING HEADER
//---------------- AMEY CODE --------------------------------------------//
if (!empty($_GET['id']) && !empty($_GET['proof'])) {
    $email=$_GET['id'];
    $name = $_GET['proof'];
    $condition_arr1= "";
    $condition_arr2= "";
    $condition_arr1 = array(":email",":name");
    $condition_arr2 = array($email,$name);
    $GetDetail=new BooventPDO();
    $get_user_sql = "SELECT * FROM boovent_user WHERE user_email = :email AND user_name=:name";
    $user_result=$GetDetail->selectQuery($get_user_sql,$condition_arr1,$condition_arr2);
    $max_size = sizeof($user_result);
    if($max_size > 0) {
      //----------------------- UPDATE EMAIL ACTIVE -----------------------------------//
      	$condition_arr1="";
    	$condition_arr2="";
    	$condition_arr1= array(":email"); 
    	$condition_arr2= array($email);
    	$UpdateUser=new BooventPDO();
    	$update_user_sql="UPDATE boovent_user SET email_activated = '1' WHERE user_email=:email";
    	$update_result = $UpdateUser->updateQuery($update_user_sql,$condition_arr1,$condition_arr2);
        if($update_result > 0) {
        	
        } else {
        	
        }
        unset($UpdateUser);
    } else {
      $error = "<p><center><h1>Cannot Activate Account.Please Try Again.</h1></center></p>";
    }
    unset($GetDetail);
  }
?>
<div class="container">
<?php if(!empty($error)) { ?>
<h2 class="text-center">Your Account cannot be verified.</h2>
<?php } else { ?>
   <h2 class="text-center">Your Account has been Activated.</h2>
<?php } ?>
</div>
<?php
include 'footer.php'; // INCLUDING FOOTER
?>