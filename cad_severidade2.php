<?php

$page_title = 'SPT/SUPGA';
require_once 'database_gac.php';
$assunt = '<i class="fas fa-server"></i> Cadastro de Niveis de Severidades';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$id_severidade = filter_input(INPUT_GET, 'id_severidade', FILTER_SANITIZE_NUMBER_INT);
$update = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

// controle de exibição do formulario
$variante_a = 1;
$variante_b = 1;

if (!empty($update)) {
    $severi = "SELECT * FROM severidades WHERE id_severidade = '$id_severidade' ";
    $resultado = mysqli_query($conection, $severi)or die('Não foi possivel conectar ao MySQL');
    while ($registro = mysqli_fetch_array($resultado)) {



        $programada = $registro['programada'];
        $id_contrato = $registro['id_contrato'];
        $prazo_atend = $registro['prazo_atend'];
        $prazo_solu = $registro['prazo_solu'];
        $descricao = $registro['descricao'];
        $multa = $registro['multa'];
        $valorFixo = $registro['valorFixo'];
        $item = $registro['item'];
        $modo = $registro['modo'];
        $severidade = $registro['severidade'];
        $tipo_atendimento = $registro['tipo_atendimento'];
        $tolerancia = $registro['tolerancia'];
        $start_onsite = $registro['start_onsite'];
        $tipoCalcMulta = $registro['tipoCalcMulta'];

        if ($prazo_solu == '100000') {


            $prazo_soft = 1;
        } else {

            $prazo_soft = 2;
        }
    }
}

if (!empty($_SESSION['dados']['multa'])) {
    $multa = $_SESSION['dados']['multa'];
    $valorFixo = 0;
}
if (!empty($_SESSION['dados']['valorFixo'])) {

    $valorFixo = $_SESSION['dados']['valorFixo'];
    $multa = 0;
}

if (!empty($id_severidade) || !empty($_SESSION['dados']['severidade'])) {

    if (isset($id_severidade) || $_SESSION['dados']['severidade']) {
        if ($multa <= 0) {
            $variante_a = 2;
            $variante_b = 1;
            $tipoCalcMulta = 1;
        } else if ($valorFixo <= 0) {

            $variante_a = 1;
            $variante_b = 2;
            $tipoCalcMulta = 2;
        }
    }
}
?>

