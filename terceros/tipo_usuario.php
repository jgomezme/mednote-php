<?php
function tipo_usuario($estado,$id){
$link=Conectarse(); 
mysql_query ("SET NAMES 'utf8'");
$tipo_usuario .= "<select name='tipo_usuario' size='0' >"; 
if ($id!='0'){

$tipo_definido=mysql_query("SELECT * FROM tipo_usuarios WHERE activo ='$estado' $w AND id_tipo_usuario = '$id'",$link);
if(mysql_num_rows($tipo_definido) >0) {


while( $row = mysql_fetch_array( $tipo_definido ) ) {
$tipo_usuario .= "<option value='".$row['id_tipo_usuario']."' selected> > ".$row['tipo_usuario']." < </option>";

																}

													}

					}else {$tipo_usuario .=  "<option value='' selected> Tipo de Usuario</option>"; }



$Productos=mysql_query("SELECT * FROM tipo_usuarios WHERE activo ='$estado' $w",$link);
if(mysql_num_rows($Productos) >0) {

while( $row = mysql_fetch_array( $Productos ) ) {
$tipo_usuario .=  "<option value='".$row['id_tipo_usuario']."'>".$row['tipo_usuario']."</option>";

}
$tipo_usuario .=  "</select>"; 
												}
												else {$tipo_usuario .=  "<img src='images/atencion.gif' alt='!' title='No hay informacion sobre Tipo de Usuario '>No hay informaci&oacute;n sobre Tipo de Usuario";}
return $tipo_usuario;
}/// fin de tipo_usuario 

///plan_benficios

function tipo_plan_beneficios($estado,$id){
$link=Conectarse(); 
mysql_query ("SET NAMES 'utf8'");
$tipo_plan_beneficios .= "<select name='plan_beneficios' size='0' >"; 
if ($id!='0'){

$tipo_definido=mysql_query("SELECT * FROM tipo_plan_beneficios WHERE activo ='$estado'  AND id_tipo_plan_beneficios = '$id'",$link);
if(mysql_num_rows($tipo_definido) >0) {


while( $row = mysql_fetch_array( $tipo_definido ) ) {
$tipo_plan_beneficios .=  "<option value='".$row['id_tipo_plan_beneficios']."' selected> > ".$row['tipo_plan_beneficios']." < </option>";

																}

													}

					}else {$tipo_plan_beneficios .=  "<option value='' selected> Plan de beneficios</option>"; }



$Productos=mysql_query("SELECT * FROM tipo_plan_beneficios WHERE activo ='$estado' $w",$link);
if(mysql_num_rows($Productos) >0) {

while( $row = mysql_fetch_array( $Productos ) ) {
$tipo_plan_beneficios .=  "<option value='".$row['id_tipo_plan_beneficios']."'>".$row['tipo_plan_beneficios']."</option>";

}
$tipo_plan_beneficios .=  "</select>"; 
												}
												else {$tipo_plan_beneficios .=  "<img src='images/atencion.gif' alt='!' title='No hay informacion sobre Plan de Beneficios '>No hay informaci&oacute;n sobre el Plan de Beneficios";
												}
return $tipo_plan_beneficios;
} /// fin de tipo_plan_beneficios


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
