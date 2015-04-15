<html><head>  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Cambiar contrase&ntilde;a</title>
 <link rel="SHORTCUT ICON" href="../../icono.ico">
<link href="../../estilos/estilo.css" rel="stylesheet" type="text/css">
</head>

<script>
function Verif()  {
    if (document.forms[0].elements[0].value == ""){
    alert("Indique el ID de su usuario")
    document.forms[0].elements[0].focus();
    return false;
  }
    else if (document.forms[0].elements[1].value == ""){
    alert("No puede dejar campos vacios")
    document.forms[0].elements[1].focus();
    return false;
  }
    else if (document.forms[0].elements[2].value == ""){
    alert("No puede dejar campos vacios")
    document.forms[0].elements[1].focus();
    return false;
  }

    clave1 = document.nuevo_password.password1.value
    clave2 = document.nuevo_password.password2.value
    if (clave1 == clave2){
    }
    else{
       alert("Las dos claves escritas son distintas, por favor escribalas de nuevo")
       document.forms[0].elements[1].focus();
       return false;
    }
  } 
</script>


<body >

<table width="80%" border="0" align="center">  
<tr>
   <td colspan="3" align="center">
   
   <br><br><img src="../../images/logo.gif"  border="0" name="GaleNUx.com" alt="GaleNUx.com" align="top"><br>
  </td>  
</tr>

<tr>
   <td colspan="3" align="center">
<br>

<h2>Formato para cambio de contrase&ntilde;a </h2>
<form action="proceso_cambiar_password.php" method="post" name="nuevo_password" onsubmit="return Verif(this.form)">
<p>Ingrese el ID de su usuario (se le envi&oacute; por correo)</p><input type="text" name="id">
<p>Ingrese la contrase&ntilde;a</p><input type="password" name="password1">
<p>Ingrese la contrase&ntilde;a nuevamente</p><input type="password" name="password2">
<input type="hidden" name="codsec" value="<?php echo $_REQUEST['gHsiw']; ?>">
<br><br>
<input type="submit" value="Cambiar" />
</form>
</tr>
</table>
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
