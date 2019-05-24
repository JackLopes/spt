<!DOCTYPE html>

<?php

$page_title = 'Bem vindo ao Site';
require_once 'menu.php'; 
?>


<?php
 if (isset($_GET['id'])) {
$id =(int)$_GET['id'];} 

?>

<html>

<head>

		<title><?php echo $page_title; ?></title>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<link rel="stylesheet" href="dist/css/bootstrap-grid.css">
		<script src="dist/js/bootstrap.min.js"></script>	
	<link rel="stylesheet"  type="text/css" href="style8.css" media="screen"/>	
</head>
	<body >
		
<?php

echo"<center><table id ='tb1' border='1' cellpadding='10' ><center>";


require_once 'database_gac.php';

$sqlcolaborador = "SELECT * FROM colaborador WHERE id_colaborador = $id";
$resultado = mysqli_query($conection,$sqlcolaborador)or die ('Não foi possivel conectar ao MySQL');
while ($registro = mysqli_fetch_array($resultado))
{
	
		
	?>
    <tr>
        <td><?php echo  $registro['nome'];?></td>
        <td><?php echo $registro['funcao'];?></td>
        <td><?php echo $registro['email'];?></td>
        <td><?php echo $registro['celular'];?></td>
		 <td><?php echo $registro['telefone'];?></td>
        <td><?php echo $registro['lotacao'];?></td>
        <td>
            <a href="form.php?id=<?php echo $res['id']?>">
                editar
            </a>
        </td>
        <td>
            <a href="apagar.php?id=<?php echo $res['id_usuario']?>">
                apagar
            </a>
        </td>
    </tr>
    <?php
}
?>
</table>
<a href="form.php" class="btn btn-primary">
    Novo
</a>
 
</body>
</html>
