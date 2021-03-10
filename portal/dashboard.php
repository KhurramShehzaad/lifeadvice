<?php
include 'includes/db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Dashboard - Customer Portal</title>

		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- page specific plugin styles -->

		<!-- text fonts -->
		<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->
		<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
		<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="assets/js/ace-extra.min.js"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
 <style>
.infobox {
	width:240px;
}
</style>
	</head>

	<body class="no-skin">
	
	<?php include 'header.php'; ?>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
			//	try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<?php include 'sidebar.php'; ?>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="#">Home</a>
							</li>
							<li class="active">Dashboard</li>
						</ul><!-- /.breadcrumb -->

						<!--<div class="nav-search" id="nav-search">
							<form class="form-search">
								<span class="input-icon">
									<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
									<i class="ace-icon fa fa-search nav-search-icon"></i>
								</span>
							</form>
						</div> /.nav-search -->
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								Dashboard
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									overview &amp; stats
								</small>
                                <?php if($sess_user_type == 'admin'){?>
                                <form method="get" action="?action=filter" style="float: right; width: 200px;">
                                <select class="chosen-select form-control" name="seller" id="seller" data-placeholder="Select Seller" onChange="this.form.submit();">
                                <?php if($sess_user_type == 'admin'){?>
                                            <option <?php if($_POST['seller'] == 'admin'){?> selected <?php } ?> value="">Select All</option>
                                            <?php $agent_q = mysqli_query($db, "SELECT * FROM `users` WHERE `user_type`='broker' ORDER BY `fname`");
											while($agent_f = mysqli_fetch_assoc($agent_q)){
											?>
                                            <option <?php if($_REQUEST['seller'] == $agent_f['id']){?> selected <?php } ?> value="<?php echo $agent_f['id'];?>"><?php echo $agent_f['fname'].' '.$agent_f['lname'];?></option>
                                            <?php } ?>
                                            <?php }?>
                                </select>
                                </form>
                                <?php } ?>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="hr hr-dotted"></div>
								<div class="row">
								<?php
								$pros_q = mysqli_query($db, "SELECT * FROM `wp_dh_products`");
								while($pros_f = mysqli_fetch_assoc($pros_q)){
								?>
								<div class="col-md-2 text-center" style="background-color: #FFF;min-height: 180px;margin-right: 10px;border-radius: 5px;border: 1px solid #ddd;box-shadow: 0px 0px 1px 0px #ccc;font-size: 52px;padding: 30px 0 10px;margin-left: 10px; margin-bottom:10px;">
								<i class="fa fa-umbrella"></i>
								<h3 style="margin: 0;text-transform: uppercase;color: #888;font-size: 16px;font-weight: bold;"><?php echo ucwords(strtolower($pros_f['pro_name']));?></h3>
								<a href="<?php echo $pros_f['pro_url'];?>" target="_blank" class="btn btn-primary" style="display: block;width: 50%;margin: 0 auto;margin-top: 10px;padding: 0px;font-weight: bold;font-family: arial;text-decoration: none;border-width: 3px;font-size: 16px;">Buy Now</a>
								</div>
								<?php } ?>
								</div>
								<div class="hr hr-dotted"></div>

								<div class="row">
									<div class="col-sm-6">
										<div class="widget-box transparent">
											<div class="widget-header widget-header-flat">
												<h4 class="widget-title lighter">
													<i class="ace-icon fa fa-star orange"></i>
													Recent Sales
												</h4>

												<div class="widget-toolbar">
													<a href="#" data-action="collapse">
														<i class="ace-icon fa fa-chevron-up"></i>
													</a>
												</div>
											</div>

											<div class="widget-body">
												<div class="widget-main no-padding">
													<table class="table table-bordered table-striped">
														<thead class="thin-border-bottom">
															<tr>
																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>Policy
																</th>

																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>Premium
																</th>

																<th class="hidden-480">
																	<i class="ace-icon fa fa-caret-right blue"></i>Status
																</th>
															</tr>
														</thead>

														<tbody>
