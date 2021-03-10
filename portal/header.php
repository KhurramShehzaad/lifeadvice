<?php
if($_SESSION['portal_id'] == ''){
echo "<script>window.location='index.php?login=session_out';</script>";	
}


if($_REQUEST['action'] == 'dismiss'){
$current_url = str_replace('/portal/', '', $_SERVER['REQUEST_URI']);
$dismiss_value = '1';
mysqli_query($db, "UPDATE `notifications` SET `dismiss`='1' WHERE `id`='".$_REQUEST['id']."'");
/*$notify_q = $dbp->prepare("UPDATE `notifications` SET `dismiss`=? WHERE `id`=?");
$notify_q->bind_param('i', $dismiss_value, $_REQUEST['id']);
$notify_q->execute();*/

$current_url = str_replace('?action=dismiss&id='.$_REQUEST['id'], '', $current_url);
echo "<script>window.location='$current_url';</script>";	
}
?>

		<div id="navbar" class="navbar navbar-default          ace-save-state">
			<div class="navbar-container ace-save-state" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left">
					<a href="dashboard.php" class="navbar-brand">
						<small>
							<i class="fa fa-shield"></i>
							LifeAdvice
						</small>
					</a>
				</div>

				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<li class="purple dropdown-modal">

<?php
									$sql = "SELECT * FROM `notifications` WHERE `dismiss`='0' AND `user_id`='".$_SESSION['portal_id']."' ORDER BY `notifications`.`dated` DESC";
									$n_q = mysqli_query($db, $sql);
									$num_rows = mysqli_num_rows($n_q);
												
												/*$sql = "SELECT * FROM `notifications` WHERE `dismiss`=? AND `changedby`<>? AND (`user_id`=? OR `user_id` IN (SELECT `id` FROM `users` WHERE `parent_id`=?)) limit 5";
												$n_q = $dbp->prepare($sql);
												$dis = '0';
												$de_q->bind_param("iiii", $dis, $_SESSION['portal_id'], $_SESSION['portal_id'], $_SESSION['portal_id']);	
												$n_q->execute();
												$n_q_results = $n_q->get_result();
												$num_rows = $n_q_results->num_rows;*/
?>
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-bell <?php if($num_rows > 0){?> icon-animated-bell <?php } ?>"></i>
								<span class="badge badge-important"><?php echo $num_rows;?></span>
							</a>

							<ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-exclamation-triangle"></i>
									<?php echo $num_rows;?> Notifications
								</li>

								<li class="dropdown-content">
									<ul class="dropdown-menu dropdown-navbar navbar-pink">
                                    <?php
												while($n_f = mysqli_fetch_assoc($n_q)){ //$n_q_results->fetch_assoc()){ 
									?>
										<li>
												<div class="clearfix">
													<span class="pull-left" style="line-height: normal; color: rgb(102, 102, 102); font-size:13px;">
														<!--<i class="btn btn-xs no-hover btn-pink fa fa-comment"></i>-->
														<?php echo $n_f['notification'];?><br/> <small><i class="fa fa-clock-o"></i> <?php echo $n_f['dated'];?></small>
                                                        <?php if($_SESSION['portal_id'] == $n_f['user_id']){?>
                                                        <span class="text-danger" style="padding: 0px 6px 0px 5px; font-family: arial; font-size: 11px; font-weight: bold;"><a href="?action=dismiss&id=<?php echo $n_f['id'];?>"><i class="fa fa-close"></i> Dismiss</a></span>
                                                        <?php } ?>
													</span>
													<!--<span class="pull-right badge badge-info">+12</span>
                                                    <span class="pull-right badge badge-danger"><i class="fa fa-close"></i> Dismiss</span>-->
												</div>
										</li>
                                        <?php } if($num_rows == 0){ ?>
                                        <li>
												<div class="clearfix">
													<span class="pull-left" style="line-height: normal; color: rgb(102, 102, 102);">
														There are no notiications yet!
													</span>
												</div>
										</li>
                                        <?php } ?>
									</ul>
								</li>

								<li class="dropdown-footer" style="background: #f7ecf2; padding:0; display:none;">
									<a href="timeline.php">
										See all notifications
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>

						<!--<li class="green dropdown-modal">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-envelope icon-animated-vertical"></i>
								<span class="badge badge-success">0</span>
							</a>

							<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-envelope-o"></i>
									0 Messages
								</li>

								<li class="dropdown-content">
									<ul class="dropdown-menu dropdown-navbar">
										<li>
											<a href="#" class="clearfix">
												<img src="assets/images/avatars/user.jpg" class="msg-photo" alt="" />
												<span class="msg-body">
													<span class="msg-title">
														<span class="blue">Administrator:</span>
														Welcome to Customer Portal...
													</span>

													<!--<span class="msg-time">
														<i class="ace-icon fa fa-clock-o"></i>
														<span>a moment ago</span>
													</span>--><!--
												</span>
											</a>
										</li>

									</ul>
								</li>

								<!--<li class="dropdown-footer">
									<a href="inbox.html">
										See all messages
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</li>--><!--
							</ul>
						</li>-->

						<li class="light-blue dropdown-modal">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="assets/images/avatars/user.jpg" alt="Jason's Photo" />
								<span class="user-info">
									<small>Welcome,</small>
									<?php echo $sess_fname;?>
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">

								<li>
									<a href="profile.php">
										<i class="ace-icon fa fa-user"></i>
										My Profile
									</a>
								</li>
                                <li class="divider"></li>
                                <?php if($sess_user_type == 'admin'){?>
                                <li>
									<a href="settings_admin.php">
										<i class="ace-icon fa fa-gear"></i>
										Settings
									</a>
								</li>
                                <li class="divider"></li>
                                <?php } else { ?>
								<li>
									<a href="settings.php">
										<i class="ace-icon fa fa-gear"></i>
										My Settings
									</a>
								</li>
                                <li class="divider"></li>
                                <?php } ?>
								

								<li>
									<a href="#" onclick="if(confirm('Do you really want to logout ?')) window.location='index.php?login=logout';">
										<i class="ace-icon fa fa-power-off"></i>
										Logout
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div><!-- /.navbar-container -->
		</div>