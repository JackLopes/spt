<?php
if (isset($_GET['id_tipo'])) {
    $id_tipo = (int) $_GET['id_tipo'];
}
if (isset($_POST['id_tipo'])) {
    $id_tipo = (int) $_POST['id_tipo'];
}




require_once 'database_gac.php';


$query = "SELECT tip.* , loc.id_contrato, cont.tip_chamado, 
				cont.rg, cont.valor_Contratado, loc.lugar_regional				
				FROM tipo AS tip
				INNER JOIN local AS loc ON  loc.id_local = tip.id_local
				INNER JOIN  contrato AS cont ON  cont.id_contrato = loc.id_contrato
				WHERE id_tipo = '$id_tipo'";

$resultado = mysqli_query($conection, $query)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado)) {

    $val_contr = $registro['valor_Contratado'];
    $ct = $registro['id_contrato'];
    $tch = $registro['tip_chamado'];
    $rg = $registro['rg'];
    $regional = $registro['lugar_regional'];
     $valor_Contratado = $registro['valor_Contratado'];
}

  $sql_quali = "SELECT SUM(valor_acrescimo) AS valor FROM aditivos WHERE id_contrato = $ct";
        $resul_quali = mysqli_query($conection, $sql_quali)or die('Não foi possivel conectar ao MySQL');
        while ($registro10 = mysqli_fetch_array($resul_quali)) {
            $valor_acrescimo = $registro10['valor'];
        }

        $sql_supressao = "SELECT SUM(valor_supressao) AS valor_supressao FROM aditivos WHERE id_contrato = $ct";
        $resul_supressao = mysqli_query($conection, $sql_supressao)or die('Não foi possivel conectar ao MySQL');
        while ($registro11 = mysqli_fetch_array($resul_supressao)) {
            $valor_supressao = $registro11['valor_supressao'];
        }

       
        $valor_atual = $valor_Contratado + $valor_acrescimo - $valor_supressao;
       

        if (!empty($valor_acrescimo)) {
            $val_contr = $valor_atual;
        }



$regs = array();
$total = array();
$cor8 = 'red';
$cor9 = 'silver';
$cor10 = 'blue';
$i5 = 0;
$sql = "  SELECT SUM(valor_parcela) AS par_valor, regional FROM pagamentos WHERE   id_contrato= '$ct' AND status = 'ok' GROUP BY regional";
$resultado = mysqli_query($conection, $sql);
While ($registro = mysqli_fetch_array($resultado)) {
    $regs[$i5] = $registro['regional'];
    $par_total[$i5] = ($registro['par_valor']);

    $i5 = $i5 + 1;

    $sub_par_total = array_sum($par_total);
}

if (empty($par_total)) {

    $sub_par_total = 0;
} else {
    $sub_par_total = array_sum($par_total);
}

$rest = $val_contr - $sub_par_total;
?>

<html lang="pt">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">		
        <link rel="stylesheet" href="css/bootstrap.css" >
         <link rel="stylesheet"  type="text/css" href="css/Styleprevi1.css" media="screen"/>
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>      
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load("current", {packages: ['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ["Element", "", {role: "style"}],
                    ['Total do Contrato', <?php echo $val_contr ?>, '<?php echo $cor8 ?>'],
<?php
$k2 = $i5;
for ($i5 = 0; $i5 < $k2; $i5++) {
    ?>
                        ['<?php echo $regs[$i5] ?>',<?php echo $par_total[$i5] ?>, '<?php echo $cor10 ?>'],

    <?php
}
?>
                    ['Pendência Contratual', <?php echo $rest ?>, '<?php echo $cor9 ?>']


                ]);

                var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                    {calc: "stringify",
                        sourceColumn: 1,
                        type: "string",
                        role: "none"},
                    2]);

                var options = {
                    title: "Liberação de Pagamentos por Reginal",
                    width: 1200,
                    height: 500,
                    bar: {groupWidth: "95%"},
                    legend: {position: "none"},
                };
                var chart = new google.visualization.ColumnChart(document.getElementById("gf7"));
                chart.draw(view, options);
            }

        </script>

    </head>
    <body>
        <div  class=" container graf " >
            <div id="gf7" ></div>
        </div> 

        <script src="js/jquery.js"></script>
        <script src="js/jquery_1.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>

