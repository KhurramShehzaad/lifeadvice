<?php
session_start();
include 'includes/db_connect.php';

/*cancel
paid
pending
return*/

//PURCHASE, CANCELLATION, EARLY_RETURN, and DATE_CHANGE
/*
$id = $_REQUEST['id'];
$query = mysqli_query($db, "SELECT * FROM `sales` WHERE `sales_id`='$id'");
$fetch = mysqli_fetch_assoc($query);
$sales_id = $fetch['sales_id'];
$purchase_date = $fetch['purchase_date'];
$policy_id = $fetch['policy_id'];
$policy_title = $fetch['policy_title'];
$fname = $fetch['fname'];
$lname = $fetch['lname'];
$email = $fetch['email'];
$phone = $fetch['phone'];
$address = $fetch['address'];
$address_2 = $fetch['address_2'];
$city = $fetch['city'];
$postcode = $fetch['postcode'];
$country = $fetch['country'];
$home_address = $fetch['home_address'];
$home_address_2 = $fetch['home_address_2'];
$home_city = $fetch['home_city'];
$home_province = $fetch['home_province'];
$home_zip = $fetch['home_zip'];
$billing_province = $fetch['billing_province'];
$home_country = $fetch['home_country'];
$pre_exe = $fetch['pre_exe'];
$deductible = $fetch['deductible'];
$deductible_rate = $fetch['deductible_rate'];
$benefit = $fetch['benefit'];
$duration = $fetch['duration'];
$age = $fetch['age'];
$product = $fetch['product'];
$trip_type = $fetch['trip_type'];
$plan = $fetch['plan'];
$trip_dest = $fetch['trip_dest'];
$supervisa = $fetch['supervisa'];
$tripcost = $fetch['tripcost'];
$dob = $fetch['dob'];
$start_date = $fetch['start_date'];
$end_date = $fetch['end_date'];
$cancel_date = $fetch['cancel_date'];
$departure_date = $fetch['departure_date'];
$arrival_date = $fetch['arrival_date'];
$return_date = $fetch['return_date'];
$smoking = $fetch['smoking'];
$province_id = $fetch['province'];
$number_of_travellers = $fetch['additional_travellers'] + 1;
$price = $fetch['price'];
$daily_price = $fetch['daily_price'];
$price_total = $fetch['price_total'];
$price_payable = $fetch['price_payable'];
$eligible = $fetch['eligible'];
$policy_number = $fetch['policy_number'];
$policy_type = $fetch['policy_type'];
$elder_age = $fetch['elder_age'];
$family_plan = $fetch['family_plan'];
$policy_status = $fetch['policy_status'];
$broker = $fetch['broker'];
$agent = $fetch['agent'];
$transaction_type = $fetch['transaction_type'];
$transaction_reason = $fetch['transaction_reason'];
$gross_comm_rate = $fetch['gross_comm_rate'];
$user_ip = $fetch['user_ip'];
$transaction_code = $fetch['transaction_code'];

if($policy_title == 'TrueNorth - Bronze'){
$insurance_plan = '1';	
}else if($policy_title == 'TrueNorth - Silver'){
$insurance_plan = '2';	
}else if($policy_title == 'TrueNorth - Gold'){
$insurance_plan = '3';	
}else if($policy_title == 'TrueNorth - Platinum'){
$insurance_plan = '4';	
}else if($policy_title == 'TrueNorth - Diamond'){
$insurance_plan = '5';	
}else if($policy_title == 'TrueNorth - Onyx'){
$insurance_plan = '6';	
}

if($transaction_code == 'CANCELLATION'){
$additional_fee = $fetch['additional_fee'];
$premium_adjustment = '0';
}else if($transaction_code == 'DATE_CHANGE_WITH_FINANCIAL_IMPACT'){
$additional_fee = $fetch['additional_fee'];
$premium_adjustment = $fetch['premium_adjustment'];
}else {
$additional_fee = '0';
$premium_adjustment = '0';	
}
$procinves_q = mysqli_query($db, "SELECT * FROM `provinces` WHERE `id`='".$province_id."'");
$procinves_f = mysqli_fetch_assoc($procinves_q);
$province = $procinves_f['prov_abbr'];

//CARD DETALLS
$cards_q = mysqli_query($db, "SELECT * FROM `sales_cards` WHERE `sales_id`='$sales_id'");
$cards_f = mysqli_fetch_assoc($cards_q);
$card_name = $cards_f['card_name'];
$cards_number = $cards_f['card_number'];
$billing_address = $cards_f['billing_address'];
$billing_address_2 = $cards_f['billing_address_2'];
$billing_province = $cards_f['billing_province'];
$billing_city = $cards_f['billing_city'];
$billing_zip = $cards_f['billing_zip'];
$billing_country = $cards_f['billing_country'];

$name_temp = explode(' ', $card_name);
$card_fname = $name_temp[0];
$card_lname = $name_temp[1].' '.$name_temp[2];


if($policy_status == 'paid'){
$transaction_type = 'PURCHASE';
}
else if($policy_status == 'return'){
$transaction_type = 'EARLY_RETURN';
$refund = $fetch['refund'];	
}
else if($policy_status == 'cancel'){
$transaction_type = 'CANCELLATION';	
$refund = $fetch['refund'];
} else {
$transaction_type = 'PURCHASE';
}


//SENDING CONFIRMATION
//SENDING REQUEST TO API

$array = array(
payor_first_name => $card_fname,
payor_last_name => $card_lname,
policy_type => '1',
number_of_travellers => $number_of_travellers,
payment_method => '1',
payment_identifier => '1',
payment_reference => '1',
canada_address_1 => $address,
canada_address_2 => $address_2,
city_in_canada => $city,
postal_code => $postcode,
province => $province,
mailing_or_billing_address_1 => $billing_address,
mailing_or_billing_address_2 => $billing_address_2,
mailing_or_billing_city => $billing_city,
mailing_or_billing_country => $billing_country,
mailing_or_billing_postal_or_zip_code => $billing_zip,
mailing_or_billing_province_or_state => $billing_province,
physical_address_1 => $home_address,
physical_address_2 => $home_address_2,
physical_city => $home_city,
physical_country => $home_country,
physical_province_or_state => $home_province,
physical_postal_or_zip_code => $home_zip,
fulfillment_email_address => $email,
change_flag => "0",
transaction_type => $transaction_type,
fulfillment_phone_number => $phone,
credit_card_reference => $cards_number
);

if($policy_status == 'return' || $policy_status == 'cancel'){
$array = array_merge($array, array(
refund => $refund,
));	
}

$comma = ',';	
$array = array_merge($array, array(
traveller_1_id => '1',
product_id_1 => '1',
policy_number_1 => $policy_number,
mailing_address_1_1 => $address,
mailing_address_2_1 => $address_2,
mailing_city_1 => $city,
mailing_country_1 => $country,
mailing_province_or_state_1 => $province,
mailing_postal_or_zip_code_1 => $postcode,
policy_holder_or_traveller_first_name_1 => $fname,
policy_holder_or_traveller_last_name_1 => $lname,
policy_holder_or_traveller_date_of_birth_1 => $dob,
effective_date_1 => $start_date,
expiry_date_1 => $end_date,
annual_days_1 => $duration,
arrival_or_departure_date_1 => $start_date,
return_date_1 => $end_date,
deductible_amount_1 => $deductible,
premium_amount_1 => $price,
amount_insured_1 => $benefit,
gender_1 => "Male",
additional_fee => $additional_fee,
premium_adjustment => $premium_adjustment,
insurance_plan_1 => $insurance_plan,
));

$b = 1;	
$addi_q = mysqli_query($db, "SELECT * FROM `sales` WHERE `parent_sales_id`='$sales_id' AND `eligible`='yes' ORDER BY `sales_id`");
$no_addi = mysqli_num_rows($addi_q);
while($addi_f = mysqli_fetch_assoc($addi_q)){
$b++;
if($b < $no_addi){
$addcomma = ',';	
}
else {
$addcomma = '';	
}

if($transaction_code == 'CANCELLATION'){
$additional_fee = $addi_f['additional_fee'];
$premium_adjustment = '0';
}else if($transaction_code == 'DATE_CHANGE_WITH_FINANCIAL_IMPACT'){
$additional_fee = $addi_f['additional_fee'];
$premium_adjustment = $addi_f['premium_adjustment'];
}else {
$additional_fee = '0';
$premium_adjustment = '0';	
}


$bno = $b;	

$array = array_merge($array, array(
traveller_.$bno._id => ''.$bno.'',
product_id_.$bno => '1',
policy_number_.$bno => $addi_f['policy_number'],
mailing_address_1_.$bno => $address,
mailing_address_2_.$bno => $address_2,
mailing_city_.$bno => $city,
mailing_country_.$bno => $country,
mailing_postal_or_zip_code_.$bno => $postcode,
mailing_province_or_state_.$bno => $province,
policy_holder_or_traveller_first_name_.$bno => $addi_f['fname'],
policy_holder_or_traveller_last_name_.$bno => $addi_f['lname'],
policy_holder_or_traveller_date_of_birth_.$bno => $addi_f['dob'],
effective_date_.$bno => $start_date,
expiry_date_.$bno => $end_date,
annual_days_.$bno => $duration,
arrival_or_departure_date_.$bno => $start_date,
return_date_.$bno => $end_date,
deductible_amount_.$bno => $addi_f['deductible'],
premium_amount_.$bno => $addi_f['price'],
amount_insured_.$bno => $benefit,
gender_.$bno => 'Male',
transaction_type => $transaction_type,
additional_fee => $additional_fee,
premium_adjustment => $premium_adjustment,
insurance_plan_.$bno => $insurance_plan
));
}

//print_r($array);exit;
$final = json_encode($array);
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api2.awaycare.ca/api/regenerate_fulfillment",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $final,
  CURLOPT_HTTPHEADER => array(
    "Accept: application/json",
    "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjgyMDdhNTk1NjU0YTQ4NzQ0YzFjOTAwZjBlZjUwNjc0NDMwZDczMTk0NzE1MmE5MzA1Y2U5ZGVhNjkyZWJlMDA3OWJiZDNmMDIyMmIzZjQyIn0.eyJhdWQiOiIxIiwianRpIjoiODIwN2E1OTU2NTRhNDg3NDRjMWM5MDBmMGVmNTA2NzQ0MzBkNzMxOTQ3MTUyYTkzMDVjZTlkZWE2OTJlYmUwMDc5YmJkM2YwMjIyYjNmNDIiLCJpYXQiOjE1MjcxNjU5MjQsIm5iZiI6MTUyNzE2NTkyNCwiZXhwIjoxNTU4NzAxOTI0LCJzdWIiOiIzIiwic2NvcGVzIjpbXX0.IXtTmct8bLJ7FxiAsHZ70goo0Vok0tZC7tEHlfwgtVty4SY6NNypcD6bp05pvHuZoWhGhU7dqmUFI_RnNbJxgms0gj3Lav_TkNGIh9uo7pLtOc9FomJHmjKNlUDdVWfWB2h83f_rxBNwdUVkUXuGslF6jtZ2OHfojbexUYaXRr3bO8tGYfkreXkkJs24-KqHiApUgSr_-LZFSYzUWntUt3SuknD1m8kwS7O_hrS1ooS26JR4ImBmTXeWtQSmoor9x_cOj8FxyRaSX9ffd4ev4ubRskCx7oLT8hVaq91hQUOt2YTMME12A6T-fvbq3Ss6JOWS6cL_uukvID89NBh-IdgCYv7DRHXJQTBptqQI-REcS31T837LBOvb4J1ZlyFhWAvV_ytR0bXhT0x3GjZP7KbVecoJTF0OM1OMZ8TW-sSyzYmMkEr-irF1gPQspzHVCD30__tuKn9hbkKMOWeXP9t56nqTCJSMVNmZO3RqyCMWoOknO1OX1UaIT1xcz2HOx9wQ9r_3aLuaEIaKLu5v1t6ZHKZhOn0bFJ5z3ARaSIjt827IihZTcCw7pYNuy-hX4kzZo9HQOMvv4oU9Ki64xj7aU3WjR_8jKI9GfRJyd7zcr9sSYYXUQm9o9r0AdjyIzM7yv9DhgxCnEtIcg0l0yLU96EPCXHdzdGw-HlNtUog",
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);
*/


/*if ($err) {
  echo "cURL Error #:" . $err;
} else {
//header('Content-Type: application/pdf');
echo   $response;
}*/
//////////////ENDED CALLING API AND REQUESTING///////////////
?>
<!--
<h5 style="font-family:Arial, Helvetica, sans-serif; font-size:16px;">Record Updated</h5>
<h5 style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#00CC00;">Confirmation Sent</h5>-->
<script>window.location='sales_view.php?id=<?php echo $_REQUEST['id'];?>';</script>