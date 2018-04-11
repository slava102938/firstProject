<?php // Редактирование пользователя администратором
session_start();

	// если зайти на страницу без введённых данных
	if(!isset($_SESSION['id'])) { 
		header("refresh:0.1;index.php");
	}

	// если попытаеться зайти не администратор
	elseif($_SESSION['status'] != '10') { 
		header("refresh:0.1;profile.php");
	}
	else {

		require "php/connectBD.php";
		require "php/ifBaned.php";
		require "php/exit.php";

		// ID пользователя, данные которого будут отредактированны
		$userId = $_GET['id'];

		// сбор данных пользователя
		$editUser = "SELECT login,status FROM users WHERE id='$userId'";
		$result = mysqli_query(hostopen(), $editUser);
		foreach($result as $result2) {
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
			margin: 1px;
		}
	</style>
	<title>Редактирование пользователя</title>
	<meta name="robots" content="noindex, nofollow">
	<noscript><meta http-equiv="refresh" content="0.1;noscript.html"></noscript>
</head>
<body>

	<?php 
	// Навигация и выход
	require "navigation.php";
	?>

	<form action="" method="POST"> 
		<fieldset>
			<legend>Редактирование (<?php echo $result2['login'] ?>)</legend>
				Статус:
				<select name="editStatus">
					<option <?php if($result2['status'] == 1) echo 'selected' ?>>Пользователь</option>
					<option <?php if($result2['status'] == 10) echo 'selected' ?>>Администратор</option>
				</select><br>
			<input type="submit" value="Редактировать" onclick="edit(); return false;">
		</fieldset>
	</form>
	<?php 
		}
	?>
	<script async src="editJs.js"></script>
</body>
</html>