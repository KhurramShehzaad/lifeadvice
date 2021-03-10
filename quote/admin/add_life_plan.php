<?php
//error_reporting(E_ALL);
session_start();
include 'includes/db_connect.php';
//$con is BMS database
//$db1 is site database
if (isset($_SESSION['user'])) {
} else {
echo "<script>
window.location='index.php?session=out';
</script>";
}
if($_REQUEST['action'] == 'add'){
	$smoke = $_POST['smoke'];
	$pname = $_POST['iplan'];
	$product = $_POST['ipname'];
	$comp = $_POST['icname'];
	$dlink = $_POST['directlink'];
	$current_user = $_SESSION['id'];
	$ratebase = $_POST['irateCalculation'];

	$insertPlan = mysqli_query($db, "INSERT INTO `wp_dh_life_plans`(`plan_name`, `product`, `insurance_company`, `rate_base`, `smoke`, `directlink`, `status`) VALUES ('$pname','$product','$comp','$ratebase','$smoke','$dlink','1')");

		$planId = $db->insert_id;
		if($planId != 0){
		for($i=0;$i<count($_POST['ibenefitHead']);$i++){
			$bene_head = $_POST['ibenefitHead'][$i];
			$bene_desc = $_POST['ibenefitDesc'][$i];
			$bene_time = time();
			$current_user = $_SESSION['id'];
			$insertBenefit = mysqli_query($db, "INSERT INTO wp_dh_life_plans_benefits(plan_id, benefits_head, benefits_desc,created_on , created_by ) VALUES('$planId','$bene_head', '$bene_desc', '$bene_time' , '$current_user' )");
		}
		
		// Inserting the Rates
		for($i=0;$i<count($_POST['iratesMin']);$i++){
			$irateMin = $_POST['iratesMin'][$i];
			$irateMax = $_POST['iratesMax'][$i];
			$irateSum = $_POST['iratesSum'][$i];
			$irateRate = $_POST['iratesRate'][$i];
			$iratesTime = $_POST['iratesTime'][$i];
			$iratesSex = $_POST['iratesSex'][$i];
			$cuser = $_SESSION['id'];
			$time = time();
			$insertRates = mysqli_query($db, "INSERT INTO wp_dh_life_plans_rates(`plan_id`, `minage`, `maxage`, `sum_insured`, `duration`, `sex`, `rate`, `ratebase`) VALUES('$planId','$irateMin','$irateMax','$irateSum','$iratesTime','$iratesSex','$irateRate','$ratebase')");
		}
		}
echo "<script>window.location='life_plans.php';</script>";
}
else if($_REQUEST['action'] == 'update'){
	$id = $_POST['update_id'];
	$smoke = $_POST['smoke'];
	$pname = $_POST['iplan'];
	$product = $_POST['ipname'];
	$comp = $_POST['icname'];
	$dlink = $_POST['directlink'];
	$current_user = $_SESSION['id'];
	$ratebase = $_POST['irateCalculation'];
	$last_update = date("Y-m-d H:i:s");

	$insertPlan = "UPDATE `wp_dh_life_plans` SET `plan_name`='$pname',`product`='$product',`insurance_company`='$comp',`rate_base`='$ratebase',`smoke`='$smoke',`directlink`='$dlink' WHERE id='$id'";

	$planId = $id;

		if(mysqli_query($db, $insertPlan)){
			
			$deleteBenefits = mysqli_query($db, "DELETE FROM wp_dh_life_plans_benefits where plan_id='$planId'");
			for($i=0;$i<count($_POST['ibenefitHead']);$i++){
				$bene_head = $_POST['ibenefitHead'][$i];
				$bene_desc = $_POST['ibenefitDesc'][$i];
				$bene_time = time();
				$current_user = $_SESSION['id'];
				$insertBenefit = mysqli_query($db, "INSERT INTO wp_dh_life_plans_benefits(plan_id, benefits_head, benefits_desc,created_on , created_by ) VALUES('$planId','$bene_head', '$bene_desc', '$bene_time' , '$current_user' )");
			}
			
			// Inserting the Rates
			$deleteRates=mysqli_query($db, "DELETE FROM `wp_dh_life_plans_rates` WHERE plan_id='$planId'");	
			for($i=0;$i<count($_POST['iratesMin']);$i++){
				$irateMin = $_POST['iratesMin'][$i];
				$irateMax = $_POST['iratesMax'][$i];
				$irateSum = $_POST['iratesSum'][$i];
				$iratesTime = $_POST['iratesTime'][$i];
				$iratesSex = $_POST['iratesSex'][$i];
				$irateRate = $_POST['iratesRate'][$i];
				$insertRates = mysqli_query($db, "INSERT INTO wp_dh_life_plans_rates(`plan_id`, `minage`, `maxage`, `sum_insured`, `duration`, `sex`, `rate`, `ratebase`) VALUES('$planId','$irateMin','$irateMax','$irateSum','$iratesTime','$iratesSex','$irateRate','$ratebase')");
			}
		}
		
echo "<script>window.location='life_plans.php';</script>";	
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
</style>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <style>
  #sortable { list-style-type: none; margin: 0; padding: 0; }
  #sortable li { margin: 0 5px 5px 5px; padding: 5px; }
  .ui-state-highlight { height: 1.5em; line-height: 1.2em; }
  </style>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>

$( function() {
   var $sortable =   $( "#sortable, #sortable2" ).sortable({
	  connectWith: ".connectedSortable",
	update: function(event, ui) {
			var counter = 1;
			$('li', $sortable).each(function() {
				$(this).attr('position', counter);
				 $(this).find("input[name='sort[]']").val(counter);
				counter++;
			});
	}
	}).disableSelection();
  } );
  </script>
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
					<h1>Manage Life Plan</h1>
					<ol class="breadcrumb">
						<li><a href="life_plans.php">Plans</a></li>
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
$sql = mysqli_query($db, "SELECT * FROM `wp_dh_life_plans` WHERE `id`='".$_REQUEST['id']."'");
$fetch = mysqli_fetch_assoc($sql);
$srno++;	
$plan_id = $fetch['id'];
$plan_name = $fetch['plan_name'];
$product = $fetch['product'];
$insurance_company = $fetch['insurance_company'];
$rate_base = $fetch['rate_base'];
$smoke_rate = $fetch['smoke_rate'];
$smoke = $fetch['smoke'];
$directlink = $fetch['directlink'];
$status = $fetch['status'];

$pro_q = mysqli_query($db, "SELECT * FROM `wp_dh_products` WHERE `pro_id`='$product'");
$pro_f = mysqli_fetch_assoc($pro_q);

$co_q = mysqli_query($db, "SELECT * FROM `wp_dh_companies` WHERE `comp_id`='$insurance_company'");
$co_f = mysqli_fetch_assoc($co_q);		
?>
	<form action="?action=<?php if($_REQUEST['id']){ echo 'update'; } else { echo 'add'; }?>" method="post" class="web-form" id="itemPlan" novalidate="novalidate">
		<!-- Add Plan Details -->

		<div class="row">

			<div class="panel panel-default col-md-12">
			 <div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<h4 class="text-primary" style="margin:0;"><strong><i class="fa fa-umbrella"></i> Enter Plan Details</strong></h4>
					</div>
				</div>
				<div class="row">
				<div class="col-md-4">
					<label><i class="fa fa-leaf"></i> <strong class="text-danger">Select Product</strong></label>
						<select autocomplete="on" name="ipname" id="ipname" class="form-control">
									<?php
									$pr_q = mysqli_query($db, "SELECT * FROM `wp_dh_products` WHERE `pro_life`='1'");
									while($pr_f = mysqli_fetch_assoc($pr_q)){
									?>
									<option value="<?php echo $pr_f['pro_id'];?>" <?php if($product == $pr_f['pro_id']){?> selected="" <?php } ?>><?php echo $pr_f['pro_name'];?></option>
									<?php
									}
									?>

							</select>

				</div>
				<div class="col-md-4">
					<label><strong>Name of the Plan</strong></label>
					<input id="iplan" name="iplan" placeholder="Enter Plan Name" class="form-control" value="<?php echo $plan_name;?>" type="text">
				</div>
				<div class="col-md-4">
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
				
				<div class="row">
				<div class="col-md-12">
				<h4 class="item-sub" style="margin: 0;"><i class="fa fa-gear"></i> Plan Settings</h4>
				</div>
				</div>
				<div class="row">
				<div class="col-md-3">
				<div class="row">
				<div class="col-md-12">
				<label><strong>Select Rates Type</strong></label>
				</div>
				<div class="col-md-12">
				<!-- radio -->
				<label class="radio">
					<input type="radio" value="1" <?php if($rate_base == '1'){?> checked="" <?php } ?> name="irateCalculation" id="daily" required="">
					<i></i> Monthly
				</label>
				<label class="radio">
					<input type="radio" value="2" <?php if($rate_base == '2'){?> checked="" <?php } ?> name="irateCalculation" id="daily" required="">
					<i></i> Yearly
				</label>
				</div>
				</div>
				</div>
				<div class="col-md-9">
				<div class="row">
				<div class="col-md-12">
					<label><strong>Smoker Plan?</strong></label>					
				</div>
				<div class="col-md-12" id="stop_usa">
					<label class="radio">
						<input type="radio" value="0" <?php if($smoke == '0'){?> checked="" <?php } ?> name="smoke" id="smoke" required="">
						<i></i> No
					</label>
					<label class="radio">
						<input type="radio" value="1" <?php if($smoke == '1'){?> checked="" <?php } ?> name="smoke" id="smoke" required="">
						<i></i> Yes
					</label>
				</div>
				</div>
				</div>
				
				</div>
				
				</div>

			</div>


		</div>


<div class="panel-body">
			
					<!-- Rate Section for all other products except single -->

	<div class="daily_monthly" id="daily_monthly" <?php if($rate_base=='0' || $rate_base=='1' || $rate_base=='2') { echo 'display:block'; } else {echo 'display:none';}?>>

		<div class="row" id="ratesItem">

			<div class="col-md-12">

				<h4 class="item-sub" style="margin: 0;margin-bottom: 20px;margin-top: 5px; color:#c00;"><i class="fa fa-shopping-cart"></i> Manage Plan Prices</h4>
				<?php
				if($_REQUEST['id']){
				$counter=0;

				$rats_q = mysqli_query($db, "SELECT * FROM `wp_dh_life_plans_rates` WHERE `plan_id`='".$_REQUEST['id']."'");
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

						<div class="col-md-1">
							<label><strong>Min Age</strong></label>
							<input id="iratesMin1" name="iratesMin[]" class="form-control" value="<?php echo $rats_f['minage'];?>" type="text" class="min_1">
						</div>

						<div class="col-md-1">
							<label><strong>Max Age</strong></label>
							<input id="iratesMax1" name="iratesMax[]" class="form-control" value="<?php echo $rats_f['maxage'];?>" type="text" class="max_1">
						</div>

						<div class="col-md-2">
							<label class="wrapup"><strong>Benefit Amount</strong></label>
							<input id="iratesSum1" name="iratesSum[]" class="form-control" value="<?php echo $rats_f['sum_insured'];?>" type="text" class="sum_1">
						</div>
						<div class="col-md-1">
							<label class="wrapup"><strong>Duration</strong></label>
							<input id="iratesTime1" name="iratesTime[]" class="form-control" value="<?php echo $rats_f['duration'];?>" type="text">
						</div>
						<div class="col-md-2">
							<label class="wrapup"><strong>Sex</strong></label>
							<select id="iratesSex1" name="iratesSex[]" class="form-control">
							<option value="m" <?php if($rats_f['sex'] == 'm'){?> selected="" <?php } ?>>Male</option>
							<option value="f" <?php if($rats_f['sex'] == 'f'){?> selected="" <?php } ?>>Female</option>
							</select>
						</div>
						<div class="col-md-1">
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
							<div class="col-md-1">
								<div class="input">
									<input type="text" id="iratesMin'+countRates+'" name="iratesMin[]" class="min_<?php echo date('his').$rand;?> form-control" value="<?php echo $rats_f['minage'];?>">
								</div>
							</div>
							<div class="col-md-1">
								<div class="input">
									<input type="text" id="iratesMax'+countRates+'" name="iratesMax[]" class="max_<?php echo date('his').$rand;?> form-control" value="<?php echo $rats_f['maxage'];?>">
								</div>
							</div>
							<div class="col-md-2">
								<div class="input">
									<input type="text" id="iratesSum'+countRates+'" name="iratesSum[]" class="sum_<?php echo date('his').$rand;?> form-control" value="<?php echo $rats_f['sum_insured'];?>">
								</div>
							</div>
							<div class="col-md-1">
								<input id="iratesTime1" name="iratesTime[]" class="duration_<?php echo date('his').$rand;?> form-control" value="<?php echo $rats_f['duration'];?>" type="text">
							</div>
							<div class="col-md-2">
								<select id="iratesSex1" name="iratesSex[]" class="form-control">
								<option value="m" <?php if($rats_f['sex'] == 'm'){?> selected="" <?php } ?>>Male</option>
								<option value="f" <?php if($rats_f['sex'] == 'f'){?> selected="" <?php } ?>>Female</option>
								</select>
							</div>
							<div class="col-md-1">
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
						<div class="col-md-1">
							<label><strong>Min Age</strong></label>
							<input id="iratesMin1" name="iratesMin[]" class="form-control" type="text" class="min_1">
						</div>
						<div class="col-md-1">
							<label><strong>Max Age</strong></label>
							<input id="iratesMax1" name="iratesMax[]" class="form-control" type="text" class="max_1">
						</div>
						<div class="col-md-2">
							<label class="wrapup"><strong>Benefit Amount</strong></label>
							<input id="iratesSum1" name="iratesSum[]" class="form-control" type="text" class="sum_1">
						</div>
						<div class="col-md-1">
							<label class="wrapup"><strong>Duration</strong></label>
							<input id="iratesTime1" name="iratesTime[]" class="form-control" type="text">
						</div>
						<div class="col-md-2">
							<label class="wrapup"><strong>Sex</strong></label>
							<select id="iratesSex1" name="iratesSex[]" class="form-control">
							<option value="m">Male</option>
							<option value="f">Female</option>
							</select>
						</div>
						<div class="col-md-1">
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
						<a href="javascript:void(0)" class="btn btn-default btn-sm addlifeRates addnewItem"><i class="fa fa-plus"></i> Add Item</a>
						<a href="javascript:void(0)" class="btn btn-warning btn-sm copylifeRates addnewItem"><i class="fa fa-copy"></i> Copy Items</a>
						<a href="javascript:void(0)" class="btn btn-danger btn-sm removelifeRates addnewItem"><i class="fa fa-trash"></i> Remove Items</a>
					</div>

				</div>

				<hr>

			</div>

			</div>


	</div>

<div class="clear"></div>

			<div class="row">
			<div class="col-md-12">

				<h4 class="item-sub" style="margin: 0;margin-bottom: 20px;margin-top: 5px; color:#c00;"><i class="fa fa-heart"></i> Manage Benefits</h4>

				<div class="original">
<?php
if($_REQUEST['id']){
$be_q = mysqli_query($db, "SELECT * FROM `wp_dh_life_plans_benefits` WHERE `plan_id`='".$_REQUEST['id']."'");
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
		
	</div>

			<div class="clear"></div>

			<div class="row">
				<div class="col-md-6"> <br/>
					<button type="submit" name="submit" class="btn btn-success submit-btn addnewItem"><i class="fa fa-save"></i> Submit Changes</button>
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
</script>	
<script type="text/javascript" src="assets/js/admin.js"></script>
		<!-- JAVASCRIPT FILES 
		<script type="text/javascript">var plugin_path = 'assets/plugins/';</script>
		<script type="text/javascript" src="assets/plugins/jquery/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="assets/js/app.js"></script>-->

	</body>

</html>