<?php
    	session_start();
		$cod_user=$_SESSION['cod_user'];
////////////////////////// paginacion//////////////////////////////////
		 $pagina=0;
		 $pagina=isset($_GET["pagina"]) ? $_GET["pagina"]:NULL;
		 $registros = 10;
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
	
	$login_crea=isset($_REQUEST["cod_login_crea"]) ? $_REQUEST["cod_login_crea"]:"";
	$registrore=isset($_REQUEST["cod_login_recibe"]) ? $_REQUEST["cod_login_recibe"]:"";
	$cod=isset($_REQUEST["cod"]) ? $_REQUEST["cod"]:"";
	$razon=isset($_REQUEST["razon"]) ? $_REQUEST["razon"]:"";
	
if(($actu==1)or($actu==6))
{
	if($actu==1){//preautorizado
		$hql="UPDATE REQUISICION SET REQUISICION.COD_ESTADO=6,REQUISICION.COD_LOGIN_PREAUTORIZA=$login_crea,REQUISICION.COD_LOGIN_RECIBE=$registrore WHERE REQUISICION.COD_REQUISICION=$cod";
		$hqls="UPDATE DET_REQUISICION SET DET_REQUISICION.DR_ESTADO=6 WHERE DET_REQUISICION.COD_REQUISICION=$cod";
		$hqlt="INSERT INTO HISTORIAL (HI_FECHA, COD_LOGIN, LO_USERNAME, HI_CODIGO, COD_TIPO, COD_ESTADO, COD_LOGIN_2, LO_USERNAME_2) VALUES (sysdate, $login_crea , (select lo_username from login where cod_login=$login_crea),  $cod ,  1 ,  6,  $registrore, (select lo_username from login where cod_login=$registrore))"; //registro en el log	
		} 
	if($actu==6){//negar solicitud
		$hql="UPDATE REQUISICION SET REQUISICION.COD_ESTADO=8,REQUISICION.RE_RAZON='$razon' WHERE REQUISICION.COD_REQUISICION=$cod";
		$hqls="UPDATE DET_REQUISICION SET DET_REQUISICION.DR_ESTADO=8 WHERE DET_REQUISICION.COD_REQUISICION=$cod";
	 	$hqlt="INSERT INTO HISTORIAL (HI_FECHA, COD_LOGIN, LO_USERNAME, HI_CODIGO, COD_TIPO, COD_ESTADO) VALUES (sysdate, $cod_user , (select lo_username from login where cod_login=$cod_user), $cod, 1, 8)";}	

//echo $hqlt;	
	$stid = oci_parse($con, $hql);	
	oci_execute($stid, OCI_DEFAULT);
	oci_commit($con);
	
	$stids = oci_parse($con, $hqls);	
	oci_execute($stids, OCI_DEFAULT);
	oci_commit($con);

	$stidt = oci_parse($con, $hqlt);	
	oci_execute($stidt, OCI_DEFAULT);
	oci_commit($con);
}
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
	parent.document.getElementById("icentro").style.height="780px";	
 
/*	function enviar(){		
	document.autorizacion.action="autorizacion.php";
	document.autorizacion.submit();
								
    }
	
/*	function enviar2(pag){     	
		if(pag >= 26)
		{alert("Atención!\nDebido al volumen del resultado en su consulta, esta información será exportada directamente a un archivo de Excel");}
		//document.autorizacion.action="../func_php/imresulauto.php";
		document.autorizacion.submit();
	}
	
/*	function enviarr(){
		document.autorizacion.action="inautorizacion.php";
		document.autorizacion.submit();
	}

/*	function enviar22(pag){
       	document.autorizacion.pagina.value=pag;
		document.autorizacion.action="autorizacion.php";
		document.autorizacion.submit();
		return true;
	}*/
</script>
<link rel="stylesheet" type="text/css" href="../otros/style.css" media="screen"/>
<style type="text/css">
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
a {
	color:#FFF;
}
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
}</style>
</head>
<body>
<div id="page">
<div id="content">
<div class="post" style="background-repeat:repeat; background-image:url(../images/fondo.gif)"> 
<h2 class="title">ADMINISTRACIÓN DE SOLICITUDES -  <?php echo $_SESSION['user']; ?></h2>
<br />
<form method="post" name="autorizacion" target="_self" id="autorizacion" action="autorizacion.php">
<div align="center">
<input name="principal" type="button" class="botones" id="principal" value="Ir a Pagina Principal" onclick="location.href='inicontenido.php'"/>
<input name="actualizar" type="button" class="botones" id="actualizar" value="Actualizar Datos" onclick="location.href='solicitud.php'"/>
</div>            
<br />
<table width="790" align="center" cellpadding="1" cellspacing="1" bgcolor="#999999">       
<tr>
	<td height="25" colspan="9" bgcolor="#444444" ><div align="center" class="Estilo56">SOLICITUDES DE PEDIDOS</div>
    </td>    
</tr>
<tr height="25">
	<td width="50px" bgcolor="#626262" class="date"><div align="center" class="Estilo55">COD.</div>
	</td>
	<td width="75px" bgcolor="#626262" class="date"><div align="center" class="Estilo55">FECHA</div>
	</td>    
    <td width="70px" bgcolor="#626262" class="date"><div align="center" class="Estilo55">USUARIO</div>
    </td>    
    <td width="70px" bgcolor="#626262" class="date"><div align="center" class="Estilo55">C. COSTO</div>
    </td>    
    <td width="80px" bgcolor="#626262" class="date"><div align="center" class="Estilo55">SERVICIO</div>
    </td>    
    <td width="240px" bgcolor="#626262" class="date"><div align="center" class="Estilo55">OBSERVACIONES</div>
    </td>
    <td width="80px" bgcolor="#626262" class="date"><div align="center" class="Estilo55">ESTADO</div>
    </td>        
