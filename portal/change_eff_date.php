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

if($_REQUEST['action'] == 'add'){
$eff_date = $_POST['eff_date'];
$expiry_date = $_POST['expiry_date'];
$admin_fee = $_POST['admin_fee'];
$transaction_reason = $_POST['transaction_reason'];
$newduration = $_POST['duration'];
$price_difference = str_replace('-','',$_POST['price_difference']);
$newtotal_price = $_POST['newprice'];

if($newduration > $duration){
mysqli_query($db, "INSERT INTO `sales_transactions`(`sales_id`, `payment_type`, `description`, `newvalue`, `amount`, `agent_code`) VALUES ('$sales_id','payment','Policy Upgrade Payment','$newduration Days','$price_difference', '$agent')");
}
else if($newduration < $duration){
mysqli_query($db, "INSERT INTO `sales_transactions`(`sales_id`, `payment_type`, `description`, `newvalue`, `amount`, `agent_code`) VALUES ('$sales_id','refund','Policy Downgrade Refund','$newduration Days','$price_difference', '$agent')");
}

mysqli_query($db, "INSERT INTO `sales_amendments`(`sales_id`, `amend_type`, `old_value`, `requestedby`) VALUES ('$sales_id','Dates Change','$start_date - $end_date ($duration Days)','".$_SESSION['portal_id']."')");
mysqli_query($db, "UPDATE `sales` SET `start_date`='$eff_date',`end_date`='$expiry_date' WHERE `sales_id`='$sales_id'");

echo "<script>window.location='sales_view.php?id=$sales_id';</script>";
} 
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Change Dates</title>

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
$( "#eff_date" ).datepicker({
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
									Change Dates
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="card">
                            <div class="card-block">
<?php if($_REQUEST['action'] == 'declined'){?>
<div class="alert alert-danger margin-bottom-30"><!-- DANGER -->
	<strong>Payment Declined!</strong> Please try again.
<?php } ?>                            
<?php
if($_REQUEST['action'] == 'review'){
?>                            
<h4 style="font-weight: bold; font-family: arial; color: #c00; text-decoration: none;">Change  Dates (<?php echo $policy_number; ?>)</h4> 
<form method="post" action="?action=add&id=<?php echo $_REQUEST['id']; ?>"> 
<div class="row">
<div class="<?php if($_POST['duration'] > $duration){ echo 'col-md-6'; } else { echo 'col-md-6'; } ?>">                          
<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" style="font-size: 14px; font-family:Arial, Helvetica, sans-serif; color:#444;">
								<tbody>
                                	<tr>
                                    	<td><strong>Old Values</strong></td>
                                        <td>&nbsp;</td>
                                        <td><strong>New Values</strong></td>
                                        <td>&nbsp;</td>
   								 	</tr>
                                    <tr>
                                    	<td>Effective Date</td>
                                        <td><?php echo $start_date;?></td>
                                        <td>Effective Date</td>
                                        <td><?php echo $_POST['eff_date'];?>
                                        <input type="hidden" name="eff_date" value="<?php echo $_POST['eff_date'];?>">
                                        </td>
   								 	</tr>
                                    <tr>
                                    	<td>Expiry Date</td>
                                        <td><?php echo $end_date;?></td>
                                        <td>Expiry Date</td>
                                        <td><?php echo $_POST['expiry_date'];?>
                                        <input type="hidden" name="expiry_date" value="<?php echo $_POST['expiry_date'];?>">
                                        </td>
   								 	</tr>
                                    <tr>
                                    	<td>Number of Days</td>
                                        <td><?php echo $duration;?></td>
                                        <td>Number of Days</td>
                                        <td><?php echo $_POST['duration'];?>
                                        <input type="hidden" name="duration" value="<?php echo $_POST['duration'];?>">
                                        </td>
   								 	</tr>
                                    <tr>
                                    	<td>Original Price</td>
                                        <td>$<?php echo $price_payable;?></td>
                                        <td>New Price</td>
                                        <td>$<?php 
										$newprice = $temp_daily_price * $_POST['duration']; echo number_format($newprice,2);?>
                                        <input type="hidden" name="newprice" value="<?php echo $newprice;?>">
                                        </td>
   								 	</tr>
                                    <tr>
                                    	<td></td>
                                        <td></td>
                                        <td><strong>Price Difference </strong>*</td>
                                        <td>$<?php $price_difference = $newprice - $price_payable; echo number_format($price_difference,2);?>
                                        <input type="hidden" name="price_difference" value="<?php echo $price_difference;?>">
                                        </td>
   								 	</tr>
                                   
                                 </tbody>
                              </table>
</div>
</div>

</div>
<div class="row">
<div class="col-md-12">
<input type="submit" class="btn btn-success pull-right" id="submitbtn" value="Submit Changes" id="submitbtn" style="margin-left:20px; margin-right:20px;">
<input type="button" class="btn btn-danger pull-right" value="Cancel" onClick="if(confirm('Do you really want to cancel it ?')) window.location='sales_view.php?id=<?php echo $_REQUEST['id'];?>'">
</div>
</div> 
</form>                                                             
<?php } else { ?>                            
                        <h4 style="font-weight: bold; font-family: arial; color: #c00; text-decoration: none;">Change  Dates (<?php echo $policy_number; ?>)</h4>
							<div class="table-responsive">
                            <form method="post" action="?action=review&id=<?php echo $_REQUEST['id']; ?>">
							<table class="table table-striped table-bordered table-hover" style="font-size: 16px; font-family:Arial, Helvetica, sans-serif; color:#444;">
								<tbody>
                                	<tr>
                                    	<td><strong>Transaction Reason</strong></td>
                                        <td><select class="form-control" name="transaction_reason" id="transaction_reason">
                                        	<option value="DATE">Date Change DATE</option>
                                        </select>
                                        </td>
   								 	</tr>
           							<tr>
                                    	<td><strong>Original Effective Date:</strong></td>
                                        <td><?php echo $start_date; ?></td>
                                     </tr>
                                     <tr>
                                    	<td><strong>Original Expiry Date:</strong></td>
                                        <td><?php echo $end_date; ?></td>
                                     </tr>
                                     <tr>
                                    	<td><strong>Number of Days:</strong></td>
                                        <td><?php echo $duration; ?> <em>Days</em></td>
                                     </tr>
                                     <tr>   
                                        <td><strong>New Effective Date:</strong></td>
                                        <td><input type="text" name="eff_date" id="eff_date" value="<?php echo $start_date;?>" required class="form-control" onChange="durationcalculate()" /></td>
   								 	</tr>
                                    <tr>   
                                        <td><strong>New Expiry Date:</strong></td>
                                        <td><input type="text" name="expiry_date" id="expiry_date" value="<?php echo $end_date;?>" required class="form-control" onChange="durationcalculate()" /></td>
   								 	</tr>
                                    <tr>   
                                        <td><strong>New Number of Days:</strong></td>
                                        <td><input type="text" name="duration" id="duration" readonly value="<?php echo $duration;?>" class="form-control"></td>
   								 	</tr>
                                   <tr>
                                        <td align="right" colspan="4"><span id="duration_error" class="pull-left"></span> <input type="button" class="btn btn-danger" value="Cancel" onClick="if(confirm('Do you really want to cancel it ?')) window.location='sales_view.php?id=<?php echo $_REQUEST['id'];?>'"> <input type="submit" class="btn btn-success" value="Review Changes" id="submitbtn"></td>
   								 	</tr>
                                </tbody>
							</table> 
                            <input type="hidden" name="sales_id" value="<?php echo $_REQUEST['id'];?>">
                            <input type="hidden" id="supervisa_value" value="<?php echo $supervisa;?>">
                            <input type="hidden" name="changes" value="<?php echo $amendments;?>">
                            </form>
                        <!-- /panel content -->
<script>
function durationcalculate(){
if(document.getElementById('supervisa_value').value == 'yes'){
document.getElementById('duration').value = '365';
	var tt = document.getElementById('eff_date').value;
	var date = new Date(tt);
	var newdate = new Date(date);
	newdate.setDate(newdate.getDate() + 364);
	var dd = newdate.getDate();
	var mm = newdate.getMonth() + 1;
	var y = newdate.getFullYear();
	if(mm <= 9){
	var mm = '0'+mm;	
	}
	var someFormattedDate = y + '-' + mm + '-' + dd;
	document.getElementById('expiry_date').value = someFormattedDate;
}
else {
var date1 = new Date(document.getElementById('eff_date').value);
var date2 = new Date(document.getElementById('expiry_date').value);
var timeDiff = Math.abs(date2.getTime() - date1.getTime());
var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24) + 1); 
document.getElementById('duration').value = diffDays;
}
var day = '365';
var acc_duration = document.getElementById('duration').value;
if(Number(acc_duration) > Number(day)){
document.getElementById('duration_error').innerHTML = 'The maximum duration must be 365 days.';
$('#submitbtn').hide();
}
else {
document.getElementById('duration_error').innerHTML = '';
$('#submitbtn').show();	
}

}
</script>                        
						</div>
<?php } ?>                        
                            </div>
</div>
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
		
	</body>
</html>
