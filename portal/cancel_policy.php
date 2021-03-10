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
$policy_number = $fetch['policy_number'];
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
$amendments = $fetch['amendments'];

$temp_daily_price = $price_payable / $duration;


//SYSTEM SETTINGS.
$colorid = '1';
$color_q = $dbp->prepare("SELECT * FROM `color_scheme` WHERE `id`=?");
$color_q->bind_param("i", $colorid);
$color_q->execute();
$color_q_results = $color_q->get_result(); 
$color_f = $color_q_results->fetch_assoc();
$sys_api_key = $color_f['api_key'];
$sys_merchant_id = $color_f['merchant_id'];


//CARD DETALLS
$cards_q = mysqli_query($db, "SELECT * FROM `sales_cards` WHERE `sales_id`='".$_REQUEST['id']."'");
$cards_f = mysqli_fetch_assoc($cards_q);

//Company details:
$company_q = mysqli_query($db, "SELECT * FROM `companies` WHERE `id`=(SELECT `company_id` FROM `policies` WHERE `id`='$policy_id')");
$company_f = mysqli_fetch_assoc($company_q);
$company = $company_f['company'];
$company_logo = $company_f['logo'];

if($_REQUEST['action'] == 'add'){
$comment = $_POST['comment'];
$sales_id = $_REQUEST['id'];
$user = $_POST['user'];
$user_name = $_POST['user_name'];
$cancel_date = $_POST['cancel_date'];

$replace = array("%", "$");
$adminfee = str_replace($replace, '', $_POST['adminfee']);

$tax_query = mysqli_query($db, "SELECT * FROM `provinces` WHERE `prov_abbr`='".$cards_f['billing_province']."' AND CURRENT_DATE>=`effective_date` AND CURRENT_DATE<=`expiry_date`");
$tax_num = mysqli_num_rows($tax_query);
$tax_fetch = mysqli_fetch_assoc($tax_query);
$tax_rate = str_replace('$','',$tax_fetch['taxes']);
if($tax_num > 0){
$tax = ($tax_rate * $adminfee) / 100;
}
else {
$tax = 0;	
}
$transaction_reason = $_POST['transaction_reason'];


//this is to use for confirmations
$additional_fee = $adminfee + $tax;
$price_difference = $price_payable - $additional_fee;

//PAYMENT API CALL
require '../quote/vendor/autoload.php';

$api_key = $sys_api_key; //INSERT API ACCESS PASSCODE
$merchant_id = $sys_merchant_id; //INSERT MERCHANT ID (must be a 9 digit string)
$api_version = 'v1'; //default
$platform = 'www'; //default
//Create Beanstream Gateway
$beanstream = new \Beanstream\Gateway($merchant_id, $api_key, $platform, $api_version);

$remaining_refund = $price_difference;
//GETTING TRANSACTION ID FOR REFUND
$trans_q = mysqli_query($db, "SELECT * FROM `sales_payments` WHERE `sales_id`='$sales_id' AND `payment_type`='payment' AND `amount`>='$price_difference'");
while($trans_f = mysqli_fetch_assoc($trans_q)){
$transaction_id = $trans_f['transid'];
$transaction_amount = $trans_f['amount'];

if($remaining_refund > 0){
try {
	$result = $beanstream->payments()->returnPayment($transaction_id, $transaction_amount , $policy_number);
	 //echo $result['approved'];
	 //print_r($result);
} catch (\Beanstream\Exception $e) {
	//print_r($e); 
	echo $e->getCode();
}
//Try to submit a Card Payment
if($result['approved'] == 1){
$trnId = $result['id'];
mysqli_query($db, "INSERT INTO `sales_payments`(`sales_id`, `desc`, `payment_type`, `amount`, `transid`, `transaction_type`, `transaction_reason`, `start_date`, `end_date`) VALUES ('$sales_id','Price Difference','refund','$price_difference','$trnId','update', 'date', '$eff_date', '$expiry_date')");	
}
}

$remaining_refund -= $transaction_amount;
} //while end

//ENDED PAYMENT API CALL

if($result['approved'] == 1){
$action = 'approved';
$errmsg = '';
//Adding to Payments
mysqli_query($db, "INSERT INTO `sales_payments`(`sales_id`, `desc`, `payment_type`, `amount`, `transaction_type`, `transaction_reason`, `pmt_status`, `start_date`, `end_date`) VALUES ('$sales_id','Policy Cancellation','refund','$price','cancel','$transaction_reason', 'cancel', '$start_date', '$end_date')");
if($adminfee > 0){
mysqli_query($db, "INSERT INTO `sales_payments`(`sales_id`, `desc`, `payment_type`, `amount`, `transaction_type`, `transaction_reason`, `pmt_status`, `start_date`, `end_date`) VALUES ('$sales_id','Cancellation Fee','fee','$adminfee','cancel','$transaction_reason', 'cancel', '$start_date', '$end_date')");
}
if($tax > 0){
mysqli_query($db, "INSERT INTO `sales_payments`(`sales_id`, `desc`, `payment_type`, `amount`, `transaction_type`, `transaction_reason`, `pmt_status`, `start_date`, `end_date`) VALUES ('$sales_id','Cancellation Tax','tax','$tax','cancel','$transaction_reason', 'cancel', '$start_date', '$end_date')");
}

//Editing Policy
mysqli_query($db, "UPDATE `sales` SET `transaction_reason`='$transaction_reason', `transaction_code`='CANCELLATION', `additional_fee`='$additional_fee', `premium_adjustment`='0', `refund`='$adjust_refund', `cancel_date`='$cancel_date', `policy_status`='cancel' WHERE `sales_id`='$sales_id'");

//or die(mysqli_error($db))

//Additional travellers Payments
$adi_q = mysqli_query($db, "SELECT * FROM `sales` WHERE `parent_sales_id`='$sales_id' AND `eligible`='yes' ORDER BY `sales_id`");
while($adi_f = mysqli_fetch_assoc($adi_q)){
$adi_sales_id = $adi_f['sales_id'];
$adi_policy_number = $adi_f['policy_number'];
$adi_price = $adi_f['price'];
mysqli_query($db, "INSERT INTO `sales_payments`(`sales_id`, `desc`, `payment_type`, `amount`, `transaction_type`, `transaction_reason`, `pmt_status`, `start_date`, `end_date`) VALUES ('$adi_sales_id','$adi_policy_number Policy Cancellation','refund','$adi_price','cancel','$transaction_reason', 'cancel', '$start_date', '$end_date')");

//Editing Policy
mysqli_query($db, "UPDATE `sales` SET `transaction_reason`='$transaction_reason', `transaction_code`='CANCELLATION', `additional_fee`='$additional_fee', `premium_adjustment`='0', `cancel_date`='$cancel_date', `policy_status`='cancel' WHERE `sales_id`='$adi_sales_id'");
}

$query = mysqli_query($db, "INSERT INTO `comments`(`sales_id`, `user`, `user_name`, `comment`) VALUES ('$sales_id','$user','$user_name','$comment')");


echo "<script>window.location='resend.php?id=".$sales_id."'</script>";
}

if($result['approved'] != 1){
$action = 'failed';	
$errmsg = $e->getMessage();
echo "<script>alert(".$errmsg.");</script>";
}

}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Sales View - AwayCare</title>

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
$( "#cancel_date" ).datepicker({
  changeMonth: true,
  changeYear: true,
  dateFormat: 'yy-mm-dd',
  yearRange: "+0:+5",
});
} );
$( function() {
$( "#expiry_date" ).datepicker({
  changeMonth: true,
  changeYear: true,
  dateFormat: 'yy-mm-dd',
  yearRange: "+0:+5",
});
} );
</script>
<style>
.ui-widget.ui-widget-content {width:auto; }
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
									Cancel
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
                        <h4 style="font-weight: bold; font-family: arial; color: #c00; text-decoration: none;">Cancel Policy (<?php echo $policy_number; ?>)</h4>
                       <form method="post" action="?action=add&id=<?php echo $_REQUEST['id']; ?>">
                        <div class="row">
                        	<div class="col-md-6">
							<div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" style="font-size: 14px; font-family:Arial, Helvetica, sans-serif; color:#444;">
                            <thead>
                            	<th colspan="2"><h3 style="font-weight: bold; font-family: arial; text-decoration: none; margin: 0px; font-size: 18px;">Enter Dates/Fees</h3><small id="error" class="text-danger"></small></th>
                            </thead>
                            <tbody>
                            	 <tr>
                                    	<td>Admin Fee ($)</td>
                                        <td><?php 
										$admin_fee_query = mysqli_query($db, "SELECT * FROM `provinces` WHERE `id`='$province'");
