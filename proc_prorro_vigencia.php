<?php

session_start();

$permissa = (int) $_SESSION['permissao'];

require_once 'Funcoes/limpa_string.php';
require_once 'database_gac.php';

$id_contrato = filter_input(INPUT_POST, 'id_contrato', FILTER_SANITIZE_NUMBER_INT);
$id_aditivo = filter_input(INPUT_POST, 'id_aditivo', FILTER_SANITIZE_NUMBER_INT);
$inicio_vigencia_aditivo = filter_input(INPUT_POST, 'inicio_vigencia_aditivo', FILTER_SANITIZE_STRING);
$fim_vigencia_aditivo = filter_input(INPUT_POST, 'fim_vigencia_aditivo', FILTER_SANITIZE_STRING);
$rg_aditivo = filter_input(INPUT_POST, 'rg_aditivo', FILTER_SANITIZE_NUMBER_INT);


$dados7 = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$_SESSION['dados7'] = $dados6;



if ($permissa < 4) {
    

 $q = "SELECT rg_aditivo FROM qualificacao WHERE rg_aditivo = '$rg_aditivo' AND prorrogacao = '5'  ";
        $r = mysqli_query($conection, $q);
        $num = mysqli_num_rows($r);

        if ($num == 0) {

    if (!empty($id_contrato)) {
        $erro = array();

        if (empty($id_contrato)) {
            $erro[] = 'Há problemas com a identificação do contrato';
        } else if (is_numeric($id_contrato)) {
            $id_contrato = mysqli_real_escape_string($conection, trim($id_contrato));
        } else {
            $erro[] = 'Há problemas com a identificação do contrato';
        }


        if (empty($inicio_vigencia_aditivo)) {
            $erro[] = 'Insira o inicio da vigência.';
        } else {
            $inicio_vigencia_aditivo = mysqli_real_escape_string($conection, trim($inicio_vigencia_aditivo));
        }


        if (empty($fim_vigencia_aditivo)) {
            $erro[] = 'Insira o fim da vigência.';
        } else {
            $fim_vigencia_aditivo = mysqli_real_escape_string($conection, trim($fim_vigencia_aditivo));
        }

 if (empty($erro)) {
        
        $q = "SELECT id_qualificacao FROM qualificacao WHERE rg_aditivo = '$rg_aditivo'";
        $resultado = mysqli_query($conection, $q)or die('Não foi possivel conectar ao MySQL');
        while ($registro = mysqli_fetch_array($resultado)) {
      
           $id_qualificacao = $registro['id_qualificacao'];
           
                $qualifica = "UPDATE qualificacao SET inicio_vigencia_aditivo='$inicio_vigencia_aditivo', fim_vigencia_aditivo='$fim_vigencia_aditivo', prorrogacao = '5'  WHERE id_qualificacao = '$id_qualificacao'";
                $resp = mysqli_query($conection, $qualifica);
               
            }




            if ($q) {


                $_SESSION['msg43'] = "<p style='color:green;'> Aditivo cadastrado com sucesso ! </p>";
                header("Location:cad_aditivos.php?id=$id_contrato");
                 unset($_SESSION['dados5']);
            } else {
                $_SESSION['msg43'] = "<p style='color:red;'> O aditivo não foi cadastrado!</p>";
                header("Location:cad_aditivos.php?id=$id_contrato");
            }
        } else {

            foreach ($erro as $mg)
                $_SESSION['msg43'] = "<div class='alert alert-danger' role='alert'>- $mg<br>\n</div>";
            header("Location:cad_aditivos.php?id=$id_contrato");
        }
    }
 }else {

    $_SESSION['msg43'] = "<p style='color:red;'> O referido RG: $rg_aditivo já possui uma operação de prorrogação</p>";
    header("Location:cad_aditivos.php?id=$id_contrato");
     unset($_SESSION['dados5']);
     
      
        $result_quali = "DELETE FROM qualificacao  WHERE id_aditivo='$id_aditivo'";
        $resultado_quali = mysqli_query($conection, $result_quali);

        $result = "DELETE FROM aditivos  WHERE id_aditivo='$id_aditivo'";
        $resultado_aditivo = mysqli_query($conection, $result);
        
} 

        }else {

    $_SESSION['msg43'] = "<p style='color:red;'> Você não tem permissão para cadastrar registro</p>";
    header("Location:cad_aditivos.php?id=$id_contrato");
}
  

