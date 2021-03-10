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
		<title><?php echo $pro_name;?></title>
		<link rel="icon" type="image/png" href="/images/icon.png">
		<!-- mobile settings -->
		<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />
		<!-- CORE CSS -->
		<link href="admin/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="admin/assets/css/essentials.css" rel="stylesheet" type="text/css" />
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<style>
		.box {
			background: #333;
			color: #FFF;
			padding: 1px 5px;
		}
		</style>
	</head>

<body>
<?php include 'lifehead.php'; ?>
<section class="tabscontent">
<div class="row">
<div class="col-md-12 text-center">
<h1 class="text-center">You're almost there!</h1>
<p class="sub-heading">Take a few seconds to fill in the form to begin your application process.</p>
</div>
</div>
<div class="row">
<div class="col-md-8 col-lg-offset-2 fields" style="color:#4F596A;">
<div class="row">
<div class="col-md-12" style="background:#333; color:#FFF;margin-bottom: 10px;">
<h2 style="margin: 0;font-size: 20px;font-weight: bold;color: #FFF;">PROPOSED INSURED</h2>
</div>
</div>

<div class="row">
<div class="col-md-12">
<h2 style="margin-bottom: 10px;font-size: 18px;font-weight: bold;text-transform: uppercase;"><span class="box">A</span> Identification</h2>
</div>
</div>
<div class="row">
<div class="col-md-4">
<label>First Name <small class="text-danger">*</small></label>
<input name="fname" class="form-control"  type="text" placeholder="First name" required>
</div>
<div class="col-md-4">
<label>Last Name <small class="text-danger">*</small></label>
<input name="lname" class="form-control"  type="text" placeholder="Last name" required>
</div>
<div class="col-md-4">
<label>Middle name <small class="text-danger">*</small></label>
<input name="mname" class="form-control"  type="text" placeholder="Middle name" required>
</div>
</div>
<div class="row">
<div class="col-md-12">
<label>If your name has changed, what was your full name at birth?</label>
<input name="fullname_atbirth" class="form-control"  type="text" required>
</div>
</div>
<div class="row">
<div class="col-md-4">
<div class="col-md-12" style="padding:0;">
<label>Sex</label>
</div>
<div class="col-md-12" style="padding:0;">
<label class="radio">
	<input type="radio" name="sex" value="M" checked="checked">
	<i></i> Male
</label>
<label class="radio">
	<input type="radio" name="sex" value="M" checked="checked">
	<i></i> Male
</label>
</div>
</div>
<div class="col-md-4">
<label>Date of birth</label>
<input type="text" class="form-control datepicker" name="dob" />
</div>
<div class="col-md-4">
<div class="col-md-12" style="padding:0;">
<label>Language</label>
</div>
<div class="col-md-12" style="padding:0;">
<label class="radio">
	<input type="radio" name="language" value="English" checked="checked">
	<i></i> English
</label>
<label class="radio">
	<input type="radio" name="language" value="French" checked="checked">
	<i></i> French
</label>
</div>
</div>

</div>

