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


//Restriction access to this page for agent and brokers with value no capibility
if($sess_user_type !='admin'){
if($sess_mg_capability != '1'){
echo "<script>window.location='home.php';</script>";
}
}
?>
<!doctype html>
<html lang="en-US">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Expired Documents Report</title>
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
					<h1>Expired Documents Report</h1>
					<ol class="breadcrumb">
						<li><a href="user_docs.php">Documents</a></li>
						<li class="active">Expired Documents Report</li>
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
								<strong>Expired Documents Report</strong> <!-- panel title -->
							</span>
							</div>
						</div>
						<!-- panel content -->
						<div class="panel-body">
						<h4 class="red">
																<span class="middle">Licensing and/or E&O Documents</span><br/>
                                                                <small><i class="fa fa-info-circle"></i> Only approved but expired documents will be shown into this report.</small>
															</h4>
							                                <table class="table table-striped table-bordered table-hover" id="datatable_sample">
															<thead>
															<tr>
															<th class="center">SrNo</th>
															<th>Uploaded By</th>
															<th>Document Type/Name</th>
															<th>Expired On</th>
															<th>Province</th>
															<th>Current Status</th>
															</tr>
															</thead>
                                                            <tbody>
															<?php 
                                                            $sr = 0;
															$doc_type = $_POST['doc_type'];
															$today = date('Y-m-d');														
															if($sess_user_type == 'admin'){
															$insql = "";
															}
															else {
															$insql = "`user_id` IN (SELECT `id` FROM `users` WHERE `parent_id`='".$_SESSION['portal_id']."') AND";	
															}
                                                            $file_q = mysqli_query($db, "SELECT * FROM `user_license` WHERE $insql `expiry_date`<='".$today."' AND `status`='1'");
                                                            while($file_f = mysqli_fetch_assoc($file_q)){
                                                            $sr++;
															
															if($file_f['status'] == '1'){
															$label = 'label-success';
															$status_txt = 'Approved';
															}
															else if($file_f['status'] == '0'){
															$label = 'label-info';	
															$status_txt = 'Pending';
															}
															else if($file_f['status'] == '2'){
															$label = 'label-warning';
															$status_txt = 'Rejected';	
															}
															
															$license_type = $file_f['license_type'];
															if($license_type == 'eo'){
															$license_type = 'Error`s and Omission (E&O)';
															}
															//uploaded by name
															$u_q = mysqli_query($db, "SELECT * FROM `users` WHERE `id`='".$file_f['user_id']."'");
                                                            $u_f = mysqli_fetch_assoc($u_q);
															$uploadedby = $u_f['fname'].' '.$u_f['lname'];
															
															//approved by name
															$a_q = mysqli_query($db, "SELECT * FROM `users` WHERE `id`='".$file_f['approved_by']."'");
                                                            $a_f = mysqli_fetch_assoc($a_q);
															$approvedby = $a_f['fname'].' '.$a_f['lname'];
                                                            ?>
                                                            <tr>
                                                                <td class="center"><?php echo $sr;?></td>
                                                                <td><a href="user_profile.php?id=<?php echo $file_f['user_id'];?>"><?php echo $uploadedby;?></a><br/><small><i class="fa fa-clock-o"></i> <?php echo $file_f['dated'];?></small></td>
                                                                <td><a href="uploads/<?php echo $file_f['license'];?>" target="_blank"><i class="fa fa-file"></i> <?php echo ucwords(strtolower($license_type));?></a></td>
                                                                <td><?php echo $file_f['expiry_date'];?></td>
                                                                <td><?php echo $file_f['province'];?></td>
                                                                <td><span class="label label-warning arrowed-in arrowed-in-right">Expired</span></td>
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
								"orderable": false
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