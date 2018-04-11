var idInput = document.querySelector("[name='userid']");
var nameInput = document.querySelector("[name='username']");

function showInfo() {
	if(idInput.value.length > 0) {
		ajax("php/adminAjax.php", idInput.value, "id");
	}
	else if(nameInput.value.length > 0) {
		ajax("php/adminAjax.php", nameInput.value, "name");
	}
	else {
		alert("Вы не ввели данные");
	}
}

function ajax(url, object, name) {
	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	data = name + "=" + encodeURIComponent(object);
	xhr.send(data);
	return xhr.onreadystatechange = function() {
		if(xhr.status == 200 && xhr.readyState == 4) {
			handler(xhr.responseText);
		}
		else if(xhr.status != 200 && xhr.readyState == 4) {
			alert("Error " + xhr.status);
		}
	}
}

function banedUser(login) {
	var baned = /\(0\)/.test(login);
	var test;
	if(baned == 1) {
		test = confirm("Забанить пользователя " + login + "?");
	}
	else {
		test = confirm("Разбанить пользователя " + login + "?");
	}
	
	if(test == true) {
		ajax("php/adminAjax.php", login, "banedLogin");
	}
	else {
		alert("Отмена операции");
	}
}

function handler(info) {
	if(info == "false") {
		alert("Данные не найдены");
	}
	else if(info == undefined) {
	}
	else if(info == "return") {
		location.reload();
	}
		else {
		alert(info.replace(/<br>/g, '\n'));
	}
}

function deleteUser(login) {
	var test = confirm("Удалить аккаунт " + login + "?");
	if(test == true) {
		ajax("php/adminAjax.php", login, "deleteLogin");
	}
	else {
		alert("Отмена операции");
	}
}