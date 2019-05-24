<?php
$page_title = "Check- List";
require_once 'menu.php';
require_once 'database_gac.php';


if (!empty(filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT))) {

    $id_contrato = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
} else {

    $id_contrato = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
}

  $categoria_pesquisa = filter_input(INPUT_POST, 'categoria_pesquisa', FILTER_SANITIZE_STRING);
  $periodo_pesquisa = filter_input(INPUT_POST, 'periodo_pesquisa', FILTER_SANITIZE_STRING);




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
$result_curso = "SELECT * FROM documents_father  WHERE id_contrato = '$id_contrato'";
$resultado_curso = mysqli_query($strcon, $result_curso);

//Contar o total de cursos
$total_cursos = mysqli_num_rows($resultado_curso);

//Seta a quantidade de cursos por pagina
$quantidade_pg = 1;

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

    <div class="container-fluid" style="margin-top: 70px;">
        <div class="col-11" style="margin: auto;">
            <div class="row">
                <div class="col" style="border-style: solid;border-width: 1px;  border-color:#fff;padding: 10px;border-radius: 15px;">
                    <div class="row">
                        <div class="col-12" ><h3>CHECK LIST </h3></div>
                        <?php// var_dump($dados);?>
                        <div class=" col-12  "  >
                            <form  class="needs-validation"  action="previ_lista.php?id=<?php echo $id_contrato; ?>" method="POST"novalidate>
                                <div class="row">

                                    <div class="form-group col-md-12">


                                        <button class="btn btn-outline-light btn-lg btn-block">GERAR LISTA</button>

                                    </div>


                                </div>
                            </form> 
                        </div>
           <?php
           if(!empty($periodo_pesquisa) AND !empty($categoria_pesquisa)){
                        include 'previ2.php';         
           } else 
               
           { include 'previ1.php'; }
           
           ?>
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
                                    <option value= "1">1 - DECLARAÇÃODE ACEITE DE CAPACITAÇÃO</option>	
                                    <option value= "2">2 - DOCUMENTO DO FORNECEDOR</option>
                                    <option value= "1">1 - GARANTIA DE EXECUÇÃO CONTRATUAL</option>	
                                    <option value= "2">2 - RESPOSTA A SOLICITAÇÃO INTERNA</option>
                                    <option value= "1">1 - RESPOSTA AO FORNECEDOR</option>	
                                    <option value= "2">2 - SOLICITAÇÃO DO FORNECEDOR</option>
                                    <option value= "1">1 - RESPOSTA AO FORNECEDOR</option>	
                                    <option value= "2">2 - SOLICITAÇÃO INTERNA</option>
                                    <option value= "2">2 - TERMO DE APOSTILAMENTO</option>
                                    <option value= "2">2 - TERMO DE RECEBIMENTO DEFINITIVO</option>
                                    <option value= "2">2 - TERMO DE RECEBIMENTO PROVISÓRIO</option>

                                </select>	
                            </div> 

                            <div class="form-group col-md-2" style="margin-top: 40PX;">
                                <button class="btn btn-outline-light" type="submit">INSERIR NA LISTA</button>
                            </div>
                        </div>

                    </form> 
                    <form  class="needs-validation" action='previ.php?id=<?php echo $id_contrato; ?>' method="post" novalidate>
                        <div class="row">
                            <div class="col-12"><h3>PESQUISAR DOCUMENTO</h3></div>
                            <div class="col-md-8 mb-3">

                                <label for="cvig_contrat">Tipo de Documento:</label>
                                <select class="form-control"  Type="text" name="categoria_pesquisa"  >

                                    <option selected></option>
                                    <option value= "ANS">1 - ANS</option>	
                                    <option value= "ATA">2 - ATA</option>
                                    <option value= "TRD">2 - TRD</option>

                                </select>	
                            </div> 
                           
                            <div class="form-group col-md-2">
                                <label>Periodo:</label>
                                <input class="form-control" Type="text" name="periodo_pesquisa"  >
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