<?php
session_start();

if ($_SESSION['status'] != 'LOGADO') {
    header("Location: login.php");
}

$registro = $_SESSION['registro'];
$limite = $_SESSION['limite'];

if ($registro) {// verifica se a session  registro esta ativa
    $segundos = time() - $registro;
}
// fim da verificação da session registro

/* verifica o tempo de inatividade 
  se ele tiver ficado mais de 900 segundos sem atividade ele destroi a session
  se não ele renova o tempo e ai é contado mais 900 segundos */
if ($segundos > $limite) {
    session_destroy();


    unset($_SESSION['id'], $_SESSION['nome'], $_SESSION['email'], $_SESSION['permissao'], $_SESSION['matricula'], $_SESSION['status']);
    header("Location: login.php");
} else {
    $_SESSION['registro'] = time();
}
?>
<nav class="navbar navbar-expand-lg   navbar-dark bg-dark ">
    <a class="navbar-brand"  href="#">GERIR CONTRATAÇÃOES</a>

    <div class="collapse navbar-collapse" id="navbarNav">


    </div>
    <ul class="nav navbar-nav navbar-right">
        <li class="d-none d-xl-block nav-item" style="list-style-type: none;">
           <li> <a style="margin-left:-8px; margin-right: 5px;" class="btn btn-danger" href=""  onclick="opener.location.reload(); window.close();">FECHAR</a></li>
        </li>

    </ul>

</nav>
