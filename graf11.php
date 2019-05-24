<?php




  
if (isset($_GET['id_tipo'])) {$id_tipo =(int)$_GET['id_tipo'];} 
if (isset($_POST['id_tipo'])) {$id_tipo =(int)$_POST['id_tipo'];}


 

require_once 'database_gac.php';
/*

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

*/
$rg = '59533';

?>

<html lang="pt">

<head>
      <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">		
		<link rel="stylesheet" href="css/bootstrap.css" >
                <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>      
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
     <script type="text/javascript">
        google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Ano', 'Total Chamados', 'Desconformidade'],
          ['2014', 1000, 400],
          ['2015', 1170, 460],
          ['2016', 660, 1120],
          ['2017', 1030, 540]
        ]);

        var options = {
          chart: {
            title: 'ATENDIMENTOS ANS (MANUTENÇÃO CORRETIVAS) ANUAL POR CONTRATO',
            subtitle: '<?php  echo $rg ;?>',
          },
          bars: 'vertical',
          vAxis: {format: 'decimal'},
          height: 600,
         
          colors: ['#1b9e77', '#d95f02']
        };

        var chart = new google.charts.Bar(document.getElementById('graf11'));

        chart.draw(data, google.charts.Bar.convertOptions(options));        
        
      }
  </script>
  
</head>
<body>
   <div>
       <div  class="container"  >
 
           <div id="graf11"></div>
    
 </div> 
</div>
<script src="js/jquery.js"></script>
    <script src="js/jquery_1.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
  </html>
	
	

