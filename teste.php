<?php
/*
$valor_multa_array = array();
$id_multa_array = array();
$soma_corretiva = 0;
$i=0;
include_once 'database_gac.php';

$total_status = array();
$total_cham = array();

$sqlcorre = "SELECT * FROM corretivas WHERE regional='SPO' AND id_contrato = '245' AND mes_ref ='1'  AND ano = '2019'";
$resultado = mysqli_query($conection, $sqlcorre)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_assoc($resultado)) {

    $n_chamado = $registro['n_chamado'];
   
    $status = $registro['status'];
    $previsao_multa[] = (int) $registro['previsao_multa'];
    $previsao = (int) $registro['previsao_multa'];
    $total_status [] = $status;
      
    
if ($previsao == 1) {
    $total_cham [] = $n_chamado;
    
}}
*/
require_once 'database_gac.php';
require_once 'Funcoes/func_data.php';
require_once 'Funcoes/limpa_string.php';
require_once 'Funcoes/valida_data.php';

$data_inicio1='24/10/2018';
$periodo1 = 10;
        
$ano1 = '2018';

function fim_periodo($data_inicio, $periodo, $ano) {
    
    

    for ($i = 0; $i < $periodo; $i ++) {
        
        
   $dia=null;
   
      
         if($dia != $periodo) {

         //    var_dump($i);
            
           $data_fim = SomarData($data_inicio, $i , 0, 0);
           
          //    var_dump($data_fim);
          
              
              $dia = DiasUteis($data_inicio, $data_fim, $ano);
        }
        
   
          
    }
   
    return $data_fim;
}





$data = fim_periodo($data_inicio1, $periodo1, $ano1);

 var_dump($data);