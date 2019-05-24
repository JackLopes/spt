<?php
session_start();

if ($_SESSION['status'] != 'LOGADO') {
    header("Location: login.php");
}

//Controle de menu em caso de requisição indireta

if(!empty(filter_input(INPUT_GET, 'menu', FILTER_VALIDATE_INT))){
    $menu = filter_input(INPUT_GET, 'menu', FILTER_VALIDATE_INT);   
   
} else {
    $menu = 1;
}

if($menu == 1){
require_once 'menu_local.php';
}


require_once 'Funcoes/func_data.php';
require_once 'valida_permissao.php';
require_once './Funcoes/mascara_php.php';

$mes = array('', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');

$page_title = 'Corretiva';



if (isset($_GET['id_tipo'])) {
    $id_tipo = (int) $_GET['id_tipo'];
}
if (isset($_POST['id_tipo'])) {
    $id_tipo = (int) $_POST['id_tipo'];
}

require_once 'database_gac.php';


$query = "SELECT tip.* , loc.id_contrato, loc.sigla, cont.tip_chamado, 
				cont.rg, cont.valor_Contratado,cont.id_prestador, loc.lugar_regional				
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
    $valor_Contratado = $registro['valor_Contratado'];
    $sigla = $registro['sigla'];
    $id_prestador = $registro['id_prestador'];
}
$sql_quali = "SELECT SUM(valor_acrescimo) AS valor FROM aditivos WHERE id_contrato = $ct";
$resul_quali = mysqli_query($conection, $sql_quali)or die('Não foi possivel conectar ao MySQL');
while ($registro10 = mysqli_fetch_array($resul_quali)) {
    $valor_acrescimo = $registro10['valor'];
}

$sql_supressao = "SELECT SUM(valor_supressao) AS valor_supressao FROM aditivos WHERE id_contrato = $ct";
$resul_supressao = mysqli_query($conection, $sql_supressao)or die('Não foi possivel conectar ao MySQL');
while ($registro11 = mysqli_fetch_array($resul_supressao)) {
    $valor_supressao = $registro11['valor_supressao'];
}


$valor_atual = $valor_Contratado + $valor_acrescimo - $valor_supressao;

if (!empty($valor_acrescimo)) {
    $val_contr = $valor_atual;
}





$regs = array();
$total = array();
$i5 = 0;
$sql = "  SELECT SUM(valor_parcela) AS par_valor, regional FROM pagamentos WHERE   id_contrato= '$ct' AND status = 'ok' GROUP BY regional";
$resultado = mysqli_query($conection, $sql);
While ($registro = mysqli_fetch_array($resultado)) {
    $regs[$i5] = $registro['regional'];
    $par_total[$i5] = ($registro['par_valor']);

    $i5 = $i5 + 1;

    $sub_par_total = array_sum($par_total);
}

if (empty($par_total)) {

    $sub_par_total = 0;
} else {
    $sub_par_total = array_sum($par_total);
}

$rest = $val_contr - $sub_par_total;

$sq2 = "  SELECT SUM(valor_parcela) AS par_valor, regional FROM pagamentos WHERE   id_contrato= '$ct' ";
$resultado2 = mysqli_query($conection, $sq2);
While ($registro2 = mysqli_fetch_array($resultado2)) {

    $par_total2 = ($registro2['par_valor']);
}

if (!empty($par_total2)) {
    $rest2 = $val_contr - $par_total2;
} else {
    $rest2 = 0;
}

$sq3 = "  SELECT SUM(valor_parcela) AS par_valor, regional FROM pagamentos WHERE   id_contrato= '$ct' AND regional = '$sigla'";
$resultado3 = mysqli_query($conection, $sq3);
While ($registro3 = mysqli_fetch_array($resultado3)) {

    $valor = $registro3['par_valor'];
}

$assunt = "<i class='fab fa-cc-visa'></i> Liberacao de Pagamento<p><h3 style='margin-left:50px; opacity:0.7;'> RG:  $rg / $regional  - Grupo de $tipos </h3><p> ";


?>

<!doctype html>
<html lang="pt">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet"  type="text/css" href="css/stylepag.css" media="screen"/>
        <link rel="stylesheet" href="css/bootstrap.css" >
     

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load("current", {packages: ["corechart"]});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Regional', 'Total Pago'],

