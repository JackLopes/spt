
<?php

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

if (isset($_POST['rg'])) {
    $rg = $_POST['rg'];
}

if (isset($_POST['nom'])) {
    $nom = $_POST['nom'];
}

if (isset($_POST['mes'])) {
    $mes = $_POST['mes'];
}


if (isset($_POST['ano'])) {
$ano = (int) $_POST['ano'];}

$anomes= $ano."-".$mes."-30";

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$id_relatorio = filter_input(INPUT_POST, 'id_relatorio', FILTER_SANITIZE_NUMBER_INT);

if (isset($_POST['conclusao'])) {
    $conclusao = $_POST['conclusao'];
} else {
    $conclusao = 0;
}
if (isset($_POST['mar_resumo'])) {
    $mar_resumo = $_POST['mar_resumo'];
} else {
    $mar_resumo = 0;
}
if (isset($_POST['mar_preventiva'])) {
    $mar_preventiva = $_POST['mar_preventiva'];
} else {
    $mar_preventiva = 0;
}

require_once 'Funcoes/mascara_php.php';

$meses = array('', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
$me = @$meses[$mes];

function formata($total) {
    if ($total > 0) {
        echo (string) $total . ":00";
    } else {
        echo "00:00";
    }
}

function inverteData($data) {

    if (count(explode("/", $data)) > 1) {
        return implode("-", array_reverse(explode("/", $data)));
    } elseif (count(explode("-", $data)) > 1) {
        return implode("/", array_reverse(explode("-", $data)));
    }
}

$conection = mysqli_connect('localhost', 'root');
mysqli_select_db($conection, 'gac');




$sqlcorre7 ="SELECT * FROM preventivas WHERE id_contrato = '$id'  AND MONTH(data_conclusao)= '$mes'  AND YEAR(data_conclusao)= '$ano'  ORDER BY d_limite";
$resultado7 = mysqli_query($conection, $sqlcorre7)or die('Não foi possivel conectar ao MySQLs');
while ($registro7 = mysqli_fetch_array($resultado7)) {

    $id_preventiva = $registro7['id_preventiva'];
    $d_limite = $registro7['d_limite'];
    $data_conclusao = $registro7['data_conclusao'];
    
}

            $data_3 = new DateTime($data_conclusao);
            $data_4 = new DateTime($d_limite);
            $intervalo = $data_3->diff($data_4);
            $inter_garant = " {$intervalo->y} anos, {$intervalo->m} meses e {$intervalo->d} dias";
            
          

//verificar se á pendencias de analise, caso tenha o relatório não poderá ser emitido.

$sqlcorre = "SELECT * FROM corretivas WHERE id_contrato = '$id' AND mes_ref ='$mes'  AND ano = '$ano' AND status!='Pendente' AND aplicacao_multa='Verificar'";
$resultado = mysqli_query($conection, $sqlcorre)or die('Não foi possivel conectar ao MySQLs');
$num = mysqli_num_rows($resultado);

if ($num > 0) {
    $_SESSION['msg8'] = "<p style='color:red;'> Registros Pendentes de Analise, Efeutue-as para emitir o relatório. </p>";
    header("Location: analise_ans.php");
}




include('pdf/mpdf.php');


$conection = mysqli_connect('localhost', 'root');
mysqli_select_db($conection, 'gac');



$mpdf = new mPDF('utf-8', 'A4-L');
$mpdf->SetDisplayMode('fullpage');

$mpdf->SetHTMLHeader("
<img id='imge' src='img/serpro4.jpg' width='150'  />
<div style='text-align: right; font-weight: bold; margin-top:-30px;margin-bottom: 40px;'>
  <strong id = 'obje'>Análise de Níveis de Serviço - ANS (Manutenção) - $me  de  $ano  </strong>    <hr id='lin'>  <p id='tit'>      $nom    - RG:  $rg </p> 
                 
</div>");

$pagina = "
    
$passo = 100px;
    
<style>
        h3 {color: black; }
        h5 {color: red; margin-bottom: 10px; margin-top:20px; }
        #content table {color: red; text-align: center; }
        #content  {margin-top: 20px; }
        #analitic  {margin-top: 150% ; }
        #tit {margin-top: -8px; }
     
        #tit {font-size: 12px; text-shadow:1px 1px 3px #cfcfcf}
        #obje {text-shadow:1px 1px 3px #cfcfcf}
        #lin {margin-top: 0px;}
       .conc{margin-top: 50px;  outline: 1px ;}
        #conc2{margin-top: 10px;  outline: 1px ;}
        #margin{margin-top: $conclusao px;}
        #mar_resumo{margin-top: $mar_resumo px;}
        #mar_preventiva{margin-top: $mar_preventiva px;}
        #imge {margin-left:10px;}
      
        
</style>
<html> 
   
	<body>
		 	
    


 <br/><table border=1 cellspacing=0 cellpadding=3  >
  <tr>
 <td color=#000000; bgcolor='#E6E6E6'><font size='1'><center><b>Item</center></td>
 <td color=#000000; bgcolor='#E6E6E6'><font size='1'><b>Crítica</td>
 <td color=#000000; bgcolor='#E6E6E6'><font size='1'><b>Modo Apoio</td>
 <td color=#000000; bgcolor='#E6E6E6'><font size='1' width='630px'  ><b>Descrição</td>
 <td  color=#FFFFFF bgcolor='black'><font size='1'><b>Início</td>
 <td  color=#FFFFFF bgcolor='black'><font size='1'><b>Tolerância</td>
 <td  color=#FFFFFF bgcolor='black'><font size='1'><b>On-Site</td>
 <td  color=#FFFFFF bgcolor='black'><font size='1'><b>Solução</td> 
 <td  color=#FFFFFF bgcolor='black'><font size='1'><b>Multa</td>
 
 </tr><tbody>
";

$severi = "SELECT * FROM severidades WHERE id_contrato = '$id'";
$resultado = mysqli_query($conection, $severi)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado)) {

    if ($registro['modo'] == 1) {
        $modo1 = "24 x 7";
    } else {
        $modo1 = "10 x 5";
    }

    $tolerancia = $registro['tolerancia'];
    $start_onsite = $registro['start_onsite'];

    if ($tolerancia == 100) {
        $tolerancia = "0";
    }

    if ($start_onsite == 100) {
        $start_onsite = "0";
    }
    $multa = $registro['multa'];
    $prazo_solu = $registro['prazo_solu'];

    if ($prazo_solu == 100000) {
        $prazo_solu = "Indeterminado";
    }



    $pagina = $pagina . "			
				
	
    <tr>
        <td ><font size='1'>" . $registro['item'] . "</font></td>
	<td ><font size='1'>" . $registro['severidade'] . "</font></td>
	<td ><font size='1'>" . $modo1 . "</font></td>
        <td  width='630px '><font size='1'>" . $registro['descricao'] . "</font></td>
        <td ><font size='1'>" . mascara_php($registro['prazo_atend']) . "</font></td>
        <td ><font size='1'>" . mascara_php($tolerancia) . "</font></td>
        <td ><font size='1'>" . mascara_php($start_onsite) . "</font></td>
	<td ><font size='1'>" . mascara_php($prazo_solu) . "</font></td>
        <td ><font size='1'>" . $multa . "</font></td>
    </tr> ";
}
$pagina = $pagina . "	
</tbody>
</table> ";

