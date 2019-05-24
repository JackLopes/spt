



                        <div class=" col-12 justify-content-center "  >
                            <form id='envia_msg' action='previ.php?<?php echo $id_contrato; ?>' method='POST' style="margin: auto;"> 
                                <?php
                                $sql1 = "SELECT * FROM  documentos WHERE categoria LIKE '%$categoria_pesquisa%' AND periodo='$periodo_pesquisa' AND id_contrato='$id_contrato' order by (categoria) limit $incio, $quantidade_pg";
    
                                $resultado1 = mysqli_query($conection, $sql1)or die('Não foi possivel conectar ao MySQL');
            if (mysqli_num_rows($resultado1) == 0) {
                
            } else {
                $i = 0;

          
                while ($registro1 = mysqli_fetch_array($resultado1)) {
                    $status[$i] = $registro1 ['status'];
                    $categoria[$i] = $registro1 ['categoria'];
                    $id_doc[$i] = $registro1 ['id_doc'];
                    $regional[$i] = $registro1 ['regional'];
                    $periodo[$i] = $registro1 ['periodo'];
                    
                    if(!empty( $regional[$i])){
                         $regional[$i] = "-" . $regional[$i];
                    }



                    if ($status[$i] == '1') {
                        $checkd = "<font style='color:red ;'><i class='fas fa-times-circle'></i></font>";
                    } else {
                        $checkd = "<font style='color:green;'><i class='fas fa-check-circle'></i></font>";
                    }

            
                    
                    
                    
                    
                    ?>
                    <div  style="border-style: solid;border-width: 1px;  border-color:#fff;padding: 15px;border-radius: 15px; background-color: #DDDDDD;">

                        <div class="row">

                            <div class="form-group col-md-1 text-center"style=" margin-top: 30px;" >
                                <span style=" font-size: 36px;" > <?php echo $checkd ?></span>

                            </div>   
                              <div class="form-group col-md-1">
                                <label >Periodo</label>
                                <input class="form-control" Type="text" name="periodo" value="<?php echo $periodo[$i]?>" disabled>
                            </div> 
                            <div class="form-group col-md-4">
                                <label>Tipo de Documento</label>
                                <input  type="text" style="font-size: 17px; font-weight: bold; color: blue;" class=" form-control" name="prazo"disabled value="<?php echo $categoria[$i] . $regional[$i]?>"disabled>
                            </div>                                        
                            <div class="form-group col-md-4">
                                <label >Link</label>
                                <input class="form-control" Type="url" name="responsavel,<?php echo $id_doc[$i] ?>[] "disabled>
                            </div> 


                            <button  style=" border-radius: 10px;width:120px; height: 30px;margin-left: 10px;margin-top: 45px;"  class=" btn-sm btn btn-outline-primary"  data-toggle="modal" href="#" data-target=".bd-example-modal-lg3<?php echo $id_doc[$i] ?>">Atualizar</button>  
                            <button style=" border-radius: 10px;width:120px; height: 30px;margin-left: 10px;margin-top: 45px;"  class=" btn-sm btn btn-outline-primary"  data-toggle="modal" href="#" data-target="#exampleModal<?php echo $id_doc ?>">Deletar</button>  

                            <div class="form-group col-md-2">
                                <label>Cláusula Contratual</label>
                                <input class="form-control" Type="text" name="prazo"disabled>
                            </div>                                        
                            <div class="form-group col-md-4">
                                <label >Responsabilidade:</label>
                                <input class="form-control" Type="text" name="responsavel,<?php echo $id_doc[$i] ?>[] "disabled>
                            </div>    
                            <div class="form-group col-md-2">
                                <label>Prazo Contratual</label>
                                <input class="form-control" Type="Date" name="prazo,<?php echo $id_doc[$i] ?>[] "disabled>
                            </div>                                       




                            <div class="form-group col-md-2">
                                <label >Data Prevista:</label>
                                <input class="form-control" Type="date" name="responsavel,<?php echo $id_doc[$i] ?>[] "disabled>
                            </div>                                        
                            <div class="form-group col-md-2">
                                <label >Data Executada:</label>
                                <input class="form-control" Type="date" name="responsavel,<?php echo $id_doc[$i] ?>[] "disabled>
                            </div>                                        
                        </div>   
                        <div class="row">

                            <div class="form-group col-md-12">

                                <label for="exampleFormControlTextarea1">Observação:</label>
                                <textarea class="form-control"  name="situacao" id="exampleFormControlTextarea1" rows="1"disabled><?php echo $registro['situacao']; ?></textarea>
                            </div>

                        </div>
                    </div>
                    <div class="modal fade" id="exampleModal<?php echo $id_doc[$i] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Deseja Realmente Deletar <p><?php echo $doc; ?></p></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <ul class="nav justify-content-center">     

                                        <li class="nav-item">
                                            <a   class="btn btn-danger" href=delete.php?acao=apagar&id=<?php echo $id_doc_father ?>>Sim</a>
                                        </li>
                                        <li style="margin-left:30px" class="nav-item">

                                            <a style=" color: #FFFFFF" class="btn btn-success"  data-dismiss="modal">Nao</a>
                                        </li>
                                    </ul>
                                </div>                             
                            </div>
                        </div>
                    </div>
                    <div class="modal fade bd-example-modal-lg3<?php echo $id_doc[$i] ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                                        <form id='envia_msg' action='previ.php?id=<?php echo $id_contrato; ?>' method='POST' style="margin: auto;">
                                            <div class="row">
                                                <div class="col-12" ></div>
                                                <div class="col-md-12 mb-3">

                                                    <label for="cvig_contrat">Tipo  de Documento:</label>
                                                    <input style=" color: blue; font-weight: bold;" class="form-control" Type="text" name="" value="<?php echo $doc; ?> ">
                                                </div> 

                                            </div>

                                            <div class="row">


                                                <div class="form-group col-md-4">
                                                    <label>Mês de Referência</label>
                                                    <input class="form-control" Type="date" name="prazo,<?php echo $id_doc[$i] ?>[] ">
                                                </div>                                        

                                                <div class="form-group col-md-4">
                                                    <label>Cláusula Contratual</label>
                                                    <input class="form-control" Type="text" name="prazo,<?php echo $id_doc[$i] ?>[] ">
                                                </div>                                        
                                                <div class="form-group col-md-4">
                                                    <label >Responsabilidade:</label>
                                                    <input class="form-control" Type="text" name="responsavel,<?php echo $id_doc[$i] ?>[] ">
                                                </div>    

                                            </div>   
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label>Prazo Contratual</label>
                                                    <input class="form-control border-bottom" Type="Date" name="prazo,<?php echo $id_doc[$i] ?>[] ">
                                                </div>              
                                                <div class="form-group col-md-4">
                                                    <label >Data Prevista:</label>
                                                    <input class="form-control" Type="date" name="responsavel,<?php echo $id_doc[$i] ?>[] ">
                                                </div>                                        
                                                <div class="form-group col-md-4">
                                                    <label >Data Executada:</label>
                                                    <input class="form-control" Type="date" name="responsavel,<?php echo $id_doc[$i] ?>[] ">
                                                </div>                                        


                                                <div class="form-group col-md-12">

                                                    <label for="exampleFormControlTextarea1">Observação:</label>
                                                    <textarea class="form-control"  name="situacao" id="exampleFormControlTextarea1" rows="5"> <?php echo $registro['situacao']; ?></textarea>
                                                </div>
                                            </div>
                                    </div>

                                    <input type="hidden" name="id" value="<?php echo $id_contrato ?>">

                                    <div class="modal-footer">

                                        <button type="submit" class="btn btn-primary">Atualizar</button>
                                    </div>

                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>

                    &nbsp
                    <?php
                    $i++;
                }
            }
        
    
    ?>















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
