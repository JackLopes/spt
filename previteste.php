<?php
$page_title = "Check- List";
require_once 'menu.php';
require_once 'database_gac.php';


if (!empty(filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT))) {

    $id_contrato = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
} else {

    $id_contrato = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
}

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);




if (!empty($dados['status'])) {

    $numer = count($dados['status']);

    for ($i = 0; $i < $numer; $i++) {


        $ex = explode(',', $dados['status'][$i]);

        $result = "UPDATE documentos SET  status ='$ex[0]' WHERE id_doc ='$ex[1]'";
        $resultado = mysqli_query($conection, $result);
    }
}


var_dump($id_contrato);

$host = "localhost";
$user = "root";
$pass = "";
$banco = "gac";

$strcon = mysqli_connect($host, $user, $pass, $banco) or die('Não foi possivel conectar ao MySQL');



$an = date('Y');
//Verificar se está sendo passado na URL a página atual, senao é atribuido a pagina 
$pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;

//Selecionar todos os cursos da tabela
$result_curso = "SELECT * FROM documents_father  WHERE id_contrato = '$id_contrato'";
$resultado_curso = mysqli_query($strcon, $result_curso);

//Contar o total de cursos
$total_cursos = mysqli_num_rows($resultado_curso);

//Seta a quantidade de cursos por pagina
$quantidade_pg = 5;

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

<body style=" background-color: #cfcfcf; ">

    <div class="container-fluid" style="margin-top: 50px;">
        <div class="col-11" style="margin: auto;">
            <div class="row">
                <div class="col" style="border-style: solid;border-width: 1px;  border-color:#fff;padding: 30px;border-radius: 15px;">
                    <div class="row">
                        <div class="col-12" ><h3>CHECK LIST </h3></div>
                        <div class=" col-12  "  >
                            <form  class="needs-validation"  action="previ_lista.php?id=<?php echo $id_contrato; ?>" method="POST"novalidate>
                                <div class="row">

                                    <div class="form-group col-md-12">


                                        <button class="btn btn-outline-light btn-lg btn-block">GERAR LISTA</button>

                                    </div>


                                </div>
                            </form> 
                        </div>
                        <div class=" col-12 justify-content-center "  >
                            <form id='envia_msg' action='previ.php?<?php echo $id_contrato; ?>' method='POST' style="margin: auto;"> 
                                <?php
                                $sql1 = "SELECT * FROM documents_father WHERE id_contrato = $id_contrato  order by (categoria) limit $incio, $quantidade_pg";
                                $result1 = mysqli_query($conection, $sql1)or die('Não foi possivel conectar ao MySQL');
//$num = mysqli_num_rows($result1);
                                if (mysqli_num_rows($result1) == 0) {
                                    
                                } else {
                                    while ($registro1 = mysqli_fetch_array($result1)) {

                                        $periodo = $registro1['periodo'];
                                        $categoria = $registro1['categoria'];
                                        $id_doc_father = $registro1['id_doc_father'];



                                        echo" <h3>$categoria  $periodo </h3>";



                                        $sqcon = "SELECT * FROM documentos WHERE id_father = '$id_doc_father' order by (data_periodo)ASC";
                                        $resultado1 = mysqli_query($conection, $sqcon)or die('Não foi possivel conectar ao MySQL');
                                        if (mysqli_num_rows($resultado1) == 0) {
                                            
                                        } else {
                                            $i = 0;

                                            while ($registro1 = mysqli_fetch_array($resultado1)) {
                                                $status[$i] = $registro1 ['status'];
                                                $categoria[$i] = $registro1 ['categoria'];
                                                $id_doc[$i] = $registro1 ['id_doc'];

                                                if ($categoria[$i] == 1) {
                                                    $doc = 'Siscor com validação Técnica do relatório';
                                                } else if ($categoria[$i] == 2) {
                                                    $doc = 'Relatorio Enviado pelo fornrcedor';
                                                } else if ($categoria[$i] == 3) {
                                                    $doc = 'Termo de Recebimento Definitivo Validado';
                                                }
                                                ?>

                                               
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <input type='checkbox' aria-label="Checkbox for following text input"  name="status[]"   value="2,<?php echo $id_doc[$i] ?>"   <?php
                                                            if ($status[$i] == 2) {
                                                                echo "checked";
                                                            }
                                                            ?>> 
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Text input with checkbox" value="<?php echo $doc ?>">
                                                </div>



                                                <?php
                                                $i++;
                                            }
                                        }
                                    }
                                }
                                ?>
                                <input type="hidden" name="id" value="<?php echo $id_contrato ?>">
                                <button class="btn btn-outline-light" type="submit">ATUALIZAR</button>



                            </form>
                            <?php
