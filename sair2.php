<?php
require_once 'database_gac.php';
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (!empty($dados['status'])) {

    $numer = count($dados['status']);

    for ($i = 0; $i < $numer; $i++) {


        $ex = explode(',', $dados['status'][$i]);

        $result = "UPDATE documentos SET  status ='$ex[0]' WHERE id_doc ='$ex[1]'";
        $resultado = mysqli_query($conection, $result);
    }
}

$host = "localhost";
$user = "root";
$pass = "";
$banco = "gac";

$strcon = mysqli_connect($host, $user, $pass, $banco) or die('Não foi possivel conectar ao MySQL');



$an = date('Y');
//Verificar se está sendo passado na URL a página atual, senao é atribuido a pagina 
$pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;

//Selecionar todos os cursos da tabela
$result_curso = "SELECT * FROM pagamentos  WHERE id_contrato = '174'";
$resultado_curso = mysqli_query($strcon, $result_curso);

//Contar o total de cursos
$total_cursos = mysqli_num_rows($resultado_curso);

//Seta a quantidade de cursos por pagina
$quantidade_pg = 24;

//calcular o número de pagina necessárias para apresentar os cursos
$num_pagina = ceil($total_cursos / $quantidade_pg);

//Calcular o inicio da visualizacao
$incio = ($quantidade_pg * $pagina) - $quantidade_pg;
/*
//Selecionar os cursos a serem apresentado na página
$result_cursos = "SELECT * FROM pagamentos limit $incio, $quantidade_pg";
$resultado_cursos = mysqli_query($strcon, $result_cursos);
$total_cursos = mysqli_num_rows($resultado_cursos);
*/








?>
<!doctype html>
<html lang="pt">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet"  type="text/css" href="css/stylmulta.css" media="screen"/>	
        <link rel="stylesheet" href="css/bootstrap.css" >
    </head>
    <body>
        <div class="container-fluid">
            <div class="col-16" style=" background-color: greenyellow; " >
                <form style="margin-left:25%;"  class="needs-validation"  action="previ.php"method="post" novalidate>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label >RG:</label>
                            <input class="form-control" Type="text" name="rg"  >
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="cvig_contrat">Tipo  de Documento:</label>
                            <select class="form-control"  Type="text" name="tip_documento"  >

                                <option selected></option>
                                <option value= "1">1 - SISCOR INICIAL</option>	
                                <option value= "2">2 - ANS</option>

                            </select>	
                        </div> 
                        <div class="form-group col-md-3">
                            <label>Quantidade:</label>
                            <input class="form-control" Type="text" name="qtd"  >
                        </div>
                        <input  class="btn btn-outline-primary" type="submit" name="Prosseguir" value="ENVIAR"  class="btn btn-primary">
                    </div>
                </form> 
            </div>

            <form id='envia_msg' action='previ.php' method='POST'> 
                <?php
                
                if(!empty (filter_input(INPUT_POST, 'rg', FILTER_SANITIZE_NUMBER_INT) )){
                        
                $rg = filter_input(INPUT_POST, 'rg', FILTER_SANITIZE_NUMBER_INT);} else{

                $rg = filter_input(INPUT_GET, 'rg', FILTER_SANITIZE_NUMBER_INT);}

                require_once 'database_gac.php';

                $sql = "SELECT id_contrato FROM contrato WHERE rg = $rg ";
                $result = mysqli_query($conection, $sql)or die('Não foi possivel conectar ao MySQL');
                while ($registro = mysqli_fetch_array($result)) {

                    $id_contrato = $registro['id_contrato'];
                }


                        $sqcon = "SELECT * FROM documentos WHERE id_contrato = '$id_contrato' group by data_periodo order by (data_periodo) ASC  limit $incio, $quantidade_pg";
                        $resultado1 = mysqli_query($conection, $sqcon)or die('Não foi possivel conectar ao MySQL');
                        if (mysqli_num_rows($resultado1) == 0) {
                            
                        } else {
                            $i = 0;

                            while ($registro1 = mysqli_fetch_array($resultado1)) {
                                $status[$i] = $registro1 ['status'];
                                $categoria[$i] = $registro1 ['categoria'];
                                $id_doc[$i] = $registro1 ['id_doc'];
                                $data_periodo[$i] = $registro1 ['data_periodo'];

                                if ($categoria[$i] == 1) {
                                    $doc = 'ANS';
                                } else if ($categoria[$i] == 2) {
                                    $doc = 'Parecer Tecnico';
                            }else{
                                    $doc = 'Relatorio';
                                }
                                ?>

                                <ul>


                                    <input type='checkbox' class='form-check-input'  name="status[]"   value="2,<?php echo $id_doc[$i] ?>"   <?php
                                    if ($status[$i] == 2) {
                                        echo "checked";
                                    }
                                    ?>> 
                                    <label class='form-check-label' for='exampleCheck1'><?php echo $data_periodo[$i] ."-" . $doc ?></label> 

                                </ul>
                                <?php
                                $i++;
                            }
                        }
                    
                
                ?>
                <input type="hidden" name="rg" value="<?php echo $rg ?>">
                
              <?php
//Verificar a pagina anterior e posterior
    $pagina_anterior = $pagina - 1;
    $pagina_posterior = $pagina + 1;
    ?>   
                
                 <nav  class=" paggina fixed-bottom text-center">
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <?php if ($pagina_anterior != 0) { ?>
                    <a class="page-link" href="previ.php?pagina=<?php echo $pagina_anterior; ?>&rg=<?php echo $rg ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                <?php } else { ?>
                    <span aria-hidden="true">&laquo;</span>
                <?php } ?>
            </li >
            <?php
            //Apresentar a paginacao
            for ($i = 1; $i < $num_pagina + 1; $i++) {
                ?>
                <li class="page-item"><a class="page-link" href="previ.php?pagina=<?php echo $i; ?>&rg=<?php echo $rg ?>"><?php echo $i; ?></a></li>
            <?php } ?>
            <li class="page-item">
                <?php if ($pagina_posterior <= $num_pagina) { ?>
                    <a  class="page-link" href="previ.php?pagina=<?php echo $pagina_posterior; ?>&rg=<?php echo $rg ?>" aria-label="Previous">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                <?php } else { ?>
                    <span aria-hidden="true">&raquo;</span>
                <?php } ?>
            </li>
        </ul>
    </nav>


                <button type="submit" >Enviar</button>
            </form>
            <p id="resultado"></p>
        </div>
        <script src="js/jquery-3.2.1.slim.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script defer src="js/fontawesome-all.min.js"></script>
    </body>
</html>
