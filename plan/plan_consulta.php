<?php 
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: adentro.php");
// echo "hola mundo2";
												} 


echo "<form name='recetar' id='recetar' > ";
echo "Formular:<br> "; recetar();

function recetar(){
global $id_turno ,$id_usuario ,$id_especialista;
$control =  microtime();
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");

include_once("farmacia/listado_medicamentos.php");
//include_once("plan/recetas_anteriores.php");
//$id_medicamento="255";
listado_medicamentos($id_medicamento,$pos);
$formato .= "
<input type='hidden' name='id_usuario' id='id_usuario' value='$id_usuario'>
<input type='hidden' name='id_especialista' id='id_especialista' value='$id_especialista'>
<input type='hidden' name='id_turno' id='id_turno' value='$id_turno'>
<input type='hidden' name='control' id='control' value='$control'>


			";	
			
echo $formato;
						}
echo  "</form>";
echo  "<form name='ordenar' id='ordenar' >";
echo   "<h2>Ordenes y Procedimientos</h2>";
include_once("plan/ordenes/tipo_orden.php");
echo "<div name='confirmar_orden' id='confirmar_orden'></div>

<input type='hidden' name='id_usuario' id='id_usuario' value='$id_usuario'>
<input type='hidden' name='id_especialista' id='id_especialista' value='$id_especialista'>
<input type='hidden' name='id_turno' id='id_turno' value='$id_turno'>
<input type='hidden' name='control' id='control' value='$control'>";
// echo  "<table border='1'><tr><td>";

// ordenes();

function ordenes(){
global $id_turno ,$id_usuario ,$id_especialista;
$control =  microtime();
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");

include_once("plan/listado_ordenes.php");

listado_tipo_orden("19","Laboratorios");
listado_tipo_orden("20","Biopcias, citologias y similares");
listado_tipo_orden("21","Radiológicos y especiales");
listado_tipo_orden("22","Medicina nuclear");
listado_tipo_orden("23","Nefrología y urología");
listado_tipo_orden("24","Neumología");
listado_tipo_orden("25","Cardioloia y hemodinámia");
listado_tipo_orden("26","Neurología");
listado_tipo_orden("27","Otorrinolaringología");
listado_tipo_orden("28","Oftalmología");
listado_tipo_orden("29","Medicina física y rehabilitación");
listado_tipo_orden("30","Banco de sangre");
listado_tipo_orden("31","Ecografías, vascolares no invasivos y resonacia");
listado_tipo_orden("33","Oncología");
listado_tipo_orden("37","Cirugía general");
$formato .= "
</td><td>
<div name='confirmar_orden' id='confirmar_orden'>

</div>

<input type='hidden' name='id_usuario' id='id_usuario' value='$id_usuario'>
<input type='hidden' name='id_especialista' id='id_especialista' value='$id_especialista'>
<input type='hidden' name='id_turno' id='id_turno' value='$id_turno'>
<input type='hidden' name='control' id='control' value='$control'>

</td></tr>

			";	
			
echo $formato;
						}
echo "<!-- </table> --></form>";


?><?php
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
