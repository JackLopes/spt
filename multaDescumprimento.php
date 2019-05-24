
<?php

require_once ('./inc/Config.inc.php');
require_once './Funcoes/func_data.php';
require_once './Funcoes/mascara_php.php';


$conection = mysqli_connect('localhost', 'root');
mysqli_select_db($conection, 'gac');

$id_contrato = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$id_histmulta = filter_input(INPUT_GET, 'id_histmulta', FILTER_SANITIZE_NUMBER_INT);
$id_tipo = filter_input(INPUT_GET, 'id_tipo', FILTER_SANITIZE_NUMBER_INT);

$sql = "SELECT * FROM contrato WHERE  id_contrato = '$id_contrato' ";
$resultado = mysqli_query($conection, $sql)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado)) {

    $percent_atrasoEntrega = $registro['percent_atrasoEntrega'];

    $percent_naoObjeto = $registro['percent_naoObjeto'];
    $percent_descumprimento = $registro['percent_descumprimento'];
    $rg = $registro['rg'];
    $vig_garantia = $registro['vig_garantia'];
    $valor_atual1 = $registro['valor_atual'];
    $valor_atual = number_format($valor_atual1, 2, ',', '.');
     $limiteParcial = $registro['limiteParcial'];
    $limiteTotal = $registro['limiteTotal'];

    $id_prestador = $registro['id_prestador'];
    $objeto = $registro['objeto'];
    $d_Assinatura = inverteData($registro['d_Assinatura']);
    $prazo_entrega = inverteData($registro['prazo_entrega']);
}

$percent_descumprimento2 = $percent_descumprimento / 100;
$multa = number_format($valor_atual1 * $percent_descumprimento2, 2, ',', '.');


$sql3 = "SELECT * FROM prestador WHERE id_prestador = $id_prestador";
$resultado1 = mysqli_query($conection, $sql3)or die('Não foi possivel conectar ao MySQL');
while ($registro1 = mysqli_fetch_array($resultado1)) {

    $nom = $registro1['nome'];
}

$clausuala_sql = "SELECT clausula, motivacao,id_colaborador FROM  historico_multa WHERE id_histmulta ='$id_histmulta'";
$result1 = mysqli_query($conection, $clausuala_sql)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($result1)) {

    $clausula = $registro['clausula'];
    $motivacao = $registro['motivacao'];
    $id_colaborador = $registro['id_colaborador'];
}

$contato = explode(',', $id_colaborador);

//var_dump($id_colaborador);









include('pdf/mpdf.php');





$mpdf = new mPDF('utf-8', 'A4-L');
$mpdf->SetDisplayMode('fullpage');



$mpdf->SetHTMLHeader("
<img id='imge' src='img/serpro2.jpg' width='100'  />
<div style='text-align: right; font-weight: bold; margin-top:-30px;margin-bottom: 40px;'>


  <strong id = 'obje'>Previsão de Multa Contratual  - Descumprimento de Cláusula Contratual   <hr id='lin'>  <p id='tit'>  RG:  $rg - $nom  </p> 
                 
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
        .tb{text-align:left; }
        .tb3 {margin-top:72; }
        #imge {margin-left:10px;}
        .block {height:400px;}

        .coment{
                  margin-bottom: -10px;
              
                color:red;
        }
        .coment1{
                
             
                color:red;
        }
     
       
        .division { width:49%;  height:200px; }
        .division1 { width:49%;  height:200px; vertical-align:top;  margin-left:500px;  margin-top:-188 px;}
}
</style>
<html> 
  <body>
  
  <table  cellspacing=0 cellpadding=3 >  
  <tr><td  bgcolor='#E8E8E8' color='black'><font ><h4> Objeto Do Contrato : </h4></center></td><td colspan='3' bgcolor='#E8E8E8'>$objeto</td><tr> 
  <tr><td  color='black'><font ><h4> Assinatura Contrato : </h4></center></td><td colspan='3'> $d_Assinatura</td><tr>                      
  <tr><td  bgcolor='#E8E8E8' color='black'><font ><h4> Vigência da Garantia :</h4> </center></td><td  bgcolor='#E8E8E8' colspan='3'>$vig_garantia meses</td><tr> 
  <tr><td  color='black'><font > <h4>Total do Contrato :</h4> </center></td><td> R$ $valor_atual</td><tr>                      
  
 
      ";

for ($i = 0; $i < count($contato); $i++) {


    if ($contato[$i] != null) {



        $k = array();



        $sql3 = "SELECT * FROM colaborador WHERE id_colaborador = $contato[$i]";
        $resultado1 = mysqli_query($conection, $sql3)or die('Não foi possivel conectar ao MySQL');
        while ($registro1 = mysqli_fetch_array($resultado1)) {

            $nom = $registro1['nome'];
            $email = $registro1['email'];
            $telefone = masc_tel_php($registro1['telefone']);




            $k = $i + 1;
        }



        $pagina = $pagina . "
  


         
<tr><td  bgcolor='#E8E8E8' color='black'><font >$k º  Contato: </center></td><td width='266'; bgcolor='#E8E8E8'>$nom </td><td width='266' text-align='left'; bgcolor='#E8E8E8'>  $email  </td><td width='266'  bgcolor='#E8E8E8'>  $telefone  </td><tr> 
   
        
";
    }
}

