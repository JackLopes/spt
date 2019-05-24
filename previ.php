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




$host = "localhost";
$user = "root";
$pass = "";
$banco = "gac";

$strcon = mysqli_connect($host, $user, $pass, $banco) or die('Não foi possivel conectar ao MySQL');
$an = date('Y');
//Verificar se está sendo passado na URL a página atual, senao é atribuido a pagina 
$pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;

//Selecionar todos os cursos da tabela
$result_curso = "SELECT * FROM documentos WHERE id_contrato = '$id_contrato'";
$resultado_curso = mysqli_query($strcon, $result_curso);

//Contar o total de cursos
$total_cursos = mysqli_num_rows($resultado_curso);

//Seta a quantidade de cursos por pagina
$quantidade_pg = 20;

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
            <div class="row mb-3">
                <div class="col" style="border-style: solid;border-width: 1px;  border-color:#fff;padding: 10px;border-radius: 15px;">
                    <div class="row">  
                        <div class="col">
                            <div class="col-12" ><h3>INSERIR ITEM</h3></div>

                            <button style="margin-top: 50px;"class="btn btn-light lg btn-block"   data-toggle="modal" data-target=".bd-example-modal-lg">INSERIR NA LISTA</button>
                        </div>

                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" >
                                    <div class="modal-header">
                                        <h5 class="modal-title"><h3>INSERIR ITEM</h3></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" >

                                        <div  style="border-style: solid;border-width: 1px;  border-color:#fff;padding: 15px;border-radius: 15px; background-color: #DDDDDD;">
                                            <form id='envia_msg' action='cad_documentos.php?action=salva' method='POST' style="margin: auto;">
                                                <div class="row">
                                                    <div class="col-12" ></div>
                                                    <div class="col-md-9 mb-3">

                                                        <label for="cvig_contrat">Tipo  de Documento:</label>
                                                        <select  class=" custom-select" name="categoria"   >
                                                            <option></option>  
                                                            <?php
                                                           
                                                           $q1 = "SELECT nome  FROM tipos_documentos";
                                                            $r1 = mysqli_query($conection, $q1);
                                                            while ($row = mysqli_fetch_assoc($r1)) {
                                                            

                                                                $nome = $row['nome'];
                                                                ?>
                                                            <option value="<?php echo $nome ?>"><?php echo $nome ?></option>  		
                                                            <?php } ?>
                                                        </select>
                                                    </div> 
                                                    <div class="col-md-3 mb-3">

                                                        <label for="cvig_contrat">Autuado:</label>
                                                        <select class="form-control"  Type="text" name="status"  >

                                                            <option selected></option>
                                                            <option value= "2"> Sim</option>
                                                            <option value= "1"> Não</option> 


                                                        </select>	
                                                    </div> 


                                                </div>




                                                <div class="row">


                                                    <div class="form-group col-md-4">
                                                        <label>Mês de Referência</label>
                                                        <input class="form-control" Type="date" name="periodo">
                                                    </div>                                        

                                                    <div class="form-group col-md-4">
                                                        <label>Cláusula Contratual</label>
                                                        <input class="form-control" Type="text" name="clausula">
                                                    </div>                                        
                                                    <div class="form-group col-md-4">
                                                        <label >Responsabilidade:</label>
                                                        <input class="form-control" Type="text" name="responsa">
                                                    </div>    

                                                </div>   
                                                <div class="row">
                                                    <div class="form-group col-md-4">
                                                        <label>Prazo Contratual</label>
                                                        <input class="form-control border-bottom" Type="Date" name="prazo">
                                                    </div>              
                                                    <div class="form-group col-md-4">
                                                        <label >Data Prevista:</label>
                                                        <input class="form-control" Type="date" name="prevista">
                                                    </div>                                        
                                                    <div class="form-group col-md-4">
                                                        <label >Data Executada:</label>
                                                        <input class="form-control" Type="date" name="executada">
                                                    </div>                                        


                                                    <div class="form-group col-md-12">

                                                        <label for="exampleFormControlTextarea1">Observação:</label>
                                                        <textarea class="form-control"  name="observacao" id="exampleFormControlTextarea1" rows="5"> <?php echo $registro['situacao']; ?></textarea>
                                                    </div>
                                                    <div class="form-group col-md-12">

                                                        <label for="exampleFormControlTextarea1">Link:</label>
                                                        <input class="form-control" Type="url" name="link">
                                                    </div>
                                                </div>
                                        </div>

                                        <input type="hidden" name="id_contrato" value="<?php echo $id_contrato ?>">

                                        <div class="modal-footer">

                                            <button type="submit" class="btn btn-primary">Salvar</button>
                                        </div>

                                        </form>

                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <form  class="needs-validation" action='previ.php?id=<?php echo $id_contrato; ?>' method="post" novalidate>
                                <div class="row">
                                    <div class="col-12"><h3>PESQUISAR DOCUMENTO</h3></div>
                                    <div class="col-md-8 mb-3">

                                        <label for="cvig_contrat">Tipo de Documento:</label>
                                        <select class="form-control"  Type="text" name="categoria_pesquisa"  >
                                            <option selected></option>                                        
                                            <option value= "1"> 01 - </option> 
                                            <option value= "2"> 02 - </option>
                                            <option value= "3"> 03 - GARANTIA DE EXECUÇÃO CONTRATUAL</option>	
                                            <option value= "4"> 04 - </option>
                                            <option value= "5"> 05 - </option>
                                            <option value= "6"> 06 - </option> 
                                            <option value= "7"> 07 - </option> 
                                            <option value= "8"> 08 - </option> 
                                            <option value= "9"> 09 - DECLARAÇÃODE ACEITE DE CAPACITAÇÃO</option>
                                            <option value= "10"> 10  - </option>
                                            <option value= "11"> 11 - </option>       
                                            <option value= "12"> 12 - </option>                                  
                                            <option value= "13"> 13  - DOCUMENTO DO FORNECEDOR</option>
                                            <option value= "14">14 - SOLICITAÇÃO DO FORNECEDOR</option>
                                            <option value= "15">15 - SOLICITAÇÃO INTERNA</option>
                                            <option value= "16">16 - RESPOSTA A SOLICITAÇÃO INTERNA</option>
                                            <option value= "17">17 - RESPOSTA AO FORNECEDOR</option>	
                                            <option value= "18">18 - TERMO DE APOSTILAMENTO</option>
                                            <option value= "19">19 - </option> 
                                            <option value= "20">20 - REGISTRO DE LIÇÕES APRENDIDAS</option>    
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
            <?php
            if (isset($_SESSION['msg40'])) {
                echo "<span style='margin-top: 20px;'>" .$_SESSION['msg40'] . "</span>";
                unset($_SESSION['msg40']);
            }
            ?>

            <div class="row">
                <div class="col" style="border-style: solid;border-width: 1px;  border-color:#fff;padding: 10px;border-radius: 15px;margin-top: 10px;">
                    <div class="row">
                        <div class="col-12" ><h3>CHECK LIST </h3></div>
                        <?php // var_dump($dados); ?>
                        <div class=" col-12  "  >
                            <form  class="needs-validation"  action="previ_lista.php?id=<?php echo $id_contrato; ?>" method="POST"novalidate>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <button style="font-size: 12px;"class="btn btn-light btn-lg btn-block">GERAR LISTA</button>
                                    </div>
                                </div>
                            </form> 
                        </div>
                        <?php
                        if (!empty($periodo_pesquisa) AND ! empty($categoria_pesquisa)) {
                            include 'previ2.php';
                        } else if (empty($periodo_pesquisa) AND ! empty($categoria_pesquisa)) {
                            include 'previ3.php';
                        } else {
                            include 'previ1.php';
                        }
                        ?>
                    </div>
                </div>
            </div>





        </div>




    </div>
    <footer>
        <?php require_once 'foot.php'; ?>

    </footer>

</body>
</html>