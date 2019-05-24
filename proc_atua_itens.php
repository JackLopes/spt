<?php

session_start();


if (isset($_POST['id_tipo'])) {
    $id_tipo = (int) $_POST['id_tipo'];
}
if (isset($_POST['id_corretiva'])) {
    $id_corretiva = (int) $_POST['id_corretiva'];
}

require_once 'database_gac.php';

$aplicacao_multa = filter_input(INPUT_POST, 'aplicacao_multa', FILTER_SANITIZE_STRING);
$regional = filter_input(INPUT_POST, 'regional', FILTER_SANITIZE_STRING);
$id_itens = filter_input(INPUT_POST, 'id_itens', FILTER_VALIDATE_INT);
$id_aceite = filter_input(INPUT_POST, 'id_aceite', FILTER_VALIDATE_INT);
$id_contrato = filter_input(INPUT_POST, 'id_contrato', FILTER_VALIDATE_INT);





if (!empty($id_contrato)) {




    if ($aplicacao_multa == 'Sim') {


        $q = "SELECT id_multa FROM multa WHERE id_aceite = $id_aceite";
        $r = mysqli_query($conection, $q);
        $num = mysqli_num_rows($r);

        if ($num == 0) {

            //Seleção do registro com ocorrência

            $query = "SELECT ace.* , ite.patrimonio, ite.valor_unitario, ite.qtd_total,
                                ite.prazo_entrega								
				FROM aceite AS ace
				INNER JOIN itens AS ite ON  ite.id_itens = ace.id_iten				
				WHERE id_aceite = '$id_aceite'";


            $result = mysqli_query($conection, $query) or die(mysqli_error($conection));
            while ($registro = mysqli_fetch_array($result)) {

                $patrimonio = $registro['patrimonio'];
                $valor_unitario = $registro['valor_unitario'];
                $prazo_entrega = $registro['prazo_entrega'];
                $prorrogacao = $registro['prorrogacao'];
                $entrega = $registro['entrega'];
                $atraso_dias = $registro['atraso_dias'];
                $qtd_total = $registro['qtd_total'];
                $qtd_entrege = $registro['qtd_entrege'];

                //Seleção com registro com percentual de multa

                $sql2 = "SELECT percent_atrasoEntrega FROM contrato WHERE  id_contrato='$id_contrato'";
                $result2 = mysqli_query($conection, $sql2)or die('Não foi possivel conectar ao MySQL');
                while ($registro2 = mysqli_fetch_array($result2)) {

                    $percent_atrasoEntrega = $registro2['percent_atrasoEntrega'];
                }
            }
            $categoria = 2;
            $status = '2';

            $valor_total_entrega = $valor_unitario * $qtd_entrege;

            // Calculo do valor  pelo   atraso na   entrega   do   objeto   (produtos   e/ou   serviços)   em   relação   ao   prazo estipulado, sujeitar-se-á a  
            //CONTRATADA ao pagamento de multa de mora calculada à razão de 1% (um por cento) ao dia, sobre o valor da entrega fora do prazo previsto.
            $subtotal = ($percent_atrasoEntrega / 100) * $atraso_dias * $valor_total_entrega;




            $sql3 = "INSERT INTO multa (id_contrato, referencia , categoria, subtotal, regional, n_patrimonio, status ,id_itens, prazo_entrega_itens, prorrogacao_itens , entrega_itens,
              atraso_itens, id_aceite, valor_entrega) VALUES 
             ('$id_contrato','$valor_unitario','$categoria','$subtotal','$regional', '$patrimonio','$status','$id_itens','$prazo_entrega','$prorrogacao',
              '$entrega', ' $atraso_dias', '$id_aceite', '$valor_total_entrega') ";
            $r1 = mysqli_query($conection, $sql3);
        }
    } else {

        $sql4 = "SELECT id_multa FROM multa WHERE id_aceite = $id_aceite  AND  status='2'";
        $result4 = mysqli_query($conection, $sql4)or die('Não foi possivel conectar ao MySQL');
        while ($registro4 = mysqli_fetch_array($result4)) {

            $id_multa = $registro4['id_multa'];
        }

        if ($id_multa) {

            $sql5 = "DELETE FROM multa  WHERE id_multa='$id_multa'";
            $resultado_pagamento = mysqli_query($conection, $sql5);
        } else {
            $compemento_msg = 'Esta multa já foi aplicada';
        }
    }


//atualiza registro


    var_dump($compemento_msg);
    


    if ($aplicacao_multa == 'Sim') {
        $aplicacao_multa = 1;
    } else {
        $aplicacao_multa = 0;
    }



    $q1 = "UPDATE aceite SET  
            aplicacao_multa='$aplicacao_multa' WHERE id_aceite='$id_aceite'";

    $r1 = mysqli_query($conection, $q1);


    var_dump($r1);


    if ($q1) {

        if (!empty($compemento_msg)) {     


            $q1 = "UPDATE aceite SET  
            aplicacao_multa='1' WHERE id_aceite='$id_aceite'";
            $r1 = mysqli_query($conection, $q1);
            
          $_SESSION['msg38'] = "<p style='color:green;'> $compemento_msg </p>";
          header("Location: cad_aceite2.php?id_itens=$id_itens&id_tipo=$id_tipo");
          
        } else {

            $_SESSION['msg38'] = "<p style='color:green;'> Registro atualizado com sucesso </p>";
            header("Location: cad_aceite2.php?id_itens=$id_itens&id_tipo=$id_tipo");
        }
    } else {

        $_SESSION['msg38'] = "<p style='color:red;'> Registro não foi atualizado </p>";
        header("Location: cad_aceite2.php?id_itens=$id_itens&id_tipo=$id_tipo");
    }
} else {


    $_SESSION['msg38'] = "<p style='color:red;'>REgistro</p>";
    header("Location: cad_aceite2.php?id_itens=$id_itens&id_tipo=$id_tipo");
}





