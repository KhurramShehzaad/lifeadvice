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
	margin-bottom:10px;
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
border: 1px solid #01a281;
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
	color: #333;
font-size: 14px !important;
}
.form-control {
background: #FFF !important;
border: 1px solid #ccc !important;
}

</style>
  
<div class="container">
<div class="row" style="padding:40px 0;">
<div class="col-md-4 hidden-xs">
<img src="images/woman-4.jpg" style="width: 100%;">
</div>

<div class="col-md-8 visa-insurance" style="padding: 0;"> 
<script type="text/javascript">
	jQuery(document).ready(function($){
		$("#dh-get-quote").validate();
	    /*$("#dh-get-quote").on("submit",function(){
	        $("#dh-get-quote").validate();
	    })*/
	    
	});
</script>

<form action="life_sessions.php?action=info" method="post"  class="form form-layout1" role="form"  >


		  <style>
            #primary_destination{
                overflow-y: scroll;
            }
            #primary_destination_child{
                overflow-y: scroll;
            }
			.ui-datepicker-header{
				margin: -11px 0 0px;
			}



            .input-group {
                width: 100%;
            }
            .input-group .form-control{
                z-index: -1;
                position: initial;
            }


		</style>


	<div id="">

<?php if($allow_input_field['fname'] == "on" ){?>
<div class="col-md-6">
<label class="input-label"><strong>First name</strong></label>
<input type="text" name="fname" id="fname" class="form-control" value="<?php echo $_SESSION['fname'];?>" required="" />
</div>
<div class="col-md-6">
<label class="input-label"><strong>Last name</strong></label>
<input type="text" name="lname" id="lname" class="form-control" value="<?php echo $_SESSION['lname'];?>" required="" />
</div>
<?php } ?>

<?php if($allow_input_field['email'] == "on" ){?>
<div class="col-md-12">
<label class="input-label"><strong>Email Address</strong></label>
<input type="email" name="savers_email" id="savers_email" class="form-control" placeholder="name@example.com" value="<?php echo $_SESSION['savers_email'];?>" required="" />
</div>
<?php } ?>

<?php if($allow_input_field['phone'] == "on" ){?>
<div class="col-md-12">
<label class="input-label"><strong>Phone Number</strong> <small id="phone_error" class="text-danger"></small></label>
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

<div class="col-md-12 col-sm-12 col-xs-12 control-input">
<label class="input-label"><strong>Postcode</strong> <small class="text-danger" id="postal_error"></small></label>
<input type="text" name="postcode" id="postcode" class="form-control" value="<?php echo $_SESSION['postcode'];?>" required="" onchange="checkPostal()" />
</div>


<?php  if($allow_input_field['dob'] == "on" ){    ?>
<div class="col-md-12 col-sm-12 col-xs-12 control-input">
<div class="birthday">
<label class="input-label"><strong>Your Age ?</strong></label>
<select name="years" id="years" class="form-control" required="required">
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
</div>

				<?php } ?>
       
       <!--   Gender of person -->
		<?php
		if($allow_input_field['gender'] == "on" ){ ?>
		   <div class="col-md-6" style="padding:0px;">
			<div class="col-md-12 col-sm-12 control-label"  style="text-align: left;">
				<label class="input-label"><strong>Gender</strong></label>
			</div>
			<div class="col-md-12" style="margin-bottom: 10px;">
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

		<?php if($allow_input_field['smoked'] == "on" ){ ?>
		   <div class="col-md-6" style="padding:0px;">
			<div class="col-md-12 col-sm-12 control-label"  style="text-align: left;">
				<label class="input-label"><strong>Tobacco use (Ever?)</strong></label>
			</div>
			<div class="col-md-12" style="margin-bottom: 10px;">
			<!-- radio -->
			<label class="radio">
				<input type="radio" name="smoke" value="1" <?php if($_SESSION['smoke'] == '1'){?> checked="" <?php } ?>>
				<i></i> Yes
			</label>
			<label class="radio">
				<input type="radio" name="smoke" value="0" <?php if($_SESSION['smoke'] == '0'){?> checked="" <?php } ?>>
				<i></i> No
			</label>
			</div>
			</div>
		<?php } ?>		
      <!-- Gender of person ends -->



	   <div class="col-md-12"  style="margin-top: 20px;">
		   <span id="family_error" style="display: none; font-size: 16px;font-weight: bold;text-align: right;padding: 20px;" class="text-danger"><i class="fa fa-warning"></i> </span>
			<div class="center m-t-30px">
				<button type="submit" class="btn btn-lg nextbtn">Continue <i class="fa fa-arrow-right"></i></button>
			</div>
		</div>

	</div>


<input type="hidden" name="broker" value="<?php echo $_REQUEST['broker']; ?>">     
<input type="hidden" name="agent" value="<?php echo $_REQUEST['agent']; ?>">
	<input type="hidden" name="quote" value="<?php //echo randomquote(); ?>">
</form>
</div>
</div>
</div>

<script>
<?php if($supervisa == 'yes'){?>
function supervisayes(){
window.setTimeout(function(){	
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
}, 1000);
}
<?php } ?>

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

function numoftravelers(){
	if(document.getElementById('familyplan_temp').value == 'yes'){
	checkfamilyplan();
	}
}


</script>



<script>
	
 /*   jQuery('#gender:before').click(function() {
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
*/
    jQuery(document).ready(function($){
        $("select[name=number_travelers]").on("change", function(){
            var number_of_traveller = $(this).val();
            var aa = "";
            for(var i=2; i<=number_of_traveller; i++){
                aa = aa +'<div class="col-md-6 col-sm-6 col-xs-12 control-input">' + $(".birthday")[0].outerHTML +'</div>';
            }

            $("#birthday_view").html(aa);
            console.log( $(".birthday")[0] );
        })
  /*
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

		$('#GET_QUOTES').click(function(){

			var deparature = $('#departure_date').val();
			$('#departuredate').val(deparature);

			var returndate = $('#return_date').val();
			$('#returndate').val(returndate);


	 	});
*/

    });
</script>




<script>

    // function validateEmail(email) {
        // var re =  /\S+@\S+\.\S+/;
        // return re.test(email);
    // }

    // function validate001(email) {

        // if (validateEmail(email)) {
            // document.getElementById('GET_QUOTES').disabled = false;
        // } else {
            // document.getElementById('GET_QUOTES').disabled = 'disabled';
        // }
        // return false;
    // }



</script>



