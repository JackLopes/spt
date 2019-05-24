<?php
session_start();
 require_once 'database_gac.php';
 $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
 $id_aditivo = filter_input(INPUT_GET, 'id_aditivo', FILTER_SANITIZE_NUMBER_INT);
 

 
   $mat =  $_SESSION['matricula'];
   $permissa = $_SESSION['permissao'];
        
require_once 'database_gac.php';

 require_once 'valida_permissao.php';
 
 if ($matricula === $mat AND $permissa < 4 or $permissa == '2') {

$result = "DELETE FROM aditivos  WHERE id_aditivo='$id_aditivo'"; 
$resultado_pagamento = mysqli_query($conection, $result);

var_dump($resultado_pagamento);


if(mysqli_affected_rows($conection)){
	$_SESSION['msg43'] = "<span style='color:green;'> Registro apagado com sucesso</span>";
	  header("Location: cad_aditivos.php?id=$id");
}else{
	$_SESSION['msg43'] = "<span style='color:red;'> Registro não foi deletado</span>";
	  header("Location: cad_aditivos.php?id=$id");
}     
}else{$_SESSION['msg43'] = "<span style='color:red;'> Você não tem permissão para deletar esse registro</span>";
	  header("Location: cad_aditivos.php?id=$id");    }  