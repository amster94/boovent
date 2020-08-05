<?php
require_once 'connect/class.booventpdo.php';
date_default_timezone_set('Asia/Kolkata');
ini_set('display_errors',0);
if(!isset($_SESSION))
{
    session_start();
}
// echo date("Y-m-d h:s:a");
if (!empty($share_image) AND $share_image=='Not Given') {
    $share_image=BASE_URL.EVENT_IMAGE;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- This file has been downloaded from Bootsnipp.com. Enjoy! -->
    <title>Boovent</title>
    <meta name = "googlebot" content= "noodp">
    <meta name="theme-color" content="#C10707">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="content-language" content="en">
    <meta http-equiv="Pragma" content="NO-CACHE">
    <meta name="msvalidate.01" content="16F84199A9F4DD4768547A74394951F1" />
    <meta http-equiv="Cache-Control" content="private, max-age=120, pre-check=5400">
    <meta http-equiv="Expires" content="<?php echo date(DATE_RFC822,strtotime("2 day")); ?>">
    
    <meta name="keywords" content="Make event easiy, boovent event, pune event">
    <meta name="description" content="Boovent provides an online event ticketing and registration platform. Through this platform people can create, search, share and book the events.">

    <meta name="author" content="boovent" />
    <meta name="company" content="boovent Pty. Ltd." />
    <meta name="copyright" content="&copy;2017 boovent.com" />
    <meta name="robots" content="index, follow" />
    <meta name="generator" content="boovent 1.0" />

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- FACEBOOK SHARING START -->
    <meta property="fb:app_id" content="<?php echo FB_APP_ID; ?>"/>
    <meta property="og:site_name" content="Boovent"/>
    <meta property="og:image" content="<?php echo $share_image; ?>"/>
    <meta property="og:title" content="<?php echo $share_event_title; ?>" />
    <meta property="og:description" content="<?php echo trim(strip_tags($share_event_description)); ?>" />
    <meta property="og:url" content="<?php echo $share_event_url; ?>"/>
    <meta property="og:type" content="events.event"/>
    <!-- FACEBOOK SHARING END -->

    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
    
    <!-- Font awesome import for getting fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <!-- // <script src="https://use.fontawesome.com/63a9dbe848.js"></script> -->
    <!-- Core boostrap -->
    <link href="css/bootstrap3.3.0.min.css" rel="stylesheet">
    <!-- date-time picker css -->
    <link href="css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen">
    <!-- Material Design Bootstrap -->
    <!-- <link href="css/mdb.min.css" rel="stylesheet"> -->
    <!-- jquery css -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    
    <link href="css/custom.css" rel="stylesheet">
    <!-- MEDIA QUERY OF EVERY CUSTOM.JS -->
    <link href="css/media-query.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <!-- SCRIPTS -->
    
    <!-- JQuery -->
    <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="js/tether.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="js/bootstrap3.3.0.min.js"></script>
    
    <!-- date-time picker js -->
    <script type="text/javascript" src="js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <script type="text/javascript" src="js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
    
    <!-- Jquery Ui js -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- for smooth  scroll on click button or link -->
    <script type="text/javascript" src="js/jquery.easing.min.js" ></script>
    <!-- MDB core JavaScript -->
    <!-- // <script type="text/javascript" src="js/mdb.min.js"></script> -->
    <script type="text/javascript" src="js/custom.js"></script>
    
<script type="text/javascript">
$(document).ready(function(){
    $(this).scrollTop(0);
});
</script> 
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

<!-- GOOGLE ADSENESE -->
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-6103599956934383",
    enable_page_level_ads: true
  });
</script>
</head>

<body>
<!-- add navbar-fixed-top for fixed nav -->
<div class="navbar navbar-default " role="navigation">
    <div class="container-fluid"> 
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span> 
            </button>
            <h1 class="navbar-brand"><a href="index.php"><img class="img-responsive" src="images/logo.png"></a></h1>
            <!-- <a href="index.php" class="navbar-brand"><span class="logo_b">B</span><span class="logo_oovent">boovent</span></a> -->
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="browse-event.php">BROWSE EVENTS</a></li>
                <?php if(isset($_SESSION['user_email']) && isset($_SESSION['user_email']) ) { 
                    $CheckEvent = new BooventPDO();
                    $condition_arr1= "";
                    $condition_arr2= "";
                    $condition_arr1 = array(":email");
                    $condition_arr2 = array($_SESSION['user_email']);
                    $check_event_sql = "SELECT event_title FROM boovent_events WHERE user_email = :email";
                    $check_result=$CheckEvent->selectQuery($check_event_sql,$condition_arr1,$condition_arr2);
                    $max_size = sizeof($check_result);
                ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user-circle fa-1x" aria-hidden="true"></i>
                        <!-- <strong>Salman</strong> -->
                        <i class="fa fa-angle-down fa-1x" aria-hidden="true"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="dashboard/user-dashboard.php">My Profile</a></li>
                        <li class="divider"></li>
                        <?php if($max_size > 0) { ?>
                        <li><a href="dashboard/organizer-dashboard.php">Dashboard</a></li>
                        <li class="divider"></li>
                        <?php } ?>
                        <li><a href="utility/Logout.php">Sign Out <span class="pull-right"></span></a></li>
                    </ul>
                </li>
                <li><a href="create-event.php">CREATE EVENT</a></li>
                <?php } else { ?>
                <li id="signup"><a data-toggle="modal" data-target="#login_signup_modal" href="#">SIGN UP</a></li>
                <li id="login"><a data-toggle="modal" data-target="#login_signup_modal" href="#">LOGIN</a></li>
                <li><a href="auth.php">CREATE EVENT</a></li>
                <?php } ?>
                <li><a target="_BLANK" href="http://blog.boovent.com/">BLOG</a></li>
            </ul>
        </div><!-- collapse navbar-collapse -->
    </div>
</div>


<script type="text/javascript">
$(document).ready(function(){
  // $('ul.nav li.dropdown').hover(function() {
  //     $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(200);
  //   }, function() {
  //     $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(200);
  //   });

  $("ul.nav li.dropdown").hover(            
        function() {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).slideDown("800");
            $(this).toggleClass('open');        
        },
        function() {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).slideUp("800");
            $(this).toggleClass('open');       
        }
    );
});
</script>
</html>
