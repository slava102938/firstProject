// размер окна
var scrollHeight = Math.max(
  document.body.scrollHeight, document.documentElement.scrollHeight,
  document.body.offsetHeight, document.documentElement.offsetHeight,
  document.body.clientHeight, document.documentElement.clientHeight
);

var table = document.querySelector("table");
var dot = 30;
var secondTime = 45;
var numberLevel = document.getElementById("changeLevel");
var main = document.querySelector("main");
var topic = 0;
var spanTable = document.getElementById("table");
var tableValue = document.getElementById("changeTable");
var cube = document.getElementById("cube");

// построение размера таблицы
function buildTable() {
	var col;
	var row;
	if(tableValue.value == "1") {
		col = 22;
		row = 5;
	}
	else if(tableValue.value == "2") {
		col = 28;
		row = 8;
	}
	else {
		col = 32;
		row = 10;
	}
	for(var r = 1; r < row; r++) {
		var ttr = document.createElement('tr');
		for(var t = 1; t < col; t++) {
			var ttd = document.createElement('td');
			ttr.appendChild(ttd);
		}
		table.appendChild(ttr);
	}

	ttr = document.createElement('tr');
	for(r = 1; r < ((col - 4) / 2); r++) { 
		ttd = document.createElement('td');
		ttr.appendChild(ttd);
	}

	var tth = document.createElement('th');
	tth.setAttribute("colspan", "2");
	ttr.appendChild(tth);

	tth = document.createElement('th');
	tth.setAttribute("colspan", "2");
	ttr.appendChild(tth);

	for(r = 1; r < (((col - 4) / 2) + 1); r++) {
		ttd = document.createElement('td');
		ttr.appendChild(ttd);
	}
	table.appendChild(ttr);

	for(r = 1; r < row + 1; r++) {
		ttr = document.createElement('tr');
		for(t = 1; t < col; t++) { // 22, , 32
			ttd = document.createElement('td');
			ttr.appendChild(ttd);
		}
		table.appendChild(ttr);
	}

	window.td = document.querySelectorAll("td");
	window.th = document.querySelectorAll("th");
}

// запускает игру
function start() {
	buildTable()
	main.style.display = "none";
	table.style.height = scrollHeight + "px";
	var anim;
	
	// выбор анимации для квадратов
	if(topic == "1") {
		anim = ['blackWhite1', 'blackWhite2', 'blackWhite1', 'blackWhite2'];
	}
	else if (numberLevel.value == "1" && topic != "1") {
		anim = ['animEase1', 'animEase2', 'animEase3', 'animEase4'];
	}
	else if (numberLevel.value != "1" && topic != "1") {
		anim = ['animHard1', 'animHard2', 'animHard3', 'animHard4'];
	}
	var second = ['1s', '1.25s', '1.5s', '1.75s', '2s', '2.25s', '2.5s', '2.75s', '3s'];
	var temp = ['linear', 'ease', 'ease-in', 'ease-out', 'ease-in-out'];
	// расстановка разного темпа для квадратов
	for(var i = 0; i < window.td.length; i++) {
		var secondResult = second[Math.round(Math.random() * 8)];
		var tempResult = temp[Math.round(Math.random() * 4)];
		window.td[i].style.animation = anim[Math.round(Math.random() * 3)] + " " + secondResult + " " + tempResult + " infinite";
		window.td[i].addEventListener("click", clickBlack);
	}
	// генерация точек
	creatureTable();
	startTime();
	startAudio();
}

// запуск аудио под уровень
function startAudio() {
	switch(numberLevel.value) {
		case "1":
		audio = new Audio();
		audio.src = "music/music1.mp3";
		audio.autoplay = true;
		break;
		case "2":
		audio = new Audio();
		audio.src = "music/music2.mp3";
		audio.autoplay = true;
		break;
		case "3":
		audio = new Audio();
		audio.src = "music/music3.mp3";
		audio.autoplay = true;
		break;
		case "4":
		audio = new Audio();
		audio.src = "music/music4.mp3";
		audio.autoplay = true;
		break;
	}
}

