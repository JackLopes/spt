<?php

session_start();

$page_title = 'Corretiva';

$id_prestador = filter_input(INPUT_POST, 'id_prestador', FILTER_SANITIZE_NUMBER_INT);
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$mnemonico = filter_input(INPUT_POST, 'mnemonico', FILTER_SANITIZE_STRING);
$cnp = filter_input(INPUT_POST, 'cnpj', FILTER_SANITIZE_STRING);
$endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
$pais = filter_input(INPUT_POST, 'pais', FILTER_SANITIZE_STRING);
$estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);
$cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING);


var_dump($id_prestador);
require_once 'database_gac.php';


if ($cnp) {

    if (isset($_POST['submitted'])) {
        $erro = array();



        if (empty($nome)) {
            $erro[] = 'Selecionar o Prestador do Serviço.';
        } else if (strlen($nome) < 4) {
            $erro[] = "Preencha a Razão com no mínimo 4 caracteres.";
        } else {
            $nome = mysqli_real_escape_string($conection, trim($nome));
        }

        include 'validar_cnpj.php';

        if (empty($cnp)) {
            $erro[] = 'Informar o CNPJ.';
        } else if (valida_cnpj($cnp)) {
            $cnpj = $cnp;
        } else {

            $erro[] = ' CNPJ Inválido.';
        }

        if (empty($endereco)) {
            $erro[] = 'Informar o Endereço.';
        } else if (strlen($endereco) < 8) {
            $erro[] = "Preencha o Endereço com no mínimo 8 caracteres.";
        } else {
            $end = mysqli_real_escape_string($conection, trim($endereco));
        }

        if (empty($pais)) {
            $erro[] = 'Selecionar o País.';
        }

        if (empty($estado)) {
            $erro[] = 'Selecionar o Estado.';
        }

        if (empty($cep)) {
            $erro[] = 'Informar o Cep.';
        } else if (!preg_match('/^[0-9]{5,5}([- ]?[0-9]{3,3})?$/', $cep)) {
            $erro[] = "Digite um cep válido";
        } else {
            $cep = mysqli_real_escape_string($conection, trim($cep));
        }

        if (empty($mnemonico)) {
            $erro[] = 'Designe um mnemônico';
        } else if (is_numeric($mnemonico)) {
            $erro[] = 'Mnemônico inválido';
        } else {
            $mnemonico = mysqli_real_escape_string($conection, trim($mnemonico));
        }



        if (empty($erro)) {


            if ($_REQUEST['action'] == 'update') {

                $q1 = "UPDATE prestador  SET  nome='$nome', mnemonico='$mnemonico', cnpj='$cnpj', endereco='$endereco',
               pais='$pais', estado='$estado', cep='$cep' WHERE id_prestador='$id_prestador'";
                $r1 = mysqli_query($conection, $q1);

                

                if ($q1) {
                    $_SESSION['msg40'] = "<p class='alert alert-secondary' style='color:green;'> Registro atualizado com sucesso </p>";
                   header("Location: lista_entidades.php?id_prest=$id_prestador&action=update");
                   
                } else {
                    $_SESSION['msg40'] = "<p class='alert alert-danger' style='color:green;'> O registro não foi atualizado </p>";
                    header("Location: lista_entidades.php?id_prest=$id_prestador&action=update");
                }
            }

            if ($_REQUEST['action'] == 'salva') {
                
               
                

                $q = "SELECT cnpj FROM prestador WHERE cnpj = '$cnp'";
                $r = mysqli_query($conection, $q);
                $num = mysqli_num_rows($r);

                if ($num == 0) {

                    $q1 = "INSERT INTO prestador (nome,mnemonico,cnpj,endereco,pais,estado,cep ) VALUES ('$nome','$mnemonico','$cnp','$end', '$pais', '$estado', '$cep' )";
                    $r1 = mysqli_query($conection, $q1);
                 
                }
                

                $_SESSION['msg40'] = "<p class='alert alert-success ' >Registro cadastrado com Sucesso</p>";
                  header("Location: lista_entidades.php");
            }
        } else {
            foreach ($erro as $mg) {

                $_SESSION['msg40'] = "<p class='alert alert-danger' style='color:red;'>$mg</p>";
                header("Location: lista_entidades.php?id_prest=$id_prestador&action=update");
            }
        }
    }
} else {

    $_SESSION['msg40'] = "<p class='alert alert-danger' style='color:red;'>Preencha os registros</p>";
    header("Location: lista_entidades.php?id_prest=$id_prestador");
}




    