<?php
include 'includes/db_connect.php';

$product_id = '20';
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
		<link href="css/style.css" rel="stylesheet" type="text/css" />
<style>
.nextbtn {
	background:#11d491;
}
.rangeslider__fill {
    background: #00c2a2 !important;
    position: absolute;
}	
.ui-slider-horizontal .ui-slider-range {
	background:#11d491 !important;
}
.ui-slider span {
border: 3px solid #11d491 !important;
cursor: pointer !important;
background: #3D4B5D !important;	
}
</style>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>	

<script>
<?php
$ded = mysqli_query($db, "SELECT `duration` FROM `wp_dh_life_plans_rates` WHERE `plan_id` IN (SELECT `id` FROM wp_dh_life_plans WHERE `product`='$product_id') GROUP BY `duration` ORDER BY CAST(`duration` AS DECIMAL)");
?> 
var Slider_Values = [<?php
				$d = 0;
				while($ded_f = mysqli_fetch_assoc($ded)){
				$d++;
				echo $dedivalue = $ded_f['duration'];
				if($d < mysqli_num_rows($ded)){
				echo ', ';
				}
				} ?>];
<?php 
$dedq = mysqli_query($db, "SELECT `duration` FROM `wp_dh_life_plans_rates` WHERE `plan_id` IN (SELECT `id` FROM wp_dh_life_plans WHERE `product`='$product_id') GROUP BY `duration` ORDER BY CAST(`duration` AS DECIMAL)");
$dedf = mysqli_fetch_assoc($dedq);
$stay_duration = $dedf['duration'];
if($_SESSION['duration']){
$stay_duration = $_SESSION['duration'];
}
?>	
var dValue = Slider_Values.indexOf(<?php echo $stay_duration;?>);
if(dValue == '-1'){ dValue = '0'; }
$(function () {
    $("#slider").slider({
		range: "min",
        min: 0,
        max: Slider_Values.length - 1,
        step: 1,
		value: dValue,		
        slide: function (event, ui) {
            $('#coverage_deductible').text(Slider_Values[ui.value]);
			//alert(Slider_Values.length);
for (i = 0; i < Slider_Values.length; i++) {
var group = Slider_Values[i];
$('.deductable-'+group).hide();
}
			$('.deductable-'+Slider_Values[ui.value]).show();
			$( "#coverage_deductible" ).val( Slider_Values[ui.value] + " year(s)" );
			$( "#duration" ).val( Slider_Values[ui.value]);

calculate();
			
        }
    });
});

//Sum Insured Slider
<?php
$sum = mysqli_query($db, "SELECT `sum_insured` FROM `wp_dh_life_plans_rates` WHERE `plan_id` IN (SELECT `id` FROM wp_dh_life_plans WHERE `product`='$product_id') GROUP BY `sum_insured` ORDER BY CAST(`sum_insured` AS DECIMAL)");
?> 
var SliderValues = [<?php
				$s = 0;
				while($sum_f = mysqli_fetch_assoc($sum)){
				$s++;	
				echo $sumamount = $sum_f['sum_insured'];
				if($s < mysqli_num_rows($sum)){
				echo ', ';
				}
				} ?>];
<?php
$sumq = mysqli_query($db, "SELECT `sum_insured` FROM `wp_dh_life_plans_rates` WHERE `plan_id` IN (SELECT `id` FROM wp_dh_life_plans WHERE `product`='$product_id') GROUP BY `sum_insured` ORDER BY CAST(`sum_insured` AS DECIMAL)");
$sumf = mysqli_fetch_assoc($sumq);
$stay_sum = $sumf['sum_insured'];
if($_SESSION['sum_insured2']){
$stay_sum = $_SESSION['sum_insured2'];
}
?>
var iValue = SliderValues.indexOf(<?php echo $stay_sum;?>);
$(function () {
    $("#sum_slider").slider({
		range: "min",
        min: 0,
        max: SliderValues.length - 1,
        step: 1,
		value: iValue,
        slide: function (event, ui) {
            $('#sum_insured').text(SliderValues[ui.value]);
			//alert(SliderValues.length);
for (i = 0; i < SliderValues.length; i++) {
var group = SliderValues[i];
$('.coverage-amt-'+group).hide();
}
			$('.coverage-amt-'+SliderValues[ui.value]).show();
			$( "#sum_insured" ).val( "$" + SliderValues[ui.value] );
			$( "#sum_insured2" ).val(SliderValues[ui.value]);

calculate();
			
        }
    });

});
  </script>

<style>
.fields {
box-shadow: 0 0 16px rgba(0,0,0,0.27) !important;
border-radius: 10px !important;
}	
</style>
	</head>
	
<body onload="calculate();">
<?php include 'lifehead.php'; ?>
<section class="tabscontent">
<div class="container">
<form action="life_sessions.php?action=coverage" method="post">
<div class="row">
<div class="col-md-12 hidden-xs text-center">
<h1 class="text-center">Choose your options.</h1>
<p class="sub-heading">How much insurance would you like and for how many years?</p>
</div>
</div>

