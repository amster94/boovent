<div class="footer">
	<div class="container">
		<div class="footer_content">
			<div class="col-md-4 col-sm-12 col-xs-12">
				<h3>Contact Info</h3>
				<div class="ft_head_line"></div>
				<ul>
					<li><i class="fa fa-envelope-o" aria-hidden="true"></i><a href="mailto:test@gmail.com">support@boovent.com</a></li>
					<li><i class="fa fa-phone" aria-hidden="true"></i>+91 1234 567 890</li>
				</ul>
			</div>
			<div class="col-md-4 col-sm-12 col-xs-12">
				<h3>Navigation</h3>
				<div class="ft_head_line"></div>
				<ul>
          <li><a href="about.php"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>About us</a></li>
          <li><a href="contact.php"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Contact us</a></li>
          <li><a href="privacy-policy.php"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Privacy Policy</a></li>
          <li><a href="term-condition.php"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Terms and Condition</a></li>
          <!-- <li><a href="pricing.php"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Pricing</a></li> -->
          <li><a href="how-it-works.php"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>How it works</a></li>
          <li><a href="refund.php"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Refund</a></li>
        </ul>
			</div>
			<div class="col-md-4 ">
				<h3>Connect With Us</h3>
				<div class="ft_head_line"></div>
				<form action="sub.php" method="post">
					<div class="form-group">
						<input class="form-control email_subscribe" type="text" name="Email" placeholder="Email" required="">
					</div>
					<div class="form-group">
						<input class="btn btn-primary email_subscribe_btn" type="submit" name="submit" value="Send">
					</div>
				</form>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
</div>
<div class="copy_right">
	<div class="container">
		<p>&copy; 2017 Boovent. All rights reserved </p>
		<!-- <div class="w3_agile_social_icons">
			<ul>
				<li><a href="https://www.facebook.com/Boovent/?ref=settings" class="icon icon-cube agile_facebook"></a></li>
				<li><a href="https://www.instagram.com/boovent17/" class="icon icon-cube agile_instagram"></a></li>
			</ul>
		</div> -->
	</div>
</div>

<!-- ========================== LOGIN SIGN-UP MODAL CODE ================= -->
<div id="login_signup_modal" class="modal fade login_signup_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div type="button" class="modal_close_btn pull-right" data-dismiss="modal" aria-hidden="true">✕
      </div>
      <div class="row">
        <div class="panel panel-login">
          <div class="panel-body padd_0px">
            <!-- <div class="row"> -->
              <div class="login_signup" >
                <div class="login_box" id="login-form">
                  <div class="col-md-4 lg_sp_form_left">
                    <h2>Login</h2>
                    <p>Get access to your Orders, Wishlist and Recommendations</p>
                  	<!-- <img class="img-responsive login_icon" src="images/login-icon.png"> -->
                  </div>
                  <div class="col-md-8">
                    <form method="POST" action="">
                      <p class="loginError"></p>
                      <div class="form-group">
                        <input type="text" id="user_email" name="user_email" class="inputText" value="" required/>
                        <span class="bar"></span>
                        <span class="floating-label">Email</span>
                      </div>
                      <div class="form-group">
                        <input type="password" id="user_password" name="user_password" value="" class="password" required/>
                        <span class="bar"></span>
                        <span class="floating-label">Password</span>
                        <span class="show_password">SHOW</span>
                        <span class="hide_password">HIDE</span>
                      </div>
                      <div class="">
                        <a href="#" data-toggle="modal" data-target="#forget-pass-modal">Forgot Password?</a>
                      </div>
                      <div class="form-group">
                          <input type="button" onclick="booventLogin();" class="btn btn-primary" value="Login">
                      </div>
                      <div class="form-group">
                        <a href="fblogin.php">Login with facebook</a>
                      </div>
                      <div class="col-md-12 text-center">
                        <a href="#" id="register-form-link">New to Boovent? Signup</a>
                      </div>
                    </form>
                  </div>
                </div>

                <div class="signup_box" id="register-form">
                  <div class="col-md-4 lg_sp_form_left">
                    <h2>Signup</h2>
                    <p>We do not share your personal details with anyone.</p>
                  	<!-- <img class="img-responsive login_icon" src="images/login-icon.png"> -->
                  </div>
                  <div class="col-md-8" >
                    <form method="POST" action="">
                      <p class="signupError"></p>
                      <div class="form-group">
                        <input type="text" id="reg_name" name="reg_name" value="" required/>
                        <span class="bar"></span>
                        <span class="floating-label">Name</span>
                      </div>
                      <div class="form-group">
                        <input type="text" id="reg_email" name="reg_email" value="" required/>
                        <span class="bar"></span>
                        <span class="floating-label">Email</span>
                      </div>
                      <div class="form-group">
                        <input type="phone" id="reg_phone" name="reg_phone" value="" required/>
                        <span class="bar"></span>
                        <span class="floating-label">Phone No</span>
                      </div>
                      <div class="form-group">
                        <input type="password" id="reg_password" name="reg_password" value="" class="password" required/>
                        <span class="bar"></span>
                        <span class="floating-label">Password</span>
                        <span class="show_password">SHOW</span>
                        <span class="hide_password">HIDE</span>
                      </div>
                      <div class="row form-group checkbox">
                        <label>
                          <input type="checkbox" id="agree_with_user_terms" >
                          <span class="box-sign"><i class="fa fa-check" aria-hidden="true"></i></span>
                          I am agree with 
                        </label>
                        <a href="#"><b>term and condition</b></a>
                      </div>
                      <div class="form-group">
                          <input type="button" onclick="booventSignup();" class="btn btn-primary" value="Sign-up">
                            <!-- <div class="ripples"><span class="ripplesCircle"></span></div> -->
                      </div>
                      <div class="col-md-12 text-center">
                        <a href="#" class="active" id="login-form-link">Existing User? Login</a>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            <!-- </div> -->
          </div>
        </div>
      </div>
		</div><!-- modal-content -->
  </div>
