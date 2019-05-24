<?php

session_start();

include_once 'database_gac.php';



$id_tipo = filter_input(INPUT_POST, 'id_tipo', FILTER_SANITIZE_NUMBER_INT);
$id_contrato = filter_input(INPUT_POST, 'id_contrato', FILTER_SANITIZE_NUMBER_INT);
$descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
$prazo_entrega = filter_input(INPUT_POST, 'prazo_entrega', FILTER_SANITIZE_STRING);
$tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_STRING);
$patrimonio = filter_input(INPUT_POST, 'patrimonio', FILTER_SANITIZE_STRING);
$serie = filter_input(INPUT_POST, 'serie', FILTER_SANITIZE_STRING);
$valor_unitario = filter_input(INPUT_POST, 'valor_unitario', FILTER_SANITIZE_STRING);
$observacao = filter_input(INPUT_POST, 'observacao', FILTER_SANITIZE_STRING);
$status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
$tipos = filter_input(INPUT_POST, 'tipos', FILTER_SANITIZE_STRING);
$id_resp = filter_input(INPUT_POST, 'id_resp', FILTER_SANITIZE_NUMBER_INT);

$valor_unitario = floatval($valor_unitario);

var_dump($id_contrato);




if (($matricula === $mat && $permissa < 4) || $permissa == '2') {


    if ($descricao != "" AND $valor_unitario != "") {


       

            $q1 = "SELECT * FROM  responsaveis WHERE id_resp = '$id_resp' ";
            $r1 = mysqli_query($conection, $q1);
            while ($row = mysqli_fetch_assoc($r1)) {

                $responsavel = $row ['nome'];
                $area = $row ['area'];
            }


            if ($tipos == 'Software') {
                $patrimonio = 'N/A';
                $serie = 'N/A';
            }



            $result = "INSERT INTO itens ( id_tipo, descricao,responsavel, area, patrimonio, serie,  valor_unitario, observacao, status  ) "
                    . "VALUES  ('$id_tipo', '$descricao','$responsavel','$area','$patrimonio', '$serie',  '$valor_unitario', '$observacao', '$status'  ) ";
            $resultado = mysqli_query($conection, $result);

            $id_ultimo = mysqli_insert_id($conection);

            var_dump($id_ultimo);

            //insere dados na tabela em caso de aquisição, logo sera possivel calcular possiveis atrasos

            if ($tipo == 'AQUISIÇÃO') {

   
                $sql5 = "UPDATE itens SET id_contrato='$id_contrato',prazo_entrega = '$prazo_entrega' WHERE id_itens = '$id_ultimo'";

                $r5 = mysqli_query($conection, $sql5);
            }
               

                if ($id_ultimo) {
                    $_SESSION['msg23'] = $usu . "<p style='color:green;'> Registro cadastrado com sucesso </p>";

                    header("Location:cad_itens.php?id_tipo=$id_tipo");
                } else {
                    $_SESSION['msg23'] = "<p style='color:red;'> Registro não foi  cadastrado  </p>";
                    header("Location:cad_itens.php?id_tipo=$id_tipo");
                }
            
        } else {

            $_SESSION['msg23'] = "<p style='color:red;'> Preencha a descrição e o valor unitário do item</p>";
            header("Location:cad_itens.php?id_tipo=$id_tipo");
        }
    } else {
        $_SESSION['msg23'] = "<span style='color:red;'> Você não tem permissão para incluir registro</span>";
        header("Location:cad_itens.php?id_tipo=$id_tipo");
    }    