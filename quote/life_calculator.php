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
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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


<style>
.fields {
border-radius: 10px !important;
}
.radio {
	display: block;
	text-align: left;
}
.infodiv {
	font-size:14px; margin-top:20px;color: #666;font-style: italic;text-align: justify;
}
.btntxt {
	color: #1BBC9B;font-size: 19px;font-weight: bold;text-align: left;
}
.svg {
	width: 80px;display: block;float: none;text-align: center;margin: 15px auto;
}
label {
	font-weight: bold;
}
</style>
	</head>
	
<body onload="calculate();">
<?php include 'lifehead.php'; ?>
<section class="tabscontent" style="background: url(images/life_calculator.jpg);background-size: 100%;background-attachment: fixed;">
<div class="container">
<div class="row">
<div class="col-md-12 hidden-xs text-center">
<h1 class="text-center" style="color:#FFF;">Life Insurance <span>Calculator</span></h1>
<p class="sub-heading" style="color:#FFF;">Please provide the answers below to understand your needs!</p>
</div>
</div>

<div class="row">
<form method="post" action="#">
<div class="col-md-8 col-lg-offset-2" style="background: rgba(255,255,255,0.8);padding: 5em;">
<div class="col-md-12 page_1">
<img src="images/svg/mortgage.svg" class="svg" />
<label>Amount required to pay off the balance of the mortgage</label>
<div class="input-group">
<input type="text" name="mortgage" id="mortgage" class="form-control ui-autocomplete-input" placeholder="$" onchange="cashliabilities()" value="0" autocomplete="off">
<span class="input-group-addon"><i class="fa fa-dollar fa-fw"></i></span>
</div>
<div class="col-md-12 infodiv">
<i class="fa fa-info-circle"></i> including penalties and legal commissions and fees)
</div>
<div class="col-md-12" style="margin-top:30px !important; clear:both;">
<div class="col-md-12 text-center"><button type="button" style="padding:10px 20px !important;" class="btn btn-lg nextbtn" onclick="gopage2()">Next <i class="fa fa-arrow-right"></i></button></div>
</div>
</div>

<div class="col-md-12 page_2" style="display:none;">
<img src="images/svg/debt.svg" class="svg" />
<label>Amount required to pay off personal debts</label>
<div class="input-group">
<input type="text" name="debt" id="debt" class="form-control ui-autocomplete-input" placeholder="$" onchange="cashliabilities()" value="0" autocomplete="off">
<span class="input-group-addon"><i class="fa fa-dollar fa-fw"></i></span>
</div>
<div class="col-md-12 infodiv">
<i class="fa fa-info-circle"></i> including credit cards, personal loans, tuition loans , car loans, etc.
</div>
<div class="col-md-12" style="margin-top:30px !important; clear:both; padding:0;">
<div class="col-md-6 text-left" style="padding: 0;"><button type="button" style="padding:10px 20px !important;" class="btn btn-lg btn-default" onclick="gopage1()"><i class="fa fa-arrow-left"></i> Back</button></div>
<div class="col-md-6 text-right" style="padding: 0;"><button type="button" style="padding:10px 20px !important;" class="btn btn-lg nextbtn" onclick="gopage3()">Next <i class="fa fa-arrow-right"></i></button></div>
</div>
</div>
<div class="col-md-12 page_3" style="display:none;">
<img src="images/svg/wallet.svg" class="svg" />
<label>Emergency reserve fund</label>
<div class="input-group">
<input type="text" name="reserve_fund" id="reserve_fund" class="form-control ui-autocomplete-input" placeholder="$" onchange="cashliabilities()" value="0" autocomplete="off">
<span class="input-group-addon"><i class="fa fa-dollar fa-fw"></i></span>
</div>
<div class="col-md-12 infodiv">
<i class="fa fa-info-circle"></i> including funding for extraordinary medical expenses and a reserve for emergency and unexpected expenses.
</div>
<div class="col-md-12" style="margin-top:30px !important; clear:both; padding:0;">
<div class="col-md-6 text-left" style="padding: 0;"><button type="button" style="padding:10px 20px !important;" class="btn btn-lg btn-default" onclick="gopage2()"><i class="fa fa-arrow-left"></i> Back</button></div>
<div class="col-md-6 text-right" style="padding: 0;"><button type="button" style="padding:10px 20px !important;" class="btn btn-lg nextbtn" onclick="gopage4()">Next <i class="fa fa-arrow-right"></i></button></div>
</div>
</div>
<div class="col-md-12 page_4" style="display:none;">
<img src="images/svg/income.svg" class="svg" />
<label>Final expenses</label>
<div class="input-group">
<input type="text" name="expenses" id="expenses" class="form-control ui-autocomplete-input" placeholder="$" onchange="cashliabilities()" value="0" autocomplete="off">
<span class="input-group-addon"><i class="fa fa-dollar fa-fw"></i></span>
</div>
<div class="col-md-12 infodiv">
<i class="fa fa-info-circle"></i> including income taxes, probate fees, lawyers' commissions and fees, accounting fees, other administrative commissions and fees and funeral costs.
</div>
<div class="col-md-12" style="margin-top:30px !important; clear:both; padding:0;">
<div class="col-md-6 text-left" style="padding: 0;"><button type="button" style="padding:10px 20px !important;" class="btn btn-lg btn-default" onclick="gopage3()"><i class="fa fa-arrow-left"></i> Back</button></div>
<div class="col-md-6 text-right" style="padding: 0;"><button type="button" style="padding:10px 20px !important;" class="btn btn-lg nextbtn" onclick="gopage5()">Next <i class="fa fa-arrow-right"></i></button></div>
</div>
</div>