<div class="row">
<div class="col-md-4">
<label>Social Insurance Number <small>Optional</small></label>
<input type="text" class="form-control datepicker" name="social_number" />
</div>
<div class="col-md-8">
<label>Relationship to applicant</label>
<input type="text" class="form-control datepicker" name="relationship" />
</div>
</div>
<div class="row">
<div class="col-md-12" style="margin-bottom:30px;">
At issue, the policy will be established based on the insured’s age as of his or her nearest birthday, unless you wish to save the insured’s actual age.<br/>
If you wish to save the insured’s actual age, indicate the age to save: <input type="text" name="save_age" /><br/>
The policy and premiums will be established based on the indicated age, in accordance with applicable underwriting rules and subject to payment of retroactive premiums.
</div>
</div>
<div class="row">
<div class="col-md-12">
<h2 style="margin-bottom: 10px;font-size: 18px;font-weight: bold;text-transform: uppercase;"><span class="box">B</span> Address</h2>
</div>
<div class="col-md-12" style="margin-bottom:30px; font-weight:bold;">
<i class="fa fa-warning"></i> Always mandatory (If it is not possible to provide a street address, please provide a copy of an identification document with proof of address.)
</div>
</div>
<div class="row">
<div class="col-md-2">
<label>No.</label>
<input type="text" class="form-control" name="address_no" />
</div>
<div class="col-md-7">
<label>Street</label>
<input type="text" class="form-control" name="address_street" />
</div>
<div class="col-md-3">
<label>Apartment/Office/Unit</label>
<input type="text" class="form-control" name="address_apartment" />
</div>
</div>
<div class="row">
<div class="col-md-6">
<label>City</label>
<input type="text" class="form-control" name="address_city" />
</div>
<div class="col-md-3">
<label>Province</label>
<input type="text" class="form-control" name="address_province" />
</div>
<div class="col-md-3">
<label>Postal code</label>
<input type="text" class="form-control" name="address_postcode" />
</div>
</div>
<div class="row">
<div class="col-md-6">
<label>Station <small>Optional</small></label>
<input type="text" class="form-control" name="address_station" />
</div>
<div class="col-md-3">
<label>Rural route</label>
<input type="text" class="form-control" name="address_route" />
</div>
<div class="col-md-3">
<label>P.O. Box</label>
<input type="text" class="form-control" name="address_pobox" />
</div>
</div>
<div class="row">
<div class="col-md-12" style="margin-bottom:10px; margin-top:30px;">
<h2 style="margin-bottom: 10px;font-size: 18px;font-weight: bold;text-transform: uppercase;"><span class="box">C</span> Contact</h2>
</div>
</div>
<div class="row">
<div class="col-md-3">
<label>Home phone</label>
<input type="text" class="form-control" name="home_phone" />
</div>
<div class="col-md-3">
<label>Cell phone</label>
<input type="text" class="form-control" name="cell_phone" />
</div>
<div class="col-md-3">
<label>Work phone</label>
<input type="text" class="form-control" name="work_phone" />
</div>
<div class="col-md-3">
<label>Extension</label>
<input type="text" class="form-control" name="extension" />
</div>
</div>
<div class="row">
<div class="col-md-12" style="margin-bottom:30px;">
<label>Email</label>
<input type="text" class="form-control" name="email" />
</div>
</div>
<div class="row">
<div class="col-md-12">
<h2 style="margin-bottom: 10px;font-size: 18px;font-weight: bold;text-transform: uppercase;"><span class="box">D</span> Confirmation of identity - For Universal Life policies only</h2>
</div>
<div class="col-md-12" style="margin-bottom:30px; font-weight:bold;">
To be completed only if the insured is also the applicant. Refer to an original, unexpired piece of government-issued PHOTO identification.
</div>
</div>
<div class="row">
<div class="col-md-6">
<label>Type of document</label>
<input type="text" class="form-control" name="doc_type" />
</div>
<div class="col-md-6">
<label>Document number</label>
<input type="text" class="form-control" name="doc_num" />
</div>
</div>
<div class="row">
<div class="col-md-6">
<label>Place of issue</label>
<input type="text" class="form-control" name="place_of_issue" />
</div>
<div class="col-md-6">
<label>Expiry date (if applicable)</label>
<input type="text" class="form-control datepicker" name="doc_expiry" />
</div>
</div>

<div class="row">
<div class="col-md-12" style="background:#333; color:#FFF;margin-bottom: 10px; margin-top:30px;">
<h2 style="margin: 0;font-size: 20px;font-weight: bold;color: #FFF;">INSURANCE HISTORY</h2>
</div>
</div>
<div class="row">
<div class="col-md-12">
<h2 style="margin-bottom: 10px;font-size: 18px;font-weight: bold;text-transform: uppercase;"><span class="box">A</span> Pending insurance</h2>
</div>
</div>
<div class="row">
<div class="col-md-6">
Do you have other pending insurance applications?
</div>
<div class="col-md-6 text-right">
<label class="switch switch-success switch-round">
	<input type="checkbox" name="pending_policy" value="1">
	<span class="switch-label" data-on="YES" data-off="NO"></span>
