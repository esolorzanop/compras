<?php 
 session_start();
 $url=""; 
 
 include("lib.php");
 require_once("funpass.php");
 
  $con=conectar();
  $valores = array("'", "´", "/", "--"); 

  $usuario=strtoupper(isset($_REQUEST["user"]) ? $_REQUEST["user"]:NULL);
  $usuario = str_replace($valores, "", $usuario);
  
 $passwd=strtoupper(isset($_REQUEST["passwd"]) ? $_REQUEST["passwd"]:NULL);
 $passwd = str_replace($valores, "", $passwd);
  
   
 $sql="Select * from login where lo_username='$usuario'";
 $rst=oci_parse($con,$sql);
 oci_execute($rst) or die("Ocurrió un error al ejecutar el query1...");
 
  			$num_filas=0;
				 while(($row = oci_fetch_array($rst, OCI_ASSOC)))
  				 {
				 $num_filas++;
				 
				 $salt = $row['LO_USERNAME'].$row['COD_LOGIN'];
				 } 
	if($num_filas == 0)
	{    
       $URL="../pag_php/login.php?num=4" . "&passwd=" . $passwd . "&user=" . $usuario;
	}
	else
	{
		//if($row['COD_NIVEL']==5)
			//{    
       		 //$URL="login.php?num=9";
		 //header("Location: $URL");
			// exit;
			//}

			 $passwd2 = str2hex(rc4($salt, $passwd));

//			 $passwd2=$passwd;   

             $sql="Select * from login where lo_password='$passwd2' and lo_username='$usuario'";
//			  echo $sql;
             $rst = oci_parse($con, $sql);
 			 oci_execute($rst) or die("Ocurrió un error al ejecutar el query2...");
  			 $num_filas=0;
				 while(($row = oci_fetch_array($rst, OCI_ASSOC)))
  				 {
				 $num_filas++;
				 }    
	          if($num_filas == 0)
	                  {    
                        $URL="../pag_php/login.php?num=5" . "&passwd=" . $passwd2 . "&user=" . $usuario;
	                 }
					  else
	                                {
										oci_free_statement($rst);
										
										$sqll="Select cod_login, lo_aprueba, lo_confirma from login where lo_username='$usuario' and lo_password='$passwd2'";
										$rst = oci_parse($con, $sqll);
            							oci_execute($rst)or die("Ocurrió un error ");
   									    $row = oci_fetch_array($rst, OCI_ASSOC);
										$cod_login=$row['COD_LOGIN'];
										$lo_aprueba=$row['LO_APRUEBA'];
										$_SESSION['confirma'] = $row['LO_CONFIRMA'];
										//echo $lo_aprueba;
                                      	$URL="../pag_php/login.php?num=1" . "&user=" . $usuario . "&cod_login=" . $cod_login. "&aprueba=". $lo_aprueba;
										
	                                    oci_free_statement($rst);  								    																
										$rst = oci_parse($con, $sqll);
            							oci_execute($rst) or die("Ocurrió un error fecha");
										
										 $ip = getRealIP();
										 $mac = returnMacAddress();   
 
										  $sql='UPDATE login SET lo_iplogin = :ip, lo_maclogin = :mac, lo_ultimologin = sysdate WHERE cod_login = :login';				  
										  $rst = oci_parse($con, $sql);
										  oci_bind_by_name($rst, ":ip", $ip);			  
										  oci_bind_by_name($rst, ":mac", $mac);			  										  
										  oci_bind_by_name($rst, ":login", $cod_login, -1, SQLT_CHR);			  
										  $r = oci_execute($rst);			

											  if (!$r) {
												$e = oci_error($rst); 
												/*    print htmlentities($e['message']);
													print "\n<pre>\n";
													print htmlentities($e['sqltext']);
													printf("\n%".($e['offset']+1)."s", "^");
													print  "\n</pre>\n";*/
													echo "actualizando login";
												}  

										
									}
					
	}
oci_close($con);	
header("Location: $URL");
exit;
?>