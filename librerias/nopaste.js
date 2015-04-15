var i=0; 
function denyPaste(obj){
i++;
if(obj.value.length>i){
obj.value='';i=0;
}
}