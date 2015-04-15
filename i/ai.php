<?php session_start(); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Un Proyecto De: http://opuslibertati.org - Powered by GaleNUx</title>
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
<div name='cabecera' id='cabecera' ></div>
<?php 
include_once("../librerias/conex_anonimo.php"); 


$ai=$_REQUEST['r'];
$pin=$_POST['pin'];
$formulario = informe_atencion_inicial($ai,"listado",$pin);

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

function informe_atencion_inicial($ai,$tipo,$pin){
//creo el xajaxResponse para generar una salida
//$respuesta = new xajaxResponse('utf-8');
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");

$sql=mysql_query("SELECT * FROM atencion_inicial WHERE control = '$ai' LIMIT 1",$link);
if (mysql_num_rows($sql)!='0') {

$pin_id =mysql_result($sql,0,"pin");

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
$id_registro=wordwrap(mysql_result($sql,0,"consecutivo"),1,'</b>|<b>',true);
$fecha_registro=mysql_result($sql,0,"timestamp_atencion");
$fecha_registro=wordwrap(date("Y-m-d ",$fecha_registro),1,'</b>|<b>',true);
$hora_registro=mysql_result($sql,0,"timestamp_atencion");
$hora_registro=wordwrap(date("H:i ",$hora_registro),1,'</b>|<b>',true);
$remitido=mysql_result($sql,0,"remitido");
if($remitido=='1'){$r1='checked'; $r0=''; $remitido_codigo_entidad=wordwrap(mysql_result($sql,0,"remitido_codigo_entidad"),1,'</b>|<b>',true);
$remitido_nombre_entidad=mysql_result($sql,0,"remitido_nombre_entidad"); 
$remitido_departamento=wordwrap(mysql_result($sql,0,"cod_departamento"),1,'</b>|<b>',true);
$remitido_ciudad=wordwrap(mysql_result($sql,0,"cod_ciudad"),1,'</b>|<b>',true);
//mysql_result($sql,0,"cod_departamento"),mysql_result($sql,0,"cod_ciudad")
$remitido_cod_departamento=mysql_result($sql,0,"cod_departamento");
$remitido_cod_ciudad=mysql_result($sql,0,"cod_ciudad");
$remitido_nombre_departamento =geo_nombre_departamento("$remitido_cod_departamento","$remitido_cod_ciudad");
$remitido_nombre_ciudad =geo_nombre_ciudad("$remitido_cod_departamento","$remitido_cod_ciudad"); 
}else{$r0='checked';$r1='';

 }



$accidente_de_transito=mysql_result($sql,0,"accidente_de_transito");
if($accidente_de_transito=='1'){$at='checked';}
$clasificacion=mysql_result($sql,0,"clasificacion");
if($clasificacion=='1'){$c1='checked';}
elseif($clasificacion=='2'){$c2='checked';}
elseif($clasificacion=='3'){$c3='checked';}
else{}
$origen_de_la_atencion=mysql_result($sql,0,"origen_de_la_atencion");
if($origen_de_la_atencion=='1'){$o1='checked';}
elseif($origen_de_la_atencion=='2'){$o2='checked';}
elseif($origen_de_la_atencion=='3'){$o3='checked';}
elseif($origen_de_la_atencion=='4'){$o4='checked';}
else{}
$destino=mysql_result($sql,0,"destino");
if($destino =='0'){$d0 = "checked";}
elseif ($destino =='1'){$d1 = "checked";}
elseif ($destino =='2'){$d2 = "checked";}
elseif ($destino =='3'){$d3 = "checked";}
elseif ($destino =='4'){$d4 = "checked";}
elseif ($destino ==''){}
else {$d5 = "checked";}
$consulta_datos=mysql_query("SELECT id_consulta_datos, id_campo, contenido FROM consulta_datos WHERE control = '$ai' AND consulta_datos.perfil = '4'",$link);

while( $row = mysql_fetch_array( $consulta_datos ) ) {
$id_consulta_datos=$row['id_consulta_datos'];
$consulta_especialista ="SELECT consulta_datos.id_especialista, d9_users.id_grupo 
									FROM	consulta_datos, d9_users 
									WHERE consulta_datos.id_consulta_datos = '$id_consulta_datos' 
									AND consulta_datos.id_especialista = d9_users.id
									";
$grupo_especialista = mysql_query($consulta_especialista,$link);
$grupo_especialista=mysql_result($grupo_especialista,0,"id_grupo");

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
					

$id_empresa=mysql_result($sql,0,"id_empresa");
$empresa=mysql_query("SELECT * FROM empresa WHERE id_empresa = '$id_empresa' LIMIT 1",$link);
$razon_social=mysql_result($empresa,0,"razon_social");
$nit_empresa=mysql_result($empresa,0,"nit");
$nit_empresa=wordwrap($nit_empresa,1,'</b>|<b>',true); 
$codigo_empresa=mysql_result($empresa,0,"codigo_empresa");
$codigo_empresa=wordwrap($codigo_empresa,1,'</b>|<b>',true);
$departamento_empresa=wordwrap(mysql_result($empresa,0,"departamento"),1,'</b>|<b>',true);

$empresa_nombre_departamento =geo_nombre_departamento(mysql_result($empresa,0,"departamento"),mysql_result($empresa,0,"ciudad"));
$empresa_nombre_ciudad =geo_nombre_ciudad(mysql_result($empresa,0,"departamento"),mysql_result($empresa,0,"ciudad"));

$ciudad_empresa=wordwrap(mysql_result($empresa,0,"ciudad"),1,'</b>|<b>',true);
$direccion_empresa=mysql_result($empresa,0,"direccion");
$telefono_empresa_1=wordwrap(mysql_result($empresa,0,"telefono_1"),1,'</b>|<b>',true);
$telefono_empresa_2=wordwrap(mysql_result($empresa,0,"telefono_2"),1,'</b>|<b>',true);
//$id_cliente=mysql_result($sql,0,"id_cliente");
$destino_observacon=mysql_result($sql,0,"destino_observacion");
//$cliente=mysql_query("SELECT * FROM clientes WHERE id_cliente = '$id_cliente' LIMIT 1",$link);
//$cliente_codigo=wordwrap(mysql_result($cliente,0,"codigo"),1,'</b>|<b>',true);
//$cliente_razon_social=mysql_result($cliente,0,"razon_social");
$id_usuario=mysql_result($sql,0,"id_usuario");

$clasificacion=mysql_result($sql,0,"clasificacion");
$usuario=mysql_query("SELECT *,documento_tipo.documento_tipo as tipo FROM d9_users, documento_tipo WHERE id = '$id_usuario' AND documento_tipo.id_documento_tipo = d9_users.documento_tipo LIMIT 1",$link);
$id_cliente=mysql_result($usuario,0,"id_cliente");
$cliente=mysql_query("SELECT * FROM clientes WHERE id_cliente = '$id_cliente' LIMIT 1",$link);
$cliente_codigo=wordwrap(mysql_result($cliente,0,"codigo"),1,'</b>|<b>',true);
$cliente_razon_social=mysql_result($cliente,0,"razon_social");
$primer_nombre=mysql_result($usuario,0,"p_nombre");
$segundo_nombre=mysql_result($usuario,0,"s_nombre");
$primer_apellido=mysql_result($usuario,0,"p_apellido");
$segundo_apellido=mysql_result($usuario,0,"s_apellido");
$tipo_documento=mysql_result($usuario,0,"documento_tipo");
$fecha_nacimiento=wordwrap(mysql_result($usuario,0,"fecha_nacimiento"),1,'</b>|<b>',true);
$documento_numero=wordwrap(mysql_result($usuario,0,"documento_numero"),1,'</b>|<b>',true);
$departamento_usuario=wordwrap(mysql_result($usuario,0,"departamento"),1,'</b>|<b>',true);

$usuario_nombre_departamento =geo_nombre_departamento(mysql_result($usuario,0,"departamento"),mysql_result($empresa,0,"ciudad"));
$usuario_nombre_ciudad =geo_nombre_ciudad(mysql_result($usuario,0,"departamento"),mysql_result($empresa,0,"ciudad"));

$ciudad_usuario=wordwrap(mysql_result($usuario,0,"ciudad"),1,'</b>|<b>',true);
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


$id_funcionario=mysql_result($sql,0,"id_funcionario");
$funcionario=mysql_query("SELECT * FROM d9_users WHERE id = '$id_funcionario' LIMIT 1",$link);
$nombre_completo_funcionario=mysql_result($funcionario,0,"nombre_completo");
$cargo_funcionario=mysql_result($funcionario,0,"cargo");
$nuevo_select .="<div name='cabecera' id='cabecera' ><a href='#'  onclick=SoloCerrar();>[Cerrar]</a> <a href='#'  onclick=Imprimir();>[Imprimir]</a><hr></div>";
$nuevo_select .="<font face='arial'>
<table border='1' width='98%' align='center'  cellpadding='5' cellspacing='0' border='1' style='border-color: #000000; border-style: solid; border-width: 1; '  >
	<tr>
		<td>
		<img src='../images/escudo_colombia.jpg' border='0' alt='' align='left'>
		<div align='center'>
		
		<b>MINISTERIO DE LA PROTECCION SOCIAL<BR>
		INFORME DE LA ATENCION INICIAL DE URGENCIAS
		</b>
		<BR><div align='center'>NUMERO DE LA ATENCION: <b>$id_registro</b></div> <div align='right'>FECHA:<b> $fecha_registro</b> HORA:<b> $hora_registro </b></div>
		
		
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
 			<td align='right'><font size='-1'>Departamento:$empresa_nombre_departamento</font> |<b>$departamento_empresa</b>|
 			</td>
 			<td align='right'><font size='-1'>Municipio:$empresa_nombre_ciudad</font> |<b>$ciudad_empresa</b>|
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
		<td>Departamento: $usuario_nombre_departamento|<b>$departamento_usuario</b>|
		</td>
		<td align='right'>Municipio:$usuario_nombre_ciudad |<b>$ciudad_usuario</b>|
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
	<b><div align='center'>INFORMACIÓN DE LA ATENCIÓN</div></b>
	<b>Orígen de la atención</b>
	<table border='0' width='100%'> 
	<tr valign='top'>
		<td>
			<input type='checkbox' disabled='true' $o1 >Enfermedad general
			<br><input type='checkbox' disabled='true' $o4 >Enfermedad profesional 
			
		</td>
		<td><input type='checkbox' disabled='true' $o2 >Accidente de trabajo
		<br><input type='checkbox' disabled='true' $at >Accidente de tránsito
		</td>
		<td><input type='checkbox' disabled='true' $o3 >Evento catastrófico
		</td>
		<td align='right' valign='top'>Triage</td>
		<td><input type='checkbox' disabled='true' $c1 > 1. Rojo
		<br><input type='checkbox' disabled='true' $c2 > 2. Amarillo
		<br><input type='checkbox' disabled='true' $c3 > 3. Verde
			
		</td>
	</tr>
	
	</table>
	<hr>
	<b>Ingreso a Urgencias</b><br>
	Fecha: |<b>$fecha_registro</b> Hora: |<b>$hora_registro</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	Paciente viene remitido <input type='checkbox' disabled='true' $r1 >SI <input type='checkbox' disabled='true' $r0 >NO
	<table border='0' width='100%'>
	<tr>
		<td><font size='-1'>Nombre del prestador de servicios que remite: </font>
	<b>$remitido_nombre_entidad</b>
		</td>
		<td align='right'> Código: |<b>$remitido_codigo_entidad</b>|
		</td>
	</tr>
	<tr>
		<td>Departamento: $remitido_nombre_departamento |<b>$remitido_departamento</b>|
		</td>
		<td align='right'>Municipio: $remitido_nombre_ciudad |<b>$remitido_ciudad</b>|
		</td>
	</tr>
	</table>
	<hr> 
		
	Motivo de consulta:
	<b>$motivo_consulta</b>
	<Hr>
	
	<table border='0' width='100%' align='center'  cellpadding='0' cellspacing='0' border='0'  >
	<tr>
		<td><b>Impresión diagnóstica</b></td>
		<td align='right'><font size='-2'>CIE10</font></td>
		<td width='80%'><div align='center'><b>Descripción:</b></div></td>
	</tr>
	<tr>
		<td align='right'><font size='-1'>Diagnóstico principal
		</td>
		<td align='right'>|<b>$diagnostico_principal</b>|
		</td>
		<td valign='top'> <div > $cie_0_descripcion </div>
		</td>
	</tr>	
	<tr>
		<td nowrap  align='right'><font size='-1'>Diagnóstico relacionado 1
		</td>
		<td align='right'>
		|<b>$diagnostico_relacionado_1</b>|
		</td>
		<td valign='top'> <div > $cie_1_descripcion </div>
		</td>
	</tr>	
	<tr>
		<td  align='right'><font size='-1'>Diagnóstico relacionado 2
		</td>
		<td align='right'>
		|<b>$diagnostico_relacionado_2</b>|
		</td>
		<td valign='top'> <div > $cie_2_descripcion </div>
		</td>
	</tr>	
	<tr>
		<td  align='right'><font size='-1'>Diagnóstico relacionado 3
		</td>
		<td align='right'>
		|<b>$diagnostico_relacionado_3</b>|
		</td>
		<td valign='top'> <div > $cie_3_descripcion </div>
		</td>
	</tr>

	</table>
	
	<hr>
	<b>Destino del paciente:</b> 	
	<table border='0' width='100%'>
		<tr>
			<td><input type='checkbox' disabled='true' $d0 > Domicilio
			<br><input type='checkbox' disabled='true' $d3 > Observación
			</td>
			<td><input type='checkbox' disabled='true' $d1 > Internación
			<br><input type='checkbox' disabled='true' $d4 > Remisión
			</td>
			<td><input type='checkbox' disabled='true' $d2 > Contraremisión
			<br><input type='checkbox' disabled='true' $d5 > Otro
			</td>
		</tr>
	</table>
	
	</td>
</tr>
<tr>
	<td><div align='center'><b>DATOS DE LA PERSONA QUE INFORMA</b></div>
	<table width='100%' border='0'>
	<tr>
		<td>
			<font size='-1'>Nombre de quien informa:</font>
		</TD>
		<TD align='right'>Teléfono |<b>$telefono_empresa_1</b>|</td>
	</tr>
	<tr>
		<td><b>$nombre_completo_funcionario</b>
		</td>
		<td>
		</td>
	</tr>
	<tr>
		<td><font size='-1'>Cargo o actividad:</font> <b>$cargo_funcionario</b>
		</td>
		<td align='right'>Telefono celular: |<b>$telefono_empresa_2</b>|
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

function usuario_datos_consultar($id,$tipo,$campo){
$link=Conectarse(); 
if($tipo == 'usuario'){$tabla= 'd9_users'; $clave ='id'; $w = "LIMIT 1"; }
elseif($tipo == 'cliente'){$tabla= 'clientes'; $clave ='id_cliente'; $w = "LIMIT 1";}
elseif($tipo == 'cie_10'){$tabla= 'cie_10'; $clave ='codigo'; $w = "LIMIT 1";}
elseif($tipo == 'turnos_usuario'){$tabla= 'turnos'; $clave ='id_turno'; $w = "LIMIT 1";}
elseif($tipo == 'atencion_inicial'){$tabla= 'atencion_inicial'; $clave ='id_atencion_inicial'; $w = "LIMIT 1";}
elseif($tipo == 'inconsistencias'){$tabla= 'inconsistencias'; $clave ='id_inconsistencia'; $w = "LIMIT 1";}
elseif($tipo == 'consultas_referencia'){$tabla= 'atencion_inicial'; $clave ='id_usuario'; $w ='ORDER BY `timestamp_atencion` DESC'; $lista ='1'; $campo ='*'; $nombre_select="control";}
else{}
mysql_query("SET NAMES 'utf8'");
$consulta = "SELECT $campo FROM $tabla WHERE $clave = '$id' $w ";
$sql=mysql_query($consulta,$link);

if (mysql_num_rows($sql)!='0'){
if($lista =='1'){$resultado .= "<select name='$nombre_select'>";}
while( $row = mysql_fetch_array( $sql ) ) {
if($lista !='1'){
$resultado .= $row[$campo] ;
					 }else{/// si se pide una lista se dan los valores del select
					 	$resultado .= "<option value='$row[control]'>".date('Y-m-d G:i',$row[timestamp_atencion])."</option>";
					 			}
														}
									}else {
												if($lista !='1'){$resultado= "[$id]";}
												else{/// si se pide una lista se dan los valores del select
					 	$resultado .= "<img src='images/atencion.gif' alt='[!]' title='Opss! No hay información sobre $tabla'> Opss! No hay información sobre $tabla ";
					 									} return $resultado;
if($lista =='1'){$resultado .="</select>";}
					 						}

return $resultado;

																 }

pie_imprenta_anonimo();
?>
<hr><font>
Un proyecto de: <a href='http://opuslibertati.org'>http://opuslibertati.org</a> - 
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
