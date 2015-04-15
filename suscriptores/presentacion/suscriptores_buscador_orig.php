

<table width="85%" border="0" align=center >  
	<tr> 
		<td colspan="3">
			<center><h1><? echo $page; ?></h1>
			
		
			<script type="text/javascript">
function protoSend(){
var params = Form.serialize($('presForm'));
new Ajax.Updater('formBox', 'suscriptores/presentacion/suscriptores_buscador_procesar.php', {asynchronous:true, parameters:params});
}

function usuarioIncluir(){
var params = Form.serialize($('presForm2'));
new Ajax.Updater('formBox', 'suscriptores/proceso/usuarios_crear.php', {asynchronous:true, parameters:params});
}

</script>
	 <?php  	if ($_SESSION['grupo'] == "2"){ ?>
			<div id="nuevo" style="clear:both;"></div>
			<div id="formBox" style="clear:both;"></div>	 
	 <?php 

	 
	 include_once ("suscriptores_buscador_procesar.php"); 
	 } else { ?>
			
			<h2>Buscar <? echo "$page"; ?> por documento, nombre o tel&eacute;fono</h2> 
<?php include_once("suscriptores/librerias/Usuarios_Todos_Formato_Suggest.php");	  ?>
				
			
			<div id="nuevo" style="clear:both;"></div>
			<div id="formBox" style="clear:both;"></div>
			
		</td>
	</tr>
</table>

<?php } ?>
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
