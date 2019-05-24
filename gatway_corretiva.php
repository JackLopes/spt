<?php

function total_ocorrencia() {
    require './database_gac.php';

    $sqlcorre2 = "SELECT data_conclusao FROM corretivas WHERE  aplicacao_multa ='Verificar' ORDER BY (data_conclusao) DESC";
    $resultado = mysqli_query($conection, $sqlcorre2)or die('Não foi possivel conectar ao MySQL');
    $num = mysqli_num_rows($resultado);

    return "<font style='font-size:30px; font-family: times new romam '>Total de ocorrências:  $num</font>";
}

function total_ocorrencia_rg($param_rg) {
    require './database_gac.php';

    $sqlcorre2 = "SELECT data_conclusao FROM corretivas WHERE rg = '$param_rg'  And aplicacao_multa ='Verificar' ORDER BY (data_conclusao) DESC";
    $resultado = mysqli_query($conection, $sqlcorre2)or die('Não foi possivel conectar ao MySQL');
    $num = mysqli_num_rows($resultado);

    return "<font style='font-size:30px; font-family: times new romam '>Total de ocorrências:  $num</font>";
}

function total_ocorrencia_nome($param_nome) {
    require './database_gac.php';

    $sqlcolaborador = "SELECT id_contrato   FROM responsaveis WHERE responsabilidade='Fiscal Administrativo'  AND nome='$param_nome'";
    $resultado1 = mysqli_query($conection, $sqlcolaborador)or die('Não foi possivel conectar ao MySQL');
    while ($registro1 = mysqli_fetch_array($resultado1)) {

        $id_contrato = $registro1['id_contrato'];

        $sqlcorre = "SELECT previsao_multa FROM corretivas WHERE id_contrato = '$id_contrato' and previsao_multa = '1' And aplicacao_multa ='Verificar' ORDER BY (data_conclusao) DESC";
        $resultado = mysqli_query($conection, $sqlcorre)or die('Não foi possivel conectar ao MySQL');
        $num1[] = mysqli_num_rows($resultado);

        $num = array_sum($num1);
        
        
      

        $cate = 4;
        insert_ocorrencia_corretiva($cate, $param_nome, $num);
    }
      if(empty($num)){
            $num =0;
        }
    
    
    return "<font style='font-size:30px; font-family: times new romam '>  $num</font>";
}

function insert_ocorrencia_corretiva($cate, $nom, $tot) {
    require './database_gac.php';

    $query1 = "SELECT nome FROM historico_processo WHERE nome='$nom' AND categoria = '4' GROUP BY(nome)";
    $verifica = mysqli_query($conection, $query1);
    $num_verifica = mysqli_num_rows($verifica);


    if ($num_verifica == 0) {

        $query = "INSERT INTO historico_processo (categoria, nome,total_ocorre)VALUES('$cate','$nom','$tot')";
        $result = mysqli_query($conection, $query)or die(mysqli_error($conection));
    } else {

        $query2 = "UPDATE historico_processo SET total_ocorre ='$tot' WHERE categoria= '4' AND nome='$nom'";
        $r1 = mysqli_query($conection, $query2)or die(mysqli_error($conection));
    }
}

function notasMedir($param_nome) {

    require './database_gac.php';

    $startTime = mktime(0, 0, 0, date('m') - 1, 1, date('Y'));    //inicio mes anterior
    $endTime1 = mktime(); // data atual

    $inicio = date("Y-m-d", $startTime);
    $final = date("Y-m-d", $endTime1);

    $sqlcolaborador = "SELECT  id_contrato  FROM responsaveis WHERE responsabilidade='Fiscal Administrativo'  AND nome='$param_nome'";
    $resultado1 = mysqli_query($conection, $sqlcolaborador)or die('Não foi possivel conectar ao MySQL');
    while ($registro1 = mysqli_fetch_array($resultado1)) {

        $id_contrato = $registro1['id_contrato'];

        $sqlcorre = "SELECT data_fim_per FROM pagamentos WHERE  data_fim_per BETWEEN '$inicio' AND ' $final'  AND id_contrato ='$id_contrato' AND medido !='Sim' ORDER BY (data_fim_per) DESC";
        $resultado = mysqli_query($conection, $sqlcorre)or die('Não foi possivel conectar ao MySQL');

        $num1[] = mysqli_num_rows($resultado);

        $num = array_sum($num1);

        $cate = 1;

        insert_ocorrencia_nota($cate, $param_nome, $num);
    }

    return "<font style='font-size:30px; font-family: times new romam '>  $num</font>";
}