<div class="col-md-12 page_5" style="display:none;">
<img src="images/svg/education.svg" class="svg" />
<h3 class="text-center">Children's Education Fund</h3>
<label>Number of Children</label>
<div class="input-group">
<input type="text" name="num_of_child" id="num_of_child" class="form-control ui-autocomplete-input" placeholder="1" onchange="childedufunds()" value="0" autocomplete="off">
<span class="input-group-addon"><i class="fa fa-hashtag fa-fw"></i></span>
</div>
<label>Cost per Year per Child</label>
<div class="input-group">
<input type="text" name="cost_per_child" id="cost_per_child" class="form-control ui-autocomplete-input" placeholder="$" onchange="childedufunds()" value="0" autocomplete="off">
<span class="input-group-addon"><i class="fa fa-dollar fa-fw"></i></span>
</div>
<label>Years Needed Per Child</label>
<div class="input-group">
<input type="text" name="num_of_years" id="num_of_years" class="form-control ui-autocomplete-input" placeholder="1" onchange="childedufunds()" value="0" autocomplete="off">
<span class="input-group-addon"><i class="fa fa-hashtag fa-fw"></i></span>
</div>
<div class="col-md-12 infodiv">
<i class="fa fa-info-circle"></i> including income taxes, probate fees, lawyers' commissions and fees, accounting fees, other administrative commissions and fees and funeral costs.
</div>
<div class="col-md-12" style="margin-top:30px !important; clear:both; padding:0;">
<div class="col-md-6 text-left" style="padding: 0;"><button type="button" style="padding:10px 20px !important;" class="btn btn-lg btn-default" onclick="gopage4()"><i class="fa fa-arrow-left"></i> Back</button></div>
<div class="col-md-6 text-right" style="padding: 0;"><button type="button" style="padding:10px 20px !important;" class="btn btn-lg nextbtn" onclick="gopage6()">Next <i class="fa fa-arrow-right"></i></button></div>
</div>
</div>

