<?php 
 session_start();

 include("lib.php");
 require_once("funpass.php");

// $cod_user=$_SESSION['cod_user'];

 date_default_timezone_set('America/Guayaquil');
 
// $wlogin=isset($_SESSION['cod_user']) ? $_SESSION['cod_user']:NULL;

 $wlogin=isset($_REQUEST["codusuario2"]) ? $_REQUEST["codusuario2"]:NULL;
 $wclave=strtoupper(isset($_REQUEST["clave"]) ? $_REQUEST["clave"]:NULL);
 $nwclave=strtoupper(isset($_REQUEST["nclave"]) ? $_REQUEST["nclave"]:NULL);

		 $salt = $_SESSION['user'].$wlogin;

		 $wclave = str2hex(rc4($salt, $wclave));		 
		 $nwclave = str2hex(rc4($salt, $nwclave));
 
 $con=conectar();

 $sql="select * from login where cod_login='$wlogin' and lo_password='$nwclave'";
 $rst = oci_parse($con, $sql);
 oci_execute($rst) or die("Ocurrió un error al ejecutar el query1...");
  			$num_filas=0;
				 while($row = oci_fetch_array($rst, OCI_ASSOC))
  				 {
				 $num_filas++;
				 } 
				 
	if($num_filas != 0)
	{    
       $URL="../pag_php/inicontenido.php?num=1&codusuario2=$wlogin";
		oci_free_statement($rst);
	}
else{
	
$sql="update login set lo_password='$nwclave', lo_cambio_pswd=sysdate where cod_login='$wlogin' and lo_password='$wclave'";
//echo $sql;
 $rst = oci_parse($con, $sql);
 oci_execute($rst) or die("Ocurrió un error al cambiar su clave");
 oci_free_statement($rst);

$sql="select * from login where cod_login='$wlogin' and lo_password='$nwclave'";
 $rst = oci_parse($con, $sql);
 oci_execute($rst) or die("Ocurrió un error al ejecutar el query2...");
  			$num_filas=0;
				 while($row = oci_fetch_array($rst, OCI_ASSOC))
  				 {
				 $num_filas++;
				 } 
	if($num_filas == 0)
	{    
       $URL="../pag_php/inicontenido.php?num=4&codusuario2=$wlogin";	   
	}else{
	    $URL="../pag_php/inicontenido.php?num=5&codusuario2=$wlogin";    /// clave cambiada con exito
          }
   }
 oci_free_statement($rst);
 oci_close($con);
 header("Location: $URL");
 exit;
?>