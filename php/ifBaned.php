<?php
// проверка забаненности пользователя
function ban($id) { 
	$ban = "SELECT baned FROM users WHERE id='$id'";
	$result = mysqli_query(hostopen(), $ban);
	foreach ($result as $arr) {
	}
	if($arr['baned'] == 0) {
		return true;
	}
	else {
		return false;
	}
}

// выход из страницы при бане пользователя
if(ban($_SESSION['id']) == false) {
	?>
	<script>alert('Вы были забанены')</script>
	<?php 
	$_POST['destroy'] = "Выйти";
}
?>