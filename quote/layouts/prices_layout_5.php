<style>
    .main-content .container{
        width: 100%;
    }
    .main-content {
        background: #f3f5f9 !important;
    }
    .dh-listings{

	}
	.dh-listings b{
		font-size:10px;
	}
	.dh-listings hr{
		border: 1px solid #d0d0d0;
		margin: 0px !important;
	}
	.dh-listings ul{
		font-size:12px;
	}
	.dh-listings tr td , .dh-listings tr th{
		border: 0px solid #eee;
		border-top:0px !important;
	}

	.dh-listings{

	}

	.testshortcode{
		display:none;
	}


	#dh-get-quote select , #dh-get-quote input{
		height: 51px;
	}
	.form-control {

		border-radius: 5px !important;
	}
    .plan-details, .side-bar {
        position: relative;
        background: #fff;
        -webkit-box-shadow: 0 1px 2px 0 rgba(34, 36, 38, .22);
        box-shadow: 0 5px 5px 0 rgba(34, 36, 38, .22);
        margin: 1rem 0;
        padding: 1em;
        border-radius: .25rem;
        border: 1px solid rgba(34, 36, 38, .22);
    }


    .side-bar {
        height: auto;
        padding: 20px 0;
    }

    .adjust-quoto {
        border-top: 2px solid #ddd;
    }

    .adjust-quoto h2 {
        color: #464644;
        font-size: 26px;
        font-weight: 400;
    }

    .adjust-quoto h4 {
        color: #8e939c;
        font-size: 20px;
        font-weight: 400;
    }
    .adjust-quoto span {
font-size: 20px;
border-radius: 50px !important;
border: 5px solid #2e6ac9 !important;
background: #FFF !important;
cursor: pointer !important;
    }
    .quote_reference{
        padding: 10px 15px;
        font-size: 20px;
    }
    #slider{
        margin: 25px 0px;
    }
    .adjust-quoto{
        margin-bottom: 20px;
    }
    #dh-get-quote select{
        height: 51px;
        display: none;
    }
    @media screen and (max-width: 768px) {
		.mob-img, .gfdgd {
    height: 80px;
}
.ui.center.aligned.header {
    position: relative;
}
.ui.checkbox.large.nopad {
    margin: auto;
    position: relative;
    top: initial;
    left: initial;
    display: table;
    width: 100%;
    height: 50px;
    margin-top: 0;
}
.ui.checkbox.large.nopad label {
    padding: 11px;
}
    }

.checkbox-inline{
border: 1px solid #ddd;
width: 181px;
height: 40px;
line-height: 32px;
text-align: center;
background: #F9F9F9;
font-size: 17px;
margin-top: 10px;
border-radius: 3px;
box-shadow: 0px 1px 1px 0px #ccc;
padding-top: 2px;
}

.rangeslider__fill {
    background: #04cca4 !important;
    position: absolute;
}	
.ui-slider-horizontal .ui-slider-range {
	background:#04cca4 !important;
}	
</style>

  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
<?php
$ded = mysqli_query($db, "SELECT `deductible1` FROM wp_dh_insurance_plans_deductibles WHERE `plan_id` IN (SELECT `id` FROM wp_dh_insurance_plans WHERE `product`='$product_id') GROUP BY `deductible1` ORDER BY `deductible1`");
?> 
var Slider_Values = [<?php
				$d = 0;
				$havethousand = 'no';
				while($ded_f = mysqli_fetch_assoc($ded)){
				$d++;
				echo $dedivalue = $ded_f['deductible1'];
				if($d < mysqli_num_rows($ded)){
				echo ', ';
				}
				if($dedivalue == 1000){ $havethousand = 'yes'; }
				} ?>];
<?php if($havethousand == 'yes'){?>
var dValue = Slider_Values.indexOf(1000);
<?php } else { ?>
var dValue = Slider_Values[0];
<?php } ?>
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
			$( "#coverage_deductible" ).val( "$" + Slider_Values[ui.value] );
        }
    });
});

