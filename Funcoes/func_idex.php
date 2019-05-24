<?php

require_once 'Db/db_idex.php';

function statusAtual($data_atual, $fim_vigencia_original, $fim_vigencia_prorogada, $fim_garantia , $tipo_contrato,$id_contrato) {
    //CONTRATO DE SERVIÇOS   
    //vigente-> se (data atual) < que (final da vig contratual)    
    //encerrado-> se (data atual) > (final da vig contratual) 

    if ($tipo_contrato == 'SERVIÇOS') {

        if ($fim_vigencia_prorogada > $fim_vigencia_original) {
            $fim_vigencia_original = $fim_vigencia_prorogada;
        }

        if ($data_atual < $fim_vigencia_original) {

            $status = "Vigente";
        } else {

            $status = "Encerrado";
        }
    } else {

        //CONTRATO DE AQUISIÇÃO OU SOLUÇÃO
        //vigente-> se (data atual) < que (final da vig contratual) e (fim da garantia)
        //vigente garantia ->se (data atual) > (final da vig contratual) e (data atual) < (fim da garantia)
        //encerrado-> se (data atual) > (final da vig contratual) e (data atual) > < (fim da garantia)

        if ($data_atual < $fim_vigencia_original AND $data_atual < $fim_garantia) {

            $status = "Vigente";
        } else if ($data_atual > $fim_vigencia_original AND $data_atual < $fim_garantia) {

            $status = "Vigente/Garantia";
        } else {

            $status = "Encerrado";
        }
    }
    
    //Atualiza no Banco de dados
    
    update_status($status, $id_contrato);
    
  
    return $status;
}

