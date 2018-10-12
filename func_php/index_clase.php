<?php
include("prueba_clase.php");
$pruebaconsulta = new miWebService();
$result=$pruebaconsulta -> consulta("Select cod_usuariow, web_login from usuario_web"); 
 //echo “”; print_r($result[0]); echo “”;
// print_r($result[0]);
/* foreach($result as $codigo => $login)
 {
   echo $codigo."-".$login.'<br/>';
  } */
foreach($result as $r){
   echo $r->COD_USUARIOW.' '.$r->WEB_LOGIN.'<br/>';
}

?>

