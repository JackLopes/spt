<?php
	require_once 'database_gac.php';


	$title  =  $_POST['title'];
	$color =  $_POST['color'];
	$start =  $_POST['start'];
	$end =  $_POST['end'];
	$observacao =  $_POST['observacao'];	
	$id_contr =  $_POST['id_contr'];
	
    	
	$data = explode (" ", $start);
	list($data, $hora) = $data;	
	$data_sem_barra = array_reverse(explode("/",$data));
	$data_sem_barra = implode("-", $data_sem_barra);
	$start_sem_barra = $data_sem_barra . " " . $hora;
	
	
	$data = explode (" ", $end);
	list($data, $hora) = $data;	
	$data_sem_barra = array_reverse(explode("/",$data));
	$data_sem_barra = implode("-", $data_sem_barra);
	$end_sem_barra = $data_sem_barra . " " . $hora;
	
	
			
	   
    $q1 = "INSERT INTO events (title, color, start, end, observacao, id_contr) VALUES ('$title ','$color', '$start_sem_barra', '$end_sem_barra','$observacao', '$id_contr')"; 
	$r1 = mysqli_query($conection, $q1);  
    

?>

<a href="index2.php?id=<?php echo $id_contr?>"><button>Voltar</button></a>
