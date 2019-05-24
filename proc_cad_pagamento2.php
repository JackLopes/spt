<?php
 session_start();
 
        $page_title = 'Cadastrando Contrato';

        require_once 'database_gac.php';
        require_once 'Funcoes/func_data.php';
        require_once 'Funcoes/limpa_string.php';
        require_once 'Funcoes/valida_data1.php';
        require_once 'Funcoes/verifica_feriado.php';
       
         $id_tipo = filter_input(INPUT_POST, 'id_tipo', FILTER_SANITIZE_NUMBER_INT);
         $id_pag = filter_input(INPUT_POST, 'id_pag', FILTER_SANITIZE_NUMBER_INT);
     
         $parcela = filter_input(INPUT_POST, 'valor_parcela', FILTER_SANITIZE_STRING);
         $data_inicio_per= filter_input(INPUT_POST, 'data_inicio_per', FILTER_SANITIZE_STRING);
         $data_fim_per= filter_input(INPUT_POST, 'data_fim_per', FILTER_SANITIZE_STRING);
        
       
   /* $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
       var_dump($dados);*/
       
     if (isset($_POST['submitted'])){
        $erro = array();
        
     
        
         if (empty($parcela)){
	$erro[] = 'Digite o valor da parcela.';
	}else {$parcela = mysqli_real_escape_string($conection, trim($parcela));
	$parcela = floatval($parcela);}       
        
              
        // condição : data já formatada 
     
        if (empty($data_inicio_per)){
	$erro[] = 'Insira do Inicío do Periodo.';
	} 
        else { $data_inicio_per = mysqli_real_escape_string($conection, trim($data_inicio_per));}
        
        if (empty($data_fim_per)){
	$erro[] = 'Insira do Fim do Periodo.';
	} 
        else { $data_fim_per = mysqli_real_escape_string($conection, trim($data_fim_per));}
       
       
        
         if (empty($erro)) {
 
		   
        $q1 = "UPDATE pagamentos SET    valor_parcela='$parcela', data_inicio_per='$data_inicio_per', data_fim_per='$data_fim_per' WHERE id_pag='$id_pag'"; 
	$r1 = mysqli_query($conection, $q1);
        
        var_dump($r1);

        if($q1) {
                $_SESSION['msg28'] = "<p style='color:green;'> Registro atualizado com sucesso </p>";
                 header("Location: cad_pag.php?id_tipo=$id_tipo");
        }
        else{
                $_SESSION['msg28'] = "<p style='color:green;'> Registro não foi atualizado </p>";
                   header("Location: cad_pag.php?id_tipo=$id_tipo");
        }
          } else {
                  foreach ($erro as $mg){

                  $_SESSION['msg28'] = "<p style='color:red;'>$mg</p>";
                     header("Location: cad_pag.php?id_tipo=$id_tipo");

}}}
