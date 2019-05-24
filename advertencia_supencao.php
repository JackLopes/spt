

<?php
include 'menu.php';
require_once ('./inc/Config.inc.php');
require_once './Funcoes/func_data.php';
require 'database_gac.php';
$assunt = "Incidências de Advertência ou Suspenção";
$permissa = $_SESSION['permissao'];

$id_contrato = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$sql = "SELECT percent_atrasoEntrega, percent_naoObjeto, percent_descumprimento, rg ,id_prestador FROM contrato WHERE  id_contrato = '$id_contrato' ";
$resultado = mysqli_query($conection, $sql)or die('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado)) {

    $percent_atrasoEntrega = $registro['percent_atrasoEntrega'];
    $percent_naoObjeto = $registro['percent_naoObjeto'];
    $percent_descumprimento = $registro['percent_descumprimento'];
    $rg = $registro['rg'];
    $id_prestador = $registro['id_prestador'];
}
?>
<!doctype html>
<html lang="pt">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet"  type="text/css" href="css/stylpainelMulta.css" media="screen"/>	
        <link rel="stylesheet" href="css/bootstrap.css" >

        <style>
                      .Assunt{
                position:absolute;
                margin-top: -130px;
                margin-left: 50px;
                color:white;
                font-size: 200%;

            }
            .format{color: black;
                    margin-left:10px;

            }
            .btns{
                margin-top: 30px;
            }
            .nav a {

                margin-left: 10px;

            }
            .nav  {

                margin-left: -25px;
                margin-bottom: 10px;
            }
            .coment{
                background-color: #6c757d;
                margin-top: 20px;
                color: white;
                padding-left: 5px; 
                padding: 3px;
            }
            #envi{
                margin-top: 30px;
            }
            .tb2{
                margin-top: -16px;
            }

            #forms{
                background-color:#e9ecef; 
                padding: 10px;
                padding-bottom: 30px;
                color:  #6c757d;
                margin-top: -15px;

            }
            #forms input{
                background-color: #f8f9fa; 

            }
        </style>

    </head>
    <body>
        <?php require_once 'image_header6.php'; ?>
        <div  class=" container-fluid    "  >
            <div style="margin: auto" class="col-md-10 mb-10"> 
                 <nav  style=" margin-top: 30px;" class="navbar navbar-light">                 
                  

                    <a class="btn btn-primary" href="painelMultas.php?id=<?php echo $id_contrato ?>">RETORNAR</a>
              
                </nav>
                <div   class="modal-body">
                      <p class="coment">OCORRÊNCIAS PASSIVEIS DE MULTAS</p>
                    <form  class=" updates needs-validation " id="forms" action="atu_confirma_multa.php?action=inclusaoAdvertencia"   method="post" novalidate>         

                        <div class="form-row">	
                            <div class="form-group col-md-4">

                                <label class="mods1" for="ccategoria" >TIPO DE INFRAÇÃO</label>
                                <select class="custom-select  "name="categoria" id="ctipo_infracao"  >
                                    <option selected></option>
                                    <option value="3">ADVERTÊNCIA</option>
                                    <option value="4">SUSPENSÃO</option>                                                           
                                </select>
                            </div>
                        
                        
                            <div class="form-group col-md-4">
                                <label for="csiscor">SISCOR:</label>

                                <input type="text" class="form-control "  name="siscor"  >
                            </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                <label for="cobservacao">RESUMO DA OCORRÊNCIA:</label>
                              
                                  
                                    <textarea class="form-control "  id="exampleFormControlTextarea1"  name="observacao" rows="8"></textarea>
                                </div>
                                
                                
                            </div>
                            <div class="row" style="margin-top:10px;" >
                                <div class="col-md-12 mb-10">                         

                                    <label for="creferencia">Contatos:</label><hr  style=" margin-top: -10px">  
                                    <p style=" font-size: 13px;">Pressione Ctrl para selecionar mais de uma opção*</p>
                                    <input type="hidden" name="id_colaborado" />
                                    <select class="slMultiple custom-select" multiple="multiple" name="id_colaborado[]" >
                                        <?php
                                        $sqlcolaborador = "SELECT * FROM colaborador WHERE id_presta='$id_prestador'";
                                        $resultado = mysqli_query($conection, $sqlcolaborador)or die('Não foi possivel conectar ao MySQL');
                                        while ($registro = mysqli_fetch_assoc($resultado)) {

                                            $id_colaborado = $registro['id_colaborador'];
                                            $nome = $registro['nome'];
                                            ?>
                                            <option  value="<?php echo $id_colaborado; ?>"><?php echo $nome; ?></option>  		
                                        <?php } ?>
                                    </select>  

                                </div>

                               

                            </div>
                            

                       
                      <div class="row" style="margin-top:10px;" >
                            <input name="id_contrato" type="hidden" value=<?php echo $id_contrato; ?>>

                            <button style=" margin-left: 17px;" type="submit" name="Prosseguir"  class="btn btn-primary">CADASTRAR</button>
                        </div>
                    </form>
                </div>
           
                     <div class="col-md-12 mb-10"   style="  width:100%; margin-top: 50px;   ">
                           <?php
                    if
                    (isset($_SESSION['msg23'])) {
                        echo $_SESSION['msg23'];
                        unset($_SESSION['msg23']);
                    }
                    ?>
                     <p class="coment" >HISTÓRICO DE LANÇAMENTOS</p>
                        <table  class=" tb2 table table-hover table-striped table-sm table-bordered bg-light"   >
                            <thead class="thead-dark ">
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Tipo de infração</th>
                                    <th scope="col">SISCOR</th>
                                    <th scope="col">Resumo</th>
                                    <th scope="col">Status</th>                                   
                                    <th scope="col">Atualizar</th>
                                    <th scope="col">Excluir</th>



                                    <?php
                                    $sql20 = "SELECT *  FROM historico_multa WHERE id_contrato = '$id_contrato'AND categoria='3'OR categoria='4'  ";
                                    $result = mysqli_query($conection, $sql20)or die('Não foi possivel conectar ao MySQL');
                                    while ($registro1 = mysqli_fetch_array($result)) {



                                        $id_histmulta = $registro1['id_histmulta'];
                                        $categoria = $registro1['categoria'];
                                        $siscor = $registro1['siscor'];
                                        $observacao = $registro1['observacao'];
                                        $status = $registro1['status'];
                                     

                                        switch ($categoria) {
                                            case 3:
                                                $categoria = "Advertência";
                                                break;
                                            case 4:
                                                $categoria = "Suspenção";
                                                break;
                                         
                                        }

                                        if (!empty($observacao)) {
                                            $observacao = 'Detalhes';
                                        }

                                     
                                        ?>
                                    <tr>
                                        
                                        <td ><a  href="multaAdverSuspe.php?id=<?php echo $id_contrato ?>&id_histmulta=<?php echo $id_histmulta ?>"><center><i class="far fa-file"></i></center></a></td>
                                        <td><?php echo $categoria ?></td> 
                                        <td><?php echo $siscor ?></td>
                                         <td><a  data-toggle="modal" href="#" data-target="#exampleModal1<?php echo $id_histmulta ?>" ><center><?php echo $observacao ?></center</a></td>
                                        <td><?php echo $status ?></td>
                                        
                                       


                                        <td><a id="a2" data-toggle="modal" href="#" data-target="#exampleModal<?php echo $id_histmulta ?>" ><i class="fas fa-eraser"></i></a></td>


                                        <td><a id="a2" href="atu_usuario.php?id_usuario=<?php echo $id_histmulta ?>"> <i class="far fa-edit"></i></a></td>
                                    </tr>
                                    <!-- Modal Exclusao -->
                                <div class="modal fade" id="exampleModal<?php echo $id_histmulta ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Deseja Realmente Deletar  </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p><?php echo $siscor ?></p>
                                                <ul class="nav justify-content-center">     

                                                    <li class="nav-item">
                                                        <a  class="btn btn-danger" href="<?php echo $registro1['id_histmulta'] ?>">Sim</a>
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
                    </div>
            
            
        </div>