<!doctype html>
<html lang="pt">

<head>
 <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
	<link rel="stylesheet" href="css/bootstrap.css" > 





</head>

<body>
<nav class="navbar fixed-bottom navbar-light bg-light">  
<div  class="container-fluid" >
       
	 
	 <div class="col-md-2 mb-3">
  <a class="navbar-brand" href="idex.php?id=<?php echo $_GET['id'];?>">RETORNAR  </a>
  	</div>
    	 <div class="row">
            <div class="col-md-5 mb-3">


         <form  class="form-inline mt-2 mt- md-0" action="menu_local.php" method="post">						
		<input Type="hidden" name="id_tipo"   value="<?php echo $tip ;?>" >
		<input Type="hidden" name="ct" value="<?php echo $id;?>" >
		<input Type="hidden" name="tch" value="<?php echo $tch;?>" />			
	    <input Type="hidden" name="an"   value="<?php echo $an ;?>" >	
		<input  type="hidden" name="rg" value="<?php echo $rg ; ?>"/>
		<input  type="hidden" name="regional"  value="<?php echo $regional ; ?>"/>
		<input  type="hidden" name="graf" value="2"/>
		<input type="submit" class="btn btn-danger" style="color: #cfcfcf; text-shadow:1px 1px 3px black"  name="submit" value="CLIQUE AQUI !!!">
	    <input type="hidden" name="submitted" value="TRUE" />

 			
			
		</form>
		</div>
	
	</div>	
	</div>	
</nav>
		</body>
	</html>