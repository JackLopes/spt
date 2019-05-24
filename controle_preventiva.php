<?php
session_start();
require_once 'database_gac.php';
require_once 'Funcoes/func_data.php';
require_once 'valida_permissao.php';

if (!empty(filter_input(INPUT_GET, 'rg', FILTER_VALIDATE_INT))) {
    $rg = filter_input(INPUT_GET, 'rg', FILTER_VALIDATE_INT);
} else {
    $rg = filter_input(INPUT_POST, 'rg', FILTER_VALIDATE_INT);
}
if (!empty(filter_input(INPUT_GET, 'nome', FILTER_SANITIZE_STRING))) {
    $nome = filter_input(INPUT_GET, 'nome', FILTER_SANITIZE_STRING);
} else {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
}






//$rg = '62242';
//$nome = 'Jackson Silva Lopes';

if (empty($nome)) {
    $nome1 = '';
} else {
    $nome1 = " $nome";
}
if (empty($rg)) {
    $rg1 = '';
} else {
    $rg1 = "RG: $rg";
}

$page_title = '';
$assunt = "<font style='color: #df7700 ; '><i class='fas fa-wrench'></i></font> Controle do Processo de Aplicação de Penalidade (Manutenção Preventiva)<p style='margin-left:50px;font-family:times new roman';> $nome1 </p><p>$rg1</p>";

$me = date('m');
$me1 = (int) $me - 1;

$an = date('Y');
?>

<!doctype html>
<html lang="pt">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet"  type="text/css" href="css/styleateste.css" media="screen"/>
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <link rel="stylesheet" href="css/bootstrap.css" >  

        <style>

            .sec select{
                font-size:22px;
                height: 50px;
                color:#007bff;
            }
            .sec input{
                font-size:22px;
                height: 50px;


            }
            label{
                font-size: 23px;             
                font-family:  times new romam;
                color: #6c757d; 
                font-weight: bold;

            }
            input{
                font-size:22px;
                height: 50px;
                font-size: 23px;       
            }

            #a {
                font-size: 23px;             
                font-family:  times new romam;
                margin-top: 40px;

            }
            #b {
                font-size: 23px;             
                font-family:  times new romam;
                margin-top: 40px;

            }
            .tb34{

            }
            .set1{
                font-size: 20px;
                font-family: times new romam;
                text-align: center;
                font-weight: bold;
                color:#007bff;

            }
        </style>

    </head>
    <body>
    
        <?php
        include './header_controle.php';
        require_once 'image_header6.php';
        ;
        ?>

        <div  class=" container-fluid    " >

            <div class="form-group col-md-12">
                <form   style="background-color:#f8f9fa; margin-top: 20px;" action="controle_preventiva.php?action=pesquisa" method="post">
                    <div class="div1 form-row">	
                        <div class="form-group col-md-12">
                            <h5><i class="fab fa-sistrix"></i> PESQUISA DE LANÇAMENTOS :</h5>
                        </div>
                    </div>
                    <div class=" div1 form-row">	


                        <div class = " sec form-group col-md-2">
                            <label class = "descri" for = "">PESQUISA POR NOME</label>
                            <select  class=" sec custom-select custom-select mb-3" name="nome" >
                                <option></option>  
                                <?php
                                $q1 = "SELECT nome FROM  responsaveis WHERE responsabilidade = 'Fiscal Administrativo'GROUP BY(nome)";
                                $r1 = mysqli_query($conection, $q1);
                                while ($row = mysqli_fetch_assoc($r1)) {
                                    ?>
                                    <option value ="<?php echo $row ['nome']; ?>"><?php echo $row ['nome']; ?></option>
                                <?php } ?>
                            </select>

                        </div>
                        <div class="form-group col-md-2">
                            <label for="crg" ><strong>PESQUISA POR RG:</strong></label>			 
                            <input class="form-control "  Type="text"   name="rg" id="crg"  />
                        </div>
                        <div    class="form-group col-md-2">
                            <input name="pesquisa"  type="hidden" value="pesquisa">


                            <input  id="b"  type="submit" class="btn btn-primary"  name="submit" value="Enviar"/>
                            <input type="hidden" name="submitted" value="TRUE" />
                            <a id="a"  class="btn btn-danger"  href="controle_corretiva.php">Default</a>
                        </div>
                    </div>            
                </form>
            </div>  
            <div class="form-group col-md-12">

                <div class=" message ">	

                    <?php
                    if (isset($_SESSION['msg28'])) {
                        echo $_SESSION['msg28'];
                        unset($_SESSION['msg28']);
                    }
                    ?>

                </div> 
                <?php
                if (!empty($rg) || !empty($nome)) {

                    include_once 'control_preventiva_rg_nome.php';
                } else {
                    include_once 'control_preventiva_geral.php';
                }
                ?>
            </div>
        </div>
    </body>

    <script>

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

    </script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script defer src="js/fontawesome-all.min.js"></script>
    <script>
                                        $(function () {
                                            setTimeout(function () {
                                                location.reload();
                                            }, 180000); // 3 * 60 * 1000
                                        });
 </script>
</html>







