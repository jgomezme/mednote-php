<?php session_start(); 
include_once("../librerias/conex_anonimo.php");
//incluímos la clase ajax
require ('../../xajax/xajax.inc.php');

//instanciamos el objeto de la clase xajax
$xajax = new xajax();

require ('../includes/funciones_anonimo_XAJAX.php');

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequests();
?>
<html xmlns="http://www.w3.org/1999/xhtml"xml:lang="es" lang="es" dir="ltr">
<head>
<script language="JavaScript" src="../librerias/scripts.js" type="text/javascript"></script>


 <? $xajax->printJavascript("../../xajax/");  ?>

 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Un proyecto de: http://opuslibertati.org - Powered by: GaleNUx</title>
<link href="../estilos/impresion_pantalla.css" rel="stylesheet" type="text/css" >
<link href="../estilos/impresion.css" rel="stylesheet" type="text/css" media="print">
<script>


function SoloCerrar(){
window.close()
							}
function Imprimir(){
window.print()
							}
</script>
</head>
<body>

<?php 

$ai=$_REQUEST['r'];
$pin=$_POST['pin'];
$formulario = solicitud_autorizacion($ai,"listado",$pin);

echo $formulario;
function geo_nombre_ciudad($cod_departamento,$cod_municipio){
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
$nombre_localidad=mysql_query("SELECT nombre_departamento, nombre_municipio FROM geo_municipios_colombia WHERE codigo_departamento like '$cod_departamento' AND codigo_municipio like '$cod_municipio'",$link);
if (mysql_num_rows($nombre_localidad)!='0'){
$nombre_municipio = mysql_result($nombre_localidad,0,"nombre_municipio");
} else{$nombre_municipio="[$cod_departamento][$cod_municipio]";}
return $nombre_municipio;
		}
function geo_nombre_departamento($cod_departamento,$cod_municipio){
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
$nombre_localidad=mysql_query("SELECT nombre_departamento, nombre_municipio FROM geo_municipios_colombia WHERE codigo_departamento like '$cod_departamento' AND codigo_municipio like '$cod_municipio'",$link);
if (mysql_num_rows($nombre_localidad)!='0'){
$nombre_departamento = mysql_result($nombre_localidad,0,"nombre_departamento");
} else{$nombre_departamento="[$cod_departamento][$cod_municipio]";}
return $nombre_departamento;
		}
