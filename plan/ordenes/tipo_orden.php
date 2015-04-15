<?php
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: includes/error.php");
// echo "hola mundo2";
} 



$campos_formulario_usuario .= "

	
	Ordenes y procedimientos:<br>
	<input style='width: 500px' type='text' id='nombre' name='nombre' value='' 
	onclick=\"this.value=''; document.getElementById('id_tipo_orden').value=''\"
	
				  />  
				 <input type='hidden' id='id_tipo_orden' name='id_tipo_orden' value='' readonly >
					<input type='button' value='Ordenar' onClick=\"xajax_revisar_orden(document.getElementById('id_tipo_orden').value);\"> 				 
				 <br>
	<div  id='confirmar_orden'></div>
	<div name='estado_orden' id='estado_orden' ></div>
	
	
	<br>
";	
$campos_formulario_usuario .="
<script type='text/javascript'>
	var options = {
		script:'plan/ordenes/test.php?json=true&limit=10&',
		varname:'input',
		json:true,
		delay:6,
		timeout:50000,
		shownoresults:false,
		maxresults:20,
		callback: function (obj) { document.getElementById('id_tipo_orden').value = obj.id; }
	};
	var as_json = new bsn.AutoSuggest('nombre', options);
	

</script>
";
																			
echo $campos_formulario_usuario;

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
