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


//Company details:
$company_q = mysqli_query($db, "SELECT * FROM `wp_dh_companies` WHERE `comp_id`=(SELECT `insurance_company` FROM `wp_dh_insurance_plans` WHERE `id`='$policy_id')");
$company_f = mysqli_fetch_assoc($company_q);
$company_logo = $company_f['comp_logo'];


if($_REQUEST['action'] == 'done'){
$daylen = 60*60*24;
$date1 = $start_date;
$date2 = $_POST['early_expiry_date'];
$earlyreturn_days = (strtotime($date2)-strtotime($date1))/$daylen + 1;
$new_numdays = $duration - $earlyreturn_days;

$replace = array("%", "$");
$adminfee = str_replace($replace, '', $_POST['adminfee']);

$tax = 0;	



$travellers = 1 + $additional_travellers;

$new_expiry = $_POST['early_expiry_date'];
$transaction_reason = $_POST['transaction_reason'];


$refundable = $temp_daily_price * $new_numdays;
$additional_fee = $adminfee + $tax;

// REQUEST FOR PAYMENT
$price_difference = $refundable - $additional_fee;

//Editing Policy
mysqli_query($db, "UPDATE `sales` SET `transaction_reason`='$transaction_reason', `transaction_code`='EARLY_RETURN', `additional_fee`='$additional_fee', `premium_adjustment`='0', `end_date`='$new_expiry', `duration`='$earlyreturn_days', `policy_status`='return' WHERE `sales_id`='$sales_id'");

echo "<script>window.location='resend.php?id=".$sales_id."'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Sales View</title>

		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome ==-->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- page specific plugin styles -->

		<!-- text fonts ==-->
		<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

		<!-- ace styles ==-->
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
$( "#early_expiry_date" ).datepicker({
  changeMonth: true,
  changeYear: true,
  dateFormat: 'yy-mm-dd',
  minDate: '<?php echo $start_date;?>', 
  maxDate: '<?php echo $end_date;?>',
  yearRange: "+0:+5",
});
} );
$( function() {
$( "#expiry_date" ).datepicker({
  changeMonth: true,
  changeYear: true,
  dateFormat: 'yy-mm-dd',
  minDate: '<?php echo $start_date;?>',  
  maxDate: '<?php echo $end_date;?>',  
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
									Early Return
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->


								<div class="row">
									<div class="card">
                            <div class="card-block">
                        <h4 style="font-weight: bold; font-family: arial; color: rgb(51, 51, 51); text-decoration: none;">Early Return</h4>
							<div class="table-responsive">
                            <form method="post" action="?action=done&id=<?php echo $id;?>">
							<table class="table table-striped table-bordered table-hover" style="font-size: 14px; font-family:Arial, Helvetica, sans-serif; color:#444;">
								<tbody>
                                	<tr>
                                    	<td>Transaction Reason</td>
                                        <td><select class="form-control" name="transaction_reason" id="transaction_reason">
                                        	<option value="ERRR">Early Return - ERRR</option>
                                        </select>
                                        </td>
   								 	</tr>
           							<tr>
                                    	<td>Early Return Date</td>
                                        <td><div class="input-group">
                                                <input type="text" value="<?php echo $start_date;?>" id="early_expiry_date" name="early_expiry_date" class="form-control" required>
                                                <span class="input-group-addon"><i class="icon-calender"></i></span>
                                        </div>
                                        </td>
   								 	</tr>
                                    <tr>
                                    	<td>Original Effective Date</td>
                                        <td><?php echo $start_date;?></td>
   								 	</tr>
                                    <tr>
                                    	<td>Original Expiry Date</td>
                                        <td><?php echo $end_date; ?></td>
                                   </tr>
                                   <tr>
                                    	<td>Original Duration</td>
                                        <td><?php echo $duration; ?> Days</td>
                                   </tr>
                                   <tr>
                                    	<td>Admin Fee ($)</td>
                                        <td><input type="text" value="" name="adminfee" id="adminfee" class="form-control" required></td>
                                   </tr>
                                   <tr>
                                        <td colspan="2" align="right"> <input type="button" class="btn btn-danger" value="Cancel" onClick="if(confirm('Do you really want to cancel it ?')) window.location='sales_view.php?id=<?php echo $_REQUEST['id'];?>'"> <input type="submit" class="btn btn-success" value="Request Changes" ></td>
                                   </tr>
                                </tbody>
							</table>
                            </form>
                        <!-- /panel content -->
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

		<!-- ace scripts ==-->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
	<script>
window.onload = function() {
calculaterefund();
}
</script>
	</body>
</html>
