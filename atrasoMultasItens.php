<?php
include 'menu.php';
require_once ('./inc/Config.inc.php');
require_once './Funcoes/func_data.php';
require 'database_gac.php';
require_once './Funcoes/mask_valor.php';


$permissa = $_SESSION['permissao'];

$id_contrato = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$id_itens = filter_input(INPUT_GET, 'id_itens', FILTER_SANITIZE_NUMBER_INT);
$id_tipo = filter_input(INPUT_GET, 'id_tipo', FILTER_SANITIZE_NUMBER_INT);

$sql = "SELECT percent_atrasoEntrega, percent_naoObjeto, percent_descumprimento, rg  FROM contrato WHERE  id_contrato = '$id_contrato' ";
$resultado = mysqli_query($conection, $sql)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado)) {

    $percent_atrasoEntrega = $registro['percent_atrasoEntrega'];
    $percent_naoObjeto = $registro['percent_naoObjeto'];
    $percent_descumprimento = $registro['percent_descumprimento'];
    $rg = $registro['rg'];
}
require_once './Funcoes/calculo_multas.php';



$assunt = "<i class=''></i> Atraso na Entrega de Itens " . "- " . "RG " . $rg;
?>
<!doctype html>
<html lang="pt">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">       	
        <link rel="stylesheet" href="css/bootstrap.css" >
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>

        <style>
            .Assunt{
                position:absolute;
                margin-top: -130px;
                margin-left: 50px;
                color:white;
                font-size: 200%;

            }
            .format{color: black;
                    margin-left:10px;

            }
            .btns{
                margin-top: 30px;
            }
            .nav a {

                margin-left: 10px;

            }
            .nav  {

                margin-left: -25px;
                margin-bottom: 10px;
            }
            .coment{
                background-color: #6c757d;
                margin-top: 40px;
                color: white;
                padding-left: 5px; 
                padding: 3px;
            }
            #envi{
                margin-top: 30px;
            }
            .tb2{
                margin-top: -16px;
            }

            #forms{
                background-color:#e9ecef; 
                padding: 10px;
                padding-bottom: 20px;
                color:  #6c757d;
                margin-top: -15px;

            }
            #forms input{
                background-color: #f8f9fa; 

            }
        </style>
    </head>
    <body>
        <?php require_once 'image_header6.php'; ?>
        <div  class=" container-fluid    "  style="margin-top: 30px">
            <div class="  col-md-10 order-md-1"style="margin:auto">
                <div class="nav">
                    <nav class="  navbar navbar-light ">                 
                        <?php if (!empty($id_itens)) { ?>
                            <a class="btn btn-primary" href="cad_aceite2.php?id_itens=<?php echo $id_itens ?>&id_tipo=<?php echo $id_tipo ?>">RETORNAR</a> 

                        <?php } else if (empty($id_itens)) { ?>

                            <a class="btn btn-primary" href="painelMultas.php?id=<?php echo $id_contrato ?>">RETORNAR</a> 
                        <?php } ?>

                        <a class="btn btn-primary" href="painelMultas.php?id=<?php echo $id_contrato ?>">PAINEL MULTAS</a>
                        <a class="btn btn-primary" href="multaAtrasoItens.php?id=<?php echo $id_contrato ?>&id_itens=<?php echo $id_itens ?>&id_tipo=<?php echo $id_tipo ?>">RELATÓRIO</a>
                    </nav>
                </div>

                <div  >
                    <p class="coment">OCORRÊNCIAS PASSIVEIS DE MULTAS</p>
                    <table  class=" tb2 table table-hover table-striped table-sm table-bordered bg-light"  >
                        <thead class="thead-dark ">
                            <tr>
                                <th scope="col">Regional</th>
                                <th scope="col">Patrimônio</th>
                                <th scope="col">Prazo Entrega</th>                         
                                <th scope="col">Prorrogação</th>                         
                                <th scope="col">Entrega Objeto</th> 
                                <th scope="col">Atraso Entrega (Dias)</th>                                                          
                                <th scope="col">Percentual Multa</th>
                                <th scope="col">Referência (Valor)</th>                         
                                <th scope="col">Multa Objeto</th>                               
                                <th scope="col">Observação</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <?php
                        $mult1 = "SELECT id_multa, referencia,subtotal, obs, status,regional, n_patrimonio,prazo_entrega_itens, prorrogacao_itens,entrega_itens,
        atraso_itens FROM multa WHERE id_contrato = '$id_contrato' AND categoria= '2'  ORDER BY (regional)";
                        $result1 = mysqli_query($conection, $mult1)or die('Não foi possivel conectar ao MySQL');
                        while ($registro = mysqli_fetch_array($result1)) {

                            $status = $registro['status'];

                            if ($status == 1) {
                                $status = "<font style='color:green'>Incluido</font>";
                            } else if ($status == 3) {
                                $status = "<font style='color:blue'>Multa Aplicada</font>";
                            } else {
                                $status = "<font style='color:red'>Incluir</font>";
                            }





                            $id_multa = $registro['id_multa'];
                            ?>
                            <tr>
                                <td ><?php echo $registro['regional']; ?></td>
                                <td ><?php echo $registro['n_patrimonio']; ?></td>
                                <td ><?php echo inverteData($registro['prazo_entrega_itens']); ?></td>
                                <td ><?php echo inverteData($registro['prorrogacao_itens']); ?></td>
                                <td ><?php echo inverteData($registro['entrega_itens']); ?></td>
                                <td ><?php echo $registro['atraso_itens']; ?></td>
                                <td ><?php echo $registro['obs']; ?></td>
                                <td ><?php echo $registro['referencia']; ?></td>
                                <td ><?php echo $registro['subtotal']; ?></td>
                                <td ><?php echo $registro['obs']; ?></td>



                                <td  ><a  href="#"  data-toggle="modal" data-target="#exampleModal<?php echo $id_multa ?>">
                                        <?php echo $status; ?>
                                    </a></td>

                            </tr>
                            <?php if ($status != "<font style='color:blue'>Multa Aplicada</font>") { ?>

                                <!-- Modal -->
                                <div class="modal fade"  id="exampleModal<?php echo $id_multa ?>"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Confirmar Aplicação da Multa</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <form class="needs-validation"  id="fm6"  action="atu_confirma_multa.php?action=atrasoMultasItens" method="post" novalidate>


                                                    <div class="row">
                                                        <div class="col-md-9 mb-10">
                                                            <label class="mods1" for="cstatus" >Aplicar Multa?</label>
                                                            <select class="custom-select" name="status" >
                                                                <option selected>Selecione</option>
                                                                <option value="1">Sim</option>
                                                                <option value="2">Não</option>                                                           
                                                            </select>
                                                        </div> 
                                                        <div class=" btns col-md-2 mb-10"> 
                                                            <input name="id_contrato" type="hidden" value=<?php echo $id_contrato; ?>>
                                                            <input name="id_itens" type="hidden" value=<?php echo $id_itens; ?>>
                                                            <input name="id_multa" type="hidden" value=<?php echo $id_multa; ?>>
                                                            <input name="valor_multa" type="hidden" value=<?php echo $registro['subtotal']; ?>>
                                                            <input name="categoria" type="hidden" value='1'>
                                                            <input name="id_tipo" type="hidden" value=<?php echo $id_tipo; ?>>
                                                            <input id="envi" type="submit" name="submit" value="ENVIAR"   class="btn btn-primary" /></center><p>

                                                        </div> 
                                                    </div> 

                                                </form>
                                            </div> 
                                        </div> 
                                    </div>       
                                </div>

                            <?php } ?>
                            <?php
                        }
                        ?>
                    </table>
                </div>
                <div>
                    <?php
                    if
                    (isset($_SESSION['msg23'])) {
                        echo $_SESSION['msg23'];
                        unset($_SESSION['msg23']);
                    }
                    ?>
                    <div> 
                        <p class="coment" >CADASTRO DA SOMATÓRIA PARA POSSIVEL APLICAÇÃO DE MULTA</p>
                        <form class="needs-validation" id="forms"    action="atu_confirma_multa.php?action=inclusaoMulta" method="post" novalidate>

                            <div class="row">
                                <div class="col-md-3 mb-10">
                                    <label class="mods1"  >TOTAL PREVISTO ATUAL:</label>
                                    <input Type="text" class="form-control"  value="<?php echo "R$ " . number_format($A, 2, ',', '.'); ?>"  disabled/>
                                </div> 
                                <div class="col-md-3 mb-10">
                                    <label class="mods1"  >TOTAL APLICADO:</label>
                                    <input Type="text" class="form-control "  value="<?php echo "R$ " . number_format($total_aplicado_itens, 2, ',', '.'); ?>"  disabled/>
                                </div> 
                                <div class="col-md-3 mb-10">
                                    <label class="mods1"  >LIMITE APLICAVEL:</label>
                                    <input Type="text" class="form-control"   value="<?php echo "R$ " . $valor_limitacao_pacial1 ?>"  disabled/>
                                </div> 

                                <div class="col-md-3 mb-10">
                                    <label class="mods1" for="cvalor_multa_aplicado" >VALOR CALCULADO APLICAÇÃO DE MULTA :</label>
                                    <input Type="text" class="form-control "  name="valor_multa_aplicado" id="cn_chamado"   value="<?php echo $AD ?>"  disabled/>
                                </div> 


                            </div> 
                            <div style=" margin-top: 10px;" class="row">
                                <div class="col-md-11 mb-10">
                                    <label class="mods1" for="cobservacao" >OBSERVAÇÃO:</label>
                                    <input Type="text" class="form-control"  name="observacao" >
                                </div>



                                <div class="  col-md-1 mb-10"> 
                                    <input name="id_contrato" type="hidden" value=<?php echo $id_contrato; ?>>
                                    <input name="categoria" type="hidden" value='1'>
                                    <input name="valor_multa_aplicado" type="hidden" value=<?php echo $AD ?>>
                                    <input name="total_acumulado" type="hidden" value=<?php echo $AF; ?>>
                                    <input name="id_itens" type="hidden" value=<?php echo $id_itens; ?>>                                                        
                                    <input name="id_tipo" type="hidden" value=<?php echo $id_tipo; ?>>
                                    <button  type="submit" name="submit" value="ENVIAR"  id="envi" class="btn btn-primary" >CADASTRAR</button>                                                                         
                                </div> 
                            </div> 

                        </form>   
                    </div>

                    <p class="coment">HISTÓRICO DE LANÇAMENTOS</p>
                    <table class=" tb2 table table-hover table-striped table-sm table-bordered bg-light"  >
                        <thead class="thead-dark ">
                            <tr>
                                <th scope="col">Data Registro</th>
                                <th scope="col">SISCOR</th>
                                <th scope="col">Tipo de Infração</th>
                                <th scope="col">Valor Calculado</th>
                                <th scope="col">Valor Aplicado</th>
                                <th scope="col">Observação</th>
                                <th scope="col">Atualizar</th>
                                <th scope="col">Excluir</th>



                                <?php
                                $sql20 = "SELECT *  FROM historico_multa WHERE id_contrato = '$id_contrato' AND categoria='1' ";
                                $result = mysqli_query($conection, $sql20)or die('Não foi possivel conectar ao MySQL');
                                while ($registro1 = mysqli_fetch_array($result)) {



                                    $data_registro = $registro1['data_registro'];
                                    $valor_multa_aplicado = $registro1['valor_multa_aplicado'];
                                    $valor_multa_definitivo = $registro1['valor_multa_definitivo'];
                                    $siscor = $registro1['siscor'];
                                    $observacao = $registro1['observacao'];
                                    $categoria = $registro1['categoria'];

                                    switch ($categoria) {
                                        case 1:
                                            $categoria = "Atraso na Entrega do Objeto";
                                            break;
                                        case 5:
                                            $categoria = "Descumprimento SLA Corretiva";
                                            break;
                                        case 3:
                                            $categoria = " ";
                                            break;
                                    }

                                    if (!empty($observacao)) {
                                        $observacao = 'Detalhes';
                                    }

                                    $valor_multa_aplicado1 = number_format($valor_multa_aplicado, 2, ',', '.');
                                    $valor_multa_definitivo1 = number_format($valor_multa_definitivo, 2, ',', '.');
                                    ?>
                                <tr>
                                    <td><?php echo $data_registro ?></td> 
                                    <td><?php echo $siscor ?></td>
                                    <td><?php echo $categoria ?></td>
                                    <td><?php echo 'R$ ' . $valor_multa_aplicado1 ?></td>
                                    <td><?php echo 'R$ ' . $valor_multa_definitivo1 ?></td>
                                    <td><a  data-toggle="modal" href="#" data-target="#exampleModal1<?php echo $res['id_histmulta'] ?>" ><center><?php echo $observacao ?></center</a></td>


                                    <td><a id="a2" data-toggle="modal" href="#" data-target="#exampleModal<?php echo $res['id_histmulta'] ?>" ><i class="fas fa-eraser"></i></a></td>


                                    <td><a id="a2" href="atu_usuario.php?id_usuario=<?php echo $registro1['id_histmulta'] ?>"> <i class="far fa-edit"></i></a></td>
                                </tr>
                                <!-- Modal Exclusao -->
                            <div class="modal fade" id="exampleModal<?php echo $registro1['id_histmulta'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Deseja Realmente Deletar  </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p><?php echo $siscor ?></p>
                                            <ul class="nav justify-content-center">     

                                                <li class="nav-item">
                                                    <a  class="btn btn-danger" href="lista_usuario.php?id_usuario=<?php echo $registro1['id_histmulta'] ?>">Sim</a>
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
                    <div style="margin-top: 50px">                 

                    </div>

                </div>

                <script defer src="js/fontawesome-all.min.js"></script>
                </body>
                </html>