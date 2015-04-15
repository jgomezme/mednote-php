<?php 
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: includes/error.php");
// echo "hola mundo2";
}








// 19230
// 7121
// 8886


include("../librerias/conex.php");
$link=Conectarse();
$id_usuario=$_SESSION["id_usuario"];
$id_suscriptor_auditado=8886;
$accion="rechazado";
$fecha_ahora = date('Y-m-d g:i:s');

if($accion == "aceptado"){
mysql_query("update `usuarios_temporal` SET 
`revisado`='1',  
`aceptado`='1',
`revisado_por`='$id_usuario',  
`aceptado_por`='$id_usuario',
`revisado_fecha`='$fecha_ahora',  
`aceptado_fecha`='$fecha_ahora'
WHERE `usuarios_temporal`.`id_usuario_temporal` = '$id_suscriptor_auditado' LIMIT 1",$link);
}
else{
mysql_query("update `usuarios_temporal` SET 
`digitado`='0',
`revisado`='1',  
`digitado_por`=NULL,    
`revisado_por`='$id_usuario',  
`revisado_fecha`='$fecha_ahora'
WHERE `usuarios_temporal`.`id_usuario_temporal` = '$id_suscriptor_auditado' LIMIT 1",$link);
echo mysql_error();

mysql_query("DELETE FROM `datos_geograficos` WHERE `id` = '$id_suscriptor_auditado' LIMIT 1",$link);
echo mysql_error();
}
echo "Proceso realizado correctamente";
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
