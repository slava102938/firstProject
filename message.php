<?php // Сообщения пользователя
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

		// удаление сообщения
		if(isset($_GET['id'])) { 
			$idmess = $_GET['id'];
			$search = "SELECT id_recipient, id_sender FROM message WHERE id='$idmess'";
			$resultdel = mysqli_query(hostopen(), $search);
			foreach($resultdel as $abc) {
			}
			if(!empty($abc)) {
				if($abc['id_recipient'] == $id or $abc['id_sender'] == $id) {
					$delete = "DELETE FROM message WHERE id='$idmess'";
					mysqli_query(hostopen(), $delete);
				}
			}
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
			width: 23%;
			border: 1px solid black;
			text-align: center;
		}
	</style>
	<title>Сообщения</title>
	<meta name="robots" content="noindex, nofollow">
	<noscript><meta http-equiv="refresh" content="0.1;noscript.html"></noscript>
</head>
<body>
	<?php 
	// Навигация и выход
	require "navigation.php";
	?>

	<b><a href="nowmessage.php">НАПИСАТЬ СООБЩЕНИЕ</a></b><br><br>

	<!-- Список сообщений !-->
	Полученные сообщения:<br>
	<table>
		<tr>
			<th>Логин отправителя</th>
			<th>Тема</th>
			<th>Время и дата</th>
			<th>Удалить</th>
		</tr>
	<?php

		// передаёт получаемые сообщения
		$recmessage = "SELECT login_sender,id,topic,viewed,messtime FROM message WHERE id>0 AND id_recipient='$id'"; 
		$recresult = mysqli_query(hostopen(),$recmessage);
		foreach($recresult as $elem1) {
			$i = 1;
			foreach($elem1 as $arr) {
				if($i==1) {
					echo "<tr><td>".$arr."</td>";
					$i++;
				}
				elseif($i==2) {
					echo "<td><a href='private_message.php?id=".$arr."'>";
					$messid = $arr;
					$i++;
				}
				elseif($i==3) {
					echo $arr."</a>";
					$i++;
				}
				elseif($i==4) {
					if($arr==0) {
						echo "<sub>новое</sub></td>";
						$i++;
					}
					else {
						echo "</td>";
						$i++;
					}
				}
				else {
					echo "<td>".$arr."</td>";
					echo "<td><a href='message.php?id=".$messid."'>Удалить</a></td></tr>";
					$i==1;
				}
			}
		}
		?>
		</table><br>

	Отправленные сообщения:<br>
	<table>
		<tr>
			<th>Логин получателя</th>
			<th>Тема</th>
			<th>Время и дата</th>
			<th>Удалить</th>
		</tr>
	<?php

		// показывает отправленные сообщения
		$senmessage = "SELECT login_recipient,id,topic,viewed,messtime FROM message WHERE id>0 AND id_sender='$id'"; 
		$senresult = mysqli_query(hostopen(),$senmessage);
		foreach($senresult as $elem2) {
			$m = 1;
			foreach($elem2 as $arr2) {
				if($m==1) {
					echo "<tr><td>".$arr2."</td>";
					$m++;
				}
				elseif($m==2) {
					echo "<td><a href='private_message.php?id=".$arr2."'>";
					$messid2 = $arr2;
					$m++;
				}
				elseif($m==3) {
					echo $arr2."</a>";
					$m++;
				}
				elseif($m==4) {
					if($arr2==1) {
						echo "<sub>просмотрено</sub></td>";
						$m++;
					}
					else {
						echo "</td>";
						$m++;
					}
				}
				else {
					echo "<td>".$arr2."</td>";
					echo "<td><a href='message.php?id=".$messid2."'>Удалить</a></td><tr>";
					$m==1;
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