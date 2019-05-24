<?php

function  db_access($id_tipo)
{
     require './database_gac.php';
    
$query = "SELECT tip.* , loc.id_contrato,loc.sigla, cont.tip_chamado, cont.tipo, cont.prazo_entrega,
				cont.rg, cont.valor_Contratado, loc.lugar_regional, loc.id_local				
				FROM tipo AS tip
				INNER JOIN local AS loc ON  loc.id_local = tip.id_local
				INNER JOIN  contrato AS cont ON  cont.id_contrato = loc.id_contrato
				WHERE id_tipo = '$id_tipo'";

$resultado = mysqli_query($conection, $query)or die('Não foi possivel conectar ao MySQL');
$access = mysqli_fetch_array($resultado);


return $access;

}