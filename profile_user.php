<?php // Профиль другого пользователя
session_start();

	if(!isset($_SESSION['id'])) { // если зайти на страницу без введённых данных
		header("refresh:0.1;index.php");
	}
	else {

		require "php/connectBD.php";
		require "php/ifBaned.php";
		require "php/exit.php";

		//вывод некоторой информации просматриваемого пользователя
		$loginuser = $_GET['login'];
		$info = "SELECT users.login, users.name, users.lastname, countries.countrie, langs.lang FROM users INNER JOIN countries ON users.countrieId=countries.id INNER JOIN langs ON users.langId=langs.id WHERE users.login='$loginuser'";
		$resultuser = mysqli_query(hostopen(), $info);
		foreach($resultuser as $elem1) {
		}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="shortcut icon" type="image\x-icon" href="image/favicon.ico">
	<link rel="stylesheet" type="text/css" href="css/generalCss.css">
	<?php 
		echo "<title>".$elem1['name']." ".$elem1['lastname']."</title>";
	?>
	<meta name="robots" content="noindex, nofollow">
	<noscript><meta http-equiv="refresh" content="0.1;noscript.html"></noscript>
</head>
<body>
	<?php 
	// Навигация и выход
	require "navigation.php";

		// вывод данных пользователя
		echo 'Логин: '.$elem1['login'].'<br>';
		echo 'Имя: '.$elem1['name'].'<br>';
		echo 'Фамилия: '.$elem1['lastname'].'<br>';
		echo 'Страна: '.$elem1['countrie'].'<br>';
		echo 'Язык: '.$elem1['lang'].'<br><br>';
		
		echo "<b><a href='nowmessage.php?login=".$elem1['login']."'>НАПИСАТЬ ЛИЧНОЕ СООБЩЕНИЕ</a></b>";
		}
	?>
</body>
</html>