<?php

$rgs = filter_input(INPUT_POST, 'rgs', FILTER_SANITIZE_STRING);



  require_once 'database_gac.php';

             
                    
               
                    
                    $rg = mysqli_real_escape_string($conection, trim($_POST['rgs']));

                    $sqlcontrato = "SELECT * FROM contrato WHERE rg = '$rg'";
                    $resultado = mysqli_query($conection, $sqlcontrato)or die('Não foi possivel conectar ao MySQL');
                    $num = mysqli_num_rows($resultado);
                    if ($num == 0) { 
                                        
                       
                       
                             header("Location: lista_geral.php?result=result&rg=$rg");
                            
                             
                          
                        
                    } else { 
                        
                         

                        while ($reg = mysqli_fetch_array($resultado)) {
                              $id_contrato =  $reg['id_contrato'];
                            
                           header("Location: idex.php?id=$id_contrato");
                        }
                    }
               