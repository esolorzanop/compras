<?php
    include("lib.php");
    $con=conectar();
	date_default_timezone_set('America/Guayaquil');
	$sql1=isset($_GET["sqll"]) ? $_GET["sqll"]:NULL ;
	$empresa=isset($_GET["empresa"]) ? $_GET["empresa"]:NULL ;
    $fecha=date("Y-m-d");
	$nombre=$empresa."_".$fecha.".xls";
//	echo $sql1;
	
header('Content-type: application/vnd.ms-excel; name=excel');
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
        <td colspan="12" bgcolor="#070707" height="100"><div align="center"><img src="http://192.168.1.13:8080/images/LoginBanner_white.png" alt="TEVCOL - Transportadora Ecuatoriana de Valores" width="450" height="100" /></div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="21" colspan="12"><div align="center"><font color="#000000" size="+2"><strong>TEVCOL Cia. Ltda. - SISTEMA DE SOLICITUDES WEB</strong></font></div></td>
      </tr>
    </table>
    <table width="100%" border="0" align="center">
      <tr>
        <td colspan="6"><strong>Empresa: </strong><?php echo $empresa;?></td>
        <td colspan="6"><strong>Fecha: </strong>
            <?php 	
		$meses = array('0' => '','01' => 'Enero','02' => 'Febrero','03' => 'Marzo','04' => 'Abril','05' => 'Mayo','06' => 'Junio','07' => 'Julio','08' => 'Agosto','09' => 'Septiembre','10' => 'Octubre','11' =>'Noviembre','12' => 'Diciembre');
		$anio=date("Y");
		$mes=date("m");
		$dia=date("d");		  
//		 echo "<strong>";
		 echo $dia."/".$meses[$mes]."/".$anio;	
//	     echo "</strong>";
	?></td>
      </tr>
      <tr>
        <td colspan="6"><strong>Usuario  : </strong><?php echo isset($_GET['nombre']) ? $_GET['nombre']:NULL ;?></td>
        <td colspan="6"><strong>Hora :  </strong>
          <?php $hora=date("H:i:s");
	 echo $hora; ?>
        </td>
      </tr>
    </table>
</div>

