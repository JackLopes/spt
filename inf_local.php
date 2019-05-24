
<?php
$page_title = 'Informação Prestador';
require_once 'menu.php';
require_once 'database_gac.php';
require_once 'Funcoes/func_data.php';


//Utilizada apenas para usar classe para deletar
require_once ('./inc/Config.inc.php');
$Acao = filter_input(INPUT_GET, 'acao', FILTER_DEFAULT);
$id_loc = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$ct = filter_input(INPUT_GET, 'ct', FILTER_VALIDATE_INT);
$id_resp = filter_input(INPUT_GET, 'id_resp', FILTER_VALIDATE_INT);
$id_tip = filter_input(INPUT_GET, 'id_tipo', FILTER_VALIDATE_INT);


require_once 'valida_permissao.php';


if (isset($_SESSION['sinal'])) {
    unset($_SESSION['sinal']);
}

$sql_tipo = "SELECT loc.* , cont.prazo_entrega,loc.rec_definitivo, loc.sigla , cont.rg, loc.id_local, loc.lugar_regional, cont.id_contrato,
    cont.natureza, cont.tipo, cont.id_prestador			
				FROM local AS loc
				INNER JOIN contrato AS cont ON cont.id_contrato = loc.id_contrato				
				WHERE id_local= '$id_loc'";
$resultado = mysqli_query($conection, $sql_tipo)or die('Não foi possivel conectar ao MySQL');
while ($registro1 = mysqli_fetch_array($resultado)) {

    $rg = $registro1['rg'];
    $sigla = $registro1['sigla'];

    $lugar_regional = $registro1['lugar_regional'];

    $natureza = $registro1['natureza'];
    $tipo_de_contrato = $registro1['tipo'];
    $id_prestador = $registro1['id_prestador'];



    if (empty($ct)) {
        $ct = $registro1['id_contrato'];
    }
}




$assunt = ' <i class="fas fa-globe"></i>' . ' ' . $lugar_regional . ' - ' . 'RG: ' . $rg;

  $resp = 'Gestor Tecnico';
  $resp2 = 'Fiscal Administrativo';
  $id_user4 = 61;
  $resp4 = 'Gestora De Contratos';
  $resp5 = 'Fiscal Administrativo Gerencial';

  if ($natureza === 'GACAD') {

  $id_user5 = 60;
  } else {

  $id_user5 = 107;
  }

  $user = "SELECT * FROM usuario WHERE id_usuario= '$id_user4'";
  $resultado_user = mysqli_query($conection, $user);
  while ($row = mysqli_fetch_assoc($resultado_user)) {


  $nom = $row['nome'];
  $lot = $row['lotacao'];
  $fun = $row['funcao'];
  $email = $row['email'];
  $matriculas = $row['matricula'];
  $tel = $row['telefone'];

  $q = "SELECT email FROM responsaveis WHERE email = '$email' AND id_contrato='$ct'  ";
  $r = mysqli_query($conection, $q);
  $num1 = mysqli_num_rows($r);

  if (($num1 == 0) and empty($Acao)) {



  $query = "INSERT INTO responsaveis (nome, area, funcao, email, matricula, telefone, responsabilidade, id_contrato ) VALUES ('$nom', '$lot',
  '$fun', '$email','$matriculas','$tel', '$resp4', $ct )";

  $r1 = mysqli_query($conection, $query);
  }
  }

  $user = "SELECT * FROM usuario WHERE id_usuario= '$id_user5'";
  $resultado_user = mysqli_query($conection, $user);
  while ($row = mysqli_fetch_assoc($resultado_user)) {


  $nom = $row['nome'];
  $lot = $row['lotacao'];
  $fun = $row['funcao'];
  $email = $row['email'];
  $matriculas = $row['matricula'];
  $tel = $row['telefone'];

  $q = "SELECT email FROM responsaveis WHERE email = '$email' AND  id_contrato='$ct'  ";
  $r = mysqli_query($conection, $q);
  $num = mysqli_num_rows($r);

  if (($num == 0) and empty($Acao)) {


  $query = "INSERT INTO responsaveis (nome, area, funcao, email, matricula, telefone, responsabilidade ,id_contrato ) VALUES ('$nom', '$lot',
  '$fun', '$email','$matriculas','$tel', '$resp5', $ct )";

  $r1 = mysqli_query($conection, $query);
  }
  }

