<?php // Список других пользователей
session_start();

	if(!isset($_SESSION['id'])) { // если зайти на страницу без введённых данных
		header("refresh:0.1;index.php");
	}
	else {
		require "php/connectBD.php";
		require "php/ifBaned.php";
		require "php/exit.php";

		// сбор данных пользователя
		$id = $_SESSION['id'];
		$infoid = "SELECT name,lastname FROM users WHERE id='$id'";
		$elem = mysqli_query(hostopen(), $infoid);
		foreach($elem as $result) {
		}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="shortcut icon" type="image\x-icon" href="image/favicon.ico">
	<link rel="stylesheet" type="text/css" href="css/generalCss.css">
	<style type="text/css">
		table {
			border: 1px solid black;
			margin: 5px;
			width: 100%;
		}
		th, td {
			width: 33%;
			border: 1px solid black;
			text-align: center;
		}
	</style>
	<title>Пользователи</title>
	<meta name="robots" content="noindex, nofollow">
	<noscript><meta http-equiv="refresh" content="0.1;noscript.html"></noscript>
</head>
<body>

	<?php 
	// Навигация и выход
	require "navigation.php";
	?>

	<!-- Таблица со всеми пользователями !-->
	<table>
		<tr>
			<th>Имя</th>
			<th>Фамилия</th>
			<th>Посмотреть профиль</th>
		</tr>
	<?php

		// вывод списка пользователей
		$spisok = "SELECT name,lastname,login FROM users WHERE id>'$id' OR id<'$id'";
		$resultuser = mysqli_query(hostopen(), $spisok);
		$i = 1;
		foreach ($resultuser as $elem1) { 
			foreach ($elem1 as $arr) {
				if($i == 1) {
					echo "<tr><td>".$arr."</td>";
					$i ++;
				}
				elseif($i == 2) {
					echo "<td>".$arr."</td>";
					$i++;
				}
				else {
					echo "<td><a href='profile_user.php?login=".$arr."'>Просмотреть профиль</a></td></tr>";
					$i = 1;
				}
			} 
		}
	?>
	</table>
	<?php 
		}
	?>
</body>
</html>