<?php
include 'menu.php';
require_once ('./inc/Config.inc.php');
require_once './Funcoes/func_data.php';
require 'database_gac.php';
$assunt = "<i class='fas fa-industry'></i> Multas";
$permissa = $_SESSION['permissao'];

$id_contrato = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$sql = "SELECT percent_atrasoEntrega, percent_naoObjeto, percent_descumprimento  FROM contrato WHERE  id_contrato = '$id_contrato' ";
$resultado = mysqli_query($conection, $sql)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado)) {

    $percent_atrasoEntrega = $registro['percent_atrasoEntrega'];
    $percent_naoObjeto = $registro['percent_naoObjeto'];
    $percent_descumprimento = $registro['percent_descumprimento'];
}
?>
<!doctype html>
<html lang="pt">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet"  type="text/css" href="css/stylmulta.css" media="screen"/>	
        <link rel="stylesheet" href="css/bootstrap.css" >

    </head>
    <body>
        <?php require_once 'image_header6.php'; ?>
        <div  class=" container-fluid    "  style="margin-top: 30px">
            <div class="col-md-12 order-md-1">
                <div class="block">
                    <div class="division2" style="background-color:white ;">
                        <div class="row" id="red" style="background-color: white;">
                            <p style="margin-left: 17px;"><b>Cadastro Dos Percentuais</b></p>
                            <div class="col-md-2 mb-10">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                    Inserir (%)
                                </button>
                            </div>
                            <div class="col-md-3 mb-10">
                                <label for="address">Atraso Na Entrega:</label>

                                <input type="number" class="form-control" name="percent_atrasoEntrega" value="<?php echo $percent_atrasoEntrega; ?>" >
                            </div>
                            <div class="col-md-3 mb-10">
                                <label for="address">Não Entrega Do Objeto:</label>
                                <input type="text" class="form-control" value="<?php echo $percent_naoObjeto; ?>" >
                            </div>
                            <div class="col-md-3 mb-10">
                                <label for="address">Violação De Cláusula :</label>
                                <input type="text" class="form-control" value="<?php echo $percent_descumprimento; ?>" >
                            </div>
                        </div>
                    </div>
                    <div class="division3" >
                        2
                    </div>

                </div>

                <div class="block">
                    <div class="division" style="background-color:#f8f9fa;">

                        <div class="row" id="red2" ">
                            <p style="margin-left: 17px;"><b>Atrazo da Entrega</b></p>
                            <div class="col-md-2 mb-10">
                                <button type="button" class="btn btn-primary" >
                                    Cadastrar
                                </button>
                            </div>
                            <div class="col-md-3 mb-10">
                                <label for="address">Referência:</label>

                                <input type="number" class="form-control" name="percent_atrasoEntrega"  >
                            </div>
                            <div class="col-md-3 mb-10">
                                <label for="address">Período:</label>
                                <input type="text" class="form-control">
                            </div>                                
                        </div>
                        <div class=" moti col-md-9 mb-10">
                            <label for="address">Observação:</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>

                    <div class="division" style="background-color:#f8f9fa;" >
                        <table  class=" tb2 table table-hover table-striped table-sm table-bordered bg-light"  >
                            <thead class="thead-dark ">
                                <tr>
                                    <th scope="col">Percentual</th>
                                    <th scope="col">Referência</th>                         
                                    <th scope="col">Período</th>                         
                                    <th scope="col">Subtotal</th>
                                    <th scope="col">Observação</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <?php
                            $mult1 = "SELECT referencia, periodo, subtotal, obs, status, id_multa FROM multa WHERE id_contrato = '$id_contrato' AND categoria= '1'  ORDER BY (id_contrato)";
                            $result1 = mysqli_query($conection, $mult1)or die('Não foi possivel conectar ao MySQL');
                            while ($registro = mysqli_fetch_array($result1)) {

                                $referencia = $registro['referencia'];
                                $periodo = $registro['periodo'];
                                $subtotal = $registro['subtotal'];
                                $obs = $registro['obs'];
                                $status = $registro['status'];
                                $id_multa = $registro['id_multa'];
                                ?>
                                <tr>
                                    <td ><?php echo "1%" ?></td>
                                    <td  ><?php echo $referencia; ?></td>                            
                                    <td ><?php echo $periodo; ?></td>
                                    <td  ><?php echo $subtotal; ?></td>
                                    <td  ><?php echo $obs; ?></td>

                                    <td  ><a  href="#"  data-toggle="modal" data-target="#regModal<?php echo $id_multa ?>">
                                            <?php echo $status; ?>
                                        </a></td>

                                </tr>

                                <!-- Modal Exclusao -->


                                <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>
                <div class="block">
                    <div  class="division1" ">
                        <div class="row" id="red2" style="background-color: white;">
                            <p style="margin-left: 17px;"><b>Não Entrega Do Objeto</b> </p>
                            <div class="col-md-2 mb-10">
                                <button type="button" class="btn btn-primary" >
                                    Cadastrar
                                </button>
                            </div>
                            <div class="col-md-3 mb-10">
                                <label for="address">Referência:</label>

                                <input type="number" class="form-control" name="percent_atrasoEntrega"  >
                            </div>

                        </div>
                        <div class=" moti col-md-9 mb-10">
                            <label for="address">Observação:</label>
                            <input type="text" class="form-control">
                        </div>

                    </div>
                    <div  class="division" >
                        6
                    </div>
                </div>
                <div class="block">
                    <div  class="division1"style="background-color:#f8f9fa;" >
                        <div class="row" id="red2">
                            <p style="margin-left: 17px;"><b>Descumprimento De Clausula</b></p>
                            <div class="col-md-2 mb-10">
                                <button type="button" class="btn btn-primary" >
                                    Cadastrar
                                </button>
                            </div>
                            <div class="col-md-3 mb-10">
                                <label for="address">Referência:</label>

                                <input type="number" class="form-control" name="percent_atrasoEntrega"  >
                            </div>
                            <div class="col-md-3 mb-10">
                                <label for="address">Período:</label>
                                <input type="text" class="form-control">
                            </div>                                
                        </div>
                        <div class=" moti col-md-9 mb-10">
                            <label for="address">Observação:</label>
                            <input type="text" class="form-control">
                        </div> 7
                    </div>
                    <div class="division" style="background-color:#f8f9fa;">
                        8
                    </div>
                </div>
                <div class="block">
                    <div  class="division1"style="background-color:white;" >
                        <div class="row" id="red2">
                            <p style="margin-left: -50px; color:red"><b>MANUTENÇÃO PREVENTIVA</b></p>
                            <div class="col-md-2 mb-10">
                                <button type="button" class="btn btn-primary" >
                                    Cadastrar
                                </button>
                            </div>
                            <div class="col-md-3 mb-10">
                                <label for="address">Referência:</label>

                                <input type="number" class="form-control" name="percent_atrasoEntrega"  >
                            </div>
                            <div class="col-md-3 mb-10">
                                <label for="address">Período:</label>
                                <input type="text" class="form-control">
                            </div>                                
                        </div>
                        <div class=" moti col-md-9 mb-10">
                            <label for="address">Observação:</label>
                            <input type="text" class="form-control">
                        </div> 9
                    </div>
                    <div class="division" style="background-color:white;">
                        10
                    </div>
                </div>
                <div class="block">
                    <p style="margin-left: 0px; color:red"><b>MANUTENÇÃO CORRETIVA</b></p>
                    <table  class="table table-hover table-striped table-sm table-bordered bg-light"   >
                        <thead class="thead-dark ">
                            <tr>
                                <th  scope="col">Nº Chamado</th>
                                <th scope="col">Regional</th>
                                <th scope="col">Crítica</th>
                                <th scope="col"colspan="2" >Abertura</th>
                                <th scope="col"colspan="2" >Atendimento</th>
                                <th scope="col"colspan="2" >Conclusão</th>
                                <th scope="col">Prazo Atendimento</th>
                                <th scope="col">Utilizado Atendimento</th>
                                <th scope="col">Prazo de Conclusão</th> 
                                <th scope="col">Utilizado Conclusão</th>
                                <th   style="background-color: #B22222;">Total Horas Excedentes </th> 
                                <th scope="col">Taxa</th>
                                <th scope="col">Referência</th>
                                <th scope="col">Valor da Multa</th>
                                <th scope="col">Status</th>
                            </tr> 
                        </thead>
                        <?php
                        $sqlcorre = "SELECT * FROM multa WHERE id_contrato = '$id_contrato' AND categoria='5' ORDER BY (data_conclusao) DESC";
                        $resultado = mysqli_query($conection, $sqlcorre)or die('Não foi possivel conectar ao MySQL');
                        while ($registro = mysqli_fetch_array($resultado)) {
                            $data1 = $registro['data_abertura'];
                            $data1 = inverteData($data1);

                            $data2 = $registro['data_atendimento'];
                            $data2 = inverteData($data2);


                            $data3 = $registro['data_conclusao'];
                            $data3 = inverteData($data3);

                            $id_corretiva = $registro['id_corretiva'];

                            if ($status == '1') {
                                $status = 'Ok';
                            }

                            if ($registro['n_chamado'] == 'Nao Houve') {
                                $data3 = '00/00/0000';
                            }
                            ?>
                            <tr>
                                <td class = "td2" ><?php echo $registro['n_chamado']; ?></td>
                                <td class = "td2" ><?php echo $registro['regional']; ?></td>
                                <td class = "td2" ><?php echo $registro['tipo_severidade']; ?></td>
                                <td class = "td2" ><?php echo $data1; ?></td>
                                <td class = "td2" ><?php echo $registro['hora_abertura']; ?></td>
                                <td class = "td2" ><?php echo $data2; ?></td>
                                <td class = "td2" ><?php echo $registro['hora_atendimento']; ?></td>
                                <td class = "td2" ><?php echo $data3; ?></td>
                                <td class = "td2" ><?php echo $registro['hora_conclusao']; ?></td>
                                <td class = "td2" ><?php echo $registro['prazo_atendimento']; ?></td>
                                <td class = "td2" ><?php echo $registro['subtotal_atendimento']; ?></td>
                                <td class = "td2" ><?php echo $registro['prazo_conclusao']; ?></td>       
                                <td class = "td2" ><?php echo $registro['subtotal_conclusao']; ?></td>
                                <td class = "td2" ><?php echo $registro['total']; ?></td>
                                <td class = "td2" > <?php echo $registro['taxa']; ?> </td>
                                <td class = "td2" ><a data-toggle="modal" data-target="#references" href="#">
                                        <?php echo $registro['referencia']; ?></a></td>
                                <td class = "td2" ><?php echo $registro['subtotal']; ?></td>
                                <!-- Permissão -->
                                <td>
                                    <a data-toggle="modal" data-target="#exampleModal2<?php echo $id_corretiva ?>" href="#">
                                        <i class="far fa-edit"></i>
                                    </a>
                                </td>

                                <!--Permissão -->
                            </tr>
                            <div class="modal fade" id="references" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Referência </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                        </div>                             
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </table>
                </div>
                <div class="block">
                    <div  class="division1"style="background-color:white;" >
                        13
                    </div>
                    <div class="division" style="background-color:white;">
                        14
                    </div>
                </div>
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Referência </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                            </div>                             
                        </div>
                    </div>
                </div>







            </div>
            <script src="js/jquery-3.2.1.slim.min.js"></script>
            <script src="js/popper.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <script defer src="js/fontawesome-all.min.js"></script>
    </body>
</html>