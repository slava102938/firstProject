// Выравнивает форму входа по высоте в центре
var windowHeight = Math.max(document.body.scrollHeight, document.body.offsetHeight, document.body.clientHeight, document.documentElement.scrollHeight, document.documentElement.offsetHeight, document.documentElement.clientHeight);
document.querySelector("main").style.height = windowHeight + "px";

// Меняет инпут с паролем на текстовый инпут и обратно
function showPass() {
	var inputPass = document.getElementById("pass");
	var label = document.querySelector("label:nth-of-type(1)");
	audio = new Audio();
	if(inputPass.type == "password") {
		inputPass.type = "text";
		label.style.backgroundImage = "url('image/openPassword.jpg')";
		audio.src = "sound/Isee.wav";
		audio.autoplay = true;
	}
	else {
		inputPass.type = "password";
		label.style.backgroundImage = "url('image/closePassword.jpg')";
	}
}

function notShowPass() {
	var inputPass = document.getElementById("pass");
	inputPass.type = "password";
}

function saveUser(){
	var label = document.querySelector("label:nth-of-type(2)");
	audio = new Audio();
	if(label.style.backgroundImage == 'url("image/saveUser.jpg")'){
		label.style.backgroundImage = "url('image/noSaveUser.jpg')";
	}
	else{
		label.style.backgroundImage = "url('image/saveUser.jpg')";
		audio.src = "sound/saveUser.wav";
		audio.autoplay = true;
	}
}