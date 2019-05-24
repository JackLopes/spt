<?php
session_start();
if ($_SESSION['status'] != 'LOGADO') {
    header("Location: login.php");
}

function saudacoes($nome) {

    date_default_timezone_set('America/Sao_Paulo');

    $hora = date('G');


    if (($hora >= 0) AND ( $hora < 6)) {
        $mensagem = "Boa madrugada!!! " . $nome;
    } else if (($hora >= 6) AND ( $hora < 12)) {
        $mensagem = "Bom dia!!! " . $nome;
    } else if (($hora >= 12) AND ( $hora < 18)) {
        $mensagem = "Boa tarde!!! " . $nome;
    } else {
        $mensagem = "Boa noite!!! " . $nome;
    }

    return $mensagem;
}

$nom = $_SESSION['nome'];
$nom1 = explode(" ", $nom);

$nom2 = $nom1[0];

$nom3 = saudacoes($nom2)
?>
<!doctype html>
<html lang="pt">

    <head>
        <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet"  ttype="text/css"  href="css/stylecab1.css" media="screen"/>
        <link rel="stylesheet" href="css/bootstrap.css" >
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <script defer src="js/fontawesome-all.min.js"></script>
        <title></title>
    </head>
    <body>
        <div  class="container-fluid ">

            <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark"   style="padding-left:20px">
                <img src="img/serpro5.jpg" width="30" height="30" class="d-inline-block align-top" style="padding-right:5px" alt="">
                <a class="navbar-brand"  style="padding-right:200px" href=""><?php echo $nom3 ?></a>

                <a class="navbar-brand" href="Painel.php">SPT/SI - SUPGA</a>		
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav mr-auto">

                        <li class="nav-item">
                            <a class="nav-link" href="lista_geral.php">Resumo</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="Painel.php" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cadastros</a>
                            <div class="dropdown-menu" aria-labelledby="dropdown01">
                                <a class="dropdown-item"  href="cad_prestador.php" >Fornecedor</a>	
                                <a class="dropdown-item" href="cad_contrato_etapa1.php" >Contrato</a>
                                <a class="dropdown-item" href="cad_usuario.php" >Usuários</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="Painel.php" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Listas</a>
                            <div class="dropdown-menu" aria-labelledby="dropdown01">
                                <a class="dropdown-item"  href="alerta.php" >Alerta</a>
                                <a class="dropdown-item"  href="index.php" >Usuários</a>
                            </div>
                        </li>
                    </ul>
                    <form class="form-inline mt-2 mt-md-0" action="gac_cabeça.php" method="post">
                        <input class="form-control mr-sm-1" id="prg" type="text" placeholder="Digite o RG" aria-label="Search"  name="rgs"  value="<?php if (isset($_POST['rgs'])) echo $_POST['rgs']; ?>" />

                        <button class="btn btn-outline-primary my-2 my-sm-0" name="submit"  type="submit">Pesquisar</button>
                        <input type="hidden" name="submitted" value="TRUE" />
                    </form>
                </div>

                <?php
                require_once 'database_gac.php';

                if (isset($_POST['submitted'])) {

                    $rg = mysqli_real_escape_string($conection, trim($_POST['rgs']));

                    $sqlcontrato = "SELECT * FROM contrato WHERE rg = '$rg'";
                    $resultado = mysqli_query($conection, $sqlcontrato)or die('Não foi possivel conectar ao MySQL');
                    $num = mysqli_num_rows($resultado);
                    if ($num == 0) { 
                                        
                       
                       
                             header("Location: Painel.php");
                            
                             
                          
                        
                    } else { 
                        
                         

                        while ($reg = mysqli_fetch_array($resultado)) {
                              $id_contrato =  $reg['id_contrato'];
                            
                           header("Location: idex.php?id=$id_contrato");
                           
                            ?>
                            <a class=" result btn btn-success" href="idex.php?id=<?php echo $reg['id_contrato']; ?>"><?php echo "RG: " . $reg['rg']; ?></a>
                            <?php
                        }
                    }
                }
                ?>
            </nav>
            <div>
                    <img class=" colisel second-slide" src="img/coliseu.jpg" alt="Second slide">    
            </div>
        </body>
</html>



