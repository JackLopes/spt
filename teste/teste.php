<!DOCTYPE html>

<?php
$page_title = 'Informação Prestador';
include 'gac_cabeça.php';
?>


<?php
 if (isset($_GET['id'])) {
$id =(int)$_GET['id'];} 

if (isset($_GET['ct'])) {
$ct =(int)$_GET['ct'];} 




/*var_dump($id);*/


?>
<?php

if (isset($_POST['submitted'])){
$erro = array();

	if (empty($_POST['id'])) {
	$erro[] = 'Há problemas com a identificação do contrato';
	} else if (is_numeric($_POST['id'])){	
	$id = mysqli_real_escape_string($conection, trim($_POST['id']));
	} else { $erro[]='Há problemas com a identificação do contrato';}	



	if (empty($_POST['tipos'])){
	$erro[] = 'Informar o TIPO.';
	} else {
	$tip = mysqli_real_escape_string($conection, trim($_POST['tipos']));}


	$lg = ($_POST['lugar_regional']);
	
	$prazo_entrega = ($_POST['prazo_entrega']);
	
if (empty($erro)) {	    
	
		 
    
	$q = "SELECT tipos FROM tipo WHERE id_local = '$id' AND lugar_regional = '$lg' AND tipos = '$tip' "; 
	$r = mysqli_query($conection, $q);
    $num = mysqli_num_rows ($r);	
	
	if ($num  < 1) {	


    $q = "INSERT INTO tipo (id_local, tipos,lugar_regional, prazo_entrega ) VALUES ('$id', '$tip','$lg', '$prazo_entrega' )"; 
	$r = mysqli_query($conection, $q);
    
    if ($r) {
	echo '<h3>Cadastro realizado com sucesso !!!</h3>';
   ?>
   
   <nav class="navbar fixed-bottom navbar-light bg-light">
<?php 

if  (isset($_GET['ct'])) { ?>
	
	 <a class="navbar-brand" href="idex.php?id=<?php echo $_GET['ct'];?>">RETORNAR </a>

	 <?php

	} else { ?>
		
	<a class="navbar-brand" href="lista_geral.php">RETORNAR </a>
	
 <?php	
	;}  
	
	?> 
</nav>

   
   
   
   
   
   
   
   
   <?php 
	 
	mysqli_close($conection);    
	exit(); }	
	   
    } else {	
	echo "<center><h3>Já há um grupo de " . $tip . " cadastrado</h3></center>\n";
	mysqli_close($conection);    
     exit();
}} else {  echo '<h2>Atenção!</h2>
    <p class="error">Ficaram as seguintes pendencias:<br />';
    foreach ($erro as $mg)
    echo " - $mg<br>\n ";
    echo '</p><p>Por favor, refaça os preenchimentos.</p><p><br/ ></p>';
    mysqli_close($conection);    
     exit();}}

?>
<!doctype html>
<html lang="pt">

<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 <title>Fornecedor</title>

<link rel="stylesheet"  type="text/css" href="css/styleinf_local.css" media="screen"/>
 <link rel="stylesheet" href="css/bootstrap.css" >
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<link href='./css/bootstrap.min.css' rel='stylesheet'>
		<link href='./css/fullcalendar.min.css' rel='stylesheet' />
		<link href='./css/fullcalendar.print.min.css' rel='stylesheet' media='print' />
		<link href='./css/personalizado.css' rel='stylesheet' />
		<script src='./js/jquery.min.js'></script>
		<script src='./js/bootstrap.min.js'></script>
		<script src='./js/moment.min.js'></script>
		<script src='./js/fullcalendar.min.js'></script>
		<script src='./locale/pt-br.js'></script>
</head>
<body >
 <script>
			
	$('#visualizar').modal('show');		
			
</script>


 
 <div  class="container " >
<div  class="row" id="div1">
  <nav class="col-md- d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
		    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>CADASTRO</span>        
              
            </h6>
		  
            <ul class="nav flex-column">
              
              <li class="nav-item">
                <a class="nav-link" href="cad_colaborador.php?id=<?php echo $id ?>">
				 Responsáveis				
				</a>                  
              </li>
			    <li class="nav-item">
                <a class="nav-link"  href="#" data-toggle="modal" data-target="#grupoHard">
				 Grupo de Objetos				
				</a>                  
              </li>
			    </li>
			    <li class="nav-item">
                <a class="nav-link"  href="#" data-toggle="modal" data-target="#visualizar">
				 Grupo de Objetos				
				</a>                  
              </li>
             
            </ul>

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
             ATUALIZAR             
            </h6>
            <ul class="nav flex-column mb-2">
              <li class="nav-item">
                <a class="nav-link" href="inf_prestador.php?id=<?php echo $for?>&ct=<?php echo $id?>"> 				           
                  Regional
                </a>
              </li>             
            </ul>
			 <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
             RELATÓRIOS             
            </h6>
			<ul class="nav flex-column mb-2">
              <li class="nav-item">
              
              </li>             
            </ul>
          </div>
        </nav>
 <main role="main" class="col-md-8 ml-sm-6 col-lg-10 ">


	