<?php 
echo "<td width=95px bgcolor=#626262 class=date colspan=2><div align=center class=Estilo55>ACCIÓN</div></td> ";
?>
</tr>
<?php
$sql1 = "SELECT 
    REQUISICION.RE_DIRECTAS,
	REQUISICION.COD_REQUISICION, 
    REQUISICION.RE_FECHA, 
    (SELECT LOGIN.LO_USERNAME FROM LOGIN WHERE COD_LOGIN = REQUISICION.COD_LOGIN_CREA) AS LOGIN_CREA, 
    REQUISICION.CODI_COTB_CENT_COST, 
    (SELECT NOMB_COTB_CENT_COST FROM INTER.COTB_CENTROS_COSTO_EMPRESA_DAT WHERE INTER.COTB_CENTROS_COSTO_EMPRESA_DAT.CODI_COTB_CENT_COST = REQUISICION.CODI_COTB_CENT_COST AND INTER.COTB_CENTROS_COSTO_EMPRESA_DAT.CODI_ADMI_EMPR_FINA = REQUISICION.CODI_ADMI_EMPR_FINA ) AS NOMB_COTB_CENT_COST, 
    REQUISICION.CODI_COTB_CENT_AUXI, 
    (SELECT NOMB_CORT_COTB_CENT_AUXI FROM INTER.COTB_CENTROS_COSTO_AUXILI_DAT WHERE INTER.COTB_CENTROS_COSTO_AUXILI_DAT.CODI_COTB_CENT_AUXI = REQUISICION.CODI_COTB_CENT_AUXI AND INTER.COTB_CENTROS_COSTO_AUXILI_DAT.CODI_ADMI_EMPR_FINA = REQUISICION.CODI_ADMI_EMPR_FINA ) AS NOMB_CORT_COTB_CENT_AUXI, 
    REQUISICION.RE_OBSERVACIONES, 
    REQUISICION.COD_LOGIN_CREA, 
    REQUISICION.COD_LOGIN_RECIBE, 
    (SELECT LOGIN.LO_USERNAME FROM LOGIN WHERE COD_LOGIN = REQUISICION.COD_LOGIN_RECIBE) AS LOGIN_RECIBE, 
    REQUISICION.COD_ESTADO, 
    REQUISICION.RE_RAZON, 
    (SELECT ES_NOMBRE FROM ESTADOS WHERE ESTADOS.COD_ESTADO = REQUISICION.COD_ESTADO AND ESTADOS.COD_TIPO = 1) AS ES_NOMBRE, 
    REQUISICION.COD_LOGIN_PREAUTORIZA 
FROM 
    REQUISICION  
WHERE 
    ( 
        (COD_LOGIN_RECIBE = $cod_user AND COD_ESTADO IN (4,5)) 
    )  
ORDER BY 
    RE_FECHA DESC, 
    COD_REQUISICION DESC";  
	$a = oci_parse($con, $sql1);
	if (!$a) {
    $e = oci_error($con);
    print htmlentities($e['message']);
    exit;
  	} 
  	$s = oci_execute($a, OCI_DEFAULT);
  	if (!$s) {
    $e = oci_error($a);
    echo htmlentities($e['message']);
    exit;
  	}
//		echo $sql1;
	echo "<form action='autorizacion.php' method='post'>";
  	while ($row = oci_fetch_array($a, OCI_ASSOC)){	 
	echo "<tr>";
	echo "<td bgcolor='#FFFFFF' class='Estilo58'><div align='center'>".$row['COD_REQUISICION']."</div></td>";
	echo "<td bgcolor='#FFFFFF' class='Estilo58'><div align='center'>".$row['RE_FECHA']."</div></td>";
	echo "<td bgcolor='#FFFFFF' class='Estilo58' align='center'>".$row['LOGIN_CREA']."</td>";
	echo "<td bgcolor='#FFFFFF' class='Estilo58' align='center'>".$row['NOMB_COTB_CENT_COST']."</td>";
	echo "<td bgcolor='#FFFFFF' class='Estilo58' align='center'>".$row['NOMB_CORT_COTB_CENT_AUXI']."</td>";	
	echo "<td bgcolor='#FFFFFF' class='Estilo58' >".$row['RE_OBSERVACIONES']."</td>";	
	echo "<td bgcolor='#FFFFFF' class='Estilo58' align='center'>".$row['ES_NOMBRE']."</td>";
	//echo "<td bgcolor='#999999' width='80px' class='Estilo58'>".$row['LOGIN_RECIBE']."</td>"; ////// falta de espacio	
	if (($row['COD_ESTADO']==4)or($row['COD_ESTADO']==5)){			
	echo "<td width='100px' bgcolor='#FFFFFF' align='center'>"."<a href='detalles.php?cod_pedido=$row[COD_REQUISICION]&registro=$row[COD_LOGIN_RECIBE]' class='submenu'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><img src='../images/boton1.png' width='90' height='25' border='0' title='PREAUTORIZAR'/></font></a>"."</td>";		
	}	
	else{echo "<td width='100px' bgcolor='#FFFFFF' class='Estilo58'></td>";}	
	echo "</tr>";	
  }	
	echo "</form>";
  	oci_close($con);
?>				
</table>
<br />
</form>  
</div>                  				  
</div>
</div>
<script language="JavaScript" type="text/javascript">
	var message="";
	function clickIE() {if (document.all) {(message);return false;}}
	function clickNS(e) {if 
	(document.layers||(document.getElementById&&!document.all)) {
	if (e.which==2||e.which==3) {(message);return false;}}}
	if (document.layers) 
	{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
	else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}
	document.oncontextmenu=new Function("return false")
</script>
</body>
</html>