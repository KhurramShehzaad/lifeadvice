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

$orderdata = $pro_sort;
$allow_input_field = $pro_fields;
?>
<html>
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Life Insurance Canada</title>
		<!-- mobile settings -->
		<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />
		<!-- CORE CSS -->
		<link href="admin/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="admin/assets/css/essentials.css" rel="stylesheet" type="text/css" />
		<link href="css/style.css" rel="stylesheet" type="text/css" />
	</head>
<body>
<?php include 'lifehead.php'; ?>
<?php
$bgs = array(1, 2, 3, 7, 8, 11, 12); //VTC
$k = array_rand($bgs);
$bg = $bgs[$k];
?>

<section class="tabscontent" <?php if($form_layout == 'layout_5'){?> style="background: linear-gradient( rgba(162, 44, 44, 0.3), rgba(82, 82, 82, 0.3) ), url(<?php echo 'images/bgs/'.$bg;?>.jpg); background-size: cover; background-position: 50% 50%;" <?php } ?>>
<?php
include 'layouts/life_'.$form_layout.'.php';
?>
</section>

<?php include 'footer.php'; ?>
<script>

function checkPostal(){
	var postcode = document.getElementById('postcode');
    var regex = new RegExp(/^[ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ]( )?\d[ABCEGHJKLMNPRSTVWXYZ]\d$/i);
    if (regex.test(postcode.value)){
        //return true;
		document.getElementById('postal_error').innerHTML = '';
	} else {
		//return false;
		document.getElementById('postal_error').innerHTML = 'Invalid postal code';
	}
}
</script>
		<!-- JAVASCRIPT FILES -->
		<script type="text/javascript">var plugin_path = 'admin/assets/plugins/';</script>
		<script type="text/javascript" src="admin/assets/plugins/jquery/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="admin/assets/js/app.js"></script>
</body>
</html>	