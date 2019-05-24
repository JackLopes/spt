
<?php
if (isset($_GET['id_tipo'])) {
    $id_tipo = (int) $_GET['id_tipo'];
}
if (isset($_POST['id_tipo'])) {
    $id_tipo = (int) $_POST['id_tipo'];
}

$sq = "SELECT * FROM preventivas WHERE  id_tipo = '$id_tipo'";
$resultado = mysqli_query($conection, $sq); {
    $res = mysqli_num_rows($resultado);

    define('valor', $res);
}
$sql = "SELECT  *  FROM preventivas WHERE status = 'ok' AND id_tipo = '$id_tipo'";
$resultado1 = mysqli_query($conection, $sql); {
    $res1 = mysqli_num_rows($resultado1);

    define('valor1', $res1);
}
?>


<!doctype html>
<html lang="pt">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet"  type="text/css" href="css/Styleprevi1.css" media="screen"/>
        <link rel="stylesheet" href="css/bootstrap.css" >
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load("current", {packages: ['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ["Element", "Density", {role: "style"}],
                    ["PLANEJADAS", <?php echo valor ?>, "green"],
                    ["REALISADAS", <?php echo valor1 ?>, "red"],
                ]);

                var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                    {calc: "stringify",
                        sourceColumn: 1,
                        type: "string",
                        role: "annotation"},
                    2]);

                var options = {
                    title: "Manutencao Preventiva",
                    width: 1050,
                    height: 700,
                    bar: {groupWidth: "95%"},
                    legend: {position: "none"},
                };
                var chart = new google.visualization.ColumnChart(document.getElementById("grft6"));
                chart.draw(view, options);
            }
        </script>



    </head>
    <body>

        <div  class=" container graf " >
            <div id="grft6"></div>
        </div>




        <script src="js/jquery.js"></script>
        <script src="js/jquery_1.js"></script>
        <script src="js/bootstrap.min.js"></script>

    </body>
</html>