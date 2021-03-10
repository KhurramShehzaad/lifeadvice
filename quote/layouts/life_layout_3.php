<form action="life_sessions.php?action=info" method="post">
<div class="row">
<div class="col-md-12 text-center">
<h1 class="text-center">Tell us about yourself</h1>
<p class="sub-heading">We'll use this information to determine your prices.</p>
</div>
</div>

<div class="row">
<div class="col-md-6 col-lg-offset-3 fields">
<div class="col-md-12" style="margin-bottom: 10px;">
<label><i class="fa fa-map-marker"></i> Postcode <small class="text-danger" id="postal_error"></small></label>
<input type="text" name="postcode" id="postcode" class="form-control" value="<?php echo $_SESSION['postcode'];?>" required="" onchange="checkPostal()" />
</div>

<?php
if($allow_input_field['dob'] == "on" ){ 
?>
<div class="col-md-12">
<div class="row" id="traveller_1">
<h4 class="text-info"><i class="fa fa-user"></i> Insurer's Details</h4>
<label class="input-label">Date of Birth</label>
<div class="col-md-12" style="margin-bottom: 10px; padding:0;">
<div class="col-md-4 col-xs-4 no-padding" style="padding-right:10px;padding-left: 0;">
<select name="month" id="month" class="form-control col-md-4">
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
<select name="dob_day" id="dob_day" class="form-control col-md-4">
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
<select name="years" id="add_1" class="form-control col-md-4">
<option value="">Year</option>
<?php if($supervisa == 'yes'){ $maxyear = date('Y') - 40; } else { $maxyear = date('Y'); } for ($x = 1930; $x <= $maxyear; $x++) {?>
<option value="<?php echo date('Y') - $x;?>" <?php if($_SESSION['years'] == 2019 - $x){?> selected="" <?php } ?>><?php echo $x;?></option>
<?php } ?>
</select>
</div>
</div>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php if($allow_input_field['smoked'] == "on" ){ ?>
<div class="col-md-6" style="padding:0;">
<label class="input-label">Tobacco use (Ever?)</label>
<div class="col-md-12" style="margin-bottom: 10px; padding:0;">
<!-- radio -->
<label class="radio">
	<input type="radio" name="smoke" <?php if($_SESSION['smoke'] == '1'){?> checked="" <?php } ?> value="1">
	<i></i> Yes
</label>
<label class="radio">
	<input type="radio" name="smoke" value="0" <?php if($_SESSION['smoke'] == '0'){?> checked="" <?php } ?>>
	<i></i> No
</label>
</div>
</div>
<?php } ?>
<?php if($allow_input_field['gender'] == "on" ){?>
<div class="col-md-6" style="padding:0;">
<label class="input-label">Gender</label>
<div class="col-md-12" style="margin-bottom: 10px; padding:0;">
<!-- radio -->
<label class="radio">
	<input type="radio" name="gender" value="m" <?php if($_SESSION['gender'] == 'm'){?> checked="" <?php } ?>>
	<i></i> Male
</label>
<label class="radio">
	<input type="radio" name="gender" value="f" <?php if($_SESSION['gender'] == 'f'){?> checked="" <?php } ?>>
	<i></i> Female
</label>
</div>
</div>
<?php } ?>
<?php if($allow_input_field['fname'] == "on" ){?>
<div class="col-md-6" style="padding-left:0;">
<label class="input-label">First name</label>
<input type="text" name="fname" id="fname" class="form-control" value="<?php echo $_SESSION['fname'];?>" required="" />
</div>
<div class="col-md-6" style="padding-right:0;">
<label class="input-label">Last name</label>
<input type="text" name="lname" id="lname" class="form-control" value="<?php echo $_SESSION['lname'];?>" required="" />
</div>
<?php } ?>

<?php if($allow_input_field['email'] == "on" ){?>
<div class="col-md-12" style="padding:0;">
<label class="input-label">Email Address</label>
<input type="email" name="savers_email" id="savers_email" class="form-control" placeholder="name@example.com" value="<?php echo $_SESSION['savers_email'];?>" required="" />
</div>
<?php } ?>

<?php if($allow_input_field['phone'] == "on" ){?>
<div class="col-md-12" style="padding:0;">
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

</div>



</div>
</div>
<div class="row" style="margin-top:30px !important;opacity: 0.7;">
<div class="col-md-12 text-center">
<button type="submit" class="btn btn-lg nextbtn">Continue <i class="fa fa-arrow-right"></i></button>
</div>
</div>
<div class="row" style="margin-top:30px !important;opacity: 0.7;">
<div class="col-md-12 text-center"><i class="fa fa-lock"></i> Your information is secure.</div>
</div>
</form>
