<?php 
require "connectBD.php";

if(isset($_POST['newemail'])) {
	$email = $_POST['newemail'];
	$proces = "SELECT email FROM users WHERE email='$email'";
	$d = mysqli_query(hostopen(), $proces);
	foreach($d as $elem) {
	}
	if(empty($elem)) {
		echo "true";
	}
	else {
		echo "Такой эмайл уже зарегистрирован. Используйте другой почтовый адрес";
	}
}

if(isset($_POST['newlogin'])) {
	$login = $_POST['newlogin'];
	$proces = "SELECT login FROM users WHERE login='$login'";
	$d = mysqli_query(hostopen(), $proces);
	foreach($d as $elem) {
	}
	if(empty($elem)) {
		echo "true";
	}
	else {
		echo "Такой логин уже зарегистрирован. Используйте другой логин";
	}
}
?>