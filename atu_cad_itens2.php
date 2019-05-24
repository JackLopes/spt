<?php

session_start();

include_once 'database_gac.php';

$id_itens = filter_input(INPUT_POST, 'id_itens', FILTER_SANITIZE_NUMBER_INT);
$id_aceite = (int) filter_input(INPUT_POST, 'id_aceite', FILTER_SANITIZE_NUMBER_INT);
$id_tipo = filter_input(INPUT_POST, 'id_tipo', FILTER_SANITIZE_NUMBER_INT);
$categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_NUMBER_INT);
$qtd_entrege = filter_input(INPUT_POST, 'qtd_entrege', FILTER_SANITIZE_NUMBER_INT);
$descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
$observacao = filter_input(INPUT_POST, 'observacao', FILTER_SANITIZE_STRING);
$patrimonio = filter_input(INPUT_POST, 'patrimonio', FILTER_SANITIZE_STRING);
$serie = filter_input(INPUT_POST, 'serie', FILTER_SANITIZE_STRING);
$valor_unitario = filter_input(INPUT_POST, 'valor_unitario', FILTER_SANITIZE_STRING);
$id_resp = filter_input(INPUT_POST, 'id_resp', FILTER_SANITIZE_NUMBER_INT);
$entrega = filter_input(INPUT_POST, 'entrega', FILTER_SANITIZE_STRING);
$prazo_entrega = filter_input(INPUT_POST, 'prazo_entrega', FILTER_SANITIZE_STRING);
$rec_provisorio = filter_input(INPUT_POST, 'rec_provisorio', FILTER_SANITIZE_STRING);
$data_instalacao = filter_input(INPUT_POST, 'data_instalacao', FILTER_SANITIZE_STRING);
$prorrogacao = filter_input(INPUT_POST, 'prorrogacao', FILTER_SANITIZE_STRING);
$clean = (int) filter_input(INPUT_POST, 'clean', FILTER_SANITIZE_STRING);
$qtd_total = filter_input(INPUT_POST, 'qtd_total', FILTER_SANITIZE_STRING);
$qtd_entregue = filter_input(INPUT_POST, 'qtd_entrege', FILTER_SANITIZE_STRING);
$Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$valor_unitario = (float) $valor_unitario;





require_once 'valida_permissao.php';

$severi = "SELECT  ace.*,ite.qtd_total, ite.qtd_entregue_itens
				FROM aceite as ace
                                INNER JOIN itens AS ite ON  ite.id_itens = ace.id_iten
				WHERE id_iten = '$id_itens'";
$resultado = mysqli_query($conection, $severi)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado)) {

    $qtd_entr[] = (int) $registro ['qtd_entrege'];
    $atraso_d[] = (int) $registro ['atraso_dias'];

    $qtd_entregue_itens = (int) $registro ['qtd_entregue_itens'];
    $qtd_total = (int) $registro ['qtd_total'];
    //$resul_entega = $qtd_entregas1 - $qtd_entrege;
}
$qtd_entreg = array_sum($qtd_entr);
$atraso_di = array_sum($atraso_d);


$permissa = (int) $permissa;

