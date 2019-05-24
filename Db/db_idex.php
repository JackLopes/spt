<?php
function update_status($status, $id_contrato) {
    require './database_gac.php';
    
        $query_idex = "UPDATE contrato SET status ='$status' WHERE id_contrato= '$id_contrato'";
        $result = mysqli_query($conection, $query_idex)or die(mysqli_error($conection));
    
        
}

