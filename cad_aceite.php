<?php
session_start();
require_once ('./inc/Config.inc.php');
require_once 'database_gac.php';
require_once './Funcoes/func_data.php';

$Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$id_aceite = filter_input(INPUT_GET, 'id_aceite', FILTER_VALIDATE_INT);

$id_tipo = $_SESSION['tip'] = filter_input(INPUT_GET, 'id_tipo', FILTER_VALIDATE_INT);

require_once 'valida_permissao.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
}
if (isset($_GET['se'])) {
    $serie = $_GET['se'];
}
if (isset($_GET['pa'])) {
    $patrimonio = $_GET['pa'];
}
?>

<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
        <link rel="stylesheet"  type="text/css" href="" media="screen"/>
        <link rel="stylesheet" href="css/bootstrap.css" >
        <script defer src="js/fontawesome-all.min.js"></script>

        <style>
            .prill{
                color: blue;
            }

        </style>
    </head>
    <body >
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Observações</a>
        </nav>
        <div  class="container-fluid" >
            
            <div  class="row  justify-content-center" >
                <div  class=" col-md-8 ml-sm-6 col-lg-10 pt-0 justify-content-center" >

        <div class="col-md- order-md-1">
            <center><h5 class="mb-3" >Observações</h5></center>
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
            <hr class="mb-4">
        </div>
        
                    <div>
                        <?php
                        echo '<h5> Serie: ' . $serie . '</h5> ';
                        echo "<h5>Patrimônio: " . $patrimonio . '</h5><br> ';
                        ?>
                    </div>
                    <?php
                    if (!empty($Dados['submit'])) {
                        unset($Dados['submit']);
                        $UpdObservacao = new UpdObservacao();
                        $UpdObservacao->ExeUpdate($id_aceite, $Dados);
                        echo $UpdObservacao->getMsg();
                    }


                    $i = 0;

                    $severi = "SELECT tip.* , ite.descricao, ace.data_registro,ace.categoria, ace.assunto,ace.observacao,ace.prorrogacao,
				ite.serie, ite.patrimonio, ite.regional, ace.id_iten, ace.id_aceite		
				FROM tipo AS tip
				LEFT JOIN itens AS ite ON  ite.id_tipo = tip.id_tipo
				LEFT JOIN aceite AS ace ON  ace.id_iten = ite.id_itens
				WHERE id_iten = '$id' AND ace.categoria='1'";


                    $resultado = mysqli_query($conection, $severi)or die('Não foi possivel conectar ao MySQL');
                    while ($registro = mysqli_fetch_array($resultado)) {
                        $i = $i + 1;
                        $id_aceite = $registro['id_aceite'];
                        $regional= $registro['regional'];
                        
                        ?>

                        <table class="table table-sm  table-hover table-bordered" id="tb2">
                            <thead class="thead-light">
                                <tr >
                                    <th scope="col">Ordem dos Eventos</th>
                                    <th scope="col">Data / Hora do Registro</th>                              
                                    <th scope="col">Assunto</th>
                                    <th scope="col"><center>Observação</center></th>
                            <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?> 
                                <th scope="col">Excluir</th>
                            <?php } ?>
                            </thead>
                            </tr> 
                            <tbody>
                                <tr>
                                    <td ><?php echo $i . "º"; ?></td>  
                                    <td ><?php echo $registro['data_registro']; ?></td>
                                    <td ><?php echo $registro['assunto']; ?></td>
                                  
                                    <td ><a data-toggle="modal" href="#" data-target="#example2<?php echo $id_aceite; ?>" ><?php echo $registro['observacao']; ?></a></td>
                                    <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?> 
                                        <td ><a  href="#"  data-toggle="modal" data-target="#exampleModal5<?php echo $id_aceite ?>">
                                                <i class="fas fa-eraser "></i> 
                                            </a></td>
                                    <?php } ?>
                                </tr>
                                <!-- Modal -->
                            <div class="modal fade" id="example2<?php echo $id_aceite; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class=" prill modal-title" id="exampleModalLongTitle"><?php echo 'Assunto: ' . $registro['assunto']; ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form   class="needs-validation "   action="cad_aceite.php?id=<?php echo $id; ?>&se=<?php echo $serie; ?>&pa=<?php echo $patrimonio; ?>"  method="post" novalidate>
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label class="prill" for="cassunto" >Assunto:</label>
                                                        <input class="form-control" Type="text" name="assunto" id="cassunto" value="<?php echo $registro['assunto']; ?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label class="prill" for="cprorrogacao" >Data Prorrogação: <font style=" color: red">(Somente se Houver Previsão)</font></label>
                                                        <input class="form-control" Type="date" name="prorrogacao" id="cprorrogacao" value="<?php echo $registro['prorrogacao']; ?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label class="prill" for="cobservacao">Observação</label>
                                                        <input  class="form-control" id="cobservacao"  name="observacao" rows="5" value="<?php echo $registro['observacao']; ?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 mb-10">                                                 
                                                        <input class="btn btn-primary btn-sm btn-block"  type="submit" name="submit" value="Enviar"/> 
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <!-- Modal Exclusao -->
                            <div class="modal fade" id="exampleModal5<?php echo $id_aceite; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Deseja Realmente Deletar  </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p><?php echo 'Esta ' . $i . "º" . ' ' . 'Observação'; ?></p>
                                            <ul class="nav justify-content-center">     
                                                <li class="nav-item">
                                                    <a class="btn btn-danger"  href ="delet_aceite.php?id_aceite=<?php echo $id_aceite; ?>&se=<?php echo $serie; ?>&pa=<?php echo $patrimonio; ?>&id_tipo=<?php echo $id_tipo; ?>&id=<?php echo $id ?>">Sim</a>
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
                        </tbody>
                    </table>
                   
                    <div class="col-md- order-md-1" style=" margin-top: 100px;">
                        <center><h5 class="mb-3" >Prorrogacoes</h5></center>
                        <?php
                        if (isset($_SESSION['msg'])) {
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                        ?>
                        <hr class="mb-4">
                    </div>
                    <?php
                    $i = 0;

                    $severi = "SELECT tip.* , ite.descricao, ace.data_registro, ace.assunto,ace.observacao,ace.prorrogacao,
				ite.serie, ite.patrimonio, ace.id_iten, ace.id_aceite		
				FROM tipo AS tip
				LEFT JOIN itens AS ite ON  ite.id_tipo = tip.id_tipo
				LEFT JOIN aceite AS ace ON  ace.id_iten = ite.id_itens
				WHERE id_iten = '$id' AND ace.categoria='2'";


                    $resultado = mysqli_query($conection, $severi)or die('Não foi possivel conectar ao MySQL');
                    while ($registro = mysqli_fetch_array($resultado)) {
                        $i = $i + 1;
                        $id_aceite = $registro['id_aceite'];
                        ?>

                    <table class="table table-sm  table-hover table-bordered" id="tb2" >
                            <thead class="thead-light">
                                <tr >
                                    <th scope="col">Ordem dos Eventos</th>
                                    <th scope="col">Data / Hora do Registro</th>                             
                                
                                    <th scope="col">Data Prorrogada para entrega de Objeto</th>

                                    <th scope="col"><center>Observação</center></th>
                            <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?> 
                                <th scope="col">Excluir</th>
                            <?php } ?>
                            </thead>
                            </tr> 
                            <tbody>
                                <tr>
                                    <td ><?php echo $i . "º"; ?></td>  
                                    <td ><?php echo $registro['data_registro']; ?></td>
                                   
                                    <td ><?php echo inverteData($registro['prorrogacao']); ?></td>
                                    <td ><a data-toggle="modal" href="#" data-target="#example2<?php echo $id_aceite; ?>" ><?php echo $registro['observacao']; ?></a></td>
                                    <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?> 
                                        <td ><a  href="#"  data-toggle="modal" data-target="#exampleModal5<?php echo $id_aceite ?>">
                                                <i class="fas fa-eraser "></i> 
                                            </a></td>
                                    <?php } ?>
                                </tr>
                                <!-- Modal -->
                            <div class="modal fade" id="example2<?php echo $id_aceite; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class=" prill modal-title" id="exampleModalLongTitle"><?php echo 'Assunto: ' . $registro['assunto']; ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form   class="needs-validation "   action="cad_aceite.php?id=<?php echo $id; ?>&se=<?php echo $serie; ?>&pa=<?php echo $patrimonio; ?>"  method="post" novalidate>
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label class="prill" for="cassunto" >Assunto:</label>
                                                        <input class="form-control" Type="text" name="assunto" id="cassunto" value="<?php echo $registro['assunto']; ?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label class="prill" for="cprorrogacao" >Data Prorrogação: <font style=" color: red">(Somente se Houver Previsão)</font></label>
                                                        <input class="form-control" Type="date" name="prorrogacao" id="cprorrogacao" value="<?php echo $registro['prorrogacao']; ?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label class="prill" for="cobservacao">Observação</label>
                                                        <input  class="form-control" id="cobservacao"  name="observacao" rows="5" value="<?php echo $registro['observacao']; ?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 mb-10">                                                 
                                                        <input class="btn btn-primary btn-sm btn-block"  type="submit" name="submit" value="Enviar"/> 
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <!-- Modal Exclusao -->
                            <div class="modal fade" id="exampleModal5<?php echo $id_aceite; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Deseja Realmente Deletar  </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p><?php echo 'Esta ' . $i . "º" . ' ' . 'Observação'; ?></p>
                                            <ul class="nav justify-content-center">     
                                                <li class="nav-item">
                                                    <a class="btn btn-danger"  href ="delet_aceite.php?id_aceite=<?php echo $id_aceite; ?>&se=<?php echo $serie; ?>&pa=<?php echo $patrimonio; ?>&id_tipo=<?php echo $id_tipo; ?>&id=<?php echo $id ?>">Sim</a>
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script src="js/jquery-3.2.1.slim.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>