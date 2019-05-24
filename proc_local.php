
<?php

session_start();

session_start();

$permissa = $_SESSION['permissao'];

$page_title = 'Informação Prestador';

require_once 'database_gac.php';
require_once 'Funcoes/func_data.php';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$ct = filter_input(INPUT_GET, 'ct', FILTER_SANITIZE_NUMBER_INT);
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$ct = filter_input(INPUT_POST, 'ct', FILTER_SANITIZE_NUMBER_INT);



if ($permissa < '4') {
    if (isset($_POST['submitted'])) {
        $erro = array();

        

        if (empty($_POST['tipos'])) {
            $erro[] = 'Informar o TIPO.';
        } else {
            $tip = mysqli_real_escape_string($conection, trim($_POST['tipos']));
            $tip1 = ucwords(strtolower($tip));
        }


       



        if (empty($erro)) {



            $q = "SELECT * FROM tipo WHERE id_local = '$id'  AND tipos = '$tip' ";
            $r = mysqli_query($conection, $q);
            $num = mysqli_num_rows($r);

            if ($num == 0) {


                $q = "INSERT INTO tipo (id_local, tipos,lugar_regional ) VALUES ('$id', '$tip','$lg' )";
                $r = mysqli_query($conection, $q);


                if ($q) {
                    $_SESSION['msg15'] = "<p style='color:green;'> Grupo de " . $tip1 . " cadastrado  com sucesso!</p>";
                    header("Location: inf_local2.php?id=$id&ct=$ct");
                } else {
                    $_SESSION['msg15'] = "<p style='color:red;'> Não foi possivel cadastrar o Grupo de  $tip1 </p>";
                    header("Location: inf_local2.php?id=$id&ct=$ct");
                }
            } else {
                $_SESSION['msg15'] = "<p style='color:red;'> Já há um Grupo de " . $tip1 . " cadastrado </p>";
                header("Location: inf_local2.php?id=$id&ct=$ct");
            }
        } else {
            foreach ($erro as $mg) {

                $_SESSION['msg15'] = "<p style='color:red;'>$mg</p>";
                header("Location: inf_local2.php?id=$id&ct=$ct");
            }
        }
    }
} else {

    $_SESSION['msg15'] = "<p style='color:red;'> Você não tem permissão para cadastrar registro</p>";
    header("Location: inf_local.php?id=$id&ct=$ct");
}
  


	