<?php
												if($sess_user_type == 'admin'){
												$inquery = '';	
												}
												else if($sess_user_type == 'broker'){
												$inquery = " WHERE `agent` IN (select  `unique_code`
from    (select * from `users`
         order by parent_id, id) products_sorted,
        (select @pv := ".$_SESSION['portal_id'].") initialisation
where   find_in_set(parent_id, @pv)
and     length(@pv := concat(@pv, ',', id)))
";	
												}
												else if($sess_user_type == 'agent'){
												$inquery = "WHERE `agent`='$sess_unique_code'";	
												}
												$sales_q = mysqli_query($db, "SELECT * FROM `sales` $inquery ORDER BY `sales`.`purchase_date` DESC");
												while($sales_f = mysqli_fetch_assoc($sales_q )){

$today = strtotime(date('Y-m-d'));
												$st_date = strtotime($sales_f['start_date']);
												$policy_status = $sales_f['policy_status'];
												//checking policy status
												if($today >= $st_date && $policy_status == 'paid'){
												//echo '>';
												$status = 'active';
												$class = 'success';	
												} else {
												if($policy_status == 'paid'){
												$status = 'paid';
												$class = 'info';	
												}	
												}
												
												if($sales_f['product'] == '1'){
													$policytype = 'SVI';
												} else if($sales_f['product'] == '2'){
													$policytype = 'VTC';
												} else if($sales_f['product'] == '3'){
													$policytype = 'SI';
												} else if($sales_f['product'] == '4'){
													$policytype = 'IFC';
												} else if($sales_f['product'] == '5'){
													$policytype = 'ST';
												} else if($sales_f['product'] == '6'){
													$policytype = 'MT';
												} else if($sales_f['product'] == '7'){
													$policytype = 'AI';
												} else if($sales_f['product'] == '8'){
													$policytype = 'TII';
												} else if($sales_f['product'] == '9'){
													$policytype = 'BC';
												}

												$policy_number_temp = 10000000 + $sales_f['sales_id'];
												$policy_number = $policytype.$policy_number_temp;
												if($policy_status == 'cancel'){
												$status = 'cancelled';
												$class = 'danger';
												}
												else if($policy_status == 'pending'){
												$status = 'pending';
												$class = 'info';	
												}else if($policy_status == 'return'){
												$status = 'Early Return';
												$class = 'warning';
												}
?>

															<tr>
																<td><a href="sales_view.php?id=<?php echo $sales_f['sales_id'];?>"><?php echo $policy_number;?></a></td>

																<td>
																	<b class="blue">$<?php echo number_format($sales_f['price_total'],2);?></b>
																</td>

																<td class="hidden-480">
																	<span class="label label-<?php echo $class;?> arrowed-in arrowed-in-right"><?php echo ucwords(strtolower($status));?></span>
																</td>
															</tr>
<?php } ?>

														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>

									<div class="col-sm-6">
										<div class="widget-box transparent" id="recent-box">
											<div class="widget-header">
												<h4 class="widget-title lighter">
													<i class="ace-icon fa fa-star orange"></i>
													Recent <?php if($sess_user_type == 'admin'){ echo 'Members'; } else { echo 'Downlines'; } ?>
												</h4>

												<div class="widget-toolbar no-border">
													<ul class="nav nav-tabs" id="recent-tab">
														<li class="active">
															<a data-toggle="tab" href="#member-tab">Recent <?php if($sess_user_type == 'admin'){ echo 'Members'; } else { echo 'Downlines'; } ?></a>
														</li>

													</ul>
												</div>
											</div>

											<div class="widget-body">
												<div class="widget-main padding-4">
													<div class="tab-content padding-8">

														<div id="member-tab" class="tab-pane active">
															<div class="clearfix">

																<div class="itemdiv memberdiv">
																	<div class="user">
																		<img alt="Bob Doe's avatar" src="assets/images/avatars/avatar2.png" />
																	</div>

																	<div class="body">
																		<div class="name">
																			<a href="user_profile.php?id=<?php echo $de_f['id'];?>"><?php echo $de_f['fname'].' '.$de_f['lname'];?></a>
																		</div>

																		<div class="time">
																			<i class="ace-icon fa fa-clock-o"></i>
																			<span class="green"><?php echo ucwords(strtolower($de_f['user_type']));?></span>
																		</div>

																		<div>
																			<span class="label label-warning label-sm"><?php echo $de_f['status'];?></span>

																		</div>
																	</div>
																</div>



															<div class="space-4" style="clear:both;"></div>

															<div  style="background: rgb(249, 249, 249) none repeat scroll 0% 0%; padding: 5px; margin: 20px 0px 0px;">
																<i class="ace-icon fa fa-users fa-2x green middle"></i>

																&nbsp;
																<?php if($sess_user_type == 'admin' || $sess_user_type == 'broker'){?>
																<a href="users.php" class="btn btn-sm btn-white btn-info">
																	See all members &nbsp;
																	<i class="ace-icon fa fa-arrow-right"></i>
																</a>
																<?php } else {?>
																<a href="profile.php" class="btn btn-sm btn-white btn-info">
																	See all &nbsp;
																	<i class="ace-icon fa fa-arrow-right"></i>
																</a>
																<?php } ?>
															</div>

															<div class="hr hr-double hr8" style="margin-top: 0;"></div>
														</div>

														
												</div>
											</div>
										</div>
									</div>


										
									</div>


								</div>

								<div class="hr hr32 hr-dotted"></div>

							</div>
                                                  
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

