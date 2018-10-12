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
    
	<script language="javascript" type="text/javascript" src="../otros/jquery-1.5.1.js"></script>
	<script language="javascript" type="text/javascript" src="../otros/jquery.autocomplete.pack.js"></script>

    <script>
		 $(document).ready(function() {
			$('#cod_item').keydown(function(e){			
//				if (e.keyCode === 13){
//				var varRut = $('#nomitem').val();
						tecla = (document.all) ? e.keyCode : e.which;					
							if (tecla==13) {
							send('consulta');
							}																
	//				}
			});		
		});
		
function SoloNumeros(evt){
 if(window.event){//asignamos el valor de la tecla a keynum
  keynum = evt.keyCode; //IE
 }
 else{
  keynum = evt.which; //FF
 } 
 //comprobamos si se encuentra en el rango numérico y que teclas no recibirá.
 if((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 ){
  return true;
 }
 else{
  return false;
 }
}		
	</script>

	<script type="text/javascript">
			if(top==self) top.location="../pag_php/tevcol.php";
			parent.document.getElementById("headerpic").style.height="90px";	
			parent.document.getElementById("header").style.height="90px";
			parent.document.getElementById("icentro").style.height="850px";	
				
		function validar(e) {
			
		}			

		function send(action){
				if (action == 'consulta')
				{
							var form = document.bushist;
							form.action.value="bushisto.php";		
							form.submit();
				}
				action = "";
		}		
				
	</script>    

</head>

<body>
<div id="page">
<div id="content">
<div class="post" style="background-image:url(../images/fondo.gif)"> 
<h2 class="title">BUSQUEDA HISTORIAL DE PEDIDOS AUTORIZADOS - <?php echo $_SESSION['user']; ?></h2>
<br />
<div align="center">
<input name="principal" type="button" class="botones" id="principal" value="Ir a Página Principal" onclick="location.href='inicontenido.php'"/>
<input name="actualizar" type="button" class="botones" id="actualizar" value="Nueva Busqueda" onclick="location.href='bushistpedi.php'"/>
</div>          
<br />
<?php 	if($cod_item==""){ ?>
<table width="790" align="center" cellpadding="1" cellspacing="1" bgcolor="#999999">       
<form name="bushist" id="bushist" action="" method="POST" autocomplete="off">
<tr>
	<td height="25" bgcolor="#444444" colspan="2" ><div align="center" class="Estilo56">BUSQUEDA POR PEDIDOS COTIZADOS</div></td>   
</tr>
<tr height="50"><td bgcolor='#FFFFFF' colspan="2">
      <div align="center"><span class="Estilo53"><span class="Estilo59">Atenci&oacute;n:</span><span class="Estilo45"> <strong>Para realizar la busqueda, debe ingresar el número de la orden de compra aprobada, para el pedido que desea consultar.</strong></span></span></div>
</td></tr>
<tr height="50">
    <td bgcolor="#626262" class="date1" width="30%"><div align="center" class="Estilo55"># de Orden de Compra a buscar:</div>
    </td>
	<td bgcolor='#FFFFFF' class="date">
   &nbsp; &nbsp;<input name="cod_item" type="text" id="cod_item"  size="30" autofocus required onKeyPress="return SoloNumeros(event);"/> <br/>
<!--   <input name="cod_item" id="cod_item" type="hidden">
   <input name="nom_item" id="nom_item" type="hidden">
   <input name="nom_cate" id="nom_cate" type="hidden">      -->
</td></tr>
</form>
</table>

<?php 	} else { ?>
<table width="800px" align="center" cellpadding="1" cellspacing="1" bgcolor="#999999">       
<?php
$sql_dtr="SELECT (SELECT ESTADOS.ES_NOMBRE
          FROM ESTADOS
         WHERE ESTADOS.COD_ESTADO = REQUISICION.COD_ESTADO
               AND ESTADOS.COD_TIPO = 1)
          AS NOMBRE_ESTADO,
       REQUISICION.COD_REQUISICION,
       (SELECT INTER.COTB_CENTROS_COSTO_EMPRESA_DAT.NOMB_COTB_CENT_COST
          FROM INTER.COTB_CENTROS_COSTO_EMPRESA_DAT
         WHERE INTER.COTB_CENTROS_COSTO_EMPRESA_DAT.CODI_COTB_CENT_COST =
                  REQUISICION.CODI_COTB_CENT_COST
               AND INTER.COTB_CENTROS_COSTO_EMPRESA_DAT.CODI_ADMI_EMPR_FINA =
                      '00001')
          AS CCOSTO,
       REQUISICION.CODI_COTB_CENT_AUXI,
       REQUISICION.RE_OBSERVACIONES,
       (SELECT LOGIN.LO_USERNAME
          FROM LOGIN
         WHERE LOGIN.COD_LOGIN = REQUISICION.COD_LOGIN_CREA)
          AS CREADOR,
       (SELECT HISTORIAL.HI_FECHA
          FROM HISTORIAL
         WHERE     HISTORIAL.COD_TIPO = 1
               AND HISTORIAL.COD_ESTADO = 4
               AND HISTORIAL.HI_CODIGO = REQUISICION.COD_REQUISICION)
          AS FECHAENVIO,
       (SELECT HISTORIAL.LO_USERNAME_2
          FROM HISTORIAL
         WHERE     HISTORIAL.COD_TIPO = 1
               AND HISTORIAL.COD_ESTADO = 4
               AND HISTORIAL.HI_CODIGO = REQUISICION.COD_REQUISICION)
          AS PREAUTORIZADOR,
       (SELECT HISTORIAL.HI_FECHA
          FROM HISTORIAL
         WHERE     HISTORIAL.COD_TIPO = 1
               AND HISTORIAL.COD_ESTADO = 6
               AND HISTORIAL.HI_CODIGO = REQUISICION.COD_REQUISICION)
          AS FECHAPREAUTORIZA,
       (SELECT HISTORIAL.LO_USERNAME_2
          FROM HISTORIAL
         WHERE     HISTORIAL.COD_TIPO = 1
               AND HISTORIAL.COD_ESTADO = 6
               AND HISTORIAL.HI_CODIGO = REQUISICION.COD_REQUISICION)
          AS ASIGNADO
  FROM REQUISICION
   WHERE 
     REQUISICION.COD_REQUISICION IN 
                    (SELECT REQUISICIONES_PEDIDO.COD_REQUISICION FROM REQUISICIONES_PEDIDO, COTIZACION, ORDEN_COMPRA WHERE REQUISICIONES_PEDIDO.COD_PEDIDO = COTIZACION.COD_PEDIDO AND COTIZACION.COD_COTIZACION = ORDEN_COMPRA.COD_COTIZACION 
                    AND ORDEN_COMPRA.COD_ORDEN_COMPRA = ".$cod_item.")";

  
	//echo $sql_dtr."<br>";
	$rst_dtr=oci_parse($con, $sql_dtr);
	oci_execute($rst_dtr) or die("Ocurrio un error al totalizar los registros1...!");
	$cont = 0;
	
	while($row_dtr = oci_fetch_array($rst_dtr, OCI_ASSOC+OCI_RETURN_NULLS))
	{
		if ($cont == 0)
			{
					echo "<tr>
							<td height='25' colspan='9' bgcolor='#444444' ><div align='center' class='Estilo56'>SOLICITUD # ".$row_dtr['COD_REQUISICION']."</div></td>   
						</tr>
						<tr height='25'>
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>ESTADO</div></td>
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>C. COSTO</div></td>        
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>SERV.</div></td>
							<td bgcolor='#626262' class='date' width='40%'><div align='center' class='Estilo55'>OBSERVACIONES</div></td>							
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>CREA</div></td>
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>FECH CREA</div></td>    
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>PRE-AUTORIZA</div></td> 
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>FECH PRE-AUTORIZA</div></td> 
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>ASIGNADO</div></td> 														
						</tr>";
						$cont++;
			}
					if ($row_dtr['CO_APROBADA']==1)
					{$bgcolor='#01DF01';}else{$bgcolor='#FFF';}						
					
					echo "<tr>";
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['NOMBRE_ESTADO']."</td>"; 
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['CCOSTO']."</td>"; 
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['CODI_COTB_CENT_AUXI']."</td>";
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['RE_OBSERVACIONES']."</td>";	
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['CREADOR']."</td>";	
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['FECHAENVIO']."</td>";							   						   
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['PREAUTORIZADOR']."</td>";							   						   
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['FECHAPREAUTORIZA']."</td>";							   						   
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['ASIGNADO']."</td>";							   						   						   			
					echo "</tr>";											   				
	}
	?>
</table>
<br><br>
<table width="800px" align="center" cellpadding="1" cellspacing="1" bgcolor="#999999">       
<?php
/////////////////////////////////////////////////////
$sql_dtr="SELECT (SELECT ESTADOS.ES_NOMBRE
          FROM ESTADOS
         WHERE ESTADOS.COD_ESTADO = PEDIDO.PE_ESTADO AND ESTADOS.COD_TIPO = 2)
          AS NOMBRE_ESTADO,
       PEDIDO.COD_PEDIDO,
       PEDIDO.PE_OBSERVACIONES,
       (SELECT LOGIN.LO_USERNAME
          FROM LOGIN
         WHERE LOGIN.COD_LOGIN = PEDIDO.COD_LOGIN_CREA)
          AS TRAMITADOR,
       (SELECT HISTORIAL.HI_FECHA
          FROM HISTORIAL
         WHERE     HISTORIAL.COD_TIPO = 2
               AND HISTORIAL.COD_ESTADO = 4
               AND HISTORIAL.HI_CODIGO = PEDIDO.COD_PEDIDO)
          AS FECHAENVIO,
       (SELECT LOGIN.LO_USERNAME
          FROM LOGIN
         WHERE LOGIN.COD_LOGIN = PEDIDO.COD_LOGIN_AUTORIZA)
          AS AUTORIZADOR,
       (SELECT HISTORIAL.HI_FECHA
          FROM HISTORIAL
         WHERE     HISTORIAL.COD_TIPO = 2
               AND HISTORIAL.COD_ESTADO = 6
               AND HISTORIAL.HI_CODIGO = PEDIDO.COD_PEDIDO)
          AS FECHAAUTORIZA,
       (SELECT LOGIN.LO_USERNAME
          FROM LOGIN
         WHERE LOGIN.COD_LOGIN = PEDIDO.COD_LOGIN_COTIZA)
          AS COTIZADOR,
       (SELECT LOGIN.LO_USERNAME
          FROM LOGIN
         WHERE LOGIN.COD_LOGIN = PEDIDO.COD_LOGIN_CONFIRMA)
          AS CONFIRMA		  
  FROM PEDIDO
 WHERE PEDIDO.COD_PEDIDO IN (SELECT COTIZACION.COD_PEDIDO FROM COTIZACION, ORDEN_COMPRA WHERE COTIZACION.COD_COTIZACION = ORDEN_COMPRA.COD_COTIZACION AND ORDEN_COMPRA.COD_ORDEN_COMPRA = ".$cod_item.")";
  
