<?php
include 'includes/db_connect.php';

if($_REQUEST['action'] == 'save_profile'){
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$city = $_POST['city'];
$province = $_POST['province'];
$postal = $_POST['postal'];
$country = $_POST['country'];
$dob = $_POST['dob'];
$facebook = $_POST['facebook'];
$twitter = $_POST['twitter'];
$about_me = $_POST['about_me'];

mysqli_query($db, "UPDATE `users` SET `user_pic`='$user_pic', `fname`='$fname', `lname`='$lname', `email`='$email', `phone`='$phone', `dob`='$dob', `about_me`='$about_me', `facebook`='$facebook', `twitter`='$twitter', `address`='$address', `province`='$province', `postal`='$postal', `country`='$country' WHERE `id`='".$_SESSION['portal_id']."'") or die(mysqli_error($db));
/*$update_q = $dbp->prepare("UPDATE `users` SET `user_pic`=?, `fname`=?, `lname`=?, `email`=?, `phone`=?, `dob`=?, `about_me`=?, `facebook`=?, `twitter`=? WHERE `id`=?");
$update_q->bind_param('bbbbbbbbbb', $user_pic, $fname, $lname, $email, $phone, $dob, $about_me, $facebook, $twitter, $_SESSION['portal_id']);
$update_q->execute();
$update_q->close();*/
	echo "<script>window.location='manage_profile.php'</script>";
}

else if($_REQUEST['action'] == 'save_security'){
$username = $sess_username;
$password = $username.$_POST['password'].$username;
$password = sha1($password);
mysqli_query($db, "UPDATE `users` SET `password`='$password' WHERE `id`='".$_SESSION['portal_id']."'") or die(mysqli_error($db));
echo "<script>window.location='index.php?login=logout'</script>";	
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>My Profile</title>

		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- page specific plugin styles 
		<link rel="stylesheet" href="assets/css/jquery-ui.custom.min.css" />
		<link rel="stylesheet" href="assets/css/jquery.gritter.min.css" />
		<link rel="stylesheet" href="assets/css/select2.min.css" />-->

		<link rel="stylesheet" href="assets/css/bootstrap-editable.min.css" />

		<!-- text fonts -->
		<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->
		<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
		<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler 
		<script src="assets/js/ace-extra.min.js"></script>-->

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
$( "#doc_expiry" ).datepicker({
  changeMonth: true,
      changeYear: true,
	  dateFormat: 'yy-mm-dd',
	  minDate: "today",
});
} );

</script>
<style>
.ui-widget.ui-widget-content {width:auto; }
</style>
	</head>

	<body class="no-skin">

	<?php include 'header.php'; ?>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<?php include 'sidebar.php'; ?>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="#">Home</a>
							</li>

							<li>
								<a href="#">My Account</a>
							</li>
							<li class="active">Manage Profile</li>
						</ul><!-- /.breadcrumb -->

						<div class="nav-search" id="nav-search">
							<form class="form-search">
								<span class="input-icon">
									<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
									<i class="ace-icon fa fa-search nav-search-icon"></i>
								</span>
							</form>
						</div><!-- /.nav-search -->
					</div>

					<div class="page-content">

						<div class="page-header">
							<h1>
								My Profile
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Select your next step below:
								</small>
								<button class="btn btn-primary btn-xs pull-right" onClick="window.location='profile.php'"><i class="fa fa-eye"></i> View Profile</i></button>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<div class="">
									<div id="user-profile-2" class="user-profile">
										<div class="tabbable">
											<ul class="nav nav-tabs padding-18">
												<li class="active">
													<a data-toggle="tab" href="#home">
														<i class="green ace-icon fa fa-user bigger-120"></i>
														My Profile
													</a>
												</li>

												<!--<li>
													<a data-toggle="tab" href="#feed">
														<i class="orange ace-icon fa fa-gear bigger-120"></i>
														Settings
													</a>
												</li>
