<?php 
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: error.php");
// echo "hola mundo2";
} 
function eventos_listado($estado,$id,$codigo){
$link=Conectarse(); 

$w='';
if ($id!='0'){$w .= "";}


// depuracion echo "estado: $estado time: $time  w: $w > esp: $especialista ";
mysql_query("SET NAMES 'utf8'");
$result=mysql_query("
		SELECT `nombre`,`cups`,`soat`,`id_evento`
		FROM `eventos` 
		WHERE eventos.estado='$estado'		
		$w
		
		ORDER BY nombre",$link);
if(mysql_num_rows($result) >0) {
$select .= "

			<select NAME='id_evento' id='id_evento' onChange=\"xajax_revisar_evento(this.value) \" >
				<option value'' >SELECCIONE PROCEDIMIENTOS</option>
				<option  > </option>
		   	<option value='otros' >         [ OTROS PROCEDIMIENTOS ]</option>
		   	<option  > </option>
		   	";
   while($row = mysql_fetch_array($result)) {
$select .=  "<option value=".$row["id_evento"]." >".$row["nombre"]." Cups ".$row["cups"]." Soat ".$row["soat"]."</option>\n";

   }

$select .=  "</select>
						<div id='revisar_evento'></div>
						";
										}else
										{
										$select .=  "No hay informaci&oacute;n ";}
return $select;
}




?>


<?php
$control_version = '0aa0b6b3207f0b3839381db1962574a2'; 
/*  

    IMPORTANTE: Esta aplicación fue desarrollada en el marco del proyecto - Opus libertati- 
    plan piloto de investigación aplicada en tecnologías de la información y la comunicación 
    para el sector salud - linea software libre - http://opuslibertati.org
    promovido por el Hospital Departamental Universitario del Quindio San Juan De Dios.
    Si deseas participar, apoyar o colaborar con el desarrollo de esta aplicación o conocer otras   
    lineas de trabajo de nuestro proyecto comunicate con http://ourproject.org/projects/opuslibertati/ 
    o http://opuslibertati.org

    ATENCION: Puede existir una versión mas reciente de este archivo en 
    http://ourproject.org/projects/opuslibertati/
    por favor compruébelo antes de modificarlo. versión actual: [$version]
    
    Copyright ©  13-22-2/ 17-Dic-2008 Dirección nacional de derechos de autor Colombia 
    El core y base de datos inicial de la aplicación fue desarrollado por http://GaleNUx.com 
    Es un sistema para de información para la salud adaptado al sistema de salud Colombiano.
    
    Si necesita consultoría o capacitación en el manejo, instalación y/o soporte o 
    ampliación de prestaciones de GaleNUx por favor comuníquese al email praxis@galenux.com.

    Este programa es software libre: usted puede redistribuirlo y/o modificarlo 
    bajo los términos de la Licencia Publica General GNU publicada 
    por la Fundación para el Software Libre, ya sea la version 3 
    de la Licencia, o cualquier version posterior.

    Este programa se distribuye con la esperanza de que sea útil, pero 
    SIN GARANTIA ALGUNA; ni siquiera la garantía implícita 
    MERCANTIL o de APTITUD PARA UN PROPOSITO DETERMINADO. 
    Consulte los detalles de la Licencia Publica General GNU para obtener 
    una información mas detallada. 

    Debería haber recibido una copia de la Licencia Publica General GNU 
    junto a este programa. 
    En caso contrario, consulte <http://www.gnu.org/licenses/>.
    
    POR FAVOR CONSERVE ESTA NOTA SI EDITA ESTE ARCHIVO 

 */
?>
