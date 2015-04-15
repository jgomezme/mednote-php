<?php  if (  $_SESSION['grupo'] == "3" ) {

echo "";
}ELSE { echo "";}
?>


<?php 
function listado($id){
$id=$id;
$link=Conectarse(); 
$listado_reportes=mysql_query("

SELECT fecha_inicio, asunto, descripcion,nombre_completo , id_servicio_cliente
FROM `servicio_cliente` ,`d9_users` 
WHERE  servicio_cliente.id = $id 

AND servicio_cliente.cerrado != '1'
AND d9_users.id = funcionario
ORDER BY fecha_inicio DESC",$link);

if (mysql_num_rows($listado_reportes)!=0)
	{
echo "<h2>Mensajes o reportes pendientes</h2>";
echo "<table align=center border=0 title='Reportes de servicio al cliente'>";
echo "<td align=center>Fecha</td>";
echo "<td align=center>Asunto</td>";
echo "<td  align=right>Descripci&oacute;n</td>
<td  align=center>Funcionario</td><td  align=center>Acci&oacute;n</td>
</tr><tr>";



while($salida = mysql_fetch_array($listado_reportes)){

       for ($i=0;$i<5;$i++){


        if($i!=4){       

    echo "<td  bgcolor='#fde0ac'><font size=-2>",$salida[$i],"</font></td>";
        				}else{
        echo "<td bgcolor='#fde0ac'>
        			<a HREF=\"javascript:abrir('suscriptores/presentacion/enviar_correo.php?id=$id&responder=$salida[id_servicio_cliente]','enviar_correo',600,300,100,0,1)\" TITLE='Responder'><p>Responder</p></a>
       
        <form id='mensaje' name='mensaje'><center>
        <input type='hidden' name='id_servicio_cliente' value='$salida[id_servicio_cliente]'>
        <input type='hidden' name='id' value='$id'>
      <input  value='(X)' onclick=\"xajax_servicio_cliente(xajax.getFormValues('mensaje'))\" type='button' title='Marcar como leido'></form></center></td></tr>";

    							}
        							}   
																		}

 
?>
</tr>
</table>

<?php }else{}
    							}
    echo "<div id='servicio_cliente'>";
    if ($id < '1')  {$id=$_SESSION['id_usuario'];}
    listado($id);
    echo "</div>";
    

   
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
