 <?PHP
require_once("../../xajax/xajax.inc.php");
$xajax = new xajax(”fetchEmails.server.php”); 

$xajax->registerFunction(”fetchEmails”); $xajax-> registerFunction ( "fetchEmails");
?> >
<html>
<head><title>Example XAJAX to fetch emails</title> <head> <title> Ejemplo xajax para buscar mensajes de correo electrónico </ title>

 <? $xajax->printJavascript("../../xajax/");  ?>
<style>
.emailRow { . emailRow (
background-color: white; fondo de color: blanco;
border: 0px; border: 0px;
} )
.emailRow_highlight { . emailRow_highlight (
background-color: #00cccc; fondo-color: # 00cccc;
border: 1px outset blue; border: 1px todo azul;
} )
</style> </ style>
<script language=”javascript”> <script language="javascript">
<!– <! --

// INITIATE GLOBAL VARIABLES: / / INCOAR variables globales:
var emails = new Array; // will be populated by calling xajax_fetchEmails() remotely var mensajes = new Array; / / se pobladas llamando xajax_fetchEmails () a distancia
var timer = null; var timer = null;
var selectedRow = -1; // for highlighting the row selectedRow var = -1; / / para poner de relieve la fila
var numRows = 0; // for using arrow keys to navigate the list numRows var = 0; / / para el uso de teclas de flecha para navegar por la lista

// This function reduces the number of XAJAX calls we make / / Esta función reduce el número de xajax pide que hagamos
// b/c if you are continuously typing, then the timer keeps / / B / c si usted está escribiendo continuamente, entonces el temporizador mantiene
// getting cancelled. / / Obtener cancelado. When you stop typing for half a second Cuando usted deja de mecanografía para la mitad de un segundo
// then we make the xajax_fetchEmails call. / / Entonces hacemos la xajax_fetchEmails llamada. Genious!
function setTimer_fetchEmails(e) setTimer_fetchEmails función (e)
{ (
// if I have typed a key in less than half a second / / Si me ha escrito un elemento clave en menos de medio segundo
// cancel the pending xajax_fetchEmails call: / / Cancelar la llamada en espera xajax_fetchEmails:
if ( timer != null ) if (temporizador! = null)
clearTimeout(timer); clearTimeout (temporizador);

// for windows and IE compatibility / / Para Windows y la compatibilidad de IE
if ( e == null ) if (e == null)
e = window.event; e = window.event;
var key = ( e.keyCode > 0 ? e.keyCode : e.which ); var clave = (e.keyCode> 0? e.keyCode: e.which);

// if down or up arrow, move up or down the list instead! / / Si abajo o flecha hacia arriba, mover hacia arriba o hacia abajo en lugar de la lista!
if ( key == 40 ) // down if (clave == 40) / / abajo
{ (
// down arrow clicked, let’s move down the list: / / Flecha hacia abajo clic, vamos a bajar la lista:
if ( selectedRow 1 < numRows ) if (selectedRow 1 <numRows)
{ (
highlightRow(selectedRow 1); highlightRow (selectedRow 1);
} )
return false; devolver false;
} )
else if ( key == 38 ) // up else if (key == 38) / / hasta
{ (
// up arrow clicked, let’s move up the list: / / Flecha hacia arriba se hace clic, vamos a ascender en la lista:
if ( selectedRow > 0 ) if (selectedRow> 0)
{ (
highlightRow(selectedRow-1); highlightRow (selectedRow-1);
} )
return false; devolver false;
} )
else if ( key == 13 ) // ENTER KEY else if (key == 13) / / tecla ENTER
{ (
if ( selectedRow > -1 ) if (selectedRow> -1)
{ (
document.getElementById(’email’).value = emails[selectedRow]; document.getElementById ( 'email'). value = e-mails [selectedRow];
clearEmails(); clearEmails ();
} )
return false; devolver false;
} )
else if ( key == 37 || key == 39 ) else if (key == 37 | | tecla == 39)
return; retorno;

// in half a second, if another key is not pressed, then / / En medio segundo, si otra de las claves no se presiona, a continuación,
// fetchEmails() will be called. / / FetchEmails () será llamado. fetchEmails() makes the call fetchEmails () hace la llamada
// back to the server to fetch the data. / / Vuelta al servidor para obtener los datos.
timer = setTimeout(”fetchEmails()”, 500); temporizador = setTimeout ( "fetchEmails ()", 500);
} )

