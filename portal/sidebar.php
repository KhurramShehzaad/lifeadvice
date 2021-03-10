<div id="sidebar" class="sidebar responsive ace-save-state">
				<script type="text/javascript">
					try{ace.settings.loadState('sidebar')}catch(e){}
				</script>


				<ul class="nav nav-list">
					<li class="active col-md-2">
						<a href="dashboard.php">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Dashboard </span>
						</a>

						<b class="arrow"></b>
					</li>
<?php if($sess_user_type !='agent'){?>
					<li class="col-md-2">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-users"></i>
							<span class="menu-text">
								Manage Members
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>
						<b class="arrow"></b>
						<ul class="submenu">
							<li class="">
								<a href="users.php">
									<i class="menu-icon fa fa-user"></i>
									Manage Members
								</a>

								<b class="arrow"></b>
							</li>
						</ul>	
						
					</li>
<?php } ?>		

                            <?php if($sess_mg_capability == '1' || $sess_user_type =='admin'){?>
                            <li class="col-md-2">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-barcode"></i>
							<span class="menu-text">
								Licenses & E&O
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>
						<b class="arrow"></b>
						<ul class="submenu">
							<li class="">
								<a href="user_docs.php">
									<i class="menu-icon fa fa-file"></i>
									Member Documents
								</a>
								<b class="arrow"></b>
							</li>
                            <li class="">
								<a href="docs_report.php">
									<i class="menu-icon fa fa-file"></i>
									Documents Report
								</a>
								<b class="arrow"></b>
							</li>
                            <li class="">
								<a href="expired_docs_report.php">
									<i class="menu-icon fa fa-file"></i>
									Expired Documents Report
								</a>
								<b class="arrow"></b>
							</li>
						</ul>	
						
					</li>
                      <?php } ?>			
					
					<li class="col-md-2">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-bar-chart-o"></i>
							<span class="menu-text">
								Manage Sales
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>
						<ul class="submenu">
							<li class="">
								<a href="sales.php">
									<i class="menu-icon fa fa-bar-chart-o"></i>
									Sales
								</a>

								<b class="arrow"></b>
							</li>
						</ul>	
						
					</li>
					
					<li class="col-md-2">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-gears"></i>
							<span class="menu-text">
								Manage Reports
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>
						<ul class="submenu">
						<li class="">
								<a href="sales_report.php">
									<i class="menu-icon fa fa-gears"></i>
									Sales Report
								</a>

								<b class="arrow"></b>
							</li>
                            <?php if($sess_user_type =='admin'){?>
							<li class="">
								<a href="broker_commission.php">
									<i class="menu-icon fa fa-gears"></i>
									Broker Commission Report
								</a>

								<b class="arrow"></b>
							</li>
                            <li class="">
								<a href="agent_commission.php">
									<i class="menu-icon fa fa-gears"></i>
									Agent Commission Report
								</a>

								<b class="arrow"></b>
							</li>
                            <?php } else if($sess_user_type =='broker'){?>
                            <li class="">
								<a href="broker_commission.php">
									<i class="menu-icon fa fa-gears"></i>
									Broker Commissions
								</a>

								<b class="arrow"></b>
							</li>
                            <?php } else if($sess_user_type =='agent'){?>
                            <li class="">
								<a href="agent_commission.php">
									<i class="menu-icon fa fa-gears"></i>
									Agent Commissions
								</a>

								<b class="arrow"></b>
							</li>
                            <?php } ?>

						</ul>	
						
					</li>
                    <!--<li class="col-md-2">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-dollar"></i>
							<span class="menu-text">
								Rates Sheet
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>
						<ul class="submenu">
							<li class="">
								<a href="rates_report.php">
									<i class="menu-icon fa fa-dollar"></i>
									Rates Sheet
								</a>

								<b class="arrow"></b>
							</li>
						</ul>	
						
					</li>-->
				</ul><!-- /.nav-list 

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>-->
			</div>