$pagina = $pagina . "
                       
     
 </table> 
 <div  style='page-break-inside:avoid'>

 <p><h4 class='coment1' >Motivação</h4></p>   
";


$clau = explode(';', $clausula);
$moti = explode(';', $motivacao);



for ($i = 0; $i < count($moti); $i++) {
    $pagina = $pagina . "
         
     <p style='margin: 2;'>$moti[$i]</p>


</div>
        
";
}



$pagina = $pagina . "
<div  style='page-break-inside:avoid'>
 <p><h4 class='coment'>Clausulas</h4></p>
";

for ($i = 0; $i < count($clau); $i++) {
    $pagina = $pagina . "
         
     <p>$clau[$i]</p>

        
";
}
$pagina = $pagina . "
    </div>
<div  style='page-break-inside:avoid'>
<p><h4 class='coment'>Calculo Da Multa</h4></p>

<p>Multa = $percent_descumprimento %   X   Valor Do Contrato </p>
<p>Multa = $percent_descumprimento2  X  $valor_atual </p>
<p>Multa = R$ $multa   </p>

</div>



  
<html> 
 	<body>      
    	
 <div class='block'  style='page-break-inside:avoid;'>
 
  <div class='division'>
  <p><h4 class='coment1'>Incidencias de Penalidades</h4></p>
    <table  class='tb' cellspacing=0 cellpadding=3 >	
                      <thead >
                 <tr>
                      <th   class='tb' width='100%'; color='white'; bgcolor=' #6c757d'; >INFRAÇÃO</th>    <th  width='100%'; class='tb' bgcolor=' #6c757d';  color='white' >SUBTOTAL</th>
                                                                                 
                </tr>
                
    </thead>
                

                      ";

$A = 0;
$D = 0;
$C = 0;
$C1 = 0;
$B = 0;
$ABCD = 0;
$AD = 0;

$sql = "SELECT SUM(subtotal) AS soma_subtotal FROM multa WHERE id_contrato = '$id_contrato' AND categoria='1' ";
$result = mysqli_query($conection, $sql)or die('Não foi possivel conectar ao MySQL');
while ($registro1 = mysqli_fetch_array($result)) {

    $D = $registro1['soma_subtotal'];
}
$sql2 = "SELECT SUM(subtotal) AS soma_subtotal FROM multa WHERE id_contrato = '$id_contrato' AND categoria='2' ";
$result = mysqli_query($conection, $sql2)or die('Não foi possivel conectar ao MySQL');
while ($registro2 = mysqli_fetch_array($result)) {

    $A = $registro2['soma_subtotal'];
}
$sq5 = "SELECT SUM(subtotal) AS soma_subtotal FROM multa WHERE id_contrato = '$id_contrato' AND categoria='5' ";
$result = mysqli_query($conection, $sq5)or die('Não foi possivel conectar ao MySQL');
while ($registro5 = mysqli_fetch_array($result)) {

    $C1 = $registro5['soma_subtotal'];
}
$sq = "SELECT SUM(subtotal) AS soma_subtotal FROM multa WHERE id_contrato = '$id_contrato'  ";
$result = mysqli_query($conection, $sq)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($result)) {

    $sub_corretiva = $registro['soma_subtotal'];
}
$sq = "SELECT SUM(valor_multa_aplicado) AS soma_valor_multa_aplicado FROM  historico_multa WHERE id_contrato = '$id_contrato' AND categoria='5'";
$result = mysqli_query($conection, $sq)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($result)) {

    $soma_multa_aplicado_corretiva = $registro['soma_valor_multa_aplicado'];
}
$sq = "SELECT SUM(valor_multa_aplicado) AS soma_valor_multa_aplicado FROM  historico_multa WHERE id_contrato = '$id_contrato' AND categoria='1'";
$result = mysqli_query($conection, $sq)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($result)) {

    $soma_multa_aplicado_atraso_itens = $registro['soma_valor_multa_aplicado'];
}
$sq = "SELECT COUNT(siscor) AS advertencia FROM  historico_multa WHERE id_contrato = '$id_contrato' AND categoria ='3'";
$result = mysqli_query($conection, $sq)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($result)) {

    $advertencia = $registro['advertencia'];
}

 $sq = "SELECT SUM(valor_multa_aplicado) AS soma_valor_multa_aplicado FROM  historico_multa WHERE id_contrato = '$id_contrato'";
                                        $result = mysqli_query($conection, $sq)or die('Não foi possivel conectar ao MySQL');
                                        while ($registro = mysqli_fetch_array($result)) {

                                            $soma_total = $registro['soma_valor_multa_aplicado'];
                                        }

