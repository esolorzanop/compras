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
<h2 class="title">HISTORIAL DE ITEMS ADQUIRIDOS - <?php echo $_SESSION['user']; ?></h2>
<!--<br>
<div align="center">
<input name="principal" type="button" class="botones" id="principal" value="Cerrar Ventana" onclick="window.close();'"/>
<input name="actualizar" type="button" class="botones" id="actualizar" value="Actualizar Datos" onclick="location.href='bushisto.php'"/>
</div>-->        
<br />
<?php
 /*  $sql_dtr="SELECT
  F.COD_ITEM,
  F.IT_NOMBRE,
  F.CODI_INVE_PROV,
  F.RAZO_SOCI_INVE_PROV,
  F.DC_VUNITARIO,
  F.COTIZ,
  CO.CO_FECHA
FROM
(SELECT distinct
  DC.COD_ITEM,
  IT.IT_NOMBRE,
  CO.CODI_INVE_PROV,
  VP.RAZO_SOCI_INVE_PROV,
  DC.DC_VUNITARIO,
  (SELECT MAX(CO1.COD_COTIZACION) COTIZA FROM DET_COTIZACION CO1 WHERE CO1.DC_VUNITARIO = DC.DC_VUNITARIO) AS COTIZ
FROM
  DET_COTIZACION DC,
  COTIZACION CO,    
  ITEM IT,
  VIEW_PROVEEDORES VP
WHERE
  CO.COD_COTIZACION(+) = DC.COD_COTIZACION AND
  DC.COD_ITEM = '".$cod_item."' AND    
  IT.COD_ITEM (+) = DC.COD_ITEM AND
  VP.CODI_INVE_PROV(+) = CO.CODI_INVE_PROV
) F, COTIZACION CO WHERE
CO.COD_COTIZACION = F.COTIZ
ORDER BY
CO_FECHA DESC";
   
	//echo $sql_dtr."<br>";
	$rst_dtr=oci_parse($con, $sql_dtr);
	oci_execute($rst_dtr) or die("Ocurrio un error al totalizar los registros...!");
	
	$cont = 0;        
	while($row_dtr = oci_fetch_array($rst_dtr, OCI_ASSOC+OCI_RETURN_NULLS))
	{
	if ($cont == 0)
	{
			$cont++;
	?>	
<table width="570" align="center" cellpadding="1" cellspacing="1" bgcolor="#999999">       
<tr>
	<td height="25" colspan="4" bgcolor="#444444" ><div align="center" class="Estilo56"> VARIACION EN VALOR DE ITEM POR PROVEEDOR</div></td>   
</tr>
<tr>
    <td bgcolor="#626262" class="date"><div align="center" class="Estilo55">ITEM</div>
	<td height="25" colspan="3" bgcolor="#ffffff"><div align="left" class="Estilo58">&nbsp;&nbsp;<?php echo $row_dtr['IT_NOMBRE']; ?></div>
    </td>
</tr>
<tr height="25">
    <td bgcolor="#626262" class="date"><div align="center" class="Estilo55">NUMERO COTIZACION</div></td>    
    <td bgcolor="#626262" class="date"><div align="center" class="Estilo55">NOMBRE PROVEEDOR</div></td>
    <td bgcolor="#626262" class="date"><div align="center" class="Estilo55">FECHA COTIZACION</div></td>
    <td bgcolor="#626262" class="date"><div align="center" class="Estilo55">VALOR UNITARIO</div></td>
</tr>
<?php		
	} else{	
					echo "<tr>";
						   echo "<td bgcolor='#FFFFFF' class='Estilo58' align='center'>".$row_dtr['COTIZ']."</td>"; 
						   echo "<td bgcolor='#FFFFFF' class='Estilo58' align='center'><a href=\"infoprovee.php?cod_item=".$row_dtr['CODI_INVE_PROV']."\" target=\"_blank\" onclick=\"window.open(this.href,this.target,'width=800,height=320');return false;\">".$row_dtr['RAZO_SOCI_INVE_PROV']."</a></td>"; 
						   echo "<td bgcolor='#FFFFFF' class='Estilo58' align='center'>".$row_dtr['CO_FECHA']."</td>"; 
						   echo "<td bgcolor='#FFFFFF' class='Estilo58' align='center'>".number_format($row_dtr['DC_VUNITARIO'],2)."</td>";
					echo "</tr>";						   
		}
	}
	$cont = 0;
?>
</table>*/ ?>
 <table width="800" align="center" cellpadding="1" cellspacing="1" bgcolor="#999999">       
