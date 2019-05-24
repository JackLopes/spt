<?php
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
    header("Location: sessao.php");
} else {
    $_SESSION['registro'] = time();
}
?>
        <style>
            a{
                font-family: times new roman;

            }

            html,
            body {
               

            }

            body {


                text-shadow: 0 .05rem .1rem rgba(0, 0, 0, .2);
                box-shadow: inset 0 0 5rem rgba(0, 0, 0, .4);
            }
        </style>
<script defer src="js/fontawesome-all.min.js"></script>
<nav class="navbar navbar-expand-lg   navbar-light bg-light  " style="padding: 20px;">
    <a class="navbar-brand" href="#">GERIR CONTRATAÇÃOES</a>
  
    <div  class="collapse navbar-collapse" id="navbarSupportedContent">
      
       
    </div>
  
    <ul class="nav navbar-nav navbar-right">
          <a style=" font-size:15px;color: #FFF;"class="navbar-brand btn btn-success" href="Painel.php"><i class="fas fa-home"></i> HOME </a>

    </ul>
</nav>
