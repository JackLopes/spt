<?php
$page_title = 'GERIR CONTRATOS';

require_once 'menu.php';
require_once 'Funcoes/func_data.php';


$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$id_aditivo = (int) filter_input(INPUT_GET, 'id_aditivo', FILTER_SANITIZE_NUMBER_INT);
$numero_aditivo = (int) filter_input(INPUT_GET, 'numero_aditivo', FILTER_SANITIZE_NUMBER_INT);
$rg = filter_input(INPUT_GET, 'rg', FILTER_SANITIZE_STRING);
require_once 'valida_permissao.php';
$assunt = '<i class="fas fa-server"></i> Cadastro de Aditivos - RG ' . $rg;
?>
<!doctype html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
        <link rel="stylesheet"  type="text/css" href="css/styleaditivo.css" media="screen"/>
        <link rel="stylesheet" href="css/bootstrap.css" >
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <script defer src="js/fontawesome-all.min.js"></script>
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


        </script>
        <script>
            function showMe(it, elem) {
                var elems = document.getElementsByClassName("cb");
                var currentState = elem.checked;
                var elemsLength = elems.length;

                for (i = 0; i < elemsLength; i++) {
                    if (elems[i].type === "checkbox") {
                        elems[i].checked = false;
                    }
                }
                elem.checked = currentState;
                var elements = document.getElementsByClassName('ocult');
                for (j = 0; j < elements.length; j++) {
                    if (elements[j].id != it || currentState == false) {
                        elements[j].style.display = "none";
                    } else {
                        elements[j].style.display = "block";
                    }
                }
            }
        </script>
    </head>
    <body style="background-color: #f8f9fa;">
        <?php require_once 'image_header6.php'; ?>

        <div id="princ" class="  container-fluid  " > 
            <div class=" contents col-md-10 ">
                <?php
                if (isset($_SESSION['msg43'])) {
                    echo $_SESSION['msg43'];
                    unset($_SESSION['msg43']);
                }
                ?>                 
                <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?>
                    <form class="contents  needs-validation" action="proc_aditivos.php?action=save" method="post">
                        <div class="row">
                            <div class="col-md-1 mb-10">
                                <label class="title" for="caditivo" >Nº Aditivo:</label>
                                <input class="form-control" Type="text" name="numero_aditivo" id="caditivo" value="<?php if (isset($_SESSION['dados5']['numero_aditivo'])) echo $_SESSION['dados5']['numero_aditivo']; ?>" />
                            </div>
                            <div class=" botao col-md-1 mb-10">
                                <input name="id_contrato" type="hidden" value=<?php echo $id; ?>>                           
                                <input type="submit" name="submit" value="Enviar"    class="btn btn-primary "  />
                                <input type="hidden" name="submitted" value="TRUE" /> 
                            </div> 
                        </div>
                    </form>
