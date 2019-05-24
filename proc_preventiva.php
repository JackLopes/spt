<?php
session_start();

$id_tipo = filter_input(INPUT_POST, 'id_tipo', FILTER_SANITIZE_NUMBER_INT);
$obs = filter_input(INPUT_POST, 'obs', FILTER_SANITIZE_STRING);

require_once 'database_gac.php';

if (isset($_POST['submitted'])){
    
$erro = array();

$query = "SELECT tip.* , loc.id_contrato, cont.tip_chamado, 
				cont.rg, loc.lugar_regional				
				FROM tipo AS tip
				INNER JOIN local AS loc ON  loc.id_local = tip.id_local
				INNER JOIN  contrato AS cont ON  cont.id_contrato = loc.id_contrato
				WHERE id_tipo = '$id_tipo'";
				
				$resultado = mysqli_query($conection,$query)or die ('Não foi possivel conectar ao MySQL');
				while ($registro = mysqli_fetch_array($resultado)) {
                                    
				$ct = $registro['id_contrato'];				
				$rg = $registro['rg'];
				$regional = $registro['lugar_regional'];
                                
                                }

  
        
	if (empty($_POST['d_limite'])){
        $erro[] = 'Digite o prazo final para execução, conforme cronograma';
	} else {
	$d_limite = mysqli_real_escape_string($conection, trim($_POST['d_limite']));          
         
        $ex = explode("-", $d_limite); 
        
        $numero_ano = $ex[0];       
        $numero_mes = $ex[1];       
        $numero_mes=(int)$numero_mes;  
        
       
        
       
        
       $mes = array('', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro','Novembro', 'Dezembro');
       $d_limite_mes= $mes[$numero_mes];
         
        }
       
         if (empty($erro)) {
             
        
        $status ='Pendente';
        

		   
        $q1 = "INSERT INTO preventivas ( id_tipo, item, patrimonio, n_chamado, mes, d_limite, data_conclusao, siscor, obs,
               previsao_multa, aplicacao_multa, id_contrato, regional, status, mes_ref,ano ) VALUES ('$id_tipo', '',
	'',' ','$d_limite_mes', '$d_limite','','','$obs', '', '', '$ct', '', '$status', '$numero_mes', '$numero_ano' )"; 
	$r1 = mysqli_query($conection, $q1);
      
        if($q1) {
                $_SESSION['msg8'] = "<p style='color:green;'> Registro cadastrado com sucesso </p>";
               header("Location: cad_preventiva.php?id_tipo=$id_tipo");
        }
        else{
                $_SESSION['msg8'] = "<p style='color:green;'> Registro cadastrado com sucesso </p>";
                 header("Location: cad_preventiva.php?id_tipo=$id_tipo");
        }
          } else {
                  foreach ($erro as $mg){

                  $_SESSION['msg8'] = "<p style='color:red;'>$mg</p>";
                header("Location: cad_preventiva.php?id_tipo=$id_tipo");

}}}?>

