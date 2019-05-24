
<?php

session_start();

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

if (isset($_POST['rg'])) {
    $rg = $_POST['rg'];
}

if (isset($_POST['nom'])) {
    $nom = $_POST['nom'];
}

if (isset($_POST['mes'])) {
    $mes = $_POST['mes'];
  
   
   
}

if (isset($_POST['ano'])) {
    $ano = $_POST['ano'];
    
   
}
if (isset($_POST['regio_id'])) {
    $regio_id = $_POST['regio_id'];
}
if (isset($_POST['id_local'])) {
    $id_local = $_POST['id_local'];
}

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
 $_SESSION['dados'] = $dados;
 
$palavra = explode("&", $regio_id);
$regio = $palavra[0];
$id_local = $palavra[1];

//var_dump($id_local);

require_once './Funcoes/mascara_php.php';
require_once 'database_gac.php';




$meses = array('', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
$me = @$meses[$mes];

function formata($total) {
    if ($total > 0) {
        echo (string) $total . ":00";
    } else {
        echo "00:00";
    }
}

//Função para inverter data
function inverteData($data) {

    if (count(explode("/", $data)) > 1) {
        return implode("-", array_reverse(explode("/", $data)));
    } elseif (count(explode("-", $data)) > 1) {
        return implode("/", array_reverse(explode("-", $data)));
    }
}

//Função cumprimento

date_default_timezone_set('America/Sao_Paulo');
$hora = date('G');

if (($hora >= 0) AND ( $hora < 6)) {
    $mensagem = "Boa madrugada! ";
} else if (($hora >= 6) AND ( $hora < 12)) {
    $mensagem = "Bom dia!  ";
} else if (($hora >= 12) AND ( $hora < 18)) {
    $mensagem = "Boa tarde! ";
} else {
    $mensagem = "Boa noite! ";
}

function SomarData($data, $dias, $meses, $ano) {
    /* www.brunogross.com */
    //passe a data no formato dd/mm/yyyy
    $data = explode("/", $data);
    $newData = date("d/m/Y", mktime(0, 0, 0, $data[1] + $meses, $data[0] + $dias, $data[2] + $ano));
    return $newData;
}

$d = '3';
$data_hoje = date('d/m/Y');

$termino_prazo = SomarData($data_hoje, $d, 0, 0);

//var_dump($termino_prazo);

$total_status = array();
$total_cham = array();

$sqlcorre = "SELECT * FROM corretivas WHERE regional='$regio' AND id_contrato = '$id' AND mes_ref ='$mes'  AND ano = '$ano'";
$resultado = mysqli_query($conection, $sqlcorre)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_assoc($resultado)) {

    $n_chamado = $registro['n_chamado'];
   
    $status = $registro['status'];
    $previsao_multa[] = (int) $registro['previsao_multa'];
    $previsao = (int) $registro['previsao_multa'];
    $total_status [] = $status;
      
    
if ($previsao == 1) {
    $total_cham [] = $n_chamado;
    
}

    //verifica se há chamados em aberto

    if (in_array("Pendente", $total_status)) {
        $aberto = "Obs: Há ocorrência (s) de chamado (s) em aberto.";
    }
}

$total_n_chamado = implode(", ", $total_cham);

var_dump('TOTAL:'.$total_n_chamado);




$multa = array_sum($previsao_multa);



$q = "SELECT * FROM preventivas WHERE id_contrato = '$id'  AND mes_ref='$mes' ";
$r = mysqli_query($conection, $q);
$num = mysqli_num_rows($r);

if ($num >= 1) {
    $preventiva = 1;
} else {

    $preventiva = 0;
}


if ($n_chamado == null && $preventiva == 0) {

    $texto = "Não há lançamentos  .";
} else



if ($n_chamado == 'Aguardando' && $preventiva == 0) {

    $texto = " A solicitação da validação do relatório referente ao mês de <font color='#0080FF' > $me</font>, será enviada posteriormente, neste mesmo SISCOR, assim quenos for entregue pelo fornecedor.";
} else

