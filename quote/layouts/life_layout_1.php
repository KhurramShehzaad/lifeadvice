<?php
/*** LAYOUT 1 **/
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

  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#dob" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  dateFormat: 'yy-mm-dd',
	  yearRange: "-100:+0",
	  endDate: "today",
      maxDate: "today",
    });
  } );
  
  $( function() {
    $( "#departure_date" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  dateFormat: 'yy-mm-dd',
	  yearRange: "+0:+5",
	  minDate: "today",
    });
  } );
<?php if($supervisa == 'no'){?>
  $( function() {
    $( "#return_date" ).datepicker({
       changeMonth: true,
      changeYear: true,
	  dateFormat: 'yy-mm-dd',
	  yearRange: "+0:+5",
	  minDate: "today",
    });
  } );
<?php } ?>
  </script>

<style>
#ui-datepicker-div, .ui-datepicker-div, .ui-datepicker-inline {
	width:auto;
}
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default, .ui-button, html .ui-button.ui-state-disabled:hover, html .ui-button.ui-state-disabled:active {
border: 1px solid #DDD;
background: #F1F1F1;
font-weight: normal;
color: #333;
font-weight: bold;
font-size: 14px;
padding: 0;
text-align: center;	

}

.ui-monthpicker .ui-datepicker-today a, .ui-monthpicker .ui-datepicker-today a:hover, .ui-datepicker .ui-datepicker-current-day a {
background: #c00 !important;
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

.form-control {
border: 1px solid rgb(173, 173, 173) !important;
height: 38px !important;
padding: 1px 10px !important;
font-size: 13px;
overflow: hidden;
color: rgba(0, 0, 0, .87) !important;
background: #FFF !important;
}

.fa, .fas {
color:#f5821f;
}

.submit-btn {
    background: #f5821f;
    font-size: 15px;
    font-weight: normal;
    text-transform: none;
    border-radius: 0;
    border: 0;
    box-shadow: none;
    padding: 10px 25px;
	margin-top:10px;
}
}
.submit-btn:hover {
background: #FFF;
color:#f5821f;
}
.submit-btn i{
	color:#FFF;
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

  border-radius: 50%;

  background-color: #FFF;

border: 4px solid #CCC !important;

}



/* On mouse-over, add a grey background color */

.radio-container:hover input ~ .checkmark {

background-color: #C00;

border: 4px solid #CCC !important;

}



/* When the radio button is checked, add a blue background */

.radio-container input:checked ~ .checkmark {

background-color: #FFF;

border: 4px solid #C00 !important;

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



}

.form-group {

	clear:both;
	margin:10px 0px 5px 10px;

}
.clearfix {
clear:both;	
}
.no-padding {
	padding:0;
}

label.input-label {
padding: 10px 0px 0 !important;
color: #333 !important;
font-size: 15px !important;
margin-bottom: 0;
font-weight: normal !important;	
}

.leftsection {
background: #F1F1F1; padding-bottom:20px;padding-top: 10px;padding-right: 0;	
}
.mainsection {
	border:1px solid #ddd;padding: 10px;
}

@media screen and (max-width: 600px) {
.mainsection {
border:0;
}
.leftsection {
background: #FFF !important;
padding-right: 0px !important;
padding-left: 0px !important;
}	
.form-group {
margin: 0 !important;
}
.container {
	padding:0;
}

}


.preinfo i {
padding: 5px 9px;
background: #0695BD;
border-radius: 54%;
font-size: 11px;
color: #fff;
cursor:pointer;
}
.preinfo i span {
width: 200px;
padding: 10px;
background: rgba(0, 0, 0, 0.8);
position: absolute;
z-index: 100;
top: 10px;
left: 10px;
font-family: arial;
font-size: 12px;
color: #fff;
line-height: 20px;
display: none;	
}
.preinfo > i:hover  span {
	display:block;
}
</style>