<div class="col-md-12 page_6" style="display:none;">
<img src="images/svg/debt.svg" class="svg" />
<h3 class="text-center">Funding for replacement of lost income</h3>
<label>Income Frequency:</label>
<select name="frequency" id="frequency" class="form-control" onchange="fundsreplostincome()">
<option value="1">Annual</option>
<option value="2">Semi-Annual</option>
<option value="3">Quarterly</option>
<option value="6">Bi-Monthly</option>
<option value="12" selected="">Monthly</option>
</select>
<label>Income Amount</label>
<div class="input-group">
<input type="text" name="frequency_amount" id="frequency_amount" class="form-control ui-autocomplete-input" placeholder="$" onchange="fundsreplostincome()" value="0" autocomplete="off">
<span class="input-group-addon"><i class="fa fa-dollar fa-fw"></i></span>
</div>
<label>Percentage of income required for survivors (i.e. 90%)</label>
<div class="input-group">
<input type="text" name="percent_survivors" id="percent_survivors" class="form-control ui-autocomplete-input" placeholder="$" onchange="fundsreplostincome()" value="0" autocomplete="off">
<span class="input-group-addon"><i class="fa fa-percent fa-fw"></i></span>
</div>
<label>Number of years over which income continuation will be required</label>
<div class="input-group">
<input type="text" name="num_of_years_continue" id="num_of_years_continue" class="form-control ui-autocomplete-input" placeholder="1" onchange="fundsreplostincome()" value="0" autocomplete="off">
<span class="input-group-addon"><i class="fa fa-hashtag fa-fw"></i></span>
</div>
<label>Anticipated Interest expected on investment of funds:</label>
<div class="input-group">
<input type="text" name="percent_interest" id="percent_interest" class="form-control ui-autocomplete-input" placeholder="$" onchange="fundsreplostincome()" value="0" autocomplete="off">
<span class="input-group-addon"><i class="fa fa-percent fa-fw"></i></span>
</div>
<label>Income is to be indexed (for inflation):</label>
<div class="input-group">
<input type="text" name="income_inflation" id="income_inflation" class="form-control ui-autocomplete-input" placeholder="$" onchange="fundsreplostincome()" value="0" autocomplete="off">
<span class="input-group-addon"><i class="fa fa-percent fa-fw"></i></span>
</div>
<div class="col-md-12" style="margin-top:30px !important; clear:both; padding: 0;">
<div class="col-md-6 text-left" style="padding: 0;"><button type="button" style="padding:10px 20px !important;" class="btn btn-lg btn-default" onclick="gopage5()"><i class="fa fa-arrow-left"></i> Back</button></div>
<div class="col-md-6 text-right" style="padding: 0;"><button type="button" style="padding:10px 20px !important;" class="btn btn-lg nextbtn" onclick="gopage7()">Next <i class="fa fa-arrow-right"></i></button></div>
</div>
</div>
<div class="col-md-12 page_7" style="display:none;">
<img src="images/svg/savings.svg" class="svg" />
<h3 class="text-center">Current Assets</h3>
<label>Liquid Assets: <small style="font-weight:normal;">Including bank accounts, mutual funds, certificates of deposit, stocks, bonds and cash</small></label>
<div class="input-group">
<input type="text" name="liquid_assets" id="liquid_assets" class="form-control ui-autocomplete-input" placeholder="$" onchange="currentassets()" value="0" autocomplete="off">
<span class="input-group-addon"><i class="fa fa-dollar fa-fw"></i></span>
</div>
<label>Face (coverage) amount of all life insurance policies in force:</label>
<div class="input-group">
<input type="text" name="inforce_amount" id="inforce_amount" class="form-control ui-autocomplete-input" placeholder="$" onchange="currentassets()" value="0" autocomplete="off">
<span class="input-group-addon"><i class="fa fa-dollar fa-fw"></i></span>
</div>
<div class="col-md-12" style="margin-top:30px !important; clear:both; padding: 0;">
<div class="col-md-6 text-left" style="padding: 0;"><button type="button" style="padding:10px 20px !important;" class="btn btn-lg btn-default" onclick="gopage6()"><i class="fa fa-arrow-left"></i> Back</button></div>
<div class="col-md-6 text-right" style="padding: 0;"><button type="button" style="padding:10px 20px !important;" class="btn btn-lg nextbtn" onclick="finish()">Finish <i class="fa fa-arrow-right"></i></button></div>
</div>
</div>

<div class="col-md-12 page_8" style="display:none;">
<img src="images/svg/life.svg" class="svg" />
<h3 class="text-center">Here's our suggestion</h3>
<label>This personalized coverage suggestion is based on your life insurance needs.</label>
<h1 id="coverage_estimate_txt" class="text-center"></h1>
<label>The amount shown above is an estimate of the amount of life insurance coverage that you may need IN ADDITION to existing coverage that you have included under</label>
<p>
<i class="fa fa-warning"></i> Note: A negative amount in the yellow box (a minus sign in front ot the amount) may indicate that you may be adequately covered for those liabilities and contingencies that you have included in the above estimate calculator.</p>
<div class="col-md-12 text-center" style="margin-top:30px !important; clear:both; padding: 0;">
<div class="col-md-12 text-center" style="padding: 0;"><a type="button" style="padding:10px 20px !important;" class="btn btn-lg nextbtn" href="life_calculator.php">Start Over <i class="fa fa-refresh"></i></a></div>
</div>
</div>


</div>

