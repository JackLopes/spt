<script>
    $(document).ready(function () {
        $('.date').mask('00/00/0000');
        $('.time').mask('000:00', {reverse: true});
        $('.date_time').mask('00/00/0000 00:00:00');
        $('.cep').mask('00000-000');
        $('.phone').mask('0000-0000');
        $('.phone_with_ddd').mask('(00) 0000-0000');
        $('.phone_us').mask('(000) 000-0000');
        $('.mixed').mask('AAA 000-S0S');
        $('.cpf').mask('000.000.000-00', {reverse: true});
        $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
        $('.money').mask('000.000.000.000.000,00', {reverse: true});
        $('.money2').mask("#.##0,00", {reverse: true});
        $('.ip_address').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
            translation: {
                'Z': {
                    pattern: /[0-9]/, optional: true
                }
            }
        });
        $('.ip_address').mask('099.099.099.099');
        $('.percent').mask('##0,00%', {reverse: true});
        $('.clear-if-not-match').mask("00/00/0000", {clearIfNotMatch: true});
        $('.placeholder').mask("00/00/0000", {placeholder: "__/__/____"});
        $('.fallback').mask("00r00r0000", {
            translation: {
                'r': {
                    pattern: /[\/]/,
                    fallback: '/'
                },
                placeholder: "__/__/____"
            }
        });
        $('.selectonfocus').mask("00/00/0000", {selectOnFocus: true});
    });
</script>

<?php
/*
String: "3438420000", Máscara: "(##)####-####", Resultado: "(34)3842-0000";
String: "12032010", Máscara: "##/##/##", Resultado: "12/03/2010";
String: "2236", Máscara: "##:##", Resultado: "22:36".
*/

$telefone = '1158741859';
$hora='12';

function mascara_string($mascara,$string)
{
   $string = str_replace(" ","",$string);
   for($i=0;$i<strlen($string);$i++)
   {
      $mascara[strpos($mascara,"#")] = $string[$i];
   }
   return $mascara;
}

/*
echo mascara_string('(##)####-####',$telefone);
echo'<br>';
echo mascara_string('###:##',$hora);

echo'<br>';
echo strlen($hora); 
/*
 * 
 */

function mascara_php($hora) {
    

$tamanho = strlen($hora); 

switch ($tamanho) {
    case 2:
        echo mascara_string('0:##',$hora);
        break;
    case 3:
        echo mascara_string('#:##',$hora);
        break;
    case 4:
       echo mascara_string('##:##',$hora);
        break;
    case 5:
      echo mascara_string('###:##',$hora);
        break;
}
}
        
        ?>