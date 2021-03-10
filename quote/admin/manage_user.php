<?php
error_reporting(E_ALL);
session_start();
include 'includes/db_connect.php';
if($sess_user_type == 'agent'){
	echo "<script>window.location='dashboard.php'</script>";
}

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
mysqli_query($db, "UPDATE `users` SET `fname`='$fname', `lname`='$lname', `email`='$email', `phone`='$phone', `dob`='$dob', `about_me`='$about_me', `facebook`='$facebook', `twitter`='$twitter', `address`='$address', `province`='$province', `postal`='$postal', `user_type`='$user_type', `parent_id`='$parent_id', `country`='$country', `username`='$username', `password`='$password', `status`='$status', `mg_capability`='$mg_capability', `fiscal_year`='$fiscal_year', `logo`='$logo' WHERE `id`='$update_id'") or die(mysqli_error($db));
echo "<script>window.location='user_profile.php?id=$update_id'</script>";
}
?>

<!doctype html>

<html lang="en-US">

	<head>

		<meta charset="utf-8" />

		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />

		<title>Manage User</title>

		<meta name="description" content="" />

		<meta name="Author" content="" />



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



		<!-- PAGE LEVEL STYLES -->

		<link href="assets/css/layout-datatables.css" rel="stylesheet" type="text/css" />



	</head>

	<!--

		.boxed = boxed version

	-->

	<body>





		<!-- WRAPPER -->

		<div id="wrapper">



			<!-- 

				ASIDE 

				Keep it outside of #wrapper (responsive purpose)

			-->

			<?php include 'sidebar.php'; ?>

			<!-- /ASIDE -->





			<!-- HEADER -->

			<?php include 'header.php'; ?>

			<!-- /HEADER -->





			<!-- 

				MIDDLE 

			-->

			<section id="middle">





				<!-- page title -->

				<header id="page-header">

					<h1>Manage Users</h1>

					<ol class="breadcrumb">

						<li><a href="users.php">Users</a></li>

						<li class="active">Manage Users</li>

					</ol>

				</header>

				<!-- /page title -->





				<div id="content" class="padding-20">



					<!-- 

						PANEL CLASSES:

							panel-default

							panel-danger

							panel-warning

							panel-info

							panel-success



						INFO: 	panel collapse - stored on user localStorage (handled by app.js _panels() function).

								All pannels should have an unique ID or the panel collapse status will not be stored!

					-->
