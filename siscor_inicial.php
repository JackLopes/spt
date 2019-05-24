
<?php
session_start();


if ($_SESSION['status'] != 'LOGADO') {
    header("Location: login.php");
}

$page_title = 'Relatórios';


$an = date('Y');

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
}

if (isset($_GET['rg'])) {
    $rg = (int) $_GET['rg'];
}

if (isset($_GET['nom'])) {
    $nom = $_GET['nom'];
}



if (isset($_SESSION['dados2'])) {

    $id = $_SESSION['dados2']['id'];
    $rg = $_SESSION['dados2']['rg'];
    $nom = $_SESSION['dados2']['nom'];
    $mes = $_SESSION['dados2']['mes'];
    $ano = $_SESSION['dados2']['ano'];
}

if (isset($_SESSION['dados'])) {

    $id = $_SESSION['dados']['id'];
    $rg = $_SESSION['dados']['rg'];
    $nom = $_SESSION['dados']['prestador'];
    $mes = $_SESSION['dados']['mes'];
    $ano = $_SESSION['dados']['ano'];
}
require_once 'database_gac.php';
?>				

<!doctype html>
<html lang="pt">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet"  type="text/css" href="css/styleans.css" media="screen"/>
        <link rel="stylesheet" href="css/bootstrap.css" >
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <script defer src="js/fontawesome-all.min.js"></script>

        <title><?php echo $page_title; ?></title>




    </head>
    <body  style="background-color: #cfcfcf;">
        <nav class="navbar navbar-light bg-light">
            <a class="navbar-brand" href="idex.php?id=<?php echo $id; ?>">RETORNAR  </a>
            <img src="img/serpro5.jpg" width="30" height="30" class="d-inline-block align-top" style="padding-right:5px" alt="">
            </a>
        </nav>
        <div  class="container" ></br></br>
            <center><div class="col-md-8 order-md-1">
                    <h4 class="mb-3"><i class="fas fa-edit"></i> Texto Para SISCOR de Iniciação de Contrato </h4>
                    <hr class="mb-4">

                    <form  id= "fmr" action="texto_siscor_inicial.php" method="post">
                        <div class="row"  >

                            <div class="col-sm-8 " >	
                                <label >TIPO DE OBJETO: </label>        
                                <select class="custom-select" name="tipo_siscorInitial" id="caplicacao_multa"  >
                          
                                                    
                                        <option ></option>
                                        <option value="1">Aquisição de Fitas-LTO</option>
                                        <option value="3">Serviços De Manutenção Corretiva e Preventiva</option>                                                           
                                    </select> 

                                </select>
                            </div>



                            <div class="col-sm-3 " style="margin-top: 30px;">
                                <input type="submit" class="btn btn-danger" style="color: #cfcfcf; text-shadow:1px 1px 3px black"  name="submit" value="GERAR MODELO"/>
                            </div>

                            <input Type="hidden" name="id" size="15" maxlength="20"  value="<?php echo $id; ?>" /></p>
                            <input Type="hidden" name="rg" size="15" maxlength="40" value="<?php echo $rg; ?>" /></p>
                            <input Type="hidden" name="nom" size="15" maxlength="40" value="<?php echo $nom; ?>" /></p>
                            <input Type="hidden" name="id_local" size="15" maxlength="40" value="<?php echo $id_local; ?>" /></p>
                        </div>
                    </form>


                </div>




                </body>
                <?php unset($_SESSION['dados2']); ?>
                <?php unset($_SESSION['dados']); ?>
                </html>
