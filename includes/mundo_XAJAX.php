<?php
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: includes/error.php");
// echo "hola mundo2";
} 

//registramos la función creada anteriormente al objeto xajax


$xajax->registerFunction("generar_select");
$xajax->registerFunction("municipios");
$xajax->registerFunction("ciudades");
$xajax->processRequests();

///FUNCION PARA EL MUNDO


function generar_select ($formulario){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');

$pais = $formulario["cod_pais"];
$formulario = $formulario["formulario"];
include_once("config.php");
$conn = mysql_connect($Servidor,$Usuario,$Password); 
mysql_select_db($BaseDeDatos,$conn);

mysql_query ("SET NAMES 'utf8'");
if ($pais != "COL"){
$nuevo_select .= "Estado o provincia: <br><select name='cod_departamento' id='cod_departamento' onchange=\"xajax_ciudades(xajax.getFormValues('$formulario'))\">"; 	
	
$ssql = "SELECT * FROM geo_ciudad WHERE  cod_pais = '$pais' GROUP BY distrito_ciudad "; 
$rs = mysql_query($ssql,$conn); 

while( $row = mysql_fetch_array( $rs ) ) {
$nuevo_select .= '<option value="'.$row['distrito_ciudad'].'">' . $row['nombre_ciudad'] . '</option>/n';

}

$nuevo_select .= "</select>";
						}	ELSE {
			
$nuevo_select .= "Departamento: <br><select name='cod_departamento' id='cod_departamento' onchange=\"xajax_municipios(xajax.getFormValues('$formulario'))\">"; 	

$ssql = "SELECT * FROM geo_municipios_colombia GROUP by codigo_departamento"; 
$rs = mysql_query($ssql,$conn);
while( $row = mysql_fetch_array( $rs ) ) {
$nuevo_select .= '<option value="'.$row['codigo_departamento'].'">'. $row['nombre_departamento'] . '</option>/n';
}
$nuevo_select .= "</select>";
$borrar = "";
						  }				
$respuesta->addAssign("seleccombinado","innerHTML",$nuevo_select);
$respuesta->addAssign("selecmunicipios","innerHTML",$borrar);
return $respuesta;
}
////funcion municipios
function municipios($formulario){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$departamento = $formulario["cod_departamento"];
$formulario = $formulario["formulario"];
include_once("config.php");
$conn = mysql_connect($Servidor,$Usuario,$Password); 
mysql_select_db($BaseDeDatos,$conn); 
mysql_query ("SET NAMES 'utf8'");
$nuevo_select .= "Ciudad: <br><select id='cod_ciudad' name='cod_ciudad'>";	
$ssql = "SELECT * FROM geo_municipios_colombia WHERE  codigo_departamento = '$departamento'  "; 
$rs = mysql_query($ssql,$conn);
while( $row = mysql_fetch_array( $rs ) ) {
$nuevo_select .= '<option value="'.$row['codigo_municipio'].'">' . $row['nombre_municipio'] . '</option>/n';
}
$nuevo_select .= "</select>";
$respuesta->addAssign("selecmunicipios","innerHTML",$nuevo_select);
return $respuesta;
}
////fin funcion municipios

////funcion ciudades
function ciudades($formulario){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$distrito = $formulario["distrito_ciudad"];
$formulario = $formulario["formulario"];
include_once("config.php");
$conn = mysql_connect($Servidor,$Usuario,$Password); 
mysql_select_db($BaseDeDatos,$conn);
mysql_query ("SET NAMES 'utf8'");
$nuevo_select .= "Ciudad:<br> <select id='cod_ciudad' name='cod_ciudad'>";	
$ssql = "SELECT * FROM geo_ciudad WHERE  distrito_ciudad = '$distrito'  "; 
$rs = mysql_query($ssql,$conn);
while( $row = mysql_fetch_array( $rs ) ) {
$nuevo_select .= '<option value="'.$row['nombre_ciudad'].'">' . $row['nombre_ciudad'] . '</option>/n';
}
$nuevo_select .= "</select>";
$respuesta->addAssign("selecmunicipios","innerHTML",$nuevo_select);
return $respuesta;
}

//// FIN FUNCION PARA EL MUNDO
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