<?php
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
?>
					<div class="panel panel-default">
                    <form method="post" action="?action=<?php if($_REQUEST['id'] == ''){echo 'add'; } else { echo 'update'; ?>&id=<?php echo $_REQUEST['id']; }?>" enctype="multipart/form-data">
						<div class="panel-heading panel-heading-transparent">
							<strong>User Details</strong>
						</div>

						<div class="panel-body">
                        	<div class="row">
                            	<div class="col-md-12">
                                <h3 class="text-danger"> Personal Details </h3>
                            	</div>
                            </div>
                            <div class="row">
                            	<div class="col-md-3 text-right">
                                <label><strong>Management Capability</strong></label>
                            	</div>
                                <div class="col-md-9">
                                <label> License and E&O Management capability ? </label>
                                <label class="switch switch-success switch-round">
									<input type="checkbox" name="mg_capability" value="1" <?php if($user_mg_capability == '1'){?> checked <?php } ?>>
									<span class="switch-label" data-on="YES" data-off="NO"></span>
								</label>
                            	</div>
                            </div>
							<div class="row">
                            	<div class="col-md-3 text-right">
                                <label><strong>Select Logo</strong></label>
                            	</div>
                                <div class="col-md-9">
                                <!-- fancy no style -->
								<div class="fancy-file-upload">
									<i class="fa fa-upload"></i>
									<input type="file" class="form-control" name="logo" onchange="jQuery(this).next('input').val(this.value);" />
									<input type="text" class="form-control" placeholder="no file selected" readonly="" />
									<span class="button">Choose File</span>
								</div>
                            	</div>
                            </div>
							<div class="row">
                            	<div class="col-md-3 text-right">
                                <label><strong>Status</strong></label>
                            	</div>
                                <div class="col-md-9">
                                <select name="status" id="status" class="form-control">
								<option value="">SELECT ACCOUNT STATUS</option>
								<option <?php if($user_status == 'active'){?> selected="selected" <?php } ?> value="active">Active</option>
								<option <?php if($user_status == 'pending'){?> selected="selected" <?php } ?> value="pending">Pending</option>
								<option <?php if($user_status == 'suspended'){?> selected="selected" <?php } ?> value="suspended">Suspended</option>
								</select>
                            	</div>
                            </div>
							<div class="row">
                            	<div class="col-md-3 text-right">
                                <label><strong>User Type</strong></label>
                            	</div>
                                <div class="col-md-9">
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
                            </div>
							<?php if($sess_user_type == 'admin'){?>
							<div class="row">
                            	<div class="col-md-3 text-right">
                                <label><strong>Parent User</strong></label>
                            	</div>
                                <div class="col-md-9">
								<select class="form-control" name="parent_id" id="parent_id" required="required" onChange="mustparent()">
								<option value="0">N/A</option>
								<?php $sql = mysqli_query($db, "SELECT * FROM `users` WHERE `user_type`='broker'");
								while($fet = mysqli_fetch_assoc($sql)){
								?>
								<option <?php if($user_parent_id == $fet['id']){?> selected="selected" <?php } ?> value="<?php echo $fet['id'];?>"><?php echo $fet['fname'].' '.$fet['lname']; ?></option>
								<?php } ?>
								</select>
								</div>
							</div>
							<?php } else {
							$sql = mysqli_query($db, "SELECT * FROM `users` WHERE `id`='".$_REQUEST['id']."'");
							$fet = mysqli_fetch_assoc($sql);
							$parent = $fet['parent_id'];
							if($parent == ''){
							$parent = $_SESSION['id'];
							}
							 ?>
							<input type="hidden" value="<?php echo $parent;?>" name="parent_id" required>
							<?php } ?>	
							<div class="row">
                            	<div class="col-md-3 text-right">
                                <label><strong>Fiscal Year Starts From</strong></label>
                            	</div>
                                <div class="col-md-9">
								<input type="text" class="form-control datepicker" name="fiscal_year" id="fiscal_year" value="<?php echo $user_fiscal_year;?>" data-format="yyyy-mm-dd" data-lang="en" data-RTL="false">
								</div>
							</div>
							<div class="row">
                            	<div class="col-md-3 text-right">
                                <label><strong>Name</strong></label>
                            	</div>
                                <div class="col-md-4">
								<input type="text" class="form-control" placeholder="First Name" name="fname" id="fname" style="margin-right:5px;" value="<?php echo $user_fname;?>" required onKeyUp="suggestusername();">
								</div>
								<div class="col-md-4">
								<input type="text" class="form-control" placeholder="Last Name"  name="lname" id="lname" value="<?php echo $user_lname;?>" required onKeyUp="suggestusername();">
								</div>
							</div>
							<div class="row">
                            	<div class="col-md-3 text-right">
                                <label><strong><i class="fa fa-envelope"></i> Email</strong></label>
                            	</div>
                                <div class="col-md-9">
								<input type="email" class="form-control" placeholder="Email Address" value="<?php echo $user_email;?>"name="email" id="email" required>
								</div>
							</div>
							<div class="row">
                            	<div class="col-md-3 text-right">
                                <label><strong><i class="fa fa-phone"></i> Phone</strong></label>
                            	</div>
                                <div class="col-md-9">
								<input type="text" class="form-control" placeholder="Phone Number" value="<?php echo $user_phone;?>"name="phone" id="phone" required>
								</div>
							</div>
							<div class="row">
                            	<div class="col-md-3 text-right">
                                <label><strong><i class="fa fa-map-marker"></i> Location</strong></label>
                            	</div>
                                <div class="col-md-4">
								<input type="text" class="form-control" placeholder="Address" id="address" name="address" value="<?php echo $user_address;?>" required /> 
								</div>
								<div class="col-md-3">
								<input type="text" class="form-control" placeholder="City" id="city" name="city" value="<?php echo $user_city;?>" required /> 
								</div>
								<div class="col-md-2">
								<input type="text" class="form-control" placeholder="Province" id="province" name="province" value="<?php echo $user_province;?>" required /> 
								</div>
							</div>
							<div class="row">
                            	<div class="col-md-3 text-right">
                                <label><strong>&nbsp;</strong></label>
                            	</div>
                                <div class="col-md-4">
								<input type="text" class="form-control" placeholder="Postcode" id="postal" name="postal" value="<?php echo $user_postal;?>" required />
								</div>
								<div class="col-md-5">
								<select id="country" class="form-control" name="country" required="required">
