<?php

session_start();
require_once 'database_gac.php';
require_once 'Funcoes/limpa_string.php';

function limpatel($valor) {
    $valor = trim($valor);
    $valor = str_replace("-", "", $valor);
    $valor = str_replace("(", "", $valor);
    $valor = str_replace(")", "", $valor);

    return $valor;
}

$permissa = $_SESSION['permissao'];

$id_usuario = filter_input(INPUT_POST, 'id_usuario', FILTER_SANITIZE_STRING);
$matricula = filter_input(INPUT_POST, 'matricula', FILTER_SANITIZE_STRING);

$nom = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$fun1 = filter_input(INPUT_POST, 'funcao', FILTER_SANITIZE_STRING);
$tel = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_NUMBER_INT);
$celular = filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_NUMBER_INT);
$lot = filter_input(INPUT_POST, 'lotacao', FILTER_SANITIZE_STRING);
$empresa = filter_input(INPUT_POST, 'empresa', FILTER_SANITIZE_STRING);
$empresa1 = filter_input(INPUT_POST, 'empresa1', FILTER_SANITIZE_NUMBER_INT);
$id_prestador = filter_input(INPUT_POST, 'id_prestador', FILTER_SANITIZE_NUMBER_INT);
$palavra_busca = filter_input(INPUT_POST, 'palavra_busca', FILTER_SANITIZE_STRING);
$permissao = filter_input(INPUT_POST, 'permissao', FILTER_SANITIZE_NUMBER_INT);
$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
$senha2 = filter_input(INPUT_POST, 'senha2', FILTER_SANITIZE_STRING);
$admin = filter_input(INPUT_POST, 'admin', FILTER_SANITIZE_STRING);
//var_dump($id_usuario);

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$_SESSION['dados'] = $dados;

