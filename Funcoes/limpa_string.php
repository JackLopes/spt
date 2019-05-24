<?php

function limpa($string){
     
    $string_l = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $string ) );
     $string_m =  strtolower($string_l);
     $string_limpa = ucwords($string_m);
    
    return $string_limpa;
}

