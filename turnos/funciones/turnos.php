<?php
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: includes/error.php");
// echo "hola mundo2";
} 
function cambiar_sucursal ($capa,$id_turno,$sucursal_actual,$sucursal_nueva){
$respuesta = new xajaxResponse('ISO-8859-1');
      $link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
if($sucursal_nueva==''){

 $resultado ="<br>Mover atención : <select title='Mover esta atención a otra area de servicio' onchange=\"xajax_cambiar_sucursal('capa_id_sucursal_$id_turno','$id_turno','$sucursal_actual',this.value) \" name='id_sucursal' id='id_sucursal'  size='1' style='width:250'> 
	   			<option value=''>Sin selección</option>";

	$consulta = "SELECT id_sucursal, sucursal_nombre FROM sucursales WHERE activo ='1' AND sucursal_prioridad >= '5'";
	$result=mysql_query($consulta,$link);
		while ($row = mysql_fetch_array($result)){
   			$resultado .= "<option value='$row[id_sucursal]'>$row[sucursal_nombre]</option>";
																}

				$resultado .="</select>";

     				  }/// fin de select   
     				  else {$resultado = "moviendo a $sucursal_nueva";
$consulta_grabar = "UPDATE `turnos` 
						SET `id_sucursal`='$sucursal_nueva' 
						WHERE `id_turno`= '$id_turno' ";		
$GRABAR = mysql_query($consulta_grabar,$link);	
$resultado = "La consulta fué movida";     				  
     				  }
$respuesta->addAssign($capa,"innerHTML",$resultado);
return $respuesta;
										
										}
