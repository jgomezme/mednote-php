<?php 
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: error.php");
// echo "hola mundo2";
} 
if($_SESSION['grupo']=='1'){
echo "<h1>Parametrizaci&oacute;n de datos</h1>
<li><a onclick=\"xajax_parametrizacion_editar_sucursal('','','capa_sucursal','')\">Sucursales o áreas de servicio</a></li>
<div id='capa_sucursal' name='capa_sucursal'></div>
<li><a onclick=\"xajax_parametrizacion_tipo_consulta('consultar_listado','capa_tipo_consulta','')\">Parametrizar tipos de consulta</a></li>
<div id='capa_tipo_consulta' name='capa_tipo_consulta'></div>
<li><a  onClick=\"xajax_importar('listado','capa_subir_contratos','clientes','terceros/temporal/')\">Importar Usuarios</a></li>
		<div id='capa_subir_contratos' name='capa_subir_contratos'></div>
<li><a  onClick=\"xajax_parametrizacion_medicamentos('','','capa_parametrizar_medicamentos')\">Edición de medicamentos</a></li>
		<div id='capa_parametrizar_medicamentos' name='capa_parametrizar_medicamentos'></div>

";		
		}

		/*
include_once("parametrizacion/grupos.php");
include_once("parametrizacion/tipo_usuario.php");
include_once("parametrizacion/escolaridad.php");
include_once("parametrizacion/tipo_documento_id.php");
include_once("parametrizacion/estado_civil.php");
include_once("parametrizacion/tipo_orden.php");
include_once("parametrizacion/plan_beneficio.php");

include_once("parametrizacion/ayuda_clases.php");
*/
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
