
session_start();

<?php
require_once 'database_gac.php';

$status = $_POST['status'];
$id_chat = $_POST['id_chat'];


if (!empty($_POST['id_chat'])) {


    $query = "UPDATE chat SET  status='$status' WHERE id_chat='$id_chat'";
    $result = mysqli_query($conection, $query);
   
    var_dump($result);
    



    if ($result) {
        $_SESSION['msg28'] = "<p style='color:green;'>Atualização efetuada  com sucesso </p>";
        header("Location: lista_chat.php");
    } else {
        $_SESSION['msg28'] = $_SESSION['voce'] . "<p style='color:red;'> Falha ao tentar atualizar registro</p>";
        header("Location: lista_chat.php");
    }
} else {
    $_SESSION['msg28'] . "<p style='color:red;'> Necessário Atualizar Registro</p>";
    header("Location: lista_chat.php");
}
			
			
	
	

   