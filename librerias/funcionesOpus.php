<?php
include_once '../includes/config.php';

/*
 * Libreria de opuslibertati para crear funciones que se 
 * necesiten durante el desarrollo de nuevas funcionalidades
 */

//peticiones por GET
if(isset($_GET['req'])){
	$requerimiento = $_GET['req'];
	
	//requerimientos de autorizaciones
	if($requerimiento == "autorizaciones"){
		if(isset($_GET['opcion']) && isset($_GET['id'])){
			$opcion =  $_GET['opcion'];
			$id = $_GET['id'];
			if($opcion== "enviar"){
				updateEstadoAutorizacion(2,$id);
				echo "<a href='#' onclick='cambiarEstadoSolicitudAutorizacion(\"confirmar\" , \"$id\");return false;'>Autorizar</a>";
			}else if($opcion== "confirmar"){
				updateEstadoAutorizacion(3,$id);
				echo "Autorizado";
			}
		}				
	}
	
	//otros requerimientos
}

//################## FUNCIONES DE LOS REQUERIMIETOS##################



function updateEstadoAutorizacion($estado, $id){
	$conexion = conect();
		$campo = "";
		if($estado== "2"){
			$campo = "horaenvio";		
		}else if($estado== "3"){
			$campo = "horaconfirma";
		}
	$sql="UPDATE  autorizaciones_solicitud SET  estado =  '$estado', $campo = NOW( ) WHERE  id_autorizacion_solicitud =$id";
	mysql_query($sql,$conexion);
	mysql_close($conexion);
}



?>