-->

												<li>
													<a data-toggle="tab" href="#pictures">
														<i class="pink ace-icon fa fa-lock bigger-120"></i>
														Account Security
													</a>
												</li>
                                                  
											</ul>

											<div class="tab-content no-border padding-24">
                                            
												<div id="home" class="tab-pane in active">
                                                <form method="post" action="?action=save_profile">
													<div class="row">
														<div class="col-xs-12 col-sm-9">
															<h4 class="red">
																<span class="middle"><strong>Personal Details</strong></span>
															</h4>
															<div class="profile-user-info">
																<div class="profile-info-row">
																	<div class="profile-info-name"> Name </div>

																	<div class="profile-info-value">
																		<span><input type="text" class="col-xs-12 col-sm-3" placeholder="First Name" id="form-field-1" name="fname" style="margin-right:5px;" value="<?php echo $sess_fname;?>" required></span>
																		<span><input type="text" class="col-xs-12 col-sm-3" placeholder="Last Name" id="form-field-1" name="lname" value="<?php echo $sess_lname;?>" required></span>
																	</div>
																</div>
																<div class="profile-info-row">
																	<div class="profile-info-name"><i class="fa fa-envelope light-blue bigger-110"></i> Email </div>

																	<div class="profile-info-value">
																		
																		<span><input type="email" class="col-xs-12 col-sm-3" placeholder="Last Name" id="form-field-1" name="email" value="<?php echo $sess_email;?>" required></span>
																	</div>
																</div>
																
																<div class="profile-info-row">
																	<div class="profile-info-name"><i class="fa fa-phone light-red bigger-110"></i> Phone </div>

																	<div class="profile-info-value">
																		
																		<span><input type="text" class="col-xs-12 col-sm-3" placeholder="Phone Number" id="form-field-1" name="phone" value="<?php echo $sess_phone;?>" required></span>
																	</div>
																</div>

																<div class="profile-info-row">
																	<div class="profile-info-name"><i class="fa fa-map-marker light-orange bigger-110"></i> Location </div>

																	<div class="profile-info-value">
																		<span><input type="text" class="col-xs-12 col-sm-6" placeholder="Address" id="form-field-1" name="address" value="<?php echo $sess_address;?>" required> 
																		<input type="text" class="col-xs-12 col-sm-3" placeholder="City" id="form-field-1" name="city" value="<?php echo $sess_city;?>" required>
																		<input type="text" class="col-xs-12 col-sm-3" placeholder="Province" id="form-field-1" name="province" value="<?php echo $sess_province;?>" required>
																		<input type="text" class="col-xs-12 col-sm-3" placeholder="Postcode" id="form-field-1" name="postal" value="<?php echo $sess_postal;?>" required>
																		<select id="form-field-select-1" class="col-xs-12 col-sm-6" name="country" required="required" style="height: 34px">
