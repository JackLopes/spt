<?php

//LISTA DE FERIADOS NO ANO

/* Abaixo criamos um array para registrar todos os feriados existentes durante o ano. */
function Feriados1($ano, $posicao) {
    $dia = 86400;
    $datas = array();
    $datas['pascoa'] = easter_date($ano);
    $datas['sexta_santa'] = $datas['pascoa'] - (2 * $dia);
    $datas['carnaval'] = $datas['pascoa'] - (47 * $dia);
    $datas['corpus_cristi'] = $datas['pascoa'] + (60 * $dia);
    $feriados = array(
        '01/01',
        '02/02', // Navegantes
        date('d/m', $datas['carnaval']),
        date('d/m', $datas['sexta_santa']),
        date('d/m', $datas['pascoa']),
        '21/04',
        '01/05',
        date('d/m', $datas['corpus_cristi']),
        '07/09',
        '20/09', // Revolução Farroupilha \m/
        '12/10',
        '02/11',
        '15/11',
        '25/12',
    );

    return $feriados[$posicao] . "/" . $ano;
}



function verificar($data_ver, $anos) {   

    $result = $data_ver;

    for ($i = 0; $i <= 13; $i++) {
        
        if ($data_ver == Feriados1($anos, $i)) {
            
             $data_ver1 = inverteData($data_ver);

            $result2 = date('Y-m-d', strtotime($data_ver1 . ' + 1 days'));
            
             $result = inverteData($result2);
        }
    }
   
    return $result;
       
}