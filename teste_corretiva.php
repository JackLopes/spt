<!DOCTYPE html>

<html lang= "pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $dabertura2 = '2018-06-11';
        $habertura = '09:00:00';



        $datendimento2 = '2018-07-16';
        $hatendimento = '15:00:00';
        $dconclusao2 = '2018-06-11';
        $hconclusao = '16:00:00';
        $p_atendimento = 24;
        $p_solucao = 72;

/*
        if ($dabertura2 == $datendimento2) {
            $tempo_excedido_atendimento_calc = (( $diasUteis_atendimento ) * 10 +
                    (( strtotime($hatendimento) - strtotime($habertura)) / 3600));

            $tempo_excedido_atendimento = $tempo_excedido_atendimento_calc - $p_atendimento;
        } else {
            $tempo_excedido_atendimento_calc = ((( $diasUteis_atendimento - 1) * 10 +
                    (( strtotime($fim) - strtotime($habertura)) / 3600) + (( strtotime($hatendimento) - strtotime($inicio)) / 3600)));

            $tempo_excedido_atendimento = $tempo_excedido_atendimento_calc - $p_atendimento;
        }

        
        




        if ($datendimento2 == $dconclusao2) {
            $tempo_excedido_conclusao = (($diasUteis_conclusao ) * 10 +
                    (( strtotime($hconclusao) - strtotime($hatendimento)) / 3600) - $p_solucao);
        } else {
       
            $tempo_excedido_conclusao = ((($diasUteis_conclusao - 1) * 10 +
                    (( strtotime($fim) - strtotime($hatendimento)) / 3600) + (( strtotime($hconclusao) - strtotime($inicio)) / 3600)) - $p_solucao);
        }

*/
       // da abertura modo 10x5
        
        
            if ($dabertura2 == $datendimento2) {
                $tempo_excedido_atendimento_calc = (($diasUteis_conclusao ) * 10 +
                        (( strtotime($hatendimento) - strtotime($habertura)) / 3600));
                
                $tempo_excedido_atendimento = $tempo_excedido_atendimento_calc - $p_atendimento;
                
                 
            } else {
                $tempo_excedido_atendimento_calc = ((($diasUteis_conclusao - 1) * 10 +
                        (( strtotime($fim) - strtotime($habertura)) / 3600) + (( strtotime($hatendimento) - strtotime($inicio)) / 3600)));
                
                 $tempo_excedido_atendimento = $tempo_excedido_atendimento_calc - $p_atendimento;
                
                
            }



            if ($datendimento2 == $dconclusao2) {
                $tempo_excedido_conclusao_calc = (($diasUteis_conclusao ) * 10 +
                        (( strtotime($hconclusao) - strtotime($habertura)) / 3600) );
                
                $tempo_excedido_conclusao =  $tempo_excedido_conclusao_calc - $p_solucao;
                
                
            } else {
                $tempo_excedido_conclusao_calc = ((($diasUteis_conclusao - 1) * 10 +
                        (( strtotime($fim) - strtotime($habertura)) / 3600) + (( strtotime($hconclusao) - strtotime($inicio)) / 3600)) );
                
                 $tempo_excedido_conclusao =  $tempo_excedido_conclusao_calc - $p_solucao;
            }
        

        
        
        
        
        
        
        
        var_dump('utilizado atendimento:'.$tempo_excedido_atendimento_calc);
        echo '<br>';
        var_dump('excedido atendimento:'.$tempo_excedido_atendimento);
        echo '<br>';
         var_dump('utilizado conclusao:'.$tempo_excedido_conclusao_calc);
        echo '<br>';
         var_dump('excedido conclusao:'.$tempo_excedido_conclusao);
        echo '<br>';
        ?>
    </body>
</html>
