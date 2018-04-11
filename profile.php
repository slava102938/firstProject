<?php // Профиль пользователя
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
	$infoid = "SELECT *, users.id as id_users, countries.id as id_countries, langs.id as id_langs FROM users INNER JOIN countries ON users.countrieId=countries.id INNER JOIN langs ON users.langId=langs.id WHERE users.id='$id'";
	$elem = mysqli_query(hostopen(), $infoid);
	foreach($elem as $result) {
	}

	$_SESSION['login'] = $result['login'];
	$_SESSION['email'] = $result['email'];
	$_SESSION['name'] = $result['name'];
	$_SESSION['lastname'] = $result['lastname'];
	$_SESSION['registr'] = $result['registr'];
	$_SESSION['countrie'] = $result['countrie'];
	$_SESSION['lang'] = $result['lang'];
	$_SESSION['password'] = $result['password'];
	$_SESSION['salt'] = $result['salt'];
	$_SESSION['status'] = $result['status'];

	// создание кук
	if(isset($_SESSION['savecookie'])) { 
		$cooklogin = $_SESSION['login'];
		$cookkod = $_SESSION['cookkod'];
		$cookienow = "UPDATE users SET cookie='$cookkod' WHERE login='$cooklogin'";
		mysqli_query(hostopen(), $cookienow);
		setcookie('login', $cooklogin, time() + 3600*24*31);
		setcookie('cookie', $cookkod, time() + 3600*24*31);
		unset($_SESSION['savecookie'], $_SESSION['cookkod']);
	}
?>
<!DOCTYPE html> 
<html>
	<head>
	<meta charset="utf-8">
	<link rel="shortcut icon" type="image\x-icon" href="image/favicon.ico">
	<link rel="stylesheet" type="text/css" href="css/generalCss.css">
		<?php 
			echo "<title>".$result['name']." ".$result['lastname']."</title>";
		?>
	<meta name="robots" content="noindex, nofollow">
	<noscript><meta http-equiv="refresh" content="0.1;noscript.html"></noscript>
	</head>
	<body>
		<?php
		// Навигация и выход
		require "navigation.php";

		// вывод данных пользователя
		echo 'Добро пожаловать на вашу страницу<br>'; 
			echo 'Ваш профиль:<br>';
			echo 'Ваш id: '.$result['id_users'].'<br>';
			echo 'Ваш логин: '.$result['login'].'<br>';
			echo 'Ваш эмайл: '.$result['email'].'<br>';
			echo 'Ваше имя: '.$result['name'].'<br>';
			echo 'Ваша фамилия: '.$result['lastname'].'<br>';
			echo 'Дата вашей регистрации: '.$result['registr'].'<br>';
			echo 'Ваша страна: '.$result['countrie'].'<br>';
			echo 'Ваш язык: '.$result['lang'].'<br>';

			// поле для админа
			if($result['status'] == '10') { 
				?>
				<a href="admin.php">Кабинет администратора</a>
				<?php
			}
		}
		?>
	</body>
</html>
