<?php
//1
function total_item_horas_atraso($patrimonio, $id_contrato) {

    $conection = mysqli_connect('localhost', 'root');
    mysqli_select_db($conection, 'gac');

    $query = "SELECT cont.*,  it.valor_unitario
								
				FROM contrato AS cont
				INNER JOIN local AS loc ON  loc.Id_contrato = cont.id_contrato
				INNER JOIN  tipo AS tip ON  tip.id_local = loc.id_local
				INNER JOIN  itens AS it ON  it.id_tipo = tip.id_tipo
				WHERE cont.id_contrato = '$id_contrato'AND it.patrimonio = '$patrimonio'";
    $resultado = mysqli_query($conection, $query)or die(mysqli_error($conection));
    while ($registro = mysqli_fetch_array($resultado)) {

        return $valor_unitario = floatval($registro['valor_unitario']);
    }

}
    
  //2  
    function total_contrato_60_horas_atraso() {
        
    }

    function total_valor_especifico_severidade() {
        
    }

    function total_contrato_horas_atraso() {
        
    }

    function total_mensal_regional($regional, $id_contrato, $data_abertura) {

        $conection = mysqli_connect('localhost', 'root');
        mysqli_select_db($conection, 'gac');

        $ref= explode("-", $data_abertura);
        $ano = $ref[0];
        $mes = $ref[1];
        
        $sql2 = "SELECT valor_parcela FROM pagamentos WHERE  regional='$regional' AND id_contrato = '$id_contrato' AND  YEAR(data_fim_per)='$ano' AND MONTH(data_fim_per)='$mes'";
        $result2 = mysqli_query($conection, $sql2)or die('Não foi possivel conectar ao MySQL');
        while ($registro2 = mysqli_fetch_array($result2)) {
            $valor_parcela = floatval($registro2['valor_parcela']);
        }

        return $valor_parcela;
    }

    
    
    
    function total_mensal_geral( $id_contrato, $data_abertura) {
        
          $conection = mysqli_connect('localhost', 'root');
        mysqli_select_db($conection, 'gac');
        
        $ref= explode("-", $data_abertura);
        $ano = $ref[0];
        $mes = $ref[1];
         
        $sql2 = "SELECT valor_parcela FROM pagamentos WHERE   id_contrato = '$id_contrato' AND  YEAR(data_fim_per)='$ano' AND MONTH(data_fim_per)='$mes'";
        $result2 = mysqli_query($conection, $sql2)or die('Não foi possivel conectar ao MySQL');
        while ($registro2 = mysqli_fetch_array($result2)) {
            $valor_parcela[] = floatval($registro2['valor_parcela']);
        }

        return $total_parcela = array_sum($valor_parcela);
        
    }
    