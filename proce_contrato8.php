<?php
 session_start();
 
 $permissa = $_SESSION['permissao'];
 
        $page_title = 'Cadastrando Contrato';
        require_once 'database_gac.php';
        require_once 'Funcoes/func_data.php';
        require_once 'Funcoes/limpa_string.php';
        require_once 'Funcoes/valida_data.php';

         $id_prestador = filter_input(INPUT_POST, 'id_prestador', FILTER_SANITIZE_NUMBER_INT);
         $id_user = filter_input(INPUT_POST, 'id_usuario', FILTER_SANITIZE_NUMBER_INT);
         $rg = filter_input(INPUT_POST, 'rg', FILTER_SANITIZE_STRING);
         //$d_Registro= filter_input(INPUT_POST, 'd_Registro', FILTER_SANITIZE_STRING);
         $projeto_basico= filter_input(INPUT_POST, 'projeto_basico', FILTER_SANITIZE_STRING);
         //$d_emissao= filter_input(INPUT_POST, 'd_emissao', FILTER_SANITIZE_STRING);
         $n_processo= filter_input(INPUT_POST, 'n_processo', FILTER_SANITIZE_STRING);
         //$d_Assinatura= filter_input(INPUT_POST, 'd_Assinatura', FILTER_SANITIZE_STRING);
         $status= filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
         //$d_Inic_vige_contr= filter_input(INPUT_POST, 'rg', FILTER_SANITIZE_STRING);
         //$d_fim_vige_cont= filter_input(INPUT_POST, 'rg', FILTER_SANITIZE_STRING);
         $pos_prorrogacao= filter_input(INPUT_POST, 'pos_prorrogacao', FILTER_SANITIZE_STRING);
         $periodo_prorrogacao= filter_input(INPUT_POST, 'periodo_prorrogacao', FILTER_SANITIZE_NUMBER_INT);
         $vig_garantia= filter_input(INPUT_POST, 'vig_garantia', FILTER_SANITIZE_NUMBER_INT);
         //$obs= filter_input(INPUT_POST, 'rg', FILTER_SANITIZE_STRING);
         $valor_contratado= filter_input(INPUT_POST, 'valor_Contratado', FILTER_SANITIZE_STRING);
         //$d_prorro= filter_input(INPUT_POST, 'rg', FILTER_SANITIZE_STRING);
         //$d_Aceite= filter_input(INPUT_POST, 'rg', FILTER_SANITIZE_STRING);
         $n_siscor= filter_input(INPUT_POST, 'n_siscor', FILTER_SANITIZE_STRING);
         $objeto= filter_input(INPUT_POST, 'objeto', FILTER_SANITIZE_STRING);
         $tipo= filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_STRING);
         $prazo_entrega= filter_input(INPUT_POST, 'prazo_entrega', FILTER_SANITIZE_STRING);
         //$d_recebimento;
         $vig_contrat= filter_input(INPUT_POST, 'vig_contrat', FILTER_SANITIZE_NUMBER_INT);
         //$d_fim_g;
         $link_pv= filter_input(INPUT_POST, 'link_pv', FILTER_SANITIZE_URL);
         $link_ged= filter_input(INPUT_POST, 'link_ged', FILTER_SANITIZE_URL);
         $link_proscorm= filter_input(INPUT_POST, 'link_proscorm', FILTER_SANITIZE_URL);
         //$agora= filter_input(INPUT_POST, 'rg', FILTER_SANITIZE_URL);
         $natureza= filter_input(INPUT_POST, 'natureza', FILTER_SANITIZE_STRING);
         $tip_chamado= filter_input(INPUT_POST, 'tip_chamado', FILTER_SANITIZE_NUMBER_INT);
         $fim_vig_garat;
         $mine= filter_input(INPUT_POST, 'mine', FILTER_SANITIZE_STRING);
         
      
         
       if ( $permissa < '4') {   
         
         if (isset($_POST['submitted'])){
        $erro = array();
        
         
             
          
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        $_SESSION['dados']=$dados ;

        if (empty($id_prestador)) {
	$erro[] = 'Selecionar o prestador de serviço';
	} else if (is_numeric($id_prestador)){	
	$id_prestador = mysqli_real_escape_string($conection, trim($id_prestador));
	} else { $erro[]='Selecione o prestador de serviço ';}
	
	if (empty($rg)){
	$erro[] = 'Informar o RG do Contrato.';
	}else if (strlen($rg) < 5){	
	$erro[] =  "Preencha o RG com no mínimo 5 caracteres.";
	} else {
	$rg = mysqli_real_escape_string($conection, trim($rg));}
        
        if (empty($projeto_basico)){
	$erro[] = 'Informar o Projeto Básico.';
	}else if (strlen($projeto_basico) < 4){	
	$erro[] =  "Preencha o Projeto Básico  com no mínimo 4 caracteres.";
	} else {
	$projeto_basico = mysqli_real_escape_string($conection, trim($projeto_basico));}
	
        if (empty($n_processo)){
	$erro[] = 'Insira o número do Processo.';
	}else if (strlen($n_processo) < 4){	
	$erro[] =  "Preencha o número do processo   com no mínimo 4 caracteres.";
	} else {
	$n_processo = mysqli_real_escape_string($conection, trim($n_processo));}
       
          if (empty($_POST['d_Assinatura'])){
	$erro[] = 'Insira Data Assinatura.';
	} else {
	$d_Assinatura = mysqli_real_escape_string($conection, trim($_POST['d_Assinatura']));}
        $d_Assinatura = str_replace("/", "-", $d_Assinatura);	
        
        if (empty($status)){
	$erro[] = 'Defina o Status do Contrato.';
	} else {
	$status = mysqli_real_escape_string($conection, trim($status));} 
        
        if (empty($vig_contrat)){
	$erro[] = 'Insira o periodo da Vigencia.';
	} else {
	$vig_contrat = mysqli_real_escape_string($conection, trim($vig_contrat));}         
        
        if (empty($_POST['d_Inic_vige_contr'])){
	$erro[] = 'Insira Data Inicio da Vigencia.';
	} else {
	$d_Inic_vige_contr = mysqli_real_escape_string($conection, trim($_POST['d_Inic_vige_contr']));
        $d_Inic_vige_contr = str_replace("/", "-", $d_Inic_vige_contr);	
        
        $d = ' 1';

        $d_Inic_vige_contr  = inverteData($d_Inic_vige_contr );	
        $termino_vig = SomarData( $d_Inic_vige_contr , 0, $vig_contrat, 0);	
        $d_fim_vige_cont = SubData(  $termino_vig, $d, 0, 0);	

        } 
       
            if (empty($_POST['pos_prorrogacao'])){
            $erro[] = 'Informe se há possibilidade Prorrogação.';
            }else {
            $pos_prorrogacao = mysqli_real_escape_string($conection, trim($_POST['pos_prorrogacao']));

            if ($pos_prorrogacao == 'NÃO'){

                    $d_prorro = 0;

                    if (!empty($periodo_prorrogacao)){
            //$erro[] = 'Não há previsão de prorrogação para este contrato.';
            unset($periodo_prorrogacao);
                    }
                       }else 	if ($pos_prorrogacao == 'SIM'){

                    if(empty($periodo_prorrogacao)){
            $erro[] = 'Insira Periodo da Prorrogação.';
            } else {
                    $d = ' 1';
                    
                 $termino_pro = SomarData( $d_Inic_vige_contr, 0, $periodo_prorrogacao , 0);	
                 $d_prorro = SubData(  $termino_pro, $d, 0, 0);
                     }
              }
        }
        
          if (empty($tipo)){
	$erro[] = 'Selecione Aquisição ou Serviço.';
	} else {
	$tipo = mysqli_real_escape_string($conection, trim($tipo));
                
	if ( $tipo === 'SERVIÇOS' ) {			
	if (!empty($prazo_entrega)){
	//$erro[] = 'Não há  prazo de entrega  para contratos de Serviços';
        unset($prazo_entrega);
	}
		}			
	 else if ($tipo ==='AQUISIÇÃO' ) {	
	if (empty($prazo_entrega)){
	$erro[] = 'Insira Data da Entrega.';
        }else{ $prazo_entrega = mysqli_real_escape_string($conection, trim($prazo_entrega));}
 	} 		
	 else if ($tipo ==='SOLUÇÃO' ){	
	if (empty($prazo_entrega)){
	$erro[] = 'Insira Data da Entrega.';        
        }else{ $prazo_entrega = mysqli_real_escape_string($conection, trim($prazo_entrega));}
        	}
        }
               
               
        if (empty($tipo)){
	$erro[] = 'Selecione Aquisição , Serviço ou Solução.';
	} else {
	$tipo = mysqli_real_escape_string($conection, trim($tipo));	
	if ( $tipo == 'SERVIÇOS' ) {		
		if (!empty($vig_garantia)){
	//$erro[] = 'Não há  Vigencia Garantia para contratos de Serviços';
                     unset($vig_garantia);
		}
	}
	 else if ( $tipo == 'AQUISIÇÃO' ) {		
		
	if (empty($vig_garantia)){
	$erro[] = 'Insira Vigencia Garantia.';
	} else  {
	$vig_garantia = mysqli_real_escape_string($conection, trim($vig_garantia));}
	 }
	 else if ( $tipo == 'SOLUÇÃO' ){
	if (empty($vig_garantia)){
	$erro[] = 'Insira Vigencia Garantia.';
	}else  {
	$vig_garantia = mysqli_real_escape_string($conection, trim($vig_garantia));}
            }	
          } 
          
        if (empty($valor_contratado)){
	$erro[] = 'Digite o Valor Contratado.';
	}else if (is_numeric($valor_contratado)){	
	$valor_contratado1 = mysqli_real_escape_string($conection, trim($valor_contratado));
	$valor_contratado = $valor_contratado1;}
        
        if (empty($n_siscor)){
	$erro[] = 'Insira o SISCOR de Iniciação.';
	}else if (strlen($n_siscor) < 8){	
	$erro[] =  "Preencha o SISCOR com no mínimo 8 caracteres.";}
	else {
	$n_siscor = mysqli_real_escape_string($conection, trim($n_siscor));}
           
        if (empty($objeto)){
	$erro[] = 'Informar o Objeto do Contrato.';
	}else if (strlen($objeto) < 5){	
	$erro[] =  "Preencha o Objeto com no mínimo 5 caracteres.";
	} else if (is_string($objeto)){	
	$objeto1 = mysqli_real_escape_string($conection, trim($objeto));
        $objeto=limpa($objeto1);}
        
        
        if (empty($link_pv)){
	$erro[] = 'Insira o link processo verde.';
	} else {
	$link_pv = mysqli_real_escape_string($conection, trim($link_pv));} 
        
        
	if (empty($link_ged)){
	$erro[] = 'Selecione linke Gedig.';
	} else {
	$link_ged = mysqli_real_escape_string($conection, trim($link_ged));}	
        
        $link_proscorm = mysqli_real_escape_string($conection, trim($_POST['link_proscorm']));
       

        if (empty($_POST['vig_contrat'])){
	$erro[] = 'Insira Vigência Contratual.';
	} else {
	$vigc = mysqli_real_escape_string($conection, trim($_POST['vig_contrat']));}
	
	
			
	if (empty($natureza)){
	$erro[] = 'Insira Area Gestora.';
	} else {
	$natureza = mysqli_real_escape_string($conection, trim($natureza));} 
	
	if (empty($tip_chamado)){
	$erro[] = 'Selecione o tipo de Chamado. Informação referente aos atendimentos e soluções especificadas nos niveis de severidade do respectivo controtao';
	} else {
	$tip_chamado  = mysqli_real_escape_string($conection, trim($tip_chamado));}
	
        $id_prestador = (int)$id_prestador;
        $d_Inic_vige_contr = inverteData($d_Inic_vige_contr);
        $d_fim_vige_cont = inverteData($d_fim_vige_cont);
        $d_prorro = inverteData($d_prorro);
	      
	if (empty($erro)) {	 
    
	$q = "SELECT rg FROM contrato WHERE rg = '$rg'"; 
	$r = mysqli_query($conection, $q);
        $num = mysqli_num_rows ($r);

	if ($num  == 0) {	 
    
          
     
	$q1 = "INSERT INTO contrato 
             (id_contrato, id_prestador, rg, d_Registro, projeto_basico, d_emissao, n_processo, d_Assinatura, status, d_Inic_vige_contr, 
            d_fim_vige_cont, pos_prorrogacao, vig_garantia, obs, valor_Contratado, d_prorro, d_Aceite, n_siscor, objeto, tipo, prazo_entrega, d_recebimento, 
             vig_contrat, d_fim_g, link_pv, link_ged, link_proscorm, agora, natureza, tip_chamado, fim_vig_garat, mine) 
	    VALUES 
	    ('','$id_prestador','$rg','','$projeto_basico','','$n_processo','$d_Assinatura','$status','$d_Inic_vige_contr','$d_fim_vige_cont',
                '$pos_prorrogacao','$vig_garantia','','$valor_contratado','$d_prorro','', '$n_siscor', '$objeto','$tipo','$prazo_entrega','',
                '$vig_contrat','','$link_pv', '$link_ged', '$link_proscorm','', '$natureza', '$tip_chamado','','$mine')";	
        
        $r1 = mysqli_query($conection, $q1)  or die (mysqli_error($conection));
        
        
	
	if(mysqli_insert_id($conection)){
            
     
    
         
//Direcionar para o respectivo contrato criado
       			
                $sqlcontrato = "SELECT * FROM contrato WHERE rg = '$rg'";
                $resultado = mysqli_query($conection,$sqlcontrato)or die ('Não foi possivel conectar ao MySQL');
                while ($registro = mysqli_fetch_array($resultado))
                { $id = $registro['id_contrato'];}
                
 //atribuir fiscal         
      if(!empty($id_user))  {    
        $query_user = "SELECT * FROM usuario WHERE id_usuario= '$id_user'";
        $resultado_user = mysqli_query($conection, $query_user);
        while ($row = mysqli_fetch_assoc($resultado_user)) {

            $nom = $row['nome'];
            $lot = $row['lotacao'];
            $fun = $row['funcao'];
            $email = $row['email'];
            $matricula = $row['matricula'];
            $tel = $row['telefone'];
            
              
        }
      
      
        $id_local= null;
        $resp = 'Fiscal Administrativo';
        
        
         $query = "INSERT INTO responsaveis (nome, area, funcao, email, matricula, telefone, id_local, responsabilidade, id_contrato )
                                     VALUES ('$nom', '$lot','$fun', '$email','$matricula','$tel','$id_local','$resp','$id' )"; 
          $r1 = mysqli_query($conection, $query)  or die (mysqli_error($conection));
               
        }
         
     
	
             $_SESSION['msg31'] = "<p style='color:green;'> Contrato cadastrado com sucesso ! </p>";
        header("Location:idex.php?id=$id");
       
         } else{ $_SESSION['msg31'] = "<p style='color:red;'> Há algum erro, o contrato não foi cadastrado!</p>";
       header("Location:contrato.php");
        }}else { 
            $_SESSION['msg31'] = "<p style='color:green;'> Este contrato já foi cadastrado</p>";
        header("Location:contrato.php");
              } 
        }else{	
	
          foreach ($erro as $mg)   
	  $_SESSION['msg31'] = "<div class='alert alert-danger' role='alert'> $mg <br>\n</div>";       
        header("Location:contrato.php");
       }}}
       else {
            
             $_SESSION['msg31'] = "<p style='color:red;'> Você não tem permissão para cadastrar registro</p>";
       header("Location:contrato.php");
       
       }
  