<!doctype html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
        <link rel="stylesheet"  type="text/css" href="css/styleseveri.css" media="screen"/>
        <link rel="stylesheet" href="css/bootstrap.css" >
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <script defer src="js/fontawesome-all.min.js"></script>
        <script src="js/jquery.mask.js"></script>

        <?php 
         include 'header_close.php'; 
        include './Funcoes/mascara.php'; ?>

        <style>
            .titl{
                color:red;

            }
            .teste{
                color:red;

            }
            .teste1{
                color:red;

            }
            label{
                color:#007bff;
                font-size: 23px;
                font-weight: bolder;

            }
            #fmr1 input{
                background-color: #e9ecef;

                font-weight: bolder;

                font-size: 20px;
            }
            #fmr1 select{
                background-color: #e9ecef;
                font-size: 18px;
                font-weight: bolder;


            }
        </style>


    </head>
    <body style="background-color: #f8f9fa; "  >
        <?php require_once 'image_header6.php';
        ?>

     
        <div  class=" container-fluid    "  style="margin-top: 20px">
            <div class=" contents col-md-8 order-md-1">

                <?php
                if (isset($_SESSION['msg40'])) {
                    echo $_SESSION['msg40'];
                    unset($_SESSION['msg40']);
                }
                ?>
                <form id="fmr1" class="contents needs-validation" <?php if ($id_severidade) { ?> action="proce_severidade.php?action=update"<?php } else { ?> action="proce_severidade.php?action=salva" <?php } ?>  method="post">
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label for="">MODO: </label>
                            <select class="form-control"  name="modo">
                                <option Selected ><?php
                                    if (isset($_SESSION['dados']['modo'])) {
                                        echo $_SESSION['dados']['modo'];
                                    } elseif (!empty($id_severidade)) {
                                        echo $modo;
                                    }
                                    ?></option> 
                                <option value="1">24 X 7 - 24h </option>
                                <option value="2">10 X 5 - Das 8h as 18h</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tipo">TIPO DE ATENDIMENTO</label>
                            <select class="form-control"  name="tipo_atendimento"  onchange="interval(this.value)">
                                <option selected><?php
                                    if (isset($_SESSION['dados']['tipo_atendimento'])) {
                                        echo $_SESSION['dados']['tipo_atendimento'];
                                    } elseif (!empty($id_severidade)) {
                                        echo $tipo_atendimento;
                                    }
                                    ?></option>
                                <option value="Remoto">Remoto</option>
                                <option value="On-Site">On-Site</option>
                                <option value="Remoto e On-Site" >Remoto e On-Site</option>
                                <option value="Remoto e On-Site(Eventual)" >Remoto e On-Site (Atipico)</option>
                            </select>
                        </div>



                        <div class="col-md-6 mb-3">
                            <label for="">CATEGORIAS: </label> 
                            <select class="form-control"  name="item"  onchange="prazos(this.value)">
                                <option selected><?php
                                    if (isset($_SESSION['dados']['item'])) {
                                        echo $_SESSION['dados']['item'];
                                    } elseif (!empty($id_severidade)) {
                                        echo $item;
                                    }
                                    ?></option>
                                <option value="Hardware">Hardware</option>
                                <option value="Software">Software</option>
                                <option value="Solução" >Solução</option>

                            </select>
                        </div>

                        <div  id="div14"  class="col-md-6 mb-3">
                            <label for="">PREVISÃO PRAZO CONCLUSÃO: </label> 
                            <select class="form-control"  name="prazo_soft"  onchange="solucao(this.value)">
                                <option selected><?php
                                    if (isset($_SESSION['dados']['prazo_soft'])) {
                                        echo $_SESSION['dados']['prazo_soft'];
                                    } elseif (!empty($id_severidade)) {
                                        echo $prazo_soft;
                                    }
                                    ?></option>
                                <option value="1">1 - Sem Prazo</option>
                                <option value="2">2 - Com Prazo</option>
                            </select>
                        </div>
                    </div>


                    <div class=" row ">
                        <div class="col-md-6 mb-3">
                            <label for="">SEVERIDADES:  </label>
                            <select class="form-control selec1" name="severidade" onchange="mostraDiv(this.value)">
                                <option selected><?php
                                    if (isset($_SESSION['dados']['severidade'])) {
                                        echo $_SESSION['dados']['severidade'];
                                    } elseif (!empty($id_severidade)) {
                                        echo $severidade;
                                    }
                                    ?></option>
                                <option value="1">1 </option>
                                <option value="2">2 </option>
                                <option value="3">3 </option>
                                <option value="5">3 Manut. Programada </option>
                                <option value="4">4 </option>
                            </select>
                        </div>
                        <div id="div5" class="col-md-6 mb-3">
                            <label for="">PARADA PROGRAMADA ?</label>
                            <select class="form-control "  name="programada"  onchange="esconDiv(this.value)" >
                                <option selected><?php
                                    if (isset($_SESSION['dados']['programada'])) {
                                        echo $_SESSION['dados']['programada'];
                                    } elseif (!empty($id_severidade)) {
                                        echo $programada;
                                    }
                                    ?></option>
                                <option value="1">Sim</option>
                                <option value="2">Não</option>                               
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-10">
                            <label for="">DESCRIÇÃO </label>  
                            <select class="form-control"  name="descricao"  >
                                <option selected><?php
                                    if (isset($_SESSION['dados']['descricao'])) {
                                        echo $_SESSION['dados']['descricao'];
                                    } elseif (!empty($id_severidade)) {
                                        echo $descricao;
                                    }
                                    ?></option>
                                <option value="Associados a problemas ou questão grave, e que prejudica a operação do sistema">Associados a problemas ou questão grave, e que prejudica a operação do sistema</option>
                                <option value="Situações de emergência ou problema crítico, caracterizados pela existência de ambiente paralisado">Situações de emergência ou problema crítico, caracterizados pela existência de ambiente paralisado</option>
                                <option value="Associados a situações de alto impacto, incluindo os casos de degradação severa de desempenho">Associados a situações de alto impacto, incluindo os casos de degradação severa de desempenho</option>
                                <option value="Associados a problemas que criam restrições à operação do sistema, porém não afetam a sua funcionalidade">Associados a problemas que criam restrições à operação do sistema, porém não afetam a sua funcionalidade</option>
                                <option value="Associados a problemas ou dúvidas que não afetam a operação do sistema">Associados a problemas ou dúvidas que não afetam a operação do sistema</option>
                                <option value="Situações de baixo impacto ou com problemas intermitentes, incluindo substituição de componentes">Situações de baixo impacto ou com problemas intermitentes, incluindo substituição de componentes</option>                         
                                <option value="Chamados com objetivo de sanar dúvidas quanto ao uso ou à implementação do produto">Chamados com objetivo de sanar dúvidas quanto ao uso ou à implementação do produto</option>
                                <option value="Solicitar acompanhamento técnico presencial para o desligamento e posterior ligação confome atividade programada.">Solicitar acompanhamento técnico presencial para o desligamento e posterior ligação confome atividade programada.</option>
                                <option value="Em caso de qualquer defeito durante o período de garantia, a Contratada deverá realizar a troca em até 15 dias.">Em caso de qualquer defeito durante o período de garantia, a Contratada deverá realizar a troca em até 15 dias.</option>
                                <option value="Chamados com objetivo de solicitar acompanhamento técnico presencial para o desligamento e posterior ligação do (s) equipamento (s) em virtude de atividade programada.">Chamados com objetivo de solicitar acompanhamento técnico presencial para o desligamento e posterior ligação do (s) equipamento (s) em virtude de atividade programada.</option>
                                <option value="Ocorre quando existe uma grave perda de funcionalidade">Ocorre quando existe uma grave perda de funcionalidade</option>
                                <option value="Ocorre quando existe perda de funcionalidade"> Ocorre quando existe perda de funcionalidade</option>
                                <option value="Ocorre quando existe uma perda menor de serviço">Ocorre quando existe uma perda menor de serviço.</option>
                                <option value="Ocorre quando existe uma grave perda de funcionalidade">  Ocorre quando existe uma grave perda de funcionalidade</option>
                                <option value="Ocorre quando problemas que impactam no negócio ou produto do SERPRO , causados pela perda ou paralisação total do serviço.">Ocorre quando problemas que impactam no negócio ou produto do SERPRO , causados pela perda ou paralisação total do serviço.</option>
                                <option value="Problema que impacta de forma severa o uso do Software em ambiente de produção (tal como perda de dados de produção ou quando os sistemas de produção não estão funcionando). A situação interrompe suas operações comerciais e não há hipótese de procedimento alternativo.">Problema que impacta de forma severa o uso do Software em ambiente de produção (tal como perda de dados de produção ou quando os sistemas de produção não estão funcionando). A situação interrompe suas operações comerciais e não há hipótese de procedimento alternativo.</option>
                                <option value="Problema quando o Software está funcionando, mas o uso no ambiente de produção está severamente reduzido. A situação está afetando demais partes de suas operações comerciais e não há hipótese de procedimento alternativo.">Problema quando o Software está funcionando, mas o uso no ambiente de produção está severamente reduzido. A situação está afetando demais partes de suas operações comerciais e não há hipótese de procedimento alternativo.</option>
                                <option value="Problema que envolve a perda parcial e não crítica do uso do Software no ambiente de produção ou no ambiente de
                                        desenvolvimento. Para ambientes de produção, há um impacto médio para baixo nos negócios, mas seu negócio continua funcionando, inclusive pelo uso de procedimento alternativo. Para ambientes de desenvolvimento, a situação faz com que o seu projeto não possa mais continuar nem migrar para produção.">Problema que envolve a perda parcial e não crítica do uso do Software no ambiente de produção ou no ambiente de
                                    desenvolvimento. Para ambientes de produção, há um impacto médio para baixo nos negócios, mas seu negócio continua funcionando, inclusive pelo uso de procedimento alternativo. Para ambientes de desenvolvimento, a situação faz com que o seu projeto não possa mais continuar nem migrar para produção.</option>
                                <option value="Questões de uso geral, relatos de erro de documentação ou recomendações para um futuro aprimoramento ou modificação do produto. Para ambientes de produção, há um impacto baixo para nenhum nos negócios, no desempenho ou na funcionalidade dos sistemas. Para ambientes de desenvolvimento, há um impacto médio para
                                        baixo em seus negócios, mas seus negócios continuam funcionando, inclusive através de uso de procedimento alternativo.">Questões de uso geral, relatos de erro de documentação ou recomendações para um futuro aprimoramento ou modificação do produto. Para ambientes de produção, há um impacto baixo para nenhum nos negócios, no desempenho ou na funcionalidade dos sistemas. Para ambientes de desenvolvimento, há um impacto médio para
                                    baixo em seus negócios, mas seus negócios continuam funcionando, inclusive através de uso de procedimento alternativo.</option>
                                  <option value="Equipamento fora  de operação, ou  com alguma funcionalidade comprometida.">Equipamento fora  de operação, ou  com alguma funcionalidade comprometida.</option>
                            <option value="Equipamento com falha em algum de seus componentes, mas ainda operacional.">Equipamento com falha em algum de seus componentes, mas ainda operacional.</option>

                            </select>
                        </div>
                    </div>
                    <div class="row conter">

                        <div class="col-md-6 mb-3">
                            <label for="">PRAZO DE ATENDIMENTO:</label>
                            <input class="time form-control" Type="text"   placeholder="00:00" name="prazo_atend" id="cprazo_atend" value="<?php
                                    if (isset($_SESSION['dados']['prazo_atend'])) {
                                        echo $_SESSION['dados']['prazo_atend'];
                                    } elseif (!empty($id_severidade)) {
                                        echo $prazo_atend;
                                    }
                                    ?>" >
                        </div>

                        <div id="div15" class="col-md-6 mb-3 div4">
                            <label for="">PRAZO DE SOLUÇÃO:</label>     
                            <input class=" time form-control" Type="text"  placeholder="00:00" name="prazo_solu" id="cprazo_solu" size="15" maxlength="40" value="<?php
                                    if (isset($_SESSION['dados']['prazo_solu'])) {
                                        echo $_SESSION['dados']['prazo_solu'];
                                    } elseif (!empty($id_severidade)) {
                                        echo $prazo_solu;
                                    }
                                    ?>" />
                        </div>
                    </div>
                    <div class="row">
                        <div id="div12"   class="col-md-6 mb-3 div2">
                            <label for="">TOLERÂNCIA ON-SITE:</label>
                            <input class="time form-control" Type="text"  placeholder="00:00"  name="tolerancia" id="cprazo_atend" value="<?php
                            if (isset($_SESSION['dados']['tolerancia'])) {
                                echo $_SESSION['dados']['tolerancia'];
                            } elseif (!empty($id_severidade)) {
                                echo $tolerancia;
                            }
                                    ?>" >
                        </div> 
                        <div  id="div13"  class="col-md-6 mb-3 div2">
                            <label for="">START ON-SITE:</label>
                            <input class=" time form-control" Type="text" placeholder="00:00"  name="start_onsite" id="cprazo_atend" value="<?php
                        if (isset($_SESSION['dados']['start_onsite'])) {
                            echo $_SESSION['dados']['start_onsite'];
                        } elseif (!empty($id_severidade)) {
                            echo $start_onsite;
                        }
                        ?>" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="">MODO DA MULTA:  </label>
                            <select class="form-control selec1" name="tipoCalcMulta" onchange="modaMulta(this.value)">
                                <option selected><?php
                            if (isset($_SESSION['dados']['tipoCalcMulta'])) {
                                echo $_SESSION['dados']['tipoCalcMulta'];
                            } elseif (!empty($id_severidade)) {
                                echo $tipoCalcMulta;
                            }
                        ?></option>
                                <option value="1">Valor Fixo</option>
                                <option value="2">Percentual</option>

                            </select>
                        </div>
                            <?php if ($variante_a == 1) { ?>
                            <div id="percent" class="col-md-4 mb-3">
                                <label for="">PERCENTUAL:</label> 
                                <input class="form-control" Type="text" step=0.01 name="multa" id="campovalor"  value="<?php
                                if (isset($_SESSION['dados']['multa'])) {
                                    echo $_SESSION['dados']['multa'];
                                } elseif (!empty($id_severidade)) {
                                    echo $multa;
                                }
                                ?>" >
                            </div>
<?php } ?>
                <?php if ($variante_b == 1) { ?>
                            <div id="valoMult"  class="col-md-4 mb-3">
                                <label for="">VALOR MULTA (FIXA):</label> 
                                <input class="form-control" Type="text" step=0.01 name="valorFixo" id="campovalor1"  value="<?php
                    if (isset($_SESSION['dados']['valorFixo'])) {
                        echo $_SESSION['dados']['valorFixo'];
                    } elseif (!empty($id_severidade)) {
                        echo $valorFixo;
                    }
                    ?>" >
                            </div>
<?php } ?>
                    </div>

                    <div class="  row">
                        <div class="col-md-4 mb-10 ">