<div  class="row" id="forn">
		
<br />
<center><h6><b>UNIDADE DEMANDANTE</h6></center><p>

<table  class="table table-striped table-hover table-bordered table-sm"   >		
<?php

echo "<tr>";
echo "</tr>";


require_once 'database_gac.php';


	

$sqlprestador = "SELECT * FROM local WHERE id_local = $id";
$resultado = mysqli_query($conection,$sqlprestador)or die ('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado))
{
	$idp = $registro['id_local'];
	$nome = $registro['lugar_regional'];
	$cnpj = $registro['cnpj'];	
	$endereco = $registro['endereco'];
	
	
	
	
	echo "<p><tr><td width='20px '><b>REGIONAL:</td><td  >  ".$nome ."</td><tr>";		
	echo "<tr><td><b>CNPJ:</td><td> ".$cnpj."</td><tr>";
	echo "<tr><td><b>ENDEREÇO:</td><td> ".$endereco."</td><tr>";
	
} 
echo "</table>";
 ?>
 
<br />
</div>

<div class="cont">
<br /><h6 id="ti" ><b>RESPONSÁVEIS<h6><br/>
 <table  class="table table-striped table-hover table-bordered table-sm"  id= "tb2">
 <tr>
 <td class = "td1">ATUAÇÃO</td>
  <td class = "td1">NOME</td>
  <td class = "td1">AREA</td>
 <td class = "td1">FUNÇÃO</td>
 <td class = "td1">EMAIL</td>
 <td class = "td1">MATRICULA</td>
 <td class = "td1">TELEFONE</td>
 
 
 </tr> 
 <?php
	
 			
				$sqlcolaborador = "SELECT * FROM responsaveis WHERE id_local= '$idp'";
				$resultado = mysqli_query($conection,$sqlcolaborador)or die ('Não foi possivel conectar ao MySQL');
				while ($registro = mysqli_fetch_array($resultado)) {
			
				
					
	?>
    <tr>
		 <td class = "td2" ><?php echo $registro['responsabilidade'];?></td>	
        <td class = "td2" ><?php echo  $registro['nome'];?></td>
		<td class = "td2" ><?php echo $registro['area'];?></td>
        <td class = "td2" ><?php echo $registro['funcao'];?></td>
        <td class = "td2" ><?php echo $registro['email'];?></td> 
		  <td class = "td2" ><?php echo $registro['matricula'];?></td>  
		<td class = "td2" ><?php echo $registro['telefone'];?></td>
       
        <td>
            <a class = "td2" href="form.php?id=<?php echo $res['id']?>">
                EDITAR
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
</main>
</div>
</br>

   
	

</div>

</div>



<div class="modal fade"  id="grupoHard"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"id="exampleModalLabel" text="center" ><font color='#0080FF'>GRUPO DE OBJETOS</font></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <form action="inf_local.php" method="post">
		
		<div class="form-row">
		                <div class="form-group col-md-6">
						<label for="ctipos">GRUPO:</label>
								<select class="form-control" name="tipos" Type="text"  id="ctipos" value="<?php if (isset($_POST['tipos']))echo $_POST['tipos'];?>" />
								  <option value="HARDWARE">HARDWARE</option>
								  <option value="SOFTWARE">SOFTWARE</option>
								</select><br/>
						</div>		
							<div class="form-group col-md-6">
							  <label for="cprazo_entrega" >PRAZO DA ENTREGA:</label>
							  <input class="form-control" name="prazo_entrega" Type="date"  id="cprazo_entrega"  value="<?php if (isset($_POST['prazo_entrega']))echo $_POST['prazo_entrega'];?>" >
							</div>	
							</div>		
							<div class="form-group col-md-12">
							  <label for="crec_definitivo" >RECEBIMENTO DEFINITIVO:</label>
							  <input class="form-control" name="rec_definitivo" Type="date"  id="crec_definitivo"  value="<?php if (isset($_POST['rec_definitivo']))echo $_POST['rec_definitivo'];?>" >
							</div>	
						<div class="form-group col-md-2">	
						<input name="id" type="hidden" value=<?php echo $id ; ?>>
								<input name="lugar_regional" type="hidden" value=<?php echo $nome ; ?>>
								<p><input type="submit" name="submit" value="ENVIAR"  class="btn btn-primary" />
						<input type="hidden" name="submitted" value="TRUE" />
		             </div>		
		       </form>	 
	 	  </div>
	</div>        
        </div>    
			</div>
			
	<?php


			$sql_tipo = "SELECT * FROM tipo WHERE id_local= '$idp'";
				$resultado = mysqli_query($conection,$sql_tipo)or die ('Não foi possivel conectar ao MySQL');
				while ($registro1 = mysqli_fetch_array($resultado)) {
			
			
			?>
			
			
			
		<div class="container ">
			<div class="page-header">
				<h3>Eventos </h3>
			</div>
			<?php
			if(isset($_SESSION['msg'])){
				echo $_SESSION['msg'];
				unset($_SESSION['msg']);
			}
			?>
		
		
		</div>	
			
			
			
			
			
			
	<!--- visualizar e Editar --->
			<div class="modal fade" id="visualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title text-center">Detalhes Recebimto</h4>
					</div>
					<div class="modal-body">
						<div class="visualizar." >
							<dl class="dl-horizontal">
								<dt>ID</dt>
								<dd ><?php echo $registro1['id_tipo'];?></dd>
								<dt>Grupo</dt>
								<dd><?php echo $registro1['tipos'];?></dd>
								<dt>Prazo de Entrega</dt>
								<dd><?php echo $registro1['prazo_entrega'];?></dd>
								<dt>Recebimento</dt>
								<dd><?php echo $registro1['rec_definitivo'];?></dd>
								
								 
							</dl>
							<button class="btn btn-canc-vis btn-warning">Editar</button>
						</div>
						<div class="form">							
								       <form class="form-horizontal" action="inf_local.php" method="post">										
		
									               <div class="form-row">
													<div class="form-group col-md-6">
													<label for="ctipos">GRUPO:</label>
															<select class="form-control" name="tipos" Type="text"  id="ctipos" value="<?php if (isset($_POST['tipos']))echo $_POST['tipos'];?>" />
															  <option value="HARDWARE">HARDWARE</option>
															  <option value="SOFTWARE">SOFTWARE</option>
															</select><br/>
													</div>		
														<div class="form-group col-md-6">
														  <label for="cprazo_entrega" >PRAZO DA ENTREGA:</label>
														  <input class="form-control" name="prazo_entrega" Type="date"  id="cprazo_entrega"  value="<?php if (isset($_POST['prazo_entrega']))echo $_POST['prazo_entrega'];?>" >
														</div>	
													</div>	
													<div class="form-row">
														<div class="form-group col-md-12">
														  <label for="crec_definitivo" >RECEBIMENTO DEFINITIVO:</label>
														  <input class="form-control" name="rec_definitivo" Type="date"  id="crec_definitivo"  value="<?php if (isset($_POST['rec_definitivo']))echo $_POST['rec_definitivo'];?>" >
														</div>
													</div>				
													<div class="col-sm-offset-2 col-sm-10">
														<input name="id" type="hidden" value=<?php echo $id ; ?>>
														<input name="lugar_regional" type="hidden" value=<?php echo $nome ; ?>>
														<input type="hidden" name="submitted" value="TRUE" />	
														<button type="button" class="btn btn-canc-edit btn-primary">Cancelar</button>
														<button type="submit" class="btn btn-warning">Salvar Alterações</button>
													</div>														
										    </form>									
												
						</div>
								
									
						</div>
						</div>
					</div>
			</div>
		
		
		
				<?php } ?>		
		
		<!----fim --->
		
	
	<script>
			
		
			$('.btn-canc-vis').on("click", function() {
				$('.form').slideToggle();
				$('.visualizar').slideToggle();
			});
			
			$('.btn-canc-edit').on("click", function() {
				$('.visualizar').slideToggle();
				$('.form').slideToggle();
			});
	</script>


		



<nav class="navbar fixed-bottom navbar-light bg-light">
<?php 

if  (isset($_GET['ct'])) { ?>
	
	 <a class="navbar-brand" href="idex.php?id=<?php echo $_GET['ct'];?>">RETORNAR </a>

	 <?php

	} else { ?>
		
	<a class="navbar-brand" href="lista_geral.php">RETORNAR </a>
	
 <?php	
	;}  
	
	?> 
</nav>
</body>
</html>