<hr>
<table border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="">
  <tr>
    <td height="25" colspan="12" bgcolor="#444444" style="color: #FFFFFF; font-family: Tahoma; font-weight: bold;"><div align="center">Solicitudes de Despacho</div></td>
  </tr>
  <tr>
    <td height="25" bgcolor="#626262" class="date1"><div align="center" class="Estilo55">Numero Solicitud</div></td>
    <td bgcolor="#626262" class="date" style="color: #FFFFFF;"><div align="center">Numero Recibo</div></td>
    <?php 
	$cargo=isset($_GET['cargo']) ? $_GET['cargo']:NULL ;
			   if (($cargo=="SUPERVISOR")||($cargo=="ADMINISTRADOR")){
		   echo "<td bgcolor=#626262 class=date><div align=center class=Estilo55>Solicitado Por</div></td>";}	
			   if ($cargo=="ADMINISTRADOR"){
		   echo "<td bgcolor=#626262 class=date><div align=center class=Estilo55>Empresa</div></td>";}	
		   ?>
    <td bgcolor="#626262" class="date" style="color: #FFFFFF;"><div align="center">Cliente</div></td>
	<td bgcolor="#626262" class="date" style="color: #FFFFFF;"><div align="center">Descripcion Ruta</div></td>
    <td bgcolor="#626262" class="date" style="color: #FFFFFF;"><div align="center">Ciudad</div></td>
    <td bgcolor="#626262" class="date" style="color: #FFFFFF;"><div align="center">Tonelaje</div></td>	
    <td bgcolor="#626262" class="date" style="color: #FFFFFF;"><div align="center">Valor</div></td>	
    <td bgcolor="#626262" class="date" style="color: #FFFFFF;"><div align="center">Observacion Custodia</div></td>		
    <td bgcolor="#626262" class="date" style="color: #FFFFFF;"><div align="center">Fecha realizar pedido</div></td>
    <td bgcolor="#626262" class="date" style="color: #FFFFFF;"><div align="center">Estado</div></td>
  </tr>
  <?php	
       			     
					 $rst = oci_parse($con, $sql1);
					 oci_execute($rst)or die("Ocurrio un error ");
					 while ($row = oci_fetch_array($rst, OCI_ASSOC)) 
						{								
					// echo $sql1;								
        echo "<tr bgcolor=#FFFFFF> 
		   <td height=25  class=date1 bgcolor=#444444><div align=center style='color:#D0910B'>".$row['COD_SOLICITUD']."</div></td>
		   <td height=25  class=date1 bgcolor=#444444><div align=center style='color:#D0910B'>".$row['COD_RECIBO']."</div></td>";		   
		   if (($cargo=="SUPERVISOR")||($cargo=="ADMINISTRADOR"))
		   	  {echo "<td bgcolor=#FFFFFF  class=date2><div align=left>".$row['USI_LOGIN']."</div></td>";}	   
		    if ($cargo=="ADMINISTRADOR")
		   	  {echo "<td bgcolor=#FFFFFF  class=date2><div align=center>".$row['CLO_NOMBRE']."</div></td>";}		
		   echo "<td bgcolor=#FFFFFF  class=date2><div align=left>".$row['UL_NOMBRE']."</div></td>		  	   
           <td bgcolor=#FFFFFF  class=date2><div align=left>".$row['KL_DESCRIPCION']."</div></td>
           <td bgcolor=#FFFFFF  class=date2><div align=center>".$row['CI_NOMBRE']."</div></td>
           <td bgcolor=#FFFFFF  class=date2><div align=center>".$row['SO_SOLTNLJE']."</div></td>		   
           <td bgcolor=#FFFFFF  class=date2><div align=center>".$row['SO_VALOR']."</div></td>		   
           <td bgcolor=#FFFFFF  class=date2><div align=center>".$row['OBSERVACION']."</div></td>		   		   		   
           <td bgcolor=#FFFFFF  class=date2><div align=center>".$row['SO_FECHSOLICITA']."</div></td>";
           if ($row['SO_ESTADO']==1)  
		      {
			  echo "<td bgcolor=#FFFFFF  class=date2><div align=center>Pendiente</div></td>";
			  }
			if ($row['SO_ESTADO']==2)  
		      {
			  echo "<td bgcolor=#FFFFFF  class=date2><div align=center>Asignado</div></td>";
			  }
			if ($row['SO_ESTADO']==4)  
		      {
			  echo "<td bgcolor=#FFFFFF  class=date2><div align=center>Procesado</div></td>";
			  }
			if ($row['SO_ESTADO']==3)  
		      {
			  echo "<td bgcolor=#FFFFFF  class=date2><div align=center>Entregado</div></td>";
			  }	
			if ($row['SO_ESTADO']==8)  
		      {
			  echo "<td bgcolor=#FFFFFF  class=date2><div align=center>Cancelado</div></td>";
			  }			  			  			  			  
			  		  			  			  
         echo "</tr> \n";
		            }										
		 ?>
</table>
<hr />
<table width="100%" border="0" align="center">
  <tr>
    <td height="21" colspan="11">
<?php
					 $nombre=isset($_GET['nombre']) ? $_GET['nombre']:NULL ;
					 $sql2="select WEB_NOMBRE_USUARIO from usuario_web WHERE WEB_LOGIN LIKE '%$nombre%'";
					 $rst1 = oci_parse($con, $sql2);
					 oci_execute($rst1)or die("Ocurrió un error ");
					 $row1 = oci_fetch_array($rst1, OCI_ASSOC); 
?>
      <div align="center"><strong><?php echo $row1['WEB_NOMBRE_USUARIO']; ?></strong><br />
      <strong>Nombre </strong>      </div></td>
  </tr>
  <tr>
    <td height="21" colspan="11" bgcolor="#070707"></td>
  </tr>
</table>
<?php 
    oci_free_statement($rst);
    oci_free_statement($rst1);
	oci_close($con);
?>
</body>
</html>
