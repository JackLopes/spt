<?php
session_start();
require_once ('./inc/Config.inc.php');
require_once 'database_gac.php';
require_once './Funcoes/func_data.php';

$Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$id_aceite = filter_input(INPUT_GET, 'id_aceite', FILTER_VALIDATE_INT);
$id_tipo = $_SESSION['tip'] = filter_input(INPUT_GET, 'id_tipo', FILTER_VALIDATE_INT);

require_once 'valida_permissao.php';

if (isset($_GET['id_itens'])) {
    $id_itens = (int) $_GET['id_itens'];
}
if (isset($_GET['se'])) {
    $serie = $_GET['se'];
}
if (isset($_GET['pa'])) {
    $patrimonio = $_GET['pa'];
}


$query = "SELECT tip.* , loc.id_contrato,loc.sigla, cont.tip_chamado, cont.tipo, cont.prazo_entrega,
				cont.rg, cont.valor_Contratado, loc.lugar_regional, loc.id_local				
				FROM tipo AS tip
				INNER JOIN local AS loc ON  loc.id_local = tip.id_local
				INNER JOIN  contrato AS cont ON  cont.id_contrato = loc.id_contrato
				WHERE id_tipo = '$id_tipo'";

$resultado = mysqli_query($conection, $query)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado)) {

    $tipos = ucwords(strtolower($registro['tipos']));
    $val_contr = $registro['valor_Contratado'];
    $ct = $registro['id_contrato'];
    $tch = $registro['tip_chamado'];
    $rg = $registro['rg'];
    $regional = $registro['lugar_regional'];
    $tipo = $registro['tipo'];
    $id_local = $registro['id_local'];
    $prazo_entrega_contrato = $registro['prazo_entrega'];
    $sigla = $registro['sigla'];
}
?>