//	echo $sql_dtr."<br>";
	$rst_dtr=oci_parse($con, $sql_dtr);
	oci_execute($rst_dtr) or die("Ocurrio un error al totalizar los registros...!");
	$cont = 0;
	
	while($row_dtr = oci_fetch_array($rst_dtr, OCI_ASSOC+OCI_RETURN_NULLS))
	{
		if ($cont == 0)
			{
					echo "<tr>
							<td height='25' colspan='8' bgcolor='#444444' ><div align='center' class='Estilo56'>PEDIDO # ".$row_dtr['COD_PEDIDO']."</div></td>   
						</tr>
						<tr height='25'>
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>ESTADO</div></td>
							<td bgcolor='#626262' class='date' width='40%'><div align='center' class='Estilo55'>OBSERVACIONES</div></td>														
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>TRAMITADOR</div></td>        
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>ENVIADO</div></td>
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>AUTORIZADOR</div></td>
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>AUTORIZADO</div></td>    
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>ASIGNADO</div></td> 														
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>CONFIRMADO</div></td> 																					
						</tr>";
						$cont++;
			}
					if ($row_dtr['CO_APROBADA']==1)
					{$bgcolor='#01DF01';}else{$bgcolor='#FFF';}						
					
					echo "<tr>";
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['NOMBRE_ESTADO']."</td>"; 
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['PE_OBSERVACIONES']."</td>";							   
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['TRAMITADOR']."</td>"; 
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['FECHAENVIO']."</td>";
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['AUTORIZADOR']."</td>";	
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['FECHAAUTORIZA']."</td>";							   						   
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['COTIZADOR']."</td>";							   						   														   						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['CONFIRMADO']."</td>";   			
					echo "</tr>";											   				
	}
	?>
