<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Login</title>		
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">	
        <link rel="stylesheet"  type="text/css" href="css/stylelog.css" />
        <link rel="stylesheet" href="css/bootstrap.css" >
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <script>
           $(document).ready(function(){ $('input[type="text"], select').val('') }); 
        </script>

    </head>
    <body style="background-color: #343a40;" >
        <div class="figuretion">
            <img src="img/img_serpro5.jpg">
        </div>
        <div class="information">
            <form class="form-signin" name= "loginform" method="post"  autocomplete="off"   action="validacao.php" autocomplete="off" >
                <div class="islogan mb-4">
                    <img class="mb-4" src="img/serpro5.jpg" alt="" width="72" height="72">
                    <h1 class="h3 mb-3 font-weight-normal">SUPGA </h1>
                    <p>GERIR CONTRATAÇÕES</p>
                </div>

                <label for="inputEmail" class="sr-only ">Matricula</label>
                <input type="text" id="inputEmail" name="matricula" class="form-control text-center" placeholder="Matrícula" required autofocus>


                <label for="inputPassword" class="sr-only ">Senha</label>
                <input type="password" name="senha"  id="inputPassword"  autocomplete="off"   class="form-control text-center" placeholder="Senha" required>



                <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
                <p class="mt-5 mb-3 text-muted">&copy; 2018-2019	  </p>	  
                <div class="form-label-group">
                    <?php
                    if (isset($_SESSION['loginErro'])) {
                        echo $_SESSION['loginErro'];
                        unset($_SESSION['loginErro']);
                    }
                    ?>
                   
                </div>
            </form>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a  href="" data-toggle="modal" data-target="#Recuperar" href="#">Esqueci A Senha</a>
                </li>
                <li class="nav-item">
                    <a   href="inf_visitante.php" >Cadastre-se</a>
                </li>

            </ul>

        </div>

        <!-- Modal -->
        <div class="modal fade" id="Recuperar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle"> ESQUECI MINHA SENHA</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <P> Entre em contato. Tel: (11)2173-1415 ou (11)2173-1396 </P>


                        </form>
                        <?php
                        if (isset($_SESSION['dados'])) {
                            unset($_SESSION['dados']);
                        }
                        ?>
                    </div>

                </div>
            </div>
        </div>

        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script defer src="js/fontawesome-all.min.js"></script>
        <script src="scripts/controller/LogController.js"></script>
        <script src="scripts/move.js"></script>
        
    </body>
</html>
