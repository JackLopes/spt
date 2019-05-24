<?php

session_start();

$permissa = $_SESSION['permissao'];
$page_title = 'Cadastrando Contrato';
require_once 'database_gac.php';
require_once 'Funcoes/func_data.php';
require_once 'Funcoes/limpa_string.php';
require_once 'Funcoes/valida_data.php';


$id_contrato = (int) filter_input(INPUT_POST, 'id_contrato', FILTER_SANITIZE_NUMBER_INT);
$status = limpa(filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING));
$rg = filter_input(INPUT_POST, 'rg', FILTER_SANITIZE_STRING);
$n_siscor = filter_input(INPUT_POST, 'n_siscor', FILTER_SANITIZE_STRING);

$projeto_basico = filter_input(INPUT_POST, 'projeto_basico', FILTER_SANITIZE_STRING);
$pos_prorrogacao = filter_input(INPUT_POST, 'pos_prorrogacao', FILTER_SANITIZE_STRING);
$periodo_prorrogacao = filter_input(INPUT_POST, 'periodo_prorrogacao', FILTER_SANITIZE_NUMBER_INT);
$link_pv = filter_input(INPUT_POST, 'link_pv', FILTER_SANITIZE_URL);

$link_ged = filter_input(INPUT_POST, 'link_ged', FILTER_SANITIZE_URL);
$link_proscorm = filter_input(INPUT_POST, 'link_proscorm', FILTER_SANITIZE_URL);
$natureza = filter_input(INPUT_POST, 'natureza', FILTER_SANITIZE_STRING);
$id_usuario = (int) filter_input(INPUT_POST, 'id_usuario', FILTER_SANITIZE_NUMBER_INT);

$id_prestador = (int) filter_input(INPUT_POST, 'id_prestador', FILTER_SANITIZE_NUMBER_INT);
$mine = filter_input(INPUT_POST, 'mine', FILTER_SANITIZE_STRING);
$n_processo = filter_input(INPUT_POST, 'n_processo', FILTER_SANITIZE_STRING);
$pasta = filter_input(INPUT_POST, 'pasta', FILTER_SANITIZE_STRING);

$tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_STRING);
$objeto = limpa(filter_input(INPUT_POST, 'objeto', FILTER_SANITIZE_STRING));
$periodo_entrega = filter_input(INPUT_POST, 'periodo_entrega', FILTER_SANITIZE_NUMBER_INT);
$intervalo_entrega = filter_input(INPUT_POST, 'intervalo_entrega', FILTER_SANITIZE_NUMBER_INT);
$apartir_data = filter_input(INPUT_POST, 'apartir_data', FILTER_SANITIZE_STRING);
$tip_chamado = filter_input(INPUT_POST, 'tip_chamado', FILTER_SANITIZE_NUMBER_INT);

$parametro_multa = filter_input(INPUT_POST, 'parametro_multa', FILTER_SANITIZE_NUMBER_INT);
$valor_contratado = floatval(filter_input(INPUT_POST, 'valor_Contratado', FILTER_SANITIZE_STRING));
$valor_garantia_exc = floatval(filter_input(INPUT_POST, 'valor_garantia_exc', FILTER_SANITIZE_STRING));
$percent_atrasoEntrega = floatval(filter_input(INPUT_POST, 'percent_atrasoEntrega', FILTER_SANITIZE_STRING));

$percent_naoObjeto = floatval(filter_input(INPUT_POST, 'percent_naoObjeto', FILTER_SANITIZE_STRING));
$percent_descumprimento = floatval(filter_input(INPUT_POST, 'percent_descumprimento', FILTER_SANITIZE_STRING));
$limiteParcial = floatval(filter_input(INPUT_POST, 'limiteParcial', FILTER_SANITIZE_STRING));
$limiteTotal = floatval(filter_input(INPUT_POST, 'limiteTotal', FILTER_SANITIZE_STRING));

