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
		$planId = $_POST['plan_id'];
		// Inserting the Benefits Details
		for($i=0;$i<count($_POST['ibenefitHead']);$i++){
			$bene_head = $_POST['ibenefitHead'][$i];
			$bene_desc = $_POST['ibenefitDesc'][$i];
			$bene_time = time();
			$current_user = $_SESSION['id'];
			$insertBenefit = mysqli_query($db, "INSERT INTO wp_dh_life_plans_benefits(plan_id, benefits_head, benefits_desc,created_on , created_by ) VALUES('$planId','$bene_head', '$bene_desc', '$bene_time' , '$current_user' )");
		}


echo "<script>window.location='life_plans_benefits.php';</script>";
}
else if($_REQUEST['action'] == 'update'){
	$id = $_POST['update_id'];
	$planId = $id;

			$deleteBenefits = mysqli_query($db, "DELETE FROM wp_dh_life_plans_benefits where plan_id='$planId'");
			for($i=0;$i<count($_POST['ibenefitHead']);$i++){

				$bene_head = $_POST['ibenefitHead'][$i];
				$bene_desc = $_POST['ibenefitDesc'][$i];
				$bene_time = time();
				$current_user = $_SESSION['id'];
				$insertBenefit = mysqli_query($db, "INSERT INTO wp_dh_life_plans_benefits(plan_id, benefits_head, benefits_desc,created_on , created_by ) VALUES('$planId','$bene_head', '$bene_desc', '$bene_time' , '$current_user' )");
			}

	
echo "<script>window.location='life_plans_benefits.php';</script>";	
}
?>

<!doctype html>
<html lang="en-US">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Manage Benefits</title>
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
					<h1>Manage Benefits</h1>
					<ol class="breadcrumb">
						<li><a href="plans_benefits.php">Plans Benefits</a></li>
						<li class="active">Manage Benefits</li>
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
	<form action="?action=<?php if($_REQUEST['id']){ echo 'update'; } else { echo 'add'; }?>" method="post" class="web-form" id="itemPlan" novalidate="novalidate">
		<!-- Add Plan Details -->

		<div class="row">

			<div class="panel panel-default col-md-12">
			 <div class="panel-body">

				<div class="row">
				<div class="col-md-12">
					<label><i class="fa fa-building"></i> <strong>Select Plan</strong></label>
						<select autocomplete="on" name="plan_id" id="plan_id" class="form-control select2">
							<option value="">None</option>
									<?php
									$pl_q = mysqli_query($db, "SELECT * FROM `wp_dh_life_plans` ORDER BY `id`");
									while($pl_f = mysqli_fetch_assoc($pl_q)){
									$co_q = mysqli_query($db, "SELECT * FROM `wp_dh_companies` WHERE `comp_id`='".$pl_f['insurance_company']."'");
									$co_f = mysqli_fetch_assoc($co_q);	
									?>
									<option value="<?php echo $pl_f['id'];?>" <?php if($_REQUEST['id'] == $pl_f['id']){?> selected="" <?php } ?>><?php echo $pl_f['id'].' - '.$pl_f['plan_name'];?> (<?php echo $co_f['comp_name'];?>)</option>
									<?php
									}
									?>
							</select>
				</div>
				</div>
				</div>

			</div>

		</div>


		<div class="panel-body">
			
			<div class="clear"></div>

			<div class="row">
			
						<div class="col-md-12">

				<h4 class="item-sub" style="margin: 0;margin-bottom: 20px;margin-top: 5px; color:#c00;"><i class="fa fa-heart"></i> Manage Benefits</h4>

				<div class="original">
<?php
if($_REQUEST['id']){
?>
<div id="appendBenefits">	
<?php $be_q = mysqli_query($db, "SELECT * FROM `wp_dh_life_plans_benefits` WHERE `plan_id`='".$_REQUEST['id']."'");
while($be_f = mysqli_fetch_assoc($be_q)){
?>
<div class="appendBenefits">

					<div class="row" style="margin-top:10px;">
						<div class="col-md-12">
							<input id="ibenefitHead1" name="ibenefitHead[]" class="form-control" value="<?php echo $be_f['benefits_head'];?>" placeholder="Enter Heading of Benefit # 1" type="text">
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<textarea placeholder="Enter benefit Description" class="form-control" value="<?php echo $be_f['benefits_desc'];?>" spellcheck="false" id="ibenefitDesc1" name="ibenefitDesc[]"></textarea>
						</div>
					</div>
</div>					
<?php } ?>
</div>
<?php } else { ?>
					<div class="row">
						<div class="col-md-12">
							<input id="ibenefitHead1" name="ibenefitHead[]" class="form-control" placeholder="Enter Heading of Benefit" type="text">
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<textarea placeholder="Enter benefit Description" class="form-control" spellcheck="false" id="ibenefitDesc1" name="ibenefitDesc[]"></textarea>
						</div>
					</div>
<?php } ?>					
				</div>
<?php if($_REQUEST['id'] == ''){?>
				<div id="appendBenefits"></div>
<?php } ?>
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


			<div class="clear"></div>
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