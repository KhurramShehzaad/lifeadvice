<?php
$q1 = mysqli_query($db, "SELECT * FROM `wp_dh_insurance_plans` WHERE product = '$product_id'");
$row = mysqli_fetch_assoc($q1);
	$premedical[] = $row['premedical'];
	$family_plan[] = $row['family_plan'];


$prodetails = mysqli_query($db, "SELECT * FROM `wp_dh_products` WHERE `pro_id`='$product_id'");
$prorow = mysqli_fetch_assoc($prodetails);
$prosupervisa = $prorow['pro_supervisa'];
$product_name = $prorow['pro_name'];


if($prosupervisa == '1'){
$supervisa = 'yes';
} else {
$supervisa = 'no';	
}
	
$orderdata = $pro_sort;
$allow_input_field = $pro_fields;

$_SESSION['broker'] = $_REQUEST['broker'];
$_SESSION['agent'] = $_REQUEST['agent'];
$_SESSION['user_id'] = $_REQUEST['user_id'];
?>
<style>
.form-control {
font-size: 16px !important;
color: #333 !important;
border-radius: 4px !important;
text-transform: none;
border: 2px solid #fff;
background: #FFF !important;
padding: 5px 10px;
max-height: 40px;
text-align: left;
}
.form-control:focus {
    border: 2px solid #fff;
	box-shadow: 0px 0px 5px #333 !important;
}

.wrapper {
    height: 600px;
}
#jrange input {
    width: 200px;
}
#jrange div {
    font-size: 9pt;
}
.date-range-selected > .ui-state-active, .date-range-selected > .ui-state-default {
    background: none;
    background-color: lightsteelblue;
}
.agesbtn {
	background: #FFF !important;
}
.agesbtn i{
float: right;
padding-right: 5px;
color: #999;
}
.no-padding {
	padding:0;
}
.ageandcitizen {
background: #FFF;
margin-top: 5px;
box-shadow: 0 0 24px rgba(0,0,0,.16);
text-align:left;
}
.ageandcitizen input {
width: 100% !important;
height: 20px;
border: 0;
    border-bottom-color: currentcolor;
    border-bottom-style: none;
    border-bottom-width: 0px;
border-bottom-color: currentcolor;
border-bottom-style: none;
border-bottom-width: 0px;
border-bottom: 1px solid #bbb;
padding: 0px;
}
.ageandcitizen input:focus {
border-bottom: 1px solid #1bbc9b;
}
.ageandcitizen h3 {
color: #465c69;
font-size: 13px;
font-weight: bold;
line-height: 0;
margin-top: 25px;
margin-bottom: 10px;
}

.ageandcitizen h3 i{
color: #36ae8d;
font-size: 20px;
padding-right: 5px;
}

input[type=checkbox]{
	height: 0;
	width: 0;
	visibility: hidden;
}

.personswitch label {
cursor: pointer;
text-indent: -9999px;
width: 40px;
height: 15px;
background: #DDD;
display: block;
border-radius: 100px;
position: relative;
}

.personswitch label:after {
content: '';
position: absolute;
top: -2px;
left: 2px;
width: 19px;
height: 19px;
background: #44bc9b;
border-radius: 90px;
transition: 0.3s;
}

.personswitch input:checked + label {
	background: rgba(88,169,33,.4);
}

.personswitch input:checked + label:after {
	left: calc(100% - 2px);
	transform: translateX(-100%);
}

.fa-close {
color: #666;
font-size: 16px;
font-weight: normal;
position: absolute;
right: 15px;
top: 15px;
cursor: pointer;
}
.fa-close:hover {
color: #c00;	
}

.addmorebtn {
cursor: pointer;
border: 1px solid #1bbc9b;
border-radius: 30px;
color: #1bbc9b;
font-weight: bold;
display: block;
text-align: center;
width: 22px;
height: 22px;
padding: 0;
background: #FFF;
box-shadow: none !important;	
}
.addmorebtn:hover {
border: 1px solid #1bbc9b;	
background: #1bbc9b;
color: #FFF;
}
.daterangepicker td.start-date {
border-radius: 100px !important;
}
.daterangepicker td.end-date {
border-radius: 100px !important;	
}
.daterangepicker td.in-range {
border-radius: 100px !important;	
}
.durationtext {
font-size: 16px;
font-weight: bold;
display: inline-block;
text-align: left;
float: left;
}
.duration_days {
color: #35ad8c;
padding: 5px 0;
}
.duration_text {
display: inline-block;
font-size: 12px;
padding-top: 5px;
}
/*Radio Styling */

.daterangepicker .drp-calendar {
	max-width: none !important;
}
.daterangepicker .calendar-table th, .daterangepicker .calendar-table td {
height: 34px !important;	
}
</style>

<!--<style>
#ui-datepicker-div, .ui-datepicker-div, .ui-datepicker-inline {
	width:auto;
}
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default, .ui-button, html .ui-button.ui-state-disabled:hover, html .ui-button.ui-state-disabled:active {
border: none;
background: #30a887;
color: #fff;
font-weight: bold;
font-size: 14px;
text-align: center;	
}
.ui-monthpicker .ui-datepicker-today a, .ui-monthpicker .ui-datepicker-today a:hover, .ui-datepicker .ui-datepicker-current-day a {
background: #333 !important;
color: #FFF !important;
text-align: center;
border: none !important;
outline: none;
}
.ui-datepicker-calendar th span {
	color:#333 !important;
}
.ui-datepicker-header select, table.ui-datepicker td a {
color: #333;
background: #FFF !important;	
}
.ui-datepicker .ui-state-highlight {
background: #FFFA90 !important;
color: #333 !important;	
}
</style>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  $( function() {
    $( "#departure_date" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  dateFormat: 'yy-mm-dd',
	  yearRange: "+0:+5",
	  minDate: "today",
    });
  });
</script> 
   <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <link id="bsdp-css" href="https://uxsolutions.github.io/bootstrap-datepicker/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet">
	<script src="https://uxsolutions.github.io/bootstrap-datepicker/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>-->
	
<style>
.datepicker table tr td.active.active, .datepicker table tr td.active.highlighted.active, .datepicker table tr td.active.highlighted:active, .datepicker table tr td.active:active {
background-color: #04cca4;
border-radius: 100px;	
}
.table-condensed > thead > tr > th, .table-condensed > tbody > tr > th, .table-condensed > tfoot > tr > th, .table-condensed > thead > tr > td, .table-condensed > tbody > tr > td, .table-condensed > tfoot > tr > td {
	padding:3px !important;
}
.datepicker .datepicker-switch, .datepicker .next, .datepicker .prev, .datepicker tfoot tr th { font-weight:bold !important; }
.datepicker table tr td, .datepicker table tr th {
text-align: center;
padding: 8px 12px !important;
border-radius: 50px !important;
border: none;
}
.table-striped > tbody > tr:nth-child(2n+1), table > tbody > tr:nth-child(2n+1) {
border: none !important;	
}
.datepicker table tr td.today {
background: #F1F1F1 !important;
}
.table-condensed thead tr:nth-child(2) {
background: #44bc9b !important;
color: #FFF !important;	
}
.table-condensed thead tr th:nth-child(1) {
border-radius: 0px !important;	
}
.table-condensed thead tr th:nth-child(2) {
border-radius: 0px !important;	
}
.table-condensed thead tr th:nth-child(3) {
border-radius: 0px !important;	
}
.datepicker .datepicker-switch, .datepicker .next, .datepicker .prev, .datepicker tfoot tr th {
	font-size:16px;
}

.mainheading {
	font-weight:bold;margin: 0px; text-align:center;color: #FFF !important;font-size: 48px;
}

@media only screen and (max-width: 420px) {
#backbtn {
	width: 100% !important;
}
#getquote {
width: 100% !important;	
}
.daterangepicker {
position: fixed !important;
width: 100% !important;
z-index: 999999999 !important;
top: 0 !important;
left: 0 !important;
bottom: 0;
right: 0 !important;
margin-top: 0 !important;
}
.daterangepicker .drp-calendar {
max-width: 99% !important;
}
.daterangepicker .drp-calendar.left {
	padding:0px 8px;
}
.daterangepicker .drp-calendar.right {
	padding:0px 8px;
}

.ageandcitizen {
position: fixed !important;
width: 100% !important;
z-index: 999999999 !important;
top: 0 !important;
left: 0 !important;
bottom: 0;
right: 0 !important;
margin-top: 0 !important;
overflow: scroll;
}
.mainheading {
	font-size: 29px !important;
}

}

</style>

<script type="text/javascript" src="daterangepicker/jquery.min.js"></script>
<script type="text/javascript" src="daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="daterangepicker/daterangepicker.css" />

