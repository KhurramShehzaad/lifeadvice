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
$newfile = date('dmYHi').'_'.str_replace(" ", "", basename( $_FILES['comp_logo']['name']));	
move_uploaded_file($_FILES['comp_logo']['tmp_name'], "uploads/".$newfile);
echo $comp_logo = date('dmYHi').'_'.$_FILES['comp_logo']['name'];

$cpdf = date('dmYHi').'_'.str_replace(" ", "", basename( $_FILES['comp_canadapdf']['name']));	
move_uploaded_file($_FILES['comp_canadapdf']['tmp_name'], "uploads/".$cpdf);
$comp_canadapdf = date('dmYHi').'_'.$_FILES['comp_canadapdf']['name'];

$spdf = date('dmYHi').'_'.str_replace(" ", "", basename( $_FILES['comp_studentpdf']['name']));	
move_uploaded_file($_FILES['comp_studentpdf']['tmp_name'], "uploads/".$spdf);
$comp_studentpdf = date('dmYHi').'_'.$_FILES['comp_studentpdf']['name'];

$comp_name = $_POST['comp_name'];
$comp_buylink = $_POST['comp_buylink'];

$q = mysqli_query($db, "INSERT INTO `wp_dh_companies`(`comp_name`, `comp_logo`, `comp_canadapdf`, `comp_studentpdf`, `comp_buylink`) VALUES ('$comp_name','$comp_logo','$comp_canadapdf','$comp_studentpdf','$comp_buylink')");

echo "<script>window.location='companies.php';</script>";
}
else if($_REQUEST['action'] == 'update'){
$newfile = date('dmYHi').'_'.str_replace(" ", "", basename( $_FILES['comp_logo']['name']));	
move_uploaded_file($_FILES['comp_logo']['tmp_name'], "uploads/" .$newfile);
$comp_logo = date('dmYHi').'_'.str_replace(" ", "", $_FILES['comp_logo']['name']);

$cpdf = date('dmYHi').'_'.str_replace(" ", "", basename( $_FILES['comp_canadapdf']['name']));	
move_uploaded_file($_FILES['comp_canadapdf']['tmp_name'], "uploads/" .$cpdf);
$comp_canadapdf = date('dmYHi').'_'.$_FILES['comp_canadapdf']['name'];

$spdf = date('dmYHi').'_'.str_replace(" ", "", basename( $_FILES['comp_studentpdf']['name']));	
move_uploaded_file($_FILES['comp_studentpdf']['tmp_name'], "uploads/" .$spdf);
$comp_studentpdf = date('dmYHi').'_'.str_replace(" ", "", $_FILES['comp_studentpdf']['name']);


if($comp_logo == ''){
$comp_logo	= $_POST['curr_logo'];
}
if($comp_canadapdf == ''){
$comp_canadapdf	= $_POST['curr_cpdf'];
}
if($comp_logo == ''){
$comp_studentpdf	= $_POST['curr_spdf'];
}

$comp_name = $_POST['comp_name'];
$comp_buylink = $_POST['comp_buylink'];
$update_id = $_POST['update_id'];

$query = mysqli_query($db, "UPDATE `wp_dh_companies` SET `comp_name`='$comp_name',`comp_logo`='$comp_logo',`comp_canadapdf`='$comp_canadapdf',`comp_studentpdf`='$comp_studentpdf',`comp_buylink`='$comp_buylink' WHERE `comp_id`='$update_id'");

echo "<script>window.location='companies.php';</script>";	
}
?>

<!doctype html>
<html lang="en-US">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Add Company</title>
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
</style>
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
					<h1>Manage Company</h1>
					<ol class="breadcrumb">
						<li><a href="companies.php">Company</a></li>
						<li class="active">Manage Company</li>
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
$page_q = mysqli_query($db, "SELECT * FROM `wp_dh_companies` WHERE `comp_id`='".$_REQUEST['id']."'");
$fetch = mysqli_fetch_assoc($page_q);
$comp_id = $fetch['comp_id'];
$comp_name = $fetch['comp_name'];
$comp_logo = $fetch['comp_logo'];
$comp_canadapdf = $fetch['comp_canadapdf'];
$comp_studentpdf = $fetch['comp_studentpdf'];
$comp_buylink = $fetch['comp_buylink'];
$comp_createon = $fetch['comp_createon'];
$comp_createby = $fetch['comp_createby'];
$comp_updateon = $fetch['comp_updateon'];
$comp_updateby = $fetch['comp_updateby'];

