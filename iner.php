
<?php
require_once 'database_gac.php';

$id='78';


							 $q2 = "SELECT cont.*,loc.lugar_regional
							 FROM contrato AS cont
							 INNER JOIN local AS loc ON loc.Id_contrato = cont.Id_contrato						
							 WHERE id_contrato = '$id'";
							 $r2 = mysqli_query($conection, $q2);
	                         while($row = mysqli_fetch_assoc($r2)) {
							 $tch = $row ['tip_chamado'];
							 $rg = $row ['rg'];
							  $regional=$row ['lugar_regional'];
							  
							  
							  var_dump($tch) ;
							    var_dump($rg) ;
								  var_dump($regional) ;
							
							}
							
		?>