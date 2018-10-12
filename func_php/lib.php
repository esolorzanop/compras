<?php

// ESTA FUNCION NOS SIRVE PARA REALIZAR LA CONEXION AL SERVIDOR Y SELECCIONAR LA BASE DE DATOS A TRABAJAR
// CUALQUIER PAGINA QUE NECESITE CONECTARSE SOLO NECESITA LLAMAR A ESTA FUNCION Y MANDARLE COMO PARAMETROS
// -- EL NOMBRE DEL SERVIDOR Y EL NOMBRE DE LA BASE DE DATOS A TRABAJAR
function conectar()
{
	$username = "REQ";
	$passwd = "PRUEBAS";//"800300";

	$db="(DESCRIPTION= (ADDRESS_LIST= (ADDRESS=(PROTOCOL=TCP) (HOST=192.168.1.114) (PORT=1521) ) ) (CONNECT_DATA=(SID=db11g)) )"; //pruebas

//	$db = "(DESCRIPTION = (ADDRESS_LIST = (FAILOVER = on)(LOAD_BALANCE = on)(SOURCE_ROUTE = off)(ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.1.17)(PORT = 1521))(ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.1.18)(PORT = 1521)))(CONNECT_DATA = (SERVER = dedicated)(SERVICE_NAME = GLTEVRAC)))";
	$con = oci_connect($username,$passwd,$db) or die (ocierror());
	return $con;
}

function getRealIP() {
if (!empty($_SERVER['HTTP_CLIENT_IP']))
return $_SERVER['HTTP_CLIENT_IP'];

if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
return $_SERVER['HTTP_X_FORWARDED_FOR'];

return $_SERVER['REMOTE_ADDR'];
}

  function returnMacAddress() {
        $ip = getRealIP();
		$mac_string = shell_exec("arp -a $ip");
		$mac_array = explode(" ",$mac_string);
		$mac = $mac_array[3];
		return $mac;
     }
?>