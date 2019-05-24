<?php
$page_title = 'SPT/SUPGA';
$assunt = '<i class="fas fa-server"></i> Cadastro de Niveis de Severidades';
require_once 'menu.php';
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$id_severidade = filter_input(INPUT_GET, 'id_severidade', FILTER_SANITIZE_NUMBER_INT);
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
        <?php  include './Funcoes/mascara.php'; ?>
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
                } else if (valor != "3")
                {

                    document.getElementById("div5").style.display = "none";
                } else if (valor == "3")
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
    </head>
    <body style="background-color: #cfcfcf; ">
        <?php require_once 'image_header6.php'; ?>
        <div  class=" tot container-fluid" >
            <div class=" contents col-md-8 order-md-1">

                <?php
                if (isset($_SESSION['msg40'])) {
                    echo $_SESSION['msg40'];
                    unset($_SESSION['msg40']);
                }


                $sql_severidade = " SELECT * FROM severidades WHERE id_severidade = '$id_severidade'";
                $resultado = mysqli_query($conection, $sql_severidade)or die('Não foi possivel conectar ao MySQL');
                while ($registro = mysqli_fetch_array($resultado)) {
                    ?>
  
                <form class="contents needs-validation"  action="atu_proce_severidade.php" method="post">
                        <div class="row">
                            <div class="col-md-3 mb-10">
                                <label for="">Modo: </label>
                                <select class="form-control"  name="modo" />
                                <option><?php if($registro['modo'] == '2'){echo '10 X 5' ;} else {echo '24 X 7';} ?></option>
                                <option value="1">24 X 7</option>
                                <option value="2">10 X 5</option> 
                                </select>
                            </div>
                                <div class="col-md-3 mb-10">
                            <label for="tipo">Tipo De Atendimento</label>
                            <select class="form-control"  name="tipo_atendimento"  onchange="interval(this.value)">
                                <option selected><?php echo $registro['tipo_atendimento']; ?></option>
                                <option value="Remoto">Remoto</option>
                                <option value="On-Site">On-Site</option>
                                <option value="Remoto e On-Site" >Remoto e On-Site</option>
                                <option value="Remoto e On-Site(Eventual)" >Remoto e On-Site (Atipico)</option>
                            </select>
                        </div>
                       
                        <div class="col-md-3 mb-10">
                            <label for="">Categoria: </label> 
                            <select class="form-control"  name="item"  onchange="prazos(this.value)">
                                <option selected><?php echo $registro['item']; ?></option>
                                <option value="Hardware">Hardware</option>
                                <option value="Software">Software</option>
                                <option value="Solução" >Solução</option>

                            </select>
                        </div>
                       
                        <div  id="div14"  class="col-md-3 mb-10">
                            <label for="">Prazo Conclusão Software: </label> 
                            <select class="form-control"  name="prazo_soft"  onchange="solucao(this.value)">
                                <option selected></option>
                                <option value="1">Sem Prazo</option>
                                <option value="2">Com Prazo</option>
                            </select>
                        </div>
                           
                        </div>
                        <div class=" row bloc1">
                            <div class="col-md-3 mb-10">
                                <label for="">Severidade:  </label>
                                <select class="form-control selec1" name="severidade" onchange="mostraDiv(this.value)">
                                   <option selected><?php echo $registro['severidade']; ?></option>
                                    <option value="1">1 </option>
                                    <option value="2">2 </option>
                                    <option value="3">3 </option>
                                    <option value="5">3 Manut. Programada </option>
                                    <option value="4">4 </option>
                                </select>
                            </div>
                            <div id="div5" class="col-md-3 mb-10">
                                <label for="">Parada Programada?</label>
                                <select class="form-control "  name="programada"  onchange="esconDiv(this.value)" >
                                     <option selected><?php echo $registro['programada']; ?></option>
                                    <option value="1">Sim</option>
                                    <option value="2">Não</option>                               
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-10">
                                <label for="">Aplicação:  </label>  
                                <select class="form-control"  name="descricao" value="<?php echo $registro['descricao']; ?>" >
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
                                </select>
                            </div>
                        </div>
                        <div class="row conter">
                            <div class="col-md-6 mb-10">
                                <label for="">Prazo Atendimento:</label>
                                <input class="time form-control" Type="text" name="prazo_atend" id="cprazo_atend" value="<?php echo $registro['prazo_atend']; ?>" >
                            </div>

                            <div id="div4" class="col-md-6 mb-10 div4">
                                <label for="">Prazo Solução:</label>     
                                <input class="time form-control" Type="text" name="prazo_solu" id="cprazo_solu" size="15" maxlength="40" value="<?php echo $registro['prazo_solu']; ?>" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-10 div2">
                                <label for="">Toleraância On-Site:</label>
                                <input class="time form-control" Type="text" name="tolerancia" id="cprazo_atend" value="<?php echo $registro['tolerancia']; ?>" >
                            </div> 
                            <div class="col-md-6 mb-10 div2">
                                <label for="">Start On-Site:</label>
                                <input class="time form-control" Type="text" name="start_onsite" id="cprazo_atend" value="<?php echo $registro['start_onsite']; ?>" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-10">
                                <label for="">Percentual Multa:</label> 
                                <input class="form-control" Type="text" step=0.01 name="multa" id="campovalor"  value="<?php echo $registro['multa']; ?>" >
                            </div>
                        </div>

                        <div class=" tot row">
                            <div class="col-md-4 mb-10 btn1">
                                <input name="id_contrato" type="hidden" value=<?php echo $id; ?>>
                                <input name="id_severidade" type="hidden" value=<?php echo $id_severidade; ?>>
                                <input type="submit" name="submit" value="CADASTRAR"  class="btn btn-primary "  />
                                <input type="hidden" name="submitted" value="TRUE" /> 
                            </div> 
                        </div>

                    </form>
    <?php
}
?>

            </div>
            <nav class="navbar fixed-bottom navbar-light bg-light">
                <a class="navbar-brand   "href="idex.php?id=<?php echo $id; ?>">RETORNAR  </a>
            </nav> 
        </div>
    </body>
</html>



