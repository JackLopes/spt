

<?php

 if (isset($_POST['an'])) {
 $an = $_POST['an'];} else {
	$an= date('Y'); 	 
 }



    $numero_dia = date('w')*1;
    $dia_mes = date('d');
    $numero_mes = date('m')*1;
    $an1 = date('Y');
    $dia = array('Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado');
    $me = array('', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', '       Novembro', 'Dezembro');
   // echo $dia[$numero_dia] . ", " .$dia_mes . " de " . $me[$numero_mes] . " de " . $an . ".";

require_once 'database_gac.php';
$i2 = 0;



$sql = " SELECT rg  FROM corretivas WHERE  ano = '$an' GROUP BY (rg)  ";
$resultado = mysqli_query($conection,$sql);
While ($row_registro = mysqli_fetch_assoc($resultado))
  {
	 $rg[$i2] =  $row_registro['rg'];  

	 $i2 = $i2 + 1;
}



$sql = "  SELECT COUNT(data_conclusao) AS totaldata , YEAR(data_conclusao) AS ano    FROM corretivas WHERE  ano = '$an'  GROUP BY (rg)";
$resultado = mysqli_query($conection,$sql);
While ($row_registro = mysqli_fetch_assoc($resultado))
  {
	 $totaldata[$i2] =  $row_registro['totaldata'];	
	
	$i2 = $i2 + 1;
}


$id='1';

$sql = "  SELECT  SUM(previsao_multa) AS multa , YEAR(data_conclusao) AS ano   FROM corretivas WHERE ano = '$an'      GROUP BY (rg)";
$resultado = mysqli_query($conection,$sql);
While ($row_registro = mysqli_fetch_assoc($resultado))
  {
	 
	 $multa[$i2] =  $row_registro['multa'];  	
	
	$i2 = $i2 + 1;
}




?>


<!doctype html>
<html lang="pt">

<head>
	 <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet"  type="text/css"  media="screen"/>
		<link rel="stylesheet" href="css/bootstrap.css" >

   </script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Contratos', 'Total Atendimentos No Período', 'Total Atendimento em Desacordo com ANS', ],
          <?php 
		  
		$k2 = $i2;
		for ($i2 = 0; $i2 < $k2; $i2++) {
			?>
			['<?php echo $rg[$i2]?>',<?php echo  $totaldata[$i2]?>, <?php echo  $multa[$i2]?>],
			
			<?php
		}
		?>
		
		// [[1,2,3], [1,2,3], [1,2,3]]
        ]);

        var options = {
          chart: {
            title: ' ',
            subtitle: 'Comparação do Total de Atendimentos e Ocorrências Em Desconformidade do ANS de Manutenção por Contrato',
          },
          bars: 'horizontal' // Required for Material Bar Charts.
        };

        var chart = new google.charts.Bar(document.getElementById('ansrg'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
  
  
  
</head>
<body>
<div class="row"   >
  <div class="col-sm-12"> 
  <div id="ansrg"  style="width: 1100px; height:500px;"></div>
  </div>

</div>

</div>
  

	<script src="js/jquery.js"></script>
    <script src="js/jquery_1.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>
</html>