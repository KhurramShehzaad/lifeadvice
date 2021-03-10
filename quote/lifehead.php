<section class="tabshead">
<div class="row" style="padding: 15px; margin:0;">
<div class="col-md-6 col-xs-6"><a href="/"><img src="images/logo-white.png" /></a></div>
<div class="col-md-6 col-xs-6 text-right" style="padding-top: 20px;"><a href="tel:0018555008999" style="text-decoration:none; color:#FFF; font-size:26px;"><i class="fa fa-phone"></i> <span class="hidden-xs">855-500-8999</span></a></div>
</div>

</section>
<?php $cnt_url = end(explode('/', $_SERVER['REQUEST_URI'])); ?>
<style>
.col-xs-3 {
	padding:0 5px !important;
}
</style>
<section class="tabshead">
<div class="container">
<div class="row tabs">
<div class="col-md-3 col-xs-3 text-center"><button class="btn <?php if($cnt_url == 'life_info.php'){ echo 'active'; } ?>" onclick="window.location='life_info.php'"><i class="fa fa-user"></i> Information</button></div>
<div class="col-md-3 col-xs-3 text-center"><button class="btn <?php if($cnt_url == 'life_coverage.php'){ echo 'active'; } ?>" onclick="window.location='life_coverage.php'"><i class="fa fa-umbrella"></i> Coverage</button></div>
<div class="col-md-3 col-xs-3 text-center"><button class="btn <?php if($cnt_url == 'life_quotes.php'){ echo 'active'; } ?>" onclick="window.location='life_quotes.php'"><i class="fa fa-shopping-cart"></i> Quotes</button></div>
<div class="col-md-3 col-xs-3 text-center"><button class="btn <?php if($cnt_url == 'life_buy.php'){ echo 'active'; } ?>"><i class="fa fa-edit"></i> Apply / Buy</button></div>
</div>
</div>
</section>