$sqlcorre = "SELECT * FROM corretivas WHERE id_contrato = '$id' AND mes_ref ='$mes'  AND ano = '$ano' AND status!='Pendente'  ORDER BY (mes_ref)";
$r = mysqli_query($conection, $sqlcorre);
$num1 = mysqli_num_rows($r);

if ($num1 > 0) {
    $pagina = $pagina . "
<html> 
 
	<body>
		<h5>Corretiva (Atendimentos encerrados)</h5>
 <table border=1 cellspacing=0 cellpadding=3  > 
 <tr> 
 <td rowspan='2'  bgcolor='#E6E6E6' ><font size='1'>Data Conclusão</td>
 <td rowspan='2'  bgcolor='#E6E6E6'><font size='1'>Tipo</td>
 <td rowspan='2'  bgcolor='#E6E6E6'><font size='1'>Nº Patrimônio</td>
 <td rowspan='2'  bgcolor='#E6E6E6'><font size='1'>Nº Chamado</td>
 <td rowspan='2'  bgcolor='#E6E6E6'><font size='1'>Local</td>
 <td rowspan='2'  bgcolor='#E6E6E6'><font size='1'>Severidade</td>
 <td colspan='3' bgcolor='black' color=#FFFFFF;><font size='1' width='10px' ><center>Atendimento</td>
 <td colspan='3' bgcolor='black' color=#FFFFFF;><font size='1' width='10px' ><center>Solução</td>
 <td rowspan='2' bgcolor='#E6E6E6'><font size='1'><center>Total (Horas)</td>
 <td rowspan='2' bgcolor='#E6E6E6'><font size='1'><center>Carência On-site?</td>
 <td rowspan='2'  bgcolor='#E6E6E6'><font size='1'><center>Apoio On-site?</td>
 <td rowspan='2'  bgcolor='#E6E6E6'><font size='1'><center>Aplicada multa</td>
 
 
  </tr>

  <tr>
     
	 <td bgcolor='#E6E6E6'><font size='1'  bgcolor='#E6E6E6'><center>Prazo </td>
	 <td bgcolor='#E6E6E6'><font size='1'><center>Utilizado</td>
         <td bgcolor='black' color=#FFFFFF;><font size='1'><center>Excedido</td>
	 <td bgcolor='#E6E6E6'><font size='1'><center>Prazo </td>
	 <td bgcolor='#E6E6E6'><font size='1'><center>Utilizado</td>
         <td bgcolor='black' color=#FFFFFF;><font size='1'><center>Excedido</td>

	
 </tr><tbody>
 
";


    $sqlcorre = "SELECT * FROM corretivas WHERE id_contrato = '$id' AND mes_ref ='$mes'  AND ano = '$ano' AND status!='Pendente'  ORDER BY (mes_ref)";
    $resultado = mysqli_query($conection, $sqlcorre)or die('Não foi possivel conectar ao MySQLs');
    while ($registro = mysqli_fetch_array($resultado)) {

        $data1 = $registro['data_abertura'];
        $data1 = inverteData($data1);
        $data2 = $registro['data_atendimento'];
        $data2 = inverteData($data2);
        $data3 = $registro['data_conclusao'];
        //$data3 = inverteData($data3);
        $tipo = $registro['tipos'];
        $tempat = $registro['tempo_excedido_atendimento'];
        $tempac = $registro['tempo_excedido_conclusao'];
        $subac = $registro['subtotal_conclusao'];
        $regional = $registro['regional'];

        include './abreviacao.php';

        $ex = explode("-", $data3);
        $ano1 = $ex[0];
        $mes_ref = $ex[1];

        $data3 = $mes_ref . "/" . $ano1;
        $previsao_multa = $registro['previsao_multa'];

        if ($previsao_multa == 1) {
            $previsao_multa = 'Sim';
        } else {
            $previsao_multa = 'Não';
        }


        $total = ($registro['total']);
        if ($total > 0) {
            $total1 = (string) $total . ":00";
        } else {
            $total1 = "00:00";
        }

        $subat = $registro['subtotal_atendimento'];
        if ($subat > 0) {
            $subat1 = (string) $subat . ":00";
        } else {
            $subat1 = "00:00";
        }

        $subac = $registro['subtotal_conclusao'];
        if ($subac > 0) {
            $subac1 = (string) $subac . ":00";
        } else {
            $subac1 = "00:00";
        }


        if ($tempat > 0) {
            $tempat1 = (string) $tempat . ":00";
        } else {
            $tempat1 = "00:00";
        }

        if ($tempac > 0) {
            $tempac1 = (string) $tempac . ":00";
        } else {
            $tempac1 = "00:00";
        }



        $pagina = $pagina . "			
	
	<tr>
	<td ><font size='1'><center>" . $data3 . "</font></td>
	<td ><font size='1'><center>" . $tipo . "</font></td>
	<td ><font size='1'><center>" . $registro['n_patrimonio'] . "</font></td>
	<td ><font size='1'><center>" . $registro['n_chamado'] . "</font></td>
        <td ><font size='1'><center>" . $regional . "</font></td>
	<td color=#CD0000><font size='1'><center>" . $registro['tipo_severidade'] . "</font></td>
        <td bgcolor='#E8E8E8'><font size='1'><center>" . $registro['prazo_atendimento'] . "</font></td>
        <td bgcolor='#E8E8E8'><font size='1'><center>" . $subat1 . "</font></td>
        <td bgcolor='#E8E8E8' ><font size='1' ><center>" . $tempat1 . "</font></td>		
	<td ><font size='1'><center>" . $registro['prazo_conclusao'] . "</font></td>
        <td ><font size='1'><center>" . $subac1 . "</font></td>
        <td ><font size='1'><center>" . $tempac1 . "</font></td>
        <td bgcolor='#E8E8E8' color=#CD0000 ><font size='1'><center>" . $total1 . "</font></td>		
	<td ><font size='1'><center>" . $registro['necessidade_on_site'] . "</font></td>
        <td ><font size='1'><center>" . $registro['atendimento_onsite'] . "</font></td>       
        <td ><font size='1'><center>" . $registro['aplicacao_multa'] . "</font></td>
		
     <tr>   
   ";
    }
}
$pagina = $pagina . "	
</tbody>
 </table>";

