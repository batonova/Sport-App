<?php 
global $bd;
global $i;
$bd = pg_connect("host=127.0.0.1 port=5438 dbname=bd user=postgres password=postgres");
$i = 3;
var_dump($bd);

print_r($_POST); 

	$gender = $_POST['gender'];
	if ($gender) $gender = 'м';
	else $gender = 'ж';
	$height = $_POST['height'];
	$weight = $_POST['weight'];
	$health_group = $_POST['health_group'];
	$name = 'Имя';
	$email = 'sbd3@edu.hse.ru';
	$contr_mas = [];
	for ($j=1; $j<=10; $j++){
		if (array_key_exists('contr'.$j, $_POST)){
			array_push($contr_mas, 'contr'.$j);
		}
	}
	print_r($contr_mas);
	$contr = implode(",",$contr_mas); //Соединение в строку
	
	$invent_mas = [];
	for ($j=1; $j<=10; $j++){
		if (array_key_exists('invent'.$j, $_POST)){
			array_push($invent_mas, 'invent'.$j);
		}
	}
	print_r($invent_mas);
	$invent = implode(",",$invent_mas); //Соединение в строку
	
	pg_query($bd, "INSERT INTO users (userid,name,email,gender,height,weight,health_group, contraindications, inventory) VALUES (1,'$name','$email','$gender','$height','$weight','$health_group','$contr', '$invent')");
	
	header('Location: /');
?>