</label>
</div>
</div>
<div class="row">
<div class="col-md-12">
If YES, considering all your pending insurance applications with all insurance companies (including iA Financial Group), what is the total amount you plan on buying?
</div>
</div>
<div class="row">
<div class="col-md-12">
<label>Main insured</label>
</div>
<div class="col-md-12">
<div class="table-responsive">
	<table class="table table-bordered nomargin">
		<thead>
			<tr>
				<th>Amount of life insurance ($)</th>
				<th>Amount of critical illness insurance ($)</th>
				<th>Amount of disability insurance ($)</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><input type="text" name="life_amount" class="form-control" /></td>
				<td><input type="text" name="illness_amount" class="form-control" /></td>
				<td><input type="text" name="disability_amount" class="form-control" /></td>
			</tr>
		</tbody>	
	</table>
</div>	
</div>
</div>
<div class="row">
<div class="col-md-12" style="margin-top:30px;">
<h2 style="margin-bottom: 10px;font-size: 18px;font-weight: bold;text-transform: uppercase;"><span class="box">B</span> Declined insurance</h2>
</div>
</div>
<div class="row">
<div class="col-md-6">
Have you ever been declined for insurance?
</div>
<div class="col-md-6 text-right">
<label class="switch switch-success switch-round">
	<input type="checkbox" name="declined_policy" value="1">
	<span class="switch-label" data-on="YES" data-off="NO"></span>
</label>
</div>
</div>
<div class="row">
<div class="col-md-12">
If YES, please provide the following information:
</div>
</div>
<div class="row">
<div class="col-md-12">
<label>Main insured</label>
</div>
<div class="col-md-12" style="margin-bottom:30px;">
<div class="table-responsive">
	<table class="table table-bordered nomargin">
		<thead>
			<tr>
				<th>Year</th>
				<th>Reason(s)</th>
				<th align="center">Life</th>
				<th align="center">Critical illness</th>
				<th align="center">Disability</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><input type="text" name="declined_year1" class="form-control" /></td>
				<td><input type="text" name="declined_reason1" class="form-control" /></td>
				<td align="center">
				<label class="radio">
					<input type="radio" name="declined_type1" value="Life" checked="checked">
					<i></i>
				</label>
				</td>
				<td align="center">
				<label class="radio">
					<input type="radio" name="declined_type1" value="Critical illness" checked="checked">
					<i></i>
				</label>
				</td>
				<td align="center">
				<label class="radio">
					<input type="radio" name="declined_type1" value="Disability" checked="checked">
					<i></i>
				</label>
				</td>
			</tr>
			<tr>
				<td><input type="text" name="declined_year2" class="form-control" /></td>
				<td><input type="text" name="declined_reason2" class="form-control" /></td>
				<td align="center">
				<label class="radio">
					<input type="radio" name="declined_type2" value="Life" checked="checked">
					<i></i>
				</label>
				</td>
				<td align="center">
				<label class="radio">
					<input type="radio" name="declined_type2" value="Critical illness" checked="checked">
					<i></i>
				</label>
				</td>
				<td align="center">
				<label class="radio">
					<input type="radio" name="declined_type2" value="Disability" checked="checked">
					<i></i>
				</label>
				</td>
			</tr>
			<tr>
				<td><input type="text" name="declined_year3" class="form-control" /></td>
				<td><input type="text" name="declined_reason3" class="form-control" /></td>
				<td align="center">
				<label class="radio">
					<input type="radio" name="declined_type3" value="Life" checked="checked">
					<i></i>
				</label>
				</td>
				<td align="center">
				<label class="radio">
					<input type="radio" name="declined_type3" value="Critical illness" checked="checked">
					<i></i>
				</label>
				</td>
				<td align="center">
				<label class="radio">
					<input type="radio" name="declined_type3" value="Disability" checked="checked">
					<i></i>
				</label>
				</td>
			</tr>
		</tbody>	
	</table>