// esta consulta apenas verifica a existencia de chamados Pendentes , caso não exista a tabela não será exibida.

$sqlcorre = "SELECT * FROM corretivas WHERE id_contrato = '$id' AND status='Pendente'AND MONTH(data_abertura)<= '$mes' ";
$resultado = mysqli_query($conection, $sqlcorre)or die('Não foi possivel conectar ao MySQLs');
while ($registro = mysqli_fetch_array($resultado)) {

    $status = $registro['status'];
    if ($status) {
        $pagina = $pagina . "
<html> 
 
		<body>
		 <h5>Corretiva (Atendimentos Abertos)</h5> 
		


 <table border=1 cellspacing=0 cellpadding=3  >
 
 
 <tr> 
 <td rowspan='2'  bgcolor='#E6E6E6' ><font size='1'>Data Abertura</td>
 <td rowspan='2'  bgcolor='#E6E6E6'><font size='1'>Tipo</td>
 <td rowspan='2'  bgcolor='#E6E6E6'><font size='1'>Nº Patrimônio</td>
 <td rowspan='2'  bgcolor='#E6E6E6'><font size='1'>Nº Chamado</td>
 <td rowspan='2'  bgcolor='#E6E6E6'><font size='1'>Local</td>
 <td rowspan='2'  bgcolor='#E6E6E6'><font size='1'>Severidade</td>
 <td colspan='3' bgcolor='black' color=#FFFFFF;><font size='1' width='10px' ><center>Atendimento</td>
 <td colspan='3' bgcolor='black' color=#FFFFFF;><font size='1' width='10px' ><center>Solução</td>
 <td rowspan='2' bgcolor='#E6E6E6'><font size='1'><center>Total (Horas)</td>
 <td rowspan='2' bgcolor='#E6E6E6'><font size='1'><center>Carência On-site?</td>
 <td rowspan='2'  bgcolor='#E6E6E6'><font size='1'><center>Apoio On-site?</td>
 
 <td rowspan='2'  bgcolor='#E6E6E6'><font size='1'><center>Aplicada multa</td>
  </tr>

  <tr>
     
	 <td bgcolor='#E6E6E6'><font size='1'  bgcolor='#E6E6E6'><center>Prazo</td>
	 <td bgcolor='#E6E6E6'><font size='1'><center>Utilizado</td>
         <td bgcolor='black' color=#FFFFFF;><font size='1'><center>Excedido</td>
	 <td bgcolor='#E6E6E6'><font size='1'><center>Prazo</td>
	 <td bgcolor='#E6E6E6'><font size='1'><center>Utilizado</td>
         <td bgcolor='black' color=#FFFFFF;><font size='1'><center>Excedido</td>


	
 </tr><tbody>
 
";


       $sqlcorre = "SELECT * FROM corretivas WHERE id_contrato = '$id' AND status='Pendente' AND data_abertura <='$anomes' AND MONTH(data_abertura)BETWEEN '1' AND '12'   ";
                    $resultado = mysqli_query($conection, $sqlcorre)or die('Não foi possivel conectar ao MySQL');
                    while ($registro = mysqli_fetch_array($resultado)) {
  

            $data1 = $registro['data_abertura'];
            $data1 = inverteData($data1);

            $data2 = $registro['data_atendimento'];
            $data2 = inverteData($data2);

            $data3 = $registro['data_conclusao'];
            $data3 = inverteData($data3);
            $tipo = $registro['tipos'];
            $tempat = $registro['tempo_excedido_atendimento'];
            $tempac = $registro['tempo_excedido_conclusao'];
            $subac = $registro['subtotal_conclusao'];
            $subac = $registro['subtotal_conclusao'];
            $subat = $registro['subtotal_atendimento'];
            $regional = $registro['regional'];
            include './abreviacao.php';

            $total = ($registro['total']);
            if ($total > 0) {
                $total1 = (string) $total . ":00";
            } else {
                $total1 = "A Calcular";
            }


            if ($subat > 0) {
                $subat1 = (string) $subat . ":00";
            } else {
                $subat1 = " ";
            }

            $subac = $registro['subtotal_conclusao'];
            if ($subac > 0) {
                $subac1 = (string) $subac . ":00";
            } else {
                $subac1 = " ";
            }


            if ($tempat > 0) {
                $tempat1 = (string) $tempat . ":00";
            } else {
                $tempat1 = " ";
            }

            if ($tempac > 0) {
                $tempac1 = (string) $tempac . ":00";
            } else {
                $tempac1 = " ";
            }



            $previsao_multa = $registro['previsao_multa'];

            if ($previsao_multa == 1) {
                $previsao_multa = 'Sim';
            } else {
                $previsao_multa = 'Não';
            }

            $pagina = $pagina . "			
	
	<tr>
	<td ><font size='1'><center>" . $data1 . "</font></td>
	<td ><font size='1'><center>" . $tipo . "</font></td>
	<td ><font size='1'><center>" . $registro['n_patrimonio'] . "</font></td>
	<td ><font size='1'><center>" . $registro['n_chamado'] . "</font></td>
        <td ><font size='1'><center>" . $regional . "</font></td>
	<td color=#CD0000><font size='1'><center>" . $registro['tipo_severidade'] . "</font></td>
        <td bgcolor='#E8E8E8'><font size='1'><center>" . $registro['prazo_atendimento'] . "</font></td>
        <td bgcolor='#E8E8E8'><font size='1'><center>" . $subat1 . "</font></td>
        <td bgcolor='#E8E8E8' ><font size='1' ><center>" . $tempat1 . "</font></td>		
	<td ><font size='1'><center>" . $registro['prazo_conclusao'] . "</font></td>
            
        <td ><font size='1'><center>" . $subac1 . "</font></td>
        <td ><font size='1'><center>" . $tempac1 . "</font></td>
        <td bgcolor='#E8E8E8' color=#CD0000 ><font size='1'><center>" . $total1 . "</font></td>		
	<td ><font size='1'><center>" . $registro['necessidade_on_site'] . "</font></td>
        <td ><font size='1'><center>" . $registro['atendimento_onsite'] . "</font></td>       
        <td ><font size='1'><center>" . $registro['aplicacao_multa'] . "</font></td>
     <tr>   
   ";
        }
    }
}
$pagina = $pagina . "	
</tbody>
 </table> ";

