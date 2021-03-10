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
<section class="tabscontent">
<?php include 'layouts/prices_life_'.$price_layout.'.php';?>
</section>

<?php include 'footer.php'; ?>

    <script>
	function comparetest(){
		var pids = [];
		var price = [];
		            var $checkboxes = jQuery('.compare input[type="checkbox"]');

            $checkboxes.change(function(e){
//            e.preventDefault();
                var pid =  jQuery(this).attr('data-pid');
                var product_id =  jQuery(this).attr('data-productid');
				var price_plan = jQuery(this).val();

                $checkboxes.attr("disabled", false);
                var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
                console.log(countCheckedCheckboxes);
                if (countCheckedCheckboxes == 1){
                    jQuery('.compare_header_top').show();
                    jQuery('.two_select').hide();
                    jQuery('.one_select').show();
                }else if(countCheckedCheckboxes == 2 || countCheckedCheckboxes == 3){
					jQuery('.compare_header_top').show();
                    jQuery('.two_select').show();
                    jQuery('.one_select').hide();
					//$checkboxes.attr("disabled", true);
                    //$checkboxes.filter(':checked').attr("disabled", false);
                }else if(countCheckedCheckboxes >= 4){
					jQuery('.compare_header_top').show();
                    jQuery('.two_select').show();
                    jQuery('.one_select').hide();
					$checkboxes.attr("disabled", true);
                    $checkboxes.filter(':checked').attr("disabled", false);
					
                }
				// else if(countCheckedCheckboxes == 3){
                    // $checkboxes.attr("disabled", true);
                    // $checkboxes.filter(':checked').attr("disabled", false);
                // }
				else{
                    jQuery('.compare_header_top').hide();
                }
				
				
                if (jQuery(this).is(":checked")== false) {
                     pids.splice(pids.indexOf(pid), 1);
                     price.splice(price.indexOf(price_plan), 1);
                }else{
                    pids.push(pid);
                    price.push(price_plan);
               }
			   
			   
			   
                var url = window.location.href; 
				var arr=url.split('?')[1];
				var slider1 = localStorage.getItem("default_value");
				var slider2 = localStorage.getItem("price_value");
				
				jQuery("#new_window").click(function(){
					var planId = jQuery.unique(pids);
					var main_price = jQuery.unique(price);
                    var compareUrl = "http://lifeadvice.ca/quote/compare_page.php?product_id=" + product_id + '&ids=' + planId + '&'+arr+'&default_value='+slider1+'&price_value='+slider2+'&rate='+main_price;					
					
					if (compareUrl.indexOf("#") > -1) {
						var myUrl = compareUrl.replace(/\#/g, '');
						var newUrl = jQuery(".two_select a").prop("href",myUrl);
				    }else{
						var newUrl = jQuery(".two_select a").prop("href",compareUrl);
					}
					 
					 
					 var newwindow = window.open($(this).prop("href"), '', 'height=800,width=1024');
					 
					 if (window.focus) {newwindow.focus()}
					 return false;
						
				});

            });
			
			 jQuery("#clear").click(function(){
				  $(".hidden1").prop("checked", false);
				  $(".hidden1").prop("disabled", false);
				  $(".two_select a").removeAttr("href");
				  pids = [];
		          price = [];
				  jQuery('.compare_header_top').hide();
			   });
	}
</script>
        <style>
            .btn-custom-default {
                color: #333 !important;
                background-color: #fff !important;
                border-color: #000 !important;
                padding: 10px 30px !important;
                border-radius: 0 !important;
                font-weight: 600 !important;
                font-size: 16px !important;
            }
        </style>
        <div class="compare_header_top">
            <div class="container-fluid">
				<div class="row">
                    <div class="col-md-12 text-center">
					<h3 style="margin:0;">Select & Compare Plans</h3>
					</div>
				</div>	
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="one_select">
                            <a href="#" class="btn btn-primary">Select one more plan to compare</a>
                        </div>
                        <div class="two_select">
                            <a href="#" class="btn btn-primary" id="new_window"><i class="fa fa-server"></i> Compare</a>
                            <i class="icon"></i>
                            <a href="#"  class="btn btn-default" id="clear"><i class="fa fa-refresh"></i> Clear all</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!-- JAVASCRIPT FILES -->
		<script type="text/javascript">var plugin_path = 'admin/assets/plugins/';</script>
		<!--<script type="text/javascript" src="admin/assets/plugins/jquery/jquery-2.1.4.min.js"></script>-->
		<script type="text/javascript" src="admin/assets/js/app.js"></script>
</body>
</html>	