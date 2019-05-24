<?php
$page_title = 'Atualizar Colaborador';
require_once 'menu.php';
$assunt = '<i class="fas fa-user"></i> Atualizar Colaborador';

require 'database_gac.php';
$id_usuario = filter_input(INPUT_GET, 'id_usuario', FILTER_SANITIZE_NUMBER_INT);

$q_user = "SELECT * FROM usuario WHERE id_usuario = $id_usuario";
$resultado = mysqli_query($conection, $q_user)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado)) {
    
    $permissao = $registro['permissao'];
    
    switch ($permissao) {
    case 2:
        $permissaos = 'Administrador';
        break;
    case 3:
        $permissaos = 'Fiscal Adminstrativo';
        break;
    case 10:
         $permissaos = 'Visitante';
        break;
}
    
    
    ?>
    <!doctype html>
    <html lang="pt">

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">				 
            <link rel="stylesheet"  type="text/css" href="css/Styleuser1.css" media="screen"/>
            <link rel="stylesheet" href="css/bootstrap.css" >
            <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
            <script defer src="js/fontawesome-all.min.js"></script>
            <script>


                function esconDiv(valor)

                {
                    if (valor == "2")
                    {
                        document.getElementById("div4").style.display = "none";
                        document.getElementById("div6").style.display = "none";
                        document.getElementById("div7").style.display = "block";
                    } else if (valor == "1")
                    {
                        document.getElementById("div4").style.display = "block";
                        document.getElementById("div6").style.display = "block";
                        document.getElementById("div7").style.display = "none";

                    }
                }

            </script>
        </head>
        <body  >
            <div class="img5">
                <?php include_once 'image_header5.php' ?>  
            </div>
            <div  class=" container-fluid    "  style="margin-top: 60px">
                <div class=" form1 col-md-8 order-md-1">
                    <?php
                    if (isset($_SESSION['msg40'])) {
                        echo $_SESSION['msg40'];
                        unset($_SESSION['msg40']);
                    }
                    ?>	


                    <form class=" form1 needs-validation"  id="fm6" action="cad_colaboradores.php?action=update" method="post" novalidate>
                        <div class="row">

                            <div  class="col-md-3 mb-10">
                                <label for="">EMPRESA</label>
                                <select class="form-control "  name="empresa1"  onchange="esconDiv(this.value)" >
                                    <option selected></option>
                                    <option value="1">SERPRO</option>
                                    <option value="2">OUTRA</option>                               
                                </select>
                            </div>
                 
                     
                      
                            <div class="col-md-9 mb-10">
                                <label for="firstName">NOME:</label>
                                <input class="form-control" Type="text" name="nome"   value="<?php echo $registro['nome']; ?>" required>	
                            </div>  
                            </div>  
                        
                        <div class="row">
                            <div class="col-md-4 mb-10">
                                <label for="firstName">EMAIL:</label>
                                <input class="form-control" Type="email" name="email" value="<?php echo $registro['email']; ?>" required> 	
                            </div>
                            <div class="col-md-4 mb-10">
                                <label for="firstName">	CELULAR:</label>
                                <input class="form-control" Type="text" name="celular"  value="<?php echo $registro['celular']; ?>" required>
                            </div>       

                            <div class="col-md-4 mb-10">
                                <label for="firstName">TELEFONE:</label>
                                <input class="form-control" Type="text" name="telefone"    value="<?php echo $registro['telefone']; ?>" required>         
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-10">
                                <label for="address">FUNÇÃO:</label>			  
                                <input class="form-control" Type="text" name="funcao" size="40" value="<?php echo $registro['funcao']; ?>" required>                 
                            </div>

                            <div class="col-md-4 mb-10   div1" id="div4">
                                <label for="address"> LOTAÇÃO:</label>			  
                                <input class="form-control" Type="text" name="lotacao"   value="<?php echo $registro['lotacao']; ?>" required> 	       
                            </div>
                            <div class="col-md-4 mb-10   div1" id="div6">
                                <label for="firstName">MATRICULA:</label>
                                <input class="form-control" Type="text" name="matricula"  value="<?php echo $registro['matricula']; ?>" required>
                            </div>  
                        </div>
                        <div class=" row"  >
                            <div id="div7" class="form-group col-md-12">
                                <label for="forn">PRESTADOR/ FORNECEDOR:</label>
                                <select class="form-control" id="forn" name="empresa">
                                    <option selected><?php echo $registro['empresa']; ?></option>  
                                    <?php
                                    $q1 = "SELECT * FROM  prestador WHERE modo = '2' ORDER BY nome ASC";
                                    $r1 = mysqli_query($conection, $q1);
                                    while ($row = mysqli_fetch_assoc($r1)) {
                                        ?>
                                        <option value = "<?php echo $row ['nome']; ?>"><?php echo $row ['nome']; ?></option>
                                    <?php } ?>
                                </select>	
                            </div>
                        </div>

                        <div class="mb-3"> 
                            <input  class="form-control" type="hidden" name="id_usuario" value="<?php echo $id_usuario; ?>" >
                            
                            <input type="hidden" name="submitted" value="TRUE">
                            <input class="btn btn-primary btn-lg btn-block"  type="submit" name="submit" value="Enviar"/>      
                        </div>
                    </form>
                    <?php if ($permissa == '2') { ?>

                        <?php
                        if (isset($_SESSION['msg42'])) {
                            echo $_SESSION['msg42'];
                            unset($_SESSION['msg42']);
                        }
                        ?>	
                        <hr>
                        <h3>Atualizar Senha </h3>
                        <p> Atualize a senha de usuários que eventualmente esqueceram 
                            suas respectivas para o acesso. Sugerimos utilizar a Senha: 123, informe ao usuario e solicite que a altere imediatamente, apos ter restabelecido 
                            o acesso.</p>

                        <hr>

                        <form id="frmRegistro" action="cad_visitante.php?action=update" method="post">
                            <div class="row">
                                <div class="col-md-4 mb-10">
                                    <label for="csenha"><i class='fas fa-key'></i> NOVA SENHA:</label>
                                    <input class="form-control" type="password" name="senha" size="20" maxlength="20" />
                                </div>
                                <div class="col-md-4 mb-10">
                                    <label for="csenha2"><i class='fas fa-key'></i> CONFIRMA SENHA:</label>
                                    <input class="form-control" type="password" name="senha2" size="20" maxlength="20" />
                                </div>
                                 <div class="col-md-4 mb-10" style="margin-top: 30px">
                                     <input  class="form-control" type="hidden" name="admin" value='1' >
                                    <input name="id_usuario" type="hidden" value=<?php echo $id_usuario; ?>>                                    
                                    <button type="submit" class="btn btn-primary">Enviar Senha</button>
                                </div>
                            </div>
                        </form>
                          <?php
                    if (isset($_SESSION['msg43'])) {
                        echo $_SESSION['msg43'];
                        unset($_SESSION['msg43']);
                    }
                    ?>	
                        <hr>
                        <h3>Permissões</h3>
                        <p>Atualize a permissões caso queira atribuir poderes ou restringi-los do usuário em questão.</p>  
                        <form id="frmRegistro" action="cad_visitante.php?action=permissao" method="post">
                            <div class="row">
                                <div class="col-md-4 mb-10">
                                    
                                   

                                    <label for="cpermissao">PERMISSÃO:</label>
                                    <select id="cpermissao" class="form-control" name="permissao">
                                        <option selected><?php echo $permissaos; ?></option>
                                        <option value="2">Administrador</option>
                                        <option value="3">Fiscal Adminstrativo</option>
                                        <option value="10">Visitante</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-10" style="margin-top: 30px">
                                    <input name="id_usuario" type="hidden" value=<?php echo $id_usuario; ?>>                                    
                                    <button type="submit" class="btn btn-primary">Enviar Permissão</button>
                                </div>
                            </div>
                        </form>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </body>
        <nav class="navbar fixed-bottom navbar-light bg-light">
            <a class="navbar-brand" href="lista_usuario.php"><strong>Voltar a Lista</strong></a>
        </nav>
    </html>         
<?php } ?>