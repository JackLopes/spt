
<?php

require_once ('./inc/Config.inc.php');
require_once './Funcoes/func_data.php';

$conection = mysqli_connect('localhost', 'root');
mysqli_select_db($conection, 'gac');

$id_contrato = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$id_itens = filter_input(INPUT_GET, 'id_itens', FILTER_SANITIZE_NUMBER_INT);
$id_tipo = filter_input(INPUT_GET, 'id_tipo', FILTER_SANITIZE_NUMBER_INT);

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
  <strong id = 'obje'>Calculo de Multa Contratual  - Atraso na Entrega   <hr id='lin'>  <p id='tit'>  RG:  $rg - $nom  </p> 
                 
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
  <tr><td  bgcolor='#E8E8E8' color='black'><font > Data Prevista de Entrega do Objeto: </center></td><td  bgcolor='#E8E8E8'>$prazo_entrega</td><tr>                      
     
 </table> 	
    
";
$mult1 = "SELECT id_multa, referencia,subtotal, obs, status,regional, n_patrimonio,prazo_entrega_itens, prorrogacao_itens,entrega_itens,
        atraso_itens FROM multa WHERE id_contrato = '$id_contrato' AND categoria= '2'  ORDER BY (regional)";
$r = mysqli_query($conection, $mult1);
$num1 = mysqli_num_rows($r);

if ($num1 > 0) {


  $pagina = $pagina . "

 <br/><table border=1 cellspacing=0 cellpadding=3  >
  <tr bgcolor=' #6c757d'>
                                <th>Local da Entrega</th>
                                <th>Data Prorrogada para Entrega</th>                         
                                <th>Data Entrega do Objeto</th> 
                                <th> Dias Atraso na Entrega</th>                                                          
                                <th>Valor Entrega</th>
                                <th>Multa Aplicavel </th>                                                
 
 </tr><tbody>
";

$mult1 = "SELECT id_multa, referencia,subtotal, obs, status,regional, n_patrimonio,prazo_entrega_itens, prorrogacao_itens,entrega_itens,
        atraso_itens FROM multa WHERE id_contrato = '$id_contrato' AND categoria= '2'  ORDER BY (regional)";
$result1 = mysqli_query($conection, $mult1)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($result1)) {


    $pagina = $pagina . "				
	
    <tr>
        <td ><font size='1'>" . $registro['regional'] . "</font></td>   
	
	<td ><font size='1'>" . inverteData($registro['prorrogacao_itens']) . "</font></td>
        <td ><font size='1'>" . inverteData($registro['entrega_itens']) . "</font></td>
        <td ><font size='1'>" . $registro['atraso_itens'] . "</font></td>
        <td ><font size='1'>" . $registro['valor_entrega'] . "</font></td>
      
	<td ><font size='1'>" . $registro['subtotal'] . "</font></td>
     
     
    </tr> ";
}
$pagina = $pagina . "	
</tbody>
</table> ";

}


$pagina = $pagina . "
  
<html> 
 	<body>      
    	
 <div class='block'>
  <div class='division'>
    <table  class='tb' cellspacing=0 cellpadding=3 >	
                      <thead >
                 <tr>
                      <th   class='tb' width='100%';  bgcolor=' #6c757d'; >INFRAÇÃO</th>    <th  width='100%'; class='tb' bgcolor=' #6c757d';  >SUBTOTAL</th>
                                                                                 
                </tr>
                
    </thead>
                

                      ";

$sql = "SELECT SUM(subtotal) AS soma_subtotal FROM multa WHERE id_contrato = '$id_contrato' AND categoria='1' ";
$result = mysqli_query($conection, $sql)or die('Não foi possivel conectar ao MySQL');
while ($registro1 = mysqli_fetch_array($result)) {

    $sub_corretiva1 = $registro1['soma_subtotal'];
}
$sql2 = "SELECT SUM(subtotal) AS soma_subtotal FROM multa WHERE id_contrato = '$id_contrato' AND categoria='2' ";
$result = mysqli_query($conection, $sql2)or die('Não foi possivel conectar ao MySQL');
while ($registro2 = mysqli_fetch_array($result)) {

    $sub_corretiva2 = $registro2['soma_subtotal'];
}
$sq5 = "SELECT SUM(subtotal) AS soma_subtotal FROM multa WHERE id_contrato = '$id_contrato' AND categoria='5' ";
$result = mysqli_query($conection, $sq5)or die('Não foi possivel conectar ao MySQL');
while ($registro5 = mysqli_fetch_array($result)) {

    $sub_corretiva5 = $registro5['soma_subtotal'];
}
$sq = "SELECT SUM(subtotal) AS soma_subtotal FROM multa WHERE id_contrato = '$id_contrato' ";
$result = mysqli_query($conection, $sq)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($result)) {

    $sub_corretiva = $registro['soma_subtotal'];
}
$pagina = $pagina . "
    

   
                                    <tr><td   bgcolor='#E8E8E8'  >Atraso na Entrega Contratual</td><td bgcolor='#E8E8E8' >R$ $sub_corretiva1</td></tr>
                                    <tr><td>Atraso na Entrega Itens</td><td>R$  $sub_corretiva2</td></tr>
                                    <tr><td bgcolor='#E8E8E8' >Não Entrega do Objeto</td><td  bgcolor='#E8E8E8' >R$ 0,00</td></tr>
                                    <tr><td>Descumprimento de Cláusula</td><td>R$ 0,00</td></tr>
                                    <tr><td  bgcolor='#E8E8E8' >NS (Manutenção Preventiva)</td><td  bgcolor='#E8E8E8' >R$ 0,00</td></tr>
                                    <tr><td>NS (Manutenção Corretiva)</td><td>R$  $sub_corretiva5</td></tr>
                                    <tr><td  bgcolor='#E8E8E8' ><strong>TOTAL</strong></td><td  bgcolor='#E8E8E8' ><strong>R$ $sub_corretiva</strong></td></tr>


                            
                      
       			
				
		
</tbody>
 </table> </div> 
 <div class='division1'>
               <table  class='tb' cellspacing=0 cellpadding=3 >
                      <thead >
                            <tr>
                               <th  class='tb' bgcolor=' #6c757d'; width='130%'; colspan='2'>LIMITAÇÕES</th>
                                                                
                            </tr>
                    </thead>
                           <tr><td>Limite de Aplicação Parcial</td  ><td>R$ 0,00</td></tr>
                           <tr><td bgcolor='#E8E8E8'>Limite de Aplicação Total</td ><td bgcolor='#E8E8E8'>R$ 0,00</td></tr>
               </table>
               <br>
               <br>
               <br>
              

  
                <table  class='tb' cellspacing=0 cellpadding=3 >
                             <thead >
                                 <tr>
                                     <th bgcolor=' #6c757d'; width='200%'; colspan='2' >VALOR PARA APLICAÇÃO DA MULTA</th>
                                                                            
                                </tr>
                           </thead>
                       <tr><td bgcolor='#E8E8E8'></td><td bgcolor='#E8E8E8'><strong>R$ 0,00</strong></td></tr>
                </table>
    </div></div>"
;
$mpdf->setFooter('{PAGENO}');
$mpdf->AddPage('L', '', '', '', '', 20, 20, 28, 28, 10, 10);
$mpdf->WriteHTML($pagina);
$mpdf->Output($pagina, 'I');






// I abre no navegador
// F salva no servidor
// D salva o arquivo no computador do usuario
?>