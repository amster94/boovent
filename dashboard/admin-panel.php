<?php 
require_once '../connect/class.booventpdo.php';
date_default_timezone_set('Asia/Kolkata');
ini_set('display_errors',0);
if(!isset($_SESSION)){
    session_start();
}
if (isset($_SESSION['user_email'])) {
    if ($_SESSION['user_email']!=ADMIN_LOGIN_EMAIL) {
      $home_url = BASE_URL.'404.php';
      header('Location: ' . $home_url);
    }
    
}else{
  $home_url = BASE_URL.'auth.php';
  header('Location: ' . $home_url);
}
?>
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
    <!-- custom css  -->
    <script type="text/javascript" src="../js/custom.js"></script>
    
<style type="text/css">
  body{background-color: #ecf0f1;}

  .navbar-inverse {
      background-color: #2C3E50;
      border-color: #2C3E50;
  }

  .navbar {
      position: relative;
      min-height: 50px;
      margin-bottom: 0px;
      border: 0px solid transparent;
  }
  .navbar-nav > li > a {
      padding-top: 20px;
      padding-bottom: 10px;
      line-height: 20px;
  }
  @media (min-width: 768px){

  .navbar {
      border-radius: 0px;
  }}

  .navbar-brand {
      float: left;
      height: auto;
      padding: 15px 15px;
      font-size: 18px;
      line-height: 20px;
  }
  .sidebar-toggle {
      color: #fff;
      font-size: 28px;
      display: inline-block;
      padding: 3px 22px;
  }
  @media (min-width:768px){
  .container-1{width:15%;float:left;}
  .container-2{width:100%;float: left;}
  }

  @media (max-width:768px){
  .container-1{width:100%;}
  .container-2{width:100%;}
  }
  .container-1:after,
  .container-2:before,
  {
    display: table;
    content: " ";
  }
  .container-1:after,
  .container-2:after,
  {clear: both;}

  .container-1{display: none;}
  /*navbar-right=====START==========*/

  .social-icon{margin:0px;padding:0px;}
  .social-icon li {margin: 0px;padding: 0px;list-style-type: none;}
  .social-icon li a {
      display: block;
      padding: 15px 14px;
      text-decoration:none;
  }
  .social-icon li a:focus{
     color:#fff;
      text-decoration:none;
  }

  .messages-link{
          color: #fff !important;
      background: #16a085 !important;

  }

  .alerts-link{
          color: #fff !important;
      background: #f39c12 !important;

  }

  .tasks-link{
          color: #fff !important;
      background: #2980b9 !important;

  }

  .user-link{
          color: #fff !important;
      background: #E74C3C !important;

  }
   .number {
      position: absolute;
      bottom: 25px;
      left: 3px;
      width: 20px;
      height: 20px;
      padding-right: 1px;
      border-radius: 50%;
      text-align: center;
      font-size: 11px;
      line-height: 20px;
      background-color: #2c3e50;
  }

  .dropdown-menu {
      position: absolute;
      top: 100%;
      left: -105px;
      z-index: 1000;
      display: none;
      float: left;
      min-width: 160px;
      padding: 5px 0;
      margin: 2px 0 0;
      font-size: 14px;
      text-align: left;
      list-style: none;
      background-color: #fff;
      -webkit-background-clip: padding-box;
      background-clip: padding-box;
      border: 1px solid #ccc;
      border: 1px solid rgba(0, 0, 0, .15);
      border-radius: 4px;
      -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
      box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
  }
  /*navbar-right=======END========*/

  /*sidebar-toggle=============*/
  .sidebar-toggle:hover, .sidebar-toggle:focus {
      color: #fff;
      text-decoration: underline;
  }


  /*sidr-NAVBAR=======START========*/
  .navbar-nav-1{width: 100%;background-color:#34495E;height:auto;overflow: hidden;z-index: 1020;position: relative;}

  .side-user {
      display: block;
      width: 100%;
      padding: 15px;
      border-top: none !important;
      border-bottom: 1px solid #142638;
      text-align: center;
  }
  .close-btn {
      position: absolute;
      z-index: 99;
      color: #fff;
      font-size: 31px;
      top: 0px;
      left: 223px;    
      display: none;
      padding: 0px;
      cursor: pointer;
  }
  .close-btn .fa-window-close{color:#fff;font-size: 25px;}
  .welcome {
      margin: 0;
      font-style: italic;
      color: #9aa4af;
  }

  .name {
      margin: 0;
      font-family: "Ubuntu","Helvetica Neue",Helvetica,Arial,sans-serif;
      font-size: 20px;
      font-weight: 300;
      color: #ccd1d7;
  }
  .side-user a{
     color:#fff;
  }
  .nav-search{border-top: 1px solid #54677a;}
  .nav-search .form-control{border: 1px solid #000;border-radius: 0px;}
  .nav-search .btn{border: 1px solid #000;border-radius: 0px;}

  .dashboard>a{
      color:#fff;
      }
  .side-nav li {
      border-top: 1px solid #54677a;
      border-bottom: 1px solid #142638;
  }

  .side-nav>li>a:active {
      text-shadow: 1px 1px 1px rgba(0,0,0,0.1);
      outline: none;
      color: #fff;
      background-color: #34495e;
  }

  .panel {
      margin-bottom: 0;
      border: none;
      border-radius: 0;
      background-color: transparent;
      box-shadow: none;
  }

  .panel>a{
      position: relative;
      display: block;
      padding: 10px 15px;
      color: #fff;
  }

  .panel>ul>li>a {
      position: relative;
      display: block;
      padding: 10px 15px;
      color: darkcyan;
      background: black;
  }
  .nav > li > a:hover, .nav > li > a:focus {
      text-decoration: none;
      background-color: #3d566e;
  }
  /*sidr-NAVBAR=======END========*/
  @media (min-width: 768px){

  #page-wrapper {
     
      padding: 0 30px;
      min-height: 1300px;
      border-left: 1px solid #2c3e50;
  }
  }

  #page-wrapper {
      padding: 0 15px;
      border: none;
      
  }

  .date-picker{    
      border-color: #138871;
      color: #fff;
      background-color: #149077;
      margin-top: -7px;
      border-radius: 0px;
      margin-right: -15px;
  }

  #page-wrapper .breadcrumb {
      padding: 8px 15px;
      margin-bottom: 20px;
      list-style: none;
      background-color: #e0e7e8;
      border-radius: 0px;
      
  }




  @media (min-width: 768px){
  .circle-tile {
      margin-bottom: 30px;
  }
  }

  .circle-tile {
      margin-bottom: 15px;
      text-align: center;
  }

  .circle-tile-heading {
      position: relative;
      width: 80px;
      height: 80px;
      margin: 0 auto -40px;
      border: 3px solid rgba(255,255,255,0.3);
      border-radius: 100%;
      color: #fff;
      transition: all ease-in-out .3s;
  }

  /* -- Background Helper Classes */

  /* Use these to cuztomize the background color of a div. These are used along with tiles, or any other div you want to customize. */

   .dark-blue {
      background-color: #34495e;
  }

  .green {
      background-color: #16a085;
  }

  .blue {
      background-color: #2980b9;
  }

  .orange {
      background-color: #f39c12;
  }

  .red {
      background-color: #e74c3c;
  }

  .purple {
      background-color: #8e44ad;
  }

  .dark-gray {
      background-color: #7f8c8d;
  }

  .gray {
      background-color: #95a5a6;
  }

  .light-gray {
      background-color: #bdc3c7;
  }

  .yellow {
      background-color: #f1c40f;
  }

  /* -- Text Color Helper Classes */

   .text-dark-blue {
      color: #34495e;
  }

  .text-green {
      color: #16a085;
  }

  .text-blue {
      color: #2980b9;
  }

  .text-orange {
      color: #f39c12;
  }

  .text-red {
      color: #e74c3c;
  }

  .text-purple {
      color: #8e44ad;
  }

  .text-faded {
      color: rgba(255,255,255,0.7);
  }



  .circle-tile-heading .fa {
      line-height: 80px;
  }

  .circle-tile-content {
      padding-top: 50px;
  }
  .circle-tile-description {
      text-transform: uppercase;
  }

  .text-faded {
      color: rgba(255,255,255,0.7);
  }

  .circle-tile-number {
      padding: 5px 0 15px;
      font-size: 26px;
      font-weight: 700;
      line-height: 1;
  }

  .circle-tile-footer {
      display: block;
      padding: 5px;
      color: rgba(255,255,255,0.5);
      background-color: rgba(0,0,0,0.1);
      transition: all ease-in-out .3s;
  }

  .circle-tile-footer:hover {
      text-decoration: none;
      color: rgba(255,255,255,0.5);
      background-color: rgba(0,0,0,0.2);
  }

  #datetime{color:#fff;}
.event_box_admin .thumbnail{
  width: 260px;
}
</style>
<?php 
// require_once '../connect/class.booventpdo.php';
// ini_set('display_errors',0);
// if(!isset($_SESSION)){
//     session_start();
// }
// $user_email=$_SESSION['user_email'];

?>
 
<!--========================================================================================
             NAVIGATION
=========================================================================================-->
    
<!--top nav start=======-->
<nav class="navbar navbar-inverse top-navbar" id="top-nav">
  <div class="container-fluid">
    <div class="navbar-header">      
      <a class="navbar-brand" href="<?php echo BASE_URL; ?>"><img class="img-responsive" src="../images/logo.png" width="150" height="20"></a>
    </div>
      
    <!-- <ul class="social-icon pull-right list-inline">
      <li class="dropdown">
          <a class="messages-link dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-envelope"></span>
            <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Page 1-1</a></li>
            <li><a href="#">Page 1-2</a></li>
            <li><a href="#">Page 1-3</a></li>
          </ul>
        </li>
    </ul> -->       
  </div>  
</nav>    
<!--    top nav end ===========-->

<!-- ========================= BIGIN MAIN CONTENT DIV ============================== -->
<div class="container-2">
  <div id="page-wrapper">   
    <div class="row">
     <div class="col-md-12">
      <div class="page-title">
       <h2>ADMIN<small>boovent</small></h2>
        <ol class="breadcrumb">
         <li class="active"><i class="fa fa-dashboard"></i> Dashboard</li>
          <li class="pull-right">
           <div id="reportrange" class="btn btn-green btn-square date-picker">
            <i class="fa fa-calendar"></i>
             <span class="date-range"><?php echo date("l jS \of F Y h:i:s A"); ?></span>
           </div>
          </li>
        </ol>
       </div>
      </div>
    </div> <!-- row -->
                                               
    <div class="row" >
      <div class="col-md-3  col-sm-6">
          <div class="circle-tile">
              <div class="circle-tile-heading dark-blue">
                  <i class="fa fa-users fa-fw fa-3x"></i>
              </div>
              <div class="circle-tile-content dark-blue">
                  <div class="circle-tile-description text-faded">
                      ORGANIZERS
                  </div>
                  <div class="circle-tile-number text-faded">
                      <span id="total_organizers">0</span>
                  </div>
                  <a href="#organizer_detail" data-toggle="tab" class="circle-tile-footer">SHOW ALL <i class="fa fa-chevron-circle-right"></i></a>
              </div>
          </div>
      </div>
      <div class="col-md-3  col-sm-6">
          <div class="circle-tile">
              <div class="circle-tile-heading green">
                  <i class="fa fa-users fa-fw fa-3x"></i>
              </div>
              <div class="circle-tile-content green">
                  <div class="circle-tile-description text-faded">
                      USERS
                  </div>
                  <div class="circle-tile-number text-faded">
                      <span id="total_users">0</span>
                  </div>
                  <a href="#all_users_detail" data-toggle="tab" class="circle-tile-footer">SHOW ALL <i class="fa fa-chevron-circle-right"></i></a>
              </div>
          </div>
      </div>
      <div class="col-md-3  col-sm-6">
          <div class="circle-tile">
              <div class="circle-tile-heading orange">
                  <i class="fa fa-bell fa-fw fa-3x"></i>
              </div>
              <div class="circle-tile-content orange">
                  <div class="circle-tile-description text-faded">
                      TOTAL EVENTS
                  </div>
                  <div class="circle-tile-number text-faded">
                      <span id="total_events">0</span>
                  </div>
                  <a href="#all_events_detail" data-toggle="tab" class="circle-tile-footer">SHOW ALL <i class="fa fa-chevron-circle-right"></i></a>
              </div>
          </div>
      </div>
      <div class="col-md-3  col-sm-6">
          <div class="circle-tile">
              <div class="circle-tile-heading blue">
                  <i class="fa fa-tasks fa-fw fa-3x"></i>
              </div>
              <div class="circle-tile-content blue">
                  <div class="circle-tile-description text-faded">
                    Pending Tasks
                  </div>
                  <div class="circle-tile-number text-faded">
                      <span id="pending_events">0</span>
                  </div>
                  <a href="#all_pending_events" data-toggle="tab" class="circle-tile-footer">SHOW ALL <i class="fa fa-chevron-circle-right"></i></a>
              </div>
          </div>
      </div>
    </div> <!-- row -->
<!-- ============== MAIN TAB CONTENT BLOCK ===================================== -->
  <div class="tab-content user_account" >
    <!-- ALL ORGANIZER DETAILS TAB -->
    <div class="tab-pane active" id="organizer_detail">
      <h3>ORGANIZER DETAILS</h3>
      <!-- FILTER BY OWN CUSTOMIZATION -->
      <div class="form-group row">
        <div class="col-md-4 col-md-offset-4">
          <input type="search" id="" class="boovent-table-filter form-control" data-table="filter-table-organizer" placeholder="Search Custom User by any key...">
        </div>
      </div><!-- form-group -->
      <div class="table-responsive">
        <table class="filter-table-organizer table  table-striped table-hover">
          <thead class="thead-inverse">
            <tr>
              <th>Sl. No.</th>
              <th>Name</th>
              <th>Email</th>
              <th>Contact</th>
              <th>Join Date</th>
              <th>Address</th>
              <th>Zip</th>
              <th>City</th>
              <th>State</th>
              <th>Bank Details</th>
              <th>Action</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody class="table-striped" id="organizers_list">
          
          </tbody>
        </table>
      </div> <!--   table-responsive -->
    </div>
    <!-- ALL GENERAL USER DETAILS TAB -->
    <div class="tab-pane" id="all_users_detail">
      <h3>GENERAL USERS DETAILS</h3>
      <!-- FILTER BY OWN CUSTOMIZATION -->
      <div class="form-group row">
        <div class="col-md-4 col-md-offset-4">
          <input type="search" id="" class="boovent-table-filter form-control" data-table="filter-table-general-user" placeholder="Search Custom User by any key...">
        </div>
      </div><!-- form-group -->
      <div class="table-responsive">
        <table class="filter-table-general-user table  table-striped table-hover">
          <thead class="thead-inverse">
            <tr>
              <th>SL. No.</th>
              <th>Name</th>
              <th>Email</th>
              <th>Contact</th>
              <th>Action</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody class="table-striped" id="all_users"></tbody>
        </table>
      </div> <!--   table-responsive -->
    </div>
    <!-- ALL EVENT DETAILS TAB -->
    <div class="tab-pane" id="all_events_detail">
      <h3>ALL EVENTS</h3>
      <!-- FILTER BY OWN CUSTOMIZATION -->
      <div class="form-group row">
        <div class="col-md-4 col-md-offset-4">
          <input type="search" id="" class="boovent-table-filter form-control" data-table="filter-table-all-event" placeholder="Search Custom User by any key...">
        </div>
      </div><!-- form-group -->
      <div class="table-responsive">
        <table class="filter-table-all-event table  table-striped table-hover">
          <thead class="thead-inverse">
            <tr>
              <th>SL. No.</th>
              <th>Create Date</th>
              <th>Event Id</th>
              <th>Event Title</th>
              <th>Boovent <br>Charge(Rs)</th>
              <th colspan="2">Action</th>
              <th>QTY. Sold</th>
              <th>Organizer Name</th>
              <th>Contact</th>
              <th>Email</th>
            </tr>
          </thead>
          <tbody class="table-striped" id="live_event_detail"></tbody>
        </table>
      </div> <!--   table-responsive -->
    </div>
    <!-- ALL OTHER PENDING TASKS TAB -->
    <div class="tab-pane" id="all_pending_events">
      <h3>ALL PENDING EVENTS</h3>
      <!-- FILTER BY OWN CUSTOMIZATION -->
      <div class="form-group row">
        <div class="col-md-4 col-md-offset-4">
          <input type="search" id="" class="boovent-table-filter form-control" data-table="filter-table-all-pending-events" placeholder="Search Custom User by any key...">
        </div>
      </div><!-- form-group -->
      <div class="col-md-12 event_main_box ">
        <div class="row" id="inactive_events">
            
        </div>
      </div><!-- event_main_box -->
    </div>
  </div>  
  </div><!-- page-wrapper END-->
</div><!-- container-2 END-->
<!-- ========================= END MAIN CONTENT DIV ============================== -->

<!-- ========================= ORGANIZER'S BANK DETAILS MODAL =================================== -->
<div id="organizers_bank_detail_modal" class="modal fade organizers_bank_detail_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
          <h4 class="modal-title">Organizer's Bank Details</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-8 col-md-offset-2" id="organizer_bank_detail_body">
            
          </div>
        </div>
      </div>
      <div class="modal-footer">
          <input type="button" class="btn btn-primary col-md-3 pull-right" data-dismiss="modal" value="OK" />
      </div>
    </div>
  </div>
</div><!-- organizers_bank_detail_modal -->

<!-- ========================= EVENT DETAILS MODAL =================================== -->
<div id="organizers_event_detail_modal" class="modal fade organizers_event_detail_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
          <h4 class="modal-title">Event Details</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">
            <div class="event_description" id="event_details">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
          <input type="button" class="btn btn-primary col-md-3 pull-right" data-dismiss="modal" value="OK" />
      </div>
    </div>
  </div>
</div><!-- organizers_event_detail_modal -->

<!-- ========================= EVENT DETAILS MODAL =================================== -->
<div id="event_purchase_detail_modal" class="modal fade event_purchase_detail_modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
          <h4 class="modal-title">Event Purchase Detail</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-10 col-md-offset-1">
            <div class="table-responsive">
              <table id="filter-table-organizer" class="filter-table-organizer table  table-striped table-hover">
                <thead class="thead-inverse">
                  <tr>
                    <th>Sl. No.</th>
                    <th>Order Id</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Purchase Date</th>
                    <th>Ticket No.</th>
                    <th>QTY.</th>
                    <th>Ticket Type</th>
                    <th>Paid(INR)</th>
                  </tr>
                </thead>
                <tbody class="table-striped" id="event_purchase_detail">
                </tbody>
              </table>
            </div> <!--   table-responsive -->
          </div>
        </div>
      </div>
      <div class="modal-footer">
          <input onclick="exportToExcel('filter-table-organizer')" type="button" class="btn btn-primary col-md-3 " value="Export to Excel" />
          <input type="button" class="btn btn-primary col-md-3 pull-right" data-dismiss="modal" value="OK" />
      </div>
    </div>
  </div>
</div><!-- event_purchase_detail_modal -->
<!-- ===================== ALL JAVASCRIPT START HERE ============================================================ -->
<script type="text/javascript">
  $(document).ready(function(){
      // $("#admin-left-nav").show();
      $(".sidebar-toggle").click(function(){
        $(this).hide();
        $("#admin-left-nav").show();
        $("#hide-btn").show();
        $(".container-2").css("width", "85%");
      });
      
      $("#hide-btn").click(function(){
        $(this).hide();
        $("#admin-left-nav").hide();
        $(".sidebar-toggle").show();
        $(".container-2").css("width", "100%");
      });

    setInterval(function(){
      showLiveBooventStatus();
      showAllOrganizersDetails();
      showAllUserDetails();
      showAllEventDetails();
      showInactiveEventDetails();
    }, 5000);
  });
</script>
<script type="text/javascript">
// SHOW BOOVENT STATUS
showLiveBooventStatus();
function showLiveBooventStatus(){
  var show_live_boovent_status='show_live_boovent_status';
  $.ajax({
    type:"POST",
    url:'../utility/handle-admin-dashboard.php',
    data:{
        show_live_boovent_status:show_live_boovent_status
        },
    cache:false,
    error: function (xhr, ajaxOptions, thrownError) {
          console.log(xhr);
          console.log(ajaxOptions);
          console.log(thrownError);
      },
    beforeSend: function(){
      },
    success:function(response) {
    // alert(response);
    var result = $.parseJSON(response);//parse JSON
    $.each(result, function(key, value){
        $.each(value, function(key, value){
            console.log(key, value);
            $('#'+key).text(value);
            // alert(key)

        });
    });
    }
  });
}
// SHOW ALL ORGANIZERS DETAILS
showAllOrganizersDetails();
function showAllOrganizersDetails(){
  var show_organizer_details='show_organizer_details';

  $.ajax({
    type:'POST',
    url:'../utility/handle-admin-dashboard.php',
    data:{
      show_organizer_details:show_organizer_details
    },
    error: function (xhr, ajaxOptions, thrownError) {
      console.log(xhr);
      console.log(ajaxOptions);
      console.log(thrownError);
    },
    beforeSend: function(){
        // alert("Sending Data..");
    },
    success: function(data) {
      // alert(data);
      $('#organizers_list').text('');
      $('#organizers_list').append(data); 
    }
  });
}

// SHOW ORGANIZERS BANK DETAILS ON MODAL
function showOrganizerBankDetail(organizer_email){
  var organizer_email=organizer_email;
  // alert(event_id_for_show_detail);
  $.ajax({
    type:'POST',
    url:'../utility/handle-admin-dashboard.php',
    data:{
      organizer_email_for_bank_detail:organizer_email
    },
    error: function (xhr, ajaxOptions, thrownError) {
      console.log(xhr);
      console.log(ajaxOptions);
      console.log(thrownError);
    },
    beforeSend: function(){
        // alert("Sending Data..");
    },
    success: function(data) {
      // alert(data);
      $('#organizer_bank_detail_body').text('');
      $('#organizer_bank_detail_body').append(data); 
    }
  });
}

// SHOW ALL USERS DETAILS
showAllUserDetails();
function showAllUserDetails(){
  var user_details='user_details';

  $.ajax({
    type:'POST',
    url:'../utility/handle-admin-dashboard.php',
    data:{
      user_details:user_details
    },
    error: function (xhr, ajaxOptions, thrownError) {
      console.log(xhr);
      console.log(ajaxOptions);
      console.log(thrownError);
    },
    beforeSend: function(){
        // alert("Sending Data..");
    },
    success: function(data) {
      // alert(data);
      $('#all_users').text('');
      $('#all_users').append(data); 
    }
  });
}

// DELETE USER USING EMAIL ID 
function deleteUser(delete_user){
  // alert('delete'+delete_user);
  var delete_user=delete_user;
  $.ajax({
    type:'POST',
    url:'../utility/handle-admin-dashboard.php',
    data:{
      delete_user:delete_user
    },
    error: function (xhr, ajaxOptions, thrownError) {
      console.log(xhr);
      console.log(ajaxOptions);
      console.log(thrownError);
    },
    beforeSend: function(){
        // alert("Sending Data..");
    },
    success: function(data) {
      alert(data);
      showAllUserDetails();
      showAllOrganizersDetails();
    }
  });
}

// SHOW ALL LIVE EVENTS DETAILS
showAllEventDetails();
function showAllEventDetails(){
  var live_event_detail='live_event_detail';

  $.ajax({
    type:'POST',
    url:'../utility/handle-admin-dashboard.php',
    data:{
      live_event_detail:live_event_detail
    },
    error: function (xhr, ajaxOptions, thrownError) {
      console.log(xhr);
      console.log(ajaxOptions);
      console.log(thrownError);
    },
    beforeSend: function(){
        // alert("Sending Data..");
    },
    success: function(data) {
      // alert(data);
      $('#live_event_detail').text('');
      $('#live_event_detail').append(data); 
    }
  });
}

// SHOW ALL NOT LIVE(INACTIVE) EVENTS DETAILS
showInactiveEventDetails();
function showInactiveEventDetails(){
  var not_live_event_detail='not_live_event_detail';

  $.ajax({
    type:'POST',
    url:'../utility/handle-admin-dashboard.php',
    data:{
      not_live_event_detail:not_live_event_detail
    },
    error: function (xhr, ajaxOptions, thrownError) {
      console.log(xhr);
      console.log(ajaxOptions);
      console.log(thrownError);
    },
    beforeSend: function(){
        // alert("Sending Data..");
    },
    success: function(data) {
      // alert(data);
      $('#inactive_events').text('');
      $('#inactive_events').append(data); 
    }
  });
}
function aproveEvent(evnet_id){
  // alert(evnet_id);
  var update_event_id=evnet_id;
  $.ajax({
    type:'POST',
    url:'../utility/handle-admin-dashboard.php',
    data:{
      update_event_id:update_event_id
    },
    error: function (xhr, ajaxOptions, thrownError) {
      console.log(xhr);
      console.log(ajaxOptions);
      console.log(thrownError);
    },
    beforeSend: function(){
        // alert("Sending Data..");
    },
    success: function(data) {
      alert(data);
      showInactiveEventDetails();
      showAllEventDetails();
    }
  });
}
// SHOW EVENT DETAIL THAT IS NOT LIVE
function showEventDetail(event_id){
  var event_id_for_show_detail=event_id;
  // alert(event_id_for_show_detail);
  $.ajax({
    type:'POST',
    url:'../utility/handle-admin-dashboard.php',
    data:{
      event_id_for_show_detail:event_id_for_show_detail
    },
    error: function (xhr, ajaxOptions, thrownError) {
      console.log(xhr);
      console.log(ajaxOptions);
      console.log(thrownError);
    },
    beforeSend: function(){
        // alert("Sending Data..");
    },
    success: function(data) {
      // alert(data);
      $('#event_details').text('');
      $('#event_details').append(data); 
    }
  });
}

//SHOW TICKET PURCHASE DETAILS
function showTicketPurchaseDetail(event_id){
  var event_id_for_show_purchase_detail=event_id;
  // $('#event_purchase_detail_modal').modal('show');

  $.ajax({
    type:'POST',
    url:'../utility/handle-admin-dashboard.php',
    data:{
      event_id_for_show_purchase_detail:event_id_for_show_purchase_detail
    },
    error: function (xhr, ajaxOptions, thrownError) {
      console.log(xhr);
      console.log(ajaxOptions);
      console.log(thrownError);
    },
    beforeSend: function(){
        // alert("Sending Data..");
    },
    success: function(data) {
      $('#event_purchase_detail_modal').modal('show');
      $('#event_purchase_detail').text('');
      $('#event_purchase_detail').append(data); 
    }
  });
}

// DELETE THIS EVENT
function deleteThisEvent(event_id){
  var delete_this_event=event_id;
  var r = confirm("Are realy want to delete this event!");
  if (r == true) {
    $.ajax({
      type:"POST",
      url:'../utility/handle-admin-dashboard.php',
      data:{
          delete_this_event:delete_this_event
          },
      cache:false,
      error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr);
            console.log(ajaxOptions);
            console.log(thrownError);
        },
        beforeSend: function(){
        },
      success:function(response) {
        data(response);

      }
    });
  } else {
      // txt = "You pressed Cancel!";
  }
}

// EXPORT HTML TO EXCEL
function exportToExcel(table_id){
    // e.preventDefault();
    //getting data from our table
    var data_type = 'data:application/vnd.ms-excel';
    var table_div = document.getElementById(table_id);
    var table_html = table_div.outerHTML.replace(/ /g, '%20');

    var a = document.createElement('a');
    a.href = data_type + ', ' + table_html;
    a.download = 'exported_table_' + Math.floor((Math.random() * 9999999) + 1000000) + '.xls';
    a.click();
}
</script>
</body>
</html>