//Verificar a pagina anterior e posterior
                            $pagina_anterior = $pagina - 1;
                            $pagina_posterior = $pagina + 1;
                            ?>   

                            <nav  class=" paggina fixed-bottom text-center">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item">
                                        <?php if ($pagina_anterior != 0) { ?>
                                            <a class="page-link" href="previ.php?pagina=<?php echo $pagina_anterior; ?>&id=<?php echo $id_contrato ?>" aria-label="Previous">
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
                                        <li class="page-item"><a class="page-link" href="previ.php?pagina=<?php echo $i; ?>&id=<?php echo $id_contrato ?>"><?php echo $i; ?></a></li>
                                    <?php } ?>
                                    <li class="page-item">
                                        <?php if ($pagina_posterior <= $num_pagina) { ?>
                                            <a  class="page-link" href="previ.php?pagina=<?php echo $pagina_posterior; ?>&id=<?php echo $id_contrato ?>" aria-label="Previous">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        <?php } else { ?>
                                            <span aria-hidden="true">&raquo;</span>
                                        <?php } ?>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <div col-2>
                    &nbsp
                    &nbsp
                    &nbsp
                </div>
                <div class="col" style="border-style: solid;border-width: 1px;  border-color:#fff;padding: 30px;border-radius: 15px;margin-left: 3opx;">
                    <form  class="needs-validation"  action="previ.php"method="post" novalidate>


                        <div class="row">
                            <div class="col-12" ><h3>INSERIR DOCUMENTO</h3></div>
                            <div class="col-md-8 mb-3">

                                <label for="cvig_contrat">Tipo  de Documento:</label>
                                <select class="form-control"  Type="text" name="tip_documento"  >

                                    <option selected></option>
                                    <option value= "1">1 - SISCOR INICIAL</option>	
                                    <option value= "2">2 - ANS</option>

                                </select>	
                            </div> 

                            <div class="form-group col-md-2" style="margin-top: 40PX;">
                                <button class="btn btn-outline-light" type="submit">INSERIR NA LISTA</button>
                            </div>
                        </div>

                    </form> 
                    <form  class="needs-validation"  action="previ.php"method="post" novalidate>
                        <div class="row">
                            <div class="col-12"><h3>PESQUISAR DOCUMENTO</h3></div>
                            <div class="col-md-8 mb-3">

                                <label for="cvig_contrat">Tipo de Documento:</label>
                                <select class="form-control"  Type="text" name="tip_documento"  >

                                    <option selected></option>
                                    <option value= "1">1 - SISCOR INICIAL</option>	
                                    <option value= "2">2 - ANS</option>

                                </select>	
                            </div> 
                            <div class="form-group col-md-2">
                                <label>Data:</label>
                                <input class="form-control" Type="text" name="qtd"  >
                            </div>
                            <div class="form-group col-md-2" style="margin-top: 40PX;">
                                <button class="btn btn-outline-light" type="submit">PESQUISAR</button>
                            </div>

                        </div>
                    </form> 

                </div>
            </div>



        </div>
    </div>
    <footer>
        <?php require_once 'foot.php'; ?>

    </footer>

</body>
</html>