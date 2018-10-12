<?php 
 $codigo=isset($_GET["codigo"]) ? $_GET["codigo"]:NULL ;
 include("lib.php");
 $con=conectar();
 $sqll="SELECT DET_RUTA_TRACK.DRT_ORD, CIUDAD.CI_NOMBRE FROM DET_RUTA_TRACK, CIUDAD WHERE COD_RUTA_TRACK='$codigo' AND DET_RUTA_TRACK.COD_CIUDAD=CIUDAD.COD_CIUDAD order by DRT_ORD asc";
 $rst = oci_parse($con, $sqll);
 oci_execute($rst)or die("Ocurrió un error ");
	while ($row = oci_fetch_array($rst, OCI_ASSOC)) 
	{
   	    $ciudad=$row['CI_NOMBRE']."  ";
		echo "<script language=\"JavaScript\" type=\"text/javascript\">parent.document.getElementById(\"recorrido\").value+=\"$ciudad\"; </script>";
	}
//$row['DRT_ORD']."-".$row['CI_NOMBRE']."\n";

oci_free_statement($rst); 
oci_close($con);
?>


