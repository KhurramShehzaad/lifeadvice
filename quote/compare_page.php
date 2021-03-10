<?php
include 'includes/db_connect.php';
?>
<link href="admin/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="admin/assets/css/essentials.css" rel="stylesheet" type="text/css" />
<style>
	h2.title{font-weight: 700;text-transform: uppercase;font-size: 14px;}
    p.desc{font-size: 12px;}
    .table>thead>tr>th{vertical-align: middle;}
    .table>tbody>tr>td{font-size: 13px;max-width: 274px;}
    .martop10{margin-top: 12px}
    .block{display: block; text-align: center;}
    tr td:first-of-type,tr th:first-of-type{font-weight: 700;color: #F0AD4E}
.smallhead {
text-transform: uppercase;
color: #fff !important;
background: #515d63;
}

</style>
<div class="container-fluid">
<?php
$startdate = $_REQUEST['departure_date'];
$enddate = $_REQUEST['return_date'];

$dStart = new DateTime($_REQUEST['departure_date']);
$dEnd  = new DateTime($_REQUEST['return_date']);
$dDiff = $dStart->diff($dEnd);
$dDiff->format('%R'); // use for point out relation: smaller/greater
$num_of_days = $dDiff->days;
if($num_of_days > 365 || $num_of_days == 364){ $num_of_days = 365; }


$product_id = $_REQUEST['product_id'];
$page_q = mysqli_query($db, "SELECT * FROM `wp_dh_products` WHERE `pro_id`='$product_id'");
$fetch = mysqli_fetch_assoc($page_q);
$prosupervisa = $fetch['pro_supervisa'];
$product_name = $fetch['pro_name'];
?>
<h1 style="font-size: 24px;font-weight: bold;color: #005d9a;">Compare and Buy <?php echo $product_name;?> Plans</h1>
<p>Please Note: The information and content of this site is intended for general informational purposes only,For most accurate information regarding rates, benefits, terms and conditions for travel insurance products, please refer directly to our insurance partners website.</p>
<?php
		$planid=explode(",", rtrim($_REQUEST['ids']));
?>
<table class="table table-bordered table-striped">
	<tbody>
	<tr style="background:#239b7a;">
		<td rowspan="2" style="text-align:center;color: #FFF;font-size: 16px;"><h3 style="background:#45bd9c; padding:3px; font-size:41px; text-align:center;color:#FFF;margin: 0;margin-bottom: 10px;"><?php echo count($planid);?></h3>Plans Selected for Comparison
		<button type="button" style="display: block;margin: 5px auto 0px auto;font-weight: bold;" class="btn btn-default" onclick="javascript:window.print()"><i class="fa fa-print"></i> Print Plans</button>
		</td>
		<?php 
		for($i=0;$i<count($planid);$i++){
		$planq = mysqli_query($db, "SELECT * FROM `wp_dh_insurance_plans` WHERE `id`='".$planid[$i]."'");
		$plan = mysqli_fetch_assoc($planq);
		$planname = $plan['plan_name'];
		?>
			<th style="color:#FFF; text-align:center; font-weight:bold; font-size:18px;"><?php echo $planname;?></th>
		<?php } ?>
	</tr>
	<tr>
		<?php 
		$planid=explode(",", rtrim($_REQUEST['ids']));
		$rate=explode(",", rtrim($_REQUEST['rate']));
		for($i=0;$i<count($planid);$i++){
		$compq = mysqli_query($db, "SELECT * FROM `wp_dh_companies` WHERE `comp_id`= (SELECT `insurance_company` FROM `wp_dh_insurance_plans` WHERE `id`='".$planid[$i]."')");
		$compy = mysqli_fetch_assoc($compq);
		$compylogo = $compy['comp_logo'];
		?>
			<td align="center"><img src="images/<?php echo $compylogo;?>" alt="<?php echo $compy['comp_name']; ?>" class="img-responsive" height="70" width="200" style="width:200px"></td>
		<?php } ?>
	</tr>
		<tr>
			<td class="smallhead">PREMIUM</td>
			<?php for($i=0;$i<count($planid);$i++){?>
			<td style="text-align: center;font-size: 28px;font-weight: bold;color: #C00;">$ <?echo number_format($rate[$i],2)?></td>
			<?php } ?>
		</tr>
		<tr>
			<td class="smallhead"></td>
			<?php for($i=0;$i<count($planid);$i++){
			$planq = mysqli_query($db, "SELECT * FROM `wp_dh_insurance_plans` WHERE `id`='".$planid[$i]."'");
			$plan = mysqli_fetch_assoc($planq);
			$planname = $plan['plan_name'];
			
			$compq = mysqli_query($db, "SELECT * FROM `wp_dh_companies` WHERE `comp_id`= (SELECT `insurance_company` FROM `wp_dh_insurance_plans` WHERE `id`='".$planid[$i]."')");
			$compy = mysqli_fetch_assoc($compq);
			$companyName = $compy['comp_name'];
			?>
			<td><?php $buynow_url = "tab_buy.php?email=".$_REQUEST['savers_email']."&coverage=".$rate[$i]."&traveller=1&deductibles=$price&companyName=$companyName&comp_id=$plan->insurance_company&planname=$planname&tripdate=".$_REQUEST['departure_date']."&tripend=".$_REQUEST['return_date']."&premium=".$rate[$i]."&cdestination=&product_name=$product_name&country=$primary_destination&visitor_visa_type=$product_name&tripduration=$num_of_days";
			?>
			<button type="button" style="display: block;margin: 5px auto 0px auto;font-weight: bold;" class="btn btn-success" onclick="window.location='<?php echo $buynow_url;?>'"><i class="fa fa-shopping-cart"></i> Buy Now</button>
			</td>
			<?php }?>
		</tr>
		<tr>
			<td class="smallhead">Coverage Amount</td>
			<?php for($i=0;$i<count($planid);$i++){?>
			<td style="text-align: center;font-size: 16px;font-weight: bold;">$ <?php echo number_format($_REQUEST['sum_insured2']); ?></td>
			<?php } ?>
		</tr>
		<tr>
			<td class="smallhead">Sample PDF Policy</td>
			<?php for($i=0;$i<count($planid);$i++){
			$pdfq = mysqli_query($db, "SELECT `pdfpolicy` FROM `wp_dh_insurance_plans_pdfpolicy` WHERE `plan_id`='".$planid[$i]."'");
			$pdfqry = mysqli_fetch_assoc($pdfq);
			$pdfpolicy = $pdfqry['pdfpolicy'];
			?>
				<td><a href="admin/uploads/<?php echo $pdfpolicy;?>" target="_blank"><i class="fa fa-file-pdf-o text-danger"></i> View PDF Policy</a></td>
			<?php } ?>
		</tr>
			<?php
			$feat = mysqli_query($db, "SELECT * FROM `wp_dh_insurance_plans_benefits` WHERE `plan_id` IN (".$_REQUEST['ids'].") GROUP BY `benefits_head`");
			while($feature = mysqli_fetch_assoc($feat)){
			$benefits_head = $feature['benefits_head'];
			
			?>
		<tr>
			<td class="smallhead"><?php echo $benefits_head; ?></td>
			<?php for($i=0;$i<count($planid);$i++){
			$feades_q = mysqli_query($db, "SELECT `benefits_desc` FROM `wp_dh_insurance_plans_benefits` WHERE `plan_id`='".$planid[$i]."' AND `benefits_head`='$benefits_head'");
			$feades_f = mysqli_fetch_assoc($feades_q);
			$benefits_desc = $feades_f['benefits_desc'];
			?>
			<td><?php echo $benefits_desc; ?></td>
			<?php } ?>
		</tr>
			<?php } ?>
				<tr>
			<td class="smallhead">PREMIUM</td>
			<?php for($i=0;$i<count($planid);$i++){?>
			<td style="text-align: center;font-size: 28px;font-weight: bold;color: #C00;">$ <?echo number_format($rate[$i],2)?></td>
			<?php } ?>
		</tr>
		<tr>
			<td class="smallhead"></td>
			<?php for($i=0;$i<count($planid);$i++){
			$planq = mysqli_query($db, "SELECT * FROM `wp_dh_insurance_plans` WHERE `id`='".$planid[$i]."'");
			$plan = mysqli_fetch_assoc($planq);
			$planname = $plan['plan_name'];
			
			$compq = mysqli_query($db, "SELECT * FROM `wp_dh_companies` WHERE `comp_id`= (SELECT `insurance_company` FROM `wp_dh_insurance_plans` WHERE `id`='".$planid[$i]."')");
			$compy = mysqli_fetch_assoc($compq);
			$companyName = $compy['comp_name'];
			?>
			<td><?php $buynow_url = "tab_buy.php?email=".$_REQUEST['savers_email']."&coverage=".$rate[$i]."&traveller=1&deductibles=$price&companyName=$companyName&comp_id=$plan->insurance_company&planname=$planname&tripdate=".$_REQUEST['departure_date']."&tripend=".$_REQUEST['return_date']."&premium=".$rate[$i]."&cdestination=&product_name=$product_name&country=$primary_destination&visitor_visa_type=$product_name&tripduration=$num_of_days";
			?>
			<button type="button" style="display: block;margin: 5px auto 0px auto;font-weight: bold;" class="btn btn-success" onclick="window.location='<?php echo $buynow_url;?>'"><i class="fa fa-shopping-cart"></i> Buy Now</button>
			</td>
			<?php }?>
		</tr>	

	</tbody>
</table>

</div>
<div class="clearfix"></div>


<!-- Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <form role="form">
                    <div class="form-group">
                        <label for="inputName">Send Email</label>
                        <input type="text" class="form-control" id="inputName" placeholder="Enter your name" value="<?php echo $email; ?>"/>
                    </div>
                </form>
			<div>
                <button class="btn btn-default" onclick="close_Form()">Close</button>
                <button class="btn btn-primary submitBtn" onclick="submitContactForm()">SUBMIT</button>
            </div>	
  </div>

</div>
	<script>
	var modal = document.getElementById('myModal');
		 
	window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
	 function email_model(){
		jQuery('#myModal').show();
		
	 }
	 function close_Form(){
		jQuery('#myModal').hide();
		
	 }
		  function submitContactForm() {
			  var email = jQuery( "#inputName" ).val();
			    var url = window.location.href; 
				var arr=url.split('?')[1];
				var data = {
							'action': 'email_custom_send',
							'page' : email,
							'url': arr
							};

                var url = "<?php //echo admin_url('admin-ajax.php'); ?>";
				jQuery.ajax({
							url : url, // AJAX handler
							data : data,
							type : 'POST',
							success : function( data ){
								//console.log(data);
								if(data === 'ok'){
									alert('Email Send Successfully');
									jQuery('#myModal').hide();
								}else{
									alert('There is an error.Please try again');
								}
							}
						});
				}
			
				  
	
	</script>