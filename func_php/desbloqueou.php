<?php 
   include("lib.php");
   $con=conectar();
   $usuario=strtoupper(isset($_REQUEST["usuario"]) ? $_REQUEST["usuario"]:NULL);
   $passwd=isset($_REQUEST["passwd1"]) ? $_REQUEST["passwd1"]:NULL;
   if ($usuario!="")
   {
				$sqll="update login set WEB_SESION=0 where WEB_LOGIN='$login' and WEB_CLAVE='$clave'";
				$rst = oci_parse($con, $sqll);
				oci_execute($rst) or die("Ocurrió un error sesion");		
	            $URL="../pag_php/login.php?num=10";
	}else
	     {
          $URL="../pag_php/login.php";
		 }		
    oci_close($con);						
	header("Location: $URL");
	exit;
      ?>
