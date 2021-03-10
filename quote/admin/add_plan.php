<?php
error_reporting(E_ALL);
session_start();
include 'includes/db_connect.php';
//$db1 is site database
if (isset($_SESSION['user'])) {
} else {
echo "<script>
window.location='index.php?session=out';
</script>";
}
if($_REQUEST['action'] == 'add'){
	$preMedical = $_POST['imedical'];
	$familyPlan = $_POST['ifamily'];
	$usa_rate = $_POST['usa_rate'];
	$canada_rate=$_POST['canada_rate'];
	$nonusa_rate=$_POST['nonusa_rate'];
	$rateBase = $_POST['irateCalculation'];
	$monthlytwo = $_POST['monthlytwo'];
	$smoke = $_POST['smoke'];
	$smokeprice = $_POST['smokeprice'];
	$cdiscountprice = $_POST['cdiscountprice'];
	$sales_tax = $_POST['sales_tax'];
	$flat =  $_POST['iflat'];
	$iflatrateprice = $_POST['iflatrateprice'];
	$flatrate_type = $_POST['flatrate_type'];
	$feature = $_POST['ifeature'];
	$pname = $_POST['iplan'];
	$product = $_POST['ipname'];
	$comp = $_POST['icname'];
	$dlink = $_POST['directlink'];
	$discount = $_POST['discount'];
	$discount_rate = $_POST['discount_rate'];
	$current_user = $_SESSION['id'];

	$insertPlan = mysqli_query($db, "INSERT INTO wp_dh_insurance_plans(plan_name,product,insurance_company,premedical,family_plan, flatrate_type, flatrate,rate_base,monthly_two,feature,  sales_tax,smoke,  smoke_rate,cdiscountrate,directlink,created_by,last_updated_by,discount,discount_rate,status) VALUES('$pname','$product','$comp','$preMedical','$familyPlan', '$flatrate_type', '$iflatrateprice','$rateBase','$monthlytwo','$feature', '$sales_tax','$smoke','$smokeprice', '$cdiscountprice', '$dlink', '$current_user', '$current_user', '$discount', '$discount_rate','1')");


		$planId = $db->insert_id;
		// Inserting the Benefits Details
		for($i=0;$i<count($_POST['ibenefitHead']);$i++){
			$bene_head = $_POST['ibenefitHead'][$i];
			$bene_desc = $_POST['ibenefitDesc'][$i];
			$bene_time = time();
			$current_user = $_SESSION['id'];
			$insertBenefit = mysqli_query($db, "INSERT INTO wp_dh_insurance_plans_benefits(plan_id, benefits_head, benefits_desc,created_on , created_by ) VALUES('$planId','$bene_head', '$bene_desc', '$bene_time' , '$current_user' )");
		}
		// Inserting the PDF Policy
		//for($i=0;$i<count($_POST['ipdfPolicy']);$i++){
			$newfile = date('dmYHis').'_'.str_replace(" ", "", basename($_FILES['ipdfPolicy']['name']));	
			move_uploaded_file($_FILES['ipdfPolicy']['tmp_name'], "uploads/" .$newfile);
			$pdfpolicy = date('dmYHis').'_'.$_FILES['ipdfPolicy']['name'];
			$current_user = $_SESSION['id'];
			$time = time();
			
			$insertPDF = mysqli_query($db, "INSERT INTO wp_dh_insurance_plans_pdfpolicy (plan_id, pdfpolicy,created_on , created_by ) VALUES('$planId','$pdfpolicy', '$time', '$current_user')");
			
		//}
		// Inserting the Deductibles

		for($i=0;$i<count($_POST['ideductHash']);$i++){
			$deduct = $_POST['ideductHash'][$i];
			$ideductPer = $_POST['ideductPer'][$i];
			$time = time();
			$cuser = $_SESSION['id'];
			$insertDeduct = mysqli_query($db, "INSERT INTO wp_dh_insurance_plans_deductibles(plan_id, deductible1,deductible2,created_on, created_by ) VALUES('$planId', '$deduct', '$ideductPer','$time', '$cuser')");
		}

		// Inserting the Rates

		if($rateBase == '3')
		{
			//echo count($_POST['sr']);
			for($i=1;$i<=count($_POST['sr']);$i++){
			  //echo $i;
		   		 $max = $_POST['iratesMax1'][$i-1];
			     $min = $_POST['iratesMin1'][$i-1];
				 //echo 'Min-'.$min;
				 //echo ' Max-'.$max.'<br/>';
				 $s = 0;
                 foreach($_POST['days_rate_range1'] as $dayrange){
				
				//echo $s;
				  $range = $dayrange;
				  $ranger = str_replace(' ', '', $range);
				  $ranges = explode('-', $ranger);
				  $min_range = $ranges[0];
				  $max_range = $ranges[1];

				  if($max_range == ''){
					  $max_range = $min_range;
				  }					

				  $price = $_POST['days_rate'.$i][$s];
				$s++;
				  
			     $insertRates1 = mysqli_query($db, "INSERT INTO wp_dh_plan_day_rate(plan_id,minage,maxage,sum_insured,min_range,max_range,range_rate,rate,created_on) VALUES('$planId','$min','$max','".$_POST['iratesSum1'][$i-1]."','$min_range','$max_range','$range','$price',now())");
			  }
			 }
			 
		} else {
			
			for($i=0;$i<count($_POST['iratesMin']);$i++){
			$irateMin = $_POST['iratesMin'][$i];
			$irateMax = $_POST['iratesMax'][$i];
			$irateSum = $_POST['iratesSum'][$i];
			$irateRate = $_POST['iratesRate'][$i];
			$cuser = $_SESSION['id'];
			$time = time();
			$insertRates = mysqli_query($db, "INSERT INTO wp_dh_insurance_plans_rates(plan_id, minage,maxage,sum_insured,rate,created_on, created_by ) VALUES('$planId','$irateMin','$irateMax','$irateSum','$irateRate', '$time', '$cuser')");
		}
		}

		// Inserting features
		for($i=0;$i<count($_POST['ifeaturelist']);$i++){
			$features = $_POST['ifeaturelist'][$i];
			$userID = $_SESSION['id'];
			$time = time();

			$insertRates = mysqli_query($db, "INSERT INTO wp_dh_insurance_plans_features(plan_id, features,created_on, created_by ) VALUES( '$planId','$features','$time','$userID')");
			
		}
		//return true;
		//echo " Successfully! All Records Inserted ";	 
		//exit;


	//return true;

echo "<script>window.location='plans.php';</script>";
}
else if($_REQUEST['action'] == 'update'){
	$id = $_POST['update_id'];
	$preMedical = $_POST['imedical'];
	$familyPlan = $_POST['ifamily'];
	$usa_rate = $_POST['usa_rate'];
	$canada_rate=$_POST['canada_rate'];
	$nonusa_rate=$_POST['nonusa_rate'];
	$rateBase = $_POST['irateCalculation'];
	$monthlytwo = $_POST['monthlytwo'];
	$smoke = $_POST['smoke'];
	$smokeprice = $_POST['smokeprice'];
	$cdiscountprice = $_POST['cdiscountprice'];
	$sales_tax = $_POST['sales_tax'];
	$flat =  $_POST['iflat'];
	$iflatrateprice = $_POST['iflatrateprice'];
	$flatrate_type = $_POST['flatrate_type'];
	$feature = $_POST['ifeature'];
	$pname = $_POST['iplan'];
	$product = $_POST['ipname'];
	$comp = $_POST['icname'];
	$dlink = $_POST['directlink'];
	$discount = $_POST['discount'];
	$discount_rate = $_POST['discount_rate'];
	$current_user = $_SESSION['id'];;
	$last_update = date("Y-m-d H:i:s");

	$insertPlan = "UPDATE wp_dh_insurance_plans SET plan_name='$pname', product='$product', insurance_company='$comp', sales_tax='$sales_tax', smoke_rate='$smokeprice',  smoke='$smoke', premedical='$preMedical', family_plan='$familyPlan',   flatrate_type='$flatrate_type',   flatrate='$iflatrateprice', rate_base='$rateBase',monthly_two='$monthlytwo', feature='$feature', directlink='$dlink', last_updation='$last_update', last_updated_by='$current_user', `discount`='$discount',`discount_rate`='$discount_rate' WHERE id='$id'";

	$planId = $id;

		if(mysqli_query($db, $insertPlan)){
				$deleteBenefits = mysqli_query($db, "DELETE FROM wp_dh_insurance_plans_benefits where plan_id='$planId'");
			for($i=0;$i<count($_POST['ibenefitHead']);$i++){

				$bene_head = $_POST['ibenefitHead'][$i];
				$bene_desc = $_POST['ibenefitDesc'][$i];
				$bene_time = time();
				$current_user = $_SESSION['id'];
				$insertBenefit = mysqli_query($db, "INSERT INTO wp_dh_insurance_plans_benefits(plan_id, benefits_head, benefits_desc,created_on , created_by ) VALUES('$planId','$bene_head', '$bene_desc', '$bene_time' , '$current_user' )");
			}

			$deletePolicy = mysqli_query($db, "DELETE FROM wp_dh_insurance_plans_pdfpolicy where plan_id='$planId'");

			//for($i=0;$i<count($_POST['ipdfPolicy']);$i++){
				$newfile = date('dmYHis').'_'.str_replace(" ", "", basename( $_FILES['ipdfPolicy']['name']));	
				move_uploaded_file($_FILES['ipdfPolicy']['tmp_name'], "uploads/" .$newfile);
				$pdfpolicy = date('dmYHis').'_'.$_FILES['ipdfPolicy']['name'];
				$current_user = $_SESSION['id'];
				$time = time();

				$insertPDF = mysqli_query($db, "INSERT INTO wp_dh_insurance_plans_pdfpolicy(plan_id, pdfpolicy,created_on , created_by ) VALUES('$planId','$pdfpolicy', '$time', '$current_user')");
			//}

			$deleteDeductibles = mysqli_query($db, "DELETE FROM wp_dh_insurance_plans_deductibles where plan_id='$planId'");

			for($i=0;$i<count($_POST['ideductHash']);$i++){
				$deduct = $_POST['ideductHash'][$i];
				$ideductPer = $_POST['ideductPer'][$i];
				$time = time();
				$cuser = $_SESSION['id'];
				$insertDeduct = "INSERT INTO wp_dh_insurance_plans_deductibles(plan_id, deductible1,deductible2,created_on, created_by ) VALUES('$planId', '$deduct', '$ideductPer','$time', '$cuser')";

				mysqli_query($db, $insertDeduct);

			}


			// Inserting the Rates
			
			if($rateBase == '3')
			{
				$deleteRates=mysqli_query($db, "DELETE FROM wp_dh_plan_day_rate where plan_id='$planId'");
				//echo count($_POST['sr']);
				for($i=1;$i<=count($_POST['sr']);$i++){
				  //echo $i;
					 $max = $_POST['iratesMax1'][$i-1];
					 $min = $_POST['iratesMin1'][$i-1];
					 //echo 'Min-'.$min;
					 //echo ' Max-'.$max.'<br/>';
					 $s = 0;
					 foreach($_POST['days_rate_range1'] as $dayrange){
					
					//echo $s;
					  $range = $dayrange;
					  $ranger = str_replace(' ', '', $range);
					  $ranges = explode('-', $ranger);
					  $min_range = $ranges[0];
					  $max_range = $ranges[1];

					  if($max_range == ''){
						  $max_range = $min_range;
					  }					

					  $price = $_POST['days_rate'.$i][$s];
					$s++;
					  
					 $insertRates1 = mysqli_query($db, "INSERT INTO wp_dh_plan_day_rate(plan_id,minage,maxage,sum_insured,min_range,max_range,range_rate,rate,created_on) VALUES('$planId','$min','$max','".$_POST['iratesSum1'][$i-1]."','$min_range','$max_range','$range','$price',now())");
				  }
				 }
			} else {
				$deleteRates=mysqli_query($db, "DELETE FROM wp_dh_insurance_plans_rates where plan_id='$planId'");	
				for($i=0;$i<count($_POST['iratesMin']);$i++){
				$irateMin = $_POST['iratesMin'][$i];
				$irateMax = $_POST['iratesMax'][$i];
				$irateSum = $_POST['iratesSum'][$i];
				$irateRate = $_POST['iratesRate'][$i];
				$cuser = $_SESSION['id'];
				$time = time();
				$insertRates = mysqli_query($db, "INSERT INTO wp_dh_insurance_plans_rates(plan_id, minage,maxage,sum_insured,rate,created_on, created_by ) VALUES('$planId','$irateMin','$irateMax','$irateSum','$irateRate', '$time', '$cuser')");
			}
			}
		


			// deleteing features
			$deletefeaure = mysqli_query($db, "DELETE FROM wp_dh_insurance_plans_features where plan_id='$planId'");

			// Inserting features
			for($i=0;$i<count($_POST['ifeaturelist']);$i++){
				$features = $_POST['ifeaturelist'][$i];
				$userID = $_SESSION['id'];
				$time = time();
				$insertRates="INSERT INTO wp_dh_insurance_plans_features(plan_id, features,created_on, created_by ) VALUES( '$planId','$features','$time','$userID')";
				mysqli_query($db, $insertRates);
			}


			
		}
		
echo "<script>window.location='plans.php';</script>";	
}
?>

