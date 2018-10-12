<?php 
 session_start();
 include("lib.php");
 $con=conectar();
 
 $cod_solicitud1=isset($_GET["cod_solicitud"]) ? $_GET["cod_solicitud"]:NULL ;

 $login_web1=$_SESSION['user'];
 

 $login_web="WEB_".$login_web1;
 $so_estado=8;

 
  echo "$cod_solicitud1"."<br>";
  echo "USI_LOGIN: ".$login_web1."<br>";  
  echo "SO_ESTADO: ".$so_estado."<br>";  

$G_sql = "UPDATE SOLICITUD SET USI_LOGIN='$login_web',SO_FECHA=sysdate,SO_ESTADO=$so_estado WHERE COD_SOLICITUD=$cod_solicitud1";


$parsed = oci_parse($con, $G_sql);
oci_execute($parsed) or die("Error al Guardar") ;
echo "<br>".$G_sql;


$G_URL="../pag_php/solicitud.php";
//echo $G_URL;
oci_free_statement($parsed);
oci_close($con);
header("Location: $G_URL");
exit;


?>



