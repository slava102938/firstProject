<?php
require "connectBD.php";

if(isset($_POST['email']))
{
	$email = $_POST['email'];
	$proces = "SELECT email FROM users WHERE email='$email'";
	$d = mysqli_query(hostopen(), $proces);
	foreach($d as $result){
	}
	if(empty($result)) {
		echo "false";
	}
	else {
		$header = "Восстановление аккаунта";
		$text = "Для восстановления аккаунта перейдите по этой ссылке... но тут нет никакой ссылки! Правильно! Но это только пока. Ждите и она скоро появится.";
		mail("admin@localhost.com", '=?UTF-8?B?'.base64_encode($header).'?=', $text, "From: admin@localhost.com");
		echo "true";
	}
}
?>