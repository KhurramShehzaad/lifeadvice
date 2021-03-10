<?php
error_reporting(E_ALL);
session_start();
include 'includes/db_connect.php';
//$con is BMS database
//$db1 is site database
if (isset($_SESSION['user'])) {
} else {
echo "<script>
window.location='index.php?session=out';
</script>";
}
if($_REQUEST['action'] == 'add'){
$pro_name = $_POST['pro_name'];
$pro_parent = $_POST['pro_parent'];
$pro_supervisa = $_POST['pro_supervisa'];
$pro_life = $_POST['pro_life'];
$pro_travel_destination = $_POST['destinationtype'];
$pro_url = $_POST['pro_url'];
$prod_fields = serialize($_POST['prod']);

$sort_orders = array();
$orderlist = explode(',' , $_POST['savesortlist']);    
$i = 1;
foreach($orderlist as  $order)
{
$sort_orders[$i] = $order ;
$i++;
}
$sort_orders =  serialize($sort_orders);

$q = mysqli_query($db, "INSERT INTO `wp_dh_products`(`pro_name`, `pro_parent`, `pro_supervisa`, `pro_life`, `pro_fields`, `pro_sort`, `pro_travel_destination`, `pro_url`) VALUES ('$pro_name','$pro_parent','$pro_supervisa','$pro_life','$prod_fields','$sort_orders','$pro_travel_destination', '$pro_url')");

echo "<script>window.location='products.php';</script>";
}
else if($_REQUEST['action'] == 'update'){
$pro_name = $_POST['pro_name'];
$pro_parent = $_POST['pro_parent'];
$pro_supervisa = $_POST['pro_supervisa'];
$pro_life = $_POST['pro_life'];
$pro_travel_destination = $_POST['destinationtype'];
$pro_url = $_POST['pro_url'];
$prod_fields = serialize($_POST['prod']);

$sort_orders = array();
$orderlist = explode(',' , $_POST['savesortlist']);    
$i = 1;
foreach($orderlist as  $order)
{
$sort_orders[$i] = $order ;
$i++;
}
$sort_orders =  serialize($sort_orders);
$update_id = $_POST['update_id'];

$query = mysqli_query($db, "UPDATE `wp_dh_products` SET `pro_name`='$pro_name',`pro_parent`='$pro_parent',`pro_supervisa`='$pro_supervisa',`pro_life`='$pro_life',`pro_fields`='$prod_fields',`pro_sort`='$sort_orders',`pro_travel_destination`='$pro_travel_destination',`pro_url`='$pro_url' WHERE `pro_id`='$update_id'");

echo "<script>window.location='products.php';</script>";	
}
?>

<!doctype html>
<html lang="en-US">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Manage Product</title>
		<meta name="description" content="" />
		<meta name="Author" content="" />
		<!-- mobile settings -->
		<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />
		<!-- WEB FONTS -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&amp;subset=latin,latin-ext,cyrillic,cyrillic-ext" rel="stylesheet" type="text/css" />
		<!-- CORE CSS -->
		<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<!-- THEME CSS -->
		<link href="assets/css/essentials.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/layout.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/color_scheme/green.css" rel="stylesheet" type="text/css" id="color_scheme" />
		<!-- PAGE LEVEL STYLES -->
		<link href="assets/css/layout-datatables.css" rel="stylesheet" type="text/css" />
<style>
#middle div.panel-heading {
color: #1E252D !important;
height: auto !important;
background: #DEDEDE !important;
border-bottom: 2px solid #CCC !important;
}
.design-select {
float: left;
margin-right: 7px;
border: 2px solid #F9F9F9;
cursor: pointer;
width:11.5%;
}
.design-select img {
	width:100%;
}
.selected {
border: 2px solid #245580;	
}
</style>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <style>
  #sortable { list-style-type: none; margin: 0; padding: 0; }
  #sortable li { margin: 0 5px 5px 5px; padding: 5px; }
  .ui-state-highlight { height: 1.5em; line-height: 1.2em; }
  </style>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>

