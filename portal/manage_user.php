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
$user_mg_capability = $user_f['mg_capability'];
$user_fiscal_year = $user_f['fiscal_year'];
$user_logo = $user_f['logo'];

if($_REQUEST['action'] == 'add'){
$code_q = mysqli_query($db, "SELECT MAX(`id`) AS 'maxid' FROM `users`");
$code_r = mysqli_fetch_assoc($code_q);
$maxid = $code_r['maxid'] + 1;

if($_POST['user_type'] == 'db' || $_POST['user_type'] == 'broker'){
$bcvalue = '7';
$dvalue = '16';	
}
else if($_POST['user_type'] == 'da' || $_POST['user_type'] == 'agent'){
$bcvalue = '16';
$dvalue = '21';		
}
$colum_b = number_format($maxid / $bcvalue,0); //8
$column_c = number_format($colum_b * $bcvalue,0); //56
$b_c = $maxid - $column_c;
$colum_d = $maxid * $dvalue;
$user_code = $colum_d + $b_c;

$parent_id = $_POST['parent_id'];
$user_type = $_POST['user_type'];

if($user_type == 'db'){
$user_type = 'broker';	
} else if($user_type == 'da'){
$user_type = 'agent';
}

if($parent_id == '0'){
$level = '1';
}else {
$level = '2';
}


//Adding Logo
$newfile = date('dmYHis').'_'.str_replace(" ", "", basename( $_FILES['logo']['name']));	
move_uploaded_file($_FILES['logo']['tmp_name'], "logos/" .$newfile);
$logo = date('dmYHis').'_'.$_FILES['logo']['name'];


$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$city = $_POST['city'];
$province = $_POST['province'];
$postal = $_POST['postal'];
$country = $_POST['country'];
$dob = $_POST['dob'];
$facebook = $_POST['facebook'];
$twitter = $_POST['twitter'];
$about_me = $_POST['about_me'];
$username = $_POST['username'];
$password = $username.$_POST['password'].$username;
$password = sha1($password);
$commission_rate = $_POST['commission_rate'];
$status = $_POST['status'];
$mg_capability = $_POST['mg_capability'];
$fiscal_year = $_POST['fiscal_year'];

mysqli_query($db,"INSERT INTO `users`(`fname`, `lname`, `email`, `phone`, `dob`, `about_me`, `facebook`, `twitter`, `username`, `password`, `address`, `province`, `city`, `country`, `postal`, `user_type`, `parent_id`, `status`, `user_level`, `unique_code`, `mg_capability`, `fiscal_year`, `logo`) VALUES ('$fname','$lname','$email','$phone','$dob','$about_me','$facebook','$twitter','$username','$password','$address','$province','$city','$country','$postal','$user_type','$parent_id','$status','$level', '$user_code', '$mg_capability', '$fiscal_year', '$logo')");

echo "<script>window.location='users.php'</script>";
}
else if($_REQUEST['action'] == 'update'){

$parent_id = $_POST['parent_id'];

$user_type = $_POST['user_type'];

if($user_type == 'db'){
$user_type = 'broker';	
} else if($user_type == 'da'){
$user_type = 'agent';	
}

if($parent_id == '0'){
$level = '1';
}else {
$level = '2';
}

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$city = $_POST['city'];
$province = $_POST['province'];
$postal = $_POST['postal'];
$country = $_POST['country'];
$dob = $_POST['dob'];
$facebook = $_POST['facebook'];
$twitter = $_POST['twitter'];
$about_me = $_POST['about_me'];
$username = $user_username;
$password = $username.$_POST['password'].$username;
$password = sha1($password);
if($_POST['password'] == ''){
$password = $user_password;
}
$commission_rate = $_POST['commission_rate'];
$status = $_POST['status'];
$mg_capability = $_POST['mg_capability'];
$fiscal_year = $_POST['fiscal_year'];

//Adding Logo
if($_FILES['logo']['name'] == ''){
$logo = $_POST['current_logo'];
} else {
$newfile = date('dmYHis').'_'.str_replace(" ", "", basename( $_FILES['logo']['name']));	
move_uploaded_file($_FILES['logo']['tmp_name'], "logos/" .$newfile);
$logo = date('dmYHis').'_'.$_FILES['logo']['name'];
}

$update_id = $_REQUEST['id'];	
mysqli_query($db, "UPDATE `users` SET `fname`='$fname', `lname`='$lname', `email`='$email', `phone`='$phone', `dob`='$dob', `about_me`='$about_me', `facebook`='$facebook', `twitter`='$twitter', `address`='$address', `province`='$province', `postal`='$postal', `user_type`='$user_type', `parent_id`='$parent_id', `country`='$country', `username`='$username', `password`='$password', `status`='$status', `mg_capability`='$mg_capability', `fiscal_year`='$fiscal_year', `logo`='$logo' WHERE `id`='$update_id'") or die(mysqli_error($db));;
/*$update_q = $dbp->prepare("UPDATE `users` SET `user_pic`=?, `fname`=?, `lname`=?, `email`=?, `phone`=?, `dob`=?, `about_me`=?, `facebook`=?, `twitter`=? WHERE `id`=?");
$update_q->bind_param('bbbbbbbbbb', $user_pic, $fname, $lname, $email, $phone, $dob, $about_me, $facebook, $twitter, $_SESSION['portal_id']);
$update_q->execute();
$update_q->close();*/

echo "<script>window.location='user_profile.php?id=$update_id'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>User Profile</title>

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
<link rel="stylesheet" href="assets/datepicker/jquery-ui.css">
<script src="assets/datepicker/jquery-1.12.4.js"></script>
<script src="assets/datepicker/jquery-ui.js"></script>
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
});

$( function() {
$( "#fiscal_year" ).datepicker({
  changeMonth: true,
      changeYear: true,
	  dateFormat: 'yy-mm-dd',
	  endDate: "today",
      maxDate: "today",
});
});


