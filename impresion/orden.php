<?php 
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: includes/error.php");
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
<body onload="javascript:resizeTo(800,600), window.print()" >
<?php

$id = $_REQUEST['id_usuario'];
include_once("../librerias/conex_pop.php");
$link=Conectarse();
impresion("$id");
function impresion($id){
global $link, $id_funcionario;
mysql_query("SET NAMES 'utf8'");
$titulo ="Orden";

$id = $_REQUEST['id_usuario'];
include_once ("../suscriptores/presentacion/datos.php");
echo "<div name='cabecera' id='cabecera' ><a href='#'  onclick=SoloCerrar();>[Cerrar]</a><hr></div>";
$nuevo_select .= "<table border='0'><tr valign='top'><td><img src='../images/logo_impresion.gif'></td><td>";
echo $nuevo_select;
/* $consulta = "SELECT id_usuario FROM turnos WHERE id_turno = '$id_turno' ";
$sql=mysql_query($consulta,$link);

if (mysql_num_rows($sql)!='0'){$id=mysql_result($sql,0,"id_usuario");}
*/
usuario_datos($id,"print");
$nuevo_select ="</td></tr></table><hr>";
$nuevo_select .="<ol>"; 
foreach ($_REQUEST['orden'] as $clave => $valor)
	{

$pos=mysql_query("SELECT *, ordenes.estado FROM ordenes, cups WHERE id_orden='$clave' AND ordenes.id_tipo_orden = cups.codigo",$link);

if (mysql_num_rows($pos)> 0){
mysql_query("
						UPDATE `ordenes` 
						SET `estado` = '1'
						WHERE `id_orden` ='$clave'
						LIMIT 1 ;",$link);

$nuevo_select .="<li>";
while( $row = mysql_fetch_array( $pos ) ) {

$nuevo_select .= "<h1>[ $id ]".$row['descripcion']."</h1><br>".$row['observaciones']."";
$id_especialista = $row['id_especialista'];
														}
										}

															}
$nuevo_select .="</ol><hr>";
echo "$nuevo_select";


especialista_datos($id_especialista,"especialista");
$nuevo_select ="";
echo "$nuevo_select";
pie_imprenta();

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