if(!empty($id_usuario)) {

if (!empty($_REQUEST['action'] == 'update')) {

    if (isset($_POST['submitted'])) {

        $erro = array();

        if ($empresa1 == 1) {

            $empresa = 'Serviço Federal de Processamento de Dados';
        }

        if (empty($empresa)) {
            $erro[] = 'Informar se a pessoa e do SERPRO ou não';
        }


        if (empty($nom)) {
            $erro[] = 'Digite o nome.';
        } else if (strlen($nom) < 8) {
            $erro[] = "Preencha o nome com no mínimo 8 caracteres.";
        } else {
            $nom = limpa(mysqli_real_escape_string($conection, trim($nom)));
        }

        if (empty($email)) {
            $erro[] = 'Informar o email.';
        } else {
            $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        }


        if (!empty($fun)) {
            $fun = limpa(mysqli_real_escape_string($conection, trim($fun)));
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

        if ($empresa1 == 1) {
            if (empty($lot)) {
                $erro[] = 'Informar o lotacao.';
            } else if (!is_string($lot)) {
                $erro[] = 'Preencha corretamente por favor!!!.';
            } else if (strlen($lot) > 30) {
                $erro[] = "Preencha a lotação  com no maximo 25 caracteres.";
            }

            if (empty($matricula)) {
                $erro[] = 'Digite a matricula.';
            } else if (strlen($matricula) < 8) {
                $erro[] = "Preencha a matricula  com no mínimo 8 caracteres.";
            } else {
                $matricula = mysqli_real_escape_string($conection, trim($matricula));
            }
        } else {

            $lot = "Não se aplica";

            $matricula = "Não se aplica";
        }

        $fun = limpa($fun1);
        $nom = limpa($nom);
        $tel = limpatel($tel);
        $celular = limpatel($celular);
        $matricula = limpatel($matricula);
        $empresa = limpa($empresa);

        if (empty($erro)) {

            var_dump($matricula);

            $q1 = "UPDATE usuario SET  nome='$nom', lotacao='$lot', funcao='$fun', email='$email',
               telefone='$tel', celular='$celular', matricula='$matricula', empresa='$empresa' WHERE id_usuario='$id_usuario'";
            $r1 = mysqli_query($conection, $q1);

            var_dump($r1);

            if ($r1) {
                $_SESSION['msg40'] = "<p class='alert alert-secondary' style='color:green;'> Colaborador atualizado com sucesso </p>";
                header("Location: lista_usuario.php?id_usuario=$id_usuario&action=update");
            } else {
                $_SESSION['msg40'] = "<p class='alert alert-danger' style='color:green;'> O colaborador não foi atualizado </p>";
                header("Location:lista_usuario.php?id_usuario=$id_usuario&action=update");
            }
        } else {
            foreach ($erro as $mg) {

                $_SESSION['msg40'] = "<p class='alert alert-danger' style='color:red;'>$mg</p>";
                header("Location:lista_usuario.php?id_usuario=$id_usuario&action=update");
            }
        }
    }
}

//Atualiza senha

if (!empty($_REQUEST['action'] == 'updatesenha')) {

    if (!empty($senha)) {


        if ($senha == $senha2) {

            $senha3 = md5($senha2);


            $q = "UPDATE usuario  SET senha='$senha3' WHERE id_usuario='$id_usuario' ";

            $r = mysqli_query($conection, $q)or die(mysqli_error($conection));


            if (!empty($admin)) {

                if ($r) {

                    $_SESSION['msg42'] = "<p style='color:green;'> Senha atualizada com sucesso ! </p>";

                    header("Location:lista_usuario.php?id_usuario=$id_usuario&action=update");
                    exit();
                } else {
                    $_SESSION['msg42'] = "<p style='color:red;'> Sua Senha não foi atualizada!</p>";
                    header("Location:lista_usuario.php?id_usuario=$id_usuario&action=update");
                }
            }

            if ($r) {

                $_SESSION['msg40'] = "<p style='color:green;'> Senha atualizada com sucesso ! </p>";

                header("Location:lista_usuario.php");
            } else {
                $_SESSION['msg40'] = "<p style='color:red;'> Sua Senha não foi atualizada!</p>";
                header("Location:lista_usuario.php?id_usuario=$id_usuario&action=update");
            }
        } else if (!empty($admin)) {
            $_SESSION['msg40'] = "<p style='color:red;'> Confirmação da senha diferente, tente novamente!</p>";
            header("Location:lista_usuario.php?id_usuario=$id_usuario&action=update");
        } else {
            $_SESSION['msg40'] = "<p style='color:red;'> Senha desiguais, tente novamente!</p>";
            header("Location:lista_usuario.php?id_usuario=$id_usuario&action=update");
        }
    } else if (!empty($admin)) {
        $_SESSION['msg40'] = "<p style='color:red;'>Digite a senha!</p>";
        header("Location:lista_usuario.php?id_usuario=$id_usuario&action=update");
    } else {
        $_SESSION['msg40'] = "<p style='color:red;'>Digite a senha!</p>";
        header("lista_usuario.php?id_usuario=$id_usuario&action=update");
    }
}
//atualiza permissaao
if (!empty($_REQUEST['action'] == 'updatepermissao')) {

    if (!empty($permissao)) {

        $q = "UPDATE usuario  SET permissao='$permissao' WHERE id_usuario='$id_usuario' ";

        $r = mysqli_query($conection, $q)or die(mysqli_error($conection));

        if ($r) {


            $_SESSION['msg43'] = "<p style='color:green;'> Permissão atualizada com sucesso ! </p>";

            header("Location:lista_usuario.php?id_usuario=$id_usuario&action=update");
        } else {
            $_SESSION['msg43'] = "<p style='color:red;'> Permissão não foi atualizada!</p>";
            header("Location:lista_usuario.php?id_usuario=$id_usuario&action=update");
        }
    } else {
        $_SESSION['msg43'] = "<p style='color:red;'> Insira a Permissão !</p>";
        header("Location:lista_usuario.php?id_usuario=$id_usuario&action=update");
    }
}


} else {
      $_SESSION['msg40'] = "<p style='color:red;'> Selecione um usuário</p>";
        header("Location:lista_usuario.php");
}



if (!empty($_REQUEST['action'] == 'salva')) {

    if (isset($_POST['submitted'])) {
        $erro = array();


        if ($empresa1 == 1) {

            $empresa = 'Serviço Federal de Processamento de Dados';
        }

        if (empty($empresa)) {
            $erro[] = 'Informar se a pessoa e do SERPRO ou não';
        }

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

        if ($empresa1 == 1) {
            if (empty($lot)) {
                $erro[] = 'Informar o lotacao.';
            } else if (!is_string($lot)) {
                $erro[] = 'Preencha corretamente por favor!!!.';
            } else if (strlen($lot) > 20) {
                $erro[] = "Preencha a lotação corretamente.";
            }

            if (empty($matricula)) {
                $erro[] = 'Digite a matricula.';
            } else if (strlen($matricula) < 8) {
                $erro[] = "Preencha a matricula  com no mínimo 8 caracteres.";
            } else {
                $matricula = mysqli_real_escape_string($conection, trim($matricula));
            }
        } else {

            $lot = "Não se aplica";
            $matricula = "Não se aplica";
            $q1 = "SELECT * FROM  prestador WHERE id_prestador = '$id_prestador'";
            $r1 = mysqli_query($conection, $q1);
            while ($row = mysqli_fetch_assoc($r1)) {
                $empresa = $row['nome'];
            }
        }

        $fun = limpa($fun1);
        $nom = limpa($nom);
        $tel = limpatel($tel);
        $celular = limpatel($celular);
        $matricula = limpatel($matricula);
        $empresa = limpa($empresa);


        if (empty($erro)) {

            if ($empresa1 == 1) {
                $q = "SELECT email FROM usuario WHERE email = '$email' AND empresa= '$empresa'";
                $r = mysqli_query($conection, $q);
                $num = mysqli_num_rows($r);
                var_dump($num);
            } else {
                $num = 0;
            }


            if ($num == 0) {

                $q1 = "INSERT INTO usuario ( nome, lotacao, funcao, email, telefone, celular, senha, matricula, empresa ) VALUES ('$nom', '$lot',
	'$fun', '$email','$tel','$celular',' ','$matricula', '$empresa' )";
                $r1 = mysqli_query($conection, $q1);

                if (!empty($id_prestador)) {
                    $query = "INSERT INTO colaborador ( id_presta, nome,funcao, email, telefone,  celular, id_contrato ) VALUES ('$id_prestador', '$nom',
	'$fun', '$email','$tel','$celular', '' )";
                    $r2 = mysqli_query($conection, $query);
                }
                if ($q1) {
                    $_SESSION['msg40'] = "<p class='alert alert-secondary' style='color:green;'> Colaborador salvo com sucesso </p>";
                    header("Location: lista_usuario.php");
                } else {
                    $_SESSION['msg40'] = "<p class='alert alert-danger' style='color:green;'> O colaborador não foi salvo </p>";
                    header("Location: lista_usuario.php");
                }
            } else {
                $_SESSION['msg40'] = "<p class='alert alert-secondary' style='color:red;'> Colaborador já cadastrado </p>";
                header("Location: lista_usuario.php");
            }
        } else {
            foreach ($erro as $mg) {

                $_SESSION['msg40'] = "<p class='alert alert-danger' style='color:red;'>$mg</p>";
                header("Location: lista_usuario.php");
            }
        }
    }
}

if (!empty($_REQUEST['action'] == 'deleta_usuario')) {
    
    
}