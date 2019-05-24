



<div class=" col-12 justify-content-center "  >

    <div class="col-12 row" >
        <?php
        $sql1 = "SELECT * FROM documentos WHERE id_contrato = $id_contrato  order by (categoria)ASC  limit $incio, $quantidade_pg";
        $resultado1 = mysqli_query($conection, $sql1)or die('Não foi possivel conectar ao MySQL');
        if (mysqli_num_rows($resultado1) == 0) {
            
        } else {
            $i = 0;

            while ($registro1 = mysqli_fetch_array($resultado1)) {
              
                $link[$i] = $registro1 ['link'];
                $categoria[$i] = $registro1 ['categoria'];
                $clausula[$i] = $registro1 ['clausula'];
                $responsa[$i] = $registro1 ['responsa'];
                $prazo[$i] = $registro1 ['prazo'];
                $prevista[$i] = $registro1 ['prevista'];
                $executada[$i] = $registro1 ['executada'];
                $observacao[$i] = $registro1 ['observacao'];
                $status[$i] = $registro1 ['status'];
                $id_doc[$i] = $registro1 ['id_doc'];
                $periodo[$i] = $registro1 ['periodo'];
                $regional[$i] = $registro1 ['regional'];

                if ($status[$i] == '2') {
                    $checkd = "<font style='color:green;'><i class='fas fa-check-circle'></i></font>";
                } else {
                    $checkd = "<font style='color:red ;'><i class='fas fa-times-circle'></i></font>";
                }
                ?>
                <div  style="border-style: solid;border-width: 1px;  border-color:#fff;padding: 15px;border-radius: 15px; background-color: #DDDDDD;">

                    <div class="row">

                        <div class="form-group col-md-1 text-center"style=" margin-top: 30px;" >
                            <span style=" font-size: 36px;" > <?php echo $checkd ?></span>

                        </div>   
                        <div class="form-group col-md-1">
                            <label >Periodo</label>
                            <input class="form-control" Type="text" name="periodo" value="<?php echo $periodo[$i] ?>" disabled>
                        </div> 
                        <div class="form-group col-md-4">
                            <label>Tipo de Documento</label>
                            <input  type="text" style="font-size: 17px; font-weight: bold; color: blue;" class=" form-control" name="categoria"disabled value="<?php echo $categoria[$i] ?>"disabled>
                        </div>                                        
                        <div class="form-group col-md-1">
                            <label >Regional</label>
                            <input class="form-control" Type="tex" name="regional" value="<?php echo $regional[$i] ?>"  autocomplete="off" disabled>
                        </div> 
                        <div class="form-group col-md-3" style="margin-top: 39px;"> 
                            <label >Link</label>
                            <?php if (!empty($link[$i])) { ?>


                                <a class="btn btn-outline-success"  style="border-radius: 10px;height: 40px;margin-left: 15px;"   href="<?php echo $link[$i] ?>"target="blank"  ><?php echo $link[$i] ?></a>   

                            <?php } else { ?>

                                <a class="btn btn-outline-danger"   style="border-radius: 10px;height: 40px;margin-left: 15px;"   href="#"  > Aguardando Autuação no Processo</a>   

                            <?php } ?>
                        </div> 


                        <button  style=" border-radius: 10px;width:120px; height: 35px;margin-left: 10px;margin-top: 45px;"  class=" btn-sm btn btn-outline-primary"  data-toggle="modal" href="#" data-target=".bd-example-modal-lg3<?php echo $id_doc[$i] ?>">Atualizar</button>  
                        <button style=" border-radius: 10px;width:120px; height: 35px;margin-left: 10px;margin-top: 45px;"  class=" btn-sm btn btn-outline-primary"  data-toggl0e="modal" href="#" data-target="#exampleModal<?php echo $id_doc ?>">Deletar</button>  

                        <div class="form-group col-md-2">
                            <label>Cláusula Contratual</label>
                            <input class="form-control" Type="text" name="clausula" value="<?php echo $clausula[$i] ?>" disabled>
                        </div>                                        
                        <div class="form-group col-md-4">
                            <label >Responsabilidade:</label>
                            <input class="form-control" Type="text" name="responsa " value="<?php echo $responsa[$i] ?>" disabled>
                        </div>    
                        <div class="form-group col-md-2">
                            <label>Prazo Contratual</label>
                            <input class="form-control" Type="Date" name="prazo"value="<?php echo $prazo[$i] ?>" disabled>
                        </div>                                       




                        <div class="form-group col-md-2">
                            <label >Data Prevista:</label>
                            <input class="form-control" Type="date" name="prevista"value="<?php echo $prevista[$i] ?>" disabled>
                        </div>                                        
                        <div class="form-group col-md-2">
                            <label >Data Executada:</label>
                            <input class="form-control" Type="date" name="executada"value="<?php echo $executada[$i] ?>" disabled>
                        </div>                                        
                    </div>   
                    <div class="row">

                        <div class="form-group col-md-12">

                            <label for="exampleFormControlTextarea1">Observação:</label>
                            <textarea class="form-control"  name="observacao" id="exampleFormControlTextarea1" rows="1"disabled><?php echo $observacao[$i]; ?></textarea>
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
                                <h5 class="modal-title"><h3>ATUALIZAR TIPO</h3></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" >

                                <div  style="border-style: solid;border-width: 1px;  border-color:#fff;padding: 15px;border-radius: 15px; background-color: #DDDDDD;">
                                    <form id='envia_msg' action='cad_documentos.php?action=update' method='POST' style="margin: auto;">
                                        <div class="row">
                                            <div class="col-12" ></div>
                                            <div class="col-md-9 mb-3">

                                                <label for="cvig_contrat">Tipo  de Documento:</label>
                                                <input style=" color: blue; font-weight: bold;" class="form-control" Type="text" name="categoria" value="<?php echo $categoria[$i]; ?> ">
                                            </div> 
                                            <div class="form-group col-md-3">
                                                <label >Regional</label>
                                                <input class="form-control" Type="tex" name="regional"  autocomplete="off" value="<?php echo $regional[$i] ?>" >
                                            </div> 

                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label >Link</label>
                                                <input class="form-control" Type="url" name="link" value="<?php echo $link[$i] ?>" >
                                            </div> 
                                        </div>

                                        <div class="row">


                                            <div class="form-group col-md-4">
                                                <label >Periodo</label>
                                                <input class="form-control" Type="text" name="periodo" value="<?php echo $periodo[$i] ?>">
                                            </div>                                        

                                            <div class="form-group col-md-4">
                                                <label>Cláusula Contratual</label>
                                                <input class="form-control" Type="text" name="clausula" value="<?php echo $clausula[$i] ?>">
                                            </div>                                        
                                            <div class="form-group col-md-4">
                                                <label >Responsabilidade:</label>
                                               
                                                <select class="form-control"  Type="text" name="responsa"  >

                                                    <option selected><?php echo $responsa[$i] ?></option>
                                                    <option value= "SERPRO"> SERPRO</option>
                                                    <option value= "CONTRATADA"> CONTRATADA</option> 


                                                </select>
                                            </div>    

                                        </div>   
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label>Prazo Contratual</label>
                                                <input class="form-control" Type="Date" name="prazo"value="<?php echo $prazo[$i] ?>" >
                                            </div>              
                                            <div class="form-group col-md-4">
                                                <label >Data Prevista:</label>
                                                <input class="form-control" Type="date" name="prevista"value="<?php echo $prevista[$i] ?>" >
                                            </div>                                        
                                            <div class="form-group col-md-4">
                                                <label >Data Executada:</label>
                                                <input class="form-control" Type="date" name="executada"value="<?php echo $executada[$i] ?>" >
                                            </div>                                        


                                            <div class="form-group col-md-12">

                                                <label for="exampleFormControlTextarea1">Observação:</label>
                                                <textarea class="form-control"  name="observacao" id="exampleFormControlTextarea1" rows="8"><?php echo $observacao[$i]; ?></textarea>
                                            </div>
                                        </div>
                                </div>

                                <input type="hidden" name="id_contrato" value="<?php echo $id_contrato ?>">
                                <input type="hidden" name="id_doc" value="<?php echo $id_doc[$i] ?>">

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
