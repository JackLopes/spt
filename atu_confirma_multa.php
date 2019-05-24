<?php

session_start();

include_once 'database_gac.php';

$id_multa = filter_input(INPUT_POST, 'id_multa', FILTER_SANITIZE_NUMBER_INT);
$id_histmulta = filter_input(INPUT_POST, 'id_histmulta', FILTER_SANITIZE_NUMBER_INT);
$id_contrato = filter_input(INPUT_POST, 'id_contrato', FILTER_SANITIZE_NUMBER_INT);
$id_descumpri = filter_input(INPUT_POST, 'id_descumpri', FILTER_SANITIZE_NUMBER_INT);
$id_itens = filter_input(INPUT_POST, 'id_itens', FILTER_SANITIZE_NUMBER_INT);
$id_tipo = filter_input(INPUT_POST, 'id_tipo', FILTER_SANITIZE_NUMBER_INT);
$status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);




if (isset( $_POST['id_colaborado'])) {
   $id_colaborador = $_POST['id_colaborado'];
   
   $id_colaborador = implode(",", $id_colaborador);
}


$categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_NUMBER_INT);
$valor_multa_aplicado = floatval(filter_input(INPUT_POST, 'valor_multa_aplicado', FILTER_SANITIZE_STRING));
$valor_multa_definitivo = floatval(filter_input(INPUT_POST, 'valor_multa_definitivo', FILTER_SANITIZE_STRING));
$valor_multa = floatval(filter_input(INPUT_POST, 'valor_multa', FILTER_SANITIZE_STRING));
$total_acumulado = floatval(filter_input(INPUT_POST, 'total_acumulado', FILTER_SANITIZE_STRING));
$siscor = filter_input(INPUT_POST, 'siscor', FILTER_SANITIZE_STRING);
$observacao = filter_input(INPUT_POST, 'observacao', FILTER_SANITIZE_STRING);

$tipo_infracao = filter_input(INPUT_POST, 'tipo_infracao', FILTER_SANITIZE_NUMBER_INT);
$siscor_advert_infra = filter_input(INPUT_POST, 'siscor_advert_infra', FILTER_SANITIZE_STRING);
$ocorrencia = filter_input(INPUT_POST, 'ocorrencia', FILTER_SANITIZE_STRING);

$clausula = filter_input(INPUT_POST, 'clausula', FILTER_SANITIZE_STRING);
$motivacao = filter_input(INPUT_POST, 'motivacao', FILTER_SANITIZE_STRING);
$referencia = filter_input(INPUT_POST, 'referencia', FILTER_SANITIZE_STRING);
$det_processo = filter_input(INPUT_POST, 'det_processo', FILTER_SANITIZE_STRING);




require_once './Funcoes/calculo_multas.php';


require_once 'valida_permissao.php';

$permissa = (int) $permissa;


if (!empty($id_contrato)) {

    $sq3 = "SELECT percent_atrasoEntrega, percent_naoObjeto, percent_descumprimento,valor_Contratado,id_prestador  FROM contrato WHERE  id_contrato = '$id_contrato' ";
    $resultado = mysqli_query($conection, $sq3)or die('Não foi possivel conectar ao MySQL');
    while ($registro = mysqli_fetch_array($resultado)) {

        $percent_atrasoEntrega = $registro['percent_atrasoEntrega'];
        $percent_naoObjeto = $registro['percent_naoObjeto'];
        $percent_descumprimento = $registro['percent_descumprimento'];
        $valor_Contratado = $registro['valor_Contratado'];
        $id_prestador = $registro['id_prestador'];
    }

    $sql3 = "SELECT * FROM prestador WHERE id_prestador = $id_prestador";
    $resultado1 = mysqli_query($conection, $sql3)or die('Não foi possivel conectar ao MySQL');
    while ($registro1 = mysqli_fetch_array($resultado1)) {
        $nom = $registro1['nome'];
    }
    
                              
    
}



