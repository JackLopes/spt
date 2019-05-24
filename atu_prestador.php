
<?php
$page_title = 'Cadastrando Prestador/ Fornecedor';
include 'menu.php';
$id_pretador = filter_input(INPUT_GET, 'id_prest', FILTER_SANITIZE_NUMBER_INT);

$assunt = '<i class="fas fa-industry"></i> Atualização de Entidade'
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
    <body  style="background-color: #cfcfcf;">
        <?php require_once 'image_header6.php'; ?>
        <div  class="container-fluid" >

            <?php
            require_once 'database_gac.php';
            $sql = "select * from prestador WHERE id_prestador = '$id_pretador' ";
            $con = mysqli_query($conection, $sql);
            while ($res = mysqli_fetch_array($con)) {
                ?>
                <center><div class="col-md-8 order-md-1">                


                        <div class="col-md-12 order-md-1">
                            <?php
                            if (isset($_SESSION['msg12'])) {
                                echo $_SESSION['msg12'];
                                unset($_SESSION['msg12']);
                            }
                            ?>
                            <form class="needs-validation"  id= "form4" action="proc_prestador.php" method="post" novalidate>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="firstName">CNPJ:</label>
                                        <p><input class="form-control" Type="text" name="cnpj"  value="<?php echo $res ['cnpj']; ?>" /></p>	
                                    </div>   
                                    <div class="col-md-6 mb-10">
                                        <label for="mine">MNEUMONICO:</label>
                                        <p><input class="form-control" id="mine" Type="text" name="mnemonico"  value="<?php echo $res ['mnemonico']; ?>" /></p>	
                                    </div>
                                </div>     
                                <div class="mb-3">
                                    <label for="address">PRESTADOR DE SERVIÇO/ FORNECEDOR:</label>
                                    <p><input class="form-control" id="address" Type="text" name="nome" size="80"  value="<?php echo $res ['nome']; ?>" /></p>


                                </div>
                                <div class="mb-3">			
                                    <label for="address2">ENDEREÇO:<span class="text-muted"></label>
                                    <p><input class="form-control" id="address2" Type="text" name="endereco" size="255" value="<?php echo $res['endereco']; ?>" /></p>

                                </div>

                                <div class="row">
                                    <div class="col-md-5 mb-3">
                                        <label for="country">País</label>
                                        <select class="custom-select d-block w-100" name="pais" id="country" required>
                                            <option value=""></option>
                                               <option selected><?php echo $res['pais']; ?></option>
                                            <option>Brasil</option>
                                        </select>               			
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="state">Estado</label>
                                        <select class="custom-select d-block w-100" name="estado" id="state" required>
                                            <option selected><?php echo $res['estado']; ?></option>
                                            <option value=""></option>                  
                                            <option>Acre</option>
                                            <option>Alagoas</option>
                                            <option>Amapa</option>
                                            <option>Amazonas</option>
                                            <option>Bahia</option>
                                            <option>Brasilia</option>
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
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="zip">CEP</label>
                                        <input type="text" class="form-control" id="ccep" name="cep" placeholder="" value="<?php echo $res['cep']; ?>" /></p>        
                                    </div>
                                </div>

                                <hr class="mb-4">
                                <input class="btn btn-primary btn-lg btn-block"  type="submit" name="submit" value="Atualizar"/>
                                <input type="hidden" name="submitted" value="TRUE" />
                                <input class="form-control" Type="hidden" name="id_prestador" id="vig_garantia" value="<?php if (isset($id_pretador)) echo $id_pretador; ?>" >
                            </form>
                        </div> 
                        <?php
                    }
                    ?>
                </div></center>
            
        </div>
    

        <nav class="navbar fixed-bottom navbar-light bg-light">
            <a class="navbar-brand" href="lista_prestador.php">RETORNAR </a>
        </nav>		

    </body>
</html>