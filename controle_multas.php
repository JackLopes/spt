<?php
require_once 'menu.php';
$assunt = 'Previsão de Aplicação de Multas ';
?>



<style>


    .tb34{
        margin-top: 40px;

    }

    
</style>

</head>
<body>

    <?php
    require_once 'image_header6.php';
    ?>


    <div class="form-group col-md-12">

        <table  class="tb34 table table-hover table-striped table-sm table-bordered bg-light"   >
            <thead class="thead-dark ">
                <tr>
                    <th class="set1" scope="col">Relatorio: </th>
                    <th class="set1" scope="col">Status: </th>
                    <th class="set1" scope="col">Área Gestora: </th>
                    <th class="set1" scope="col">RG: </th>
                    <th class="set1" scope="col">Contratada </th>              
                    <th  scope="col">SISCOR</th>   
                    <th  scope="col">Tipo de Infração</th>   
                    <th  scope="col">Valor do Contrato</th>
                    <th   style="background-color: #B22222;">Valor do Previsionado</th>
                    <th  scope="col">Valor do Aplicado</th>

                </tr> 
            </thead>
            <?php
            require_once 'database_gac.php';
            $sql20 = "SELECT *  FROM historico_multa WHERE status = '1' ";
            $result = mysqli_query($conection, $sql20)or die('Não foi possivel conectar ao MySQL');
            while ($registro1 = mysqli_fetch_array($result)) {
                $id_contrato = $registro1['id_contrato'];

                $sqlcontrato = "SELECT * FROM contrato WHERE id_contrato = $id_contrato";
                $resultado = mysqli_query($conection, $sqlcontrato)or die('Não foi possivel conectar ao MySQL');
                while ($registro = mysqli_fetch_array($resultado)) {
                    $rg = $registro['rg'];
                    $valor_atual = $registro['valor_atual'];
                    $area = $registro['natureza'];
                    $id_prestador = $registro['id_prestador'];
                }
                $sql3 = "SELECT * FROM prestador WHERE id_prestador = $id_prestador";
                $resultado2 = mysqli_query($conection, $sql3)or die('Não foi possivel conectar ao MySQL');
                while ($registro2 = mysqli_fetch_array($resultado2)) {

                    $empresa = $registro2['nome'];
                }


                $data_registro = $registro1['data_registro'];

                $valor_multa_aplicado = $registro1['valor_multa_aplicado'];
                $valor_multa_definitivo = $registro1['valor_multa_definitivo'];
                $siscor = $registro1['siscor'];
                $observacao = $registro1['observacao'];
                $categoria = $registro1['categoria'];
                $id_histmulta = $registro1['id_histmulta'];
                $siscor = $registro1['siscor'];
                $clausula = $registro1['clausula'];
                $status = $registro1['status'];
                $id_histmulta = $registro1['id_histmulta'];



                $valor_multa_definitivo = $registro1['valor_multa_definitivo'];

                switch ($categoria) {
                    case 1:
                        $categoria = "Atraso na Entrega do Objeto";
                        break;
                    case 5:
                        $categoria = "Descumprimento SLA Corretiva";
                        $dire = 'multaCorretiva.php?id';
                        break;
                    case 3:
                        $categoria = " ";
                        break;
                    case 4:
                        $categoria = " ";
                        break;
                    case 5:
                        $categoria = " ";
                        break;
                    case 6:
                        $categoria = "Descumprimento de Cláusula ";

                        $dire = 'multaDescumprimento.php?id';
                        break;
                }

                if (!empty($observacao)) {
                    $observacao = 'Detalhes';
                }

                if ($status == 1) {
                    $status = "Em Processo";
                }

                $valor_multa_aplicado1 = number_format($valor_multa_aplicado, 2, ',', '.');
                $valor_multa_definitivo1 = number_format($valor_multa_definitivo, 2, ',', '.');
                ?>
                <tr>
                    <td ><a  href="<?php echo $dire ?>=<?php echo $id_contrato ?>&id_histmulta=<?php echo $id_histmulta ?>"><center><i class="far fa-file"></i></center></a></td>
                    <td><?php echo $status ?></td> 
                    <td><?php echo $area ?></td> 
                    <td><?php echo $rg ?></td> 
                    <td><?php echo $empresa ?></td> 
                    <td><?php echo $siscor ?></td>
                    <td><?php echo $categoria ?></td>
                    <td><?php echo $valor_atual ?></td>
                    <td><?php echo 'R$ ' . $valor_multa_aplicado1 ?></td>
                    <td><?php echo 'R$ ' . $valor_multa_definitivo1 ?></td>

                </tr>
                <?php
            }
            ?>
        </table>
    </div>

</body>

<script>

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

</script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script defer src="js/fontawesome-all.min.js"></script>
</html>




