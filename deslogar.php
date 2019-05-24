<?php
session_start();

if(isset($_SESSION['status'] )){
    // se você possui algum cookie relacionado com o login deve ser removido
    session_destroy();
    header("location: login.php");
    exit();
}

var_dump($_SESSION['status']);