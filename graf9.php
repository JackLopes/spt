<?php




  
if (isset($_GET['id_tipo'])) {$id_tipo =(int)$_GET['id_tipo'];} 
if (isset($_POST['id_tipo'])) {$id_tipo =(int)$_POST['id_tipo'];}


 

require_once 'database_gac.php';


				$query = "SELECT tip.* , loc.id_contrato, cont.tip_chamado, 
				cont.rg, cont.valor_Contratado, loc.lugar_regional				
				FROM tipo AS tip
				INNER JOIN local AS loc ON  loc.id_local = tip.id_local
				INNER JOIN  contrato AS cont ON  cont.id_contrato = loc.id_contrato
				WHERE id_tipo = '$id_tipo'";
				
				$resultado = mysqli_query($conection,$query)or die ('Não foi possivel conectar ao MySQL');
				while ($registro = mysqli_fetch_array($resultado)) {
				
	                        $val_contr = $registro['valor_Contratado'];
				$ct = $registro['id_contrato'];
				$tch = $registro['tip_chamado'];
				$rg = $registro['rg'];
				$regional = $registro['lugar_regional'];
                                }




$regs = array();
$total = array();
$cor8 = 'red';
$cor9 = 'silver';
$cor10 = 'blue';
$i5 = 0;
$sql = "  SELECT SUM(valor_parcela) AS par_valor, regional FROM pagamentos WHERE   id_contrato= '$ct' AND status = 'ok' GROUP BY regional";
$resultado = mysqli_query($conection,$sql);
While ($registro = mysqli_fetch_array($resultado))
  {
     $regs[$i5] =  $registro['regional']; 
     $par_total[$i5] =  ($registro['par_valor']); 
   
   $i5 = $i5 + 1;
   
    $sub_par_total = array_sum ($par_total );
   
}

if (empty($par_total)){
    
   $sub_par_total = 0;
} else {
     $sub_par_total = array_sum ($par_total );
   
}

$rest= $val_contr - $sub_par_total;




?>

<html lang="pt">

<head>
      <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">		
		<link rel="stylesheet" href="css/bootstrap.css" >
                <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>      
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Regional', 'Total Pago'],
          
          <?php 
		$k2 = $i5;
		for ($i5 = 0; $i5 < $k2; $i5++) {
			?>
			['<?php echo $regs[$i5]?>',<?php echo   $par_total[$i5]?>],
			
			<?php
                        
		}
		?>    
        ['FALTAM ',  <?php echo $rest ?>]
        
        ]);

        var options = {
          title: 'PAGAMENTOS EFETUADOS POR REGIONAIS',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('gf9'));
        chart.draw(data, options);
      }
    </script>
</head>
<body>
   <div>
       <div  class="container"  >
  <div id="gf9" style="width:1000px; height:900px;"></div>
    
 </div> 
</div>

  </body>
  </html>
	
	