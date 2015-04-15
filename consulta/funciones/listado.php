<?php
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
// Si no existe 
header("Location: ../includes/error.php");
// echo "hola mundo2";
} 



/// listado de consultas por usuario  dividida en areas
///listado_areas("$id_usuario","todas");

function listado_areas($id_usuario,$id_turno,$autorizado){

$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
$sql=mysql_query(" SELECT turnos.*, turnos.id_evento, turnos.id_procedimiento , turnos_estado.nombre_estado AS estado, d9_users.nombre_completo AS especialista,
									especialistas.color as color
									FROM turnos ,turnos_estado, d9_users, especialistas
									WHERE turnos.id_turno = '$id_turno' 
									
									AND turnos.estado = turnos_estado.id_estado
									AND turnos.especialista = d9_users.id
									AND turnos.especialista = especialistas.id
									AND turnos.estado >= '4'
									GROUP BY turnos.id_turno
									ORDER BY turnos.id_turno DESC 
										
										",$link);

$sql_atenciones ="SELECT timestamp, perfil, consulta_tipo_nombre, id_especialista
							FROM consulta_datos, consulta_tipo 
							WHERE id_turno = '$id_turno' 
							AND consulta_tipo.id_consulta_tipo = consulta_datos.perfil
							GROUP BY timestamp";
//// se clasifican las atenciones dentro de un turno por el timestamp
$atenciones = mysql_query($sql_atenciones,$link); 
if (mysql_num_rows($atenciones)!='0'){ /// si hay atenciones en ese turno

while( $row = mysql_fetch_array( $atenciones )) { /// empiezan a mostrarse la atenciones agrupas por timestamp
$tiempo_atencion = date('Y-m-d H:i:s',$row[timestamp]);
$atendido_por = usuario_datos_consultar($row[id_especialista],usuario,'nombre_completo');
$timestamp_atencion= $row[timestamp];
$perfil = $row[perfil];
$impresion= impresion($id_usuario,$timestamp_atencion,$perfil,$id_turno);
$estado_turno = usuario_datos_consultar($id_turno,'turnos_usuario','estado');
															
	$listado_atenciones .="<td colspan='2'><hr><b title ='Fecha y hora de atención'>$tiempo_atencion</b>
									<br><b title='Tipo de Ateción '>$row[consulta_tipo_nombre]</b> | <b title='Funcionario que atendió'>$atendido_por</b> 
									<br>$impresion </td>";	
	
	$sql_areas=" 
													SELECT 
													consulta_areas.id_consulta_area,
													consulta_areas.consulta_area_nombre
													FROM 
													consulta_areas 
																									
													ORDER BY consulta_areas.orden";		
												$consulta_areas=mysql_query($sql_areas,$link);
										//		$listado_atenciones .= "$sql_areas";
if (mysql_num_rows($consulta_areas)!='0'){/// si hay datos en la consulta
while( $row = mysql_fetch_array( $consulta_areas ) ) {//// se clasifica por area
$listado_atenciones .= "<tr valign='top' ><td colspan='2'><font color='#BDBDBD'> <b>".$row['consulta_area_nombre']."</b></font></td></tr>";
$area = $row['id_consulta_area'];
$id_consulta_datos = $row['id_consulta_datos'];
/// los campos de cada area
///se buscan los datos de la consulta
$sql_datos_consulta ="
					SELECT consulta_datos.id_campo AS id_campo ,consulta_datos.id_consulta_datos,
					consulta_datos.contenido, 
					consulta_campos.campo_nombre  , 
					consulta_campos.campo_descripcion,
					consulta_datos.bloqueo  
					FROM 
					consulta_datos, 
					consulta_campos 
					WHERE 
					consulta_datos.id_turno = '$id_turno' 
					AND consulta_datos.timestamp = $timestamp_atencion
					AND consulta_campos.id_consulta_campo = consulta_datos.id_campo 
					AND consulta_campos.campo_area = $area
					ORDER BY consulta_campos.orden 
					";
//$listado_atenciones .= "$sql_datos_consulta";
$datos_consulta=mysql_query($sql_datos_consulta,$link);
$estado_turno = usuario_datos_consultar($id_turno,'turnos_usuario','estado');
if (mysql_num_rows($datos_consulta)!='0'){
while( $row = mysql_fetch_array( $datos_consulta ) ) {
$bloqueado = $row['bloqueo']; 
if($row['id_campo']>='12'  AND $row[id_campo] <= '15'){$bloqueado=''; $contenido = usuario_datos_consultar($row[contenido],cie10,descripcion);}
																else{$contenido = $row[contenido]; $bloqueado=''; }
																if($estado_turno > 4){$bloqueado ='1';}
//$listado_atenciones = verifica_campo($row['id_consulta_datos'],'consulta_datos');
$listado_atenciones .= "<tr valign='top'  bgcolor='white'  onMouseOver=\"uno(this,'#c2f0e5');\" onMouseOut=\"dos(this,'white');\">
										<td  align='right'  width='25%' title=' ".$row['campo_descripcion']."'><b> ".$row['campo_nombre'].": </b></td>
										<td valign='top'><div id='capa_$row[id_consulta_datos]' style='display:inline;'>
															".revisar_campo_consulta($row['id_consulta_datos'],'confirmacion','revisar_campo',$autorizado)." ";
							
							if($bloqueado !='1'){	/// si esta bloqueado	
											
$listado_atenciones .= "<a onclick=\"xajax_tipo_campo_consulta('$row[id_consulta_datos]','capa_$row[id_consulta_datos]','form')\">$contenido </a>"; 
//$nuevo_select .= "".$row['contenido']." </a>";
															}///fin de esta bloqueado
															else{		///si no esta bloqueado						
$listado_atenciones .= " $contenido";
															}///fin de si noesta bloqueado
$listado_atenciones .= "</div></td>
									</tr>";
															}/// fin d el array para datos de la consulta
															
										}/// fin de si hay resultados en $datos_consulta

/// fin de los campos de cada area

															}
															
															
										}	//	else{$listado_atenciones.="MANO PELUDA";}			
																												
																	}///fin de las atenciones mostradas por timestamp
																	
												}/// fin de las atenciones en ese turno
											//	else{$listado_atenciones.="MANO PELUDA";}
/// fin de la clasificacion de atenciones por timestamp
if (mysql_num_rows($sql)!='0'){
$nombre_paciente = usuario_datos_consultar($id_usuario,'usuario','nombre_completo');
$nuevo_select .= "<center><h2>Resumen de atenciones</h2></center>
 [$id_usuario] //$nombre_paciente
<table border='0'  width='80%' align='center' valign='top'>
$listado_atenciones
</table>
<table border='0'  width='95%' colspan='2' rowspan='2' align='center' valign='top'>

";
												while( $row = mysql_fetch_array( $sql ) ) {
												$turno=$row['id_turno'];
												if($id_turno == $turno){$color_turno ='#F49393'; $borde_turno ='1';}else {$color_turno ='#EEEDD1';$borde_turno ='0';}
												if($row['observaciones'] !=''){$observaciones = "<font size='-2'>".$row['observaciones']."</font>";}else{$observaciones='';}
												if($row['color'] !=''){$color = $row['color'];}else {$color="ffffff";}
			$nuevo_select .= "
												<tr title='Atendido por ".$row['especialista']."' bgcolor='$color_turno'  align='center' >
												<td><b>Fecha y hora: ".$row['fecha']." ".$row['hora_inicio']."</b></td>
												<td><strong>".$row['campo_nombre']."</strong> $observaciones</td>
												<td><b>Turno [".$row['id_turno']."]</b></td>
												<td><b>".$row['especialista']."</b></td>
												<td><b>".$row['estado']."</b></td>
												</tr>
												<tr><td colspan='5'  >
												<table border='$borde_turno' width='100%'><tr><td>
												<table border='0'  width='95%' colspan='2' rowspan='2' align='center' valign='top'>
												";
												//// se busca si hay datos de consulta 
												$areas=@mysql_query(" 
													SELECT 
													consulta_areas.id_consulta_area,
													consulta_areas.consulta_area_nombre
													FROM 
													consulta_areas 
													ORDER BY consulta_areas.orden",$link);
												
												
if (mysql_num_rows($areas)!='0'){/// si hay datos e la consulta

while( $row = mysql_fetch_array( $areas ) ) {//// se clasifica por area
//$nuevo_select .= "<tr valign='top' ><td colspan='2'><font color='red'> <b>".$row['consulta_area_nombre']."</b></font></td></tr>";
$area = $row['campo_area'];
$id_consulta_datos = $row['id_consulta_datos'];
/// los campos de cada area
///se buscan los datos de la consulta
$datos_consulta=mysql_query("
					SELECT DISTINCT(consulta_datos.id_campo)AS id_campo ,consulta_datos.id_consulta_datos,
					consulta_datos.contenido, 
					consulta_campos.campo_nombre  , 
					consulta_campos.campo_descripcion,
					consulta_datos.bloqueo  
					FROM 
					consulta_datos, 
					consulta_campos 
					WHERE 
					id_turno = '$turno' 
					AND consulta_campos.id_consulta_campo = consulta_datos.id_campo 
					
					AND consulta_campos.campo_area = $area 
					
					 ORDER BY consulta_datos.id_campo, consulta_datos.id_consulta_datos DESC, timestamp DESC 
					 
					 
					",$link);


/*
if (mysql_num_rows($datos_consulta)!='0'){
while( $row = mysql_fetch_array( $datos_consulta ) ) {
$bloqueado = $row['bloqueo']; 
if($row['id_campo']>='12'  AND $row[id_campo] <= '15'){$bloqueado='1';}
$nuevo_select .= "<tr valign='top'  bgcolor='#$color'  onMouseOver=\"uno(this,'#c2f0e5');\" onMouseOut=\"dos(this,'#$color');\">
										<td  align='right'  width='25%' title=' ".$row['campo_descripcion']."'><b> ".$row['campo_nombre'].": </b></td>
										<td valign='top'><div id='capa_$row[id_consulta_datos]' style='display:inline;'>
															".revisar_campo_consulta($row['id_consulta_datos'],'confirmacion','revisar_campo',$autorizado)." ";
							if($bloqueado !='1'){								
$nuevo_select .= "	$test <a onclick=\"xajax_tipo_campo_consulta('$row[id_consulta_datos]','capa_$row[id_consulta_datos]','form')\">$row[contenido]</a>"; 
//$nuevo_select .= "".$row['contenido']." </a>";
															}
															else{								
$nuevo_select .= " ".$row['contenido']."";
															}
$nuevo_select .= "</div></td>
									</tr>";
															}
										}

/// fin de los campos de cada area
*/
															}
										}

/// fin de las area de consulta
//pos
$pos=mysql_query("SELECT *, recetas.estado FROM recetas, medicamentos WHERE id_turno='$turno' AND recetas.id_medicamento = medicamentos.id_medicamento ",$link);



if (mysql_num_rows($pos)!='0'){
$nuevo_select .= "<tr valign='top' ><td colspan='2'><font color='red'> <b> Medicamentos formulados</b></font></td></tr>";
while( $row = mysql_fetch_array( $pos ) ) {
$nuevo_select .= "<tr valign='top'  bgcolor='#$color'  onMouseOver=\"uno(this,'#c2f0e5');\" onMouseOut=\"dos(this,'#$color');\">
									<td  align='left' width='25%'></td><td>
																									<div id='receta_$row[id_receta]' style='display:inline;'>
																									".revisar_campo_consulta($row['id_receta'],'receta','revisar_receta',$autorizado)."
																									</div>
																									<b>".$row['medicamento_nombre']."  </b>
																									<br>".$row['concentracion_forma']." Cantidad: ".$row['cantidad']." (".$row['cantidad_letras'].")
																									<br><b>Posología: </b>".$row['posologia']." 
									</td>
									</tr>";
															}
															
										}
//fin pos

/// fin de las recetas formuladas en esta consulta
//ordenes expedidas en la consulta
$ordenes=mysql_query("SELECT *, ordenes.estado 
											FROM ordenes, cups
											WHERE ordenes.id_turno='$turno' 
											AND ordenes.id_tipo_orden = cups.codigo
											GROUP BY  ordenes.id_orden",$link);

if (mysql_num_rows($ordenes)!='0'){

$nuevo_select .= "<tr valign='top' ><td colspan='2'><font color='red'> <b>Ordenes </b></font></td></tr>";

while( $row = mysql_fetch_array( $ordenes ) ) {
$nuevo_select .= "<tr valign='top'  bgcolor='#$color'  onMouseOver=\"uno(this,'#c2f0e5');\" onMouseOut=\"dos(this,'#$color');\">
									<td  align='left' width='25%'>
									<div id='orden_$row[id_orden]' style='display:inline;'>
																									".revisar_campo_consulta($row['id_orden'],'orden','revisar_orden',$autorizado)."
																									</div>									
									<b title='$row[descripcion]'> [ Codigo: $row[codigo] ] <br> $row[descripcion]</b></td><td><b>".$row['observaciones']."  </b>
																								
									</td>
									</tr>";
															}
														
										}

//fin ordenes expedidas en la consulta

//Ayudas diagnósticas aportadas por el paciente
$ayudas=mysql_query("SELECT * FROM ayudas_diagnosticas WHERE id_turno='$turno' ",$link);

if (@mysql_num_rows($ayudas)!='0'){
$nuevo_select .= "<tr valign='top' ><td colspan='2'><font color='red'> <b>Paraclínicos suministrados por el paciente</b></font></td></tr>";

while( $row = mysql_fetch_array( $ayudas ) ) {
$nuevo_select .= "<tr valign='top'  bgcolor='#$color'  onMouseOver=\"uno(this,'#c2f0e5');\" onMouseOut=\"dos(this,'#$color');\">
									<td  align='left' width='25%'><b>".$row['ayuda_clase']."</b><br>Laboratorio: <b>".$row['ayuda_laboratorio']."</b> Fecha: <b>".$row['ayuda_fecha']."</b><br>[".$row['id_ayuda']."]</td>
									<td>  ".nl2br($row['ayuda_observaciones'])." 
									</td>
									</tr>";
															}
														
										}

//fin Ayudas diagnósticas aportadas por el paciente

			$nuevo_select .= "</table></td></tr></table></td></tr>
			
																						";											}
																						
$nuevo_select .= "</table>";
if($_SESSION['grupo'] !='9'){
$nuevo_select .= "<div align='center'>
<div name='avalar' id='avalar' style='background-color: #FF0000; color: white; width:400px '>
	<b>Autorizar esta consulta</b> 
	<br>Usuario: <input type='text' name='username' id='username' value='' title='Nombre de usuario del especialista que autoriza esta consulta'>
	<br>Clave: &nbsp;&nbsp;&nbsp;<input type='password' name='password' id='password' title='Clave personal del usuario que autoriza esta consulta'>
	<br>&nbsp;&nbsp;&nbsp;<input onclick=\"xajax_resumen_consulta('$id_usuario','$id_turno','6',xajax.getFormValues('consulta'))\" type='button' value='Autorizar' title='Con esta acción el especialista se hace responsable de lo consignado en esta consulta'>
	<br>La consulta se grabará a nombre del especialista que la autorice
</div></div>";
										}
$nuevo_select .= "</center>";
															}
return $nuevo_select;
} 

/// listado de consultas por usuario
///listado_consultas("$id_usuario","todas");

function listado_consultas($id_usuario,$estado){

$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
$sql=mysql_query("SELECT 
										DISTINCT(consulta_datos.id_campo),
										consulta_campos.campo_nombre , 
										consulta_datos.contenido , 
										consulta_datos.id_turno 
									FROM `consulta_datos`,`consulta_campos` 
									WHERE id_usuario = '$id_usuario'
									AND consulta_campos.id_consulta_campo = consulta_datos.id_campo
",$link);



if (mysql_num_rows($sql)!='0'){
$nuevo_select .= "<center><h2>Resumen de consultas</h2>
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
												$nuevo_select .= "<tr title='Atendido por ".$row['especialista']."' bgcolor='#$color'  onMouseOver=\"uno(this,'#c2f0e5');\" onMouseOut=\"dos(this,'#$color');\">
												<td>".$row['fecha']." ".$row['hora_inicio']."</td>
												<td><strong>".$row['campo_nombre']."</strong> $observaciones</td>
												<td>".$row['contenido']."</td>
												<td>".$row['factura']."</td>
												<td>".$row['recibo']."</td></tr>";
																																	}
$nuevo_select .= "</table></center>";
															}
return $nuevo_select;
} 


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