$( function() {
   var $sortable =   $( "#sortable, #sortable2" ).sortable({
	  connectWith: ".connectedSortable",
	update: function(event, ui) {
			var counter = 1;
			$('li', $sortable).each(function() {
				$(this).attr('position', counter);
				 $(this).find("input[name='sort[]']").val(counter);
				counter++;
			});
	}
	}).disableSelection();
  } );
  </script>
	</head>
	<!--
		.boxed = boxed version
	-->
	<body>
		<!-- WRAPPER -->
		<div id="wrapper">
			<!-- 
				ASIDE 
				Keep it outside of #wrapper (responsive purpose)
			-->
			<?php include 'sidebar.php'; ?>
			<!-- /ASIDE -->
			<!-- HEADER -->
			<?php include 'header.php'; ?>
			<!-- /HEADER -->
			<!-- 
				MIDDLE 
			-->
			<section id="middle">
				<!-- page title -->
				<header id="page-header">
					<h1>Manage Product</h1>
					<ol class="breadcrumb">
						<li><a href="products.php">Products</a></li>
						<li class="active">Manage Product</li>
					</ol>
				</header>
				<!-- /page title -->

				<div id="content" class="padding-20">
					<!-- 
						PANEL CLASSES:
							panel-default
							panel-danger
							panel-warning
							panel-info
							panel-success
						INFO: 	panel collapse - stored on user localStorage (handled by app.js _panels() function).
								All pannels should have an unique ID or the panel collapse status will not be stored!
					-->
<?php
$page_q = mysqli_query($db, "SELECT * FROM `wp_dh_products` WHERE `pro_id`='".$_REQUEST['id']."'");
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
$pro_life = $fetch['pro_life'];
$pro_fields = unserialize($fetch['pro_fields']);
$form_layout = $pro_fields['form_layout'];
$price_layout = $pro_fields['price_layout'];
$pro_sort  = unserialize($fetch['pro_sort']);
$pro_travel_destination = $fetch['pro_travel_destination'];
$pro_url = $fetch['pro_url'];		
?>
<form method="post" action="?action=<?php if($_REQUEST['id']){ echo 'update'; } else { echo 'add'; }?>" id="productform" enctype="multipart/form-data">
					<div class="panel panel-default col-md-8" style="padding:0;">
							<!--<div class="panel-heading panel-heading-transparent">
							<strong>Enter Product Details</strong>
							</div>-->
                        <div class="panel-body">
							<div class="row">
									<div class="col-md-12">
										<h4 class="text-primary" style="margin:0;"><strong><i class="fa fa-umbrella"></i> Enter Product Details</strong></h4>
                                    </div>
							</div>
                            <div class="row">
									<div class="col-md-6" style="padding:0;">
									<div class="col-md-12">
                                    <label><strong>Supervisa Product ?</strong> <small>(Is this super visa product ?)</small></label>
                                    </div>
									<div class="col-md-12">
                                    <label class="switch switch-success switch-round">
										<input type="checkbox" name="pro_supervisa" id="pro_supervisa" value="1" <?php if($pro_supervisa == '1'){?> checked="" <?php } ?>>
										<span class="switch-label" data-on="YES" data-off="NO"></span>
									</label>
                                    </div>
									</div>
									<div class="col-md-6">
									<div class="col-md-12">
                                    <label><strong>Life Insurance Product ?</strong> <small>(Is this life insurance product ?)</small></label>
                                    </div>
									<div class="col-md-12">
                                    <label class="switch switch-success switch-round">
										<input type="checkbox" name="pro_life" id="pro_life" value="1" <?php if($pro_life == '1'){?> checked="" <?php } ?>>
										<span class="switch-label" data-on="YES" data-off="NO"></span>
									</label>
                                    </div>
									</div>
							</div>
							<div class="row">		
                                    <div class="col-md-12">
                                    <label><strong>Product Name <span class="text-danger">*</span></strong></label>
                                    <!-- date picker -->
                                    <input class="form-control" type="text" id="pro_name" name="pro_name" placeholder="Enter product name" value="<?php echo $pro_name;?>" />
                                    </div>
                             </div>
							 <div class="row">		
                                    <div class="col-md-12">
                                    <label><strong>Parent Product <small>(optional)</small></strong></label>
                                    </div>
									<div class="col-md-12">
									<div class="fancy-form fancy-form-select">
										<select class="form-control" name="pro_parent" id="pro_parent">
											<option value="">--- None ---</option>
											<?php
											$p_q = mysqli_query($db, "SELECT * FROM `wp_dh_products`");
											while($p_f = mysqli_fetch_assoc($p_q)){
											?>
											<option <?php if($pro_parent == $p_f['pro_id']){?> selected <?php } ?> value="<?php echo $p_f['pro_id'];?>"><?php echo $p_f['pro_name'];?></option>
											<?php } ?>
										</select>
										<i class="fancy-arrow"></i>
									</div>
									</div>
                             </div>
							 <div class="row">		
                                    <div class="col-md-12">
                                    <label><strong>Product Buynow URL <span class="text-danger">*</span></strong></label>
                                    <!-- date picker -->
                                    <input class="form-control" type="text" id="pro_url" name="pro_url" placeholder="https://" value="<?php echo $pro_url;?>" />
                                    </div>
                             </div>
							 <div class="row">
									<div class="col-md-12">
                                    <label><strong>Choose Quote Form <span class="text-danger">*</span></strong> <small>Select the quote form design you want to use.</small></label>
                                    </div>
									<div class="col-md-12">
									<div class="design-select <?php if($form_layout == 'layout_1'){ echo 'selected'; } ?>" onclick="formone()" id="form1">
									<img src="images/form-one.png">
									</div>
									<div class="design-select <?php if($form_layout == 'layout_2'){ echo 'selected'; } ?>" onclick="formtwo()" id="form2">
									<img src="images/form-two.png">
									</div>
									<div class="design-select <?php if($form_layout == 'layout_3'){ echo 'selected'; } ?>" onclick="formthree()" id="form3">
									<img src="images/form-three.png">
									</div>
									<div class="design-select <?php if($form_layout == 'layout_4'){ echo 'selected'; } ?>" onclick="formfour()" id="form4">
									<img src="images/form-four.png">
									</div>
									<div class="design-select <?php if($form_layout == 'layout_5'){ echo 'selected'; } ?>" onclick="formfive()" id="form5">
									<img src="images/form-five.png">
									</div>
									<div class="design-select <?php if($form_layout == 'layout_6'){ echo 'selected'; } ?>" onclick="formsix()" id="form6">
									<img src="images/form-six.png">
									</div>
									<div class="design-select <?php if($form_layout == 'layout_7'){ echo 'selected'; } ?>" onclick="formseven()" id="form7">
									<img src="images/form-seven.png">
									</div>									
									<input type="hidden" name="prod[form_layout]" id="form_layout" value="<?php echo $form_layout;?>" />
									</div>
