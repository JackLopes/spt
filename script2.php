<!doctype html>
<html lang="pt">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">				 

        <link rel='stylesheet" href="css/bootstrap.css' >
        <script type='text/javascript" src="js/jquery-3.3.1.min.js'></script>
       
        
    </head>
    <body  >



        <div class='row col-8' style="margin: auto">
            <div class='col-6' style='  background-color: red'>         
                <table   >	
                    <thead >
                        <tr>
                            <th color='white'; bgcolor=' #6c757d'; >INFRAÇÃO</th>    <th  bgcolor=' #6c757d';  color='white' >TOTAL PREVISIONADO *</th> <th  class='tb' bgcolor=' #6c757d' colspan='2'  color='white'>LIMITAÇÕES</th> 
                        </tr>
                    </thead>
                    <tr><td  bgcolor='#E8E8E8'>Advertência</td><td  bgcolor='#E8E8E8'> $advertencia </td></tr>
                    <tr><td>Suspenção</td><td>0</td></tr> 
                    <tr><td   bgcolor='#E8E8E8'  >Atraso na Entrega do Objeto</td><td bgcolor='#E8E8E8' >R$ $soma_multa_aplicado_atraso_itens1</td></tr>
                    <tr><td>Não Entrega do Objeto</td><td>R$  R$ 0,00</td></tr>
                    <tr><td  bgcolor='#E8E8E8' >NS (Manutenção Preventiva)</td><td  bgcolor='#E8E8E8' >R$ 0,00</td></tr>
                    <tr><td>NS (Manutenção Corretiva)</td><td>R$  $soma_multa_aplicado_corretiva1</td></tr>                                      
                    <tr><td  bgcolor='#E8E8E8'>Descumprimento de Cláusula</td><td  bgcolor='#E8E8E8'>R$ $soma_multa_descumprimento1</td></tr>                                     
                    </tbody>
                </table> 
            </div >
            <div class='col-6'  style='  background-color: greenyellow'>
            <table  >
                <thead >
                    <tr>
                                                                                    
                    </tr>
                </thead>
                <tr><td>Limite de Aplicação Parcial</td  ><td>R$ $valor_limitacao_pacial1</td></tr>
                <tr><td bgcolor='#E8E8E8'>Limite de Aplicação Total</td ><td bgcolor='#E8E8E8'>R$ $valor_limitacao_total1</td></tr>
            </table>
            <table  class='tb3' cellspacing=0 cellpadding=3 >
                <thead >
                    <tr>
                        <th bgcolor=' #6c757d' colspan='2' color='white' >VALOR REFERENTE PARA APLICAÇÃO DA MULTA</th>

                    </tr>
                </thead>
                <tr><td bgcolor='#E8E8E8'></td><td bgcolor='#E8E8E8'><strong>R$ $valor_multa_aplicado</strong></td></tr>
            </table>
        </div>
    </div> 
</body>

</html>    