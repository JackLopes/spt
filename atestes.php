<?php
session_start();
require_once 'database_gac.php';
require_once 'Funcoes/func_data.php';
require_once 'valida_permissao.php';



if (!empty(filter_input(INPUT_GET, 'rg', FILTER_VALIDATE_INT)) ||  !empty( filter_input(INPUT_GET, 'nome', FILTER_SANITIZE_STRING)) AND empty(filter_input(INPUT_GET, 'verif', FILTER_SANITIZE_STRING))) {

    $mes_pesquisa = filter_input(INPUT_GET, 'mes_pesquisa', FILTER_SANITIZE_STRING);
    $ano_pesquisa = filter_input(INPUT_GET, 'ano_pesquisa', FILTER_SANITIZE_STRING);
    $pesquisa = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
    $rg = filter_input(INPUT_GET, 'rg', FILTER_VALIDATE_INT);
    $nome = filter_input(INPUT_GET, 'nome', FILTER_SANITIZE_STRING);
   
}  else if (filter_input(INPUT_GET, 'verif', FILTER_SANITIZE_STRING)) {
    $nome = filter_input(INPUT_GET, 'nome', FILTER_SANITIZE_STRING);
    $verif = filter_input(INPUT_GET, 'verif', FILTER_SANITIZE_STRING);
} 
 else if (!empty(filter_input(INPUT_POST, 'rg', FILTER_VALIDATE_INT)) || !empty(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING)) AND empty(filter_input(INPUT_GET, 'verif', FILTER_SANITIZE_STRING)  ) ) {

    $mes_pesquisa = filter_input(INPUT_POST, 'mes_pesquisa', FILTER_SANITIZE_STRING);
    $ano_pesquisa = filter_input(INPUT_POST, 'ano_pesquisa', FILTER_SANITIZE_STRING);
    $pesquisa = filter_input(INPUT_POST, 'pesquisa', FILTER_SANITIZE_STRING);
    $rg = filter_input(INPUT_POST, 'rg', FILTER_VALIDATE_INT);
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
}




if (!empty($rg) AND $rg!='') {

    $query7 = "SELECT id_contrato FROM contrato WHERE rg='$rg'";
    $result = mysqli_query($conection, $query7)or die('Não foi possivel conectar ao MySQL');
    while ($registro = mysqli_fetch_array($result)) {
        $id_contrato = $registro['id_contrato'];
    }
}


$page_title = '';
$assunt = "<font style='color: #df7700 ;'><i class='fab fa-cc-visa'></i></font> Controle do Processo de Liberação de Pagamentos";

$me = date('m');
$me1 = (int) $me - 1;

$an = date('Y');
?>

<!doctype html>
<html lang="pt">

    <head>
        <title>Controle Notas</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet"  type="text/css" href="css/styleateste.css" media="screen"/>
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <link rel="stylesheet" href="css/bootstrap.css" >  

        <style>

            .sec select{
                font-size:22px;
                height: 50px;
               
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
                border-radius: 15px;

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
                <form   style="background-color:#f8f9fa; margin-top: 20px; padding: 30px; border-radius: 20px;" action="atestes.php?action=pesquisa" method="post">
                    <div class="div1 form-row">	
                        <div class="form-group col-md-12">
                            <h5><i class="fab fa-sistrix"></i> PESQUISA DE LANÇAMENTOS :</h5>
                        </div>
                    </div>
                    <div class=" div1 form-row">	
                        <div class="form-group col-md-2">
                             <label class = "descri" for = "">SELECIONE O MÊS</label>
                            <select class="form-control"   id="cmes" name="mes_pesquisa">

                                <option selected><?php if (!empty($_POST['mes_pesquisa']) || !empty($_GET['mes_pesquisa'])) echo $mes_pesquisa; ?></option>  
                                <?php
                                $sql1 = "  SELECT  MONTH(data_inicio_per) AS mes   FROM pagamentos  GROUP BY MONTH(data_inicio_per)";
                                $resultado1 = mysqli_query($conection, $sql1);
                                While ($row1 = mysqli_fetch_assoc($resultado1)) {
                                    $mes = $row1['mes'];
                                    ?>
                                    <option value= "<?php echo $mes; ?>"><?php echo $mes; ?></option> 
                                <?php } ?>
                            </select>
                        </div>  
                        <div class=" form-group col-md-2" >
                             <label class = "descri" for = "">SELECIONE O ANO</label>
                            <select class=" form-control"   id="cano" name="ano_pesquisa">
                                <option selected><?php if (!empty($_POST['ano_pesquisa']) || !empty($_GET['ano_pesquisa'])) echo $ano_pesquisa; ?></option>  
                                <?php
                                $sql2 = "SELECT  YEAR(data_inicio_per)  AS ano   FROM pagamentos  GROUP BY YEAR(data_inicio_per)";
                                $resultado2 = mysqli_query($conection, $sql2);
                                While ($row2 = mysqli_fetch_assoc($resultado2)) {
                                    $ano = $row2['ano'];
                                    ?>
                                    <option value= "<?php echo $ano; ?>"><?php echo $ano; ?></option> 
                                <?php } ?>
                            </select>
                        </div>                      

                        <div class = " sec form-group col-md-2">
                            <label class = "descri" for = "">PESQUISA POR NOME</label>
                            <select  class=" sec custom-select custom-select mb-3" name="nome" >
                               <option selected><?php if (!empty($_POST['nome']) || !empty($_GET['nome'])) echo $nome; ?></option>  
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
                            <input class="form-control "  Type="text"   name="rg" id="crg"  value="<?php if (!empty($_POST['rg']) || !empty($_GET['rg'])) echo $rg; ?>"/>
                        </div>
                        <div    class="form-group col-md-2">
                            <input name="pesquisa"  type="hidden" value="pesquisa">
                            <input  id="b"  type="submit" class="btn btn-primary"  name="submit" value="Enviar"/>
                            <input type="hidden" name="submitted" value="TRUE" />
                            <a id="a"  class="btn btn-danger"  href="atestes.php">Default</a>
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
             //   pesquisa da unica
                  if (!empty($nome) AND ! empty($verif)) {
                       include_once 'teste_pesquisa_nome.php';
                    } else
               
                if (!empty($nome)) {

                   include_once 'teste_pesquisa.php';
                } else {
                   include_once 'teste_pesquisa1.php';
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
</html>







