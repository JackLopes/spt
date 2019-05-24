
<?php

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

if (isset($_POST['rg'])) {
    $rg = $_POST['rg'];
}


if (isset($_POST['mes'])) {
    $mes = $_POST['mes'];
}

if (isset($_POST['ano'])) {
    $ano = $_POST['ano'];
}


$meses = array('', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
$me = @$meses[$mes];

function inverteData($data) {

    if (count(explode("/", $data)) > 1) {
        return implode("-", array_reverse(explode("/", $data)));
    } elseif (count(explode("-", $data)) > 1) {
        return implode("/", array_reverse(explode("-", $data)));
    }
}

include('pdf/mpdf.php');


$conection = mysqli_connect('localhost', 'root');
mysqli_select_db($conection, 'gac');



$mpdf = new mPDF('utf-8', 'A4-L');
$mpdf->SetDisplayMode('fullpage');

$mpdf->SetHTMLHeader("
<div style='text-align: right; font-weight: bold;'>
  <strong id = 'obje'> SPT/SI ETIQUETAS <br>    RG:  $rg  - $me  de  $ano  </strong>  
                 
</div>");

$pagina = "
    
$passo = 100px;
    
<style>
      
      .conc{width:200px;font-size:12px;}
      .conc1{width:100px;font-size:12px;}
       
        
</style>
<html> 
   
	<body>
		 	
    <br/><table border=1 cellspacing=0 cellpadding=3  >		
                        ";
                       
                        $sqlprestador = "SELECT * FROM pagamentos WHERE id_contrato = '$id'  AND  MONTH(data_fim_per)= '$mes ' AND  YEAR(data_fim_per)='$ano'";
                        $resultado = mysqli_query($conection, $sqlprestador)or die('Não foi possivel conectar ao MySQL');
                        while ($registro = mysqli_fetch_array($resultado)) {
                            $siscor = $registro['siscor'];
                            $d_assinatura_dig = inverteData($registro['d_assinatura_dig']);                             
                            $d_vencimento_pag = inverteData($registro['d_vencimento_pag']);
                             $regional = $registro['regional'];
                             
                          $exp = explode("-", $registro['data_fim_per']);
                          $mes = $exp[1];
                           
 $pagina = $pagina . "
                                               
                            <tr><td class='conc1'>RG:</td><td class='conc' >  $rg </td><tr>
                            <tr><td class='conc1'>Regional:</td><td class='conc' >  $regional </td><tr>
                            <tr><td class='conc1'>SISCOR:</td><td class='conc'>  $siscor </td><tr>
                                
                            <tr><td class='conc1'>Assinatura:</td><td class='conc'> $d_assinatura_dig </td><tr>
                            <tr><td class='conc1'>Vencimento:</td><td class='conc'> $d_vencimento_pag </td><tr>
                            <tr><td class='conc1' bgcolor='black'></td><td  bgcolor='black'> </td><tr>
                            
                        
                        <hr> ";
}
$pagina = $pagina . "	

</table> ";
		
		

$mpdf->setFooter('{PAGENO}');
$mpdf->AddPage('L', '', '', '', '', 20, 20, 28, 28, 10, 10);
$mpdf->WriteHTML($pagina);
$mpdf->Output($pagina, 'I');






// I abre no navegador
// F salva no servidor
// D salva o arquivo no computador do usuario
?>