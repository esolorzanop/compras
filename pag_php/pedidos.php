<?php
    	session_start();
		$cod_user=$_SESSION['cod_user'];
		$user=$_SESSION['user'];
////////////////////////// paginacion//////////////////////////////////
		 $contador=0;
		 $pagina=0;
		 $pagina=isset($_GET["pagina"]) ? $_GET["pagina"]:NULL;
		 $registros = 12;
		 if (!$pagina) 
		 { 
          $inicio = 0; 
          $pagina = 1; 
		 }	 
			else { 
    		$inicio = ($pagina - 1) * $registros; 
			} 
			
/////////////////////////////////////////////////////////////////////
    include("../func_php/lib.php");
	$con=conectar();
	
	$actu=isset($_REQUEST["ban"]) ? $_REQUEST["ban"]:0;
	$cod_item=isset($_GET['cod_pedido']) ? $_GET['cod_pedido']:NULL ;
    $cod_cotiza=isset($_GET['cod_cotiza']) ? $_GET['cod_cotiza']:NULL ;
	
	if($actu==2){ // aprobar cotizacion
		$hql= "select co_subtotal from cotizacion where cotizacion.COD_COTIZACION=$cod_cotiza"; //subtotal de la cotizacion
		$stid = oci_parse($con,$hql);
		oci_execute($stid, OCI_DEFAULT);
		$row = oci_fetch_array($stid, OCI_ASSOC);
		$subtotal=$row['CO_SUBTOTAL'];

	    oci_free_statement($stid);
		$hql= "SELECT nivel.cod_nivel, NIVEL.NI_VALINICIAL, NIVEL.NI_VALFINAL FROM NIVEL, FUNCION WHERE NIVEL.COD_NIVEL = FUNCION.COD_NIVEL AND FUNCION.COD_FUNCION = (SELECT lg.COD_FUNCION funcion FROM LOGIN lg WHERE lg.COD_LOGIN=$cod_user)"; //valores que puede aprobar el usuario
		$stid = oci_parse($con,$hql);
		oci_execute($stid, OCI_DEFAULT);
		$row = oci_fetch_array($stid, OCI_ASSOC);
		$valinicial=$row['NI_VALINICIAL'];
		$valfinal=$row['NI_VALFINAL'];
		$codnivel=$row['COD_NIVEL'];
  		  	
	    if ($subtotal<=$valfinal)//(($subtotal>=$valinicial)and($subtotal<=$valfinal))
		{  // si esta dentro del rango permitido para el usuario entonces autoriza
		 oci_free_statement($stid);
		 $hql= "UPDATE COTIZACION SET COTIZACION.CO_ESTADO = 6, COTIZACION.CO_APROBADA = 1, COTIZACION.COD_NIVEL_APROBACION=$codnivel, COTIZACION.COD_LOGIN_APRUEBA=$cod_user, COTIZACION.NI_VALINICIAL=$valinicial,COTIZACION.NI_VALFINAL=$valfinal, COTIZACION.CO_OBSERVACIONESAP='".$_SESSION['obsap']."' WHERE COTIZACION.COD_COTIZACION = $cod_cotiza";
		 $stid = oci_parse($con,$hql);
		 oci_execute($stid, OCI_DEFAULT);
		 oci_commit($con);
		 
		 $hqlh= "INSERT INTO HISTORIAL (HI_FECHA, COD_LOGIN, LO_USERNAME, HI_CODIGO, COD_TIPO, COD_ESTADO) VALUES (sysdate, $cod_user, (select lo_username from login where cod_login=$cod_user),  $cod_cotiza,3,6)";
		 $stidh = oci_parse($con,$hqlh);
		 oci_execute($stidh, OCI_DEFAULT);
		 oci_commit($con);	 
		 
		 $valor="";
		// echo $hql;
		}
		else{$valor="noautorizado";}
	}	
/////////////////////////////////////////////
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>TEVCOL - SISTEMA DE COMPRAS</title>