</div>
<!-- Confirmation Modal -->
<div id="confirmation-modal" class="modal fade confirmation-modal">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
        <p>Please Enter Your Email</p>
    </div>
    <div class="modal-body">
    <div class="row-fluid">
    <p>
    <h3 style="color:#CCC;">
      An Confirmation Mail has been sent to your Email Id to Activate your Account.
    </h3>
    </p>
    </div>
    </div>
    <div class="modal-footer">
    <p style="text-align: center;">Boovent Team</p>
    </div>
    </div>
    
  </div>
</div>
<!-- Forget Modal -->
<div id="forget-pass-modal" class="modal fade forget-pass-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
          <p>Please Enter Your Email</p>
      </div>
    <div class="modal-body">
    <div class="row-fluid">
    <form method="POST" action="">
      <div class="form-group">
      <p class="forgetError"></p>
      <input type="text" id="forget_email" name="forget_email" value="" required/>
      <span class="bar"></span>
      <span class="floating-label">Email</span>
      </div>
      <div class="form-group">
      <input type="button" onclick="forgotPass();" class="btn btn-primary" value="Get Password" />
      </div>
    </form>
    </div>
    </div>
    <div class="modal-footer">
    <p style="text-align: center;">Boovent Team</p>
    </div>
    </div>
    
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
  // $('.show_password').on('click', function(e) {
  //   // $('input[type=password]').prop("type", "text");
  //   $('.password').prop("type", "text");

  //   $(this).hide();
  //   $('.hide_password').show();
  // });
  // $('.hide_password').on('click', function(e) {
  //   $('.password').prop("type", "password");
  //   $(this).hide();
  //   $('.show_password').show();

  // });
})
</script>
<script type="text/javascript" src="js/validateForm.js" ></script>
<script type="text/javascript">

function booventLogin() {
  var email = $('#user_email').val();
  var password = $('#user_password').val();
  if(email!= null && password!=null)
  {
    $.ajax({
      type:'POST',
      url:'utility/handleLoginSignUp.php',
      data:{
        login_email:email,
        password:password
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
        
        $('.loginError').text(data).css({'color':'red'},{'font-weight':'bold'});
        $("input[type=text], input[type=password],input[type=phone], input[type=email], textarea").val('');
        window.location.reload();
      }
      });
  }
  else {
    $('.loginError').empty();
    $('.loginError').text('Email or Password invalid!').css({'color':'red'},{'font-weight':'bold'});
  }
}

