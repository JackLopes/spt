<?php

session_start();

$permissa = $_SESSION['permissao'];

require_once 'Funcoes/limpa_string.php';
require_once 'database_gac.php';

$programada = filter_input(INPUT_POST, 'programada', FILTER_SANITIZE_NUMBER_INT);
$prazo_soft = filter_input(INPUT_POST, 'prazo_soft', FILTER_SANITIZE_NUMBER_INT);
$id_contrato = filter_input(INPUT_POST, 'id_contrato', FILTER_SANITIZE_NUMBER_INT);
$id_severidade = filter_input(INPUT_POST, 'id_severidade', FILTER_SANITIZE_NUMBER_INT);
$prazo_atend = filter_input(INPUT_POST, 'prazo_atend', FILTER_SANITIZE_NUMBER_INT);
$prazo_solu = filter_input(INPUT_POST, 'prazo_solu', FILTER_SANITIZE_NUMBER_INT);
$descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
$multa = filter_input(INPUT_POST, 'multa', FILTER_SANITIZE_STRING);
$item = filter_input(INPUT_POST, 'item', FILTER_SANITIZE_STRING);
$modo = filter_input(INPUT_POST, 'modo', FILTER_SANITIZE_NUMBER_INT);
$severidade = filter_input(INPUT_POST, 'severidade', FILTER_SANITIZE_NUMBER_INT);
$tipo_atendimento = filter_input(INPUT_POST, 'tipo_atendimento', FILTER_SANITIZE_STRING);
$tolerancia = filter_input(INPUT_POST, 'tolerancia', FILTER_SANITIZE_NUMBER_INT);
$start_onsite = filter_input(INPUT_POST, 'start_onsite', FILTER_SANITIZE_NUMBER_INT);
$submitted = filter_input(INPUT_POST, 'submitted', FILTER_SANITIZE_STRING);




/*
  /*

  $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
  $_SESSION['dados']=$dados ;

  var_dump($dados);
 */



if ($permissa < '4') {


    if (isset($submitted)) {
        $erro = array();

        if (empty($id_contrato)) {
            $erro[] = 'Há problemas com a identificação do contrato';
        } else if (is_numeric($id_contrato)) {
            $id_contrato = mysqli_real_escape_string($conection, trim($id_contrato));
        } else {
            $erro[] = 'Há problemas com a identificação do contrato';
        }

        if (empty($prazo_atend)) {
            $erro[] = 'Digite o prazo para atendimento';
        } else if (is_numeric($prazo_atend)) {
            $prazo_atend = mysqli_real_escape_string($conection, trim($prazo_atend));
        } else {
            $erro[] = 'Deve ser um número';
        }

        if (!empty($prazo_soft) && $item == 'Software' && $prazo_soft === '1') {
            $prazo_solu = 100000;
        }

        if (!empty($programada) && $severidade == '3' && $programada === '1') {
            $programada = 'Mant. Programada';
            $prazo_solu = 100000;
        } else {
            $programada = null;
        }

        if (empty($prazo_solu)) {
            $erro[] = 'Digite o prazo para solução';
        } else if (is_numeric($prazo_solu)) {
            $prazo_solu = mysqli_real_escape_string($conection, trim($prazo_solu));
        } else {
            $erro[] = 'Deve ser um número';
        }


        if (empty($descricao)) {
            $erro[] = 'Selecione a descrição referente ao nivel de severidade.';
        } else {
            $descricao = mysqli_real_escape_string($conection, trim($descricao));
        }

        if (empty($multa)) {
            $erro[] = 'Digite o valor da Multa';
        } else {
            $multa = mysqli_real_escape_string($conection, trim($multa));
            $multa = (floatval($multa));
        }

        if (empty($item)) {
            $erro[] = 'Selecione o item.';
        } else {
            $item = mysqli_real_escape_string($conection, trim($item));
        }

        if (empty($modo)) {
            $erro[] = 'Selecione o modo.';
        } else {
            $modo = mysqli_real_escape_string($conection, trim($modo));
            $modo = (int) $modo;
        }

        if (empty($severidade)) {
            $erro[] = 'Selecione a Severidade';
        } else if (is_numeric($severidade)) {
            $severidade = mysqli_real_escape_string($conection, trim($severidade));
        } else {
            $erro[] = 'Deve ser um número';
        }

        if (empty($tipo_atendimento)) {
            $erro[] = 'Selecione o tipo de atendimento.';
        } else {
            $tipo_atendimento = mysqli_real_escape_string($conection, trim($tipo_atendimento));
        }

        if ($tipo_atendimento === 'Remoto e On-Site') {

            if (empty($start_onsite)) {
                $erro[] = 'Digite o prazo para inicio do On-site';
            } else if (is_numeric($start_onsite)) {
                $start_onsite = mysqli_real_escape_string($conection, trim($start_onsite));
            } else {
                $erro[] = 'Deve ser um número';
            }

            if (empty($tolerancia)) {
                $erro[] = 'Digite o prazo de tolerância';
            } else if (is_numeric($tolerancia)) {
                $tolerancia = mysqli_real_escape_string($conection, trim($tolerancia));
            } else {
                $erro[] = 'Deve ser um número';
            }
        } else if ($tipo_atendimento === 'Remoto e On-Site Atipico') {
            $start_onsite = 100;
            $tolerancia = 100;
        } else {
            $start_onsite = 0;
            $tolerancia = 0;
        }





        if (empty($erro)) {


           


            $q = "UPDATE severidades  SET id_contrato='$id_contrato', prazo_atend='$prazo_atend', prazo_solu='$prazo_solu', descricao='$descricao', multa='$multa', item='$item', modo='$modo', severidade='$severidade',
            tipo_atendimento='$tipo_atendimento', tolerancia='$tolerancia', start_onsite='$start_onsite', programada='$programada' WHERE id_severidade='$id_severidade' ";
	
            $r = mysqli_query($conection, $q)or die(mysqli_error($conection));

            if ($r) {


                $_SESSION['msg40'] = "<p style='color:green;'> Severidade atualizada com sucesso ! </p>";
               header("Location:atu_severidade.php?id=$id_contrato&id_severidade=$id_severidade");
            } else {
                $_SESSION['msg40'] = "<p style='color:red;'> A Severidade não foi atualizada!</p>";
               header("Location:atu_severidade.php?id=$id_contrato&id_severidade=$id_severidade");
            }
        } else {

            foreach ($erro as $mg)
                $_SESSION['msg40'] = "<div class='alert alert-danger' role='alert'>- $mg<br>\n</div>";
            header("Location:atu_severidade.php?id=$id_contrato&id_severidade=$id_severidade");
        }
    }
} else {

    $_SESSION['msg40'] = "<p style='color:red;'> Você não tem permissão para cadastrar registro</p>";
    header("Location:atu_severidade.php?id=$id_contrato&id_severidade=$id_severidade");
}
  

