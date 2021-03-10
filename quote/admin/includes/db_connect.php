<?php
error_reporting(0);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
$db = mysqli_connect("localhost","lifea026_php","lifea026_php@786","lifea026_php");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
 
if($_SESSION['id']){
//if logged in
$sess_q = mysqli_query($db, "SELECT * FROM `users` WHERE `id`='".$_SESSION['id']."'");
$sess_f = mysqli_fetch_assoc($sess_q);

$sess_id = $sess_f['id'];
$sess_user_pic = $sess_f['user_pic'];
$sess_fname = $sess_f['fname'];
$sess_lname = $sess_f['lname'];
$sess_email = $sess_f['email'];
$sess_phone = $sess_f['phone'];
$sess_username = $sess_f['username'];
$sess_password = $sess_f['password'];
$sess_address = $sess_f['address'];
$sess_province = $sess_f['province'];
$sess_city = $sess_f['city'];
$sess_country = $sess_f['country'];
$sess_postal = $sess_f['postal'];
$sess_user_type = $sess_f['user_type'];
$sess_parent_id = $sess_f['parent_id'];
$sess_status = $sess_f['status'];
$sess_commission_rate = $sess_f['commission_rate'];
$sess_passkey = $sess_f['passkey'];
$sess_unique_code = $sess_f['unique_code'];
$sess_join_date = $sess_f['join_date'];
$sess_user_pic = $sess_f['user_pic'];
$sess_user_level = $sess_f['user_level'];
$sess_dob = $sess_f['dob'];
$sess_about_me = $sess_f['about_me'];
$sess_facebook = $sess_f['facebook'];
$sess_twitter = $sess_f['twitter'];
$sess_pay_commission = $sess_f['pay_commission'];
$sess_mg_capability = $sess_f['mg_capability'];
$sess_fiscal_year = $sess_f['fiscal_year'];
} 
?>