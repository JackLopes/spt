<?php



$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$id_severidade = filter_input(INPUT_GET, 'id_severidade', FILTER_SANITIZE_NUMBER_INT);
$id_local = filter_input(INPUT_GET, 'id_local', FILTER_SANITIZE_NUMBER_INT);
$id_resp = filter_input(INPUT_GET, 'id_resp', FILTER_VALIDATE_INT);
$id_prorrogs = filter_input(INPUT_GET, 'id_prorrog', FILTER_VALIDATE_INT);



require_once 'database_gac.php';

 if (!empty($id_prorrogs)){

 $result = "DELETE FROM historico_prorrogacao  WHERE id_prorrog='$id_prorrogs'";
  mysqli_query($conection, $result);


 } else if (!empty($id_severidade)){
 $result = "DELETE FROM severidades  WHERE id_severidade='$id_severidade'"; 
 mysqli_query($conection, $result);


 }
  
  header("Location:idex.php?id=$id");
  
  