<option selected="selected" label="Select a country … " value="0">Select a country … </option>
<optgroup label="Africa" id="country-optgroup-Africa">
<option label="Algeria" value="DZ">Algeria</option>
<option label="Angola" value="AO">Angola</option>
<option label="Benin" value="BJ">Benin</option>
<option label="Botswana" value="BW">Botswana</option>
<option label="Burkina Faso" value="BF">Burkina Faso</option>
<option label="Burundi" value="BI">Burundi</option>
<option label="Cameroon" value="CM">Cameroon</option>
<option label="Cape Verde" value="CV">Cape Verde</option>
<option label="Central African Republic" value="CF">Central African Republic</option>
<option label="Chad" value="TD">Chad</option>
<option label="Comoros" value="KM">Comoros</option>
<option label="Congo - Brazzaville" value="CG">Congo - Brazzaville</option>
<option label="Congo - Kinshasa" value="CD">Congo - Kinshasa</option>
<option label="Côte d’Ivoire" value="CI">Côte d’Ivoire</option>
<option label="Djibouti" value="DJ">Djibouti</option>
<option label="Egypt" value="EG">Egypt</option>
<option label="Equatorial Guinea" value="GQ">Equatorial Guinea</option>
<option label="Eritrea" value="ER">Eritrea</option>
<option label="Ethiopia" value="ET">Ethiopia</option>
<option label="Gabon" value="GA">Gabon</option>
<option label="Gambia" value="GM">Gambia</option>
<option label="Ghana" value="GH">Ghana</option>
<option label="Guinea" value="GN">Guinea</option>
<option label="Guinea-Bissau" value="GW">Guinea-Bissau</option>
<option label="Kenya" value="KE">Kenya</option>
<option label="Lesotho" value="LS">Lesotho</option>
<option label="Liberia" value="LR">Liberia</option>
<option label="Libya" value="LY">Libya</option>
<option label="Madagascar" value="MG">Madagascar</option>
<option label="Malawi" value="MW">Malawi</option>
<option label="Mali" value="ML">Mali</option>
<option label="Mauritania" value="MR">Mauritania</option>
<option label="Mauritius" value="MU">Mauritius</option>
<option label="Mayotte" value="YT">Mayotte</option>
<option label="Morocco" value="MA">Morocco</option>
<option label="Mozambique" value="MZ">Mozambique</option>
<option label="Namibia" value="NA">Namibia</option>
<option label="Niger" value="NE">Niger</option>
<option label="Nigeria" value="NG">Nigeria</option>
<option label="Rwanda" value="RW">Rwanda</option>
<option label="Réunion" value="RE">Réunion</option>
<option label="Saint Helena" value="SH">Saint Helena</option>
<option label="Senegal" value="SN">Senegal</option>
<option label="Seychelles" value="SC">Seychelles</option>
<option label="Sierra Leone" value="SL">Sierra Leone</option>
<option label="Somalia" value="SO">Somalia</option>
<option label="South Africa" value="ZA">South Africa</option>
<option label="Sudan" value="SD">Sudan</option>
<option label="Swaziland" value="SZ">Swaziland</option>
<option label="São Tomé and Príncipe" value="ST">São Tomé and Príncipe</option>
<option label="Tanzania" value="TZ">Tanzania</option>
<option label="Togo" value="TG">Togo</option>
<option label="Tunisia" value="TN">Tunisia</option>
<option label="Uganda" value="UG">Uganda</option>
<option label="Western Sahara" value="EH">Western Sahara</option>
<option label="Zambia" value="ZM">Zambia</option>
<option label="Zimbabwe" value="ZW">Zimbabwe</option>
</optgroup>
<optgroup label="Americas" id="country-optgroup-Americas">
<option label="Anguilla" value="AI">Anguilla</option>
<option label="Antigua and Barbuda" value="AG">Antigua and Barbuda</option>
<option label="Argentina" value="AR">Argentina</option>
<option label="Aruba" value="AW">Aruba</option>
<option label="Bahamas" value="BS">Bahamas</option>
<option label="Barbados" value="BB">Barbados</option>
<option label="Belize" value="BZ">Belize</option>
<option label="Bermuda" value="BM">Bermuda</option>
<option label="Bolivia" value="BO">Bolivia</option>
<option label="Brazil" value="BR">Brazil</option>
<option label="British Virgin Islands" value="VG">British Virgin Islands</option>
<option label="Canada" value="CA">Canada</option>
<option label="Cayman Islands" value="KY">Cayman Islands</option>
<option label="Chile" value="CL">Chile</option>
<option label="Colombia" value="CO">Colombia</option>
<option label="Costa Rica" value="CR">Costa Rica</option>
<option label="Cuba" value="CU">Cuba</option>
<option label="Dominica" value="DM">Dominica</option>
<option label="Dominican Republic" value="DO">Dominican Republic</option>
<option label="Ecuador" value="EC">Ecuador</option>
<option label="El Salvador" value="SV">El Salvador</option>
<option label="Falkland Islands" value="FK">Falkland Islands</option>
<option label="French Guiana" value="GF">French Guiana</option>
<option label="Greenland" value="GL">Greenland</option>
<option label="Grenada" value="GD">Grenada</option>
<option label="Guadeloupe" value="GP">Guadeloupe</option>
<option label="Guatemala" value="GT">Guatemala</option>
<option label="Guyana" value="GY">Guyana</option>
<option label="Haiti" value="HT">Haiti</option>
<option label="Honduras" value="HN">Honduras</option>
<option label="Jamaica" value="JM">Jamaica</option>
<option label="Martinique" value="MQ">Martinique</option>
<option label="Mexico" value="MX">Mexico</option>
<option label="Montserrat" value="MS">Montserrat</option>
<option label="Netherlands Antilles" value="AN">Netherlands Antilles</option>
<option label="Nicaragua" value="NI">Nicaragua</option>
<option label="Panama" value="PA">Panama</option>
<option label="Paraguay" value="PY">Paraguay</option>
<option label="Peru" value="PE">Peru</option>
<option label="Puerto Rico" value="PR">Puerto Rico</option>
<option label="Saint Barthélemy" value="BL">Saint Barthélemy</option>
<option label="Saint Kitts and Nevis" value="KN">Saint Kitts and Nevis</option>
<option label="Saint Lucia" value="LC">Saint Lucia</option>
<option label="Saint Martin" value="MF">Saint Martin</option>
<option label="Saint Pierre and Miquelon" value="PM">Saint Pierre and Miquelon</option>
<option label="Saint Vincent and the Grenadines" value="VC">Saint Vincent and the Grenadines</option>
<option label="Suriname" value="SR">Suriname</option>
<option label="Trinidad and Tobago" value="TT">Trinidad and Tobago</option>
<option label="Turks and Caicos Islands" value="TC">Turks and Caicos Islands</option>
<option label="U.S. Virgin Islands" value="VI">U.S. Virgin Islands</option>
<option label="United States" value="US">United States</option>
<option label="Uruguay" value="UY">Uruguay</option>
<option label="Venezuela" value="VE">Venezuela</option>
</optgroup>
<optgroup label="Asia" id="country-optgroup-Asia">
<option label="Afghanistan" value="AF">Afghanistan</option>
<option label="Armenia" value="AM">Armenia</option>
<option label="Azerbaijan" value="AZ">Azerbaijan</option>
<option label="Bahrain" value="BH">Bahrain</option>
<option label="Bangladesh" value="BD">Bangladesh</option>
<option label="Bhutan" value="BT">Bhutan</option>
<option label="Brunei" value="BN">Brunei</option>
<option label="Cambodia" value="KH">Cambodia</option>
<option label="China" value="CN">China</option>
<option label="Cyprus" value="CY">Cyprus</option>
<option label="Georgia" value="GE">Georgia</option>
<option label="Hong Kong SAR China" value="HK">Hong Kong SAR China</option>
<option label="India" value="IN">India</option>
<option label="Indonesia" value="ID">Indonesia</option>
<option label="Iran" value="IR">Iran</option>
<option label="Iraq" value="IQ">Iraq</option>
<option label="Israel" value="IL">Israel</option>
<option label="Japan" value="JP">Japan</option>
<option label="Jordan" value="JO">Jordan</option>
<option label="Kazakhstan" value="KZ">Kazakhstan</option>
<option label="Kuwait" value="KW">Kuwait</option>
<option label="Kyrgyzstan" value="KG">Kyrgyzstan</option>
<option label="Laos" value="LA">Laos</option>
<option label="Lebanon" value="LB">Lebanon</option>
<option label="Macau SAR China" value="MO">Macau SAR China</option>
<option label="Malaysia" value="MY">Malaysia</option>
<option label="Maldives" value="MV">Maldives</option>
<option label="Mongolia" value="MN">Mongolia</option>
<option label="Myanmar [Burma]" value="MM">Myanmar [Burma]</option>
<option label="Nepal" value="NP">Nepal</option>
<option label="Neutral Zone" value="NT">Neutral Zone</option>
<option label="North Korea" value="KP">North Korea</option>
<option label="Oman" value="OM">Oman</option>
<option label="Pakistan" value="PK">Pakistan</option>
<option label="Palestinian Territories" value="PS">Palestinian Territories</option>
<option label="People's Democratic Republic of Yemen" value="YD">People's Democratic Republic of Yemen</option>
<option label="Philippines" value="PH">Philippines</option>
<option label="Qatar" value="QA">Qatar</option>
<option label="Saudi Arabia" value="SA">Saudi Arabia</option>
<option label="Singapore" value="SG">Singapore</option>
<option label="South Korea" value="KR">South Korea</option>
<option label="Sri Lanka" value="LK">Sri Lanka</option>
<option label="Syria" value="SY">Syria</option>
<option label="Taiwan" value="TW">Taiwan</option>
<option label="Tajikistan" value="TJ">Tajikistan</option>
<option label="Thailand" value="TH">Thailand</option>
<option label="Timor-Leste" value="TL">Timor-Leste</option>
<option label="Turkey" value="TR">Turkey</option>
<option label="Turkmenistan" value="™">Turkmenistan</option>
<option label="United Arab Emirates" value="AE">United Arab Emirates</option>
<option label="Uzbekistan" value="UZ">Uzbekistan</option>
<option label="Vietnam" value="VN">Vietnam</option>
<option label="Yemen" value="YE">Yemen</option>
</optgroup>
<optgroup label="Europe" id="country-optgroup-Europe">
<option label="Albania" value="AL">Albania</option>
<option label="Andorra" value="AD">Andorra</option>
<option label="Austria" value="AT">Austria</option>
<option label="Belarus" value="BY">Belarus</option>
<option label="Belgium" value="BE">Belgium</option>
<option label="Bosnia and Herzegovina" value="BA">Bosnia and Herzegovina</option>
<option label="Bulgaria" value="BG">Bulgaria</option>
<option label="Croatia" value="HR">Croatia</option>
<option label="Cyprus" value="CY">Cyprus</option>
<option label="Czech Republic" value="CZ">Czech Republic</option>
<option label="Denmark" value="DK">Denmark</option>
<option label="East Germany" value="DD">East Germany</option>
<option label="Estonia" value="EE">Estonia</option>
<option label="Faroe Islands" value="FO">Faroe Islands</option>
<option label="Finland" value="FI">Finland</option>
<option label="France" value="FR">France</option>
<option label="Germany" value="DE">Germany</option>
<option label="Gibraltar" value="GI">Gibraltar</option>
<option label="Greece" value="GR">Greece</option>
<option label="Guernsey" value="GG">Guernsey</option>
<option label="Hungary" value="HU">Hungary</option>
<option label="Iceland" value="IS">Iceland</option>
<option label="Ireland" value="IE">Ireland</option>
<option label="Isle of Man" value="IM">Isle of Man</option>
<option label="Italy" value="IT">Italy</option>
<option label="Jersey" value="JE">Jersey</option>
<option label="Latvia" value="LV">Latvia</option>
<option label="Liechtenstein" value="LI">Liechtenstein</option>
<option label="Lithuania" value="LT">Lithuania</option>
<option label="Luxembourg" value="LU">Luxembourg</option>
<option label="Macedonia" value="MK">Macedonia</option>
<option label="Malta" value="MT">Malta</option>
<option label="Metropolitan France" value="FX">Metropolitan France</option>
<option label="Moldova" value="MD">Moldova</option>
<option label="Monaco" value="MC">Monaco</option>
<option label="Montenegro" value="ME">Montenegro</option>
<option label="Netherlands" value="NL">Netherlands</option>
<option label="Norway" value="NO">Norway</option>
<option label="Poland" value="PL">Poland</option>
<option label="Portugal" value="PT">Portugal</option>
<option label="Romania" value="RO">Romania</option>
<option label="Russia" value="RU">Russia</option>
<option label="San Marino" value="SM">San Marino</option>
<option label="Serbia" value="RS">Serbia</option>
<option label="Serbia and Montenegro" value="CS">Serbia and Montenegro</option>
<option label="Slovakia" value="SK">Slovakia</option>
<option label="Slovenia" value="SI">Slovenia</option>
<option label="Spain" value="ES">Spain</option>
<option label="Svalbard and Jan Mayen" value="SJ">Svalbard and Jan Mayen</option>
<option label="Sweden" value="SE">Sweden</option>
<option label="Switzerland" value="CH">Switzerland</option>
<option label="Ukraine" value="UA">Ukraine</option>
<option label="Union of Soviet Socialist Republics" value="SU">Union of Soviet Socialist Republics</option>
<option label="United Kingdom" value="GB">United Kingdom</option>
<option label="Vatican City" value="VA">Vatican City</option>
<option label="Åland Islands" value="AX">Åland Islands</option>
</optgroup>
<optgroup label="Oceania" id="country-optgroup-Oceania">
<option label="American Samoa" value="AS">American Samoa</option>
<option label="Antarctica" value="AQ">Antarctica</option>
<option label="Australia" value="AU">Australia</option>
<option label="Bouvet Island" value="BV">Bouvet Island</option>
<option label="British Indian Ocean Territory" value="IO">British Indian Ocean Territory</option>
<option label="Christmas Island" value="CX">Christmas Island</option>
<option label="Cocos [Keeling] Islands" value="CC">Cocos [Keeling] Islands</option>
<option label="Cook Islands" value="CK">Cook Islands</option>
<option label="Fiji" value="FJ">Fiji</option>
<option label="French Polynesia" value="PF">French Polynesia</option>
<option label="French Southern Territories" value="TF">French Southern Territories</option>
<option label="Guam" value="GU">Guam</option>
<option label="Heard Island and McDonald Islands" value="HM">Heard Island and McDonald Islands</option>
<option label="Kiribati" value="KI">Kiribati</option>
<option label="Marshall Islands" value="MH">Marshall Islands</option>
<option label="Micronesia" value="FM">Micronesia</option>
<option label="Nauru" value="NR">Nauru</option>
<option label="New Caledonia" value="NC">New Caledonia</option>
<option label="New Zealand" value="NZ">New Zealand</option>
<option label="Niue" value="NU">Niue</option>
<option label="Norfolk Island" value="NF">Norfolk Island</option>
<option label="Northern Mariana Islands" value="MP">Northern Mariana Islands</option>
<option label="Palau" value="PW">Palau</option>
<option label="Papua New Guinea" value="PG">Papua New Guinea</option>
<option label="Pitcairn Islands" value="PN">Pitcairn Islands</option>
<option label="Samoa" value="WS">Samoa</option>
<option label="Solomon Islands" value="SB">Solomon Islands</option>
<option label="South Georgia and the South Sandwich Islands" value="GS">South Georgia and the South Sandwich Islands</option>
<option label="Tokelau" value="TK">Tokelau</option>
<option label="Tonga" value="TO">Tonga</option>
<option label="Tuvalu" value="TV">Tuvalu</option>
<option label="U.S. Minor Outlying Islands" value="UM">U.S. Minor Outlying Islands</option>
<option label="Vanuatu" value="VU">Vanuatu</option>
<option label="Wallis and Futuna" value="WF">Wallis and Futuna</option>
</optgroup>
</select>
																		</span>
																	</div>
																</div>

																<div class="profile-info-row">
																	<div class="profile-info-name"> Date of Birth </div>

																	<div class="profile-info-value col-md-4">
			
																			<div class="input-group">
																				<input class="form-control date-picker" name="dob" id="dob" value="<?php echo $sess_dob;?>" type="text" data-date-format="dd-mm-yyyy" />
																				<span class="input-group-addon">
																					<i class="fa fa-calendar bigger-110"></i>
																				</span>
																			</div>

																	</div>
																</div>

																<div class="profile-info-row">
																	<div class="profile-info-name"> Joined </div>

																	<div class="profile-info-value">
																		<span><?php echo $sess_join_date;?></span>
																	</div>
																</div>

															</div>

															<div class="hr hr-8 dotted"></div>

															<div class="profile-user-info">

																<div class="profile-info-row">
																	<div class="profile-info-name">
																		<i class="middle ace-icon fa fa-facebook-square bigger-150 blue"></i>
																		www.facebook.com/
																	</div>

																	<div class="profile-info-value">
																		<input type="text" class="col-xs-8 col-sm-3" placeholder="Facebook ID" id="form-field-1" name="facebook" value="<?php echo $sess_facebook;?>">
																	</div>
																</div>

																<div class="profile-info-row">
																	<div class="profile-info-name">
																		<i class="middle ace-icon fa fa-twitter-square bigger-150 light-blue"></i>
																		www.twitter.com/
																	</div>

																	<div class="profile-info-value">
																	<input type="text" class="col-xs-8 col-sm-3" placeholder="Twitter ID" id="form-field-1" name="twitter" value="<?php echo $sess_twitter;?>">
																	</div>
																</div>
															</div>
															
														
															<div class="hr hr-8 dotted"></div>
															
														</div><!-- /.col -->
													</div><!-- /.row -->

													<div class="space-20"></div>

													<div class="row">


														<div class="col-xs-12 col-sm-9">
															<div class="widget-box transparent">
																<div class="widget-header widget-header-small">
																	<h4 class="widget-title smaller">
																		<i class="ace-icon fa fa-check-square-o bigger-110"></i>
																		Little About Me
																	</h4>
																</div>

																<div class="widget-body">
																	<div class="widget-main">
																		<textarea class="form-control limited" name="about_me" id="form-field-9" maxlength="500" placeholder="Write something about you..."><?php echo $sess_about_me;?></textarea>
																		
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="space-20"></div>
													<div class="row">
														<div class="col-xs-12 col-sm-9"><input type="submit" value="Submit Changes" class="btn btn-primary">
														</div>
													</div>	
                                                    </form>
												</div><!-- /#home -->
												


												<div id="pictures" class="tab-pane">
													<div class="col-xs-12 col-sm-9">
															<h4 class="blue">
																<span class="middle">Account Security</span>
															</h4>
