<?php
include 'includes/db_connect.php';
if($_REQUEST['action'] == 'info'){
$_SESSION['years'] = $_POST['years'];
$_SESSION['postcode'] = $_POST['postcode'];
$_SESSION['smoke'] = $_POST['smoke'];
$_SESSION['gender'] = $_POST['gender'];
$_SESSION['fname'] = $_POST['fname'];
$_SESSION['lname'] = $_POST['lname'];
$_SESSION['savers_email'] = $_POST['savers_email'];
$_SESSION['phone'] = $_POST['phone'];
echo "<script>window.location='life_coverage.php';</script>";
}
if($_REQUEST['action'] == 'coverage'){
$_SESSION['sum_insured2'] = $_POST['sum_insured2'];
$_SESSION['duration'] = $_POST['duration'];
echo "<script>window.location='life_quotes.php';</script>";	
}
?>
