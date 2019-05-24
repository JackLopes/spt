<?php


 require './database_gac.php';
 require_once './gatway_corretiva.php';
 $nome = array();

        $sqlcolaborador = "SELECT nome FROM responsaveis WHERE responsabilidade='Fiscal Administrativo' GROUP BY(nome)";
        $resultado1 = mysqli_query($conection, $sqlcolaborador)or die('Não foi possivel conectar ao MySQL');
        while ($registro1 = mysqli_fetch_array($resultado1)) {

            $nome[] = $registro1['nome'];
        }
        $nomes = implode(",", $nome);

        $varios_nomes = explode(',', $nomes);

        $total_nome = count($varios_nomes);

/*
        for ($k = 0; $k < $total_nome; $k++) {

           total_ocorrencia_nome($varios_nomes[$k]);
            notasMedir($varios_nomes[$k]);
        }
*/
        
        var_dump($total_nome);