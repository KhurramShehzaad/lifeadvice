<?php
include 'includes/db_connect.php';
if($sess_user_type == 'agent'){
	echo "<script>window.location='dashboard.php'</script>";
}

//if logged in
$user_q = mysqli_query($db, "SELECT * FROM `users` WHERE `id`=?");
$user_f = mysqli_fetch_assoc($user_q);
//$user_q->close();

$user_id = $user_f['id'];
$user_user_pic = $user_f['user_pic'];
$user_fname = $user_f['fname'];
$user_lname = $user_f['lname'];
$user_email = $user_f['email'];
$user_phone = $user_f['phone'];
$user_username = $user_f['username'];
$user_password = $user_f['password'];
$user_address = $user_f['address'];
$user_province = $user_f['province'];
$user_city = $user_f['city'];
$user_country = $user_f['country'];
$user_postal = $user_f['postal'];
$user_user_type = $user_f['user_type'];
$user_parent_id = $user_f['parent_id'];
$user_status = $user_f['status'];
$user_commission_rate = $user_f['commission_rate'];
$user_passkey = $user_f['passkey'];
$user_unique_code = $user_f['unique_code'];
$user_join_date = $user_f['join_date'];
$user_user_pic = $user_f['user_pic'];
$user_user_level = $user_f['user_level'];
$user_dob = $user_f['dob'];
$user_about_me = $user_f['about_me'];
$user_facebook = $user_f['facebook'];
$user_twitter = $user_f['twitter'];
$user_pay_commission = $user_f['pay_commission'];
$user_mg_capability = $user_f['mg_capability'];


