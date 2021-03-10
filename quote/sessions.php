<?php
include 'includes/db_connect.php';
if($_REQUEST['action'] == 'info'){
$_SESSION['sum_insured2'] = $_POST['sum_insured2'];
$_SESSION['departure_date'] = $_POST['departure_date'];
$_SESSION['return_date'] = $_POST['return_date'];
$_SESSION['number_travelers'] = $_POST['number_travelers'];
$_SESSION['years'] = ''; // this is to reset array
$_SESSION['years'] = $_POST['ages']; //$_POST['years'];
$_SESSION['months'] = $_POST['months'];
$_SESSION['days'] = $_POST['days'];
$_SESSION['fname'] = $_POST['fname'];
$_SESSION['lname'] = $_POST['lname'];
$_SESSION['savers_email'] = $_POST['savers_email'];
$_SESSION['primary_destination'] = $_POST['primary_destination'];
$_SESSION['primary_destination_State'] = $_POST['primary_destination_State'];
$_SESSION['usa_stop'] = $_POST['usa_stop'];
$_SESSION['phone'] = $_POST['phone'];
$_SESSION['traveller_gender'] = $_POST['traveller_gender'];
$_SESSION['gender'] = $_POST['gender'];
$_SESSION['traveller_Smoke'] = $_POST['traveller_Smoke'];
$_SESSION['old_traveller_gender'] = $_POST['old_traveller_gender'];
if($_POST['skip_coverage'] == 'yes'){ // This is in case layout 3 is selected.
$_SESSION['Smoke12'] = $_POST['Smoke12'];
$_SESSION['pre_existing'] = $_POST['pre_existing'];
$_SESSION['familyplan_temp'] = $_POST['familyplan_temp'];
echo "<script>window.location='tab_quotes.php';</script>";
} else {
echo "<script>window.location='tab_coverage.php';</script>";
}

}
if($_REQUEST['action'] == 'coverage'){
$_SESSION['Smoke12'] = $_POST['Smoke12'];
$_SESSION['pre_existing'] = $_POST['pre_existing'];
$_SESSION['familyplan_temp'] = $_POST['familyplan_temp'];
echo "<script>window.location='tab_quotes.php';</script>";
}

if($_REQUEST['product_id']){
$_SESSION['product_id'] = $_REQUEST['product_id'];
$_SESSION['sum_insured2'] = '';
$_SESSION['departure_date'] = '';
$_SESSION['return_date'] = '';
$_SESSION['number_travelers'] = '';
$_SESSION['years'] = '';
$_SESSION['months'] = '';
$_SESSION['days'] = '';
$_SESSION['fname'] = '';
$_SESSION['lname'] = '';
$_SESSION['savers_email'] = '';
$_SESSION['primary_destination'] = '';
$_SESSION['primary_destination_State'] = '';
$_SESSION['usa_stop'] = '';
$_SESSION['phone'] = '';
$_SESSION['traveller_gender'] = '';
$_SESSION['gender'] = '';
$_SESSION['traveller_Smoke'] = '';
$_SESSION['old_traveller_gender'] = '';
$_SESSION['Smoke12'] = '';
$_SESSION['pre_existing'] = '';
$_SESSION['familyplan_temp'] = '';
echo "<script>window.location='tab_info.php';</script>";	
}
?>
