<?php
session_start();




//Incluir conexao com BD
$conection = mysqli_connect('localhost','root');

mysqli_select_db($conection,'gac');

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
$color = filter_input(INPUT_POST, 'color', FILTER_SANITIZE_STRING);
$start = filter_input(INPUT_POST, 'start', FILTER_SANITIZE_STRING);
$end = filter_input(INPUT_POST, 'end', FILTER_SANITIZE_STRING);
$obs = filter_input(INPUT_POST, 'observacao', FILTER_SANITIZE_STRING);
$id_contr = filter_input(INPUT_POST, 'id_contr', FILTER_SANITIZE_STRING);

if(!empty($id) && !empty($title) && !empty($color) && !empty($start) && !empty($end) && !empty($obs)){
	//Converter a data e hora do formato brasileiro para o formato do Banco de Dados
	$data = explode(" ", $start);
	list($date, $hora) = $data;
	$data_sem_barra = array_reverse(explode("/", $date));
	$data_sem_barra = implode("-", $data_sem_barra);
	$start_sem_barra = $data_sem_barra . " " . $hora;
	
	$data = explode(" ", $end);
	list($date, $hora) = $data;
	$data_sem_barra = array_reverse(explode("/", $date));
	$data_sem_barra = implode("-", $data_sem_barra);
	$end_sem_barra = $data_sem_barra . " " . $hora;
	
	$result_events = "UPDATE events SET title='$title', color='$color', start='$start_sem_barra', end='$end_sem_barra',observacao='$obs', id_contr='$id_contr' WHERE id='$id'"; 
	$resultado_events = mysqli_query($conection, $result_events);
	
	//Verificar se alterou no banco de dados através "mysqli_affected_rows"
	if(mysqli_affected_rows($conection)){
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>O Evento editado com Sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		header("Location: index2.php?ids=$id_contr");
	}else{
		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao editar o evento <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		header("Location: index2.php?ids=$id_contr");
	}
	
}else{
	$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao editar o evento <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
	header("Location: index2.php?ids=$id_contr");
}