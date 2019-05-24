


<?php


include 'gac_cabeça.php';









function inverteData($data){
    if(count(explode("/",$data)) > 1){
        return implode("-",array_reverse(explode("/",$data)));
    }elseif(count(explode("-",$data)) > 1){
        return implode("/",array_reverse(explode("-",$data)));
    }
}


function SomarData($data, $dias, $meses, $ano)
{
   /*www.brunogross.com*/
   //passe a data no formato dd/mm/yyyy 
   $data = explode("/", $data);
   $newData = date("d/m/Y", mktime(0, 0, 0, $data[1] + $meses,
     $data[0] + $dias, $data[2] + $ano) );
   return $newData;
}

function SubData($data, $dias, $meses, $ano)
{
   /*www.brunogross.com*/
   //passe a data no formato dd/mm/yyyy 
   $data = explode("/", $data);
   $newData = date("d/m/Y", mktime(0, 0, 0, $data[1] - $meses,
     $data[0] - $dias, $data[2] - $ano) );
   return $newData;
}

function dataToTimestamp($data){
   $ano = substr($data, 6,4);
   $mes = substr($data, 3,2);
   $dia = substr($data, 0,2);
return mktime(0, 0, 0, $mes, $dia, $ano);  
} 

function CalculaDias($xDataInicial, $xDataFinal){
   $tMenor= dataToTimestamp($xDataInicial);  
   $tMaior = dataToTimestamp($xDataFinal);  


   $diff = $tMaior-$tMenor;  
   $numDias = $diff/86400; //86400 é o número de segundos que 1 dia possui  
   return $numDias;
}

$page_title = 'Bem vindo ao Site';

?>


<?php
 if (isset($_GET['id'])) {
$id =(int)$_GET['id'];} 

 /*if (isset($_POST['id_local'])) { 	 
$idl = $_POST['id_local'];
}
		 
if (isset($_POST['tipos'])) {
$tips = $_POST['tipos'];} */


?>
<?php
require_once 'database_gac.php';

			$sql_tipo = "SELECT MAX(rec_definitivo) AS rece FROM local WHERE id_contrato = $id";
				
				$resultado = mysqli_query($conection,$sql_tipo)or die ('Não foi possivel conectar ao MySQL');
				while ($registro1 = mysqli_fetch_array($resultado)) {
			     
				 $d_recebimento = inverteData($registro1['rece']);			
				
				}