$sq = "SELECT SUM(valor_multa_aplicado) AS soma_valor_multa_aplicado FROM  historico_multa WHERE id_contrato = '$id_contrato' AND categoria='6'";
                                        $result = mysqli_query($conection, $sq)or die('Não foi possivel conectar ao MySQL');
                                        while ($registro = mysqli_fetch_array($result)) {

                                            $soma_multa_descumprimento = $registro['soma_valor_multa_aplicado'];
                                        }
                                        
//Calculo de  limitação parcial(Referência: valor atual do contrato)

$valor_limitacao_pacial = $valor_atual1 * ($limiteParcial / 100);
$valor_limitacao_pacial1 = number_format($valor_limitacao_pacial, 2, ',', '.');



//Calculo de  limitação Total(Referência: valor atual do contrato)

$valor_limitacao_total = $valor_atual1 * ($limiteTotal / 100);
$valor_limitacao_total1 = number_format($valor_limitacao_total, 2, ',', '.');


//Calculo de  Aplicação de multa
//condição A e D
// $A = 1;
// $D = 2;
$C = 0;
$B = 0;
// $B = 6000000;

if (!empty($A) OR ! empty($D)) {

    $AD = $A + $D;

    if ($AD > $valor_limitacao_pacial) {

        $AD = $valor_limitacao_pacial;
    }
}

//condição A + B + C + D


if (!empty($A) OR ! empty($B)OR ! empty($C) OR ! empty($C1)OR ! empty($D)) {

    $ABCD = $AD + $B + $C + $C1;

    if ($ABCD > $valor_limitacao_total) {

        $ABCD = $valor_limitacao_total;
    }
}

$atraso_entrega = number_format($A, 2, ',', '.');
$soma_multa_aplicado_atraso_itens1 = number_format($soma_multa_aplicado_atraso_itens, 2, ',', '.');
$Corretiva = number_format($C1, 2, ',', '.');
$soma_multa_aplicado_corretiva1 = number_format($soma_multa_aplicado_corretiva, 2, ',', '.');
$soma_multa_descumprimento1 = number_format($soma_multa_descumprimento, 2, ',', '.');
 $soma_total1 = number_format($soma_total, 2, ',', '.');

$pagina = $pagina . "
 


                                        <tr><td  bgcolor='#E8E8E8'>Advertência</td><td  bgcolor='#E8E8E8'> $advertencia </td></tr>
                                        <tr><td>Suspenção</td><td>0</td></tr> 
                                        <tr><td   bgcolor='#E8E8E8'  >Atraso na Entrega do Objeto</td><td bgcolor='#E8E8E8' >R$ $soma_multa_aplicado_atraso_itens1</td></tr>
                                        <tr><td>Não Entrega do Objeto</td><td>R$  R$ 0,00</td></tr>
                                        <tr><td  bgcolor='#E8E8E8' >NS (Manutenção Preventiva)</td><td  bgcolor='#E8E8E8' >R$ 0,00</td></tr>
                                        <tr><td>NS (Manutenção Corretiva)</td><td>R$  $soma_multa_aplicado_corretiva1</td></tr>                                      
                                        <tr><td  bgcolor='#E8E8E8'>Descumprimento de Cláusula</td><td  bgcolor='#E8E8E8'>R$ $soma_multa_descumprimento1</td></tr>                                     
                                      
                                   
		
</tbody>
 </table> </div> 
 <div class='division1'>
               <table class='tb' cellspacing=0 cellpadding=3 >
                      <thead >
                            <tr>
                               <th  class='tb' bgcolor=' #6c757d'; width='130%'; colspan='2'  color='white'>LIMITAÇÕES</th>                                                              
                            </tr>
                    </thead>
                           <tr><td>Limite de Aplicação Parcial</td  ><td>R$ $valor_limitacao_pacial1</td></tr>
                           <tr><td bgcolor='#E8E8E8'>Limite de Aplicação Total</td ><td bgcolor='#E8E8E8'>R$ $valor_limitacao_total1</td></tr>
               </table>
                      
                   
             

                <table  class='tb3' cellspacing=0 cellpadding=3 >
                             <thead >
                                 <tr>
                                     <th bgcolor=' #6c757d'; width='150%'; colspan='2' color='white' >VALOR PARA APLICAÇÃO DA MULTA</th>
                                                                         
                                </tr>
                           </thead>
                       <tr><td bgcolor='#E8E8E8'></td><td bgcolor='#E8E8E8'><strong>R$ $soma_total1</strong></td></tr>
                </table>
    </div></div>"
;
$mpdf->setFooter('{PAGENO}');
$mpdf->AddPage('L', '', '', '', '', 20, 20, 32, 15, 10, 10);
$mpdf->WriteHTML($pagina);
$mpdf->Output($pagina, 'I');






// I abre no navegador
// F salva no servidor
// D salva o arquivo no computador do usuario
?>