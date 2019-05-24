<?php

$id_itens = filter_input(INPUT_GET, 'id_itens', FILTER_SANITIZE_NUMBER_INT);
$id_tipo = filter_input(INPUT_GET, 'id_tipo', FILTER_SANITIZE_NUMBER_INT);



include_once 'database_gac.php';

//obtem   a maior data do prazo de entrega

$q = "SELECT prorrogacao FROM aceite WHERE id_iten = '$id_itens' ";
$r = mysqli_query($conection, $q);

while ($register = mysqli_fetch_assoc($r)) {
    $prorrogacaos = array();
    $prorrogacaos[] = $register ['prorrogacao'];
    $prorrogacao_max = max($prorrogacaos);
}

// atualiza a tabela aceite 
$result2 = "UPDATE  aceite  SET   prorrogacao ='$prorrogacao_max' WHERE id_iten='$id_itens'";
$resultado2 = mysqli_query($conection, $result2) or die(mysqli_error($conection));


// faz o calculo automatico
$i = 0;

$sq5 = "SELECT id_aceite, prorrogacao, entrega  FROM aceite WHERE id_iten = '$id_itens'";
$result = mysqli_query($conection, $sq5)or die('Não foi possivel conectar ao MySQL');
while ($registro5 = mysqli_fetch_array($result)) {

    $id_aceite[$i] = $registro5['id_aceite'];
    $entrega[$i] = $registro5['entrega'];
    $prorrogacao[$i] = $registro5['prorrogacao'];



    $atraso_dias[$i] = (( strtotime($entrega[$i]) / 86400) - (strtotime($prorrogacao[$i]) / 86400));



    if ($atraso_dias[$i] < 0) {
        $atraso_dias[$i] = 0;
        $aplicacao_multa[$i] = 0;
    } else if ($atraso_dias[$i] > 0) {
        $aplicacao_multa[$i] = 3;
        $atraso_dias[$i] = (int) $atraso_dias[$i];
    }


    $result1 = "UPDATE  aceite  SET  atraso_dias='$atraso_dias[$i]' ,aplicacao_multa ='$aplicacao_multa[$i]' WHERE id_aceite='$id_aceite[$i]'";
    $resultado = mysqli_query($conection, $result1) or die(mysqli_error($conection));

    $i = $i + 1;
}

// atualiza o atraso na tabela item para atualizar o status

$sq6 = "SELECT SUM(atraso_dias) AS atraso_dias_itens  FROM aceite WHERE id_iten = '$id_itens'";
$result6 = mysqli_query($conection, $sq6)or die('Não foi possivel conectar ao MySQL');
while ($registro6 = mysqli_fetch_array($result6)) {


    $atraso_dias_itens = (int) $registro6['atraso_dias_itens'];
    
    $result3 = "UPDATE  itens  SET  atraso_dias='$atraso_dias_itens' WHERE  id_itens='$id_itens'";
    $resultado = mysqli_query($conection, $result3);
}

//retorna para a pagina de origem



header("Location:cad_aceite2.php?id_itens=$id_itens&id_tipo=$id_tipo");




