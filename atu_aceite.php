
<?php

	

	if (isset($_GET['id'])) {
	$id =(int)$_GET['id'];} 
	
	$id = 1;
	
?>


<?php
	require_once 'database_gac.php';

	if (isset($_POST['submitted'])){		
		
	
		
    $prazo_entrega= $_POST['prazo_entrega'];
    $rec_provisorio= $_POST['rec_provisorio'];
	$data_instalacao= $_POST['data_instalacao'];
	$rec_definitivo= $_POST['rec_definitivo'];
	$obs= $_POST['obs'];
	
	
	
    $q = "UPDATE aceite SET prazo_entrega='$prazo_entrega', rec_provisorio='$rec_provisorio', 
	 data_instalacao='$data_instalacao', rec_definitivo='$rec_definitivo', obs='$obs' WHERE id_iten='$id' "; 
	$r = mysqli_query($conection, $q);
    
    if (mysqli_affected_rows($conection) == 1)  {
	echo '<h6><br /> Atualização  realizada  com sucesso !</h6>'; ?>
	
	
	
	
	<?php
   
	 
	mysqli_close($conection);    
     exit(); } else {	
	echo "<center><h1>Não foi possivel realizar a atualização !</h1></center>\n";
	mysqli_close($conection);    
     exit(); }
	}?>
	
<!doctype html>
<html lang="pt-br">

	<head>
	 <meta charset="utf-8">
	 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
		<link rel="stylesheet"  type="text/css" href="" media="screen"/>
			<link rel="stylesheet" href="css/bootstrap.css" >
				<script src="jquery.js" type="text/javascript"></script>
			<script type="text/javascript" src="js1/jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="js1/jquery.mask.min.js"></script>
	</head>
<body >
 <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">CONTOLE DE RECEBIMENTO</a>
  </nav>
</div>  
<br/>
<br/>
 
  <div  class="container" > 

	 <div class="col-md- order-md-1">
          <center><h4 class="mb-3">Novo Evento</h4></center>
		    <hr class="mb-4">


	  <form id= "fmr1"  class="needs-validation "   action="cad_itens_bc.php"  method="post" novalidate>
				 <div  class="container" >		
				<div class="form-row">		
			<div class="form-group col-md-6">
			  <label for="" >PRAZO ENTREGA:</label>
			  <input class="form-control" Type="text" name="" id=""  value="<?php if (isset($_POST['']))echo $_POST[''];?>" />
			</div>
		
					
             <div class="form-group col-md-6">
			  <label for="" >DATA RECEBIMENTO PROVISÓRIO:</label>
			  <input class="form-control" Type="text" name="" id=""  value="<?php if (isset($_POST['']))echo $_POST[''];?>" />
			</div>	
            </div>		
	<div class="form-row">					
				 <div class="form-group col-md-6">
			  <label for="" >DATA INSTALAÇÃO</label>
			  <input class="form-control" Type="text" name="" id=""  value="<?php if (isset($_POST['']))echo $_POST[''];?>" />
			</div>		
					<div class="form-group col-md-6">
					  <label for="campovalor" >DATA RECEBIMENTO DEFINITIVO:</label>			 
					  <input class="form-control"  Type="text"   name="valor_contratado" id="campovalor" value="<?php if (isset($_POST['valor_contratado']))echo $_POST['valor_contratado'];?>" >
					</div>
						</div>
						<div class="form-row">		
						<div class="form-group col-md-12">
							<label for="">OBSERVAÇÃO:</label>
							<textarea class="form-control"  rows="3" class="form-control" Type="text" name="" id=""  value="<?php if (isset($_POST['']))echo $_POST[''];?>" ></textarea>
						</div>
			
			
			</div>
			
			 <input class="form-control"  type="hidden" name="id_iten" id=""  value="<?php  $id ;?>" />		
					
			
	         <input  class="btn btn-outline-primary" type="submit" name="Prosseguir &gt;$gt" value="ENVIAR"  class="btn btn-primary"/>
			 <input type="hidden" name="submitted" value="TRUE" />
       
       </div>	  
				   </div>	 
				</form>
	
     </div>
	  <div  class="container">
		<br/>		<br/>
		
		
		
		
		<table  class="table table-striped table-hover table-bordered table-sm"  >
	   <thead class="thead-dark">
			 <tr>
			 <td >PRAZO ENTREGA</td>
			 <td >R. PROVISÓRIO</td>
			 <td >D. INTALAÇÃO</td>
			 <td >R. DEFINITIVO</td>			
			 <td >OBSERVAÇÃO</td>
			 <td >STATUS</td>			
			 <td >ATUALIZAR</td>
			 <td >EXCLUIR</td>	
			 
			 </tr> 
			  </thead>
 <?php
	           
				
	
 	
				$severi = "SELECT ite.descricao , ite.serie, ace.prazo_entrega,	
				ace.rec_provisorio, ace.data_instalacao, ace.rec_definitivo, 
				ace.obs, ace.status
				FROM itens AS ite
				INNER JOIN aceite AS ace ON  ace.id_iten = ite.id_itens				
				WHERE ite.id_itens = '$id'";
				$resultado = mysqli_query($conection,$severi)or die ('Não foi possivel conectar ao MySQL');
				while ($registro = mysqli_fetch_array($resultado)) {
				
				
				
				$descricao= $registro['descricao'] ;				
			   
				
				$serie= $registro['serie'];
			
					
		echo "<h6> ". $descricao . " - " . $serie . "</h6><br/>";
				
	?>
    <tr>

        <td class = "td3" ><?php echo  $registro['prazo_entrega'];?></td>
        <td class = "td3" ><?php echo $registro['rec_provisorio'];?></td>      
		<td class = "td3" ><?php echo $registro['data_instalacao'];?></td>
        <td class = "td3" ><?php echo $registro['rec_definitivo'];?></td>
		<td class = "td3" ><?php echo $registro['obs'];?></td>
		<td class = "td3" ><?php echo $registro ['status']?></td>       
		 
    
	 <td>
           


		   <a a href="cad_aceite.php?id=<?php echo 	$id_itens?>"
               target="_blank">ATUALIZAR
            </a>
        </td>
        <td>
            <a class = "td2" href="apagar.php?id=<?php echo $res['id']?>">
                EXCLUIR
            </a>
        </td>
		
    </tr>

	
	<?php
	

	
}
?>
 </table>
 

			


</div>
<nav class="navbar fixed-bottom navbar-light bg-light ">

  <a class="navbar-brand"  href="cad_aceite.php?id=<?php echo $id;?>">RETORNAR </a>
</nav>

<script src="js/jquery.js"></script>
		<script src="js/jquery_1.js"></script>
		<script src="js/bootstrap.min.js"></script>
</body>
  </html>	