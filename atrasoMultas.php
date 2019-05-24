<?php
include 'menu.php';
require_once ('./inc/Config.inc.php');
require_once './Funcoes/func_data.php';
require 'database_gac.php';

$permissa = $_SESSION['permissao'];

$id_contrato = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$sql = "SELECT percent_atrasoEntrega, percent_naoObjeto, percent_descumprimento, valor_Contratado,id_prestador , rg  FROM contrato WHERE  id_contrato = '$id_contrato' ";
$resultado = mysqli_query($conection, $sql)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado)) {
//55764848 17093
    $percent_atrasoEntrega = $registro['percent_atrasoEntrega'];
    $percent_naoObjeto = $registro['percent_naoObjeto'];
    $percent_descumprimento = $registro['percent_descumprimento'];
    $valor_Contratado = $registro['valor_Contratado'];
    $id_prestador = $registro['id_prestador'];
    $rg = $registro['rg'];
}
$assunt = "Descrumprimento de Cláusula Contratual - RG $rg";
?>
<!doctype html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet"  type="text/css" href="css/stylmultas.css" media="screen"/>	
        <link rel="stylesheet" href="css/bootstrap.css" >
        <?php require_once './Funcoes/mask_valor.php'; ?>
        <style>
            .Assunt{
                position:absolute;
                margin-top: -130px;
                margin-left: 50px;
                color:white;
                font-size: 200%;

            }
            .format{color: black;
                    margin-left:10px;

            }
            .btns{
                margin-top: 30px;
            }
            .nav a {

                margin-left: 10px;

            }
            .nav  {

                margin-left: -25px;
                margin-bottom: 10px;
            }
            .coment{
                background-color: #6c757d;
                margin-top: 40px;
                color: white;
                padding-left: 5px; 
                padding: 3px;
            }
            #envi{
                margin-top: 30px;
            }
            .tb2{
                margin-top: -16px;
            }

            #forms{
                background-color:#e9ecef; 
                padding: 10px;
                padding-bottom: 30px;
                color:  #6c757d;
                margin-top: -15px;

            }
            #forms input{
                background-color: #f8f9fa; 

            }
            .more label{
                color:#007bff;
                margin-top:  15px;
            }
            .more input{
                background-color:#f8f9fa;
            }
            .more textarea{
                background-color:#f8f9fa;
            }
            .moti label{
                margin-top: 10px;
            }
        </style>
        <script>
            var mask = {
                money: function () {
                    var el = this
                            , exec = function (v) {
                                v = v.replace(/\D/g, "");
                                v = new String(Number(v));
                                var len = v.length;
                                if (1 == len)
                                    v = v.replace(/(\d)/, "0.0$1");
                                else if (2 == len)
                                    v = v.replace(/(\d)/, "0.$1");
                                else if (len > 2) {
                                    v = v.replace(/(\d{2})$/, '.$1');
                                }
                                return v;
                            };

                    setTimeout(function () {
                        el.value = exec(el.value);
                    }, 1);
                }

            }
            $(function () {
                $('#campovalor').bind('keypress', mask.money);
                $('#campovalor').bind('keyup', mask.money);
            });
        </script>	
    </head>
    <body>
        <?php require_once 'image_header6.php'; ?>
        <div  class=" container-fluid    "  style="margin-top: 30px">
            <div class="col-md-10 order-md-1"style="margin:auto">
                <div>
                    <div class="nav" id="nav">
                        <nav  style=" margin-top: 30px;" class="navbar navbar-light">                 
                            <a class="btn btn-primary" href="painelMultas.php?id=<?php echo $id_contrato ?>">RETORNAR</a>
                        </nav>
                    </div>
                    <span style=" position: absolute;"><?php echo'Valor Atual Contratado: ' . 'R$ ' . number_format($valor_Contratado, 2, ',', '.'); ?></span>
                    <p class="coment" >CADASTRO DA OCORRÊNCIA PARA POSSIVEL APLICAÇÃO DE MULTA </p>
                    <form class="needs-validation"  id="forms" action="atu_confirma_multa.php?action=descumprimento"  method="post" novalidate>
                        <div class=" moti col-md-12 mb-10">  

                            <div class=" row" >
                                <div class="  col-md-12 mb-10">
                                    <label for="cmotivacao">Motivação:</label>
                                       <p style=" font-size: 13px;">Utilize ponto-virgula ( ; ) ao invés de ponto ( . ) no final de cada paragrafo*</p>
                                    <textarea class="form-control "  id="exampleFormControlTextarea1"  name="motivacao" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="row" >
                                <div class="col-md-3 mb-10">
                                    <label for="creferencia">Referência (R$):</label>
                                    <input type="text" class="form-control" id="campovalor" name="referencia"  >
                                </div>
                            </div>
                            <div class="row" >
                                <div class="col-md-12 mb-10">                         

                                    <label for="creferencia">Contatos:</label><hr  style=" margin-top: -10px">  
                                    <p style=" font-size: 13px;">Pressione Ctrl para selecionar mais de uma opção*</p>
                                    <input type="hidden" name="id_colaborado" />
                                    <select class="slMultiple custom-select" multiple="multiple" name="id_colaborado[]" >
                                        <?php
                                        $sqlcolaborador = "SELECT * FROM colaborador WHERE id_presta='$id_prestador'";
                                        $resultado = mysqli_query($conection, $sqlcolaborador)or die('Não foi possivel conectar ao MySQL');
                                        while ($registro = mysqli_fetch_assoc($resultado)) {

                                            $id_colaborado = $registro['id_colaborador'];
                                            $nome = $registro['nome'];
                                            ?>
                                            <option  value="<?php echo $id_colaborado; ?>"><?php echo $nome; ?></option>  		
                                        <?php } ?>
                                    </select>  

                                </div>
                               
                                    <div class = "col-md-1 mb-10">
                                        <input name = "id_contrato" type = "hidden" value = <?php echo $id_contrato; ?>>                               
                                        <input type="hidden" name="submitted" value="TRUE" />
                                        <button type="submit" style = " margin-top: 31px;" class="btn btn-primary">Cadastrar</button>
                                    </div>
                               
                            </div>
                    </form>
                </div>
                <div>
                    <?php
                    if
                    (isset($_SESSION['msg23'])) {
                        echo $_SESSION['msg23'];
                        unset($_SESSION['msg23']);
                    }
                    ?>
                </div> 
                <div> 
                    <p class="coment">HISTÓRICO DE LANÇAMENTOS</p>

                    <table  class=" tb2 table table-hover table-striped table-sm table-bordered bg-light"  >
                        <thead class="thead-dark ">
                            <tr>
                                <th scope="col"></th>                         
                                <th scope="col">Siscor</th>                         
                                <th scope="col">Referência</th>                         
                                <th scope="col">Valor Multa</th>                   
                                <th scope="col">Informação do Processo</th>
                                <th scope="col">Status</th>
                                <th scope="col">Excluir</th>
                                <th scope="col">Atualizar</th>
                            </tr>
                        </thead>
                        <?php
                        $mult1 = "SELECT * FROM  historico_multa WHERE id_contrato = '$id_contrato' AND categoria= '6' ";
                        $result1 = mysqli_query($conection, $mult1)or die('Não foi possivel conectar ao MySQL');
                        while ($registro = mysqli_fetch_array($result1)) {
                            $siscor = $registro['siscor'];
                            $clausula = $registro['clausula'];
                            $referencia = $registro['referencia'];
                            $valor_multa = $registro['valor_multa_aplicado'];
                            $motivacao = $registro['motivacao'];
                            $status = $registro['status'];
                            $id_histmulta = $registro['id_histmulta'];
                            if (!empty($motivacao)) {
                                $motivacao = 'Detalhes';
                            }
                            ?>
                            <tr>
                                <td ><a  href="multaDescumprimento.php?id=<?php echo $id_contrato ?>&id_histmulta=<?php echo $id_histmulta ?>"><center><i class="far fa-file"></i></center></a></td>
                                <td ><?php echo $siscor ?></td>
                                <td ><?php echo $referencia ?></td>
                                <td  ><?php echo $valor_multa; ?></td>                            
                                <td><a  data-toggle="modal" href="#" data-target="#exampleModal1<?php echo $id_histmulta ?>" ><center><?php echo $motivacao ?></center</a></td>
                                <td  ><a  href="#"  data-toggle="modal" data-target="#regModal<?php echo $id_multa ?>">
                                        <?php echo $status; ?>
                                    </a></td>
                                <td><a id="a2" data-toggle="modal" href="#" data-target="#exampleModal<?php echo $res['id_histmulta'] ?>" ><i class="fas fa-eraser"></i></a></td>
                                <td><a id="a2" href="atu_usuario.php?id_usuario=<?php echo $registro1['id_histmulta'] ?>"> <i class="far fa-edit"></i></a></td>
                            </tr>
                            <!-- Modal Exclusao -->
                            <div class="modal fade" id="exampleModal1<?php echo $id_histmulta ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">DESCUMPRIMENTO CLAÚSULA</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="needs-validation"   action="atu_confirma_multa.php?action=descumprimento_update"  method="post" novalidate>
                                                <div class="more col-md-12 mb-10">  
                                                    <div class="row" >
                                                        <div class="col-md-12 mb-10">
                                                            <label for="cclausula">STATUS :</label>
                                                            <select class="custom-select" name="status" id="ctipo_infracao"  >
                                                                <option selected></option>
                                                                <option value="1">Em Processo</option>
                                                                <option value="3">Aplicada</option>                                                           
                                                            </select>                             
                                                        </div> 
                                                    </div>
                                                    <div class="row" >
                                                        <div class="col-md-12 mb-10">
                                                            <label for="cclausula">SISCOR :</label>
                                                            <input class="form-control "  id="exampleFormControlTextarea1"  name="siscor" value="<?php if (isset($siscor)) echo $siscor; ?>">                                
                                                        </div> 
                                                    </div>
                                                    <div class="row" >
                                                        <div class="col-md-12 mb-10">
                                                            <label for="creferencia">REFERÊNCIA  (R$):</label>
                                                            <input type="text" class="form-control" id="campovalor" name="referencia" value="<?php if (isset($referencia)) echo $referencia ?>" >
                                                        </div>
                                                    </div>
                                                    <div class="row" >
                                                        <div class="col-md-12 mb-10">
                                                            <label for="creferencia">VALOR DA MULTA  (R$):</label>
                                                            <input type="text" class="form-control" id="campovalor" name="valor_multa" value="<?php if (isset($valor_multa)) echo $valor_multa ?>" >
                                                        </div>
                                                    </div>
                                                    <div class="row" >
                                                        <div class="col-md-12 mb-10">
                                                            <label for="cclausula">CLAÚSULA CONTRATUAL VIOLADA:</label>
                                                            <p><b>Texto pre-formatado, favor atualiza-lo conforme contrato em questão, pois este será utilizado na confecção do relátorio.</b></p>
                                                            <textarea class="form-control "  id="exampleFormControlTextarea1"  name="clausula" rows="20"><?php echo $clausula; ?></textarea>                                
                                                        </div>
                                                    </div>
                                                    <div class="row" >
                                                        <div class=" moti col-md-12 mb-10">
                                                            <label for="cmotivacao">MOTIVAÇÃO :</label>
                                                            <textarea class="form-control "  id="exampleFormControlTextarea1"     name="motivacao" rows="20"><?php if (isset($registro['motivacao'])) echo $registro['motivacao']; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row" >
                                                        <div class=" moti col-md-12 mb-10">
                                                            <label for="cmotivacao">DETALHES DO PROCESSO :</label>
                                                            <textarea class="form-control "  id="exampleFormControlTextarea1"  name="det_processo" rows="20"><?php if (isset($registro['det_processo'])) echo $registro['det_processo']; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 mb-10"style=" margin-top: 31px;">
                                                        <input name="id_contrato" type="hidden" value=<?php echo $id_contrato ?>>                               
                                                        <input name="id_histmulta" type="hidden" value=<?php echo $id_histmulta ?>>                               
                                                        <input type="hidden" name="submitted" value="TRUE" />
                                                        <button type="submit" class="btn btn-primary">Atualizar</button>
                                                    </div>
                                                </div>

                                            </form>

                                        </div>                             
                                        <div class="modal-footer">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </table>
                </div>

            </div>
        </div>            
        <script src="js/jquery-3.2.1.slim.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script defer src="js/fontawesome-all.min.js"></script>
    </body>
</html>