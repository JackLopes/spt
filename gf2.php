
<?php
$rg = array();
$total = array();

$i5 = 0;
$cor10 = 'red';
require_once 'database_gac.php';


$sql = "  SELECT rg, DATEDIFF( d_fim_vige_cont, NOW()) AS vig FROM contrato WHERE DATEDIFF(d_fim_vige_cont, NOW())  BETWEEN 1 AND 240";
$resultado = mysqli_query($conection, $sql);
While ($registro = mysqli_fetch_array($resultado)) {
    $rgs[$i5] = $registro['rg'];
    $total[$i5] = floatval($registro['vig']);

    $i5 = $i5 + 1;
}
?>

</script>  

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load("current", {packages: ['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ["Element", "Dias restantes para o fim da Vigência", {role: "style"}],
<?php
$k2 = $i5;
for ($i5 = 0; $i5 < $k2; $i5++) {
    ?>
                ['<?php echo $rgs[$i5] ?>',<?php echo $total[$i5] ?>, '<?php echo $cor10 ?>'],

    <?php
}
?>

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
            title: "Contratos com ate 8 meses (aproximadamente 240 dias) para o fim da vigência contratual",
            width: 1050,
            height: 700,
            bar: {groupWidth: "95%"},
            legend: {position: "none"},
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("gf2"));
        chart.draw(view, options);
    }
</script>

<div  class="container"  >
    <div id="gf2" >
    </div>
</div>


<script src="js/bootstrap.min.js"></script>


