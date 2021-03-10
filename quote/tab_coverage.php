<?php
include 'includes/db_connect.php';
/*if($_REQUEST['product_id']){
echo "<script>window.location='sessions.php?product_id=".$_REQUEST['product_id']."'</script>";
}*/
$product_id = $_SESSION['product_id'];
$page_q = mysqli_query($db, "SELECT * FROM `wp_dh_products` WHERE `pro_id`='$product_id'");
$fetch = mysqli_fetch_assoc($page_q);
$pro_id = $fetch['pro_id'];
$pro_name = $fetch['pro_name'];
$pro_parent = $fetch['pro_parent'];
$pro_createon = $fetch['pro_createon'];
$pro_createby = $fetch['pro_createby'];
$pro_updateon = $fetch['pro_updateon'];
$pro_updateby = $fetch['pro_updateby'];
$status = $fetch['status'];
$pro_supervisa = $fetch['pro_supervisa'];
$pro_fields = unserialize($fetch['pro_fields']);
$form_layout = $pro_fields['form_layout'];
$price_layout = $pro_fields['price_layout'];
$pro_sort  = unserialize($fetch['pro_sort']);
$pro_travel_destination = $fetch['pro_travel_destination'];
$pro_url = $fetch['pro_url'];

if($pro_supervisa == '1'){
$supervisa = 'yes';
} else {
$supervisa = 'no';	
}
$orderdata = $pro_sort;
$allow_input_field = $pro_fields;
?>
<html>
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title><?php echo $pro_name;?></title>
		<link rel="icon" type="image/png" href="/images/icon.png">
		<!-- mobile settings -->
		<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />
		<!-- CORE CSS -->
		<link href="admin/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="admin/assets/css/essentials.css" rel="stylesheet" type="text/css" />
		<link href="css/tab_style.css" rel="stylesheet" type="text/css" />
<style>
@media screen and (min-width: 1000px) {
.col-lg-offset-3 {
    margin-left: 25%;
}
}
</style>		
	</head>
<body onload="checkfamilyplan()">
<?php include 'tabsheader.php'; ?>
<section class="tabscontent">
<form action="sessions.php?action=coverage" method="post">
<div class="row">
<div style="height:30px;" class="col-md-12 visible-xs"></div>
<div class="col-md-12 hidden-xs text-center">
<h1 class="text-center">Choose your options.</h1>
</div>
</div>

<div class="row">
<div class="col-md-6 col-xs-12 col-lg-offset-3 fields">

<?php
if($allow_input_field['Smoke12'] == "on" ){ ?>
<div class="col-md-12 row graybox" style="margin-bottom: 10px !important;">
<label class="hidden-xs"><i class="fa fa-fire"></i> Do you Smoke in last 12 months ?</label>
<label class="visible-xs col-xs-8"><i class="fa fa-fire"></i> Do you Smoke ?</label>
<!-- success -->
<label class="switch switch-success switch-round pull-right">
	<input type="checkbox" name="Smoke12" <?php if($_SESSION['Smoke12'] == 'yes'){?> checked="" <?php } ?> value="yes">
	<span class="switch-label" data-on="YES" data-off="NO"></span>
</label>
</div>
<?php } ?>
<?php
if($allow_input_field['pre_existing'] == "on" ){ ?>
<div class="col-md-12 row graybox" style="margin-bottom: 10px !important;">
<label class="hidden-xs"><i class="fa fa-wheelchair"></i> Do you have any Pre-existing Condition ?</label>
<label class="visible-xs col-xs-8" style="padding-right:0;"><i class="fa fa-wheelchair"></i> Pre-existing Condition ?</label>
<!-- success -->
<label class="switch switch-success switch-round pull-right">
	<input type="checkbox" name="pre_existing" <?php if($_SESSION['pre_existing'] == 'yes'){?> checked="" <?php } ?> value="yes">
	<span class="switch-label" data-on="YES" data-off="NO"></span>
</label>
</div>
<?php } ?>
<?php
if($allow_input_field['pre_existing'] == "on" ){ ?>
<div class="col-md-12 row graybox" style="margin-bottom: 10px !important;">
<label class="hidden-xs"><i class="fa fa-child"></i>  Do you require Family Plan ?</label>
<label class="visible-xs col-xs-8"><i class="fa fa-child"></i>  Require Family Plan ?</label>
<!-- success -->
<label class="switch switch-success switch-round pull-right">
	<input type="checkbox" name="fplan" id="fplan" <?php if($_SESSION['familyplan_temp'] == 'yes'){?> checked="" <?php } ?> value="yes" onclick="changefamily()">
	<span class="switch-label" data-on="YES" data-off="NO"></span>
</label>
<input type="hidden" id="familyplan_temp" name="familyplan_temp" value="<?php if($_SESSION['familyplan_temp'] == ''){ echo 'no'; } else { echo $_SESSION['familyplan_temp']; } ?>">
<script>
function changefamily(){
	if(document.getElementById('fplan').checked == true){
		//alert('yes');
		document.getElementById('familyplan_temp').value = 'yes';
	} else {
		//alert('no');
		document.getElementById('familyplan_temp').value = 'no';
	}
checkfamilyplan();	
}
</script>
</div>
<?php } ?>

