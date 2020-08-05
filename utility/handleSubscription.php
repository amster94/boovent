<?php
require_once "../connect/class.booventpdo.php";
date_default_timezone_set('Asia/Kolkata');
if(isset($_POST['subscribe_email'])) {
	$email = $_POST['subscribe_email'];
	$ipaddress = getenv('REMOTE_ADDR');
	$current_date = date('Y-m-d h:i:s');
	//--------------------------- SUBSCRIBE EMAIL ---------------------------------//
	$condition_arr1 = "";
	$condition_arr2 = "";
	$condition_arr1 = array(":now",":ip",":email",":subscribe");
	$condition_arr2 = array($current_date,$ipaddress,$email,'1');
	$Subscribe=new BooventPDO();
	$subscribe_sql="INSERT INTO boovent_subscription(create_date,user_ip,user_email,is_subscribed) VALUES(:now,:ip,:email,:subscribe)";
	$subscribe_result=$Subscribe->insertQuery($subscribe_sql,$condition_arr1,$condition_arr2);
	$max_size = sizeof($subscribe_result);
	if($max_size >0) {
	    //Success
	    echo "Thanks for subscribing boovent.com";
	}
	else {
	    echo "Fail";
	}
	unset($Subscribe);
}

?>