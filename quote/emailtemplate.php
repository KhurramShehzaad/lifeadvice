<?php//ini_set('display_errors', 1);//ini_set('display_startup_errors', 1);//error_reporting(E_ALL);$jsondata = file_get_contents('email2.txt');// $demo_content = site_url()."/email2.txt";//$jsondata = file_get_contents($demo_content);$jsondata= str_replace("[],","",$jsondata);$jsondata= stripslashes($jsondata);$arrr = json_decode($jsondata,true);function object_to_array($object){	return (array) $object;}$buynowurl = $arrr[0]['url'];?><html><head>    <meta charset="utf-8">    <style type="text/css">        body {margin: 0;padding: 0;}        * {margin: 0;padding: 0;outline: none;list-style: none;}    </style></head><body style="margin:0; padding:0;">    <div style="width:680px; margin:0 auto; background:#fff; border:1px solid #f1f1f1; padding:10px;">        <div style="width:100%;">            <img src="https://lifeadvice.ca/images/brand.png" style="margin:0 auto; display:block;" alt="#">        </div>        <div style="width:100%; background:#41c3bb">            <h1 style="font:bold 28px Arial, Helvetica, sans-serif; color:#fff; text-align:center; line-height:80px;">Here's Your Quotes            <?php            $countertop = 0;            $dumy = 1 ;            foreach ($arrr as $key):            	$key=object_to_array($key);            	 if($key['deductible']==$countertop && $dumy<2):           	  $dumy++;          	 ?>             		<?=$key['planproduct'];?></h1>             	 <?php endif;             endforeach; ?>        </div>        <div style="width:100%; margin-bottom:10px;">            <h2 style="font:bold 16px Arial, Helvetica, sans-serif; color:#333; line-height:50px; margin:0 0 0 20px;">Dear Customer,</h2>             <p style="font:normal 14px Arial, Helvetica, sans-serif; color:#333; line-height:24px; margin:0 0 0 20px;">Quote # <?php echo rand(); ?></p>            <p style="font:normal 14px Arial, Helvetica, sans-serif; color:#333; line-height:24px; margin:0 0 0 20px;">Thank you for visiting our website</p>            <p style="font:normal 14px Arial, Helvetica, sans-serif; color:#333; line-height:24px;  margin:0 0 0 20px;">               to comparing Quote on our website to buy the policy click <a href="https://lifeadvice.ca<?php echo $buynowurl;?>" style="font:bold 14px Arial, Helvetica, sans-serif; color:#eb342b; text-decoration:none;"> Buy Now</a> or Call Us at                <a href="tel:8555005041" style="font:bold 14px Arial, Helvetica, sans-serif; color:#eb342b; text-decoration:none;">1855-500-5041</a></p>        </div>        <div style="width:100%; background:#faad2f">            <h2 style="font:normal 16px Arial, Helvetica, sans-serif; color:#fff; line-height:36px; text-align:center;">                Lowest Price on following deductibles            </h2>        </div>        <?php        $ded = ['0','250','1000','2500'];        for($i=0;$i<count($ded);$i++){?>                <div style="width:100%;border-bottom:1px solid #ccc">                    <h3 style="font:bold 26px Arial,Helvetica,sans-serif;color:#f00;text-align:center;line-height:50px">                        $<?=$ded[$i]?> Deductible                    </h3>                </div>            <?php            $counter=0;            foreach ($arrr as $key){            $key=object_to_array($key);            //print_r($key);                if($key['deductible']==$ded[$i] && $counter<3){                    $counter++;				//$key['logo'];	               ?>                <div style="width:100%; border-bottom:1px solid #ccc;padding:10px 0;">                    <div style="width:33.33%; display:inline-block;height: 47px; color: darkred;float: left">                        <h4 style="font:bold 26px Arial, Helvetica, sans-serif; color:#333; text-align:center;display: table-cell;vertical-align: middle;height: 72px;width: 222px;line-height: 42px;">$                   <?php                    $check_total = isset($key['check_total']) ? $key['check_total'] : '';                   if($check_total=="1") {                 $totalPrice1=round($key['price']+$key['flatrate_price']);                                         if($key['sales_tax']!="" && $key['sales_tax']!='9% quebec')                              {                                $totalPrice1=$totalPrice1+($totalPrice1*8)/100;                              }                              elseif($key['sales_tax']!="" && $key['sales_tax']=='9% quebec')                              {                                $totalPrice1=$totalPrice1+($totalPrice1*9)/100;                              }                    ?>          <?= sprintf('%.2f',$totalPrice1,2);  } else { ?>  <?= sprintf('%.2f',round($key['price'],2));} ?></h4>                    </div>                    <div style="width:33.33%; display:inline-block;text-align:center;float: left">                        <img src="https://lifeadvice.ca/quote/admin/uploads/<? echo $key['logo']?>" style="max-width: 100%;max-height:72px" >                    </div>					<div style="width:33.33%; display:inline-block;text-align:center;float: left; padding-top:15px;">					<h4 style="font:bold 18px Arial, Helvetica, sans-serif; color:#333; text-align:center;display: block;vertical-align: middle;margin:0;">$<?=$key['sum_insured']?></h4> Benefits Maximum					</div>                    <div style="clear:both;"></div>                </div>                <?php }            }        } ?>  <table align="center" border="0" cellpadding="0" cellspacing="0" style="background:#fff;width:100%">    <tbody>        <tr>            <td align="center">                <table  style="display:inline;" width="100%" align="left" border="0" cellpadding="0" cellspacing="0">                    <tbody>                        <tr>                            <td height="10">                            </td>                        </tr>                        <tr>                            <td style="font-family: 'Open Sans',sans-serif;line-height: 36px;font-size: 30px;color: #333333;font-weight: 700;padding-left: 61px;" contenteditable="true">                                Lets Stay Connected!                            </td>                        </tr>                        <tr>                            <td height="5">                            </td>                        </tr>                        <tr>                            <td  style="font-family: Open Sans,sans-serif;font-size: 14px;line-height: 24px;color: #333333;font-weight: 400;text-align: left;padding-left: 63px; ">                               For relavant travel realted information, follow us on your social media platform of choice!                            </td>                        </tr>                        <tr>                            <td height="10">                            </td>                        </tr>                        <tr>                            <td  style="font-family: Open Sans,sans-serif;font-size: 14px;line-height: 24px;color: #333333;font-weight: 400;text-align: left;padding-left: 63px; ">                               Join the #Visitorguard conversation                            </td>                        </tr>                    </tbody>                </table>            </td>        </tr>        <tr>            <td align="center" >                <table align="center"  border="0" cellpadding="0" cellspacing="0" >                    <tbody>                        <tr>                            <td style="margin-right: 7px;display: inline-block;">                                <a href="#"><img src="https://lifeadvice.ca/quote/images/social/facebook.png" width="400"  style="width:100%;height:100%;border-radius: 42px;height: 44px;width: 44px;" ></a>                            </td>                            <td style="margin-right: 7px;display: inline-block;">                                <a href="#"><img src="https://lifeadvice.ca/quote/images/social/twitter.png" width="400"   style="width:100%;height:100%;border-radius: 42px;height: 44px;width: 44px;"></a>                            </td>                            <td style="margin-right: 7px;display: inline-block;">                                <a href="#"><img src="https://lifeadvice.ca/quote/images/social/linkedin.png" width="400"   style="width:100%;height:100%;border-radius: 42px;height: 44px;width: 44px;"></a>                            </td>                             <td  style="margin-right: 7px;display: inline-block;">                                <a href="#"><img src="https://lifeadvice.ca/quote/images/social/google-plus.png" width="400"   style="width:100%;height:100%;border-radius: 42px;height: 44px;width: 44px;"></a>                            </td>                             <td style="margin-right: 7px;display: inline-block;">                                <a href="#"><img src="https://lifeadvice.ca/quote/images/social/pinterest.png" width="400"   style="width:100%;height:100%;border-radius: 42px;height: 44px;width: 44px;"></a>                            </td>                        </tr>                    </tbody>                </table>            </td>        </tr>        <tr>            <td style="background:#FAAD2F; padding: 7px;">                <p style="text-align: center;color: #fff;padding: 1px;margin: 0;font-size: 13px;">Ready to save money ?</p>                <p style="text-align: center;color: #fff;padding: 1px;margin: 0;font-size: 13px;">LifeAdvice, 10-7003 Steeles Ave WEST,  Toronto, Ontario, M9W0A2</p>                <p style="text-align: center;color: #fff;padding: 1px;margin: 0;font-size: 13px;">Telephone: +1855-500-5041 | FAX: +1855-222-7444 | E-mail:  <a href="mailto:nfo@lifeadvice.ca" style="color:#fff;font-weight:700">info@lifeadvice.ca</a></p>            </td>        </tr>    </tbody></table>    </div></body></html>