<?php
$sql_dtr="SELECT * FROM (SELECT ROWNUM AS FILAS, CO.CO_FECHA,DC.COD_ITEM,IT.IT_NOMBRE,CO.COD_COTIZACION,CO.COD_PEDIDO,CO.CODI_INVE_PROV,VP.RAZO_SOCI_INVE_PROV,DC.DC_VUNITARIO,DC.DC_CANTIDAD,DC.DC_VALXCANTIDAD,DC.DC_VALDESCUENTO,CO.CO_APROBADA, COD_VEHICULO FROM DET_COTIZACION DC,COTIZACION CO,ITEM IT,VIEW_PROVEEDORES VP WHERE CO.COD_COTIZACION(+) = DC.COD_COTIZACION AND DC.COD_ITEM = '".$cod_item."' AND IT.COD_ITEM(+) = DC.COD_ITEM AND VP.CODI_INVE_PROV(+) = CO.CODI_INVE_PROV ORDER BY  CO_FECHA DESC) WHERE ROWNUM < 11";

  
//	echo $sql_dtr."<br>";
	$rst_dtr=oci_parse($con, $sql_dtr);
	oci_execute($rst_dtr) or die("Ocurrio un error al totalizar los registros...!");
	$cont = 0;
	$cont1 = 1;	
	$valores = array();
	
	while($row_dtr = oci_fetch_array($rst_dtr, OCI_ASSOC+OCI_RETURN_NULLS))
	{
		if ($cont == 0)
			{
					echo "<tr>
							<td height='25' colspan='8' bgcolor='#444444' ><div align='center' class='Estilo56'>HISTORIAL ITEMS COTIZADOS</div></td>   
						</tr>
						<tr>
							<td bgcolor='626262' class='date'><div align='center' class='Estilo55'>ITEM:</div>
							<td height='25' colspan='7' bgcolor='#ffffff'><div align='left' class='Estilo58'>&nbsp;&nbsp;".$row_dtr['IT_NOMBRE']."</div>
							</td>
						</tr>
						<tr height='25'>
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>FECHA</div></td>
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>PROVEEDOR</div></td>
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>PEDIDO</div></td>        
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>COTIZACIÓN</div></td>        
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>VAL UNI</div></td>
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>CANT</div></td>
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>VAL TOT</div></td>    
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>VEHICULO</div></td> 
						</tr>";
						$cont++;
			}
					if ($row_dtr['CO_APROBADA']==1)
					{$bgcolor='#01DF01';}else{$bgcolor='#FFF';}						
					echo "<tr>";
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['CO_FECHA']."</td>"; 
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'><a href=\"infoprovee.php?cod_item=".$row_dtr['CODI_INVE_PROV']."\" target=\"_blank\" onclick=\"window.open(this.href,this.target,'width=800,height=320');return false;\">".$row_dtr['RAZO_SOCI_INVE_PROV']."</a></td>"; 
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['COD_PEDIDO']."</td>"; 
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['COD_COTIZACION']."</td>"; 
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".number_format($row_dtr['DC_VUNITARIO'],2)."</td>";
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['DC_CANTIDAD']."</td>";	
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".number_format($row_dtr['DC_VALXCANTIDAD'],2)."</td>";	
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['COD_VEHICULO']."</td>";							   						   
					echo "</tr>";
											   
				if($row_dtr['DC_VUNITARIO'] <> $dc_uni){										
					$valores[$cont1]['CO_APROBADA'] = $row_dtr['CO_APROBADA'];				
					$valores[$cont1]['FECHA'] = $row_dtr['CO_FECHA'];			
					$valores[$cont1]['COD_PROVE'] =	$row_dtr['CODI_INVE_PROV'];	
					$valores[$cont1]['PROVE'] = $row_dtr['RAZO_SOCI_INVE_PROV'];
					$valores[$cont1]['PEDI'] = $row_dtr['COD_PEDIDO'];		
					$valores[$cont1]['COTI'] = $row_dtr['COD_COTIZACION'];		
					$valores[$cont1]['VALOR'] = $row_dtr['DC_VUNITARIO'];																																										
					$cont1++;																																			
				}		
			 	$dc_uni = $row_dtr['DC_VUNITARIO'];					
		}
	//}
	?>
</table>
<?php
	$tvalores = count($valores);
	for ($x=$tvalores; $x>=1; $x--){
		if ($x==$tvalores){
		$val_dif = 0;
		}
		else{
		$val_dif = $valores[$x]['VALOR'] - $valores[$x+1]['VALOR'];
		}
		$valores[$x]['DIFE'] = number_format($val_dif,2);		
	}
	
if ($tvalores > 0){
?>
<br>
 <table width="800" align="center" cellpadding="1" cellspacing="1" bgcolor="#999999">       
<tr>
	<td height="25" colspan="6" bgcolor="#444444" ><div align="center" class="Estilo56">VARIACIÓN DE PRECIOS</div></td>   
</tr>
<tr height='25'>
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>FECHA</div></td>
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>PROVEEDOR</div></td>
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>PEDIDO</div></td>        
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>COTIZACIÓN</div></td>        
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>VAL UNI</div></td>
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>DIFERENCIA</div></td>    
</tr>
<?php
				foreach ($valores as $v1) {
					echo '<tr>';									
					foreach ($v1 as $v2=>$value) {
 																				
							switch ($v2) {															
							
								case "CO_APROBADA":								
										if ($value == 1)
										{$bgcolor='#01DF01';}else{$bgcolor='#FFF';}		
								break;

								case "COD_PROVE":								
										$COD_PROVE=$value;		
								break;								
							
								case "PROVE":								
								echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'><a href=\"infoprovee.php?cod_item=".$COD_PROVE."\" target=\"_blank\" onclick=\"window.open(this.href,this.target,'width=800,height=320');return false;\">".$value."</a></td>";
								break;															

								case "VALOR":
								echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".number_format($value,2)."</td>";
								break;								

								default:
								echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>$value</td>";
								break;								
							}
					
					}
					echo '</tr>'; 
				}
	
?>
<tr height="25px">
<td colspan="6" bgcolor='#fff' class='Estilo58' align='center'>
* Las Filas con fondo de color verde corresponden a cotizaciones para las cuales fue generada orden de compra
</td>
</tr>
</table>
<?php  
}else{  ?> <div colspan="6" bgcolor='#fff' class='Estilo58' align='center'>* Su busqueda no obtuvo resultados, intente recargar la página y  pruebe con un item distinto. </div>

<?php 
}

 ?>
<br>
<div align="center"><input type="button" value="Cerrar Ventana" class="botones" onClick="self.close();" onKeyPress="self.close();"></div>
</div>                  				  
</div>
</div>
</body>
</html>