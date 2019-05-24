<?php
$page_title = 'Controles Regionais';

if (isset($_GET['id_tipo'])) {
    $id_tipo = (int) $_GET['id_tipo'];
}
if (isset($_POST['id_tipo'])) {
    $id_tipo = $_POST['id_tipo'];
}

if (isset($_GET['an'])) {
    $an = (int) $_GET['an'];
}
if (isset($_POST['an'])) {
    $an = (int) $_POST['an'];
}

if (isset($_GET['sinal'])) {
    $_SESSION['sinal'] = $_GET['sinal'];
}

if (isset($_GET['graf'])) {

    require_once 'Painel_Regional.php';

    $graf = $_GET['graf'];
}

if (isset($_POST['graf'])) {

    require_once 'Painel_Regional.php';

    $graf = $_POST['graf'];
}

if (isset($_REQUEST['action'])) {

    $_SESSION['req'] = $_REQUEST['action'];
}





require_once 'database_gac.php';


$query = "SELECT tip.* , loc.id_contrato, cont.tip_chamado, cont.tipo,
				cont.rg, loc.lugar_regional				
				FROM tipo AS tip
				INNER JOIN local AS loc ON  loc.id_local = tip.id_local
				INNER JOIN  contrato AS cont ON  cont.id_contrato = loc.id_contrato
				WHERE id_tipo = '$id_tipo'";

