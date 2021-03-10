<?php
include 'includes/db_connect.php';

$id = $_REQUEST['id'];
$sale_q = mysqli_query($db, "SELECT * FROM `sales` WHERE `sales_id`='$id'");
$fetch = mysqli_fetch_assoc($sale_q);

$sales_id = $fetch['sales_id'];
$purchase_date = $fetch['purchase_date'];
$policy_id = $fetch['policy_id'];
$policy_title = $fetch['policy_title'];
$fname = $fetch['fname'];
$lname = $fetch['lname'];
$email = $fetch['email'];
$phone = $fetch['phone'];
$address = $fetch['address'];
$address_2 = $fetch['address_2'];
$city = $fetch['city'];
$postcode = $fetch['postcode'];
$country = $fetch['country'];
$home_address = $fetch['home_address'];
$home_address_2 = $fetch['home_address_2'];
$home_city = $fetch['home_city'];
$home_province = $fetch['home_province'];
$home_zip = $fetch['home_zip'];
$billing_province = $fetch['billing_province'];
$home_country = $fetch['home_country'];
$pre_exe = $fetch['pre_exe'];
$deductible = $fetch['deductible'];
$deductible_rate = $fetch['deductible_rate'];
$benefit = $fetch['benefit'];
$duration = $fetch['duration'];
$age = $fetch['age'];
$product = $fetch['product'];
$trip_type = $fetch['trip_type'];
$plan = $fetch['plan'];
$trip_dest = $fetch['trip_dest'];
$supervisa = $fetch['supervisa'];
$tripcost = $fetch['tripcost'];
$dob = $fetch['dob'];
$start_date = $fetch['start_date'];
$end_date = $fetch['end_date'];
$cancel_date = $fetch['cancel_date'];
$departure_date = $fetch['departure_date'];
$arrival_date = $fetch['arrival_date'];
$return_date = $fetch['return_date'];
$smoking = $fetch['smoking'];
$province = $fetch['province'];
$additional_travellers = $fetch['additional_travellers'];
$price = $fetch['price'];
$daily_price = $fetch['daily_price'];
$price_total = $fetch['price_total'];
$price_payable = $fetch['price_payable'];
$eligible = $fetch['eligible'];
$policy_number = $fetch['policy_number'];
$policy_type = $fetch['policy_type'];
$elder_age = $fetch['elder_age'];
$family_plan = $fetch['family_plan'];
$policy_status = $fetch['policy_status'];
$broker = $fetch['broker'];
$agent = $fetch['agent'];
$transaction_type = $fetch['transaction_type'];
$transaction_reason = $fetch['transaction_reason'];
$gross_comm_rate = $fetch['gross_comm_rate'];
$user_ip = $fetch['user_ip'];

$temp_daily_price = $price_payable / $duration;


//Company details:
$company_q = mysqli_query($db, "SELECT * FROM `wp_companies` WHERE `id`=(SELECT `insurance_company` FROM `wp_dh_insurance_plans` WHERE `id`='$policy_id')");
$company_f = mysqli_fetch_assoc($company_q);
$company_logo = $company_f['comp_logo'];

//Elder age 
if($parent_sales_id == '0'){
$elder_q = mysqli_query($db, "SELECT MAX(`age`) AS 'elder_age' FROM `sales` WHERE `sales_id`='$sales_id' OR `sales_id` IN (SELECT `sales_id` FROM `sales` WHERE `parent_sales_id`='$sales_id')");
//travellers
$travellers_q = mysqli_query($db, "SELECT COUNT(`sales_id`) AS 'travellers' FROM `sales` WHERE `sales_id`='$sales_id' OR `sales_id` IN (SELECT `sales_id` FROM `sales` WHERE `parent_sales_id`='$sales_id')");
} else {
$elder_q = mysqli_query($db, "SELECT MAX(`age`) AS 'elder_age' FROM `sales` WHERE `sales_id`='$parent_sales_id' OR `sales_id` IN (SELECT `sales_id` FROM `sales` WHERE `parent_sales_id`='$parent_sales_id')");
//travellers
$travellers_q = mysqli_query($db, "SELECT COUNT(`sales_id`) AS 'travellers' FROM `sales` WHERE `sales_id`='$parent_sales_id' OR `sales_id` IN (SELECT `sales_id` FROM `sales` WHERE `parent_sales_id`='$parent_sales_id')");
}
$travellers_f = mysqli_fetch_assoc($travellers_q);
$elder_f = mysqli_fetch_assoc($elder_q);
$elder_age = $elder_f['elder_age'];
$travellers = $travellers_f['travellers'];

