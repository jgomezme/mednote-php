<?php 
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: includes/error.php");
// echo "hola mundo2";
} 
?>
<html>
<head>
<title>Impresion</title>
<link href="../estilos/impresion_pantalla.css" rel="stylesheet" type="text/css" >
<link href="../estilos/impresion.css" rel="stylesheet" type="text/css" media="print">
</head>
<script>


function SoloCerrar(){
window.close()
							}
</script>
<body onload="javascript:resizeTo(800,600), window.print()" >
<?php

$control = $_REQUEST['control'];
include_once("../librerias/conex_pop.php");
$link=Conectarse();
impresion("$control");
function impresion($control){
global $link ;
mysql_query("SET NAMES 'utf8'");
 $usuario=mysql_query("SELECT  * FROM consulta_datos WHERE consulta_datos.control = '$control'  LIMIT 1",$link);  
while( $row = mysql_fetch_array( $usuario ) ) {
 $estado=$row['estado'];
 //$especialista=$row['especialista'];
 $id=$row['id_usuario'];
 $id_turno=$row['id_turno'];
                            
 																}

$titulo ="usuario _ $id ";


include_once ("../suscriptores/presentacion/datos.php");
echo "<div name='cabecera' id='cabecera' ><a href='#'  onclick=SoloCerrar();>[Cerrar]</a><hr></div>";
$nuevo_select .= "<h1>usuario $id</h1><table border='0'><tr valign='top'><td><img src='../images/logo_impresion_new.gif' WIDTH=260 HEIGHT=70 alt='$_SESSION[razon_social]'></td><td>";
echo $nuevo_select;
usuario_datos($id,"print");
$nuevo_select ="</td></tr></table><hr>";
/// datos de la consulta
$areas=mysql_query(" 
					SELECT DISTINCT(consulta_datos.id_campo),
					consulta_campos.campo_area ,
					consulta_areas.consulta_area_nombre
					FROM 
					consulta_datos, 
					consulta_campos,
					consulta_areas 
					WHERE 
					control = '$control' 
					AND consulta_datos.id_turno ='0'
					AND consulta_campos.id_consulta_campo = consulta_datos.id_campo
					AND consulta_datos.contenido != ''
					AND	consulta_campos.campo_area = consulta_areas.id_consulta_area
					AND consulta_datos.perfil = '1'
					GROUP BY consulta_campos.campo_area 
order by consulta_campos.orden",$link);
					

					
if (mysql_num_rows($areas)!='0'){
$clasificacion_consulta=mysql_query("
					SELECT 
					atencion_inicial.clasificacion,
					atencion_inicial.timestamp_atencion
					FROM 
					atencion_inicial
					WHERE 
					atencion_inicial.control = '$control' 
					
					",$link);
$clasificacion=mysql_result($clasificacion_consulta,0,"clasificacion");
$timestamp_atencion=mysql_result($clasificacion_consulta,0,"timestamp_atencion");
$nuevo_select .= "<h1>Clasificación triage: $clasificacion / fecha y hora de la atencion ".date("Y-m-d H:i",$timestamp_atencion)."</h1><br><br>";
while( $row = mysql_fetch_array( $areas ) ) {
$nuevo_select .= "<b> " .$row['consulta_area_nombre'] . "</b><ul>";
$area = $row['campo_area'];
/// los campos de cada area

$sql=mysql_query("
					SELECT DISTINCT(consulta_datos.id_campo),
					consulta_datos.contenido, 
					consulta_datos.id_consulta_datos, 
					consulta_campos.campo_nombre ,
					atencion_inicial.clasificacion
					FROM 
					consulta_datos, 
					consulta_campos ,
					atencion_inicial
					WHERE 
					consulta_datos.control = '$control' 
					AND consulta_datos.control = atencion_inicial.control
					AND consulta_datos.id_turno ='0'
					AND consulta_campos.id_consulta_campo = consulta_datos.id_campo 
					AND consulta_datos.contenido != '' 
					AND consulta_campos.campo_area = $area
					AND consulta_datos.perfil = '1'
					
order by consulta_campos.orden",$link);


if (mysql_num_rows($sql)!='0'){

while( $row = mysql_fetch_array( $sql ) ) {

$consulta_especialista ="SELECT consulta_datos.id_especialista, d9_users.id_grupo FROM	consulta_datos, d9_users WHERE consulta_datos.id_consulta_datos = '$row[id_consulta_datos]' AND consulta_datos.id_especialista = d9_users.id";
$grupo_especialista = mysql_query($consulta_especialista,$link);
$grupo_especialista=mysql_result($grupo_especialista,0,"id_grupo");

if($grupo_especialista != '9'){ /// si el grupo no es hospitalario revisar si esta avalado por un tutor
	$revisado_consulta ="SELECT firma_contenido, id_funcionario FROM	consulta_revision WHERE id_campo = '$row[id_consulta_datos]' AND tabla='consulta_datos'";
	$revisado = mysql_query($revisado_consulta,$link);
		if (mysql_num_rows($revisado)!='0'){ $imprimir='1'; $especialista=mysql_result($revisado,0,"id_funcionario"); }
		else{
					 $imprimir='1'; $especialista ="$_SESSION[id_usuario]";
				}
	
										}else{ $imprimir='1'; $especialista ="$_SESSION[id_usuario]";}
if($imprimir=='1'){

$nuevo_select .= "<li>" .$row['campo_nombre'] . ":<b> " . $row['contenido'] . "</b></li>";
						}else{$nuevo_select .= "<div id='cabecera' style='display:inline;'>
														<li><FONT COLOR='RED' title='Esta información NO HA SIDO VERIFICADA y no se imprimirá'> " .$row['campo_nombre'] . ":<b> " . $row['contenido'] . "</b></font></li>
														</div>";
							}
															}
										}
/// fin de los campos de cada area
$nuevo_select .= "</ul>";
															}
										}

/// fin de las aread de consulta
/// recetas formuladas en esta consulta
//pos
$pos=mysql_query("SELECT *, recetas.estado FROM recetas, medicamentos WHERE control='$control' AND recetas.id_medicamento = medicamentos.id_medicamento ",$link);



if (mysql_num_rows($pos)!='0'){
$nuevo_select .= "<b>Medicamentos formulados</b><ol>";
while( $row = mysql_fetch_array( $pos ) ) {

$consulta_especialista ="SELECT recetas.id_especialista, d9_users.id_grupo FROM	recetas, d9_users WHERE recetas.id_receta = '$row[id_receta]' AND recetas.id_especialista = d9_users.id";
$grupo_especialista = mysql_query($consulta_especialista,$link);
$grupo_especialista=mysql_result($grupo_especialista,0,"id_grupo");
if($grupo_especialista != '9'){ /// si el grupo no es hospitalario revisar si esta avalado por un tutor
	$revisado_consulta ="SELECT firma_contenido, id_funcionario FROM	consulta_revision WHERE id_campo = '$row[id_receta]' AND tabla='recetas'";
	$revisado = mysql_query($revisado_consulta,$link);
		if (mysql_num_rows($revisado)!='0'){ $imprimir='1';  }
		else{
					 $imprimir='0';
				}
	
										}else{ $imprimir='1'; }
if($imprimir=='1'){
$nuevo_select .= "<li> " .$row['medicamento_nombre'] . ":<b> " . $row['concentracion_forma'] . " " . $row['cantidad'] . "<br>" . $row['posologia'] . "</b></font></li>";
						}else{$nuevo_select .= "<div id='cabecera' style='display:inline;'>
														<li><FONT COLOR='RED' title='Esta información NO HA SIDO VERIFICADA y no se imprimirá'> " .$row['medicamento_nombre'] . ":<b> " . $row['concentracion_forma'] . " " . $row['cantidad'] . "<br>" . $row['posologia'] . "</b></font></li>
														</div>";
							}
															}
										}


//$nuevo_select .= "<li title='".$row['posologia']."'><b>".$row['medicamento_nombre']."</b> ".$row['concentracion_forma']."<b> [".$row['cantidad']."]</b></li>";

															$nuevo_select .= "</ol>";

//fin pos
//NO pos
/*
$no_pos=mysql_query("SELECT *, recetas.estado FROM recetas, medicamentos WHERE id_turno='$id_turno' AND recetas.id_medicamento = medicamentos.id_medicamento AND medicamentos.nopos='1'",$link);

if (mysql_num_rows($no_pos)!='0'){
$nuevo_select .= "<b>Medicamentos NO POS formulados</b><ol>";
while( $row = mysql_fetch_array( $no_pos ) ) {
$nuevo_select .= "<li title='".$row['posologia']."'><b>".$row['medicamento_nombre']."</b> ".$row['concentracion_forma']."<b> [".$row['cantidad']."]</b></li>";
															}
															$nuevo_select .= "</ol>";
										}
//fin NO pos
*/
/// fin de las recetas formuladas en esta consulta
//ordenes expedidas en la consulta
$ordenes=mysql_query("SELECT *, ordenes.estado, ordenes.id_orden  FROM ordenes, tipo_orden WHERE control='$control' AND ordenes.id_tipo_orden = tipo_orden.id_tipo_orden",$link);

if (mysql_num_rows($ordenes)!='0'){
$nuevo_select .= "<b>Ordenes expedidas</b><ol>";
while( $row = mysql_fetch_array( $ordenes ) ) {

$consulta_especialista ="SELECT ordenes.id_orden, d9_users.id_grupo FROM	ordenes, d9_users WHERE ordenes.id_orden = '$row[id_orden]' AND ordenes.id_especialista = d9_users.id";
$grupo_especialista = mysql_query($consulta_especialista,$link);
$grupo_especialista=mysql_result($grupo_especialista,0,"id_grupo");
if($grupo_especialista != '9'){
	$revisado_consulta ="SELECT firma_contenido, id_funcionario FROM	consulta_revision WHERE id_campo = '$row[id_orden]' AND tabla='ordenes'";
	$revisado = mysql_query($revisado_consulta,$link);
		if (mysql_num_rows($revisado)!='0'){ $imprimir='1'; }
		else{
					 $imprimir='0';
				}
	
										}else{ $imprimir='1'; }
if($imprimir=='1'){
$nuevo_select .= "<li> " .$row['orden_tipo'] . ":<b> " . $row['observacions'] . "</b></font></li>";
						}else{$nuevo_select .= "<div id='cabecera' style='display:inline;'>
														<li><FONT COLOR='RED' title='Esta información NO HA SIDO VERIFICADA y no se imprimirá'> " .$row['orden_tipo'] . ":<b> " . $row['observaciones'] . "</b></font></li>
														</div>";
							}
															}
									//	}


															$nuevo_select .= "</ol>";
										}

//fin ordenes expedidas en la consulta

/// fin datos de la consulta

$nuevo_select .="<hr>";
echo "$nuevo_select";


especialista_datos($especialista,"especialista");
$nuevo_select ="";
echo "$nuevo_select";
pie_imprenta();

							}
?>
</body>
</html><?php
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
