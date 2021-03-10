<?php
include 'includes/db_connect.php';
$sub_url = explode('.', $_SERVER['HTTP_HOST']);
$count = count($sub_url);
if($count > 2){
$suburl = $sub_url[0];	
}
else {
$suburl = 'www';	
}



if($_REQUEST['id'] != ''){
if($sess_user_type == 'agent'){
$user_id = $_SESSION['portal_id'];	
}else { 
$user_id = $_REQUEST['id'];
}
}else {
$user_id = 	$_SESSION['portal_id'];
}

$me_q = mysqli_query($db, "SELECT * FROM `users` WHERE `id`='$user_id'");
$de_f = mysqli_fetch_assoc($me_q);
$user_id = 	$de_f['id'];
$parentid = $de_f['parent_id'];

if($_REQUEST['action'] == 'save_document'){							
$newfile = date('dmYHis').'_'.str_replace(" ", "", basename( $_FILES['document']['name']));	
move_uploaded_file($_FILES['document']['tmp_name'], "uploads/" .$newfile);
$document = date('dmYHis').'_'.$_FILES['document']['name'];
$eff_date = $_POST['eff_date'];
$expiry_date = $_POST['expiry_date'];
$license_type = $_POST['license_type'];
$province = $_POST['province'];

$doc_q = mysqli_query($db, "INSERT INTO `user_license`(`user_id`, `license`, `license_type`, `eff_date`, `expiry_date`, `province`) VALUES ('$user_id', '$document', '$license_type', '$eff_date', '$expiry_date', '$province')");

$notification = 'New document has been uploaded by <strong>'.$sess_fname.' '.$sess_lname.'</strong>';
$notify_q = mysqli_query($db, "INSERT INTO `notifications`(`notification`, `user_id`) VALUES ('$notification', '$parentid')");

if($parentid != '0'){
$parent_q = mysqli_query($db, "SELECT * FROM `users` WHERE `id`='$parentid'");
$parent_f = mysqli_fetch_assoc($parent_q);
$parent_name = $parent_f['fname'].' '.$parent['lname'];
$parent_email = $parent_f['email'];

$to = $parent_email;
$subject = 'Document Notification - LifeAdvice.ca';

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
    Dear '.$parent_name.',<br>
    <br>
    This email is to notify you that <strong>'.$de_f['fname'].' '.$de_f['lname'].'</strong> has uploaded a new document for your review and approval.<br>
	Click on the following link to view<br>
    <h4><a href="https://'.$suburl.'.LifeAdvice.ca/portal" target="_blank"><strong>Login to Customer Portal</strong></a></h4>
    <br>
    <br>
    Best Reards,
    LifeAdvice.ca
    </td>
  </tr>
</tbody>
</table>
</body>
</html>
';

mail($to, $subject, $body, $headers);
}

if($_REQUEST['id']){
echo "<script>window.location='user_profile.php?id=".$_REQUEST['id']."'</script>";
} else {
echo "<script>window.location='settings.php'</script>";
}

}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Documents</title>

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
<?php
$pastmonths = date('Y-m-d', strtotime('-35 months'));
$futuremonths = date('Y-m-d', strtotime('+35 months'));
?>
<script>
$( function() {
$( "#eff_date" ).datepicker({
  changeMonth: true,
      changeYear: true,
	  dateFormat: 'yy-mm-dd',
	  minDate: "<?php echo $pastmonths;?>",
	  maxDate: "today",
});
} );
$( function() {
$( "#expiry_date" ).datepicker({
  changeMonth: true,
      changeYear: true,
	  dateFormat: 'yy-mm-dd',
	  minDate: "today",
	  maxDate: "<?php echo $futuremonths;?>",
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
							<li class="active">Manage Profile</li>
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
								Add Document <?php if($_REQUEST['id']){								
								echo '<span class="text-danger"><i class="ace-icon fa fa-angle-double-right"></i> For '.$de_f['fname'].' '.$de_f['lname'].'</span>';
								}
								?>
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Select your next step below:
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<div class="col-xs-12 col-sm-9">
                                                                <h4 class="red">
																<span class="middle"><strong>License and/or E&O Document</strong></span>
															</h4>
    <form method="post" action="?action=save_document&id=<?php echo $_REQUEST['id'];?>" enctype="multipart/form-data">
                                                                															
															
															<div class="profile-user-info">
																<div class="profile-info-row">
																	<div class="profile-info-name" style="width: 200px;">
																		<i class="ace-icon fa fa-file red"></i>
																		Select Document
																	</div>

																	<div class="profile-info-value">
																		<div class="form-group">
															<div class="col-xs-6">
																<input type="file" id="document" name="document" required />
															</div>
														</div>
																	</div>
																</div>
                                                                
                                                                <div class="profile-info-row">
																	<div class="profile-info-name">
																		<i class="ace-icon fa fa-calendar red"></i>
																		Document Validity
																	</div>

																	<div class="profile-info-value">
                                                                 <div class="form-group">
                                                                    <div class="col-xs-6">
                                                                        <input class="form-control date-picker" name="eff_date" id="eff_date" type="text" data-date-format="dd-mm-yyyy" placeholder="Valid from" data-required="true"
 onChange="setdate()" />
                                                                    </div>
                                                                    <div class="col-xs-6">
                                                                        <input class="form-control date-picker" name="expiry_date" id="expiry_date" type="text" data-date-format="dd-mm-yyyy" placeholder="Valid till" data-required="true"
 onChange="checkdate()" />
                                                                    </div>
                                                                </div>
																	</div>
																</div>
<script>
function setdate(){
// Adding Default date as 1 year after
	var tt = document.getElementById('eff_date').value;
	var date = new Date(tt);
	var newdate = new Date(date);
	newdate.setDate(newdate.getDate() + 365);
	var dd = newdate.getDate();
	var mm = newdate.getMonth() + 1;
	var y = newdate.getFullYear();
	if(mm <= 9){
	var mm = '0'+mm;	
	}
	if(dd <= 9){
	var dd = '0'+dd;	
	}
	var someFormattedDate = y + '-' + mm + '-' + dd;
	document.getElementById('expiry_date').value = someFormattedDate;
// Added Default date as 1 year after	
}
function checkdate(){
var date1 = new Date(document.getElementById('eff_date').value);
var date2 = new Date(document.getElementById('expiry_date').value);
var timeDiff = Math.abs(date2.getTime() - date1.getTime());
var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24) + 1); 
document.getElementById('duration').value = diffDays;

var day = '365';
var acc_duration = document.getElementById('duration').value;
if(Number(acc_duration) > Number(day)){
document.getElementById('duration_error').innerHTML = '<i class="fa fa-warning"></i> The expiry date must be within 1 year from the date of document valid from.';
$('#submitbtn').hide();
}
else {
document.getElementById('duration_error').innerHTML = '';
$('#submitbtn').show();	
}	
}
</script>                                                                
                                                                <div class="profile-info-row">
																	<div class="profile-info-name">
																		<i class="ace-icon fa fa-file red"></i>
																		Document Type
																	</div>

																	<div class="profile-info-value">
                                                                 <div class="form-group">
                                                                    <div class="col-xs-6">
                                                                        <select class="form-control" name="license_type" id="license_type" required onChange="checktype()">
                                                                        <option value="">Select Document Type</option>
                                                                        <option value="license">License</option>
                                                                        <option value="eo">Error’s and Omission (E&O) </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
																	</div>
																</div>
                                                                
                                                                <div class="profile-info-row province_div" style="display:none;">
																	<div class="profile-info-name">
																		<i class="ace-icon fa fa-globe red"></i>
																		Select Province
																	</div>

																	<div class="profile-info-value">
                                                                 <div class="form-group">
                                                                    <div class="col-xs-6">
                                                                        <select class="form-control" name="province" id="province" required onChange="checktypeexist()">
                                                                        <option value="">Select Province</option>
                                                                        <?php
																		$pro_q = mysqli_query($db, "SELECT * FROM `provinces`");
																		while($pro_f = mysqli_fetch_assoc($pro_q)){
																		
																		$exi_q = mysqli_query($db, "SELECT * FROM `user_license` WHERE `user_id`='".$user_id."' AND `province`='".$pro_f['prov_abbr']."' AND `status`='1'");
																		$exi_num = mysqli_num_rows($exi_q);
																		?>
                                                                        <option value="<?php echo $pro_f['prov_abbr'];?>" <?php if($exi_num >= 1){?> disabled style="color:#c00;" <?php } ?>><?php echo $pro_f['prov_title'];?> <?php if($exi_num >= 1){?> <small class="text-danger">(In used)</small> <?php } ?></option>
                                                                        <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
																	</div>
																</div>
                                                                
																
                                                                <div class="profile-info-row">
																	<div class="profile-info-name">
																		
																	</div>

																	<div class="profile-info-value">
                                                                 <div class="form-group">
                                                                    <button type="submit" class="btn btn-primary" style="margin-top:30px;" id="submitbtn"><i class="fa fa-upload"></i> Upload Now</button>
                                                                    <span id="duration_error" class="text-danger"></span>
                                                                </div>
																	</div>
																</div>

															</div>
<input type="hidden" id="duration" name="duration">                                                            
    </form>                                                        
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

<script>
$('#document').ace_file_input({
	no_file:'No File ...',
	btn_choose:'Choose',
	btn_change:'Change',
	droppable:false,
	onchange:null,
	thumbnail:false //| true | large
	//whitelist:'gif|png|jpg|jpeg'
	//blacklist:'exe|php'
	//onchange:''
	//
});

function checktype(){	
if(document.getElementById('license_type').value == 'license'){
$('.province_div').show();
document.getElementById('province').required = true;	
}
else {
$('.province_div').hide();	
document.getElementById('province').required = false;
}
}

</script>
	</body>
</html>
