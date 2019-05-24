
<?php
session_start();
require_once'Funcoes/func_data.php';
require_once 'database_gac.php';

$assunt = "<i class='far fa-handshake'></i>  Cadastro de Contrato";


$id_contrato = (int)filter_input(INPUT_GET, 'id_contrato', FILTER_SANITIZE_NUMBER_INT);

if (isset($_SESSION['dados']['id_contrato'])){ $id_contrato = (int)$_SESSION['dados']['id_contrato'];}
if (isset($_SESSION['dados']['id_contrato'])){ $valor_garantia_exc = (int)$_SESSION['dados']['valor_garantia_exc'];}

if (!empty($id_contrato)) {
    $sqlcontrato = "SELECT * FROM contrato WHERE id_contrato = $id_contrato";
    $resultado = mysqli_query($conection, $sqlcontrato)or die('Não foi possivel conectar ao MySQL');
    while ($registro = mysqli_fetch_array($resultado)) {
        $rg = $registro['rg'];
        $id_prestador = $registro['id_prestador'];
        $d_Registro = $registro['d_Registro'];
        $projeto_basico= $registro['projeto_basico'];
        $d_emissao= $registro['d_emissao'];
        $n_processo= $registro['n_processo'];
        $d_Assinatura= $registro['d_Assinatura'];  
        $status= $registro['status'];
        $d_Inic_vige_contr= $registro['d_Inic_vige_contr'];
        $d_fim_vige_cont= $registro['d_fim_vige_cont'];
        $pos_prorrogacao= $registro['pos_prorrogacao'];
        $vig_garantia= $registro['vig_garantia'];
        $obs= $registro['obs'];
        $valor_Contratado= $registro['valor_Contratado'];
        $valor_atual= $registro['valor_atual'];
        $d_prorro= $registro['d_prorro'];
        $d_Aceite= $registro['d_Aceite'];
        $n_siscor= $registro['n_siscor'];
        $objeto= $registro['objeto'];
        $tipo= $registro['tipo'];
        $prazo_entrega= $registro['prazo_entrega'];
        $d_recebimento= $registro['d_recebimento'];
        $vig_contrat= $registro['vig_contrat'];
        $d_fim_g= $registro['d_fim_g'];
        $link_pv= $registro['link_pv'];
        $link_ged= $registro['link_proscorm'];
        $link_proscorm= $registro['link_proscorm'];
        $agora= $registro['agora'];
        $natureza= $registro['natureza'];
        $tip_chamado= $registro['tip_chamado'];
        $fim_vig_garat= $registro['fim_vig_garat'];
        $mine= $registro['mine'];
        $data_prorro_aditivo= $registro['data_prorro_aditivo'];
        $percent_atrasoEntrega= $registro['percent_atrasoEntrega'];
        $percent_naoObjeto= $registro['percent_naoObjeto'];
        $percent_descumprimento= $registro['percent_descumprimento'];
        $limiteParcial= $registro['limiteParcial'];
        $limiteTotal= $registro['limiteTotal'];
        $entrega_garantia_exc= $registro['entrega_garantia_exc'];
        $parametro_multa = $registro['parametro_multa'];
        $periodo_garantia_exc = $registro['periodo_garantia_exc'];
        $valor_garantia_exc = $registro['valor_garantia_exc'];
        $pasta = $registro['pasta'];
    }
}


// controle de exibição no formulario
$variante_a = 1;
$variante_b = 1;



if(!empty($id_contrato)){

if (isset($id_contrato)) {
    if ($tipo == 'SERVIÇOS') {
        $variante_a = 2;
        $variante_b = 1;
    } else if ($tipo == 'AQUISIÇÃO') {

        $variante_a = 1;
        $variante_b = 2;
    }else if ($tipo == 'SOLUÇÃO') {

        $variante_a = 1;
        $variante_b = 1;
    }
}

if (isset($_SESSION['dados'])) {
    if ($_SESSION['dados']['tipo'] == 'SERVIÇOS') {
        $variante_a = 2;
        $variante_b = 1;
    } else if ($_SESSION['dados']['tipo'] == 'AQUISIÇÃO') {

        $variante_a = 1;
        $variante_b = 2;
    } else if ($_SESSION['dados']['tipo'] == 'SOLUÇÃO') {

        $variante_a = 1;
        $variante_b = 1;
    }
}



}
?>       


