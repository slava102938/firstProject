<?php // Регистрация
session_start();

	require "php/connectBD.php";

	// список городов
	$countrie = "SELECT * FROM countries WHERE id>0";
	$countriesArray = mysqli_query(hostopen(), $countrie);

	// список языков
	$langs = "SELECT * FROM langs WHERE id>0";
	$langsArray = mysqli_query(hostopen(), $langs);

	// генерация рандомного кода
	function genCode() { 
		$AlphabeT = range('A', 'Z');
		$alphabet = range('a', 'z');
		$number = range(1, 9);
		$saltarray = array_merge($AlphabeT, $alphabet, $number);
		$passNumb = mt_rand(10, 15);
		$salt = '';
		for($b = 1; $b<=$passNumb; $b++) {
			$randomSymbol = mt_rand(0, 60);
			$salt .= $saltarray[$randomSymbol];
		}
		return $salt;
	}

	// код для регистрации пользователя
	if(isset($_POST['newlogin'])) { 
		$salt = genCode();
		$newlogin = $_POST['newlogin'];
		$newpassword = $_POST['newpassword1'];
		$newpassword2 = md5($newpassword.$salt);
		$newname = $_POST['newname'];
		$newlastname = $_POST['newlastname'];
		$newemail = $_POST['newemail'];
		$newregistr = date("d.m.Y");

		foreach($countriesArray as $countriesArray2) {
			if($countriesArray2['countrie'] == $_POST['newcountrie']) {
				$newcountrie = $countriesArray2['id'];
			}
		}
		foreach($langsArray as $langsArray2) {
			if($langsArray2['lang'] == $_POST['newlang']) {
				$newlang = $langsArray2['id'];
			}
		}

		$newuser = "INSERT INTO users (status, baned, login, password, salt, name, lastname, email, registr, countrieId, langId) VALUES ('1', '0', '$newlogin', '$newpassword2', '$salt', '$newname', '$newlastname', '$newemail', '$newregistr', '$newcountrie', '$newlang')";
		mysqli_query(hostopen(), $newuser);
		header("refresh:0.5;registrationReady.html");
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="shortcut icon" type="image\x-icon" href="image/favicon.ico">
		<title>Регистрация</title>
		<link rel="stylesheet" type="text/css" href="css/registrationCss.css">
		<meta name="robots" content="noindex, nofollow">
		<noscript><meta http-equiv="refresh" content="0.1;noscript.html"></noscript>
	</head>
	<body>
		<div id="form">
			<form action="" method="POST"> 
				<fieldset class="formRegistr">
					<legend>Форма регистрации</legend>
					<div><input type="text" name="newlogin" data-form_ready="0" placeholder="Введите логин">
						<span>Логин должен иметь от 4 до 15 символов(a-zA-Z0-9_-)</span></div>
					<div><input type="text" name="newemail" data-form_ready="0" placeholder="Введите эмайл">
						<span>Введите ваш почтовый адрес</span></div>
					<div><input type="password" name="newpassword1" data-form_ready="0" placeholder="Введите пароль">
						<span>Количество символов в пароле должно быть от 6 до 20</span></div>
					<div><input type="password" disabled="true" name="newpassword2" data-form_ready="0" placeholder="Повторите пароль">
						<span>Количество символов в пароле должно быть от 6 до 20</span></div>
					<label><input type="checkbox">Показать пароль</label><br>
					<div><input type="text" name="newname" data-form_ready="0" placeholder="Введите имя">
						<span>Пишите ваше имя русскими или латинскими буквами до 20 символов</span></div>
					<div><input type="text" name="newlastname" data-form_ready="0" placeholder="Введите фамилию">
						<span>Пишите вашу фамилию русскими или латинскими буквами до 20 символов</span></div>
					<select name="newcountrie" data-form_ready="0">
						<option>Укажите вашу страну</option>
						<?php
							foreach($countriesArray as $array1) {
								echo "<option>".$array1["countrie"]."</option>";
							}
						?>
					</select><br>
					<select name="newlang" data-form_ready="0">
						<option>Укажите ваш язык</option>
						<?php 
							foreach($langsArray as $langsArray1) {
								echo "<option>".$langsArray1["lang"]."</option>";
							}
						?>
					</select><br>
					<input type="submit" value="Зарегистрироваться" disabled>
					<input type="reset" onclick="notShowPass()"><br>
				</fieldset>
			</form>

			<fieldset class="formPassword">
				<legend>Генератор пароля</legend>
				<input type="text" class="generator" readonly=""><br>
				<button onmouseup="genCode(); return false">Сгенерировать</button>
			</fieldset>
				
			<a href="index.php">Главная</a>
		</div>

		<script async src="js/registrationJs.js"></script>
	</body>
</html>