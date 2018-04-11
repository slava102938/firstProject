<?php 
// настройки подключение к БД
function hostopen() {
	$result = mysqli_connect('localhost', 'root', '', 'slava102938');
	mysqli_query($result, "SET NAMES 'utf8'");
	return $result;
} 
?>