<!doctype html>
<html lang="en-US">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Manage Plans</title>
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
<style>
#middle div.panel-heading {
color: #1E252D !important;
height: auto !important;
background: #DEDEDE !important;
border-bottom: 2px solid #CCC !important;
}
.design-select {
float: left;
margin-right: 7px;
border: 2px solid #F9F9F9;
cursor: pointer;
}
.selected {
border: 2px solid #245580;	
}
form .row {
	margin-bottom:5px !important;
}
</style>

<script src="assets/js/jquery-1.12.4.js"></script>
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
					<h1>Manage Plan</h1>
					<ol class="breadcrumb">
						<li><a href="plans.php">Plans</a></li>
						<li class="active">Manage Plan</li>
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
$srno = 0;
$sql = mysqli_query($db, "SELECT * FROM `wp_dh_insurance_plans` WHERE `id`='".$_REQUEST['id']."'");
$fetch = mysqli_fetch_assoc($sql);
$srno++;	
$plan_id = $fetch['id'];
$plan_name = $fetch['plan_name'];
$product = $fetch['product'];
$insurance_company = $fetch['insurance_company'];
$premedical = $fetch['premedical'];
$family_plan = $fetch['family_plan'];
$flatrate_type = $fetch['flatrate_type'];
$flatrate = $fetch['flatrate'];
$rate_base = $fetch['rate_base'];
$monthly_two = $fetch['monthly_two'];
$feature = $fetch['feature'];
$sales_tax = $fetch['sales_tax'];
$smoke_rate = $fetch['smoke_rate'];
$smoke = $fetch['smoke'];
$cdiscountrate = $fetch['cdiscountrate'];
$directlink = $fetch['directlink'];
$created_on = $fetch['created_on'];
$created_by = $fetch['created_by'];
$last_updation = $fetch['last_updation'];
$last_updated_by = $fetch['last_updated_by'];
$status = $fetch['status'];
$discount = $fetch['discount'];
$discount_rate = $fetch['discount_rate'];