$xajax->registerFunction("cambiar_sucursal");
///NOMBRE DE LA FUNCION: 
// para llamar la funcion utilizar 
// onChange="xajax_dummy(xajax.getFormValues('nombre_formulario'))"
function autorizar_consulta($variable_array,$tipo){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$id_turno = $variable_array["id_turno"];
$funcionario=$_SESSION['id_usuario'];
$recibo = $variable_array["recibo"];
$excedente = $variable_array["excedente"];
$especialista = $variable_array["especialista"];
$ahora=time();

      $link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
if($tipo=='cancelar'){ $estado="3"; $cancela=", timestamp_cancelacion='$ahora', id_cancelacion='$funcionario' ,cancelacion_motivo='$recibo' ";}else {$estado="2";}
if($recibo != ''){
mysql_query("
 	update 
 		turnos  
 	set 
		 
		estado='$estado',
		autorizacion='1',
		id_autorizacion='$funcionario', 
		recibo='$recibo' ,
		excedente='$excedente' ,		timestamp_autorizacion='$ahora' 		$cancela
	where 
		id_turno='$id_turno'
					",$link); 
$motivo .= "<font size='-2'>Autorización o motivo: </font>
<input type='text' name='recibo' value='$recibo' tITLE='Para autorizar o cancelar, este campo no puede estar vacio!'>";		
$capa ="capa_turno_$id_turno";

$respuesta->addAssign("motivo_$id_turno","innerHTML",$motivo);
								}

								else{
											$nuevo_select .= "
															<div  style='border: 1px solid red; ' >
															<font size='-2' color='red'><font size='-2'>Para <strong>$tipo</strong> este campo es obligatorio <br>Autorización o motivo: </font>
															<img src='images/atencion.gif' alt='[!]' title='Para cancelar o actualizar el campo no puede estar vacio!'>
															<input type='text' name='recibo' value='$recibo' tITLE='Para autorizar o cancelar, este campo no puede estar vacio!'>	
															</div>";
															$capa = "motivo_$id_turno";
										}
if ($tipo=="autorizar") {$nuevo_select .="Autorizada <img src='images/check.gif' alt='[Autorizada]' border='0' title='Autorizacion $recibo'>";
if ($funcionario == $especialista){
$autorizado ="<a href=?page=consulta&turno=$id_turno><font size='+1'>Iniciar consulta</font></a>";
$respuesta->addAssign("iniciar_consulta_$id_turno","innerHTML",$autorizado);
																	}
}
if ($tipo=="cancelar") {$nuevo_select .="Cancelada <img src='images/eliminar.gif' alt='[Cancelada]' border='0'  title='Cancelada por $recibo'>";}


$respuesta->addAssign("$capa","innerHTML",$nuevo_select);
return $respuesta;



} 


///NOMBRE DE LA FUNCION: dar_cita
// para llamar la funcion utilizar 
// onChange="xajax_dummy(xajax.getFormValues('nombre_formulario'))"
function dar_cita($variable_array){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$id_usuario=$variable_array['id_usuario'];
$id_turno=$variable_array['id_turno'];
$funcionario=$_SESSION['id_usuario'];
$observaciones=$variable_array['observaciones']; 
$recibo=$variable_array['recibo']; 
$id_cliente=$variable_array['id_cliente']; 
$id_evento=$variable_array['id_evento']; 
$id_procedimiento=$variable_array['id_procedimiento']; 
$excedente=$variable_array['excedente']; 
$control=md5($variable_array['control']); 
if($_SESSION['grupo']!='1'){$id_empresa= $_SESSION['id_empresa'];}else {$id_empresa='%%';}
$ahora=time();

if($id_evento==''){ if($id_procedimiento==''){$error = "No se ha seleccionado un Procedimiento! ";}else {$error = "0";}}
									else {$error = "0";}


if($error !='0'){ $alerta = "<img src='images/atencion.gif' alt='[!]' title='$error'> $error";
$nuevo_select .= "$alerta";
$respuesta->addAssign("asignacion_procedimiento_alerta","innerHTML",$nuevo_select);
return $respuesta;
							}
if ($id_turno != ''){ /// SI EL ID DE TURNO NO ESTA VACIO
//include_once("librerias/conex.php"); 
$link=Conectarse(); 

mysql_query("SET NAMES 'utf8'");
if ($id_turno == 'nuevo'){ /// SI ES UN TURNO NUEVO
											$hoy=date('Y-m-d');
											$hora=date('H:i:s');
											list( $ano, $mes, $dia ) = split( '[-]', $hoy );
											$hoy_timestamp=mktime(0,0,0, $mes, $dia, $ano);
											$timestamp=mktime(0,0,0, $mes, $dia, $ano);
											$especialista= $_SESSION['id_usuario'];
						mysql_query("INSERT INTO  `turnos` 	(
																							`fecha`, 
																							`timestamp`,
																							`timestamp_inicio`,
																							`hora_inicio`,  
																							`especialista`, 
																							`id_usuario`, 
																							`observaciones`, 
																							`estado`, 
																							`id_evento`, 
																							`id_procedimiento`, 
																							`timestamp_ocupacion`, 
																							`id_ocupacion`, 
																							`timestamp_autorizacion`, 
																							`id_autorizacion`, 
																							`control`, 
																							`autorizacion`, 
																							`recibo`, 
																							`id_cliente`, 
																							`id_empresa`
																							) 
  													VALUES 
  																						(
  																						'$hoy',
  																						'$timestamp',
  																						'$timestamp',
  																						'$hora',
  																						'$especialista',
  																						'$id_usuario',
  																						'$observaciones',
  																						'2',
  																						'$id_evento',
  																						'$id_procedimiento',
  																						'$timestamp',
  																						'$especialista',
  																						'$timestamp',
  																						'$especialista',
  																						'$control',
  																						'1',
  																						'Autorizada por el médico',
  																						'$id_cliente',
  																						'$id_empresa'
  																						)",$link);     
					///BUSCA EL TURNO INSERTADO
						$sql=mysql_query("SELECT * FROM turnos WHERE control = '$control' ",$link);
						//si encuentra el ulturno insertado
						if (mysql_num_rows($sql)!='0'){ 
						///extrae el id de ese turno																
						$turno=mysql_result($sql,0,"id_turno");
																						} else {
						/// si NO LO ENCUENTRA MUESTRA EL ERROR
						$nuevo_select .= "error";
																																			}
																																			
					///MUESTRA AVISO Y LINK PARA INICIAR CONSULTA																														
$nuevo_select .= "<center><a href=?page=consulta&turno=$turno><h1>[ Iniciar consulta ]</h1></a></center>";
													}/// FIN DEL TRUNO NUEVO
//// SI EL TURNO NO ESTA VACIA ACTUALIZA UNO EXISTENTE

 mysql_query("
 	UPDATE 
 		turnos  
 	SET 
		id_usuario='$id_usuario', 
		estado='1',
		id_ocupacion='$funcionario', 
		observaciones='$observaciones', 
		recibo='$recibo' ,
		id_evento='$id_evento' ,
		id_procedimiento='$id_procedimiento' ,
		id_cliente='$id_cliente', 
		excedente='$excedente' ,		timestamp_ocupacion='$ahora' ,		id_usuario='$id_usuario' 
	WHERE 
		id_turno='$id_turno'
					"); 
$sql=mysql_query("SELECT fecha, hora_inicio, nombre_completo 
						FROM turnos, d9_users 
						WHERE id_turno = '$id_turno'
						AND turnos.especialista=d9_users.id						
						",$link);
while( $row = mysql_fetch_array( $sql ) ) {
$nuevo_select .= '<center><h1>La cita quedo asignada para el ' . $row['fecha'] . ' a las ' . $row['hora_inicio'] . '<br>Con el especialista '. $row['nombre_completo'] .'</h1></center>		';
													}
}/// FIN DEL TURNO
														else
														{
														$alerta="No se ha elegido un turno v&aacute;lido";
$nuevo_select .= "$alerta <img src='images/atencion.gif' alt='[!]'>";
														
$respuesta->addAssign("asignacion_turnos_alerta","innerHTML",$nuevo_select);
return $respuesta;
														}
														
include_once("consulta/funciones/listado.php");
$nuevo_select .= listado_consultas("$id_usuario","todas");

$respuesta->addAssign("asignacion_turnos","innerHTML",$nuevo_select);
return $respuesta;



} 

/// FIN DE LA FUNCION dummy



/// FUNCION turnos_grabar
function turnos_grabar($variable_array){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$fecha=$variable_array['fecha'];
$duracion=$variable_array['duracion'];
$hora=$variable_array['hora'];
$hora_inicio=$variable_array['hora_inicio'];
$hora_fin=$variable_array['hora_fin'];
$especialista=$variable_array['id'];
$tipo=$variable_array['tipo'];
$tipo_2=$variable_array['tipo_2'];
$hora_inicio_2=$variable_array['hora_inicio_2'];
$Turnos=$variable_array['turnos'];
$id_empresa= $_SESSION['id_empresa'];
list( $ano, $mes, $dia ) = split( '[-]', $fecha );
$fecha_comas = $ano.",".$mes.",".$dia;
$timestamp=mktime(0,0,0, $mes, $dia, $ano);

$link=Conectarse(); 
$especialistas=mysql_query("SELECT * FROM d9_users WHERE id ='$especialista'",$link);  
$nombre_completo=mysql_result($especialistas,0,"nombre_completo");
$nuevo_select = "<center><font size='-2'><b>$nombre_completo</b></font></center>";

foreach ($hora as $clave => $valor)
	{


 $i_hora=(int)($clave/60);
 $i_minutos=($clave%60); if ($i_minutos==0){ $i_minutos='00';}
  $f_hora=(int)(($clave+($duracion))/60);
 $f_minutos=(($clave+($duracion))%60); if ($f_minutos==0){ $f_minutos='00';}
 
$timestamp_inicio = ($timestamp+$clave);
$timestamp_fin = ($timestamp+$clave+$duracion);

mysql_query("INSERT INTO `turnos` (`id_empresa`,`fecha`, `timestamp`,`timestamp_inicio`,`timestamp_fin`, `hora_inicio`, `hora_fin`, `especialista`) 
  VALUES ('$id_empresa','$fecha','$timestamp','$timestamp_inicio','$timestamp_fin','$i_hora:$i_minutos','$f_hora:$f_minutos','$especialista')",$link);     

	
	}


function fecha_larga($date){

    list($aano,$mmes,$ddia) = split("-",$date);

        $ww = date('w', mktime(0,0,0,date($mmes)  ,date($ddia) ,date($aano)));

        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");

        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        $resultado = $dias[$ww]." ".$ddia." ".$meses[$mmes-1]." de ".$aano;

        return $resultado;

									}

if( $hora_inicio >= $hora_fin )
								{$alerta="La hora final es menor que la inicial";
$nuevo_select .= "<center title='$alerta'>$alerta<br><img src='images/atencion.gif' alt='!'></center>";
 								}else {

										}

$turnos=count($hora);
$nuevo_select .= "<center title='Fueron grabados ($turnos) turnos'>
<input value='Ver los $turnos turnos en la agenda' type='button'  OnClick='showEventForm($dia); startCalendar(0,0)' title='Actualizar la vista de la agenda'><br>
						";
$nuevo_select .= "".fecha_larga($fecha)." <font color=red>($turnos)</font> grabados<hr> 
	<table border='0' align='center' > 
		<tr>
			<td ></td>
			<td>Inicio</td>
			<td>Fin</td>
			<td><center>Duraci&oacute;n</center></td>
			<td> </td>
		</tr>";

foreach ($hora as $clave => $valor)
	{


 $i_hora=(int)($clave/60);
 $i_minutos=($clave%60); if ($i_minutos==0){ $i_minutos='00';}
  $f_hora=(int)(($clave+($duracion))/60);
 $f_minutos=(($clave+($duracion))%60); if ($f_minutos==0){ $f_minutos='00';}


$nuevo_select .= "<tr onMouseOver=\"uno(this,'red');\" onMouseOut=\"dos(this,'');\">
							<td ></td>
							<td bgcolor='ffffff' align='right' onMouseOver=\"uno(this,'ffffff');\" onMouseOut=\"dos(this,'ffffff');\">".$i_hora.":".$i_minutos." </td>
							<td bgcolor='ffffff' align='center' onMouseOver=\"uno(this,'ffffff');\" onMouseOut=\"dos(this,'ffffff');\">".$f_hora.":".$f_minutos."</td>
							<td bgcolor='ffffff' align='center' onMouseOver=\"uno(this,'ffffff');\" onMouseOut=\"dos(this,'ffffff');\">".$duracion." Minutos</td>
							<td ><center></td>
						</tr>";

}

 	
$respuesta->addAssign("turnos_revisar","innerHTML",$nuevo_select);

return $respuesta;


} 

/// FIN FUNCION turnos_grabar




///NOMBRE DE LA FUNCION: turnos_procesar

function turnos_procesar($variable_array){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$fecha=$variable_array['fecha'];
$duracion=$variable_array['duracion'];
$hora=$variable_array['hora'];
$hora_inicio=$variable_array['hora_inicio'];
$hora_fin=$variable_array['hora_fin'];
$especialista=$variable_array['id'];
$tipo=$variable_array['tipo'];
$tipo_2=$variable_array['tipo_2'];
$hora_inicio_2=$variable_array['hora_inicio_2'];
$hora_fin_2=$variable_array['hora_fin_2'];
//control de especialista
if($especialista==''){$alerta = "No se ha elegido un especialista";
$nuevo_select = "<center title='$alerta'>$alerta<br><img src='images/atencion.gif' alt='!' title='$alerta'></center>";
}
else
{
$link=Conectarse(); 
$especialistas=mysql_query("SELECT * FROM d9_users WHERE id ='$especialista'",$link);  
$nombre_completo=mysql_result($especialistas,0,"nombre_completo");
$nuevo_select = "<center><font size='-2'><b>$nombre_completo</b></font></center>";

function fecha_larga($date){

    list($aano,$mmes,$ddia) = split("-",$date);

        $ww = date('w', mktime(0,0,0,date($mmes)  ,date($ddia) ,date($aano)));

        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");

        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        $resultado = $dias[$ww]." <b><font size='+1'>".$ddia."</font></b> ".$meses[$mmes-1]." de ".$aano;

        return $resultado;

}

if( $hora_inicio >= $hora_fin ){$alerta="La hora final es menor que la inicial";
$nuevo_select .= "<center title='$alerta'>$alerta<br><img src='images/atencion.gif' alt='!'></center>";
 }else {
$Resta=($hora_fin-$hora_inicio);
$Turnos=(int)($Resta/$duracion); 
}


$nuevo_select .= "<center title='Se declararan los siguientes ($Turnos) turnos'>";
$nuevo_select .= fecha_larga($fecha);
$nuevo_select .= " <font color=red>($Turnos)</font><hr> 
<FORM  name='turnos_crear' id='turnos_crear'>
<a OnClick=\"xajax_turnos_grabar(xajax.getFormValues('turnos_crear'))\"><b>[ Confirmar ]</b></a>
		<table border='0' align='center' title='Si no desea alguno, por favor haga click en la casilla'> 
			<tr>
				<td> </td>
				<td>Hora</td>
				<td><center>Duraci&oacute;n</center></td>
				<td>[x]</td>
				<td> </td>
			</tr>";
 $A=0;
while ($A<$Turnos){
	$suma=($duracion*$A);
 	$inicio_suma=($suma+$hora_inicio);
  	$hora=(int)($inicio_suma/60);
   $minutos=($inicio_suma%60); if ($minutos==0){ $minutos='00';}$A++;
$nuevo_select .= "
		<tr bgcolor='' align='right' onMouseOver=\"uno(this,'red');\" onMouseOut=\"dos(this,'');\" >
			<td> </td>
			<td bgcolor='ffffff' align='right' onMouseOver=\"uno(this,'ffffff');\" onMouseOut=\"dos(this,'ffffff');\" align='right'>".$hora.":".$minutos."</td>
			<td bgcolor='ffffff' align='right' onMouseOver=\"uno(this,'ffffff');\" onMouseOut=\"dos(this,'ffffff');\" align='center'>".$duracion." Minutos </td>
			<td bgcolor='ffffff' align='right' onMouseOver=\"uno(this,'ffffff');\" onMouseOut=\"dos(this,'ffffff');\"><center><input type='checkbox' name='hora[$inicio_suma]' checked></td>
			<td> </td>
		</tr>";

}	
$nuevo_select .= "<TR><TD colspan='3' ><center>
				
				<input type='hidden' value='$Turnos' name='turnos'>
				
				<a OnClick=\"xajax_turnos_grabar(xajax.getFormValues('turnos_crear'))\"><b>[ Confirmar ]</b></a>
				</form>
</td></tr>
";

}//fin de el control de especialista 	
$respuesta->addAssign("turnos_revisar","innerHTML",$nuevo_select);

return $respuesta;



} 

/// FIN DE LA FUNCION turnos_procesar
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
