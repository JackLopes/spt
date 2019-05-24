
<?php
session_start();

require 'database_gac.php';

$q1 = "SELECT * FROM chat ORDER BY data ";
$result = mysqli_query($conection, $q1);
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
    </head>
    <body>
        <nav class="navbar navbar-light bg-light">
            <a class="navbar-brand" href="#">LISTA DE DEMANDAS & SUGESTOES</a>
        </nav>
    <center><div class="col-md-12 order-md-1">
            <h4 class="mb-3"></h4>

            <div  class="container-fluid">
                <?php
                if (!empty($_SESSION['msg28'])) {
                    echo $_SESSION['msg28'];
                    unset($_SESSION['msg28']);
                }
                ?> 
                <table class="table table-striped"  >
                    <thead class="thead-light ">
                        <tr>
                            <th scope="col">Autor</th>
                            <th scope="col">Demanda & Sugestoes</th>                         
                            <th scope="col">Data Registro</th>
                            <th scope="col">Status</th>
                            <th scope="col">Excluir</th>
                        </tr>
                    </thead>
                    <?php
                    while ($res = mysqli_fetch_array($result)) {
                        ?>
                        <tr>
                            <td><?php echo $res['pseudo']; ?></td> 
                            <td><?php echo $res['mensagem']; ?></td> 
                            <td><?php echo $res['data']; ?></td>                            
                            <td>
                                <a href=""  data-toggle="modal" data-target="#exampleModal<?php echo $res['id_chat'] ?>"><?php echo "<font color='#0080FF'>" . $res['status'] . "</font>"; ?></a>
                            </td>
                            <td> <a class = "td2" href="lista_chat.php?id_chat=<?php echo $res['id_chat'] ?>"><i class="fas fa-eraser"></i></a></td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal<?php echo $res['id_chat'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-left" id="exampleModalLabel"><?php echo $res['mensagem']; ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form  class=" updates needs-validation "   action="atu_chat.php"  method="post" novalidate>  
                                        <div  class="container" >	
                                            <div class="form-row"> 
                                                <div class="form-group col-md-8"> 
                                                    <label class="mods2" for="caplicacao_multa" >STATUS</label>
                                                    <select class="custom-select"name="status" id="cstatus"  >
                                                        <option selected></option>
                                                        <option value="Pendente">Pendente</option>
                                                        <option value="Executado">Executado</option>                                                           
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4"> 
                                                    <input class="form-control"  type="hidden" name="id_chat" id="cid_chat"  value="<?php echo $res['id_chat']; ?>" >
                                                    <input  class="btn btn-outline-primary" type="submit"  style="margin-top:30px;" value="ENVIAR"  class="btn btn-primary ">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </table>
            </div>
            <script src="js/popper.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
            </body>            
            </html>
