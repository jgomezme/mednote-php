<?php
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: includes/error.php");
// echo "hola mundo2";
} 
 
 
function contratos_select($capa){
$id_empresa = $_SESSION['id_empresa'];
$link = Conectarse();
mysql_query ("SET NAMES 'utf8'");
$nuevo_select .="";
$nuevo_select .= "<select name='id_cliente' title='Elija un contrato ' style='width: 400;text-align: left;' onChange=\"xajax_terceros(this.value,'6','$capa')\" >"; 
$nuevo_select .= "<option value='' title='Seleccione un contrato'> Seleccione un contrato </option>";
$nuevo_select .= "<option value='nuevo' title='Incluir un nuevo contrato'> [ Nuevo Contrato ]</option>";
$Contratos=mysql_query("SELECT * FROM clientes WHERE id_empresa ='$id_empresa' ",$link);
if(mysql_num_rows($Contratos) >0) {

while( $row = mysql_fetch_array( $Contratos ) ) {
$nuevo_select .= "<option value='$row[id_cliente]' title='$row[objeto_contrato]'>$row[numero_contrato] | $row[alias]</option>";
																}
$nuevo_select .= "</select>"; 
												}
$nuevo_select .="<div name='$capa' id='$capa'></div>";
return $nuevo_select;
									}
									
							
function contratos_listado($grupo,$titulo){
$grupo=$grupo;

$id_empresa = $_SESSION['id_empresa'];
$clientes_listado .= "
						

						<div align='center'><h2>$titulo</h2></div><hr>
						<table border='0'  width='95%' colspan='2' rowspan='2' align='center' valign='top'>
						
						<tr align='center'>
							<td width='20%'><b>Razón social empresa</b></td>
							<td width='20%'><b>Referencia</b></td>
							<td width=''><b>Objeto</b></td>
							<td width='100'><b>Inicio</b></td>
							<td width='100'><b>Fin</b></td>
							
						</tr>
						</table>
						";
$clientes_listado .= "					<div name='terceros_nuevo' id='terceros_nuevo'>
																
																	<tr title= 'Click para editar este contrato'
																				onClick=\"xajax_terceros('nuevo','6')\"
																				 valign='top'  bgcolor='beige'  onMouseOver=\"uno(this,'yellow');\" onMouseOut=\"dos(this,'beige');\">
																				
																					<td colspan='5' align='center'><b>[ Nuevo Contrato]</b></td>
																		</tr>					
																	
																</div>
																					
																						";
$link=Conectarse(); 
mysql_query ("SET NAMES 'utf8'");
 if($id_empresa != ''){
										$Clientes=mysql_query("SELECT * FROM clientes WHERE id_empresa= $id_empresa",$link);  
										if (mysql_num_rows($Clientes)!='0'){
										while( $row = mysql_fetch_array( $Clientes ) ) {
							$inicio_contrato =	$row['inicio_contrato'];
							if ($inicio_contrato == ''){	$inicio_contrato = '';}
							elseif($inicio_contrato == '0'){$inicio_contrato = '';}
							else {$inicio_contrato = $inicio_contrato;}
							$fin_contrato =	$row['vencimiento_contrato'];
							if ($fin_contrato == ''){	$fin_contrato = '';}
							elseif($fin_contrato == '0'){$fin_contrato = '';}
							else {$fin_contrato = $fin_contrato;}
									$clientes_listado .= "<div name='terceros_".$row['id_cliente']."' id='terceros_".$row['id_cliente']."'>
																			
																				<tr  title= 'Click para editar este contrato'
																				onClick=\"xajax_terceros(".$row['id_cliente'].",'6')\"
																				 valign='top'  bgcolor='beige'  onMouseOver=\"uno(this,'c2f0e5');\" onMouseOut=\"dos(this,'FFFFFF');\" bgcolor='#FFFFFF'>
																																										
																					<td width='20%' NOWRAP>[".$row['id_cliente']."]".$row['razon_social']." ".$row['codigo']."</td>
																					<td width='20%'>".$row['alias']."</td>
																					<td width=''>".$row['objeto_contrato']."</td>
																					<td width='100'>$inicio_contrato</td>
																					<td width='100'>$fin_contrato </td>
																					
																				</tr>
																				
																					</div>
																					<div name='terceros_error_".$row['id_cliente']."' id='terceros_error_".$row['id_cliente']."' align='center'></div>
																					
																				";

																												}
																				}
}

			$clientes_listado .=  "<hr>"; 
							
return $clientes_listado;
																	} /// fin  de la funcion


