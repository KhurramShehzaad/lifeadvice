<?php
include 'includes/db_connect.php';

//Restriction access to this page for agent and brokers with value no capibility
if($sess_user_type !='admin'){
if($sess_mg_capability != '1'){
echo "<script>window.location='dashboard.php';</script>";
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

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Manage Documents</title>

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
							<li class="active">Manage Documents</li>
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
								Manage Documents
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Manage your member's documents and more:
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
											</ul>

											<div class="tab-content no-border padding-24">
												<div id="documents" class="tab-pane in active">
													<div class="profile-feed row">
                                                    <?php if($_REQUEST['action'] == 'change' && $_REQUEST['status'] == '2'){?>
                                                    <form method="post" action="?action=change_done&status=<?php echo $_REQUEST['status'];?>&ub=<?php echo $_REQUEST['ub'];?>&id=<?php echo $_REQUEST['id'];?>">
                                                    <div class="col-md-12">
                                                    <h5 class="red">
																<span class="middle"><strong>Explain the reason of rejection</strong></span>
															</h5>
                                                    <p>Before processing request please explain the reason of rejection.</p>    
                                                    <textarea class="form-control" name="reason" id="reasoon" required></textarea>
                                                    </div>
                                                    <div class="col-md-12" style="margin-top:20px;">
                                                    <button type="submit" class="btn btn-primary pull-right">Submit Now</button>
                                                    </div>
                                                    </form>
                                                    <?php } else { ?>
													<div class="col-xs-12 col-sm-12">
                                                    		<h4 class="red">
																<span class="middle">Licensing and/or E&O Documents</span>
															</h4>
															
                                                        <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                                                        												<thead>
													<tr>
														<th class="center">SrNo</th>
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
                                                            <tr>
                                                                <td class="center"><?php echo $sr;?></td>
                                                                <td><a href="user_profile.php?id=<?php echo $file_f['user_id'];?>"><i class="fa fa-user"></i> <?php echo $uploadedby;?> - <small class="text-danger"><?php echo $uploader_type; ?></small></a><br/><small><i class="fa fa-clock-o"></i> <?php echo $file_f['dated'];?></small></td>
                                                                <td><?php echo $parent_name;?></td>
                                                                <td><a href="uploads/<?php echo str_replace(' ', '', $file_f['license']);?>" target="_blank"><i class="fa fa-file"></i> <?php echo ucwords(strtolower($license_type));?></a></td>
                                                                <td><?php echo $file_f['eff_date'].' - '.$file_f['expiry_date'];?></td>
                                                                <td><?php echo $file_f['province'];?></td>
                                                                <td><span class="label <?php echo $label;?> arrowed-in arrowed-in-right"><?php echo $status_txt;?></span></td>
                                                                <td><span class="text-danger"><i class="fa fa-gear"></i> Change Status</span> <div class="inline position-relative">
																				<button class="btn btn-minier btn-primary btn-no-border dropdown-toggle" data-toggle="dropdown" data-position="auto">
																					<i class="ace-icon fa fa-angle-down icon-only bigger-120"></i>
																				</button>

																				<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
																					<li>
																						<a href="?action=change_done&id=<?php echo $file_f['id'];?>&status=1&ub=<?php echo $file_f['user_id'];?>" class="tooltip-success" data-rel="tooltip" title="Approve">
																							<span class="green">
																								<i class="ace-icon fa fa-check bigger-110"></i>
																							</span>
																						</a>
																					</li>

																					<li>
																						<a href="?action=change&id=<?php echo $file_f['id'];?>&status=2&ub=<?php echo $file_f['user_id'];?>" class="tooltip-warning" data-rel="tooltip" title="Reject">
																							<span class="orange">
																								<i class="ace-icon fa fa-times bigger-110"></i>
																							</span>
																						</a>
																					</li>

																					<!--<li>
																						<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
																							<span class="red">
																								<i class="ace-icon fa fa-trash-o bigger-110"></i>
																							</span>
																						</a>
																					</li>-->
																				</ul>
																			</div></td>
                                                            </tr>
															<?php } ?>
                                                            </tbody>
                                                            </table>

															<div class="hr hr-8 dotted"></div>

														</div>
                                                    <?php } ?> 
													</div><!-- /.row -->

													<div class="space-12"></div>


												</div>
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
		<!-- page specific plugin scripts -->
		<script src="assets/js/jquery.dataTables.min.js"></script>
		<script src="assets/js/jquery.dataTables.bootstrap.min.js"></script>
		<script src="assets/js/dataTables.buttons.min.js"></script>
		<script src="assets/js/buttons.flash.min.js"></script>
		<script src="assets/js/buttons.html5.min.js"></script>
		<script src="assets/js/buttons.print.min.js"></script>
		<script src="assets/js/buttons.colVis.min.js"></script>
		<script src="assets/js/dataTables.select.min.js"></script>

		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
				<script type="text/javascript">
			jQuery(function($) {
				//initiate dataTables plugin
				var myTable = 
				$('#dynamic-table')
				//.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
				.DataTable( {
					bAutoWidth: false,
					"aoColumns": [
					  { "bSortable": true },
					  null, null,null, null, null,null,
					  { "bSortable": true }
					],
					"aaSorting": [],
					
					
					//"bProcessing": true,
			        //"bServerSide": true,
			        //"sAjaxSource": "http://127.0.0.1/table.php"	,
			
					//,
					//"sScrollY": "200px",
					//"bPaginate": false,
			
					//"sScrollX": "100%",
					//"sScrollXInner": "120%",
					//"bScrollCollapse": true,
					//Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
					//you may want to wrap the table inside a "div.dataTables_borderWrap" element
			
					//"iDisplayLength": 50
			
			
					select: {
						style: 'multi'
					}
			    } );
			
				
				
				$.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';
				
				new $.fn.dataTable.Buttons( myTable, {
					buttons: [
					  {
						"extend": "colvis",
						"text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>Show/hide columns</span>",
						"className": "btn btn-white btn-primary btn-bold",
						columns: ':not(:first):not(:last)'
					  },
					  {
						"extend": "copy",
						"text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copy to clipboard</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "csv",
						"text": "<i class='fa fa-database bigger-110 orange'></i> <span class='hidden'>Export to CSV</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "excel",
						"text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "pdf",
						"text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "print",
						"text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
						"className": "btn btn-white btn-primary btn-bold",
						autoPrint: false,
						message: 'This print was produced using the Print button for DataTables'
					  }		  
					]
				} );
				myTable.buttons().container().appendTo( $('.tableTools-container') );
				
				//style the message box
				var defaultCopyAction = myTable.button(1).action();
				myTable.button(1).action(function (e, dt, button, config) {
					defaultCopyAction(e, dt, button, config);
					$('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
				});
				
				
				var defaultColvisAction = myTable.button(0).action();
				myTable.button(0).action(function (e, dt, button, config) {
					
					defaultColvisAction(e, dt, button, config);
					
					
					if($('.dt-button-collection > .dropdown-menu').length == 0) {
						$('.dt-button-collection')
						.wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
						.find('a').attr('href', '#').wrap("<li />")
					}
					$('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
				});
			
				////
			
				setTimeout(function() {
					$($('.tableTools-container')).find('a.dt-button').each(function() {
						var div = $(this).find(' > div').first();
						if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
						else $(this).tooltip({container: 'body', title: $(this).text()});
					});
				}, 500);
				
				
				
				
				
				myTable.on( 'select', function ( e, dt, type, index ) {
					if ( type === 'row' ) {
						$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', true);
					}
				} );
				myTable.on( 'deselect', function ( e, dt, type, index ) {
					if ( type === 'row' ) {
						$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', false);
					}
				} );
			
			
			
			
				/////////////////////////////////
				//table checkboxes
				$('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);
				
				//select/deselect all rows according to table header checkbox
				$('#dynamic-table > thead > tr > th input[type=checkbox], #dynamic-table_wrapper input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header
					
					$('#dynamic-table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) myTable.row(row).select();
						else  myTable.row(row).deselect();
					});
				});
				
				//select/deselect a row when the checkbox is checked/unchecked
				$('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
					var row = $(this).closest('tr').get(0);
					if(this.checked) myTable.row(row).deselect();
					else myTable.row(row).select();
				});
			
			
			
				$(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
					e.stopImmediatePropagation();
					e.stopPropagation();
					e.preventDefault();
				});
				
				
				
				//And for the first simple table, which doesn't have TableTools or dataTables
				//select/deselect all rows according to table header checkbox
				var active_class = 'active';
				$('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header
					
					$(this).closest('table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
						else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
					});
				});
				
				//select/deselect a row when the checkbox is checked/unchecked
				$('#simple-table').on('click', 'td input[type=checkbox]' , function(){
					var $row = $(this).closest('tr');
					if($row.is('.detail-row ')) return;
					if(this.checked) $row.addClass(active_class);
					else $row.removeClass(active_class);
				});
			
				
			
				/********************************/
				//add tooltip for small view action buttons in dropdown menu
				$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				
				//tooltip placement on right or left
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('table')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					//var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
				
				
				
				
				/***************/
				$('.show-details-btn').on('click', function(e) {
					e.preventDefault();
					$(this).closest('tr').next().toggleClass('open');
					$(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
				});
				/***************/
				
				
				
				
				
				/**
				//add horizontal scrollbars to a simple table
				$('#simple-table').css({'width':'2000px', 'max-width': 'none'}).wrap('<div style="width: 1000px;" />').parent().ace_scroll(
				  {
					horizontal: true,
					styleClass: 'scroll-top scroll-dark scroll-visible',//show the scrollbars on top(default is bottom)
					size: 2000,
					mouseWheelLock: true
				  }
				).css('padding-top', '12px');
				*/
			
			
			})
		</script>
	</body>
</html>
