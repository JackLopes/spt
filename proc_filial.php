<?php

session_start();

$permissa = $_SESSION['permissao'];

$id = filter_input(INPUT_POST, 'id_prestador', FILTER_SANITIZE_NUMBER_INT);
$ct = filter_input(INPUT_POST, 'ct', FILTER_SANITIZE_NUMBER_INT);
$pais = filter_input(INPUT_POST, 'pais', FILTER_SANITIZE_STRING);
$estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);
$cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING);
$Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);


require_once 'database_gac.php';
require_once 'Funcoes/limpa_string.php';



if ($permissa < '4') {
    if (isset($_POST['submitted'])) {
        $erro = array();


        if (empty($_POST['nome'])) {
            $erro[] = 'Selecionar o Prestador do Serviço.';
        } else if (strlen($_POST['nome']) < 8) {
            $erro[] = "Preencha a Razão com no mínimo 8 caracteres.";
        } else {
            $nom = mysqli_real_escape_string($conection, trim($_POST['nome']));
            $nom = limpa($nom);
        }
        
        include 'validar_cnpj.php';

        $cnpj = ($_POST['cnpj']);

        if (empty($_POST['cnpj'])) {
            $erro[] = 'Informar o CNPJ.';
        } else if (valida_cnpj($_POST['cnpj'])) {
            $cnp = $_POST['cnpj'];
        } else {

            $erro[] = ' CNPJ Inválido.';
        }
        
        if (empty($_POST['endereco'])) {
            $erro[] = 'Informar o Endereço.';
        } else if (strlen($_POST['endereco']) < 8) {
            $erro[] = "Preencha o Endereço com no mínimo 8 caracteres.";
        } else {
            $end = mysqli_real_escape_string($conection, trim($_POST['endereco']));
            $end = limpa($end);
        }
        if (empty($erro)) {

            $q = "SELECT cnpj FROM filial WHERE cnpj = '$cnp'";
            $r = mysqli_query($conection, $q);
            $num = mysqli_num_rows($r);
            
            $q = "SELECT cnpj FROM prestador WHERE cnpj = '$cnp'";
            $r = mysqli_query($conection, $q);
            $num1 = mysqli_num_rows($r);

            if ($num == 0 AND $num1 == 0) {
                
               

                $q1 = "INSERT INTO  filial (id_prestador, nome, cnpj, endereco, cep,estado, pais  ) 
                   VALUES ('$id','$nom', '$cnp','$end', '$cep', '$estado', '$pais')";
                  $r1 = mysqli_query($conection, $q1);


                if ($result) {
                    $_SESSION['msg37'] = "<p style='color:green;'> Registro cadastrado com sucesso </p>";
                    header("Location: inf_prestador2.php?id=$id&ct=$ct");
                } else {
                    $_SESSION['msg37'] = "<p style='color:green;'> Registro Não cadastrado  </p>";
                    header("Location: inf_prestador2.php?id=$id&ct=$ct");
                }
            } else {
                $_SESSION['msg37'] = "<span style='color:red;'> Esta filial já foi inserida </span>";
                header("Location: inf_prestador2.php?id=$id&ct=$ct");
            }
        } else {
            foreach ($erro as $mg) {

                $_SESSION['msg37'] = "<p style='color:red;'>$mg</p>";
                header("Location: inf_prestador2.php?id=$id&ct=$ct");
            }
        }
    }
} else {
    $_SESSION['msg37'] = "<span style='color:red;'> Você não tem permissão para incluir registro</span>";
    header("Location: inf_prestador2.php?id=$id&ct=$ct");
}
 