?>
					<div class="panel panel-default">
                    <form method="post" action="?action=<?php if($_REQUEST['id']){ echo 'update'; } else { echo 'add'; }?>" enctype="multipart/form-data">
                        <div class="panel-heading panel-heading-transparent">
							<strong>Company Details</strong>
							</div>
                        <div class="panel-body">
                            <div class="row">
									<div class="col-md-12">
                                    <label><strong>Company Name</strong></label>
                                    <!-- date picker -->
                                    <input class="form-control" type="text" id="comp_name" name="comp_name" value="<?php echo $comp_name;?>" />
                                    </div>
							</div>
							<div class="row">		
                                    <div class="col-md-4">
                                    <label><strong>Company Logo</strong></label>
                                    <!-- date picker -->
                                    <input class="custom-file-upload" type="file" id="comp_logo" name="comp_logo" data-btn-text="Select a File" />
                                    </div>
									<div class="col-md-4">
                                    <label><strong>Canada PDF Policy</strong></label>
                                    <!-- date picker -->
                                    <input class="custom-file-upload" type="file" id="comp_canadapdf" name="comp_canadapdf" data-btn-text="Select a File" />
                                    </div>
									<div class="col-md-4">
                                    <label><strong>Student PDF Policy</strong></label>
                                    <!-- date picker -->
                                    <input class="custom-file-upload" type="file" id="comp_studentpdf" name="comp_studentpdf" data-btn-text="Select a File" />
                                    </div>
                             </div>
							 <div class="row">
									<div class="col-md-12">
                                    <label><strong>Buynow Link</strong></label>
                                    <!-- date picker -->
                                    <input class="form-control" type="text" id="comp_buylink" name="comp_buylink" value="<?php echo $comp_buylink;?>" />
                                    </div>
							</div>
                        </div>    
						<div class="panel-footer">
							<input type="submit" class="btn btn-success" value="Submit Changes">
						</div>
                        <input type="hidden" name="update_id" value="<?php echo $_REQUEST['id']; ?>">
                        <input type="hidden" name="curr_logo" id="curr_logo" value="<?php echo $comp_logo; ?>" class="btn btn-success">
						<input type="hidden" name="curr_cpdf" id="curr_img" value="<?php echo $comp_canadapdf; ?>" class="btn btn-success">
						<input type="hidden" name="curr_spdf" id="curr_spdf" value="<?php echo $comp_studentpdf; ?>" class="btn btn-success">
                     </form>   
					</div>

					<!-- /PANEL -->



				</div>

			</section>

			<!-- /MIDDLE -->



		</div>







	

		<!-- JAVASCRIPT FILES -->

		<script type="text/javascript">var plugin_path = 'assets/plugins/';</script>

		<script type="text/javascript" src="assets/plugins/jquery/jquery-2.1.4.min.js"></script>

		<script type="text/javascript" src="assets/js/app.js"></script>



		<!-- PAGE LEVEL SCRIPTS -->

		<script type="text/javascript">

			loadScript(plugin_path + "datatables/js/jquery.dataTables.min.js", function(){

				loadScript(plugin_path + "datatables/dataTables.bootstrap.js", function(){



					if (jQuery().dataTable) {



						var table = jQuery('#datatable_sample');

						table.dataTable({

							"columns": [{

								"orderable": false

							}, {

								"orderable": true

							}, {

								"orderable": false

							}, {

								"orderable": false

							}, {

								"orderable": true

							}, {

								"orderable": false

							}],

							"lengthMenu": [

								[5, 15, 20, -1],

								[5, 15, 20, "All"] // change per page values here

							],

							// set the initial value

							"pageLength": 25,            

							"pagingType": "bootstrap_full_number",

							"language": {

								"lengthMenu": "  _MENU_ records",

								"paginate": {

									"previous":"Prev",

									"next": "Next",

									"last": "Last",

									"first": "First"

								}

							},

							"columnDefs": [{  // set default column settings

								'orderable': false,

								'targets': [0]

							}, {

								"searchable": false,

								"targets": [0]

							}],

							"order": [

								[1, "asc"]

							] // set first column as a default sort by asc

						});



						var tableWrapper = jQuery('#datatable_sample_wrapper');



						table.find('.group-checkable').change(function () {

							var set = jQuery(this).attr("data-set");

							var checked = jQuery(this).is(":checked");

							jQuery(set).each(function () {

								if (checked) {

									jQuery(this).attr("checked", true);

									jQuery(this).parents('tr').addClass("active");

								} else {

									jQuery(this).attr("checked", false);

									jQuery(this).parents('tr').removeClass("active");

								}

							});

							jQuery.uniform.update(set);

						});



						table.on('change', 'tbody tr .checkboxes', function () {

							jQuery(this).parents('tr').toggleClass("active");

						});



						tableWrapper.find('.dataTables_length select').addClass("form-control input-xsmall input-inline"); // modify table per page dropdown



					}



				});

			});

		</script>



	</body>

</html>