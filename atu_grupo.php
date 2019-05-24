
session_start();

<?php
	require_once 'database_gac.php';

	if(!empty($_POST['prazo_entrega'])){	

	$rec_definitivo= $_POST['rec_definitivo'];
	$id= $_POST['id'];
	
	
	
    $q = "UPDATE local SET   rec_definitivo='$rec_definitivo' WHERE id_local='$id' "; 
	$r = mysqli_query($conection, $q);
    
	
	if($r ){
			$_SESSION['msg89'] = "<p style='color:green;'>Atualização efetuada  com sucesso </p>";
			header("Location: inf_local2.php?id=$id");
		}
	 else{
			$_SESSION['msg89'] =  $_SESSION['voce']. "<p style='color:red;'> Falha ao tentar atualizar registro</p>";
			header("Location: inf_local2.php?id=$id");
	} 
	
	}else {$_SESSION['msg89']. "<p style='color:red;'> Necessário Atualizar Registro</p>";
	header("Location: inf_local2.php?id=$id");}
			
			
	
	

   