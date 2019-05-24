<?php


$path = "//Vboxsvr/media/grupos-bsa-sede/SUPGA/06_GACCD/02 GACAD/Contratos/Contratos Ativos/NOVASISTEMAS/RG 58079/teste";
$diretorio = dir($path);

//echo "Lista de Arquivos do diretório '<strong>".$path."</strong>':<br />";
while($arquivo = $diretorio -> read()){
  $arqui[] =$arquivo;
    
 
    
//echo "<a href='".$path.$arquivo."'>".$arquivo."</a><br />";
}
 sort($arqui);
 
foreach ($arqui as $key => $val) {
   // echo "Arquivo[" . $key . "] = " . $val . "\n";
    echo "<a href='".$path.$val."'>".$val."</a><br />";
}


$diretorio -> close();


