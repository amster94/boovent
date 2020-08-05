<style></style>
<?php
require_once 'connect/class.booventpdo.php';
ini_set('display_errors',1);
date_default_timezone_set('Asia/Kolkata');
  //====================== INITIALIZE THE VARIABLES ====================================//
    $error = "";
    $max_size = "";
    $event_browse_result = "";
  //==================== GET EVENT CATEGORY ===============================================//
  if (!empty($_GET['e-cat'])) {
    $event_cat=$_GET['e-cat'];
    $current_date=date('Y-m-d h:i:s') ;
    $displayEvent=new BooventPDO();
    if ($event_cat=='all category') {
      $condition_arr1= "";
      $condition_arr2= "";
      $condition_arr1 = array(":live",":start_date");
      $condition_arr2 = array("Live",$current_date);
      $get_tag_sql = "SELECT * FROM boovent_events WHERE event_end_date > :start_date AND make_event_live=:live ORDER BY event_start_date ASC";
    }else{
      $condition_arr1= "";
      $condition_arr2= "";
      $condition_arr1 = array(":category", ":live",":start_date");
      $condition_arr2 = array($event_cat, "Live",$current_date);
      $get_tag_sql = "SELECT * FROM boovent_events WHERE event_end_date > :start_date AND event_category=:category AND make_event_live=:live ORDER BY event_start_date ASC";
    }
    $tag_result=$displayEvent->selectQuery($get_tag_sql,$condition_arr1,$condition_arr2);
    $max_size = sizeof($tag_result);
    // print_r($tag_result);
    if($max_size > 0) {
      $event_browse_result=$tag_result;
    } else {
      $error = "<p><center><h2>Sorry, No Events Found for this category</h2></center></p>";
    }
  }
  //==================== GET EVENT TAGS ===============================================//
  else if (!empty($_GET['by-tag'])) {
    $event_tag=$_GET['by-tag'];
    $event_tag="%".$event_tag."%";
    $current_date=date('Y-m-d h:i:s') ;
    $condition_arr1= "";
    $condition_arr2= "";
    $condition_arr1 = array(":tag", ":live",":start_date");
    $condition_arr2 = array($event_tag, "Live",$current_date);
    $displayEvent=new BooventPDO();
    $get_tag_sql = "SELECT * FROM boovent_events WHERE event_tags LIKE :tag AND event_end_date > :start_date AND make_event_live=:live ORDER BY event_start_date ASC";
    $tag_result=$displayEvent->selectQuery($get_tag_sql,$condition_arr1,$condition_arr2);
    $max_size = sizeof($tag_result);
    if($max_size > 0) {
      $event_browse_result=$tag_result;
    } else {
      $error = "<p><center><h2>Sorry, No Events Found for this Tag</h2></center></p>";
    }
  }
  //==================== GET EVENT IF PAID OR FREE ===============================================//
  else if (!empty($_GET['price'])) {
    $price=$_GET['price'];
    $current_date=date('Y-m-d h:i:s') ;
    $condition_arr1= "";
    $condition_arr2= "";
    $condition_arr1 = array(":is_paid", ":live",":start_date");
    $condition_arr2 = array($price, "Live",$current_date);
    $displayEvent=new BooventPDO();
    if ($price=='Free') {
      $get_tag_sql = "SELECT boovent_events.*, boovent_ticket_manager.* FROM boovent_events JOIN boovent_ticket_manager ON boovent_events.event_id=boovent_ticket_manager.event_id AND ticket_type=:is_paid  AND event_end_date > :start_date AND make_event_live=:live ORDER BY event_start_date ASC";
    }else{
      $get_tag_sql = "SELECT boovent_events.*, boovent_ticket_manager.* FROM boovent_events JOIN boovent_ticket_manager ON boovent_events.event_id=boovent_ticket_manager.event_id AND ticket_type=:is_paid AND boovent_ticket_manager.ticket_class='GOLD'  AND event_end_date > :start_date AND make_event_live=:live ORDER BY event_start_date ASC";
    
    }
    $tag_result=$displayEvent->selectQuery($get_tag_sql,$condition_arr1,$condition_arr2);
    $max_size = sizeof($tag_result);
    if($max_size > 0) {
      $event_browse_result=$tag_result;
    } else {
      $error = "<p><center><h2>Sorry, No Events Found for this Tag</h2></center></p>";
    }
  }
  //==================== GET EVENT CATEGORIES =========================================//
  else if (!empty($_GET['event_type'])) {
    $event_category=$_GET['event_type'];
    $current_date=date('Y-m-d h:i:s') ;
    $condition_arr1= "";
    $condition_arr2= "";
    $condition_arr1 = array(":live",":category",":start_date");
    $condition_arr2 = array("Live",$event_category,$current_date);
    $displayEvent=new BooventPDO();
    $get_category_sql = "SELECT * FROM boovent_events WHERE event_end_date > :start_date AND event_category = :category AND make_event_live=:live ORDER BY event_start_date ASC";
    $category_result=$displayEvent->selectQuery($get_category_sql,$condition_arr1,$condition_arr2);
    $max_size = sizeof($category_result);
    if($max_size > 0) {
      $event_browse_result=$category_result;
    } else {
      $error = "<p><center><h2>Sorry, No Events Found for this Category</h2></center></p>";
    }
  }
  //==================== GET EVENT BY DATE FILTER =========================================//
  else if (!empty($_GET['evdt'])) {
    $event_time=$_GET['evdt'];
    $c_date=date('Y-m-d') ;
    $condition_arr1= "";
    $condition_arr2= "";
    $displayEvent=new BooventPDO();

    if ($event_time=='today') {
      $current_date=substr(date('Y-m-d h:i:s'), 0, 10) ;
      $condition_arr1 = array(":live",":today", ":start_date");
      $condition_arr2 = array("Live",$current_date, $c_date);
      $get_category_sql = "SELECT * FROM boovent_events WHERE SUBSTR(event_start_date, 1, 10)=:today  AND event_end_date > :start_date AND make_event_live=:live ORDER BY event_start_date ASC";
    
    }else if($event_time=='tomorrow'){
      $current_date=substr(date('Y-m-d h:i:s', strtotime("+1 days")), 0, 10) ;

      $condition_arr1 = array(":live",":today", ":start_date");
      $condition_arr2 = array("Live",$current_date, $c_date);
      $get_category_sql = "SELECT * FROM boovent_events WHERE SUBSTR(event_start_date, 1, 10)=:today  AND event_end_date > :start_date AND make_event_live=:live ORDER BY event_start_date ASC";
    
    }else if($event_time=='this-week'){
      $current_date=substr(date('Y-m-d h:i:s'), 0, 10) ;
      for ($i=0; $i <7 ; $i++) {
        $current_date_day=substr(date('D', strtotime("+$i days")), 0, 10) ;
        if($current_date_day=='Sat'){
         $week_end=$current_date_day;
         $count_for_week= $i;
          break;
        }
      }
      $next_date=substr(date('Y-m-d h:i:s', strtotime("+$count_for_week days")), 0, 10) ;

      $condition_arr1 = array(":live",":start_date",":end_date");
      $condition_arr2 = array("Live",$current_date,$next_date);
      $get_category_sql = "SELECT * FROM boovent_events WHERE (SUBSTR(event_start_date, 1, 10) BETWEEN :start_date AND :end_date) AND make_event_live=:live ORDER BY event_start_date ASC";

    }else if($event_time=='this-weekend'){
      $current_date=substr(date('Y-m-d h:i:s'), 0, 10) ;
      for ($i=0; $i <7 ; $i++) {
        $current_date_day=substr(date('D', strtotime("+$i days")), 0, 10) ;
        if($current_date_day=='Sat'){
         $week_end=$current_date_day;
         $count_for_weekend= $i;
          break;
        }
      }
      $week_end=substr(date('Y-m-d h:i:s', strtotime("+$count_for_weekend days")), 0, 10) ;


      $condition_arr1 = array(":live",":week_end", ":start_date");
      $condition_arr2 = array("Live",$week_end, $c_date);
      $get_category_sql = "SELECT * FROM boovent_events WHERE DATE_FORMAT(event_start_date, '%a')=:week_end AND event_end_date > :start_date AND make_event_live=:live ORDER BY event_start_date ASC";
    
    }else if($event_time=='this-month'){
      $current_date=date('Y M');
      $condition_arr1 = array(":live",":this_month", ":start_date");
      $condition_arr2 = array("Live",$current_date, $c_date);
      $get_category_sql = "SELECT * FROM boovent_events WHERE DATE_FORMAT(event_start_date, '%Y %b')=:this_month AND event_end_date > :start_date AND make_event_live=:live ORDER BY event_start_date ASC";
    
    }else {
      $home_url = '404.php';
      header('Location: ' . $home_url);
      $error = "<p><center><h2>Sorry, No Events Found for this Category</h2></center></p>";
    }
    $category_result=$displayEvent->selectQuery($get_category_sql,$condition_arr1,$condition_arr2);
    $max_size = sizeof($category_result);
    if($max_size > 0) {
      $event_browse_result=$category_result;
    }else {
      $error = "<p><center><h2>Sorry, No Events Found for this Category</h2></center></p>";
    }
  }
  //====================== FETCH THE SEARCH RESULTS ====================================//
  else if (!empty($_GET['c']) || !empty($_GET['l']) || !empty($_GET['d'])) {
    $event_category=$_GET['c'];
    $event_location=$_GET['l'];
    $event_time=$_GET['d'];
    $event_now=$_GET['n'];
    $event_end=$_GET['e'];
    $event_city =strtok($event_location, ',');
    //------------------- CONVERT THE STRING INTO DATE TYPE ----------------------//
    $time = strtotime($event_now);
    $time1 = strtotime($event_end);
    //------------------- IF CATEGORY IS EMPTY ----------------------------------//
    if(empty($_GET['c'])) {
    $condition_arr1= "";
    $condition_arr2= "";
    $displayEvent=new BooventPDO();
    if($event_time == "now") {
      $condition_arr1= array(":event_city", ":event_end");
      $condition_arr2= array($event_city, date ("Y-m-d H:i:s", $time1 ));
      $location_sql="SELECT * FROM boovent_events WHERE event_city=:event_city AND event_end_date =:event_end ";
    }
    else if($event_time == "tommorow" || $event_time == "month" || $event_time == "week" ) {
      $condition_arr1= array(":event_city", ":event_now",":event_end");
      $condition_arr2= array($event_city, date ("Y-m-d H:i:s", $time ),date ("Y-m-d H:i:s", $time1 ));
      $location_sql="SELECT * FROM boovent_events WHERE event_city=:event_city AND event_end_date BETWEEN :event_now AND :event_end ";
    }
    else {
      $condition_arr1= array(":event_city", ":event_now");
      $condition_arr2= array($event_city, date ("Y-m-d H:i:s", $time ));
      $location_sql="SELECT * FROM boovent_events WHERE event_city=:event_city AND event_end_date > :event_now";
    }
    $lresult=$displayEvent->selectQuery($location_sql,$condition_arr1,$condition_arr2);
    $max_size = sizeof($lresult);
    if($max_size > 0) {
      $event_browse_result=$lresult;
    }
    else {
      if($event_time == "tommorow" || $event_time == "month" || $event_time == "week" || $event_time == "now") {
        $error = "<p><center><h2>No Events Found in ".$event_city." for specified Time.</h2>
        </center></p>";
      } else {
        $error = "<p><center><h2>No Events Found for ".$event_city.".</h2></center></p>";
      }
    }
    }
    //------------------- IF LOCATION IS EMPTY ----------------------------------//
    if(empty($_GET['l'])) {
    $current_date=date('Y-m-d h:i:s') ;
      $condition_arr1= "";
      $condition_arr2= "";
      $displayEvent=new BooventPDO();
    if($event_time == "now") {
    $condition_arr1= array(":event_category", ":event_end");
    $condition_arr2= array($event_category, date ("Y-m-d H:i:s", $time1 ));
    $get_all_sql="SELECT * FROM boovent_events WHERE event_category=:event_category AND event_start_date =:event_end ";
    }
    else if($event_time == "tommorow" || $event_time == "month" || $event_time == "week" ) {
      $condition_arr1= array(":event_category", ":event_now",":event_end");
      $condition_arr2= array($event_category, date ("Y-m-d H:i:s", $time ),date ("Y-m-d H:i:s", $time1 ));
      $get_all_sql="SELECT * FROM boovent_events WHERE event_category=:event_category AND event_start_date BETWEEN :event_now AND :event_end ";
    }
    else {
      $condition_arr1= array(":event_category", ":event_now");
      $condition_arr2= array($event_category, date ("Y-m-d H:i:s", $time ));
      $get_all_sql="SELECT * FROM boovent_events WHERE event_category=:event_category AND event_end_date > :event_now";
    }
    $result=$displayEvent->selectQuery($get_all_sql,$condition_arr1,$condition_arr2);
    $max_size = sizeof($result);
    if($max_size > 0) {
      $event_browse_result=$result;
    }
    else {
     $error = "<p><center><h2>Sorry, No Events Found.</h2></center></p>";
    }
    }
    //------------------- IF BOTH LOCATION AND CATEGORY IS EMPTY --------------------------//
    if(empty($_GET['l']) && empty($_GET['l'])) {
    $condition_arr1= "";
    $condition_arr2= "";
    $displayEvent=new BooventPDO();
    if($event_time == "now") {
    $condition_arr1= array(":event_end");
    $condition_arr2= array(date ("Y-m-d H:i:s", $time1 ));
    $get_all_sql="SELECT * FROM boovent_events WHERE event_start_date =:event_end ";
    }
    else if($event_time == "tommorow" || $event_time == "month" || $event_time == "week" ) {
      $condition_arr1= array(":event_now",":event_end");
      $condition_arr2= array(date ("Y-m-d H:i:s", $time ),date ("Y-m-d H:i:s", $time1 ));
      $get_all_sql="SELECT * FROM boovent_events WHERE event_start_date BETWEEN :event_now AND :event_end ";
    }
    else {
      $condition_arr1= array(":event_now");
      $condition_arr2= array(date ("Y-m-d H:i:s", $time ));
      $get_all_sql="SELECT * FROM boovent_events WHERE event_end_date > :event_now";
    }
    $result=$displayEvent->selectQuery($get_all_sql,$condition_arr1,$condition_arr2);
    $max_size = sizeof($result);
    if($max_size > 0) {
      $event_browse_result=$result;
    }
    else {
     $error = "<p><center><h2>Sorry, No Events Found.</h2></center></p>";
    }
    }

    //-------------------- INITIALIZE THE VARIABLES -----------------------------------//
    if(!empty($_GET['c']) && !empty($_GET['l']) && !empty($_GET['d'])) {
    //----------------------- CHECK LOCATION AVAILABILITY -----------------------------------//
    $condition_arr1= "";
    $condition_arr2= "";
    $condition_arr1 = array(":live",":event_city");
    $condition_arr2 = array("Live",$event_city);
    $displayEvent=new BooventPDO();
    $location_sql = "SELECT * FROM boovent_events WHERE event_city=:event_city AND make_event_live=:live ORDER BY event_start_date ASC";
    $lresult=$displayEvent->selectQuery($location_sql,$condition_arr1,$condition_arr2);
    $max_size = sizeof($lresult);
    if($max_size > 0) {
    $condition_arr1= "";
    $condition_arr2= "";
    //----------------------- EVENTS FROM MATCHED CATEGORY AND LOCATION ---------------------//
    if($event_time == "now") {
      $condition_arr1= array(":event_category", ":event_city", ":event_end");
      $condition_arr2= array($event_category, $event_city, date ("Y-m-d H:i:s", $time1 ));
      $get_event_sql="SELECT * FROM boovent_events WHERE event_category=:event_category AND event_city=:event_city AND event_start_date =:event_end ";
    }
    else if($event_time == "tommorow" || $event_time == "month" || $event_time == "week" ) {
      $condition_arr1= array(":event_category", ":event_city", ":event_now",":event_end");
      $condition_arr2= array($event_category, $event_city, date ("Y-m-d H:i:s", $time ),date ("Y-m-d H:i:s", $time1 ));
      $get_event_sql="SELECT * FROM boovent_events WHERE event_category=:event_category AND event_city=:event_city AND event_start_date BETWEEN :event_now AND :event_end ";
    }
    else {
      $condition_arr1= array(":event_category", ":event_city", ":event_now");
      $condition_arr2= array($event_category, $event_city, date ("Y-m-d H:i:s", $time ));
      $get_event_sql="SELECT * FROM boovent_events WHERE event_category=:event_category AND event_city=:event_city AND event_end_date > :event_now";
    }
    $result=$displayEvent->selectQuery($get_event_sql,$condition_arr1,$condition_arr2);
    $max_size = sizeof($result);
    if($max_size > 0) {
      $event_browse_result=$result;
    }
    else {
     $error = "<p><center><h2>Sorry, No Events Found.</h2></center></p>";
    }
    }
    else {
      $current_date=date('Y-m-d h:i:s') ;
      $condition_arr1= "";
      $condition_arr2= "";
      $condition_arr1 = array(":live",":start_date",":event_category");
      $condition_arr2 = array("Live",$current_date,$event_category);
      $displayEvent=new BooventPDO();
    $get_all_sql="SELECT * FROM boovent_events WHERE event_end_date >= :start_date  AND event_category=:event_category AND make_event_live=:live ORDER BY event_start_date ASC ";
    $result=$displayEvent->selectQuery($get_all_sql,$condition_arr1,$condition_arr2);
    $max_size = sizeof($result);
    if($max_size > 0) {
      $event_browse_result=$result;
    }
    else {
     $error = "<p><center><h2>Sorry, No Events Found.</h2></center></p>";
    }
    }
  } 
  }
  //========================= SHOW LIVE EVENTS ON BROWSE EVENTS =========================//
  else {
    $current_date=date('Y-m-d h:i:s') ;
    $condition_arr1= "";
    $condition_arr2= "";
    $condition_arr1 = array(":live",":start_date");
    $condition_arr2 = array("Live",$current_date);
    $displayEvent=new BooventPDO();
    $get_all_sql="SELECT * FROM boovent_events WHERE event_end_date > :start_date AND make_event_live=:live ORDER BY event_start_date ASC";
    $result=$displayEvent->selectQuery($get_all_sql,$condition_arr1,$condition_arr2);
    $max_size = sizeof($result);
    if($max_size > 0) {
      $event_browse_result=$result;
    }
    else {
     $error = "<p><center><h2>Sorry, No Events Found.</h2></center></p>";
    }
  }
  unset($displayEvent);