if (( $permissa < 4) || $permissa == '2') {
//Se action vier do formulario de prorrogaão
    if ($_REQUEST['action'] == 'obs') {

        if ($clean === 1) {


            /*

              $sql8 = "SELECT qtd_entrege, atraso_dias FROM aceite WHERE id_aceite = '$id_aceite'";
              $result8 = mysqli_query($conection, $sql8)or die('Não foi possivel conectar ao MySQL');
              while ($registro8 = mysqli_fetch_array($result8)) {

              $qtd_entrege = (int) $registro8['qtd_entrege'];
              $atraso_dias = (int) $registro8['atraso_dias'];
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
            
            // atualiza tabela itens
            $result1 = "UPDATE  itens  SET  qtd_entregue_itens='0' WHERE id_itens='$id_itens'";
            $resultado1 = mysqli_query($conection, $result1) or die(mysqli_error($conection));
           */ 
            
            
            
            
            //atualiza tabela aceite para novo lançamento
            $result2 = "UPDATE  aceite  SET rec_provisorio='0000-00-00' ,data_intalacao='0000-00-00' WHERE id_aceite='$id_aceite'";
            $resultado2 = mysqli_query($conection, $result2) or die(mysqli_error($conection));
        }





        $result = "UPDATE aceite SET observacao='$observacao' WHERE $id_aceite ='id_aceite'";
        $resultado = mysqli_query($conection, $result) or die(mysqli_error($conection));


        $_SESSION['msg38'] = "<p style='color:green;'> Registro atualizado com sucessos </p>";

        header("Location:cad_aceite2.php?id_itens=$id_itens&id_tipo=$id_tipo");
    } else if ($_REQUEST['action'] == 'entregas') {


        $sql8 = "SELECT  prorrogacao, entrega FROM aceite WHERE id_aceite = '$id_aceite'";
        $result8 = mysqli_query($conection, $sql8)or die('Não foi possivel conectar ao MySQL');
        while ($registro8 = mysqli_fetch_array($result8)) {

            $entrega = $registro8['entrega']; // data da entrega
            $prorrogacao = $registro8['prorrogacao']; // prazo de entrega
        }





        $erro = array();

     /*   if (empty($qtd_entregue)) {
            $erro[] = 'Informe a quantidade da entrega';
        }
*/
//caso haja data de instalação , esta assume o paramentro para calculo.
        if (!empty($data_instalacao)) {

            $data_valida = $data_instalacao;
        } else {
            $data_valida = $entrega;
        }




       

/*

        if ($qtd_total < $qtd_entregue_itens + $qtd_entregue) {
            $erro[] = 'Valor maior que o permitido';
        }
 * 
 */

        if (empty($erro)) {


            /*
              $sql4 = "SELECT id_multa FROM multa WHERE id_aceite = $id_aceite  AND  status='2'";
              $result4 = mysqli_query($conection, $sql4)or die('Não foi possivel conectar ao MySQL');
              while ($registro4 = mysqli_fetch_array($result4)) {

              $id_multa = $registro4['id_multa'];
              }

              $sql3 = "DELETE FROM multa  WHERE id_multa='$id_multa'";
              $resultado_pagamento = mysqli_query($conection, $sql3);

             */




            if (!empty($prorrogacao)) {







//calculo dos dias de atraso, este calculo é necessario pois havendo data de instalação os dias de atrso seraõ atualizados na tabela aceite


                $atraso_dias = (int) (( strtotime($data_valida) / 86400) - (strtotime($prorrogacao) / 86400) );



                //   var_dump("Prazo:".$prazo_entrega,"Entrega:".$entrega,"Prorrogacao:".$prorrogacao, "Atraso:".$atraso_dias, "Id_Itens:".$id_itens);
                // var_dump($atraso_dias);

                if ($atraso_dias < 0) {
                    $atraso_dias = 0;
                    $aplicacao_multa = 0;
                } else {
                    $aplicacao_multa = 3;
                }





                $result = "UPDATE  aceite  SET  entrega='$entrega',
             rec_provisorio='$rec_provisorio', data_intalacao='$data_instalacao', atraso_dias='$atraso_dias', 
             aplicacao_multa ='$aplicacao_multa' WHERE id_aceite='$id_aceite'";
                $resultado = mysqli_query($conection, $result) or die(mysqli_error($conection));

// a tabela itens armazena os valores para exibição e armazenamento do status, isso é feito no proprio formulario itens


                /*
                  $qtd_entregas1 = $qtd_entreg + $qtd_entregue;
                  $atraso_dias1 = $atraso_dias + $atraso_di;

                  $result1 = "UPDATE  itens  SET  qtd_entregue_itens='$qtd_entregas1', atraso_dias_itens='$atraso_dias1' WHERE id_itens='$id_itens'";
                  $resultado1 = mysqli_query($conection, $result1) or die(mysqli_error($conection));
                 */





                if ($resultado) {
                    $_SESSION['msg38'] = $usu . "<p style='color:green;'> Registro atualizado com sucessos </p>";

                    header("Location:cad_aceite2.php?id_itens=$id_itens&id_tipo=$id_tipo");
                } else {
                    $_SESSION['msg38'] = "<p style='color:red;'> Registro não foi  atualizado  </p>";
                    header("Location:cad_aceite2.php?id_itens=$id_itens&id_tipo=$id_tipo");
                }
            } else {

                $erro[] = 'Necessario Lançar Prazo de Entrega do Contrato';
            }
        } else {
            foreach ($erro as $mg) {

                $_SESSION['msg38'] = "<p style='color:red;'>$mg</p>";
                header("Location:cad_aceite2.php?id_itens=$id_itens&id_tipo=$id_tipo");
            }
        }
    }
} else {
    $_SESSION['msg38'] = "<p style='color:red;'> Você não tem permissão para atualizar registros</p>";
    header("Location:cad_aceite2.php?id_itens=$id_itens&id_tipo=$id_tipo");
}
     
