<?php 
 date_default_timezone_set('America/Guayaquil');
 $cod_solicitud1=isset($_GET["cod_solicitud"]) ? $_GET["cod_solicitud"]:NULL ;
 $ban=isset($_GET["ban"]) ? $_GET["ban"]:NULL ;
 $cod_usuariow=isset($_GET["cod_usuariow"]) ? $_GET["cod_usuariow"]:NULL ;
 $cargo=isset($_GET["cargo"]) ? $_GET["cargo"]:NULL ;
 $usuario=isset($_GET["clienteo2"]) ? $_GET["clienteo2"]:NULL ;
// $cod_ciudad=$_GET["ruta"];
 $cod_rutafac=isset($_GET["ruta"]) ? $_GET["ruta"]:NULL ;
 $tonelaje=isset($_GET["tonelaje"]) ? $_GET["tonelaje"]:NULL ;
 $valor= str_replace(",","",isset($_GET["valor"]) ? $_GET["valor"]:NULL);
 $observacion=trim(isset($_GET["observacion"]) ? $_GET["observacion"]:NULL);
 $fecha_pedido=isset($_GET["fecha"]) ? $_GET["fecha"]:NULL;
 $login_web1=isset($_GET["usuario"]) ? $_GET["usuario"]:NULL;
 //$empresa=$_GET["empresa"];
 
 include("lib.php");
 					 $con=conectar();
					 $sqll="select * from usuario_web where web_login='$login_web1'";
					 $rst = oci_parse($con, $sqll);
					 oci_execute($rst)or die("Ocurrió un error ");
					 $row = oci_fetch_array($rst, OCI_ASSOC); 
 
 $login_web="WEB_".$login_web1;
 $nombrec_usrweb=$row['WEB_NOMBRE_USUARIO'];
 $cod_cliente=isset($_GET["codempresa"]) ? $_GET["codempresa"]:NULL;//$row[COD_CLIENTE];
 $so_observacionweb=$observacion;	  
 $cod_usuario=$usuario;

 					 oci_free_statement($rst);
					 $sql="select MAX(COD_SOLICITUD) from SOLICITUD";
					 $rst = oci_parse($con, $sql);
					 oci_execute($rst)or die("Ocurrió un error ");
					 $rowc = oci_fetch_array($rst, OCI_ASSOC); 					 

 $cod_solicitud=$rowc['MAX(COD_SOLICITUD)'];
 $cod_solicitud=$cod_solicitud+1;

 					 oci_free_statement($rst);
					 $sql="select  ul.cod_cliente from usuario_logistica ul where ul.COD_USUARIO=$cod_usuario";
					 $rst = oci_parse($con, $sql);
					 oci_execute($rst)or die("Ocurrió un error ");
					 $rowc = oci_fetch_array($rst, OCI_ASSOC); 					 					 

 $cod_ciudad=isset($_GET["cod_centro"]) ? $_GET["cod_centro"]:NULL;

 $fecha=date("Y-m-d");
 $hora=date("h:i:s");
 $fecha=$fecha." ".$hora;
 $cod_klmtje=isset($_GET["cod_klmtje"]) ? $_GET["cod_klmtje"]:NULL;
// $cod_cliente=$rowc[COD_CLIENTE];
 $so_estado=1;

 

  echo "$cod_solicitud1";
  echo "USI_LOGIN: ".$login_web."<br>";
  echo "SO_FECHA: ".$fecha."<br>";
  echo "COD_KLMTJE: ".$cod_klmtje."<br>";
  echo "SO_SOLICITA: ".$nombrec_usrweb."<br>";
  echo "COD_CLIENTE: ".$cod_cliente."<br>";
  echo "SO_ESTADO: ".$so_estado."<br>";
  echo "SO_FECHSOLICITA: ".$fecha_pedido."<br>";
  echo "SO_TONELAJE: ".$tonelaje."<br>";
  echo "COD_RUTAFAC: ".$cod_rutafac."<br>";
  echo "SO_OBSERVACIONWEB: ".$so_observacionweb."<br>";	  
  echo "SO_VALOR:".$valor."<br>";
  echo "COD_USUARIO:".$cod_usuario."<br>";
  

 
if ($ban!='U') //ingreso nueva solicitud
{
$G_sql = "INSERT INTO SOLICITUD(COD_SOLICITUD,USI_LOGIN,SO_FECHA,COD_KLMTJE,SO_SOLICITA,COD_CLIENTE,SO_ESTADO,COD_CIUDAD,SO_FECHSOLICITA,SO_SOLTNLJE,COD_RUTAFAC,SO_OBSERVACIONWEB,SO_VALOR,COD_USUARIO) VALUES(COD_SOLICITUD.NEXTVAL,'$login_web',sysdate,'$cod_klmtje','$nombrec_usrweb',$cod_cliente,$so_estado,$cod_ciudad,to_date('$fecha_pedido','dd/mm/yyyy'),$tonelaje,'$cod_rutafac','$so_observacionweb',$valor,$cod_usuario)";
}
else // modificacion de solicitud existente
{
$G_sql = "UPDATE SOLICITUD SET SO_FECHA=sysdate,SO_FECHSOLICITA=to_date('$fecha_pedido','dd/mm/yyyy'),SO_SOLTNLJE=$tonelaje,COD_RUTAFAC='$cod_rutafac',SO_OBSERVACIONWEB='$so_observacionweb',SO_VALOR=$valor WHERE COD_SOLICITUD='$cod_solicitud1'";// and SO_ESTADO=$so_estado";
}
echo $G_sql;

$parsed = oci_parse($con, $G_sql);
oci_execute($parsed) or die("Error al Guardar");


//$G_URL="../pag_php/solicitud.php?nombre=$login_web1&cod_user=$cod_usuariow&cargo=$cargo&empresa=$empresa";
$G_URL="../pag_php/solicitud.php";

    oci_free_statement($rst);
    oci_free_statement($parsed);	
	oci_close($con);
header("Location: $G_URL");
exit;


?>