<!doctype html>
<html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
        <link rel="stylesheet"  type="text/css" href="css/styleacon.css" media="screen"/>
        <link rel="stylesheet" href="css/bootstrap.css" >
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
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
                $('#campovalor1').bind('keypress', mask.money);
                $('#campovalor1').bind('keyup', mask.money);
            });
            $(function () {
                $('#campovalor2').bind('keypress', mask.money);
                $('#campovalor2').bind('keyup', mask.money);
            });
            $(function () {
                $('#campovalor3').bind('keypress', mask.money);
                $('#campovalor3').bind('keyup', mask.money);
            });
            $(function () {
                $('#campovalor4').bind('keypress', mask.money);
                $('#campovalor4').bind('keyup', mask.money);
            });
            $(function () {
                $('#campovalor5').bind('keypress', mask.money);
                $('#campovalor5').bind('keyup', mask.money);
            });
            $(function () {
                $('#campovalor6').bind('keypress', mask.money);
                $('#campovalor6').bind('keyup', mask.money);
            });

        </script>	
        <script>
            function esconDiv2(valor)
            {
                if (valor == "NÃO")
                {
                    document.getElementById("div1").style.display = "none";

                } else if (valor == "SIM")
                {
                    document.getElementById("div1").style.display = "block";
                }
            }
        </script>
       
    </head>
    <body >
<?php 
   include 'header_cadastro.php';
include_once 'image_header5.php' ?>
       
        <div  class=" container-fluid    "  style="margin-top: 60px">
            <div  class="row  justify-content-center" >
                <div class="col-md-10 ">

<?php
if (isset($_SESSION['msg31'])) {
    echo $_SESSION['msg31'];
    unset($_SESSION['msg31']);
}