<div class="col-md-12"><p id="family_error"></p></div>
</div>
</div>
<div class="row" style="margin-top:30px !important;opacity: 0.7;">
<div class="col-md-12 text-center"><button type="submit" class="btn btn-lg nextbtn" id="GET_QUOTES">Continue <i class="fa fa-arrow-right"></i></button></div>
</div>
<div class="row" style="margin-top:30px !important;opacity: 0.7;">
<div class="col-md-12 text-center"><i class="fa fa-lock"></i> Your information is protected.</div>
</div>
</form>
</section>

<?php include 'footer.php'; ?>
<script>
<?php if($supervisa == 'yes'){?>
function supervisayes(){
//window.setTimeout(function(){	
	var tt = document.getElementById('departure_date').value;
	var date = new Date(tt);
	var newdate = new Date(date);
	newdate.setDate(newdate.getDate() + 364);
	var dd = newdate.getDate();
	var mm = newdate.getMonth() + 1;
	var y = newdate.getFullYear();
	if(mm <= 9){
	var mm = '0'+mm;	
	}
	if(dd <= 9){
	var dd = '0'+dd;	
	}
	//var someFormattedDate = mm + '/' + dd + '/' + y;
	var someFormattedDate = y + '-' + mm + '-' + dd;
	document.getElementById('return_date').value = someFormattedDate;
	//alert(someFormattedDate);
//}, 1000);
}
<?php } ?>

function checktravellers(){
	//Number OF Traveller
	var number_of_traveller = $("#number_travelers").val();
	for(var t=2; t<=8; t++){
		$("#traveller_"+t).hide();
		document.getElementById('add_'+t).required = false;
	}
	for(var i=2; i<=number_of_traveller; i++){
	$("#traveller_"+i).show();
	document.getElementById('add_'+i).required = true;
	}
	//reset values for other people
	var numt = document.getElementById('number_travelers').value;
	var one = 1;
	var num = parseInt(numt) + parseInt(one);
	for(var a=num; a<8; a++){
	document.getElementById('add_'+a).value = '';
	document.getElementById('add_'+a).required = false;
	}

checkfamilyplan();
}


function checkfamilyplan(){
//Eligibility
var inps = <?php echo str_replace('"','', json_encode(array_filter($_SESSION['years'])));?>;

Array.prototype.max = function() {
  return Math.max.apply(null, this);
};

Array.prototype.min = function() {
  return Math.min.apply(null, this);
};

var max_age = inps.max(); //ages.max();
var min_age = inps.min();
//alert(max_age);
if(document.getElementById('familyplan_temp').value == 'yes'){
var number_travelers = '<?php echo $_SESSION['number_travelers'];?>';
if(number_travelers >='2' && max_age <=59 && min_age <=21){
$('#GET_QUOTES').show();
document.getElementById('family_error').innerHTML = '';
document.getElementById('family_error').style.display = 'none';
} else {
$('#GET_QUOTES').hide();
if(number_travelers <'2'){
document.getElementById('family_error').innerHTML = '<i class="fa fa-warning"></i> Minimum 2 travellers required for family plan.';
} else if(max_age > 59){
document.getElementById('family_error').innerHTML = '<i class="fa fa-warning"></i> Maximum age for family plan should be 59';	
} else if(min_age > 21){
document.getElementById('family_error').innerHTML = '<i class="fa fa-warning"></i> For family plan the youngest traveller shouldn`t be elder than 21';	
}
document.getElementById('family_error').style.display = 'block';	
}

} else {
	$('#GET_QUOTES').show();
	document.getElementById('family_error').style.display = 'none';	
}
	
}
</script>
		<!-- JAVASCRIPT FILES -->
		<script type="text/javascript">var plugin_path = 'admin/assets/plugins/';</script>
		<script type="text/javascript" src="admin/assets/plugins/jquery/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="admin/assets/js/app.js"></script>
</body>
</html>	