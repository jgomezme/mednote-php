<?php 
function usuario_datos_consultar_impresion($id,$tipo,$campo){
global $link;
if($tipo == 'usuario'){$tabla= 'd9_users'; $clave ='id'; $w = "LIMIT 1"; }
elseif($tipo == 'documento'){$tabla= 'documento_tipo'; $clave ='id_documento_tipo'; $w = "LIMIT 1";}
elseif($tipo == 'cliente'){$tabla= 'clientes'; $clave ='id_cliente'; $w = "LIMIT 1";}
elseif($tipo == 'cie10'){$tabla= 'cie_10'; $clave ='codigo'; $w = "LIMIT 1";}
elseif($tipo == 'turnos_usuario'){$tabla= 'turnos'; $clave ='id_turno'; $w = "LIMIT 1";}
elseif($tipo == 'autorizaciones_solicitud'){$tabla= 'autorizaciones_solicitud'; $clave ='id_autorizacion_solicitud'; $w = "LIMIT 1";}
elseif($tipo == 'atencion_inicial'){$tabla= 'atencion_inicial'; $clave ='id_atencion_inicial'; $w = "LIMIT 1";}
elseif($tipo == 'atencion_inicial_control'){$tabla= 'atencion_inicial'; $clave ='control'; $w = "LIMIT 1";}
elseif($tipo == 'clasificacion'){$tabla= 'atencion_inicial'; $clave ='control'; $w = "LIMIT 1";}
elseif($tipo == 'inconsistencias'){$tabla= 'inconsistencias'; $clave ='id_inconsistencia'; $w = "LIMIT 1";}
elseif($tipo == 'motivo_consulta'){$tabla= 'consulta_datos'; $clave ='control'; $w = "AND id_campo ='1' LIMIT 1";}
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


function edad($edad){
/*list($anio,$mes,$dia) = explode("-",$edad);
$anio_dif = date("Y") - $anio;
$mes_dif = date("m") - $mes;
$dia_dif = date("d") - $dia;
if ($dia_dif < 0 || $mes_dif < 0){$anio_dif--;}
$edad_completa ="$anio_dif Años $mes_dif Meses $dia_dif Dias";
//return $anio_dif ;
*/ 
$fecha_actual = date ("Y-m-d"); 
$fecha_de_nacimiento = $edad;


// separamos en partes las fechas
$array_nacimiento = explode ( "-", $fecha_de_nacimiento );
$array_actual = explode ( "-", $fecha_actual );

$anos =  $array_actual[0] - $array_nacimiento[0]; // calculamos años
$meses = $array_actual[1] - $array_nacimiento[1]; // calculamos meses
$dias =  $array_actual[2] - $array_nacimiento[2]; // calculamos días

//ajuste de posible negativo en $días
if ($dias < 0)
{
    --$meses;

    //ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual
    switch ($array_actual[1]) {
           case 1:     $dias_mes_anterior=31; break;
           case 2:     $dias_mes_anterior=31; break;
           case 3: 
                if (bisiesto_2($array_actual[0]))
                {
                    $dias_mes_anterior=29; break;
                } else {
                    $dias_mes_anterior=28; break;
                }
           case 4:     $dias_mes_anterior=31; break;
           case 5:     $dias_mes_anterior=30; break;
           case 6:     $dias_mes_anterior=31; break;
           case 7:     $dias_mes_anterior=30; break;
           case 8:     $dias_mes_anterior=31; break;
           case 9:     $dias_mes_anterior=31; break;
           case 10:     $dias_mes_anterior=30; break;
           case 11:     $dias_mes_anterior=31; break;
           case 12:     $dias_mes_anterior=30; break;
    }

    $dias=$dias + $dias_mes_anterior;
}

//ajuste de posible negativo en $meses
if ($meses < 0)
{
    --$anos;
    $meses=$meses + 12;
}

$edad_completa =  "$anos años con $meses meses y $dias días";

return $edad_completa;
}

function bisiesto_2($anio_actual){
    $bisiesto_2=false;
    //probamos si el mes de febrero del año actual tiene 29 días
      if (checkdate(2,29,$anio_actual))
      {
        $bisiesto_2=true;
    }
    return $bisiesto_2;
} 
function nombre_ciudad($cod_departamento,$cod_municipio){
global $link;
mysql_query("SET NAMES 'utf8'");
$nombre_localidad=mysql_query("SELECT nombre_departamento, nombre_municipio FROM geo_municipios_colombia WHERE codigo_departamento like '$cod_departamento' AND codigo_municipio like '$cod_municipio'",$link);
if (mysql_num_rows($nombre_localidad)!='0'){
$nombre_municipio = mysql_result($nombre_localidad,0,"nombre_municipio");
} else{$nombre_municipio="[$cod_departamento][$cod_municipio]";}
return $nombre_municipio;
		}
function nombre_departamento($cod_departamento,$cod_municipio){
global $link;
mysql_query("SET NAMES 'utf8'");
$nombre_localidad=mysql_query("SELECT nombre_departamento, nombre_municipio FROM geo_municipios_colombia WHERE codigo_departamento like '$cod_departamento' AND codigo_municipio like '$cod_municipio'",$link);
if (mysql_num_rows($nombre_localidad)!='0'){
$nombre_departamento = mysql_result($nombre_localidad,0,"nombre_departamento");
} else{$nombre_departamento="[$cod_departamento][$cod_municipio]";}
return $nombre_departamento;
		}
function usuario_datos($id,$tipo){
global $link;
mysql_query("SET NAMES 'utf8'");
$Usuario_Datos=mysql_query("SELECT clientes.alias, d9_users. *
FROM d9_users, clientes
WHERE (d9_users.id = '$id')
AND d9_users.id_cliente = clientes.id_cliente LIMIT 1",$link); 
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
$documento_tipo = usuario_datos_consultar_impresion($documento_tipo,'documento','documento_tipo');
$estado_civil=mysql_result($Usuario_Datos,$i,"estado_civil"); 
$genero=mysql_result($Usuario_Datos,$i,"genero");  
$fecha_nacimiento=mysql_result($Usuario_Datos,$i,"fecha_nacimiento"); 
$Fecha_Nacimiento=mysql_result($Usuario_Datos,$i,"fecha_nacimiento");  
$email=mysql_result($Usuario_Datos,$i,"email");  
$direccion=mysql_result($Usuario_Datos,$i,"direccion");   
$barrio=mysql_result($Usuario_Datos,$i,"barrio");   
$departamento=mysql_result($Usuario_Datos,$i,"departamento"); 
$ciudad=mysql_result($Usuario_Datos,$i,"ciudad");      
$ciudad_extranjero=mysql_result($Usuario_Datos,$i,"ciudad_extranjero");   
$nombre_departamento =nombre_departamento($departamento,$ciudad);  
$nombre_ciudad =nombre_ciudad($departamento,$ciudad);
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
 
$activos=mysql_result($Usuario_Datos,$i,"activos");
$entidad=mysql_result($Usuario_Datos,$i,"alias");
if ( isset ( $_REQUEST['control'] ) ) {
$entidad = usuario_datos_consultar_impresion($_REQUEST['control'],'atencion_inicial_control','id_cliente');
$entidad = usuario_datos_consultar_impresion($entidad,'cliente','alias');
}elseif ( isset ( $_REQUEST['id_turno'] ) ) {
$entidad = usuario_datos_consultar_impresion($_REQUEST['id_turno'],'turnos_usuario','id_cliente');
$entidad = usuario_datos_consultar_impresion($entidad,'cliente','alias');
}else{$entidad = $entidad;}

////
$responsable_nombre=mysql_result($Usuario_Datos,$i,"responsable_nombre");
$responsable_direccion=mysql_result($Usuario_Datos,$i,"responsable_direccion");
$responsable_telefono=mysql_result($Usuario_Datos,$i,"responsable_telefono");

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
$timestamp_nacimiento = mktime(0,0,0,$dia,$mes,$ano);
$hoy = mktime();
$edad= edad($Fecha_Nacimiento);

$mes_letras = date("n", $fecha_nacimiento);
$mes_letras = $letras[$mes_letras];
		}

if($tipo == "print"){

$nuevo_select .="<td><h4>Usuario: </h4><h1>$nombre_completo</h1><br>
<h4>Documento: $documento_tipo $documento_numero Codigo: $id Entidad: $entidad</h4><br>
<h4>Fecha nacimiento: $mes_letras $dia  $ano Edad: $edad </h4><br>
<h4>Departamento: $nombre_departamento [$departamento] Municipio: $nombre_ciudad [$ciudad] </h4><br>
<h4>Barrio: $barrio Direccion: $direccion Telefonos: $telefono_fijo $telefono_fijo_1 $telefono_celular</h4><br>
</td>";}else {
$nuevo_select .= "
Paciente en consulta <b>$nombre_completo</b>
<br>Fecha de nacimiento $mes_letras $dia  $ano
<br>Edad $edad
									";
//echo $nuevo_select;
if ($_SESSION['grupo'] == "2"){}
else{

//$nuevo_select .= "<a HREF=\"javascript:abrir('suscriptores/presentacion/enviar_correo.php?id=$id&id_remitente=$id_remitente','enviar_correo',600,300,100,0,1)\" TITLE='Clic AQUI en contactar usuario'><p>Enviar correo a usuario</p></a>";

		}
																		}//fin de excepcion de print
print "$nuevo_select";
														}// fin si hay un usuario valido como parametro

}//fin funcion


