<?php
include 'quote/includes/db_connect.php';
?>
<?php include_once('header.php'); ?>
    


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


<div class="col-md-8 align-items-center"><div class="row">
<?php
$srno = 0;
$sql = mysqli_query($db, "SELECT * FROM `blog`");
while($fetch = mysqli_fetch_assoc($sql)){
$srno++;	
$blog_id = $fetch['id'];
$blog_dated = $fetch['dated'];
$blog_title = $fetch['title'];
$blog_text = $fetch['post_text'];
$blog_img = $fetch['blog_img'];
$blog_url = $fetch['blog_url'];
?>
<!-- Blog 1 -->
<div class="col-12 blogs">
<span class="blogimg"><img src="/quote/admin/blog/<?php echo $blog_img;?>" alt="Blog"></span>
<p class="blogtag"><i class="fa fa-calendar text-success"></i> <?php echo date('M d Y', strtotime($blog_dated));?> &nbsp;&nbsp;<i class="fa fa-tag text-success"></i> Visitor Insurance</p>

<h3><?php echo $blog_title; ?></h3>
<p><?php echo substr($blog_text, 0, 200);?>...</p>
<a href="/blog/<?php echo $blog_url;?>/<?php echo $blog_id;?>" class="btn btn-outline-dark">Read More</a>
</p>
</div>
<?php } ?>

</div>

<!-- Paginatin Starts 
<div class="col-md-12">
<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-center">
    <li class="page-item disabled">
      <a class="page-link" href="#" aria-disabled="true">Previous</a>
    </li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item">
      <a class="page-link" href="#">Next</a>
    </li>
  </ul>
</nav>
</div>
-->

</div>

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

</div></div>


</div>




<?php include_once('footer.php'); ?>

</body></html>