?>
                    <form id= "fmr1"  class="needs-validation"   <?php if($id_contrato){?> action="proce_contrato.php?action=update"<?php } else {?> action="proce_contrato.php?action=salva" <?php }?> method="post" novalidate>
                        <div class="content1" >    
                  <span  class="titl " ><h4>DO CONTRATO</h4><hr> </span>  
                      
                        <div class="row"> 
                            <div class="col-md-4 mb-3">
                                <label for="cstatus">Status:</label>
                                <select  class="form-control-plaintext" type="text" name="status" id="cstatus" value="<?php if (isset($_SESSION['dados']['status'])){ echo $_SESSION['dados']['status'];} elseif (isset ($id_contrato)){echo $status;} ?>"  required>
                                    <option selected><?php if (isset($_SESSION['dados']['status'])) {echo $_SESSION['dados']['status'];} elseif (!empty ($id_contrato)){echo $status;} ?></option>
                                    <option value= "VIGENTE">VIGENTE</option>	
                                    <option value="VIGENTE/GARANTIA">VIGENTE/GARANTIA</option>
                                    <option value="ENCERRADO">ENCERRADO</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="crg" >RG:</label>
                                <input  class="form-control-plaintext" Type="text" name="rg" id="crg"  value="<?php if (isset($_SESSION['dados']['rg'])) {echo  $_SESSION['dados']['rg'];} elseif (!empty  ($id_contrato)){echo $rg;}  ?>" />
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="n_siscor" >SISCOR Inicial:</label>
                                <input  class="form-control-plaintext" Type="text" name="n_siscor" id="cn_siscor"  value="<?php if (isset($_SESSION['dados']['n_siscor'])){ echo $_SESSION['dados']['n_siscor'];} elseif (!empty  ($id_contrato)){echo $n_siscor;} ?>" >
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="cprojeto_basico"  >Projeto Básico:</label>
                                <input  class="form-control-plaintext"  Type="text" name="projeto_basico" id="cprojeto_basico" value="<?php if (isset($_SESSION['dados']['projeto_basico'])){ echo $_SESSION['dados']['projeto_basico'];} elseif (!empty  ($id_contrato)){echo $projeto_basico;}  ?>" />
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="cpos_prorrogacao">Prorrogação</label>
                                <select  class="form-control-plaintext"  Type="text" name="pos_prorrogacao" id="cpos_prorrogacao"  maxlength="40" onchange="esconDiv2(this.value)" >
                                    <optgroup label="Selecione">
                                        <option selected><?php if (isset($_SESSION['dados']['pos_prorrogacao'])){ echo $_SESSION['dados']['pos_prorrogacao']; } elseif (!empty  ($id_contrato)){echo $pos_prorrogacao;}?></option>
                                        <option value= "SIM">SIM</option>	
                                        <option value= "NÃO">NÃO</option>
                                    </optgroup>
                                </select><p>	
                            </div> 

                            <div id="div1" class="col-md-4 mb-3 div1">
                                <label for="cperiodo_prorrogacao">Periodo De Prorrogação:</label>
                                <input  class="form-control-plaintext"  Type="number" name="periodo_prorrogacao"  id="cperi_Pror" value="<?php if (isset($_SESSION['dados']['periodo_prorrogacao'])) echo $_SESSION['dados']['periodo_prorrogacao']; ?>" >                   
                            </div>
                          <?php if (!empty($id_contrato)) {?>
                            
                             <div class="col-md-12 mb-3 ">
                                    <label for="cd_prorro">Data Prorrogação:</label>
                                    <input  class="form-control-plaintext"  Type="date" name="d_prorro"  id="cperi_Pror" value="<?php echo $d_prorro ?>" >                   
                                </div>
                          <?php } ?>

                            <div class="col-md-12 mb-3">
                                <label for="clink_pv">Caminho Da Pasta De Arquivos Autuados No P.Verde:</label>		  
                                <input  class="form-control-plaintext"  Type="text" name="pasta" id="clink_pv"  value="<?php if (isset($_SESSION['dados']['pasta'])){ echo $_SESSION['dados']['pasta']; } elseif (!empty  ($id_contrato)){echo $pasta;}  ?>">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="clink_pv">URL Processo Verde:</label>		  
                                <input  class="form-control-plaintext" Type="url" name="link_pv" id="clink_pv"  value="<?php if (isset($_SESSION['dados']['link_pv'])){ echo $_SESSION['dados']['link_pv']; } elseif (!empty  ($id_contrato)){echo $link_pv;}  ?>">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="clink_ged">URL GEDIG:</label>	
                                <input  class="form-control-plaintext" Type="url" name="link_ged" id="clink_ged" value="<?php if (isset($_SESSION['dados']['link_ged'])){ echo $_SESSION['dados']['link_ged']; } elseif (!empty  ($id_contrato)){echo $link_ged;}  ?>">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="clink_proscorm">URL Proposta Comercial:</label>	
                                <input  class="form-control-plaintext" Type="url" name="link_proscorm" id="clink_proscorm" value="<?php if (isset($_SESSION['dados']['link_proscorm'])) {echo $_SESSION['dados']['link_proscorm'];  } elseif (!empty  ($id_contrato)){echo $link_proscorm;} ?>" >
                            </div>
                        </div>
                        <span class="titl" > GESTÃO<hr></span>
                        <div class="row"> 

                            <div class="col-md-3 mb-3">
                                <label for="cnatureza">Área Gestora:</label>
                                <select class="form-control-plaintext" Type="text" name="natureza" id="cnatureza"   ><br />				
                                    <option selected><?php if (isset($_SESSION['dados']['natureza'])){ echo $_SESSION['dados']['natureza'];  } elseif (!empty  ($id_contrato)){echo $natureza;}?></option>
                                    <option value="GACAD">GACAD</option>
                                    <option value="GACAM">GACAM</option>						
                                </select>
                            </div>
                             <?php if (empty($id_contrato)) {?>    
                            <div class="col-md-9 mb-3">

                                <label for="forn"> Responsabilidade Fiscal Administrativa:</label>
                                <select class="form-control-plaintext" id="forn" name="id_usuario" >
                                    <option selected><?php if (isset($_SESSION['dados']['id_usuario'])) echo $_SESSION['dados']['id_usuario']; ?></option>
<?php
$q1 = "SELECT * FROM  usuario WHERE permissao ='3' ORDER BY nome ASC ";
$r1 = mysqli_query($conection, $q1);
while ($row = mysqli_fetch_assoc($r1)) {
    ?>
                                        <option value = "<?php echo $row ['id_usuario']; ?>"><?php echo $row ['nome']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                              <?php } ?>
                        </div>
                        <span class="titl" >DA CONTRATADA<hr></span>
                        <div class="row"> 
                            <div class="form-group col-md-8">
                                <label for="forn">Prestador/ Fornecedor:</label>
                                <select class="form-control-plaintext" id="forn" name="id_prestador" value="<?php
                                    if (isset($_SESSION['dados']['id_prestador'])) {
                                        echo $_SESSION['dados']['id_prestador'];
                                    } elseif ($_REQUEST["update"]) {
                                        echo $registro['mine'];
                                    }
                                    ?>">
                                    <option selected><?php if (isset($_SESSION['dados']['id_prestador'])) {echo $_SESSION['dados']['id_prestador'];  } elseif (!empty  ($id_contrato)){echo $id_prestador;}?></option>  
                                        <?php
                                        $q1 = "SELECT * FROM  prestador WHERE modo = '2'";
                                        $r1 = mysqli_query($conection, $q1);
                                        while ($row = mysqli_fetch_assoc($r1)) {
                                            ?>
                                        <option value = "<?php echo $row ['id_prestador']; ?>"><?php echo $row['id_prestador'] . "-" . ""; ?><?php echo $row ['nome']; ?></option>
                                    <?php } ?>
                                </select>	
                            </div>
                            <div class="form-group col-md-2">
                                <label for="n_processo" >Nº Processo:</label>
                                <input class="form-control-plaintext" Type="text" name="n_processo" id="cn_processo" size="15" maxlength="40" placeholder= "Nº Processo Verde"value="<?php if (isset($_SESSION['dados']['n_processo'])) {echo $_SESSION['dados']['n_processo']; } elseif (!empty  ($id_contrato)){echo $n_processo;} ?>" />
                            </div>
                        </div>
                        <span class="titl" > DO OBJETO<hr></span>
                        <div class="row"> 
                            <div class="col-md-4 mb-3">
                                <label for="ctipo">Tipo de Contrato</label>
                                <select class="form-control-plaintext" Type="text" name="tipo" id="ctipo"  onchange="esconDiv(this.value)" >				
                                    <option selected><?php if (isset($_SESSION['dados']['tipo'])){ echo $_SESSION['dados']['tipo']; } elseif (!empty  ($id_contrato)){echo $tipo;} ?></option>
                                    <option value="AQUISIÇÃO">Aquisição</option>
                                    <option value="SERVIÇOS">Serviços</option>						
                                    <option value="SOLUÇÃO">Solução</option>
                                  
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="cobjeto">Objeto do Contrato:</label>
                                <input class="form-control-plaintext" Type="text" name="objeto" id="cobjeto" value="<?php if (isset($_SESSION['dados']['objeto'])){ echo $_SESSION['dados']['objeto']; } elseif (!empty  ($id_contrato)){echo $objeto;} ?>" />
                            </div>
                        </div>
                           <span   class="titl" > DO VALOR CONTRATO</span>
                        <div style="margin-top:20px;" class="row">
                            <div class="form-group col-md-4">
                                <label for="campovalor" >Valor Contratado:</label>			 
                                <input class="form-control-plaintext"  Type="text"   name="valor_Contratado" id="campovalor" value="<?php if (isset($_SESSION['dados']['valor_Contratado'])){ echo $_SESSION['dados']['valor_Contratado']; } elseif (!empty  ($id_contrato)){echo $valor_Contratado;} ?>" >
                            </div> 
                        </div>
                        <span class="titl" >DAS SANÇÕES ADMINISTRATIVAS ( % )<hr></span>
                        <div class="row"> 
                            <div class="form-group col-md-4">
                                <label for="address">Atraso na entrega do objeto:</label>
                                <input type="text" class="form-control-plaintext"  id="campovalor1" name="percent_atrasoEntrega" value="<?php if (isset($_SESSION['dados']['percent_atrasoEntrega'])){ echo $_SESSION['dados']['percent_atrasoEntrega']; } elseif (!empty  ($id_contrato)){echo $percent_atrasoEntrega;}  ?>" >
                            </div>
                            <div class="form-group col-md-4">
                                <label for="address">Não entregha do objeto:</label>
                                <input type="text" class="form-control-plaintext" id="campovalor2" name="percent_naoObjeto"  value="<?php if (isset($_SESSION['dados']['percent_naoObjeto'])) {echo $_SESSION['dados']['percent_naoObjeto']; } elseif (!empty  ($id_contrato)){echo $percent_naoObjeto;}  ?>" >
                            </div>
                            <div class="form-group col-md-4">
                                <label for="address">Descumprimento de cláusula:</label>
                                <input type="text" class="form-control-plaintext" id="campovalor3" name="percent_descumprimento" value="<?php if (isset($_SESSION['dados']['percent_descumprimento'])){ echo $_SESSION['dados']['percent_descumprimento']; } elseif (!empty  ($id_contrato)){echo $percent_descumprimento;}  ?>" >
                            </div>
                            <div class="form-group col-md-4">
                                <label for="address">Limite Parcial:</label>
                                <input type="text" class="form-control-plaintext" id="campovalor4" name="limiteParcial" value="<?php if (isset($_SESSION['dados']['limiteParcial'])){ echo $_SESSION['dados']['limiteParcial']; } elseif (!empty  ($id_contrato)){echo $limiteParcial;}  ?>" >
                            </div>
                            <div class="form-group col-md-4">
                                <label for="address">Limite Total:</label>
                                <input type="text" class="form-control-plaintext" id="campovalor5" name="limiteTotal"  value="<?php if (isset($_SESSION['dados']['limiteTotal'])){ echo $_SESSION['dados']['limiteTotal']; } elseif (!empty  ($id_contrato)){echo $limiteTotal;}  ?>" >

                            </div>
                        </div>
                        <span class="titl" > DA VIGÊNCIA<hr></span>
                        <div class="row"> 
                            <div class="col-md-6 mb-3">
                                <label for="cvig_contrat"> Periodo da vigência contratual:</label>
                                <input class="form-control-plaintext" Type="number" name="vig_contrat" id="cvig_contrat" value="<?php if (isset($_SESSION['dados']['vig_contrat'])) {echo $_SESSION['dados']['vig_contrat'];} elseif (!empty  ($id_contrato)){echo $vig_contrat;}  ?>" >
                            </div> 
                            <div class="col-md-6 mb-3">
                                <label for="cd_Inic_vige_contr">Inicio da vigência contratual:</label>
                                <input class="form-control-plaintext"  Type="Date" name="d_Inic_vige_contr" id="cd_Inic_vige_contr" size="40" maxlength="40" value="<?php if (isset($_SESSION['dados']['d_Inic_vige_contr'])){ echo $_SESSION['dados']['d_Inic_vige_contr']; } elseif (isset ($id_contrato)){echo $d_Inic_vige_contr;}?>">
                            </div> 

                        </div>


                        <span class="titl" > DA ASSINATURA<hr></span>
                        <div class="row"> 
                            <div class="col-md-4 mb-3">
                                <label for="cd_Assinatura">Data da assinatura:</label>
                                <input class="form-control-plaintext" Type="Date" name="d_Assinatura" id="cd_Assinatura"  value="<?php if (isset($_SESSION['dados']['d_Assinatura'])) {echo $_SESSION['dados']['d_Assinatura'];}  elseif (!empty ($id_contrato)){echo $d_Assinatura;} ?>" >
                            </div>
                        </div>
                        </div>
<?php if ($variante_a == 1) { ?>
                         <div class=" teste border border-danger" style=" padding: 10px;  margin-top: 20px; background-color:#e9ecef; ">    
                        <span  class="teste" ><h4>CONTRATOS DE AQUISIÇÃO</h4><hr></span>
                            <span  class="teste" >DA ENTREGA<hr></span>
                            <div  class="teste row"> 
                                <div  class="teste col-md-3 mb-3  "  >
                                    <label for="cperiodo_entrega">Periodo  Entrega:</label>
                                    <input class="form-control" Type="tex" name="periodo_entrega" id="cprazo_entrega"  value="<?php if (isset($_SESSION['dados']['periodo_entrega'])) echo $_SESSION['dados']['periodo_entrega']; ?>" >
                                </div>
                                <div  class="col-md-3 mb-3"  >
                                    <label for="ctipo_contagem_entrega"> Contagem:</label>
                                    <select class="custom-select d-block w-100"  Type="text" name="tipo_contagem_entrega" >				
                                        <option selected><?php if (isset($_SESSION['dados']['tipo_contagem_entrega'])) echo $_SESSION['dados']['tipo_contagem_entrega']; ?></option>
                                        <option value="1">Dias Úteis</option>
                                        <option value="2">Dias Corridos</option>				
                                       			
                                    </select>
                                </div>
                                <div  class="teste col-md-3 mb-3"  >
                                    <label for="ctipo"> A Partir De:</label>
                                    <select class="custom-select d-block w-100"  Type="text" name="intervalo_entrega"   onchange="mostraDiv(this.value)">				
                                        <option selected><?php if (isset($_SESSION['dados']['intervalo_entrega'])) echo $_SESSION['dados']['intervalo_entrega']; ?></option>
                                        <option value="1">Vigência do Contrato</option>
                                        <option value="2">Assinatura do Contrato</option>				
                                        <option value="3">Outro</option>				
                                    </select>
                                </div>
                                <div id="div5"  class="teste col-md-3 mb-3 "  >
                                    <label for="capartir_data">A PARTIR DESTA DATA :</label>
                                    <input class="form-control" Type="date" name="apartir_data" id="capartir_data"  >
                                </div>
                           <?php if (!empty($id_contrato)) {?>     
                                <div  class="teste col-md-12 mb-3  "  >
                                    <label for="cprazo_entrega">DATA ENTREGA:</label>
                                    <input class="form-control" Type="date" name="prazo_entrega" id="cprazo_entrega"  value="<?php echo $prazo_entrega; ?>" >

                                </div>
                           <?php } ?>
                                </div>
                            <span  class="teste div2" > DA GARANTIA<hr></span>
                            <div class="teste row"> 
                                <div  class="teste col-md-4 mb-4  div2 ">
                                    <label for="cvig_garantia">Periodo Vigencia da Garantia:</label>
                                    <input class="form-control" Type="number" name="vig_garantia" min="1"  max="999" id="cvig_garantia" value="<?php if (isset($_SESSION['dados']['vig_garantia'])){ echo $_SESSION['dados']['vig_garantia']; } elseif (isset ($id_contrato)){echo $vig_garantia;}?>" >
                                </div>
                               </div>
                            <span   class="teste" > DA GARANTIA DE EXECUÇÃO DO CONTRATO<hr></span>
                            <div class="teste row"> 
                              
                                <div  class=" teste col-md-3 mb-3">
                                    <label for="cperiodo_garantia"> Periodo G. Excução:</label>
                                    <input class="form-control" Type="text" name="periodo_garantia_exc" id="cvig_contrat" value="<?php if (isset($_SESSION['dados']['periodo_garantia_exc'])){ echo $_SESSION['dados']['periodo_garantia_exc'];}  elseif (!empty ($id_contrato)){echo $periodo_garantia_exc;}  ?>" >
                                </div> 
                                 <div  class="col-md-3 mb-3"  >
                                    <label for="ctipo_contagem_entrega_exec"> Contagem:</label>
                                    <select class="custom-select d-block w-100"  Type="text" name="tipo_contagem_entrega_exec" >				
                                        <option selected><?php if (isset($_SESSION['dados']['tipo_contagem_entrega_exec'])) echo $_SESSION['dados']['tipo_contagem_entrega_exec']; ?></option>
                                        <option value="1">Dias Úteis</option>
                                        <option value="2">Dias Corridos</option>				
                                      			
                                    </select>
                                </div>
                               <div  class=" teste col-md-3 mb-3">
                                    <label for="ctipo"> A partir De:</label>
                                    <select class="custom-select d-block w-100"  Type="text" name="intervalo_garantia"    >				
                                        <option selected><?php if (isset($_SESSION['dados']['intervalo_garantia'])) echo $_SESSION['dados']['intervalo_garantia']; ?></option>
                                        <option value="1">Vigência do Contrato</option>
                                        <option value="2">Assinatura do Contrato</option>				

                                    </select>
                                </div>
                                
                               <div  class=" teste col-md-3 mb-3">
                                    <label for="percentual_garantia"> Percentual:</label>
                                    <input class="form-control" Type="number" name="percentual_garantia" id="campovalor6"  value="<?php if (isset($_SESSION['dados']['percentual_garantia'])) echo $_SESSION['dados']['percentual_garantia']; ?>" >
                                </div> 
                                
                                <div  class=" teste col-md-4 mb-3">
                                    <label for="centrega_garantia_exc">Data Da Entrega da Garantia Atual:</label>
                                    <input class="form-control" Type="date" name="entrega_garantia_exc" id="centrega_garantia_exc"  value="<?php echo $entrega_garantia_exc; ?>" >

                                </div>
                            </div>
                            </div>
                         
<?php } ?>
<?php if ($variante_b == 1 || $variante_a == 1  ) { ?>
                            <div class="teste1 border border-danger" style=" padding: 10px; margin-top: 20px; background-color:#e9ecef; ">    
                  <span  class="teste1 " ><h4>CONTRATOS DE SERVIÇO</h4><hr> </span>
                            <span  class="teste1" > DA FISCALIZAÇÃO DOS SERVIÇOS E DOS NIVEIS DE SEVERIDADE<hr></span>
           
                                <div  class="teste1 row"> 
                                    <div   class="teste1 form-group col-md-4">
                                        <label for="cvig_contrat">TIPO DE CHAMADO PREDOMINANTE:</label>
                                        <select class="form-control"  Type="number" name="tip_chamado" id="ctip_chamado"  maxlength="40" value="<?php if (isset($_SESSION['dados']['tip_chamado'])) echo $_SESSION['dados']['tip_chamado']; ?>" >
                                            <option selected><?php if (isset($_SESSION['dados']['tip_chamado'])){ echo $_SESSION['dados']['tip_chamado']; } elseif (!empty  ($id_contrato)){echo $tip_chamado;} ?></option>
                                            <option value= "1">1 - DO ATENDIMENTO</option>	
                                            <option value= "2">2 - DO CHAMADO</option>
                                        </select>
                                    </div> 
                                    <div   class="teste1 form-group col-md-8">
                                        <label for="cvig_contrat">TIPO DE PENALIDADE:</label>
                                        <select class="form-control"  Type="text" name="parametro_multa" id="cparametro_multa"  maxlength="40" value="<?php if (isset($_SESSION['dados']['parametro_multa'])) echo $_SESSION['dados']['parametro_multa']; ?>" >
                                            <option selected><?php if (isset($_SESSION['dados']['parametro_multa'])) {echo $_SESSION['dados']['parametro_multa']; } elseif (!empty  ($id_contrato)){echo $parametro_multa;} ?></option>
                                            <option value= "1">1 - X% DO VALOR TOTAL DO ITEM * HORAS DE ATRASO</option>	
                                            <option value= "2">2 - X% DO VALOR DO CONTRATO / 60 * HORAS DE ATRASO</option>
                                            <option value= "3">3 - VALOR ESPECIFICADO PARA A SEVERIDADE * HORAS DE ATRASO</option>
                                            <option value= "4">4 - X% DO VALOR DO CONTRATO * HORAS DE ATRASO</option>
                                            <option value= "5">5 - X% DO VALOR DO TOTAL MENSAL (TODAS REGIONAIS) * HORAS DE ATRASO</option>
                                            <option value= "6">6 - X% DO VALOR DO MENSAL PARA REGIONAL * HORAS DE ATRASO</option>
                                           </select>
                                    </div> 
                                </div> 

                            <br>
                           </div>  
<?php } ?>
                     
                        <hr>
                        <div class="row">
                            <div class="col-md-12 mb-10">
                               <?php if(!empty($id_contrato)){ ?> 
                                <input type="hidden" name="id_contrato" value="<?php echo $id_contrato; ?>" />
                                <input type="hidden" name="valor_garantia_exc" value="<?php echo $valor_garantia_exc; ?>" />
                                <?php } ?>
                                <button type="submit" name="Prosseguir "  class="btn btn-primary btn-lg btn-block" >Cadastrar</button>
                                <input type="hidden" name="submitted" value="TRUE" />
                            </div>
                        </div> 
                    </form> 
                    <br>
                    <br>
<?php unset($_SESSION['dados']); ?>                                        
                </div
            </div>
        </div> 
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script>
                                    function mostraDiv(valor)
                                    {
                                        if (valor == "3")
                                        {
                                            document.getElementById("div5").style.display = "block";
                                        } else if (valor == "1")
                                        {
                                            document.getElementById("div5").style.display = "none";
                                        } else if (valor == "2")
                                        {
                                            document.getElementById("div5").style.display = "none";
                                        }
                                    }
        </script>
         <script>
            var aqui = document.getElementsByClassName("teste");
            var servic = document.getElementsByClassName("teste1");

            console.log(aqui);

            function esconDiv(valor)
            {
                if (valor == "SERVIÇOS")
                {
                    for (var c = 0; c < aqui.length; c++) {
                  aqui[c].style.display = "none";
                  servic[c].style.display = "block";
                     
                    }
                    
                } else if (valor == "AQUISIÇÃO")
                {
                 
                    for (var c = 0; c < servic.length; c++) {
                   servic[c].style.display = "none";
                   aqui[c].style.display = "block";   
                    }
                } else if (valor == "SOLUÇÃO")
                {
                 
                    for (var c = 0; c < servic.length; c++) {
                   servic[c].style.display = "block";
                   aqui[c].style.display = "block";   
                    }
                }
                
            }

        </script>
    </body>
</html>