// esta consulta apenas verifica a existencia de chamados Pendentes , caso não exista a tabela não será exibida.



if ($id_preventiva) {



    $pagina = $pagina . "    
<html> 
 
	<body>
        <br/>
         <div  style='page-break-inside:avoid'>
		<h5 id='mar_preventiva'>Preventiva</h5>
                

		
 <table border=1 cellspacing=0 cellpadding=3  >
 <tr>
 <td bgcolor='#E8E8E8' ><font size='1'>Ano</td>
 <td bgcolor='#E8E8E8' ><font size='1'>Nº Chamado</td>
 <td bgcolor='#E8E8E8' ><font size='1'>Nº Patrimônios Contemplados</td>  
 
 <td bgcolor='#E8E8E8' ><font size='1'>Local</td> 
 <td bgcolor='black' color=#FFFFFF ><font size='1'>Mês Planejado</td> 
 <td  bgcolor='black' color=#FFFFFF ><font size='1'>Data da Execução</td>
 <td bgcolor='#E8E8E8' ><font size='1'>Previsão de multa?</td>
 <td bgcolor='#E8E8E8' ><font size='1'>Aplicar multa?</td> 
 </tr><tbody>
";



    $sqlcorre = "SELECT * FROM preventivas WHERE id_contrato = '$id'  AND mes_ref = '$mes'  AND YEAR
(data_conclusao)= '$ano'  ORDER BY d_limite";
    $resultado = mysqli_query($conection, $sqlcorre)or die('Não foi possivel conectar ao MySQLs');
    while ($registro = mysqli_fetch_array($resultado)) {

        $d_limite = $registro['d_limite'];
        $ex = explode("-", $d_limite);
        $ano = $ex[0];



        $d_execucao = $registro['data_conclusao'];
        $d_execucao1 = inverteData($d_execucao);
        $id_preventiva = $registro['id_preventiva'];


        $pagina = $pagina . "			
    <tr>
        <td ><font size='1'><center>" . $ano . "</center></td>
        <td ><font size='1'><center>" . $registro['n_chamado'] . "</center></td> 	
	<td ><font size='1'>" . $registro['patrimonio'] . "</td> 
      
        <td ><font size='1'>" . $registro['regional'] . "</center></td>
        <td ><font size='1'><center>" . $registro['mes'] . "</center></td>        
        <td ><font size='1'><center>" . $d_execucao1 . "</center></td>
	<td ><font size='1'><center>" . $registro['previsao_multa'] . "</center></td> 
	<td ><font size='1'><center>" . $registro['aplicacao_multa'] . "</center></td>
        
    </tr> ";
    }
}

