
<?php
$page_title = 'Resumo';
include 'menu.php';

$result = filter_input(INPUT_GET, 'result', FILTER_SANITIZE_STRING);
$rgs = filter_input(INPUT_GET, 'rg', FILTER_SANITIZE_STRING);

$host = "localhost";
$user = "root";
$pass = "";
$banco = "gac";

$strcon = mysqli_connect($host, $user, $pass, $banco) or die('Não foi possivel conectar ao MySQL');

$an = date('Y');
//Verificar se está sendo passado na URL a página atual, senao é atribuido a pagina 
$pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;

//Selecionar todos os cursos da tabela
$result_curso = "SELECT * FROM prestador  WHERE modo = '2'";
$resultado_curso = mysqli_query($strcon, $result_curso);

//Contar o total de cursos
$total_cursos = mysqli_num_rows($resultado_curso);

//Seta a quantidade de cursos por pagina
$quantidade_pg = 4;

//calcular o número de pagina necessárias para apresentar os cursos
$num_pagina = ceil($total_cursos / $quantidade_pg);

//Calcular o inicio da visualizacao
$incio = ($quantidade_pg * $pagina) - $quantidade_pg;

//Selecionar os cursos a serem apresentado na página
$result_cursos = "SELECT * FROM prestador limit $incio, $quantidade_pg";
$resultado_cursos = mysqli_query($strcon, $result_cursos);
$total_cursos = mysqli_num_rows($resultado_cursos);

if (!empty($result)) {

    $assunt = " <div style='margin-left:200px;color:red; text-align:center;';> O <font color='#ffffff'>RG: $rgs </font>não foi encontrado. Verifique na lista abaixo atraves do registro do Fornecedor</div>";
} else {
    $assunt = 'Lista Geral';
}
?>

<script type="text/javascript">
    $(document).ready(function () {

        $('.gh #a2').css("border-bottom", "solid 1px #cfcfcf");
        $('.np #a3').hide().delay('1000')
        $('body').click(function () {
            $('body').dblclick(function () {
                $('.np #a3').fadeIn(1000)
            });
            $('body').click(function () {
                $('.np #a3').hide()
            });
        });
    });

</script>
<style>
    .paggina{
        font-weight: bold;
        font-size: 30px;
    }  


</style>



<div class="img5">
    <?php include_once 'image_header5.php' ?>  
</div>
<div id="cont" class="container "  >
    <div class="form-row  justify-content-center">
        <div class="form-group col-md-12">
            <?php
            $sqlprestador = "SELECT * FROM prestador WHERE modo = '2' ORDER BY nome limit $incio, $quantidade_pg";
            $resultado = mysqli_query($strcon, $sqlprestador)or die('Não foi possivel conectar ao MySQL');

            while ($registro = mysqli_fetch_array($resultado)) {
                $idp = $registro ['id_prestador'];

                $sqcon = "SELECT * FROM contrato WHERE id_prestador = '$idp'";
                $resultado1 = mysqli_query($strcon, $sqcon)or die('Não foi possivel conectar ao MySQL');
                if (mysqli_num_rows($resultado1) == 0) {
                    
                } else {

                    while ($registro1 = mysqli_fetch_array($resultado1)) {

                        if (!empty($registro1 ['id_contrato'])) {
                            ?>

                            <li  class=" list-group-item-action list-group-item-secondary  " id ="nps"><p><center><a id="a1" href="inf_prestador.php?id=<?php echo $registro['id_prestador']; ?>"><?php echo $registro['nome']; ?></a></li>

                                <?php
                                $sqcon = "SELECT * FROM contrato WHERE id_prestador = '$idp'";
                                $resultado1 = mysqli_query($strcon, $sqcon)or die('Não foi possivel conectar ao MySQL');
                                if (mysqli_num_rows($resultado1) == 0) {
                                    
                                } else {
                                    ?>				
                                    <?php
                                    while ($registro1 = mysqli_fetch_array($resultado1)) {
                                        $ids = $registro1 ['id_contrato'];
                                        $tch = $registro1 ['tip_chamado'];
                                        $rg = $registro1 ['rg'];
                                        ?>			
                                        <ul>	
                                            <li class ="gh">
                                                <a id="a2"  href="idex.php?id=<?php echo $registro1['id_contrato']; ?>"><em><?php echo '<span style="color:#363636" >' . " RG: " . '</span>' . $registro1['rg'] . '  '; ?></em></a>
                                            </li>
                                            <?php
                                            $sqloc = "SELECT * FROM local WHERE id_contrato = '$ids'";
                                            $resultado2 = mysqli_query($strcon, $sqloc)or die('Não foi possivel conectar ao MySQL');
                                            if (mysqli_num_rows($resultado2) == 0) {
                                                
                                            } else {
                                                ?>	
                                                <ul>

                                                    <?php
                                                    while ($registro2 = mysqli_fetch_array($resultado2)) {
                                                        $idl = $registro2 ['id_local'];
                                                        $regional = $registro2 ['lugar_regional'];
                                                        ?>			
                                                        <li class ="no"><a id="a3a" href="inf_local.php?id=<?php echo $registro2['id_local']; ?>&rg=<?php echo $rg; ?>"><em>
                                                                <?php echo "○ " . $registro2['lugar_regional']; ?></a></em><p></li>	
                                                        <?php
                                                        $sqlol = "SELECT * FROM tipo WHERE id_local = '$idl'";
                                                        $resultado3 = mysqli_query($strcon, $sqlol)or die('Não foi possivel conectar ao MySQL');
                                                        if (mysqli_num_rows($resultado3) == 0) {
                                                            
                                                        } else {
                                                            ?>				

                                                            <?php
                                                            while ($registro3 = mysqli_fetch_array($resultado3)) {
                                                                ?>		<ul>

                                                                    <li class ="np">
                                                                        <a id="a3" href="menu_local.php?id_tipo=<?php echo $registro3['id_tipo']; ?>
                                                                           &an=<?php echo $an; ?>&graf=1">
                                                                            <em><?php echo '<span style="color: #2F2F4F" >' . $registro3['tipos'] . '</span>'; ?></em></a>
                                                                        <p></li>	

                                                                </ul>
                                                            <?php } ?>		
                                                        <?php } ?>	
                                                    <?php } ?>	
                                                </ul>				
                                            <?php } ?>		
                                        </ul>

                                    <?php } ?>

                                <?php } ?>

                            <?php } ?>

                        <?php } ?>
                    <?php } ?>
                <?php } ?>

        </div>		</div>
    <?php
//Verificar a pagina anterior e posterior
    $pagina_anterior = $pagina - 1;
    $pagina_posterior = $pagina + 1;
    ?>
    <nav  class=" paggina fixed-bottom text-center">
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <?php if ($pagina_anterior != 0) { ?>
                    <a class="page-link" href="lista_geral.php?pagina=<?php echo $pagina_anterior; ?>" aria-label="Previous">
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
                <li class="page-item"><a class="page-link" href="lista_geral.php?pagina=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php } ?>
            <li class="page-item">
                <?php if ($pagina_posterior <= $num_pagina) { ?>
                    <a  class="page-link" href="lista_geral.php?pagina=<?php echo $pagina_posterior; ?>" aria-label="Previous">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                <?php } else { ?>
                    <span aria-hidden="true">&raquo;</span>
                <?php } ?>
            </li>
        </ul>
    </nav>
</div>
<?php require_once 'foot.php'; ?>
</body>
</html>
