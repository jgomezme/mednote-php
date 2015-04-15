<?php 
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: includes/error.php");
// echo "hola mundo2";
} 

?>
 <form id='invitar' name='invitar'>
<table border='0'  cellpadding='0' cellspacing='0' style='width: 98%; '>
	<tr>
		<td colspan='3'>
		<div>
  <b class='caja_externa'>
  <b class='caja_externa1'><b></b></b>
  <b class='caja_externa2'><b></b></b>
  <b class='caja_externa3'></b>
  <b class='caja_externa4'></b>
  <b class='caja_externa5'></b></b>

  <div class='caja_externafg'>
  <div align='center'><font size='-2'>Invita a un colega<br>a disfrutar GaleNUx!</font></div>
		</td>
	</tr>
	<tr>
		<td  style='background:#c2f0e5; ' >&nbsp;</td>
		<td  style='background:#ffffff; ' >
		

 <center>
 <div id='capa_invitacion'><font size='-3'>Email:<br></font>
<input title='E-MAIL del colega' type='text' name='correo_invitado' id='correo_invitado' size='15' value='' onchange="xajax_comprobar_email(this.value)">
<font size='-3'>Nombre:<br></font>
<input title='Nombre del colega'  type='text' name='nombre_invitado' id='nombre_invitado' size='15' value='' >
<div id='capa_mail'><font size='-2' color='#E5E5E5' title='Email y nombre son campos requeridos'>[ INVITAR ]</font></div>
</div>
</center>
  

		</td>
		<td  style='background:#c2f0e5; ' >&nbsp;</td>
	</tr>
	<tr>
		<td colspan='3'>
		
</div>
  <b class='caja_externa'>
  <b class='caja_externa5'></b>
  <b class='caja_externa4'></b>
  <b class='caja_externa3'></b>
  <b class='caja_externa2'><b></b></b>
  <b class='caja_externa1'><b></b></b></b>
</div>	
		</td>
	</tr>
</table>

</form><?php
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