<?php include 'footer.php';?>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="assets/js/jquery-2.1.4.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="assets/js/excanvas.min.js"></script>
		<![endif]-->
		<script src="assets/js/jquery-ui.custom.min.js"></script>
		<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
		<!--<script src="assets/js/jquery.easypiechart.min.js"></script>-->
		<script src="assets/js/jquery.sparkline.index.min.js"></script>
		<script src="assets/js/jquery.flot.min.js"></script>
		<script src="assets/js/jquery.flot.pie.min.js"></script>
		<script src="assets/js/jquery.flot.resize.min.js"></script>

		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
		
				$('.sparkline').each(function(){
					var $box = $(this).closest('.infobox');
					var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
					$(this).sparkline('html',
									 {
										tagValuesAttribute:'data-values',
										type: 'bar',
										barColor: barColor ,
										chartRangeMin:$(this).data('min') || 0
									 });
				});
			
			
			  //flot chart resize plugin, somehow manipulates default browser resize event to optimize it!
			  //but sometimes it brings up errors with normal resize event handlers
			  $.resize.throttleWindow = false;
			
			  var placeholder = $('#piechart-placeholder').css({'width':'90%' , 'min-height':'150px'});
			  var data = [
				{ label: "social networks",  data: 38.7, color: "#68BC31"},
				{ label: "search engines",  data: 24.5, color: "#2091CF"},
				{ label: "ad campaigns",  data: 8.2, color: "#AF4E96"},
				{ label: "direct traffic",  data: 18.6, color: "#DA5430"},
				{ label: "other",  data: 10, color: "#FEE074"}
			  ]
			  function drawPieChart(placeholder, data, position) {
			 	  $.plot(placeholder, data, {
					series: {
						pie: {
							show: true,
							tilt:0.8,
							highlight: {
								opacity: 0.25
							},
							stroke: {
								color: '#fff',
								width: 2
							},
							startAngle: 2
						}
					},
					legend: {
						show: true,
						position: position || "ne", 
						labelBoxBorderColor: null,
						margin:[-30,15]
					}
					,
					grid: {
						hoverable: true,
						clickable: true
					}
				 })
			 }
			 drawPieChart(placeholder, data);
			
			 /**
			 we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
			 so that's not needed actually.
			 */
			 placeholder.data('chart', data);
			 placeholder.data('draw', drawPieChart);
			
			
			  //pie chart tooltip example
			  var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
			  var previousPoint = null;
			
			  placeholder.on('plothover', function (event, pos, item) {
				if(item) {
					if (previousPoint != item.seriesIndex) {
						previousPoint = item.seriesIndex;
						var tip = item.series['label'] + " : " + item.series['percent']+'%';
						$tooltip.show().children(0).text(tip);
					}
					$tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
				} else {
					$tooltip.hide();
					previousPoint = null;
				}
				
			 });
			
				/////////////////////////////////////
				$(document).one('ajaxloadstart.page', function(e) {
					$tooltip.remove();
				});
			
			
			
			
				var d1 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.5) {
					d1.push([i, Math.sin(i)]);
				}
			
				var d2 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.5) {
					d2.push([i, Math.cos(i)]);
				}
			
				var d3 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.2) {
					d3.push([i, Math.tan(i)]);
				}
				
			
				var sales_charts = $('#sales-charts').css({'width':'100%' , 'height':'220px'});
				$.plot("#sales-charts", [
					{ label: "Domains", data: d1 },
					{ label: "Hosting", data: d2 },
					{ label: "Services", data: d3 }
				], {
					hoverable: true,
					shadowSize: 0,
					series: {
						lines: { show: true },
						points: { show: true }
					},
					xaxis: {
						tickLength: 0
					},
					yaxis: {
						ticks: 10,
						min: -2,
						max: 2,
						tickDecimals: 3
					},
					grid: {
						backgroundColor: { colors: [ "#fff", "#fff" ] },
						borderWidth: 1,
						borderColor:'#555'
					}
				});
			
			
				$('#recent-box [data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('.tab-content')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					//var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
			
			
				$('.dialogs,.comments').ace_scroll({
					size: 300
			    });
				
				
				//Android's default browser somehow is confused when tapping on label which will lead to dragging the task
				//so disable dragging when clicking on label
				var agent = navigator.userAgent.toLowerCase();
				if(ace.vars['touch'] && ace.vars['android']) {
				  $('#tasks').on('touchstart', function(e){
					var li = $(e.target).closest('#tasks li');
					if(li.length == 0)return;
					var label = li.find('label.inline').get(0);
					if(label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation() ;
				  });
				}
			
				$('#tasks').sortable({
					opacity:0.8,
					revert:true,
					forceHelperSize:true,
					placeholder: 'draggable-placeholder',
					forcePlaceholderSize:true,
					tolerance:'pointer',
					stop: function( event, ui ) {
						//just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
						$(ui.item).css('z-index', 'auto');
					}
					}
				);
				$('#tasks').disableSelection();
				$('#tasks input:checkbox').removeAttr('checked').on('click', function(){
					if(this.checked) $(this).closest('li').addClass('selected');
					else $(this).closest('li').removeClass('selected');
				});
			
			
				//show the dropdowns on top or bottom depending on window height and menu position
				$('#task-tab .dropdown-hover').on('mouseenter', function(e) {
					var offset = $(this).offset();
			
					var $w = $(window)
					if (offset.top > $w.scrollTop() + $w.innerHeight() - 100) 
						$(this).addClass('dropup');
					else $(this).removeClass('dropup');
				});
			
			})
		</script>
	</body>
</html>