// генерация таблицы под уровень
function creatureTable() {
	switch(numberLevel.value) {
		case "1":
		for(var j = 0; j < 30;) {
			tdGame = window.td[Math.round(Math.random() * (window.td.length - 1))];
			if(tdGame.innerHTML != ".") {
				tdGame.innerHTML = ".";
				j++;
			}
		};
		window.th[0].innerHTML = "Секунд: " + secondTime;
		window.th[1].innerHTML = "Точек: " + dot;
		break;
		case "2":
		for(j = 0; j < 30;) {
			tdGame = window.td[Math.round(Math.random() * (window.td.length - 1))];
			if(tdGame.innerHTML != ".") {
				tdGame.innerHTML = ".";
				j++;
			}
		};
		window.th[0].innerHTML = "Секунд: " + secondTime;
		window.th[1].innerHTML = "Точек: " + dot;
		break;
		case "3":
		var simvol = ["!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "-", "_", "+", ":", ";", "~", "№", "?", "[", "]", "{", "}", "..", "..."];
		for(j = 0; j < 3;) {
			tdGame = window.td[Math.round(Math.random() * (window.td.length - 1))];
			if(tdGame.innerHTML != ".") {
				tdGame.innerHTML = ".";
				j++;
			}
		};
		for(j = 0; j < window.td.length; j++) {
			if(window.td[j].innerHTML == "") {
				window.td[j].innerHTML = simvol[Math.round(Math.random() * (simvol.length - 1))];
			}
		}
		window.th[0].innerHTML = "Секунд: " + secondTime;
		window.th[1].innerHTML = "Точек: " + dot;
		break;
		case "4":
		window.td[Math.round(Math.random() * (window.td.length - 1))].innerHTML = ":";
		for(j = 0; j < window.td.length; j++) {
			if(window.td[j].innerHTML == "") {
				window.td[j].innerHTML = ";";
			}
		}
		window.th[0].innerHTML = "Секунд: " + secondTime;
		window.th[1].innerHTML = "Двоеточий: " + dot;
		break;
	}
}

// запускает таймер для игры
function startTime() {
	window.times = window.setInterval(thTime, 1000);
}

// работа таймера и проигрыш
function thTime() {
	secondTime--;
	if(secondTime >= 0) {
		window.th[0].innerHTML = "Секунд: " + secondTime;
	}
	else {
		window.clearInterval(window.times);
		// отключение нажатия на кнопки
		for(var i = 0; i < window.td.length; i++) {
			window.td[i].removeEventListener("click", clickBlack);
			// подсветка квадратов с поисковым элементом
			if(window.td[i].innerHTML == "." || (window.td[i].innerHTML == ":" && numberLevel.value == "4")) {
				if(topic == 0) {
					window.td[i].style.boxShadow = "0px 0px 3px 3px black inset";
					window.td[i].style.color = "black";
				}
				else {
					window.td[i].style.boxShadow = "0px 0px 3px 3px #009999 inset";
					window.td[i].style.color = "#009999";
				}
			}
			window.td[i].style.animation = window.td[i].style.animation + " paused";
		}
		window.th[0].innerHTML = "GAME";
		window.th[1].innerHTML = "OVER";
	}
}

// нажатие на правильный квадрат и выйгрыш
function clickBlack() {
	if(this.innerHTML == "." || (this.innerHTML == ":" && numberLevel.value == "4")) {
		dot--;
		// анимация на квадрат после нажатия
		if(topic == 0) {
			this.style.animation = "tdClick 3s ease forwards";
		}
		else {
			this.style.animation = "tdBWClick 3s ease forwards";
		}
		this.removeEventListener("click", clickBlack);
		window.th[1].innerHTML = "Точек: " + dot;
		if(dot == 0) {
			window.clearInterval(window.times);
			// отключение нажатия на квадрат и пауза квадратов
			for(var i = 0; i < window.td.length; i++) {
				window.td[i].removeEventListener("click", clickBlack);
				window.td[i].style.animation = window.td[i].style.animation + " paused";
			}
			window.th[0].innerHTML = "YOU ARE";
			window.th[1].innerHTML = "PROF";
		}
	}
	else if((numberLevel.value == "3" && this.innerHTML != ".") || (numberLevel.value == "4" && this.innerHTML != ":")) {
		secondTime -= 5;
	}
}

// описание и изменение уровня
function level() {
	var spanLevel = document.getElementById("level");
	var pInfo = document.getElementById("info");
	switch(numberLevel.value) {
		case "1":
		spanLevel.innerHTML = "ПоЧТи оТСуТСТВие СЛоЖНоСТи";
		pInfo.innerHTML = "Супер лёгкий уровень в котором невозможно (почти) проиграть. На поле 30 точек, а секунд - 45. Никакой маскировки и обмана зрения. Только КОНТРАСТ";
		dot = 30;
		secondTime = 45;
		break;
		case "2":
		spanLevel.innerHTML = "НаЧиНаюЩиЙ СаПёР";
		pInfo.innerHTML = "Уровень для начинающего сапёра, который находит мину (или не мину) в земле, когда она замаскирована. На поле 30 точек, а секунд - 60. Обман зрения с маскировкой вернулись и будут путать вас до конца. Найди, если сможешь...";
		dot = 30;
		secondTime = 60;
		break;
		case "3":
		spanLevel.innerHTML = "СаМоМуЧиТеЛЬ МоЗГа";
		pInfo.innerHTML = "Только для тех, кто имеет иммунитет к головной боли, а глаза не болят от большого количество объектов. Точек всего 3 (одна точка на одну клетку), а времени - 30 секунд. Не перепутай точку с чем-нибудь... ошибки стоят дорого с этого момента...";
		dot = 3;
		secondTime = 30;
		break;
		case "4":
		spanLevel.innerHTML = "оСоБо оПаСеН";
		pInfo.innerHTML = "Для горстки особых людей, которые бы могли заменить любой поисковый прибор или стать супер шпионом. Пройти этот уровень невозможно (почти). Найдите одно двоеточие(:) среди точек с запятыми(;) за 45 секунд. Да прибудет с вами супер зрение...";
		dot = 1;
		secondTime = 45;
		break;
	}
}

// изменение темы уровня
function blackWhite() {
	if(topic == 0) {
		main.style.color = "#FF9200";
		main.style.backgroundColor = "#009999";
		document.body.style.backgroundColor = "#A600A6";
		topic++;
		numberLevel.value = "2";
		level();
		numberLevel.min = "2";
		return;
	}
	else {
		main.style.color = "black";
		main.style.backgroundColor = "white";
		document.body.style.backgroundColor = "black";
		topic--;
		numberLevel.min = "1";
		numberLevel.value = "1";
		level();
		return;
	}
}

function changeTable() {
	switch(tableValue.value) {
		case "1":
		spanTable.innerHTML = "оЧеНЬ МаЛеНЬКая ТаБЛиЦа (-50% сложности)";
		cube.innerHTML = "206";
		break;
		case "2":
		spanTable.innerHTML = "КаК СоЗДаТеЛЬ ПРоПиСаЛ (+0% сложности)";
		cube.innerHTML = "432";
		break;
		case "3":
		spanTable.innerHTML = "СТРаХ-ТаБЛиЦа (+50% сложности)";
		cube.innerHTML = "616";
		break;
	}
}