<form method="post" action="?action=save_security">
															<div class="profile-user-info">
																<div class="profile-info-row">
																	<div style="text-align:left; width:200px;" class="profile-info-name"><i class="fa fa-user light-orange bigger-110"></i> Username </div>

																	<div class="profile-info-value">
																		<span><?php echo $sess_username;?></span>
																	</div>
																</div>
																<div class="profile-info-row">
																	<div style="text-align:left; width:200px;" class="profile-info-name"><i class="ace-icon fa fa-lock"></i> Change Password </div>

																	<div class="profile-info-value col-md-6">
                                                                    	<div class="col-md-5" style="padding:0;">
																		<input type="password" class="col-xs-12 col-sm-12" name="password" id="password" placeholder="Password" value="" <?php if($_REQUEST['id'] == ''){?> required <?php } ?> onkeyup="validatePassword();">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                        <input type="button" onclick="generatepassword();" value="Generate Password" class="btn btn-xs" style="color: rgb(51, 51, 51) ! important; background: rgb(241, 241, 241) none repeat scroll 0% 0% ! important; border-width: 1px; margin-top: 5px; text-shadow: 0px 0px; font-family: arial; font-size: 12px;">
                                                                        </div>
                                                                        <div class="col-md-12" style="padding:0;">
																		<span class="help-inline col-xs-12 col-sm-7" id="password_check" style="padding-top:5px; padding-left:0;"><?php if($_REQUEST['id'] != ''){?><span class="text-info"><i class="fa fa-warning"></i> Leave blank to use old password</span><?php } ?></span>
                                                                        </div>
																	</div>

															</div>

																<div class="profile-info-row">
																	<div style="text-align:left; width:200px;" class="profile-info-name"> </div>

																	<div class="profile-info-value">
																	<span><button class="btn btn-primary btn-xs" type="submit" id="submitbtn"><i class="fa fa-pencil"></i> Submit Changes</button></span>
																	
																	</div>
																</div>

															<div class="hr hr-8 dotted"></div>

														</div>
