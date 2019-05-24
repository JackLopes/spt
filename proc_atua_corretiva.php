<?php

session_start();

$page_title = 'Corretiva';
if (isset($_POST['id_tipo'])) {
    $id_tipo = (int) $_POST['id_tipo'];
}
if (isset($_POST['id_corretiva'])) {
    $id_corretiva = (int) $_POST['id_corretiva'];
}

if (isset($_POST['data_conclusao'])) {
    $conclusao = $_POST['data_conclusao'];
}

//

require_once './func_corretiva.php';
require_once 'database_gac.php';
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
    $regional = $registro['lugar_regional'];
}


if (($_POST['n_chamado']) == 'Nao Houve') {

    $erro = array();


    $dconclusao = ($_POST['data_conclusao']);
    $ct = ($_POST['ct']);
    $nchamado = 'Nao Houve';
    $n_patrimonio = '—';

    if (empty($_POST['data_conclusao'])) {
        $erro[] = 'Informar a data de conclusao.';
    } else {
        $dconclusao = mysqli_real_escape_string($conection, trim($_POST['data_conclusao']));
    }

    $tipo = 'Hardware/Software';
    $regional = ($_POST['regional']);
    $status = '1';
    $ex = explode("-", $dconclusao);
    $ano = $ex[0];
    $mes_ref = $ex[1];
    //  $dconclusao = '0000-00-00';
    $necessidade_on_site = 'Nao';
    $aplicacao_multa = 'Nao';


    if (empty($erro)) {

        $q1 = "UPDATE corretivas SET  n_chamado='$nchamado', data_conclusao='$dconclusao', aplicacao_multa='$aplicacao_multa', status='$status', id_tipo='$id_tipo', ano= '$ano', id_contrato='$ct',rg='$rg',
            regional='$regional', criado='NOW()',necessidade_on_site='$necessidade_on_site', tipos='$tipo',mes_ref = '$mes_ref' WHERE id_corretiva='$id_corretiva'";
        $r1 = mysqli_query($conection, $q1);

        if ($q1) {

            $_SESSION['msg38'] = "<p style='color:green;'> Registro cadastrado com sucesso </p>";
            header("Location: cad_corretiva.php?id_tipo=$id_tipo");

            unset($_SESSION['dados20']);
        }
    } else {
        foreach ($erro as $mg) {

            $_SESSION['msg38'] = "<p style='color:red;'>$mg</p>";
            header("Location: cad_corretiva.php?id_tipo=$id_tipo");
        }
    }
} else if ($conclusao) {



    $erro = array();


    if (empty($_POST['n_chamado'])) {
        $erro[] = 'Informar o número do chamado, ou indicar que não ocorreu.';
    } else {
        $nchamado = mysqli_real_escape_string($conection, trim($_POST['n_chamado']));
    }

    if (empty($_POST['n_patrimonio'])) {
        $erro[] = 'Informar o Número do patrimonio.';
    } else {
        $n_patrimonio = mysqli_real_escape_string($conection, trim($_POST['n_patrimonio']));
    }

    if (empty($_POST['tipo_severidade'])) {
        $erro[] = 'Selecione a Severidades';
    } else if (is_numeric($_POST['tipo_severidade'])) {
        $severidade = mysqli_real_escape_string($conection, trim($_POST['tipo_severidade']));
    } else {
        $erro[] = 'Informe o número do tipo de severidade.';
    }

    $tipo = ($_POST['tipos']);
    $id_tipo = ($_POST['id_tipo']);
    $ct = ($_POST['ct']);
    $rg = ($_POST['rg']);
    $regional = ($_POST['regional']);
    $chamado = ($_POST['tch']);
    $rdemanda = ($_POST['resumo_demanda']);
    $requis = ($_POST['requisitante']);
    $tecnico = ($_POST['tecnico']);
    $obs = ($_POST['observacao']);
    $requisitante = ($_POST['requisitante']);
    $dabertura = ($_POST['data_abertura']);
    $habertura = ($_POST['hora_abertura']);
    $datendimento = ($_POST['data_atendimento']);
    $hatendimento = ($_POST['hora_atendimento']);
    $dconclusao = ($_POST['data_conclusao']);
    $hconclusao = ($_POST['hora_conclusao']);

    if (!empty($datendimento) and ! empty($dabertura) and ! empty($dconclusao) and $dconclusao) {

        if ((strtotime($datendimento) < strtotime($dabertura) ) && (strtotime($datendimento) != strtotime($dabertura))) {
            $erro[] = 'A data do atendimento não pode anteceder a data de abertura do chamados.';
        } else if (strtotime($dconclusao) < strtotime($datendimento) && strtotime($dconclusao) != strtotime($datendimento)) {
            $erro[] = 'A data da conclusão não pode anteceder a data do atendimento.';
        }
    }


    if (empty($erro)) {



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




        //fim  do atendimento 

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


            //10 x 5 e chamado do atendimento    
        } else if ($modo == 2 && $chamado == 1) {


            // se a abertura do chamado for depois das 18h , ele sera computado no dia seguinte apartir das 8h.
            if ($habertura > '18:00') {
                $dabertura = date('d/m/Y', strtotime($dabertura . ' + 1 days'));
                $habertura = '08:00';
            }
            // se a abertura do chamado for antes das 8h , ele sera computado as 8h.
            if ($habertura < '08:00') {
                $habertura = '08:00';
            }
            //   se a abertura  for no sabado ou domingo, o sistema inicia no proximo dia util apartir das 8:00  
            $dabertura2 = proximoDiaUtil($dabertura);

            if ($dabertura2 > $dabertura) {
                $habertura = '08:00';
                $dabertura = $dabertura2;
            }

            $dabertura2 = inverteData($dabertura);
            $datendimento2 = inverteData($datendimento);
            $dconclusao2 = inverteData($dconclusao);

            $diasUteis_atendimento = DiasUteis($dabertura2, $datendimento2);
            $diasUteis_conclusao = DiasUteis($datendimento2, $dconclusao2);

//calculo 

            if ($dabertura2 == $datendimento2) {
                $tempo_excedido_atendimento_calc = (( $diasUteis_atendimento ) * 10 +
                        (( strtotime($hatendimento) - strtotime($habertura)) / 3600));


                $tempo_excedido_atendimento = $tempo_excedido_atendimento_calc - $p_atendimento;
            } else {
                
                 /* Por ser dias diferentes neste calculo utilizamos as variaveis $inicio e $fim  para obtermos aparcela do 
                primeiro dia  e ultimo respectivamente , por isso subtraimos 1 dos dias uteis e assim contabilizamos o total de horas */
                
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
                
                 /* Por ser dias diferentes neste calculo utilizamos as variaveis $inicio e $fim  para obtermos aparcela do 
                primeiro dia  e ultimo respectivamente , por isso subtraimos 1 dos dias uteis e assim contabilizamos o total de horas */
                
                $tempo_excedido_conclusao_calc = ((($diasUteis_conclusao - 1) * 10 +
                        (( strtotime($fim) - strtotime($hatendimento)) / 3600) + (( strtotime($hconclusao) - strtotime($inicio)) / 3600)));


                $tempo_excedido_conclusao = $tempo_excedido_conclusao_calc - $p_solucao;
            }
        }




        // Calculo de 10x5 considerando chamado da abertura 
        else if ($modo == 2 && $chamado == 2) {

            var_dump($modo);

            //   se a abertura  for apos as 18:00 o sistema acrescentara mais um dia e iniciara a contagem apartidas 8:00 

            if ($habertura > '18:00') {
                $dabertura = date('Y-m-d', strtotime($dabertura . ' + 1 days'));
                $habertura = '08:00';
            }
            //   se a abertura  for antes das  8:00 , o sistema entendera que devera contar apartir das 8:00 e que se trata do mesmo dia 
            if ($habertura < '08:00') {
                $habertura = '08:00';
            }
            //  se a abertura  for no sabado ou domingo, o sistema inicia no proximo dia util apartir das 8:00 

            $dabertura2 = proximoDiaUtil($dabertura);

            if ($dabertura2 > $dabertura) {
                $habertura = '08:00';
                $dabertura = $dabertura2;
            }

            $fim = '18:00';
            $inicio = '08:00';

            // Calculo inverte as datas do formato nativo para o convencional, isto é feito para que possamos utilizar a função que extrai feriados e fim de semana 
            $dabertura2 = inverteData($dabertura);
            $datendimento2 = inverteData($datendimento);
            $dconclusao2 = inverteData($dconclusao);

            // Calculo de dias uteis 

            $diasUteis_atendimento = DiasUteis($dabertura2, $datendimento2);
            $diasUteis_conclusao = DiasUteis($datendimento2, $dconclusao2);

            // condicional que fara os calculos confome seja datas iguais ou diferentes respectivamente 

            if ($dabertura2 == $datendimento2) {
                $tempo_excedido_atendimento_calc = (($diasUteis_atendimento ) * 10 +
                        (( strtotime($hatendimento) - strtotime($habertura)) / 3600));

                $tempo_excedido_atendimento = $tempo_excedido_atendimento_calc - $p_atendimento;
            } else {
                
                 /* Por ser dias diferentes neste calculo utilizamos as variaveis $inicio e $fim  para obtermos aparcela do 
                primeiro dia  e ultimo respectivamente , por isso subtraimos 1 dos dias uteis e assim contabilizamos o total de horas */
                
                $tempo_excedido_atendimento_calc = ((($diasUteis_atendimento - 1) * 10 +
                        (( strtotime($fim) - strtotime($habertura)) / 3600) + (( strtotime($hatendimento) - strtotime($inicio)) / 3600)));

                $tempo_excedido_atendimento = $tempo_excedido_atendimento_calc - $p_atendimento;
                var_dump($tempo_excedido_atendimento_calc);
            }

            if ($datendimento2 == $dconclusao2) {
                $tempo_excedido_conclusao_calc = (($diasUteis_conclusao ) * 10 +
                        (( strtotime($hconclusao) - strtotime($habertura)) / 3600) );

                $tempo_excedido_conclusao = $tempo_excedido_conclusao_calc - $p_solucao;
            } else {
                /* Por ser dias diferentes neste calculo utilizamos as variaveis $inicio e $fim  para obtermos aparcela do 
                primeiro dia  e ultimo respectivamente , por isso subtraimos 1 dos dias uteis e assim contabilizamos o total de horas */ 
               
                
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

          $sub_total_atend = $tempo_excedido_atendimento_calc;
          $sub_total_conclu = $tempo_excedido_conclusao_calc;
          $total = $tempo_excedido_atendimento + $tempo_excedido_conclusao;

          if ($tempo_excedido_atendimento_calc > 0) {
          $tempo_excedido_atendimento_calc = 0;
          }

          if ($tempo_excedido_conclusao_calc > 0) {
          $tempo_excedido_conclusao_calc = 0;
          }

            if ($sub_total_atend < 0) {
          $sub_total_atend = 0;
          }
          if ($sub_total_conclu < 0) {
          $sub_total_conclu = 0;
          }
          // verifica a necessidade de atendimento on site , logo se o periodo compreendido entre o atendimento e a conclusão ($periodo_conclusao)
          //  for maior que o prazo limite (start_on_site); o sistema indicara a necessidade de atendimento on_site


          if (($tipo_atendimento == 'Remoto e On-Site') and ( $tempo_excedido_atendimento_calc > $start_onsite )) {
              
              var_dump("valores:". $tempo_excedido_atendimento_calc, $start_onsite );
                      
          $necessidade_on_site = 'Sim';
          } else if ($tipo_atendimento == 'Remoto e On-Site Ati') {
          $necessidade_on_site = '—';
          } else {
          $necessidade_on_site = 'Não';
          }


          if (($total > 0) or ( $necessidade_on_site == 'Sim')) {
          $previsao_multa = 1;
          $aplicacao_multa = 'Verificar';
          } else if ($total == 0) {
          $previsao_multa = 0;
          $aplicacao_multa = 'Nao';
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



          $q1 = "UPDATE corretivas SET  n_chamado='$nchamado', resumo_demanda='$rdemanda', requisitante='$requis', data_abertura='$dabertura', hora_abertura='$habertura',
          data_atendimento='$datendimento', hora_atendimento='$hatendimento',data_conclusao='$dconclusao', hora_conclusao='$hconclusao', tempo_excedido_atendimento='$tempo_excedido_atendimento',
          tempo_excedido_conclusao='$tempo_excedido_conclusao', total='$total' ,
          tipo_severidade='$severidade', prazo_atendimento='$p_atendimento',  prazo_conclusao='$p_solucao',n_patrimonio = '$n_patrimonio', previsao_multa='$previsao_multa',
          aplicacao_multa='$aplicacao_multa', subtotal_atendimento='$sub_total_atend', subtotal_conclusao='$sub_total_conclu ', modo='$modo',
          tecnico='$tecnico', observacao='$obs', status='$status', id_tipo='$id_tipo', ano= '$ano', id_contrato='$ct',rg='$rg',
          regional='$regional',necessidade_on_site='$necessidade_on_site', mes_ref='$mes_ref', criado='NOW()' WHERE id_corretiva='$id_corretiva'";


          $r1 = mysqli_query($conection, $q1);

          if ($q1) {

          $_SESSION['msg38'] = "<p style='color:green;'> Registro atualizado com sucesso </p>";
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

    $erro = array();


    if (empty($_POST['n_chamado'])) {
        $erro[] = 'Informar o número do chamado, ou indicar que não ocorreu.';
    } else {
        $nchamado = mysqli_real_escape_string($conection, trim($_POST['n_chamado']));
    }

    if (empty($_POST['n_patrimonio'])) {
        $erro[] = 'Informar o Número do patrimonio.';
    } else {
        $n_patrimonio = mysqli_real_escape_string($conection, trim($_POST['n_patrimonio']));
    }

    if (empty($_POST['tipo_severidade'])) {
        $erro[] = 'Selecione a Severidade...oi';
    } else if (is_numeric($_POST['tipo_severidade'])) {
        $severidade = mysqli_real_escape_string($conection, trim($_POST['tipo_severidade']));
    } else {
        $erro[] = 'Informe o número do tipo de severidade.';
    }

    $tipo = ($_POST['tipos']);
    $id_tipo = ($_POST['id_tipo']);
    $ct = ($_POST['ct']);
    $rg = ($_POST['rg']);
    $regional = ($_POST['regional']);
    $chamado = ($_POST['tch']);
    $rdemanda = ($_POST['resumo_demanda']);
    $requis = ($_POST['requisitante']);
    $tecnico = ($_POST['tecnico']);
    $obs = ($_POST['observacao']);
    $requisitante = ($_POST['requisitante']);
    $dabertura = ($_POST['data_abertura']);
    $habertura = ($_POST['hora_abertura']);
    $datendimento = ($_POST['data_atendimento']);
    $hatendimento = ($_POST['hora_atendimento']);
    $dconclusao = ($_POST['data_conclusao']);
    $hconclusao = ($_POST['hora_conclusao']);

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
    $mes_ref = 0;

    if (empty($erro)) {



        $q1 = "UPDATE corretivas SET  n_chamado='$nchamado', resumo_demanda='$rdemanda', requisitante='$requis', data_abertura='$dabertura', hora_abertura='$habertura',
            data_atendimento='$datendimento', hora_atendimento='$hatendimento',data_conclusao='$dconclusao', hora_conclusao='$hconclusao', tempo_excedido_atendimento='$tempo_excedido_atendimento',  
            tempo_excedido_conclusao='$tempo_excedido_conclusao', total='$total' , 
            tipo_severidade='$severidade', prazo_atendimento='$p_atendimento',  prazo_conclusao='$p_solucao', previsao_multa='$previsao_multa',
            aplicacao_multa='$aplicacao_multa', subtotal_atendimento='$sub_total_atend', subtotal_conclusao='$sub_total_conclu ', modo='$modo', 
            tecnico='$tecnico', observacao='$obs', status='$status', id_tipo='$id_tipo', ano= '$ano', id_contrato='$ct',rg='$rg',
            regional='$regional',necessidade_on_site='$necessidade_on_site', mes_ref='$mes_ref', criado='NOW()' WHERE id_corretiva='$id_corretiva'";


        $r1 = mysqli_query($conection, $q1);

        if ($q1) {

            $_SESSION['msg38'] = "<p style='color:green;'> Registro cadastrado com sucesso </p>";
            header("Location: cad_corretiva.php?id_tipo=$id_tipo");

            unset($_SESSION['dados20']);
        } else {

            $_SESSION['msg38'] = "<p style='color:red;'> Registro não  foi cadastrado  </p>";
            header("Location: cad_corretiva.php?id_tipo=$id_tipo");
        }
    } else {
        foreach ($erro as $mg) {

            $_SESSION['msg38'] = "<p style='color:red;'>$mg</p>";
            header("Location: cad_corretiva.php?id_tipo=$id_tipo");
        }
    }
}







