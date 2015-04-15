<?php
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: includes/error.php");
// echo "hola mundo2";
} 

//registramos la función creada anteriormente al objeto xajax
$xajax->registerFunction("procesar_alistamiento");
$xajax->registerFunction("dummy");
$xajax->registerFunction("guardar_digitacion");
$xajax->registerFunction("procesar_formulario");
$xajax->registerFunction("estadisticas_alistamiento");
$xajax->registerFunction("ventas_procesar");
$xajax->registerFunction("revisar_documento");
$xajax->registerFunction("revisar_email");
$xajax->registerFunction("revisar_telefono");
$xajax->registerFunction("generar_select");
$xajax->registerFunction("municipios");
$xajax->registerFunction("ciudades");
$xajax->registerFunction("servicio_cliente");
$xajax->registerFunction("usuario_datos");
$xajax->registerFunction("terceros");
$xajax->registerFunction("terceros_modificar");
$xajax->registerFunction("turnos_procesar");
$xajax->registerFunction("turnos_grabar");
$xajax->registerFunction("dar_cita");
$xajax->registerFunction("autorizar_consulta");
$xajax->registerFunction("formulario_consulta_procesar");
$xajax->registerFunction("crear_campos_consulta");
$xajax->registerFunction("grabar_consulta");
$xajax->registerFunction("grabar_receta");
$xajax->registerFunction("revisar_medicamentos");
$xajax->registerFunction("revisar_orden");
$xajax->registerFunction("grabar_orden");
$xajax->registerFunction("impresion_medicamentos");
$xajax->registerFunction("impresion_ordenes");
$xajax->registerFunction("impresion_ctc");
$xajax->registerFunction("grabar_ayudas");
$xajax->registerFunction("superficie_corporal");
$xajax->registerFunction("ayudas_diagnosticas");
$xajax->registerFunction("revisar_ayudas_diagnosticas");
$xajax->registerFunction("campos_consulta_dinamico");
$xajax->registerFunction("resumen_consulta");
$xajax->registerFunction("factura_buscar");
$xajax->registerFunction("factura_agregar");
$xajax->registerFunction("factura_modificar");
$xajax->registerFunction("factura_encabezado_grabar");
$xajax->registerFunction("factura_encabezado_modificar");
$xajax->registerFunction("campos_consulta_analisis");
$xajax->registerFunction("cie_formularioconsulta");
//$xajax->registerFunction("cambiar_numero_letras");
$xajax->processRequests();
//include_once('numeros_letras.php');



///NOMBRE DE LA FUNCION: dummy
// para llamar la funcion utilizar 
// onChange="xajax_dummy(xajax.getFormValues('nombre_formulario'))"
function dummy($variable_array){
//creo el xajaxResponse para generar una salida

$respuesta = new xajaxResponse('ISO-8859-1');
$Valor = $variable_array[""];
//include_once("librerias/conex.php"); 
//$link=Conectarse(); 
//mysql_query("SET NAMES 'utf8'");

//$sql=mysql_query("SELECT * FROM d9_users WHERE nombre_completo != '' LIMIT 0,10",$link);



//if (mysql_num_rows($sql)!='0'){
//while( $row = mysql_fetch_array( $sql ) ) {
//$nuevo_select .= "" . $row['id'] . "" . $row['nombre_completo'] . "<br>";
//															}
//										}
$nuevo_select .= "<h1>Los dummys</h1>";
$respuesta->addAssign("capadummy","innerHTML",$nuevo_select);
return $respuesta;
} 

/// fin dummy



