<?php
require_once 'connect/class.booventpdo.php';

if(!isset($_SESSION))
{
    session_start();
}
require_once( 'Facebook/autoload.php' );
if (isset($_SESSION['user_email'])) {
    $home_url = BASE_URL;
    header('Location: ' . $home_url);
}

$fb = new Facebook\Facebook([
  'app_id' => '164675907428320',
  'app_secret' => 'c67bfb1f61b4eba6556c8771da31aae4',
  'default_graph_version' => 'v2.10',
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://www.boovent.com/callback.php', $permissions);

'<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
include 'header.php'; // INCLUDING HEADER
?>
<script type="text/javascript">
$(document).ready(function(){
  // HIDE LOGIN-SIGNUP MODAL WHEN AUTH.PHP IN OPEN
  $('#login').hide();
  $('#signup').hide();
});
</script>
<style type="text/css">

</style>
<div class="container">
    <div class="row">
      <div id="login_signup_box" class="col-md-8 col-md-offset-2 login_signup_modal">
        <!-- <div class="modal-dialog"> -->
          <!-- <div class="modal-content"> -->
            <!-- <div type="button" class="modal_close_btn pull-right" data-dismiss="modal" aria-hidden="true">✕</div> -->
            
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
                        <div class="col-md-8 top_5pt">
                          <form method="POST" action="">
                            <p class="loginError"></p>
                            <div class="form-group">
                              <input type="text" id="user_email" name="user_email" class="inputText" value=""
                              required/>
                              <span class="bar"></span>
                              <span class="floating-label">Email</span>
                            </div>
                            <div class="form-group">
                              <input type="password" id="user_password" name="user_password" class="password" value="" required/>
                              <span class="bar"></span>
                              <span class="floating-label">Password</span>
                              <span class="show_password">SHOW</span>
                              <span class="hide_password">HIDE</span>
                            </div>
                            <div class="">
                              <a href="#">Forgot Password?</a>
                            </div>
                            <div class="form-group">
                                <input onclick="booventLogin();" type="button" class="btn btn-primary" value="Login">
                            </div>
                            <div class="col-md-12 text-center">
                              <a class="btn facebook_button" href="<?php echo htmlspecialchars($loginUrl); ?>" >Login with Facebook</a>
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
                        <div class="col-md-8 top_5pt">
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
                                <input type="checkbox" id="agree_with_user_terms" class="booventTerms">
                                <span class="box-sign"><i class="fa fa-check" aria-hidden="true"></i></span>
                                I agree with the
                              </label>
                              <a href="term-condition.php"><b>terms and conditions</b></a>
                            </div>
                            <div class="form-group">
                                <input type="button" onclick="booventSignup();" class="btn btn-primary" value="Sign-up">
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
          <!-- </div>modal-content -->
        <!-- </div> -->
      </div>
    </div>
</div><!-- container -->
<?php
include 'footer.php'; // INCLUDING FOOTER
?>
