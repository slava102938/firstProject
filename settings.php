<?php // Настройки
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
		$infoid = "SELECT name,lastname,langId,countrieId FROM users WHERE id='$id'";
		$elem = mysqli_query(hostopen(), $infoid);
		foreach($elem as $result) {
		}

		// список городов
		$country = "SELECT * FROM countries WHERE id>0";
		$countriesArray = mysqli_query(hostopen(), $country);

		// список языков
		$langs = "SELECT * FROM langs WHERE id>0";
		$langsArray = mysqli_query(hostopen(), $langs);

		// смена обычных данных
		if(isset($_POST['name'])) { 
			$name = $_POST['name'];
			$lastname = $_POST['lastname'];
			foreach($countriesArray as $array2) {
				if($array2['countrie'] == $_POST['countrie']) {
					$countrie = $array2['id'];
				}
			}
			foreach($langsArray as $langsArray2) {
				if($langsArray2['lang'] == $_POST['lang']) {
					$lang = $langsArray2['id'];
				}
			}
			
			$nowinfo = "UPDATE users SET name='$name',lastname='$lastname',countrieId='$countrie',langId='$lang' WHERE id='$id'";
			mysqli_query(hostopen(), $nowinfo);
			$_SESSION['name'] = $name;
			$_SESSION['lastname'] = $lastname;
			$_SESSION['countrie'] = $_POST['countrie'];
			$_SESSION['lang'] = $_POST['lang'];
		}

		// смена пароля
		if(isset($_POST['chpass1'])) { 
			if(md5($_POST['chpasspass'].$_SESSION['salt']) == $_SESSION['password']) {
				if($_POST['chpass1'] == $_POST['chpass2']) {
					$nowpassword = md5($_POST['chpass1'].$_SESSION['salt']);
					$resultpass = "UPDATE users SET password='$nowpassword' WHERE id='$id'";
					mysqli_query(hostopen(),$resultpass);
					$_SESSION['password'] = $nowpassword;
				}
				else {
					?>
						<script>alert('Пароли не совпадают')</script>
					<?php
				}
			}
			else {
				?>
					<script>alert('Неверно введён старый пароль')</script>
				<?php
			}
		}

		// смена логина
		if(isset($_POST['chlog'])) { 
			if($_SESSION['password'] == md5($_POST['chlogpass'].$_SESSION['salt'])) {
				if(proverkalogin($_POST['chlog']) == true) {
					$nowlogin = $_POST['chlog'];
					$resultlog = "UPDATE users SET login='$nowlogin' WHERE id='$id'";
					mysqli_query(hostopen(),$resultlog);
					$_SESSION['login'] = $nowlogin;
				}
				else {
					?>
					<script>alert('Такой логин уже существует')</script>
					<?php
				}
			}
			else {
				?>
					<script>alert('Неправильно введён пароль')</script>
				<?php
			}
		}

		// смена эмайла
		if(isset($_POST['chemail'])) { 
			if(md5($_POST['chemailpass'].$_SESSION['salt']) == $_SESSION['password']) {
				if(proverkaemail($_POST['chemail']) == true) {
					$nowemail = $_POST['chemail'];
					$resultemail = "UPDATE users SET email='$nowemail' WHERE id='$id'";
					mysqli_query(hostopen(),$resultemail);
					$_SESSION['email'] = $nowemail;
				}
				else {
					?>
						<script>alert('Такой эмайл уже существует')</script>
					<?php
				}
			}
			else {
				?>
					<script>alert('Неверно введён пароль')</script>
				<?php
			}
		}

		// удаление аккаунта
		if(isset($_POST['delete'])) { 
			if(md5($_POST['delete'].$_SESSION['salt']) == $_SESSION['password']) {
				$delete = "DELETE FROM users WHERE id='$id'";
				mysqli_query(hostopen(),$delete);
				setcookie('login', '', time());
				setcookie('cookie', '', time());
				session_destroy();
				header("refresh:0.1;url='index.php'");
			}
			else {
				?>
					<script>alert('Пароль введён неверно')</script>
				<?php
			}
		}

		// функция для проверки одинаковых логинов
		function proverkalogin($login) { 
			$proces = "SELECT login FROM users WHERE login='$login'";
			$d = mysqli_query(hostopen(), $proces);
			foreach($d as $elem) {
			}
			if(!empty($elem)) {
				return false;
			}
			else {
				return true;
			}
		}

		// функция для проверки одинаковых эмайлов
		function proverkaemail($email) { 
			$proces = "SELECT email FROM users WHERE email='$email'";
			$d = mysqli_query(hostopen(), $proces);
			foreach($d as $elem) {
			}
			if(!empty($elem)) {
				return false;
			}
			else {
				return true;
			}
		}

		if(isset($_SESSION['countrieId'])) {
			$sss = $_SESSION['countrieId'];
			unset($_SESSION['countrieId']);
		}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="shortcut icon" type="image\x-icon" href="image/favicon.ico">
	<link rel="stylesheet" type="text/css" href="css/generalCss.css">
	<style type="text/css">
		input {
			margin: 1px;
		}
	</style>
	<title>Настройки</title>
	<meta name="robots" content="noindex, nofollow">
	<noscript><meta http-equiv="refresh" content="0.1;noscript.html"></noscript>