<script>
function formone(){
	document.getElementById('form_layout').value = 'layout_1';
	document.getElementById('form1').classList.add('selected');
	document.getElementById('form2').classList.remove('selected');
	document.getElementById('form3').classList.remove('selected');
	document.getElementById('form4').classList.remove('selected');
	document.getElementById('form5').classList.remove('selected');
	document.getElementById('form6').classList.remove('selected');
	document.getElementById('form7').classList.remove('selected');
}
function formtwo(){
	document.getElementById('form_layout').value = 'layout_2';
	document.getElementById('form1').classList.remove('selected');
	document.getElementById('form2').classList.add('selected');
	document.getElementById('form3').classList.remove('selected');
	document.getElementById('form4').classList.remove('selected');
	document.getElementById('form5').classList.remove('selected');
	document.getElementById('form6').classList.remove('selected');
	document.getElementById('form7').classList.remove('selected');
}
function formthree(){
	document.getElementById('form_layout').value = 'layout_3';
	document.getElementById('form1').classList.remove('selected');
	document.getElementById('form2').classList.remove('selected');
	document.getElementById('form3').classList.add('selected');
	document.getElementById('form4').classList.remove('selected');
	document.getElementById('form5').classList.remove('selected');
	document.getElementById('form6').classList.remove('selected');
	document.getElementById('form7').classList.remove('selected');
}
function formfour(){
	document.getElementById('form_layout').value = 'layout_4';
	document.getElementById('form1').classList.remove('selected');
	document.getElementById('form2').classList.remove('selected');
	document.getElementById('form3').classList.remove('selected');
	document.getElementById('form4').classList.add('selected');
	document.getElementById('form5').classList.remove('selected');
	document.getElementById('form6').classList.remove('selected');
	document.getElementById('form7').classList.remove('selected');
}
function formfive(){
	document.getElementById('form_layout').value = 'layout_5';
	document.getElementById('form1').classList.remove('selected');
	document.getElementById('form2').classList.remove('selected');
	document.getElementById('form3').classList.remove('selected');
	document.getElementById('form4').classList.remove('selected');
	document.getElementById('form5').classList.add('selected');
	document.getElementById('form6').classList.remove('selected');
	document.getElementById('form7').classList.remove('selected');
}
function formsix(){
	document.getElementById('form_layout').value = 'layout_6';
	document.getElementById('form1').classList.remove('selected');
	document.getElementById('form2').classList.remove('selected');
	document.getElementById('form3').classList.remove('selected');
	document.getElementById('form4').classList.remove('selected');
	document.getElementById('form5').classList.remove('selected');
	document.getElementById('form6').classList.add('selected');
	document.getElementById('form7').classList.remove('selected');
}
function formseven(){
	document.getElementById('form_layout').value = 'layout_7';
	document.getElementById('form1').classList.remove('selected');
	document.getElementById('form2').classList.remove('selected');
	document.getElementById('form3').classList.remove('selected');
	document.getElementById('form4').classList.remove('selected');
	document.getElementById('form5').classList.remove('selected');
	document.getElementById('form6').classList.remove('selected');
	document.getElementById('form7').classList.add('selected');
}
</script>
									
							</div>
							<div class="row">
									<div class="col-md-12">
                                    <label><strong>Choose Prices Display <span class="text-danger">*</span></strong> <small>Select the design you want to use to show prices.</small></label>
                                    </div>
									<div class="col-md-12">
									<div class="design-select <?php if($price_layout == 'layout_1'){ echo 'selected'; } ?>" onclick="pricesone()" id="prices1">
									<img src="images/prices-one.png">
									</div>
									<div class="design-select <?php if($price_layout == 'layout_2'){ echo 'selected'; } ?>" onclick="pricestwo()" id="prices2">
									<img src="images/prices-two.png">
									</div>
									<div class="design-select <?php if($price_layout == 'layout_3'){ echo 'selected'; } ?>" onclick="pricesthree()" id="prices3">
									<img src="images/prices-three.png">
									</div>
									<div class="design-select <?php if($price_layout == 'layout_4'){ echo 'selected'; } ?>" onclick="pricesfour()" id="prices4">
									<img src="images/prices-four.png">
									</div>
									<div class="design-select <?php if($price_layout == 'layout_5'){ echo 'selected'; } ?>" onclick="pricesfive()" id="prices5">
									<img src="images/prices-five.png">
									</div>
									<div class="design-select <?php if($price_layout == 'layout_6'){ echo 'selected'; } ?>" onclick="pricessix()" id="prices6">
									<img src="images/prices-six.png">
									</div>
									<div class="design-select <?php if($price_layout == 'layout_7'){ echo 'selected'; } ?>" onclick="pricesseven()" id="prices7">
									<img src="images/prices-seven.png">
									</div>
									<div class="design-select <?php if($price_layout == 'layout_8'){ echo 'selected'; } ?>" onclick="priceseight()" id="prices8">
									<img src="images/prices-eight.png">
									</div>
									<input type="hidden" name="prod[price_layout]" id="price_layout" value="<?php echo $price_layout;?>" />
									</div>
