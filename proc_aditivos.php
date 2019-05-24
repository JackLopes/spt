<?php

session_start();

$permissa = (int) $_SESSION['permissao'];

require_once 'Funcoes/limpa_string.php';
require_once 'database_gac.php';


$id_contrato = filter_input(INPUT_POST, 'id_contrato', FILTER_SANITIZE_NUMBER_INT);
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_NUMBER_INT);
$id_aditivo = filter_input(INPUT_POST, 'id_aditivo', FILTER_SANITIZE_NUMBER_INT);
$numero_aditivo = filter_input(INPUT_POST, 'numero_aditivo', FILTER_SANITIZE_STRING);
$valor_acrescimo = filter_input(INPUT_POST, 'valor_acrescimo', FILTER_SANITIZE_STRING);
$valor_supressao = filter_input(INPUT_POST, 'valor_supressao', FILTER_SANITIZE_STRING);
$inicio_vigencia_aditivio = filter_input(INPUT_POST, 'inicio_vigencia_aditivio', FILTER_SANITIZE_STRING);
$fim_vigencia_aditivo = filter_input(INPUT_POST, 'fim_vigencia_aditivo', FILTER_SANITIZE_STRING);



$dados5 = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$_SESSION['dados5'] = $dados5;


if ($permissa < 4) {

    


        if ($_REQUEST['action']== 'save') {


            $q = "SELECT * FROM aditivos WHERE numero_aditivo= '$numero_aditivo'";
            $r = mysqli_query($conection, $q);
            $num = mysqli_num_rows($r);

            if ($num == 0) {

                if (empty($id_contrato)) {
                    $erro[] = 'Há problemas com a identificação do contrato';
                } else if (is_numeric($id_contrato)) {
                    $id_contrato = mysqli_real_escape_string($conection, trim($id_contrato));
                } else {
                    $erro[] = 'Há problemas com a identificação do contrato';
                }


                if (empty($numero_aditivo)) {
                    $erro[] = 'Insira o numero do aditivo.';
                } else {
                    $numero_aditivo = mysqli_real_escape_string($conection, trim($numero_aditivo));
                }


                if (empty($erro)) {

                    $q = "INSERT INTO aditivos (id_contrato, numero_aditivo) VALUES 
	('$id_contrato', '$numero_aditivo ')";

                    $r = mysqli_query($conection, $q)or die(mysqli_error($conection));

                    $id_aditivo = mysqli_insert_id($conection);

                    if ($r) {



                        $_SESSION['msg43'] = "<p style='color:green;'> Selecione o Tipo de Lançamento </p>";
                        header("Location:cad_aditivos.php?id=$id_contrato&id_aditivo=$id_aditivo&numero_aditivo=$numero_aditivo");
                    } else {
                        $_SESSION['msg43'] = "<p style='color:red;'> Algo deu errado!</p>";
                        header("Location:cad_aditivos.php?id=$id_contrato");
                    }
                } else {

                    foreach ($erro as $mg)
                        $_SESSION['msg43'] = "<div class='alert alert-danger' role='alert'>- $mg<br>\n</div>";
                    header("Location:cad_aditivos.php?id=$id_contrato");
                }
            } else {

                $query = "SELECT * FROM aditivos WHERE numero_aditivo = '$numero_aditivo' ";
                $result = mysqli_query($conection, $query);
                While ($row = mysqli_fetch_assoc($result)) {

                    $id_aditivo = $row['id_aditivo'];
                }

                $_SESSION['msg43'] = "<p style='color:green;'> Selecione o Tipo de Lançamento </p>";

                header("Location:cad_aditivos.php?id=$id_contrato&id_aditivo=$id_aditivo&numero_aditivo=$numero_aditivo");
            }
        }
          
     
        
        if ($_REQUEST['action']== 'update') {
                
                
   var_dump($numero_aditivo);
                $query = "SELECT * FROM aditivos WHERE numero_aditivo = '$numero_aditivo' ";
                $result = mysqli_query($conection, $query);
                While ($row = mysqli_fetch_assoc($result)) {

                    $valor_acrescimo1 = $row['valor_acrescimo'];
                    $valor_supressao1 = $row['valor_supressao'];
                    $inicio_vigencia_aditivio1 = $row['inicio_vigencia_aditivio'];
                    $fim_vigencia_aditivo1 = $row['fim_vigencia_aditivo'];
                    $id_aditivo = $row['id_aditivo'];

                    
                    
                    if (empty($valor_acrescimo)) {
                        $valor_acrescimo = $valor_acrescimo1;
                    }

                    if (empty($valor_supressao)) {
                        $valor_supressao = $valor_supressao1;
                    }

                    if (empty($inicio_vigencia_aditivio)) {
                        $inicio_vigencia_aditivio = $inicio_vigencia_aditivio1;
                    }

                    if (empty($fim_vigencia_aditivo)) {
                        $fim_vigencia_aditivo = $fim_vigencia_aditivo1;
                    }

 
                    $atualiza = "UPDATE aditivos SET valor_acrescimo='$valor_acrescimo', valor_supressao='$valor_supressao', inicio_vigencia_aditivio='$inicio_vigencia_aditivio', fim_vigencia_aditivo = '$fim_vigencia_aditivo'
                      WHERE id_aditivo = '$id_aditivo'";
                    $resp = mysqli_query($conection, $atualiza);
                    var_dump($resp);
                    
                    
                }
                if ($resp) {

                    $_SESSION['msg43'] = "<p style='color:green;'> Informe o RG Para Novo Lançamento</p>";
                    header("Location:cad_aditivos.php?id=$id_contrato&numero_aditivo=$numero_aditivo");
                    
                    unset($_SESSION['dados5']);
                    
                } else {
                    $_SESSION['msg43'] = "<p style='color:red;'> Algo deu errado!</p>";
                    header("Location:cad_aditivos.php?id=$id_contrato");
                }
            }
        
    
} else {

    $_SESSION['msg43'] = "<p style='color:red;'> Você não tem permissão para cadastrar registro</p>";
    header("Location:cad_aditivos.php?id=$id_contrato");
}



    