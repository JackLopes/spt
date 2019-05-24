<?php



if ($categoria == 1) { // atraso de entrega de item
    $clausula = '<p> (7.2, a) Pelo atraso na entrega do objeto em relação ao prazo estipulado, sujeitar-se-á a
CONTRATADA  ao pagamento de multa de mora calculada à razão de 1% (um por cento)
ao dia, sobre o valor da entrega fora do prazo previsto </p>


<p> (7.2.1) As multas previstas nas alíneas “a” e “d” da subcláusula 7.2 são independentes
entre si, podendo ser aplicadas isoladas ou cumulativamente, desde que o somatório não
ultrapasse 10% (dez por cento) do valor total do contrato </p>

<p O valor das multas previstas na subcláusula 7.2.1 mais as da subcláusula 7.2.2
eventualmente aplicadas, está limitado a 100% (cem por cento) do valor total do contrato.';
} else if ($categoria == 2) {// ANS preventiva
    $clausula = '
<p> (7.2, c) Pelo descumprimento de níveis de serviços acordados, sujeitar-se-á a 
CONTRATADA ao pagamento de multas escalonadas e segundo critérios próprios neles estabelecidos;</p> 

<p> As multas previstas nas alíneas “b” e “c” da subcláusula 7.2 são independentes
entre si e demais alíneas, devendo ser aplicadas isoladamente, sem submeterem-se ao
limite fixado na subcláusula 7.2.1 anterior. </p>

<p>7.2.1 As multas previstas nas alíneas “a” e “d” da subcláusula 7.2 são independentes
entre si, podendo ser aplicadas isoladas ou cumulativamente, desde que o somatório não
ultrapasse 10% (dez por cento) do valor total do contrato</p>

<p>O valor das multas previstas na subcláusula 7.2.1 mais as da subcláusula 7.2.2
eventualmente aplicadas, está limitado a 100% (cem por cento) do valor total do contrato.</p>';
} else if ($categoria == 3) {//advertência
    $clausula = '
         a) Advertência;
         b) Multa;
         c) Suspensão   temporária   de   participação   em   licitação   promovida   pelo  
SERPRO   e impedimento de contratar com este por prazo de até 2 (dois) anos;
            7.1.1 As sanções previstas nas alíneas “a” e “c” da Subcláusula 7.1 poderão ser aplicadas
junto a da alínea “b”,  obedecido aos procedimentos legais;';
} else if ($categoria == 4) {// suspenção
    $clausula = ' 
         a) Advertência;
         b) Multa;
         c) Suspensão   temporária   de   participação   em   licitação   promovida   pelo  
SERPRO   e impedimento de contratar com este por prazo de até 2 (dois) anos;
            7.1.1 As sanções previstas nas alíneas “a” e “c” da Subcláusula 7.1 poderão ser aplicadas
junto a da alínea “b”,  obedecido aos procedimentos legais;';
} else if ($categoria == 5) {// ANS  corretiva
    $clausula = '
 c) Pelo descumprimento de níveis de serviços acordados, sujeitar-se-á a 
CONTRATADA ao pagamento de multas escalonadas e segundo critérios próprios neles estabelecidos.; 

7.2.1 As multas previstas nas alíneas “a” e “d” da subcláusula 7.2 são independentes
entre si, podendo ser aplicadas isoladas ou cumulativamente, desde que o somatório não
ultrapasse 10% (dez por cento) do valor total do contrato.;

7.2.2 As multas previstas nas alíneas “b” e “c” da subcláusula 7.2 são independentes
entre si e demais alíneas, devendo ser aplicadas isoladamente, sem submeterem-se ao
limite fixado na subcláusula 7.2.1 anterior.;



O valor das multas previstas na subcláusula 7.2.1 mais as da subcláusula 7.2.2
eventualmente aplicadas, está limitado a 100% (cem por cento) do valor total do contrato.;

';
} else if ($categoria == 6) { //descumprimento de clausula
    $clausula = '
7.2,d - Pelo não cumprimento de qualquer condição fixada neste contrato e não abrangida
pelas alíneas anteriores, relativa a cumprimento de prazos ou obrigações específicos,
sujeitar-se-á a CONTRATADA  ao pagamento de multa, à razão de 1% (um por cento) do
valor total deste contrato, por evento apurado; 

7.2.1 - As multas previstas nas alíneas “a” e “d” da subcláusula 7.2 são independentes
entre si, podendo ser aplicadas isoladas ou cumulativamente, desde que o somatório não
ultrapasse 10% (dez por cento) do valor total do contrato;

7.2.3 - O valor das multas previstas na subcláusula 7.2.1 mais as da subcláusula 7.2.2
eventualmente aplicadas, está limitado a 100% (cem por cento) do valor total do contrato. ';
} else if ($categoria == 7) { // Não entrga do objeto
    $clausula = '
<p> ( 7.2, b)Pela não entrega do objeto, caracterizada por atraso igual ou superior a 30 (trinta)
dias, sem que haja manifestação aceita pelo SERPRO , sujeitar-se-á a  CONTRATADA  ao
pagamento de multa compensatória de 15% (quinze por cento) sobre a soma dos valores
correspondentes aos itens de inexecução parcial ou sobre o valor total deste contrato,
quando se tratar de inexecução total, independentemente de rescisão contratual </p>';
} 


/*

$clau= explode(';', $clausula);

for ($i = 0; $i < count($clau) ; $i++) {
    
    echo $clau[$i].'<br>';
}
 * 
 * 
 */