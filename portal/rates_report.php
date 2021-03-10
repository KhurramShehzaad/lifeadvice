<?php
include 'includes/db_connect.php';
/*if($sess_user_type =='agent'){
echo "<script>window.location='dashboard.php';</script>";
}*/
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Rates Sheet</title>

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
.ui-widget.ui-widget-content { width:auto; }
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
								<a href="#">Rates Sheet</a>
							</li>
							<li class="active">Rates Sheet</li>
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
								Rates Sheet
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Check out rates:
								</small>
								
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<h4 class="red">
									<span class="middle"><strong>Rates Sheet</strong></span>
								</h4>
								    <div class="card">
                        
                            <div class="table-responsive">
                            <form method="post" action="?action=done" id="form">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th colspan="2"><strong><i class="fa fa-calendar"></i> Dates Between</strong></th>
                                                <th><strong><i class="fa fa-user"></i> Action</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><input type="text" name="start_date" class="form-control" id="start_date" value="<?php echo $_POST['start_date'];?>" required></td>
                                            <td><input type="text" name="end_date" class="form-control" id="end_date" value="<?php echo $_POST['end_date'];?>"  required></td>
                                            <td><input type="button" class="btn btn-success" style="padding: 2px;" value="Generate Report" onClick="generatereport()"> <?php if($_REQUEST['action'] == 'done'){?><button type="button" style="padding: 2px;" class="btn btn-primary" onClick="printview()"><i class="fa fa-print"></i> Print View</button> <?php } ?></td>
                                        </tr>                           
                                      </tbody>
                                    </table>
                            </form>        
                                </div>                           
<script>
function printview(){
document.getElementById('form').action = 'rates_printview.php?start='+ document.getElementById('start_date').value + '&end=' + document.getElementById('end_date').value;
document.getElementById('form').setAttribute('target', '_blank');
document.getElementById('form').submit();	
}

function generatereport(){
document.getElementById('form').action = '?action=done';
document.getElementById('form').setAttribute('target', '');
document.getElementById('form').submit();	
}
</script> 
                                
