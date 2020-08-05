<?php
require_once '../connect/class.booventpdo.php';
ini_set('display_errors',1);
if(!isset($_SESSION)){
    session_start();
}
// $user_email=$_SESSION['user_email'];
$condition_arr1 = ""; // FOR SQL PARAMETER VALUE
$condition_arr2 = ""; // FOR BINDING SQL PARAMETER VALUE
$msg="";
// ===================== SHOW ORGANIZER BANK DETAIL IN ADMIN PANEL ON MODAL ===================================================================
if (isset($_POST['map_location'])) {
	// echo $location1=$_GET['map_location'];
    $location="%".$_POST['map_location']."%";
    $current_date=date('Y-m-d') ;
    $condition_arr1= "";
    $condition_arr2= "";
    $condition_arr1 = array(":start_date", ":live",":event_address");
    $condition_arr2 = array($current_date, "Live",$location);
    $displayEvent=new BooventPDO();
    $get_category_sql = "SELECT * FROM boovent_events WHERE (event_location LIKE :event_address OR event_address LIKE :event_address OR event_city LIKE :event_address OR event_state LIKE :event_address) AND event_end_date > :start_date AND make_event_live=:live";
    $category_result=$displayEvent->selectQuery($get_category_sql,$condition_arr1,$condition_arr2);
    // print_r($category_result);
    $max_size = sizeof($category_result);
    if($max_size > 0) {
      $event_browse_result=$category_result;
      
      foreach ($category_result as $rows) {
		$tags= $rows['event_tags']; 
		$tags =explode(',', $tags);
		$condition_arr1="";
		$condition_arr2="";
		// GETTING MINIMUM PRICE OF TICKET FOR SHOWING ON button
		$condition_arr1= array(":event_id");
		$condition_arr2= array($rows['event_id']);
		$MinPrice=new BooventPDO();
		$get_min_price_sql="SELECT MIN(ticket_price) as min_price FROM boovent_ticket_manager WHERE event_id=:event_id";
		$min_price_result=$MinPrice->selectQuery($get_min_price_sql,$condition_arr1,$condition_arr2);
		$event_min_price=$min_price_result;
		$event_min_price= $event_min_price[0]['min_price'];
		unset($MinPrice);

		if(!empty($rows['event_image']) && $rows['event_image']!="Not Given") {
			$event_image_url=$rows['event_image'];
		}else{
			$event_image_url="images/default-event-baner.jpg";
		}
		$event_start_date=$rows['event_start_date'];
		$event_start_date=strtotime($event_start_date);
		$event_start_date= date("l M d Y, h:i:s A", $event_start_date);

        $share_image=$rows['event_image'];
        $share_event_title=$rows['event_title'];
        $share_event_description=strip_tags($rows['event_description']);
        $share_event_description=substr($share_event_description, 0,40).'...';
        $share_event_url=BASE_URL."event-details.php?eid=".$rows['event_id'];
        $fb_share='\'http://www.facebook.com/share.php?u='.$share_event_url.'&title='.$share_event_title.'&description='.$share_event_description.'\',\'Boovent\''.',\'width=800\',\'height=400\'';
      	$twitter_share='\'http://twitter.com/home?status='.$share_event_title.'+'.$share_event_url.'\',\'Boovent\''.',\'width=800\',\'height=400\'';
        $g_plus='\'https://plus.google.com/share?url='.$share_event_url.'\',\'Boovent\''.',\'width=800\',\'height=400\'';
        echo '<div class="single_event_box box_border">';
        echo  '<div class="row">';
        echo    '<a href="event-details.php?eid='.$rows['event_id'].'">';
        echo      '<div class="event_description ">';
        echo        '<div class="col-md-5 col-sm-12 col-xs-12">';
        echo          '<img class="img-responsive" src="'.$event_image_url.'">';
        echo        '</div>';
        echo        '<div class="col-md-7">';
        echo          '<div class="event_title">';
        echo            '<p>'.strtoupper($rows['event_title']).'</p>';
        echo          '</div>';
        echo          '<div class="date_time">';
        echo            '<p>'.$event_start_date.'</p>';
        echo          '</div>';
        echo          '<div class="event_address">';
        echo           '<p>'.$rows['event_address']." ".$rows['event_location']." ".$rows['event_city']." ".$rows['event_state']." ".$rows['event_country'].'</p>';
        echo          '</div>';
                  if($event_min_price > 0) {
                echo  '<p class="top_2pt buy_btn"><a href="event-details.php?eid='.$rows['event_id'].'" class="btn btn-primary" role="button">
                  Buy at Rs. '.$event_min_price.'</a></p>';
                  } else {
                echo '<p class="top_2pt buy_btn"><a href="event-details.php?eid='.$rows['event_id'].'" class="btn btn-primary" role="button">
                       Free Event</a></p>';
                  }
                echo'</div>';
            echo  '</div>';
            echo'</a>';
        echo    '<div class="col-md-12">';
        echo      '<div class="tag_share_opt">';
        echo        '<div class="col-md-6 event_tag">';
                  foreach ($tags as $values) { 
                  	$values=trim($values);
        			echo  '<a href="browse-event.php?by-tag='.$values.'">#'.$values.'</a>';
                  }
        echo        '</div>';
        echo        '<div class="col-md-6 share_on_social ">';
        echo          '<p class="pull-right">Share on : 
                        <span>';
        echo                  '<a onclick="window.open('.$fb_share.')" href="javascript:;"><i class="fa fa-facebook" aria-hidden="true"></i></a>';
        echo                  '<a onclick="window.open('.$twitter_share.')" href="javascript:;"><i class="fa fa-twitter" aria-hidden="true"></i></a>';
        echo                  '<a onclick="window.open('.$g_plus.')" href="javascript:;"><i class="fa fa-google-plus" aria-hidden="true"></i></a>';
        echo                '</span>';
        echo             '</p>';
        echo        '</div>';
        echo      '</div>';
        echo    '</div>';
        echo  '</div>';
        echo '</div>';
        }

    } else {
    echo '<div class="single_event_box box_border">
            <div class="row">';
    echo 		'<p><center><h1>No Events Found for this Category</h1></center></p>';
    echo 	'</div>
         </div>';
    }
}else{
	echo "string";
}


?>