<div class="container">
	<div class="row text-center" style="margin-bottom: 30px !important;margin-top: 30px !important;">
	<h1 style="font-weight:bold;margin: 0px;" class="text-danger"><strong><?php echo $product_name;?></strong></h1>
	<h2 style="text-align: center; margin: 0px;" class="hidden-xs">It's fast and easy using our secure online application.</h2>
	</div>



<div class="row mainsection" >

<div class="col-md-7 leftsection">

<script type="text/javascript">

	jQuery(document).ready(function($){

		$("#dh-get-quote").validate();

	    /*$("#dh-get-quote").on("submit",function(){

	        $("#dh-get-quote").validate();

	    })*/

	    

	});

</script>

<?php

if(!empty($_REQUEST['error'])){

?>

	<span style="color:red">Sorry! Not eligible for family plan insurance.</span>

<?php

}

?>

<form action="life_sessions.php?action=info" method="post"  class=" form form-layout1" role="form"  id="dh-get-quote" >

	<div id="">

		   <div class="form-group">
			<div class="col-md-5 "  style="text-align: left;">
				<label class="input-label">Postcode <small class="text-danger" id="postal_error"></small></label> 
			</div>

			<div class="col-md-7 col-xs-12" style="padding-top: 10px;">	
	         <input type="text" name="postcode" id="postcode" class="form-control" value="<?php echo $_SESSION['postcode'];?>" required="" onchange="checkPostal()" />
			</div>
<div class="clearfix"></div>
			</div>


<?php  if($allow_input_field['dob'] == "on"){ ?>
<div class="form-group" id="traveller_1">
<div class="col-md-5 col-xs-12 ">
<label class="input-label">Insurer's Date of Birth</label>
</div>
<div class="col-md-7 col-xs-12">	
<div class="col-md-4 col-xs-4 no-padding" style="padding-right:10px;">
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
<div class="col-md-4 col-xs-4 no-padding" style="padding-left:10px;">
<select name="years" class="form-control col-md-4">
<option value="">Year</option>
<?php if($supervisa == 'yes'){ $maxyear = date('Y') - 40; } else { $maxyear = date('Y'); } for ($x = 1930; $x <= $maxyear; $x++) {?>
<option value="<?php echo date('Y') - $x;?>" <?php if($_SESSION['years'] == 2019 - $x){?> selected="" <?php } ?>><?php echo $x;?></option>
<?php } ?>
</select>
</div>
</div>

<div class="clearfix"></div>
             </div>

<?php } ?>

<?php if($allow_input_field['gender'] == "on" ){ ?>
		   <div class="form-group">
			<div class="col-md-5 "  style="text-align: left;">
				<label class="input-label">Gender</label> 
			</div>

			<div class="col-md-7 col-xs-12" style="padding-top: 10px;">	
	                            <select name="gender" id="gender" class="form-control form-select" required>
                                <option value=""> --- Please choose --- </option>
                                <option value="m" <?php if($_SESSION['gender'] == 'm'){?> selected="" <?php } ?>>Male</option>
                                <option value="f" <?php if($_SESSION['gender'] == 'f'){?> selected="" <?php } ?>>Female</option>
                            </select>
			</div>
<div class="clearfix"></div>
			</div>
<?php } ?>

		<?php if($allow_input_field['smoked'] == "on" ){ ?>
		   <div class="form-group">
			<div class="col-md-5 "  style="text-align: left;">
				<label class="input-label">Tobacco use (Ever?)</label> 
			</div>

			<div class="col-md-7 col-xs-12" style="padding-top: 10px;">	
	                            <select name="smoke" id="smoke" class="form-control form-select" required>
                                <option value=""> --- Please choose --- </option>
                                <option value="1" <?php if($_SESSION['smoke'] == '1'){?> selected="" <?php } ?>>Yes</option>
                                <option value="0" <?php if($_SESSION['smoke'] == '0'){?> selected="" <?php } ?>>No</option>
                            </select>
			</div>
<div class="clearfix"></div>
			</div>

		<?php } ?>

      <!-- Gender of person ends -->