$resultado = mysqli_query($conection, $query)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado)) {

    $tipo = $registro['tipo'];
    $ct = $registro['id_contrato'];
    $tch = $registro['tip_chamado'];
    $rg = $registro['rg'];
    $regional = $registro['lugar_regional'];
    $id_local = $registro['id_local'];
    ?>








    <!doctype html>
    <html lang="pt">

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

            <link rel="stylesheet"  type="text/css" href="css/stylemenu.css" media="screen"/>
            <link rel="stylesheet" href="css/bootstrap.css" >
            <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
            <script defer src="js/fontawesome-all.min.js"></script>


            <title><?php echo $page_title; ?></title>
            <style>
                #selected{
                    color:red;

                }
           
            body {


                text-shadow: 0 .05rem .1rem rgba(0, 0, 0, .2);
             
            }
        </style>


        </head>


        <body>
            <div  class="container-fluid " >

                <header  id= "top">
                    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
                        <a class="navbar-brand" href="#">GERIR CONTRATAÇÕES - SUPGA</a>	


                        <div class="collapse navbar-collapse" >

                            <ul class="navbar-nav mr-auto  ">
                                <li class="nav-item" style="list-style-type: none;">
                                    <a style=" font-size:15px;color: #FFF;"class="navbar-brand btn btn-success" href="Painel.php"><i class="fas fa-home"></i> HOME </a>
                                </li>
                                <li class="nav-item "> 

                                    <a  class="nav-link"  href="idex.php?id=<?php echo $registro['id_contrato']; ?>" >       
                                        Contrato</a>           
                                </li>
                                <li class="nav-item dropdown " style=" margin-left: 10px;">
                                    <a class="nav-link dropdown-toggle" href="Painel.php" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i  class="fas fa-eye"></i> Controle De Processos</a>
                                    <div class="dropdown-menu " aria-labelledby="dropdown">
                                        <a class="dropdown-item" href="atestes.php"><font color='#df7700'><i class='fab fa-cc-visa'></i> NOTAS</font></a>
                                        <a class="dropdown-item" href="controle_corretiva.php" ><font style="color:red;"><i class='fas fa-wrench'></i> CORRETIVAS</font></a>
                                        <a class="dropdown-item" href="controle_itens.php"><font style="color:blue;"><i class="fas fa-eye"></i>  ITENS </font></a>
                                        <a class="dropdown-item" href="controle_preventiva.php"><font style="color:green;"><i class='fas fa-wrench'></i> PREVENTIVAS (EM BREVE)</font></a>
                                    </div>
                                </li>   
                            </ul>

                        <?php } ?>
                        <?php
                        if (isset($_SESSION['req'])) {
                            switch ($_SESSION['req']) {
                                case null:
                                    $url = '#';

                                    break;
                                case 1:
                                    $url = '#';

                                    break;
                                case 2:
                                    $url = 'corretivaMultas.php?id';
                                    break;
                                case 3:
                                    $url = '#';
                                    break;
                            }
                        }
                        ?>  

                        <select  class="custom-select btn-outline-dark"  style="width: 300px;background-color: #343a40; color:#ffffff; margin-left:8px;"  onchange="location = this.value;">
                            <option id="selected" selected><?php echo $regional; ?></option> 
                            <?php
                            $an = date('Y');

                            $q1 = "SELECT loc.*, tip.id_tipo, tip.tipos
                                    FROM local as loc
                                    INNER JOIN tipo as tip ON tip.id_local=loc.id_local
                                    WHERE id_contrato = '$ct'";
                            $r1 = mysqli_query($conection, $q1);
                            while ($row = mysqli_fetch_assoc($r1)) {
                                $tipos = ucwords(strtolower($row['tipos']));
                                ?>

                                <option  value="menu_local.php?id_tipo=<?php echo $row['id_tipo']; ?>&an=<?php echo $an; ?>&graf=1"><?php echo $row['lugar_regional'] . " - Grupo de " . $tipos; ?></option>  		

                            <?php } ?>
                        </select>
                        <form id= "for1" class="form-inline mt-2 mt-md-0" action="cad_itens.php?action=0" method="post">
                            <input Type="hidden" name="id_tipo" size="15" maxlength="20"  value="<?php echo $id_tipo; ?>" />	                           
                            <button class="btn btn-outline-primary my-2 my-sm-0"   value="ITENS" name="submit"  type="submit" ><i class="fas fa-database"></i> Itens</button>
                        </form>


                        <form id= "for2"   class="form-inline mt-2 mt-md-0" action="cad_preventiva.php?action=1" method="post">
                            <input Type="hidden" name="id_tipo"  value="<?php echo $id_tipo; ?>" />
                            <button class="btn btn-outline-success my-2 my-sm-0"  type="submit" name="submit" value="PREVENTIVA" ><i class='fas fa-wrench'></i> Preventiva</button>
                        </form>
                        <form id= "for3"  class="form-inline mt-2 mt-md-0" action="cad_corretiva.php?action=2" method="post">
                            <input Type="hidden" name="id_tipo" size="15" maxlength="20"  value="<?php echo $id_tipo; ?>" />                       
                            <button class="btn btn-outline-danger my-2 my-sm-0"   value="ITENS" name="submit"  type="submit"><i class='fas fa-wrench'></i> Corretiva</button>
                        </form>

                        <form id= "for1" class="form-inline mt-2 mt-md-0" action="Painel_Regional.php?action=0" method="post">
                            <input Type="hidden" name="id_tipo" size="15" maxlength="20"  value="<?php echo $id_tipo; ?>" />   
                            <input Type="hidden" name="an" size="15" maxlength="20"  value="<?php echo date('Y'); ?>" />   
                            <button class="btn btn-outline-primary my-2 my-sm-0"   value="ITENS" name="submit"  type="submit"><i class="far fa-chart-bar"></i> Grafico ANS</button>
                        </form>
                        <form id= "for4"  class="form-inline mt-2 mt-md-0" action="cad_pag.php?action=0" method="post">
                            <input Type="hidden" name="id_tipo" size="15" maxlength="20"  value="<?php echo $id_tipo; ?>" />                 
                            <button class="btn btn-outline-warning my-2 my-sm-0"   value="ITENS" name="submit"  type="submit" ><i class="fab fa-cc-visa"></i> Pagamento</button>
                        </form>

                        <?php if (isset($_SESSION['req']) and $_SESSION['req'] != 0) { ?>

                            <a style="margin-left:5px;" class="format btn btn-outline-danger" href="<?php echo $url ?>=<?php echo $ct ?>&id_tipo=<?php echo $id_tipo ?>">Multas</a>        

                        <?php } ?>



                    </div>
                </nav>
            </header>
        </div >
    </body>
</html>

