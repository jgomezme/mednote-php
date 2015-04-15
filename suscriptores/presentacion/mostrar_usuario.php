<?PHP session_start();
header('Content-Type: text/html; charset=UTF-8');

if ($_SESSION['prioridad'] < "3"){} 
else { 


}
if (isset($_REQUEST['ID'])) {echo "<script language='JavaScript' src='../../librerias/gen_validatorv2.js' type='text/javascript'></script>";}
?>
 <html>
 <head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="../../estilos/estilo.css" rel="stylesheet" type="text/css">
<script>
function SoloCerrar(){
window.close()
}

function retornar_ID(id){
	window.opener.document.buscador.elements[0].value = id
	window.close()
}

function uno(src,color_entrada) {
    src.bgColor=color_entrada;src.style.cursor="hand";
}
function dos(src,color_default) {
    src.bgColor=color_default;src.style.cursor="default";
}	

</script>
<?
include("../../librerias/conex.php");
$link=Conectarse();
$apellido_suscriptor = $_POST['apellido_suscriptor'];
$suscriptor="'%%$apellido_suscriptor%%'";
$suscriptor_mayus=strtoupper($suscriptor);
$suscriptor_minus=strtolower($suscriptor);
mysql_query("SET NAMES 'utf8'");
$suscriptores_buscados = mysql_query("
SELECT `id` , `nombre_completo` , `documento_numero` 
FROM `d9_users` 
WHERE (nombre_completo LIKE $suscriptor_mayus) OR  (nombre_completo LIKE $suscriptor_minus) OR (documento_numero LIKE $suscriptor)ORDER BY nombre_completo  LIMIT 100",$link);
echo mysql_error();
$cantidad=mysql_num_rows($suscriptores_buscados);
$filas=($cantidad*30);
if($filas < 200){$filas=200;}
if(mysql_num_rows($suscriptores_buscados)==0){
	$_SESSION['error']=1; ?>
	<script>
		window.location.href='seleccionar_usuario.php';
	</script>

<?
}
else{$_SESSION['error']=0;
?>

</head>
<body onload="javascript:resizeTo(500,<? echo $filas ?>)">
<? echo $cantidad ?> Usuarios encontrados
<center>
<form name='buscar' method=POST action='mostrar_usuario.php' ENCTYPE='multipart/form-data' onsubmit="return validar(this.form)">
				<input type='text' name='apellido_suscriptor' size="32" maxlength="32" onKeyPress="return acceptNum(event)"> 
				<input type='submit' name='button' TITLE='Pulse para Continuar'   value='Buscar'>
				<input type='submit' href="seleccionar_usuario.php" value="Cerrar" onclick=SoloCerrar();>
				</form>
				
</center>


	<table>
	
<?
	while ($row = mysql_fetch_row($suscriptores_buscados)){
	echo "<tr  onMouseOver=uno(this,'red'); onMouseOut=dos(this,'FFFFFF'); bgcolor=#FFFFFF ><td></td><td onMouseOver=uno(this,'#f5f3d7'); onMouseOut=dos(this,'FFFFFF'); bgcolor=#FFFFFF><a href=\"javascript:retornar_ID('$row[0]')\"  onsubmit=SoloCerrar(); >".$row[1]." Doc: ".$row[2]." ".$row[3]." ".$row[4]."</a></td><td></td></tr>";
	}
?>
	</table>
	</body>
	</html>

<?
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
