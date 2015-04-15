<?php 
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: includes/error.php");
// echo "hola mundo2";
} 
echo "[$id_factura]";
mysql_query("SET NAMES 'utf8'");
$turnos=mysql_query("
																			SELECT 
																				turnos.id_turno,
																				turnos.id_usuario,
																				turnos.fecha, 
																				turnos.especialista,
																				turnos.factura_descripcion,
																				d9_users.nombre_completo, 
																				eventos.nombre,
																				codigo,
																				eventos.cups,
																				turnos.id_factura,
																				turnos.recibo,
																				turnos.cantidad,
																				valor_procedimiento,
																				excedente,
																				turnos.total ,
																				turnos.especialista as id_especialista,
																				d9_users.documento_tipo,
																				d9_users.documento_numero
																			FROM 
																				turnos, 
																				d9_users,
																				eventos ,
																				clientes
																			WHERE  turnos.id_factura = '$id_factura' 
																			AND d9_users.id = turnos.id_usuario
																			AND eventos.id_evento = turnos.id_evento 
																			AND clientes.id_cliente =turnos.id_cliente
																			AND turnos.autorizacion= '1'
																			ORDER BY turnos.id_factura DESC , id_usuario, fecha ASC
																			",$link);

			/// SI HAY PROCESOS SON FACTURAR PARA ESE CLIENTE														
	
			if (mysql_num_rows($turnos)!='0'){
																											
															$nuevo_select .= "
															<hr>
														<table border='0'  width= '100%' align='center' cellpadding='3' >
															<tr>
																<td><font size='-1'><CENTER><b>ID</b></font></td>	
																<td><font size='-1'><b>Cant</b></font></td>
																<td><font size='-1'><CENTER><b>Usuario</b></font></td>
																<td><font size='-1'><b>CUPS</b></font></td>
																<td><font size='-1'><b>Autorización</b></font></font></td>
																<td><font size='-1'><center><b>[AAAA-MM-DD] Descripción</b></font></td>
																<td nowrap><font size='-1'><CENTER><b>Valor $</b></font></td>
																<td nowrap><font size='-1'><CENTER><b>Coopago $</b></font></td>
																<td nowrap><font size='-1'><CENTER><b>Total $</b></font></td>
															</tr> "; 
																			while( $row = mysql_fetch_array( $turnos ) ) 
																			{			
																																							
																			
																			
																			$nuevo_select .= "
															<tr valign='top'>
																				<td valign='top' ><div align='right'><font size='-2'>".$row['id_turno']."</div></td>
																				<td><div align='right'>".$row['cantidad']."</div></td>	
																				<td><font size='-2'>".$row['nombre_completo']."<br>Doc ".$row['documento_numero']."</font></td>
																				<td><div align='right'>".$row['cups']."</div></td>
																				<td><div align='right'>".$row['recibo']."</td>
																				<td><font size='-1'>[".$row['fecha']."] ".$row['factura_descripcion']."</font></td>
																				<td nowrap><div align='right'><font size='-1'> ".number_format($row['valor_procedimiento'], 2, ',', '.')." </div></td>
																				<td nowrap><div align='right'><font size='-1'> ".number_format($row['excedente'], 2, ',', '.')." </div></td>
																				<td nowrap><div align='right'><font size='-1'> ".number_format($row['total'], 2, ',', '.')." </div></td>
															</tr>";
																																								
																			}
																			$nuevo_select .="
													</table>
													<hr>												";
															
																				
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
