<?php
//error_reporting(E_ALL);
session_start();
include 'includes/db_connect.php';
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
		<title>Agent Commission Report</title>
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
					<h1>Manage Reports</h1>
					<ol class="breadcrumb">
						<li><a href="#">Reports</a></li>
						<li class="active">Broker Commissions Report</li>
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
								<strong>Agent Commission Report</strong> <!-- panel title -->
							</span>
							</div>
						</div>
						<!-- panel content -->
						<div class="panel-body">
							
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<h4 class="red">
									<span class="middle"><strong>Agent Commission Statement</strong></span>
								</h4>
								    <div class="card">
                        
                            <div class="table-responsive">
                            <form method="post" action="?action=done" id="form">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th colspan="2"><strong><i class="fa fa-calendar"></i> Dates Between</strong></th>
                                                <th colspan="2"><strong><i class="fa fa-user"></i> Select Seller</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><input type="text" name="start_date" style="height:39px;" class="form-control datepicker" id="start_date" value="<?php echo $_POST['start_date'];?>" required></td>
                                            <td><input type="text" name="end_date" style="height:39px;" class="form-control datepicker" id="end_date" value="<?php echo $_POST['end_date'];?>" required></td>
											<td><select class="chosen-select form-control" name="seller" id="seller" data-placeholder="Select Seller">
                                            <?php if($sess_user_type == 'admin'){?>
                                            <option <?php if($_POST['seller'] == 'admin'){?> selected <?php } ?> value="admin">Select All</option>
                                            <?php $agent_q = mysqli_query($db, "SELECT * FROM `users` WHERE `user_type`='agent' AND `pay_commission`='yes' ORDER BY `fname`");
											while($agent_f = mysqli_fetch_assoc($agent_q)){
											?>
                                            <option <?php if($_POST['seller'] == $agent_f['unique_code']){?> selected <?php } ?> value="<?php echo $agent_f['unique_code'];?>"><?php echo $agent_f['fname'].' '.$agent_f['lname'].' - '.$agent_f['unique_code'];?></option>
                                            <?php } ?>
                                            <?php } else if($sess_user_type == 'broker'){?>
                                            <option <?php if($_POST['seller'] == $sess_unique_code){?> selected <?php } ?> value="<?php echo $sess_unique_code;?>"><?php echo $sess_fname.' '.$sess_lname.' - '.$sess_unique_code;?></option>
                                            <?php } ?>
											</select>
														</td>
                                            <td><input type="button" class="btn btn-success" value="Generate Report" onClick="generatereport()"> <?php if($_REQUEST['action'] == 'done'){?><!--<button type="button" style="padding: 2px;" class="btn btn-primary" onClick="downloadpdf()"><i class="fa fa-file"></i> Export Excl</button>--> <?php } ?></td>
                                        </tr>                           
                                      </tbody>
                                    </table>
                            </form>        
                                </div>
<script>
function downloadpdf(){
document.getElementById('form').action = 'excel.php?start='+ document.getElementById('start_date').value + '&end=' + document.getElementById('end_date').value;
$("#form").attr('target', '_blank');
document.getElementById('form').submit();	
}

function generatereport(){
document.getElementById('form').action = '?action=done';
$("#form").attr('target', '');
document.getElementById('form').submit();	
}
</script>                                
                                