<script language="JavaScript" type="text/JavaScript">
<!--
	if(top==self) top.location="../pag_php/tevcol.php";
   	parent.document.getElementById("headerpic").style.height="90px";	
   	parent.document.getElementById("header").style.height="90px";
	parent.document.getElementById("icentro").style.height="850px";	

	function nuevop(){     	
	document.getElementById('autorizado').value="<?php echo $valor; ?>";
		if(document.getElementById('autorizado').value=="noautorizado")
		{
			var coti=<?php echo isset($cod_cotiza) ? $cod_cotiza:0; ?>;
			alert("Atención \nEl usuario actual no tiene el nivel de aprobación suficiente para la cotización "+ coti +"\nPor favor verifique e intente de nuevo");}
	}

	function enviar(){			
		document.autorizacion.action="autorizacion.php";
		document.autorizacion.submit();
								
    }
	function enviar2(pag){     	
		if(pag >= 26)
		{alert("Atención!\nDebido al volumen del resultado en su consulta, esta información será exportada directamente a un archivo de Excel");}
		//document.autorizacion.action="../func_php/imresulauto.php";
		document.autorizacion.submit();
	}
	
	function enviarr(){
		document.autorizacion.action="inautorizacion.php";
		document.autorizacion.submit();
	}

	function enviar22(pag){
       	document.autorizacion.pagina.value=pag;
		document.autorizacion.action="autorizacion.php";
		document.autorizacion.submit();
		return true;
	}	
	
		function valor(){
		value=document.getElementById('user').value;
		if (value=='0')
		{alert("Seleccione un Usuario");
		document.getElementById('user1').value="";
		}
		else{
		document.getElementById('user1').value=document.getElementById('user').value;	
		}
		}
-->
</script>
	
<link rel="stylesheet" type="text/css" href="../otros/jquery.autocomplete.css" media="screen"/>
<link rel="stylesheet" type="text/css" href="../otros/style.css" media="screen"/>
<link rel="stylesheet" type="text/css" href="../otros/datePicker.css"/>
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
	background-image: url(../images/fondo.gif);
}

.Estilo55 {
	color: #FFF;
	font-size:12px;
	font-family: Tahoma;
	font-weight: bold;	
	}
/*a {
	color:#FFF;
}*/
.Estilo56 {
	color: #FC0;
	font-size:16px;
	font-family: Tahoma;
	font-weight: bold;
}
.Estilo57 {font-size: 12px}
.Estilo58 {
	color: #333;
	font-size:11px;
	font-family: Tahoma;	
	font-weight: bold;	
}
-->
</style>
</head>

<body onload="nuevop();">
<div id="page">
<div id="content">
<div class="post" style="background-image:url(../images/fondo.gif)"> 
<h2 class="title">ADMINISTRACIÓN DE PEDIDOS -  <?php echo $_SESSION['user']; ?></h2>
<br />
<form method="post" action="autorizacion.php" name="autorizacion" target="_self" id="autorizacion">
<div align="center">
  <label for="autorizado"></label>
  <input name="autorizado" type="hidden" id="autorizado" value="" />
<input name="principal" type="button" class="botones" id="principal" value="Ir a Pagina Principal" onclick="location.href='inicontenido.php'"/>
<input name="principal2" type="button" class="botones" id="principal2" value="REGRESAR" onclick="location.href='autorizacion.php'"/>

</div>
<br />

<?php

$sql1 = "SELECT pedido.PE_ESTADO,PEDIDO.COD_PEDIDO,PEDIDO.PE_FECHA,PEDIDO.PE_OBSERVACIONES,PEDIDO.PE_USERCREA,PEDIDO.PE_ESTADO, pedido.PE_DIRECTAS, (SELECT LOGIN.LO_USERNAME FROM LOGIN WHERE LOGIN.COD_LOGIN = PEDIDO.COD_LOGIN_AUTORIZA) AS PRE, (SELECT LOGIN.LO_USERNAME FROM LOGIN WHERE LOGIN.COD_LOGIN = PEDIDO.COD_LOGIN_confirma)AS conf FROM PEDIDO WHERE COD_PEDIDO =$cod_item ORDER BY PE_FECHA DESC";
	