<?php if($allow_input_field['fname'] == "on" ){?>
<div class="form-group">
<div class="col-md-5">
<label class="input-label">First name</label>
</div>
<div class="col-md-7 col-xs-12" style="padding-top: 10px;">	
<input type="text" name="fname" id="fname" class="form-control" value="<?php echo $_SESSION['fname'];?>" required="" />
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if($allow_input_field['lname'] == "on" ){?>
<div class="form-group">
<div class="col-md-5">
<label class="input-label">Last name</label>
</div>
<div class="col-md-7 col-xs-12" style="padding-top: 10px;">	
<input type="text" name="lname" id="lname" class="form-control" value="<?php echo $_SESSION['lname'];?>" required="" />
</div>
<div class="clearfix"></div>
</div>
<?php } ?>

<?php if($allow_input_field['email'] == "on" ){?>
<div class="form-group">
<div class="col-md-5">
<label class="input-label">Email Address</label>
</div>
<div class="col-md-7 col-xs-12" style="padding-top: 10px;">	
<input type="email" name="savers_email" id="savers_email" class="form-control" placeholder="name@example.com" value="<?php echo $_SESSION['savers_email'];?>" required="" />
</div>
<div class="clearfix"></div>
</div>
<?php } ?>

<?php if($allow_input_field['phone'] == "on" ){?>
<div class="form-group">
<div class="col-md-5">
<label class="input-label">Phone Number <small id="phone_error" class="text-danger"></small></label>
</div>
<div class="col-md-7 col-xs-12" style="padding-top: 10px;">
<input type="text" name="phone" id="phone" class="form-control" maxlength="10" value="<?php echo $_SESSION['phone'];?>" onkeyup="validatephone()" required="" />
</div>
<div class="clearfix"></div>
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
<?php } ?>


		   <div class="col-md-12 col-sm-12 col-xs-12 ">
		   <div class="col-md-4 col-xs-6" style="padding-top:20px;">
		   <img src="images/low_pr_icon.png" class="img-responsive">
		   </div>

		   <div class="col-md-8 col-xs-6" style="padding: 0;">
		   <span id="family_error" style="display: none; font-size: 15px;font-weight: bold;text-align: right;padding: 20px;" class="text-danger"><i class="fa fa-warning"></i> </span>
				<button type="submit" name="GET QUOTES" id="GET_QUOTES"  class="btn btn-warning pull-right">Get a Quote <i class="fa fa-angle-double-right"></i> </button>
			</div>
		</div>

	</div>
<input type="hidden" name="quote" value="<?php //echo randomquote(); ?>">
<input type="hidden" name="broker" value="<?php echo $_REQUEST['broker']; ?>">     
<input type="hidden" name="agent" value="<?php echo $_REQUEST['agent']; ?>">
</form>


<div class="clearfix"></div>
</div>



<div class="col-md-5 hidden-xs">
<div class="col-md-12 text-center" style="padding:0;">
<img src="images/Super-Visa-Insurance-visitorguard.ca.jpg" class="img-responsive">
</div>
<div class="col-md-12 text-center" style="padding-top:20px;text-align: justify;background: #f0f0f0;margin-top: 10px;max-height: 335px;overflow-y: auto;border: 1px solid #ddd;">
<strong>Why Choosing us</strong>: we are reputed experience insurance   provider, we provide flexible and affordable Travel Insurance Plan from   multiple insurance companies like <a href="" target="_blank">Manulife Insurance</a>, GMS, <a href="" target="_blank">TIC Insurance</a>,   SRMRM insurance, Travelance Insurance, TUGO, 21st Century, we provide   services in Kitchener, Waterloo, Cambridge, Guelph, Stratford ,Hamilton,   Branford, Woodstock, London, Milton, Mississauga, Brampton, Toronto. <strong>Super Visa Insurance</strong> : Super Visa is a new option for   parents and grandparents of Canadian citizens and permanent residents to   visit their family in Canada. These individuals may be eligible to   apply for the Parent and Grandparent Super Visa to visit their family in   Canada for up to 2 years without the need to renew their status. Super   Visa Insurance provides coverage for emergency medical and hospital care   in Canada. This insurance is valid for 365 days.

<h2>How to Apply for Super Visa Insurance</h2>
<ul>
  <li>Fill out the <a href="http://www.cic.gc.ca/english/pdf/kits/forms/IMM5257E.PDF">Application for a Temporary Resident Visa Made Outside of Canada [IMM5257]</a>.</li>
  <li>Gather any required documentation.</li>
  <li>Submit your completed form and supporting documents to a visa office.</li>
  <li>Make sure to pay the <a href="http://www.cic.gc.ca/english/information/offices/apply-where.asp">fee that coincides with your country or region</a>.</li>
  <li>Make sure to purchase <a href="">Visitors to Canada insurance</a></li>
</ul>

<p><strong>Super visa Requirements : </strong>To obtain a Parent or   Grandparent Super Visa for Canada, applicants must have valid Super Visa   Insurance. With Super Visa applications They need to provide a proof   that they have private medical insurance from a Canadian insurance   company valid for a minimum of 1 year from a Canadian insurance company   and that it:      <strong>Here&rsquo;s the things you need to know before you buy Super Visa Insurance </strong> <strong>Pre-existing Conduction: </strong>A Pre-existing condition   depends on your health condition means the critical illness, injury,   symptom(s) that exists before and after effective date of insurance.   Sometimes a healthy applicant can be deemed to have a pre-existing   condition based on a past health problem or evidence of treatment for a   particular condition. <strong>Deductible:</strong> Most plans have a variety of deductibles.   The deductible is the amount of each claim that you will pay. A $0   deductible means the insurance company pays 100% of each eligible claim.   A $1000 deductible means you will pay up to $1000 of each eligible   claim and the insurance company will only pay amounts in excess of the   $1000. <strong>Multiple Entry</strong>: Multiple entry coverage provides   intermittent coverage that allows you to travel back and forth between   Canada and your home country. Your coverage will be interrupted when you   return to your home country, and then be automatically reinstated when   you return to Canada. Plans that do not offer Multiple Entry have   coverage that stops as soon as you return to your home country. <strong>Side Trip: Side</strong> trip coverage provides travel health   insurance for any trips you take outside Canada during your stay, i.e.   if you take vacations to the U.S. If you expect to spend some time   outside of Canada during the term of your super visa, you should choose a   plan that has side trip coverage. <strong>Refundable</strong>: The government requires that you purchase   coverage for a full year. If you&rsquo;re planning on staying less than a year   a refundable plan will allow you to receive a refund of the unused   portion of the annual/yearly premiums. These refunds come with   conditions, so again it&rsquo;s important that you read the policy.</p>
</div>
</div>

</div>

<div style="clear:both;"></div>

</div>

<script>
	window.onload = function() {
		checktravellers();
	}
    jQuery('#gender:before').click(function() {
        var text = jQuery(this).attr('data-on-text');
//        var text2 = jQuery(this).attr('data-off-text');
//        checkbox-6
         console.log(text);
//         console.log(text2);
    });
    function subform(){
        alert('submit form');
        return false;
    }
    jQuery(document).ready(function($){
    	jQuery("#GET_QUOTES").on("click",function(){
    	});
/*
        $("#number_travelers").on("change", function(){
			//Number OF Traveller
			var number_of_traveller = $("#number_travelers").val();
			var aa = "";
			for(var i=2; i<=number_of_traveller; i++){
			var aa = aa + $("#birthday")[0].outerHTML;
			}
			$("#birthday_view").html(aa);
        })
*/
        $("button[type=submit]").on("change", function(){
            //function validateForm() {
            //if($(this).val() > 1){
            ///		alert('fsd');
            //		return false;
            //}
            //}
        });

        $('button[type="submit"]').click(function() {
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
        });

/* 		$('#GET_QUOTES').click(function(){
			var deparature = $('#departure_date').val();
			$('#departuredate').val(deparature);
		var returndate = $('#return_date').val();
			$('#returndate').val(returndate);
	 	});
*/
    });
</script>
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
var inps = json_encode(<?php echo $_SESSION['years'];?>);
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
<!--<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.4.min.js" ></script>-->