?>


<!DOCTYPE html>

<html lang="pt">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Fornecedor</title>
        <link rel="stylesheet"  type="text/css" href="css/styleinf_loca.css" media="screen"/>
        <link rel="stylesheet" href="css/bootstrap.css" >
        <script defer src="js/fontawesome-all.min.js"></script>
        <script>
            window.open('teste/index3.php?ids=<?php echo $id ?>', 'popup', 'width=1000,height=600,scrolling=auto,top=0,left=0')
        </script>



    </head>
    <body style="background:#cfcfcf;">
        <?php include_once 'image_header5.php' ?>



        <div  class=" container-fluid    "  style="margin-top: 20px">
            <div style="margin: auto" class="col-md-10 mb-10"> 
                <div class="row  justify-content-center">             

                    </br>

                    <nav id='naviselect' class="col-md-2 d-none d-md-block bg-light sidebar ">
                        <div class="sidebar-sticky">
                            <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?>

                                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                                    <span>Cadastro</span>    

                                </h6>

                                <ul class="nav flex-column">

                                    <li class="nav-item" id="List_1">
                                        <a class="nav-link"href="#" data-toggle="modal" data-target="#resp">
                                            <i class="fas fa-id-badge"></i> Fiscal Técnico				
                                        </a>                  
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="List_2" href="#" data-toggle="modal" data-target="#grupoHard">
                                            <i class="fas fa-database"></i>  Grupo do Objeto				
                                        </a>                  
                                    </li>
                                    </li>

                                </ul>
                            <?php } ?>
                            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                                Consultar           
                            </h6>
                            <ul class="nav flex-column mb-2">
                                <li class="nav-item">
                                    <a class="nav-link"  href="#" data-toggle="modal" data-target="#exampleModalCenter2">
                                        <i class="fas fa-globe"></i>   Outras Regionais				
                                    </a>

                                </li> 
                                <li class="nav-item">
                                    <a class="nav-link" href="inf_prestador.php?id=<?php echo $id_prestador ?>&ct=<?php echo $ct ?>">
                                        <i class="fas fa-dolly-flatbed"></i>   Fornecedor
                                    </a>
                                </li>
                            </ul>


                            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                                Relatórios             
                            </h6>
                            <ul class="nav flex-column mb-2">
                                <li class="nav-item">

                                </li>             
                            </ul>
                        </div>
                    </nav>

                    <main role="main" class="col-md-8 ml-sm-6 col-lg-10 pt-0">
                        <?php
                        if (isset($_SESSION['msg15'])) {
                            echo $_SESSION['msg15'];
                            unset($_SESSION['msg15']);
                        }
                        ?>
                        <table  class="table  table-striped table-hover table-bordered table-sm" style="margin-top: -15px"  >	
                            <?php
                            echo "<tr>";
                            echo "</tr>";

                            $sqlprestador = "SELECT * FROM local WHERE id_local = $id_loc";
                            $resultado = mysqli_query($conection, $sqlprestador)or die('Não foi possivel conectar ao MySQL');
                            while ($registro = mysqli_fetch_array($resultado)) {
                                $id_loc = $registro['id_local'];
                                $nome = $registro['lugar_regional'];
                                $cnpj = $registro['cnpj'];
                                $endereco = $registro['endereco'];

                                echo "<p><tr><td width='20px '><b>REGIONAL:</td><td  >  " . $nome . "</td><tr>";
                                echo "<tr><td><b>CNPJ:</td><td> " . $cnpj . "</td><tr>";
                                echo "<tr><td><b>ENDEREÇO:</td><td> " . $endereco . "</td><tr>";
                            }
                            echo "</table>";
                            ?>

                            <br />

                            <?php
                            if (!empty($id_tip)) {
                                $apagarTipo = new Delete();
                                $apagarTipo->ExeDelete('tipo', 'WHERE id_tipo = :id', "id={$id_tip}");
                                echo $apagarTipo->getMsg();
                            }


                            if (isset($_SESSION['msg2'])) {
                                echo $_SESSION['msg2'];
                                unset($_SESSION['msg2']);
                            }
                            ?>

                            <table class="table table-sm table-hover table-bordered"  id="tbl_1" >

                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col"> <i class="fas fa-database"></i> Grupo dos Objetos</th>
                                        <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?>
                                            <th scope="col"  >Excluir</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <?php
                                $sqltipo = "SELECT * FROM tipo WHERE id_local= '$id_loc'";
                                $resultado7 = mysqli_query($conection, $sqltipo)or die('Não foi possivel conectar ao MySQL');
                                while ($registro7 = mysqli_fetch_array($resultado7)) {
                                    ?>                           
                                    <tr>
                                        <td  ><a href="cad_itens.php?id_tipo=<?php echo $registro7['id_tipo']; ?>&sinal=sinal"><?php echo $registro7['tipos']; ?> </a></td>
                                        <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?>
                                            <td>
                                                <a  href="#"  data-toggle="modal" data-target="#exampleModal4<?php echo $registro7['id_tipo'] ?>">
                                                    <i class="fas fa-eraser"></i>
                                                </a>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                    <!-- Modal Exclusao -->
                                    <div class="modal fade" id="exampleModal4<?php echo $registro7['id_tipo'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Deseja Realmente Deletar  </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><?php echo 'O Grupo de' . ' ' . $registro7['tipos']; ?></p>
                                                    <ul class="nav justify-content-center">     
                                                        <li class="nav-item">
                                                            <a class="btn btn-danger" href="inf_local.php?acao=apagar&id=<?php echo $id_loc ?>&ct=<?php echo $ct ?>&id_tipo=<?php echo $registro7['id_tipo'] ?>">Sim</a>
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
                            </br>


                            <hr><h6  ><b><i class="fas fa-address-book"></i> Responsáveis<h6><br/>
                                        <?php
                                        if (!empty($id_resp)) {
                                            $apagarResponsavel = new Delete();
                                            $apagarResponsavel->ExeDelete('responsaveis', 'WHERE id_resp = :id', "id={$id_resp}");
                                            echo $apagarResponsavel->getMsg();
                                        }


                                        if (isset($_SESSION['msg3'])) {
                                            echo $_SESSION['msg3'];
                                            unset($_SESSION['msg3']);
                                        }
                                        if (isset($_SESSION['msg'])) {
                                            echo $_SESSION['msg'];
                                            unset($_SESSION['msg']);
                                        }
                                        ?>
                                        <div id="tbl2">
                                            <table class="table table-sm table-hover table-bordered" >

                                                <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col">Atuação</th>
                                                        <th scope="col">Nome</th>
                                                        <th scope="col">Area</th>

                                                        <th scope="col">Email</th>

                                                        <th e="col">Telefone</th>
                                                        <th e="col">Atualizado</th>
                                                    </tr>
                                                </thead>

                                                <?php
                                                $sqlcolaborador = "SELECT * FROM responsaveis WHERE id_local= '$id_loc'";
                                                $resultado = mysqli_query($conection, $sqlcolaborador)or die('Não foi possivel conectar ao MySQL');
                                                while ($registro = mysqli_fetch_array($resultado)) {

                                                    $atualizacao = $registro['atualizacao'];
                                                    $exp = explode(" ", $atualizacao);
                                                    $atualizacao = inverteData($exp[0]);
                                                    ?>
                                                    <tr>
                                                        <td class = "td2" ><?php echo $registro['responsabilidade']; ?></td>	
                                                        <td class = "td2" ><?php echo $registro['nome']; ?></td>
                                                        <td class = "td2" ><?php echo $registro['area']; ?></td>

                                                        <td class = "td2" ><?php echo $registro['email']; ?></td> 

                                                        <td class = "td2" ><?php echo $registro['telefone']; ?></td>

                                                        <td class = "td2" ><?php echo $atualizacao; ?></td>
                                                        <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?>
                                                            <td>
                                                                <a class = "td2" >
                                                                    <i class="far fa-edit"></i>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <a  href="#"  data-toggle="modal" data-target="#exampleModal5<?php echo $registro['id_resp'] ?>">
                                                                    <i class="fas fa-eraser"></i>
                                                                </a>
                                                            </td>
                                                        <?php } ?>
                                                    </tr>
                                                    <!-- Modal Exclusao -->
                                                    <div class="modal fade" id="exampleModal5<?php echo $registro['id_resp']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Deseja Realmente Deletar  </h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><?php echo $registro['nome']; ?></p>
                                                                    <ul class="nav justify-content-center">     
                                                                        <li class="nav-item">
                                                                            <a class="btn btn-danger" href="inf_local.php?acao=apagar&id=<?php echo $id_loc ?>&ct=<?php echo $ct ?>&id_resp=<?php echo $registro['id_resp'] ?>">Sim</a>
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
                                        </br>

                                        <?php if ($tipo_de_contrato != 'SERVIÇOS') { ?>                                       	                                 
                                            <br/>
                                            <?php
                                            if (isset($_SESSION['msg89'])) {
                                                echo $_SESSION['msg89'];
                                                unset($_SESSION['msg89']);
                                            }
                                            ?>
                                            <hr><h6  ><b>Recebimento Definitivo<h6><br/>
                                                        <table class="table table-hover table-sm " id="table_2" >
                                                            <tr>
                                                            <thead class="thead-light">

                                                                <tr>

                                                                    <th scope="col">Prazo Entrega</th>
                                                                    <th scope="col">Recebimento Definitivo</th>
                                                                    <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?>
                                                                        <th scope="col"  >Status</th>
                                                                    <?php } ?>
                                                                </tr>
                                                            </thead>

                                                            <?php
                                                            $sql_tipo = "SELECT loc.* , cont.prazo_entrega,loc.rec_definitivo, cont.rg, loc.id_local, cont.tipo			
				FROM local AS loc
				INNER JOIN contrato AS cont ON cont.id_contrato = loc.id_contrato				
				WHERE id_local= '$id_loc'";
                                                            $resultado = mysqli_query($conection, $sql_tipo)or die('Não foi possivel conectar ao MySQL');
                                                            while ($registro1 = mysqli_fetch_array($resultado)) {


                                                                $tipo = $registro1['tipo'];
                                                                $id_loc = $registro1['id_local'];
                                                                $rg = $registro1['rg'];

                                                                $d_rec = $registro1['rec_definitivo'];


                                                                $data_prazo = $registro1['prazo_entrega'];
                                                                $d_rec1 = inverteData($d_rec);
                                                                $data_prazo1 = inverteData($data_prazo);
                                                                $data = date('Y-m-d');




                                                                $data10 = date('d/m/y');
                                                                $temp_rest = CalculaDias($data10, $data_prazo1);
                                                                $temp_rest = intval($temp_rest);
                                                                if ($temp_rest < 1) {

                                                                    $rest = 0;
                                                                } else {
                                                                    $rest = $temp_rest;
                                                                }




                                                                if ($data_prazo != '0000-00-00' && $d_rec === '0000-00-00') {


                                                                    if (strtotime($data_prazo) < strtotime($data)) {

                                                                        $status = 'ATRASADO';
                                                                    } else if (strtotime($data_prazo) > strtotime($data)) {

                                                                        $status = 'FALTAM ' . $rest . ' DIAS PARA EXPIRAR O PRAZO';
                                                                    } else if (strtotime($data_prazo) == strtotime($data)) {
                                                                        $status = 'HOJE EXPIRA O PRAZO DO RECEBIMENTO DEFINITIVO ';
                                                                    }
                                                                } else if ($data_prazo == '0000-00-00' && $d_rec === '0000-00-00' && $tipo != 'SERVIÇOS') {
                                                                    $status = 'PENDENTE DE LANÇAMENTO';
                                                                } else if ($data_prazo == '0000-00-00' && $d_rec === '0000-00-00') {
                                                                    $status = 'NÃO SE APLICA  ';
                                                                    $data_prazo1 = 'NÃO SE APLICA  ';
                                                                    $d_rec1 = 'NÃO SE APLICA  ';
                                                                } else if ($tipo == 'SERVIÇOS') {
                                                                    $status = 'NÃO SE APLICA  ';
                                                                    $data_prazo1 = 'NÃO SE APLICA  ';
                                                                    $d_rec1 = 'NÃO SE APLICA  ';
                                                                } else {
                                                                    $status = 'OK';
                                                                }
                                                                ?>			
                                                                <tr>

                                                                    <td  ><?php echo $data_prazo1; ?></td>
                                                                    <td  ><?php echo $d_rec1; ?></td>

                                                                    <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?>
                                                                        <td  >		
                                                                    <center><a class="nav-link"  href="#" data-toggle="modal" data-target="#visualizar<?php echo $id_loc ?>"><?php echo $status; ?></a></center>

                                                                    </td>
                                                                <?php } ?>
                                                                </tr>

                                                                <!--- visualizar e Editar --->
                                                                <div class="modal fade" id="visualizar<?php echo $id_loc ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title text-center"><?php echo "RG: " . $rg; ?></h4>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                                                                    <span aria-hidden="true">&times;</span></button>
                                                                            </div>
                                                                            <div class="modal-body">						
                                                                                <form class="form-horizontal" action="atu_grupo.php" method="post">			   
                                                                                    <div class="form-group col-md-8">
                                                                                        <label for="crec_definitivo" >RECEBIMENTO DEFINITIVO:</label>
                                                                                        <input class="form-control" name="rec_definitivo" Type="date"  id="crec_definitivo"  value="<?php echo $registro1['rec_definitivo']; ?>" >

                                                                                    </div>											

                                                                                    <div class="col-sm-offset-2 col-sm-10">
                                                                                        <input name="id" type="hidden" value=<?php echo $id_loc; ?>>
                                                                                        <input name="prazo_entrega" type="hidden" value=<?php echo $data_prazo; ?>>


                                                                                        <input type="hidden" name="submitted" value="TRUE" />	

                                                                                        <button type="submit" class="btn btn-warning">Salvar Alterações</button>
                                                                                    </div>	


                                                                                </form>									




                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php }
                                                            ?>	

                                                        </table>
                                                    <?php }
                                                    ?>	
                                                    <div id="info1" >
                                                        <span>Informação:</span>
                                                    </div>
                                                    </div>

                                                    </div>  

                                                    </div>
                                                    <!----fim --->
                                                    </div>

                                                    <nav class="navbar fixed-bottom navbar-light bg-light">
                                                        <?php if (isset($_GET['ct'])) { ?>

                                                            <a class="navbar-brand" href="idex.php?id=<?php echo $_GET['ct']; ?>">RETORNAR </a>

                                                        <?php } else {
                                                            ?>

                                                            <a class="navbar-brand" href="lista_geral.php">RETORNAR </a>

                                                            <?php
                                                        }
                                                        ?> 
                                                    </nav>
                                                    </div>


                                                    <div class="modal fade"  id="grupoHard"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"id="exampleModalLabel" text="center" ><font color='#0080FF'> <i class="fas fa-database"></i> Grupo De Objetos</font></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="proc_local.php" method="post">

                                                                        <div class="form-row">
                                                                            <div class="form-group col-md-12">
                                                                                <label for="ctipos">Grupo de:</label>
                                                                                <select class="form-control" name="tipos" Type="text"  id="ctipos" value="<?php if (isset($_POST['tipos'])) echo $_POST['tipos']; ?>" />
                                                                                <option value="Hardware">Hardware</option>
                                                                                <option value="Software">Software</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <input name="ct" type="hidden" value=<?php echo $ct; ?>>
                                                                                <input name="id" type="hidden" value=<?php echo $id_loc; ?>>
                                                                                <input name="lugar_regional" type="hidden" value=<?php echo $nome; ?>>
                                                                                <p><input type="submit" name="submit" value="ENVIAR"  class="btn btn-primary" />
                                                                                    <input type="hidden" name="submitted" value="TRUE" />
                                                                            </div>

                                                                        </div>
                                                                    </form>	 

                                                                </div>        
                                                            </div>    
                                                        </div>
                                                    </div>
                                                    <!-- Modal -->
                                                    <div class="modal fade"  id="resp"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"id="exampleModalLabel" text="center" ><font color='#0080FF'> <i class="fas fa-id-badge"></i> Fiscal Técnico</font></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form class="needs-validation"  id="fm6" action="cad_responsavel.php?action=local" method="post" novalidate>
                                                                        <div class="row">
                                                                            <div class="col-md-6 mb-10">                  


                                                                                <label for="forn">NOME:</label>
                                                                                <select class="form-control" id="forn" name="id_usuario" value="<?php if (isset($_POST['id_usuario'])) echo $_POST['id_usuario']; ?>" >
                                                                                    <option>Selecione</option>  
                                                                                    <?php
                                                                                    $q1 = "SELECT * FROM  usuario WHERE permissao > 3 ORDER BY nome ASC ";
                                                                                    $r1 = mysqli_query($conection, $q1);
                                                                                    while ($row = mysqli_fetch_assoc($r1)) {
                                                                                        ?>
                                                                                        <option value = "<?php echo $row ['id_usuario']; ?>"><?php echo $row ['nome']; ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>

                                                                            <div class="col-md-6 mb-10">   
                                                                                <label for="forn1">RESPONSABILIDADE:</label>
                                                                                <select class="form-control" id="forn1" name="responsabilidade" value="<?php if (isset($_POST['responsabilidade'])) echo $_POST['responsabilidade']; ?>" >
                                                                                    <option selected></option>                                                                        

                                                                                    <option value="Fiscal Tecnico">Fiscal Tecnico</option>                                                                              
                                                                                </select>

                                                                            </div>
                                                                        </div>
                                                                        <br class="mb-4">
                                                                        <div class="row">
                                                                            <div class="col-md-12 mb-10">   
                                                                                <input type="hidden" name="id_local" value="<?php echo $id_loc; ?>" />
                                                                                <input type="hidden" name="id_contrato" value="<?php echo $ct; ?>" />
                                                                                <input type="hidden" name="sigla" value="<?php echo $sigla; ?>" />
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
                                                    <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLongTitle">SELECIONE A REGIONAL</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">

                                                                    <select  class="form-control" name="id_contrato" onchange="location = this.value;">
                                                                        <option>REGIONAIS</option>
                                                                        <?php
                                                                        $q1 = "SELECT * FROM local WHERE id_contrato = '$ct'";
                                                                        $r1 = mysqli_query($conection, $q1);
                                                                        while ($row = mysqli_fetch_assoc($r1)) {
                                                                            ?>
                                                                            <option value= "inf_local.php?id=<?php echo $row['id_local']; ?>&ct=<?php echo $ct; ?>"><?php echo $row['lugar_regional']; ?></option>
                                                                        <?php } ?>
                                                                    </select>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <script>
                                                            //var iformation1 = getelementById("info1").inneHTML;

                                                            document.getElementById("tbl2").onmouseover = function () {
                                                                document.getElementById("info1").innerHTML = "<h4 style='color:#B22222'>"+"Apartir 01/02/2019 está Tabela exibirá apenas infomação do Fiscais Técnicos." + "</h4>";
                                                            };

                                                            document.getElementById("tbl2").onmouseout = function () {
                                                                document.getElementById("info1").innerHTML = '';
                                                            };
                                                            
                                                            document.getElementById("tbl_1").onmouseover = function () {
                                                                document.getElementById("info1").innerHTML = "<h4 style='color:#B22222'>"+"Esta tabela contém o link (HARDWARE ou SOFTWARE) que acessa a pagina  onde deve ser cadastrados os referidos itens pertecentes ao referido grupo do objeto " + "</h4>";
                                                            };

                                                            document.getElementById("tbl_1").onmouseout = function () {
                                                                document.getElementById("info1").innerHTML = '';
                                                            };
                                                            
                                                            document.getElementById("table_2").onmouseover = function () {
                                                                document.getElementById("info1").innerHTML = "<h4 style='color:#B22222'>"+"Click sob o link da coluna  STATUS para inserir a data do Recebimento Definitivo" + "</h4>";
                                                            };

                                                            document.getElementById("table_2").onmouseout = function () {
                                                                document.getElementById("info1").innerHTML = '';
                                                            };
                                                            document.getElementById("List_1").onmouseover = function () {
                                                                document.getElementById("info1").innerHTML = "<h4 style='color:#B22222'>"+"Passo 1 : Click aqui para cadastrar quantos FISCAIS TÉCNICOS  foram designado para este contrato" + "</h4>";
                                                            };

                                                            document.getElementById("List_1").onmouseout = function () {
                                                                document.getElementById("info1").innerHTML = '';
                                                            };
                                                            
                                                            document.getElementById("List_2").onmouseover = function () {
                                                                document.getElementById("info1").innerHTML = "<h4 style='color:#B22222'>"+"Passo 2 : Click aqui para cadastrar o GRUPO DO OBJETO. Este se refere no sistema a duas categorias, HARDWARE  OU SOFTWARE. Logo todos intens relevantes do objeto que se enquadram em uma dessas  categoria serão posteriormente cadastrados. " + "</h4>";
                                                            };

                                                            document.getElementById("List_2").onmouseout = function () {
                                                                document.getElementById("info1").innerHTML = '';
                                                            };


                                                        </script>

                                                        </body>
                                                        <script src="js/popper.min.js"></script>
                                                        <script src="js/bootstrap.min.js"></script>
                                                        </html>