<?php
include 'menu_local.php';
require_once './Funcoes/func_data.php';
if (isset($_GET['id_tipo'])) {
    $id_tipo = (int) $_GET['id_tipo'];
}
if (isset($_GET['id_pre'])) {
    $id_prev = (int) $_GET['id_pre'];
}
if (isset($_POST['id_tipo'])) {
    $id_tipo = (int) $_POST['id_tipo'];
}

$mes = array('', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');

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

$assunt = "<i class='fas fa-wrench'></i> Manutenção Preventiva<p><h3 style='margin-left:50px'><font color='#df7700'> RG:  $rg / $regional  - Grupo de $tipos </font></h3><p> ";
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

    </head>
    <body>
        <?php require_once 'image_header6.php'; ?>

        <div  class=" container-fluid    "  style="margin-top: 30px">

            <div class="  informt1 form-group col-md-12">
                <?php echo "<font color='black'> RG:  $rg / $regional  - Grupo de $tipos </font>"; ?>  
            </div> 
         
            <div class=" col-md-12" > 
                <?php
                if (isset($_SESSION['msg8'])) {
                    echo $_SESSION['msg8'];
                    unset($_SESSION['msg8']);
                }
                ?>
                <?php
                $sqlcorre1 = "SELECT * FROM preventivas WHERE id_preventiva= '$id_prev'";
                $resultado1 = mysqli_query($conection, $sqlcorre1)or die('Não foi possivel conectar ao MySQL');
                while ($registro1 = mysqli_fetch_array($resultado1)) {

                    $ref = $registro1['d_limite'];
                    ?>
                    <div class="form-row">
                        <div class="form-group col-md-9">
                            <form  action="proc_preventiva1.php" method="post">
                                <div class="form-row">	
                                    		
                                    <div class="form-group col-md-2">
                                        <label for="cn_chamado">Nº CHAMADO:</label>                                
                                        <input Type="text" class="form-control is-valid"  name="n_chamado" id="cn_chamado"   value="<?php echo $registro1['n_chamado']; ?>" />
                                    </div>  
                                    <div class="form-group col-md-2">
                                        <label for="cd_limite">CRONOGRAMA:</label>
                                        <input type="text"  class="form-control is-valid"  name="d_limite"  id = "cd_limite"  value="<?php echo $registro1['mes']; ?>" disabled/>
                                    </div>
                                    <div class="form-group col-md-2">	
                                        <label for="cd_execucao">DATA REALIZADA:</label>
                                        <input Type="date" class="form-control is-valid" id="cd_execucao" name="data_conclusao"  value="<?php echo $registro1['data_conclusao']; ?>"  />
                                    </div>	
                                  
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="c_obs">OBSERVAÇÃO:</label>
                                        <input Type="text" class="form-control is-valid" style=" outline: 0" name="obs" id="c_obs"  value="<?php echo $registro1['obs']; ?>"  /></p>
                                    </div>
                                </div>

                                <div class="form-row">	

                                    <input name="id_tipo"  type="hidden" value=<?php echo $id_tipo; ?>>
                                    <input name="id_preventiva"  type="hidden" value=<?php echo $id_prev; ?>>
                                    <input name="d_limite"  type="hidden" value=<?php echo $ref; ?>>

                                    <div class="form-group col-md-2">		
                                        <input id= "bt1" type="submit" class="btn btn-success"  name="submit" value="Enviar"/>
                                        <input type="hidden" name="submitted" value="TRUE" />
                                    </div>
                                </div>            
                            </form>

                        <?php }
                        ?>         
                    </div> 
                    <div class="form-group col-md-3">
                        <div id="columnchart_values" style="width: 400px; height: 200px;"></div>
                    </div>
                </div> 
            </div> 
            <div class="col-sm-12">	
                <table  class="table table-hover table-striped table-sm table-bordered bg-light"   >
                    <thead class="thead-dark ">
                
                    <th scope="col">Patrimônio</th>
                    <th scope="col">Nº Chamado</th>
                    <th scope="col">Data Limite (Cronograma)</th>
                    <th scope="col">Data Execução</th>
               
                    <th scope="col">Observação</th>
                    <th scope="col">Previsão De Multa</th>
                    <th scope="col">Aplicar Multa</th>
                    <th scope="col">Status</th>
                    <th scope="col">Editar</th>                  
                    </tr> 
                    <?php
                    $sqlcorre = "SELECT * FROM preventivas WHERE id_tipo= '$id_tipo'";
                    $resultado = mysqli_query($conection, $sqlcorre)or die('Não foi possivel conectar ao MySQL');
                    while ($registro = mysqli_fetch_array($resultado)) {

                        $id_preventiva = $registro['id_preventiva'];
                        ?>
                        <tr>
                           
                            <td class = "td2" ><?php echo $registro['patrimonio']; ?></td>
                            <td class = "td2" ><?php echo $registro['n_chamado']; ?></td>
                            <td class = "td2" ><?php echo inverteData($registro['d_limite']); ?></td>
                            <td class = "td2" ><?php echo inverteData($registro['data_conclusao']); ?></td>
                              
                            <td class = "td2" ><?php echo $registro['obs']; ?></td>       
                            <td class = "td2" ><?php echo $registro['previsao_multa']; ?></td>
                            <td class = "td2" ><?php echo $registro['aplicacao_multa']; ?></td>

                            <td class = "td2" ><?php echo $registro['status']; ?></td>
                            <td>
                                <a class = "td2" href="cad_preventiva1.php?id_tipo=<?php echo $registro['id_tipo'] ?>&id_pre=<?php echo $registro['id_preventiva'] ?>">
                                    Editar
                                </a>
                            </td>
                           </tr>

                        <?php
                    }
                    ?>

                </table>

            </div>

        </div>

        <script src="js/jquery.js"></script>
        <script src="js/jquery_1.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>