<script>
function pricesone(){
	document.getElementById('price_layout').value = 'layout_1';
	document.getElementById('prices1').classList.add('selected');
	document.getElementById('prices2').classList.remove('selected');
	document.getElementById('prices3').classList.remove('selected');
	document.getElementById('prices4').classList.remove('selected');
	document.getElementById('prices5').classList.remove('selected');
	document.getElementById('prices6').classList.remove('selected');
	document.getElementById('prices7').classList.remove('selected');
	document.getElementById('prices8').classList.remove('selected');
}
function pricestwo(){
	document.getElementById('price_layout').value = 'layout_2';
	document.getElementById('prices1').classList.remove('selected');
	document.getElementById('prices2').classList.add('selected');
	document.getElementById('prices3').classList.remove('selected');
	document.getElementById('prices4').classList.remove('selected');
	document.getElementById('prices5').classList.remove('selected');
	document.getElementById('prices6').classList.remove('selected');
	document.getElementById('prices7').classList.remove('selected');
	document.getElementById('prices8').classList.remove('selected');
}
function pricesthree(){
	document.getElementById('price_layout').value = 'layout_3';
	document.getElementById('prices1').classList.remove('selected');
	document.getElementById('prices2').classList.remove('selected');
	document.getElementById('prices3').classList.add('selected');
	document.getElementById('prices4').classList.remove('selected');
	document.getElementById('prices5').classList.remove('selected');
	document.getElementById('prices6').classList.remove('selected');
	document.getElementById('prices7').classList.remove('selected');
	document.getElementById('prices8').classList.remove('selected');
}
function pricesfour(){
	document.getElementById('price_layout').value = 'layout_4';
	document.getElementById('prices1').classList.remove('selected');
	document.getElementById('prices2').classList.remove('selected');
	document.getElementById('prices3').classList.remove('selected');
	document.getElementById('prices4').classList.add('selected');
	document.getElementById('prices5').classList.remove('selected');
	document.getElementById('prices6').classList.remove('selected');
	document.getElementById('prices7').classList.remove('selected');
	document.getElementById('prices8').classList.remove('selected');
}
function pricesfive(){
	document.getElementById('price_layout').value = 'layout_5';
	document.getElementById('prices1').classList.remove('selected');
	document.getElementById('prices2').classList.remove('selected');
	document.getElementById('prices3').classList.remove('selected');
	document.getElementById('prices4').classList.remove('selected');
	document.getElementById('prices5').classList.add('selected');
	document.getElementById('prices6').classList.remove('selected');
	document.getElementById('prices7').classList.remove('selected');
	document.getElementById('prices8').classList.remove('selected');
}
function pricessix(){
	document.getElementById('price_layout').value = 'layout_6';
	document.getElementById('prices1').classList.remove('selected');
	document.getElementById('prices2').classList.remove('selected');
	document.getElementById('prices3').classList.remove('selected');
	document.getElementById('prices4').classList.remove('selected');
	document.getElementById('prices5').classList.remove('selected');
	document.getElementById('prices6').classList.add('selected');
	document.getElementById('prices7').classList.remove('selected');
	document.getElementById('prices8').classList.remove('selected');
}
function pricesseven(){
	document.getElementById('price_layout').value = 'layout_7';
	document.getElementById('prices1').classList.remove('selected');
	document.getElementById('prices2').classList.remove('selected');
	document.getElementById('prices3').classList.remove('selected');
	document.getElementById('prices4').classList.remove('selected');
	document.getElementById('prices5').classList.remove('selected');
	document.getElementById('prices6').classList.remove('selected');
	document.getElementById('prices7').classList.add('selected');
	document.getElementById('prices8').classList.remove('selected');
}
function priceseight(){
	document.getElementById('price_layout').value = 'layout_8';
	document.getElementById('prices1').classList.remove('selected');
	document.getElementById('prices2').classList.remove('selected');
	document.getElementById('prices3').classList.remove('selected');
	document.getElementById('prices4').classList.remove('selected');
	document.getElementById('prices5').classList.remove('selected');
	document.getElementById('prices6').classList.remove('selected');
	document.getElementById('prices7').classList.remove('selected');
	document.getElementById('prices8').classList.add('selected');
}
</script>								
							</div>
                        
                        
						</div>    
						<div class="panel-footer">
							<input type="button" onclick="submitfunc();" class="btn btn-success" value="Submit Changes">
						</div>
					</div>

					<div class="panel panel-default col-md-4">
                        <div class="panel-body">
						<div class="row">
									<div class="col-md-12">
										<h4 class="text-primary" style="margin:0;"><strong><i class="fa fa-umbrella"></i> Product Fields & Ordering</strong></h4>
										<small>Drag and drop to set ordering</small>
                                    </div>
							</div>
                            <div class="row">
									<div class="col-md-12">
										<ul id="sortable" class="connectedSortable sortingfields">
