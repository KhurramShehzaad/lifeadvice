<?php
include 'includes/db_connect.php';

$id = $_REQUEST['id'];
$sale_q = mysqli_query($db, "SELECT * FROM `sales` WHERE `sales_id`='$id'");
$fetch = mysqli_fetch_assoc($sale_q);

$sales_id = $fetch['sales_id'];
$purchase_date = $fetch['purchase_date'];
$policy_id = $fetch['policy_id'];
$policy_title = $fetch['policy_title'];
$fname = $fetch['fname'];
$lname = $fetch['lname'];
$email = $fetch['email'];
$phone = $fetch['phone'];
$address = $fetch['address'];
$address_2 = $fetch['address_2'];
$city = $fetch['city'];
$postcode = $fetch['postcode'];
$country = $fetch['country'];
$home_address = $fetch['home_address'];
$home_address_2 = $fetch['home_address_2'];
$home_city = $fetch['home_city'];
$home_province = $fetch['home_province'];
$home_zip = $fetch['home_zip'];
$billing_province = $fetch['billing_province'];
$home_country = $fetch['home_country'];
$pre_exe = $fetch['pre_exe'];
$deductible = $fetch['deductible'];
$deductible_rate = $fetch['deductible_rate'];
$benefit = $fetch['benefit'];
$duration = $fetch['duration'];
$age = $fetch['age'];
$product = $fetch['product'];
$trip_type = $fetch['trip_type'];
$plan = $fetch['plan'];
$trip_dest = $fetch['trip_dest'];
$supervisa = $fetch['supervisa'];
$tripcost = $fetch['tripcost'];
$dob = $fetch['dob'];
$start_date = $fetch['start_date'];
$end_date = $fetch['end_date'];
$cancel_date = $fetch['cancel_date'];
$departure_date = $fetch['departure_date'];
$arrival_date = $fetch['arrival_date'];
$return_date = $fetch['return_date'];
$smoking = $fetch['smoking'];
$province = $fetch['province'];
$additional_travellers = $fetch['additional_travellers'];
$price = $fetch['price'];
$daily_price = $fetch['daily_price'];
$price_total = $fetch['price_total'];
$price_payable = $fetch['price_payable'];
$eligible = $fetch['eligible'];
$policy_type = $fetch['policy_type'];
$elder_age = $fetch['elder_age'];
$family_plan = $fetch['family_plan'];
$policy_status = $fetch['policy_status'];
$broker = $fetch['broker'];
$agent = $fetch['agent'];
$transaction_type = $fetch['transaction_type'];
$transaction_reason = $fetch['transaction_reason'];
$gross_comm_rate = $fetch['gross_comm_rate'];
$user_ip = $fetch['user_ip'];

//Company details:
$company_q = mysqli_query($db, "SELECT * FROM `wp_dh_companies` WHERE `comp_id`=(SELECT `insurance_company` FROM `wp_dh_insurance_plans` WHERE `id`='$policy_id')");
$company_f = mysqli_fetch_assoc($company_q);
$company_logo = $company_f['comp_logo'];

$today = strtotime(date('Y-m-d'));
$st_date = strtotime($start_date);
												
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


if($fetch['product'] == '1'){
$policytype = 'SVI';
} else if($fetch['product'] == '2'){
$policytype = 'VTC';
} else if($fetch['product'] == '3'){
$policytype = 'SI';
} else if($fetch['product'] == '4'){
$policytype = 'IFC';
} else if($fetch['product'] == '5'){
$policytype = 'ST';
} else if($fetch['product'] == '6'){
$policytype = 'MT';
} else if($fetch['product'] == '7'){
$policytype = 'AI';
} else if($fetch['product'] == '8'){
$policytype = 'TII';
} else if($fetch['product'] == '9'){
$policytype = 'BC';
}

