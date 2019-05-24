
<?php
include './includes/headers/header_entidade.php';
require_once './Funcoes/func_entidades.php';
require_once ('./inc/Config.inc.php');
require_once './Funcoes/mascara_php.php';
require 'database_gac.php';
$assunt = "<i class='fas fa-industry'></i> Lista de Entidades";
$permissa = $_SESSION['permissao'];

$id_prestador = filter_input(INPUT_GET, 'id_prest', FILTER_SANITIZE_NUMBER_INT);
$nomes_busca = filter_input(INPUT_POST, 'nomes_busca', FILTER_SANITIZE_STRING);
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$direct = 'salva';
$valor = 'Cadastrar';




$mat = $_SESSION['matricula'];
$permissa = (int) $_SESSION['permissao'];

//controle de formulario para atualiza 
if ($action == 'update') {
    
    $registro = busca_entidade_id($id_prestador);
    

    $direct = 'update';
    $valor = "Atualizar";

  
    unset($_SESSION['dados']);
}

if($action == 'deleta'){
    
    deleta_entidade($id_prestador);
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
                font-size: 20px;
                color:#007bff;
                font-weight: bold;
                font-family: times new roman;
                padding: 5px;
                margin: auto;
                margin-top: 20px;
            }
            .form1 input{
                font-size: 24px;
                background-color: #f8f9fa;
                font-family: times new roman;
            }
            .form1 select{
                font-size: 24px;
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
        </style>
    </head>
    <body>
        <?php require_once 'image_header6.php'; ?>
        <div  class=" container-fluid    "  >
            <div class="col-md-12 order-md-1 justify-content-center">
               
                      <div class=" form1 col-md-8 order-md-1">
                           <?php
                if (isset($_SESSION['msg40'])) {
                    echo $_SESSION['msg40'];
                    unset($_SESSION['msg40']);
                }
                ?>	
           
                <form class="needs-validation"  id= "form4" action="proc_prestador.php?action=<?php echo $direct ?>" method="post" novalidate>
                    <div class="row">
                        <div class="col-md-6 mb-10">
                            <label for="firstName">CNPJ:</label>
                            <p><input class="form-control" Type="text" name="cnpj"  value="<?php
                                if (isset($_SESSION['dados']['cnpj'])) {
                                    echo $_SESSION['dados']['cnpj'];
                                } elseif (!empty($action == 'update')) {
                                    echo $registro['cnpj'];
                                }
                                ?>" required>		
                        </div>
                    </div>
                     <div class="row">
                      <div class="col-md-8 mb-3">
                        <label for="address">Prestador de Serviço / Fornecedor:</label>
                        <p><input class="form-control"  Type="text" name="nome" size="80"  value="<?php
                                if (isset($_SESSION['dados']['nome'])) {
                                    echo $_SESSION['dados']['nome'];
                                } elseif (!empty($action == 'update')) {
                                    echo $registro['nome'];
                                }
                                ?>" required>	
                       
                    </div>
                      <div class="col-md-4 mb-3">
                        <label for="">Mneumônico:</label>
                        <p><input class="form-control"  Type="text" name="mnemonico" size="80" value="<?php
                                if (isset($_SESSION['dados']['mnemonico'])) {
                                    echo $_SESSION['dados']['mnemonico'];
                                } elseif (!empty($action == 'update')) {
                                    echo $registro['mnemonico'];
                                }
                                ?>" required>	

                       
                    </div>
                    </div>
                    <div class="mb-3">
                        <label for="address2">Endereço:<span class="text-muted"></label>
                        <p><input class="form-control" id="address2" Type="text" name="endereco" size="255" value="<?php
                                if (isset($_SESSION['dados']['endereco'])) {
                                    echo $_SESSION['dados']['endereco'];
                                } elseif (!empty($action == 'update')) {
                                    echo $registro['endereco'];
                                }
                                ?>" required>	
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label for="country">País</label>
                            <select class="custom-select d-block w-100"  name="pais" id="country" required>
                                  <option selected><?php
                                        if (isset($_SESSION['dados']['pais'])) {
                                            echo $_SESSION['dados']['pais'];
                                        } elseif (!empty($action == 'update')) {
                                            echo  $registro['pais'];
                                        }
                                        ?></option>  
                                <option value=""></option>
                                <option>Brasil</option>
                            </select>
                            
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="state">Estado</label>
                            <select class="custom-select d-block w-100"  name="estado"  id="state" required>
                                  <option selected><?php
                                        if (isset($_SESSION['dados']['estado'])) {
                                            echo$_SESSION['dados']['estado'];
                                        } elseif (!empty($action == 'update')) {
                                            echo $registro['estado'];
                                        }
                                        ?></option>  
                                <option value=""></option>
                                <option>Acre</option>
                                <option>Alagoas</option>
                                <option>Amapa</option>
                                <option>Amazonas</option>
                                <option>Bahia</option>
                                <option>Ceara</option>
                                <option>Distrito Federal</option>
                                <option>Espirito Santo</option>
                                <option>Goias</option>
                                <option>Maranhao</option>
                                <option>Mato Grosso</option>
                                <option>Mato Grosso do Sul</option>
                                <option>Minas Gerais</option>
                                <option>Amazonas</option>
                                <option>Para</option>
                                <option>Paraiba</option>
                                <option>Parana</option>
                                <option>Pernambuco</option>
                                <option>Piaui</option>
                                <option>Rio de Janeiro</option>
                                <option>Rio Grande do Norte</option>
                                <option>Rio Grande do Sul</option>
                                <option>Rondonia</option>
                                <option>Roraima</option>
                                <option>Santa Catarina</option>
                                <option>Sao Paulo</option>
                                <option>Sergipe</option>
                                <option>Tocantis</option>	                                             		    
                            </select>
                            <div class="invalid-feedback">
                                Please provide a valid state.
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="ccep">CEP</label>
                            <input type="text" class="form-control" id="ccep" name="cep"  placeholder="" value="<?php
                                if (isset($_SESSION['dados']['cep'])) {
                                    echo $_SESSION['dados']['cep'];
                                } elseif (!empty($action == 'update')) {
                                    echo $registro['cep'];
                                }
                                ?>" required>                           
                        </div>
                    </div>
                    <hr class="mb-4">
                   
                   <input name="id_prestador" type="hidden" value=<?php echo $id_prestador; ?>>    
                   <button  class="btn btn-primary "  type="submit"><?php echo $valor ?></button>  
                    <input type="hidden" name="submitted" value="TRUE" />
                </form>             
            
        </div>

<?php unset($_SESSION['dados']); ?>
                </div>     
                <div style=" margin-top: 50px;">
<?php
if (!empty($nomes_busca)) {

    require_once './includes/listas/lista_geral_entidades_busca.php';
} else {
    require_once './includes/listas/lista_geral_entidades.php';
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