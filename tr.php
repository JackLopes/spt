
            
            
            
<?php
require 'database_gac.php';

$q1 = "SELECT * FROM chat ORDER BY data ";
$result = mysqli_query($conection, $q1);
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
        <nav class="navbar navbar-light bg-light">
            <a class="navbar-brand" href="#">LISTA DE DEMANDAS & SUGESTOES</a>
        </nav>
    <center><div class="col-md-12 order-md-1">
            <h4 class="mb-3"></h4>

            <div  class="container-fluid">
                <table class="table table-striped"  >
                    <thead class="thead-light ">
                        <tr>
                            <th scope="col">Autor</th>
                            <th scope="col">Demanda & Sugestoes</th>                         
                            <th scope="col">Data Registro</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <?php
                    while ($res = mysqli_fetch_array($result)) {
                        ?>
                        <tr>
                            <td><?php echo $res['pseudo']; ?></td> 
                            <td><?php echo $res['mensagem']; ?></td> 
                            <td><?php echo $res['data']; ?></td>                            
                            <td><a href="atu_chat.php?id_chat=<?php echo $res['id_chat'] ?>"><?php echo $res['status']; ?></a></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
            </body>
            </html>