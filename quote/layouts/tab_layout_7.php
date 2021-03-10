<style>
.date-wrapper {
	height: 40px;
	border-radius: 4px;
	position: relative;
	-webkit-transition: all 0.2s linear;
	width: 100%;
	overflow: hidden;
	display: flex;
	display: -webkit-flex;
	align-items: center;
	-webkit-align-items: center;
	color: #566266;
	background-color: white;
	border: #ddd 2px solid;
}
.date-wrapper input {
    width: 32%;
    border: 0 none;
    text-align: center;
    box-shadow: none;
	border-radius: 4px;
	padding: 15px 15px;
	display: block;
	max-height: 50px;
	background-color: white;
}
</style>
<form action="sessions.php?action=info" method="post">
<div class="row">
<div class="col-md-12 hidden-xs text-center">
<h1 class="text-center">Traveller's Information</h1>
<p class="sub-heading">This information is required in order to provide accurate rates.</p>
</div>
</div>

<div class="row birthdate">
<div class="col-md-6 col-lg-offset-3 fields">

<?php
if($allow_input_field['sum_insured'] == "on" ){ ?>
<div class="col-md-12" style="margin-bottom: 10px;">
<label>Coverage Amount</label>
<select class="form-control" name="sum_insured2" id="sum_insured2">
<option value="">Coverage Amount</option>
<?php
$sumin = mysqli_query($db, "SELECT `sum_insured` FROM `wp_dh_insurance_plans_rates` WHERE `plan_id` IN (SELECT `id` FROM `wp_dh_insurance_plans` WHERE `product`='$product_id') GROUP BY `sum_insured` ORDER BY CAST(`sum_insured` AS DECIMAL)");
while($suminsu = mysqli_fetch_assoc($sumin)){
$sum_insured = $suminsu['sum_insured'];
?>
<option value="<?php echo $sum_insured; ?>" <?php if($_SESSION['sum_insured2'] == $sum_insured){ echo 'selected=""'; } else if($sum_insured == '100000'){?> selected="" <?php } ?> >$<?php echo number_format($sum_insured); ?> </option>
<?php } ?>
</select>
</div>
<?php } ?>


       <!---Destination country -->


        <?php
		if($allow_input_field['Country'] == "on" ){ 
		?>
<div class="col-md-12">
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
			<div class="col-md-12" style="padding:0;"> 
				<label>Trip destination </label>
                <select name="primary_destination" onchange="CountryState(this)" class="form-control form-select" id="primary_destination" aria-required="true" required>

                    <option value='United States' data-imagecss="flag us" data-title="United States">United States</option>

                    <option value='Canada' data-imagecss="flag ca" data-title="Canada" selected="selected">Canada</option>

                    <option value="">---------</option>-->

                    <option value='Andorra' data-imagecss="flag ad" data-title="Andorra">Andorra</option>

                    <option value='United Arab Emirates' data-imagecss="flag ae" data-title="United Arab Emirates">United Arab Emirates</option>

                    <option value='Afghanistan' data-imagecss="flag af" data-title="Afghanistan">Afghanistan</option>

                    <option value='Antigua and Barbuda' data-imagecss="flag ag" data-title="Antigua and Barbuda">Antigua and Barbuda</option>

                    <option value='Anguilla' data-imagecss="flag ai" data-title="Anguilla">Anguilla</option>

                    <option value='Albania' data-imagecss="flag al" data-title="Albania">Albania</option>

                    <option value='Armenia' data-imagecss="flag am" data-title="Armenia">Armenia</option>

                    <option value='Netherlands Antilles' data-imagecss="flag an" data-title="Netherlands Antilles">Netherlands Antilles</option>

                    <option value='Angola' data-imagecss="flag ao" data-title="Angola">Angola</option>

                    <option value='Antarctica' data-imagecss="flag aq" data-title="Antarctica">Antarctica</option>

                    <option value='Argentina' data-imagecss="flag ar" data-title="Argentina">Argentina</option>

                    <option value='American Samoa' data-imagecss="flag as" data-title="American Samoa">American Samoa</option>

                    <option value='Austria' data-imagecss="flag at" data-title="Austria">Austria</option>

                    <option value='Australia' data-imagecss="flag au" data-title="Australia">Australia</option>

                    <option value='Aruba' data-imagecss="flag aw" data-title="Aruba">Aruba</option>

                    <option value='Aland Islands' data-imagecss="flag ax" data-title="Aland Islands">Aland Islands</option>

                    <option value='Azerbaijan' data-imagecss="flag az" data-title="Azerbaijan">Azerbaijan</option>

                    <option value='Bosnia and Herzegovina' data-imagecss="flag ba" data-title="Bosnia and Herzegovina">Bosnia and Herzegovina</option>

                    <option value='Barbados' data-imagecss="flag bb" data-title="Barbados">Barbados</option>

                    <option value='Bangladesh' data-imagecss="flag bd" data-title="Bangladesh">Bangladesh</option>

                    <option value='Belgium' data-imagecss="flag be" data-title="Belgium">Belgium</option>

                    <option value='Burkina Faso' data-imagecss="flag bf" data-title="Burkina Faso">Burkina Faso</option>

                    <option value='Bulgaria' data-imagecss="flag bg" data-title="Bulgaria">Bulgaria</option>

                    <option value='Bahrain' data-imagecss="flag bh" data-title="Bahrain">Bahrain</option>

                    <option value='Burundi' data-imagecss="flag bi" data-title="Burundi">Burundi</option>

                    <option value='Benin' data-imagecss="flag bj" data-title="Benin">Benin</option>

                    <option value='Bermuda' data-imagecss="flag bm" data-title="Bermuda">Bermuda</option>

                    <option value='Brunei Darussalam' data-imagecss="flag bn" data-title="Brunei Darussalam">Brunei Darussalam</option>

                    <option value='Bolivia' data-imagecss="flag bo" data-title="Bolivia">Bolivia</option>

                    <option value='Brazil' data-imagecss="flag br" data-title="Brazil">Brazil</option>

                    <option value='Bahamas' data-imagecss="flag bs" data-title="Bahamas">Bahamas</option>

                    <option value='Bhutan' data-imagecss="flag bt" data-title="Bhutan">Bhutan</option>

                    <option value='Bouvet Island' data-imagecss="flag bv" data-title="Bouvet Island">Bouvet Island</option>

                    <option value='Botswana' data-imagecss="flag bw" data-title="Botswana">Botswana</option>

                    <option value='Belarus' data-imagecss="flag by" data-title="Belarus">Belarus</option>

                    <option value='Belize' data-imagecss="flag bz" data-title="Belize">Belize</option>

                    <option value='Cocos (Keeling) Islands' data-imagecss="flag cc" data-title="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>

                    <option value='Democratic Republic of the Congo' data-imagecss="flag cd" data-title="Democratic Republic of the Congo">Democratic Republic of the Congo</option>

                    <option value='Central African Republic' data-imagecss="flag cf" data-title="Central African Republic">Central African Republic</option>

                    <option value='Congo' data-imagecss="flag cg" data-title="Congo">Congo</option>

                    <option value='Switzerland' data-imagecss="flag ch" data-title="Switzerland">Switzerland</option>

                    <option value='Cote D Ivoire (Ivory Coast)' data-imagecss="flag ci" data-title="Cote D'Ivoire (Ivory Coast)">Cote D'Ivoire (Ivory Coast)</option>

                    <option value='Cook Islands' data-imagecss="flag ck" data-title="Cook Islands">Cook Islands</option>

                    <option value='Chile' data-imagecss="flag cl" data-title="Chile">Chile</option>

                    <option value='Cameroon' data-imagecss="flag cm" data-title="Cameroon">Cameroon</option>

                    <option value='China' data-imagecss="flag cn" data-title="China">China</option>

                    <option value='Colombia' data-imagecss="flag co" data-title="Colombia">Colombia</option>

                    <option value='Costa Rica' data-imagecss="flag cr" data-title="Costa Rica">Costa Rica</option>

                    <option value='Serbia and Montenegro' data-imagecss="flag cs" data-title="Serbia and Montenegro">Serbia and Montenegro</option>

                    <option value='Cuba' data-imagecss="flag cu" data-title="Cuba">Cuba</option>

                    <option value='Cape Verde' data-imagecss="flag cv" data-title="Cape Verde">Cape Verde</option>

                    <option value='Christmas Island' data-imagecss="flag cx" data-title="Christmas Island">Christmas Island</option>

                    <option value='Cyprus' data-imagecss="flag cy" data-title="Cyprus">Cyprus</option>

                    <option value='Czech Republic' data-imagecss="flag cz" data-title="Czech Republic">Czech Republic</option>

                    <option value='Germany' data-imagecss="flag de" data-title="Germany">Germany</option>

                    <option value='Djibouti' data-imagecss="flag dj" data-title="Djibouti">Djibouti</option>

                    <option value='Denmark' data-imagecss="flag dk" data-title="Denmark">Denmark</option>

                    <option value='Dominica' data-imagecss="flag dm" data-title="Dominica">Dominica</option>

                    <option value='Dominican Republic' data-imagecss="flag do" data-title="Dominican Republic">Dominican Republic</option>

                    <option value='Algeria' data-imagecss="flag dz" data-title="Algeria">Algeria</option>

                    <option value='Ecuador' data-imagecss="flag ec" data-title="Ecuador">Ecuador</option>

                    <option value='Estonia' data-imagecss="flag ee" data-title="Estonia">Estonia</option>

                    <option value='Egypt' data-imagecss="flag eg" data-title="Egypt">Egypt</option>

                    <option value='Western Sahara' data-imagecss="flag eh" data-title="Western Sahara">Western Sahara</option>

                    <option value='Eritrea' data-imagecss="flag er" data-title="Eritrea">Eritrea</option>

                    <option value='Spain' data-imagecss="flag es" data-title="Spain">Spain</option>

                    <option value='Ethiopia' data-imagecss="flag et" data-title="Ethiopia">Ethiopia</option>

                    <option value='Finland' data-imagecss="flag fi" data-title="Finland">Finland</option>

                    <option value='Fiji' data-imagecss="flag fj" data-title="Fiji">Fiji</option>

                    <option value='Falkland Islands (Malvinas)' data-imagecss="flag fk" data-title="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>

                    <option value='ederated States of Micronesia' data-imagecss="flag fm" data-title="Federated States of Micronesia">Federated States of Micronesia</option>

                    <option value='Faroe Islands' data-imagecss="flag fo" data-title="Faroe Islands">Faroe Islands</option>

                    <option value='France' data-imagecss="flag fr" data-title="France">France</option>

                    <option value='France, Metropolitan' data-imagecss="flag fx" data-title="France, Metropolitan">France, Metropolitan</option>

                    <option value='Gabon' data-imagecss="flag ga" data-title="Gabon">Gabon</option>

                    <option value='Great Britain (UK)' data-imagecss="flag gb" data-title="Great Britain (UK)">Great Britain (UK)</option>

                    <option value='Grenada' data-imagecss="flag gd" data-title="Grenada">Grenada</option>

                    <option value='Georgia' data-imagecss="flag ge" data-title="Georgia">Georgia</option>

                    <option value='French Guiana' data-imagecss="flag gf" data-title="French Guiana">French Guiana</option>

                    <option value='Ghana' data-imagecss="flag gh" data-title="Ghana">Ghana</option>

                    <option value='Gibraltar' data-imagecss="flag gi" data-title="Gibraltar">Gibraltar</option>

                    <option value='Greenland' data-imagecss="flag gl" data-title="Greenland">Greenland</option>

                    <option value='Gambia' data-imagecss="flag gm" data-title="Gambia">Gambia</option>

                    <option value='Guinea' data-imagecss="flag gn" data-title="Guinea">Guinea</option>

                    <option value='Guadeloupe' data-imagecss="flag gp" data-title="Guadeloupe">Guadeloupe</option>

                    <option value='Equatorial Guinea' data-imagecss="flag gq" data-title="Equatorial Guinea">Equatorial Guinea</option>

                    <option value='Greece' data-imagecss="flag gr" data-title="Greece">Greece</option>

                    <option value='S. Georgia and S. Sandwich Islands' data-imagecss="flag gs" data-title="S. Georgia and S. Sandwich Islands">S. Georgia and S. Sandwich Islands</option>

                    <option value='Guatemala' data-imagecss="flag gt" data-title="Guatemala">Guatemala</option>

                    <option value='Guam' data-imagecss="flag gu" data-title="Guam">Guam</option>

                    <option value='Guinea-Bissau' data-imagecss="flag gw" data-title="Guinea-Bissau">Guinea-Bissau</option>

                    <option value='Guyana' data-imagecss="flag gy" data-title="Guyana">Guyana</option>

                    <option value='Hong Kong' data-imagecss="flag hk" data-title="Hong Kong">Hong Kong</option>

                    <option value='Heard Island and McDonald Islands' data-imagecss="flag hm" data-title="Heard Island and McDonald Islands">Heard Island and McDonald Islands</option>

                    <option value='Honduras' data-imagecss="flag hn" data-title="Honduras">Honduras</option>

                    <option value='Croatia (Hrvatska)' data-imagecss="flag hr" data-title="Croatia (Hrvatska)">Croatia (Hrvatska)</option>

                    <option value='Haiti' data-imagecss="flag ht" data-title="Haiti">Haiti</option>

                    <option value='Hungary' data-imagecss="flag hu" data-title="Hungary">Hungary</option>

                    <option value='Indonesia' data-imagecss="flag id" data-title="Indonesia">Indonesia</option>

                    <option value='Ireland' data-imagecss="flag ie" data-title="Ireland">Ireland</option>

                    <option value='Israel' data-imagecss="flag il" data-title="Israel">Israel</option>

                    <option value='India' data-imagecss="flag in" data-title="India">India</option>

                    <option value='British Indian Ocean Territory' data-imagecss="flag io" data-title="British Indian Ocean Territory">British Indian Ocean Territory</option>

                    <option value='Iraq' data-imagecss="flag iq" data-title="Iraq">Iraq</option>

                    <option value='Iran' data-imagecss="flag ir" data-title="Iran">Iran</option>

                    <option value='Iceland' data-imagecss="flag is" data-title="Iceland">Iceland</option>

                    <option value='Italy' data-imagecss="flag it" data-title="Italy">Italy</option>

                    <option value='Jamaica' data-imagecss="flag jm" data-title="Jamaica">Jamaica</option>

                    <option value='Jordan' data-imagecss="flag jo" data-title="Jordan">Jordan</option>

                    <option value='Japan' data-imagecss="flag jp" data-title="Japan">Japan</option>

                    <option value='Kenya' data-imagecss="flag ke" data-title="Kenya">Kenya</option>

                    <option value='Kyrgyzstan' data-imagecss="flag kg" data-title="Kyrgyzstan">Kyrgyzstan</option>

                    <option value='Cambodia' data-imagecss="flag kh" data-title="Cambodia">Cambodia</option>

                    <option value='Kiribati' data-imagecss="flag ki" data-title="Kiribati">Kiribati</option>

                    <option value='Comoros' data-imagecss="flag km" data-title="Comoros">Comoros</option>

                    <option value='Saint Kitts and Nevis' data-imagecss="flag kn" data-title="Saint Kitts and Nevis">Saint Kitts and Nevis</option>

                    <option value='Korea (North)' data-imagecss="flag kp" data-title="Korea (North)">Korea (North)</option>

                    <option value='Korea (South)' data-imagecss="flag kr" data-title="Korea (South)">Korea (South)</option>

                    <option value='Kuwait' data-imagecss="flag kw" data-title="Kuwait">Kuwait</option>

                    <option value='Cayman Islands' data-imagecss="flag ky" data-title="Cayman Islands">Cayman Islands</option>

                    <option value='Kazakhstan' data-imagecss="flag kz" data-title="Kazakhstan">Kazakhstan</option>

                    <option value='Laos' data-imagecss="flag la" data-title="Laos">Laos</option>

                    <option value='Lebanon' data-imagecss="flag lb" data-title="Lebanon">Lebanon</option>

                    <option value='Saint Lucia' data-imagecss="flag lc" data-title="Saint Lucia">Saint Lucia</option>

                    <option value='Liechtenstein' data-imagecss="flag li" data-title="Liechtenstein">Liechtenstein</option>

                    <option value='Sri Lanka' data-imagecss="flag lk" data-title="Sri Lanka">Sri Lanka</option>

                    <option value='Liberia' data-imagecss="flag lr" data-title="Liberia">Liberia</option>

                    <option value='Lesotho' data-imagecss="flag ls" data-title="Lesotho">Lesotho</option>

                    <option value='Lithuania' data-imagecss="flag lt" data-title="Lithuania">Lithuania</option>

                    <option value='Luxembourg' data-imagecss="flag lu" data-title="Luxembourg">Luxembourg</option>

                    <option value='Latvia' data-imagecss="flag lv" data-title="Latvia">Latvia</option>

                    <option value='Libya' data-imagecss="flag ly" data-title="Libya">Libya</option>

                    <option value='Morocco' data-imagecss="flag ma" data-title="Morocco">Morocco</option>

                    <option value='Monaco' data-imagecss="flag mc" data-title="Monaco">Monaco</option>

                    <option value='Moldova' data-imagecss="flag md" data-title="Moldova">Moldova</option>

                    <option value='Madagascar' data-imagecss="flag mg" data-title="Madagascar">Madagascar</option>

                    <option value='Marshall Islands' data-imagecss="flag mh" data-title="Marshall Islands">Marshall Islands</option>

                    <option value='Macedonia' data-imagecss="flag mk" data-title="Macedonia">Macedonia</option>

                    <option value='Mali' data-imagecss="flag ml" data-title="Mali">Mali</option>

                    <option value='Myanmar' data-imagecss="flag mm" data-title="Myanmar">Myanmar</option>

                    <option value='Mongolia' data-imagecss="flag mn" data-title="Mongolia">Mongolia</option>

                    <option value='Macao' data-imagecss="flag mo" data-title="Macao">Macao</option>

                    <option value='Northern Mariana Islands' data-imagecss="flag mp" data-title="Northern Mariana Islands">Northern Mariana Islands</option>

                    <option value='Martinique' data-imagecss="flag mq" data-title="Martinique">Martinique</option>

                    <option value='Mauritania' data-imagecss="flag mr" data-title="Mauritania">Mauritania</option>

                    <option value='Montserrat' data-imagecss="flag ms" data-title="Montserrat">Montserrat</option>

                    <option value='Malta' data-imagecss="flag mt" data-title="Malta">Malta</option>

                    <option value='Mauritius' data-imagecss="flag mu" data-title="Mauritius">Mauritius</option>

                    <option value='Maldives' data-imagecss="flag mv" data-title="Maldives">Maldives</option>

                    <option value='Malawi' data-imagecss="flag mw" data-title="Malawi">Malawi</option>

                    <option value='Mexico' data-imagecss="flag mx" data-title="Mexico">Mexico</option>

                    <option value='Malaysia' data-imagecss="flag my" data-title="Malaysia">Malaysia</option>

                    <option value='Mozambique' data-imagecss="flag mz" data-title="Mozambique">Mozambique</option>

                    <option value='Namibia' data-imagecss="flag na" data-title="Namibia">Namibia</option>

                    <option value='New Caledonia' data-imagecss="flag nc" data-title="New Caledonia">New Caledonia</option>

                    <option value='Niger' data-imagecss="flag ne" data-title="Niger">Niger</option>

                    <option value='Norfolk Island' data-imagecss="flag nf" data-title="Norfolk Island">Norfolk Island</option>

                    <option value='Nigeria' data-imagecss="flag ng" data-title="Nigeria">Nigeria</option>

                    <option value='Nicaragua' data-imagecss="flag ni" data-title="Nicaragua">Nicaragua</option>

                    <option value='Netherlands' data-imagecss="flag nl" data-title="Netherlands">Netherlands</option>

                    <option value='Norway' data-imagecss="flag no" data-title="Norway">Norway</option>

                    <option value='Nepal' data-imagecss="flag np" data-title="Nepal">Nepal</option>

                    <option value='Nauru' data-imagecss="flag nr" data-title="Nauru">Nauru</option>

                    <option value='Niue' data-imagecss="flag nu" data-title="Niue">Niue</option>

                    <option value='New Zealand (Aotearoa)' data-imagecss="flag nz" data-title="New Zealand (Aotearoa)">New Zealand (Aotearoa)</option>

                    <option value='Oman' data-imagecss="flag om" data-title="Oman">Oman</option>

                    <option value='Panama' data-imagecss="flag pa" data-title="Panama">Panama</option>

                    <option value='Peru' data-imagecss="flag pe" data-title="Peru">Peru</option>

                    <option value='French Polynesia' data-imagecss="flag pf" data-title="French Polynesia">French Polynesia</option>

                    <option value='Papua New Guinea' data-imagecss="flag pg" data-title="Papua New Guinea">Papua New Guinea</option>

                    <option value='Philippines' data-imagecss="flag ph" data-title="Philippines">Philippines</option>

                    <option value='Pakistan' data-imagecss="flag pk" data-title="Pakistan">Pakistan</option>

                    <option value='Poland' data-imagecss="flag pl" data-title="Poland">Poland</option>

                    <option value='Saint Pierre and Miquelon' data-imagecss="flag pm" data-title="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>

                    <option value='Pitcairn' data-imagecss="flag pn" data-title="Pitcairn">Pitcairn</option>

                    <option value='Puerto Rico' data-imagecss="flag pr" data-title="Puerto Rico">Puerto Rico</option>

                    <option value='Palestinian Territory' data-imagecss="flag ps" data-title="Palestinian Territory">Palestinian Territory</option>

                    <option value='Portugal' data-imagecss="flag pt" data-title="Portugal">Portugal</option>

                    <option value='Palau' data-imagecss="flag pw" data-title="Palau">Palau</option>

                    <option value='Paraguay' data-imagecss="flag py" data-title="Paraguay">Paraguay</option>

                    <option value='Qatar' data-imagecss="flag qa" data-title="Qatar">Qatar</option>

                    <option value='Reunion' data-imagecss="flag re" data-title="Reunion">Reunion</option>

                    <option value='Romania' data-imagecss="flag ro" data-title="Romania">Romania</option>

                    <option value='Russian Federation' data-imagecss="flag ru" data-title="Russian Federation">Russian Federation</option>

                    <option value='Rwanda' data-imagecss="flag rw" data-title="Rwanda">Rwanda</option>

                    <option value='Saudi Arabia' data-imagecss="flag sa" data-title="Saudi Arabia">Saudi Arabia</option>

                    <option value='Solomon Islands' data-imagecss="flag sb" data-title="Solomon Islands">Solomon Islands</option>

                    <option value='Seychelles' data-imagecss="flag sc" data-title="Seychelles">Seychelles</option>

                    <option value='Sudan' data-imagecss="flag sd" data-title="Sudan">Sudan</option>

                    <option value='Sweden' data-imagecss="flag se" data-title="Sweden">Sweden</option>

                    <option value='Singapore' data-imagecss="flag sg" data-title="Singapore">Singapore</option>

                    <option value='Saint Helena' data-imagecss="flag sh" data-title="Saint Helena">Saint Helena</option>

                    <option value='Slovenia' data-imagecss="flag si" data-title="Slovenia">Slovenia</option>

                    <option value='Svalbard and Jan Mayen' data-imagecss="flag sj" data-title="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>

                    <option value='Slovakia' data-imagecss="flag sk" data-title="Slovakia">Slovakia</option>

                    <option value='Sierra Leone' data-imagecss="flag sl" data-title="Sierra Leone">Sierra Leone</option>

                    <option value='San Marino' data-imagecss="flag sm" data-title="San Marino">San Marino</option>

                    <option value='Senegal' data-imagecss="flag sn" data-title="Senegal">Senegal</option>

                    <option value='Somalia' data-imagecss="flag so" data-title="Somalia">Somalia</option>

                    <option value='Suriname' data-imagecss="flag sr" data-title="Suriname">Suriname</option>

                    <option value='Sao Tome and Principe' data-imagecss="flag st" data-title="Sao Tome and Principe">Sao Tome and Principe</option>

                    <option value='USSR (former)' data-imagecss="flag su" data-title="USSR (former)">USSR (former)</option>

                    <option value='El Salvador' data-imagecss="flag sv" data-title="El Salvador">El Salvador</option>

                    <option value='Syria' data-imagecss="flag sy" data-title="Syria">Syria</option>

                    <option value='Swaziland' data-imagecss="flag sz" data-title="Swaziland">Swaziland</option>

                    <option value='Turks and Caicos Islands' data-imagecss="flag tc" data-title="Turks and Caicos Islands">Turks and Caicos Islands</option>

                    <option value='Chad' data-imagecss="flag td" data-title="Chad">Chad</option>

                    <option value='French Southern Territories' data-imagecss="flag tf" data-title="French Southern Territories">French Southern Territories</option>

                    <option value='Togo' data-imagecss="flag tg" data-title="Togo">Togo</option>

                    <option value='Thailand' data-imagecss="flag th" data-title="Thailand">Thailand</option>

                    <option value='Tajikistan' data-imagecss="flag tj" data-title="Tajikistan">Tajikistan</option>

                    <option value='Tokelau' data-imagecss="flag tk" data-title="Tokelau">Tokelau</option>

                    <option value='Timor-Leste' data-imagecss="flag tl" data-title="Timor-Leste">Timor-Leste</option>

                    <option value='Turkmenistan' data-imagecss="flag tm" data-title="Turkmenistan">Turkmenistan</option>

                    <option value='Tunisia' data-imagecss="flag tn" data-title="Tunisia">Tunisia</option>

                    <option value='Tonga' data-imagecss="flag to" data-title="Tonga">Tonga</option>

                    <option value='East Timor' data-imagecss="flag tp" data-title="East Timor">East Timor</option>

                    <option value='Turkey' data-imagecss="flag tr" data-title="Turkey">Turkey</option>

                    <option value='Trinidad and Tobago' data-imagecss="flag tt" data-title="Trinidad and Tobago">Trinidad and Tobago</option>

                    <option value='Tuvalu' data-imagecss="flag tv" data-title="Tuvalu">Tuvalu</option>

                    <option value='Taiwan' data-imagecss="flag tw" data-title="Taiwan">Taiwan</option>

                    <option value='Tanzania' data-imagecss="flag tz" data-title="Tanzania">Tanzania</option>

                    <option value='Ukraine' data-imagecss="flag ua" data-title="Ukraine">Ukraine</option>

                    <option value='Uganda' data-imagecss="flag ug" data-title="Uganda">Uganda</option>

                    <option value='United Kingdom' data-imagecss="flag uk" data-title="United Kingdom">United Kingdom</option>

                    <option value='United States Minor Outlying Islands' data-imagecss="flag um" data-title="United States Minor Outlying Islands">United States Minor Outlying Islands</option>

                    <option value='Uruguay' data-imagecss="flag uy" data-title="Uruguay">Uruguay</option>

                    <option value='Uzbekistan' data-imagecss="flag uz" data-title="Uzbekistan">Uzbekistan</option>

                    <option value='Vatican City State (Holy See)' data-imagecss="flag va" data-title="Vatican City State (Holy See)">Vatican City State (Holy See)</option>

                    <option value='Saint Vincent and the Grenadines' data-imagecss="flag vc" data-title="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>

                    <option value='Venezuela' data-imagecss="flag ve" data-title="Venezuela">Venezuela</option>

                    <option value='Virgin Islands (British)' data-imagecss="flag vg" data-title="Virgin Islands (British)">Virgin Islands (British)</option>

                    <option value='Virgin Islands (U.S.)' data-imagecss="flag vi" data-title="Virgin Islands (U.S.)">Virgin Islands (U.S.)</option>

                    <option value='Viet Nam' data-imagecss="flag vn" data-title="Viet Nam">Viet Nam</option>

                    <option value='Vanuatu' data-imagecss="flag vu" data-title="Vanuatu">Vanuatu</option>

                    <option value='Wallis and Futuna' data-imagecss="flag wf" data-title="Wallis and Futuna">Wallis and Futuna</option>

                    <option value='Samoa' data-imagecss="flag ws" data-title="Samoa">Samoa</option>

                    <option value='Yemen' data-imagecss="flag ye" data-title="Yemen">Yemen</option>

                    <option value='Mayotte' data-imagecss="flag yt" data-title="Mayotte">Mayotte</option>

                    <option value='Yugoslavia (former)' data-imagecss="flag yu" data-title="Yugoslavia (former)">Yugoslavia (former)</option>

                    <option value='South Africa' data-imagecss="flag za" data-title="South Africa">South Africa</option>

                    <option value='Zambia' data-imagecss="flag zm" data-title="Zambia">Zambia</option>

                    <option value='Zaire (former)' data-imagecss="flag zr" data-title="Zaire (former)">Zaire (former)</option>

                    <option value='Zimbabwe' data-imagecss="flag zw" data-title="Zimbabwe">Zimbabwe</option>

                </select>

			</div>


			<div id="primary_destination_State_div">


				<div class="col-md-12" style="padding:0;">
					<label>Primary destination in Canada</label>	
					<select name="primary_destination_State" class="form-control form-select" id="primary_destination_State" autocomplete="off" required>

						<option value=""> --- Please choose ---</option>

						<option value="Alberta">Alberta</option>

						<option value="British Columbia">British Columbia</option>

						<option value="Manitoba">Manitoba</option>

						<option value="New Brunswick">New Brunswick</option>

						<option value="Newfoundland">Newfoundland</option>

						<option value="North West Territories">North West Territories</option>

						<option value="Nova Scotia">Nova Scotia</option>

						<option value="Nunavut">Nunavut</option>

						<option value="Ontario" selected>Ontario</option>

						<option value="Prince Edward Island">Prince Edward Island</option>

						<option value="Quebec">Quebec</option>

						<option value="Saskatchewan">Saskatchewan</option>

						<option value="Yukon Territory">Yukon Territory</option>

					</select>

				</div>

			</div>


			<div id="do_you_smoke">
				<div class="col-md-12 " style="padding:0;">
				<label>Do you Smoke ?</label>
					<select name="primary_destination_State" class="form-control form-select" id="primary_destination_State" autocomplete="off" required>
						<option value=""> --- Please choose ---</option>
						<option value="yes">Yes</option>
						<option value="no">No</option>
					</select>
				</div>
			</div>


			

			<div id="usa_stop_div" style="display:none;">
				<div class="col-md-12" style="padding:0;">
<label> Any stop-over in the US?</label>
				<select name="usa_stop" id="usa_stop" aria-invalid="false" class="form-control" required>
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


	        <?php } else {  ?>

        <div class="col-md-12" style="padding:0;">
<label> Primary destination in Canada </label> 
        <select name="primary_destination" class="form-control" id="primary_destination" autocomplete="off" required>

            <option value=""> --- Please choose ---</option>

            <option value="Alberta" selected="">Alberta</option>

            <option value="British Columbia">British Columbia</option>

            <option value="Manitoba">Manitoba</option>

            <option value="New Brunswick">New Brunswick</option>

            <option value="Newfoundland">Newfoundland</option>

            <option value="North West Territories">North West Territories</option>

            <option value="Nova Scotia">Nova Scotia</option>

            <option value="Nunavut">Nunavut</option>

            <option value="Ontario" selected>Ontario</option>

            <option value="Prince Edward Island">Prince Edward Island</option>

            <option value="Quebec">Quebec</option>

            <option value="Saskatchewan">Saskatchewan</option>

            <option value="Yukon Territory">Yukon Territory</option>

        </select>

     </div>


<?php } ?>
</div>
<?php } ?>


        <!-- Destination ends -->