</form>                                                        
												</div><!-- /#pictures -->
											
											</div>
                                                
										</div>
									</div>
								</div>


								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<?php include 'footer.php';?>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> 
		<script src="assets/js/jquery-2.1.4.min.js"></script>-->

		<!-- <![endif]-->

		<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="assets/js/excanvas.min.js"></script>
		<![endif]
		<script src="assets/js/jquery-ui.custom.min.js"></script>
		<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="assets/js/jquery.gritter.min.js"></script>
		<script src="assets/js/bootbox.js"></script>
		<script src="assets/js/jquery.easypiechart.min.js"></script>
		<script src="assets/js/bootstrap-datepicker.min.js"></script>
		<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
		<script src="assets/js/jquery.hotkeys.index.min.js"></script>
		<script src="assets/js/bootstrap-wysiwyg.min.js"></script>
		<script src="assets/js/select2.min.js"></script>
		<script src="assets/js/spinbox.min.js"></script>-->
		<!--<script src="assets/js/bootstrap-editable.min.js"></script>
		<script src="assets/js/ace-editable.min.js"></script>
		<script src="assets/js/jquery.maskedinput.min.js"></script>-->

		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

<script>
//"^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}"
function validatePassword() {
	//document.getElementById('password').type = 'password';
    var newPassword = document.getElementById('password').value;
    var minNumberofChars = 8;
    var maxNumberofChars = 16;
    var regularExpression  = /^(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}/;
    //alert(newPassword); 
    if(newPassword.length < minNumberofChars || newPassword.length > maxNumberofChars){
        document.getElementById('password_check').innerHTML = '<i class="fa fa-check fa-lg red"></i> Minimum 8 character required';
		document.getElementById('submitbtn').disabled = true;
    } else 
    if(!regularExpression.test(newPassword)) {
        //alert("password should contain atleast one number and one special character");
		document.getElementById('password_check').innerHTML = '<i class="fa fa-close fa-lg red"></i> Atleast one capitalized character, one number and one special character required';
		document.getElementById('submitbtn').disabled = true;
        return false;
    } else {
		document.getElementById('submitbtn').disabled = false;
		document.getElementById('password_check').innerHTML = '<i class="fa fa-check fa-lg green"></i> Valid Password';
	}
}

function generatepassword(){
String.prototype.pick = function(min, max) {
    var n, chars = '';

    if (typeof max === 'undefined') {
        n = min;
    } else {
        n = min + Math.floor(Math.random() * (max - min + 1));
    }

    for (var i = 0; i < n; i++) {
        chars += this.charAt(Math.floor(Math.random() * this.length));
    }

    return chars;
};

String.prototype.shuffle = function() {
    var array = this.split('');
    var tmp, current, top = array.length;

    if (top) while (--top) {
        current = Math.floor(Math.random() * (top + 1));
        tmp = array[current];
        array[current] = array[top];
        array[top] = tmp;
    }

    return array.join('');
};

var specials = '@$%&*?';
var lowercase = 'abcdefghijklmnopqrstuvwxyz';
var uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
var numbers = '0123456789';

var all = uppercase + lowercase + numbers + specials;
//var all = specials + lowercase + uppercase + numbers;

var password = '';
password += uppercase.pick(1);
password += lowercase.pick(5);
password += specials.pick(1);
password += numbers.pick(3);
//password += all.pick(3, 10);
//password = password.shuffle();
document.getElementById('password').type = 'text';
document.getElementById('password').value = password;

validatePassword();	
}
</script>
	</body>
</html>
