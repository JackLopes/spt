<?php
session_start();
$id_usuario = $_SESSION['id_usuario'];
$nome = $_SESSION['nome'];

$assunt =  $nome  ;
$nome
?>

<!DOCTYPE html>

<html>
    <!doctype html>
    <html lang="pt">

        <head>
            <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
            <link rel="stylesheet"  ttype="text/css"  href="css/styleindex.css" media="screen"/>
            <link rel="stylesheet" href="css/bootstrap.css" >
            <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
              <script defer src="js/fontawesome-all.min.js"></script>
            <style>
                .Assunt{
                    position:absolute;
                    margin-top: -130px;
                    margin-left: 50px;
                    color:white;
                    font-size: 150%;

                }
                
            </style>
        </head>
        <body>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <span><h5>GERIR CONTRATOS</h5></span>

                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-item nav-link active" style="margin-left: 20px;" href="#"><span class="sr-only">(current)</span></a>

                    </div>
                </div>
            </nav>
            <div class="container">

                <div class="img5" style="margin-top: 30px;">
                    <?php require_once 'image_header6.php'; ?>         
                </div>
                <div>
                    <?php
                    if (isset($_SESSION['msg12'])) {
                        echo $_SESSION['msg12'];
                        unset($_SESSION['msg12']);
                    }
                    ?>   
                    <hr>
                    <form id="frmRegistro" action="cad_visitante.php?action=update" method="post">
                        <div class="row">
                            <div class="col-md-6 mb-10">
                                <label for="csenha"><i class='fas fa-key'></i> NOVA SENHA:</label>
                                <input class="form-control" type="password" name="senha" size="20" maxlength="20" />
                            </div>
                            <div class="col-md-6 mb-10">
                                <label for="csenha2"><i class='fas fa-key'></i> CONFIRMA SENHA:</label>
                                <input class="form-control" type="password" name="senha2" size="20" maxlength="20" />
                            </div>
                        </div><br>

                        <div class="modal-footer">
                            <input name="id_usuario" type="hidden" value=<?php echo $id_usuario; ?>> 

                            <button type="button" id="registro" class="btn btn-secondary" data-dismiss="modal" onClick= "window.close()">Fechar</button>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </body>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </html>
