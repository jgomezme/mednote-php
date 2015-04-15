<?php 
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: includes/error.php");
// echo "hola mundo2";
} 
?>
<html>
<head>
<title>Impresion de factura</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../../estilos/impresion_pantalla.css" rel="stylesheet" type="text/css" >
<link href="../../estilos/impresion.css" rel="stylesheet" type="text/css" media="print">

</head>
<script>


function SoloCerrar(){
window.close()
							}
</script>
<body  >
<?php
include_once("../../librerias/conex.php");
if($_SESSION['grupo']!='1'){$id_empresa= $_SESSION['id_empresa'];}else {$id_empresa='%%';}
$link=Conectarse();
$id_factura = $_REQUEST['id_factura'];



impresion("$id_factura");
function impresion($id_factura){
global $link ;
mysql_query("SET NAMES 'utf8'");
include_once("../../impresion/datos_empresa.php");
 $factura=mysql_query("SELECT  * 
 											FROM facturas 
 											WHERE facturas.id_factura = $id_factura 
 											AND facturas.id_empresa LIKE  '$id_empresa'
 											AND estado ='1'
 											LIMIT 1",$link); 
/// si la factura existe 
if (mysql_num_rows($factura)!='0'){
while( $row = mysql_fetch_array( $factura ) ) {
																							 $id_factura=$row['id_factura'];
																							 $id_cliente=$row['id_cliente'];
																							 $factura_numero=$row['factura_numero'];
																							 $referencia=$row['referencia'];
																							 $fecha_factura = $row['fecha_factura'];
																								$fecha_factura = date('Y-m-d',$fecha_factura);
																								$fecha_vencimiento = $row['fecha_vencimiento'];
																								$fecha_vencimiento = date('Y-m-d',$fecha_vencimiento);
																								$fecha_pronto_pago = $row['fecha_pronto_pago'];
																								$fecha_pronto_pago = date('Y-m-d',$fecha_pronto_pago);
																								$descuento_pronto_pago = $row['descuento_pronto_pago'];
																								$folios = $row['folios'];
																								$letras = $row['letras'];
																							 $valor=$row['valor'];
																							 $elaboro=$row['elaboro']; 
                            
								 																}
include_once("../../impresion/datos_cliente.php");

$titulo ="usuario _ $id_usuario ";


echo "<div name='cabecera' id='cabecera' ><a href='#'  onclick=SoloCerrar();>[Cerrar]</a><hr></div>";
$nuevo_select .= "
<table border='0' width= '95%' align='center'  height='570' >
		<tr>
			<td>
					<div align='right'> 
					<div align='right' style='border: 1px solid black; width: 300px; padding-right: 10px;'>
					<h2>Factura de venta<br> <font size='+3'># $facturacion_prefijo$factura_numero</font></h2>
					</div>
					</div>
	
					<table border='0' width= '100%' align='center' >
					<tr valign='top'>
					<td>
						<img src='../../images/logo_bn_300.gif' alt=''>
					</td>
					<td>
						<div align='center'>	
					<h1>$razon_social</h1><br>
					<h2>Nit $nit - Régimen $regimen_tributario</h2><br>
					<h3>$direccion 
					Telefonos: $telefono_1 $telefono_2 $telefono_3 email: $email $ciudad $departamento</h3><br>
					<h2>$web</h2><br>
						</div>
					</td>
				</tr>
				<tr >
					<td COLSPAN=2>
					<div align='left' style='border: 1px solid black; width: 75%; padding-right: 5px; padding-left: 5px; padding-top: 0px; padding-bottom: 0px;'>
						<h4>Fecha facturación: <b>$fecha_factura</b> Fecha vencimiento: <b>$fecha_vencimiento</b> Fecha pronto pago: <b>$fecha_pronto_pago</b> Desc. pronto pago: <b>$descuento_pronto_pago</b> %				
						<br>Cliente: <b>$cliente_alias</b> Nit: <b>$cliente_nit</b>
						 <br>Dirección: <b>$cliente_direccion $cliente_ciudad $cliente_departamento</b> Teléfono: <b>$cliente_telefono</b>	
						 <br>Tarifa: <b>$cliente_tarifa $cliente_tarifario_diferencia $suma</b>
						</h4>
						</div><div align='center'><h1>Esta es una prueba de impresión, no constituye un documento legal</h1></div>
					</td>				
				</tr>
				</table>		
			</td>
		</tr>
		<tr>
			<td>
				";
/// turnos de esta factura
include_once("turnos.php");
mysql_query("SET NAMES 'utf8'");
$total=mysql_query("SELECT sum( valor_procedimiento ) AS Total
																										FROM `turnos`
																										WHERE id_factura = $id_factura
																										GROUP BY id_factura",$link);
																		$row = mysql_fetch_row($total);
																		$Total = $row[0];
																		$Total_factura = number_format($row[0], 2, ',', '.'); 
																/// suma para el valor total de excedente y coopago
																
																$total_excedente=mysql_query("SELECT sum( excedente ) AS Excedente
																															FROM `turnos`
																															WHERE id_factura = $id_factura
																															GROUP BY id_factura",$link);
																		$row_excedente = mysql_fetch_row($total_excedente);
																		$Excedente = $row_excedente[0];
																		$Total_excedente = number_format($row_excedente[0], 2, ',', '.'); 
																$Gran_total = ($Total - $Excedente); 
																
																$Gran_total = number_format($Gran_total, 2, ',', '.');
																$ahora=date('Y-m-d H:i:s');
																$nombre_completo = $_SESSION['nombre_completo'];
																$nuevo_select .= "
																									<div align='right'>
																										<table border ='0'>
																											<tr valign='bottom'>
																											<td><h4>http://GaleNUx.com 
																													<br>Imprimi&oacute;: $nombre_completo 
																													<br>$ahora ip: $_SERVER[REMOTE_ADDR]</h4>
																											</td>
																												<td  align='center'>
																												<font size='-1'>Folios:</font><br>$folios
																												</td>
																												<td  align='center'>";
																$Elaboro=mysql_query("SELECT nombre_completo
																															FROM `d9_users`
																															WHERE id = '$elaboro'
																															",$link);
																															
																
																$elaboro=mysql_result($Elaboro,0,"nombre_completo");
																
																$nuevo_select .= "
																												<font size='-1'>$elaboro</font>
																												<hr>Elaboró
																												</td>
																												<td  align='center'>
																												<hr>Recibido por:
																												</td>
																												<td  align='center'>
																												<hr>Autorizado por:
																												</td>
																												<td  align='right'>
																												
																												
																													Valor $ <strong>$Total_factura</strong> <br>
																													 Coopagos o excedentes - $ <strong>$Total_excedente</strong> 
																													 <hr>
																													 <h2>Total: $ $Gran_total</h2>
																												</td>
																											</tr>
																											
																												";
																												
																												$nuevo_select .="
																												
																											
																										</table>
																									</div>
																									";
																												

$nuevo_select .="
			</td>
		</tr>	
		<tr>
			<td>";
			
			$nuevo_select .= "<hr><div align='left'><h4><img src='../../images/vigilado_gris_200.gif' alt='VIGILADO Supersalud '></div>
		<div align='right'></div>
												
			</td>		
		</tr>
								";
echo "$nuevo_select";

///// si la factura no existe
												}else {echo "<div align='center'><img src='../../images/atencion.gif' alt='[!]'><br><h1>La factura no existe o no cuenta con permisos suficientes para la impresión </h1></div>";}
							}///// fin de la funcion mpresion
?>
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
