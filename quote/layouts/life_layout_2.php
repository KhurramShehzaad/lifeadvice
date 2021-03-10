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


$orderdata = $pro_sort;
$allow_input_field = $pro_fields;

$_SESSION['broker'] = $_REQUEST['broker'];
$_SESSION['agent'] = $_REQUEST['agent'];
$_SESSION['user_id'] = $_REQUEST['user_id'];

?>
<style>
.error{
	color: red;
}
#primary_destination_msdd.dd.ddcommon {
    box-shadow: none;
    border: 1px solid #dedede;
    background: none;
    color: #959595;
    font-size: 14px;
}
input[type="text"]:focus, input[type="password"]:focus, input[type="email"]:focus, input[type="url"]:focus, input[type="tel"]:focus, input[type="number"]:focus, input[type="range"]:focus, input[type="date"]:focus, textarea:focus, input.text:focus, input[type="search"]:focus, select:focus, input[type="checkbox"]:focus, .form-control:focus {
    border-color: #ccc !important;
    box-shadow: none !important;
}
form.form.form-layout1 .form-control {
    padding: 5px 12px;
    border-radius: 0px !important;
}
    form.form.form-layout1 .form-control, form.form.form-layout1 .select {
    height: 42px;
}
.dd .ddTitle .ddTitleText {
    padding: 8px 25px 7px 8px !important; 
}
#primary_destination_msdd {
    border-radius: 0;
    height: 42px !important;
}
.toggle-button-icon-fade label {
    height: 42px !important;
}

.toggle-button-icon-fade .toggle-button__icon {
    height: 36px !important;
    width: 28px !important;
    margin: 3px !important;
    background: #eee;
}

    .rangeslider--horizontal {
        height: 15px !important;
    }
    .rangeslider--horizontal .rangeslider__handle {
        top: -13px;
    }

	#dh-get-quote .control-label{
		font-size: 16px;
		font-weight: normal;
		letter-spacing: 0.5px;

	}

    #primary_destination_msdd{
        border-radius: 0;
        height: 50px;
        width: 100% !important;
    }
    .dd .ddTitle .ddTitleText {
        padding: 13px 25px 11px 8px;
    }
	#dh-get-quote button{
padding: 8px 50px;
font-weight: bold;
border: 1px solid #44bc9b;
font-size: 16px;
	}


	#dh-get-quote .range-output{
		position: absolute;
		top: -30px;
		right: 5px;
		font-size: 125%;
	}

.email-main {
    position: relative;
}
.email-main input {
    padding-left: 40px !important;
    position: relative;
}	
label.control-label-mail {
    position: absolute;
    left: 2.5%;
    color: #868585;
    top: 49%;
    padding: 6px 7px;
}
.phone-custom-input2 span.phone-icon {
position: absolute !important;
top: 8% !important;
left: 0.5% !important;
padding: 6px 8px !important;
}


<!--Range Slider CSS-->
.ui-slider-handle .ui-state-default .ui-corner-all {
background: #FFF !important;
font-weight: normal !important;
color: #454545 !important;
padding: 5px !important !important;
width: 25px !important;
height: 25px !important;
margin-top: -5px !important;
border-radius: 50px !important;
border: 5px solid #C00 !important;
}
</style>

<style>
	.toggle-button-icon-fade{
		width: 100%;
		height: 47px;
		color: #444;
		float:left;
	}

	.toggle-button-icon-fade label{
		/*width: 147px;
		height: 47px; */
        width: 100%;
        box-shadow: none;
        border: 1px solid #dedede;
        padding: 5px 20px;
        height: 50px;
        background;#FFF !important;
        color: #959595;
        font-size: 14px;
        line-height: 36px;
        border-radius: 0;
	}

	.toggle-button-icon-fade .toggle-button__icon{
        height: 40px;
        width: 36px;
        margin:4px;
		background:#eee;
	}

	.toggle-button-icon-fade label::before, .toggle-button-icon-fade label::after{
		left: 48px;

		font-weight: normal;
		font-size: 80%;
		color: #686868;

	}

	.selection-box::after{
		height: 43px;
	}


	.toggle-button-icon-fade .toggle-button__icon::before, .toggle-button-icon-fade .toggle-button__icon::after {
		background: #f00;
	}



	.toggle-button-icon-fade .toggle-button__icon::before, .toggle-button-icon-fade .toggle-button__icon::after {
		top:45%;
	}

	.toggle-button__icon::before, .toggle-button__icon::after {
		left: 42%;
	}







