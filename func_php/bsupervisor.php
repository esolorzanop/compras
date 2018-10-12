<?php
    session_start();
	$cod_cliente=$_SESSION['codigo'];
	$term = strtoupper($_REQUEST['q']);
	include("lib.php");
	$con=conectar();
	$sql="select COD_USUARIOW, WEB_NOMBRE_USUARIO from USUARIO_WEB where COD_CLIENTE=$cod_cliente and WEB_CARGO='SUPERVISOR' and WEB_NOMBRE_USUARIO LIKE '%$term%' order by WEB_NOMBRE_USUARIO asc";
	$result = oci_parse($con, $sql);
	oci_execute($result) or die("Ocurrió un error al ejecutar el query1...");
	while ($fila = oci_fetch_array($result, OCI_ASSOC))
	{
           echo $fila['COD_USUARIOW']."-".$fila['WEB_NOMBRE_USUARIO']."\n"; 			   
	}
	oci_free_statement($result); 
	oci_close($con);
?>