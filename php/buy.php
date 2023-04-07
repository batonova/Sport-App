<?php
global $id;
$id = 1;
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

	$aw = (int)$_POST['aw_id'];
	echo $aw;
	pg_query($bd, "INSERT INTO users_awards VALUES($id, $aw, 'Нет')");
	//header("Location: /train.php#8");
?>