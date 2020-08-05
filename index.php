<?php
require_once 'connect/class.booventpdo.php';
ini_set('display_errors',1);
date_default_timezone_set('Asia/Kolkata');
//-------------------- INITIALIZE THE VARIABLES -----------------------------------//
$error = "";
$current_date=date('Y-m-d h:i:s') ;
//========================= SEARCH QUERY RESULT FOR BOOVENT =================================//
$condition_arr1= "";
$condition_arr2= "";
$condition_arr1= array(":live",":start_date");
$condition_arr2= array("Live",$current_date);

$showEvent=new BooventPDO();
$get_event_sql="SELECT DISTINCT event_category FROM boovent_events WHERE event_end_date >= :start_date  AND make_event_live=:live ORDER BY event_start_date ASC";
$result=$showEvent->selectQuery($get_event_sql,$condition_arr1,$condition_arr2);
$event_category_arr=array();
foreach ($result as $row) {
    // Push the Data in an array
    $event_category = $row['event_category'];
    array_push($event_category_arr,$event_category);
}
//-------------- PREPARE JSON ARRAY ---------------------------//
$event_category_arr= array_unique($event_category_arr);
$event_category_arr=json_encode($event_category_arr);

//========================= FEATURE EVENTS ==============================================//

$condition_arr1 = "";
$condition_arr2 = "";
$condition_arr1 = array(":live",":start_date");
$condition_arr2 = array("Live",$current_date);

$showEvent=new BooventPDO();
$get_feature_sql="SELECT *,DATE_FORMAT(event_start_date, '%W %M %e, %r') as formatted_date FROM boovent_events WHERE event_end_date > :start_date  AND make_event_live=:live ORDER BY event_start_date ASC";
$feature_result=$showEvent->selectQuery($get_feature_sql,$condition_arr1,$condition_arr2);
$max_size = sizeof($feature_result);
if($max_size >0) {
    //Success
}
else {
    $error = "<p><center><h1>No Featured Events Found.</h1></center></p>";
}
unset($showEvent);
include 'header.php'; // INCLUDING HEADER
?>
  
<!-- HOME COROUSEL CODE -->
<div class="container-fluid">
    <div id="carousel" class="row carousel slide carousel-fade" data-ride="carousel">
        <!-- Carousel items -->
        <div class="carousel-inner carousel-zoom">
            <!-- <div class="active item">
                <img class="img-responsive" src="images/home-slider/1.jpg">
            </div> -->
            <div class="active item">
                <img class="img-responsive" src="images/home-slider/2.jpg">
            </div>
            <div class="item">
                <img class="img-responsive" src="images/home-slider/3.jpg">
            </div>
            <div class="item">
                <img class="img-responsive" src="images/home-slider/4.jpg">
            </div>
            <div class="item">
                <img class="img-responsive" src="images/home-slider/5.jpg">
            </div>
        </div>
    </div>
</div><!-- container-fluid --> 
<!-- =================== EVENT SEARCH BOX =================== -->
<div class="container-fluid">
    <div class="col-md-10 col-md-offset-1 search_box">
        <div class="search_title fnt_clr">
            <p>Explore Local Events, Gigs and Offers</p>
        </div>
        <form class="form-inline col-md-10 col-md-offset-1">
            <div class=" form-group ">
                <input type="text" class="form-control event_type" id="event_type" placeholder="Search events or categories" />
            </div>
            <div class=" form-group ">
                <input type="text" class="form-control event_location" id="event_location" placeholder="Location" />
            </div>
            <div class=" form-group">
                <select class="form-control event_by_date" id="event_by_date">
                    <option value="all">All Dates</option>
                    <option value="now">Today</option>
                    <option value="tommorow">Tomorrow</option>
                    <option value="week">In a Week</option>
                    <option value="month">This Month</option>
                </select>
            </div>
            <div class="form-group">
                <input onclick="searchEvents()" type="button" class="form-control btn btn-primary btn-lg search" style="margin-left:-5px;" value="Search" />
            </div>
        </form>
    </div>
</div><!-- container-fluid -->

