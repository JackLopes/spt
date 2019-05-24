
<!doctype html>
<html lang="pt">

<head>
 <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
	<link rel="stylesheet" href="css/bootstrap.css" > 
</head>

<body>
    <div class="row">
              <div class="col-lg-"> 
   
                  <select  class="custom-select"  >
				<option>REGIONAIS</option>  
				<?php	
				
				$q1 = "SELECT loc.*, tip.id_tipo, tip.tipos
                                    FROM local as loc
                                    INNER JOIN tipo as tip ON tip.id_local=loc.id_local
                                    WHERE id_contrato = '$id'";
				$r1 = mysqli_query($conection, $q1);
				while($row = mysqli_fetch_assoc($r1)) {                                 
                                    
				?>
                                <option ><a href="menu_local.php?id_local=<?php echo $row['id_local'];?>&id_tipo=<?php echo $row['id_tipo'];?>"><?php echo $row['lugar_regional'] ;?></a></option>  		
                                
                              
		<?php } ?>
	     </select>
               </div>
	</div>
</body>
</html>