</table>
<br><br>
<table width="800px" align="center" cellpadding="1" cellspacing="1" bgcolor="#999999">       
<?php
/////////////////////////////////////////////////////
$sql_dtr="SELECT (SELECT ESTADOS.ES_NOMBRE
          FROM ESTADOS
         WHERE ESTADOS.COD_ESTADO = COTIZACION.CO_ESTADO
               AND ESTADOS.COD_TIPO = 3)
          AS NOMBRE_ESTADO,
       COTIZACION.COD_COTIZACION,
       (SELECT REQ.VIEW_PROVEEDORES.RAZO_SOCI_INVE_PROV
          FROM REQ.VIEW_PROVEEDORES
         WHERE REQ.VIEW_PROVEEDORES.CODI_INVE_PROV =
                  COTIZACION.CODI_INVE_PROV)
          AS PROVEEDOR,
       COTIZACION.CO_NUMERO,
       COTIZACION.CO_OBSERVACIONES,
       COTIZACION.CO_TOTAL,
       DECODE (COTIZACION.CO_RECOMENDADA, 1, 'SI', '') CO_RECOMENDADA,
       COTIZACION.CO_USERCREA,
       (SELECT HISTORIAL.HI_FECHA
          FROM HISTORIAL
         WHERE     HISTORIAL.COD_TIPO = 2
               AND HISTORIAL.COD_ESTADO = 10
               AND HISTORIAL.HI_CODIGO = COTIZACION.COD_PEDIDO)
          AS FECHAENVIO,
       (SELECT LOGIN.LO_USERNAME
          FROM LOGIN
         WHERE LOGIN.COD_LOGIN =
                  (SELECT DISTINCT PEDIDO.COD_LOGIN_DIRIGIDO
                     FROM PEDIDO
                    WHERE PEDIDO.COD_PEDIDO = COTIZACION.COD_PEDIDO))
          AS APROBADOR,
       (CASE
           WHEN COTIZACION.CO_APROBADA = 1
           THEN
              (SELECT HISTORIAL.HI_FECHA
                 FROM HISTORIAL
                WHERE     HISTORIAL.COD_TIPO = 2
                      AND HISTORIAL.COD_ESTADO = 11
                      AND HISTORIAL.HI_CODIGO = COTIZACION.COD_PEDIDO)
           ELSE
              (NULL)
        END)
          AS FECHAAPRUEBA
  FROM COTIZACION
 WHERE COTIZACION.COD_COTIZACION IN (SELECT ORDEN_COMPRA.COD_COTIZACION FROM ORDEN_COMPRA WHERE ORDEN_COMPRA.COD_ORDEN_COMPRA = ".$cod_item.")";
  
