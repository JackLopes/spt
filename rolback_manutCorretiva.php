<?php

$id_histmulta = filter_input(INPUT_GET, 'id_histmulta', FILTER_SANITIZE_NUMBER_INT);
$id_contrato = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
require 'database_gac.php';


//  tabela historico (excluir) // tabela multa (retornar status incluir)



$sqlcorre = "SELECT id_multas FROM  historico_multa WHERE id_histmulta = '$id_histmulta'";
$resultado = mysqli_query($conection, $sqlcorre)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado)) {
    $id_multas = $registro['id_multas'];

    $id_ex = explode(",", $id_multas);
    $num_id = count($id_ex);

    for ($v = 0; $v < $num_id; $v++) {


        $q1 = "UPDATE multa SET  status='2' WHERE id_multa='$id_ex[$v]'";
        $r1 = mysqli_query($conection, $q1);

        $result = "DELETE FROM soma_atraso_item  WHERE id_multa='$id_ex[$v]'";
         mysqli_query($conection, $result);
    }
}


$result = "DELETE FROM historico_multa  WHERE id_histmulta='$id_histmulta'";
mysqli_query($conection, $result);




header("Location: corretivaMultas.php?id=$id_contrato");


