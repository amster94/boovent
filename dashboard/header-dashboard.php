<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- This file has been downloaded from Bootsnipp.com. Enjoy! -->
    <title>Boovent</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.png" />
    
    <!-- Font awesome import for getting fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <!-- // <script src="https://use.fontawesome.com/63a9dbe848.js"></script> -->
    <!-- Core boostrap -->
    <link href="../css/bootstrap3.3.0.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <!-- <link href="../css/mdb.min.css" rel="stylesheet"> -->
    <link href="../css/custom.css" rel="stylesheet">
    <!-- MEDIA QUERY OF EVERY CUSTOM.JS -->
    <link href="../css/media-query.css" rel="stylesheet">

    <!-- SCRIPTS -->
    
    <!-- JQuery -->
    <script type="text/javascript" src="../js/jquery-3.1.1.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="../js/tether.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="../js/bootstrap3.3.0.min.js"></script>
    <!-- for smooth  scroll on click button or link -->
    <script type="text/javascript" src="../js/jquery.easing.min.js" ></script>
    <!-- MDB core JavaScript -->
    <!-- // <script type="text/javascript" src="../js/mdb.min.js"></script> -->
    <script type="text/javascript" src="../js/custom.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $(this).scrollTop(0);
});
</script>  
</head>
<body>
<!-- add navbar-fixed-top for fixed nav -->
<div class="navbar navbar-default user_dashboard_nav" role="navigation">
    <div class="container-fluid"> 
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span> 
            </button>
            <a href="../index.php" class="navbar-brand"><img class="img-responsive" src="../images/logo.png"></a>
            <!-- <a href="index.php" class="navbar-brand"><span class="logo_b">B</span><span class="logo_oovent">boovent</span></a> -->
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user-circle fa-1x" aria-hidden="true"></i>
                        <!-- <strong>Salman</strong> -->
                        <i class="fa fa-angle-down fa-1x" aria-hidden="true"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="user-dashboard.php">My Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="organizer-dashboard.php">Dashboard</a></li>
                        <li class="divider"></li>
                        <li><a href="../utility/Logout.php">Sign Out <span class="pull-right"></span></a></li>
                    </ul>
                </li>
                <li><a href="../create-event.php">CREATE EVENT</a></li>
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
