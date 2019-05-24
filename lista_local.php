
<?php
include 'menu.php';

require 'database_gac.php';

$sql = "select * from local ORDER BY lugar_regional";
$con = mysqli_query($conection, $sql);

?>
<!doctype html>
<html lang="pt">

<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet"  type="text/css" href="css/styleinf_prest.css" media="screen"/>	
        <link rel="stylesheet" href="css/bootstrap.css" >
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
</head>
<body>
    <center><div class="col-md-12 order-md-1">
          <h4 class="mb-3">Lista de Entidades</h4>
		    <hr class="mb-4">           
    <div  class="container-fluid">
<table class="table table-striped"  >
<?php
while ($res = mysqli_fetch_array($con)) {
    ?>
    <tr>
       
        <td><?php echo $res['lugar_regional'];?></td> 
         <td><?php echo $res['cnpj'];?></td> 
         <td><?php echo $res['endereco'];?></td> 
        
        <td><a id="a2" href="atu_local.php?id_local=<?php echo $res['id_local']?>">EDITAR</a></td>

       
    </tr>
    <?php
}
?>

</table>

</div>
</body>
</html>