$sqlcontrato = "SELECT * FROM contrato WHERE id_contrato = $id";
$resultado = mysqli_query($conection,$sqlcontrato)or die ('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado))
{ $for = $registro['id_prestador'];
  $rg = $registro['rg'];
 

$sql3 = "SELECT * FROM prestador WHERE id_prestador = $for";
$resultado1 = mysqli_query($conection, $sql3)or die ('Não foi possivel conectar ao MySQL');
while ($registro1 = mysqli_fetch_array($resultado1)){
	
	$nom = $registro1['nome'];
	$val_cot = number_format($registro['valor_Contratado'], 2, ',', '.');
		$vigência = $registro['vig_contrat'];
		$data1 = inverteData($registro['d_Inic_vige_contr']);
		$data2 = inverteData($registro['d_fim_vige_cont']);
		$data3 = inverteData($registro['d_Aceite']);
		$data4 = inverteData($registro['d_Assinatura']);
		$data5 = inverteData($registro['d_prorro']);
		$garantia = $registro['vig_garantia'];
		$link_processoverde = $registro['link_pv'];
		$link_gedig = $registro['link_ged'];
		$link_proposta = $registro['link_proscorm'];
	
	$d = ' 1';
	
	
	$termino_vig = SomarData( $data1, 0, $vigência, 0);	
	$termino_vig1 = SubData(  $termino_vig, $d, 0, 0);
	
	$termino_garantia = SomarData( $d_recebimento, 0, $garantia , 0);	
	$termino_garantia1 = SubData(  $termino_garantia, $d, 0, 0);	 
	 
	 $data10 =  date('d/m/y');
		  
	$temp_rest_garant = CalculaDias($data10 , $termino_garantia1  ); 
	$temp_rest_garant = intval($temp_rest_garant );
	
	
	
	
	if ($temp_rest_garant <  1){
		$temp_rest_garant= '0';
		
	}else {
		$temp_rest_garant = $temp_rest_garant;
		
	}
	 
	
	
	
}

?>


<!doctype html>
<html lang="pt">

<head>
 <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
	<link rel="stylesheet"  type="text/css" href="css/styleidexone.css" media="screen"/>
	<link rel="stylesheet" href="css/bootstrap.css" > 
	<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
	
	<script type="text/javascript">
			$(document).ready(function(){
					$('h6, #acme' ).css("border-bottom", "solid 1px #cfcfcf")
	 	
			});
				
		</script>		
		
	
<title><?php echo $page_title; ?></title>




</head>

<body >

<div  class="container-fluid    " >
 <div  class="row   justify-content-center" " id="div1">
  <nav class="col-md-1 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
		    

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
             DETALHES             
            </h6>
            <ul class="nav flex-column mb-2">
              <li class="nav-item">
                <a class="nav-link" href="inf_prestador.php?id=<?php echo $for?>&ct=<?php echo $id?>"> 				           
                  FORNECEDOR
                </a>
              </li>             
            </ul>
			 <ul class="nav flex-column mb-2">
              <li class="nav-item">
                <button type="button" class="btn btn-light" data-toggle="modal" data-target="#exampleModalCenter2"> 				           
                  REGIONAL
                </a>
              </li>             
            </ul>
			
			 <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
             RELATÓRIOS             
            </h6>
			<ul class="nav flex-column mb-2">
              <li class="nav-item">
                <a class="nav-link" href="ans.php?id=<?php echo $id?>&rg=<?php echo $rg?>&nom=<?php echo $nom?>">
				  ANS  
                </a>
              </li>             
            </ul>
			  <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>CADASTRO</span>    
             
              </a>
            </h6>
		  
            <ul class="nav flex-column">   
             
		
              <li class="nav-item">
                <a class="nav-link" href="cad_regional.php?id=<?php echo $id?>">
				REGIONAIS
				</a>                  
              </li>
              <li class="nav-item">
                <a class="nav-link" href="cad_severidade.php?id=<?php echo $id?>"> 
			 SEVERIDADES 
				</a>                 
              </li>
              <li class="nav-item">
                <a class="nav-link"  href="teste/index2.php?ids=<?php echo $id?>"> 
				EVENTOS
				</a>
                  
              </li>
              <li class="nav-item">
                <a class="nav-link"  href="menu_local.php?id=<?php echo $for?>">
				CONTRATO 
                </a>
              </li>
			 
             
            </ul>

          </div>
		  <button type="button" class="btn btn-light" data-toggle="modal" data-target="#exampleModalCenter">
             <a style="color:#0080FF">GRUPO DO OBJETO</a>
           </button>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">SELECIONE A REGIONAL</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  
	  
        <div  class="row" id="REG">	 
 
		
	<select  class="btn btn-outline-light" id="Rap" name="id_contrato" onchange="location = this.value;">
	<option>REGIONAIS</option>  
	<?php	
    $q1 = "SELECT * FROM local WHERE id_contrato = '$id'";
	$r1 = mysqli_query($conection, $q1);
	while($row = mysqli_fetch_assoc($r1)) {
		
	?>
	<option value= "inf_local.php?id=<?php echo $row['id_local'];?>&ct=<?php echo $id;?>"><?php echo $row['lugar_regional'] ;?></option>  
		
	<?php } ?>
	</select>
	</div><br/>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">SELECIONE A REGIONAL</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  
	  
        <div  class="row" id="REG">	 
 
		
	<select  class="btn btn-outline-light" id="Rap" name="id_contrato" onchange="location = this.value;">
	<option>REGIONAIS</option>  
	<?php	
    $q1 = "SELECT * FROM local WHERE id_contrato = '$id'";
	$r1 = mysqli_query($conection, $q1);
	while($row = mysqli_fetch_assoc($r1)) {
		
	?>
	<option value= "inf_local.php?id=<?php echo $row['id_local'];?>&ct=<?php echo $id;?>"><?php echo $row['lugar_regional'] ;?></option>  
		
	<?php } ?>
	</select>
	</div><br/>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
        </nav>
 <main role="main" class="col-md-8 ml-sm-6 col-lg-10 pt-0 px-4">

<table  class="table table-striped table-bordered table-hover table-sm  bg-light "    >



	
	
	
	<thead>
     <thead class="thead-dark">
        <th scope="col" colspan ="3" fonte-size align="center"  height= "30px" bgcolor= "#e8e8e8" ><center><?php echo "<b><font color='#0080FF'>RG: </font></b>" .  $registro['rg'];?></th>
	 </tr>
	 </thead>
	  <tbody>
	  <tr>
	 <td colspan ="3"><?php echo "<font color='#0080FF'> OBJETO : </font>"  . $registro['objeto'];?></td>    
    </tr>
	 <tr>
		<td><?php echo "<font color='#0080FF'> STATUS : </font>" . $registro['status'];?></td>
       <td><?php echo  "<font color='#0080FF'> SISCOR INICIAL: </font>" .  $registro['n_siscor'];?></td>       
		<td><?php echo "<font color='#0080FF'> VALOR CONTRATADO:  </font>" . "R$ ". $val_cot;?></td>
	</tr>
	 <tr>		
		<td><?php echo "<font color='#0080FF'> VALOR ATUAL : </font>" . "R$";?></td>
		<td><?php echo "<font color='#0080FF'> FORNECEDOR : </font>" . $nom ;?></td>
       <td><?php echo  "<font color='#0080FF'> TIPO : </font>" .  $registro['tipo'];?></td>		
	</tr>
	
	<tr>
		<td><?php echo "<font color='#0080FF'> VIGÊNCIA CONTRATUAL: </font>" .  $registro['vig_contrat'] . " MÊSES";?></td>
       <td><?php echo "<font color='#0080FF'> INÍCIO VIG. CONTRATUAL: </font>" .  $data1;?></td>		
       <td><?php echo "<font color='#0080FF'> FINAL VIG. CONTRATUAL: </font>" .  $termino_vig1;?></td> 		
	 </tr>
		<tr>
		<td><?php echo "<font color='#0080FF'> PRORROGAÇÃO FIM VIG. CONTRATUAL: </font>" ;?></td> 		
     <td><?php echo "<font color='#0080FF'> VIGÊNCIA GARANTIA : </font>" . $registro['vig_garantia'] . " MÊSES";?></td>
       <td><?php echo "<font color='#0080FF'> RECEBIMENTO DEFINITIVO : </font>" . $d_recebimento ;?></td>     
	    
    </tr>
	<tr>
	<td><?php echo "<font color='#0080FF'> DATA FINAL DA GARANTIA : </font>" . $termino_garantia1;?></td>	
	<td><?php echo "<font color='#0080FF'>  A GARANTIA ACABA EM  </font>" . $temp_rest_garant . " DIAS";?></td>        
	<td><?php echo "<font color='#0080FF'> Nº PROCESSO : </font>"  . $registro['n_processo'];?></td>	  
    
    </tr>
	<tr>
	
	<td><?php echo "<font color='#0080FF'>  DATA DA ASSINATURA : </font>" . $data4;?></td> 
	<td><?php echo "<font color='#0080FF'> POSSÍVEL PRORROGAÇÃO: </font>"  . $registro['pos_prorrogacao'];?></td>
	<td><?php echo "<font color='#0080FF'> PRORROGAVÉL ATÉ : </font>" . $data5 ;?></td>   
   	 
    </tr>
	<tr>
	<td><?php echo "<font color='#0080FF'> Nº PROJETO BÁSICO : </font>"  . $registro['projeto_basico'];?></td>	
	<td><?php echo "<font color='#0080FF'>  DATA DA ASSINATURA : </font>" . $data4;?></td>        
	<td><?php echo "<font color='#0080FF'> PROCESSO DECISÓRIO: </font>"  ;?></td>  
    
    </tr>
	
	
    <?php
}

?>




 </tbody>
</table></br>
	<div class="col-sm">
	<ul class="nav">
  <li class="nav-item">
    <a class="nav-link active"  href=<?php echo $link_processoverde?> target="_blank"><em><u>Link Processo Verde</u></em></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href=<?php echo $link_processoverde?> target="_blank"><em><u>Linke GEDIG</u></em></a>
  </li>
  <li class="nav-item">
    <a class="nav-link"href=<?php echo $link_processoverde?> target="_blank"><em><u>Link Proposta Comercial</u></em></a>
  </li>
  
</ul>
		
	</div></br>




  	 <table  class="table table-hover table-striped table-sm table-bordered bg-light"   >
	   <thead class="thead-dark ">
			 <tr>
			 <th scope="col">GRUPO</th>
			 <th scope="col">SEVERIDADE</th>
		     <th scope="col">TIPO</th>
			 <th scope="col">DESCRIÇÃO</th>
			 <th scope="col">ATENDIMENTO</th>
			 <th scope="col">SOLUÇÃO</th>
		     <th scope="col">MULTA</th>
				 
			 </tr> 
			  </thead>
 <?php
	
 			
				$severi = "SELECT * FROM severidades WHERE id_contrato = '$id'";
				$resultado = mysqli_query($conection,$severi)or die ('Não foi possivel conectar ao MySQL');
				while ($registro = mysqli_fetch_array($resultado)) {
				
				if ($registro['modo'] == 1) {
				$modo1= "24 x 7";}
				else {$modo1= "10 x 5";					
				}
				
				
	?>
    <tr>
        <td ><?php echo  $registro['item'];?></td>
        <td  ><?php echo $registro['severidade'];?></td>
        <td ><?php echo $modo1;?></td>
        <td  ><?php echo $registro['descricao'];?></td>
		<td  ><?php echo $registro['prazo_atend'];?></td>
        <td  ><?php echo $registro['prazo_solu'];?></td>
		<td  ><?php echo $registro['multa'];?></td>
        
    </tr>
	
	
	<?php
}
?>
 </table>
 <br/>
 <div> ACESSO  MENU LANÇAMENTOS <hr class="mb-4"></div> <br/>
 </div>



 	 



 
 <?php
 

 
if (isset($_POST['submitted'])){
	
	
$erro = array();

	if (!empty($_POST['id_local']) AND (empty($_POST['id_tipo'])) AND (is_numeric($_POST['id_local']))) {
	
	$idl  = mysqli_real_escape_string($conection, trim($_POST['id_local']));
	
	include_once 'include_tipos.php';

exit();	}
	
	
	else if (!empty($_POST['id_local']) AND  (!is_numeric($_POST['id_local']))){
	$erro[] = 'SELECIONE A REGIONAL';
	}
	
	
	
	if (empty($_POST['id_local']) AND empty($_POST['id_tipo']) ) {
	$erro[] = 'SELECIONE A REGIONAL';
	}else if (is_numeric($_POST['id_local'])) {			
	$idl2  = mysqli_real_escape_string($conection, trim($_POST['id_local']));	
	} else { $erro[]='SELECIONE A REGIONAL';}	
	
    if (empty($_POST['id_tipo']) ) {
	$erro[] = 'SELECIONE A REGIONAL' ;
	}else if (is_numeric($_POST['id_tipo'])) {			
	$tip = mysqli_real_escape_string($conection, trim($_POST['id_tipo']));	
	} else { $erro[]='VOCÊ NÃO SELECIONOU O TIPO OU NÃO HÁ TIPOS CADASTRADOS';}	
	

    
	
	

if (empty($erro)) {	   



	
	
	/*
	var_dump ($idl2);
	
	var_dump ($ver); 	
			
	var_dump ($tips);
	
	var_dump ( $num);*/

	
	   
      

			 		

		
			 
			 
		?>
		
		<div  class="col-md-12 order-md-1">
		
		<div  class="alert alert-success" role="alert"><center>
        Perfeito !!! Lançamento  do atendimento Permitido !
         </center></div> </div> <?php
			 
			 
		 
			

	
							$an = date('Y');
	
							 $q2 = "SELECT * FROM contrato WHERE id_contrato = '$id'";
							 $r2 = mysqli_query($conection, $q2);
	                         while($row = mysqli_fetch_assoc($r2)) {
							 $tch = $row ['tip_chamado'];
							 $rg = $row ['rg'];
							
							}
 	                       					
							 $q3 = "SELECT * FROM local WHERE id_local = '$idl2'";
							 $r3 = mysqli_query($conection, $q3);
	                         while($row = mysqli_fetch_assoc($r3)) {
							 $regional=$row ['lugar_regional'];
							}
							
							
 include_once 'include_lancamento.php';				
							
							
							
							}  else 

{  
   foreach ($erro as $mg)
   ?>
   	<div class="col-md-12 order-md-1">
   
   <div id="rec2" class="alert alert-danger" role="alert"><center>
<?php   echo " ATENÇÃO !!!" . " - $mg<br>\n "; ?>
    </center></div>
	   </div>
    	<div class="col-md-12 order-md-1">
<nav class="navbar fixed-bottom navbar-light bg-light">
  <a class="navbar-brand" href="idex.php?id=<?php echo $_GET['id'];?>">RETORNAR  </a>
</nav>
 </div>
<?php ;}} ?> 	
	
 			
		</div>		


</main>

	

  
  
 
</body>
  <script src="js/bootstrap.min.js"></script>
</html>

<?php
if (!isset($_POST['submitted'])){

	include 'selec_regional.php';}

?>



