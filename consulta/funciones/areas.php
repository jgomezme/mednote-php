<?php
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) { 
 // Si no existe 
 header("Location: includes/error.php");
// echo "hola mundo2";
}  


///NOMBRE DE LA FUNCION: grabar_consulta
// para llamar la funcion utilizar 
// onChange="xajax_grabar_consulta(xajax.getFormValues('nombre_formulario'))"
function grabar_consulta($variable_array){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$id_campo = $variable_array["id_campo"];
$id_especialista = $variable_array["id_especialista"];
$id_usuario = $variable_array["id_usuario"];
$id_turno = $variable_array["id_turno"];
$tipo = $variable_array["tipo"];
$cie_10 = $variable_array["29"];
$cabeza = $variable_array["22"];
$cuello = $variable_array["23"];
$torax = $variable_array["24"];
$abdomen = $variable_array["25"];
$timestamp = time(); 
$link=conectarse();
mysql_query("SET NAMES 'utf8'");

/// CAMPOS OBLIGATORIOS
if ($cie_10 == ''){
$nuevo_select ="<center><h1><img src='images/atencion.gif' alt='!'>No ha especificado un código de diagnóstico</h1><h2>Los datos no se guardarán!</h2></center>";
$respuesta->addAssign("consulta_dinamico","innerHTML",$nuevo_select);
return $respuesta;
										}
										// comprueba si el cie 1o es valido
$sql=mysql_query("SELECT * FROM cie_10 WHERE codigo = '$cie_10' LIMIT 1",$link);

if (mysql_num_rows($sql)=='0'){

															
$nuevo_select ="<center><h1><img src='images/atencion.gif' alt='!'> $cie_10 No es un código válido!</h1><h2>Los datos no se guardarán!</h2></center>";
										

$respuesta->addAssign("consulta_dinamico","innerHTML",$nuevo_select);
return $respuesta;
										}

if ($cabeza == ''){
$sql=mysql_query("SELECT contenido FROM consulta_datos WHERE id_campo = '22' AND id_turno='$id_turno' LIMIT 1",$link);
if (mysql_num_rows($sql)=='0'){
$nuevo_select ="<center><img src='images/atencion.gif' alt='!'>
<input type='button' onClick=\"xajax_campos_consulta_dinamico('8','Exámen físico','<? echo $id_usuario; ?>');\" 
				value='El campo CABEZA en exámen fisico, no puede estar vacio'>
							<h2>Los datos no se guardarán!</h2>
							</center>";
$respuesta->addAssign("alerta","innerHTML",$nuevo_select);
return $respuesta;            }
										}

if ($cuello == ''){
$sql=mysql_query("SELECT contenido FROM consulta_datos WHERE id_campo = '23' AND id_turno='$id_turno' LIMIT 1",$link);
if (mysql_num_rows($sql)=='0'){
$nuevo_select ="<center><img src='images/atencion.gif' alt='!'>
<input type='button' onClick=\"xajax_campos_consulta_dinamico('8','Exámen físico','<? echo $id_usuario; ?>');\" 
				value='El campo CUELLO en exámen fisico, no puede estar vacio'>
							<h2>Los datos no se guardarán!</h2>
							</center>";
$respuesta->addAssign("alerta","innerHTML",$nuevo_select);
return $respuesta;
										}}
if ($torax == ''){
$sql=mysql_query("SELECT contenido FROM consulta_datos WHERE id_campo = '24' AND id_turno='$id_turno' LIMIT 1",$link);
if (mysql_num_rows($sql)=='0'){
$nuevo_select ="<center><img src='images/atencion.gif' alt='!'>
<input type='button' onClick=\"xajax_campos_consulta_dinamico('8','Exámen físico','<? echo $id_usuario; ?>');\" 
				value='El campo TORAX en exámen fisico, no puede estar vacio'>
							<h2>Los datos no se guardarán!</h2>
							</center>";
$respuesta->addAssign("alerta","innerHTML",$nuevo_select);
return $respuesta;
										}}
if ($abdomen == ''){
$sql=mysql_query("SELECT contenido FROM consulta_datos WHERE id_campo = '25' AND id_turno='$id_turno' LIMIT 1",$link);
if (mysql_num_rows($sql)=='0'){
$nuevo_select ="<center><img src='images/atencion.gif' alt='!'>
<input type='button' onClick=\"xajax_campos_consulta_dinamico('8','Exámen físico','<? echo $id_usuario; ?>');\" 
				value='El campo ABDOMEN en exámen fisico, no puede estar vacio'>
							<h2>Los datos no se guardarán!</h2>
							</center>";
$respuesta->addAssign("alerta","innerHTML",$nuevo_select);
return $respuesta;
										}}

/// FIN CAMPOS OBLIGATORIOS

										


if ($tipo == 'mostrar'){

foreach ($variable_array as $campo => $contenido)
	{
$campos=mysql_query("
  		SELECT id_consulta_campo, campo_nombre
		FROM `consulta_campos`
		WHERE id_consulta_campo = '$campo'
		",$link);

while( $row = mysql_fetch_array( $campos ) ) {
if($contenido != ""){ 
/// revisando si el campo ya fue grabado en el mismo turno
$sql_campo=mysql_query("SELECT * 
												FROM consulta_datos 
												WHERE id_campo = '$campo'
												AND id_turno='$id_turno' 
												LIMIT 1",$link);

if (mysql_num_rows($sql_campo)!='0'){
while( $row = mysql_fetch_array( $sql_campo ) ) { 
$id_consulta_datos = $row['id_consulta_datos'];


//							$nuevo_select .= "$timestamp EXISTIA - $id_consulta_campos -";	
				mysql_query("
UPDATE `consulta_datos` SET 
`id_especialista` = '$id_especialista',
`id_usuario` = '$id_usuario',
`contenido` = '$contenido',
`timestamp` = '$timestamp',
`id_turno` = '$id_turno' WHERE`id_consulta_datos` = '$id_consulta_datos' LIMIT 1 ",$link);
																										}
							
							
								}else {	
//								$nuevo_select .= "nuevo";		
mysql_query("
INSERT INTO `consulta_datos` ( `id_consulta_datos` , `id_campo` , `id_especialista` , `id_usuario` , `contenido` , `timestamp` , `id_turno` )
VALUES (NULL , '$campo', '$id_especialista', '$id_usuario', '$contenido', '$timestamp', '$id_turno')",$link);
// $nuevo_select .= "$campo --- $contenido <br>";

						}

										}
															}	
	
	

	}	
//		$nuevo_select .= "<h1>La consulta fu&eacute; guardada</h1>	<a href=?page=plan&id_turno=$id_turno>Recetar</a>; 
		
$respuesta->addAssign("cabecera","innerHTML",$nuevo_select);
return $respuesta;

								}
								
$nuevo_select .= "<h1>Los siguientes datos ser&aacute;n guardados en la consulta:</h1>";

  
$nuevo_select .= "<ol>";

foreach ($variable_array as $campo => $valor)
	{

$campos=mysql_query("
  		SELECT id_consulta_campo, campo_nombre
		FROM `consulta_campos`
		WHERE id_consulta_campo = '$campo'
		",$link);

while( $row = mysql_fetch_array( $campos ) ) {
$nuevo_select .= "<li>". $row['id_consulta_campo']." " . $row['campo_nombre'].":" .$valor."</li>";
															}
	}
	
	

//while( $row = mysql_fetch_array( $sql ) ) {
//$nuevo_select .= '' . $row['id'] . '">' . $row['nombre_completo'] . '<br>';
//}
$nuevo_select .= "<input type='text' name='tipo' id='tipo' value='guardar'>
						<input type='button' onClick=\"xajax_grabar_consulta(xajax.getFormValues('consulta'));confirmacion(); \" value='Confirmar' >
					
						
						";
$respuesta->addAssign("cabecera","innerHTML",$nuevo_select);
return $respuesta;
} 

/// 


function campos_consulta_dinamico($area,$titulo,$id_usuario){
//$area = $area["area"];
$especialista="0";
//$titulo=$area;

//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');

$link=conectarse();
mysql_query("SET NAMES 'utf8'");

  $campos=mysql_query("
  		SELECT id_consulta_campo, campo_nombre, campo_descripcion, tipo_campo_accion, campo_area, orden
		FROM `consulta_campos` , `tipo_campo`
		WHERE id_especialista = '$especialista'
		AND campo_area = '$area'
		AND consulta_campos.campo_tipo = tipo_campo.id_tipo_campo
		ORDER BY orden ASC",$link);

$campos_formulario = "

		<div name='$titulo"."_".$especialista."' id='$titulo"."_".$especialista."' style='border: 1px solid #$color;' >
		<div  class='cabecera'><li>$titulo </li> </div>
		<hr><h1>$titulo </h1>
		<div  id='alerta'></div>
		<ol>
											";

while( $row = mysql_fetch_array( $campos ) ) {

///prellenado
$campo_consulta = $row['id_consulta_campo'];
//global $id_usuario; 
$campos_datos= mysql_query("
  		SELECT id_campo, contenido
		FROM `consulta_datos` 
		WHERE id_usuario = '$id_usuario'
		AND id_campo= $campo_consulta
		ORDER BY timestamp DESC LIMIT  1",$link);
if (mysql_num_rows($campos_datos)!='0'){
while( $row_contenido = mysql_fetch_array( $campos_datos ) ) {
$contenido=$row_contenido['contenido'];
//$contenido="No vacio";

																
																					}}else {$contenido = "";}
//
//prellenado
if ($row['tipo_campo_accion']=='textarea'){
$campos_formulario .= "<li> ".$row['campo_nombre'].": 
		
			
			<br>
			<textarea name='".$row['id_consulta_campo']."' id='".$row['id_consulta_campo']."' rows='5' cols='70'>$contenido</textarea>
			<br>";}
if ($row['tipo_campo_accion']=='text'){
$campos_formulario .=  "<li> ".$row['campo_nombre'].": 
	
		
			<br>
			<input name='".$row['id_consulta_campo']."' id='".$row['id_consulta_campo']."' value='$contenido' type='".$row['tipo_campo_accion']."' size='72'>
			<br>";
																	  }														
																	  
if (is_numeric($row['tipo_campo_accion']))	{
$campos_formulario .=  "<li> ".$row['campo_nombre'].": 
	
		
			
			<input name='".$row['id_consulta_campo']."' id='".$row['id_consulta_campo']."' value='$contenido' type='".$row['tipo_campo_accion']."' size='".$row['tipo_campo_accion']."'   MAXLENGTH='".$row['tipo_campo_accion']."' >
			<br>";
																	  }


																  
																	  				}

$campos_formulario .="</ol>";
//echo $campos_formulario;
										
	
$respuesta->addAssign("consulta_dinamico","innerHTML",$campos_formulario);
return $respuesta;										
										
												
} 



/// formulario consulta

function formulario_consulta($area,$titulo,$especialista){

$link=conectarse();
mysql_query("SET NAMES 'utf8'");
  $campos=mysql_query("
  		SELECT id_consulta_campo, campo_nombre, campo_descripcion, tipo_campo_accion, campo_area, orden
		FROM `consulta_campos` , `tipo_campo`
		WHERE id_especialista = '$especialista'
		AND campo_area = '$area'
		AND consulta_campos.campo_tipo = tipo_campo.id_tipo_campo
		ORDER BY orden ASC",$link);

$campos_formulario = "<form name='Xarea_$area' id='Xarea_$area'>
<div name='cabecera' id='cabecera' class='cabecera'><b>$titulo</b> [-]<input type ='hidden' name='id_especialista' id='id_especialista' value='$especialista'><input type='hidden' name='Xarea' id='Xarea' value='$area'> <input type='button' value='+' OnClick=\"xajax_crear_campos_consulta(xajax.getFormValues('Xarea_$area'));\"></div></form><div name='$titulo"."_".$especialista."' id='$titulo"."_".$especialista."' style='border: 1px solid #$color; '>

";
$campos_formulario .= "<div name='crear_campos_consulta_$area' id='crear_campos_consulta_$area'>	</div>";	
while( $row = mysql_fetch_array( $campos ) ) {
if ($row['tipo_campo_accion']=='textarea'){$campos_formulario .= "<div  name='id_campos_consulta_".$row['id_consulta_campo']."' id='id_campos_consulta_".$row['id_consulta_campo']."'><form name='Xcampo_editar".$row['id_consulta_campo']."' id='Xcampo_editar".$row['id_consulta_campo']."'><input  name='id_campo_editar' id='id_campo_editar' value='".$row['id_consulta_campo']."' type='hidden'><input type='hidden' name='Xarea' id='Xarea' value='".$row['campo_area']."' type='hidden'><input name='id_campo_editar' type='hidden' id='id_campo_editar' value='".$row['id_consulta_campo']."'></form>".$row['orden']."<input type='button' style='width: 200;text-align: left;'  value='".$row['campo_nombre']."' OnClick=\"xajax_crear_campos_consulta(xajax.getFormValues('Xcampo_editar".$row['id_consulta_campo']."'));\" title='".$row['campo_descripcion']."'><br><textarea name='".$row['campo_nombre']."' rows='5' cols='70'></textarea></div><br><br>";}
if ($row['tipo_campo_accion']=='text'){$campos_formulario .= "<div   name='id_campos_consulta_".$row['id_consulta_campo']."' id='id_campos_consulta_".$row['id_consulta_campo']."'><form name='Xcampo_editar".$row['id_consulta_campo']."' id='Xcampo_editar".$row['id_consulta_campo']."'><input name='id_campo_editar' id='id_campo_editar' value='".$row['id_consulta_campo']."' type='hidden' ><input type='hidden' name='Xarea' id='Xarea' value='".$row['campo_area']."' ><input name='id_campo_editar' id='id_campo_editar' value='".$row['id_consulta_campo']."' type='hidden'></form>".$row['orden']."<input type='button' style='width: 200;text-align: left;'  value='".$row['campo_nombre']."' OnClick=\"xajax_crear_campos_consulta(xajax.getFormValues('Xcampo_editar".$row['id_consulta_campo']."'));\" title='".$row['campo_descripcion']."'><br> <input name='".$row['campo_nombre']."' id='".$row['campo_nombre']."' type='".$row['tipo_campo_accion']."' size='72'></div><br><br>";}																		

if (is_numeric($row['tipo_campo_accion'])){$campos_formulario .= "<div   name='id_campos_consulta_".$row['id_consulta_campo']."' id='id_campos_consulta_".$row['id_consulta_campo']."'><form name='Xcampo_editar".$row['id_consulta_campo']."' id='Xcampo_editar".$row['id_consulta_campo']."'><input name='id_campo_editar' id='id_campo_editar' value='".$row['id_consulta_campo']."' type='hidden' ><input type='hidden' name='Xarea' id='Xarea' value='".$row['campo_area']."' ><input name='id_campo_editar' id='id_campo_editar' value='".$row['id_consulta_campo']."' type='hidden'></form>".$row['orden']."<input type='button' style='width: 200;text-align: left;'  value='".$row['campo_nombre']."' OnClick=\"xajax_crear_campos_consulta(xajax.getFormValues('Xcampo_editar".$row['id_consulta_campo']."'));\" title='".$row['campo_descripcion']."'> <input name='".$row['campo_nombre']."' id='".$row['campo_nombre']."' type='".$row['tipo_campo_accion']."' size='".$row['tipo_campo_accion']."'></div><br><br>";}																		


																	  }

echo $campos_formulario;
												
} 


///fin formulario consulta



/// crear formulario consulta
function crear_campos_consulta($variable_array){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$area = $variable_array["Xarea"];
$especialista = $variable_array["id_especialista"];
$id_campo_editar = $variable_array["id_campo_editar"];
$resultado = "$id_campo_editar";
$link = conectarse();
mysql_query("SET NAMES 'utf8'");
$capa = "crear_campos_consulta_$area";	
$formulario ="manejo_campos_$area";

if ($id_campo_editar > 0){
$sql=mysql_query("SELECT * FROM consulta_campos WHERE id_consulta_campo = '$id_campo_editar'",$link);
while( $row = mysql_fetch_array( $sql ) ) {
$resultado .="";
$campo_descripcion =$row['campo_descripcion'];
$campo_nombre =$row['campo_nombre'];
$orden =$row['orden'];
$especialista =$row['id_especialista'];
$capa ="id_campos_consulta_$id_campo_editar";
$formulario ="manejo_campos_$id_campo_editar";
$editar="<input type='hidden' name='editar' id='editar' value='editar'>
			<input type='hidden' name='id_campo_editar' id='id_campo_editar' value='$id_campo_editar'>
			<input type='hidden' name='misma_area' id='misma_area' value='$area'>";
$Campo_tipo_definido= $row['campo_tipo'];			
}
								}
								
$Tipo_campo ="  Tipo: <select name='campo_tipo' id='campo_tipo' >";
$tipos=mysql_query("
  		SELECT *
		FROM `tipo_campo` 
		WHERE activo = '1'
		",$link);
while( $row = mysql_fetch_array( $tipos ) ) {

if($row['id_tipo_campo'] == $Campo_tipo_definido){
$Tipo_campo .= " <option value='".$row['id_tipo_campo']."' SELECTED > > ".$row['id_tipo_campo']." - ".$row['tipo_campo_nombre']." < </option>";
																									}
$Tipo_campo .= " <option value='".$row['id_tipo_campo']."'>".$row['id_tipo_campo']." - ".$row['tipo_campo_nombre']."</option>";
}
$Tipo_campo .="</select>";




$Areas ="<select name='campo_area' id='campo_area'' >";
$areas=mysql_query("
  		SELECT *
		FROM `consulta_areas` 
		WHERE estado = '1'
		",$link);
while( $row = mysql_fetch_array( $areas ) ) {

if ($row['id_consulta_area']==$area){

$Areas .= "<option value='".$row['id_consulta_area']."' SELECTED >".$row['id_consulta_area']." - ".$row['consulta_area_nombre']."< </option>";
													}
$Areas .= "<option value='".$row['id_consulta_area']."'>".$row['id_consulta_area']." - ".$row['consulta_area_nombre']."</option>";
}
$Areas .="</select><img src='images/atencion_s.gif'alt='!' title='SI CAMBIA EL AREA TENDRA QUE REFRESCAR LA PAGINA PARA VER LOS EFECTOS'>";


$identificador = microtime();

$resultado .= "<div name='formulario_campos_$area' id='formulario_campos_$area' style='padding: 10px;' class='BC".$especialista."' >
	<form name='$formulario' id ='$formulario'>
	<br>Nombre del campo: <input type='text' name='campo_nombre' id='campo_nombre' size='35' value ='$campo_nombre'>
	<br>Descripci&oacute;n<br><textarea name='campo_descripcion' id='campo_descripcion' cols=60 rows='3'>$campo_descripcion</textarea>
	<br>Area: $Areas 
	Orden: 
				<select 	name='campo_orden' id='campo_orden' >";
if($orden >= 1){
$resultado .= "		<option value='$orden' SELECTED>$orden <</option>	";
					}
$resultado .= "		<option value='01'>01</option>	
				<option value='02'>02</option>	
				<option value='03'>03</option>	
				<option value='04'>04</option>	
				<option value='05'>05</option>	
				<option value='06'>06</option>	
				<option value='07'>07</option>	
				<option value='08'>08</option>	
				<option value='09'>09</option>	
				<option value='10'>10</option>				
				</select>
	
$Tipo_campo 
	<input type='hidden' name='misma_area' id='misma_area' value='$area'>
	<input type ='button' value=' Guardar ' OnClick=\"xajax_formulario_consulta_procesar(xajax.getFormValues('$formulario'))\" />	
		<br><input type ='hidden' name='id_especialista' id='id_especialista' value='$especialista'>
		$editar
		<input type ='hidden' name='tipo' id='tipo' value='nuevo'>
		<input type ='hidden' name='campo_identificador' id='campo_identificador' value='$identificador $especialista'>
	 	</form>
			 	
	 	</div>";
	
$respuesta->addAssign("$capa","innerHTML",$resultado);
return $respuesta;
}


///// fin


///NOMBRE DE LA FUNCION: formulario_consulta
// para llamar la funcion utilizar 
// onChange="xajax_formulario_consulta(xajax.getFormValues('nombre_formulario'))"
function formulario_consulta_procesar($variable_array){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$id_especialista = $variable_array["id_especialista"];
$campo_nombre = $variable_array["campo_nombre"];
$campo_descripcion = $variable_array["campo_descripcion"];
$campo_tipo = $variable_array["campo_tipo"];
$campo_area = $variable_array["campo_area"];
$misma_area = $variable_array["misma_area"];
$campo_orden = $variable_array["campo_orden"];
$campo_identificador = $variable_array["campo_identificador"];
$tipo = $variable_array["tipo"];
$editar = $variable_array["editar"];
$id_campo_editar = $variable_array["id_campo_editar"];
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
if ($editar == 'editar'){
mysql_query("
						UPDATE `consulta_campos` 
						SET `campo_nombre` = '$campo_nombre',
						`campo_descripcion` = '$campo_descripcion',
						`orden` = '$campo_orden' ,
						`campo_area` = '$campo_area',
						`campo_tipo` = '$campo_tipo'
						WHERE `consulta_campos`.`id_consulta_campo` ='$id_campo_editar'
						LIMIT 1 ;",$link);
$w_campo = "id_consulta_campo = '$id_campo_editar'";						

								}else {

mysql_query("
				insert into `consulta_campos` 
			(`id_especialista`, `campo_nombre`,`campo_descripcion`,`campo_tipo`, `campo_area`, `orden`, `activo`, `identificador`) 
  values ('$id_especialista','$campo_nombre','$campo_descripcion','$campo_tipo','$campo_area','$campo_orden','1','$campo_identificador')",$link);  
$w_campo= "identificador = '$campo_identificador'";
										}

  $campos=mysql_query("
  		SELECT id_consulta_campo, campo_nombre, campo_descripcion, tipo_campo_accion, campo_area, orden
		FROM `consulta_campos` , `tipo_campo`
		WHERE $w_campo
		
		AND consulta_campos.campo_tipo = tipo_campo.id_tipo_campo
		LIMIT 1",$link);

$campos_formulario = "";
$campos_formulario .= "<div name='crear_campos_consulta_$campo_area' id='crear_campos_consulta_$campo_area'>	</div>";	
while( $row = mysql_fetch_array( $campos ) ) {
if ($row['tipo_campo_accion']=='textarea'){
$campos_formulario .= "<div  name='id_campos_consulta_".$row['id_consulta_campo']."' id='id_campos_consulta_".$row['id_consulta_campo']."'><form name='Xcampo_editar".$row['id_consulta_campo']."' id='Xcampo_editar".$row['id_consulta_campo']."'><input  name='id_campo_editar' id='id_campo_editar' value='".$row['id_consulta_campo']."' type='hidden'><input type='hidden' name='Xarea' id='Xarea' value='".$row['campo_area']."' type='hidden'><input name='id_campo_editar' type='hidden' id='id_campo_editar' value='".$row['id_consulta_campo']."'></form>".$row['orden']."<input type='button' style='width: 200;text-align: left;'  value='".$row['campo_nombre']."' OnClick=\"xajax_crear_campos_consulta(xajax.getFormValues('Xcampo_editar".$row['id_consulta_campo']."'));\" title='".$row['campo_descripcion']."'><br><textarea name='".$row['campo_nombre']."' rows='5' cols='70'></textarea></div><br><br>";}
else{
$campos_formulario .= "<div   name='id_campos_consulta_".$row['id_consulta_campo']."' id='id_campos_consulta_".$row['id_consulta_campo']."'><form name='Xcampo_editar".$row['id_consulta_campo']."' id='Xcampo_editar".$row['id_consulta_campo']."'><input name='id_campo_editar' id='id_campo_editar' value='".$row['id_consulta_campo']."' type='hidden' ><input type='hidden' name='Xarea' id='Xarea' value='".$row['campo_area']."' ><input name='id_campo_editar' id='id_campo_editar' value='".$row['id_consulta_campo']."' type='hidden'></form>".$row['orden']."<input type='button' style='width: 200;text-align: left;'  value='".$row['campo_nombre']."' OnClick=\"xajax_crear_campos_consulta(xajax.getFormValues('Xcampo_editar".$row['id_consulta_campo']."'));\" title='".$row['campo_descripcion']."'><br> <input name='".$row['campo_nombre']."' id='".$row['campo_nombre']."' type='".$row['tipo_campo_accion']."' size='72'></div><br><br>";
																	  }																		}


$respuesta->addAssign("formulario_campos_$misma_area","innerHTML",$campos_formulario);
return $respuesta;
} 

/// FIN DE LA FUNCION 


/// FIN DE LA FUNCION dummy

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
