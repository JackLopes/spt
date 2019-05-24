<?php

session_start();
require_once 'database_gac.php';
require_once 'Funcoes/limpa_string.php';

$permissa = $_SESSION['permissao'];

$id_contrato = (int)filter_input(INPUT_POST, 'id_contrato', FILTER_SANITIZE_STRING);
$id_doc =(int)filter_input(INPUT_POST, 'id_doc', FILTER_SANITIZE_STRING);


$link = filter_input(INPUT_POST, 'link', FILTER_SANITIZE_URL);
$categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);
$status = (int) filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
$clausula = filter_input(INPUT_POST, 'clausula', FILTER_SANITIZE_STRING);
$responsa = filter_input(INPUT_POST, 'responsa', FILTER_SANITIZE_STRING);
$prazo = filter_input(INPUT_POST, 'prazo', FILTER_SANITIZE_STRING);
$prevista = filter_input(INPUT_POST, 'prevista', FILTER_SANITIZE_STRING);
$executada = filter_input(INPUT_POST, 'executada', FILTER_SANITIZE_STRING);
$observacao = filter_input(INPUT_POST, 'observacao', FILTER_SANITIZE_STRING);
$periodo = filter_input(INPUT_POST, 'periodo', FILTER_SANITIZE_STRING);
$regional = filter_input(INPUT_POST, 'regional', FILTER_SANITIZE_STRING);


$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$_SESSION['dados'] = $dados;




if (!empty($_REQUEST['action'] == 'salva')) {

    $erro = array();

    if (empty($categoria)) {
        $erro[] = 'Insira o Tipo de Documento ';
    } else {
        $categoria = limpa(mysqli_real_escape_string($conection, trim($categoria)));
    }


    if (empty($periodo)) {
        $erro[] = 'Insira o mês de referência ';
    } else {
        $periodo = limpa(mysqli_real_escape_string($conection, trim($periodo)));
    }

    if (empty($prevista)) {
        $erro[] = 'Insira a Data Prevista';
    } else {
        $prevista = limpa(mysqli_real_escape_string($conection, trim($prevista)));
    }


    $categoria = strtoupper(mysqli_real_escape_string($conection, trim($categoria)));


    if (empty($erro)) {


        $q1 = "INSERT INTO documentos (id_contrato,link, categoria, clausula, responsa,prazo,prevista,executada,observacao,status, periodo, regional) VALUES
               ('$id_contrato','$link','$categoria','$clausula','$responsa','$prazo', '$prevista', '$executada','$observacao','$status','$periodo','$regional')";
        $r1 = mysqli_query($conection, $q1);



        if ($r1) {
            $_SESSION['msg40'] = "<h3 class='alert alert-info' style='color:green;'> Tipo incluido com sucesso!!! </h3>";
            header("Location: previ.php?id=$id_contrato");
        } else {
            $_SESSION['msg40'] = "<h3 class='alert alert-danger' style='color:red;'> Tipo não foi incluido !!! </h3>";
            header("Location:  previ.php?id=$id_contrato");
        }
    } else {
        foreach ($erro as $mg) {

            $_SESSION['msg40'] = "<h3 class='alert alert-danger' style='color:red;'> $mg</h3>";
            header("Location:  previ.php?id=$id_contrato");
        }
    }
}


if (!empty($_REQUEST['action'] == 'update')) {

    $status = 2;

   


    if (empty($categoria)) {
        $erro[] = 'Insira o Tipo de Documento ';
    } else {
        $categoria = limpa(mysqli_real_escape_string($conection, trim($categoria)));
    }
    
    $categoria = strtoupper(mysqli_real_escape_string($conection, trim($categoria)));
 
 
    if (empty($link)) {
        $erro[] = 'Insira o Link da Autuação';
    } else {
        $link = limpa(mysqli_real_escape_string($conection, trim($link)));
    }

    if (empty($periodo)) {
        $erro[] = 'Insira o mês de referência ';
    } else {
        $periodo = limpa(mysqli_real_escape_string($conection, trim($periodo)));
    }


    if (empty($clausula)) {
        $erro[] = 'Insira a Cláusula Contratual';
    } else {
        $clausula = limpa(mysqli_real_escape_string($conection, trim($clausula)));
    }

    if (empty($responsa)) {
        $erro[] = 'Atribua a Responsabilidade';
    } else {
        $responsa = limpa(mysqli_real_escape_string($conection, trim($responsa)));
    }


    if (empty($prazo)) {
        $erro[] = 'Insira o Prazo Contratual';
    } else {
        $prazo = limpa(mysqli_real_escape_string($conection, trim($prazo)));
    }

    if (empty($prevista)) {
        $erro[] = 'Insira a Data Prevista';
    } else {
        $prevista = limpa(mysqli_real_escape_string($conection, trim($prevista)));
    }

    if (empty($erro)) {


        $q1 = "UPDATE documentos SET  id_contrato='$id_contrato',link='$link', categoria='$categoria', clausula='$clausula', responsa='$responsa',
               prazo='$prazo', prevista='$prevista', executada='$executada', observacao='$observacao',status='$status', periodo='$periodo', regional='$regional' WHERE id_doc='$id_doc'";
        $r1 = mysqli_query($conection, $q1);



        if ($r1) {
            $_SESSION['msg40'] = "<h3 class='alert alert-info' style='color:green;'> Tipo incluido com sucesso!!! </h3>";
            header("Location: previ.php?id=$id_contrato");
        } else {
            $_SESSION['msg40'] = "<h3 class='alert alert-danger' style='color:red;'> Tipo não foi incluido !!! </h3>";
            header("Location:  previ.php?id=$id_contrato");
        }
    } else {
        
       
        foreach ($erro as $mg) {

           
            $_SESSION['msg40'] = "<h3 class='alert alert-danger' style='color:red;'> $mg</h3>";
           header("Location:  previ.php?id=$id_contrato");
        }
    }
}
