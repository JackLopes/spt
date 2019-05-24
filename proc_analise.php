<?php

session_start();


if ($_SESSION['status'] != 'LOGADO') {
    header("Location: login.php");
}

$page_title = 'Corretiva';
 $permissa = $_SESSION['permissao'];


$id_relatorio = filter_input(INPUT_POST, 'id_relatorio', FILTER_SANITIZE_NUMBER_INT);
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$cpreventiva = filter_input(INPUT_POST, 'conclusao_preventiva', FILTER_SANITIZE_STRING);
$conclusao_corretiva = filter_input(INPUT_POST, 'conclusao_corretiva', FILTER_SANITIZE_STRING);
$acompanhado = filter_input(INPUT_POST, 'acompanhado', FILTER_SANITIZE_STRING);
$analizado = filter_input(INPUT_POST, 'analizado', FILTER_SANITIZE_STRING);
$mes = filter_input(INPUT_POST, 'mes', FILTER_SANITIZE_STRING);
$ano = filter_input(INPUT_POST, 'ano', FILTER_SANITIZE_STRING);
$prestador = filter_input(INPUT_POST, 'prestador', FILTER_SANITIZE_STRING);
$rg = filter_input(INPUT_POST, 'rg', FILTER_SANITIZE_STRING);

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$_SESSION['dados'] = $dados;




require_once 'database_gac.php';


      if ( $permissa < '4') {  


if (!empty($id_relatorio)&& !empty($conclusao_corretiva) ){


    $erro = array();


    if (!empty($conclusao_corretiva) && strlen($conclusao_corretiva) < 10) {
        $erro[] = "Preencha sua analise da corretiva  com no mínimo 10 caracteres.";
    } else {
        $conclusao_corretiva = mysqli_real_escape_string($conection, trim($conclusao_corretiva));
    }

    if (!empty($conclusao_preventiva) && strlen($conclusao_preventiva) < 10) {
        $erro[] = "Preencha sua analise da preventiva  com no mínimo 10 caracteres.";
    } else {
        $conclusao_preventiva = mysqli_real_escape_string($conection, trim($cpreventiva));
    }

    if (empty($erro)) {

        $q1 = "UPDATE reg_relatorio SET conclusao_preventiva='$conclusao_preventiva', conclusao_corretiva='$conclusao_corretiva', 
                acompanhado='$acompanhado', analizado='$analizado',  atualizacao='NOW()' WHERE id_relatorio='$id_relatorio'";

        $r = mysqli_query($conection, $q1);
        



        if ($r) {
            $_SESSION['msg8'] = "<p style='color:green;'> Atualização Efetuada com Sucesso !!! </p>";
           header("Location: analise_ans.php?id=$id&mes=$mes");
        } else {
            $_SESSION['msg8'] = "<p style='color:red;'> Não atualizado o registro </p>";
            header("Location: analise_ans.php?id=$id&mes=$mes&ano=$ano&$nom=");
        }
    } else {

        foreach ($erro as $mg)
            $_SESSION['msg8'] = "<p style='color:red;'> $mg </p>";
        header("Location: analise_ans.php?id=$id&mes=$mes");
    }
} else {
    $_SESSION['msg8'] = "<p style='color:red;'> Estando definido o mês e o ano , é necessario fazer a analise da corretiva, para inserir o registro. </p>";
    header("Location: analise_ans.php?id=$id&mes=$mes");
}
}
       else {
            
             $_SESSION['msg8'] = "<p style='color:red;'> Você não tem permissão para cadastrar registro</p>";
         header("Location: analise_ans.php?id=$id&mes=$mes");
       
       }
  