function contratos($origen){
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
											$nuevo_select .= "
															<form name='tercero_modificar' id='tercero_modificar'>
															<input name='id_cliente' id='id_cliente'  type='hidden' value='nuevo' >
															<input type='hidden' name='control' value='$_SESSION[id_empresa]-$_SESSION[id_usuario]-".microtime()."'>
															<input name='origen' id='origen'  type='hidden' value='$origen' >
															<input name='grupo' id='grupo'  type='hidden' value='6' >
															<table border=0 width='80%' align='center'>
															
															 <tr>
															  		<td width='30%'> <div align='right'>Codigo Cliente</div></td>
															
															  		<td>
															  		<input name='codigo' id='codigo' size='30' maxlength='255' type='text' value='$codigo' title='Codigo o registro que saldra en RIPS de la entidad'>
																	<select name='activo' title='Marcar si se encuentra activa la negociacion con la entidad'>
																<option value='0'>Inactivo</option>
																<option value='1' selected>Activo</option>		
																</select>  		
														  		
														  		</td> 
														  	</tr>
															<tr>
																<td width='30%'> <div align='right'>Empresa</div></td>
																<td><input name='razon_social' id='razon_social' size='60' maxlength='255' type='text' value='$razon_social' title='Nombre general con que se conoce la entidad' ></td> 
															</tr>
															<tr>
																<td width='30%'> <div align='right'>Nombre o referencia del contrato</div></td>
														
																<td><input name='alias' id='alias' size='60' maxlength='255' type='text' value='$alias' title='Division o subempresa a nombre de quien se facturara y/o generaran los RIPS'></td>  
															</tr>
																<tr>
																<td width='30%'> <div align='right'>Nit</div></td>
														
																<td><input name='nit' id='nit' size='10' maxlength='10' type='text' value='$nit' title='Nit de la empresa'></td>  
															</tr>
															<tr>
																<td width='30%'> <div align='right'>Objeto del Contrato</div></td>
																<td><textarea id='objeto_contrato' name='objeto_contrato' rows='5' cols='60' title='Pegar aqui el objeto de contrato para tenerlo como referencia'>$objeto_contrato</textarea></td> 
															</tr>
														<tr>
																<td width='30%'> 
																	<div align='right'>Limites del Contrato: </div>
																</td>
																<td>
																	Monto: $ <input name='monto_contrato' id='monto_contrato' size='20' maxlength='50' type='text' value='$monto_contrato' title='monto pactado en el contrato' ><br>
																			";
															$hoy = date('Y-m-d');
																	
																	$nuevo_select .="
																	Fecha Inicio: <input readonly='readonly' size='10' id='fc $grupo _1' title='YYYY-MM-DD' onclick='displayCalendar(this);' name='inicio_contrato' value='$inicio_contrato' type='text'>
																	Fecha Vencimiento: <input readonly='readonly' size='10' id='fc $grupo _2' title='YYYY-MM-DD' onclick='displayCalendar(this);' name='vencimiento_contrato' value='$vencimiento_contrato' type='text'>
					
																	</td>
																</tr>
															<tr><td width='30%'> <div align='right'>Contacto General</div></td><td><input name='contacto_general' id='contacto_general' size='60' maxlength='255' type='text' value='$contacto_general' title='Personal con quien se tiene contacto en la entidad' ></td> </tr>
															<tr><td width='30%'> <div align='right'>Contacto Medico</div></td><td><input name='contacto_medico' id='contacto_medico' size='60' maxlength='255' type='text' value='$contacto_medico' title='Personal medico con quien se tiene contacto en la entidad' ></td> </tr>
															<tr><td width='30%'> <div align='right'>Contacto Administrativo</div></td><td><input name='contacto_administrativo' id='contacto_administrativo' size='60' maxlength='255' type='text' value='$contacto_administrativo' title='Personal administrativo con quien se tiene contacto en la entidad' ></td> </tr>
															<tr><td width='30%'> <div align='right'>Telefono</div></td><td><input name='telefono' id='telefono' size='30' maxlength='60' type='text' value='$telefono' title='Telefono oficial de contacto'></td> </tr>
															<tr><td width='30%'> <div align='right'>E Mail</div></td><td><input name='e_mail' value='$email' id='e_mail' size='60' maxlength='60' type='text' title='Email oficial de la entidad'></td> </tr>
															<tr><td width='30%'></td><td><select name='tarifario' title='Tarifas negociada con esa entidad'>";

													$nuevo_select .="<option value='' selected >Elija un tarifario</option>";
														
													$Tarifas=mysql_query("SELECT * FROM tarifas",$link);   
													while( $row = mysql_fetch_array( $Tarifas ) ) {
													$nuevo_select .="<option value='".$row['id_tarifa']."'>".$row['tarifa_nombre']."</option>";
																																				}
													$nuevo_select .="</select><select name='suma' id='suma' title='Diferencia entre el tarifario elegido y el cobro, puede ser: Mas, Menos o Igual'>";
													
													$nuevo_select .="	<option value='='>Igual</option>
																						<option value='+'>Mas </option>
																						<option value='-'>Menos</option>
																					</select>
													
													 <input name='tarifario_diferencia' value='$tarifario_diferencia' id='tarifario_diferencia' size='3' maxlength='3' type='text' title='Puntos de diferencia en porcentaje entre el tarifario elegido y el valor a cobrar'>% </td> </tr>
													<tr><td width='30%' colspan='2'><div align='center'>
													<hr>
													<input type='button' OnClick=\"xajax_terceros_modificar(xajax.getFormValues('tercero_modificar'))\" title='Pulse una vez para guardar los cambio' value='Grabar'></center></td> </tr>
													
													
													
													</table>
													";
													return $nuevo_select;


														}

