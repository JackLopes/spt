<?php
session_start();
$page_title = 'Cadastrando Prestador/ Fornecedor';

require_once 'Funcoes/limpa_string.php';
$assunt = '<i class="fas fa-dolly-flatbed"></i>' . ' Cadastro Prestador de Serviço';
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);



$mnemonico = filter_input(INPUT_POST, 'mnemonico', FILTER_SANITIZE_STRING);
$modo = filter_input(INPUT_POST, 'modo', FILTER_SANITIZE_NUMBER_INT);
$pais = filter_input(INPUT_POST, 'pais', FILTER_SANITIZE_STRING);
$estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);
$cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING);

$_SESSION['dados'] = $dados;
$permissa = $_SESSION['permissao'];
?>
<!doctype html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
        <link rel="stylesheet"  type="text/css" href="css/Style_prestador.css" media="screen"/>
        <link rel="stylesheet" href="css/bootstrap.css" >
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    </head>
    <body style="background-color: #f8f9fa; " >
        <?php 
          include './header_cadastro.php';
        include_once 'image_header5.php' ?>
     
      
    <div  class=" container-fluid    "  style="margin-top: 60px">
        <?php
      
        require_once 'database_gac.php';

        if ($permissa < '4') {
            if (isset($_POST['submitted'])) {
                $erro = array();





                if (empty($_POST['nome'])) {
                    $erro[] = 'Selecionar o Prestador do Serviço.';
                } else if (strlen($_POST['nome']) < 8) {
                    $erro[] = "Preencha a Razão com no mínimo 8 caracteres.";
                } else {
                    $nom = mysqli_real_escape_string($conection, trim($_POST['nome']));
                    $nom = limpa($nom);
                }
                /* --------------------------------------------------------------------------- */
                include 'validar_cnpj.php';

                $cnpj = ($_POST['cnpj']);

                if (empty($_POST['cnpj'])) {
                    $erro[] = 'Informar o CNPJ.';
                } else if (valida_cnpj($_POST['cnpj'])) {
                    $cnp = $_POST['cnpj'];
                } else {

                    $erro[] = ' CNPJ Inválido.';
                }
                /* --------------------------------------------------------------------------- */
                if (empty($_POST['endereco'])) {
                    $erro[] = 'Informar o Endereço.';
                } else if (strlen($_POST['endereco']) < 8) {
                    $erro[] = "Preencha o Endereço com no mínimo 8 caracteres.";
                } else {
                    $end = mysqli_real_escape_string($conection, trim($_POST['endereco']));
                    $end = limpa($end);
                }

               /* if (empty($mine)) {
                    $erro[] = 'Designe um mnemônico';
                } else if (is_numeric($mine)) {
                    $erro[] = 'Mnemônico inválido';
                } else {
                    $mine = mysqli_real_escape_string($conection, trim($mine));
                }*/

                if (empty($erro)) {

                    $q = "SELECT cnpj FROM prestador WHERE cnpj = '$cnp'";
                    $r = mysqli_query($conection, $q);
                    $num = mysqli_num_rows($r);

                    if ($num < 1) {

                        $q1 = "INSERT INTO prestador (nome, cnpj, endereco,pais, estado, cep ) VALUES ('$nom','$cnp','$end', '$pais', '$estado', '$cep' )";
                        $r1 = mysqli_query($conection, $q1);

                        if ($r1) {
                            ?>		

                            <div   class=" form1 col-md-8 alert alert-primary   col-md-8 order-md-1" role="alert">
                                <h6>Cadastro realizado com sucesso !!!</h6>
                            </div>    	  


                            <?php
                            unset($_SESSION['dados']);
                        } else {
                            
                        }
                    } else {
                        ?> 
                        <div   class=" form1 col-md-8 alert alert-primary   col-md-8 order-md-1" role="alert">
                            <h6>Este Prestador de Serviço já foi cadastrado !!!</h6>
                        </div>  


                        <?php
                    }
                } else {
                    ?>
                    <div  class=" form1 col-md-8 alert alert-danger col-md-8 order-md-1" role="alert"> <?php
                        echo "<h6>Atenção</h6>";
                        foreach ($erro as $mg)
                            echo " - $mg<br>\n ";
                        ?>
                    </div>
                    <?php
                }
            }
        } else {
            ?> 
            <div   class=" form1 col-md-8 alert alert-danger   col-md-8 order-md-1" role="alert">
                <h6>Você não tem permissão para cadastrar registros </h6>
            </div>  
            <?php
        }
        ?>
        <div class=" form1 col-md-8 order-md-1">
            <div class="content col-md-12 order-md-1">
                <form class="needs-validation"  id= "form4" action="cad_prestador.php" method="post" novalidate>
                    <div class="row">
                        <div class="col-md-6 mb-10">
                            <label for="firstName">CNPJ:</label>
                            <p><input class="form-control" Type="text" name="cnpj"  value="<?php if (isset($_SESSION['dados']['cnpj'])) echo $_SESSION['dados']['cnpj']; ?>" /></p>	
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address">Prestador de Serviço / Fornecedor:</label>
                        <p><input class="form-control" id="address" Type="text" name="nome" size="80"  value="<?php if (isset($_SESSION['dados']['nome'])) echo $_SESSION['dados']['nome']; ?>" /></p>

                        <div class="invalid-feedback">
                            Please enter your shipping address.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address2">Endereço:<span class="text-muted"></label>
                        <p><input class="form-control" id="address2" Type="text" name="endereco" size="255" value="<?php if (isset($_SESSION['dados']['endereco'])) echo $_SESSION['dados']['endereco']; ?>" /></p>
                    </div>
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label for="country">País</label>
                            <select class="custom-select d-block w-100"  name="pais" id="country" required>
                                <option value=""></option>
                                <option>Brasil</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid country.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="state">Estado</label>
                            <select class="custom-select d-block w-100"  name="estado"  id="state" required>
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
                            <input type="text" class="form-control" id="ccep" name="cep"  placeholder="" required>
                            <div class="invalid-feedback">
                                Zip code required.
                            </div>
                        </div>
                    </div>
                    <hr class="mb-4">

                    <input class="btn btn-primary "  type="submit" name="submit" value="CADASTRAR"/>
                    <input type="hidden" name="submitted" value="TRUE" />
                </form>             
            </div> 
        </div>
    </div>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>
</html>
