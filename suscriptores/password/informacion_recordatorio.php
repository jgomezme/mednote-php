<?session_start();?>
<html><head>  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Recordatorio de contrase&ntilde;a</title>
 <link rel="SHORTCUT ICON" href="../../icono.ico">



<link href="../../estilos/estilo.css" rel="stylesheet" type="text/css">
</head>
<body >

<table width="80%" border="0" align="center">  
<tr>
   <td colspan="3" align="center">
   
   <br><br><img src="../../images/logo.gif"  border="0" name="GaleNUx" alt="GaleNUx" align="top"><br>
  </td>  
</tr>
<tr>
   <td colspan="3" align="center">
<br>
<?
$ip_solicitud=$_SERVER['REMOTE_ADDR'];
include_once("../../librerias/conex.php");
$link=Conectarse();
$mail_recordatorio = $_POST['mail'];
if ($mail_recordatorio == "")
{
echo "<h1>Acceso denegado</h1>";
echo '<a href="../../index.php">Volver al inicio</a>';
}
else
{
$info_recordatorio=mysql_query("SELECT id, control, email FROM d9_users WHERE email='$mail_recordatorio'",$link);
$aux_recordatorio = mysql_fetch_array($info_recordatorio);	
if (mysql_num_rows($info_recordatorio)==0){
 	echo "<h1>No existe ning&uacute;n usuario con tal correo electr&oacute;nico</h1>";
	echo '<a href="password_perdido.php">Volver a buscar</a>';
}
else {
	include_once("../../includes/correos.php");
	enviarmail($aux_recordatorio['email'],$aux_recordatorio['id'], $ip_solicitud, $aux_recordatorio['control'],'');
	echo "<h1>La informaci&oacute;n de su cuenta de usuario ha sido enviada a su correo</h1>";
	echo '<a href="../../index.php">Volver</a>';
}
}
?>
</tr>
</table>
</body>
</html>
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
