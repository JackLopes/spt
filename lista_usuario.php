
<?php
include './includes/headers/header_usuario.php';
require_once ('./inc/Config.inc.php');
require_once 'Funcoes/func_usuarios.php';
require 'database_gac.php';

$id_usuario = filter_input(INPUT_GET, 'id_usuario', FILTER_SANITIZE_NUMBER_INT);
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$nomes_busca = filter_input(INPUT_POST, 'nomes_busca', FILTER_SANITIZE_STRING);
$assunt = "<font style='font-size:70px'><i class='fas fa-user'> </i></font> Cadastro, Busca e Atualização de Colaboradores";
$direct = 'salva';
$valor = 'Cadastrar';


$mat = $_SESSION['matricula'];
$permissa = (int) $_SESSION['permissao'];

//controle de formulario para atualiza 
if ($action == 'update') {
    $registro = busca_usuario_id($id_usuario);
    $direct = 'update';
    $valor = "Atualizar";

    if ($registro['empresa'] == 'Servico Federal De Processamento De Dados') {

        $valor1 = 1;
    } else {
        $valor1 = 2;
    }
    unset($_SESSION['dados']);
}



if (isset($_SESSION['dados']['empresa'])) {
    if ($_SESSION['dados']['empresa'] == 'Servico Federal De Processamento De Dados') {

        $valor1 = 1;
    } else {
        $valor1 = 2;
    }
}
?>
<!doctype html>
<html lang="pt">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet"  type="text/css" href="css/stylecolaborador.css" media="screen"/>	
        <link rel="stylesheet" href="css/bootstrap.css" >
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <style>
            .form1{
                font-size: 22px;
                color:#007bff;
                font-weight: bold;
                font-family: times new roman;
                padding: 5px;
                margin: auto;
            }
            .form1 input{
                font-size: 22px;
                background-color: #f8f9fa;
                font-family: times new roman;
            }
            .form1 select{
                font-size: 22px;
                background-color: #f8f9fa;
                height: 50px;
                font-family: times new roman;
            }
            .form1 button{
                font-size: 20px;
            }
            .tb1{
                font-family: times new roman;
                font-size: 18px;
            }
            .sec{
                font-size: 24px;
            }
            .pt{
                font-family: times new roman;
            }
            
            p{
                color: black;
                fonte-size:8px;
            }
        </style>
    </head>
    <body>
        <?php require_once 'image_header6.php'; ?>
        <div  class=" container-fluid    "  style="margin-top: 30px">
            <div class="col-md-12 order-md-1">
                <?php
                if (isset($_SESSION['msg40'])) {
                    echo $_SESSION['msg40'];
                    unset($_SESSION['msg40']);
                }
                ?>	
                <div class=" form1 col-md-8 order-md-3">
                    <form class=" form1 needs-validation"  id="fm6" action="cad_colaboradores.php?action=<?php echo $direct ?>" method="post" novalidate>
                        <div class="row">
                            <div  class="col-md-2 mb-1">
                                <label for="">Empresa</label>

                                <select  class=" custom-select"   name="empresa1"  onchange="esconDiv(this.value)" >
                                    <option selected><?php
                                        if (isset($_SESSION['dados']['empresa'])) {
                                            echo $valor1;
                                        } elseif (!empty($action == 'update')) {
                                            echo $valor1;
                                        }
                                        ?></option>  

                                    <option value="1">SERPRO</option>
                                    <option value="2">Outra Empresa</option>                               
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="address">Função:</label>			  
                                <input class="form-control" Type="text" name="funcao" size="40"  value="<?php
                                if (isset($_SESSION['dados']['funcao'])) {
                                    echo $_SESSION['dados']['funcao'];
                                } elseif (!empty($action == 'update')) {
                                    echo $registro['funcao'];
                                }
                                ?>" required>            
                            </div>


                            <div id="div7" class="form-group col-md-6">
                                <label for="forn">Nome Da Empresa:</label>
                                <select  class=" custom-select" id="forn" name="empresa">
                                    <option selected><?php
                                        if (isset($_SESSION['dados']['empresa'])) {
                                            echo $_SESSION['dados']['empresa'];
                                        } elseif (!empty($action == 'update')) {
                                            echo $registro['empresa'];
                                        }
                                        ?></option>  
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

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="firstName">Nome:</label>
                                <input class="form-control" Type="text" name="nome" size="100"   value="<?php
                                if (isset($_SESSION['dados']['nome'])) {
                                    echo $_SESSION['dados']['nome'];
                                } elseif (!empty($action == 'update')) {
                                    echo $registro['nome'];
                                }
                                ?>" required>	
                            </div>  


                            <div class="col-md-4 mb-3">
                                <label for="firstName">Email:</label>
                                <input class="form-control" Type="email" name="email" size="40" value="<?php
                                if (isset($_SESSION['dados']['email'])) {
                                    echo $_SESSION['dados']['email'];
                                } elseif (!empty($action == 'update')) {
                                    echo $registro['email'];
                                }
                                ?>" required> 	
                            </div>


                            <div class="col-md-4 mb-3">
                                <label for="firstName">	Celular:</label>
                                <input class="form-control" Type="tel" maxlength="15"  name="celular"  pattern="\([0-9]{2}\) [0-9]{4,6}-[0-9]{3,4}$"  value="<?php
                                if (isset($_SESSION['dados']['celular'])) {
                                    echo $_SESSION['dados']['celular'];
                                } elseif (!empty($action == 'update')) {
                                    echo $registro['celular'];
                                }
                                ?>" required>
                            </div>        
                        </div>        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="firstName">Telefone:</label>

                                <input class="form-control" Type="tel" maxlength="15" name="telefone" pattern="\([0-9]{2}\) [0-9]{4,6}-[0-9]{3,4}$"  value="<?php
                                if (isset($_SESSION['dados']['telefone'])) {
                                    echo $_SESSION['dados']['telefone'];
                                } elseif (!empty($action == 'update')) {
                                    echo $registro['telefone'];
                                }
                                ?>" required>            
                            </div>               




                            <div class="col-md-4 mb-3   div1" id="div4">
                                <label for="address"> Lotação:</label>			  
                                <input class="form-control" Type="text" name="lotacao"   value="<?php
                                if (isset($_SESSION['dados']['lotacao'])) {
                                    echo $_SESSION['dados']['lotacao'];
                                } elseif (!empty($action == 'update')) {
                                    echo $registro['lotacao'];
                                }
                                ?>" required>            
                            </div>

                            <div class="col-md-4 mb-3  div1" id="div6">
                                <label for="firstName">Matricula:</label>
                                <input class="form-control" Type="text" name="matricula"   value="<?php
                                if (isset($_SESSION['dados']['matricula'])) {
                                    echo $_SESSION['dados']['matricula'];
                                } elseif (!empty($action == 'update')) {
                                    echo $registro['matricula'];
                                }
                                ?>"required>	
                            </div>  
                        </div>  


                        <hr class="mb-4">
                        <div class="mb-3">   
                            <input Type="hidden" name="senha" size="40" value="<?php if (isset($_SESSION['dados']['senha'])) echo $_SESSION['dados']['senha']; ?>" />
                            <input  type="hidden" name="id_usuario" value="<?php echo $id_usuario; ?>" />
                            <input type="hidden" name="submitted" value="true" />
                            <button  class="btn btn-primary "  type="submit"><?php echo $valor ?></button>  
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
                        <h3 >Atualizar Senha </h3>
                        <p > Atualize a senha de usuários que eventualmente esqueceram 
                            suas respectivas para o acesso. Sugerimos utilizar a Senha: 123, informe ao usuario e solicite que a altere imediatamente, apos ter restabelecido 
                            o acesso.</p>

                        <hr>

                        <form class="Form1" action="cad_colaboradores.php?action=updatesenha" method="post">
                            <div class="row">
                                <div class="col-md-4 mb-10">
                                    <label for="csenha"><i class='fas fa-key'></i> NOVA SENHA:</label>
                                    <input class="form-control" type="password" name="senha" size="20" maxlength="20" />
                                </div>
                                <div class="col-md-4 mb-10">
                                    <label for="csenha2"><i class='fas fa-key'></i> CONFIRMA SENHA:</label>
                                    <input class="form-control" type="password" name="senha2" size="20" maxlength="20" />
                                </div>
                                <div class="col-md-4 mb-10" style="margin-top: 45px">
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
                        <h3 class="pt">Permissões</h3>
                        <p class="pt">Atualize a permissões caso queira atribuir poderes ou restringi-los do usuário em questão.</p>  
                        <form class="form1"action="cad_colaboradores.php?action=updatepermissao" method="post">
                            <div class="row">
                                <div class="col-md-4 mb-10">
                                    <label for="cpermissao">PERMISSÃO:</label>                                    
                                    <select class=" custom-select"   name="permissao">
                                        <option selected></option>
                                        <option value="2">Administrador</option>
                                        <option value="3">Fiscal Adminstrativo</option>
                                        <option value="10">Visitante</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-10" style="margin-top: 40px">
                                    <input name="id_usuario" type="hidden" value=<?php echo $id_usuario; ?>>                                    
                                    <button type="submit" class="btn btn-primary">Enviar Permissão</button>
                                </div>
                            </div>
                        </form>
                        <?php
                    }
                    ?>
                    <?php unset($_SESSION['dados']); ?>
                </div>     
                <div style=" margin-top: 50px;">
                    <?php
                    if (!empty($nomes_busca)) {

                        require_once './includes/listas/lista_geral_usuarios_busca.php';
                    } else {
                        require_once './includes/listas/lista_geral_usuarios.php';
                    }
                    ?>                                               
                </div>

            </div>
        </div>
        <script defer src="js/fontawesome-all.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
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
    </body>
</html>