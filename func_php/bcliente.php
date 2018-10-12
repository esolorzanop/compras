<?php
    session_start();
	$cod_cliente=$_SESSION['codb_cliente'];
	$bcod_cliente=isset($_GET["cod_empresa"]) ? $_GET["cod_empresa"]:NULL ;
	$term = strtoupper($_REQUEST['q']);
	include("lib.php");
	$con=conectar();
	if($bcod_cliente==10)
	{$sql="SELECT COD_USUARIO, UL_NOMBRE, COD_CIUDAD FROM USUARIO_LOGISTICA WHERE UL_NOMBRE LIKE '%$term%' order by UL_NOMBRE asc";}
	else{
	  if ($cod_cliente=='')
	  {
	    $cod_cliente=$bcod_cliente;
	   }
	  $sql="SELECT COD_USUARIO, UL_NOMBRE, COD_CIUDAD FROM USUARIO_LOGISTICA WHERE COD_CLIENTE=$cod_cliente and UL_NOMBRE LIKE '%$term%' order by UL_NOMBRE asc";
	}
	$result = oci_parse($con, $sql);
	oci_execute($result) or die("Ocurrió un error al ejecutar el query1...");
	while ($fila = oci_fetch_array($result, OCI_ASSOC)) 
	{
           echo $fila['COD_USUARIO']."-".$fila['COD_CIUDAD']."/".htmlentities($fila['UL_NOMBRE'])."\n"; 			   		   
	}
    oci_free_statement($result);
	oci_close($con);
  ?>


