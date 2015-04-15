<?php 
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: includes/error.php");
// echo "hola mundo2";
} 
function citas($fecha){
include('includes/datos.php');
$link=Conectarse();
mysql_query("SET NAMES 'utf8'");
$funcionario = $_SESSION['id_usuario'];
$id_empresa = $_SESSION['id_empresa'];
$abrir_sala='0'; /// '1' permite que los usuarios diferentes a asistencial puedan realizar consultas
if ($fecha!='0'){$fecha = "AND turnos.timestamp >= '$fecha'";}else{ $fecha='';}
///if ($_SESSION['grupo'] == '9'){$especialista = "AND turnos.especialista='$funcionario'";}
if($_SESSION[grupo] != '1' && $_SESSION[grupo] != '5') {$id_sucursal = $_SESSION[sucursal]; $sucursal="AND id_sucursal ='$id_sucursal'";}
if($_SESSION[grupo] == '5'){$maximo_estado ='5'; //$no_mostrar_admitidos = "AND turnos.factura_impresa != '1'"; 
}
elseif($_SESSION[grupo] == '1'){$maximo_estado ='7';}
else{$maximo_estado ='4';}
$consulta =  "SELECT 
turnos.control,
turnos.id_usuario as paciente,
turnos.fecha,
turnos.estado,
turnos.id_turno,
turnos.id_cliente,
turnos.hora_inicio,
turnos.observaciones,
turnos.recibo,
turnos.cancelacion_motivo,
turnos.excedente,
d9_users.nombre_completo,
d9_users.documento_numero,
d9_users.documento_tipo,
turnos.especialista,
turnos.consulta_efectuada,
turnos.factura_impresa,
(SELECT nombre_completo FROM d9_users WHERE turnos.especialista = d9_users.id ) AS nombre_especialista,
(SELECT sucursal_nombre FROM sucursales WHERE turnos.id_sucursal = sucursales.id_sucursal ) AS sucursal
FROM turnos, d9_users 
WHERE turnos.id_usuario = d9_users.id
$especialista
$fecha
$sucursal
$no_mostrar_admitidos 
AND turnos.estado BETWEEN '1' AND '$maximo_estado' 
ORDER BY turnos.fecha DESC , turnos.hora_inicio DESC
";
$result=mysql_query($consulta,$link); 
  							
if (mysql_num_rows($result)!='0'){ /// solo muestra el cuadro si hay resulados
$listado_citas_cabeza .="
<div id='consulta_dinamico'  name='consulta_dinamico' >
<center>
  <TABLE border='0'  colspan='2' rowspan='2' align='center' valign='top' width='95%'>
      <TR bgcolor='#EEEDD1' align='center'><TD><B>Fecha/hora</B></TD> <TD><B>Usuario/identificacion</B></TD><TD><B>Especialista / Servicio</B></TD><td><strong>Triage</strong></td><TD><strong>Acción</strong></TD></TR>
";    

   while($row = mysql_fetch_array($result)) {
   if($row["estado"]>='5' AND $row["factura_impresa"]=='1'){}
   else{
 //  	if($_SESSION[grupo]=='5' OR $_SESSION[grupo]=='1'){
   if ($row["estado"]=='4') { $estado="<font  color='green' title='Aun no se efectua el egreso'>En Consulta</font>";}
   elseif($row["estado"]=='5') { $estado="<b title='La consulta ya fué efectuada y se encuentra pendiente su admisión o facturación'><font  color='red'>Egreso</font></b>";}
	elseif($row["estado"]=='7') { $estado="<b title='La consulta ya fué Admitida o facturada'><font  color='blue'>Admitida</font></b>";}   
   else{}
 //  																		}
 
 if($_SESSION[grupo]=='1'){$mover ="<div align='center' id='capa_id_sucursal_$row[id_turno]' name='capa_id_sucursal_$row[id_turno]'>
														
														<a onclick=\" xajax_cambiar_sucursal('capa_id_sucursal_$row[id_turno]','$row[id_turno]','$row[sucursal]','')\">$row[sucursal]</a>
														</div>";
														}else {$mover="<b>$row[sucursal]</b>";}
$listado_citas .="<tr onMouseOver=\"uno(this,'#c2f0e5');\" onMouseOut=\"dos(this,'');\" title='Id turno: ".$row["id_turno"]."' valign='top'  >
      	<td valign='top'  align='center'  width='100px'>".$row["fecha"]." ".$row["hora_inicio"]."</td>
      	<td title='".$row["observaciones"]."' ><div id='iniciar_consulta_".$row["id_turno"]."'></div>";
      	if($row[nombre_especialista]==''){$row[nombre_especialista]='Sin asignar';}
		//	if($_SESSION['id_usuario']==$row["especialista"]){ 
			if($abrir_sala == '1' || $_SESSION[grupo]=='3'|| $_SESSION[grupo]=='4'|| $_SESSION[grupo]=='8'|| $_SESSION[grupo]=='9' || $_SESSION['id_usuario']==$row["especialista"]){
								if ($row["estado"]==2) { $listado_citas .="<a href=?page=consulta&turno=".$row["id_turno"]."><font size='+1'>";}
								if ($row["estado"]==4) { $listado_citas .="<img src='images/doctor.gif' alt='[En consulta]' border='0'  title='En consulta'><a href=?page=consulta&turno=".$row["id_turno"]."><font size='+1'>";}
								
								if ($row["consulta_efectuada"]=='1') { $bloqueo ="<img src='images/atencion.gif' title='La consulta se encuentra en proceso pero se esperan análisis o tramites'> <font color='red' size='-1'>En espera</font><br>";}else{ $bloqueo ="";}
																												}      	
						$clasificacion= usuario_datos_consultar($row[control],'clasificacion','clasificacion');
						$motivo_consulta= usuario_datos_consultar($row[control],'motivo_consulta','contenido');
						$entidad= usuario_datos_consultar($row[id_cliente],'cliente','alias');
						$documento_tipo = usuario_datos_consultar($row[documento_tipo],'documento','documento_tipo');
						$color_fuente='';
						if($clasificacion == '1'){$color='red'; $color_fuente='white';}
						elseif($clasificacion == '2'){$color='yellow';}
						else{$color='green'; $color_fuente='white';}
						if($_SESSION[grupo]=='5' ){
						if($row["factura_impresa"]!='1'){
						$admision="Pendiente <img class='cursor' src='images/pendiente.gif' title='Marcar como admitido' alt='[]' onClick=\"xajax_admitir($row[id_turno]) \">";
																		}			else{$admision="<font color='red' title='La atención ya fué admitida en el sistema'>Admitida</font>";}		
																							}
$listado_citas .="<strong>".$row["nombre_completo"]."</strong><br>Documento: $documento_tipo ".$row["documento_numero"]."<br>".$row["observaciones"]." </font></a>$entidad
																							</td>
      	<td class='BC".$row["especialista"]."' title='Nombre del especialista'>".$row["nombre_especialista"]." <br> $mover </td>
      	<td align='center' bgcolor='$color' valign='middle'><strong><font size='+2' color='$color_fuente'>$clasificacion</font></strong><br title='Motivo de la Consulta'>$motivo_consulta</td>
      	<td width='100px' nowrap>	$bloqueo 
      	 <div style='display:inline;' id='admision_$row[id_turno]' name='admision_$row[id_turno]'>$estado $admision</div>
      			
      			 <br><a href=\"javascript:abrir('impresion/imprimir_ficha.php?control=$row[control]','PRINT_ficha',500,600,100,0,1);\" title='Imprimir ficha de ingreso'><img src='images/print.gif' alt='[I]' border='0'> <font size='-2'>Ficha de ingreso</font></a>
      			<br><a href=\"javascript:abrir('impresion/imprimir_triage.php?control=$row[control]','PRINT',500,600,100,0,1);\" title='Imprimir el resumen de la consulta'><img src='images/print.gif' alt='[I]' border='0'> <font size='-2'>Resumen triage</font></a>
      			<br><input type='button' id='boton_6' style='' onClick=\"xajax_wait('consulta_dinamico');xajax_resumen_consulta('$row[paciente]','$row[id_turno]','',xajax.getFormValues('consulta'))\" value='Resumen Consulta $row[id_turno]' >
      			
      			
      			";
      			if ($row["estado"]!=4){
$listado_citas .="";
      														}
$listado_citas .="<div id='capa_turno_".$row["id_turno"]."'>
      			";
      if ($row["estado"]==1) {$listado_citas .="Pendiente: <img src='images/pendiente.gif' alt='Pendiente'  border='0'></a>";}
      if ($row["estado"]==2) {$listado_citas .="Autorizada: <img src='images/check.gif' alt='[Autorizada]' border='0' title='Autorizacion ".$row["recibo"]."'>";}
      if ($row["estado"]==3) {$listado_citas .="Cancelada: <img src='images/eliminar.gif' alt='[Cancelada]' border='0'  title='Cancelada por ".$row["cancelacion_motivo"]."'>";}
			if ($row["estado"]==4) {$listado_citas .="En consulta: <img src='images/doctor.gif' alt='[En consulta]' border='0'  title='En consulta con  ".$row["nombre_especialista"]."'>";}

$listado_citas .="</div></form></td>
 		</tr>"; 
   }
   }///finde si no se ha hecho el egreso ni admitido
   mysql_free_result($result);
global $ahora;
$listado_citas_pie .="
<TR bgcolor='#EEEDD1' ><TD colspan='2'>Última actualización: $ahora</TD><TD></TD><TD></TD></TR>
</table></center>
</div>";
}/// si no hay resultados 
else{$listado_citas .= "<center><h2>No hay usuarios pendientes de atención</h2></center>";}
$cuadro = "$listado_citas_cabeza $listado_citas $listado_citas_pie";
return $cuadro;
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
