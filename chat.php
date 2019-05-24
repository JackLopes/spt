<?php
$page_title = 'Mensagens';
include 'menu.php';
require_once 'database_gac.php';
$assunt = '<a  href="lista_chat.php" target="_blank" ><i class="far fa-question-circle"></i> Canal de Sugetões</a>';
$message = filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_STRING);

$nom = ($_SESSION['nome']);
$data9 = date('Y-m-d H:i:s');




$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$_SESSION['dados'] = $dados;



if (!empty($message)) {

    $q1 = "INSERT INTO chat (mensagem, pseudo, data) VALUES ('$message', '$nom',  '$data9') ";
    $r1 = mysqli_query($conection, $q1);
}
?>

<!doctype html>
<html lang="pt">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">			
        <link rel="stylesheet"  type="text/css" href="css/stylelist.css" media="screen"/>
    </head>
    <body>
        <?php include_once 'image_header5.php' ?>
        <div  class="container " >
            <form class="form form-control" action="chat.php" method="post">

                <div class="form-group">
                    <label for="cmensagem">Edite Sua Dúvida:</label>
                    <input class="form-control" type="text" name="mensagem"  id="cmensagem">
                    <link rel="stylesheet" href="css/bootstrap.css" >
                </div>
                <input type="submit" value="ENVIAR" class="btn btn-primary btn-sm btn-block"  />     
            </form>
            <br/>
            <div>
                <?php
                $q1 = "SELECT * FROM chat ORDER BY id_chat DESC LIMIT 10";
                $reponse = mysqli_query($conection, $q1);
                while ($donnees = mysqli_fetch_array($reponse)) {
                    ?>
                    <div class="list-group">
                        <a  class="list-group-item list-group-item-action flex-column align-items-start ">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1"><?php echo'<span style="color:#0080FF" >' . strtoupper($donnees['pseudo']) . '</span>'; ?></h5>
                                <small><?php echo $donnees['data']; ?></small>
                            </div>
                            <p class="mb-1"><?php echo $donnees['mensagem']; ?></p>
                        </a> 
                    </div>
    <?php
}
?>
            </div>   
        </div>
    </body>               
</html>