//funcion datos_especialista

function especialista_datos($id,$tipo){
global $link;
mysql_query("SET NAMES 'utf8'");
$Usuario_Datos=mysql_query("SELECT *
FROM d9_users, especialistas
WHERE (d9_users.id = '$id')
AND d9_users.id = especialistas.id",$link); 
$num=mysql_num_rows($Usuario_Datos);
if (mysql_num_rows($Usuario_Datos)!=0){
$i=0;
$nombre_completo=mysql_result($Usuario_Datos,$i,"nombre_completo");
$registro_medico=mysql_result($Usuario_Datos,$i,"registro_medico");  
$universidad_especializacion=mysql_result($Usuario_Datos,$i,"universidad_especializacion");  
$especialidad=mysql_result($Usuario_Datos,$i,"especialidad");  
$cargo=mysql_result($Usuario_Datos,$i,"cargo");  //modificacion william
echo "<table border='0' width='100%'><tr><td width='10%'></td><td align='right'><h3>$nombre_completo</h3>&nbsp;<h2>&nbsp;$especialidad&nbsp;$universidad_especializacion</h2>&nbsp;<h4>Registro medico:$registro_medico</h4>&nbsp;</td></tr></table>";
													}
										}// fin funcion especialista_datos
										

//funcion pie imprenta

function pie_imprenta(){
//global $link;
$ahora=date('Y-m-d H:i:s');
$nombre_completo = $_SESSION['nombre_completo'];
echo "<div align='left'><h4><img src='../images/vigilado_gris_200.gif' WIDTH=120 HEIGHT=30 alt='VIGILADO Supersalud '></div>
<div align='right'><h4><html>Un proyecto de: <a href='http://opuslibertati.org'>http://opuslibertati.org</a> - Powered by: <a href='http://GaleNUx.com'>http://GaleNUx.com</a> - Imprimi&oacute;: $nombre_completo / $ahora ip: $_SERVER[REMOTE_ADDR]</h4></div>";
												
}// fin funcion pie de imprenta									

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
