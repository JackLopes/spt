



<div class=" col-12 justify-content-center "  >
    <form id='envia_msg' action='previ.php?id=<?php echo $id_contrato; ?>' method='POST' style="margin: auto;"> 
        <?php
        $sql1 = "SELECT * FROM documents_father WHERE id_contrato = $id_contrato  order by (ordem) limit $incio, $quantidade_pg";
        $result1 = mysqli_query($conection, $sql1)or die('Não foi possivel conectar ao MySQL');
//$num = mysqli_num_rows($result1);
        if (mysqli_num_rows($result1) == 0) {
            
        } else {
            while ($registro1 = mysqli_fetch_array($result1)) {

                $periodo = $registro1['periodo'];
                $categoria = $registro1['categoria'];
                $id_doc_father = $registro1['id_doc_father'];
                ?>
                <div class="col-12 row">
                    <div class= col-10 text-left>
                        <h3><?php echo $categoria . " " . $periodo; ?></h3>
                    </div>

                    <div class="col-2 text-right" >   
                        <button class="btn btn-danger" data-toggle="modal" href="#" data-target="#exampleModal<?php echo $id_doc_father?>">Delet</button>                                               
                    </div>

                </div>
          <!-- Modal Exclusao -->
                        

                <?php
                $sqcon = "SELECT * FROM documentos WHERE id_father = '$id_doc_father'order by (data_periodo)ASC ";
                $resultado1 = mysqli_query($conection, $sqcon)or die('Não foi possivel conectar ao MySQL');
                if (mysqli_num_rows($resultado1) == 0) {
                    
                } else {
                    $i = 0;



                    while ($registro1 = mysqli_fetch_array($resultado1)) {
                        $status[$i] = $registro1 ['status'];
                        $categoria[$i] = $registro1 ['categoria'];
                        $id_doc[$i] = $registro1 ['id_doc'];

                        if ($categoria[$i] == 1) {
                            $doc = 'SISCOR COM VALIDAÇÃO TECNICA';
                        } else if ($categoria[$i] == 2) {
                            $doc = 'RELATÓRIO TECNICO';
                        } else if ($categoria[$i] == 3) {
                            $doc = 'TERMO DE RECEBIMENTO DEFINITIVO';
                        } else if ($categoria[$i] == 4) {
                            $doc = 'ATA DE REUNIÃO';
                        } else if ($categoria[$i] == 5) {
                            $doc = 'SISCOR DE INICIAÇÃO DO CONTRATO';
                        }
                        ?>
                        <div  style="border-style: solid;border-width: 1px;  border-color:#fff;padding: 15px;border-radius: 15px; background-color: #DDDDDD;">

                            <div class="row">
                                <div class="input-group col-md-6 mb-3">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input type='checkbox' aria-label="Checkbox for following text input"  name="status[]"   value="2,<?php echo $id_doc[$i] ?>"   <?php
                if ($status[$i] == 2) {
                    echo "checked";
                }
                ?>> 
                                        </div>
                                    </div>
                                    <input type="text" style="font-size: 18px; font-weight: bold; color: blue;" class=" form-control" aria-label="Text input with checkbox" value="<?php echo $doc ?>">
                                </div>

                                <div class="form-group col-md-2">
                                    <label>Cláusula Contratual</label>
                                    <input class="form-control" Type="text" name="prazo,<?php echo $id_doc[$i] ?>[] ">
                                </div>                                        
                                <div class="form-group col-md-2">
                                    <label >Responsabilidade:</label>
                                    <input class="form-control" Type="text" name="responsavel,<?php echo $id_doc[$i] ?>[] ">
                                </div>    
                                <div class="form-group col-md-2">
                                    <label>Prazo Contratual</label>
                                    <input class="form-control" Type="Date" name="prazo,<?php echo $id_doc[$i] ?>[] ">
                                </div>                                       
                            </div>   
                            <div class="row">



                                <div class="form-group col-md-2">
                                    <label >Data Prevista:</label>
                                    <input class="form-control" Type="date" name="responsavel,<?php echo $id_doc[$i] ?>[] ">
                                </div>                                        
                                <div class="form-group col-md-2">
                                    <label >Data Executada:</label>
                                    <input class="form-control" Type="date" name="responsavel,<?php echo $id_doc[$i] ?>[] ">
                                </div>                                        


                                <div class="form-group col-md-8">

                                    <label for="exampleFormControlTextarea1">Observação:</label>
                                    <textarea class="form-control"  name="situacao" id="exampleFormControlTextarea1" rows="1"> <?php echo $registro['situacao']; ?></textarea>
                                </div>
                            </div>
                        </div>
                      
                            &nbsp
                <?php
                $i++;
            }
        }
    }
}
?>
                            
            <input type="hidden" name="id" value="<?php echo $id_contrato ?>">
            <button  style="margin-top: 5px;" class="btn btn-outline-light btn-lg btn-block" type="submit">ATUALIZAR</button>



    </form>
    

    
    
    
    
    
    
    
    
    
            <?php
//Verificar a pagina anterior e posterior
            $pagina_anterior = $pagina - 1;
            $pagina_posterior = $pagina + 1;
            ?>   

    <nav  class=" paggina fixed-bottom text-center">
        <ul class="pagination  pagination-sm justify-content-center">
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