//	echo $sql_dtr."<br>";
	$rst_dtr=oci_parse($con, $sql_dtr);
	oci_execute($rst_dtr) or die("Ocurrio un error al totalizar los registros...!");
	$cont = 0;
	
	while($row_dtr = oci_fetch_array($rst_dtr, OCI_ASSOC+OCI_RETURN_NULLS))
	{
		if ($cont == 0)
			{
					echo "<tr>
							<td height='25' colspan='10' bgcolor='#444444' ><div align='center' class='Estilo56'>COTIZACION # ".$row_dtr['COD_COTIZACION']."</div></td>   
						</tr>
						<tr height='25'>
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>ESTADO</div></td>
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>PROVEEDOR</div></td>        
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>NÚMERO</div></td>        							
							<td bgcolor='#626262' class='date' width='30%'><div align='center' class='Estilo55'>OBSERVACIONES</div></td>														
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>VALOR</div></td>        
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>REC</div></td>
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>COTIZA</div></td>
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>ENVIADO</div></td>    
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>APROBADOR</div></td> 														
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>APRUEBA</div></td> 																					
						</tr>";
						$cont++;
			}
					if ($row_dtr['CO_APROBADA']==1)
					{$bgcolor='#01DF01';}else{$bgcolor='#FFF';}						
					
					echo "<tr>";
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['NOMBRE_ESTADO']."</td>"; 
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['PROVEEDOR']."</td>"; 
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['CO_NUMERO']."</td>"; 						   						   
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['CO_OBSERVACIONES']."</td>";							   
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".number_format($row_dtr['CO_TOTAL'],2)."</td>"; 
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['CO_RECOMENDADA']."</td>";
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['CO_USERCREA']."</td>";	
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['FECHAENVIO']."</td>";							   						   
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['APROBADOR']."</td>";							   						   						   			
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['FECHAAPRUEBA']."</td>";							   						   						   					  					echo "</tr>";											   				
	}
	?>
