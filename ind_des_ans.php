<?php


session_start();
if ($_SESSION['status'] != 'LOGADO') {
   header("Location: login.php");	   
}
?>

<?php

$page_title = 'Controles Regionais';

?>

<?php
 if (isset($_GET['id'])) {
$id =(int)$_GET['id'];} 
if (isset($_POST['id'])) {
$id =(int)$_POST['id'];}

if (isset($_GET['ct'])) {
$ct =(int)$_GET['ct'];} 
if (isset($_POST['ct'])) {
$ct =(int)$_POST['ct'];}

if (isset($_GET['tch'])) {
$tch =(int)$_GET['tch'];} 
if (isset($_POST['tch'])) {
$tch =(int)$_POST['tch'];} 

if (isset($_GET['an'])) {
$an =(int)$_GET['an'];} 
if (isset($_POST['an'])) {
$an =(int)$_POST['an'];} 


?>

<?php
    $numero_dia = date('w')*1;
    $dia_mes = date('d');
    $numero_mes = date('m')*1;
    $an1 = date('Y');
    $dia = array('Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado');
    $me = array('', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
   // echo $dia[$numero_dia] . ", " .$dia_mes . " de " . $me[$numero_mes] . " de " . $an . ".";

require_once 'database_gac.php';
$i2 = 0;

$id='1';

$sql = "  SELECT MONTH(data_conclusao) AS mes , YEAR(data_conclusao) AS ano  FROM corretivas WHERE  ano = '$an'   AND   id_tipo = '$id 'GROUP BY MONTH(data_conclusao)";
$resultado = mysqli_query($conection,$sql);
While ($row_registro = mysqli_fetch_assoc($resultado))
  {
	 $mes[$i2] =  $row_registro['mes'];  
	 $ano[$i2] =  $row_registro['ano']; 

           $mes[$i2]= $me[$mes[$i2]];


	 $i2 = $i2 + 1;
}
//var_dump (  $me);
//echo "<br>";
//var_dump (  $ano);

?>

<?php
echo "<br>";



require_once 'database_gac.php';
$i2 = 0;

$id='1';

$sql = "  SELECT COUNT(data_conclusao) AS totaldata , MONTH(data_conclusao) AS mes    FROM corretivas WHERE  ano = '$an'   AND     id_tipo = '$id ' GROUP BY MONTH(data_conclusao)";
$resultado = mysqli_query($conection,$sql);
While ($row_registro = mysqli_fetch_assoc($resultado))
  {
	 $totaldata[$i2] =  $row_registro['totaldata'];
	

	
	
	$i2 = $i2 + 1;
}
//var_dump (  $totaldata);


?>

<?php
echo "<br>";

require_once 'database_gac.php';
$i2 = 0;

$id='1';

$sql = "  SELECT  SUM(previsao_multa) AS multa , MONTH(data_conclusao) AS mes   FROM corretivas WHERE ano = '$an'   AND    id_tipo = '$id ' GROUP BY MONTH(data_conclusao)";
$resultado = mysqli_query($conection,$sql);
While ($row_registro = mysqli_fetch_assoc($resultado))
  {
	 
	 $multa[$i2] =  $row_registro['multa'];  
	
	$i2 = $i2 + 1;
}

//var_dump (  $multa);

?>




<!doctype html>
<html lang="pt">

<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 
<link rel="stylesheet"  type="text/css" href="css/stylemenu1.css" media="screen"/>
 <link rel="stylesheet" href="css/bootstrap.css" >

<title><?php echo $page_title; ?></title>

    <html>
  <head>
     <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Meses', 'Total Atendimentos', 'Total Desconformidade', ],
          <?php 
		  
		$k2 = $i2;
		for ($i2 = 0; $i2 < $k2; $i2++) {
			?>
			['<?php echo $mes[$i2]?>',<?php echo  $totaldata[$i2]?>, <?php echo  $multa[$i2]?>],
			
			<?php
		}
		?>
		
		// [[1,2,3], [1,2,3], [1,2,3]]
        ]);

        var options = {
          chart: {
            title: ' ',
            subtitle: 'Comparação do Total de Atendimentos e Ocorrências Em Desconformidade ao ANS de Manutenção ,por Regional',
          },
          bars: 'horizontal' // Required for Material Bar Charts.
        };

        var chart = new google.charts.Bar(document.getElementById('ans'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
	
	
  
   
 
  </head>
  

<body>
<div  class="container-fluid " id= "top" >

	<div class="col-12 col-sm-12 col-md-12  col-lg-12 col-xl-12 " id="hea1" ><h5>GAC - SPT/SI<h5></div>		
	


<div class="row" id="navi">
	<form action="cad_itens.php" method="post">
		<input Type="hidden" name="id" size="15" maxlength="20"  value="<?php echo $id ;?>" /></p>
		<input Type="hidden" name="ct" size="15" maxlength="40" value="<?php echo $ct;?>" /></p>
		<input Type="hidden" name="tch" size="15" maxlength="40" value="<?php echo $tch;?>" /></p>
		<div class="col-sm"   >
		<input type="submit" style="color: #cfcfcf; text-shadow:1px 1px 3px black" class="btn btn-link" name="submit" value="ITENS"/>
		</div>
	</form>
	<form action="cad_preventiva.php" method="post">
		<input Type="hidden" name="id" size="15" maxlength="20"  value="<?php echo $id ;?>" /></p>
		<input Type="hidden" name="ct" size="15" maxlength="40" value="<?php echo $ct;?>" /></p>
		<input Type="hidden" name="tch" size="15" maxlength="40" value="<?php echo $tch;?>" /></p>
		<div class="col-sm"   >
		<input type="submit" style="color: #cfcfcf; text-shadow:1px 1px 3px black" class="btn btn-link" name="submit" value="PREVENTIVA"/>
		</div>
	</form>
	<form action="cad_corretiva.php" method="post">
		<input Type="hidden" name="id" size="15" maxlength="20"  value="<?php echo $id ;?>" /></p>
		<input Type="hidden" name="ct" size="15" maxlength="40" value="<?php echo $ct;?>" /></p>
		<input Type="hidden" name="tch" size="15" maxlength="40" value="<?php echo $tch;?>" /></p>
		<div class="col-sm"   >
		<input type="submit" style="color: #cfcfcf; text-shadow:1px 1px 3px black" class="btn btn-link" name="submit" value="CORRETIVA"/>
		</div>
	</form>
<form action="cad_pagamento.php" method="post">
		<input Type="hidden" name="id" size="15" maxlength="20"  value="<?php echo $id ;?>" /></p>
		<input Type="hidden" name="ct" size="15" maxlength="40" value="<?php echo $ct;?>" /></p>
		<input Type="hidden" name="tch" size="15" maxlength="40" value="<?php echo $tch;?>" /></p>
		<div class="col-sm"   >
		<input type="submit" style="color: #cfcfcf; text-shadow:1px 1px 3px black" class="btn btn-link" name="submit" value="PAGAMENTO"/>
		</div>
	</form>
</div></br>
<form  id= "fmr" action="menu_local.php" method="post">
<div class="row" >
 <div class="col-sm-2 ">
 <p><select class="form-control"  name="an" value="<?php if (isset($_POST['an']))echo $_POST['an'];?>" /></p>
  <option value="2017">2017</option>
  <option value="2018">2018</option>
  <option value="2019">2019</option>
  </select>
   </div >
 <div class="col-sm"> 
  <input name="id_tipo" type="hidden" value=<?php echo $id ; ?>>
  <input name="ct" type="hidden" value=<?php echo $ct ; ?>>
  <input name="tch" type="hidden" value=<?php echo $tch ; ?>>
   <input id= "bt1" type="submit"  class="btn btn-primary"  name="submit" value="Enviar"/>
   </div>
  </div >
 </form> 


<div class="row" id="one" >
  
  <div id="ans" style="width: 900px; height:400px;"></div>
 
</div>


<div class="row" id= "return">
<a href="lista_geral.php" class="btn btn-link" >Voltar</a>
 </div> 

	 
 

 </div >
 
    <script src="js/jquery.js"></script>
    <script src="js/jquery_1.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>
</html>