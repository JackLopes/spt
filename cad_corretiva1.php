<?php

session_start();


$id_tipo = filter_input(INPUT_POST, 'id_tipo', FILTER_SANITIZE_NUMBER_INT);

$ct = filter_input(INPUT_POST, 'ct', FILTER_SANITIZE_NUMBER_INT);
$atu_previsao_multa = (int) filter_input(INPUT_POST, 'atu_previsao_multa', FILTER_SANITIZE_STRING);

//mantem status ja calculado
$previsao_multa = filter_input(INPUT_POST, 'previsao_multa', FILTER_SANITIZE_STRING);
$id_corretiva = filter_input(INPUT_POST, 'id_corretiva', FILTER_SANITIZE_NUMBER_INT);

$severidade = (int) filter_input(INPUT_POST, 'tipo_severidade', FILTER_SANITIZE_NUMBER_INT);
$n_chamado = filter_input(INPUT_POST, 'n_chamado', FILTER_SANITIZE_STRING);
$n_patrimonio = filter_input(INPUT_POST, 'n_patrimonio', FILTER_SANITIZE_STRING);
$chamado = filter_input(INPUT_POST, 'tch', FILTER_SANITIZE_STRING);
$regional = filter_input(INPUT_POST, 'regional', FILTER_SANITIZE_STRING);
$rg = filter_input(INPUT_POST, 'rg', FILTER_SANITIZE_STRING);
$tipo = filter_input(INPUT_POST, 'tipos', FILTER_SANITIZE_STRING);
$requis = filter_input(INPUT_POST, 'resumo_demanda', FILTER_SANITIZE_STRING);
$tecnico = filter_input(INPUT_POST, 'tecnico', FILTER_SANITIZE_STRING);
$rdemanda = filter_input(INPUT_POST, 'resumo_demanda', FILTER_SANITIZE_STRING);
$obs = filter_input(INPUT_POST, 'observacao', FILTER_SANITIZE_STRING);
$requisitante = filter_input(INPUT_POST, 'requisitante', FILTER_SANITIZE_STRING);
$dabertura = filter_input(INPUT_POST, 'data_abertura', FILTER_SANITIZE_STRING);
$habertura = filter_input(INPUT_POST, 'hora_abertura', FILTER_SANITIZE_STRING);
$datendimento = filter_input(INPUT_POST, 'data_atendimento', FILTER_SANITIZE_STRING);
$hatendimento = filter_input(INPUT_POST, 'hora_atendimento', FILTER_SANITIZE_STRING);
$dconclusao = filter_input(INPUT_POST, 'data_conclusao', FILTER_SANITIZE_STRING);
$hconclusao = filter_input(INPUT_POST, 'hora_conclusao', FILTER_SANITIZE_STRING);


$dabertura_real = $dabertura;
$habertura_real = $habertura;
$datendimento_real = $datendimento;
$hatendimento_real = $hatendimento;
$dconclusao_real = $dconclusao;
$hconclusao_real = $hconclusao;

$mesg_obs = array();

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$_SESSION['dados20'] = $dados;

require_once 'database_gac.php';
require_once './func_corretiva.php';
require_once 'Funcoes/mascara_php.php';


$query = "SELECT tip.* , loc.id_contrato, cont.tip_chamado, 
				cont.rg, loc.lugar_regional				
				FROM tipo AS tip
				INNER JOIN local AS loc ON  loc.id_local = tip.id_local
				INNER JOIN  contrato AS cont ON  cont.id_contrato = loc.id_contrato
				WHERE id_tipo = '$id_tipo'";

$resultado = mysqli_query($conection, $query)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado)) {

    $tipos = $registro['tipos'];
    $ct = $registro['id_contrato'];
    $tch = $registro['tip_chamado'];
    $rg = $registro['rg'];
}


$q1 = "SELECT * FROM severidades WHERE id_contrato = '$ct' AND item = '$tipo' AND severidade = '$severidade' ";
$r1 = mysqli_query($conection, $q1)or die('Não foi possivel conectar ao MySQL');
while ($row = mysqli_fetch_assoc($r1)) {

    $p_atendimento = formata_periodo(mascara_php($row['prazo_atend']));
    $p_solucao = formata_periodo(mascara_php($row['prazo_solu']));
    $tolerancia = formata_periodo(mascara_php($row['tolerancia']));
    $start_onsite = formata_periodo(mascara_php($row['start_onsite']));
    $tipo_atendimento = $row['tipo_atendimento'];
    $modo = $row['modo'];
}

//valida exclusão de registro


if (!empty($_REQUEST['action'] == 'deleta')) {

    $id_tipoget = (int) filter_input(INPUT_GET, 'id_tipo', FILTER_SANITIZE_NUMBER_INT);
    $id_corretivaget = (int) filter_input(INPUT_GET, 'id_corretiva', FILTER_SANITIZE_NUMBER_INT);

    if (verifica_ocorrencia($id_corretivaget) == false) {


        $result = "DELETE FROM corretivas  WHERE id_corretiva='$id_corretivaget'";
        $q1 = mysqli_query($conection, $result);

        $_SESSION['msg38'] = "<h4  class='alert alert-success'> Registro deletado com sucesso!</4>";
        header("Location: cad_corretiva.php?id_tipo=$id_tipoget");
        exit();
    } else {

        $_SESSION['msg38'] = "<h4  class='alert alert-danger'>Este registro não pode ser excluido, pois foi previsionado para aplicação de multa!</h4>";
        header("Location: cad_corretiva.php?id_tipo=$id_tipoget");
        exit();
    }
}



