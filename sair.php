<?php

session_start();
unset($_SESSION['id'], $_SESSION['nome'], $_SESSION['email'],  $_SESSION['permissao'], $_SESSION['matricula'], $_SESSION['status']);

if(isset($_SESSION['LOGADO'])){
   
    session_destroy();
    

}

header("Location: login.php");