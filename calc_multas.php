<?php

session_start();

$page_title = 'Corretiva';
require_once 'database_gac.php';

$referencia = filter_input(INPUT_POST, 'referencia', FILTER_SANITIZE_STRING);
$periodo = filter_input(INPUT_POST, 'periodo', FILTER_SANITIZE_STRING);
$obs = filter_input(INPUT_POST, 'obs', FILTER_SANITIZE_STRING);
$valor_regional =filter_input(INPUT_POST, 'valor_regional', FILTER_SANITIZE_STRING);
$patrimonio = filter_input(INPUT_POST, 'patrimonio', FILTER_SANITIZE_STRING);
$id_contrato = filter_input(INPUT_POST, 'id_contrato', FILTER_SANITIZE_NUMBER_INT);
$id_corretiva = filter_input(INPUT_POST, 'id_corretiva', FILTER_SANITIZE_NUMBER_INT);


$valor_regional = floatval(str_replace(',', '.', $valor_regional));

var_dump($valor_regional);


if (!empty($id_contrato)) {

    $sq3 = "SELECT percent_atrasoEntrega, percent_naoObjeto, percent_descumprimento,valor_Contratado  FROM contrato WHERE  id_contrato = '$id_contrato' ";
    $resultado = mysqli_query($conection, $sq3)or die('Não foi possivel conectar ao MySQL');
    while ($registro = mysqli_fetch_array($resultado)) {

        $percent_atrasoEntrega = $registro['percent_atrasoEntrega'];
        $percent_naoObjeto = $registro['percent_naoObjeto'];
        $percent_descumprimento = $registro['percent_descumprimento'];
        $valor_Contratado = $registro['valor_Contratado'];
    }


    $query = "SELECT cont.* , loc.Id_contrato,tip.id_local,loc.id_local,it.id_tipo,tip.id_tipo,   it.descricao, it.serie, it.patrimonio, it.valor_unitario,
				 loc.lugar_regional				
				FROM contrato AS cont
				INNER JOIN local AS loc ON  loc.Id_contrato = cont.id_contrato
				INNER JOIN  tipo AS tip ON  tip.id_local = loc.id_local
				INNER JOIN  itens AS it ON  it.id_tipo = tip.id_tipo
				WHERE cont.id_contrato = '$id_contrato'AND it.patrimonio = '$patrimonio'";
    $resultado = mysqli_query($conection, $query)or die(mysqli_error($conection));
    while ($registro = mysqli_fetch_array($resultado)) {


        $valor_unitario = $registro['valor_unitario'];
    }

    if (!empty($_REQUEST['action'] == 'corr')) {

        $sql = "SELECT taxa, total, parametro_multa FROM multa WHERE id_corretiva = '$id_corretiva'";
        $result = mysqli_query($conection, $sql)or die('Não foi possivel conectar ao MySQL');
        while ($registro = mysqli_fetch_array($result)) {

            $taxa = $registro['taxa'];
            $total_horas_atraso = $registro['total'];
            $parametro = $registro['parametro_multa'];
        }

        switch ($parametro) {
            case 5:
               
                $referencia = ($valor_regional) * ($taxa / 100);
                $subtotal = $total_horas_atraso * $referencia;
                
                break;
            case 6:

              
                $referencia = ($valor_regional) * ($taxa / 100);
                $subtotal = $total_horas_atraso * $referencia;
                
                break;
        }

 var_dump($valor_regional);

        $q1 = "UPDATE multa SET  
            referencia = '$referencia', subtotal='$subtotal' WHERE id_corretiva='$id_corretiva'";

        $r1 = mysqli_query($conection, $q1);


        if ($q1) {

            $_SESSION['msg38'] = "<p style='color:green;'> Registro atualizado com sucesso </p>";
            header("Location: corretivaMultas.php?id=$id_contrato");
        } else {

            $_SESSION['msg38'] = "<p style='color:red;'> Registro não foi atualizado </p>";
            header("Location: corretivaMultas.php?id=$id_contrato");
        }
    } else if (!empty($_REQUEST['action'] == 'entrega')) {

        $referencia = floatval($referencia);
        $periodo = (int) $periodo;
        $taxa = floatval($percent_atrasoEntrega / 100);
        $subtotal = $referencia * $periodo * $taxa;
        $categoria = '1';




        $q1 = "INSERT INTO multa (id_contrato, referencia,periodo,categoria,subtotal,taxa,obs, status )VALUES 
            ('$id_contrato','$referencia','$periodo','$categoria','$subtotal','$taxa','$obs', '1')";

        $r1 = mysqli_query($conection, $q1)or die(mysqli_error($conection));

        if ($q1) {

            $_SESSION['msg38'] = "<p style='color:green;'> Registro atualizado com sucesso </p>";
            header("Location: atrasoMultas.php?id=$id_contrato");
        } else {

            $_SESSION['msg38'] = "<p style='color:red;'> Registro não foi atualizado </p>";
            header("Location: atrasoMultas.php?id=$id_contrato");
        }
    }
} 