//	echo $sql1;
	
  $rst1 = oci_parse($con, $sql1);
  if (!$rst1) {
    $e = oci_error($con);
    print htmlentities($e['message']);
    exit;
  }

  $r = oci_execute($rst1, OCI_DEFAULT);
  if (!$r) {
    $e = oci_error($rst1);
    echo htmlentities($e['message']);
    exit;
  }
  
  $row = oci_fetch_array($rst1, OCI_ASSOC);
    
	$AUTORIZA=isset($row['PRE']) ? $row['PRE']:NULL;
    $CONFIRMA=isset($row['CONF']) ? $row['CONF']:NULL;	
//echo "<tr> ";
	$PE_FECHA=$row['PE_FECHA'];
	//echo "<tr> ";
	$COD_PEDIDO=$row['COD_PEDIDO'];
//	echo "<tr> ";
	$PE_OBSERVACIONES=$row['PE_OBSERVACIONES'];
	//echo "<tr> ";
	$PE_USERCREA=$row['PE_USERCREA'];
	$PE_ESTADO=$row['PE_ESTADO'];	

   echo "<table width='650px' align='center' bgcolor='#FFFFFF' border='0'>";
  echo "<tr>";
    echo "<td class='Estilo58' width=25%><label>CÓDIGO PEDIDO: </label></td>
	<td ><strong>".$row['COD_PEDIDO']."</strong></td>";    
	    echo "<td class='Estilo58' width=25%><label>FECHA PEDIDO: </label></td>
	<td ><strong>".$PE_FECHA."</strong></td>";   

  echo "</tr>";
  
  echo "<tr>";
    echo "<td class='Estilo58' width=25%><label>USUARIO SOLICITA: </label></td><td width=25%><strong>".$PE_USERCREA."</strong></td>";
    echo "<td class='Estilo58' width=25%><label>USUARIO PRE-AUTORIZA: </label></td><td width=25%><strong>".$AUTORIZA."</strong></td>";
  echo "</tr>";
  
  echo "<tr>";
    echo "<td class='Estilo58' width=25%></td><td width=25%></td>";
    echo "<td class='Estilo58' width=25%><label>USUARIO CONFIRMA: </label></td><td width=25%><strong>".$CONFIRMA."</strong></td>";
  echo "</tr>";
    
  echo "<tr>";
    echo "<td class='Estilo58' width=25%><label>COMPRA DIRECTA: </label></td>";
	
	if ($row['PE_DIRECTAS']==1){				
		echo "<td bgcolor='#01DF01' class='Estilo58' align='center' colspan=3>SI</td>";	
	}
	else
	{				
		echo "<td bgcolor='#FF0000' class='Estilo58' align='center' colspan=3>NO</td>";	
	}	
  echo"</tr>";
     
  echo "<tr><td class='Estilo58' colspan=4><label>OBSERVACIONES PEDIDO </label></td>";
  echo "<tr><td colspan=4><strong>".$PE_OBSERVACIONES."</strong></td></tr>";
  echo "<tr>";    
  echo "<tr align='right'><td class='Estilo58' colspan=4><strong>Si desea conocer la historia completa del pedido favor dar click
  <a href=\"histpedi.php?cod_item=".$COD_PEDIDO."\" target=\"_blank\" onclick=\"window.open(this.href,this.target,'width=800,height=650');return false;\"> AQUÍ...</a> 
  </strong></td></tr>";  
echo "</table>";


if($row['PE_ESTADO']==4) /// pedido revisado
	{
	$hql="UPDATE pedido SET pedido.PE_ESTADO=5 WHERE pedido.COD_PEDIDO=$COD_PEDIDO";
    $stid = oci_parse($con, $hql);	
	oci_execute($stid, OCI_DEFAULT);
	oci_commit($con);
	
    oci_free_statement($stid); ////// grabo en el historial que el pedido fue revisado
 	$hqls="INSERT INTO HISTORIAL (HI_FECHA, COD_LOGIN, LO_USERNAME, HI_CODIGO, COD_TIPO, COD_ESTADO) VALUES (sysdate, $cod_user, '$user', $COD_PEDIDO, 2, 5)";
    $stid = oci_parse($con, $hqls);	
	oci_execute($stid, OCI_DEFAULT);
	oci_commit($con);	
	}


?>

<table width="790px" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#999999">       
<tr>
	<td height="25" colspan="8" bgcolor="#444444"><div align="center" class="Estilo56">DETALLE DEL PEDIDO</div>
    </td>
