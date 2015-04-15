/**************************************************************
   
result.php by Milfson (milf@milfcz.com) 17.04.2004

Milfson added preselect(parameters...) to pre-populate dropdowns with default values.

Thanks for the code! - Brent.
 
***************************************************************/

// constants
var noValue = '-99';
// default values
var IDMake = noValue;
var IDModel = noValue;
var IDOptions = noValue;
//selects disabled true/false
var boolEnabled = true;

// globals
var curOption = new Array();
var isLoaded = new Array();

function initLists(){
  // initialize lists
  emptyList( 'lstMake' );
  emptyList( 'lstModel');
  emptyList( 'lstOptions' );
  jsrsExecute( 'select_rs.php', cbFillMake, 'makeList');
}

function preselect(idMake,idModel,idOptions,selectable){
  boolEnabled = selectable;
  IDMake = idMake;
  IDModel = idModel;
  IDOptions = idOptions;
  initLists();
}

function lstMake_onChange(){
  var val = this.options[this.selectedIndex].value;
    IDMake = val;
    IDModel = noValue;
    IDOptions = noValue;
  if(val == noValue){
    selectOption( this.name, curOption[this.name] )
  } else {
    curOption[this.name] = val;
    // init dependent lists
    emptyList( 'lstModel' );
    emptyList( 'lstOptions');
    window.status = 'Loading Model Selections...';
    jsrsExecute( 'select_rs.php', cbFillModel, 'modelList', val);
  }  
}

function lstModel_onChange(){

  var val = this.options[this.selectedIndex].value;
  if(val == noValue){
    selectOption( this.name, curOption[this.name] )
  } else {
    curOption[this.name] = val;
    emptyList( 'lstOptions');
    window.status = 'Loading Options Selections...';
    jsrsExecute( 'select_rs.php', cbFillOptions, 'optionsList', val);
  }  
}

function lstOptions_onChange(){
  var val = this.options[this.selectedIndex].value;
  IDOptions = val;
  if(val == noValue){
    selectOption( this.name, curOption[this.name] )
  } else {
    var msg = "You have selected: \n\n";
    msg += this.form.lstMake.options[this.form.lstMake.selectedIndex].text + "\n";
    msg += this.form.lstModel.options[this.form.lstModel.selectedIndex].text + "\n";
    msg += this.options[this.selectedIndex].text + "\n";
    //alert (msg);
    
    if(boolEnabled){
    document.getElementById('cmdSubmit').disabled="";
    document.getElementById('show').style.backgroundColor="#FFCC99";
    }
    
  }
}

function cbFillMake ( strMakes ){ 
  window.status = '';
  fillList( 'lstMake',  strMakes ); 
  if(IDMake != noValue){
    jsrsExecute( 'select_rs.php', cbFillModel, 'modelList', ''+IDMake+'');
  }
}

function cbFillModel ( strModels ){ 
  // callback for dependent listbox
  window.status = '';
  fillList( 'lstModel',  strModels ); 
  if(IDModel != noValue){
    jsrsExecute( 'select_rs.php', cbFillOptions, 'optionsList', ''+IDModel+'');
  }
}

function cbFillOptions( strOptions ){ 
  // callback for dependent listbox
  window.status = '';
  fillList( 'lstOptions', strOptions ); 
}

function fillList( listName, strOptions ){
  // fill any list with options
  emptyList( listName );
  
  // always insert selection prompt
  var lst = document.forms['QForm'][listName];
  lst.disabled = true;
  lst.options[0] = new Option('=>  Please Select  <=', noValue);
  
  // options in form "value~displaytext|value~displaytext|..."
  var aOptionPairs = strOptions.split('|');
  for( var i = 0; i < aOptionPairs.length; i++ ){
    if (aOptionPairs[i].indexOf('~') != -1) {
      var aOptions = aOptionPairs[i].split('~');
      lst.options[i + 1] = new Option(aOptions[1], aOptions[0]);
    }  
  }
  switch(listName){
  	case 'lstMake':
		  ID = IDMake;
		break;
  	case 'lstModel':
		  ID = IDModel;
		break;
	case 'lstOptions':
		  ID = IDOptions;
		break;
	}
  // init to no value
  selectOption( listName, ID );
  isLoaded[listName] = true;
  lst.disabled = !boolEnabled;
  lst.onchange = eval( listName + "_onChange" );
  // eval( "document.forms['QForm']['" + listName + "'].onchange=" + listName + "_onChange;" );
}

function emptyList( listName ){
  var lst = document.forms['QForm'][listName];
  lst.options.length = 0;
  lst.onchange = null;
  lst.disabled = !boolEnabled;
  isLoaded[listName] = false;
  curOption[listName] = noValue;
}

function selectOption( listName, optionVal ){
  // set list selection to option based on value
  var lst = document.forms['QForm'][listName];
  for( var i = 0; i< lst.options.length; i++ ){
    if( lst.options[i].value == optionVal ){
      lst.selectedIndex = i;
      curOption[listName] = optionVal;
      return;
    }  
  }
}


