<?php
session_start();

if ($_SESSION['status'] != 'LOGADO') {
    header("Location: login.php");
}

if (isset($_SESSION['tip'])) {
    unset($_SESSION['tip']);
}


if(!empty(filter_input(INPUT_GET, 'menu', FILTER_VALIDATE_INT))){
    $menu = filter_input(INPUT_GET, 'menu', FILTER_VALIDATE_INT);   
   
} else {
    $menu = 1;
}

if($menu == 1){
require_once 'menu_local.php';
}

require_once ('./inc/Config.inc.php');
require_once './Funcoes/func_data.php';

$Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$id_itens = filter_input(INPUT_GET, 'id_itens', FILTER_VALIDATE_INT);

if (isset($_POST['id_tipo'])) {
    $id_tipo = (int) $_POST['id_tipo'];
}
if (isset($_GET['id_tipo'])) {
    $id_tipo = (int) $_GET['id_tipo'];
}

require_once 'valida_permissao.php';
require_once 'database_gac.php';


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

if ($tipo == 'AQUISIÇÃO' or $tipo == 'SOLUÇÃO') {
    $assunt = "<i class='fas fa-database'></i> Cadastro e Acompanhamento da Entrega e Instalações de Itens<p><h3 style='margin-left:50px; opacity:0.7;'> RG:  $rg / $regional  - Grupo de $tipos </h3><p> ";
} else {
    $assunt = "<i class='fas fa-database'></i> Cadastro de Itens <p><h3 style='margin-left:50px; opacity:0.7;'> RG:  $rg / $regional  - Grupo de $tipos </h3><p> ";
}