</script>
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
							<li class="active">Add/Edit Profile</li>
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
								<?php echo $user_fname.' '.$user_lname;?>
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Update user profile below:
								</small>
								<?php if($_REQUEST['id'] != ''){?>
								<button class="btn btn-primary btn-xs pull-right" onClick="window.location='user_profile.php?id=<?php echo $_REQUEST['id'];?>'"><i class="fa fa-eye"></i> View Profile</i></button>
								<?php } ?>
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
														Add/Edit Profile
													</a>
												</li>

											</ul>

											<div class="tab-content no-border padding-24">
												<div id="home" class="tab-pane in active">
												<form method="post" action="?action=<?php if($_REQUEST['id'] == ''){echo 'add'; } else { echo 'update'; ?>&id=<?php echo $_REQUEST['id']; }?>" enctype="multipart/form-data">
													<div class="row">
														<div class="col-xs-12 col-sm-12">
															<h4 class="red">
																<span class="middle"><strong>Personal Details</strong></span>
															</h4>
															<div class="profile-user-info">
                                                            <div class="profile-info-row">
																	<div class="profile-info-name"> Management Capability </div>

																	<div class="profile-info-value">
																		<span><small>License and E&O Management capability ?</small> <br/>
                                                                        <label>
                                                                            <input type="checkbox" class="ace ace-switch ace-switch-5" name="mg_capability" value="1" <?php if($user_mg_capability == '1'){?> checked <?php } ?>>
                                                                            <span class="lbl"></span>
                                                                        </label>
                                                                        </span>
																	</div>
																</div>
															<div class="profile-info-row">
																	<div class="profile-info-name"> Joining </div>

																	<div class="profile-info-value">
																		<span><?php echo $user_join_date; if($_REQUEST['id'] == ''){ echo date('Y-m-d h:i:s'); }?></span>
																	</div>
																</div>
                                                                <div class="profile-info-row">
																	<div class="profile-info-name" style="width: 200px;">
																		<i class="ace-icon fa fa-file red"></i>
																		Select Logo
																	</div>

																	<div class="profile-info-value">
																		<div class="form-group">
															<div class="col-xs-6">
																<input type="file" id="logo" name="logo" />
															</div>
														</div>
																	</div>
																</div>
																<div class="profile-info-row">
																	<div class="profile-info-name"> Status </div>

																<div class="profile-info-value col-md-2">
																<select id="form-field-select-1" class="form-control" name="status" required="required">
																	<option value="">SELECT ACCOUNT STATUS</option>
																	<option <?php if($user_status == 'active'){?> selected="selected" <?php } ?> value="active">Active</option>
																	<option <?php if($user_status == 'pending'){?> selected="selected" <?php } ?> value="pending">Pending</option>
																	<option <?php if($user_status == 'suspended'){?> selected="selected" <?php } ?> value="suspended">Suspended</option>
																</select>
																	</div>
																</div>
																<div class="profile-info-row">
																	<div class="profile-info-name"> User Type </div>

																	<div class="profile-info-value col-md-2">
																		<select class="form-control" name="user_type" id="user_type" required="required" onChange="mustparent()">
																<option value="">SELECT USER TYPE</option>
																<?php if($sess_user_type == 'admin'){?>
																<option <?php if($user_user_type == 'admin'){?> selected="selected" <?php } ?> value="admin">Admin</option>
																<option <?php if($user_user_type == 'broker'  && $user_user_level == '1'){?> selected="selected" <?php } ?> value="broker">AB Broker</option>
																<option <?php if($user_user_type == 'agent'  && $user_user_level == '1'){?> selected="selected" <?php } ?> value="agent">AB Agent</option>
                                                                <option <?php if($user_user_type == 'broker' && $user_user_level == '2'){?> selected="selected" <?php } ?> value="db">AB Downline Broker</option>
																<option <?php if($user_user_type == 'agent'  && $user_user_level == '2'){?> selected="selected" <?php } ?> value="da">AB Downline Agent</option>
																<?php } else if($sess_user_type == 'broker' || $user_user_level == '1'){?>
                                                                <option <?php if($user_user_type == 'agent' && $user_user_level == '1'){?> selected="selected" <?php } ?> value="agent">AB Agent</option>
																<option <?php if($user_user_type == 'broker'){?> selected="selected" <?php } ?> value="broker">AB Downline Broker</option>
                                                                
																<option <?php if($user_user_type == 'agent'){?> selected="selected" <?php } ?> value="agent">AB Downline Agent</option>
																<?php } else { ?>
																<option <?php if($user_user_type == 'agent'){?> selected="selected" <?php } ?> value="agent">AB Downline Agent</option>
																<?php } ?>
															</select>
																	</div>
												<script>
                                                function mustparent(){
												if(document.getElementById('user_type').value == 'db'){
													if(document.getElementById('parent_id').value == 0){
													document.getElementById('submitbtn').disabled = true;
													document.getElementById('err').innerHTML = '<i class="fa fa-warning"></i> Please select a parent';
													}
													else {
													document.getElementById('submitbtn').disabled = false;
													document.getElementById('err').innerHTML = '';	
													}		
                                                }
												else if(document.getElementById('user_type').value == 'da'){
													if(document.getElementById('parent_id').value == 0){
													document.getElementById('submitbtn').disabled = true;
													document.getElementById('err').innerHTML = '<i class="fa fa-warning"></i> Please select a parent';
													}
													else {
													document.getElementById('submitbtn').disabled = false;
													document.getElementById('err').innerHTML = '';	
													}

                                                } else {
												document.getElementById('submitbtn').disabled = false;
												document.getElementById('err').innerHTML = '';	
												}
                                                }
                                                </script>
																</div>
																<?php if($sess_user_type == 'admin'){?>
																<div class="profile-info-row">
																	<div class="profile-info-name"> Parent User </div>

																	<div class="profile-info-value col-md-2">
																		<select class="form-control" name="parent_id" id="parent_id" required="required" onChange="mustparent()">
																		<option value="0">N/A</option>
																		<?php $sql = mysqli_query($db, "SELECT * FROM `users` WHERE `user_type`='broker'");
																		while($fet = mysqli_fetch_assoc($sql)){
																		?>
																		<option <?php if($user_parent_id == $fet['id']){?> selected="selected" <?php } ?> value="<?php echo $fet['id'];?>"><?php echo $fet['fname'].' '.$fet['lname']; ?></option>
																		<?php } ?>
																		</select>
																	</div>
                                                                    <div class="profile-info-value col-md-2"><span id="err" class="text-danger"></span></div>
																</div>
																<?php } else {
																$sql = mysqli_query($db, "SELECT * FROM `users` WHERE `id`='".$_REQUEST['id']."'");
																$fet = mysqli_fetch_assoc($sql);
																$parent = $fet['parent_id'];
																if($parent == ''){
																$parent = $_SESSION['portal_id'];
																}
																 ?>
																<input type="hidden" value="<?php echo $parent;?>" name="parent_id" required>
																<?php } ?>
																<div class="profile-info-row">
																	<div class="profile-info-name"> Fiscal Year Starts From</div>

																	<div class="profile-info-value col-md-3">
			
																			<div class="input-group">
																				<input class="form-control date-picker" name="fiscal_year" id="fiscal_year" value="<?php echo $user_fiscal_year;?>" type="text" data-date-format="dd-mm-yyyy" placeholder="YYYY-MM-DD" readonly data-required="true"
 />
																				<span class="input-group-addon">
																					<i class="fa fa-calendar bigger-110"></i>
																				</span>
																			</div>

																	</div>
																</div>
                                                                <div class="profile-info-row">
																	<div class="profile-info-name"> Name </div>

																	<div class="profile-info-value">
																		<span><input type="text" class="col-xs-12 col-sm-3" placeholder="First Name" name="fname" id="fname" style="margin-right:5px;" value="<?php echo $user_fname;?>" required onKeyUp="suggestusername();"></span>
																		<span><input type="text" class="col-xs-12 col-sm-3" placeholder="Last Name"  name="lname" id="lname" value="<?php echo $user_lname;?>" required onKeyUp="suggestusername();"></span>
																	</div>
																</div>
																<div class="profile-info-row">
																	<div class="profile-info-name"><i class="fa fa-envelope light-blue bigger-110"></i> Email </div>

																	<div class="profile-info-value">
																		
																		<span><input type="email" class="col-xs-12 col-sm-3" placeholder="Email" id="form-field-1" name="email" value="<?php echo $user_email;?>" required></span>
																	</div>
																</div>
																
																<div class="profile-info-row">
																	<div class="profile-info-name"><i class="fa fa-phone light-red bigger-110"></i> Phone </div>

																	<div class="profile-info-value">
																		
																		<span><input type="text" class="col-xs-12 col-sm-3" placeholder="Phone Number" id="form-field-1" name="phone" value="<?php echo $user_phone;?>" required></span>
																	</div>
																</div>

																<div class="profile-info-row">
																	<div class="profile-info-name"><i class="fa fa-map-marker light-orange bigger-110"></i> Location </div>

																	<div class="profile-info-value">
																		<span><input type="text" class="col-xs-12 col-sm-6" placeholder="Address" id="form-field-1" name="address" value="<?php echo $user_address;?>" required> 
																		<input type="text" class="col-xs-12 col-sm-3" placeholder="City" id="form-field-1" name="city" value="<?php echo $user_city;?>" required>
																		<input type="text" class="col-xs-12 col-sm-3" placeholder="Province" id="form-field-1" name="province" value="<?php echo $user_province;?>" required>
																		<input type="text" class="col-xs-12 col-sm-3" placeholder="Postcode" id="form-field-1" name="postal" value="<?php echo $user_postal;?>" required>
																		<select id="form-field-select-1" class="col-xs-12 col-sm-6" name="country" required="required" style="height: 34px">