$pro_q = mysqli_query($db, "SELECT * FROM `wp_dh_products` WHERE `pro_id`='$product'");
$pro_f = mysqli_fetch_assoc($pro_q);

$co_q = mysqli_query($db, "SELECT * FROM `wp_dh_companies` WHERE `comp_id`='$insurance_company'");
$co_f = mysqli_fetch_assoc($co_q);		
?>
	<form action="?action=<?php if($_REQUEST['id']){ echo 'update'; } else { echo 'add'; }?>" method="post" class="web-form" id="itemPlan" novalidate="novalidate" enctype="multipart/form-data">
		<!-- Add Plan Details -->

		<div class="row">

			<div class="panel panel-default col-md-6">
			 <div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<h4 class="text-primary" style="margin:0;"><strong><i class="fa fa-umbrella"></i> Enter Plan Details</strong></h4>
					</div>
				</div>
				<div class="row">
				<div class="col-md-12">
					<label><i class="fa fa-leaf"></i> <strong class="text-danger">Select Product</strong></label>
						<select autocomplete="on" name="ipname" id="ipname" class="form-control">
									<?php
									$pr_q = mysqli_query($db, "SELECT * FROM `wp_dh_products`");
									while($pr_f = mysqli_fetch_assoc($pr_q)){
									?>
									<option value="<?php echo $pr_f['pro_id'];?>" <?php if($product == $pr_f['pro_id']){?> selected="" <?php } ?>><?php echo $pr_f['pro_name'];?></option>
									<?php
									}
									?>

							</select>

				</div>
				</div>
				
				<div class="row">
				<div class="col-md-12">
					<label><strong>Name of the Plan</strong></label>
					<input id="iplan" name="iplan" placeholder="Enter Plan Name" class="form-control" value="<?php echo $plan_name;?>" type="text">
				</div>
				</div>
				
				<div class="row">
				<div class="col-md-12">
					<label><i class="fa fa-building"></i> <strong>Select Company</strong></label>
						<select autocomplete="on" name="icname" id="icname" class="form-control">
							<option value="">None</option>
									<?php
									$co_q = mysqli_query($db, "SELECT * FROM `wp_dh_companies`");
									while($co_f = mysqli_fetch_assoc($co_q)){
									?>
									<option value="<?php echo $co_f['comp_id'];?>" <?php if($insurance_company == $co_f['comp_id']){?> selected="" <?php } ?>><?php echo $co_f['comp_name'];?></option>
									<?php
									}
									?>

							</select>

				</div>
				</div>



				<div class="original row">
					<div class="col-md-12" id="links">
						<label><i class="fa fa-shopping-cart"></i> Buynow Link</label>
							<input id="directlink" name="directlink" class="form-control" placeholder="https://" value="<?php echo $directlink;?>" type="text">

					</div>
				</div>
				</div>

			</div>


<div class="panel panel-default col-md-6">
			 <div class="panel-body">
<h4 class="item-sub"><i class="fa fa-gear"></i> Plan Settings</h4>
				<div class="row">
				<div class="col-md-12">
					<label><strong>Do you want to add Features?</strong></label>
				</div>
				<div class="col-md-12">
					<label class="switch switch-success switch-round">
						<input type="checkbox" name="ifeature" id="ifeature" <?php if($ifeature == '1'){?> checked="" <?php } ?> value="1">
						<span class="switch-label" data-on="YES" data-off="NO"></span>
					</label>
				</div>
				</div>
				
				<div class="row">
				<div class="col-md-12">
				<label><strong>Select Rates Type</strong></label>
				</div>
				<div class="col-md-12">
				<!-- radio -->
				<label class="radio">
					<input type="radio" value="0" <?php if($rate_base == '0'){?> checked="" <?php } ?> name="irateCalculation" id="daily" onclick="tempcall_0();">
					<i></i> Daily
				</label>
				<label class="radio">
					<input type="radio" value="1" <?php if($rate_base == '1'){?> checked="" <?php } ?> name="irateCalculation" id="daily" onclick="tempcall_0();">
					<i></i> Monthly
				</label>
				<label class="radio">
					<input type="radio" value="2" <?php if($rate_base == '2'){?> checked="" <?php } ?> name="irateCalculation" id="daily" onclick="tempcall_0();">
					<i></i> Yearly
				</label>
				<label class="radio">
					<input type="radio" value="3" <?php if($rate_base == '3'){?> checked="" <?php } ?> name="irateCalculation" id="daily" onclick="tempcall_3();">
					<i></i> Multi
				</label>
				<label class="checkbox">
					<input type="checkbox" name="monthlytwo" <?php if($monthly_two == '1'){?> checked="" <?php } ?> id="monthlytwo" value="1">
					<i></i> Monthly Option 2
				</label>
				<input type="hidden" name="temp_ratebase" id="temp_ratebase" value="0">
				</div>
