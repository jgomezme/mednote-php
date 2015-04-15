<?php 
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: includes/error.php");
// echo "hola mundo2";
} 

//if($_SESSION['grupo']!='1'){
$id_empresa= $_SESSION['id_empresa'];
//}else {$id_empresa='%%';}

mysql_query("SET NAMES 'utf8'");
$Usuario_Datos=mysql_query("
SELECT 	d9_users.id, 
			d9_users.id_grupo,
			d9_users.documento_numero,
			d9_users.fecha_nacimiento, 
			d9_users.nombre_completo ,
			d9_users.id_cliente 
			
FROM d9_users 
WHERE  (d9_users.id =  '$usuario')
AND id_empresa LIKE '$id_empresa'

",$link);
//echo "[ <a href='?page=suscriptores'><b>BUSCAR OTRO USUARIO</b></a> ]";
//echo "";
echo "<div name='asignacion_turnos' id='asignacion_turnos'>"; 

if (mysql_num_rows($Usuario_Datos)!=0){//// se comprueba el usuario si existe se sigue
$id=mysql_result($Usuario_Datos,0,"id");
$id_grupo=mysql_result($Usuario_Datos,0,"id_grupo");
$id_cliente=mysql_result($Usuario_Datos,0,"id_cliente");

/// incluir los datos del usuario
include_once("suscriptores/presentacion/usuarios_datos.php");
 usuario_datos($id,"$id_grupo");
echo $nuevo_select;



//include_once("impresion/impresion_usuario.php");
/// incluir resumen de consulta por usuario
if ($_SESSION['grupo'] == '3'){$asistencial = '1';}
elseif ($_SESSION['grupo'] == '8'){$asistencial = '1';}
elseif ($_SESSION['grupo'] == '9'){$asistencial = '1';}
else{$asistencial = '0';}
//if($asistencial=='1'){ /// si es un usuarios asistencial se muestra la HC

$sql=mysql_query(" SELECT id_turno, id_usuario, fecha, hora_inicio
									FROM turnos 
									WHERE turnos.id_usuario = '$id' 
									ORDER BY turnos.timestamp DESC 
										
										",$link);
if (mysql_num_rows($sql)!='0'){
while( $row = mysql_fetch_array( $sql ) ) {
$listado .= "<li> <input title='Consultar el resumen de esta atención' type='button' id='boton_6' style='' onClick=\"xajax_resumen_consulta('$row[id_usuario]','$row[id_turno]','',xajax.getFormValues('consulta'))\" value='Resumen Consulta $row[fecha] $row[hora_inicio]' >	</li>";													
														}
										}
echo $listado;							
echo "<div id='consulta_dinamico'  name='consulta_dinamico' ></div>";			
//include_once("consulta/funciones/listado.php");
//$areas=listado_areas($id,"todas",'');
//echo $areas;
$atencion_inicial_consulta = atencion_inicial_consulta($id,"listado");
echo $atencion_inicial_consulta;
//echo listado_areas($id_usuario,$id_turno,$autorizado);

//										} ///  fin de mostrar consultas

//if($id_grupo == '2'){ /// si el usuario que se busco es un paciente se muestra la asignacion de citas
include_once("turnos/asignacion.php");
//											}	/// fin de paciente
if($_SESSION[grupo]=='5'){ /// muestra la solicitud de autorizacion
									echo "<div align='center' title='Formulario para solicitar la autorización de servicios adicionales o posteriores a la atención de urgencias para este usuario'><div id='autorizaciones'><input type='button' class='cursor'
									 value='Solicitud de autorización de servicios adicionales para  ".usuario_datos_consultar($id,'usuario','nombre_completo')."' 
									onClick=\"xajax_autorizacion_solicitud('$id','autorizaciones','Solicitud de autorización','formulario'); \">
</div></div>";
include('i/listado.php');
									}
/// incluir el listado de consultas asignadas al usuario
include_once("turnos/funciones/listado.php");
$listado=listado_turnos($id,"todas");
echo $listado;



				}//// fin de la comprobacion de usuario

  
		else {/// si no es un usuario valido se alerta
		echo "<h1><img src='images/atencion.gif' border='0' alt='[!]'> El id $usuario  no existe o no cuenta con permisos para consultarlo</h1>";
		
				}
				echo"</div>";
   ?>
   </td></tr>

<?php
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
