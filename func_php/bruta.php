<?php
	session_start();
//	$cod_cliente=$_GET['cod_empresa'];      //codigo cliente logistica
	$cod_cliente=$_SESSION['codb_cliente'];
	$cod_ciudad=$_SESSION['codciudad'];
	$term = strtoupper($_REQUEST['q']);
	include("lib.php");
	$con=conectar();
	// if($cod_cliente==10)
	  // {
	    // $sql="SELECT COD_RUTA_TRACK FROM RUTA_TRACK WHERE RT_ESTADO=-1 and COD_RUTA_TRACK LIKE '%$term%' order by COD_RUTA_TRACK asc";
		// $sql="SELECT COD_RUTA_TRACK FROM RUTA_TRACK WHERE COD_CIUDAD=$cod_ciudad and RT_ESTADO =-1 and COD_RUTA_TRACK LIKE '%$term%' order by COD_RUTA_TRACK asc";
		//}
	    //else
		  // {
		    $sql="SELECT COD_RUTA_TRACK FROM RUTA_TRACK WHERE COD_CLIENTE=$cod_cliente and COD_CIUDAD=$cod_ciudad and RT_ESTADO =-1 and COD_RUTA_TRACK LIKE '%$term%' order by COD_RUTA_TRACK asc";
		//	echo $sql;
		    //}	
	  $result = oci_parse($con, $sql);
	  oci_execute($result) or die("Ocurrió un error al ejecutar el query1...");
	  while ($fila = oci_fetch_array($result, OCI_ASSOC)) 
	  {	   
		   echo $fila['COD_RUTA_TRACK']."\n"; 		   
	   }
oci_free_statement($result); 
oci_close($con);
  ?>