//INICIO DA VERIFICAÇÃO
/*

$id_pags = array();
$query_pag = "select id_pag from pagamentos where id_contrato = '$ct' and id_tipo ='$id_tipo'";
$result_pag = mysqli_query($conection, $query_pag);
while ($registro = mysqli_fetch_array($result_pag)) {

    $id_pags[] = $registro['id_pag'];
}
$num_pag = count($id_pags); //total de indices do array

if ($num_pag > 1) {

    $ex_pag = explode("-", $dconclusao);
    $ano_pag1 = (int)$ex_pag[0];
    $mes_ref_pag = $ex_pag[1];
   
    $mes_ref_pag1 = (int)$mes_ref_pag - 1;
    if ($mes_ref_pag == '1') {
        $mes_ref_pag1 = 12;
        $ano_pag1 = $ano_pag - 1;
    }

    
 
    
    $sql_pag1 = "  SELECT * FROM pagamentos  WHERE id_tipo= '$id_tipo' AND MONTH(data_inicio_per)='$mes_ref_pag1' AND YEAR(data_inicio_per)='$ano_pag1' AND (medido='' OR d_assinatura_dig ='0000-00-00' OR siscor ='') LIMIT 1 ";
    $resultado_pag1 = mysqli_query($conection, $sql_pag1);
    $num_very = mysqli_num_rows($resultado_pag1);
}

   var_dump($mes_ref_pag1); 
//FIM DA VERIFICAÇÃO
//
//

if($num_very == 0){*/
// Chamados "Aguardadndo"  em casos que o relatório não foi entregue pelo fornecedor
    if (!empty($dconclusao) || !empty($n_chamado)) {

        if ($n_chamado === '1' || $n_chamado == 'Aguardando' and ! empty($dconclusao) and ! empty($_POST['regional']) and ! empty($_POST['tipos'])) {

            $erro = array();

            $n_chamado = 'Aguardando';
            $n_patrimonio = '';
            $tipo = '';
            $status = 'Pendente';
            $necessidade_on_site = 'Nao';
            $aplicacao_multa = '';

            //limitação caso não haja data de conclusão

            if (empty($dconclusao)) {
                $erro[] = 'Informar a data de conclusao.';
            } else {
                $dconclusao = mysqli_real_escape_string($conection, trim($dconclusao));
            }
            $ex = explode("-", $dconclusao);
            $ano = $ex[0];
            $mes_ref = $ex[1];

            if (empty($erro)) {

                if ($_REQUEST['action'] == 'update') {
                    $sit = "atualizado";

                    $q1 = "UPDATE corretivas SET  n_chamado='$n_chamado', data_conclusao='$dconclusao', aplicacao_multa='$aplicacao_multa', status='$status', id_tipo='$id_tipo', ano= '$ano', id_contrato='$ct',rg='$rg',
            regional='$regional', criado='NOW()',necessidade_on_site='$necessidade_on_site', tipos='$tipo',mes_ref = '$mes_ref' WHERE id_corretiva='$id_corretiva'";
                    $r1 = mysqli_query($conection, $q1);
                } else {
                    $sit = "cadastrado";

                    $q1 = "INSERT INTO corretivas ( n_chamado,  data_conclusao,	 aplicacao_multa, status, id_tipo , ano, id_contrato, rg, regional, necessidade_on_site, tipos, mes_ref )
	VALUES 
	('$n_chamado', '$dconclusao', '$aplicacao_multa','$status','$id_tipo','$ano', '$ct','$rg', '$regional', '$necessidade_on_site', '$tipo', '$mes_ref')";

                    $r1 = mysqli_query($conection, $q1);
                }
                if ($q1) {

                    $_SESSION['msg38'] = "<h4  class='alert alert-success'> Registro $sit com sucesso </h4>";
                    header("Location: cad_corretiva.php?id_tipo=$id_tipo");

                    unset($_SESSION['dados20']);
                }
            } else {
                foreach ($erro as $mg) {

                    $_SESSION['msg38'] = "<h4  class='alert alert-danger'>$mg</h4>";
                    header("Location: cad_corretiva.php?id_tipo=$id_tipo");
                }
            }
            exit();
        } else

// caso não haja nenhum chamado

        if ($n_chamado == '0' || $n_chamado == 'Nao Houve' and ! empty($dconclusao)) {

            $erro = array();


            $nchamado = 'Nao Houve';
            $n_patrimonio = '—';
            if (empty($dconclusao)) {
                $erro[] = 'Informar a data de conclusao.';
            } else {
                $dconclusao = mysqli_real_escape_string($conection, trim($dconclusao));
            }
            $tipo = 'Hardware/Software';
            $status = '1';
            $ex = explode("-", $dconclusao);
            $ano = $ex[0];
            $mes_ref = $ex[1];

            $necessidade_on_site = 'Nao';
            $aplicacao_multa = 'Nao';

            if (empty($erro)) {

                if ($_REQUEST['action'] == 'update') {

                    $sit = "atualizado";
                    $q1 = "UPDATE corretivas SET  n_chamado='$nchamado',data_conclusao='$dconclusao',n_patrimonio = '$n_patrimonio',
          aplicacao_multa='$aplicacao_multa', status='$status', id_tipo='$id_tipo', ano= '$ano', id_contrato='$ct',rg='$rg',
          regional='$regional',necessidade_on_site='$necessidade_on_site', mes_ref='$mes_ref', criado='NOW()' WHERE id_corretiva='$id_corretiva'";

                    $r1 = mysqli_query($conection, $q1);

                    $_SESSION['msg38'] = "<h4  class='alert alert-success'> Registro atualizado com sucesso !!!</h4>";
                    header("Location: cad_corretiva.php?id_tipo=$id_tipo");

                    unset($_SESSION['dados20']);
                } else {

                    $q = "SELECT  regional, mes_ref, ano, id_contrato  FROM corretivas  WHERE  regional ='$regional'  AND mes_ref ='$mes_ref' AND  ano='$ano'AND id_contrato ='$ct'";
                    $r = mysqli_query($conection, $q);



                    $num = mysqli_num_rows($r);



                    if ($num == 0) {
                        $q1 = "INSERT INTO corretivas ( n_chamado, n_patrimonio,  aplicacao_multa, status, id_tipo , ano, id_contrato, rg, regional, necessidade_on_site, tipos, mes_ref )
	VALUES 
	('$nchamado','$n_patrimonio', '$aplicacao_multa', '$status','$id_tipo','$ano', '$ct','$rg',
                 '$regional', '$necessidade_on_site', '$tipo', '$mes_ref')";

                        $r1 = mysqli_query($conection, $q1);

                        if ($q1) {
                            $_SESSION['msg38'] = "<h4  class='alert alert-success'>Registro cadastrado com sucesso </h4>";
                            header("Location: cad_corretiva.php?id_tipo=$id_tipo");

                            unset($_SESSION['dados20']);
                        }
                    } else {

                        $_SESSION['msg38'] = "<h4  class='alert alert-danger'> Nao e possivel cadastrar mais ausencia de atendimento para esse periodo nesta regional </h4>";
                        header("Location: cad_corretiva.php?id_tipo=$id_tipo");
                    }
                }
            } else {
                foreach ($erro as $mg) {

                    $_SESSION['msg38'] = "<h4  class='alert alert-danger'>$mg</h4>";
                    header("Location: cad_corretiva.php?id_tipo=$id_tipo");
                }
            }
            exit();
        } else

        if ($_REQUEST['action'] != 'update') {

            $q = "SELECT * FROM corretivas WHERE  n_chamado = '$n_chamado' and id_tipo = '$id_tipo'";
            $r = mysqli_query($conection, $q);
            $num = mysqli_num_rows($r);
        } else {

            $num = 0;
        }

        if ($num == 0 && $n_chamado != '1') {



            if (isset($_POST['submitted']) and $dabertura != null and $dabertura != '0000-00-00' and ! empty($habertura) and $datendimento != null and $dconclusao != null) {

                $erro = array();


                if (empty($n_chamado)) {
                    $erro[] = 'Informar o número do chamado, ou indicar que não ocorreu.';
                } else {
                    $n_chamado = mysqli_real_escape_string($conection, trim($_POST['n_chamado']));
                }

                if (empty($severidade)) {
                    $erro[] = 'Selecione a Severidade';
                } else if (is_numeric($severidade)) {
                    $severidade = mysqli_real_escape_string($conection, trim($_POST['tipo_severidade']));
                } else {
                    $erro[] = 'Informe o número do tipo de severidade.';
                }

                // evitar erro de digitação com datas cronologicamente erradas.

                if (!empty($datendimento) and ! empty($dabertura) and ! empty($dconclusao) and $dconclusao) {

                    if ((strtotime($datendimento) < strtotime($dabertura) ) && (strtotime($datendimento) != strtotime($dabertura))) {
                        $erro[] = 'A data do atendimento não pode anteceder a data de abertura do chamados.';
                    } else if (strtotime($dconclusao) < strtotime($datendimento) && strtotime($dconclusao) != strtotime($datendimento)) {
                        $erro[] = 'A data da conclusão não pode anteceder a data do atendimento.';
                    }
                }

                if (empty($erro)) {


                    // do atendimento 
                    $fim = '18:00';
                    $inicio = '08:00';

                    //24 x 7 e chamado do atendimento

                    if ($modo == 1 && $chamado == 1) {
                        $tempo_excedido_atendimento_calc = (((strtotime($datendimento) - strtotime($dabertura)) +
                                ( strtotime($hatendimento) - strtotime($habertura))) / 3600);

                        $tempo_excedido_atendimento = $tempo_excedido_atendimento_calc - $p_atendimento;


                        $tempo_excedido_conclusao_calc = (((strtotime($dconclusao) - strtotime($datendimento)) +
                                ( strtotime($hconclusao) - strtotime($hatendimento))) / 3600);

                        $tempo_excedido_conclusao = $tempo_excedido_conclusao_calc - $p_solucao;

                        //24 x 7 e chamado da abertura 
                    } else if ($modo == 1 && $chamado == 2) {
                        $tempo_excedido_atendimento_calc = (((strtotime($datendimento) - strtotime($dabertura)) +
                                ( strtotime($hatendimento) - strtotime($habertura))) / 3600);
                        $tempo_excedido_atendimento = $tempo_excedido_atendimento_calc - $p_atendimento;


                        $tempo_excedido_conclusao_calc = (((strtotime($dconclusao) - strtotime($dabertura)) +
                                ( strtotime($hconclusao) - strtotime($habertura))) / 3600);

                        $tempo_excedido_conclusao = $tempo_excedido_conclusao_calc - $p_solucao;



                        //10 x 5 e abertura do atendimento
                    } else if ($modo == 2 && $chamado == 1) {

                        if (($habertura > '18:00') AND ( $hatendimento > '18:00') AND ( $hconclusao > '18:00') AND ( $dabertura == $dconclusao)) {
                            $dabertura = date('d/m/Y', strtotime($dabertura . ' + 1 days'));
                            $datendimento = $dabertura;
                            $dconclusao = $dabertura;

                            $habertura = '08:00';
                            $hatendimento = $habertura;
                            $hconclusao = $habertura;
                        }
                        // se a abertura do chamado e o  atendimento  forem no mesmo dia diferente da conclusão  e apos as 18:00, mas  conclusão registrados apos  18h , a abertura  e atendimento serao comutados  as 8h do dia seguinte , mas a conclusão sera 18h no respectivo dia
                        else if (($habertura > '18:00') AND ( $hatendimento > '18:00') AND ( $hconclusao > '18:00') AND ( $dabertura != $dconclusao) And ( $dabertura == $datendimento)) {
                            $dabertura = date('d/m/Y', strtotime($dabertura . ' + 1 days'));
                            $datendimento = $dabertura;


                            $habertura = '08:00';
                            $hatendimento = $habertura;
                            $hconclusao = '18:00';
                        }
                        // se a abertura do chamado e for antes das 18h, o atendimento em dia diferente apos as 18h , a conclusao em dia deferente aspos as 18h, atendimento as 18h e conclusaõ tambem nos dias respectivos
                        else if (($habertura <= '18:00') AND ( $hatendimento > '18:00') AND ( $hconclusao > '18:00') AND ( $dabertura != $datendimento) And ( $datendimento != $dconclusao)) {
                            $hatendimento = '18:00';
                            $hconclusao = '18:00';
                        } else if (($habertura <= '18:00') AND ( $hatendimento <= '18:00') AND ( $hconclusao > '18:00') AND ( $dabertura != $datendimento) And ( $datendimento != $dconclusao)) {

                            $hconclusao = '18:00';
                        }
                        // se a abertura do chamado for antes das 18:00,  o atendimento e conclusão, no mesmo dia, for depois das 18h , eles serão computados as 18h.
                        else if (($habertura <= '18:00') AND ( $hatendimento > '18:00') AND ( $hconclusao > '18:00') AND ( $dabertura == $datendimento) AND ( $dabertura == $dconclusao)) {

                            $hatendimento = '18:00';
                            $hconclusao = $hatendimento;
                        }
                        //  se a ABERTURA  for no sabado ou domingo, o sistema inicia no proximo dia util apartir das 8:00 

                        $dabertura2 = proximoDiaUtil($dabertura);
                        $dabertura3 = inverteData($dabertura2);
                        $ano_dabertura = explode("/", $dabertura3);
                        $anos_aberturas = $ano_dabertura[2];
                        //verifica se é feriado
                        $dabertura2 = inverteData(verificar($dabertura3, $anos_aberturas));

                        // verifica se deve-se modificar o horario de abetura

                        if ($dabertura2 > $dabertura) {
                            $habertura = '08:00';
                            $dabertura = $dabertura2;
                            $obs_auto1 = " Abertura efetuada em dia atípico(Final de Semana ou Feriado)";
                        }

                        //  se a ATENDIMENTO for no sabado ou domingo, o sistema inicia no proximo dia util apartir das 8:00 

                        $datendimento2 = proximoDiaUtil($datendimento);
                        $datendimento3 = inverteData($datendimento2);

                        $ano_datendimento = explode("/", $datendimento3);
                        $ano_datendimentos = $ano_datendimento[2];


                        //verifica se é feriado
                        $datendimento2 = inverteData(verificar($datendimento3, $ano_datendimentos));

                        // verifica se deve-se modificar o horario de abetura
                        if ($datendimento2 > $datendimento) {
                            $hatendimento = '08:00';
                            $datendimento = $datendimento2;

                            $obs_auto2 = " Atendimento efetuada em dia atípico(Final de Semana ou Feriado)";
                        }


                        //  se a CONCLUSÃO  for no sabado ou domingo, o sistema inicia no proximo dia util apartir das 8:00 

                        $dconclusao2 = proximoDiaUtil($dconclusao);
                        $dconclusao3 = inverteData($dconclusao2);

                        $ano_dconclusao = explode("/", $dconclusao3);
                        $ano_dconclusaos = $ano_dconclusao[2];
                        //verifica se é feriado
                        $dconclusao2 = inverteData(verificar($dconclusao3, $ano_dconclusaos));
                        // verifica se deve-se modificar o horario de abetura
                        if ($dconclusao2 > $dconclusao) {
                            $hconclusao = '08:00';
                            $dconclusao = $dconclusao2;
                            $obs_auto3 = " Conclusão efetuada em dia atípico (Final de Semana ou Feriado)";
                        }




                        $fim = '18:00';
                        $inicio = '08:00';

                        // Calculo inverte as datas do formato nativo para o convencional, isto é feito para que possamos utilizar a função que extrai feriados e fim de semana 
                        $dabertura2 = inverteData($dabertura);
                        $datendimento2 = inverteData($datendimento);
                        $dconclusao2 = inverteData($dconclusao);

                        // Calculo de dias uteis 

                        $diasUteis_atendimento = DiasUteis($dabertura2, $datendimento2, $anos_aberturas);
                        $diasUteis_conclusao = DiasUteis($datendimento2, $dconclusao2, $anos_aberturas);

                        //Calculo 

                        if ($dabertura2 == $datendimento2) {
                            $tempo_excedido_atendimento_calc = (( $diasUteis_atendimento ) * 10 +
                                    (( strtotime($hatendimento) - strtotime($habertura)) / 3600));

                            $tempo_excedido_atendimento = $tempo_excedido_atendimento_calc - $p_atendimento;
                        } else {
                            // Por ser dias diferentes neste calculo utilizamos as variaveis $inicio e $fim  para obtermos aparcela do 
                            //  primeiro dia  e ultimo respectivamente , por isso subtraimos 1 dos dias uteis e assim contabilizamos o total de horas 

                            $tempo_excedido_atendimento_calc = ((( $diasUteis_atendimento - 1) * 10 +
                                    (( strtotime($fim) - strtotime($habertura)) / 3600) + (( strtotime($hatendimento) - strtotime($inicio)) / 3600)));


                            $tempo_excedido_atendimento = $tempo_excedido_atendimento_calc - $p_atendimento;

                            var_dump($tempo_excedido_atendimento);
                        }

                        if ($datendimento2 == $dconclusao2) {
                            $tempo_excedido_conclusao_calc = (($diasUteis_conclusao ) * 10 +
                                    (( strtotime($hconclusao) - strtotime($hatendimento)) / 3600));


                            $tempo_excedido_conclusao = $tempo_excedido_conclusao_calc - $p_solucao;
                        } else {

                            // Por ser dias diferentes neste calculo utilizamos as variaveis $inicio e $fim  para obtermos aparcela do 
                            //   primeiro dia  e ultimo respectivamente , por isso subtraimos 1 dos dias uteis e assim contabilizamos o total de horas 
                            $tempo_excedido_conclusao_calc = ((($diasUteis_conclusao - 1) * 10 +
                                    (( strtotime($fim) - strtotime($hatendimento)) / 3600) + (( strtotime($hconclusao) - strtotime($inicio)) / 3600)));


                            $tempo_excedido_conclusao = $tempo_excedido_conclusao_calc - $p_solucao;
                        }
                    }

                    // Calculo de 10x5 considerando abertura do chamado
                    else if ($modo == 2 && $chamado == 2) {

                        if (($habertura > '18:00') AND ( $hatendimento > '18:00') AND ( $hconclusao > '18:00') AND ( $dabertura == $dconclusao)) {
                            $dabertura = date('d/m/Y', strtotime($dabertura . ' + 1 days'));
                            $datendimento = $dabertura;
                            $dconclusao = $dabertura;

                            $habertura = '08:00';
                            $hatendimento = $habertura;
                            $hconclusao = $habertura;
                        }
                        // se a abertura do chamado e o  atendimento forem no mesmo dia  e tambem como a conclusão registrados as 18h , a abertura  e atendimento serao comutados  as 8h do dia seguinte , mas a conclusão sera 18h no respectivo dia
                        else if (($habertura > '18:00') AND ( $hatendimento > '18:00') AND ( $hconclusao > '18:00') AND ( $dabertura != $dconclusao) And ( $dabertura == $datendimento)) {
                            $dabertura = date('d/m/Y', strtotime($dabertura . ' + 1 days'));
                            $datendimento = $dabertura;


                            $habertura = '08:00';
                            $hatendimento = $habertura;
                            $hconclusao = '18:00';
                        }
                        // se a abertura do chamado e for antes das 18h, o atendimento em dia diferente apos as 18h , a conclusao em dia deferente aspos as 18h, atendimento as 18h e conclusaõ tambem nos dias respectivos
                        else if (($habertura <= '18:00') AND ( $hatendimento > '18:00') AND ( $hconclusao > '18:00') AND ( $dabertura != $datendimento) And ( $datendimento != $dconclusao)) {
                            $hatendimento = '18:00';
                            $hconclusao = '18:00';
                        } else if (($habertura <= '18:00') AND ( $hatendimento <= '18:00') AND ( $hconclusao > '18:00') AND ( $dabertura != $datendimento) And ( $datendimento != $dconclusao)) {

                            $hconclusao = '18:00';
                        }
                        // se a abertura do chamado for antes das 18:00,  o atendimento e conclusão, no mesmo dia, for depois das 18h , eles serão computados as 18h.
                        else if (($habertura <= '18:00') AND ( $hatendimento > '18:00') AND ( $hconclusao > '18:00') AND ( $dabertura == $datendimento) AND ( $dabertura == $dconclusao)) {

                            $hatendimento = '18:00';
                            $hconclusao = $hatendimento;
                        }
                        //  se a ABERTURA  for no sabado ou domingo, o sistema inicia no proximo dia util apartir das 8:00 

                        $dabertura2 = proximoDiaUtil($dabertura);
                        $dabertura3 = inverteData($dabertura2);
                        $ano_dabertura = explode("/", $dabertura3);
                        $anos_aberturas = $ano_dabertura[2];
                        //verifica se é feriado
                        $dabertura2 = inverteData(verificar($dabertura3, $anos_aberturas));

                        // verifica se deve-se modificar o horario de abetura

                        if ($dabertura2 > $dabertura) {
                            $habertura = '08:00';
                            $dabertura = $dabertura2;
                            $obs_auto1 = " Abertura efetuada em dia atípico (Final de Semana ou Feriado)";
                        }

                        //  se a ATENDIMENTO for no sabado ou domingo, o sistema inicia no proximo dia util apartir das 8:00 

                        $datendimento2 = proximoDiaUtil($datendimento);
                        $datendimento3 = inverteData($datendimento2);

                        $ano_datendimento = explode("/", $datendimento3);
                        $ano_datendimentos = $ano_datendimento[2];


                        //verifica se é feriado
                        $datendimento2 = inverteData(verificar($datendimento3, $ano_datendimentos));

                        // verifica se deve-se modificar o horario de abetura
                        if ($datendimento2 > $datendimento) {
                            $hatendimento = '08:00';
                            $datendimento = $datendimento2;
                            $obs_auto2 = " Atendimento efetuada em dia atípico (Final de Semana ou Feriado)";
                        }


                        //  se a CONCLUSÃO  for no sabado ou domingo, o sistema inicia no proximo dia util apartir das 8:00 

                        $dconclusao2 = proximoDiaUtil($dconclusao);
                        $dconclusao3 = inverteData($dconclusao2);

                        $ano_dconclusao = explode("/", $dconclusao3);
                        $ano_dconclusaos = $ano_dconclusao[2];
                        //verifica se é feriado
                        $dconclusao2 = inverteData(verificar($dconclusao3, $ano_dconclusaos));
                        // verifica se deve-se modificar o horario de abetura
                        if ($dconclusao2 > $dconclusao) {
                            $hconclusao = '08:00';
                            $dconclusao = $dconclusao2;
                            $obs_auto3 = " Conclusão efetuada em dia atípico (Final de Semana ou Feriado)";
                        }



                        $fim = '18:00';
                        $inicio = '08:00';

                        // Calculo inverte as datas do formato nativo para o convencional, isto é feito para que possamos utilizar a função que extrai feriados e fim de semana 
                        $dabertura2 = inverteData($dabertura);
                        $datendimento2 = inverteData($datendimento);
                        $dconclusao2 = inverteData($dconclusao);

                        // Calculo de dias uteis 

                        $diasUteis_atendimento = DiasUteis($dabertura2, $datendimento2, $anos_aberturas);
                        $diasUteis_conclusao = DiasUteis($dabertura2, $dconclusao2, $anos_aberturas);



                        var_dump($diasUteis_conclusao);

                        // condicional que fara os calculos confome seja datas iguais ou diferentes respectivamente 

                        if ($dabertura2 == $datendimento2) {
                            $tempo_excedido_atendimento_calc = (($diasUteis_atendimento ) * 10 +
                                    (( strtotime($hatendimento) - strtotime($habertura)) / 3600));

                            $tempo_excedido_atendimento = $tempo_excedido_atendimento_calc - $p_atendimento;
                        } else {
                            // Por ser dias diferentes neste calculo utilizamos as variaveis $inicio e $fim  para obtermos aparcela do 
                            //  primeiro dia  e ultimo respectivamente , por isso subtraimos 1 dos dias uteis e assim contabilizamos o total de horas 
                            $tempo_excedido_atendimento_calc = ((($diasUteis_atendimento - 1) * 10 +
                                    (( strtotime($fim) - strtotime($habertura)) / 3600) + (( strtotime($hatendimento) - strtotime($inicio)) / 3600)));

                            $tempo_excedido_atendimento = $tempo_excedido_atendimento_calc - $p_atendimento;
                        }

                        if ($datendimento2 == $dconclusao2) {
                            $tempo_excedido_conclusao_calc = (($diasUteis_conclusao ) * 10 +
                                    (( strtotime($hconclusao) - strtotime($habertura)) / 3600) );

                            $tempo_excedido_conclusao = $tempo_excedido_conclusao_calc - $p_solucao;
                        } else {

                            // Por ser dias diferentes neste calculo utilizamos as variaveis $inicio e $fim  para obtermos aparcela do 
                            //  primeiro dia  e ultimo respectivamente , por isso subtraimos 1 dos dias uteis e assim contabilizamos o total de horas 
                            $tempo_excedido_conclusao_calc = ((($diasUteis_conclusao - 1) * 10 +
                                    (( strtotime($fim) - strtotime($habertura)) / 3600) + (( strtotime($hconclusao) - strtotime($inicio)) / 3600)) );

                            $tempo_excedido_conclusao = $tempo_excedido_conclusao_calc - $p_solucao;
                        }
                    }


                    // ceil faz o arrendodamento para mais 

                    $tempo_excedido_atendimento = @ceil($tempo_excedido_atendimento);
                    $tempo_excedido_conclusao = @ceil($tempo_excedido_conclusao);
                    $total = @ceil($total);

                    // condição para tratar valores negativos 

                    if ($tempo_excedido_atendimento < 0) {
                        $tempo_excedido_atendimento = 0;
                    }
                    if ($tempo_excedido_conclusao < 0) {
                        $tempo_excedido_conclusao = 0;
                    }
                    if ($total < 0) {
                        $total = 0;
                    }

                  

                    if ($tempo_excedido_atendimento_calc < 0) {
                        $tempo_excedido_atendimento_calc = 0;
                    }

                    if ($tempo_excedido_conclusao_calc < 0) {
                        $tempo_excedido_conclusao_calc = 0;
                    }

                      $sub_total_atend = $tempo_excedido_atendimento_calc;
                    $sub_total_conclu = $tempo_excedido_conclusao_calc;
                    $total = $tempo_excedido_atendimento + $tempo_excedido_conclusao;
                    
                    
                    
                    
                    // verifica a necessidade de atendimento on site , logo se o periodo compreendido entre o atendimento e a conclusão ($periodo_conclusao)
                    //  for maior que o prazo limite (start_on_site); o sistema indicara a necessidade de atendimento on_site 


                    if (($tipo_atendimento == 'Remoto e On-Site') and ( $tempo_excedido_atendimento_calc > $start_onsite )) {
                        $necessidade_on_site = 'Sim';
                    } else if ($tipo_atendimento == 'Remoto e On-Site Ati') {
                        $necessidade_on_site = '—';
                    } else {
                        $necessidade_on_site = 'Não';
                    }


                    if ($_REQUEST['action'] != 'update' ) {

                        if (($total > 0) or ( $necessidade_on_site == 'Sim')) {
                            $previsao_multa = 1;
                            $aplicacao_multa = 'Verificar';
                        } else if ($total == 0) {
                            $previsao_multa = 0;
                            $aplicacao_multa = 'Nao';
                        }

                        
                    }
                    if ($_REQUEST['action'] == 'update' and $atu_previsao_multa == 2) {

                        if (($total > 0) or ( $necessidade_on_site == 'Sim')) {
                            $previsao_multa = 1;
                            $aplicacao_multa = 'Verificar';
                        } else if ($total == 0) {
                            $previsao_multa = 0;
                            $aplicacao_multa = 'Nao';
                        }

                        if ($atu_previsao_multa == 2) {

                            $q1 = "UPDATE corretivas SET aplicacao_multa='$aplicacao_multa' WHERE id_corretiva='$id_corretiva'";
                            $r1 = mysqli_query($conection, $q1);
                        }
                    }
                    // expressão para extrair o ano na data de conclusão

                    $ex = explode("-", $dconclusao);
                    $ano = $ex[0];
                    $mes_ref = $ex[1];

                    //Condicional para verificar a existencia de datas e horarios, caso falte alguma dessas variaveis o 
                    // status será pendente, do contrario será Ok

                    if (!empty($dabertura) and ! empty($habertura) and ! empty($datendimento) and ! empty($hatendimento)
                            and ! empty($dconclusao) and ! empty($hconclusao)) {
                        $status = 'Ok';
                    } else {
                        $status = 'Pendente';
                    }

                    $ex_mes_ref = explode("-", $dconclusao);
                    $ex_mes_ref = $ex[1];
                    $mes_ref = (int) $ex_mes_ref;


                    if (!empty($obs_auto1) || !empty($obs_auto2) || !empty($obs_auto3)) {
                        array_push($mesg_obs, $obs_auto1, $obs_auto2, $obs_auto3, $obs);

                        $obs = implode(' / ', $mesg_obs);
                    }


                    if ($_REQUEST['action'] == 'update') {


                        $sit = "atualizado";

                        $q1 = "UPDATE corretivas SET  n_chamado='$n_chamado', resumo_demanda='$rdemanda', requisitante='$requis', data_abertura='$dabertura', hora_abertura='$habertura',
          data_atendimento='$datendimento', hora_atendimento='$hatendimento',data_conclusao='$dconclusao', hora_conclusao='$hconclusao', tempo_excedido_atendimento='$tempo_excedido_atendimento',
          tempo_excedido_conclusao='$tempo_excedido_conclusao', total='$total' ,
          tipo_severidade='$severidade', prazo_atendimento='$p_atendimento',  prazo_conclusao='$p_solucao',n_patrimonio = '$n_patrimonio', previsao_multa='$previsao_multa',
           subtotal_atendimento='$sub_total_atend', subtotal_conclusao='$sub_total_conclu ', modo='$modo',
          tecnico='$tecnico', observacao='$obs', status='$status', id_tipo='$id_tipo', ano= '$ano', id_contrato='$ct',rg='$rg',
          regional='$regional',necessidade_on_site='$necessidade_on_site', mes_ref='$mes_ref', criado='NOW()', dabertura_real = '$dabertura_real', habertura_real = '$habertura_real',
            datendimento_real = '$datendimento_real', hatendimento_real = '$hatendimento_real', dconclusao_real = '$dconclusao_real', hconclusao_real = '$hconclusao_real' WHERE id_corretiva='$id_corretiva'";




                        $r1 = mysqli_query($conection, $q1);
                    } else {

                        $sit = "cadastrado";

                        $q1 = "INSERT INTO corretivas ( n_chamado, resumo_demanda, requisitante, data_abertura, hora_abertura,
              data_atendimento, hora_atendimento, data_conclusao, hora_conclusao, tempo_excedido_atendimento,tempo_excedido_conclusao,
              total, tipo_severidade, prazo_atendimento, prazo_conclusao, n_patrimonio, previsao_multa,  aplicacao_multa,
              subtotal_atendimento, subtotal_conclusao, modo, tecnico, observacao, status, id_tipo , ano, id_contrato, rg, regional, necessidade_on_site, tipos, mes_ref,
             dabertura_real, habertura_real, datendimento_real, hatendimento_real, dconclusao_real, hconclusao_real )
              VALUES
              ('$n_chamado','$rdemanda','$requis','$dabertura ','$habertura','$datendimento','$hatendimento ', '$dconclusao',
              '$hconclusao', '$tempo_excedido_atendimento', '$tempo_excedido_conclusao', '$total', '$severidade', '$p_atendimento',
              '$p_solucao', '$n_patrimonio', '$previsao_multa', '$aplicacao_multa', '$sub_total_atend', '$sub_total_conclu ', '$modo', '$tecnico', '$obs','$status','$id_tipo','$ano', '$ct','$rg', '$regional', '$necessidade_on_site', '$tipo', '$mes_ref',
               '$dabertura_real','$habertura_real','$datendimento_real','$hatendimento_real', '$dconclusao_real','$hconclusao_real')";
                    }

                    $r1 = mysqli_query($conection, $q1);

                    if ($q1) {

                        $_SESSION['msg38'] = "<h4  class='alert alert-success'> Registro $sit com sucesso </h4>";
                        header("Location: cad_corretiva.php?id_tipo=$id_tipo");

                        unset($_SESSION['dados20']);
                    } else {

                        $_SESSION['msg38'] = "<h4  class='alert alert-danger'> Registro não  foi cadastrado  </h4>";
                        header("Location: cad_corretiva.php?id_tipo=$id_tipo");
                    }
                } else {
                    foreach ($erro as $mg) {

                        $_SESSION['msg38'] = "<h4  class='alert alert-danger'>$mg</p>";
                        header("Location: cad_corretiva.php?id_tipo=$id_tipo");
                    }
                }
            } else {
                $_SESSION['msg38'] = "<h4  class='alert alert-danger'> Digite a data  e o horario da abertura</h4>";
                header("Location: cad_corretiva.php?id_tipo=$id_tipo");
            }


            //inserção de registro com PENDENCIAS de datas


            if ($_POST['n_chamado'] != 0 and $_POST['n_chamado'] != 1 and empty($dconclusao) || empty($datendimento)) {


                $erro = array();


                if (empty($n_chamado)) {
                    $erro[] = 'Informar o número do chamado, ou indicar que não ocorreu.';
                } else {
                    $n_chamado = mysqli_real_escape_string($conection, trim($n_chamado));
                }


                if (empty($severidade)) {
                    $erro[] = 'Selecione a Severidade';
                } else if (is_numeric($severidade)) {
                    $severidade = mysqli_real_escape_string($conection, trim($_POST['tipo_severidade']));
                } else {
                    $erro[] = 'Informe o número do tipo de severidade.';
                }




                if ($tipo_atendimento == 'Remoto e On-Site') {
                    $necessidade_on_site = 'Pendente';
                } else if ($tipo_atendimento == 'Remoto e On-Site Ati') {
                    $necessidade_on_site = '—';
                } else {
                    $necessidade_on_site = 'Não';
                }



                $previsao_multa = 'Pendente';
                $aplicacao_multa = 'Não';
                $status = 'Pendente';
                $ex = explode("-", $dabertura);
                $ano = $ex[0];
                $mes_ref = $ex[1];




                if (empty($erro)) {

                    if ($_REQUEST['action'] != 'update') {

                        $q1 = "INSERT INTO corretivas ( n_chamado, resumo_demanda, requisitante, data_abertura, hora_abertura,
              data_atendimento, hora_atendimento, data_conclusao, hora_conclusao, tempo_excedido_atendimento,tempo_excedido_conclusao,
              total, tipo_severidade, prazo_atendimento, prazo_conclusao, n_patrimonio, previsao_multa,  aplicacao_multa,
              subtotal_atendimento, subtotal_conclusao, modo, tecnico, observacao, status, id_tipo , ano, id_contrato, rg, regional, necessidade_on_site, tipos, mes_ref,
             dabertura_real, habertura_real, datendimento_real, hatendimento_real, dconclusao_real, hconclusao_real )
              VALUES
              ('$n_chamado','$rdemanda','$requis','$dabertura ','$habertura','$datendimento','$hatendimento ', '$dconclusao',
              '$hconclusao', '$tempo_excedido_atendimento', '$tempo_excedido_conclusao', '$total', '$severidade', '$p_atendimento',
              '$p_solucao', '$n_patrimonio', '$previsao_multa', '$aplicacao_multa', '$sub_total_atend', '$sub_total_conclu ', '$modo', '$tecnico', '$obs','$status','$id_tipo','$ano', '$ct','$rg', '$regional', '$necessidade_on_site', '$tipo', '$mes_ref',
               '$dabertura_real','$habertura_real','$datendimento_real','$hatendimento_real', '$dconclusao_real','$hconclusao_real')";


                        $r1 = mysqli_query($conection, $q1);
                    } else {

                        $sit = "atualizado";


                        $q1 = "UPDATE corretivas SET  n_chamado='$n_chamado', resumo_demanda='$rdemanda', requisitante='$requis', data_abertura='$dabertura', hora_abertura='$habertura',
          data_atendimento='$datendimento', hora_atendimento='$hatendimento',data_conclusao='$dconclusao', hora_conclusao='$hconclusao', tempo_excedido_atendimento='$tempo_excedido_atendimento',
          tempo_excedido_conclusao='$tempo_excedido_conclusao', total='$total' ,
          tipo_severidade='$severidade', prazo_atendimento='$p_atendimento',  prazo_conclusao='$p_solucao',n_patrimonio = '$n_patrimonio', previsao_multa='$previsao_multa',
          aplicacao_multa='$aplicacao_multa', subtotal_atendimento='$sub_total_atend', subtotal_conclusao='$sub_total_conclu ', modo='$modo',
          tecnico='$tecnico', observacao='$obs', status='$status', id_tipo='$id_tipo', ano= '$ano', id_contrato='$ct',rg='$rg',
          regional='$regional',necessidade_on_site='$necessidade_on_site', mes_ref='$mes_ref', criado='NOW()', dabertura_real = '$dabertura_real', habertura_real = '$habertura_real',
            datendimento_real = '$datendimento_real', hatendimento_real = '$hatendimento_real', dconclusao_real = '$dconclusao_real', hconclusao_real = '$hconclusao_real' WHERE id_corretiva='$id_corretiva'";


                        $r1 = mysqli_query($conection, $q1);
                    }

                    if ($q1) {

                        $_SESSION['msg38'] = "<h4  class='alert alert-success'>  Registro cadastrado com sucesso </h4>";
                        header("Location: cad_corretiva.php?id_tipo=$id_tipo");

                        unset($_SESSION['dados20']);
                    } else {

                        $_SESSION['msg38'] = "<h4  class='alert alert-danger'> Registro não  foi cadastrado  </h4>";
                        header("Location: cad_corretiva.php?id_tipo=$id_tipo");
                    }
                } else {
                    foreach ($erro as $mg) {

                        $_SESSION['msg38'] = "<h4  class='alert alert-danger'>$mg</h4>";
                        header("Location: cad_corretiva.php?id_tipo=$id_tipo");
                    }
                }
            }
        } else {

            $_SESSION['msg38'] = "<h4  class='alert alert-danger'> Este registro já  foi cadastrado</h4>";
            header("Location: cad_corretiva.php?id_tipo=$id_tipo");
        }
    } else {

        $_SESSION['msg38'] = "<h4  class='alert alert-danger'> Insira os dados no formulário</h4>";
        header("Location: cad_corretiva.php?id_tipo=$id_tipo");
    }
/*
}else{
    
     $_SESSION['msg38'] = "<h4  class='alert alert-danger'>Registro não foi processado, há pendencia dos registros da Liberação de Pagamento do mês anterior </h4>";
        header("Location: cad_corretiva.php?id_tipo=$id_tipo");
    
}
 * 
 */