if($_REQUEST['action'] == 'license'){
if($_REQUEST['status'] == '1' || $_REQUEST['status'] == '2'){
$de_q = mysqli_query($db, "UPDATE `user_license` SET `status`='".$_REQUEST['status']."' WHERE `user_id`='$user_id'");
} /*else if($_REQUEST['status'] == 'del'){
$de_q = $dbp->prepare("DELETE FROM `user_license` WHERE `id`=?");
$de_q->bind_param("i", $_REQUEST['delid'], $user_id);
$de_q->execute();
}*/
echo "<script>window.location='user_profile.php?id=$user_id'</script>";
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>User Profile</title>

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
								<a href="#">More Pages</a>
							</li>
							<li class="active">Manage Profile</li>
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
								<?php echo $user_fname.' '.$user_lname;?>
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Select your next step below:
								</small>
                                <button onclick="window.location='add_document.php?id=<?php echo $_REQUEST['id'];?>'" class="btn btn-warning btn-xs pull-right" style="color: #333 !important; text-shadow: 0 0 !important; margin-left:5px;"><i class="fa fa-upload"></i> Upload Document</button>
								<button class="btn btn-primary btn-xs pull-right" onClick="window.location='manage_user.php?id=<?php echo $_REQUEST['id'];?>'"><i class="fa fa-pencil"></i> Edit Profile</i></button>
                                
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
													<a data-toggle="tab" href="#home">
														<i class="green ace-icon fa fa-user bigger-120"></i>
														User Profile
													</a>
												</li>

												<li>
													<a data-toggle="tab" href="#feed">
														<i class="orange ace-icon fa fa-gear bigger-120"></i>
														Settings
													</a>
												</li>

												<li>
													<a data-toggle="tab" href="#friends">
														<i class="blue ace-icon fa fa-users bigger-120"></i>
														Downline Members
													</a>
												</li>

												<li>
													<a data-toggle="tab" href="#pictures">
														<i class="pink ace-icon fa fa-lock bigger-120"></i>
														Account Security
													</a>
												</li>
											</ul>

											<div class="tab-content no-border padding-24">
												<div id="home" class="tab-pane in active">
													<div class="row">
														<!--<div class="col-xs-12 col-sm-3 center">
															<span class="profile-picture">
																<img class="editable img-responsive" alt="Alex's Avatar" id="avatar2" src="assets/images/avatars/profile-pic.jpg" />
															</span>

															<h3><span class="red">I'm</span> <?php echo ucwords(strtolower($user_user_type));?></h3>
															<div class="space space-4"></div>
															
														</div> User Picture -->

														<div class="col-xs-12 col-sm-9">
															<h4 class="blue">
																<span class="middle"><?php echo $user_fname.' '.$user_lname;?> <small class="text-danger">(<?php echo ucwords(strtolower($user_user_type));?>)</small></span>

																<span class="label label-purple arrowed-in-right">
																	<i class="ace-icon fa fa-circle smaller-80 align-middle"></i>
																	<?php echo $user_status;?>
																</span>
															</h4>

															<div class="profile-user-info">
                                                            	<div class="profile-info-row">
																	<div class="profile-info-name"> Management Capability </div>

																	<div class="profile-info-value">
																		<span>
																		<label>
                                                                            <input type="checkbox" class="ace ace-switch ace-switch-5" name="mg_capability" value="1" <?php if($user_mg_capability == '1'){?> checked <?php } ?> disabled>
                                                                            <span class="lbl"></span>
                                                                        </label>
                                                                        </span>
																	</div>
																</div>
																<div class="profile-info-row">
																	<div class="profile-info-name"> Email </div>

																	<div class="profile-info-value">
																		<i class="fa fa-envelope light-blue bigger-110"></i>
																		<span><?php echo $user_email;?></span>
																	</div>
																</div>
																
																<div class="profile-info-row">
																	<div class="profile-info-name"> Phone </div>

																	<div class="profile-info-value">
																		<i class="fa fa-phone light-red bigger-110"></i>
																		<span><?php echo $user_phone;?></span>
																	</div>
																</div>

																<div class="profile-info-row">
																	<div class="profile-info-name"> Location </div>

																	<div class="profile-info-value">
																		<i class="fa fa-map-marker light-orange bigger-110"></i>
																		<span><?php echo $user_address.' '.$user_city.', '.$user_province.' '.$user_postal;?></span>
																		<span><?php echo $user_country;?></span>
																	</div>
																</div>

																<div class="profile-info-row">
																	<div class="profile-info-name"> Age </div>

																	<div class="profile-info-value">
																		<span><?php echo  date('Y') - date('Y', strtotime($user_dob));?>yrs</span>
																		<span><?php echo $user_dob;?>
																	</div>
																</div>

																<div class="profile-info-row">
																	<div class="profile-info-name"> Joined </div>

																	<div class="profile-info-value">
																		<span><?php echo $user_join_date;?></span>
																	</div>
																</div>

															</div>

															<div class="hr hr-8 dotted"></div>

															<div class="profile-user-info">
															<?php if($user_user_type != 'admin'){?>
																<div class="profile-info-row">
																	<div class="profile-info-name"> Unique <?php if($user_user_type == 'broker'){ echo 'Code'; } else { echo 'URL'; } ?> </div>

																	<div class="profile-info-value">
																	<i class="fa fa-globe bigger-110"></i>
																	<?php if($user_unique_code == ''){?>
																	<a href="url.php" target="_blank"><strong>Assign URL/Code</strong></a>
																	<?php } else {
																		if($user_user_type == 'broker'){ echo $user_unique_code; } else {
																		?>
																		<a href="https://<?php echo $suburl;?>.vtcinsure.ca/quote/?<?php echo $user_user_type.'='.$user_unique_code;?>" target="_blank">https://<?php echo $suburl;?>.vtcinsure.ca/quote/?<?php echo $user_user_type.'='.$user_unique_code;?> <i class="fa fa-external-link"></i></a>
																	<?php }} ?>
																	</div>
																</div>
																<?php } ?>	

																<div class="profile-info-row">
																	<div class="profile-info-name">
																		<i class="middle ace-icon fa fa-facebook-square bigger-150 blue"></i>
																	</div>

																	<div class="profile-info-value">
																		<a href="http://facebook.com/<?php echo $user_facebook;?>" target="_blank">Find me on Facebook</a>
																	</div>
																</div>

																<div class="profile-info-row">
																	<div class="profile-info-name">
																		<i class="middle ace-icon fa fa-twitter-square bigger-150 light-blue"></i>
																	</div>

																	<div class="profile-info-value">
																		<a href="http://twitter.com/<?php echo $user_twitter;?>" target="_blank">Follow me on Twitter</a>
																	</div>
																</div>
															</div>
														</div><!-- /.col -->
													</div><!-- /.row -->

													<div class="space-20"></div>

													<div class="row">

														<div class="col-xs-12 col-sm-9">
															<div class="widget-box transparent">
																<div class="widget-header widget-header-small">
																	<h4 class="widget-title smaller">
																		<i class="ace-icon fa fa-check-square-o bigger-110"></i>
																		Little About User
																	</h4>
																</div>

																<div class="widget-body">
																	<div class="widget-main">
																		<?php echo $user_about_me;?>
																		<p>
																			Thanks for visiting my profile.
																		</p>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div><!-- /#home -->

												<div id="feed" class="tab-pane">
													<div class="profile-feed row">
													<div class="col-xs-12 col-sm-9">
															<h4 class="red">
																<span class="middle">Manage Settings/Rates <button type="button" onClick="window.location='manage_comm_rates.php?id=<?php echo $_REQUEST['id'];?>'" class="btn btn-xs btn-danger"><i class="fa fa-pencil"></i> Modify</button></span>
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


												</div><!-- /#feed -->

												<div id="friends" class="tab-pane">
													<div class="profile-users clearfix">
													<?php
													$me_q = mysqli_query($db, "SELECT * FROM `users` WHERE `parent_id`='".$_REQUEST['id']."' OR `parent_id` IN (SELECT `id` FROM `users` WHERE `parent_id`='".$_REQUEST['id']."' OR `parent_id` IN (SELECT `id` AS 'curret_id' FROM `users` WHERE `parent_id`='".$_REQUEST['id']."' OR `parent_id` IN (SELECT `id` FROM `users` WHERE `parent_id`='curret_id')))");
													while($de_f = mysqli_fetch_assoc($me_q)){
													?>
														<div class="itemdiv memberdiv">
															<div class="inline pos-rel">
																<div class="user">
																	<a href="#">
																		<img src="assets/images/avatars/avatar4.png" alt="Bob Doe's avatar" />
																	</a>
																</div>

																<div class="body">
																	<div class="name">
																		<a href="user_profile.php?id=<?php echo $de_f['id'];?>">
																			<span class="user-status status-online"></span>
																			<?php echo $de_f['fname'].' '.$de_f['lname'];?>
																		</a>
																	</div>
																</div>

																<div class="popover">
																	<div class="arrow"></div>

																	<div class="popover-content">
																		<div class="bolder"><?php echo ucwords(strtolower($de_f['user_type']));?></div>

																		<div class="time">
																			<i class="ace-icon fa fa-clock-o middle bigger-120 orange"></i>
																			<span class="green"> <?php echo ucwords(strtolower($de_f['joined']));?> </span>
																		</div>

																		<div class="hr dotted hr-8"></div>
																	</div>
																</div>
															</div>
														</div>
													<?php } //if($numrows == 0){ echo 'No members found under this user.'; } ?>
													</div>

													<div class="hr hr10 hr-double"></div>


												</div><!-- /#friends -->

												<div id="pictures" class="tab-pane">
													<div class="col-xs-12 col-sm-9">
															<h4 class="blue">
																<span class="middle">Account Security</span>
															</h4>

															<div class="profile-user-info">
																<div class="profile-info-row">
																	<div style="text-align:left; width:200px;" class="profile-info-name"> Username </div>

																	<div class="profile-info-value">
																	<i class="fa fa-user light-orange bigger-110"></i>
																		<span><?php echo $user_username;?></span>
																	</div>
																</div>
																<div class="profile-info-row">
																	<div style="text-align:left; width:200px;" class="profile-info-name"> Password </div>

																	<div class="profile-info-value">
																	<i class="fa fa-lock light-orange bigger-110"></i>
																		<span>*********</span>
																		<span><button class="btn btn-primary btn-xs pull-right" onClick="window.location='manage_user.php?id=<?php echo $user_id;?>'"><i class="fa fa-pencil"></i> Change Password</i></button></span>
																	</div>
																</div>


															</div>

															<div class="hr hr-8 dotted"></div>


														</div>
												</div><!-- /#pictures -->
											
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
		<script type="text/javascript">
			jQuery(function($) {
			
				/*editables on first profile page
				$.fn.editable.defaults.mode = 'inline';
				$.fn.editableform.loading = "<div class='editableform-loading'><i class='ace-icon fa fa-spinner fa-spin fa-2x light-blue'></i></div>";
			    $.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit"><i class="ace-icon fa fa-check"></i></button>'+
			                                '<button type="button" class="btn editable-cancel"><i class="ace-icon fa fa-times"></i></button>';    
				
				//editables */
				
				//text editable
			    $('#username')
				.editable({
					type: 'text',
					name: 'username'		
			    });
			
			
				
				//select2 editable
				var countries = [];
			    $.each({ "CA": "Canada", "IN": "India", "NL": "Netherlands", "TR": "Turkey", "US": "United States"}, function(k, v) {
			        countries.push({id: k, text: v});
			    });
			
				var cities = [];
				cities["CA"] = [];
				$.each(["Toronto", "Ottawa", "Calgary", "Vancouver"] , function(k, v){
					cities["CA"].push({id: v, text: v});
				});
				cities["IN"] = [];
				$.each(["Delhi", "Mumbai", "Bangalore"] , function(k, v){
					cities["IN"].push({id: v, text: v});
				});
				cities["NL"] = [];
				$.each(["Amsterdam", "Rotterdam", "The Hague"] , function(k, v){
					cities["NL"].push({id: v, text: v});
				});
				cities["TR"] = [];
				$.each(["Ankara", "Istanbul", "Izmir"] , function(k, v){
					cities["TR"].push({id: v, text: v});
				});
				cities["US"] = [];
				$.each(["New York", "Miami", "Los Angeles", "Chicago", "Wysconsin"] , function(k, v){
					cities["US"].push({id: v, text: v});
				});
				
				var currentValue = "NL";
			    $('#country').editable({
					type: 'select2',
					value : 'NL',
					//onblur:'ignore',
			        source: countries,
					select2: {
						'width': 140
					},		
					success: function(response, newValue) {
						if(currentValue == newValue) return;
						currentValue = newValue;
						
						var new_source = (!newValue || newValue == "") ? [] : cities[newValue];
						
						//the destroy method is causing errors in x-editable v1.4.6+
						//it worked fine in v1.4.5
						/**			
						$('#city').editable('destroy').editable({
							type: 'select2',
							source: new_source
						}).editable('setValue', null);
						*/
						
						//so we remove it altogether and create a new element
						var city = $('#city').removeAttr('id').get(0);
						$(city).clone().attr('id', 'city').text('Select City').editable({
							type: 'select2',
							value : null,
							//onblur:'ignore',
							source: new_source,
							select2: {
								'width': 140
							}
						}).insertAfter(city);//insert it after previous instance
						$(city).remove();//remove previous instance
						
					}
			    });
			
				$('#city').editable({
					type: 'select2',
					value : 'Amsterdam',
					//onblur:'ignore',
			        source: cities[currentValue],
					select2: {
						'width': 140
					}
			    });
			
			
				
				//custom date editable
				$('#signup').editable({
					type: 'adate',
					date: {
						//datepicker plugin options
						    format: 'yyyy/mm/dd',
						viewformat: 'yyyy/mm/dd',
						 weekStart: 1
						 
						//,nativeUI: true//if true and browser support input[type=date], native browser control will be used
						//,format: 'yyyy-mm-dd',
						//viewformat: 'yyyy-mm-dd'
					}
				})
			
			    $('#age').editable({
			        type: 'spinner',
					name : 'age',
					spinner : {
						min : 16,
						max : 99,
						step: 1,
						on_sides: true
						//,nativeUI: true//if true and browser support input[type=number], native browser control will be used
					}
				});
				
			
			    $('#login').editable({
			        type: 'slider',
					name : 'login',
					
					slider : {
						 min : 1,
						  max: 50,
						width: 100
						//,nativeUI: true//if true and browser support input[type=range], native browser control will be used
					},
					success: function(response, newValue) {
						if(parseInt(newValue) == 1)
							$(this).html(newValue + " hour ago");
						else $(this).html(newValue + " hours ago");
					}
				});
			
				$('#about').editable({
					mode: 'inline',
			        type: 'wysiwyg',
					name : 'about',
			
					wysiwyg : {
						//css : {'max-width':'300px'}
					},
					success: function(response, newValue) {
					}
				});
				
				
				
				// *** editable avatar *** //
				try {//ie8 throws some harmless exceptions, so let's catch'em
			
					//first let's add a fake appendChild method for Image element for browsers that have a problem with this
					//because editable plugin calls appendChild, and it causes errors on IE at unpredicted points
					try {
						document.createElement('IMG').appendChild(document.createElement('B'));
					} catch(e) {
						Image.prototype.appendChild = function(el){}
					}
			
					var last_gritter
					$('#avatar').editable({
						type: 'image',
						name: 'avatar',
						value: null,
						//onblur: 'ignore',  //don't reset or hide editable onblur?!
						image: {
							//specify ace file input plugin's options here
							btn_choose: 'Change Avatar',
							droppable: true,
							maxSize: 110000,//~100Kb
			
							//and a few extra ones here
							name: 'avatar',//put the field name here as well, will be used inside the custom plugin
							on_error : function(error_type) {//on_error function will be called when the selected file has a problem
								if(last_gritter) $.gritter.remove(last_gritter);
								if(error_type == 1) {//file format error
									last_gritter = $.gritter.add({
										title: 'File is not an image!',
										text: 'Please choose a jpg|gif|png image!',
										class_name: 'gritter-error gritter-center'
									});
								} else if(error_type == 2) {//file size rror
									last_gritter = $.gritter.add({
										title: 'File too big!',
										text: 'Image size should not exceed 100Kb!',
										class_name: 'gritter-error gritter-center'
									});
								}
								else {//other error
								}
							},
							on_success : function() {
								$.gritter.removeAll();
							}
						},
					    url: function(params) {
							// ***UPDATE AVATAR HERE*** //
							//for a working upload example you can replace the contents of this function with 
							//examples/profile-avatar-update.js
			
							var deferred = new $.Deferred
			
							var value = $('#avatar').next().find('input[type=hidden]:eq(0)').val();
							if(!value || value.length == 0) {
								deferred.resolve();
								return deferred.promise();
							}
			
			
							//dummy upload
							setTimeout(function(){
								if("FileReader" in window) {
									//for browsers that have a thumbnail of selected image
									var thumb = $('#avatar').next().find('img').data('thumb');
									if(thumb) $('#avatar').get(0).src = thumb;
								}
								
								deferred.resolve({'status':'OK'});
			
								if(last_gritter) $.gritter.remove(last_gritter);
								last_gritter = $.gritter.add({
									title: 'Avatar Updated!',
									text: 'Uploading to server can be easily implemented. A working example is included with the template.',
									class_name: 'gritter-info gritter-center'
								});
								
							 } , parseInt(Math.random() * 800 + 800))
			
							return deferred.promise();
							
							// ***END OF UPDATE AVATAR HERE*** //
						},
						
						success: function(response, newValue) {
						}
					})
				}catch(e) {}
				
				/**
				//let's display edit mode by default?
				var blank_image = true;//somehow you determine if image is initially blank or not, or you just want to display file input at first
				if(blank_image) {
					$('#avatar').editable('show').on('hidden', function(e, reason) {
						if(reason == 'onblur') {
							$('#avatar').editable('show');
							return;
						}
						$('#avatar').off('hidden');
					})
				}
				*/
			
				//another option is using modals
				$('#avatar2').on('click', function(){
					var modal = 
					'<div class="modal fade">\
					  <div class="modal-dialog">\
					   <div class="modal-content">\
						<div class="modal-header">\
							<button type="button" class="close" data-dismiss="modal">&times;</button>\
							<h4 class="blue">Change Avatar</h4>\
						</div>\
						\
						<form class="no-margin">\
						 <div class="modal-body">\
							<div class="space-4"></div>\
							<div style="width:75%;margin-left:12%;"><input type="file" name="file-input" /></div>\
						 </div>\
						\
						 <div class="modal-footer center">\
							<button type="submit" class="btn btn-sm btn-success"><i class="ace-icon fa fa-check"></i> Submit</button>\
							<button type="button" class="btn btn-sm" data-dismiss="modal"><i class="ace-icon fa fa-times"></i> Cancel</button>\
						 </div>\
						</form>\
					  </div>\
					 </div>\
					</div>';
					
					
					var modal = $(modal);
					modal.modal("show").on("hidden", function(){
						modal.remove();
					});
			
					var working = false;
			
					var form = modal.find('form:eq(0)');
					var file = form.find('input[type=file]').eq(0);
					file.ace_file_input({
						style:'well',
						btn_choose:'Click to choose new avatar',
						btn_change:null,
						no_icon:'ace-icon fa fa-picture-o',
						thumbnail:'small',
						before_remove: function() {
							//don't remove/reset files while being uploaded
							return !working;
						},
						allowExt: ['jpg', 'jpeg', 'png', 'gif'],
						allowMime: ['image/jpg', 'image/jpeg', 'image/png', 'image/gif']
					});
			
					form.on('submit', function(){
						if(!file.data('ace_input_files')) return false;
						
						file.ace_file_input('disable');
						form.find('button').attr('disabled', 'disabled');
						form.find('.modal-body').append("<div class='center'><i class='ace-icon fa fa-spinner fa-spin bigger-150 orange'></i></div>");
						
						var deferred = new $.Deferred;
						working = true;
						deferred.done(function() {
							form.find('button').removeAttr('disabled');
							form.find('input[type=file]').ace_file_input('enable');
							form.find('.modal-body > :last-child').remove();
							
							modal.modal("hide");
			
							var thumb = file.next().find('img').data('thumb');
							if(thumb) $('#avatar2').get(0).src = thumb;
			
							working = false;
						});
						
						
						setTimeout(function(){
							deferred.resolve();
						} , parseInt(Math.random() * 800 + 800));
			
						return false;
					});
							
				});
			
				
			
				//////////////////////////////
				$('#profile-feed-1').ace_scroll({
					height: '250px',
					mouseWheelLock: true,
					alwaysVisible : true
				});
			
				$('a[ data-original-title]').tooltip();
			
				$('.easy-pie-chart.percentage').each(function(){
				var barColor = $(this).data('color') || '#555';
				var trackColor = '#E2E2E2';
				var size = parseInt($(this).data('size')) || 72;
				$(this).easyPieChart({
					barColor: barColor,
					trackColor: trackColor,
					scaleColor: false,
					lineCap: 'butt',
					lineWidth: parseInt(size/10),
					animate:false,
					size: size
				}).css('color', barColor);
				});
			  
				///////////////////////////////////////////
			
				//right & left position
				//show the user info on right or left depending on its position
				$('#user-profile-2 .memberdiv').on('mouseenter touchstart', function(){
					var $this = $(this);
					var $parent = $this.closest('.tab-pane');
			
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $this.offset();
					var w2 = $this.width();
			
					var place = 'left';
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) place = 'right';
					
					$this.find('.popover').removeClass('right left').addClass(place);
				}).on('click', function(e) {
					e.preventDefault();
				});
			
			
				///////////////////////////////////////////
				$('#user-profile-3')
				.find('input[type=file]').ace_file_input({
					style:'well',
					btn_choose:'Change avatar',
					btn_change:null,
					no_icon:'ace-icon fa fa-picture-o',
					thumbnail:'large',
					droppable:true,
					
					allowExt: ['jpg', 'jpeg', 'png', 'gif'],
					allowMime: ['image/jpg', 'image/jpeg', 'image/png', 'image/gif']
				})
				.end().find('button[type=reset]').on(ace.click_event, function(){
					$('#user-profile-3 input[type=file]').ace_file_input('reset_input');
				})
				.end().find('.date-picker').datepicker().next().on(ace.click_event, function(){
					$(this).prev().focus();
				})
				$('.input-mask-phone').mask('(999) 999-9999');
			
				$('#user-profile-3').find('input[type=file]').ace_file_input('show_file_list', [{type: 'image', name: $('#avatar').attr('src')}]);
			
			
				////////////////////
				//change profile
				$('[data-toggle="buttons"] .btn').on('click', function(e){
					var target = $(this).find('input[type=radio]');
					var which = parseInt(target.val());
					$('.user-profile').parent().addClass('hide');
					$('#user-profile-'+which).parent().removeClass('hide');
				});
				
				
				
				/////////////////////////////////////
				$(document).one('ajaxloadstart.page', function(e) {
					//in ajax mode, remove remaining elements before leaving page
					try {
						$('.editable').editable('destroy');
					} catch(e) {}
					$('[class*=select2]').remove();
				});
			});
		</script>
	</body>
</html>
