<?php

$id_contrato = (int)filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

var_dump($id_contrato);




require_once 'database_gac.php';


$j = 0;

//script para teste de criação de lista.

$q = "SELECT * FROM  contrato Where id_contrato='$id_contrato' ";
$r = mysqli_query($conection, $q);
$num = mysqli_num_rows($r);

var_dump($num);

while ($res = mysqli_fetch_array($r)) {

    $d_Assinatura = $res['d_Assinatura'];
    $id_contrato = $res['id_contrato'];
     $pex = explode("-", $d_Assinatura);
    $data_inicio_per="$pex[1]/$pex[0]";


    $q1 = "SELECT * FROM documents_father WHERE categoria ='SISCOR INICIAL' AND periodo ='$data_inicio_per' AND id_contrato = '$id_contrato'";
    $r1 = mysqli_query($conection, $q1);
    $num1 = mysqli_num_rows($r1);

    if ($num1 == 0) {


        $query1 = "INSERT INTO documents_father(ordem,categoria,status,periodo,id_contrato) VALUES  ('1','SISCOR INICIAL', '1','$data_inicio_per','$id_contrato')";
        $resultado1 = mysqli_query($conection, $query1); 
                $id_return = mysqli_insert_id($conection);

          for ($i = 5; $i < 6; $i++) {

        $q2 = "SELECT id_father FROM documentos WHERE id_father = '$id_return' And categoria='$i'";
        $r2 = mysqli_query($conection, $q2);
        $num2 = mysqli_num_rows($r2);

        if ($num2 == 0) {

           

             // $q1 = "UPDATE documentos  SET id_contrato='$id_contrato[$j]', categoria='$i', status='1',data_periodo='$data_inicio_per[$j]'  WHERE id_pag='$id_pag[$j]'";
             // $r1 = mysqli_query($conection, $q1);

            //  var_dump($i,$id_pag[$j].'<br>' );

            
            $query1 = "INSERT INTO documentos(id_father,id_contrato,categoria,status,data_periodo) VALUES  ('$id_return', '$id_contrato','$i','1','$data_inicio_per')";
            $resultado1 = mysqli_query($conection, $query1);
      }
    }
        
   
        
    }
}