//Sum Insured Slider
<?php
$sum = mysqli_query($db, "SELECT `sum_insured` FROM `wp_dh_insurance_plans_rates` WHERE `plan_id` IN (SELECT `id` FROM wp_dh_insurance_plans WHERE `product`='$product_id') GROUP BY `sum_insured` ORDER BY CAST(`sum_insured` AS DECIMAL)");
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
var iValue = SliderValues.indexOf(<?php echo $_REQUEST['sum_insured2'];?>);
$(function () {
    $("#sum_slider").slider({
		range: "min",
        min: 0,
        max: SliderValues.length - 1,
        step: 1,
		value: iValue,
        slide: function (event, ui) {
            $('#coverage_amount').text(SliderValues[ui.value]);
			//alert(SliderValues.length);
for (i = 0; i < SliderValues.length; i++) {
var group = SliderValues[i];
$('.coverage-amt-'+group).hide();
}
			$('.coverage-amt-'+SliderValues[ui.value]).show();
			$( "#coverage_amount" ).val( "$" + SliderValues[ui.value] );
        }
    });

});
  </script>
  
<div class="dh-listings container"   id="dh-get-quote">
<?php
//	error_reporting(E_ERROR);
$startdate = $_REQUEST['departure_date'];
$enddate = $_REQUEST['return_date'];

//$dStart = new DateTime($_REQUEST['departure_date']);
//$dEnd  = new DateTime($_REQUEST['return_date']);
//$dDiff = $dStart->diff($dEnd);
//$dDiff->format('%R'); // use for point out relation: smaller/greater
$num_of_days = $dDiff->days + 1;
if($num_of_days > 365 || $num_of_days == 364){ $num_of_days = 365; }

$num_of_days = 365;
$prosupervisa = $pro_supervisa;
$product_name = $pro_name;
	
if($prosupervisa == '1'){
$supervisa = 'yes';
$num_of_days = 365;
} else {
$supervisa = 'no';	
}

    $enable_family_plan = (!empty($_REQUEST['familyplan'])) ? true : false;
	$enable_pre_existing = (!empty($_REQUEST['pre_existing'])) ? true : false;

	if($_REQUEST['familyplan_temp'] == 'yes'){
	$enable_family_plan = true;
	} else {
	$enable_family_plan = false;	
	}
	if($_REQUEST['pre_existing'] == 'Yes'){
	$enable_pre_existing = true;
	} else {
	$enable_pre_existing = false;	
	}

	$oldest_traveller = 0;
	$family_plan      = false;

	$years = array();

//Getting Eldest Age
$ages_array = array_filter($_REQUEST['years']);
//print_r($ages_array);
$younger_age = min($ages_array);
$elder_age = max($ages_array);

$number_travelers = count($ages_array);

if($_REQUEST['familyplan_temp'] == 'yes'){
if($number_travelers >= 2 && ($elder_age >= 21 && $elder_age <=58) && ($younger_age <=21)){
$family_plan = 'yes';
}
else {
$family_plan = 'no';
}
} else {
$family_plan = 'no';
}

if($_REQUEST['familyplan_temp'] == 'yes' && $family_plan == 'no'){
 //echo "<script>window.location='?action=not_eligible';</script>";	
}
?>

<div class="row">
		<div class="col-md-12 visible-xs">
	<button type="button" class="btn" onclick="changedisplay()" style="display: block;width: 100%;background: #FFF !important;color: #333 !important;padding: 10px;"><i class="fa fa-gear"></i> Change Coverage</button>
	</div>
	<input type="hidden" id="change_display" name="change_display" value="0" />