if (!empty($id_itens)) {
    $apagarResponsavel = new Delete();
    $apagarResponsavel->ExeDelete('itens', 'WHERE id_itens = :id', "id={$id_itens}");
}
?>
<!doctype html>
<html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
        <link rel="stylesheet"  type="text/css" href="css/Styleitens.css" media="screen"/>
        <link rel="stylesheet" href="css/bootstrap.css" >
        <script src="jquery.js" type="text/javascript"></script>
        <script type="text/javascript" src="js1/jquery-3.3.1.min.js"></script>
        <script defer src="js/fontawesome-all.min.js"></script>
        <style>
            label{
                font-size: 23px;             
                font-family:  times new romam;
                color: #6c757d;
            }

            #fmr1  input {
                font-size: 22px;           
                font-weight: bold;
                font-family:  times new romam;
            }
            #fmr1  select {
                font-size: 22px;           
                font-weight: bold;
                font-family:  times new romam;
                height: 50px;
            }
        </style>



    </head>
    <body  >
        <?php require_once 'image_header6.php'; ?>

        <div  class=" container-fluid    "  style="margin-top: 30px">

            <div class=" regis form-group col-md-12">
                <div  class="row" >

                    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                        <div class="sidebar-sticky">
                            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                                RELATÓRIOS             
                            </h6>
                            <ul class="nav flex-column mb-2">
                                <li class="nav-item">
                                    <a class="nav-link"  href="#"> 				           
                                        ANS
                                    </a> 

                                </li>             
                            </ul>
                        </div>
                    </nav>

                    <main role="main"  class="col-md-10 ml-sm-6 col-lg-10 pt-0 px-4">
                        <?php
                        if (!empty($_SESSION['msg23'])) {

                            echo $_SESSION['msg23'];

                            unset($_SESSION['msg23']);
                        }
                        ?> 
                        <form id= "fmr1"  class="needs-validation bg-light"   action="proc_cad_itens.php"  method="post" novalidate>
                            <div  class="container"  > 
                                <div class="form-row">
                                    <div class="form-group col-md-12">                 
                                        <label for="forn"> FISCAL TÉCNICO:</label>
                                        <select class="form-control" id="forn" name="id_resp" >
                                            <option></option>  
                                            <?php
                                            $q1 = "SELECT * FROM  responsaveis WHERE id_local= '$id_local' AND responsabilidade ='Fiscal Tecnico' ";
                                            $r1 = mysqli_query($conection, $q1);
                                            while ($row = mysqli_fetch_assoc($r1)) {
                                                ?>
                                                <option value = "<?php echo $row ['id_resp']; ?>"><?php echo $row ['nome']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">		
                                    <div class="form-group col-md-12">
                                        <label for="cdescricao" >DESCRIÇÃO:</label>
                                        <input class="form-control" Type="text" name="descricao" id=""  value="<?php if (isset($_POST[''])) echo $_POST['']; ?>" />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <?php if ($tipos == 'Hardware') { ?>
                                        <div class="form-group col-md-4">
                                            <label for="cserie" >SERIE:</label>
                                            <input class="form-control" Type="text" name="serie" id=""  value="<?php if (isset($_POST[''])) echo $_POST['']; ?>" />
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="cpatrimonio" >PATRIMONIO:</label>
                                            <input class="form-control" Type="text" name="patrimonio" id=""  value="<?php if (isset($_POST[''])) echo $_POST['']; ?>" />
                                        </div>
                                    <?php } ?>		
                                    <div class="form-group col-md-4">
                                        <label for="campovalor" >VALOR UNITÁRIO:</label>			 
                                        <input class="form-control"  Type="text"   name="valor_unitario" id="campovalor" value="<?php if (isset($_POST['valor_contratado'])) echo $_POST['valor_contratado']; ?>" >
                                    </div>

                                </div>
                                <input class="form-control"  type="hidden" name="id_tipo" id="cid_iten"  value="<?php echo $id_tipo; ?>" >
                                <input class="form-control"  type="hidden" name="tipos" id="cid_iten"  value="<?php echo $tipos; ?>" >
                                <input class="form-control"  type="hidden" name="id_contrato" id="cid_iten"  value="<?php echo $ct; ?>" >
                                <input class="form-control"  type="hidden" name="prazo_entrega" id="cid_iten"  value="<?php echo $prazo_entrega_contrato; ?>" >
                                <input class="form-control"  type="hidden" name="tipo" id="cid_iten"  value="<?php echo $tipo; ?>" >

                                <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?>
                                    <input  class="btn btn-outline-primary" type="submit" name="Prosseguir &gt;$gt" value="ENVIAR"  class="btn btn-primary"/>
                                    <input type="hidden" name="submitted" value="TRUE" />
                                <?php } ?>

                            </div>
                        </form>
                    </main>
                </div>
            </div>
            <div class="regis form-group col-md-12">
                <br/>		<br/>
                <?php
                if (!empty($Dados['assunto']) and ! empty($Dados['observacao'])and ! empty($Dados['categoria'])) {
                    unset($Dados['submit']);
                    $CadObservacao = new Observacao();
                    $CadObservacao->ExeCreate($Dados);
                    if (!$CadObservacao->getResultado()) {
                        $CadObservacao->getMsg();
                    } else {
                        echo $CadObservacao->getMsg();
                    }
                }


                if (!empty($Dados['prazo_entrega']) and ! empty($Dados['rec_provisorio'])) {
                    unset($Dados['submit']);
                    $UpdRecebimento = new RecebimentoProvisorio();
                    $UpdRecebimento->ExeUpdate($id_itens, $Dados);
                    echo $UpdRecebimento->getMsg();
                }
                if (!empty($_SESSION['msg24'])) {

                    echo $_SESSION['msg24'];

                    unset($_SESSION['msg24']);
                }
                ?>
                <table  class="table table-striped table-hover table-bordered table-sm"  >
                    <thead class="thead-dark">
                        <tr>
                            <td >Descrição</td>
                            <td>Fiscal Técnico</td>
                            <td>Area</td>
                            <?php if ($tipo == 'SERVIÇOS') { ?>
                                <td>Operante</td>
                            <?php } ?>
                            <?php if ($tipos == 'Hardware') { ?>
                                <td >Série</td>
                                <td >Patrimônio</td>
                            <?php } ?>
                            <td >Qtd Total </td>
                            <?php if ($tipos == 'Hardware') { ?>       
                                <td >Qtd Entregue </td>
                            <?php } ?>
                            <td >Valor Unitário</td>
                            <td >Sub Total</td>
                            <?php if ($tipo == 'AQUISIÇÃO' or $tipo == 'SOLUÇÃO') { ?> 
                                <td >Prazo Entrega</td>
                                <td >Data De Entrega</td>
                                <td >Status</td>


                            <?php } ?>
                            <td >Detalhes</td>

                            <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?>
                                <td >Atualizar</td>
                                <td >Excluir</td>
                            <?php } ?>

                        </tr> 
                    </thead>

                    <?php
                    $severi = "SELECT  * 
				FROM itens 			
				WHERE id_tipo = '$id_tipo'";
                    $resultado = mysqli_query($conection, $severi)or die('Não foi possivel conectar ao MySQL');
                    while ($registro = mysqli_fetch_array($resultado)) {

                        $id_itens = (int) $registro['id_itens'];

                        $desc = $registro['descricao'];
                        $d_rec_pro = $registro['rec_provisorio'];
                        $d_inst = $registro['data_instalacao'];
                        $prazo_entrega = $registro['prazo_entrega'];
                        $patrimonio = $registro['patrimonio'];
                        $entrega = $registro ['entrega'];
                        $aplicacao_multa = $registro ['aplicacao_multa'];
                        $prorrogacao_itens = $registro ['prorrogacao'];
                        $ativo = $registro['ativo'];
                        $qtd_total = (int) $registro['qtd_total'];
                        
                        //consulta que infere os valores constantes na tabela aceita para exibição na tabela itens

                        $sq5 = "SELECT SUM(qtd_entrege) AS qtd_entregue_itens  FROM aceite WHERE id_iten = '$id_itens'";
                        $result = mysqli_query($conection, $sq5)or die('Não foi possivel conectar ao MySQL');
                        while ($registro5 = mysqli_fetch_array($result)) {

                            $qtd_entregue_itens = $registro5['qtd_entregue_itens'];
                           
                        }

                        $sq6 = "SELECT SUM(atraso_dias) AS atraso_dias_itens  FROM aceite WHERE id_iten = '$id_itens'";
                        $result6 = mysqli_query($conection, $sq6)or die('Não foi possivel conectar ao MySQL');
                        while ($registro6 = mysqli_fetch_array($result6)) {

                          
                            $atraso_dias_itens = (int) $registro6['atraso_dias_itens'];
                        }
                       //atualiza tabela itens
                         $result1 = "UPDATE  itens  SET  qtd_entregue_itens='$qtd_entregue_itens', atraso_dias_itens ='$atraso_dias_itens' WHERE id_itens='$id_itens'";
                         $resultado1 = mysqli_query($conection, $result1) or die(mysqli_error($conection));
    
                       //condicional para avaliar se o item é ativo ou não, caso não seu patrimonio não contara no relatorio de manutençãopreventiva.

                        $ativo == 2 ? $ativo = 'Sim' : $ativo = "<font color='red' >Não</font>";

                       //acesso aos historico editados durante o processo
                  
                        $q = "SELECT * FROM aceite WHERE id_iten = '$id_itens' ";
                        $r = mysqli_query($conection, $q);
                        $num1 = mysqli_num_rows($r);


                       
                       //atualização automatica do prazo de entrega (quando há prorrogação )
                        
                        $q = "SELECT * FROM  historico_prorrogacao WHERE  id_contrato = '$ct'  AND tipo_prorog='1'";
                        $r = mysqli_query($conection, $q);
                        $num = mysqli_num_rows($r);
                        while ($register = mysqli_fetch_assoc($r)) {
                            $prorrogacaos = array();
                            $prorrogacaos[] = $register ['d_prorrogada'];
                            $prorrogacao = max($prorrogacaos);

                            if (!empty($prorrogacao)) {

                                $sql8 = "UPDATE itens SET prazo_entrega ='$prorrogacao' WHERE id_itens ='$id_itens'";
                                $r8 = mysqli_query($conection, $sql8);
                            }
                        }


                     //condicionais para exibição do status
                        
                        

                        $data = date('Y-m-d');

                        if (( $qtd_entregue_itens == $qtd_total)and($qtd_entregue_itens != 0 )and ( $atraso_dias_itens == 0) ) {

                            $inter_entrega = "<font style='color:green;'><b>Entrega Efetuada com Sucesso</font>";
                            $status = ' Entrega Efetuada';
                        } else if (( $qtd_entregue_itens < $qtd_total )and ( $qtd_entregue_itens > 0) ) { //and ( $atraso_dias_itens === 0)

                            $inter_entrega = "<font style='color:red;'><b>Pendência  de Entrega</font> ";
                            $status = 'Pendência  de Entrega';
                        } else if (($atraso_dias_itens > 0)and ( $qtd_entregue_itens == $qtd_total)) {

                            $inter_entrega = "<font style='color:red;'><b>Entrega efetuada com Atraso</font>";
                            $status = 'Entrega efetuada com Atraso';
                        } else if
                        (strtotime($data) < strtotime($prorrogacao_itens) && $qtd_entregue_itens == 0 ) {

                            $data1 = new DateTime($data);
                            $data2 = new DateTime($prorrogacao_itens);
                            $intervalo = $data1->diff($data2);


                            $inter_entrega = "<b>{$intervalo->m} meses e {$intervalo->d} dias";
                            $status = "{$intervalo->m} meses e {$intervalo->d} dias";
                        } else if
                        (($prorrogacao_itens != '0000-00-00')and ( strtotime($prorrogacao_itens) > strtotime($prazo_entrega_contrato))and ( $qtd_entregue_itens === 0)) {

                            $inter_entrega = "<font style='color:red;'><b>Entrega Em atraso</b></font>";
                            $status = 'Entrega Em atraso';
                        } else if ( $qtd_entregue_itens == 0) {
                            
                            $inter_entrega = "<font style='color:#007bff;'><b>Aguardando Lançamento</font>";
                            $status = 'Aguardando Entrega';
                        }

                      

                        //armazenamento do status na tabela itens

                        $result1 = "UPDATE  itens  SET  status='$status' WHERE id_itens='$id_itens'";
                        $resultado1 = mysqli_query($conection, $result1) or die(mysqli_error($conection));

                        // indicador e acesso ao detalhes quando a entrega e criada na tabela ceite

                        if ($num1 > 0) {
                            $observacao = "<span class='btn btn-outline-primary'><i class='fas fa-database'></i></span>";
                        } else {
                            $observacao = " ";
                        }


                        $val_unitario = number_format($registro['valor_unitario'], 2, ',', '.');
                        ?>
                        <tr>
                            <td><?php echo $desc; ?></td>
                            <td class = "td3" ><?php echo $registro['responsavel']; ?></td>
                            <td class = "td3 " ><?php echo $registro['area']; ?></td>
                            <?php if ($tipo == 'SERVIÇOS') { ?>
                                <td class = "td3  text-center "  ><?php echo $ativo; ?></td>

                            <?php } ?>
                            <?php if ($tipos == 'Hardware') { ?>
                                <td class = "td3" > <a data-toggle="modal" <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?>  data-target="#exampleModal<?php echo $id_itens ?>" <?php } ?>href="#"><?php echo $registro['serie']; ?></a></td>
                                <td class = "td3" ><?php echo $registro ['patrimonio'] ?></td> 
                            <?php } ?>
                            <td class = "td3" ><?php echo $registro['qtd_total']; ?></td>   
                            <?php if ($tipos == 'Hardware') { ?>   
                                <td class = "td3" ><?php echo $qtd_entregue_itens; ?></td>                              
                            <?php } ?>
                            <td class = "td3" ><?php echo 'R$ ' . $val_unitario; ?></td>
                            <td class = "td3" ><?php
                                echo 'R$ ' . number_format($registro['sub_total'], 2, ',', '.');
                                ;
                                ?></td>
                            <?php if ($tipo == 'AQUISIÇÃO' or $tipo == 'SOLUÇÃO') { ?> 

                                <td class = "td3" ><?php echo "<h5 >" . inverteData($registro['prazo_entrega']) . "</h5>"; ?></td>
                                <td> <a data-toggle="modal"<?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?>  data-target="#example2<?php echo $id_itens ?>"<?php } ?> href="#">
                                        <?php
                                        echo "<h5 class='btn btn-outline-primary'>" . inverteData($prorrogacao_itens) . "</h5>";
                                        ?></td></a></td>


                                <td class = "td3" ><?php echo $inter_entrega; ?></td>

                            <?php } ?>

                            <td class="text-center" >
                                <a href="cad_aceite2.php?id_itens=<?php echo $id_itens; ?>&id_tipo=<?php echo $id_tipo; ?>" ><?php echo $observacao; ?>
                                </a>
                            </td>

                            <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?>
                                <td class="text-center" >
                                    <a data-toggle="modal" class='btn btn-outline-primary' data-target="#example9<?php echo $id_itens ?>" href="#">

                                        <i class="far fa-edit"></i>
                                    </a>
                                </td>

                                <td class="text-center" >
                                    <a href="#" class='btn btn-outline-primary'  data-toggle="modal" data-target="#exampleModal5<?php echo $id_itens ?>">
                                        <i class="fas fa-eraser"></i>
                                    </a>
                                </td>
                            <?php } ?>
                        </tr>

                        <div class="modal fade" id="example2<?php echo $id_itens ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle"><?php echo 'Série: ' . $registro ['serie'] ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form   class="needs-validation "   action="atu_cad_itens.php?action=prorro"  method="post" novalidate>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="centrega" >Data da Entrega</label>

                                                    <input class="form-control" Type="date" name="entrega" id="centrega" >
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label  class="mods1" for="cqtd_entrege" >Quantidade:</label>
                                                    <input class="form-control" Type="text" name="qtd_entrege" id="" />
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="cobservacao">Detalhes</label>
                                                    <textarea class="form-control" id="cobservacao"  name="observacao" rows="5"></textarea>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 mb-10"> 
                                                    <input class="form-control"  type="hidden" name="id_tipo"   value="<?php echo $id_tipo; ?>" >
                                                    <input class="form-control"  type="hidden" name="qtd_total"   value="<?php echo $qtd_total; ?>" >
                                                    <input class="form-control"  type="hidden" name="id_itens"   value="<?php echo $id_itens; ?>" >
                                                    <input class="form-control"  type="hidden" name="prorrogacao"  value="<?php echo $registro['prazo_entrega']; ?>" >
                                                    <input class="form-control"  type="hidden" name="categoria" id="ccategoria"  value="2" >
                                                    <input class="form-control"  type="hidden" name="patrimonio" id="cpatrimonio"  value="<?php echo $registro ['patrimonio'] ?>" >
                                                    <input class="btn btn-primary btn-sm btn-block"  type="submit" name="submit" value="Enviar"/> 

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <!-- Modal -->
                        <div class="modal fade" id="example9<?php echo $id_itens ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle"><?php echo 'Série: ' . $registro ['serie'] ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id= "fmr1"  class="needs-validation bg-light"   action="atu_cad_itens.php"  method="post" novalidate>
                                            <div  class="container"  > 	
                                                <div class="form-row">	                 
                                                    <label  class="mods1" for="forn"> Fiscal Técnico:</label>
                                                    <select class="form-control" id="forn" name="id_resp" >

                                                        <?php
                                                        $q1 = "SELECT * FROM  responsaveis WHERE id_local= '$id_local' AND responsabilidade ='Fiscal Tecnico' ";
                                                        $r1 = mysqli_query($conection, $q1);
                                                        while ($row = mysqli_fetch_assoc($r1)) {
                                                            ?>
                                                            <option selected><?php echo $row ['id_resp']; ?></option>
                                                            <option value = "<?php echo $row ['id_resp']; ?>"><?php echo $row ['nome']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="form-row">		
                                                    <div class="form-group col-md-12">
                                                        <label   class="mods1" for="cdescricao" >Descrição do Equipamento:</label>
                                                        <input class="form-control" Type="text" name="descricao" id=""  value="<?php echo $registro['descricao']; ?>" />
                                                    </div>
                                                </div>
                                                <div class="form-row">	
                                                    <div class="form-group col-md-12">

                                                        <label class="mods1" for="#" >Operante</label>
                                                        <select class="custom-select" name="ativo"   >
                                                            <option selected><?php echo $ativo; ?></option>
                                                            <option value="1">Não</option>
                                                            <option value="2">Sim</option>                                                           
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label   class="mods1" for="cserie" >Série:</label>
                                                        <input class="form-control" Type="text" name="serie" id=""  value="<?php
                                                        echo $registro['serie'];
                                                        ;
                                                        ?>" />
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label  class="mods1" for="cpatrimonio" >Patrimônio:</label>
                                                        <input class="form-control" Type="text" name="patrimonio" id=""  value="<?php
                                                        echo $registro['patrimonio'];
                                                        ;
                                                        ?>" />
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label   class="mods1" for="campovalor" >Valor Unitário:</label>			 
                                                        <input class="form-control"  Type="text"   name="valor_unitario" id="campovalor" value="<?php
                                                        echo $registro['valor_unitario'];
                                                        ;
                                                        ?>" >
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label  class="mods1" for="cqtd_total" >Quantidade:</label>
                                                        <input class="form-control" Type="text" name="qtd_total" id=""  value="<?php
                                                        echo $registro['qtd_total'];
                                                        ;
                                                        ?>" />
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="cobservacao">Observação</label>
                                                        <textarea class="form-control" id="cobservacao"  name="observacao" rows="5"><?php echo $registro['Observacao']; ?></textarea>
                                                    </div>

                                                </div>

                                                <div class="form-row">
                                                    <input class="form-control"  type="hidden" name="id_tipo" id="cid_iten"  value="<?php echo $id_tipo; ?>" >
                                                    <input class="form-control"  type="hidden" name="id_itens" id="cid_iten"  value="<?php echo $id_itens; ?>" >

                                                    <input  class="btn btn-outline-primary" type="submit" name="Prosseguir &gt;$gt" value="ENVIAR"  class="btn btn-primary"/>
                                                    <input type="hidden" name="submitted" value="TRUE" />
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <!-- Modal Exclusao -->
                        <div class="modal fade" id="exampleModal5<?php echo $id_itens; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Deseja Realmente Deletar  </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p><?php echo $registro['descricao']; ?></p>
                                        <ul class="nav justify-content-center">     
                                            <li class="nav-item">
                                                <a class="btn btn-danger"  href="cad_itens.php?id_tipo=<?php echo $id_tipo ?>&id_itens=<?php echo $id_itens ?>">Sim</a>
                                            </li>
                                            <li style="margin-left:30px" class="nav-item">

                                                <a style=" color: #FFFFFF" class="btn btn-success"  data-dismiss="modal">Nao</a>
                                            </li>
                                        </ul>
                                    </div>                             
                                </div>
                            </div>
                        </div>
                        <div class="modal fade"  id="exampleModal3<?php echo $id_itens ?>"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <?php
                    }
                    ?>	
                </table>
            </div>
        </div>
    </main>


</div>  
<script src="js/jquery.js"></script>
<script src="js/jquery_1.js"></script>
<script src="js/bootstrap.min.js"></script>    
<script>if (window.name != "first")
        window.location.reload();
    window.name = "first";</script>
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
</body>
</html>