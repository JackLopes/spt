<?php
$page_title = 'Contrato';

require_once './Funcoes/limpa_string.php';
require_once './Funcoes/func_idex.php';
require_once ('./inc/Config.inc.php');
require_once 'menu.php';
require_once 'Funcoes/func_data.php';
require_once 'Funcoes/mascara_php.php';
require_once 'database_gac.php';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$id_severidade = filter_input(INPUT_GET, 'id_severidade', FILTER_SANITIZE_NUMBER_INT);
$id_local = filter_input(INPUT_GET, 'id_local', FILTER_SANITIZE_NUMBER_INT);
$id_resp = filter_input(INPUT_GET, 'id_resp', FILTER_VALIDATE_INT);
$id_prorrogs = filter_input(INPUT_GET, 'id_prorrog', FILTER_VALIDATE_INT);

// Destruir  as sessoes  preovenientes  do frm analise de ANS
if (isset($_SESSION['dados5'])) {
    unset($_SESSION['dados5']);
}

//atribui session permissão numa variavel para validar acesso no formulario
$permissa = $_SESSION['permissao'];




if (isset($_GET['acao'])) {
    $apagar = $_GET['acao'];
}

//inclui arquivo para validar permissão do usuaario logado
require_once 'valida_permissao.php';


//Selects para preenchimento da tabela com detalhes do contrato

