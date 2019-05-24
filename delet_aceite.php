<?php
session_start();
 require_once 'database_gac.php';
 
 $id_aceite = filter_input(INPUT_GET, 'id_aceite', FILTER_SANITIZE_NUMBER_INT);
 $id_tipo = filter_input(INPUT_GET, 'id_tipo', FILTER_SANITIZE_NUMBER_INT);
 $serie = filter_input(INPUT_GET, 'se',FILTER_SANITIZE_STRING);
 $patrimonio = filter_input(INPUT_GET, 'pa', FILTER_SANITIZE_STRING);
 $id_itens = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$dados = filter_input_array(INPUT_GET, FILTER_DEFAULT);
      
require_once 'database_gac.php';
require_once 'valida_permissao.php';




 if ($matricula === $mat AND $permissa < 4 or $permissa == '2') {

$result = "DELETE FROM aceite  WHERE id_aceite='$id_aceite'"; 
$resultado_pagamento = mysqli_query($conection, $result);

if (!empty($id_itens)) {
    $Sql = "SELECT prazo_entrega, entrega FROM itens  WHERE  id_itens='$id_itens' and  patrimonio = '$patrimonio'";
        $resultado = mysqli_query($conection, $Sql);
        while ($registro = mysqli_fetch_array($resultado)) {

            $prazo_entrega = $registro['prazo_entrega'];
            $entrega = $registro['entrega'];
        }
    

    $query6 = "SELECT prorrogacao FROM aceite WHERE id_iten = '$id_itens'";
    $result = mysqli_query($conection, $query6);
    $num = mysqli_num_rows($result);


    var_dump($num);

    if ($num == 0) {

        $result = "UPDATE  itens  SET  prorrogacao='0000-00-00' WHERE  id_itens='$id_itens' and  patrimonio = '$patrimonio'";
        $resultado = mysqli_query($conection, $result);

        
            $atraso_dias = (int) (( strtotime($entrega) / 86400) - (strtotime($prazo_entrega) / 86400) );
            
            if($atraso_dias < 0){
                $atraso_dias =0;
            }

            $sql7 = "UPDATE itens SET atraso_dias='$atraso_dias' WHERE  id_itens='$id_itens' and  patrimonio = '$patrimonio'";
            $r = mysqli_query($conection, $sql7);
        
    }
    else if ($num != 0) {

        $q = "SELECT * FROM aceite WHERE  patrimonio = '$patrimonio' and id_iten = '$id_itens' ";
        $r = mysqli_query($conection, $q);
        $num = mysqli_num_rows($r);
        while ($register = mysqli_fetch_assoc($r)) {
            $prorrogacaos = array();
            $prorrogacaos[] = $register ['prorrogacao'];
            $prorrogacao_max = max($prorrogacaos);
        }
       
          if($prorrogacao_max != '0000-00-00' ) { $prazo_entrega = $prorrogacao_max;}
        var_dump($entrega);

        $atraso_dias = (int) (( strtotime($entrega) / 86400) - (strtotime($prazo_entrega) / 86400) );
        
      if ($atraso_dias < 0) {
            $atraso_dias = 0;
            $aplicacao_multa = 0;
            
        } else {
            $aplicacao_multa = 1;
        }

        
        var_dump($atraso_dias);
      $result = "UPDATE  itens  SET  prorrogacao='$prorrogacao_max', aplicacao_multa = '$aplicacao_multa' WHERE  id_itens='$id_itens' and  patrimonio = '$patrimonio'";
        $resultado = mysqli_query($conection, $result);

     
        $result = "UPDATE  itens  SET  atraso_dias='$atraso_dias' WHERE  id_itens='$id_itens' and  patrimonio = '$patrimonio'";

        $resultado = mysqli_query($conection, $result);
}

if($resultado_pagamento){
	$_SESSION['msg24'] = "<span style='color:green;'> Registro apagado com sucesso</span>";
	  header("Location: cad_itens.php?id_tipo=$id_tipo");
}else{
	$_SESSION['msg24'] = "<span style='color:red;'> Registro não foi deletado</span>";
	 header("Location: cad_itens.php?id_tipo=$id_tipo");
}     
}
}else{$_SESSION['msg24'] = "<span style='color:red;'> Você não tem permissão para deletar esse registro</span>";
	 header("Location: cad_itens.php?id_tipo=$id_tipo");  
         }  

