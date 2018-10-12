<?php
    session_start();
	include("../func_php/lib.php");
	$con=conectar();
	
	$term = strtoupper($_REQUEST['q']);
	    
	$sql="SELECT IT.COD_ITEM, CA.CA_NOMBRE, IT.IT_NOMBRE FROM ITEM IT, CATEGORIA CA WHERE UPPER(IT.IT_NOMBRE) LIKE '%$term%' AND CA.COD_CATEGORIA (+) = IT.COD_CATEGORIA ORDER BY IT_NOMBRE ASC, CA.CA_NOMBRE ASC";
	
	$result = oci_parse($con, $sql);
	oci_execute($result) or die("Ocurrió un error al ejecutar el query1...");
	
	while ($fila = oci_fetch_array($result, OCI_ASSOC)) 
	{
		echo $fila['COD_ITEM']."_".$fila['CA_NOMBRE']."_".$fila['IT_NOMBRE']."\n"; 	
	}
    oci_free_statement($result);
	oci_close($con);

?>