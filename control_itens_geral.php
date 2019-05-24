<div class="form-group col-md-12">
    <?php
    $tipo = 'AQUISIÇÃO';
    $tipos = 'Hardware';
    require './gatway_corretiva.php';
    require_once './access_db.php';
  
    ?>
    <table  class="table table-striped table-hover table-bordered table-sm"  >
        <thead class="thead-dark">
            <tr>
                <td >RG:</td>
                <td >Regional:</td>
                <td >Descrição</td>
                <td>Fiscal Técnico</td>
                <td>Area</td>
                <?php if ($tipo == 'SERVIÇOS') { ?>
                    <td>Operante</td>
                <?php } ?>
                <?php if ($tipos == 'Hardware') { ?>
                    <td >Série</td>
                    <td >Patrimônio</td>
                <?php } ?>
                <td >Qtd Total </td>
                <?php if ($tipos == 'Hardware') { ?>       
                    <td >Qtd Entregue </td>
                <?php } ?>
                <td >Valor Unitário</td>
                <td >Sub Total</td>
                <?php if ($tipo == 'AQUISIÇÃO' or $tipo == 'SOLUÇÃO') { ?> 
                    <td >Prazo Entrega</td>
                    <td >Data De Entrega</td>
                    <td >Status</td>


                <?php } ?>


            </tr> 
        </thead>

        <?php
        $para_data = date('Y-m-d');



        $severi = "SELECT  * FROM itens WHERE status = 'Aguardando Entrega' AND prazo_entrega > '$para_data'";
        $resultado = mysqli_query($conection, $severi)or die('Não foi possivel conectar ao MySQL');
        while ($registro = mysqli_fetch_array($resultado)) {

            $id_itens = (int) $registro['id_itens'];
            $id_tipo = (int) $registro['id_tipo'];

            $regis = db_access($id_tipo);
            $rg = $regis['rg'];
            $id_contrato = $regis['id_contrato'];
            $regional = $regis['sigla'];

            $desc = $registro['descricao'];
            $d_rec_pro = $registro['rec_provisorio'];
            $d_inst = $registro['data_instalacao'];
            $prazo_entrega = $registro['prazo_entrega'];
            $patrimonio = $registro['patrimonio'];
            $entrega = $registro ['entrega'];
            $aplicacao_multa = $registro ['aplicacao_multa'];
            $prorrogacao_itens = $registro ['prorrogacao'];
            $ativo = $registro['ativo'];
            $qtd_total = (int) $registro['qtd_total'];
            $status = $registro['status'];


            //consulta que infere os valores constantes na tabela aceita para exibição na tabela itens

            $sq5 = "SELECT SUM(qtd_entrege) AS qtd_entregue_itens  FROM aceite WHERE id_iten = '$id_itens'";
            $result = mysqli_query($conection, $sq5)or die('Não foi possivel conectar ao MySQL');
            while ($registro5 = mysqli_fetch_array($result)) {

                $qtd_entregue_itens = $registro5['qtd_entregue_itens'];
            }

            $sq6 = "SELECT SUM(atraso_dias) AS atraso_dias_itens  FROM aceite WHERE id_iten = '$id_itens'";
            $result6 = mysqli_query($conection, $sq6)or die('Não foi possivel conectar ao MySQL');
            while ($registro6 = mysqli_fetch_array($result6)) {


                $atraso_dias_itens = (int) $registro6['atraso_dias_itens'];
            }
            //atualiza tabela itens
            $result1 = "UPDATE  itens  SET  qtd_entregue_itens='$qtd_entregue_itens', atraso_dias_itens ='$atraso_dias_itens' WHERE id_itens='$id_itens'";
            $resultado1 = mysqli_query($conection, $result1) or die(mysqli_error($conection));

            //condicional para avaliar se o item é ativo ou não, caso não seu patrimonio não contara no relatorio de manutençãopreventiva.

            $ativo == 2 ? $ativo = 'Sim' : $ativo = "<font color='red' >Não</font>";

            //acesso aos historico editados durante o processo

            $q = "SELECT * FROM aceite WHERE id_iten = '$id_itens' ";
            $r = mysqli_query($conection, $q);
            $num1 = mysqli_num_rows($r);





            //condicionais para exibição do status
            //armazenamento do status na tabela itens

            $result1 = "UPDATE  itens  SET  status='$status' WHERE id_itens='$id_itens'";
            $resultado1 = mysqli_query($conection, $result1) or die(mysqli_error($conection));

            // indicador e acesso ao detalhes quando a entrega e criada na tabela ceite

            if ($num1 > 0) {
                $observacao = "<span class='btn btn-outline-primary'><i class='fas fa-database'></i></span>";
            } else {
                $observacao = " ";
            }


            $val_unitario = number_format($registro['valor_unitario'], 2, ',', '.');
            ?>
            <tr>
                <td ><a href="#"=<?php echo $id_contrato ?>"><?php echo $rg; ?></a></td>
                <td style=" font-size: 30px; font-weight: bold;font-family: time new romam; " ><a class="btn btn-outline-primary"  href="cad_itens.php?action=0&id_tipo=<?php echo $id_tipo ?>&menu=2"><?php echo $regional; ?></a></td>
                
                <td><?php echo $desc; ?></td>
                <td class = "td3" ><?php echo $registro['responsavel']; ?></td>
                <td class = "td3 " ><?php echo $registro['area']; ?></td>
    <?php if ($tipo == 'SERVIÇOS') { ?>
                    <td class = "td3  text-center "  ><?php echo $ativo; ?></td>

    <?php } ?>
    <?php if ($tipos == 'Hardware') { ?>
                    <td class = "td3" > <a data-toggle="modal" <?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?>  data-target="#exampleModal<?php echo $id_itens ?>" <?php } ?>href="#"><?php echo $registro['serie']; ?></a></td>
                    <td class = "td3" ><?php echo $registro ['patrimonio'] ?></td> 
                <?php } ?>
                <td class = "td3" ><?php echo $registro['qtd_total']; ?></td>   
                <?php if ($tipos == 'Hardware') { ?>   
                    <td class = "td3" ><?php echo $qtd_entregue_itens; ?></td>                              
                <?php } ?>
                <td class = "td3" ><?php echo 'R$ ' . $val_unitario; ?></td>
                <td class = "td3" ><?php
                echo 'R$ ' . number_format($registro['sub_total'], 2, ',', '.');
                ;
                ?></td>
                <?php if ($tipo == 'AQUISIÇÃO' or $tipo == 'SOLUÇÃO') { ?> 

                    <td class = "td3" ><?php echo "<h5 >" . inverteData($registro['prazo_entrega']) . "</h5>"; ?></td>
                    <td> <a data-toggle="modal"<?php if ($matricula === $mat AND $permissa < 4 or $permissa == '2') { ?>  data-target="#example2<?php echo $id_itens ?>"<?php } ?> href="#">
                        <?php
                        echo "<h5 style='text-align: center'>" . inverteData($prorrogacao_itens) . "</h5>";
                        ?></td></a></td>


                    <td class = "td3" ><?php echo $status; ?></td>

                        <?php } ?>


            </tr>
    <?php
}
?>
    </table>
</div>