</div>	
</div>
</div>
<div class="row">
<div class="col-md-12">
<h2 style="margin-bottom: 10px;font-size: 18px;font-weight: bold;text-transform: uppercase;"><span class="box">C</span> Insurance in force</h2>
</div>
</div>
<div class="row">
<div class="col-md-6">
Do you have in-force insurance on your life, excluding group insurance or credit insurance?
</div>
<div class="col-md-6 text-right">
<label class="switch switch-success switch-round">
	<input type="checkbox" name="inforce_policy" value="1">
	<span class="switch-label" data-on="YES" data-off="NO"></span>
</label>
</div>
</div>
<div class="row">
<div class="col-md-12">
If YES, please provide the following information:
</div>
</div>
<div class="row">
<div class="col-md-12">
<label>Main insured</label>
</div>
<div class="col-md-12">
<div class="table-responsive">
	<table class="table table-bordered nomargin">
		<thead>
			<tr>
				<th>Name of company</th>
				<th>Surrender of contract?</th>
				<th>Policy number (iA contract)</th>
				<th>Amount of life insurance ($)</th>
				<th>Amount of critical illness insurance ($)</th>
				<th>Amount of disability insurance ($)</th>
				<th>Year of issue</th>
				<th>Need</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><input type="text" name="inforce_company1" class="form-control" /></td>
				<td><!-- success -->
				<label class="switch switch-success switch-round">
					<input type="checkbox" name="inforce_contract1" value="1">
					<span class="switch-label" data-on="YES" data-off="NO"></span>
				</label>
				</td>
				<td><input type="text" name="inforce_policyno1" class="form-control" /></td>
				<td><input type="text" name="inforce_life_amount1" class="form-control" /></td>
				<td><input type="text" name="inforce_illness_amount1" class="form-control" /></td>
				<td><input type="text" name="inforce_disability_amount1" class="form-control" /></td>
				<td><input type="text" name="inforce_year1" class="form-control" /></td>
				<td>
				<label class="radio">
					<input type="radio" name="inforce_need1" value="Personal" checked="checked">
					<i></i> Personal
				</label>
				<label class="radio">
					<input type="radio" name="inforce_need1" value="Business" checked="checked">
					<i></i> Business
				</label>
				</td>
			</tr>
			<tr>
				<td><input type="text" name="inforce_company2" class="form-control" /></td>
				<td><!-- success -->
				<label class="switch switch-success switch-round">
					<input type="checkbox" name="inforce_contract2" value="1">
					<span class="switch-label" data-on="YES" data-off="NO"></span>
				</label>
				</td>
				<td><input type="text" name="inforce_policyno2" class="form-control" /></td>
				<td><input type="text" name="inforce_life_amount2" class="form-control" /></td>
				<td><input type="text" name="inforce_illness_amount2" class="form-control" /></td>
				<td><input type="text" name="inforce_disability_amount2" class="form-control" /></td>
				<td><input type="text" name="inforce_year2" class="form-control" /></td>
				<td>
				<label class="radio">
					<input type="radio" name="inforce_need2" value="Personal" checked="checked">
					<i></i> Personal
				</label>
				<label class="radio">
					<input type="radio" name="inforce_need2" value="Business" checked="checked">
					<i></i> Business
				</label>
				</td>
			</tr>
			<tr>
				<td><input type="text" name="inforce_company3" class="form-control" /></td>
				<td><!-- success -->
				<label class="switch switch-success switch-round">
					<input type="checkbox" name="inforce_contract3" value="1">
					<span class="switch-label" data-on="YES" data-off="NO"></span>
				</label>
				</td>
				<td><input type="text" name="inforce_policyno3" class="form-control" /></td>
				<td><input type="text" name="inforce_life_amount3" class="form-control" /></td>
				<td><input type="text" name="inforce_illness_amount3" class="form-control" /></td>
				<td><input type="text" name="inforce_disability_amount3" class="form-control" /></td>
				<td><input type="text" name="inforce_year3" class="form-control" /></td>
				<td>
				<label class="radio">
					<input type="radio" name="inforce_need3" value="Personal" checked="checked">
					<i></i> Personal
				</label>
				<label class="radio">
					<input type="radio" name="inforce_need3" value="Business" checked="checked">
					<i></i> Business
				</label>
				</td>
			</tr>
		</tbody>	
	</table>