$pagina = $pagina . "	
</tbody>
 </table> 
 </div>";
$pagina = $pagina . "
<html> 
 
	<body>

		
         <div id=content>
          <div  style='page-break-inside:avoid'>
         <h5 id='mar_resumo'>Resumo </h5>
                 <table  border=1 cellspacing=0 cellpadding=3  >                 
<tr>
 <td bgcolor='#E8E8E8' color='black' ><font size='1'>Tipo de Manutenção</td>
 <td bgcolor='#E8E8E8' color='black'  ><font size='1'>Total de  Chamadas</td>
 <td bgcolor='#E8E8E8' color='black'  ><font size='1'>Dentro do Prazo</td>
 <td bgcolor='#E8E8E8' color='black' ><font size='1'>Fora do Prazo</td>
 <td bgcolor='#E8E8E8' color='black' ><font size='1'>Total de Tempo Excedidio</td>
 <td bgcolor='#E8E8E8' color='black' ><font size='1'>Total de Pendencias </td>
 </tr>

                      ";
$sql1 = "SELECT * FROM corretivas WHERE id_contrato = '$id' AND MONTH(data_conclusao)= '$mes'  AND YEAR (data_conclusao)= '$ano' AND status='Ok' ";
$resul1 = mysqli_query($conection, $sql1)or die('Não foi possivel conectar ao MySQL');

