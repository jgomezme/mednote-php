<?php
require ('../xajax/xajax.inc.php'); 
$xajax = new xajax(); 
//registramos la función creada anteriormente al objeto xajax
$xajax->registerFunction("area");
$xajax->processRequests();

function area($form_entrada){ 
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$peso=$form_entrada['peso'];
$altura=$form_entrada['altura'];
$seleccionarpor=$form_entrada['seleccionarpor'];

	if ($seleccionarpor == 1){
		$haycock=0.024265*(pow($peso,0.5378))*(pow($altura,0.3964));
		echo $haycock;
	}
	elseif ($seleccionarpor == 2){
		$area=0.007184*(pow($peso,0.425))*(pow($altura,0.725));
	}
	elseif ($seleccionarpor == 3){
		$area=0.0235*(pow($peso,0.51456))*(pow($altura,0.42246));
	}
	elseif ($seleccionarpor == 4){
		$peso=$peso*1000;
		$area=0.0003207*(pow($peso,(0.7285-(0.0188*log10($peso)))))*(pow($altura,0.3));
	}
	elseif ($seleccionarpor == 5){
		$area=pow((($pesoo*$alturaa)/3600),0.5);
	}

$nuevo_select = 'Su superficie corporal es de: '.$area;
$respuesta->addAssign("capaarea","innerHTML",$nuevo_select);
return $respuesta;
}
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
