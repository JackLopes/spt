<?php

session_start();
require_once 'database_gac.php';

function inverteData($data) {
    if (count(explode("/", $data)) > 1) {
        return implode("-", array_reverse(explode("/", $data)));
    } elseif (count(explode("-", $data)) > 1) {
        return implode("/", array_reverse(explode("-", $data)));
    }
}

$resto = filter_input(INPUT_POST, 'resto', FILTER_SANITIZE_NUMBER_INT);
$id_tipo = filter_input(INPUT_POST, 'id_tipo', FILTER_SANITIZE_NUMBER_INT);
$nParcelas = filter_input(INPUT_POST, 'parcela', FILTER_SANITIZE_NUMBER_INT);
$varlorTotal = filter_input(INPUT_POST, 'valor_total', FILTER_SANITIZE_STRING);

if (isset($_POST['data_inicio_per'])) {
    $data = $_POST['data_inicio_per'];
}


$nParcelas = (int) $nParcelas;
$varlorTotal = $varlorTotal;
$resto = $resto;
$data = inverteData($data);






if (isset($_POST['submitted']) and ! empty($nParcelas)) {

    require_once 'valida_permissao.php';



    if ($matricula === $mat AND $permissa < 4 or $permissa == '2') {

        $erro = array();

        if ($varlorTotal > $resto AND $resto > 0) {

            $erro[] = "Digite um valor menor que " . $resto;
        } else if ($resto < 0) {

            $erro[] = "Não é possivel adicionar mais parcelas, pois excederá o limite de valor contratado ";
        }

        if (empty($nParcelas)) {
            $erro[] = 'Insira o número de parcelas.';
        } else {
            $nParcelas = mysqli_real_escape_string($conection, trim($nParcelas));
        }

        if (empty($varlorTotal)) {
            $erro[] = 'Insira o valor disponivel para a regional.';
        } else {
            $varlorTotal = mysqli_real_escape_string($conection, trim($varlorTotal));
        }

        if (empty($data)) {
            $erro[] = 'Selecione a data.';
        } else {
            $data = mysqli_real_escape_string($conection, trim($data));
        }



        $query = "SELECT tip.* , loc.id_contrato, loc.sigla, cont.tip_chamado, 
				cont.rg, loc.lugar_regional, cont.valor_Contratado				
				FROM tipo AS tip
				INNER JOIN local AS loc ON  loc.id_local = tip.id_local
				INNER JOIN  contrato AS cont ON  cont.id_contrato = loc.id_contrato
				WHERE id_tipo = '$id_tipo'";

        $resultado = mysqli_query($conection, $query)or die('Não foi possivel conectar ao MySQL');
        while ($registro = mysqli_fetch_array($resultado)) {

            $val_contr = $registro['valor_Contratado'];
            $ct = $registro['id_contrato'];

            $sigla = $registro['sigla'];
            //include 'abreviacao.php';
        }


        $calculoParc = ($varlorTotal / $nParcelas);


        if ($varlorTotal > $val_contr) {
            $erro[] = 'Não é possivel lançar um valor maior que o contratado.';
        }
        if ($data != null) {
            $data = explode("/", $data);
            $dia = $data[0];
            $mes = $data[1];
            $ano = $data[2];
        } else {
            $dia = date("d");
            $mes = date("m");
            $ano = date("Y");
        }

        if ($nParcelas > 60) {
            $nParcelas = 62;
        }

        $ans = [];

        for ($x = 0; $x < $nParcelas; $x++) {

            $retorno = strtotime("+" . $x . " month", mktime(0, 0, 0, $mes, $dia, $ano));
            $dataParc = date('Y/m/d', $retorno) . '<br>';

            $dataParc = explode("/", $dataParc);
            $ano2 = $dataParc[0];
            $mes2 = $dataParc[1];
            $dia2 = $dataParc[2];

            $data_fim3 = array($ano2, $mes2, $dia2);
            $data_fim4 = implode("-", $data_fim3);
            $ultimo_dia = date("t", mktime(0, 0, 0, $mes2, '01', $ano)); // Mágica, plim!
            $ultimo_dia = (int) $ultimo_dia;
            $data_fim = array($ano2, $mes2, $ultimo_dia);
            $data_fim2 = implode("-", $data_fim);


            if (empty($erro)) {


                $result = "INSERT INTO pagamentos (id_tipo, nota_fiscal, valor_parcela, n_parcela,data_inicio_per, data_fim_per,
            aut_nota, medido, d_assinatura_dig, d_vencimento_pag, siscor, obser, id_contrato, regional, status  ) VALUES 
            ('$id_tipo', '', '$calculoParc', '$x','$data_fim4', '$data_fim2',
            '', '', '', '', '', '', '$ct', '$sigla','' )";
                $resultado = mysqli_query($conection, $result);

                $id_pag = mysqli_insert_id($conection);


           
                // $document[$x] = [$id_pag, [1,1], [2,1]];
                // $ans = serialize($document[$x]);

                for ($i = 1; $i < 3; $i++) {               

                    $query1 = "INSERT INTO documentos(id_pag,id_contrato,categoria,status) VALUES  ('$id_pag','$ct','$i','1')";
                    $resultado1 = mysqli_query($conection, $query1);

                    var_dump($resultado1);
                }


                if ($result) {
                    $_SESSION['msg28'] = "<p style='color:green;'> Registro cadastrado com sucesso </p>";
                   header("Location: cad_pag.php?id_tipo=$id_tipo");
                } else {
                    $_SESSION['msg28'] = "<p style='color:green;'> Registro Não cadastrado  </p>";
                    header("Location: cad_pag.php?id_tipo=$id_tipo");
                }
            } else {
                foreach ($erro as $mg) {

                    $_SESSION['msg28'] = "<p style='color:red;'>$mg</p>";
                    header("Location: cad_pag.php?id_tipo=$id_tipo");
                }
            }
        }
    } else {
        $_SESSION['msg28'] = "<span style='color:red;'> Você não tem permissão para incluir registro</span>";
        header("Location: cad_pag.php?id_tipo=$id_tipo");
    }
} else {
    $_SESSION['msg28'] = "<span style='color:red;'> Preencha os Campos</span>";
    header("Location: cad_pag.php?id_tipo=$id_tipo");
} 




    