<script>
function tempcall_0(){
document.getElementById('temp_ratebase').value = '0';
checkratebase();
}
function tempcall_3(){
document.getElementById('temp_ratebase').value = '3';
checkratebase();
}
function checkratebase(){
if(document.getElementById('temp_ratebase').value == '0'){
$('.daily_monthly').show();
$('.day_basis').hide();
} else if(document.getElementById('temp_ratebase').value == '3'){
$('.daily_monthly').hide();
$('.day_basis').show();
}
}
</script>
				<div class="col-md-12">
					<label><strong>Provincial Sales Tax</strong></label>
						<select name="sales_tax" class="form-control">
							<option value="">None</option>
							<option value="8% ontario" <?php if($sales_tax == ''){?> selected="8% ontario" <?php } ?>>8% sales tax ontario</option>
							<option value="9% quebec" <?php if($sales_tax == ''){?> selected="9% quebec" <?php } ?>>9% sales tax quebec</option>
							<option value="8% manitoba" <?php if($sales_tax == ''){?> selected="8% manitoba" <?php } ?>>8% sales tax manitoba</option>
					      </select>
				</div>

			</div>


			<div class="col-md-12">
					<label class="switch switch-success switch-round">
						<input type="checkbox" name="imedical" id="imedical" <?php if($premedical == '1'){?> checked="" <?php } ?> value="1">
						<span class="switch-label" data-on="YES" data-off="NO"></span>
						<strong>Pre Existing Medical Condition ?</strong>
					</label>
				</div>

				<div class="col-md-12">
					<label class="switch switch-success switch-round">
						<input type="checkbox" name="ifamily" id="ifamily" <?php if($family_plan == '1'){?> checked="" <?php } ?> value="1">
						<span class="switch-label" data-on="YES" data-off="NO"></span>
						<strong>Family Package ? check for yes</strong>
					</label>
				</div>

				

			
				<div class="col-md-12">
					<label class="switch switch-success switch-round">
						<input type="checkbox" name="cdiscountrate" id="cdiscountrate" class="cdiscountrate" <?php if($cdiscountrate != '0'){?> checked="" <?php } ?> value="1" onclick="cdiscountratecheck()">
						<span class="switch-label" data-on="YES" data-off="NO"></span>
						<strong>Do you want to apply discount on Canadian ?</strong>
					</label>
				</div>
				
				<div class="col-md-12" id="discountrateshow" style="display:<?php if($cdiscountrate != '0'){ echo 'block;'; } else { echo 'none'; } ?>">
					<label><strong>Canadian Discount Rate</strong></label>
						<input id="cdiscountprice" name="cdiscountprice" class="form-control" value="<?php echo $cdiscountrate;?>" placeholder="Discount Rate" type="text">

				</div>
<script>
function cdiscountratecheck(){
if(document.getElementById('cdiscountrate').checked == true){
document.getElementById('discountrateshow').style.display = 'block';	
} else {
document.getElementById('discountrateshow').style.display = 'none';	
}	
}
</script>				
				<div class="col-md-12" style="margin-top: 10px;">
					<label class="switch switch-success switch-round">
						<input type="checkbox" name="iflat" id="flatratecheck" <?php if($flatrate > '0'){?> checked="" <?php } ?> value="1" onclick="flatratecheckfunc()">
						<span class="switch-label" data-on="YES" data-off="NO"></span>
						<strong>Do you want to add flat rate ?</strong>
					</label>
				</div>
					<div class="col-md-12" id="flatratediv" style="display: <?php if($flatrate > '0'){ echo 'block;'; } else { echo 'none'; } ?>">
					<label class="radio">
						<input type="radio" value="each" <?php if($flatrate_type == 'each'){?> checked="" <?php } ?> name="flatrate_type">
						<i></i> For Each User
					</label>
					<label class="radio">
						<input type="radio" value="total" <?php if($flatrate_type == 'total'){?> checked="" <?php } ?> name="flatrate_type">
						<i></i> On Total Premium
					</label>
				
					
					<div class="col-md-12" style="clear:both; padding:0;">
					<label><strong>Flat Rate</strong></label>
						<input id="iflatrateprice" name="iflatrateprice" placeholder="Flat Rate" value="<?php echo $flatrate;?>" class="form-control" type="text">
					</div>

				</div>
<script>
function flatratecheckfunc(){
if(document.getElementById('flatratecheck').checked == true){
document.getElementById('flatratediv').style.display = 'block';	
} else {
document.getElementById('flatratediv').style.display = 'none';	
}	
}
</script>









				<div class="col-md-12" style="margin-top: 10px;">
					<label class="switch switch-success switch-round">
						<input type="checkbox" name="discount" id="discount" <?php if($discount == '1'){?> checked="" <?php } ?> value="1" onclick="discountfunc()">
						<span class="switch-label" data-on="YES" data-off="NO"></span>
						<strong>Do you want to give discount ?</strong>
					</label>
				</div>
					<div class="col-md-12" id="discountdiv" style="display: <?php if($discount == '1'){ echo 'block;'; } else { echo 'none'; } ?>">
					<label><strong>Discount Rate (%)</strong></label>
						<input id="discount_rate" name="discount_rate" placeholder="Discount Rate" value="<?php echo $discount_rate;?>" class="form-control" type="text">

				</div>
<script>
function discountfunc(){
if(document.getElementById('discount').checked == true){
document.getElementById('discountdiv').style.display = 'block';	
} else {
document.getElementById('discountdiv').style.display = 'none';	
}	
}
</script>


				<div class="col-md-12">

					<label><strong>Rate Type for Smoked Person</strong></label>					

				</div>

					<div class="col-md-12" id="stop_usa">
					<label class="radio">
						<input type="radio" value="0" <?php if($smoke == '0'){?> checked="" <?php } ?> name="smoke" id="smoke">
						<i></i> Fixed Price ($)
					</label>
					<label class="radio">
						<input type="radio" value="1" <?php if($smoke == '1'){?> checked="" <?php } ?> name="smoke" id="smoke">
						<i></i> Percentage (%)
					</label>
					
					<div class="clear" style="height:15px;"></div>
					<div class="col-md-12" style="padding:0;">
						<input id="smokeprice" name="smokeprice" class="form-control" value="<?php echo $smoke_rate;?>" placeholder="Smoke Rate" type="text">
					</div>

				</div>


</div>


			</div>

		</div>


