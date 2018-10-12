<?php 
	session_start();
	$cod_cliente=$_SESSION['codb_cliente'];
	$cod_usuario=$_SESSION['codigo2'];      //codigo usuario logistica
	$term = strtoupper($_REQUEST['q']);
	 include("lib.php");
 	$con=conectar();
			    $sql="select clo.clo_nombre, kl.cod_klmtje , org.UL_NOMBRE origen, dst.UL_NOMBRE destino from klmtje_logistica kl, usuario_logistica org, usuario_logistica dst, cliente_logistica clo where kl.cod_usuario=$cod_usuario and kl.cod_cliente=$cod_cliente and kl.cod_origen=org.cod_usuario and kl.cod_cliente=org.cod_cliente and kl.cod_destino=dst.cod_usuario and kl.cod_cliente=dst.cod_cliente and clo.cod_cliente=kl.cod_cliente and org.ul_nombre like '%$term%'";
	  $result = oci_parse($con, $sql);
	  oci_execute($result) or die("Ocurrió un error al ejecutar el query1...");
	  while ($fila = oci_fetch_array($result, OCI_ASSOC)) 
	  {	   
		   echo $fila['COD_KLMTJE']."/".htmlentities($fila['ORIGEN'])."-".htmlentities($fila['DESTINO'])."\n"; 		   
	   }
oci_free_statement($result); 
oci_close($con);
?>

