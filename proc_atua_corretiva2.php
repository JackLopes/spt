<?php

session_start();

$page_title = 'Corretiva';
if (isset($_POST['id_tipo'])) {
    $id_tipo = (int) $_POST['id_tipo'];
}
if (isset($_POST['id_corretiva'])) {
    $id_corretiva = (int) $_POST['id_corretiva'];
}

require_once 'database_gac.php';

if (!empty($id_corretiva) ) {

  
        $q2 = "SELECT * FROM corretivas WHERE id_corretiva = '$id_corretiva' ";
        $r2 = mysqli_query($conection, $q2)or die('Não foi possivel conectar ao MySQL');
        while ($row = mysqli_fetch_assoc($r2)) {

            $atendimento_onsite = $row['atendimento_onsite'];
          
        }

        
       if($atendimento_onsite == 'Sim'){ 
        
    $data_atend_onsite = ($_POST['data_atend_onsite']);
    $hora_atendimento_onsite = ($_POST['hora_atendimento_onsite']);

    

           
	$q1 = "UPDATE corretivas SET  
            data_atend_onsite='$data_atend_onsite', hora_atendimento_onsite='$hora_atendimento_onsite',  criado='NOW()' WHERE id_corretiva='$id_corretiva'"; 
        
  
		
	$r1 = mysqli_query($conection, $q1); 

        if ($q1) {
            
            $_SESSION['msg38'] = "<p style='color:green;'> Registro atualizado com sucesso </p>";
            header("Location: cad_corretiva.php?id_tipo=$id_tipo");
        } else {
            
            $_SESSION['msg38'] = "<p style='color:red;'> Registro não foi atualizado </p>";
            header("Location: cad_corretiva.php?id_tipo=$id_tipo");
        }
        } else {
       

            $_SESSION['msg38'] = "<p style='color:red;'> Só é possivel registrar casos com necessidade de atendimento on-site </p>";
            header("Location: cad_corretiva.php?id_tipo=$id_tipo");
        }
    }




