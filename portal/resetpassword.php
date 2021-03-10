<?php
session_start();
session_destroy();
include 'includes/db_connect.php';
if($_REQUEST['action'] == 'reset'){
$users_q = mysqli_query($db, "SELECT * FROM `users` WHERE `id`='".$_REQUEST['user_id']."'");
$users = mysqli_num_rows($users_q);
$users_f = mysqli_fetch_assoc($users_q);
$users_id = $users_f['id'];
$username = $users_f['username'];
$password = $username.$_POST['password'].$username;
$password = sha1($password);

mysqli_query($db, "UPDATE `users` SET `password`='$password', `passkey`='' WHERE `id`='$users_id'");
echo "<script>window.location='index.php?login=reset'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Customer Portal - AwayCare Inc</title>

		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- text fonts -->
		<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="assets/css/ace.min.css" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" />
		<![endif]-->
		<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body class="login-layout light-login">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>
									<img src="assets/images/logo.png">
								</h1>
								<h4 class="blue" id="id-company-text">&copy; Customer Portal</h4>
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
									
<?php 
$key_temp = explode('-',$_REQUEST['key']);
$key = $key_temp[0];
$id = $key_temp[1];
$users_q = mysqli_query($db, "SELECT * FROM `users` WHERE `passkey`='$key' AND `id`='$id'");
$users = mysqli_num_rows($users_q);
$users_f = mysqli_fetch_assoc($users_q);
$users_id = $users_f['id'];
$username = $users_f['username'];
$password = $username.$_POST['password'].$username;
$password = sha1($password);
if($users >= 1){
?>
										<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<i class="ace-icon fa fa-lock green"></i>
												Enter New Password
											</h4>

											<div class="space-6"></div>

											<form method="post" action="verify_login.php">
												<fieldset>
													<label class="block clearfix" style="margin:0;">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" id="password" name="password" required placeholder="Enter password..." onkeyup="validatePassword();" />
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>
                                                    <label class="block clearfix">
														<input type="button" onclick="generatepassword();" value="Generate Password" class="btn btn-xs" style="color: rgb(51, 51, 51) ! important; background: rgb(241, 241, 241) none repeat scroll 0% 0% ! important; border-width: 1px; margin-top: 5px; text-shadow: 0px 0px; font-family: arial; font-size: 12px;">
													</label>
                                                    <label class="block clearfix">
														<span id="password_check"></span>
													</label>	

													<div class="space"></div>
													
													
													<div class="clearfix">
														<button type="submit" id="submitbtn" class="pull-right btn btn-sm btn-primary">
															<i class="ace-icon fa fa-key"></i>
															<span class="bigger-110">Reset Password</span>
														</button>
													</div>

													<div class="space-4"></div>
													<label class="block text-<?php echo $class;?>"><?php echo $msg;?></label>
													
												</fieldset>
												     <input type="hidden" id="user_id" name="user_id" value="<?php echo $users_id;?>">
											</form>


											<div class="space-6"></div>

										</div><!-- /.widget-main -->
<?php } else {?>
<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<i class="ace-icon fa fa-info green"></i>
												Invalid Request!
											</h4>

											<div class="space-6"></div>


													<label class="block text-danger">Reset password key has been expired or invalid. Submit password reset request again.</label>



											<div class="space-6"></div>

										</div><!-- /.widget-main -->
<?php } ?>										
										<div class="toolbar clearfix">
											<div>
												<a href="index.php" data-target="#forgot-box" class="forgot-password-link">
													<i class="ace-icon fa fa-arrow-left"></i>
													Back to login page
												</a>
											</div>

										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.login-box -->


							</div><!-- /.position-relative -->

						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.main-content -->
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="assets/js/jquery-2.1.4.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
<script>
//"^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}"
function validatePassword() {
	//document.getElementById('password').type = 'password';
    var newPassword = document.getElementById('password').value;
    var minNumberofChars = 8;
    var maxNumberofChars = 16;
    var regularExpression  = /^(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}/;
    //alert(newPassword); 
    if(newPassword.length < minNumberofChars || newPassword.length > maxNumberofChars){
        document.getElementById('password_check').innerHTML = '<i class="fa fa-check fa-lg red"></i> Minimum 8 character required';
		document.getElementById('submitbtn').disabled = true;
    } else 
    if(!regularExpression.test(newPassword)) {
        //alert("password should contain atleast one number and one special character");
		document.getElementById('password_check').innerHTML = '<i class="fa fa-check fa-lg red"></i> Atleast one capitalized character, one number and one special character required';
		document.getElementById('submitbtn').disabled = true;
        return false;
    } else {
		document.getElementById('submitbtn').disabled = false;
		document.getElementById('password_check').innerHTML = '<i class="fa fa-check fa-lg green"></i> Valid Password';
	}
}

function generatepassword(){
String.prototype.pick = function(min, max) {
    var n, chars = '';

    if (typeof max === 'undefined') {
        n = min;
    } else {
        n = min + Math.floor(Math.random() * (max - min + 1));
    }

    for (var i = 0; i < n; i++) {
        chars += this.charAt(Math.floor(Math.random() * this.length));
    }

    return chars;
};

String.prototype.shuffle = function() {
    var array = this.split('');
    var tmp, current, top = array.length;

    if (top) while (--top) {
        current = Math.floor(Math.random() * (top + 1));
        tmp = array[current];
        array[current] = array[top];
        array[top] = tmp;
    }

    return array.join('');
};

var specials = '@$%&*?';
var lowercase = 'abcdefghijklmnopqrstuvwxyz';
var uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
var numbers = '0123456789';

var all = uppercase + lowercase + numbers + specials;
//var all = specials + lowercase + uppercase + numbers;

var password = '';
password += uppercase.pick(1);
password += lowercase.pick(5);
password += specials.pick(1);
password += numbers.pick(3);
//password += all.pick(3, 10);
//password = password.shuffle();
document.getElementById('password').type = 'text';
document.getElementById('password').value = password;

validatePassword();	
}
</script>
		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
			 $(document).on('click', '.toolbar a[data-target]', function(e) {
				e.preventDefault();
				var target = $(this).data('target');
				$('.widget-box.visible').removeClass('visible');//hide others
				$(target).addClass('visible');//show target
			 });
			});
			
			
			
			//you don't need this, just used for changing background
			jQuery(function($) {
			 $('#btn-login-dark').on('click', function(e) {
				$('body').attr('class', 'login-layout');
				$('#id-text2').attr('class', 'white');
				$('#id-company-text').attr('class', 'blue');
				
				e.preventDefault();
			 });
			 $('#btn-login-light').on('click', function(e) {
				$('body').attr('class', 'login-layout light-login');
				$('#id-text2').attr('class', 'grey');
				$('#id-company-text').attr('class', 'blue');
				
				e.preventDefault();
			 });
			 $('#btn-login-blur').on('click', function(e) {
				$('body').attr('class', 'login-layout blur-login');
				$('#id-text2').attr('class', 'white');
				$('#id-company-text').attr('class', 'light-blue');
				
				e.preventDefault();
			 });
			 
			});
		</script>
	</body>
</html>
