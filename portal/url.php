<?php
include 'includes/db_connect.php';
if($sess_user_type == 'agent'){
	echo "<script>window.location='dashboard.php'</script>";
}

//if logged in
$user_q = mysqli_query($db, "SELECT * FROM `users` WHERE `id`='".$_REQUEST['id']."'");
$user_f = mysqli_fetch_assoc($user_q);
//$user_q->close();

$user_id = $user_f['id'];
$user_fname = $user_f['fname'];
$user_lname = $user_f['lname'];
$user_user_type = $user_f['user_type'];
$user_unique_code = $user_f['unique_code'];


if($_REQUEST['action'] == 'done'){
$addcode_q = mysqli_query($db, "UPDATE `users` SET `unique_code`='".$_POST['unique_code']."' WHERE `id`='".$_REQUEST['id']."'");
echo "<script>window.location='user_profile.php?id=".$_REQUEST['id']."'</script>";	
}

//checking if it is not admin
if($user_user_type == 'admin'){
	echo "<script>window.location='dashboard.php'</script>";
}

$sub_url = explode('.', $_SERVER['HTTP_HOST']);
$count = count($sub_url);
if($count > 2){
$suburl = $sub_url[0];	
}
else {
$suburl = 'www';	
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Affiliate Code</title>

		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- page specific plugin styles -->

		<!-- text fonts -->
		<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->
		<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
		<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="assets/js/ace-extra.min.js"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body class="no-skin">
	<?php include 'header.php'; ?>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

	<?php include 'sidebar.php'; ?>
	
			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="#">Home</a>
							</li>

							<li>
								<a href="#">Members</a>
							</li>
							<li class="active">Manage URL</li>
						</ul><!-- /.breadcrumb -->

						<div class="nav-search" id="nav-search">
							<form class="form-search">
								<span class="input-icon">
									<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
									<i class="ace-icon fa fa-search nav-search-icon"></i>
								</span>
							</form>
						</div><!-- /.nav-search -->
					</div>

					<div class="page-content">

						<div class="page-header">
							<h1>
								Affiliate Code
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Manage Affiliate Code
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->


								<div class="row">
									<div class="col-xs-12">
											<h4 class="blue">
												<span class="middle"><?php echo $user_fname.' '.$user_lname;?> <small class="text-danger">(<?php echo ucwords(strtolower($user_user_type));?>)</small></span>
												<span class="label label-purple arrowed-in-right">
													<i class="ace-icon fa fa-circle smaller-80 align-middle"></i> active</span>
											</h4>
											
											<div class="profile-user-info">
												<form method="post" action="?action=done&id=<?php echo $_REQUEST['id'];?>">
													<div class="row" style="margin-top:20px;">
														<div class="col-md-12"><strong>Assign URL</strong></div>
														<div class="col-md-12 text-info"><strong style="font-size: 16px;">https://lifeadvice.ca/visitor-insurance/?<?php echo $user_user_type;?>=<input type="text" placeholder="Enter code here" id="unique_code" name="unique_code" onkeyup="checkavailable()" ></strong>
														<span id="url_check" style="padding-top:5px;"></span>
														</div>
														<div class="col-md-12" style="margin-top:20px;"><input type="submit" id="submitbtn" class="btn btn-primary btn-xs" value="Submit Changes"></div>
													</div>
												</form>					
											</div>					
									
									</div>
								</div>



								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

<?php include 'footer.php'; ?>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
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
		<script src="assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->
		<script src="assets/js/jquery.dataTables.min.js"></script>
		<script src="assets/js/jquery.dataTables.bootstrap.min.js"></script>
		<script src="assets/js/dataTables.buttons.min.js"></script>
		<script src="assets/js/buttons.flash.min.js"></script>
		<script src="assets/js/buttons.html5.min.js"></script>
		<script src="assets/js/buttons.print.min.js"></script>
		<script src="assets/js/buttons.colVis.min.js"></script>
		<script src="assets/js/dataTables.select.min.js"></script>

		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
				<script type="text/javascript">
function checkavailable()
{
document.getElementById('url_check').innerHTML = 'Please wait...';

var unique_code = document.getElementById('unique_code').value;
var minNumberofChars = 6;
var maxNumberofChars = 16;
var regularExpression  = /^\d+$/;

if(unique_code.length < minNumberofChars || unique_code.length > maxNumberofChars){
	document.getElementById('url_check').innerHTML = '<i class="fa fa-check fa-lg red"></i4> Minimum 6 number characters required';
	document.getElementById('submitbtn').disabled = true;
}
else 
    if(!regularExpression.test(unique_code)) {
        //alert("password should contain atleast one number and one special character");
		document.getElementById('url_check').innerHTML = '<i class="fa fa-check fa-lg red"></i> Must be numbers characters only';
		document.getElementById('submitbtn').disabled = true;
        return false;
    } 
else {
 $.ajax({
 type: 'get',
 url: 'get_url.php',
 data: {
 get_option: unique_code,
 },
 success: function (response) {
	 if(response >= 1){
		document.getElementById('url_check').innerHTML = '<i class="fa fa-check fa-lg red"></i> Unavailable'; 
		document.getElementById('submitbtn').disabled = true;
	 } else {
		document.getElementById('url_check').innerHTML = '<i class="fa fa-check fa-lg green"></i> Available';  
		document.getElementById('submitbtn').disabled = false;
	 }
 }
 });
}
}
</script>
	</body>
</html>
