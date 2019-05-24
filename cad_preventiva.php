<?php
session_start();

if ($_SESSION['status'] != 'LOGADO') {
header("Location: login.php");
}
include 'menu_local.php';
require_once ('./inc/Config.inc.php');

if (isset($_GET['id_tipo'])) {
$id_tipo = (int) $_GET['id_tipo'];
}
if (isset($_POST['id_tipo'])) {
$id_tipo = (int) $_POST['id_tipo'];
}

require_once 'valida_permissao.php';
$id_preventiva = filter_input(INPUT_GET, 'id_preventiva', FILTER_VALIDATE_INT);


if (!empty($id_preventiva)) {
$apagarChamado = new Delete();
$apagarChamado->ExeDelete('preventivas', 'WHERE id_preventiva = :id', "id={$id_preventiva}");
}

function inverteData($data) {
if (count(explode("/", $data)) > 1) {
return implode("-", array_reverse(explode("/", $data)));
} elseif (count(explode("-", $data)) > 1) {
return implode("/", array_reverse(explode("-", $data)));
}
}

$mes = array('', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
$page_title = 'Corretiva';
require_once 'database_gac.php';
$query = "SELECT tip.* , loc.id_contrato, cont.tip_chamado, 
				cont.rg, loc.lugar_regional				
				FROM tipo AS tip
				INNER JOIN local AS loc ON  loc.id_local = tip.id_local
				INNER JOIN  contrato AS cont ON  cont.id_contrato = loc.id_contrato
				WHERE id_tipo = '$id_tipo'";

$resultado = mysqli_query($conection, $query)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado)) {

$tipos = ucwords(strtolower($registro['tipos']));
$ct = $registro['id_contrato'];
$rg = $registro['rg'];
$regional = $registro['lugar_regional'];
}
$sq = "SELECT * FROM preventivas WHERE  id_tipo = '$id_tipo'";
$resultado = mysqli_query($conection, $sq);
$num = mysqli_num_rows($resultado);

$sql = "SELECT  *  FROM preventivas WHERE status = 'ok' AND id_tipo = '$id_tipo'";
$resultado1 = mysqli_query($conection, $sql);
$num1 = mysqli_num_rows($resultado1);

