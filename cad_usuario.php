

<?php
session_start();
$page_title = 'Cadastrar Usuário';
require_once 'database_gac.php';
$assunt = "<i class='fas fa-user'> </i> Cadastro de Colaboradores";
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$_SESSION['dados'] = $dados;
?> 
<!doctype html>
<html lang="pt">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">				 
        <link rel="stylesheet"  type="text/css" href="css/Styleuser1.css" media="screen"/>
        <link rel="stylesheet" href="css/bootstrap.css" >
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <script defer src="js/fontawesome-all.min.js"></script>
        <script>


            function esconDiv(valor)

            {
                if (valor == "2")
                {
                    document.getElementById("div4").style.display = "none";
                    document.getElementById("div6").style.display = "none";
                    document.getElementById("div7").style.display = "block";
                } else if (valor == "1")
                {
                    document.getElementById("div4").style.display = "block";
                    document.getElementById("div6").style.display = "block";
                    document.getElementById("div7").style.display = "none";

                }
            }

        </script>
    </head>
    <body  >
     
            <?php
            include 'header_cadastro.php';
            include_once 'image_header5.php' ?>  
      
        <div  class=" container-fluid    "  style="margin-top: 50px">
            <div class=" form1 col-md-8 order-md-1">

                <?php
                if (isset($_SESSION['msg41'])) {
                    echo $_SESSION['msg41'];
                    unset($_SESSION['msg41']);
                }
                ?>	

                <form class=" form1 needs-validation"  id="fm6" action="cad_colaboradores.php?action=salva" method="post" novalidate>
                    <div class="row">
                        <div  class="col-md-3 mb-10">
                            <label for="">EMPRESA</label>
                            <select class="form-control "  name="empresa1"  onchange="esconDiv(this.value)" >
                                <option selected></option>
                                <option value="1">SERPRO</option>
                                <option value="2">OUTRA</option>                               
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 mb-10">
                            <label for="firstName">NOME:</label>
                            <input class="form-control" Type="text" name="nome" size="100"  value="<?php if (isset($_SESSION['dados']['nome'])) echo $_SESSION['dados']['nome']; ?>" required>	
                        </div>  
                    </div>   
                    <div class="row">
                        <div class="col-md-6 mb-10">
                            <label for="firstName">EMAIL:</label>
                            <input class="form-control" Type="email" name="email" size="40" value="<?php if (isset($_SESSION['dados']['email'])) echo $_SESSION['dados']['email']; ?>" required> 	
                        </div>
                        <div class="col-md-6 mb-10">
                            <label for="firstName">	CELULAR:</label>
                            <input class="form-control" Type="text" name="celular" size="40" value="<?php if (isset($_SESSION['dados']['celular'])) echo $_SESSION['dados']['celular']; ?>" required>
                        </div>        
                    </div > 
                    <div class="row">
                        <div class="col-md-6 mb-10">
                            <label for="firstName">TELEFONE:</label>
                            <input class="form-control" Type="text" name="telefone" size="100"  value="<?php if (isset($_SESSION['dados']['telefone'])) echo $_SESSION['dados']['telefone']; ?>" required>            
                        </div>
                        <div class="col-md-6 mb-10">
                            <label for="address">FUNÇÃO:</label>			  
                            <input class="form-control" Type="text" name="funcao" size="40" value="<?php if (isset($_SESSION['dados']['funcao'])) echo $_SESSION['dados']['funcao']; ?>" required>            
                        </div>
                    </div>
                    <div class="row"  >
                        <div class="col-md-6 mb-10   div1" id="div4">
                            <label for="address"> LOTAÇÃO:</label>			  
                            <input class="form-control" Type="text" name="lotacao"  value="<?php if (isset($_SESSION['dados']['lotacao'])) echo $_SESSION['dados']['lotacao']; ?>" required>            
                        </div>
                        <div class="col-md-6 mb-10   div1" id="div6">
                            <label for="firstName">MATRICULA:</label>
                            <input class="form-control" Type="text" name="matricula"   value="<?php if (isset($_SESSION['dados']['matricula'])) echo $_SESSION['dados']['matricula']; ?>" required>	
                        </div>  
                    </div>
                    <div class=" row"  >
                        <div id="div7" class="form-group col-md-12">
                            <label for="forn">PRESTADOR/ FORNECEDOR:</label>
                            <select class="form-control" id="forn" name="empresa">
                                <option selected><?php  if (isset($_SESSION['dados']['empresa'])) echo $_SESSION['dados']['empresa']; ?></option>  
                                <?php
                                $q1 = "SELECT * FROM  prestador WHERE modo = '2' ORDER BY nome ASC";
                                $r1 = mysqli_query($conection, $q1);
                                while ($row = mysqli_fetch_assoc($r1)) {
                                    ?>
                                    <option value = "<?php echo $row ['nome']; ?>"><?php echo $row ['nome']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <hr class="mb-4">
                    <div class="mb-3">   
                        <input Type="hidden" name="senha" size="40" value="<?php if (isset($_SESSION['dados']['senha'])) echo $_SESSION['dados']['senha']; ?>" >
                        <input type="hidden" name="submitted" value="TRUE" />
                        <input class="btn btn-primary "  type="submit" name="submit" value="CADASTRAR"/>      
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>         
