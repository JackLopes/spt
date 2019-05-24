
<?php

	session_start();

       
        $id = filter_input(INPUT_POST, 'id_contrato', FILTER_SANITIZE_NUMBER_INT);
        $idp = filter_input(INPUT_POST, 'id_prestador', FILTER_SANITIZE_NUMBER_INT);
        
        

       

if( !empty($idp) and !empty($id)){




  $permissa = $_SESSION['permissao'];    

require_once 'database_gac.php';
	 if ( $permissa < '4') {   

	if (isset($_POST['submitted'])){		
		
	$erro = array();
	
	$q1 = "SELECT * FROM prestador WHERE id_prestador = '$idp'";
	$r1 = mysqli_query($conection, $q1);
	while($row = mysqli_fetch_assoc($r1)) { 
	
	$lur = $row['nome'];
	$cnp = $row['cnpj'];
	$end = $row['endereco'];			
	$mnemonico = $row['mnemonico'];	
        $id_prestador = $row['id_prestador'];
	
	} 

		
        if (empty($erro)) {	            
            
        $query = "SELECT * FROM local WHERE  cnpj = '$cnp' AND Id_contrato =  '$id'   "; 
	$resp = mysqli_query($conection, $query);
        $num = mysqli_num_rows ($resp);    
       
	if ($num == 0) {

        $q = "INSERT INTO local (id_contrato, lugar_regional, endereco, cnpj, sigla,id_prestador  ) VALUES ('$id',  '$lur', '$end','$cnp', '$mnemonico', '$id_prestador'  )"; 
        $r = mysqli_query($conection, $q);

        if(mysqli_insert_id($conection)){
	
            $_SESSION['msg23'] = "<p style='color:green;'> Regional  cadastrada com sucesso </p>";
		
	    header("Location:idex.php?id=$id");
        
}else{
	$_SESSION['msg23'] = "<p style='color:red;'>Não foi possivel efetuar o cadastrado da Regional </p>";
	
           header("Location:idex.php?id=$id");
}
} else {
	
	$_SESSION['msg23'] = "<p style='color:red;'>Regional já cadastrada</p>";
	
          header("Location:idex.php?id=$id");
	
}
      
    }
         }} else {
            
             $_SESSION['msg23'] = "<p style='color:red;'> Você não tem permissão para cadastrar registro</p>";
         header("Location:idex.php?id=$id");
       
         }
}else{
     $_SESSION['msg23'] = "<p style='color:red;'>Algo deu errado !!! Entre em contato com o desenvolvedor </p>";
         header("Location:idex.php?id=$id");
}        