///NOMBRE DE LA FUNCION: terceros
function terceros($id_cliente,$grupo,$capa){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');

$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
//$sql=mysql_query("SELECT * FROM clientes WHERE id_cliente = $id_cliente ",$link);
//if (mysql_num_rows($sql)!='0'){
if ($id_cliente != ""){ /// SI NO ESTA VACIO
									
		if ($grupo == "6")	{ /// SI GRUPO = 6
											$nuevo_select .="<H1>Clientes y contratos</h1>";
if ($id_cliente == "nuevo"){ /// SI ES NUEVO 
											$nuevo_select .= "
															<div name='terceros_error_nuevo' id='terceros_error_nuevo' align='center'></div>
															
															<form name='tercero_modificar' id='tercero_modificar'>
															<input name='capa' id='capa'  type='hidden' value='$capa' >
															<input type='hidden' name='control' value='$_SESSION[id_empresa]-$_SESSION[id_usuario]-".microtime()."'>
															<input name='id_cliente' id='id_cliente'  type='hidden' value='nuevo' >
															<input name='grupo' id='grupo'  type='hidden' value='$grupo' >
															<hr><table border=0 width='80%' align='center'>
					
					 	<tr><td width='30%'> <div align='right'>Código habilitación del cliente</div></td><td><input name='codigo' id='codigo' size='30' maxlength='255' type='text' value='$codigo' title='Codigo o registro que saldra en RIPS de la entidad'>
						<tr><td width='30%'> <div align='right'>Número contrato</div></td><td><input name='numero_contrato' id='numero_contrato' size='30' maxlength='255' type='text' value='$numero_contrato' title='Identificador interno del contrato'>
							<select name='estado' title='Marcar si se encuentra activa la negociacion con la entidad'>";
					if ($activo == "1")$nuevo_select .="<option value='1' selected >> Vigente <</option>";
					if ($activo == "2")$nuevo_select .="<option value='2' selected >> Suspendido <</option>";
					
					if ($activo == "3")$nuevo_select .="<option value='3' selected >> Terminado <</option>";
					$nuevo_select .="
							<option value='1'>Vigente</option>
							<option value='2'>Suspendido</option>	
							<option value='3'>Terminado</option>		
							</select>  		
					  		
					  		</td> 
					  	</tr>
						<tr>
							<td width='30%'> <div align='right'>Razón social empresa</div></td>
							<td><input name='razon_social' id='razon_social' size='60' maxlength='255' type='text' value='$razon_social' title='Nombre general con que se conoce la entidad' ></td> 
						</tr>
						<tr>
							<td width='30%'> <div align='right'>Nombre o referencia del contrato</div></td>
					
							<td><input name='alias' id='alias' size='60' maxlength='255' type='text' value='$alias' title='Division o subempresa a nombre de quien se facturara y/o generaran los RIPS'></td>  
						</tr>	
						<tr>
							<td width='30%'> <div align='right'>Nit</div></td>
					
							<td><input name='nit' id='nit' size='60' maxlength='50' type='text' value='$nit' title='Nit de la empresa'></td>  
						</tr>
						<tr>
							<td width='30%'> <div align='right'>Objeto del Contrato</div></td>
							<td><textarea id='objeto_contrato' name='objeto_contrato' rows='5' cols='60' title='Pegar aqui el objeto de contrato para tenerlo como referencia'>$objeto_contrato</textarea></td> 
						</tr>
						<tr>
							<td width='30%'> 
								<div align='right'>Limites del Contrato: </div>
							</td>
							<td>
								Monto: $<input name='monto_contrato' id='monto_contrato' size='20' maxlength='50' type='text' value='$monto_contrato' title='monto pactado en el contrato' ><br>
							";
							if ($vencimiento_contrato != '0'){	$vencimiento_contrato = $vencimiento_contrato;}
							else{$vencimiento_contrato='';}
							if ($inicio_contrato != '0'){$inicio_contrato = $inicio_contrato;}
							else{$inicio_contrato='';}
							
							
							$nuevo_select .= "
								Fecha Inicio: <input readonly='readonly' size='10' id='fc $grupo _1' title='YYYY-MM-DD' onclick='displayCalendar(this);' name='inicio_contrato' value='$inicio_contrato' type='text'>
								Fecha Vencimiento: <input readonly='readonly' size='10' id='fc $grupo _2' title='YYYY-MM-DD' onclick='displayCalendar(this);' name='vencimiento_contrato' value='$vencimiento_contrato' type='text'>
					
							</td>
						</tr>
						
					
					<tr><td width='30%'> <div align='right'>Contacto General</div></td><td><input name='contacto_general' id='contacto_general' size='60' maxlength='255' type='text' value='$contacto_general' title='Personal con quien se tiene contacto en la entidad' ></td> </tr>
					<tr><td width='30%'> <div align='right'>Contacto Medico</div></td><td><input name='contacto_medico' id='contacto_medico' size='60' maxlength='255' type='text' value='$contacto_medico' title='Personal medico con quien se tiene contacto en la entidad' ></td> </tr>
					<tr><td width='30%'> <div align='right'>Contacto Administrativo</div></td><td><input name='contacto_administrativo' id='contacto_administrativo' size='60' maxlength='255' type='text' value='$contacto_administrativo' title='Personal administrativo con quien se tiene contacto en la entidad' ></td> </tr>
					<tr><td width='30%'> <div align='right'>Telefono fijo</div></td><td><input name='telefono_fijo' id='telefono_fijo' size='30' maxlength='60' type='text' value='$telefono_fijo' title='Telefono fijo de contacto'></td> </tr>
					<tr><td width='30%'> <div align='right'>Telefono celular</div></td><td><input name='telefono_celular' id='telefono_fijo' size='30' maxlength='60' type='text' value='$telefono_celular' title='Telefono móvil de contacto'></td> </tr>
					<tr><td width='30%'> <div align='right'>Telefono auditor</div></td><td><input name='telefono_auditor' id='telefono_auditor' size='30' maxlength='60' type='text' value='$telefono_auditor' title='Telefono auditor médico'></td> </tr>
					<tr><td width='30%'> <div align='right'>Direccion</div></td><td><input name='direccion' value='$direccion' id='direccion' size='60' maxlength='150' type='text' title='Direccion oficial de la entidad'></td> </tr>
					<tr><td width='30%'> <div align='right'></div></td><td>Departamento: <input name='departamento' value='$departamento' id='departamento' size='2' maxlength='2' type='text' title='Departamento según DIVIPOLA'>
																							 Ciudad: <input name='ciudad' value='$ciudad' id='ciudad' size='3' maxlength='3' type='text' title='Departamento según DIVIPOLA'>
																							Barrio: <input name='barrio' value='$barrio' id='barrio' size='30' maxlength='50' type='text' title='Barrio de la entidad'></td> </tr>
					<tr><td width='30%'> <div align='right'>Correo para autorizaciones</div></td><td><input name='email_autorizaciones' value='$email_autorizaciones' id='email_autorizaciones' size='60' maxlength='50' type='text' title='Email para el envío de autorizaciones'></td> </tr>
					<tr><td width='30%'> <div align='right'>Correo administrativo</div></td><td><input name='email_administrativo' value='$email_administrativo' id='email_administrativo' size='60' maxlength='50' type='text' title='Email administrativo'></td> </tr>
					<tr><td width='30%'> <div align='right'>Correo auditor médico</div></td><td><input name='email_medico_auditor' value='$email_medico_auditor' id='email_medico_auditor' size='60' maxlength='50' type='text' title='Email auditor médico'></td> </tr>
					
					<tr><td width='30%' colspan='2'><div align='center'>
					 <input type='button' OnClick=\"xajax_terceros_modificar(xajax.getFormValues('tercero_modificar'))\" title='Pulse una vez para guardar los cambio' value='Modificar'>			
					</center></td> </tr>
					
					
					
					</table>
													";
		
											}/// FIN DE NUEVO 
											else
											{/// SI NO ES NUEVO
					$sql=mysql_query("SELECT * FROM clientes WHERE id_cliente = '$id_cliente' ",$link);
					
					while( $row = mysql_fetch_array( $sql ) ) {
					$codigo=$row['codigo'];
					$numero_contrato=$row['numero_contrato'];
					$id_cliente=$row['id_cliente'];
					$razon_social=$row['razon_social'];
					$alias=$row['alias']; 
					$nit=$row['nit']; 
					$objeto_contrato=$row['objeto_contrato'];
					$monto_contrato=$row['monto_contrato'];
					$vencimiento_contrato=$row['vencimiento_contrato'];
					$inicio_contrato=$row['inicio_contrato'];
					$contacto_general=$row['contacto_general'];
					$contacto_medico=$row['contacto_medico'];
					$contacto_administrativo=$row['contacto_administrativo'];
					$telefono_fijo=$row['telefono_fijo'];
					$telefono_celular=$row['telefono_celular'];
					$telefono_auditor=$row['telefono_auditor'];
					$email_autorizaciones=$row['email_autorizaciones'];
					$email_administrativo=$row['email_administrativo'];
					$email_medico_auditor=$row['email_medico_auditor'];
					$direccion=$row['direccion'];
					$departamento=$row['departamento'];
					$ciudad=$row['ciudad'];
					$barrio=$row['barrio'];
					
					
					$activo=$row['estado'];

																										}
											
					    
					$nuevo_select .= "
					<form name='tercero_modificar' id='tercero_modificar'>
					<input name='id_cliente' id='id_cliente'  type='hidden' value='$id_cliente' >
					<input name='capa' id='capa'  type='hidden' value='$capa' >
					<input type='hidden' name='control' value='$_SESSION[id_empresa]-$_SESSION[id_usuario]-".microtime()."'>
					<input name='grupo' id='grupo'  type='hidden' value='$grupo' >
					<hr><table border=0 width='80%' align='center'>
					
					 <tr><td width='30%'> <div align='right'>Código habilitación del cliente</div></td><td><input name='codigo' id='codigo' size='30' maxlength='255' type='text' value='$codigo' title='Codigo o registro que saldra en RIPS de la entidad'>
						<tr><td width='30%'> <div align='right'>Número contrato</div></td><td><input name='numero_contrato' id='numero_contrato' size='30' maxlength='255' type='text' value='$numero_contrato' title='Identificador interno del contrato'>
						<select name='estado' title='Marcar si se encuentra activa la negociacion con la entidad'>";
					if ($activo == "1")$nuevo_select .="<option value='1' selected >> Vigente <</option>";
					if ($activo == "2")$nuevo_select .="<option value='2' selected >> Suspendido <</option>";
					
					if ($activo == "3")$nuevo_select .="<option value='3' selected >> Terminado <</option>";
					$nuevo_select .="
							<option value='1'>Vigente</option>
							<option value='2'>Suspendido</option>	
							<option value='3'>Terminado</option>		
							</select>  		
					  		
					  		</td> 
					  	</tr>
						<tr>
							<td width='30%'> <div align='right'>Razón social empresa</div></td>
							<td><input name='razon_social' id='razon_social' size='60' maxlength='255' type='text' value='$razon_social' title='Nombre general con que se conoce la entidad' ></td> 
						</tr>
						<tr>
							<td width='30%'> <div align='right'>Nombre o referencia del contrato</div></td>
					
							<td><input name='alias' id='alias' size='60' maxlength='255' type='text' value='$alias' title='Division o subempresa a nombre de quien se facturara y/o generaran los RIPS'></td>  
						</tr>	
						<tr>
							<td width='30%'> <div align='right'>Nit</div></td>
					
							<td><input name='nit' id='nit' size='60' maxlength='50' type='text' value='$nit' title='Nit de la empresa'></td>  
						</tr>
						<tr>
							<td width='30%'> <div align='right'>Objeto del Contrato</div></td>
							<td><textarea id='objeto_contrato' name='objeto_contrato' rows='5' cols='60' title='Pegar aqui el objeto de contrato para tenerlo como referencia'>$objeto_contrato</textarea></td> 
						</tr>
						<tr>
							<td width='30%'> 
								<div align='right'>Limites del Contrato: </div>
							</td>
							<td>
								Monto: $<input name='monto_contrato' id='monto_contrato' size='20' maxlength='50' type='text' value='$monto_contrato' title='monto pactado en el contrato' ><br>
							";
							if ($vencimiento_contrato != '0'){	$vencimiento_contrato = $vencimiento_contrato;}
							else{$vencimiento_contrato='';}
							if ($inicio_contrato != '0'){$inicio_contrato = $inicio_contrato;}
							else{$inicio_contrato='';}
							
							
							$nuevo_select .= "
								Fecha Inicio: <input readonly='readonly' size='10' id='fc $grupo _1' title='YYYY-MM-DD' onclick='displayCalendar(this);' name='inicio_contrato' value='$inicio_contrato' type='text'>
								Fecha Vencimiento: <input readonly='readonly' size='10' id='fc $grupo _2' title='YYYY-MM-DD' onclick='displayCalendar(this);' name='vencimiento_contrato' value='$vencimiento_contrato' type='text'>
					
							</td>
						</tr>
						
					
					<tr><td width='30%'> <div align='right'>Contacto General</div></td><td><input name='contacto_general' id='contacto_general' size='60' maxlength='255' type='text' value='$contacto_general' title='Personal con quien se tiene contacto en la entidad' ></td> </tr>
					<tr><td width='30%'> <div align='right'>Contacto Medico</div></td><td><input name='contacto_medico' id='contacto_medico' size='60' maxlength='255' type='text' value='$contacto_medico' title='Personal medico con quien se tiene contacto en la entidad' ></td> </tr>
					<tr><td width='30%'> <div align='right'>Contacto Administrativo</div></td><td><input name='contacto_administrativo' id='contacto_administrativo' size='60' maxlength='255' type='text' value='$contacto_administrativo' title='Personal administrativo con quien se tiene contacto en la entidad' ></td> </tr>
					<tr><td width='30%'> <div align='right'>Telefono fijo</div></td><td><input name='telefono_fijo' id='telefono_fijo' size='30' maxlength='60' type='text' value='$telefono_fijo' title='Telefono fijo de contacto'></td> </tr>
					<tr><td width='30%'> <div align='right'>Telefono celular</div></td><td><input name='telefono_celular' id='telefono_fijo' size='30' maxlength='60' type='text' value='$telefono_celular' title='Telefono móvil de contacto'></td> </tr>
					<tr><td width='30%'> <div align='right'>Telefono auditor</div></td><td><input name='telefono_auditor' id='telefono_auditor' size='30' maxlength='60' type='text' value='$telefono_auditor' title='Telefono auditor médico'></td> </tr>
					<tr><td width='30%'> <div align='right'>Direccion</div></td><td><input name='direccion' value='$direccion' id='direccion' size='60' maxlength='150' type='text' title='Direccion oficial de la entidad'></td> </tr>
					<tr><td width='30%'> <div align='right'></div></td><td>Departamento: <input name='departamento' value='$departamento' id='departamento' size='2' maxlength='2' type='text' title='Departamento según DIVIPOLA'>
																							 Ciudad: <input name='ciudad' value='$ciudad' id='ciudad' size='3' maxlength='3' type='text' title='Departamento según DIVIPOLA'>
																							Barrio: <input name='barrio' value='$barrio' id='barrio' size='30' maxlength='50' type='text' title='Barrio de la entidad'></td> </tr>
					<tr><td width='30%'> <div align='right'>Correo para autorizaciones</div></td><td><input name='email_autorizaciones' value='$email_autorizaciones' id='email_autorizaciones' size='60' maxlength='50' type='text' title='Email para el envío de autorizaciones'></td> </tr>
					<tr><td width='30%'> <div align='right'>Correo administrativo</div></td><td><input name='email_administrativo' value='$email_administrativo' id='email_administrativo' size='60' maxlength='50' type='text' title='Email administrativo'></td> </tr>
					<tr><td width='30%'> <div align='right'>Correo auditor médico</div></td><td><input name='email_medico_auditor' value='$email_medico_auditor' id='email_medico_auditor' size='60' maxlength='50' type='text' title='Email auditor médico'></td> </tr>
					
					<tr><td width='30%' colspan='2'><div align='center'>
					<input type='button' OnClick=\"xajax_terceros_modificar(xajax.getFormValues('tercero_modificar'))\" title='Pulse una vez para guardar los cambio' value='Modificar'>					
					</center></td> </tr>
					
					
					
					</table>
					";

											}/// FIN DE SI NO ES NUEVO

												}	/// FIN SI GRUPO = 6

	if ($grupo == "3")	{ /// SI GRUPO = 3
											$nuevo_select .="<H1 >Médicos o especialistas</h1>";
											$sql=mysql_query("SELECT * FROM especialistas WHERE id = $Valor ",$link);
													while( $row = mysql_fetch_array( $sql ) ) {
													$id_especialista=$row['id_especialista'];
													$registro_medico=$row['registro_medico'];
													$especialidad=$row['especialidad'];
													$universidad_especializacion=$row['universidad_especializacion']; 
													$cargo=$row['cargo'];  
													$universidad_pregrado=$row['universidad_pregrado']; 
													$objeto_contrato=$row['objeto_contrato'];
													$slogan=$row['slogan'];
													$color=$row['color'];
													$fecha_vinculacion=$row['fecha_vinculacion'];
													$fecha_vencimiento=$row['fecha_vencimiento'];
													$activo=$row['activo'];
																																			}
													$nuevo_select .= "
														<form name='tercero_modificar' id='tercero_modificar'>
														<input name='id_especialista' id='id_especialista'  type='hidden' value='$id_especialista' >
														<input name='id_usuario' id='id_usuario'  type='hidden' value='$Valor' >
														<input name='grupo' id='grupo'  type='hidden' value='$grupo' >
														<hr><table border=0 width='80%' align='center'>
														
														 <tr>
														  		<td width='30%'></td>
														
														  		<td>
														  		<select name='activo' title='Marcar si se encuentra activo'>";
														if ($activo == "0")$nuevo_select .="<option value='0' selected >> Inactivo <</option>";
														if ($activo == "1")$nuevo_select .="<option value='1' selected >> Activo <</option>";
														
														if ($activo == "")$nuevo_select .="<option value='0' selected >> Inactivo <</option>";
														$nuevo_select .="
																<option value='0'>Inactivo</option>
																<option value='1'>Activo</option>		
																</select>  		
														  		
														  		</td> 
														  	</tr>
															<tr>
																<td width='30%'> <div align='right'>Registro m&eacute;dico: </div></td>
																<td><input name='registro_medico' id='registro_medico' size='60' maxlength='255' type='text' value='$registro_medico' title='Registro medico' ></td> 
															</tr>
															<tr>
																<td width='30%'><div align='right'>Universidad Pregrado: </div></td>
																<td><input name='universidad_pregrado' id='universidad_pregrado' size='60'
																 maxlength='255' type='text' value='$universidad_pregrado' title='universidad_pregrado' ></td> 
															</tr>
															<tr>
																<td width='30%'><div align='right'>Especialidad: </div></td>
																<td><input name='especialidad' id='especialidad' size='60'
																 maxlength='255' type='text' value='$especialidad' title='especialidad' ></td> 
															</tr>
															<tr>
																<td width='30%'><div align='right'>Universidad Especializaci&oacute;n: </div></td>
																<td><input name='universidad_especializacion' id='universidad_especializacion' size='60'
																 maxlength='255' type='text' value='$universidad_especializacion' title='universidad_especializacion' ></td> 
															</tr>
															<tr>
																<td width='30%'><div align='right'> Cargo: </div></td>
																<td><input name='cargo' id='cargo' size='60'
																 maxlength='255' type='text' value='$cargo' title='Cargo' ></td> 
															</tr>
															<tr>
																<td width='30%'><div align='right'> Slogan: </div></td>
																<td><textarea name='slogan' id='slogan' cols='60' rows='3'
																 maxlength='255'  title='Slogan' >$slogan</textarea></td> 
															</tr>
															<tr>
																<td width='30%'> <div align='right'>Objeto del Contrato</div></td>
																<td><textarea id='objeto_contrato' name='objeto_contrato' rows='5' cols='60' title='Pegar aqui el objeto de contrato para tenerlo como referencia'>$objeto_contrato</textarea></td> 
															</tr>
															<tr>
														
																<td width='30%' ><div align='right'> Color: </div></td>
																<td id='colorin' name='colorin' bgColor='$color' title='Con este color el usuario se identifica en el sistema'><input name='color' id='color' size='12'
																 maxlength='12' type='text' value='$color' onclick=\"lanzarSubmenu() ; modificarElemento()\">
																 <a onclick=\"modificarElemento()\" > Probar </a>
														
																 </td> <td  width='30%'></td>
															</tr>
															<tr>
																<td width='30%'><div align='right'> </div></td>
																<td>Fecha vinculaci&oacute;n: <input size='10' id='fc_1213927245' type='text' name='fecha_vinculacion' title='YYYY-MM-DD' onClick=\"displayCalendar(this);\" value='$fecha_vinculacion'>
																 Vencimiento: <input size='10' id='fc_1213927246' type='text' name='fecha_vencimiento' title='YYYY-MM-DD' onClick=\"displayCalendar(this);\" value='$fecha_vencimiento'></td> 
															</tr>
															<tr><td width='30%' colspan='2'><div align='center'><a OnClick=\"xajax_terceros_modificar(xajax.getFormValues('tercero_modificar'))\" title='Pulse una vez para guardar los cambio'>[ Modificar ]</a></center></td> </tr>
															";
											}	/// FIN SI GRUPO = 3



									}/// FIN DE SI NO ESTA VACIO
									else {$nuevo_select .="<center><h1><img src='images/atencion.gif' alt='[!]' title='Seleccione un item'> No se ha seleccionado!</h1></center>";}
									// $nuevo_select.= contratos_select('$capa');
$respuesta->addAssign($capa,"innerHTML",$nuevo_select);
return $respuesta;

} 