</tr>
<tr>
	  
    <td width="54" bgcolor="#626262" class="date"><div align="center" class="Estilo55">CATEG.</div>
    </td>
        
	<td width="300" height="25" bgcolor="#626262" class="date1"><div align="center" class="Estilo55">DESCRIPCION ÍTEM</div>
    </td>
    
    <td width="199" height="25" bgcolor="#626262" class="date1"><div align="center" class="Estilo55">OBSERVACIÓN</div>
    </td>
       
    <td width="38" bgcolor="#626262" class="date"><div align="center" class="Estilo55">CANT.</div>
    </td>
    
    <td width="58" bgcolor="#626262" class="date"><div align="center" class="Estilo55">CENTRO</div>
    </td>
    
    <td width="56" bgcolor="#626262" class="date"><div align="center" class="Estilo55">SERV</div>
    </td>
  
</tr>

<?php
			
	$sql = "SELECT pe.PE_DIRECTAS,PE.PE_FECHA,PE.COD_PEDIDO, 
    PE.PE_OBSERVACIONES, 
    PE.PE_USERCREA, RP.COD_PEDIDO,CA.COD_CATEGORIA,CA.CA_PREFIJO,IT.COD_ITEM,IT.IT_NOMBRE,DR.DR_CANTIDAD,DR.DR_OBSERVACION,
    (SELECT CC.NOMB_COTB_CENT_COST FROM INTER.COTB_CENTROS_COSTO_EMPRESA_DAT CC WHERE CC.CODI_COTB_CENT_COST = RQ.CODI_COTB_CENT_COST AND CC.CODI_ADMI_EMPR_FINA = '00001') AS CENTROCOSTO, 
    RQ.CODI_COTB_CENT_AUXI AS SERVICIO
FROM REQUISICIONES_PEDIDO RP,REQUISICION RQ, DET_REQUISICION DR,CATEGORIA CA,ITEM IT,PEDIDO PE
WHERE RP.COD_PEDIDO = $cod_item
AND RQ.COD_REQUISICION = RP.COD_REQUISICION 
AND DR.COD_REQUISICION = RP.COD_REQUISICION 
AND DR.COD_DET_REQUISICION = RP.COD_DET_REQUISICION 
AND CA.COD_CATEGORIA = DR.COD_CATEGORIA 
AND IT.COD_ITEM = DR.COD_ITEM
AND PE.COD_PEDIDO=RP.COD_PEDIDO
ORDER BY IT_NOMBRE ASC";
//	echo $sql; 
  $rst = oci_parse($con, $sql);
  if (!$rst) {
    $e = oci_error($con);
    print htmlentities($e['message']);
    exit;
  }

  $r = oci_execute($rst, OCI_DEFAULT);
  if (!$r) {
    $e = oci_error($rst);
    echo htmlentities($e['message']);
    exit;
  }
        
  	while ($row = oci_fetch_array($rst, OCI_ASSOC)) {
    
	echo "<tr> ";
	echo "<td bgcolor='#FFFFFF' width='40px' class='Estilo58' align='center'>".$row['CA_PREFIJO']."</td>";
	echo "<td bgcolor='#FFFFFF' width='316px' class='Estilo58'>".$row['IT_NOMBRE']."</td>";
	echo "<td bgcolor='#FFFFFF' width='316px' class='Estilo58'>".$row['DR_OBSERVACION']."</td>";
	echo "<td bgcolor='#FFFFFF' width='44px' align='center' class='Estilo58'>".$row['DR_CANTIDAD']."</td>";
	echo "<td bgcolor='#FFFFFF' width='80px' class='Estilo58' align='center'>".$row['CENTROCOSTO']."</td>";
	echo "<td bgcolor='#FFFFFF' width='40px' class='Estilo58' align='center'>".$row['SERVICIO']."</td>";
	
	//echo "<tr> ";
//	$PE_FECHA=$row['PE_FECHA'];
//	echo "<tr> ";
//	$COD_PEDIDO=$row['COD_PEDIDO'];
//	echo "<tr> ";
//	$PE_OBSERVACIONES=$row['PE_OBSERVACIONES'];
//	echo "<tr> ";
//	$PE_USERCREA=$row['PE_USERCREA'];
		
  }
 
 	//echo $PE_FECHA;
	//echo "<tr> ";
	
 	//echo $COD_PEDIDO;
	//echo "<tr> ";
	
 	//echo $PE_OBSERVACIONES;
	//echo "<tr> ";
 	//echo $PE_USERCREA;
	
