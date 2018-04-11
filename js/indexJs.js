// Выравнивает форму входа по высоте в центре
var windowHeight = Math.max(document.body.scrollHeight, document.body.offsetHeight, document.body.clientHeight, document.documentElement.scrollHeight, document.documentElement.offsetHeight, document.documentElement.clientHeight);
var divForm = document.getElementById("form");
var formHeight = Math.max(divForm.offsetHeight, divForm.clientHeight);
var marginFormTop = (windowHeight - formHeight) / 2;
divForm.style.marginTop = marginFormTop + "px";

// Меняет инпут с паролем на текстовый инпут и обратно
function showPass() {
	var inputPass = document.getElementById("pass");
	if(inputPass.type == "password") {
		inputPass.type = "text";
	}
	else {
		inputPass.type = "password";
	}
}

function notShowPass() {
	var inputPass = document.getElementById("pass");
	inputPass.type = "password";
}

function showNote() {
	var note = document.querySelector(".note");
	if(note.style.display == "none") {
		note.style.display = "inline-block";
	}
	else {
		note.style.display = "none";
	}
}