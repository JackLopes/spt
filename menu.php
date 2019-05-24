<?php
session_start();

if ($_SESSION['status'] != 'LOGADO') {
    header("Location: login.php");
}

$registro = $_SESSION['registro'];
$limite = $_SESSION['limite'];

if ($registro) {// verifica se a session  registro esta ativa
    $segundos = time() - $registro;
}
// fim da verificação da session registro

/* verifica o tempo de inatividade 
  se ele tiver ficado mais de 900 segundos sem atividade ele destroi a session
  se não ele renova o tempo e ai é contado mais 900 segundos */
if ($segundos > $limite) {
    session_destroy();



    unset($_SESSION['id'], $_SESSION['nome'], $_SESSION['email'], $_SESSION['permissao'], $_SESSION['matricula'], $_SESSION['status']);
    header("Location: login.php");
} else {
    $_SESSION['registro'] = time();
}




/*

  if ($_SESSION['nome'] == 'admin') {
  header("Location: login.php");
  }
 */
require_once 'database_gac.php';
$mat = $_SESSION['matricula'];
$permissa = $_SESSION['permissao'];

function saudacoes($nome) {
    date_default_timezone_set('America/Sao_Paulo');
    $hora = date('G');

    if (($hora >= 0) AND ( $hora < 6)) {
        $mensagem = "Boa madrugada! " . $nome;
    } else if (($hora >= 6) AND ( $hora < 12)) {
        $mensagem = "Bom dia!  " . $nome . ".";
    } else if (($hora >= 12) AND ( $hora < 18)) {
        $mensagem = "Boa tarde! " . $nome . ".";
    } else {
        $mensagem = "Boa noite! " . $nome;
    }
    return $mensagem;
}

$nom = $_SESSION['nome'];
$nom1 = explode(" ", $nom);
$nom2 = $nom1[0];
$nom3 = saudacoes($nom2)
?>
<!doctype html>
<html lang="pt-br">

    <head>
        <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
        <?php echo require_once 'links.php'; ?>
        <style>
            a{
                font-family: times new roman;

            }

            html,
            body {
                height: 100%;

            }

            body {


                text-shadow: 0 .05rem .1rem rgba(0, 0, 0, .2);
                box-shadow: inset 0 0 5rem rgba(0, 0, 0, .3);
            }

            .tableblock{
                display: block;
            }
            .tbodyflow{
                overflow: auto;
                height: 100px;
            }
            
            input{
                 autocomplete:"off";
            }
        </style>
        <script>
            $(function () {
                setTimeout(function () {
                    location.reload();
                }, 180000); // 3 * 60 * 1000
            });
        </script>
        <title><?php echo $page_title; ?></title>

    </head>
    <body onunload="window.opener.location.reload();">
        <div  class="container-fluid ">
            <header> 
                <nav class=" navis navbar navbar-expand-md navbar-light fixed-top bg-light  "  style="padding:20px" >
                    <img src="img/serpro5.jpg" width="30" height="30" class="d-inline-block align-top" style="padding-right:5px;" alt="">
                    <a class="  navbar-brand d-none d-xl-block"  style="padding-right:50px" href="#"  data-toggle="modal" data-target="#listar_meus_contratos"   ><?php echo $nom3 ?></a>	   
                    <a class="navbar-brand" href="Painel.php">GERIR CONTRATAÇÕES - SUPGA</a>
                    <div class="collapse navbar-collapse  " id="navbarCollapse">
                        <ul class=" options navbar-nav mr-auto">
                            <li class="nav-item d-none d-xl-block ">
                                <a class="nav-link" href="lista_geral.php"><i class="fas fa-list"></i></a>
                            </li>
                            <?php if ($permissa < 4) { ?>     

                                <li class=" nav-item dropdown d-none d-xl-block ">
                                    <a class="nav-link dropdown-toggle" href="Painel.php" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-edit"></i></i></a>
                                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                                        <a class="dropdown-item"  href="lista_entidades.php"  > <i class="fas fa-dolly-flatbed"></i>  FORNECEDOR</a>	
                                        <a class="dropdown-item" href="contrato.php" ><i class="far fa-handshake"></i> CONTRATO</a>
                                        <a class="dropdown-item" href="lista_usuario.php" > <i class="fas fa-user"></i> COLABORADOR</a>
                                    </div>
                                </li>                           

                                <li class="nav-item dropdown d-none d-xl-block ">
                                    <a class="nav-link dropdown-toggle" href="Painel.php" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-clipboard-list"></i></a>
                                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                                        <a class="dropdown-item"  href="alerta.php" ><i class="fas fa-eye"></i> </i> ALERT</a>
                                        <a class="dropdown-item" href="controle_multas.php" ><font color='#FF0000'><i class='fa fa-money-bill-alt'></i> MULTAS</font></a>
                                        <a class="dropdown-item" href="atestes.php"><font color='#df7700'><i class='fab fa-cc-visa'></i> NOTAS</font></a>
                                        <a class="dropdown-item " href="controle_corretiva.php" ><font style="color:red;"><i class='fas fa-wrench'></i> CORRETIVAS</font></a>
                                        <a class="dropdown-item" href="controle_itens.php" ><i class="fas fa-eye"></i>  ITENS </font></a>
                                        <a class="dropdown-item" href="controle_preventiva.php" ><font style="color:green;"><i class='fas fa-wrench'></i> PREVENTIVAS</font></a>
                                        <a class="dropdown-item"  href="upload.php" ><font style="color:black;"><i class="far fa-file"></i> DOCUMENTOS ARQUIVADOS PROCESSO VERDE</font></a>  


                                    </div>
                                </li>
                            <?php } ?>
                            <?php