$vig_contrat = filter_input(INPUT_POST, 'vig_contrat', FILTER_SANITIZE_NUMBER_INT);
$d_Inic_vige_contr = filter_input(INPUT_POST, 'd_Inic_vige_contr', FILTER_SANITIZE_STRING);
$vig_garantia = filter_input(INPUT_POST, 'vig_garantia', FILTER_SANITIZE_NUMBER_INT); // PERIODO
$periodo_garantia_exc = filter_input(INPUT_POST, 'periodo_garantia_exc', FILTER_SANITIZE_NUMBER_INT);

$intervalo_garantia = filter_input(INPUT_POST, 'intervalo_garantia', FILTER_SANITIZE_NUMBER_INT);
$percentual_garantia = floatval(filter_input(INPUT_POST, 'percentual_garantia', FILTER_SANITIZE_STRING));
$prazo_entrega = filter_input(INPUT_POST, 'prazo_entrega', FILTER_SANITIZE_STRING);
$d_Assinatura = floatval(filter_input(INPUT_POST, 'd_Assinatura', FILTER_SANITIZE_STRING));
$tipo_contagem_entrega = (int) filter_input(INPUT_POST, 'tipo_contagem_entrega', FILTER_SANITIZE_NUMBER_INT);
$tipo_contagem_entrega_exec = (int) filter_input(INPUT_POST, 'tipo_contagem_entrega_exec', FILTER_SANITIZE_NUMBER_INT);

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$_SESSION['dados'] = $dados;

$d = 1;