<!--<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="<?php //echo plugins_url() . '/insurancePlus'; ?>/picker/range.js"></script>
<link rel='stylesheet' type='text/css' href='<?php //echo plugins_url() . '/insurancePlus'; ?>/picker/core.css'>
-->
<div class="clearfix"></div>
<?php
if($product_id == '1'){
$bgs = array(4, 6, 8, 11); //Super
} else if($product_id == '2'){
$bgs = array(1, 2, 3, 7, 8, 11, 12, 15); //VTC
} else if($product_id == '3'){
$bgs = array(5, 9, 10); //Student
} else if($product_id == '9'){
$bgs = array(13, 14); //Student
} else {
$bgs = array(1, 2, 3, 7, 8, 11, 12); //VTC
}

$k = array_rand($bgs);
$bg = $bgs[$k];

?>

<section style="background: linear-gradient( rgba(162, 44, 44, 0.3), rgba(82, 82, 82, 0.3) ), url(<?php echo 'images/bgs/'.$bg;?>.jpg); background-size: cover; background-position: 50% 50%; padding:100px 0px 200px 0px;">
<?php 
$allow_input_field = array_slice($pro_fields, 2); 
$current_values = array();
$i = 0;
$position_array = array();
foreach($allow_input_field as $key => $value){
$i ++;
$position_array[$i] = $key;
}
?>
<div class="container">
	<div class="col-md-12">
	<h1 class="mainheading"><strong><?php echo $product_name;?></strong></h1>
	<h2 style="margin: 0px; text-align:center; color:#FFF;font-size: 20px;font-weight: normal;line-height: normal;">To start, we have a few quick questions to understand your needs.</h2>
	</div>

<div class="col-md-12 text-center" style="padding:0;">
<div class="clearfix"></div>
<form action="sessions.php?action=info" method="post"  id="dh-get-quote"  class="form-horizontal form-layout2" role="form"  >
<div id="listprices_" style="padding-top:30px;">

