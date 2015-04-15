<?php
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: ../includes/error.php");
// echo "hola mundo2";
} 

/// listado de consultas por usuario
///listado_consultas("$id_usuario","todas");

function listado_turnos($id_usuario,$estado){

$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
$sql=mysql_query("SELECT turnos.*, eventos.nombre , turnos_estado.nombre_estado AS estado, d9_users.nombre_completo AS especialista,
										especialistas.color as color
									FROM turnos, eventos ,turnos_estado, d9_users, especialistas
									WHERE id_usuario = '$id_usuario' 
									AND turnos.id_evento = eventos.id_evento 
									AND turnos.estado = turnos_estado.id_estado
									AND turnos.especialista = d9_users.id
									AND turnos.especialista = especialistas.id
									ORDER BY fecha DESC, hora_inicio DESC",$link);



if (mysql_num_rows($sql)!='0'){
$nuevo_select .= "<center><h2>Consultas y procedimientos referentes a este usuario</h2>
<table border='0'  width='90%' colspan='2' rowspan='2' align='center' valign='top'>
<tr bgcolor='#EEEDD1' title='Ubique el puntero sobre la fila para conocer el especialista que atiende'>
	<td><strong>Fecha/Hora</strong></td>
	<td><strong>Usuario/observaciones</strong></td>
	<td><strong>Estado</strong></td>
	<td><strong>Factura</strong></td>
	<td><strong>Autorizacion</strong></td></tr>
";
												while( $row = mysql_fetch_array( $sql ) ) {
												if($row['observaciones'] !=''){$observaciones = "<font size='-2'><br>".$row['observaciones']."</font>";}else{$observaciones='';}
												if($row['color'] !=''){$color = $row['color'];}else {$color="ffffff";}
												$nuevo_select .= "<tr title='Atendido por ".$row['especialista']."' bgcolor='#$color'  onMouseOver=\"uno(this,'yellow');\" onMouseOut=\"dos(this,'#$color');\"><td>".$row['fecha']." ".$row['hora_inicio']."</td><td><strong>".$row['nombre']."</strong> $observaciones</td><td>".$row['estado']."</td><td>".$row['factura']."</td><td>".$row['recibo']."</td></tr>";
																																	}
$nuevo_select .= "</table></center>";
						}
$otros_servicios=mysql_query("SELECT turnos.*, otros_servicios.descripcion , turnos_estado.nombre_estado AS estado, d9_users.nombre_completo AS especialista,
										especialistas.color as color
									FROM turnos, otros_servicios ,turnos_estado, d9_users, especialistas
									WHERE id_usuario = '$id_usuario'
									AND turnos.id_procedimiento = otros_servicios.codigo 
									AND turnos.estado = turnos_estado.id_estado
									AND turnos.especialista = d9_users.id
									AND turnos.especialista = especialistas.id
									ORDER BY fecha DESC, hora_inicio DESC",$link);



if (mysql_num_rows($otros_servicios)!='0'){
$nuevo_select .= "<center><h2>Otros procedimientos</h2>
<table border='0'  width='90%' colspan='2' rowspan='2' align='center' valign='top'>
<tr bgcolor='#EEEDD1' title='Ubique el puntero sobre la fila para conocer el especialista que atiende'>
	<td><strong>Fecha/Hora</strong></td>
	<td><strong>Usuario/observaciones</strong></td>
	<td><strong>Estado</strong></td>
	<td><strong>Factura</strong></td>
	<td><strong>Autorizacion</strong></td></tr>
";
												while( $row = mysql_fetch_array( $otros_servicios ) ) {
												if($row['observaciones'] !=''){$observaciones = "<font size='-2'><br>".$row['observaciones']."</font>";}else{$observaciones='';}
												if($row['color'] !=''){$color = $row['color'];}else {$color="ffffff";}
												$nuevo_select .= "<tr title='Atendido por ".$row['especialista']."' bgcolor='#$color'  onMouseOver=\"uno(this,'yellow');\" onMouseOut=\"dos(this,'#$color');\"><td>".$row['fecha']." ".$row['hora_inicio']."</td><td><strong>".$row['nombre']."</strong> $observaciones</td><td>".$row['estado']."</td><td>".$row['factura']."</td><td>".$row['recibo']."</td></tr>";
																																	}
$nuevo_select .= "</table></center>";
															}
return $nuevo_select;
} 

/// fin dummy

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
