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

if($_REQUEST['action'] == 'change_done'){
$newstatus = $_REQUEST['status'];
$docid = $_REQUEST['id'];
$ubid = $_REQUEST['ub'];

$doc_q = mysqli_query($db, "UPDATE `user_license` SET `status`='$newstatus',`approved_by`='".$_SESSION['portal_id']."' WHERE `id`='$docid'");

$ub_q = mysqli_query($db, "SELECT * FROM `users` WHERE `id`='$ubid'");
$ub_f = mysqli_fetch_assoc($ub_q);
$ub_name = $ub_f['fname'].' '.$ub_f['lname'];
$ub_email = $ub_f['email'];

$notification = 'Document status has been updated';
$notify_q = mysqli_query($db, "INSERT INTO `notifications`(`notification`, `user_id`) VALUES ('$notification', '$ubid')");

if($newstatus == '2'){
$reason = '<h4>Reason of Rejecton</h4>'.$_POST['reason'].'<br/><br/><br/>';	
}

$to = $ub_email;
$subject = 'Document Status Notification - LifeAdvice.ca';

$headers = "From: " . strip_tags('info@LifeAdvice.ca') . "\r\n";
$headers .= "Reply-To: ". strip_tags('info@LifeAdvice.ca') . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$body = '
<html>
<body style="width: 700px; border: 1px solid rgb(204, 204, 204); margin: 0px auto;">
<table width="700" cellspacing="0" cellpadding="2" border="0" style="border-top: 10px solid #c00; font-family: arial; font-size: 13px;">
  <tbody>
  <tr>
    <td style="background: rgb(255, 255, 255) none repeat scroll 0% 0%; border-bottom: 1px solid rgb(204, 204, 204);"><img src="https://lifeadvice.ca/wp-content/uploads/2018/03/Life-Advice-Insurance-Inc-2.png" /></td>
  </tr>
  <tr>
  	<td style="padding: 10px">
    Dear '.$ub_name.',<br>
    <br>
    You have received this notification because one of your document status has been updated. Please login to your customer portal for more details.<br>
    <h4><a href="https://LifeAdvice.ca/portal" target="_blank"><strong>Login to Customer Portal</strong></a></h4>
    <br>
    <br>
	'.$reason.'<br/>
    Best Reards,<br>
    LifeAdvice.ca
    </td>
  </tr>
</tbody>
</table>
</body>
</html>
';

mail($to, $subject, $body, $headers);

echo "<script>window.location='user_docs.php'</script>";
	
	
}
?>
<!doctype html>
<html lang="en-US">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Manage Documents</title>
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
					<h1>Manage Documents</h1>
					<ol class="breadcrumb">
						<li><a href="user_docs.php">Documents</a></li>
						<li class="active">Manage Documents</li>
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
								<strong><i class="fa fa-umbrella"></i> Licensing and/or E&O Documents</strong> <!-- panel title -->
							</span>
							</div>
						</div>
						<!-- panel content -->
						<div class="panel-body">
							<table class="table table-striped table-bordered table-hover" id="datatable_sample">
							<thead>
									<tr>
										<th align="center">SrNo</th>
										<th>Uploaded By</th>
										<th>Parent Broker</th>
										<th>Document Type/Name</th>
										<th>Vaid From/Till</th>
										<th>Province</th>
										<th>Current Status</th>
										<th>Change Status</th>
									</tr>
								</thead>
								<tbody>
															<?php 
                                                            $sr = 0;
															if($sess_user_type == 'admin'){
															$insql = "";
															}
															else {
															$insql = "WHERE `user_id` IN (SELECT `id` FROM `users` WHERE `parent_id`='".$_SESSION['portal_id']."')";	
															}
                                                            $file_q = mysqli_query($db, "SELECT * FROM `user_license` $insql ORDER BY `user_license`.`id` DESC");
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
															//approved by name
															$u_q = mysqli_query($db, "SELECT * FROM `users` WHERE `id`='".$file_f['user_id']."'");
                                                            $u_f = mysqli_fetch_assoc($u_q);
															$uploadedby = $u_f['fname'].' '.$u_f['lname'];
															$parent_id = $u_f['parent_id'];
															$uploader_type = $u_f['user_type'];
															
															if($parent_id == '0'){
															$parent_name = 'N/A';	
															} else {
															$p_q = mysqli_query($db, "SELECT * FROM `users` WHERE `id`='$parent_id'");
                                                            $p_f = mysqli_fetch_assoc($p_q);
															$parent_name = $p_f['fname'].' '.$p_f['lname'];
															}

															if($uploader_type == 'agent' && $u_f['user_level'] == '1'){
															$uploader_type == 'AB Agent';
															} else 
															if($uploader_type =='broker' && $u_f['user_level'] == '1'){
															$uploader_type = 'AB Broker';
															} else
															if($uploader_type == 'broker' && $u_f['user_level'] == '2'){
															$uploader_type = 'AB Downline Broker';
															} else
															if($uploader_type == 'agent' && $u_f['user_level'] == '2'){
															$uploader_type = 'AB Downline Agent';
															}

                                                            ?>

									<tr class="odd gradeX">
										<td class="center"><?php echo $sr;?></td>
										<td><a href="user_profile.php?id=<?php echo $file_f['user_id'];?>"><i class="fa fa-user"></i> <?php echo $uploadedby;?> - <small class="text-danger"><?php echo $uploader_type; ?></small></a><br/><small><i class="fa fa-clock-o"></i> <?php echo $file_f['dated'];?></small></td>
										<td><?php echo $parent_name;?></td>
										<td><a href="uploads/<?php echo str_replace(' ', '', $file_f['license']);?>" target="_blank"><i class="fa fa-file"></i> <?php echo ucwords(strtolower($license_type));?></a></td>
										<td><?php echo $file_f['eff_date'].' - '.$file_f['expiry_date'];?></td>
										<td><?php echo $file_f['province'];?></td>
										<td><span class="label <?php echo $label;?> arrowed-in arrowed-in-right"><?php echo $status_txt;?></span></td>
                                        <td>
										<ul class="nav">
											<li class="dropdown">
												<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-gear"></i> Change Status <span class="caret"></span></a>
												<ul class="dropdown-menu" role="menu">
													<li>
														<a href="?action=change_done&id=<?php echo $file_f['id'];?>&status=1&ub=<?php echo $file_f['user_id'];?>"><i class="fa fa-check"></i> Approve</a>
													</li>
													<li>
														<a href="?action=change&id=<?php echo $file_f['id'];?>&status=2&ub=<?php echo $file_f['user_id'];?>"><i class="fa fa-times"></i> Reject</a>
													</li>
												</ul>
											</li>
										</ul>
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
							}, {
								"orderable": false
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