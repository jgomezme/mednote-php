<?php 
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: error.php");
// echo "hola mundo2";
}
?>

<table width="85%" border="0" align=center title="Situe el puntero sobre un campo para recibir ayuda">  
	<tr> 
		<td colspan="3">
		
			
		
<script type="text/javascript">

function Verificar()  {
    if (document.buscador.usuario.value==""){
    alert("Este campo no puede estar vacio, seleccione un ID de usuario para continuar")
    document.buscador.usuario.focus();
    return false;
  															}
							}

</script>
	 <?php  	if ($_SESSION['prioridad'] <= "2"){ 
	 include_once ("suscriptores_buscador_procesar.php"); 
	 } else { 
	 if (isset($_REQUEST['usuario'])) {
			$usuario = $_REQUEST['usuario'];
			include_once("suscriptores_buscador_procesar.php");

													}
			else{
			//// buscador por documento
			echo "<form  method='post'  id='buscador' name='buscador' onsubmit=\"return Verificar(this.form)\" autocomplete='off' >";
			 echo suggestivo('documento','d9_users','id','documento_numero','1','Buscar un usuario por documento');	 
			 ////buscador por nombre
			 
			 echo suggestivo('usuario','d9_users','id','nombre_completo','1','Buscar un usuario por nombre o apellido');	 
							?>
			
					<!-- 	Código: <input type='input' name='usuario' id='usuario' size='25' TITLE='Escriba el ID de Usuario' onKeyPress="return acceptNum(event)"> -->
			<!-- <input type="submit" name="boton" value="Buscar usuario"  size='25' title="Buscar un usuario">  -->
			<hr><div align='center'><input type='button' value='CREAR un nuevo usuario' onclick="xajax_wait('formulario');xajax_suscriptores_formulario('','$origen')"></div>
			</form>
			
			<?php }
			?>
			
		</td>
	</tr>
</table>

<?php	 } 
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
