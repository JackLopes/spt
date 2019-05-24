<?php

function controle_linha($id_contrato){
    
    $conection = mysqli_connect('localhost', 'root');
    mysqli_select_db($conection, 'gac');

    
    $id_pags = array();
    $query = "select id_pag from pagamentos where id_contrato = '$id_contrato'";
    $result = mysqli_query($conection, $query);
    while ($registro = mysqli_fetch_array($result)) {

        $id_pags[] = $registro['id_pag'];
    }

    
    $num_pag = count($id_pags); //total de indices do array
    
   
    sort($id_pags); // ordena array
    $indice = array_keys($id_pags, $id_pag);
    array_push($indice, -1);
    $value = array_sum($indice);
    $verif_id = (INT) $id_pags[$value];

    $query1 = "SELECT * FROM pagamentos WHERE id_pag ='$verif_id' AND  medido='' AND d_assinatura_dig ='0000-00-00' AND siscor = '' LIMIT 1 ";
    $result1 = mysqli_query($conection, $query1);
    $num_very = mysqli_num_rows($result1);
 
    return $num_very;
    
   
}