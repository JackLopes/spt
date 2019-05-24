<?php

session_start();

$page_title = 'Corretiva';
if (isset($_POST['id_tipo'])) {
    $id_tipo = (int) $_POST['id_tipo'];
}
if (isset($_POST['id_corretiva'])) {
    $id_corretiva = (int) $_POST['id_corretiva'];
}
$patrimonio = filter_input(INPUT_POST, 'patrimonio', FILTER_SANITIZE_STRING);
require_once './func_corretiva.php';
require_once './Funcoes/func_corretiva_multa.php';

require_once 'database_gac.php';

if (verifica_previsao_multa($id_corretiva) == true) {


    if (verifica_lancamentos($id_corretiva) == true) {

        if (!empty($id_corretiva)) {




            $atendimento_onsite = ($_POST['atendimento_onsite']);
            $aplicacao_multa = ($_POST['aplicacao_multa']);

            $q = "SELECT id_multa FROM multa WHERE id_corretiva = $id_corretiva";
            $r = mysqli_query($conection, $q);

            if ($aplicacao_multa == 'Sim') {



                $num = mysqli_num_rows($r);

                if ($num == 0) {

                    //Seleção do registro com ocorrência

                    $sql = "SELECT n_chamado,data_abertura,hora_abertura,data_atendimento, hora_atendimento, 
                data_conclusao, hora_conclusao, tempo_excedido_atendimento,tempo_excedido_conclusao,
                tipo_severidade,prazo_atendimento,prazo_conclusao, n_patrimonio, subtotal_atendimento,
                subtotal_conclusao,total,id_contrato, regional,rg , tipos FROM corretivas WHERE id_corretiva = '$id_corretiva'";

                    $result = mysqli_query($conection, $sql)or die('Não foi possivel conectar ao MySQL');
                    while ($registro = mysqli_fetch_array($result)) {

                        $n_chamado = $registro['n_chamado'];
                        $data_abertura = $registro['data_abertura'];
                        $hora_abertura = $registro['hora_abertura'];
                        $data_atendimento = $registro['data_atendimento'];
                        $hora_atendimento = $registro['hora_atendimento'];
                        $data_conclusao = $registro['data_conclusao'];
                        $hora_conclusao = $registro['hora_conclusao'];
                        $tempo_excedido_atendimento = $registro['tempo_excedido_atendimento'];
                        $tempo_excedido_conclusao = $registro['tempo_excedido_conclusao'];
                        $tipo_severidade = (int) $registro['tipo_severidade'];

                        $prazo_atendimento = $registro['prazo_atendimento'];
                        $prazo_conclusao = $registro['prazo_conclusao'];
                        $n_patrimonio = $registro['n_patrimonio'];
                        $subtotal_atendimento = $registro['subtotal_atendimento'];
                        $subtotal_conclusao = $registro['subtotal_conclusao'];
                        $total = $registro['total'];
                        $id_contrato = $registro['id_contrato'];
                        $regional = $registro['regional'];
                        $rg = $registro['rg'];
                        $tipos = $registro['tipos'];

                        //Seleção com registro com percentual de multa

                        $sql2 = "SELECT multa, valorFixo FROM severidades WHERE  severidade='$tipo_severidade' AND item='$tipos' AND id_contrato = '$id_contrato'";
                        $result2 = mysqli_query($conection, $sql2)or die('Não foi possivel conectar ao MySQL');
                        while ($registro2 = mysqli_fetch_array($result2)) {

                            $multa = $registro2['multa'];
                            $tipo_atendimento = $registro2['tipo_atendimento'];
                            $valorFixo = floatval($registro2['valorFixo']);
                        }
                    }

                    $categoria = 5; // modalidade de multa

                    if ($n_patrimonio != "") {

                        $sq3 = "SELECT *  FROM contrato WHERE  id_contrato = '$id_contrato' ";
                        $resultado = mysqli_query($conection, $sq3)or die('Não foi possivel conectar ao MySQL');
                        while ($registro = mysqli_fetch_array($resultado)) {

                            $percent_atrasoEntrega = floatval($registro['percent_atrasoEntrega']);
                            $percent_naoObjeto = floatval($registro['percent_naoObjeto']);
                            $percent_descumprimento = floatval($registro['percent_descumprimento']);
                            $valor_Contratado = floatval($registro['valor_Contratado']);
                            $parametro_multa = (int) $registro['parametro_multa'];
                        }


                        $query = "SELECT cont.*,  it.valor_unitario
								
				FROM contrato AS cont
				INNER JOIN local AS loc ON  loc.Id_contrato = cont.id_contrato
				INNER JOIN  tipo AS tip ON  tip.id_local = loc.id_local
				INNER JOIN  itens AS it ON  it.id_tipo = tip.id_tipo
				WHERE cont.id_contrato = '$id_contrato'AND it.patrimonio = '$patrimonio'";
                        $resultado = mysqli_query($conection, $query)or die(mysqli_error($conection));
                        while ($registro = mysqli_fetch_array($resultado)) {

                            $valor_unitario = floatval($registro['valor_unitario']);
                        }


                        if ($valorFixo <= 0) {
                            $taxa = $multa;
                        } else if ($multa <= 0) {
                            $taxa = $valorFixo;
                        }


                        $total_horas_atraso = $total;

                        if ($parametro_multa ) {

                            switch ($parametro_multa) {
                                case 1:

                                    $valor_unitario = total_item_horas_atraso($patrimonio, $id_contrato);
                                    var_dump($valor_unitario);
                                    $referencia = floatval($valor_unitario);
                                    $subtotal = $total_horas_atraso * $referencia * ($taxa / 100);

                                    break;
                                case 2:
                                    $referencia = floatval($valor_Contratado) * ($taxa / 100) / 60;
                                    $subtotal = $total_horas_atraso * $referencia;
                                    break;
                                case 3:
                                    $referencia = floatval($valorFixo);
                                    $subtotal = $total_horas_atraso * $valorFixo;
                                    break;
                                case 4:
                                    $referencia = floatval($valor_Contratado) * ($taxa / 100);
                                    $subtotal = $total_horas_atraso * $referencia;
                                    break;
                                case 5:
                                   /* $total_parcela_regional_geral = total_mensal_geral($id_contrato, $data_abertura);
                                    $referencia = ($total_parcela_regional_geral) * ($taxa / 100);
                                    $subtotal = $total_horas_atraso * $referencia;*/
                                    $subtotal=0;
                                    break;
                                case 6:

                                   /* $total_parcela_regional = total_mensal_regional($regional, $id_contrato, $data_abertura);
                                    $referencia = ($total_parcela_regional) * ($taxa / 100);
                                    $subtotal = $total_horas_atraso * $referencia;*/
                                    $subtotal=0;
                                    break;
                            }





                            $sql3 = "INSERT INTO multa (id_contrato,rg,referencia, categoria,subtotal, id_corretiva,n_chamado,regional,data_abertura,hora_abertura,data_atendimento,hora_atendimento,
              data_conclusao,hora_conclusao,tempo_excedido_atendimento,tempo_excedido_conclusao,tipo_severidade,
             prazo_atendimento,prazo_conclusao,n_patrimonio,subtotal_atendimento,subtotal_conclusao,total,taxa,parametro_multa ) VALUES 
             ('$id_contrato','$rg','$referencia','$categoria','$subtotal','$id_corretiva', '$n_chamado','$regional', '$data_abertura','$hora_abertura','$data_atendimento','$hora_atendimento',
              '$data_conclusao', ' $hora_conclusao','$tempo_excedido_atendimento', '$tempo_excedido_conclusao',
                '$tipo_severidade', '$prazo_atendimento','$prazo_conclusao','$n_patrimonio', '$subtotal_atendimento', 
               '$subtotal_conclusao', '$total', '$multa','$parametro_multa') ";
                            $r1 = mysqli_query($conection, $sql3);
                        } else {

                            $_SESSION['msg38'] = "<p style='color:red;'> É necessario Atualizar contrato e inserir  o <b>TIPO DE PENALIDADE</b>. </p>";
                            header("Location: cad_corretiva.php?id_tipo=$id_tipo");
                            $aplicacao_multa = "Verificar";

                            $q1 = "UPDATE corretivas SET  
            aplicacao_multa='$aplicacao_multa', atendimento_onsite='$atendimento_onsite',  criado='NOW()' WHERE id_corretiva='$id_corretiva'";

                            $r1 = mysqli_query($conection, $q1);

                            exit;
                        }
                    } else {
                        $agregado = array();

                        $agregado = "<p style='color:red;'> OBS: Para que esta previsão de multa seja computada em Incidência de Multas, é necessário que o registro possua o número do patrimônio </p>";

                        $aplicacao_multa = "Verificar";
                    }
                }
            } else {

                $sql4 = "SELECT id_multa FROM multa WHERE id_corretiva = $id_corretiva";
                $result4 = mysqli_query($conection, $sql4)or die('Não foi possivel conectar ao MySQL');
                while ($registro4 = mysqli_fetch_array($result4)) {

                    $id_multa = $registro4['id_multa'];
                }

                $sql4 = "DELETE FROM multa  WHERE id_multa='$id_multa'";
                $resultado_pagamento = mysqli_query($conection, $sql4);
            }




            $q1 = "UPDATE corretivas SET  
            aplicacao_multa='$aplicacao_multa', atendimento_onsite='$atendimento_onsite',  criado='NOW()' WHERE id_corretiva='$id_corretiva'";

            $r1 = mysqli_query($conection, $q1);

            if ($q1) {

                if (count($agregado) > 0) {
                    $_SESSION['msg38'] = "<p style='color:green;'>  <p>$agregado</p>";
                } else {
                    $_SESSION['msg38'] = "<p style='color:green;'> Registro atualizado com sucesso </p>";
                }

                header("Location: cad_corretiva.php?id_tipo=$id_tipo");
            } else {

                $_SESSION['msg38'] = "<p style='color:red;'> Registro não foi atualizado </p>";
                header("Location: cad_corretiva.php?id_tipo=$id_tipo");
            }
        } else {
            foreach ($erro as $mg) {

                $_SESSION['msg38'] = "<p style='color:red;'>$mg</p>";
                header("Location: cad_corretiva.php?id_tipo=$id_tipo");
            }
        }
    } else {
        $_SESSION['msg38'] = "<p style='color:red;'> Este valor não pode ser alterado, Multa Aplicada !</p>";
        header("Location: cad_corretiva.php?id_tipo=$id_tipo");
    }
} else {
    $_SESSION['msg38'] = "<p style='color:red;'> Não há previsão de multa para este chamado</p>";
    header("Location: cad_corretiva.php?id_tipo=$id_tipo");
}


