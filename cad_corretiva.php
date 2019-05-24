<?php
session_start();

if ($_SESSION['status'] != 'LOGADO') {
    header("Location: login.php");
}

$id_corretiva = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if(!empty(filter_input(INPUT_GET, 'menu', FILTER_VALIDATE_INT))){
    $menu = filter_input(INPUT_GET, 'menu', FILTER_VALIDATE_INT);   
   
} else {
    $menu = 1;
}

if($menu == 1){
require_once 'menu_local.php';
}




require_once 'database_gac.php';


require_once ('./inc/Config.inc.php');



if (!empty($id_corretiva)) {
    
if( verifica_previsao_multa($id_corretiva)){
      $_SESSION['msg38'] = "<p style='color:red;'> Este registro não pode ser excluido, Multa aplicada!</p>";
}else {
     $result = "DELETE FROM correivas  WHERE id_corretiva='$id_corretiva'";
     mysqli_query($conection, $result); 
}
   
}



$page_title = 'Corretiva';


$id_resp = filter_input(INPUT_GET, 'id_resp', FILTER_VALIDATE_INT);

if (isset($_GET['id_tipo'])) {
    $id_tipo = (int) $_GET['id_tipo'];
}
if (isset($_POST['id_tipo'])) {
    $id_tipo = (int) $_POST['id_tipo'];
}
require_once 'valida_permissao.php';

function inverteData($data) {
    if (count(explode("/", $data)) > 1) {
        return implode("-", array_reverse(explode("/", $data)));
    } elseif (count(explode("-", $data)) > 1) {
        return implode("/", array_reverse(explode("-", $data)));
    }
}

$query = "SELECT tip.* , loc.id_contrato, loc.sigla, cont.tip_chamado, 
				cont.rg, loc.lugar_regional				
				FROM tipo AS tip
				INNER JOIN local AS loc ON  loc.id_local = tip.id_local
				INNER JOIN  contrato AS cont ON  cont.id_contrato = loc.id_contrato
				WHERE id_tipo = '$id_tipo'";

$resultado = mysqli_query($conection, $query)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado)) {

    $tipos = $registro['tipos'];
    $ct = $registro['id_contrato'];
    $tch = $registro['tip_chamado'];
    $rg = $registro['rg'];
    $lugar_regional = $registro['lugar_regional'];
    $regional = (string) $lugar_regional;
    $sigla = $registro['sigla'];
}

