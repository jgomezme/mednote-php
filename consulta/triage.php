<?php 
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: error.php");
// echo "hola mundo2";
} 

$timestamp_atencion = time();
$control = md5($_SESSION[id_usuario]."-".microtime());
//echo "$hoy_timestamp";
/// si el grupo de especialista es "8 triage" se muestran campos de la atencion inicial de urgencias
if($_SESSION['grupo']=='8' or $_SESSION['grupo']=='9'){$ahora=time();$hora=date('H:i:s');
echo "<center><h2>Triage</h2>
<div id='resultado_atencion_inicial'>
<div id='capa_id_funcionario' style='display: inline;'></div>
<div id='capa_id_usuario' style='display: inline;'></div>
<div id='capa_estado' style='display: inline;'></div>
<div id='capa_id_cliente' style='display: inline;'></div>
														
<table><tr><td>
<form name='atencion_inicial_urgencias' id='atencion_inicial_urgencias'>
<input type='hidden' value='atencion_inicial_urgencias' id='formulario' name='formulario'>
<input type='hidden' value='$_SESSION[id_usuario]' id='id_funcionario' name='id_funcionario'>
<input type='hidden' value='$id' name='id_usuario'>
<input type='hidden' value='1' name='estado'>
											 
<input type='hidden' name='control' id='control' value='$control'>
<input type='hidden' name='timestamp_atencion' id='timestamp_atencion' value='$timestamp_atencion'>
<!-- <div id='capa_origen_de_la_atencion' style='display: inline;'><font color='red'>*</font></div><b>Orígen de la atención:</b>
[<b title='correspondiente al origen de la afección que motiva la consulta del paciente al servicio de urgencias. 
Es posible marcar simultáneamente las opciones accidente de trabajo y accidente de tránsito cuando el accidente de tránsito corresponda a un accidente de trabajo.'><font color='red'>?</font></b>]
<br><input name='origen_de_la_atencion' type='radio' value='1'>Enfermedad General
<br><input name='origen_de_la_atencion'   type='radio' value='2'>Accidente de trabajo
<br><input name='origen_de_la_atencion'  type='radio' value='3'>Evento Catastrófico
<br><input name='origen_de_la_atencion' type='radio'  value='4'>Enfermedad Profesional
<br><input name='accidente_de_transito' type='checkbox'  value='1'>Accidente de tránsito
										
-->

																					
																						
														 
<!-- <div id='capa_remitido' style='display: inline;'><font color='red'>*</font></div>Paciente remitido? No<input name='remitido' value='0' type='radio'>
Sí <input name='remitido' value='1'  type='radio' title='En caso afirmativo, registre el nombre del prestador remitente, así como el código de habilitación, el nombre del departamento y del municipio en el cual se encuentra ubicado dicho prestador con los códigos asignados en la codificación del DIVIPOLA.'>																								
									
<br>Código de la entidad que remite <input name='remitido_codigo_entidad'  id='remitido_codigo_entidad' type='text' value='' size='10' >
<br>Entidad que remite: <input name='remitido_nombre_entidad'  id='remitido_nombre_entidad' type='text' value='' size='70' >
<br><div id='capa_remitido_pais' style='display: inline;'><font color='red'></font></div>
<div id='capa_remitido_departamento' style='display: inline;'><font color='red'></font></div>
<div id='capa_remitido_ciudad' style='display: inline;'><font color='red'></font></div> -->
";
														
  $campos=mysql_query("
  		SELECT obligatorio, id_consulta_campo, consulta_campos.campo_nombre, consulta_campos.campo_descripcion, tipo_campo_accion, consulta_campos.campo_area, consulta_campos.orden, consulta_campos.tipo_contenido
		FROM `consulta_campos` , `tipo_campo` , `consulta_areas`, `consulta_tipo_campos`
		WHERE (consulta_campos.id_empresa = '$_SESSION[id_empresa]' )
		AND tipo_consulta = '1'
		AND consulta_tipo_campos.id_campo = consulta_campos.id_consulta_campo
		AND consulta_campos.campo_area LIKE '%%'
		AND consulta_areas.id_consulta_area = consulta_campos.campo_area 
		AND consulta_campos.campo_tipo = tipo_campo.id_tipo_campo
		ORDER BY consulta_areas.orden ,consulta_campos.campo_area,  consulta_campos.orden   ASC",$link);
	
   $campos_formulario = "<div name='$titulo"."_".$especialista."' id='$titulo"."_".$especialista."' style='border: 1px solid #$color;' align='center'>
		<div  class='cabecera'  align='left' style='background-color: #$_SESSION[mi_bgcolor]'>&nbsp; &nbsp; <b>$titulo</b></div>
		
		
		<script language=\"JavaScript\">
		<!--
		var nav4 = window.Event ? true : false;
		function acceptNum(evt){   
		var key = nav4 ? evt.which : evt.keyCode;   
		return (key <= 13 || (key>= 46 && key <= 57));
		}
		//-->
		</script>

		<div  id='alerta'></div>
		<ol>
											";

while( $row = mysql_fetch_array( $campos ) ) {

///prellenado
$campo_consulta = $row['id_consulta_campo'];
$requiere = $row['obligatorio'];
if($requiere =='1'){$obligatorio="<font color='red'><b title='Campo obligatorio'> * </b></font>";}else{$obligatorio='';}
//global $id_usuario; 
$campos_datos= mysql_query("
  		SELECT id_campo, contenido
		FROM `consulta_datos` 
		WHERE id_usuario = '$id_usuario'
		AND id_campo= $campo_consulta
		ORDER BY timestamp DESC LIMIT  1",$link);
if (mysql_num_rows($campos_datos)!='0'){
while( $row_contenido = mysql_fetch_array( $campos_datos ) ) {
//$contenido=$row_contenido['contenido'];
//$contenido="No vacio";

																
																					}}else {$contenido = "";}
//
//prellenado
$no_mostrar='0';
if($row['tipo_contenido'] =='1'){
$validador ="onKeyPress=\"return acceptNum(event)\"";
											}
$id_consulta_campo = "<font color='grey' size='-2'>($row[id_consulta_campo])</font>";
if($row[id_consulta_campo] == '7') {$no_mostrar='1';}
if($no_mostrar !='1'){ //// si no se han marcado los campos para no ser mostrados
/////select
//$id_consulta_campo = $row['id_consulta_campo'];
if ($row['tipo_campo_accion']=='select'){
$select= mysql_query("
  		SELECT campo_valor, predeterminado
		FROM `consulta_campos_valores` 
		WHERE id_consulta_campo =  '$row[id_consulta_campo]'
		",$link);
		$select_valores ='';
while( $row_valores = mysql_fetch_array($select) ) {
  if($row_valores[predeterminado]=='1'){$select_valores .= "<option value ='$row_valores[campo_valor]' selected>$row_valores[campo_valor]</option>";}
	$select_valores .= "<option value ='$row_valores[campo_valor]'>$row_valores[campo_valor]</option>";
																							}
$campos_formulario .= "<div align='' style='display: inline;' title='".$row['campo_descripcion']."'>$id_consulta_campo<b>".$row['campo_nombre'].":</b></div> 
		
			
			
			$obligatorio <select title='".$row['campo_descripcion']."' name='".$row['id_consulta_campo']."' id='".$row['id_consulta_campo']."' >";

$campos_formulario .="			$select_valores</select>";
			}
//// fin select

if ($row['tipo_campo_accion']=='textarea'){
$campos_formulario .= "<div align=''><p title='".$row['campo_descripcion']."'>$id_consulta_campo<b>".$row['campo_nombre'].":</b></div> 
		
			
			
			$obligatorio<textarea title='".$row['campo_descripcion']."' name='".$row['id_consulta_campo']."' id='".$row['id_consulta_campo']."' rows='2' cols='70'>$contenido</textarea>
			<br>";}
if ($row['tipo_campo_accion']=='text'){
$campos_formulario .=  "<p title='".$row['campo_descripcion']."'>$id_consulta_campo<b> ".$row['campo_nombre'].":</b> 
	
		
			<br>
			$obligatorio<input $validador title='".$row['campo_descripcion']."'  name='".$row['id_consulta_campo']."' id='".$row['id_consulta_campo']."' value='$contenido' type='".$row['tipo_campo_accion']."' size='72'>
			<br>";
																	  }														
																	  
if (is_numeric($row['tipo_campo_accion']))	{
$campos_formulario .=  "<p title='".$row['campo_descripcion']."'>$id_consulta_campo <b>".$row['campo_nombre'].": </b>
	
		
			
			$obligatorio<input title='".$row['campo_descripcion']."' $validador name='".$row['id_consulta_campo']."' id='".$row['id_consulta_campo']."' value='$contenido' type='".$row['tipo_campo_accion']."' size='".$row['tipo_campo_accion']."'   >
			<br>";
																	  }

										}/// fin de los campos que se muestran
																  
																	  				}//// fin del while

$campos_formulario .="</ol>";
echo $campos_formulario;
														echo "
														
														<!-- <div align='center'><div id='capa_destino' style='display: inline;'><font color='red'>*</font></div><b>Destino del paciente:</b></div> 
														
														<div align='center'>
														Domicilio: <input name='destino' value='0' TITLE='Domicilio'  type='radio'>  
														Internación:<input name='destino' value='1' TITLE='Internación'  type='radio'> 
														Contrarremisión: <input name='destino' value='2' TITLe='Contrarremisión'  type='radio'>
														Observación: <input name='destino' value='3' TITLE='Observación'  type='radio'> 
														Remisión: <input name='destino' value='4' TITLE='Remisión'  type='radio'>    
														Otro: <input name='destino' value='5' TITLE='Otro'  type='radio'>
														<br><b>Observaciones sobre el destino del paciente:</b><br>
														<textarea name='destino_observacion' rows='3' cols='50'></textarea></div> -->
															<div align='center' TITLE='Seleccione la clasificación dada al paciente por la persona que realizó el Triage según la clasificación única establecida por el Ministerio de la Protección Social.'>
																						<div id='capa_clasificacion' style='display: inline;'><font color='red'>*</font></div>Clasificación: 
																						
																						<FONT COLOR='RED'>[1</font><input name='clasificacion' value='1'  type='radio' TITLE= '1 ROJO'><FONT COLOR='RED'>-ROJO] </font>
																						<FONT COLOR='ORANGE'>[2</font><input name='clasificacion' value='2'  type='radio' TITLE= '2 AMARILLO'><FONT COLOR='ORANGE'>-AMARILLO] </font>
																						<FONT COLOR='GREEN'>[3</FONT><input name='clasificacion' value='3'  type='radio' TITLE= '3 VERDE'><FONT COLOR='GREEN'>-VERDE]</FONT>
																						<FONT COLOR='BLACK'>[4</FONT><input name='clasificacion' value='4'  type='radio' TITLE= '4 BLANCO'><font  color='BLACK'>-BLANCO]</FONT>
																						</div>
														<br>Entidad:
														";
												
														include_once ("terceros/listado_asignacion.php"); 
														listado("1","$id_cliente","empresa");
														
														/* ASIGNACION DE PACIENTES A ESPECIALISTAS 
														echo "<br><font color='red'>Asignar el paciente al médico : </font><br>";
														echo usuarios_logueados('3','Especialistas',$formulario,$funcion,'id_especialista');
														*/
														
echo "<div align='center' id='capa_id_sucursal' name='capa_id_sucursal'></div>
      <div align='center' id='capa_sucursal' name='capa_sucursal'><a onclick=\"xajax_parametrizacion_editar_sucursal('','solo_select','capa_sucursal','1')\">
      <h2>Asignar el paciente al servicio de:</h2>
      </a></div>";
echo "<hr><center><input type='button' value='Grabar' onClick=\"xajax_triage_grabar(xajax.getFormValues('atencion_inicial_urgencias'));
     \"></center>
      </form>
      </td></tr></table>
      </div>
      </center>";
	}
													
?>
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
