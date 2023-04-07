<?php 
global $bd;
global $i;
$bd = pg_connect("host=127.0.0.1 port=5438 dbname=base4 user=postgres password=postgres");
$i = 3;

//print_r($_POST); 

	$gender = $_POST['gender'];
	if ($gender == 1) $gender = 'м';
	else $gender = 'ж';
	$height = $_POST['height'];
	$weight = $_POST['weight'];
	$health_group = $_POST['health_group'];
	$level = $_POST['level'];
	if ($level == 1) $level = 'Начальный';
	else if ($level == 2) $level = 'Средний';
	else $level = 'Высокий';
	$name = 'Имя';
	$email = 'example@edu.hse.ru';
	$contr_mas = [];
	$id = 1;
	if (array_key_exists('contr1', $_POST)){
		array_push($contr_mas, 'Нет');
	}
	if (array_key_exists('contr2', $_POST)){
		array_push($contr_mas, 'Физические нагрузки высокой интенсивности');
	}
	if (array_key_exists('contr3', $_POST)){
		array_push($contr_mas, 'Акробатические упражнения');
	}
	if (array_key_exists('contr4', $_POST)){
		array_push($contr_mas, 'Упражнения на гимнастических снарядах');
	}
	if (array_key_exists('contr5', $_POST)){
		array_push($contr_mas, 'Длительная задержка дыхания');
	}
	if (array_key_exists('contr6', $_POST)){
		array_push($contr_mas, 'Упражнения, выполнение которых связано с натуживанием');
	}
	if (array_key_exists('contr7', $_POST)){
		array_push($contr_mas, 'Интенсивное напряжением мышц брюшного пресса');
	}
	if (array_key_exists('contr8', $_POST)){
		array_push($contr_mas, 'Значительные наклоны головы');
	}
	if (array_key_exists('contr9', $_POST)){
		array_push($contr_mas, 'Резкое изменение положения тела');
	}
	if (array_key_exists('contr10', $_POST)){
		array_push($contr_mas, 'Напряжение органов зрения');
	}
	if (array_key_exists('contr11', $_POST)){
		array_push($contr_mas, 'Продолжительные физические нагрузки средней интенсивности');
	}
	if (array_key_exists('contr12', $_POST)){
		array_push($contr_mas, 'Физические упражнения с длительным статическим напряжением мышц');
	}
	if (array_key_exists('contr13', $_POST)){
		array_push($contr_mas, 'Физические упражнения, вызывающие нервное перенапряжение');
	}
	if (array_key_exists('contr14', $_POST)){
		array_push($contr_mas, 'Упражнения, сопровождающиеся значительным сотрясением тела');
	}
	if (array_key_exists('contr15', $_POST)){
		array_push($contr_mas, 'Круговые движения туловища и наклоны, особенно вперед');
	}
	if (array_key_exists('contr16', $_POST)){
		array_push($contr_mas, 'Значительные наклоны головы');
	}
	
	//
	//$contr = implode(",",$contr_mas); //Соединение в строку
	$str1 = "( 1, '";
	$str2 = "')";
	$contr2 = implode("'), (1, '",$contr_mas);
	$contr1 = $str1.$contr2;
	$contr= $contr1.$str2;
	//print_r($contr);
	pg_query($bd, "INSERT INTO users_contraindications (userid,contraindication) VALUES  $contr");
	
	$invent_mas = [];
	
	if (array_key_exists('invent1', $_POST)){
		array_push($invent_mas, 'Нет');
	}
	if (array_key_exists('invent2', $_POST)){
		array_push($invent_mas, 'Набор спортивных резинок');
	}
	if (array_key_exists('invent3', $_POST)){
		array_push($invent_mas, 'Спортивный коврик');
	}
	if (array_key_exists('invent4', $_POST)){
		array_push($invent_mas, 'Гантели');
	}
	if (array_key_exists('invent5', $_POST)){
		array_push($invent_mas, 'Утяжелители на ноги/руки');
	}
	if (array_key_exists('invent6', $_POST)){
		array_push($invent_mas, 'Скакалка');
	}
	if (array_key_exists('invent7', $_POST)){
		array_push($invent_mas, 'Эспандер');
	}
	if (array_key_exists('invent8', $_POST)){
		array_push($invent_mas, 'Мяч');
	}
	if (array_key_exists('invent9', $_POST)){
		array_push($invent_mas, 'Гимнастическая палка (или её замена)');
	}
	if (array_key_exists('invent10', $_POST)){
		array_push($invent_mas, 'Обруч');
	}
	if (array_key_exists('invent11', $_POST)){
		array_push($invent_mas, 'Турник');
	}
	$str1 = "( 1, '";
	$str2 = "')";
	$invent2 = implode("'), (1, '",$invent_mas);
	$invent1 = $str1.$invent2;
	$invent= $invent1.$str2;
	pg_query($bd, "INSERT INTO users_inventories (userid,inventory) VALUES $invent");

	
	pg_query($bd, "UPDATE users SET  Gender = '$gender', Height = '$height', Weight = '$weight', Health_Group = '$health_group', Train_Level = '$level' WHERE userid = $id");
	header("Location: /info.php");
?>