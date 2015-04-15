<?php 
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: ../includes/error.php");
// echo "hola mundo2";
} 

/// temporalmente se asume la empresa "1" pero se debe integrar una variable de session que marque y
/// relacione la empresa con cada usuario 
if($_SESSION['grupo']!='1'){$id_empresa= $_SESSION['id_empresa'];}else {$id_empresa='%%';}
mysql_query("SET NAMES 'utf8'");
$empresa=mysql_query("SELECT empresa.*,  geo_municipios_colombia.nombre_departamento ,geo_municipios_colombia.nombre_municipio
											FROM empresa, geo_municipios_colombia , tarifas
											WHERE id_empresa like '$id_empresa' 
											
											AND geo_municipios_colombia.codigo_departamento = empresa.departamento
											AND geo_municipios_colombia.codigo_municipio = empresa.ciudad
											LIMIT 1",$link);
$resolucion_facturacion=mysql_result($empresa,0,"resolucion_facturacion");
$facturacion_desde=mysql_result($empresa,0,"facturacion_desde");
$facturacion_hasta=mysql_result($empresa,0,"facturacion_hasta");
$facturacion_primera=mysql_result($empresa,0,"facturacion_primera");
$facturacion_prefijo=mysql_result($empresa,0,"facturacion_prefijo");
$razon_social=mysql_result($empresa,0,"razon_social");
$slogan=mysql_result($empresa,0,"slogan");
$nit=mysql_result($empresa,0,"nit");
$regimen_tributario=mysql_result($empresa,0,"regimen_tributario");
$direccion=mysql_result($empresa,0,"direccion");
$telefono_1=mysql_result($empresa,0,"telefono_1");
$telefono_2=mysql_result($empresa,0,"telefono_2");
$telefono_3=mysql_result($empresa,0,"telefono_3");
$web=mysql_result($empresa,0,"web");
$email=mysql_result($empresa,0,"email");
$ciudad=mysql_result($empresa,0,"nombre_municipio");
$departamento=mysql_result($empresa,0,"nombre_departamento");
//$=mysql_result($empresa,0,"");
//$=mysql_result($empresa,0,"");


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
