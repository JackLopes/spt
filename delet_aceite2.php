<?php

session_start();
require_once 'database_gac.php';

$id_aceite = filter_input(INPUT_GET, 'id_aceite', FILTER_SANITIZE_NUMBER_INT);
$id_tipo = filter_input(INPUT_GET, 'id_tipo', FILTER_SANITIZE_NUMBER_INT);
$id_itens = filter_input(INPUT_GET, 'id_itens', FILTER_VALIDATE_INT);


$dados = filter_input_array(INPUT_GET, FILTER_DEFAULT);

require_once 'database_gac.php';
require_once 'valida_permissao.php';

if ($matricula === $mat AND $permissa < 4 or $permissa == '2') {
    
                   
     $sql8 = "SELECT qtd_entrege, atraso_dias FROM aceite WHERE id_aceite = '$id_aceite'";
    $result8 = mysqli_query($conection, $sql8)or die('Não foi possivel conectar ao MySQL');
    while ($registro8 = mysqli_fetch_array($result8)) {

        $qtd_entrege = (int)$registro8['qtd_entrege'];
         $atraso_dias = (int)$registro8['atraso_dias'];
       
        
    }
       
  
   
    $severi9 = "SELECT  qtd_entregue_itens, atraso_dias_itens FROM itens  WHERE id_itens = '$id_itens'";
    $resultado9 = mysqli_query($conection, $severi9)or die('Não foi possivel conectar ao MySQL');
    while ($registro9 = mysqli_fetch_array($resultado9)) {

        $qtd_entregue_itens = (int)$registro9['qtd_entregue_itens'];
        $atraso_dias_itens = $registro9['atraso_dias_itens'];
    }

  
    $valor_entregue = $qtd_entregue_itens - $qtd_entrege;
    $valor_atraso_dias_itens = $atraso_dias_itens - $atraso_dias;
    
    if( $valor_atraso_dias_itens < 0){
        $valor_atraso_dias_itens = 0;
    }
    if( $valor_entregue < 0){
        $valor_entregue = 0;
    }
  
    $result1 = "UPDATE  itens  SET  qtd_entregue_itens='$valor_entregue', atraso_dias_itens ='$valor_atraso_dias_itens' WHERE id_itens='$id_itens'";
    $resultado1 = mysqli_query($conection, $result1) or die(mysqli_error($conection));
    
    

// deleta a multa atribuida a este registro

    $sql4 = "SELECT id_multa FROM multa WHERE id_aceite = $id_aceite  AND  status='2'";
    $result4 = mysqli_query($conection, $sql4)or die('Não foi possivel conectar ao MySQL');
    while ($registro4 = mysqli_fetch_array($result4)) {

        $id_multa = $registro4['id_multa'];
    }

    $sql4 = "DELETE FROM multa  WHERE id_multa='$id_multa'";
    $resultado_pagamento = mysqli_query($conection, $sql4);
    
    
    // deleta o registro em questaõ da tabela aceite

    $result = "DELETE FROM aceite  WHERE id_aceite='$id_aceite'";
    $resultado_pagamento = mysqli_query($conection, $result);

    
    
    
    
    

//atualiza a tabela itens

    $q = "SELECT * FROM aceite WHERE  id_iten = '$id_itens' ";
    $r = mysqli_query($conection, $q);

    $num = mysqli_num_rows($r);
    while ($register = mysqli_fetch_assoc($r)) {
        $prorrogacaos = array();
        $prorrogacaos[] = $register ['prorrogacao'];
        $prorrogacao_max = max($prorrogacaos);
    }

// atualiza valores entregues
    
    var_dump($num);

    if ($num === 0) {

        $result = "UPDATE  itens  SET  prorrogacao='0000-00-00' WHERE  id_itens='$id_itens'";
        $resultado = mysqli_query($conection, $result);
    } else {
        $result = "UPDATE  itens  SET  prorrogacao='$prorrogacao_max' WHERE  id_itens='$id_itens'";
        $resultado = mysqli_query($conection, $result);
    }





    if ($result) {
        $_SESSION['msg24'] = "<span style='color:green;'> Registro apagado com sucesso</span>";
        header("Location:cad_aceite2.php?id_itens=$id_itens&id_tipo=$id_tipo");
    } else {
        $_SESSION['msg24'] = "<span style='color:red;'> Registro não foi deletado</span>";
        header("Location:cad_aceite2.php?id_itens=$id_itens&id_tipo=$id_tipo");
    }
  
} else {
    $_SESSION['msg24'] = "<span style='color:red;'> Você não tem permissão para deletar esse registro</span>";
    header("Location:cad_aceite2.php?id_itens=$id_itens&id_tipo=$id_tipo");
}  

