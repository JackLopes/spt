
<?php

function saudacoes($nome) {

date_default_timezone_set('America/Sao_Paulo'); 
  
$hora = date('G');


if (($hora >= 0) AND ($hora < 6)) {
$mensagem = "Boa madrugada!!! " . $nome;
} else if (($hora >= 6) AND ($hora < 12)) {
$mensagem = "Bom dia!!! " . $nome;
} else if (($hora >= 12) AND ($hora < 18)) {
$mensagem = "Boa tarde!!! " . $nome;
} else {
$mensagem = "Boa noite!!!" . $nome;
}

return $mensagem;
  }

  

$nom = $_SESSION['nome'] ;
$nom1= explode(" ",$nom );

$nom2= $nom1[0];



?>

