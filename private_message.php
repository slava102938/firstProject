<?php // Просмотр отдельного сообщения
session_start();
	
	// если зайти на страницу без введённых данных
	if(!isset($_SESSION['id'])) { 
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
	<title>Личное сообщение</title>
	<meta name="robots" content="noindex, nofollow">
	<noscript><meta http-equiv="refresh" content="0.1;noscript.html"></noscript>
</head>
<body>
	<?php

	// Навигация и выход
	require "navigation.php";

		// сообщение
		if(isset($_GET['id'])) {
			$messid = $_GET['id'];
			$message = "SELECT * FROM message WHERE id='$messid'";
			$resultmess = mysqli_query(hostopen(),$message);
			foreach($resultmess as $elem1) {
			}
			echo "<b>Отправитель:</b> ".$elem1['login_sender'].'<br>';
			echo "<b>Получатель:</b> ".$elem1['login_recipient'].'<br>';
			echo "<b>Тема:</b> ".$elem1['topic'].'<br>';
			echo "<b>Сообщение:</b><br>";
			echo $elem1['messtext'].'<br>';
			echo "<b>Время и дата:</b> ".$elem1['messtime'];

			// просмотренность сообщения
			if($elem1['viewed'] == 0 and $elem1['id_recipient'] == $id) { 
				$viewedtrue = "UPDATE message SET viewed=1 WHERE id='$messid'";
				mysqli_query(hostopen(), $viewedtrue);
			}
		}

	}
	?>
</body>
</html>