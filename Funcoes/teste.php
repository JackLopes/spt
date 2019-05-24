<?php

//SOMA 01 DIA   
function Soma1dia($data){   
   $ano = substr($data, 6,4);
   $mes = substr($data, 3,2);
   $dia = substr($data, 0,2);
return   date("d/m/Y", mktime(0, 0, 0, $mes, $dia+1, $ano));
}

//LISTA DE FERIADOS NO ANO
/*Abaixo criamos um array para registrar todos os feriados existentes durante o ano.*/
function Feriados($ano,$posicao){
   $dia = 86400;
   $datas = array();
   $datas['pascoa'] = easter_date($ano);
   $datas['sexta_santa'] = $datas['pascoa'] - (2 * $dia);
   $datas['carnaval'] = $datas['pascoa'] - (47 * $dia);
   $datas['corpus_cristi'] = $datas['pascoa'] + (60 * $dia);
   $feriados = array (
      '01/01',
      '02/02', // Navegantes
      date('d/m',$datas['carnaval']),
      date('d/m',$datas['sexta_santa']),
      date('d/m',$datas['pascoa']),
      '21/04',
      '01/05',
      date('d/m',$datas['corpus_cristi']),
      '20/09', // Revolução Farroupilha \m/
      '12/10',
      '02/11',
      '15/11',
      '25/12',
   );
   
return $feriados[$posicao]."/".$ano;
}      


//CALCULA DIAS UTEIS
/*É nesta função que faremos o calculo. Abaixo podemos ver que faremos o cálculo normal de dias ($calculoDias), após este cálculo, faremos a comparação de dia a dia, verificando se este dia é um sábado, domingo ou feriado e em qualquer destas condições iremos incrementar 1*/

function DiasAcrescentar($yDataInicial,$yDataFinal){

   $diaAcres = 0; //dias não úteis
   
   while($yDataInicial!=$yDataFinal){
    
      //senão vemos se este dia é FERIADO
         for($s=0; $s<=12; $s++){
            if($yDataInicial==Feriados(date("Y"),$s)){
               $diaAcres++;   
            }
         
      }
     $yDataInicial = Soma1dia($yDataInicial); //dia + 1
   }
return $diaAcres;
}


/**
* Função para calcular o próximo dia útil de uma data
* Formato de entrada da $data: AAAA-MM-DD
*/
function proximoDiaUtil($data, $saida = 'Y-m-d') {
// Converte $data em um UNIX TIMESTAMP
$timestamp = strtotime($data);
// Calcula qual o dia da semana de $data
// O resultado será um valor numérico:
// 1 -> Segunda ... 7 -> Domingo
$dia = date('N', $timestamp);
// Se for sábado (6) ou domingo (7), calcula a próxima segunda-feira
if ($dia >= 6) {
$timestamp_final = $timestamp + ((8 - $dia) * 3600 * 24);
} else  {
// Não é sábado nem domingo, mantém a data de entrada
$timestamp_final = $timestamp;
}
return date($saida, $timestamp_final);
}


/*$d1='30/05/2018';
$d2='01/06/2018';


$acres=DiasAcrescentar($d1,$d2);

var_dump($acres);*/