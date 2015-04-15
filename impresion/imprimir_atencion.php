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
function Imprimir(){
window.print()
							}
</script>
<body onload="javascript:resizeTo(800,600), window.print()" >
<?php

$id_turno = $_REQUEST['id_turno'];
$timestamp = $_REQUEST['timestamp'];
$perfil = $_REQUEST['perfil'];

include_once("../librerias/conex_pop.php");
$link=Conectarse();
impresion("$id_turno");
function impresion($id_turno){
$timestamp = $_REQUEST['timestamp'];
$perfil = $_REQUEST['perfil']; 
global $link ;
mysql_query("SET NAMES 'utf8'");
 $usuario=mysql_query("SELECT  * FROM turnos WHERE turnos.id_turno = $id_turno LIMIT 1",$link);  
while( $row = mysql_fetch_array( $usuario ) ) {
 $estado=$row['estado'];
 //$especialista=$row['especialista'];
 $id=$row['id_usuario'];
 $id_turno=$row['id_turno'];
                            
 																}

$titulo ="usuario _ $id ";


include_once ("../suscriptores/presentacion/datos.php");
echo "<div name='cabecera' id='cabecera' ><a href='#'  onclick=SoloCerrar();>[Cerrar]</a> <a href='#'  onclick=Imprimir();>[Imprimir]</a><hr></div>";
$nuevo_select .= "<table border='0'><tr valign='top'><td><img src='../images/logo_impresion_new.gif' WIDTH=260 HEIGHT=70 alt='$_SESSION[razon_social]'></td><td>";
echo $nuevo_select;
usuario_datos($id,"print");
$tiempo_atencion = date('Y-m-d H:i:s',$timestamp);
if($perfil =='3'){$nombre_perfil="Tipo Atención: Evolución"; }
$nuevo_select ="<br></td></tr></table><hr><b><h5>Fecha y hora de la atención: </b>$tiempo_atencion </h5>"; 


/// datos de la consulta
$sql_areas=" SELECT consulta_areas.id_consulta_area, consulta_areas.consulta_area_nombre
			 FROM 
			 consulta_areas
where consulta_areas.estado != '0'
			 ORDER BY consulta_areas.orden";

				
$areas=mysql_query($sql_areas,$link);
					
if (mysql_num_rows($areas)!='0'){
$aux = 0;
while( $row = mysql_fetch_array( $areas ) ) {
if($aux>0){
$nombre_perfil = "";
}
$nuevo_select .= "<b><h5>" .$row['consulta_area_nombre'] . ": $nombre_perfil</b></h5><ul>";
$area = $row['id_consulta_area'];
$aux = $aux + 1;
/// los campos de cada area

$sql=mysql_query("
					SELECT consulta_datos.id_campo,
					consulta_datos.contenido, 
					consulta_datos.id_consulta_datos, 
					consulta_datos.perfil, 
					consulta_campos.campo_nombre , 
					consulta_datos.id_especialista 
					FROM 
					consulta_datos, 
					consulta_campos,
					consulta_tipo_campos
					WHERE 
					consulta_datos.id_turno = '$id_turno' 
					AND consulta_datos.timestamp= '$timestamp'
					AND consulta_tipo_campos.tipo_consulta = '$perfil'
					AND consulta_tipo_campos.id_campo = consulta_datos.id_campo
					AND consulta_campos.id_consulta_campo = consulta_datos.id_campo 
					AND consulta_datos.contenido != '' 
					AND consulta_campos.campo_area = $area
					AND consulta_datos.perfil = '$perfil'
                    and consulta_campos.activo != '0'                  
                    
order by consulta_campos.orden					
                    ",$link);

/* 
$id_especialista=mysql_result($areas,0,"id_especialista");
					$atendido_por = usuario_datos_consultar_impresion($id_especialista,usuario,'nombre_completo');
					$nuevo_select .="$nombre_perfil<br> Atendido por: $atendido_por <br><br>";
*/ 

if (mysql_num_rows($sql)!='0'){

while( $row = mysql_fetch_array( $sql ) ) {

if ($row['id_campo']>='12' and $row['id_campo']<='15'){$contenido= "[ $row[contenido] ]".usuario_datos_consultar_impresion($row[contenido],cie10,descripcion);}else{$contenido =$row['contenido'];}
$consulta_especialista ="SELECT consulta_datos.id_especialista, d9_users.id_grupo FROM	consulta_datos, d9_users WHERE consulta_datos.id_consulta_datos = '$row[id_consulta_datos]' AND consulta_datos.id_especialista = d9_users.id";
$grupo_especialista = mysql_query($consulta_especialista,$link);
$grupo_del_especialista=mysql_result($grupo_especialista,0,"id_grupo");
$especialista=mysql_result($grupo_especialista,0,"id_especialista");


if($grupo_del_especialista != '9'){ /// si el grupo no es hospitalario revisar si esta avalado por un tutor
	$revisado_consulta ="SELECT firma_contenido, id_funcionario FROM consulta_revision WHERE id_campo = '$row[id_consulta_datos]' AND tabla='consulta_datos'";
	$revisado = mysql_query($revisado_consulta,$link);
		if (mysql_num_rows($revisado)!='0'){ $imprimir='1'; $especialista=mysql_result($revisado,0,"id_funcionario"); }
		else{
					 $imprimir='0';
				}
	
										}else{ $imprimir='1'; }
if($imprimir=='1'){

$nuevo_select .= "<b>". $row['campo_nombre'] ."</b>". ": $contenido". ".&nbsp;&nbsp;&nbsp;&nbsp;"; //modificacion william
						}else{$nuevo_select .= "<div id='cabecera' style='display:inline;'>
							<li><FONT COLOR='RED' title='Esta información NO HA SIDO VERIFICADA y no se imprimirá'> " .$row['campo_nombre'] . ":<b> $contenido </b></font></li>
							</div>";
							}
								}
									}
/// fin de los campos de cada area
$nuevo_select .= "</ul>";
															}
										}



/// fin datos de la consulta

$nuevo_select .="<hr>";
echo "$nuevo_select";



echo especialista_datos($especialista,"especialista"); 
$nuevo_select ="";
echo "$nuevo_select";
pie_imprenta();

							}
?>
</body>
</html>
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
