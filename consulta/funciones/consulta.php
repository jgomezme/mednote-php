<?php
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) { 
 // Si no existe 
 header("Location: ../../includes/error.php");
// echo "hola mundo2";
}  
function admitir($id_turno){
    $respuesta = new xajaxResponse('ISO-8859-1');
    $link=Conectarse(); 
    $sql ="UPDATE turnos SET factura_impresa='1' WHERE id_turno='$id_turno'";
    mysql_query($sql,$link);
    $respuesta->addAlert("La atención se marcó com admitida");
    $respuesta->addAssign("admision_$id_turno", "innerHTML", "Admitido");
    return $respuesta;
									}
$xajax->registerFunction("admitir");
function verifica_campo($id_campo,$tabla){
 $link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
$sql ="SELECT id_grupo, contenido
				FROM  $tabla, d9_users 
				WHERE id_consulta_datos = '$id_campo' 
				AND d9_users.id = $tabla.id_especialista
				
				";

$consulta = mysql_query($sql,$link);
if (mysql_num_rows($consulta)!=0){
$id_grupo=mysql_result($consulta,0,"id_grupo");
$contenido=md5(mysql_result($consulta,0,"contenido"));
if($id_grupo !='9'){

$sql_firma="SELECT firma_contenido 
				FROM consulta_revision 
				WHERE id_campo = '$id_campo' 
				AND tabla = '$tabla'
				AND firma_contenido = '$contenido'";
$consulta_firma = mysql_query($sql_firma,$link);
if (mysql_num_rows($consulta_firma)=='0'){$resultado_firma ="0";}else{$resultado_firma ="1";}
						}else {$resultado_firma ='1';}
												}

						
//return $resultado;
return $resultado_firma;
}

 function sugiere($valor,$item_cie) {
    $respuesta = new xajaxResponse('ISO-8859-1');
 if(strlen($valor) >= '3'){
 $link=Conectarse(); 

mysql_query("SET NAMES 'utf8'");
                $sql = "SELECT descripcion, codigo   FROM cie_10 WHERE descripcion LIKE '%%$valor%%' OR codigo LIKE '%%$valor%%' ORDER BY codigo LIMIT 100";
$query =mysql_query($sql,$link);
 //           $query = pg_query($sql);
            if(mysql_num_rows($query)==0)
            {
           
            $respuesta->addAssign("contenedor$item_cie","style.display","none");
            }
            else{
            while( $row = mysql_fetch_array( $query ) ) {
           
   						$p  = stripos($row[descripcion], $valor);
                    $s1 = substr($row[descripcion], 0, $p);
                    $s2 = substr($row[descripcion], $p, strlen($valor));
                    $s3 = substr($row[descripcion], ($p + strlen($valor)));
 
                    $r = $s1."<font color='red'>$s2</font>".$s3;
 
              //      $pinta .= "	<li onclick=\"rc_autocompleter_click('edtAutocompleter', '$row[descripcion]', 'completer_preview');\">$r";
         
 $pinta .= "<li title='Clic para seleccionar codigo: $row[codigo] ' id='$row[codigo]' >
 <label class='aum' id='e$row[codigo]'>[$row[codigo]] </label><label class='aum'></label>$r
 <br> 
 |<a title ='Diagnostico PRINCIPAL' onclick=\"document.getElementById('texto_campo_12').value='$row[codigo] | $row[descripcion]';document.getElementById('12').value='$row[codigo]';document.getElementById('buscar$item_cie').value='$row[descripcion]';document.getElementById('contenedor$item_cie').style.display='none'\"' class='cursor'><font size = '-1'>Dx Principal</font></a>
 |<a title ='PRIMER Diagnostico RELACIONADO' onclick=\"document.getElementById('texto_campo_13').value='$row[codigo] | $row[descripcion]'; document.getElementById('13').value='$row[codigo]';document.getElementById('buscar$item_cie').value='$row[descripcion]';document.getElementById('contenedor$item_cie').style.display='none'\"' class='cursor'><font size = '-1'>1&deg; Dx Rel</font></a>
 |<a title ='SEGUNDO Diagnostico RELACIONADO' onclick=\"document.getElementById('texto_campo_14').value='$row[codigo] | $row[descripcion]';document.getElementById('14').value='$row[codigo]';document.getElementById('buscar$item_cie').value='$row[descripcion]';document.getElementById('contenedor$item_cie').style.display='none'\"' class='cursor'><font size = '-1'>2&deg; Dx Rel</font></a>
 |<a title ='TERCER Diagnostico RELACIONADO' onclick=\"document.getElementById('texto_campo_15').value='$row[codigo] | $row[descripcion]';document.getElementById('15').value='$row[codigo]';document.getElementById('buscar$item_cie').value='$row[descripcion]';document.getElementById('contenedor$item_cie').style.display='none'\"' class='cursor'><font size = '-1'>3&deg; Dx Rel</font></a>|
 |<br><a title ='SOLO EN EL RESUMEN DE CONSULTA' onclick=\"document.getElementById('texto_campo_$item_cie').value='$row[codigo] | $row[descripcion]';document.getElementById('$item_cie').value='$row[codigo]';document.getElementById('buscar$item_cie').value='$row[descripcion]';document.getElementById('contenedor$item_cie').style.display='none'\"' class='cursor'><font size = '-1'>Cambiar campo actual</font></a>|
 </li>";
															}
 $mensaje .= "<li title ='LIMPIAR BUSQUEDA' onclick=\"document.getElementById('buscar$item_cie').value='' ;
    document.getElementById('contenedor$item_cie').style.display='none'\"' class='cursor' id='li$row[campo]' ><b>Limpiar Busqueda [<font color='red'>X</font>]</b> 


 </li>";
            $respuesta->addAssign("contenedor$item_cie", "innerHTML", "<ul  id='lista$item_cie'> $mensaje $pinta</ul>");
            $respuesta->addAssign("contenedor$item_cie","style.display","block");
            }
          //  $respuesta->addScript("contenedor.scrollTop=0");
          }else{
          //$pinta.= "ESTO $item //";
            //       $respuesta->addAssign("contenedor", "innerHTML", "<ul  id='lista'>$pinta</ul>");
           // $respuesta->addAssign("contenedor","style.display","block");
          }
            return $respuesta;

    }
    $xajax->registerFunction("sugiere");
    
function cie_10(){
//creo el xajaxResponse para generar una salida
//$respuesta = new xajaxResponse('utf-8');

//include_once("librerias/conex.php"); 
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");

$sql="SELECT * FROM cie_10 ";
$sql_resultado =mysql_query($sql,$link);

$resultado="<select>";
if (mysql_num_rows($sql_resultado)!='0'){
while( $row = mysql_fetch_array( $sql_resultado ) ) {
$resultado .= "<option value='$row[codigo]'>$row[codigo] $row[descripcion]</option>";
															}
										}
$resultado .="</select>";
//$respuesta->addAssign($capa,"innerHTML",$esultado);
//return $respuesta;
return $resultado;
} 
///$xajax->registerFunction("dummy");

function tipo_consulta_listado($tipo,$id_usuario,$estado){

$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");

$sql=mysql_query("SELECT * FROM consulta_tipo, consulta_tipo_campos 
WHERE activo LIKE '$estado' 
AND consulta_tipo_campos.id_empresa = '$_SESSION[id_empresa]' 
AND consulta_tipo_campos.tipo_consulta = consulta_tipo.id_consulta_tipo
GROUP BY consulta_tipo.id_consulta_tipo
ORDER BY orden ",$link);
global $id_turno;



if (mysql_num_rows($sql)!='0'){
while( $row = mysql_fetch_array( $sql ) ) {

									$perfil=$row['id_consulta_tipo'];
									$sql_validar_perfil ="SELECT contenido FROM consulta_datos WHERE (perfil = '$perfil' AND id_turno = '$id_turno')";
									$validar_perfil = mysql_query($sql_validar_perfil,$link);
									if (mysql_num_rows($validar_perfil) !='0'){
									
									$resultado .= "<input type='button' id='boton_$row[id_consulta_tipo]' onClick=\"xajax_campos_consulta_dinamico('todas','$row[consulta_tipo_nombre]','$id_usuario','$row[id_consulta_tipo]'); \" value='$row[consulta_tipo_nombre]' > ";
																							}
																			else {
$medirTiempo ="";
//--------------------------------------- boton de consulta general-----------------------------------------------------------------------------------
if($row['id_consulta_tipo']==4){
	//$medirTiempo ="alert(''); ";
}
$resultado .= "<input type='button' id='boton_$row[id_consulta_tipo]' onClick=\"$medirTiempo xajax_campos_consulta_dinamico('todas','$row[consulta_tipo_nombre]','$id_usuario','$row[id_consulta_tipo]');\" value='$row[consulta_tipo_nombre]' > ";
																					}
															}
										}

return $resultado;
} 


function grabando_consulta($formulario_consulta,$capa){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('utf-8');
$perfil = $formulario_consulta["perfil"];
$id_especialista = $_SESSION[id_usuario];
$id_usuario = $formulario_consulta["id_usuario"];
$control = $formulario_consulta["control"];
$id_turno = $formulario_consulta["id_turno"];
$tipo = $formulario_consulta["tipo"];
//$evolucion = $formulario_consulta["evolucion"];
if($perfil == '3'){$evolucion='1';}else{$evolucion='0';}
//$evolucion='0';
//// campos para glasgow
$glasgow = ($formulario_consulta[17]+$formulario_consulta[18]+$formulario_consulta[19]);
$formulario_consulta["7"]=$glasgow;
/// fin glasglow
$timestamp_atencion = time(); 


foreach ($formulario_consulta as $id => $valor_campo)
	{

//$resultado.="$id = $valor_campo <br>";
	}
	

$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");

  $campos_consulta_obligatorio="
  		SELECT id_campo, obligatorio
		FROM `consulta_tipo_campos`
		WHERE (id_empresa = '$_SESSION[id_empresa]' )
		AND tipo_consulta ='$perfil'
		AND obligatorio='1'
		";
	$campos_obligados=	mysql_query($campos_consulta_obligatorio,$link);


//if (mysql_num_rows($campos_obligados)!='0'){

while( $row = mysql_fetch_array( $campos_obligados ) ) {
$campo_valor=$formulario_consulta[$row['id_campo']];

if($row[obligatorio]=='1'){
if($campo_valor == '' && $row[obligatorio]=='1'){
$error = "Revise campos obligatorios [*] (".$row['id_campo'].")"; 

																}
if($error !=''){$respuesta->addAlert($error); return $respuesta;}																
									}
											}/// fin de registros obligatorios
											
$campos_obligatorios = array( //campos obligatorios que no estan parametrizados en la consulta

"id_especialista",
"id_usuario"
);
///if ($campos_obligatorio =="")
foreach ($campos_obligatorios as $campo => $contenido)
	{
	if ($$contenido == ""){
		$nombre_campo = ereg_replace("_"," ","$contenido");
		$obligatorio = "<img src='images/atencion.gif' alt='[!]' title='El campo $nombre_campo no puede estar vacio'> ";
		$respuesta->addAlert('El campo ['.$nombre_campo.'] no puede estar vacio');
		$respuesta->addAssign("cabecera","innerHTML",$obligatorio);
return $respuesta;
								}else {$obligatorio = "";
								$respuesta->addAssign("cabecera","innerHTML",$obligatorio);
										}
///	$resultado_atencion_inicial .= " $obligatorio" ;
	}				

 $campos_consulta="
  		SELECT id_campo, obligatorio
		FROM `consulta_tipo_campos`
		WHERE (id_empresa = '$_SESSION[id_empresa]' )
		AND tipo_consulta ='$perfil'
		
		";
	$campos=	mysql_query($campos_consulta,$link);



while( $row = mysql_fetch_array( $campos ) ) {
$campo_valor=$formulario_consulta[$row['id_campo']];
									
	if ($campo_valor !=''){ //// si el registro no sta vacio
	///consultar si ya fue grabado
	$consultar_campo="SELECT * 
												FROM consulta_datos 
												WHERE id_campo = '$row[id_campo]'
												AND id_turno='$id_turno' 
												AND bloqueo != '1'
												LIMIT 1";
					$sql_campo=			mysql_query($consultar_campo,$link);
					
					
if (mysql_num_rows($sql_campo)=='0'){
if($evolucion =='1'){$bloqueado ='1';}else{$bloqueado='1';}
//$resultado .= "insert $campo_valor /";
$insertar_consulta = " INSERT INTO `consulta_datos` (  `id_campo` , `id_especialista` , `id_usuario` , `contenido` , `timestamp` , `id_turno`, `control`, `bloqueo`, `perfil` )
								VALUES ('$row[id_campo]','$id_especialista','$id_usuario','$campo_valor','$timestamp_atencion','$id_turno','$control','$bloqueado','$perfil')";

												}else{
$id_consulta_datos=mysql_result($sql_campo,0,"id_consulta_datos");

$insertar_consulta = " UPDATE `consulta_datos` SET 
`id_especialista` = '$id_especialista',
`contenido` = '$campo_valor',
`timestamp` = '$timestamp_atencion' WHERE `consulta_datos`.`id_consulta_datos` = $id_consulta_datos LIMIT 1";

if($_SESSION['grupo']=='9'){ /// si el grupo es 9 se inserta la revision
 $firma_contenido = $id_usuario.$campo_valor.$id_turno;
 $firma_contenido = md5($firma_contenido);
 $consulta_revision ="INSERT INTO `consulta_revision` (

`id_funcionario` ,
`id_campo` ,
`tabla` ,
`firma_contenido`
)
VALUES (
 '$id_especialista',
 '$id_consulta_datos', 'consulta_datos', '$firma_contenido'
)";
$resultado_consulta_revision = mysql_query($consulta_revision,$link);

 									} /// fin del grupo 9											
														}										

if ($error ==''){
$sql_consulta=@mysql_query($insertar_consulta,$link);
if($sql_consulta){$resultado.="";}ELSE{$resultado.= "Posible Erro al escribir la informacion por favor verique!";}
}
									}								
							
													
																}/// fin de array de los campos por perfil


//															}/// fin de obligatorio
///$resultado .= $insertar_consulta;															
							$capa = "consulta_dinamico";
$respuesta->addAssign($capa,"innerHTML",$resultado);
return $respuesta;
} 
$xajax->registerFunction("grabando_consulta");


