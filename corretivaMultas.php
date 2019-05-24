<?php
include_once './menu_invisivel.php';
require_once ('./inc/Config.inc.php');
require_once './Funcoes/func_data.php';
require 'database_gac.php';

$permissa = $_SESSION['permissao'];

$id_contrato = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$id_tipo = filter_input(INPUT_GET, 'id_tipo', FILTER_SANITIZE_NUMBER_INT);

$sql = "SELECT percent_atrasoEntrega, percent_naoObjeto, percent_descumprimento, rg ,id_prestador FROM contrato WHERE  id_contrato = '$id_contrato' ";
$resultado = mysqli_query($conection, $sql)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado)) {

    $percent_atrasoEntrega = $registro['percent_atrasoEntrega'];
    $percent_naoObjeto = $registro['percent_naoObjeto'];
    $percent_descumprimento = $registro['percent_descumprimento'];
    $rg = $registro['rg'];
    $id_prestador = $registro['id_prestador'];
}
$query = "SELECT tip.* , loc.id_contrato, loc.sigla, cont.tip_chamado, 
				cont.rg, loc.lugar_regional				
				FROM tipo AS tip
				INNER JOIN local AS loc ON  loc.id_local = tip.id_local
				INNER JOIN  contrato AS cont ON  cont.id_contrato = loc.id_contrato
				WHERE loc.id_contrato = '$id_contrato'";

$resultado = mysqli_query($conection, $query)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado)) {

    $id_tipo = $registro['id_tipo'];
}


