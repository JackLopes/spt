<?php
$cep = "55324-424";

if(!preg_match('/^[0-9]{5,5}([- ]?[0-9]{3,3})?$/', $cep)) {
  echo "CEP inválido.";
}
?>