
<?php

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}



require_once 'database_gac.php';
require_once ('./inc/Config.inc.php');
require_once './Funcoes/func_data.php';
require_once './Funcoes/mascara_php.php';
require_once './Funcoes/extenso.php';


//$conection = mysqli_connect('localhost', 'root');
//mysqli_select_db($conection, 'gac');

$id_contrato = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$id_histmulta = filter_input(INPUT_GET, 'id_histmulta', FILTER_SANITIZE_NUMBER_INT);
$id_tipo = filter_input(INPUT_GET, 'id_tipo', FILTER_SANITIZE_NUMBER_INT);

$sql = "SELECT * FROM contrato WHERE  id_contrato = '$id' ";
$resultado = mysqli_query($conection, $sql)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado)) {

    $percent_atrasoEntrega = $registro['percent_atrasoEntrega'];

    $percent_naoObjeto = $registro['percent_naoObjeto'];
    $percent_descumprimento = $registro['percent_descumprimento'];
    $rg = $registro['rg'];
    $vig_garantia = $registro['vig_garantia'];
    $valor_atual1 = $registro['valor_atual'];
    $valor_atual = number_format($valor_atual1, 2, ',', '.');
    $valor_extenso = extenso($registro['valor_atual']);
    $limiteParcial = $registro['limiteParcial'];
    $limiteTotal = $registro['limiteTotal'];

    $id_prestador = $registro['id_prestador'];
    $objeto = $registro['objeto'];
    $d_Assinatura = inverteData($registro['d_Assinatura']);
    $prazo_entrega = inverteData($registro['prazo_entrega']);
}









$sqlcontrato = "SELECT * FROM contrato WHERE id_contrato = $id";
$resultado = mysqli_query($conection, $sqlcontrato)or die('Não foi possivel conectar ao MySQL');
while ($registro2 = mysqli_fetch_array($resultado)) {

    $n_processo = $registro2['n_processo'];
    $for = $registro2['id_prestador'];

    $sql3 = "SELECT * FROM prestador WHERE id_prestador = $for";
    $resultado1 = mysqli_query($conection, $sql3)or die('Não foi possivel conectar ao MySQL');
    while ($registro1 = mysqli_fetch_array($resultado1)) {

        $cnpj = $registro1['cnpj'];
        $nome_prestador = $registro1['nome'];
    }
}





include('pdf/mpdf.php');



$mpdf = new mPDF('utf-8', 'A4-P');
$mpdf->SetDisplayMode('fullpage');



$pagina = "

$passo = 100px;

<style>
    h3 {color: black; }
    h5 {color: red; margin-bottom: 8px; }
    #content table {color: red; text-align: center; }
    #content  {margin-top: 20px; }
    #analitic  {margin-top: 150% ; }
    #tit {margin-top: -5px;}
    #tit {font-size: 12px; text-shadow:1px 1px 3px #cfcfcf}
    #obje {text-shadow:1px 1px 3px #cfcfcf}
    #lin {margin-top: 0px;}
    .conc{margin-top: 50px;  outline: 1px ;}
    #conc2{margin-top: 10px;  outline: 1px ;}
    #margin{margin-top: $conclusao px;}
    #mar_preventiva{margin-top: $mar_preventiva px;}


</style>

<html> 

    <body>

    
<div>

 <font color='#0080FF' >$nom</font> - RG <font color='#0080FF' >$rg</font> 
     




     
";


if (!empty($id)) {
    
$i=0;

$sqlcolaborador = "SELECT * FROM responsaveis WHERE id_contrato='$id'";
$resultado = mysqli_query($conection, $sqlcolaborador)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado)) {
    $nome[$i] = $registro['nome'];
    $responsabilidade[$i] = $registro['responsabilidade'];
    $area[$i] = $registro['area'];
    
   if( $responsabilidade[$i] == 'Gestor Tecnico'){
     $pagina = $pagina . "  
       <p><b>Gestor Técnico :</b> <font color='#0080FF' >$nome[$i] -  $area[$i] </font>
      
";
   }
    
    if( $responsabilidade[$i] == 'Gestora De Contratos'){
     $pagina = $pagina . "  
       <p><b>Gestor do Contrato :</b><font color='#0080FF' > $nome[$i] -  $area[$i] </font>
      
";
     
    } 
    
    $i++;

}

    $pagina = $pagina . "

   





