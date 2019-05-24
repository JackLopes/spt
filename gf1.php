
<?php
require_once 'database_gac.php';




$cor4 = 'red';
$cor5 = '#0B610B';
$cor6 = '#FFD700';
$cor7 = '#0000CD';


$sq2 = "SELECT * FROM contrato WHERE status = 'vigente' AND natureza = 'gacam'";
$resultado2 = mysqli_query($conection, $sq2);
$num4 = mysqli_num_rows($resultado2);

$sql3 = "SELECT  *  FROM contrato WHERE status = 'encerrado' AND natureza = 'gacam'";
$resultado3 = mysqli_query($conection, $sql3);
$num5 = mysqli_num_rows($resultado3);

$sq4 = "SELECT  *  FROM contrato WHERE status = 'vigente/garantia' AND natureza = 'gacam'";
$resultado4 = mysqli_query($conection, $sq4);
$num6 = mysqli_num_rows($resultado4);


$num7 = $num4 + $num5 + $num6;
?>





<!doctype html>
<html lang="pt">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet"  type="text/css"  media="screen"/>
        <link rel="stylesheet" href="css/bootstrap.css" >
        <link rel="stylesheet"  type="text/css" href="gf13.css" media="screen"/>

    </script>


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {packages: ['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ["Status", "Quantidade", {role: "style"}],

                ['<?php echo "Vigente" ?>', <?php echo $num4 ?>, '<?php echo $cor4 ?>'],
                ['<?php echo "Encerrado" ?>',<?php echo $num5 ?>, '<?php echo $cor5 ?>'],
                ['<?php echo "Vigente/Garantia" ?>',<?php echo $num6 ?>, '<?php echo $cor6 ?>'],
                ['<?php echo "Total Contratos" ?>',<?php echo $num7 ?>, '<?php echo $cor7 ?>'],
                        // [[1,2,3], [1,2,3], [1,2,3]]

            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                {calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation"},
                2]);

            var options = {
                title: "Status dos Contratos GACAM",
                width: 1050,
                height: 700,
                bar: {groupWidth: "95%"},
                legend: {position: "none"},
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("gf3"));
            chart.draw(view, options);


        }

    </script>



<div  class="container" >

    <div id="gf3" >
    </div>

</div>

<script src="js/bootstrap.min.js"></script>


