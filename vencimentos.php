<?php
$rg = array();
$total = array();

$i2 = 0;


$cor10 = '#ff0066';


$dbc = mysqli_connect('localhost','root','','gac');
$sql = "  SELECT rg, DATEDIFF( d_fim_vige_cont, agora)/31 AS vig FROM contrato WHERE DATEDIFF(d_fim_vige_cont, agora)/31  BETWEEN 1 AND 12";
$resultado = mysqli_query($dbc,$sql);
While ($registro = mysqli_fetch_array($resultado))
  {
	 $rg[$i2] =  $registro['rg']; 
     $total[$i2] =  (int)$registro['vig']; 
	  
echo $rg[$i2]."<br>";
echo $total[$i2]."<br>";



$i2 = $i2 + 1;
}



?>
<!DOCTYPE html>

 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Density", { role: "style" } ],
		<?php 
		$k2 = $i2;
		for ($i2 = 0; $i2 < $k2; $i2++) {
			?>
			['<?php echo $rg[$i2]?>',<?php echo  $total[$i2]?>, '<?php echo $cor10?>'],
			
			<?php
		}
		?>
		
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
        title: "Density of Precious Metals, in g/cm^3",
        width: 600,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
  }
  </script>
  
  
</head>
<body>
<div id="columnchart_values" style="width: 900px; height: 300px;"></div>
    
  
</body>
</html>