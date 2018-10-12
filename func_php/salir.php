<?php 
   include("lib.php");
   $con=conectar();
	session_start();
	
   //if(isset($_SESSION['user'])) 
   //{ 
				//$usuario=$_SESSION['user'];
				//$sqll="update LOGIN set COD_NIVEL=0 where LOGIN='$usuario'";
				//$rst = oci_parse($con, $sqll);
				//oci_execute($rst) or die("Ocurrió un error sesion");				
  			    //oci_free_statement($rst);
				//oci_close($con);		
	
	//unset($_SESSION['user']); 
	//unset($_SESSION['cod_user']); 	
	
	session_destroy();	
	$URL="../pag_php/login.php?num=50";
//	header("Location:$URL");
//	exit;
	echo "<script>window.parent.location.href = '$URL';</script>";
	
	//}  
?>
