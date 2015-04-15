<?php 
function usuario_datos($id,$grupo){
$id =$id;
if($_SESSION['grupo']!='1'){$id_empresa= $_SESSION['id_empresa'];}else {$id_empresa='%%';}
$link=Conectarse();
mysql_query("SET NAMES 'utf8'");
$Usuario_simple=mysql_query(" 
SELECT 	d9_users.id,
			d9_users.id_grupo,
			d9_users.documento_numero,
			d9_users.documento_tipo,
			d9_users.fecha_nacimiento, 
			d9_users.nombre_completo
FROM d9_users 
WHERE  id_empresa LIKE '$id_empresa' 
AND (d9_users.id =  '$id')
									",$link); 
if($grupo != '2'){
$Usuario_Datos=mysql_query("
SELECT 	d9_users.id,
			d9_users.id_grupo,
			d9_users.documento_numero,
			d9_users.documento_tipo,
			d9_users.fecha_nacimiento, 
			d9_users.nombre_completo
WHERE  d9_users.id_empresa LIKE '$id_empresa' 
AND (d9_users.id =  '$id')
									",$link); 
											}else
											{
$Usuario_Datos=mysql_query("
SELECT 	d9_users.id, 
			d9_users.id_grupo,
			d9_users.documento_numero,
			d9_users.documento_tipo,
			d9_users.fecha_nacimiento, 
			d9_users.nombre_completo, 
			clientes.alias   AS id_cliente,
			tipo_plan_beneficios.tipo_plan_beneficios AS plan_beneficios,
			tipo_usuarios.tipo_usuario  AS tipo_usuario,
			clientes.estado AS estado
FROM d9_users , clientes , tipo_plan_beneficios, tipo_usuarios
WHERE  d9_users.id_empresa LIKE '$id_empresa' 
AND (d9_users.id =  '$id')
AND d9_users.id_cliente = clientes.id_cliente
AND d9_users.plan_beneficios = tipo_plan_beneficios.id_tipo_plan_beneficios
AND d9_users.tipo_usuario = tipo_usuarios.id_tipo_usuario

									",$link); 
											} 
if (mysql_num_rows($Usuario_simple)!=0){
							
							if($grupo == '2'){
							if (mysql_num_rows($Usuario_Datos)!=0){
							$id_cliente=mysql_result($Usuario_Datos,0,"id_cliente");
							$plan_beneficios=mysql_result($Usuario_Datos,0,"plan_beneficios");
							$tipo_usuario=mysql_result($Usuario_Datos,0,"tipo_usuario");  
							$estado=mysql_result($Usuario_Datos,0,"estado"); 
							$vinculacion .= "
							<li>Entidad: $id_cliente $estado </li>
							<li>Tipo: $tipo_usuario </li>
							<li>Plan de beneficios: $plan_beneficios</li>";
																										
									
									if($estado =='0') {
																	$estado =" <img src='images/atencion.gif' border='0' alt='[!]' title='La EPS esta inactiva'> EPS inactiva ";
																		} else{$estado ="";} 
																												}else {$vinculacion .= "<!-- <div align='center' class='alerta'><img src='images/atencion.gif' border='0' alt='[!]' 
																																title='ATENCION: El usuario TIENE DATOS INCOMPLETOS'> 
																																<h2>El usuario no esta asociado con una EPS<br> o no cuenta con los datos necesarios para facturar
																																</h2><a HREF=\"javascript:abrir('suscriptores/presentacion/editar_usuario.php?id=$id','editar_usuario',600,600,300,0,1)\" 
																																TITLE='Clic AQUI para editar el Usuario'><h1>[ Completar Perfil ]</h1></A>
																																									</div> -->";
																															}
															}
									$id=mysql_result($Usuario_simple,0,"id");  
									$id_grupo=mysql_result($Usuario_simple,0,"id_grupo");
									$documento_numero=mysql_result($Usuario_simple,0,"documento_numero");      
									$nombre_completo=mysql_result($Usuario_simple,0,"nombre_completo");      
									$fecha_nacimiento=mysql_result($Usuario_simple,0,"fecha_nacimiento");    
									$documento_tipo=mysql_result($Usuario_simple,0,"documento_tipo");  
									 $documento_tipo = usuario_datos_consultar($documento_tipo,'documento','documento_tipo');
									 $edad = saber_edad($fecha_nacimiento);

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
$nuevo_select .= "<h2> Código: [$id] $nombre_completo
<a OnClick=\"xajax_wait('formulario');xajax_suscriptores_formulario('$id','otro')\"  TITLE='Clic AQUI para editar el Usuario'>
<img src='images/editar.gif' border='0' alt='[E]' title='Editar el perfil del usuario'></A> 

<a HREF=\"javascript:abrir('suscriptores/presentacion/enviar_correo.php?id=$id&id_remitente=$id_remitente','enviar_correo',750,400,100,0,1)\" TITLE='Clic AQUI en contactar usuario'>
<img src='images/email.gif' border='0' alt='[M]' title='Enviar correo'>
</a></h2><h3>Documento: $documento_tipo $documento_numero / Edad $edad</h3>
";
$nuevo_select .= $vinculacion;
echo $nuevo_select;
if ($_SESSION['grupo'] == "2"){}
else{
$nuevo_select = $ID; 
$nuevo_select .= "";
echo $nuevo_select;
		}
}ELSE {echo "";}

}//fin funcion

?>
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