<?php
$k2 = $i5;
for ($i5 = 0; $i5 < $k2; $i5++) {
    ?>
                        ['<?php echo $regs[$i5] ?>',<?php echo $par_total[$i5] ?>],

    <?php
}
?>
                    ['Pendência Atual Contratual', <?php echo $rest ?>]

                ]);

                var options = {
                    title: 'Liberação de Pagamentos Efetuadas por Regionais',
                    is3D: true,
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                chart.draw(data, options);
            }
        </script>

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
    <body>
      
        <?php require_once 'image_header6.php';
          var_dump($id_tipo);
        ?>

        <div  class=" container-fluid    "  style="margin-top: 30px">

            <div class="form-group col-md-12">
               
                <div class="form-row">	
                    <div class="form-group col-md-7">

                        <form id= "fmr1" action="proce_pag.php" method="post">
                            <div class="form-row">	

                                <div class="form-group col-md-3">
                                    <label for="cparcela">NÚMERO PARCELAS:</label>                                
                                    <input Type="number" class="form-control "   name="parcela" id="cparcela"   value="<?php if (isset($_POST['parcela'])) echo $_POST['parcela']; ?>" />
                                </div>  

                                <div class="form-group col-md-3">
                                    <label for="campovalor" >VALOR TOTAL:</label>			 
                                    <input class="form-control "  Type="text"   name="valor_total" id="campovalor" value="<?php if (isset($_POST['valor_total'])) echo $_POST['valor_total']; ?>" >					</div>
                                <div class="form-group col-md-3">	
                                    <label for="cdata_inicio_per">DATA INICIAL:</label>
                                    <input Type="date" class="form-control " id="cdata_inicio_per" name="data_inicio_per"  value="<?php if (isset($_POST['data_inicio_per'])) echo $_POST['data_inicio_per']; ?>" />
                                </div>	
                            </div>            
                            <div class="form-row">	
                                <div class="form-group col-md-2">	
                                    <input name="id_tipo"  type="hidden" value=<?php echo $id_tipo; ?>>
                                   
                                    <input name="resto"  type="hidden" value=<?php echo $rest2; ?>>
                                    <?php if ($matricula === $mat AND $permissa < 4 or $permissa == 2) { ?> 
                                        <input id= "bt1" type="submit" class="btn btn-warning"  name="submit" value="Enviar"/>
                                        <input type="hidden" name="submitted" value="TRUE" />
                                    <?php } ?>
                                </div>
                            </div>            
                        </form>
                    </div>   
                    <div class="form-group col-md-5">
                        <div id="piechart_3d" style="width:750px; height:300px;"></div>
                    </div>     
                </div>     
                <div class=" message ">	
                    <?php
                    if (isset($_SESSION['msg28'])) {
                        echo $_SESSION['msg28'];
                        unset($_SESSION['msg28']);
                    }
                    ?>
                </div> 
                <div class="informt">  
                    <?php echo "<strong> Total Lançamentos: " . "R$ " . number_format($valor, 2, ',', '.') . "</strong>"; ?>   
                </div> 
                <table  class=" view table table-hover table-striped table-sm table-bordered bg-light"   >
                    <thead class="thead-dark ">
                    <th scope="col">Referência</th> 
                    <th scope="col">Nota Fiscal</th>
                    <th scope="col">CNPJ Faturamento</th>
                    <th scope="col">Valor da Parcela</th>
                    <th scope="col">Início do Período</th>
                    <th scope="col">Fim do Período</th>
                    <th scope="col">Data da Assinatura</th>
                    <th scope="col">SISCOR</th>
                    <th style="background-color: #FF4500;">Data do Vencimento</th>
                    <th style="background-color: #FF4500;">Autuado ?</th>
                    <th style="background-color: #FF4500;">Medido ?</th>
                    <th scope="col">Observação</th>
                    <th scope="col">Status</th>
                    <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?> 
                        <th scope="col">Editar</th>
                        <th scope="col">Deletar</th>
                    <?php } ?>
                    </thead>
                    </tr> 
                    <?php
                    $sqlcorre = "SELECT * FROM pagamentos WHERE id_tipo= '$id_tipo' ORDER BY (data_fim_per) DESC";
                    $resultado = mysqli_query($conection, $sqlcorre)or die('Não foi possivel conectar ao MySQL');
                    while ($registro = mysqli_fetch_array($resultado)) {

                        $id_pag = $registro['id_pag'];
                        $n_parcela = $registro['n_parcela'];
                        $id_tipo = $registro['id_tipo'];

                        $ex = explode("-", $registro['data_fim_per']);
                        $ano = $ex[0];
                        $mes_ref = $ex[1];

                        $ref = $mes_ref . '/' . $ano;
                        ?>
                        <tr>
                            <td class = "td2" ><?php echo $id_pag . ' - ' . $ref; ?></td>
                            <td class = "td2" ><?php echo $registro['nota_fiscal']; ?></td>
                            <td class = "td2" ><?php echo masc_cnpj_php( $registro['cnpj_faturamento']); ?></td>
                            <td class = "center" > <a data-toggle="modal"  <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?>  data-target="#exampleModal2<?php echo $id_pag ?>" <?php } ?> href="#"><?php echo "R$ " . $registro['valor_parcela']; ?></a></td>
                            <td class = "td2" ><?php echo inverteData($registro['data_inicio_per']); ?></td>
                            <td class = "td2" ><?php echo inverteData($registro['data_fim_per']); ?></td>
                            <td class = "td2" ><?php echo inverteData($registro['d_assinatura_dig']); ?></td>
                            <td class = "td2" ><?php echo $registro['siscor']; ?></td>        
                            <td class = "td2" ><?php echo inverteData($registro['d_vencimento_pag']); ?></td>       
                            <td class = "td2" ><?php echo $registro['aut_nota']; ?></td>
                            <td class = "td2" ><?php echo $registro['medido']; ?></td>
                            <td class = "td2" ><?php echo $registro['obser']; ?></td>
                            <td class = "td2" ><?php echo $registro['status']; ?></td>
                            <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?> 
                                <td>
                                    <a data-toggle="modal" data-target="#exampleModal<?php echo $id_pag ?>" href="#">
                                        <i class="far fa-edit"></i> 
                                    </a>
                                </td>
                                <td>
                                    <a  href="#"  data-toggle="modal" data-target="#exampleModal5<?php echo $registro['id_pag'] ?>">

                                        <i class="fas fa-eraser"></i> 
                                    </a>
                                </td>
                            <?php } ?>
                        </tr>

                        <!-- Modal -->

                        <div class="modal fade"  id="exampleModal<?php echo $id_pag ?>"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"id="exampleModalLabel" text="center" ><font color='#0080FF'><?php echo $id_pag ?></font></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <form  class="needs-validation "   action="proc_cad_pagamento.php"  method="post" novalidate>         
                                            <div  class="container" >		
                                                <div class="form-row">		
                                                    <div class="form-group col-md-6">
                                                        <label for="cnota_fiscal" >NOTA FISCAL:</label>
                                                        <input class="form-control" Type="text" name="nota_fiscal" id="cnota_fiscal"  value="<?php echo $registro['nota_fiscal']; ?>" >
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="cvalor_parcela" >CNPJ FATURAMENTO:</label>
                                                        <select  class="form-control" name="cnpj_faturamento" >
                                                            <option><?php echo masc_cnpj_php($registro['cnpj_faturamento']); ?></option>
                                                            <?php
                                                            
                                                            $q1 = "SELECT cnpj FROM filial WHERE id_prestador = '$id_prestador'";
                                                            $r1 = mysqli_query($conection, $q1);
                                                            while ($row = mysqli_fetch_assoc($r1)) {
                                                                
                                                               $cnpj=  masc_cnpj_php($row['cnpj']);                                                            
                                                                
                                                                ?>
                                                                <option value= "<?php echo $cnpj; ?>"><?php echo $cnpj ; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>	
                                                </div>		
                                                <div class="form-row">		

                                                    <div class="form-group col-md-12">
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
                                                    <div class="form-group col-md-12">
                                                        <label for="cd_assinatura_dig">DATA ASSINATURA:</label>
                                                        <input class="form-control"  Type="date"   name="d_assinatura_dig" id="cd_assinatura_dig" value="<?php echo $registro['d_assinatura_dig']; ?>" >
                                                    </div>
                                                </div>
                                                <div class="form-row">		
                                                    <div class="form-group col-md-6">
                                                        <label for="csiscor" >SISCOR:</label>
                                                        <input class="form-control" Type="text" name="siscor" id="csiscor" value="<?php echo $registro['siscor']; ?>" >
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="cd_vencimento_pag" >DATA VENCIMENTO:</label>
                                                        <input class="form-control" Type="date" name="d_vencimento_pag" id="cd_vencimento_pag"  value="<?php echo $registro['d_vencimento_pag']; ?>" >
                                                    </div>	
                                                </div>			
                                                <div class="form-row">					
                                                    <div class="form-group col-md-6">
                                                        <label for="caut_nota" >AUTUADO:</label>	        
                                                        <select class="form-control"  Type="text" name="aut_nota" id="ctip_chamado"  maxlength="40" value="<?php echo $registro['aut_nota']; ?>" >		
                                                            <option selected><?php echo $registro['aut_nota']; ?></option>
                                                            <option value= "Sim">Sim</option>	
                                                            <option value= "Nao">Não</option>		
                                                        </select>
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
                                                    <div class="form-group col-md-12">
                                                        <label for="cobser">OBSERVAÇÃO:</label>
                                                        <textarea class="form-control"  rows="3" class="form-control" Type="text" name="obser" id="cobs" value="<?php echo $registro['obser']; ?>" ></textarea>
                                                    </div>
                                                </div>
                                                <input class="form-control"  type="hidden" name="id_pag" id="cid_pag"  value="<?php echo $id_pag; ?>" >
                                                <input class="form-control"  type="hidden" name="id_tipo" id="cid_tipo"  value="<?php echo $id_tipo; ?>" >
                                                <input class="form-control"  type="hidden" name="id_contrato" id="cid_tipo"  value="<?php echo $ct; ?>" >
                                                 <input name="regional"  type="hidden" value=<?php echo $sigla; ?>>
                                                <input  class="btn btn-outline-primary" type="submit" name="Prosseguir" value="ENVIAR"  class="btn btn-primary">
                                                <input type="hidden" name="submitted" value="TRUE" />
                                            </div>
                                        </form>
                                    </div>	 
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->

                        <div class="modal fade"  id="exampleModal2<?php echo $id_pag ?>"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"id="exampleModalLabel" text="center" ><font color='#0080FF'><?php echo $id_pag ?></font></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <form  class="needs-validation "   action="proc_cad_pagamento2.php"  method="post" novalidate>         
                                            <div  class="container" >		
                                                <div class="form-row">		

                                                    <div class="form-group col-md-12">
                                                        <label for="cvalor_parcela" >VALOR PARCELA:</label>
                                                        <input class="form-control" Type="number" name="valor_parcela" id="cvalor_parcela"  value="<?php echo $registro['valor_parcela']; ?>" >
                                                    </div>	
                                                  
                                                </div>		
                                                <div class="form-row">		

                                                     <div class="form-group col-md-6">
                                                        <label for="cdata_inicio_per" >INICIO DO PERIODO:</label>
                                                        <input class="form-control" Type="date" name="data_inicio_per" id="cdata_inicio_per"  value="<?php echo $registro['data_inicio_per']; ?>" >
                                                    </div>	
                                                    <div class="form-group col-md-6">
                                                        <label for="cdata_fim_per" >FIM DO PERIODO:</label>
                                                        <input class="form-control" Type="date" name="data_fim_per" id="cdata_fim_per"  value="<?php echo $registro['data_fim_per']; ?>" >
                                                    </div>
                                                </div>		
                                                <div class="form-row">       		
                                                </div>
                                                <input class="form-control"  type="hidden" name="id_pag" id="cid_pag"  value="<?php echo $id_pag; ?>" >
                                                <input class="form-control"  type="hidden" name="id_tipo" id="cid_tipo"  value="<?php echo $id_tipo; ?>" >
                                                <input  class="btn btn-outline-primary" type="submit" name="Prosseguir" value="ENVIAR"  class="btn btn-primary">
                                                <input type="hidden" name="submitted" value="TRUE" />
                                            </div>
                                        </form>
                                    </div>	 
                                </div>
                            </div>
                        </div>
                        <!-- Modal Exclusao -->
                        <div class="modal fade" id="exampleModal5<?php echo $registro['id_pag']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Deseja Realmente Deletar  </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p><?php echo 'A Nota Fiscal ' . $registro['nota_fiscal'] . ' ' . 'com valor de R$ ' . $registro['valor_parcela']; ?></p>
                                        <ul class="nav justify-content-center">     
                                            <li class="nav-item">
                                                <a class="btn btn-danger"  href="delet_pagamento.php?id_pag=<?php echo $registro['id_pag'] ?>&id_tipo=<?php echo $id_tipo ?>">Sim</a>
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
            </div>
        </div>
    </body>
      
    <script defer src="js/fontawesome-all.min.js"></script>
    <script src="js/jquery-3.2.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>


</html>







