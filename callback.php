<?php
$title="Facebook Login - Boovent";
session_start();
if (isset($_SESSION['user_email'])) {
 header('Location: https://www.boovent.com');
}
require_once( 'Facebook/autoload.php' );

$fb = new Facebook\Facebook([
  'app_id' => '164675907428320',
  'app_secret' => 'c67bfb1f61b4eba6556c8771da31aae4',
  'default_graph_version' => 'v2.10',
]);  
  
$helper = $fb->getRedirectLoginHelper();  
  
try {  
  $accessToken = $helper->getAccessToken();  
} catch(Facebook\Exceptions\FacebookResponseException $e) {  
  // When Graph returns an error  
  
  // echo 'Graph returned an error: ' . $e->getMessage();  
  exit;  
} catch(Facebook\Exceptions\FacebookSDKException $e) {  
  // When validation fails or other local issues  

  echo 'Facebook SDK returned an error: ' . $e->getMessage();  
  exit;  
}  


try {
  // Get the Facebook\GraphNodes\GraphUser object for the current user.
  // If you provided a 'default_access_token', the '{access-token}' is optional.
  $response = $fb->get('/me?fields=id,name,email,first_name,last_name', $accessToken->getValue());
//  print_r($response);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  'ERROR: Graph ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  'ERROR: validation fails ' . $e->getMessage();
  exit;
}
$me = $response->getGraphUser();
// print_r($me);
// $user_fullname=$me->getProperty('name');
$user_firstname=$me->getProperty('first_name');
$user_lastname=$me->getProperty('last_name');
$user_email=$me->getProperty('email');
"Facebook ID: <a href='https://www.facebook.com/".$me->getProperty('id')."' target='_blank'>".$me->getProperty('id')."</a>";
$id=$me->getProperty('id');
echo $birthday = $me->getProperty('birthday');
$sex = $me->getProperty('gender');

$img = 'https://graph.facebook.com/'.$id.'/picture?width=200';

$name=$user_firstname.' '.$user_lastname;

$ipaddress = getenv('REMOTE_ADDR');

require_once 'connect/class.booventpdo.php';
/*---------------------------- EMAIL CHECK -----------------------------------------------*/
// print_r($_SESSION);

$dsn = 'mysql:host=localhost;dbname=boovent';
$db = new PDO($dsn, 'root', 'boov123');
$check_this_user="SELECT * FROM boovent_user WHERE user_email=:user_email";
$result=$db->prepare($check_this_user);
$result->bindParam(':user_email',$user_email);
$result->execute();
if ($result->rowCount()>0) {
  echo "This Email Already Exist!";
}else{
  $email_activated=1;
  $insert_this_user="INSERT INTO boovent_user(user_name, user_password, user_email, email_activated)
                    VALUES(:user_name, :user_password, :user_email, :email_activated)";
  $result=$db->prepare($insert_this_user);
  $result->bindParam(':user_name',$name);
  $result->bindParam(':user_password',$id);
  $result->bindParam(':user_email',$user_email);
  // $result->bindParam(':user_profile_pic',$img);
  $result->bindParam(':email_activated',$email_activated);
  $result->execute();
}
$_SESSION['user_email']=$user_email;

// header("location: index.php");
header('Location: https://www.boovent.com/');


?>
