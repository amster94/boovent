<?php
session_start();
require_once( 'Facebook/autoload.php' );

$fb = new Facebook\Facebook([
  'app_id' => '164675907428320',
  'app_secret' => 'c67bfb1f61b4eba6556c8771da31aae4',
  'default_graph_version' => 'v2.10',
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions for more permission you need to send your application for review
$loginUrl = $helper->getLoginUrl('http://www.boovent.com/', $permissions);

header("location: ".$loginUrl);

?>