$spreve = "SELECT * FROM preventivas WHERE id_contrato = '$id' AND MONTH(data_conclusao)= '$mes'  AND YEAR (data_conclusao)= '$ano' AND status='Ok' ";
$resu_pre = mysqli_query($conection, $spreve)or die('Não foi possivel conectar ao MySQL');

$sqlcorre2 = "SELECT * FROM corretivas WHERE id_contrato = '$id' AND MONTH(data_conclusao)= '$mes'  AND YEAR (data_conclusao)= '$ano' AND previsao_multa=0 AND  status!='1'";
$resultado2 = mysqli_query($conection, $sqlcorre2)or die('Não foi possivel conectar ao MySQL');

$sqlpreve1 = "SELECT * FROM preventivas WHERE id_contrato = '$id' AND MONTH(data_conclusao)= '$mes'  AND YEAR (data_conclusao)= '$ano' AND previsao_multa='Nao' ";
$resu_pre1 = mysqli_query($conection, $sqlpreve1)or die('Não foi possivel conectar ao MySQL');

$sqlcorre3 = "SELECT * FROM corretivas WHERE id_contrato = '$id' AND MONTH(data_conclusao)= '$mes'  AND YEAR (data_conclusao)= '$ano' AND previsao_multa=1 ";
$resultado3 = mysqli_query($conection, $sqlcorre3)or die('Não foi possivel conectar ao MySQL');

$sqlpreve2 = "SELECT * FROM preventivas WHERE id_contrato = '$id' AND MONTH(data_conclusao)= '$mes'  AND YEAR (data_conclusao)= '$ano' AND previsao_multa='Sim' ";
$resu_pre2 = mysqli_query($conection, $sqlpreve2)or die('Não foi possivel conectar ao MySQL');

 $sqlcorre5 = "SELECT * FROM corretivas WHERE id_contrato = '$id' AND status='Pendente' AND data_abertura <='$anomes' AND MONTH(data_abertura)BETWEEN '1' AND '12'   ";
$resultado5 = mysqli_query($conection, $sqlcorre5)or die('Não foi possivel conectar ao MySQL');

