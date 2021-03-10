<?php
include 'includes/db_connect.php';
if($sess_user_type == 'agent'){
	echo "<script>window.location='dashboard.php'</script>";
}

//if logged in
$user_q = $dbp->prepare("SELECT * FROM `users` WHERE `id`=?");
$user_q->bind_param("i", $_REQUEST['id']);
$user_q->execute();
$user_r = $user_q->get_result(); 
$user_f = $user_r->fetch_assoc();
//$user_q->close();

$user_id = $user_f['id'];
$user_user_pic = $user_f['user_pic'];
$user_fname = $user_f['fname'];
$user_lname = $user_f['lname'];
$user_email = $user_f['email'];
$user_phone = $user_f['phone'];
$user_username = $user_f['username'];
$user_password = $user_f['password'];
$user_address = $user_f['address'];
$user_province = $user_f['province'];
$user_city = $user_f['city'];
$user_country = $user_f['country'];
$user_postal = $user_f['postal'];
$user_user_type = $user_f['user_type'];
$user_parent_id = $user_f['parent_id'];
$user_status = $user_f['status'];
$user_commission_rate = $user_f['commission_rate'];
$user_passkey = $user_f['passkey'];
$user_unique_code = $user_f['unique_code'];
$user_join_date = $user_f['join_date'];
$user_user_pic = $user_f['user_pic'];
$user_user_level = $user_f['user_level'];
$user_dob = $user_f['dob'];
$user_about_me = $user_f['about_me'];
$user_facebook = $user_f['facebook'];
$user_twitter = $user_f['twitter'];
$user_pay_commission = $user_f['pay_commission'];