</div>	
</div>
</div>
<div class="row">
<div class="col-md-12" style="background:#333; color:#FFF;margin-bottom: 10px; margin-top:30px;">
<h2 style="margin: 0;font-size: 20px;font-weight: bold;color: #FFF;">REGULATORY QUESTIONS</h2>
</div>
</div>
<div class="row">
<div class="col-md-12" style="margin-bottom:30px;">
The following questions and the organization classification are required for the purpose of compliance with the Proceeds of Crime (Money Laundering)
and Terrorist Financing Act and Regulations, with the Common Reporting Standard (CRS) and with the U.S. Foreign Account Tax Compliance Act (FATCA).
</div>
</div>
<div class="row">
<div class="col-md-12">
<h2 style="margin-bottom: 10px;font-size: 18px;font-weight: bold;text-transform: uppercase;"><span class="box">A</span> PREMIUM FINANCING – ALWAYS MANDATORY</h2>
</div>
</div>
<div class="row">
<div class="col-md-8">
1) Will the life insurance premiums be financed and/or paid by a lender or any other person who has no relationship with the insured person?
</div>
<div class="col-md-4 text-right">
<label class="switch switch-success switch-round">
	<input type="checkbox" name="payby_lender" value="1">
	<span class="switch-label" data-on="YES" data-off="NO"></span>
</label>
</div>
</div>
<div class="row">
<div class="col-md-6" style="margin-top:10px;">
If YES, indicate the name of the lender or the other person: 
</div>
<div class="col-md-6">
<input type="text" name="lender_name" class="form-control" />
</div>
</div>
<div class="row">
<div class="col-md-12">
<h2 style="margin-bottom: 10px;font-size: 18px;font-weight: bold;text-transform: uppercase;"><span class="box">B</span> TO BE COMPLETED FOR INDIVIDUAL APPLICANTS</h2>
</div>
</div>

</div>
</div>
<div class="row" style="margin-top:30px !important;opacity: 0.7;">
<div class="col-md-12 text-center"><button type="button" id="getquote" class="btn btn-lg nextbtn"><i class="fa fa-shopping-cart"></i> Buy Now</button></div>
</div>
<div class="row" style="margin-top:30px !important;opacity: 0.7;">
<div class="col-md-6 col-lg-offset-3 text-center" style="font-size:16px;">Don't worry, nothing's set in stone. Your dedicated advisor will review everything and contact you before submitting your application. By submitting this form, you consent to your data being sent to an independent representative working with LifeAdvice Insurance.</div>
</div>
<div class="row" style="margin-top:30px !important;opacity: 0.7;">
<div class="col-md-12 text-center"><i class="fa fa-lock"></i> Your information is secure.</div>
</div>
</section>

<?php include 'footer.php'; ?>

		<!-- JAVASCRIPT FILES -->
		<script type="text/javascript">var plugin_path = 'admin/assets/plugins/';</script>
		<!--<script type="text/javascript" src="admin/assets/plugins/jquery/jquery-2.1.4.min.js"></script>-->
		<script type="text/javascript" src="admin/assets/js/app.js"></script>
</body>
</html>	