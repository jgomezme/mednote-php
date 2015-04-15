<?php 
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: includes/error.php");
// echo "hola mundo2";
} 
include_once("librerias/conex.php"); 
$link=Conectarse(); 
$usuario=$_SESSION['usuario'];
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
 <? $xajax->printJavascript("../xajax/");  ?>

<script language="JavaScript" src="librerias/prototype.js" type="text/javascript"></script>
<script language="JavaScript" src="librerias/scripts.js" type="text/javascript"></script>
<script language="JavaScript" src="librerias/validation.js" type="text/javascript"></script>
<script language="JavaScript" src="gen_validatorv2.js" type="text/javascript"></script>
<script type="text/javascript" src="librerias/bsn.AutoSuggest_2.1.3.js" ></script>

<script language="Javascript">
<!--
 function doClear(theText) {
     if (theText.value == theText.defaultValue) {
         theText.value = ""
     }
 }

//-->
</script>

  <title><? echo "$empresa $aplicacion $page $usuario"; ?></title>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="estilos/estilo.css" rel="stylesheet" type="text/css">
  <link rel="SHORTCUT ICON" href="icono.ico"></head>

<body>
<div align="right"><a href='includes/salir.php' title='Salir y cerrar la sesi&oacute;n'>[X]SALIR </a></div>

<table style="text-align: left; margin-left: auto; margin-right: auto; width: 98%; height: 48px;" border="0" cellpadding="0" cellspacing="0">
  
    <tr>
     
      <td style=" text-align: center; vertical-align: top;" colspan="2">
      <table style=" width: 100%; text-align: left; margin-left: auto; margin-right: auto;" align="center" border="0" cellpadding="0" cellspacing="0">
          
            
            <tr> 
              	<td colspan="1" rowspan="1" width="10%" >
              	<div id="mensajes"><font size=-3 ></div>
              	</td>
              	<td colspan="1" rowspan="1" width="100%" >
              		              		       		
               </td>
            </tr>
        </table>
     </tr>
     <tr>
         <td style=" text-align: left; vertical-align: top; width: 150;" >
        <table style=" width: 100%;  text-align: left; vertical-align: top;" border="0" cellpadding="0" cellspacing="0">
        <tr><td>
        
  
        <br>
      <?include ("includes/menu.php"); ?><br></td></tr></table>
      <div id='enlinea' style="display:none">enlinea</div>
      <div id='online' ></div>
      
      <div id='estado'></div>
      
         </td>                  
          <td class="box"  ><br>
           <center><table style="width: 98%;" HEIGHT="400" border="0" cellpadding="0" cellspacing="0">
           <tr><td style=" text-align: left; vertical-align: top;  background-color: ffffff;">

      <div id='online' ></div>
      
      <div id='estado'></div>
      
         </td>                  
          <td  class="box" ><br>
           <center><table style="width: 98%;" HEIGHT="400" border="0" cellpadding="0" cellspacing="0">
           <tr><td style=" text-align: left; vertical-align: top;">
          
					<?php if ( isset ( $_REQUEST['page'] ) )  
					{$page=$_REQUEST['page']; include_once("$page/$page.php");} 
					
					
					
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
