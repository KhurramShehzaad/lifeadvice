<div id="sidebar" class="sidebar responsive ace-save-state  menu-min">
				<script type="text/javascript">
					try{ace.settings.loadState('sidebar')}catch(e){}
				</script>


				<ul class="nav nav-list">
					<li class="active">
						<a href="dashboard.php">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Dashboard </span>
						</a>
					</li>

					<li class="active">
						<a href="sales.php">
							<i class="menu-icon fa fa-database"></i>
							<span class="menu-text">
								Manage Sales
							</span>
						</a>						
					</li>
					
					<li class="active">
						<a href="add_note.php?id=<?php echo $_REQUEST['id']; ?>">
							<i class="menu-icon fa fa-sticky-note-o"></i>
							<span class="menu-text">
								Add Note
							</span>
						</a>						
					</li>
					
					<li class="active">
						<a href="change_eff_date.php?id=<?php echo $_REQUEST['id']; ?>">
							<i class="menu-icon fa fa-calendar-check-o"></i>
							<span class="menu-text">
								Change Dates
							</span>
						</a>						
					</li>
					
					<!--<li class="active">
						<a href="resend.php?id=<?php echo $_REQUEST['id']; ?>&policy_number=<?php echo $policy_number;?>&policy_status=<?php echo $policy_status;?>">
							<i class="menu-icon fa fa-envelope"></i>
							<span class="menu-text">
								Send Confirmation
							</span>
						</a>						
					</li>-->
					<?php if($status == 'active'){?>
					<li class="active">
						<a href="early_return.php?id=<?php echo $_REQUEST['id']; ?>">
							<i class="menu-icon fa fa-eject"></i>
							<span class="menu-text">
								Early Return
							</span>
						</a>						
					</li>
					<?php } 
					if($status == 'paid'){
					?>
					<li class="active">
						<a href="cancel_policy.php?id=<?php echo $_REQUEST['id']; ?>">
							<i class="menu-icon fa fa-trash"></i>
							<span class="menu-text">
								Cancel Policy
							</span>
						</a>						
					</li>
					<?php } ?>
					<li class="active">
						<a href="sales_edit.php?id=<?php echo $_REQUEST['id']; ?>">
							<i class="menu-icon fa fa-pencil"></i>
							<span class="menu-text">
								Edit Policy
							</span>
						</a>						
					</li>
					
					
				</ul><!-- /.nav-list 

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>-->
			</div>