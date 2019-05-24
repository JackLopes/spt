


<?php

 session_start();

 $permissa = $_SESSION['permissao'];

require_once 'database_gac.php';

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$id_user = filter_input(INPUT_POST, 'id_usuario', FILTER_SANITIZE_STRING);
$id_user2 = filter_input(INPUT_POST, 'id_usuario2', FILTER_SANITIZE_STRING);
$id_user3 = filter_input(INPUT_POST, 'id_usuario3', FILTER_SANITIZE_STRING);

if ( $permissa < '4') {  
if (isset($_POST['submitted'])) {

 
    $q = "UPDATE contrato SET   gestor_tecnico='$id_user', gestor_tecnico_2='$id_user2',fiscal_administrativo='$id_user3' WHERE id_contrato='$id' ";
    $r = mysqli_query($conection, $q);



    if ($q) {
        $_SESSION['msg23'] = "<p style='color:green;'>Atualização efetuada  com sucesso !!!</p>";
        header("Location: idex.php?id=$id");
    } else {
        $_SESSION['msg23'] =  "<p style='color:red;'> Falha ao tentar atualizar registro</p>";
        header("Location: idex.php?id=$id");
    }
} else {
    $_SESSION['msg23'] . "<p style='color:red;'> Necessário Atualizar Registro</p>";
        header("Location: idex.php?id=$id");
}
}else {
            
             $_SESSION['msg23'] = "<p style='color:red;'> Você não tem permissão para cadastrar registro</p>";
          header("Location: idex.php?id=$id");
       
}






mysqli_close($conection);
exit();
