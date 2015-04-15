<?php session_start(); 
 

  $result=mysql_query("SELECT 
  							turnos.estado,
  							turnos.id_turno,
  							turnos.hora_inicio,
  							turnos.observaciones,
  							turnos.recibo,
  							turnos.excedente,
  							d9_users.nombre_completo,
  							d9_users.documento_numero,
  							turnos.especialista,
  							(SELECT nombre_completo FROM d9_users WHERE turnos.especialista = d9_users.id ) AS nombre_especialista
  							FROM turnos, d9_users 
  							WHERE turnos.id_usuario = d9_users.id
  							
  							LIMIT 100",$link); 
?>
 
<center><h2>Usuarios Pendientes por Autorizaci&oacute;n</h2>
  <TABLE BORDER=0 CELLSPACING=2 CELLPADDING=2 width="95%">
      <TR><TD>&nbsp;<B>Usuario</B></TD> <TD>&nbsp;<B>Identificacion</B></TD><TD>&nbsp;<B>Fecha / Hora</B>&nbsp;</TD> <TD>&nbsp;<B>Especialista</B>&nbsp;</TD> <TD>&nbsp;<B>Motivo</B>&nbsp;</TD><TD>&nbsp;<B>Datos</B>&nbsp;</TD></TR>
<?php      

   while($row = mysql_fetch_array($result)) {
      echo"<tr><td>".$row["hora_inicio"]."</td><td >".$row["nombre_completo"]." ".$row["documento_numero"]."</td><td class='BC".$row["especialista"]."' >".$row["nombre_especialista"]."</td><td>".$row["observaciones"]. $row["recibo"]."</td><td>
<form name='autorizar_consulta' id='autorizar_".$row["id_turno"]."'>    <input type='hidden' name='id_turno' value='".$row["id_turno"]."'>  
      
      <img src='images/check.gif' alt='Autorizada'><img src='images/pendiente.gif' alt='Pendiente' onClick=\"xajax_autorizar_consulta(xajax.getFormValues('autorizar_".$row["id_turno"]."'));bloquea();\"><img src='images/eliminar.gif' alt='Cancelada'> estado:".$row["estado"]."
      </form>
      </td></tr>"; 
   }
   mysql_free_result($result);

?> 
</table></center>
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