<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
        <link rel="stylesheet"  type="text/css" href="" media="screen"/>
        <link rel="stylesheet" href="css/bootstrap.css" >
        <script defer src="js/fontawesome-all.min.js"></script>
        <style>
            .format{ margin-left: 10px}
            #title{ background-color: #f8f9fa;
                    margin-top: 10px;


            }



        </style>

    </head>
    <body >
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">


            <a class="navbar-brand" href="#">Detalhes </a>
            <a class=" format btn btn-outline-light" href="cad_itens.php?id_tipo=<?php echo $id_tipo ?>&sinal=sinal">Voltar</a>                
            <a class="format btn btn-outline-danger" href="atrasoMultasItens.php?id=<?php echo $ct ?>&id_itens=<?php echo $id_itens ?>&id_tipo=<?php echo $id_tipo ?>">Multas</a>                

        </nav>
        <div  class="container-fluid" >
            <div id="title">
                <?php echo "RG: " . $rg . "/ " . $regional . " - Grupo de " . $tipos;
                ?>  

            </div>

            <div  class="row  justify-content-center" >
                <div  class=" col-md-8 ml-sm-6 col-lg-10 pt-0 justify-content-center" >



                    <div class="col-md- order-md-1" style=" margin-top: 100px;">

                        <?php
                        if (isset($_SESSION['msg38'])) {
                            echo $_SESSION['msg38'];
                            unset($_SESSION['msg38']);
                        }
                        ?>

                    </div>

                    <table class="  table table-sm  table-hover table-bordered" id="tb2" >
                        <tr>
                        <thead class="thead-light">
                        <td >Ordem dos Eventos</td>
                        <td >Data / Hora do Registro</td>                             
                        <td >Prazo Entrega</td>                             
                        <td >Qtd Entregue </td>
                        <td >Data Entrega</td>
                        <td >R. Provisório</td>
                        <td >Instalação</td>
                        <td >Atraso Entrega</td>
                        <td >Aplicar Multa</td>                                
                        <td >Status</td>
                        <td >Observação</td>
                        <td >Editar</td>
                        <td >Excluir</td>
                        </thead>
                        </tr> 
                        <tbody  >
                            <tr class="delivered" >
                                <?php
                                $i = 0;

                                $severi = "SELECT  ace.*,ite.qtd_total 
				FROM aceite as ace
                                INNER JOIN itens AS ite ON  ite.id_itens = ace.id_iten
				WHERE id_iten = '$id_itens'";
                                $resultado = mysqli_query($conection, $severi)or die('Não foi possivel conectar ao MySQL');
                                while ($registro = mysqli_fetch_array($resultado)) {
                                    $i = $i + 1;
                                    $id_aceite = $registro['id_aceite'];
                                    $d_rec_pro = $registro['rec_provisorio'];
                                    $d_inst = $registro['data_intalacao'];
                                    $entrega = $registro ['entrega'];
                                    $atraso_dias = $registro ['atraso_dias'];

                                    $qtd_entrege = (int) $registro ['qtd_entrege'];
                                    $qtd_entr[] = (int) $registro ['qtd_entrege'];
                                    $qtd_entregas1 = array_sum($qtd_entr);

                                    $aplicacao_multa = $registro ['aplicacao_multa'];
                                    $qtd_total = (int) $registro ['qtd_total'];

                                    $resul_entega = $qtd_entregas1 - $qtd_entrege;

                                    // var_dump($qtd_entrege);

                                    if ($atraso_dias > 0) {
                                        $aplicacao_multa = 'Sim';
                                    } else if ($atraso_dias == 0) {
                                        $aplicacao_multa = 'Não';
                                    } else {
                                        $aplicacao_multa = 'Verificar';
                                    }
                                    $observacao = $registro ['observacao'];




                                    $q = "SELECT id_aceite FROM multa WHERE id_aceite = '$id_aceite'";
                                    $r = mysqli_query($conection, $q);
                                    $num = mysqli_num_rows($r);
                                    if ($num == 1) {

                                        $status = "<font style='color:red'>Lançamento para penalidade efetuado</font>";
                                    } else
                                    if ($qtd_entrege === 0) {

                                        $status = "<font style='color:#007bff;'>Aguardando Entrega</font>";
                                    } else if ($qtd_entrege != 0 and $atraso_dias > 0) {
                                        $status = "<font style='color:red'>Entrega com atraso </font>";
                                    } else if ($qtd_entrege != 0 and $atraso_dias == 0) {
                                        $status = "<font style='color:green'>Entrega Efetuada</font>";
                                    }

                                   // var_dump($resul_entega);
                                    ?>

                                    <td ><?php echo $i . "º"; ?></td>  
                                    <td ><?php echo $registro['data_registro']; ?></td> 
                                    <td id="ultiData" ><?php echo inverteData($registro['prorrogacao']); ?></td> 
                                    <td  ><a data-toggle="modal" data-target="#exampleModal<?php echo $id_aceite ?>"href="#"><?php echo"<h5 class='btn btn-outline-primary'>". $qtd_entrege. "</h5>"; ?></td>                              
                                    <td  > <a data-toggle="modal" data-target="#exampleModal<?php echo $id_aceite ?>"href="#"><?php echo   inverteData($entrega); ?></a></td>
                                    <td class = "td3" ><?php echo inverteData($registro['rec_provisorio']); ?></td>
                                    <td class = "td3" ><?php echo inverteData($d_inst); ?></td>
                                    <td class = "td3" ><?php echo "<font style='color:red'>" . $registro ['atraso_dias'] . "</font>"; ?></td>
                                    <td class = "td2" ><a  data-toggle="modal"  <?php ?> data-target="#exampleModal3<?php echo $id_aceite ?>" href="#" ><?php echo "<h5 class='btn btn-outline-primary'>". $aplicacao_multa. "</h5>"; ?></td>
                                    <td class = "td3" ><?php echo $status; ?></td>                         
                                    <td>

    <?php echo $registro['observacao']; ?>
                                    </td>
                                    <td>
                                        <a data-toggle="modal" class='btn btn-outline-primary' data-target="#example2<?php echo $id_aceite; ?>" href="#">

                                            <i class="far fa-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a  href="#"class='btn btn-outline-primary'  data-toggle="modal" data-target="#delete<?php echo $id_aceite; ?>">
                                            <i class="fas fa-eraser"></i>
                                        </a>
                                    </td>
                                </tr>
                                <!-- Modal Observacao-->
                            <div class="modal fade" id="example2<?php echo $id_aceite; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class=" prill modal-title" id="exampleModalLongTitle"><?php echo $i . "º " . " Evento " ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form   classf="needs-validation "   action="atu_cad_itens2.php?action=obs"  method="post" novalidate>
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label class="prill" for="cobservacao">Observação</label>
                                                        <input  class="form-control" id="cobservacao"  name="observacao" rows="5" value="<?php echo $registro['observacao']; ?>">
                                                    </div>
                                                     <div class="form-group col-md-12">

                                                            <label class="mods1" for="caplicacao_multa" >Reeditar Datas e Quantidades Entregues ?</label>
                                                            <select class="custom-select"name="clean" >
                                                                <option selected>Selecione</option>
                                                                <option value="1">Sim</option>
                                                                <option value="2">Não</option>                                                           
                                                            </select>
                                                        </div>
                                                    <div class="col-md-12 mb-10">  
                                                        <input class="form-control"  type="hidden" name="id_tipo"   value="<?php echo $id_tipo; ?>" >
                                                       
                                                        <input class="form-control"  type="hidden" name="id_itens"   value="<?php echo $id_itens; ?>" >
                                                        <input class="form-control"  type="hidden" name="id_aceite"   value="<?php echo $id_aceite; ?>" >
                                                        <input class="btn btn-primary btn-sm btn-block"  type="submit" name="submit" value="Enviar"/> 
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <!-- Modal Data de Entrega-->
                            <div class="modal fade"  id="exampleModal<?php echo $id_aceite; ?>"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"id="exampleModalLabel" text="center" ><font color='#0080FF'></font></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <br/>
                                            <form id= "fmr1"  class="needs-validation "    action="atu_cad_itens2.php?action=entregas"  method="post" novalidate>
                                                <div  class="container" >		
                                                    <div class="form-row">	
                                                        
                                                         <!--
                                                        <div class="form-group col-md-12">
                                                            <label for="cqtd_entrege" >QTD ENTREGA:</label>
                                                            <input class="form-control" Type="number" name="qtd_entrege"  value=" <?php// echo $registro['qtd_entrege']; ?>" >
                                                        </div>
                                                         -->
                                                        
                                                        <div class="form-group col-md-12">
                                                            <label for="rec_provisorio" >RECEBIMENTO PROVISÓRIO:</label>
                                                            <input class="form-control" Type="date" name="rec_provisorio" id="rec_provisorio"  value="<?php echo $registro['rec_provisorio']; ?>" >
                                                        </div>	

                                                        <div class="form-group col-md-12">
                                                            <label for="cdata_instalacao" >DATA INSTALAÇÃO</label>
                                                            <input class="form-control" Type="date" name="data_instalacao" id="cdata_instalacao"  value="<?php echo $registro['data_instalacao']; ?>" >
                                                        </div>		
                                                    </div>
                                                    <br/>
                                                    <input class="form-control"  type="hidden" name="id_tipo"   value="<?php echo $id_tipo; ?>" >
                                                    <input class="form-control"  type="hidden" name="prorrogacao"   value="<?php echo $registro['prorrogacao']; ?>" >
                                                    <input class="form-control"  type="hidden" name="id_aceite"   value="<?php echo $id_aceite; ?>" >
                                                    <input class="form-control"  type="hidden" name="id_itens"   value="<?php echo $id_itens; ?>" >

                                                    <input  class="btn btn-outline-primary" type="submit" name="submit" value="ENVIAR"  class="btn btn-primary">

                                                </div>
                                            </form>
                                        </div>	 

                                    </div>    
                                </div> 
                            </div>              
                            <!-- Modal aplicar Multas -->

                            <div class="modal fade"  id="exampleModal3<?php echo $id_aceite ?>"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"id="exampleModalLabel" text="center" ><font color='#0080FF'>Análise da Ocorrência</font></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form  class=" updates needs-validation "   action="proc_atua_itens.php"  method="post" novalidate>         
                                                <div  class="container" >	
                                                    <div class="form-row"> 
                                                        <div class="form-group col-md-9">

                                                            <label class="mods1" for="caplicacao_multa" >APLICAR MULTA ?</label>
                                                            <select class="custom-select"name="aplicacao_multa" id="caplicacao_multa"  value="<?php echo $registro['aplicacao_multa']; ?>" >
                                                                <option selected>Selecione</option>
                                                                <option value="Sim">Sim</option>
                                                                <option value="Nao">Não</option>                                                           
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-3" style=" margin-top: 30px;">
                                                            <input class="form-control"  type="hidden" name="id_aceite" id="cid_pag"  value="<?php echo $id_aceite; ?>" >
                                                            <input class="form-control"  type="hidden" name="id_itens" id="cid_pag"  value="<?php echo $id_itens; ?>" >
                                                            <input class="form-control"  type="hidden" name="id_tipo" id="cid_pag"  value="<?php echo $id_tipo; ?>" >
                                                            <input class="form-control"  type="hidden" name="id_contrato" id="cid_tipo"  value="<?php echo $ct; ?>" >                                           
                                                            <input class="form-control"  type="hidden" name="regional" id="cid_tipo"  value="<?php echo $sigla; ?>" >                                           
                                                            <input  class="btn btn-outline-primary" type="submit" name="Prosseguir" value="ENVIAR"  class="btn btn-primary">
                                                            <input type="hidden" name="submitted" value="TRUE" />
                                                        </div>
                                                    </div>	
                                                </div>
                                            </form>
                                        </div>	 
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Deletar Registro-->
                            <div class="modal fade" id="delete<?php echo $id_aceite; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Deseja Realmente Deletar  </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p><?php echo 'Esta ' . $i . "º" . ' ' . 'Observação'; ?></p>
                                            <ul class="nav justify-content-center">     
                                                <li class="nav-item">
                                                    <a class="btn btn-danger"  href ="delet_aceite2.php?id_aceite=<?php echo $id_aceite; ?>&id_tipo=<?php echo $id_tipo; ?>&id_itens=<?php echo $id_itens ?>">Sim</a>
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script src="js/jquery-3.2.1.slim.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script>
          handed  =  document.getElementsByTagName('tr');
          ultimaData = document.getElementById("ultiData").innerHTML;
          
          var segundo = handed[2];
          
        /*  if (verifly == 0){
              segundo.style.display = "none";
          }
          */
         
          
          
          var ultimo = handed[handed.length - 1];
          
          

     
          console.log(ultimaData);
          
        for  (var c = 0; c < handed.length; c++){
              handed[c].style.backgroundColor = "#cbd3da";
          }
               
              ultimo.style.backgroundColor = "#e9ecef";
              ultimo.style.fontWeight = "900";
              ultimo.style.fontSize = "x-large";
              
           
        </script>    
    </body>
</html>