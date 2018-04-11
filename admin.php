<?php // Кабинет администратора
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

		$id = $_SESSION['id'];

		$arrayUsers = "SELECT id,login,email,status,baned FROM users WHERE id>'$id' OR id<'$id'"; 
		$resultUsers = mysqli_query(hostopen(), $arrayUsers);
		$numberUsers = 1;
		$banedUsers = 0;
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
			width: 15%;
			border: 1px solid black;
			text-align: center;
		}
		input {
			margin: 1px;
		}

		button {
			background-color: #fdfc4f;
			border: none;
			font-weight: bolder;
			font-size: 15px;
			cursor: pointer;
		}
		table a {
			font-size: 15px;
			text-decoration: none;
			color: black;
		}
		table span {
			cursor: pointer;
		}
		table span:hover, table a:hover {
			text-decoration: underline;
		}
	</style>
	<title>Администрация</title>
	<meta name="robots" content="noindex, nofollow">
	<noscript><meta http-equiv="refresh" content="0.1;noscript.html"></noscript>
</head>
<body>
	<?php 
	// Навигация и выход
	require "navigation.php";
	?>
		<form method="POST" action="">
			Узнать данные пользователя<br>
			<input type="number" name="userid" placeholder="Введите id"><br>
			<input type="text" name="username" placeholder="Введите логин"><br>
			<input type="submit" value="Найти" onclick="showInfo();return false"><br>
		</form>

		<table>
			<tr>
				<th>ID</th>
				<th>Логин</th>
				<th>Эмайл</th>
				<th>Статус</th>
				<th>Забанить</th>
				<th>Удалить</th>
				<th>Редактировать</th>
			</tr>
		<?php
		// вывод списка пользователей для удаления, бана или редактирования
		foreach($resultUsers as $resultUsers2) {
			$numberUsers++;
			?>
			<tr>
				<td><?php echo $resultUsers2['id'] ?></td>
				<td><?php echo $resultUsers2['login'] ?></td>
				<td><?php echo $resultUsers2['email'] ?></td>
				<td><?php 
					if($resultUsers2['status'] == 1) {
						echo "Пользователь";
					}
					else {
						echo "Администратор";
					}
				 ?></td>
				<td><span onclick="banedUser('<?php echo $resultUsers2["login"],"(".$resultUsers2["baned"].")" ?>')"><?php
					if($resultUsers2['baned'] == 1) {
						echo "Разбанить";
						$banedUsers++;
					}
					else {
						echo "Забанить";
					}
				 ?></span></td>
				<td><span onclick="deleteUser('<?php echo $resultUsers2["login"] ?>')">Удалить</span></td>
				<td><a href="edit.php?id=<?php echo $resultUsers2['id'] ?>">Редактировать</a></td>
			</tr>
			<?php 
		}
		?>
		</table>
		<?php // количество пользователей и т.д.
		echo "<b>Пользователей: </b>".$numberUsers."<br>";
		echo "<b>Забаненных пользователей: </b>".$banedUsers."<br>";
	}
	?>
	<script async src="js/adminJs.js"></script>
</body>
</html>