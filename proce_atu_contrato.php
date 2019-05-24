<?php

 session_start();
 
 $permissa = $_SESSION['permissao'];
 
$page_title = 'Bem vindo ao Site';
include 'gac_cabeça.php';
require_once 'Funcoes/limpa_string.php';



 $mine =filter_input(INPUT_POST, 'mine', FILTER_SANITIZE_STRING);
 $id_contrato= filter_input(INPUT_POST, 'id_contrato', FILTER_SANITIZE_NUMBER_INT);
 $rg = filter_input(INPUT_POST, 'rg', FILTER_SANITIZE_STRING);
 $status =filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
 $id_prestador= filter_input(INPUT_POST, 'id_prestador', FILTER_SANITIZE_NUMBER_INT);
 $val_contratado = filter_input(INPUT_POST, 'valor_Contratado', FILTER_SANITIZE_STRING);
 $objeto = filter_input(INPUT_POST, 'objeto', FILTER_SANITIZE_STRING);
 $siscor = filter_input(INPUT_POST, 'n_siscor', FILTER_SANITIZE_STRING);
 $projeto_bassico = filter_input(INPUT_POST, 'projeto_basico', FILTER_SANITIZE_STRING);
 $n_processo = filter_input(INPUT_POST, 'n_processo', FILTER_SANITIZE_STRING);
 $vig_garantia= filter_input(INPUT_POST, 'vig_garantia', FILTER_SANITIZE_NUMBER_INT);
 $natureza = filter_input(INPUT_POST, 'natureza', FILTER_SANITIZE_STRING);
 $met_calculo = filter_input(INPUT_POST, 'tip_chamado', FILTER_SANITIZE_NUMBER_INT);
 $pos_prorrogacao =filter_input(INPUT_POST, 'pos_prorrogacao', FILTER_SANITIZE_STRING);
 $d_prorr = filter_input(INPUT_POST, 'd_prorro', FILTER_SANITIZE_NUMBER_INT);
 $link_pv =filter_input(INPUT_POST, 'link_pv', FILTER_SANITIZE_URL);
 $link_ged =filter_input(INPUT_POST, 'link_ged', FILTER_SANITIZE_URL);
 $link_proscorm =filter_input(INPUT_POST, 'link_proscorm', FILTER_SANITIZE_URL);

 
 
 if (isset($objeto)){
     
 $objeto = limpa($objeto);}
 
/* $vari= array($id_contrato,$rg ,$status,$id_prestador,$val_contratado ,$objeto,$siscor,$projeto_bassico ,$n_processo ,$vig_garantia,
        $natureza,$met_calculo,$pos_prorrogacao,$d_prorr ,$link_pv, $link_ged ,$link_proscorm );
 
    var_dump($vari)*/
 
 
 
 
require_once 'database_gac.php';

