<?php
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location:  includes/error.php");
// echo "hola mundo2";
} 

/// listado de facturas

function facturas_listado($pagina,$registros){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('utf-8'); 

if($_SESSION['grupo']!='1'){$id_empresa= $_SESSION['id_empresa'];}else {$id_empresa='%%';}
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");


$sql=mysql_query("SELECT * ,clientes.codigo AS codigo,clientes.alias AS alias
									FROM facturas , clientes
									WHERE facturas.id_empresa LIKE '$id_empresa' 
									AND clientes.id_cliente = facturas.id_cliente
									ORDER BY facturas.id_empresa , facturas.id_factura DESC 
									
									",$link);


if (mysql_num_rows($sql)!='0'){

//$registros='10';

if (!$pagina) {
   $inicio = 0;
   $pagina = 1;
}
else {
   $inicio = ($pagina - 1) * $registros;
}

$total_registros = mysql_num_rows($sql);
$resultados=mysql_query("SELECT * ,clientes.codigo AS codigo,clientes.alias AS alias
									FROM facturas , clientes
									WHERE facturas.id_empresa LIKE'$id_empresa' 
									AND clientes.id_cliente = facturas.id_cliente
									ORDER BY facturas.id_empresa , facturas.id_factura DESC 
									LIMIT $inicio, $registros
										",$link);
$total_paginas = ceil($total_registros / $registros);

$facturas_listado .=  "<div align='center'>";
if(($pagina - 1) > 0) {
$facturas_listado .=  "<a onClick=\"xajax_facturas_listado('".($pagina-1)."','$registros');\"' style='cursor:pointer'>< Anterior</a> ";
												}
															
for ($i=1; $i<=$total_paginas; $i++)
   if ($pagina == $i){
$facturas_listado .=  "<b>".$pagina."</b> ";
} else {
$facturas_listado .=  "
<a onClick=\"xajax_facturas_listado('$i','$registros');\"' style='cursor:pointer'>$i</a> ";
}

if(($pagina + 1)<=$total_paginas) {

$facturas_listado .= "<a onClick=\"xajax_facturas_listado('".($pagina+1)."','$registros');\"' style='cursor:pointer'> Siguiente ></a>";
}

$facturas_listado .= "<hr><font size='-2'>Página <b>$pagina</b> de <b>$total_paginas</b> total registros: <b>$total_registros</b></font><hr> </div>";
$facturas_listado .= "
<table>
				<tr align='center' bgcolor='#c2f0e5'>
					<td bgcolor='#ffffff'></td>
					
					<td><b>Número</b></td>
					<td><b>Fecha</b></td>
					<td><b>Vencimiento</b></td>
					<td  width='100%'><b>Referencia</b></td>
					<td><b>Contrato</b></td>
					<td><b>Subtotal</b></td>
					<td><b>Coopagos</b></td>
					<td><b>Total</b></td>
					<td></td>
					<td bgcolor='#ffffff'></td>
				</tr>";

while( $row = mysql_fetch_array( $resultados ) ) {
$facturas_listado .= "
				<tr valign='top'  onmouseover=\"uno(this,'c2f0e5');\" onmouseout=\"dos(this,'ffffff');\"onclick=\"uno(this,'c2f0e5');\" >
					
					<td></td>
					
					<td bgcolor='#F2F2F2' onclick=\"xajax_factura_buscar('','".$row['id_factura']."')\" style='cursor:pointer' ><b>".$row['prefijo']."-".$row['factura_numero']."</b></td>
					<td title='AAAA-MM-DD'>".date('Y-m-d',$row['fecha_factura'])."</td>
					<td bgcolor='#F2F2F2' title='AAAA-MM-DD'>".date('Y-m-d',$row['fecha_vencimiento'])."</td>
					<td>".$row['referencia']."</td>
					<td  bgcolor='#F2F2F2' title='".$row['alias']."/".$row['razon_social']."'>".$row['codigo']."</td>
					<td>".$row['subtotal']."</td>
					<td bgcolor='#F2F2F2' >".$row['excedente']."</td>
					<td>".$row['total']."</td>
					<td bgcolor='#F2F2F2' >";
					IF($row['estado']==1){$accion="<a HREF=\"javascript:abrir('facturacion/impresion/impresion.php?id_factura=".$row['id_factura']."','impresion_factura',750,400,100,0,1)\" TITLE='Imprimir factura ".$row['prefijo']."-".$row['factura_numero']."'><img src='images/print.gif' alt='[I]' border='0'></a>";}
					else{$accion="<img class='cursor' src='images/editar.gif' onclick=\"xajax_factura_buscar('','".$row['id_factura']."')\"  alt='[E]' title='Revisar la factura ".$row['prefijo']."-".$row['factura_numero']."'>";}
					
$facturas_listado.= "						
						$accion
					</td>
					
					<td></td>
				</tr>";
															}
										}
$facturas_listado.= "</table>

<hr><div align='center'><font size='-2'>Página <b>$pagina</b> de <b>$total_paginas</b> total registros: <b>$total_registros</b></font> </div>
";
$respuesta->addAssign("factura_formato","innerHTML",$facturas_listado);
return $respuesta;
} 

/// fin del listado de facturas


/// factura_nuevo_producto
function factura_nuevo_producto($facturacion){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('UTF-8');
$id_turno = $facturacion["id_turno"];
$id_factura = $facturacion["id_factura"]; 
$id_especialista = $facturacion["id_especialista"];
$id_evento = $facturacion["id_evento"];
$id_procedimiento = $facturacion["id_procedimiento"];
$valor = $facturacion["n_valor_procedimiento"];
$recibo = $facturacion["n_autorizacion"];
$id_cliente = $facturacion["id_cliente"];
$usuario = $facturacion["usuario"];
$cantidad = $facturacion["n_cantidad"];
$excedente = $facturacion["n_excedente"];


$timestamp_facturacion = time();
$factura_responsable = $_SESSION['id_usuario'];
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
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
																							`valor_procedimiento`,
																							`excedente`,
																							`id_factura`,
																							`cantidad`
																							) 
  													VALUES 
  																						(
  																						'$hoy',
  																						'$timestamp',
  																						'$timestamp',
  																						'$hora',
  																						'$id_especialista',
  																						'$usuario',
  																						'$observaciones',
  																						'7',
  																						'$id_evento',
  																						'$id_procedimiento',
  																						'$timestamp',
  																						'$factura_responsable',
  																						'$timestamp',
  																						'$factura_responsable',
  																						'$control',
  																						'1',
  																						'$recibo',
  																						'$id_cliente',
  																						'$valor',
  																						'$excedente',
  																						'$id_factura',
  																						'$cantidad'
  																						)",$link);     

						
$nuevo_select .= "<center><a href=?page=consulta&turno=$turno><h1>[ Iniciar consulta ]</h1></a></center>";
													

$respuesta->addAssign("otro_aviso","innerHTML",$nuevo_select);
return $respuesta;
} 




///NOMBRE DE LA FUNCION: factura_agregar_proceso

function factura_agregar_proceso($facturacion){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('UTF-8');
$id_turno = $facturacion["id_turno"];
$id_factura = $facturacion["id_factura"];
$timestamp_facturacion = time();
$factura_responsable = $_SESSION['id_usuario'];
if($id_turno != ''){

//include_once("librerias/conex.php"); 
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
mysql_query("
 	UPDATE 
 		turnos  
 	SET 
		 
		id_factura='$id_factura',
		factura_responsable='$factura_responsable' ,
		timestamp_facturacion='$timestamp_facturacion',
		estado='7'
	WHERE 
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


//// agregar productos a la factura
function factura_eventos_listado($estado,$id,$codigo){
$link=Conectarse(); 

$w='';
if ($id!='0'){$w .= "";}


// depuracion echo "estado: $estado time: $time  w: $w > esp: $especialista ";
mysql_query("SET NAMES 'utf8'");
$result=mysql_query("
		SELECT `nombre`,`cups`,`soat`,`id_evento`
		FROM `eventos` 
		WHERE eventos.estado='$estado'		
		$w
		
		ORDER BY nombre",$link);
if(mysql_num_rows($result) >0) {
$select .= "

			<select NAME='id_evento' id='id_evento' onChange=\"xajax_revisar_evento(this.value) \" >
				<option value'' >SELECCIONE PROCEDIMIENTOS</option>
				<option  > </option>
		   	<option value='otros' >         [ OTROS PROCEDIMIENTOS ]</option>
		   	<option  > </option>
		   	";
   while($row = mysql_fetch_array($result)) {
$select .=  "<option value=".$row["id_evento"]." >".$row["nombre"]." Cups ".$row["cups"]." Soat ".$row["soat"]."</option>\n";

   }

$select .=  "</select>
						<div id='revisar_evento'></div>
						";
										}else
										{
										$select .=  "No hay informaci&oacute;n ";}
return $select;
}



///NOMBRE DE LA FUNCION: factura_encabezado_formulario

function factura_encabezado_formulario($id_factura){
//creo el xajaxResponse para generar una salida

$respuesta = new xajaxResponse('UTF-8');

//$ = $variable_array[""];

if($_SESSION['grupo']!='1'){$id_empresa= $_SESSION['id_empresa'];}else {$id_empresa='%%';}
$link=Conectarse();
mysql_query("SET NAMES 'utf8'");
/// busca la factura con el id_factura
$factura_encabezado=mysql_query("SELECT * FROM facturas WHERE  id_factura = '$id_factura' AND id_empresa LIKE '$id_empresa' ORDER BY id_factura DESC LIMIT 1",$link);
// consulta los valores para la factura actual

$referencia=mysql_result($factura_encabezado,0,"referencia");
$fecha_factura = mysql_result($factura_encabezado,0,"fecha_factura");
$fecha_vencimiento = mysql_result($factura_encabezado,0,"fecha_vencimiento");
$fecha_pronto_pago = mysql_result($factura_encabezado,0,"fecha_pronto_pago");
$fecha_factura = date('Y-m-d',$fecha_factura);
$fecha_vencimiento = date('Y-m-d',$fecha_vencimiento);
$fecha_pronto_pago = date('Y-m-d',$fecha_pronto_pago);
$folios = mysql_result($factura_encabezado,0,"folios");
$descuento_pronto_pago = mysql_result($factura_encabezado,0,"descuento_pronto_pago");
$id_cliente = mysql_result($factura_encabezado,0,"id_cliente"); 
$enunciado = "Modificando";
											
											$nuevo_select .= "
											
											<div align='center' id='encabezado' style='border: 1px solid brown;'>
											<table><tr><td>
												<input type='hidden' value='$id_factura' name='id_factura' id='id_factura' >
												<input type='hidden' value='$id_empresa' name='empresa' id='empresa' >
												Referencia: <br><input type='text' size='70' name='referencia' value='$referencia' title='Referencia de la factura'><br>
												Fecha factura: [<b title='fecha de emisión o impresión para la factura'>?</b>]
												<input  size='10' id='fc_1 $mtime'  title='YYYY-MM-DD' onClick=\"displayCalendar(this);\" type='text' name='fecha_factura'  value='$fecha_factura' >
												Fecha vencimiento: <input  type='text' size='10' name='fecha_vencimiento' value='$fecha_vencimiento'  id='fc_2 $mtime'  title='YYYY-MM-DD' onClick=\"displayCalendar(this);\">
												<br>Fecha pronto pago: <input type='text'  size='10' name='fecha_pronto_pago' value='$fecha_pronto_pago' id='fc_3 $mtime'  title='YYYY-MM-DD' onClick=\"displayCalendar(this);\"> 
												Desc. pronto pago: <input type='text' size='3' name='descuento_pronto_pago' value='$descuento_pronto_pago' title='Descuento pronto pago (%)'>%
												Folios: <input type='text' size='3' name='folios' value='$folios' title='Folios anexos a la factura'>
												<br>
												<div name='aviso' id='aviso'></div>
																			";
												include_once('terceros/listado_asignacion_xajax.php');	

											
												
											$nuevo_select .=  "												
												</td></tr></table>	
												<div name='confirmacion' id='confirmacion' ></div><font color='red'>
												<b>Cerrar e imprimir la factura </b>
												<input type='checkbox' id='cerrar' name='cerrar' value='cerrar' title ='Si se cierra la factura no se podrá agregar mas procesos'>
												</font> <hr><a  title='Grabar los cambios' OnClick=\"xajax_factura_encabezado_modificar(xajax.getFormValues('facturacion')); \">
												Grabar los cambios
												</a>
																						
											</div>						"; 
											
																	
$respuesta->addAssign("encabezado","innerHTML",$nuevo_select);
return $respuesta;
} 
 
function factura_encabezado_modificar($variable_array){ 
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('UTF-8');
$id_factura = $variable_array["id_factura"];
$respuesta = new xajaxResponse('UTF-8');
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
$total_factura = $variable_array['total_factura'];
$total_excedente = $variable_array['total_excedente'];
$gran_total = $variable_array['gran_total'];
$letras = $variable_array['letras'];

$id_funcionario = $_SESSION['id_usuario'];
$cerrar = $variable_array['cerrar'];
if ($cerrar=='cerrar'){$estado = "`estado` = '1',";}else {$estado = "`estado` = '0',";}
//include_once("librerias/conex.php"); 
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");

$sql = mysql_query("
UPDATE `facturas` SET 
$estado
`subtotal` = '$total_factura',
`excedente` = '$total_excedente',
`total` = '$gran_total',
`fecha_factura` = '$fecha_factura',
`fecha_vencimiento` = '$fecha_vencimiento',
`id_cliente` = '$id_cliente',
`fecha_pronto_pago` = '$fecha_pronto_pago',
`descuento_pronto_pago` = '$descuento_pronto_pago',

`descuento` = '$descuento',

`id_usuario` = '$id_usuario',
`folios` = '$folios' ,
`letras` = '$letras' ,
`referencia` = '$referencia' 
WHERE `id_factura` = '$id_factura' LIMIT 1",$link);

if ($cerrar=='cerrar'){
////xajax_facturas_listado('".($pagina-1)."','$registros');
$respuesta->addScript("abrir('facturacion/impresion/impresion.php?id_factura=$id_factura','impresion_factura',750,400,100,0,1);");
$respuesta->addScript("xajax_facturas_listado('1','20');");
											}else{

$respuesta->addScript("xajax_factura_buscar('','$id_factura');");
														}
return $respuesta;
} 




///NOMBRE DE LA FUNCION: factura_encabezado_grabar
// para llamar la funcion utilizar 
// onChange="xajax_dummy(xajax.getFormValues('nombre_formulario'))"
function factura_encabezado_grabar($variable_array){ 
//creo el xajaxResponse para generar una salida
$id_cliente = $variable_array['id_cliente'];
$respuesta = new xajaxResponse('UTF-8');
//$id_turno = $variable_array['id_turno'];
if ($id_cliente == ""){
										$aviso .= "Se debe seleccionar un Cliente o contrato	 <img src='images/atencion.gif' alt='[!]' title='ATENCION: no se ha seleccionado un Cliente o contrato'>";
										$respuesta->addAssign("aviso_proceso","innerHTML",$aviso);
										return $respuesta;
										}


$prefijo = $variable_array["prefijo"];
$factura_numero = $variable_array["factura_numero"];
$id_empresa = $variable_array["empresa"];
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
$letras = $variable_array['letras'];
$id_funcionario = $_SESSION['id_usuario'];

//include_once("librerias/conex.php"); 
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
//$cliente_actual = mysql_query("SELECT id_cliente FROM turnos WHERE id_turno = '$id_turno'  LIMIT 1",$link);

///if (mysql_num_rows($cliente_actual)!='0'){$id_cliente = mysql_result($cliente_actual,0,"id_cliente");}


$sql = mysql_query("
INSERT INTO `facturas` (
`identificador` ,
`prefijo` ,
`factura_numero` ,
`id_empresa` ,
`fecha_factura` ,
`referencia` ,
`fecha_vencimiento` ,
`id_cliente` ,
`fecha_pronto_pago` ,
`descuento_pronto_pago` ,
`elaboro` ,
`folios` 

)
VALUES (
'$prefijo-$factura_numero',
'$prefijo',
'$factura_numero',
'$id_empresa',
 '$fecha_factura', 
 '$referencia', 
 '$fecha_vencimiento', 
 '$id_cliente', 
 '$fecha_pronto_pago', 
 '$descuento_pronto_pago',  
 '$id_funcionario', 
 '$folios'
)",$link);

//$nuevo_select .= "<h2>La factura $id_factura, ya está disponible</h2>";

//$respuesta->addAssign("factura_formato","innerHTML",$nuevo_select);
///$respuesta->addScript("xajax_factura_buscar(xajax.getFormValues('facturacion'));");
$respuesta->addScript("xajax_facturas_listado('1','20');");

return $respuesta;
} 

/// fin factura_encabezado_grabar


///NOMBRE DE LA FUNCION: factura_modificar
// para llamar la funcion utilizar 
// onChange="xajax_dummy(xajax.getFormValues('nombre_formulario'))"
function factura_modificar($variable_array){
if($_SESSION['grupo']!='1'){$id_empresa= $_SESSION['id_empresa'];}else {$id_empresa='%%';}
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('UTF-8');
$timestamp_facturacion = time();
$factura_responsable = $_SESSION['id_usuario'];
$prefijo = $variable_array["prefijo"];
$id_factura=$variable_array["id_factura"];

$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
foreach ($variable_array["recibo"] as $clave => $valor)
					{
						if($valor != ''){ 
														mysql_query("UPDATE turnos SET recibo='$valor', estado='7' WHERE id_turno='$clave' LIMIT 1	",$link);
														}
					}
foreach ($variable_array["factura_descripcion"] as $clave => $valor)
					{
						if($valor != ''){ 
														mysql_query("UPDATE turnos SET factura_descripcion='$valor', estado='7' WHERE id_turno='$clave' LIMIT 1	",$link);
														}
					}
foreach ($variable_array["id_fact"] as $clave => $valor)
					{
						if($valor != ''){ 
														$revisar_factura=mysql_query("
															SELECT id_factura FROM facturas 
															WHERE id_factura = '$valor'
															
															AND id_empresa LIKE '$id_empresa'  ",$link);
															if (mysql_num_rows($revisar_factura)!= 0)
																{
														mysql_query("UPDATE turnos SET 
																					id_factura='$valor',
																					factura_responsable='$factura_responsable' ,
																					timestamp_facturacion='$timestamp_facturacion',
																					estado='7' WHERE id_turno='$clave' LIMIT 1	",$link);
																				$nuevo_select .= "";
																													$div = "turno_".$clave;
																}else {$nuevo_select .= "<img src='images/atencion.gif' alt=[!] title='Se intento cambiar el numero
																													de factura por uno que no existe! o no tiene permiso'> Error!";
																													$div = "turno_".$clave;
																										
																			}
														}else
														{
														mysql_query("UPDATE turnos SET 
																					id_factura=NULL,
																					
																					factura_responsable='$factura_responsable' ,
																					timestamp_facturacion='$timestamp_facturacion' ,
																					estado='7'
																					WHERE id_turno='$clave' LIMIT 1	",$link);
																					
																				//	$nuevo_select .= "NO chequeados$clave > $valor<br>";													
														}
					}
//foreach ($variable_array["cups"] as $clave => $valor)
//					{ 
//						mysql_query("UPDATE turnos SET cups='$valor', estado='7' WHERE id_turno='$clave' LIMIT 1	",$link);
//					}
foreach ($variable_array["valor_procedimiento"] as $clave => $valor)
					{ 
						mysql_query("UPDATE turnos SET valor_procedimiento='$valor',estado='7' WHERE id_turno='$clave' LIMIT 1	",$link);
					}
foreach ($variable_array["excedente"] as $clave => $valor)
					{ 
						mysql_query("UPDATE turnos SET excedente='$valor' , estado='7'WHERE id_turno='$clave' LIMIT 1	",$link);
					}
foreach ($variable_array["cantidad"] as $clave => $valor)
					{
						if($valor != ''){ 
														mysql_query("UPDATE turnos SET cantidad='$valor',estado='7' WHERE id_turno='$clave' LIMIT 1	",$link);
														}
					}

foreach ($variable_array["id_fact"] as $clave => $valor)
				{
						if($valor != ''){ 
														mysql_query("UPDATE turnos SET total=(valor_procedimiento * cantidad) - excedente , estado='7'
														WHERE id_turno='$clave' LIMIT 1	",$link);
														}
				}



 

if($div == ""){$div = "otro_aviso";
$respuesta->addAssign("$div","innerHTML",$nuevo_select);
							}else{
$respuesta->addScript("xajax_factura_buscar('','$id_factura');");
										}
 return $respuesta;

} 






///NOMBRE DE LA FUNCION: factura_agregar
// para llamar la funcion utilizar 
// onChange="xajax_producto_agregar(xajax.getFormValues('nombre_formulario'))"
function factura_agregar($facturacion){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('UTF-8');
$id_turno = $facturacion["id_turno"];
$prefijo = $facturacion["prefijo"];
$factura_numero = $facturacion["factura_numero"];
$especialista = $facturacion["id_especialista"];
$id_evento = $facturacion["id_evento"];
$id_procedimiento = $facturacion["id_procedimiento"];
$valor = $facturacion["valor"];
$recibo = $facturacion["recibo"];
$id_cliente = $facturacion["id_cliente"];


$timestamp_facturacion = time();
$factura_responsable = $_SESSION['id_usuario'];
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
if($id_turno != ''){

//include_once("librerias/conex.php"); 

mysql_query("
 	UPDATE 
 		turnos  
 	SET 
		  
		id_factura='$id_factura',
		factura_responsable='$factura_responsable' ,
		timestamp_facturacion='$timestamp_facturacion',
		estado='7'
	WHERE 
		id_turno='$id_turno'
					",$link);
					


$nuevo_select .= "Proceso <b>$id_turno</b> agregado a la factura <b>$id_factura</b>";
} else {

				}


$respuesta->addScript("xajax_factura_buscar(xajax.getFormValues('facturacion'));");

return $respuesta;
} 

/// fin factura_agregar




///NOMBRE DE LA FUNCION: factura_buscar
// para llamar la funcion utilizar 
// onChange="xajax_dummy(xajax.getFormValues('nombre_formulario'))"
function factura_buscar($variable_array,$una_factura){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('UTF-8');
if($una_factura==''){
$id_factura = $variable_array["id_factura"];
										}else {$id_factura=$una_factura;}
										
$id_usuario = $variable_array["id_usuario"];
if($_SESSION['grupo']!='1'){$id_empresa= $_SESSION['id_empresa'];}else {$id_empresa='%%';}


$link=Conectarse();
mysql_query("SET NAMES 'utf8'");
/// si se pasa un $id_factura vacio se intentara crear una nueva
if($id_usuario==''){ if($id_factura==''){


$factura_nueva=mysql_query("SELECT * FROM empresa WHERE id_empresa LIKE '$id_empresa' LIMIT 1",$link);
$resolucion_facturacion=mysql_result($factura_nueva,0,"resolucion_facturacion");
$facturacion_desde=mysql_result($factura_nueva,0,"facturacion_desde");
$facturacion_hasta=mysql_result($factura_nueva,0,"facturacion_hasta");
$facturacion_primera=mysql_result($factura_nueva,0,"facturacion_primera");
$facturacion_prefijo=mysql_result($factura_nueva,0,"facturacion_prefijo");
$factura_ultima=mysql_query("SELECT * FROM facturas WHERE id_empresa LIKE '$id_empresa' ORDER BY id_factura DESC LIMIT 1",$link);
/// si no se han creado facturas se sugiere la marcada como primera en la DB tabla empresa
// se crea la variable $permitido para saber si se puede "1" o no "0" crear una nueva factura
if (mysql_num_rows($factura_ultima)== 0){$enunciado .= "Primera factura: ";
																				$permitido = "1";
																				$proxima_factura=$facturacion_primera;
																				}else
																				/// si hay facturas creadas se busca la de numero mayor y se le suma "1" para la proxima factura
																				{
																				$ultima_factura=mysql_result($factura_ultima,0,"factura_numero");
																				$proxima_factura=($ultima_factura + 1);
																				$permitido = "1";
																				/// se revisa que el proximo numero de factura este dentro del rango de la resolucion de facturacion
																				if($proxima_factura > $facturacion_hasta){$permitido = "0"; $enunciado = "Factura<i> $proxima_factura </i><b>mayor</b> que la permitida <img src='images/atencion.gif' alt='[!]' title='No se puede crear una factura mayor a $facturacion_hasta'>";}
																				if($proxima_factura < $facturacion_desde){$permitido = "0"; $enunciado = "Factura<i> $proxima_factura </i><b>menor</b> que la permitida <img src='images/atencion.gif' alt='[!]' title='No se puede crear una factura menor a $facturacion_desde'>";}
																				}
/// si esta permitido se podr'a crear la nueva factura
if($permitido == "0") {/// si el proximo numero de factura no esta en el rango
$nuevo_select .= "$enunciado";
$respuesta->addAssign("otro_aviso","innerHTML",$nuevo_select);
return $respuesta;

											}else
											{
											if($fecha_factura == ''){	$fecha_factura=date('Y-m-d');}
																								list( $ano, $mes, $dia ) = split( '[-]', $fecha_factura );

											if($fecha_vencimiento == ''){
																								$f_vencimiento=mktime(0,0,0, $mes, $dia, $ano);
																								$fecha_vencimiento = ($f_vencimiento + 2592000);
																								$fecha_vencimiento = date('Y-m-d',$fecha_vencimiento);
																									}
											if($fecha_pronto_pago == ''){
																								$f_pronto_pago=mktime(0,0,0, $mes, $dia, $ano);
																								$fecha_pronto_pago = ($f_pronto_pago + 1296000);
																								$fecha_pronto_pago = date('Y-m-d',$fecha_pronto_pago);
																									}
											$nuevo_select .= "<div align='center'><hr> $enunciado Factura  <b>$facturacion_prefijo$proxima_factura</b></div> ";
											$nuevo_select .= "
											<div align='center' id='encabezado_f' style='border: 1px solid brown;'>
											<table><tr><td>
												
												<input readonly type='hidden' value='$id_empresa' name='empresa' id='empresa' size='5' >
												<input readonly type='hidden' value='$facturacion_prefijo' name='prefijo' id='prefijo'  size='5'>
												<input readonly type='hidden' value='$proxima_factura' name='factura_numero' id='factura_numero'  size='5'>
												Referencia: <br><input type='text' size='70' name='referencia' value='$referencia' title='Referencia de la factura'><br>
												Fecha factura: [<b title='fecha de emisión o impresión para la factura'>?</b>]
												<input  size='10' id='fc_1 $mtime'  title='YYYY-MM-DD' onClick=\"displayCalendar(this);\" type='text' name='fecha_factura'  value='$fecha_factura' >
												Fecha vencimiento: <input  type='text' size='10' name='fecha_vencimiento' value='$fecha_vencimiento'  id='fc_2 $mtime'  title='YYYY-MM-DD' onClick=\"displayCalendar(this);\">
												<br>Fecha pronto pago: <input type='text' READONLY  size='10' name='fecha_pronto_pago' value='$fecha_pronto_pago' id='fc_3 $mtime'  title='YYYY-MM-DD' onClick=\"displayCalendar(this);\"> 
												Desc. pronto pago: <input type='text' size='3' name='descuento_pronto_pago' value='$descuento_pronto_pago' title='Descuento pronto pago (%)'>%
												Folios: <input type='text' size='3' name='folios' value='$folios' title='Folios anexos a la factura'>
												<br><div name='aviso_proceso' id='aviso_proceso'><!-- aqui se muestra la aletar si no se selecciona un proceso --></div>
												
												
																			";
											//	include_once('facturacion/funciones/listado_procesos.php');	
											include_once('terceros/listado_asignacion_xajax.php');												
												
											$nuevo_select .=  "												
												</td></tr></table>	
												<div name='confirmacion' id='confirmacion' ></div>
												<a  title='Crear una nueva factura con este número' 
												OnClick=\"xajax_factura_encabezado_grabar(xajax.getFormValues('facturacion')); \">
												<h2>[ CREAR FACTURA $facturacion_prefijo$proxima_factura ]</h2>
												</a>
																						
											</div>						";
											}
																				
$respuesta->addAssign("factura_formato","innerHTML",$nuevo_select);
return $respuesta;

														}else
														/// si se pasa un $id_factura no vacio se revisara si la factura existe
														{
														$factura_estado=mysql_query("SELECT estado 
																									FROM facturas 
																									WHERE id_factura = '$id_factura' 
																									LIMIT 1",$link);
														$estado = mysql_result($factura_estado,0,"estado");
														/// si la factura esta cerrada (1)//
														if($estado =='1'){$nuevo_select .="<h1>Factura cerrada</h1>";}
														/// si aun no se ha cerrado la factura se puede editar														
														else{
														
														
														$factura=mysql_query("SELECT * 
																									FROM facturas 
																									WHERE id_factura = '$id_factura' 
																									AND id_empresa LIKE '$id_empresa'
																									ORDER BY id_factura DESC LIMIT 1",$link);
														
														////totales de la factura
														$total=mysql_query("SELECT sum( valor_procedimiento ) AS Total
																								FROM `turnos`
																								WHERE id_factura = $id_factura
																								AND id_empresa LIKE '$id_empresa'
																								GROUP BY id_factura",$link);
																$row = mysql_fetch_row($total);
																$Total = $row[0];
																$Total_factura = number_format($row[0], 2, ',', '.'); 
														/// suma para el valor total de excedente y coopago
														$total_excedente=mysql_query("SELECT sum( excedente ) AS Excedente
																													FROM `turnos`
																													WHERE id_factura = $id_factura
																													AND id_empresa LIKE '$id_empresa'
																													GROUP BY id_factura",$link);
																$row_excedente = mysql_fetch_row($total_excedente);
																$Excedente = $row_excedente[0];
																$Total_excedente = number_format($row_excedente[0], 2, ',', '.'); 
														$gran_total = ($Total - $Excedente); 
														
														$Gran_total = number_format($gran_total, 2, ',', '.');
														/// si no se encuentra la factura en la tabla se imprime un mensaje de error															
														if (mysql_num_rows($factura)== 0)
																			{
																			$nuevo_select .= "<div align='center'><h3>La factura $id_factura aun no existe! <img src='images/atencion.gif' alt='[!]' title='No se ha especificado una factura valida'></h3></div> ";
																			}else
																			/// si se encuentra la factura en la tabla se imprime la informacion 
																			{
																			while( $row = mysql_fetch_array( $factura ) ) 
																				{
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
																				$factura_actual = $row['factura_numero'];
																				$prefijo = $row['prefijo'];
																				$mtime= microtime();
																				}
																			$nuevo_select .= "<h2>Factura $prefijo$factura_actual</h2>
																			<input type='hidden' name='id_factura' id='id_factura' value='$id_factura' >
																			<div align='center' id='encabezado' '>
																				<div align='center' id='encabezado_f' style='border: 1px solid brown;'>
																										<table width='100%'>
																											<tr>
																												<td>
																												<ul>																												
																												<li>Referencia: <b>$referencia</b></li>
																												<li>Fecha factura: <b>$fecha_factura</b></li>
																												<li>Fecha vencimiento: <b>$fecha_vencimiento</b></li>
																												<li>Fecha pronto pago: <b>$fecha_pronto_pago</b> desc <b>$descuento_pronto_pago</b> %</li>
																												";
																													$cliente_actual = mysql_query("SELECT alias, codigo FROM clientes WHERE id_cliente = '$id_cliente'  LIMIT 1",$link);
																													if (mysql_num_rows($cliente_actual)!='0'){																													
																													$cliente = mysql_result($cliente_actual,0,"alias");
																													$codigo = mysql_result($cliente_actual,0,"codigo");	
																																												}																						
																			$nuevo_select .=	"
																												<li>Cliente: <b>$cliente</b> [$codigo]</li>																								
																												<li>Número de folios: <b>$folios</b></li>		
																												</ul>
																												
																												</td>
																												<td>
																													<div align='right'>
																													Valor $ <strong>$Total_factura</strong> <br>
																													 Coopagos o excedentes - $ <strong>$Total_excedente</strong> 
																													 <hr>
																													 <h2>Total: $ $Gran_total</h2>
																													</div>
																												</td>
																											</tr>
																										</table>	
																										<a onClick=\"xajax_factura_encabezado_formulario('$id_factura'); \">Modificar encabezado o cerrar la factura</a>																				
																				</div>
																			</div>	
																			<input readonly type='hidden' id='total_factura' name='total_factura' value='$Total'>
																			<input readonly type='hidden' id='total_excedente' name='total_excedente' value='$Excedente'>
																			<input readonly type='hidden' id='gran_total' name='gran_total' value='$gran_total'>	
																			
																			<center>
																			
																			<table cellpadding='0' cellspacing='0' border='0' align='center' valign='top' width='100%'>
																				<tr>
																					<td align='center'>
																						
								
																			
																							";
			
											/// muestra procesos relacionados con este cliente
										
											
											$sql=mysql_query("
																			SELECT 
																				turnos.id_turno,
																				turnos.id_usuario,
																				turnos.fecha, 
																				turnos.especialista,
																				turnos.factura_descripcion,
																				d9_users.nombre_completo,
																				codigo,
																				turnos.id_evento,
																				turnos.id_procedimiento,
																				turnos.id_factura,
																				turnos.factura_prefijo,
																				turnos.recibo,
																				turnos.cantidad,
																				valor_procedimiento,
																				excedente,
																				total ,
																				turnos.especialista as id_especialista
																			FROM 
																				turnos, 
																				d9_users,
																				
																				clientes
																			WHERE 
																						turnos.id_cliente = '$id_cliente'		
																			AND turnos.id_empresa LIKE '$id_empresa'													
																			AND ( id_factura IS NULL OR turnos.id_factura = '' OR turnos.id_factura = '$id_factura' OR turnos.id_factura = '0' ) 
																			AND d9_users.id = turnos.id_usuario
																			
																			AND clientes.id_cliente =turnos.id_cliente
																			
																			ORDER BY turnos.id_factura DESC , id_usuario, fecha ASC
																			",$link);
			
			/// SI HAY PROCESOS SIN FACTURAR PARA ESE CLIENTE	
			/// implentar la facturacion por usuario													
	
			if (mysql_num_rows($sql)!='0'){
														$nuevo_select .= "";
																											
															$nuevo_select .= "<table cellpadding='0' cellspacing='0' border='0' width='100%'>
															<tr bgcolor='#c2f0e5'>
																<td></td>	
																
																<td><font size='-2'>Cant</font></td>
																<td><CENTER>Usuario</td>
																<td>Cups</td>
																<td>Autorización</td>
																<td><center>Descripción</td>
																<td>Valor</td>
																<td>Coopago</td>
																<td>Total</td>
															</tr> "; 
																			while( $row = mysql_fetch_array( $sql ) ) 
																			{		
																																							
																			
																			if ($row['factura_descripcion'] ==''){$descripcion = $row['nombre'];} 
																				else {$descripcion = $row['factura_descripcion'];}
																				
																				if ($row['id_factura'] ==''){$estado="0";}
																				elseif($row['id_factura'] ==NULL){$estado="0";}
																				elseif($row['id_factura'] =='0'){$estado="0";}
																				elseif($row['id_factura'] ==$id_factura){$estado="1";}
																				else{$estado="0";}
																			if ($estado ==1){$accion = "
																			<input TITLE ='QUITAR de la factura' checked OnClick =\"document.getElementById('id_fact[".$row['id_turno']."]').value=''; 
														
														xajax_factura_modificar(xajax.getFormValues('facturacion'));	\"  
														type='checkbox' name='agregar_quitar_factura' value='id'>
														";} 
																				else {$accion = "
																				<input title ='AGREGAR  a la factura' OnClick =\"document.getElementById('id_fact[".$row['id_turno']."]').value='$id_factura'; 
														
														xajax_factura_modificar(xajax.getFormValues('facturacion'));	\"  
														type='checkbox' name='agregar_quitar_factura' value='id'>";}
																			$nuevo_select .= "<tr valign='top' onclick=\"uno(this,'c2f0e5');\" onmouseover=\"uno(this,'c2f0e5');\" onmouseout=\"dos(this,'ffffff');\" >
																			
																				<td><div id='turno_".$row['id_turno']."'></div>$accion
																				
																				<input type='HIDDEN' name='id_fact[".$row['id_turno']."]' id='id_fact[".$row['id_turno']."]' SIZE='6' value='".$row['id_factura']."'  >	
																						
																				</td>
																				<td><input  class='invisible' size='2' name='cantidad[".$row['id_turno']."]' id='cantidad[".$row['id_turno']."]' value='";
																				if($row['cantidad']==''){$cantidad="1";}else{$cantidad=$row['cantidad'];} $cantidad;
																			$nuevo_select .="$cantidad' 
																				OnChange=\"xajax_factura_modificar(xajax.getFormValues('facturacion')); \"></td>	
																								 ";
																				$especialista =$row['especialista'];
																						$Especialista=mysql_query("SELECT nombre_completo, color
																																				FROM d9_users, especialistas
																																				WHERE d9_users.id = $especialista AND  especialistas.id = d9_users.id
																																				",$link); 
																						$especialista = mysql_result($Especialista,0,"nombre_completo");
																						$color = mysql_result($Especialista,0,"color");
																						$cups = $row['id_evento'];
																						$otro_servicio = $row['id_procedimiento'];
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
																						
																				$nuevo_select .= "
																				<td TITLE='[".$row['id_turno']."] Fecha ".$row['fecha']." Atendió: $especialista' bgcolor='$color'><font size='-2' >".$row['nombre_completo']."</font></td>
																				<td TITLE='$servicio_nombre'>$servicio</td>
																				<td><input class='invisible' size='8' name='recibo[".$row['id_turno']."]' id='recibo[".$row['id_turno']."]' value='".$row['recibo']."' title='".$row['recibo']."' Onchange=\"xajax_factura_modificar(xajax.getFormValues('facturacion'));\" ></td>
																				<td><input class='invisible' name='factura_descripcion[".$row['id_turno']."]' id='factura_descripcion[".$row['id_turno']."]' value='$descripcion' title='$descripcion' OnChange=\"xajax_factura_modificar(xajax.getFormValues('facturacion'));\" ></td>
																				<td><input class='invisible' size='8' name='valor_procedimiento[".$row['id_turno']."]' id='valor_procedimiento[".$row['id_turno']."]' value='".$row['valor_procedimiento']."' OnChange=\"xajax_factura_modificar(xajax.getFormValues('facturacion'));\" ></td>
																				<td><input class='invisible' size='8' type='text' name='excedente[".$row['id_turno']."]' id='excedente[".$row['id_turno']."]' value='".$row['excedente']."' OnChange=\"xajax_factura_modificar(xajax.getFormValues('facturacion'));\" ></td>
																				<td><strong>".$row['total']."</strong></td></tr>";
																																								
																			}
																			$nuevo_select .="</table>
																			</td>
																				</tr>
																			</table></center>		";														
	//// AGREGAR OTROS EVENTOS A LA FACTURA
$nuevo_select .="

																			
		<!-- <b>Agregar a la factura</b><hr>
								<table cellpadding='0' cellspacing='0' border='0' width='100%'>
									<tr align='center'>
										<td><font size='-1'><b>Cant</b></font></td>
										<td><font size='-1'><b>Valor</b></td>
										<td><font size='-1'><b>Coopago</b></td>
										<td><font size='-1'><b>Autorización</b></td>
									</tr>
								
									<tr valign='top'  align='right'>
										<td  align='right'><input type='text' name='n_cantidad' id='n_cantidad' size='3' value='1'></td>
										<td><input type='text' name='n_valor_procedimiento' id='n_valor_procedimiento' size='12'></td>
										<td><input type='text' name='n_excedente' id='n_excedente' size='12'></td>
										<td><input type='text' name='n_autorizacion' id='n_autorizacion' size='12'></td>
									</tr>
								</table>";
							
					$nuevo_select .= factura_eventos_listado('1','0','0'); 
					
				include_once('terceros/listado_XAJAX.php');	
				$nuevo_select .= listado_especialistas();
				include_once('suscriptores/funciones/suscriptores.php');	
				$nuevo_select .= listado_usuarios_por_cliente($id_cliente);
				
					
								$nuevo_select .= "
								<hr><input type='button' value='Agregar a la factura $id_factura' 
								OnClick=\"xajax_factura_nuevo_producto(xajax.getFormValues('facturacion')); \" >
																	 -->				";
																		}else 
																		{ $nuevo_select .= "<h1>No hay procesos pendientes</h1>";
																		}						


																			/// fin de los procesos relcionados con este cliente
																			
																			}/// fin de la informacion para factura existente
																}/// fin de la edicion de factura abierta																			
																			
														}/// fin de factura por cliente
									}else { ///// INICIO FACTURA POR USUARIO
									
									$nuevo_select .= "<center><h1> Facturación para $id_usuario </h1></center>";
									
									$sql=mysql_query("
																																						SELECT 
																				turnos.id_turno,
																				turnos.id_usuario,
																				turnos.fecha, 
																				turnos.especialista,
																				turnos.factura_descripcion,
																				d9_users.nombre_completo, 
																				
																				turnos.id_cliente ,
																				turnos.id_procedimiento ,
																				turnos.id_evento ,
																				
																				turnos.factura,
																				turnos.recibo,
																				turnos.cantidad,
																				turnos.valor_procedimiento,
																				turnos.excedente,
																				turnos.total ,
																				turnos.especialista as id_especialista
																			FROM 
																				turnos, 
																				d9_users
																			WHERE 
																				turnos.id_usuario = '$id_usuario'
																			
																			AND d9_users.id = turnos.id_usuario
																			
																			ORDER BY turnos.id_factura DESC , id_usuario, fecha ASC
																			",$link);

			/// SI HAY PROCESOS SIN FACTURAR PARA ESE CLIENTE														
	
			if (mysql_num_rows($sql)!='0'){
														$nuevo_select .= "<ol>";
																											
															$nuevo_select .= "<table border='0' >
															<tr bgcolor='beige'>
																<td><b>Factura</b></td>	
																<td><b>Cant</b></td>
																<td><b><CENTER>USUARIO</b></td>
																<td><b>SERVICIO</b></td>
																
																<td><b><CENTER>AUTORIZA</b></td>
																<td><center><b>DESCRIPCION</b></td>
																<td><b>VALOR</b></td>
																<td><b>COOPAGO</b></td>
																<td><b>TOTAL</b></td>
															</tr> "; 
																			while( $row = mysql_fetch_array( $sql ) ) 
																			{			
																																							
																			
																			if ($row['factura_descripcion'] ==''){$descripcion = $row['nombre'];} 
																				else {$descripcion = $row['factura_descripcion'];}
																			if ($row['factura'] ==''){$factura = $factura_actual;} 
																				else {$factura = $row['factura'];}
																			$nuevo_select .= "
																			<tr valign='top'>
																				<td>
																				<div id='turno_".$row['id_turno']."'></div>
																				<b>$factura</b>		
																				</td>
																				<td>".$row['cantidad']."</td>	
																								 ";
																				$especialista =$row['especialista'];
																						$Especialista=mysql_query("SELECT nombre_completo, color
																																				FROM d9_users, especialistas
																																				WHERE d9_users.id = $especialista AND  especialistas.id = d9_users.id
																																				",$link); 
																						$especialista = mysql_result($Especialista,0,"nombre_completo");
																						$color = mysql_result($Especialista,0,"color");
																						$cups = $row['id_evento'];
																						$otro_servicio = $row['id_procedimiento'];
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
																						
																				$nuevo_select .= "
																				<td TITLE='[".$row['id_turno']."] Fecha ".$row['fecha']." Atendió: $especialista' bgcolor='$color'><font size='-2' >".$row['nombre_completo']."</font></td>
																				
																				
																				<td title='$servicio_nombre'>$servicio</td>
																				
																				<td>".$row['recibo']."</td>
																				<td>$descripcion</td>
																				<td nowrap>$".$row['valor_procedimiento']."</td>
																				<td nowrap>$".$row['excedente']."</td>
																				<td nowrap><strong>$".$row['total']."</strong></td></tr>";
																																								
																			}
																			$nuevo_select .="</table>";														
																				
																		}else 
																		{ $nuevo_select .= "<h1>No hay procesos pendientes</h1>";
																		}						

												}//// FIN FACTURA POR USUARIO					




$respuesta->addAssign("factura_formato","innerHTML",$nuevo_select);
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
