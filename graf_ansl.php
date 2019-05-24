


<?php
if (isset($_GET['id_tipo'])) {
    $id_tipo = (int) $_GET['id_tipo'];
}

if (isset($_POST['id_tipo'])) {
    $id_tipo = (int) $_POST['id_tipo'];
}



if (isset($_GET['an'])) {
    $an = (int) $_GET['an'];
}
if (isset($_POST['an'])) {
    $an = (int) $_POST['an'];
}



require_once 'database_gac.php';


$query = "SELECT tip.* , loc.id_contrato, cont.tip_chamado, 
				cont.rg, loc.lugar_regional				
				FROM tipo AS tip
				INNER JOIN local AS loc ON  loc.id_local = tip.id_local
				INNER JOIN  contrato AS cont ON  cont.id_contrato = loc.id_contrato
				WHERE id_tipo = '$id_tipo'";

$resultado = mysqli_query($conection, $query)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado)) {


    $ct = $registro['id_contrato'];
    $tch = $registro['tip_chamado'];
    $rg = $registro['rg'];
    $regional = $registro['lugar_regional'];
}
?>

<?php
$numero_dia = date('w') * 1;
$dia_mes = date('d');
$numero_mes = date('m') * 1;
$an1 = date('Y');
$dia = array('Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado');
$me = array('Chamados Abertos', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
// echo $dia[$numero_dia] . ", " .$dia_mes . " de " . $me[$numero_mes] . " de " . $an . ".";

require_once 'database_gac.php';
$i2 = 0;



$sql = "  SELECT MONTH(data_conclusao) AS mes , YEAR(data_conclusao) AS ano  FROM corretivas WHERE  ano = '$an'   AND   id_tipo = '$id_tipo 'GROUP BY MONTH(data_conclusao)";
$resultado = mysqli_query($conection, $sql);
While ($row_registro = mysqli_fetch_assoc($resultado)) {
    $mes[$i2] = $row_registro['mes'];
    $ano[$i2] = $row_registro['ano'];

    $mes[$i2] = $me[$mes[$i2]];


    $i2 = $i2 + 1;
}
/* var_dump (  $me);
  echo "<br>";
  var_dump (  $ano); */
?>

<?php
echo "<br>";



require_once 'database_gac.php';
$i2 = 0;


$sql = "  SELECT COUNT(data_conclusao) AS totaldata , MONTH(data_conclusao) AS mes    FROM corretivas WHERE  ano = '$an'   AND     id_tipo = '$id_tipo ' GROUP BY MONTH(data_conclusao)";
$resultado = mysqli_query($conection, $sql);
While ($row_registro = mysqli_fetch_assoc($resultado)) {
    $totaldata[$i2] = $row_registro['totaldata'];




    $i2 = $i2 + 1;
}
/* var_dump (  $totaldata); */
?>

<?php
echo "<br>";

require_once 'database_gac.php';
$i2 = 0;



$sql = "  SELECT  SUM(previsao_multa) AS multa , MONTH(data_conclusao) AS mes   FROM corretivas WHERE ano = '$an'   AND    id_tipo = '$id_tipo ' GROUP BY MONTH(data_conclusao)";
$resultado = mysqli_query($conection, $sql);
While ($row_registro = mysqli_fetch_assoc($resultado)) {

    $multa[$i2] = $row_registro['multa'];

    $i2 = $i2 + 1;
}
?>




<!doctype html>
<html lang="pt">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet"  type="text/css" href="css/styleans.css" media="screen"/>
        <link rel="stylesheet" href="css/bootstrap.css" >
        <title><?php echo $page_title; ?></title>
    <html>
        <head>
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                google.charts.load('current', {'packages': ['bar']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Meses', 'Lançamentos', 'Desconformidade', ],
<?php
$k2 = $i2;
for ($i2 = 0; $i2 < $k2; $i2++) {
    ?>
                            ['<?php echo $mes[$i2] ?>',<?php echo $totaldata[$i2] ?>, <?php echo $multa[$i2] ?>],

    <?php
}
?>

                        // [[1,2,3], [1,2,3], [1,2,3]]
                    ]);

                    var options = {
                        chart: {
                            title: ' ',
                            subtitle: ' Total de Lançamentos  e Ocorrencias em Desconformidades',
                        },
                        bars: 'horizontal' // Required for Material Bar Charts.
                    };

                    var chart = new google.charts.Bar(document.getElementById('ans'));

                    chart.draw(data, google.charts.Bar.convertOptions(options));
                }

            </script>
        </head>
        <body>
            <div  class="container "  >
                <div class="form-group col-md-12">
                    <div class=" selet" >
                 
                        <form  class = "fmr" action="menu_local.php" method="post">
                            <div class="row" >
                                <select  class="form-control   btn-outline-light"  onchange="location = this.value;">
                                    <option selected>Selecione o Ano</option>  
                                    <?php
                                    
                                    //
                                    
                                    $q1 = "SELECT ano FROM  corretivas WHERE id_tipo = '$id_tipo' GROUP BY (ano) desc";
                                    $r1 = mysqli_query($conection, $q1);
                                    while ($row = mysqli_fetch_array($r1)) {
                                        ?>
                                        <option value = "menu_local.php?id_tipo=<?php echo $id_tipo; ?>&an=<?php echo $row['ano']; ?>&graf=1"><?php echo $row ['ano']; ?></option>
                                    <?php } ?>
                                </select>	                               
                            </div>
                         
                        </form> 
                    </div >
                    <div  class=" container graf1 " >
                        <div id="ans" style="width: 1200px; height:500px;"></div>
                    </div>
                </div>
            </div >
            <script src="js/jquery.js"></script>
            <script src="js/jquery_1.js"></script>
            <script src="js/bootstrap.min.js"></script>
        </body>
    </html>