if (( $permissa < 4) || $permissa == '2') {
//Se action vier do formulario de atrasoMultasItens
    if ($_REQUEST['action'] == 'atrasoMultasItens') {

        $q = "SELECT id_multa FROM soma_atraso_item WHERE id_multa = '$id_multa' ";
        $r = mysqli_query($conection, $q);
        $num = mysqli_num_rows($r);

        if ($num == 0) {

            if ($status == 1) {

                if ($total_aplicado < $valor_limitacao_pacial) {

                    $q1 = "INSERT INTO  soma_atraso_item ( id_contrato, id_multa, categoria,valor_multa, status ) VALUES "
                            . "('$id_contrato', '$id_multa','$categoria', '$valor_multa', '$status' )";
                    $r1 = mysqli_query($conection, $q1);

                    $result1 = "UPDATE  multa SET  status='$status' WHERE  id_multa='$id_multa'";
                    $resultado1 = mysqli_query($conection, $result1);
                } else {
                    $result1 = "UPDATE  multa SET  status='$status' WHERE  id_multa='$id_multa'";
                    $resultado1 = mysqli_query($conection, $result1);
                }
            }
        }

        if ($status == 2) {

            $sql5 = "DELETE FROM soma_atraso_item  WHERE id_multa='$id_multa'";
            $resultado_pagamento = mysqli_query($conection, $sql5);

            $result1 = "UPDATE  multa SET  status='$status' WHERE  id_multa='$id_multa'";
            $resultado1 = mysqli_query($conection, $result1);
        }

        //  Atualiza a tabela multa


        header("Location:atrasoMultasItens.php?id=$id_contrato&id_itens=$id_itens&id_tipo=$id_tipo");
    }

    //Corretivas descruprimento SLA
    else if ($_REQUEST['action'] == 'corretivaMultas') {

        $q = "SELECT id_multa FROM soma_atraso_item WHERE id_multa = '$id_multa' ";
        $r = mysqli_query($conection, $q);
        $num = mysqli_num_rows($r);


        if ($num == 0) {

            if ($status == 1) {



                $q1 = "INSERT INTO  soma_atraso_item ( id_contrato, id_multa, categoria,valor_multa, status ) VALUES "
                        . "('$id_contrato', '$id_multa','$categoria', '$valor_multa', '$status' )";
                $r1 = mysqli_query($conection, $q1);



                $result1 = "UPDATE  multa SET  status='$status' WHERE  id_multa='$id_multa'";
                $resultado1 = mysqli_query($conection, $result1);
                var_dump($resultado1, 'status:' . $status);
            }
        }

        if ($status == 2) {


            $sql5 = "DELETE FROM soma_atraso_item  WHERE id_multa='$id_multa'";
            $resultado_pagamento = mysqli_query($conection, $sql5);

            $result1 = "UPDATE  multa SET  status='$status' WHERE  id_multa='$id_multa'";
            $resultado1 = mysqli_query($conection, $result1);
        }

        header("Location:corretivaMultas.php?id=$id_contrato&id_tipo=$id_tipo");
    }
    
    if ($_REQUEST['action'] == 'slacorretiva_update') {

        var_dump($id_histmulta);


        $sql_sla = "UPDATE historico_multa SET siscor='$siscor',  observacao ='$observacao', valor_multa_definitivo='$valor_multa_definitivo', status='$status', clausula='$clausula'  WHERE  id_histmulta ='$id_histmulta' ";
        $result1 = mysqli_query($conection, $sql_sla)or die(mysqli_error($conection));
      
        if ($result1) {
            $_SESSION['msg23'] = "<p style='color:green;'> Registro atualizado com sucessoss </p>";

    header("Location:corretivaMultas.php?id=$id_contrato");
      exit();
        } else {
            $_SESSION['msg23'] = "<p style='color:red;'> Registro não foi  atualizado </p>";
            header("Location:corretivaMultas.php?id=$id_contrato");
        }
    }
    
    
    

    if ($_REQUEST['action'] == 'inclusaoMulta') {

        if ($categoria == 1) {

          

            if ($total_aplicado_itens == $valor_limitacao_pacial) {
                $valor_multa_aplicado = 0;
            }

            if ($valor_multa_aplicado > 0) {

                $q1 = "INSERT INTO historico_multa ( id_contrato, valor_multa_aplicado, observacao,categoria, total_acumulado) VALUES "
                        . "('$id_contrato', '$valor_multa_aplicado','$observacao','$categoria', '$total_acumulado')";
                $r1 = mysqli_query($conection, $q1);
                

                $mult1 = "UPDATE  multa SET  status='3'  WHERE  categoria='2' AND status ='1' AND id_contrato = '$id_contrato' ";
                $result1 = mysqli_query($conection, $mult1)or die('Não foi possivel conectar ao MySQL');

                //Zerar o mostrador do previsto

                $mult1 = "UPDATE  soma_atraso_item SET  status='3'  WHERE  categoria='1' AND status ='1' AND id_contrato = '$id_contrato' ";
                $result1 = mysqli_query($conection, $mult1)or die('Não foi possivel conectar ao MySQL');
            } else {

                $msg = "<p style='color:red;'> Não é  será possivel fazer o lançamento , pois  o valor do  limite Contratual já foi alcançado </p>";
            }

            if ($r1) {
                $_SESSION['msg23'] = $usu . "<p style='color:green;'> Registro atualizado com sucessoss </p>";

                header("Location:atrasoMultasItens.php?id=$id_contrato&id_itens=$id_itens&id_tipo=$id_tipo");
            } else {
                if (!empty($msg)) {

                    $_SESSION['msg23'] = $msg;
                } else {
                    $_SESSION['msg23'] = "<p style='color:red;'> Registro não foi  cadastrados </p>";
                }

                header("Location:atrasoMultasItens.php?id=$id_contrato&id_itens=$id_itens&id_tipo=$id_tipo");
            }
        } else if ($categoria == 5) {
           
            
            require './Funcoes/clausula.php';
            
     
      
     

            if ($total_aplicado_corretiva == $valor_limitacao_total) {

                $valor_multa_aplicado = 0;
            }

            if ($valor_multa_aplicado > 0) {





                $q1 = "INSERT INTO historico_multa ( id_contrato, valor_multa_aplicado, observacao,categoria, total_acumulado, id_multas, id_colaborador, clausula) VALUES "
                        . "('$id_contrato', '$valor_multa_aplicado','$observacao','$categoria', '$total_acumulado', '$id_multaString', '$id_colaborador', '$clausula')";
                $r1 = mysqli_query($conection, $q1);

  if($r1){

                $mult1 = "UPDATE  multa SET  status='3'  WHERE  categoria='5' AND status ='1' AND id_contrato = '$id_contrato' ";
                $result1 = mysqli_query($conection, $mult1)or die('Não foi possivel conectar ao MySQL');

                //Zerar o mostrador do previsto

                $mult1 = "UPDATE  soma_atraso_item SET  status='3'  WHERE  categoria='5' AND status ='1' AND id_contrato = '$id_contrato' ";
  $result1 = mysqli_query($conection, $mult1)or die('Não foi possivel conectar ao MySQL');}
            } else {

                $msg = "<p style='color:red;'> Não é possivel fazer mais lançamentos, pois limite Contratual já foi alcançado. </p>";
            }


            if ($r1) {
                $_SESSION['msg23'] = $usu . "<p style='color:green;'> Registro atualizado com sucessoss </p>";

                header("Location:corretivaMultas.php?id=$id_contrato&id_itens=$id_itens&id_tipo=$id_tipo");
            } else {
                if ($valor_multa_aplicado > 0) {

                    $_SESSION['msg23'] = "<p style='color:red;'> Registro não foi  cadastrado </p>";
                } else {
                    $_SESSION['msg23'] = $msg;
                }

                header("Location:corretivaMultas.php?id=$id_contrato&id_itens=$id_itens&id_tipo=$id_tipo");
            }
        }
    } else if ($_REQUEST['action'] == 'descumprimento_update') {






        $categoria = 6;


        $mult1 = "UPDATE  historico_multa SET  clausula='$clausula', motivacao='$motivacao', referencia='$referencia',
                       status='$status', observacao='$det_processo', valor_multa_aplicado='$valor_multa', siscor='$siscor'  WHERE  id_histmulta = '$id_histmulta' ";
        $result1 = mysqli_query($conection, $mult1)or die('Não foi possivel conectar ao MySQL');

        if ($result1) {
            $_SESSION['msg23'] = "<p style='color:green;'> Registro atualizado com sucessoss </p>";

            header("Location:atrasoMultas.php?id=$id_contrato");
        } else {
            $_SESSION['msg23'] = "<p style='color:red;'> Registro não foi  cadastrado </p>";
            header("Location:atrasoMultas.php?id=$id_contrato");
        }
    }



    //  Atualiza a tabela multa
    else if ($_REQUEST['action'] == 'descumprimento') {

        $referencia = floatval($referencia);
        $taxa = floatval($percent_descumprimento / 100);
        $valor_multa = $referencia * $taxa;




        if (!empty($motivacao) and ! empty($referencia)) {

            $status = 1;

            $categoria = 6;

            require_once './Funcoes/clausula.php';

            $q1 = "INSERT INTO  descump_clausula ( id_contrato, clausula, motivacao,  referencia, status, valor_multa, categoria,id_colaborador ) VALUES "
                    . "('$id_contrato', '$clausula', '$motivacao',  '$referencia', '$status', '$valor_multa', '$categoria','$id_colaborador' )";

            $r1 = mysqli_query($conection, $q1);
            
              
            $q2 = "INSERT INTO  historico_multa ( id_contrato, valor_multa_aplicado,categoria, status, id_colaborador, clausula ,referencia, motivacao ) VALUES "
                        . "('$id_contrato', '$valor_multa','$categoria', '$status','$id_colaborador', '$clausula','$referencia', '$motivacao' )";

            $r2 = mysqli_query($conection, $q2);
              
            
            

            if ($r1) {
                $_SESSION['msg23'] = "<p style='color:green;'> Registro atualizado com sucessoss </p>";

                header("Location:atrasoMultas.php?id=$id_contrato");
            } else {





                $_SESSION['msg23'] = "<p style='color:red;'> Registro não foi  cadastrado </p>";
                header("Location:atrasoMultas.php?id=$id_contrato");
            }
        } else {

            if (empty($clausula) or empty($motivacao) or empty($referencia)) {
                $_SESSION['msg23'] = "<p style='color:green;'>Preencha todos  os campos</p>";

                header("Location:atrasoMultas.php?id=$id_contrato");
            }
        }



        //  Atualiza a tabela multa
    } else if ($_REQUEST['action'] == 'inclusaoAdvertencia') {


        $q = "SELECT siscor FROM historico_multa WHERE id_contrato='$id_contrato' AND  siscor = '$siscor'";
        $r = mysqli_query($conection, $q);
        $num = mysqli_num_rows($r);

        if ($num == 0) {

            if (!empty($categoria)  and ! empty($observacao)) {

                $status = 2;
            
                require_once './Funcoes/clausula.php';

                $q1 = "INSERT INTO  historico_multa ( id_contrato, siscor,observacao,  categoria, status, id_colaborador, clausula) VALUES "
                        . "('$id_contrato','$siscor' , '$observacao','$categoria', '$status', '$id_colaborador', '$clausula' )";

                $r1 = mysqli_query($conection, $q1);

                if ($r1) {
                    $_SESSION['msg23'] = "<p style='color:green;'> Registro atualizado com sucessoss </p>";

                    header("Location:advertencia_supencao.php?id=$id_contrato");
                } else {





                    $_SESSION['msg23'] = "<p style='color:red;'> Registro não foi  cadastrado </p>";
                    header("Location:advertencia_supencao.php?id=$id_contrato");
                }
            } else {

                if (empty($categoria) or empty($observacao) ) {
                    $_SESSION['msg23'] = "<p style='color:green;'>Preencha todos  os campos</p>";

                    header("Location:advertencia_supencao.php?id=$id_contrato");
                }
            }



            //  Atualiza a tabela multa
        } else {

                    $_SESSION['msg23'] = "<p style='color:green;'> Registro já foi cadastrado </p>";

                    header("Location:advertencia_supencao.php?id=$id_contrato");
                }
    }
}