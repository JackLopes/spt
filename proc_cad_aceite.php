<?php
session_start();
include_once 'database_gac.php';

$usu = $_SESSION['nome'];
$us = Explode ( '', $usu  );
$u = 

$pren = $_POST['prazo_entrega'];
$obs = filter_input(INPUT_POST, 'obs', FILTER_SANITIZE_STRING);
$id = filter_input(INPUT_POST, 'id_iten', FILTER_SANITIZE_NUMBER_INT);


/*var_dump($pren);
var_dump($obs );
var_dump($id);*/

if(!empty($_POST['prazo_entrega'])){


$result = "INSERT INTO aceite ( id_iten, prazo_entrega,obs) VALUES ('$id','$pren ', '$obs ' ) ";
$resultado = mysqli_query($conection, $result);

if(mysqli_insert_id($conection)){
	$_SESSION['msg'] = $usu . "<p style='color:green;'> Registro cadastrado com sucesso </p>";
		
	header("Location:cad_aceite.php?id=$id");
}else{
	$_SESSION['msg'] = "";
	header("Location: cad_aceite.php?id=$id");
}
} else {
	
	$_SESSION['msg'] = "<p style='color:red;'>Usuário não foi cadastrado com sucesso777</p>";
	header("Location:cad_aceite.php?id=$id");
	
}