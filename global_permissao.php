<?php
 require_once 'database_gac.php';
 $mat =  $_SESSION['matricula'];
 $permissa = $_SESSION['permissao'];
        


$query = "SELECT tip.* ,  loc.lugar_regional, resp.matricula, resp.responsabilidade				
				FROM tipo AS tip
				INNER JOIN local AS loc ON  loc.id_local = tip.id_local
				INNER JOIN  responsaveis AS resp ON  resp.id_local = loc.id_local
				WHERE id_tipo = '$id_tipo' AND resp.responsabilidade = 'Fiscal Administrativo'";
				
				$resultado = mysqli_query($conection,$query)or die ('Não foi possivel conectar ao MySQL');
				while ($registro = mysqli_fetch_array($resultado)) {
                                    
                               
				$matricula = $registro['matricula'];				
				                                
                                }
 
                            
                                
   if (empty($matricula)) { $matricula = '00000000';};   
   
 /* if ($matricula === $mat or  $permissa == '2'){
    
   
 var_dump($mat);
 
 
 echo '<br>';
 
 var_dump($matricula);*/