if($_REQUEST['action'] == 'update'){
		
	$id = $_REQUEST['id'];
	$new_fname = $_POST['fname'];
	$new_lname = $_POST['lname'];
	$new_email = $_POST['email'];
	$new_phone = $_POST['phone'];
	$new_dob = $_POST['phone'];
	$new_age = $_POST['age'];
	$new_address = $_POST['address'];
	$new_address_2 = $_POST['address_2'];
	$new_province = $_POST['province'];
	$new_city = $_POST['city'];
	$new_postcode = $_POST['postcode'];
	$new_country = $_POST['country'];
	$new_home_address = $_POST['home_address'];
	$new_home_address_2 = $_POST['home_address_2'];
	$new_home_province = $_POST['home_province'];
	$new_home_city = $_POST['home_city'];
	$new_home_zip = $_POST['home_zip'];
	$new_home_country = $_POST['home_country'];

if($new_age != $age){

if($family_plan == 'yes' && $new_age <= 69){
//checking age to use
if($new_age > $elder_age){
$use_age = $new_age;
}else {
$use_age = $elder_age;	
}
	
}
else if($family_plan == 'yes' && $new_age > 69){
echo "<script>window.location='?action=invalid_age&id=".$sales_id."';</script>";
exit;
}

if($family_plan == 'no'){
$use_age = $new_age;	
}



$getprice = mysqli_query($db, "SELECT * FROM `prices` WHERE `age_id`=(SELECT `id` FROM `ages` WHERE '$use_age' BETWEEN `s_age` AND `e_age` AND `company_id`='$company_id') AND `days_id`=(SELECT `id` FROM `days` WHERE '$duration' BETWEEN `s_day` AND `e_day` AND `company_id`='$company_id') AND `benefit_id`=(SELECT `id` FROM `benefit` WHERE `benefit_amount`='$benefit') AND `rate_table`=(SELECT `rate_table` FROM `policies` WHERE `id`='$policy_id')");
$getprice_f = mysqli_fetch_assoc($getprice);
$newdail_prices = $getprice_f['price'];
$newprices_status = $getprice_f['price_status'];
$newprice = $duration * $newdail_prices;


$p_pre_q = mysqli_query($db, "SELECT * FROM `pre_exe` WHERE `rate_table`=(SELECT `rate_table` FROM `policies` WHERE `id`='$policy_id') AND '$new_age' BETWEEN `s_age` AND `e_age` AND `pre_exe`='$pre_exe'");
$p_pre_f = mysqli_fetch_assoc($p_pre_q);
$p_pre_type = $p_pre_f['rate_type'];
$p_pre_value = $p_pre_f['rate_value'];

if($p_pre_type == 'p'){
$p_percent = ($newprice * $p_pre_value) / 100;
$newprice = $p_percent;
}

$newprice = $deductible_rate * $newprice / 100;


if($family_plan == 'yes' && $new_age > $elder_age){
$newpayable = ($newprice * 2);
$newprice = $newpayable / $travellers;
//additionals
if($parent_sales_id == '0'){
$update = mysqli_query($db, "UPDATE `sales` SET `price`='$newprice', `daily_price`='$newdail_prices', `price_total`='$newpayable',`price_payable`='$newpayable' WHERE `parent_sales_id`='$sales_id'");	
$update = mysqli_query($db, "UPDATE `sales` SET `price`='$newprice', `daily_price`='$newdail_prices', `price_total`='$newpayable',`price_payable`='$newpayable' WHERE `sales_id`='$sales_id'");

if($newprice > $price){
$amount = $newprice - $price;
$payment = mysqli_query($db, "INSERT INTO `sales_payments`(`sales_id`, `desc`, `payment_type`, `amount`, `transaction_type`, `transaction_reason`) VALUES ('$sales_id','DOB Change','payment','$amount','update','date')");
}
else {
$amount = $newprice - $price;
$payment = mysqli_query($db, "INSERT INTO `sales_payments`(`sales_id`, `desc`, `payment_type`, `amount`, `transaction_type`, `transaction_reason`) VALUES ('$sales_id','DOB Change','refund','$amount','update','date')");	
}
//addtionals payments
$additonals_q = mysqli_query($db, "SELECT * FROM `sales` WHERE `parent_sales_id`='$sales_id'");
while($additonals_f = mysqli_fetch_assoc($additonals_q)){

if($newprice > $price){
$amount = $newprice - $price;
$payment = mysqli_query($db, "INSERT INTO `sales_payments`(`sales_id`, `desc`, `payment_type`, `amount`, `transaction_type`, `transaction_reason`) VALUES ('".$additonals_f['sales_id']."','DOB Change','payment','$amount','update','date')");
}
else {
$amount = $newprice - $price;
$payment = mysqli_query($db, "INSERT INTO `sales_payments`(`sales_id`, `desc`, `payment_type`, `amount`, `transaction_type`, `transaction_reason`) VALUES ('".$additonals_f['sales_id']."','DOB Change','refund','$amount','update','date')");	
}
}

} else {

$update = mysqli_query($db, "UPDATE `sales` SET `price`='$newprice', `daily_price`='$newdail_prices', `price_total`='$newpayable',`price_payable`='$newpayable' WHERE `sales_id`='$parent_sales_id'");
$update = mysqli_query($db, "UPDATE `sales` SET `price`='$newprice', `daily_price`='$newdail_prices', `price_total`='$newpayable',`price_payable`='$newpayable' WHERE `parent_sales_id`='$parent_sales_id'");	
	
if($newprice > $price){
$amount = $newprice - $price;
$payment = mysqli_query($db, "INSERT INTO `sales_payments`(`sales_id`, `desc`, `payment_type`, `amount`, `transaction_type`, `transaction_reason`) VALUES ('$sales_id','DOB Change','payment','$amount','update','date')");
}
else {
$amount = $newprice - $price;
$payment = mysqli_query($db, "INSERT INTO `sales_payments`(`sales_id`, `desc`, `payment_type`, `amount`, `transaction_type`, `transaction_reason`) VALUES ('$sales_id','DOB Change','refund','$amount','update','date')");	
}


//addtionals payments
$additonals_q = mysqli_query($db, "SELECT * FROM `sales` WHERE `sales_id`='$parent_sales_id' OR `sales_id` IN (SELECT `sales_id` FROM `sales` WHERE `parent_sales_id`='$parent_sales_id' AND `sales_id`<>'$sales_id'))");
while($additonals_f = mysqli_fetch_assoc($additonals_q)){

if($newprice > $price){
$amount = $newprice - $price;
$payment = mysqli_query($db, "INSERT INTO `sales_payments`(`sales_id`, `desc`, `payment_type`, `amount`, `transaction_type`, `transaction_reason`) VALUES ('".$additonals_f['sales_id']."','DOB Change','payment','$amount','update','date')");
}
else {
$amount = $newprice - $price;
$payment = mysqli_query($db, "INSERT INTO `sales_payments`(`sales_id`, `desc`, `payment_type`, `amount`, `transaction_type`, `transaction_reason`) VALUES ('".$additonals_f['sales_id']."','DOB Change','refund','$amount','update','date')");	
}
}


}

}//if family_plan == 'yes' && new_age > elder_age

}// if age not equal

	$query_update = mysqli_query($db, "UPDATE `sales` SET `fname`='$fname',`lname`='$lname', `email`='$email', `phone`='$phone', `address`='$address', `address_2`='$address_2', `province`='$province', `city`='$city', `postcode`='$postcode', `home_address`='$home_address', `home_address_2`='$home_address_2', `home_province`='$home_province', `home_city`='$home_city', `home_zip`='$home_zip', `home_country`='$home_country', `policy_status`='$policy_status'  WHERE `sales_id`='$id' ");

	echo "<script>window.location='resend.php?id=$id'</script>";
	
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Sales</title>

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

		<!-- ace settings handler 
		<script src="assets/js/ace-extra.min.js"></script>-->

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$( function() {
$( "#dob" ).datepicker({
  changeMonth: true,
  changeYear: true,
  dateFormat: 'yy-mm-dd',
  yearRange: "+0:+5",
});
} );
$( function() {
$( "#expiry_date" ).datepicker({
  changeMonth: true,
  changeYear: true,
  dateFormat: 'yy-mm-dd',
  yearRange: "+0:+5",
});
} );
</script>
<style>
.ui-widget.ui-widget-content {width:auto; }
.nav-list > li { display:inline-block !important; }
</style>	
	</head>

	<body class="no-skin">
	<?php include 'header.php'; ?>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

	<?php include 'sales_sidebar.php'; ?>
	
			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="#">Home</a>
							</li>

							<li>
								<a href="#">Sales</a>
							</li>
							<li class="active">Manage Sales</li>
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
								Sales
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Early Return
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->


								<div class="row">
									<div class="col-sm-12">
									<div class="card-block">
                             <div style="text-align:center;"><img src="https://vtcinsure.ca/quote/admin/uploads/<?php echo $company_logo;?>" width="280"><br />
                                <h1 style="font-size:24px; display:inline-block;"><strong><?php echo $policy_title; ?></strong></h1>
                             </div>
                             <div style="clear:both; height:40px;"><hr/></div>
                             <form action="?action=update&id=<?php echo $_REQUEST['id'];?>" method="post">
                             
<h4><strong>Insured Client Details:</strong></h4>
<div class="row">
<div class="col-md-12" style="margin-bottom:50px;">
<div style="border-bottom: 2px solid #ccc;border-top: 1px solid #999;clear: both;height: 1px;margin: 10px 0;"></div>
<h5 style="font-size:14px; color:#cc0000;"><strong>Primary Details:</strong></h5>
<div class="row">
<div class="col-md-4">
<h5 style="font-size:13px;"><strong>First Name</strong></h5>
<input type="text" class="form-control" name="fname" id="fname" value="<?php echo $fname; ?>">
</div>
<div class="col-md-4">
<h5 style="font-size:13px;"><strong>Last Name</strong></h5>
<input type="text" class="form-control" name="lname" id="lname" value="<?php echo $lname;?>">
</div>
<div class="col-md-4">
<h5 style="font-size:13px;"><strong>Email</strong></h5>
<input type="email" class="form-control" name="email" id="email" value="<?php echo $email;?>" >
</div>
</div>
<div class="row">
<div class="col-md-4">
<h5 style="font-size:13px;"><strong>Phone</strong></h5>
<input type="text" class="form-control" name="phone" id="phone" value="<?php echo $phone;?>" required>
</div>
<div class="col-md-4">
<h5 style="font-size:13px;"><strong>Date of Birth</strong></h5>
<input type="text" class="form-control" name="dob" id="dob" value="<?php echo $dob;?>" onChange="getagefunc()" readonly data-required="true" style="background:#fff; color:#444;">
<input type="hidden" name="age" id="age" value="<?php echo $age; ?>">
<script>
function getagefunc(){
var birthdate = new Date(document.getElementById('dob').value);
var cur = new Date();
var diff = cur - birthdate;
var age = Math.floor(diff/31536000000);
    //document.getElementById('age_txt').innerHTML = age+' Years';
	document.getElementById('age').value = age;
}
</script>
</div>
</div>

<div style="clear: both; height: 20px; margin-top: 25px;"><hr/></div>

<div class="row">
<div class="col-md-12">
<h5 style="font-size:14px; color:#C00;"><strong>Address where you are staying in Canada:</strong></h5>
</div>
</div>
<div class="row">
<div class="col-md-4">
<h5 style="font-size:13px;"><strong>Address Line 1</strong></h5>
<input type="text" class="form-control" name="address" id="address" value="<?php echo $address;?>" required>
</div>
<div class="col-md-4">
<h5 style="font-size:13px;"><strong>Address Line 2</strong></h5>
<input type="text" class="form-control" name="address_2" id="address_2" value="<?php echo $address_2;?>">
</div>
<div class="col-md-4">
<h5 style="font-size:13px;"><strong>Province</strong></h5>
<select class="form-control" id="province" name="province" required>
			<option selected="selected" value="">Select Province</option>
			<?php
            $sr = 0;
            $provinces_q = mysqli_query($db, "SELECT * FROM `provinces` ORDER BY `id`");
            while($provinces_f = mysqli_fetch_assoc($provinces_q)){
            $sr++;
            ?>
			<option <?php if($province == $provinces_f['id']){?> selected="selected" <?php } ?> value="<?php echo strtoupper($provinces_f['id']);?>"><?php echo $provinces_f['prov_title'];?></option>
			<?php } ?>
	</select>
</div>
</div>
<div class="row">
<div class="col-md-4">
<h5 style="font-size:13px;"><strong>City</strong></h5>
<input type="text" class="form-control" name="city" id="city" value="<?php echo $city;?>" required>
</div>
<div class="col-md-4">
<h5 style="font-size:13px;"><strong>Postal Code</strong></h5>
<input type="text" class="form-control" name="postcode" id="postcode" value="<?php echo $postcode;?>" required>
</div>
<div class="col-md-4">
<h5 style="font-size:13px;"><strong>Country</strong></h5>
<select required="" id="country" name="country" class="form-control">
<option value="Canada" selected>Canada</option>
</select>
</div>
</div>
<div class="row">
<div class="col-md-12">
<h5 style="font-size:14px; color:#cc0000;"><strong>Home Address:</strong></h5>
</div>
</div>
<div class="row">
<div class="col-md-4">
<h5 style="font-size:13px;"><strong>Address Line 1</strong></h5>
<input type="text" class="form-control" name="home_address" id="home_address" value="<?php echo $home_address;?>" required>
</div>
<div class="col-md-4">
<h5 style="font-size:13px;"><strong>Address Line 2</strong></h5>
<input type="text" class="form-control" name="home_address_2" id="home_address_2" value="<?php echo $home_address_2;?>">
</div>
<div class="col-md-4">
<h5 style="font-size:13px;"><strong>Province/State</strong></h5>
<input type="text" class="form-control" id="home_province" name="home_province" value="<?php echo $home_province;?>" required>
</div>
</div>
<div class="row">
<div class="col-md-4">
<h5 style="font-size:13px;"><strong>City</strong></h5>
<input type="text" class="form-control" name="home_city" id="home_city" value="<?php echo $home_city;?>" required>
</div>
<div class="col-md-4">
<h5 style="font-size:13px;"><strong>Zip</strong></h5>
<input type="text" class="form-control" name="home_zip" id="home_zip" value="<?php echo $home_zip;?>">
</div>
<div class="col-md-4">
<h5 style="font-size:13px;"><strong>Home Country</strong></h5>
<select required="" id="home_country" name="home_country" class="form-control">
                                 <option value="" disabled="" selected="">Please Select...</option>
                                    <option <?php if($home_country == 'United States'){?> selected <?php } ?> value="United States">United States</option>
                                    <option <?php if($home_country == 'Canada'){?> selected <?php } ?> value="Canada">Canada</option>
                                    <option <?php if($home_country == 'Afghanistan'){?> selected <?php } ?> value="Afghanistan">Afghanistan</option>
                                    <option <?php if($home_country == 'Albania'){?> selected <?php } ?> value="Albania">Albania</option>
                                    <option <?php if($home_country == 'Algeria'){?> selected <?php } ?> value="Algeria">Algeria</option>
                                    <option <?php if($home_country == 'Andorra'){?> selected <?php } ?> value="Andorra">Andorra</option>
                                    <option <?php if($home_country == 'Angola'){?> selected <?php } ?> value="Angola">Angola</option>
                                    <option <?php if($home_country == 'Antiguaand Barbuda'){?> selected <?php } ?> value="Antiguaand Barbuda">Antiguaand Barbuda</option>
                                    <option <?php if($home_country == 'Argentina'){?> selected <?php } ?> value="Argentina">Argentina</option>
                                    <option <?php if($home_country == 'Armenia'){?> selected <?php } ?> value="Armenia">Armenia</option>
                                    <option <?php if($home_country == 'Australia'){?> selected <?php } ?> value="Australia">Australia</option>
                                    <option <?php if($home_country == 'Azerbaijan'){?> selected <?php } ?> value="Azerbaijan">Azerbaijan</option>
                                    <option <?php if($home_country == 'Bahamas'){?> selected <?php } ?> value="Bahamas">Bahamas</option>
                                    <option <?php if($home_country == 'Bahrain'){?> selected <?php } ?> value="Bahrain">Bahrain</option>
                                    <option <?php if($home_country == 'Bangladesh'){?> selected <?php } ?> value="Bangladesh">Bangladesh</option> 
                                    <option <?php if($home_country == 'Barbados'){?> selected <?php } ?> value="Barbados">Barbados</option>
                                    <option <?php if($home_country == 'Belarus'){?> selected <?php } ?> value="Belarus">Belarus</option>
                                    <option <?php if($home_country == 'Belgium'){?> selected <?php } ?> value="Belgium">Belgium</option>
                                    <option <?php if($home_country == 'Belize'){?> selected <?php } ?> value="Belize">Belize</option>
                                    <option <?php if($home_country == 'Benin'){?> selected <?php } ?> value="Benin">Benin</option>
                                    <option <?php if($home_country == 'Bhutan'){?> selected <?php } ?> value="Bhutan">Bhutan</option>
                                    <option <?php if($home_country == 'Bolivia'){?> selected <?php } ?> value="Bolivia">Bolivia</option>
                                    <option <?php if($home_country == 'Bosniaand Herzegovina'){?> selected <?php } ?> value="Bosniaand Herzegovina">Bosniaand Herzegovina</option>
                                    <option <?php if($home_country == 'Botswana'){?> selected <?php } ?> value="Botswana">Botswana</option>
                                    <option <?php if($home_country == 'Brazil'){?> selected <?php } ?> value="Brazil">Brazil</option>
                                    <option <?php if($home_country == 'Brunei'){?> selected <?php } ?> value="Brunei">Brunei</option>
                                    <option <?php if($home_country == 'Bulgaria'){?> selected <?php } ?> value="Bulgaria">Bulgaria</option>
                                    <option <?php if($home_country == 'BurkinaFaso'){?> selected <?php } ?> value="BurkinaFaso">BurkinaFaso</option>
                                    <option <?php if($home_country == 'Burundi'){?> selected <?php } ?> value="Burundi">Burundi</option>
                                    <option <?php if($home_country == 'Cambodia'){?> selected <?php } ?> value="Cambodia">Cambodia</option>
                                    <option <?php if($home_country == 'Cameroon'){?> selected <?php } ?> value="Cameroon">Cameroon</option>
                                    <option <?php if($home_country == 'Cape Verde'){?> selected <?php } ?> value="Cape Verde">Cape Verde</option>
                                    <option <?php if($home_country == 'Central African Republic'){?> selected <?php } ?> value="Central African Republic">Central African Republic</option>
                                    <option <?php if($home_country == 'Chad'){?> selected <?php } ?> value="Chad">Chad</option>
                                    <option <?php if($home_country == 'Chile'){?> selected <?php } ?> value="Chile">Chile</option>
                                    <option <?php if($home_country == 'China'){?> selected <?php } ?> value="China">China</option>
                                    <option <?php if($home_country == 'Colombia'){?> selected <?php } ?> value="Colombia">Colombia</option>
                                    <option <?php if($home_country == 'Comoros'){?> selected <?php } ?> value="Comoros">Comoros</option>
                                    <option <?php if($home_country == 'Congo(Brazzaville'){?> selected <?php } ?> value="Congo(Brazzaville)">Congo(Brazzaville)</option>
                                    <option <?php if($home_country == 'Congo'){?> selected <?php } ?> value="Congo">Congo</option>
                                    <option <?php if($home_country == 'Costa Rica'){?> selected <?php } ?> value="Costa Rica">Costa Rica</option>
                                    <option <?php if($home_country == 'Coted Ivoire'){?> selected <?php } ?> value="Coted Ivoire">Coted'Ivoire</option>
                                    <option <?php if($home_country == 'Croatia'){?> selected <?php } ?> value="Croatia">Croatia</option>
                                    <option <?php if($home_country == 'Cuba'){?> selected <?php } ?> value="Cuba">Cuba</option>
                                    <option <?php if($home_country == 'Cyprus'){?> selected <?php } ?> value="Cyprus">Cyprus</option>
                                    <option <?php if($home_country == 'Czech Republic'){?> selected <?php } ?> value="Czech Republic">Czech Republic</option>
                                    <option <?php if($home_country == 'Denmark'){?> selected <?php } ?> value="Denmark">Denmark</option>
                                    <option <?php if($home_country == 'Djibouti'){?> selected <?php } ?> value="Djibouti">Djibouti</option>
                                    <option <?php if($home_country == 'Dominica'){?> selected <?php } ?> value="Dominica">Dominica</option>
                                    <option <?php if($home_country == 'Dominican Republic'){?> selected <?php } ?> value="Dominican Republic">Dominican Republic</option>
                                    <option <?php if($home_country == 'EastTimor(TimorTimur)'){?> selected <?php } ?> value="EastTimor(TimorTimur)">EastTimor(TimorTimur)</option>
                                    <option <?php if($home_country == 'Ecuador'){?> selected <?php } ?> value="Ecuador">Ecuador</option>
                                    <option <?php if($home_country == 'Egypt'){?> selected <?php } ?> value="Egypt">Egypt</option>
                                    <option <?php if($home_country == 'ElSalvador'){?> selected <?php } ?> value="ElSalvador">ElSalvador</option>
                                    <option <?php if($home_country == 'Equatorial Guinea'){?> selected <?php } ?> value="Equatorial Guinea">Equatorial Guinea</option>
                                    <option <?php if($home_country == 'Eritrea'){?> selected <?php } ?> value="Eritrea">Eritrea</option>
                                    <option <?php if($home_country == 'Estonia'){?> selected <?php } ?> value="Estonia">Estonia</option>
                                    <option <?php if($home_country == 'Ethiopia'){?> selected <?php } ?> value="Ethiopia">Ethiopia</option>
                                    <option <?php if($home_country == 'Fiji'){?> selected <?php } ?> value="Fiji">Fiji</option>
                                    <option <?php if($home_country == 'Finland'){?> selected <?php } ?> value="Finland">Finland</option>
                                    <option <?php if($home_country == 'France'){?> selected <?php } ?> value="France">France</option>
                                    <option <?php if($home_country == 'Gabon'){?> selected <?php } ?> value="Gabon">Gabon</option>
                                    <option <?php if($home_country == 'Gambia The'){?> selected <?php } ?> value="Gambia The">Gambia The</option>
                                    <option <?php if($home_country == 'Georgia'){?> selected <?php } ?> value="Georgia">Georgia</option>
                                    <option <?php if($home_country == 'Germany'){?> selected <?php } ?> value="Germany">Germany</option>
                                    <option <?php if($home_country == 'Ghana'){?> selected <?php } ?> value="Ghana">Ghana</option>
                                    <option <?php if($home_country == 'Greece'){?> selected <?php } ?> value="Greece">Greece</option>
                                    <option <?php if($home_country == 'Grenada'){?> selected <?php } ?> value="Grenada">Grenada</option>
                                    <option <?php if($home_country == 'Guatemala'){?> selected <?php } ?> value="Guatemala">Guatemala</option>
                                    <option <?php if($home_country == 'Guinea'){?> selected <?php } ?> value="Guinea">Guinea</option>
                                    <option <?php if($home_country == 'Guinea-Bissau'){?> selected <?php } ?> value="Guinea-Bissau">Guinea-Bissau</option>
                                    <option <?php if($home_country == 'Guyana'){?> selected <?php } ?> value="Guyana">Guyana</option>
                                    <option <?php if($home_country == 'Haiti'){?> selected <?php } ?> value="Haiti">Haiti</option>
                                    <option <?php if($home_country == 'Honduras'){?> selected <?php } ?> value="Honduras">Honduras</option>
                                    <option <?php if($home_country == 'Hungary'){?> selected <?php } ?> value="Hungary">Hungary</option>
                                    <option <?php if($home_country == 'Iceland'){?> selected <?php } ?> value="Iceland">Iceland</option>
                                    <option <?php if($home_country == 'India'){?> selected <?php } ?> value="India">India</option>
                                    <option <?php if($home_country == 'Indonesia'){?> selected <?php } ?> value="Indonesia">Indonesia</option>
                                    <option <?php if($home_country == 'Iran'){?> selected <?php } ?> value="Iran">Iran</option>
                                    <option <?php if($home_country == 'Iraq'){?> selected <?php } ?> value="Iraq">Iraq</option>
                                    <option <?php if($home_country == 'Ireland'){?> selected <?php } ?> value="Ireland">Ireland</option>
                                    <option <?php if($home_country == 'Israel'){?> selected <?php } ?> value="Israel">Israel</option>
                                    <option <?php if($home_country == 'Italy'){?> selected <?php } ?> value="Italy">Italy</option>
                                    <option <?php if($home_country == 'Jamaica'){?> selected <?php } ?> value="Jamaica">Jamaica</option>
                                    <option <?php if($home_country == 'Japan'){?> selected <?php } ?> value="Japan">Japan</option>
                                    <option <?php if($home_country == 'Jordan'){?> selected <?php } ?> value="Jordan">Jordan</option>
                                    <option <?php if($home_country == 'Kazakhstan'){?> selected <?php } ?> value="Kazakhstan">Kazakhstan</option>
                                    <option <?php if($home_country == 'Kenya'){?> selected <?php } ?> value="Kenya">Kenya</option>
                                    <option <?php if($home_country == 'Kiribati'){?> selected <?php } ?> value="Kiribati">Kiribati</option>
                                    <option <?php if($home_country == 'KoreaNorth'){?> selected <?php } ?> value="KoreaNorth">KoreaNorth</option>
                                    <option <?php if($home_country == 'KoreaSouth'){?> selected <?php } ?> value="KoreaSouth">KoreaSouth</option>
                                    <option <?php if($home_country == 'Kuwait'){?> selected <?php } ?> value="Kuwait">Kuwait</option>
                                    <option <?php if($home_country == 'Kyrgyzstan'){?> selected <?php } ?> value="Kyrgyzstan">Kyrgyzstan</option>
                                    <option <?php if($home_country == 'Laos'){?> selected <?php } ?> value="Laos">Laos</option>
                                    <option <?php if($home_country == 'Latvia'){?> selected <?php } ?> value="Latvia">Latvia</option>
                                    <option <?php if($home_country == 'Lebanon'){?> selected <?php } ?> value="Lebanon">Lebanon</option>
                                    <option <?php if($home_country == 'Lesotho'){?> selected <?php } ?> value="Lesotho">Lesotho</option>
                                    <option <?php if($home_country == 'Liberia'){?> selected <?php } ?> value="Liberia">Liberia</option>
                                    <option <?php if($home_country == 'Libya'){?> selected <?php } ?> value="Libya">Libya</option>
                                    <option <?php if($home_country == 'Liechtenstein'){?> selected <?php } ?> value="Liechtenstein">Liechtenstein</option>
                                    <option <?php if($home_country == 'Lithuania'){?> selected <?php } ?> value="Lithuania">Lithuania</option>
                                    <option <?php if($home_country == 'Luxembourg'){?> selected <?php } ?> value="Luxembourg">Luxembourg</option>
                                    <option <?php if($home_country == 'Macedonia'){?> selected <?php } ?> value="Macedonia">Macedonia</option>
                                    <option <?php if($home_country == 'Madagascar'){?> selected <?php } ?> value="Madagascar">Madagascar</option>
                                    <option <?php if($home_country == 'Malawi'){?> selected <?php } ?> value="Malawi">Malawi</option>
                                    <option <?php if($home_country == 'Malaysia'){?> selected <?php } ?> value="Malaysia">Malaysia</option>
                                    <option <?php if($home_country == 'Maldives'){?> selected <?php } ?> value="Maldives">Maldives</option>
                                    <option <?php if($home_country == 'Mali'){?> selected <?php } ?> value="Mali">Mali</option>
                                    <option <?php if($home_country == 'Malta'){?> selected <?php } ?> value="Malta">Malta</option>
                                    <option <?php if($home_country == 'Marshall Islands'){?> selected <?php } ?> value="Marshall Islands">Marshall Islands</option>
                                    <option <?php if($home_country == 'Mauritania'){?> selected <?php } ?> value="Mauritania">Mauritania</option>
                                    <option <?php if($home_country == 'Mauritius'){?> selected <?php } ?> value="Mauritius">Mauritius</option>
                                    <option <?php if($home_country == 'Mexico'){?> selected <?php } ?> value="Mexico">Mexico</option>
                                    <option <?php if($home_country == 'Micronesia'){?> selected <?php } ?> value="Micronesia">Micronesia</option>
                                    <option <?php if($home_country == 'Moldova'){?> selected <?php } ?> value="Moldova">Moldova</option>
                                    <option <?php if($home_country == 'Monaco'){?> selected <?php } ?> value="Monaco">Monaco</option>
                                    <option <?php if($home_country == 'Mongolia'){?> selected <?php } ?> value="Mongolia">Mongolia</option>
                                    <option <?php if($home_country == 'Montenegro'){?> selected <?php } ?> value="Montenegro">Montenegro</option>
                                    <option <?php if($home_country == 'Morocco'){?> selected <?php } ?> value="Morocco">Morocco</option>
                                    <option <?php if($home_country == 'Mozambique'){?> selected <?php } ?> value="Mozambique">Mozambique</option>
                                    <option <?php if($home_country == 'Myanmar'){?> selected <?php } ?> value="Myanmar">Myanmar</option>
                                    <option <?php if($home_country == 'Namibia'){?> selected <?php } ?> value="Namibia">Namibia</option>
                                    <option <?php if($home_country == 'Nauru'){?> selected <?php } ?> value="Nauru">Nauru</option>
                                    <option <?php if($home_country == 'Nepa'){?> selected <?php } ?> value="Nepa">Nepa</option>
                                    <option <?php if($home_country == 'Netherlands'){?> selected <?php } ?> value="Netherlands">Netherlands</option>
                                    <option <?php if($home_country == 'New Zealand'){?> selected <?php } ?> value="New Zealand">New Zealand</option>
                                    <option <?php if($home_country == 'Nicaragua'){?> selected <?php } ?> value="Nicaragua">Nicaragua</option>
                                    <option <?php if($home_country == 'Niger'){?> selected <?php } ?> value="Niger">Niger</option>
                                    <option <?php if($home_country == 'Nigeria'){?> selected <?php } ?> value="Nigeria">Nigeria</option>
                                    <option <?php if($home_country == 'Norway'){?> selected <?php } ?> value="Norway">Norway</option>
                                    <option <?php if($home_country == 'Oman'){?> selected <?php } ?> value="Oman">Oman</option>
                                    <option <?php if($home_country == 'Pakistan'){?> selected <?php } ?> value="Pakistan">Pakistan</option>
                                    <option <?php if($home_country == 'Palau'){?> selected <?php } ?> value="Palau">Palau</option>
                                    <option <?php if($home_country == 'Palestinian Authority'){?> selected <?php } ?> value="Palestinian Authority">Palestinian Authority</option>
                                    <option <?php if($home_country == 'Panama'){?> selected <?php } ?> value="Panama">Panama</option>
                                    <option <?php if($home_country == 'Papua New Guinea'){?> selected <?php } ?> value="Papua New Guinea">Papua New Guinea</option>
                                    <option <?php if($home_country == 'Paraguay'){?> selected <?php } ?> value="Paraguay">Paraguay</option>
                                    <option <?php if($home_country == 'Peru'){?> selected <?php } ?> value="Peru">Peru</option>
                                    <option <?php if($home_country == 'Philippines'){?> selected <?php } ?> value="Philippines">Philippines</option>
                                    <option <?php if($home_country == 'Poland'){?> selected <?php } ?> value="Poland">Poland</option>
                                    <option <?php if($home_country == 'Portugal'){?> selected <?php } ?> value="Portugal">Portugal</option>
                                    <option <?php if($home_country == 'Qatar'){?> selected <?php } ?> value="Qatar">Qatar</option>
                                    <option <?php if($home_country == 'Romania'){?> selected <?php } ?> value="Romania">Romania</option>
                                    <option <?php if($home_country == 'Russia'){?> selected <?php } ?> value="Russia">Rwanda</option>
                                    <option <?php if($home_country == 'Rwanda'){?> selected <?php } ?> value="Rwanda">Palau</option>
                                    <option <?php if($home_country == 'Saint Kitts and Nevis'){?> selected <?php } ?> value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                    <option <?php if($home_country == 'SaintLucia'){?> selected <?php } ?> value="SaintLucia">SaintLucia</option>
                                    <option <?php if($home_country == 'SaintVincent'){?> selected <?php } ?> value="SaintVincent">SaintVincent</option>
                                    <option <?php if($home_country == 'Samoa'){?> selected <?php } ?> value="Samoa">Samoa</option>
                                    <option <?php if($home_country == 'SanMarino'){?> selected <?php } ?> value="SanMarino">SanMarino</option>
                                    <option <?php if($home_country == 'Sao Tome and Principe'){?> selected <?php } ?> value="Sao Tome and Principe">Sao Tome and Principe</option>
                                    <option <?php if($home_country == 'SaudiArabia'){?> selected <?php } ?> value="SaudiArabia">SaudiArabia</option>
                                    <option <?php if($home_country == 'Senegal'){?> selected <?php } ?> value="Senegal">Senegal</option>
                                    <option <?php if($home_country == 'Serbia'){?> selected <?php } ?> value="Serbia">Serbia</option>
                                    <option <?php if($home_country == 'Seychelles'){?> selected <?php } ?> value="Seychelles">Seychelles</option>
                                    <option <?php if($home_country == 'Sierra Leone'){?> selected <?php } ?> value="Sierra Leone">Sierra Leone</option>
                                    <option <?php if($home_country == 'Singapore'){?> selected <?php } ?> value="Singapore">Singapore</option>
                                    <option <?php if($home_country == 'Slovakia'){?> selected <?php } ?> value="Slovakia">Slovakia</option>
                                    <option <?php if($home_country == 'Slovenia'){?> selected <?php } ?> value="Slovenia">Slovenia</option>
                                    <option <?php if($home_country == 'Solomon Islands'){?> selected <?php } ?> value="Solomon Islands">Solomon Islands</option>
                                    <option <?php if($home_country == 'Somalia'){?> selected <?php } ?> value="Somalia">Somalia</option>
                                    <option <?php if($home_country == 'South Africa'){?> selected <?php } ?> value="South Africa">South Africa</option>
                                    <option <?php if($home_country == 'South Sudan'){?> selected <?php } ?> value="South Sudan">South Sudan</option>
                                    <option <?php if($home_country == 'Spain'){?> selected <?php } ?> value="Spain">Spain</option>
                                    <option <?php if($home_country == 'Sri Lanka'){?> selected <?php } ?> value="Sri Lanka">Sri Lanka</option>
                                    <option <?php if($home_country == 'Sudan'){?> selected <?php } ?> value="Sudan">Sudan</option>
                                    <option <?php if($home_country == 'Suriname'){?> selected <?php } ?> value="Suriname">Suriname</option>
                                    <option <?php if($home_country == 'Swaziland'){?> selected <?php } ?> value="Swaziland">Swaziland</option>
                                    <option <?php if($home_country == 'Sweden'){?> selected <?php } ?> value="Sweden">Sweden</option>
                                    <option <?php if($home_country == 'Switzerland'){?> selected <?php } ?> value="Switzerland">Switzerland</option>
                                    <option <?php if($home_country == 'Syria'){?> selected <?php } ?> value="Syria">Syria</option>
                                    <option <?php if($home_country == 'Taiwan'){?> selected <?php } ?> value="Taiwan">Taiwan</option>
                                    <option <?php if($home_country == 'Tajikistan'){?> selected <?php } ?> value="Tajikistan">Tajikistan</option>
                                    <option <?php if($home_country == 'Tanzania'){?> selected <?php } ?> value="Tanzania">Tanzania</option>
                                    <option <?php if($home_country == 'Thailand'){?> selected <?php } ?> value="Thailand">Thailand</option>
                                    <option <?php if($home_country == 'Togo'){?> selected <?php } ?> value="Togo">Togo</option>
                                    <option <?php if($home_country == 'Tonga'){?> selected <?php } ?> value="Tonga">Tonga</option>
                                    <option <?php if($home_country == 'Trinidadand Tobago'){?> selected <?php } ?> value="Trinidadand Tobago">Trinidadand Tobago</option>
                                    <option <?php if($home_country == 'Tunisia'){?> selected <?php } ?> value="Tunisia">Tunisia</option>
                                    <option <?php if($home_country == 'Turkey'){?> selected <?php } ?> value="Turkey">Turkey</option>
                                    <option <?php if($home_country == 'Turkmenistan'){?> selected <?php } ?> value="Turkmenistan">Turkmenistan</option>
                                    <option <?php if($home_country == 'Tuvalu'){?> selected <?php } ?> value="Tuvalu">Tuvalu</option>
                                    <option <?php if($home_country == 'Uganda'){?> selected <?php } ?> value="Uganda">Uganda</option>
                                    <option <?php if($home_country == 'Ukraine'){?> selected <?php } ?> value="Ukraine">Ukraine</option>
                                    <option <?php if($home_country == 'United Arab Emirates'){?> selected <?php } ?> value="United Arab Emirates">United Arab Emirates</option>
                                    <option <?php if($home_country == 'United Kingdom'){?> selected <?php } ?> value="United Kingdom">United Kingdom</option>
                                    <option <?php if($home_country == 'Uruguay'){?> selected <?php } ?> value="Uruguay">Uruguay</option>
                                    <option <?php if($home_country == 'Uzbekistan'){?> selected <?php } ?> value="Uzbekistan">Uzbekistan</option>
                                    <option <?php if($home_country == 'Vanuatu'){?> selected <?php } ?> value="Vanuatu">Vanuatu</option>
                                    <option <?php if($home_country == 'Vatican City'){?> selected <?php } ?> value="Vatican City">Vatican City</option>
                                    <option <?php if($home_country == 'Venezuela'){?> selected <?php } ?> value="Venezuela">Venezuela</option>
                                    <option <?php if($home_country == 'Vietnam'){?> selected <?php } ?> value="Vietnam">Vietnam</option>
                                    <option <?php if($home_country == 'Yemen'){?> selected <?php } ?> value="Yemen">Yemen</option>
                                    <option <?php if($home_country == 'Zambia'){?> selected <?php } ?> value="Zambia">Zambia</option>
                                    <option <?php if($home_country == 'Zimbabwe'){?> selected <?php } ?> value="Zimbabwe">Zimbabwe</option> 
                                    </select>
</div>
</div>

<div style="clear:both; height:10px;"></div>

</div>
</div>
                                <div style="clear:both; height:40px;"><hr/></div>
                                 
                                  <div class="row" style="margin-bottom: 10px;">
                                  	<input type="submit" name="submit" class="btn btn-success" value="Sumit Changes" >
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

		<!--[if !IE]> 
		<script src="assets/js/jquery-2.1.4.min.js"></script>-->

		<!-- <![endif]-->

		<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<!--<script src="assets/js/bootstrap.min.js"></script>

		 page specific plugin scripts 
		<script src="assets/js/jquery.dataTables.min.js"></script>
		<script src="assets/js/jquery.dataTables.bootstrap.min.js"></script>
		<script src="assets/js/dataTables.buttons.min.js"></script>
		<script src="assets/js/buttons.flash.min.js"></script>
		<script src="assets/js/buttons.html5.min.js"></script>
		<script src="assets/js/buttons.print.min.js"></script>
		<script src="assets/js/buttons.colVis.min.js"></script>
		<script src="assets/js/dataTables.select.min.js"></script>-->

		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		
	
	</body>
</html>
