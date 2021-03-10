<?php
include 'includes/db_connect.php';
if($sess_user_type =='agent'){
echo "<script>window.location='dashboard.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Commissions Report</title>

		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- page specific plugin styles 
		<link rel="stylesheet" href="assets/css/jquery-ui.custom.min.css" />
		<link rel="stylesheet" href="assets/css/jquery.gritter.min.css" />
		<link rel="stylesheet" href="assets/css/select2.min.css" />-->

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

		<!-- ace settings handler 
		<script src="assets/js/ace-extra.min.js"></script>-->

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
<link rel="stylesheet" href="assets/datepicker/jquery-ui.css">
<script src="assets/datepicker/jquery-1.12.4.js"></script>
<script src="assets/datepicker/jquery-ui.js"></script>
<script>
$( function() {
$( "#start_date" ).datepicker({
  changeMonth: true,
      changeYear: true,
	  dateFormat: 'yy-mm-dd',
	  yearRange: "-100:+0",
});
} );
$( function() {
$( "#end_date" ).datepicker({
  changeMonth: true,
      changeYear: true,
	  dateFormat: 'yy-mm-dd',
	  yearRange: "-100:+0",
});
} );
</script>
<style>
.ui-widget.ui-widget-content {
	width: auto;
}
</style>
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
								<a href="#">Manage Reports</a>
							</li>
							<li class="active">Commission Statement</li>
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
								Commission Statement
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Check out your commissions:
								</small>
								
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<h4 class="red">
									<span class="middle"><strong>Broker Commission Statement</strong></span>
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
                                            <td><input type="text" name="start_date" class="form-control" id="start_date" value="<?php echo $_POST['start_date'];?>" required></td>
                                            <td><input type="text" name="end_date" class="form-control" id="end_date" value="<?php echo $_POST['end_date'];?>" required></td>
											<td><select class="chosen-select form-control" name="seller" id="seller" data-placeholder="Select Seller">
                                            <?php if($sess_user_type == 'admin'){?>
                                            <option <?php if($_POST['seller'] == 'admin'){?> selected <?php } ?> value="admin">Select All</option>
                                            <?php $broker_q = mysqli_query($db, "SELECT * FROM `users` WHERE `user_type`='broker' AND `pay_commission`='yes' ORDER BY `fname`");
											while($broker_f = mysqli_fetch_assoc($broker_q)){
											?>
                                            <option <?php if($_POST['seller'] == 'b_'.$broker_f['id']){?> selected <?php } ?> value="b_<?php echo $broker_f['id'];?>"><?php echo $broker_f['fname'].' '.$broker_f['lname'].' - '.$broker_f['unique_code'];?></option>
                                            <?php } ?>
                                            <?php } else if($sess_user_type == 'broker'){?>
                                            <option <?php if($_POST['seller'] == $sess_unique_code){?> selected <?php } ?> value="<?php echo $sess_unique_code;?>"><?php echo $sess_fname.' '.$sess_lname.' - '.$sess_unique_code;?></option>
                                            <?php } ?>
											</select>
														</td>
                                            <td><input type="button" class="btn btn-success" style="padding: 2px;" value="Generate Report" onClick="generatereport()"> <?php if($_REQUEST['action'] == 'done'){?><!--<button type="button" style="padding: 2px;" class="btn btn-primary" onClick="downloadpdf()"><i class="fa fa-file"></i> Export Excl</button>--> <?php } ?></td>
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
					
					</div><!-- /.page-content -->
				
							</div>
			</div><!-- /.main-content -->

			<?php include 'footer.php';?>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> 
		<script src="assets/js/jquery-2.1.4.min.js"></script>-->

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
		<![endif]
		<script src="assets/js/jquery-ui.custom.min.js"></script>
		<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="assets/js/jquery.gritter.min.js"></script>
		<script src="assets/js/bootbox.js"></script>
		<script src="assets/js/jquery.easypiechart.min.js"></script>
		<script src="assets/js/bootstrap-datepicker.min.js"></script>
		<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
		<script src="assets/js/jquery.hotkeys.index.min.js"></script>
		<script src="assets/js/bootstrap-wysiwyg.min.js"></script>
		<script src="assets/js/select2.min.js"></script>
		<script src="assets/js/spinbox.min.js"></script>-->
		<!--<script src="assets/js/bootstrap-editable.min.js"></script>
		<script src="assets/js/ace-editable.min.js"></script>
		<script src="assets/js/jquery.maskedinput.min.js"></script>-->

		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

		<script type="text/javascript">
function checkavailable()
{
document.getElementById('username_check').innerHTML = 'Please wait...';

		
var username = document.getElementById('username').value;
 $.ajax({
 type: 'get',
 url: 'get_username.php',
 data: {
 get_option: username,
 },
 success: function (response) {
	 if(response >= 1){
		document.getElementById('username_check').innerHTML = '<i class="fa fa-check fa-lg red"></i> Unavailable'; 
		document.getElementById('submitbtn').disabled = true;
	 } else {
		document.getElementById('username_check').innerHTML = '<i class="fa fa-check fa-lg green"></i> Available';  
		document.getElementById('submitbtn').disabled = false;
	 }
// document.getElementById("username_check").innerHTML=response; 
 }
 });
}

"^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}"
function validatePassword() {
    var newPassword = document.getElementById('password').value;
    var minNumberofChars = 8;
    var maxNumberofChars = 16;
    var regularExpression  = /^(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}/;
    //alert(newPassword); 
    if(newPassword.length < minNumberofChars || newPassword.length > maxNumberofChars){
        document.getElementById('password_check').innerHTML = '<i class="fa fa-check fa-lg red"></i> Minimum 8 character required';
		document.getElementById('submitbtn').disabled = true;
    } else 
    if(!regularExpression.test(newPassword)) {
        //alert("password should contain atleast one number and one special character");
		document.getElementById('password_check').innerHTML = '<i class="fa fa-check fa-lg red"></i> Atleast one capitalized character, one number and one special character required';
		document.getElementById('submitbtn').disabled = true;
        return false;
    } else {
		document.getElementById('submitbtn').disabled = false;
		document.getElementById('password_check').innerHTML = '<i class="fa fa-check fa-lg green"></i> Valid Password';
	}
}
</script>
		
	</body>
</html>