<div class="panel-body">
			
					<!-- Rate Section for all other products except single -->

	<div class="daily_monthly" id="daily_monthly" style="<?php if($rate_base=='0' || $rate_base=='1' || $rate_base=='2') { echo 'display:block'; } else {echo 'display:none';}?>">

		<div class="row" id="ratesItem">

			<div class="col-md-12">

				<h4 class="item-sub" style="margin: 0;margin-bottom: 20px;margin-top: 5px; color:#c00;"><i class="fa fa-shopping-cart"></i> Manage Plan Prices</h4>
				<?php
				if($_REQUEST['id']){
				$counter=0;

				$rats_q = mysqli_query($db, "SELECT * FROM `wp_dh_insurance_plans_rates` WHERE `plan_id`='".$_REQUEST['id']."'");
				$rats_num = mysqli_num_rows($rats_q);
					while($rats_f = mysqli_fetch_assoc($rats_q)){
					$counter++;
					if($counter == 1){
				?>
				<div class="original">

					<div class="row" style="margin-bottom: 10px;">
						<div class="col-md-1" style="width: 71px;margin-right: 10px;padding: 0;">
							<div class="col-md-12">
							<label><strong>Select</strong></label>
							</div>
							<div class="col-md-12">
							<label class="checkbox">
								<input type="checkbox" value="1" id="rt[]" name="rt[]">
								<i></i>
							</label>
							</div>
						</div>

						<div class="col-md-2">
							<label><strong>Min Age</strong></label>
							<input id="iratesMin1" name="iratesMin[]" class="form-control" value="<?php echo $rats_f['minage'];?>" type="text" class="min_1">
						</div>

						<div class="col-md-2">
							<label><strong>Max Age</strong></label>
							<input id="iratesMax1" name="iratesMax[]" class="form-control" value="<?php echo $rats_f['maxage'];?>" type="text" class="max_1">
						</div>

						<div class="col-md-3">
							<label class="wrapup"><strong>Benefit Amount</strong></label>
							<input id="iratesSum1" name="iratesSum[]" class="form-control" value="<?php echo $rats_f['sum_insured'];?>" type="text" class="sum_1">
						</div>

						<div class="col-md-2">
							<label><strong>Rate ($)</strong></label>
								<input id="iratesRate1" name="iratesRate[]" class="form-control" value="<?php echo $rats_f['rate'];?>" type="text">
						</div>

					</div>

				</div>
					<div id="appendRates">
				
				<?php } else {
				$rand = $counter * (rand(10,100)); 
				?>
					<div class="appendRates" id="row_<?php echo date('his').$rand;?>" style="margin-bottom: 10px;">
					<div class="row">
							<div class="col-md-1" style="width: auto;margin-right: 10px;">
								<label class="checkbox">
								<input type="checkbox" value="<?php echo date('his').$rand;?>" id="rt[]" name="rt[]">
								<i></i>
							</label>
							</div>
							<div class="col-md-2">
								<div class="input">
									<input type="text" id="iratesMin'+countRates+'" name="iratesMin[]" class="min_<?php echo date('his').$rand;?> form-control" value="<?php echo $rats_f['minage'];?>">
								</div>
							</div>
							<div class="col-md-2">
								<div class="input">
									<input type="text" id="iratesMax'+countRates+'" name="iratesMax[]" class="max_<?php echo date('his').$rand;?> form-control" value="<?php echo $rats_f['maxage'];?>">
								</div>
							</div>
							<div class="col-md-3">
								<div class="input">
									<input type="text" id="iratesSum'+countRates+'" name="iratesSum[]" class="sum_<?php echo date('his').$rand;?> form-control" value="<?php echo $rats_f['sum_insured'];?>">
								</div>
							</div>
							<div class="col-md-2">
								<div class="input">
									<input type="text" id="iratesRate'+countRates+'" name="iratesRate[]" class="form-control" value="<?php echo $rats_f['rate'];?>">
								</div>
							</div>
						</div>
							</div>
					<?php } if($rats_num == $counter){ ?> </div> <?php

				}

				}

				?>		
					<?php } else {?>
					<div class="original">
					<div class="row">
						<div class="col-md-1" style="width: auto;margin-right: 10px;">
							<label class="checkbox">
								<input type="checkbox" value="1" id="rt[]" name="rt[]">
								<i></i>
							</label>
						</div>
						<div class="col-md-2">
							<label><strong>Min Age</strong></label>
							<input id="iratesMin1" name="iratesMin[]" class="form-control" type="text" class="min_1">
						</div>
						<div class="col-md-2">
							<label><strong>Max Age</strong></label>
							<input id="iratesMax1" name="iratesMax[]" class="form-control" type="text" class="max_1">
						</div>
						<div class="col-md-3">
							<label class="wrapup"><strong>Benefit Amount</strong></label>
							<input id="iratesSum1" name="iratesSum[]" class="form-control" type="text" class="sum_1">
						</div>
						<div class="col-md-2">
							<label><strong>Rate</strong></label>
								<input id="iratesRate1" name="iratesRate[]" class="form-control" type="text">
						</div>
					</div>
				</div>
				<div id="appendRates"></div>
					<?php } ?>
				

				<div class="clear" style="clear:both; height:10px;"></div>

				<div class="row">

					<div class="col-md-12">
						<a href="javascript:void(0)" class="btn btn-default btn-sm addRates addnewItem"><i class="fa fa-plus"></i> Add Item</a>
						<a href="javascript:void(0)" class="btn btn-warning btn-sm copyRates addnewItem"><i class="fa fa-copy"></i> Copy Items</a>
						<a href="javascript:void(0)" class="btn btn-danger btn-sm removeRates addnewItem"><i class="fa fa-trash"></i> Remove Items</a>
					</div>

				</div>

				<hr>

			</div>

		

		</div>

	</div>

<div class="clear"></div>

	<div class="day_basis" id="day_basis" style="display:<?php if($rate_base == '3'){ echo 'block'; } else { echo 'none'; } ?>;">

		<div class="row" id="ratesItem">

			<div class="col-md-12">

				<h4 class="item-sub"><i class="fa fa-plus"></i> Add Rates</h4>