<?php if (!empty($id_severidade)) { ?>

                                <input name="id_severidade" type="hidden" value=<?php echo $id_severidade; ?>>

<?php } ?>
                            <input name="id_contrato" type="hidden" value=<?php echo $id; ?>>
                            <button type="submit" name="submit"  class="btn btn-primary " > CADASTRAR</button> 
                            <input type="hidden" name="submitted" value="TRUE" /> 
                        </div> 
                    </div>


                </form>
<?php unset($_SESSION['dados']); ?> 
            </div>

        </div>
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


            $('.mult').on("change", function () {
                $(this).val(parseFloat($(this).val()).toFixed(2));
            });


        </script>
        <script>
            $(function () {
                var cprazo = $('.div2');
                $('#customRadio5').click(function () {
                    cprazo.hide('slow')
                });
            });
            $(function () {
                var cprazo = $('.div2');
                $('#customRadio4').click(function () {
                    cprazo.hide('slow')
                });
            });
            $(function () {
                var cprazo = $('.div2');
                $('#customRadio6').click(function () {
                    cprazo.show('slow')
                });
            });
            $(function () {
                var cprazo = $('.div2');
                $('#customRadio7').click(function () {
                    cprazo.hide('slow')
                });
            });
            $(function () {
                var pra_soft = $('.div3');
                $('#customRadio9').click(function () {
                    pra_soft.show('slow')
                });
            });
            $(function () {
                var pra_soft = $('.div3');
                $('#customRadio8').click(function () {
                    pra_soft.hide('slow')
                });
            });
            $(function () {
                var pra_soft = $('.div3');
                $('#customRadio10').click(function () {
                    pra_soft.hide('slow')
                });
            });
            $(function () {
                var pra_soft = $('.div4');
                $('#customRadio11').click(function () {
                    pra_soft.hide('slow')
                });
            });
            $(function () {
                var pra_soft = $('.div4');
                $('#customRadio12').click(function () {
                    pra_soft.show('slow')
                });
            });
            $(function () {
                var pra_soft = $('.div4');
                $('#customRadio8').click(function () {
                    pra_soft.show('slow')
                });
            });
            $(function () {
                var pra_soft = $('.div4');
                $('#customRadio10').click(function () {
                    pra_soft.show('slow')
                });
            });

            function mostraDiv(valor)
            {
                if (valor == "1")
                {
                    document.getElementById("div5").style.display = "none";
                } else if (valor != "5")
                {
                    document.getElementById("div5").style.display = "none";
                } else if (valor == "5")
                {
                    document.getElementById("div5").style.display = "block";
                }
            }

            function esconDiv(valor)
            {
                if (valor == "1")
                {
                    document.getElementById("div4").style.display = "none";
                } else if (valor == "2")
                {
                    document.getElementById("div4").style.display = "block";
                }
            }

        </script>
        <script>

            function interval(valor)
            {
                if (valor == "Remoto")
                {
                    document.getElementById("div12").style.display = "none";
                    document.getElementById("div13").style.display = "none";
                } else if (valor == "On-Site")
                {
                    document.getElementById("div12").style.display = "none";
                    document.getElementById("div13").style.display = "none";
                } else if (valor == "Remoto e On-Site(Eventual)")
                {
                    document.getElementById("div12").style.display = "none";
                    document.getElementById("div13").style.display = "none";
                } else if (valor == "Remoto e On-Site")
                {
                    document.getElementById("div12").style.display = "block";
                    document.getElementById("div13").style.display = "block";
                }
            }


            function prazos(valor)
            {
                if (valor == "Hardware")
                {
                    document.getElementById("div14").style.display = "block";
                } else if (valor == "Solução")

                {
                    document.getElementById("div14").style.display = "block";
                } else if (valor == "Software")
                {
                    document.getElementById("div14").style.display = "block";
                }
            }

            function solucao(valor)
            {
                if (valor == "1")
                {
                    document.getElementById("div15").style.display = "none";
                } else if (valor == "2")
                {
                    document.getElementById("div15").style.display = "block";
                }
            }
            function modaMulta(valor)
            {
                if (valor == "1")
                {
                    document.getElementById("percent").style.display = "none";
                    document.getElementById("valoMult").style.display = "block";
                } else if (valor == "2")
                {
                    document.getElementById("percent").style.display = "block";
                    document.getElementById("valoMult").style.display = "none";
                }
            }
        </script>
    </body>

</html>


