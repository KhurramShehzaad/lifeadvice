<?php
session_start();
include 'includes/db_connect.php';

$user_name = $_POST['user_name'];
$user_pass = sha1($_POST['user_name'].$_POST['user_password'].$_POST['user_name']);
$query = mysqli_query($db, "SELECT * FROM `users` WHERE `username`='$user_name' AND `password`='$user_pass' AND `status`='active'");
$query_num = mysqli_num_rows($query);
$query_fetch = mysqli_fetch_assoc($query);
$db_id = $query_fetch['id'];
$db_username = $query_fetch['username'];
$db_password = $query_fetch['password'];
$db_status = $query_fetch['status'];
$user_type = $query_fetch['user_type'];
$db_fname = $query_fetch['fname'];
if($query_num > 0){
if($db_status != '0' || $db_status != ''){
session_start();
$_SESSION['id'] = $db_id;
$_SESSION['un'] = $db_username;
$_SESSION['user'] = $db_fname;
$_SESSION['type'] = $user_type;
echo "<script>
window.location='home.php';
</script>";	
}
else {
echo "<script>
window.location='index.php?action=inactive';
</script>";	
}
}
else {
echo "<script>
window.location='index.php?action=failed';
</script>";	
}
?>