<?php
session_start();
require_once 'database_gac.php';

 
        $id_contrato=filter_input(INPUT_POST, 'id_contrato', FILTER_SANITIZE_NUMBER_INT);
        $percent_atrasoEntrega = floatval(filter_input(INPUT_POST, 'percent_atrasoEntrega', FILTER_SANITIZE_STRING));
        $percent_naoObjeto = floatval(filter_input(INPUT_POST, 'percent_naoObjeto', FILTER_SANITIZE_STRING));
        $percent_descumprimento = floatval(filter_input(INPUT_POST, 'percent_descumprimento', FILTER_SANITIZE_STRING));
        $limiteParcial = floatval(filter_input(INPUT_POST, 'limiteParcial', FILTER_SANITIZE_STRING));
        $limiteTotal = floatval(filter_input(INPUT_POST, 'limiteTotal', FILTER_SANITIZE_STRING));
        
	
        
        var_dump($percent_atrasoEntrega);
        
        
       
   

if (!empty($id_contrato)){
       
        
          
        
        $q1 = "UPDATE contrato SET  percent_atrasoEntrega='$percent_atrasoEntrega', percent_naoObjeto='$percent_naoObjeto', percent_descumprimento='$percent_descumprimento', limiteParcial='$limiteParcial',
               limiteTotal='$limiteTotal' WHERE id_contrato='$id_contrato'";                      
	$r1 = mysqli_query($conection, $q1) ;
  
        if($q1) {
                $_SESSION['msg42'] = "<p class='alert alert-secondary' style='color:green;'> Percentual atualizado com sucesso ! </p>";
                    header("Location: painelMultas.php?id=$id_contrato");
        }
        else{
                $_SESSION['msg42'] = "<p class='alert alert-danger' style='color:green;'> O percentual não foi atualizado </p>";
                         header("Location: painelMultas.php?id=$id_contrato");
        }
         }