<script>
function changedisplay(){
var displayvalue = document.getElementById('change_display').value;
if(displayvalue == '0'){
	$('.filterdiv').attr('style','display: block !important');
	document.getElementById('change_display').value = '1';
} else {
	$('.filterdiv').attr('style','display: none !important');
	document.getElementById('change_display').value = '0';	
}
}
</script>
	<div class="col-md-3 side-bar filterdiv hidden-xs">
        <div class="col-md-12 quote_reference">
            <small><?php
				echo $startdate . " " . $enddate;
				?></small>
                <h1 style="margin: 0;">Quote Reference</h1> 
				<h3 style="margin: 0; font-size:22px;"><?php echo $randomquote; ?></h3>
        </div>
        <div class="col-md-12 adjust-quoto">
            <h2>Adjust your quotes</h2>
            <h4 class="deductible" style="margin: 0;padding: 0;font-weight: bold;margin-bottom: 0;border: none;text-align: left;">Deductible: <input type="text" id="coverage_deductible" name="coverage_deductible" value="$<?php if($havethousand == 'no'){ echo '0'; } else {echo '1000'; } ?>" style="border:0; font-size:24px; color:#444; font-weight:bold;background: no-repeat;margin: 0;padding: 0;text-align: center;width: 100px;"></h4>
				
				<div id="slider" style="border: 1px solid #c5c5c5;padding: 5px;box-shadow: 0px 0px 5px 0px inset #CCC;border-radius: 10px;"></div>
        </div>
        <div class="col-md-12 adjust-quoto" style="border-top:0px">
            <h4 class="coverage" style="margin: 0;padding: 0;font-weight: bold;margin-bottom: 0;border: none;text-align: left;">Coverage: <input type="text" id="coverage_amount" name="coverage_amount" value="$<?php echo $_REQUEST['sum_insured2'];?>" style="border:0; font-size:24px; color:#444; font-weight:bold;background: no-repeat;margin: 0;padding: 0;text-align: center;width: 150px;"></h4>
				<div id="sum_slider" style="border: 1px solid #c5c5c5;padding: 5px;box-shadow: 0px 0px 5px 0px inset #CCC;border-radius: 10px;"></div>
        </div>
	</div>



    <div class="col-md-9" id="listprices">
    <?php
		$addinquery = '';
		if($_REQUEST['pre_existing'] == 'yes' || $_REQUEST['pre_existing'] == '1'){
			$addinquery .= "AND `premedical`='1'";
		} 
		if($family_plan == 'yes'){
			$addinquery .= "AND `family_plan`='1'";
		}
		if($num_of_days < '365'){
			$lessquery = " AND `rate_base`<>'2'";
		}

		$plans_q = mysqli_query($db,  "SELECT * FROM wp_dh_insurance_plans WHERE `product`='$product_id' AND `status`='1' $lessquery $addinquery ORDER BY `id`" );
		while($getplan = mysqli_fetch_assoc($plans_q)){
		$plan_id = $getplan['id'];
		$plan_name = $getplan['plan_name'];
		$insurance_company = $getplan['insurance_company'];
		$premedical = $getplan['premedical'];
		$rate_base = $getplan['rate_base'];  //0=Daily 1=Monthly 2=Yearly 3=Multi
		$monthly_two = $getplan['monthly_two'];
		$flatrate = $getplan['flatrate'];
		$flatrate_type = $getplan['flatrate_type'];
		$sales_tax = $getplan['sales_tax'];
		$smoke_rate = $getplan['smoke_rate'];
		$smoke = $getplan['smoke'];
		$directlink = $getplan['directlink'];
		$status = $getplan['status'];
		$cdiscountrate = $getplan['cdiscountrate'];
		
		$post_dest = str_replace(' ', '', strtolower($_REQUEST['primary_destination']));
		$salestaxeplode = explode('%', $sales_tax);
		$salestax_rate = $salestaxeplode[0];
		$salestax_dest = str_replace(' ', '', $salestaxeplode[1]);
		

		//COMPANY Details
		$company_q = mysqli_query($db,  "SELECT * FROM wp_dh_companies WHERE `comp_id`='$insurance_company'" );
		$company_f = mysqli_fetch_assoc($company_q);
		$comp_id = $company_f['comp_id'];
		$comp_name = $company_f['comp_name'];
		$comp_logo = $company_f['comp_logo'];
		
		
		$deductsloop = mysqli_query($db,  "SELECT `deductible1` FROM wp_dh_insurance_plans_deductibles WHERE `plan_id` IN (SELECT `id` FROM wp_dh_insurance_plans WHERE `product`='$product_id') GROUP BY `deductible1` ORDER BY `deductible1`" );
		while($deductsloop_f = mysqli_fetch_assoc($deductsloop)){
		$deductible = $deductsloop_f['deductible1'];
		
		$deduct = '';
		$deduct_rate = '';
		$deduct_plan_id = '';
		$deductsq = mysqli_query($db, "SELECT `deductible1`, `deductible2`, `plan_id` FROM wp_dh_insurance_plans_deductibles WHERE `plan_id`='$plan_id' AND `deductible1`='$deductible'" );
		$deducti = mysqli_fetch_assoc($deductsq);
		$deduct = $deducti['deductible1'];
		$deduct_rate = str_replace('-', '', $deducti['deductible2']);
		$deduct_plan_id = $deducti['plan_id'];
		

		if($supervisa == 'yes'){
			$addinbenefit = "AND CAST(`sum_insured` AS DECIMAL)>='100000'";
		}
		$sum_insured= '';
		$sumin = mysqli_query($db, "SELECT `sum_insured` FROM `wp_dh_insurance_plans_rates` WHERE `plan_id`='$deduct_plan_id' $addinbenefit GROUP BY `sum_insured` ORDER BY CAST(`sum_insured` AS DECIMAL)");
		while($suminsu = mysqli_fetch_assoc($sumin)){
		$sum_insured = $suminsu['sum_insured'];
		
		$sumamt = '';
		$sumq = mysqli_query($db,  "SELECT `sum_insured` FROM `wp_dh_insurance_plans_rates` WHERE `plan_id`='$plan_id' AND `sum_insured`='$sum_insured'");
		$sumqry = mysqli_fetch_assoc($sumq);
		$sumamt = $sumqry['sum_insured'];
		
		
		//getting prices for each ages

			if($rate_base == '3'){
				$rates_table_name = "wp_dh_plan_day_rate";
				$addquery = "AND '$num_of_days' BETWEEN `min_range` AND `max_range`";
			} else {
				$rates_table_name = "wp_dh_insurance_plans_rates";
				$addquery = "";
			}

			$total_price = 0;
			$daily_rate = 0;
			//$single_person_rate = 0;
			//$single_person_rate = array();
			$display = array();
			if($family_plan == 'yes'){
				$plan_rates = mysqli_query($db,  "SELECT * FROM $rates_table_name WHERE `plan_id`='$deduct_plan_id' AND '$elder_age' BETWEEN `minage` AND `maxage` AND `sum_insured`='$sumamt' $addquery" );
				$planrates = mysqli_fetch_assoc($plan_rates);
				$daily_rate = $planrates['rate'] * 2;	//Multipling by 2 for family elder rate
				
				if(!$daily_rate){ $display = '0'; }
			} else {
				foreach($ages_array as $person_age){
					$plan_rates = mysqli_query($db, "SELECT * FROM $rates_table_name WHERE `plan_id`='$deduct_plan_id' AND '$person_age' BETWEEN `minage` AND `maxage` AND `sum_insured`='$sumamt' $addquery" );	
					$planrates = mysqli_fetch_assoc($plan_rates);
					$dailyrate = $planrates['rate'];

					$daily_rate += $dailyrate;
					if($dailyrate == ''){ $dailyrate = 0; }
					$display[] =  $dailyrate;
					$dailyrate = 0;
				}
			}
			
//print_r($single_person_rate);
//print_r($ages_array);


//NUM OF MONTHS
$num_months = $num_of_days / 30;
$num_months = ceil($num_months ); // converting is 1.2,1.3 etc.. then it will be 2
if($num_months > 12){ $num_months = 12; }

if($rate_base == '0'){ // if daily rate
$total_price = $daily_rate * $num_of_days;
} else if($rate_base == '1'){ //if monthly rate
$total_price = $daily_rate * $num_months;
$monthly_price = $total_price / $num_months;
} else if($rate_base == '2'){ // if yearly rate
$total_price = $daily_rate;
}
else if($rate_base == '3'){ // if multi days rate
$total_price = $daily_rate;
}

if($flatrate_type == 'each'){
$flat_price = $flatrate * $number_travelers;
}else if($flatrate_type == 'total'){
$flat_price = $flatrate;
} else {
$flat_price = 0;
}
//totaldaysprice
$totaldaysprice = $total_price;
//SALES TAX
if($salestax_dest == $post_dest){
//$salesequal = 'yes';
$salestaxes = ($salestax_rate * $totaldaysprice) / 100;
} else {
$salestaxes = 0;
//$salesequal = 'no';
}

//SMOKE RATE
if($_REQUEST['Smoke12'] == 'yes' || $_REQUEST['traveller_Smoke'] == 'yes'){
if($smoke == '0'){
$smoke_price = $smoke_rate;
} else if($smoke == '1'){
$smoke_price = ($totaldaysprice * $smoke_rate) / 100;	
}
} else {
$smoke_price = 0;	
}

// OTHERS
$others = ($flat_price + $salestaxes) + $smoke_price;

//Deductible 
$deduct_discount = ($total_price * $deduct_rate) / 100;
$cdiscount = ($total_price * $cdiscountrate) / 100;
$discount = $deduct_discount + $cdiscount;
$total_price = ($total_price - $discount) + $others;
$monthly_price = $total_price / $num_months;

if (in_array("0", $display)){ $show = '0'; } else {$show = '1'; }
		
		
if($show == '1' && $total_price > 0){
?>
				 <div class="desktop-compare listing-item" data-listing-price="<?php echo str_replace(',', '', number_format($total_price));?>">
                <div class="coverage-amt coverage-amt-<?php echo $sum_insured; ?>"   style="display: <?php if($_REQUEST['sum_insured2'] == $sum_insured ){ echo 'block'; } else { echo 'none'; } ?>; vertical-align: inherit; ">
                    <div class="row plan-details  deductable-<?php echo $deductible; ?>"  style="border:1px solid #c0c0c0;margin-bottom: 20px; display: <?php if($deductible == '1000'){ echo 'block'; } else if($havethousand == 'no' && $deductible == '0'){ echo 'bock'; } else { echo 'none'; } ?>;">
                        <div class="col-md-4" style="border:0px solid #000;  text-align:centerk;padding: 5px 0; ">
                            <i class="fa fa-exclamation-circle dh-toggle" data-value='<?php echo $sum_insured.$deductible.$plan_id; ?>' style="cursor:pointer;position: absolute;top: 43%;left: 0;" aria-hidden="true"></i> &nbsp;
                            <img  style="min-height:20px; margin-left: 20px" width="170" height="60"  src="images/<?php echo $comp_logo; ?>"/>
                        </div>

             <div class="col-md-2" style="border:0px solid #000;font-size: 20px;padding: 15px 0; text-align:center;">$<?php  echo $deductible; ?><br/> Deductible</div>

                        <div class="col-md-3" style="border:0px solid #000; text-align: center; padding: 10px 0;">
                            <h2 style="font-weight:normall;display:inline;font-size: 30px;line-height: 30px">$<?php echo number_format($total_price,2); // $planID2->sum_insured + ?></h2>
<?php if($monthly_two == '1'){?>
		<h2 style="padding;5px; margin:0; font-size:15px; font-weight:bold;color: #333;font-family: arial;padding: 3px;line-height: normal;margin-bottom: 10px;width: auto;">$<?php echo number_format($monthly_price,2);?>/Month<small style="color: #f5821f;font-weight: bold;margin-left: 1px;"><?php echo $num_months;?></small></h2>
		<?php } ?>	
							<p> <?php echo $number_travelers; ?> traveller(s) </p>

                   </div>
                        <div class="col-md-3" style="border:0px solid #000;  text-align:center; ">
<?php
$dob = $_REQUEST['years'][0].'-'.$_REQUEST['month'].''.$_REQUEST['dob_day'];
$agent = $_REQUEST['agent'];
$broker = $_REQUEST['broker'];
$buynow_url = "buynow.php?email=$email&coverage=".$sum_insured."&traveller=".$number_travelers."&deductibles=".$deductible."&deductible_rate=$deduct_rate&person1=$date_of_birth&days=$num_of_days&companyName=$comp_name&comp_id=".$comp_id."&planname=".$plan_name."&plan_id=".$plan_id."&tripdate=$startdate&tripend=$enddate&premium=$total_price&destination=$destination&cdestination=&product_name=$product_name&product_id=$product_id&country=$primary_destination&visitor_visa_type=$product_name&tripduration=$num_of_days&age=$ages_array[0]&dob=$dob&agent=$agent&broker=$broker";
?>

                            <button onclick="$('.buynow_<?php echo $deductible.$plan_id;?>').fadeIn();" class="submit-btn" data-value="<?php echo $plan_id; ?>" style="background: #1c9b22;font-size: 16px;width: 180px;padding: 10px 0 !important;border: 0;box-shadow: none !important;border:0;" class="btn btn-lg btn-danger" name="buynow">Buy this plan</button>
                            <div class="compare">
                                <div class="ui center aligned header">
                                    <label  class="checkbox-inline">
                                        <input data-productid="<?php echo $product_id; ?>"  data-pid="<?php echo $plan_id; ?>" price="<?php echo str_replace(',', '', number_format($total_price));?>"  style=" width: 16px;
        height: 26px;
        text-align: left;
        margin-left: -25px;" type="checkbox" tabindex="0" class="hidden1" value="<?php echo str_replace(',', '', number_format($total_price));?>" onclick="comparetest()">Add to Compare</label>

                                </div>
                            </div>
                            </td>
                        </div>


                        <div class="col-md-12 dh-toggle-show-hide-<?php echo $sum_insured.$deductible.$plan_id; ?>"  style="display:none;">
                            <div class="col-md-6">
                                <b><i class="fa fa-briefcase" aria-hidden="true"></i> Summary:</b> <hr/>
                                <div style="font-size:70%;">
                                    <b>Plan</b> <?php if($family_plan == 'yes'){ echo 'Family'; } else {echo 'Individual';}?><br/>
                                    Days: <?php echo $num_of_days; ?> &nbsp; (<?php echo $startdate." - ".$enddate; ?>)<Br/>
                                    Total: $<?php echo number_format($total_price,2); ?>
										<?php
										$per = 0;
										foreach($ages_array as $person_age){
										$per++;
										?>										
                                        <br/><b>Person <?php echo $per;?></b><br/>
                                        <strong>Age:</strong> <?php echo $person_age; ?> 
										<strong>Coverage Amount:</strong> <?php echo $sum_insured; ?>
                                        <strong>Premium:</strong> $<?php
					$p_plan_rates = mysqli_query($db,  "SELECT * FROM $rates_table_name WHERE `plan_id`='$deduct_plan_id' AND '$person_age' BETWEEN `minage` AND `maxage` AND `sum_insured`='$sumamt' $addquery" );
					$p_planrates = mysqli_fetch_assoc($p_plan_rates);
					$single_person_rate = $p_planrates['rate'];
				
if($family_plan == 'yes' && $elder_age != $person_age){
$person_daily = 0;
} else if($family_plan == 'yes' && $elder_age == $person_age){
$person_daily = $single_person_rate * 2;
} else {
$person_daily = $single_person_rate;
}

if($rate_base == '0'){ // if daily rate
$person_price = $person_daily * $num_of_days;
} else if($rate_base == '1'){ //if monthly rate
$person_price = $person_daily * $num_months;
} else if($rate_base == '2'){ // if yearly rate
$person_price = $person_daily;
}
else if($rate_base == '3'){ // if multi days rate
$person_price = $person_daily;
}

if($flatrate_type == 'each'){
$p_flat_price = $flatrate;
}else if($flatrate_type == 'total'){
$p_flat_price = $flatrate  / $number_travelers;
} else {
$p_flat_price = 0;
}
//totaldaysprice
$ptotaldaysprice = $person_price;
//SALES TAX
if($salestax_dest == $post_dest){
//$salesequal = 'yes';
$p_salestaxes = ($salestax_rate * $ptotaldaysprice) / 100;
} else {
$p_salestaxes = 0;
//$salesequal = 'no';
}

//SMOKE RATE
if($_REQUEST['Smoke12'] == 'yes' || $_REQUEST['traveller_Smoke'] == 'yes'){
if($smoke == '0'){
$p_smoke_price = $smoke_rate;
} else if($smoke == '1'){
$p_smoke_price = ($ptotaldaysprice * $smoke_rate) / 100;	
}
} else {
$p_smoke_price = 0;	
}

// OTHERS
$p_others = ($p_flat_price + $p_salestaxes) + $p_smoke_price;

//Deductible 
$p_deduct_discount = ($person_price * $deduct_rate) / 100;
$p_cdiscount = ($person_price * $cdiscountrate) / 100;
$p_discount = $p_deduct_discount + $p_cdiscount;
$person_price = ($person_price - $p_discount) + $p_others;

											echo number_format($person_price,2); ?>
										<?php } ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <?php
                                $features = mysqli_query($db, "SELECT * FROM wp_dh_insurance_plans_features WHERE plan_id = '$plan_id' " );
                                //
                                ?>
                                <b><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Features:</b><hr/>
                                <ul>
                                    <li>$<?php echo $deductible; ?> deductible  </li>
                                    <?php
                                    if ( mysqli_num_rows($features) > 1 ) {
												while($feature = mysqli_fetch_assoc($features)) {
													echo "<li>".$feature['features']."</li>";
												}
											}
                                    ?>
                                </ul>

                            </div>
                            <div class="col-md-3">
                                <b><i class="fa fa-list-alt" aria-hidden="true"></i> Policy details:</b> <hr/>
                                <?php
                                //foreach (get_all_pdfpolicy($plan_id) as $pdfpolicy):
                                   // echo "<a href='$pdfpolicy->pdfpolicy' style='font-size: 70%;'>Sample Policy</a>";
                               // endforeach;
                                ?>
                            </div>
                        </div>

<div style="clear:both;height:10px;"></div>
<div class="row buynow_<?php echo $deductible.$plan_id;?>" style="clear:both;margin: 0;border: 1px solid #CCC; display:none;">
<div class="col-md-6" style="background:#F9F9F9;">
<h3 style="border-bottom:1px solid #ccc;margin: 0;font-size: 18px;font-weight: bold;">Buy Online</h3>
<p style="font-weight: bold;">In three simple steps you can purchase your policy, easily and securely, online.</p>
<p><input type="checkbox" name="agree" style="height: auto;margin: 0;"> I give permission to LifeAdvice.ca to transfer my quote information and contact details to <?php echo $comp_name;?> in order to complete the purchase of travel insurance. LifeAdvice values your privacy. For details, see our <a href="/">Privacy Policy</a></p>
<p></p>
<p><a class="submit-btn" href="<?php echo $buynow_url;?>" style="background: #1c9b22;font-size: 16px;width: 180px;padding: 10px 0 !important;border: 0;box-shadow: none !important;border:0; display:block;"><i class="fa fa-shopping-cart"></i> Buy Now</a></p>
</div>
<div class="col-md-6 text-center" style="font-size:16px;">
<a href="#" onclick="$('.buynow_<?php echo $deductible.$plan_id;?>').fadeOut();" class="pull-right text-danger" style="font-size:16px;"><i class="fa fa-close"></i></a>
<p>or</p>
<p>BY CALLING</p>
<p><a href="tel:+18555005041" style="font-size:24px; font-weight:bold; color:#44bc9b;">+1-855-500-5041</a></p>
<p style="font-size:13px; font-weight:bold;border-top: 1px solid #eee;padding-top: 10px;">CALL CENTRE HOURS</p>
<p style="font-size:11px;line-height: normal;">Monday to Thursday 8:00 am to 9:00 pm EDT | Friday 8:00 am to 8:00 pm EDT | Saturday 8:30 am to 4:00 pm EDT | Closed on holidays.</p>
</div>
</div>


                    </div>

                </div>
                </div>
				
<?php
						$mailitem[] = array(
							"deductible"  => $deductible,
							"sum_insured" => $sum_insured,
							"planproduct" => $product_name,
							"price"       => $total_price,
							"quote"       => $randomquote,
							"logo"        => $comp_logo,
							"url"         => $_SERVER['REQUEST_URI'] . "&fromemail=yes&quote=" . $randomquote,
							"buynow"      => $buynow_url
						);

						$price[] = $total_price;

?>				
<?php $display = ''; }}}} ?>

	<?php
	$counter = 0;
	if ( ! empty( $mailitem ) && ! isset( $_REQUEST['fromemail'] ) ) {

		foreach ( $mailitem as $key => $row ) {
			$deductible[ $counter ]  = $row['deductible'];
			$buynow[ $counter ]      = $row['buynow'];
			$planproduct[ $counter ] = $row['planproduct'];
			$logo[ $counter ]        = $row['logo'];
			$price[ $counter ]       = $row['price'];
			$counter ++;
		}

		// Sort the data with volume descending, edition ascending
		// Add $data as the last parameter, to sort by the common key
		array_multisort( $price, SORT_ASC, $mailitem );

		//chmod(plugins_url()."/insurance", 0755);


		$content = json_encode( $mailitem );

		$fp = fopen( "email2.txt", "wb" );
		fwrite( $fp, $content );
		fclose( $fp );

		$email = $_REQUEST['savers_email'];
		if($email == ''){
		$email = $_REQUEST['email'];
		}
		// Initiating the mail
		$recipients = array(
			$email,
			//'msharda29@gmail.com'
		);
		$subject    = "Your Quote - $product_name";

		//$message   = file_get_contents( 'emailtemplate.php');
		$headers = "From: quote@lifeadvice.ca\r\n";
		$headers .= "Reply-To: quote@lifeadvice.ca\r\n";
//		$headers .= "CC: susan@example.com\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
		$mailResult = false;
		//$mailResult = mail($email, $subject, $message, $headers);
/*		if($mailResult){
			echo 'email sent';
		} else {
		echo 'email not sent';
		}
		wp_mail( $recipients, $subject, $message, $headers );
		if ( mail(implode(",", $recipients), $subject, $message, implode(PHP_EOL, $headers)) ) {
			wp_mail( $recipients, $subject, $message, $headers );
		} else {
			echo "Not send";
		}
*/

	}
	?>
    </div>
