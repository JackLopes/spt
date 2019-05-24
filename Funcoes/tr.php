
<!doctype html>
<html lang="pt">

<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 
<link rel="stylesheet"  type="text/css" href="css/style_etapa13.css" media="screen"/>
 <link rel="stylesheet" href="css/bootstrap.css" >

<script src="jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="js1/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js1/jquery.mask.min.js"></script>


</head>
<body  style="background-color: #cfcfcf;">
  <div  class="container " >
<form>
<input type="text" id="campoData">
<input type="text" id="campoTelefone">
<input type="text" id="campoSenha">

  <div class="form-group col-md-6">
      <label for="campovalor" >VALOR CONTRATADO:</label>
	 
      <input class="form-control"  Type="text" name="valor_contratado" id="campovalor" value="<?php if (isset($_POST['valor_contratado']))echo $_POST['valor_contratado'];?>" >
    </div>
</form>
 
<script>
jQuery(function($){
$("#campoData").mask("99/99/9999");
$("#campoTelefone").mask("(999) 999-9999");
$("#campoSenha").mask("***-****");
$('#campovalor').mask('000.000.000.000.000,00', {reverse: true});
});
</script>

        <script src="js/jquery.js"></script>
		<script src="js/jquery_1.js"></script>
		<script src="js/bootstrap.min.js"></script>
		
	</div>
</body>
</html>