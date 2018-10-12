<?php 
	//session_start();
	///*$cod_cliente=$_GET['cod_empresa'];      //codigo cliente logistica
	//$cod_usuario=$_SESSION['codigo2'];      //codigo usuario logistica
	//$term = strtoupper($_REQUEST['q']);*/
    $codklmtje=isset($_GET['klmtje']) ? $_GET['klmtje']:NULL ;
	include("lib.php");
 	$con=conectar();
   	$sql="select clo.clo_nombre, kl.cod_klmtje , org.UL_NOMBRE origen, dst.UL_NOMBRE destino from klmtje_logistica kl, usuario_logistica org, usuario_logistica dst, cliente_logistica clo where kl.cod_origen=org.cod_usuario and kl.cod_cliente=org.cod_cliente and kl.cod_destino=dst.cod_usuario and kl.cod_cliente=dst.cod_cliente and clo.cod_cliente=kl.cod_cliente and kl.cod_klmtje='$codklmtje'";
	  $result = oci_parse($con, $sql);
	//  echo $sql;
	  oci_execute($result) or die("Ocurrió un error al ejecutar el query1...");
	  $fila = oci_fetch_array($result, OCI_ASSOC)
	   $origen=$fila['ORIGEN'];
   	   $destino=$fila['DESTINO'];
      //echo $fila['COD_KLMTJE']."/".$fila['ORIGEN']."-".$fila['DESTINO']."\n"; 		   
	echo "<script language=\"JavaScript\" type=\"text/javascript\">parent.document.getElementById(\"ubicacion\").value=\"$origen\"; parent.document.getElementById(\"ubicacion2\").value=\"$destino\";</script>";

oci_free_statement($result);
oci_close($con);
?>

