<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$sql = "SELECT valor_atual, percent_atrasoEntrega, percent_naoObjeto, percent_descumprimento, limiteParcial, limiteTotal FROM contrato WHERE  id_contrato = '$id_contrato' ";
$resultado = mysqli_query($conection, $sql)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado)) {

    $percent_atrasoEntrega = $registro['percent_atrasoEntrega'];
    $percent_naoObjeto = $registro['percent_naoObjeto'];
    $percent_descumprimento = $registro['percent_descumprimento'];
    $limiteParcial = $registro['limiteParcial'];
    $limiteTotal = $registro['limiteTotal'];
    $valor_atual = $registro['valor_atual'];
}


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
 $sql2 = "SELECT SUM(subtotal) AS soma_subtotal FROM multa WHERE id_contrato = '$id_contrato' AND categoria='2' AND status='1' ";
  $result = mysqli_query($conection, $sql2)or die('Não foi possivel conectar ao MySQL');
  while ($registro2 = mysqli_fetch_array($result)) {

  $A_alternativo = $registro2['soma_subtotal'];}
  
$sq5 = "SELECT SUM(subtotal) AS soma_subtotal FROM multa WHERE id_contrato = '$id_contrato' AND categoria='5' ";
$result = mysqli_query($conection, $sq5)or die('Não foi possivel conectar ao MySQL');
while ($registro5 = mysqli_fetch_array($result)) {

    $C1 = $registro5['soma_subtotal'];
}
$sq = "SELECT SUM(subtotal) AS soma_subtotal FROM multa WHERE id_contrato = '$id_contrato' AND status='1' ";
$result = mysqli_query($conection, $sq)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($result)) {

    $sub_corretiva = $registro['soma_subtotal'];
}

$sq8 = "SELECT SUM(valor_multa) AS soma_valor_multa FROM soma_atraso_item WHERE id_contrato = '$id_contrato' AND categoria='1' AND status = '1'";
$result = mysqli_query($conection, $sq8)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($result)) {

    $A = $registro['soma_valor_multa'];
}





$sql21 = "SELECT SUM(valor_multa_aplicado) AS soma_total, SUM(total_acumulado) AS soma_totalAculado FROM historico_multa WHERE id_contrato = '$id_contrato' AND categoria='1'  ";
$result1 = mysqli_query($conection, $sql21)or die('Não foi possivel conectar ao MySQL');
while ($registro21 = mysqli_fetch_array($result1)) {

    $total_aplicado_itens = $registro21['soma_total'];
}
   


if(empty($total_aplicado_itens)){
   
    $total_aplicado_itens = 0;
}

//$total_acumulado = $total_aplicado;
//Calculo de  limitação parcial(Referência: valor atual do contrato)

$valor_limitacao_pacial = $valor_atual * ($limiteParcial / 100);
$valor_limitacao_pacial1 = number_format($valor_limitacao_pacial, 2, ',', '.');



//Calculo de  limitação Total(Referência: valor atual do contrato)

$valor_limitacao_total = $valor_atual * ($limiteTotal / 100);
$valor_limitacao_total1 = number_format($valor_limitacao_total, 2, ',', '.');


//Calculo de  Aplicação de multa
//condição A e D
// $A = 1;
// $D = 2;
$C = 0;
$B = 0;
// $B = 6000000;

$valor_maximo_aplicavel = $valor_limitacao_pacial - $total_aplicado_itens;

if (!empty($A) OR ! empty($D)) {

    $AD = $A + $D;





    if ($AD > $valor_maximo_aplicavel) {

        $AD = $valor_maximo_aplicavel;
/*
        if ($valor_limitacao_pacial == $total_aplicado_itens) {

            $result1 = "UPDATE  soma_atraso_item SET  categoria='3' WHERE  categoria='1'";
            $resultado1 = mysqli_query($conection, $result1);
            
          

          
        }*/

        $ADF = number_format($AD, 2, ',', '.');
    }
}

if( $total_aplicado_itens == $valor_limitacao_pacial){
   $A = $A_alternativo;
}


$AF = number_format($A, 2, ',', '.');

//condição A + B + C + D


if (!empty($A) OR ! empty($B)OR ! empty($C) OR ! empty($C1)OR ! empty($D)) {

    $ABCD = $AD + $B + $C + $C1;

    if ($ABCD > $valor_limitacao_total) {

        $ABCD = $valor_limitacao_total;
    }
}

$ABCDF = number_format($ABCD, 2, ',', '.');

//CORRETIVAS

//  extrai a soma os valores incluidos da tabela multa que deseja se incluir
/*
$sq8 = "SELECT SUM(valor_multa) AS soma_valor_multa FROM soma_atraso_item WHERE id_contrato = '$id_contrato' AND categoria='5' AND status = '1'";
$result = mysqli_query($conection, $sq8)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($result)) {

    $soma_corretiva = $registro['soma_valor_multa'];
}
 * 
 */
$valor_multa_array = array();
$id_multa_array = array();
$soma_corretiva = 0;
$i=0;

$sq8 = "SELECT valor_multa, id_multa  FROM soma_atraso_item WHERE id_contrato = '$id_contrato' AND categoria='5' AND status = '1'";
$result = mysqli_query($conection, $sq8)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($result)) {
    
    $valor_multas[$i] = $registro['valor_multa'];
    $id_multas[$i] = $registro['id_multa'];

   
    array_push($valor_multa_array,  $valor_multas[$i]);
    array_push($id_multa_array, $id_multas[$i]);
    
     $soma_corretiva = array_sum( $valor_multa_array);
     
     $i = $i + 1;
     
   
}
   $id_multaString = implode(",", $id_multa_array);
   
  


// extrai a  soma total  do histórico
$sql21 = "SELECT SUM(valor_multa_aplicado) AS soma_total, SUM(total_acumulado) AS soma_totalAculado FROM historico_multa WHERE id_contrato = '$id_contrato' AND categoria='5'  ";
$result1 = mysqli_query($conection, $sql21)or die('Não foi possivel conectar ao MySQL');
while ($registro21 = mysqli_fetch_array($result1)) {

    $total_aplicado_corretiva = $registro21['soma_total'];
}
 
if(empty($total_aplicado_corretiva)){
   
    $total_aplicado_corretiva = 0;
}


$sql2 = "SELECT SUM(subtotal) AS soma_subtotal FROM multa WHERE id_contrato = '$id_contrato' AND categoria='5' AND status='1' ";
  $result = mysqli_query($conection, $sql2)or die('Não foi possivel conectar ao MySQL');
  while ($registro2 = mysqli_fetch_array($result)) {

  $soma_corretiva_alternativo = $registro2['soma_subtotal'];}

//estabelece o valor maximo aplicavel
$valor_max_aplicavel_corretiva = $valor_limitacao_total - $total_aplicado_corretiva;

// se o valor 
if($valor_max_aplicavel_corretiva < 0){
    $valor_max_aplicavel_corretiva = 0;
}



$soma_corretiva_maxima = $soma_corretiva;

if ($soma_corretiva > $valor_max_aplicavel_corretiva ){
    $soma_corretiva_maxima = $valor_max_aplicavel_corretiva;
}

if( $total_aplicado_corretiva == $valor_limitacao_total){
  
    $soma_corretiva = $soma_corretiva_alternativo;
   
}

//Descumprimento de Clausula