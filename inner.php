
<?php
/*
require_once 'database_gac.php';


$id= '78';


$sqlcontrato = "SELECT cont.rg, cont.tip_chamado 
loc.id_local, loc.lugar_regional	
FROM contrato AS cont
INNER JOIN local AS loc ON  cont.id_contrato = loc.id_contrato

WHERE id_contrato = $id";



$resultado = mysqli_query($conection,$sqlcontrato)or die ('Não foi possivel conectar ao MySQL');
while ($row = mysqli_fetch_assoc($resultado))
{ 

echo "tc ;:" .$row['tip_chamado'] . "<br/>";
echo "rg " .$row['rg'] . "<br/>";
echo "tc ;:" .$row['id_local'] . "<br/>";
echo "rg " .$row['lugar_regional	'] . "<br/>";
  
}

*/

require_once 'database_gac.php';
$id= '78';


$sqlcontrato = "SELECT loc.id_local, loc.lugar_regional	,
cont.rg, cont.tip_chamado, tip.id_tipo, tip.tipos

FROM local AS loc
INNER JOIN contrato AS cont ON  cont.id_contrato = loc.id_contrato 
INNER JOIN tipo AS tip ON  tip.id_local = loc.id_local 
WHERE cont.id_contrato= '$id'";



$resultado = mysqli_query($conection,$sqlcontrato)or die ('Não foi possivel conectar ao MySQL');
while ($row = mysqli_fetch_assoc($resultado))
{ 

echo "tc ;:" .$row['tip_chamado'] . "<br/>";
echo "rg " .$row['rg'] . "<br/>";
echo "idl ;:" .$row['id_local'] . "<br/>";
echo "lg: " .$row['lugar_regional'] . "<br/>";
echo "idt: " .$row['id_tipo'] . "<br/>";
echo "idt: " .$row['tipos'] . "<br/><hr>";
  
}

/*

$result_niv_ac = "SELECT nivac.*,
sit.nome nome_sit
FROM niveis_acessos AS nivac
INNER JOIN situacaos AS sit ON sit.id = nivac.situacao_id
ORDER BY nivac.id";

$resultado_niv_ac = mysqli_query($conn, $result_niv_ac);

while($row_niv_ac = mysqli_fetch_assoc($resultado_niv_ac)){
	echo "ID: " . $row_niv_ac['id'] . "<br>";
	echo "Nível de Acesso: " . $row_niv_ac['nome'] . "<br>";
	echo "Situação do Nível de Acesso: " . $row_niv_ac['nome_sit'] . "<br><hr>";
}
*/

	
	
	
	
	
	
		






?>



<div  class="row" id="REG">	
		
	<select  class="btn btn-outline-light" id="Rap" name="id_contrato" onchange="location = this.value;">
	<option>REGIONAIS</option>  
	<?php	
    $q1 = "SELECT * FROM local WHERE id_contrato = '$id'";
	$r1 = mysqli_query($conection, $q1);
	while($row = mysqli_fetch_assoc($r1)) { ?>
	<option value= "inf_local.php?id=<?php echo $row['id_local'];?>&ct=<?php echo $id;?>"><?php echo $row['lugar_regional'] ;?></option>  
		
	<?php } ?>
	</select><br><br>
</div>