/// FIN DE LA FUNCION terceros

///NOMBRE DE LA FUNCION: terceros_modificar
function terceros_modificar($variable_array){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');

$capa=$variable_array['capa']; 
$grupo=$variable_array['grupo']; 
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'"); 


if ($grupo=='6'){
$id_cliente = $variable_array["id_cliente"];
$alias=$variable_array['alias'];
$codigo=$variable_array['codigo'];
$razon_social=$variable_array['razon_social'];
$origen=$variable_array['origen'];
$numero_contrato=$variable_array['numero_contrato'];
$monto_contrato=$variable_array['monto_contrato'];
$telefono_fijo=$variable_array['telefono_fijo'];
$telefono_celular=$variable_array['telefono_celular'];
$telefono_auditor=$variable_array['telefono_auditor'];
$direccion=$variable_array['direccion'];
$departamento=$variable_array['departamento'];
$ciudad=$variable_array['ciudad'];
$barrio=$variable_array['barrio'];
$email_autorizaciones=$variable_array['email_autorizaciones'];
$email_administrativo=$variable_array['email_administrativo'];
$email_medico_auditor=$variable_array['email_medico_auditor'];
$estado=$variable_array['estado'];

/////

$nit=$variable_array['nit'];
$objeto_contrato=$variable_array['objeto_contrato'];
$monto_contrato=$variable_array['monto_contrato'];
$vencimiento_contrato=$variable_array['vencimiento_contrato'];
$inicio_contrato=$variable_array['inicio_contrato'];
$contacto_general=$variable_array['contacto_general'];
$contacto_medico=$variable_array['contacto_medico'];
$contacto_administrativo=$variable_array['contacto_administrativo'];
$id_empresa = $_SESSION['id_empresa'];
$control = md5($variable_array['control']);
if($codigo==''){$error = "Se debe especificar un 'Código de habilitación' ";}
elseif($alias==''){$error = "Se debe especificar 'Nombre o referencia del contrato'>";}
elseif($razon_social==''){$error = "Se debe especificar una ''Razón social o nombre'</b>";}
elseif($numero_contrato==''){$error = "Se debe especificar una 'Número de contrato'";}
else{$error = '0';}
if($error !='0'){ $alerta = "$error";
$respuesta->addAlert("$alerta");
return $respuesta;								
								}

if ($id_cliente =='nuevo'){


$consulta="

INSERT INTO `clientes` (

`id_empresa` ,
`id` ,
`codigo` ,
`razon_social` ,
`alias` ,
`nit` ,
`numero_contrato` ,
`objeto_contrato` ,
`inicio_contrato` ,
`vencimiento_contrato` ,
`monto_contrato` ,
`contacto_medico` ,
`contacto_administrativo` ,
`contacto_general` ,
`telefono_fijo` ,
`telefono_celular` ,
`telefono_auditor` ,
`direccion` ,
`departamento` ,
`ciudad` ,
`barrio` ,
`email_autorizaciones` ,
`email_administrativo` ,
`email_medico_auditor` ,
`control` ,
`estado`
)
VALUES (
 
'$id_empresa', 
'$id', 
'$codigo', 
'$razon_social', 
'$alias', 
'$nit', 
'$numero_contrato', 
'$objeto_contrato', 
'$inicio_contrato', 
'$vencimiento_contrato', 
'$monto_contrato', 
'$contacto_medico', 
'$contacto_administrativo', 
'$contacto_general', 
'$telefono_fijo', 
'$telefono_celular', 
'$telefono_auditor', 
'$direccion', 
'$departamento', 
'$ciudad', 
'$barrio', 
'$email_autorizaciones', 
'$email_administrativo', 
'$email_medico_auditor', 
'$control', 
'$estado'
)";

$sql = mysql_query($consulta,$link);

													}else{
$actualizar ="UPDATE `clientes` SET 
`id_empresa` = '$id_empresa',
`id` = '$id',
`codigo` = '$codigo',
`razon_social` = '$razon_social',
`alias` = '$alias',
`nit` = '$nit',
`numero_contrato` = '$numero_contrato',
`objeto_contrato` = '$objeto_contrato',
`inicio_contrato` = '$inicio_contrato',
`vencimiento_contrato` = '$vencimiento_contrato',
`monto_contrato` = '$monto_contrato',
`contacto_medico` = '$contacto_medico',
`contacto_administrativo` = '$contacto_administrativo',
`contacto_general` = '$contacto_general',
`telefono_fijo` = '$telefono_fijo',
`telefono_celular` = '$telefono_celular',
`telefono_auditor` = '$telefono_auditor',
`direccion` = '$direccion',
`departamento` = '$departamento',
`ciudad` = '$ciudad',
`barrio` = '$barrio',
`email_autorizaciones` = '$email_autorizaciones',
`email_administrativo` = '$email_administrativo',
`email_medico_auditor` = '$email_medico_auditor',
`estado` = '$estado' WHERE `clientes`.`id_cliente` ='$id_cliente' LIMIT 1 ";													
$sql = mysql_query($actualizar,$link);
															}
 									}

if ($grupo=='3'){
$id_especialista=$variable_array['id_especialista'];
$id_usuario=$variable_array['id_usuario'];
$registro_medico=$variable_array['registro_medico'];
$especialidad=$variable_array['especialidad'];
$universidad_especializacion=$variable_array['universidad_especializacion']; 
$cargo=$variable_array['cargo'];  
$universidad_pregrado=$variable_array['universidad_pregrado'];
$objeto_contrato=$variable_array['objeto_contrato'];
$slogan=$variable_array['slogan'];
$color=$variable_array['color'];
$fecha_vinculacion=$variable_array['fecha_vinculacion'];
$fecha_vencimiento=$variable_array['fecha_vencimiento'];
$activo=$variable_array['activo'];
$sql=mysql_query("SELECT * FROM especialistas WHERE id = $id_usuario ",$link);
if (mysql_num_rows($sql)==0){
$insertar=mysql_query("INSERT INTO `especialistas` (  `id` ) VALUES ( '$id_usuario')",$link); 
$nuevo_select .= "<h1>$id_especialista se creó un perfil nuevo </h1>";
														}
mysql_query("UPDATE `especialistas` SET
`registro_medico` = '$registro_medico',
`especialidad` = '$especialidad',
`universidad_especializacion` = '$universidad_especializacion',
`objeto_contrato` = '$objeto_contrato',
`cargo` = '$cargo',
`universidad_pregrado` = '$universidad_pregrado',
`slogan` = '$slogan',
`color` = '$color',
`fecha_vinculacion` = '$fecha_vinculacion',
`fecha_vencimiento` = '$fecha_vencimiento',
`activo` = '$activo'

WHERE `id_especialista` ='$id_especialista' LIMIT 1",$link);
}



if($origen=="inicio"){$respuesta->addRedirect("adentro.php");}
else{
							
							if ($inicio_contrato == ''){	$inicio_contrato = '';}
							elseif($inicio_contrato == '0'){$inicio_contrato = '';}
							else {$inicio_contrato = date('Y-m-d',$inicio_contrato);}
							
							if ($vencimiento_contrato == ''){	$vencimiento_contrato = '';}
							elseif($vencimiento_contrato == '0'){$vencimiento_contrato = '';}
							else {$vencimiento_contrato = date('Y-m-d',$vencimiento_contrato);}
$nuevo_select .= "Registro modificado Contrato número : <b>$numero_contrato</b>";

//$nuevo_select.= contratos_select('$capa');
//include ("terceros/listado.php"); 
//$nuevo_select .= clientes_listado("6","Contratos");
//$respuesta->addAssign("terceros_error_$id_cliente","innerHTML",$alerta);
$respuesta->addAssign($capa,"innerHTML",$nuevo_select);
			}
return $respuesta;



} 

/// FIN DE LA FUNCION terceros_modificar

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
