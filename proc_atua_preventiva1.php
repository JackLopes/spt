<?php

session_start();

$page_title = 'Corretiva';
if (isset($_POST['id_tipo'])) {
    $id_tipo = (int) $_POST['id_tipo'];
}
if (isset($_POST['id_preventiva'])) {
    $id_preventiva = (int) $_POST['id_preventiva'];
}



require_once 'database_gac.php';

if (!empty($id_preventiva) ) {

    $aplicacao_multa = ($_POST['aplicacao_multa']);

    

           
	$q1 = "UPDATE preventivas SET  
            aplicacao_multa='$aplicacao_multa', criado='NOW()' WHERE id_preventiva='$id_preventiva'"; 
        
  
		
	$r1 = mysqli_query($conection, $q1); 

        if ($q1) {
            
            $_SESSION['msg39'] = "<p style='color:green;'> Registro atualizado com sucesso </p>";
            header("Location: cad_preventiva.php?id_tipo=$id_tipo");
        } else {
            
            $_SESSION['msg39'] = "<p style='color:red;'> Registro não foi atualizado </p>";
             header("Location: cad_preventiva.php?id_tipo=$id_tipo");
        }
        } 
    




