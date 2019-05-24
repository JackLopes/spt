<?php

session_start();

 $permissa = (int)$_SESSION['permissao'];

require_once 'Funcoes/limpa_string.php';
require_once 'database_gac.php';

$id_contrato = filter_input(INPUT_POST, 'id_contrato', FILTER_SANITIZE_NUMBER_INT);
$numero_aditivo = filter_input(INPUT_POST, 'numero_aditivo', FILTER_SANITIZE_STRING);
$tipo_aditivo = filter_input(INPUT_POST, 'tipo_aditivo', FILTER_SANITIZE_STRING);
$data_assinatura = filter_input(INPUT_POST, 'data_assinatura', FILTER_SANITIZE_STRING);



  $dados5 = filter_input_array(INPUT_POST, FILTER_DEFAULT);
  $_SESSION['dados5']=$dados5 ;

 

 if ( $permissa < 4) {   


if (!empty($id_contrato)) {
$erro = array();

if (empty($id_contrato)) {
$erro[] = 'Há problemas com a identificação do contrato';
} else if (is_numeric($id_contrato)) {
$id_contrato = mysqli_real_escape_string($conection, trim($id_contrato));
} else {
$erro[] = 'Há problemas com a identificação do contrato';
}


if (empty($numero_aditivo)) {
$erro[] = 'Insira o numero do aditivo.';
} else {
$numero_aditivo = mysqli_real_escape_string($conection, trim($numero_aditivo));
}


if (empty($tipo_aditivo)) {
$erro[] = 'Selecione o tipo de aditivo.';
} else {
$tipo_aditivo = mysqli_real_escape_string($conection, trim($tipo_aditivo));
}





if (empty($erro)) {

$q = "INSERT INTO aditivos (id_contrato, numero_aditivo, tipo_aditivo) VALUES 
	('$id_contrato', '$numero_aditivo ', '$tipo_aditivo')";

$r = mysqli_query($conection, $q)or die (mysqli_error($conection));

$id_aditivo = mysqli_insert_id($conection);



if ($r) {


$_SESSION['msg43'] = "<p style='color:green;'> Aditivo cadastrado com sucesso ! </p>";
header("Location:cad_aditivos.php?id=$id_contrato&id_aditivo=$id_aditivo");
} else {
$_SESSION['msg43'] = "<p style='color:red;'> O aditivo não foi cadastrado!</p>";
header("Location:cad_aditivos.php?id=$id_contrato");
}

}else{

foreach ($erro as $mg)
$_SESSION['msg43'] = "<div class='alert alert-danger' role='alert'>- $mg<br>\n</div>";
header("Location:cad_aditivos.php?id=$id_contrato");
}
}}
       else {
            
             $_SESSION['msg43'] = "<p style='color:red;'> Você não tem permissão para cadastrar registro</p>";
     header("Location:cad_aditivos.php?id=$id_contrato");
       
       
       }
  

