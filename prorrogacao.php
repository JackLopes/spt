<?php

session_start();
include_once 'database_gac.php';



$detalhe = filter_input(INPUT_POST, 'detalhe', FILTER_SANITIZE_STRING);
$d_prorrogada = filter_input(INPUT_POST, 'd_prorrogada', FILTER_SANITIZE_STRING);
$id_contrato = filter_input(INPUT_POST, 'id_contrato', FILTER_SANITIZE_NUMBER_INT);
$tipo_prorog = (int)filter_input(INPUT_POST, 'tipo_prorog', FILTER_SANITIZE_NUMBER_INT);




if (!empty($id_contrato) AND ! empty($tipo_prorog) AND ! empty($d_prorrogada)) {


    $result = "INSERT INTO historico_prorrogacao (id_contrato, tipo_prorog,d_prorrogada, detalhe)"
            . " VALUES ('$id_contrato','$tipo_prorog','$d_prorrogada', '$detalhe')";
    $resultado = mysqli_query($conection, $result);
    
    
if($tipo_prorog == 1){

    $q = "SELECT * FROM  historico_prorrogacao WHERE  id_contrato = '$id_contrato'  AND tipo_prorog='1'";
    $r = mysqli_query($conection, $q);
    $num = mysqli_num_rows($r);
    while ($register = mysqli_fetch_assoc($r)) {
        $prorrogacaos = array();
        $prorrogacaos[] = $register ['d_prorrogada'];
        $prorrogacao = max($prorrogacaos);

        if (!empty($prorrogacao)) {

            $sql8 = "UPDATE contrato SET prazo_entrega ='$prorrogacao' WHERE id_contrato ='$id_contrato'";
            $r8 = mysqli_query($conection, $sql8);
            
           
        }
    }
    
}else
// garantia de execução
if($tipo_prorog == 2){
    $q = "SELECT * FROM  historico_prorrogacao WHERE  id_contrato = '$id_contrato'  AND tipo_prorog='2'";
    $r = mysqli_query($conection, $q);
    $num = mysqli_num_rows($r);
    while ($register = mysqli_fetch_assoc($r)) {
        $prorrogacaos = array();
        $prorrogacaos[] = $register ['d_prorrogada'];
        $prorrogacao2 = max($prorrogacaos);

        if (!empty($prorrogacao2)) {

            $sql8 = "UPDATE contrato SET entrega_garantia_exc ='$prorrogacao2' WHERE id_contrato ='$id_contrato'";
            $r8 = mysqli_query($conection, $sql8);
        }
    }
}





    $_SESSION['msg23'] = "<p style='color:green;'> Prorrogação  cadastrada com sucesso </p>";

    header("Location:idex.php?id=$id_contrato");
} else {
    $_SESSION['msg23'] = "<p style='color:red;'>Não foi possivel efetuar o cadastrado da Prorrogação </p>";

    header("Location:idex.php?id=$id_contrato");
}
