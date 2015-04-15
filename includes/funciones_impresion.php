<?php
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: error.php");
// echo "hola 2";
} 

function usuario_datos_consultar_impresion($id,$tipo,$campo){
$link=Conectarse(); 
if($tipo == 'usuario'){$tabla= 'd9_users'; $clave ='id'; $w = "LIMIT 1"; }
elseif($tipo == 'cliente'){$tabla= 'clientes'; $clave ='id_cliente'; $w = "LIMIT 1";}
elseif($tipo == 'cie10'){$tabla= 'cie_10'; $clave ='codigo'; $w = "LIMIT 1";}
elseif($tipo == 'turnos_usuario'){$tabla= 'turnos'; $clave ='id_turno'; $w = "LIMIT 1";}
elseif($tipo == 'autorizaciones_solicitud'){$tabla= 'autorizaciones_solicitud'; $clave ='id_autorizacion_solicitud'; $w = "LIMIT 1";}
elseif($tipo == 'atencion_inicial'){$tabla= 'atencion_inicial'; $clave ='id_atencion_inicial'; $w = "LIMIT 1";}
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
