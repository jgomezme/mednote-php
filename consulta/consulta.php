<?php 
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: includes/error.php");
// echo "hola mundo2";
} 
if($_SESSION[prioridad]>='3'){
 $id_turno=$_REQUEST['turno'];
 $sala_abierta ='0';/// '1' permite que los usuarios diferentes a asistencial puedan realizar consultas
if (isset($_REQUEST['turno'])){ //// si se pasa un turno  se muestran los datos de consulta
if (isset($_REQUEST['anterior'])){	
																$_SESSION['en_consulta'] = $_REQUEST['siguiente'];
																$anterior =$_REQUEST['anterior'];
																
																$ahora=time();
											 								//	mysql_query("UPDATE turnos 	SET estado='2',timestamp_consulta_fin='$ahora'WHERE 	id_turno='$anterior'	");
																	}


 
  $result=mysql_query("SELECT turnos.estado, especialista, id_usuario, id_turno, d9_users.nombre_completo , turnos.control, consulta_efectuada
  										FROM turnos, d9_users 
  										WHERE turnos.id_turno = $id_turno 
  										AND  d9_users.id=turnos.id_usuario
  										LIMIT 1",$link);  


while( $row = @mysql_fetch_array( $result ) ) {
																							 $estado=$row['estado'];
																							 $consulta_efectuada=$row['consulta_efectuada'];
																							 $especialista=$row['especialista'];
																							 $id_usuario_consulta=$row['id_usuario'];
																							 $control=$row['control'];
																							 
																							 $nombre_completo_en_consulta=$row['nombre_completo'];
																							                            
 																							}//
if($consulta_efectuada =='1'){$link_bloquear = "<input type='button' title='Desbloquear esta consulta' onClick=\"document.getElementById('libre').value='';javascript:window.location='adentro.php?page=consulta&turno=$id_turno&bloquear=0';\"  value='Continuar Consulta' id='libre'>";}
else{$link_bloquear ="<input type='button' title='Bloquear esta consulta'  onClick=\"javascript:window.location='adentro.php?page=consulta&turno=$id_turno&bloquear=1';document.getElementById('bloqueado').value='';\" id='bloqueado' value ='Bloquear Consulta'>";} 																							
 																							
if ( isset( $_SESSION['en_consulta'] ) ) {
				if ( $_SESSION['en_consulta'] == $id_turno ){$error ='0'; } 
				else {
							$error ='1'; 
							$en_consulta=$_SESSION['en_consulta']; 
$usuario_en_consulta=mysql_query("SELECT  d9_users.nombre_completo 
  										FROM turnos, d9_users 
  										WHERE turnos.id_turno = $en_consulta 
  										AND  d9_users.id=turnos.id_usuario
  										LIMIT 1",$link);  

$en_consulta_nombre=mysql_result($usuario_en_consulta,0,"nombre_completo");
						
							echo "<center><h1>
							<img src='images/atencion.gif' alt='[!]'> 
							<h2>Continuar en consulta con</h2>  <a href='adentro.php?page=consulta&turno=$en_consulta' ><h1>$en_consulta_nombre</h1></a>
							<h2>Cambiar por el usuario</h2><a href='adentro.php?page=consulta&turno=$id_turno&anterior=$en_consulta' ><h1>$nombre_completo_en_consulta</h1></center>";

							} 
																						} 																							
 																							
 																							
 	if($sala_abierta == '1' || $especialista == $_SESSION['id_usuario']|| $_SESSION[grupo]=='3'|| $_SESSION[grupo]=='4'|| $_SESSION[grupo]=='8'|| $_SESSION[grupo]=='9'  ){ /// si el turno esta asignado a quien esta logueado o s del grupo 9
// 	0  	Disponible  	El turno acaba de ser declarado y se encuentra dis...
//	1 	Asignado 	Se h asignado un evento al turno
//	2 	Autorizado 	Se ha autorizado y se encuentra en sala de espera
//	3 	Cancelado 	El turno se ha cancelado fin de este turno
//	7 	En facturación 	El turno se ha facturado pero la factura no se ha ...
//	4 	En consulta 	El paciente tiene una consulta en proceso
//	5 	Consulta finalizada

 												if($estado > '4'){ echo "<center><h1><img src='images/atencion.gif' alt='[!]'> El turno  [$id_turno] ya está en procesos administrativos y/o de facturación</h1></center>"; $error='1';}
 												elseif ($estado=='0'){echo "<center><h1><img src='images/atencion.gif' alt='[!]'> No se ha asignado un usuario al turno  [$id_turno], por lo tanto no es posible realizar una consulta o procedimiento</h1></center>";
 														$error='1';							}
											
											 elseif ($estado=='1'){echo "<center><h1><img src='images/atencion.gif' alt='[!]'> No se ha autorizado el turno [$id_turno], por lo tanto no es posible realizar una consulta o procedimiento</h1></center>";
											 			$error='1';								}
											
											 elseif ($estado=='3'){echo "<center><h1><img src='images/atencion.gif' alt='[!]'> El turno  [$id_turno] fu&eacute; cancelado, por lo tanto no es posible realizar una consulta o procedimiento</h1></center>";
											 			$error='1';							}
											
											 elseif ($error != '1'){
											  /// si el turno esta autorizado "en consulta" 4 
											 									$ahora=time();
											 									if($especialista ==''){ $set = ", especialista = '$_SESSION[id_usuario]'";}
											 									if($_REQUEST['bloquear'] =='1'){$bloqueo=",consulta_efectuada ='1'";
											 									$link_bloquear ="<input type='button' title='Bloquear esta consulta'  onClick=\"javascript:window.location='adentro.php?page=consulta&turno=$id_turno&bloquear=0';document.getElementById('libre').value='';\" id='libre' value ='Continuar Consulta'>";
											 									}
											 									if($_REQUEST['bloquear'] =='0'){$bloqueo=",consulta_efectuada ='0'";
											 									$link_bloquear ="<input type='button' title='Bloquear esta consulta'  onClick=\"javascript:window.location='adentro.php?page=consulta&turno=$id_turno&bloquear=1';document.getElementById('bloqueado').value='';\" id='bloqueado' value ='Bloquear Consulta'>";}
											 									mysql_query("
																									 	UPDATE 
																									 		turnos  																									
																									 	SET 
																											
																											estado='4',
																											timestamp_consulta='$ahora'
																											$set
																											$bloqueo
																										WHERE 
																											id_turno='$id_turno'
																											");
																											
																											
																													$_SESSION['en_consulta'] = "$id_turno";
																													
																			 ?>
																			 <div class='' style='width: 400px; align:left '>
																			 <a href= "adentro.php?page=consulta&turno=<? echo $_SESSION['en_consulta']; ?>&anterior=<? echo $_SESSION['en_consulta']; ?>" >
																			  Finalizar consulta [<b>x</b>]</a><br>
																			  <? include_once('suscriptores/presentacion/datos.php');
																			 usuario_datos($id_usuario_consulta,'') 
																			
																			 ?>
																			  </div>
																			  <hr>
																			 <div id='cabecera' name='cabecera'></div>
																			<!-- formulario atencion inicial -->
<form name='atencion_inicial' id='atencion_inicial'>

<input type='hidden' value='atencion_inicial' id='formulario' name='formulario'>
<input type='hidden' value='<? echo $_SESSION[id_usuario]; ?>' id='id_funcionario' name='id_funcionario'>
<input type='hidden' value='<? echo $id_usuario_consulta; ?>' name='id_usuario'>
<input type='hidden' value='<? echo $_SESSION[en_consulta]; ?>' name='id_turno'>
<input type='hidden' value='<? echo $control; ?>' name='control_edicion'>
 <div name='atencion_inicial_capa' id='atencion_inicial_capa' class='consulta'></div>
 	</form>
																			
																			<!-- ////CABECERA DEL FORMULARIO -->
																			<form id='consulta' name='consulta'>
																			
<input type='hidden' name='tipo' id='tipo' value='mostrar'> 
<input readonly  type='hidden' name='id_especialista' id='id_especialista' value='<? echo $especialista; ?>'>
<input type='hidden' name='id_usuario' id='id_usuario' value='<? echo $id_usuario_consulta; ?>'>
<input type='hidden' name='id_turno' id='id_turno' value='<? echo $id_turno; ?>'>
<input type='hidden' name='control' id='control' value='<? echo $control; ?>'>

<!-- //// FIN DE LA CABECERA DEL FORMULARIO -->
<!-- /////BOTONERA DE CONSULTA -->
																			
<?php echo tipo_consulta_listado('',$id_usuario_consulta,'1'); ?> 
<!-- <input type='button' id='boton_2' onClick=" xajax_campos_consulta_dinamico('todas','Consulta completa','<? echo $id_usuario_consulta; ?>','0');" value='Consulta completa' > -->
<input type='button' id='boton_4' onClick="xajax_plan('Medicamentos','4','<? echo $id_usuario_consulta; ?>');" value='Ordenes , Procedimiento y Formulación' >

<input type='button' id='boton_6' style='' onClick="xajax_resumen_consulta('<? echo $id_usuario_consulta; ?>','<? echo $id_turno; ?>','6',xajax.getFormValues('consulta'))" value='Resumen Consulta' >
<input type='button' value='Egreso del servicio de urgencias' title='Información necesaria para el egreso del servicio de Urgencias' 	onClick="xajax_atencion_inicial_grabar(xajax.getFormValues('atencion_inicial'),'atencion_inicial_capa','formulario'); ">
<br><b id='letrero_bloquear'><?  echo $link_bloquear ?></b>
																			<!-- //// FIN DE LA BOTONERA -->
																			<div name='consulta_dinamico' id='consulta_dinamico'></div>
																			<!-- /////FIN DEL FORMULARIO -->

																			</FORM>
																			<!-- //// CIERRE DEL FORMULARIO -->
																			
																			<?php
																			
																			//echo tipo_orden();

												 								}/// FIN SI EL ESTADO ES "2" AUTORIZADO 
												 								else {} /// si el estado es desconocido todo vacio
 						
 																							}
 																							else { /// si el turno no esta asignado a quien esta logueado 
 																							echo "<center> $especialista (( $_SESSION[id_usuario] ))<h1><img src='images/atencion.gif' alt='[!]' title='Quizás este turno esta asignado a otro especialista'> No está autorizado para atender este turno! </h1></center>";
																										}
													}/// fin si se ha pasado un turno
													else { /// si no se ha pasado un turno se muestra la aplicacion para 
																	// complementar el formato de HC
																	
																	
																	echo "<a title='Regresar a la consulta'  href='adentro.php?page=consulta&turno=$_REQUEST[regresa]' class='cursor'>Regresar a la Consulta</a>";
																	include_once("consulta_edicion.php"); 

											
															}

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