$assunt = "<i class='fas fa-wrench'></i> Manutenção Preventiva<p><h3 style='margin-left:50px; opacity:0.7;'> RG:  $rg / $regional  - Grupo de $tipos </h3><p> ";
?>
<!doctype html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet"  type="text/css" href="css/styleprevent.css" media="screen"/>
        <link rel="stylesheet" href="css/bootstrap.css" >
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load("current", {packages: ['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ["Element", "Density", {role: "style"}],
                    ["PLANEJADAS", <?php echo $num ?>, "green"],
                    ["REALISADAS", <?php echo $num1 ?>, "red"],
                ]);

                var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                    {calc: "stringify",
                        sourceColumn: 1,
                        type: "string",
                        role: "annotation"},
                    2]);

                var options = {
                    title: "MANUTENÇÃO PRENVENTIVAS ",
                    width: 400,
                    height: 270,
                    bar: {groupWidth: "95%"},
                    legend: {position: "none"},
                };
                var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
                chart.draw(view, options);
            }
        </script>
         <style>
            label{
                font-size: 20px;             
                font-family:  times new romam;
            }
        </style>

    </head>
    <body>
        <?php require_once 'image_header6.php'; ?>
        <div  class=" container-fluid    "  style="margin-top: 30px">
            <div class=" col-md-12" > 
                <?php
                if (isset($_SESSION['msg8'])) {
                echo $_SESSION['msg8'];
                unset($_SESSION['msg8']);
                }
                ?>
                
                <div class="form-row">
                    <div class="form-group col-md-9">
                        <form  action="proc_preventiva.php" method="post">
                            <div class="form-row">	

                                <div class="form-group col-md-2">
                                    <label for="cn_chamado">Nº CHAMADO:</label>                                
                                    <input Type="text" class="form-control is-valid"  name="n_chamado" id="cn_chamado"   value="<?php if (isset($_POST['n_chamado'])) echo $_POST['n_chamado']; ?>"  disabled/>
                                </div>  
                                <div class="form-group col-md-2">
                                    <label for="cd_limite">CRONOGRAMA:</label>
                                    <input type="date"  class="form-control is-valid"  name="d_limite"  id = "cd_limite"  value="<?php if (isset($_POST['d_limite'])) echo $_POST['d_limite']; ?>" />
                                </div>
                                <div class="form-group col-md-2">	
                                    <label for="cd_execucao">DATA REALIZADA:</label>
                                    <input Type="date" class="form-control is-valid" id="cd_execucao" name="data_conclusao"  value="<?php if (isset($_POST['data_conclusao'])) echo $_POST['data_conclusao']; ?>"  disabled/>
                                </div>	
                              
                            </div>
                            <div class="form-row">						 	
                                <div class="form-group col-md-12">
                                    <label for="c_obs">Observação:</label>
                                    <input Type="text" class="form-control is-valid" style=" outline: 0" name="obs" id="c_obs"  value="<?php if (isset($_POST['obs'])) echo $_POST['obs']; ?>" /></p>
                                </div>
                            </div>
                            <div class="form-row">	

                                <input name="id_tipo"  type="hidden" value=<?php echo $id_tipo; ?>>

                                <div class="form-group col-md-2">	
                                    <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?> 
                                    <input id= "bt1" type="submit" class="btn btn-success"  name="submit" value="Enviar"/>
                                    <input type="hidden" name="submitted" value="TRUE" />
                                    <?php } ?>
                                </div>
                            </div>            
                        </form>
                    </div> 
                    <div class="form-group col-md-3">
                        <div id="columnchart_values" style="width: 400px; height: 200px;"></div>
                    </div>
                </div> 
            </div> 

            <div class="col-sm-12">	
                <?php
                if
                (isset($_SESSION['msg39'])) {
                echo $_SESSION['msg39'];
                unset($_SESSION['msg39']);
                }
                ?>
                <table  class="table table-hover table-striped table-sm table-bordered bg-light"   >
                    <thead class="thead-dark ">

                    <th scope="col">Patrimônios </th>
                    <th scope="col">Nº Chamado</th>
                    <th style="background-color:#228B22;">Mês Planejado</th>
                    <th scope="col">Ano</th> 
                    <th scope="col">Data da Execução</th>                  
                    <th scope="col">Observação</th>
                    <th style="background-color:#228B22;">Previsão de multa?</th>
                    <th style="background-color:#228B22;">Aplicar multa?</th>
                    <th scope="col">Status</th>
                    <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?> 
                    <th scope="col">Editar</th>
                    <th scope="col">Excluir</th>
                     <?php } ?>
                    </tr> 
                    <?php
                    $sqlcorre = "SELECT * FROM preventivas WHERE id_tipo= '$id_tipo' ORDER BY d_limite";
                    $resultado = mysqli_query($conection, $sqlcorre)or die('Não foi possivel conectar ao MySQL');
                    while ($registro = mysqli_fetch_array($resultado)) {

                    $d_limite = $registro['d_limite'];
                    $ex = explode("-", $d_limite);
                    $ano = $ex[0];

                    $d_execucao = $registro['data_conclusao'];
                    $d_execucao1 = inverteData($d_execucao);

                    $id_preventiva = $registro['id_preventiva'];
                    ?>
                    <tr>
                        <td class = "td2" ><?php echo $registro['patrimonio']; ?></td>
                        <td class = "td2" ><?php echo $registro['n_chamado']; ?></td>        
                        <td class = "td2" ><?php
                            echo $registro['mes'];
                            ;
                            ?></td>
                        <td class = "td2" ><?php echo $ano; ?></td>
                        <td class = "td2" ><?php echo $d_execucao1; ?></td>
                       
                        <td class = "td2" ><?php echo $registro['obs']; ?></td>       
                        <td class = "td2" ><?php echo $registro['previsao_multa']; ?></td>
                        <td class = "td2" >
                            <a  href="" data-toggle="modal"  <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?> data-target="#exampleModalLong<?php echo $id_preventiva; ?>" <?php }?>><?php echo $registro['aplicacao_multa']; ?></a>
                        </td>
                        <td class = "td2" ><?php echo $registro['status']; ?></td>
                         <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?>
                        <td>
                            <a class = "td2" href="cad_preventiva1.php?id_tipo=<?php echo $registro['id_tipo']; ?>&id_pre=<?php echo $registro['id_preventiva']; ?>">
                             <i class="far fa-edit"></i>
                            </a>
                        </td>
                        <td>
                             <a  href="#"  data-toggle="modal" data-target="#exampleModal5<?php echo$id_preventiva ?>">
                           
                                  <i class="fas fa-eraser"></i>
                            </a>
                        </td>
                         <?php } ?>
                    </tr>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModalLong<?php echo $id_preventiva ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle"><font color='#0080FF'>Análise da Ocorrência</font></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form  class=" updates needs-validation "   action="proc_atua_preventiva1.php"  method="post" novalidate>         
                                <div  class="container" >	
                                    <div class="form-row"> 
                                        <div class="form-group col-md-6">                                             

                                            <label class="mods2" for="caplicacao_multa" >APLICAR MULTA ?</label>
                                            <select class="custom-select"name="aplicacao_multa" id="caplicacao_multa"  value="<?php echo $registro['aplicacao_multa']; ?>" >
                                                <option selected><?php echo $registro['aplicacao_multa']; ?></option>
                                                <option value="Sim">Sim</option>
                                                <option value="Nao">Não</option>                                                           
                                            </select>
                                        </div>
                                    </div>	
                                    <div class="form-row">       		
                                        <div class="form-group col-md-12">    
                                            <input class="form-control"  type="hidden" name="id_preventiva" id="cid_pag"  value="<?php echo $id_preventiva; ?>" >
                                            <input class="form-control"  type="hidden" name="id_tipo" id="cid_tipo"  value="<?php echo $id_tipo; ?>" >                                           

                                            <input  class="btn btn-outline-primary" type="submit" name="Prosseguir" value="ENVIAR"  class="btn btn-primary">
                                            <input type="hidden" name="submitted" value="TRUE" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
               <!-- Modal Exclusao -->
                        <div class="modal fade" id="exampleModal5<?php echo $id_preventiva; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Deseja Realmente Deletar  </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p><?php echo 'O registro referente ao  mês de ' . $registro['mes']; ?></p>
                                        <ul class="nav justify-content-center">     
                                            <li class="nav-item">
                                                <a class="btn btn-danger"  href="cad_preventiva.php?id_tipo=<?php echo $id_tipo; ?>&id_preventiva=<?php echo $id_preventiva; ?>">Sim</a>
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
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>