?>

<br />				
<?php
	if (($PE_ESTADO==4)or($PE_ESTADO==5)) //($PE_ESTADO==1) //enviado o revisado listo para cotizar
	{ ?>
<tr>
    <td width="54" height="25" bgcolor="#626262" class="date1"><div align="center" class="Estilo55">Usuario Cotiza:</div>
    </td>
    <td colspan="1">

<?php 	

	$cons="select cod_login,lo_nombre from login where lo_cotiza=1 order by lo_nombre asc";
 	$rstcl = oci_parse($con, $cons);
	oci_execute($rstcl)or die("Ocurri&oacute; un error ");					
		echo "<select name='user' id='user' onchange='valor();'>";
		echo "<option value='0' class='date'>SELECCIONE: </option>";
		while ($registro = oci_fetch_array($rstcl, OCI_ASSOC))		 
			{echo "<option value='".$registro['COD_LOGIN']."'>".$registro['LO_NOMBRE']."</option>";			}
		echo "</select>";
		echo "<td class='Estilo58'><input name='user1' id='user1' type='hidden'></td>";

?>
    </td>    
</tr>
<tr>
  <td height="25" bgcolor="#626262" class="date1" colspan="1"><div align="center" class="Estilo55">Raz&oacute;n Negar</div></td>
  <td ><input name="razon" type="text" id="razon" size="50" /></td><td><div align="center" style="vertical-align:middle"> <a href="javascript:;" onclick="javaScript:envia_pagnega(this);"><img  src='../images/boton5.png' title='NEGAR' /></a></div></td>  
</tr>
<tr>
	<td height="25" colspan="8" bgcolor="#FFFFFF" class="date1 Estilo55">
    	<div align="center">
 <a href="javascript:;" onclick="javaScript:envia_pag(this);"><img src='../images/boton.png' width='101' height='25' border='0' title='AUTORIZAR'/></a>
<script language="JavaScript" type="text/javascript">
			function envia_pag(obj){
			var ban=1;
			var cod=<?php echo $COD_PEDIDO;?>;
//			var cod_login_crea= document.getElementById("user2").value;
			var cod_login_cotiza= document.getElementById("user1").value;
			var url = "autorizacion.php?ban="+ ban + "&cod="+ cod +"&cod_login_cotiza="+ cod_login_cotiza;
			if (document.getElementById("user").value==0)
			{ alert("Para poder autorizar el pedido debe escojer el usuario que cotiza");}
			   else{obj.href=url;}
			}
			function envia_pagnega(obj){
			var ban=9;
			var cod=<?php echo $COD_PEDIDO;?>;
			var razon= document.getElementById("razon").value;
			var url = "autorizacion.php?ban="+ ban + "&cod="+ cod +"&razon="+ razon;
			if (document.getElementById("razon").value=="")
			{ alert("Para poder negar el pedido debe indicar la razon para negar");}
			   else{obj.href=url;}
			}			
		</script>
</div>       		
    </td>
</tr>
<?php
	} else{
	?> 
<tr>
  <td height="25" bgcolor="#626262" class="date1" colspan="1"></td>
  <td bgcolor="#626262" colspan="5"></td>  
</tr>
<tr>
	<td height="25" colspan="8" bgcolor="#FFFFFF" class="date1 Estilo55"></td>
</tr>
<?php } ?>
</table>
<br />

<table width="790" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#999999">       
<tr>
	<td height="25" colspan="9" bgcolor="#444444"><div align="center" class="Estilo56">LISTA DE COTIZACIONES DEL PEDIDO</div>
    </td>