<?php
$ranges_q = mysqli_query($db, "SELECT * FROM `wp_dh_plan_day_rate` WHERE `plan_id`='".$_REQUEST['id']."' GROUP BY `minage`, `maxage` ORDER BY `id`");
$ranges_num = mysqli_num_rows($ranges_q);
if($ranges_num == 0){?>
<div class="original">
					<div class="row pricerow_1">
						<div class="col-md-1" style="width: auto;margin-right: 10px;">
							<div class="col-md-12 text-center" style="padding:0;">
							<label><strong>Select</strong></label>
							</div>
							<div class="col-md-12 text-center" style="padding:0;">
							<label class="checkbox" style="margin:0;">
								<input type="checkbox" value="1" id="sr[]" class="form-control sr" name="sr[]" style="margin: 0;">
								<i></i>
							</label>
							</div>
						</div>
						
						<div class="col-md-1">
							<label style="margin-bottom:20px;"><strong>Min Age</strong></label>
							<input id="iratesMin1" class="form-control" class="form-control" name="iratesMin1[]" value="<?php echo $ranges_f['minage'];?>" type="text">

						</div>

						<div class="col-md-1">
							<label style="margin-bottom:20px;"><strong>Max Age</strong></label>
<input id="iratesMax1" class="form-control" name="iratesMax1[]" class="form-control" value="<?php echo $ranges_f['maxage'];?>" type="text">

						</div>

						<div class="col-md-2 margin5 nopad">
							<label style="margin-bottom:20px;"><strong>Benefit</strong></label>
<input id="iratesSum1" class="form-control" name="iratesSum1[]" class="form-control" value="<?php echo $ranges_f['sum_insured'];?>" type="text">
						</div>
<div class="dayrange_1">
						<div class="col-md-1 rangegroup_1" style="padding:0;">
						<div class="col-md-12" style="padding:0;">
						<input placeholder="Days Range" class="form-control" id="days_rate_range" name="days_rate_range1[]" class="form-control" value="<?php echo $sub_ranges_f['range_rate'];?>" type="text">
						</div>
						<div class="col-md-12" style="padding:0;">
						<input id="days_rate" placeholder="Price" class="form-control" name="days_rate1[]" class="form-control" value="<?php echo $sub_ranges_f['rate'];?>" type="text">
						</div>
						</div>
</div>
					</div>
				</div>	
<?php } else {
$prow = 0;	
while($ranges_f = mysqli_fetch_assoc($ranges_q)){
$prow++;	
?>
					<div class="row pricerow_<?php echo $prow;?>">
						<div class="col-md-1" style="width: auto;margin-right: 10px;">
							<?php if($prow == 1){?>
							<div class="col-md-12 text-center" style="padding:0;">
							<label><strong>Select</strong></label>
							</div>
							<?php } ?>
							<div class="col-md-12 text-center" style="padding: <?php if($prow == 1){ echo '0'; } else { echo '0 21px'; }?>;">
							<label class="checkbox" style="margin:0;">
								<input type="checkbox" value="1" id="sr[]" class="form-control sr" name="sr[]" style="margin: 0;">
								<i></i>
							</label>
							</div>
						</div>
						
						<div class="col-md-1">
							<?php if($prow == 1){?><label style="margin-bottom:20px;"><strong>Min Age</strong></label><?php } ?>
							<input id="iratesMin1" class="form-control" class="form-control" name="iratesMin1[]" value="<?php echo $ranges_f['minage'];?>" type="text">

						</div>

						<div class="col-md-1">
							<?php if($prow == 1){?><label style="margin-bottom:20px;"><strong>Max Age</strong></label><?php } ?>
<input id="iratesMax1" class="form-control" name="iratesMax1[]" class="form-control" value="<?php echo $ranges_f['maxage'];?>" type="text">

						</div>

						<div class="col-md-2 margin5 nopad">
							<?php if($prow == 1){?><label style="margin-bottom:20px;"><strong>Benefit</strong></label><?php } ?>
<input id="iratesSum1" class="form-control" name="iratesSum1[]" class="form-control" value="<?php echo $ranges_f['sum_insured'];?>" type="text">
						</div>
<div class="dayrange_<?php echo $prow;?>">
<?php
$r = 0;
$sub_ranges_q = mysqli_query($db, "SELECT * FROM `wp_dh_plan_day_rate` WHERE `plan_id`='".$_REQUEST['id']."' AND `minage`='".$ranges_f['minage']."' AND `maxage`='".$ranges_f['maxage']."' ORDER BY `id`");
$sub_ranges_num = mysqli_num_rows($sub_ranges_q);
while($sub_ranges_f = mysqli_fetch_assoc($sub_ranges_q)){
$r++;
?>

						<div class="col-md-1 rangegroup_<?php echo $r;?>" style="padding:0;">
						<?php if($prow == 1){?><div class="col-md-12" style="padding:0;">
						<input placeholder="Days Range" class="form-control" id="days_rate_range" name="days_rate_range1[]" class="form-control" value="<?php echo $sub_ranges_f['range_rate'];?>" type="text">
						</div><?php } ?>
						<div class="col-md-12" style="padding:0;">
						<input id="days_rate" placeholder="Price" class="form-control" name="days_rate<?php echo $prow;?>[]" class="form-control" value="<?php echo $sub_ranges_f['rate'];?>" type="text">
						</div>
						</div>
						
<?php } ?>
</div>
					</div>
<?php }

} ?>
				<div id="appendRates1"></div>

<input type="hidden" id="currentragerows" value="<?php if($_REQUEST['id'] && $sub_ranges_num > 0){ echo $sub_ranges_num; } else { echo '1'; }?>" />
<input type="hidden" id="pricerows" value="<?php if($_REQUEST['id'] && $ranges_num > 0){ echo $ranges_num; } else { echo '1'; }?>" />
				

				<div class="clear" style="clear:both; height:10px;"></div>

				<div class="row">
					<div class="col-md-6">
						<a href="javascript:void(0)" class="btn btn-default btn-sm addnewItem" onclick="addmultirate();"><i class="fa fa-plus"></i> Add Item</a>
						<a href="javascript:void(0)" class="btn btn-default btn-sm copyRates1 addnewItem"><i class="fa fa-copy"></i> Copy Items</a>
						<a href="javascript:void(0)" class="btn btn-danger btn-sm addnewItem" onclick="removemultirate();"><i class="fa fa-trash"></i> Remove Items</a>
					</div>

					<div class="col-md-6">
						<a href="javascript:void(0)" class="btn btn-default btn-sm addnewItem" onclick="adddayrange();"><i class="fa fa-plus"></i> Add Day Range</a>
						<a href="javascript:void(0)" class="btn btn-danger btn-sm addnewItem" onclick="removedayrange();"><i class="fa fa-trash"></i> Remove Day Range</a>
					</div>
					<div class="clear">&nbsp;</div>
				</div>
				<hr>
			</div>

		

		</div>

	</div>

		<!-- End Rate Section for all other products except single -->

<div class="clear"></div>

<div class="row" id="ratesItem">

		<div class="col-md-6">

				<h4 class="item-sub" style="margin: 0;margin-bottom: 20px;margin-top: 5px; color:#c00;"><i class="fa fa-leaf"></i> Manage Deductables</h4>
				<div class="row">
					<div class="col-md-6"><label style="margin:0; padding:0;"><strong>Deductable Amount</strong></label></div>
					<div class="col-md-6"><label style="margin:0; padding:0;"><strong>Deductable Rate (%)</strong></label></div>
				</div>
				<div class="row">