if($_REQUEST['action'] == 'add'){

$update_q = $dbp->prepare("UPDATE `users` SET `pay_commission`=? WHERE `id`=?");
$update_q->bind_param('ss', $_POST['pay_commission'], $user_id);
$update_q->execute();

//deleting exiting values
mysqli_query($db, "DELETE FROM `comm_rates` WHERE `user_id`='$user_id'");

$p_q = $dbp->prepare("SELECT * FROM `policies`");
$p_q->execute();
$p_q_results = $p_q->get_result();
while($p_f = $p_q_results->fetch_assoc()){
$pid = $p_f['id'];
$rate_value = $_POST['rate_'.$pid];
$allowtosell = $_POST['allowtosell_'.$pid];
if($allowtosell == ''){ $allowtosell = '0'; }
$query = $dbp->prepare("INSERT INTO `comm_rates`(`user_id`, `policy_id`, `comm_rate`, `allowtosell`) VALUES (?, ?, ?, ?)");
$query->bind_param('iisi', $user_id, $pid, $rate_value, $allowtosell);
$query->execute();
//if($query){ echo 'done'; } else { echo 'failed: '.$dbp->error; }
}


$notification = 'Commission rates for <strong>'.$user_fname.' '.$user_lname.'</strong> has been updated by '.$sess_fname.' '.$sess_lname.'.';
$notify_q = $dbp->prepare("INSERT INTO `notifications`(`notification`, `user_id`, `changedby`) VALUES (?,?,?)");
$notify_q->bind_param('sii', $notification, $user_id, $_SESSION['portal_id']);
$notify_q->execute();

if($user_pay_commission != $_POST['pay_commission']){
$notification = 'Pay commission set to '.$_POST['pay_commission'].' for <strong>'.$user_fname.' '.$user_lname.'</strong> by '.$sess_fname.' '.$sess_lname.'.';
$notify_q = $dbp->prepare("INSERT INTO `notifications`(`notification`, `user_id`, `changedby`) VALUES (?,?,?)");
$notify_q->bind_param('sii', $notification, $user_id, $_SESSION['portal_id']);
$notify_q->execute();
}

echo "<script>window.location='user_profile.php?id=$user_id'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>User Profile - AwayCare</title>

		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- page specific plugin styles 
		<link rel="stylesheet" href="assets/css/jquery-ui.custom.min.css" />
		<link rel="stylesheet" href="assets/css/jquery.gritter.min.css" />
		<link rel="stylesheet" href="assets/css/select2.min.css" />-->

		<link rel="stylesheet" href="assets/css/bootstrap-editable.min.css" />

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

		<!-- ace settings handler 
		<script src="assets/js/ace-extra.min.js"></script>-->

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>        
<!--<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$( function() {
$( "#dob" ).datepicker({
  changeMonth: true,
      changeYear: true,
	  dateFormat: 'yy-mm-dd',
	  yearRange: "-100:+0",
	  endDate: "today",
      maxDate: "today",
});
} );
</script>-->
<style>
.ui-widget.ui-widget-content {width:auto; }
</style>
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
								<a href="#">User Profile</a>
							</li>
							<li class="active">Commission Rates</li>
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
								Commission Rates/Settings 
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Manage rates below:
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<div class="">
									<div id="user-profile-2" class="user-profile">
										<div class="tabbable">
											<ul class="nav nav-tabs padding-18">
												<li class="active">
													<a data-toggle="tab" href="#home">
														<i class="green ace-icon fa fa-user bigger-120"></i>
														 Commission Rates/Settings 
													</a>
												</li>

											</ul>

											<div class="tab-content no-border padding-24">
												<form method="post" action="?action=add&id=<?php echo $_REQUEST['id'];?>">
                                                <div class="row">
														<div class="col-xs-12 col-sm-12 col-md-4" style="padding: 0;">
															<h4 class="red">
																<span class="middle"><strong>Commission Settings</strong></span>
															</h4>
                                                                <label>Pay Commission ?</label>
                                                                    <select id="pay_commission" name="pay_commission" class="form-control" required="required">
                                                                        <option value="">Select</option>
                                                                        <option <?php if($user_pay_commission == 'yes'){?> selected <?php } ?> value="yes">Yes</option>
                                                                        <option <?php if($user_pay_commission == 'no'){?> selected <?php } ?> value="no">No</option>
                                                                    </select>
																</div>
												</div>

												<div class="hr hr-8 dotted"></div>
												<div class="row">
                                                <h4 class="red">
                                                    <span class="middle"><strong>Commission Rates</strong></span>
                                                </h4>            
                                                <table class="table  table-bordered table-hover" style="margin-bottom: 50px;">
                                                <thead>
                                                    <tr>
                                                        <th>Policy</th>
                                                        <th>Allowed to Sell</th>
                                                        <th>Commission Rate (%)</th>
                                                        <th>Maximum Value (%)</th>
                                                    <tr>
                                                </thead>
                                                <tbody>
                                                <?php 
												$p_q = $dbp->prepare("SELECT * FROM `policies`");
												$p_q->execute();
												$p_q_results = $p_q->get_result();
												while($p_f = $p_q_results->fetch_assoc()){
													
												$cur_q = mysqli_query($db, "SELECT * FROM `comm_rates` WHERE `user_id`='".$_REQUEST['id']."' AND `policy_id`='".$p_f['id']."'");
												$cur_f = mysqli_fetch_assoc($cur_q);
												
												
												$mcur_q = mysqli_query($db, "SELECT * FROM `comm_rates` WHERE `user_id`='".$user_parent_id."' AND `policy_id`='".$p_f['id']."'");
												$mcur_f = mysqli_fetch_assoc($mcur_q);
												
												?>
                                                	<tr>
                                                        <td><?php echo $p_f['policy_name'];?></td>
                                                        <td><label>
														<input type="checkbox" <?php if($cur_f['allowtosell'] == '1'){?> checked="checked" <?php } ?> class="ace ace-switch ace-switch-5" name="allowtosell_<?php echo $p_f['id'];?>" id="allowtosell_<?php echo $p_f['id'];?>" value="1">
														<span class="lbl"></span>
													</label>
                                                    </td>
                                                        <td><input type="text" name="rate_<?php echo $p_f['id'];?>" id="rate_<?php echo $p_f['id'];?>" class="form-control" value="<?php echo $cur_f['comm_rate'];?>" required> <small class="text-danger" id="errmsg_<?php echo $p_f['id'];?>"></small>
                                                        
<script>
$('#rate_<?php echo $p_f['id'];?>').keyup(function(){
    var val = $(this).val();
    if(isNaN(val)){
         val = val.replace(/[^0-9\.]/g,'');
         if(val.split('.').length>2) 
             val =val.replace(/\.+$/,"");
    }
    $(this).val(val);
	<?php if($user_parent_id != '0'){?>
	if(document.getElementById('rate_<?php echo $p_f['id'];?>').value > Number('<?php echo $mcur_f['comm_rate'];?>')){
	document.getElementById('rate_<?php echo $p_f['id'];?>').value = Number('<?php echo $mcur_f['comm_rate'];?>');
	}
	<?php } ?>
});
</script>
                                                        </td>
                                                        <td><?php echo $mcur_f['comm_rate'];?>%</td>
                                                    </tr>
                                                <?php } ?> 
                                                    <tr>
                                                    	<td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="submit" value="Submit Now" class="btn btn-success pull-right"> <input type="button" value="Cancel" class="btn btn-danger pull-right" onClick="window.location='user_profile.php?id=<?php echo $_REQUEST['id'];?>'" style="margin-right:10px;"> </td>
                                                    </tr>   
                                                </tbody>
                                                </table>
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

			<?php include 'footer.php';?>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> 
		<script src="assets/js/jquery-2.1.4.min.js"></script>-->

		<!-- <![endif]-->

		<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="assets/js/excanvas.min.js"></script>
		<![endif]
		<script src="assets/js/jquery-ui.custom.min.js"></script>
		<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="assets/js/jquery.gritter.min.js"></script>
		<script src="assets/js/bootbox.js"></script>
		<script src="assets/js/jquery.easypiechart.min.js"></script>
		<script src="assets/js/bootstrap-datepicker.min.js"></script>
		<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
		<script src="assets/js/jquery.hotkeys.index.min.js"></script>
		<script src="assets/js/bootstrap-wysiwyg.min.js"></script>
		<script src="assets/js/select2.min.js"></script>
		<script src="assets/js/spinbox.min.js"></script>-->
		<!--<script src="assets/js/bootstrap-editable.min.js"></script>
		<script src="assets/js/ace-editable.min.js"></script>
		<script src="assets/js/jquery.maskedinput.min.js"></script>-->

		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

		<script type="text/javascript">
function checkavailable()
{
document.getElementById('username_check').innerHTML = 'Please wait...';

		
var username = document.getElementById('username').value;
 $.ajax({
 type: 'get',
 url: 'get_username.php',
 data: {
 get_option: username,
 },
 success: function (response) {
	 if(response >= 1){
		document.getElementById('username_check').innerHTML = '<i class="fa fa-check fa-lg red"></i> Unavailable'; 
		document.getElementById('submitbtn').disabled = true;
	 } else {
		document.getElementById('username_check').innerHTML = '<i class="fa fa-check fa-lg green"></i> Available';  
		document.getElementById('submitbtn').disabled = false;
	 }
// document.getElementById("username_check").innerHTML=response; 
 }
 });
}

//"^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}"
function validatePassword() {
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
</script>
		
	</body>
</html>