require_once './Funcoes/calculo_multas.php';
$assunt = " Descumprimento de SLA de Manutenção Corretiva - RG $rg";
?>
<!doctype html>
<html lang="pt">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet"  type="text/css" href="css/stylpainelMulta.css" media="screen"/>	
        <link rel="stylesheet" href="css/bootstrap.css" >
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <script defer src="js/fontawesome-all.min.js"></script>
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
                font-size: 20px;
                font-family: times new roman;
            }

            #forms{
                background-color:#e9ecef; 
                padding: 10px;
                padding-bottom: 40px;
                color:  #6c757d;
                margin-top: -15px;
                font-size: 23px;
                font-family: times new roman


            }
            #forms input{
                background-color: #f8f9fa; 
                font-size: 23px;
                font-weight: bold;

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
            
            $(function () {
                $('#campvalor1').bind('keypress', mask.money);
                $('#campvalor1').bind('keyup', mask.money);
            });

        </script>		

    </head>
    <body>
        <?php require_once 'image_header6.php'; ?>
        <div  class=" container-fluid    "  style="margin-top: 30px">
            <div class="form-group col-md-12">
                <div class="nav">
                    <nav class="navbar navbar-light bg-light">   
                   
                        <a class="btn btn-primary" href="painelMultas.php?id=<?php echo $id_contrato ?>">PAINEL MULTAS</a>
                        <a class="btn btn-primary" href="multaAtrasoItens.php?id=<?php echo $id_contrato ?>&id_itens=<?php echo $id_itens ?>&id_tipo=<?php echo $id_tipo ?>">RELATÓRIO</a>
                        <select  class="custom-select btn-outline-dark"  style="width: 500px;background-color: #007bff; color:#ffffff; margin-left:8px;"  onchange="location = this.value;">
                            <option id="selected" selected>PAINEL DE CONTROLE - SELECIONE A REGIONAL</option> 
                            <?php
                            $an = date('Y');

                            $q1 = "SELECT loc.*, tip.id_tipo, tip.tipos
                                    FROM local as loc
                                    INNER JOIN tipo as tip ON tip.id_local=loc.id_local
                                    WHERE id_contrato = '$id_contrato'";
                            $r1 = mysqli_query($conection, $q1);
                            while ($row = mysqli_fetch_assoc($r1)) {
                                $tipos = ucwords(strtolower($row['tipos']));
                                ?>

                                <option  value="cad_corretiva.php?id_tipo=<?php echo $row['id_tipo']; ?>"><?php echo $row['lugar_regional'] . " - Grupo de " . $tipos; ?></option>  		

                            <?php } ?>
                        </select>


                    </nav>
                </div>

                <p class="coment">OCORRÊNCIAS PASSIVEIS DE MULTAS</p>
                <table  class=" tb2 table table-hover table-striped table-sm table-bordered bg-light"   >
                    <thead class="thead-dark ">
                        <tr>

                            <th  scope="col">Nº Chamado</th>
                            <th scope="col">Regional</th>
                            <th scope="col">Patrimonio</th>
                            <th scope="col">Crítica</th>
                            <th scope="col"colspan="2" class="text-center" >Abertura</th>
                            <th scope="col"colspan="2" class="text-center" >Atendimento</th>
                            <th scope="col"colspan="2"  class="text-center" >Conclusão</th>
                            <th scope="col">Prazo Atendimento</th>
                            <th scope="col">Utilizado Atendimento</th>
                            <th scope="col">Prazo de Conclusão</th> 
                            <th scope="col">Utilizado Conclusão</th>
                            <th   style="background-color: #B22222;">T. Horas Excedentes </th> 
                            <th scope="col">Taxa</th>
                            <th scope="col">Referência</th>
                            <th scope="col" >Valor da Multa</th>
                            <th scope="col" class="text-center">Status</th>
                        </tr> 
                    </thead>
                    <?php
                    $sqlcorre = "SELECT * FROM multa WHERE id_contrato = '$id_contrato' AND categoria='5' ORDER BY (data_conclusao) ASC";
                    $resultado = mysqli_query($conection, $sqlcorre)or die('Não foi possivel conectar ao MySQL');
                    while ($registro = mysqli_fetch_array($resultado)) {
                        $id_multa = $registro['id_multa'];
                        $data1 = $registro['data_abertura'];
                        $data1 = inverteData($data1);

                        $data2 = $registro['data_atendimento'];
                        $data2 = inverteData($data2);


                        $data3 = $registro['data_conclusao'];
                        $data3 = inverteData($data3);

                        $id_corretiva = $registro['id_corretiva'];

                        $patrimonio = $registro['n_patrimonio'];
                        $status = $registro['status'];

                        $status = $registro['status'];
                        $parametro_multa = (int)$registro['parametro_multa'];
                        
                        if($parametro_multa == 5){
                            $ref = "TOTAL MENSAL <font style='color:#df7700'>(SOMA DE TODAS REGIONAIS)</font>";
                        } else {
                            $ref = 'TOTAL MENSAL DA REGIONAL';
                        }


                        if ($status == 1) {
                            $status = "<font style='color:green'>Incluido</font>";
                        } else if ($status == 3) {
                            $status = "<font style='color:blue'>Aplicada</font>";
                        } else {
                            $status = "<font style='color:red'>Incluir</font>";
                        }
                        ?>
                        <tr>

                            <td class = "td2" ><?php echo $parametro_multa; ?></td>
                            <td class = "td2" ><?php echo $registro['regional']; ?></td>
                            <td class = "td2" ><?php echo $registro['n_patrimonio']; ?></td>
                            <td class = "td2" ><?php echo $registro['tipo_severidade']; ?></td>
                            <td class = "td2" ><?php echo $data1; ?></td>
                            <td class = "td2" ><?php echo $registro['hora_abertura']; ?></td>
                            <td class = "td2" ><?php echo $data2; ?></td>
                            <td class = "td2" ><?php echo $registro['hora_atendimento']; ?></td>
                            <td class = "td2" ><?php echo $data3; ?></td>
                            <td class = "td2" ><?php echo $registro['hora_conclusao']; ?></td>
                            <td class = "td2" ><?php echo $registro['prazo_atendimento']; ?></td>
                            <td class = "td2" ><?php echo $registro['subtotal_atendimento']; ?></td>
                            <td class = "td2" ><?php echo $registro['prazo_conclusao']; ?></td>       
                            <td class = "td2" ><?php echo $registro['subtotal_conclusao']; ?></td>
                            <td class = "td2" ><?php echo $registro['total']; ?></td>
                            <td class = "td2" > <?php echo $registro['taxa']; ?> </td>
                            <td class = "td2" ><?php if($parametro_multa == 5 || $parametro_multa == 6 ){ ?><a data-toggle="modal" href="#" data-target=" #exampleModal3<?php echo $id_corretiva ?>"> Referência
                                    
                                </a><?php } else  { echo $registro['referencia']; }?></td>
                            <td style=" font-size: 25px; font-weight: bold;color: red;" ><?php echo number_format($registro['subtotal'], 2, ',', '.'); ?></td>
                            <!-- Permissão -->
                            <td class="text-center" ><a  href="#"  data-toggle="modal" data-target="#exampleModal<?php echo $id_multa ?>">
                                    <?php echo $status; ?>
                                </a></td>

                            <!--Permissão -->
                        </tr>
                        <div class="modal fade"  id="exampleModal3<?php echo $id_corretiva ?>"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"id="exampleModalLabel" text="center" ><font color='#0080FF'><?php echo "PATRIMONIO:" . $registro['n_patrimonio']; ?></font></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="needs-validation"  id="fm6" action="calc_multas.php?action=corr" method="post" novalidate>
                                           
                                            <div class="col-md-12 mb-3">
                                                
                                           	  <label class="mods1"  >INCLUA O <?php echo $ref ?></label>		 
                                                  <input type="text" class="form-control" id="campvalor1" name="valor_regional"  >
                                             </div> 
                                                <div class="col-md-3 mb-10">
                                                    <input name="id_corretiva" type="hidden" value=<?php echo $id_corretiva ?>>
                                                   
                                                    <input name="id_contrato" type="hidden" value=<?php echo $id_contrato ?>>
                                                    <input name="patrimonio" type="hidden" value=<?php echo $patrimonio ?>>
                                                    <input type="hidden" name="submitted" value="TRUE" />	
                                                    <button type="submit" class="btn btn-warning">Enviar</button>
                                                </div>	
                                            </div>
                                    </div>
                                    </form>
                                </div>	 
                            </div>
                        </div>
                        <?php if ($status != "<font style='color:blue'>Multa Aplicada</font>") { ?>

                            <!-- Modal status-->
                            <div class="modal fade"  id="exampleModal<?php echo $id_multa ?>"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Confirmar Aplicação da Multa</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <form class="needs-validation"  id="fm6"  action="atu_confirma_multa.php?action=corretivaMultas" method="post" novalidate>


                                                <div class="row">
                                                    <div class="col-md-9 mb-10">
                                                        <label class="mods1" for="cstatus" >Aplicar Multa?</label>
                                                        <select class="custom-select" name="status" >
                                                            <option selected>Selecione</option>
                                                            <option value="1">Sim</option>
                                                            <option value="2">Não</option>                                                           
                                                        </select>
                                                    </div> 
                                                    <div class=" btns col-md-2 mb-10"> 
                                                        <input name="id_contrato" type="hidden" value=<?php echo $id_contrato; ?>>                                     

                                                        <input name="id_multa" type="hidden" value=<?php echo $id_multa; ?>>

                                                        <input name="valor_multa" type="hidden" value=<?php echo $registro['subtotal']; ?>>
                                                        <input name="categoria" type="hidden" value='5'>
                                                        <input name="id_tipo" type="hidden" value=<?php echo $id_tipo; ?>>
                                                        <input id="envi" type="submit" name="submit" value="ENVIAR"   class="btn btn-primary" /></center><p>

                                                    </div> 
                                                </div> 

                                            </form>
                                        </div> 
                                    </div> 
                                </div>       
                            </div>

                        <?php } ?>
                        <?php
                    }
                    ?>
                </table>
                <div>
                    <?php
                    if
                    (isset($_SESSION['msg23'])) {
                        echo $_SESSION['msg23'];
                        unset($_SESSION['msg23']);
                    }
                    ?>
                    <div> 
                        <p class="coment" >CADASTRO DA SOMATÓRIA PARA POSSIVEL APLICAÇÃO DE MULTA</p>
                        <form class="needs-validation"  id="forms"  action="atu_confirma_multa.php?action=inclusaoMulta" method="post" novalidate>
                            <div class="row">
                                <div class="col-md-3 mb-10">
                                    <label class="mods1"  >TOTAL PREVISTO ATUAL:</label>
                                    <input Type="text" class="form-control "  value="<?php echo "R$ " . number_format($soma_corretiva, 2, ',', '.'); ?>"  disabled/>
                                </div> 
                                <div class="col-md-3 mb-10">
                                    <label class="mods1"  >TOTAL JÁ APLICADO:</label>
                                    <input Type="text" class="form-control "  value="<?php echo"R$ " . number_format($total_aplicado_corretiva, 2, ',', '.'); ?>"  disabled/>
                                </div> 
                                <div class="col-md-3 mb-10">
                                    <label class="mods1"  >LIMITE MÁXIMO PARA APLICAÇÃO:</label>
                                    <input Type="text" class="form-control "   value="<?php echo "R$ " . number_format($valor_max_aplicavel_corretiva, 2, ',', '.') ?>"  disabled/>
                                </div> 

                                <div class="col-md-3 mb-10">
                                    <label class="mods1" for="cvalor_multa_aplicado" > CALCULADO PARA APLICAÇÃO :</label>
                                    <input Type="text" class="form-control "  name="valor_multa_aplicado"    value="<?php echo "R$ " . number_format($soma_corretiva_maxima, 2, ',', '.') ?>" "  disabled/>
                                </div> 

                            </div> 
                            <div class="row" style="margin-top:10px;" >
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
                            </div>
                            <div style=" margin-top: 11px;" class="row">
                                <div class="col-md-11 mb-10">
                                    <label class="mods1" for="cobservacao" >OBSERVAÇÃO:</label>
                                    <input Type="text" class="form-control"  name="observacao"  >
                                </div>
                                <div class=" btns col-md-1 mb-10"> 
                                    <input name="id_contrato" type="hidden" value=<?php echo $id_contrato; ?>>
                                    <input name="categoria" type="hidden" value='5'>
                                    <input name="valor_multa_aplicado" type="hidden" value=<?php echo $soma_corretiva_maxima ?>>
                                    <input name="total_acumulado" type="hidden" value=<?php echo $AF; ?>>

                                    <button  type="submit" name="submit" value="ENVIAR"   class="btn btn-primary" >CADASTRAR</button>                                                           
                                </div> 
                            </div> 
                        </form>   
                    </div>

                </div>
                <p class="coment">HISTÓRICO DE LANÇAMENTOS</p>
                <table class=" tb2 table table-hover table-striped table-sm table-bordered bg-light"  >
                    <thead class="thead-dark ">
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Data Registro</th>
                            <th scope="col">SISCOR</th>
                            <th scope="col">Tipo de Infração</th>
                            <th scope="col">Valor Calculado</th>
                            <th scope="col">Valor Aplicado</th>
                            <th scope="col">Observação</th>
                            <th scope="col">Atualizar</th>
                            <th scope="col">Excluir</th>
                            <?php
                            $sql20 = "SELECT *  FROM historico_multa WHERE id_contrato = '$id_contrato' AND categoria='5' ";
                            $result = mysqli_query($conection, $sql20)or die('Não foi possivel conectar ao MySQL');
                            while ($registro1 = mysqli_fetch_array($result)) {

                                $data_registro = $registro1['data_registro'];
                                $valor_multa_aplicado = $registro1['valor_multa_aplicado'];
                                $valor_multa_definitivo = $registro1['valor_multa_definitivo'];
                                $siscor = $registro1['siscor'];
                                $observacao = $registro1['observacao'];
                                $categoria = $registro1['categoria'];
                                $id_histmulta = $registro1['id_histmulta'];
                                $siscor = $registro1['siscor'];
                                $clausula = $registro1['clausula'];

                                $valor_multa_definitivo = $registro1['valor_multa_definitivo'];

                                switch ($categoria) {
                                    case 1:
                                        $categoria = "Atraso na Entrega do Objeto";
                                        break;
                                    case 5:
                                        $categoria = "Descumprimento SLA Corretiva";
                                        break;
                                    case 3:
                                        $categoria = " ";
                                        break;
                                }

                                if (!empty($observacao)) {
                                    $observacao = 'Detalhes';
                                }

                                $valor_multa_aplicado1 = number_format($valor_multa_aplicado, 2, ',', '.');
                                $valor_multa_definitivo1 = number_format($valor_multa_definitivo, 2, ',', '.');
                                ?>
                            <tr>
                                <td ><a  target="_blank" href="multaCorretiva.php?id=<?php echo $id_contrato ?>&id_histmulta=<?php echo $id_histmulta ?>"><center><i class="far fa-file"></i></center></a></td>
                                <td><?php echo $data_registro ?></td> 
                                <td><?php echo $siscor ?></td>
                                <td><?php echo $categoria ?></td>
                                <td><?php echo 'R$ ' . $valor_multa_aplicado1 ?></td>
                                <td><?php echo 'R$ ' . $valor_multa_definitivo1 ?></td>
                                <td><a  data-toggle="modal" href="#" data-target="#exampleModal1<?php echo $res['id_histmulta'] ?>" ><center><?php echo $observacao ?></center</a></td>
                                <td><a id="a2" data-toggle="modal" href="#" data-target="#exampleModa3<?php echo $registro1['id_histmulta'] ?>" ><i class="fas fa-edit"></i></a></td>
                                <td><a id="a2" data-toggle="modal" href="#" data-target="#exampleModa2<?php echo $registro1['id_histmulta'] ?>" ><i class="fas fa-eraser"></i></a></td>
                            </tr>
                            <!-- Modal Exclusao -->
                        <div class="modal fade" id="exampleModa3<?php echo $registro1['id_histmulta'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><?php echo "Atualizar registro criado na data $data_registro ?" ?> </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="  needs-validation"  id="updt" action="atu_confirma_multa.php?action=slacorretiva_update"  method="post" novalidate>
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
                                                        <label for="creferencia">VALOR DA MULTA EFETIVAMENTE APLICADA:</label>
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
                                                    <div class="col-md-12 mb-10">
                                                        <label for="cobservacao">OBSERVAÇÃO:</label>

                                                        <textarea class="form-control "  id="exampleFormControlTextarea1"  name="observacao" rows="20"><?php echo $registro1['observacao']; ?></textarea>                                
                                                    </div>
                                                </div>

                                                <div class="col-md-1 mb-10"style=" margin-top: 31px;">
                                                    <input name="id_contrato" type="hidden" value=<?php echo $id_contrato; ?>>                               
                                                    <input name="id_histmulta" type="hidden" value=<?php echo $registro1['id_histmulta']; ?>>                               
                                                    <input type="hidden" name="submitted" value="TRUE" />
                                                    <button type="submit" class="btn btn-primary">Atualizar</button>
                                                </div>
                                            </div>

                                        </form>

                                    </div>                             
                                </div>
                            </div>
                        </div>
                        <!-- Modal Exclusao -->
                        <div class="modal fade" id="exampleModa2<?php echo $registro1['id_histmulta'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><?php echo "Deseja deletar O registro criado na data $data_registro ?" ?> </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p><?php echo $siscor ?></p>
                                        <ul class="nav justify-content-center">     

                                            <li class="nav-item">
                                                <a  class="btn btn-danger" href="rolback_manutCorretiva.php?id_histmulta=<?php echo $registro1['id_histmulta'] ?>&id=<?php echo $id_contrato ?>">Sim</a>
                                            </li>
                                            <li style="margin-left:30px" class="nav-item">

                                                <a style=" color: #FFFFFF" class="btn btn-success"  data-dismiss="modal">Nao</a>
                                            </li>
                                        </ul>
                                    </div>                             
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                    ?>

                </table>                        
                <div style="margin-top: 50px">                 

                </div>


            </div>
        </div>


            
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script defer src="js/fontawesome-all.min.js"></script>
    </body>
</html>