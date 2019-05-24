
<?php
session_start();
require_once'Funcoes/func_data.php';
require_once 'database_gac.php';
$assunt = "<i class='far fa-handshake'></i>  Cadastro de Contrato";
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

        </script>	

        <script>
            function esconDiv(valor)
            {
                if (valor == "SERVIÇOS")
                {
                    document.getElementById("div2").style.display = "none";
                    document.getElementById("div3").style.display = "none";
                    document.getElementById("div4").style.display = "none";
                    document.getElementById("div5").style.display = "none";
                } else if (valor == "AQUISIÇÃO")
                {
                    document.getElementById("div2").style.display = "block";
                    document.getElementById("div3").style.display = "block";
                    document.getElementById("div4").style.display = "block";
                    document.getElementById("div5").style.display = "block";

                }
            }
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
        <?php include_once 'image_header5.php' ?>
           <span style="position: absolute; margin-top: -125px; margin-left: 90%;"><a class="btn btn-danger" href="" onclick="opener.location.reload(); window.close();">FECHAR</a></span>
           <span style="position: absolute; margin-top: -125px; margin-left: 75%;"><a class="btn btn-primary"  href="#"  onclick="window.open('cad_prestador.php', 'popup1', 'width=1000,height=600,scrolling=auto,top=0,left=0'); return false;"> <i class="fas fa-dolly-flatbed"></i>  CADASTRAR NOVO FORNECEDOR</a></span>
        <div  class=" container-fluid    "  style="margin-top: 60px">
            <div  class="row  justify-content-center" >
                <div class="col-md-10 ">

                    <?php
                    if (isset($_SESSION['msg31'])) {
                        echo $_SESSION['msg31'];
                        unset($_SESSION['msg31']);
                    }
                    ?>

                    <form id= "fmr1"  class="needs-validation"   action="proce_contrato.php"  method="post" novalidate>
                        <div class="row"> 
                            <div class="col-md-2 mb-3">
                                <label for="ctipo">TIPO</label>
                                <select class="custom-select d-block w-100"  Type="text" name="tipo" id="ctipo"  onchange="esconDiv(this.value)" >				
                                    <option selected><?php if (isset($_SESSION['dados']['tipo'])) echo $_SESSION['dados']['tipo']; ?></option>
                                    <option value="AQUISIÇÃO">AQUISIÇÃO</option>
                                    <option value="SERVIÇOS">SERVIÇOS</option>						
                                    <option value="SOLUÇÃO">SOLUÇÃO</option>
                                </select>
                            </div>

                            <div class="col-md-2 mb-3">
                                <label for="cnatureza">ÁREA ADMINISTRADORA:</label>
                                <select class="custom-select d-block w-100"  Type="text" name="natureza" id="cnatureza"   ><br />				
                                    <option selected><?php if (isset($_SESSION['dados']['natureza'])) echo $_SESSION['dados']['natureza']; ?></option>
                                    <option value="GACAD">GACAD</option>
                                    <option value="GACAM">GACAM</option>						
                                </select>
                                <br/>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="cvig_contrat">MÉTODO CÁLCULO:</label>
                                <select class="form-control"  Type="number" name="tip_chamado" id="ctip_chamado"  maxlength="40" value="<?php if (isset($_SESSION['dados']['tip_chamado'])) echo $_SESSION['dados']['tip_chamado']; ?>" >
                                    <optgroup label="TIPO DE CHAMADO">
                                        <option selected><?php if (isset($_SESSION['dados']['tip_chamado'])) echo $_SESSION['dados']['tip_chamado']; ?></option>
                                        <option value= "1">1 - DO ATENDIMENTO</option>	
                                        <option value= "2">2 - DO CHAMADO</option>
                                    </optgroup>
                                </select><p>	
                            </div> 
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="crg" >RG:</label>
                                <input class="form-control" Type="text" name="rg" id="crg"  value="<?php if (isset($_SESSION['dados']['rg'])) echo $_SESSION['dados']['rg']; ?>" />
                            </div>
                            <div class="form-group col-md-2">
                                <label for="cstatus">STATUS:</label>
                                <select class="custom-select d-block w-100" type="text" name="status" id="cstatus" value="<?php if (isset($_SESSION['dados']['status'])) echo $_SESSION['dados']['status']; ?>"  required>
                                    <option selected><?php if (isset($_SESSION['dados']['status'])) echo $_SESSION['dados']['status']; ?></option>
                                    <option value= "VIGENTE">VIGENTE</option>	
                                    <option value="VIGENTE/GARANTIA">VIGENTE/GARANTIA</option>
                                    <option value="ENCERRADO">ENCERRADO</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="forn">PRESTADOR/ FORNECEDOR:</label>
                                <select class="form-control" id="forn" name="id_prestador" value="<?php if (isset($_SESSION['dados']['id_prestador'])) echo $_SESSION['dados']['id_prestador']; ?>" >
                                    <option selected><?php if (isset($_SESSION['dados']['id_prestador'])) echo $_SESSION['dados']['id_prestador']; ?></option>  
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
                                <label for="cd_Assinatura">DATA DA ASSINATURA:</label>
                                <input class="form-control" Type="Date" name="d_Assinatura" id="cd_Assinatura"  value="<?php if (isset($_SESSION['dados']['d_Assinatura'])) echo $_SESSION['dados']['d_Assinatura']; ?>" >
                            </div>
                        </div> 
                        <div class="form-row">				
                            <div class="form-group col-md-2">
                                <label for="campovalor" >VALOR CONTRATADO:</label>			 
                                <input class="form-control"  Type="text"   name="valor_Contratado" id="campovalor" value="<?php if (isset($_SESSION['dados']['valor_Contratado'])) echo $_SESSION['dados']['valor_Contratado']; ?>" >
                            </div> 
                            <div class="form-group col-md-10">
                                <label for="cobjeto">OBEJTO:</label>
                                <input class="form-control" Type="text" name="objeto" id="cobjeto" value="<?php if (isset($_SESSION['dados']['objeto'])) echo $_SESSION['dados']['objeto']; ?>" />
                            </div>
                            <div class="form-group col-md-2">
                                <label for="n_siscor" >SISCOR INICIAL:</label>
                                <input class="form-control" Type="text" name="n_siscor" id="cn_siscor"  value="<?php if (isset($_SESSION['dados']['n_siscor'])) echo $_SESSION['dados']['n_siscor']; ?>" >
                            </div>
                            <div class="form-group col-md-2">
                                <label for="cprojeto_basico"  >PROJETO BÁSICO:</label>
                                <input class="form-control" Type="text" name="projeto_basico" id="cprojeto_basico" value="<?php if (isset($_SESSION['dados']['projeto_basico'])) echo $_SESSION['dados']['projeto_basico']; ?>" />
                            </div>
                            <div class="form-group col-md-4">
                                <label for="n_processo" >Nº PROCESSO:</label>
                                <input class="form-control" Type="text" name="n_processo" id="cn_processo" size="15" maxlength="40" placeholder= "Nº Processo Verde"value="<?php if (isset($_SESSION['dados']['n_processo'])) echo $_SESSION['dados']['n_processo']; ?>" />
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="cvig_contrat"> VIGÊNCIA CONTRATUAL:</label>
                                <input class="form-control" Type="number" name="vig_contrat" id="cvig_contrat" value="<?php if (isset($_SESSION['dados']['vig_contrat'])) echo $_SESSION['dados']['vig_contrat']; ?>" >
                            </div> 
                            <div class="col-md-2 mb-3">
                                <label for="cd_Inic_vige_contr">INÍCIO VIG. CONTRATUAL:</label>
                                <input class="form-control"  Type="Date" name="d_Inic_vige_contr" id="cd_Inic_vige_contr" size="40" maxlength="40" value="<?php if (isset($_SESSION['dados']['d_Inic_vige_contr'])) echo $_SESSION['dados']['d_Inic_vige_contr']; ?>">
                            </div> 

                        </div> 
                        <div class="row">
                            <div id="div2"  class="col-md-2 mb-3 div2 "  >
                                <label for="cprazo_entrega">DATA ENTREGA:</label>
                                <input class="form-control" Type="date" name="prazo_entrega" id="cprazo_entrega"  value="<?php if (isset($_SESSION['dados']['prazo_entrega'])) echo $_SESSION['dados']['prazo_entrega']; ?>" >
                            </div>
                            <div  id="div3" class="col-md-2 mb-3  div2 ">
                                <label for="cvig_garantia">PERIODO VIG GARANTIA:</label>
                                <input class="form-control" Type="number" name="vig_garantia" min="1"  max="999" id="cvig_garantia" value="<?php if (isset($_SESSION['dados']['vig_garantia'])) echo $_SESSION['dados']['vig_garantia']; ?>" >
                            </div>
                            <div id="div4" class="col-md-2 mb-3 div2 ">
                                <label for="cvig_garantia">INICIO VIG GARANTIA:</label>
                                <input class="form-control" Type="date" name="d_recebimento" min="1"  max="999" id="cvig_garantia" value="<?php if (isset($_SESSION['dados']['d_recebimento'])) echo $_SESSION['dados']['d_recebimento']; ?>" disabled>
                            </div>
                            <div id="div5" class="col-md-2 mb-3  div2 ">
                                <label for="cvig_garantia">FIM VIG GARANTIA:</label>
                                <input class="form-control" Type="date" name="fim_vig_garat" min="1"  max="999" id="cvig_garantia" value="<?php if (isset($_SESSION['dados']['fim_vig_garat'])) echo $_SESSION['dados']['fim_vig_garat']; ?>" disabled>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="cpos_prorrogacao">PRORROGAÇÃO</label>
                                <select class="form-control"  Type="text" name="pos_prorrogacao" id="cpos_prorrogacao"  maxlength="40" onchange="esconDiv2(this.value)" >
                                    <optgroup label="Selecione">
                                        <option selected><?php if (isset($_SESSION['dados']['pos_prorrogacao'])) echo $_SESSION['dados']['pos_prorrogacao']; ?></option>
                                        <option value= "SIM">SIM</option>	
                                        <option value= "NÃO">NÃO</option>
                                    </optgroup>
                                </select><p>	
                            </div> 

                            <div id="div1" class="col-md-2 mb-3 div1">
                                <label for="cperiodo_prorrogacao">PERIODO DE PRORROGAÇÃO:</label>
                                <input class="form-control" Type="number" name="periodo_prorrogacao"  id="cperi_Pror" value="<?php if (isset($_SESSION['dados']['periodo_prorrogacao'])) echo $_SESSION['dados']['periodo_prorrogacao']; ?>" >                   
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="clink_pv">URL PROCESSO VERDE:</label>		  
                                <input class="form-control" Type="url" name="link_pv" id="clink_pv"  value="<?php if (isset($_SESSION['dados']['link_pv'])) echo $_SESSION['dados']['link_pv']; ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="clink_ged">URL GEDIG:</label>	
                                <input class="form-control" Type="url" name="link_ged" id="clink_ged" value="<?php if (isset($_SESSION['dados']['link_ged'])) echo $_SESSION['dados']['link_ged']; ?>">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="clink_proscorm">URL PROPOSTA COMERCIAL:</label>	
                                <input class="form-control" Type="url" name="link_proscorm" id="clink_proscorm" value="<?php if (isset($_SESSION['dados']['link_proscorm'])) echo $_SESSION['dados']['link_proscorm']; ?>" >
                            </div>	
                            <div class="row">
                                <div style="margin-left: 13px;" class="col-md-12 mb-3">
                                    <p><h4><i class="fas fa-address-book"></i> Atribuição de Responsabilidade Fiscal Administrativa.</h4></p>  
                                    <label for="forn"> Nome:</label>
                                    <select class="form-control" id="forn" name="id_usuario" >
                                        <option></option>  
                                        <?php
                                        $q1 = "SELECT * FROM  usuario WHERE permissao ='3' ORDER BY nome ASC ";
                                        $r1 = mysqli_query($conection, $q1);
                                        while ($row = mysqli_fetch_assoc($r1)) {
                                            ?>
                                            <option value = "<?php echo $row ['id_usuario']; ?>"><?php echo $row ['nome']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <hr>
                            <div class="col-md-12 mb-3">
                                <input type="submit" name="Prosseguir " value="Cadastrar"  class="btn btn-primary btn-lg btn-block" >
                                <input type="hidden" name="submitted" value="TRUE" />
                            </div>
                        </div> 

                    </form>  
                    <?php unset($_SESSION['dados']); ?>                                        
                </div>
            </div>
        </div> 
        
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    </body>
</html>