<!DOCTYPE html>
<html lang="ru">
    <head>
		<meta charset="utf-8" />
        <title>Дистанционная физ-ра</title>
		<link rel="shortcut icon" href="./img/favicon_1.ico">
		<link href="style_train.css" rel="stylesheet" type="text/css" />
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
				<p>Тренировки</p>
			</div>
			
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

			$array_result = array();
			
			$sql_ex = 'SELECT ExerciseID 
				FROM "public"."exercises" AS ex
				WHERE (((SELECT Health_Group FROM "public"."users" WHERE UserID = 1) IS NULL) OR ((SELECT Health_Group FROM "public"."users" WHERE UserID = 1) <= ex.Health_Group))
					
					AND NOT EXISTS ((SELECT Inventory FROM "public"."exercises_inventories" WHERE ExerciseID = ex.ExerciseID) EXCEPT (SELECT Inventory FROM "public"."users_inventories" WHERE UserID = 1))
					AND NOT EXISTS ((SELECT Contraindication FROM "public"."exercises_contraindications" WHERE ExerciseID = ex.ExerciseID) INTERSECT (SELECT Contraindication FROM "public"."users_contraindications" WHERE UserID = 1))';
			$array_result_ex = getdata($sql_ex);
			for ($i = 0; $i < count($array_result_ex); $i++){
				array_push($array_result, $array_result_ex[$i]['exerciseid']);
			}
			$keys = array_rand( $array_result, 8);
			$array_result_new = [];
			file_put_contents('train.txt', '');
			for ($i = 0; $i < count($keys); $i++){
				$k1 = $keys[$i];
				$sql_1 = "SELECT * FROM exercises WHERE ExerciseID = $array_result[$k1]";
				$array_result_new[$i] = getdata($sql_1);
				$file = 'train.txt';
				$current = file_get_contents($file);
				$current .= $array_result_new[$i][0]['exerciseid'].' ';
				file_put_contents($file, $current);
				$sql_2 = "SELECT * FROM exercises_inventories WHERE ExerciseID = $array_result[$k1]";
				$array_result_new2[$i] = getdata($sql_2)[0]['inventory'];
				
			}
			$inv = array_unique($array_result_new2);
			$inv = array_diff($inv, array('')); 
			$id = 1;
			
			for ($i = 0; $i < 8; $i++) {
				$tr_id = $array_result_new[$i][0]['exerciseid'];
				$level_arr = getdata("SELECT Train_Level FROM exercises WHERE exerciseid	 = $tr_id");
				$test_arr = getdata("SELECT Pulse_Rating FROM pulses WHERE UserID = $id AND Pulse_Time = (SELECT MAX(Pulse_Time) FROM pulses WHERE UserID = $id)");
				$level = $level_arr[0]['train_level'];
				$test = $test_arr[0]['pulse_rating'];
				if ($test == NULL){
					if ($level == 'Начальный')
					$keys[$i] = '00:02:30';
					if ($level == 'Средний')
					$keys[$i] = '00:02:00';
					if ($level == 'Высокий')
					$keys[$i] = '00:01:30';
				}else if ($level == 'Начальный'){
					if ($test < 55)
					$keys[$i] = '00:02:00';
					else if ($test < 65)
					$keys[$i] = '00:02:30';
					else if ($test < 80)
					$keys[$i] = '00:03:00';
					else if ($test < 90)
					$keys[$i] = '00:03:30';
					else
					$keys[$i] = '00:04:00';
				} else if ($level == 'Средний') {
					if ($test < 55)
					$keys[$i] = '00:02:00';
					else if ($test < 65)
					$keys[$i] = '00:02:15';
					else if ($test < 80)
					$keys[$i] = '00:02:30';
					else if ($test < 90)
					$keys[$i] = '00:02:45';
					else
					$keys[$i] = '00:03:00';
				} else if ($level == 'Высокий') {
					if ($test < 55)
					$keys[$i] = '00:01:00';
					else if ($test < 65)
					$keys[$i] = '00:01:15';
					else if ($test < 80)
					$keys[$i] = '00:01:30';
					else if ($test < 90)
					$keys[$i] = '00:01:45';
					else
					$keys[$i] = '00:02:00';
				}
				
				$sum += strtotime($keys[$i])-strtotime("00:00:00");
			}
			?>
				<table class="train">
					<tr id="first">
						<td>Номер</td>
						<td>Упражнение</td>
						<td>Время</td>
					</tr>
					<tr>
						<td>№1</td>
						<td><?php echo $array_result_new[0][0]['ex_name']?></td>
						<td><?php echo substr($keys[0],-5)?> мин</td>
					</tr>
					<tr>
						<td>№2</td>
						<td><?php echo $array_result_new[1][0]['ex_name']?></td>
						<td><?php echo substr($keys[1],-5)?> мин</td>
					</tr>
					<tr>
						<td>№3</td>
						<td><?php echo $array_result_new[2][0]['ex_name']?></td>
						<td><?php echo substr($keys[2],-5)?> мин</td>
					</tr>
					<tr>
						<td>№4</td>
						<td><?php echo $array_result_new[3][0]['ex_name']?></td>
						<td><?php echo substr($keys[3],-5)?> мин</td>
					</tr>
					<tr>
						<td>№5</td>
						<td><?php echo $array_result_new[4][0]['ex_name']?></td>
						<td><?php echo substr($keys[4],-5)?> мин</td>
					</tr>
					<tr>
						<td>№6</td>
						<td><?php echo $array_result_new[5][0]['ex_name']?></td>
						<td><?php echo substr($keys[5],-5)?> мин</td>
					</tr>
					<tr>
						<td>№7</td>
						<td><?php echo $array_result_new[6][0]['ex_name']?></td>
						<td><?php echo substr($keys[6],-5)?> мин</td>
					</tr>
					<tr>
						<td>№8</td>
						<td><?php echo $array_result_new[7][0]['ex_name']?></td>
						<td><?php echo substr($keys[7],-5)?> мин</td>
					</tr>
				</table>
				
				<table class="train">
					<tr>
						<td>Общее время тренировки</td>
						<td><?php echo date('i:s',$sum)?> мин</td>
					</tr>
					<tr>
						<td>Каждому упражнению соответствует предполагаемое время его выполнения. 
						Сконцентрируйтесь на правильности выполнения, а не на количестве подходов!</td>
						<td>После выполнения упражнения рекомендуем сделать паузу в 15-20 секунд.
						Нажимайте на кнопку "Следующее упражнение" только когда будете готовы к его выполнению</td>
					</tr>
					<tr>
						
					</tr>
					<tr>
						<td>Список инвентаря</td>
						<td><?php 
							echo "<ul>";
							foreach($inv as $value) {
								printf("<li>%s</li>", $value);
							}
							 echo "</ul>";
						?></td>
					</tr>
				</table>
			
					
		<script>
			
			
			</script>
			
			<form action="./php/train.php" method="post">
			<button class="buttn" type="submit" name="my_button" id="btn">Начать тренировку</button>
			</form>
			<div class="dark" id="1"> <!-- 1ое упражнение -->
				<div class="window">
					<p class="train_num">Упражнение №1</p>
					<div class="img"><img src="<?php echo $array_result_new[0][0]['gif']?>"></div>
					<div class="text"><p style="font-size:24px"><?php echo $array_result_new[0][0]['ex_name']?></p>
					<p><?php echo $array_result_new[0][0]['text_description']?> <p></div> 
					<a href="#2" class="buttn_skip">Пропустить упражнение<a>
					<form action="./php/train.php" method="post">
					<button class="buttn_next" type="submit" name="ex1" id="btn">Следующее упражнение</button>
					</form>
				</div>
			</div>
			
			<div class="dark" id="2"> 
				<div class="window">
					<p class="train_num">Упражнение №2</p>
					<div class="img"><img src="<?php echo $array_result_new[1][0]['gif']?>"></div>
					<div class="text"><p style="font-size:24px"><?php echo $array_result_new[1][0]['ex_name']?></p>
					<p><?php echo $array_result_new[1][0]['text_description']?><p></div> 
					<a href="#3" class="buttn_skip">Пропустить упражнение<a>
					<form action="./php/train.php" method="post">
					<button class="buttn_next" type="submit" name="ex2" id="btn">Следующее упражнение</button>
					</form>
				</div>
			</div>
			<div class="dark" id="3">
				<div class="window">
					<p class="train_num">Упражнение №3</p>
					<div class="img"><img src="<?php echo $array_result_new[2][0]['gif']?>"></div>
					<div class="text"><p style="font-size:24px"><?php echo $array_result_new[2][0]['ex_name']?></p>
					<p><?php echo $array_result_new[2][0]['text_description']?><p></div> 
					<a href="#4" class="buttn_skip">Пропустить упражнение<a>
					<form action="./php/train.php" method="post">
					<button class="buttn_next" type="submit" name="ex3" id="btn">Следующее упражнение</button>
					</form>
				</div>
			</div>
			<div class="dark" id="4"> 
				<div class="window">
					<p class="train_num">Упражнение №4</p>
					<div class="img"><img src="<?php echo $array_result_new[3][0]['gif']?>"></div>
					<div class="text"><p style="font-size:24px"><?php echo $array_result_new[3][0]['ex_name']?></p>
					<p><?php echo $array_result_new[3][0]['text_description']?><p></div> 
					<a href="#5" class="buttn_skip">Пропустить упражнение<a>
					<form action="./php/train.php" method="post">
					<button class="buttn_next" type="submit" name="ex4" id="btn">Следующее упражнение</button>
					</form>
				</div>
			</div>
			<div class="dark" id="5"> 
				<div class="window">
					<p class="train_num">Упражнение №5</p>
					<div class="img"><img src="<?php echo $array_result_new[4][0]['gif']?>"></div>
					<div class="text"><p style="font-size:24px"><?php echo $array_result_new[4][0]['ex_name']?></p>
					<p><?php echo $array_result_new[4][0]['text_description']?><p></div> 
					<a href="#6" class="buttn_skip">Пропустить упражнение<a>
					<form action="./php/train.php" method="post">
					<button class="buttn_next" type="submit" name="ex5" id="btn">Следующее упражнение</button>
					</form>
				</div>
			</div>
			<div class="dark" id="6"> 
				<div class="window">
					<p class="train_num">Упражнение №6</p>
					<div class="img"><img src="<?php echo $array_result_new[5][0]['gif']?>"></div>
					<div class="text"><p style="font-size:24px"><?php echo $array_result_new[5][0]['ex_name']?></p>
					<p><?php echo $array_result_new[5][0]['text_description']?><p></div> 
					<a href="#7" class="buttn_skip">Пропустить упражнение<a>
					<form action="./php/train.php" method="post">
					<button class="buttn_next" type="submit" name="ex6" id="btn">Следующее упражнение</button>
					</form>
				</div>
			</div>
			<div class="dark" id="7">
				<div class="window">
					<p class="train_num">Упражнение №7</p>
					<div class="img"><img src="<?php echo $array_result_new[6][0]['gif']?>"></div>
					<div class="text"><p style="font-size:24px"><?php echo $array_result_new[6][0]['ex_name']?></p>
					<p><?php echo $array_result_new[6][0]['text_description']?><p></div> 
					<a href="#8" class="buttn_skip">Пропустить упражнение<a>
					<form action="./php/train.php" method="post">
					<button class="buttn_next" type="submit" name="ex7" id="btn">Следующее упражнение</button>
					</form>
				</div>
			</div>
			<div class="dark" id="8"> <!-- последнее упражнение -->
				<div class="window">
					<p class="train_num">Упражнение №8</p>
					<div class="img"><img src="<?php echo $array_result_new[7][0]['gif']?>"></div>
					<div class="text"><p style="font-size:24px"><?php echo $array_result_new[7][0]['ex_name']?></p>
					<p><?php echo $array_result_new[7][0]['text_description']?><p></div> 
					<form action="./php/train.php" method="post">
					<button class="buttn_skip" type="submit" name="ex8skip" id="btn">Пропустить упражнение</button>
					<button class="buttn_next" type="submit" name="ex8" id="btn">Следующее упражнение</button>
					</form>
				</div>
			</div>
<?php
				
		$sql_id = 'SELECT points FROM "public"."trainings" WHERE userid = 1 AND Training_Time = (SELECT MAX(Training_Time) FROM trainings WHERE UserID = 1)';
		$result = getdata($sql_id);
?>
			<div class="dark" id="9">
				<div class="window">
					<p class="end">Успех!</p>
					<p class="end">Тренировка окончена</p>
					<div class="train" id="end_text">
						<p id="fulltime"></p>
						<p>Начислено баллов: <?php echo $result[0]['points']?></p>
					</div>
					<a href="#" class="buttn_next">Закрыть</a>
					
					<img width="300px" src="http://drive.google.com/uc?export=view&id=1TdEwX-FKcqaZJyUfmHMSsdfJHAr2nI2j">
				</div>
			</div>
		</div>
	</body>
</html>