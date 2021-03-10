<?php
include 'includes/db_connect.php';
$product_id = '2';
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
?>
<html>
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Visitors to Canada</title>
		<meta name="description" content="" />
		<meta name="Author" content="" />
		<!-- mobile settings -->
		<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />
		<!-- WEB FONTS -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&amp;subset=latin,latin-ext,cyrillic,cyrillic-ext" rel="stylesheet" type="text/css" />

		<!-- CORE CSS -->
		<link href="admin/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		
		<!-- THEME CSS -->
		<link href="admin/assets/css/essentials.css" rel="stylesheet" type="text/css" />
		<link href="admin/assets/css/layout.css" rel="stylesheet" type="text/css" />
		<link href="admin/assets/css/color_scheme/green.css" rel="stylesheet" type="text/css" id="color_scheme" />
</head>	
<body style="background:#FFF;">
<?php
include 'layouts/'.$form_layout.'.php';
?>

<div style="clear:both; height:30px;"></div>
		<!-- JAVASCRIPT FILES -->
		<script type="text/javascript">var plugin_path = 'admin/assets/plugins/';</script>
		<!--<script type="text/javascript" src="admin/assets/plugins/jquery/jquery-2.1.4.min.js"></script>-->
		<script type="text/javascript" src="admin/assets/js/app.js"></script>
</body>
</html>