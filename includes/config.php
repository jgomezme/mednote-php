<?php 
$Usuario="root";
$Password="root";
$Servidor="localhost";
$BaseDeDatos="opuslibertati";
$usuarios_sesion="husda";
$sql_tabla="d9_users";
$obligatorio ="<font color='red' title='CAMPO OBLIGATORIO!' >*</font>";

define("USUARIO", "root");
define("PASS", "root");
define("SERVER", "localhost");
define("BDATA", "opuslibertati");

function conect()
{
//global $Servidor, $Usuario, $Password, $BaseDeDatos;

   if (!($link=mysql_connect(SERVER,USUARIO,PASS)))
   {
      echo "Error conectando a la base de datos.";
      exit();
   }
   if (!mysql_select_db(BDATA,$link))
   {
      echo "Error seleccionando la base de datos.";
      exit();
   }
   return $link;
   
}

?>
