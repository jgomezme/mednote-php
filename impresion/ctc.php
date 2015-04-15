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
<body onload="javascript:resizeTo(800,600), xwindow.print()" >
<?php

$id = $_REQUEST['id_usuario'];
include_once("../librerias/conex_pop.php");

$link=Conectarse();
impresion("$id");
function impresion($id){
global $link, $id_funcionario;
mysql_query("SET NAMES 'utf8'");
$titulo ="Orden ";

include_once ("../suscriptores/presentacion/datos.php");
echo "<div name='cabecera' id='cabecera' > <a href='#'  onclick=SoloCerrar();>[Cerrar]</a><hr></div>";
$nuevo_select .= "<table border='0'><tr valign='top'><td><img src='../images/logo_impresion.gif'></td><td>";
echo $nuevo_select;
usuario_datos($id,"print");
$nuevo_select ="<h1>$nombre_completo</h1></td></tr></table><hr>";
$nuevo_select .="<ul>"; 
foreach ($_REQUEST['orden'] as $clave => $valor)
	{

$pos=mysql_query("SELECT *, recetas_no_pos.estado  FROM recetas_no_pos, medicamentos WHERE id_receta_no_pos='$clave' AND recetas_no_pos.id_medicamento = medicamentos.id_medicamento",$link);

if (mysql_num_rows($pos)> 0){
//mysql_query("
//						UPDATE `ordenes` 
//						SET `estado` = '1'
//						WHERE `id_orden` ='$clave'
//						LIMIT 1 ;",$link);

$nuevo_select .="";
while( $row = mysql_fetch_array( $pos ) ) {

$nuevo_select .= "
<li>Medicamento solicitado:<br> <h1>".$row['medicamento_nombre']." ".$row['concentracion_forma']."</h1>
<li>Cantidad: <b>".$row['cantidad']." (".$row['cantidad_letras'].") ".$row['posologia']."</b> 
<li>Tiempo de respuesta esperada: <b>".$row['tiempo_respuesta']."</b>
<li>Resultado esperado con el tratamiento:<br> <b>".$row['efecto_deseado']."</b>
<li>Riesgo posible al no aplicarse el tratamiento: <br><b>".$row['riesgo']."</b>
<li>Efectos secundarios: <br><b>".$row['efectos_secundarios']."</b>
<li>Bibliografia u observaciones: <br><h5>".$row['observaciones']."</h5>
<hr>Medicamento POS usado anteriormente:<br> <b>".$row['pos_usado']."</b>
<br>Respuesta alcanzada con el medicamento usado anteriormente:<br><b>".$row['pos_usado_respuesta']."</b>
<br>Tiempo de utilizaci&oacute;n del medicamento POS:  <b>".$row['tiempo_utilizacion']."</b>
<br>Duración del tratamiento:  <b>".$row['duracion_tratamiento_no_pos']."</b>
";





$id_especialista = $row['id_especialista'];
														}
										}

															}
$nuevo_select .="<hr>";
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
