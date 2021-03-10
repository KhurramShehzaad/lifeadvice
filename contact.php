<?php include_once('header.php');

if($_REQUEST['action'] == 'post'){
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$to = 'contact-us@lifeadvice.ca';
$from = 'info@lifeadvice.ca';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Create email headers
$headers .= 'From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion();

$body = "
<html>
<body>
Dear Administrator,<br/>
<br/>
You have just received contact inquiry from lifeadvice.ca please find the details below:<br/>
<strong>Name:</strong> $fname $lname <br/>
<strong>Email:</strong> $email <br/>
<strong>Contact #:</strong> $mobile <br/>
<strong>Subject:</strong> $subject <br/>
<strong>Message:</strong> $message <br/>
<br/>
Regards,<br/>
LifeAdvice
</body>
</html>
";
 
// Sending email
if(mail($to, $subject, $body, $headers)){
    echo "<script>window.location='?action=sent'</script>";
}

}
?>
<div class="col-md-12 py-5 d-lg-block d-none">
<h1 class="head">Get In Touch
<span>Have a Question? Contact Us Now!</span></h1>
</div>
</div>
</div>

<div class="row">
<div id="demo" class="carousel slide" data-ride="carousel">

  <!-- The slideshow -->
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="images/slide1.jpg" alt="Los Angeles">
    </div>
    <div class="carousel-item">
      <img src="images/slide2.jpg" alt="Chicago">
    </div>

  </div>
</div>
</div>

</div>

</header>

<div class="container-fluid pt-5 pl-0 pr-0">

<div class="row pb-2 d-none contactus align-items-center">
<h1 class="text-center">Got questions about insurance?</h1>

<div class="col-md-6 py-3 text-center offset-md-3">
<h5>Get answers to your questions from our Insurance Experts. We will also assist you all the way with your insurance application.</h5>
<p>Speak with our Advisors anytime</p></div>


</div>

<div class="container-fluid pb-5 cnctmain">
<div class="container">
<div class="row  row-eq-height">

<div class="col-md-5 contactadd align-items-center">
<h1>Contact Address</h1>
<h5>Get answers to your questions from our Insurance Experts. We will also assist you all the way with your insurance application.</h5>
<p>Speak with our Advisors anytime</p>

<div class="col-md-12 add">
<h5><i class="fa fa-map-marker"></i>  Address </h5>
<p>912 Isaiah Place, Kitchener, ON, N2E0B6 </p> </div>
   
 <div class="col-md-12 add">
<h5><i class="fa fa-phone"></i> Phone  </h5>
<p>+1-855-500-8999,</p></div> 

<div class="col-md-12 add">
<h5><i class="fa fa-envelope"></i> Email </h5>
<p>contact@lifeadvice.ca,</p></div> 


</div>
<div class="col-md-7 contactform">
<?php if($_REQUEST['action'] == 'sent'){?>
<h1>Thank you !
<span>We have received your contact inquiry we will get back to you as soon as possible.</span></h1>
<?php } else { ?>
<h1>Send a Message
<span>Please fill the form below and submit... We will contact you.</span></h1>
<form method="post" action="?action=post">
<div class="row">
<p class="col-6"><label class="">Your Name *</label><br><span><input type="text" name="fname"></span></p>
<p class="col-6"><label class="">Your Last Name</label><br><span><input type="text" name="lname"></span></p>
<p class="col-6"><label class="">Your Email *</label><br><span><input type="text" name="email"></span></p>
<p class="col-6"><label class="">Your Contact No *</label><br><span><input type="text" name="mobile"></span></p>
<p class="col-12"><label class="">Your Subject</label><br><span><input type="text" name="subject"></span></p>
<p class="col-12"><label class="">Your Message</label><br><span><textarea name="message"  rows="2"></textarea></span></p>
<p class="col-12 text-right"><button type="submit" class="btn btn-lg"><i class="fa fa-send-o"></i></button></p>
</div>
</form>
<?php } ?>

</div>

</div>



</div>
</div>
</div>


<div class="container-fluid">
<div class="row">

<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2898.706305242645!2d-80.52393728446313!3d43.40406767913069!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x882bf5f33283b73d%3A0x11d11e5af5f01ae3!2s912+Isaiah+Pl%2C+Kitchener%2C+ON+N2E+0B6%2C+Canada!5e0!3m2!1sen!2sin!4v1559567604280!5m2!1sen!2sin" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>

</div>
</div>

</div>

<?php include_once('footer.php'); ?>

<script>
jQuery(document).ready(function($) {
	// on focus
	$(".contactform input, .contactform textarea")
		.focus(function() {
		$(this)
			.parent()
			.siblings("label")
			.addClass("has-value");
	})
	
	// blur input fields on unfocus + if has no value
		.blur(function() {
		var text_val = $(this).val();
		if (text_val === "") {
			$(this)
				.parent()
				.siblings("label")
				.removeClass("has-value");
		}
	});
});


  </script>

</body>
</html>