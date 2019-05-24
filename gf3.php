
<?php

$cor = 'red';
$cor1 = '#0B610B';
$cor2 = '#FFA500';
$cor3 = '#0000CD';

$sq = "SELECT * FROM contrato WHERE status = 'vigente' AND natureza = 'gacad'";
$resultado = mysqli_query($conection,$sq);
$num = mysqli_num_rows ($resultado);

$sql = "SELECT  *  FROM contrato WHERE status = 'encerrado' AND natureza = 'gacad'";
$resultado1 = mysqli_query($conection,$sql);
$num1 = mysqli_num_rows ($resultado1);

$sql = "SELECT  *  FROM contrato WHERE status = 'vigente/garantia' AND natureza = 'gacad'";
$resultado1 = mysqli_query($conection,$sql);
$num2 = mysqli_num_rows ($resultado1);


$num3= $num + $num1 + $num2;



?>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Status", "Quantidade", { role: "style" } ],		
		
			['<?php echo "Vigente"?>', <?php echo $num ?>,'<?php echo $cor?>'],
			['<?php echo "Encerrado"?>',<?php echo $num1 ?>,'<?php echo $cor1?>'],
			['<?php echo "Vigente/Garantia"?>',<?php echo $num2 ?>,'<?php echo $cor2?>'],
			['<?php echo "Total Contratos"?>',<?php echo $num3 ?>,'<?php echo $cor3?>'],
			// [[1,2,3], [1,2,3], [1,2,3]]
		
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Status dos Contratos GACAD",
        width: 1050,
        height: 700,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("gf1"));
      chart.draw(view, options);
  }
  </script>
  
  
  

<div  class="container"  >

<div id="gf1" >
 </div>

</div>
  
<script src="js/bootstrap.min.js"></script>