</head>
<body>

	<?php 
	// Навигация и выход
	require "navigation.php";
	?>

	<!-- Настройки !-->
	<form action="" method="POST"> 
		<fieldset>
			<legend>Обычные данные</legend>
			<table>
				<tr>
					<td>Ваше имя:</td>
					<td><input type="text" name="name" required value="<?php echo $_SESSION['name'] ?>"></td>
				</tr>
				<tr>
					<td>Ваша фамилия:</td>
					<td><input type="text" name="lastname" required value="<?php echo $_SESSION['lastname'] ?>"></td>
				</tr>
				<tr>
					<td>Ваша страна:</td>
					<td><select name="countrie" required value="<?php echo $_SESSION['countrie'] ?>">
						<?php 
							foreach($countriesArray as $array1) {
								if($array1['id'] == $result['countrieId']) {
									echo "<option selected>".$array1["countrie"]."</option>";
								}
								else {
									echo "<option>".$array1["countrie"]."</option>";
								}
							}
						?>
					</select></td>
				</tr>
				<tr>
					<td>Ваш язык:</td>
					<td>
						<select name="lang" required>
							<?php 
								foreach($langsArray as $langsArray1) {
									if($langsArray1['id'] == $result['langId']) {
										echo "<option selected>".$langsArray1["lang"]."</option>";
									}
									else {
										echo "<option>".$langsArray1["lang"]."</option>";
									}
								}
							?>
						</select>
					</td>
				</tr>
			</table>
			<input type="submit" value="Сохранить">
		</fieldset>
	</form>
	<form action="" method="POST">
		<fieldset>
			<legend>Сменить логин</legend>
			<input type="text" name="chlog" placeholder="Введите новый логин" minlength="4" maxlength="14" required value="<?php if(isset($_POST['chlog'])) echo $_POST['chlog'] ?>"><br>
			<input type="password" name="chlogpass" placeholder="Введите пароль" minlength="6" maxlength="20" required><br>
			<input type="submit" name="" value="Сменить">
		</fieldset>
	</form>
	<form action="" method="POST">
		<fieldset>
			<legend>Сменить пароль</legend>
			<input type="password" name="chpasspass" placeholder="Введите старый пароль" minlength="6" maxlength="20" required><br>
			<input type="password" name="chpass1" placeholder="Введите новый пароль" minlength="6" maxlength="20" required><br>
			<input type="password" name="chpass2" placeholder="Повторите новый пароль" minlength="6" maxlength="20" required><br>
			<input type="submit" name="" value="Сменить">
		</fieldset>
	</form>
	<form action="" method="POST">
		<fieldset>
			<legend>Сменить эмайл</legend>
			<input type="email" name="chemail" placeholder="Введите эмайл" value="<?php if(isset($_POST['chemail'])) echo $_POST['chemail'] ?>"><br>
			<input type="password" name="chemailpass" placeholder="Введите пароль" minlength="6" maxlength="20" required><br>
			<input type="submit" name="" value="Сменить">
		</fieldset>
	</form>
	<form action="" method="POST">
		<fieldset>
			<legend>Удалить страницу</legend>
			<input type="password" name="delete" placeholder="Введите пароль" minlength="6" maxlength="20" required><br>
			<input type="submit" name="" value="Удалить">
		</fieldset>
	</form>
	<?php
		}
	?>
</body>
</html>