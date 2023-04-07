<?php 
global $bd;
$bd = mysqli_connect("localhost", "4S5UTSqn", "", "drfeg_steam");
var_dump($bd);

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


$sql = 'SELECT * FROM "public"."users" where userid = 3;';
$array_result = getdata($sql);
echo '<pre>'; print_r ($array_result); echo '</pre>';*/
?>