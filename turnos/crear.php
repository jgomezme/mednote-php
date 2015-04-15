<?php 
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: includes/error.php");
// echo "hola mundo2";
} 
if ($_SESSION['prioridad'] >= "3"){ 
?>
<FORM  name="turnos_crear" id="turnos_crear">
<table width="" border="0" align="center">  
<tr >
<td align="center"  title="Elija la fecha, hora y duración de la sesion de trabajo"></td>
<td align="center"></td>
<td align="center"></td>
</tr>

  <tr valign="top">
  
 
    <td> <div align="right">
         <?php 
     include_once("terceros/listado_XAJAX.php"); 
	listado("9","","turnos_crear","turnos_procesar")     
     ?><br>
    Fecha : <input size="8" id="fecha" type="text" name="fecha" title="YYYY-MM-DD" OnBlur="xajax_turnos_procesar(xajax.getFormValues('turnos_crear'))"
    onClick="displayCalendar(this);" value="<? echo $hoy ?>" OnChange="xajax_turnos_procesar(xajax.getFormValues('turnos_crear'))"> 
        <br>
    Inicio jornada:
 
    <select  NAME="hora_inicio"  id="hora_inicio" OnChange="xajax_turnos_procesar(xajax.getFormValues('turnos_crear'))" title="Hora en que se empezara la consulta">
		  <option value="<?php echo "$minutos_dia"; ?>" selected><?php echo "$hora:00 $ap"; ?></option>
        <option value="360" >6:00 Am</option>
        <option value="390" >6:30 Am</option>
        <option value="420" >7:00 Am</option>
        <option value="450" >7:30 Am</option>
        <option value="480" >8:00 Am</option>
        <option value="510" >8:30 Am</option>
        <option value="540" >9:00 Am</option>
        <option value="570" >9:30 Am</option>
        <option value="600" >10:00 Am</option>
        <option value="630" >10:30 Am</option>
        <option value="660" >11:00 Am</option>
        <option value="690" >11:30 Am</option>
        <option value="720">12:00 M</option>
        <option value="750" >12:30 Pm</option>
        <option value="780" >1:00 Pm</option>
        <option value="810" >1:30 Pm</option>
        <option value="840" >2:00 Pm</option>
        <option value="870" >2:30 Pm</option>
        <option value="900" >3:00 Pm</option>
        <option value="930" >3:30 Pm</option>
        <option value="960" >4:00 Pm</option>
        <option value="990" >4:30 Pm</option>
        <option value="1020" >5:00 Pm</option>
        <option value="1050" >5:30 Pm</option>
        <option value="1080" >6:00 Pm</option>
        <option value="1110" >6:30 Pm</option>
        <option value="1140" >7:00 Pm</option>
        <option value="1170">7:30 Pm</option> 
        <option value="1200" >8:00 Pm</option>
        <option value="1230" >8:30 Pm</option>
        <option value="1260" >9:00 Pm</option>
        <option value="1290" >9:30 Pm</option>
        <option value="1320" >10:00 Pm</option>
        <option value="1350" >10:30 Pm</option>
        <option value="1380" >11:00 Pm</option>
        <option value="1410" >11:30 Pm</option>
        <option value="1440" >12:00 PM</option>
        <option value="30" >0:30 Am</option>
        <option value="60" >1:00 Am</option>
        <option value="90" >1:30 Am</option>
        <option value="120" >2:00 AM</option>
        <option value="150" >2:30 Am</option>
        <option value="180" >3:00 Am</option>
        <option value="210" >3:30 Am</option>
        <option value="240" >4:00 Am</option>
        <option value="270" >4:30 Am</option>
        <option value="300" >5:00 Am</option>
        <option value="330" >5:30 Am</option>
        <option value="360" >6:00 Am</option>
				
      </select><br>
       Fin jornada:  
      
    <select  NAME="hora_fin"  id="hora_fin" OnChange="xajax_turnos_procesar(xajax.getFormValues('turnos_crear'))"  title="Hora en que se FINALIZARA la consulta" >

        <option value="360" >6:00 Am</option>
        <option value="390" >6:30 Am</option>
        <option value="420" >7:00 Am</option>
        <option value="450" >7:30 Am</option>
        <option value="480" >8:00 Am</option>
        <option value="510" >8:30 Am</option>
        <option value="540" >9:00 Am</option>
        <option value="570" >9:30 Am</option>
        <option value="600" >10:00 Am</option>
        <option value="630" >10:30 Am</option>
        <option value="660" >11:00 Am</option>
        <option value="690" >11:30 Am</option>
        <option value="720" >12:00 M</option>
        <option value="750" >12:30 Pm</option>
        <option value="780" >1:00 Pm</option>
        <option value="810" >1:30 Pm</option>
        <option value="840" >2:00 Pm</option>
        <option value="870" >2:30 Pm</option>
        <option value="900" >3:00 Pm</option>
        <option value="930" >3:30 Pm</option>
        <option value="960" >4:00 Pm</option>
        <option value="990" >4:30 Pm</option>
        <option value="1020" >5:00 Pm</option>
        <option value="1050" >5:30 Pm</option>
        <option value="1080" selected >6:00 Pm</option>
        <option value="1140" >6:30 Pm</option>
        <option value="1170" >7:00 Pm</option>
        <option value="1200">7:30 Pm</option> 
        <option value="1230" >8:00 Pm</option>
        <option value="1260" >8:30 Pm</option>
        <option value="1290" >9:00 Pm</option>
        <option value="1320" >9:30 Pm</option>
        <option value="1350" >10:00 Pm</option>
        <option value="1380" >10:30 Pm</option>
        <option value="1410" >11:00 Pm</option>
        <option value="1440" >11:30 Pm</option>
        <option value="1470" >12:00 PM</option>
        <option value="30" >0:30 Am</option>
        <option value="60" >1:00 Am</option>
        <option value="90" >1:30 Am</option>
        <option value="120" >2:00 AM</option>
        <option value="150" >2:30 Am</option>
        <option value="180" >3:00 Am</option>
        <option value="210" >3:30 Am</option>
        <option value="240" >4:00 Am</option>
        <option value="270" >4:30 Am</option>
        <option value="300" >5:00 Am</option>
        <option value="330" >5:30 Am</option>
        <option value="360" >6:00 Am</option>
				
      </select><br>
      
      
       Duraci&oacute;n: 
     <select NAME="duracion"  id="duracion" OnChange="xajax_turnos_procesar(xajax.getFormValues('turnos_crear'))" TITLE="Duracion de cada consulta en minutos">
      <option value="5">5</option>
      <option value="10">10</option>
      <option value="15">15</option>
      <option value="20">20</option>
      <option value="25">25</option>
      <option value="30" selected >30</option>
      <option value="35">35</option>
      <option value="40">40</option>
      <option value="45">45</option>
      <option value="50">50</option>
      <option value="55">55</option>
      <option value="60">60</option>
      <option value="65">65</option>
      <option value="70">70</option>
      <option value="75">75</option>
      <option value="80">80</option>
      <option value="85">85</option>
      <option value="90">90</option>
      <option value="95">95</option>
      <option value="100">100</option>
      <option value="105">105</option>
      <option value="110">110</option>
      <option value="115">115</option>
      <option value="120">120</option>
      </select><br><br>
			<input value="Actualizar" type="button" name="actualizar"  id="actualizar" OnClick="xajax_turnos_procesar(xajax.getFormValues('turnos_crear'))" title="Si cambia la fecha no olvide actualizarla">

      
      </div>
      <input type="hidden" name="tipo" value="revisar">
      <!-- </form> -->
      </td>
      <td bgcolor="<?php echo $_SESSION['mi_bgcolor']; ?>">
      	<div name="turnos_revisar" id="turnos_revisar"  >
      	
      	</div>
      </td>
  		<td >
  			<div name="turnos_grabar" id="turnos_grabar"  >
  			<?php  include_once("calendario/index.php");  ?>
  			</div>
  		</td>
    </tr>
  
</table>
<div align="center">
		
	
</div>



<?php } ?>
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
