<?php
include 'quote/includes/db_connect.php';

$sql = mysqli_query($db, "SELECT * FROM `blog` WHERE `id`='".$_REQUEST['id']."'");
$fetch = mysqli_fetch_assoc($sql);	
$blog_id = $fetch['id'];
$blog_dated = $fetch['dated'];
$blog_title = $fetch['title'];
$blog_text = $fetch['post_text'];
$blog_img = $fetch['blog_img'];
include_once('header.php');
?>


<div class="col-md-12 py-5 d-lg-block d-none">

<h1 class="head">Blogs
<span>Latest Blog and Updates</span></h1>

</div>





</div></div>





<div class="row"><div id="demo" class="carousel slide" data-ride="carousel">



  <!-- The slideshow -->

  <div class="carousel-inner">

    <div class="carousel-item active">

      <img src="/images/slide1.jpg" alt="Los Angeles">

    </div>

    <div class="carousel-item">

      <img src="/images/slide2.jpg" alt="Chicago">

    </div>



  </div>

  

</div></div>



</div>



</header>







<div class="container-fluid py-5"><div class="container"><div class="row">


<div class="col-md-8 singl-blog align-items-center"><div class="row">

<!-- Blog 1 -->

<img src="/quote/admin/blog/<?php echo $blog_img; ?>" alt="Blog" class="w-100 img-fluid">
<p class="blogtag"><i class="fa fa-calendar text-success"></i> <?php echo date('M d, Y', strtotime($blog_dated));?> &nbsp;&nbsp;<i class="fa fa-tag text-success"></i> Blog</p>

<h3><?php echo $blog_title; ?></h3>
<br>

<p><?php echo $blog_text; ?>
</p>

</div></div>

<div class="col-md-4 blogsbar">

<div class="col-12 sidebar">
<h1>Search Blog</h1>
<form>

 <div class="input-group my-3">
        <input type="text" class="form-control" id="validationTooltipUsername" placeholder="Username" aria-describedby="validationTooltipUsernamePrepend" required>
          <div class="input-group-append">
          <span class="input-group-text" id="validationTooltipUsernamePrepend"><i class="fa fa-search"></i></span>
        </div>



</div></form>
</div>

<div class="col-12 sidebar">
<h1>Categories</h1>
<ul>
<li><a href="#">Visitor to Canada</a></li>
<li><a href="#">Life Insurance</a></li>
</ul>
</div>


</div>



</div>

</div></div>












</div>



<?php include_once('footer.php'); ?>

</body></html>