</tr>
<tr>
	  
    <td width="85px" bgcolor="#626262" class="date"><div align="center" class="Estilo55">FECHA</div>
	</td>
    
    <td width="175px" bgcolor="#626262" class="date"><div align="center" class="Estilo55">PROVEEDOR</div>
    </td>

    <td width="175px" bgcolor="#626262" class="date"><div align="center" class="Estilo55">OBSERVACIONES</div>
    </td>
        
	<td width="80px" height="25" bgcolor="#626262" class="date1"><div align="center" class="Estilo55">RECIBE</div>
    </td>
    
    <td width="80px" height="25" bgcolor="#626262" class="date1"><div align="center" class="Estilo55">F. PAGO</div>
    </td>
    
	<td width="44px" bgcolor="#626262" class="date"><div align="center" class="Estilo55">DESC.</div>
    </td>
    
    <td width="66px" bgcolor="#626262" class="date"><div align="center" class="Estilo55">SUBTOTAL</div>
    </td>
    
    <td width="34px" bgcolor="#626262" class="date"><div align="center" class="Estilo55">REC.</div>
    </td>
    
    <?php 

echo "<td width=50px bgcolor=#626262 class=date><div align=center class=Estilo55>ACCI&Oacute;N</div></td> ";

?>
  
</tr>

<?php
			
	$sql1 = "SELECT DISTINCT COTIZACION.COD_COTIZACION,COTIZACION.CO_FECHA,COTIZACION.CODI_INVE_PROV, 
    (SELECT PR.RAZO_SOCI_INVE_PROV FROM VIEW_PROVEEDORES PR WHERE PR.CODI_INVE_PROV = COTIZACION.CODI_INVE_PROV) AS PROVEEDOR, 
    COTIZACION.CO_SUBTOTAL,COTIZACION.CO_OBSERVACIONES,COTIZACION.CO_ESTADO, DECODE(COTIZACION.CO_RECOMENDADA,1,'R','') CO_RECOMENDADA,
    (SELECT LOGIN.LO_USERNAME FROM LOGIN WHERE LOGIN.COD_LOGIN = COTIZACION.COD_LOGIN_RECIBE) AS CO_RECIBE, 
    (SELECT FP_DESCRIPCION FROM FORMAPAGO WHERE FORMAPAGO.COD_FORMAPAGO = COTIZACION.COD_FORMAPAGO) AS FP_DESCRIPCION, 
    COTIZACION.CO_DESCUENTO, COTIZACION.CO_APROBADA, 
    (SELECT PEDIDO.PE_ESTADO FROM PEDIDO WHERE PEDIDO.COD_PEDIDO = COTIZACION.COD_PEDIDO) AS ESTADO_PEDIDO, 
    (SELECT COD_ORDEN_COMPRA FROM ORDEN_COMPRA WHERE ORDEN_COMPRA.COD_COTIZACION = COTIZACION.COD_COTIZACION) AS COD_ORDEN_COMPRA 
