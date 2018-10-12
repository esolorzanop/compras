<?php
	$term = strtoupper($_REQUEST['q']);
	include("lib.php");
	$con=conectar();
	$sql="SELECT COD_CLIENTE, CLO_NOMBRE FROM CLIENTE_LOGISTICA WHERE CLO_NOMBRE LIKE '%$term%' order by CLO_NOMBRE asc";
	$result = oci_parse($con, $sql);
	oci_execute($result) or die("Ocurrió un error al ejecutar el query1...");
	while ($fila = oci_fetch_array($result, OCI_ASSOC)) 
	{
           echo $fila['COD_CLIENTE']."/".$fila['CLO_NOMBRE']."\n"; 			   
	}
	oci_free_statement($result); 
	oci_close($con);
  ?>
