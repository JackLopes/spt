
<?php
$rg = filter_input(INPUT_POST, 'rg', FILTER_VALIDATE_INT);
require_once 'menu.php';

require_once 'database_gac.php';
//   $path = "//Vboxsvr/media/grupos-bsa-sede/SUPGA/06_GACCD/02 GACAD/Contratos/Contratos Ativos/NOVASISTEMAS/RG_58079/autuados";
//$path = str_replace("/","\\",$path);
//var_dump($path);

$assunt = "Documentos Autuados Armazenados na Rede - RG: $rg";
?>



<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="css/bootstrap.css" > 
        <link rel="stylesheet"  type="text/css" href="css/styleide.css" media="screen"/>
        <style>

            .form1{
                margin-top: 30px;
                margin-bottom: 30px;

            }




        </style>   


    </head>


    <body>
<?php

require_once 'image_header6.php';
//var_dump($segundos, $limite);

if (!empty($rg)) {

    $sql = "SELECT pasta FROM contrato WHERE rg ='$rg'";
    $result = mysqli_query($conection, $sql)or die('Não foi possivel conectar ao MySQL');
    $num = mysqli_num_rows($result);



    if ($num == 1) {


        $sqlcorre = "SELECT pasta FROM contrato WHERE rg ='$rg'";
        $resultado = mysqli_query($conection, $sqlcorre)or die('Não foi possivel conectar ao MySQL');
        while ($registro = mysqli_fetch_array($resultado)) {

            $path = $registro['pasta'];

            $_SESSION['msg59'] = "<span style='color:green;'>Lista dos Arquivos RG: $rg</span>";
        }

        $path = str_replace("\\", "/", $path);
    } else {

        $_SESSION['msg59'] = "<span style='color:red;'>Caminho da pasta não encontrado !</span>";
    }
}
?>   

        <div class="container-fluid">
            <div class="row">
                <div class="col">

                    <form   style="background-color:#f8f9fa; margin-top: 20px;" action="upload.php" method="post">
                        <div class="div1 form-row">	
                            <div class="form-group col-md-12">
                                <h5><i class="fab fa-sistrix"></i> PESQUISA POR CONTRATOS:</h5>
                            </div>
                        </div>
                        <div class=" div1 form-row">	                       
                            <div class="form-group col-md-2">
                                <label for="crg" ><strong>DIGITE O RG:</strong></label>			 
                                <input class="form-control "  Type="text"   name="rg" id="crg"  />
                            </div>
                            <div  style=" margin-top: 30px;"  class="form-group col-md-2">
                                <input name="pesquisa"  type="hidden" value="pesquisa">


                                <input   id="b"  type="submit" class="btn btn-primary"  name="submit" value="Enviar"/>
                                <input type="hidden" name="submitted" value="TRUE" />

                            </div>
                        </div>            
                    </form>
                </div>
                <div class="col">

                    <form class=" form-inline" style="background-color:#f8f9fa; margin-top: 20px;" action="upload_recebe.php" enctype="multipart/form-data" method="POST">

                        <div class="form-row">
                            <div class="form-group col-md-12  mb-3" >
                                <label for="staticEmail2" class="sr-only"> Enviar o arquivo:</label>
                                <input type="file" name="arquivo" class="form-control-file" id="exampleFormControlFile1">
                            </div>
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-primary mb-2">Enviar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div>


<?php
if (!empty($_SESSION['msg59'])) {

    echo $_SESSION['msg59'];

    unset($_SESSION['msg59']);
}
?> 

<?php
// $path = "//Vboxsvr/media/grupos-bsa-sede/SUPGA/06_GACCD/02 GACAD/Contratos/Contratos Ativos/NOVASISTEMAS/RG_58079/autuados";
if (!empty($rg) and $num > 0) {
    $diretorio = dir($path);

//echo "Lista de Arquivos do diretório '<strong>".$path."</strong>':<br />";
    while ($arquivo = $diretorio->read()) {
        $arqui[] = $arquivo;



//echo "<a href='".$path.$arquivo."'>".$arquivo."</a><br />";
    }
    sort($arqui);



    foreach ($arqui as $key => $val) {
        // echo "Arquivo[" . $key . "] = " . $val . "\n";
        if (strlen($val) > 3) {

            echo "<div class='container'><ul class='list-group'>"
            . "<li class='list-group-item'><a href='" . $path . $val . "'>" . $val . "</a></li></ul></div>";
        }
    }


    $diretorio->close();
}
?>

            </div>

            <script src = "js/popper.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <script defer src="js/fontawesome-all.min.js"></script>

    </body>
</html>

