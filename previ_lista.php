<?php

$id_contrato = (int) filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

require_once 'database_gac.php';

//script para teste de criação de lista.

  $q = "SELECT * FROM  contrato Where id_contrato='$id_contrato' ";
  $r = mysqli_query($conection, $q);
  $num = mysqli_num_rows($r);

  while ($res = mysqli_fetch_array($r)) {

  $d_Assinatura = $res['d_Assinatura'];
  $id_contrato = $res['id_contrato'];
  $tipo = $res['tipo'];
  //$pex = explode("-", $d_Assinatura);
  $mesAnoAss = $d_Assinatura;
  
    if($tipo == 'AQUISIÇÃO' || $tipo == 'SOLUÇÃO'){
  
   //declaração de origens de bens
  $q5 = "SELECT * FROM documentos WHERE categoria ='DECLARACAO DE ORIGENS DE BENS' AND periodo ='$mesAnoAss' AND id_contrato = '$id_contrato'";
  $r5 = mysqli_query($conection, $q5);
  $num17 = mysqli_num_rows($r5);

  if ($num5 == 0) {
  $query1 = "INSERT INTO documentos (categoria,status,periodo,id_contrato) VALUES  ('DECLARACAO DE ORIGENS DE BENS','1','$mesAnoAss','$id_contrato')";
  $resultado1 = mysqli_query($conection, $query1);

  }
  
  
   //relatorio patrimonial
  $q5 = "SELECT * FROM documentos WHERE categoria ='RELATORIO PATRIMONIAL' AND periodo ='$mesAnoAss' AND id_contrato = '$id_contrato'";
  $r5 = mysqli_query($conection, $q5);
  $num5 = mysqli_num_rows($r5);

  if ($num5 == 0) {


  $query1 = "INSERT INTO documentos (categoria,status,periodo,id_contrato) VALUES  ('RELATORIO PATRIMONIAL','1','$mesAnoAss','$id_contrato')";
  $resultado1 = mysqli_query($conection, $query1);
  }
  
    //requisitos tecnicos para instalação
  $q7 = "SELECT * FROM documentos WHERE categoria ='REQUISITOS TECNICOS PARA INSTALACAO' AND periodo ='$mesAnoAss' AND id_contrato = '$id_contrato'";
  $r7 = mysqli_query($conection, $q7);
  $num7 = mysqli_num_rows($r1);

  if ($num7 == 0) {
  $query1 = "INSERT INTO documentos (categoria,status,periodo,id_contrato) VALUES  ('REQUISITOS TECNICOS PARA INSTALACAO','1','$mesAnoAss','$id_contrato')";
  $resultado1 = mysqli_query($conection, $query1);
  }
     }
        


  //iniciação do contrato

  $q1 = "SELECT categoria, periodo FROM documentos WHERE categoria ='INICIACAO DO CONTRATO' AND periodo ='$mesAnoAss' AND id_contrato = '$id_contrato'";
  $r1 = mysqli_query($conection, $q1);
  $num1 = mysqli_num_rows($r1);

  var_dump($num1);

  if ($num1 == 0) {


  $query1 = "INSERT INTO documentos (categoria,status,periodo,id_contrato) VALUES  ('INICIACAO DO CONTRATO','1','$mesAnoAss','$id_contrato')";
  $resultado1 = mysqli_query($conection, $query1);

  }
  //ata
  $q2 = "SELECT * FROM documentos WHERE categoria ='ATA DE REUNIAO' AND periodo ='$mesAnoAss' AND id_contrato = '$id_contrato'";
  $r2 = mysqli_query($conection, $q2);
  $num2 = mysqli_num_rows($r2);

  if ($num2 == 0) {

  $query1 = "INSERT INTO documentos (categoria,status,periodo,id_contrato) VALUES  ('ATA DE REUNIAO','1','$mesAnoAss','$id_contrato')";
  $resultado1 = mysqli_query($conection, $query1);

  }

  //relatório prametrizado
  $q4 = "SELECT * FROM documentos WHERE categoria ='RELATORIO PARAMETRIZADO DO CONTRATO' AND periodo ='$mesAnoAss' AND id_contrato = '$id_contrato'";
  $r4 = mysqli_query($conection, $q4);
  $num1 = mysqli_num_rows($r4);

  if ($num4 == 0) {


  $query1 = "INSERT INTO documentos (categoria,status,periodo,id_contrato) VALUES  ('RELATORIO PARAMETRIZADO DO CONTRATO','1','$mesAnoAss','$id_contrato')";
  $resultado1 = mysqli_query($conection, $query1);

  }
 
  //relatorio tecnico
  $q7 = "SELECT * FROM documentos WHERE categoria ='RELATORIO TECNICO' AND periodo ='$mesAnoAss' AND id_contrato = '$id_contrato'";
  $r7 = mysqli_query($conection, $q1);
  $num7 = mysqli_num_rows($r1);

  if ($num7 == 0) {


  $query1 = "INSERT INTO documentos (categoria,status,periodo,id_contrato) VALUES  ('RELATORIO TECNICO','1','$mesAnoAss','$id_contrato')";
  $resultado1 = mysqli_query($conection, $query1);

  }
 
  
   //termo de enceramento
  $q19 = "SELECT * FROM documentos WHERE categoria ='TERMO DE ENCERRAMENTO DO CONTRATO' AND periodo ='$mesAnoAss' AND id_contrato = '$id_contrato'";
  $r19 = mysqli_query($conection, $q5);
  $num19 = mysqli_num_rows($r5);

  if ($num19 == 0) {


  $query1 = "INSERT INTO documentos (categoria,status,periodo,id_contrato) VALUES  ('TERMO DE ENCERRAMENTO DO CONTRATO','1','$mesAnoAss','$id_contrato')";
  $resultado1 = mysqli_query($conection, $query1);



  }
  
   //canais de atendimento
  $q5 = "SELECT * FROM documentos WHERE categoria ='CANAIS DE ATENDIMENTO' AND periodo ='$mesAnoAss' AND id_contrato = '$id_contrato'";
  $r5 = mysqli_query($conection, $q5);
  $num5 = mysqli_num_rows($r5);

  if ($num5 == 0) {


  $query1 = "INSERT INTO documentos (categoria,status,periodo,id_contrato) VALUES  ('CANAIS DE ATENDIMENTO','1','$mesAnoAss','$id_contrato')";
  $resultado1 = mysqli_query($conection, $query1);

  }
  

  
  }
 
