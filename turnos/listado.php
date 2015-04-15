<?php 
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: error.php");
// echo "hola mundo2";
} 
function turnos_listado($estado,$time,$especialista){
$link=Conectarse(); 
if($_SESSION['grupo']!='1'){$id_empresa= $_SESSION['id_empresa'];}else {$id_empresa='%%';}
$hoy=date('Y-m-d');
list( $ano, $mes, $dia ) = split( '[-]', $hoy );
$hoy_timestamp=mktime(0,0,0, $mes, $dia, $ano);
$w='';
echo "<br><div name='asignacion_procedimiento_alerta' id='asignacion_procedimiento_alerta' style='display:inline'></div>";
echo "<div name='asignacion_turnos_alerta' id='asignacion_turnos_alerta' style='display:inline'></div>
<select NAME='id_turno'>
<option value='' >Seleccione un turno</option>
<option value='nuevo' > >>> Realizar consulta en este momento <<<</option>
<option value='' >-------------------------------------------------------</option>

";
if ($especialista!='0'){$w .= "AND turnos.especialista ='$especialista'";}
if ($time=="1"){$w .= "AND turnos.timestamp >= $hoy_timestamp";}

// depuracion echo "estado: $estado time: $time  w: $w > esp: $especialista ";
$result=mysql_query("
		SELECT `id_turno`,`fecha`,`hora_inicio`,`hora_fin`, `especialista`, `nombre_completo`, `especialidad`
		FROM `turnos` ,`d9_users` ,`especialistas` 
		WHERE turnos.estado='$estado'		
		AND  turnos.especialista = d9_users.id
		AND  turnos.especialista = especialistas.id
		AND  turnos.id_empresa LIKE $id_empresa
		$w
		
		ORDER BY fecha, hora_inicio",$link);
if(mysql_num_rows($result) >0) {


		
   while($row = mysql_fetch_array($result)) {
     echo "<option value='".$row["id_turno"]."'  class=\"C".$row["especialista"]."\">".$row["fecha"]." Hora ".$row["hora_inicio"]."-".$row["hora_fin"]." [".$row["nombre_completo"]." _".$row["especialidad"]."_]</option>\n";

   }
	echo "</select>";
										}else
										{echo "</select>No hay turnos disponibles ! <img src='images/atencion.gif' alt='!'><br>";}
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
