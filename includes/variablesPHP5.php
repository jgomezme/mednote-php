<?php
	
	/*  
  
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
	
	Autores: Pedro Obreg�n Mej�as
		 Rub�n D. Mancera Mor�n
	
	Parche PHP5 0.5: Luis Miguel Cabezas Granado
			 
	Versi�n: 1.0
	Fecha Liberaci�n del c�digo: 13/07/2004
	Galop�n para gnuLinEx 2004 -- Extremadura		 
	
	*/

	class variablesPHP5

	{

	function variablesPHP5() {

	    foreach ($_GET as $indice => $valor) {

	        global $$indice;

	        $$indice = $valor;

	    }

	    foreach ($_POST as $indice => $valor) {

	        global $$indice;

	        $$indice = $valor;

	    }
		
		// Parche para que funcione la subida de archivos en PHP5
		
		global $foto_name, $foto;
		$foto_name = $_FILES['foto']['name'];
		$foto = $_FILES['foto']['tmp_name'];
		
    }

}
?>
<?php
$control_version = '0aa0b6b3207f0b3839381db1962574a2'; 
/*
    IMPORTANTE: Esta aplicaci�n fue desarrollada en el marco del proyecto - Opus libertati- 
    plan piloto de investigaci�n aplicada en tecnolog�as de la informaci�n y la comunicaci�n 
    para el sector salud - linea software libre - http://opuslibertati.org
    promovido por el Hospital Departamental Universitario del Quindio San Juan De Dios.
    Si deseas participar, apoyar o colaborar con el desarrollo de esta aplicaci�n o conocer otras   
    lineas de trabajo de nuestro proyecto comunicate con http://ourproject.org/projects/opuslibertati/ 
    o http://opuslibertati.org

    ATENCION: Puede existir una versi�n mas reciente de este archivo en 
    http://ourproject.org/projects/opuslibertati/
    por favor compru�belo antes de modificarlo. versi�n actual: [$version]
    
    Copyright �  13-22-2/ 17-Dic-2008 Direcci�n nacional de derechos de autor Colombia 
    El core y base de datos inicial de la aplicaci�n fue desarrollado por http://GaleNUx.com 
    Es un sistema para de informaci�n para la salud adaptado al sistema de salud Colombiano.
    
    Si necesita consultor�a o capacitaci�n en el manejo, instalaci�n y/o soporte o 
    ampliaci�n de prestaciones de GaleNUx por favor comun�quese al email praxis@galenux.com.

    Este programa es software libre: usted puede redistribuirlo y/o modificarlo 
    bajo los t�rminos de la Licencia Publica General GNU publicada 
    por la Fundaci�n para el Software Libre, ya sea la version 3 
    de la Licencia, o cualquier version posterior.

    Este programa se distribuye con la esperanza de que sea �til, pero 
    SIN GARANTIA ALGUNA; ni siquiera la garant�a impl�cita 
    MERCANTIL o de APTITUD PARA UN PROPOSITO DETERMINADO. 
    Consulte los detalles de la Licencia Publica General GNU para obtener 
    una informaci�n mas detallada. 

    Deber�a haber recibido una copia de la Licencia Publica General GNU 
    junto a este programa. 
    En caso contrario, consulte <http://www.gnu.org/licenses/>.
    
    POR FAVOR CONSERVE ESTA NOTA SI EDITA ESTE ARCHIVO 

 */ 
?>
