
<?php
$page_title = 'Indicadores';
require_once 'menu.php';
?>
<!doctype html>
<html lang="pt">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
        <link rel="stylesheet" href="css/bootstrap.css" >
        <link rel="stylesheet"  type="text/css" href="css/stylepaineis1.css" media="screen"/>
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script defer src="js/fontawesome-all.min.js"></script>
        <script type="text/javascript">

            $(document).ready(function () {
                $('#teste').modal('show');
            })
        </script>

        <style>
            .dist{
                margin-bottom: 30px;

            }
            .dist li{
                background-color: #e9edf0;

            }
        </style>
    </head>
    <body style="background-color: #343a40;;" >
        <!-- Modal -->
        <div class="modal fade" id="teste" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  data-backdrop="static" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <?php
                        require_once './gatway_corretiva.php';
                        $nome_para = $_SESSION['nome'];
 if ($permissa != 2) { 

                        $total = total_ocorrencia_nome($nome_para);
                        $notas = notasMedir($nome_para);
                        $entrega= total_itens_nome($nome_para);
                        $prevent=total_preventiva_nome($nome_para);
 }           

                        ?>
                        <h5 style=" font-size: 30px;font-family: times new roman; font-weight: bold;" class="modal-title" id="exampleModalLabel"><?php echo $nome_para ?></h5>

                    </div>
                    <div class="modal-body">
                        <?php if ($permissa != 2) { ?>

                            <ul class=" dist list-group ">
                                <li style=" font-size: 23px; font-weight: bold; color:red; font-family: times new roman;" class="list-group-item d-flex justify-content-between align-items-center">
                                    Manutenção Corretivas a Verificar:
                                    <a  class="badge badge-danger badge-pill" href="#" onclick="window.open('controle_corretiva.php?nome=<?php echo $nome_para ?> ', 'popup3', 'width=1300,height=800,scrolling=auto,top=0,left=0')"> <?php echo $total; ?></a>                                    
                                </li>
                            </ul>
                            <ul class="dist list-group ">
                                <li style=" font-size: 23px; font-weight: bold; color:green; font-family: times new roman;" class="list-group-item d-flex justify-content-between align-items-center">
                                    Manutenção Preventiva a Verificar:
                                    <a  class="badge  badge-success badge-pill" href="#" onclick="window.open('controle_preventiva.php?nome=<?php echo $nome_para ?> ', 'popup3', 'width=1300,height=800,scrolling=auto,top=0,left=0')"> <?php echo $prevent; ?></a>                                    
                                </li>
                            </ul>
                            <ul class="dist list-group">
                                <li style=" font-size: 23px; font-weight: bold; color:blue; font-family: times new roman;" class="list-group-item d-flex justify-content-between align-items-center">
                                    Itens Pendencias Entregas:
                                    <a  class="badge badge-primary badge-pill" href="#" onclick="window.open('controle_itens.php?nome=<?php echo $nome_para ?> ', 'popup3', 'width=1300,height=800,scrolling=auto,top=0,left=0')"> <?php echo $entrega; ?></a>                                    
                                </li>
                            </ul>
                            <ul class="dist list-group">
                                <li style=" font-size: 23px; font-weight: bold; color:#df7700; font-family: times new roman;" class="list-group-item d-flex justify-content-between align-items-center">
                                    Notas A Medir:
                                    <a  class="badge badge-warning badge-pill" href="#" onclick="window.open('atestes.php?nome=<?php echo $nome_para; ?>&verif=verif', 'popup3', 'width=1300,height=800,scrolling=auto,top=0,left=0')"> <?php echo $notas; ?></a>                                    
                                </li>
                            </ul>
                        <?php } else {
                            atualisacao_automatica($_SESSION['permissao']); ?>
                            <table class="tb3 table-striped table table-sm table-hover ">
                                <thead class="">
                                    <tr>
                                        <th colspan="2" style=" background-color: #df7700;color: white; text-align: center;" >NOTAS A MEDIR</th> 
                                    </tr>
                                    <tr>
                                        <th  scope="col" style="color: #df7700; font-family: times new roman;font-size: 25px;">Nome: </th>  
                                        <th  scope="col" style="color: #df7700; font-family: times new roman;font-size: 25px;">Total:</th>  
                                    </tr>
                                </thead>
                                <?php
                                $sql_gestor = "SELECT * FROM  historico_processo WHERE categoria = '1' ";
                                $resultado = mysqli_query($conection, $sql_gestor)or die('Não foi possivel conectar ao MySQL');
                                while ($registro = mysqli_fetch_array($resultado)) {
                                    ?> 
                                    <tr>
                                        <td class = "td2"  style=" font-size: 24px;" > <a   href="#" onclick="window.open('atestes.php?nome=<?php echo $registro['nome']; ?>&verif=verif', 'popup3', 'width=1300,height=800,scrolling=auto,top=0,left=0')"><?php echo $registro['nome']; ?></a></td>                              
                                        <td class = "td2"style=" font-size: 20px; text-align: center; font-weight: bold" ><?php echo $registro['total_ocorre']; ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <br>
                            </table>
                            <table class="tb3 table table-sm table-striped table-hover ">
                                <thead class="">
                                    <tr>
                                        <th colspan="2" style=" background-color: red;color: white; text-align: center;" >MANUTENÇÃO CORRETIVA A VERIFICAR </th> 
                                    </tr>
                                    <tr>
                                        <th  scope="col" style="color: red; font-family: times new roman; font-size: 25px;">Nome: </th>  
                                        <th  scope="col" style="color: red; font-family: times new roman;font-size: 25px;">Total:</th>  
                                    </tr>
                                </thead>
                                <?php
                                $sql_gestor = "SELECT * FROM  historico_processo WHERE categoria = '4' ";
                                $resultado = mysqli_query($conection, $sql_gestor)or die('Não foi possivel conectar ao MySQL');
                                while ($registro = mysqli_fetch_array($resultado)) {
                                    ?> 
                                    <tr>
                                        <td class = "td2" style=" font-size: 24px;"> <a   href="#" onclick="window.open('controle_corretiva.php?nome=<?php echo $registro['nome']; ?> ', 'popup3', 'width=1300,height=800,scrolling=auto,top=0,left=0')"><?php echo $registro['nome']; ?></a></td>                              
                                        <td class = "td2"style=" font-size: 20px; text-align: center; font-weight: bold" ><?php echo $registro['total_ocorre']; ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <br>
                            </table>
                            <table class="tb3 table table-sm table-hover ">
                                <thead class="thead-light">
                                    <tr>
                                        <th colspan="2" style=" background-color: green;color: white; text-align: center;" >MANUTENÇÃO PREVENTIVAS A VERIFICAR </th> 
                                    </tr>
                                    <tr>
                                        <th  scope="col">Nome: </th>  
                                        <th  scope="col">Total:</th>  
                                    </tr>
                                </thead>
                                <?php 
                                  $sql_gestor = "SELECT * FROM  historico_processo WHERE categoria = '2' ";
                                  $resultado = mysqli_query($conection, $sql_gestor)or die('Não foi possivel conectar ao MySQL');
                                  while ($registro = mysqli_fetch_array($resultado)) {
                                  ?> 
                                <tr>

                                    <td class = "td2" > <a   href="#" onclick="window.open('controle_preventiva.php?nome=<?php echo $registro['nome']; ?> ', 'popup3', 'width=1300,height=800,scrolling=auto,top=0,left=0')"><?php echo $registro['nome']; ?></a></td>                              

                                     <td class = "td2"style=" font-size: 20px; text-align: center; font-weight: bold" ><?php echo $registro['total_ocorre']; ?></td>

                                </tr>
                                <?php
                                    } 
                                ?>
                                <br>
                            </table>
                            <table class="tb3 table-striped table table-sm table-hover ">
                                <thead class="">
                                    <tr>
                                        <th colspan="3" style=" background-color: blue;color: white; text-align: center;" >ITENS PENDÊNCIAS ENTREGAS</th> 
                                        
                                    </tr>
                                    <tr>
                                       <th  scope="col" style="color: blue; font-family: times new roman; font-size: 25px;">Nome: </th>  
                                        <th  scope="col" style="color: blue; font-family: times new roman;font-size: 25px;">Total:</th>   
                                    </tr>
                                </thead>
                                <?php
                                $sql_gestor = "SELECT * FROM  historico_processo WHERE categoria = '3' ";
                                $resultado = mysqli_query($conection, $sql_gestor)or die('Não foi possivel conectar ao MySQL');
                                while ($registro = mysqli_fetch_array($resultado)) {
                                    ?> 
                                    <tr>
                                        <td class = "td2" style=" font-size: 24px;"> <a   href="#" onclick="window.open('controle_itens.php?nome=<?php echo $registro['nome']; ?> ', 'popup3', 'width=1300,height=800,scrolling=auto,top=0,left=0')"><?php echo $registro['nome']; ?></a></td>                              
                                        
                                        <td class = "td2"style=" font-size: 20px; text-align: center; font-weight: bold" ><?php echo $registro['total_ocorre']; ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <br>
                            </table>

                            <?php
                        }
                        ?>
                    </div>
                    <div class="modal-footer">
                        <a href="Painel.php" class="btn btn-secondary" >CONTINUA</a>

                    </div>
                </div>
            </div>
        </div> 
    </body>
</html>