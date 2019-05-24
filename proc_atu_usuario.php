<?php
session_start();
require_once 'database_gac.php';
require_once 'Funcoes/limpa_string.php';
 
        $id_usuario=filter_input(INPUT_GET, 'id_usuario', FILTER_SANITIZE_NUMBER_INT);
        $matricula =filter_input(INPUT_POST, 'matricula', FILTER_SANITIZE_STRING);
	$nom =filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
        $email =filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
        $fun1 =filter_input(INPUT_POST, 'funcao', FILTER_SANITIZE_STRING);
        $tel=filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_NUMBER_INT);
        $celular=filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_NUMBER_INT);
        $lot =filter_input(INPUT_POST, 'lotacao', FILTER_SANITIZE_STRING);
        $empresa=filter_input(INPUT_POST, 'empresa', FILTER_SANITIZE_NUMBER_INT);
     
   

if (isset($_POST['submitted'])){
       
    $erro = array();   
    
       
        
	if (empty($empresa)){
	$erro[] = 'Informar se a pessoa e do SERPRO ou não';
        } 
			
        
	if (empty($nom)){            
	$erro[] = 'Digite o nome.';
	} else if (strlen($nom) < 8){	
	$erro[] =  "Preencha o nome com no mínimo 8 caracteres.";
	}else {
	$nom = limpa(mysqli_real_escape_string($conection, trim($nom)));}
        
	if (empty($email)){
	$erro[] = 'Informar o email.';
        } else { $email= filter_var($email , FILTER_VALIDATE_EMAIL);}
			
	
	if (!empty($fun)){	
	$fun = limpa(mysqli_real_escape_string($conection, trim($fun)));}	
        else {$fun= " Não Informados";}	
			
	if (empty($tel)) {
	$erro[] = 'Informar o telefone.';}
	else if (preg_match('/^\([0-9]{2}\)?\s?[0-9]{4,5}-[0-9]{4}$/', $tel)){   
		$erro[] = 'Digite um número  de telefone válido.';} 	
	
	if (empty($celular)) {
	$celular = 'Não Informado.';}
	else if (preg_match('/^\([0-9]{2}\)?\s?[0-9]{4,5}-[0-9]{4}$/', $celular)){   
        $erro[] = 'Digite um número  de celular  válido.';}
		
	if ($empresa == 1 ){
	if (empty($lot)){
	$erro[] = 'Informar o lotacao.';
	} else if(!is_string ($lot)) {
	 $erro[] = 'Preencha corretamente por favor!!!.';
	} else if(strlen($lot) > 25){	
        $erro[] = "Preencha a lotação  com no maximo 25 caracteres.";}	
        
        if (empty($matricula)){
	$erro[] = 'Digite a matricula.';
	} else if (strlen($matricula) < 8){	
	$erro[] =  "Preencha a matricula  com no mínimo 8 caracteres.";
	}else {
	$matricula= mysqli_real_escape_string($conection, trim($matricula));}
        } else {
            
         $lot = "Não se aplica"; 
         
         $matricula = "Não se aplica";
        }
      
        $fun= limpa($fun1);
        $nom= limpa($nom);
                
        if (empty($erro)) {     
          
        
        $q1 = "UPDATE usuario SET  nome='$nom', lotacao='$lot', funcao='$fun', email='$email',
               telefone='$tel', celular='$celular', matricula='$matricula', empresa='$empresa' WHERE id_usuario='$id_usuario'";                      
	$r1 = mysqli_query($conection, $q1) ;
  
        if($q1) {
                $_SESSION['msg40'] = "<p class='alert alert-secondary' style='color:green;'> Colaborador atualizado com sucesso </p>";
                    header("Location: atu_usuario.php?id_usuario=$id_usuario");
        }
        else{
                $_SESSION['msg40'] = "<p class='alert alert-danger' style='color:green;'> O colaborador não foi atualizado </p>";
                         header("Location: atu_usuario.php?id_usuario=$id_usuario");
        }
          } else {
                  foreach ($erro as $mg){

                  $_SESSION['msg40'] = "<p class='alert alert-danger' style='color:red;'>$mg</p>";
                     header("Location: atu_usuario.php?id_usuario=$id_usuario");

}}}
