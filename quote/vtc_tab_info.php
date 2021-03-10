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
	background: #1e2839;
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
</style>	
<body>
<?php include 'tabshead.php'; ?>
<section class="tabscontent">
<form action="sessions.php?action=info" method="post">
<div class="row">
<div class="col-md-12 text-center">
<h1 class="text-center">Tell us about yourself</h1>
<p class="sub-heading">We'll use this information to determine your prices.</p>
</div>
</div>

<div class="row">
<div class="col-md-6 col-lg-offset-3 fields">

<?php
if($allow_input_field['sum_insured'] == "on" ){ ?>
<div class="col-md-12" style="margin-bottom: 10px;">
<label>Coverage Amount</label>
<select class="form-control" name="sum_insured2" id="sum_insured2">
<option value="">Coverage Amount</option>
<?php
$sumin = mysqli_query($db, "SELECT `sum_insured` FROM `wp_dh_insurance_plans_rates` WHERE `plan_id` IN (SELECT `id` FROM `wp_dh_insurance_plans` WHERE `product`='$product_id') GROUP BY `sum_insured` ORDER BY CAST(`sum_insured` AS DECIMAL)");
while($suminsu = mysqli_fetch_assoc($sumin)){
$sum_insured = $suminsu['sum_insured'];
?>
<option value="<?php echo $sum_insured; ?>" <?php if($_SESSION['sum_insured2'] == $sum_insured){ echo 'selected=""'; } else if($sum_insured == '100000'){?> selected="" <?php } ?> >$<?php echo number_format($sum_insured); ?> </option>
<?php } ?>
</select>
</div>
<?php } ?>
<?php if($allow_input_field['sdate'] == "on" && $allow_input_field['edate'] == "on"){ ?>
<div class="col-md-6" style="margin-bottom: 10px;">
<label>Start date of coverage</label>
<input  id="departure_date"  name="departure_date" value="<?php echo $_SESSION['departure_date'];?>" class="form-control datepicker"  type="text" placeholder="Start Date" required <?php if($supervisa == 'yes'){?> onchange="supervisayes()" <?php } ?>>
			<label for="departure_date" style="z-index: 999;padding: 11px 11px !important;position: absolute;top: 28px;right: 17px;background: #F1F1F1;border-radius: 0px 5px 5px 0;">
				<i class="fa fa-calendar" aria-hidden="true"></i>
			</label>
			
					<script>
						$('#departure_date').datepicker({
						format: 'yyyy-mm-dd',
						todayHighlight:'TRUE',
						autoclose: true,
						});
					</script>
</div>
<div class="col-md-6" style="margin-bottom: 10px;">
<label>End date of coverage</label>
<input  id="return_date"  name="return_date" value="<?php echo $_SESSION['return_date'];?>" class="form-control datepicker"  type="text" placeholder="End Date" required <?php if($supervisa == 'yes'){?> readonly="true" <?php } ?>>
			<label for="return_date" style="z-index: 999;padding: 11px 11px !important;position: absolute;top: 28px;right: 17px;background: #F1F1F1;border-radius: 0px 5px 5px 0;">
				<i class="fa fa-calendar" aria-hidden="true"></i>
			</label>
			
					<?php if($supervisa == 'no'){?>
						<script>
							$('#return_date').datepicker({
							format: 'yyyy-mm-dd',
							todayHighlight:'TRUE',
							autoclose: true,
							});
						</script>
				<?php } ?>
</div>				
<?php } ?>
<?php if($allow_input_field['traveller'] == "on" ){
$number_of_travel = $allow_input_field['traveller_number'];
?>
<div class="col-md-12" style="margin-bottom: 10px;">
<label>Number of Travellers</label>
<select name="number_travelers" class="form-control form-select" id="number_travelers"  autocomplete="off" required onchange="checktravellers()">
	<option value="">Number of travellers</option>
	<?php for($i=1;$i<=$number_of_travel;$i++){ ?>
	<option value="<?php echo $i; ?>" <?php if($_SESSION['number_travelers'] == $i){?> selected="" <?php } ?> ><?php echo $i; ?></option>
	<?php } ?>
</select>
</div>							
<?php } ?>
<?php
if($allow_input_field['dob'] == "on" ){ 
?>
<div class="col-md-12">
<?php 
$ordinal_words = array('oldest', 'oldest', 'second', 'third', 'fourth', 'fifth', 'sixth', 'seventh', 'eighth');
for($i=1;$i<=$number_of_travel;$i++){ ?>
<div class="row" id="traveller_<?php echo $i;?>" style="<?php if($i > 1){ echo 'display: none'; } ?>">
<label class="input-label">Birth date of the <?php echo $ordinal_words[$i];?> Traveller</label>
<div class="col-md-12" style="margin-bottom: 10px; padding:0;">
<div class="col-md-4 col-xs-4 no-padding" style="padding-right:10px;padding-left: 0;">
<select required="required" name="month" id="month" class="form-control col-md-4">
<option value="01">Jan</option>
<option value="02">Feb</option>
<option value="03">Mar</option>
<option value="04">Apr</option>
<option value="05">May</option>
<option value="06">Jun</option>
<option value="07">Jul</option>
<option value="08">Aug</option>
<option value="09">Sep</option>
<option value="10">Oct</option>
<option value="11">Nov</option>
<option value="12">Dec</option>
</select>	
</div>
<div class="col-md-4 col-xs-4 no-padding">
<select required="required" name="dob_day" id="dob_day" class="form-control col-md-4">
<option value="01">01</option>
<option value="02">02</option>
<option value="03">03</option>
<option value="04">04</option>
<option value="05">05</option>
<option value="06">06</option>
<option value="07">07</option>
<option value="08">08</option>
<option value="09">09</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
<option value="30">30</option>
<option value="31">31</option>
</select>		
</div>
<div class="col-md-4 col-xs-4 no-padding" style="padding-right:0;">
<select name="years[]" id="add_<?php echo $i;?>" class="form-control col-md-4" onchange="checkfamilyplan()">
<option value="">Year</option>
<?php if($supervisa == 'yes'){ $maxyear = date('Y') - 40; } else { $maxyear = date('Y'); } for ($x = 1930; $x <= $maxyear; $x++) {?>
<option value="<?php echo date('Y') - $x;?>" <?php if($_SESSION['years'][$i-1] == 2019 - $x){?> selected="" <?php } ?>><?php echo $x;?></option>
<?php } ?>
</select>
</div>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>

</div>
</div>
<div class="row" style="margin-top:30px !important;opacity: 0.7;">
<div class="col-md-12 text-center"><button type="submit" class="btn btn-lg nextbtn">Continue <i class="fa fa-arrow-right"></i></button></div>
</div>
<div class="row" style="margin-top:30px !important;opacity: 0.7;">
<div class="col-md-12 text-center"><i class="fa fa-lock"></i> Your information is secure.</div>
</div>
</form>
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

window.onload = function() {
  checktravellers();
};

</script>
		<!-- JAVASCRIPT FILES -->
		<script type="text/javascript">var plugin_path = 'admin/assets/plugins/';</script>
		<script type="text/javascript" src="admin/assets/plugins/jquery/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="admin/assets/js/app.js"></script>
</body>
</html>	