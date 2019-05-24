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
	
if (empty($erro)) {	    
	
		 
    
	$q = "SELECT tipos FROM tipo WHERE id_local = '$id' AND lugar_regional = '$lg' AND tipos = '$tip' "; 
	$r = mysqli_query($conection, $q);
    $num = mysqli_num_rows ($r);	
	
	if ($num  < 1) {	


    $q = "INSERT INTO tipo (id_local, tipos,lugar_regional ) VALUES ('$id', '$tip','$lg' )"; 
	$r = mysqli_query($conection, $q);
    
    if ($r) {
	echo '<h3>Cadastro realizado com sucesso !!!</h3>';
   
	 
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

</head>
<body >
 
 
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
<div class="col-sm-8">	
<form action="inf_local.php" method="post">
<select name="tipos" Type="text"  id="ctipos" maxlength="40" value="<?php if (isset($_POST['tipos']))echo $_POST['tipos'];?>" />
<option value="HARDWARE">HARDWARE</option>
  <option value="SOFTWARE">SOFTWARE</option>
</select><BR><BR>
<input name="id" type="hidden" value=<?php echo $id ; ?>>
<input name="lugar_regional" type="hidden" value=<?php echo $nome ; ?>>
<p><input type="submit" name="submit" value="Cadastrar"/>
<input type="hidden" name="submitted" value="TRUE" />

</div>

<table class="table" id="tb1"  >

 <tr>
 <td >GRUPO</td>
  <td >DESCRIÇÃO</td>
  <td >R. PROVISÓRIO</td>
 <td >INTALAÇÃO</td>
 <td >status</td>  
 
 </tr> 




<?php 
				
				$severi = "SELECT tip.* , ite.descricao, ace.data_aceite, ace.data_recebimento 			
				FROM tipo AS tip
				LEFT JOIN itens AS ite ON  ite.id_tipo = tip.id_tipo
				LEFT JOIN aceite AS ace ON  ace.id_iten = ite.id_itens
				WHERE id_local = '$id'";
				$resultado = mysqli_query($conection,$severi)or die ('Não foi possivel conectar ao MySQL');
				while ($registro = mysqli_fetch_array($resultado)) {
         
$data=date('Y-m-d');

$d_ace= $registro['data_aceite'];
$d_rec= $registro['data_recebimento'];

$data_prazo = '2018-05-21';
$data_rece_defi = '2013-05-22';
 $controle =1;
 
 if(!empty($d_ace) && !empty($d_rec )){ 
        
 
          if(strtotime($data_prazo) < strtotime($data) && $controle==1 ){
		  $status='atrasado' ;}
		   else if(strtotime($data_prazo) > strtotime($data) && $controle==1 ){
		  $status='no prazo' ;}
		   else if(strtotime($data_prazo) == strtotime($data) && $controle==1) {
		  $status='hoje vence o prazo' ;} 
		   else if(strtotime($data_prazo) < strtotime($data) && $controle==2 ){
		  $status='ok'; }
		   else if(strtotime($data_prazo) > strtotime($data) && $controle==2 ){
		  $status='ok' ;}
		   else if(strtotime($data_prazo) == strtotime($data) && $controle==2 ){
		  $status='ok'; 
		  } 
            }	  else {  $status='pendente de lançamento';}
		  
		  
		  


		     

	?>
	
	  <tbody>
	 <tr>
		<td "td1"><?php echo  $registro['tipos'];?></td>
		 <td "td1"><?php echo  $registro['descricao'];?></td>    
		<td "td1"><?php echo  $registro['data_aceite'];?></td>
		 <td "td1"><?php echo  $registro['data_recebimento'];?></td>    
		<td><?php echo  $status ?></td>
     </tr>
	 
	
    <?php
}

?>



 </tbody>
</table></br>


</div>
</div>
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