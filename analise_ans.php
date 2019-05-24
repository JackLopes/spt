
<?php
session_start();

require_once 'database_gac.php';


if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

if (isset($_POST['rg'])) {
    $rg = $_POST['rg'];
}

if (isset($_POST['nom'])) {
    $nom = $_POST['nom'];
}

if (isset($_POST['mes'])) {
    $mes = $_POST['mes'];
}

if (isset($_POST['ano'])) {
    $ano = $_POST['ano'];
}

$anomes= $ano."-".$mes."-30";



$dados_inicial = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$_SESSION['dados2'] = $dados_inicial;

$meses = array('', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
$me_string = @$meses[$mes];

if (isset($_SESSION['dados'])) {

    $id = $_SESSION['dados']['id'];
    $rg = $_SESSION['dados']['rg'];
    $nom = $_SESSION['dados']['prestador'];
    $mes = $_SESSION['dados']['mes'];
    $ano = $_SESSION['dados']['ano'];
}

// prepearação de variaveis para uso especifico,  no mês de janeiro sendo dezembro seu mes anterio, não valendo a expressão  mes anterio = mês -1.
if ($mes == '1') {
    $mes_anterior = '12';
} else {
    $mes_anterior = (int) $mes - 1;
}
$ano_anterior = (int) $ano - 1;

$q2 = "SELECT mes FROM reg_relatorio WHERE id_contrato = '$id' AND mes='$mes'  AND ano = '$ano'";
$rs = mysqli_query($conection, $q2);
$num = mysqli_num_rows($rs);

if ($num == 0) {


    $q = "INSERT INTO reg_relatorio (id_contrato, conclusao_preventiva, conclusao_corretiva, acompanhado, analizado, mes, ano, prestador, rg ) VALUES
             ('$id','', '','','', '$mes', '$ano', '$nom', '$rg')";
    $r1 = mysqli_query($conection, $q);
}

function inverteData($data) {
    if (count(explode("/", $data)) > 1) {
        return implode("-", array_reverse(explode("/", $data)));
    } elseif (count(explode("-", $data)) > 1) {
        return implode("/", array_reverse(explode("-", $data)));
    }
}

$assunt = " <h5><center>Análise de Níveis de Serviço - ANS (Manutenção) - " . $me_string . " de " . $ano . "</center></h5> ";
?>
<!doctype html>
<html lang="pt">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet"  type="text/css" href="css/Styleanalise.css" media="screen"/>
        <link rel="stylesheet" href="css/bootstrap.css" >
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>

    </head>
    <body style="background-color: #cfcfcf">
        <nav class="navbar navbar-light bg-light">            
            <a class="navbar-brand" href="ans.php">RETORNAR  </a>
            <a class="navbar-brand" href="idex.php?id=<?php echo $id ?>">Voltar </a>
            <img src="img/serpro5.jpg" width="30" height="30" class="d-inline-block align-top" style="padding-right:5px" alt="">
            </a>
        </nav>
        <?php include_once 'image_header7.php';
        ?>
        <div  class=" master container-fluid " >
            <div class="form-group col-md-12">	
                <div  id = "tit2">
                    <?php echo $nom . "   <b> - RG: </b>" . $rg; ?>    

                </div>

                <br/>	
                <br/>	
                <?php
                if (isset($_SESSION['msg8'])) {
                    echo $_SESSION['msg8'];
                    unset($_SESSION['msg8']);
                }
                ?>
                <h6 class="descri">Corretiva (Atendimentos encerrados)</h6>
                <table  class="table table-hover table-striped table-sm table-bordered bg-light"   >
                    <thead class="thead-dark ">
                        <tr>
                            <th   style="background-color: #0080FF;">Nº Chamado</th>
                            <th scope="col">Critica</th>
                            <th scope="col">Data da Abertura</th>
                            <th scope="col">Hora da Abertura</th>
                            <th scope="col">Data do Atendimento</th>
                            <th scope="col">Hora do Atendimento</th>
                            <th scope="col">Data de Conclusão</th>
                            <th scope="col">Hora da Conclusão</th>
                            <th scope="col">Prazo do Atendimento</th>
                            <th scope="col">Horas Excedidas</th>
                            <th scope="col">Prazo de Conclusão</th> 
                            <th scope="col">Excedido Conclusão</th>
                            <th   style="background-color: #0080FF;">Total Horas Excedentes </th>
                            <th scope="col">Necessidade On-site?</th>
                            <th scope="col">Atendimento On-site?</th>
                            <th scope="col">Previsão de Multa?</th>
                            <th   style="background-color: #0080FF;">Aplicar Multa?</th>
                            <th scope="col">Status</th>
                        </tr> 
                    </thead>
                    <?php
                    $sqlcorre1 = "SELECT * FROM corretivas WHERE id_contrato = '$id' AND  mes_ref= '$mes'  AND ano = '$ano' AND status!='Pendente'  ";
                    $resultado1 = mysqli_query($conection, $sqlcorre1)or die('Não foi possivel conectar ao MySQL');
                    while ($registro1 = mysqli_fetch_array($resultado1)) {
                        $status = $registro1['status'];
                        if ($status == 1) {
                            $status = 'Ok';
                        }
                        $data1 = $registro1['data_abertura'];
                        $data1 = inverteData($data1);

                        $data2 = $registro1['data_atendimento'];
                        $data2 = inverteData($data2);

                        $data3 = $registro1['data_conclusao'];
                        $data3 = inverteData($data3);
                        $necessidade_on_site = $registro1['necessidade_on_site'];
                        $atendimento_onsite = $registro1['atendimento_onsite'];


                        $id_corretiva = $registro1['id_corretiva'];

                        if ($registro1['n_chamado'] == 'Nao Houve') {
                            $data3 = '00/00/0000';
                        }
                        ?>
                        <tr>
                            <td class = "td2" ><?php echo $registro1['n_chamado']; ?></td>                               
                            <td class = "td2" ><?php echo $registro1['tipo_severidade']; ?></td>
                            <td class = "td2" ><?php echo $data1; ?></td>
                            <td class = "td2" ><?php echo $registro1['hora_abertura']; ?></td>
                            <td class = "td2" ><?php echo $data2; ?></td>
                            <td class = "td2" ><?php echo $registro1['hora_atendimento']; ?></td>
                            <td class = "td2" ><?php echo $data3; ?></td>
                            <td class = "td2" ><?php echo $registro1['hora_conclusao']; ?></td>
                            <td class = "td2" ><?php echo $registro1['prazo_atendimento']; ?></td>
                            <td class = "td2" ><?php echo $registro1['tempo_excedido_atendimento']; ?></td>
                            <td class = "td2" ><?php echo $registro1['prazo_conclusao']; ?></td>       
                            <td class = "td2" ><?php echo $registro1['tempo_excedido_conclusao']; ?></td>
                            <td class = "td2" ><?php echo $registro1['total']; ?></td>
                            <td class = "td2" ><?php echo $necessidade_on_site; ?></td>
                            <td class = "td2" ><a data-toggle="modal" data-target="#exampleModal4<?php echo $id_corretiva ?>" href="#"><?php echo $atendimento_onsite; ?></td>
                            <td class = "td2" ><?php echo $registro1['previsao_multa']; ?></td>
                            <td class = "td2" ><a data-toggle="modal" data-target="#exampleModal3<?php echo $id_corretiva ?>" href="#"><?php echo $registro1['aplicacao_multa']; ?></td>
                            <td class = "td2" ><?php echo $status; ?></td>                          
                        </tr>
                    <?php } ?>
                </table>

                <h6 class="descri" >Corretiva (Atendimentos Abertos)</h6> 


                <table  class="table table-hover table-striped table-sm table-bordered bg-light"   >
                    <thead class="thead-dark ">
                        <tr>
                            <th   style="background-color: #0080FF;">Nº Chamado</th>
                            <th scope="col">Severidade</th>
                            <th scope="col">Data da Abertura</th>
                            <th scope="col">Hora da Abertura</th>
                            <th scope="col">Data do Atendimento</th>
                            <th scope="col">Hora do Atendimento</th>
                            <th scope="col">Data de Conclusão</th>
                            <th scope="col">Hora da Conclusão</th>
                            <th scope="col">Prazo do Atendimento</th>
                            <th scope="col">Horas Excedidas</th>
                            <th scope="col">Prazo de Conclusão</th> 
                            <th scope="col">Excedido Conclusão</th>
                            <th   style="background-color: #0080FF;">Total Horas Excedentes </th>
                            <th scope="col">Necessidade On-site?</th>
                            <th scope="col">Atendimento On-site?</th>
                            <th scope="col">Previsão de Multa?</th>
                            <th   style="background-color: #0080FF;">Aplicar Multa?</th>
                            <th scope="col">Status</th>
                        </tr> 
                    </thead>
                    <?php
                //                   
                                        
                                                  
                    $sqlcorre = "SELECT * FROM corretivas WHERE id_contrato = '$id' AND status='Pendente' AND data_abertura <='$anomes' AND MONTH(data_abertura)BETWEEN '1' AND '12'   ";
                    $resultado = mysqli_query($conection, $sqlcorre)or die('Não foi possivel conectar ao MySQL');
                    while ($registro = mysqli_fetch_array($resultado)) {
                        $data1 = $registro['data_abertura'];
                        $data1 = inverteData($data1);
                        $data2 = $registro['data_atendimento'];
                        $data2 = inverteData($data2);
                        $data3 = $registro['data_conclusao'];
                        $data3 = inverteData($data3);
                        $necessidade_on_site = $registro['necessidade_on_site'];
                        $atendimento_onsite = $registro['atendimento_onsite'];
                        $id_corretiva = $registro['id_corretiva'];
                        
                        ?>
                        <tr>
                            <td class = "td2" ><?php echo $registro['n_chamado']; ?></td>
                            <td class = "td2" ><?php echo $registro['tipo_severidade']; ?></td>
                            <td class = "td2" ><?php echo $data1; ?></td>
                            <td class = "td2" ><?php echo $registro['hora_abertura']; ?></td>
                            <td class = "td2" ><?php echo $data2; ?></td>
                            <td class = "td2" ><?php echo $registro['hora_atendimento']; ?></td>
                            <td class = "td2" ><?php echo $data3; ?></td>
                            <td class = "td2" ><?php echo $registro['hora_conclusao']; ?></td>
                            <td class = "td2" ><?php echo $registro['prazo_atendimento']; ?></td>
                            <td class = "td2" ><?php echo $registro['tempo_excedido_atendimento']; ?></td>
                            <td class = "td2" ><?php echo $registro['prazo_conclusao']; ?></td>       
                            <td class = "td2" ><?php echo $registro['tempo_excedido_conclusao']; ?></td>
                            <td class = "td2" ><?php echo $registro['total']; ?></td>
                            <td class = "td2" ><?php echo $necessidade_on_site; ?></td>
                            <td class = "td2" ><a data-toggle="modal" data-target="#exampleModal4<?php echo $id_corretiva ?>" href="#"><?php echo $atendimento_onsite; ?></td>
                            <td class = "td2" ><?php echo $registro['previsao_multa']; ?></td>
                            <td class = "td2" ><a data-toggle="modal" data-target="#exampleModal3<?php echo $id_corretiva ?>" href="#"><?php echo $registro['aplicacao_multa']; ?></td>
                            <td class = "td2" ><?php echo $registro['status']; ?></td>                          
                        </tr>
                    <?php } ?>
                </table>
                <h6 class="descri" >Preventiva</h6>

                <table  class="table table-hover table-striped table-sm table-bordered bg-light"   >
                    <thead class="thead-dark ">
                    <th style="background-color:#0080FF;">Nº Chamado</th>
                    <th scope="col">Patrimônios Contemplados</th>
                    <th scope="col">Ano</th> 
                    <th style="background-color:#0080FF;">Mês Planejado</th>
                    <th style="background-color:#0080FF;">Data da Execução</th>

                    <th scope="col">Observação</th>
                    <th scope="col">Previsão de multa?</th>
                    <th   style="background-color: #0080FF;">Aplicar multa?</th>
                    <th scope="col">Status</th>
                    </tr> 
                    <?php
                    $sqlcorre2 = "SELECT * FROM preventivas WHERE id_contrato = '$id'  AND MONTH(data_conclusao)= '$mes'  AND YEAR
(data_conclusao)= '$ano'  ORDER BY d_limite";
                    $resultado2 = mysqli_query($conection, $sqlcorre2)or die('Não foi possivel conectar ao MySQL');
                    while ($registro2 = mysqli_fetch_array($resultado2)) {

                        $status = $registro2['status'];

                        $d_limite = $registro2['d_limite'];
                        $ex = explode("-", $d_limite);
                        $ano = $ex[0];

                        $d_execucao = $registro2['data_conclusao'];
                        $d_execucao1 = inverteData($d_execucao);

                        $id_preventiva = $registro2['id_preventiva'];
                        ?>
                        <tr>
                            <td class = "td2" ><?php echo $registro2['n_chamado']; ?></td> 
                            <td class = "td2" ><?php echo $registro2['patrimonio']; ?></td>
                            <td class = "td2" ><?php echo $id_preventiva; ?></td>
                            <td class = "td2" ><?php echo $registro2['mes']; ?></td>                           
                            <td class = "td2" ><?php echo $d_execucao1; ?></td>

                            <td class = "td2" ><?php echo $registro2['obs']; ?></td>       
                            <td class = "td2" ><?php echo $registro2['previsao_multa']; ?></td>
                            <td class = "td2" >
                                <a  href="" data-toggle="modal" data-target="#exampleModalLong<?php echo $id_preventiva ?>"><?php echo $registro2['aplicacao_multa']; ?></a>
                            </td>
                            <td class = "td2" ><?php echo $status; ?></td>
                        </tr>
                    <?php } ?>
                </table>
                <?php
                $sqlprestador = "SELECT * FROM pagamentos WHERE id_contrato = '$id'  AND  MONTH(data_fim_per)= '$mes ' AND  YEAR(data_fim_per)='$ano' GROUP BY (regional)";
                $resultado = mysqli_query($conection, $sqlprestador)or die('Não foi possivel conectar ao MySQL');
                while ($registro6 = mysqli_fetch_array($resultado)) {
                    $siscor = $registro6['siscor'];
                    $regional_siscor = $registro6['regional'];

                    if (!empty($siscor)) {
                        echo "<h6 id='infor'>" . $regional_siscor . " - SISCOR (TRD): " . $siscor . "</h6>";
                    }
                }
                ?>
                <div id="divisori1">
                    <?php
                    $query5 = "SELECT * FROM reg_relatorio WHERE id_contrato = '$id' AND mes='$mes'  AND ano = '$ano' AND rg = '$rg'";
                    $resu = mysqli_query($conection, $query5);
                    while ($regis = mysqli_fetch_array($resu)) {

                        $id_relatorio = $regis['id_relatorio'];
                        ?>
                        <form action = "proc_analise.php" method = "post">
                            <div class = "row" >
                                <div class = "form-group col-md-12">
                                    <label class = "descri" for = "cconclusao_corretiva">Conclusão Manutenção Corretiva:</label>
                                    <input class = "form-control" Type = "text" name = "conclusao_corretiva" id = "cconclusao_corretiva" value = "<?php echo $regis['conclusao_corretiva']; ?>" />
                                </div>
                                <div class = "form-group col-md-12">
                                    <label class = "descri" for = "cconclusao_preventiva">Conclusão Manutenção Preventiva:</label>
                                    <input class = "form-control" Type = "text" name = "conclusao_preventiva" id = "cobjeto"  value = "<?php echo $regis['conclusao_preventiva']; ?>" />
                                </div>
                            </div>
                            <div class = "row" >
                                <div class = "form-group col-md-6">
                                    <label class = "descri" for = "cacompanhado">Acompanhado por:</label>
                                    <select class = "form-control" id = "forn" name = "acompanhado"  value = "<?php echo $regis['acompanhado']; ?>" >
                                        <option selected><?php echo $regis['acompanhado']; ?></option>  

                                        <?php
                                        $q1 = "SELECT nome FROM  usuario WHERE permissao = '3'";
                                        $r1 = mysqli_query($conection, $q1);
                                        while ($row = mysqli_fetch_assoc($r1)) {
                                            ?>
                                            <option value = "<?php echo $row ['nome']; ?>"><?php echo $row ['nome']; ?></option>
                                        <?php } ?>
                                    </select>	
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="descri" for="canalizado">Analisado por:</label>
                                    <select class="form-control" id="forn" name="analizado"  value = "<?php echo $regis['analizado']; ?>" >
                                        <option selected><?php echo $regis['analizado']; ?></option>  
                                        <?php
                                        $q1 = "SELECT nome FROM  usuario WHERE permissao = '2'";
                                        $r1 = mysqli_query($conection, $q1);
                                        while ($row1 = mysqli_fetch_assoc($r1)) {
                                            ?>
                                            <option value = "<?php echo $row1 ['nome']; ?>"><?php echo $row1 ['nome']; ?></option>
                                        <?php } ?>
                                    </select>	
                                </div>
                                <div class="col-sm-4 ">
                                    <input type="submit" class="btn btn-dark" style="color: #cfcfcf; text-shadow:1px 1px 3px black"  name="submit" value="Salvar Analise"/>
                                    <input Type="hidden" name="id"  value="<?php echo $id; ?>" />
                                    <input Type="hidden" name="ano" value="<?php echo $ano; ?>" />
                                    <input Type="hidden" name="mes"  value="<?php echo $mes; ?>" />
                                    <input Type="hidden" name="prestador" value="<?php echo $nom; ?>" />
                                    <input Type="hidden" name="rg" value="<?php echo $rg; ?>" />
                                    <input Type="hidden" name="id_relatorio" value="<?php echo $id_relatorio; ?>" />
                                </div>
                                <br><br>
                            </div>
                        </form>
                    <?php } ?>

                </div>
                <div id="divisori2">
                    <table  class="table  table-striped table-hover table-bordered table-sm"   >		
                        <?php
                        $sqlcorre1 = "SELECT * FROM corretivas WHERE id_contrato = '$id' AND MONTH(data_conclusao)= '$mes'  AND YEAR (data_conclusao)= '$ano' AND status='Ok' ";
                        $resultado1 = mysqli_query($conection, $sqlcorre1)or die('Não foi possivel conectar ao MySQL');
                        $sqlcorre2 = "SELECT * FROM corretivas WHERE id_contrato = '$id' AND MONTH(data_conclusao)= '$mes'  AND YEAR (data_conclusao)= '$ano' AND previsao_multa=0  AND status!='1'";
                        $resultado2 = mysqli_query($conection, $sqlcorre2)or die('Não foi possivel conectar ao MySQL');
                        $sqlcorre3 = "SELECT * FROM corretivas WHERE id_contrato = '$id' AND MONTH(data_conclusao)= '$mes'  AND YEAR (data_conclusao)= '$ano' AND previsao_multa=1 ";
                        $resultado3 = mysqli_query($conection, $sqlcorre3)or die('Não foi possivel conectar ao MySQL');
                        $sqlcorre5 = "SELECT * FROM corretivas WHERE id_contrato = '$id' AND status='Pendente' AND data_abertura <='$anomes' AND MONTH(data_abertura)BETWEEN '1' AND '12'   ";
                        $resultado5 = mysqli_query($conection, $sqlcorre5)or die('Não foi possivel conectar ao MySQL');

                        $rows = mysqli_num_rows($resultado1);
                        $rows2 = mysqli_num_rows($resultado2);
                        $rows3 = mysqli_num_rows($resultado3);
                        $rows5 = mysqli_num_rows($resultado5);

                        $sqlcorre4 = "SELECT SUM(total) as totais FROM corretivas WHERE id_contrato = '$id' AND MONTH(data_conclusao)= '$mes'  AND YEAR (data_conclusao)= '$ano' AND previsao_multa=1 ";
                        $resultado4 = mysqli_query($conection, $sqlcorre4)or die('Não foi possivel conectar ao MySQL');
                        while ($registro4 = mysqli_fetch_array($resultado4)) {

                            $total = $registro4['totais'];

                            if ($total) {
                                $total = $registro4['totais'];
                            } else {
                                $total = 0;
                            }
                        }
                        ?>
                        <tr><td width='30% '></td><td   > Corretivas </td></td><td  > Preventiva </td><tr>
                        <tr><td width='30% '>Total chamadas:</td><td  ><?php echo $rows; ?></td><td  >  </td><tr>
                        <tr><td>Dentro do Praso:</td><td> <?php echo $rows2; ?> </td><td  >  </td><tr>
                        <tr><td>Fora do Prazo:</td><td><?php echo $rows3; ?>  </td><td  >  </td><tr>  
                        <tr><td>Total Excedido:</td><td><?php echo $total; ?>  </td></td><td  >  </td><tr>
                        <tr><td>Total Pendencias:</td><td><?php echo $rows5; ?></td><td  >  </td><tr>
                    </table>
                </div
                <footer>
                    <h6 class="descri" >Configuração Da Página PDF (Se Necessário)</h6>
                    <form  action="gerar_ans_pdf4.php"  target="_blank" method="post">
                        <div class="row"  >
                            <div class = "col-2">
                                <label class = "cconclusao" for = "cmar_resumo">Margem Resumo </label>
                                <input class = "form-control" Type = "text" name = "mar_resumo" id = "cmar_resumo"  />
                            </div>
                            <div class = "col-2">
                                <label class = "cconclusao" for = "cmar_preventiva">Margem Preventiva </label>
                                <input class = "form-control" Type = "text" name = "mar_preventiva" id = "cmar_preventiva"  />
                            </div>
                            <div class = "col-2">
                                <label class = "cconclusao" for = "cconclusao_corretiva">Margem Conclusão </label>
                                <input class = "form-control" Type = "text" name = "conclusao" id = "cconclusao"  />
                            </div>
                            <div class = "col-6" style="margin-top: 30px;">	                           
                                <input Type="hidden" name="id"   value="<?php echo $id; ?>" />
                                <input Type="hidden" name="rg" value="<?php echo $rg; ?>" />
                                <input Type="hidden" name="nom" value="<?php echo $nom; ?>" />
                                <input Type="hidden" name="ano"  value="<?php echo $ano; ?>" />
                                <input Type="hidden" name="mes" value="<?php echo $mes; ?>" />
                                <input Type="hidden" name="id_relatorio" value="<?php echo $id_relatorio; ?>" />
                                <input Type="hidden" name="id_preventiva" value="<?php echo $id_preventiva; ?>" />
                                <?php
                                //verificar se á pendencias de analise, caso tenha o relatório não poderá ser emitido.

                                $sqlcorre = "SELECT * FROM corretivas WHERE id_contrato = '$id' AND mes_ref ='$mes'  AND ano = '$ano' AND status!='Pendente' AND aplicacao_multa='Verificar'";
                                $resultado = mysqli_query($conection, $sqlcorre)or die('Não foi possivel conectar ao MySQLs');
                                $num = mysqli_num_rows($resultado);
                                
                         
                                  $sql_rel = "SELECT * FROM reg_relatorio WHERE id_relatorio = '$id_relatorio' AND  conclusao_preventiva =''AND conclusao_corretiva=''  AND acompanhado='' AND analizado=''";
                                $resultado1 = mysqli_query($conection, $sql_rel)or die('Não foi possivel conectar ao MySQLs2');
                                $num1 = mysqli_num_rows($resultado1);
                              
                            

                                if ($num > 0 || $num1 > 0 ) {
                                    ?>
                                    <div >  
                                        <h4 class="btn btn-danger" style="color: #cfcfcf; text-shadow:1px 1px 3px black">Analises Pendentes </h4>
                                    </div>

                                    <?php
                                } else {
                                    ?>
                                    <div >
                                        <input type="submit" class=" btn btn-warning" style="color: #cfcfcf; text-shadow:1px 1px 3px black"  name="submit" value="Gerar Relatório"/>
                                    </div>

                                <?php } ?>
                            </div>
                        </div>
                    </form>
                </footer>
            </div>
        </div>
    </body>
</html>
