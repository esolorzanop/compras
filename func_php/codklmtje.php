<?php 
session_start();
 $codklmtje=isset($_GET['codklmtje']) ? $_GET['codklmtje']:NULL ;
 include("lib.php");
 $con=conectar();
 if($codklmtje<>"")
 {
 $sqll="select ci.cod_ciudad, ci.ci_nombre from ciudad ci where ci.cod_ciudad in (select cod_ciudad from usuario_logistica where cod_usuario in (select cod_origen from klmtje_logistica where cod_klmtje='$codklmtje'))";
 $rst = oci_parse($con, $sqll);
 oci_execute($rst)or die("Ocurrió un error ");
  $row = oci_fetch_array($rst, OCI_ASSOC);
   	    $cod_ciudad=$row['COD_CIUDAD'];
   	    $ciudad=$row['CI_NOMBRE'];
		echo "<script language=\"JavaScript\" type=\"text/javascript\">parent.document.getElementById(\"ubicaciono\").value=\"$ciudad\"; parent.document.getElementById(\"cod_centro\").value=\"$cod_ciudad\";</script>";
//$row['DRT_ORD']."-".$row['CI_NOMBRE']."\n";
  	    echo $cod_ciudad;
   	    echo $ciudad;
$_SESSION['codciudad']= $cod_ciudad;	
oci_free_statement($rst); 
oci_close($con);

}
?>