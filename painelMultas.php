<?php
include_once './menu_invisivel.php';
require_once ('./inc/Config.inc.php');
require_once './Funcoes/func_data.php';
require 'database_gac.php';

$permissa = $_SESSION['permissao'];

$id_contrato = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$sql = "SELECT rg, valor_atual, percent_atrasoEntrega, percent_naoObjeto, percent_descumprimento, limiteParcial, limiteTotal FROM contrato WHERE  id_contrato = '$id_contrato' ";
$resultado = mysqli_query($conection, $sql)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado)) {

    $percent_atrasoEntrega = $registro['percent_atrasoEntrega'];
    $percent_naoObjeto = $registro['percent_naoObjeto'];
    $percent_descumprimento = $registro['percent_descumprimento'];
    $limiteParcial = $registro['limiteParcial'];
    $limiteTotal = $registro['limiteTotal'];
    $valor_atual = $registro['valor_atual'];
    $rg = $registro['rg'];
}

$assunt = "Incidências Gerais - $rg";
?>
<!doctype html>
<html lang="pt">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet"  type="text/css" href="css/stylpainelMulta.css" media="screen"/>	
        <link rel="stylesheet" href="css/bootstrap.css" >

        <style>
            li{
                margin-bottom: 6px;
                margin-top: 6px;
            }
            #forms{
                background-color:#e9ecef; 
                padding: 10px;
                padding-bottom: 20px;
                color:  #6c757d;
                margin-top: -15px;

            }
            #forms input{
                background-color: #f8f9fa; 

            }
            .nav a {

                margin-left: 10px;
                font-size: 16px;
                font-family: times new roman;

            }
            #naviselect a {

                margin-left: 10px;
                font-size: 31px;
                font-family: times new roman;

            }
            #nav{
                margin-left: -35px;
                margin-top: 30px;
            }

            table td{
                font-size: 18px;
            }

        </style>

    </head>
    <body>
        <?php require_once 'image_header6.php'; ?>
        <div  class=" container-fluid    "  >

            <div style="margin: auto;" class="col-md-11 mb-10"> 
                <div class="nav" id="nav">
                    <nav class="  navbar navbar-light ">                 

                        <a style=" border-radius: 5px;" class="btn btn-primary" href="idex.php?id=<?php echo $id_contrato ?>">RETORNAR</a>
                        <a style=" border-radius: 5px;" class="btn btn-primary" href="multaAtrasoItens.php?id=<?php echo $id_contrato ?>&id_itens=<?php echo $id_itens ?>&id_tipo=<?php echo $id_tipo ?>">RELATÓRIO</a>
                        <a style=" border-radius: 5px;" class="btn btn-primary" href="#" data-toggle="modal" data-target="#exampleModal">
                            PERCENTUAIS PARA CALCULO DE MULTA
                        </a>
                    </nav>
                </div>


                <p style="margin-left: 0px; margin-top: 40px;margin-bottom: 10px; background-color: #f8f9fa;"> </p>
                <?php
                if
                (isset($_SESSION['msg42'])) {
                    echo $_SESSION['msg42'];
                    unset($_SESSION['msg42']);
                }
                ?>

                <p style=" margin-bottom: -50px; margin-top: 40px ; background-color: #f8f9fa;">RESUMO GERAL  DE APLICAÇÃO DE PENALIDADES</p>
                <div  class="row" >   

                    <nav class=" col-md-2 d-none d-md-block  sidebar" style=" border-radius: 20px;margin-top: 70px; background-color: #e9ecef;">
                        <div class="sidebar-sticky">
                            <h5 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                                <span>OUTRAS INCIDÊNCIAS </span>
                            </h5>
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link btn btn-outline-warning" href="advertencia_supencao.php?id=<?php echo $id_contrato ?>">
                                        Advertência / Suspensão
                                    </a>
                                </li>

                            </ul>
                            <h5 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                                <span>INCIDÊNCIA MULTA </span>
                            </h5>
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link btn btn-outline-primary" href="atrasoMultasItens.php?id=<?php echo $id_contrato ?>">
                                        Atraso na Entrega do Objeto
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-outline-secondary" href="atrasoMultas.php?id=<?php echo $id_contrato ?>">
                                        Descumprimento de Cláusula
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a class="nav-link btn btn-outline-dark"  href="teste/index2.php?ids=<?php echo $id ?>">
                                        Não Entrega do Objeto
                                    </a>
                                </li> 


                                <li class="nav-item">
                                    <a class="nav-link btn btn-outline-success" href="cad_aditivos.php?id=<?php echo $id ?>&rg=<?php echo $rg ?>">
                                        Manutenção Preventiva
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link btn btn-outline-danger"  href="corretivaMultas.php?id=<?php echo $id_contrato ?>">
                                        Manutenção Corretiva
                                    </a>
                                </li> 
                            </ul>
                    </nav>

                    <main role="main" style="margin-top: 70px; " class="col-md-10 ml-sm-auto  px-2" >
                        <div  class="col-12" >
                            <div class="row">
                                <div class="col">
                                    <table  class="  table table-hover  bg-light"  >
                                        <thead class="thead-light ">
                                            <tr>
                                                <th colspan="2" >INFRAÇÃO</th>
                                                <th  >PREVISIONADO </th>                                        
                                                <th  >APLICADO </th>                                        
                                            </tr>
                                            <?php
                                            $A = 0;
                                            $D = 0;
                                            $C = 0;
                                            $C1 = 0;
                                            $B = 0;
                                            $ABCD = 0;
                                            $AD = 0;

                                            $sql = "SELECT SUM(subtotal) AS soma_subtotal FROM multa WHERE id_contrato = '$id_contrato' AND categoria='1' ";
                                            $result = mysqli_query($conection, $sql)or die('Não foi possivel conectar ao MySQL');
                                            while ($registro1 = mysqli_fetch_array($result)) {

                                                $D = $registro1['soma_subtotal'];
                                            }
                                            $sql2 = "SELECT SUM(subtotal) AS soma_subtotal FROM multa WHERE id_contrato = '$id_contrato' AND categoria='2' ";
                                            $result = mysqli_query($conection, $sql2)or die('Não foi possivel conectar ao MySQL');
                                            while ($registro2 = mysqli_fetch_array($result)) {

                                                $A = $registro2['soma_subtotal'];
                                            }
                                            $sq5 = "SELECT SUM(subtotal) AS soma_subtotal FROM multa WHERE id_contrato = '$id_contrato' AND categoria='5' ";
                                            $result = mysqli_query($conection, $sq5)or die('Não foi possivel conectar ao MySQL');
                                            while ($registro5 = mysqli_fetch_array($result)) {

                                                $C1 = $registro5['soma_subtotal'];
                                            }
                                            $sq = "SELECT SUM(subtotal) AS soma_subtotal FROM multa WHERE id_contrato = '$id_contrato'  ";
                                            $result = mysqli_query($conection, $sq)or die('Não foi possivel conectar ao MySQL');
                                            while ($registro = mysqli_fetch_array($result)) {

                                                $sub_corretiva = $registro['soma_subtotal'];
                                            }
                                            $sq = "SELECT SUM(valor_multa_aplicado) AS soma_valor_multa_aplicado FROM  historico_multa WHERE id_contrato = '$id_contrato' AND categoria='5'";
                                            $result = mysqli_query($conection, $sq)or die('Não foi possivel conectar ao MySQL');
                                            while ($registro = mysqli_fetch_array($result)) {

                                                $soma_multa_aplicado_corretiva = $registro['soma_valor_multa_aplicado'];
                                            }
                                            $sq = "SELECT SUM(valor_multa_aplicado) AS soma_valor_multa_aplicado FROM  historico_multa WHERE id_contrato = '$id_contrato'";
                                            $result = mysqli_query($conection, $sq)or die('Não foi possivel conectar ao MySQL');
                                            while ($registro = mysqli_fetch_array($result)) {

                                                $soma_total = $registro['soma_valor_multa_aplicado'];
                                            }
                                            $sq = "SELECT SUM(valor_multa_aplicado) AS soma_valor_multa_aplicado FROM  historico_multa WHERE id_contrato = '$id_contrato' AND categoria='1'";
                                            $result = mysqli_query($conection, $sq)or die('Não foi possivel conectar ao MySQL');
                                            while ($registro = mysqli_fetch_array($result)) {

                                                $soma_multa_aplicado_atraso_itens = $registro['soma_valor_multa_aplicado'];
                                            }
                                            $sq = "SELECT SUM(valor_multa_aplicado) AS soma_valor_multa_aplicado FROM  historico_multa WHERE id_contrato = '$id_contrato' AND categoria='6'";
                                            $result = mysqli_query($conection, $sq)or die('Não foi possivel conectar ao MySQL');
                                            while ($registro = mysqli_fetch_array($result)) {

                                                $soma_multa_descumprimento = $registro['soma_valor_multa_aplicado'];
                                            }
                                            $sq = "SELECT COUNT(siscor) AS advertencia FROM  historico_multa WHERE id_contrato = '$id_contrato' AND categoria ='3'";
                                            $result = mysqli_query($conection, $sq)or die('Não foi possivel conectar ao MySQL');
                                            while ($registro = mysqli_fetch_array($result)) {

                                                $advertencia = $registro['advertencia'];
                                            }

                                            //Calculo de  limitação parcial(Referência: valor atual do contrato)

                                            $valor_limitacao_pacial = $valor_atual * ($limiteParcial / 100);
                                            $valor_limitacao_pacial1 = number_format($valor_limitacao_pacial, 2, ',', '.');



                                            //Calculo de  limitação Total(Referência: valor atual do contrato)

                                            $valor_limitacao_total = $valor_atual * ($limiteTotal / 100);
                                            $valor_limitacao_total1 = number_format($valor_limitacao_total, 2, ',', '.');



                                            $soma_multa_descumprimento1 = number_format($soma_multa_descumprimento, 2, ',', '.');
                                            $soma_total1 = number_format($soma_total, 2, ',', '.');


                                            //Calculo de  Aplicação de multa
                                            //condição A e D
                                            // $A = 1;
                                            // $D = 2;
                                            $C = 0;
                                            $B = 0;
                                            // $B = 6000000;

                                            if (!empty($A) OR ! empty($D)) {

                                                $AD = $A + $D;

                                                if ($AD > $valor_limitacao_pacial) {

                                                    $AD = $valor_limitacao_pacial;
                                                }
                                            }

                                            //condição A + B + C + D


                                            if (!empty($A) OR ! empty($B)OR ! empty($C) OR ! empty($C1)OR ! empty($D)) {

                                                $ABCD = $AD + $B + $C + $C1;

                                                if ($ABCD > $valor_limitacao_total) {

                                                    $ABCD = $valor_limitacao_total;
                                                }
                                            }
                                            ?>
                                        </thead>     
                                        <tbody>
                                            <tr><td></td><td>Advertência</td><td><?php echo $advertencia; ?></td><td></td></tr>
                                            <tr><td></td><td>Suspenção</td><td><?php echo '0'; ?></td><td></td></tr>                           
                                            <tr><td class=" text-primary">A</td><td>Atraso na Entrega do Objeto</td><td class=""><?php echo "R$ " . number_format($A, 2, ',', '.'); ?></td><td><?php echo "R$ " . number_format($soma_multa_aplicado_atraso_itens, 2, ',', '.'); ?></td></tr>
                                            <tr><td  >B</td><td>Não Entrega do Objeto</td><td class=""><?php echo "R$ " . $B; ?></td><td></td></tr>                           
                                            <tr><td class=" text-success" >C</td><td>NS (Manutenção Preventiva)</td><td class=""><?php echo "R$ " . $C; ?></td><td></td></tr>
                                            <tr><td class=" text-danger" >C</td><td>NS (Manutenção Corretiva)</td><td class=""><?php echo "R$ " . number_format($C1, 2, ',', '.'); ?></td><td><?php echo "R$ " . number_format($soma_multa_aplicado_corretiva, 2, ',', '.'); ?></td></tr>
                                            <tr><td  >D</td><td>Descumprimento de Cláusula</td><td class=""><?php echo "R$ " . $soma_multa_descumprimento1; ?></td><td></td></tr>
                                            <tr><td></td><td><strong>TOTAL</strong></td><td><strong><?php echo "R$ " . $sub_corretiva; ?></strong></td><td></td></tr>
                                        </tbody>

                                    </table>

                                </div>
                                <div class="col-12">
                                    <table  class=" table table-hover  bg-light"  >
                                        <thead class="thead-light ">
                                            <tr>
                                                <th colspan="2" >LIMITAÇÕES</th>
                                                <th  ></th>                                        
                                            </tr>
                                        </thead>
                                        <tr><td>Limite de Aplicação Parcial</td><td>A ou  D</td><td class="numer"><?php echo 'R$ ' . $valor_limitacao_pacial1 ?></td></tr>
                                        <tr><td>Limite de Aplicação Total</td><td>A + B + C + D</td><td class="numer"><?php echo 'R$ ' . $valor_limitacao_total1 ?></td></tr>
                                    </table>
                                    <table  class="  table table-hover  bg-light"  >
                                        <thead class="thead-light ">
                                            <tr>
                                                <th style=" font-size: 20px;">VALOR ACUMULADO PARA MULTA</th>
                                                <th style=" font-size: 20px;" ></th>                                        
                                            </tr>
                                        </thead>
                                        <tr><td class=""></td><td  ><?php echo 'R$ ' . $soma_total1 ?></td></tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">CADASTRO DOS PERCENTUAIS</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form  class=" updates needs-validation "   action="proc_atu_percentuais.php"  method="post" novalidate>         

                            <div class="form-row">	
                                <div class="form-group col-md-12">
                                    <label for="address">Atraso na Entrega do Objeto:</label>

                                    <input type="text" class="form-control" name="percent_atrasoEntrega" value="<?php echo $percent_atrasoEntrega; ?>" >
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="address">Não Entrega Do Objeto:</label>
                                    <input type="text" class="form-control" name="percent_naoObjeto" value="<?php echo $percent_naoObjeto; ?>" >
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="address">Descumprimento de Cláusula :</label>
                                    <input type="text" class="form-control"  name="percent_descumprimento" value="<?php echo $percent_descumprimento; ?>" >
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="address">Limite Parcial:</label>
                                    <input type="text" class="form-control" name="limiteParcial" value="<?php echo $limiteParcial; ?>" >
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="address">Limite Total :</label>
                                    <input type="text" class="form-control" name="limiteTotal" value="<?php echo $limiteTotal; ?>" >
                                </div>
                                <input name="id_contrato" type="hidden" value=<?php echo $id_contrato; ?>>
                            </div>
                            <input  class="btn btn-outline-primary" type="submit" name="Prosseguir" value="ENVIAR"  class="btn btn-primary">

                        </form>
                    </div>

                </div>
            </div>
        </div>
        <script src="js/jquery-3.2.1.slim.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script defer src="js/fontawesome-all.min.js"></script>
    </body>
</html>