<!DOCTYPE html>
<html lang="ru">
    <head>
		<meta charset="utf-8" />
        <title>Дистанционная физ-ра</title>
		<link rel="shortcut icon" href="./img/favicon_1.ico">
		<link href="style_progress.css" rel="stylesheet" type="text/css" />
	</head>
	<script src="jquery.js"></script>
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
		$sql_id = 'SELECT score FROM "public"."users" WHERE userid = 1 ';
		$result = getdata($sql_id);
		$id = 1;
		$pulse = getdata("SELECT * FROM pulses WHERE UserID = $id AND Pulse_Time = (SELECT MAX(Pulse_Time) FROM pulses WHERE UserID = $id)");
		$train = getdata("SELECT * FROM trainings WHERE UserID = $id");
		$awards = getdata("SELECT * FROM awards ");
		
		$buy_awards = getdata("SELECT * FROM users_awards WHERE UserID = $id");
		$my_awards = [];
		foreach($awards as $value){
			foreach($buy_awards as $myvalue){
				if($value['awardsid'] == $myvalue['awardsid'])
					array_push($my_awards, $value);
			}
		}
?>	
<script>

</script>		
		<div id="main">
			<div class="header">
				<p>HSE Exercises</p>
			</div>
			<div class="name"> 
				<p>Личный кабинет</p>
			</div>
			<div id="user">
				<img src="./img/user.svg">
				<div>Иван Иванов</div>
			</div>
			<div id="all">
				<p id="points">Начисленные баллы </p>
				Всего: <?php echo $result[0]['score']?> баллов
				<p id="points">Результат степ - теста </p>
				Пульс за 30 секунд: <?php echo $pulse[0]['pulse_after']?> ударов <br>
				Результат: <?php echo $pulse[0]['pulse_rating']?> баллов
			</div>
			<div id="train">
				<p id="points">Тренировки</p>
				<table>
					<tr>
						<td>Дата тренировки</td>
						<td>Баллы</td>
					</tr>
						<?php 
							echo "<tr>";
							foreach($train as $value) {
								printf("<td>%s</td><td>%s</td>", substr($value['training_time'],0,16),$value['points']);
								echo "</tr><tr>";
							}
							 echo "</tr>";
						?>
					
				</table>
			</div>
			<div class="name"> 
				<p>Витрина</p>
			</div>
		
			<section>
				<?php 
					foreach($awards as $value) {
						echo '<form action="./php/buy.php" method="post">';
						echo '<article style="height:300px">';
						printf('<img src="%s"> <p class="a_name">%s</p><p class="score">%s баллов</p>', $value['gif'],$value['awards_name'],$value['price_award']);
						printf('<input type="hidden" name="aw_id" value="%s"/>', $value['awardsid']);
						echo '<input name="submit" class="buy" type="submit" value="Купить">';
						echo "</article>";
						echo '</form>';
					}
				?>
			</section>
			
			<div class="name"> 
				<p>Мои покупки</p>
			</div>
		
			<section>
			
				<?php 
					foreach($my_awards as $value) {
						echo '<form action="./php/buy.php" method="post">';
						echo '<article style="height:300px">';
						printf('<img src="%s"> <p class="a_name">%s</p><p class="score">%s баллов</p>', $value['gif'],$value['awards_name'],$value['price_award']);
						echo "</article>";
						echo '</form>';
					}
				?>
			</section>
		</div>
	</body>
	<script src="script.js"></script>
</html>