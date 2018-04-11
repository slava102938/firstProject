<!DOCTYPE html>
<html>
<head>
	<title>Восстановление аккаунта</title>
	<style>
		@font-face {
			font-family: "WebFont";
			src: url("font.ttf");
		}
		body, input{
			font-family: "WebFont", Arial, sans-serif;
		}

		body{
			background-image: url("image/index.jpg");
		}

		form {
			width: 600px;
			margin: auto;
			text-align: center;
		}
		fieldset {
			border-radius: 40px;
			border-color: #FF4900;
		}
		legend {
			color: #FF4900;
		}
		span {
			color: #FF4900;
		}
		input{
			margin: 5px;
			padding: 5px;
			border-width: 1.5px;
			border-radius: 10px;
			outline: none;
			border-color: #FF4900;
			color: #9FEE00;
			box-sizing: border-box;
			background-color: black;
		}
		[type="email"] {
			width: 180px;
			transition: width 0.5s ease;
		}
		[type="email"]:focus {
			width: 250px;
		}
		a {
			text-decoration: none;
			color: #FB000D;
			background-color: white;
			border: 2px solid #FB000D;
			border-radius: 8px;
			padding: 0px 5px;
			background-color: black;
		}
	</style>
</head>
<body>
	<form>
		<fieldset>
			<legend>Восстановление аккаунта</legend>
			<span>Введите ваш электронный почтовый адрес:</span><br>
			<input type="email" placeholder="Поле ввода"><br>
			<input type="button" value="Вспомнить!" onclick="testEmail()"><br>
			<a href="index.php">Я уже всё вспомнил!</a>
		</fieldset>
	</form>
	<script>
		// Выравнивает форму входа по высоте в центре
		var windowHeight = Math.max(document.body.scrollHeight, document.body.offsetHeight, document.body.clientHeight, document.documentElement.scrollHeight, document.documentElement.offsetHeight, document.documentElement.clientHeight);
		var divForm = document.querySelector("form");
		var formHeight = Math.max(divForm.offsetHeight, divForm.clientHeight);
		var marginFormTop = (windowHeight - formHeight) / 2;
		divForm.style.marginTop = marginFormTop + "px";

		//проверка формы на правильность введения почтового адреса
		function testEmail()
		{
			var email = document.querySelector("[type='email']");
			if(/^[01-9a-zA-Z._\-]+@[a-zA-Z1-9]+\.[a-zA-z]{1,3}$/.test(email.value))
				ajax("php/recoveryAjax.php", email.value, "email");
			else
				alert("Почтовый адрес введён неверно");
		}

		function ajax(url, object, name) {
			var xhr = new XMLHttpRequest();
			xhr.open("POST", url, true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			data = name + "=" + encodeURIComponent(object);
			xhr.onreadystatechange = function() {
				if(xhr.status == 200 && xhr.readyState == 4) {
					/*if(xhr.responseText == "false")
						alert("Почтовый адрес введён неверно. Перезагузите страницу и попытайтесь ещё раз");
					if(xhr.responseText == "true")
						alert("На ваш почтовый адрес отправлено письмо с восстановление аккаунта");*/
					res(xhr.responseText);
				}
				else if(xhr.status != 200 && xhr.readyState == 4) {
					alert("Error " + xhr.status);
				}
			}
			xhr.send(data);
		}

		function res(res) {
			if(res == "true")
				alert("На ваш почтовый адрес отправлено письмо с восстановление аккаунта");
			else
				alert("Почтовый адрес введён неверно. Перезагузите страницу и попытайтесь ещё раз");
		}
	</script>
</body>
</html>