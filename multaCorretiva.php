
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

$clausuala_sql = "SELECT * FROM historico_multa WHERE id_histmulta = '$id_histmulta'";
$result1 = mysqli_query($conection, $clausuala_sql)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($result1)) {

    $clausula = $registro['clausula'];
    $motivacao = $registro['motivacao'];
    $id_colaborador = $registro['id_colaborador'];
    $id_multas = $registro['id_multas'];
    $valor_multa_aplicado1 = $registro['valor_multa_aplicado'];
}
$clau = explode(';', $clausula);
$moti = explode(';', $motivacao);
$contato = explode(',', $id_colaborador);
$id_multas = explode(',', $id_multas);

$valor_multa_aplicado = number_format($valor_multa_aplicado1, 2, ',', '.');

//var_dump($id_colaborador);









include('pdf/mpdf.php');





$mpdf = new mPDF('utf-8', 'A4-L');
$mpdf->SetDisplayMode('fullpage');



$mpdf->SetHTMLHeader("
<img id='imge' src='img/serpro2.jpg' width='100'  />
<div style='text-align: right; font-weight: bold; margin-top:-30px;margin-bottom: 40px;'>


  <strong id = 'obje'>Previsão de Multa Contratual  - Descumprimento de ANS - Manutenção Corretiva   <hr id='lin'>  <p id='tit'>  RG:  $rg - $nom  </p> 
                 
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
        .tb1{text-align:left;margin-top: 0px; }
        .tb3 {margin-top:70px; }
        #imge {margin-left:10px;}      
        .block {height:200px; background-color:white; margin-top: 20px;}

        .coment{
                  margin-bottom: -10px;
              
                color:red;
        }
        .coment1{
                
             
                color:red;
              
               
        }
        .coment2{
                             
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

 <p><h4 class='coment1' >Nivel de Severidade</h4></p>
 
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

$severi = "SELECT * FROM severidades WHERE id_contrato = '$id_contrato'";
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
</table> 
</div>

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
 <p><h4 class='coment1' >Ocorrências</h4></p>

               <table border=1 cellspacing=0 cellpadding=3  > 
                    <thead class='thead-dark '>
                        <tr>

                           
                            <th scope='col'>Regional</th>
                            <th  scope='col'>Nº Chamado</th>                            
                            <th scope='col'>Patrimonio</th>
                            <th scope='col'>Crítica</th>
                            <th scope='col' >Data Abertura</th>
                            <th scope='col' >Hora Abertura</th>
                            <th scope='col' >Data Atendimento</th>
                            <th scope='col' >Hora Atendimento</th>
                            <th scope='col' >Data Solução</th>
                            <th scope='col' >Hora Solução</th>
                            <th scope='col'>Prazo Atendimento</th>                           
                            <th scope='col'>Utilizado Atendimento</th>
                            <th scope='col'>Prazo de Conclusão</th> 
                            <th scope='col'>Utilizado Conclusão</th>
                            <th   style='background-color: #B22222; color: white  '> Horas Excedentes </th> 
                           
                       
                            <th scope='col' style='background-color: #B22222; color: white'>Valor da Multa (R$)</th>
                          
                        </tr> 
                    </thead>
                      
                      ";


for ($i = 0; $i < count($id_multas); $i++) {


    if ($id_multas[$i] != null) {



        $k = array();
        $valortotal8 = array();

        $sqlcorre = "SELECT * FROM multa WHERE id_multa = '$id_multas[$i]'   ORDER BY (data_conclusao) ASC";
        $resultado = mysqli_query($conection, $sqlcorre)or die('Não foi possivel conectar ao MySQL');
        while ($registro = mysqli_fetch_array($resultado)) {
            $id_multa = $registro['id_multa'];
            $data1 = $registro['data_abertura'];
            $data1 = inverteData($data1);

            $data2 = $registro['data_atendimento'];
            $data2 = inverteData($data2);


            $data3 = $registro['data_conclusao'];
            $data3 = inverteData($data3);

            $id_corretiva = $registro['id_corretiva'];

            $patrimonio = $registro['n_patrimonio'];
            $status = $registro['status'];
            $prazo_atendimento = (int) $registro['prazo_atendimento'];
            $subtotal_atendimento = (int) $registro['subtotal_atendimento'];
            $prazo_conclusao = (int) $registro['prazo_conclusao'];
            $subtotal_conclusao = (int) $registro['subtotal_conclusao'];
            $total = (int) $registro['total'];


            if ($subtotal_atendimento < 0) {
                $subtotal_atendimento = 0;
            }
            if ($subtotal_conclusao < 0) {
                $subtotal_conclusao = 0;
            }




            $valor = number_format($registro['subtotal'], 2, ',', '.');


            if ($status == 1) {
                $status = "<font style='color:green'>Incluido</font>";
            } else if ($status == 3) {
                $status = "<font style='color:blue'>Multa Aplicada</font>";
            } else {
                $status = "<font style='color:red'>Incluir</font>";
            }










            $pagina = $pagina . "	                  
                        <tr>

                          
                             <td class = 'td2' >" . $registro['regional'] . "</td>
                            <td class = 'td2' >" . $registro['n_chamado'] . "</td>                            
                             <td class = 'td2' >" . $registro['n_patrimonio'] . "</td>
                             <td class = 'td2' >" . $registro['tipo_severidade'] . "</td>
                            <td class = 'td2' >" . $data1 . "</td>
                             <td class = 'td2' >" . $registro['hora_abertura'] . "</td>
                             <td class = 'td2' >" . $data2 . "</td>
                             <td class = 'td2' >" . $registro['hora_atendimento'] . "</td>
                             <td class = 'td2' >" . $data3 . "</td>
                             <td class = 'td2' >" . $registro['hora_conclusao'] . "</td>
                             <td class = 'td2' >" . hora_php($prazo_atendimento) . "</td>
                             <td class = 'td2' >" . hora_php($subtotal_atendimento) . "</td>
                             <td class = 'td2' >" . hora_php($prazo_conclusao) . "</td>    
                             <td class = 'td2' >" . hora_php($subtotal_conclusao) . "</td>
                             <td class = 'td2' >" . hora_php($total) . "</td>
                          
                         
                             <td class = 'td2' >" . $valor . "</td>
                          
                         
                          
                     </tr> ";

            $k = $i + 1;
        }
    }
}


$pagina = $pagina . "	
</tbody>
</table> 
</div>
";



$pagina = $pagina . "




  
<html> 
 	<body>      

 <div class='block'  style='page-break-inside:avoid;'>
 
  <div >
  <p><h4 class='coment2' >Incidências de Multas</h4></p>
  
           

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
 
 <table  class='tb'  cellspacing=0 cellpadding=3 >	
        <thead >
                 <tr>
                      <td class='tb' width='100%'; color='white'; bgcolor=' #6c757d'; >INFRAÇÃO</td>    <td  width='100%'; class='tb' bgcolor=' #6c757d';  color='white' >TOTAL PREVISIONADO *</td>  <td  class='celsp' bgcolor=' #6c757d'  colspan='2'  color='white'>LIMITAÇÕES</td>
                                                                              
                </tr>
              
    </thead>
   
                                        <tr><td  bgcolor='#E8E8E8'>Advertência</td><td  bgcolor='#E8E8E8'> $advertencia </td><td>Limite de Aplicação Parcial</td  ><td>R$ $valor_limitacao_pacial1</td></tr>
                                        <tr><td>Suspenção</td><td>0</td><td bgcolor='#E8E8E8'>Limite de Aplicação Total</td ><td bgcolor='#E8E8E8'>R$ $valor_limitacao_total1</td></tr>
                                        <tr><td   bgcolor='#E8E8E8'  >Atraso na Entrega do Objeto</td><td bgcolor='#E8E8E8' >R$ $soma_multa_aplicado_atraso_itens1</td></tr>
                                        <tr><td>Não Entrega do Objeto</td><td>R$  R$ 0,00</td></tr>
                                        <tr><td  bgcolor='#E8E8E8' >NS (Manutenção Preventiva)</td><td  bgcolor='#E8E8E8' >R$ 0,00</td></tr>
                                        <tr><td>NS (Manutenção Corretiva)</td><td>R$  $soma_multa_aplicado_corretiva1</td><td bgcolor=' #6c757d'; width='150%'; colspan='2' color='white' >VALOR REFERENTE PARA APLICAÇÃO DA MULTA</td></tr>                                 
                                        <tr><td  bgcolor='#E8E8E8'>Descumprimento de Cláusula</td><td  bgcolor='#E8E8E8'>R$ $soma_multa_descumprimento1</td><td bgcolor='#E8E8E8'></td><td bgcolor='#E8E8E8'><strong>R$ $valor_multa_aplicado</strong></td></tr>                                     
                           
                                   
		
</tbody>
 </table> </div> 

                      
                   
             

    </div>
    <span style='font-size:8px;'>* Total Previsionado inclui está ocorrência.</span>
    
</div>"
;
$mpdf->setFooter('{PAGENO}');
$mpdf->AddPage('L', '', '', '', '', 20, 20, 32, 15, 10, 10);
$mpdf->WriteHTML($pagina);
$mpdf->Output($pagina, 'I');






// I abre no navegador
// F salva no servidor
// D salva o arquivo no computador do usuario
?>