</div>
    <div class="clear"></div> <br/>

<script>
    var buynow_selected = "";
    var info_box = "";

    jQuery(".dh-toggle").click(function(){
        if(info_box != ""){
            jQuery(".dh-toggle-show-hide-"+info_box).slideToggle();
        }

        if( jQuery(this).data('value') == info_box ){
            info_box = "";
            return false;
        }

        if(buynow_selected != ""){
            jQuery(".buynow-btn-"+buynow_selected).slideToggle();
            buynow_selected = "";
        }

        var id = jQuery(this).data('value');
        info_box  = id;
        jQuery(".dh-toggle-show-hide-"+id).slideToggle();
    });


    jQuery(".buynow-btn").click(function(){
        if(buynow_selected != ""){
            jQuery(".buynow-btn-"+buynow_selected).slideToggle();
        }

        if( jQuery(this).data('value') == buynow_selected ){
            buynow_selected = "";
            return false;
        }

        if(info_box != ""){
            jQuery(".dh-toggle-show-hide-"+info_box).slideToggle();
            info_box = "";
        }

        var id = jQuery(this).data('value');
        buynow_selected = id;
        jQuery(".buynow-btn-"+id).slideToggle();
    });



    jQuery('#coverage_deductible').on('change', function() {
        if(! this.value ){
            jQuery(".plan-details").show();
        }else{
            jQuery(".plan-details").hide();
            jQuery(".deductable-"+this.value).show();
        }
    });


    jQuery('#coverage_amount').on('change', function() {
        //alert( this.value );
        if(! this.value ){
            jQuery(".coverage-amt").show();
        }else{
            jQuery(".coverage-amt").hide();
            jQuery(".coverage-amt-"+this.value).show();
        }

    });

