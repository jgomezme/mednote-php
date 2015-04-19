<?php
session_start();
// Comprobamos si existe la variable
if ( isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: adentro.php");
} 
include_once("librerias/conex.php"); 
$link = Conectarse(); 
$usuario = $_SESSION['usuario'];
include_once("includes/datos.php");
  // No almacenar en el cache del navegador esta página.
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");             		// Expira en fecha pasada
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");		// Siempre página modificada
		header("Cache-Control: no-cache, must-revalidate");           		// HTTP/1.1
		header("Pragma: no-cache");  
		 
include_once("includes/datos.php");                                 		// HTTP/1.0
?>
<html xmlns="http://www.w3.org/1999/xhtml"xml:lang="es" lang="es" dir="ltr">
<head>  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Administracion de Usuarios <?php echo $empresa; ?></title>

 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
 <link rel="SHORTCUT ICON" href="icono.ico">



<link href="estilos/estilo.css" rel="stylesheet" type="text/css">
</head>
<body >

<?php  echo $_SESSION['usuario_login'] ; ?>
<form action="includes/control.php" method="POST">
<table width="80%" border="0" align="center">  
<tr>
   <td colspan="3" align="center">
   
   <br><br><img src="images/logo.gif"  border="0" title="<?php echo $empresa; ?>" alt="<? echo $empresa; ?>" align="top"><br>
  </td>  
</tr>
<tr>
    <td colspan="2" align="center" 
	<?php if($_REQUEST["errorusuario"]=="si") {
		echo "bgcolor=red><span style="color:ffffff"><b>Datos incorrectos</b></span>";
	} elseif($_REQUEST["errorusuario"]=="inactivo") {
	    echo "bgcolor=red><span style='color:ffffff'><b>Usuario inactivo</b></span>";
	} else {
		echo "bgcolor=#cccccc>Por favor ingrese los siguientes datos:";
	}?>
	</td>
</tr>

<tr>
    <td align="center" colspan="2"><br><div align="center"><h3>Nombre:<input type="Text" name="usuario" size="20" maxlength="50"> Clave:<input type="password" name="clave" size="12" maxlength="50"> <input type="Submit" value="Entrar"></h3></td>
</tr>
<tr><td align="center" colspan="2"><a href="suscriptores/password/password_perdido.php">He perdido mi contrase&ntilde;a</a></tr>
<tr>
    <td colspan="2" align="center" valign="bottom">
    <table border='0' width='100%'>
    <tr>
    <td><a href='http://www.opuslibertati.org/opus/'  border='0'>
    <img src="images/opuslibertati.png"  border="0" title="http://OpusLibertati.org" alt="http://OpusLibertati.org" >  </a></td>
    <td width='100%' >.</td>
    <td><a href='http://qwerty.com.co'  border='0'><img src="images/qwerty.png"  border="0" title="http://qwerty.com.co" alt="QWERTY LTDA">    </a></td>
    </tr></table>
	<hr>

    </td>
</tr>
</table>

</form>
<br>
