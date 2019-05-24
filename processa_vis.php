<?php
session_start();
require_once 'database_gac.php';

if(isset($_POST['contar'])){
	//Obter a data atual
	$data['atual'] = date('Y-m-d H:i:s');
	
	//Diminuir 1 minuto, contar usuário no site no último minuto
	//$data['online'] = strtotime($data['atual'] . " - 1 minutes");
	
	//Diminuir 20 segundos 
	$data['online'] = strtotime($data['atual'] . " - 20 seconds");
	$data['online'] = date("Y-m-d H:i:s",$data['online']);
	//echo $_SESSION['visitante'];
	if ((isset($_SESSION['visitante'])) AND (!empty($_SESSION['visitante']))) {
		
		$result_up_visita = "UPDATE visitas SET
		data_final = '" . $data['atual'] . "'
		WHERE id = '" . $_SESSION['visitante'] . "'";
		
		$resultado_up_visitas = mysqli_query($conection, $result_up_visita);
		
	}else{
		 $nom = $_SESSION['nome'] ;

//Salvar no banco de dados
		$result_visitas = "INSERT INTO visitas (data_inicio, data_final,nome)VALUES ('".$data['atual']."', '".$data['atual']."', '$nom')";
		
		$resultado_visitas = mysqli_query($conection, $result_visitas);
		
		$_SESSION['visitante'] = mysqli_insert_id($conection);
	}
	
	//Pesquisar os ultimos usuarios online nos 20 segundo
	$result_qnt_visitas = "SELECT count(id) as online FROM visitas WHERE data_final >= '" . $data['online'] . "'";	
	$resultado_qnt_visitas = mysqli_query($conection, $result_qnt_visitas);
	$row_qnt_visitas = mysqli_fetch_assoc($resultado_qnt_visitas);
	
	echo $row_qnt_visitas['online'];
             
}