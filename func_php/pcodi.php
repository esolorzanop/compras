<?php
    session_start();
if (($codigo=isset($_GET["codigo"]) ? $_GET["codigo"]:NULL)!="") {
   	$_SESSION['codigo']=$codigo;
	echo "<br>codigo=".$_SESSION['codigo'];
}
if (($codigo2=isset($_GET["codigo2"]) ? $_GET["codigo2"]:NULL)!="") {
   	$_SESSION['codigo2']=$codigo2;
		echo "<br>codigo2=".$_SESSION['codigo2'];
} 
if (($codigo4=isset($_GET["codigo4"]) ? $_GET["codigo4"]:NULL)!="") 
	{
	  $_SESSION['codb_cliente']=$codigo4;
	  	echo "<br>codigocliente=".$_SESSION['codb_cliente'];	
	}
	
//	echo $_SESSION['codciudad'];

?>