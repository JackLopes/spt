<?php

require_once 'database_gac.php';
/*
  $i = 0;

  $query = "SELECT id_preventiva,id_tipo, d_limite  FROM  preventivas ";
  $result = mysqli_query($conection, $query);
  while ($res = mysqli_fetch_array($result)) {



  $d_limite[$i] = $res['d_limite'];
  $id_tipo[$i] = $res['id_tipo'];
  $id_preventiva[$i] = $res['id_preventiva'];
  $ex = explode("-", $d_limite[$i]);
  $ano[$i] = (int) $ex[0];
  $mes[$i] = (int) $ex[1];


  $query1 = "SELECT tip.* , loc.id_contrato, loc.sigla, cont.tip_chamado,
  cont.rg, loc.lugar_regional
  FROM tipo AS tip
  INNER JOIN local AS loc ON  loc.id_local = tip.id_local
  INNER JOIN  contrato AS cont ON  cont.id_contrato = loc.id_contrato
  WHERE id_tipo = '$id_tipo[$i]'";

  $resultado = mysqli_query($conection, $query1)or die('Não foi possivel conectar ao MySQL');
  while ($registro = mysqli_fetch_array($resultado)) {


  $id_contrato[$i] = $registro['id_contrato'];
  }


  $q1 = "UPDATE preventivas  SET id_contrato='$id_contrato[$i]', mes_ref='$mes[$i]', ano='$ano[$i]' WHERE id_preventiva='$id_preventiva[$i] '";
  $r1 = mysqli_query($conection, $q1);


  // var_dump($r1);

  $i++;
  }
 * */





$j = 0;

//script para teste de criação de lista.

$q = "SELECT * FROM  pagamentos Where id_contrato='174' group by (data_inicio_per) ";
$r = mysqli_query($conection, $q);
$num = mysqli_num_rows($r);

var_dump($num);

while ($res = mysqli_fetch_array($r)) {

    $data_inicio_per = $res['data_inicio_per'];
    $id_contrato = $res['id_contrato'];


    $q1 = "SELECT * FROM documents_father WHERE periodo ='$data_inicio_per' AND id_contrato = '$id_contrato'";
    $r1 = mysqli_query($conection, $q1);
    $num1 = mysqli_num_rows($r1);

    if ($num1 == 0) {


        $query1 = "INSERT INTO documents_father(categoria,status,periodo,id_contrato) VALUES  ('ANS', '1','$data_inicio_per','$id_contrato')";
        $resultado1 = mysqli_query($conection, $query1);
        var_dump($data_inicio_per . "<br>");

        $id_return = mysqli_insert_id($conection);
        
        
         for ($i = 1; $i < 3; $i++) {

        $q2 = "SELECT id_father FROM documentos WHERE id_father = '$id_return' And categoria='$i'";
        $r2 = mysqli_query($conection, $q2);
        $num2 = mysqli_num_rows($r2);

        if ($num2 == 0) {

            /*

              $q1 = "UPDATE documentos  SET id_contrato='$id_contrato[$j]', categoria='$i', status='1',data_periodo='$data_inicio_per[$j]'  WHERE id_pag='$id_pag[$j]'";
              $r1 = mysqli_query($conection, $q1);

              var_dump($i,$id_pag[$j].'<br>' );

             */
            $query1 = "INSERT INTO documentos(id_father,id_contrato,categoria,status,data_periodo) VALUES  ('$id_return', '$id_contrato','$i','1','$data_inicio_per')";
            $resultado1 = mysqli_query($conection, $query1);
      }
    }

        
    }
}


/*

while ($res = mysqli_fetch_array($r)) {

   
    $data_inicio_per= $res['data_inicio_per'];
  
    
    



    
    
      var_dump(  $data_inicio_per[$j] . "<br>");
      
        }

 $j++;
}*/








/*

$query = "SELECT * FROM  pagamentos Where id_contrato='174' ";
$result = mysqli_query($conection, $query);
while ($res = mysqli_fetch_array($result)) {

    $id_pag[$j] = $res['id_pag'];
    $data_inicio_per[$j] = $res['data_inicio_per'];
    $id_contrato[$j] = $res['id_contrato'];



    for ($i = 1; $i < 3; $i++) {



        $q = "SELECT id_pag FROM documentos WHERE id_pag = '$id_pag[$j]' AND categoria ='$i'";
        $r = mysqli_query($conection, $q);
        $num = mysqli_num_rows($r);

        if ($num == 0) {

            /*

              $q1 = "UPDATE documentos  SET id_contrato='$id_contrato[$j]', categoria='$i', status='1',data_periodo='$data_inicio_per[$j]'  WHERE id_pag='$id_pag[$j]'";
              $r1 = mysqli_query($conection, $q1);

              var_dump($i,$id_pag[$j].'<br>' );

             *//*
            $query1 = "INSERT INTO documentos(id_pag,id_contrato,categoria,status,data_periodo) VALUES  ('$id_pag[$j]', '$id_contrato[$j]','$i','1','$data_inicio_per[$j]')";
            $resultado1 = mysqli_query($conection, $query1);
  /*      }
    }

    $j++;
}*/
 /*
$query = "SELECT id_prestador, cnpj FROM  prestador ";
$result = mysqli_query($conection, $query);
  while ($res = mysqli_fetch_array($result)) {
      
      $id_prestador = $res['id_prestador'];
      $cnpj = $res['cnpj'];
      
        $q1 = "UPDATE local  SET  id_prestador='$id_prestador' WHERE cnpj='$cnpj'";
        $r1 = mysqli_query($conection, $q1);
 }
  */

/*
$query = "SELECT id_prestador, nome, cnpj, endereco  FROM  prestador ";
$result = mysqli_query($conection, $query);
  while ($res = mysqli_fetch_array($result)) {
      
      $nome = $res['nome'];
      $endereco = $res['endereco'];
      $id_prestador = $res['id_prestador'];
      $cnpj = $res['cnpj'];
      
        $q1 = "UPDATE local  SET lugar_regional='$nome',endereco='$endereco', cnpj='$cnpj'  WHERE id_prestador='$id_prestador'";
        $r1 = mysqli_query($conection, $q1);
 }
  */