<?php 
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: adentro.php");
// echo "hola mundo2";
} 



function impresion($id){
global $id_turno, $id_usuario_consulta;
$nuevo_select = "<table border ='0'><tr>";
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");

// resumen de consulta													
														

$nuevo_select .= "<td>Imprimir: <a href=\"javascript:abrir('impresion/imprimir_resumen.php?id_turno=$id_turno&id_usuario=$id','PRINT',500,600,100,0,1);\" title='Imprimir el resumen de la consulta'>Resumen</a> </td>";

											

// medicamentos pendientes de impresion
$pos=mysql_query("SELECT count(recetas.id_receta) as cantidad, recetas.estado FROM recetas WHERE id_turno='$id_turno'  GROUP BY id_usuario",$link);
//if (mysql_num_rows($pos)> 0)					{
$Total=@mysql_result($pos,0,"cantidad");
$nuevo_select .= "<td>/ <a href=\"javascript:abrir('impresion/imprimir_receta.php?id_turno=$id_turno&id_usuario=$id','PRINT',500,600,100,0,1);\" title='Imprimir medicamentos'>Medicamentos</a></td>";

//														}
//ordenes pendientes de impresion						
$orden=mysql_query("SELECT count(ordenes.id_orden) as cantidad, ordenes.estado FROM ordenes WHERE id_turno='$id_turno'  GROUP BY id_usuario",$link);

//if (mysql_num_rows($orden)> 0)					{
$Total=@mysql_result($orden,0,"cantidad");
$nuevo_select .= "<td>/ <a href=\"javascript:abrir('impresion/imprimir_orden.php?id_turno=$id_turno&id_usuario=$id','PRINT',500,600,100,0,1);\" title='Imprimir ordenes'>Ordenes</a></td>";

//														}				
														
/// formatos ctc pendientes de impresion

														
														
$ctc=mysql_query("SELECT count(recetas_no_pos.id_receta_no_pos) as cantidad FROM recetas_no_pos WHERE id_turno='$id_turno'  GROUP BY id_usuario",$link);

//if (mysql_num_rows($ctc)> 0)					{
$Total=@mysql_result($ctc,0,"cantidad");
$nuevo_select .= "<td>/ <a href=\"javascript:abrir('impresion/imprimir_ctc.php?id_turno=$id_turno&id_usuario=$id','PRINT',500,600,100,0,1);\" title='Imprimir formulario CTC'> CTC no pos</a></td>";

//														}	
														
																	
																								
$nuevo_select .="</tr></table>";	
									return $nuevo_select ;						
//echo "$nuevo_select";
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
