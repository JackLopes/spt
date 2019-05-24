<?php

session_start();

$page_title = 'Corretiva';




$id_preventiva = filter_input(INPUT_POST, 'id_preventiva', FILTER_SANITIZE_NUMBER_INT);
$id_tipo = filter_input(INPUT_POST, 'id_tipo', FILTER_SANITIZE_NUMBER_INT);
$n_chamado = filter_input(INPUT_POST, 'n_chamado', FILTER_SANITIZE_STRING);
$siscor = filter_input(INPUT_POST, 'siscor', FILTER_SANITIZE_STRING);
$obs = filter_input(INPUT_POST, 'obs', FILTER_SANITIZE_STRING);
$d_limite = filter_input(INPUT_POST, 'd_limite', FILTER_SANITIZE_STRING);


$ex1 = explode("-", $d_limite);
$d_limite = $ex1[1];
$d_limite = (int) $d_limite;


require_once 'database_gac.php';




if (isset($_POST['submitted'])) {

    $erro = array();

    $query = "SELECT tip.* , loc.id_contrato, cont.tip_chamado, 
				cont.rg, loc.lugar_regional				
				FROM tipo AS tip
				INNER JOIN local AS loc ON  loc.id_local = tip.id_local
				INNER JOIN  contrato AS cont ON  cont.id_contrato = loc.id_contrato
				WHERE id_tipo = '$id_tipo'";

    $resultado = mysqli_query($conection, $query)or die('Não foi possivel conectar ao MySQL');
    while ($registro = mysqli_fetch_array($resultado)) {

        $ct = $registro['id_contrato'];
        $rg = $registro['rg'];
        $regional = $registro['lugar_regional'];
    }

   
    $i=0;
  
    $patrimo = array();
    
    $query1 = "SELECT * FROM itens Where id_tipo ='$id_tipo'";
    $resultado1 = mysqli_query($conection, $query1)or die('Não foi possivel conectar ao MySQL');
    while ($registro2 = mysqli_fetch_array($resultado1)) {
        $patrimonio[] = (string) $registro2['patrimonio'];
        $descricao = $registro2['descricao'];       
        $patri = implode(" - ", $patrimonio);
        $patrim[$i]=$registro2['patrimonio'];
        $ativo[$i] = $registro2['ativo'];
        
        var_dump($ativo[$i] . '<br>');
         if( $ativo[$i] != 1 ){
        
         array_push($patrimo, $patrim[$i]);
    }
         $patrimon = implode(" - ", $patrimo);

        $i++; 
        
       // print $comma_separated; // lastname,email,phone
    }


    
   


   

    if (empty($n_chamado)) {
        $erro[] = 'Digite o número do chamado ou informe se não houver';
    } else {
        $n_chamado = mysqli_real_escape_string($conection, trim($n_chamado));
    }


   /* if (isset($d_limite)) {

        switch ($d_limite) {


            case "Janeiro":
                $d_limite = 1;
                break;
            case "Fevereiro":
                $d_limite = 2;
                break;
            case "Março":
                $d_limite = 3;
                break;
            case "Abril":
                $d_limite = 4;
                break;
            case "Maio":
                $d_limite = 5;
                break;
            case "Junho":
                $d_limite = 6;
                break;
            case "Julho":
                $d_limite = 7;
                break;
            case "Agosto":
                $d_limite = 8;
                break;
            case "Setembro":
                $d_limite = 9;
                break;
            case "Outubro":
                $d_limite = 10;
                break;
            case "Novembro":
                $d_limite = 11;
                break;
            case "Dezembro":
                $d_limite = 12;
                break;
        }
    }
*/



    if (empty($_POST['data_conclusao']) AND ! empty($n_chamado)) {
        $erro[] = 'Digite a data de execução ';
    } else {
        $d_execucao = mysqli_real_escape_string($conection, trim($_POST['data_conclusao']));

        if (!empty($d_execucao)) {
            $ex2 = explode("-", $d_execucao);
            $numero_mes2 = $ex2[1];
            $numero_mes2 = (int) $numero_mes2;
        }
    }
 
       

    if (!empty($d_limite)) {

        if ($d_limite >= $numero_mes2) {

            $previsao_multa = 'Nao';
            $aplicar_multa = 'Nao';
        } else if ($d_limite < $numero_mes2) {
            $previsao_multa = 'Sim';
            $aplicar_multa = 'Analisar';
        }
    }

    if (!empty($previsao_multa)) {
        $status = ok;
    }

   


        
        
         if (empty($erro)) {
 
		   
        $q1 = "UPDATE preventivas SET   item='$descricao', patrimonio='$patrimon', n_chamado='$n_chamado',  data_conclusao='$d_execucao',  obs='$obs',
               previsao_multa='$previsao_multa', aplicacao_multa='$aplicar_multa', id_contrato='$ct', regional='$regional', status='$status', mes_ref= '$numero_mes2' WHERE id_preventiva='$id_preventiva'"; 
	$r1 = mysqli_query($conection, $q1);
        
        var_dump($r1);

        if($q1) {
                $_SESSION['msg8'] = "<p style='color:green;'> Registro atualizado com sucesso </p>";
                header("Location: cad_preventiva.php?id_tipo=$id_tipo");
        }
        else{
                $_SESSION['msg8'] = "<p style='color:green;'> Registro não foi atualizado </p>";
                   header("Location: cad_preventiva.php?id_tipo=$id_tipo");
        }
          } else {
                  foreach ($erro as $mg){

                  $_SESSION['msg8'] = "<p style='color:red;'>$mg</p>";
                    header("Location: cad_preventiva.php?id_tipo=$id_tipo");

}}}?>