$policy_number_temp = 10000000 + $fetch['sales_id'];
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
//checking policy status ended
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Sales View</title>

		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- page specific plugin styles -->

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
<style>
.btn-group-xs > .btn, .btn-xs { line-height:1; }
.nav-list > li { display:inline-block !important; }
</style>	
	</head>

	<body class="no-skin">
	<?php include 'header.php'; ?>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

	<?php include 'sales_sidebar.php'; ?>
	
			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="#">Home</a>
							</li>

							<li>
								<a href="#">Sales</a>
							</li>
							<li class="active">Manage Sales</li>
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
								Sales
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Manage Sales
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->


								<div class="row">
									<div class="col-sm-12">
                        <div class="card">
                            <div class="card-block">
                            	<div style="text-align:center;"><img src="<?php echo $company_logo;?>" width="280"><br />
                                <h1 style="font-size:24px; display:inline-block;"><strong><?php echo $policy_title; ?></strong></h1>
                                </div>
                                <div style="clear:both; height:40px;"><hr/></div>
                                <h4><strong>Policy Details</strong></h4>
                                <div class="table-responsive">
                                	<table class="table">
                                        <tbody>
                                            <tr>
                                                <td bgcolor="#F6F6F6"><strong>Policy Number:</strong></td>
                                                <td><?php echo $policy_number;?></td>
                                                <td bgcolor="#F6F6F6"><strong>Purchase Date:</strong></td>
                                                <td><?php echo $purchase_date;?></td>  
                                            </tr>
                                            <tr>
                                                <td bgcolor="#F6F6F6"><strong>Policy Status:</strong></td>
                                                <td style="color:<?php echo $status_color; ?>"><strong><?php echo ucwords(strtolower($status));?></strong></td>
                                                <td bgcolor="#F6F6F6"><strong>Cancel Date:</strong></td>
                                                <td style="color:#c00;"><?php echo $cancel_date;?></td>  
                                            </tr>
                                            <tr>
                                                <td bgcolor="#F6F6F6"><strong>Duration:</strong></td>
                                                <td><?php echo $duration;?> Days (<?php echo $start_date;?> - <?php echo $end_date; ?>)</td>
                                                <td bgcolor="#F6F6F6"><strong>Total Price:</strong></td>
                                                <td>$<?php echo number_format($price_total,2);?></td>  
                                            </tr>
                                            <tr>
                                                <td bgcolor="#F6F6F6"><strong>Coverage Amount:</strong></td>
                                                <td>$<?php echo number_format($benefit); ?></td>
                                                <td bgcolor="#F6F6F6"><strong>Deductible:</strong></td>
                                                <td>$<?php echo $deductible; ?> @ <?php echo $deductible_rate - 100; ?>%</td>  
                                            </tr>
                                        </tbody>
                                       
                                    </table>
                                </div>
                                <h4><strong>Primary Insured Details:</strong> <button type="button" class="btn btn-xs btn-primary" onClick="window.location='sales_edit_traveller.php?id=<?php echo $_REQUEST['id'];?>'"><i class="fa fa-pencil"></i> Edit Details</button></h4>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td bgcolor="#F6F6F6"><strong>Name:</strong></td>
                                                <td><?php echo $fname.' '.$lname;?></td>
                                                <td bgcolor="#F6F6F6"><strong>Age/DOB:</strong></td>
                                                <td><?php echo $age;?> years</td>  
                                            </tr>
                                            <tr>
                                                <td bgcolor="#F6F6F6"><strong>Email:</strong></td>
                                                <td><?php echo $email;?></td>
                                                <td bgcolor="#F6F6F6"><strong>Phone:</strong></td>
                                                <td><?php echo $phone;?></td>  
                                            </tr>
                                            <tr>
                                                <td bgcolor="#F6F6F6"><strong>Address:</strong></td>
                                                <td><?php echo $address.' '.$city.', '.$postcode.' '.$billing_province;?></td>
                                                <td bgcolor="#F6F6F6"><strong>Country:</strong></td>
                                                <td><?php echo $country;?></td>  
                                            </tr>
                                             <!--<tr>
                                                <td bgcolor="#F6F6F6"><strong>Price:</strong></td>
                                                <td>$<?php echo number_format($price,2);?></td>
                                                <td><strong>Daily Price</strong></td>
                                                <td>$<?php echo $daily_price; ?>/day</td>
                                            </tr>-->
                                        </tbody>
                                    </table>
                                </div>
                                <!--<h4><strong>Additional Insured Details:</strong></h4>-->
                                <div class="table-responsive" style="display:none;">
                                    <table class="table">
                                    	<thead>
                                        	<tr bgcolor="#F9F9F9">
                                            	<th><strong>SrNo</strong></th>
                                                <th><strong>Policy Number</strong></th>
                                                <th><strong>Name</strong></th>
                                                <th><strong>Age/DOB</strong></th>
                                                <th><strong>Relationship</strong></th>
                                                <th><strong>Start & End Dates</strong></th>
                                                <th><strong>Premium/Price</strong></th>
                                                <th><strong>Edit Details</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
										$sr = 0;
										if($eligible == 'yes'){
										$total_charges = $price;
										}
										else {
										$total_charges = 0;
										}
										$add_q = mysqli_query($db, "SELECT * FROM `sales` WHERE `parent_sales_id`='$sales_id' AND `eligible`='yes' ORDER BY `sales_id`");
										while($add_f = mysqli_fetch_assoc($add_q)){
										$sr++;
										?>
                                            <tr>
                                            	<td><?php echo $sr;?></td>
                                                <td><?php echo $add_f['policy_number'];?></td>
                                                <td><?php echo $add_f['fname'].' '.$add_f['lname'];?></td>
                                                <td><?php echo $add_f['age'];?>years (<?php echo $add_f['dob'];?>)</td>
                                                <td><?php echo $add_f['relation'];?></td>
                                                <td><?php echo $add_f['start_date'];?> - <?php echo $add_f['end_date'];?></td> 
                                                <td>$<?php echo number_format($add_f['price'],2);?></td>
                                                <td><button type="button" class="btn-primary btn btn-xs" onClick="window.location='sales_edit_traveller.php?id=<?php echo $add_f['sales_id'];?>'"><i class="fa fa-pencil"></i> Edit Details</button></td>
                                            </tr>
                                         <?php } ?>   
                                        </tbody>
                                    </table>
                                </div>
                                <h4><strong>Payment Details:</strong></h4>
                                <div class="table-responsive">
                                    <table class="table">
                                    	<thead>
                                        	<tr bgcolor="#F9F9F9">
                                            	<th><strong>Date</strong></th>
                                                <th><strong>Description</strong></th>
                                                <th><strong>Payment Type</strong></th>
                                                <th><strong>Amount</strong></th>
                                                <th><strong>Reference Num</strong></th>
                                                <th><strong>Sub Total</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
										$balance = 0;
										$pay_q = mysqli_query($db, "SELECT * FROM `sales_transactions` WHERE `sales_id`='$sales_id' ORDER BY `dated` ASC");
										while($pay_f = mysqli_fetch_assoc($pay_q)){
										$payment_id = $pay_f['payment_id'];
										$sales_id = $pay_f['sales_id'];
										$datetime = $pay_f['dated'];
										$desc = $pay_f['description'];
										$payment_type = $pay_f['payment_type'];
										$amount = $pay_f['amount'];

										if($payment_type == 'payment'){
										$balance += $amount;
										}else if($payment_type == 'refund'){
										$balance -= $amount;	
										}
										?>
                                            <tr>
                                            	<td><?php echo $datetime;?></td>
                                                <td><?php echo $desc;?></td>
                                                <td><?php echo ucwords(strtolower($payment_type)); ?></td>
												<td><?php echo 10000000 + $sales_id;?></td>
                                                <td>$<?php echo number_format($amount,2);?></td>
                                                <td><strong>$<?php echo number_format($balance,2);?></strong></td>
                                            </tr>
                                         <?php } ?>
                                            <!--<tr bgcolor="#F9F9F9">
                                            	<td colspan="2">&nbsp;</td>
                                                <td><strong>Balance</strong> </td>
                                                <td style="border-top: 1px solid; border-bottom: 2px solid;"><strong>$ <?php echo number_format($balance,2);?></strong></td>
                                                <td>&nbsp;</td>
                                            </tr>-->   
                                        </tbody>
                                    </table>
                                </div>
                                <h4><strong>Policy Amendments:</strong></h4>
                                <div class="table-responsive">
                                    <table class="table">
                                    	<thead>
                                        	<tr bgcolor="#F9F9F9">
                                            	<th><strong>Date</strong></th>
                                                <th><strong>Amendment Type</strong></th>
                                                <th><strong>Old Value</strong></th>
                                                <th><strong>Requested By</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
										$amends_q = mysqli_query($db, "SELECT * FROM `sales_amendments` WHERE `sales_id`='$sales_id'");
										while($amends_f = mysqli_fetch_assoc($amends_q)){
$user_query = mysqli_query($db, "SELECT * FROM `users` WHERE `id`='".$amends_f['requestedby']."'");
$user_fetch = mysqli_fetch_assoc($user_query);
$user_id = $user_fetch['id'];
$user_fname = $user_fetch['fname'];
$user_lname = $user_fetch['lname'];
$amend_type = $amends_f['amend_type'];

										?>
                                        	<tr>
                                            	<td><?php echo $amends_f['dated'];?></td>
                                                <td><?php echo $amend_type;?></td>
                                                <td><?php echo $amends_f['old_value'];?></td>
                                                <td><?php echo $user_fname.' '.$user_lname;?></td>
                                           </tr>
                                        <?php } ?>   
                                        </tbody>
                                     </table>
                                </div>
                                        
                                <h4><strong>Policy Notes:</strong></h4>
                                <div class="table-responsive">
                                    <table class="table">
                                    	<thead>
                                        	<tr bgcolor="#F9F9F9">
                                            	<th><strong>Date</strong></th>
                                                <th><strong>Comment</strong></th>
                                                <th><strong>Author</strong></th>
                                                <th><strong>Action</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
										$comm_q = mysqli_query($db, "SELECT * FROM `comments` WHERE `sales_id`='".$_REQUEST['id']."'");
										while($comm_f = mysqli_fetch_assoc($comm_q)){
										$comment = $comm_f['comment'];
										?>
                                        	<tr>
                                            	<td><?php echo $comm_f['dated']; ?></td>
                                                <td><?php echo $comm_f['comment']; ?></td>
                                                <td><?php echo $comm_f['user_name']; ?></td>
                                                <td><a href="add_note.php?action=edit&id=<?php echo $_REQUEST['id'];?>&note=<?php echo $comm_f['id']; ?>" class="link"><i class="icon-pencil"></i> <font class="font-medium">Edit</font></a> <a href="add_note.php?action=del&id=<?php echo $_REQUEST['id'];?>&note=<?php echo $comm_f['id']; ?>" onClick="return confirm('Are you sure you want to delete ?');" class="link"><i class="icon-trash"></i> <font class="font-medium">Delete</font></a></td>
                                           </tr> 
                                        <?php } ?>       
                                        </tbody>
                                     </table>
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

<?php include 'footer.php'; ?>

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
					  { "bSortable": false },
					  null, null,null, null, null,
					  { "bSortable": false }
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
