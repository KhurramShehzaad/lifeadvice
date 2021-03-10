<?php $cnt_url = end(explode('/', $_SERVER['REQUEST_URI'])); ?>
<style>
.col-xs-3 {
	padding:0 5px !important;
}
</style>
<section class="tabshead">
<div class="container">
<div class="row tabs">
<div class="col-md-3 col-xs-3 text-center"><button class="btn <?php if($cnt_url == 'vtc_tab_info.php'){ echo 'active'; } ?>" onclick="window.location='vtc_tab_info.php'"><i class="fa fa-user"></i> Information</button></div>
<div class="col-md-3 col-xs-3 text-center"><button class="btn <?php if($cnt_url == 'vtc_tab_coverage.php'){ echo 'active'; } ?>" onclick="window.location='vtc_tab_coverage.php'"><i class="fa fa-umbrella"></i> Coverage</button></div>
<div class="col-md-3 col-xs-3 text-center"><button class="btn <?php if($cnt_url == 'vtc_tab_quotes.php'){ echo 'active'; } ?>" onclick="window.location='vtc_tab_quotes.php'"><i class="fa fa-shopping-cart"></i> Quotes</button></div>
<div class="col-md-3 col-xs-3 text-center"><button class="btn <?php if($cnt_url == 'vtc_tab_buy.php'){ echo 'active'; } ?>" onclick="window.location='vtc_tab_buy.php'"><i class="fa fa-edit"></i> Apply / Buy</button></div>
</div>
</div>
</section>