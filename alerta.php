
<?php
$page_title = 'Resumo';
require_once 'menu.php';
require_once 'database_gac.php';
include 'Funcoes/func_data.php';
include './Funcoes/limpa_string.php';
$assunt = "<i class='fas fa-eye'></i> Alerta";

if (isset($_POST['submitted'])) {


    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $_SESSION['dadalert'] = $dados;
    $id_alerta = filter_input(INPUT_POST, 'id_alerta', FILTER_SANITIZE_NUMBER_INT);
    $id_contrato = filter_input(INPUT_POST, 'id_contrato', FILTER_SANITIZE_NUMBER_INT);
    $situacao = trim( filter_input(INPUT_POST, 'situacao', FILTER_SANITIZE_STRING)); 
    $siscor = trim(filter_input(INPUT_POST, 'siscor', FILTER_SANITIZE_STRING)); 
   

    $crip= md5(trim($situacao));
    
    if($situacao != null){

    $q = "UPDATE alerta SET  data= NOW(), situacao='$situacao', siscor='$siscor' WHERE id_alerta='$id_alerta' ";
    $r = mysqli_query($conection, $q);
    
    
        $q1 = "SELECT crip FROM historico_alerta WHERE id_alerta = '$id_alerta'  AND crip = '$crip'  ";
        $r = mysqli_query($conection, $q1);
        $num = mysqli_num_rows($r);
        
        var_dump($num);

        if ($num == 0) {

         
                    $q2 = "INSERT INTO  historico_alerta ( id_contrato,  informacao, id_alerta, crip ) VALUES "
                            . "('$id_contrato', '$situacao','$id_alerta', '$crip')";
                     $r2 = mysqli_query($conection, $q2);
        
        }
    }   

}
?>





        <?php require_once 'image_header6.php'; ?>
        <div  class=" container-fluid    "  style="margin-top: 30px">
    <div class="col-md-12 order-md-1">
            <table  class="table table-hover table-striped table-bordered bg-light"   >
                <thead class="thead-dark ">
                    <tr style="font-size:14px">
                        <th scope="col">Registro  Contrato</th>
                        <th scope="col">Tipo</th>
                        <th scope="col" >Objeto</th>
                        <th scope="col">GestorTécnico</th>
                        <th scope="col">Contratada</th>
                        <th scope="col">Encerramento Vigencia</th>
                        <th scope="col">Prazo Termino Vigencia</th>
                        <th scope="col">Encerramento Garantia</th>
                        <th scope="col">Prazo Termino Garantia</th>
                        <th scope="col">Situação da Tratativa</th>
                        <th scope="col">Siscor Cobrança</th>
                        <th scope="col">Ultima Atualização</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <?php
                $query = "SELECT cont.*,ale.data, resp.nome, ale.situacao, ale.siscor, ale.id_alerta, cont.d_fim_vige_cont
						       FROM contrato AS cont
							   INNER JOIN local AS loc ON  loc.id_contrato = cont.id_contrato
							   INNER JOIN responsaveis AS resp ON  resp.id_contrato = cont.id_contrato
							   INNER JOIN alerta  AS ale ON ale.id_contrato = cont.id_contrato
							   WHERE resp.responsabilidade = 'Gestor Tecnico' GROUP BY (id_contrato) HAVING MAX(data) ORDER BY (fim_vig_garat)  ASC";

                $resultado = mysqli_query($conection, $query)or die('Não foi possivel conectar ao MySQL');
                while ($registro = mysqli_fetch_array($resultado)) {

                    $rg = $registro ['rg'];
                    $id_contrato = $registro ['id_contrato'];
                    $obj = $registro ['objeto'];
                    $nom = $registro ['nome'];
                    $mine = $registro ['mine'];
                    $df = $registro ['d_fim_vige_cont'];
                    $data_prorro_aditivo = $registro ['data_prorro_aditivo'];
                    $sit = $registro ['situacao'];
                    $sicor = $registro ['siscor'];
                    $fim_garantia = $registro ['fim_vig_garat'];
                    $id_alerta = $registro ['id_alerta'];
                    $time = $registro['data'];
                    $tipo = limpa($registro['tipo']);             
                    
                       
                if(strtotime($data_prorro_aditivo) > strtotime($df)) {
                       $df= $data_prorro_aditivo;
                   }    
                    
                     
              
         
                    $time1 = explode(" ", $time);
                    $time2 = $time1[0];
                    $time3 = inverteData($time2);
                    $df1 = inverteData($df);
                    $fim_garantia1 = inverteData($fim_garantia);
                    $time1 = ($time);
                    $nom1 = explode(" ", $nom);
                    $nom2 = $nom1[0];



                    $data = date('Y-m-d');
                    $c1 = strtotime($data);
                    $c1 = (int) $c1;
                    $c2 = strtotime($fim_garantia);
                    $c3 = strtotime($df);

                    if ($c1 < $c3) {
                        $data1 = new DateTime($data);
                        $data2 = new DateTime($df);
                        $intervalo = $data1->diff($data2);
                        $inter_vcontr = " {$intervalo->y} anos, {$intervalo->m} meses e {$intervalo->d} dias";
                    } else {
                        $inter_vcontr = "Prazo Encerrado";
                    }
                    if ($c1 < $c2) {
                        $data3 = new DateTime($data);
                        $data4 = new DateTime($fim_garantia);
                        $intervalo = $data3->diff($data4);
                        $inter_garant = " {$intervalo->y} anos, {$intervalo->m} meses e {$intervalo->d} dias";
                    } else {
                        $inter_garant = "Prazo Encerrado";
                    }

                    if ($fim_garantia1 == '29/11/1999') {
                        $fim_garantia1 = 'Não se aplica';
                        $inter_garant = 'Não se aplica';}
                    else if ($c2 < $c3){
                           $fim_garantia1 ='Pendente Lançamento Recebimento';
                           $inter_garant ='Pendente Lançamento Recebimento';
                        
                       }
                   
                                    
                    ?>
                    <tr>
                       
                        <td ><a href="idex.php?id=<?php echo $id_contrato ?>"><?php echo $registro['rg']; ?></a></td>
                        <td  ><?php echo $tipo; ?></td>
                        <td  ><?php echo $registro['objeto']; ?></td>
                        <td ><?php echo $nom2; ?></td>
                        <td  ><?php echo $registro['mine']; ?></td>
                        <td  ><?php echo $df1; ?></td>
                        <td  ><?php echo $inter_vcontr; ?></td>
                        <td  ><?php echo $fim_garantia1; ?></td>
                        <td  ><?php echo $inter_garant; ?></td>
                        <td  ><?php echo $registro['situacao']; ?></td>
                        <td  ><?php echo $registro['siscor']; ?></td>
                        <td  >
                    <center><a class="nav-link"  href="#" data-toggle="modal" data-target="#visualizar<?php echo $id_alerta; ?>"><?php echo $time3; ?>	</a></center>
                    </td>
                     <td ><a target="_blank" href="historico_alerta.php?id=<?php echo $id_contrato ?>&id_alerta=<?php echo $id_alerta ?>&fg=<?php echo $inter_vcontr ?>&siscor=<?php echo $registro['siscor'] ?>"  ><center><i class="far fa-file"></i></center></td>
                    </tr>
                    <!--- visualizar e Editar --->
                    <div class="modal fade" id="visualizar<?php echo $id_alerta; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title text-center" style=" color: red;"><?php echo 'RG: '. $registro['rg'] ?></h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal" action="alerta.php" method="post">
                                         <div class="form-group col-md-12">
                                       
                                            <label for="exampleFormControlTextarea1">EDITAR SITUAÇÃO:</label>
                                            <textarea class="form-control"  name="situacao" id="exampleFormControlTextarea1" rows="10"> <?php echo $registro['situacao']; ?></textarea>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="crec_definitivo" >SISCOR:</label>
                                            <input  class="form-control form-control-lg"  name="siscor" Type="text"  id="csiscor"  value="<?php echo $registro['siscor']; ?>">
                                        </div>
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <input name="id_alerta" type="hidden" value=<?php echo $registro['id_alerta']; ?>>
                                            <input name="id_contrato" type="hidden" value=<?php echo $id_contrato; ?>>
                                           
                                            <input type="hidden" name="submitted" value="TRUE" />
                                            <button type="submit" class="btn btn-primary">Enviar</button>
                                        </div>
                                    </form>
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
   <?php require_once 'foot.php';?>
</body>
</html>
