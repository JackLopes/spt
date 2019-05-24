<?php
include 'menu.php';
require_once ('./inc/Config.inc.php');
require_once './Funcoes/mascara_php.php';
require 'database_gac.php';
$assunt = "<i class='fas fa-industry'></i> Lista de Entidades";
$permissa = $_SESSION['permissao'];

$id_prestador = filter_input(INPUT_GET, 'id_prestador', FILTER_SANITIZE_NUMBER_INT);

$sql = "select * from prestador ORDER BY nome ";
$con = mysqli_query($conection, $sql);
?>

      
      
       
  
        <?php require_once 'image_header6.php'; ?>
       <div  class=" container-fluid    "  style="margin-top: 30px">
            <div class="col-md-12 order-md-1">
                <?php
               

                if ($permissa < '4') {

                    if (!empty($id_prestador)) {
                        $apagarPrestador = new Delete();
                        $apagarPrestador->ExeDelete('prestador', 'WHERE id_prestador = :id', "id={$id_prestador}");
                        echo $apagarPrestador->getMsg();
                    }
                } else {
                    $_SESSION['msg50'] = "<span style='color:red;'> Você não Tem Prmissão para Excluir Registros desta Lista</span>";
                }
                
                 if (!empty($_SESSION['msg50'])) {

                    echo $_SESSION['msg50'];

                    unset($_SESSION['msg50']);
                }
                ?>
                <table  class="table table-hover table-striped table-sm table-bordered bg-light"   >
                    <thead class="thead-dark ">
                        <tr>
                            <th scope="col">Nome Fantasia</th>
                             <th scope="col">Sigla</th>
                            <th scope="col">Nº do CNPJ </th>
                            <th scope="col">Endereço</th>       
                            <th scope="col">Editar</th>
                               <?php if ($permissa == '2') { ?>
                            <th scope="col">Excluir</th>
                              <?php } ?>
                    </thead>
                    <?php
                    while ($res = mysqli_fetch_array($con)) {
                        ?>
                        <tr>

                            <td><?php echo $res['nome']; ?></td> 
                             <td><?php echo $res['mnemonico']; ?></td> 
                            <td><?php echo masc_cnpj_php($res['cnpj']); ?></td> 
                            <td><?php echo $res['endereco']; ?></td> 
                            <td><a id="a2" href="atu_prestador.php?id_prest=<?php echo $res['id_prestador'] ?>"><i class="far fa-edit"></a></td>
                             <?php if ($permissa == '2') { ?>
                                        <td> <a  href="#"  data-toggle="modal" data-target="#exampleModal5<?php echo$res['id_prestador'] ?>"><i class="fas fa-eraser"></i></a></td>
  <?php } ?>

                        </tr>
                        <!-- Modal Exclusao -->
                        <div class="modal fade" id="exampleModal5<?php echo $res['id_prestador']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Deseja Realmente Deletar  </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p><?php echo $res['nome']; ?></p>
                                        <ul class="nav justify-content-center">     
                                            <li class="nav-item">
                                                <a class="btn btn-danger"  href="lista_prestador.php?id_prestador=<?php echo $res['id_prestador'] ?>">Sim</a>
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

            </div>
        </div>
       <?php require_once 'foot.php';?>
    </body>
</html>