$sqlcontrato = "SELECT * FROM contrato WHERE id_contrato ='$id'";
$resultado = mysqli_query($conection, $sqlcontrato)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado)) {
    $for = $registro['id_prestador'];
    $rg = $registro['rg'];
    $natureza = $registro['natureza'];
    $prazo_entrega = $registro['prazo_entrega'];
    $entrega_garantia_exc = $registro['entrega_garantia_exc'];
    $valor_garantia_exc = number_format($registro['valor_garantia_exc'], 2, ',', '.');
    $fim_garantia = $registro ['fim_vig_garat'];
    $d_fim_vige_cont = $registro ['d_fim_vige_cont'];
    $data_prorro_aditivo = $registro ['data_prorro_aditivo'];
    $tipo = limpa($registro['tipo']);
    $tipo_contrato = $registro['tipo'];
    $valor_Contratado = $registro['valor_Contratado'];
    $vigência = $registro['vig_contrat'];
    $garantia = $registro['vig_garantia'];
    $link_processoverde = $registro['link_pv'];
    $link_gedig = $registro['link_ged'];
    $link_proposta = $registro['link_proscorm'];


//Prepara dados para exibição na tabela do formulario e para calculos
    $val_cot = number_format($registro['valor_Contratado'], 2, ',', '.');
    $data1 = inverteData($registro['d_Inic_vige_contr']);
    $data2 = inverteData($registro['d_fim_vige_cont']);
    $data3 = inverteData($registro['d_Aceite']);
    $data4 = inverteData($registro['d_Assinatura']);
    $data5 = inverteData($registro['d_prorro']);

//Calcula termino da vigencia para inclui na tabela contrato- dias corridos.
    $d = ' 1';
    $termino_vig = SomarData($data1, 0, $vigência, 0);
    $termino_vig1 = SubData($termino_vig, $d, 0, 0);
    $termino_vig2 = inverteData($termino_vig1);

//Obtem nome do fornecedor para exibir na tabela do formulario

    $sql3 = "SELECT * FROM prestador WHERE id_prestador = $for";
    $resultado1 = mysqli_query($conection, $sql3)or die('Não foi possivel conectar ao MySQL');
    while ($registro1 = mysqli_fetch_array($resultado1)) {

        $nom = $registro1['nome'];
    }

//Verifica se há regionais para efetuar calculo de recebimento definitivo

    $q = "SELECT id_local FROM local WHERE id_contrato = '$id'";
    $r = mysqli_query($conection, $q);
    $num = mysqli_num_rows($r);

    if ($num != 0) {

        //obtem maxima data para calculo da garantia apos entrega do recebimento definitivo

        $sql_tipo = "SELECT MAX(rec_definitivo) AS rece FROM local WHERE id_contrato = $id";
        $resultado = mysqli_query($conection, $sql_tipo)or die('Não foi possivel conectar ao MySQL');
        while ($registro3 = mysqli_fetch_array($resultado)) {

            $d_recebimento = inverteData($registro3['rece']);
            $d_rece = inverteData($registro3['rece']);
            $d_recebimento1 = inverteData($d_recebimento);

            //calculo para termino da data fim da garantia apos recebimento definitivo
            $termino_garantia = SomarData($d_recebimento, 0, $garantia, 0);
            $termino_garantia1 = SubData($termino_garantia, $d, 0, 0);
            $termino_garantia2 = inverteData($termino_garantia1);

            //tratamento da variavel  $termino_garantia2 nula                                 
            if (!empty($termino_garantia2)) {
                $termino_garantia2 = $termino_garantia2;
            } else {
                $termino_garantia2 = '1999-11-29';
            }


            //Atualiza a tabela contrato
            $garantia = "UPDATE contrato SET d_fim_vige_cont='$termino_vig2', d_recebimento='$d_recebimento1', fim_vig_garat='$termino_garantia2 ',agora='NOW' WHERE id_contrato = '$id'";
            $resp = mysqli_query($conection, $garantia);
            $data9 = date('Y-m-d H:i:s');


            // Agora insere linha na tabela Alerta caso não exista.

            $query = "SELECT id_contrato FROM  alerta WHERE id_contrato = '$id'";
            $alerta = mysqli_query($conection, $query);
            $num_alerta = mysqli_num_rows($alerta);

            if ($num_alerta < 1) {

                $q11 = "INSERT INTO alerta (obs, data, situacao, siscor, id_contrato ) VALUES (' ', '$data9','', '', '$id')";
                $r11 = mysqli_query($conection, $q11);
            }

            //tratamento de possiveis erros para exibição na tabela do formulario
            $data10 = date('d/m/y');
            $temp_rest_garant = CalculaDias($data10, $termino_garantia1);
            $temp_rest_garant = intval($temp_rest_garant);

            if ($termino_garantia1 == '29/11/1999') {
                $termino_garantia1 = "Pendente R.Definitivo";
            } else if ($d_recebimento == '00/00/0000') {
                $termino_garantia1 = "Pendente R.Definitivo";
            }
            if ($temp_rest_garant < 1) {
                $temp_rest_garant = '0';
            } else {
                $temp_rest_garant = $temp_rest_garant;
            }
        }
    } else {

        $d_recebimento = "<p style='color:red;'>Regional Ausente</p>";
        $termino_garantia1 = "Pendente R.Definitivo";
        $temp_rest_garant = "Pendente R.Definitivo";
    }

    if ($d_recebimento == '00/00/0000') {
        $d_recebimento = "<font color='#dc3545'><b>Pendente</b></font>";
    }
    if ($registro['tipo'] == 'SERVIÇOS') {
        $d_recebimento = " Não se aplica ";
        $termino_garantia1 = 'Não se aplica';
        $temp_rest_garant = 'Não se aplica';
    }

    //Calculos para aditivos       

    $sql_quali = "SELECT SUM(valor_acrescimo) AS valor FROM aditivos WHERE id_contrato = $id";
    $resul_quali = mysqli_query($conection, $sql_quali)or die('Não foi possivel conectar ao MySQL');
    while ($registro10 = mysqli_fetch_array($resul_quali)) {
        $valor_acrescimo = $registro10['valor'];
    }

    $sql_supressao = "SELECT SUM(valor_supressao) AS valor_supressao FROM aditivos WHERE id_contrato = $id";
    $resul_supressao = mysqli_query($conection, $sql_supressao)or die('Não foi possivel conectar ao MySQL');
    while ($registro11 = mysqli_fetch_array($resul_supressao)) {
        $valor_supressao = $registro11['valor_supressao'];
    }

    $valor_Contratado = $registro['valor_Contratado'];
    $valor_atual2 = $valor_Contratado + $valor_acrescimo - $valor_supressao;
    $valor_atual = number_format($valor_atual2, 2, ',', '.');

//--------------- armazena atualização do valor do contrato --------------------------------------

    if (!empty($valor_atual2)) {
        $Sql_valorAtual = "UPDATE contrato SET valor_atual='$valor_atual2' WHERE id_contrato = '$id'";
        $resp = mysqli_query($conection, $Sql_valorAtual);
    } else {
        $Sql_valorAtual = "UPDATE contrato SET valor_atual='$valor_Contratado' WHERE id_contrato = '$id'";
        $resp = mysqli_query($conection, $Sql_valorAtual);
    }
//------------------------------------------------------------------------------------------------
    if (!empty($valor_acrescimo)) {
        $val_contr = $valor_atual;
    }

//Seleciona amaxima vigencia do aditivo e atualiza a tabela contrato

    $sql_quali_prorr = "SELECT MAX(fim_vigencia_aditivo) AS vigencia_aditivo FROM aditivos WHERE id_contrato = $id";
    $resul_quali = mysqli_query($conection, $sql_quali_prorr)or die('Não foi possivel conectar ao MySQL');
    while ($registro10 = mysqli_fetch_array($resul_quali)) {

        $fim_vigencia_aditivo = $registro10['vigencia_aditivo'];

        $sql_prorro = "UPDATE contrato SET data_prorro_aditivo='$fim_vigencia_aditivo' WHERE id_contrato = '$id'";
        $resp = mysqli_query($conection, $sql_prorro);
    }



//Utilização de uma classe POO para exclusão de registros

    if (!empty($apagar)) {

        if (!empty($id_local)) {
            $apagarLocal = new Delete();
            $apagarLocal->ExeDelete('local', 'WHERE id_local = :id', "id={$id_local}");
// echo  $apagarLocal->getMsg();
        }
    }
    if (!empty($id_resp)) {
        $apagarResponsavel = new Delete();
        $apagarResponsavel->ExeDelete('responsaveis', 'WHERE id_resp = :id', "id={$id_resp}");
// echo $apagarResponsavel->getMsg();
    }



//Calculos dinamicos para monitoração no formulario
    //Variaveis Encerramento
    $data = date('Y-m-d');
    $c1 = strtotime($data);
    $c1 = (int) $c1;
    $c2 = (int) strtotime($fim_garantia);
    $c3 = (int) strtotime($prazo_entrega);
    $c4 = (int) strtotime($entrega_garantia_exc);
    $c5 = (int) strtotime($d_fim_vige_cont);
    $c6 = (int) strtotime($data_prorro_aditivo);

    if (!empty($d_rece)) {

        // Calculo Encerramento Garantia
        if ($c1 < $c2) {
            $data_3 = new DateTime($data);
            $data_4 = new DateTime($fim_garantia);
            $intervalo = $data_3->diff($data_4);
            $inter_garant = " {$intervalo->y} anos, {$intervalo->m} meses e {$intervalo->d} dias";
        } else if ($d_rece == '00/00/0000') {
            $inter_garant = "Pendente R.Definitivo";
        } else {
            $inter_garant = "Encerrado";
        }
        //Variaveis Encerramento
        // Calculo Encerramento Entrega Objeto
        if ($c1 < $c3) {
            $data_3 = new DateTime($data);
            $data_5 = new DateTime($prazo_entrega);
            $intervalo = $data_3->diff($data_5);
            $inter_objeto = " {$intervalo->m} meses e {$intervalo->d} dias";
        } else if ($d_rece == '00/00/0000') {
            $inter_objeto = "Pendente R.Definitivo";
        } else {
            $inter_objeto = "Encerrado";
        }
    }
    //Variaveis Encerramento
    // Calculo Encerramento Garantia Execução
    if ($c1 < $c4) {
        $data_3 = new DateTime($data);
        $data_6 = new DateTime($entrega_garantia_exc);
        $intervalo = $data_3->diff($data_6);
        $inter_garant_exec = " {$intervalo->m} meses e {$intervalo->d} dias";
    } else {
        $inter_garant_exec = "Encerrado";
    }

    if ($c1 < $c5) {
        $data_3 = new DateTime($data);
        $data_7 = new DateTime($d_fim_vige_cont);
        $intervalo = $data_3->diff($data_7);
        $inter_vcontr = " {$intervalo->y} anos, {$intervalo->m} meses e {$intervalo->d} dias";
    } else {
        $inter_vcontr = "Encerrado";
    }

    if (!empty($data_prorro_aditivo)) {
        if ($c1 < $c6) {
            $data_3 = new DateTime($data);
            $data_8 = new DateTime($data_prorro_aditivo);
            $intervalo = $data_3->diff($data_8);
            $inter_prorro_aditivo = " {$intervalo->y} anos, {$intervalo->m} meses e {$intervalo->d} dias";
        } else if ($c6 == 0) {
            $inter_prorro_aditivo = "Sem Previsão";
        } else {
            $inter_prorro_aditivo = "Encerrado";
        }
    }

    // atualização dinamica da tabela contrato do prazo de entrega conforme lançamento de prorrogação

    $q20 = "SELECT * FROM  historico_prorrogacao WHERE  id_contrato = '$id'  AND tipo_prorog='1'";
    $r20 = mysqli_query($conection, $q20);

    while ($register = mysqli_fetch_assoc($r20)) {
        $prorrogacaos = array();
        $prorrogacaos[] = $register ['d_prorrogada'];
        $prorrogacao3 = max($prorrogacaos);

        if (!empty($prorrogacao3)) {

            $sql8 = "UPDATE contrato SET prazo_entrega='$prorrogacao3' WHERE id_contrato ='$id'";
            $r8 = mysqli_query($conection, $sql8);
        }
    }


    // atualização dinamica da tabela contrato da entrega de garantia de execução  conforme lançamento de prorrogação

    if (!empty($prorrogacao3)) {

        if (strtotime($prorrogacao3) > strtotime($prazo_entrega)) {
            $prazo_entrega = $prorrogacao3;
        }
    }


    $q21 = "SELECT * FROM  historico_prorrogacao WHERE  id_contrato = '$id'  AND tipo_prorog='2'";
    $r21 = mysqli_query($conection, $q21);

    while ($register = mysqli_fetch_assoc($r21)) {
        $prorrogacaos = array();
        $prorrogacaos[] = $register ['d_prorrogada'];
        $prorrogacao2 = max($prorrogacaos);

        if (!empty($prorrogacao2)) {

            $sql9 = "UPDATE contrato SET entrega_garantia_exc ='$prorrogacao2' WHERE id_contrato ='$id'";
            $r9 = mysqli_query($conection, $sql9);
        }
    }
    //Validação do status do contrato
    $data_atual = date('Y-m-d');
    $validacao_status = statusAtual($data_atual, $d_fim_vige_cont, $fim_vigencia_aditivo, $termino_garantia2, $tipo_contrato, $id);

    if ($validacao_status == "Vigente") {
        $assunt = '<i class="far fa-handshake"></i> ' . 'Detalhes do Contrato ' . 'RG: ' . $rg . "<font Style='font-weight: bold;color: #A9E2F3; font-family:times new romam;margin-left:30px;'>" . $validacao_status . '</font>';
    } else if ($validacao_status == "Vigente/Garantia") {
        $assunt = '<i class="far fa-handshake"></i> ' . 'Detalhes do Contrato ' . 'RG: ' . $rg . "<font Style='font-weight: bold;color: #df7700; font-family:times new romam;margin-left:30px;'>" . $validacao_status . '</font>';
    } else if ($validacao_status == "Encerrado") {

        $assunt = '<i class="far fa-handshake"></i> ' . 'Detalhes do Contrato ' . 'RG: ' . $rg . "<font Style='font-weight: bold;color: red; font-family:times new romam;margin-left:30px;'>" . $validacao_status . '</font>';
    }


    //Titulo do formulario.
    ?>

    <section>
        <?php
        require_once 'image_header6.php';
        ?>         

        <div  class=" tot container-fluid" >


            <div style="margin: auto" class="col-md-12 mb-10"> 

                <div  class="row   " >    

                    <nav id="naviselect" class=" col-md-2 d-none d-md-block bg-light sidebar" style=" border-radius: 20px;">
                        <div class="sidebar-sticky">

                            <ul class="nav flex-column">
                                <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle text-muted" href="Painel.php" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  ><i class="fas fa-edit"></i><b>Cadastrar</b> </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdown01">
                                            <a class="nav-link" href="cad_aditivos.php?id=<?php echo $id ?>&rg=<?php echo $rg ?>">
                                                <i class="far fa-calendar-plus"></i>  Tipo de Aditivos
                                            </a>
                           
                         
                                            <a class="nav-link" href="#" data-toggle="modal" data-target="#exampleModal8">
                                                <i class="far fa-file-alt"></i> Tipos Documentos
                                            </a>

                                            <a class="nav-link"  href="#" onclick=popup2()>
                                                <i class="far fa-calendar-alt"></i>  Eventos Gerais
                                            </a>
                                            <a class="nav-link" href="" data-toggle="modal" data-target="#regModal">
                                                <i class="fas fa-globe"></i>  Regionais
                                            </a>
                                            <a class="nav-link" href="" data-toggle="modal" data-target="#resp">
                                                <i class="fas fa-address-book"></i> Responsabilidades                                                 </a>
                                            <a class="nav-link" href="#"  onclick="window.open('cad_severidade2.php?id=<?php echo $id ?>', 'popup', 'width=1200,height=700,scrolling=auto,top=0,left=0'); return false;">
                                                <i class="far fa-arrow-alt-circle-down"></i> Niveis de Severidade
                                            </a>
                                            <a class="nav-link" href="painelMultas.php?id=<?php echo $id ?>">
                                                <i class="far fa-arrow-alt-circle-down"></i> Penalidades <font color='red'> (Em Breve)</font>
                                            </a>
                                            
                                            <?php if ($registro['tipo'] == 'AQUISIÇÃO') { ?>
                                                <a class="nav-link" href="" data-toggle="modal" data-target="#prorro">
                                                    <i class="far fa-arrow-alt-circle-down"></i> Prorrogaçãoes <font color='red'> (Em Breve)</font>
                                                </a>
                                            <?php } ?>  
                                        </div>
                                    </li> 
                                <?php } ?>
                            </ul>
                            <ul class="nav flex-column mb-2">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle text-muted" href="Painel.php" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-search"></i> <b>Consultar</b> </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                                        <a class="nav-link" data-toggle="modal" href="" data-target=".bd-example-modal-lg">                                       
                                            <i class="far fa-address-book"></i>  Gestores e Fiscais
                                        </a>	
                                        <a class="nav-link" href="#" onclick=popup()>
                                            <i class="fas fa-dolly-flatbed"></i>   Fornecedor
                                        </a>
                                        <a  class="nav-link" href="" data-toggle="modal" data-target="#exampleModalCenter2">
                                            <i class="fas fa-globe"></i>  Regionais
                                        </a>
                                        <a  class="nav-link" href="previ.php?id=<?php echo $id ?>">
                                            <i class="fas fa-list"></i>  Check List
                                        </a>
                                        <a  class="nav-link" href=<?php echo $link_processoverde ?> target="_blank"><em><u>Processo Verde</u></em></a>
                                        <a class="nav-link" href=<?php echo $link_processoverde ?> target="_blank"><em><u>GEDIG</u></em></a>
                                        <a class="nav-link"href=<?php echo $link_processoverde ?> target="_blank"><em><u>Proposta Comercial</u></em></a>

                                    </div>
                            </ul>
                            <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?> 
                                <ul class="nav flex-column mb-2">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle text-muted" href="Painel.php" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-pen-square"></i> <b>Atualizar</b> </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdown01">
                                            <a class="nav-link" href="contrato.php?id_contrato=<?php echo $id ?>">
                                                <i class="far fa-handshake"></i> Atualizar Contrato
                                            </a>
                                            <a  class="nav-link" href="" data-toggle="modal" data-target="#bore">
                                                <i class="fas fa-globe"></i> Excluir Regionais
                                            </a>
                                        </div>
                                    </li>  
                                </ul>
                            <?php } ?>
                            <ul class="nav flex-column mb-2">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle text-muted" href="Painel.php" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="far fa-file-alt"></i> <b>Relatórios</b></a>
                                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                                        <a class="nav-link" href="ans.php?id=<?php echo $id ?>&rg=<?php echo $rg ?>&nom=<?php echo $nom ?>">
                                            <i class="fas fa-edit"></i>  ANS
                                        </a>	
                                        <a class="nav-link"  href="siscor_trd.php?id=<?php echo $id ?>&rg=<?php echo $rg ?>&nom=<?php echo $nom ?>">
                                            <i class="fas fa-edit"></i> SISCOR TRD<font color='red'></font>
                                        </a>
                                        <a class="nav-link" href="siscor_inicial.php?id=<?php echo $id ?>&rg=<?php echo $rg ?>&nom=<?php echo $nom ?>">
                                            <i class="fas fa-edit"></i> SISCOR INICIAL <font color='red'>(Em Breve)</font>
                                        </a>
                                        <a class="nav-link" href="#">
                                            <i class="fas fa-edit"></i> PDC <font color='red'> (Em Breve)</font>
                                        </a>
                                    </div>
                                </li>  
                            </ul>

                        </div>
                    </nav>
                    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-3 ">
                        <div class="row contleg1 col-4  justify-content-center"   >                                 
                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#"  data-toggle="modal" data-target="#PainelControle">  Painel Controle</a>
                                </li>
                            </ul>
                        </div>
                        <table  class="tb1 table   table-hover table-sm  bg-light  " style=" border-radius: 20px;">
                            <thead>
                            <thead class="thead-light" >
                            <th scope="col" colspan ="3" fonte-size align="center"  height= "30px" bgcolor= "#e8e8e8"   ><center><?php echo "<b><font color='#0080FF'>RG: </font></b>" . $registro['rg']; ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan ="3"><?php echo "<font color='#0080FF'> Objeto : </font>" . $registro['objeto']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo "<font color='#0080FF' > Status : </font>" . "<font color='#df7700'>" . limpa($registro['status']) . "</font>"; ?></td>
                                        <td><?php echo "<font color='#0080FF'> Tipo : </font>" . $tipo; ?></td>
                                        <td><?php echo "<font color='#0080FF'> Fornecedor : </font>" . "<font color='#df7700'>" . $nom . "</font>"; ?></td>                                                                                
                                    </tr>
                                    <tr>
                                        <td><?php echo "<font color='#0080FF'> Nº Projeto Básico : </font>" . $registro['projeto_basico']; ?></td>
                                        <td><?php echo "<font color='#0080FF'> Siscor Inicial: </font>" . $registro['n_siscor']; ?></td>
                                        <td><?php echo "<font color='#0080FF'>  Data da Assinatura : </font>" . $data4; ?></td>

                                    </tr>
                                    <tr>
                                        <td><?php echo "<font color='#0080FF'>Nº Processo : </font>" . $registro['n_processo']; ?></td>
                                        <td><?php echo "<font color='#0080FF'> Valor Contratado:  </font>" . "R$ " . $val_cot; ?></td>
                                        <td><?php echo "<font color='#0080FF'> Valor Atual : </font>" . "<font color='#df7700'>" . "R$ " . $valor_atual . "</font>"; ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo "<font color='#0080FF'>Vigência Contratual: </font>" . $registro['vig_contrat'] . " Meses"; ?></td>
                                        <td><?php echo "<font color='#0080FF'>Início Vig. Contratual: </font>" . $data1; ?></td>
                                        <td><?php echo "<font color='#0080FF'> Final Vig. Contratual: </font>" . $termino_vig1 . "<font color='#df7700'> (" . $inter_vcontr . ")</b></font>"; ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo "<font color='#0080FF'>Prorrogação: </font>" . "<font color='#df7700'>" . limpa($registro['pos_prorrogacao']) . "</font>"; ?></td>
                                        <td><?php echo "<font color='#0080FF'> Prorrogavel até : </font>" . $data5; ?></td>
                                        <td><?php if ($c6 != 0) echo "<font color='#0080FF'> Prorrogação Final Vig. Contratual: </font>" . inverteData($fim_vigencia_aditivo) . "<font color='#df7700'> (" . $inter_prorro_aditivo . ")</b></font>"; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">&nbsp;</td>

                                    </tr>

                                    <?php if ($registro['tipo'] == 'AQUISIÇÃO' || $registro['tipo'] == 'SOLUÇÃO') { ?>
                                        <tr>
                                            <td  style=" background-color:#cbd3da"><?php echo "<font color='#0080FF'> Vigência Garantia : </font>" . $registro['vig_garantia'] . " Meses"; ?></td>
                                            <td  style=" background-color:#cbd3da"><?php echo "<font color='#0080FF'>  Fim da Garantia : </font>" . "<font color='#df7700'><b>" . $termino_garantia1 . "</b></font>"; ?></td>
                                            <td  style=" background-color:#cbd3da"><?php
                                                if (!empty($d_rece)) {
                                                    echo "<font color='#0080FF'>  Contagem Prazo : </font>" . "<font color='#df7700'><b>" . $inter_garant . "</b></font>";
                                                }
                                                ?></td>
                                        </tr>
                                        <tr>
                                            <td  style=" background-color:#dadfe4"><?php echo "<font color='#0080FF'>  Prazo Entrega Objeto: </font> " . inverteData($prazo_entrega); ?></td>
                                            <td  style=" background-color:#dadfe4"><?php
                                                if (!empty($d_rece)) {
                                                    echo "<font color='#0080FF'> Contagem Prazo :  </font>" . "<font color='#df7700'><b>" . $inter_objeto . "</b></font>";
                                                }
                                                ?></td>
                                            <td  style=" background-color:#dadfe4"><?php echo "<font color='#0080FF'> R.Definitivo (Aquisição): </font>" . $d_recebimento; ?></td>
                                        </tr>
                                        <tr>
                                            <td  style=" background-color:#e9ecef"><?php echo "<font color='#0080FF'>  Prazo Entrega G. Execução : </font>" . inverteData($entrega_garantia_exc); ?></td>
                                            <td  style=" background-color:#e9ecef"><?php echo "<font color='#0080FF'> Status Prazo:  </font>" . "<font color='#df7700'><b>" . $inter_garant_exec . "</b></font>"; ?></td>
                                            <td  style=" background-color:#e9ecef"><?php echo "<font color='#0080FF'>  Valor Entrega G. Execução: </font>" . "R$ " . $valor_garantia_exc; ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php
                                }
                                ?>
                            </tbody>
                    </table>
                    <table  class=" tb2 table table-hover table-striped table-sm table-bordered bg-light"  >
                        <thead class="thead-light ">
                            <tr>
                                <th scope="col">Grupo</th>
                                <th scope="col">Crítica</th>                         
                                <th scope="col">Categoria</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Atendimento</th>
                                <th scope="col">Tolerancia</th>
                                <th scope="col">On-site</th>
                                <th scope="col">Solução</th>
                                <th scope="col">Multa </th>

                                <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <?php
                        $severi = "SELECT * FROM severidades WHERE id_contrato = '$id' ORDER BY (severidade)";
                        $resultado = mysqli_query($conection, $severi)or die('Não foi possivel conectar ao MySQL');
                        while ($registro = mysqli_fetch_array($resultado)) {
                            $prazo_atend = mascara_php($registro['prazo_atend']);
                            $tolerancia = mascara_php($registro['tolerancia']);
                            $start_onsite = mascara_php($registro['start_onsite']);
                            $prazo_solu = mascara_php($registro['prazo_solu']);
                            $severidade = $registro['severidade'];
                            $valorFixo = floatval($registro['valorFixo']);
                            $multa = $registro['multa'];
                            $modo = $registro['modo'];


                            if ($valorFixo <= 0) {
                                $modMulta = $multa;
                            } else if ($multa <= 0) {
                                $modMulta = 'R$ ' . number_format($valorFixo, 2, ',', '.');
                            }



                            if ($severidade == 5) {
                                $severidade = 3;
                            }

                            if ($prazo_solu == '1000:00') {
                                $prazo_solu = 'Indeterminavel';
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

                            if (($tolerancia == '1000:00' ) and $start_onsite == '1000:00') {
                                $tolerancia = 'Inaplicavel';
                                $start_onsite = 'Eventual';
                            }
                            ?>
                            <tr>
                                <td ><?php echo $registro['item']; ?></td>
                                <td  ><?php echo $severidade; ?></td>                            
                                <td ><?php echo $modo_atendimento; ?></td>
                                <td  ><?php echo $registro['descricao']; ?></td>
                                <td  ><?php echo $prazo_atend; ?></td>
                                <td ><?php echo $tolerancia; ?></td>
                                <td ><?php echo $start_onsite; ?></td>
                                <td  ><?php echo $prazo_solu; ?></td>
                                <td  ><?php echo $modMulta; ?></td>

                                <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?>
                                    <td  ><a  onclick="window.open('cad_severidade2.php?id=<?php echo $id ?>&id_severidade=<?php echo $registro['id_severidade'] ?>&action=update', 'popup', 'width=1200,height=700,scrolling=auto,top=0,left=0'); return false" href="">
                                            <i class="far fa-edit"></i>
                                        </a></td>
                                    <td  ><a  href="#"  data-toggle="modal" href="#" data-target="#exampleModal5<?php echo $registro['id_severidade'] ?>">
                                            <i class="fas fa-eraser"></i>
                                        </a></td><?php } ?>
                            </tr>

                            <!-- Modal Exclusao -->
                            <div class="modal fade" id="exampleModal5<?php echo $registro['id_severidade'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                    <a   class="btn btn-danger" href=delete.php?acao=apagar&id=<?php echo $id; ?>&id_severidade=<?php echo $registro['id_severidade'] ?>" onclick="refresh()">Sim</a>
                                                </li>
                                                <li style="margin-left:30px" class="nav-item">

                                                    <a style=" color: #FFFFFF" class="btn btn-success"  data-dismiss="modal">Nao</a>
                                                </li>
                                            </ul>
                                        </div>                             
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                    </table>
                    <?php
                    if (!empty($_SESSION['msg23'])) {
                        echo $_SESSION['msg23'];
                        unset($_SESSION['msg23']);
                    }
                    ?> 


                </main>
            </div>
            <!-- Modal check list-->
            <div class="modal fade" id="exampleModal8" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Inclusão de Tipos de  Documento - Check-List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id='envia_msg' action='cad_documentos.php?action=tipo_documento' method='POST' style="margin: auto;">
                                <div class="row">
                                    <div class="col-12  mb-3" >


                                        <label ><h4>Novo Tipo de Documento:</h4></label>
                                        <input style=" color: blue; font-weight: bold;" autocomplete="off" class="form-control" Type="text" name="nome">


                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <button type="submit" class="btn btn-primary">Incluir</button>
                                    </div>
                                </div> 
                            </form>

                            <table class=" table table-sm table-hover ">
                                <thead class=" thead-light">
                                    <tr>
                                        <th  scope="col">Tipo de Documento Inclusos</th>  
                                        <th  scope="col">Excluir</th>  
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    $sql_gestor = "SELECT nome  FROM tipos_documentos";
                                    $resultado = mysqli_query($conection, $sql_gestor)or die('Não foi possivel conectar ao MySQL');
                                    while ($registro = mysqli_fetch_array($resultado)) {
                                        ?> 
                                        <tr>
                                            <td style=" font-size: 16px;" ><?php echo $i . " - " . $registro['nome']; ?></td>                              
                                            <td><a  href="#"> <i class="fas fa-eraser"></i></a></td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>                     

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade"  id="prorro"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static"  aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title"id="exampleModalLabel" text="center" ><font  color='#0080FF'> <i class="fas fa-calendar-alt"></i> NOVA PRORROGAÇÃO</font></h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="sec" action="prorrogacao.php" method="post">

                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label ><b>TIPO DE PRORROGAÇÃO:</b></label>
                                        <select class="form-control form-control-lg" name="tipo_prorog">                                                
                                            <option ></option>
                                            <option value="1">Entrega do Objeto</option>
                                            <option value="2">Garantia de Execução Contratual</option>                                                                                
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="cd_Assinatura"><b>NOVO PRAZO:</b></label>
                                        <input class="form-control" Type="Date" name="d_prorrogada">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="cd_Assinatura"><b>OBSERVAÇÃO:</b></label>
                                        <input class="form-control" Type="text" name="detalhe">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <input name="id_contrato" type="hidden" value=<?php echo $id; ?>>
                                        <input type="submit" name="submit" value="ENVIAR"  class="btn btn-primary" />
                                        <input type="hidden" name="submitted" value="TRUE" />
                                    </div>
                                    <div class="col-md-12 mb-10">
                                        <table class="table table-sm table-hover " id="tb2">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th  scope="col">TIPO</th>  
                                                    <th  scope="col">DATA </th>  
                                                </tr>
                                            </thead>
                                            <?php
                                            $sql_gestor = "SELECT * FROM historico_prorrogacao WHERE id_contrato='$id' ORDER BY(tipo_prorog)   ";
                                            $resultado = mysqli_query($conection, $sql_gestor)or die('Não foi possivel conectar ao MySQL');
                                            while ($registro = mysqli_fetch_array($resultado)) {

                                                $tipo_prorog = $registro['tipo_prorog'];
                                                $categoria = (int) $registro['categoria'];

                                                switch ($tipo_prorog) {
                                                    case 1:
                                                        $cat = "Entrega do Objeto";
                                                        break;
                                                    case 2:
                                                        $cat = "Entrega Garantia de Execução Contratual";
                                                        break;
                                                }
                                                ?> 
                                                <tr>

                                                    <td class = "td2" ><?php echo $cat; ?></td>                              
                                                    <td class = "td2" ><?php echo inverteData($registro['d_prorrogada']); ?></td>                               

    <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2' AND $categoria < 1) { ?>
                                                        <td>
                                                            <a id="eraset" href="delete.php?acao=apagar&id=<?php echo $id; ?>&id_prorrog=<?php echo $registro['id_prorrog']; ?>"  > <i class="fas fa-eraser"  ></i></a></td>
                                                        </td>
                                                        <?php
                                                    }
                                                    ?>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            <br>
                                        </table>
                                    </div>
                                </div>
                            </form>	 
                        </div>   
                        <div class=" sec modal-footer">
                            <input  type="button" class="btn btn-danger" data-dismiss="modal" value="FECHAR">
                        </div>
                    </div>    
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="PainelControle" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"   data-backdrop="static" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLongTitle"><font color='#df7700'><b>PAINEL DE CONTROLE</b></font></h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="sec modal-body">

                            <select  class=" custom-select"   onchange="location = this.value;">
                                <option>Selecione a Regional</option>  
                                <?php
                                $an = date('Y');
                                $q1 = "SELECT loc.*, tip.id_tipo, tip.tipos
                                    FROM local as loc
                                    INNER JOIN tipo as tip ON tip.id_local=loc.id_local
                                    WHERE id_contrato = '$id'";
                                $r1 = mysqli_query($conection, $q1);
                                while ($row = mysqli_fetch_assoc($r1)) {
                                    $tipos = ucwords(strtolower($row['tipos']));

                                    $lugar_regional = $row['lugar_regional'];
                                    ?>
                                    <option id="opt" value="menu_local.php?id_tipo=<?php echo $row['id_tipo']; ?>&an=<?php echo $an; ?>&graf=1"><?php echo $lugar_regional . " - Grupo de " . $tipos; ?></option>  		
<?php } ?>
                            </select>

                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="FECHAR">
                        </div>
                    </div>
                </div>
            </div>  
            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"   data-backdrop="static" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-globe"></i> Selecionar Regional</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="sec modal-body">
                            <select  class="form-control"   onchange="openWindow(this)">

                                <option></option>
                                <?php
                                $q1 = "SELECT * FROM local WHERE id_contrato = '$id'";
                                $r1 = mysqli_query($conection, $q1);
                                while ($row = mysqli_fetch_assoc($r1)) {
                                    ?>
                                    <option value= "inf_local2.php?id=<?php echo $row['id_local']; ?>&ct=<?php echo $id; ?>"><?php echo $row['lugar_regional']; ?></option>
<?php } ?>
                            </select>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">FECHAR</button>
                        </div>
                    </div>
                </div>
            </div>  
            <!-- Modal -->
            <div class="modal fade" id="regModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> <i class="fas fa-globe"></i> Cadastrar Regionais </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class=" modal-body">
                            <form class=" sec needs-validation"  id="fm6"  action="cad_regional.php" method="post" novalidate>
                                <div class="row">
                                    <div class=" col-md-12 mb-10"> 

                                        <select  class="custom-select custom-select-lg mb-3" name="id_prestador"  >
                                            <option>Selecione a Regional</option>  
                                            <?php
                                            $q1 = "SELECT * FROM prestador WHERE modo = '1'";
                                            $r1 = mysqli_query($conection, $q1);
                                            while ($row = mysqli_fetch_assoc($r1)) {
                                                ?>
                                                <option value="<?php echo $row['id_prestador']; ?>"><?php echo $row['nome']; ?></option>  		
<?php } ?>
                                        </select>
                                    </div> 
                                </div> 
                                <div class="row">
                                    <div class="col-md-12 mb-10"> 
                                        <input name="id_contrato" type="hidden" value=<?php echo $id; ?>>
                                        <input id="envi" type="submit" name="submit" value="ENVIAR"   class="btn btn-primary" /></center><p>
                                            <input type="hidden" name="submitted" value="TRUE" />
                                    </div> 
                                </div> 
                            </form>
                        </div> 
                    </div> 
                </div>       
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade"  id="resp"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"id="exampleModalLabel" text="center" ><font color='#0080FF'> <i class="fas fa-address-book"></i>  Gestores / Fiscais / Auxiliares </font></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation"  id="fm6" action="cad_responsavel.php?action=idex" method="post" novalidate>
                        <br>
                        <div class="row">
                            <div class="col-md-12 mb-10">                  
                                <label for="forn"> Nome:</label>
                                <select class="form-control" id="forn" name="id_usuario" >
                                    <option></option>  
                                    <?php
                                    $q1 = "SELECT * FROM  usuario WHERE permissao >'1' ORDER BY nome ASC ";
                                    $r1 = mysqli_query($conection, $q1);
                                    while ($row = mysqli_fetch_assoc($r1)) {
                                        ?>
                                        <option value = "<?php echo $row ['id_usuario']; ?>"><?php echo $row ['nome']; ?></option>
<?php } ?>
                                </select>
                            </div>

                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-12 mb-10">   
                                <label for="forn1">Responsabilidades:</label>
                                <select class="form-control" id="forn1" name="responsabilidade" value="<?php if (isset($_POST['responsabilidade'])) echo $_POST['responsabilidade']; ?>" >
                                    <option selected></option>                                                                        

                                    <option value="Gestor Tecnico">Gestor Tecnico</option>
                                    <?php if ($pin == 1) { ?>
                                        <option value="Auxiliar Administrativo">Auxiliar Administrativo</option>  
                                    <?php } ?>
<?php if ($permissa == '2') { ?>
                                        <option value="Fiscal Administrativo">Fiscal Administrativo</option>  

<?php } ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <br>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-md-12 mb-10">   
                                <input type="hidden" name="id_contrato" value="<?php echo $id; ?>" />
                                <input type="hidden" name="submitted" value="TRUE" />
                                <input class="btn btn-primary btn-sm btn-block"  type="submit" name="submit" value="Enviar"/> 
                            </div>
                        </div>
                    </form>
                </div>
            </div>        
        </div>    
    </div>
    <!-- Modal -->
    <div class="modal fade" id="bore" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> <i class="fas fa-globe"></i> Excluir Regional</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <?php
                        $sql = "select * from local where id_contrato = '$id' ORDER BY (lugar_regional) ";
                        $con = mysqli_query($conection, $sql);
                        ?>
                        <table  class="table table-hover table-striped table-sm table-bordered bg-light"   >
                            <thead class="thead-dark ">
                                <tr>
                                    <th scope="col">CNPJ</th>
                                    <th scope="col">Reginal</th>
                                    <th scope="col">Excluir</th>
                            </thead>
                            <?php
                            while ($res = mysqli_fetch_array($con)) {
                                ?>
                                <tr>
                                    <td><?php echo $res['cnpj']; ?></td> 
                                    <td><?php echo $res['lugar_regional']; ?></td> 
                                    <td><a  href="idex.php?acao=apagar&id=<?php echo $res['Id_contrato'] ?>&id_local=<?php echo $res['id_local'] ?>"> <i class="fas fa-eraser"></i></a></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">  <i class="far fa-address-book"></i>  Gestores e Fiscais Responsáveis</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="col-md-12 mb-10">
                    <br>
                    <table class="tb3 table table-sm table-hover ">
                        <thead class="thead-light">
                            <tr>
                                <th colspan="3" scope="col">Gestor do Contrato</th>  
                            </tr>
                        </thead>
                        <?php
                        $gestor = '61';

                        $sql_gestor = "SELECT * FROM usuario WHERE id_usuario = '$gestor'";
                        $resultado = mysqli_query($conection, $sql_gestor)or die('Não foi possivel conectar ao MySQL');
                        while ($registro = mysqli_fetch_array($resultado)) {
                            ?> 
                            <tr>

                                <td class = "td2" ><?php echo $registro['nome']; ?></td>                     
                                <td class = "td2" ><?php echo $registro['email']; ?></td>                               
                                <td class = "td2" ><?php echo masc_tel_php($registro['telefone']); ?></td>

                            </tr>
                            <?php
                        }
                        ?>
                    </table>

                </div>
                <div class="col-md-12 mb-10">

                    <table class="tb3 table table-sm table-hover ">
                        <thead class="thead-light">
                            <tr>
                                <th colspan="3" scope="col">Gestor Administrativo</th>  
                            </tr>
                        </thead>
                        <?php
                        if ($natureza == 'GACAM') {
                            $fiscal_gerente = '107';
                        } else {
                            $fiscal_gerente = '60';
                        }

                        $sql_gestor = "SELECT * FROM usuario WHERE id_usuario = '$fiscal_gerente'";
                        $resultado = mysqli_query($conection, $sql_gestor)or die('Não foi possivel conectar ao MySQL');
                        while ($registro = mysqli_fetch_array($resultado)) {
                            ?> 
                            <tr>
                                <td class = "td2" ><?php echo $registro['nome']; ?></td>                              
                                <td class = "td2" ><?php echo $registro['email']; ?></td>                               
                                <td class = "td2" ><?php echo masc_tel_php($registro['telefone']); ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        <br>
                    </table>
                </div>
                <div class="col-md-12 mb-10">

                    <table class="tb3 table table-sm table-hover ">
                        <thead class="thead-light">
                            <tr>
                                <th colspan="5" scope="col">Fiscais  Administrativos</th>  
                            </tr>
                        </thead>
                        <?php
                        $sql_gestor = "SELECT * FROM responsaveis WHERE responsabilidade = 'Fiscal Administrativo' AND id_contrato='$id' ";
                        $resultado = mysqli_query($conection, $sql_gestor)or die('Não foi possivel conectar ao MySQL');
                        while ($registro = mysqli_fetch_array($resultado)) {
                            ?> 
                            <tr>

                                <td class = "td2" ><?php echo $registro['nome']; ?></td>                              
                                <td class = "td2" ><?php echo $registro['email']; ?></td>                               
                                <td class = "td2" ><?php echo masc_tel_php($registro['telefone']); ?></td>
                                <td class = "td2" ><?php echo $registro['sigla']; ?></td>
    <?php if ($permissa == '2') { ?>
                                    <td>

                                        <a    href="idex.php?acao=apagar&id=<?php echo $id; ?>&id_resp=<?php echo $registro['id_resp']; ?>"> <i class="fas fa-eraser"></i></a></td>

                                    </td>
                                    <?php
                                }
                                ?>

                            </tr>
                            <?php
                        }
                        ?>
                        <br>
                    </table>
                </div>
                <div class="col-md-12 mb-10">
                    <table class="tb3 table table-sm table-hover ">
                        <thead class="thead-light">
                            <tr>
                                <th colspan="5" scope="col">Auxiliar Administrativo</th>  
                            </tr>
                        </thead>
                        <?php
                        $sql_gestor = "SELECT * FROM responsaveis WHERE responsabilidade = 'Auxiliar Administrativo' AND id_contrato='$id' ";
                        $resultado = mysqli_query($conection, $sql_gestor)or die('Não foi possivel conectar ao MySQL');
                        while ($registro = mysqli_fetch_array($resultado)) {
                            ?> 
                            <tr>
                                <td class = "td2" ><?php echo $registro['nome']; ?></td>                              
                                <td class = "td2" ><?php echo $registro['email']; ?></td>                               
                                <td class = "td2" ><?php echo masc_tel_php($registro['telefone']); ?></td>
                                <td class = "td2" ><?php echo $registro['sigla']; ?></td>
    <?php if ($pin == 1) { ?>
                                    <td>
                                        <a    href="idex.php?acao=apagar&id=<?php echo $id; ?>&id_resp=<?php echo $registro['id_resp']; ?>"> <i class="fas fa-eraser"></i></a></td>
                                    </td>
                                    <?php
                                }
                                ?>
                            </tr>
                            <?php
                        }
                        ?>
                        <br>
                    </table>
                </div>
                <div class="col-md-12 mb-10">
                    <table class="tb3 table table-sm table-hover ">
                        <thead class="thead-light">
                            <tr>
                                <th colspan="4" scope="col">Gestor Técnico</th>  
                            </tr>
                        </thead>
                        <?php
                        $sql_gestor = "SELECT * FROM responsaveis WHERE responsabilidade = 'Gestor Tecnico' AND id_contrato='$id' ";
                        $resultado = mysqli_query($conection, $sql_gestor)or die('Não foi possivel conectar ao MySQL');
                        while ($registro = mysqli_fetch_array($resultado)) {
                            ?> 
                            <tr>

                                <td class = "td2" ><?php echo $registro['nome']; ?></td>                              
                                <td class = "td2" ><?php echo $registro['email']; ?></td>                               
                                <td class = "td2" ><?php echo masc_tel_php($registro['telefone']); ?></td>
    <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?>
                                    <td>

                                        <a    href="idex.php?acao=apagar&id=<?php echo $id; ?>&id_resp=<?php echo $registro['id_resp']; ?>"> <i class="fas fa-eraser"></i></a></td>

                                    </td>
                                    <?php
                                }
                                ?>
                            </tr>
                            <?php
                        }
                        ?>
                        <br>
                    </table>
                </div>
                <div class="col-md-12 mb-10">
                    <table class="tb3 table table-sm table-hover ">
                        <thead class="thead-light">
                            <tr>
                                <th colspan="4" scope="col">Fiscais  Técnicos</th>  
                            </tr>
                        </thead>
                        <?php
                        $sql_gestor = "SELECT * FROM responsaveis WHERE responsabilidade = 'Fiscal Tecnico' AND id_contrato='$id' ";
                        $resultado = mysqli_query($conection, $sql_gestor)or die('Não foi possivel conectar ao MySQL');
                        while ($registro = mysqli_fetch_array($resultado)) {
                            ?> 
                            <tr>
                                <td class = "td2" ><?php echo $registro['nome']; ?></td>                              
                                <td class = "td2" ><?php echo $registro['email']; ?></td>                               
                                <td class = "td2" ><?php echo masc_tel_php($registro['telefone']); ?></td>
                                <td class = "td2" ><?php echo $registro['sigla']; ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        <br>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">FECHAR</button>
                </div>

            </div>
        </div>


        <div id='result'  >

            <?php
            if (!empty($_SESSION['msg23'])) {

                echo $_SESSION['msg23'];

                unset($_SESSION['msg23']);
            }
            ?> 
        </div>  
</section>
<footer>
<?php require_once 'foot.php'; ?>

</footer>
<script>
    $('#prorro').on('hidden.bs.modal', function () {
        window.setTimeout(refresh, 2000);
    })

</script>
<script languague="javascript">
    function popup() {
        window.open('inf_prestador2.php?id=<?php echo $for ?>&ct=<?php echo $id ?>', 'popup', 'width=1000,height=600,scrolling=auto,top=0,left=0')
    }
    function popup2() {
        window.open('teste/index3.php?ids=<?php echo $id ?>', 'popup', 'width=1000,height=600,scrolling=auto,top=0,left=0')
    }
    function openWindow(select) {
        var value = select.options[select.selectedIndex].value;
        window.open(value, 'popup', 'width=1200,height=700,scrolling=auto,top=0,left=0')
    }
</script>
</body> 
</html>
