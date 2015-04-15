<?php session_start(); ?>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../estilos/estilo.css" rel="stylesheet" type="text/css">
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
include_once("../librerias/conex_anonimo.php"); 
$ai=$_REQUEST['r'];
$pin=$_POST['pin'];
$formulario = informe_inconsistencia($ai,"listado",$pin);

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
function informe_inconsistencia($ai,$tipo,$pin){
//creo el xajaxResponse para generar una salida
//$respuesta = new xajaxResponse('utf-8');
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");

$sql=mysql_query("SELECT *, d9_users.id FROM inconsistencias, d9_users WHERE inconsistencias.control = '$ai'  AND d9_users.id = inconsistencias.id_usuario LIMIT 1",$link);



if (@mysql_num_rows($sql)!='0'){
$pin_id =mysql_result($sql,0,"pin");
if ($pin!=$pin_id){$nuevo_select .= "
	<div align='center'>
	<br><br>
	<img src='../images/atencion.gif' alt='[!]'><br> <br> <h2>El PIN <font  COLOR='RED'>$pin</font> no  corresponde al documento solicitado!</h2>
	<br>
	<form method='post' name='pin' id='pin'>
	PIN: <input type='text' value='' name='pin' size='10' title='Escriba el PIN que se le envió por correo y oprima ENTER'>
	<input type='hidden' value='$ai' name='r' size='10'><BR>	<font size='-1' COLOR='RED'>Escriba el PIN que se le envió por <b>correo</b> y oprima ENTER</font>
	</form>

</div>

";}else{
$id_registro=wordwrap(mysql_result($sql,0,"consecutivo"),1,'</b><b>',true);
$fecha_registro=mysql_result($sql,0,"timestamp_inconsistencia");
$fecha_registro=wordwrap(date("Y-m-d ",$fecha_registro),1,'</b><b>',true);
$hora_registro=mysql_result($sql,0,"timestamp_inconsistencia");
$hora_registro=wordwrap(date("H:i ",$hora_registro),1,'</b><b>',true);

$inconsistencia_tipo=mysql_result($sql,0,"inconsistencia_tipo");
if ($inconsistencia_tipo =='0'){
	$inconsistencia_tipo ="<input type='checkbox' checked disabled='true'> El usuario no existe en la base de datos
								<br><input type='checkbox'  readonly disabled='true'>Los datos del usuario no corresponden con los del documento de identidad presentado";
										}
elseif($inconsistencia_tipo =='1'){
$inconsistencia_tipo ="<input type='checkbox'  disabled='true'> El usuario no existe en la base de datos
								<br><input type='checkbox' checked  disabled='true'>Los datos del usuario no corresponden con los del documento de identidad presentado";				
											}
$primer_nombre_errado=mysql_result($sql,0,"primer_nombre");
$segundo_nombre_errado=mysql_result($sql,0,"segundo_nombre");
$primer_apellido_errado=mysql_result($sql,0,"primer_apellido");
$segundo_apellido_errado=mysql_result($sql,0,"segundo_apellido");
$tipo_documento_errado=mysql_result($sql,0,"tipo_documento");
if($tipo_documento_errado =='1'){$t1='checked';}
elseif($tipo_documento_errado =='2'){$t2='checked';}
elseif($tipo_documento_errado =='3'){$t3='checked';}
elseif($tipo_documento_errado =='4'){$t4='checked';}
elseif($tipo_documento_errado =='5'){$t5='checked';}
elseif($tipo_documento_errado =='6'){$t6='checked';}
elseif($tipo_documento_errado =='7'){$t7='checked';}
else{$t8='checked';}
$numero_documento_errado=mysql_result($sql,0,"numero_documento");
$numero_documento_errado=wordwrap($numero_documento_errado,1,'</b><b>',true);
$fecha_nacimiento_errada=mysql_result($sql,0,"fecha_nacimiento");
$fecha_nacimiento_errada=wordwrap($fecha_nacimiento_errada,1,'</b><b>',true);

if(mysql_result($sql,0,"correccion_primer_apellido")=='1'){$v1='checked';}
if(mysql_result($sql,0,"correccion_segundo_apellido")=='1'){$v2='checked';}
if(mysql_result($sql,0,"correccion_primer_nombre")=='1'){$v3='checked';}
if(mysql_result($sql,0,"correccion_segundo_nombre")=='1'){$v4='checked';}
if(mysql_result($sql,0,"correccion_tipo_documento")=='1'){$v5='checked';}
if(mysql_result($sql,0,"correccion_numero_documento")=='1'){$v6='checked';}
if(mysql_result($sql,0,"correccion_fecha_nacimiento")=='1'){$v7='checked';}
$id_empresa=mysql_result($sql,0,"id_empresa");
$empresa=mysql_query("SELECT * FROM empresa WHERE id_empresa = '$id_empresa' LIMIT 1",$link);
$razon_social=mysql_result($empresa,0,"razon_social");
$nit_empresa=mysql_result($empresa,0,"nit");
$nit_empresa=wordwrap($nit_empresa,1,'</b><b>',true); 
$codigo_empresa=mysql_result($empresa,0,"codigo_empresa");
$codigo_empresa=wordwrap($codigo_empresa,1,'</b><b>',true);
$departamento_empresa=wordwrap(mysql_result($empresa,0,"departamento"),1,'</b><b>',true);
$ciudad_empresa=wordwrap(mysql_result($empresa,0,"ciudad"),1,'</b><b>',true);
$empresa_nombre_departamento =geo_nombre_departamento(mysql_result($empresa,0,"departamento"),mysql_result($empresa,0,"ciudad"));
$empresa_nombre_ciudad =geo_nombre_ciudad(mysql_result($empresa,0,"departamento"),mysql_result($empresa,0,"ciudad"));
$direccion_empresa=mysql_result($empresa,0,"direccion");
$telefono_empresa_1=wordwrap(mysql_result($empresa,0,"telefono_1"),1,'</b><b>',true);
$telefono_empresa_2=wordwrap(mysql_result($empresa,0,"telefono_2"),1,'</b><b>',true);
$id_cliente=mysql_result($sql,0,"id_cliente");
$observaciones=mysql_result($sql,0,"observaciones");
$cliente=mysql_query("SELECT * FROM clientes WHERE id_cliente = '$id_cliente' LIMIT 1",$link);
$cliente_codigo=mysql_result($cliente,0,"codigo");
$cliente_razon_social=mysql_result($cliente,0,"razon_social");
$id_usuario=mysql_result($sql,0,"id_usuario");
$usuario=mysql_query("SELECT *,documento_tipo.documento_tipo as tipo FROM d9_users, documento_tipo WHERE id = '$id_usuario' AND documento_tipo.id_documento_tipo = d9_users.documento_tipo LIMIT 1",$link);
$primer_nombre=wordwrap(mysql_result($usuario,0,"p_nombre"),1,'</b><b>',true);
$segundo_nombre=wordwrap(mysql_result($usuario,0,"s_nombre"),1,'</b><b>',true);
$primer_apellido=wordwrap(mysql_result($usuario,0,"p_apellido"),1,'</b><b>',true);
$segundo_apellido=wordwrap(mysql_result($usuario,0,"s_apellido"),1,'</b><b>',true);
$documento_tipo=wordwrap(mysql_result($usuario,0,"tipo"),1,'</b><b>',true);
$fecha_nacimiento=wordwrap(mysql_result($usuario,0,"fecha_nacimiento"),1,'</b><b>',true);
$documento_numero=wordwrap(mysql_result($usuario,0,"documento_numero"),1,'</b><b>',true);
$departamento_usuario=wordwrap(mysql_result($usuario,0,"departamento"),1,'</b><b>',true);
$usuario_nombre_departamento =geo_nombre_departamento(mysql_result($empresa,0,"departamento"),mysql_result($empresa,0,"ciudad"));
$usuario_nombre_ciudad =geo_nombre_ciudad(mysql_result($empresa,0,"departamento"),mysql_result($empresa,0,"ciudad"));
$ciudad_usuario=wordwrap(mysql_result($usuario,0,"ciudad"),1,'</b><b>',true);
$direccion_usuario=mysql_result($usuario,0,"direccion");
$telefono_usuario=wordwrap(mysql_result($usuario,0,"telefono_fijo"),1,'</b><b>',true);
$tipo_usuario=mysql_result($usuario,0,"tipo_usuario");
if($tipo_usuario =='1'){$r1='checked';}
elseif($tipo_usuario =='2'){$r2='checked';}
elseif($tipo_usuario =='9'){$r9='checked';}
elseif($tipo_usuario =='11'){$r11='checked';}
elseif($tipo_usuario =='10'){$r10='checked';}
elseif($tipo_usuario =='8'){$r8='checked';}
elseif($tipo_usuario =='12'){$r12='checked';}
else{$r5='checked';}


$id_funcionario=mysql_result($sql,0,"id_funcionario");
$funcionario=mysql_query("SELECT * FROM d9_users WHERE id = '$id_funcionario' LIMIT 1",$link);
$nombre_completo_funcionario=mysql_result($funcionario,0,"nombre_completo");
$cargo_funcionario=mysql_result($funcionario,0,"cargo");
$nuevo_select .="<div name='cabecera' id='cabecera' ><a href='#'  onclick=SoloCerrar();>[Cerrar]</a> <a href='#'  onclick=Imprimir();>[Imprimir]</a><hr></div>";
$nuevo_select .="<font face='arial'>
<table border='1' width='98%' align='center'  cellpadding='5' cellspacing='0' border='1' style='border-color: #000000; border-style: solid; border-width: 1; '  >
	<tr>
		<td><font size=2>
		<img src='../images/escudo_colombia.jpg' border='0' alt='' align='left'>
		<div align='center'>
		
		<b>MINISTERIO DE LA PROTECCION SOCIAL<BR>
		INFORME DE POSIBLES INCONSISTENCIAS EN LA BASE DE DATOS DE LA ENTIDAD RESPONSABLE DEL PAGO
		</b>
		<BR><div align='center'>NUMERO DE INFORME: <b>$id_registro</b></div> <div align='right'>FECHA:<b> $fecha_registro</b> HORA:<b> $hora_registro </b></div>
		
		
		</div>
	</td>
</tr>
<tr>
	<td>
		
	
		<b><font size=2><div align='center'>INFORMACION DEL PRESTADOR:</div></b>
		<table width='100%' border='0'>
			<tr>
			<td><font size=2>Nombre:
			</td>
			<td><font size=2>NIT<input type='checkbox'  readonly disabled='true' checked > 
			</td>
			<td><font size=2><b>$nit_empresa</b>
			</td>
			</tr>
			<tr>
			<td><font size=2><b>$razon_social</b>
			</td border='1'>
			<td><font size=2>CC<input type='checkbox'  readonly disabled='true'> 
			</td>
			<td><font size=2>Número
			</td>
			</tr>
		</table>
 		<hr>
 		<table width='100%' align='center'  cellpadding='0' cellspacing='0' border='1' style='border-color: #000000; border-style: solid; border-width: 1; '  >
 		<tr>
 			<td><font size='1'>Código</font>
 			</td>
 			<td  colspan='2'><font size=1><b>$codigo_empresa</b>
 			</td>
 			<td  colspan='2'><font size='1'>Dirección prestador:</font>
 			</td>
 		</tr>
 		<tr>
 			<td span='2'><div align='center'><font size='1'>Teléfono</font></div>
 			</td>
 			<td><div align='center'><font size=1><b>$indicativo_empresa</b></div>
 			</td>
 			<td><div align='center'><font size=1><b>$telefono_empresa_1</b></div>
 			</td>
 			<td  colspan='2'><font size=1><b>$direccion_empresa</b>
 			</td>
 		</tr>
 		<tr>
 			<td><font size='1'><div align='center'>Indicativo</div></font>
 			</td>
 			<td><font size='1'><div align='center'>Teléfono</div></font>
 			</td>
 			<td align='right'><font size='1'>Departamento: $empresa_nombre_departamento <b>$departamento_empresa</b>
 			</td>
 			<td align='right'><font size='1'>Municipio: $empresa_nombre_ciudad <b>$ciudad_empresa</b>
 			</td>
 		</tr>
 		<tr>
 			<td colspan='4'><font size=2>Entidad a la que se le informa: (PAGADOR)<b> $cliente_razon_social</b>
 			</td>
 			<td align='right' ><font size='2'>CODIGO: <b>$cliente_codigo</b>
 			</td>
 		</tr>
 		</table>
		
		 
	</td>
</tr>
<tr>
	<td>
	<table border='0'>
		<tr>
			<td><font size='2'>
			Tipo de inconsistencia:
			</td>
			<td><font size='1'>
			$inconsistencia_tipo
			</td>
		</tr>

</table>
	</td>
</tr>
<tr>
	<td>
	<div align='center'><font size='2'><b>DATOS DEL USUARIO</b> (Como aparece en la base de datos)</div>
	<table border='1' width='100%' align='center'  cellpadding='0' cellspacing='0' border='1' style='border-color: #000000; border-style: solid; border-width: 1; '  >
	<tr align='center'><td><b><font size='1'>$primer_apellido_errado</b></td><td><b><font size='1'>$segundo_apellido_errado</b></td><td><b><font size='1'>$primer_nombre_errado</b></td><td><b><font size='1'>$segundo_nombre_errado</b></td></tr>
	<tr align='center'><td><font size='1'>Primer Apellido</font></td><td><font size='1'>Segundo Apellido</font></td><td><font size='1'>Primer Nombre</font></td><td><font size='1'>Segundo Nombre</font></td></tr>

	</table><font size='2'><b>Tipo documento de Identificación:</b>
	<table border='0'  width='90%'>
	<tr valign='top'>
		<td ><font size='1'>
		<input type='checkbox' disabled='true' $t4 > Registro Civil
	<br><input type='checkbox' disabled='true' $t5 > Tarjeta de identidad
	<br><input type='checkbox' disabled='true' $t1 > Cédula de ciudadanía
	<br><input type='checkbox' disabled='true' $t2 > Cédula de extranjería
		</td>
		<td><font size='1'>
		<input type='checkbox' disabled='true' $t3 > Pasaporte
	<br><input type='checkbox' disabled='true' $t6 > Adulto sin identificación
	<br><input type='checkbox' disabled='true' $t7 > Menor sin identificación
		</td>
		<td valign='bottom'>
		<div align='right'><font size='2'><b>$numero_documento_errado</b><br>
		<font size='2'>Número documento de identificación</font>
		<br><br>Fecha de nacimiento: <b>$fecha_nacimiento_errada</b></div>
		</td>
	</tr>
	</table>
	<hr>
	Dirección de Residencia Habitual: <b>$direccion_usuario</b> Telefono: <b>$telefono_usuario</b>
	<br>Departamento: $usuario_nombre_departamento <b>$departamento_usuario</b> Municipio: $usuario_nombre_departamento<b>$ciudad_usuario</b>
	<hr>
	<b><font size='2'>Cobertura en salud</b>
	<table border='0'  width='90%'>
	<tr valign='top'>
		<td ><font size='1'>
		<input type='checkbox' disabled='true' $r1 > Regimen contributivo
	<br><input type='checkbox' disabled='true' $r2 > Regimen subsidiado - total

		</td>
		<td><font size='1'>
		<input type='checkbox' disabled='true' $r9 > Regimen subsidiado - parcial
		<br><input type='checkbox' disabled='true' $r11 > Población pobre no asegurada con SISBEN
	
		</td>
		<td><font size='1'>
		<input type='checkbox' disabled='true' $r10 > Población pobre no asegurada sin SISBEN
	<br><input type='checkbox' disabled='true' $r8 > Desplazado
	
		</td>
		<td><font size='1'>
		<input type='checkbox' disabled='true' $r12 > Plan adicional de salud
	<br><input type='checkbox' disabled='true' $r5 > Otro
	
		</td>
		
	</tr>
	</table>
</td>
</tr>
<tr>
	<td>
	<b><div align='center'><font size='2'>INFORMACIÓN DE LA POSIBLE INCONSISTENCIA</div></b><hr>
	<TABLE width='100%' border='0'>
	<tr>
		<td><b><font size='2'>VARABLE PRESUNTAMENTE INCORRECTA</font></b></td>
		<td colspan='2'><div align='center'><b><font size='2'>DATOS SEGÚN DOCUMENTO DE IDENTIFICACION (Físico)</font></div></b></td>
	</tr>
	<tr  valign='top'>
		<td rowspan='7'><font size='1' >
		<BR><input type='checkbox' disabled='true' $v1 > Primer Apellido
		<BR><input type='checkbox' disabled='true' $v2 > Segundo Apellido
		<BR><input type='checkbox' disabled='true' $v3 > Primer Nombre
		<BR><input type='checkbox' disabled='true' $v4 > Segundo Nombre
		<BR><input type='checkbox' disabled='true' $v5 > Tipo documento de identificación
		<BR><input type='checkbox' disabled='true' $v6 > Número documeto de identificación
		<BR><input type='checkbox' disabled='true' $v7 > Fecha de nacimiento</font>
		
		</td>
		<td><font size='1'>Primer Apellido:</td><td><div align='right'><b><font size='1'>$primer_apellido</b></div></td></tr>
		<tr  valign='top'><td><font size='1'>Segundo Apellido:</td><td><div align='right'><b><font size='1'>$segundo_apellido</b></div></td></tr>
		<tr  valign='top'><td><font size='1'>Primer Nombre:</td><td><div align='right'><b><font size='1'>$primer_nombre</b></div></td></tr>
		<tr  valign='top'><td><font size='1'>Segundo Nombre:</td><td><div align='right'><b><font size='1'>$segundo_nombre</b></div></td></tr>
		<tr  valign='top'><td><font size='1'>Tipo documento de identificacion:</td><td><div align='right'><b><font size='1'>$documento_tipo</b></div></td></tr>
		<tr  valign='top'><td><font size='1'>Número documento identificación:</td><td><div align='right'><b><font size='1'>$documento_numero</b></div></td></tr>
		<tr  valign='top'><td><font size='1'>Fecha nacimiento:</td><td><div align=''><b><font size='1'>$fecha_nacimiento</b></div></td></tr>
		
		</font>
		</td>
		
	</tr>
	</table>
	
	</td>
</tr>
<tr>
	<td><b><font size='2'>OBSERVACIONES</b><BR>$observaciones
	</td>
</tr>
<tr>
	<td><div align='center'><b><font size='2'>DATOS DE LA PERSONA QUE REPORTA</b></div>
	<table with='100%'><tr><td><font size='1'>
			Nombre de quien informa: <b><font size='1'>$nombre_completo_funcionario</b>
	<br><font size='1'>Cargo o actividad: <b><font size='1'>$cargo_funcionario</b>
	</td><td><font size='1'>
	Teléfono <b>$telefono_empresa_1</b>
	Telefono celular: <b>$telefono_empresa_2</b>
	</td></tr></table>
	
	</td>
</tr>
<tr>
	<td>		
		</b>
		</td>
	</tr>
</table>";

	$nuevo_select .= "<font size='-2'><font size='1'> << REFERENCIA: $ai >> </font>";
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
