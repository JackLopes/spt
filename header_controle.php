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

    '<script>  Window.close(); </script>';
} else {
    $_SESSION['registro'] = time();
}
?>
<style>
     html,
            body {
               
           

            }

            body {


                text-shadow: 0 .05rem .1rem rgba(0, 0, 0, .2);
            
            }
        </style>
<nav class="navbar navbar-expand-lg   navbar-light bg-light" style="padding: 20px;">
    <a class="navbar-brand" href="#">GERIR CONTRATAÇÃOES</a>

    <div style="margin-left: 30px;"  class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">

            <li class="nav-item dropdown d-none d-xl-block ">
                <a class="nav-link dropdown-toggle" href="Painel.php" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#007bff; "><i  class="fas fa-eye"></i> Controle De Processos</a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                    <a class="dropdown-item" href="atestes.php"><font color='#df7700'><i class='fab fa-cc-visa'></i> NOTAS</font></a>
                    <a class="dropdown-item" href="controle_corretiva.php" ><font style="color:red;"><i class='fas fa-wrench'></i> CORRETIVAS</font></a>
                    <a class="dropdown-item" href="controle_itens.php"><font style="color:blue;"><i class="fas fa-eye"></i>  ITENS </font></a>
                    <a class="dropdown-item" href="controle_preventiva.php"><font style="color:green;"><i class='fas fa-wrench'></i> PREVENTIVAS (EM BREVE)</font></a>
                </div>
            </li>                    
        </ul>


    </div>
    <li class="d-none d-xl-block nav-item" style="list-style-type: none;">
        <a style=" font-size:15px;color: #FFF;"class="navbar-brand btn btn-success" href="Painel.php"><i class="fas fa-home"></i> HOME </a>
    </li>
    

</nav>

