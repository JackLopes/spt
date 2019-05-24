<?php
session_start();


$assunt = '';
?>



<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <!doctype html>
    <html lang="pt">

        <head>
            <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
            <link rel="stylesheet"  ttype="text/css"  href="css/styleindex.css" media="screen"/>
            <link rel="stylesheet" href="css/bootstrap.css" >
            <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>

        </head>
        <body>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <span><h5>GERIR CONTRATAÇÕES</h5></span>

                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-item nav-link active" style="margin-left: 20px;" href="login.php">Login<span class="sr-only">(current)</span></a>

                    </div>
                </div>
            </nav>
            <div class="container">
                <div class="img5" style="margin-top: 30px;">
                    <?php require_once 'image_header6.php'; ?>         
                </div>



                <hr>
                <div>
                    <?php
                    if (isset($_SESSION['msg3'])) {
                        echo $_SESSION['msg3'];
                        unset($_SESSION['msg3']);
                    }
                    ?>   
                    <form method="post" action="cad_visitante.php"   autocomplete="off"  id="formCadastrarse">
                        <div class="row">
                            <div class="col-md-12 mb-10">
                                <label for="firstName">NOME:</label>
                                <input class="form-control" Type="text" name="nome" size="100"  value="<?php if (isset($_SESSION['dados']['nome'])) echo $_SESSION['dados']['nome']; ?>" required>	
                            </div>  
                        </div>   
                        <div class="row">

                            <div class="col-md-6 mb-10">
                                <label for="firstName">EMAIL:</label>
                                <input class="form-control" Type="email" name="email" size="40" value="<?php if (isset($_SESSION['dados']['email'])) echo $_SESSION['dados']['email']; ?>" required> 	
                            </div>
                            <div class="col-md-6 mb-10">
                                <label for="firstName">	CELULAR:</label>
                                <input class="form-control" Type="text" name="celular" size="40" value="<?php if (isset($_SESSION['dados']['celular'])) echo $_SESSION['dados']['celular']; ?>" required>
                            </div>        
                        </div > 
                        <div class="row">
                            <div class="col-md-6 mb-10">
                                <label for="firstName">TELEFONE:</label>
                                <input class="form-control" Type="text" name="telefone" size="100"  value="<?php if (isset($_SESSION['dados']['telefone'])) echo $_SESSION['dados']['telefone']; ?>" required>            
                            </div>
                            <div class="col-md-6 mb-10">
                                <label for="address">FUNÇÃO:</label>			  
                                <input class="form-control" Type="text" name="funcao" size="40" value="<?php if (isset($_SESSION['dados']['funcao'])) echo $_SESSION['dados']['funcao']; ?>" required>            
                            </div>
                        </div>
                        <div class="cadast row"  >
                            <div class="col-md-6 mb-10   div1" id="div4">
                                <label for="address"> LOTAÇÃO:</label>			  
                                <input class="form-control" Type="text" name="lotacao"  value="<?php if (isset($_SESSION['dados']['lotacao'])) echo $_SESSION['dados']['lotacao']; ?>" required>            
                            </div>
                            <div class="col-md-6 mb-10   div1" id="div6">
                                <label for="cmatricula">MATRICULA:</label>
                                <input class="form-control" Type="text" name="matricula" size="40"  id="cmatricula" autocomplete="off" value="<?php if (isset($_SESSION['dados']['matricula'])) echo $_SESSION['dados']['matricula']; ?>" required>	
                            </div>  
                       
                        </div>
                        <div class=" row">
                            <div  class=" col-md-12 mb-10">
                                <label for="firstName">SENHA:</label>
                                <input type="password" class="form-control" id="senha"  autocomplete="off" name="senha" placeholder="Senha" required="requiored">
                            </div>
                        </div>
                        <div class="modal-footer">

                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                       
                    </form>
                </div>
            </div>
        </body>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </html>
