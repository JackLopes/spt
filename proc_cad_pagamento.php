<?php

session_start();

$page_title = 'Cadastrando Contrato';

require_once 'database_gac.php';
require_once 'Funcoes/func_data.php';
require_once 'Funcoes/limpa_string.php';
require_once 'Funcoes/valida_data1.php';
require_once 'Funcoes/verifica_feriado.php';
require_once 'Funcoes/func_pagamento.php';

$id_tipo = filter_input(INPUT_POST, 'id_tipo', FILTER_SANITIZE_NUMBER_INT);
$id_pag = filter_input(INPUT_POST, 'id_pag', FILTER_SANITIZE_NUMBER_INT);
$id_contrato = filter_input(INPUT_POST, 'id_contrato', FILTER_SANITIZE_NUMBER_INT);
$nota_fiscal = filter_input(INPUT_POST, 'nota_fiscal', FILTER_SANITIZE_STRING);
$parcela = filter_input(INPUT_POST, 'valor_parcela', FILTER_SANITIZE_STRING);
$data_inicio_per = filter_input(INPUT_POST, 'data_inicio_per', FILTER_SANITIZE_STRING);
$data_fim_per = filter_input(INPUT_POST, 'data_fim_per', FILTER_SANITIZE_STRING);
$d_assinatura_dig = filter_input(INPUT_POST, 'd_assinatura_dig', FILTER_SANITIZE_STRING);
$autuado = filter_input(INPUT_POST, 'aut_nota', FILTER_SANITIZE_STRING);
$medido = filter_input(INPUT_POST, 'medido', FILTER_SANITIZE_STRING);
$siscor = filter_input(INPUT_POST, 'siscor', FILTER_SANITIZE_STRING);
$obser = filter_input(INPUT_POST, 'obser', FILTER_SANITIZE_STRING);
$cnpj_faturamento = filter_input(INPUT_POST, 'cnpj_faturamento', FILTER_SANITIZE_STRING);
$regional = filter_input(INPUT_POST, 'regional', FILTER_SANITIZE_STRING);
$verif = filter_input(INPUT_POST, 'verif', FILTER_SANITIZE_STRING);



$pesquisa = filter_input(INPUT_POST, 'pesquisa', FILTER_SANITIZE_STRING);
$rg = filter_input(INPUT_POST, 'rg', FILTER_VALIDATE_INT);
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);

$relatorio = filter_input(INPUT_POST, 'relatorio', FILTER_SANITIZE_STRING);
$ateste = filter_input(INPUT_POST, 'ateste', FILTER_SANITIZE_STRING);
$recebimento_nota = filter_input(INPUT_POST, 'recebimento_nota', FILTER_SANITIZE_STRING);
$all = (int) filter_input(INPUT_POST, 'all', FILTER_SANITIZE_STRING);


$mes_pesquisa = (int)filter_input(INPUT_POST, 'mes_pesquisa', FILTER_SANITIZE_STRING);
$ano_pesquisa = (int)filter_input(INPUT_POST, 'ano_pesquisa', FILTER_SANITIZE_STRING);



$query = "SELECT tip.* , loc.id_contrato,loc.sigla, cont.tip_chamado, 
				cont.rg, cont.valor_Contratado,cont.id_prestador, cont.id_contrato, loc.lugar_regional				
				FROM tipo AS tip
				INNER JOIN local AS loc ON  loc.id_local = tip.id_local
				INNER JOIN  contrato AS cont ON  cont.id_contrato = loc.id_contrato
				WHERE id_tipo = '$id_tipo'";

$resultado = mysqli_query($conection, $query)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado)) {
    $val_contr = $registro['valor_Contratado'];
    $id_prestador = $registro['id_prestador'];
    $id_contrato = $registro['id_contrato'];
    $regional = $registro['sigla'];
}