<option selected="selected" label="Select a country" <?php if($user_country == ''){?> selected <?php } ?> value="">Select Country</option>
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
								</div>
							</div>							
							<div class="row">
                            	<div class="col-md-3 text-right">
                                <label><strong>Date of Birth</strong></label>
                            	</div>
                                <div class="col-md-9">
								<input class="form-control datepicker" name="dob" id="dob" value="<?php echo $user_dob;?>" type="text" data-format="yyyy-mm-dd" data-lang="en" data-RTL="false" />
								</div>
							</div>
							<div class="row">
                            	<div class="col-md-3 text-right">
                                <label><strong>Little About Me </strong></label>
                            	</div>
                                <div class="col-md-9">
								<textarea class="form-control limited" name="about_me" id="about_me" maxlength="500" placeholder="Write something about you..."><?php echo $user_about_me;?></textarea>
								</div>
							</div>
							<div class="row">
                            	<div class="col-md-12">
                                <h4 class="red">
									<span class="middle"><strong>Account Security</strong></span>
								</h4>
                            	</div>
                            </div>
							<div class="row">
                            	<div class="col-md-3 text-right">
                                <label><strong><i class="fa fa-user"></i> Username</strong></label>
                            	</div>
                                <div class="col-md-9">
								<?php if($_REQUEST['id'] == ''){?>
								<input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo $user_username;?>" onkeyup="checkavailable()" required >
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
							<div class="row">
                            	<div class="col-md-3 text-right">
                                <label><strong><i class="fa fa-lock"></i> <?php if($_REQUEST['id'] != ''){ echo 'Change';} ?> Password</strong></label>
                            	</div>
                                <div class="col-md-9">
								<div class="col-md-5" style="padding:0;">
								<input type="password" class="form-control" name="password" id="password" placeholder="Password" value="" <?php if($_REQUEST['id'] == ''){?> required <?php } ?> onkeyup="validatePassword();">
								</div>
								<div class="col-md-6">
								<input type="button" onclick="generatepassword();" value="Generate Password" class="btn btn-default">
								</div>
								<div class="col-md-12" style="padding:0;">
								<span class="help-inline col-xs-12 col-sm-7" id="password_check" style="padding-top:5px; padding-left:0;"><?php if($_REQUEST['id'] != ''){?><span class="text-info"><i class="fa fa-warning"></i> Leave blank to use old password</span><?php } ?></span>
								</div>
								</div>
							</div>
							
						</div>
						<div class="panel-footer">
							<input type="submit" value="Submit Changes" class="btn btn-primary" id="submitbtn">
						</div>
                        <input type="hidden" name="update_id" value="<?php echo $_REQUEST['id']; ?>">
						<input type="hidden" name="current_logo" id="current_logo" value="<?php echo $user_logo;?>">
                     </form>   
					</div>

					<!-- /PANEL -->



				</div>

			</section>

			<!-- /MIDDLE -->



		</div>







	

		<!-- JAVASCRIPT FILES -->

		<script type="text/javascript">var plugin_path = 'assets/plugins/';</script>

		<script type="text/javascript" src="assets/plugins/jquery/jquery-2.1.4.min.js"></script>

		<script type="text/javascript" src="assets/js/app.js"></script>



		<!-- PAGE LEVEL SCRIPTS -->

		<script type="text/javascript">

			loadScript(plugin_path + "datatables/js/jquery.dataTables.min.js", function(){

				loadScript(plugin_path + "datatables/dataTables.bootstrap.js", function(){



					if (jQuery().dataTable) {



						var table = jQuery('#datatable_sample');

						table.dataTable({

							"columns": [{

								"orderable": false

							}, {

								"orderable": true

							}, {

								"orderable": false

							}, {

								"orderable": false

							}, {

								"orderable": true

							}, {

								"orderable": false

							}],

							"lengthMenu": [

								[5, 15, 20, -1],

								[5, 15, 20, "All"] // change per page values here

							],

							// set the initial value

							"pageLength": 25,            

							"pagingType": "bootstrap_full_number",

							"language": {

								"lengthMenu": "  _MENU_ records",

								"paginate": {

									"previous":"Prev",

									"next": "Next",

									"last": "Last",

									"first": "First"

								}

							},

							"columnDefs": [{  // set default column settings

								'orderable': false,

								'targets': [0]

							}, {

								"searchable": false,

								"targets": [0]

							}],

							"order": [

								[1, "asc"]

							] // set first column as a default sort by asc

						});



						var tableWrapper = jQuery('#datatable_sample_wrapper');



						table.find('.group-checkable').change(function () {

							var set = jQuery(this).attr("data-set");

							var checked = jQuery(this).is(":checked");

							jQuery(set).each(function () {

								if (checked) {

									jQuery(this).attr("checked", true);

									jQuery(this).parents('tr').addClass("active");

								} else {

									jQuery(this).attr("checked", false);

									jQuery(this).parents('tr').removeClass("active");

								}

							});

							jQuery.uniform.update(set);

						});



						table.on('change', 'tbody tr .checkboxes', function () {

							jQuery(this).parents('tr').toggleClass("active");

						});



						tableWrapper.find('.dataTables_length select').addClass("form-control input-xsmall input-inline"); // modify table per page dropdown



					}



				});

			});
<?php
if($_REQUEST['action']){?>			
_toastr("Settings Saved Successfully!","top-right","success",false);
<?php } ?>
		</script>


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
		document.getElementById('username_check').innerHTML = '<i class="fa fa-close fa-lg text-danger"></i> Unavailable'; 
		document.getElementById('submitbtn').disabled = true;
	 } else {
		document.getElementById('username_check').innerHTML = '<i class="fa fa-check fa-lg text-success"></i> Available';  
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