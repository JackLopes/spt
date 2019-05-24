<!DOCTYPE html>

<html lang= "pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require_once './mist_corre.php';
        
        $modo=2;
        $chamado = 2;
                
      
        $dabertura = '2018-06-25';
        $habertura = '18:55:00';



        $datendimento = '2018-06-26';
        $hatendimento = '06:32:00';
        $dconclusao = '2018-07-31';
        $hconclusao = '10:49:00';
        $p_atendimento = 6;
        $p_solucao = 100000;

 /* Calculo de 10x5 considerando chamado da abertura */ 
        if ($modo == 2 && $chamado == 2) {
            
                /*   se a abertura  for apos as 18:00 o sistema acrescentara mais um dia e iniciara a contagem apartidas 8:00 */
                if ($habertura > '18:00') {
                    $dabertura = date('Y-m-d', strtotime($dabertura . ' + 1 days'));
                    $habertura = '08:00';
                } 
                   /*   se a abertura  for antes das  8:00 , o sistema entendera que devera contar apartir das 8:00 e que se trata do mesmo dia */
                 else    if ($habertura < '08:00') {
                    $habertura = '08:00';
                }
                /*   se a abertura  for no sabado ou domingo, o sistema inicia no proximo dia util apartir das 8:00 */

                $dabertura2 = proximoDiaUtil($dabertura);

                if ($dabertura2 > $dabertura) {
                    $habertura = '08:00';
                    $dabertura = $dabertura2;
                }

                   $fim = '18:00';
                   $inicio = '08:00';



                /* Calculo inverte as datas do formato nativo para o convencional, isto é feito para que possamos utilizar a função que extrai feriados e fim de semana */
                $dabertura2 = inverteData($dabertura);
                $datendimento2 = inverteData($datendimento);
                $dconclusao2 = inverteData($dconclusao);


                /* Calculo de dias uteis */

                $diasUteis_atendimento = DiasUteis($dabertura2, $datendimento2);
                $diasUteis_conclusao = DiasUteis($datendimento2, $dconclusao2);

                /* condicional que fara os calculos confome seja datas iguais ou diferentes respectivamente */

                if ($dabertura2 == $datendimento2) {
                    $tempo_excedido_atendimento_calc = (($diasUteis_atendimento ) * 10 +
                            (( strtotime($hatendimento) - strtotime($habertura)) / 3600));

                    $tempo_excedido_atendimento = $tempo_excedido_atendimento_calc - $p_atendimento;
                } else {
                    $tempo_excedido_atendimento_calc = ((($diasUteis_atendimento - 1) * 10 +
                            (( strtotime($fim) - strtotime($habertura)) / 3600) + (( strtotime($hatendimento) - strtotime($inicio)) / 3600)));

                    $tempo_excedido_atendimento = $tempo_excedido_atendimento_calc - $p_atendimento;
                }



                if ($datendimento2 == $dconclusao2) {
                    $tempo_excedido_conclusao_calc = (($diasUteis_conclusao ) * 10 +
                            (( strtotime($hconclusao) - strtotime($habertura)) / 3600) );

                    $tempo_excedido_conclusao = $tempo_excedido_conclusao_calc - $p_solucao;
                } else {
                    $tempo_excedido_conclusao_calc = ((($diasUteis_conclusao - 1) * 10 +
                            (( strtotime($fim) - strtotime($habertura)) / 3600) + (( strtotime($hconclusao) - strtotime($inicio)) / 3600)) );

                    $tempo_excedido_conclusao = $tempo_excedido_conclusao_calc - $p_solucao;
                }
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
