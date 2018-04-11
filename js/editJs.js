function edit() {
	var selected = document.querySelector("select").value;
	var login = document.querySelector("legend").innerHTML.replace(/^.+ \((.+)\)$/, "$1");
	var test = confirm("Сменить статус пользователя " + login + " на " + selected + "?");
	if(test == true) {
		ajax("php/editAjax.php", login + "(<?php echo $result2['status'] ?>)", "editStatus");
	}
	else {
		alert("Отмена операции");
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
			location.reload();
		}
		else if(xhr.status != 200 && xhr.readyState == 4) {
			alert("Error " + xhr.status);
		}
	}
}