<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" >
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
  <meta name="author" content="Milfson web: http://www.milfcz.com e-mail: milf@milfcz.com" />
  <title>JSRS Select Demo - page #2</title>
<style type="text/css">
		/* <![CDATA[ */
		@import url(./style.css);
		/* ]]> */
</style>
<script type="text/javascript" src="jsrsClient.js"></script>
<script type="text/javascript" src="selectphp.js"></script>
</head>
<?php
  $make = isset($_POST['lstMake']) ? $_POST['lstMake'] : -99;
  $model = isset($_POST['lstModel']) ? $_POST['lstModel'] : -99;
  $options = isset($_POST['lstOptions']) ? $_POST['lstOptions'] : -99;
?>
<body onload="preselect('<?php echo $make;?>', '<?php echo $model;?>', '<?php echo $options;?>', 1);">
<h2>JSRS Select Box Filling Demo - page #2</h2>
<form name="QForm" action="./select.php" method="post">
<fieldset>
  <legend>Result from previous selects</legend>
    <p>
      <label for="lstMake">Make</label>
      <select name="lstMake" id="lstMake">
        <option>--------- Not Yet Loaded ---------</option>
      </select>
    </p>
    <p>
      <label for="lstModel">Model</label>
      <select name="lstModel" id="lstModel">
        <option>--------- Not Yet Loaded ---------</option>
      </select>
    </p>
    <p>
      <label for="lstOptions">Options</label>
      <select name="lstOptions" id="lstOptions">
        <option>--------- Not Yet Loaded ---------</option>
      </select>
    </p>
</fieldset>
<p><input type="submit" name="cmdBack" value="Back" id="cmdSubmit" /></p>
</form>
Thanks to Milfson (milf@milfcz.com) for the preselection code!
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