$admin_fee_fetch = mysqli_fetch_assoc($admin_fee_query);
$admin_fee = str_replace('$','',$admin_fee_fetch['admin_fee']);?>
<input type="text" value="<?php echo $admin_fee;?>" name="adminfee" id="adminfee" class="form-control" required></td>
                                   </tr>
                                <tr>
                                	<td><label><strong>Cancellation Date</strong></label></td>
                                    <td><input type="text" name="cancel_date" required id="cancel_date" value="" class="form-control"></td>
                                </tr>
                                <tr>
                                	<td><label><strong>Start Date</strong></label></td>
                                    <td><input type="text" readonly name="start_date" id="start_date" value="<?php echo $start_date;?>" class="form-control"></td>
                                </tr>
                                <tr>
                                	<td><label><strong>End Date</strong></label></td>
                                    <td><input type="text" name="end_date" id="end_date" readonly value="<?php echo $end_date;?>" class="form-control"></td>
                                </tr>
                                <tr>
                                	<td><label><strong>Number of Days</strong></label></td>
                                    <td><input type="text" name="duration" id="duration" readonly value="<?php echo $duration;?>" class="form-control"></td>
                                </tr>
                                <tr>
                                	<td><label><strong>Transaction Reason</strong></label></td>
                                    <td><select class="form-control" name="transaction_reason" id="transaction_reason" required>
                                        	<option value="">Select Reason</option>
                                            <option value="TCNG">Trip Cancelled - Not Going TCNG</option>
                                            <option value="TCBP">Trip Cancelled - Better Price Found TCBP</option>
                                            <option value="TCDI">Trip Cancelled - Death of Insured TCDI</option>
                                            <option value="TCUN">Trip Cancelled - Unknown TCUN</option>
                                            <option value="TCVR">Trip Cancelled - Visa Refused TCVR</option>
                                        </select></td>
                                </tr>
                                 <tr>
                                	<td><label><strong>Policy Premium ($)</strong></label></td>
                                    <td style="font-weight:bold; font-size:16px;">$<?php echo number_format($price_payable,2);?></td>
                                </tr>
                                <tr>
                                	<td><label><strong>Refund ($)</strong></label></td>
                                    <td><input type="text" name="refund" readonly id="refund" value="<?php echo str_replace(',','', number_format($price_payable,2));?>" class="form-control" style="font-size:18px; font-weight:bold;" required onKeyUp="durationcalculate()"></td>
                                </tr>
                            </tbody>
                            </table>
                        <!-- /panel content -->
						</div>
                        	</div>
                            <div class="col-md-6">
                            <div class="row">      
                             <div class="col-md-12">
                            <h3>Please explain the circumstances before cancel this policy.</h3>
                            <label><strong>Author</strong></label>
                            <input type="text" readonly class="form-control" value="<?php echo $sess_fname.' '.$sess_lname; ?>">
                                <input type="hidden" name="user" value="<?php echo $sess_id;?>">
                                <input type="hidden" name="user_name" value="<?php echo $sess_fname.' '.$sess_lname; ?>">
                            <label><strong>Comment</strong></label>
                                   <textarea class="form-control" name="comment" required style="width:100%; min-height:185px;"></textarea>
                             </div>
                             </div>
                             <div class="row" style="margin-top: 20px">      
                             <div class="col-md-12">
                             <input type="button" value="Cancel" class="btn btn-danger"> <input type="submit" id="smtbtn" value="Submit Changes" class="btn btn-success pull-right">
                             </div> 
                             </div>         
                            </div>
                        </div>
                        </form>
                        
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

		<!--[if !IE]> 
		<script src="assets/js/jquery-2.1.4.min.js"></script>-->

		<!-- <![endif]-->

		<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<!--<script src="assets/js/bootstrap.min.js"></script>

		 page specific plugin scripts 
		<script src="assets/js/jquery.dataTables.min.js"></script>
		<script src="assets/js/jquery.dataTables.bootstrap.min.js"></script>
		<script src="assets/js/dataTables.buttons.min.js"></script>
		<script src="assets/js/buttons.flash.min.js"></script>
		<script src="assets/js/buttons.html5.min.js"></script>
		<script src="assets/js/buttons.print.min.js"></script>
		<script src="assets/js/buttons.colVis.min.js"></script>
		<script src="assets/js/dataTables.select.min.js"></script>-->

		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		
<script>
window.onload = function() {
durationcalculate();
}
</script>		
	</body>
</html>