<?php if($_REQUEST['action'] == 'done'){?>
								<div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr bgcolor="#F1F1F1">
												<th>Transaction Date</th>
                                                <th>Policy Number</th>
                                                <th>Client Name</th>
                                                <th>Client Contact</th>
                                                <th>Start Date</th>
                                                <th>Expiry Date</th>
												<th>Broker Code</th>
												<th>Agent Code</th>
                                                <th>Transaction Type</th>
                                                <th>Medical Benefit</th>
												<th>Deductible</th>
												<th>Policy Premium</th>
                                                <th>Commission</th>
												<th>Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
										$post_seller = explode('_',$_POST['seller']);
										$ps = $post_seller[0];
										$p_s = $post_seller[1];
										
										if($ps == 'admin'){
										$inquery = "";	
										}
										else if($ps == 'b'){
										$inquery = "  AND `agent_code` IN (select  `unique_code`
										from    (select * from `users`
										order by parent_id, id) products_sorted,
										(select @pv := ".$p_s.") initialisation
										where   find_in_set(parent_id, @pv)
										and     length(@pv := concat(@pv, ',', id)))
										";
										}
										else if($ps == 'all'){
										$inquery = "  AND `agent_code` IN (select  `unique_code`
										from    (select * from `users`
										order by parent_id, id) products_sorted,
										(select @pv := ".$_SESSION['portal_id'].") initialisation
										where   find_in_set(parent_id, @pv)
										and     length(@pv := concat(@pv, ',', id)))
										";
										} else {
										$inquery = " AND `agent_code`='".$ps."'";	
										}
										//echo $inquery;
										$subtotal = '';
										$trans_q = mysqli_query($db, "SELECT * FROM `sales_transactions` WHERE `dated`>='".$_POST['start_date']." 00:00:00' AND `dated`<='".$_POST['end_date']." 23:59:59' $inquery ORDER BY `sales_transactions`.`id` ASC");
										while($trans_f = mysqli_fetch_assoc($trans_q)){
										$trans_date =  date('d-M-Y', strtotime($trans_f['dated']));
										$payment_id = $trans_f['id'];
										$sale_id = $trans_f['sales_id'];
										$desc = $trans_f['description'];
										$payment_type = $trans_f['payment_type'];
										$amount = $trans_f['amount'];
										$agent_code = $trans_f['agent_code'];
										
									
										if($payment_type == 'payment'){
										$trans_class = '';
										$subtotal += $amount;										
										}
										else if($payment_type == 'refund'){
										$trans_class = 'danger';
										$subtotal -= $amount;
										}								

										$s_q = mysqli_query($db, "SELECT * FROM `sales` WHERE `sales_id`='$sale_id'");
										$s_f = mysqli_fetch_assoc($s_q);
										$sales_id = $s_f['sales_id'];
										$purchase_date = date('d-M-Y', strtotime($s_f['purchase_date']));
										$policy_id = $s_f['policy_id'];
										$policy_title = $s_f['policy_title'];
										$fname = $s_f['fname'];
										$lname = $s_f['lname'];
										$email = $s_f['email'];
										$phone = $s_f['phone'];
										$address = $s_f['address'];
										$address_2 = $s_f['address_2'];
										$city = $s_f['city'];
										$postcode = $s_f['postcode'];
										$country = $s_f['country'];
										$home_address = $s_f['home_address'];
										$home_address_2 = $s_f['home_address_2'];
										$home_city = $s_f['home_city'];
										$home_province = $s_f['home_province'];
										$home_country = $s_f['home_country'];
										$pre_exe = $s_f['pre_exe'];
										$deductible = $s_f['deductible'];
										$deductible_rate = $s_f['deductible'];
										$benefit = $s_f['benefit'];
										$duration = $s_f['duration']; 
										$age = $s_f['age'];
										$product = $s_f['product'];
										$trip_type = $s_f['trip_type'];
										$plan = $s_f['plan'];
										$trip_dest = $s_f['trip_dest'];
										$supervisa = $s_f['supervisa'];
										$tripcost = $s_f['tripcost'];
										$dob = date('d-M-Y', strtotime($s_f['dob']));
										$start_date = date('d-M-Y', strtotime($s_f['start_date']));
										$end_date = date('d-M-Y', strtotime($s_f['end_date']));
										$cancel_date = date('d-M-Y', strtotime($s_f['cancel_date']));
										$smoking = $s_f['smoking'];
										$province = $s_f['province'];
										$additional_travellers = $s_f['additional_travellers'];
										$price = $s_f['price'];
										$daily_price = $s_f['daily_price'];
										$price_total = $s_f['price_total'];
										$price_payable = $s_f['price_payable'];
										$eligible = $s_f['eligible'];
										$policy_type = $s_f['policy_type'];
										$elder_age = $s_f['elder_age'];
										$family_plan = $s_f['family_plan'];
										$policy_status = $s_f['policy_status'];
										$broker = $s_f['broker'];
										$agent = $s_f['agent'];
										$gross_comm_rate =  $s_f['gross_comm_rate'];
										$sales_tax = $s_f['sales_tax'];
										$parent_sales_id = $s_f['parent_sales_id'];
										
										if($s_f['product'] == '1'){
										$policytype = 'SVI';
										} else if($s_f['product'] == '2'){
										$policytype = 'VTC';
										} else if($s_f['product'] == '3'){
										$policytype = 'SI';
										} else if($s_f['product'] == '4'){
										$policytype = 'IFC';
										} else if($s_f['product'] == '5'){
										$policytype = 'ST';
										} else if($s_f['product'] == '6'){
										$policytype = 'MT';
										} else if($s_f['product'] == '7'){
										$policytype = 'AI';
										} else if($s_f['product'] == '8'){
										$policytype = 'TII';
										} else if($s_f['product'] == '9'){
										$policytype = 'BC';
										}
																					
										$policy_number_temp = 10000000 + $s_f['sales_id'];
										$policy_number = $policytype.$policy_number_temp;
										
									
										//$gross_commission = ($gross_comm_rate * $amount)/ 100;
										
										//Agent Details
										if($agent !='0'){
										$agnt_q = mysqli_query($db, "SELECT * FROM `users` WHERE `unique_code`='$agent'");
										$agnt_f = mysqli_fetch_assoc($agnt_q);
										$agnt_id = $agnt_f['id'];
										$agnt_name = $agnt_f['fname'].' '.$agnt_f['lname'];
										$agnt_parent = $agnt_f['parent_id'];
										}
										
										//Broker Details
										if($agnt_parent != '0' || $agnt_parent != ''){
										$bro_q = mysqli_query($db, "SELECT * FROM `users` WHERE `id`='$agnt_parent'");
										$bro_f = mysqli_fetch_assoc($bro_q);
										$broker_id = $agnt_parent;
										$bro_name = $bro_f['fname'].' '.$bro_f['lname'];
										$broker_code = $bro_f['unique_code'];
										}else { 
										$broker_code = '1';
										}
										?>
                                            <tr class="<?php echo $trans_class;?>">
                                                <td><?php echo $trans_date; ?></td>
                                                <td><?php echo $policy_title;?><br/><a href="sales_view.php?id=<?php echo $sales_id;?>" target="_blank"><?php echo $policy_number; ?></a></td>
                                                <td><?php echo $fname.' '.$lname; ?></td>
												<td><?php echo $email.'<br/>'.$phone; ?></td>
                                                <td><?php echo $start_date; ?></td>
                                                <td><?php echo $end_date; ?></td>
                                                <td><?php echo $broker_code; ?></td>
												<td><?php echo $agent; ?></td>
                                                <td><?php echo ucwords(strtolower($payment_type)); ?></td>
                                                <td>$<?php echo $benefit; ?></td>
                                                <td>$<?php echo $deductible; ?></td>
                                                <td>$<?php echo number_format($amount,2); ?></td>
                                                <td>$0.00</td>
                                                <td><strong>$<?php echo number_format($subtotal,2); ?></strong></td>
                                            </tr> 
										<?php } ?> 
											<tr bgcolor="#F1F1F1">
												<th colspan="11" style="font-size:15px; font-weight:bold; text-align:right;">Grand Total</th>
												<th style="font-size:15px; font-weight:bold; text-align:right;">$<?php echo number_format($subtotal,2); ?></th>
												<th style="font-size:15px; font-weight:bold; text-align:right;">$0.00</th>
												<th style="font-size:15px; font-weight:bold; text-align:right;">$<?php echo number_format($subtotal,2); ?></th>
											</tr>										
                                      </tbody>
                                    </table>        
                                </div>

								<?php } ?>
                                
                                
                        </div>
                    
								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->


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