<?php if($_REQUEST['id']){?>
<?php  for($i=1;$i<=17;$i++){ ?>
<?php if(array_search("id_1",$pro_sort) == $i){?>										
											<li class="ui-state-default" id="id_1" >
											<label class="checkbox">
											<input name="sort[]" value="1"  type="hidden">
											<input name="prod[fname]" id="fname"  type="checkbox" <?php if(array_key_exists('fname', $pro_fields)){?> checked="" <?php } ?>><i></i>
											First Name</label>
											</li>
<?php } if(array_search("id_2",$pro_sort) == $i){ ?>											
											<li class="ui-state-default"  id="id_2">
											<label class="checkbox">
											<input name="sort[]" value="2"  type="hidden">
											<input name="prod[lname]" id="lname"  type="checkbox" <?php if(array_key_exists('lname', $pro_fields)){?> checked="" <?php } ?>><i></i>
											Last Name</label>
											</li>
<?php } if(array_search("id_3",$pro_sort) == $i){ ?>											
											<li class="ui-state-default"    id="id_3" >
											<label class="checkbox">
											<input name="sort[]" value="3"  type="hidden">
											<input name="prod[dob]" id="dob"  type="checkbox" <?php if(array_key_exists('dob', $pro_fields)){?> checked="" <?php } ?>><i></i>
											Date of Birth</label>
											</li>
<?php } if(array_search("id_4",$pro_sort) == $i){ ?>
											<li class="ui-state-default"  id="id_4" >
											<label class="checkbox">
											<input name="sort[]" value="4"  type="hidden">
											<input name="prod[email]" id="email"   type="checkbox" <?php if(array_key_exists('email', $pro_fields)){?> checked="" <?php } ?>><i></i>
											Email Address</label>
											</li>
<?php } if(array_search("id_5",$pro_sort) == $i){ ?>											
											<li class="ui-state-default"   id="id_5" >
											<label class="checkbox">
											<input name="sort[]" value="5"  type="hidden">
											<input name="prod[Smoke12]" id="Smoke12"   type="checkbox" <?php if(array_key_exists('Smoke12', $pro_fields)){?> checked="" <?php } ?>><i></i>
											Smoke in last 12 month (yes/no)
											</label>
											</li>
<?php } if(array_search("id_6",$pro_sort) == $i){ ?>
											<li class="ui-state-default"  id="id_6" >
											<label class="checkbox"  style="display: inline-block;">
											<input name="sort[]" value="6"  type="hidden">
											<input name="prod[Country]" id="Country"  type="checkbox" <?php if(array_key_exists('Country', $pro_fields)){?> checked="" <?php } ?>><i></i>
											Destination Country</label><br/>
											<label><input type="radio" name="destinationtype" value="worldwide" <?php if($pro_fields['destinationtype'] == 'worldwide'){?> checked="" <?php } ?>> Worldwide</label>
											<label><input type="radio" name= "destinationtype" value="canada" <?php if($pro_fields['destinationtype'] == 'canada'){?> checked="" <?php } ?>>Canada Only</label>
											</li>
<?php } if(array_search("id_7",$pro_sort) == $i){ ?>
											<li class="ui-state-default"   id="id_7" >
											<label class="checkbox">
											<input name="sort[]" value="7"  type="hidden">
											<input name="prod[phone]" id="phone"  type="checkbox" <?php if(array_key_exists('phone', $pro_fields)){?> checked="" <?php } ?>><i></i>
											Phone Number</label>
											</li>
<?php } if(array_search("id_8",$pro_sort) == $i){ ?>
											<li class="ui-state-default"  id="id_8">
											<label class="checkbox">
											<input name="sort[]" id="sdate_sort" value="8"  type="hidden">
											<input name="prod[sdate]" id="sdate"  type="checkbox" <?php if(array_key_exists('sdate', $pro_fields)){?> checked="" <?php } ?>><i></i>
											Start Date</label>
											</li>
<?php } if(array_search("id_9",$pro_sort) == $i){ ?>
											<li class="ui-state-default"   id="id_9"  >
											<label class="checkbox">
											<input name="sort[]" id="edate_sort" value="9"  type="hidden">
											<input name="prod[edate]" id="edate"  type="checkbox" <?php if(array_key_exists('edate', $pro_fields)){?> checked="" <?php } ?>><i></i>
											End Date
											</label>
											</li>
<?php } if(array_search("id_10",$pro_sort) == $i){ ?>											
											<li class="ui-state-default" id="id_10" >
											<label class="checkbox" style="display: inline-block;">
											<input name="sort[]" id="traveller_sort" value="10"  type="hidden">
											<input name="prod[traveller]" id="traveller"  type="checkbox" <?php if(array_key_exists('traveller', $pro_fields)){?> checked="" <?php } ?>><i></i>
											Number of Traveller's
											</label>
											<input type="number" name="prod[traveller_number]"  value="<?php echo $pro_fields['traveller_number'];?>" min="1" max="8" step="1" >
											</li>
<?php } if(array_search("id_11",$pro_sort) == $i){ ?>											
											<li class="ui-state-default"  id="id_11" >
											<label class="checkbox">
											<input name="sort[]" id="smoked_sort" value="11"  type="hidden">
											<input name="prod[smoked]" id="smoked" type="checkbox" <?php if(array_key_exists('smoked', $pro_fields)){?> checked="" <?php } ?>> <i></i>
											Traveller Smoked
											</label>
											</li>
<?php } if(array_search("id_12",$pro_sort) == $i){ ?>											
											<li class="ui-state-default"   id="id_12" >
											<label class="checkbox">
											<input name="sort[]" id="traveller_gender_sort" value="12"  type="hidden">
											<input name="prod[traveller_gender]" id="traveller_gender" type="checkbox" <?php if(array_key_exists('traveller_gender', $pro_fields)){?> checked="" <?php } ?>> <i></i>
											Oldest Traveller's Gender
											</label>
											</li>
<?php } if(array_search("id_13",$pro_sort) == $i){ ?>											
											<li class="ui-state-default"     id="id_13"  >
											<label class="checkbox" style="display: inline-block;">
											<input name="sort[]" id="us_stop_sort" value="13"  type="hidden">
											<input name="prod[us_stop]" id="us_stop"  type="checkbox" <?php if(array_key_exists('us_stop', $pro_fields)){?> checked="" <?php } ?>> <i></i>
											Stopover in US (Days)
											</label>
											<input type="number" name="prod[us_stop_days]" min="0" max="30" step="1" value="<?php echo $pro_fields['us_stop_days'];?>" style="display:none3;" >
											</li>
<?php } if(array_search("id_14",$pro_sort) == $i){ ?>											
											<li class="ui-state-default"  id="id_14">
											<label class="checkbox">
											<input name="sort[]" id="gender_sort" value="14"  type="hidden">
											<input name="prod[gender]" id="gender"  type="checkbox" <?php if(array_key_exists('gender', $pro_fields)){?> checked="" <?php } ?>><i></i>
											Gender
											</label>
											</li>
<?php } if(array_search("id_15",$pro_sort) == $i){ ?>											
											<li class="ui-state-default"    id="id_15"  >
											<label class="checkbox">
											<input name="sort[]" id="fplan_sort" value="15"  type="hidden">
											<input name="prod[fplan]" id="fplan"  type="checkbox" <?php if(array_key_exists('fplan', $pro_fields)){?> checked="" <?php } ?>> <i></i>
											Family Plan
											</label>
											</li>
<?php } if(array_search("id_16",$pro_sort) == $i){ ?>											
											<li class="ui-state-default"   id="id_16" >
											<label class="checkbox">
											<input name="sort[]" id="pre_existing_sort" value="16"  type="hidden">
											<input name="prod[pre_existing]" id="pre_existing"  type="checkbox" <?php if(array_key_exists('pre_existing', $pro_fields)){?> checked="" <?php } ?>> <i></i>
											Pre-existing Condition
											</label>
											</li>
<?php } if(array_search("id_17",$pro_sort) == $i){ ?>											
											<li class="ui-state-default"  id="id_17">
											<label class="checkbox">
											<input name="sort[]" id="sum_insured_sort" value="17"  type="hidden">
											<input name="prod[sum_insured]" id="sum_insured" type="checkbox" <?php if(array_key_exists('sum_insured', $pro_fields)){?> checked="" <?php } ?>> <i></i>
											Sum Insured Amount
											</label>
											</li>
<?php } ?>
<?php } ?>									
<?php } else {?>
<li class="ui-state-default"   id="id_1" >
											<label class="checkbox">
											<input name="sort[]" value="1"  type="hidden">
											<input name="prod[fname]" id="fname"  type="checkbox"><i></i>
											First Name</label>
											</li>
											<li class="ui-state-default"  id="id_2">
											<label class="checkbox">
											<input name="sort[]" value="2"  type="hidden">
											<input name="prod[lname]" id="lname"  type="checkbox"><i></i>
											Last Name</label>
											</li>
											<li class="ui-state-default"    id="id_3" >
											<label class="checkbox">
											<input name="sort[]" value="3"  type="hidden">
											<input name="prod[dob]" id="dob"  type="checkbox"><i></i>
											Date of Birth</label>
											</li>

											<li class="ui-state-default"  id="id_4" >
											<label class="checkbox">
											<input name="sort[]" value="4"  type="hidden">
											<input name="prod[email]" id="email"   type="checkbox"><i></i>
											Email Address</label>
											</li>
											<li class="ui-state-default"   id="id_5" >
											<label class="checkbox">
											<input name="sort[]" value="5"  type="hidden">
											<input name="prod[Smoke12]" id="Smoke12"   type="checkbox"><i></i>
											Smoke in last 12 month (yes/no)
											</label>
											</li>

											<li class="ui-state-default"  id="id_6" >
											<label class="checkbox"  style="display: inline-block;">
											<input name="sort[]" value="6"  type="hidden">
											<input name="prod[Country]" id="Country"  type="checkbox"><i></i>
											Destination Country</label><br/>
											<label><input type="radio" name="destinationtype" value="worldwide" checked> Worldwide</label>
											<label><input type="radio" name= "destinationtype" value="canada">Canada Only</label>
											</li>

											<li class="ui-state-default"   id="id_7" >
											<label class="checkbox">
											<input name="sort[]" value="7"  type="hidden">
											<input name="prod[phone]" id="phone"  type="checkbox"><i></i>
											Phone Number</label>
											</li>

											<li class="ui-state-default"  id="id_8">
											<label class="checkbox">
											<input name="sort[]" id="sdate_sort" value="8"  type="hidden">
											<input name="prod[sdate]" id="sdate"  type="checkbox"><i></i>
											Start Date</label>
											</li>

											<li class="ui-state-default"   id="id_9"  >
											<label class="checkbox">
											<input name="sort[]" id="edate_sort" value="9"  type="hidden">
											<input name="prod[edate]" id="edate"  type="checkbox"><i></i>
											End Date
											</label>
											</li>
											<li class="ui-state-default" id="id_10" >
											<label class="checkbox" style="display: inline-block;">
											<input name="sort[]" id="traveller_sort" value="10"  type="hidden">
											<input name="prod[traveller]" id="traveller"  type="checkbox"><i></i>
											Number of Traveller's
											</label>
											<input type="number" name="prod[traveller_number]"  value="1" min="1" max="8" step="1" >
											</li>
											<li class="ui-state-default"  id="id_11" >
											<label class="checkbox">
											<input name="sort[]" id="smoked_sort" value="11"  type="hidden">
											<input name="prod[smoked]" id="smoked" type="checkbox"> <i></i>
											Traveller Smoked
											</label>
											</li>
											<li class="ui-state-default"   id="id_12" >
											<label class="checkbox">
											<input name="sort[]" id="traveller_gender_sort" value="12"  type="hidden">
											<input name="prod[traveller_gender]" id="traveller_gender" type="checkbox"> <i></i>
											Oldest Traveller's Gender
											</label>
											</li>
											<li class="ui-state-default"     id="id_13"  >
											<label class="checkbox" style="display: inline-block;">
											<input name="sort[]" id="us_stop_sort" value="13"  type="hidden">
											<input name="prod[us_stop]" id="us_stop"  type="checkbox"> <i></i>
											Stopover in US (Days)
											</label>
											<input type="number" name="prod[us_stop_days]" min="0" max="30" step="1" value="0" style="display:none3;" >
											</li>
											<li class="ui-state-default"  id="id_14">
											<label class="checkbox">
											<input name="sort[]" id="gender_sort" value="14"  type="hidden">
											<input name="prod[gender]" id="gender"  type="checkbox"><i></i>
											Gender
											</label>
											</li>
											<li class="ui-state-default"    id="id_15"  >
											<label class="checkbox">
											<input name="sort[]" id="fplan_sort" value="15"  type="hidden">
											<input name="prod[fplan]" id="fplan"  type="checkbox"> <i></i>
											Family Plan
											</label>
											</li>
											<li class="ui-state-default"   id="id_16" >
											<label class="checkbox">
											<input name="sort[]" id="pre_existing_sort" value="16"  type="hidden">
											<input name="prod[pre_existing]" id="pre_existing"  type="checkbox"> <i></i>
											Pre-existing Condition
											</label>
											</li>
											<li class="ui-state-default"  id="id_17">
											<label class="checkbox">
											<input name="sort[]" id="sum_insured_sort" value="16"  type="hidden">
											<input name="prod[sum_insured]" id="sum_insured" type="checkbox"> <i></i>
											Sum Insured Amount
											</label>
											</li>
<?php } ?>											
										</ul>
                                    </div>
							</div>


                        </div>    
                        <input type="hidden" name="update_id" value="<?php echo $_REQUEST['id']; ?>">
						<input name="savesortlist" id="savesortlist" type="hidden" value=""/>
                     </form>   
					</div>

					<!-- /PANEL -->

</form>

				</div>

			</section>

			<!-- /MIDDLE -->



		</div>



<script>
function submitfunc(){
	var a = $("#sortable").sortable("toArray", {
		attribute: "id"
	});
	$('#savesortlist').val(a);
	$('#productform').submit();
	//alert(a);
}
</script>	

		<!-- JAVASCRIPT FILES 
		<script type="text/javascript">var plugin_path = 'assets/plugins/';</script>
		<script type="text/javascript" src="assets/plugins/jquery/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="assets/js/app.js"></script>-->

	</body>

</html>