function fetchEmails() fetchEmails función ()
{ (
// trim whitespace: / / Recortar en blanco:
var email = document.getElementById(’email’).value.replace(/ /g, “”); var email = document.getElementById ( 'email'). value.replace (/ / g, "");
// as long as we have something in the email box, call the function on the / / Siempre y cuando tenemos algo en la casilla de correo electrónico, llame a la función en la
// server to fetch the emails. / / Servidor para descargar el correo electrónico. The server will respond with a chunk of El servidor responderá con un fragmento de un
// javascript to be executed, which is an array of emails and then showEmails() / / Javascript para ser ejecutado, que es un conjunto de mensajes de correo electrónico y, a continuación, showEmails ()
if ( email.length > 0 ) if (email.length> 0)
xajax_fetchEmails(document.getElementById(’email’).value, 0, 15); xajax_fetchEmails (document.getElementById ( 'email'). valor, 0, 15);
else algo más
clearEmails(); clearEmails ();
} )
function showEmails() showEmails función ()
{ (
if ( emails.length > 0 ) if (emails.length> 0)
{ (
var aDiv = document.getElementById(’div_emails’); aDiv var = document.getElementById ( 'div_emails');
var div_style = GetLayerStyle(’div_emails’); div_style var = GetLayerStyle ( 'div_emails');
var leftpos = 0; VAR leftpos = 0;
var toppos = 0; toppos var = 0;

// GET THE POSITION, THIS IS A COOL WAY TO GET THE POSITION: / / Obtener la posición, este es un lugar fresco manera de obtener la posición:
aTag = document.getElementById(’email’); ATAG = document.getElementById ( 'email');
do { do (
aTag = aTag.offsetParent; ATAG = aTag.offsetParent;
leftpos = aTag.offsetLeft; leftpos = aTag.offsetLeft;
toppos = aTag.offsetTop; toppos = aTag.offsetTop;
} while (aTag.tagName != ‘BODY’); ) While (aTag.tagName! = 'CUERPO');
// POSITION OF THE email FORM ELEMENT IS FOUND, BUT WE DON’T WANT / / Posición del elemento de correo electrónico forma se encuentra, pero no queremos
// TO PLACE THE DROP DOWN OVER THE email FORM ELEMENT, SO LET’S MOVE / / Para colocar el menú desplegable durante el formulario de correo electrónico, por lo que vamos a pasar
// IT DOWN A TAD: / / IT ABAJO A TAD:
toppos = 24; toppos = 24;
div_style.left = leftpos ’px’; div_style.left = leftpos 'px';
div_style.top = toppos ’px’; div_style.top = toppos 'px';
// CREATE THE TABLE TO PUT IN THE HIDDEN DIV THAT WILL BECOME OUR / / Crear la mesa para poner en las div ocultas que se convertirá en nuestro
// DROP DOWN: / / Menú desplegable:
var str = ‘<table>’; var str = '<table>';
// build the rows of the drop down table / / Construir las filas del cuadro desplegable
for (var i=0; i<emails.length; i ) for (var i = 0; i <emails.length; i )
{ (
str = ‘<tr id=”emailRow’ i ’” class=”emailRow” onMouseOver=”highlightRow(’ i ’)” onClick=”selectEmail(\” emails[i] ’\')”><td>’; str = '<tr id="emailRow' i '" class="emailRow" onMouseOver="highlightRow(' i ')" onClick="selectEmail(\" emails[i] '\')"> <TD> ';
str = emails[i]; str = mensajes de correo electrónico [i];
str = ‘</td></tr>’; str = '</ td> </ tr>';
} )
str = ‘</table>’; str = '</ table>';
aDiv.innerHTML = str; aDiv.innerHTML = str;
numRows = emails.length; numRows = emails.length;
// SHOW IT: / / SHOW IT:
div_style.display = ‘inline’; div_style.display = 'inline';
} )
else { else (
// clear the drop down: / / Claro el menú desplegable:
clearEmails(); clearEmails ();
} )
} )

// function to remove the drop down table and reset the global variables: / / Función para quitar el cuadro desplegable y restablecer las variables globales:
function clearEmails() clearEmails función ()
{ (
var aDiv = document.getElementById(’div_emails’); aDiv var = document.getElementById ( 'div_emails');
var div_style = GetLayerStyle(’div_emails’); div_style var = GetLayerStyle ( 'div_emails');
div_style.display = ‘none’; div_style.display = 'ninguno';
aDiv.innerHTML = ”; aDiv.innerHTML = ";
numRows = 0; numRows = 0;
selectedRow = -1; selectedRow = -1;
} )

// used when clicking a row from the drop down, used to populate the text element: / / Usa cuando una fila, haga clic en el menú desplegable, que sirve para rellenar el elemento de texto:
function selectEmail(email) función selectEmail (correo electrónico)
{ (
document.getElementById(’email’).value = email; document.getElementById ( 'email'). value = correo electrónico;
clearEmails(); clearEmails ();
document.getElementById(’email’).focus(); document.getElementById ( 'email'). centrar ();
} )

// loop through all the rows, unhighlighting all except the selcted row / / Bucle a través de todas las filas, unhighlighting todos, excepto la fila selcted
// highlighting that row. / / Poner de relieve que la fila. We do this by changing the className Lo hacemos por cambiar el className
function highlightRow( i ) highlightRow función de (i)
{ (
for (var j=0; j<numRows; j ) for (var j = 0; j <numRows; j )
{ (
if ( j == i ) if (i == j)
document.getElementById(’emailRow’ j).className = ‘emailRow_highlight’; document.getElementById ( 'emailRow' j). className = 'emailRow_highlight';
else algo más
document.getElementById(’emailRow’ j).className = ‘emailRow’; document.getElementById ( 'emailRow' j). className = 'emailRow';
} )
selectedRow = i; selectedRow = i;
} )

// neat little function for getting the style object for a named element: / / Poco aseado función para obtener el estilo de un objeto llamado elemento:
function GetLayerStyle(layername) { función GetLayerStyle (layername) (
if (document.all) return document.all[layername].style; if (document.all) return document.all [layername]. estilo;
else return document.getElementById(layername).style; otra vuelta document.getElementById (layername). estilo;
} )

function captureEmailKeystrokes() captureEmailKeystrokes función ()
{ (
// must on onkeydown, onkeypress in IE sucks, IE doesn’t / / Debe a OnKeyDown, onkeypress en IE sucks, es decir no
// fire the event on arrow keys when using onkeypress … / / El fuego en caso de las teclas de dirección cuando se utiliza onkeypress…
// which tripped me up for awhile, onkeydown works fine / / Que me disparado hasta por un tiempo, OnKeyDown funciona bien
// in IE, but in firefox, returning false onkeydown doesn’t stop / / En IE, pero en el firefox, volviendo falsa OnKeyDown no se detiene
// the event from happening. / / El evento ocurra. SOOOO, we need onkeydown for Soooo, es necesario para OnKeyDown
// IE and onkeypress for firefox, yuck: / / IE y onkeypress para firefox, Qué asco:
if ( document.all ) if (document.all)
document.emailform.email.onkeydown = setTimer_fetchEmails; document.emailform.email.onkeydown = setTimer_fetchEmails;
else algo más
document.emailform.email.onkeypress = setTimer_fetchEmails; document.emailform.email.onkeypress = setTimer_fetchEmails;
} )

// –> / / ->
</script> </ script>

</head> </ head>
<body bgcolor=”white” onLoad=”captureEmailKeystrokes();”> <body bgcolor="white" onLoad="captureEmailKeystrokes();">

<table><tr> <table> <tr>
<form name=”emailform”> <form name="emailform">
<table><tr> <table> <tr>
<td>Email:</td> <TD> E-mail: </ td>
<td><input type=”text” size=”50″ name=”email” id=”email” maxlength=”255″ onBlur=”setTimeout(’clearEmails();’, 400)” AUTOCOMPLETE=”off”></td> <TD> <entrada type = "text" size = "50" name = "email" id = "email" maxlength = "255" onBlur = "setTimeout ( 'clearEmails ();', 400)" autocomplete = "off" > </ TD>
</tr></table> </ tr> </ table>
</form> </ form>
<div id=”div_emails” style=”border: 2px inset blue; padding: 2px; position:absolute; display:none; background-color:white; z-index:100″></div> <div id="div_emails" style="border: 2px inserción blue; padding: 2px; position:absolute; display:none; background-color:white; z-index:100"> </ div>
</body> </ body>
</html> </ HTML> <?php
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
