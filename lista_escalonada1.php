

<?php

$page_title = 'Bem vindo ao Site';
include 'menu.html';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8"/>
<title>menu</title>
</head>
<body>
      <ul>	
	  <?php
		$host = "localhost";
		$user = "root";
		$pass = "";
		$banco = "gac";
	
		$strcon = mysqli_connect($host, $user, $pass,$banco) or die ('Não foi possivel conectar ao MySQL');
		$sqlcontrato = "SELECT * FROM contrato ";
		$resultado = mysqli_query($strcon,$sqlcontrato)or die ('Não foi possivel conectar ao MySQL');
		while ($registro = mysqli_fetch_array($resultado)) {
			$ids = $registro ['id_contrato'];
		?>		
		<li><a href="idex.php?id=<?php echo $registro['id_contrato'];?>"><?php echo $registro['rg'];?></a>
		<?php 
				$sqloc = "SELECT * FROM local WHERE Id_contrato = '$ids'";
				$resultado1 = mysqli_query($strcon,$sqloc)or die ('Não foi possivel conectar ao MySQL');
				if(mysqli_num_rows($resultado1) == 0 ) { 
				} else {
						
		?>				
		<ul>
		<?php		
				while ($registro1 = mysqli_fetch_array($resultado1)) {		
		?>			
		<li><a href="menu_local.php?id=<?php echo $registro1['id_local'];?>"><?php echo $registro1['lugar_regional'] . '  ' ;?><?php echo '(' . $registro1['especie'] . ')';?></a></li>	
		
		<?php } ?>		
	     </ul>	
      <?php }?>	
	</li>	
      <?php }?>	
	  </ul>
</body>
</html>