///NOMBRE DE LA FUNCION: factura_encabezado_grabar
// para llamar la funcion utilizar 
// onChange="xajax_dummy(xajax.getFormValues('nombre_formulario'))"
function factura_encabezado_modificar($variable_array){ 
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$id_factura = $variable_array["id_factura"];
$respuesta = new xajaxResponse('ISO-8859-1');
$referencia = $variable_array["referencia"];
$f_factura = $variable_array['fecha_factura'];
list( $ano, $mes, $dia ) = split( '[-]', $f_factura );
$fecha_factura=mktime(0,0,0, $mes, $dia, $ano);
$f_vencimiento = $variable_array['fecha_vencimiento'];
list( $ano, $mes, $dia ) = split( '[-]', $f_vencimiento );
$fecha_vencimiento=mktime(0,0,0, $mes, $dia, $ano);
$f_pronto_pago = $variable_array['fecha_pronto_pago'];
list( $ano, $mes, $dia ) = split( '[-]', $f_pronto_pago );
$fecha_pronto_pago=mktime(0,0,0, $mes, $dia, $ano);
$descuento_pronto_pago = $variable_array['descuento_pronto_pago'];
$folios = $variable_array['folios'];
$id_cliente = $variable_array['id_cliente'];
$letras = $variable_array['letras'];
$id_funcionario = $_SESSION['id_usuario'];

//include_once("librerias/conex.php"); 
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");

$sql = mysql_query("
UPDATE `facturas` SET 
`fecha_factura` = '$fecha_factura',
`fecha_vencimiento` = '$fecha_vencimiento',
`id_cliente` = '$id_cliente',
`fecha_pronto_pago` = '$fecha_pronto_pago',
`descuento_pronto_pago` = '$descuento_pronto_pago',
`subtotal` = '$subtotal',
`descuento` = '$descuento',
`total` = '$total',
`id_usuario` = '$id_usuario',
`folios` = '$folios' ,
`letras` = '$letras' ,
`referencia` = '$referencia' 
WHERE `id_factura` = '$id_factura' LIMIT 1",$link);

$nuevo_select .= "<h1>GRABADO</h1>";

//if (mysql_num_rows($sql)!='0'){
//while( $row = mysql_fetch_array( $sql ) ) {
//$nuevo_select .= "" . $row['id'] . "" . $row['nombre_completo'] . "<br>";
//															}
//										}
//$nuevo_select .= "<h1>Los dummys</h1>";
//$respuesta->addAssign("confirmacion","innerHTML",$nuevo_select);
return $respuesta;
} 

/// fin factura_encabezado_grabar



///NOMBRE DE LA FUNCION: factura_encabezado_grabar
// para llamar la funcion utilizar 
// onChange="xajax_dummy(xajax.getFormValues('nombre_formulario'))"
function factura_encabezado_grabar($variable_array){ 
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$id_factura = $variable_array["id_factura"];
$respuesta = new xajaxResponse('ISO-8859-1');
$referencia = $variable_array["referencia"];
$f_factura = $variable_array['fecha_factura'];
list( $ano, $mes, $dia ) = split( '[-]', $f_factura );
$fecha_factura=mktime(0,0,0, $mes, $dia, $ano);
$f_vencimiento = $variable_array['fecha_vencimiento'];
list( $ano, $mes, $dia ) = split( '[-]', $f_vencimiento );
$fecha_vencimiento=mktime(0,0,0, $mes, $dia, $ano);
$f_pronto_pago = $variable_array['fecha_pronto_pago'];
list( $ano, $mes, $dia ) = split( '[-]', $f_pronto_pago );
$fecha_pronto_pago=mktime(0,0,0, $mes, $dia, $ano);
$descuento_pronto_pago = $variable_array['descuento_pronto_pago'];
$folios = $variable_array['folios'];
$id_cliente = $variable_array['id_cliente'];
$letras = $variable_array['letras'];
$id_funcionario = $_SESSION['id_usuario'];

//include_once("librerias/conex.php"); 
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");

$sql = mysql_query("
INSERT INTO `facturas` (
`id_factura` ,
`fecha_factura` ,
`referencia` ,
`fecha_vencimiento` ,
`id_cliente` ,
`fecha_pronto_pago` ,
`descuento_pronto_pago` ,
`letras` ,
`elaboro` ,
`folios` 

)
VALUES (
'$id_factura',
 '$fecha_factura', 
 '$referencia', 
 '$fecha_vencimiento', 
 '$id_cliente', 
 '$fecha_pronto_pago', 
 '$descuento_pronto_pago',  
 '$letras', 
 '$id_funcionario', 
 '$folios'
)",$link);

$nuevo_select .= "<h1>GRABADO</h1>";

//if (mysql_num_rows($sql)!='0'){
//while( $row = mysql_fetch_array( $sql ) ) {
//$nuevo_select .= "" . $row['id'] . "" . $row['nombre_completo'] . "<br>";
//															}
//										}
$nuevo_select .= "<h1>Los dummys</h1>";
$respuesta->addAssign("confirmacion","innerHTML",$nuevo_select);
return $respuesta;
} 

/// fin factura_encabezado_grabar


///NOMBRE DE LA FUNCION: factura_modificar
// para llamar la funcion utilizar 
// onChange="xajax_dummy(xajax.getFormValues('nombre_formulario'))"
function factura_modificar($variable_array){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$timestamp_facturacion = time();
$factura_responsable = $_SESSION['id_usuario'];

$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
foreach ($variable_array["recibo"] as $clave => $valor)
{if($valor != ''){ mysql_query("UPDATE turnos SET recibo='$valor' WHERE id_turno='$clave' LIMIT 1	",$link);}}
foreach ($variable_array["factura_descripcion"] as $clave => $valor)
{if($valor != ''){ mysql_query("UPDATE turnos SET factura_descripcion='$valor' WHERE id_turno='$clave' LIMIT 1	",$link);}}
foreach ($variable_array["id_fact"] as $clave => $valor)
{if($valor != ''){ mysql_query("UPDATE turnos SET 
		factura='$valor',
		factura_responsable='$factura_responsable' ,
		timestamp_facturacion='$timestamp_facturacion',
		estado='4' WHERE id_turno='$clave' LIMIT 1	",$link);}}
foreach ($variable_array["valor_procedimiento"] as $clave => $valor)
{ mysql_query("UPDATE turnos SET valor_procedimiento='$valor' WHERE id_turno='$clave' LIMIT 1	",$link);}
foreach ($variable_array["excedente"] as $clave => $valor)
{ mysql_query("UPDATE turnos SET excedente='$valor' WHERE id_turno='$clave' LIMIT 1	",$link);}
foreach ($variable_array["cantidad"] as $clave => $valor)
{if($valor != ''){ mysql_query("UPDATE turnos SET cantidad='$valor' WHERE id_turno='$clave' LIMIT 1	",$link);}}

foreach ($variable_array["id_fact"] as $clave => $valor)
{if($valor != ''){ mysql_query("UPDATE turnos SET total=(valor_procedimiento * cantidad) - excedente WHERE id_turno='$clave' LIMIT 1	",$link);}}


//$sql=mysql_query("SELECT * FROM d9_users WHERE nombre_completo != '' LIMIT 0,10",$link);

$nuevo_select = "<h1>$Valor</h1>";

//if (mysql_num_rows($sql)!='0'){
//while( $row = mysql_fetch_array( $sql ) ) {
//$nuevo_select .= "" . $row['id'] . "" . $row['nombre_completo'] . "<br>";
//															}
//										}
$nuevo_select .= "<h1>Los dummys</h1>";
//$respuesta->addAssign("capadummy","innerHTML",$nuevo_select);
return $respuesta;
} 

/// fin dummy




///NOMBRE DE LA FUNCION: factura_agregar
// para llamar la funcion utilizar 
// onChange="xajax_producto_agregar(xajax.getFormValues('nombre_formulario'))"
function factura_agregar($facturacion){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$id_turno = $facturacion["id_turno"];
$id_factura = $facturacion["id_factura"];
$timestamp_facturacion = time();
$factura_responsable = $_SESSION['id_usuario'];
if($id_turno != ''){

//include_once("librerias/conex.php"); 
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
mysql_query("
 	update 
 		turnos  
 	set 
		 
		factura='$id_factura',
		factura_responsable='$factura_responsable' ,
		timestamp_facturacion='$timestamp_facturacion',
		estado='4'
	where 
		id_turno='$id_turno'
					",$link);


$nuevo_select .= "Proceso <b>$id_turno</b> agregado a la factura <b>$id_factura</b>";
} else {$nuevo_select = "<h1>debe elegir un proceso para facturar</h1>";}

//$sql=mysql_query("SELECT * FROM d9_users WHERE nombre_completo != '' LIMIT 0,10",$link);


//if (mysql_num_rows($sql)!='0'){
//while( $row = mysql_fetch_array( $sql ) ) {
//$nuevo_select .= "" . $row['id'] . "" . $row['nombre_completo'] . "<br>";
//															}
//										}
$respuesta->addAssign("capa_turno","innerHTML",$nuevo_select);
return $respuesta;
} 

/// fin factura_agregar




///NOMBRE DE LA FUNCION: factura_buscar
// para llamar la funcion utilizar 
// onChange="xajax_dummy(xajax.getFormValues('nombre_formulario'))"
function factura_buscar($variable_array){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$id_factura = $variable_array["id_factura"];
if($id_factura == ''){$nuevo_select .= "<center>No se ha seleccionado un n&uacute;mero de factura <img src='../images/atencion.gif' alt='!'></center><hr>";
$respuesta->addAssign("factura_formato","innerHTML",$nuevo_select);
return $respuesta;

}
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
$nuevo_select .= "<h1>Factura # $id_factura</h1>";

$factura=mysql_query("SELECT * FROM facturas WHERE id_factura = '$id_factura'",$link);

while( $row = mysql_fetch_array( $factura ) ) {
$referencia = $row['referencia'];
$fecha_factura = $row['fecha_factura'];
$fecha_factura = date('Y-m-d',$fecha_factura);
$fecha_vencimiento = $row['fecha_vencimiento'];
$fecha_vencimiento = date('Y-m-d',$fecha_vencimiento);
$fecha_pronto_pago = $row['fecha_pronto_pago'];
$fecha_pronto_pago = date('Y-m-d',$fecha_pronto_pago);
$descuento_pronto_pago = $row['descuento_pronto_pago'];
$folios = $row['folios'];
$id_cliente = $row['id_cliente'];
$letras = $row['letras'];
$mtime= microtime();
}
$total=mysql_query("SELECT sum( valor_procedimiento ) AS Total
FROM `turnos`
WHERE factura = $id_factura
GROUP BY factura",$link);
$row = mysql_fetch_row($total);
$Total_factura = number_format($row[0], 2, ',', '.'); 

$total_excedente=mysql_query("SELECT sum( excedente ) AS Excedente
FROM `turnos`
WHERE factura = $id_factura
GROUP BY factura",$link);
$row_excedente = mysql_fetch_row($total_excedente);
$Total_excedente = number_format($row_excedente[0], 2, ',', '.'); 
$Gran_total = ($row[0] - $row_excedente[0]); 

$Gran_total = number_format($Gran_total, 2, ',', '.');

if($fecha_factura == ''){$fecha_factura=date('Y-m-d');}
list( $ano, $mes, $dia ) = split( '[-]', $fecha_factura );

if($fecha_vencimiento == ''){
$f_vencimiento=mktime(0,0,0, $mes, $dia, $ano);
$fecha_vencimiento = ($f_vencimiento + 2592000);
$fecha_vencimiento = date('Y-m-d',$fecha_vencimiento);
													}

$nuevo_select .= "
	Referencia: <br><input type='text' size='70' name='referencia' value='$referencia' title='Referencia de la factura'><br>
	Fecha factura: [<b title='fecha de emisión o impresión para la factura'>?</b>]
	<input  READONLY size='10' id='fc_1 $mtime'  title='YYYY-MM-DD' onClick=\"displayCalendar(this);\" type='text' name='fecha_factura'  value='$fecha_factura' >
	Fecha vencimiento: <input READONLY  type='text' size='10' name='fecha_vencimiento' value='$fecha_vencimiento'  id='fc_2 $mtime'  title='YYYY-MM-DD' onClick=\"displayCalendar(this);\">
	<br>Fecha pronto pago: <input type='text' READONLY  size='10' name='fecha_pronto_pago' value='$fecha_pronto_pago' id='fc_3 $mtime'  title='YYYY-MM-DD' onClick=\"displayCalendar(this);\"> 
	Descuento pronto pago: <input type='text' size='3' name='descuento_pronto_pago' value='$descuento_pronto_pago' title='Descuento pronto pago (%)'>%
	Folios: <input type='text' size='3' name='folios' value='$folios' title='Folios anexos a la factura'>
	<br>Valor procedimientos: $ $Total_factura Coopagos: $ $Total_excedente  <b>Gran Total: $ $Gran_total</b>
	<br>Valor en letras:<br> <input type='text' size='70' name='letras' value='$letras' title='Valor en letras'>
	<br>
	";

	include_once('terceros/listado_asignacion_xajax.php');
  $nuevo_select .= "<hr>";
if (mysql_num_rows($factura)!='0'){
$nuevo_select .= "<a OnClick=\"xajax_factura_encabezado_modificar(xajax.getFormValues('facturacion')); xajax_factura_buscar(xajax.getFormValues('facturacion'));\" title='Grabar encabezado'><h2>[ Grabar encabezado # $id_factura ]</h2></a>";
																	}else { $nuevo_select .= "<div name='confirmacion' id='confirmacion' ></div><a  title='Crear una nueva factura con este número' OnClick=\"xajax_factura_encabezado_grabar(xajax.getFormValues('facturacion'))\"><h2>[ Iniciar factura # $id_factura ]</h2></a>";}															
																							
										
//include_once("librerias/conex.php"); 


/// inserccion procesos sin facturar
$sql=mysql_query("
	SELECT 
		turnos.id_turno,
		turnos.fecha, 
		d9_users.nombre_completo, 
		eventos.nombre,
		codigo
	FROM 
		turnos, 
		d9_users,
		eventos ,
		clientes 
	WHERE ( factura IS NULL OR turnos.factura = '' ) 
	AND d9_users.id = turnos.especialista
	AND eventos.id_evento = turnos.id_evento 
	AND clientes.id_cliente =turnos.id_cliente
	AND turnos.autorizacion= '1'
	
	ORDER BY clientes.codigo , fecha
	
	
	
	",$link);



$turnos=mysql_query("
	select 
	 
	turnos.id_turno,
	turnos.factura,
	turnos.id_turno,
	turnos.fecha, 
	turnos.id_evento,
	turnos.recibo,
	turnos.factura_descripcion,
	turnos.valor_procedimiento,
	turnos.excedente, 
	d9_users.documento_tipo,
	d9_users.documento_numero, 
	d9_users.nombre_completo,
	turnos.observaciones,
	turnos.total, 
	turnos.cantidad, 
	turnos.id_procedimiento,
	d9_users.id,
	eventos.nombre,
	eventos.cups
	
from 
	d9_users, 
	turnos,
	eventos
where  
	(turnos.factura =  '$id_factura') 
and 
	(turnos.id_usuario = d9_users.id)
 
and 
	(turnos.id_evento = eventos.id_evento)


order by
	 turnos.fecha 
	asc
	
	",$link);

if (mysql_num_rows($turnos)!='0'){
$nuevo_select .= "<table border='0' >
<tr bgcolor='beige'>
	<td>#</td>	
	<td>Cant</td>
	<td><CENTER>USUARIO</td>
	<td>CUPS</td>
	<td>BOLETA</td>
	<td><center>DESCRIPCION</td>
	<td>VALOR</td>
	<td>COOPAGO</td>
	<td>TOTAL</td>
</tr> "; 
while( $row = mysql_fetch_array( $turnos ) ) {
if ($row['factura_descripcion'] ==''){$descripcion = $row['nombre'];} else {$descripcion = $row['factura_descripcion'];}
$nuevo_select .= "<tr>
	<td><input type='text' name='id_fact[".$row['id_turno']."]' id='id_fact[".$row['id_turno']."]' SIZE='6' value='".$row['factura']."' OnBlur=\"xajax_factura_modificar(xajax.getFormValues('facturacion')); xajax_factura_buscar(xajax.getFormValues('facturacion'));\" ></td>
	<td><input size='3' name='cantidad[".$row['id_turno']."]' id='cantidad[".$row['id_turno']."]' value='".$row['cantidad']."' 
	OnBlur=\"xajax_factura_modificar(xajax.getFormValues('facturacion')); xajax_factura_buscar(xajax.getFormValues('facturacion'));\"></td>	
	<td><font size='-2'>". $row['nombre_completo'] . "</font></td>
	<td>" . $row['cups'] . "</td>
	<td><input size='8' name='recibo[".$row['id_turno']."]' id='recibo[".$row['id_turno']."]' value='".$row['recibo']."' OnBlur=\"xajax_factura_modificar(xajax.getFormValues('facturacion')); xajax_factura_buscar(xajax.getFormValues('facturacion'));\" ></td>
	<td><input name='factura_descripcion[".$row['id_turno']."]' id='factura_descripcion[".$row['id_turno']."]' value='$descripcion' title='$descripcion' ></td>
	<td>$ <input size='8' name='valor_procedimiento[".$row['id_turno']."]' id='valor_procedimiento[".$row['id_turno']."]' value='".$row['valor_procedimiento']."' OnBlur=\"xajax_factura_modificar(xajax.getFormValues('facturacion')); xajax_factura_buscar(xajax.getFormValues('facturacion'));\" ></td>
	<td>$ <input size='8' type='text' name='excedente[".$row['id_turno']."]' id='excedente[".$row['id_turno']."]' value='".$row['excedente']."' OnBlur=\"xajax_factura_modificar(xajax.getFormValues('facturacion')); xajax_factura_buscar(xajax.getFormValues('facturacion'));\" ></td>
	<td>$ ". $row['total'] . "</td></tr>";
																					}
$nuevo_select .="</table>
<hr>
										";
																	}

if (mysql_num_rows($sql)!='0'){
$nuevo_select .= "Procesos sin facturar:<br><select name='id_turno' id='id_turno' style='width:400px'>
<option value=''>Elija un proceso para facturar</option> ";
while( $row = mysql_fetch_array( $sql ) ) {
$nuevo_select .= "<option value='".$row['id_turno']."'>" . $row['codigo'] . " ". $row['fecha'] . " " . $row['nombre_completo'] . " ". $row['nombre'] . "</option>";
																					}

$nuevo_select .= "</select>
<input type='button' OnClick=\"xajax_factura_agregar(xajax.getFormValues('facturacion')); xajax_factura_buscar(xajax.getFormValues('facturacion'));\" value='Agregar a la factura $id_factura'>
<div name='capa_turno' id='capa_turno'></div>
 ";
										}			else { $nuevo_select .= "<h1>No hay procesos pendientes</h1>";}						


/// fin de la insercion de los procesos sin facturar

$respuesta->addAssign("factura_formato","innerHTML",$nuevo_select);
return $respuesta;
} 

/// fin dummy


///NOMBRE DE LA FUNCION: resumen_consulta
// para llamar la funcion utilizar 
// onChange="xajax_dummy(xajax.getFormValues('nombre_formulario'))"
function resumen_consulta($id_turno){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$nuevo_select .= "<h2>Resumen de esta consulta</h2>";

//include_once("librerias/conex.php"); 
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
$areas=mysql_query(" 
					SELECT DISTINCT(consulta_datos.id_campo),
					consulta_campos.campo_area ,
					consulta_areas.consulta_area_nombre,
					consulta_datos.id_consulta_datos
					FROM 
					consulta_datos, 
					consulta_campos,
					consulta_areas 
					WHERE 
					id_turno = '$id_turno' 
					AND consulta_campos.id_consulta_campo = consulta_datos.id_campo
					AND consulta_datos.contenido != ''
					AND	consulta_campos.campo_area = consulta_areas.id_consulta_area
					GROUP BY consulta_campos.campo_area ",$link);
					

					
if (mysql_num_rows($areas)!='0'){
while( $row = mysql_fetch_array( $areas ) ) {
$nuevo_select .= "<b> " .$row['consulta_area_nombre'] . "</b><ul>";
$area = $row['campo_area'];
$id_consulta_datos = $row['id_consulta_datos'];
/// los campos de cada area

$sql=mysql_query("
					SELECT DISTINCT(consulta_datos.id_campo),
					consulta_datos.contenido, 
					consulta_campos.campo_nombre  
					FROM 
					consulta_datos, 
					consulta_campos 
					WHERE 
					id_turno = '$id_turno' 
					AND consulta_campos.id_consulta_campo = consulta_datos.id_campo 
					AND consulta_datos.contenido != '' 
					AND consulta_campos.campo_area = $area;
					",$link);



if (mysql_num_rows($sql)!='0'){
while( $row = mysql_fetch_array( $sql ) ) {
$nuevo_select .= "<li>" .$row['campo_nombre'] . ":<b> " . $row['contenido'] . "</b></li>";
															}
										}

/// fin de los campos de cada area
$nuevo_select .= "</ul>";
															}
										}

/// fin de las aread de consulta
/// recetas formuladas en esta consulta
//pos
$pos=mysql_query("SELECT *, recetas.estado FROM recetas, medicamentos WHERE id_turno='$id_turno' AND recetas.id_medicamento = medicamentos.id_medicamento AND medicamentos.nopos='0'",$link);



if (mysql_num_rows($pos)!='0'){
$nuevo_select .= "<b>Medicamentos POS formulados</b><ol>";
while( $row = mysql_fetch_array( $pos ) ) {
$nuevo_select .= "<li title='".$row['posologia']."'><b>".$row['medicamento_nombre']."</b> ".$row['concentracion_forma']."<b> [".$row['cantidad']."]</b></li>";
															}
															$nuevo_select .= "</ol>";
										}
//fin pos
//NO pos
$no_pos=mysql_query("SELECT *, recetas.estado FROM recetas, medicamentos WHERE id_turno='$id_turno' AND recetas.id_medicamento = medicamentos.id_medicamento AND medicamentos.nopos='1'",$link);

if (mysql_num_rows($no_pos)!='0'){
$nuevo_select .= "<b>Medicamentos NO POS formulados</b><ol>";
while( $row = mysql_fetch_array( $no_pos ) ) {
$nuevo_select .= "<li title='".$row['posologia']."'><b>".$row['medicamento_nombre']."</b> ".$row['concentracion_forma']."<b> [".$row['cantidad']."]</b></li>";
															}
															$nuevo_select .= "</ol>";
										}
//fin NO pos
/// fin de las recetas formuladas en esta consulta
//ordenes expedidas en la consulta
$ordenes=mysql_query("SELECT *, ordenes.estado FROM ordenes, tipo_orden WHERE id_turno='$id_turno' AND ordenes.id_tipo_orden = tipo_orden.id_tipo_orden",$link);

if (mysql_num_rows($ordenes)!='0'){
$nuevo_select .= "<b>Ordenes expedidas</b><ol>";
while( $row = mysql_fetch_array( $ordenes ) ) {
$nuevo_select .= "<li title='".$row['observaciones']."'><b>".$row['orden_tipo']."</b> </li>";
															}
															$nuevo_select .= "</ol>";
										}

//fin ordenes expedidas en la consulta



$respuesta->addAssign("consulta_dinamico","innerHTML",$nuevo_select);
return $respuesta;
} 

/// fin dummy

///NOMBRE DE LA FUNCION: ayudas_diagnosticas
// para llamar la funcion utilizar 
// onChange="xajax_dummy(xajax.getFormValues('nombre_formulario'))"
function ayudas_diagnosticas($titulo){

//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');

$ayuda = "

		<div name='$titulo"."_".$especialista."' id='$titulo"."_".$especialista."' style='border: 1px solid #$color; ' >
		<div  class='cabecera'><li>$titulo </li> </div>
		<hr><h1>$titulo </h1>
		<div name='ayudas_diagnosticas' id='ayudas_diagnosticas' >
											";


$ayuda .= "

Tipo: <select name='ayuda_clase' id='ayuda_clase' onchange=\"xajax_revisar_ayudas_diagnosticas(xajax.getFormValues('consulta'))\">
<option  value='' title='Click para seleccionar'>Elija un tipo de ayuda diagnóstica</option>
";
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
$sql=mysql_query("SELECT * FROM ayuda_clases WHERE activo = '1' ",$link);

if (mysql_num_rows($sql)!='0'){
while( $row = mysql_fetch_array( $sql ) ) {
$ayuda .= "<option value='".$row['id_ayuda_clase']."' > ".$row['ayuda_clase']." </option>";
															}
										}
$ayuda .= "
</select><br> 
<div id='ayudas_diagnosticas_formulario' name='ayudas_diagnosticas_formulario'></div>

							";
$ayuda .="</div>";
$respuesta->addAssign("consulta_dinamico","innerHTML",$ayuda);
return $respuesta;
} 

/// fin ayudas_diagnosticas


///NOMBRE DE LA FUNCION: revisar_ayudas_diagnosticas
// para llamar la funcion utilizar 
// onChange="xajax_dummy(xajax.getFormValues('nombre_formulario'))"
function revisar_ayudas_diagnosticas($variable_array){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$id_ayuda_clase = $variable_array["ayuda_clase"];
$link=Conectarse();
mysql_query("SET NAMES 'utf8'");
$sql=mysql_query("SELECT * FROM ayuda_clases WHERE id_ayuda_clase = '$id_ayuda_clase' ",$link);

if (mysql_num_rows($sql)!='0'){
while( $row = mysql_fetch_array( $sql ) ) {
$nuevo_select = "

Laboratorio o entidad responsable:<br>
 <input type='text' name='ayuda_laboratorio' id='ayuda_laboratorio' size='72' ><br>
Fecha: <input type='text' name='ayuda_fecha' id='ayuda_fecha' size='20' ><br>

Observaciones: <br>
<textarea name='ayuda_observaciones' id='ayuda_observaciones' cols='70' rows='10' title='Por favor escribir al frente cada valor' >".$row['ayuda_forma']."</textarea><input type='hidden' name='ayuda_titulo' id='ayuda_titulo' value='".$row['ayuda_clase']."'><br>";
$nuevo_select .="
<input onclick=\"xajax_grabar_ayudas(xajax.getFormValues('consulta'))\" value='Grabar' type='button'>";
															}
										}

$respuesta->addAssign("ayudas_diagnosticas_formulario","innerHTML",$nuevo_select);
return $respuesta;
} 

/// fin dummy




function superficie_corporal($form){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$peso=$form['20'];
$altura=$form['19'];
$seleccionar_por=$form['seleccionar_por'];
    if ($seleccionar_por == 1){
        $area=0.024265*(pow($peso,0.5378))*(pow($altura,0.3964));
    }
    elseif ($seleccionar_por == 2){
        $area=0.007184*(pow($peso,0.425))*(pow($altura,0.725));
    }
    elseif ($seleccionar_por == 3){
        $area=0.0235*(pow($peso,0.51456))*(pow($altura,0.42246));
    }
    elseif ($seleccionar_por == 4){
        $peso=$peso*1000;
        $area=0.0003207*(pow($peso,(0.7285-(0.0188*log10($peso)))))*(pow($altura,0.3));
    }
    elseif ($seleccionar_por == 5){
        $area=pow((($peso*$altura)/3600),0.5);
    }
    if ($area > 0){$area_listo='Superficie corporal:<b> '.$area.'</b> metros cuadrados'; }else{$area_listo='No hay valores correctos para el calculo';}
$nuevo_select = ''.$area_listo;
$respuesta->addAssign("capa_area","innerHTML",$nuevo_select);
return $respuesta;
}


///NOMBRE DE LA FUNCION: grabar_ayudas
// para llamar la funcion utilizar 
// onChange="xajax_dummy(xajax.getFormValues('nombre_formulario'))"
function grabar_ayudas($variable_array){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$ayuda_laboratorio = $variable_array["ayuda_laboratorio"];
$ayuda_fecha = $variable_array["ayuda_fecha"];
$ayuda_observaciones = $variable_array["ayuda_observaciones"];
$ayuda_clase = $variable_array["ayuda_clase"];
$ayuda_titulo = $variable_array["ayuda_titulo"];
$id_turno = $variable_array["id_turno"];
$id_especialista = $variable_array["id_especialista"];
$id_usuario = $variable_array["id_usuario"];
$link=Conectarse(); 
if($ayuda_laboratorio == ''){$seguir ='0';}
elseif($ayuda_fecha == ''){$seguir ='0';}
elseif($ayuda_observaciones == ''){$seguir ='0';}

if ($seguir == '0'){$atencion = "<img src='images/atencion.gif' alt= '!' title='Revise los campos, no pueden quedar vacios'> Campos incompletos no se ha grabado intentelo nuevamente<br>";}else{


mysql_query("SET NAMES 'utf8'");

$sql=mysql_query("INSERT INTO `beremundo`.`ayudas_diagnosticas` (
`id_ayuda` ,
`timestamp` ,
`id_usuario` ,
`id_especialista` ,
`id_turno` ,
`ayuda_laboratorio` ,
`ayuda_fecha` ,
`ayuda_observaciones` ,
`id_ayuda_clase`,
`ayuda_clase`
)
VALUES (
NULL ,
CURRENT_TIMESTAMP , '$id_usuario', '$id_especialista', '$id_turno', '$ayuda_laboratorio', '$ayuda_fecha', '$ayuda_observaciones', '$ayuda_clase', '$ayuda_titulo'
)",$link); 
$ayuda = "";
 }
$ayuda .= "

Tipo: <select name='ayuda_clase' id='ayuda_clase' onchange=\"xajax_revisar_ayudas_diagnosticas(xajax.getFormValues('consulta'))\">
<option  value='' title='Click para seleccionar'>Elija un tipo de ayuda diagnóstica</option>
";
//$link=Conectarse();
mysql_query("SET NAMES 'utf8'");
$sql=mysql_query("SELECT * FROM ayuda_clases WHERE activo = '1' ",$link);

if (mysql_num_rows($sql)!='0'){
while( $row = mysql_fetch_array( $sql ) ) {
$ayuda .= "<option value='".$row['id_ayuda_clase']."' > ".$row['ayuda_clase']." </option>";
															}
										}
$ayuda .= "
</select><br> 
<div id='ayudas_diagnosticas_formulario' name='ayudas_diagnosticas_formulario'>$atencion</div>
<ol>

							";					
							
$sql=mysql_query("SELECT * FROM ayudas_diagnosticas WHERE id_turno = '$id_turno' ",$link);


if (mysql_num_rows($sql)!='0'){
while( $row = mysql_fetch_array( $sql ) ) {
$ayuda .= "<li title ='" . $row['ayuda_observaciones'] . "'>" . $row['ayuda_clase'] . " / " . $row['ayuda_fecha'] . "</li>";
																					}
																					$ayuda .="</ol>";
															}	else {$ayuda .= "<h2>No se han inscrito ayudas diagnosticas en esta consulta</h2>";}						
								


$respuesta->addAssign("ayudas_diagnosticas","innerHTML",$ayuda);
return $respuesta;
} 




///NOMBRE DE LA FUNCION: impresion_ctc

function impresion_ctc($variable_array){ 
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$orden = $variable_array["orden"];
$id_usuario = $variable_array["id_usuario"];

include_once("../librerias/conex_pop.php"); 
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
if($orden == ''){$nuevo_select .= "<center>No se ha seleccionado una orden <img src='../images/atencion.gif' alt='!'></center><hr>";}
else {
$nuevo_select .="<form name='formula'  method='post' id='formula' action='ctc.php'><ol>";
foreach ($orden as $clave => $valor)
	{
	

$sql=mysql_query("SELECT * FROM recetas_no_pos, medicamentos 
							WHERE id_receta_no_pos='$clave' 
							AND medicamentos.id_medicamento = recetas_no_pos.id_medicamento",$link);

if (mysql_num_rows($sql)>'0'){
while( $row = mysql_fetch_array( $sql ) ) {
$nuevo_select .= "<li title='".$row['observaciones']."'><input type='checkbox' name='orden[$clave]' id='orden[$clave]' value='$clave' checked>".$row['medicamento_nombre']."<br> ".$row['concentracion_forma']."</li> ";
	
															}
										}
	}
$nuevo_select .="</ol><input type='hidden' name='id_usuario' id='id_usuario' value='$id_usuario'";	
$nuevo_select .="<center><br><input type='submit' value ='Imprimir formulario' ></center></form><hr>";	
		}
//include_once("librerias/conex.php"); 

//$respuesta->addScript("abrir('impresion/imprimir_receta.php','crear',700,800,100,0,1)");
$respuesta->addAssign("impresion","innerHTML",$nuevo_select);
//
return $respuesta;
} 

/// fin imprimir_ctc





///NOMBRE DE LA FUNCION: revisar_orden
// para llamar la funcion utilizar 
// onChange="xajax_dummy(xajax.getFormValues('nombre_formulario'))"
function revisar_orden($variable_array){ 
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$id_tipo_orden = $variable_array["id_tipo_orden"];
$nuevo_select = "";

//include_once("librerias/conex.php"); 
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
$sql=mysql_query("SELECT * FROM tipo_orden WHERE  id_tipo_orden = '$id_tipo_orden'",$link);
if (mysql_num_rows($sql)>'0'){ 
while( $row = mysql_fetch_array( $sql ) ) 
{
$nuevo_select .= "Ordenando: <b>" .$row['orden_tipo']."</b><br>Observaciones: <br>";
}
								
$nuevo_select .= "<textarea name='observaciones' id='observaciones' cols='70' rows='6'></textarea><br>

<input type='button' value='Grabar Orden' onClick=\"xajax_grabar_orden(xajax.getFormValues('ordenar')) \" >
";
									}else {$nuevo_select .="No se ha elegido un tipo de orden <img src='images/atencion.gif' alt='!'> ";}	
$respuesta->addAssign("confirmar_orden","innerHTML",$nuevo_select);
return $respuesta;
} 

/// fin revisar_orden


///NOMBRE DE LA FUNCION: impresion_medicamentos

function impresion_ordenes($variable_array){ 
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$orden = $variable_array["orden"];
$id_usuario = $variable_array["id_usuario"];

include_once("../librerias/conex_pop.php"); 
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
if($orden == ''){$nuevo_select .= "<center>No se ha seleccionado una orden <img src='../images/atencion.gif' alt='!'></center><hr>";}
else {
$nuevo_select .="<form name='formula'  method='post' id='formula' action='orden.php'><ol>";
foreach ($orden as $clave => $valor)
	{
//$nuevo_select .= "<li>$clave : $valor</li>";	

$sql=mysql_query("SELECT * FROM ordenes, tipo_orden 
							WHERE id_orden='$clave' 
							AND ordenes.id_tipo_orden = tipo_orden.id_tipo_orden",$link);

if (mysql_num_rows($sql)>'0'){
while( $row = mysql_fetch_array( $sql ) ) {
$nuevo_select .= "<li title='".$row['observaciones']."'><input type='checkbox' name='orden[$clave]' id='orden[$clave]' value='$clave' checked>".$row['orden_tipo']."</li> ";
	
															}
										}
	}
$nuevo_select .="</ol><input type='hidden' name='id_usuario' id='id_usuario' value='$id_usuario'";	
$nuevo_select .="<center><br><input type='submit' value ='Imprimir esta Orden' ></center></form><hr>";	
		}
//include_once("librerias/conex.php"); 

//$respuesta->addScript("abrir('impresion/imprimir_receta.php','crear',700,800,100,0,1)");
$respuesta->addAssign("impresion","innerHTML",$nuevo_select);
//
return $respuesta;
} 

/// fin imprimir ordenes


///NOMBRE DE LA FUNCION: impresion_medicamentos

function impresion_medicamentos($variable_array){ 
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$receta = $variable_array["receta"];
$id_usuario = $variable_array["id_usuario"];

include_once("../librerias/conex_pop.php"); 
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
if($receta == ''){$nuevo_select .= "<center>No se ha seleccionado un medicamento <img src='../images/atencion.gif' alt='!'></center><hr>";}
else {
$nuevo_select .="<form name='formula'  method='post' id='formula' action='formula.php'><ol>";
foreach ($receta as $clave => $valor)
	{
//$nuevo_select .= "<li>$clave : $valor</li>";	

$sql=mysql_query("SELECT * FROM recetas, medicamentos 
							WHERE id_receta='$clave' 
							AND recetas.id_medicamento = medicamentos.id_medicamento",$link);

if (mysql_num_rows($sql)>'0'){
while( $row = mysql_fetch_array( $sql ) ) {
$nuevo_select .= "<li><input type='checkbox' name='receta[$clave]' id='receta[$clave]' value='$clave' checked>".$row['medicamento_nombre']."</li> ";
	
															}
										}
	}
$nuevo_select .="</ol><input type='hidden' name='id_usuario' id='id_usuario' value='$id_usuario'";	
$nuevo_select .="<center><br><input type='submit' value ='Imprimir estos medicamentos' ></center></form><hr>";	
		}
//include_once("librerias/conex.php"); 

//$respuesta->addScript("abrir('impresion/imprimir_receta.php','crear',700,800,100,0,1)");
$respuesta->addAssign("impresion","innerHTML",$nuevo_select);
//
return $respuesta;
} 

/// fin dummy

///NOMBRE DE LA FUNCION: grabar_orden
// para llamar la funcion utilizar 
// onChange="xajax_dummy(xajax.getFormValues('nombre_formulario'))"
function grabar_orden($variable_array){ 
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$id_turno = $variable_array["id_turno"];
$id_especialista = $variable_array["id_especialista"];
$id_usuario = $variable_array["id_usuario"];
$observaciones = $variable_array["observaciones"];
$id_tipo_orden = $variable_array["id_tipo_orden"];
$control = microtime();
$hoy=date('Y-m-d');
list( $ano, $mes, $dia ) = split( '[-]', $hoy );
$fecha_comas = $ano.",".$mes.",".$dia;
$timestamp=mktime(0,0,0, $mes, $dia, $ano);
if($id_tipo_orden == ''){
$nuevo_select = "<h1><img src='images/atencion.gif' alt='!'>Elija un tipo de orden</h1>";
$respuesta->addAssign("estado_orden","innerHTML",$nuevo_select);
return $respuesta;
								}
//include_once("librerias/conex.php"); 
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
mysql_query("INSERT INTO `ordenes` ( `id_orden` , `id_usuario` , `id_especialista` , `timestamp` , `observaciones` , `id_tipo_orden` , `revisada` , `id_turno` , `control` )
VALUES (
NULL , '$id_usuario', '$id_especialista', '$timestamp', '$observaciones', '$id_tipo_orden', '0', '$id_turno', '$control'
)",$link);

$sql=mysql_query("SELECT tipo_orden.orden_tipo, ordenes.observaciones FROM ordenes,tipo_orden WHERE id_turno = '$id_turno' AND ordenes.id_tipo_orden = tipo_orden.id_tipo_orden ",$link);

$nuevo_select = "<h2>Ordenes expedidas en esta consulta:</h2><ol>";
while( $row = mysql_fetch_array( $sql ) ) {
$nuevo_select .= "<li>".$row['orden_tipo'].": ".$row['observaciones']."</li>";
}

$nuevo_select .="</ol>";
$respuesta->addAssign("confirmar_orden","innerHTML",$nuevo_select);
return $respuesta;
} 

/// fin dummy

///NOMBRE DE LA FUNCION: revisar_medicamentos
// para llamar la funcion utilizar 
// onChange="xajax_dummy(xajax.getFormValues('nombre_formulario'))"
function revisar_medicamentos($id_medicamento,$id_usuario){  
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
//$Valor = $id_medicamento["id_medicamento"];
//$id_usuario = $id_medicamento["id_usuario"];



//include_once("librerias/conex.php"); 
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
$sql=mysql_query("SELECT * FROM medicamentos WHERE id_medicamento = '$id_medicamento' LIMIT 1",$link);

$nuevo_select = "Formulando: ";
$nuevo_select .= "<input type='hidden' name='receta' id='receta' value='$id_medicamento'>";
while( $row = mysql_fetch_array( $sql ) ) {

$nuevo_select .= "<b>".$row['id_medicamento']." ".$row['medicamento_nombre']." ".$row['concentracion_forma']."</b>";
if ($row['nopos']=='1'){
$no_pos=mysql_query("SELECT * FROM recetas_no_pos WHERE id_medicamento = '$id_medicamento' 
							AND id_usuario = $id_usuario  ORDER BY id_receta_no_pos DESC LIMIT 1",$link);
while( $pos = mysql_fetch_array( $no_pos ) ) {
$pos_usado=$pos['pos_usado'];
$tiempo_utilizacion=$pos['tiempo_utilizacion'];
$pos_usado_respuesta=$pos['pos_usado_respuesta'];
$riesgo=$pos['riesgo'];
$efecto_deseado=$pos['efecto_deseado'];
$tiempo_respuesta=$pos['tiempo_respuesta'];
$efectos_secundarios=$pos['efectos_secundarios'];
$observaciones=$pos['observaciones'];
$cantidad=$pos['cantidad'];
$cantidad_letras=$pos['cantidad_letras'];
$posologia=$pos['posologia'];
														}

$nuevo_select .= "<h1>No POS</h1>

<input type='hidden' name='no_pos' id='no_pos' value='no_pos'>
<li>Medicamento POS usado anteriormente:<br>
<textarea name='pos_usado' id='pos_usado' cols='70' rows='3'>$pos_usado</textarea></li>
<li>Tiempo utilizaci&oacute;n del no POS:<br>
<input type='text' name='tiempo_utilizacion' id='tiempo_utilizacion' value='$tiempo_utilizacion' size='70'></li>
<li>Respuesta clínica y paraclínica alcanzada con el medicamento POS:<br>
<textarea name='pos_usado_respuesta' id='pos_usado_respuesta' cols='70' rows='3'>$pos_usado_respuesta</textarea></li>
<li>Riesgo inminente al no ser aplicado el medicamento:<br>
<textarea name='riesgo' id='riesgo' cols='70' rows='3'>$riesgo</textarea></li>
<li>Efecto deseado con la aplicacion del medicamento:<br>
<textarea name='efecto_deseado' id='efecto_deseado' cols='70' rows='3'>$efecto_deseado</textarea></li>
<li>Tiempo estimado de respuesta:<br>
<input type='text' name='tiempo_respuesta' id='tiempo_respuesta' value='$tiempo_respuesta' size='70'></li>
<li>Posibles efectos secundarios:<br>
<textarea name='efectos_secundarios' id='efectos_secundarios' cols='70' rows='3'>$efectos_secundarios</textarea></li>
<li>Bibliografia y observaciones:<br>
<textarea name='observaciones' id='observaciones' cols='70' rows='3'>".$row['observaciones']."</textarea></li>
<li>Cantidad: <input type='text' name='cantidad' id='cantidad' value='$cantidad' size='4'>
Cantidad letras:<input type='text' name='cantidad_letras' id='cantidad_letras' value='$cantidad_letras'></li>
<li>Posologia<br>
<textarea name='posologia' id='posologia' cols='70' rows='5'>$posologia</textarea></li><br> 

<input type='button' onClick=\"xajax_grabar_receta(xajax.getFormValues('recetar')) \" value='Recetar' >
						
							";}
							
							else{ 
							
$pos_receta=mysql_query("SELECT * FROM recetas WHERE id_medicamento = '$id_medicamento' 
							AND id_usuario = $id_usuario  ORDER BY id_receta DESC LIMIT 1",$link);
while( $pos = mysql_fetch_array( $pos_receta ) ) {
$cantidad=$pos['cantidad'];
$cantidad_letras=$pos['cantidad_letras'];
$posologia=$pos['posologia'];
														}							
							
							$nuevo_select .= "
<li>Cantidad: <input type='text' name='cantidad' id='cantidad' value='$cantidad' size='4'>
Cantidad letras:<input type='text' name='cantidad_letras' id='cantidad_letras' value='$cantidad_letras'></li>
<li>Posologia<br>
<textarea name='posologia' id='posologia' cols='70' rows='5'>$posologia</textarea></li><br> 

<input type='button' onClick=\"xajax_grabar_receta(xajax.getFormValues('recetar')) \" value='Recetar' >

													";
									}
}
$nuevo_select .= "</b>";
$respuesta->addAssign("estado","innerHTML",$nuevo_select);
return $respuesta;
} 


/// fin 


///NOMBRE DE LA FUNCION: grabar_receta
// para llamar la funcion utilizar 
// onChange="xajax_dummy(xajax.getFormValues('nombre_formulario'))"
function grabar_receta($variable_array){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$no_pos = $variable_array["no_pos"];
$id_turno = $variable_array["id_turno"];
$id_especialista = $variable_array["id_especialista"];
$id_usuario = $variable_array["id_usuario"];
$id_medicamento = $variable_array["id_medicamento"];
$pos_usado = $variable_array["pos_usado"];
$pos_usado_respuesta = $variable_array["pos_usado_respuesta"];
$cantidad = $variable_array["cantidad"];
$cantidad_letras = $variable_array["cantidad_letras"];
$posologia = $variable_array["posologia"];
$tiempo_utilizacion = $variable_array["tiempo_utilizacion"];
$riesgo = $variable_array["riesgo"];
$efecto_deseado = $variable_array["efecto_deseado"];
$tiempo_respuesta = $variable_array["tiempo_respuesta"];
$efectos_secundarios = $variable_array["efectos_secundarios"];
$observaciones = $variable_array["observaciones"];
$control = microtime();
$hoy=date('Y-m-d');
list( $ano, $mes, $dia ) = split( '[-]', $hoy );
$fecha_comas = $ano.",".$mes.",".$dia;
$timestamp=mktime(0,0,0, $mes, $dia, $ano);
if($id_medicamento == ''){
$nuevo_select = "<h1><img src='images/atencion.gif' alt='!'> No se ha elegido un medicamento ! ( $id_medicamento )</h1>";
$respuesta->addAssign("estado","innerHTML",$nuevo_select);
return $respuesta;
								}
$nuevo_select ="";
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");

if ($no_pos == 'no_pos'){ 
mysql_query("INSERT INTO `recetas_no_pos` ( `id_receta_no_pos` , `timestamp` , `pos_usado` , `pos_usado_respuesta` , `cantidad` , `posologia` , `tiempo_utilizacion` , `riesgo` , `efecto_deseado` , `tiempo_respuesta` , `efectos_secundarios` , `observaciones` , `id_usuario` , `id_medicamento` , `id_especialista` , `id_turno`, `control` , `cantidad_letras`  )
VALUES (
NULL , '$timestamp', '$pos_usado', '$pos_usado_respuesta', '$cantidad', '$posologia', '$tiempo_utilizacion', '$riesgo', '$efecto_deseado', '$tiempo_respuesta', '$efectos_secundarios', '$observaciones', '$id_usuario', '$id_medicamento', '$id_especialista', '$id_turno', '$control', '$cantidad_letras'
)",$link);

mysql_query("INSERT INTO `recetas` ( `id_receta` , `timestamp` , `cantidad` ,`cantidad_letras` , `posologia` , `id_usuario` , `id_medicamento` , `id_especialista` , `id_turno`, `control` )
VALUES (
NULL , '$timestamp', '$cantidad','$cantidad_letras', '$posologia', '$id_usuario', '$id_medicamento', '$id_especialista', '$id_turno', '$control'
)",$link);

								 }
								 
								 else {
								 
mysql_query("INSERT INTO `recetas` ( `id_receta` , `timestamp` , `cantidad` ,`cantidad_letras` , `posologia` , `id_usuario` , `id_medicamento` , `id_especialista` , `id_turno`, `control` )
VALUES (
NULL , '$timestamp', '$cantidad','$cantidad_letras', '$posologia', '$id_usuario', '$id_medicamento', '$id_especialista', '$id_turno', '$control'
)",$link);
								 
								 }



$nuevo_select .= "<h2>Medicamentos formulados en esta consulta</h2><ol>";


$sql=mysql_query("SELECT medicamentos.medicamento_nombre, medicamentos.concentracion_forma, recetas.cantidad, recetas.posologia FROM recetas, medicamentos WHERE recetas.id_turno = '$id_turno' AND recetas.id_medicamento = medicamentos.id_medicamento",$link);


while( $row = mysql_fetch_array( $sql ) ) {
$nuevo_select .= "<li>".$row['medicamento_nombre']." ".$row['concentracion_forma'].": ".$row['cantidad']." ".$row['posologia']."</li>";
}
$nuevo_select .= "</ol>";
$respuesta->addAssign("estado","innerHTML",$nuevo_select);
return $respuesta;
} 

/// fin 


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
$hoy=date('Y-m-d');
list( $ano, $mes, $dia ) = split( '[-]', $hoy );
$fecha_comas = $ano.",".$mes.",".$dia;
$timestamp=mktime(0,0,0, $mes, $dia, $ano);
$link=conectarse();
mysql_query("SET NAMES 'utf8'");
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
mysql_query("
INSERT INTO `consulta_datos` ( `id_consulta_datos` , `id_campo` , `id_especialista` , `id_usuario` , `contenido` , `timestamp` , `id_turno` )
VALUES (NULL , '$campo', '$id_especialista', '$id_usuario', '$contenido', '$timestamp', '$id_turno')",$link);
$nuevo_select .= "$campo --- $contenido <br>";
										}
															}	
	
	

	}	
		$nuevo_select .= "<h1>La consulta fu&eacute; guardada</h1>
		
		<a href=?page=plan&id_turno=$id_turno>Recetar</a>
							"; 
		
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

///campos_consulta
function campos_consulta($area,$titulo,$especialista){

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

		<div name='$titulo"."_".$especialista."' id='$titulo"."_".$especialista."' style='border: 1px solid #$color; ' >
		<div  class='cabecera'><li>$titulo </li> </div>
		<hr><h1>$titulo </h1><ol>
											";

while( $row = mysql_fetch_array( $campos ) ) {

///prellenado
$campo_consulta = $row['id_consulta_campo'];
global $id_usuario; 
$campos_datos= mysql_query("
  		SELECT id_campo, contenido
		FROM `consulta_datos` 
		WHERE id_usuario = '$id_usuario'
		AND id_campo= $campo_consulta
		ORDER BY timestamp DESC LIMIT  1",$link);

while( $row_contenido = mysql_fetch_array( $campos_datos ) ) {
$contenido=$row_contenido['contenido'];
																	
																					}
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

$campos_formulario .="</ol></div>";
echo $campos_formulario;
												
} 



///fin campos_consulta

///CAMPOS CONSULTA DINAMICO

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
		<hr><h1>$titulo </h1><ol>
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

while( $row_contenido = mysql_fetch_array( $campos_datos ) ) {
$contenido=$row_contenido['contenido'];
																
																					}
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





/// FIN CAMPOS CONSULTA DINAMICO
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


///NOMBRE DE LA FUNCION: 
// para llamar la funcion utilizar 
// onChange="xajax_dummy(xajax.getFormValues('nombre_formulario'))"
function autorizar_consulta($variable_array){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$id_turno = $variable_array["id_turno"];
$funcionario=$_SESSION['id_usuario'];
$tipo = $variable_array["tipo"];
$recibo = $variable_array["recibo"];
$excedente = $variable_array["excedente"];
$cancelacion = $variable_array["cancelacion"];
$cancelacion_motivo = $variable_array["cancelacion_motivo"];
$ahora=time();
$nuevo_select = "<div class='capa-centrada'  ><center><a  onclick='desbloquea();'>[<font color='red'>x</font>] Cerrar</a> $tipo</center><hr>";
$link=Conectarse(); 
if($cancelacion=='1'){ $estado="3"; $cancela=", timestamp_cancelacion='$ahora', id_cancelacion='$funcionario' ,cancelacion_motivo='$cancelacion_motivo' ";}else {$estado="2";}
if($tipo == 'autorizar'){
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
					
					$nuevo_select .= "<h1>La consulta fu&eacute; autorizada</h1></div>";
$respuesta->addAssign("popup","innerHTML",$nuevo_select);
return $respuesta;

								}

$sql=mysql_query("SELECT *,  (

SELECT nombre_completo
FROM d9_users
WHERE turnos.especialista = d9_users.id
) AS nombre_especialista
  							FROM turnos, d9_users 
  							WHERE  turnos.id_turno = '$id_turno' 
  							AND turnos.id_usuario = d9_users.id
  							
  							",$link);  

while( $row = mysql_fetch_array($sql) ) {
$nuevo_select .= "<form name='autorizar' id='autorizar'>
						<b>Usuario: </b>" . $row['nombre_completo'] . "<br><b>Especialista: </b>" . $row['nombre_especialista'] . "
						<br><b>Valor adicional: </b>$ <input type='text' id='excedente' name='excedente' size='40' value='".$row['excedente']."' title='Se refiere a coopago o cuota moderadora'>	
						<br><b>Recibo o boleta: </b><input type='text' id='recibo' name='recibo' size='40' value='" . $row['recibo'] . "' title='Numero de soporte para hacer el cobro a la aseguradora'>	
						<hr><font color='red'><b>Cancelada: </b><input name='cancelacion' value='1' type='checkbox'><b>Motivo: </b><input type='text' id='cancelacion_motivo' name='cancelacion_motivo' size='40' title='Si la cita fue cancelada, escriba el motivo'>	</font>
						<hr><center>
						<input type='hidden' value='autorizar' name='tipo' id='tipo'>	
						<input type='hidden' value='$id_turno' name='id_turno' id='id_turno'>						
						<input type='button' value=' Aceptar ' onClick=\"xajax_autorizar_consulta(xajax.getFormValues('autorizar'));\"></form></center>
						"; 
														}

$nuevo_select .= "</div>";


$respuesta->addAssign("popup","innerHTML",$nuevo_select);
return $respuesta;
} 

/// FIN DE LA FUNCION dummy

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
$execdente=$variable_array['excedente']; 
$ahora=time();
if ($id_evento == ''){

$alerta="No se ha elegido un tipo de evento o consulta";
$nuevo_select = "<center title='$alerta'><h1>$alerta</h1><br><img src='images/atencion.gif' alt='!'></center>";
														
$respuesta->addAssign("asignacion_turnos","innerHTML",$nuevo_select);
return $respuesta;
							}
if ($id_turno != ''){
//include_once("librerias/conex.php"); 
$link=Conectarse(); 

$nuevo_select = "<h1>$Valor</h1>";
 mysql_query("
 	update 
 		turnos  
 	set 
		id_usuario='$id_usuario', 
		estado='1',
		id_ocupacion='$funcionario', 
		observaciones='$observaciones', 
		recibo='$recibo' ,
		id_evento='$id_evento' ,
		id_cliente='$id_cliente', 
		excedente='$excedente' ,		timestamp_ocupacion='$ahora' ,		id_usuario='$id_usuario' 
	where 
		id_turno='$id_turno'
					"); 
$sql=mysql_query("SELECT fecha, hora_inicio, nombre_completo 
						FROM turnos, d9_users 
						WHERE id_turno = '$id_turno'
						AND turnos.especialista=d9_users.id						
						",$link);
while( $row = mysql_fetch_array( $sql ) ) {
$nuevo_select .= '<h1>La cita quedo asignada para el ' . $row['fecha'] . ' a las ' . $row['hora_inicio'] . '<br>Con el especialista '. $row['nombre_completo'] .'</h1><br>';
														}
}
														else
														{
														$alerta="No se ha elegido un turno v&aacute;lido";
$nuevo_select = "<center title='$alerta'><h1>$alerta</h1><br><img src='images/atencion.gif' alt='!'></center>";
														}
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

mysql_query("insert into `turnos` (`fecha`, `timestamp`,`timestamp_inicio`,`timestamp_fin`, `hora_inicio`, `hora_fin`, `especialista`) 
  values ('$fecha','$timestamp','$timestamp_inicio','$timestamp_fin','$i_hora:$i_minutos','$f_hora:$f_minutos','$especialista')",$link);     

	
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

        $resultado = $dias[$ww]." ".$ddia." ".$meses[$mmes-1]." de ".$aano;

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
		<table border='0' align='center' title='Si no desea alguno, por favor haga click en la casilla'> 
			<tr>
				<td> </td>
				<td>Hora</td>
				<td><center>Duraci&oacute;n</center></td>
				<td>(x)</td>
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
				
				<a OnClick=\"xajax_turnos_grabar(xajax.getFormValues('turnos_crear'))\">[ Confirmar ]</a>
				</form>
</td></tr>
";

}//fin de el control de especialista 	
$respuesta->addAssign("turnos_revisar","innerHTML",$nuevo_select);

return $respuesta;



} 

/// FIN DE LA FUNCION turnos_procesar

///NOMBRE DE LA FUNCION: terceros_modificar
function terceros_modificar($variable_array){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$id_cliente = $variable_array["id_cliente"];
$codigo=$variable_array['codigo'];
$razon_social=$variable_array['razon_social'];
$alias=$variable_array['alias'];
$objeto_contrato=$variable_array['objeto_contrato'];
$contacto_general=$variable_array['contacto_general'];
$contacto_medico=$variable_array['contacto_medico'];
$contacto_administrativo=$variable_array['contacto_administrativo'];
$telefono=$variable_array['telefono'];
$email=$variable_array['e_mail'];
$tarifario=$variable_array['tarifario'];
$tarifario_diferencia=$variable_array['tarifario_diferencia'];
$suma=$variable_array['suma'];
$activo=$variable_array['activo'];
$grupo=$variable_array['grupo'];
$link=Conectarse(); 
$tabla=mysql_query("SELECT tabla FROM usuarios_grupo WHERE id_grupo = $grupo ",$link);
$tabla=mysql_result($tabla,0,"tabla");

if ($grupo=='6'){
mysql_query("UPDATE `$tabla` SET
`codigo` = '$codigo',
`razon_social` = '$razon_social',
`alias` = '$alias',
`objeto_contrato` = '$objeto_contrato',
`contacto_general` = '$contacto_general',
`contacto_medico` = '$contacto_medico',
`contacto_administrativo` = '$contacto_administrativo',
`telefono` = '$telefono',
`tarifario` = '$tarifario',
`tarifario_diferencia` = '$tarifario_diferencia',
`suma` = '$suma',
`activo` = '$activo',
`email` = '$email'
WHERE `id_cliente` ='$id_cliente' LIMIT 1",$link);
 }

if ($grupo=='3'){
$id_especialista=$variable_array['id_especialista'];
$registro_medico=$variable_array['registro_medico'];
$especialidad=$variable_array['especialidad'];
$universidad_especializacion=$variable_array['universidad_especializacion']; 
$cargo=$variable_array['cargo'];  
$universidad_pregrado=$variable_array['universidad_pregrado'];
$objeto_contrato=$variable_array['objeto_contrato'];
$slogan=$variable_array['slogan'];
$color=$variable_array['color'];
$fecha_vinculacion=$variable_array['fecha_vinculacion'];
$fecha_vencimiento=$variable_array['fecha_vencimiento'];
$activo=$variable_array['activo'];

mysql_query("UPDATE `especialistas` SET
`registro_medico` = '$registro_medico',
`especialidad` = '$especialidad',
`universidad_especializacion` = '$universidad_especializacion',
`objeto_contrato` = '$objeto_contrato',
`cargo` = '$cargo',
`universidad_pregrado` = '$universidad_pregrado',
`slogan` = '$slogan',
`color` = '$color',
`fecha_vinculacion` = '$fecha_vinculacion',
`fecha_vencimiento` = '$fecha_vencimiento',
`activo` = '$activo'

WHERE `id_especialista` ='$id_especialista' LIMIT 1",$link);
}


$nuevo_select = "<h1>Modificado : $alias</h1>";
//while( $row = mysql_fetch_array( $sql ) ) {
//$nuevo_select .= '' . $row['id'] . '">' . $row['nombre_completo'] . '<br>';
//}

$respuesta->addAssign("terceros","innerHTML",$nuevo_select);
return $respuesta;



} 

/// FIN DE LA FUNCION terceros_modificar


///NOMBRE DE LA FUNCION: terceros
function terceros($variable_array){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$Valor = $variable_array["id"];
$grupo = $variable_array["grupo"];
$link=Conectarse(); 
$tabla=mysql_query("SELECT tabla FROM usuarios_grupo WHERE id_grupo = $grupo ",$link);
$tabla=mysql_result($tabla,0,"tabla");
$nuevo_select = "";
if ($Valor > 0){
$sql=mysql_query("SELECT * FROM $tabla WHERE id = $Valor ",$link);
if (mysql_num_rows($sql)==0){
$insertar=mysql_query("INSERT INTO `$tabla` (  `id` ) VALUES ( '$Valor')",$link); 
$sql=mysql_query("SELECT * FROM $tabla WHERE id = $Valor ",$link);
}
/// comienzo de la rutina de clientes
//si el grupo es cliente siga con esto
if ($grupo=='6'){


while( $row = mysql_fetch_array( $sql ) ) {
$codigo=$row['codigo'];
$id_cliente=$row['id_cliente'];
$razon_social=$row['razon_social'];
$alias=$row['alias']; 
$objeto_contrato=$row['objeto_contrato'];
$contacto_general=$row['contacto_general'];
$contacto_medico=$row['contacto_medico'];
$contacto_administrativo=$row['contacto_administrativo'];
$telefono=$row['telefono'];
$email=$row['email'];
$tarifario_diferencia=$row['tarifario_diferencia'];
$tarifario=$row['tarifario'];
$suma=$row['suma'];
$activo=$row['activo'];

}
$nuevo_select .= "
<form name='tercero_modificar' id='tercero_modificar'>
<input name='id_cliente' id='id_cliente'  type='hidden' value='$id_cliente' >
<input name='grupo' id='grupo'  type='hidden' value='$grupo' >
<hr><table border=0 width='80%' align='center'>

 <tr>
  		<td width='30%'> <div align='right'>Codigo</div></td>

  		<td>
  		<input name='codigo' id='codigo' size='30' maxlength='255' type='text' value='$codigo' title='Codigo o registro que saldra en RIPS de la entidad'>
		<select name='activo' title='Marcar si se encuentra activa la negociacion con la entidad'>";
if ($activo == "0")$nuevo_select .="<option value='0' selected >> Inactivo <</option>";
if ($activo == "1")$nuevo_select .="<option value='1' selected >> Activo <</option>";

if ($activo == "")$nuevo_select .="<option value='0' selected >> Inactivo <</option>";
$nuevo_select .="
		<option value='0'>Inativo</option>
		<option value='1'>Activo</option>		
		</select>  		
  		
  		</td> 
  	</tr>
	<tr>
		<td width='30%'> <div align='right'>Razon Social</div></td>
		<td><input name='razon_social' id='razon_social' size='60' maxlength='255' type='text' value='$razon_social' title='Nombre general con que se conoce la entidad' ></td> 
	</tr>
	<tr>
		<td width='30%'> <div align='right'>Alias</div></td>

		<td><input name='alias' id='alias' size='60' maxlength='255' type='text' value='$alias' title='Division o subempresa a nombre de quien se facturara y/o generaran los RIPS'></td>  
	</tr>
	<tr>
		<td width='30%'> <div align='right'>Objeto del Contrato</div></td>
		<td><textarea id='objeto_contrato' name='objeto_contrato' rows='5' cols='60' title='Pegar aqui el objeto de contrato para tenerlo como referencia'>$objeto_contrato</textarea></td> 
	</tr>

<tr><td width='30%'> <div align='right'>Contacto General</div></td><td><input name='contacto_general' id='contacto_general' size='60' maxlength='255' type='text' value='$contacto_general' title='Personal con quien se tiene contacto en la entidad' ></td> </tr>
<tr><td width='30%'> <div align='right'>Contacto Medico</div></td><td><input name='contacto_medico' id='contacto_medico' size='60' maxlength='255' type='text' value='$contacto_medico' title='Personal medico con quien se tiene contacto en la entidad' ></td> </tr>
<tr><td width='30%'> <div align='right'>Contacto Administrativo</div></td><td><input name='contacto_administrativo' id='contacto_administrativo' size='60' maxlength='255' type='text' value='$contacto_administrativo' title='Personal administrativo con quien se tiene contacto en la entidad' ></td> </tr>
<tr><td width='30%'> <div align='right'>Telefono</div></td><td><input name='telefono' id='telefono' size='30' maxlength='60' type='text' value='$telefono' title='Telefono oficial de contacto'></td> </tr>
<tr><td width='30%'> <div align='right'>E Mail</div></td><td><input name='e_mail' value='$email' id='e_mail' size='60' maxlength='60' type='text' title='Email oficial de la entidad'></td> </tr>
<tr><td width='30%'></td><td><select name='tarifario' title='Tarifas negociada con esa entidad'>";

if ($tarifario != "0"){$Tarifa_definido=mysql_query("SELECT * FROM tarifas WHERE id_tarifa = $tarifario LIMIT 1" ,$link); 
$tarifa_definido=mysql_result($Tarifa_definido,0,"tarifa_nombre");  
$id_tarifa_definido=mysql_result($Tarifa_definido,0,"id_tarifa");  
$nuevo_select .="<option value='$id_tarifa_definido' selected >>$tarifa_definido<</option>";}else
{ $nuevo_select .="<option value='' selected >Elija una tarifa</option>";}
$Tarifas=mysql_query("SELECT * FROM tarifas",$link);   
while( $row = mysql_fetch_array( $Tarifas ) ) {
$nuevo_select .="<option value='".$row['id_tarifa']."'>".$row['tarifa_nombre']."</option>";

}
$nuevo_select .="</select><select name='suma' id='suma' title='Diferencia entre el tarifario elegido y el cobro, puede ser: Mas, Menos o Igual'>";
if ($suma == "")$nuevo_select .="<option value='' selected >> Diferencia <</option>";
if ($suma == "=")$nuevo_select .="<option value='=' selected >> Igual <</option>";
if ($suma == "+")$nuevo_select .="<option value='+' selected >> Mas <</option>";
if ($suma == "-")$nuevo_select .="<option value='-' selected >> Menos <</option>";
$nuevo_select .="<option value='='>Igual</option><option value='+'>Mas </option><option value='-'>Menos</option></select>

 <input name='tarifario_diferencia' value='$tarifario_diferencia' id='tarifario_diferencia' size='3' maxlength='3' type='text' title='Puntos de diferencia en porcentaje entre el tarifario elegido y el valor a cobrar'>% </td> </tr>
<tr><td width='30%' colspan='2'><div align='center'><a OnClick=\"xajax_terceros_modificar(xajax.getFormValues('tercero_modificar'))\" title='Pulse una vez para guardar los cambio'>[ Modificar ]</a></center></td> </tr>



</table>
";

}else {}

}/// fin de la rutina de clientes
if ($grupo=='3')
{ /// si el grupo es especialista
while( $row = mysql_fetch_array( $sql ) ) {
$id_especialista=$row['id_especialista'];
$registro_medico=$row['registro_medico'];
$especialidad=$row['especialidad'];
$universidad_especializacion=$row['universidad_especializacion']; 
$cargo=$row['cargo'];  
$universidad_pregrado=$row['universidad_pregrado']; 
$objeto_contrato=$row['objeto_contrato'];
$slogan=$row['slogan'];
$color=$row['color'];
$fecha_vinculacion=$row['fecha_vinculacion'];
$fecha_vencimiento=$row['fecha_vencimiento'];
$activo=$row['activo'];

}

$nuevo_select .= "
 
<form name='tercero_modificar' id='tercero_modificar'>
<input name='id_especialista' id='id_especialista'  type='hidden' value='$id_especialista' >
<input name='grupo' id='grupo'  type='hidden' value='$grupo' >
<hr><table border=0 width='80%' align='center'>

 <tr>
  		<td width='30%'></td>

  		<td>
  		<select name='activo' title='Marcar si se encuentra activo'>";
if ($activo == "0")$nuevo_select .="<option value='0' selected >> Inactivo <</option>";
if ($activo == "1")$nuevo_select .="<option value='1' selected >> Activo <</option>";

if ($activo == "")$nuevo_select .="<option value='0' selected >> Inactivo <</option>";
$nuevo_select .="
		<option value='0'>Inativo</option>
		<option value='1'>Activo</option>		
		</select>  		
  		
  		</td> 
  	</tr>
	<tr>
		<td width='30%'> <div align='right'>Registro m&eacute;dico: </div></td>
		<td><input name='registro_medico' id='registro_medico' size='60' maxlength='255' type='text' value='$registro_medico' title='Registro medico' ></td> 
	</tr>
	<tr>
		<td width='30%'><div align='right'>Universidad Pregrado: </div></td>
		<td><input name='universidad_pregrado' id='universidad_pregrado' size='60'
		 maxlength='255' type='text' value='$universidad_pregrado' title='universidad_pregrado' ></td> 
	</tr>
	<tr>
		<td width='30%'><div align='right'>Especialidad: </div></td>
		<td><input name='especialidad' id='especialidad' size='60'
		 maxlength='255' type='text' value='$especialidad' title='especialidad' ></td> 
	</tr>
	<tr>
		<td width='30%'><div align='right'>Universidad Especializaci&oacute;n: </div></td>
		<td><input name='universidad_especializacion' id='universidad_especializacion' size='60'
		 maxlength='255' type='text' value='$universidad_especializacion' title='universidad_especializacion' ></td> 
	</tr>
	<tr>
		<td width='30%'><div align='right'> Cargo: </div></td>
		<td><input name='cargo' id='cargo' size='60'
		 maxlength='255' type='text' value='$cargo' title='Cargo' ></td> 
	</tr>
	<tr>
		<td width='30%'><div align='right'> Slogan: </div></td>
		<td><textarea name='slogan' id='slogan' cols='60' rows='3'
		 maxlength='255'  title='Slogan' >$slogan</textarea></td> 
	</tr>
	<tr>
		<td width='30%'> <div align='right'>Objeto del Contrato</div></td>
		<td><textarea id='objeto_contrato' name='objeto_contrato' rows='5' cols='60' title='Pegar aqui el objeto de contrato para tenerlo como referencia'>$objeto_contrato</textarea></td> 
	</tr>
	<tr>

		<td width='30%' ><div align='right'> Color: </div></td>
		<td id='colorin' name='colorin' bgColor='$color' title='Con este color el usuario se identifica en el sistema'><input name='color' id='color' size='12'
		 maxlength='12' type='text' value='$color' onclick=\"lanzarSubmenu() ; modificarElemento()\">
		 <a onclick=\"modificarElemento()\" > Probar </a>

		 </td> <td  width='30%'></td>
	</tr>
	<tr>
		<td width='30%'><div align='right'> </div></td>
		<td>Fecha vinculaci&oacute;n: <input size='10' id='fc_1213927245' type='text' name='fecha_vinculacion' title='YYYY-MM-DD' onClick=\"displayCalendar(this);\" value='$fecha_vinculacion'>
		 Vencimiento: <input size='10' id='fc_1213927246' type='text' name='fecha_vencimiento' title='YYYY-MM-DD' onClick=\"displayCalendar(this);\" value='$fecha_vencimiento'></td> 
	</tr>
	<tr><td width='30%' colspan='2'><div align='center'><a OnClick=\"xajax_terceros_modificar(xajax.getFormValues('tercero_modificar'))\" title='Pulse una vez para guardar los cambio'>[ Modificar ]</a></center></td> </tr>
	";

}
$respuesta->addAssign("terceros","innerHTML",$nuevo_select);
return $respuesta;

} 

/// FIN DE LA FUNCION terceros

///usuario_datos
function usuario_datos_dinamico($variable_array){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$documento = $variable_array["documento"];

$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");

$Usuario_Datos=mysql_query("SELECT * FROM d9_users  WHERE  (documento_numero =  '$documento')",$link); 
$num=mysql_num_rows($Usuario_Datos);
if (mysql_num_rows($Usuario_Datos)!=0){
$i=0;
$id=mysql_result($Usuario_Datos,$i,"id");  
$id_grupo=mysql_result($Usuario_Datos,$i,"id_grupo");   
$documento_numero=mysql_result($Usuario_Datos,$i,"documento_numero");      
$nombre_completo=mysql_result($Usuario_Datos,$i,"nombre_completo");      
$p_apellido=mysql_result($Usuario_Datos,$i,"p_apellido");
$s_apellido=mysql_result($Usuario_Datos,$i,"s_apellido"); 
$s_nombre=mysql_result($Usuario_Datos,$i,"s_nombre"); 
$p_nombre=mysql_result($Usuario_Datos,$i,"p_nombre");  
$documento_tipo=mysql_result($Usuario_Datos,$i,"documento_tipo"); 
$estado_civil=mysql_result($Usuario_Datos,$i,"estado_civil"); 
$genero=mysql_result($Usuario_Datos,$i,"genero");  
$fecha_nacimiento=mysql_result($Usuario_Datos,$i,"fecha_nacimiento");  
$email=mysql_result($Usuario_Datos,$i,"email");  
$direccion=mysql_result($Usuario_Datos,$i,"direccion");   
$barrio=mysql_result($Usuario_Datos,$i,"barrio");   
$estrato=mysql_result($Usuario_Datos,$i,"estrato");   
$departamento=mysql_result($Usuario_Datos,$i,"departamento");   
$ciudad=mysql_result($Usuario_Datos,$i,"ciudad");      
$ciudad_extranjero=mysql_result($Usuario_Datos,$i,"ciudad_extranjero");   
$pais=mysql_result($Usuario_Datos,$i,"pais");   
$estado=mysql_result($Usuario_Datos,$i,"estado");   
$genero=mysql_result($Usuario_Datos,$i,"genero");   
$estado_civil=mysql_result($Usuario_Datos,$i,"estado_civil");   
$escolaridad=mysql_result($Usuario_Datos,$i,"escolaridad");    
$titulo_profesional=mysql_result($Usuario_Datos,$i,"titulo_profesional");   
$ocupacion=mysql_result($Usuario_Datos,$i,"ocupacion");   
$empresa=mysql_result($Usuario_Datos,$i,"empresa");  
$cargo=mysql_result($Usuario_Datos,$i,"cargo");   
$telefono_fijo=mysql_result($Usuario_Datos,$i,"telefono_fijo");  
$telefono_fijo_1=mysql_result($Usuario_Datos,$i,"telefono_fijo_1");  
$fax=mysql_result($Usuario_Datos,$i,"fax");  
$web=mysql_result($Usuario_Datos,$i,"web");   
$telefono_celular=mysql_result($Usuario_Datos,$i,"telefono_celular");  
$telefono_VoIP=mysql_result($Usuario_Datos,$i,"telefono_VoIP");   
$presentacion=mysql_result($Usuario_Datos,$i,"presentacion");  
$activos=mysql_result($Usuario_Datos,$i,"activos");

if ($fecha_nacimiento == "0000-00-00"){
$ano = "";
$mes = "";
$dia = "";
}
else {
$letras=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

$fecha_nacimiento = strtotime($fecha_nacimiento);
$ano = date("Y", $fecha_nacimiento);
$mes = date("m", $fecha_nacimiento);
$dia = date("d", $fecha_nacimiento);
$mes_letras = date("n", $fecha_nacimiento);
$mes_letras = $letras[$mes_letras];
}
$nuevo_select = "<a HREF=\"javascript:abrir('suscriptores/presentacion/editar_usuario.php?id=$id','editar_usuario',600,600,300,0,1)\" TITLE='Clic AQUI para editar el Usuario'><h1> ID: [$id] $nombre_completo</h1><h1>$direccion $barrio $ciudad $ciudad_extranjero $estado $departamento $pais </h1></A>";
//echo $nuevo_select;
if ($_SESSION['grupo'] == "2"){}
else{
$nuevo_select .= $ID; 
$nuevo_select .= "<a HREF=\"javascript:abrir('suscriptores/presentacion/enviar_correo.php?id=$id&id_remitente=$id_remitente','enviar_correo',600,300,100,0,1)\" TITLE='Clic AQUI en contactar usuario'><p>Enviar correo a usuario</p></a>";
//echo $nuevo_select;
 

}
}

$respuesta->addAssign("usuarios","innerHTML",$nuevo_select);
return $respuesta;



} 


/// GUARDAR DIGITACION
function guardar_digitacion($variable_array){ 
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$Gid_usuario_temporal = $variable_array["id_usuario_temporal"];
$Gdocumento_tipo = $variable_array["documento_tipo"];
$Gprimer_nombre = $variable_array["primer_nombre"];
$Gsegundo_nombre = $variable_array["segundo_nombre"];
$Gprimer_apellido = $variable_array["primer_apellido"];
$Gsegundo_apellido = $variable_array["segundo_apellido"];
$Gmail_username = $variable_array["mail_username"];
$Gmail_servidor = $variable_array["mail_servidor"];
$Gmail_dominio = $variable_array["mail_dominio"];
//geograficos
$Gcod_pais = $variable_array["cod_pais"];
$Gcodigo_departamento = $variable_array["cod_departamento"];
$Gid_ciudad = $variable_array["id_municipio"];
$Gid_geo_tipo_via = $variable_array["id_geo_tipo_via_digitacion"];
$Gid_geo_numero_01_datos_geograficos = $variable_array["id_geo_numero_01_digitacion"];
$Gid_geo_numero_02_datos_geograficos = $variable_array["id_geo_numero_02_digitacion"];
$Gid_geo_numero_03_datos_geograficos = $variable_array["id_geo_numero_03_digitacion"];
$Gletra_01_datos_geograficos = $variable_array["letra_01_digitacion"];
$Gletra_02_datos_geograficos = $variable_array["letra_02_digitacion"];
$Ggeo_separador_datos_geograficos = $variable_array["geo_separador_digitacion"];
$Gid_geo_hito_01_datos_geograficos = $variable_array["id_geo_hito_01_digitacion"];
$Gdescripcion_geo_hito_01_datos_geografico = $variable_array["hito_01_digitacion"];
$Gid_geo_hito_02_datos_geograficos = $variable_array["id_geo_hito_02_digitacion"];
$Gdescripcion_geo_hito_02_datos_geografico = $variable_array["hito_02_digitacion"];
$Gid_geo_hito_03_datos_geograficos = $variable_array["id_geo_hito_03_digitacion"];
$Gdescripcion_geo_hito_03_datos_geografico = $variable_array["hito_03_digitacion"];
$Gorientacion_01_datos_geografico= $variable_array["orientacion_01"];
$Gorientacion_02_datos_geografico= $variable_array["orientacion_02"];
$Gid_geo_hito_04_datos_geograficos = $variable_array["id_geo_hito_04_digitacion"];
$Gdescripcion_geo_hito_04_datos_geografico = $variable_array["hito_04_digitacion"];

$Gid_usuario=$_SESSION["id_usuario"];

include_once("librerias/conex.php"); 
$link=Conectarse(); 



mysql_query("UPDATE `usuarios_temporal` SET
`primer_nombre` = '$Gprimer_nombre',
`segundo_nombre` = '$Gsegundo_nombre',
`primer_apellido` = '$Gprimer_apellido',
`segundo_apellido` = '$Gsegundo_apellido',
`mail_username` = '$Gmail_username',
`mail_servidor` = '$Gmail_servidor',
`mail_dominio` = '$Gmail_dominio',
`digitado` = '1',
`genero` = '$Ggenero',
`digitado_por` = '$Gid_usuario',
`digitado_fecha` = NOW( ) 
WHERE `usuarios_temporal`.`id_usuario_temporal` ='$Gid_usuario_temporal' LIMIT 1",$link);

mysql_query("INSERT INTO `datos_geograficos` (
`id_datos_geograficos` ,
`id` ,
`cod_pais` ,
`codigo_departamento` ,
`id_ciudad` ,
`id_geo_tipo_dato_geografico` ,
`id_geo_tipo_via` ,
`id_geo_numero_01_datos_geograficos` ,
`id_geo_numero_02_datos_geograficos` ,
`id_geo_numero_03_datos_geograficos` ,
`letra_01_datos_geograficos` ,
`letra_02_datos_geograficos` ,
`geo_separador_datos_geograficos` ,
`id_geo_hito_01_datos_geograficos` ,
`descripcion_geo_hito_01_datos_geografico` ,
`id_geo_hito_02_datos_geograficos` ,
`descripcion_geo_hito_02_datos_geografico` ,
`id_geo_hito_03_datos_geograficos` ,
`descripcion_geo_hito_03_datos_geografico` ,
`orientacion_01` ,
`orientacion_02` ,
`id_geo_hito_04_datos_geograficos` ,
`descripcion_geo_hito_04_datos_geografico`,
`digitador`
)
VALUES (
NULL, '$Gid_usuario_temporal' ,
'$Gcod_pais' ,
'$Gcodigo_departamento' ,
'$Gid_ciudad' ,
'1' ,
'$Gid_geo_tipo_via' ,
'$Gid_geo_numero_01_datos_geograficos' ,
'$Gid_geo_numero_02_datos_geograficos' ,
'$Gid_geo_numero_03_datos_geograficos' ,
'$Gletra_01_datos_geograficos' ,
'$Gletra_02_datos_geograficos' ,
'$Ggeo_separador_datos_geograficos' ,
'$Gid_geo_hito_01_datos_geograficos' ,
'$Gdescripcion_geo_hito_01_datos_geografico' ,
'$Gid_geo_hito_02_datos_geograficos' ,
'$Gdescripcion_geo_hito_02_datos_geografico' ,
'$Gid_geo_hito_03_datos_geograficos' ,
'$Gdescripcion_geo_hito_03_datos_geografico' ,
'$Gorientacion_01_datos_geografico' ,
'$Gorientacion_02_datos_geografico' ,
'$Gid_geo_hito_04_datos_geograficos' ,
'$Gdescripcion_geo_hito_04_datos_geografico',
'$Gid_usuario'
 )",$link);
//while( $row = mysql_fetch_array( $sql ) ) {
//$nuevo_select .= '' . $row['id'] . '">' . $row['nombre_completo'] . '<br>';
//}

$nuevo_select .= "<ul>
<li><font color='green'>Documento: </font>$documento_numero 
<font color='green'>Nombre:</font> $nombre 
<li><font color='green'>Direcci&oacute;n </font>$direccion
<font color='green'>Barrio:</font> $barrio 
 <font color='green'>Ciudad:</font> $ciudad  
<font color='green'>Pais:</font> $pais </li>
<li><font color='green'>Email:</font> $email</ul>";
$nuevo_select .= "";
$respuesta->addAssign("capadigitacion","innerHTML",$nuevo_select);
return $respuesta;



} 

/// FIN GUARDAR DIGITACION

//// SERVICIO AL CLIENTE
function servicio_cliente($variable_array){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$Valor = $variable_array["id_servicio_cliente"];
$ID = $variable_array["id"];
$funcionario=$_SESSION["id_usuario"];
$fecha_sistema=date('Y-m-d H:i:s');

//include_once("librerias/conex.php"); 
$link=Conectarse(); 

$sql=mysql_query("
UPDATE `servicio_cliente` 
SET `cerrado` = '1' ,
 `cerrado_por` = '$funcionario' ,
  `fecha_cierre` = '$fecha_sistema' 


WHERE `servicio_cliente`.`id_servicio_cliente` =$Valor LIMIT 1 ;",$link); 

$listado_reportes=mysql_query("

SELECT fecha_inicio, asunto, descripcion,nombre_completo , id_servicio_cliente
FROM `servicio_cliente` ,`d9_users` 
WHERE  servicio_cliente.id = $ID 
AND servicio_cliente.cerrado != '1'
AND d9_users.id = funcionario
ORDER BY fecha_inicio DESC",$link);
$nuevo_select = "";
if (mysql_num_rows($listado_reportes)!=0)	{
$nuevo_select .=  "<h2>Mensajes o reportes pendientes</h2>";
$nuevo_select .=  "<table align=center border=0 title='Reportes de servicio al cliente'>";
$nuevo_select .= "<td align=center>Fecha</td>";
$nuevo_select .=  "<td align=center>Asunto</td>";
$nuevo_select .=  "<td  align=right>Descripci&oacute;n</td>
<td  align=center>Funcionario</td><td  align=center>Acci&oacute;n</td>
</tr><tr>";

while($salida = mysql_fetch_array($listado_reportes)){

       for ($i=0;$i<5;$i++){


        if($i!=4){       

$nuevo_select .=  "<td  bgcolor='#fde0ac'><font size=-2>".$salida[$i]."</font></td>";
        				}else{
$nuevo_select .=  "<td bgcolor='#fde0ac'>
        			<a HREF=\"javascript:abrir('suscriptores/presentacion/enviar_correo.php?id=$ID&responder=$salida[id_servicio_cliente]','enviar_correo',600,300,100,0,1)\" TITLE='Responder'><p>Responder</p></a>
       
        <form id='mensaje' name='mensaje'><center>
        <input type='hidden' name='id_servicio_cliente' value='$salida[id_servicio_cliente]'>
        <input type='hidden' name='id' value='$ID'>
      <input  value='(X)' onclick=\"xajax_servicio_cliente(xajax.getFormValues('mensaje'))\" type='button' title='Marcar como leido'></form></center></td></tr>";
    							}
        							}   
																		}
$nuevo_select .=  "</tr>
</table>";

 }else{}																		




//while( $row = mysql_fetch_array( $sql ) ) {
//$nuevo_select .= '' . $row['id'] . '">' . $row['nombre_completo'] . '<br>';
//}

$respuesta->addAssign("servicio_cliente","innerHTML",$nuevo_select);
return $respuesta;



} 
//// SERVICIO AL CLIENTE FIN


///FUNCION PARA EL MUNDO


function generar_select2($formulario){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$FORM = $formulario["formulario"];
$pais = $formulario["cod_pais"];
include_once("librerias/conex.php"); 
$conn=Conectarse(); 
mysql_query ("SET NAMES 'utf8'");
if ($pais != "COL"){
$nuevo_select .= "$link<select name='distrito_ciudad' id='distrito_ciudad' onchange=\"xajax_ciudades(xajax.getFormValues('formulario'))\">"; 	
	
$ssql = "SELECT * FROM geo_ciudad WHERE  cod_pais = '$pais' GROUP BY distrito_ciudad "; 
$rs = mysql_query($ssql,$conn);

while( $row = mysql_fetch_array( $rs ) ) {
$nuevo_select .= '<option value="'.$row['distrito_ciudad'].'">' . $row['distrito_ciudad'] . '</option>/n';

}

$nuevo_select .= "</select>";
						}	ELSE {
			
$nuevo_select .= "<select name='cod_departamento' id='cod_departamento' onchange=\"xajax_municipios(xajax.getFormValues('formulario'))\">"; 	
$ssql = "SELECT * FROM geo_municipios_colombia GROUP by codigo_departamento"; 
$rs = mysql_query($ssql,$conn);
while( $row = mysql_fetch_array( $rs ) ) {
$nuevo_select .= '<option value="'.$row['codigo_departamento'].'">' . $row['nombre_departamento'] . '</option>/n';
}
$nuevo_select .= "</select>";
$borrar = "";
						  }				
$respuesta->addAssign("seleccombinado","innerHTML",$nuevo_select);
$respuesta->addAssign("selecmunicipios","innerHTML",$borrar);
return $respuesta;
}
////funcion municipios
function municipios2($formulario){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$departamento = $formulario["cod_departamento"];
include_once("librerias/conex.php"); 
$conn=Conectarse(); 
mysql_query ("SET NAMES 'utf8'");
$nuevo_select .= "<select id='cod_departamento' name='cod_departamento'>";	
$ssql = "SELECT * FROM geo_municipios_colombia WHERE  codigo_departamento = '$departamento'  "; 
$rs = mysql_query($ssql,$conn);
while( $row = mysql_fetch_array( $rs ) ) {
$nuevo_select .= '<option value="'.$row['codigo_municipio'].'">' . $row['nombre_municipio'] . '</option>/n';
}
$nuevo_select .= "</select>";
$respuesta->addAssign("selecmunicipios","innerHTML",$nuevo_select);
return $respuesta;
}
////fin funcion municipios

////funcion ciudades
function ciudades2($formulario){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$distrito = $formulario["distrito_ciudad"];
include_once("librerias/conex.php"); 
$conn=Conectarse(); 
mysql_query ("SET NAMES 'utf8'");
$nuevo_select .= "<select id='municipio' name='municipio'>";	
$ssql = "SELECT * FROM geo_ciudad WHERE  distrito_ciudad = '$distrito'  "; 
$rs = mysql_query($ssql,$conn);
while( $row = mysql_fetch_array( $rs ) ) {
$nuevo_select .= '<option value="'.$row['id_ciudad'].'">' . $row['nombre_ciudad'] . '</option>/n';
}
$nuevo_select .= "</select>";
$respuesta->addAssign("selecmunicipios","innerHTML",$nuevo_select);
return $respuesta;
}

//// FIN FUNCION PARA EL MUNDO


function procesar_formulario($form_entrada){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$inicio = $form_entrada["inicio"];
$fin = $form_entrada["fin"];

include_once("librerias/conex.php"); 
$link=Conectarse(); 

$sql=mysql_query("SELECT * FROM d9_users WHERE nombre_completo != '' LIMIT 0,10",$link);


$nuevo_select = "inicio = $inicio // fin = $fin <br>";
while( $row = mysql_fetch_array( $sql ) ) {
$nuevo_select .= '' . $row['id'] . '">' . $row['nombre_completo'] . '<br>';
}
$nuevo_select .= "";
$respuesta->addAssign("capaformulario","innerHTML",$nuevo_select);
return $respuesta;



} 


function procesar_alistamiento($form_entrada){ 
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$edicion = $form_entrada["edicion"];
$edicion_1 = $form_entrada["edicion"]+1;
$categoria = $form_entrada["categoria"];

include_once("librerias/conex.php"); 
$link=Conectarse(); 

$sql=mysql_query("
SELECT COUNT(productos.categoria) AS envios, categoria_productos.categoria_nombre  
FROM `transacciones`,`d9_users` ,`categoria_productos` ,`productos` 
WHERE transacciones.id = d9_users.id
AND categoria_productos.id_categoria = $categoria
AND transacciones.id_producto = productos.id_producto 
AND productos.categoria = categoria_productos.id_categoria
and recibo != '' and factura != ''
and recibo > 0 and factura > 0
and $edicion BETWEEN ed_inicial AND ed_final 
GROUP BY categoria_productos.id_categoria ",$link);
if (mysql_num_rows($sql)!=0){

$total=mysql_query("
SELECT COUNT(productos.categoria) AS envios, categoria_productos.categoria_nombre  
FROM `transacciones`,`d9_users` ,`categoria_productos` ,`productos` 
WHERE transacciones.id = d9_users.id
AND categoria_productos.id_categoria = $categoria
AND transacciones.id_producto = productos.id_producto 
AND productos.categoria = categoria_productos.id_categoria
and recibo != '' and factura != ''
and recibo > 0 and factura > 0
and $edicion_1 BETWEEN ed_inicial AND ed_final 
GROUP BY categoria_productos.id_categoria ",$link);

$i=0;
$Total=mysql_result($total,$i,"envios");  
$nuevo_select = "Alistamiento para la edici&oacute;n <b>$edicion</b>";
while( $row = mysql_fetch_array( $sql ) ) {
$nuevo_select .= ' Cantidad: <b>' . $row['envios'] . '</b>Proxima edicion: '.$Total.' Producto: <b> ' . $row['categoria_nombre'].'</b><a href="informes/alistamiento.php?edicion='.$edicion.'&categoria='.$row['categoria_nombre'].'"> descargar</a><br>';
}


}else {$nuevo_select = "No hay alistamiento para la edici&oacute;n <b>$edicion</b> de la categor&iacute;a seleccionada";}

$respuesta->addAssign("capaalistamiento","innerHTML",$nuevo_select);
return $respuesta;

}

//ventas procesar

function ventas_procesar($form_entrada){  
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
//variables
$cantidad = $form_entrada["cantidad"];
$ed_inicial = $form_entrada["ed_inicial"];
$id = $form_entrada["id"];
$vendedor = $_SESSION["id_usuario"];
$id_producto=$form_entrada["producto"];
$forma_pago=$form_entrada["forma_pago"];
$transaccion_observaciones=$form_entrada["transaccion_observaciones"];
$fecha_sistema=date('Y-m-d g:i:s');

include_once("librerias/conex.php"); 
$link=Conectarse(); 

$Productos=mysql_query("SELECT id_producto, valor, envios FROM productos WHERE id_producto = $id_producto",$link);  
$fila= mysql_fetch_array($Productos);
$valor = $fila['valor']*$cantidad;

if ($ed_inicial==""){ 
$ed_final = "NULL";  
$ed_inicial="NULL";}
else { $ed_final=($ed_inicial+$fila['envios'])-1; }

$sql=mysql_query("INSERT INTO `transacciones` ( `id_transaccion`, `id` , `fecha_sistema` , `fecha_transaccion` , `tipo` , `factura` , `recibo` , `recibo_fecha` , `id_producto` , `cantidad` , `ed_inicial` , `ed_final` , `forma_pago` , `valor` , `vendedor` , `estado`,  `cobro`,  `transaccion_observaciones`)
VALUES ( NULL , '$id' , '$fecha_sistema' , '$fecha_transaccion' , '$tipo' , '$factura' , '$recibo' ,'$recibo_fecha' ,'$id_producto' , '$cantidad' , '$ed_inicial' , '$ed_final' , '$forma_pago' , '$valor' , '$vendedor' , '$estado' , '$cobro', '$transaccion_observaciones')",$link);

$nuevo_select = "Se ha incluido el producto $id_producto /$fecha_sistema";
$nuevo_select .= "";
$respuesta->addAssign("capaventas","innerHTML",$nuevo_select);
return $respuesta;

} 


function estadisticas_alistamiento($form_entrada){ 
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$edicion_inicial = $form_entrada["edicion_inicial"];
$edicion_final = $form_entrada["edicion_final"];
$categoria = $form_entrada["categoria"];

include_once("librerias/conex.php"); 
$link=Conectarse(); 

$sql=mysql_query("
SELECT COUNT(productos.categoria) AS envios, categoria_productos.categoria_nombre  
FROM `transacciones`,`d9_users` ,`categoria_productos` ,`productos` 
WHERE transacciones.id = d9_users.id
AND categoria_productos.id_categoria = $categoria
AND transacciones.id_producto = productos.id_producto 
AND productos.categoria = categoria_productos.id_categoria
AND  ed_final >= $edicion_final 
AND ed_inicial <= $edicion_inicial
GROUP BY categoria_productos.id_categoria ",$link);
if (mysql_num_rows($sql)!=0){

$nuevo_select = "Alistamiento para la edici&oacute;n <b>$edicion</b>";
while( $row = mysql_fetch_array( $sql ) ) {
$nuevo_select .= ' Cantidad: <b>' . $row['envios'] . '</b> Producto: <b> ' . $row['categoria_nombre'].'</b><br>';
}


}else {$nuevo_select = "No hay alistamiento para la edici&oacute;n <b>$edicion</b> de la categor&iacute;a seleccionada";}

$respuesta->addAssign("capaalistamientoestadistica","innerHTML",$nuevo_select);
return $respuesta;


}
function revisar_documento($documentos){
$respuesta = new xajaxResponse('ISO-8859-1');
$documento1 = $documentos["documento_numero"];
$documento2 = $documentos["documento_numero2"];
if ($documento2 != $documento1)
{ $nuevo_select = '<font color="red">Las identificaciones no coinciden</font>';}
else{$nuevo_select = '<font color="green">Identificaciones correctas</font>';}
$respuesta->addAssign("documca","innerHTML",$nuevo_select);
return $respuesta;
}

function revisar_email($email){
$respuesta = new xajaxResponse('ISO-8859-1');
$email1 = $email["email"];
$email2 = $email["email_2"];
if ($email2 != $email1)
{ $nuevo_select = '<font color="red">Correos ingresados incorrectos</font>';}
else{$nuevo_select = '<font color="green">Correos ingresados correctos</font>';}
$respuesta->addAssign("mailca","innerHTML",$nuevo_select);
return $respuesta;
}

function revisar_telefono($telefono){
$respuesta = new xajaxResponse('ISO-8859-1');
$telefono1 = $telefono["$telefono_fijo"];
if ( strlen($telefono1)<7)
{ $nuevo_select = '<font color="red">Tel&eacute;fono incorrecto</font>';}
else{$nuevo_select = '<font color="green">Telefono correcto</font>';}
$respuesta->addAssign("tele1ca","innerHTML",$nuevo_select);
return $respuesta;
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
