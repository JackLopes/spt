<?php

function busca_entidade($nome) {

    $conection = mysqli_connect('localhost', 'root');
    mysqli_select_db($conection, 'gac');

    $query = "SELECT * FROM  prestador WHERE nome LIKE '%$nome%' ";
    $resultado = mysqli_query($conection, $query);
    $registros = mysqli_fetch_array($resultado);


    return $registros;
}

function busca_entidade_id($id_prestador) {

    $conection = mysqli_connect('localhost', 'root');
    mysqli_select_db($conection, 'gac');

    $query = "SELECT * FROM  prestador WHERE id_prestador='$id_prestador' ";
    $resultado = mysqli_query($conection, $query);
    $registros = mysqli_fetch_array($resultado);


    return $registros;
}


function deleta_entidade($id_prestador){
    
   $conection = mysqli_connect('localhost', 'root');
   mysqli_select_db($conection, 'gac');
    
  $query = "DELETE FROM prestador  WHERE   id_prestador='$id_prestador' ";
  mysqli_query($conection, $query);
  
}

function update_entidade ($id_prestador){
    
      // UPDATE tabela1, tabela2
       //   SET tabela1.campo = 'valor', tabela2.campo = 'valor'
       //   WHERE tabela1.campo = tabela2.campo 


        $q1 = "UPDATE prestador as tb1, filial as tb2 SET 
                 tb1.nome='$nome', tb2.nome='$nome', tb1.mnemonico='$mnemonico', tb2.mnemonico='$mnemonico',
                 tb1.cnpj='$cnpj', tb2.cnpj='$cnpj',tb1.endereco='$endereco',tb2.endereco='$endereco',
                 tb1.pais='$pais',tb1.pais='$pais', estado='$estado', cep='$cep' WHERE id_prestador='$id_prestador'";
        $r1 = mysqli_query($conection, $q1);
    
    
    
    
    
}

function lista_contatos($id_prestador){
    
    $conection = mysqli_connect('localhost', 'root');
    mysqli_select_db($conection, 'gac');

    $query = "SELECT * FROM  colaborador WHERE id_presta='$id_prestador' ";
    $resultado = mysqli_query($conection, $query);
    $registros = mysqli_fetch_array($resultado);
    
    return $registros;
}