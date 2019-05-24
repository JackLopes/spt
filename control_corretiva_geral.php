<div class="form-group col-md-12">
    <?php
    require './gatway_corretiva.php';
    echo total_ocorrencia();
    ?>
    <table  class="table table-hover table-striped table-sm table-bordered bg-light"   >
        <thead class="thead-dark ">
            <tr>
                <th class="set1" scope="col">RG: </th>
                <th class="set1" scope="col">Regional </th>
                <th  scope="col">Nº Chamado</th>
                <th  scope="col">Mes</th>
                <th scope="col">Severidade</th>
                <th scope="col">Data da Abertura</th>                                                                                                                                                                                                                   
                <th scope="col">Hora da Abertura</th>
                <th scope="col">Data do Apoio</th>
                <th scope="col">Hora do Apoio</th>
                <th scope="col">Data de Conclusão</th>
                <th scope="col">Hora da Conclusão</th>
                <th scope="col">Prazo do Apoio</th>
                <th scope="col">Utilizado Atendimento</th>
                <th scope="col">Prazo de Conclusão</th> 
                <th scope="col">Utilizado Conclusão</th>
                <th   style="background-color: #B22222;">Total Horas Excedentes </th>
                <th style="background-color: #B22222;">Necessidade On-site?</th>
                <th  style="background-color: #B22222;">Apoio On-site?</th>
                <th style="background-color: #B22222;">Previsão de Multa?</th>
                <th  style="background-color: #B22222;">Aplicar Multa?</th>
            </tr> 
        </thead>
        <?php
        $multa = array();
        $sqlcorre = "SELECT * FROM corretivas WHERE previsao_multa = '1' And aplicacao_multa ='Verificar' ORDER BY (data_conclusao) DESC";
        $resultado = mysqli_query($conection, $sqlcorre)or die('Não foi possivel conectar ao MySQL');
        while ($registro = mysqli_fetch_array($resultado)) {

            $multa[] = $registro['previsao_multa'];
            $patrimonio = $registro['n_patrimonio'];
            $rg = $registro['rg'];
            $regional = $registro['regional'];
            $id_tipo = $registro['id_tipo'];
            $status = $registro['status'];
            $previsao_multa = $registro['previsao_multa'];
            $data1 = $registro['dabertura_real'];
            $data1 = inverteData($data1);
            $data2 = $registro['datendimento_real'];
            $data2 = inverteData($data2);
            $data3 = $registro['dconclusao_real'];
            $data3 = inverteData($data3);
            $necessidade_on_site = $registro['necessidade_on_site'];
            $atendimento_onsite = $registro['atendimento_onsite'];
            $id_corretiva = $registro['id_corretiva'];
            $severidade = $registro['tipo_severidade'];

            if ($severidade == 5) {
                $severidade = 3;
            }

            if ($status == '1') {
                $status = 'Ok';
            }

            if ($registro['n_chamado'] == 'Nao Houve') {
                $data3 = '00/00/0000';
            }

            if ($previsao_multa == '1') {
                $previsao_multa = "<font style='color:red;'><i class='fas fa-check-circle'></i></font>";
            } else {
                $previsao_multa = "<font style='color:green ;'><i class='fas fa-times-circle'></i></font>";
            }
            ?>
            <tr>
                <td class = " set1 " ><?php echo $rg; ?></td>
                <td style=" font-size: 20px; font-weight: bold;font-family: time new romam; text-align: center;" ><a class="btn btn-outline-primary" href="cad_corretiva.php?action=2&id_tipo=<?php echo $id_tipo ?>"><?php echo $registro['regional']; ?></a></td>
                <td class = "td2" ><?php echo $registro['n_chamado']; ?></td>
                <td class = "td2" ><?php echo $registro['mes_ref'] . "/" . $registro['ano_ref']; ?></td>
                <td class = "td2" ><?php echo $severidade; ?></td>
                <td class = "td2" ><?php echo $data1; ?></td>
                <td class = "td2" ><?php echo $registro['habertura_real']; ?></td>
                <td class = "td2" ><?php echo $data2; ?></td>
                <td class = "td2" ><?php echo $registro['hatendimento_real']; ?></td>
                <td class = "td2" ><?php echo $data3; ?></td>
                <td class = "td2" ><?php echo $registro['hconclusao_real']; ?></td>
                <td class = "td2" ><?php echo $registro['prazo_atendimento']; ?></td>
                <td class = "td2" ><?php echo $registro['subtotal_atendimento']; ?></td>
                <td class = "td2" ><?php echo $registro['prazo_conclusao']; ?></td>       
                <td class = "td2" ><?php echo $registro['subtotal_conclusao']; ?></td>
                <td class = "td2" ><?php echo $registro['total']; ?></td>
                <td class = "td2" ><?php echo $necessidade_on_site; ?></td>
                <td class = "td2" ><?php echo $atendimento_onsite; ?></td>
                <td class = "td2" style=" text-align: center;"><?php echo $previsao_multa; ?></td>
                <td class = "set1" ><?php echo $registro['aplicacao_multa']; ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>