<div class="page_1">
<?php
if($allow_input_field['sum_insured'] == "on" ){ ?>
<div class="col-md-4" style="margin-bottom: 10px;">
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
<div class="col-md-4" style="margin-bottom: 10px;">
<?php if($supervisa == 'yes'){?>
<input  id="departure_date"  name="departure_date" value="<?php echo $_SESSION['departure_date']; ?>" class="form-control" type="text" required <?php if($supervisa == 'yes'){?> onchange="supervisayes()" <?php } ?>>
<i class="fa fa-calendar" onclick="$('#departure_date').focus();" style="position: absolute;top: 11px;right: 28px;font-size: 16px;color: #01a281;"></i>		
<script>
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1; //January is 0!
var yyyy = today.getFullYear();
if (dd < 10) {
  dd = '0' + dd;
} 
if (mm < 10) {
  mm = '0' + mm;
} 
var today = mm + '/' + dd + '/' + yyyy;

$(function() {
  $('input[name="departure_date"]').daterangepicker({
    opens: 'left',
	minDate: today,
	singleDatePicker: true,
    showDropdowns: true,
  }, function(start, end, label) {
//console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
});
</script>
<script>
//SUPER VISA 
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
//}, 1000);
}
</script>
<?php } else { ?>
<input type="text" name="daterange" id="daterange" autocomplete="false" readonly="true" class="form-control" value="<?php if($_SESSION['departure_date'] != '' && $_SESSION['return_date'] !=''){ echo date('m/d/Y', strtotime($_SESSION['departure_date'])).' - '.date('m/d/Y', strtotime($_SESSION['return_date'])); }?>" placeholder="<?php if($_SESSION['departure_date'] != '' && $_SESSION['return_date'] !=''){ echo date('m/d/Y', strtotime($_SESSION['departure_date'])).' - '.date('m/d/Y', strtotime($_SESSION['return_date'])); } else { echo 'Start Date | End Date'; } ?>" style="cursor: pointer;" />
<i class="fa fa-calendar" onclick="$('#daterange').focus();" style="position: absolute;top: 11px;right: 28px;font-size: 16px;color: #01a281;"></i>
<script>
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1; //January is 0!
var yyyy = today.getFullYear();
if (dd < 10) {
  dd = '0' + dd;
} 
if (mm < 10) {
  mm = '0' + mm;
} 
var today = mm + '/' + dd + '/' + yyyy;

$(function() {
  $('input[name="daterange"]').daterangepicker({
    opens: 'left',
	minDate: today,
	autoApply: true,
  }, function(start, end, label) {
	 document.getElementById('departure_date').value = start.format('YYYY-MM-DD');
	 document.getElementById('return_date').value = end.format('YYYY-MM-DD');
//Calculation of Duration:
var date1 = new Date(start.format('YYYY-MM-DD'));
var date2 = new Date(end.format('YYYY-MM-DD'));
var timeDiff = Math.abs(date2.getTime() - date1.getTime());
var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24) + 1); 
$('.duration_days').html(diffDays+' Days');


//var todaydate = today+' - '+today;
//localStorage.clear();
//var getvalue =  localStorage.getItem("dateRange");
//if(todaydate == getvalue){
//	var getvalue = null;
//}
//if(getvalue == null){
//localStorage.setItem("dateRange", $("#daterange").val());
//alert('setted');
//}
//alert(localStorage.getItem("dateRange"));
//console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
});
</script>
<input type="hidden" name="departure_date" id="departure_date" value="<?php echo $_SESSION['departure_date']; ?>">
<?php } ?>
<input type="hidden" name="return_date" id="return_date" value="<?php echo $_SESSION['return_date']; ?>">
</div>
<?php } ?>	


<div class="col-md-4 agesdiv" id="agesdiv">
<button class="btn btn-default agesbtn form-control" type="button" onclick="$('.ageandcitizen').fadeIn(300);">Ages and Details <i class="fa fa-caret-down"></i></button>
<div class="col-md-12 ageandcitizen" style="display:none; padding: 1px 15px;">
<?php
if($allow_input_field['dob'] == "on" ){ 
?>

<div class="col-md-12 no-padding">
<h3><i class="fa fa-user"></i> Primary Traveler</h3>
</div>
<div class="row yearsdiv">
<div class="col-md-5">
<small style="font-size: 12px;color: #999;">Age</small>
<input type="text" name="ages[]" id="ages[]" value="<?php echo $_SESSION['years'][0]; ?>" class="primaryage" style="margin-top: -5px !important;display: block;" />
</div>
<div class="col-md-2 text-center" style="padding-top: 10px;">
or
</div>
<div class="col-md-5" style="padding-top: 10px;">
<a style="cursor: pointer;" onclick="$('.dobdiv').show(); $('.yearsdiv').hide()">Enter Date of Birth</a>
</div>
</div>

<div class="row dobdiv" style="display:none;">
<div class="col-md-12">
<div class="col-md-6 no-padding">
<div class="col-md-4" style="padding: 0 5px;">
<small style="font-size: 12px;color: #999;padding: 0;">Month</small>
<input type="text" style="margin-top: -5px !important;display: block;">
</div>
<div class="col-md-4" style="padding: 0 5px;">
<small style="font-size: 12px;color: #999;padding: 0;">Day</small>
<input type="text" style="margin-top: -5px !important;display: block;">
</div>
<div class="col-md-4" style="padding: 0 5px;">
<small style="font-size: 12px;color: #999;padding: 0;">Year</small>
<input type="text" id="dob_year" onchange="calprimaryage()" style="margin-top: -5px !important;display: block;">
</div>
</div>
<script>
function calprimaryage(){
var currentyear = new Date().getFullYear();
var dobyear = document.getElementById('dob_year').value;
var primaryage = currentyear - dobyear;
$('.primaryage').val(primaryage);
}
</script>
<div class="col-md-6" style="padding-top: 10px;">
<div style="padding: 0;" class="col-md-2 text-center">
or
</div>
<div style="padding: 0;text-align: center;" class="col-md-10">
<a style="cursor: pointer;" onclick="$('.dobdiv').hide(); $('.yearsdiv').show()">Enter Age</a>
</div>
</div>
</div>
</div>

<?php } 

if($allow_input_field['traveller'] == "on" ){
?>
<div class="col-md-12 no-padding" style="margin-top:10px;">
<div class="col-md-10 no-padding" style="padding-top: 1px;">
<h3><i class="fa fa-list-ul"></i> Additional Travelers</h3>
</div>
<div class="col-md-2 personswitch" style="padding-top: 25px;padding-right: 0;padding-left: 0;">
<input type="checkbox" id="switch" style="float:right;" onclick="checkadditionals();" <?php if($_SESSION['number_travelers'] > 1){?> checked="" <?php } ?> /><label for="switch">Toggle</label>
<input type="hidden" id="temp_addi" value="0" />
<script>
function checkadditionals(){
if(document.getElementById('switch').checked == true){
document.getElementById('temp_addi').value = 1;
$('.additionals').show();
} else {
document.getElementById('temp_addi').value = 0;
$('.additionals').hide();
$('.add_1').val('');
}
}
</script>
</div>
</div>
<div class="col-md-12 no-padding additionals" style=" <?php if($_SESSION['number_travelers'] > 1){ echo 'display:block;'; } else {echo 'display:none;';} ?>">
<div class="birthday">
<div class="col-md-3 add_1" style="padding-left: 0;">
<small style="font-size: 12px;color: #999;">Age</small>
<input type="text" name="years[]" class="add_1" value="<?php echo $_SESSION['years'][1];?>" style="margin-top: -5px !important;display: block;" />
</div>
<?php 
$sess_travellers = $_SESSION['number_travelers'] - 2;
for($s=1; $s <= $sess_travellers; $s++){	?>
<div class="col-md-3 add_<?php echo $s;?>" style="padding-left: 0;">
<small style="font-size: 12px;color: #999;">Age</small>
<input type="text" name="years[]" class="add_<?php echo $s;?>" id="add_<?php echo $s;?>" value="<?php echo $_SESSION['years'][$s+2];?>" style="margin-top: -5px !important;display: block;" />
<i class="fa fa-close" onclick="addfunc_<?php echo $s;?>()"></i>
</div>
<?php } ?>
</div>
<input type="hidden" id="current_adds" value="<?php if($_SESSION['number_travelers'] == ''){ echo '1'; } else { echo $_SESSION['number_travelers'] - 1; } ?>" />
<input type="hidden" id="number_travelers" name="number_travelers" value="<?php if($_SESSION['number_travelers'] == ''){ echo '1'; } else { echo $_SESSION['number_travelers']; } ?>">
<script>
<?php for($i=0; $i<= $allow_input_field['traveller_number']; $i++){	?>
function addfunc_<?php echo $i;?>(){
$(".add_<?php echo $i;?>").remove();
var minus_traveller = document.getElementById('current_adds').value;
document.getElementById('current_adds').value = parseFloat(minus_traveller) - 1;
$('.addmoretraveler').show();	
}
<?php } ?>

function addtravellers(){
var number_of_traveller = '<?php echo $allow_input_field['traveller_number'];?>';
var current_travellers = document.getElementById('current_adds').value;
var current_id = parseFloat(current_travellers) + 1;
var aa = '';
aa = aa + '<div class="col-md-3 add_'+current_id+'" style="padding-left: 0;"><small style="font-size: 12px;color: #999;">Age</small><input type="text" name="years[]" id="years[]" style="margin-top: -5px !important;display: block;" /><i class="fa fa-close" onclick="addfunc_'+current_id+'()"></i></div>';
if(current_travellers < number_of_traveller){
document.getElementById('current_adds').value = parseFloat(current_travellers) + 1;
$('.addmoretraveler').fadeIn(300);	
$(".birthday").append(aa);
if(current_travellers == '<?php echo $allow_input_field['traveller_number'] - 1;?>'){ $('.addmoretraveler').hide(); }
} else {
$('.addmoretraveler').fadeOut(300);	
}
}
</script>
<div class="col-md-2 text-center addmoretraveler" style="padding-top:20px;">
<a class="addmorebtn" onclick="addtravellers();"><i class="fa fa-plus" style="position: relative;top: 4px;left: 0px;"></i></a>
</div>
</div>
<?php } ?>

<?php
if($allow_input_field['Smoke12'] == "on" ){  ?>
<div class="col-md-12 no-padding">
<h3><i class="fa fa-fire"></i> Do you Smoke in last 12 months ?</h3>
<div class="col-md-12 no-padding">
<label style="display: inline-block;margin-right: 10px;margin-left: 25px;"><input type="radio" name="Smoke12" <?php if($_SESSION['Smoke12'] == 'yes'){?> checked="" <?php } ?> value="yes" style="width: auto !important;height: auto;"> Yes</label> <label style="display: inline-block;margin-right: 10px;"><input type="radio" name="Smoke12" value="no" <?php if($_SESSION['Smoke12'] == 'no' || $_SESSION['Smoke12'] == ''){?> checked="" <?php } ?> style="width: auto !important;height: auto;"> No</label>
</div>
</div>
<?php } ?>
<?php if($allow_input_field['pre_existing'] == "on" ){ $num = array_search("pre_existing", $position_array); $current_values[$num] = 'group_16'; ?>
<div class="col-md-12 no-padding">
<h3><i class="fa fa-wheelchair"></i> Pre-existing Condition ?</h3>
<div class="col-md-12 no-padding">
<label style="display: inline-block;margin-right: 10px;margin-left: 25px;"><input type="radio" name="pre_existing" <?php if($_SESSION['pre_existing'] == 'yes'){?> checked="" <?php } ?> value="yes" style="width: auto !important;height: auto;"> Yes</label> <label style="display: inline-block;margin-right: 10px;"><input type="radio" name="pre_existing" value="no" <?php if($_SESSION['pre_existing'] == 'no' || $_SESSION['pre_existing'] == ''){?> checked="" <?php } ?> style="width: auto !important;height: auto;"> No</label>
</div>
</div>
<?php } ?>

<?php if($allow_input_field['fplan'] == "on" ){ $num = array_search("fplan", $position_array); $current_values[$num] = 'group_15';  ?>
<div class="col-md-12 no-padding">
<h3><i class="fa fa-child"></i> Do you require Family Plan ?</h3>
<div class="col-md-12 no-padding">
<label style="display: inline-block;margin-right: 10px;margin-left: 25px;"><input type="radio" name="fplan" <?php if($_SESSION['fplan'] == 'yes'){?> checked="" <?php } ?> value="yes" style="width: auto !important;height: auto;" onclick="changefamilyyes()"> Yes</label> <label style="display: inline-block;margin-right: 10px;"><input type="radio" name="fplan" value="no" <?php if($_SESSION['fplan'] == 'no' || $_SESSION['fplan'] == ''){?> checked="" <?php } ?> style="width: auto !important;height: auto;" onclick="changefamilyno()"> No</label>
</div>
<input type="hidden" id="familyplan_temp" name="familyplan_temp" value="no">

<script>
function changefamilyyes(){
document.getElementById('familyplan_temp').value = 'yes';	
checkfamilyplan();
}
function changefamilyno(){
document.getElementById('familyplan_temp').value = 'no';	
checkfamilyplan();
}

</script>
</div>
<?php } ?>

<div class="col-md-12 no-padding text-center">
<button type="button" class="btn btn-primary" style="margin-bottom: 20px;margin-top: 20px;border-radius: 20px;width: 100%;" onclick="applychanges();">Apply Changes</button>
<script>
function applychanges(){
var inps = document.getElementsByName('years[]');
var ages = [];
for (var i = 0; i <inps.length; i++) {
var inp=inps[i];
ages.push(inp.value);
}

var ages = ages.filter(Boolean);
$('.agesbtn').html(ages + ' Years <i class="fa fa-caret-down"></i>');
$('.ageandcitizen').fadeOut(300);	
document.getElementById('number_travelers').value = ages.length;
checkfamilyplan();
}
</script>
</div>

<div class="clear:both;"></div>

</div>
</div>

<div class="clear:both;"></div>
<div class="col-md-2 pull-right" style="margin: 30px 0;">
<?php
//Calcuation for next page
$nextpage = 0;
if($allow_input_field['fname'] == "on" ){ $nextpage = $nextpage + 1; }
if($allow_input_field['lname'] == "on" ){ $nextpage = $nextpage + 1; }
if($allow_input_field['email'] == "on" ){ $nextpage = $nextpage + 1; }
if($allow_input_field['phone'] == "on" ){ $nextpage = $nextpage + 1; }
if($allow_input_field['traveller_gender'] == "on" ){ $nextpage = $nextpage + 1; }
if($allow_input_field['gender'] == "on" ){ $nextpage = $nextpage + 1; }
if($allow_input_field['smoked'] == "on" ){ $nextpage = $nextpage + 1; }

if($nextpage > 0){
?>
<button class="btn nextbtn" type="button" id="GET_QUOTES" onclick="$('.page_1').hide();$('.page_2').show('slow');"> Next <i class="fa fa-arrow-circle-right"></i></button>
<?php } else {?>
<input  id="savers_email" name="savers_email" class="form-control" type="hidden" value="youremail@site.com" >
<button type="submit" id="getquote" class="btn nextbtn pull-right" style="font-size:16px;"> Continue <i class="fa fa-arrow-circle-right"></i></button>
<?php } ?>
</div>

<script>
$('html').click(function() {
    $('.ageandcitizen').fadeOut(300);
 })

 $('.agesdiv').click(function(e){
     e.stopPropagation();
 });
</script>
</div>
<!-- PAGE ONE ENDED -->

<div class="page_2" style="display:none;">
<div class="row">
<?php if($allow_input_field['fname'] == "on" ){?>
<div class="col-md-4" style="margin-bottom:10px;">
<input  id="fname" name="fname" class="form-control" required value="<?php echo $_SESSION['fname']; ?>"  type="text" placeholder="Your first name">
</div>
<?php } ?>

<?php if($allow_input_field['lname'] == "on" ){ ?>
<div class="col-md-4" style="margin-bottom:10px;">
<input  id="lname" name="lname" class="form-control" required value="<?php echo $_SESSION['lname']; ?>"  type="text" placeholder="Your last name">
</div>
<?php } ?>

<?php if($allow_input_field['email'] == "on" ){ ?>
<div class="col-md-4" style="margin-bottom:10px;">
<input  id="savers_email" name="savers_email" class="form-control" required value="<?php echo $_SESSION['savers_email']; ?>"  type="email" placeholder="Your email address" style="float: none;padding: 0 10px !important;">
</div>
<?php  } ?>
</div>
<div class="row">
<?php if($allow_input_field['phone'] == "on" ){ ?>
<div class="col-md-4" style="margin-bottom:10px;">
<input id="phone" name="phone" size="" minlength="10" maxlength="10" class="form-control" value="<?php echo $_SESSION['phone']; ?>" placeholder="Your phone number" type="text" required  onkeyup="validatephone()">
</div>
<script>
function validatephone(){
var checkphone = document.getElementById('phone').value;
document.getElementById('phone').value = checkphone.replace(/\D/g,'');
if (checkphone.length < 10) {
document.getElementById('phone_error').innerHTML = 'Must be 10 digits';
document.getElementById('GET_QUOTES').disabled = true;	
} else {
document.getElementById('GET_QUOTES').disabled = false;	
document.getElementById('phone_error').innerHTML = '';
}
}
</script>
<?php } ?>
<?php if($allow_input_field['traveller_gender'] == "on" ){?>
<div class="col-md-4" style="margin-bottom:10px;">
<select class="form-control" name="old_traveller_gender" id="old_traveller_gender" required="">
<option value="">Gender of Oldest Traveler</option>
<option value="male" <?php if($_SESSION['old_traveller_gender'] == 'male'){?> selected="" <?php } ?>>Male</option>
<option value="female" <?php if($_SESSION['old_traveller_gender'] == 'female'){?> selected="" <?php } ?>>Female</option>
</select>
</div>
<?php } ?>
<?php if($allow_input_field['gender'] == "on" ){?>
<div class="col-md-4" style="margin-bottom:10px;">
<select class="form-control" name="gender" id="gender" required="" style="float:none;">
<option value="">Gender</option>
<option value="male" <?php if($_SESSION['gender'] == 'male'){?> selected="" <?php } ?>>Male</option>
<option value="female" <?php if($_SESSION['gender'] == 'female'){?> selected="" <?php } ?>>Female</option>
</select>
</div>
<?php } ?>
<?php if($allow_input_field['smoked'] == "on" ){ ?>
<div class="col-md-4" style="margin-bottom:10px;">
<select class="form-control" name="traveller_Smoke" id="traveller_Smoke" required="">
<option value="">Traveller Smoke ?</option>
<option value="yes" <?php if($_SESSION['traveller_Smoke'] == 'yes'){?> selected="" <?php } ?>>Yes</option>
<option value="no" <?php if($_SESSION['traveller_Smoke'] == 'no'){?> selected="" <?php } ?>>No</option>
</select>
</div>
<?php } ?>

       <!---Destination country -->

        <?php

		if(isset($allow_input_field['Country']) && $allow_input_field['Country'] == "on" ){ 
             if($allowed_input_fields[0]->pro_travel_destination == 'worldwide'){
			?>
			<script>
                function CountryState(evt) {
                    if(evt.value=="Canada")
                    {
                        jQuery("#primary_destination_State_div").show();
                        jQuery("#usa_stop_div").hide();
                    }else if(evt.value=="United States")
                    {
                        jQuery("#primary_destination_State_div").hide();
                        jQuery("#usa_stop_div").hide();
                   }else
                   {
                       jQuery("#primary_destination_State_div").hide();
                        jQuery("#usa_stop_div").show();
                   }
                }
			</script>

			<div class="col-md-4"> 

                <select name="primary_destination" onchange="CountryState(this)" class="form-control form-select" id="primary_destination" aria-required="true" required>

                    <option value='United States'  data-imagecss="flag us" data-title="United States">United States</option>

                    <option value='Canada'  data-imagecss="flag ca" data-title="Canada" selected="selected">Canada</option>

                    <option value="">---------</option>-->

                    <option value='Andorra'  data-imagecss="flag ad" data-title="Andorra">Andorra</option>

                    <option value='United Arab Emirates'  data-imagecss="flag ae" data-title="United Arab Emirates">United Arab Emirates</option>

                    <option value='Afghanistan'  data-imagecss="flag af" data-title="Afghanistan">Afghanistan</option>

                    <option value='Antigua and Barbuda'  data-imagecss="flag ag" data-title="Antigua and Barbuda">Antigua and Barbuda</option>

                    <option value='Anguilla'  data-imagecss="flag ai" data-title="Anguilla">Anguilla</option>

                    <option value='Albania'  data-imagecss="flag al" data-title="Albania">Albania</option>

                    <option value='Armenia'  data-imagecss="flag am" data-title="Armenia">Armenia</option>

                    <option value='Netherlands Antilles'  data-imagecss="flag an" data-title="Netherlands Antilles">Netherlands Antilles</option>

                    <option value='Angola'  data-imagecss="flag ao" data-title="Angola">Angola</option>

                    <option value='Antarctica'  data-imagecss="flag aq" data-title="Antarctica">Antarctica</option>

                    <option value='Argentina'  data-imagecss="flag ar" data-title="Argentina">Argentina</option>

                    <option value='American Samoa'  data-imagecss="flag as" data-title="American Samoa">American Samoa</option>

                    <option value='Austria'  data-imagecss="flag at" data-title="Austria">Austria</option>

                    <option value='Australia'  data-imagecss="flag au" data-title="Australia">Australia</option>

                    <option value='Aruba'  data-imagecss="flag aw" data-title="Aruba">Aruba</option>

                    <option value='Aland Islands'  data-imagecss="flag ax" data-title="Aland Islands">Aland Islands</option>

                    <option value='Azerbaijan'  data-imagecss="flag az" data-title="Azerbaijan">Azerbaijan</option>

                    <option value='Bosnia and Herzegovina'  data-imagecss="flag ba" data-title="Bosnia and Herzegovina">Bosnia and Herzegovina</option>

                    <option value='Barbados'  data-imagecss="flag bb" data-title="Barbados">Barbados</option>

                    <option value='Bangladesh'  data-imagecss="flag bd" data-title="Bangladesh">Bangladesh</option>

                    <option value='Belgium'  data-imagecss="flag be" data-title="Belgium">Belgium</option>

                    <option value='Burkina Faso'  data-imagecss="flag bf" data-title="Burkina Faso">Burkina Faso</option>

                    <option value='Bulgaria'  data-imagecss="flag bg" data-title="Bulgaria">Bulgaria</option>

                    <option value='Bahrain'  data-imagecss="flag bh" data-title="Bahrain">Bahrain</option>

                    <option value='Burundi'  data-imagecss="flag bi" data-title="Burundi">Burundi</option>

                    <option value='Benin'  data-imagecss="flag bj" data-title="Benin">Benin</option>

                    <option value='Bermuda'  data-imagecss="flag bm" data-title="Bermuda">Bermuda</option>

                    <option value='Brunei Darussalam'  data-imagecss="flag bn" data-title="Brunei Darussalam">Brunei Darussalam</option>

                    <option value='Bolivia'  data-imagecss="flag bo" data-title="Bolivia">Bolivia</option>

                    <option value='Brazil'  data-imagecss="flag br" data-title="Brazil">Brazil</option>

                    <option value='Bahamas'  data-imagecss="flag bs" data-title="Bahamas">Bahamas</option>

                    <option value='Bhutan'  data-imagecss="flag bt" data-title="Bhutan">Bhutan</option>

                    <option value='Bouvet Island'  data-imagecss="flag bv" data-title="Bouvet Island">Bouvet Island</option>

                    <option value='Botswana'  data-imagecss="flag bw" data-title="Botswana">Botswana</option>

                    <option value='Belarus'  data-imagecss="flag by" data-title="Belarus">Belarus</option>

                    <option value='Belize'  data-imagecss="flag bz" data-title="Belize">Belize</option>

                    <option value='Cocos (Keeling) Islands'  data-imagecss="flag cc" data-title="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>

                    <option value='Democratic Republic of the Congo'  data-imagecss="flag cd" data-title="Democratic Republic of the Congo">Democratic Republic of the Congo</option>

                    <option value='Central African Republic'  data-imagecss="flag cf" data-title="Central African Republic">Central African Republic</option>

                    <option value='Congo'  data-imagecss="flag cg" data-title="Congo">Congo</option>

                    <option value='Switzerland'  data-imagecss="flag ch" data-title="Switzerland">Switzerland</option>

                    <option value='Cote D Ivoire (Ivory Coast)'  data-imagecss="flag ci" data-title="Cote D'Ivoire (Ivory Coast)">Cote D'Ivoire (Ivory Coast)</option>

                    <option value='Cook Islands'  data-imagecss="flag ck" data-title="Cook Islands">Cook Islands</option>

                    <option value='Chile'  data-imagecss="flag cl" data-title="Chile">Chile</option>

                    <option value='Cameroon'  data-imagecss="flag cm" data-title="Cameroon">Cameroon</option>

                    <option value='China'  data-imagecss="flag cn" data-title="China">China</option>

                    <option value='Colombia'  data-imagecss="flag co" data-title="Colombia">Colombia</option>

                    <option value='Costa Rica'  data-imagecss="flag cr" data-title="Costa Rica">Costa Rica</option>

                    <option value='Serbia and Montenegro'  data-imagecss="flag cs" data-title="Serbia and Montenegro">Serbia and Montenegro</option>

                    <option value='Cuba'  data-imagecss="flag cu" data-title="Cuba">Cuba</option>

                    <option value='Cape Verde'  data-imagecss="flag cv" data-title="Cape Verde">Cape Verde</option>

                    <option value='Christmas Island'  data-imagecss="flag cx" data-title="Christmas Island">Christmas Island</option>

                    <option value='Cyprus'  data-imagecss="flag cy" data-title="Cyprus">Cyprus</option>

                    <option value='Czech Republic'  data-imagecss="flag cz" data-title="Czech Republic">Czech Republic</option>

                    <option value='Germany'  data-imagecss="flag de" data-title="Germany">Germany</option>

                    <option value='Djibouti'  data-imagecss="flag dj" data-title="Djibouti">Djibouti</option>

                    <option value='Denmark'  data-imagecss="flag dk" data-title="Denmark">Denmark</option>

                    <option value='Dominica'  data-imagecss="flag dm" data-title="Dominica">Dominica</option>

                    <option value='Dominican Republic'  data-imagecss="flag do" data-title="Dominican Republic">Dominican Republic</option>

                    <option value='Algeria'  data-imagecss="flag dz" data-title="Algeria">Algeria</option>

                    <option value='Ecuador'  data-imagecss="flag ec" data-title="Ecuador">Ecuador</option>

                    <option value='Estonia'  data-imagecss="flag ee" data-title="Estonia">Estonia</option>

                    <option value='Egypt'  data-imagecss="flag eg" data-title="Egypt">Egypt</option>

                    <option value='Western Sahara'  data-imagecss="flag eh" data-title="Western Sahara">Western Sahara</option>

                    <option value='Eritrea'  data-imagecss="flag er" data-title="Eritrea">Eritrea</option>

                    <option value='Spain'  data-imagecss="flag es" data-title="Spain">Spain</option>

                    <option value='Ethiopia'  data-imagecss="flag et" data-title="Ethiopia">Ethiopia</option>

                    <option value='Finland'  data-imagecss="flag fi" data-title="Finland">Finland</option>

                    <option value='Fiji'  data-imagecss="flag fj" data-title="Fiji">Fiji</option>

                    <option value='Falkland Islands (Malvinas)'  data-imagecss="flag fk" data-title="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>

                    <option value='ederated States of Micronesia'  data-imagecss="flag fm" data-title="Federated States of Micronesia">Federated States of Micronesia</option>

                    <option value='Faroe Islands'  data-imagecss="flag fo" data-title="Faroe Islands">Faroe Islands</option>

                    <option value='France'  data-imagecss="flag fr" data-title="France">France</option>

                    <option value='France, Metropolitan'  data-imagecss="flag fx" data-title="France, Metropolitan">France, Metropolitan</option>

                    <option value='Gabon'  data-imagecss="flag ga" data-title="Gabon">Gabon</option>

                    <option value='Great Britain (UK)'  data-imagecss="flag gb" data-title="Great Britain (UK)">Great Britain (UK)</option>

                    <option value='Grenada'  data-imagecss="flag gd" data-title="Grenada">Grenada</option>

                    <option value='Georgia'  data-imagecss="flag ge" data-title="Georgia">Georgia</option>

                    <option value='French Guiana'  data-imagecss="flag gf" data-title="French Guiana">French Guiana</option>

                    <option value='Ghana'  data-imagecss="flag gh" data-title="Ghana">Ghana</option>

                    <option value='Gibraltar'  data-imagecss="flag gi" data-title="Gibraltar">Gibraltar</option>

                    <option value='Greenland'  data-imagecss="flag gl" data-title="Greenland">Greenland</option>

                    <option value='Gambia'  data-imagecss="flag gm" data-title="Gambia">Gambia</option>

                    <option value='Guinea'  data-imagecss="flag gn" data-title="Guinea">Guinea</option>

                    <option value='Guadeloupe'  data-imagecss="flag gp" data-title="Guadeloupe">Guadeloupe</option>

                    <option value='Equatorial Guinea'  data-imagecss="flag gq" data-title="Equatorial Guinea">Equatorial Guinea</option>

                    <option value='Greece'  data-imagecss="flag gr" data-title="Greece">Greece</option>

                    <option value='S. Georgia and S. Sandwich Islands'  data-imagecss="flag gs" data-title="S. Georgia and S. Sandwich Islands">S. Georgia and S. Sandwich Islands</option>

                    <option value='Guatemala'  data-imagecss="flag gt" data-title="Guatemala">Guatemala</option>

                    <option value='Guam'  data-imagecss="flag gu" data-title="Guam">Guam</option>

                    <option value='Guinea-Bissau'  data-imagecss="flag gw" data-title="Guinea-Bissau">Guinea-Bissau</option>

                    <option value='Guyana'  data-imagecss="flag gy" data-title="Guyana">Guyana</option>

                    <option value='Hong Kong'  data-imagecss="flag hk" data-title="Hong Kong">Hong Kong</option>

                    <option value='Heard Island and McDonald Islands'  data-imagecss="flag hm" data-title="Heard Island and McDonald Islands">Heard Island and McDonald Islands</option>

                    <option value='Honduras'  data-imagecss="flag hn" data-title="Honduras">Honduras</option>

                    <option value='Croatia (Hrvatska)'  data-imagecss="flag hr" data-title="Croatia (Hrvatska)">Croatia (Hrvatska)</option>

                    <option value='Haiti'  data-imagecss="flag ht" data-title="Haiti">Haiti</option>

                    <option value='Hungary'  data-imagecss="flag hu" data-title="Hungary">Hungary</option>

                    <option value='Indonesia'  data-imagecss="flag id" data-title="Indonesia">Indonesia</option>

                    <option value='Ireland'  data-imagecss="flag ie" data-title="Ireland">Ireland</option>

                    <option value='Israel'  data-imagecss="flag il" data-title="Israel">Israel</option>

                    <option value='India'  data-imagecss="flag in" data-title="India">India</option>

                    <option value='British Indian Ocean Territory'  data-imagecss="flag io" data-title="British Indian Ocean Territory">British Indian Ocean Territory</option>

                    <option value='Iraq'  data-imagecss="flag iq" data-title="Iraq">Iraq</option>

                    <option value='Iran'  data-imagecss="flag ir" data-title="Iran">Iran</option>

                    <option value='Iceland'  data-imagecss="flag is" data-title="Iceland">Iceland</option>

                    <option value='Italy'  data-imagecss="flag it" data-title="Italy">Italy</option>

                    <option value='Jamaica'  data-imagecss="flag jm" data-title="Jamaica">Jamaica</option>

                    <option value='Jordan'  data-imagecss="flag jo" data-title="Jordan">Jordan</option>

                    <option value='Japan'  data-imagecss="flag jp" data-title="Japan">Japan</option>

                    <option value='Kenya'  data-imagecss="flag ke" data-title="Kenya">Kenya</option>

                    <option value='Kyrgyzstan'  data-imagecss="flag kg" data-title="Kyrgyzstan">Kyrgyzstan</option>

                    <option value='Cambodia'  data-imagecss="flag kh" data-title="Cambodia">Cambodia</option>

                    <option value='Kiribati'  data-imagecss="flag ki" data-title="Kiribati">Kiribati</option>

                    <option value='Comoros'  data-imagecss="flag km" data-title="Comoros">Comoros</option>

                    <option value='Saint Kitts and Nevis'  data-imagecss="flag kn" data-title="Saint Kitts and Nevis">Saint Kitts and Nevis</option>

                    <option value='Korea (North)'  data-imagecss="flag kp" data-title="Korea (North)">Korea (North)</option>

                    <option value='Korea (South)'  data-imagecss="flag kr" data-title="Korea (South)">Korea (South)</option>

                    <option value='Kuwait'  data-imagecss="flag kw" data-title="Kuwait">Kuwait</option>

                    <option value='Cayman Islands'  data-imagecss="flag ky" data-title="Cayman Islands">Cayman Islands</option>

                    <option value='Kazakhstan'  data-imagecss="flag kz" data-title="Kazakhstan">Kazakhstan</option>

                    <option value='Laos'  data-imagecss="flag la" data-title="Laos">Laos</option>

                    <option value='Lebanon'  data-imagecss="flag lb" data-title="Lebanon">Lebanon</option>

                    <option value='Saint Lucia'  data-imagecss="flag lc" data-title="Saint Lucia">Saint Lucia</option>

                    <option value='Liechtenstein'  data-imagecss="flag li" data-title="Liechtenstein">Liechtenstein</option>

                    <option value='Sri Lanka'  data-imagecss="flag lk" data-title="Sri Lanka">Sri Lanka</option>

                    <option value='Liberia'  data-imagecss="flag lr" data-title="Liberia">Liberia</option>

                    <option value='Lesotho'  data-imagecss="flag ls" data-title="Lesotho">Lesotho</option>

                    <option value='Lithuania'  data-imagecss="flag lt" data-title="Lithuania">Lithuania</option>

                    <option value='Luxembourg'  data-imagecss="flag lu" data-title="Luxembourg">Luxembourg</option>

                    <option value='Latvia'  data-imagecss="flag lv" data-title="Latvia">Latvia</option>

                    <option value='Libya'  data-imagecss="flag ly" data-title="Libya">Libya</option>

                    <option value='Morocco'  data-imagecss="flag ma" data-title="Morocco">Morocco</option>

                    <option value='Monaco'  data-imagecss="flag mc" data-title="Monaco">Monaco</option>

                    <option value='Moldova'  data-imagecss="flag md" data-title="Moldova">Moldova</option>

                    <option value='Madagascar'  data-imagecss="flag mg" data-title="Madagascar">Madagascar</option>

                    <option value='Marshall Islands'  data-imagecss="flag mh" data-title="Marshall Islands">Marshall Islands</option>

                    <option value='Macedonia'  data-imagecss="flag mk" data-title="Macedonia">Macedonia</option>

                    <option value='Mali'  data-imagecss="flag ml" data-title="Mali">Mali</option>

                    <option value='Myanmar'  data-imagecss="flag mm" data-title="Myanmar">Myanmar</option>

                    <option value='Mongolia'  data-imagecss="flag mn" data-title="Mongolia">Mongolia</option>

                    <option value='Macao'  data-imagecss="flag mo" data-title="Macao">Macao</option>

                    <option value='Northern Mariana Islands'  data-imagecss="flag mp" data-title="Northern Mariana Islands">Northern Mariana Islands</option>

                    <option value='Martinique'  data-imagecss="flag mq" data-title="Martinique">Martinique</option>

                    <option value='Mauritania'  data-imagecss="flag mr" data-title="Mauritania">Mauritania</option>

                    <option value='Montserrat'  data-imagecss="flag ms" data-title="Montserrat">Montserrat</option>

                    <option value='Malta'  data-imagecss="flag mt" data-title="Malta">Malta</option>

                    <option value='Mauritius'  data-imagecss="flag mu" data-title="Mauritius">Mauritius</option>

                    <option value='Maldives'  data-imagecss="flag mv" data-title="Maldives">Maldives</option>

                    <option value='Malawi'  data-imagecss="flag mw" data-title="Malawi">Malawi</option>

                    <option value='Mexico'  data-imagecss="flag mx" data-title="Mexico">Mexico</option>

                    <option value='Malaysia'  data-imagecss="flag my" data-title="Malaysia">Malaysia</option>

                    <option value='Mozambique'  data-imagecss="flag mz" data-title="Mozambique">Mozambique</option>

                    <option value='Namibia'  data-imagecss="flag na" data-title="Namibia">Namibia</option>

                    <option value='New Caledonia'  data-imagecss="flag nc" data-title="New Caledonia">New Caledonia</option>

                    <option value='Niger'  data-imagecss="flag ne" data-title="Niger">Niger</option>

                    <option value='Norfolk Island'  data-imagecss="flag nf" data-title="Norfolk Island">Norfolk Island</option>

                    <option value='Nigeria'  data-imagecss="flag ng" data-title="Nigeria">Nigeria</option>

                    <option value='Nicaragua'  data-imagecss="flag ni" data-title="Nicaragua">Nicaragua</option>

                    <option value='Netherlands'  data-imagecss="flag nl" data-title="Netherlands">Netherlands</option>

                    <option value='Norway'  data-imagecss="flag no" data-title="Norway">Norway</option>

                    <option value='Nepal'  data-imagecss="flag np" data-title="Nepal">Nepal</option>

                    <option value='Nauru'  data-imagecss="flag nr" data-title="Nauru">Nauru</option>

                    <option value='Niue'  data-imagecss="flag nu" data-title="Niue">Niue</option>

                    <option value='New Zealand (Aotearoa)'  data-imagecss="flag nz" data-title="New Zealand (Aotearoa)">New Zealand (Aotearoa)</option>

                    <option value='Oman'  data-imagecss="flag om" data-title="Oman">Oman</option>

                    <option value='Panama'  data-imagecss="flag pa" data-title="Panama">Panama</option>

                    <option value='Peru'  data-imagecss="flag pe" data-title="Peru">Peru</option>

                    <option value='French Polynesia'  data-imagecss="flag pf" data-title="French Polynesia">French Polynesia</option>

                    <option value='Papua New Guinea'  data-imagecss="flag pg" data-title="Papua New Guinea">Papua New Guinea</option>

                    <option value='Philippines'  data-imagecss="flag ph" data-title="Philippines">Philippines</option>

                    <option value='Pakistan'  data-imagecss="flag pk" data-title="Pakistan">Pakistan</option>

                    <option value='Poland'  data-imagecss="flag pl" data-title="Poland">Poland</option>

                    <option value='Saint Pierre and Miquelon'  data-imagecss="flag pm" data-title="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>

                    <option value='Pitcairn'  data-imagecss="flag pn" data-title="Pitcairn">Pitcairn</option>

                    <option value='Puerto Rico'  data-imagecss="flag pr" data-title="Puerto Rico">Puerto Rico</option>

                    <option value='Palestinian Territory'  data-imagecss="flag ps" data-title="Palestinian Territory">Palestinian Territory</option>

                    <option value='Portugal'  data-imagecss="flag pt" data-title="Portugal">Portugal</option>

                    <option value='Palau'  data-imagecss="flag pw" data-title="Palau">Palau</option>

                    <option value='Paraguay'  data-imagecss="flag py" data-title="Paraguay">Paraguay</option>

                    <option value='Qatar'  data-imagecss="flag qa" data-title="Qatar">Qatar</option>

                    <option value='Reunion'  data-imagecss="flag re" data-title="Reunion">Reunion</option>

                    <option value='Romania'  data-imagecss="flag ro" data-title="Romania">Romania</option>

                    <option value='Russian Federation'  data-imagecss="flag ru" data-title="Russian Federation">Russian Federation</option>

                    <option value='Rwanda'  data-imagecss="flag rw" data-title="Rwanda">Rwanda</option>

                    <option value='Saudi Arabia'  data-imagecss="flag sa" data-title="Saudi Arabia">Saudi Arabia</option>

                    <option value='Solomon Islands'  data-imagecss="flag sb" data-title="Solomon Islands">Solomon Islands</option>

                    <option value='Seychelles'  data-imagecss="flag sc" data-title="Seychelles">Seychelles</option>

                    <option value='Sudan'  data-imagecss="flag sd" data-title="Sudan">Sudan</option>

                    <option value='Sweden'  data-imagecss="flag se" data-title="Sweden">Sweden</option>

                    <option value='Singapore'  data-imagecss="flag sg" data-title="Singapore">Singapore</option>

                    <option value='Saint Helena'  data-imagecss="flag sh" data-title="Saint Helena">Saint Helena</option>

                    <option value='Slovenia'  data-imagecss="flag si" data-title="Slovenia">Slovenia</option>

                    <option value='Svalbard and Jan Mayen'  data-imagecss="flag sj" data-title="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>

                    <option value='Slovakia'  data-imagecss="flag sk" data-title="Slovakia">Slovakia</option>

                    <option value='Sierra Leone'  data-imagecss="flag sl" data-title="Sierra Leone">Sierra Leone</option>

                    <option value='San Marino'  data-imagecss="flag sm" data-title="San Marino">San Marino</option>

                    <option value='Senegal'  data-imagecss="flag sn" data-title="Senegal">Senegal</option>

                    <option value='Somalia'  data-imagecss="flag so" data-title="Somalia">Somalia</option>

                    <option value='Suriname'  data-imagecss="flag sr" data-title="Suriname">Suriname</option>

                    <option value='Sao Tome and Principe'  data-imagecss="flag st" data-title="Sao Tome and Principe">Sao Tome and Principe</option>

                    <option value='USSR (former)'  data-imagecss="flag su" data-title="USSR (former)">USSR (former)</option>

                    <option value='El Salvador'  data-imagecss="flag sv" data-title="El Salvador">El Salvador</option>

                    <option value='Syria'  data-imagecss="flag sy" data-title="Syria">Syria</option>

                    <option value='Swaziland'  data-imagecss="flag sz" data-title="Swaziland">Swaziland</option>

                    <option value='Turks and Caicos Islands'  data-imagecss="flag tc" data-title="Turks and Caicos Islands">Turks and Caicos Islands</option>

                    <option value='Chad'  data-imagecss="flag td" data-title="Chad">Chad</option>

                    <option value='French Southern Territories'  data-imagecss="flag tf" data-title="French Southern Territories">French Southern Territories</option>

                    <option value='Togo'  data-imagecss="flag tg" data-title="Togo">Togo</option>

                    <option value='Thailand'  data-imagecss="flag th" data-title="Thailand">Thailand</option>

                    <option value='Tajikistan'  data-imagecss="flag tj" data-title="Tajikistan">Tajikistan</option>

                    <option value='Tokelau'  data-imagecss="flag tk" data-title="Tokelau">Tokelau</option>

                    <option value='Timor-Leste'  data-imagecss="flag tl" data-title="Timor-Leste">Timor-Leste</option>

                    <option value='Turkmenistan'  data-imagecss="flag tm" data-title="Turkmenistan">Turkmenistan</option>

                    <option value='Tunisia'  data-imagecss="flag tn" data-title="Tunisia">Tunisia</option>

                    <option value='Tonga'  data-imagecss="flag to" data-title="Tonga">Tonga</option>

                    <option value='East Timor'  data-imagecss="flag tp" data-title="East Timor">East Timor</option>

                    <option value='Turkey'  data-imagecss="flag tr" data-title="Turkey">Turkey</option>

                    <option value='Trinidad and Tobago'  data-imagecss="flag tt" data-title="Trinidad and Tobago">Trinidad and Tobago</option>

                    <option value='Tuvalu'  data-imagecss="flag tv" data-title="Tuvalu">Tuvalu</option>

                    <option value='Taiwan'  data-imagecss="flag tw" data-title="Taiwan">Taiwan</option>

                    <option value='Tanzania'  data-imagecss="flag tz" data-title="Tanzania">Tanzania</option>

                    <option value='Ukraine'  data-imagecss="flag ua" data-title="Ukraine">Ukraine</option>

                    <option value='Uganda'  data-imagecss="flag ug" data-title="Uganda">Uganda</option>

                    <option value='United Kingdom'  data-imagecss="flag uk" data-title="United Kingdom">United Kingdom</option>

                    <option value='United States Minor Outlying Islands'  data-imagecss="flag um" data-title="United States Minor Outlying Islands">United States Minor Outlying Islands</option>

                    <option value='Uruguay'  data-imagecss="flag uy" data-title="Uruguay">Uruguay</option>

                    <option value='Uzbekistan'  data-imagecss="flag uz" data-title="Uzbekistan">Uzbekistan</option>

                    <option value='Vatican City State (Holy See)'  data-imagecss="flag va" data-title="Vatican City State (Holy See)">Vatican City State (Holy See)</option>

                    <option value='Saint Vincent and the Grenadines'  data-imagecss="flag vc" data-title="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>

                    <option value='Venezuela'  data-imagecss="flag ve" data-title="Venezuela">Venezuela</option>

                    <option value='Virgin Islands (British)'  data-imagecss="flag vg" data-title="Virgin Islands (British)">Virgin Islands (British)</option>

                    <option value='Virgin Islands (U.S.)'  data-imagecss="flag vi" data-title="Virgin Islands (U.S.)">Virgin Islands (U.S.)</option>

                    <option value='Viet Nam'  data-imagecss="flag vn" data-title="Viet Nam">Viet Nam</option>

                    <option value='Vanuatu'  data-imagecss="flag vu" data-title="Vanuatu">Vanuatu</option>

                    <option value='Wallis and Futuna'  data-imagecss="flag wf" data-title="Wallis and Futuna">Wallis and Futuna</option>

                    <option value='Samoa'  data-imagecss="flag ws" data-title="Samoa">Samoa</option>

                    <option value='Yemen'  data-imagecss="flag ye" data-title="Yemen">Yemen</option>

                    <option value='Mayotte'  data-imagecss="flag yt" data-title="Mayotte">Mayotte</option>

                    <option value='Yugoslavia (former)'  data-imagecss="flag yu" data-title="Yugoslavia (former)">Yugoslavia (former)</option>

                    <option value='South Africa'  data-imagecss="flag za" data-title="South Africa">South Africa</option>

                    <option value='Zambia'  data-imagecss="flag zm" data-title="Zambia">Zambia</option>

                    <option value='Zaire (former)'  data-imagecss="flag zr" data-title="Zaire (former)">Zaire (former)</option>

                    <option value='Zimbabwe'  data-imagecss="flag zw" data-title="Zimbabwe">Zimbabwe</option>

                </select>

			</div>

			<div id="primary_destination_State_div">

				<div class="col-md-4" style="text-align: left; float:left;">

					<select name="primary_destination_State" class="form-control form-select" id="primary_destination_State" autocomplete="off" required>

						<option value=""> --- Primary destination in Canada ---</option>

						<option value="Alberta">Alberta</option>

						<option value="British Columbia">British Columbia</option>

						<option value="Manitoba">Manitoba</option>

						<option value="New Brunswick">New Brunswick</option>

						<option value="Newfoundland">Newfoundland</option>

						<option value="North West Territories">North West Territories</option>

						<option value="Nova Scotia">Nova Scotia</option>

						<option value="Nunavut">Nunavut</option>

						<option value="Ontario" selected>Ontario</option>

						<option value="Prince Edward Island">Prince Edward Island</option>

						<option value="Quebec">Quebec</option>

						<option value="Saskatchewan">Saskatchewan</option>

						<option value="Yukon Territory">Yukon Territory</option>

					</select>

				</div>

			</div>


			

			<div class="form-group">

			<div id="do_you_smoke">

				<div class="col-md-5 " >

					<label class="input-label">Do you Smoke ?</label>

				</div>

				<div class="col-md-7 col-xs-12 " style="text-align: left; float:left;">

					<select name="primary_destination_State" class="form-control form-select" id="primary_destination_State" autocomplete="off" required>

						<option value=""> --- Please choose ---</option>

						<option value="yes">Yes</option>

						<option value="no">No</option>

					</select>

				</div>

			</div>
<div class="clearfix"></div>
			</div>

			

			<div id="usa_stop_div" style="display:none;">


				<div class="col-md-4">

				<select name="usa_stop" id="usa_stop" aria-invalid="false" class="form-control" required>



                       <?php  for($i=0;$i<=$allow_input_field['us_stop_days'];$i++): 

                            

                           if($allow_input_field['us_stop_days'] == 0 ):



                            echo "<option selected='' value='0'>None</option>";

                                

                            else:



                             echo  "<option value='$i'>$i days</option>";

                            endif;  

                        endfor; ?>

                    </select>

				</div>


			</div>


	        <?php } else {  ?>

        <div class="col-md-4">

        <select name="primary_destination" class="form-control" id="primary_destination" autocomplete="off" required>

            <option value=""> --- Primary destination in Canada ---</option>

            <option value="Alberta" selected="">Alberta</option>

            <option value="British Columbia">British Columbia</option>

            <option value="Manitoba">Manitoba</option>

            <option value="New Brunswick">New Brunswick</option>

            <option value="Newfoundland">Newfoundland</option>

            <option value="North West Territories">North West Territories</option>

            <option value="Nova Scotia">Nova Scotia</option>

            <option value="Nunavut">Nunavut</option>

            <option value="Ontario" selected>Ontario</option>

            <option value="Prince Edward Island">Prince Edward Island</option>

            <option value="Quebec">Quebec</option>

            <option value="Saskatchewan">Saskatchewan</option>

            <option value="Yukon Territory">Yukon Territory</option>

        </select>

     </div>


<?php } } ?>

        <!-- Destination ends -->

</div>


<div class="clear:both;"></div>
<div class="col-md-12" style="margin: 50px 0;padding: 0;">
<div class="col-md-5 col-xs-12" style="padding: 0;">
<button class="btn btn-default" style="padding: 5px 40px; font-weight: bold; font-size: 16px; display: block;border-radius: 50px;  color:#333 !important;background: #FFF !important;box-shadow: none !important; margin-bottom:10px;" id="backbtn" type="button" onclick="$('.page_1').show();$('.page_2').hide('slow');"><i class="fa fa-arrow-circle-left"></i> Back</button>
</div>
<div class="col-md-7 col-xs-12" style="padding: 0;">
<button type="submit" id="getquote" style="font-size:16px;" class="btn nextbtn pull-right"> Continue <i class="fa fa-arrow-circle-right"></i></button>
</div>
</div>

</div>

<span id="family_error" class="col-md-12" style="display: none; font-size: 16px;font-weight: bold;text-align: left;padding: 20px; color:yellow;"><i class="fa fa-warning"></i> </span><br/>

<?php if($allow_input_field['Country'] == "on" ){?>
<?php
if($allowed_input_fields[0]->pro_travel_destination == 'worldwide'){
?>
<?php } ?>
<?php } ?>

			
<input type="hidden" name="broker" value="<?php echo $_REQUEST['broker']; ?>">     
<input type="hidden" name="agent" value="<?php echo $_REQUEST['agent']; ?>">
<input type="hidden" name="skip_coverage" value="yes">
</form>
</div>
</div>

</div>
</section>

      	<div class="col-md-12 col-sm-12 col-xs-12">
		
		<!--<div class="center m-t-30px" style="text-align: center;">
			<button type="submit" name="GET QUOTES" id="getquote" class="btn bg-red show-loading-popup">GET QUOTES</button>
		  </div>-->
	    </div>

<script>
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

function numoftravelers(){
if(document.getElementById('familyplan_temp').value == 'yes'){
checkfamilyplan();
}

$("#number_travelers").on("change", function(){
var number_of_traveller = $(this).val();
var aa = "";
for(var i=2; i<=number_of_traveller; i++){
var aa = aa + $("#birthday")[0].outerHTML;
}

$("#birthday_view").html(aa);
//console.log( $(".birthday")[0] );
})

}


</script>

<script>
/*
    new When({
        input: document.getElementById('daterange'),
		double: true,
		labelTo: 'End Date',
        labelFrom: 'Start Date'
    });

    new When({
        input: document.getElementById('departure_date'),
        singleDate: true
    });


$(document).ready(function() {
		  $('.trigger').click(function(){
			  $('body').addClass('display-header');
			  $('#header-trigger').removeClass('trigger');
			  $('#header-trigger').addClass('removeheader');
		  });
		  
		  $('.removeheader').click(function(){
			  $('body').removeClass('display-header');
			  $('#header-trigger').addClass('trigger');
			  $('#header-trigger').removeClass('removeheader');
		  });
});
*/
      jQuery(document).ready(function() {
		  
		  var tempvalue = localStorage.getItem("dateRange");
		 if(tempvalue){
			 document.getElementById('daterange').value = tempvalue;
			applychanges();
			document.getElementById('daterange').focus;
			//alert(tempvalue);
		} else {
			document.getElementById('daterange').value = '';
		}

       //jQuery("#primary_destination").msDropdown();
       });


    jQuery(document).ready(function($){
		
		//applychanges();
 /* 		
        $("#number_travelers").on("change", function(){
            var number_of_traveller = $(this).val();
            var aa = "";
            for(var i=2; i<=number_of_traveller; i++){
                var aa = aa + $("#birthday")[0].outerHTML;
            }

            $("#birthday_view").html(aa);
            console.log( $(".birthday")[0] );
        })
*/
 
      <?php
//    if(isset($allow_input_field['fplan']) && $allow_input_field['fplan'] == "on" ){ ?>
 /*    $('button[type="submit"]').click(function() {
            if($("select[name=number_travelers]").val()>1  && $("select[name=familyplan]").val() == "1"){
                var counter = 0;
                var aged=[];

                $("select[name=birth_month\\[\\]]").each(function(){
                    //alert( $("select[name=birth_month\\[\\]]").eq(counter).val() );
                    var d = new Date( $("select[name=birth_year\\[\\]]").eq(counter).val() ,   $("select[name=birth_month\\[\\]]").eq(counter).val()-1,  $("select[name=birth_day\\[\\]]").eq(counter).val() );
                    var tDate = new Date();
                    var age=tDate.getFullYear() - d.getFullYear();
                    aged.push(age);

                    var max=Math.max.apply(Math,aged);
                    var min=Math.min.apply(Math,aged);
                    //if((max>="21" && max<="58") && (min>="1" && min<"21")){
                    if((max < 58) && (min >0 && min < 21)){
                        $("#familymsg").hide();
                        return true;
                    }else{
                        $("#familymsg").show();
                        return false;
                    }

                    counter++;
                })
            }else{
                $("#familymsg").hide();
            }
        });*/

      <?php //} ?>
 
/* $('#getquote').click(function(){

var deparature = $('#departure_date').val();
$('#departuredate').val(deparature);

var returndate = $('#return_date').val();
$('#returndate').val(returndate);


 });
*/
    });
</script>
<script>
/*jQuery(function($) {
var divList = $(".listing-item");
divList.sort(function(a, b){ return $(a).data("listing-price")-$(b).data("listing-price")});
$("#listprices").html(divList);
})*/
</script>
<script>
(function ( $ ) {
	$.fn.bootstrapNumber = function( options ) {

		var settings = $.extend({
			upClass: 'default',
			downClass: 'default',
			upText: '+',
			downText: '-',
			center: true
			}, options );

		return this.each(function(e) {
			var self = $(this);
			var clone = self.clone(true, true);

			var min = self.attr('min');
			var max = self.attr('max');
			var step = parseInt(self.attr('step')) || 1;

			function setText(n) {
				if (isNaN(n) || (min && n < min) || (max && n > max)) {
					return false;
				}

				clone.focus().val(n);
				clone.trigger('change');
				return true;
			}

			var group = $("<div class='input-group'></div>");
			var down = $("<button type='button'>" + settings.downText + "</button>").attr('class', 'btn btn-' + settings.downClass).click(function() {
				setText(parseInt(clone.val() || clone.attr('value')) - step);
			});
			var up = $("<button type='button'>" + settings.upText + "</button>").attr('class', 'btn btn-' + settings.upClass).click(function() {
				setText(parseInt(clone.val() || clone.attr('value')) + step);
			});
			$("<span class='input-group-btn'></span>").append(down).appendTo(group);
			clone.appendTo(group);
			if(clone && settings.center) {
				clone.css('text-align', 'center');
			}
			$("<span class='input-group-btn'></span>").append(up).appendTo(group);

			// remove spins from original
			clone.prop('type', 'text').keydown(function(e) {
				if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
					(e.keyCode == 65 && e.ctrlKey === true) ||
					(e.keyCode >= 35 && e.keyCode <= 39)) {
					return;
				}
				if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
					e.preventDefault();
				}

				var c = String.fromCharCode(e.which);
				var n = parseInt(clone.val() + c);

				if ((min && n < min) || (max && n > max)) {
					e.preventDefault();
				}
			});

			self.replaceWith(group);
		});
	};
} ( jQuery ));

</script>
<script>
$('.after').bootstrapNumber();
$('#colorful').bootstrapNumber({
	upClass: 'success',
	downClass: 'danger'
});
</script>