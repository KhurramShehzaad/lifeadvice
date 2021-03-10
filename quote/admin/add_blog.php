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
$newfile = date('dmYHi').'_'.str_replace(" ", "", basename( $_FILES['blog_img']['name']));	
move_uploaded_file($_FILES['blog_img']['tmp_name'], "blog/".$newfile);
$blog_img = date('dmYHi').'_'.$_FILES['blog_img']['name'];

$blog_title = $_POST['title'];
$blog_text = addslashes($_POST['post_text']);
$blog_url = str_replace(' ', '-', $blog_title);
$blog_url = preg_replace('/[^A-Za-z0-9\-]/', '', $blog_url); // Removes special chars.
$blog_url = strtolower($blog_url); 

$q = mysqli_query($db, "INSERT INTO `blog`(`title`, `post_text`, `blog_img`, `blog_url`) VALUES ('$blog_title','$blog_text','$blog_img','$blog_url')");

echo "<script>window.location='blog.php';</script>";
}
else if($_REQUEST['action'] == 'update'){
$newfile = date('dmYHi').'_'.str_replace(" ", "", basename( $_FILES['blog_img']['name']));	
move_uploaded_file($_FILES['blog_img']['tmp_name'], "blog/".$newfile);
$blog_img = date('dmYHi').'_'.$_FILES['blog_img']['name'];


if($blog_img == date('dmYHi').'_'){
$blog_img	= $_POST['curr_img'];
}

$blog_title = $_POST['title'];
$blog_text = addslashes($_POST['post_text']);
$update_id = $_POST['update_id'];
$blog_url = str_replace(' ', '-', $blog_title);
$blog_url = preg_replace('/[^A-Za-z0-9\-]/', '', $blog_url); // Removes special chars.
$blog_url = strtolower($blog_url);

$query = mysqli_query($db, "UPDATE `blog` SET `title`='$blog_title',`post_text`='$blog_text',`blog_img`='$blog_img',`blog_url`='$blog_url' WHERE `id`='$update_id'");

echo "<script>window.location='blog.php';</script>";	
}
?>

<!doctype html>
<html lang="en-US">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Add Blog</title>
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
					<h1>Manage Blog</h1>
					<ol class="breadcrumb">
						<li><a href="companies.php">Blog</a></li>
						<li class="active">Manage Blog</li>
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
$page_q = mysqli_query($db, "SELECT * FROM `blog` WHERE `id`='".$_REQUEST['id']."'");
$fetch = mysqli_fetch_assoc($page_q);
$blog_id = $fetch['id'];
$blog_dated = $fetch['dated'];
$blog_title = $fetch['title'];
$blog_text = $fetch['post_text'];
$blog_img = $fetch['blog_img'];
?>
					<div class="panel panel-default">
                    <form method="post" action="?action=<?php if($_REQUEST['id']){ echo 'update'; } else { echo 'add'; }?>" enctype="multipart/form-data">
                        <div class="panel-heading panel-heading-transparent">
							<strong>Blog Details</strong>
							</div>
                        <div class="panel-body">
                            <div class="row">
									<div class="col-md-8">
                                    <label><strong>Blog Title</strong></label>
                                    <!-- date picker -->
                                    <input class="form-control" type="text" id="title" name="title" value="<?php echo $blog_title;?>" />
                                    </div>
									<div class="col-md-4">
                                    <label><strong>Blog Image</strong></label>
                                    <!-- date picker -->
                                    <input class="custom-file-upload" type="file" id="blog_img" name="blog_img" data-btn-text="Select a File" />
                                    </div>
							</div>
							 <div class="row">
									<div class="col-md-12">
                                    <label><strong>Blog Details</strong></label>
                                    <!-- date picker -->
                                    <textarea class="summernote form-control" data-height="200" data-lang="en-US" name="post_text" id="post_text"><?php echo $blog_text; ?></textarea>
                                    </div>
							</div>
                        </div>    
						<div class="panel-footer">
							<input type="submit" class="btn btn-success" value="Submit Changes">
						</div>
                        <input type="hidden" name="update_id" value="<?php echo $_REQUEST['id']; ?>">
                        <input type="hidden" name="curr_img" id="curr_img" value="<?php echo $blog_img; ?>" class="btn btn-success">
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
		
	</body>
</html>