if ($n_chamado == 'Nao Houve' && $preventiva == 0) {

    $texto = "Solicitamos a validação das informações do relatório de<font color='#0080FF' > $me</font>, por meio de despacho, para que possamos ter condições de analisar os níveis de serviços. Ressaltamos que, com base nos dados informados pelo fornecedor,<font color='#0080FF' > não ocorreram  chamados para o período</font>.

               <p>Informamos que após prazo para validação, tais informações prevista no relatório serão consideradas como validas sendo autuado no processo.</p>";
} else if ($n_chamado == 'Nao Houve' && $preventiva == 1) {

    $texto = "Solicitamos a validação das informações do relatório de <font color='#0080FF' > $me</font>, por meio de despacho, ressaltando que, com base nos dados informados pelo fornecedor,<font color='#0080FF' > não foi registrado nenhum chamado de manutenção corretiva para o período, apenas manutenção preventiva conforme determina contrato.</font>
               Informamos que após prazo para validação, tais informações prevista no relatório serão consideradas como validas sendo autuado no processo.";
} else if ($multa >= 1 && $preventiva == 0) {

    $texto = "Solicitamos a validação das informações do relatório de<font color='#0080FF' > $me</font>, por meio de despacho e maiores informações quanto ao chamado (s)<font color='#0080FF' > $total_n_chamado </font>, pois, com base nos dados informados pelo fornecedor, é evidenciado o não cumprimento dos prazos estabelecidos no acordo de níveis de serviço. Solicito também que nos informe se este  tempo excedido é de exclusiva responsabilidade do fornecedor, ou  se o SERPRO tem responsabilidade total ou parcial neste fato.";
} else if ($multa >= 1 && $preventiva == 1) {

    $texto = "Solicitamos a validação das informações do relatório de<font color='#0080FF' > $me</font>, por meio de despacho e maiores informações quanto ao chamado (s)<font color='#0080FF' > $total_n_chamado </font>, pois, com base nos dados informados pelo fornecedor, é evidenciado o não cumprimento dos prazos estabelecidos no acordo de níveis de serviço. Solicito também que nos informe se este  tempo excedido é de exclusiva responsabilidade do fornecedor, ou  se o SERPRO tem responsabilidade total ou parcial neste fato."
            . "Ainda informando  que segundo este as manutenção preventiva foi realizada confome niveis de serviços acordados, ";
} else if ($multa == 0 && $preventiva == 0) {

    $texto = "Solicitamos a validação das informações do relatório de<font color='#0080FF' > $me</font>,por meio de despacho, para que possamos ter condições de analisar os níveis de serviços. Ressaltamos que, com base nos dados informados pelo fornecedor,<font color='#0080FF' > todos os chamados atenderam aos prazos de início de atendimento e tempo de conclusão</font>, conforme previsão contratual.<p><font color='#0080FF' >$aberto</font>";
} else if ($multa == 0 && $preventiva == 1) {

    $texto = "Solicitamos a validação das informações do relatório de<font color='#0080FF' > $me</font>, por meio de despacho, para que possamos ter condições de analisar os níveis de serviços. Ressaltamos que, com base nos dados informados pelo fornecedor,<font color='#0080FF' > todos os chamados atenderam aos prazos de início de atendimento e tempo de conclusão</font>, conforme previsão contratual,<font color='#0080FF' > bem como a manutenção preventiva</font>.";
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
    }
}


$sqlcolaborador = "SELECT * FROM responsaveis WHERE id_contrato='$id' AND responsabilidade='Gestor Tecnico' ";
$resultado = mysqli_query($conection, $sqlcolaborador)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado)) {

    $gestor_tecnico = $registro['nome'];
}

$nome = array();

$sqlfiscal = "SELECT * FROM responsaveis WHERE id_local='$id_local' AND responsabilidade='Fiscal Tecnico'";
$resultado = mysqli_query($conection, $sqlfiscal)or die('Não foi possivel conectar ao MySQL');
while ($registro6 = mysqli_fetch_array($resultado)) {

    $fiscal_tecnico = $registro6['nome'];
    $nom_fiscal_tecnico = explode(" ", $fiscal_tecnico);
    $fiscal_tecnicos = $nom_fiscal_tecnico[0];


    $nome[] = $registro6['nome'];
}

$nomes = implode(",", $nome);



$not = array();