function solicitud_autorizacion($ai,$tipo,$pin){
//creo el xajaxResponse para generar una salida
//$respuesta = new xajaxResponse('utf-8');
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");

$sql1=mysql_query("SELECT * FROM autorizaciones_recibidas WHERE control = '$ai' LIMIT 1",$link);
if (mysql_num_rows($sql1)!='0'){
$pin_id =mysql_result($sql1,0,"pin");

if (($pin!=$pin_id) && ( !isset($_SESSION[grupo]))){$nuevo_select .= "
	<div align='center'>
	<br><br>
	<img src='../images/atencion.gif' alt='[!]'><br> <br> <h2>El PIN <font  COLOR='RED'>$pin</font> no  corresponde al documento solicitado!</h2>
	<br>
	<form method='post' name='pin' id='pin'>
	PIN: <input type='text' value='' name='pin' size='10' title='Escriba el PIN que se le envió por correo y oprima ENTER'>
	<input type='hidden' value='$ai' name='r' size='10'><BR>	<font size='-1' COLOR='RED'>Escriba el PIN que se le envió por <b>correo</b> y oprima ENTER</font>
	</form>

</div>

";					}else{
$sql=mysql_query("SELECT * FROM autorizaciones_solicitud WHERE control = '$ai' LIMIT 1",$link);
$numero_solicitud=wordwrap(mysql_result($sql,0,"consecutivo"),1,'</b>|<b>',true);
$fecha_solicitud=mysql_result($sql,0,"timestamp_autorizacion");
$fecha_solicitud=wordwrap(date("Y-m-d ",$fecha_solicitud),1,'</b>|<b>',true);
$hora_solicitud=mysql_result($sql,0,"timestamp_autorizacion");
$hora_solicitud=wordwrap(date("H:i ",$hora_solicitud),1,'</b>|<b>',true);

$porcentaje=mysql_result($sql1,0,"porcentaje");
$semanas=mysql_result($sql1,0,"semanas");
$bono=mysql_result($sql1,0,"bono");
if($bono=='1'){$bono="checked disabled='true'";}ELSE{$bono=" disabled='true' ";}
$cuota_moderadora=mysql_result($sql1,0,"cuota_moderadora");
if($cuota_moderadora=='1'){$cuota_moderadora="checked disabled='true'";}ELSE{$cuota_moderadora=" disabled='true'";}
$valor_cuota_moderadora=mysql_result($sql1,0,"valor_cuota_moderadora");
$porcentaje_cuota_moderadora=mysql_result($sql1,0,"porcentaje_cuota_moderadora");
$tope_cuota_moderadora=mysql_result($sql1,0,"tope_cuota_moderadora");
$copago=mysql_result($sql1,0,"copago");
if($copago=='1'){$copago="checked disabled='true'";}ELSE{$copago=" disabled='true' ";}
$valor_copago=mysql_result($sql1,0,"valor_copago");
$porcentaje_copago=mysql_result($sql1,0,"porcentaje_copago");
$tope_copago=mysql_result($sql1,0,"tope_copago");
$cuota_de_recuperacion=mysql_result($sql1,0,"cuota_de_recuperacion");
if($cuota_de_recuperacion=='1'){$cuota_de_recuperacion="checked disabled='true'";}ELSE{$cuota_de_recuperacion=" disabled='true'";}
$valor_cuota_de_recuperacion=mysql_result($sql1,0,"valor_cuota_de_recuperacion");
$porcentaje_cuota_de_recuperacion=mysql_result($sql1,0,"porcentaje_cuota_de_recuperacion");
$tope_cuota_de_recuperacion=mysql_result($sql1,0,"tope_cuota_de_recuperacion");
$otro=mysql_result($sql1,0,"otro");
if($otro=='1'){$otro="checked disabled='true'";}ELSE{$otro=" disabled='true'";}
$valor_otro=mysql_result($sql1,0,"valor_otro");
$porcentaje_otro=mysql_result($sql1,0,"porcentaje_otro");
$tope_otro=mysql_result($sql1,0,"tope_otro");
$pagos="
			<table cellpadding='0' cellspacing='0' border='0' align='center' width='100%'  >
					<tr>
						<td colspan='3' align='center'>NÚMERO SOLICITUD ORIGEN: |<b>$numero_solicitud</b>| Fecha:  |<b>$fecha_solicitud</b>| Hora: |<b>$hora_solicitud</b>|
						<hr>
						</td>
					</tr>
					<tr>
						<td colspan='3' align='center'>
						<font size='-1'>Porcentaje del valor de esta autorización a pagar por la entidad responsable del pago: </font>
						 <b>$porcentaje %</b> 
						</td>
					</tr>
					<tr>
						<td colspan='2' align='center'>
						<font size='-1'>Semanas de afiliaciónd el paciente  a la solicitud de la autorización: <b>$semanas</b>
						 
						</td>
						<td  align='center' colspan='1'>
						<b><font size='-1'>Reclamo de tiquete , bono o vale de pago 
						 <input title='SI' name='bono' id='bono' type='checkbox' value='1' $bono> </b> 
						</td>
						
					</tr>
					<tr valign='top' align='center' >
						<td colspan='3'>
						<table align='center'  width='80%' border ='0'>
						<tr valign='top' align='center'>
						<td><font size='-2'><b>Concepto</b></font>
						</td>
						<td><font size='-2'><b>Valor en pesos</b></font>
						</td>
						<td><font size='-2'><b>Porcentaje</b> %</font>
						</td>
						<td ><font size='-2'><b>Valor máximo (tope) en pesos</b></font>
						</td>
					</tr>
					<tr valign='top' align='center'>
						<td align='left'><font size='-2'><input type='checkbox' value='1' id='cuota_moderadora' name='cuota_moderadora' $cuota_moderadora title='Cuota moderadora'><b>Cuota moderadora</b></font>
						</td>
						<td><font size='-2'>$valor_cuota_moderadora</font>
						</td>
						<td><font size='-2'>$porcentaje_cuota_moderadora</font>
						</td>
						<td><font size='-2'>$tope_cuota_moderadora</font>
						</td>
						
					</tr>
					
					<tr valign='top' align='center'>
						<td align='left'><font size='-2'><input type='checkbox' value='1' id='copago' name='copago' title='Copago' $copago><b>Copago</b></font>
						</td>
						<td><font size='-2'>$valor_copago</font>
						</td>
						<td><font size='-2'>$porcentaje_copago</font>
						</td>
						<td><font size='-2'>$tope_copago</font>
						</td>
						
					</tr>
					
					<tr valign='top' align='center'>
						<td align='left'><font size='-2'><input type='checkbox' value='1' id='cuota_de_recuperacion' name='cuota_de_recuperacion' $cuota_de_recuperacion title='Cuota de recuperación'><b>Cuota de recuperacion</b></font>
						</td>
						<td><font size='-2'>$valor_cuota_de_recuperacion</font>
						</td>
						<td><font size='-2'>$porcentaje_cuota_de_recuperacion</font>
						</td>
						<td><font size='-2'>$tope_cuota_de_recuperacion</font>
						</td>
						
					</tr>
					
					<tr valign='top' align='center'>
						<td align='left'><font size='-2'><input type='checkbox' value='1' id='otro' name='otro' $otro title='Otro'><b>Otro</b></font>
						</td>
						<td><font size='-2'>$valor_otro</font>
						</td>
						<td><font size='-2'>$porcentaje_otro</font>
						</td>
						<td><font size='-2'>$tope_otro</font>
						</td>
						
					</tr>
					
						</table>
						<hr>
			";
$telefono_indicativo_autoriza=mysql_result($sql1,0,"telefono_indicativo_autoriza");
$telefono_numero_autoriza=mysql_result($sql1,0,"telefono_numero_autoriza");
$telefono_extencion_autoriza=mysql_result($sql1,0,"telefono_extencion_autoriza");
$telefono_celular_autoriza=mysql_result($sql1,0,"telefono_celular_autoriza");
$id_funcionario=mysql_result($sql1,0,"id_funcionario");
$funcionario=mysql_query("SELECT * FROM d9_users WHERE id = '$id_funcionario' LIMIT 1",$link);
$nombre_completo_funcionario=mysql_result($sql1,0,"nombre_autoriza");
$cargo_funcionario=mysql_result($sql1,0,"cargo_autoriza");
$id_registro=wordwrap(mysql_result($sql1,0,"numero_autorizacion"),1,'</b>|<b>',true);
$fecha_registro=mysql_result($sql1,0,"fecha_autorizacion");
$fecha_registro=wordwrap($fecha_registro,1,'</b>|<b>',true);
$hora_registro=mysql_result($sql1,0,"hora_autorizacion");
$hora_registro=wordwrap($hora_registro,1,'</b>|<b>',true);
$consulta_ai=mysql_query("SELECT * FROM atencion_inicial WHERE control = '$ai'",$link);

$accidente_de_transito=mysql_result($consulta_ai,0,"accidente_de_transito");
if($accidente_de_transito =='1'){$at='checked';}

$origen_de_la_atencion=mysql_result($consulta_ai,0,"origen_de_la_atencion");
if($origen_de_la_atencion=='1'){$o1='checked';}
elseif($origen_de_la_atencion=='2'){$o2='checked';}
elseif($origen_de_la_atencion=='3'){$o3='checked';}
elseif($origen_de_la_atencion=='4'){$o4='checked';}
else{}
//$destino=mysql_result($sql,0,"destino");
if($destino =='0'){$d0 = "checked";}
elseif ($destino =='1'){$d1 = "checked";}
elseif ($destino =='2'){$d2 = "checked";}
elseif ($destino =='3'){$d3 = "checked";}
elseif ($destino =='4'){$d4 = "checked";}
else {$destino = $d5 = "checked";}
$tipo_servicio =mysql_result($sql,0,"tipo_servicio");
if($tipo_servicio ='1'){$ts1='checked'; $ts2='';}else{$ts1='';$ts2='checked';}
$consulta_datos=mysql_query("SELECT id_campo, contenido FROM consulta_datos WHERE control = '$ai'",$link);

$prioridad_atencion =mysql_result($sql,0,"prioridad_atencion");
if($prioridad_atencion ='1'){$pa1='checked'; $pa2='';}else{$pa1='';$pa2='checked';}

$ubicacion_lugar =mysql_result($sql,0,"ubicacion_lugar");
if($ubicacion_lugar ='1'){$up1='checked'; $up2='';$up3='';}
elseif($ubicacion_lugar ='2'){$up1=''; $up2='checked';$up3='';}
else{$up1=''; $up2='';$up3='checked';}
$ubicacion_servicio =mysql_result($sql,0,"ubicacion_servicio");
$ubicacion_cama =mysql_result($sql,0,"ubicacion_cama");
$guia =mysql_result($sql,0,"guia");
$consulta_datos=mysql_query("SELECT id_campo, contenido, id_consulta_datos FROM consulta_datos WHERE control = '$ai'",$link);


while( $row = mysql_fetch_array( $consulta_datos ) ) {
$id_consulta_datos=$row['id_consulta_datos'];
$consulta_especialista ="SELECT consulta_datos.id_especialista, d9_users.id_grupo 
									FROM	consulta_datos, d9_users 
									WHERE consulta_datos.id_consulta_datos = '$id_consulta_datos' 
									AND consulta_datos.id_especialista = d9_users.id";
$grupo_especialista = mysql_query($consulta_especialista,$link);
$grupo_especialista=mysql_result($grupo_especialista,0,"id_grupo");
$error ="0";
$firmado='0';
if($grupo_especialista != '9'){ /// si el grupo no es hospitalario revisar si esta avalado por un tutor
	$revisado_consulta ="SELECT firma_contenido, id_funcionario FROM	consulta_revision WHERE id_campo = '$id_consulta_datos' AND tabla='consulta_datos'";
	$revisado = mysql_query($revisado_consulta,$link);
		if (mysql_num_rows($revisado)!='0'){ $firmado='1'; }
										}else{ $firmado='1'; }
if($firmado=='1'){
if($row[id_campo]=='1'){$motivo_consulta= $row['contenido']; }
if($row[id_campo]=='12'){$diagnostico_principal=wordwrap($row['contenido'],1,'</b>|<b>',true); 
								 
								$cie_0_descripcion =  usuario_datos_consultar($row['contenido'],'cie_10','descripcion');}
if($row[id_campo]=='13'){$diagnostico_relacionado_1=wordwrap($row['contenido'],1,'</b>|<b>',true); 
								$cie_1_descripcion =  usuario_datos_consultar($row['contenido'],'cie_10','descripcion');}
if($row[id_campo]=='14'){$diagnostico_relacionado_2=wordwrap($row['contenido'],1,'</b>|<b>',true); 
								$cie_2_descripcion =  usuario_datos_consultar($row['contenido'],'cie_10','descripcion');}
if($row[id_campo]=='15'){$diagnostico_relacionado_3=wordwrap($row['contenido'],1,'</b>|<b>',true); 
								$cie_3_descripcion =  usuario_datos_consultar($row['contenido'],'cie_10','descripcion');}
if($row[id_campo]=='11'){$diagnostico_descripcion= $row['contenido'];}
						}
																	}
if($diagnostico_principal==""){$error="<img src='../images/atencion.gif' alt='[!]' title='No se ha definido un diagnóstico'>No se ha definido un diagnóstico";}
$id_empresa=mysql_result($sql,0,"id_empresa");
$empresa=mysql_query("SELECT * FROM empresa WHERE id_empresa = '$id_empresa' LIMIT 1",$link);
$razon_social=mysql_result($empresa,0,"razon_social");
$nit_empresa=mysql_result($empresa,0,"nit");
$nit_empresa=wordwrap($nit_empresa,1,'</b>|<b>',true); 
$codigo_empresa=mysql_result($empresa,0,"codigo_empresa");
$codigo_empresa=wordwrap($codigo_empresa,1,'</b>|<b>',true);
$departamento_empresa=wordwrap(mysql_result($empresa,0,"departamento"),1,'</b>|<b>',true);
$ciudad_empresa=wordwrap(mysql_result($empresa,0,"ciudad"),1,'</b>|<b>',true);
$empresa_nombre_departamento =geo_nombre_departamento(mysql_result($empresa,0,"departamento"),mysql_result($empresa,0,"ciudad"));
$empresa_nombre_ciudad =geo_nombre_ciudad(mysql_result($empresa,0,"departamento"),mysql_result($empresa,0,"ciudad"));
$direccion_empresa=mysql_result($empresa,0,"direccion");
$telefono_empresa_1=wordwrap(mysql_result($empresa,0,"telefono_1"),1,'</b>|<b>',true);
$telefono_empresa_2=wordwrap(mysql_result($empresa,0,"telefono_2"),1,'</b>|<b>',true);
$id_cliente=@mysql_result($sql,0,"id_cliente");
$cliente=mysql_query("SELECT * FROM clientes WHERE id_cliente = '$id_cliente' LIMIT 1",$link);
$cliente_codigo=wordwrap(@mysql_result($cliente,0,"codigo"),1,'</b>|<b>',true);
$cliente_razon_social=@mysql_result($cliente,0,"razon_social");
$id_usuario=mysql_result($sql,0,"id_usuario");
$usuario=mysql_query("SELECT *,documento_tipo.documento_tipo as tipo FROM d9_users, documento_tipo WHERE id = '$id_usuario' AND documento_tipo.id_documento_tipo = d9_users.documento_tipo LIMIT 1",$link);
$primer_nombre=mysql_result($usuario,0,"p_nombre");
$segundo_nombre=mysql_result($usuario,0,"s_nombre");
$primer_apellido=mysql_result($usuario,0,"p_apellido");
$segundo_apellido=mysql_result($usuario,0,"s_apellido");
$tipo_documento=mysql_result($usuario,0,"documento_tipo");
$fecha_nacimiento=wordwrap(mysql_result($usuario,0,"fecha_nacimiento"),1,'</b>|<b>',true);
$documento_numero=wordwrap(mysql_result($usuario,0,"documento_numero"),1,'</b>|<b>',true);
$departamento_usuario=wordwrap(mysql_result($usuario,0,"departamento"),1,'</b>|<b>',true);
$ciudad_usuario=wordwrap(mysql_result($usuario,0,"ciudad"),1,'</b>|<b>',true);
$usuario_nombre_departamento =geo_nombre_departamento(mysql_result($usuario,0,"departamento"),mysql_result($usuario,0,"ciudad"));
$usuario_nombre_ciudad =geo_nombre_ciudad(mysql_result($usuario,0,"departamento"),mysql_result($usuario,0,"ciudad"));
$direccion_usuario=mysql_result($usuario,0,"direccion");
$telefono_usuario=wordwrap(mysql_result($usuario,0,"telefono_fijo"),1,'</b>|<b>',true);
$tipo_usuario=mysql_result($usuario,0,"tipo_usuario");
if($tipo_usuario =='1'){$cr1='checked';}
elseif($tipo_usuario =='2'){$cr2='checked';}
elseif($tipo_usuario =='9'){$cr9='checked';}
elseif($tipo_usuario =='11'){$cr11='checked';}
elseif($tipo_usuario =='10'){$cr10='checked';}
elseif($tipo_usuario =='8'){$cr8='checked';}
elseif($tipo_usuario =='12'){$cr12='checked';}
else{$cr5='checked';}

if($tipo_documento =='1'){$t1='checked';}
elseif($tipo_documento =='2'){$t2='checked';}
elseif($tipo_documento =='3'){$t3='checked';}
elseif($tipo_documento =='4'){$t4='checked';}
elseif($tipo_documento =='5'){$t5='checked';}
elseif($tipo_documento =='6'){$t6='checked';}
elseif($tipo_documento =='7'){$t7='checked';}
else{$t8='checked';}




////cups
$consulta_cups=mysql_query("SELECT *, cups.descripcion FROM autorizaciones_procedimientos_recibidos, cups 
										WHERE control = '$ai' 
										AND autorizaciones_procedimientos_recibidos.CUPS = cups.codigo",$link);
if (mysql_num_rows($consulta_cups)!='0'){
while( $row = mysql_fetch_array( $consulta_cups ) ) {
$cups .= "<tr><td align='right' nowrap>|<b>".wordwrap($row[CUPS],1,'</b>|<b>',true)."</b>|</td nowrap><td align='right'>|<b>".wordwrap($row[cantidad],1,'</b>|<b>',true)."</b>|</td><td><u>$row[descripcion]</u></td></tr>";
															}
									}else{$error.="<img src='../images/atencion.gif' alt='[!]' title='No se ha definido CUPS'>No se ha definido CUPS";}
////fin cups
$nuevo_select .="<div align='center' name='cabecera' id='cabecera' >
						<!-- <h1>$error</h1> -->
						<div id='autorizacion_en_linea'>
						
						</div>
					</div >";
					$nuevo_select .="<div name='cabecera' id='cabecera' ><a href='#'  onclick=SoloCerrar();>[Cerrar]</a> <a href='#'  onclick=Imprimir();>[Imprimir]</a><hr></div>";
$nuevo_select .="<font face='arial'>
<table border='1' width='98%' align='center'  cellpadding='5' cellspacing='0' border='1' style='border-color: #000000; border-style: solid; border-width: 1; '  >
	<tr>
		<td>
		<img src='../images/escudo_colombia.jpg' border='0' alt='' align='left'>
		<div align='center'>
		
		<b>MINISTERIO DE LA PROTECCION SOCIAL<BR>
		AUTORIZACION DE SERVICIOS DE SALUD
		</b>
		<BR><div align='center'>NUMERO AUTORIZACION: <b>$id_registro</b></div> <div align='right'>FECHA:<b> $fecha_registro</b> HORA:<b> $hora_registro </b></div>
		
		
		</div>
	</td>
</tr>
<tr>
	<td>
		
	
		<b><div align='center'>INFORMACION DEL PRESTADOR:</div></b>
		<table width='100%' border='0'>
			<tr>
			<td>Nombre:
			</td>
			<td>NIT<input type='checkbox'  readonly disabled='true' checked > 
			</td>
			<td><b>$nit_empresa</b>
			</td>
			</tr>
			<tr>
			<td><b>$razon_social</b>
			</td border='1'>
			<td>CC<input type='checkbox'  readonly disabled='true'> 
			</td>
			<td>Número
			</td>
			</tr>
		</table>
 		<hr>
 		<table  width='100%' align='center'  cellpadding='0' cellspacing='0' border='1' style='border-color: #000000; border-style: solid; border-width: 1; '  >
 		<tr>
 			<td><font size='-1'>Código</font>
 			</td>
 			<td  colspan='2'>|<b>$codigo_empresa</b>|
 			</td>
 			<td  colspan='2'><font size='-1'>Dirección prestador:</font>
 			</td>
 		</tr>
 		<tr>
 			<td span='2'><div align='center'><font size='-1'>Teléfono</font></div>
 			</td>
 			<td><div align='center'>|<b>$indicativo_empresa</b>|</div>
 			</td>
 			<td><div align='center'>|<b>$telefono_empresa_1</b>|</div>
 			</td>
 			<td  colspan='2'><b>$direccion_empresa</b>
 			</td>
 		</tr>
 		<tr>
 			<td><font size='-2'><div align='center'>Indicativo</div></font>
 			</td>
 			<td><font size='-2'><div align='center'>Teléfono</div></font>
 			</td>
 			<td align='right'><font size='-1'>Departamento: </font>$empresa_nombre_departamento |<b>$departamento_empresa</b>|
 			</td>
 			<td align='right'><font size='-1'>Municipio: </font> $empresa_nombre_ciudad |<b>$ciudad_empresa</b>|
 			</td>
 		</tr>
 		<tr>
 			<td colspan='4'><font size='-2'>Entidad a la que se le informa: </font><b>$cliente_razon_social</b>
 			</td>
 			<td align='right' ><font size='-1'>CODIGO:</font>|<b>$cliente_codigo</b>|
 			</td>
 		</tr>
 		</table>
		
		 
	</td>
</tr>

<tr>
	<td>
	<div align='center'><b>DATOS DEL PACIENTE</b></div>
	<table border='1' width='100%' align='center'  cellpadding='0' cellspacing='0' border='1' style='border-color: #000000; border-style: solid; border-width: 1; '  >
	<tr align='center'><td><b>$primer_apellido</b></td><td><b>$segundo_apellido</b></td><td><b>$primer_nombre</b></td><td><b>$segundo_nombre</b></td></tr>
	<tr align='center'><td><font size='-1'><font size='-2'>Primer Apellido</DIV></font></td><td><font size='-2'>Segundo Apellido</font></td><td><font size='-2'>Primer Nombre</font></td><td><font size='-2'>Segundo Nombre</font></td></tr>

	</table><b>Tipo documento de Identificación:</b>
	<table border='0'  width='90%'>
	<tr valign='top'>
		<td >
		<input type='checkbox' disabled='true' $t4 > Registro Civil
	<br><input type='checkbox' disabled='true' $t5 > Tarjeta de identidad
	<br><input type='checkbox' disabled='true' $t1 > Cédula de ciudadanía
	<br><input type='checkbox' disabled='true' $t2 > Cédula de extranjería
		</td>
		<td>
		<input type='checkbox' disabled='true' $t3 > Pasaporte
	<br><input type='checkbox' disabled='true' $t6 > Adulto sin identificación
	<br><input type='checkbox' disabled='true' $t7 > Menor sin identificación
		</td>
		<td valign='bottom'>
		<div align='right'>|<b>$documento_numero</b>|<br>
		<font size='-2'>Número documento de identificación</font>
		<br><br>Fecha de nacimiento: |<b>$fecha_nacimiento</b>|</div>
		</td>
	</tr>
	</table><hr>
	<table width='100%' border='0'>
	<tr>
		<td>Dirección de Residencia Habitual: <b>$direccion_usuario</b>
		</td>
		<td align='right'>Telefono: |<b>$telefono_usuario</b>|
		</td>
	</tr>
	<tr>
		<td>Departamento: $usuario_nombre_departamento |<b>$departamento_usuario</b>|
		</td>
		<td align='right'>Municipio: $usuario_nombre_ciudad  |<b>$ciudad_usuario</b>|
		</td>
	</tr>
	</table>
	
	<hr>
	<b>Cobertura en salud</b>
	<table border='0'  width='90%'>
	<tr valign='top'>
		<td >
		<input type='checkbox' disabled='true' $cr1 > Regimen contributivo
	<br><input type='checkbox' disabled='true' $cr2 > Regimen subsidiado - total

		</td>
		<td>
		<input type='checkbox' disabled='true' $cr9 > Regimen subsidiado - parcial
		<br><input type='checkbox' disabled='true' $r11 > Población pobre no asegurada con SISBEN
	
		</td>
		<td>
		<input type='checkbox' disabled='true' $cr10 > Población pobre no asegurada sin SISBEN
	<br><input type='checkbox' disabled='true' $cr8 > Desplazado
	
		</td>
		<td>
		<input type='checkbox' disabled='true' $cr12 > Plan adicional de salud
	<br><input type='checkbox' disabled='true' $cr5 > Otro
	
		</td>
		
	</tr>
	</table>
</td>
</tr>
<tr>
	<td>
	<div align='center'><b>SERVICIOS AUTORIZADOS</b></div><hr>
	
	
	<b>Ubicación del Paciente en el momento de la solicitud de autorización:</b><br>
	
	<table border='0' width='100%'>
	<tr valign='top'>
		<td >
		
		<input type='checkbox' disabled='true' $up1 ><font size='-1'> Consulta externa</font> 
		<br><input type='checkbox' disabled='true' $up2 ><font size='-1'> Urgencias</font>
	
		</td>
		<td align='right'> <input type='checkbox' disabled='true' $up3 ><font size='-1'> Hospitalización</font> 
		</td>
		<td align='right'><font size='-1'><b> Servicio </b></font> $ubicacion_servicio <font size='-1'><b> Cama </b></font> |<b>$ubicacion_cama</b>|
		</td>
	</tr>
	
	</table>
	<hr> 
	
	<b><font size='-1'>Manejo Integral según Guía:</font></b> $guia
	
	<Hr>
	<table cellpadding='5' cellspacing='0' border='0'  width='90%' align='center'>
	<tr valign='top'>
		<td><font size='-2'>Código CUPS</font></td>
		<td><font size='-2'>Cantidad</font></td>
		<td width='100%'><font size='-2'>Descripción</font></td>
	</tr>
	$cups
	</table>
	<hr>
	$pagos
	
	</td>
</tr>
<tr>
	<td><div align='center'><b>DATOS DE LA PERSONA QUE INFORMA</b></div>
	<table width='100%' border='0'>
	<tr>
		<td>
			<font size='-1'>Nombre de quien informa:</font>
		</TD>
		<TD align='right'></td>
	</tr>
	<tr>
		<td><b>$nombre_completo_funcionario</b>
		</td>
		<td>Teléfono:  Indicativo |<b>$telefono_indicativo_autoriza</b> Número |<b>$telefono_numero_autoriza</b>| Extención|<b>$telefono_extencion_autoriza</b>|<br>Telefono celular: |<b>$telefono_celular_autoriza </b>|
		</td>
	</tr>
	<tr>
		<td><font size='-1'>Cargo o actividad:</font> <b>$cargo_funcionario</b>
		</td>
		<td align='right'>
		</td>
	</tr>
	</table>
	
	</td>
</tr>
<tr>
	<td>		
		</b>
		</td>
	</tr>
</table>";

	$nuevo_select .= "<font size='-2'> << REFERENCIA: $ai >> </font>";
	}									}else { $nuevo_select .= "
	<div align='center'>
	<br><br>
	<img src='../images/atencion.gif' alt='[!]'><br> <br> <h1>El Documento solicitado no existe!</h2>
	<br>
	

</div>

";}

//$respuesta->addAssign("capa_dummy","innerHTML",$nuevo_select);
return $nuevo_select;
} 
//$xajax->registerFunction("atencion_inicial_consulta");



?>
<font>
Un proyecto de: <a href='http://opuslibertati.org'>http://opuslibertati.org</a>&nvsp;-&nvsp;
Powered by: <a href='http://GaleNUx.com'>http://GaleNUx.com</a></font>
</body></html><?php
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