<div class="row">
<div class="col-md-4">
<div class="col-md-12 fields" style="min-height: 170px;">
<h4 class="deductible" style="margin: 0;padding: 0;font-weight: bold;margin-bottom: 10px;border: none;text-align: left;color: #8e939c !important;font-size: 16px;">DURATION: <input type="text" id="coverage_deductible" name="coverage_deductible" value="<?php echo $stay_duration;?> year(s)" style="border:0; font-size:19px; color:#572900; font-weight:bold;background: no-repeat;margin: 0;padding: 0;text-align: center;width: 100px;"></h4>
<div id="slider" style="background:#ddd;"></div>
<input type="hidden" name="duration" id="duration" value="<?php echo $dedf['duration'];?>" />
</div>
</div>
<div class="col-md-4 ">
<div class="col-md-12 fields" style="min-height: 170px;">
 <h4 class="coverage" style="margin: 0;padding: 0;font-weight: bold;margin-bottom: 10px;border: none;text-align: left;color: #8e939c !important;font-size: 16px;">Coverage Amount: <input type="text" id="sum_insured" name="sum_insured" value="$<?php echo $stay_sum;?>" style="border:0; font-size:19px; color:#572900; font-weight:bold;background: no-repeat;margin: 0;padding: 0;text-align: center;width: 100px;"></h4>
<div id="sum_slider" style="background:#ddd;"></div>
<input type="hidden" name="sum_insured2" id="sum_insured2" value="<?php echo $stay_sum;?>" />
</div>

</div>

<div class="col-md-4  text-center">
<div class="col-md-12 fields" style="padding: 10px;">
<div class="col-md-6" id="complogo">
</div>
<div class="col-md-6">
<h1 style="color:#572900; margin:0;"><span style="font-size:30px; color:#572900;">$</span> <span id="amount" style="margin-left: -10px;color:#572900;"></span></h1>
<small id="monthly_yearly"></small>
</div>
<div class="row" style="margin-top:30px !important; clear:both;">
<div class="col-md-12 text-center"><button type="submit" style="padding:10px 20px !important;" class="btn btn-lg nextbtn">Compare Your Quotes <i class="fa fa-arrow-right"></i></button></div>
</div>
</div>
</div>

</div>
<div class="row" style="margin-top:30px !important;opacity: 0.7;">
<div class="col-md-12 text-center"><i class="fa fa-calculator" style="font-size: 30px;border: 1px solid #CCC;background: #FFF;padding: 11px;border-radius: 50px;color: #15B695;"></i> <strong>Need help? </strong><a href="life_calculator.php" target="_blank" style="color: #008C6B;font-size: 17px;">Try our calculator</a></div>
</div>
</form>
</div>
</section>

<?php include 'footer.php'; ?>

<script>
function calculate(){
var dur = document.getElementById('duration').value;
var sum = document.getElementById('sum_insured2').value;
<?php
$smoke = $_SESSION['smoke'];
$gender = $_SESSION['gender'];
$person_age = $_SESSION['years'];
$func_q = mysqli_query($db, "SELECT * FROM `wp_dh_life_plans_rates` WHERE `plan_id` IN (SELECT `id` FROM `wp_dh_life_plans` WHERE `product`='$product_id' AND `smoke`='$smoke') AND '$person_age' BETWEEN `minage` AND `maxage` AND `sex`='$gender' AND `ratebase`='1' ORDER BY CAST(`rate` AS DECIMAL)");
while($func_f = mysqli_fetch_assoc($func_q)){
$rate_base = $func_f['ratebase'];
if($rate_base == '1'){
$ratebase = 'Monthly Estimate';
$ratebase_func = 'monthly';
} else {
$ratebase = 'Yearly Estimate';
$ratebase_func = 'yearly';
}
?>
if(dur == '<?php echo $func_f['duration'];?>' && sum == '<?php echo $func_f['sum_insured'];?>'){
<?php echo $ratebase_func;?>_d<?php echo $func_f['duration'];?>_sum<?php echo $func_f['sum_insured'];?>();	
}
<?php } ?>
}
<?php
$smoke = $_SESSION['smoke'];
$gender = $_SESSION['gender'];
$person_age = $_SESSION['years'];
$func_q = mysqli_query($db, "SELECT * FROM `wp_dh_life_plans_rates` WHERE `plan_id` IN (SELECT `id` FROM `wp_dh_life_plans` WHERE `product`='$product_id' AND `smoke`='$smoke') AND '$person_age' BETWEEN `minage` AND `maxage` AND `sex`='$gender' AND `ratebase`='1' ORDER BY CAST(`rate` AS DECIMAL)");
while($func_f = mysqli_fetch_assoc($func_q)){
$comp_q = mysqli_query($db, "SELECT `comp_logo` FROM `wp_dh_companies` WHERE `comp_id` = (SELECT `insurance_company` FROM `wp_dh_life_plans` WHERE `id`='".$func_f['plan_id']."')");
$comp_f = mysqli_fetch_assoc($comp_q);
$rate_base = $func_f['ratebase'];
if($rate_base == '1'){
$ratebase = 'Monthly Estimate';
$ratebase_func = 'monthly';
} else {
$ratebase = 'Yearly Estimate';
$ratebase_func = 'yearly';
}
?>
function <?php echo $ratebase_func;?>_d<?php echo $func_f['duration'];?>_sum<?php echo $func_f['sum_insured'];?>(){
	document.getElementById('amount').innerHTML = '<?php echo $func_f['rate'];?>';
	document.getElementById('monthly_yearly').innerHTML = '<?php echo $ratebase;?>';
	document.getElementById('complogo').innerHTML = '<img src="images/<?php echo $comp_f['comp_logo'];?>" style="max-height: 100px;"/>';

}
<?php } ?>
</script>
		<!-- JAVASCRIPT FILES 
		<script type="text/javascript">var plugin_path = 'admin/assets/plugins/';</script>
		<script type="text/javascript" src="admin/assets/plugins/jquery/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="admin/assets/js/app.js"></script>-->
</body>
</html>	