function insert_ocorrencia_nota($cate, $nom, $tot) {
    require './database_gac.php';

    $query1 = "SELECT nome FROM historico_processo WHERE nome='$nom' AND categoria = '1' GROUP BY(nome)";
    $verifica = mysqli_query($conection, $query1);
    $num_verifica = mysqli_num_rows($verifica);


    if ($num_verifica == 0) {

        $query = "INSERT INTO historico_processo (categoria, nome,total_ocorre)VALUES('$cate','$nom','$tot')";
        $result = mysqli_query($conection, $query)or die(mysqli_error($conection));
    } else {

        $query2 = "UPDATE historico_processo SET total_ocorre ='$tot' WHERE categoria= '1' AND nome='$nom'";
        $r1 = mysqli_query($conection, $query2)or die(mysqli_error($conection));
    }
}

/*
  function atualisacao_automatica($permissao) {
  require './database_gac.php';



  if ($permissao == 2) {

  $nome = array();

  $sqlcolaborador = "SELECT nome FROM responsaveis WHERE responsabilidade='Fiscal Administrativo' GROUP BY(nome)";
  $resultado1 = mysqli_query($conection, $sqlcolaborador)or die('Não foi possivel conectar ao MySQL');
  while ($registro1 = mysqli_fetch_array($resultado1)) {

  $nome[] = $registro1['nome'];
  }
  $nomes = implode(",", $nome);

  $varios_nomes = explode(',', $nomes);

  $total_nome = count($varios_nomes);


  for ($k = 0; $k < $total_nome; $k++) {

  total_ocorrencia_nome($varios_nomes[$k]);
  notasMedir($varios_nomes[$k]);
  }
  }



  }

 */

function retorna_idcontrato_nome($param_nome) {
    require './database_gac.php';

    $sqlcolaborador = "SELECT  id_contrato FROM responsaveis WHERE responsabilidade='Fiscal Administrativo'  AND nome='$param_nome'";
    $resultado1 = mysqli_query($conection, $sqlcolaborador)or die('Não foi possivel conectar ao MySQL');
    while ($registro1 = mysqli_fetch_array($resultado1)) {

        $id_contrato[] = $registro1['id_contrato'];
    }

     
    
    return $id_contrato;
}

function retorna_idcontrato_rg($rg_param) {
    require './database_gac.php';

    $sqlcolaborador = "SELECT  id_contrato FROM contrato WHERE rg='$rg_param'";
    $resultado1 = mysqli_query($conection, $sqlcolaborador)or die('Não foi possivel conectar ao MySQL');
    while ($registro1 = mysqli_fetch_array($resultado1)) {

        $id_contrato[] = $registro1['id_contrato'];
    }

    return $id_contrato;
}

function total_itens_nome($param_nome) {
    require './database_gac.php';

    $para_data = date('Y-m-d');

    $sqlcolaborador = "SELECT id_contrato   FROM responsaveis WHERE responsabilidade='Fiscal Administrativo'  AND nome='$param_nome'";
    $resultado1 = mysqli_query($conection, $sqlcolaborador)or die('Não foi possivel conectar ao MySQL');
    while ($registro1 = mysqli_fetch_array($resultado1)) {

        $id_contrato = $registro1['id_contrato'];

        $severi = "SELECT prazo_entrega FROM itens WHERE status = 'Aguardando Entrega' AND prazo_entrega > '$para_data' AND id_contrato ='$id_contrato'";
        $resultado = mysqli_query($conection, $severi)or die('Não foi possivel conectar ao MySQL');
        $num1[] = mysqli_num_rows($resultado);

        $num = array_sum($num1);

        $cate = 3;
        insert_ocorrencia_itens($cate, $param_nome, $num);
    }
    return "<font style='font-size:30px; font-family: times new romam '>  $num</font>";
}

function insert_ocorrencia_itens($cate, $nom, $tot) {
    require './database_gac.php';

    $query1 = "SELECT nome FROM historico_processo WHERE nome='$nom' AND categoria = '3' GROUP BY(nome)";
    $verifica = mysqli_query($conection, $query1);
    $num_verifica = mysqli_num_rows($verifica);


    if ($num_verifica == 0) {

        $query = "INSERT INTO historico_processo (categoria, nome,total_ocorre)VALUES('$cate','$nom','$tot')";
        $result = mysqli_query($conection, $query)or die(mysqli_error($conection));
    } else {

        $query2 = "UPDATE historico_processo SET total_ocorre ='$tot' WHERE categoria= '3' AND nome='$nom'";
        $r1 = mysqli_query($conection, $query2)or die(mysqli_error($conection));
    }
}

