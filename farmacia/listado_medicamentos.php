<?php

function listado_medicamentos($id_medicamento,$pos,$id_usuario){


$select .= "<select name='id_medicamento' id='id_medicamento' style='width: 400px; '

				onChange=\"xajax_revisar_medicamentos(this.value,'$id_usuario') \" >";
				

$select .= "<option  value='' selected >Medicamento</option>";
								
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");

$sql=mysql_query("SELECT * FROM medicamentos WHERE  estado = '1' ORDER BY nopos DESC , medicamento_nombre ASC",$link);

while( $row = mysql_fetch_array( $sql ) ) {
		if($row[nopos]=='1'){$pos='[No POS] ';}else{$pos='';}

if($row['id_medicamento'] == $id_medicamento)
{
$select .= "<option  value='".$row['id_medicamento']."' selected >$pos ".$row['medicamento_nombre']."</option>";
}
$select .= "<option  value='".$row['id_medicamento']."'>$pos ".$row['medicamento_nombre']." ".$row['concentracion_forma']."</option>";
														}
														
$select .= "</select><div name='estado' id='estado'></div><div name='confirmacion' id='confirmacion'></div>";
return $select;														
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