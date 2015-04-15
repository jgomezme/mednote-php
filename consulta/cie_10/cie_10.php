<?php
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: ../../includes/error.php");
// echo "hola mundo2";
} 

?>
<html>
<head>
<script type="text/javascript" src="../../librerias/autosuggest/js/bsn.AutoSuggest_2.1.3.js" charset="utf-8"></script>
<script>

function SoloCerrar(){
window.close()
}

</script>
</head>
<body onload="javascript:resizeTo(600,200);">
</body>
</html>
<?php
include_once("../../librerias/conex.php"); 

$link=Conectarse(); 
$campos_formulario_cie_10 .= "";
mysql_query("SET NAMES 'utf8'");

$campos_formulario_cie_10 .= "

	
	Buscar: Cie10<br>
	<input style='width: 90%' type='text' id='30' name='30' value='' 
				title ='Escriba parte de diagnóstico y seleccione' /> 
			<br> 
	<div name='orden_cie10' id='orden_cie10' >";

$campos_formulario_cie_10 .= "	Cie 10:$obligatorio <input type='text' id='cie_10' name='29' value='' size='5' title ='Escriba para obtener el cie10' onClick='this.select();'/> 
<a href=\"javascript: SoloCerrar(); \">cerrar</a>
<ol><li>Búsque el codigo</li>
		<li>Señale el campo CIE 10</li>
		<li>Arrastrelo hasta el lugar donde quiere incluir el codigo</li>
		</ol>
";
																
$campos_formulario_cie_10 .= " 
	</div>
	
";	
$campos_formulario_cie_10 .="
<script type='text/javascript'>
	var options = {
		script:'test.php?json=true&limit=6&',
		varname:'input',
		json:true,
		shownoresults:true,
		noresults:'No se encuentran coincidencias',
		maxresults:16,
		timeout:5000,
		callback: function (obj) { document.getElementById('cie_10').value = obj.id; }
	};
	var as_json = new bsn.AutoSuggest('30', options);
	

</script></div>
";
																			
//echo $campos_formulario_cie_10;
 echo $campos_formulario_cie_10;
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
