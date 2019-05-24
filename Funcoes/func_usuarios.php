<?php

function busca_usuario($nome) {

    $conection = mysqli_connect('localhost', 'root');
    mysqli_select_db($conection, 'gac');

    $query = "SELECT * FROM  usuario WHERE nome LIKE '%$nome%' ";
    $resultado = mysqli_query($conection, $query);
    $registros = mysqli_fetch_array($resultado);


    return $registros;
}

function busca_usuario_id($id_usuario) {

    $conection = mysqli_connect('localhost', 'root');
    mysqli_select_db($conection, 'gac');

    $query = "SELECT * FROM  usuario WHERE id_usuario='$id_usuario' ";
    $resultado = mysqli_query($conection, $query);
    $registros = mysqli_fetch_array($resultado);


    return $registros;
}


function deleta_usuario(){
    
  $query = "DELETE FROM usuario  WHERE  id_usuario='$id_usuario' ";
  mysqli_query($conection, $result);
  
}