$sqlpreve3 = "SELECT * FROM preventivas WHERE id_contrato = '$id'  AND MONTH(data_conclusao)= '$mes'  AND YEAR(data_conclusao)= '$ano' AND status='Pendente' ORDER BY d_limite";
$resu_pre3 = mysqli_query($conection, $sqlpreve3)or die('Não foi possivel conectar ao MySQL');


    $rows = mysqli_num_rows($resul1);
    $rows2 = mysqli_num_rows($resultado2);
    $rows3 = mysqli_num_rows($resultado3);
    $rows5 = mysqli_num_rows($resultado5);

    $rows6 = mysqli_num_rows($resu_pre);
    $rows7 = mysqli_num_rows($resu_pre1);
    $rows8 = mysqli_num_rows($resu_pre2);
    $rows9 = mysqli_num_rows($resu_pre3);

    $sqlcorre4 = "SELECT SUM(total) as totais FROM corretivas WHERE id_contrato = '$id' AND MONTH(data_conclusao)= '$mes'  AND YEAR (data_conclusao)= '$ano' AND previsao_multa=1 ";
    $resultado4 = mysqli_query($conection, $sqlcorre4)or die('Não foi possivel conectar ao MySQL');
    while ($registro4 = mysqli_fetch_array($resultado4)) {

        $total = $registro4['totais'];

        if ($total > 0) {
            $total = (string) $total . ":00";
        } else {
            $total = "00:00";
        }
    }
    $pagina = $pagina . "
             <tr>
       <td bgcolor='#E8E8E8' color='black' ><font size='1'>Corretiva </td>
        <td  ><font size='1'>$rows </td>
        <td  ><font size='1'>$rows2</td>
        <td  ><font size='1'>$rows3 </td>
        <td  ><font size='1'>$total</td>
        <td  ><font size='1'>$rows5 </td>
             </tr>
             <tr>
       <td bgcolor='#E8E8E8' color='black' ><font size='1'>Preventiva </td>
        <td  ><font size='1'>$rows6 </td>
        <td  ><font size='1'>$rows7</td>
        <td  ><font size='1'>$rows8 </td>
        <td  ><font size='1'>$inter_garant</td>
        <td  ><font size='1'>$rows9 </td>
             </tr>
  		
</tbody>
 </table> </div></div>"
    ;

    $pagina = $pagina . "
  
<html> 
 	<body>    
        <div  style='page-break-inside:avoid'>
    	<br/>
                <h5 id='margin'>Conclusão</h5>
                 <table  cellspacing=0 cellpadding=3  >	

                      ";

    $sqlcorre5 = "SELECT * FROM reg_relatorio WHERE id_relatorio = '$id_relatorio'";
    $resultado5 = mysqli_query($conection, $sqlcorre5)or die('Não foi possivel conectar ao MySQL');
    while ($registro5 = mysqli_fetch_array($resultado5)) {

        $conclusao_corretiva = $registro5['conclusao_corretiva'];
        $conclusao_preventiva = $registro5['conclusao_preventiva'];
        $acompanhado = $registro5['acompanhado'];
        $analizado = $registro5['analizado'];
    }
    $pagina = $pagina . "
   
                
                        <tr><td  bgcolor='#E8E8E8' color='black'><font size='3'><b> Análise Corretiva </b></td><tr>                      
                        <tr><td   width='1000px' bgcolor='#f8f9fa'><font size='1'>$conclusao_corretiva</td><tr>
                        <tr><td><font size='2'></td><tr>   
             
                        <tr><td  bgcolor='#E8E8E8' color='black'><font size='3'><b> Análise Preventiva </b></td><tr>   
                        <tr class='conc'><td  width='850px'  bgcolor='#f8f9fa'><font size='1'>$conclusao_preventiva</td><tr>
                        <tr><td><font size='1'></td><tr>   
                        <tr><td><font size='1'></td><tr>   
                        <tr class='conc'><td ><font size='3'><b>Acompanhado por:</b> $acompanhado.</td><tr>
                        <tr id='conc2'><td><font size='3'><b>Analisado por:</b> $analizado.</td><tr>
                                    
       </div>                     
                      
       			
				
		
</tbody>
 </table> </div>"
    ;
    $mpdf->setFooter('{PAGENO}');
    $mpdf->AddPage('L', '', '', '', '', 20, 20, 40, 28, 10, 10);
    $mpdf->WriteHTML($pagina);
    $mpdf->Output($pagina, 'I');






// I abre no navegador
// F salva no servidor
// D salva o arquivo no computador do usuario
?>