<!-- =================== ALL EVENTS ARE SHOWN HERE AS LOCATION WISE =============== -->
<div class="container">
    <div class="col-md-12 top_5pt event_main_box">
        <div class="row">
            <?php if(empty($error)) {  
            foreach ($feature_result as $rows){
            $event_tags= $rows['event_tags']; 
            $tags =explode(',', $event_tags);
            //-------------------- CHECK IMAGE ----------------------------//
            if(!empty($rows['event_image']) && $rows['event_image']!="Not Given") {
            $event_image_url=$rows['event_image'];
            }else{
            $event_image_url=EVENT_IMAGE;
            }
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
            ?>
            <div class="col-sm-6 col-md-4 event_box">
                <div class="thumbnail">
                  <a href="event-details.php?eid=<?php echo $rows['event_id']; ?>"><img class="img-responsive" 
                  src="<?php echo $event_image_url; ?>" 
                  alt="Boovent -<?php echo $rows['event_title']; ?> "></a>
                  <div class="caption">
                    <h4><?php echo strtoupper($rows['event_title']); ?></h4>
                    <p class="event_time"><?php echo $rows['formatted_date']; ?></p>
                    <?php if($rows['event_type'] =="online") { ?>
                    <p class="event_address">
                    <?php echo "This is an online Event"; ?> 
                    </p>
                    <?php } else { ?>
                    <p class="event_address">
                    <?php echo $rows['event_address']." ".$rows['event_location']." ".$rows['event_city']." ".$rows['event_state']." ".$rows['event_country']; ?> 
                    </p>
                    <?php } ?>
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
                </div>
            </div>
            <?php } }  else { ?>
            <div class="row-fluid">
            <?php echo $error; ?>
            </div>
            <?php } ?>
        </div>

    </div><!-- event_main_box -->
</div>


<!-- ================== BROWSE EVENT BY TOP CATEGORY ================ -->
<div class="container">
    <div class="col-md-12 top_5pt event_category">
        <div class="browse_title">
            <h3>Browse by Top Categories</h3>
        </div>
        <div class="row">
            <div class="col-sm-6 col-xs-12 col-md-8 top_2pt cat_box">
                <div class="category_thumb img_scale_effect">
                    <a href="browse-event.php?event_type=Business">
                    <img class="img-responsive" src="images/event-cat/business.jpg" alt="Boovent - Business">
                    <div class="large_img_text">
                        <h4 class="cat_type">BUSINESS</h4>
                        <p class="cat_description">Business dinners, Fundraisers, Networking events, Meetups and many more</p>
                    </div>
                    </a>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12 col-md-4 top_2pt cat_box">
                <div class="category_thumb img_scale_effect">
                    <a href="browse-event.php?event_type=Entertainment">
                    <img class="img-responsive" src="images/event-cat/entertainment.jpg" alt="Boovent - Entertainment">
                    <div class="img_text">
                        <h4 class="cat_type">ENTERTAINMENT</h4>
                        <p class="cat_description">Concerts, Live shows, Standup comedy shows, Music Festivals, Tributes, Folk Music and many more</p>
                    </div>
                    </a>
                </div>
            </div> 
        </div><!-- row -->

        <div class="row">
            <div class="col-sm-6 col-xs-12 col-md-4 top_2pt cat_box">
                <div class="category_thumb img_scale_effect">
                    <a href="browse-event.php?event_type=Art">
                    <img class="img-responsive" src="images/event-cat/art.jpg" alt="Boovent - Art">
                    <div class="img_text">
                        <h4 class="cat_type">ART</h4>
                        <p class="cat_description">Art competitions, Art conferences, Art festivals, Art exhibitions, Comic cons and many more</p>
                    </div>
                    </a>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12 col-md-4 top_2pt cat_box">
                <div class="category_thumb img_scale_effect">
                    <a href="browse-event.php?event_type=Health">
                    <img class="img-responsive" src="images/event-cat/health.jpg" alt="Boovent - Health">
                    <div class="img_text">
                        <h4 class="cat_type">HEALTH</h4>
                        <p class="cat_description">Marathons, Cycling competitions, Coachings, Yoga sessions, Health care seminars and many more</p>
                    </div>
                    </a>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12 col-md-4 top_2pt cat_box">
                <div class="category_thumb img_scale_effect">
                    <a href="browse-event.php?event_type=Food and Drinks">
                    <img class="img-responsive" src="images/event-cat/food.jpg" alt="Boovent - Food">
                    <div class="img_text">
                        <h4 class="cat_type">FOOD & DRINKS</h4>
                        <p class="cat_description">Special events, Best places to visit in town, New lounge/restaurant, Offers and many more</p>
                    </div>
                    </a>
                </div>
            </div> 
        </div><!-- row -->

        <div class="row">
            <div class="col-sm-6 col-xs-12 col-md-4 top_2pt cat_box">
                <div class="category_thumb img_scale_effect">
                    <a href="browse-event.php?event_type=Hobbies">
                    <img class="img-responsive" src="images/event-cat/hobbies.jpg" alt="Boovent - Hobbies">
                    <div class="img_text">
                        <h4 class="cat_type">HOBBIES</h4>
                        <p class="cat_description">Games, Crafts, Singing, Dance, Photography and many more</p>
                    </div>
                    </a>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12 col-md-8 top_2pt cat_box">
                <div class="category_thumb img_scale_effect">
                    <a href="browse-event.php?event_type=College">
                    <img class="img-responsive" src="images/event-cat/college-fests.jpg" alt="Boovent - Fests">
                    <div class="large_img_text">
                        <h4 class="cat_type">COLLEGE FEST</h4>
                        <p class="cat_description">Tech Fest,Cultural Fest and many more</p>
                    </div>
                    </a>
                </div>
            </div> 
        </div><!-- row -->
        
    </div><!-- event_category -->
