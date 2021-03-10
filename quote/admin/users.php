<?php

error_reporting(E_ALL);

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

?>

<!doctype html>

<html lang="en-US">

	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Users</title>
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
					<div id="panel-1" class="panel panel-default">
						<div class="panel-heading">
							<span class="title elipsis">
								<strong>MANAGE USER ACCOUNTS</strong> <!-- panel title -->
							</span>

							<!-- right options -->
							<ul class="options pull-right list-inline">
								<li><a href="#" class="opt panel_colapse" data-toggle="tooltip" title="Colapse" data-placement="bottom"></a></li>
								<li><a href="#" class="opt panel_fullscreen hidden-xs" data-toggle="tooltip" title="Fullscreen" data-placement="bottom"><i class="fa fa-expand"></i></a></li>

						</ul>
							<!-- /right options -->

						</div>

						<!-- panel content -->
						<div class="panel-body">
<input type="button" onClick="window.location='manage_user.php'" class="btn btn-success" value="Add New User">
<hr />
							<table class="table table-striped table-bordered table-hover" id="datatable_sample">
								<thead>
									<tr>
										<th>Logo</th>
										<th>Name</th>
										<th>Parent Name</th>
										<th>Email</th>
										<th>Pay Commission</th>
										<th>User Type</th>
										<th>Affiliate Code/URL</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if($sess_user_type == 'admin'){
									$inquery = '';	
									}
									else if($sess_user_type == 'broker'){
									$inquery = "WHERE `parent_id`='".$_SESSION['id']."'";
									//The below query is if want to show downline users of the downline users
									//$inquery = "WHERE `id` IN (SELECT `id` FROM `users` WHERE `parent_id`='".$_SESSION['portal_id']."' OR `parent_id` IN (SELECT `id` AS 'curret_id' FROM `users` WHERE `parent_id`='".$_SESSION['portal_id']."' OR `parent_id` IN (SELECT `id` FROM `users` WHERE `parent_id`='curret_id')))";	
									}
									$de_q = mysqli_query($db, "SELECT * FROM `users` $inquery");
									while($de_f = mysqli_fetch_assoc($de_q)){

									$p_q = mysqli_query($db, "SELECT * FROM `users` WHERE `id`='".$de_f['parent_id']."'");
									$p_f = mysqli_fetch_assoc($p_q);
									$p_fname = $p_f['fname'];
									$p_lname = $p_f['lname'];
									?>
									<tr class="odd gradeX">
										<td>
											<?php if($de_f['logo'] != ''){?><img src="logos/<?php echo $de_f['logo'];?>" width="40"><?php } else { ?><i class="fa fa-leaf fa-lg"></i><?php } ?>
										</td>
										<td><a href="user_profile.php?id=<?php echo $de_f['id'];?>"><?php if($de_f['mg_capability'] == '1'){?><i class=" fa-user-secret "></i><?php } else {?><i class="fa fa-user"></i><?php }?> <?php echo $de_f['fname'].' '.$de_f['lname'];?></a></td>
										<td><?php echo $p_fname.' '.$p_lname; if($p_fname == ''){?>N/A<?php } ?></td>
										<td><?php echo $de_f['email'];?></td>
										<td><strong><?php if($de_f['pay_commission'] == 'yes'){?><i class="fa fa-check text-success fa-lg"></i> <?php } else { ?><i class="fa fa-close text-danger fa-lg"></i> <?php } echo ucwords(strtolower($de_f['pay_commission']));?></strong></td>
										<td><?php echo ucwords(strtolower($de_f['user_type']));?></td>
										<td><?php if($de_f['user_type'] == 'agent'){?><strong><i class="fa fa-globe"></i> <?php if($de_f['unique_code'] == '0'){?><a href="url.php?id=<?php echo $de_f['id'];?>">Assign Code</a> <?php } else { ?><a href="https://lifeadvice.ca/visitor-insurance/?<?php echo $de_f['user_type'].'='.$de_f['unique_code'];?>" target="_blank"><?php echo $de_f['unique_code'];?> <i class="fa fa-external-link"></i></a><?php } ?></strong><?php } else  if($de_f['user_type'] == 'broker'){ echo $de_f['unique_code']; } else { echo "N/A"; }?></td>
										<td><span class="label arrowed-in arrowed-in-right label-<?php if($de_f['status'] == 'active'){ echo 'success'; } else if($de_f['status'] == 'pending'){ echo 'info'; } else { echo 'danger'; }?>"><?php echo ucwords(strtolower($de_f['status']));?></span></td>
                                        <td>
												<a href="user_profile.php?id=<?php echo $de_f['id'];?>" class="btn btn-default btn-xs"><i class="fa fa-eye white"></i> View </a>
												<a href="manage_user.php?id=<?php echo $de_f['id'];?>" class="btn btn-default btn-xs"><i class="fa fa-edit white"></i> Edit </a>
												<a href="#" onclick="if(confirm('Do you really want to delete it?')) window.location='users.php?action=del&id=<?php echo $de_f['id'];?>';" class="btn btn-default btn-xs"><i class="fa fa-trash-o white"></i> Delete </a>
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