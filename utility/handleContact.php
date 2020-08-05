<?php
require_once '../connect/class.booventpdo.php';
if(isset($_POST['email'])) {
	// ---------------------- INITIALIZE THE VARIABLE -------------------------------------//
	$name = $_POST['name'];
	$email = $_POST['email'];
	$message = $_POST['message'];
	//------------------------------ INSERT INTO CONTACT TABLE -----------------------------//
	$condition_arr1 = ""; 
	$condition_arr2 = "";
	$condition_arr1= array(":name",":email",":message");
    $condition_arr2= array($name,$email,$message);
    $BooventContact=new BooventPDO();
    $get_contact_sql="INSERT INTO boovent_contact(user_name,user_email,user_message) VALUES(:name,:email,:message)";
    $contact_result=$BooventContact->insertQuery($get_contact_sql,$condition_arr1,$condition_arr2);
    if($contact_result > 0) {
    	$msg = "Message received successfully.";
    } else {
    	$msg = "Fail";
    }
    echo $msg;
    unset($BooventContact);
}

?>