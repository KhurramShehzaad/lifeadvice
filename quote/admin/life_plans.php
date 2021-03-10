<?php
//error_reporting(E_ALL);
session_start();
include 'includes/db_connect.php';
if (isset($_SESSION['user'])) {
} else {
echo "<script>
window.location='index.php?session=out';
</script>";
}
if($_REQUEST['action'] == 'del'){
$del_q = mysqli_query($db, "DELETE FROM `wp_dh_life_plans` WHERE `id`='".$_REQUEST['id']."'");
echo "<script>window.location='life_plans.php';</script>";
}
?>
<!doctype html>
<html lang="en-US">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Life Plans</title>
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
					<h1>Manage Life Plans</h1>
					<ol class="breadcrumb">
						<li><a href="life_plans.php">Life Plans</a></li>
						<li class="active">Manage Life Plans</li>
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
					<div id="panel-1" class="panel panel-default">
						<div class="panel-heading">
							<div class="col-md-6">
							<span class="title elipsis">
								<strong><i class="fa fa-umbrella"></i> MANAGE LIFE INSURANCE PLANS</strong> <!-- panel title -->
							</span>
							</div>
							<div class="col-md-6">
<button type="button" onClick="window.location='add_life_plan.php?action=addnew'" class="btn btn-primary pull-right" style="margin-top: -9px;"><i class="fa fa-plus"></i> Add New Plan</button>
							</div>	
						</div>
						<!-- panel content -->
						<div class="panel-body">
							<table class="table table-striped table-bordered table-hover" id="datatable_sample">
							<thead>
									<tr>
										<th>ID</th>
										<th>Plan Name</th>
										<th>Product Name</th>
                                        <th>Company</th>
                                        <th>Last Updated By</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
                                <?php

$srno = 0;
$sql = mysqli_query($db, "SELECT * FROM `wp_dh_life_plans`");
while($fetch = mysqli_fetch_assoc($sql)){
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


									<tr class="odd gradeX">
										<td style="text-align:center;"><?php echo $plan_id;?></td>
										<td><i class="fa fa-umbrella"></i> <?php echo $plan_name;?></td>
										<td><?php echo $pro_f['pro_name'];?></td>
                                        <td><img src="uploads/<?php echo $co_f['comp_logo'];?>" width="120"/></td>
										<td>Administrator</td>
                                        <td>
										<a href="add_life_plan.php?id=<?php echo $plan_id;?>" class="btn btn-default btn-xs"><i class="fa fa-edit white"></i> Edit </a>
										<a href="?action=del&id=<?php echo $plan_id;?>" class="btn btn-default btn-xs"><i class="fa fa-times white"></i> Delete </a>
										</td>
									</tr>
                               <?php } ?>     
								</tbody>
							</table>

						</div>
						<!-- /panel content -->
						<!-- panel footer -->
						<div class="panel-footer">
						</div>
						<!-- /panel footer -->
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
		</script>
	</body>
</html>