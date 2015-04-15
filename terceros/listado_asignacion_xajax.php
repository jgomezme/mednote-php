<?php
$id_empresa = $_SESSION['id_empresa'];
if ($_SESSION['grupo'] == '3'){$asistencial = '1';}
elseif ($_SESSION['grupo'] == '8'){$asistencial = '1';}
elseif ($_SESSION['grupo'] == '9'){$asistencial = '1';}
else{$asistencial = '0';}
if($asistencial =='1'){$grupo="GROUP BY razon_social";}
$nuevo_select .= "<select name='id_cliente' title='Elija un cliente, eps o aseguradora ' style='width: 400;text-align: left;'  >"; 
if ($id_cliente !=''){

$tipo_definido=mysql_query("SELECT * FROM clientes WHERE  id_cliente = '$id_cliente'",$link);
if(mysql_num_rows($tipo_definido) >0) {

while( $row = mysql_fetch_array( $tipo_definido ) ) {
if ($asistencial =='1'){$contrato="";}else{$contrato="| $row[numero_contrato]";}
$nuevo_select .= "<option value='".$row['id_cliente']."' selected> > ".$row['razon_social']." $contrato < </option>";}
																			}

					}else {$nuevo_select .= "<option value='' selected>EPS o aseguradora</option>
																	
																	"; }
$Productos=mysql_query("SELECT * FROM clientes WHERE id_empresa ='$id_empresa'  $grupo ORDER BY alias",$link);
if(mysql_num_rows($Productos) >0) {


while( $row = mysql_fetch_array( $Productos ) ) {
if ($asistencial =='1'){$contrato="";}else{$contrato="| $row[numero_contrato]";}
$nuevo_select .= "<option value='".$row['id_cliente']."'> ".$row['alias']." $contrato </option>";

}
$nuevo_select .= "</select>"; 
												}
												else {$nuevo_select .= "<img src='images/atencion.gif' alt='!' title='No hay informacion sobre la EPS o aseguradora '>No hay informaci&oacute;n de EPS";}
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
