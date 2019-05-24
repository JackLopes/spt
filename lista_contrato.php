


<?php

require 'database_gac.php';

$sql = "select * from contrato";
$con = mysqli_query($conection, $sql);

?>
 
	<!doctype html>
<html lang="pt-br">
				<head>
					<meta charset="UTF-8"/>
						<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
						<link rel="stylesheet"  type="text/css" href="css/stylelista_contr.css" media="screen"/>
								<link rel="stylesheet" href="css/bootstrap.css" >
								<script src="jquery.js" type="text/javascript"></script>
						<script type="text/javascript" src="js1/jquery-3.3.1.min.js"></script>
					<script type="text/javascript" src="js1/jquery.mask.min.js"></script>
				</head>
	<body>
		 <div  class="container " >
			<center><div class="col-md-12 order-md-1">
		

<table class="table table-striped" >
<?php
while ($res = mysqli_fetch_array($con)) {
    ?>
    <tr>
       
        <td><?php echo $res['rg'];?></td>        
        <td><a href="?id=<?php echo $res['id_contrato']?>"><h5>Editar<h5></a></td>

        <td><a href="cad_regional.php?id=<?php echo $res['id_contrato']?>">Cadastrar Regionais</a></td>
    </tr>
    <?php
}
?>

</table>

</div>
</body>
</html>