//Obter a data atual
                            $data['atual'] = date('Y-m-d H:i:s');
//Diminuir 20 segundos 
                            $data['online'] = strtotime($data['atual'] . " - 20 seconds");
                            $data['online'] = date("Y-m-d H:i:s", $data['online']);
//Pesquisar os ultimos usuarios online nos 20 segundo
                            $result_qnt_visitas = "SELECT count(id) as online FROM visitas WHERE data_final >= '" . $data['online'] . "'";
                            $resultado_qnt_visitas = mysqli_query($conection, $result_qnt_visitas);
                            $row_qnt_visitas = mysqli_fetch_assoc($resultado_qnt_visitas);
                            ?>
                            <li class="nav-item d-none d-xl-block ">
                                <a class="nav-link"data-toggle="modal" data-target="#exampleModal6" href=""><span id='online'><font color='#df7700'><i class="fas fa-user"></i> On-Line : <?php echo $row_qnt_visitas['online']; ?></font></span></a>
                            </li>
                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

                            <script>
        //Executar a cada 10 segundos, para atualizar a qunatidade de usuários online
        setInterval(function () {
            //Incluir e enviar o POST para o arquivo responsável em fazer contagem
            $.post("processa_vis.php", {contar: '', }, function (data) {
                $('#online').text(data);
            });
        }, 10000);
                            </script>
                        </ul>

                        <li class="d-none d-xl-block nav-item" style="list-style-type: none;">
                            <a style=" font-size:15px;color: #FFF;"class="navbar-brand btn btn-danger" href="sair.php"><i class="fas fa-sign-out-alt"></i> SAIR </a>
                        </li>
                    </div>
                    <div class="d-m-none d-xl-block">
                        <form class="  form-inline mt-2 mt-md-0" action="buscaRg.php" method="post">
                            <input  style="margin-left:-8px; margin-right: 5px;" class="  form-control mr-sm-1" id="prg" type="text" placeholder="Digite o RG" aria-label="Search"  name="rgs" >
                            <button style="margin-left:5px;"class="  btn btn-outline-primary my-2 my-sm-0" name="submit"  type="submit"><i class="fab fa-sistrix"></i> Pesquisar</button>
                        </form>

                    </div>
                </nav>
            </header>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal6" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">USUÁRIOS ONLINE</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                        $data['atual'] = date('Y-m-d H:i:s');

