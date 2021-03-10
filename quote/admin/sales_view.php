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
<!doctype html>
<html lang="en-US">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Sales View</title>
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
					<h1>Manage Sales</h1>
					<ol class="breadcrumb">
						<li><a href="sales.php">Manage Sales</a></li>
						<li class="active">Sales</li>
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
						<!-- panel content -->
						<div class="panel-body">
								<div class="row">
									<div class="col-sm-12">
                        <div class="card">
                            <div class="card-block">
                            	<div style="text-align:center;"><img src="uploads/<?php echo $company_logo;?>" width="280"><br />
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
								"orderable": true
							}, {
								"orderable": false
							}, {
								"orderable": false
							}, {
								"orderable": false
							}, {
								"orderable": false
							}, {
								"orderable": true
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