if ( $permissa < '4') {  

if (isset($_POST['submitted'])){	
	
$erro = array();
	
	if (empty($id_prestador)) {
	$erro[] = 'Preencher o prestador de serviço';
	} else if (is_numeric($id_prestador)){	
	$forn = mysqli_real_escape_string($conection, trim($id_prestador));
	} else { $erro[]='Digite novamente o fornecedor ';}
	
	if (empty($rg )){
	$erro[] = 'Informar o RG do Contrato.';
	} else {
	$rg = mysqli_real_escape_string($conection, trim($rg ));}
	
	if (empty($objeto)){
	$erro[] = 'Informar o Objeto do Contrato.';
	} else {
	$obj = mysqli_real_escape_string($conection, trim($objeto));	
	;}
	
	if (empty($val_contratado)){
	$erro[] = 'Digite o Valor Contratado.';
	} else {
	$vct = floatval($val_contratado);}
	
	if (empty($_POST['d_Assinatura'])){
	$erro[] = 'Insira Data Assinatura.';
	} else {
	$dass = mysqli_real_escape_string($conection, trim($_POST['d_Assinatura']));}
    $dass = str_replace("/", "-", $_POST["d_Assinatura"]);
    
	
	if (empty($siscor)){
	$erro[] = 'Insira o SISCOR de Iniciação.';
	} else {
	$sisc = mysqli_real_escape_string($conection, trim($siscor));}
	

	
	
	if (empty($projeto_bassico)){
	$erro[] = 'Informar o Projeto Básico.';
	} else {
	$pba = mysqli_real_escape_string($conection, trim($projeto_bassico));}
		
	if (empty($n_processo)){
	$erro[] = 'Insira o numero do Processo.';
	} else {
	$proc = mysqli_real_escape_string($conection, trim($n_processo));}	
	
	if (empty($status)){
	$erro[] = 'Defina o Status do Contrato.';
	} else {
	$sta = mysqli_real_escape_string($conection, trim($status));}
	
	
	
	if (empty($pos_prorrogacao)){
	$erro[] = 'Possibilidade Data Prorrogação.';
	} else {
	$popor = mysqli_real_escape_string($conection, trim($pos_prorrogacao));}
	
	
	
	
	$dpor = ($_POST['d_prorro']);
	$dentrega = ($_POST['prazo_entrega']);
	
	
	
	
	/*
	
	
	if (empty($_POST['vig_garantia'])){
	$erro[] = 'Insira Vigencia Garantia.';
	} else {
	$vigg = mysqli_real_escape_string($conection, trim($_POST['vig_garantia']));}
	
	
	
       */
	   
	   	
	if (empty($_POST['tipo'])){
	$erro[] = 'Selecione Aquisição ou Serviço.';
	} else {
	$tip = mysqli_real_escape_string($conection, trim($_POST['tipo']));	
		if ( $tip == 'SERVIÇOS' ) {
		
		if (!empty($_POST['vig_garantia'])){
	$erro[] = 'Não há  Vigencia Garantia para contratos de Serviços';
		} else { 
			$vigg= " Não se aplica";
		}
		
	} else if ( $tip == 'AQUISIÇÃO' ) {			
	if (empty($_POST['vig_garantia'])){
	$erro[] = 'Insira Vigencia Garantia.';
	}else{
	$vigg = mysqli_real_escape_string($conection, trim($_POST['vig_garantia']));}
	 }  else if ( $tip == 'SOLUÇÃO' ){			
	if (empty($_POST['vig_garantia'])){
	$erro[] = 'Insira Vigencia Garantia.';
	}else{
	$vigg = mysqli_real_escape_string($conection, trim($_POST['vig_garantia']));}		
            }	
	}
	 
		
	if (empty($_POST['vig_contrat'])){
	$erro[] = 'Insira Vigência Contratual.';
	} else {
	$vigc = mysqli_real_escape_string($conection, trim($_POST['vig_contrat']));}
	
	if (empty($_POST['d_Inic_vige_contr'])){
	$erro[] = 'Insira Data Inicio Vigência Contratual.';
	} else {
	$ivc = mysqli_real_escape_string($conection, trim($_POST['d_Inic_vige_contr']));}
	$ivc = str_replace("/", "-", $_POST["d_Inic_vige_contr"]);
	
	
	if (empty($_POST['d_fim_vige_cont'])){
	$erro[] = 'Insira Data Fim Vigência Contratual.';
	} else {
	$fvc = mysqli_real_escape_string($conection, trim($_POST['d_fim_vige_cont']));
    $fvc = str_replace("/", "-", $_POST["d_fim_vige_cont"]);
	
	}

	if (empty($link_pv)){
	$erro[] = 'Insira Data Final da  Garantia.';
	} else {
	$lpv = mysqli_real_escape_string($conection, trim($link_pv));} 	
	
	if (empty($link_pv)){
	$erro[] = 'Selecione linke Gedig.';
	} else {
	$lge = mysqli_real_escape_string($conection, trim($link_pv));}
	
	
	$lpco = mysqli_real_escape_string($conection, trim($link_proscorm));	
	
	
	if (empty($natureza)){
	$erro[] = 'Insira Area Gestora.';
	} else {
	$nat = mysqli_real_escape_string($conection, trim($natureza));} 
	
	if (empty($met_calculo)){
	$erro[] = 'Selecione o tipo de Chamado. Informação referente aos atendimentos e soluções especificadas nos niveis de severidade do respectivo controtao';
	} else {
	$tipch  = mysqli_real_escape_string($conection, trim($met_calculo));}
        
	if (empty($mine)){
	$erro[] = 'Insira o mneumônico';
	} else {
	$mine = mysqli_real_escape_string($conection, trim($mine));} 

	      
	 if (empty($erro)) {	
                     
             
    
	$q1 = "UPDATE contrato SET  id_prestador='$forn', rg='$rg', projeto_basico='$pba',n_processo='$proc',d_Assinatura='$dass',
            status='$sta', d_Inic_vige_contr='$ivc',d_fim_vige_cont='$fvc', pos_prorrogacao='$popor', vig_garantia='$vigg ',  valor_contratado='$vct', d_prorro='$dpor' , 
            n_siscor='$sisc', objeto='$obj',  tipo='$tip', prazo_entrega='$dentrega', vig_contrat='$vigc', link_pv='$lpv', link_ged='$lge', link_proscorm='$lpco', agora='NOW()', natureza='$nat',
            tip_chamado='$tipch' , mine ='$mine' WHERE id_contrato='$id_contrato'"; 
	

	
		
	$r1 = mysqli_query($conection, $q1); 
    
	
	
      if($q1) {
                $_SESSION['msg12'] = "<p style='color:green;'> Registro atualizado com sucesso </p>";
                header("Location: atu_contrato.php?id_contrato=$id_contrato");
        }
        else{
                $_SESSION['msg12'] = "<p style='color:green;'> Registro não foi atualizado </p>";
                    header("Location: atu_contrato.php?id_contrato=$id_contrato");
        }
          } else {
                  foreach ($erro as $mg){

                  $_SESSION['msg12'] = "<p style='color:red;'>$mg</p>";
                    header("Location: atu_contrato.php?id_contrato=$id_contrato");

}}}}
       else {
            
             $_SESSION['msg12'] = "<p style='color:red;'> Você não tem permissão para cadastrar registro</p>";
                   header("Location: atu_contrato.php?id_contrato=$id_contrato");
       
       }


	 

        