<div class="col-md-12 fields results_summary" style="margin-top: 100px;padding: 2em;">
<h2 style="font-weight: bold;font-size: 22px;"><i class="fa fa-check"></i> Results Summary</h2>
<div class="col-md-6">
<div class="total_cash_liabilities" style="display:none;">
<label>Immediate Cash Liabilities at Death:</label>
<button class="btn btntxt" type="button" id="total_cash_liabilities">$0.00</button>
<input type="hidden" name="totalcashliabilities" id="totalcashliabilities" value="0"/>
</div>
<div class="total_child_edu_funds" style="display:none;">
<label>Total (Children's education fund):</label>
<button class="btn btntxt" type="button" id="total_child_edu_funds">$0.00</button>
<input type="hidden" name="totalchildedufunds" id="totalchildedufunds" value="0"/>
</div>
<div class="total_funds_rep_lost_income" style="display:none;">
<label>Total (Provision for income funding):</label>
<button class="btn btntxt" type="button" id="total_funds_rep_lost_income">$0.00</button>
<input type="hidden" name="totalfundsreplostincome" id="totalfundsreplostincome" value="0"/>
</div>
</div>
<div class="col-md-6">
<div class="total_liabilities" style="display:none;">
<h4 style="margin-top: 10px;margin-bottom: 0;font-weight: bold;">Total Liabilities:
<button class="btn btntxt" type="button" id="total_liabilities">$0.00</button></h4>
<input type="hidden" name="totalliabilities" id="totalliabilities" value="0"/>
</div>
<div class="total_assets" style="display:none;">
<h4 style="margin-top: 10px;margin-bottom: 0;font-weight: bold;">Total Assets:
<button class="btn btntxt" type="button" id="total_assets">$0.00</button></h4>
<input type="hidden" name="totalassets" id="totalassets" value="0"/>
</div>
<div class="coverage_estimate" style="display:none;">
<h3 style="margin-top: 10px;margin-bottom: 0;font-weight: bold;">Recommended Estimate
<button class="btn btntxt" type="button" id="coverage_estimate">$0.00</button></h3>
</div>
</div>
</div>
</div>

</form>
</div>
</section>

<script>
function cashliabilities(){
var mortgage = document.getElementById('mortgage').value;
var debt = document.getElementById('debt').value;
var reserve_fund = document.getElementById('reserve_fund').value;
var expenses = document.getElementById('expenses').value;
var totalcashliabilities = parseInt(mortgage) + parseInt(debt) + parseInt(reserve_fund) + parseInt(expenses);
document.getElementById('totalcashliabilities').value = totalcashliabilities;
document.getElementById('total_cash_liabilities').innerHTML = '$' + totalcashliabilities.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
$('.total_cash_liabilities').show();
}
function childedufunds(){
var num_of_child = document.getElementById('num_of_child').value;
var cost_per_child = document.getElementById('cost_per_child').value;
var num_of_years = document.getElementById('num_of_years').value;
var totalchildedufunds = (parseInt(num_of_child) * parseInt(cost_per_child)) * parseInt(num_of_years);
document.getElementById('totalchildedufunds').value = totalchildedufunds;
document.getElementById('total_child_edu_funds').innerHTML = '$' + totalchildedufunds.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");	
$('.total_child_edu_funds').show();
}

function fundsreplostincome(){
var frequency = document.getElementById('frequency').value;
var frequency_amount = document.getElementById('frequency_amount').value;
var percent_survivors = document.getElementById('percent_survivors').value;
var num_of_years_continue = document.getElementById('num_of_years_continue').value;
var percent_interest = document.getElementById('percent_interest').value;
var income_inflation = document.getElementById('income_inflation').value;

var amountwithoutpercent = (parseInt(frequency) * parseInt(frequency_amount));
var percentinterest = (parseInt(amountwithoutpercent) * parseInt(percent_interest) / 100);
var incomeinflation = (parseInt(amountwithoutpercent) * parseInt(income_inflation) / 100);
var totalafterpercentage = (parseInt(amountwithoutpercent) + parseInt(percentinterest) + parseInt(incomeinflation)) * parseInt(num_of_years_continue);
var afterpercentsurvivors = (parseInt(totalafterpercentage) * parseInt(percent_survivors) / 100);
var totalfundsreplostincome = afterpercentsurvivors;

document.getElementById('totalfundsreplostincome').value = totalfundsreplostincome;
document.getElementById('total_funds_rep_lost_income').innerHTML = '$' + totalfundsreplostincome.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
//calling to calculate total libilities
totalliabilities();
$('.total_funds_rep_lost_income').show();
}

function totalliabilities(){
var totalcashliabilities = document.getElementById('totalcashliabilities').value;
var totalchildedufunds = document.getElementById('totalchildedufunds').value;
var totalfundsreplostincome = document.getElementById('totalfundsreplostincome').value;
var totalliabilities = parseInt(totalcashliabilities) + parseInt(totalchildedufunds) + parseInt(totalfundsreplostincome);
document.getElementById('totalliabilities').value = totalliabilities;
document.getElementById('total_liabilities').innerHTML = '$' + totalliabilities.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
$('.total_liabilities').show();	
}

function currentassets(){
var liquid_assets = document.getElementById('liquid_assets').value;
var inforce_amount = document.getElementById('inforce_amount').value;
var totalassets = parseInt(liquid_assets) + parseInt(inforce_amount);
document.getElementById('totalassets').value = totalassets;
document.getElementById('total_assets').innerHTML = '$' + totalassets.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
$('.total_assets').show();
}


function finishcalculation(){
var totalliabilities = document.getElementById('totalliabilities').value;
var totalassets = document.getElementById('totalassets').value;
var coverageestimate = parseInt(totalliabilities) + parseInt(totalassets);
document.getElementById('coverage_estimate').innerHTML = '$' + coverageestimate.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
document.getElementById('coverage_estimate_txt').innerHTML = '$' + coverageestimate.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
$('.coverage_estimate').show();
}

function gopage1(){
$('.page_1').show();
$('.page_2').hide();	
$('.page_3').hide();
$('.page_4').hide();
$('.page_5').hide();
$('.page_6').hide();
$('.page_7').hide();
$('.page_8').hide();
$('.startoverbtn').hide();
$('.results_summary').hide();
}
function gopage2(){
$('.page_1').hide();
$('.page_2').show();	
$('.page_3').hide();
$('.page_4').hide();
$('.page_5').hide();
$('.page_6').hide();
$('.page_7').hide();
$('.page_8').hide();
$('.startoverbtn').show();
$('.results_summary').show();
}
function gopage3(){
$('.page_1').hide();
$('.page_2').hide();	
$('.page_3').show();
$('.page_4').hide();
$('.page_5').hide();
$('.page_6').hide();
$('.page_7').hide();
$('.page_8').hide();
$('.startoverbtn').show();
$('.results_summary').show();
}
function gopage4(){
$('.page_1').hide();
$('.page_2').hide();	
$('.page_3').hide();
$('.page_4').show();
$('.page_5').hide();
$('.page_6').hide();
$('.page_7').hide();
$('.page_8').hide();
$('.startoverbtn').show();
$('.results_summary').show();
}
function gopage5(){
$('.page_1').hide();
$('.page_2').hide();	
$('.page_3').hide();
$('.page_4').hide();
$('.page_5').show();
$('.page_6').hide();
$('.page_7').hide();
$('.page_8').hide();
$('.startoverbtn').show();
$('.results_summary').show();
}
function gopage6(){
$('.page_1').hide();
$('.page_2').hide();	
$('.page_3').hide();
$('.page_4').hide();
$('.page_5').hide();
$('.page_6').show();
$('.page_7').hide();
$('.page_8').hide();
$('.startoverbtn').show();
$('.results_summary').show();
}
function gopage7(){
$('.page_1').hide();
$('.page_2').hide();	
$('.page_3').hide();
$('.page_4').hide();
$('.page_5').hide();
$('.page_6').hide();
$('.page_7').show();
$('.page_8').hide();
$('.startoverbtn').show();
$('.results_summary').show();
}
function finish(){
$('.page_1').hide();
$('.page_2').hide();	
$('.page_3').hide();
$('.page_4').hide();
$('.page_5').hide();
$('.page_6').hide();
$('.page_7').hide();
$('.page_8').show();
$('.startoverbtn').show();
$('.results_summary').show();
finishcalculation();
}
</script>
<?php include 'footer.php'; ?>
		<!-- JAVASCRIPT FILES 
		<script type="text/javascript">var plugin_path = 'admin/assets/plugins/';</script>
		<script type="text/javascript" src="admin/assets/plugins/jquery/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="admin/assets/js/app.js"></script>-->
</body>
</html>	