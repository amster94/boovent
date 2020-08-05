<?php 
require_once '../connect/class.booventpdo.php';
require_once '../functions/resize-image.php';
ini_set('display_errors',1);
if(!isset($_SESSION)){
    session_start();
}
$user_email=$_SESSION['user_email'];
$msg="";
if ( 0 < $_FILES['file']['error'] ) {
    echo 'Oops! Invalid file. File should be less then 3MB and jpg or png format.';
}else {
	$path = "../".PROFILE_URL.$_SESSION['user_email'];
	if (!is_dir($path)) {
    mkdir($path);
    }
    $temp = explode(".", $_FILES["file"]["name"]);
	$newfilename = date("dmY_his").'.' . end($temp);
	$img_address=PROFILE_URL.$_SESSION['user_email']."/". $newfilename;
	// if (strtolower(end($temp))=='jpg') {
		if (move_uploaded_file($_FILES['file']['tmp_name'],"../".$img_address)) {
		   		
				$resizeObj = new resize("../".$img_address);
				$resizeObj -> resizeImage(200, 200, 'exact');
				$resizeObj -> saveImage("../".$img_address, 1000);
		   	$user_profile_pic = new BooventPDO;
			$user_profile_pic_sql = "UPDATE boovent_user SET user_profile_pic=:user_profile_pic WHERE user_email = :email";
			$condition_arr1= array(":user_profile_pic", ":email");//SQL BINDPARAM 
			$condition_arr2= array($img_address, $user_email);//BINDPARAM VALUE
			$result=$user_profile_pic->updateQuery($user_profile_pic_sql, $condition_arr1, $condition_arr2);
			if ($result>0) {
				$msg="Profile Image Uploaded Successfully!";
			}else{
				$msg="Could not Upload the Profile Pic!";
			}
		}else{
		   	$msg= "Error Storing the Image. Please Try Again.";
		}
	// }else{
		// $msg="Please upload only .jpg file";
	// }	
	echo $msg;

}


?>