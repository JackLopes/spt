<?php

require_once 'database_gac.php';


$id = filter_input(INPUT_POST, 'id_presta', FILTER_SANITIZE_NUMBER_INT);
$ct = filter_input(INPUT_POST, 'ct', FILTER_SANITIZE_NUMBER_INT);
$id_user = filter_input(INPUT_POST, 'id_usuario', FILTER_SANITIZE_NUMBER_INT);

var_dump($id);

session_start();

if (isset($_POST['submitted'])) {

    $user = "SELECT * FROM usuario WHERE id_usuario= '$id_user'";
    $resultado_user = mysqli_query($conection, $user);
    while ($row = mysqli_fetch_assoc($resultado_user)) {


        $nom = $row['nome'];     
        $fun = $row['funcao'];
        $email = $row['email'];
        $celular = $row['celular'];
        $tel = $row['telefone'];
        $cel = $row['celular'];
    }


/*
    $q = "SELECT email FROM colaborador WHERE email = '$email' AND id_presta = '$id' AND id_contrato = '$ct' ";
    $r = mysqli_query($conection, $q);
    $num = mysqli_num_rows($r);


    if ($num == 0) {

*/

        $query = "INSERT INTO colaborador ( id_presta, nome,funcao, email, telefone,  celular, id_contrato ) VALUES ('$id', '$nom',
	'$fun', '$email','$tel','$cel', '$ct' )";

        $r1 = mysqli_query($conection, $query);

        if (mysqli_insert_id($conection)) {

            $_SESSION['msg37'] = $usu . "<p style='color:green;'> Registro cadastrado com sucesso </p>";

             header("Location:inf_prestador2.php?id=$id&ct=$ct");
        } else {
            $_SESSION['msg37'] = "<p style='color:red;'>Não foi possivel efetuar  cadastrado </p>";

              header("Location:inf_prestador2.php?id=$id&ct=$ct");
        }
  /*  } else {

        $_SESSION['msg37'] = "<p style='color:red;'>Preposto já foi cadastrado </p>";

        header("Location:inf_prestador2.php?id=$id&ct=$ct");
    }*/
}
