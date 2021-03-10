<?php
include 'includes/db_connect.php';
$product_id = '2';
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
		<title>Visitors to Canada</title>
		<!-- mobile settings -->
		<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />
		<!-- CORE CSS -->
		<link href="admin/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="admin/assets/css/essentials.css" rel="stylesheet" type="text/css" />
	</head>
<style>
body {
	margin:0;
	padding:0;
	background:#f3f5f9;
}
.tabshead {
	background:#1e2839;
}
.tabs {	
	color:#FFF;
	margin-bottom: 0 !important;
}
.tabs button {
	display: block;
	width: 100%;
	height: auto;
	padding: 10px 0;
	color: #FFF;
	border-radius: 5px 5px 0px 0px;
}
.tabs button:hover {
	background:#444E5F;
	color:#FFF;
}
.tabs button:focus {
	color:#FFF;
}
.tabs .active {
	background: #4D5768;
}
.tabs button:hover {
	
}
.tabs button i {
	display: block;
	color: #FFF;
	font-size: 2.5em !important;
}
.tabscontent {
	color:#1e2839;
	padding:50px 0px;
}
.tabscontent .row {
	margin:0 !important;
}
.tabscontent h1 {
	color: #1e2839;
	font-size: 3.5em;
	font-weight: bold;
	margin: 0;
}
.tabscontent .sub-heading {
	font-size: 1.125em;
	line-height: 1.5em;
	letter-spacing: 1px;	
}
.tabscontent .fields {
	background:#FFF;
	border:1px solid #1e2839;
	padding:3em;
	box-shadow:0 1px 2px 0 rgba(34,36,38,.22);
	border-radius: .25rem;
	border: 1px solid rgba(34,36,38,.22);
}
.tabscontent .fields label {
font-weight: bold;
font-size: 15px;
color: #4F596A;
}
.nextbtn {
	background: #4D7F0B;
	color: #FFF;
	padding: 10px 60px;
}
.nextbtn:hover {
background:#040E1F;
color: #FFF;
}
.nextbtn:hover i {
	color:#82b440;
}
.graybox {
	background: #FBFBFB;
	padding: 12px 6px 4px 15px;
	border-radius: 50px;
	border: 1px solid #eee;
}
</style>	
<body>
<?php include 'tabshead.php'; ?>
<section class="tabscontent">
<div class="row">
<div class="col-md-12 text-center">
<h1 class="text-center">You're almost there!</h1>
<p class="sub-heading">Take a few seconds to fill in the form to begin your application process.</p>
</div>
</div>

<div class="row">
<div class="col-md-6 col-lg-offset-3 fields">

<div class="col-md-6" style="margin-bottom: 10px;">
<label>First Name <small class="text-danger">*</small></label>
<input  id="fname"  name="fname" class="form-control"  type="text" placeholder="First name" required>
</div>
<div class="col-md-6" style="margin-bottom: 10px;">
<label>Last Name <small class="text-danger">*</small></label>
<input  id="lname"  name="lname" class="form-control"  type="text" placeholder="Last name" required>
</div>
<div class="col-md-12" style="margin-bottom: 10px;">
<label>Email Address <small class="text-danger">*</small></label>
<input  id="email"  name="email" class="form-control"  type="email" placeholder="Your email address" required>
</div>
<div class="col-md-12" style="margin-bottom: 10px;">
<label>Phone Number <small class="text-danger" id="phone_error">*</small></label>
<input  id="phone"  name="phone" class="form-control" minlength="10" maxlength="10"  type="text" placeholder="Your phone number" onkeyup="validatephone()" required>
</div>
<script>
function validatephone(){
var checkphone = document.getElementById('phone').value;
document.getElementById('phone').value = checkphone.replace(/\D/g,'');
if (checkphone.length < 10) {
document.getElementById('phone_error').innerHTML = '<small>(Must be 10 digits)</small>';
document.getElementById('getquote').disabled = true;	
} else {
document.getElementById('getquote').disabled = false;	
document.getElementById('phone_error').innerHTML = '';
}
}
</script>

</div>
</div>
<div class="row" style="margin-top:30px !important;opacity: 0.7;">
<div class="col-md-12 text-center"><button type="button" id="getquote" class="btn btn-lg nextbtn"><i class="fa fa-shopping-cart"></i> Buy Now</button></div>
</div>
<div class="row" style="margin-top:30px !important;opacity: 0.7;">
<div class="col-md-6 col-lg-offset-3 text-center" style="font-size:16px;">Don't worry, nothing's set in stone. Your dedicated advisor will review everything and contact you before submitting your application. By submitting this form, you consent to your data being sent to an independent representative working with Karma Insurance.</div>
</div>
<div class="row" style="margin-top:30px !important;opacity: 0.7;">
<div class="col-md-12 text-center"><i class="fa fa-lock"></i> Your information is secure.</div>
</div>
</section>


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
var inps = document.getElementsByName('years[]');
var ages = [];
for (var i = 0; i <inps.length; i++) {
var inp=inps[i];
if(inp.value > 0){
	ages.push(inp.value);
}
}

Array.prototype.max = function() {
  return Math.max.apply(null, this);
};

Array.prototype.min = function() {
  return Math.min.apply(null, this);
};

var max_age = ages.max();
var min_age = ages.min();
if(document.getElementById('familyplan_temp').value == 'yes'){
if(document.getElementById('number_travelers').value >='2' && max_age <=59 && min_age <=21){
document.getElementById('GET_QUOTES').style.display = 'block';
document.getElementById('family_error').innerHTML = '';
document.getElementById('family_error').style.display = 'none';
} else {
document.getElementById('GET_QUOTES').style.display = 'none';
if(document.getElementById('number_travelers').value <'2'){
document.getElementById('family_error').innerHTML = '<i class="fa fa-warning"></i> Minimum 2 travellers required for family plan.';
} else if(max_age > 59){
document.getElementById('family_error').innerHTML = '<i class="fa fa-warning"></i> Maximum age for family plan should be 59';	
} else if(min_age > 21){
document.getElementById('family_error').innerHTML = '<i class="fa fa-warning"></i> For family plan the youngest traveller shouldn`t be elder than 21';	
}
document.getElementById('family_error').style.display = 'block';	
}

} else {
	document.getElementById('GET_QUOTES').style.display = 'block';
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