<?php
//require_once 'Funcoes/func_usuarios.php';
//$nomes = busca_usuario($nomes_busca);

$query = "SELECT * FROM  usuario WHERE nome LIKE '%$nomes_busca%' ";
$result = mysqli_query($conection, $query);
?>
<table  class=" tb1 table table-hover table-striped table-sm table-bordered bg-light"   >
    <thead class="thead-dark ">
        <tr>
             <th scope="col">Nome</th>
            <th scope="col">Matricula</th>
           
            <th scope="col">Lotação</th>
            <th scope="col">Função</th>
            <th scope="col">Email</th>
            <th scope="col">Telefone</th>
            <th scope="col">Empresa</th>
            <?php if ($permissa == 2) { ?>
                <th scope="col">Permissões</th>
                <th scope="col">Senha</th>
                <th scope="col">Excluir</th>
            <?php } ?>
            <th scope="col">Editar</th>
    </thead>
    <?php
    while ($res = mysqli_fetch_array($result)) {

        $empresa = $res['empresa'];
        ?>
        <tr>
           <td class="sec"><?php echo $res['nome']; ?></td>
            <td><?php echo $res['matricula']; ?></td> 
           
            <td><?php echo $res['lotacao']; ?></td>
            <td><?php echo $res['funcao']; ?></td>
            <td><?php echo $res['email']; ?></td> 
            <td><?php echo $res['telefone']; ?></td>
            <td><?php echo $empresa; ?></td> 
            <?php if ($permissa == 2) { ?>
                <td class="text-center"><?php echo $res['permissao']; ?></td>
                <td class="text-center"><?php echo $res['senha']; ?></td>   
                <td><a id="a2" data-toggle="modal" href="#" data-target="#exampleModal<?php echo $res['id_usuario'] ?>" ><i class="fas fa-eraser"></i></a></td>
            <?php } ?>
            <td><a id="a2 "href="lista_usuario.php?id_usuario=<?php echo $res['id_usuario'] ?>&action=update"> <i class="far fa-edit"></i></a></td>
        </tr>
        <!-- Modal Exclusao -->
        <div class="modal fade" id="exampleModal<?php echo $res['id_usuario'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Deseja Realmente Deletar  </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><?php echo $res['nome'] ?></p>
                        <ul class="nav justify-content-center">     
                            <li class="nav-item">
                                <a  class="btn btn-danger" href="lista_usuario.php?id_usuario=<?php echo $res['id_usuario'] ?>">Sim</a>
                            </li>
                            <li style="margin-left:30px" class="nav-item">
                                <a style=" color: #FFFFFF" class="btn btn-success"  data-dismiss="modal">Nao</a>
                            </li>
                        </ul>
                    </div>                             
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</table>
