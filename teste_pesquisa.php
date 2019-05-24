

<table class="table table-hover table-striped table-sm table-bordered light"   >
    <thead class="thead-dark ">
    <th scope="col">Regional</th> 
    <th scope="col">Responsavel</th> 
    <th style="background-color: #df7700;">Recebimento da Nota</th> 
    <th scope="col">RG</th> 
    <th scope="col">Referência</th> 
    <th style="background-color: #df7700;">Relatório Entregue?</th> 
    <th scope="col"> Nota Fiscal</th>
    <th scope="col" style=" width:70px;">CNPJ de Faturamento</th>
    <th scope="col">Valor da Parcela</th>
    <th scope="col">Início do Período</th>
    <th scope="col">Fim do Período</th>
    <th scope="col">Data da Assinatura</th>
    <th scope="col">SISCOR</th>
    <th style="background-color: #df7700;">Vencimento</th>
    <th style="background-color: #df7700;">Medido?</th>
    <th style="background-color: #df7700;">Atestado?</th>
    <th style="background-color: #df7700;">Autuado?</th>
    <th scope="col">Editar</th>
    <th scope="col">Deletar</th>

</thead> 

<?php
$sqlcolaborador = "SELECT * FROM responsaveis WHERE responsabilidade='Fiscal Administrativo'  AND nome='$nome'";
$resultado1 = mysqli_query($conection, $sqlcolaborador)or die('Não foi possivel conectar ao MySQL');
while ($registro1 = mysqli_fetch_array($resultado1)) {

    $id_contrato = $registro1['id_contrato'];
    $sqlcorre = "SELECT * FROM pagamentos WHERE   MONTH(data_inicio_per)='$mes_pesquisa' AND  YEAR(data_inicio_per)='$ano_pesquisa' AND id_contrato ='$id_contrato' ORDER BY (data_fim_per) DESC";
    $resultado = mysqli_query($conection, $sqlcorre)or die('Não foi possivel conectar ao MySQL');

    while ($registro = mysqli_fetch_array($resultado)) {




        $id_pag = $registro['id_pag'];
        $id_tipo = $registro['id_tipo'];
        $n_parcela = $registro['n_parcela'];
        $id_tipo = $registro['id_tipo'];
        $id_contrato = $registro['id_contrato'];
        $d_vencimento_pag = $registro['d_vencimento_pag'];
        $data_inicio_per = $registro['data_inicio_per'];
        $cnpj_faturamento = $registro['cnpj_faturamento'];
        $relatorio = $registro['relatorio'];
        $medido = $registro['medido'];
        $ateste = $registro['ateste'];
        $aut_nota = $registro['aut_nota'];
         $nota = $registro['nota_fiscal'];


        if ($medido == 'Sim') {
            $medido = "<font style='color:green;'><i class='fas fa-check-circle'></i></font>";
        } else {
            $medido = "<font style='color:red ;'><i class='fas fa-times-circle'></i></font>";
        }
        if ($ateste == 'Sim') {
            $ateste = "<font style='color:green;'><i class='fas fa-check-circle'></i></font>";
        } else {
            $ateste = "<font style='color:red ;'><i class='fas fa-times-circle'></i></font>";
        }
        if ($aut_nota == 'Sim') {
            $aut_nota = "<font style='color:green;'><i class='fas fa-check-circle'></i></font>";
        } else {
            $aut_nota = "<font style='color:red ;'><i class='fas fa-times-circle'></i></font>";
        }
        if ($relatorio == 'Sim') {
            $relatorio = "<font style='color:green;'><i class='fas fa-check-circle'></i></font>";
        } else {
            $relatorio = "<font style='color:red ;'><i class='fas fa-times-circle'></i></font>";
        }

        if (!empty($nota)) {
            $nota = "<font style='color:#007bff;' class='btn btn-outline-primary'> " . $nota . " </font>";
        } else {
            $nota = "<font style='color:red ;'>Pendente</font>";
        }




        $ex = explode("-", $registro['data_fim_per']);
        $ano = $ex[0];
        $mes_ref = $ex[1];

        $vencimento = explode("-", $d_vencimento_pag);
        $ano_vencimento = $vencimento[0];
        $mes_vencimento = $vencimento[1];
        $dia_vencimento = $vencimento[2];

        $periodo = explode("-", $data_inicio_per);
        $ano_periodo = $periodo[0];
        $mes_periodo = $periodo[1];


        $ref = $mes_ref . '/' . $ano;



        $sql_contrato = "SELECT * FROM contrato WHERE id_contrato= $id_contrato ";
        $result = mysqli_query($conection, $sql_contrato)or die('Não foi possivel conectar ao MySQL');
        while ($registro2 = mysqli_fetch_array($result)) {
            $mine = $registro2['mine'];
            ?>
            <tbody>
                <tr >
                    <td style=" font-size: 30px; font-weight: bold;font-family: time new romam; " ><a class="btn btn-outline-primary"  href="cad_pag.php?action=0&id_tipo=<?php echo $id_tipo ?>"><?php echo $registro['regional']; ?></a></td>
                    <td><?php echo $nome; ?></td>
                    <td ><?php echo inverteData($registro['recebimento_nota']); ?></td>
                    <td class="set1"><a class="btn btn-outline-primary" href="idex.php?id=<?php echo $id_contrato ?>"><?php echo $registro2['rg']; ?></a></td>
                    <td ><?php echo $ref; ?></td>


                    <td class="set1"> <?php echo $relatorio; ?></td>
                    <td class="set1"> <a  href="#"  data-toggle="modal" data-target="#exampleModalLong8<?php echo $id_pag ?>"><?php echo $nota; ?></a></td>
                    <td><?php echo $cnpj_faturamento; ?></td>
                    <td class="set1"> <a data-toggle="modal"  <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?>  data-target="#exampleModal2<?php echo $id_pag ?>" <?php } ?> href="#"><?php echo number_format($registro['valor_parcela'], 2, ',', '.'); ?></a></td>
                    <td><?php echo inverteData($registro['data_inicio_per']); ?></td>
                    <td ><?php echo inverteData($registro['data_fim_per']); ?></td>
                    <td class="set1"><?php echo inverteData($registro['d_assinatura_dig']); ?></td>
                    <td><?php echo $registro['siscor']; ?></td>        
                    <td class="set1"><?php echo inverteData($registro['d_vencimento_pag']); ?></td>       

                    <td class="text-center" style=" font-size: 20px;"><?php echo $medido; ?></td>
                    <td class="text-center" style=" font-size: 20px;"><?php echo $ateste; ?></td>
                    <td class="text-center" style=" font-size: 20px;"><?php echo $aut_nota; ?></td>



                    <td class="set1">

                        <a data-toggle="modal" data-target="#exampleModal36<?php echo $id_pag ?>" href="#">
                            <i class="far fa-edit"></i> 
                        </a>
                    </td>
                    <td class="set1">
                        <a  href="#"  data-toggle="modal" data-target="#exampleModal5<?php echo $registro['id_pag'] ?>">

                            <i class="fas fa-eraser"></i> 
                        </a>
                    </td>

                </tr>
            </tbody>
            <!-- Modal -->

            <div class="modal fade"  id="exampleModal36<?php echo $id_pag ?>"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"id="exampleModalLabel" text="center" ><font color='RED'><?php echo 'RG: ' . $rg . ' - ' . 'REGIONAL: ' . $registro['regional'] ?></font></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <form  class="needs-validation "   action="proc_cad_pagamento.php?action=ateste"  method="post" novalidate>         
                                <div  class="container" >
                                    <div class="form-row">
                                        <div class="form-group col-md-6">                                             

                                            <label class="mods2" for="crecebimento_nota" >RECEBIMENTO NOTA FISCAL: </label>

                                            <input Type="date" class="form-control "   name="recebimento_nota"    value="<?php echo $registro['recebimento_nota']; ?>" />
                                        </div>
                                        <div class="form-group col-md-4" style="margin-left:20px;">
                                            <div class="custom-control custom-radio">
                                                <input value= "1" type="radio" id="customRadio1" name="all" class="custom-control-input">
                                                <label class="custom-control-label" for="customRadio1">Todas As Notas</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">                                             

                                            <label class="mods2" for="crelatorio" >RECEBIMENTO RELATÓRIO ? </label>
                                            <select class="custom-select"name="relatorio" id="caplicacao_multa"  >
                                                <option selected><?php echo $registro['relatorio']; ?></option>
                                                <option value="Sim">Sim</option>
                                                <option value="Nao">Não</option>                                                           
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">		
                                        <div class="form-group col-md-6">
                                            <label for="cnota_fiscal" >NOTA FISCAL:</label>
                                            <input class="form-control" Type="text" name="nota_fiscal" id="cnota_fiscal"  value="<?php echo $registro['nota_fiscal']; ?>" >
                                        </div>


                                        <div class="form-group col-md-6">
                                            <label for="cvalor_parcela" >VALOR PARCELA:</label>
                                            <input class="form-control" Type="number" name="valor_parcela" id="cvalor_parcela"  value="<?php echo $registro['valor_parcela']; ?>" >
                                        </div>	
                                    </div>		
                                    <div class="form-row">					
                                        <div class="form-group col-md-6">
                                            <label for="cdata_inicio_per" >INICIO PRERIODO:</label>
                                            <input class="form-control" Type="date" name="data_inicio_per" id="cdata_inicio_per"  value="<?php echo $registro['data_inicio_per']; ?>" >
                                        </div>		
                                        <div class="form-group col-md-6">
                                            <label for="cdata_fim_per" >FIM PERIODO:</label>			 
                                            <input class="form-control"  Type="date"   name="data_fim_per" id="cdata_fim_per" value="<?php echo $registro['data_fim_per']; ?>" >
                                        </div>
                                    </div>
                                    <div class="form-row">		
                                        <div class="form-group col-md-6">
                                            <label for="cd_assinatura_dig">DATA ASSINATURA:</label>
                                            <input class="form-control"  Type="date"   name="d_assinatura_dig" id="cd_assinatura_dig" value="<?php echo $registro['d_assinatura_dig']; ?>" >
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="cd_vencimento_pag" >DATA VENCIMENTO:</label>
                                            <input class="form-control" Type="date" name="d_vencimento_pag" id="cd_vencimento_pag"  value="<?php echo $registro['d_vencimento_pag']; ?>" >
                                        </div>
                                    </div>
                                    <div class="form-row">		
                                        <div class="form-group col-md-6">
                                            <label for="csiscor" >SISCOR:</label>
                                            <input class="form-control" Type="text" name="siscor" id="csiscor" value="<?php echo $registro['siscor']; ?>" >
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="cmedido" >MEDIDO:</label>			 
                                            <select class="form-control"  Type="text" name="medido" id="cmedido"  maxlength="40" value="<?php echo $registro['medido']; ?>" >		
                                                <option selected><?php echo $registro['medido']; ?></option>
                                                <option value= "Sim">Sim</option>	
                                                <option value= "Nao">Não</option>		
                                            </select>
                                        </div>

                                    </div>			
                                    <div class="form-row">	
                                        <div class="form-group col-md-6">                                             

                                            <label class="mods2" for="cateste" >ATESTETADO:</label>
                                            <select class="custom-select"name="ateste" id="caplicacao_multa"  value="<?php echo $registro['ateste']; ?>" >
                                                <option selected><?php echo $registro['ateste']; ?></option>
                                                <option value="Sim">Sim</option>
                                                <option value="Nao">Não</option>                                                           
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="caut_nota" >AUTUADO:</label>	        
                                            <select class="form-control"  Type="text" name="aut_nota" id="ctip_chamado"  maxlength="40" value="<?php echo $registro['aut_nota']; ?>" >		
                                                <option selected><?php echo $registro['aut_nota']; ?></option>
                                                <option value= "Sim">Sim</option>	
                                                <option value= "Nao">Não</option>		
                                            </select>
                                        </div>		

                                    </div>                       
                                    <div class="form-row">		
                                        <div class="form-group col-md-12">
                                            <label for="cobser">OBSERVAÇÃO:</label>
                                            <textarea class="form-control"  rows="3" class="form-control" Type="text" name="obser" id="cobs" value="<?php echo $registro['obser']; ?>" ></textarea>
                                        </div>
                                    </div>
                                    <input class="form-control"  type="hidden" name="id_pag" id="cid_pag"  value="<?php echo $id_pag; ?>" >
                                    <input class="form-control"  type="hidden" name="nome" id="cid_pag"  value="<?php echo $nome; ?>" >
                                    <input class="form-control"  type="hidden" name="id_tipo" id="cid_tipo"  value="<?php echo $id_tipo; ?>" >
                                    <input class="form-control"  type="hidden" name="mes_pesquisa" id="cid_tipo"  value="<?php echo $mes_pesquisa; ?>" >
                                    <input class="form-control"  type="hidden" name="ano_pesquisa" id="cid_tipo"  value="<?php echo $ano_pesquisa; ?>" >
                                    <input class="form-control"  type="hidden" name="rg" id="cid_tipo"  value="<?php echo $rg; ?>" >
                                    <input class="form-control"  type="hidden" name="pesquisa" id="cid_tipo"  value="list2" >
                                    <input  class="btn btn-outline-primary" type="submit" name="Prosseguir" value="ENVIAR"  class="btn btn-primary">
                                    <input type="hidden" name="submitted" value="TRUE" />
                                </div>
                            </form>
                        </div>	 
                    </div>
                </div>
            </div>
            <!-- Modal -->


            <!-- Modal (Nomeclatura) -->
            <div class="modal fade" id="exampleModalLong8<?php echo $id_pag ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle"><font color='#0080FF'>PADRÃO NOMECLATURA DOCUMENTOS</font></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form  class=" updates needs-validation "   action="proc_ateste.php?action=finalizadoAteste"  method="post" novalidate>         
                                <div  class="container" >	
                                    <div class="form-row"> 
                                        <div class="form-group col-md-10">                                             


                                            <?php
                                            echo "<p><font color='#0080FF'>NOTAS FISCAIS:</font></p><hr><b>NOTA : </b>" . $dia_vencimento . "-" . $mes_vencimento . "-" . $ano_vencimento . "_" . $mine . "_" . $registro2['rg'] . "_" . "NF-" . $registro['nota_fiscal'] . "_" . $mes_periodo . "-" . $ano_periodo . "_" . $registro['regional'] . "</p>" .
                                            "<hr><p><font color='#0080FF'>PROCESSO VERDE:</font></p><hr>" . "<p><b>TRD : </b>TRD_" . $mes_periodo . "-" . $ano_periodo . "_" . $registro2['rg'] . "_" . "NF-" . $registro['nota_fiscal'] . "_" . $registro['regional'] . "</p>" .
                                            "<p><b>ANS : </b>ANS_" . $registro2['rg'] . "_" . $mes_periodo . "-" . $ano_periodo . "</p>" . "<hr><p><font color='#0080FF'>MEDIÇÃO:</font></p><hr>" .
                                            "<p><b>RECEBIMENTO NOTA: </b>" . inverteData($registro['recebimento_nota']) . "</p>" . "<p><b>TRD VALIDADO PELO SISCOR: </b>" . $registro['siscor'] . "</p>";

                                            ;
                                            ?>

                                        </div>                                                     
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        <?php }
    }
} ?>
    