function tipo_campo_consulta($id_campo,$capa,$accion) {
$respuesta = new xajaxResponse('utf-8');

$link = conectarse();
$consulta = "SELECT *
		FROM `consulta_datos` ,`consulta_campos` , `tipo_campo` 
		WHERE consulta_datos.id_consulta_datos ='$id_campo'
		AND consulta_datos.id_campo = consulta_campos.id_consulta_campo
		AND consulta_campos.campo_tipo = tipo_campo.id_tipo_campo
		";
mysql_query("SET NAMES 'utf8'");
$campos=mysql_query($consulta,$link);
if (mysql_num_rows($campos)!='0'){
		while( $row = mysql_fetch_array( $campos ) ) {
		$contenido = $row[contenido];
		
if($accion==''){
	$campos_formulario ="".revisar_campo_consulta($row[id_consulta_datos],'','revisar_campo',$autorizado)."
								<a onclick=\"xajax_tipo_campo_consulta('$row[id_consulta_datos]','capa_$row[id_consulta_datos]','form')\">
															 ".$row['contenido']." *</a>";
	$respuesta->addAssign($capa,"innerHTML",$campos_formulario);
	return $respuesta;
					}		
if ($row['id_campo']>='12' AND $row['id_campo']<='15')	{
///$campos_formulario .=  suggestivo('12','cie10','codigo','descripcion','1','Buscar CIE 10');	
$item_cie = $row[id_consulta_datos];
$descripcion_cie = usuario_datos_consultar($contenido,cie10,descripcion);
$campos_formulario .=  "<font color='green' size='-2' class='cursor' onclick=\"xajax_editar_consulta(xajax.getFormValues('consulta')); xajax_tipo_campo_consulta('$row[id_consulta_datos]','capa_$row[id_consulta_datos]',''); \" title='Grabar los cambios'>[GRABAR]</font>
								<input  readonly title='Use el buscador para cambiar el campo'  name='$id_campo' id='$id_campo' value='$contenido' type='text' size='".$row['tipo_campo_accion']."'   >
								<input readonly  title='Use el buscador para cambiar el campo'  name='texto_campo_$id_campo' id='texto_campo_$id_campo' value='$descripcion_cie' type='text' size='60'   >
			";

$campos_formulario .="<br>Buscar un Cie 10 <input title= 'SUGERENCIA: Digite el nombre del organo afectado' type='text' id='buscar$item_cie' name='buscar$item_cie' value='Buscar un Codigo CIE 10'
 								onkeyup=\"if(revisa('buscar$item_cie')=='si'){numeros(event,$item_cie,''); }
                else{limpia($item_cie)}\" class='nselect' onClick=\"document.getElementById('buscar$item_cie').value='' \"/>
                <br/>
                <style type='text/css'>
     <!--
#contenedor$item_cie {
    position:relative;
text-align:justify;
height:200px;
background-color: white;
z-index:1002;
overflow: auto;
overflow-x:hidden;
font-size: 8pt;
font-family: Arial, Helvetica, sans-serif;
width:300px;

       -->
</style>
                <div id='contenedor$item_cie' onmouseover='sobre()' style='height:200px;  display:inline' ></div>
                </div>";

																}
elseif ($row['tipo_campo_accion']=='textarea'){

			$campos_formulario .= "
			<font color='green' size='-2' class='cursor' onclick=\"xajax_editar_consulta(xajax.getFormValues('consulta')); xajax_tipo_campo_consulta('$row[id_consulta_datos]','capa_$row[id_consulta_datos]',''); \" title='Grabar los cambios'>[GRABAR]</font>
			<br><textarea  name='$id_campo' id='$id_campo' rows='2' cols='40' title='$row[campo_nombre]: $row[campo_descripcion]'>$contenido</textarea>";
														}
elseif ($row['tipo_campo_accion']=='text'){
$campos_formulario .=  "<font color='green' size='-2' class='cursor' onclick=\"xajax_editar_consulta(xajax.getFormValues('consulta')); xajax_tipo_campo_consulta('$row[id_consulta_datos]','capa_$row[id_consulta_datos]',''); \" title='Grabar los cambios'>[GRABAR]</font>
								<input   title='$row[campo_nombre]: $row[campo_descripcion]' name='$id_campo' id='$id_campo' value='$contenido' type='text' size='72'>
			";											
														}	
																											
																	  
elseif (is_numeric($row[tipo_campo_accion]))	{
$campos_formulario .=  "<font color='green' size='-2' class='cursor' onclick=\"xajax_editar_consulta(xajax.getFormValues('consulta')); xajax_tipo_campo_consulta('$row[id_consulta_datos]','capa_$row[id_consulta_datos]',''); \" title='Grabar los cambios'>[GRABAR]</font>
								<input  title='$row[campo_nombre]: $row[campo_descripcion]'  name='$id_campo' id='$id_campo' value='$contenido' type='text' size='".$row['tipo_campo_accion']."'   >
			";
																}

else {$campos_formulario .="NO HAY DATOS";}
																	} //// fin del while
																	}else {$campos_formulario .="NO HAY DATOS del campo $id_campo /  $row[id_consulta_campo] ";}
																
$respuesta->addAssign($capa,"innerHTML",$campos_formulario);
return $respuesta;
																}//// fin de la funcion
$xajax->registerFunction("tipo_campo_consulta"); /// registro de la funcion

function revisar_campo_consulta($id,$capa,$tipo,$autorizado){
$respuesta = new xajaxResponse('utf-8');
if($_SESSION[grupo]=='9'){$autorizado=$_SESSION[id_usuario];}
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
if($tipo == 'revisar_campo'){$tabla= 'consulta_revision'; $clave ='id_campo'; $w = " AND tabla='consulta_datos' LIMIT 1"; $campo='*';  $check='check';
										$consulta_especialista ="SELECT consulta_datos.id_especialista, d9_users.id_grupo FROM	consulta_datos, d9_users WHERE consulta_datos.id_consulta_datos = '$id' AND consulta_datos.id_especialista = d9_users.id";

											}
if($tipo == 'revisar_receta'){$tabla= 'consulta_revision'; $clave ='id_campo'; $w = " AND tabla='recetas' LIMIT 1"; $campo='*';   $check='check_receta';
										$consulta_especialista ="SELECT recetas.id_especialista, d9_users.id_grupo FROM	recetas, d9_users WHERE recetas.id_receta = '$id' AND recetas.id_especialista = d9_users.id";
										}
if($tipo == 'revisar_orden'){$tabla= 'consulta_revision'; $clave ='id_campo'; $w = " AND tabla='ordenes' LIMIT 1"; $campo='*';   $check='check_orden';
										$consulta_especialista ="SELECT ordenes.id_especialista, d9_users.id_grupo FROM	ordenes, d9_users WHERE ordenes.id_orden = '$id' AND ordenes.id_especialista = d9_users.id";
										}										
////para chekear campos de la consulta
if($tipo == 'check'){
$xajax='1';
$capa = "$capa_$id";
 if($_SESSION['grupo']=='9' OR $autorizado !=''){
 $consulta_contenido ="SELECT consulta_datos.contenido FROM	consulta_datos WHERE consulta_datos.id_consulta_datos = '$id' LIMIT 1";
$contenido_sql = mysql_query($consulta_contenido,$link);
$contenido=mysql_result($contenido_sql,0,"contenido");
 $firma_contenido = $id_usuario.$contenido.$id_turno;
 $firma_contenido = md5($firma_contenido);
 if($autorizado !=''){$id_funcionario=$autorizado;}else{$id_funcionario= $_SESSION['id_usuario'];}
 //$resultado.="$autorizado )))";
 $consulta ="INSERT INTO `consulta_revision` (

`id_funcionario` ,
`id_campo` ,
`tabla` ,
`firma_contenido`
)
VALUES (
 '$id_funcionario',
 '$id', 'consulta_datos', '$firma_contenido'
)";
$efectuar = mysql_query($consulta,$link);

$resultado = "<img src='images/check.gif' alt='[Ok]' title='Revisada'>";

$respuesta->addAssign($capa,"innerHTML",$resultado);
return $respuesta;
 									}
							}
///para chequear recetas
if($tipo == 'check_receta'){
$xajax='1';
$capa = "receta_$id";
 if($_SESSION['grupo']=='9' OR $autorizado !=''){
  if($autorizado !=''){$id_funcionario=$autorizado;}else{$id_funcionario= $_SESSION['id_usuario'];}
 $consulta_contenido ="SELECT * FROM recetas WHERE id_receta = '$id' LIMIT 1";
$contenido_sql = mysql_query($consulta_contenido,$link);
$contenido=mysql_result($contenido_sql,0,"id_medicamento");
$contenido .= "/".mysql_result($contenido_sql,0,"cantidad");
$contenido .="/".mysql_result($contenido_sql,0,"cantidad_letras");
$contenido .="/".mysql_result($contenido_sql,0,"posologia");
 $firma_contenido = md5($contenido);
 $consulta ="INSERT INTO `consulta_revision` (

`id_funcionario` ,
`id_campo` ,
`tabla` ,
`firma_contenido`
)
VALUES (
 '$id_funcionario',
 '$id', 'recetas', '$firma_contenido'
)";
mysql_query($consulta,$link);
$resultado = "<img src='images/check.gif' alt='[Ok]' title='Revisada'>";
$respuesta->addAssign($capa,"innerHTML",$resultado);
return $respuesta;
 									}
							}

///para chequear ORDENES
if($tipo == 'check_orden'){
$xajax='1';
$capa = "orden_$id";
 if($_SESSION['grupo']=='9' OR $autorizado !=''){
  if($autorizado !=''){$id_funcionario=$autorizado;}else{$id_funcionario= $_SESSION['id_usuario'];}
 $consulta_contenido ="SELECT * FROM ordenes WHERE id_orden = '$id' LIMIT 1";
$contenido_sql = mysql_query($consulta_contenido,$link);
$contenido=mysql_result($contenido_sql,0,"id_tipo_orden");
$contenido .= "/".mysql_result($contenido_sql,0,"observaciones");
$contenido .="/".mysql_result($contenido_sql,0,"id_turno");
$contenido .="/".mysql_result($contenido_sql,0,"id_usuario");
 $firma_contenido = md5($contenido);
 $consulta ="INSERT INTO `consulta_revision` (

`id_funcionario` ,
`id_campo` ,
`tabla` ,
`firma_contenido`
)
VALUES (
 '$id_funcionario',
 '$id', 'ordenes', '$firma_contenido'
)";
mysql_query($consulta,$link);
$resultado = "<img src='images/check.gif' alt='[Ok]' title='Revisada'>";
$respuesta->addAssign($capa,"innerHTML",$resultado);
return $respuesta;
 									}
							}
							
/////							
$consulta = "SELECT $campo FROM $tabla WHERE $clave = '$id' $w ";
$grupo_especialista = mysql_query($consulta_especialista,$link);
$grupo_especialista=mysql_result($grupo_especialista,0,"id_grupo");
if($grupo_especialista != '9'){
$sql=mysql_query($consulta,$link);
if (mysql_num_rows($sql)!='0'){$resultado="";}else{
											if($_SESSION[grupo]=='9' OR $autorizado != ''){$resultado ="<div style='display:inline' id='$capa_$id'>
																								 <img class='cursor' onclick=\" xajax_revisar_campo_consulta('$id','$capa','$check',$autorizado); \"  src='images/pendiente.gif' title='El registro NO ha sido certificado por un médico hospitalario' alt='[!]'>
																								 </div>";}
											else{$resultado="<font color='red' size='-2' title='El campo debe ser revisado por un tutor o médico hospitalario'>[Sin revisar]</font>";}
											}
										}

if($xajax=='1'){

					}else{return $resultado;}

																 }
$xajax->registerFunction("revisar_campo_consulta");

