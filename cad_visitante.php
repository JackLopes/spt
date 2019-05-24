<?php

session_start();



require_once 'database_gac.php';

$matricula = filter_input(INPUT_POST, 'matricula', FILTER_SANITIZE_STRING);
$nom = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
$fun1 = filter_input(INPUT_POST, 'funcao', FILTER_SANITIZE_STRING);
$tel = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_NUMBER_INT);
$id_usuario = filter_input(INPUT_POST, 'id_usuario', FILTER_SANITIZE_NUMBER_INT);
$celular = filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_NUMBER_INT);
$celular = filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_NUMBER_INT);
$permissao = filter_input(INPUT_POST, 'permissao', FILTER_SANITIZE_NUMBER_INT);
$lot = filter_input(INPUT_POST, 'lotacao', FILTER_SANITIZE_STRING);
$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
$senha2 = filter_input(INPUT_POST, 'senha2', FILTER_SANITIZE_STRING);
$admin = filter_input(INPUT_POST, 'admin', FILTER_SANITIZE_STRING);

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$_SESSION['dados'] = $dados;



if (!empty($_REQUEST['action'] == 'update')) {

    if (!empty($senha)) {


        if ($senha == $senha2) {

            $senha3 = md5($senha2);


            $q = "UPDATE usuario  SET senha='$senha3' WHERE id_usuario='$id_usuario' ";

            $r = mysqli_query($conection, $q)or die(mysqli_error($conection));
            

            if (!empty($admin)) {
              
                if ($r) {


                    $_SESSION['msg42'] = "<p style='color:green;'> Senha atualizada com sucesso ! </p>";

                    header("Location:atu_usuario.php?id_usuario=$id_usuario");
                    
                    exit();
                } else {
                    $_SESSION['msg42'] = "<p style='color:red;'> Sua Senha não foi atualizada!</p>";
                    header("Location:atu_usuario.php?id_usuario=$id_usuario");
                }  
            } 
          

            if ($r) {




                $_SESSION['msg12'] = "<p style='color:green;'> Senha atualizada com sucesso ! </p>";

                header("Location:cad_novasenha.php");
            } else {
                $_SESSION['msg12'] = "<p style='color:red;'> Sua Senha não foi atualizada!</p>";
                header("Location:cad_novasenha.php");
            }
        } else if (!empty($admin))  {
            $_SESSION['msg42'] = "<p style='color:red;'> Senha desiguais, tente novamente!</p>";
            header("Location:atu_usuario.php?id_usuario=$id_usuario");
        }else {
            $_SESSION['msg12'] = "<p style='color:red;'> Senha desiguais, tente novamente!</p>";
            header("Location:cad_novasenha.php");
        }
    } else if (!empty($admin)) {
        $_SESSION['msg42'] = "<p style='color:red;'>Digite a senha!</p>";
        header("Location:atu_usuario.php?id_usuario=$id_usuario");
    } else {
        $_SESSION['msg12'] = "<p style='color:red;'>Digite a senha!</p>";
        header("Location:cad_novasenha.php");
    } 
} else


if (!empty($_REQUEST['action'] == 'permissao')) {

    if (!empty($permissao)) {

        $q = "UPDATE usuario  SET permissao='$permissao' WHERE id_usuario='$id_usuario' ";

        $r = mysqli_query($conection, $q)or die(mysqli_error($conection));

        if ($r) {


            $_SESSION['msg43'] = "<p style='color:green;'> Permissão atualizada com sucesso ! </p>";

            header("Location:atu_usuario.php?id_usuario='$id_usuario'");
        } else {
            $_SESSION['msg43'] = "<p style='color:red;'> Permissão não foi atualizada!</p>";
            header("Location:atu_usuario.php?id_usuario='$id_usuario'");
        }
    } else {
        $_SESSION['msg43'] = "<p style='color:red;'> Insira a Permissão !</p>";
        header("Location:atu_usuario.php?id_usuario='$id_usuario'");
    }
} else


if (isset($matricula)) {




    $erro = array();

    $empresa = 1;

    if (empty($nom)) {
        $erro[] = 'Digite o nome.';
    } else if (strlen($nom) < 8) {
        $erro[] = "Preencha o nome com no mínimo 8 caracteres.";
    } else {
        $nom = mysqli_real_escape_string($conection, trim($nom));
    }

    if (empty($email)) {
        $erro[] = 'Informar o email.';
    } else {
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    if (!empty($fun)) {
        $fun = mysqli_real_escape_string($conection, trim($fun));
    } else {
        $fun = " Não Informados";
    }

    if (empty($tel)) {
        $erro[] = 'Informar o telefone.';
    } else if (preg_match('/^\([0-9]{2}\)?\s?[0-9]{4,5}-[0-9]{4}$/', $tel)) {
        $erro[] = 'Digite um número  de telefone válido.';
    }

    if (empty($celular)) {
        $celular = 'Não Informado.';
    } else if (preg_match('/^\([0-9]{2}\)?\s?[0-9]{4,5}-[0-9]{4}$/', $celular)) {
        $erro[] = 'Digite um número  de celular  válido.';
    }
    //1056 21001810570690110

    if ($empresa == 1) {
        if (empty($lot)) {
            $erro[] = 'Informar o lotacao.';
        } else if (!is_string($lot)) {
            $erro[] = 'Preencha corretamente por favor!!!.';
        } else if (strlen($lot) < 4) {
            $erro[] = "Preencha a lotação  com no maximo 25 caracteres.";
        }

        if (empty($matricula)) {
            $erro[] = 'Digite a matricula.';
        } else if (strlen($matricula) < 7) {
            $erro[] = "Preencha a matricula  com no mínimo 8 caracteres.";
        } else {
            $matricula = mysqli_real_escape_string($conection, trim($matricula));
        }
        $empresa = 'SERPRO';
    }

    $fun = strtoupper($fun1);




    if (empty($erro)) {

        $q = "SELECT email FROM usuario WHERE email = '$email'";
        $r = mysqli_query($conection, $q);
        $num = mysqli_num_rows($r);


        if ($num == 0) {

            $senha3 = md5($senha);

            $q1 = "INSERT INTO usuario ( nome, lotacao, funcao, email, telefone, celular, senha, matricula, empresa )"
                    . " VALUES ('$nom', '$lot',
	'$fun', '$email','$tel','$celular','$senha3','$matricula', '$empresa' )";
            $r1 = mysqli_query($conection, $q1);

            if ($r1) {



                $_SESSION['msg3'] = "<p style='color:green;'> Registro cadastrado com sucesso </p>";
                header("Location: inf_visitante.php");

                unset($_SESSION['dados']);
            } else {

                $_SESSION['msg3'] = "<p style='color:red;'> Registro não  foi cadastrado  </p>";
                header("Location: inf_visitante.php");
            }
        } else {

            $_SESSION['msg3'] = "<p style='color:red;'> Visitante já cadastrado, Volte a pagina de Login e click em Esqueci A Senha  </p>";
            header("Location: inf_visitante.php");
        }
    } else {
        foreach ($erro as $mg) {

            $_SESSION['msg3'] = "<p style='color:red;'>$mg</p>";
            header("Location: inf_visitante.php");
        }
    }
} else {
    $_SESSION['msg3'] = "<p style='color:red;'> Nesessario Matricula  </p>";
    header("Location: login.php");
}

        