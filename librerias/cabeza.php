<?php 
session_start();
// Comprobamos si existe la variable
include_once("includes/config.php"); 
if (
$_SESSION[$usuarios_sesion] != $usuarios_sesion
//!isset ( $_SESSION['grupo'] )
 ) {
 // Si no existe 
 header("Location: includes/error.php");
// echo "hola mundo2";
} 
include_once("librerias/conex.php"); 
$link=Conectarse(); 
$usuario=$_SESSION['usuario'];
$id_funcionario=$_SESSION['id_usuario'];
$horas=date('H');
$hora=date('g');
$ap=date('A');
$minutos=date('i');
$minutos_dia=(($horas*60));
$total_minutos_dia=(($horas*60)+$minutos);
$ahora=date('Y-m-d H:i:s');
$hoy=date('Y-m-d');
list( $ano, $mes, $dia ) = split( '[-]', $hoy );
$fecha_comas = $ano.",".$mes.",".$dia;
$hoy_timestamp=mktime(0,0,0, $mes, $dia, $ano);


include_once("includes/datos.php");


?>
<?
//incluímos la clase ajax
require ('../xajax/xajax.inc.php');

//instanciamos el objeto de la clase xajax
$xajax = new xajax();

require ('includes/funciones_XAJAX.php');

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequests();
?>
<html xmlns="http://www.w3.org/1999/xhtml"xml:lang="es" lang="es" dir="ltr">
<head>
<!-- prueba del select dianmico -->

<!-- fin de la prueba del select dinamin¡co -->
<script type="text/javascript">	 
function bloquea() {
	get('bloqueador').style.display='block';
	get('popup').style.display='block';
}
function desbloquea() {
	get('bloqueador').style.display='none';
	get('popup').style.display='none';
	
}
function cancela() {
	get('confirmacion').style.display='none';
							}	
function confirmacion() {
	get('confirmacion').style.display='block';
	
	
}

function get(id){ return document.getElementById(id)}   	 
  </script>

	<script language="JavaScript">
function lanzarSubmenu(){
   window.open("librerias/colores.php","ventana1","width=300,height=300,scrollbars=YES")
}
</script>
<script type="text/javascript">
function modificarElemento() {
colorin.bgColor = document.tercero_modificar.color.value;
}
</script> 

 <? $xajax->printJavascript("../xajax/");  ?>


<script language="JavaScript" src="librerias/scripts.js" type="text/javascript"></script>


<script type="text/javascript" src="librerias/autosuggest/js/bsn.AutoSuggest_2.1.3.js" charset="utf-8"></script>




  <title><? echo " // $_SESSION[$usuarios_sesion] // $usuarios_sesion //$empresa $aplicacion $page $usuario";  ?> salud ,medicina</title>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   
    <?php
include("estilos/css_especialistas.php");
 include("includes/calendario.js"); ?>

    <link href="estilos/calendario.css" rel="stylesheet" type="text/css">
     <link href="estilos/estilo.css" rel="stylesheet" type="text/css">
<link rel="SHORTCUT ICON" href="favicon.ico">

<script type="text/JavaScript">

<!--

function ping(thetime) {

setTimeout("xajax_ping()", thetime);

}

//-->

</script>

  
  </head>

<body document.onkeydown = stopRKey; style='height: 100%;' onload="ping('2000')">
<div style="position: absolute; visibility: visible; " id="capa_ping"></div>

<table style="text-align: left; margin-left: auto; margin-right: auto; width: 100%; height: 48px;" border="0" cellpadding="0" cellspacing="0">
 <tr>
 	<td></td>
 	<td colspan='3' style='background:#ffffff; '  valign='top'>

        
  <?php include("includes/menu_horizontal.php"); include("includes/inicio.php"); ?>
					

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
