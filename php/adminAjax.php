<?php 
require 'connectBD.php';

if(isset($_POST['id'])) {
	$id = $_POST['id'];
	$searchId = "SELECT *, users.id as id_user, countries.id as id_countries, langs.id as id_langs FROM users INNER JOIN countries ON users.countrieId=countries.id INNER JOIN langs ON users.langId=langs.id WHERE users.id='$id'";
	$idArray = mysqli_query(hostopen(), $searchId);
	foreach($idArray as $resultId) {
	}
	if(!empty($resultId)) {
		echo 'Результат по заданному id<br>';
		echo 'ID: '.$resultId['id_user'].'<br>';
		echo 'Логин: '.$resultId['login'].'<br>';
		echo 'Эмайл: '.$resultId['email'].'<br>';
		echo 'Имя: '.$resultId['name'].'<br>';
		echo 'Фамилия: '.$resultId['lastname'].'<br>';
		echo 'Дата регистрации: '.$resultId['registr'].'<br>';
		echo 'Страна: '.$resultId['countrie'].'<br>';
		echo 'Язык: '.$resultId['lang'];
	}
	else {
		echo "false";
	}
}

if(isset($_POST['name'])) {
	$name = $_POST['name'];
	$searchName = "SELECT *, users.id as id_user, countries.id as id_countries, langs.id as id_langs FROM users INNER JOIN countries ON users.countrieId=countries.id INNER JOIN langs ON users.langId=langs.id WHERE users.login='$name'";
	$nameArray = mysqli_query(hostopen(), $searchName);
	foreach($nameArray as $resultName) {
	}
	if(!empty($resultName)) {
		echo 'Результат по заданному логину<br>';
		echo 'ID: '.$resultName['id_user'].'<br>';
		echo 'Логин: '.$resultName['login'].'<br>';
		echo 'Эмайл: '.$resultName['email'].'<br>';
		echo 'Имя: '.$resultName['name'].'<br>';
		echo 'Фамилия: '.$resultName['lastname'].'<br>';
		echo 'Дата регистрации: '.$resultName['registr'].'<br>';
		echo 'Страна: '.$resultName['countrie'].'<br>';
		echo 'Язык: '.$resultName['lang'];
	}
	else {
		echo "false";
	}
}

if(isset($_POST['banedLogin'])) {
	$login = $_POST['banedLogin'];
	$baned = preg_match('#\(0\)#', $login);
	$loginUser = preg_replace('#^(.+)\([01]\)$#', "$1", $login);
	if($baned == 1) {
		$baned = "UPDATE users SET baned='1' WHERE login='$loginUser'";
	}
	else {
		$baned = "UPDATE users SET baned='0' WHERE login='$loginUser'";
	}
	mysqli_query(hostopen(), $baned);
	echo "return";
}

if(isset($_POST['deleteLogin'])) {
	$login = $_POST['deleteLogin'];
	$delete = "DELETE FROM users WHERE login='$login'";
	mysqli_query(hostopen(), $delete);
	echo "return";
}
?>