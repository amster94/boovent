<?php
include 'header.php'; // INCLUDING HEADER
?>

<div class="container-fluid main_page_heading">
    <div class="jumbotron bvnt_bg_col">
        <div class="row">
            <div class="jumbo_page_heading text-center">
                <h2>CONTACT US</h2>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-6 contact_us_main_box">
            <div class="row well">
                <h3><i class="fa fa-home fa-1x"></i> Address:</h3>               
                <p>T-32, Amanora Park Town, Hdapsar Pune-411028</p>
                
                <h3><i class="fa fa-envelope fa-1x"></i> E-Mail Us At:</h3>
                <p>support@boovent.com</p>
                
                <h3><i class="fa fa-question-circle fa-1x"></i> Write Us If Any Query:</h3>
                
            	<form id="contact-us" method="post" role="form">
                <span id="contact-error"></span>
					<div class="col-xs-12 col-sm-12 col-md-12 form-group top_2pt">
						<input class="" id="name" name="name" type="text" required autofocus />
                        <span class="bar"></span>
                        <span class="floating-label">Name</span>
                    </div>
					<div class="col-xs-12 col-sm-12 col-md-12 form-group top_2pt">
						<input class="" id="email" name="email"  type="email" required />
                        <span class="bar"></span>
                        <span class="floating-label">Email</span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 top_2pt">
					   <textarea class="form-control" id="message" name="message" placeholder="Message" rows="5"></textarea>
					</div>
                    <br/>
                    <div class="col-xs-12 col-sm-12 col-md-4 pull-right top_2pt">
						<input class="btn btn-primary " type="button" value="Send Message" onclick="return contact();" />
					</div>
					
				</form>  
            </div>
        </div>
        <div class="col-sm-6 contact_us_map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15132.86302218272!2d73.9320041700671!3d18.519149748555293!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc2c22145c0bf1b%3A0x785e59a319ccc1cd!2sAmanora+Park+Town%2C+Hadapsar%2C+Pune%2C+Maharashtra!5e0!3m2!1sen!2sin!4v1498222284195"  frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
    </div>
</div>

<!-- <br><br> -->
<?php
include 'footer.php'; // INCLUDING FOOTER
?>
<script type="text/javascript">
function contact() {
    var name = $('#name').val();
    var email = $('#email').val();
    var message = $('#message').val();
    
    if(name!="" && email!="" && message!="") {
    
    $.ajax({
      type:'POST',
      url:'utility/handleContact.php',
      data:{
        name:name,
        email:email,
        message:message
      },
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr);
        console.log(ajaxOptions);
        console.log(thrownError);
      },
      beforeSend: function(){

      },
      success: function(data) {
        // Success
        if(data == "Fail") {
            $('#contact-error').text("Could not recieve message.Please try Again!").css({'color':'red'},{'font-weight':'bold'});
        }else {
            $('#contact-error').text(data).css({'color':'blue'},{'font-weight':'bold'});
        }
        $("input[type=text], input[type=password],input[type=phone], input[type=email], textarea").val('');
      }
      });
    } else {
        if(name=="") {
            $('#contact-error').text('Please provide Name.').css({'color':'red'},{'font-weight':'bold'});
        } else if(email=="") {
            $('#contact-error').text('Please provide Email id.').css({'color':'red'},{'font-weight':'bold'});
        } else {
            $('#contact-error').text('Message cannot be empty.').css({'color':'red'},{'font-weight':'bold'});
        }
    }
}
$("body").css("background-color", "#f5f5f5");
</script>