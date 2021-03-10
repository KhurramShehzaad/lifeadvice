<?php
session_start();
session_destroy();
include 'includes/db_connect.php';

if($_REQUEST['login']=='failed'){
$class = 'danger';
$msg = 'Invalid login details or Inactive Account!';	
}
else if($_REQUEST['login']=='session_out'){
$class = 'info';
$msg = 'Session Out. Login again!';	
}
else if($_REQUEST['login'] == 'logout'){
$class = 'success';	
$msg = 'Thank you! See you later.';
if(isset($_SESSION['portal_id'])){
unset($_SESSION['portal_id']);
}
}
else if($_REQUEST['login'] == 'reset'){
$class = 'warning';	
$msg = 'Password has been reset successfully.';
}
else if($_REQUEST['login'] == 'reset_sent'){
$class = 'success';	
$msg = 'Instructions has been sent successfully.';	
}

if($_REQUEST['action'] == 'sent'){
$users_q = mysqli_query($db, "SELECT * FROM `users` WHERE `email`='".$_POST['email']."'") or die(mysqli_error($db));;
$users = mysqli_num_rows($users_q);
$users_f = mysqli_fetch_assoc($users_q);
$users_id = $users_f['id'];
$users_name = $users_f['fname'].' '.$users_f['lname'];

if($users == 1){
$to = $_POST['email'];
$key = md5($_POST['email']);

//updating key
mysqli_query($db, "UPDATE `users` SET `passkey`='$key' WHERE `id`='$users_id'");

$link = 'https://lifeadvice.ca/portal/resetpassword.php?key='.$key.'-'.$users_id;
$subject = 'Change Password Request - LifeAdvice.ca';

$headers = "From: " . strip_tags('info@LifeAdvice.ca') . "\r\n";
$headers .= "Reply-To: ". strip_tags('info@LifeAdvice.ca') . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$body = '
<html>
<body style="width: 700px; border: 1px solid rgb(204, 204, 204); margin: 0px auto;">
<table width="700" cellspacing="0" cellpadding="2" border="0" style="border-top: 10px solid #c00; font-family: arial; font-size: 13px;">
  <tbody>
  <tr>
    <td style="background: rgb(255, 255, 255) none repeat scroll 0% 0%; border-bottom: 1px solid rgb(204, 204, 204);"><img src="https://lifeadvice.ca/wp-content/uploads/2018/03/Life-Advice-Insurance-Inc-2.png" /></td>
  </tr>
  <tr>
  	<td style="padding: 10px">
    Dear '.$users_name.',<br>
    <br>
    Click the link below to reset your password:<br>
    <h4><a href="'.$link.'" target="_blank"><strong>Reset Password</strong></a></h4>
    <br>
    
    Best Reards,
    LifeAdvice.ca
    </td>
  </tr>
</tbody>
</table>
</body>
</html>
';

mail($to, $subject, $body, $headers);
}
echo "<script>window.location='index.php?login=reset_sent';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Customer Portal - LifeAdvice</title>

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
						<div class="login-container" style="padding-top:50px;">
							<div class="center">
								<h1>
									<img src="assets/images/logo.png">
								</h1>

							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4>
												<i class="ace-icon fa fa-coffee green"></i>
												 Agent portal login
											</h4>

											<div class="space-6"></div>

											<form method="post" action="verify_login.php">
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" name="username" placeholder="Username" />
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" name="password" placeholder="Password" />
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>

													<div class="space"></div>
													
													
													<div class="clearfix">
														<label class="inline">
															<input type="checkbox" class="ace" />
															<span class="lbl"> Remember Me</span>
														</label>

														<button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
															<i class="ace-icon fa fa-key"></i>
															<span class="bigger-110">Login</span>
														</button>
													</div>

													<div class="space-4"></div>
													<label class="block text-<?php echo $class;?>"><?php echo $msg;?></label>
													
												</fieldset>
											</form>


											<div class="space-6"></div>

										</div><!-- /.widget-main -->

										<div class="toolbar clearfix">
											<div>
												<a href="#" data-target="#forgot-box" class="forgot-password-link">
													<i class="ace-icon fa fa-arrow-left"></i>
													I forgot my password
												</a>
											</div>

										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.login-box -->

								<div id="forgot-box" class="forgot-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header red lighter bigger">
												<i class="ace-icon fa fa-key"></i>
												Retrieve Password
											</h4>

											<div class="space-6"></div>
											<p>
												Enter your email and to receive instructions
											</p>

											<form action="index.php?action=sent" method="post">
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" name="email" id="email" class="form-control" required="required" placeholder="Email" />
															<i class="ace-icon fa fa-envelope"></i>
														</span>
													</label>

													<div class="clearfix">
														<button type="submit" class="width-35 pull-right btn btn-sm btn-danger">
															<i class="ace-icon fa fa-lightbulb-o"></i>
															<span class="bigger-110">Send Me!</span>
														</button>
													</div>
												</fieldset>
											</form>
										</div><!-- /.widget-main -->

										<div class="toolbar center">
											<a href="#" data-target="#login-box" class="back-to-login-link">
												Back to login
												<i class="ace-icon fa fa-arrow-right"></i>
											</a>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.forgot-box -->

								
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