//Diminuir 1 minuto, contar usuário no site no último minuto
//$data['online'] = strtotime($data['atual'] . " - 1 minutes");
//Diminuir 20 segundos 
                        $data['online'] = strtotime($data['atual'] . " - 20 seconds");
                        $data['online'] = date("Y-m-d H:i:s", $data['online']);
                        $result_qnt_visitas = "SELECT  nome FROM visitas WHERE data_final >= '" . $data['online'] . "'";
                        $resultado = mysqli_query($conection, $result_qnt_visitas);
                        while ($registro = mysqli_fetch_array($resultado)) {
                            ?>
                            <ul class="nav flex-column mb-2">
                                <li class="nav-item">
                                    <a class="nav-link nome" href="chat.php" ><i class="fas fa-user"></i>&nbsp		           
                                        <?php echo strtoupper($registro['nome']); ?>
                                    </a>
                                </li>             
                            </ul>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal --> 
        <div class="modal fade" id="listar_meus_contratos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center" id="exampleModalLabel "><font color='#0080FF'><i class="fas fa-list-ol"></i> Lista de Responsabilidades</font></h4>

                    </div>
                    <div class="modal-body">

                        <table class="table table-bordered">

                            <?php
                            if ($nom == 'admin' or $nom == 'Everton Valmir Oliveira Telles' or $nom == 'Fernanda Pereira Da Rosa Gomes' or $nom == 'Polliane Francisca Fuscaldi') {
                                $query3 = "SELECT cont.*,  resp.matricula, resp.responsabilidade, resp.nome				
				FROM contrato AS cont				
				INNER JOIN  responsaveis AS resp ON  resp.id_contrato = cont.id_contrato
                                WHERE resp.responsabilidade = 'Fiscal Administrativo'ORDER BY (resp.nome) ";


                                // $query3 = "SELECT id_contrato, rg, fiscal_administrativo, nome FROM contrato ORDER BY (resp.nome)";
                                $resultado = mysqli_query($conection, $query3);
                                while ($registro = mysqli_fetch_array($resultado)) {

                                    $fiscal_administrativo = $registro['nome'];

                                    if ($fiscal_administrativo == '0') {
                                        $fiscal_administrativo = 'Não Apontado Fiscal Administrativo No Sistema ';
                                    }
                                    ?>                               
                                    <tr>
                                        <td ><a  href="idex.php?id=<?php echo $registro['id_contrato']; ?>"><?php echo "<b><font color='black'> RG: " . $registro['rg'] . " </b></font> " . "<font color='#343a40'> —  </font>" . $fiscal_administrativo ?></a></td>
                                    </tr>
                                    <?php
                                }
                            } else {

                                $query3 = "SELECT cont.*,  resp.matricula, resp.responsabilidade, resp.nome				
				FROM contrato AS cont				
				INNER JOIN  responsaveis AS resp ON  resp.id_contrato = cont.id_contrato
				WHERE resp.matricula = '$mat' AND resp.responsabilidade = 'Fiscal Administrativo' ORDER BY (rg) ";
                                $resultado = mysqli_query($conection, $query3);
                                while ($registro = mysqli_fetch_assoc($resultado)) {
                                    ?>

                                    <tr>
                                        <td ><a  href="idex.php?id=<?php echo $registro['id_contrato']; ?>"><?php echo "<b><font color='black'> RG: " . $registro['rg'] . " </b></font> " . "<font color='#343a40'> —  </font>" . strtoupper($registro['status']); ?></a></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </table><br>

                        <a href="cad_novasenha.php" target="blank"><h4> <i class="fas fa-key"></i> Trocar  Minha  Senha</h4><hr> </a>

                    </div>

                </div>

            </div>
        </div>




