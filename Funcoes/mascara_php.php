<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function mascara_string($mascara, $string) {
    $string = str_replace(" ", "", $string);
    for ($i = 0; $i < strlen($string); $i++) {
        $mascara[strpos($mascara, "#")] = $string[$i];
    }
    return $mascara;
}

function mascara_php($hora) {

    $tamanho = strlen($hora);

    switch ($tamanho) {
        case 0:
            $variavel = mascara_string('00:00', $hora);
            break;
        case 1:
            $variavel = mascara_string('0:0#', $hora);
            break;
        case 2:
            $variavel = mascara_string('0:##', $hora);
            break;
        case 3:
            $variavel = mascara_string('#:##', $hora);
            break;
        case 4:
            $variavel = mascara_string('##:##', $hora);
            break;
        case 5:
            $variavel = mascara_string('###:##', $hora);
            break;
        case 6:
            $variavel = mascara_string('####:##', $hora);
            break;
        case 7:
            $variavel = mascara_string('#####:##', $hora);
            break;
        case 8:
            $variavel = mascara_string('######:##', $hora);
            break;
    }
    return $variavel;
}
function hora_php($hora) {

    $tamanho = strlen($hora);

    switch ($tamanho) {
        case 0:
            $variavel = mascara_string('00:00', $hora);
            break;
        case 1:
            $variavel = mascara_string('#:00', $hora);
            break;
        case 2:
            $variavel = mascara_string('##:00', $hora);
            break;
        case 3:
            $variavel = mascara_string('###:00', $hora);
            break;
        case 4:
            $variavel = mascara_string('####:00', $hora);
            break;
        case 5:
            $variavel = mascara_string('#####:00', $hora);
            break;
       
    }
    return $variavel;
}

function masc_cnpj_php($cnpj_format) {

    $tamanho = strlen($cnpj_format);

    switch ($tamanho) {
        
        case 0:
            $formas = null;
            break;
        case 14:
            $formas = mascara_string('##.###.###/####-##', $cnpj_format);
            break;
        case 15:
             $formas =  $cnpj_format;
            break;
        case 18:
            $formas =  $cnpj_format;
            break;
        case 1:
            $formas =  $cnpj_format;
            break;
        
    }
    return $formas;
}

 

   
 function limpatel($valor){
 $valor = trim($valor); 
 $valor = str_replace("-", "", $valor);
 $valor = str_replace("(", "", $valor);
 $valor = str_replace(")", "", $valor);
 
 return $valor;
}
 
 $tel_format = '2021-9751';
 
/*
function limpaCPF_CNPJ($valor){
$valor = preg_replace('/[^-9]/', '', $valor);
   return $valor;
}
*/

 
function masc_tel_php($tel_format) {
    
    $tel_format1 = limpatel($tel_format);

    $compri = strlen($tel_format1);

    switch ($compri) {
        
        case 0:
            $formato = null;
            break;
        case 8:
            $formato = mascara_string('####-####', $tel_format1);
            break;
        case 10:
            $formato = mascara_string('(##) ####-####', $tel_format1);
            break;
   
        
    }
    return $formato;
}


//$tel_format2 = masc_tel_php($tel_format);


 //var_dump($tel_format2);