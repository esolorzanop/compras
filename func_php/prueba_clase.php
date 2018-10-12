<?php
class miWebService
{
    /**
     * Saluda a una persona en un idioma
     * especifico
     *
     * @param string $sql
     * @return string
    */
    function consulta($sql)
    {
	 	    include("lib.php");
         	$con=conectar();
            $rst = OCIParse($con, $sql);
 			OCIExecute($rst) or die("Ocurrió un error al ejecutar el query2...");

            $iCounter = 0;
            $aGeneric = Array();
            $TempClass = new stdClass ();

			while(OCIFetchInto ($rst, $row, OCI_ASSOC))
  				 {
    			   /*echo $row['COD_USUARIOW']."-".$row['WEB_NOMBRE_USUARIO']."\n"; 		   */

                foreach ($row as $sKey => $sVal) {
                    $TempClass->{$sKey} = $sVal;
                }
                $aGeneric[$iCounter] = $TempClass;
                
                $iCounter++;
                  
			 } 
		//	 echo $iCounter;
//			 echo $aGeneric[0];
              //echo “”; print_r($aGeneric); echo “”;
//			return $row;	 
	        return ($aGeneric);
    }
}
?>

