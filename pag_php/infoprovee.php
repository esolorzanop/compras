<?php
    	session_start();
	    include("../func_php/lib.php");
		$con=conectar();
		
			$cod_item = strtoupper(isset($_REQUEST["cod_item"]) ? $_REQUEST["cod_item"]:NULL);
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>TEVCOL - SISTEMA DE COMPRAS</title>
	
	<link rel="stylesheet" type="text/css" href="../otros/style.css" media="screen"/>

<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
	background-image: url(../images/fondo.gif);
}

.Estilo45 {color: #444444}
.Estilo46 {color: #444444; font-weight: bold; }
.Estilo49 {color: #D0910B}
.Estilo53 {
	font-size: 12px;
	font-weight: bold;
}
.Estilo59 {padding-left:1px; padding-top:1px; font-family: Tahoma; color: #D0910B;}

.Estilo55 {
	color: #FFF;
	font-size:12px;
	font-family: Tahoma;
	font-weight: bold;	
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
}
html {
    overflow: -moz-scrollbars-vertical;
}
-->
</style>
    
	<script type="text/javascript">
		//	if(top==self) top.location="../pag_php/tevcol.php";
			parent.document.getElementById("headerpic").style.height="90px";	
			parent.document.getElementById("header").style.height="90px";
			parent.document.getElementById("icentro").style.height="850px";	
							
	</script>
    <script> 
function centrar() { 
    iz=(parent.document.body.clientWidth) / 2; 
    de=(parent.document.body.clientHeight) / 2; 
    moveTo(iz,de); 
}     
</script> 
</head>

<body onload="centrar()">
<div id="page">
<div id="content">
<div class="post" style="background-image:url(../images/fondo.gif)"> 
<h2 class="title">INFORMACIÓN DE PROVEEDORES - <?php echo $_SESSION['user']; ?></h2>
<!--<br>
<div align="center">
<input name="principal" type="button" class="botones" id="principal" value="Cerrar Ventana" onclick="window.close();'"/>
<input name="actualizar" type="button" class="botones" id="actualizar" value="Actualizar Datos" onclick="location.href='bushisto.php'"/>
</div>-->        
<br />
<?php
   $sql_dtr="SELECT P.RAZO_SOCI_INVE_PROV,
       P.RUC_INVE_PROV,
       G.NOMB_ADMI_UBIC_GEOG,
       P.TLF1_INVE_PROV,
       P.TLF2_INVE_PROV,
       P.TLF3_INVE_PROV,
       P.MAIL_INVE_PROV,
       P.CONT_INVE_PROV
  FROM INVE_PROVEEDORES_DAT P, ADMI_UBICACIONES_GEOGRAFICAS_D G
 WHERE     P.CODI_INVE_PROV = '".$cod_item."'
       AND P.CODI_ADMI_ESTA = 'A'
       AND P.CODI_ADMI_EMPR_FINA = '00001'
       AND P.CODI_ADMI_UBIC_GEOG = G.CODI_ADMI_UBIC_GEOG
";
   
//	echo $sql_dtr."<br>";
	$rst_dtr=oci_parse($con, $sql_dtr);
	oci_execute($rst_dtr) or die("Ocurrio un error al totalizar los registros...!");
	
	$cont = 0;        
	$row_dtr = oci_fetch_array($rst_dtr, OCI_ASSOC+OCI_RETURN_NULLS);
	
	?>	
<table width="570" align="center" cellpadding="1" cellspacing="1" bgcolor="#999999">       
<tr>
	<td height="25" colspan="4" bgcolor="#444444" ><div align="center" class="Estilo56"> INFORMACIÓN DE PROVEEDOR</div></td>   
</tr>
<tr>
    <td bgcolor="#626262" class="date"><div align="center" class="Estilo55">Código:</div>
	<td height="25" colspan="3" bgcolor="#ffffff"><div align="left" class="Estilo58">&nbsp;&nbsp;<?php echo $cod_item; ?></div>
    </td>
</tr>
<tr>
    <td bgcolor="#626262" class="date"><div align="center" class="Estilo55">Razón Social:</div>
	<td height="25" colspan="3" bgcolor="#ffffff"><div align="left" class="Estilo58">&nbsp;&nbsp;<?php echo $row_dtr['RAZO_SOCI_INVE_PROV']; ?></div>
    </td>
</tr>
<tr>
    <td bgcolor="#626262" class="date"><div align="center" class="Estilo55">RUC:</div>
	<td height="25" colspan="3" bgcolor="#ffffff"><div align="left" class="Estilo58">&nbsp;&nbsp;<?php echo $row_dtr['RUC_INVE_PROV']; ?></div>
    </td>
</tr>
<tr>
    <td bgcolor="#626262" class="date"><div align="center" class="Estilo55">Ubicación:</div>
	<td height="25" colspan="3" bgcolor="#ffffff"><div align="left" class="Estilo58">&nbsp;&nbsp;<?php echo $row_dtr['NOMB_ADMI_UBIC_GEOG']; ?></div>
    </td>
</tr>
<tr>
    <td bgcolor="#626262" class="date"><div align="center" class="Estilo55">Correo:</div>
	<td height="25" colspan="3" bgcolor="#ffffff"><div align="left" class="Estilo58">&nbsp;&nbsp;<?php echo $row_dtr['MAIL_INVE_PROV']; ?></div>
    </td>
</tr>
</table>
<br>
<div align="center"><input type="button" value="Cerrar Ventana" class="botones" onClick="self.close();" onKeyPress="self.close();"></div>
</div>                  				  
</div>
</div>
</body>
</html>