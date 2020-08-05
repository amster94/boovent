<?php 
require_once '../connect/class.booventpdo.php';
require_once '../functions/resize-image.php';
require_once '../functions/compress-image.php';
ini_set('display_errors',1);
if(!isset($_SESSION)){
    session_start();
}
if ( 0 < $_FILES['file']['error'] ) {
    echo 'Oops! Invalid file. File should be less then 3MB and jpg or png format.';
}
else {
  //----------------- CHECK IF EVENT IMAGE SESSION SET -------------------------//
  if(isset($_SESSION['event_image'])) {
    unset($_SESSION['event_image']);
  }
  //---------------- CHECK USER DIRECTORY --------------------------------------//
  $path = "../".UPLOAD_URL.$_SESSION['user_email'];
  if (!is_dir($path)) {
    mkdir($path);
  }
  $temp = explode(".", $_FILES["file"]["name"]);
  $newfilename = date("dmY_his").'.' . end($temp);
	$img_address=UPLOAD_URL.$_SESSION['user_email']."/". $newfilename;
   if (move_uploaded_file($_FILES['file']['tmp_name'],'../'.$img_address)) {
    //--------------- SET EVENT IMAGE SESSION ----------------------------//
   	$_SESSION['event_image']=$img_address;

      $resizeObj = new resize('../'.$img_address);
      $resizeObj -> resizeImage(1600, 500, 'exact');
      $resizeObj -> saveImage('../'.$img_address, 1000);
      //COMPRESS THE IMAGE
      compress_image("../".$img_address, "../".$img_address, 70);
   	echo "Event Image Uploaded Successfully.";
   }else{
   	echo "Error Uploading Event Image.Please Try Again.";
   }
}

?>