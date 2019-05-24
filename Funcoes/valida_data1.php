
<?php


function ValidaData($dat){
	$data = explode("-","$dat"); // fatia a string $dat em pedados, usando / como referência
	$d = $data[0];
	$m = $data[1];
	$y = $data[2];
 
	// verifica se a data é válida!
	// 1 = true (válida)
	// 0 = false (inválida)
	
	$res = checkdate($m,$d,$y);

	if ($res != 1){
	return 'data inválida';}
	
        
        
}

/*
$datas = '30/02/2002';
//Exemplo de chamada a função
if (isset($datas)){
$erro = array();


if ( ValidaData($datas) == 'data inválida'){
   $erro[] = 'Digite uma data valida.';
   
}



  echo '<h2>Atenção!</h2>
    <p class="error">Ficaram as seguintes pendencias:<br />';
    foreach ($erro as $mg)
    echo " - $mg<br>\n ";
    echo '</p><p>Por favor, refaça os preenchimentos.</p><p><br/ ></p>';
  
    
     exit();}*/
     
    