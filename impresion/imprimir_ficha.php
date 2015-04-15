<?php 
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: ../includes/error.php");
// echo "hola mundo2";
} 
?>
<html>
<head>
<title>Impresion</title>
<link href="../estilos/impresion_pantalla.css" rel="stylesheet" type="text/css" >
<link href="../estilos/impresion.css" rel="stylesheet" type="text/css" media="print">
</head>
<script>


function SoloCerrar(){
window.close()
							}
</script>
<body onload="javascript:resizeTo(270,700), window.print()" >
<?php


include_once("../librerias/conex_pop.php");
$link=Conectarse();
impresion($control);
function impresion($control){
global $link ;
$control = $_REQUEST['control'];
mysql_query("SET NAMES 'utf8'");
 $consulta_turno="SELECT  * FROM turnos WHERE control = '$control' LIMIT 1";
 $consulta_turno = mysql_query($consulta_turno,$link);
 $consulta_ai="SELECT  * FROM atencion_inicial WHERE control = '$control' LIMIT 1";
 $consulta_ai = mysql_query($consulta_ai,$link); 
 
 $id_turno=mysql_result($consulta_turno,0,"id_turno");
 $id=mysql_result($consulta_turno,0,"id_usuario");
 $id_ai=mysql_result($consulta_ai,0,"consecutivo");
 $pin=mysql_result($consulta_ai,0,"pin");
 $ingreso=mysql_result($consulta_ai,0,"timestamp_atencion");
 $ingreso =date('Y-m-d G:i',$ingreso);

include_once ("../suscriptores/presentacion/datos.php");
echo "<div name='cabecera' id='cabecera' ><a href='#'  onclick=SoloCerrar();>[Cerrar]</a><hr></div>";
$nuevo_select .= "<table border='0'>
							<tr valign='top'>
								<td>
									<img src='../images/logo_small.gif' alt='$_SESSION[razon_social]'>
								</td>
							</tr>
							<tr>
								";
echo $nuevo_select;
usuario_datos($id,"print");
$nuevo_select ="
								
							</tr>
							<tr>
								<td align='right'>
								<font size='-2'>Ingreso: <b>$ingreso</b></font>
								<div align='center'><br>Turno:<br> <font size='200'>[ $id_ai ]</font></div>
								 
								
								</td>
							</tr>
							<tr>
								<td>
								<div align='center'>Referencia de atención:<br><img   src='../includes/CDB/barcode.php?code=$id_turno&encoding=93&scale=1.8&mode=png'</div>
								</td>
							</tr>
							<tr>
								<td>
								<div align='center'>
								<img src='../images/vigilado_gris_200.gif' alt='Vigilado supersalud'>
								</div>
								</td>
							</tr>
							<tr>
								<td>
								<div align='center'>
								<font size='-2'>Un Proyecto De: <b>http://OpusLibertati.org</b>
								<br>Powered by <b>http://GaleNUx.com</b></font>
								</div>
								
								<hr>
								</td>
							</tr>
						</table>
						";

echo "$nuevo_select";


							}
?>
</body>
</html><?php
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