if ($permissa < '4') {

    if (isset($_POST['submitted'])) {
        $erro = array();

        if (empty($id_prestador)) {
            $erro[] = 'Selecionar o prestador de serviço';
        } else if (is_numeric($id_prestador)) {
            $id_prestador = mysqli_real_escape_string($conection, trim($id_prestador));
        } else {
            $erro[] = 'Selecione o prestador de serviço ';
        }

        if (empty($rg)) {
            $erro[] = 'Informar o RG do Contrato.';
        } else if (strlen($rg) < 5) {
            $erro[] = "Preencha o RG com no mínimo 5 caracteres.";
        } else {
            $rg = mysqli_real_escape_string($conection, trim($rg));
        }

        if (empty($projeto_basico)) {
            $erro[] = 'Informar o Projeto Básico.';
        } else if (strlen($projeto_basico) < 4) {
            $erro[] = "Preencha o Projeto Básico  com no mínimo 4 caracteres.";
        } else {
            $projeto_basico = mysqli_real_escape_string($conection, trim($projeto_basico));
        }

        if (empty($n_processo)) {
            $erro[] = 'Insira o número do Processo.';
        } else if (strlen($n_processo) < 4) {
            $erro[] = "Preencha o número do processo   com no mínimo 4 caracteres.";
        } else {
            $n_processo = mysqli_real_escape_string($conection, trim($n_processo));
        }

        if (empty($_POST['d_Assinatura'])) {
            $erro[] = 'Insira Data Assinatura.';
        } else {
            $d_Assinatura = mysqli_real_escape_string($conection, trim($_POST['d_Assinatura']));
        }


        $pasta = mysqli_real_escape_string($conection, trim($pasta));



        $d_Assinatura = str_replace("/", "-", $d_Assinatura);

        if (empty($status)) {
            $erro[] = 'Defina o Status do Contrato.';
        } else {
            $status = mysqli_real_escape_string($conection, trim($status));
        }

        if (empty($vig_contrat)) {
            $erro[] = 'Insira o periodo da Vigencia.';
        } else {
            $vig_contrat = mysqli_real_escape_string($conection, trim($vig_contrat));
        }

        if (empty($id_contrato)) {
            if (empty($_POST['d_Inic_vige_contr'])) {
                $erro[] = 'Insira Data Inicio da Vigencia.';
            }
            if (empty($id_usuario)) {
                $erro[] = 'Selecione o Fiscal Administrativo Designado para Este Contrato.';
            }
        }

        //validação sansoes
        if (empty($percent_atrasoEntrega)) {
            $erro[] = 'Informe Percentual para Penalidades na modalidade Atraso na Entrega';
        } else if (is_numeric($percent_atrasoEntrega)) {
            $percent_atrasoEntrega = mysqli_real_escape_string($conection, trim($percent_atrasoEntrega));
        } else {
            $erro[] = 'digite um numero válido';
        }

        if (empty($percent_naoObjeto)) {
            $erro[] = 'Informe Percentual para Penalidades na modalidade Não Entrega do Objeto';
        } else if (is_numeric($percent_naoObjeto)) {
            $percent_naoObjeto = mysqli_real_escape_string($conection, trim($percent_naoObjeto));
        } else {
            $erro[] = 'digite um numero válido';
        }

        if (empty($percent_descumprimento)) {
            $erro[] = 'Informe Percentual para Penalidades na modalidade Descumprimento de Cláusula Contratual';
        } else if (is_numeric($percent_descumprimento)) {
            $percent_descumprimento = mysqli_real_escape_string($conection, trim($percent_descumprimento));
        } else {
            $erro[] = 'digite um numero válido';
        }
        if (empty($limiteParcial)) {
            $erro[] = 'Informe Percentual para Limite Parcial para aplicação de Penalidade';
        } else if (is_numeric($limiteParcial)) {
            $limiteParcial = mysqli_real_escape_string($conection, trim($limiteParcial));
        } else {
            $erro[] = 'digite um numero válido';
        }

        if (empty($limiteTotal)) {
            $erro[] = 'Informe Percentual para Limite Máximo para aplicação de Penalidade';
        } else if (is_numeric($limiteTotal)) {
            $limiteTotal = mysqli_real_escape_string($conection, trim($limiteTotal));
        } else {
            $erro[] = 'digite um numero válido';
        }

        $d_Inic_vige_contr1 = str_replace("/", "-", $d_Inic_vige_contr);
        $d_Inic_vige_contr2 = inverteData($d_Inic_vige_contr1);

        // CALCULANDO DATA DE FIM DA VIGENCIA - ok
        if (!empty($vig_contrat)) {

            $termino_vig = SomarData($d_Inic_vige_contr2, 0, $vig_contrat, 0);
            $d_fim_vige_cont = SubData($termino_vig, $d, 0, 0);
        }

        if ($_REQUEST['action'] == 'salva') {

            // CALCULANDO DATA DE ENTREGA - ok
            if ($tipo === 'AQUISIÇÃO' || $tipo === 'SOLUÇÃO') {
                if (empty($periodo_entrega)) {
                    $erro[] = 'Insira Periodo para Entrega.';
                }
                if (empty($intervalo_entrega)) {
                    $erro[] = 'Insira Intervalo de Entrega.';
                }

                //  calculo prazo entrega inicial 
                //inicio          
                //calculo da entrega apartir da vigencia do contrato.
                if ($intervalo_entrega == 1) {

                    // Sendo dia util   

                    if ($tipo_contagem_entrega == 1) {

                        // certifica-se que prazo entrega inicial  caia num dia util
                        $prazo_entrega1 = SomaDiasUteis_data($d_Inic_vige_contr2, $periodo_entrega);
                        $prazo_entrega2 = SubData($prazo_entrega1, 1, 0, 0);

                        //Sendo dias corridos    
                    } else if ($tipo_contagem_entrega == 2) {


                        $prazo_entrega1 = SomarData($d_Inic_vige_contr2, $periodo_entrega, 0, 0);
                        $prazo_entrega2 = SubData($prazo_entrega1, 0, 0, 0);
                    }

                    //calculo da entrega apartir da assinatura.                 
                } else if ($intervalo_entrega == 2) {
                    $d_Assinatura2 = inverteData($d_Assinatura1);

                    // Sendo dia util   

                    if ($tipo_contagem_entrega == 1) {

                        // certifica-se que prazo entrega inicial  caia num dia util
                        $prazo_entrega1 = SomaDiasUteis_data($d_Assinatura2, $periodo_entrega);
                        $entrega_garantia_exc = SubData($prazo_entrega1, 1, 0, 0);

                        //Sendo dias corridos    
                    } else if ($tipo_contagem_entrega == 2) {


                        $prazo_entrega1 = SomarData($d_Assinatura2, $periodo_entrega, 0, 0);
                        $prazo_entrega2 = SubData($prazo_entrega1, 1, 0, 0);
                    }
                }

                //conversao
                $prazo_entrega = inverteData($prazo_entrega2);

                //fim         
            }
        }
        if ($_REQUEST['action'] == 'update') {
            //  calculo prazo entrega inicial 

            if (!empty($periodo_entrega) AND ! empty($intervalo_entrega)) {

                //calculo da entrega apartir da vigencia do contrato.
                if ($intervalo_entrega == 1) {

                    // Sendo dia util   

                    if ($tipo_contagem_entrega == 1) {

                        // certifica-se que prazo entrega inicial  caia num dia util
                        $prazo_entrega1 = SomaDiasUteis_data($d_Inic_vige_contr2, $periodo_entrega);
                        $prazo_entrega2 = SubData($prazo_entrega1, 1, 0, 0);

                        //Sendo dias corridos    
                    } else if ($tipo_contagem_entrega == 2) {


                        $prazo_entrega1 = SomarData($d_Inic_vige_contr2, $periodo_entrega, 0, 0);
                        $prazo_entrega2 = SubData($prazo_entrega1, 0, 0, 0);
                    }

                    //calculo da entrega apartir da assinatura.                 
                } else if ($intervalo_entrega == 2) {
                    $d_Assinatura2 = inverteData($d_Assinatura1);

                    // Sendo dia util   

                    if ($tipo_contagem_entrega == 1) {

                        // certifica-se que prazo entrega inicial  caia num dia util
                        $prazo_entrega1 = SomaDiasUteis_data($d_Assinatura2, $periodo_entrega);
                        $entrega_garantia_exc = SubData($prazo_entrega1, 1, 0, 0);

                        //Sendo dias corridos    
                    } else if ($tipo_contagem_entrega == 2) {


                        $prazo_entrega1 = SomarData($d_Assinatura2, $periodo_entrega, 0, 0);
                        $prazo_entrega2 = SubData($prazo_entrega1, 1, 0, 0);
                    }
                }

                //conversao
                $prazo_entrega = inverteData($prazo_entrega2);
            } else {

                $prazo_entrega = filter_input(INPUT_POST, 'prazo_entrega', FILTER_SANITIZE_STRING);
            }
        }

        if (empty($_POST['pos_prorrogacao'])) {
            $erro[] = 'Informe se há possibilidade Prorrogação.';
        } else {
            $pos_prorrogacao = mysqli_real_escape_string($conection, trim($_POST['pos_prorrogacao']));

            if ($pos_prorrogacao == 'NÃO') {

                $d_prorro = 0;

                if (!empty($periodo_prorrogacao)) {
                    //$erro[] = 'Não há previsão de prorrogação para este contrato.';
                    unset($periodo_prorrogacao);
                }
            } else if ($pos_prorrogacao == 'SIM') {

                if (empty($periodo_prorrogacao)) {
                    $erro[] = 'Insira Periodo da Prorrogação.';
                } else {
                    $d = ' 1';

                    $termino_pro = SomarData($d_Inic_vige_contr, 0, $periodo_prorrogacao, 0);
                    $d_prorro = SubData($termino_pro, $d, 0, 0);
                }
            }
        }

        if (empty($tipo)) {
            $erro[] = 'Selecione Aquisição ,  Serviço ou Solução.';
        } else {
            $tipo = mysqli_real_escape_string($conection, trim($tipo));
        }

        if ($tipo === 'SERVIÇOS') {

            if (empty($tip_chamado)) {
                $erro[] = 'Selecione o tipo de Chamado. Informação referente aos atendimentos e soluções especificadas nos niveis de severidade do respectivo controtao';
            } else {
                $tip_chamado = mysqli_real_escape_string($conection, trim($tip_chamado));
            }

            if (!empty($vig_garantia)) {

                unset($vig_garantia);
            }

            if (empty($parametro_multa)) {
                $erro[] = 'Escolha o tipo de Penalidade.';
            } else {
                $parametro_multa = mysqli_real_escape_string($conection, trim($parametro_multa));
            }
        }
        if ($_REQUEST['action'] == 'salva') {

            if ($tipo == 'AQUISIÇÃO' || $tipo == 'SOLUÇÃO') {

                if (empty($vig_garantia)) {
                    $erro[] = 'Insira Periodo da Vigencia Garantia.';
                } else {
                    $vig_garantia = mysqli_real_escape_string($conection, trim($vig_garantia));
                }
                /*  if (empty($entrega_garantia_exc)) {
                  $erro[] = 'Insira a  Data garantia de Execução';
                  } */

                if (empty($periodo_garantia_exc)) {
                    $erro[] = 'Insira periodo da garantia de execução.';
                }
                if (empty($intervalo_garantia)) {
                    $erro[] = 'Selecione o intenvalo, se é da vigência do contrato ou da assinatura.';
                }
                if (empty($percentual_garantia)) {
                    $erro[] = 'Insira Percentual do Valor da Garantia.';
                }
                if (empty($tipo_contagem_entrega_exec)) {
                    $erro[] = 'Selecione o tipo de contangem dos dias para o prazo, uteis ou corridos.';
                }

                //CALCULANDO DATA DA ENTREGA GARANTIA DE EXECUÇÃO -  SALVA
                if (!empty($periodo_garantia_exc) AND ! empty($intervalo_garantia)) {
                    //calculo da entrega apartir da vigencia do contrato.
                    if ($intervalo_garantia == 1) {

                        // Sendo dia util   

                        if ($tipo_contagem_entrega_exec == 1) {

                            // certifica-se que prazo entrega inicial  caia num dia util
                            $entrega_garantia_exc1 = SomaDiasUteis_data($d_Inic_vige_contr2, $periodo_garantia_exc);
                            $entrega_garantia_exc = SubData($entrega_garantia_exc1, 1, 0, 0);

                            //Sendo dias corridos    
                        } else if ($tipo_contagem_entrega_exec == 2) {


                            $entrega_garantia = SomarData($d_Inic_vige_contr2, $periodo_garantia_exc, 0, 0);
                            $entrega_garantia_exc = SubData($entrega_garantia, 0, 0, 0);
                        }

                        //calculo da entrega apartir da assinatura.                 
                    } else if ($intervalo_garantia == 2) {
                        $d_Assinatura2 = inverteData($d_Assinatura1);

                        // Sendo dia util   

                        if ($tipo_contagem_entrega_exec == 1) {

                            // certifica-se que prazo entrega inicial  caia num dia util
                            $entrega_garantia_exc1 = SomaDiasUteis_data($d_Assinatura2, $periodo_garantia_exc);
                            $entrega_garantia_exc = SubData($entrega_garantia_exc1, 1, 0, 0);

                            //Sendo dias corridos    
                        } else if ($tipo_contagem_entrega_exec == 2) {


                            $entrega_garantia = SomarData($d_Assinatura2, $periodo_garantia_exc, 0, 0);
                            $entrega_garantia_exc = SubData($entrega_garantia, 1, 0, 0);
                        }

                        // $entrega_garantia_exc = SomaDiasUteis_data($d_Assinatura2, $periodo_garantia_exc);
                        //$entrega_garantia_exc = inverteData($entrega_garantia_exc);
                    }

                    //conversao
                    $entrega_garantia_exc = inverteData($entrega_garantia_exc);
                }

                $valor_garantia_exc = $valor_contratado * ($percentual_garantia / 100);
            }
        }


        if ($_REQUEST['action'] == 'update') {


            if ($percentual_garantia) {

                $valor_garantia_exc = $valor_contratado * ($percentual_garantia / 100);
            }

            //CALCULANDO DATA DA ENTREGA GARANTIA DE EXECUÇÃO -  UPDATE
            if (!empty($periodo_garantia_exc) AND ! empty($intervalo_garantia)) {
                //calculo da entrega apartir da vigencia do contrato.
                if ($intervalo_garantia == 1) {

                    // Sendo dia util   

                    if ($tipo_contagem_entrega_exec == 1) {

                        // certifica-se que prazo entrega inicial  caia num dia util
                        $entrega_garantia_exc1 = SomaDiasUteis_data($d_Inic_vige_contr2, $periodo_garantia_exc);
                        $entrega_garantia_exc = SubData($entrega_garantia_exc1, 1, 0, 0);

                        //Sendo dias corridos    
                    } else if ($tipo_contagem_entrega_exec == 2) {


                        $entrega_garantia = SomarData($d_Inic_vige_contr2, $periodo_garantia_exc, 0, 0);
                        $entrega_garantia_exc = SubData($entrega_garantia, 0, 0, 0);
                    }

                    //calculo da entregarantia  apartir da assinatura.                 
                } else if ($intervalo_garantia == 2) {
                    $d_Assinatura2 = inverteData($d_Assinatura1);

                    // Sendo dia util   

                    if ($tipo_contagem_entrega_exec == 1) {

                        // certifica-se que prazo entrega inicial  caia num dia util
                        $entrega_garantia_exc1 = SomaDiasUteis_data($d_Assinatura2, $periodo_garantia_exc);
                        $entrega_garantia_exc = SubData($entrega_garantia_exc1, 1, 0, 0);

                        //Sendo dias corridos    
                    } else if ($tipo_contagem_entrega_exec == 2) {


                        $entrega_garantia = SomarData($d_Assinatura2, $periodo_garantia_exc, 0, 0);
                        $entrega_garantia_exc = SubData($entrega_garantia, 1, 0, 0);
                    }
                }

                //conversao
                $entrega_garantia_exc = inverteData($entrega_garantia_exc);
            } else {
                $entrega_garantia_exc = (filter_input(INPUT_POST, 'entrega_garantia_exc', FILTER_SANITIZE_STRING));
            }
        }

        if (empty($valor_contratado)) {
            $erro[] = 'Digite o Valor Contratado.';
        } else if (is_numeric($valor_contratado)) {
            $valor_contratado1 = mysqli_real_escape_string($conection, trim($valor_contratado));
            $valor_contratado = $valor_contratado1;
        }

        if (empty($n_siscor)) {
            $erro[] = 'Insira o SISCOR de Iniciação.';
        } else if (strlen($n_siscor) < 8) {
            $erro[] = "Preencha o SISCOR com no mínimo 8 caracteres.";
        } else {
            $n_siscor = mysqli_real_escape_string($conection, trim($n_siscor));
        }

        if (empty($objeto)) {
            $erro[] = 'Informar o Objeto do Contrato.';
        } else if (strlen($objeto) < 5) {
            $erro[] = "Preencha o Objeto com no mínimo 5 caracteres.";
        } else if (is_string($objeto)) {
            $objeto1 = mysqli_real_escape_string($conection, trim($objeto));
            $objeto = limpa($objeto1);
        }

        if (empty($link_pv)) {
            $erro[] = 'Insira o link processo verde.';
        } else {
            $link_pv = mysqli_real_escape_string($conection, trim($link_pv));
        }


        if (empty($link_ged)) {
            $erro[] = 'Selecione linke Gedig.';
        } else {
            $link_ged = mysqli_real_escape_string($conection, trim($link_ged));
        }

        $link_proscorm = mysqli_real_escape_string($conection, trim($_POST['link_proscorm']));

        if (empty($natureza)) {
            $erro[] = 'Insira Area Gestora.';
        } else {
            $natureza = mysqli_real_escape_string($conection, trim($natureza));
        }

        if (empty($erro)) {

            if (($_REQUEST['action'] == 'salva')) {


                $q = "SELECT rg FROM contrato WHERE rg = '$rg'";
                $r = mysqli_query($conection, $q);
                $num = mysqli_num_rows($r);

                if ($num == 0) {

                    $q1 = "INSERT INTO contrato 
             (id_contrato, id_prestador, rg, d_Registro, projeto_basico, d_emissao, n_processo, d_Assinatura, status, d_Inic_vige_contr, 
            d_fim_vige_cont, pos_prorrogacao, vig_garantia, obs, valor_Contratado, d_prorro, d_Aceite, n_siscor, objeto, tipo, prazo_entrega, d_recebimento, 
             vig_contrat, d_fim_g, link_pv, link_ged, link_proscorm, agora, natureza, tip_chamado, fim_vig_garat, mine,data_prorro_aditivo, percent_atrasoEntrega,
            percent_naoObjeto, percent_descumprimento,limiteParcial,limiteTotal,entrega_garantia_exc, parametro_multa, periodo_garantia_exc, valor_garantia_exc, pasta) 
	    VALUES 
	    ('','$id_prestador','$rg','','$projeto_basico','','$n_processo','$d_Assinatura','$status','$d_Inic_vige_contr','$d_fim_vige_cont',
                '$pos_prorrogacao','$vig_garantia','','$valor_contratado','$d_prorro','', '$n_siscor', '$objeto','$tipo','$prazo_entrega','',
                '$vig_contrat','','$link_pv', '$link_ged', '$link_proscorm','', '$natureza', '$tip_chamado','','$mine', '', '$percent_atrasoEntrega', 
                 '$percent_naoObjeto', '$percent_descumprimento','$limiteParcial','$limiteTotal','$entrega_garantia_exc', '$parametro_multa', '$periodo_garantia_exc', '$valor_garantia_exc', '$pasta')";
                    $r1 = mysqli_query($conection, $q1) or die(mysqli_error($conection));

                    $id_return = mysqli_insert_id($conection);

                    if ($tipo === 'AQUISIÇÃO' || $tipo === 'SOLUÇÃO') {

                        $tipo_prorog = 2;
                        $categoria = 2;

                        $result = "INSERT INTO historico_prorrogacao (id_contrato, tipo_prorog,d_prorrogada, detalhe, categoria)"
                                . " VALUES ('$id_return','$tipo_prorog','$entrega_garantia_exc', '$detalhe','$categoria')";
                        $resultado = mysqli_query($conection, $result);


                        $tipo_prorog = 1;
                        $categoria = 1;

                        $result = "INSERT INTO historico_prorrogacao (id_contrato, tipo_prorog,d_prorrogada, detalhe,categoria)"
                                . " VALUES ('$id_return','$tipo_prorog','$prazo_entrega', '$detalhe','$categoria')";
                        $resultado = mysqli_query($conection, $result);
                    }

                    if ($id_return) {

                        //atribuir fiscal
                        if (!empty($id_usuario)) {
                            $query_user = "SELECT * FROM usuario WHERE id_usuario= '$id_usuario'";
                            $resultado_user = mysqli_query($conection, $query_user);
                            while ($row = mysqli_fetch_assoc($resultado_user)) {

                                $nom = $row['nome'];
                                $lot = $row['lotacao'];
                                $fun = $row['funcao'];
                                $email = $row['email'];
                                $matricula = $row['matricula'];
                                $tel = $row['telefone'];
                            }
                            $id_local = null;
                            $resp = 'Fiscal Administrativo';


                            $query = "INSERT INTO responsaveis (nome, area, funcao, email, matricula, telefone, id_local, responsabilidade, id_contrato )
                  VALUES ('$nom', '$lot','$fun', '$email','$matricula','$tel','$id_local','$resp','$id_return' )";
                            $r1 = mysqli_query($conection, $query) or die(mysqli_error($conection));
                        }

                        unset($_SESSION['dados']);

                        $_SESSION['msg31'] = "<p style='color:green;'> Contrato cadastrado com sucesso ! </p>";
                        header("Location:contrato.php");
                    } else {
                        $_SESSION['msg31'] = "<p style='color:red;'> Há algum erro, o contrato não foi cadastrado!</p>";
                        header("Location:contrato.php");
                    }
                } else {

                    unset($_SESSION['dados']);

                    $_SESSION['msg31'] = "<p style='color:green;'> Este contrato já foi cadastrado</p>";
                    header("Location:contrato.php");
                }
            } else {



                $q1 = "UPDATE contrato SET  id_prestador ='$id_prestador', rg = '$rg', projeto_basico = '$projeto_basico', n_processo = '$n_processo', d_Assinatura='$d_Assinatura',
            status = '$status', d_Inic_vige_contr = '$d_Inic_vige_contr',d_fim_vige_cont = '$d_fim_vige_cont', pos_prorrogacao = '$pos_prorrogacao', vig_garantia ='$vig_garantia',  valor_contratado = '$valor_contratado', d_prorro='$d_prorro', 
            n_siscor='$n_siscor', objeto='$objeto',  tipo='$tipo', prazo_entrega='$prazo_entrega', vig_contrat='$vig_contrat', link_pv='$link_pv', link_ged='$link_ged', link_proscorm='$link_proscorm', agora='NOW()', natureza='$natureza',
            tip_chamado ='$tip_chamado' , mine ='$mine',percent_atrasoEntrega ='$percent_atrasoEntrega',  percent_naoObjeto = '$percent_naoObjeto',
           percent_descumprimento = '$percent_descumprimento', limiteParcial = '$limiteParcial', limiteTotal = '$limiteTotal',entrega_garantia_exc = '$entrega_garantia_exc', parametro_multa = '$parametro_multa', periodo_garantia_exc ='$periodo_garantia_exc', valor_garantia_exc = '$valor_garantia_exc', pasta ='$pasta' WHERE id_contrato ='$id_contrato'";

                
                      $id_return = mysqli_insert_id($conection);

                    if ($tipo === 'AQUISIÇÃO' || $tipo === 'SOLUÇÃO') {
                        
                        
                        $query="select id_prrrog from  historico_prorrogacao";
                        $result = mysqli_query($conection, $result);
                        $num = mysqli_num_rows($result);
                        
                        if($num == 0){
                            
                        $tipo_prorog = 2;
                        $categoria = 2;

                        $result = "INSERT INTO historico_prorrogacao (id_contrato, tipo_prorog,d_prorrogada, detalhe, categoria)"
                                . " VALUES ('$id_contrato','$tipo_prorog','$entrega_garantia_exc', '$detalhe','$categoria')";
                        $resultado = mysqli_query($conection, $result);


                        $tipo_prorog = 1;
                        $categoria = 1;

                        $result = "INSERT INTO historico_prorrogacao (id_contrato, tipo_prorog,d_prorrogada, detalhe,categoria)"
                                . " VALUES ('$id_contrato','$tipo_prorog','$prazo_entrega', '$detalhe','$categoria')";
                        $resultado = mysqli_query($conection, $result);
                        
                        }else{
                            
                        $tipo_prorog = 2;
                        $categoria = 2;

                        $result = "UPDATE historico_prorrogacao SET  tipo_prorog='$tipo_prorog',
                                d_prorrogada='$entrega_garantia_exc', detalhe='$detalhe', categoria='$categoria' WHERE id_contrato ='$id_contrato'";
                              
                        $resultado = mysqli_query($conection, $result);


                        $tipo_prorog = 1;
                        $categoria = 1;
                                
                         $result = "UPDATE historico_prorrogacao SET  tipo_prorog='$tipo_prorog',
                         d_prorrogada='$prazo_entrega', detalhe='$detalhe', categoria='$categoria' WHERE id_contrato ='$id_contrato'";                        
                         $resultado = mysqli_query($conection, $result);
                        }
                        
                        

                    }
                
                
                
                
                
                
                
                
                $r1 = mysqli_query($conection, $q1);

                $_SESSION['msg31'] = "<p style='color:green;'> Registro atualizado com Sucesso!</p>";
                header("Location:contrato.php");
            }
        } else {

            foreach ($erro as $mg)
                $_SESSION['msg31'] = "<div class='alert alert-danger' role='alert'> $mg <br>\n</div>";
            header("Location:contrato.php");
        }
    }
} else {

    $_SESSION['msg31'] = "<p style='color:red;'> Você não tem permissão para cadastrar registro</p>";
    header("Location:contrato.php");
}
  
       