</div><!-- container -->
<?php
include 'footer.php'; // INCLUDING FOOTER

// RESPONSIBLE FOR CONVERTING PHP ARRAY FROM DB BOOVENT_EVENT TABLE FOR SEARCH BY CATEGORY
$script = '<script>  var event_category = ' . $event_category_arr . '; </script>';
echo $script;
?>
<!-- ================ JAVASCRIPT GOES HERE============================================== -->
<script type="text/javascript">
// EVENT CATEGORY SHOWING DYNAMICALLY BY AUTO HINT


// function formatDateTime(sDate,FormatType) {
//     var lDate = new Date(sDate);

//     var month=new Array(12);
//     month[0]="January";
//     month[1]="February";
//     month[2]="March";
//     month[3]="April";
//     month[4]="May";
//     month[5]="June";
//     month[6]="July";
//     month[7]="August";
//     month[8]="September";
//     month[9]="October";
//     month[10]="November";
//     month[11]="December";

//     var weekday=new Array(7);
//     weekday[0]="Sunday";
//     weekday[1]="Monday";
//     weekday[2]="Tuesday";
//     weekday[3]="Wednesday";
//     weekday[4]="Thursday";
//     weekday[5]="Friday";
//     weekday[6]="Saturday";

//     var hh = lDate.getHours() < 10 ? '0' + 
//         lDate.getHours() : lDate.getHours();
//     var mi = lDate.getMinutes() < 10 ? '0' + 
//         lDate.getMinutes() : lDate.getMinutes();
//     var ss = lDate.getSeconds() < 10 ? '0' + 
//         lDate.getSeconds() : lDate.getSeconds();

//     var d = lDate.getDate();
//     var dd = d < 10 ? '0' + d : d;
//     var yyyy = lDate.getFullYear();
//     var mon = eval(lDate.getMonth()+1);
//     var mm = (mon<10?'0'+mon:mon);
//     var monthName=month[lDate.getMonth()];
//     var weekdayName=weekday[lDate.getDay()];

//     if(FormatType==1) {
//        return mm+'/'+dd+'/'+yyyy+' '+hh+':'+mi;
//     } else if(FormatType==2) {
//        return weekdayName+', '+monthName+' '+ 
//             dd +', ' + yyyy;
//     } else if(FormatType==3) {
//        return mm+'/'+dd+'/'+yyyy; 
//     } else if(FormatType==4) {
//        var dd1 = lDate.getDate();    
//        return dd1+'-'+Left(monthName,3)+'-'+yyyy;    
//     } else if(FormatType==5) {
//         return mm+'/'+dd+'/'+yyyy+' '+hh+':'+mi+':'+ss;
//     } else if(FormatType == 6) {
//         return mon + '/' + d + '/' + yyyy + ' ' + 
//             hh + ':' + mi + ':' + ss;
//     } else if(FormatType == 7) {
//         return  dd + '-' + monthName.substring(0,3) + 
//             '-' + yyyy + ' ' + hh + ':' + mi + ':' + ss;
//     }
// }