/*
  function atualisacao_automatica($permissao) {
  require './database_gac.php';



  if ($permissao == 2) {

  $nome = array();

  $sqlcolaborador = "SELECT nome FROM responsaveis WHERE responsabilidade='Fiscal Administrativo' GROUP BY(nome)";
  $resultado1 = mysqli_query($conection, $sqlcolaborador)or die('Não foi possivel conectar ao MySQL');
  while ($registro1 = mysqli_fetch_array($resultado1)) {

  $nome[] = $registro1['nome'];
  }
  $nomes = implode(",", $nome);

  $varios_nomes = explode(',', $nomes);

  $total_nome = count($varios_nomes);


  for ($k = 0; $k < $total_nome; $k++) {

  total_ocorrencia_nome($varios_nomes[$k]);
  notasMedir($varios_nomes[$k]);
  total_itens_nome($varios_nomes[$k]);
  }
  }



  }

 */

function total_preventiva_nome($param_nome) {
    require './database_gac.php';

    $mes = (int) date('m');
    $ano = date('Y');
    $dia = (int) date('d');

//se janeiro ano anterior

    if ($mes == 1) {

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


    $sqlcolaborador = "SELECT id_contrato   FROM responsaveis WHERE responsabilidade='Fiscal Administrativo'  AND nome='$param_nome'";
    $resultado1 = mysqli_query($conection, $sqlcolaborador)or die('Não foi possivel conectar ao MySQL');
    while ($registro1 = mysqli_fetch_array($resultado1)) {

        $id_contrato = $registro1['id_contrato'];

        $sqlcorre = "SELECT mes_ref FROM preventivas WHERE  mes_ref='$mes' AND ano ='$ano'   AND status ='Pendente' AND  id_contrato='$id_contrato' ORDER BY d_limite";
        $resultado = mysqli_query($conection, $sqlcorre)or die('Não foi possivel conectar ao MySQL');
        $num1[] = mysqli_num_rows($resultado);

        $num = array_sum($num1);

        $cate = 2;
        insert_preventiva_itens($cate, $param_nome, $num);
    }
    return "<font style='font-size:30px; font-family: times new romam '>  $num</font>";
}

function insert_preventiva_itens($cate, $nom, $tot) {
    require './database_gac.php';

    $query1 = "SELECT nome FROM historico_processo WHERE nome='$nom' AND categoria = '2' GROUP BY(nome)";
    $verifica = mysqli_query($conection, $query1);
    $num_verifica = mysqli_num_rows($verifica);


    if ($num_verifica == 0) {

        $query = "INSERT INTO historico_processo (categoria, nome,total_ocorre)VALUES('$cate','$nom','$tot')";
        $result = mysqli_query($conection, $query)or die(mysqli_error($conection));
    } else {

        $query2 = "UPDATE historico_processo SET total_ocorre ='$tot' WHERE categoria= '2' AND nome='$nom'";
        $r1 = mysqli_query($conection, $query2)or die(mysqli_error($conection));
    }
}

function atualisacao_automatica($permissao) {
    require './database_gac.php';



    if ($permissao == 2) {

        $nome = array();

        $sqlcolaborador = "SELECT nome FROM responsaveis WHERE responsabilidade='Fiscal Administrativo' GROUP BY(nome)";
        $resultado1 = mysqli_query($conection, $sqlcolaborador)or die('Não foi possivel conectar ao MySQL');
        while ($registro1 = mysqli_fetch_array($resultado1)) {

            $nome = $registro1['nome'];

            total_ocorrencia_nome($nome);
            notasMedir($nome);
            total_itens_nome($nome);
            total_preventiva_nome($nome);
        }
    }
}

function total_previsao_multa() {
    require './database_gac.php';

    $sqlcorre2 = "SELECT id_histmulta FROM historico_multa WHERE status = '1'";
    $resultado = mysqli_query($conection, $sqlcorre2)or die('Não foi possivel conectar ao MySQL');
    $num = mysqli_num_rows($resultado);

    return $num;
}

function verifica_resp($nome) {
      require './database_gac.php';
    
    $sql = "SELECT nome FROM responsaveis WHERE nome = '$nome'";
    $result = mysqli_query($conection, $sql);
    $num_ocorre = mysqli_num_rows($result);
    
    return $num_ocorre;
}
