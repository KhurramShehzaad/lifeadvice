<?php
include 'includes/db_connect.php';
$policies_q = mysqli_query($db, "SELECT * FROM `policies`");
while($policies_f = mysqli_fetch_assoc($policies_q)){
$policy_id = $policies_f['id'];
$policy_name = $policies_f['policy_name'];
$company_id = $policies_f['company_id'];


$days_query = mysqli_query($db, "SELECT * FROM `days` WHERE `company_id`='$company_id'");
$days_fetch = mysqli_fetch_assoc($days_query);
$days_id = $days_fetch['id'];
?>
<h3><?php echo $policy_name;?></h3>
<table cellspacing="0" cellpadding="5" border="1">
<thead>
  <tr>
    <th><strong>Coverage Amount</strong></th>
<?php
$ages_q = mysqli_query($db, "SELECT * FROM `ages` WHERE `company_id`='$company_id' ORDER BY `s_age`");
while($ages_f = mysqli_fetch_assoc($ages_q)){
$ages_id = $ages_f['id'];
?>
    <th><strong><?php echo $ages_f['s_age'].'-'.$ages_f['e_age'];?></strong></th>
<?php } ?>    
  </tr>
</thead>
<tbody>  
<?php
$bene_q = mysqli_query($db, "SELECT * FROM `benefit` ORDER BY `benefit_amount`");
while($bene_f = mysqli_fetch_assoc($bene_q)){
$bene_id = $bene_f['id'];
?>
  <tr>
    <td>$<?php echo $bene_f['benefit_amount'];?></td>
<?php
$ages_q = mysqli_query($db, "SELECT * FROM `ages` WHERE `company_id`='$company_id' ORDER BY `s_age`");
while($ages_f = mysqli_fetch_assoc($ages_q)){
$ages_id = $ages_f['id'];
$prices_q = mysqli_query($db, "SELECT * FROM `prices` WHERE `age_id`='$ages_id' AND `days_id`='$days_id' AND `benefit_id`='$bene_id'");
$prices_f = mysqli_fetch_assoc($prices_q);
$price = $prices_f['price'];
?>
    <td>$<?php echo $price;?></td>
<?php } ?>     
  </tr>
<?php } ?>
</tbody>
</table>

<?php } ?>