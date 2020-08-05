<?php
include 'header-dashboard.php'; // INCLUDING HEADER
?>
<style type="text/css">


</style>
<!-- ========= TAB MENU ============== -->
<div class="container-fluid ">
<div class="row">
    <div class="tabbable-line tab_menu">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#active_event" data-toggle="tab">Active Events</a>
			</li>
			<li>
				<a href="#past_event" data-toggle="tab">Past Events</a>
			</li>
		</ul>
		<!-- <div class="container"></div> -->
		<div class="tab-content ">
			<div class="tab-pane active" id="active_event">
				<div class="col-md-12 top_5pt event_main_box">
			        <div class="row">
			            <?php for ($i=0; $i < 2; $i++) {  ?>
			            <div class="col-sm-6 col-md-4 event_box">
			                <div class="thumbnail">
			                  <img class="img-responsive" src="../images/event-cat/health.jpg" alt="Boovent - ">
			                  <div class="caption">
			                    <h3>Event Title</h3>
			                    <p class="event_time">26-Jan-2017, 10:10 AM</p>
			                    <p class="event_address">Amnora Town, Hadapsar Pune Maharashtra</p>
			                    <p class="card-description">Digital Marketing sector is growing...</p>
			                    <p class="top_2pt"><a href="event-details.php" class="btn btn-primary" role="button">Buy Ticket</a></p>
			                    <p class="event_tag"><a href="#tag">#tag1</a><a href="#tag">#tag2</a></p>
			                  </div>
			                </div>
			            </div>
			            <?php } ?>
			        </div>
			    </div><!-- event_main_box -->
			</div>
			<div class="tab-pane" id="past_event">
				<div class="col-md-12 top_5pt event_main_box">
			        <div class="row">
			            <?php for ($i=0; $i < 6; $i++) {  ?>
			            <div class="col-sm-6 col-md-4 event_box">
			                <div class="thumbnail">
			                  <img class="img-responsive" src="../images/event-cat/health.jpg" alt="Boovent - ">
			                  <div class="caption">
			                    <h3>Event Title</h3>
			                    <p class="event_time">26-Jan-2017, 10:10 AM</p>
			                    <p class="event_address">Amnora Town, Hadapsar Pune Maharashtra</p>
			                    <p class="card-description">Digital Marketing sector is growing...</p>
			                    <p class="top_2pt"><a href="event-details.php" class="btn btn-primary" role="button">Buy Ticket</a></p>
			                    <p class="event_tag"><a href="#tag">#tag1</a><a href="#tag">#tag2</a></p>
			                  </div>
			                </div>
			            </div>
			            <?php } ?>
			        </div>
			    </div><!-- event_main_box -->
			</div>
		</div>
	</div>
</div>
</div>

<!-- <br><br> -->
<?php
include '../footer.php'; // INCLUDING FOOTER
?>