FROM COTIZACION INNER JOIN DET_COTIZACION ON  (DET_COTIZACION.COD_COTIZACION = COTIZACION.COD_COTIZACION) 
WHERE DET_COTIZACION.COD_PEDIDO =$cod_item
ORDER BY  CO_APROBADA DESC";
//echo $sql1; 	
  $rst1 = oci_parse($con, $sql1);
  if (!$rst1) {
    $e1 = oci_error($con);
    print htmlentities($e1['message']);
    exit;
  }

  $r = oci_execute($rst1, OCI_DEFAULT);
  if (!$r) {
    $e1 = oci_error($rst1);
    echo htmlentities($e1['message']);
    exit;
  }
	$estado=isset($estado) ? $estado:0;
	$cotizacion=isset($cotizacion) ? $cotizacion:0;
	        
  	while ($row = oci_fetch_array($rst1, OCI_ASSOC)) {
    
	$var= number_format($row['CO_SUBTOTAL'],2);
	echo "<tr> ";
	echo "<td bgcolor='#FFFFFF' width='50px' class='Estilo58' align='center'>".$row['CO_FECHA']."</td>";
//	echo "<td bgcolor='#FFFFFF' width='200px' class='Estilo58' align='center'>".$row['PROVEEDOR']."</td>";
	echo "<td bgcolor='#FFFFFF' width='200px' class='Estilo58' align='center'><a href='histprove.php?id=".$row['CODI_INVE_PROV']."&ped=".$COD_PEDIDO."'> ".$row['PROVEEDOR']."</a></td>";
	echo "<td bgcolor='#FFFFFF' width='150px' class='Estilo58' align='center'>".$row['CO_OBSERVACIONES']."</td>";
	echo "<td bgcolor='#FFFFFF' width='80px' class='Estilo58' align='center'>".$row['CO_RECIBE']."</td>";
	echo "<td bgcolor='#FFFFFF' width='80px' class='Estilo58' align='center'>".$row['FP_DESCRIPCION']."</td>";
	echo "<td bgcolor='#FFFFFF' width='44px' align='right' class='Estilo58'>".$row['CO_DESCUENTO']."</td>";
	echo "<td bgcolor='#FFFFFF' width='66px' class='Estilo58' align='right'>".$var."</td>";

	$row['CO_RECOMENDADA']=isset($row['CO_RECOMENDADA']) ? $row['CO_RECOMENDADA']:0;
	echo "<td bgcolor='#FFFFFF' width='34px' align='center' class='Estilo58'>".$row['CO_RECOMENDADA']."</td>";
		
	$row['CO_APROBADA']=isset($row['CO_APROBADA']) ? $row['CO_APROBADA']:0;		
	
 if (($row['CO_ESTADO']==41)and($row['CO_APROBADA']<>1)){		
	
	echo "<td width='50px' bgcolor='#FFFFFF' align='center'><a href='detallec.php?cod_pedido=$cod_item&cod_cotizacion=$row[COD_COTIZACION]' class='submenu'><img src='../images/boton3.png' width='64' height='25' border='0' title='REVISAR'/></a></td>";		
	$estado=$row['CO_ESTADO']; 
	$cotizacion=$cotizacion+$row['CO_APROBADA'];		
	}
	
	else{
	 if ($row['CO_APROBADA']==1)		
		{echo "<td width='100px' bgcolor='#999999' class='Estilo58' align='center'>APROBADA</td>";	
		 $contador=$contador+1; 
		}
		else{echo "<td width='100px' bgcolor='#999999' class='Estilo58' align='center'></td>";	}
		}
	
	echo "</tr>";
	
  }
	
	echo "</form>";

?>
<tr>
    <?php if ($contador>=1){ ?>
	<td height="25" colspan="9" bgcolor="#626262" align="center"> 
	<?php echo "<a href='autorizacion.php?ban=3,&cod=$cod_item' class='submenu'><img src='../images/boton4.png'  border='0' title='Cerrar Pedido'/></a>";	?>
    </td>
    <?php } else {

//		echo "estado ".$estado." cotizacion ".$cotizacion;
		
	   if (($estado==1)and($cotizacion<>1)){?>
      <td height="25" colspan="9" bgcolor="#626262" class="date1"><div class="Estilo55" style="float:left; padding-left:50px;">Raz&oacute;n Para Negar &eacute;l Pedido <input name="razon1" type="text" id="razon1" size="25" /></div> <?php echo "<div style='vertical-align:middle; float:left;'> <a href='javascript:;' onclick='javaScript:envia_pagnega1(this);'><img  src='../images/boton6.png' title='NEGAR' /></a></div>"; ?></td>
<?php } }
 oci_close($con);
?>    
</tr>

</table>

<div align="center"><br /></div>
</form>
</div>                  				  
</div>
</div>

<script language="JavaScript" type="text/javascript">
	<!-- Desactiva clic derecho
	/*var message="";
	function clickIE() {if (document.all) {(message);return false;}}
	function clickNS(e) {if 
	(document.layers||(document.getElementById&&!document.all)) {
	if (e.which==2||e.which==3) {(message);return false;}}}
	if (document.layers) 
	{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
	else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}
	document.oncontextmenu=new Function("return false")*/
	// Fin del script -->
	
			function envia_pagnega1(obj){
			var ban=19;
			var cod=<?php echo $COD_PEDIDO;?>;
			var razon= document.getElementById("razon1").value;
			var url = "autorizacion.php?ban="+ ban + "&cod="+ cod +"&razon="+ razon;
			if (document.getElementById("razon1").value=="")
			{ alert("Para poder negar el pedido debe indicar la razon para negar");}
			   else{obj.href=url;}
			}			
</script>

</body>
</html>