$sqlnota = "SELECT * FROM pagamentos WHERE id_contrato='$id' AND regional='$regio' AND MONTH(data_inicio_per)='$mes' AND YEAR(data_fim_per)= '$ano'";
$resultados = mysqli_query($conection, $sqlnota)or die('Não foi possivel conectar ao MySQL');
while ($registro5 = mysqli_fetch_assoc($resultados)) {


    $notas_fiscal = $registro5['nota_fiscal'];
    $not[] = $notas_fiscal;
}
$nots = implode(",", $not);

var_dump('ANO:'.$ano,'MES:'. $mes,'REIONAL:'.$regio,'RG'.$rg ,'id contrato'.$id, 'gestor'.$gestor_tecnico, 'nota' . $notas_fiscal ); 



include('pdf/mpdf.php');


$conection = mysqli_connect('localhost', 'root');
mysqli_select_db($conection, 'gac');



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

    
<div style='text-align: center; font-weight: bold;'>

 <font color='#0080FF' >$nom</font> - RG <font color='#0080FF' >$rg</font> 
     




     
";


if (!empty($me)) {





    if (!empty($notas_fiscal)) {

        $pagina = $pagina . "
       - Termo Rec. Def. - NF <font color='#0080FF' >$nots 
        
    ";
    }

    $pagina = $pagina . "
   
        - $me - $ano - $regio</font> <hr id='lin'> 
   

</div>
    
";
    if (!empty($notas_fiscal)) {

        $pagina = $pagina . "


        <p><font color='#0080FF' >$mensagem</font></p>

        <p>Prezado (a) <font color='#0080FF' >$gestor_tecnico</font>,</p>

        <p>Encaminhamos em anexo Nota Fiscal para providências de Termo de Recebimento Definitivo, conforme determina Norma GA-011.</p>

";
    }

    $pagina = $pagina . "

        <p>Processo nº: <font color='#0080FF' >$n_processo</font></p>

        <p>Contrato:  RG<font color='#0080FF' > $rg </font>.</p>

        <p>Fornecedor: <font color='#0080FF' >$nom</font>.</p>

      
        <hr>
        
";
    $sqlpagamento = "SELECT * FROM pagamentos WHERE id_contrato='$id' AND regional='$regio' AND MONTH(data_inicio_per)='$mes' AND YEAR(data_fim_per)= '$ano'";
    $resultado = mysqli_query($conection, $sqlpagamento)or die('Não foi possivel conectar ao MySQL');
    while ($registro6 = mysqli_fetch_array($resultado)) {

        $nota_fiscal = $registro6['nota_fiscal'];
        $data_inicio_per = inverteData($registro6['data_inicio_per']);
        $data_fim_per = inverteData($registro6['data_fim_per']);
        $valor_parcela = $registro6['valor_parcela'];
        $cnpj_faturamento = $registro6['cnpj_faturamento'];
        $valor_parcela1 = number_format($valor_parcela, 2, ',', '.');
        
        if(empty($cnpj_faturamento)){
      $cnpj_faturamento = $cnpj;
  }
  $cnpj_faturamento1=  masc_cnpj_php($cnpj_faturamento);

        $pagina = $pagina . "

        <p>Documentação Fiscal:<font color='#0080FF' > $nota_fiscal.</font></p>
            
        <p>CNPJ do Faturamento:<font color='#0080FF' > $cnpj_faturamento1.</font></p>

        <p>Valor : R$ <font color='#0080FF' >$valor_parcela1</font>.</p>

        <p>Período: <font color='#0080FF' >$data_inicio_per</font> a <font color='#0080FF' >$data_fim_per</font>.</p>
        <hr>

 ";
    }

    $pagina = $pagina . " 

";
    if (!empty($notas_fiscal)) {

        $pagina = $pagina . "
        <p>De acordo com o disposto na Norma GF 030 ítem 4.3.17.3, Para que o pagamento ocorra em tempo hábil, o documento fiscal deverá estar no órgão local financeiro, no mínimo, 4 (quatro) dias úteis anteriores ao seu vencimento.</p>


        <p>O documento fiscal deverá retornar à esta SUPGA/GACAD, com o Termo de Recebimento Definitivo assinado digitalmente, até o dia <font color='#0080FF' >$termino_prazo</font>, para não comprometer a data de vencimento.</p>

    
 ";
    }

    $pagina = $pagina . " 
        
      <p>Prezado (a).</p> 
      <p><font color='#0080FF' >$nomes</font>.</p>   
         
      <p>$texto</p>


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