<?php
if($_REQUEST['id']){
$sr = 0;
$de_q = mysqli_query($db, "SELECT * FROM `wp_dh_insurance_plans_deductibles` WHERE `plan_id`='".$_REQUEST['id']."'");
$de_num = mysqli_num_rows($de_q);
while($de_f = mysqli_fetch_assoc($de_q)){
$sr++;
if($sr == 1){
echo '';
$class = 'appended';

?>
					<div class="original" style="margin-top:10px; margin-bottom:0; margin-right:0; margin-left:0;">
						<div class="col-md-6 unit"  >
							<div class="widget left-50">
								<input name="ideductHash[]" id="ideductHash1" class="form-control" value="<?php echo $de_f['deductible1'];?>" placeholder="Deductible 1" type="text">
							</div>	
						</div>	
						<div class="col-md-6 unit" >
							<div class="widget left-50">
								<input name="ideductPer[]" id="ideductPer1" class="form-control" value="<?php echo $de_f['deductible2'];?>" placeholder="Deductible 1" type="text">
							</div>	
						</div>	
					</div>
<div id="deductionAppend">					
<?php } else {?>

						<div class="row appended" style="margin-top:10px; margin-bottom:0; margin-right:0; margin-left:0;">
						<div class="col-md-6 unit"  >
							<div class="widget left-50">
								<input name="ideductHash[]" id="ideductHash1" class="form-control" value="<?php echo $de_f['deductible1'];?>" placeholder="Deductible 1" type="text">
							</div>	
						</div>	
						<div class="col-md-6 unit" >
							<div class="widget left-50">
								<input name="ideductPer[]" id="ideductPer1" class="form-control" value="<?php echo $de_f['deductible2'];?>" placeholder="Deductible 1" type="text">
							</div>	
						</div>	
					</div>

<?php } if($sr == $de_num){?>
</div>
<?php } ?>
<?php }} else {?>
					<div class="row original">
						<div class="col-md-6 unit"  >
							<div class="widget left-50">
								<input name="ideductHash[]" id="ideductHash1" class="form-control" placeholder="Deductible 1" type="text">
							</div>	
						</div>	
						<div class="col-md-6 unit" >
							<div class="widget left-50">
								<input name="ideductPer[]" id="ideductPer1" class="form-control" placeholder="Deductible 1" type="text">
							</div>	
						</div>	
					</div>
					
<?php } ?>					
				</div>
<?php if($_REQUEST['id'] == ''){ ?>
				<div class="row" id="deductionAppend">
<?php } ?>

					<div class="col-md-6">

						<a href="javascript:void(0)" class="btn btn-default btn-sm addDeduct addnewItem"><i class="fa fa-plus"></i> Add Item</a>

						<a href="javascript:void(0)" class="btn btn-danger btn-sm removeDeduct addnewItem"><i class="fa fa-trash"></i> Remove Item</a>

					</div>

					<div class="clear">&nbsp;</div>



				<div class="clear"></div>

				<hr>

			</div>
			
			<div class="col-md-6" style="display:none;">

				<h4 class="item-sub" style="margin: 0;margin-bottom: 20px;margin-top: 5px; color:#c00;"><i class="fa fa-heart"></i> Manage Benefits</h4>

				<div class="original">
<?php
if($_REQUEST['id']){
$be_q = mysqli_query($db, "SELECT * FROM `wp_dh_insurance_plans_benefits` WHERE `plan_id`='".$_REQUEST['id']."'");
while($be_f = mysqli_fetch_assoc($be_q)){
?>
					<div class="row">
						<div class="col-md-12">
							<input id="ibenefitHead1" name="ibenefitHead[]" class="form-control" value="<?php echo $be_f['benefits_head'];?>" placeholder="Enter Heading of Benefit # 1" type="text">
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<textarea placeholder="Enter benefit Description #1" class="form-control" value="<?php echo $be_f['benefits_desc'];?>" spellcheck="false" id="ibenefitDesc1" name="ibenefitDesc[]"></textarea>
						</div>
					</div>
<?php }} else { ?>
					<div class="row">
						<div class="col-md-12">
							<input id="ibenefitHead1" name="ibenefitHead[]" class="form-control" placeholder="Enter Heading of Benefit # 1" type="text">
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<textarea placeholder="Enter benefit Description #1" class="form-control" spellcheck="false" id="ibenefitDesc1" name="ibenefitDesc[]"></textarea>
						</div>
					</div>
<?php } ?>					
				</div>

				<div id="appendBenefits"></div>

				<div class="clear" style="height:20px;"></div>

				<div class="row">
					<div class="col-md-12">
					<a href="javascript:void(0)" class="btn btn-default btn-sm addBenefits  addnewItem"><i class="fa fa-plus"></i> Add Item</a>

					<a href="javascript:void(0)" class="btn btn-danger btn-sm removeBenefits addnewItem"><i class="fa fa-trash"></i> Remove Item</a>

					<div class="clear">&nbsp;</div>
					</div>
				</div>

				<hr>

			</div>


		</div>

			<div class="clear"></div>

		<!-- Third Section -->

		<div class="row">

			
			<div class="col-md-6">
				<h4 class="item-sub" style="margin: 0;margin-bottom: 20px;margin-top: 5px; color:#c00;"><i class="fa fa-file"></i> PDF Policy</h4>
				<div class="">
					<label>Upload PDF Policy</label>
						<div class="fancy-file-upload">
							<i class="fa fa-upload"></i>
							<input type="file" class="form-control" name="ipdfPolicy" id="ipdfPolicy1" onchange="jQuery(this).next('input').val(this.value);" />
							<input type="text" class="form-control" placeholder="no file selected" readonly="" />
							<span class="button">Choose File</span>
						</div>
				</div>
				<div id="appendPDFpolicy"></div>
				<div class="clear"></div>
				<div class="col-md-12" style="display:none;">
					<a href="javascript:void(0)" class="btn btn-default btn-sm addPDF addnewItem"><i class="fa fa-plus"></i> Add Item</a>
					<a href="javascript:void(0)" class="btn btn-danger btn-sm removePDF addnewItem"><i class="fa fa-trash"></i> Remove Item</a>
					<div class="clear">&nbsp;</div>
				</div>

			</div>
			<div class="col-md-6">
			<h4 class="item-sub" style="margin: 0;margin-bottom: 20px;margin-top: 5px;"><i class="fa fa-file"></i> Current PDF Policy</h4>
			<?php
			$pdfq = mysqli_query($db, "SELECT `pdfpolicy` FROM `wp_dh_insurance_plans_pdfpolicy` WHERE `plan_id`='".$_REQUEST['id']."'");
			$pdf_f = mysqli_fetch_assoc($pdfq);
			$pdfpolicy = $pdf_f['pdfpolicy'];
			?>
			<h4 class="item-sub" style="margin: 0;margin-bottom: 20px;margin-top: 5px; color:#C00;"><i class="fa fa-file"></i> <?php echo $pdfpolicy; ?></h4>
			
			</div>

			<div class="clear"></div>
			<hr>
			<div class="clear"></div>
		</div>

		<!-- Fourth Section -->

		<div class="" id="featureShow" style="display:block"> 

			<div class="col-md-12">

				<h4 class="item-sub" style="margin: 0;margin-bottom: 20px;margin-top: 5px; color:#c00;"><i class="fa fa-database"></i> Manage Features</h4>

				<div class="original">
