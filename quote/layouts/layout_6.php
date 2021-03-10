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
padding-right: 0px;
color: #999;
padding-top: 3px;
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
font-size: 1rem;
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
border-radius: 30px 0 0 30px !important;
}
.daterangepicker td.end-date {
border-radius: 0 30px 30px 0 !important;	
}

.durationtext {
font-size: 16px;
font-weight: bold;
display: inline-block;
text-align: left;
float: left;
}
.duration_days {
color:#35ad8c;
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

.daterangepicker td.active, .daterangepicker td.active {
	background-color: #44bc9b !important;
}
.daterangepicker .calendar-table th, .daterangepicker .calendar-table td {
padding: 8px !important;
font-size: 15px !important;
line-height: 17px !important;
}
.daterangepicker th.month {
font-weight: bold !important;	
}
</style>
<?php if($supervisa == 'yes'){?>
<!--
<style>
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
-->
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <link id="bsdp-css" href="https://uxsolutions.github.io/bootstrap-datepicker/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet">
	<script src="https://uxsolutions.github.io/bootstrap-datepicker/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
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

</style>

<?php } else {?>
<script type="text/javascript" src="daterangepicker/jquery.min.js"></script>
<script type="text/javascript" src="daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="daterangepicker/daterangepicker.css" />
<?php } ?>
<style>
*, *:before, *:after {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.clearfix {
clear:both;
}
.breadcrumbs ul {
  list-style: none;
}

.cf {
  &:before, &:after { content: ' '; display: table; }
  &:after { clear: both; }
}

.inner {
  max-width: 820px;
  margin: 0 auto;
}

body .wizzard ul {
  margin: 0;
  padding: 0;
}

body .wizzard ul:after {
  content: "";
  display: block;
  clear: both;
}

body .wizzard ul li {
  display: inline-block;
  width: 25%;
  margin: 0;
  padding: 25px 0;
  float: left;
  text-align: center;
  position: relative;
}

body .wizzard ul li p {
  font-size: 14px;
  line-height: 16px;
  min-height: 32px;
  
}

body .wizzard ul li span {
  display: inline-block;
  background-color: #FFF;
  width: 60px;
  height: 60px;
  line-height: 60px;
  position: relative;
  overflow: hidden;
  border-radius: 100%;
  z-index: 9;
  box-shadow: 0 0 7px 0 rgba(0, 0, 0, 0.2);
}

body .wizzard ul li span strong {
  width: 70px;
  height: 70px;
  line-height: 70px;
  display: inline-block;
  background-color: #c1c1c1;
  position: absolute;
  top: 80%;
  left: 0;
  display:none;
}

body .wizzard ul li span i {
  position: relative;
  display: block;
  background-color: #f4f4f4;
  z-index: 9;
  border-radius: 100%;
  width: 36px;
  height: 36px;
  line-height: 36px;
  margin: 12px auto 0;
  font-style: normal;
  box-shadow: -webkit-0 0 7px 0 rgba(0, 0, 0, 0.2);
  box-shadow: -moz-0 0 7px 0 rgba(0, 0, 0, 0.2);
  box-shadow: -ms-0 0 7px 0 rgba(0, 0, 0, 0.2);
  box-shadow: -o-0 0 7px 0 rgba(0, 0, 0, 0.2);
  box-shadow: 0 0 7px 0 rgba(0, 0, 0, 0.2);
  font-size: 34px;
  color: #f4f4f4;
  
  font-weight: 600;
}

body .wizzard ul li em {
  position: absolute;
  width: 100%;
  height: 8px;
  background-color: #d6d6d6;
  display: block;
  bottom: 60px;
  right: -50%;
  box-shadow: -webkit-0 0 7px 0 rgba(0, 0, 0, 0.2) inset;
  box-shadow: -moz-0 0 7px 0 rgba(0, 0, 0, 0.2) inset;
  box-shadow: -ms-0 0 7px 0 rgba(0, 0, 0, 0.2) inset;
  box-shadow: -o-0 0 7px 0 rgba(0, 0, 0, 0.2) inset;
  box-shadow: 0 0 7px 0 rgba(0, 0, 0, 0.2) inset;
}

body .wizzard ul li.active {
  position: relative;
}

body .wizzard ul li.active:after {
  content: '';
  position: absolute;
  border-style: solid;
  border-width: 0 15px 15px;
  border-color: #FFFFFF transparent;
  display: block;
  width: 0;
  z-index: 1;
  bottom: 0;
  left: 0;
  right: 0;
  margin: auto;
}

body .wizzard ul li.active:before {
  content: '';
  position: absolute;
  border-style: solid;
  border-width: 0 16px 16px;
  border-color: rgba(0, 0, 0, 0.1) transparent;
  display: block;
  width: 0;
  z-index: 1;
  bottom: 0;
  left: 0;
  right: 0;
  margin: auto;
  display:none;
}

body .wizzard ul li.active span {
  position: relative;
}

body .wizzard ul li.active span strong {
  background-color: #FFF;
  display:none;
}

body .wizzard ul li.active span i {
  color: #44bc9b;
  background-color: #44bc9b;
}

body .wizzard ul li.passed span strong {
  top: 0 !important;
  background-color: #00c2a2;
}

body .wizzard ul li.passed span i {
  color: #00c2a2;
}

body .wizzard ul li.passed em {
  background-color: #00c2a2;
}

body .wizzard ul li:nth-child(2) span strong {
  top: 60%;
}

body .wizzard ul li:nth-child(3) span strong {
  top: 40%;
}

body .wizzard ul li:nth-child(4) span strong {
  top: 20%;
}

body .wizzard ul li:nth-child(5) span strong {
  top: 0;
}

body .wizzard ul li:nth-child(5) em {
  display: none;
}

input.question + span {
  display: block;
  position: relative;
  white-space: nowrap;
  padding: 0;
  margin: 0;
  width: 30%;
  border-top: 1px solid white;
  -webkit-transition: width 0.4s ease;
  transition: width 0.4s ease;
  height: 0px;	
  margin:0 auto;
}
input.question:focus + span {
  width: 80%;	
}
.form-control {
border: 1px solid #333 !important;
height: 35px !important;
padding: 0 15px !important;
font-size: 14px;
overflow: hidden;
color: #333 !important;
}
.inputheading {
text-align: center !important;
margin-bottom:10px !important;
}
.inputheading i{
color: #00c0a1;
font-size: 28px;
width: 50px;
height: 50px;
line-height: 50px;
text-align: center;
border: 2px solid #c1c1c1;
border-radius: 100%;
display: block;
margin: 0 auto;	
margin-bottom: 10px;
}
label {
    font-weight: 700 !important;
    text-align: center !important;
    margin: 20px 0 0 !important;
}

.radio-container {
position: relative;
padding-left: 25px;
margin-bottom: 12px;
cursor: pointer;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default radio button */
.radio-container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom radio button */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 18px;
  width: 18px;
  background-color: #eee;
  border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.radio-container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.radio-container input:checked ~ .checkmark {
  background-color: #009c7d;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.radio-container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.radio-container .checkmark:after {
  top: 5px;
  left: 5px;
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: white;
}

.next-btn {
background-color: #2aa281 !important;
color: #FFF;
background-image: -webkit-gradient(linear, left top, left bottom, from(#44bc9b), to(#2aa281));
}
.next-btn:hover {
	background-image: -webkit-gradient(linear, left top, left bottom, from(#2aa281), to(#44bc9b));	
}
.listing-item {	
display: block;
padding: 10px;
}

</style>
<!--<div class="row">
	<div class="col-md-12 text-center">
	<h1 style="font-weight:bold;margin: 0px;" class="text-danger"><strong><?php echo $product_name;?></strong></h1>
	<h2 style="margin: 0px;">To start, we have a few quick questions to understand your needs.<h2>
	</div>
</div>-->
<div class="clearfix"></div>
<div class="wizzard hidden-xs">
<div class="container">
<ul>
<li class="active " id="set1"> <p>About You</p><span><i>1</i><strong></strong></span><em></em> </li>
<li class=" " id="set2"> <p>See Rates &amp; Select Your Plan</p><span><i>2</i><strong></strong></span><em></em> </li>
<li class="" id="set3"> <p>Contact Details</p><span><i>3</i><strong></strong></span><em></em> </li>
<li class="" id="set4"> <p>Receive Your Policy by E-Mail</p><span><i>4</i><strong></strong></span> </li>
</ul>
</div>
<div class="clear"></div> 
</div>
<div class="clearfix"></div>
<div class="container text-center">
<h2 style="font-size: 30px;margin: 0;padding: 0 0 5px;color: #00c2a2;font-weight: 600;font-family: arial;margin-top: 30px;"><?php echo $product_name;?></h2>
<p style="line-height: normal;">To start, we have a few quick questions to understand your needs.</p>
<hr>
</div>
<div class="clearfix"></div>
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
<form action="vtc_results.php" method="get"   id="dh-get-quote"   class="form-horizontal form-layout2" role="form"  >
<div class="container" style="padding: 40px 0;" id="listprices">

<div class="col-md-12 control-label no-padding" style="display:none;">
                         <h2 class="inputheading">Please Wait...</h2>
</div>

    <?php
    if($allow_input_field['sum_insured'] == "on" ){ $num = array_search("sum_insured", $position_array); $current_values[$num] = 'group_14'; //array_push($current_values, 'group_14'); ?>
	<div class="col-md-4 listing-item" id="group_14" style="display:none;" data-listing-price="<?php echo array_search("sum_insured", $position_array);?>">
        <div class="col-md-12 control-label no-padding">
			<h2 class="inputheading"><i class="fa fa-dollar"></i> Sum of Insured Amount?</h2>
        </div>
        <div class="col-md-12 no-padding">
            <select name="sum_insured2" class="form-control question" id="sum_insured2" autocomplete="off" required>
                <?php
				$sumin = mysqli_query($db, "SELECT `sum_insured` FROM `wp_dh_insurance_plans_rates` WHERE `plan_id` IN (SELECT `id` FROM `wp_dh_insurance_plans` WHERE `product`='$product_id') GROUP BY `sum_insured` ORDER BY CAST(`sum_insured` AS DECIMAL)");
				while($suminsu = mysqli_fetch_assoc($sumin)){
				$sum_insured = $suminsu['sum_insured'];
				?>
                    <option value="<?php echo $sum_insured; ?>">$<?php echo number_format($sum_insured); ?> </option>
                <?php } ?>
            </select>
			<span></span>
        </div>
	
	</div>		
    <?php } ?>
	
	       <?php if($allow_input_field['sdate'] == "on" ){ $num = array_search("sdate", $position_array); $current_values[$num] = 'group_8'; //array_push($current_values, 'group_8'); ?>
	  <div class="col-md-4 listing-item" id="group_8" style="display:none;" data-listing-price="<?php echo array_search("sdate", $position_array);?>">
	<div class="col-md-12" style="padding-bottom: 7px;">
	<h2 class="inputheading"><i class="fa fa-calendar"></i> Duration of Coverage?</h2>
	</div>
<div class="col-md-12">
			<?php if($supervisa == 'yes'){?>
<input  id="departure_date"  name="departure_date" placeholder="Start Date" value="" class="form-control" type="text" required <?php if($supervisa == 'yes'){?> onchange="supervisayes()" <?php } ?>>
<i class="fa fa-calendar" onclick="$('#departure_date').focus();" style="position: absolute;top: 9px;right: 25px !important;font-size: 16px;color: #01a281;"></i>

<script>
$('#departure_date').datepicker({
format: 'yyyy-mm-dd',
todayHighlight:'TRUE',
autoclose: true,
});
</script>
					
<?php } else { ?>
<input type="text" name="daterange" id="daterange" class="form-control" autocomplete="false" value="" placeholder="Start Date | End Date" />
<i class="fa fa-calendar" onclick="$('#daterange').focus();" style="position: absolute;top: 9px;right: 25px !important;font-size: 16px;color: #01a281;"></i>
<script>
$(function() {
  $('input[name="daterange"]').daterangepicker({
    opens: 'left',
  }, function(start, end, label) {
	 document.getElementById('departure_date').value = start.format('YYYY-MM-DD');
	 document.getElementById('return_date').value = end.format('YYYY-MM-DD');
//Calculation of Duration:
var date1 = new Date(start.format('YYYY-MM-DD'));
var date2 = new Date(end.format('YYYY-MM-DD'));
var timeDiff = Math.abs(date2.getTime() - date1.getTime());
var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24) + 1); 
$('.duration_days').html(diffDays+' Days');
//console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
});
</script>
<input type="hidden" name="departure_date" id="departure_date" value="">
<?php } ?>
<input type="hidden" name="return_date" id="return_date" value="">
			
			
        </div>
	</div>
    <?php } ?>	


	       <?php   if($allow_input_field['dob'] == "on" ){  $num = array_search("dob", $position_array); $current_values[$num] = 'group_3'; //array_push($current_values, 'group_3');  ?>
<div class="col-md-4 listing-item" id="group_3" style="display:none;" data-listing-price="<?php echo array_search("dob", $position_array);?>">
       
        <div class="col-md-12 control-label ">
            <h2 class="inputheading"><i class="fa fa-calendar"></i> What is your Date of Birth ? </h2>
        </div>
		
        <div class="col-md-12 no-padding" id="birthday">
		
		<div class="col-md-12 agesdiv" id="agesdiv">
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
<input type="text" name="years[]" id="years[]" style="margin-top: -5px !important;display: block;" />
</div>
<div class="col-md-2 text-center" style="padding-top: 10px;">
or
</div>
<div class="col-md-5" style="padding-top: 10px;">
<a style="cursor: pointer;" onclick="$('.dobdiv').show(); $('.yearsdiv').hide()">Enter Date if Birth</a>
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
<input type="text" name="years[]" id="years[]" style="margin-top: -5px !important;display: block;">
</div>
</div>
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
<input type="checkbox" id="switch" style="float:right;" onclick="checkadditionals();" /><label for="switch">Toggle</label>
<input type="hidden" id="temp_addi" value="0" />
<script>
function checkadditionals(){
if(document.getElementById('switch').checked == true){
document.getElementById('temp_addi').value = 1;
$('.additionals').show();	
} else {
document.getElementById('temp_addi').value = 0;
$('.additionals').hide();	
}
}
</script>
</div>
</div>
<div class="col-md-12 no-padding additionals" style="display:none;">
<div class="birthday">
<div class="col-md-3 add_1" style="padding-left: 0;">
<small style="font-size: 12px;color: #999;">Age</small>
<input type="text" name="years[]" id="years[]" style="margin-top: -5px !important;display: block;" />
</div>
</div>
<input type="hidden" id="current_adds" value="1" />
<input type="hidden" id="number_travelers" name="number_travelers" value="1">
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
<a class="addmorebtn" onclick="addtravellers();"><i class="fa fa-plus" style="position: relative;top: -1px;left: 0px;"></i></a>
</div>
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
}
</script>
</div>

<div class="clear:both;"></div>

</div>
</div>

		
        </div>


    <div id="birthday_view"></div>


 <!-- Age calculator ends -->

    <div style="clear:both;"> </div>

	
</div>	
 <?php } ?>
 
 

 
            <?php if($allow_input_field['fname'] == "on" ){ $num = array_search("fname", $position_array); $current_values[$num] = 'group_1'; //array_push($current_values, 'group_1');?>
<div class="col-md-4 listing-item" id="group_1" style="display:none;" data-listing-price="<?php echo array_search("fname", $position_array);?>">
                          <div class="col-md-12 control-label no-padding">
                         <h2 class="inputheading"><i class="fa fa-user"></i> What is your first name ?</h2>
                        </div>
                        <div class="col-md-12 no-padding">	
                    <input  id="fname" name="fname" class="form-control question text-center" required placeholder="Enter your first name" type="text" >
					<span></span>
                        </div>
        
</div>
            <?php } ?>
			 
            <?php
            if($allow_input_field['lname'] == "on" ){ $num = array_search("lname", $position_array); $current_values[$num] = 'group_2'; //array_push($current_values, 'group_2'); ?>
                       <div class="col-md-4 listing-item" id="group_2" style="display:none;" data-listing-price="<?php echo array_search("lname", $position_array);?>">
					   <div class="col-md-12 control-label no-padding">
                         <h2 class="inputheading"><i class="fa fa-user"></i> What is your last name ?</h2>
                        </div>
                         <div class="col-md-12 no-padding">
                    <input  id="lname" name="lname" class="form-control question text-center" required  type="text" placeholder="Enter your last name"    style="padding: 8px;">
					<span></span>
                        </div>

			
			</div>
            <?php } ?>



    <?php if($allow_input_field['email'] == "on" ){ $num = array_search("email", $position_array); $current_values[$num] = 'group_4'; //array_push($current_values, 'group_4'); ?>
	<div class="col-md-4 listing-item" id="group_4" style="display:none;" data-listing-price="<?php echo array_search("email", $position_array);?>">
	<div class="col-md-12">
	<h2 class="inputheading"><i class="fa fa-envelope"></i> What is your email address ?</h2>
	</div>
    <div class="col-md-12 no-padding">
        <input id="savers_email" name="savers_email" class="form-control question" type="text" required placeholder="Enter your email">
		<span></span>
    </div>


</div>
    <?php  } ?>

		
     <?php
        if($allow_input_field['Smoke12'] == "on" ){ $num = array_search("Smoke12", $position_array); $current_values[$num] = 'group_5'; //array_push($current_values, 'group_5'); ?>
		<div class="col-md-4 listing-item" id="group_5" style="display:none;" data-listing-price="<?php echo array_search("Smoke12", $position_array);?>">
				<div class="col-md-12 control-label no-padding">
			<h2 class="inputheading"><i class="fa fa-fire"></i> Do you Smoke in last 12 months ?</h2>
			</div>
                       <div style="clear:both;"></div>
					   <div class="col-md-12 text-center">
						 <label class="radio-container" style="margin-right: 10px !important; display:  inline-block !important;text-align: center;"> Yes
						  <input type="radio" name="Smoke12" id="Smoke12-4" value="Yes" required="required">
						  <span class="checkmark"></span>
						</label>
						<label class="radio-container" style="margin-right: 10px;display:  inline-block !important;text-align: center;"> No
						  <input type="radio" name="Smoke12" id="Smoke12-4" value="No" required="required" checked="checked">
						  <span class="checkmark"></span>
						</label>
					</div>


</div>
        <?php } ?>		


<?php    if($allow_input_field['Country'] == "on" ){ $num = array_search("Country", $position_array); $current_values[$num] = 'group_6'; //array_push($current_values, 'group_6'); ?>
<div class="col-md-4 listing-item" id="group_6" style="display:none;" data-listing-price="<?php echo array_search("Country", $position_array);?>"> 
<div class="col-md-12 control-label no-padding">
			<h2 class="inputheading"><i class="fa fa-map-marker"></i> Destination Country</h2>
			</div>
<?php
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
            <div class="col-md-12">
                <select name="primary_destination" onchange="CountryState(this)" class="form-control form-select" id="primary_destination" aria-required="true" >
                    <option value='United States' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag us" data-title="United States">United States</option>
                    <option value='Canada' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ca" data-title="Canada" selected="selected">Canada</option>
                    <option value="">---------</option>-->
                    <option value='Andorra' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ad" data-title="Andorra">Andorra</option>
                    <option value='United Arab Emirates' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ae" data-title="United Arab Emirates">United Arab Emirates</option>
                    <option value='Afghanistan' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag af" data-title="Afghanistan">Afghanistan</option>
                    <option value='Antigua and Barbuda' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ag" data-title="Antigua and Barbuda">Antigua and Barbuda</option>
                    <option value='Anguilla' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ai" data-title="Anguilla">Anguilla</option>
                    <option value='Albania' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag al" data-title="Albania">Albania</option>
                    <option value='Armenia' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag am" data-title="Armenia">Armenia</option>
                    <option value='Netherlands Antilles' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag an" data-title="Netherlands Antilles">Netherlands Antilles</option>
                    <option value='Angola' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ao" data-title="Angola">Angola</option>
                    <option value='Antarctica' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag aq" data-title="Antarctica">Antarctica</option>
                    <option value='Argentina' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ar" data-title="Argentina">Argentina</option>
                    <option value='American Samoa' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag as" data-title="American Samoa">American Samoa</option>
                    <option value='Austria' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag at" data-title="Austria">Austria</option>
                    <option value='Australia' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag au" data-title="Australia">Australia</option>
                    <option value='Aruba' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag aw" data-title="Aruba">Aruba</option>
                    <option value='Aland Islands' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ax" data-title="Aland Islands">Aland Islands</option>
                    <option value='Azerbaijan' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag az" data-title="Azerbaijan">Azerbaijan</option>
                    <option value='Bosnia and Herzegovina' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ba" data-title="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                    <option value='Barbados' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag bb" data-title="Barbados">Barbados</option>
                    <option value='Bangladesh' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag bd" data-title="Bangladesh">Bangladesh</option>
                    <option value='Belgium' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag be" data-title="Belgium">Belgium</option>
                    <option value='Burkina Faso' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag bf" data-title="Burkina Faso">Burkina Faso</option>
                    <option value='Bulgaria' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag bg" data-title="Bulgaria">Bulgaria</option>
                    <option value='Bahrain' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag bh" data-title="Bahrain">Bahrain</option>
                    <option value='Burundi' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag bi" data-title="Burundi">Burundi</option>
                    <option value='Benin' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag bj" data-title="Benin">Benin</option>
                    <option value='Bermuda' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag bm" data-title="Bermuda">Bermuda</option>
                    <option value='Brunei Darussalam' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag bn" data-title="Brunei Darussalam">Brunei Darussalam</option>
                    <option value='Bolivia' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag bo" data-title="Bolivia">Bolivia</option>
                    <option value='Brazil' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag br" data-title="Brazil">Brazil</option>
                    <option value='Bahamas' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag bs" data-title="Bahamas">Bahamas</option>
                    <option value='Bhutan' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag bt" data-title="Bhutan">Bhutan</option>
                    <option value='Bouvet Island' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag bv" data-title="Bouvet Island">Bouvet Island</option>
                    <option value='Botswana' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag bw" data-title="Botswana">Botswana</option>
                    <option value='Belarus' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag by" data-title="Belarus">Belarus</option>
                    <option value='Belize' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag bz" data-title="Belize">Belize</option>
                    <option value='Cocos (Keeling) Islands' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag cc" data-title="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                    <option value='Democratic Republic of the Congo' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag cd" data-title="Democratic Republic of the Congo">Democratic Republic of the Congo</option>
                    <option value='Central African Republic' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag cf" data-title="Central African Republic">Central African Republic</option>
                    <option value='Congo' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag cg" data-title="Congo">Congo</option>
                    <option value='Switzerland' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ch" data-title="Switzerland">Switzerland</option>
                    <option value='Cote D Ivoire (Ivory Coast)' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ci" data-title="Cote D'Ivoire (Ivory Coast)">Cote D'Ivoire (Ivory Coast)</option>
                    <option value='Cook Islands' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ck" data-title="Cook Islands">Cook Islands</option>
                    <option value='Chile' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag cl" data-title="Chile">Chile</option>
                    <option value='Cameroon' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag cm" data-title="Cameroon">Cameroon</option>
                    <option value='China' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag cn" data-title="China">China</option>
                    <option value='Colombia' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag co" data-title="Colombia">Colombia</option>
                    <option value='Costa Rica' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag cr" data-title="Costa Rica">Costa Rica</option>
                    <option value='Serbia and Montenegro' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag cs" data-title="Serbia and Montenegro">Serbia and Montenegro</option>
                    <option value='Cuba' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag cu" data-title="Cuba">Cuba</option>
                    <option value='Cape Verde' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag cv" data-title="Cape Verde">Cape Verde</option>
                    <option value='Christmas Island' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag cx" data-title="Christmas Island">Christmas Island</option>
                    <option value='Cyprus' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag cy" data-title="Cyprus">Cyprus</option>
                    <option value='Czech Republic' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag cz" data-title="Czech Republic">Czech Republic</option>
                    <option value='Germany' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag de" data-title="Germany">Germany</option>
                    <option value='Djibouti' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag dj" data-title="Djibouti">Djibouti</option>
                    <option value='Denmark' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag dk" data-title="Denmark">Denmark</option>
                    <option value='Dominica' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag dm" data-title="Dominica">Dominica</option>
                    <option value='Dominican Republic' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag do" data-title="Dominican Republic">Dominican Republic</option>
                    <option value='Algeria' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag dz" data-title="Algeria">Algeria</option>
                    <option value='Ecuador' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ec" data-title="Ecuador">Ecuador</option>
                    <option value='Estonia' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ee" data-title="Estonia">Estonia</option>
                    <option value='Egypt' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag eg" data-title="Egypt">Egypt</option>
                    <option value='Western Sahara' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag eh" data-title="Western Sahara">Western Sahara</option>
                    <option value='Eritrea' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag er" data-title="Eritrea">Eritrea</option>
                    <option value='Spain' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag es" data-title="Spain">Spain</option>
                    <option value='Ethiopia' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag et" data-title="Ethiopia">Ethiopia</option>
                    <option value='Finland' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag fi" data-title="Finland">Finland</option>
                    <option value='Fiji' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag fj" data-title="Fiji">Fiji</option>
                    <option value='Falkland Islands (Malvinas)' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag fk" data-title="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                    <option value='ederated States of Micronesia' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag fm" data-title="Federated States of Micronesia">Federated States of Micronesia</option>
                    <option value='Faroe Islands' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag fo" data-title="Faroe Islands">Faroe Islands</option>
                    <option value='France' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag fr" data-title="France">France</option>
                    <option value='France, Metropolitan' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag fx" data-title="France, Metropolitan">France, Metropolitan</option>
                    <option value='Gabon' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ga" data-title="Gabon">Gabon</option>
                    <option value='Great Britain (UK)' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag gb" data-title="Great Britain (UK)">Great Britain (UK)</option>
                    <option value='Grenada' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag gd" data-title="Grenada">Grenada</option>
                    <option value='Georgia' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ge" data-title="Georgia">Georgia</option>
                    <option value='French Guiana' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag gf" data-title="French Guiana">French Guiana</option>
                    <option value='Ghana' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag gh" data-title="Ghana">Ghana</option>
                    <option value='Gibraltar' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag gi" data-title="Gibraltar">Gibraltar</option>
                    <option value='Greenland' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag gl" data-title="Greenland">Greenland</option>
                    <option value='Gambia' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag gm" data-title="Gambia">Gambia</option>
                    <option value='Guinea' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag gn" data-title="Guinea">Guinea</option>
                    <option value='Guadeloupe' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag gp" data-title="Guadeloupe">Guadeloupe</option>
                    <option value='Equatorial Guinea' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag gq" data-title="Equatorial Guinea">Equatorial Guinea</option>
                    <option value='Greece' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag gr" data-title="Greece">Greece</option>
                    <option value='S. Georgia and S. Sandwich Islands' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag gs" data-title="S. Georgia and S. Sandwich Islands">S. Georgia and S. Sandwich Islands</option>
                    <option value='Guatemala' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag gt" data-title="Guatemala">Guatemala</option>
                    <option value='Guam' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag gu" data-title="Guam">Guam</option>
                    <option value='Guinea-Bissau' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag gw" data-title="Guinea-Bissau">Guinea-Bissau</option>
                    <option value='Guyana' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag gy" data-title="Guyana">Guyana</option>
                    <option value='Hong Kong' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag hk" data-title="Hong Kong">Hong Kong</option>
                    <option value='Heard Island and McDonald Islands' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag hm" data-title="Heard Island and McDonald Islands">Heard Island and McDonald Islands</option>
                    <option value='Honduras' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag hn" data-title="Honduras">Honduras</option>
                    <option value='Croatia (Hrvatska)' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag hr" data-title="Croatia (Hrvatska)">Croatia (Hrvatska)</option>
                    <option value='Haiti' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ht" data-title="Haiti">Haiti</option>
                    <option value='Hungary' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag hu" data-title="Hungary">Hungary</option>
                    <option value='Indonesia' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag id" data-title="Indonesia">Indonesia</option>
                    <option value='Ireland' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ie" data-title="Ireland">Ireland</option>
                    <option value='Israel' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag il" data-title="Israel">Israel</option>
                    <option value='India' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag in" data-title="India">India</option>
                    <option value='British Indian Ocean Territory' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag io" data-title="British Indian Ocean Territory">British Indian Ocean Territory</option>
                    <option value='Iraq' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag iq" data-title="Iraq">Iraq</option>
                    <option value='Iran' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ir" data-title="Iran">Iran</option>
                    <option value='Iceland' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag is" data-title="Iceland">Iceland</option>
                    <option value='Italy' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag it" data-title="Italy">Italy</option>
                    <option value='Jamaica' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag jm" data-title="Jamaica">Jamaica</option>
                    <option value='Jordan' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag jo" data-title="Jordan">Jordan</option>
                    <option value='Japan' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag jp" data-title="Japan">Japan</option>
                    <option value='Kenya' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ke" data-title="Kenya">Kenya</option>
                    <option value='Kyrgyzstan' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag kg" data-title="Kyrgyzstan">Kyrgyzstan</option>
                    <option value='Cambodia' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag kh" data-title="Cambodia">Cambodia</option>
                    <option value='Kiribati' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ki" data-title="Kiribati">Kiribati</option>
                    <option value='Comoros' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag km" data-title="Comoros">Comoros</option>
                    <option value='Saint Kitts and Nevis' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag kn" data-title="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                    <option value='Korea (North)' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag kp" data-title="Korea (North)">Korea (North)</option>
                    <option value='Korea (South)' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag kr" data-title="Korea (South)">Korea (South)</option>
                    <option value='Kuwait' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag kw" data-title="Kuwait">Kuwait</option>
                    <option value='Cayman Islands' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ky" data-title="Cayman Islands">Cayman Islands</option>
                    <option value='Kazakhstan' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag kz" data-title="Kazakhstan">Kazakhstan</option>
                    <option value='Laos' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag la" data-title="Laos">Laos</option>
                    <option value='Lebanon' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag lb" data-title="Lebanon">Lebanon</option>
                    <option value='Saint Lucia' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag lc" data-title="Saint Lucia">Saint Lucia</option>
                    <option value='Liechtenstein' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag li" data-title="Liechtenstein">Liechtenstein</option>
                    <option value='Sri Lanka' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag lk" data-title="Sri Lanka">Sri Lanka</option>
                    <option value='Liberia' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag lr" data-title="Liberia">Liberia</option>
                    <option value='Lesotho' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ls" data-title="Lesotho">Lesotho</option>
                    <option value='Lithuania' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag lt" data-title="Lithuania">Lithuania</option>
                    <option value='Luxembourg' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag lu" data-title="Luxembourg">Luxembourg</option>
                    <option value='Latvia' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag lv" data-title="Latvia">Latvia</option>
                    <option value='Libya' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ly" data-title="Libya">Libya</option>
                    <option value='Morocco' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ma" data-title="Morocco">Morocco</option>
                    <option value='Monaco' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag mc" data-title="Monaco">Monaco</option>
                    <option value='Moldova' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag md" data-title="Moldova">Moldova</option>
                    <option value='Madagascar' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag mg" data-title="Madagascar">Madagascar</option>
                    <option value='Marshall Islands' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag mh" data-title="Marshall Islands">Marshall Islands</option>
                    <option value='Macedonia' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag mk" data-title="Macedonia">Macedonia</option>
                    <option value='Mali' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ml" data-title="Mali">Mali</option>
                    <option value='Myanmar' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag mm" data-title="Myanmar">Myanmar</option>
                    <option value='Mongolia' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag mn" data-title="Mongolia">Mongolia</option>
                    <option value='Macao' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag mo" data-title="Macao">Macao</option>
                    <option value='Northern Mariana Islands' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag mp" data-title="Northern Mariana Islands">Northern Mariana Islands</option>
                    <option value='Martinique' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag mq" data-title="Martinique">Martinique</option>
                    <option value='Mauritania' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag mr" data-title="Mauritania">Mauritania</option>
                    <option value='Montserrat' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ms" data-title="Montserrat">Montserrat</option>
                    <option value='Malta' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag mt" data-title="Malta">Malta</option>
                    <option value='Mauritius' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag mu" data-title="Mauritius">Mauritius</option>
                    <option value='Maldives' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag mv" data-title="Maldives">Maldives</option>
                    <option value='Malawi' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag mw" data-title="Malawi">Malawi</option>
                    <option value='Mexico' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag mx" data-title="Mexico">Mexico</option>
                    <option value='Malaysia' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag my" data-title="Malaysia">Malaysia</option>
                    <option value='Mozambique' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag mz" data-title="Mozambique">Mozambique</option>
                    <option value='Namibia' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag na" data-title="Namibia">Namibia</option>
                    <option value='New Caledonia' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag nc" data-title="New Caledonia">New Caledonia</option>
                    <option value='Niger' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ne" data-title="Niger">Niger</option>
                    <option value='Norfolk Island' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag nf" data-title="Norfolk Island">Norfolk Island</option>
                    <option value='Nigeria' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ng" data-title="Nigeria">Nigeria</option>
                    <option value='Nicaragua' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ni" data-title="Nicaragua">Nicaragua</option>
                    <option value='Netherlands' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag nl" data-title="Netherlands">Netherlands</option>
                    <option value='Norway' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag no" data-title="Norway">Norway</option>
                    <option value='Nepal' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag np" data-title="Nepal">Nepal</option>
                    <option value='Nauru' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag nr" data-title="Nauru">Nauru</option>
                    <option value='Niue' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag nu" data-title="Niue">Niue</option>
                    <option value='New Zealand (Aotearoa)' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag nz" data-title="New Zealand (Aotearoa)">New Zealand (Aotearoa)</option>
                    <option value='Oman' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag om" data-title="Oman">Oman</option>
                    <option value='Panama' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag pa" data-title="Panama">Panama</option>
                    <option value='Peru' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag pe" data-title="Peru">Peru</option>
                    <option value='French Polynesia' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag pf" data-title="French Polynesia">French Polynesia</option>
                    <option value='Papua New Guinea' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag pg" data-title="Papua New Guinea">Papua New Guinea</option>
                    <option value='Philippines' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ph" data-title="Philippines">Philippines</option>
                    <option value='Pakistan' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag pk" data-title="Pakistan">Pakistan</option>
                    <option value='Poland' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag pl" data-title="Poland">Poland</option>
                    <option value='Saint Pierre and Miquelon' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag pm" data-title="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                    <option value='Pitcairn' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag pn" data-title="Pitcairn">Pitcairn</option>
                    <option value='Puerto Rico' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag pr" data-title="Puerto Rico">Puerto Rico</option>
                    <option value='Palestinian Territory' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ps" data-title="Palestinian Territory">Palestinian Territory</option>
                    <option value='Portugal' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag pt" data-title="Portugal">Portugal</option>
                    <option value='Palau' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag pw" data-title="Palau">Palau</option>
                    <option value='Paraguay' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag py" data-title="Paraguay">Paraguay</option>
                    <option value='Qatar' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag qa" data-title="Qatar">Qatar</option>
                    <option value='Reunion' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag re" data-title="Reunion">Reunion</option>
                    <option value='Romania' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ro" data-title="Romania">Romania</option>
                    <option value='Russian Federation' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ru" data-title="Russian Federation">Russian Federation</option>
                    <option value='Rwanda' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag rw" data-title="Rwanda">Rwanda</option>
                    <option value='Saudi Arabia' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag sa" data-title="Saudi Arabia">Saudi Arabia</option>
                    <option value='Solomon Islands' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag sb" data-title="Solomon Islands">Solomon Islands</option>
                    <option value='Seychelles' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag sc" data-title="Seychelles">Seychelles</option>
                    <option value='Sudan' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag sd" data-title="Sudan">Sudan</option>
                    <option value='Sweden' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag se" data-title="Sweden">Sweden</option>
                    <option value='Singapore' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag sg" data-title="Singapore">Singapore</option>
                    <option value='Saint Helena' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag sh" data-title="Saint Helena">Saint Helena</option>
                    <option value='Slovenia' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag si" data-title="Slovenia">Slovenia</option>
                    <option value='Svalbard and Jan Mayen' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag sj" data-title="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                    <option value='Slovakia' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag sk" data-title="Slovakia">Slovakia</option>
                    <option value='Sierra Leone' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag sl" data-title="Sierra Leone">Sierra Leone</option>
                    <option value='San Marino' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag sm" data-title="San Marino">San Marino</option>
                    <option value='Senegal' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag sn" data-title="Senegal">Senegal</option>
                    <option value='Somalia' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag so" data-title="Somalia">Somalia</option>
                    <option value='Suriname' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag sr" data-title="Suriname">Suriname</option>
                    <option value='Sao Tome and Principe' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag st" data-title="Sao Tome and Principe">Sao Tome and Principe</option>
                    <option value='USSR (former)' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag su" data-title="USSR (former)">USSR (former)</option>
                    <option value='El Salvador' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag sv" data-title="El Salvador">El Salvador</option>
                    <option value='Syria' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag sy" data-title="Syria">Syria</option>
                    <option value='Swaziland' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag sz" data-title="Swaziland">Swaziland</option>
                    <option value='Turks and Caicos Islands' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag tc" data-title="Turks and Caicos Islands">Turks and Caicos Islands</option>
                    <option value='Chad' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag td" data-title="Chad">Chad</option>
                    <option value='French Southern Territories' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag tf" data-title="French Southern Territories">French Southern Territories</option>
                    <option value='Togo' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag tg" data-title="Togo">Togo</option>
                    <option value='Thailand' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag th" data-title="Thailand">Thailand</option>
                    <option value='Tajikistan' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag tj" data-title="Tajikistan">Tajikistan</option>
                    <option value='Tokelau' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag tk" data-title="Tokelau">Tokelau</option>
                    <option value='Timor-Leste' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag tl" data-title="Timor-Leste">Timor-Leste</option>
                    <option value='Turkmenistan' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag tm" data-title="Turkmenistan">Turkmenistan</option>
                    <option value='Tunisia' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag tn" data-title="Tunisia">Tunisia</option>
                    <option value='Tonga' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag to" data-title="Tonga">Tonga</option>
                    <option value='East Timor' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag tp" data-title="East Timor">East Timor</option>
                    <option value='Turkey' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag tr" data-title="Turkey">Turkey</option>
                    <option value='Trinidad and Tobago' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag tt" data-title="Trinidad and Tobago">Trinidad and Tobago</option>
                    <option value='Tuvalu' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag tv" data-title="Tuvalu">Tuvalu</option>
                    <option value='Taiwan' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag tw" data-title="Taiwan">Taiwan</option>
                    <option value='Tanzania' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag tz" data-title="Tanzania">Tanzania</option>
                    <option value='Ukraine' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ua" data-title="Ukraine">Ukraine</option>
                    <option value='Uganda' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ug" data-title="Uganda">Uganda</option>
                    <option value='United Kingdom' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag uk" data-title="United Kingdom">United Kingdom</option>
                    <option value='United States Minor Outlying Islands' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag um" data-title="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                    <option value='Uruguay' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag uy" data-title="Uruguay">Uruguay</option>
                    <option value='Uzbekistan' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag uz" data-title="Uzbekistan">Uzbekistan</option>
                    <option value='Vatican City State (Holy See)' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag va" data-title="Vatican City State (Holy See)">Vatican City State (Holy See)</option>
                    <option value='Saint Vincent and the Grenadines' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag vc" data-title="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                    <option value='Venezuela' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ve" data-title="Venezuela">Venezuela</option>
                    <option value='Virgin Islands (British)' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag vg" data-title="Virgin Islands (British)">Virgin Islands (British)</option>
                    <option value='Virgin Islands (U.S.)' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag vi" data-title="Virgin Islands (U.S.)">Virgin Islands (U.S.)</option>
                    <option value='Viet Nam' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag vn" data-title="Viet Nam">Viet Nam</option>
                    <option value='Vanuatu' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag vu" data-title="Vanuatu">Vanuatu</option>
                    <option value='Wallis and Futuna' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag wf" data-title="Wallis and Futuna">Wallis and Futuna</option>
                    <option value='Samoa' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ws" data-title="Samoa">Samoa</option>
                    <option value='Yemen' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag ye" data-title="Yemen">Yemen</option>
                    <option value='Mayotte' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag yt" data-title="Mayotte">Mayotte</option>
                    <option value='Yugoslavia (former)' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag yu" data-title="Yugoslavia (former)">Yugoslavia (former)</option>
                    <option value='South Africa' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag za" data-title="South Africa">South Africa</option>
                    <option value='Zambia' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag zm" data-title="Zambia">Zambia</option>
                    <option value='Zaire (former)' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag zr" data-title="Zaire (former)">Zaire (former)</option>
                    <option value='Zimbabwe' data-image="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/msdropdown/icons/blank.gif'; ?>" data-imagecss="flag zw" data-title="Zimbabwe">Zimbabwe</option>
                </select>
            </div>
            <div id="primary_destination_State_div">
                <div class="col-md-12 control-input des-primary" style="text-align: left; float:left;">
                    <select name="primary_destination_State" class="form-control form-select" id="primary_destination_State" autocomplete="off">
                        <option value="">Please choose</option>
                        <option value="Alberta">Alberta</option>
                        <option value="British Columbia">British Columbia</option>
                        <option value="Manitoba">Manitoba</option>
                        <option value="New Brunswick">New Brunswick</option>
                        <option value="Newfoundland">Newfoundland</option>
                        <option value="North West Territories">North West Territories</option>
                        <option value="Nova Scotia">Nova Scotia</option>
                        <option value="Nunavut">Nunavut</option>
                        <option value="Ontario">Ontario</option>
                        <option value="Prince Edward Island">Prince Edward Island</option>
                        <option value="Quebec">Quebec</option>
                        <option value="Saskatchewan">Saskatchewan</option>
                        <option value="Yukon Territory">Yukon Territory</option>
                    </select>
                </div>
            </div>

            
                   <?php  if(isset($allow_input_field['us_stop']) && $allow_input_field['us_stop'] == "on" ): ?>          
            <div id="usa_stop_div" style="display:none;">
                <div class="col-md-12 control-label no-padding" style="margin:0; padding:0;">
                    <label class="input-label"> Any stop-over in the US? </label>
				</div>
                <div class="col-md-12 control-input" style="text-align: left; float:left;">
                    <select name="usa_stop" id="usa_stop" aria-invalid="false" class="form-control">
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
          <?php endif; ?>



          <?php } else {  ?>

        <div class="col-md-12 no-padding">
        <select name="primary_destination" class="form-control" id="primary_destination" autocomplete="off">
            <option value="">Please choose</option>
            <option value="Alberta" selected="">Alberta</option>
            <option value="British Columbia">British Columbia</option>
            <option value="Manitoba">Manitoba</option>
            <option value="New Brunswick">New Brunswick</option>
            <option value="Newfoundland">Newfoundland</option>
            <option value="North West Territories">North West Territories</option>
            <option value="Nova Scotia">Nova Scotia</option>
            <option value="Nunavut">Nunavut</option>
            <option value="Ontario">Ontario</option>
            <option value="Prince Edward Island">Prince Edward Island</option>
            <option value="Quebec">Quebec</option>
            <option value="Saskatchewan">Saskatchewan</option>
            <option value="Yukon Territory">Yukon Territory</option>
        </select>
     </div>

<?php } ?>


</div>
<?php } ?>

			
            <?php
            if($allow_input_field['phone'] == "on" ){ $num = array_search("phone", $position_array); $current_values[$num] = 'group_7'; //array_push($current_values, 'group_7'); ?>
                <div class="col-md-4 listing-item" id="group_7" style="display:none;" data-listing-price="<?php echo array_search("phone", $position_array);?>">
                <div class="col-md-12 no-padding control-label">
				<h2 class="inputheading"><i class="fa fa-phone"></i> What is your Contact Number? <small id="phone_error" class="text-danger"></small></h2>
				</div>
                <div class="col-md-12 phone-custom-input">
				
					<input id="phone" name="phone" class="form-control question text-center" type="text" minlength="10" maxlength="11" required placeholder="Enter your phone number" onkeyup="validatephone()">
					<span></span>
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
            <?php } ?>			

	



<?php if($allow_input_field['smoked'] == "on" ){ $num = array_search("smoked", $position_array); $current_values[$num] = 'group_9'; //array_push($current_values, 'group_9'); ?>
<div class="col-md-4 listing-item" id="group_9" style="display:none;" data-listing-price="<?php echo array_search("smoked", $position_array);?>">
<div class="col-md-12 control-label ">
	<h2 class="inputheading"><i class="fa fa-fire"></i> Are You Smoker ?</h2>
</div>
<div class="col-md-12 no-padding">
<select name="traveller_Smoke" class="form-control form-select" id="traveller_Smoke" autocomplete="off">
<option value="">Please choose</option>
<option value="yes">Yes</option>
<option value="no" selected>No</option>
</select>
</div>


</div>
<?php } ?>

<?php if($allow_input_field['traveller_gender'] == "on" ){ $num = array_search("traveller_gender", $position_array); $current_values[$num] = 'group_10'; //array_push($current_values, 'group_10'); ?>
   <div class="col-md-4 listing-item" id="group_10" style="display:none;" data-listing-price="<?php echo array_search("traveller_gender", $position_array);?>">
   <div class="col-md-12 control-label ">
	<h2 class="inputheading"><i class="fa fa-male"></i> Traveller's Gender</h2>
</div>
        <div class="col-md-12 no-padding control-input custom_traveller">
                            <select name="old_traveller_gender" id="gender" class="form-control">
                                <option value="">Please Choose</option>
                                <option value="male" selected>Male</option>
                                <option value="female">Female</option>
                            </select>
                       
                </div>


</div>
    <?php } ?>

           <?php if($allow_input_field['gender'] == "on" ){ $num = array_search("gender", $position_array); $current_values[$num] = 'group_11'; //array_push($current_values, 'group_11'); ?>
		   <div class="col-md-4 listing-item" id="group_11" style="display:none;" data-listing-price="<?php echo array_search("gender", $position_array);?>">
         <div class="col-md-12 no-padding control-label " >
             <h2 class="inputheading"><i class="fa fa-male"></i> Primary Applicant's Gender ?</h2>
		<div style="clear:both;"></div>
					   <div class="col-md-12 text-center">
						 <label class="radio-container" style="margin-right: 10px !important; display:  inline-block !important;text-align: center;"> <i class="fa fa-male"></i> Male
						  <input type="radio" name="gender"  value="Male" required="required">
						  <span class="checkmark"></span>
						</label>
						<label class="radio-container" style="margin-right: 10px;display:  inline-block !important;text-align: center;"> <i class="fa fa-female"></i> Female
						  <input type="radio" name="gender" value="Female" required="required" checked="checked">
						  <span class="checkmark"></span>
						</label>
					</div>
		</div>

		   
</div>
           <?php } ?>

    <?php
    if($allow_input_field['fplan'] == "on" ){ $num = array_search("fplan", $position_array); $current_values[$num] = 'group_12'; //array_push($current_values, 'group_12'); ?>
 <div class="col-md-4 listing-item" id="group_12" style="display:none;" data-listing-price="<?php echo array_search("fplan", $position_array);?>">	
        <div class="col-md-12 control-label ">
            <h2 class="inputheading"><i class="fa fa-child"></i> Do you require Family Plan?  </h2>
					<div style="clear:both;"></div>
					   <div class="col-md-12 text-center">
						 <label class="radio-container" style="margin-right: 10px !important; display:  inline-block !important;text-align: center;"> Yes, I Want
						  <input type="radio" name="familyplan"  value="yes" required="required" onclick="changefamily()">
						  <span class="checkmark"></span>
						</label>
						<label class="radio-container" style="margin-right: 10px;display:  inline-block !important;text-align: center;"> No, I Don't Want
						  <input type="radio" name="familyplan" value="no" required="required" checked="checked" onclick="changefamily()">
						  <span class="checkmark"></span>
						</label>
					</div>
			<input type="hidden" id="familyplan_temp" name="familyplan_temp" value="no">		
		</div>

<script>
function changefamily(){
	if(document.getElementById('familyplan_temp').value == 'no'){
		document.getElementById('familyplan_temp').value = 'yes';
	} else {
		document.getElementById('familyplan_temp').value = 'no';
	}
checkfamilyplan();	
}
</script>	
</div>	
    <?php } ?>


            <?php
            if($allow_input_field['pre_existing'] == "on" ){ $num = array_search("pre_existing", $position_array); $current_values[$num] = 'group_13'; //array_push($current_values, 'group_13'); ?>
<div class="col-md-4 listing-item" id="group_13" style="display:none;" data-listing-price="<?php echo array_search("pre_existing", $position_array);?>">
                    <div class="col-md-12 control-label ">
                        <h2 class="inputheading"><i class="fa fa-wheelchair"></i> Any Pre-existing Condition?</h2>
					</div>
					<div style="clear:both;"></div>
					   <div class="col-md-12 text-center">
						 <label class="radio-container" style="margin-right: 10px !important; display:  inline-block !important;text-align: center;"> Yes, I Have
						  <input type="radio" id="checkbox-5" name="pre_existing"  value="yes" required="required" onclick="changefamily()">
						  <span class="checkmark"></span>
						</label>
						<label class="radio-container" style="margin-right: 10px;display:  inline-block !important;text-align: center;"> No, I Haven't
						  <input type="radio" id="checkbox-5" name="pre_existing" value="no" required="required" checked="checked" onclick="changefamily()">
						  <span class="checkmark"></span>
						</label>
					</div>
			
</div>
            <?php } ?>



</div>

<div class="clear:both;"></div>
<div class="container" style="margin-top: 50px;margin-bottom: 50px;">
<div class="col-md-6">
<button class="btn btn-default" style="padding: 10px 40px; font-weight: bold; font-size: 18px; margin: 0px; display: block;background: #F9F9F9 !important;color: #333 !important;" id="backbtn" type="button" onclick="checkback()"><i class="fa fa-arrow-circle-left"></i> Back</button>
</div>
<div class="col-md-6">
<button class="btn next-btn pull-right" style="padding: 10px 40px; font-weight: bold; font-size: 18px; display: block;margin: 0 auto;" type="button" id="nextbtn" onclick="checknext()"> Next <i class="fa fa-arrow-circle-right"></i></button>
<button class="btn next-btn pull-right" type="submit" style="padding: 10px 40px; font-weight: bold; font-size: 18px; background: rgb(33, 155, 0) none repeat scroll 0% 0%; display: block;margin: 0 auto; display:none;" id="getaquotebtn"> Get a Quote <i class="fa fa-shopping-cart"></i></button>
</div>
</div>
<input type="hidden" value="" id="nextitem">

<input type="hidden" name="broker" value="<?php echo $_REQUEST['broker']; ?>">     
<input type="hidden" name="agent" value="<?php echo $_REQUEST['agent']; ?>">

</form>

<script>
$('html').click(function() {
    $('.ageandcitizen').fadeOut(300);
 })

 $('.agesdiv').click(function(e){
     e.stopPropagation();
 });
</script>
<!--<script>
jQuery(function($) {
var divList = $(".listing-item");
divList.sort(function(a, b){ return $(a).data("listing-price")-$(b).data("listing-price")});

$("#listprices").html(divList);
})
</script>-->

<script>
<?php ksort($current_values);?>
function checknext(){
var javascript_array = new Array();
<?php
foreach ($current_values as $key => $value){
if($key != ''){
echo "javascript_array[".$key."] = '".$value."';";
}
}
?>
var filtered = javascript_array.filter(function (el) {
  return el != null;
});
javascript_array = filtered;

if(document.getElementById('nextitem').value == ''){
	document.getElementById('nextitem').value = '0';
} else {
document.getElementById('nextitem').value = +document.getElementById('nextitem').value + +1;
}
var nextitem = Number(document.getElementById('nextitem').value);

var longArray = javascript_array;
var size = 3;
var newArray = new Array(Math.ceil(longArray.length / size)).fill("")
    .map(function() { return this.splice(0, size) }, longArray.slice());

var sliced_array = newArray[nextitem];
var lastarray = newArray.length - 1;
if(nextitem == lastarray){
document.getElementById('nextbtn').style.display = 'none';
document.getElementById('getaquotebtn').style.display = 'block';	
} else {
document.getElementById('getaquotebtn').style.display = 'none';	
document.getElementById('nextbtn').style.display = 'block';
}

//Hiding all first
for (i = 0; i < javascript_array.length; i++) {
var group = javascript_array[i];
document.getElementById(group).style.display = 'none';
//$('#'+group).fadeOut("slow");
} 
//Showing relevent results
for (i = 0; i < sliced_array.length; i++) {
var group = sliced_array[i];
document.getElementById(group).style.display = 'block';
//$('#'+group).fadeIn("slow");
}

if(nextitem >0){
document.getElementById('backbtn').style.display = 'block';	
} else {
document.getElementById('backbtn').style.display = 'none';	
}

}
function checkback(){
var javascript_array = new Array();
<?php
foreach ($current_values as $key => $value){
if($key != ''){
echo "javascript_array[".$key."] = '".$value."';";
}
}
?>
var filtered = javascript_array.filter(function (el) {
  return el != null;
});
javascript_array = filtered;

if(document.getElementById('nextitem').value == ''){
	document.getElementById('nextitem').value = '0';
} else {
document.getElementById('nextitem').value = document.getElementById('nextitem').value - 1;
}
var nextitem = Number(document.getElementById('nextitem').value);

var longArray = javascript_array;
var size = 3;
var newArray = new Array(Math.ceil(longArray.length / size)).fill("")
    .map(function() { return this.splice(0, size) }, longArray.slice());

var sliced_array = newArray[nextitem];
var lastarray = newArray.length - 1;
//Hiding all first
for (i = 0; i < javascript_array.length; i++) {
var group = javascript_array[i];
document.getElementById(group).style.display = 'none';
} 
//Showing relevent results
for (i = 0; i < sliced_array.length; i++) {
var group = sliced_array[i];
document.getElementById(group).style.display = 'block';
}
if(nextitem == lastarray){
document.getElementById('nextbtn').style.display = 'none';
document.getElementById('getaquotebtn').style.display = 'block';	
} else {
document.getElementById('getaquotebtn').style.display = 'none';	
document.getElementById('nextbtn').style.display = 'block';
}
if(nextitem >0){
document.getElementById('backbtn').style.display = 'block';	
} else {
document.getElementById('backbtn').style.display = 'none';	
}
}
</script>

      	<div class="col-md-12 col-sm-12 col-xs-12">
		<span id="family_error" style="display: none; font-size: 16px;font-weight: bold;text-align: right;padding: 20px;" class="text-danger"><i class="fa fa-warning"></i> </span>
		<!--<div class="center m-t-30px" style="text-align: center;">
			<button type="submit" name="GET QUOTES" id="getquote" class="btn bg-red show-loading-popup">GET QUOTES</button>
		  </div>-->
	    </div>

<script>
window.onload = function() {
document.getElementById('backbtn').style.display = 'none';
checknext();
}
</script>
<script>
<?php if($supervisa == 'yes'){?>
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
	var someFormattedDate = y + '/' + mm + '/' + dd;
	document.getElementById('return_date').value = someFormattedDate;
//}, 1000);
}
<?php } ?>

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
document.getElementById('nextbtn').style.display = 'block';
document.getElementById('family_error').innerHTML = '';
document.getElementById('family_error').style.display = 'none';
} else {
document.getElementById('getquote').style.display = 'none';
if(document.getElementById('number_travelers').value <'2'){
document.getElementById('family_error').innerHTML = '<i class="fa fa-warning"></i> Minimum 2 travellers required for family plan.';
} else if(max_age > 59){
document.getElementById('family_error').innerHTML = '<i class="fa fa-warning"></i> Maximum age for family plan should be 59';	
} else if(min_age > 21){
document.getElementById('family_error').innerHTML = '<i class="fa fa-warning"></i> For family plan the youngest traveller shouldn`t be elder than 21';	
}
document.getElementById('family_error').style.display = 'block';	
}


} /*else {
	document.getElementById('nextbtn').style.display = 'block';
	document.getElementById('family_error').style.display = 'none';	
}*/
	
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
      jQuery(document).ready(function() {
		  if(typeof(Storage) !== "undefined") {
		 var saveddata = localStorage.setItem("someKey", $("#daterange").val());
		 $("#daterange").val(saveddata);
		 applychanges();
		} else {
			document.getElementById('daterange').value = '';
		}
       //jQuery("#primary_destination").msDropdown();
       });
	   
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