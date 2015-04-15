<?php
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: ../../includes/error.php");
// echo "hola mundo2";
} 

if($_SESSION['grupo']!='1'){$id_empresa= $_SESSION['id_empresa'];}else {$id_empresa='%%';}
		$sql=mysql_query("
																			SELECT 
																				turnos.id_turno,
																				turnos.fecha, 
																				turnos.especialista,
																				d9_users.nombre_completo,
																				turnos.id_procedimiento ,
																				turnos.id_evento 
																				
																				
																			FROM 
																				turnos, 
																				d9_users
																			WHERE 
																				 d9_users.id = turnos.id_usuario
																				 AND ( turnos.id_factura IS NULL OR turnos.id_factura ='')
																				 AND turnos.id_empresa LIKE '$id_empresa'
																			
																			ORDER BY turnos.id_factura DESC , id_usuario, fecha ASC
																			",$link);

			/// SI HAY PROCESOS SIN FACTURAR												
	
			if (mysql_num_rows($sql)!='0'){
														$nuevo_select .= "<select name='id_turno' id='id_turno' style='width: 400px;'>";
																											
															$nuevo_select .= "<option value=''>Procesos sin facturar </option>"; 
																			while( $row = mysql_fetch_array( $sql ) ) 
																			{			
																																							
																			
																			if ($row['factura_descripcion'] ==''){$descripcion = $row['nombre'];} 
																				else {$descripcion = $row['factura_descripcion'];}
																			if ($row['factura'] ==''){$factura = $factura_actual;} 
																				else {$factura = $row['factura'];}
																			
																				$especialista =$row['especialista'];
																						$Especialista=mysql_query("SELECT p_apellido, color , d9_users.id
																																				FROM d9_users, especialistas
																																				WHERE d9_users.id = $especialista AND  especialistas.id = d9_users.id
																																				",$link); 
																						$especialista = mysql_result($Especialista,0,"p_apellido");
																						$color = mysql_result($Especialista,0,"id");
																						$cups = $row['id_evento'];
																						$otro_servicio = $row['id_procedimiento'];
																						$id_turno = $row['id_turno'];
																						$fecha = $row['fecha'];
																						$paciente = $row['nombre_completo'];
																						$recibo = $row['recibo'];
																						if($cups > '0'){
																						$Cups=mysql_query("SELECT cups, nombre
																																				FROM eventos
																																				WHERE id_evento = '$cups'
																																				",$link); 
																						$servicio = mysql_result($Cups,0,"cups"); 
																						$servicio_nombre = mysql_result($Cups,0,"nombre");
																														}// else {$cups =''; $cups_nombre='';}
																						elseif($otro_servicio > '0'){
																						$Otros_servicios=mysql_query("SELECT *
																																				FROM otros_servicios
																																				WHERE id_procedimiento = '$otro_servicio'
																																				",$link); 
																						$servicio = mysql_result($Otros_servicios,0,"codigo"); 
																						$servicio_nombre = mysql_result($Otros_servicios,0,"descripcion");
																														}///else {$otro_servicio ='NA'; $otro_servicio_nombre='NA';}
																						else {$servicio =''; $servicio_nombre='';}
																						
																				$nuevo_select .= "<OPTION value='$id_turno'  class='C$color' title='-< $paciente  ($recibo) >-'  >$fecha $servicio_nombre $servicio [$especialista]</option>";
																																								
																			}
																			$nuevo_select .="</select>";														
																				
																		}else 
																		{ $nuevo_select .= "<h1>No hay procesos pendientes</h1>";
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
