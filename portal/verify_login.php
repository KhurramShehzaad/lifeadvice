<?php
session_start();
include 'includes/db_connect.php';
$post_username = $_POST['username'];
$post_password = $post_username.$_POST['password'].$post_username;
$post_password = sha1($post_password);

$verify_query = mysqli_query($db, "SELECT `id`, `username`, `password` FROM `users` WHERE `username`='$post_username' AND `password`='$post_password' AND `status`='active'");
$verify_num = mysqli_num_rows($verify_query);

$verify_fetch = mysqli_fetch_assoc($verify_query);
$id = $verify_fetch['id'];
$username = $verify_fetch['username'];
$password = $verify_fetch['password'];

if($verify_num > 0){
$_SESSION['portal_id'] = $id;
$session_id = $_SESSION['portal_id'];
echo "<script>window.location='dashboard.php'</script>";
}
else if($username != $post_username or $password != $post_password){
echo "<script>window.location='index.php?login=failed'</script>";
}
?>
