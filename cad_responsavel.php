

<?php

session_start();

$permissa = $_SESSION['permissao'];


require_once 'database_gac.php';


$id = filter_input(INPUT_POST, 'id_local', FILTER_SANITIZE_NUMBER_INT);
$id_contrato = filter_input(INPUT_POST, 'id_contrato', FILTER_SANITIZE_NUMBER_INT);
$id_user = filter_input(INPUT_POST, 'id_usuario', FILTER_SANITIZE_NUMBER_INT);
$resp = filter_input(INPUT_POST, 'responsabilidade', FILTER_SANITIZE_STRING);
$sigla = filter_input(INPUT_POST, 'sigla', FILTER_SANITIZE_STRING);



$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$_SESSION['dados'] = $dados;

if (!empty($_REQUEST['action'] == 'local')) {
    if ($permissa < '4') {
        if (isset($_POST['submitted'])) {


            $user = "SELECT * FROM usuario WHERE id_usuario= '$id_user'";
            $resultado_user = mysqli_query($conection, $user);
            while ($row = mysqli_fetch_assoc($resultado_user)) {

                $nom = $row['nome'];
                $lot = $row['lotacao'];
                $fun = $row['funcao'];
                $email = $row['email'];
                $matricula = $row['matricula'];
                $tel = $row['telefone'];
            }

            $q = "SELECT email FROM responsaveis WHERE email = '$email' AND id_local = '$id ' ";
            $r = mysqli_query($conection, $q);
            $num = mysqli_num_rows($r);

            if ($num < 1) {


                $query = "INSERT INTO responsaveis (nome, area, funcao, email, matricula, telefone, id_local, responsabilidade,id_contrato, sigla ) VALUES ('$nom', '$lot',
	'$fun', '$email','$matricula','$tel','$id', '$resp', '$id_contrato', '$sigla' )";

                $r1 = mysqli_query($conection, $query);
                if (mysqli_insert_id($conection)) {

                    $_SESSION['msg'] = $usu . "<p style='color:green;'> Colaborador cadastrado com sucesso </p>";

                    header("Location:inf_local2.php?id=$id&ct=$id_contrato");
                } else {
                    $_SESSION['msg'] = "<p style='color:red;'>Não foi possivel efetuar  cadastrado </p>";

                     header("Location:inf_local2.php?id=$id&ct=$id_contrato");
                }
            } else {

                $_SESSION['msg'] = "<p style='color:red;'>Colaborador já foi cadastrado </p>";

                 header("Location:inf_local2.php?id=$id&ct=$id_contrato");
            }
        }
    } else {

        $_SESSION['msg'] = "<p style='color:red;'> Você não tem permissão para cadastrar registro</p>";
        header("Location:inf_local2.php?id=$id&ct=$id_contrato");
    }
} else if (!empty($_REQUEST['action'] == 'idex')) {

    if ($permissa < '4') {

        if (isset($_POST['submitted'])) {


            $user = "SELECT * FROM usuario WHERE id_usuario= '$id_user'";
            $resultado_user = mysqli_query($conection, $user);
            while ($row = mysqli_fetch_assoc($resultado_user)) {


                $nom = $row['nome'];
                $lot = $row['lotacao'];
                $fun = $row['funcao'];
                $email = $row['email'];
                $matricula = $row['matricula'];
                $tel = $row['telefone'];
            }



            $q = "SELECT email FROM responsaveis WHERE email = '$email' AND id_contrato = '$id_contrato' ";
            $r = mysqli_query($conection, $q);
            $num = mysqli_num_rows($r);


            if ($num == 0) {


                $query = "INSERT INTO responsaveis (nome, area, funcao, email, matricula, telefone, id_local, responsabilidade, id_contrato ) VALUES ('$nom', '$lot',
	'$fun', '$email','$matricula','$tel',' ', '$resp', '$id_contrato' )";

                $r1 = mysqli_query($conection, $query) or die(mysqli_error($conection));

                if ($r1) {



                    $_SESSION['msg23'] = "<p style='color:green;'> Colaborador cadastrado com sucesso </p>";

                    header("Location:idex.php?id=$id_contrato");
                } else {
                    $_SESSION['msg23'] = "<p style='color:red;'>Não foi possivel efetuar  cadastrado </p>";

                    header("Location:idex.php?id=$id_contrato");
                }
            } else {

                $_SESSION['msg23'] = "<p style='color:red;'>Colaborador já foi cadastrado </p>";

                header("Location:idex.php?id=$id_contrato");
            }
        }
    } else {

        $_SESSION['msg23'] = "<p style='color:red;'> Você não tem permissão para cadastrar registro</p>";
        header("Location:idex.php?id=$id_contrato");
    }
}