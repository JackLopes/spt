<?php

require_once ('./inc/Config.inc.php');

$seguranca = true;

$url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_STRING);


?>
<!DOCTYPE html>
<html lang="pt-br">
    <?php
    $file = $url.'.php';
    if(file_exists($file)){
        include $file;
    }else{
        $url_destino = pg."login";
        header("Location: $url_destino");
    }    
    ?>
</html>
