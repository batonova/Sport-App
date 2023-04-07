	<!DOCTYPE html>
<html lang="ru">
    <head>
		<meta charset="utf-8" />
        <title>Дистанционная физ-ра</title>
		<link href="style_info.css" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="./img/favicon_1.ico">
		<script src="jquery.js"></script>
	</head>
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
			
			<div class="name"> 
				<p>Мои данные</p>
			</div>
			
			<form action="./php/updata.php" method="post">
			<table>
				<tr>
					<td>Пол</td>
					<td>
						<select name="gender" id = "gender">
						<option value="1">Мужской</option>
						<option value="2">Женский</option>
					   </select>
					</td>
				</tr>
				<tr>
					<td>Рост, м</td>
					<td><input id="height" type="number" name="height" value="0" min="1" max="3" step="0.01" required>
					<p class="error" id="err_h">Неверные данные</p></td>
				</tr>
				<tr>
					<td>Вес, кг</td>
					<td><input id="weight" type="number" name="weight" value="0" min="30" max="200" step="1" required>
					<p class="error" id="err_w">Неверные данные</p></td>
				</tr>
				<tr>
				<td>Группа здоровья <a href="./files/Group.pdf">🛈</a></td>
					<td>
						<select name="health_group" id = "health_group" >
						<option selected value="1">I</option>
						<option value="2">II</option>
						<option value="3">III</option>	
						<option value="4">IV</option>
					   </select>
					</td>
				</tr>
				<tr>
					<td>Уровень подготовки</td>
					<td>
						<select name="level" id="level" >
						<option selected value="1">Начальный</option>
						<option value="2">Средний</option>
						<option value="3">Высокий</option>
					   </select>
					</td>
				</tr>
				<tr>
				<td>Противопоказания <a href="./files/contr.pdf">🛈</a><br>
					<span style="font-size:18px;">Если возникли трудности, нажми на подсказку</span> </td>
					<td class="protiv">
						<p><input type="checkbox" id="c1" name="contr1" value="1">Нет</p>
						<p><input type="checkbox" id="c2" name="contr2" value="2">Физические нагрузки высокой интенсивности</p>
						<p><input type="checkbox" id="c3" name="contr3" value="3">Акробатические упражнения</p>
						<p><input type="checkbox" id="c4" name="contr4" value="4">Упражнения на гимнастических снарядах</p>
						<p><input type="checkbox" id="c5" name="contr5" value="5">Длительная задержка дыхания</p>
						<p><input type="checkbox" id="c6" name="contr6" value="6">Упражнения, выполнение которых связано с натуживанием</p>
						<p><input type="checkbox" id="c7" name="contr7" value="7">Интенсивное напряжением мышц брюшного пресса</p>
						<p><input type="checkbox" id="c8" name="contr8" value="8">Значительные наклоны головы</p>
						<p><input type="checkbox" id="c9" name="contr9" value="9">Резкое изменение положения тела</p>
						<p><input type="checkbox" id="c10" name="contr10" value="10">Напряжение органов зрения</p>
						<p><input type="checkbox" id="c11" name="contr11" value="11">Продолжительные физические нагрузки средней интенсивности</p>
						<p><input type="checkbox" id="c12" name="contr12" value="12">Физические упражнения с длительным статическим напряжением мышц</p>
						<p><input type="checkbox" id="c13" name="contr13" value="13">Физические упражнения, вызывающие нервное перенапряжение</p>
						<p><input type="checkbox" id="c14" name="contr14" value="14">Упражнения, сопровождающиеся значительным сотрясением тела</p>
						<p><input type="checkbox" id="c15" name="contr15" value="15">Круговые движения туловища и наклоны, особенно вперед</p>
						<p><input type="checkbox" id="c16" name="contr16" value="16">Значительные наклоны головы</p>
					</td>
				</tr>
				<tr>
					<td>Инвентарь</td>
					<td class="invent">
						<p><input type="checkbox" id="i1" name="invent1" value="1">Нет</p>
						<p><input type="checkbox" id="i2" name="invent2" value="2">Набор спортивных резинок</p>
						<p><input type="checkbox" id="i3" name="invent3" value="3">Спортивный коврик</p>
						<p><input type="checkbox" id="i4" name="invent4" value="4">Гантели</p>
						<p><input type="checkbox" id="i5" name="invent5" value="5">Утяжелители на ноги/руки</p>
						<p><input type="checkbox" id="i6" name="invent6" value="6">Скакалка</p>
						<p><input type="checkbox" id="i7" name="invent7" value="7">Эспандер</p>
						<p><input type="checkbox" id="i8" name="invent8" value="8">Мяч</p>
						<p><input type="checkbox" id="i9" name="invent9" value="9">Гимнастическая палка (или её замена)</p>
						<p><input type="checkbox" id="i10" name="invent10" value="10">Обруч</p>
						<p><input type="checkbox" id="i11" name="invent11" value="11">Турник</p>
					</td>
				</tr>
			</table>	
			
			<input class="label" name="PERSONAL" type="checkbox" checked required><label>Ответственность за введенные данные и текущее состояние здоровья беру на себя</label>
			
				

			
			<button class="buttn" type="submit" id="btn">Сохранить</button>
			</form>
			
			<?php 
				global $bd;
				$bd = pg_connect("host=127.0.0.1 port=5438 dbname=base4 user=postgres password=postgres");

				function query($sql){
					global $bd;
					$result = pg_query($bd, $sql);
					if(!$result){
						echo 'Ошибка'.$sql;
						exit;
					}
					return $result;
				}

				function getdata($sql){
					$result = query($sql);
					return pg_fetch_all($result);
				}


				$sql = 'SELECT * FROM "public"."users" where userid = 1;';
				$array_result = getdata($sql);
				$sql_contr = 'SELECT * FROM "public"."users_contraindications" where userid = 1;';
				$array_contr = getdata($sql_contr);
				$contr = array();
				$contr_mas = array();
				for($i = 0; $i < count($array_contr); $i++){
					array_push($contr, $array_contr[$i]['contraindication']);
				}
				 
					if (in_array("Нет", $contr)) {
						array_push($contr_mas, 'contr1');
					}
					if (in_array("Физические нагрузки высокой интенсивности", $contr)) {
						array_push($contr_mas, 'contr2');
					}
					if (in_array("Акробатические упражнения", $contr)) {
						array_push($contr_mas, 'contr3');
					}
					if (in_array("Упражнения на гимнастических снарядах", $contr)) {
						array_push($contr_mas, 'contr4');
					}
					if (in_array("Длительная задержка дыхания", $contr)) {
						array_push($contr_mas, 'contr5');
					}
					if (in_array("Упражнения, выполнение которых связано с натуживанием", $contr)) {
						array_push($contr_mas, 'contr6');
					}
					if (in_array("Интенсивное напряжением мышц брюшного пресса", $contr)) {
						array_push($contr_mas, 'contr7');
					}
					if (in_array("Значительные наклоны головы", $contr)) {
						array_push($contr_mas, 'contr8');
					}
					if (in_array("Резкое изменение положения тела", $contr)) {
						array_push($contr_mas, 'contr9');
					}
					if (in_array("Напряжение органов зрения", $contr)) {
						array_push($contr_mas, 'contr10');
					}
					if (in_array("Продолжительные физические нагрузки средней интенсивности", $contr)) {
						array_push($contr_mas, 'contr11');
					}
					if (in_array("Физические упражнения с длительным статическим напряжением мышц", $contr)) {
						array_push($contr_mas, 'contr12');
					}
					if (in_array("Физические упражнения, вызывающие нервное перенапряжение", $contr)) {
						array_push($contr_mas, 'contr13');
					}
					if (in_array("Упражнения, сопровождающиеся значительным сотрясением тела", $contr)) {
						array_push($contr_mas, 'contr14');
					}
					if (in_array("Круговые движения туловища и наклоны, особенно вперед", $contr)) {
						array_push($contr_mas, 'contr15');
					}
					if (in_array("Значительные наклоны головы", $contr)) {
						array_push($contr_mas, 'contr16');
					}
				//print_r($contr_mas);
				$count_contr = count($array_contr);
				//echo $count_contr;
				$sql_invent = 'SELECT * FROM "public"."users_inventories" where userid = 1;';
				$array_invent = getdata($sql_invent);
				$invent = array();
				$invent_mas = array();
				for($i = 0; $i < count($array_invent); $i++){
					array_push($invent, $array_invent[$i]['inventory']);
				}
				
				if (in_array("Нет", $invent)) {
						array_push($invent_mas, 'invent1');
				}
				if (in_array("Набор спортивных резинок", $invent)) {
						array_push($invent_mas, 'invent2');
				}
				if (in_array("Спортивный коврик", $invent)) {
						array_push($invent_mas, 'invent3');
				}
				if (in_array("Гантели", $invent)) {
						array_push($invent_mas, 'invent4');
				}
				if (in_array("Утяжелители на ноги/руки", $invent)) {
						array_push($invent_mas, 'invent5');
				}
				if (in_array("Скакалка", $invent)) {
						array_push($invent_mas, 'invent6');
				}
				if (in_array("Эспандер", $invent)) {
						array_push($invent_mas, 'invent7');
				}
				if (in_array("Мяч", $invent)) {
						array_push($invent_mas, 'invent8');
				}
				if (in_array("Гимнастическая палка (или её замена)", $invent)) {
						array_push($invent_mas, 'invent9');
				}
				if (in_array("Обруч", $invent)) {
						array_push($invent_mas, 'invent10');
				}
				if (in_array("Турник", $invent)) {
						array_push($invent_mas, 'invent11');
				}
				//print_r($invent_mas);
				$count_invent = count($array_invent);
				
			?>
			<script>
				var gender;
				if("<?php echo $array_result[0]['gender']?>" == 'м') gender = '1';
				else gender = '2';
				var select = document.querySelector('#gender').getElementsByTagName('option');
				for (let i = 0; i < select.length; i++) {
					if (select[i].value == gender) 
						select[i].selected = true;
				} // вывод пола *
				document.getElementById('height').value = "<?php echo $array_result[0]['height'] ?>"; //вывод роста
				document.getElementById('weight').value = "<?php echo $array_result[0]['weight'] ?>"; //вывод веса
				
				var health_group;
				health_group = "<?php echo $array_result[0]['health_group']?>";
				select = document.querySelector('#health_group').getElementsByTagName('option');
				for (let i = 0; i < select.length; i++) {
					if (select[i].value == health_group) select[i].selected = true;
				} // вывод группа здоровья
				
				var train_level;
				if("<?php echo $array_result[0]['train_level']?>" == 'Начальный') train_level = '1';
				else if("<?php echo $array_result[0]['train_level']?>" == 'Средний') train_level = '2';
				else if("<?php echo $array_result[0]['train_level']?>" == 'Высокий') train_level = '3';
				select = document.querySelector('#level').getElementsByTagName('option');
				for (let i = 0; i < select.length; i++) {
					if (select[i].value == train_level) select[i].selected = true;
				} // вывод уровня подготовки
				
				for (var j=0; j<=<?php echo $count_contr?>; j++){
					for(let i=0; i<document.querySelectorAll('.protiv input').length; i++){
						var contr = <?php echo json_encode($contr_mas)?>;
						if (document.querySelectorAll('.protiv input')[i].name == contr[j]) 
							document.querySelectorAll('.protiv input')[i].checked = true;
					}
				} //вывод противопоказаний
				
				for ( j=0; j<=<?php echo $count_invent?>; j++){
					for(i=0; i<document.querySelectorAll('.invent input').length; i++){
						var invent = <?php echo json_encode($invent_mas)?>;
						if (document.querySelectorAll('.invent input')[i].name == invent[j]) 
							document.querySelectorAll('.invent input')[i].checked = true;
					}
				} //вывод инвентаря
			</script>
		</div>
	</body>
	<script src="script_info.js"></script>
</html>