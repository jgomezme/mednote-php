<?php 
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: ../includes/error.php");
// echo "hola mundo2";
} 

//incluímos la clase ajax
require ('../../xajax/xajax.inc.php');

//instanciamos el objeto de la clase xajax
$xajax = new xajax();

require ('../impresion/funciones/impresion.php');


//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequests();
?>
 <? $xajax->printJavascript("../../xajax/");  ?>
  <link href="../estilos/impresion.css" rel="stylesheet" type="text/css">
 </head>
<body onload="javascript:resizeTo(400,600);" >
<?php

echo "<div name='impresion' id='impresion'></div>";
$id = $_REQUEST[id_usuario];
$id_turno = $_REQUEST[id_turno];

impresion("$id");
function impresion($id){
$titulo ="Ordenes";
$nuevo_select = "";
$id = $_REQUEST[id_usuario];
$id_turno = $_REQUEST[id_turno];
include_once("../librerias/conex_pop.php");

 
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
$ordenes=mysql_query("SELECT *, ordenes.estado FROM ordenes, cups WHERE id_turno='$id_turno' AND ordenes.id_tipo_orden = cups.codigo",$link);
if (mysql_num_rows($ordenes)> 0){
$nuevo_select .= "<h2>$titulo pendientes de impresi&oacute;n</h2>
<form name='imprimir_ordenes' id='imprimir_ordenes'>

<ol>";
$nuevo_select .="<input type='hidden' name='id_usuario' id='id_usuario' value='$id'><input type='hidden' name='id_turno' id='id_turno' value='$id_turno'>";
while( $row = mysql_fetch_array( $ordenes ) ) {

$nuevo_select .= "<li title='".$row['observaciones']."'><input type='checkbox' id='orden[".$row['id_orden']."]' name='orden[".$row['id_orden']."]' onchange= \"xajax_impresion_ordenes(xajax.getFormValues('imprimir_ordenes')); \" > ".$row['descripcion']." ";
if ($row['estado'] =='0'){$nuevo_select .= " ";}
if ($row['estado'] =='1'){$nuevo_select .= "<img src='../images/check.gif' alt='Impresa'> ";}
$nuevo_select .= "</li>";
}
										

$nuevo_select .= "</ol></form>";															}
echo "$nuevo_select";
							}
?>
</body><?php
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
