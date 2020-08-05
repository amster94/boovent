<?php
if(!isset($_SESSION))
{
    session_start();
}
if(isset($_POST['eventid'])) {
	//-------------------- IF SESSION ALREADY EXIST CLEAR IT ----------------------//
	if(isset($_SESSION['event'])){  
		unset($_SESSION['event']);
	}
	//------------------------- CREATE PRODUCT ARRAY -------------------------------//
	foreach($_POST as $key => $value){
        $new_event[$key] = filter_var($value, FILTER_SANITIZE_STRING); //create a new product array
    }
	//--------------------------- UPDATE EVENT DETAILS IN THE SESSION --------------------//
	$_SESSION['event'] = $new_event;
}

?>