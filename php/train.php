<?php
global $id;
$id = 1;
$bd = mysqli_connect("localhost", "drfeg_steam", "4S5UTSqn", "drfeg_steam");
if( isset( $_POST['my_button'] ) ){
	function query($sql){
		global $bd;
		$result = mysqli_query($bd, $sql);
		if(!$result){
			echo 'Ошибка'.$sql;
			exit;
		}
		return $result;
	}

	function getdata($sql){
		$result = query($sql);
		return mysqli_fetch_all($result);
	}
	mysqli_query($bd, "INSERT INTO trainings (trainingid, userid, points, done) VALUES(nextval('training_id_sequence'), 1, 0, 'Нет')");
	$file = '../train.txt';
	$current = file_get_contents($file);
	$mas = explode(" ", $current);
	$array = getdata( "select max(trainingid) from trainings where userid=$id");
	$num = (int)$array[0]['max'];
	for ($i = 0; $i < 8; $i++) {
		$level_arr = getdata("SELECT Train_Level FROM users WHERE UserID = $id");
		$test_arr = getdata("SELECT Pulse_Rating FROM pulses WHERE UserID = $id AND Pulse_Time = (SELECT MAX(Pulse_Time) FROM pulses WHERE UserID = $id)");
		$level = $level_arr[0]['train_level'];
		$test = $test_arr[0]['pulse_rating'];
		if ($level == 'Начальный'){
			if ($test < 55)
				$keys[$i] = '00:02:00';
			else if ($test < 65)
				$keys[$i] = '00:02:45';
			else if ($test < 80)
				$keys[$i] = '00:03:30';
			else if ($test < 90)
				$keys[$i] = '00:04:00';
			else
				$keys[$i] = '00:04:30';
		} else if ($level == 'Средний') {
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
		} else if ($level == 'Высокий') {
			if ($test < 55)
				$keys[$i] = '00:01:00';
			else if ($test < 65)
				$keys[$i] = '00:01:30';
			else if ($test < 80)
				$keys[$i] = '00:02:00';
			else if ($test < 90)
				$keys[$i] = '00:02:30';
			else
				$keys[$i] = '00:03:00';
		}
		mysqli_query($bd, "INSERT INTO workouts VALUES($num, $mas[$i], 'Нет', '$keys[$i]', $i+1)");
	}

	header("Location: /train.php#1");
}
if( isset( $_POST['ex1'] ) ){
	$id = 1;
	mysqli_query($bd, "UPDATE workouts  SET done = 'Да' WHERE TrainingID = (SELECT TrainingID FROM trainings as t WHERE t.UserID = $id AND t.Training_Time = (SELECT MAX(Training_Time)
			FROM trainings as s
			WHERE s.UserID = $id)) AND Exe_Order = 1");
			//echo '1';
	header("Location: /train.php#2");
}
if( isset( $_POST['ex2'] ) ){
	$id = 1;
	mysqli_query($bd, "UPDATE workouts  SET done = 'Да' WHERE TrainingID = (SELECT TrainingID FROM trainings as t WHERE t.UserID = $id AND t.Training_Time = (SELECT MAX(Training_Time)
			FROM trainings as s
			WHERE s.UserID = $id)) AND Exe_Order = 2");
	header("Location: /train.php#3");
}
if( isset( $_POST['ex3'] ) ){
	$id = 1;
	mysqli_query($bd, "UPDATE workouts  SET done = 'Да' WHERE TrainingID = (SELECT TrainingID FROM trainings as t WHERE t.UserID = $id AND t.Training_Time = (SELECT MAX(Training_Time)
			FROM trainings as s
			WHERE s.UserID = $id)) AND Exe_Order = 3");
	header("Location: /train.php#4");
}
if( isset( $_POST['ex4'] ) ){
	$id = 1;
	mysqli_query($bd, "UPDATE workouts  SET done = 'Да' WHERE TrainingID = (SELECT TrainingID FROM trainings as t WHERE t.UserID = $id AND t.Training_Time = (SELECT MAX(Training_Time)
			FROM trainings as s
			WHERE s.UserID = $id)) AND Exe_Order = 4");
	header("Location: /train.php#5");
}
if( isset( $_POST['ex5'] ) ){
	$id = 1;
	mysqli_query($bd, "UPDATE workouts  SET done = 'Да' WHERE TrainingID = (SELECT TrainingID FROM trainings as t WHERE t.UserID = $id AND t.Training_Time = (SELECT MAX(Training_Time)
			FROM trainings as s
			WHERE s.UserID = $id)) AND Exe_Order = 5");
	header("Location: /train.php#6");
}
if( isset( $_POST['ex6'] ) ){
	$id = 1;
	mysqli_query($bd, "UPDATE workouts  SET done = 'Да' WHERE TrainingID = (SELECT TrainingID FROM trainings as t WHERE t.UserID = $id AND t.Training_Time = (SELECT MAX(Training_Time)
			FROM trainings as s
			WHERE s.UserID = $id)) AND Exe_Order = 6");
	header("Location: /train.php#7");
}
if( isset( $_POST['ex7'] ) ){
	$id = 1;
	mysqli_query($bd, "UPDATE workouts  SET done = 'Да' WHERE TrainingID = (SELECT TrainingID FROM trainings as t WHERE t.UserID = $id AND t.Training_Time = (SELECT MAX(Training_Time)
			FROM trainings as s
			WHERE s.UserID = $id)) AND Exe_Order = 7");
	header("Location: /train.php#8");
}
if( isset( $_POST['ex8'] ) ){
	$id = 1;
	mysqli_query($bd, "UPDATE workouts  SET done = 'Да' WHERE TrainingID = (SELECT TrainingID FROM trainings as t WHERE t.UserID = $id AND t.Training_Time = (SELECT MAX(Training_Time)
			FROM trainings as s
			WHERE s.UserID = $id)) AND Exe_Order = 8");
	mysqli_query($bd, "UPDATE trainings SET done = 'Да' WHERE userid = $id AND Training_Time = (SELECT MAX(Training_Time) FROM trainings WHERE UserID = $id)");
	header("Location: /train.php#9");
}

if( isset( $_POST['ex8skip'] ) ){
	$id = 1;
	mysqli_query($bd, "UPDATE trainings SET done = 'Да' WHERE userid = $id AND Training_Time = (SELECT MAX(Training_Time) FROM trainings WHERE UserID = $id)");
	header("Location: /train.php#9");
}

if( isset( $_POST['pulse'] ) ){
	$id = 1;
	//print_r($_POST);
	//echo $_POST['pulse90'];
	$pulse = (int)$_POST['pulse90'];
	mysqli_query($bd, "INSERT INTO pulses (userid, pulse_after) VALUES(1, $pulse)");
	header("Location: /start.php");
}
?>