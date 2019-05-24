
<?php

require_once ('./inc/Config.inc.php');
require_once './Funcoes/func_data.php';

$conection = mysqli_connect('localhost', 'root');
mysqli_select_db($conection, 'gac');

$id_contrato = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$siscor = filter_input(INPUT_GET, 'siscor', FILTER_SANITIZE_NUMBER_INT);
$fg = filter_input(INPUT_GET, 'fg', FILTER_SANITIZE_STRING);


$sql = "SELECT * FROM contrato WHERE  id_contrato = '$id_contrato' ";
$resultado = mysqli_query($conection, $sql)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado)) {

    $percent_atrasoEntrega = $registro['percent_atrasoEntrega'];

    $percent_naoObjeto = $registro['percent_naoObjeto'];
    $percent_descumprimento = $registro['percent_descumprimento'];
    $rg = $registro['rg'];
    $id_prestador = $registro['id_prestador'];
    $objeto = $registro['objeto'];
    $d_Assinatura = inverteData($registro['d_Assinatura']);
    $prazo_entrega = inverteData($registro['prazo_entrega']);
}

$sql3 = "SELECT * FROM prestador WHERE id_prestador = $id_prestador";
$resultado1 = mysqli_query($conection, $sql3)or die('Não foi possivel conectar ao MySQL');
while ($registro1 = mysqli_fetch_array($resultado1)) {

    $nom = $registro1['nome'];
}

include('pdf/mpdf.php');






$mpdf = new mPDF('utf-8', 'A4-L');
$mpdf->SetDisplayMode('fullpage');

$mpdf->SetHTMLHeader("
<div style='text-align: right; font-weight: bold;'>
  <strong id = 'obje'>Histórico do Lancamentos   <hr id='lin'>  <p id='tit'>  RG:  $rg - $nom  </p> 
                 
</div>");

$pagina = "
    
$passo = 100px;
    
<style>
        h3 {color: black; }
        .margin{color: black; margin-bottom: 8px; margin-top:10px;margin-left:0px; }
        #content table {color: red; text-align: center; }
        #content  {margin-top: 20px; }
        #analitic  {margin-top: 150% ; }
        #tit {margin-top: -5px;}
        #tit {font-size: 12px; text-shadow:1px 1px 3px #cfcfcf}
        #obje {text-shadow:1px 1px 3px #cfcfcf}
        #lin {margin-top: 0px;}
       .conc{margin-top: 50px;  outline: 1px ;}
        #conc2{margin-top: 10px;  outline: 1px ;}
        #margin{margin-top: $conclusao px;}
        #mar_resumo{margin-top: $mar_resumo px;}
        #mar_preventiva{margin-top: $mar_preventiva px;}
        .tb{text-align:left;}
      
        .block div{display: inline-block;}
        .division { width:49%;  height:200px;  background-color: ; }
        .division1 { width:49%;  height:200px; vertical-align:top;  margin-left:500px;  position: absolute;margin-top:-200;}
}
</style>
<html> 
  <body>
  <table  cellspacing=0 cellpadding=3 >  
  <tr><td  bgcolor='#E8E8E8' color='black'><font > Objeto Do Contrato: </center></td><td  bgcolor='#E8E8E8'>$objeto</td><tr> 
  <tr><td  color='black'><font > Data da Assinatura Contrato: </center></td><td>$d_Assinatura</td><tr>                      
  <tr><td  bgcolor='#E8E8E8' color='black'><font > SISCOR: </center></td><td  bgcolor='#E8E8E8'>$siscor</td><tr>                      
  <tr><td color='black'><font > Status Atual: </center></td><td  >$fg</td><tr>                      
     
 </table> 	
    


 <br/><table border=1 cellspacing=0 cellpadding=3  >
  <tr >
                                <th>Data Registro</th>
                         
                                <th  width='870px'>Informação </th>                         
                                                                    
 
 </tr><tbody>
";

$mult1 = "SELECT * FROM historico_alerta WHERE id_contrato='$id_contrato' ORDER BY (data_registro) desc";
$result1 = mysqli_query($conection, $mult1)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($result1)) {

    $timer = $registro['data_registro'];
    
    $timer1 = explode(" ", $timer);
    $timer2 = $timer1[0];

    $pagina = $pagina . "				
	
    <tr>
      
	
	<td ><center><font size='1'>" . inverteData($timer2) . "</font></center></td>      
       
        <td ><font size='1' width='800px'>" . $registro['informacao'] . "</font></td>
    
     
     
    </tr> ";
}
$pagina = $pagina . "	
</tbody>
</table> ";





$mpdf->setFooter('{PAGENO}');
$mpdf->AddPage('L', '', '', '', '', 20, 20, 28, 28, 10, 10);
$mpdf->WriteHTML($pagina);
$mpdf->Output($pagina, 'I');






// I abre no navegador
// F salva no servidor
// D salva o arquivo no computador do usuario
?>