</table>
<br><br>
<table width="800px" align="center" cellpadding="1" cellspacing="1" bgcolor="#999999">       
<?php
/////////////////////////////////////////////////////
$sql_dtr="SELECT ORDEN_COMPRA.COD_ORDEN_COMPRA,
       ORDEN_COMPRA.COD_COTIZACION,
       (SELECT REQ.VIEW_PROVEEDORES.RAZO_SOCI_INVE_PROV
          FROM REQ.VIEW_PROVEEDORES, COTIZACION
         WHERE REQ.VIEW_PROVEEDORES.CODI_INVE_PROV =
                  COTIZACION.CODI_INVE_PROV
               AND COTIZACION.COD_COTIZACION = ORDEN_COMPRA.COD_COTIZACION)
          AS PROVEEDOR,
       ORDEN_COMPRA.OC_USERCREA,
       ORDEN_COMPRA.OC_FECHA,
       (SELECT COTIZACION.CO_TOTAL
          FROM COTIZACION
         WHERE COTIZACION.COD_COTIZACION = ORDEN_COMPRA.COD_COTIZACION)
          AS VALOR,
       ORDEN_COMPRA.OC_OBSERVACIONES
  FROM ORDEN_COMPRA
  WHERE ORDEN_COMPRA.COD_ORDEN_COMPRA  = ".$cod_item;
  
//	echo $sql_dtr."<br>";
	$rst_dtr=oci_parse($con, $sql_dtr);
	oci_execute($rst_dtr) or die("Ocurrio un error al totalizar los registros...!");
	$cont = 0;
	
	while($row_dtr = oci_fetch_array($rst_dtr, OCI_ASSOC+OCI_RETURN_NULLS))
	{
		if ($cont == 0)
			{
					echo "<tr>
							<td height='25' colspan='6' bgcolor='#444444' ><div align='center' class='Estilo56'>ORDEN DE COMPRA # ".$row_dtr['COD_ORDEN_COMPRA']."</div></td>   
						</tr>
						<tr height='25'>
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'># COTIZACIÓN</div></td>
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>PROVEEDOR</div></td>        
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>ELABORADO POR</div></td>        							
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>FECHA</div></td>        
							<td bgcolor='#626262' class='date'><div align='center' class='Estilo55'>VALOR</div></td>
							<td bgcolor='#626262' class='date' width='30%'><div align='center' class='Estilo55'>OBSERVACIONES</div></td>																					
						</tr>";
						$cont++;
			}
					if ($row_dtr['CO_APROBADA']==1)
					{$bgcolor='#01DF01';}else{$bgcolor='#FFF';}						
					
					echo "<tr>";
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['COD_COTIZACION']."</td>"; 
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['PROVEEDOR']."</td>"; 
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['OC_USERCREA']."</td>"; 
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['OC_FECHA']."</td>";
						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".number_format($row_dtr['VALOR'],2)."</td>";		
   						   echo "<td bgcolor='".$bgcolor."' class='Estilo58' align='center'>".$row_dtr['Oc_OBSERVACIONES']."</td>";							   							   					 					  					echo "</tr>";											   				
	}
	?>
</table>
<?php } ?>
</div>                  				  
</div>
</div>
</body>
</html>