$sql3 = "SELECT cnpj FROM prestador WHERE id_prestador = $id_prestador";
$resultado1 = mysqli_query($conection, $sql3)or die('Não foi possivel conectar ao MySQL');
while ($registro1 = mysqli_fetch_array($resultado1)) {

    $cnpj_prestador = $registro1['cnpj'];
}

if (empty($cnpj_faturamento)) {
    $cnpj_faturamento = $cnpj_prestador;
}





if (isset($_POST['submitted'])) {
    $erro = array();



    if (empty($nota_fiscal)) {
        $erro[] = 'Informar o número da nota.';
    } else if (strlen($nota_fiscal) < 3) {
        $erro[] = "Preencha a nota com no mínimo 3 caracteres.";
    } else {
        $nota_fiscal = mysqli_real_escape_string($conection, trim($nota_fiscal));
    }

    if (empty($parcela)) {
        $erro[] = 'Digite o valor da parcela.';
    } else if ($parcela > $val_contr) {
        $erro[] = 'Não é possivel lançar um valor maior que o contratado.';
    } else {
        $parcela = mysqli_real_escape_string($conection, trim($parcela));
        $parcela = floatval($parcela);
    }



    if (empty($data_inicio_per)) {
        $erro[] = 'Insira Data Assinatura.';
    } else {
        $data_inicio_per = mysqli_real_escape_string($conection, trim($data_inicio_per));
    }

    if (empty($data_fim_per)) {
        $erro[] = 'Insira Data Assinatura.';
    } else {
        $data_fim_per = mysqli_real_escape_string($conection, trim($data_fim_per));
    }

    if (empty($d_assinatura_dig)) {
        //$erro[] = 'Insira Data Assinatura.';
    } else {
        $d_assinatura_dig = mysqli_real_escape_string($conection, trim($d_assinatura_dig));
    }

    if (!empty($d_assinatura_dig)) {
        $d = ' 1';

        //Determinar data vencimento 

        $d_assinatura_dig1 = inverteData($d_assinatura_dig);
        $d_vencimento_pag1 = SomarData($d_assinatura_dig1, 20, 0, 0);
        $d_vencimento_pag2 = SubData($d_vencimento_pag1, $d, 0, 0);
        $d_vencimento_pag3 = inverteData($d_vencimento_pag2);

        $data_vencimento = proximoDiaUtil($d_vencimento_pag3);

        // verificar se é feriado e sendo soma um dia. para depoi verificar se é final de semana
        $data_vencimento1 = inverteData($data_vencimento);
        $data_posterior = SomarData($data_vencimento1, 1, 0, 0);
        $data_anterior = SubData($data_vencimento1, 1, 0, 0);

        if ($acres = DiasAcrescentar($data_anterior, $data_posterior) > 0) {
            $data_vencimento_pag4 = SomarData($data_vencimento1, 1, 0, 0);
        } else {

            $data_vencimento_pag4 = $data_vencimento1;
        }
        if ($data_vencimento_pag4) {
            $d_vencimento_pag5 = inverteData($data_vencimento_pag4);
            $data_vencimento_pag = proximoDiaUtil($d_vencimento_pag5);
        }
    }

    $obser = mysqli_real_escape_string($conection, trim($obser));

    if (!empty($nota_fiscal) && !empty($d_assinatura_dig) && !empty($siscor) && !empty($data_vencimento_pag) && !empty($autuado) && !empty($medido)) {
        $status = "Ok";
    } else {
        $status = "Pendente";
    }


    // Inicio validação dos registros
    //var_dump($id_pag);
/*
   $id_pags = array();
    $query = "select id_pag from pagamentos where id_contrato = '$id_contrato'";
    $result = mysqli_query($conection, $query);
    while ($registro = mysqli_fetch_array($result)) {

        $id_pags[] = $registro['id_pag'];
    }

    
    $num_pag = count($id_pags); //total de indices do array
    
    if($num_pag > 1){
    sort($id_pags); // ordena array
    $indice = array_keys($id_pags, $id_pag);
    array_push($indice, -1);
    $value = array_sum($indice);
    $verif_id = (int) $id_pags[$value];

    $query1 = "SELECT medido, d_assinatura_dig, siscor FROM pagamentos WHERE id_pag ='$verif_id' AND  (medido='' OR d_assinatura_dig ='0000-00-00' OR siscor ='') LIMIT 1 ";
    $result1 = mysqli_query($conection, $query1);
    $num_very = mysqli_num_rows($result1);
    
    }
     */
    $num_very = 0;
//fim Validação
    if (empty($erro)) {

        $complemento = ', preencha os meses anteriores para prosseguir a atualização dos registros';

        if ($num_very == 0) {





            $q1 = "UPDATE pagamentos SET   nota_fiscal='$nota_fiscal', valor_parcela='$parcela', data_inicio_per='$data_inicio_per',  data_fim_per='$data_fim_per', aut_nota='$autuado', medido='$medido',
               d_assinatura_dig='$d_assinatura_dig', d_vencimento_pag=' $data_vencimento_pag', siscor='$siscor', obser='$obser',regional='$regional', status='$status' , relatorio='$relatorio',ateste='$ateste', recebimento_nota='$recebimento_nota',  cnpj_faturamento='$cnpj_faturamento' WHERE id_pag='$id_pag'";
            $r1 = mysqli_query($conection, $q1);



            if ($relatorio === 'Sim') {
                $q2 = "UPDATE pagamentos SET    relatorio='$relatorio' WHERE recebimento_nota='$recebimento_nota'  AND id_contrato='$id_contrato'  ";
                $r2 = mysqli_query($conection, $q2);
            }

            if ($all === 1) {
                $q3 = "UPDATE pagamentos SET    recebimento_nota='$recebimento_nota' WHERE  data_fim_per BETWEEN '$inicial' AND '$final' AND id_contrato='$id_contrato' ";
                $r3 = mysqli_query($conection, $q3);
            }

            if (empty($pesquisa)) {

                if ($q1) {
                    $_SESSION['msg28'] = "<h4  class='alert alert-success'> Registro atualizado com sucesso </h4>";
                    header("Location: cad_pag.php?id_tipo=$id_tipo");
                } else {
                    $_SESSION['msg28'] = "<h4 class='alert alert-danger'> Registro não foi atualizado </h4>";
                   header("Location: cad_pag.php?id_tipo=$id_tipo");
                }
            }





            if (!empty($pesquisa)) {

                if ($q1) {
                    $_SESSION['msg28'] = "<h4  class='alert alert-success'> Registro atualizado com sucesso </h4>";
                    header("Location: atestes.php?pesquisa=$pesquisa&inicial=$inicial&final=$final&rg=$rg");
                } else {
                    $_SESSION['msg28'] = "<h4 class='alert alert-danger'>  Registro não foi atualizado </h4>";
                    header("Location: atestes.php?pesquisa=$pesquisa&inicial=$inicial&final=$final&rg=$rg");
                }

                if (($pesquisa == 'list1')) {
                    if ($q1) {
                        $_SESSION['msg28'] = "<h4  class='alert alert-success'> Registro atualizado com sucesso </p>";
                        header("Location: atestes.php?action=$pesquisa&mes_pesquisa=$mes_pesquisa&ano_pesquisa=$ano_pesquisa&rg=$rg");
                        exit();
                    } else {
                        $_SESSION['msg28'] = "<h4 class='alert alert-danger'>  Registro não foi atualizado  </h4>";
                        header("Location: atestes.php?action=$pesquisa&mes_pesquisa=$mes_pesquisa&ano_pesquisa=$ano_pesquisa&rg=$rg");
                        exit();
                    }
                }
                if (($pesquisa == 'list2')) {
                    if ($q1) {
                        $_SESSION['msg28'] = "<h4  class='alert alert-success'> Registro atualizado com sucesso </p>";
                        header("Location: atestes.php?action=$pesquisa&mes_pesquisa=$mes_pesquisa&ano_pesquisa=$ano_pesquisa&rg=$rg&nome=$nome");
                        exit();
                    } else {
                        $_SESSION['msg28'] = "<p style='color:green;'> Registro não foi atualizado  </p>";
                        header("Location: atestes.php?action=$pesquisa&mes_pesquisa=$mes_pesquisa&ano_pesquisa=$ano_pesquisa&rg=$rg&nome=$nome");
                        exit();
                    }
                }
                if (($pesquisa == 'list3')) {
                    if ($q1) {
                        $_SESSION['msg28'] = "<h4  class='alert alert-success'> Registro atualizado com sucesso </p>";
                        header("Location: atestes.php?action=$pesquisa&verif=$verif&nome=$nome");
                        exit();
                    } else {
                        $_SESSION['msg28'] = "<p style='color:green;'> Registro não foi atualizado  </p>";
                        header("Location: atestes.php?action=$pesquisa&verif=$verif&nome=$nome");
                        exit();
                    }
                }
            }
        } else {


            if (empty($pesquisa)) {

                $_SESSION['msg28'] = "<h4 class='alert alert-danger'> Registro não foi atualizado $complemento </h4>";
              header("Location: cad_pag.php?id_tipo=$id_tipo");
                exit();
            }
            if (($pesquisa == 'list1')) {

                $_SESSION['msg28'] = "<h4 class='alert alert-danger'> Registro não foi atualizado $complemento </h4>";

                if ($mes_pesquisa == 0) {

                   header("Location: atestes.php");
                    exit();
                } else {
                    header("Location: atestes.php?action=$pesquisa&mes_pesquisa=$mes_pesquisa&ano_pesquisa=$ano_pesquisa&rg=$rg");
                    exit();
                }
            }
            if (($pesquisa == 'list2')) {
                $_SESSION['msg28'] = "<h4 class='alert alert-danger'> Registro não foi atualizado $complemento </h4>";
                header("Location: atestes.php?action=$pesquisa&mes_pesquisa=$mes_pesquisa&ano_pesquisa=$ano_pesquisa&rg=$rg&nome=$nome");
                exit();
            }
            if (($pesquisa == 'list3')) {
                $_SESSION['msg28'] = "<h4 class='alert alert-danger'> Registro não foi atualizado $complemento </h4>";
                header("Location: atestes.php?action=$pesquisa&verif=$verif&nome=$nome");
                exit();
            }
        }
    } else {

        if (($_REQUEST['action'] == 'ateste')) {

            foreach ($erro as $mg) {

                $_SESSION['msg28'] = "<h4 class='alert alert-danger'> $mg</h4>";
                if (($pesquisa == 'list1')) {
                  if  ($mes_pesquisa == 0) {

                 header("Location: atestes.php");
                    exit();
                } else {
                    header("Location: atestes.php?action=$pesquisa&mes_pesquisa=$mes_pesquisa&ano_pesquisa=$ano_pesquisa&rg=$rg");
                    exit();
                }
                }
                if (($pesquisa == 'list2')) {
                    header("Location: atestes.php?action=$pesquisa&mes_pesquisa=$mes_pesquisa&ano_pesquisa=$ano_pesquisa&rg=$rg&nome=$nome");
                    exit();
                }
                if (($pesquisa == 'list3')) {

                    header("Location: atestes.php?action=$pesquisa&verif=$verif&nome=$nome");
                    exit();
                }

               // header("Location: atestes.php");
            }
        } else {

            foreach ($erro as $mg) {

                $_SESSION['msg28'] = "<h4  class='alert alert-danger'>$mg</h4>";
                header("Location: cad_pag.php?id_tipo=$id_tipo");
            }
        }
    }
}
