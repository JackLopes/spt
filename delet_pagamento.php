<?php
session_start();
 require_once 'database_gac.php';
 $id_tipo = filter_input(INPUT_GET, 'id_tipo', FILTER_SANITIZE_NUMBER_INT);
 $id_pag = filter_input(INPUT_GET, 'id_pag', FILTER_SANITIZE_NUMBER_INT);
 
   $mat =  $_SESSION['matricula'];
   $permissa = $_SESSION['permissao'];
        
require_once 'database_gac.php';

 require_once 'valida_permissao.php';
 
 if ($matricula === $mat AND $permissa < 4 or $permissa == '2') {

$result = "DELETE FROM pagamentos  WHERE id_pag='$id_pag'"; 
$resultado_pagamento = mysqli_query($conection, $result);

var_dump($resultado_pagamento);


if(mysqli_affected_rows($conection)){
	$_SESSION['msg28'] = "<span style='color:green;'> Registro apagado com sucesso</span>";
	  header("Location: cad_pag.php?id_tipo=$id_tipo");
}else{
	$_SESSION['msg28'] = "<span style='color:red;'> Registro não foi deletado</span>";
	  header("Location: cad_pag.php?id_tipo=$id_tipo");
}     
}else{$_SESSION['msg28'] = "<span style='color:red;'> Você não tem permissão para deletar esse registro</span>";
	  header("Location: cad_pag.php?id_tipo=$id_tipo");    }  