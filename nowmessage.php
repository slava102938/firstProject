<?php // Создание сообщения
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
		$infoid = "SELECT name,lastname,login FROM users WHERE id='$id'";
		$elem = mysqli_query(hostopen(), $infoid);
		foreach($elem as $result) {
		}

		// запись сообщения в базу данных
		if(isset($_POST['login'])) {
			$login_rec = $_POST['login'];
			$login_sen = $result['login'];
			$searchid = "SELECT id FROM users WHERE login='$login_rec'";
			$searchresult = mysqli_query(hostopen(), $searchid);
			foreach($searchresult as $idresult) {
			}
			$id_rec = $idresult['id'];
			$id_sen = $id;
			$topic = $_POST['topic'];
			$messtext = $_POST['messtext'];
			$messtime = date('H:i d.m.Y', time() + 3600);
			$nowmessage = "INSERT INTO message (id_recipient, id_sender, login_recipient, login_sender, topic, messtext, messtime, viewed) VALUES ('$id_rec', '$id_sen', '$login_rec', '$login_sen', '$topic', '$messtext', '$messtime', '0')";
			mysqli_query(hostopen(), $nowmessage);
			?>
			<script>alert('Сообщение отправлено')</script>
			<?php
		}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="shortcut icon" type="image\x-icon" href="image/favicon.ico">
	<link rel="stylesheet" type="text/css" href="css/generalCss.css">
	<style type="text/css">
		input, select {
			margin: 2px;
		}
		textarea {
			margin: 2px;
			resize: horizontal;
			height: 200px;
			width: 300px;
			min-width: 200px;
		}
	</style>
	<title>Написание сообщения</title>
	<meta name="robots" content="noindex, nofollow">
	<noscript><meta http-equiv="refresh" content="0.1;noscript.html"></noscript>
</head>
<body>
	<?php
		// Навигация и выход
		require "navigation.php";
	?>

	<!-- форма для написания сообщения !-->
	<form action="" method="POST">
		<fieldset>
		<legend>Написать сообщение</legend>
	<?php

			// при заходе на страницу через профиль получателя
			if(isset($_GET['login'])) { 
				$login = $_GET['login'];
				echo "<input type='text' name='login' value='$login' readonly><br>";
			}

			// список всех пользователей
			else { 
				$userslog = "SELECT login FROM users WHERE id>'$id' OR id<'$id'";
				$users = mysqli_query(hostopen(), $userslog);
				?>
				<select required name="login">
				<?php
				foreach($users as $elem1) {
					foreach($elem1 as $arr) {
					echo "<option>".$arr."</option>";
					}
				}
				?>
				</select><br>
				<?php
			}
	?>
		<input type="text" name="topic" required maxlength="30" placeholder="Тема сообщения"><br> 
		<textarea required placeholder="Текст сообщения" name="messtext"></textarea><br>
		<input type="submit" name="">
		</fieldset>
	</form>
	<?php 
		}
	?>
</body>
</html>