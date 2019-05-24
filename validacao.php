
<?php

session_start();

require_once 'database_gac.php';

$matri = filter_input(INPUT_POST, 'matricula', FILTER_SANITIZE_STRING);
$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

if ((isset($matri)) && (isset($senha))) {

    $senha3 = md5($senha);

    $q = "SELECT * FROM usuario WHERE matricula = '$matri' && senha = '$senha3' LIMIT 1";
    $r = mysqli_query($conection, $q);

    $num = mysqli_fetch_assoc($r);

    if (empty($num)) {
        $_SESSION['loginErro'] = "USUÁRIO OU SENHA INVÁLIDO";
        header("Location: login.php");
    } elseif (isset($num)) {

        $tempolimite = 2000;
//fim das configurações de fusu horario e limite de inatividade//
// aqui ta o seu script de autenticação no momento em que ele for validado você seta as configurações abaixo.//
// seta as configurações de tempo permitido para inatividade//
        $_SESSION['registro'] = time(); // armazena o momento em que autenticado //
        $_SESSION['limite'] = $tempolimite; // armazena o tempo limite sem atividade //
// fim das configurações de tempo inativo//


        $_SESSION['status'] = 'LOGADO';
        header("Location: unica.php");

        $q = "SELECT * FROM usuario WHERE matricula = '$matri' && senha = '$senha3' LIMIT 1";
        $resultado = mysqli_query($conection, $q);
        While ($registro = mysqli_fetch_array($resultado)) {

            $_SESSION['nome'] = $registro['nome'];
            $_SESSION['id_usuario'] = $registro['id_usuario'];
            $_SESSION['matricula'] = $registro['matricula'];
            $_SESSION['permissao'] = $registro['permissao'];
        }

        $nom = $_SESSION['nome'];

        $data['atual'] = date('Y-m-d H:i:s');

        //Diminuir 1 minuto, contar usuário no site no último minuto
        //$data['online'] = strtotime($data['atual'] . " - 1 minutes");
        //Diminuir 20 segundos 
        $data['online'] = strtotime($data['atual'] . " - 20 seconds");
        $data['online'] = date("Y-m-d H:i:s", $data['online']);

        $result_visitas = "INSERT INTO visitas (data_inicio, data_final,nome)VALUES ('" . $data['atual'] . "', '" . $data['atual'] . "', '$nom')";

        $resultado_visitas = mysqli_query($conection, $result_visitas);

        $_SESSION['visitante'] = mysqli_insert_id($conection);
    } else {

        $_SESSION['loginErro'] = "USUÁRIO OU SENHA INVÁLIDO";
        header("Location: login.php");
    }
} else {
    $_SESSION['loginErro'] = "USUÁRIO OU SENHA INVÁLIDO";
    header("Location: login.php");
}
	
