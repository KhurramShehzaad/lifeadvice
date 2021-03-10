<?php
error_reporting(E_ALL);
session_start();
include 'includes/db_connect.php';
if (isset($_SESSION['user'])) {
} else {
echo "<script>
window.location='index.php?session=out';
</script>";
}

?>
<!doctype html>
<html lang="en-US">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Sales</title>
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
					<h1>Sales</h1>
					<ol class="breadcrumb">
						<li><a href="user_docs.php">Sales</a></li>
						<li class="active">Sales</li>
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
								<strong>Sales</strong> <!-- panel title -->
							</span>
							</div>
						</div>
						<!-- panel content -->
						<div class="panel-body">

							                                <table class="table table-striped table-bordered table-hover" id="datatable_sample">
															<thead>
																<tr>
																	<th><strong>Purchase Date</strong></th>
																	<th><strong>Policy Number</strong></th>
																	<th><strong>Policy Title</strong></th>
																	<th><strong>Product</strong></th>
																	<th><strong>Client</strong></th>
																	<th><strong>Effective/Expiry</strong></th>
																	<th><strong>Status</strong></th>
																</tr>
															</thead>
                                                            <tbody>
															<?php 
												if($sess_user_type == 'admin'){
												$inquery = '';	
												}
												else if($sess_user_type == 'broker'){
												$inquery = " WHERE `agent` IN (select  `unique_code`
from    (select * from `users`
         order by parent_id, id) products_sorted,
        (select @pv := ".$_SESSION['portal_id'].") initialisation
where   find_in_set(parent_id, @pv)
and     length(@pv := concat(@pv, ',', id)))
";	
												}
												else if($sess_user_type == 'agent'){
												$inquery = "WHERE `agent`='$sess_unique_code'";	
												}
												$sales_q = mysqli_query($db, "SELECT * FROM `sales` $inquery ORDER BY `sales`.`purchase_date` DESC");
												while($sales_f = mysqli_fetch_assoc($sales_q )){
												$today = strtotime(date('Y-m-d'));
												$st_date = strtotime($sales_f['start_date']);
												$policy_status = $sales_f['policy_status'];
												//checking policy status
												if($today >= $st_date && $policy_status == 'paid'){
												//echo '>';
												$status = 'active';
												$class = 'success';	
												} else {
												if($policy_status == 'paid'){
												$status = 'paid';
												$class = 'info';	
												}	
												}
												
												if($sales_f['product'] == '1'){
													$policytype = 'SVI';
												} else if($sales_f['product'] == '2'){
													$policytype = 'VTC';
												} else if($sales_f['product'] == '3'){
													$policytype = 'SI';
												} else if($sales_f['product'] == '4'){
													$policytype = 'IFC';
												} else if($sales_f['product'] == '5'){
													$policytype = 'ST';
												} else if($sales_f['product'] == '6'){
													$policytype = 'MT';
												} else if($sales_f['product'] == '7'){
													$policytype = 'AI';
												} else if($sales_f['product'] == '8'){
													$policytype = 'TII';
												} else if($sales_f['product'] == '9'){
													$policytype = 'BC';
												}
												
												$prodetails = mysqli_query($db, "SELECT * FROM `wp_dh_products` WHERE `pro_id`='".$sales_f['product']."'");
												$prodetails_f = mysqli_fetch_assoc($prodetails);
												$prosupervisa = $prodetails_f['pro_supervisa'];
												$product_name = $prodetails_f['pro_name'];

												
												$policy_number_temp = 10000000 + $sales_f['sales_id'];
												$policy_number = $policytype.$policy_number_temp;

												if($policy_status == 'cancel'){
												$status = 'cancelled';
												$class = 'danger';
												}
												else if($policy_status == 'pending'){
												$status = 'pending';
												$class = '';	
												}else if($policy_status == 'return'){
												$status = 'Early Return';
												$class = 'warning';
												}	
												?>
                                                            <tr>
                                                <td><?php echo $sales_f['purchase_date'];?></td>
                                                <td><a href="sales_view.php?id=<?php echo $sales_f['sales_id'];?>" style="font-weight:bold; font-size:16px;" target="_blank"><?php echo $policy_number;?></a></td>
                                                <td><?php echo $sales_f['policy_title'];?></td>
												<td><?php echo $product_name;?></td>
                                                <td><?php echo ucwords(strtolower($sales_f['fname'].' '.$sales_f['lname']));?><br/><?php echo $sales_f['email'];?></td>
                                                <td><?php echo $sales_f['start_date'];?>/<?php echo $sales_f['end_date'];?></td>
                                               <td style="border-bottom: 1px solid #CCC;" class="<?php echo $class;?>"><?php echo ucwords(strtolower($status));?></td>
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
								"orderable": true
							}, {
								"orderable": true
							}, {
								"orderable": false
							}, {
								"orderable": false
							}, {
								"orderable": false
							}, {
								"orderable": false
							}, {
								"orderable": true
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