include 'header.php'; // INCLUDING HEADER
?>
<div class="container">
    <div class="browse_event_main_box">
      <div class="col-md-3">
        <div class="row">
          <div id="map"></div>
          <div class="form-group top_2pt">
            <input onkeyup="filterEventByLocation()" id="search-location-input" class="form-control controls" type="text" placeholder="Search By Location">
            <input onclick="filterEventByLocation()" type="button" class="btn btn-primary col-md-12 col-sm-12 col-xs-12 top_2pt pull-right" value="Find Events" />
          </div>
        </div>
        <div class="row">
          <div class="event_filter_box">
            <!-- FILTER EVENT CATEGORY WISE -->
            <div class="panel panel-primary">
              <div class="panel-heading clickable">
                <h4 class="panel-title">CATEGORY</h4>
                <span class="pull-right "><i class="fa fa-angle-down"></i></span>
              </div><!-- panel-heading clickable -->
              <div class="panel-body">
                <ul class="col-md-12" id="event_category">
                  <li><a href="browse-event.php?e-cat=all category">All Category</a></li>
                  <li><a href="browse-event.php?e-cat=Cultural">Cultural</a></li>
                  <li><a href="browse-event.php?e-cat=Food and Drinks">Food and Drinks</a></li>
                  <li><a href="browse-event.php?e-cat=Political">Political</a></li>
                  <li><a href="browse-event.php?e-cat=Health">Health</a></li>
                  <li><a href="browse-event.php?e-cat=Business">Business</a></li>
                  <li><a href="browse-event.php?e-cat=Hobbies">Hobbies</a></li>
                  <li><a href="browse-event.php?e-cat=Music">Music</a></li>
                  <li><a href="browse-event.php?e-cat=Entertainment">Entertainment</a></li>
                  <li><a href="browse-event.php?e-cat=Art">Art</a></li>
                  <li><a href="browse-event.php?e-cat=Science and Technology">Science and Technology</a></li>
                  <li><a href="browse-event.php?e-cat=Religious">Religious</a></li>
                  <li><a href="browse-event.php?e-cat=Holiday">Holiday</a></li>
                  <li><a href="browse-event.php?e-cat=Sports and Adventure">Sports and Adventure</a></li>
                  <li><a href="browse-event.php?e-cat=College">College</a></li>
                  <li><a href="browse-event.php?e-cat=Education and Family">Education and Family</a></li>
                </ul>
              </div><!-- panel-body -->
            </div><!-- panel panel-primary -->
            
            <!-- FILTER EVENT PRICE WISE -->
            <div class="panel panel-primary">
              <div class="panel-heading clickable">
                <h4 class="panel-title">PRICE</h4>
                <span class="pull-right "><i class="fa fa-angle-down"></i></span>
              </div><!-- panel-heading clickable -->
              <div class="panel-body">
                <ul class="col-md-12" id="event-price">
                  <li><a href="browse-event.php?price=Free">Free</a></li>
                  <li><a href="browse-event.php?price=Paid">Paid</a></li>
                </ul>
              </div><!-- panel-body -->
            </div><!-- panel panel-primary -->
            <!-- FILTER EVENT DATE WISE -->
            <div class="panel panel-primary">
              <div class="panel-heading clickable">
                <h4 class="panel-title">DATE</h4>
                <span class="pull-right "><i class="fa fa-angle-down"></i></span>
              </div><!-- panel-heading clickable -->
              <div class="panel-body">
                <ul class="col-md-12" id="event-date">
                  <li><a href="browse-event.php?evdt=today">Today</a></li>
                  <li><a href="browse-event.php?evdt=tomorrow">Tomorrow</a></li>
                  <li><a href="browse-event.php?evdt=this-week">This Week</a></li>
                  <li><a href="browse-event.php?evdt=this-weekend">This Weekend</a></li>
                  <!-- <li><a href="browse-event.php?evdt=next-week">Next Week</a></li> -->
                  <li><a href="browse-event.php?evdt=this-month">This Month</a></li>
                </ul>
              </div><!-- panel-body -->
            </div><!-- panel panel-primary -->
          </div><!-- event_filter_box -->
        </div>
      </div>  

      <div class="col-md-9">
        <div class="events_head_title">
        <?php
        // if(!empty($event_city)) {
          // echo "<h1>".$event_city." Events For You</h1>";
        // }
        // else {
          echo "<h1>Events For You</h1>";
        // }
        ?>
        </div>
        <!-- <div class="row">
          <div class="event_sortby pull-right">
            <span><a href="#">RELEVANCE</a><a href="#">DATE</a></span>
          </div>
        </div> -->
        <!-- <br><br><br> -->
        <div id="browse-events">
        <?php 
        if(!empty($event_browse_result)) {
        foreach ($event_browse_result as $rows){ 
          $event_tags= $rows['event_tags']; 
          $tags =explode(',', $event_tags);
          $condition_arr1="";
          $condition_arr2="";
          // GETTING MINIMUM PRICE OF TICKET FOR SHOWING ON button
          $condition_arr1= array(":event_id");
          $condition_arr2= array($rows['event_id']);
          $MinPrice=new BooventPDO();
          $get_min_price_sql="SELECT *, MIN(ticket_price) as min_price FROM boovent_ticket_manager WHERE event_id=:event_id";
          $min_price_result=$MinPrice->selectQuery($get_min_price_sql,$condition_arr1,$condition_arr2);
          $event_min_price= $min_price_result[0]['min_price'];
          $event_tickets_remaining= $min_price_result[0]['total_tickets_remaining'];
          unset($MinPrice);

          if(!empty($rows['event_image']) && $rows['event_image']!="Not Given") {
            $event_image_url=$rows['event_image'];
          }else{
            $event_image_url=EVENT_IMAGE;
          }
          $event_start_date=$rows['event_start_date'];
          $event_start_date=strtotime($event_start_date);
          $event_start_date= date("l M d Y, h:i:s A", $event_start_date);

          $share_image=$rows['event_image'];
          $share_event_title=$rows['event_title'];
          $share_event_description=strip_tags($rows['event_description']);
          $share_event_description=substr($share_event_description, 0,40).'...';
          $share_event_url=BASE_URL."event-details.php?eid=".$rows['event_id'];
        ?>
        <div class="single_event_box box_border">
          <div class="row">
            <a href="event-details.php?eid=<?php echo $rows['event_id']; ?>">
              <div class="event_description ">
                <div class="col-md-5 col-sm-12 col-xs-12">
                  <img class="img-responsive" src="<?php echo $event_image_url; ?>">
                </div>
                <div class="col-md-7 browse_event_detail">
                  <div class="event_title">
                    <p><?php echo strtoupper($rows['event_title']); ?></p>
                  </div>
                  <div class="date_time">
                    <p><?php echo $event_start_date; ?></p>
                  </div>
                  <div class="event_address">
                    <p><?php echo $rows['event_address']." ".$rows['event_location']." ".$rows['event_city']." ".$rows['event_state']." ".$rows['event_country']; ?></p>
                  </div>
                  <?php if($event_tickets_remaining > 0) { 
                    if($event_min_price > 0) { 
                    if($rows['event_button'] == "register") {
                    ?>
                    <p class="top_2pt buy_btn">
                        <a href="event-details.php?eid=<?php echo $rows['event_id']; ?>" class="btn btn-primary" role="button">Register Now</a>
                    </p>
                  <?php } else { ?>
                    <p class="top_2pt buy_btn">
                    <a href="event-details.php?eid=<?php echo $rows['event_id']; ?>" class="btn btn-primary" role="button">Buy at Rs. <?php echo $event_min_price; ?></a>
                    </p>
                  <?php } } else { ?>
                     <p class="top_2pt buy_btn">
                     <a href="event-details.php?eid=<?php echo $rows['event_id']; ?>" class="btn btn-primary" role="button">Free Event</a>
                     </p>
                    <?php } } else { ?>
                    <p class="top_2pt buy_btn">
                    <a href="javascript:;" class="btn btn-primary" role="button">All Tickets Booked
                    </a>
                    </p>
                    <?php } ?>
                </div>
              </div>
            </a>
            <div class="col-md-12">
              <div class="tag_share_opt">
                <div class="col-md-6 event_tag">
                  <?php if(!empty($event_tags)) {  ?>
                    <p class="event_tag">
                        <?php foreach ($tags as $values) { ?>
                        <a href="browse-event.php?by-tag=<?php echo $values; ?>">#<?php echo $values; ?>
                        </a>
                        <?php } ?>
                    </p>
                    <?php }else{ ?>
                        <p class="event_tag H_20px"></p>
                    <?php } ?>
                </div>
                <div class="col-md-6 share_on_social ">
                  <p class="pull-right">Share on : 
                    <span>
                      <a onclick="window.open('http://www.facebook.com/share.php?u=<?php echo $share_event_url; ?>&title=<?php echo $share_event_title; ?>&description=<?php echo $share_event_description; ?>','Boovent','width=800,height=400')" href="javascript:;"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                      <a onclick="window.open('http://twitter.com/home?status=<?php echo $share_event_title; ?>+<?php echo $share_event_url; ?>','Boovent','width=800,height=400')" href="javascript:;"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                      <a onclick="window.open('https://plus.google.com/share?url=<?php echo $share_event_url; ?>','Boovent','width=800,height=400')" href="javascript:;"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                    </span>
                  </p>
                </div>
              </div>
            </div>
          </div><!-- row -->
        </div><!-- single_event_box -->
        <?php } } else {  ?>
        <div class="single_event_box box_border">
          <div class="row">
          <?php if(!empty($error)) { echo $error; } ?>
          </div>
        </div>
        <?php } ?>
        </div>
      </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
  // $('#event_category li a').on('click', function(){
  //   // alert(this.text);
  //   var event_category=this.text;
  //    // window.location.href = "browse-event.php?ref="+event_category;
  //    window.history.pushState('browse-event.php', 'Title', 'browse-event.php?ref='+event_category);
  // });
  // initAutocomplete();
  
});
function filterEventByLocation(){
    var map_location=$('#search-location-input').val();
    
    // if (map_location!='') {
      map_location=map_location.split(",");
      map_location=map_location[0];
      // window.location.href="browse-event.php?location="+map_location;
      // $('#search-location-input').val(map_location);
      $.ajax({
        type:'POST',
        url:'utility/event-filter.php',
        data:{
          map_location:map_location
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
          $('#browse-events').text('');
          $('#browse-events').append(data);
          // window.location.replace("browse-event.php");

        }
      });
    // }else{
    //   alert("Please fill location first!");
    // }
  }

$("body").css("background-color", "#f5f5f5");
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDijyQE38q7PwUfzNEWFdKiIddwsVXqvpU&libraries=places&callback=initAutocomplete" async defer></script>

<?php
include 'footer.php'; // INCLUDING FOOTER
?>