function atencion_inicial_grabar($formulario_atencion_inicial,$capa,$accion){

//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('utf-8');
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
$control_edicion= $formulario_atencion_inicial["control_edicion"];
$comprobar_bloqueo ="
	SELECT consulta_efectuada
		FROM turnos
		WHERE  id_turno = '$_SESSION[en_consulta]'
		AND consulta_efectuada != '1'
		";
$consulta_bloqueo=mysql_query($comprobar_bloqueo,$link);
if (mysql_num_rows($consulta_bloqueo)=='0'){		
$respuesta->addAlert("La consulta está bloqueada,\nNO SE PUEDE REALIZAR EL EGRESO DE SERVICIO DE URGENCIAS\n  ");
				
return $respuesta;
}
$buscando_cie ="
	SELECT id_consulta_datos
		FROM consulta_datos
		WHERE  id_campo = '12'
		AND control = '$control_edicion'
		AND perfil='4'
		";
		  $campos_cie=mysql_query($buscando_cie,$link);
if (mysql_num_rows($campos_cie)!='0'){
$id_consulta_campo=mysql_result($campos_cie,0,"id_consulta_datos");
$firma = verifica_campo($id_consulta_campo,'consulta_datos');
$acepta = $firma;
													}else{$acepta='0';}

if ($acepta!='1'){
		$respuesta->addAlert("No se ha definido o validado un diagnostico,\nNO SE PUEDE REALIZAR EL EGRESO DE SERVICIO DE URGENCIAS\n  ");
						
return $respuesta;
													}else{
	///$respuesta->addAlert("xxxxNo se ha definido un diagnostico,\nNO SE PUEDE REALIZAR EL EGRESO DE SERVICIO DE URGENCIAS\n $firma $acepta");
													}
if($accion !='formulario'){
if($formulario_atencion_inicial =='posponer'){
	$resultado=''; 
	$respuesta->addAssign($capa,"innerHTML",$resultado);
	return $respuesta;}else{}
	
$campos_obligatorios_1 = array( 

"origen_de_la_atencion",
"accidente_de_transito",
"remitido",
"destino"
);
if($formulario_atencion_inicial["remitido"] =='1'){$remitidos_obligatorios = array("remitido_nombre_entidad","remitido_codigo_entidad","cod_departamento","cod_ciudad");
$campos_obligatorios = array_merge($campos_obligatorios_1,$remitidos_obligatorios);  }
else{$campos_obligatorios=$campos_obligatorios_1;}

$id_atencion_inicial= $formulario_atencion_inicial["id_atencion_inicial"];
$id_funcionario= $_SESSION['id_usuario'];
$id_especialista= $formulario_atencion_inicial["id_especialista"];
$id_usuario= $formulario_atencion_inicial["id_usuario"];
$id_cliente= $formulario_atencion_inicial["id_cliente"];
$estado= $formulario_atencion_inicial["estado"];
$origen_de_la_atencion= $formulario_atencion_inicial["origen_de_la_atencion"];
$accidente_de_transito= $formulario_atencion_inicial["accidente_de_transito"];
$clasificacion= $formulario_atencion_inicial["clasificacion"];
$remitido= $formulario_atencion_inicial["remitido"];
$remitido_codigo_entidad= $formulario_atencion_inicial["remitido_codigo_entidad"];
$remitido_nombre_entidad= $formulario_atencion_inicial["remitido_nombre_entidad"];
$remitido_pais= $formulario_atencion_inicial["cod_pais"];
$cod_departamento= $formulario_atencion_inicial["cod_departamento"];
$cod_ciudad= $formulario_atencion_inicial["cod_ciudad"];
$motivo_consulta= $formulario_atencion_inicial["motivo_consulta"];
$diagnostico_principal= $formulario_atencion_inicial["diagnostico_principal"];
$diagnostico_relacionado_1= $formulario_atencion_inicial["diagnostico_relacionado_1"];
$diagnostico_relacionado_2= $formulario_atencion_inicial["diagnostico_relacionado_2"];
$diagnostico_relacionado_3= $formulario_atencion_inicial["diagnostico_relacionado_3"];
$diagnostico_descripcion= $formulario_atencion_inicial["diagnostico_descripcion"];
$destino= $formulario_atencion_inicial["destino"];
$destino_observacion= $formulario_atencion_inicial["destino_observacion"];
$control_edicion= $formulario_atencion_inicial["control_edicion"];
$timestamp_atencion= $formulario_atencion_inicial["timestamp_atencion"];
$id_empresa= $_SESSION['id_empresa'];
$id_turno=$formulario_atencion_inicial["id_turno"];
$accion=$formulario_atencion_inicial["accion"];
$timestamp = time();

  $campos=mysql_query("
  		SELECT id_campo
		FROM `consulta_tipo_campos`
		WHERE (id_empresa = '$_SESSION[id_empresa]' )
		AND tipo_consulta ='2'
		",$link);


if (mysql_num_rows($campos)!='0'){

while( $row = mysql_fetch_array( $campos ) ) {

$campo_valor=$formulario_atencion_inicial[$row[id_campo]];
if ($campo_valor !=''){ //// si el registro no sta vacio
$campos_consulta_listado .= "('".$row['id_campo']."','$id_funcionario','$id_usuario','$campo_valor','$timestamp','$id_turno','$control_edicion'),";
							}
															}
															///QUITAR LA ULTIMA COMA (ULTIMO CARACTER DE LA CADENA)
													$campos_consulta_listado =		 substr ($campos_consulta_listado, 0, -1);
													$insertar_consulta = " INSERT INTO `consulta_datos` (  `id_campo` , `id_especialista` , `id_usuario` , `contenido` , `timestamp` , `id_turno`, `control` )
													VALUES $campos_consulta_listado ";
													$sql_consulta=mysql_query($insertar_consulta,$link);
										}

//$campos_obligatorios = array();
///if ($campos_obligatorio =="")
foreach ($campos_obligatorios as $campo => $contenido)
	{
	if ($$contenido == ""){
		$obligatorio = "<img src='images/atencion.gif' alt='[!]' title='El campo ".ereg_replace("_"," ","$contenido")." no puede estar vacio'> ";
		$respuesta->addAlert("[ ".ereg_replace("_"," ","$contenido")." ] no puede estar vacio");
return $respuesta;
								}else {$obligatorio = "<font color='green' size='+2'>*</font>";
								$respuesta->addAssign("capa_$contenido","innerHTML",$obligatorio);
										}
///	$resultado_atencion_inicial .= " $obligatorio" ;
	}
	///campos con contenido
$qry=mysql_query("SELECT * FROM atencion_inicial WHERE control='$control_edicion' LIMIT 1");

foreach ($formulario_atencion_inicial as $campo => $contenido)
	{
	if($contenido !=''){
	
	

$campos = mysql_num_fields($qry);
$i=0;
while($i<$campos){
if($campo==mysql_field_name ($qry, $i)){$campos_consulta .= "`$campo` = '$contenido',"; }
else{}
$i++;
	}
 

//$consulta .= "$campo : $contenido <br>";
							}
	}
	$campos_consulta =		 substr ($campos_consulta, 0, -1);
$consulta .="
UPDATE `atencion_inicial` SET $campos_consulta  WHERE `control` = '$control_edicion' LIMIT 1 ;
										";
$hoy=date('Y-m-d');
$hora=date('H:i:s');
$hoy=date('Y-m-d');
list( $ano, $mes, $dia ) = split( '[-]', $hoy );
$hoy_timestamp=mktime(0,0,0, $mes, $dia, $ano);
$timestamp=mktime(0,0,0, $mes, $dia, $ano);

$sql=mysql_query($consulta,$link);

if($sql){$bloquear=" UPDATE `turnos` SET estado = '5' WHERE `control` = '$control_edicion' LIMIT 1 "; 
			$sql_bloquear=mysql_query($bloquear,$link); 
			$respuesta->addScript("document.location.href='adentro.php?page=sala'");
return $respuesta;
			
		//	 header("Location: adentro.php?page=sala");
			
}
//$turno=mysql_query($crear_turno,$link);


//if (isset($sql)){$resultado .="La información se guardó con éxito!<br> ";
//			}else{$resultado .="PROBLEMAS CON LA CONSULTA <br>$consulta  $insertar_consulta ";}
			///debug
			//$resultado .= $insertar_consulta;




																									}/// fin de si no es formulario
														else {			
														
					$resultado .= "<div align='center' ><div style='border: 5px solid rgb(34, 85, 34); width:80% ; '>";
			$resultado .= " 
														<input type='hidden' value='atencion_inicial' id='formulario' name='formulario'>
														<input type='hidden' value='$id_funcionario' id='id_funcionario' name='id_funcionario'>
														<input type='hidden' value='$id_usuario' name='id_usuario'>
														<input type='hidden' value='$id_turno' name='id_turno'>
														<input type='hidden' value='$control_edicion' name='control_edicion'>
														
														 
																			  <table cellpadding='5' cellspacing='5' border='0' align='center' valign='top'>
																			  <tr><td colspan='4'><div align='center'><font size='+1'><b>Egreso del servicio de Urgencias</b></font></div></td></tr>
																			 
																			  	<tr  valign='top'>
																			  		<td>
																			  		<div id='capa_origen_de_la_atencion' style='display: inline;'></div>
																			  		<b>Orígen de la atención:</b>
														 [<b title='correspondiente al origen de la afección que motiva la consulta del paciente al servicio de urgencias. Es posible marcar simultáneamente las opciones accidente de trabajo y accidente de tránsito cuando el accidente de tránsito corresponda a un accidente de trabajo.'>
														 <font color='red'>?</font></b>]
																						<br><input name='origen_de_la_atencion' type='radio' value='1' $evento >Enfermedad General
																						<br><input name='origen_de_la_atencion'   type='radio' value='2'  $evento >Accidente de trabajo
																						<br><input name='origen_de_la_atencion'  type='radio' value='3' $evento >Evento Catastrófico
																						<br><input name='origen_de_la_atencion' type='radio'  value='4' $evento >Enfermedad Profesional
																			  		<div id='capa_accidente_de_transito' style='display: inline;'></div>
																					<br>Accidente de tránsito?
																						<center>SI<input name='accidente_de_transito' type='radio'  value='1'  $evento>
																						NO<input name='accidente_de_transito' type='radio'  value='0'  $evento>
																						</center> 
																			  		</td>
																			  		<td><div id='capa_remitido' style='display: inline;'></div><b>Paciente remitido?</b>
												<center> Sí<input name='remitido' value='1'  $evento  type='radio' title='En caso afirmativo, registre el nombre del prestador remitente, así como el código de habilitación, el nombre del departamento y del municipio en el cual se encuentra ubicado dicho prestador con los códigos asignados en la codificación del DIVIPOLA.'> 
												No<input name='remitido' value='2' type='radio'  $evento>
												</center>
																			  		<div id='capa_remitido_nombre_entidad' style='display: inline;'></div>Paciente remitido por: <br>Entidad que remite:
														<br> <input name='remitido_nombre_entidad'  id='remitido_nombre_entidad' type='text' value='$row[remitido_nombre_entidad]' size='40' >
														<br><div id='capa_remitido_codigo_entidad' style='display: inline;'></div>Código de la entidad que remite <input name='remitido_codigo_entidad'  id='remitido_codigo_entidad' type='text' value='$row[remitido_codigo_entidad]' size='10'  >
														
														<br><div id='capa_remitido_pais' style='display: inline;'><font color='red'></font></div>
														<input name='remitido_pais'  id='remitido_pais' type='HIDDEN' value='COL'  >
														";
														if($pais==''){
   $resultado .= departamentos("atencion_inicial","$pais","$departamento","$ciudad","aiu");
   }else{
   $resultado .= mundo("suscriptores","$pais","$departamento","$ciudad","aiu");}
    $resultado .= " 
														<div id='capa_cod_departamento' style='display: inline;'><font color='red'></font></div>
														<!-- Departamento de la entidad: <input name='remitido_departamento'   title='Código del departamento de la entidad que remite según DIVIPOLA' id='remitido_departamento' type='text' value='$row[remitido_departamento]' size='2' maxlength='2' > -->
														<div id='capa_cod_ciudad' style='display: inline;'><font color='red'></font></div>
														<!-- <br>Municipio de la entidad: <input name='remitido_ciudad'  id='remitido_ciudad'   title='Código del municipio de la entidad que remite según DIVIPOLA' type='text' value='$row[remitido_ciudad]' size='3' maxlength='3' > -->
																	  		
																			  		
																				 																							
																					</td>
																					<td>
																					<div align='right' >
<div id='capa_destino' style='display:inline;'></div><b>Destino del paciente:</b>
														
														<li>Domicilio: <input name='destino' value='0' TITLE='Domicilio'  type='radio'>  
														</li><li>Internación:<input name='destino' value='1' TITLE='Internación'  type='radio'> 
														</li><li>Contrarremisión: <input name='destino' value='2' TITLe='Contrarremisión'  type='radio'>
														</li><li>Observación: <input name='destino' value='3' TITLE='Observación'  type='radio'> 
														</li><li>Remisión: <input name='destino' value='4' TITLE='Remisión'  type='radio'>    
														</li><li>Otro: <input name='destino' value='5' TITLE='Otro'  type='radio'>
														</li>
														<br><b>Observaciones sobre el destino:</b><br>
														<textarea name='destino_observacion' rows='3' cols='20'>$row[destino_observacion]</textarea></div>
																			  		
																				 																							
																					</td>
																			  		<td align='right'>
																			  		<!-- <center><b>Diagnóstico:</b></center>
																			  		<textarea name='11' id='11' rows='2' cols='35'></textarea>
																			  		<br>CIE 10 Principal: <input name='12' id='12' value='' size='5' type='5'>
																			  		<br>Primer CIE10 relacionado: <input name='13' id='13' value='' size='5' type='5'>
																			  		<br>Segundo CIE10 relacionado: <input name='14' id='14' value='' size='5' type='5'>
																			  		<br>Tercer CIE10 relacionado: <input name='15' id='15' value='' size='5' type='5'>
	 																				-->

																			  		</td>
																			  	</tr>
																			  	</table>
<center><input type='button' value='Grabar egreso' onClick=\"xajax_atencion_inicial_grabar(xajax.getFormValues('atencion_inicial'),'atencion_inicial_capa','grabar'); \">
<input type='button' value='Posponer egreso' onClick=\"javascript:location.reload(); \"></center> 
<br>
														";												
																}
$respuesta->addAssign($capa,"innerHTML",$resultado);
return $respuesta;
} 

$xajax->registerFunction("atencion_inicial_grabar");
/// fin atencion_inicial_grabar



function atencion_inicial_consulta($id_usuario,$tipo){
//creo el xajaxResponse para generar una salida
//$respuesta = new xajaxResponse('utf-8');
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
$consulta ="SELECT * FROM consulta_datos 
				WHERE consulta_datos.id_usuario = '$id_usuario' 
				AND consulta_datos.id_campo ='1' 
				AND id_turno != '0'
				";
$consultas_todas = mysql_query($consulta,$link);

$consulta_triage="SELECT * FROM atencion_inicial, consulta_datos 
				WHERE atencion_inicial.id_usuario = '$id_usuario' 
				AND consulta_datos.id_campo ='1' 
				AND  atencion_inicial.control = consulta_datos.control 
				GROUP BY  consulta_datos.control
				ORDER BY atencion_inicial.timestamp_atencion  DESC
				";
$consultas_triage = mysql_query($consulta_triage,$link);

//if (mysql_num_rows($consultas_todas)!='0'){
$nuevo_select .= "<h2>Atenciones anteriores</h2><table border='0'>
<tr><td><b>Fecha y hora</b></td><td><b>Triage</b></td><td><div align='center'><b>Motivo</b></div></td><td></td></tr>";
while( $row = mysql_fetch_array( $consultas_triage ) ) {

$nuevo_select .= "<tr>
<td title='AAAA-MM-DD HH:MM'><b>".date("Y-m-d H:i",$row['timestamp_atencion'])."</b></td>
<td><div align='center'>".$row['clasificacion']."</div></td>
<td>".$row['contenido']."</td>
<td><a href=\"javascript:abrir('impresion/imprimir_triage.php?control=$row[control]','PRINT',500,600,100,0,1);\" title='Imprimir el resumen de la consulta'>
<img src='images/print.gif' alt='[I]' border='0'> <font size='-2'>Imprimir resumen</font></a></td>

</tr>";
															}
while( $row = mysql_fetch_array( $consultas_todas ) ) {
$nuevo_select .= "<tr>
<td title='AAAA-MM-DD HH:MM'><b>".date("Y-m-d H:i",$row['timestamp'])."</b></td>
<td><div align='center'></div></td>
<td>".$row['contenido']."</td>
<td><a href=\"javascript:abrir('impresion/imprimir_resumen.php?id_turno=$row[id_turno]','PRINT',500,600,100,0,1);\" title='Imprimir el resumen'>
<img src='images/print.gif' alt='[I]' border='0'> <font size='-2'>Imprimir resumen</font></a></td>

</tr>";
																		}															
$nuevo_select .= "</table>";
//										}

//$respuesta->addAssign("capa_dummy","innerHTML",$nuevo_select);
return $nuevo_select;
} 
//$xajax->registerFunction("atencion_inicial_consulta");

// onChange="xajax_dummy(xajax.getFormValues('nombre_formulario'))"
function triage_grabar($formulario_atencion_inicial){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('utf-8');
//// campos para glasgow
$glasgow = ($formulario_atencion_inicial[17]+$formulario_atencion_inicial[18]+$formulario_atencion_inicial[19]);
$formulario_atencion_inicial["7"]=$glasgow;
/// fin glasglow
$id_atencion_inicial= $formulario_atencion_inicial["id_atencion_inicial"];
$id_funcionario= $_SESSION['id_usuario'];
$id_especialista= $formulario_atencion_inicial["id_especialista"];
$id_usuario= $formulario_atencion_inicial["id_usuario"];
$id_cliente= $formulario_atencion_inicial["id_cliente"];
$estado= $formulario_atencion_inicial["estado"];
$origen_de_la_atencion= $formulario_atencion_inicial["origen_de_la_atencion"];
$accidente_de_transito= $formulario_atencion_inicial["accidente_de_transito"];
$clasificacion= $formulario_atencion_inicial["clasificacion"];
$remitido= $formulario_atencion_inicial["remitido"];
$remitido_codigo_entidad= $formulario_atencion_inicial["remitido_codigo_entidad"];
$remitido_nombre_entidad= $formulario_atencion_inicial["remitido_nombre_entidad"];
//$remitido_pais= $formulario_atencion_inicial["cod_pais"];
//$remitido_departamento= $formulario_atencion_inicial["cod_departamento"];
//$remitido_ciudad= $formulario_atencion_inicial["cod_ciudad"];
$motivo_consulta= $formulario_atencion_inicial["motivo_consulta"];
$diagnostico_principal= $formulario_atencion_inicial["diagnostico_principal"];
$diagnostico_relacionado_1= $formulario_atencion_inicial["diagnostico_relacionado_1"];
$diagnostico_relacionado_2= $formulario_atencion_inicial["diagnostico_relacionado_2"];
$diagnostico_relacionado_3= $formulario_atencion_inicial["diagnostico_relacionado_3"];
$diagnostico_descripcion= $formulario_atencion_inicial["diagnostico_descripcion"];
$destino= $formulario_atencion_inicial["destino"];
$destino_observacion= $formulario_atencion_inicial["destino_observacion"];
$control= $formulario_atencion_inicial["control"];
$timestamp_atencion= $formulario_atencion_inicial["timestamp_atencion"];
$id_sucursal= $formulario_atencion_inicial["id_sucursal"];
$id_empresa= $_SESSION['id_empresa'];
$accion=$formulario_atencion_inicial["accion"];
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
  $campos=mysql_query("
  		SELECT id_campo, obligatorio
		FROM `consulta_tipo_campos`
		WHERE (id_empresa = '$_SESSION[id_empresa]' )
		AND tipo_consulta ='1'
		",$link);


if (mysql_num_rows($campos)!='0'){

while( $row = mysql_fetch_array( $campos ) ) {
$campo_valor=$formulario_atencion_inicial[$row['id_campo']];
if($row[obligatorio]=='1'){
if($campo_valor == '' && $row[obligatorio]=='1'){
$error = "Revise campos obligatorios [*] (".$row['id_campo'].")"; 
if($error !=''){$respuesta->addAlert($error); return $respuesta;}
																}else{$error='';}
									}
$campos_obligatorios = array( //campos obligatorios que no estan parametrizados en la consulta

"id_funcionario",
"id_usuario",
"id_cliente",
"estado",
"clasificacion",
"id_sucursal"
);
///if ($campos_obligatorio =="")
foreach ($campos_obligatorios as $campo => $contenido)
	{
	if ($$contenido == ""){
		$nombre_campo = ereg_replace("_"," ","$contenido");
		$obligatorio = "<img src='images/atencion.gif' alt='[!]' title='El campo $nombre_campo no puede estar vacio'> ";
		$respuesta->addAlert('El campo ['.$nombre_campo.'] no puede estar vacio');
		$respuesta->addAssign("capa_$contenido","innerHTML",$obligatorio);
return $respuesta;
								}else {$obligatorio = "<font color='green' size='+2'>*</font>";
								$respuesta->addAssign("capa_$contenido","innerHTML",$obligatorio);
										}
///	$resultado_atencion_inicial .= " $obligatorio" ;
	}				

if ($campo_valor !=''){ //// si el registro no sta vacio
$campos_consulta_listado .= "('".$row['id_campo']."','$id_funcionario','$id_usuario','$campo_valor','$timestamp_atencion','','$control','1'),";
							}
															}
															///QUITAR LA ULTIMA COMO (ULTIMO CARACTER DE LA CADENA)
													$campos_consulta_listado =		 substr ($campos_consulta_listado, 0, -1);
													$insertar_consulta = " INSERT INTO `consulta_datos` (  `id_campo` , `id_especialista` , `id_usuario` , `contenido` , `timestamp` , `id_turno`, `control`, `perfil` )
													VALUES $campos_consulta_listado ";
													$sql_consulta=mysql_query($insertar_consulta,$link);
										}



$timestamp = time();
$hora=date('H:i:s');
$hoy=date('Y-m-d');
list( $ano, $mes, $dia ) = split( '[-]', $hoy );
$hoy_timestamp=mktime(0,0,0, $mes, $dia, $ano);
$consulta_ultima_atencion ="SELECT timestamp_fecha, consecutivo FROM atencion_inicial WHERE timestamp_fecha = '$hoy_timestamp' 	ORDER BY consecutivo DESC LIMIT  1";
$ultimo= mysql_query($consulta_ultima_atencion,$link);
if (mysql_num_rows($ultimo)!='0'){
$ultimo_consecutivo=mysql_result($ultimo,0,"consecutivo");
$consecutivo= ++$ultimo_consecutivo;
																			}else{$consecutivo='1';}
$pin = rand(1000,9999);

$consulta="
INSERT INTO `atencion_inicial` (
`id_atencion_inicial` ,
`timestamp_fecha` ,
`consecutivo` ,
`pin` ,
`id_funcionario` ,
`id_usuario` ,
`id_cliente` ,
`id_empresa` ,
`estado` ,
`origen_de_la_atencion` ,
`accidente_de_transito` ,
`clasificacion` ,
`remitido` ,
`remitido_codigo_entidad` ,
`remitido_nombre_entidad` ,
`motivo_consulta` ,
`diagnostico_principal` ,
`diagnostico_relacionado_1` ,
`diagnostico_relacionado_2` ,
`diagnostico_relacionado_3` ,
`diagnostico_descripcion` ,
`destino` ,
`destino_observacion` ,
`control` ,
`timestamp_atencion`
)
VALUES (
NULL ,
 '$hoy_timestamp', 
 '$consecutivo', 
 '$pin', 
 '$id_funcionario', 
 '$id_usuario', 
 '$id_cliente', 
 '$id_empresa', 
 '$estado', 
 '$origen_de_la_atencion', 
 '$accidente_de_transito', 
 '$clasificacion', 
 '$remitido', 
 '$remitido_codigo_entidad', 
 '$remitido_nombre_entidad', 
 '$motivo_consulta', 
 '$diagnostico_principal', 
 '$diagnostico_relacionado_1 ', 
 '$diagnostico_relacionado_2', 
 '$diagnostico_relacionado_3', 
 '$diagnostico_descripcion', 
 '$destino', 
 '$destino_observacion', 
 '$control', 
 '$timestamp_atencion'
)
										";


if($clasificacion == '1' || $clasificacion == '2' || $clasificacion =='3') { ///// si el triage es 123
$hoy=date('Y-m-d');
$hora=date('H:i:s');
$hoy=date('Y-m-d');
list( $ano, $mes, $dia ) = split( '[-]', $hoy );
$hoy_timestamp=mktime(0,0,0, $mes, $dia, $ano);
$timestamp=mktime(0,0,0, $mes, $dia, $ano);
$crear_turno = "INSERT INTO  `turnos` 	(
		`fecha`, 
		`timestamp`,
		`timestamp_inicio`,
		`hora_inicio`,  
		`especialista`, 
		`id_usuario`, 
		`observaciones`, 
		`estado`, 
		`id_evento`, 
		`id_procedimiento`, 
		`timestamp_ocupacion`, 
		`id_ocupacion`, 
		`timestamp_autorizacion`, 
		`id_autorizacion`, 
		`control`, 
		`autorizacion`, 
		`recibo`, 
		`id_cliente`, 
		`id_empresa`, 
		`id_sucursal`
		) 
  	VALUES 
  	(
  	'$hoy',
  	'$timestamp',
  	'$timestamp_atencion',
  	'$hora',
  	'$id_especialista',
  	'$id_usuario',
  	'$destino_observacion',
  	'2',
  	'$id_evento',
  	'$id_procedimiento',
  	'$timestamp_atencion',
  	'$id_funcionario',
  	'$timestamp_atencion',
  	'$id_funcionario',
  	'$control',
  	'1',
  	'$control',
  	'$id_cliente',
  	'$id_empresa',
  	'$id_sucursal'
  	)";     

}///// fin si el triage es 123

$sql=mysql_query($consulta,$link);
$turno=mysql_query($crear_turno,$link);

										
if (isset($sql) ){$resultado_atencion_inicial .="La información se guardó con éxito!<br> ";
$resultado_atencion_inicial .= "<a href=\"javascript:abrir('impresion/imprimir_ficha.php?control=$control','PRINT_ficha',500,600,100,0,1);\" title='Imprimir ficha de ingreso'>Imprimir ficha de ingreso</a> ";
			}else{$resultado_atencion_inicial .="PROBLEMAS CON LA CONSULTA <br>$consulta  $insertar_consulta ";}
												
$respuesta->addAssign("resultado_atencion_inicial","innerHTML",$resultado_atencion_inicial);
return $respuesta;
} 

$xajax->registerFunction("triage_grabar");
/// fin atencion_inicial_grabar


///reload_consulta
function reload_consulta($id_turno){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('utf-8');
$respuesta->addRedirect("adentro.php?page=consulta&turno=$id_turno");
//$respuesta->addAssign("capa_dummy","innerHTML",$nuevo_select);
return $respuesta;
} 
// fin de reload_consulta
// plan 
function plan($titulo,$area,$id_usuario){ 

//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
global $id_turno;
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");

  $campos_consulta_obligatorio="
  		SELECT consulta_datos.id_campo, obligatorio
		FROM `consulta_tipo_campos` , consulta_datos
		WHERE (id_empresa = '$_SESSION[id_empresa]' )
		AND consulta_datos.id_campo = consulta_tipo_campos.id_campo
		AND consulta_datos.contenido != ''
		AND consulta_datos.id_turno = '$_SESSION[en_consulta]'
		
		AND obligatorio='1'
		";
	$campos_obligados=	mysql_query($campos_consulta_obligatorio,$link);


if (mysql_num_rows($campos_obligados)!='0'){$error ='';}else{$error ="Se deben llenar los campos obligatorios antes de formular!";}
if($error !=''){$respuesta->addAlert($error); return $respuesta;}																
							

$formato .= "
 		
		<div name='$titulo"."_".$especialista."' id='$titulo"."_".$especialista."' style='border: 1px solid #$color; ' >
		<div  class='cabecera' style='background-color: #EFFBF5'>&nbsp; &nbsp;<b>$titulo</b> </div>
		<hr>
		<div name='ayudas_diagnosticas' id='ayudas_diagnosticas' >
											";
///recetar

$formato .=  "<b>Formular Medicamentos</b><br>";

//global $id_turno  ,$id_especialista;
$control =  microtime();
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");

include("farmacia/listado_medicamentos.php");

$formato .=   listado_medicamentos($id_medicamento,$pos,$id_usuario);

$formato .= " 
<input type='hidden' name='control' id='control' value='$control'>


			";	
			
$formato .= suggestivo('33333','cups','codigo','descripcion','0','Emitir Ordenes y Procedimientos');		
// include_once("plan/ordenes/tipo_orden.php");
$formato.= "<input type='button' value='Emitir esta orden' onClick=\"xajax_revisar_orden(document.getElementById('33333').value);\"> 
<br>
	<div  id='confirmar_orden'></div>
	<div name='estado_orden' id='estado_orden' ></div>

<br>
";
//$i = 0;
// while ($i <= 8):
// if($area == $i){$respuesta->addAssign("boton_$area","style.background","#$_SESSION[mi_bgcolor]");}
// 							else{$respuesta->addAssign("boton_$i","style.background","");}
//
//     $i++;
// endwhile;




$respuesta->addAssign("consulta_dinamico","innerHTML",$formato);
return $respuesta;
} 

/// fin plan





///NOMBRE DE LA FUNCION: resumen_consulta
// para llamar la funcion utilizar 
// onChange="xajax_dummy(xajax.getFormValues('nombre_formulario'))"
function resumen_consulta($id_usuario,$id_turno,$area,$formulario){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
$usuario=$formulario["username"];
if($usuario !=''){
$password=md5($formulario["password"]);
$consulta_autorizar= "SELECT id FROM d9_users WHERE username = '$usuario' AND passwd = '$password' AND id_grupo='9' ";
$autoriza = mysql_query($consulta_autorizar,$link);
if (mysql_num_rows($autoriza)=='0'){$error = "Error de usuario!";$respuesta->addAlert($error); return $respuesta;}	
											else{$autorizado=mysql_result($autoriza,0,"id");
												}
						}
$titulo="Resumen de consulta";

$areas .= "

		<div name='$titulo"."_".$especialista."' id='$titulo"."_".$especialista."' style='border: 1px solid #$color; ' >
		<div  class='cabecera' style='background-color: #EFFBF5'>&nbsp; &nbsp;<b>$titulo</b> </div>
		<hr>
		
											";

include_once("consulta/funciones/listado.php");
$areas .= listado_areas($id_usuario,$id_turno,$autorizado);

// $i = 0;
// while ($i <= 8):
// if($area == $i){$respuesta->addAssign("boton_$area","style.background","#$_SESSION[mi_bgcolor]");}
// 							else{$respuesta->addAssign("boton_$i","style.background","");}
//
//     $i++;
// endwhile;

//include_once("impresion/impresion_usuario.php");
$areas .= impresion($id_usuario,'','',$id_turno);
$respuesta->addAssign("consulta_dinamico","innerHTML",$areas);
return $respuesta;
} 


function impresion($id,$evento,$perfil,$id_turno){
// $id_turno= $_SESSION[en_consulta];
 if($evento=='' AND $perfil==''){
$nuevo_select = "";
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
$nuevo_select .= "Imprimir: ";
// resumen de consulta													
														
/*
$nuevo_select .= "Imprimir: <a href=\"javascript:abrir('impresion/imprimir_resumen.php?id_turno=$id_turno&id_usuario=$id','PRINT',500,600,100,0,1);\" title='Imprimir el resumen de la consulta general'>Consulta General</a> 
/ <a href=\"javascript:abrir('impresion/imprimir_evolucion.php?id_turno=$id_turno&id_usuario=$id','PRINT',500,600,100,0,1);\" title='Imprimir el resumen de la Evolucion'>Evolución</a> 						
						";
*/
											

// medicamentos pendientes de impresion
$pos=mysql_query("SELECT count(recetas.id_receta) as cantidad, recetas.estado FROM recetas WHERE id_turno='$id_turno'  GROUP BY id_usuario",$link);
//if (mysql_num_rows($pos)> 0)					{
$Total=@mysql_result($pos,0,"cantidad");
$nuevo_select .= "/ <a href=\"javascript:abrir('impresion/imprimir_receta.php?id_turno=$id_turno&id_usuario=$id','PRINT',500,600,100,0,1);\" title='Imprimir medicamentos'>Medicamentos</a>";

//														}
//ordenes pendientes de impresion						
$orden=mysql_query("SELECT count(ordenes.id_orden) as cantidad, ordenes.estado FROM ordenes WHERE id_turno='$id_turno'  GROUP BY id_orden",$link);

//if (mysql_num_rows($orden)> 0)					{
$Total=@mysql_result($orden,0,"cantidad");
$nuevo_select .= "/ <a href=\"javascript:abrir('impresion/imprimir_orden.php?id_turno=$id_turno&id_usuario=$id','PRINT',500,600,100,0,1);\" title='Imprimir ordenes'>Ordenes</a>";

//														}				
														
/// formatos ctc pendientes de impresion

														
														
$ctc=mysql_query("SELECT count(recetas_no_pos.id_receta_no_pos) as cantidad FROM recetas_no_pos WHERE id_turno='$id_turno'  GROUP BY id_usuario",$link);

//if (mysql_num_rows($ctc)> 0)					{
$Total=@mysql_result($ctc,0,"cantidad");
$nuevo_select .= "/ <a href=\"javascript:abrir('impresion/imprimir_ctc.php?id_turno=$id_turno&id_usuario=$id','PRINT',500,600,100,0,1);\" title='Imprimir formulario CTC'> CTC no pos</a>";

//														}	
														
																}/// fin de evento y perfil vacio	
						else {
						$nuevo_select .= "Imprimir: <a href=\"javascript:abrir('impresion/imprimir_atencion.php?id_turno=$id_turno&id_usuario=$id&timestamp=$evento&perfil=$perfil','PRINT',500,600,100,0,1);\" title='Imprimir esta atención'>Atención </a> 						
						";
								}							
$nuevo_select .="";	
			return $nuevo_select ;											
//echo "$nuevo_select";
							}
/// fin dummy

///NOMBRE DE LA FUNCION: ayudas_diagnosticas
// para llamar la funcion utilizar 
// onChange="xajax_dummy(xajax.getFormValues('nombre_formulario'))"
function ayudas_diagnosticas($titulo,$area){ 

//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');

$ayuda = "

		<div name='$titulo"."_".$especialista."' id='$titulo"."_".$especialista."' style='border: 1px solid #$color; ' >
		<div  class='cabecera' style='background-color: #EFFBF5'>&nbsp; &nbsp;<b>$titulo</b> </div>
		<hr>
		<div name='ayudas_diagnosticas' id='ayudas_diagnosticas' >
											";


$ayuda .= "

Tipo: <select name='ayuda_clase' id='ayuda_clase' onchange=\"xajax_revisar_ayudas_diagnosticas(xajax.getFormValues('consulta'))\">
<option  value='' title='Click para seleccionar'>Elija un tipo de ayuda diagnóstica</option>
";
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
$sql=mysql_query("SELECT * FROM ayuda_clases WHERE activo = '1' ",$link);

if (mysql_num_rows($sql)!='0'){
while( $row = mysql_fetch_array( $sql ) ) {
$ayuda .= "<option value='".$row['id_ayuda_clase']."' > ".$row['ayuda_clase']." </option>";
															}
										}
$ayuda .= "
</select><br> 
<div id='ayudas_diagnosticas_formulario' name='ayudas_diagnosticas_formulario'></div>

							";
$ayuda .="</div>";
 $i = 0;
 while ($i <= 8):
 if($area == $i){$respuesta->addAssign("boton_$area","style.background","#$_SESSION[mi_bgcolor]");}
 							else{$respuesta->addAssign("boton_$i","style.background","");}

     $i++;
 endwhile;




$respuesta->addAssign("consulta_dinamico","innerHTML",$ayuda);
return $respuesta;
} 

/// fin ayudas_diagnosticas


///NOMBRE DE LA FUNCION: revisar_ayudas_diagnosticas
// para llamar la funcion utilizar 
// onChange="xajax_dummy(xajax.getFormValues('nombre_formulario'))"
function revisar_ayudas_diagnosticas($variable_array){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$id_ayuda_clase = $variable_array["ayuda_clase"];
$link=Conectarse();
mysql_query("SET NAMES 'utf8'");
$sql=mysql_query("SELECT * FROM ayuda_clases WHERE id_ayuda_clase = '$id_ayuda_clase' ",$link);

if (mysql_num_rows($sql)!='0'){
while( $row = mysql_fetch_array( $sql ) ) {
$nuevo_select = "

Laboratorio o entidad responsable:<br>
 <input type='text' name='ayuda_laboratorio' id='ayuda_laboratorio' size='72' ><br>
Fecha: <input type='text' name='ayuda_fecha' id='ayuda_fecha' size='20' ><br>

Observaciones: <br>
<textarea name='ayuda_observaciones' id='ayuda_observaciones' cols='70' rows='10' title='Por favor escribir al frente cada valor' >".$row['ayuda_forma']."</textarea><input type='hidden' name='ayuda_titulo' id='ayuda_titulo' value='".$row['ayuda_clase']."'><br>";
$nuevo_select .="
<input onclick=\"xajax_grabar_ayudas(xajax.getFormValues('consulta'))\" value='Grabar' type='button'>";
															}
										}

$respuesta->addAssign("ayudas_diagnosticas_formulario","innerHTML",$nuevo_select);
return $respuesta;
} 

/// fin dummy




function superficie_corporal($form){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$peso=$form['20'];
$altura=$form['19'];
$seleccionar_por=$form['seleccionar_por'];
    if ($seleccionar_por == 1){
        $area=0.024265*(pow($peso,0.5378))*(pow($altura,0.3964));
    }
    elseif ($seleccionar_por == 2){
        $area=0.007184*(pow($peso,0.425))*(pow($altura,0.725));
    }
    elseif ($seleccionar_por == 3){
        $area=0.0235*(pow($peso,0.51456))*(pow($altura,0.42246));
    }
    elseif ($seleccionar_por == 4){
        $peso=$peso*1000;
        $area=0.0003207*(pow($peso,(0.7285-(0.0188*log10($peso)))))*(pow($altura,0.3));
    }
    elseif ($seleccionar_por == 5){
        $area=pow((($peso*$altura)/3600),0.5);
    }
    if ($area > 0){$area_listo='Superficie corporal:<b> '.$area.'</b> metros cuadrados'; }else{$area_listo='No hay valores correctos para el calculo';}
$nuevo_select = ''.$area_listo;
$respuesta->addAssign("capa_area","innerHTML",$nuevo_select);
return $respuesta;
}


///NOMBRE DE LA FUNCION: grabar_ayudas
// para llamar la funcion utilizar 
// onChange="xajax_dummy(xajax.getFormValues('nombre_formulario'))"
function grabar_ayudas($variable_array){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$ayuda_laboratorio = $variable_array["ayuda_laboratorio"];
$ayuda_fecha = $variable_array["ayuda_fecha"];
$ayuda_observaciones = $variable_array["ayuda_observaciones"];
$ayuda_clase = $variable_array["ayuda_clase"];
$ayuda_titulo = $variable_array["ayuda_titulo"];
$id_turno = $variable_array["id_turno"];
$id_especialista = $variable_array["id_especialista"];
$id_usuario = $variable_array["id_usuario"];
$link=Conectarse(); 
if($ayuda_laboratorio == ''){$seguir ='0';}
elseif($ayuda_fecha == ''){$seguir ='0';}
elseif($ayuda_observaciones == ''){$seguir ='0';}

if ($seguir == '0'){$atencion = "<img src='images/atencion.gif' alt= '!' title='Revise los campos, no pueden quedar vacios'> Campos incompletos no se ha grabado intentelo nuevamente<br>";}else{


mysql_query("SET NAMES 'utf8'");

$sql=mysql_query("INSERT INTO `ayudas_diagnosticas` (
`id_ayuda` ,
`timestamp` ,
`id_usuario` ,
`id_especialista` ,
`id_turno` ,
`ayuda_laboratorio` ,
`ayuda_fecha` ,
`ayuda_observaciones` ,
`id_ayuda_clase`,
`ayuda_clase`
)
VALUES (
NULL ,
CURRENT_TIMESTAMP , '$id_usuario', '$id_especialista', '$id_turno', '$ayuda_laboratorio', '$ayuda_fecha', '$ayuda_observaciones', '$ayuda_clase', '$ayuda_titulo'
)",$link); 
$ayuda = "";
 }
$ayuda .= "

Tipo: <select name='ayuda_clase' id='ayuda_clase' onchange=\"xajax_revisar_ayudas_diagnosticas(xajax.getFormValues('consulta'))\">
<option  value='' title='Click para seleccionar'>Elija un tipo de ayuda diagnóstica</option>
";
//$link=Conectarse();
mysql_query("SET NAMES 'utf8'");
$sql=mysql_query("SELECT * FROM ayuda_clases WHERE activo = '1' ",$link);

if (mysql_num_rows($sql)!='0'){
while( $row = mysql_fetch_array( $sql ) ) {
$ayuda .= "<option value='".$row['id_ayuda_clase']."' > ".$row['ayuda_clase']." </option>";
															}
										}
$ayuda .= "
</select><br> 
<div id='ayudas_diagnosticas_formulario' name='ayudas_diagnosticas_formulario'>$atencion</div>
<ol>

							";					
							
$sql=mysql_query("SELECT * FROM ayudas_diagnosticas WHERE id_turno = '$id_turno' ",$link);


if (mysql_num_rows($sql)!='0'){
while( $row = mysql_fetch_array( $sql ) ) {
$ayuda .= "<li title ='" . $row['ayuda_observaciones'] . "'>" . $row['ayuda_clase'] . " / " . $row['ayuda_fecha'] . "</li>";
																					}
																					$ayuda .="</ol>";
															}	else {$ayuda .= "<h2>No se han inscrito ayudas diagnosticas en esta consulta</h2>";}						
								


$respuesta->addAssign("ayudas_diagnosticas","innerHTML",$ayuda);
return $respuesta;
} 






///NOMBRE DE LA FUNCION: revisar_orden
// para llamar la funcion utilizar 
// onChange="xajax_dummy(xajax.getFormValues('nombre_formulario'))"
function revisar_orden($tipo_orden){ 
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
//$id_tipo_orden = $variable_array["id_tipo_orden"];

//include_once("librerias/conex.php"); 
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
$sql=mysql_query("SELECT * FROM cups WHERE  codigo = '$tipo_orden'",$link);
if (mysql_num_rows($sql)>'0'){ /// si se ha pasado un id_evento valido
while( $row = mysql_fetch_array( $sql ) ) 
												{
												$nuevo_select .= " $titulo <h2>" .$row['descripcion']."</h2><b>Observaciones o protocolo:</b> <br>";
												}
								
												$nuevo_select .= "
												
												<!-- <input type='hidden' name='tipo' id='tipo' value='$tipo'> -->
												
												<textarea name='observaciones' id='observaciones' cols='70' rows='6'></textarea><br>
												<input type='button' value='Grabar Orden ' onClick=\"xajax_grabar_orden(xajax.getFormValues('consulta')) \" >
																					";
												}else /// sino se alerta
															{$nuevo_select .="No se ha elegido un tipo de orden <img src='images/atencion.gif' alt='!'> ";}	
$respuesta->addAssign("confirmar_orden","innerHTML",$nuevo_select);
return $respuesta;
} 

/// fin revisar_orden


/// fin dummy

///NOMBRE DE LA FUNCION: grabar_orden
// para llamar la funcion utilizar 
// onChange="xajax_dummy(xajax.getFormValues('nombre_formulario'))"
function grabar_orden($variable_array){ 
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$id_turno = $variable_array["id_turno"];
$id_especialista = $_SESSION['id_usuario'];
$id_usuario = $variable_array["id_usuario"];
$observaciones = $variable_array["observaciones"];
$tipo = $variable_array["tipo"];
//$tipo_orden = "id_tipo_orden_".$tipo;
$id_tipo_orden = $variable_array["33333"];
$control = microtime();
$hoy=date('Y-m-d');
list( $ano, $mes, $dia ) = split( '[-]', $hoy );
$fecha_comas = $ano.",".$mes.",".$dia;
$timestamp=mktime(0,0,0, $mes, $dia, $ano);
if($id_tipo_orden == ''){
$nuevo_select = "<h1><img src='images/atencion.gif' alt='!'>Elija un tipo de orden</h1>";
$respuesta->addAssign("estado_orden","innerHTML",$nuevo_select);
return $respuesta;
								}
//include_once("librerias/conex.php"); 
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
mysql_query("INSERT INTO `ordenes` ( `id_orden` , `id_usuario` , `id_especialista` , `timestamp` , `observaciones` , `id_tipo_orden` , `revisada` , `id_turno` , `control` )
VALUES (
NULL , '$id_usuario', '$id_especialista', '$timestamp', '$observaciones', '$id_tipo_orden', '0', '$id_turno', '$control'
)",$link);

$sql=mysql_query("SELECT cups.descripcion, ordenes.observaciones , cups.codigo
									FROM ordenes, cups
									WHERE id_turno = '$id_turno' AND ordenes.id_tipo_orden = cups.codigo 
									GROUP BY id_orden",$link);

$nuevo_select = "<h2>Ordenes expedidas en esta consulta:</h2><ol>";
while( $row = mysql_fetch_array( $sql ) ) {
$nuevo_select .= "<li title='$row[descripcion]'>Código $row[codigo] : $row[observaciones]</li>";
}

$nuevo_select .="</ol>";
$respuesta->addAssign("confirmar_orden","innerHTML",$nuevo_select);
return $respuesta;
} 

/// fin dummy

///NOMBRE DE LA FUNCION: revisar_medicamentos
// para llamar la funcion utilizar 
// onChange="xajax_dummy(xajax.getFormValues('nombre_formulario'))"
function revisar_medicamentos($id_medicamento,$id_usuario){  
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
//$Valor = $id_medicamento["id_medicamento"];
//$id_usuario = $id_medicamento["id_usuario"];



//include_once("librerias/conex.php"); 
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
$sql=mysql_query("SELECT * FROM medicamentos WHERE id_medicamento = '$id_medicamento' LIMIT 1",$link);

$nuevo_select = "Formulando: ";
$nuevo_select .= "<input type='hidden' name='receta' id='receta' value='$id_medicamento'>";
while( $row = mysql_fetch_array( $sql ) ) {

$nuevo_select .= "<b>".$row['id_medicamento']." ".$row['medicamento_nombre']." ".$row['concentracion_forma']."</b>";
if ($row['nopos']=='1'){
$no_pos=mysql_query("SELECT * FROM recetas_no_pos WHERE id_medicamento = '$id_medicamento' 
							AND id_usuario = $id_usuario  ORDER BY id_receta_no_pos DESC LIMIT 1",$link);
while( $pos = mysql_fetch_array( $no_pos ) ) {
$pos_usado=$pos['pos_usado'];
$tiempo_utilizacion=$pos['tiempo_utilizacion'];
$duracion_tratamiento_no_pos=$pos['duracion_tratamiento_no_pos'];
$pos_usado_respuesta=$pos['pos_usado_respuesta'];
$riesgo=$pos['riesgo'];
$efecto_deseado=$pos['efecto_deseado'];
$tiempo_respuesta=$pos['tiempo_respuesta'];
$efectos_secundarios=$pos['efectos_secundarios'];
$observaciones=$pos['observaciones'];
$cantidad=$pos['cantidad'];
$cantidad_letras=$pos['cantidad_letras'];
$posologia=$pos['posologia'];
														}

$nuevo_select .= "<h1>No POS</h1>

<input type='hidden' name='no_pos' id='no_pos' value='no_pos'>
<li>Medicamento POS usado anteriormente:<br>
<textarea name='pos_usado' id='pos_usado' cols='70' rows='3'>$pos_usado</textarea></li>
<li>Tiempo utilizaci&oacute;n del no POS:<br>
<input type='text' name='tiempo_utilizacion' id='tiempo_utilizacion' value='$tiempo_utilizacion' size='70'></li>
<li>Respuesta clínica y paraclínica alcanzada con el medicamento POS:<br>
<textarea name='pos_usado_respuesta' id='pos_usado_respuesta' cols='70' rows='3'>$pos_usado_respuesta</textarea></li>
<li>Riesgo inminente al no ser aplicado el medicamento:<br>
<textarea name='riesgo' id='riesgo' cols='70' rows='3'>$riesgo</textarea></li>
<li>Efecto deseado con la aplicacion del medicamento:<br>
<textarea name='efecto_deseado' id='efecto_deseado' cols='70' rows='3'>$efecto_deseado</textarea></li>
<li>Tiempo estimado de respuesta:<br>
<input type='text' name='tiempo_respuesta' id='tiempo_respuesta' value='$tiempo_respuesta' size='70'></li>
<li>Posibles efectos secundarios:<br>
<textarea name='efectos_secundarios' id='efectos_secundarios' cols='70' rows='3'>$efectos_secundarios</textarea></li>
<li>Bibliografia y observaciones:<br>
<textarea name='observaciones' id='observaciones' cols='70' rows='3'>".$row['observaciones']."</textarea></li>
<li>Duración del tratamiento: <input type='text' name='duracion_tratamiento_no_pos' id='duracion_tratamiento_no_pos' value='$duracion_tratamiento_no_pos' size='20' title='Numero de dias por el cual se formula el tratamiento'> Dias
<li>Cantidad: <input type='text' name='cantidad' id='cantidad' value='$cantidad' size='4'>
Cantidad letras:<input type='text' name='cantidad_letras' id='cantidad_letras' value='$cantidad_letras'></li>
<li>Posologia<br>
<textarea name='posologia' id='posologia' cols='70' rows='5'>$posologia</textarea></li><br> 

<input type='button' onClick=\"xajax_grabar_receta(xajax.getFormValues('consulta')) \" value='Recetar' >
						
							";}
							
							else{ 
							
$pos_receta=mysql_query("SELECT * FROM recetas WHERE id_medicamento = '$id_medicamento' 
							AND id_usuario = $id_usuario  ORDER BY id_receta DESC LIMIT 1",$link);
while( $pos = mysql_fetch_array( $pos_receta ) ) {
$cantidad=$pos['cantidad'];
$cantidad_letras=$pos['cantidad_letras'];
$posologia=$pos['posologia'];
														}							
							
							$nuevo_select .= "
<li>Cantidad: <input type='text' name='cantidad' id='cantidad' value='$cantidad' size='4'>
Cantidad letras:<input type='text' name='cantidad_letras' id='cantidad_letras' value='$cantidad_letras'></li>
<li>Posologia<br>
<textarea name='posologia' id='posologia' cols='70' rows='5'>$posologia</textarea></li><br> 

<input type='button' onClick=\"xajax_grabar_receta(xajax.getFormValues('consulta')) \" value='Recetar' >

													";
									}
}
$nuevo_select .= "</b>";
$respuesta->addAssign("estado","innerHTML",$nuevo_select);
return $respuesta;
} 


/// fin 


///NOMBRE DE LA FUNCION: grabar_receta
// para llamar la funcion utilizar 
// onChange="xajax_dummy(xajax.getFormValues('nombre_formulario'))"
function grabar_receta($variable_array){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$no_pos = $variable_array["no_pos"];
$id_turno = $variable_array["id_turno"];
$id_especialista =  $_SESSION['id_usuario'];
$id_usuario = $_SESSION["id_usuario"];
$id_medicamento = $variable_array["id_medicamento"];
$pos_usado = $variable_array["pos_usado"];
$pos_usado_respuesta = $variable_array["pos_usado_respuesta"];
$cantidad = $variable_array["cantidad"];
$cantidad_letras = $variable_array["cantidad_letras"];
$posologia = $variable_array["posologia"];
$tiempo_utilizacion = $variable_array["tiempo_utilizacion"];
$riesgo = $variable_array["riesgo"];
$efecto_deseado = $variable_array["efecto_deseado"];
$tiempo_respuesta = $variable_array["tiempo_respuesta"];
$efectos_secundarios = $variable_array["efectos_secundarios"];
$observaciones = $variable_array["observaciones"];
$control = md5(microtime());
$hoy=date('Y-m-d');
list( $ano, $mes, $dia ) = split( '[-]', $hoy );
$fecha_comas = $ano.",".$mes.",".$dia;
$timestamp=mktime(0,0,0, $mes, $dia, $ano);
if($id_medicamento == ''){
$nuevo_select = "<h1><img src='images/atencion.gif' alt='!'> No se ha elegido un medicamento ! ( $id_medicamento )</h1>";
$respuesta->addAssign("estado","innerHTML",$nuevo_select);
return $respuesta;
								}
$nuevo_select ="";
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");

if ($no_pos == 'no_pos'){ 
mysql_query("INSERT INTO `recetas_no_pos` ( `id_receta_no_pos` , `timestamp` , `pos_usado` , `pos_usado_respuesta` , `cantidad` , `posologia` , `tiempo_utilizacion` , `riesgo` , `efecto_deseado` , `tiempo_respuesta` , `efectos_secundarios` , `observaciones` , `id_usuario` , `id_medicamento` , `id_especialista` , `id_turno`, `control` , `cantidad_letras`  )
VALUES (
NULL , '$timestamp', '$pos_usado', '$pos_usado_respuesta', '$cantidad', '$posologia', '$tiempo_utilizacion', '$riesgo', '$efecto_deseado', '$tiempo_respuesta', '$efectos_secundarios', '$observaciones', '$id_usuario', '$id_medicamento', '$id_especialista', '$id_turno', '$control', '$cantidad_letras'
)",$link);

mysql_query("INSERT INTO `recetas` ( `id_receta` , `timestamp` , `cantidad` ,`cantidad_letras` , `posologia` , `id_usuario` , `id_medicamento` , `id_especialista` , `id_turno`, `control` )
VALUES (
NULL , '$timestamp', '$cantidad','$cantidad_letras', '$posologia', '$id_usuario', '$id_medicamento', '$id_especialista', '$id_turno', '$control'
)",$link);

								 }
								 
								 else {
								 
mysql_query("INSERT INTO `recetas` ( `id_receta` , `timestamp` , `cantidad` ,`cantidad_letras` , `posologia` , `id_usuario` , `id_medicamento` , `id_especialista` , `id_turno`, `control` )
VALUES (
NULL , '$timestamp', '$cantidad','$cantidad_letras', '$posologia', '$id_usuario', '$id_medicamento', '$id_especialista', '$id_turno', '$control'
)",$link);
								 
								 }



$nuevo_select .= "<h2>Medicamentos formulados en esta consulta</h2><ol>";


$sql=mysql_query("SELECT medicamentos.medicamento_nombre, medicamentos.concentracion_forma, recetas.cantidad, recetas.posologia FROM recetas, medicamentos WHERE recetas.id_turno = '$id_turno' AND recetas.id_medicamento = medicamentos.id_medicamento",$link);


while( $row = mysql_fetch_array( $sql ) ) {
$nuevo_select .= "<li>".$row['medicamento_nombre']." ".$row['concentracion_forma'].": ".$row['cantidad']." ".$row['posologia']."</li>";
}
$nuevo_select .= "</ol>";
$respuesta->addAssign("estado","innerHTML",$nuevo_select);
return $respuesta;
} 

/// fin 

function editar_consulta($formulario){
$respuesta = new xajaxResponse('ISO-8859-1');
$id_campo = $formulario["id_campo"];
$id_especialista = $_SESSION[id_usuario];
$id_usuario = $formulario["id_usuario"];
$control = $formulario["control"];
$id_turno = $formulario["id_turno"];
$timestamp = time(); 
 if($_SESSION['grupo']=='9'){ $w = "AND id_especialista LIKE '%%' ";}else {$w = "AND id_especialista = '$_SESSION[id_usuario]'";}
$link=conectarse();
	mysql_query("SET NAMES 'utf8'");

foreach ($formulario as $campo => $contenido)
	{/// saca los valores del formulario
	$consulta_verificar ="SELECT  contenido FROM consulta_datos WHERE id_consulta_datos = '$campo' AND contenido != '$contenido' $w"; 
$consulta_v = mysql_query($consulta_verificar,$link);
	if (mysql_num_rows($consulta_v)!= '0'){
	$consulta ="UPDATE `consulta_datos` SET 
`id_especialista` = '$id_especialista',
`id_usuario` = '$id_usuario',
`contenido` = '$contenido',

`control` = '$control',
`id_turno` = '$id_turno' WHERE`id_consulta_datos` = '$campo' ";
			mysql_query($consulta,$link);
			//AND bloqueo != '1'
															}
	}

			


// $nuevo_select .= $consulta;

$respuesta->addAssign("cabecera","innerHTML",$nuevo_select);
return $respuesta;
													}/// fin de la funcion editar_consulta
													
$xajax->registerFunction("editar_consulta");/// registra la funcion

//---------------------------------genera los campos  de las consultas-------------------------------------------------------------
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function campos_consulta_dinamico($area,$titulo,$id_usuario,$perfil){
$turno =  $_SESSION['en_consulta'];

if($perfil == 4){
$arregloFecha = getdate();
$fechaSegundos = $arregloFecha[0];	
$alink=Conectarse(); 
$sql= "UPDATE turnos SET timestamp_fin = '".$fechaSegundos."' WHERE id_turno ='".$turno."' AND timestamp_fin is NULL";
$query = mysql_query($sql,$alink);

}


$link=conectarse();
mysql_query("SET NAMES 'utf8'");

									$sql_validar_perfil ="SELECT contenido 
																	FROM consulta_datos , consulta_tipo
																	WHERE	consulta_tipo.id_consulta_tipo = '$perfil'
																	AND consulta_tipo.id_consulta_tipo = consulta_datos.perfil
																	AND consulta_tipo.modificable = '0'
																	AND consulta_datos.perfil = '$perfil' 
																	AND consulta_datos.id_turno = '$turno'";
									$validar_perfil = mysql_query($sql_validar_perfil,$link);
								
//$prellenado = '1';

if($perfil=='0'){$perfil ='%%'; $w_tipo_consulta="AND consulta_tipo_campos.tipo_consulta LIKE '$perfil' AND consulta_campos.id_consulta_campo = consulta_tipo_campos.id_campo"; $tipo_consulta=",consulta_tipo_campos";}///  si el perfil de consulta es 0 se mostraran todos los campos
else{/// si no es cero se mostraran solo los campos del perfil
	$w_tipo_consulta="AND consulta_tipo_campos.tipo_consulta LIKE '$perfil' AND consulta_campos.id_consulta_campo = consulta_tipo_campos.id_campo"; 
	$tipo_consulta=",consulta_tipo_campos";
	}
	$item_cie ='';
	$item='prueba';

if($area=='todas'){$area='%%';}
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
	if($perfil =='1'){ 
	$respuesta->addScript('document.location.href="adentro.php?page=suscriptores&usuario='.$id_usuario.'"') ;

		return $respuesta;
							}

	if (mysql_num_rows($validar_perfil) =='0'){
$campos_formulario .="<div align='center'> <FONT COLOR='RED'>Por favor <b>REVISE</b> los datos ANTES de grabar, despues de hacerlo no podrá corregir los registros </font>
<BR>
						<input title = 'Por favor REVISE los datos ANTES de grabar, despues de hacerlo no podrá corregir los registros' type='button' id='grabar' onClick=\" xajax_grabando_consulta(xajax.getFormValues('consulta'),'cabecera');\" value='GRABAR' >
						</div>";
  $campos=mysql_query("
  		SELECT consulta_campos.id_consulta_campo, `obligatorio`, `prellenado`, 
  				id_consulta_campo, consulta_campos.campo_nombre, consulta_campos.campo_descripcion, 
  				tipo_campo_accion, consulta_campos.campo_area, consulta_campos.orden
		FROM `consulta_campos` , `tipo_campo` , `consulta_areas` $tipo_consulta
		WHERE ( id_especialista='$_SESSION[id_usuario]' OR consulta_campos.id_empresa ='$_SESSION[id_empresa]')
		$w_tipo_consulta
		
		AND consulta_campos.campo_area LIKE '$area'
		AND consulta_areas.id_consulta_area = consulta_campos.campo_area 
		AND consulta_campos.campo_tipo = tipo_campo.id_tipo_campo
		AND consulta_campos.activo='1' GROUP BY consulta_campos.id_consulta_campo
		ORDER BY consulta_areas.orden ,consulta_campos.orden  ASC
		",$link);
$campos_formulario .= " <input type='hidden' name='perfil' id='perfil' value='$perfil'>
								<input type='hidden' name='tipo' id='tipo' value='mostrar'>"; 
$campos_formulario .= "
		
		<div  title = 'Por favor REVISE los datos ANTES de grabar, despues de hacerlo no podrá corregir los registros' name='$titulo"."_".$especialista."' id='$titulo"."_".$especialista."' style='border: 1px solid #$color;' align='center'>
		<div  class='cabecera'  align='left' style='background-color: #EFFBF5'>&nbsp; &nbsp; <b>$titulo</b></div>
		<hr>
		<div  id='alerta'></div>
		<ol>
											";
while( $row = mysql_fetch_array( $campos ) ) {//// empieza el while que muestra los campos
if($perfil=='0'){$requiere='0';}else{$requiere = $row['obligatorio'];}

if($requiere =='1'){$obligatorio="<font color='red'><b title='Campo obligatorio'> * </b></font>";}else{$obligatorio='';}
if($row['prellenado'] == '1'){
$prellenado='1';}else{
$prellenado='0';}
///prellenado
$campo_consulta = $row['id_consulta_campo'];
//global $id_usuario; 
$campos_datos= mysql_query("
  		SELECT id_campo, contenido
		FROM `consulta_datos` 
		WHERE id_usuario = '$id_usuario'
		AND id_campo= $campo_consulta
		ORDER BY timestamp DESC LIMIT  1",$link);
if (mysql_num_rows($campos_datos)!='0'){/// si los campos tienen contenido

			if($prellenado == '1'){/// si el prellenado esta activo
while( $row_contenido = mysql_fetch_array( $campos_datos ) ) {$contenido=$row_contenido['contenido'];}
																
											}//// fin del prellenado
											else{$contenido='';}
													}///fin de los campos con contenido
													else {$contenido = "";}// si no tienen contenido se da vacio

$id_consulta_campo = "<font color='grey' size='-2'>($row[id_consulta_campo])</font> ";
//prellenado
//$contenido =time()."  ".$row['campo_descripcion'];

//$campos_formulario .= $row[id_consulta_campo];
$no_mostrar='0';
if($row[id_consulta_campo] == '7') {$no_mostrar='1';}
if($no_mostrar !='1'){ //// si no se han marcado los campos para no ser mostrados
if($row[id_consulta_campo] =='12'){
$item_cie="33";
$nombre_input ="buscar";
$nombre_contenedor ="contenedor";
$campos_formulario .="Buscar un Cie 10 <input type='text' id='buscar$item_cie' name='buscar$item_cie' value='Buscar un Codigo CIE 10'
 								onkeyup=\"if(revisa('buscar$item_cie')=='si'){numeros(event,$item_cie,''); }
                else{limpia($item_cie)}\" class='nselect' onClick=\"document.getElementById('buscar$item_cie').value='' \"/>
                <br/>
                <style type='text/css'>
     <!--
#contenedor$item_cie {
    position:relative;
text-align:justify;
height:200px;
background-color: white;
z-index:1002;
overflow: auto;
overflow-x:hidden;
font-size: 8pt;
font-family: Arial, Helvetica, sans-serif;
width:300px;

       -->
</style>
                <div id='contenedor$item_cie' onmouseover='sobre()' style='height:200px;  display:inline' ></div>
                </div>";
												}
if($row[id_consulta_campo] >= '12' AND $row[id_consulta_campo] <= '15'){/// campos de cie10
//$campos_formulario .= cie_10();
//$readonly="disabled='disabled'";	
$campo_tipo = "hidden";
$texto_campo= "<input $readonly  name='texto_campo_".$row['id_consulta_campo']."' id='texto_campo_".$row['id_consulta_campo']."' value='$contenido' type='text' size='72'  title='Descripcion del Cie 10'>";
																				}


if ($row['tipo_campo_accion']=='select'){
$select= mysql_query("
  		SELECT campo_valor, predeterminado
		FROM `consulta_campos_valores` 
		WHERE id_consulta_campo =  '$row[id_consulta_campo]'
		",$link);
		$select_valores ='';
while( $row_valores = mysql_fetch_array($select) ) {
  if($row_valores[predeterminado]=='1'){$select_valores .= "<option value ='$row_valores[campo_valor]' selected>$row_valores[campo_valor]</option>";}
	$select_valores .= "<option value ='$row_valores[campo_valor]'>$row_valores[campo_valor]</option>";
																							}
$campos_formulario .= "<div align='' style='display: inline;' title='".$row['campo_descripcion']."'>$id_consulta_campo<b>".$row['campo_nombre'].":</b></div> 
		
			
			
			$obligatorio <select title='".$row['campo_descripcion']."' name='".$row['id_consulta_campo']."' id='".$row['id_consulta_campo']."' >";

$campos_formulario .="			$select_valores</select><br>";
			}
//// fin select
				
				
if ($row['tipo_campo_accion']=='textarea'){
$campos_formulario .= "<div align=''>[<font color='red'  title='".$row['campo_descripcion']."'>?</font>] <b>".$row['campo_nombre'].":</b>$obligatorio $id_consulta_campo</div> 
	<textarea name='".$row['id_consulta_campo']."' id='".$row['id_consulta_campo']."' rows='5' cols='70' title='".$row['campo_descripcion']."'>$contenido</textarea>
			<br>";									}
if ($row['tipo_campo_accion']=='text'){
$campos_formulario .=  "[<font color='red'  title='".$row['campo_descripcion']."'>?</font>] <b> ".$row['campo_nombre'].":</b> 
<br>
			$obligatorio $id_consulta_campo
			<input $readonly  name='".$row['id_consulta_campo']."' id='".$row['id_consulta_campo']."' value='$contenido' type='text' size='72'  title='".$row['campo_descripcion']."'>
			<br>";
													 }														
																	  
if (is_numeric($row['tipo_campo_accion']))	{
$campos_formulario .=  "[<font color='red'  title='".$row['campo_descripcion']."'>?</font>] <b>".$row['campo_nombre'].": </b>
	$obligatorio $id_consulta_campo<input $readonly  name='".$row['id_consulta_campo']."' id='".$row['id_consulta_campo']."' value='$contenido' type='$campo_tipo' size='".$row['tipo_campo_accion']."'  maxlength='".$row['tipo_campo_accion']."' title='".$row['campo_descripcion']."'  > $texto_campo
			<br>";
															}


																  }/// fin de los campos que se muestran
																	  			}/// fin del while

$campos_formulario .="</ol>";
$campos_formulario .="<div align='center'> <FONT COLOR='RED'>Por favor <b>REVISE</b> los datos ANTES de grabar, despues de hacerlo no podrá corregir los registros </font>
<BR>
						<input title = 'Por favor REVISE los datos ANTES de grabar, despues de hacerlo no podrá corregir los registros' type='button' id='grabar' onClick=\" xajax_grabando_consulta(xajax.getFormValues('consulta'),'cabecera');\" value='GRABAR' >
						</div>";
//$campos_formulario .="<div align='center'><input type='button' id='grabar' onClick=\" xajax_grabando_consulta(xajax.getFormValues('consulta'),'cabecera');\" value='GRABAR' ></div>";
 $i = 0;
 while ($i <= 8):
 if($area == $i){
 //$respuesta->addAssign("boton_$area","style.background","#$_SESSION[mi_bgcolor]");
 								}
 							else{
 							//$respuesta->addAssign("boton_$i","style.background","");
 									}

     $i++;
 endwhile;


///
//include ('consulta/cie_10/prueba.php');
//$campos_formulario .=cie10ajax();
///
///////   FIND DE LOS CAMPOS PARA CONSULTAS QUE SON MODIFICABLES O QUE NO TIENEN DATOS
  												}ELSE {$campos_formulario .="<div align='center'><h1 TITLE='Esta consulta ya fué grabada y los datos no son modificables.'><img src='images/atencion.gif' alt='[!]' title='Advertencia'> La consulta ya fué grabada!</h1></div>";}
$respuesta->addAssign("consulta_dinamico","innerHTML",$campos_formulario);

return $respuesta;										
										
												
} 



/// formulario consulta

function formulario_consulta($area,$titulo,$especialista){

$link=conectarse();
mysql_query("SET NAMES 'utf8'");
  $campos=mysql_query("
  		SELECT id_consulta_campo, campo_nombre, campo_descripcion, tipo_campo_accion, campo_area, orden
		FROM `consulta_campos` , `tipo_campo`
		WHERE ( id_especialista = '$especialista' OR id_empresa ='$_SESSION[id_empresa]')
		AND campo_area = '$area'
		AND consulta_campos.campo_tipo = tipo_campo.id_tipo_campo
		ORDER BY orden ASC",$link);

$campos_formulario = "<form name='Xarea_$area' id='Xarea_$area'>
<div name='cabecera' id='cabecera' class='cabecera'><b>$titulo</b> [-]<input type ='hidden' name='id_especialista' id='id_especialista' value='$especialista'><input type='hidden' name='Xarea' id='Xarea' value='$area'> <input type='button' value='+' OnClick=\"xajax_crear_campos_consulta(xajax.getFormValues('Xarea_$area'));\"></div></form><div name='$titulo"."_".$especialista."' id='$titulo"."_".$especialista."' style='border: 1px solid #$color; '>

";
$campos_formulario .= "<div name='crear_campos_consulta_$area' id='crear_campos_consulta_$area'>	</div>";	
while( $row = mysql_fetch_array( $campos ) ) {
if ($row['tipo_campo_accion']=='textarea'){$campos_formulario .= "<div  name='id_campos_consulta_".$row['id_consulta_campo']."' id='id_campos_consulta_".$row['id_consulta_campo']."'><form name='Xcampo_editar".$row['id_consulta_campo']."' id='Xcampo_editar".$row['id_consulta_campo']."'><input  name='id_campo_editar' id='id_campo_editar' value='".$row['id_consulta_campo']."' type='hidden'><input type='hidden' name='Xarea' id='Xarea' value='".$row['campo_area']."' type='hidden'><input name='id_campo_editar' type='hidden' id='id_campo_editar' value='".$row['id_consulta_campo']."'></form>".$row['orden']."<input type='button' style='width: 200;text-align: left;'  value='".$row['campo_nombre']."' OnClick=\"xajax_crear_campos_consulta(xajax.getFormValues('Xcampo_editar".$row['id_consulta_campo']."'));\" title='".$row['campo_descripcion']."'><br><textarea name='".$row['campo_nombre']."' rows='5' cols='70'></textarea></div><br><br>";}
if ($row['tipo_campo_accion']=='text'){$campos_formulario .= "<div   name='id_campos_consulta_".$row['id_consulta_campo']."' id='id_campos_consulta_".$row['id_consulta_campo']."'><form name='Xcampo_editar".$row['id_consulta_campo']."' id='Xcampo_editar".$row['id_consulta_campo']."'><input name='id_campo_editar' id='id_campo_editar' value='".$row['id_consulta_campo']."' type='hidden' ><input type='hidden' name='Xarea' id='Xarea' value='".$row['campo_area']."' ><input name='id_campo_editar' id='id_campo_editar' value='".$row['id_consulta_campo']."' type='hidden'></form>".$row['orden']."<input type='button' style='width: 200;text-align: left;'  value='".$row['campo_nombre']."' OnClick=\"xajax_crear_campos_consulta(xajax.getFormValues('Xcampo_editar".$row['id_consulta_campo']."'));\" title='".$row['campo_descripcion']."'><br> <input name='".$row['campo_nombre']."' id='".$row['campo_nombre']."' type='".$row['tipo_campo_accion']."' size='72'></div><br><br>";}																		

if (is_numeric($row['tipo_campo_accion'])){$campos_formulario .= "<div   name='id_campos_consulta_".$row['id_consulta_campo']."' id='id_campos_consulta_".$row['id_consulta_campo']."'><form name='Xcampo_editar".$row['id_consulta_campo']."' id='Xcampo_editar".$row['id_consulta_campo']."'><input name='id_campo_editar' id='id_campo_editar' value='".$row['id_consulta_campo']."' type='hidden' ><input type='hidden' name='Xarea' id='Xarea' value='".$row['campo_area']."' ><input name='id_campo_editar' id='id_campo_editar' value='".$row['id_consulta_campo']."' type='hidden'></form>".$row['orden']."<input type='button' style='width: 200;text-align: left;'  value='".$row['campo_nombre']."' OnClick=\"xajax_crear_campos_consulta(xajax.getFormValues('Xcampo_editar".$row['id_consulta_campo']."'));\" title='".$row['campo_descripcion']."'> <input name='".$row['campo_nombre']."' id='".$row['campo_nombre']."' type='".$row['tipo_campo_accion']."' size='".$row['tipo_campo_accion']."'></div><br><br>";}																		


																	  }

echo $campos_formulario;
												
} 


///fin formulario consulta



/// crear formulario consulta
function crear_campos_consulta($variable_array){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$area = $variable_array["Xarea"];
$especialista = $variable_array["id_especialista"];
$id_campo_editar = $variable_array["id_campo_editar"];
$resultado = "$id_campo_editar";
$link = conectarse();
mysql_query("SET NAMES 'utf8'");
$capa = "crear_campos_consulta_$area";	
$formulario ="manejo_campos_$area";

if ($id_campo_editar > 0){
$sql=mysql_query("SELECT * FROM consulta_campos WHERE id_consulta_campo = '$id_campo_editar'",$link);
while( $row = mysql_fetch_array( $sql ) ) {
$resultado .="";
$campo_descripcion =$row['campo_descripcion'];
$campo_nombre =$row['campo_nombre'];
$orden =$row['orden'];
$especialista =$row['id_especialista'];
$capa ="id_campos_consulta_$id_campo_editar";
$formulario ="manejo_campos_$id_campo_editar";
$editar="<input type='hidden' name='editar' id='editar' value='editar'>
			<input type='hidden' name='id_campo_editar' id='id_campo_editar' value='$id_campo_editar'>
			<input type='hidden' name='misma_area' id='misma_area' value='$area'>";
$Campo_tipo_definido= $row['campo_tipo'];			
}
								}
								
$Tipo_campo ="  Tipo: <select name='campo_tipo' id='campo_tipo' >";
$tipos=mysql_query("
  		SELECT *
		FROM `tipo_campo` 
		WHERE activo = '1'
		",$link);
while( $row = mysql_fetch_array( $tipos ) ) {

if($row['id_tipo_campo'] == $Campo_tipo_definido){
$Tipo_campo .= " <option value='".$row['id_tipo_campo']."' SELECTED > > ".$row['id_tipo_campo']." - ".$row['tipo_campo_nombre']." < </option>";
																									}
$Tipo_campo .= " <option value='".$row['id_tipo_campo']."'>".$row['id_tipo_campo']." - ".$row['tipo_campo_nombre']."</option>";
}
$Tipo_campo .="</select>";




$Areas ="<select name='campo_area' id='campo_area'' >";
$areas=mysql_query("
  		SELECT *
		FROM `consulta_areas` 
		WHERE estado = '1'
		",$link);
while( $row = mysql_fetch_array( $areas ) ) {

if ($row['id_consulta_area']==$area){

$Areas .= "<option value='".$row['id_consulta_area']."' SELECTED >".$row['id_consulta_area']." - ".$row['consulta_area_nombre']."< </option>";
													}
$Areas .= "<option value='".$row['id_consulta_area']."'>".$row['id_consulta_area']." - ".$row['consulta_area_nombre']."</option>";
}
$Areas .="</select><img src='images/atencion_s.gif'alt='!' title='SI CAMBIA EL AREA TENDRA QUE REFRESCAR LA PAGINA PARA VER LOS EFECTOS'>";


$identificador = md5($_SESSION[id_usuario]."-".microtime());

$resultado .= "<div name='formulario_campos_$area' id='formulario_campos_$area' style='padding: 10px;' class='BC".$especialista."' >
	<form name='$formulario' id ='$formulario'>
	<br>Nombre del campo: <input type='text' name='campo_nombre' id='campo_nombre' size='35' value ='$campo_nombre'>
	<br>Descripci&oacute;n<br><textarea name='campo_descripcion' id='campo_descripcion' cols=60 rows='3'>$campo_descripcion</textarea>
	<br>Area: $Areas 
	Orden: 
				<select 	name='campo_orden' id='campo_orden' >";
if($orden >= 1){
$resultado .= "		<option value='$orden' SELECTED>$orden <</option>	";
					}
$resultado .= "		<option value='01'>01</option>	
				<option value='02'>02</option>	
				<option value='03'>03</option>	
				<option value='04'>04</option>	
				<option value='05'>05</option>	
				<option value='06'>06</option>	
				<option value='07'>07</option>	
				<option value='08'>08</option>	
				<option value='09'>09</option>	
				<option value='10'>10</option>				
				</select>
	
$Tipo_campo 
	<input type='hidden' name='misma_area' id='misma_area' value='$area'>
	<input type ='button' value=' Guardar ' OnClick=\"xajax_formulario_consulta_procesar(xajax.getFormValues('$formulario'))\" />	
		<br><input type ='hidden' name='id_especialista' id='id_especialista' value='$especialista'>
		$editar
		<input type ='hidden' name='tipo' id='tipo' value='nuevo'>
		<input type ='hidden' name='campo_identificador' id='campo_identificador' value='$identificador $especialista'>
	 	</form>
			 	
	 	</div>";
	
$respuesta->addAssign("$capa","innerHTML",$resultado);
return $respuesta;
}


///// fin


///NOMBRE DE LA FUNCION: formulario_consulta
// para llamar la funcion utilizar 
// onChange="xajax_formulario_consulta(xajax.getFormValues('nombre_formulario'))"
function formulario_consulta_procesar($variable_array){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('ISO-8859-1');
$id_especialista = $variable_array["id_especialista"];

$id_empresa = $_SESSION['id_empresa'];
$campo_nombre = $variable_array["campo_nombre"];
$campo_descripcion = $variable_array["campo_descripcion"];
$campo_tipo = $variable_array["campo_tipo"];
$campo_area = $variable_array["campo_area"];
$misma_area = $variable_array["misma_area"];
$campo_orden = $variable_array["campo_orden"];
$campo_identificador = $variable_array["campo_identificador"];
$tipo = $variable_array["tipo"];
$editar = $variable_array["editar"];
$id_campo_editar = $variable_array["id_campo_editar"];
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
if ($editar == 'editar'){
mysql_query("
						UPDATE `consulta_campos` 
						SET `campo_nombre` = '$campo_nombre',
						`campo_descripcion` = '$campo_descripcion',
						`orden` = '$campo_orden' ,
						`campo_area` = '$campo_area',
						`campo_tipo` = '$campo_tipo',
						`id_empresa` = '$id_empresa'
						WHERE `consulta_campos`.`id_consulta_campo` ='$id_campo_editar'
						LIMIT 1 ;",$link);
$w_campo = "id_consulta_campo = '$id_campo_editar'";						

								}else {

mysql_query("
				insert into `consulta_campos` 
			(`id_especialista`, `campo_nombre`,`campo_descripcion`,`campo_tipo`, `campo_area`, `orden`, `activo`, `identificador`, `id_empresa`) 
  values ('$id_especialista','$campo_nombre','$campo_descripcion','$campo_tipo','$campo_area','$campo_orden','1','$campo_identificador','$id_empresa')",$link);  
$w_campo= "identificador = '$campo_identificador'";
										}

  $campos=mysql_query("
  		SELECT id_consulta_campo, campo_nombre, campo_descripcion, tipo_campo_accion, campo_area, orden
		FROM `consulta_campos` , `tipo_campo`
		WHERE $w_campo
		
		AND consulta_campos.campo_tipo = tipo_campo.id_tipo_campo
		LIMIT 1",$link);

$campos_formulario = "";
$campos_formulario .= "<div name='crear_campos_consulta_$campo_area' id='crear_campos_consulta_$campo_area'>	</div>";	
while( $row = mysql_fetch_array( $campos ) ) {
if ($row['tipo_campo_accion']=='textarea'){
$campos_formulario .= "<div  name='id_campos_consulta_".$row['id_consulta_campo']."' id='id_campos_consulta_".$row['id_consulta_campo']."'><form name='Xcampo_editar".$row['id_consulta_campo']."' id='Xcampo_editar".$row['id_consulta_campo']."'><input  name='id_campo_editar' id='id_campo_editar' value='".$row['id_consulta_campo']."' type='hidden'><input type='hidden' name='Xarea' id='Xarea' value='".$row['campo_area']."' type='hidden'><input name='id_campo_editar' type='hidden' id='id_campo_editar' value='".$row['id_consulta_campo']."'></form>".$row['orden']."<input type='button' style='width: 200;text-align: left;'  value='".$row['campo_nombre']."' OnClick=\"xajax_crear_campos_consulta(xajax.getFormValues('Xcampo_editar".$row['id_consulta_campo']."'));\" title='".$row['campo_descripcion']."'><br><textarea name='".$row['campo_nombre']."' rows='5' cols='70'></textarea></div><br><br>";}
else{
$campos_formulario .= "<div   name='id_campos_consulta_".$row['id_consulta_campo']."' id='id_campos_consulta_".$row['id_consulta_campo']."'><form name='Xcampo_editar".$row['id_consulta_campo']."' id='Xcampo_editar".$row['id_consulta_campo']."'><input name='id_campo_editar' id='id_campo_editar' value='".$row['id_consulta_campo']."' type='hidden' ><input type='hidden' name='Xarea' id='Xarea' value='".$row['campo_area']."' ><input name='id_campo_editar' id='id_campo_editar' value='".$row['id_consulta_campo']."' type='hidden'></form>".$row['orden']."<input type='button' style='width: 200;text-align: left;'  value='".$row['campo_nombre']."' OnClick=\"xajax_crear_campos_consulta(xajax.getFormValues('Xcampo_editar".$row['id_consulta_campo']."'));\" title='".$row['campo_descripcion']."'><br> <input name='".$row['campo_nombre']."' id='".$row['campo_nombre']."' type='".$row['tipo_campo_accion']."' size='72'></div><br><br>";
																	  }																		}


$respuesta->addAssign("formulario_campos_$misma_area","innerHTML",$campos_formulario);
return $respuesta;
} 

/// FIN DE LA FUNCION 


/// FIN DE LA FUNCION dummy


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