</script>

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <!--    <script src="--><?php //echo plugins_url( '/js/jquery/jquery_ui.js' , __FILE__ );  ?><!--"></script>-->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
 /*       //        var abc = jQuery('select#coverage_deductible').selectToUISlider().next();
        jQuery( function() {
            var select = jQuery( "#coverage_deductible" );
            var maximun_option_value = jQuery('#coverage_deductible option').size()-1;
            var slider = jQuery( "<div id='slider'></div>" ).insertAfter( select ).slider({
			  range: false,
			  min: 1,
			  max: maximun_option_value,
			  step: .0989,
			  value: 3,
                slide: function( event, ui ) {
                    select[ 0 ].selectedIndex = ui.value;

                    jQuery('.deductible span').text(select[ 0 ].value);
					
					localStorage.setItem("default_value", select[ 0 ].value);

                    if(! select[ 0 ].value ){
                        jQuery(".plan-details").show();
                    }else{
                        jQuery(".plan-details").hide();
                        jQuery(".deductable-"+select[ 0 ].value).show();
                    }

                }
            });
            jQuery( "#coverage_deductible" ).on( "change", function() {
                slider.slider( "value", this.selectedIndex + 1 );
            });
        } );

        jQuery( function() {
            var select2 = jQuery( "#coverage_amount" );
			var ide = jQuery("#coverage_amount").prop('selectedIndex');
            var maximun_option_value2 = jQuery('#coverage_amount option').size()-1;
            var slider2 = jQuery( "<div id='slider'></div>" ).insertAfter( select2 ).slider({
				range: false,
			    min: 1,
				max: maximun_option_value2,
				step: .0989,
				value: ide,
                slide: function( event, ui ) {
					select2[ 0 ].selectedIndex = ui.value;
					
                    jQuery('.coverage span').text(select2[ 0 ].value);
					
                    localStorage.setItem("price_value", select2[ 0 ].value);
					
                    if(! select2[ 0 ].value ){
                        jQuery(".coverage-amt").show();
                    }else{
                        jQuery(".coverage-amt").hide();
                        jQuery(".coverage-amt-"+select2[ 0 ].value).show();
                    }
                }
            });
            jQuery( "#coverage_amount" ).on( "change", function() {
                slider2.slider( "value", this.selectedIndex + 1 );
            });
        } );*/
    </script>

<!--
	<pre>
	<?php print_r($_REQUEST); ?>
	</pre>
	-->
<script>
jQuery(function($) {
var divList = $(".listing-item");
divList.sort(function(a, b){ return $(a).data("listing-price")-$(b).data("listing-price")});

$("#listprices").html(divList);
})
</script>
</div>