<?php

session_start();

$id_pag = filter_input(INPUT_POST, 'id_pag', FILTER_SANITIZE_NUMBER_INT);
$recebimento_nota = filter_input(INPUT_POST, 'recebimento_nota', FILTER_SANITIZE_STRING);
$relatorio = filter_input(INPUT_POST, 'relatorio', FILTER_SANITIZE_STRING);
$ateste = filter_input(INPUT_POST, 'ateste', FILTER_SANITIZE_STRING);

require_once 'database_gac.php';


var_dump($recebimento_nota, $id_pag,$relatorio, $ateste);



if ($_GET['action'] == 'recebimentoRelatorio') {

    $q1 = "UPDATE pagamentos SET relatorio='$relatorio' WHERE id_pag='$id_pag'";
    $r1 = mysqli_query($conection, $q1);
    
} else if
 ($_GET['action'] == 'recebimentoNota') {
    
    $q1 = "UPDATE pagamentos SET recebimento_nota='$recebimento_nota' WHERE id_pag='$id_pag'";
    $r1 = mysqli_query($conection, $q1);
    
} else if
 ($_GET['action'] == 'finalizadoAteste') {
    
    $q1 = "UPDATE pagamentos SET ateste='$ateste' WHERE id_pag='$id_pag'";
    $r1 = mysqli_query($conection, $q1);
    
}


header("Location:atestes.php");



