<?php
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: includes/error.php");
// echo "hola mundo2";
} 
 function mundo($formulario){
global $pais , $departamento, $ciudad;
?>

Pais:<br>
<select name="cod_pais" id="cod_pais" onchange="xajax_generar_select(xajax.getFormValues('<? echo $formulario ?>'))">
<option value="999" SELECTED></option>

<?php

$link=Conectarse(); 
mysql_query ("SET NAMES 'utf8'");
if ($pais != ""){
$Pais_definido=mysql_query("SELECT * FROM geo_pais WHERE cod_pais = '$pais'",$link);
$pais_definido=mysql_result($Pais_definido,0,"nom_pais");
echo "<option value='$pais' selected >>$pais_definido<</option>";
								}else {echo "<option value='COL' selected >Seleccione un pais</option>";}
$Pais_Tipo=mysql_query("SELECT * FROM geo_pais",$link);

while($row = mysql_fetch_array($Pais_Tipo)) {
     printf("<option value='%s'> %s</option>", $row["cod_pais"], $row["nom_pais"]);}
     
?>
</select><br>
<div id="seleccombinado">
<?php 
if ($departamento != ""){
if ($pais == "COL") {
$Departamento_definido=mysql_query("SELECT * FROM geo_municipios_colombia WHERE codigo_departamento = '$departamento'",$link);
$departamento_definido=mysql_result($Departamento_definido,0,"nombre_departamento");
echo "Departamento: <b>$departamento_definido</b>";
										}else{

echo "Estado o provincia: <b>$departamento</b>";
													}

												}
?>
</div>
<div id="selecmunicipios">
<?php 
if ($ciudad != ""){
if ($pais == "COL") {
$Municipio_definido=mysql_query("SELECT * FROM geo_municipios_colombia WHERE codigo_departamento = '$departamento' AND codigo_municipio ='$ciudad'",$link);
$municipio_definido=mysql_result($Municipio_definido,0,"nombre_municipio");
echo "Ciudad: <b>$municipio_definido</b>";
										}else{

echo "Ciudad: <b>$ciudad</b>";
													}

												}
?>
</div>

<br>
<? }?>
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