$assunt = "<i class='fas fa-wrench'></i> Manutenção Corretiva<p><h3 style='margin-left:50px; opacity:0.7;'> RG:  $rg / $regional  - Grupo de $tipos </h3><p> ";
?>
<!doctype html>
<html lang="pt">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet"  type="text/css" href="css/Stylecorre.css" media="screen"/>
        <link rel="stylesheet" href="css/bootstrap.css" >
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
        ?>

        <div  class=" container-fluid    "  style="margin-top: 30px">

            <div class="form-group col-md-12">


                <?php
                if
                (isset($_SESSION['msg38'])) {
                    echo $_SESSION['msg38'];
                    unset($_SESSION['msg38']);
                }
                ?>
            </div>
            <div class="form-group col-md-12">	
                <form  id= "fmr1" action="cad_corretiva1.php?action=insert" method="post">
                    <div class="form-row">	
                        <div class="form-group col-md-2">
                            <label for="ctipos">ITEM:</label>
                            <input Type="text"  class="form-control is-invalid" name="tipos" id="cregional"  value="<?php echo $tipos; ?>" />
                        </div>	
                        <div class="form-group col-md-2">
                            <label for="cseve">TIPO DE SEVERIDADE:</label>
                            <select  class="form-control is-invalid"   id="cseve" name="tipo_severidade">
                                <option>Severidade</option>  
                                <?php
                                $q1 = "SELECT severidade, programada, modo FROM severidades WHERE id_contrato = '$ct' AND item = '$tipos' ORDER BY (severidade) ";
                                $r1 = mysqli_query($conection, $q1)or die('Não foi possivel conectar ao MySQL');
                                while ($row = mysqli_fetch_assoc($r1)) {

                                    $modo = $row['modo'];
                                    $severidade = $row['severidade'];


                                    if ($severidade == 5) {
                                        $severidade = 3;
                                    }

                                    switch ($modo) {
                                        case 1:
                                            $modo_atendimento = "24 x 7";
                                            break;
                                        case 2:
                                            $modo_atendimento = "10 x 5"; // das 6h as 18
                                            break;
                                        case 3:
                                            $modo_atendimento = "8 x 5";
                                            break;
                                        case 4:
                                            $modo_atendimento = "9 x 5"; // das 9h as 18
                                            break;
                                        case 5:
                                            $modo_atendimento = "12 x 7";
                                            break;
                                    }
                                    ?>

                                    <option value= "<?php echo $row['severidade']; ?>"><?php echo $severidade . ' - ' . $modo_atendimento . ' ' . $row['programada']; ?></option> 

                                    <?php
                                }
                                ?> 	
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="cregional">REGIONAL:</label>	
                            <input Type="text"  class="form-control is-invalid" name="regional" id="cregional"  value="<?php echo $sigla; ?>" />
                        </div>	
                        <div class="form-group col-md-2">

                            <label for="cn_chamado">Nº CHAMADO *</label>	
                            <input Type="text"  class="form-control is-invalid" name="n_chamado" id="cn_chamado"  value="<?php if (isset($_SESSION['dados20']['n_chamado'])) echo $_SESSION['dados20']['n_chamado']; ?>" />
                        </div>	
                        <div class="form-group col-md-2">
                            <label for="cn_patrimonio">Nº PATRIMONIO:</label>	
                            <select  class="form-control is-invalid"   id="cn_patrimonio" name="n_patrimonio" >
                                <option></option>  
                                <?php
                                $q3 = "SELECT * FROM itens WHERE  id_tipo = '$id_tipo' ";
                                $r3 = mysqli_query($conection, $q3)or die('Não foi possivel conectar ao MySQL');
                                while ($row = mysqli_fetch_assoc($r3)) {
                                    ?>

                                    <option value= "<?php echo $row['patrimonio']; ?>"><?php echo $row['patrimonio']; ?></option> 

                                    <?php
                                }
                                ?> 	
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="cresumo_demanda">RESUMO DA DEMANDA:</label>	
                            <input Type="text"  class="form-control is-invalid" name="resumo_demanda"  value="<?php if (isset($_SESSION['dados20']['resumo_demanda'])) echo $_SESSION['dados20']['resumo_demanda']; ?>" />
                        </div>
                    </div>
                    <div class="form-row">



                        <div class="form-group col-md-2">
                            <label for="cdata_abertura">DATA ABERTURA:</label>
                            <input type="date"  class="form-control is-invalid" name="data_abertura" size="15" maxlength="20"   value="<?php if (isset($_SESSION['dados20']['data_abertura'])) echo $_SESSION['dados20']['data_abertura']; ?>" />
                        </div>

                        <div class="form-group col-md-2">
                            <label for="chora_abertura">HORA ABERTURA:</label>
                            <input type="time"  class="form-control is-invalid" name="hora_abertura" size="15" maxlength="20"   value="<?php if (isset($_SESSION['dados20']['hora_abertura'])) echo $_SESSION['dados20']['hora_abertura']; ?>" />
                        </div>	

                        <div class="form-group col-md-2">
                            <label for="cdata_atendimento">DATA ATENDIMENTO:</label>
                            <p><input Type="date"  class="form-control is-invalid" name="data_atendimento" size="15" maxlength="20"  value="<?php if (isset($_SESSION['dados20']['data_atendimento'])) echo $_SESSION['dados20']['data_atendimento']; ?>" />
                        </div>	
                        <div class="form-group col-md-2">
                            <label for="chora_atendimento">HORA ATENDIMENTO:</label>
                            <input type="time"  class="form-control is-invalid" name="hora_atendimento" size="15" maxlength="20"   value="<?php if (isset($_SESSION['dados20']['hora_atendimento'])) echo $_SESSION['dados20']['hora_atendimento']; ?>" />
                        </div>
                        <div class="form-group col-md-2">
                            <label for="cdata_conclusao">DATA CONCLUSÃO *</label>
                            <input Type="date"  class="form-control is-invalid" name="data_conclusao" size="15" maxlength="20"   value="<?php if (isset($_SESSION['dados20']['data_conclusao'])) echo $_SESSION['dados20']['data_conclusao']; ?>" />
                        </div>
                        <div class="form-group col-md-2">
                            <label for="chora_conclusao">HORA CONCLUSÃO:</label>
                            <p><input type="time" class="form-control is-invalid"  name="hora_conclusao" size="15" maxlength="20"   value="<?php if (isset($_SESSION['dados20']['hora_conclusao'])) echo $_SESSION['dados20']['hora_conclusao']; ?>" />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="c">REQUISITANTE:</label>	
                            <input Type="text"  class="form-control is-invalid" name="requisitante"   value="<?php if (isset($_SESSION['dados20']['requisitante'])) echo $_SESSION['dados20']['requisitante']; ?>" />
                        </div>	                

                        <div class="form-group col-md-2">
                            <label for="ctecnico">TÉCNICO PRESTADOR:</label>
                            <input Type="text" class="form-control is-invalid" name="tecnico" size="15" maxlength="20"  value="<?php if (isset($_SESSION['dados20']['tecnico'])) echo $_SESSION['dados20']['tecnico']; ?>" />
                        </div>

                        <div class="form-group col-md-8">
                            <label for="cobservacao">OBSERVAÇÃO:</label>
                            <input Type="text" class="form-control is-invalid"  name="observacao" size="15" maxlength="20"  value="<?php if (isset($_SESSION['dados20']['observacao'])) echo $_SESSION['dados20']['observacao']; ?>" />
                        </div>
                    </div>
                    <div class="form-row">	
                        <div class="form-group col-md-2">
                            <input name="id_tipo" type="hidden" value=<?php echo $id_tipo; ?>>
                            <input name="ct" type="hidden" value=<?php echo $ct; ?>>
                            <input name="tch" type="hidden" value=<?php echo $tch; ?>>
                            <input name="rg" type="hidden" value=<?php echo $rg; ?>> 
                            <input name="regional" type="hidden" value=<?php echo $sigla; ?>>
                            <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?> 
                                <input id= "bt1" type="submit"   class="btn btn-danger" name="submit" value="Enviar"/>
                                <input type="hidden" name="submitted" value="TRUE" />
                            <?php } ?>
                        </div>
                    </div>   

                </form>
                <?php
                if (!empty($_SESSION['dados20'])) {
                    unset($_SESSION['dados20']);
                }
                ?>
            </div>
            <div class="form-group col-md-12">
                <table  class="table table-hover table-striped table-sm table-bordered bg-light"   >
                    <thead class="thead-dark ">
                        <tr>

                            <th  scope="col">Nº Chamado</th>
                            <th  scope="col">Mes</th>
                            <th  scope="col">Ano</th>
                            <th scope="col">Severidade</th>
                            <th scope="col">Data da Abertura</th>
                            <th scope="col">Hora da Abertura</th>
                            <th scope="col">Data do Apoio</th>
                            <th scope="col">Hora do Apoio</th>
                            <th scope="col">Data de Conclusão</th>
                            <th scope="col">Hora da Conclusão</th>
                            <th scope="col">Prazo do Apoio</th>
                            <th scope="col">Utilizado Atendimento</th>
                            <th scope="col">Prazo de Conclusão</th> 
                            <th scope="col">Utilizado Conclusão</th>
                            <th   style="background-color: #B22222;">Total Horas Excedentes </th>
                            <th style="background-color: #B22222;">Necessidade On-site?</th>
                            <th  style="background-color: #B22222;">Apoio On-site?</th>
                            <th style="background-color: #B22222;">Previsão de Multa?</th>
                            <th  style="background-color: #B22222;">Aplicar Multa?</th>
                            <th  style="background-color: #B22222;">Status</th>
                            <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?>
                                <th scope="col">Editar</th>
                                <th scope="col">Excluir</th>
                            <?php } ?>


                        </tr> 
                    </thead>
                    <?php
                    $multa = array();

                    $sqlcorre = "SELECT * FROM corretivas WHERE id_tipo = '$id_tipo'ORDER BY (status)DESC,(data_conclusao) DESC";
                    $resultado = mysqli_query($conection, $sqlcorre)or die('Não foi possivel conectar ao MySQL');
                    while ($registro = mysqli_fetch_array($resultado)) {

                        $multa[] = $registro['previsao_multa'];
                        $patrimonio = $registro['n_patrimonio'];
                    



                        $status = $registro['status'];
                        $previsao_multa = $registro['previsao_multa'];


                        $data1 = $registro['dabertura_real'];
                        $data1 = inverteData($data1);

                        $data2 = $registro['datendimento_real'];
                        $data2 = inverteData($data2);


                        $data3 = $registro['dconclusao_real'];
                        $data3 = inverteData($data3);

                        $necessidade_on_site = $registro['necessidade_on_site'];
                        $atendimento_onsite = $registro['atendimento_onsite'];
                        $id_corretiva = $registro['id_corretiva'];

                        $severidade = $registro['tipo_severidade'];



                        if ($severidade == 5) {
                            $severidade = 3;
                        }




                        if ($status == '1') {
                            $status = 'Ok';
                        }

                        if ($registro['n_chamado'] == 'Nao Houve') {
                            $data3 = '00/00/0000';
                        }

                        if ($previsao_multa == '1') {
                            $previsao_multa = "<font style='color:red;'><i class='fas fa-check-circle'></i></font>";
                        } else {
                            $previsao_multa = "<font style='color:green ;'><i class='fas fa-times-circle'></i></font>";
                        }
                        ?>
                        <tr>

                            <td class = "td2" ><?php echo $registro['n_chamado']; ?></td>
                            <td class = "td2" ><?php echo $registro['mes_ref']; ?></td>
                            <td class = "td2" ><?php echo $registro['ano']; ?></td>
                            <td class = "td2" ><?php echo $severidade; ?></td>
                            <td class = "td2" ><?php echo $data1; ?></td>
                            <td class = "td2" ><?php echo $registro['habertura_real']; ?></td>
                            <td class = "td2" ><?php echo $data2; ?></td>
                            <td class = "td2" ><?php echo $registro['hatendimento_real']; ?></td>
                            <td class = "td2" ><?php echo $data3; ?></td>
                            <td class = "td2" ><?php echo $registro['hconclusao_real']; ?></td>
                            <td class = "td2" ><?php echo $registro['prazo_atendimento']; ?></td>
                            <td class = "td2" ><?php echo $registro['subtotal_atendimento']; ?></td>
                            <td class = "td2" ><?php echo $registro['prazo_conclusao']; ?></td>       
                            <td class = "td2" ><?php echo $registro['subtotal_conclusao']; ?></td>
                            <td class = "td2" ><?php echo $registro['total']; ?></td>
                            <td class = "td2" ><?php echo $necessidade_on_site; ?></td>
                            <td class = "td2" ><a data-toggle="modal" data-target="#exampleModal4<?php echo $id_corretiva ?>" href="#"><?php echo $atendimento_onsite; ?></td>
                            <td class = "td2" style=" text-align: center;"><?php echo $previsao_multa; ?></td>
                            <td class = "td2" ><a  data-toggle="modal"  <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?> data-target="#exampleModal3<?php echo $id_corretiva ?>"  <?php } ?> href="#" ><?php echo $registro['aplicacao_multa']; ?></td>
                            <td class = "td2" ><?php echo $status; ?></td>
                            <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?>
                                <td>
                                    <a data-toggle="modal" data-target="#exampleModal2<?php echo $id_corretiva ?>" href="#">
                                        <i class="far fa-edit"></i>
                                    </a>
                                </td>
                                <td>
                                    <a  href="#"  data-toggle="modal" data-target="#exampleModal4<?php echo $registro['id_corretiva'] ?>">

                                        <i class="fas fa-eraser"></i>
                                    </a>
                                </td>
                            <?php } ?>
                        </tr>



                        <!-- Modal -->
                        <div class="modal fade"  id="exampleModal2<?php echo $id_corretiva ?>"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"id="exampleModalLabel" text="center" ><font color='#0080FF'><?php echo $id_corretiva ?></font></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <form  class=" updates needs-validation "   action="cad_corretiva1.php?action=update"  method="post" novalidate>         
                                            <div  class="container" >	
                                                <div class="form-row">	
                                                    <div class="form-group col-md-6">
                                                        <label for="cregional">REGIONAL:</label>	
                                                        <input Type="text"  class="form-control is-invalid" name="regional" id="cregional"  value="<?php echo $sigla; ?>" />
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="ctipos">ITEM:</label>
                                                        <input Type="text"  class="form-control is-invalid" name="tipos" id="cregional"  value="<?php echo $tipos; ?>" />
                                                    </div>	
                                                    <div class="form-group col-md-6">
                                                        <label class="mods" for="cstatus" >STATUS</label>
                                                        <input class="form-control" Type="text" name="status" id="ctipo_severidade"  value="<?php echo $registro['status']; ?>" >
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="cseve">SEVERIDADE:</label>
                                                        <select  class="form-control is-invalid"   id="cseve" name="tipo_severidade">
                                                            <option><?php echo $registro['tipo_severidade']; ?></option>  
                                                            <?php
                                                            $q1 = "SELECT severidade, programada, modo FROM severidades WHERE id_contrato = '$ct' AND item = '$tipos' ORDER BY (severidade) ";
                                                            $r1 = mysqli_query($conection, $q1)or die('Não foi possivel conectar ao MySQL');
                                                            while ($row = mysqli_fetch_assoc($r1)) {

                                                                $modo = $row['modo'];
                                                                $severidade = $row['severidade'];


                                                                if ($severidade == 5) {
                                                                    $severidade = 3;
                                                                }

                                                                switch ($modo) {
                                                                    case 1:
                                                                        $modo_atendimento = "24 x 7";
                                                                        break;
                                                                    case 2:
                                                                        $modo_atendimento = "10 x 5"; // das 6h as 18
                                                                        break;
                                                                    case 3:
                                                                        $modo_atendimento = "8 x 5";
                                                                        break;
                                                                    case 4:
                                                                        $modo_atendimento = "9 x 5"; // das 9h as 18
                                                                        break;
                                                                    case 5:
                                                                        $modo_atendimento = "12 x 7";
                                                                        break;
                                                                }
                                                                ?>
                                                                <option value= "<?php echo $row['severidade']; ?>"><?php echo $severidade . ' - ' . $modo_atendimento . ' ' . $row['programada']; ?></option> 
                                                                <?php
                                                            }
                                                            ?> 	
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="form-row">                                                   
                                                    <div class="form-group col-md-6">
                                                        <label class="mods"  for="cn_chamado" >Nº CHAMADO</label>
                                                        <input class="form-control" Type="text" name="n_chamado" id="cn_chamado"  value="<?php echo $registro['n_chamado']; ?>" >
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="mods" for="cn_patrimonio" >Nº PATRIMONIO:</label>
                                                        <input class="form-control" Type="text" name="n_patrimonio" id="cn_patrimonio"  value="<?php echo $registro['n_patrimonio']; ?>" >
                                                    </div>
                                                </div>	
                                                <div class="form-row"> 
                                                    <div class="form-group col-md-12">
                                                        <label class="mods" for="cresumo_demanda" >RESUMO DA DEMANDA:</label>
                                                        <input class="form-control" Type="text" name="resumo_demanda" id="cn_patrimonio"  value="<?php echo $registro['resumo_demanda']; ?>" >
                                                    </div>
                                                </div>
                                                <div class="form-row"> 
                                                    <div class="form-group col-md-12">
                                                        <label class="mods" for="cvalor_parcela" >REQUISITANTE:</label>
                                                        <input class="form-control" Type="text" name="requisitante" id="cvalor_parcela"  value="<?php echo $registro['requisitante']; ?>" >
                                                    </div>
                                                </div>	
                                                <div class="form-row">		
                                                    <div class="form-group col-md-6">
                                                        <label class="mods" for="cdata_abertura" >DATA ABERTURA:</label>
                                                        <input class="form-control" Type="date" name="data_abertura" id="cdata_abertura"  value="<?php echo $registro['dabertura_real']; ?>" >
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="chora_abertura" >HORA ABERTURA:</label>
                                                        <input class="form-control" Type="time" name="hora_abertura" id="chora_abertura"  value="<?php echo $registro['habertura_real']; ?>" >
                                                    </div>
                                                </div>	
                                                <div class="form-row">		
                                                    <div class="form-group col-md-6">
                                                        <label class="mods" for="cdata_atendimento" >DATA ATENDIMENTO:</label>
                                                        <input class="form-control" Type="date" name="data_atendimento" id="cdata_atendimento"  value="<?php echo $registro['datendimento_real'];
                                                        ;
                                                            ?>" >
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="mods" for="chora_atendimento" >HORA ATENDIMENTO:</label>
                                                        <input class="form-control" Type="time" name="hora_atendimento" id="chora_atendimento"  value="<?php echo $registro['hatendimento_real']; ?>" >
                                                    </div>
                                                </div>	
                                                <div class="form-row">		
                                                    <div class="form-group col-md-6">
                                                        <label class="mods" for="cdata_conclusao" >DATA CONCLUSÃO:</label>
                                                        <input class="form-control" Type="date" name="data_conclusao" id="cdata_conclusao"  value="<?php echo $registro['dconclusao_real']; ?>" >
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="mods" for="chora_conclusao" >HORA CONCLUSÃO:</label>
                                                        <input class="form-control" Type="time" name="hora_conclusao" id="chora_conclusao"  value="<?php echo $registro['hconclusao_real']; ?>" >
                                                    </div>
                                                </div>	
                                                <div class="form-row">		
                                                    <div class="form-group col-md-12">
                                                        <label class="mods" for="ctecnico" >TÉCNICO:</label>
                                                        <input class="form-control" Type="text" name="tecnico" id="cdata_conclusao"  value="<?php echo $registro['tecnico']; ?>" >
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label class="mods" for="cobservacao" >OBSERVAÇÃO:</label>
                                                        <input class="form-control" Type="text" name="observacao" id="chora_conclusao"  value="<?php echo $registro['observacao']; ?>" >
                                                    </div>

                                                </div>	                                              	
                                                <div class="form-row">   
                                                    <div class="form-group col-md-9">                                             

                                                        <label class="mods1" for="ccatendimento_onsite" >Atualizar Previsão de Multa?</label>                                                        
                                                        <select class="custom-select"name="atu_previsao_multa">

                                                            <option value="1">Não</option>
                                                            <option value="2">Sim</option>

                                                        </select>
                                                    </div>                                                     

                                                    <div class="form-group col-md-3" style=" margin-top: 40px;">    
                                                        <input class="form-control"  type="hidden" name="id_corretiva" id="cid_pag"  value="<?php echo $id_corretiva; ?>" >
                                                        <input class="form-control"  type="hidden" name="id_tipo" id="cid_tipo"  value="<?php echo $id_tipo; ?>" >                                           
                                                        <input name="ct" type="hidden" value=<?php echo $ct; ?>>
                                                        <input name="tch" type="hidden" value=<?php echo $tch; ?>>
                                                        <input name="rg" type="hidden" value=<?php echo $rg; ?>>

                                                        <input name="previsao_multa" type="hidden" value=<?php echo $registro['previsao_multa']; ?>>
                                                        <input name="regional" type="hidden" value=<?php echo $sigla; ?>>
                                                        <input  class="btn btn-outline-primary" type="submit" name="Prosseguir" value="ENVIAR"  class="btn btn-primary">
                                                        <input type="hidden" name="submitted" value="TRUE" />
                                                    </div>
                                                </div>


                                        </form>
                                    </div>	 
                                </div>
                            </div>
                        </div> 
                        </div> 

                        <div class="modal fade"  id="exampleModal3<?php echo $id_corretiva ?>"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"id="exampleModalLabel" text="center" ><font color='#0080FF'>Análise da Ocorrência</font></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form  class=" updates needs-validation "   action="proc_atua_corretiva1.php"  method="post" novalidate>         
                                            <div  class="container" >	
                                                <div class="form-row"> 
    <?php if ($necessidade_on_site == 'Sim') { ?>
                                                        <div class="form-group col-md-6">                                             

                                                            <label class="mods1" for="ccatendimento_onsite" >ATENDIMENTO ON-SITE ?</label>                                                        
                                                            <select class="custom-select"name="atendimento_onsite" id="ccatendimento_onsite"  value="<?php echo $registro['atendimento_onsite']; ?>" >
                                                                <option selected><?php echo $registro['atendimento_onsite']; ?></option>
                                                                <option value="Sim">Sim</option>
                                                                <option value="Nao">Não</option>                                                           
                                                            </select>
                                                        </div>
                                                    
                                                    
    <?php } ?>
                                                    <div class="form-group col-md-6">
                                                        <label class="mods1" for="caplicacao_multa" >APLICAR MULTA ?</label>
                                                        <select class="custom-select"name="aplicacao_multa" id="caplicacao_multa"  value="<?php echo $registro['aplicacao_multa']; ?>" >
                                                            <option selected><?php echo $registro['aplicacao_multa']; ?></option>
                                                            <option value="Sim">Sim</option>
                                                            <option value="Nao">Não</option>                                                           
                                                        </select>
                                                    </div>
                                                </div>	
                                                <div class="form-row">       		
                                                </div>
                                                <input class="form-control"  type="hidden" name="id_corretiva" id="cid_pag"  value="<?php echo $id_corretiva; ?>" >
                                                <input class="form-control"  type="hidden" name="id_tipo" id="cid_tipo"  value="<?php echo $id_tipo; ?>" >                                           
                                                <input name="patrimonio" type="hidden" value=<?php echo $patrimonio; ?>>
                                                <input  class="btn btn-outline-primary" type="submit" name="Prosseguir" value="ENVIAR"  class="btn btn-primary">
                                                <input type="hidden" name="submitted" value="TRUE" />
                                            </div>
                                        </form>
                                    </div>	 
                                </div>
                            </div>
                        </div>  
                        <div class="modal fade"  id="exampleModal4<?php
                        if ($atendimento_onsite == 'Sim') {
                            echo $id_corretiva;
                        }
                        ?>"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"id="exampleModalLabel" text="center" ><font color='#0080FF'>Detalhe do Atendimento On-Site</font></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form  class=" updates needs-validation "   action="proc_atua_corretiva2.php"  method="post" novalidate>         
                                            <div  class="container" >
                                                <div class="form-row">	
                                                    <div class="form-group col-md-6">
                                                        <label for="cdata_atend_onsite">D. ATENDIMENTO ON-SITE:</label>
                                                        <input type="date"  class="form-control is-invalid" name="data_atend_onsite" size="15" maxlength="20" value="<?php echo $registro['data_atend_onsite']; ?>" >
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="chora_atendimento_onsite">H.ATENDIMENTO ON-SITE:</label>
                                                        <input type="time"  class="form-control is-invalid" name="hora_atendimento_onsite" size="15" maxlength="20"  value="<?php echo $registro['hora_atendimento_onsite']; ?>" >
                                                    </div>
                                                </div>	
                                                <div class="form-row">       		
                                                </div>
                                                <input class="form-control"  type="hidden" name="id_corretiva" id="cid_pag"  value="<?php echo $id_corretiva; ?>" >
                                                <input class="form-control"  type="hidden" name="id_tipo" id="cid_tipo"  value="<?php echo $id_tipo; ?>" >  
                                                <input class="form-control"  type="hidden" name="tipos" id="ctipos"  value="<?php echo $tipos; ?>" > 

                                                <input  class="btn btn-outline-primary" type="submit" name="Prosseguir" value="ENVIAR"  class="btn btn-primary">
                                                <input type="hidden" name="submitted" value="TRUE" />
                                            </div>
                                        </form>
                                    </div>	 
                                </div>
                            </div>
                        </div>  
                        <!-- Modal Exclusao -->
                        <div class="modal fade" id="exampleModal4<?php echo $registro['id_corretiva'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Deseja Realmente Deletar  </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p><?php echo 'O Acionamento' . ' ' . $registro['n_chamado'] ?></p>
                                        <ul class="nav justify-content-center">     
                                            <li class="nav-item">
                                                <a class="btn btn-danger"  href="cad_corretiva1.php?action=deleta&id_tipo=<?php echo $id_tipo ?>&id_corretiva=<?php echo $registro['id_corretiva'] ?>">Sim</a>
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
        <script src="js/jquery-3.2.1.slim.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script defer src="js/fontawesome-all.min.js"></script>
    </body>