<?php if($_REQUEST['action'] == 'done'){
if($sess_user_type =='admin'){
$addinquery = "";	
}
else {
$addinquery = "AND `id` IN (SELECT `rate_table` FROM `policies` WHERE `company_id` IN (SELECT `id` FROM `companies` WHERE `id` IN (1, 15, 16, 17, 18, 19, 20)))";	
}

$rates_t_q = mysqli_query($db, "SELECT * FROM `rates_table` WHERE '".$_POST['start_date']."'>=`eff_date` AND `expiry_date`>='".$_POST['end_date']."' $addinquery ORDER BY `table_name`");
while($rates_t_f = mysqli_fetch_assoc($rates_t_q)){

$policies_q = mysqli_query($db, "SELECT * FROM `policies` WHERE `rate_table`='".$rates_t_f['id']."'");
$policies_f = mysqli_fetch_assoc($policies_q);
$policy_id = $policies_f['id'];
$policy_name = $policies_f['policy_name'];
$company_id = $policies_f['company_id'];


$days_query = mysqli_query($db, "SELECT * FROM `days` WHERE `company_id`='$company_id'");
$days_fetch = mysqli_fetch_assoc($days_query);
$days_id = $days_fetch['id'];
?>
<div class="col-md-12" style="background:#fff6c6; margin-bottom:20px; border-bottom:1px solid #CCC;">
<h3><strong><?php echo $policy_name;?></strong></h3>
<h5><?php echo $rates_t_f['table_name'];?> <code><i class="fa fa-calendar"></i> Valid From: <?php echo $rates_t_f['eff_date'];?> <i class="fa fa-calendar"></i> Valid Till: <?php echo $rates_t_f['expiry_date'];?></code><?php if($policy_name == ''){?><span class="text-danger font-18 font-bold"><i class="fa fa-close text-danger"></i> Inactive</span> <?php } else {?><span class="text-success font-18 font-bold"><i class="fa fa-check text-success"></i> Active</span><?php } ?></h5>
								<div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr style="background:#ffc464; color:#333;">
                                                <th><strong>Coverage Level</strong></th>
                                                <?php
$ages_q = mysqli_query($db, "SELECT * FROM `ages` WHERE `company_id`='$company_id' ORDER BY `s_age`");
while($ages_f = mysqli_fetch_assoc($ages_q)){
$ages_id = $ages_f['id'];
?>
                                                <th><strong><?php echo $ages_f['s_age'].'-'.$ages_f['e_age'];?></strong></th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
$bene_q = mysqli_query($db, "SELECT * FROM `benefit` ORDER BY `benefit_amount`");
while($bene_f = mysqli_fetch_assoc($bene_q)){
$bene_id = $bene_f['id'];
?>

                                            <tr>
                                                <td>$<?php echo $bene_f['benefit_amount'];?></td>
                                                <?php
$ages_q = mysqli_query($db, "SELECT * FROM `ages` WHERE `company_id`='$company_id' ORDER BY `s_age`");
while($ages_f = mysqli_fetch_assoc($ages_q)){
$ages_id = $ages_f['id'];
$prices_q = mysqli_query($db, "SELECT * FROM `prices` WHERE `age_id`='$ages_id' AND `days_id`='$days_id' AND `benefit_id`='$bene_id'");
$prices_f = mysqli_fetch_assoc($prices_q);
$price = $prices_f['price'];
if($price == ''){
$ps = '-';	
}
else {
$ps = '$';	
}
?>
                                                <td><?php echo $ps.$price;?></td>
                                                <?php } ?> 
                                            </tr> 
                                            <?php } ?>                         
                                      </tbody>
                                    </table>                  
                                </div>
<h5><strong>Deductibles:</strong></h5>
All rates stated above are based on a zero dollar deductible.<br/>
Application of deductibles to base rates noted above:
								<div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr style="background:#ffc464; color:#333;">
                                           	 <td><strong>Deductible</strong></td>
                                             <?php 
												$ag_q = mysqli_query($db, "SELECT DISTINCT(`age_id`) FROM `deductible` WHERE `policy_id`='$policy_id' AND `age_id` IN (SELECT `id` FROM `ages` WHERE `company_id`='$company_id') ORDER BY `age_id`");
												while($ag_f = mysqli_fetch_assoc($ag_q)){
												$age_q = mysqli_query($db, "SELECT * FROM `ages` WHERE `id`='".$ag_f['age_id']."' AND `company_id`='$company_id' ORDER BY `s_age`");
												$age_f = mysqli_fetch_assoc($age_q);
												?>
                                                <td><strong><?php echo $age_f['s_age'].'-'.$age_f['e_age'];?></strong></td>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                         <?php
											$de_q = mysqli_query($db, "SELECT * FROM `deductible` WHERE `policy_id`='$policy_id' GROUP BY `price`");
											while($de_f = mysqli_fetch_assoc($de_q)){
											?>
                                        	<tr>
                                            	<td>$<?php echo $de_f['price'];?></td>
                                                <?php 
												$ag_q = mysqli_query($db, "SELECT DISTINCT(`age_id`) FROM `deductible` WHERE `policy_id`='$policy_id' AND `age_id` IN (SELECT `id` FROM `ages` WHERE `company_id`='$company_id') ORDER BY `age_id`");
												while($ag_f = mysqli_fetch_assoc($ag_q)){

												$deduct_q = mysqli_query($db, "SELECT * FROM `deductible` WHERE `policy_id`='$policy_id' AND `price`='".$de_f['price']."' AND `age_id`='".$ag_f['age_id']."'");
												$deduct_f = mysqli_fetch_assoc($deduct_q);
												$deductible = $deduct_f['deductible'];
												if($deductible == ''){ $deductible == ''; $sign = '-'; $percent = ''; } else {
												$deductible = number_format(100 - $deductible,2);	
												if($deductible > 0){
												$sign = '-';	
												}
												else {
												$sign = '';	
												}
												$percent = '%';
												}
												?>
                                                <td><?php echo $sign.$deductible.$percent;?></td>
                                                <?php } ?>
                                            </tr>
                                           <?php } ?>
                                            
                                        </tbody>
                                     </table>
                                     </div> 
</div>                                                                   
<?php }} ?>
                                
                                
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