function booventSignup() {
  //---------------------------- PROCEED ONLY AFTER AGREEING TO TERMS ----------------------//
  if ($('#agree_with_user_terms').is(':checked')) {
  var name = $('#reg_name').val();
  var email = $('#reg_email').val();
  var phone = $('#reg_phone').val();
  var password = $('#reg_password').val();
  //--------------- CHECK NOT NULL CONDITION ----------------------------//
  if(name!=null && email!=null && phone!=null && password!=null) {
    if(name.length > 20) {
      $('.signupError').empty();
      $('.signupError').text('Name should be below 20 characters!').css({'color':'red'},{'font-weight':'bold'});
    }
    else if(!isEmail(email)) {
      $('.signupError').empty();
      $('.signupError').text('Please provide valid Email!').css({'color':'red'},{'font-weight':'bold'});
    }
    else if(!isPhone(phone)) {
      $('.signupError').empty();
      $('.signupError').text('Please provide valid Phone number!').css({'color':'red'},{'font-weight':'bold'});
    }
    else if(password.length < 3 || password.length > 20) {
      if(password.length < 3) {
        $('.signupError').empty();
        $('.signupError').text('Password should be greater than 3 characters!').css({'color':'red'},{'font-weight':'bold'});
      }
      else {
        $('.signupError').empty();
        $('.signupError').text('Password should be less than 20 characters!').css({'color':'red'},{'font-weight':'bold'});
      }
    }
    else {
      $.ajax({
      type:'POST',
      url:'utility/handleLoginSignUp.php',
      data:{
        signup_email:email,
        password:password,
        phone:phone,
        name:name
      },
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr);
        console.log(ajaxOptions);
        console.log(thrownError);
      },
      beforeSend: function(){
        //alert('Sending Data ! ');
      },
      success: function(data) {
        // Success
        alert(data);
        $('.signupError').text(data).css({'color':'red'},{'font-weight':'bold'});
        $("input[type=text], input[type=password],input[type=phone], input[type=email], textarea").val('');
        $("#agree_with_user_terms").prop('checked', false);
        $('#confirmation-modal').modal('show');
      }
      });
    }
  }
  //-------------- THROW NULL ERROR --------------------------------------//
  else if(name == null) {
    $('.signupError').empty();
    $('.signupError').text('Please enter the Name!').css({'color':'red'},{'font-weight':'bold'});
  }
  else if(email == null) {
    $('.signupError').empty();
    $('.signupError').text('Please enter the Email!').css({'color':'red'},{'font-weight':'bold'});
  }
  else if(phone == null) {
    $('.signupError').empty();
    $('.signupError').text('Please enter the Phone!').css({'color':'red'},{'font-weight':'bold'});
  }
  else {
    $('.signupError').empty();
    $('.signupError').text('Please enter the Password!').css({'color':'red'},{'font-weight':'bold'});
  }
 }
 //------------------------- TELL USER TO ACCEPT TERMS -----------------------------------------//
 else {
    $('.signupError').empty();
    $('.signupError').text('Please accept our Terms!').css({'color':'red'},{'font-weight':'bold'});
 }
}
</script>
<!-- == OPEN LOGIN TAB WITH MODAL ON LOGIN CLICK AND SIGNUP TAB WITH MODAL ON SIGINUP CLICK == -->
<script type="text/javascript">
$(document).ready(function(){
$('#signup').on('click', function(){
  $("#register-form").show();
  $("#login-form").hide();
  $('#login-form-link').removeClass('active');
  $('#register-form-link').addClass('active');
});
$('#login').on('click', function(){
  $("#login-form").show();
  $ ("#register-form").hide();
  $('#register-form-link').removeClass('active');
  $('#login-form-link').addClass('active');
});
});
</script>
<script type="text/javascript">

function forgotPass() {
var emailer = $('#forget_email').val();
$.ajax({
      type:'POST',
      url:'utility/handleForget.php',
      data:{
        forget_email:emailer
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
        alert(data);
      }
      });
}
</script>