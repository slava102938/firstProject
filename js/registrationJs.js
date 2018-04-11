// Выравнивает форму регистрации по высоте в центре
var windowHeight = Math.max(document.body.scrollHeight, document.body.offsetHeight, document.body.clientHeight, document.documentElement.scrollHeight, document.documentElement.offsetHeight, document.documentElement.clientHeight);
var divForm = document.getElementById("form");
var formHeight = Math.max(divForm.offsetHeight, divForm.clientHeight);
var marginFormTop = (windowHeight - formHeight) / 2;
divForm.style.marginTop = marginFormTop + "px";

var inputs = document.querySelectorAll("[placeholder], select");
for(var rr = 0; rr < inputs.length; rr++) {
	inputs[rr].addEventListener("change", formReady);
}

var password1 = document.querySelector("[name='newpassword1']");
var password2 = document.querySelector("[name='newpassword2']");
var fieldset = document.querySelector(".formRegistr");
var submit = document.querySelector("[type='submit']");
var reset = document.querySelector("[type='reset']");
var passwordShow = document.querySelector("[type='checkbox']");
var info = document.querySelector("#info");

// Генерация рандомного кода
function genCode() {
	var arrayCode = [];
	for(var number = 0; number < 10; number++) {
		arrayCode.push(number);
	}
	for(var lowerText = 65; lowerText < 91; lowerText++) {
		arrayCode.push(String.fromCharCode(lowerText).toLowerCase());
	}
	for(var upperText = 65; upperText < 91; upperText++) {
		arrayCode.push(String.fromCharCode(upperText));
	}
	var result = "";
	for(var count = 0; count < 13; count++) {
		result += arrayCode[Math.round(Math.random() * (arrayCode.length - 1))];
	}
	inputPassword = document.querySelector(".generator");
	inputPassword.value = result;
}

// Открывает кнопку регистрации при правильном заполнении формы
function openRegistration() {
	var open = 0;
	for(var jj = 0; jj < inputs.length; jj++) {
		if(inputs[jj].dataset.form_ready != "1") {
			open--;
		}
	}
	if(open == 0) {
		submit.removeAttribute('disabled');
		submit.style.borderColor = "green";
		submit.style.color = "green";

		reset.disabled = "true";
		reset.style.color = "grey";

		fieldset.style.borderColor = "green";
		fieldset.style.color = "green";
	}
	else {
		submit.disabled = "true";
		submit.style.borderColor = "red";
		submit.style.color = "grey";

		reset.removeAttribute('disabled');
		reset.style.color = "red";

		fieldset.style.borderColor = "orange";
		fieldset.style.color = "orange";
	}
}

// Показывает пароль
passwordShow.onclick = function() {
	if(inputs[2].type == "password") {
		inputs[2].type = "text";
		inputs[3].type = "text";
	}
	else {
		inputs[2].type = "password";
		inputs[3].type = "password";
	}
}

// Сбрасывает введённые данные и изменения
function notShowPass() {
	password1.type = "password";
	password2.type = "password";
	for(var rr = 0; rr < inputs.length; rr++) {
		inputs[rr].dataset.form_ready = "0";
	}
}

function ajax(url, object, name) {
	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	data = name + "=" + encodeURIComponent(object.value);
	xhr.onreadystatechange = function() {
		if(xhr.status == 200 && xhr.readyState == 4) {
			if(xhr.responseText == "true") {
				object.dataset.form_ready = "1";
			}
			else {
				object.dataset.form_ready = "-1";
				alert(xhr.responseText);
			}
		}
		else if(xhr.status != 200 && xhr.readyState == 4) {
			return "Error " + xhr.status;
		}
	}
	xhr.send(data);
}

// Проверяет форму на правильность введённых данных
function formReady() {
switch(this.name) {
	case "newlogin":
		var test = /^[a-zA-Z1-90_-]{4,15}$/.test(this.value);
		if(test == true) {
			ajax("php/registrationAjax.php", this, "newlogin");
			openRegistration();
		}
		else {
			this.dataset.form_ready = "-1";
			alert("Логин должен иметь от 4 до 15 символов(a-zA-Z0-9_-)");
		}
	break;
	case "newemail":
		test = /^[01-9a-zA-Z._\-]+@[a-zA-Z1-9]+\.[a-zA-z]{1,3}$/.test(this.value);
		if(test == true) {
			ajax("php/registrationAjax.php", this, "newemail");
			openRegistration();
		}
		else {
			this.dataset.form_ready = "-1";
			alert("Неправильно введён почтовый адрес");
		}
	break;
	case "newpassword1":
		if(this.value.length >= 6 && this.value.length <= 20) {
			this.dataset.form_ready = "1";
			password2.removeAttribute("disabled");
			if(password2.value.length > 0 && this.value != password2.value) {
				password2.dataset.form_ready = "-1";
			}
			if(password2.value.length > 0 && this.value == password2.value) {
				password2.dataset.form_ready = "1";
			}
			openRegistration();
		}
		else {
			this.dataset.form_ready = "-1";
			password2.disabled = "true";
			alert("Количество символов в пароле должно быть от 6 до 20");
			if(password2.value.length > 0) {
				password2.dataset.form_ready = "-1";
			}
		}
	break;
	case "newpassword2":
		if(password1.value == this.value) {
			this.dataset.form_ready = "1";
			openRegistration();
		}
		else {
			this.dataset.form_ready = "-1";
			alert("Пароли не совпадают");
		}
		
	break;
	case "newname":
		test = /^[А-Яа-яЁёA-Za-z]{1,20}$/.test(this.value);
		if(test == true) {
			this.dataset.form_ready = "1";
			openRegistration();
		}
		else {
			this.dataset.form_ready = "-1";
			alert("Пишите ваше имя русскими или латинскими буквами до 20 символов");
		}
	break;
	case "newlastname":
		test = /^[А-Яа-яЁёA-Za-z]{1,20}$/.test(this.value);
		if(test == true) {
			this.dataset.form_ready = "1";
			openRegistration();
		}
		else {
			this.dataset.form_ready = "-1";
			alert("Пишите вашу фамилию русскими или латинскими буквами до 20 символов");
		}
	break;
	case "newcountrie":
		if(this.value != "Укажите вашу страну") {
			this.dataset.form_ready = "1";
			openRegistration();
		}
		else {
			this.dataset.form_ready = "-1";
		}
	break;
	case "newlang":
		if(this.value != "Укажите ваш язык") {
			this.dataset.form_ready = "1";
			openRegistration();
		}
		else {
			this.dataset.form_ready = "-1";
		}
	break;
}
}