<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<?php
 $wlogin="SA";
 $wclave="sa";
// $nwclave="";
 $nwclave=(md5($wclave+5));
 $fecha=date("Y-m-d");
 include("lib.php");
 $con=conectar();

 $sql="Select * from usuario_web where web_login='$wlogin' and WEB_CLAVE='$nwclave'";
 $rst = OCIParse($con, $sql);
 OCIExecute($rst) or die("Ocurrió un error al ejecutar el query1...");
  			$num_filas=0;
				 while(OCIFetchInto ($rst, $row, OCI_ASSOC))
  				 {
				 $num_filas++;
				 } 
	if($num_filas != 0)
	{    
       $URL="../pag_php/cambclave.php?num=1";
	    OCILogOff($con);
	}
else{
 $sql="update USUARIO_WEB set WEB_CLAVE='$nwclave', WEB_FCCLAVE=TO_DATE('$fecha', 'YYYY/MM/DD') where WEB_LOGIN='$wlogin' and WEB_CLAVE='$wclave'";
 $rst = OCIParse($con, $sql);
 OCIExecute($rst) or die("Ocurrió un error al cambiar su clave");
 
$sql="Select * from usuario_web where web_login='$wlogin' and WEB_CLAVE='$nwclave'";
 $rst = OCIParse($con, $sql);
 OCIExecute($rst) or die("Ocurrió un error al ejecutar el query2...");
  			$num_filas=0;
				 while(OCIFetchInto ($rst, $row, OCI_ASSOC))
  				 {
				 $num_filas++;
				 } 
	if($num_filas == 0)
	{    
       echo "fracaso";
	    OCILogOff($con);
	}else{
 	   echo "exito";
	    OCILogOff($con);
          }
   }

 ?>
</body>
</html>
