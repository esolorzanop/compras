<?php 
	$codigo=isset($_GET['codigo10']) ? $_GET['codigo10']:NULL ; 
    include("lib.php");
 	$con=conectar();
    $sql="select clo.clo_nombre, kl.cod_klmtje , org.UL_NOMBRE origen, dst.UL_NOMBRE destino from klmtje_logistica kl, usuario_logistica org, usuario_logistica dst, cliente_logistica clo where kl.COD_KLMTJE='$codigo' and kl.cod_origen=org.cod_usuario and kl.cod_cliente=org.cod_cliente and kl.cod_destino=dst.cod_usuario and kl.cod_cliente=dst.cod_cliente and clo.cod_cliente=kl.cod_cliente";
	$result = oci_parse($con, $sql);
	oci_execute($result) or die("Ocurrió un error al ejecutar el query1...");
	$row = oci_fetch_array($result, OCI_ASSOC)
  //  echo $sql;
//    $origen=$row['COD_KLMTJE']."/".$row['ORIGEN']."-".$row['DESTINO'];
    $origen=$row['ORIGEN'];
	$destino=$row['DESTINO'];
 	echo "<script language=\"JavaScript\" type=\"text/javascript\">parent.document.getElementById(\"ubicacion\").value=\"$origen\"; parent.document.getElementById(\"ubicacion2\").value=\"$destino\"; parent.document.getElementById(\"ubicacion2\").focus();</script>";
	//echo $origen;
	//echo $destino;  
oci_free_statement($result); 
oci_close($con);	  
?>