<option selected="selected" label="Select a country … " value="0">Select a country … </option>
<optgroup id="country-optgroup-Africa" label="Africa">
<option <?php if($user_country == 'DZ'){?> selected <?php } ?> value="DZ" label="Algeria">Algeria</option>
<option <?php if($user_country == 'AO'){?> selected <?php } ?>value="AO" label="Angola">Angola</option>
<option <?php if($user_country == 'BJ'){?> selected <?php } ?>value="BJ" label="Benin">Benin</option>
<option <?php if($user_country == 'BW'){?> selected <?php } ?>value="BW" label="Botswana">Botswana</option>
<option <?php if($user_country == 'BF'){?> selected <?php } ?>value="BF" label="Burkina Faso">Burkina Faso</option>
<option <?php if($user_country == 'BI'){?> selected <?php } ?>value="BI" label="Burundi">Burundi</option>
<option <?php if($user_country == 'CM'){?> selected <?php } ?>value="CM" label="Cameroon">Cameroon</option>
<option <?php if($user_country == 'CV'){?> selected <?php } ?>value="CV" label="Cape Verde">Cape Verde</option>
<option <?php if($user_country == 'CF'){?> selected <?php } ?>value="CF" label="Central African Republic">Central African Republic</option>
<option <?php if($user_country == 'TD'){?> selected <?php } ?>value="TD" label="Chad">Chad</option>
<option <?php if($user_country == 'KM'){?> selected <?php } ?>value="KM" label="Comoros">Comoros</option>
<option <?php if($user_country == 'CG'){?> selected <?php } ?>value="CG" label="Congo - Brazzaville">Congo - Brazzaville</option>
<option <?php if($user_country == 'CD'){?> selected <?php } ?>value="CD" label="Congo - Kinshasa">Congo - Kinshasa</option>
<option <?php if($user_country == 'CI'){?> selected <?php } ?>value="CI" label="Côte d’Ivoire">Côte d’Ivoire</option>
<option <?php if($user_country == 'DJ'){?> selected <?php } ?>value="DJ" label="Djibouti">Djibouti</option>
<option <?php if($user_country == 'EG'){?> selected <?php } ?>value="EG" label="Egypt">Egypt</option>
<option <?php if($user_country == 'GQ'){?> selected <?php } ?>value="GQ" label="Equatorial Guinea">Equatorial Guinea</option>
<option <?php if($user_country == 'ER'){?> selected <?php } ?>value="ER" label="Eritrea">Eritrea</option>
<option <?php if($user_country == 'ET'){?> selected <?php } ?>value="ET" label="Ethiopia">Ethiopia</option>
<option <?php if($user_country == 'GA'){?> selected <?php } ?>value="GA" label="Gabon">Gabon</option>
<option <?php if($user_country == 'GM'){?> selected <?php } ?>value="GM" label="Gambia">Gambia</option>
<option <?php if($user_country == 'GH'){?> selected <?php } ?>value="GH" label="Ghana">Ghana</option>
<option <?php if($user_country == 'GN'){?> selected <?php } ?>value="GN" label="Guinea">Guinea</option>
<option <?php if($user_country == 'GW'){?> selected <?php } ?>value="GW" label="Guinea-Bissau">Guinea-Bissau</option>
<option <?php if($user_country == 'KE'){?> selected <?php } ?>value="KE" label="Kenya">Kenya</option>
<option <?php if($user_country == 'LS'){?> selected <?php } ?>value="LS" label="Lesotho">Lesotho</option>
<option <?php if($user_country == 'LR'){?> selected <?php } ?>value="LR" label="Liberia">Liberia</option>
<option <?php if($user_country == 'LY'){?> selected <?php } ?>value="LY" label="Libya">Libya</option>
<option <?php if($user_country == 'MG'){?> selected <?php } ?>value="MG" label="Madagascar">Madagascar</option>
<option <?php if($user_country == 'MW'){?> selected <?php } ?>value="MW" label="Malawi">Malawi</option>
<option <?php if($user_country == 'ML'){?> selected <?php } ?>value="ML" label="Mali">Mali</option>
<option <?php if($user_country == 'MR'){?> selected <?php } ?>value="MR" label="Mauritania">Mauritania</option>
<option <?php if($user_country == 'MU'){?> selected <?php } ?>value="MU" label="Mauritius">Mauritius</option>
<option <?php if($user_country == 'YT'){?> selected <?php } ?>value="YT" label="Mayotte">Mayotte</option>
<option <?php if($user_country == 'MA'){?> selected <?php } ?>value="MA" label="Morocco">Morocco</option>
<option <?php if($user_country == 'MX'){?> selected <?php } ?>value="MZ" label="Mozambique">Mozambique</option>
<option <?php if($user_country == 'NA'){?> selected <?php } ?>value="NA" label="Namibia">Namibia</option>
<option <?php if($user_country == 'NE'){?> selected <?php } ?>value="NE" label="Niger">Niger</option>
<option <?php if($user_country == 'NG'){?> selected <?php } ?>value="NG" label="Nigeria">Nigeria</option>
<option <?php if($user_country == 'RW'){?> selected <?php } ?>value="RW" label="Rwanda">Rwanda</option>
<option <?php if($user_country == 'RE'){?> selected <?php } ?>value="RE" label="Réunion">Réunion</option>
<option <?php if($user_country == 'SH'){?> selected <?php } ?>value="SH" label="Saint Helena">Saint Helena</option>
<option <?php if($user_country == 'SN'){?> selected <?php } ?>value="SN" label="Senegal">Senegal</option>
<option <?php if($user_country == 'SC'){?> selected <?php } ?>value="SC" label="Seychelles">Seychelles</option>
<option <?php if($user_country == 'SL'){?> selected <?php } ?>value="SL" label="Sierra Leone">Sierra Leone</option>
<option <?php if($user_country == 'SO'){?> selected <?php } ?>value="SO" label="Somalia">Somalia</option>
<option <?php if($user_country == 'ZA'){?> selected <?php } ?>value="ZA" label="South Africa">South Africa</option>
<option <?php if($user_country == 'SD'){?> selected <?php } ?>value="SD" label="Sudan">Sudan</option>
<option <?php if($user_country == 'SZ'){?> selected <?php } ?>value="SZ" label="Swaziland">Swaziland</option>
<option <?php if($user_country == 'ST'){?> selected <?php } ?>value="ST" label="São Tomé and Príncipe">São Tomé and Príncipe</option>
<option <?php if($user_country == 'TZ'){?> selected <?php } ?>value="TZ" label="Tanzania">Tanzania</option>
<option <?php if($user_country == 'TG'){?> selected <?php } ?>value="TG" label="Togo">Togo</option>
<option <?php if($user_country == 'TN'){?> selected <?php } ?>value="TN" label="Tunisia">Tunisia</option>
<option <?php if($user_country == 'UG'){?> selected <?php } ?>value="UG" label="Uganda">Uganda</option>
<option <?php if($user_country == 'EH'){?> selected <?php } ?>value="EH" label="Western Sahara">Western Sahara</option>
<option <?php if($user_country == 'ZM'){?> selected <?php } ?>value="ZM" label="Zambia">Zambia</option>
<option <?php if($user_country == 'ZW'){?> selected <?php } ?>value="ZW" label="Zimbabwe">Zimbabwe</option>
</optgroup>
<optgroup id="country-optgroup-Americas" label="Americas">
<option <?php if($user_country == 'AI'){?> selected <?php } ?>value="AI" label="Anguilla">Anguilla</option>
<option <?php if($user_country == 'AG'){?> selected <?php } ?>value="AG" label="Antigua and Barbuda">Antigua and Barbuda</option>
<option <?php if($user_country == 'AR'){?> selected <?php } ?>value="AR" label="Argentina">Argentina</option>
<option <?php if($user_country == 'AW'){?> selected <?php } ?>value="AW" label="Aruba">Aruba</option>
<option <?php if($user_country == 'BS'){?> selected <?php } ?>value="BS" label="Bahamas">Bahamas</option>
<option <?php if($user_country == 'BB'){?> selected <?php } ?>value="BB" label="Barbados">Barbados</option>
<option <?php if($user_country == 'BZ'){?> selected <?php } ?>value="BZ" label="Belize">Belize</option>
<option <?php if($user_country == 'BM'){?> selected <?php } ?>value="BM" label="Bermuda">Bermuda</option>
<option <?php if($user_country == 'BO'){?> selected <?php } ?>value="BO" label="Bolivia">Bolivia</option>
<option <?php if($user_country == 'BR'){?> selected <?php } ?>value="BR" label="Brazil">Brazil</option>
<option <?php if($user_country == 'VG'){?> selected <?php } ?>value="VG" label="British Virgin Islands">British Virgin Islands</option>
<option <?php if($user_country == 'CA'){?> selected <?php } ?>value="CA" label="Canada">Canada</option>
<option <?php if($user_country == 'KY'){?> selected <?php } ?>value="KY" label="Cayman Islands">Cayman Islands</option>
<option <?php if($user_country == 'CL'){?> selected <?php } ?>value="CL" label="Chile">Chile</option>
<option <?php if($user_country == 'CO'){?> selected <?php } ?>value="CO" label="Colombia">Colombia</option>
<option <?php if($user_country == 'CR'){?> selected <?php } ?>value="CR" label="Costa Rica">Costa Rica</option>
<option <?php if($user_country == 'CU'){?> selected <?php } ?>value="CU" label="Cuba">Cuba</option>
<option <?php if($user_country == 'DM'){?> selected <?php } ?>value="DM" label="Dominica">Dominica</option>
<option <?php if($user_country == 'DO'){?> selected <?php } ?>value="DO" label="Dominican Republic">Dominican Republic</option>
<option <?php if($user_country == 'EC'){?> selected <?php } ?>value="EC" label="Ecuador">Ecuador</option>
<option <?php if($user_country == 'SV'){?> selected <?php } ?>value="SV" label="El Salvador">El Salvador</option>
<option <?php if($user_country == 'FK'){?> selected <?php } ?>value="FK" label="Falkland Islands">Falkland Islands</option>
<option <?php if($user_country == 'GF'){?> selected <?php } ?>value="GF" label="French Guiana">French Guiana</option>
<option <?php if($user_country == 'GL'){?> selected <?php } ?>value="GL" label="Greenland">Greenland</option>
<option <?php if($user_country == 'GD'){?> selected <?php } ?>value="GD" label="Grenada">Grenada</option>
<option <?php if($user_country == 'GP'){?> selected <?php } ?>value="GP" label="Guadeloupe">Guadeloupe</option>
<option <?php if($user_country == 'GT'){?> selected <?php } ?>value="GT" label="Guatemala">Guatemala</option>
<option <?php if($user_country == 'GY'){?> selected <?php } ?>value="GY" label="Guyana">Guyana</option>
<option <?php if($user_country == 'HT'){?> selected <?php } ?>value="HT" label="Haiti">Haiti</option>
<option <?php if($user_country == 'HN'){?> selected <?php } ?>value="HN" label="Honduras">Honduras</option>
<option <?php if($user_country == 'JM'){?> selected <?php } ?>value="JM" label="Jamaica">Jamaica</option>
<option <?php if($user_country == 'MQ'){?> selected <?php } ?>value="MQ" label="Martinique">Martinique</option>
<option <?php if($user_country == 'MX'){?> selected <?php } ?>value="MX" label="Mexico">Mexico</option>
<option <?php if($user_country == 'MS'){?> selected <?php } ?>value="MS" label="Montserrat">Montserrat</option>
<option <?php if($user_country == 'AN'){?> selected <?php } ?>value="AN" label="Netherlands Antilles">Netherlands Antilles</option>
<option <?php if($user_country == 'NI'){?> selected <?php } ?>value="NI" label="Nicaragua">Nicaragua</option>
<option <?php if($user_country == 'PA'){?> selected <?php } ?>value="PA" label="Panama">Panama</option>
<option <?php if($user_country == 'PY'){?> selected <?php } ?>value="PY" label="Paraguay">Paraguay</option>
<option <?php if($user_country == 'PE'){?> selected <?php } ?>value="PE" label="Peru">Peru</option>
<option <?php if($user_country == 'PR'){?> selected <?php } ?>value="PR" label="Puerto Rico">Puerto Rico</option>
<option <?php if($user_country == 'BL'){?> selected <?php } ?>value="BL" label="Saint Barthélemy">Saint Barthélemy</option>
<option <?php if($user_country == 'KN'){?> selected <?php } ?>value="KN" label="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
<option <?php if($user_country == 'LC'){?> selected <?php } ?>value="LC" label="Saint Lucia">Saint Lucia</option>
<option <?php if($user_country == 'MF'){?> selected <?php } ?>value="MF" label="Saint Martin">Saint Martin</option>
<option <?php if($user_country == 'PM'){?> selected <?php } ?>value="PM" label="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
<option <?php if($user_country == 'VC'){?> selected <?php } ?>value="VC" label="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
<option <?php if($user_country == 'SR'){?> selected <?php } ?>value="SR" label="Suriname">Suriname</option>
<option <?php if($user_country == 'TT'){?> selected <?php } ?>value="TT" label="Trinidad and Tobago">Trinidad and Tobago</option>
<option <?php if($user_country == 'TC'){?> selected <?php } ?>value="TC" label="Turks and Caicos Islands">Turks and Caicos Islands</option>
<option <?php if($user_country == 'VI'){?> selected <?php } ?>value="VI" label="U.S. Virgin Islands">U.S. Virgin Islands</option>
<option <?php if($user_country == 'US'){?> selected <?php } ?>value="US" label="United States">United States</option>
<option <?php if($user_country == 'UY'){?> selected <?php } ?>value="UY" label="Uruguay">Uruguay</option>
<option <?php if($user_country == 'VE'){?> selected <?php } ?>value="VE" label="Venezuela">Venezuela</option>
</optgroup>
<optgroup id="country-optgroup-Asia" label="Asia">
<option <?php if($user_country == 'AF'){?> selected <?php } ?>value="AF" label="Afghanistan">Afghanistan</option>
<option <?php if($user_country == 'AM'){?> selected <?php } ?>value="AM" label="Armenia">Armenia</option>
<option <?php if($user_country == 'AZ'){?> selected <?php } ?>value="AZ" label="Azerbaijan">Azerbaijan</option>
<option <?php if($user_country == 'BH'){?> selected <?php } ?>value="BH" label="Bahrain">Bahrain</option>
<option <?php if($user_country == 'BD'){?> selected <?php } ?>value="BD" label="Bangladesh">Bangladesh</option>
<option <?php if($user_country == 'BT'){?> selected <?php } ?>value="BT" label="Bhutan">Bhutan</option>
<option <?php if($user_country == 'BN'){?> selected <?php } ?>value="BN" label="Brunei">Brunei</option>
<option <?php if($user_country == 'KH'){?> selected <?php } ?>value="KH" label="Cambodia">Cambodia</option>
<option <?php if($user_country == 'CN'){?> selected <?php } ?>value="CN" label="China">China</option>
<option <?php if($user_country == 'CY'){?> selected <?php } ?>value="CY" label="Cyprus">Cyprus</option>
<option <?php if($user_country == 'GE'){?> selected <?php } ?>value="GE" label="Georgia">Georgia</option>
<option <?php if($user_country == 'HK'){?> selected <?php } ?>value="HK" label="Hong Kong SAR China">Hong Kong SAR China</option>
<option <?php if($user_country == 'IN'){?> selected <?php } ?>value="IN" label="India">India</option>
<option <?php if($user_country == 'ID'){?> selected <?php } ?>value="ID" label="Indonesia">Indonesia</option>
<option <?php if($user_country == 'IR'){?> selected <?php } ?>value="IR" label="Iran">Iran</option>
<option <?php if($user_country == 'IQ'){?> selected <?php } ?>value="IQ" label="Iraq">Iraq</option>
<option <?php if($user_country == 'IL'){?> selected <?php } ?>value="IL" label="Israel">Israel</option>
<option <?php if($user_country == 'JP'){?> selected <?php } ?>value="JP" label="Japan">Japan</option>
<option <?php if($user_country == 'JO'){?> selected <?php } ?>value="JO" label="Jordan">Jordan</option>
<option <?php if($user_country == 'KZ'){?> selected <?php } ?>value="KZ" label="Kazakhstan">Kazakhstan</option>
<option <?php if($user_country == 'KW'){?> selected <?php } ?>value="KW" label="Kuwait">Kuwait</option>
<option <?php if($user_country == 'KG'){?> selected <?php } ?>value="KG" label="Kyrgyzstan">Kyrgyzstan</option>
<option <?php if($user_country == 'LA'){?> selected <?php } ?>value="LA" label="Laos">Laos</option>
<option <?php if($user_country == 'LB'){?> selected <?php } ?>value="LB" label="Lebanon">Lebanon</option>
<option <?php if($user_country == 'MO'){?> selected <?php } ?>value="MO" label="Macau SAR China">Macau SAR China</option>
<option <?php if($user_country == 'MY'){?> selected <?php } ?>value="MY" label="Malaysia">Malaysia</option>
<option <?php if($user_country == 'MV'){?> selected <?php } ?>value="MV" label="Maldives">Maldives</option>
<option <?php if($user_country == 'MN'){?> selected <?php } ?>value="MN" label="Mongolia">Mongolia</option>
<option <?php if($user_country == 'MM'){?> selected <?php } ?>value="MM" label="Myanmar [Burma]">Myanmar [Burma]</option>
<option <?php if($user_country == 'NP'){?> selected <?php } ?>value="NP" label="Nepal">Nepal</option>
<option <?php if($user_country == 'NT'){?> selected <?php } ?>value="NT" label="Neutral Zone">Neutral Zone</option>
<option <?php if($user_country == 'KP'){?> selected <?php } ?>value="KP" label="North Korea">North Korea</option>
<option <?php if($user_country == 'OM'){?> selected <?php } ?>value="OM" label="Oman">Oman</option>
<option <?php if($user_country == 'PK'){?> selected <?php } ?>value="PK" label="Pakistan">Pakistan</option>
<option <?php if($user_country == 'PS'){?> selected <?php } ?>value="PS" label="Palestinian Territories">Palestinian Territories</option>
<option <?php if($user_country == 'YD'){?> selected <?php } ?>value="YD" label="People's Democratic Republic of Yemen">People's Democratic Republic of Yemen</option>
<option <?php if($user_country == 'PH'){?> selected <?php } ?>value="PH" label="Philippines">Philippines</option>
<option <?php if($user_country == 'QA'){?> selected <?php } ?>value="QA" label="Qatar">Qatar</option>
<option <?php if($user_country == 'SA'){?> selected <?php } ?>value="SA" label="Saudi Arabia">Saudi Arabia</option>
<option <?php if($user_country == 'SG'){?> selected <?php } ?>value="SG" label="Singapore">Singapore</option>
<option <?php if($user_country == 'KR'){?> selected <?php } ?>value="KR" label="South Korea">South Korea</option>
<option <?php if($user_country == 'LK'){?> selected <?php } ?>value="LK" label="Sri Lanka">Sri Lanka</option>
<option <?php if($user_country == 'SY'){?> selected <?php } ?>value="SY" label="Syria">Syria</option>
<option <?php if($user_country == 'TW'){?> selected <?php } ?>value="TW" label="Taiwan">Taiwan</option>
<option <?php if($user_country == 'TJ'){?> selected <?php } ?>value="TJ" label="Tajikistan">Tajikistan</option>
<option <?php if($user_country == 'TH'){?> selected <?php } ?>value="TH" label="Thailand">Thailand</option>
<option <?php if($user_country == 'TL'){?> selected <?php } ?>value="TL" label="Timor-Leste">Timor-Leste</option>
<option <?php if($user_country == 'TR'){?> selected <?php } ?>value="TR" label="Turkey">Turkey</option>
<option <?php if($user_country == 'TM'){?> selected <?php } ?>value="TM" label="Turkmenistan">Turkmenistan</option>
<option <?php if($user_country == 'AE'){?> selected <?php } ?>value="AE" label="United Arab Emirates">United Arab Emirates</option>
<option <?php if($user_country == 'UZ'){?> selected <?php } ?>value="UZ" label="Uzbekistan">Uzbekistan</option>
<option <?php if($user_country == 'VN'){?> selected <?php } ?>value="VN" label="Vietnam">Vietnam</option>
<option <?php if($user_country == 'YE'){?> selected <?php } ?>value="YE" label="Yemen">Yemen</option>
</optgroup>
<optgroup id="country-optgroup-Europe" label="Europe">
<option <?php if($user_country == 'AL'){?> selected <?php } ?>value="AL" label="Albania">Albania</option>
<option <?php if($user_country == 'AD'){?> selected <?php } ?>value="AD" label="Andorra">Andorra</option>
<option <?php if($user_country == 'AT'){?> selected <?php } ?>value="AT" label="Austria">Austria</option>
<option <?php if($user_country == 'BY'){?> selected <?php } ?>value="BY" label="Belarus">Belarus</option>
<option <?php if($user_country == 'BE'){?> selected <?php } ?>value="BE" label="Belgium">Belgium</option>
<option <?php if($user_country == 'BA'){?> selected <?php } ?>value="BA" label="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
<option <?php if($user_country == 'BG'){?> selected <?php } ?>value="BG" label="Bulgaria">Bulgaria</option>
<option <?php if($user_country == 'HR'){?> selected <?php } ?>value="HR" label="Croatia">Croatia</option>
<option <?php if($user_country == 'CY'){?> selected <?php } ?>value="CY" label="Cyprus">Cyprus</option>
<option <?php if($user_country == 'CZ'){?> selected <?php } ?>value="CZ" label="Czech Republic">Czech Republic</option>
<option <?php if($user_country == 'DK'){?> selected <?php } ?>value="DK" label="Denmark">Denmark</option>
<option <?php if($user_country == 'DD'){?> selected <?php } ?>value="DD" label="East Germany">East Germany</option>
<option <?php if($user_country == 'EE'){?> selected <?php } ?>value="EE" label="Estonia">Estonia</option>
<option <?php if($user_country == 'FO'){?> selected <?php } ?>value="FO" label="Faroe Islands">Faroe Islands</option>
<option <?php if($user_country == 'FI'){?> selected <?php } ?>value="FI" label="Finland">Finland</option>
<option <?php if($user_country == 'FR'){?> selected <?php } ?>value="FR" label="France">France</option>
<option <?php if($user_country == 'DE'){?> selected <?php } ?>value="DE" label="Germany">Germany</option>
<option <?php if($user_country == 'GI'){?> selected <?php } ?>value="GI" label="Gibraltar">Gibraltar</option>
<option <?php if($user_country == 'GR'){?> selected <?php } ?>value="GR" label="Greece">Greece</option>
<option <?php if($user_country == 'GG'){?> selected <?php } ?>value="GG" label="Guernsey">Guernsey</option>
<option <?php if($user_country == 'HU'){?> selected <?php } ?>value="HU" label="Hungary">Hungary</option>
<option <?php if($user_country == 'IS'){?> selected <?php } ?>value="IS" label="Iceland">Iceland</option>
<option <?php if($user_country == 'IE'){?> selected <?php } ?>value="IE" label="Ireland">Ireland</option>
<option <?php if($user_country == 'IM'){?> selected <?php } ?>value="IM" label="Isle of Man">Isle of Man</option>
<option <?php if($user_country == 'IT'){?> selected <?php } ?>value="IT" label="Italy">Italy</option>
<option <?php if($user_country == 'JE'){?> selected <?php } ?>value="JE" label="Jersey">Jersey</option>
<option <?php if($user_country == 'LV'){?> selected <?php } ?>value="LV" label="Latvia">Latvia</option>
<option <?php if($user_country == 'LI'){?> selected <?php } ?>value="LI" label="Liechtenstein">Liechtenstein</option>
<option <?php if($user_country == 'LT'){?> selected <?php } ?>value="LT" label="Lithuania">Lithuania</option>
<option <?php if($user_country == 'LU'){?> selected <?php } ?>value="LU" label="Luxembourg">Luxembourg</option>
<option <?php if($user_country == 'MK'){?> selected <?php } ?>value="MK" label="Macedonia">Macedonia</option>
<option <?php if($user_country == 'MT'){?> selected <?php } ?>value="MT" label="Malta">Malta</option>
<option <?php if($user_country == 'FX'){?> selected <?php } ?>value="FX" label="Metropolitan France">Metropolitan France</option>
<option <?php if($user_country == 'MD'){?> selected <?php } ?>value="MD" label="Moldova">Moldova</option>
<option <?php if($user_country == 'MC'){?> selected <?php } ?>value="MC" label="Monaco">Monaco</option>
<option <?php if($user_country == 'ME'){?> selected <?php } ?>value="ME" label="Montenegro">Montenegro</option>
<option <?php if($user_country == 'NL'){?> selected <?php } ?>value="NL" label="Netherlands">Netherlands</option>
<option <?php if($user_country == 'NO'){?> selected <?php } ?>value="NO" label="Norway">Norway</option>
<option <?php if($user_country == 'PL'){?> selected <?php } ?>value="PL" label="Poland">Poland</option>
<option <?php if($user_country == 'PT'){?> selected <?php } ?>value="PT" label="Portugal">Portugal</option>
<option <?php if($user_country == 'RO'){?> selected <?php } ?>value="RO" label="Romania">Romania</option>
<option <?php if($user_country == 'RU'){?> selected <?php } ?>value="RU" label="Russia">Russia</option>
<option <?php if($user_country == 'SM'){?> selected <?php } ?>value="SM" label="San Marino">San Marino</option>
<option <?php if($user_country == 'RS'){?> selected <?php } ?>value="RS" label="Serbia">Serbia</option>
<option <?php if($user_country == 'CS'){?> selected <?php } ?>value="CS" label="Serbia and Montenegro">Serbia and Montenegro</option>
<option <?php if($user_country == 'SK'){?> selected <?php } ?>value="SK" label="Slovakia">Slovakia</option>
<option <?php if($user_country == 'ST'){?> selected <?php } ?>value="SI" label="Slovenia">Slovenia</option>
<option <?php if($user_country == 'ES'){?> selected <?php } ?>value="ES" label="Spain">Spain</option>
<option <?php if($user_country == 'SJ'){?> selected <?php } ?>value="SJ" label="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
<option <?php if($user_country == 'SE'){?> selected <?php } ?>value="SE" label="Sweden">Sweden</option>
<option <?php if($user_country == 'CH'){?> selected <?php } ?>value="CH" label="Switzerland">Switzerland</option>
<option <?php if($user_country == 'UA'){?> selected <?php } ?>value="UA" label="Ukraine">Ukraine</option>
<option <?php if($user_country == 'SU'){?> selected <?php } ?>value="SU" label="Union of Soviet Socialist Republics">Union of Soviet Socialist Republics</option>
<option <?php if($user_country == 'GB'){?> selected <?php } ?>value="GB" label="United Kingdom">United Kingdom</option>
<option <?php if($user_country == 'VA'){?> selected <?php } ?>value="VA" label="Vatican City">Vatican City</option>
<option <?php if($user_country == 'AX'){?> selected <?php } ?>value="AX" label="Åland Islands">Åland Islands</option>
</optgroup>
<optgroup id="country-optgroup-Oceania" label="Oceania">
<option <?php if($user_country == 'AS'){?> selected <?php } ?>value="AS" label="American Samoa">American Samoa</option>
<option <?php if($user_country == 'AQ'){?> selected <?php } ?>value="AQ" label="Antarctica">Antarctica</option>
<option <?php if($user_country == 'AU'){?> selected <?php } ?>value="AU" label="Australia">Australia</option>
<option <?php if($user_country == 'BV'){?> selected <?php } ?>value="BV" label="Bouvet Island">Bouvet Island</option>
<option <?php if($user_country == 'IO'){?> selected <?php } ?>value="IO" label="British Indian Ocean Territory">British Indian Ocean Territory</option>
<option <?php if($user_country == 'CX'){?> selected <?php } ?>value="CX" label="Christmas Island">Christmas Island</option>
<option <?php if($user_country == 'CC'){?> selected <?php } ?>value="CC" label="Cocos [Keeling] Islands">Cocos [Keeling] Islands</option>
<option <?php if($user_country == 'CK'){?> selected <?php } ?>value="CK" label="Cook Islands">Cook Islands</option>
<option <?php if($user_country == 'FJ'){?> selected <?php } ?>value="FJ" label="Fiji">Fiji</option>
<option <?php if($user_country == 'PF'){?> selected <?php } ?>value="PF" label="French Polynesia">French Polynesia</option>
<option <?php if($user_country == 'TF'){?> selected <?php } ?>value="TF" label="French Southern Territories">French Southern Territories</option>
<option <?php if($user_country == 'GU'){?> selected <?php } ?>value="GU" label="Guam">Guam</option>
<option <?php if($user_country == 'HM'){?> selected <?php } ?>value="HM" label="Heard Island and McDonald Islands">Heard Island and McDonald Islands</option>
<option <?php if($user_country == 'KI'){?> selected <?php } ?>value="KI" label="Kiribati">Kiribati</option>
<option <?php if($user_country == 'MH'){?> selected <?php } ?>value="MH" label="Marshall Islands">Marshall Islands</option>
<option <?php if($user_country == 'FM'){?> selected <?php } ?>value="FM" label="Micronesia">Micronesia</option>
<option <?php if($user_country == 'NR'){?> selected <?php } ?>value="NR" label="Nauru">Nauru</option>
<option <?php if($user_country == 'NC'){?> selected <?php } ?>value="NC" label="New Caledonia">New Caledonia</option>
<option <?php if($user_country == 'NZ'){?> selected <?php } ?>value="NZ" label="New Zealand">New Zealand</option>
<option <?php if($user_country == 'NU'){?> selected <?php } ?>value="NU" label="Niue">Niue</option>
<option <?php if($user_country == 'NF'){?> selected <?php } ?>value="NF" label="Norfolk Island">Norfolk Island</option>
<option <?php if($user_country == 'MP'){?> selected <?php } ?>value="MP" label="Northern Mariana Islands">Northern Mariana Islands</option>
<option <?php if($user_country == 'PW'){?> selected <?php } ?>value="PW" label="Palau">Palau</option>
<option <?php if($user_country == 'PG'){?> selected <?php } ?>value="PG" label="Papua New Guinea">Papua New Guinea</option>
<option <?php if($user_country == 'PN'){?> selected <?php } ?>value="PN" label="Pitcairn Islands">Pitcairn Islands</option>
<option <?php if($user_country == 'WS'){?> selected <?php } ?>value="WS" label="Samoa">Samoa</option>
<option <?php if($user_country == 'SB'){?> selected <?php } ?>value="SB" label="Solomon Islands">Solomon Islands</option>
<option <?php if($user_country == 'GS'){?> selected <?php } ?>value="GS" label="South Georgia and the South Sandwich Islands">South Georgia and the South Sandwich Islands</option>
<option <?php if($user_country == 'TK'){?> selected <?php } ?>value="TK" label="Tokelau">Tokelau</option>
<option <?php if($user_country == 'TO'){?> selected <?php } ?>value="TO" label="Tonga">Tonga</option>
<option <?php if($user_country == 'TV'){?> selected <?php } ?>value="TV" label="Tuvalu">Tuvalu</option>
<option <?php if($user_country == 'UM'){?> selected <?php } ?>value="UM" label="U.S. Minor Outlying Islands">U.S. Minor Outlying Islands</option>
<option <?php if($user_country == 'VU'){?> selected <?php } ?>value="VU" label="Vanuatu">Vanuatu</option>
<option <?php if($user_country == 'WF'){?> selected <?php } ?>value="WF" label="Wallis and Futuna">Wallis and Futuna</option>
</optgroup>
</select>
																		</span>
																	</div>
																</div>

																<div class="profile-info-row">
																	<div class="profile-info-name"> Date of Birth </div>

																	<div class="profile-info-value col-md-4">
			
																			<div class="input-group">
																				<input class="form-control date-picker" name="dob" id="dob" value="<?php echo $user_dob;?>" type="text" data-date-format="dd-mm-yyyy" readonly data-required="true"
 />
																				<span class="input-group-addon">
																					<i class="fa fa-calendar bigger-110"></i>
																				</span>
																			</div>

																	</div>
																</div>

																

															</div>

															<div class="hr hr-8 dotted"></div>

															<div class="profile-user-info">

																<div class="profile-info-row">
																	<div class="profile-info-name">
																		<i class="middle ace-icon fa fa-facebook-square bigger-150 blue"></i>
																		www.facebook.com/
																	</div>

																	<div class="profile-info-value">
																		<input type="text" class="col-xs-8 col-sm-3" placeholder="Facebook ID" id="form-field-1" name="facebook" value="<?php echo $user_facebook;?>">
																	</div>
																</div>

																<div class="profile-info-row">
																	<div class="profile-info-name">
																		<i class="middle ace-icon fa fa-twitter-square bigger-150 light-blue"></i>
																		www.twitter.com/
																	</div>

																	<div class="profile-info-value">
																	<input type="text" class="col-xs-8 col-sm-3" placeholder="Twitter ID" id="form-field-1" name="twitter" value="<?php echo $user_twitter;?>">
																	</div>
																</div>
															</div>
															
															<div class="hr hr-8 dotted"></div>
															
															<h4 class="red">
																<span class="middle"><strong>Personal Details</strong></span>
															</h4>
															
															
															<div class="profile-user-info">
																<div class="profile-info-row">
																	<div class="profile-info-name">
															
																		Little About Me
																	</div>
																	<div class="profile-info-value">
																	<textarea class="form-control limited" name="about_me" id="form-field-9" maxlength="500" placeholder="Write something about you..."><?php echo $user_about_me;?></textarea>
																		
																	</div>
																</div>
															</div>
															
													
															<div class="space-20"></div>
															<div class="hr hr-8 dotted"></div>

															
															<h4 class="red">
																<span class="middle"><strong>Account Security</strong></span>
															</h4>
															
															<div class="profile-user-info">
																<div class="profile-info-row">
																	<div class="profile-info-name"><i class="ace-icon fa fa-user"></i> Username </div>

																	<div class="profile-info-value col-md-6">
																	<?php if($_REQUEST['id'] == ''){?>
																	<input type="text" class="col-xs-10 col-sm-5" name="username" id="username" placeholder="Username" value="<?php echo $user_username;?>" onkeyup="checkavailable()" required >
																		<span class="help-inline col-xs-12 col-sm-7" id="username_check" style="padding-top:5px;"></span>
																	<script>
																	function suggestusername(){
																	document.getElementById('username').value = document.getElementById('fname').value +'.'+document.getElementById('lname').value;	
																	}
																	</script>
																	<?php } else {?>
																	<?php echo $user_username;?>
																	<?php } ?>	
																	</div>
																</div>	
																<div class="profile-info-row">
																	<div class="profile-info-name"><i class="ace-icon fa fa-lock"></i> <?php if($_REQUEST['id'] != ''){ echo 'Change';} ?> Password </div>

																	<div class="profile-info-value col-md-6">
                                                                    	<div class="col-md-5" style="padding:0;">
																		<input type="password" class="col-xs-12 col-sm-12" name="password" id="password" placeholder="Password" value="" <?php if($_REQUEST['id'] == ''){?> required <?php } ?> onkeyup="validatePassword();">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                        <input type="button" onclick="generatepassword();" value="Generate Password" class="btn btn-xs" style="color: rgb(51, 51, 51) ! important; background: rgb(241, 241, 241) none repeat scroll 0% 0% ! important; border-width: 1px; margin-top: 5px; text-shadow: 0px 0px; font-family: arial; font-size: 12px;">
                                                                        </div>
                                                                        <div class="col-md-12" style="padding:0;">
																		<span class="help-inline col-xs-12 col-sm-7" id="password_check" style="padding-top:5px; padding-left:0;"><?php if($_REQUEST['id'] != ''){?><span class="text-info"><i class="fa fa-warning"></i> Leave blank to use old password</span><?php } ?></span>
                                                                        </div>
																	</div>
																</div>
																<div class="profile-info-row">
																	<div class="profile-info-name"> <i class="ace-icon fa fa-info"></i> </div>
																	<div class="profile-info-value col-md-8">
																	<small>
																	<strong>Password Requirments:</strong> Minimum 8 characters and minium one capitalized character, number character, and special character
																	<small>
																	</div>
																</div>
															</div>
<div class="space-20"></div>

													<div class="space-20"></div>
															<div class="profile-user-info">
																<div class="profile-info-row">
																	<div style="text-align:left; " class="profile-info-name">
																	<input type="submit" value="Submit Changes" class="btn btn-primary" id="submitbtn">
																	</div>

																</div>
															</div>
															
														</div><!-- /.col -->
													</div><!-- /.row -->

													<div class="space-20"></div>

													

													<div class="space-20"></div>

													<div class="space-20"></div>
													<input type="hidden" name="current_logo" id="current_logo" value="<?php echo $user_logo;?>">
												</form>
                                                </div><!-- /#home -->

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
		document.getElementById('password_check').innerHTML = '<i class="fa fa-close fa-lg red"></i> Atleast one capitalized character, one number and one special character required';
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
		
	</body>
</html>
