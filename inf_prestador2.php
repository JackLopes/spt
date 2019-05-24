<?php
session_start();
$page_title = 'Informação Prestador';

require_once ('./inc/Config.inc.php');
require_once './Funcoes/mascara_php.php';

$permissa = $_SESSION['permissao'];

if (isset($_GET['id'])) {
    $id_prest = (int) $_GET['id'];
}

if (isset($_GET['ct'])) {
    $ct = (int) $_GET['ct'];
}
$id_colaborador = filter_input(INPUT_GET, 'id_colaborador', FILTER_VALIDATE_INT);

$assunt = '<i class="fas fa-dolly-flatbed"></i> ' . 'Prestador/ Fornecedor de Serviços';

 require_once 'valida_permissao.php';  
        
    


?>
<!doctype html>
<html lang="pt">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet"  type="text/css" href="css/styleinf_prest.css" media="screen"/>	
        <link rel="stylesheet" href="css/bootstrap.css" >
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <script defer src="js/fontawesome-all.min.js"></script>
          <style>
            table{
                font-size: 23px;
                font-family: times new romam;
            }
        </style>
    </head>
    <body style="background:#cfcfcf;">
        
            <?php include_once 'image_header5.php' ?>
            <span style="position: absolute; margin-top: -125px; margin-left: 90%;"><a class="btn btn-danger" href="" onclick="opener.location.reload(); window.close();">FECHAR</a></span>
            
            
       

        <div  class=" container-fluid    "  style="margin-top: 20px">
   <div style="margin: auto" class="col-md-10 mb-10"> 
            <div  class="row  justify-content-center" >
                  <?php   if ($matricula === $mat AND $permissa < 4 or $permissa == '2') {?>
                <nav id="naviselect" class="col-md-2  d-none d-xl-block bg-light sidebar">

                    <div class="sidebar-sticky">
                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>Cadastro</span>              
                            </a>
                        </h6>	  
                        <ul class="nav flex-column">             
                            <li class="nav-item">
                                <a class="nav-link"href=" " data-toggle="modal" data-target="#exampleModal">
                                   <i class="fas fa-phone-volume"></i> Contato				
                                </a>                  
                            </li>             
                        </ul>
                        <ul class="nav flex-column">             
                            <li class="nav-item">
                                <a class="nav-link"href=" " data-toggle="modal" data-target="#exampleModal2">
                                  <i class='fas fa-industry'></i>   Filiais				
                                </a>                  
                            </li>             
                        </ul>
                       
                          
                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            Relatórios             
                        </h6>
                        <ul class="nav flex-column mb-2">
                            <li class="nav-item">              
                            </li>             
                        </ul>
                    </div>
                  
                </nav>
                 <?php }?>
               <main role="main" class="col-md-8 ml-sm-6 col-lg-10 pt-0">
                   	
                        <table  class="table  table-striped table-hover table-bordered table-sm"   >

                            <?php
                            echo "<tr>";

                            echo"</tr>";

                            require_once 'database_gac.php';

                            $sqlprestador = "SELECT * FROM prestador WHERE id_prestador = $id_prest";
                            $resultado = mysqli_query($conection, $sqlprestador)or die('Não foi possivel conectar ao MySQL');
                            while ($registro = mysqli_fetch_array($resultado)) {
                                $idp = $registro['id_prestador'];
                                $nome = $registro['nome'];
                                $cnpj = $registro['cnpj'];
                                $endereco = $registro['endereco'];
                                $cep = $registro['cep'];
                                $estado = $registro['estado'];
                                $pais = $registro['pais'];

                                echo "<tr><td ><b>Nome Fantasia:</td><td>  " . $nome . "</td><tr>";
                                echo "<tr><td><b>CNPJ:</td><td> " . $cnpj . "</td><tr>";
                                echo "<tr><td><b>Endereço:</td><td> " . $endereco . "</td><tr>";
                                echo "<tr><td><b>CEP:</td><td> " . $cep . "</td><tr>";
                                echo "<tr><td><b>Estado:</td><td> " . $estado . "</td><tr>";
                                echo "<tr><td><b>País:</td><td> " . $pais . "</td><tr>";
                            }
                            ?>
                        </table>
                        <?php
                       

                            if (!empty($id_colaborador)) {
                                $apagarColaborador = new Delete();
                                $apagarColaborador->ExeDelete('colaborador', 'WHERE id_colaborador = :id', "id={$id_colaborador}");
                                echo $apagarColaborador->getMsg();
                            }
                     

                        if (isset($_SESSION['msg39'])) {
                            echo $_SESSION['msg39'];
                            unset($_SESSION['msg39']);
                        }

                        if (!empty($_SESSION['msg37'])) {

                            echo $_SESSION['msg37'];

                            unset($_SESSION['msg37']);
                        }
                        ?>	


                  
                    <br /><h6  ><i class='fas fa-industry'></i> Filiais</h6>


                    <table class="table table-sm table-hover table-bordered" >
                        <thead class="thead-light">
                            <tr scope="row">
                                <th scope="col">Nome Fantasia</th>
                                <th scope="col">CNPJ</th>                                              

                                <th scope="col">Endereço</th>
                                <th scope="col">Cep</th> 
                                <th scope="col">Estado</th> 
                                <th scope="col">Pais</th> 
                                <th scope="col">Excluir</th>  
                        </thead >
                        <?php
                        $sql_filial = "SELECT * FROM filial WHERE id_prestador= '$id_prest' ";
                        $resultado = mysqli_query($conection, $sql_filial)or die('Não foi possivel conectar ao MySQL');
                        while ($registro = mysqli_fetch_array($resultado)) {
                            ?>
                            <tr>
                                <td ><?php echo $registro['nome']; ?></td>
                                <td  ><?php echo masc_cnpj_php($registro['cnpj']); ?></td>

                                <td  ><?php echo $registro['endereco']; ?></td>
                                <td ><?php echo $registro['cep']; ?></td>
                                <td  ><?php echo $registro['estado']; ?></td>
                                <td ><?php echo $registro['pais']; ?></td>
                                <td >
                                    <a  href="#">
                                        Excluir
                                    </a>
                                </td>
                            </tr>
                             <!-- Modal Exclusao -->
                        <div class="modal fade" id="exampleModal5<?php echo $registro['id_colaborador']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Deseja Realmente Deletar  </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p><?php echo  $registro['nome']; ?></p>
                                        <ul class="nav justify-content-center">     
                                            <li class="nav-item">
                                                <a class="btn btn-danger"  href="inf_prestador2.php?id=<?php echo $registro['id_presta'] ?>&id_colaborador=<?php echo $registro['id_colaborador']; ?>&ct=<?php echo $registro['id_contrato']; ?>">Sim</a>
                                            </li>
                                            <li style="margin-left:30px" class="nav-item">
                                                <a style=" color: #FFFFFF" class="btn btn-success"  data-dismiss="modal">Nao</a>
                                            </li>
                                        </ul>
                                    </div>                             
                                </div>
                            </div>
                        </div>
                            <?php
                        }
                        ?>
                    </table>
                    <br /><h6  ><i class="fas fa-phone-volume"></i> Contatos </h6>
                    <table class="table table-sm table-hover table-bordered" >
                        <thead class="thead-light">
                            <tr scope="row">
                                <th scope="col">Nome</th>
                            
                                <th scope="col">Email</th>
                                <th scope="col">Celular</th>
                                <th scope="col">Telefone</th>  
                                <th scope="col">Excluir</th>  
                        </thead >
                        </tr> 
                        <?php
                        $sqlcolaborador = "SELECT * FROM colaborador WHERE id_presta='$id_prest'";
                        $resultado = mysqli_query($conection, $sqlcolaborador)or die('Não foi possivel conectar ao MySQL');
                        while ($registro = mysqli_fetch_assoc($resultado)) {
                            ?>
                            <tr>
                                <td ><?php echo $registro['nome']; ?></td>
                               
                                <td  ><?php echo $registro['email']; ?></td>
                                <td ><?php echo $registro['celular']; ?></td>
                                <td  ><?php echo $registro['telefone']; ?></td>
                                <td>
                                    <a  href="#"  data-toggle="modal" data-target="#exampleModal5<?php echo $registro['id_colaborador'] ?>">
                                         <i class="fas fa-eraser"></i> 
                                    </a>
                                </td>
                            </tr> 
                              <!-- Modal Exclusao -->
                        <div class="modal fade" id="exampleModal5<?php echo $registro['id_colaborador']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Deseja Realmente Deletar  </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p><?php echo  $registro['nome']; ?></p>
                                        <ul class="nav justify-content-center">     
                                            <li class="nav-item">
                                                <a class="btn btn-danger"  href="inf_prestador2.php?id=<?php echo $registro['id_presta'] ?>&id_colaborador=<?php echo $registro['id_colaborador']; ?>&ct=<?php echo $registro['id_contrato']; ?>">Sim</a>
                                            </li>
                                            <li style="margin-left:30px" class="nav-item">

                                                <a style=" color: #FFFFFF" class="btn btn-success"  data-dismiss="modal">Nao</a>
                                            </li>
                                        </ul>
                                    </div>                             
                                </div>
                            </div>
                        </div>
                            <?php
                        }
                        ?>
                    </table>
                   
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Contatos Envolvidos</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form class="needs-validation"  id="fm6" action="cad_preposto.php" method="post" novalidate>
                                        <div class="row">
                                            <div class="col-md-6 mb-10">                          
                                                <label for="forn">Nome:</label>
                                                <select class="form-control" id="forn" name="id_usuario" value="<?php if (isset($_POST['id_usuario'])) echo $_POST['id_usuario']; ?>" >
                                                    <option>Selecione</option>  
                                                    <?php
                                                    $q1 = "SELECT * FROM  usuario WHERE empresa = '$nome'";
                                                    $r1 = mysqli_query($conection, $q1);
                                                    while ($row = mysqli_fetch_assoc($r1)) {
                                                        ?>
                                                        <option value = "<?php echo $row ['id_usuario']; ?>"><?php echo $row ['nome']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>  

                                        </div>
                                        <br class="mb-4">
                                        <div class="row">
                                            <div class="col-md-12 mb-10">   
                                                <input type="hidden" name="id_presta" value="<?php echo $id_prest; ?>" />
                                                <input type="hidden" name="ct" value="<?php echo $ct; ?>" />
                                                <input type="hidden" name="submitted" value="TRUE" />
                                                <input class="btn btn-primary btn-sm btn-block"  type="submit" name="submit" value="Enviar"/> 
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Filial</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form class="needs-validation"  id= "form4" action="proc_filial.php" method="post" novalidate>
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
                                                <select class="custom-select d-block w-100" name="pais" id="country" required>
                                                    <option value=""></option>
                                                    <option>Brasil</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Please select a valid country.
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="state">Estado</label>
                                                <select class="custom-select d-block w-100" name="estado" id="state" required>
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
                                                <input type="text" class="form-control" name="cep" id="ccep" placeholder="" required>
                                                <div class="invalid-feedback">
                                                    Zip code required.
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="mb-4">
                                        <input type="hidden" name="id_prestador" value="<?php echo $id_prest; ?>" />
                                        <input type="hidden" name="ct" value="<?php echo $ct; ?>" />
                                        <input class="btn btn-primary btn-lg btn-block"  type="submit" name="submit" value="Enviar"/>
                                        <input type="hidden" name="submitted" value="TRUE" />
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            </div>
        </div>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    </body>
</html>
