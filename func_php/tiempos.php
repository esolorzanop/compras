<?php
    session_start();
	date_default_timezone_set('America/Guayaquil');
    include("lib.php");
    $con=conectar();
	
	$empresaf="";
    $cliente="";
    $fechai="";
    $fechaf="";
    $estadistico="";
	$empresa="";
    $fecha="";
	
	$empresaf=isset($_GET['txtcodigo']) ? $_GET['txtcodigo']:NULL ;
    $cliente=isset($_GET['txtcodigo2']) ? $_GET['txtcodigo2']:NULL ;
    $fechai=trim(isset($_GET['startdate']) ? $_GET['startdate']:NULL);
    $fechaf=trim(isset($_GET['enddate']) ? $_GET['enddate']:NULL );
    $estadistico=isset($_GET['txtcodigo3']) ? $_GET['txtcodigo3']:NULL ;

	$empresa=$_SESSION["empresa"];//$_GET["empresaf"];
    $fecha=date("d-m-Y");
	
	if ($cliente=="")
	{$cliente=0;
     $condicion="";}
	else
	{$condicion="so.cod_usuario=$cliente and";}

	if ($estadistico=="N1") //novedades en la entrega x ciudad
	{
   	 $nombre="NovedadesCiudad_".$empresa."_".$fecha.".xls";
	 $sql="select decode(clo_razonsocial, null, clo_nombre, clo_razonsocial) cliente, CIU.CI_NOMBRE, to_char(SO_FECHSOLICITA, 'yyyy') anio, to_char(SO_FECHSOLICITA, 'mm') mes, SO_FECHSOLICITA fecha_solicitud, count(*) numero_servicios, decode(NO_DESCRIPCION, null, 'NINGUNA',NO_DESCRIPCION) novedad from solicitud so, cliente_logistica  cl, ciudad ciu, klmtje_logistica kl, usuario_logistica  us, USUARIO_LOGISTICA origen, usuario_logistica destino, logistica_novedad nov, recibo_logistica re where $condicion so.SO_FECHSOLICITA>=to_date('$fechai', 'DD/MM/YYYY') and so.SO_FECHSOLICITA<=to_date('$fechaf', 'DD/MM/YYYY') and so.cod_cliente=$empresaf and so_estado=3 and cl.cod_cliente=so.cod_cliente and ciu.cod_ciudad=so.cod_ciudad and so.COD_KLMTJE=kl.COD_KLMTJE and so.cod_cliente= kl.cod_cliente and us.cod_usuario=kl.cod_usuario and us.cod_cliente=kl.cod_cliente and origen.cod_cliente=kl.cod_cliente and origen.cod_usuario=kl.cod_origen and destino.cod_cliente=kl.cod_cliente and destino.cod_usuario=kl.cod_destino and nov.cod_novedad(+)=so.cod_novedad and re.cod_solicitud = so.cod_solicitud group by decode(NO_DESCRIPCION, null, 'NINGUNA',NO_DESCRIPCION), CIU.CI_NOMBRE, to_char(SO_FECHSOLICITA, 'mm'), to_char(SO_FECHSOLICITA, 'yyyy'), decode(clo_razonsocial, null, clo_nombre, clo_razonsocial), SO_FECHSOLICITA order by ciu.ci_nombre"; //consulta 1   
	   }
	if ($estadistico=="N2") //novedades en la entrega x cliente
	{
   	 $nombre="NovedadesCliente_".$empresa."_".$fecha.".xls";
	 $sql="select decode(clo_razonsocial, null, clo_nombre, clo_razonsocial) cliente, us.ul_nombre, CIU.CI_NOMBRE, to_char(SO_FECHSOLICITA, 'yyyy') anio, to_char(SO_FECHSOLICITA, 'mm') mes, SO_FECHSOLICITA fecha_solicitud, count(*) numero_servicios, decode(NO_DESCRIPCION, null, 'NINGUNA',NO_DESCRIPCION) novedad from solicitud so, cliente_logistica  cl, ciudad ciu, klmtje_logistica kl, usuario_logistica  us, USUARIO_LOGISTICA origen, usuario_logistica destino, logistica_novedad nov, recibo_logistica re where $condicion so.SO_FECHSOLICITA>=to_date('$fechai', 'DD/MM/YYYY') and so.SO_FECHSOLICITA<=to_date('$fechaf', 'DD/MM/YYYY') and so.cod_cliente=$empresaf and so_estado=3 and cl.cod_cliente=so.cod_cliente and ciu.cod_ciudad=so.cod_ciudad and so.COD_KLMTJE=kl.COD_KLMTJE and so.cod_cliente= kl.cod_cliente and us.cod_usuario=kl.cod_usuario and us.cod_cliente=kl.cod_cliente and origen.cod_cliente=kl.cod_cliente and origen.cod_usuario=kl.cod_origen and destino.cod_cliente=kl.cod_cliente and destino.cod_usuario=kl.cod_destino and nov.cod_novedad(+)=so.cod_novedad and re.cod_solicitud = so.cod_solicitud group by  decode(NO_DESCRIPCION, null, 'NINGUNA',NO_DESCRIPCION), us.ul_nombre, CIU.CI_NOMBRE, to_char(SO_FECHSOLICITA, 'mm'), to_char(SO_FECHSOLICITA, 'yyyy'), decode(clo_razonsocial, null, clo_nombre, clo_razonsocial), SO_FECHSOLICITA order by us.ul_nombre"; //consulta 1   	
	   }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if ($estadistico=="N3") //notificaciones tiempo entrega x ciudad
	{  
   	 $nombre="NotificacionTiemposCiudad_".$empresa."_".$fecha.".xls";
	 $sql="select decode(clo_razonsocial, null, clo_nombre, clo_razonsocial) cliente, to_char(SO_FECHSOLICITA, 'yyyy') anio, to_char(SO_FECHSOLICITA, 'mm') mes, ciu.ci_nombre, count(*) numero_servicios, SO_FECHSOLICITA fecha_solicitud, round((decode(SO_FECHAREALLLEGADA, null, SO_FECHAEL , SO_FECHAREALLLEGADA) - SO_FECHSOLICITA) * 24,2) N_HOras_DESDE_SOLICTA, round((decode(RL_HLLEGADAENT, null, SO_FECHAEL , RL_HLLEGADAENT) - SO_FECHAEL) * 24,2) dif_tiempo_hprev_hllega, decode(sign(round((decode(RL_HLLEGADAENT, null, SO_FECHAEL , RL_HLLEGADAENT) - SO_FECHAEL) * 24,2) + 0.4), -1, 'A TIEMPO','FUERA DE HOLGURA') TIPO from solicitud so, cliente_logistica  cl, ciudad ciu, klmtje_logistica kl, usuario_logistica  us, USUARIO_LOGISTICA origen, usuario_logistica destino, logistica_novedad nov, recibo_logistica re where $condicion so.SO_FECHSOLICITA>=to_date('$fechai', 'DD/MM/YYYY') and so.SO_FECHSOLICITA<=to_date('$fechaf', 'DD/MM/YYYY') and so.cod_cliente=$empresaf and so_estado=3 and cl.cod_cliente=so.cod_cliente and ciu.cod_ciudad=so.cod_ciudad and so.COD_KLMTJE=kl.COD_KLMTJE and so.cod_cliente= kl.cod_cliente and us.cod_usuario=kl.cod_usuario and us.cod_cliente=kl.cod_cliente and origen.cod_cliente=kl.cod_cliente and origen.cod_usuario=kl.cod_origen and destino.cod_cliente=kl.cod_cliente and destino.cod_usuario=kl.cod_destino and nov.cod_novedad(+)=so.cod_novedad and re.cod_solicitud = so.cod_solicitud group by CIU.CI_NOMBRE, SO_FECHSOLICITA, decode(SO_FECHAREALLLEGADA, null, SO_FECHAEL, SO_FECHAREALLLEGADA), round((decode(RL_HLLEGADAENT, null, SO_FECHAEL , RL_HLLEGADAENT) - SO_FECHAEL) * 24,2), decode(clo_razonsocial, null, clo_nombre, clo_razonsocial) order by ciu.ci_nombre"; //consulta 1   
	   }
	if ($estadistico=="N4") //notificaciones tiempo entrega x cliente
	{ 
   	 $nombre="NotificacionTiemposCliente_".$empresa."_".$fecha.".xls";
	 $sql="select so.COD_SOLICITUD, re.cod_recibo,decode(clo_razonsocial, null, clo_nombre, clo_razonsocial) cliente, us.ul_nombre, CIU.CI_NOMBRE, count(*) numero_servicios,SO_FECHSOLICITA fecha_solicitud, decode(SO_FECHAREALLLEGADA, null, SO_FECHAEL , SO_FECHAREALLLEGADA) FELLEGADA, round((decode(SO_FECHAREALLLEGADA, null, SO_FECHAEL , SO_FECHAREALLLEGADA) - SO_FECHSOLICITA) * 24,2) N_HOras_DESDE_SOLICTA, round((decode(RL_HLLEGADAENT, null, SO_FECHAEL , RL_HLLEGADAENT) - SO_FECHAEL) * 24,2) dif_tiempo_hprev_hllega, decode(sign(round((decode(RL_HLLEGADAENT, null, SO_FECHAEL , RL_HLLEGADAENT) - SO_FECHAEL) * 24,2) + 0.4), -1, 'A TIEMPO','FUERA DE HOLGURA') TIPO from solicitud so, cliente_logistica  cl, ciudad ciu, klmtje_logistica kl, usuario_logistica  us, USUARIO_LOGISTICA origen, usuario_logistica destino, logistica_novedad nov, recibo_logistica re where $condicion so.SO_FECHSOLICITA>=to_date('$fechai', 'DD/MM/YYYY') and so.SO_FECHSOLICITA<=to_date('$fechaf', 'DD/MM/YYYY') and so.cod_cliente=$empresaf and so_estado=3 and cl.cod_cliente=so.cod_cliente and ciu.cod_ciudad=so.cod_ciudad and so.COD_KLMTJE=kl.COD_KLMTJE and so.cod_cliente= kl.cod_cliente and us.cod_usuario=kl.cod_usuario and us.cod_cliente=kl.cod_cliente and origen.cod_cliente=kl.cod_cliente and origen.cod_usuario=kl.cod_origen and destino.cod_cliente=kl.cod_cliente and destino.cod_usuario=kl.cod_destino and nov.cod_novedad(+)=so.cod_novedad and re.cod_solicitud = so.cod_solicitud and re.cod_solicitud(+)=so.cod_solicitud and re.cod_ciudad(+)=so.cod_ciudad group by so.COD_SOLICITUD, re.cod_recibo, us.ul_nombre,SO_FECHSOLICITA, decode(SO_FECHAREALLLEGADA, null, SO_FECHAEL , SO_FECHAREALLLEGADA), CIU.CI_NOMBRE, round((decode(RL_HLLEGADAENT, null, SO_FECHAEL , RL_HLLEGADAENT) - SO_FECHAEL) * 24,2), decode(clo_razonsocial, null, clo_nombre, clo_razonsocial) order by us.ul_nombre";     
	   }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if ($estadistico=="T1") //tiempo entrega x ciudad
	{
   	 $nombre="TiemposEntrega_Ciudad_".$empresa."_".$fecha.".xls";
	 $sql="select decode(clo_razonsocial, null, clo_nombre, clo_razonsocial) cliente, to_char(SO_FECHSOLICITA, 'yyyy') anio, to_char(SO_FECHSOLICITA, 'mm') mes, CIU.CI_NOMBRE, count(*) n_servicio, avg(round((decode(SO_FECHAREALLLEGADA, null, SO_FECHAEL , SO_FECHAREALLLEGADA) - SO_FECHSOLICITA) * 24,2)) promedio, max(round((decode(SO_FECHAREALLLEGADA, null, SO_FECHAEL , SO_FECHAREALLLEGADA) - SO_FECHSOLICITA) * 24,2)) maximo, min(round((decode(SO_FECHAREALLLEGADA, null, SO_FECHAEL , SO_FECHAREALLLEGADA) - SO_FECHSOLICITA) * 24,2)) minimo from solicitud so, cliente_logistica cl, ciudad ciu, klmtje_logistica kl, usuario_logistica  us, USUARIO_LOGISTICA origen, usuario_logistica destino, recibo_logistica re, logistica_novedad nov where $condicion SO_FECHSOLICITA>=to_date('$fechai', 'DD/MM/YYYY') and SO_FECHSOLICITA<=to_date('$fechaf', 'DD/MM/YYYY') and so.cod_cliente=$empresaf and so_estado=3 and cl.cod_cliente=so.cod_cliente and ciu.cod_ciudad=so.cod_ciudad and so.COD_KLMTJE=kl.COD_KLMTJE and so.cod_cliente= kl.cod_cliente and us.cod_usuario=kl.cod_usuario and us.cod_cliente=kl.cod_cliente and origen.cod_cliente=kl.cod_cliente and origen.cod_usuario=kl.cod_origen and destino.cod_cliente=kl.cod_cliente and destino.cod_usuario=kl.cod_destino and nov.cod_novedad(+)=so.cod_novedad and re.cod_solicitud = so.cod_solicitud group by decode(clo_razonsocial, null, clo_nombre, clo_razonsocial), to_char(SO_FECHSOLICITA, 'yyyy'),  to_char(SO_FECHSOLICITA, 'mm'), CIU.CI_NOMBRE order by ciu.ci_nombre"; //consulta 1   
	   }
	if ($estadistico=="T2") //tiempo entrega x cliente
	{  
   	 $nombre="TiemposEntrega_Cliente_".$empresa."_".$fecha.".xls";
	 $sql="select decode(clo_razonsocial, null, clo_nombre, clo_razonsocial) cliente, ciu.ci_nombre, to_char(SO_FECHSOLICITA, 'yyyy') anio, to_char(SO_FECHSOLICITA, 'mm') mes, us.ul_nombre, count(*) n_servicio, avg(round((decode(SO_FECHAREALLLEGADA, null, SO_FECHAEL , SO_FECHAREALLLEGADA) - SO_FECHSOLICITA) * 24,2)) promedio, max(round((decode(SO_FECHAREALLLEGADA, null, SO_FECHAEL , SO_FECHAREALLLEGADA) - SO_FECHSOLICITA) * 24,2)) maximo, min(round((decode(SO_FECHAREALLLEGADA, null, SO_FECHAEL , SO_FECHAREALLLEGADA) - SO_FECHSOLICITA) * 24,2)) minimo from solicitud so, cliente_logistica  cl, ciudad ciu, klmtje_logistica kl, usuario_logistica  us, USUARIO_LOGISTICA origen, usuario_logistica destino, logistica_novedad nov, RECIBO_LOGISTICA RE where $condicion so.SO_FECHSOLICITA>= to_date('$fechai', 'DD/MM/YYYY') and so.SO_FECHSOLICITA<= to_date('$fechaf', 'DD/MM/YYYY') and so.cod_cliente=$empresaf and so_estado=3 and cl.cod_cliente=so.cod_cliente and ciu.cod_ciudad=so.cod_ciudad and so.COD_KLMTJE=kl.COD_KLMTJE and so.cod_cliente= kl.cod_cliente and us.cod_usuario=kl.cod_usuario and us.cod_cliente=kl.cod_cliente and origen.cod_cliente=kl.cod_cliente and origen.cod_usuario=kl.cod_origen and destino.cod_cliente=kl.cod_cliente and destino.cod_usuario=kl.cod_destino and nov.cod_novedad(+)=so.cod_novedad and re.cod_solicitud = so.cod_solicitud group by decode(clo_razonsocial, null, clo_nombre, clo_razonsocial), to_char(SO_FECHSOLICITA, 'yyyy'), to_char(SO_FECHSOLICITA, 'mm'), us.ul_nombre, ciu.ci_nombre order by us.ul_nombre";	
	   }	 
	 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
    $sqlt="select cliente from($sql)";  //nombre cliente
    $rst=oci_parse($con, $sqlt);
    oci_execute($rst)or die("Ocurrió un error nombre cliente");
    $row = oci_fetch_array($rst, OCI_ASSOC);
    $cli_nom=$row['CLIENTE'];
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if (($estadistico=="N1")||($estadistico=="N2")) //novedades tiempo entrega x cliente
	{ 
	oci_free_statement($rst);
	$sqlt="select sum(numero_servicios) total from($sql)";  //total de solicitud
    $rst=oci_parse($con, $sqlt);
    oci_execute($rst)or die("Ocurrió un error en el total novedades");
    $row = oci_fetch_array($rst, OCI_ASSOC);
    $total=$row['TOTAL'];
	
	oci_free_statement($rst);
	$sqlt="select sum(numero_servicios) totala from($sql) where novedad='NINGUNA'";  //total de solicitud a tiempo
    $rst=oci_parse($con, $sqlt);
    oci_execute($rst)or die("Ocurrió un error en el total novedades2" );
    $row = oci_fetch_array($rst, OCI_ASSOC);
	$tverde=$row['TOTALA'];
	$trojo=$total-$tverde;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if (($estadistico=="N3")||($estadistico=="N4")) //notificaciones tiempo entrega x cliente
	{ 
	oci_free_statement($rst);
	$sqlt="select sum(numero_servicios) total from($sql)";  //total de solicitud
    $rst=oci_parse($con, $sqlt);
    oci_execute($rst)or die("Ocurrió un error en el total notificaciones");
    $row = oci_fetch_array($rst, OCI_ASSOC);
    $total=$row['TOTAL'];
	
	oci_free_statement($rst);
	$sqlt="select sum(numero_servicios) totala from($sql) where tipo='A TIEMPO'";  //total de solicitud a tiempo
    $rst=oci_parse($con, $sqlt);
    oci_execute($rst)or die("Ocurrió un error en el total notificaciones2");
    $row = oci_fetch_array($rst, OCI_ASSOC);
	$tverde=$row['TOTALA'];
	$trojo=$total-$tverde;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if (($estadistico=="T1")||($estadistico=="T2")) //tiempo entrega x cliente
	{  
	oci_free_statement($rst);
	$sqlt="select sum(n_servicio) total, max(round(maximo,2)) maximo, min(round(minimo,2)) minimo, avg(round(promedio,2)) promedio from($sql)";  //total de solicitud
    $rst=oci_parse($con, $sqlt);
    oci_execute($rst)or die("Ocurrió un error en el total tiempo");
    $row = oci_fetch_array($rst, OCI_ASSOC);
    $total=$row['TOTAL'];
    $promedio=$row['PROMEDIO'];
    $maximo=$row['MAXIMO'];
    $minimo=$row['MINIMO'];	
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	

header("Content-type: application/vnd.ms-excel; name=excel");
header("Content-Disposition: attachment; filename=$nombre;");
header("Pragma: no-cache");
header("Expires: 0");
 
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>TEVCOL - SISTEMA DE PEDIDOS WEB</title>

 <link rel="stylesheet" type="text/css" href="../otros/style.css" media="screen" />

<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
.Estilo55 {color: #FFFFFF}
a {
	color:#D0910B;
}
.Estilo56 {
	color: #FFFFFF;
	font-family: Tahoma;
	font-weight: bold;
}
-->
 </style>
</head>
<body>
<div align="center">
    <table width="100%" border="0" align="center">
      <tr>
        <td colspan="9" bgcolor="#070707" height="100"><div align="center"><img src="http://192.168.2.224/sistema_pedidos_web/images/LoginBanner_white.png" alt="TEVCOL - Transportadora Ecuatoriana de Valores" width="450" height="100" /></div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="21" colspan="9"><div align="center"><font color="#000000" size="+2"><strong>TEVCOL Cia. Ltda. - SISTEMA DE SOLICITUDES WEB</strong></font></div></td>
      </tr>
    </table>
    <table width="100%" border="0" align="center">
      <tr>
        <td colspan="3"><strong>Empresa: </strong><?php echo $empresa;?></td>
        <td colspan="3"><strong>Fecha: </strong>
            <?php 	
		$meses = array('0' => '','01' => 'Enero','02' => 'Febrero','03' => 'Marzo','04' => 'Abril','05' => 'Mayo','06' => 'Junio','07' => 'Julio','08' => 'Agosto','09' => 'Septiembre','10' => 'Octubre','11' =>'Noviembre','12' => 'Diciembre');
		$anio=date("Y");
		$mes=date("m");
		$dia=date("d");		  
		 echo $dia."/".$meses[$mes]."/".$anio;	
	?></td>
      </tr>
      <tr>
        <td colspan="3"><strong>Usuario  : </strong><?php echo $_SESSION['user'];?></td>
        <td colspan="3"><strong>Hora :  </strong>
          <?php $hora=date("H:i:s");
	 echo $hora; ?>
        </td>
      </tr>
    </table>
</div>
<hr>
<table border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="">
  <tr>
    <td height="25" colspan="8" bgcolor="#444444" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center"><?php echo $cli_nom; ?> - Informe Estadistico </div></td>
  </tr>
  <tr>
    <td height="25" bgcolor="#444444" ><div align="left" class="date1" style='color:#D0910B'>Fecha Inicial </div></td>
    <td height="25" colspan="2" bgcolor="#626262" class="date1" style="color: #FFFFFF;"><div align="center"><?php echo $fechai; ?></div></td>
    <td height="25" colspan="3" bgcolor="#444444" class="date" style="color: #FFFFFF;"><div align="left" style='color:#D0910B'>Fecha Final </div></td>
    <td height="25" colspan="2" bgcolor="#626262" class="date" style="color: #FFFFFF;"><div align="center"><?php echo $fechaf; ?></div></td>
  </tr>
  <tr>
    <td height="25" bgcolor="#444444" class="date1"><div align="left" style='color:#D0910B'>Total Pedidos </div></td>
    <td height="25" colspan="2" bgcolor="#626262" class="date1" style="color: #FFFFFF;"><div align="center"><?php echo $total; ?></div></td>
    <td height="25" colspan="3" bgcolor="#444444" class="date" style="color: #FFFFFF;"><div align="left" style='color:#D0910B'><?php if (($estadistico=="T1")||($estadistico=="T2")) {?>Tiempo Promedio  Entrega <?php } ?></div></td>
    <td height="25" colspan="2" bgcolor="#626262" class="date" style="color: #FFFFFF;"><div align="center"><?php if (($estadistico=="T1")||($estadistico=="T2")) { printf("%.2f", $promedio); }?></div></td>
  </tr>
 <?php if (($estadistico=="T1")||($estadistico=="T2")) {?>
  <tr>
    <td height="25" bgcolor="#444444" class="date1"><div align="left" style='color:#D0910B'>Tiempo Max.  Entrega </div></td>
    <td height="25" colspan="2" bgcolor="#626262" class="date1" style="color: #FFFFFF;"><div align="center"><?php printf("%.2f", $maximo); ?></div></td>
    <td height="25" colspan="3" bgcolor="#444444" class="date" style="color: #FFFFFF;"><div align="left" style='color:#D0910B'>Tiempo Min.  Entrega </div></td>
    <td height="25" colspan="2" bgcolor="#626262" class="date" style="color: #FFFFFF;"><div align="center"><?php printf("%.2f", $minimo); ?></div></td>
  </tr>
  <?php }   if (($estadistico=="N1")||($estadistico=="N2")) {?>
  <tr>
    <td height="25" bgcolor="#444444" class="date1"><div align="left" style='color:#D0910B'>Pedidos Sin Novedad </div></td>
    <td height="25" colspan="2" bgcolor="#626262" class="date1" style="color: #FFFFFF;"><div align="center"><?php echo $tverde; ?></div></td>
    <td height="25" colspan="3" bgcolor="#444444" class="date" style="color: #FFFFFF;"><div align="left" style='color:#D0910B'>
      <div align="left" style='color:#D0910B'>Pedidos Con Novedad</div>
    </div></td>
    <td height="25" colspan="2" bgcolor="#626262" class="date" style="color: #FFFFFF;"><div align="center">
      <div align="center"><?php echo $trojo; ?></div>
    </div></td>
  </tr>
  <?php }   if (($estadistico=="N3")||($estadistico=="N4")) {?>
  <tr>
    <td height="25" bgcolor="#444444" class="date1"><div align="left" style='color:#D0910B'>Pedidos a Tiempo </div></td>
    <td height="25" colspan="2" bgcolor="#626262" class="date1" style="color: #FFFFFF;"><div align="center"><?php echo $tverde; ?></div></td>
    <td height="25" colspan="3" bgcolor="#444444" class="date" style="color: #FFFFFF;"><div align="left" style='color:#D0910B'>
      <div align="left" style='color:#D0910B'>Pedidos Fuera Holgura</div>
    </div></td>
    <td height="25" colspan="2" bgcolor="#626262" class="date" style="color: #FFFFFF;"><div align="center">
      <div align="center"><?php echo $trojo; ?></div>
    </div></td>
  </tr>
   <?php }?>

</table> 
<?php if(($estadistico=="N1")||($estadistico=="N2")){?>
<hr>
<table border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="">
  <tr>
    <td height="25" colspan="8" bgcolor="#444444" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center">Novedades en Entregas Solicitudes Despachadas</div></td>
  </tr>  
  <tr>    
    <?php if($estadistico=="N2"){?>
	<td height="25" bgcolor="#626262" class="date" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center">CLIENTE</div></td>
	<?php } else {?>
	<td height="25" bgcolor="#626262" class="date" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center"></div></td>
	<?php } ?>
    <td height="25" bgcolor="#626262" class="date" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center">CIUDAD</div></td>
	<td height="25" bgcolor="#626262" class="date" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center">A&Ntilde;O</div></td>
    <td height="25" bgcolor="#626262" class="date" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center">MES</div></td>	
    <td height="25" bgcolor="#626262" class="date" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center">F. SOLICITUD</div></td>	
    <td height="25" bgcolor="#626262" class="date" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center"># SERVICIOS</div></td>		
    <td height="25" bgcolor="#626262" class="date" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center">NOVEDAD</div></td>				
	<td height="25" bgcolor="#626262" class="date" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center"></div></td>
  </tr>
  <?php	      			     
				     oci_free_statement($rst);
					 $rst = oci_parse($con, $sql);
					 oci_execute($rst)or die("Ocurrio un error ");
					 while ($row = oci_fetch_array($rst, OCI_ASSOC)) 
						{					
     if($estadistico=="N2"){
		   echo "<td height=25 bgcolor=#444444  class=date2><div align=left style='color: #D0910B; font-family: Tahoma;'>".$row['UL_NOMBRE']."</div></td>";	 	           
	 } else {
	       echo "<td height=25 bgcolor=#444444  class=date2><div align=left style='color: #D0910B; font-family: Tahoma;'></div></td>";	 	           
	 } 
				   echo "<td height=25 bgcolor=#FFFFFF  class=date2><div align=center>".$row['CI_NOMBRE']."</div></td>
				         <td height=25 bgcolor=#FFFFFF  class=date2><div align=center>".$row['ANIO']."</div></td>	 	        
		                 <td height=25 bgcolor=#FFFFFF  class=date2><div align=center>".$row['MES']."</div></td>					 
				         <td height=25 bgcolor=#FFFFFF  class=date2><div align=center>".$row['FECHA_SOLICITUD']."</div></td>		   
				         <td height=25 bgcolor=#FFFFFF  class=date2><div align=center>".$row['NUMERO_SERVICIOS']."</div></td>";
			if ($row['NOVEDAD']=="NINGUNA")  //semaforo verde
		      {
			  echo "<td bgcolor=#00FF00  class=date2><div align=center style='color: #FFFFFF; font-family: Tahoma; font-weight: bold;'>".$row['NOVEDAD']."</div></td>";
			  }else
		      {
			  echo "<td bgcolor=#FF0000  class=date2><div align=center style='color: #FFFFFF; font-family: Tahoma; font-weight: bold;'>".$row['NOVEDAD']."</div></td>";
			  }			  
            echo "<td height=25 bgcolor=#FFFFFF  class=date2></td>";
            echo "</tr> \n";
		            }										
		 ?>
</table>
<?php } ?>
<hr />
<?php if(($estadistico=="N3")||($estadistico=="N4")){?>
<hr>
<table border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="">
  <tr>
    <td height="25" colspan="9" bgcolor="#444444" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center">Notificaciones Tiempos de Entrega en Solicitudes Despachadas</div></td>
  </tr>  
  <tr>    
    <?php if($estadistico=="N4"){?>
	<td height="25" bgcolor="#626262" class="date" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center">CLIENTE</div></td>
	<td height="25" bgcolor="#626262" class="date" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center">N. SOLICITUD</div></td>
	<td height="25" bgcolor="#626262" class="date" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center">N. RECIBO</div></td>    
	<?php } else {?>
	<td height="25" bgcolor="#626262" class="date" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center">A&Ntilde;O</div></td>
    <td height="25" bgcolor="#626262" class="date" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center">MES</div></td>	
	<?php } ?>
    <td height="25" bgcolor="#626262" class="date" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center">CIUDAD</div></td>
    <td height="25" bgcolor="#626262" class="date" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center"># SERVICIOS</div></td>	
    <td height="25" bgcolor="#626262" class="date" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center">F. SOLICITUD</div></td>	
    <td height="25" bgcolor="#626262" class="date" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center">H. D. SOLICITUD</div></td>		
    <td height="25" bgcolor="#626262" class="date" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center">DIF. H. P. LLEGADA</div></td>		
    <td height="25" bgcolor="#626262" class="date" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center">NOTIFICACION</div></td>				
  </tr>
  <?php	      			     
					 oci_free_statement($rst);
					 $rst = oci_parse($con, $sql);
					 oci_execute($rst)or die("Ocurrio un error ");
					 while ($row = oci_fetch_array($rst, OCI_ASSOC)) 					
						{					
		        if($estadistico=="N4"){				   
				   echo "<td height=25 bgcolor=#444444  class=date2><div align=left style='color: #D0910B; font-family: Tahoma;'>".$row['UL_NOMBRE']."</div></td>	 	        
		                 <td height=25 bgcolor=#FFFFFF  class=date2><div align=center>".$row['COD_SOLICITUD']."</div></td>
		                 <td height=25 bgcolor=#FFFFFF  class=date2><div align=center>".$row['COD_RECIBO']."</div></td>";						
				 } else {
				   echo "<td height=25 bgcolor=#444444  class=date2><div align=center style='color: #D0910B; font-family: Tahoma;'>".$row['ANIO']."</div></td>	 	        
		                 <td height=25 bgcolor=#FFFFFF  class=date2><div align=center>".$row['MES']."</div></td>";
				 }
           echo"<td height=25 bgcolor=#FFFFFF  class=date2><div align=center>".$row['CI_NOMBRE']."</div></td>
           <td height=25 bgcolor=#FFFFFF  class=date2><div align=center>".$row['NUMERO_SERVICIOS']."</div></td>		   
           <td height=25 bgcolor=#FFFFFF  class=date2><div align=center>".$row['FECHA_SOLICITUD']."</div></td>";
           printf("<td height=25 bgcolor=#FFFFFF  class=date2><div align=center>%.2f</div></td>",$row['N_HORAS_DESDE_SOLICTA']);
           printf("<td height=25 bgcolor=#FFFFFF  class=date2><div align=center>%.2f</div></td>",$row['DIF_TIEMPO_HPREV_HLLEGA']);
			if ($row['TIPO']=="A TIEMPO")  //semaforo verde
		      {
			  echo "<td bgcolor=#00FF00  class=date2><div align=center style='color: #FFFFFF; font-family: Tahoma; font-weight: bold;'>".$row['TIPO']."</div></td>";
			  }else
		      {
			  echo "<td bgcolor=#FF0000  class=date2><div align=center style='color: #FFFFFF; font-family: Tahoma; font-weight: bold;'>".$row['TIPO']."</div></td>";
			  }			  
            echo "</tr> \n";
		            }										
		 ?>
</table>
<?php } ?>
<hr />
<?php if(($estadistico=="T1")||($estadistico=="T2")){?>
<hr>
<table border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="">
  <tr>
    <td height="25" colspan="8" bgcolor="#444444" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center">Tiempos de Entrega en Solicitudes Despachadas</div></td>
  </tr>  
  <tr>    
    <?php if($estadistico=="T2"){?>
	<td height="25" bgcolor="#626262" class="date" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center">CLIENTE</div></td>
	<?php } else {?>
	<td height="25" bgcolor="#626262" class="date" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center"></div></td>
	<?php } ?>
	<td height="25" bgcolor="#626262" class="date" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center">CIUDAD</div></td>
    <td height="25" bgcolor="#626262" class="date" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center">MES</div></td>
    <td height="25" bgcolor="#626262" class="date" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center">A&Ntilde;O</div></td>	
    <td height="25" bgcolor="#626262" class="date" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center"># SERVICIOS </div></td>	
    <td height="25" bgcolor="#626262" class="date" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center">T. M&Aacute;XIMO </div></td>		
    <td height="25" bgcolor="#626262" class="date" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center">T. MINIMO </div></td>		
    <td height="25" bgcolor="#626262" class="date" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center">T. PROMEDIO </div></td>				
  </tr>
  <?php	      			     
					 oci_free_statement($rst);
					 $rst = oci_parse($con, $sql);
					 oci_execute($rst)or die("Ocurrio un error ");
					 while ($row = oci_fetch_array($rst, OCI_ASSOC)) 
						{					
     if($estadistico=="T2"){
		   echo "<td height=25 bgcolor=#444444  class=date2><div align=left style='color: #D0910B; font-family: Tahoma;'>".$row['UL_NOMBRE']."</div></td>";	 	           
	 } else {
	       echo "<td height=25 bgcolor=#444444  class=date2><div align=left style='color: #D0910B; font-family: Tahoma;'></div></td>";	 	           
	 }
	       echo"<td height=25 bgcolor=#FFFFFF  class=date2><div align=center>".$row['CI_NOMBRE']."</div></td>
           <td height=25 bgcolor=#FFFFFF  class=date2><div align=center>".$row['MES']."</div></td>
           <td height=25 bgcolor=#FFFFFF  class=date2><div align=center>".$row['ANIO']."</div></td>		   
           <td height=25 bgcolor=#FFFFFF  class=date2><div align=center>".$row['N_SERVICIO']."</div></td>";
           printf("<td height=25 bgcolor=#FFFFFF  class=date2><div align=center>%.2f</div></td>",$row['MAXIMO']);
           printf("<td height=25 bgcolor=#FFFFFF  class=date2><div align=center>%.2f</div></td>",$row['MINIMO']);
           printf("<td height=25 bgcolor=#FFFFFF  class=date2><div align=center>%.2f</div></td>",$row['PROMEDIO']);
            echo "</tr> \n";
		            }										
		 ?>
</table>
<hr />
<?php } ?>
<table width="100%" border="0" align="center">
  <tr>
    <td height="25" colspan="9">
<?php
					 $nombre=$_SESSION['user'];
					 $sql2="select WEB_NOMBRE_USUARIO from usuario_web WHERE WEB_LOGIN LIKE '%$nombre%'";
					 $rst1 = oci_parse($con, $sql2);
					 oci_execute($rst1)or die("Ocurrió un error nombre usuario web");
					 $row1 = oci_fetch_array($rst1, OCI_ASSOC);
?>
      <div align="center"><strong><?php echo $row1['WEB_NOMBRE_USUARIO']; ?></strong><br />
      <strong>Nombre </strong>      </div></td>
  </tr>
  <tr>
    <td height="25" colspan="9" bgcolor="#070707"></td>
  </tr>
</table>
<?php 
oci_free_statement($rst);
oci_free_statement($rst1);
oci_close($con);
?>
</body>
</html>
