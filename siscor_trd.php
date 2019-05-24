
<?php
session_start();


if ($_SESSION['status'] != 'LOGADO') {
    header("Location: login.php");
}

$page_title = 'Relatórios';


$an = date('Y');

$id = (int) filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$rg = filter_input(INPUT_GET, 'rg', FILTER_SANITIZE_STRING);
$nom = filter_input(INPUT_GET, 'nom', FILTER_SANITIZE_STRING);


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
    $mes = $_SESSION['dados']['mes'];
    $ano1 = $_SESSION['dados']['ano'];
}


if (isset($_SESSION['dados']['mes'])) {
    $mes1 = (int) $_SESSION['dados']['mes'];
}
if (isset($_SESSION['dados']['ano'])) {
    $ano1 = (int) $_SESSION['dados']['ano'];
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
        <style>
            #for4{
                position: absolute;
                margin-left: 40px;
            }
        </style>
    </head>
    <body  style="background-color: #cfcfcf;">
        <nav class="navbar navbar-light bg-light">
            <a class="navbar-brand" href="idex.php?id=<?php echo $id; ?>">RETORNAR  </a>
            <img src="img/serpro5.jpg" width="30" height="30" class="d-inline-block align-top" style="padding-right:5px" alt="">
            </a>
        </nav>
        <div  class="container" ></br></br>
            <center><div class="col-md-8 order-md-1">
                    <h4 class="mb-3"><i class="fas fa-edit"></i> Texto Para SISCOR do Termo De Recebimento  Definitivo e Relatórios </h4>
                    <hr class="mb-4">
                    <div class="row"  >
                        <form  id= "fmr" action="texto_siscor_trd.php"  method="post">
                            <div class="row"  >

                                <div class="col-sm-3 " >	

                                    <select class="custom-select"name="regio_id" id="caplicacao_multa"  >
                                        <option selected>REGIONAL</option> 
                                        <?php
                                        $q1 = "SELECT loc.*, tip.id_tipo, tip.tipos
                                    FROM local as loc
                                    INNER JOIN tipo as tip ON tip.id_local=loc.id_local
                                    WHERE id_contrato = '$id' GROUP BY sigla";
                                        $r1 = mysqli_query($conection, $q1);
                                        while ($row = mysqli_fetch_assoc($r1)) {

                                            //$id_local = $row['id_local'];
                                            ?>
                                            <option  value="<?php echo $row['sigla']; ?>&<?php echo $row['id_local']; ?>"><?php echo $row['sigla']; ?></option>  		
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-3 " >	
                                    <select class="form-control"   id="cmes" name="mes">

                                        <option selected>MÊS</option>  
                                        <?php
                                        $sql1 = "  SELECT  mes_ref  FROM corretivas WHERE  id_contrato = '$id' GROUP BY (mes_ref )";
                                        $resultado1 = mysqli_query($conection, $sql1);
                                        While ($row1 = mysqli_fetch_assoc($resultado1)) {
                                            $mes = $row1['mes_ref'];
                                            ?>

                                            <option value= "<?php echo $mes; ?>"><?php echo $mes; ?></option> 


                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-3 ">
                                    <select class="form-control"   id="cano" name="ano">
                                        <option selected>ANO</option>  
                                        <?php
                                        $sql = "  SELECT  YEAR(data_conclusao) AS ano  FROM corretivas WHERE  id_contrato ='$id'GROUP BY YEAR(data_conclusao)";

                                        $resultado = mysqli_query($conection, $sql);
                                        While ($row = mysqli_fetch_assoc($resultado)) {
                                            $ano = $row['ano'];
                                            ?>

                                            <option value= "<?php echo $row['ano']; ?>"><?php echo $ano; ?></option> 	

                                        <?php } ?>
                                    </select>

                                    <input Type="hidden" name="id" size="15" maxlength="20"  value="<?php echo $id; ?>" /></p>
                                    <input Type="hidden" name="rg" size="15" maxlength="40" value="<?php echo $rg; ?>" /></p>
                                    <input Type="hidden" name="nom" size="15" maxlength="40" value="<?php echo $nom; ?>" /></p>
                                    <input Type="hidden" name="id_local" size="15" maxlength="40" value="<?php echo $id_local; ?>" /></p>
                                </div>
                                <div class="col-sm-3 ">
                                    <input type="submit" class="btn btn-danger" style="color: #cfcfcf; text-shadow:1px 1px 3px black"  name="submit" value="GERAR MODELO"/>
                                </div>
                                <br><br>
                            </div>
                        </form>
                        <?php
                        if (!empty($mes1) AND ! empty($ano1)) {

                            //  action="atestes.php?action=pesquisa"

                            $sqlnota = "SELECT * FROM pagamentos WHERE id_contrato='$id' AND MONTH(data_inicio_per)='$mes1' AND YEAR(data_fim_per)= '$ano1'";
                            $resultados = mysqli_query($conection, $sqlnota)or die('Não foi possivel conectar ao MySQL');
                            while ($registro5 = mysqli_fetch_assoc($resultados)) {


                                $inicial = $registro5['data_inicio_per'];
                                $final = $registro5['data_fim_per'];
                            }
                            ?>

                            <a  id= "for4" class="btn btn-outline-warning my-2 my-sm-0" href="#" onclick="window.open('atestes.php?action=pesquisa&inicial=<?php echo $inicial ?>&final=<?php echo $final ?>&rg=<?php echo $rg ?> ', 'popup3', 'width=1300,height=800,scrolling=auto,top=0,left=0')">SISCOR</a>

                        <?php } ?>

                    </div>
                </div>




                </body>
                <?php unset($_SESSION['dados2']); ?>
                <?php unset($_SESSION['dados']); ?>
                </html>