<?php } ?>     

                <?php if (!empty($id_aditivo)) { ?>

                    <label class="title" for="tipo"> Selecione o Lançamento  do Tipo de  Aditivo: </label>
                    <div >
                        <input id="chkCamp1" type="checkbox" class="cb"  onclick="showMe('optCamp1', this)" />
                        <label>Acrescimo</label>
                    </div>
                    <div >
                        <input id="chkCamp2" type="checkbox" class="cb"  onclick="showMe('optCamp2', this)" />
                        <label>Supressão</label>
                    </div>
                    <div >
                        <input id="chkCamp3" type="checkbox" class="cb"  onclick="showMe('optCamp3', this)" />
                        <label>Prorrogação de Vigência</label>
                    </div>
                    <div >
                        <input id="chkCamp4" type="checkbox" class="cb"  onclick="showMe('optCamp4', this)" />
                        <label>Distrato</label>
                    </div>
                    <div >
                        <input id="chkCamp5" type="checkbox" class="cb"  onclick="showMe('optCamp5', this)" />
                        <label >Repactuação de preços</label>
                    </div>
                    <div >
                        <input id="chkCamp6" type="checkbox" class="cb"  onclick="showMe('optCamp6', this)" />
                        <label >Sub- rogação de direitos e Obrigaçãoes</label>
                    </div>
                    <form class="contents   needs-validation" action="proc_aditivos.php?action=update" method="post">

                        <div class=" ocult row" id="optCamp1" >
                            <div class="col-md-3 mb-10">
                                <label class="title" for="cvalor_acrescimo" >Acrescimo:</label>			 
                                <input class="form-control"  Type="text"   name="valor_acrescimo" id="campovalor" value="<?php if (isset($_SESSION['dados']['valor_acrescimo'])) echo $_SESSION['dados']['valor_acrescimo']; ?>" >
                            </div> 
                        </div>
                        <div class=" ocult row" id="optCamp2" >
                            <div class="col-md-3 mb-10">
                                <label class="title" for="cvalor_supressao" >Supressão:</label>			 
                                <input class="form-control"  Type="text"   name="valor_supressao" id="campovalor1" value="<?php if (isset($_SESSION['dados']['valor_supressao'])) echo $_SESSION['dados']['valor_supressao']; ?>" >
                            </div> 
                        </div>
                        <div class=" ocult row" id="optCamp3" >                        
                            <div class="col-md-6 mb-10">
                                <label class="title" for="cinicio_vigencia_aditivio">Inicio Vigencia:</label>
                                <input class="form-control" Type="date" name="inicio_vigencia_aditivio" id="cinicio_vigencia_aditivo" >
                            </div>
                            <div class="col-md-6 mb-10">
                                <label class="title" for="cfim_vigencia_aditivo">Fim vigencia:</label>
                                <input class="form-control" Type="date" name="fim_vigencia_aditivo" id="cfim_vigencia_aditivo"  >
                            </div>
                        </div>
                        <div class="row"  >         
                            <div class="col-md-12 mb-10">
                                <label class="title" for="">Observação</label>
                                <input class="form-control" Type="text" name="obs" id="cprazo_atend" value="<?php if (isset($_POST['obs'])) echo $_POST['obs']; ?>" >
                            </div>  
                            <div class="botao2 col-md-12 mb-10">
                                <input name="id_contrato" type="hidden" value=<?php echo $id; ?>>  
                                <input name="id_aditivo" type="hidden" value=<?php echo $id_aditivo; ?>> 
                                <input name="numero_aditivo" type="hidden" value=<?php echo $numero_aditivo; ?>> 
                                <input type="submit" name="submit" value=" Cadastrar-lo "    class="btn btn-primary "  />
                                <input type="hidden" name="submitted" value="TRUE" /> 
                            </div> 
                        </div> 
                    </form>
    <?php
}
?>
                <table  class=" iformes table  table-striped table-hover table-bordered table-sm "   >
                    <thead class="thead-light ">
                        <tr>
                            <th scope="col">RG:</th>
                            <th scope="col">Acréscimo</th> 
                            <th scope="col">Supressão</th> 
                            <th scope="col">Inicio Vigência</th>
                            <th scope="col">Fim vigência</th>                           
                            <th scope="col">Excluir</th>     
                        </tr>
                    </thead>
<?php
$sql_quali = "SELECT * FROM aditivos WHERE id_contrato = $id";
$resul_quali = mysqli_query($conection, $sql_quali)or die('Não foi possivel conectar ao MySQL');
while ($registro10 = mysqli_fetch_array($resul_quali)) {
    $valor_acrescimo = $registro10['valor_acrescimo'];
    $valor_supressao = $registro10['valor_supressao'];
    $inicio_vigencia_aditivo = $registro10['inicio_vigencia_aditivio'];
    $fim_vigencia_aditivo = $registro10['fim_vigencia_aditivo'];
    $rg_aditivo = $registro10['numero_aditivo'];
    ?>  
                        <tr>
                            <td ><?php echo $rg_aditivo; ?></td>
                            <td  ><?php echo 'R$ ' . number_format($valor_acrescimo, 2, ',', '.'); ?></td>    
                            <td  ><?php echo 'R$ ' . number_format($valor_supressao, 2, ',', '.'); ?></td> 
                            <td ><?php echo inverteData($inicio_vigencia_aditivo); ?></td>
                            <td  ><?php echo inverteData($fim_vigencia_aditivo); ?></td>

                            <td  > <a href ="delet_aditivo.php?id=<?php echo $id; ?>&id_aditivo=<?php echo $registro10['id_aditivo']; ?>">
                                    <i class="fas fa-eraser"></i>
                                </a></td>
                        </tr>
    <?php
    if (isset($_SESSION['dados5'])) {
        unset($_SESSION['dados5']);
    }
}
?>
                </table>
            </div>
        </div>
        <nav class="navbar fixed-bottom navbar-light bg-light">	
            <a class="navbar-brand"href="idex.php?id=<?php echo $id; ?>">RETORNAR </a>	
        </nav>

    </body>
</html>






