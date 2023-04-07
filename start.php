<!DOCTYPE html>
<html lang="ru">
    <head>
		<meta charset="utf-8" />
        <title>Дистанционная физ-ра</title>
		<link rel="shortcut icon" href="./img/favicon_1.ico">
		<link href="style.css" rel="stylesheet" type="text/css" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	</head>
				<script>
			
			var d1, d2, interval;
			
			function Date1() {
				d1 = Date.now();
				document.location.replace('#1');
			
			}
			function Date2() {
				d2 = Date.now();
				interval = new Date(d2 - d1);
				var time = [
				  interval.getUTCHours(),
				  interval.getUTCMinutes(),
				  interval.getUTCSeconds(),  
				].join(':');
				document.location.replace('#9');
				
				var el = document.getElementById('fulltime');
				el.innerHTML = 'Длительность тренировки: ' + time;
			}
			
			function ShowModal(elId) {
			  var modalAll = document.getElementById(elId);
			  modalAll.style.display = "flex";
			}

			function HideModal() {
			  if (event.target.classList.contains('modal-all')) {
				event.currentTarget.style.display = "none";
			  }
			}
			
			$(function() {
			e1 = document.getElementById('send1');
			e2 = document.getElementById('send2');
				$.fn.Timer = function Timer(obj) {
					var def = {
						from: 5E3,
						duration: 5E3,
						to: 0,
						callback: null,
						step: function(now, fx) {
							$(fx.elem).html(now | 0)
						}
					};
					var opt = $.extend({}, def, obj);
					return this.each(function(indx, el) {
						$(el).queue(function() {
							el.n = opt.from;
							$(el).dequeue()
						});
						$(el).animate({
							n: opt.to
						}, {
							easing: "linear",
							duration: opt.duration,
							step: opt.step,
							complete: opt.callback
						})
					})
				};
				var end = +localStorage.getItem("end")||0, duration = 10 * 1E3;
				$("#send").on("click", function (event) {
				var time = (new Date).getTime(),
				d = duration;
				if (end && end > time) {
					  event.stopPropagation();
					  d = end - time;
					}
				else {
				   localStorage.setItem("end", time + duration);
				}
				var f = d/1000|0;
					var text = e1.defaultValue;
					console.log(this);
					$(e1).prop({
						disabled: true
					}).Timer({
						step: function(now, fx) {
							var a = Math.trunc(now);
							var b = ['секунда','секунды','секунд'];
							a = `${a} ${b[1 == a % 10 && 11 != a % 100 ? 0 : 2 <= a % 10 && 4 >= a % 10 && (10 > a % 100 || 20 <= a % 100) ? 1 : 2]}`;
							fx.elem.value = `${a}`;
						},
						from: f,
						duration: d,
						to: 0,
						callback: function() {
							localStorage.setItem("end", "0");
							$(e1).prop({
								disabled: false
							}).val(text)
						}
					})
					var text = e2.defaultValue;
					console.log(this);
					$(e2).prop({
						disabled: true
					}).Timer({
						step: function(now, fx) {
							var a = Math.trunc(now);
							var b = ['секунда','секунды','секунд'];
							a = `${a} ${b[1 == a % 10 && 11 != a % 100 ? 0 : 2 <= a % 10 && 4 >= a % 10 && (10 > a % 100 || 20 <= a % 100) ? 1 : 2]}`;
							fx.elem.value = `${a}`;
						},
						from: f,
						duration: d,
						to: 0,
						callback: function() {
							localStorage.setItem("end", "0");
							$(e1).prop({
								disabled: false
							}).val(text)
						}
					})
					
				})
				if (end && end > (new Date).getTime()) $("#send").click();

			});
			</script>
	<body>
		<div class="left_menu">
			<div class="logo_box">
				<a href="./start.php"> 
				<img src="./img/logo.svg"> 
				<span>МИЭМ</span>
				</a>
			</div>
			<a href="./info.php" class="menu_item">
				<img src="./img/item_1.svg">
				Мои данные
			</a>
			<a href="./train.php" class="menu_item">
				<img src="./img/item_2.svg">
				Тренировки
			</a>
			<a href="./progress.php" class="menu_item">
				<img src="./img/item_3.svg">			
				Личный кабинет
			</a>
		</div>
		
		<div id="main">
			<div class="header">
				<p>HSE Exercises</p>
			</div>
			
			<div class="train_num"> 
				<p>1 предстоящая тренировка</p>
			</div>
			
			<a href="./train.php" class="buttn">Начать тренировку<a>
						
			<div class="train_num">
			<p>Для измерения пульса пройдите Гарвардский степ - тест </p>
				<input class="buttn_pulse" type=button value="Измерить пульс" onclick="ShowModal('m1')">
			</div>
			<div id="m1" class="modal-all" onclick="HideModal()">
			  <div class="modal">
				<p>Для измерения пульса предлагаем пройти Гарвардский степ-тест</p>
				<p>Прохождение теста займет около 5 минут</p>
				<p>Для теста вам понадобится</p>
				<ul>
					<li>секундомер</li>
					<li>скамейка/стул/диван, высотой не более 50см</li>
				</ul>
				<p>Порядок выполнения теста:</p>
				<ul>
					<li>Встать на стул одной ногой</li>
					<li>Встать на стул другой ногой</li>
					<li>Опустить одну ногу</li>
					<li>Опустить другую ногу</li>
					<li>Выполнять упражнение не менее 3 мин</li>
					<li>Отдохнуть 2 мин</li>
					<li>Подсчитать пульс за 30сек</li>
				</ul>
				<input class="buttn_pulse" type=button value="Далее" onclick="ShowModal('m2')">
				<a href="" class="buttn_pulse">Закрыть</a>
			  </div>
			</div>
			<div id="m2" class="modal-all">
			  <div class="modal">
				<h2>Гарвардский степ-тест</h2>
				
				<img src="./img/test.jpg">
				<form action="./php/train.php" method="post">
				<input id="send" class="buttn_pulse" name="send" type="button" value="Начать тест">
					<table>
						<tr>
							<td>Пульс после выполнения упражнений</td>
							<td><input id="pulse90" type="number" name="pulse90" value="0" min="10" max="200" step="1" required></td>
						</tr>
					</table>
					<!-- <button class="buttn_pulse" type="button" id="btn">Сохранить</button> -->
					<button class="buttn_pulse" type="submit" name="pulse" id="send1" disabled>Закончить тест</button>
					<input id="send2" class="time" name="send1" type="submit" value="00:00">
				</form>
				
			  </div>
			</div>
			
			
		</div>
	</body>
</html>