<?php if($allow_input_field['sdate'] == "on" && $allow_input_field['edate'] == "on"){ ?>
<div class="col-md-6" style="margin-bottom: 10px;">
<label>Start date of coverage</label>
<input  id="departure_date"  name="departure_date" value="<?php echo $_SESSION['departure_date'];?>" class="form-control <?php if($mobile == 'no'){?> datepicker <?php } ?>"  type="<?php if($mobile == 'yes'){ echo 'date'; } else { echo 'text'; } ?>" placeholder="Start Date" required <?php if($supervisa == 'yes'){?> onchange="supervisayes()" <?php } else { ?> onchange="checknumtravellers()" <?php } ?>>
			<label for="departure_date" style="z-index: 999;padding: 11px 11px !important;position: absolute;top: 28px;right: 17px;background: #F1F1F1;border-radius: 0px 5px 5px 0;">
				<i class="fa fa-calendar" aria-hidden="true"></i>
			</label>
			
					<script>
						$('#departure_date').datepicker({
						format: 'yyyy-mm-dd',
						todayHighlight:'TRUE',
						autoclose: true,
						});
					</script>
</div>
<div class="col-md-6" style="margin-bottom: 10px;">
<label>End date of coverage</label>
<input  id="return_date"  name="return_date" value="<?php echo $_SESSION['return_date'];?>" class="form-control <?php if($mobile == 'no' && $supervisa == 'no'){?> datepicker <?php } ?>"  type="<?php if($mobile == 'yes'){ echo 'date'; } else { echo 'text'; } ?>" placeholder="End Date" required <?php if($supervisa == 'yes'){?> readonly="true" <?php } ?>>
			<label for="return_date" style="z-index: 999;padding: 11px 11px !important;position: absolute;top: 28px;right: 17px;background: #F1F1F1;border-radius: 0px 5px 5px 0;">
				<i class="fa fa-calendar" aria-hidden="true"></i>
			</label>
			
					<?php if($supervisa == 'no'){?>
						<script>
							$('#return_date').datepicker({
							format: 'yyyy-mm-dd',
							todayHighlight:'TRUE',
							autoclose: true,
							});
						</script>
				<?php } ?>
</div>				
<?php } ?>
<?php if($allow_input_field['traveller'] == "on" ){
$number_of_travel = $allow_input_field['traveller_number'];
?>
<div class="col-md-12" style="margin-bottom: 10px;">
<label>Number of Travellers</label>
<select name="number_travelers" class="form-control form-select" id="number_travelers"  autocomplete="off" required onchange="checknumtravellers()">
	<option value="">Number of travellers</option>
	<?php for($t=1;$t<=$number_of_travel;$t++){ ?>
	<option value="<?php echo $t; ?>" <?php if($_SESSION['number_travelers'] == $t){?> selected="" <?php } else if($t == 1){ echo 'selected=""'; } ?> ><?php echo $t; ?></option>
	<?php } ?>
</select>
</div>							
<?php } ?>
<?php
if($allow_input_field['dob'] == "on" ){ 
?>
<div class="col-md-12">
<?php 
$ordinal_words = array('oldest', 'oldest', 'second', 'third', 'fourth', 'fifth', 'sixth', 'seventh', 'eighth');
$c = 0;
for($i=1;$i<=$number_of_travel;$i++){
	?>
<div class="row" id="traveller_<?php echo $i;?>" style="<?php if($i > 1){ echo 'display: none'; } ?>">
<label>Birth date of the <?php echo $ordinal_words[$i];?> Traveller</label>
<div class="col-md-12" style="margin-bottom: 10px; padding:0;">
<div class="date-wrapper question-answer">
						<input type="text" placeholder="DD" name="days[]" id="days_<?php echo $i;?>" value="<?php echo $_SESSION['days'][$c];?>" maxlength="2" class="numeric lpad2 day-holder">/
						<input type="text" placeholder="MM" name="months[]" id="months_<?php echo $i;?>" value="<?php echo $_SESSION['months'][$c];?>" maxlength="2" class="numeric lpad2 month-holder">/
						<select name="years[]" id="add_<?php echo $i;?>" class="numeric lpadyear year-holder" onchange="checknumtravellers()" style="box-shadow: none !important;border: 0 !important;width: 100%;">
						<option value="">Year</option>
<?php $maxyear = date('Y');
$j = $maxyear;
$year = date('Y');
if($supervisa == 'yes'){
$startfrom = '1918';
$j = date('Y') - 40;
} else {
$startfrom = '1918';
}
while($j>$startfrom) {?>
<option value="<?php echo $j;?>" <?php if($_SESSION['years'][$c] == $j){?> selected="" <?php } ?>><?php echo $j;?></option>
<?php if($j == 1984){?>
<option value="" <?php if($_SESSION['years'] == ''){?> selected="" <?php } ?>>Year</option>
<?php } ?>
<?php $j--; } ?>
</select>
</div>
</div>
<div class="clearfix"></div>
</div>
<input type="hidden" name="ages[]" id="age_<?php echo $i;?>" value="" />
<?php $c++; } ?>
</div>
<?php } ?>