/*
$j = 0;

//script para teste de criação de lista.

$q = "SELECT * FROM  pagamentos Where id_contrato='$id_contrato' group by (data_inicio_per) ";
$r = mysqli_query($conection, $q);
$num = mysqli_num_rows($r);

var_dump($num);

while ($res = mysqli_fetch_array($r)) {

    $data_inicio_per = $res['data_inicio_per'];
    $pex = explode("-", $data_inicio_per);
    $data_inicio_per="$pex[1]/$pex[0]";
    
    
    
    $id_contrato = $res['id_contrato'];


    $q1 = "SELECT * FROM documents_father WHERE  categoria ='ANS' AND periodo ='$data_inicio_per' AND id_contrato = '$id_contrato'";
    $r1 = mysqli_query($conection, $q1);
    $num1 = mysqli_num_rows($r1);

    if ($num1 == 0) {


        $query1 = "INSERT INTO documents_father(ordem,categoria,status,periodo,id_contrato) VALUES  ('4','ANS', '1','$data_inicio_per','$id_contrato')";
        $resultado1 = mysqli_query($conection, $query1);
        var_dump($data_inicio_per . "<br>");

        $id_return = mysqli_insert_id($conection);
        
        
         for ($i = 1; $i < 3; $i++) {

        $q2 = "SELECT id_father FROM documentos WHERE id_father = '$id_return' And categoria='$i'";
        $r2 = mysqli_query($conection, $q2);
        $num2 = mysqli_num_rows($r2);

        if ($num2 == 0) {

           

             // $q1 = "UPDATE documentos  SET id_contrato='$id_contrato[$j]', categoria='$i', status='1',data_periodo='$data_inicio_per[$j]'  WHERE id_pag='$id_pag[$j]'";
             // $r1 = mysqli_query($conection, $q1);

            //  var_dump($i,$id_pag[$j].'<br>' );

            
            $query1 = "INSERT INTO documentos(id_father,id_contrato,categoria,status,data_periodo) VALUES  ('$id_return', '$id_contrato','$i','1','$data_inicio_per')";
            $resultado1 = mysqli_query($conection, $query1);
      }
    }

        
    }
}

$j = 0;

//script para teste de criação de lista.

$q = "SELECT * FROM  pagamentos Where id_contrato='$id_contrato' group by (data_inicio_per) ";
$r = mysqli_query($conection, $q);
$num = mysqli_num_rows($r);

var_dump($num);

while ($res = mysqli_fetch_array($r)) {

    $data_inicio_per = $res['data_inicio_per'];
    $id_contrato = $res['id_contrato'];
     $pex = explode("-", $data_inicio_per);
    $data_inicio_per="$pex[1]/$pex[0]";


    $q1 = "SELECT * FROM documents_father WHERE categoria ='TRD' AND periodo ='$data_inicio_per' AND id_contrato = '$id_contrato'";
    $r1 = mysqli_query($conection, $q1);
    $num1 = mysqli_num_rows($r1);

    if ($num1 == 0) {


        $query1 = "INSERT INTO documents_father(ordem,categoria,status,periodo,id_contrato) VALUES  ('3','TRD', '1','$data_inicio_per','$id_contrato')";
        $resultado1 = mysqli_query($conection, $query1); 
                $id_return = mysqli_insert_id($conection);

          for ($i = 3; $i < 4; $i++) {

        $q2 = "SELECT id_father FROM documentos WHERE id_father = '$id_return' And categoria='$i'";
        $r2 = mysqli_query($conection, $q2);
        $num2 = mysqli_num_rows($r2);

        if ($num2 == 0) {

           

             // $q1 = "UPDATE documentos  SET id_contrato='$id_contrato[$j]', categoria='$i', status='1',data_periodo='$data_inicio_per[$j]'  WHERE id_pag='$id_pag[$j]'";
             // $r1 = mysqli_query($conection, $q1);

            //  var_dump($i,$id_pag[$j].'<br>' );

            
            $query1 = "INSERT INTO documentos(id_father,id_contrato,categoria,status,data_periodo) VALUES  ('$id_return', '$id_contrato','$i','1','$data_inicio_per')";
            $resultado1 = mysqli_query($conection, $query1);
      }
    }
        
   
        
    }
}


$j = 0;

//script para teste de criação de lista.

$q = "SELECT * FROM  contrato Where id_contrato='$id_contrato' ";
$r = mysqli_query($conection, $q);
$num = mysqli_num_rows($r);

var_dump($num);

while ($res = mysqli_fetch_array($r)) {

    $d_Assinatura = $res['d_Assinatura'];
    $id_contrato = $res['id_contrato'];
     $pex = explode("-", $d_Assinatura);
    $data_inicio_per="$pex[1]/$pex[0]";


    $q1 = "SELECT * FROM documents_father WHERE categoria ='ATA' AND periodo ='$data_inicio_per' AND id_contrato = '$id_contrato'";
    $r1 = mysqli_query($conection, $q1);
    $num1 = mysqli_num_rows($r1);

    if ($num1 == 0) {


        $query1 = "INSERT INTO documents_father(ordem,categoria,status,periodo,id_contrato) VALUES  ('2','ATA', '1','$data_inicio_per','$id_contrato')";
        $resultado1 = mysqli_query($conection, $query1); 
                $id_return = mysqli_insert_id($conection);

          for ($i = 4; $i < 5; $i++) {

        $q2 = "SELECT id_father FROM documentos WHERE id_father = '$id_return' And categoria='$i'";
        $r2 = mysqli_query($conection, $q2);
        $num2 = mysqli_num_rows($r2);

        if ($num2 == 0) {

           

             // $q1 = "UPDATE documentos  SET id_contrato='$id_contrato[$j]', categoria='$i', status='1',data_periodo='$data_inicio_per[$j]'  WHERE id_pag='$id_pag[$j]'";
             // $r1 = mysqli_query($conection, $q1);

            //  var_dump($i,$id_pag[$j].'<br>' );

            
            $query1 = "INSERT INTO documentos(id_father,id_contrato,categoria,status,data_periodo) VALUES  ('$id_return', '$id_contrato','$i','1','$data_inicio_per')";
            $resultado1 = mysqli_query($conection, $query1);
      }
    }
        
   
        
    }
}








*/



header("Location: previ.php?id=$id_contrato");