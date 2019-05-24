<?php

require_once 'database_gac.php';

$mat = $_SESSION['matricula'];
$permissa = $_SESSION['permissao'];

$pin = 1;


if (!empty($id_tipo)) {
    $query = "SELECT tip.* , loc.id_contrato, cont.tip_chamado, 
				cont.rg, loc.lugar_regional, resp.matricula, resp.responsabilidade				
				FROM tipo AS tip
				INNER JOIN local AS loc ON  loc.id_local = tip.id_local
				INNER JOIN  contrato AS cont ON  cont.id_contrato = loc.id_contrato
                                INNER JOIN  responsaveis AS resp ON  resp.id_contrato = cont.id_contrato
				WHERE id_tipo = '$id_tipo' AND responsabilidade='Fiscal Administrativo'";

    $resultado = mysqli_query($conection, $query)or die('Não foi possivel conectar ao MySQL');
    while ($registro = mysqli_fetch_array($resultado)) {

        $matricula = $registro['matricula'];
        $id_contrato = $registro['id_contrato'];
    }
} else if (!empty($id)) {

    $id_contrato = $id;

    $query = "SELECT matricula FROM responsaveis WHERE responsabilidade='Fiscal Administrativo' AND id_contrato = '$id' ";

    $resultado = mysqli_query($conection, $query)or die('Não foi possivel conectar ao MySQL');
    while ($registro = mysqli_fetch_array($resultado)) {

        $matricula = $registro['matricula'];
    }
} else if (!empty($ct)) {

    $id_contrato = $ct;

    $query = "SELECT matricula FROM responsaveis WHERE  responsabilidade='Fiscal Administrativo' AND  id_contrato = '$ct'";

    $resultado = mysqli_query($conection, $query)or die('Não foi possivel conectar ao MySQL');
    while ($registro = mysqli_fetch_array($resultado)) {

        $matricula = $registro['matricula'];
    }
}


if (empty($matricula)) {
    $matricula = '00000000';
};

if ($mat == '21023867'  ){
   
    
    
    $query = "SELECT matricula FROM responsaveis WHERE  responsabilidade='Auxiliar Administrativo' AND  id_contrato = '$id_contrato'";
    $resultado = mysqli_query($conection, $query)or die('Não foi possivel conectar ao MySQL');
    while ($registro = mysqli_fetch_array($resultado)) {

        $matricula_aux = $registro['matricula'];
    }
    
    if(!empty($matricula_aux)){
        if($matricula_aux == '21023867' ){
        unset($mat);
        unset($pin);
        $mat = $matricula;
        
        $pin = 2;
        
    } 
        
    }
    
    
    
    
  
} 

if ( $mat == '21023395'){
    
    $query = "SELECT matricula FROM responsaveis WHERE  responsabilidade='Auxiliar Administrativo' AND  id_contrato = '$id_contrato'";
    $resultado = mysqli_query($conection, $query)or die('Não foi possivel conectar ao MySQL');
    while ($registro = mysqli_fetch_array($resultado)) {

        $matricula_aux = $registro['matricula'];
    }
    
    if(!empty($matricula_aux)){
        if($matricula_aux == '21023395' ){
        unset($mat);
        unset($pin);
        $mat = $matricula;
        
        $pin = 2;
        
    } 
        
    }
    
}