$i = 0;
$query = "SELECT tip.* , loc.id_contrato, loc.sigla, cont.tip_chamado, 
				cont.rg, loc.lugar_regional				
				FROM tipo AS tip
				INNER JOIN local AS loc ON  loc.id_local = tip.id_local
				INNER JOIN  contrato AS cont ON  cont.id_contrato = loc.id_contrato
				WHERE cont.id_contrato = '$id_contrato'";

$resultado = mysqli_query($conection, $query)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado)) {

    $sigla[$i] = $registro['sigla'];

    var_dump($sigla);
    
     $q = "SELECT * FROM  pagamentos Where id_contrato='$id_contrato'";
    $r = mysqli_query($conection, $q);
    while ($res = mysqli_fetch_array($r)) {

        $data_fim_per = $res['data_fim_per'];
        $id_contrato = $res['id_contrato'];
        $regional = $res['regional'];
      //  $pex = explode("-", $data_inicio_per);
     //   $data_inicio_per = "$pex[1]/$pex[0]";


        $q10 = "SELECT * FROM documentos WHERE categoria ='RELATORIO NE NIVEIS DE SERVICO' AND periodo ='$data_fim_per' AND id_contrato = '$id_contrato'";
        $r10 = mysqli_query($conection, $q10);
        $num10 = mysqli_num_rows($r10);

        if ($num10 == 0) {

            $query1 = "INSERT INTO documentos (categoria,status,periodo,id_contrato) VALUES  ('RELATORIO NE NIVEIS DE SERVICO','1','$data_fim_per','$id_contrato')";
            $resultado1 = mysqli_query($conection, $query1);
        }
    }
  
     if($tipo == 'AQUISIÇÃO' || $tipo == 'SOLUÇÃO'){
    
     //termo de recebimento provisório
    
  $q4 = "SELECT * FROM documentos WHERE categoria ='TERMO DE RECEBIMENTO PROVISORIO'  AND id_contrato = '$id_contrato' and regional='$sigla[$i]' ";
  $r4 = mysqli_query($conection, $q4);
  $num4 = mysqli_num_rows($r4);

  if ($num4 == 0) {


  $query1 = "INSERT INTO documentos (categoria,status,periodo,id_contrato,regional) VALUES  ('TERMO DE RECEBIMENTO PROVISORIO','1','$mesAnoAss','$id_contrato','$sigla[$i]')";
  $resultado1 = mysqli_query($conection, $query1);

  }
     }


    $q = "SELECT * FROM  pagamentos Where id_contrato='$id_contrato' and regional='$sigla[$i]' ";
    $r = mysqli_query($conection, $q);
    while ($res = mysqli_fetch_array($r)) {

        $data_fim_per = $res['data_fim_per'];
        $id_contrato = $res['id_contrato'];
        $regional = $res['regional'];
      //  $pex = explode("-", $data_inicio_per);
     //   $data_inicio_per = "$pex[1]/$pex[0]";


        $q10 = "SELECT * FROM documentos WHERE categoria ='TERMO DE RECEBIMENTO DEFINITIVO' AND periodo ='$data_fim_per' AND id_contrato = '$id_contrato' AND regional='$regional'";
        $r10 = mysqli_query($conection, $q10);
        $num10 = mysqli_num_rows($r10);

        if ($num10 == 0) {

            $query1 = "INSERT INTO documentos (categoria,status,periodo,id_contrato,regional) VALUES  ('TERMO DE RECEBIMENTO DEFINITIVO','1','$data_fim_per','$id_contrato','$regional')";
            $resultado1 = mysqli_query($conection, $query1);
        }
    }
   

    $i++;
}


header("Location: previ.php?id=$id_contrato");
