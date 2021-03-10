<?php
include 'includes/db_connect.php';

if($_REQUEST['action'] == 'gc'){
$dg_q = mysqli_query($db, "DELETE FROM `settings` WHERE `user_id`='".$_SESSION['portal_id']."'");

$gc_q = mysqli_query($db, "INSERT INTO `settings`(`user_id`, `grace_period`) VALUES ('".$_SESSION['portal_id']."', '".$_POST['grace_period']."')");
echo "<script>window.location='settings.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Settings </title>

		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- page specific plugin styles -->
		<link rel="stylesheet" href="assets/css/jquery-ui.custom.min.css" />
		<link rel="stylesheet" href="assets/css/jquery.gritter.min.css" />
		<link rel="stylesheet" href="assets/css/select2.min.css" />
		<link rel="stylesheet" href="assets/css/bootstrap-datepicker3.min.css" />
		<link rel="stylesheet" href="assets/css/bootstrap-editable.min.css" />

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

		<!-- ace settings handler -->
		<script src="assets/js/ace-extra.min.js"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body class="no-skin">

	<?php include 'header.php'; ?>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<?php include 'sidebar.php'; ?>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="#">Home</a>
							</li>

							<li>
								<a href="#">My Account</a>
							</li>
							<li class="active">Manage Settings</li>
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
								Manage Settings
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Manage your settings and more:
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<div class="">
									<div id="user-profile-2" class="user-profile">
										<div class="tabbable">
											<ul class="nav nav-tabs padding-18">
												<li class="active">
													<a data-toggle="tab" href="#documents">
														<i class="orange ace-icon fa fa-file bigger-120"></i>
														Manage Documents
													</a>
												</li>
                                                <li>
													<a data-toggle="tab" href="#feed">
														<i class="green ace-icon fa fa-gear bigger-120"></i>
														Commission Rates
													</a>
												</li>
											</ul>

											<div class="tab-content no-border padding-24">
												<div id="documents" class="tab-pane in active">
													<div class="profile-feed row">
													<div class="col-xs-12 col-sm-12">
                                                    <button class="btn btn-primary btn-xs pull-right" onClick="window.location='add_document.php'"><i class="fa fa-plus fa-lg"></i> Upload New Document</i></button>
															<h4 class="red">
																<span class="middle">Grace Period</span>
															</h4>
                                                        <div class="row">
                                                        	<div class="col-md-4">
                                                            <strong>For Your:</strong> 
                                                            <?php
															if($sess_user_level == '1'){
															$graceid = '0';	
															}
															else {
															$graceid = $sess_parent_id;	
															}
															$g_q = mysqli_query($db, "SELECT `grace_period` FROM `settings` WHERE `user_id`='$graceid'");
															$g_f = mysqli_fetch_assoc($g_q);
															echo $gracedays = $g_f['grace_period'];
															?> Days
                                                            </div>
                                                            <div class="col-md-4">
                                                            <?php if($sess_user_level == '1' && $sess_user_type=='broker'){?>
                                                            <strong>For Your Downlines:</strong> 
                                                            <div id="gc">
                                                            <?php
															$g_q = mysqli_query($db, "SELECT `grace_period` FROM `settings` WHERE `user_id`='".$_SESSION['portal_id']."'");
															$g_f = mysqli_fetch_assoc($g_q);
															echo $gracedays = $g_f['grace_period'];
															?>
                                                            Days <button class="btn btn-xs btn-primary" style="padding:1px;" onClick="showform()"><i class="fa fa-pencil"></i> Edit Period</button>
                                                            </div>
                                                            
                                                            <div id="gc_form" style="display:none;">
                                                            <form method="post" action="?action=gc">
                                                            <input type="text" style="width:100px;" name="grace_period" required>
                                                            <input type="submit" value="Submit Now" class="btn btn-xs btn-primary">
                                                            </form>
                                                            </div>
                                                            <script>
															function showform(){
																document.getElementById('gc').style.display = 'none';
																document.getElementById('gc_form').style.display = 'block';
															}
															</script>
                                                            <?php } ?>
                                                            </div>
                                                        </div>    
                                                            
														<h4 class="red">
																<span class="middle">Licensing and/or E&O Documents</span>
															</h4>	
                                                        <table class="table table-bordered table-hover" style="margin-bottom: 50px;">
                                                            <thead>
                                                                <tr>
                                                                    <th>SrNo</th>
                                                                    <th>Uploaded On</th>
                                                                    <th>Document Type/Name</th>
                                                                    <th>Vaid From/Till</th>
                                                                    <th>Province</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                <tr>
                                                            </thead>
                                                            <tbody>
															<?php 
                                                            $sr = 0;
                                                            $file_q = mysqli_query($db, "SELECT * FROM `user_license` WHERE `user_id`='".$_SESSION['portal_id']."'");
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
															$u_q = mysqli_query($db, "SELECT * FROM `users` WHERE `id`='".$file_f['approved_by']."'");
                                                            $u_f = mysqli_fetch_assoc($u_q);
															$approvedby = $u_f['fname'];
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $sr;?></td>
                                                                <td><?php echo $file_f['dated'];?></td>
                                                                <td><a href="uploads/<?php echo $file_f['license'];?>" target="_blank"><i class="fa fa-file"></i> <?php echo ucwords(strtolower($license_type));?></a></td>
                                                                <td><?php echo $file_f['eff_date'].' - '.$file_f['expiry_date'];?></td>
                                                                <td><?php echo $file_f['province'];?></td>
                                                                <td><span class="label <?php echo $label;?> arrowed-in arrowed-in-right"><?php echo $status_txt;?></span> <?php if($file_f['status'] !='0'){?> <small>By <strong><?php echo $approvedby;?></strong></small> <?php } ?></td>
                                                                <td><?php if($file_f['status'] =='1'){?><i class="fa fa-lock"></i> Locked <?php } else {?><a href="#" onclick="if(confirm('Do you really want to delete ?')) window.location='?action=del&id=<?php echo $file_f['id'];?>';"><i class="ace-icon red fa fa-trash-o bigger-110"></i> Delete</a><?php } ?></td>
                                                            </tr>
															<?php } ?>
                                                            </tbody>
                                                            </table>

															<div class="hr hr-8 dotted"></div>

														</div>
													</div><!-- /.row -->

													<div class="space-12"></div>


												</div>
                                                
												<div id="feed" class="tab-pane">
													<div class="profile-feed row">
													<div class="col-xs-12 col-sm-9">
															<h4 class="blue">
																<span class="middle">Commission Rates Settings</span>
															</h4>

															<div class="profile-info-row">
																	<div class="profile-info-name" style="text-align: left; width: 200px;"> Pay Commission ? </div>

																	<div class="profile-info-value" style="font-weight: bold; font-size: 16px;">
																		<span><?php if($user_pay_commission == 'yes'){?><i class="fa fa-check text-success fa-lg"></i> <?php } else { ?><i class="fa fa-close text-danger fa-lg"></i> <?php } ?> <?php echo ucwords(strtolower($user_pay_commission));?></span>
																	</div>
																</div>
															
                                                            <table class="table  table-bordered table-hover" style="margin-bottom: 50px;">
                                                <thead>
                                                    <tr>
                                                        <th>Policy</th>
                                                        <th>Allowed to Sell</th>
                                                        <th>Commission Rate (%)</th>
                                                    <tr>
                                                </thead>
                                                <tbody>
                                                <?php 
												$p_q = mysqli_query($db, "SELECT * FROM `comm_rates` WHERE `user_id`='".$_REQUEST['id']."'");
												while($p_f = mysqli_fetch_assoc($p_q)){
													
												$cur_q = mysqli_query($db, "SELECT * FROM `policies` WHERE `id`='".$p_f['policy_id']."'");
												$cur_f = mysqli_fetch_assoc($cur_q);
												?>
                                                	<tr>
                                                        <td><?php echo $cur_f['policy_name'];?></td>
                                                        <td><?php if($p_f['allowtosell'] == '1'){?><i class="fa fa-check text-success fa-lg"></i> Yes<?php } else { ?><i class="fa fa-close text-danger fa-lg"></i> No<?php } ?></td>
                                                        <td><?php echo $p_f['comm_rate'];?>%</td>
                                                    </tr>
                                                <?php } ?>   
                                                </tbody>
                                                </table>

															<div class="hr hr-8 dotted"></div>

														</div>
													</div><!-- /.row -->

													<div class="space-12"></div>


												</div><!-- /#settings -->

											</div>
										</div>
									</div>
								</div>


								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<?php include 'footer.php';?>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="assets/js/jquery-2.1.4.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="assets/js/excanvas.min.js"></script>
		<![endif]-->
		<script src="assets/js/jquery-ui.custom.min.js"></script>
		<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="assets/js/jquery.gritter.min.js"></script>
		<script src="assets/js/bootbox.js"></script>
		<script src="assets/js/jquery.easypiechart.min.js"></script>
		<script src="assets/js/bootstrap-datepicker.min.js"></script>
		<script src="assets/js/jquery.hotkeys.index.min.js"></script>
		<script src="assets/js/bootstrap-wysiwyg.min.js"></script>
		<script src="assets/js/select2.min.js"></script>
		<script src="assets/js/spinbox.min.js"></script>
		<!--<script src="assets/js/bootstrap-editable.min.js"></script>-->
		<script src="assets/js/ace-editable.min.js"></script>
		<script src="assets/js/jquery.maskedinput.min.js"></script>

		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		
	</body>
</html>
