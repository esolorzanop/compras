<?php 
// $cod_usuariow;;     codigo de usuario web
 $web_login=strtoupper(isset($_GET["login"]) ? $_GET["login"]:NULL);
 $web_clave=isset($_GET["login"]) ? $_GET["clave"]:NULL;
// $web_fcclave;      cambio de clave
// $web_fecingreso;   cuando ingresa al sistema
 $cod_cliente=isset($_GET["codusuario"]) ? $_GET["codusuario"]:NULL;
 $web_nombre_usuario=strtoupper(isset($_GET["nomyape"]) ? $_GET["nomyape"]:NULL);
 $web_correo=isset($_GET["correo"]) ? $_GET["correo"]:NULL;  
 $web_cargo=isset($_GET["cargo"]) ? $_GET["cargo"]:NULL;
 $cod_supervisor=isset($_GET["codsupervisor"]) ? $_GET["codsupervisor"]:NULL;  
 
 // $cod_usuariow;;     codigo de usuario web
 echo $web_login."<br>";
 echo $web_clave."<br>";
// $web_fcclave;      cambio de clave
// $web_fecingreso;   cuando ingresa al sistema
 echo $cod_cliente."<br>";
 echo $web_nombre_usuario."<br>";
 echo $web_correo."<br>";  
 echo $web_cargo."<br>";
 echo $cod_supervisor."<br>";  
 
 include("lib.php");
 $con=conectar();
 $sql="Select * from usuario_web where web_login='$web_login'";
 $rst = oci_parse($con, $sql);
 oci_execute($rst) or die("Ocurrió un error al ejecutar el query1...");
  			$num_filas=0;
				 while($row = oci_fetch_array($rst, OCI_ASSOC))
  				 {
				 $num_filas++;
				 } 
	oci_free_statement($rst); 
	if($num_filas == 0)
	{    
	       echo "registro no repetido";	
           if($cod_supervisor==0)
		   {
		   $sql="INSERT INTO USUARIO_WEB(COD_USUARIOW,WEB_LOGIN,WEB_CLAVE,WEB_FCCLAVE,WEB_FECINGRESO,COD_CLIENTE,WEB_NOMBRE_USUARIO,WEB_CORREO,WEB_CARGO,COD_SUPERVISORW) 
VALUES(COD_USUARIOW.NEXTVAL,'$web_login','$web_clave',sysdate,sysdate,$cod_cliente,'$web_nombre_usuario','$web_correo','$web_cargo',COD_USUARIOW.NEXTVAL)";
		    }else{
			$sql="INSERT INTO USUARIO_WEB(COD_USUARIOW,WEB_LOGIN,WEB_CLAVE,WEB_FCCLAVE,WEB_FECINGRESO,COD_CLIENTE,WEB_NOMBRE_USUARIO,WEB_CORREO,WEB_CARGO,COD_SUPERVISORW)
VALUES(COD_USUARIOW.NEXTVAL,'$web_login','$web_clave',sysdate,sysdate,$cod_cliente,'$web_nombre_usuario','$web_correo','$web_cargo',$cod_supervisor)";
			       }
   			       $rst = oci_parse($con, $sql);
				   oci_execute($rst) or die("Ocurrió un error al guardar nuevo usuario...");
				   $URL="../pag_php/nusuario.php?num=2";
	}
	else
	{
       $URL="../pag_php/nusuario.php?num=4";
		}
oci_close($con); 
header("Location: $URL");
exit;

?>