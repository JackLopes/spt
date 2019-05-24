<?php
session_start();
/*
if ($_SESSION['status'] != 'LOGADO') {
    header("Location: login.php");
}*/

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
   "<script>
    window.cose();
   </script>";
} else {
    $_SESSION['registro'] = time();
}
?>
<nav class="navbar navbar-expand-lg   navbar-dark bg-dark " style="padding: 20px;">
    <a class="navbar-brand"  href="#">GERIR CONTRATAÇÃOES</a>

    <div class="collapse navbar-collapse" id="navbarNav">


    </div>
    <ul  class="nav navbar-nav navbar-right">
        <li>  <a style=" font-size:15px;color: #FFF;"class="navbar-brand btn btn-success" href="Painel.php"><i class="fas fa-home"></i> HOME </a></li>

    </ul>
    <form class="form-inline my-2 my-lg-0"   action="lista_entidades.php" method="post">
        <input class="form-control mr-sm-2" name="nomes_busca"   type="search" placeholder="Digite o Nome" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
    </form>

</nav>