<?php
if($_REQUEST['id']){
$fe_q = mysqli_query($db, "SELECT * FROM `wp_dh_insurance_plans_features` WHERE `plan_id`='".$_REQUEST['id']."'");
while($fe_f = mysqli_fetch_assoc($fe_q)){
?>	
					<div class="" style="margin-bottom: 10px;">
							<input id="ifeaturelist1" name="ifeaturelist[]" class="form-control" value="<?php echo $fe_f['features'];?>" placeholder="Enter Feature List # 1" type="text">
					</div>
<?php }} else {?>
					<div class="" style="margin-bottom: 10px;">
							<input id="ifeaturelist1" name="ifeaturelist[]" class="form-control" placeholder="Enter Feature List # 1" type="text">
					</div>
<?php } ?>					

				</div>

				<div id="appendFeatures"></div>

				<div class="clear" style="height:20px;"></div>

				<div class="">

					<a href="javascript:void(0)" class="btn btn-default btn-sm addFeatures addnewItem"><i class="fa fa-plus"></i> Add Item</a>

					<a href="javascript:void(0)" class="btn btn-danger btn-sm removeFeatures addnewItem"><i class="fa fa-trash"></i> Remove Item</a>

					<div class="clear">&nbsp;</div>

				</div>

				<hr>

			</div>

			

		</div>


			
			</div>

			<div class="clear"></div>

			<div class="row">
				<div class="col-md-6"> <br/>
					<button type="submit" name="submit" class="btn btn-success submit-btn addnewItem" onclick="$('.sr').prop('checked', true);"><i class="fa fa-save"></i> Submit Changes</button>
				</div>
				<div class="clear"></div>
			</div>
		
		<div class="clear"></div>
		
		</div>



		
		
		</div>
		</div>
	<input type="hidden" name="update_id" id="update_id" value="<?php echo $_REQUEST['id']; ?>" />
	</form>


				</div>

			</section>

			<!-- /MIDDLE -->



		</div>



<script>
function submitfunc(){
	var a = $("#sortable").sortable("toArray", {
		attribute: "id"
	});
	$('#savesortlist').val(a);
	$('#productform').submit();
	//alert(a);
}

function addmultirate() {
    var countRange = document.getElementById('currentragerows').value;
	var countranges = parseInt(document.getElementById('currentragerows').value) + 1;
	var pricerows = parseInt(document.getElementById('pricerows').value) + 1;
	//var 
    var range="";
    //alert(countRange);
    for(var i=1;i<=countRange;i++)
    {
      range+=  '<div class="col-md-1 rangegroup_'+ i +'" style="padding:0;">'+
		'<div class="col-md-12" style="padding:0;">'+
		'<input id="days_rate" placeholder="Price" class="form-control" name="days_rate'+ pricerows +'[]" class="form-control" value="" type="text">'+
		'</div></div>';
    }
   // alert(countRates);
    jQuery('#appendRates1').append(
	'<div class="row '+' pricerow_'+ pricerows +'">'+
	'<div class="col-md-1" style="width: auto;margin-right: 10px;">'+
	'<div class="col-md-12 text-center" style="padding:0 21px;">'+
	'<label class="checkbox" style="margin:0;">'+
	'<input type="checkbox" value="'+ pricerows +'" id="sr[]" class="form-control sr" name="sr[]" style="margin: 0;">'+
	'<i style="top: 0;"></i>'+
	'</label>'+
	'</div>'+
	'</div>'+
	'<div class="col-md-1">'+
	'<input id="iratesMin1" class="form-control" class="form-control" name="iratesMin1[]" value="" type="text">'+
	'</div>'+
	'<div class="col-md-1">'+
	'<input id="iratesMax1" class="form-control" name="iratesMax1[]" class="form-control" value="" type="text">'+
	'</div>'+
	'<div class="col-md-2 margin5">'+
	'<input id="iratesSum1" class="form-control" name="iratesSum1[]" class="form-control" value="" type="text">'+
	'</div><div class="dayrange_'+ pricerows +'">'+ range +
	'</div>'+
	'</div>');

document.getElementById('pricerows').value = pricerows;	
   // alert(range);	
}

function adddayrange() {
var rangerows = parseInt(document.getElementById('pricerows').value);
var countranges = parseInt(document.getElementById('currentragerows').value) + 1;
var realvalue = parseInt(document.getElementById('currentragerows').value);
for(var d=1;d<=rangerows;d++)
{

if(d == '1'){
	var addlable = 
	'<div class="col-md-12" style="padding: 0;">'+
	'<input placeholder="Days Range" class="form-control" id="days_rate_range" name="days_rate_range1[]" class="form-control" value="" type="text">'+
	'</div>';
} else {
	var addlable = '';
}

//alert('dayrange_'+d);
jQuery('.dayrange_'+d).append(
		'<div class="col-md-1 rangegroup_'+ countranges +'" style="padding:0;">'+ addlable +
		'<div class="col-md-12" style="padding:0;">'+
		'<input id="days_rate" placeholder="Price" class="form-control" name="days_rate'+d+'[]" class="form-control" value="" type="text">'+
		'</div></div>');		
}
document.getElementById('currentragerows').value = countranges;

}

function removedayrange(){
var countranges = parseInt(document.getElementById('currentragerows').value) - 1;
if(document.getElementById('currentragerows').value == 1){
	alert('Can not delete first day range.');
} else {
$('.rangegroup_'+ countranges).remove();
document.getElementById('currentragerows').value = countranges;
}
	
}

function removemultirate() {
    event.preventDefault();
    var searchIDs = $("#day_basis input:checkbox:checked").map(function(){
      return $(this).val();
    }).get(); // <----
	//var arraysize = searchIDs.length;
	//alert(arraysize);
	//var crntrows = parseInt(document.getElementById('pricerows').value) - 1;
	//document.getElementById('pricerows').value = crntrows - arraysize;

	searchIDs.forEach(function(entry) {
    $('.pricerow_'+entry).remove();
	});
    //console.log(searchIDs);


}
</script>	
<script type="text/javascript" src="assets/js/admin.js"></script>
		<!-- JAVASCRIPT FILES 
		<script type="text/javascript">var plugin_path = 'assets/plugins/';</script>
		<script type="text/javascript" src="assets/plugins/jquery/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="assets/js/app.js"></script>-->

	</body>

</html>