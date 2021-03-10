<?php
error_reporting(0);
session_destroy();
?> 
<!doctype html>
<html lang="en-US">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>VTC</title>
		<meta name="description" content="" />
		<!-- mobile settings -->
		<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />

		<!-- WEB FONTS -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&amp;subset=latin,latin-ext,cyrillic,cyrillic-ext" rel="stylesheet" type="text/css" />

		<!-- CORE CSS -->
		<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		
		<!-- THEME CSS -->
		<link href="assets/css/essentials.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/layout.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/color_scheme/green.css" rel="stylesheet" type="text/css" id="color_scheme" />
	</head>
	<!--
		.boxed = boxed version
	-->
	<body>
		<div class="padding-15">
			<div class="login-box">
				<!-- login form -->
				<form action="verify_login.php" method="post" class="sky-form boxed">
					<header style="text-align:center;"><i><img src="images/logo.png"></i><br/> <span style="font-size: 13px; text-transform: uppercase; font-weight: bold;">ADMINISTRATION</span></header>
                    <?php
					if($_REQUEST['action'] == 'failed'){
					?>
					<div class="alert alert-danger noborder text-center weight-400 nomargin noradius">
						Invalid Username or Password!
					</div>
                    <?php } ?>
                    <?php
					if($_REQUEST['session'] == 'out'){
					?>
                    <div class="alert alert-danger noborder text-center weight-400 nomargin noradius">
						Session Out! You need to re-login.
					</div>
					<?php
					}
					?>
                    <?php
					if($_REQUEST['action'] == 'inactive'){?>

					<div class="alert alert-warning noborder text-center weight-400 nomargin noradius">
						Account Inactive!
					</div>
<?php } ?>
					<fieldset>	
						<section>
							<label class="label">Username</label>
							<label class="input">
								<i class="icon-append fa fa-user"></i>
								<input type="text" id="user_name" name="user_name">
								<span class="tooltip tooltip-top-right">Type your Username</span>
							</label>
						</section>
						<section>
							<label class="label">Password</label>
							<label class="input">
								<i class="icon-append fa fa-lock"></i>
								<input type="password" name="user_password" id="user_password">
								<b class="tooltip tooltip-top-right">Type your Password</b>
							</label>
							<label class="checkbox"><input type="checkbox" name="checkbox-inline" checked><i></i>Keep me logged in</label>
						</section>
					</fieldset>
					<footer>
						<button type="submit" class="btn btn-primary pull-right">Sign In</button>
						<div class="forgot-password pull-left">
							<a href="#">Forgot password?</a> <br />
						</div>
					</footer>
				</form>
				<!-- /login form -->
			</div>
		</div>
		<!-- JAVASCRIPT FILES -->
		<script type="text/javascript">var plugin_path = 'assets/plugins/';</script>
		<script type="text/javascript" src="assets/plugins/jquery/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="assets/js/app.js"></script>
	</body>
</html>