</div>
</div>
<div class="row" style="margin-top:30px !important;opacity: 0.7;">
<div class="col-md-12 text-center"><button type="submit" class="btn btn-lg nextbtn">Continue <i class="fa fa-arrow-right"></i></button></div>
</div>
<div class="row" style="margin-top:30px !important;opacity: 0.7;">
<div class="col-md-12 text-center"><i class="fa fa-lock"></i> Your information is protected.</div>
</div>
</form>
<script type="text/javascript" src="admin/assets/js/moment.js"></script>
<script type="text/javascript" src="admin/assets/js/moment-with-locales.js"></script>
<script>
function checknumtravellers(){
	//Number OF Traveller
	var number_of_traveller = document.getElementById('number_travelers').value;
	
	for(var t=1; t<=number_of_traveller; t++){
		$("#traveller_"+t).hide();
		$('#age_'+t).val('');
	}
	//alert(number_of_traveller);
	for(var i=1; i<=number_of_traveller; i++){
	$("#traveller_"+i).show();
	document.getElementById('add_'+i).required = true;
	}
var startdate = document.getElementById('departure_date').value;	
for(var i=1; i<=number_of_traveller; i++){
var d = document.getElementById('days_'+i).value;
var m = document.getElementById('months_'+i).value;
var y = document.getElementById('add_'+i).value;
var dob = y + '-' + m + '-' + d;
//alert(dob);
dob = new Date(dob);
var today = new Date(startdate);
var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
$('#age_'+i).val(age);
}
p = 1;
pr = number_of_traveller + p;
for(var p = pr; p<=8; p++){
document.getElementById('days_'+p).value = '';
document.getElementById('months_'+p).value = '';
document.getElementById('add_'+p).value = '';
}

//checkfamilyplan();
}


var container = document.getElementsByClassName("birthdate")[0];
container.onkeyup = function(e) {
    var target = e.srcElement || e.target;
    var maxLength = parseInt(target.attributes["maxlength"].value, 10);
    var myLength = target.value.length;
    if (myLength >= maxLength) {
        var next = target;
        while (next = next.nextElementSibling) {
            if (next == null)
                break;
            if (next.tagName.toLowerCase() === "input") {
                next.focus();
                break;
            }
        }
    }
    // Move to previous field if empty (user pressed backspace)
    else if (myLength === 0) {
        var previous = target;
        while (previous = previous.previousElementSibling) {
            if (previous == null)
                break;
            if (previous.tagName.toLowerCase() === "input") {
                previous.focus();
                break;
            }
        }
    }
}

window.onload = function() {
  checknumtravellers();
};
</script>
<script type="text/javascript">var plugin_path = 'admin/assets/plugins/';</script>
<script type="text/javascript" src="admin/assets/plugins/jquery/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="admin/assets/js/app.js"></script>
