<?php 
if(isset($_POST['destroy'])) { 
	$login = $_SESSION['login'];
	$cookiedelete = "UPDATE users SET cookie='' WHERE login='$login'";
	mysqli_query(hostopen(), $cookiedelete);
	setcookie('login', '', time());
	setcookie('cookie', '', time());
	session_destroy();
	header("refresh:0.1;url='index.php'");
}
?>