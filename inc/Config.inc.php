<?php

//Credenciais de acesso ao BD
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DBNAME', 'gac');

function __autoload($Class){
    $dirName = 'class';
    
if(file_exists("{$dirName}/{$Class}.class.php")):
    require("{$dirName}/{$Class}.class.php");
else:
    die("Classe {$Class}.class.php não encontrada");
endif;        
}

$url_host = filter_input(INPUT_SERVER, 'HTTP_HOST');
define('pg', "http://$url_host/sp/");