<p><font color='#0080FF' >$nome_prestador</font> RG <font color='#0080FF' >$rg</font> - Iniciação do Contrato
                  
                  
                 

<p>Comunicamos o registro e publicação do contrato, cujos dados seguem abaixo, com objetivo de tomar as providências preparatórias e pertinentes, de forma tempestiva, de acordo com as disposições normativas e contratuais.

<p>Dados Contratuais:

   <p>RG: <font color='#0080FF' > $rg </font>
    <p>Fornecedor: <font color='#0080FF' >$nome_prestador</font>
    <p>Objeto: <font color='#0080FF' >$objeto</font>
    <p>Valor: R$  <font color='#0080FF' >$valor_atual</font> ( <font color='#0080FF' >$valor_extenso</font> ).
    <p>Data de assinatura: <font color='#0080FF' >$d_Assinatura</font>.
    <p>Vigência: 28/01/2019 a 27/01/2020.
    <p>Garantia: 60 (sessenta) meses a partir do recebimento definitivo.
    <p>Localidade: Rio de janeiro.
    <p>Gestora do Contrato: Fernanda Pereira da Rosa Gomes - DIRAD/SUPGA/GACCD.
    <p>Fiscais Administrativos:
    <p>Everton Valmir Oliveira Telles - SUPGA/GACCD/GACAD;
    <p>Jackson Silva Lopes - SUPGA/GACCD/GACAD;
    <p>Gestor Técnico: Plinio Nogueira De Arruda Sampaio - DIOPE/SUPCD/CDINF (conforme item 8.3 do TR 01650/2018).
    <p>Fiscal Técnico RJO: aguardando indicação da SUPCD;

    <p>Prazos de Entrega:
    <p>Até 40 (quarenta) dias corridos contados a partir do início da vigência do contrato (prazo final 11/03/2019)

    <p>Em se constatando quaisquer defeitos durante o período de garantia, a CONTRATADA terá o prazo máximo de 10 (dez) dias corridos, contados a partir da data da notificação, para proceder à substituição dos cartuchos de fita magnética, independente da quantidade rejeitada e sem ônus para o SERPRO.

    <p>Documentação Processual:

    <p>Termo de Recebimento Provisório - Norma GA-011.
    <p>Termo de Recebimento Definitivo - Norma GA-011.

<p>Reunião Inicial

<p>Os assuntos relacionados à execução e gestão do contrato serão ponderados na Reunião Inicial do Contrato, a ser realizada em data oportuna, com a participação das pessoas envolvidas no processo.

<p>Links:

<p>Contrato:
<p>https://processoverde.documenta.serpro/pvc/page/site/processoverde/document-details?nodeRef=workspace://SpacesStore/6f1d4ab6-3bc6-4bfd-bb9e-90b9b111368a

<p>Proposta Comercial:
<p>https://processoverde.documenta.serpro/pvc/page/site/processoverde/document-details?nodeRef=workspace://SpacesStore/b7eb4c5d-be51-48fa-a7ba-5cd738211b45


    


";
} else {
    $pagina = $pagina . " 
            
      <p>$texto</p>

";
}

$pagina = $pagina . "


        ";

$mpdf->setFooter('{PAGENO}');
$mpdf->AddPage('P', '', '', '', '', 10, 10, 10, 10, 10, 10);
$mpdf->WriteHTML($pagina);
$mpdf->Output($pagina, 'I');






// I abre no navegador
// F salva no servidor
// D salva o arquivo no computador do usuario
?>