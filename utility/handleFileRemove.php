<?php 
require_once '../connect/class.booventpdo.php';
require_once '../functions/resize-image.php';
ini_set('display_errors',1);
if(!isset($_SESSION)){
    session_start();
}

if(isset($_POST['remove_profile_image'])) {
	$email = $_SESSION['user_email'];

	//----------------------- FETCH THE IMAGE PATH -------------------------------------------//
	$condition_arr1 = "";
	$condition_arr2 = "";
	$condition_arr1 = array(":email");
	$condition_arr2 = array($email);
	$Subscribe=new BooventPDO();
	$subscribe_sql="SELECT user_profile_pic FROM boovent_user WHERE user_email = :email";
	$subscribe_result=$Subscribe->selectQuery($subscribe_sql,$condition_arr1,$condition_arr2);
	$max_size = sizeof($subscribe_result);
	if($max_size >0) {
		//----------------------- UPDATE THE IMAGE PATH ------------------------------------//
		$condition_arr1 = "";
		$condition_arr2 = "";
		$condition_arr1 = array(":email",":pic");
		$condition_arr2 = array($email,"");
		$UpdateRemove = new BooventPDO();
		$remove_sql="UPDATE boovent_user SET user_profile_pic=:pic WHERE user_email = :email";
		$remove_result=$UpdateRemove->updateQuery($remove_sql,$condition_arr1,$condition_arr2);
		$max_size = sizeof($remove_result);
		if($max_size == 1) {
			//Success
		    $image = $subscribe_result[0]['user_profile_pic'];
		    $remove_string = PROFILE_IMAGE_PATH.$email."/";
		    $remove_image = str_replace($remove_string ,"",$image);
		    $old = getcwd(); // Save the current directory
		    chdir("../".PROFILE_IMAGE_PATH.$email);
		    unlink($remove_image);
			chdir($old); // Restore the old working directory
			echo "Successfully removed the Image";
		} else {
			echo "Fail to remove image. Please try again.";
		}

	}
	else {
	    echo "Fail";
	}
	unset($Subscribe);

}

?>