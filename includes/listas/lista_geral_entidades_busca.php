<?php
//require_once 'Funcoes/func_usuarios.php';
//$nomes = busca_usuario($nomes_busca);

$query = "SELECT * FROM  prestador WHERE nome LIKE '%$nomes_busca%' ";
$result = mysqli_query($conection, $query);
?>
<table  class="table table-hover table-striped table-sm table-bordered bg-light"   >
    <thead class="thead-dark ">
        <tr>
            <th scope="col">Nome Fantasia</th>
            <th scope="col">Sigla</th>
            <th scope="col">Nº do CNPJ </th>
            <th scope="col">Endereço</th>       
            <th scope="col">Contato</th>       
            <th scope="col">Editar</th>
            <?php if ($permissa == '2') { ?>
                <th scope="col">Excluir</th>
            <?php } ?>
    </thead>
    <?php
    while ($res = mysqli_fetch_array($result)) {
             $id_prestador = $res['id_prestador'];
        ?>
        <tr>

            <td class="sec"><?php echo $res['nome']; ?></td> 
            <td><?php echo $res['mnemonico']; ?></td> 
            <td><?php echo masc_cnpj_php($res['cnpj']); ?></td> 
            <td><?php echo $res['endereco']; ?></td> 
              <td> <a  href="#"  data-toggle="modal" data-target="#contatos<?php echo$res['id_prestador'] ?>"><i class="far fa-address-card"></i>/a></td>
            <td><a id="a2" href="lista_entidades.php?id_prest=<?php echo $res['id_prestador'] ?>&action=update"><i class="far fa-edit"></a></td>
            <?php if ($permissa == '2') { ?>
                <td> <a  href="#"  data-toggle="modal" data-target="#exampleModal5<?php echo$res['id_prestador'] ?>"><i class="fas fa-eraser"></i></a></td>
            <?php } ?>

        </tr>
        <!-- Modal Exclusao -->
        <div class="modal fade" id="exampleModal5<?php echo $res['id_prestador']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Deseja Realmente Deletar  </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><?php echo $res['nome']; ?></p>
                        <ul class="nav justify-content-center">     
                            <li class="nav-item">
                                <a class="btn btn-danger"  href="lista_entidades.php?id_prest=<?php echo $res['id_prestador'] ?>&action=deleta">Sim</a>
                            </li>
                            <li style="margin-left:30px" class="nav-item">

                                <a style=" color: #FFFFFF" class="btn btn-success"  data-dismiss="modal">Nao</a>
                            </li>
                        </ul>
                    </div>                             
                </div>
            </div>
        </div>
        <!-- Modal contatos -->
        <div class="modal fade" id="contatos<?php echo $res['id_prestador']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Contatos</h5>

                    </div>
                    <div class="modal-body">
                        <?php
                        echo"<ul class = 'list-group list-group-horizontal-xl'>";
                        $query = "SELECT * FROM  colaborador WHERE id_presta='$id_prestador' ";
                        $resultado = mysqli_query($conection, $query);
                        While ($value = mysqli_fetch_array($resultado)) {
                            echo " <li class = 'list-group-item'>" . "<p>" . "Nome: " . $value['nome'] . "</p> " . "<p>" . " Telefone: " . $value['telefone'] . "</p> " . "<p> Email: " . $value['email'] . "</p>" . "</li>";
                        }
                        echo " </ul>";
                        ?>
                    </div>                             
                </div>
            </div>
        </div>
        <?php
    }
    ?>

</table>
