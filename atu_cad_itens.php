<?php

session_start();

include_once 'database_gac.php';

$id_itens = filter_input(INPUT_POST, 'id_itens', FILTER_SANITIZE_NUMBER_INT);



$id_tipo = filter_input(INPUT_POST, 'id_tipo', FILTER_SANITIZE_NUMBER_INT);
$categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_NUMBER_INT);
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

$qtd_total = filter_input(INPUT_POST, 'qtd_total', FILTER_SANITIZE_STRING);
$qtd_entrege = filter_input(INPUT_POST, 'qtd_entrege', FILTER_SANITIZE_STRING);
$ativo = (int) filter_input(INPUT_POST, 'ativo', FILTER_SANITIZE_STRING);
$Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);


var_dump($prorrogacao);



$valor_unitario = (float) $valor_unitario;

require_once 'valida_permissao.php';

$permissa = (int) $permissa;


//Se action vier do formulario de prorrogaão
if ($_REQUEST['action'] == 'prorro') {

    if (!empty($entrega) && !empty($qtd_entrege)){

//validação do valor lançado atraves da tabela aceite e o valor total estipulado

    $sq5 = "SELECT SUM(qtd_entrege) AS qtd_entregue_itens ,  SUM(atraso_dias) AS atraso_dias_itens  FROM aceite WHERE id_iten = '$id_itens'";
    $result = mysqli_query($conection, $sq5)or die('Não foi possivel conectar ao MySQL');
    while ($registro5 = mysqli_fetch_array($result)) {

        $qtd_entregue_itens = $registro5['qtd_entregue_itens'];
        $atraso_dias_itens = (int) $registro['atraso_dias_itens'];


        if ($qtd_entregue_itens == null) {
            $qtd_entregue_itens = 0;
        }
        if ($atraso_dias_itens == null) {
            $atraso_dias_itens = 0;
        }
    }



    if ($qtd_total < $qtd_entregue_itens + $qtd_entrege) {
        $erro[] = 'Valor Inadequado';
    }

    if (empty($erro)) {



        // insere nova linha na tabela caeite e o prazo de entrega  na tabela aceite

        $result = "INSERT INTO aceite(id_iten, observacao, prorrogacao, categoria, patrimonio,entrega  )  VALUES ('$id_itens', 
            '$observacao', '$prorrogacao','$categoria', '$patrimonio','$entrega')";
        $resultado = mysqli_query($conection, $result);
        $id_return = mysqli_insert_id($conection);





        var_dump($id_return);



        // Seleciona todas prorrogaçõe da tabela de mesmo id e obtem o maior

        $q = "SELECT * FROM aceite WHERE  id_iten = '$id_itens' ";
        $r = mysqli_query($conection, $q);
        $num = mysqli_num_rows($r);
        while ($register = mysqli_fetch_assoc($r)) {
            $prorrogacaos = array();
            $prorrogacaos[] = $register ['entrega'];
            $prorrogacao_max = max($prorrogacaos);
        }
        if ($prorrogacao_max != "0000-00-00") {
            $prazo_entrega = $prorrogacao_max;
        }

  // Atualiza a tabela iten quanto a maior data efetuada para entrega
        $result1 = "UPDATE  itens  SET  prorrogacao='$prorrogacao_max'  WHERE  id_itens='$id_itens'";
        $resultado1 = mysqli_query($conection, $result1);
        


/*

        $sql4 = "SELECT id_multa FROM multa WHERE id_aceite = '$id_return'  AND  status='2'";
        $result4 = mysqli_query($conection, $sql4)or die('Não foi possivel conectar ao MySQL');
        while ($registro4 = mysqli_fetch_array($result4)) {

            $id_multa = $registro4['id_multa'];
        }

        $sql3 = "DELETE FROM multa  WHERE id_multa='$id_multa'";
        $resultado_pagamento = mysqli_query($conection, $sql3);

*/

//calcula dias de atraso
        $atraso_dias = (int) (( strtotime($entrega) / 86400) - (strtotime($prorrogacao) / 86400) );



        //   var_dump("Prazo:".$prazo_entrega,"Entrega:".$entrega,"Prorrogacao:".$prorrogacao, "Atraso:".$atraso_dias, "Id_Itens:".$id_itens);
        // var_dump($atraso_dias);

        if ($atraso_dias < 0) {
            $atraso_dias = 0;
            $aplicacao_multa = 0;
        } else {
            $aplicacao_multa = 3;
        }



//atualiza a tabela aceite 

        $result = "UPDATE  aceite  SET  qtd_entrege='$qtd_entrege', entrega='$entrega',
           atraso_dias='$atraso_dias', 
             aplicacao_multa ='$aplicacao_multa' WHERE id_aceite='$id_return'";
        $resultado = mysqli_query($conection, $result) or die(mysqli_error($conection));



        
       //Direciona para atualizaar todos registros caso haja prorrogação (precisa haver Lançamento)
        
        header("Location:entrega_aultomatico.php?id_itens=$id_itens&id_tipo=$id_tipo");
        
        
         exit();
        
    } else {
        foreach ($erro as $mg) {

            $_SESSION['msg38'] = "<p style='color:red;'>$mg</p>";
            header("Location:cad_aceite2.php?id_itens=$id_itens&id_tipo=$id_tipo");

            exit();
        }
    }
    } else {
         $_SESSION['msg23'] = "<p style='color:red;'>Insira a quantidade e a data da entrega</p>";
         header("Location:cad_itens.php?id_tipo=$id_tipo");
    }
    
} else if (!empty($valor_unitario)) {

//atualização da linha na tabela itens (update)


    $q1 = "SELECT * FROM  responsaveis WHERE id_resp = '$id_resp' ";
    $r1 = mysqli_query($conection, $q1);
    while ($row = mysqli_fetch_assoc($r1)) {

        $responsavel = $row ['nome'];
        $area = $row ['area'];
    }


    $sub_total = $qtd_total * $valor_unitario;

    $result = "UPDATE  itens  SET   descricao='$descricao', responsavel='$responsavel', area='$area', patrimonio='$patrimonio', serie='$serie', 
            valor_unitario='$valor_unitario', Observacao='$observacao',qtd_total='$qtd_total',sub_total = '$sub_total', ativo ='$ativo' WHERE  id_itens='$id_itens'  ";

    $resultado = mysqli_query($conection, $result);

    if ($resultado) {
        $_SESSION['msg23'] = $usu . "<p style='color:green;'> Registro atualizado com sucessoss </p>";

        header("Location:cad_itens.php?id_tipo=$id_tipo");
    } else {
        $_SESSION['msg23'] = "<p style='color:red;'> Registro não foi  atualizado  </p>";
        header("Location:cad_itens.php?id_tipo=$id_tipo");
    }
} else {

    $_SESSION['msg23'] = "<p style='color:red;'> Preencha os campos </p>";
    header("Location:cad_itens.php?id_tipo=$id_tipo");
}
        
        