//------------------- CREATE USER CURRENT DATE ------------------------------//
    function getLastDaysInMonth(m, y) {
    return m===2 ? y & 3 || !(y%25) && y & 15 ? 28 : 29 : 30 + (m+(m>>3)&1);
    }

    //--------------------------- GET CURRENT DATE -------------------------------//
    var d = new Date();
    var curr_date = d.getDate();
    var curr_month = d.getMonth() + 1; //Months are zero based
    var curr_year = d.getFullYear();
    var curr_hour = d.getHours();
    var curr_minute = d.getMinutes();
    //---------------------------- GET TOMMORROW DATE -------------------------------//
    var tDate = new Date(new Date().getTime() + 2 * 24 * 60 * 60 * 1000);
    var tday = tDate.getDate();
    var tmonth = tDate.getMonth() + 1;
    var tyear = tDate.getFullYear();
    var thour = tDate.getHours();
    var tminute = tDate.getMinutes();
    //---------------------------- GET WEEK DATE -------------------------------//
    var wDate = new Date(new Date().getTime() + 8 * 24 * 60 * 60 * 1000);
    var wday = wDate.getDate();
    var wmonth = wDate.getMonth() + 1;
    var wyear = wDate.getFullYear();
    var whour = wDate.getHours();
    var wminute = wDate.getMinutes();

    var userTime = curr_date + "-" + curr_month + "-" + curr_year + " " + curr_hour + ":" + curr_minute;
    // For Today Event
    var userTimeEnd = curr_date + "-" + curr_month + "-" + curr_year + "24" + ":" + "00";
    // Tommorrow Events
    var tommorowTime = tday + "-" + tmonth + "-" + tyear + " " + thour + ":" + tminute;
    // Week Event
    var weekTime = wday + "-" + wmonth + "-" + wyear + " " + whour + ":" + wminute;
    // Month Events
    var month_last_day = getLastDaysInMonth(curr_month, curr_year);
    var monthTime = month_last_day + "-" + curr_month + "-" + curr_year + "24" + ":" + "00";

$(function() {
    console.log(event_category);
    var eventCategory = event_category;
    $( "#event_type" ).autocomplete({
      source: eventCategory
    });
});
// SEARCH EVENT FUNCTION
function searchEvents(){
    var event_category=$("#event_type").val();
    var event_location=$("#event_location").val();
    var event_by_date=$("#event_by_date").val();
    if($("#event_by_date").val() == "now") {
        var endTime = userDate;
    }
    else if($("#event_by_date").val() == "tommorow") {
        var endTime = tommorowTime;
    }
    else if($("#event_by_date").val() == "week") {
        var endTime = weekTime;
    }
    else {
        var endTime = monthTime;
    }
    // Pass to Browse Event Page
    if (event_category!="" || event_location!="" || event_by_date!="" ) {
        window.location.href = 'browse-event.php?c='+event_category+'&l='+event_location+'&d='+event_by_date + '&n='+userTime+'&e='+endTime;
    }
    else{
        if(event_category=="") {
            alert('Please select event category!');
        }
        else if(event_location=="") {
            alert('Please select event location!');
        }
        else {
            alert('Please select event Date!');
        } 
    }
}
$("body").css("background-color", "#f5f5f5");

</script>
<!-- EVENT LOCATION FROM DATABAS SHOWING DYNAMICALLY BY AUTO HINT BY GOOGLE LOCATION -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC6jN9xh1nrsOyRQlBuShvbS_9QCfdVSrE&libraries=places"></script>
<script type="text/javascript">
    google.maps.event.addDomListener(window, 'load', function () {
        var options = {
                types: ['(cities)'],
                componentRestrictions: {country: "in"}
        };
        var input = document.getElementById('event_location');
        var places = new google.maps.places.Autocomplete(input,options);
        google.maps.event.addListener(places, 'place_changed', function () {
            var place = places.getPlace();
            var address = place.formatted_address;
            var latitude = place.geometry.location.lat();
            var longitude = place.geometry.location.lng();
            var mesg = "Address: " + address;
            mesg += "\nLatitude: " + latitude;
            mesg += "\nLongitude: " + longitude;
        });
    });
    // $("#event_location").attr("placeholder","");
</script>
