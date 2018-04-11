<?php // Главная страница (network)
session_start();

	require "php/connectBD.php";
	

	// Вход на страницу
	if(isset($_POST['login'])) {
		$login = $_POST['login'];
		$inquiryBD = "SELECT * FROM users WHERE login='$login'";
		$resultArray = mysqli_query(hostopen(), $inquiryBD);
		foreach($resultArray as $result) {
		}
		
		if(isset($_SESSION['id']) or (isset($_COOKIE['login']) and testCookie($_COOKIE['login'], $_COOKIE['cookie']) == true) or (isset($_POST['login']) and testData($_POST['login'],$_POST['email'],$_POST['password']) == true)) {
			if($result['baned'] == 0) {
				if(!isset($_SESSION['id'])) {
					$_SESSION['id'] = $result['id'];
					$_SESSION['cookkod'] = genCode();
				}
				if(isset($_POST['savecookie'])) {
					$_SESSION['savecookie'] = $_POST['savecookie'];
				}
				header("refresh:0.1;url='profile.php'");
			}
			else {
				?>
				<script>alert('Вы были забанены')</script>
				<?php
			}
		}
		else { 
			if(isset($_POST['login']) and testData($_POST['login'],$_POST['email'],$_POST['password']) != true) {
				?>
				<script>alert('Неверно введён логин, пароль или электронная почта. Попытайтесь еще раз')</script>
				<?php
			}
		}
	}

	// Функция для проверки пользователя в базе данных
	function testData($login,$email,$password) {
		global $result;
		if(!empty($result)) {
			$salt = $result['salt'];
			$saltresult = md5($password.$salt);
			if($result['email'] == $email and $result['password'] == $saltresult) {
				return true;
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
	}

	// Проверка созданных куки
	function testCookie($login, $cookie) {
		$inquiryBD = "SELECT cookie FROM users WHERE login='$login'";
		$resultArray = mysqli_query(hostopen(), $inquiryBD);
		foreach($resultArray as $result) {
		}
		if(!empty($result)) {
			if($result['cookie'] == $cookie) {
				return true;
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
	}

	// Генерация рандомного кода
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
?>
<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
		<title>Главная</title>
		<link rel="stylesheet" type="text/css" href="css/indexCss.css">
		<style>
			[type="submit"]{
				color: #9FEE00;
			}
			[type="reset"]{
				color: #FB000D;
			}
		</style>
		<meta name="robots" content="noindex, nofollow">
		<noscript><meta http-equiv="refresh" content="0.1;noscript.html"></noscript>
	</head>
	<body>
	<span onclick="showNote()">!!!Можно нажать!!!</span>
	<div class="note" style="display: none;">Все фоновые картинки на сайте были скачаны с бесплатного источника!</div>

	<div id="form">
		<form action="" method="POST"> 
			<fieldset>
			<legend>Форма авторизации</legend>
			<input type="text" name="login" placeholder="Введите логин" required minlength="4" maxlength="15" value="<?php if(isset($_POST['login'])) echo $_POST['login'] ?>"><br>
			<input type="email" name="email" placeholder="Введите эмайл" required value="<?php if(isset($_POST['email'])) echo $_POST['email'] ?>"><br>
			<input id="pass" type="password" name="password" placeholder="Введите пароль" required minlength="6" maxlength="20"><br>
			<label><input type="checkbox" onclick="showPass()">Показать пароль</label><br>
			<label><input type="checkbox" name="savecookie" <?php if(isset($_POST['savecookie'])) { ?> checked <?php } ?>>Запомнить меня</label><br>
			<input type="submit" name="" value="Войти">
			<input type="reset" onclick="notShowPass()"><br>
			</fieldset>
		</form>
		<a href="registration.php">Регистрация</a>
		<a href="recovery.php">Забыл пароль</a><br>
		<span class="email">При любых ошибках писать на эл. почту: <a href="mailto:slava102938@inbox.lv">slava102938@inbox.lv</a><span>
	</div>
	<script asyns src="js/indexJs.js"></script>
	</body>
</html>