#ui-datepicker-div, .ui-datepicker-div, .ui-datepicker-inline {
	width:auto;
}
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default, .ui-button, html .ui-button.ui-state-disabled:hover, html .ui-button.ui-state-disabled:active {
border: none;
background: #f5821f;
font-weight: normal;
color: #fff;
font-weight: bold;
font-size: 14px;	
}
.ui-monthpicker .ui-datepicker-today a, .ui-monthpicker .ui-datepicker-today a:hover, .ui-datepicker .ui-datepicker-current-day a {
background: #44bc9b !important;
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

.ui-slider .ui-slider-handle {
border: 7px solid #44bc9b !important;
background: #f6f6f6  !important;
font-weight: normal  !important;
color: #454545  !important;
height: 25px  !important;
width: 25px  !important;
margin-top: -4px  !important;
border-radius: 20px  !important;
cursor: pointer !important;
}

.ui-slider-vertical .ui-widget-header, .ui-slider-horizontal .ui-widget-header {
	background-color: #44bc9b;
}
form.form.form-layout1 label.input-label {
	padding-bottom:0 !important;
	color: #FFF;
font-size: 14px !important;
}
.form-control {
background: #FFF !important;
border: 1px solid #ccc !important;
}

.clearfix {
	clear:both;
}
</style>


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

<section style="background: linear-gradient( rgba(162, 44, 44, 0.3), rgba(82, 82, 82, 0.3) ), url(<?php echo 'images/bgs/'.$bg;?>.jpg); background-size: cover; background-position: 50% 50%; padding:0px;">
<div class="container">

<div class="row">
<div class="col-md-2 hidden-xs"></div>
<div class="col-md-8 visa-insurance" style="padding-top: 10px;padding-bottom: 20px;background:rgba(0,0,0,0.7);"> 
<div class="clearfix"></div>

	<div class="col-md-12 text-center" style="padding: 20px 0;">
	<h1 style="font-weight:bold;margin: 0px;color: #FFF;font-size: 38px;"><strong><?php echo $product_name;?></strong></h1>
	<h2 style="margin: 0px;font-size: 16px;line-height: normal;color:#FFF;">To start, we have a few quick questions to understand your needs.</h2>
	</div>

<script type="text/javascript">
	jQuery(document).ready(function($){
		$("#dh-get-quote").validate();
	    /*$("#dh-get-quote").on("submit",function(){
	        $("#dh-get-quote").validate();
	    })*/
	    
	});
</script>
<form action="life_sessions.php?action=info" method="post"  class="form form-layout1" role="form"  >
<div id="">
<div class="col-md-12 col-sm-12 col-xs-12 control-input">
<label class="input-label">Postcode <small class="text-danger" id="postal_error"></small></label>
<input type="text" name="postcode" id="postcode" class="form-control" value="<?php echo $_SESSION['postcode'];?>" required="" onchange="checkPostal()" />
</div>
	
<?php   if($allow_input_field['dob'] == "on" ){    ?>
	
<div class="col-md-12 col-sm-12 col-xs-12 control-input">
<label class="input-label">Your Age ?</label>
<select name="years" class="form-control">
<?php $maxyear = date('Y');
$i = $maxyear;
$year = date('Y');
while($i>1918) {?>
<option value="<?php echo $year - $i;?>" <?php if($_SESSION['years'] == $year - $i){?> selected="" <?php } ?>><?php echo $i;?></option>
<?php if($i == 1984){?>
<option value="" <?php if($_SESSION['years'] == ''){?> selected="" <?php } ?>>Year</option>
<?php } ?>
<?php $i--; } ?>
</select>
</div>
				<?php } ?>

        <!---Traveller Smoke-->
			<?php
				if($allow_input_field['smoked'] == "on" ){ ?>
		         <div class="col-md-12 control-label "  style="text-align: left; float:left;" >
					<label class="input-label">Traveller Smoke</label></div>
				<div class="col-md-12 col-sm-12 col-xs-12 control-input" style="text-align: left; float:left;">
					<select name="smoke" class="form-control form-select" id="smoke" autocomplete="off" required>
						<option value="">Please choose</option>
						<option value="1" <?php if($_SESSION['smoke'] == '1'){?> selected="" <?php } ?>>Yes</option>
						<option value="0" <?php if($_SESSION['smoke'] == '0'){?> selected="" <?php } ?>>No</option>
					</select>
				</div>
		
		<?php } ?>

       <!--   Gender of person -->
		<?php
		if($allow_input_field['gender'] == "on"){ ?>
		   <div class="col-md-12" style="padding:0px;">
			<div class="col-md-12 col-sm-12 control-label"  style="text-align: left;">
				<label class="input-label">Gender</label>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 control-input">
			<select name="gender" id="gender" class="form-control" required="">
						<option value="">--- Please Choose ---</option>
						<option value="m" <?php if($_SESSION['gender'] == 'm'){?> selected="" <?php } ?>>Male</option>
						<option value="f" <?php if($_SESSION['gender'] == 'f'){?> selected="" <?php } ?>>Female</option>
						</select>
			</div>
			</div>
		<?php } ?>

      <!-- Gender of person ends -->

<?php if($allow_input_field['fname'] == "on" ){?>
<div class="col-md-6">
<label class="input-label">First name</label>
<input type="text" name="fname" id="fname" class="form-control" value="<?php echo $_SESSION['fname'];?>" required="" />
</div>
<div class="col-md-6">
<label class="input-label">Last name</label>
<input type="text" name="lname" id="lname" class="form-control" value="<?php echo $_SESSION['lname'];?>" required="" />
</div>
<?php } ?>

<?php if($allow_input_field['email'] == "on" ){?>
<div class="col-md-12">
<label class="input-label">Email Address</label>
<input type="email" name="savers_email" id="savers_email" class="form-control" placeholder="name@example.com" value="<?php echo $_SESSION['savers_email'];?>" required="" />
</div>
<?php } ?>

<?php if($allow_input_field['phone'] == "on" ){?>
<div class="col-md-12">
<label class="input-label">Phone Number <small id="phone_error" class="text-danger"></small></label>
<input type="text" name="phone" id="phone" class="form-control" maxlength="10" value="<?php echo $_SESSION['phone'];?>" onkeyup="validatephone()" required="" />
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

		   <div class="col-md-12"  style="margin-top: 20px;">
		   <span id="family_error" style="display: none; font-size: 16px;font-weight: bold;text-align: right;padding: 20px; color:yellow;"><i class="fa fa-warning"></i> </span>
				<button type="submit" name="GET QUOTES" id="GET_QUOTES"  class="btn btn-danger" style="border: 1px solid #44bc9b;padding: 10px 30px;"><i class="fa fa-list"></i> Get a Quote </button>
			</div>

	</div>



<input type="hidden" name="broker" value="<?php echo $_REQUEST['broker']; ?>">     
<input type="hidden" name="agent" value="<?php echo $_REQUEST['agent']; ?>">
<input type="hidden" name="quote" value="<?php //echo randomquote(); ?>">
</form>
<div class="clearfix"></div>

</div>
<div class="col-md-2 hidden-xs"></div>
</div>
</div>
</section>