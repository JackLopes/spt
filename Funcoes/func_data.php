
<?php

// Função Inverte Data

function inverteData($data){
    if(count(explode("/",$data)) > 1){
        return implode("-",array_reverse(explode("/",$data)));
    }elseif(count(explode("-",$data)) > 1){
        return implode("/",array_reverse(explode("-",$data)));
    }
}

// Função Soma Data

function SomarData($data, $dias, $meses, $ano)
{
   /*www.brunogross.com*/
   //passe a data no formato dd/mm/yyyy
   $data = explode("/", $data);
   $newData = date("d/m/Y", mktime(0, 0, 0, $data[1] + $meses,
     $data[0] + $dias, $data[2] + $ano) );
   return $newData;
}

// Função Subtrai Data

function SubData($data, $dias, $meses, $ano)
{
   /*www.brunogross.com*/
   //passe a data no formato dd/mm/yyyy
   $data = explode("/", $data);
   $newData = date("d/m/Y", mktime(0, 0, 0, $data[1] - $meses,
     $data[0] - $dias, $data[2] - $ano) );
   return $newData;
}

function dataToTimestamp($data){
   $ano = substr($data, 6,4);
   $mes = substr($data, 3,2);
   $dia = substr($data, 0,2);
return mktime(0, 0, 0, $mes, $dia, $ano);
}

// Função Calcula dias

function CalculaDias($xDataInicial, $xDataFinal){
   $tMenor= dataToTimestamp($xDataInicial);
   $tMaior = dataToTimestamp($xDataFinal);


   $diff = $tMaior-$tMenor;
   $numDias = $diff/86400; //86400 é o número de segundos que 1 dia possui
   return $numDias;
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


//FORMATA COMO TIMESTAMP
/*Esta função é bem simples, e foi criada somente para nos ajudar a formatar a data já em formato  TimeStamp facilitando nossa soma de dias para uma data qualquer.*/



//SOMA 01 DIA   
function Soma1dia($data){   
   $ano = substr($data, 6,4);
   $mes = substr($data, 3,2);
   $dia = substr($data, 0,2);
return   date("d/m/Y", mktime(0, 0, 0, $mes, $dia+1, $ano));
}

//CALCULA DIAS UTEIS
/*É nesta função que faremos o calculo. Abaixo podemos ver que faremos o cálculo normal de dias ($calculoDias), após este cálculo, faremos a comparação de dia a dia, verificando se este dia é um sábado, domingo ou feriado e em qualquer destas condições iremos incrementar 1*/

function DiasUteis($yDataInicial,$yDataFinal){

   $diaFDS = 0; //dias não úteis(Sábado=6 Domingo=0)
   $calculoDias = CalculaDias($yDataInicial, $yDataFinal); //número de dias entre a data inicial e a final
   $diasUteis = 0;
   
   while($yDataInicial!=$yDataFinal){
      $diaSemana = date("w", dataToTimestamp($yDataInicial));
      if($diaSemana==0 || $diaSemana==6){
         //se SABADO OU DOMINGO, SOMA 01
         $diaFDS++;
      }else{
      //senão vemos se este dia é FERIADO
         for($i=0; $i<=12; $i++){
            if($yDataInicial==Feriados(date("Y"),$i)){
               $diaFDS++;   
            }
         }
      }
      $yDataInicial = Soma1dia($yDataInicial); //dia + 1
   }
return $calculoDias - $diaFDS;
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

/////////////


//FORMATA COMO TIMESTAMP



function SomaDiasUteis_data($xDataInicial,$xSomarDias){
   for($ii=0; $ii<=$xSomarDias; $ii++){
      
      $xDataInicial=Soma1dia($xDataInicial); //SOMA DIA NORMAL
      
      //VERIFICANDO SE EH DIA DE TRABALHO
      if(date("w", dataToTimestamp($xDataInicial))=="0"){
         //SE DIA FOR DOMINGO OU FERIADO, SOMA +1
         $xDataInicial=Soma1dia($xDataInicial);
         
      }else if(date("w", dataToTimestamp($xDataInicial))=="6"){
         //SE DIA FOR SABADO, SOMA +2
         $xDataInicial=Soma1dia($xDataInicial);
         $xDataInicial=Soma1dia($xDataInicial);
         
      }else{
         //senaum vemos se este dia eh FERIADO
         for($i=0; $i<=12; $i++){
            if($xDataInicial==Feriados(date("Y"),$i)){
               $xDataInicial=Soma1dia($xDataInicial);
            }
         }
      }
   }
return $xDataInicial;
}


