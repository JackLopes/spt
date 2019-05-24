<!doctype html>
<html lang="pt">

<head>
 <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
	<link rel="stylesheet" href="css/bootstrap.css" > 





</head>

<body>

 <div  class="container" >
<div  class="row  justify-content-center" >


 <form class="needs-validation"   action="idex.php?id=<?php echo $id ?>" method="post" novalidate>
 <div class="row">
              <div class="col-lg-6">
<select  class="custom-select"  name="id_tipo" value="<?php if (isset($_POST['id_tipo']))echo $_POST['id_tipo'];?>"/></br>
				<option>TIPOS</option>  
				<?php	
				$sqlcontrato = "SELECT loc.id_local, loc.lugar_regional	,
							cont.rg, cont.tip_chamado, tip.id_tipo, tip.tipos
							FROM local AS loc
							INNER JOIN contrato AS cont ON  cont.id_contrato = loc.id_contrato 
							INNER JOIN tipo AS tip ON  tip.id_local = loc.id_local 
							WHERE loc.id_local= '$idl'";


							$resultado = mysqli_query($conection,$sqlcontrato)or die ('Não foi possivel conectar ao MySQL');
							while ($row = mysqli_fetch_assoc($resultado))
							{ 
					 			
				?>
				<option value="<?php echo $row['id_tipo'];?>"><?php echo $row['tipos'] ;?></option>  		
		<?php } ?>
			</select>
			</div>	 
               		
				<div class="col"> 
				    <input Type="hidden" name="id_local"   value="<?php echo $idl;?>" >
					<input  type="submit" name="submit" value="VALIDAR"  class="btn btn-primary " >
					<input type="hidden" name="submitted" value="TRUE" />
		</div>
				</div>
		</form>
			</div>
				</div>
		
		</body>
	</html>