<div class="form-group col-md-12">

    <table  class="table table-hover table-striped table-sm table-bordered bg-light"   >
    <thead class="thead-dark ">

    <th scope="col">RG: </th>
    <th scope="col">Regional</th>
    <th scope="col">Patrimônios </th>
    <th scope="col">Nº Chamado</th>
    <th style="background-color:#228B22;">Mês Planejado</th>
    <th scope="col">Ano</th> 
    <th scope="col">Data da Execução</th>                  
    <th scope="col">Observação</th>
    <th style="background-color:#228B22;">Previsão de multa?</th>
    <th style="background-color:#228B22;">Aplicar multa?</th>
    <th scope="col">Status</th>
  
</tr> 

        <?php
        
        require './gatway_corretiva.php';
        require_once './access_db.php'; 

        $para_data = date('Y-m-d');
        
        if(!empty($nome)){
        
         $id_contrato = retorna_idcontrato_nome($nome);
         
        } else if (!empty($rg)){
                        
        $id_contrato = retorna_idcontrato_rg($rg);
         
        }
        
     
$mes = (int)date('m');
$ano = date('Y');
$dia = (int) date('d');

//se janeiro ano anterior

if($mes == 1 ){
    
    $startTime1 = mktime(0, 0, 0, 1, 1, date('Y') - 1);
    $endTime1 = mktime(23, 59, 59, 12, 31, date('Y') - 1);
    $final1 = date("Y-m-d", $endTime1);
    $res1 = explode("-", $final1);

    $ano = (int) $res1[0];
    
    
}

// se dia menor que 25 mes anterio

if ($dia < 25) {

    $startTime = mktime(0, 0, 0, date('m') - 1, 1, date('Y'));
    $endTime = mktime(23, 59, 59, date('m'), date('d') - date('j'), date('Y'));
    $final = date("Y-m-d", $endTime);
    $res = explode("-", $final);

    $mes = (int) $res[1];
} else {

    $mes = date('m');
}

     
 
         foreach ($id_contrato as $value) {
                    
           
$sqlcorre = "SELECT * FROM preventivas WHERE mes_ref='$mes' AND ano ='$ano'  AND status ='Pendente' AND  id_contrato='$value' ORDER BY d_limite";
$resultado = mysqli_query($conection, $sqlcorre)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado)) {

    $d_limite = $registro['d_limite'];
    $id_tipo = $registro['id_tipo'];
    $ex = explode("-", $d_limite);
    $ano = $ex[0];
    $regis = db_access($id_tipo);
    $rg = $regis['rg'];
    $id_contrato = $regis['id_contrato'];
    $regional = $regis['sigla'];
    $d_execucao = $registro['data_conclusao'];
    $d_execucao1 = inverteData($d_execucao);
    $id_preventiva = $registro['id_preventiva'];
    ?>
    <tr>
        <td ><a href="#"=<?php echo $id_contrato ?>"><?php echo $rg; ?></a></td>
        <td style=" font-size: 30px; font-weight: bold;font-family: time new romam; " ><a class="btn btn-outline-primary"  href="cad_preventiva.php?action=1&id_tipo=<?php echo $id_tipo ?>"><?php echo $regional; ?></a></td>
        <td class = "td2" ><?php echo $registro['patrimonio']; ?></td>
        <td class = "td2" ><?php echo $registro['n_chamado']; ?></td>        
        <td class = "td2" ><?php
            echo $registro['mes'];
            ;
            ?></td>
        <td class = "td2" ><?php echo $ano; ?></td>
        <td class = "td2" ><?php echo $d_execucao1; ?></td>

        <td class = "td2" ><?php echo $registro['obs']; ?></td>       
        <td class = "td2" ><?php echo $registro['previsao_multa']; ?></td>
        <td class = "td2" >
            <a  href="" data-toggle="modal"  <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?> data-target="#exampleModalLong<?php echo $id_preventiva; ?>" <?php } ?>><?php echo $registro['aplicacao_multa']; ?></a>
        </td>
        <td class = "td2" ><?php echo $registro['status']; ?></td>
      
    </tr>

    <?php
         }}
?>

</table>


